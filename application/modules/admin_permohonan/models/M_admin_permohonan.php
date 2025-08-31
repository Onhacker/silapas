<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_permohonan extends CI_Model {
	private $table = 'booking_tamu';

    // Kolom untuk pencarian global DataTables
	private $column_search = [
		'bt.kode_booking','bt.nama_tamu','u.nama_unit',
		'bt.status','bt.jabatan','bt.target_instansi_nama',
		  'bt.nama_petugas_instansi' // <-- tambahkan ini
		];


    public function __construct(){
        parent::__construct();
    }

    public function arr_units()
    {
        $res = $this->db->order_by('nama_unit','asc')->get('unit_tujuan')->result();
        $arr = ['' => '== Semua Unit Tujuan =='];
        foreach($res as $r){
            $arr[$r->id] = $r->nama_unit;
        }
        return $arr;
    }

    private function _base_query($filters=[])
    {
        // Ambil keduanya:
// - bt.target_instansi_nama (di form) -> alias 'asal'
// - u.nama_unit (dari unit_tujuan)     -> alias 'unit_tujuan_nama'
		$this->db->select("bt.*, u.nama_unit AS unit_tujuan_nama, bt.target_instansi_nama AS asal");

        $this->db->from($this->table.' bt');
        $this->db->join('unit_tujuan u','u.id = bt.target_instansi_id','left');

        // Hak akses: user hanya instansinya sendiri
        $level = $this->session->userdata('admin_level');
        $user_unit_id = $this->session->userdata('id_unit'); // pastikan session ini ada saat login user

        if ($level !== 'admin' && !empty($user_unit_id)) {
            $this->db->where('bt.target_instansi_id', $user_unit_id);
        }

        $mulai   = $filters['tanggal_mulai']   ?? '';
$selesai = $filters['tanggal_selesai'] ?? '';

if ($mulai && !$selesai)  $selesai = $mulai;
if ($selesai && !$mulai)  $mulai   = $selesai;

if ($mulai && $selesai) {
    $this->db->where('bt.tanggal >=', $mulai);
    $this->db->where('bt.tanggal <=', $selesai);
}


        // Filter unit tujuan (opsional)
        if (!empty($filters['unit_tujuan'])) {
            $this->db->where('bt.target_instansi_id', $filters['unit_tujuan']);
        }

        // Filter status (opsional)
        if (isset($filters['status']) && $filters['status'] !== '') {
            $this->db->where('bt.status', $filters['status']);
        }

        // Filter "form_asal" → cari di nama_tamu & u.nama_unit
        if (!empty($filters['form_asal'])) {
		    $this->db->group_start();
		    $this->db->like('bt.nama_tamu', $filters['form_asal']);
		    $this->db->or_like('bt.target_instansi_nama', $filters['form_asal']); // Asal (form)
		    $this->db->or_like('u.nama_unit', $filters['form_asal']);             // Unit tujuan (opsional)
		    $this->db->group_end();
		}

    }

    private function _datatable_query($post)
    {
        $this->_base_query($post);

        // Pencarian global DataTables
        if (!empty($post['search']['value'])) {
            $sv = $post['search']['value'];
            $this->db->group_start();
            foreach ($this->column_search as $col) {
                $this->db->or_like($col, $sv);
            }
            $this->db->group_end();
        }

        // Urutan default
        if (isset($post['order'])) {
            // contoh: urutkan berdasarkan tanggal desc jika user klik
            // kolom2 client-side, kita default fallback ke tanggal desc
        } else {
            $this->db->order_by('bt.tanggal','DESC');
            $this->db->order_by('bt.jam','DESC');
        }
    }

    public function get_datatables($post)
    {
        $this->_datatable_query($post);

        if (isset($post['length']) && $post['length'] != -1) {
            $this->db->limit($post['length'], $post['start'] ?? 0);
        }
        return $this->db->get()->result();
    }

    public function count_filtered($post)
    {
        $this->_datatable_query($post);
        return $this->db->count_all_results();
    }

    public function count_all($post)
    {
        $this->_base_query($post);
        return $this->db->count_all_results();
    }

    // Untuk export PDF (tanpa pagination)
    public function get_for_export($filters=[])
    {
        $this->_base_query($filters);
        $this->db->order_by('bt.tanggal','DESC');
        $this->db->order_by('bt.jam','DESC');
        return $this->db->get()->result();
    }
	public function get_detail_by_kode($kode_booking)
{
    // Ambil semua kolom booking_tamu + info unit_tujuan
    return $this->db
        ->select('bt.*, u.nama_unit AS unit_tujuan_nama, u.nama_pejabat AS pejabat_unit')
        ->from('booking_tamu bt')
        ->join('unit_tujuan u', 'u.id = bt.target_instansi_id', 'left')
        ->where('bt.kode_booking', $kode_booking)
        ->limit(1)
        ->get()
        ->row();
}


}
