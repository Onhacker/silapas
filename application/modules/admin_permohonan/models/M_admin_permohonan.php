<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_permohonan extends CI_Model {
    private $table = 'booking_tamu';

    // Kolom untuk pencarian global DataTables
    private $column_search = [
        'bt.kode_booking',
        'bt.nama_tamu',
        'u.nama_unit',
        'bt.status',
        'bt.jabatan',
        'bt.target_instansi_nama',
        'bt.instansi',
        'bt.nama_petugas_instansi',
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
        // asal = prefer target_instansi_nama; fallback ke field instansi (string bebas dari form lama)
        $this->db->select("
            bt.*,
            u.nama_unit AS unit_tujuan_nama,
            COALESCE(NULLIF(bt.target_instansi_nama,''), NULLIF(bt.instansi,'')) AS asal
        ", false);

        $this->db->from($this->table.' bt');
        // FIX: join ke unit_tujuan berdasarkan kolom tujuan internal
        $this->db->join('unit_tujuan u','u.id = bt.unit_tujuan','left');

        // Hak akses sederhana: user non-admin hanya bisa lihat unit miliknya
        $level        = $this->session->userdata('admin_level');
        $user_unit_id = (int)$this->session->userdata('id_unit');
        if ($level !== 'admin' && !empty($user_unit_id)) {
            $this->db->where('bt.unit_tujuan', $user_unit_id);
        }

        // Filter rentang tanggal (berdasarkan kolom tanggal booking)
        $mulai   = $filters['tanggal_mulai']   ?? '';
        $selesai = $filters['tanggal_selesai'] ?? '';
        if ($mulai && !$selesai)  $selesai = $mulai;
        if ($selesai && !$mulai)  $mulai   = $selesai;
        if ($mulai && $selesai) {
            $this->db->where('bt.tanggal >=', $mulai);
            $this->db->where('bt.tanggal <=', $selesai);
        }

        // Filter unit tujuan (drop-down)
        if (!empty($filters['unit_tujuan'])) {
            $this->db->where('bt.unit_tujuan', (int)$filters['unit_tujuan']);
        }

        // Filter status
        if (isset($filters['status']) && $filters['status'] !== '') {
            $this->db->where('bt.status', $filters['status']);
        }

        // Filter teks "form_asal": cari di nama tamu, asal instansi, dan nama unit tujuan
        if (!empty($filters['form_asal'])) {
            $q = $filters['form_asal'];
            $this->db->group_start();
                $this->db->like('bt.nama_tamu', $q);
                $this->db->or_like('bt.target_instansi_nama', $q);
                $this->db->or_like('bt.instansi', $q);
                $this->db->or_like('u.nama_unit', $q);
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

        // Urutan default (terbaru di atas)
        if (empty($post['order'])) {
            $this->db->order_by('bt.tanggal','DESC');
            $this->db->order_by('bt.jam','DESC');
        }
    }

    public function get_datatables($post)
    {
        $this->_datatable_query($post);
        if (isset($post['length']) && $post['length'] != -1) {
            $this->db->limit((int)$post['length'], (int)($post['start'] ?? 0));
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

        return $this->db
            ->select('bt.*, u.nama_unit AS unit_tujuan_nama, u.nama_pejabat AS pejabat_unit', false)
            ->from('booking_tamu bt')
            // FIX: join ke unit tujuan
            ->join('unit_tujuan u', 'u.id = bt.unit_tujuan', 'left')
            ->where('bt.kode_booking', $kode_booking)
            ->limit(1)
            ->get()
            ->row();
    }

    public function get_pendamping_by_kode($kode_booking)
{
    return $this->db
        ->order_by('id_pendamping', 'ASC')
        ->get_where('booking_pendamping', ['kode_booking' => $kode_booking])
        ->result();
}

}
