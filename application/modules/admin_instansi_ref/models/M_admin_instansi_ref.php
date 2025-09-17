<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_instansi_ref extends CI_Model {

    public function __construct(){ parent::__construct(); }

    /* ====== Konfigurasi per jenis ======
       - table: nama tabel
       - pk   : primary key
       - view_cols: kolom yang ditampilkan di DataTables (urutan render)
       - fillable : kolom yang dapat diisi via form
       - labels   : label form
       - rules    : aturan validasi CI3
    */
    public function map()
    {
        return [
            'opd' => [
                'table'     => 'opd_sulsel',
                'pk'        => 'id_opd',
                'view_cols' => ['nama_opd','jenis','induk','singkatan','aktif'],
                'fillable'  => ['nama_opd','jenis','induk','singkatan','aktif'],
                'labels'    => [
                    'nama_opd'=>'Nama OPD','jenis'=>'Jenis','induk'=>'Induk','singkatan'=>'Singkatan','aktif'=>'Aktif'
                ],
                'rules'     => [
                    'nama_opd'=>'trim|required|max_length[255]',
                    'jenis'    =>'trim|required|in_list[OPD Provinsi,Instansi Vertikal]',
                    'induk'    =>'trim|max_length[255]',
                    'singkatan'=>'trim|max_length[100]',
                    'aktif'    =>''
                ],
                'search'    => ['nama_opd','jenis','induk','singkatan']
            ],
            'pn' => [
                'table'=>'pengadilan_negeri_sulsel','pk'=>'id_pn',
                'view_cols'=>['nama_pn','kabkota','provinsi','aktif'],
                'fillable'=>['nama_pn','kabkota','provinsi','aktif'],
                'labels'=>['nama_pn'=>'Nama PN','kabkota'=>'Kab/Kota','provinsi'=>'Provinsi','aktif'=>'Aktif'],
                'rules'=>[
                    'nama_pn'=>'trim|required|max_length[255]',
                    'kabkota'=>'trim|required|max_length[120]',
                    'provinsi'=>'trim|required|max_length[120]',
                    'aktif'=>''
                ],
                'search'=>['nama_pn','kabkota','provinsi']
            ],
            'pa' => [
                'table'=>'pengadilan_agama_sulsel','pk'=>'id_pa',
                'view_cols'=>['nama_pa','kabkota','provinsi','aktif'],
                'fillable'=>['nama_pa','kabkota','provinsi','aktif'],
                'labels'=>['nama_pa'=>'Nama PA','kabkota'=>'Kab/Kota','provinsi'=>'Provinsi','aktif'=>'Aktif'],
                'rules'=>[
                    'nama_pa'=>'trim|required|max_length[255]',
                    'kabkota'=>'trim|required|max_length[120]',
                    'provinsi'=>'trim|required|max_length[120]',
                    'aktif'=>''
                ],
                'search'=>['nama_pa','kabkota','provinsi']
            ],
            'ptun' => [
                'table'=>'pengadilan_tun_sulsel','pk'=>'id_ptun',
                'view_cols'=>['nama_ptun','kabkota','provinsi','aktif'],
                'fillable'=>['nama_ptun','kabkota','provinsi','aktif'],
                'labels'=>['nama_ptun'=>'Nama PTUN','kabkota'=>'Kab/Kota','provinsi'=>'Provinsi','aktif'=>'Aktif'],
                'rules'=>[
                    'nama_ptun'=>'trim|required|max_length[255]',
                    'kabkota'=>'trim|required|max_length[120]',
                    'provinsi'=>'trim|required|max_length[120]',
                    'aktif'=>''
                ],
                'search'=>['nama_ptun','kabkota','provinsi']
            ],
            'kejari' => [
                'table'=>'kejaksaan_negeri_sulsel','pk'=>'id_kejari',
                'view_cols'=>['nama_kejari','kabkota','provinsi','aktif'],
                'fillable'=>['nama_kejari','kabkota','provinsi','aktif'],
                'labels'=>['nama_kejari'=>'Nama Kejari','kabkota'=>'Kab/Kota','provinsi'=>'Provinsi','aktif'=>'Aktif'],
                'rules'=>[
                    'nama_kejari'=>'trim|required|max_length[255]',
                    'kabkota'=>'trim|required|max_length[120]',
                    'provinsi'=>'trim|required|max_length[120]',
                    'aktif'=>''
                ],
                'search'=>['nama_kejari','kabkota','provinsi']
            ],
            'cabjari' => [
                'table'=>'kejari_cabang_sulsel','pk'=>'id_cabjari',
                'view_cols'=>['id_kejari','nama_cabang','lokasi','kabkota','provinsi','aktif'],
                'fillable'=>['id_kejari','nama_cabang','lokasi','kabkota','provinsi','aktif'],
                'labels'=>[
                    'id_kejari'=>'Kejari Induk','nama_cabang'=>'Nama Cabang','lokasi'=>'Lokasi',
                    'kabkota'=>'Kab/Kota','provinsi'=>'Provinsi','aktif'=>'Aktif'
                ],
                'rules'=>[
                    'id_kejari'=>'required|integer',
                    'nama_cabang'=>'trim|required|max_length[255]',
                    'lokasi'=>'trim|required|max_length[150]',
                    'kabkota'=>'trim|required|max_length[120]',
                    'provinsi'=>'trim|required|max_length[120]',
                    'aktif'=>''
                ],
                'search'=>['nama_cabang','lokasi','kabkota','provinsi']
            ],
            'bnn' => [
                'table'=>'bnn_sulsel','pk'=>'id_bnn',
                'view_cols'=>['nama_unit','tingkat','kabkota','provinsi','singkatan','aktif'],
                'fillable'=>['nama_unit','tingkat','kabkota','provinsi','singkatan','aktif'],
                'labels'=>[
                    'nama_unit'=>'Nama Unit','tingkat'=>'Tingkat','kabkota'=>'Kab/Kota',
                    'provinsi'=>'Provinsi','singkatan'=>'Singkatan','aktif'=>'Aktif'
                ],
                'rules'=>[
                    'nama_unit'=>'trim|required|max_length[255]',
                    'tingkat'=>'trim|required|in_list[Kabupaten,Kota]',
                    'kabkota'=>'trim|required|max_length[100]',
                    'provinsi'=>'trim|required|max_length[100]',
                    'singkatan'=>'trim|max_length[20]',
                    'aktif'=>''
                ],
                'search'=>['nama_unit','tingkat','kabkota','provinsi','singkatan']
            ],
            'kodim' => [
                'table'=>'kodim_sulawesi','pk'=>'id_kodim',
                'view_cols'=>['nomor_kodim','label','wilayah','provinsi','aktif'],
                'fillable'=>['nomor_kodim','label','wilayah','provinsi','aktif'],
                'labels'=>[
                    'nomor_kodim'=>'Nomor Kodim','label'=>'Label','wilayah'=>'Wilayah','provinsi'=>'Provinsi','aktif'=>'Aktif'
                ],
                'rules'=>[
                    'nomor_kodim'=>'required|integer',
                    'label'=>'trim|required|max_length[255]',
                    'wilayah'=>'trim|required|max_length[150]',
                    'provinsi'=>'trim|required|max_length[120]',
                    'aktif'=>''
                ],
                'search'=>['nomor_kodim','label','wilayah','provinsi']
            ],
            'kejati' => [
                'table'=>'kejaksaan_tinggi_sulsel','pk'=>'id_kejati',
                'view_cols'=>['nama_kejati','provinsi','aktif'],
                'fillable'=>['nama_kejati','provinsi','aktif'],
                'labels'=>['nama_kejati'=>'Nama Kejati','provinsi'=>'Provinsi','aktif'=>'Aktif'],
                'rules'=>[
                    'nama_kejati'=>'trim|required|max_length[255]',
                    'provinsi'=>'trim|required|max_length[120]',
                    'aktif'=>''
                ],
                'search'=>['nama_kejati','provinsi']
            ],
        ];
    }

    public function table($jenis){ return $this->map()[$jenis]['table']; }
    public function pk($jenis){ return $this->map()[$jenis]['pk']; }
    public function list_columns_view($jenis){ return $this->map()[$jenis]['view_cols']; }
    public function fillable($jenis){ return $this->map()[$jenis]['fillable']; }

    /* ===== DataTables base query ===== */
    private function _base_q($jenis)
    {
        $cfg = $this->map()[$jenis];
        $this->db->from($cfg['table']);
    }

    private function _build_q($jenis)
    {
        $cfg = $this->map()[$jenis];
        $this->_base_q($jenis);

        // searching
        $search = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';
        if ($search !== '') {
            $this->db->group_start();
            foreach ($cfg['search'] as $i=>$col) {
                if ($i === 0) $this->db->like($col, $search);
                else          $this->db->or_like($col, $search);
            }
            $this->db->group_end();
        }

        // ordering
        if (isset($_POST['order'])) {
            $idx = (int)$_POST['order'][0]['column'];
            $dir = ($_POST['order'][0]['dir'] === 'desc') ? 'DESC' : 'ASC';
            // mapping index DT -> kolom view_cols (skip checkbox & nomor)
            $cols = array_values($cfg['view_cols']);
            $col  = $cols[$idx - 2] ?? $cfg['view_cols'][0]; // -2 karena kolom 0 cek, 1 nomor
            $this->db->order_by($col, $dir);
        } else {
            // default
            if ($jenis === 'kodim') {
                $this->db->order_by('nomor_kodim', 'ASC');
            } else {
                $first = $cfg['view_cols'][0];
                $this->db->order_by($first, 'ASC');
            }
        }
    }

    public function get_data($jenis)
    {
        $this->_build_q($jenis);

        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit((int)$_POST['length'], (int)$_POST['start']);
        }
        return $this->db->get()->result();
    }

    public function count_filtered($jenis)
    {
        $this->_build_q($jenis);
        return $this->db->get()->num_rows();
    }

    public function count_all($jenis)
    {
        $this->_base_q($jenis);
        return $this->db->count_all_results();
    }

    public function get_one($jenis, $id)
    {
        return $this->db->get_where($this->table($jenis), [$this->pk($jenis)=>(int)$id])->row();
    }

    /** Select2 Kejari untuk Cabjari */
    public function opsi_kejari($q='')
    {
        if ($q !== '') {
            $this->db->group_start()
                     ->like('nama_kejari', $q)
                     ->or_like('kabkota', $q)
                     ->group_end();
        }
        return $this->db->select('id_kejari, nama_kejari, kabkota')
                        ->from('kejaksaan_negeri_sulsel')
                        ->where('aktif', 1)
                        ->order_by('nama_kejari','ASC')
                        ->limit(50)
                        ->get()->result();
    }
}
