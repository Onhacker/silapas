<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_instansi_ref extends Admin_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_admin_instansi_ref','dm');
        $this->load->driver('cache', ['adapter' => 'file']); // untuk invalidasi cache
        cek_session_akses(get_class($this), $this->session->userdata('admin_session'));
    }

    public function index(){
        $data["controller"] = get_class($this);
        $data["title"]      = "Master Ref. Instansi Sulsel";
        $data["subtitle"]   = $this->om->engine_nama_menu(get_class($this));
        $data["content"]    = $this->load->view($data["controller"]."_view",$data,true);
        $this->render($data);
    }

    /** DataTables server-side */
    public function get_data()
    {
        $jenis = $this->input->post('jenis', true);
        if (!$this->_is_supported($jenis)) {
            return $this->_json_dt([], 0, 0);
        }

        $list = $this->dm->get_data($jenis);
        $data = [];
        foreach ($list as $r) {
            $row = [];

            $pk  = $this->dm->pk($jenis);
            $idv = (int)$r->{$pk};

            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single">
                <input type="checkbox" class="data-check" value="'.$idv.'"><label></label></div>';
            $row['no']  = ''; // diisi di rowCallback

            // kolom dinamis (tampil rapih + aman)
            foreach ($this->dm->list_columns_view($jenis) as $col) {
                $val = isset($r->{$col}) ? $r->{$col} : '';
                if ($col === 'aktif') {
                    $row[$col] = ((int)$val === 1)
                        ? '<span class="badge badge-success">Aktif</span>'
                        : '<span class="badge badge-secondary">Nonaktif</span>';
                } else {
                    $row[$col] = htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
                }
            }

            $row['aksi'] = '<button type="button" class="btn btn-sm btn-warning" onclick="edit(\''.$jenis.'\','.$idv.')"><i class="fe-edit"></i></button>';

            $data[] = $row;
        }

        $out = [
            "draw"            => (int)$this->input->post('draw'),
            "recordsTotal"    => $this->dm->count_all($jenis),
            "recordsFiltered" => $this->dm->count_filtered($jenis),
            "data"            => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }

    /** Ambil satu baris untuk form edit */
    public function get_one($jenis, $id)
    {
        if (!$this->_is_supported($jenis)) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Jenis tidak dikenal"]); return;
        }
        $id  = (int)$id;
        $row = $this->dm->get_one($jenis, $id);
        if (!$row) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data tidak ditemukan"]);
            return;
        }
        echo json_encode(["success"=>true,"data"=>$row]);
    }

    /** Create */
    public function add()
    {
        $jenis = $this->input->post('jenis', true);
        if (!$this->_is_supported($jenis)) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Jenis tidak dikenal"]); return;
        }

        $this->_validate($jenis, false);
        $in = $this->_collect($jenis);

        $this->db->trans_begin();
        $ok = $this->db->insert($this->dm->table($jenis), $in);
        $ok ? $this->db->trans_commit() : $this->db->trans_rollback();

        if ($ok) { $this->_invalidate_opts_cache($jenis); }

        echo json_encode([
            "success" => (bool)$ok,
            "title"   => $ok ? "Berhasil" : "Gagal",
            "pesan"   => $ok ? "Data berhasil disimpan" : "Data gagal disimpan"
        ]);
    }

    /** Update */
    public function update()
    {
        $jenis = $this->input->post('jenis', true);
        if (!$this->_is_supported($jenis)) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Jenis tidak dikenal"]); return;
        }
        $pk = $this->dm->pk($jenis);

        $this->_validate($jenis, true);
        $id = (int)$this->input->post($pk, true);
        if ($id <= 0) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"ID tidak valid"]); return;
        }
        $in = $this->_collect($jenis);

        $this->db->trans_begin();
        $ok = $this->db->where($pk, $id)->update($this->dm->table($jenis), $in);
        $ok ? $this->db->trans_commit() : $this->db->trans_rollback();

        if ($ok) { $this->_invalidate_opts_cache($jenis); }

        echo json_encode([
            "success" => (bool)$ok,
            "title"   => $ok ? "Berhasil" : "Gagal",
            "pesan"   => $ok ? "Data berhasil diupdate" : "Data gagal diupdate"
        ]);
    }

    /** Delete (bulk) */
    public function hapus_data()
    {
        $jenis = $this->input->post('jenis', true);
        $ids   = (array)$this->input->post('id');
        if (!$this->_is_supported($jenis)) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Jenis tidak dikenal"]); return;
        }
        if (!$ids) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Tidak ada data dipilih"]); return;
        }
        $pk  = $this->dm->pk($jenis);

        $this->db->trans_begin();
        $this->db->where_in($pk, array_map('intval',$ids))->delete($this->dm->table($jenis));
        $ok = ($this->db->affected_rows() > 0);
        $ok ? $this->db->trans_commit() : $this->db->trans_rollback();

        if ($ok) { $this->_invalidate_opts_cache($jenis); }

        echo json_encode([
            "success"=>$ok,
            "title"=>$ok?"Berhasil":"Gagal",
            "pesan"=>$ok?"Data berhasil dihapus":"Tidak ada data dihapus"
        ]);
    }

    /** Select2: daftar Kejari (untuk Cabjari) */
    public function opsi_kejari()
    {
        $q = trim((string)$this->input->get('q', true));
        $rows = $this->dm->opsi_kejari($q);
        $out = [];
        foreach($rows as $r){
            $out[] = ["id"=>$r->id_kejari, "text"=>"[#{$r->id_kejari}] ".$r->nama_kejari." – ".$r->kabkota];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }

    /* ================== Private Helpers ================== */

    private function _is_supported($jenis){
        return in_array($jenis, array_keys($this->dm->map()), true);
    }

    private function _invalidate_opts_cache($jenis){
        $this->cache->delete('opts_kat:'.$jenis);
    }

    private function _validate($jenis, $is_update)
    {
        $this->load->library('form_validation');
        $cfg = $this->dm->map()[$jenis];

        if ($is_update) {
            $this->form_validation->set_rules($this->dm->pk($jenis), 'ID', 'required|integer');
        }

        // Aturan per field
        foreach ($cfg['rules'] as $field => $rule) {
            $label = $cfg['labels'][$field] ?? ucfirst($field);
            $this->form_validation->set_rules($field, $label, $rule);
        }

        // Pesan baku
        $this->form_validation->set_message('required','* %s harus diisi');
        $this->form_validation->set_message('integer','* %s harus berupa angka bulat');
        $this->form_validation->set_message('in_list','* %s tidak valid');
        $this->form_validation->set_error_delimiters('<br> ',' ');

        if ($this->form_validation->run() !== TRUE) {
            echo json_encode([
                "success" => false,
                "title"   => "Validasi Gagal",
                "pesan"   => validation_errors()
            ]);
            exit;
        }
    }

    private function _collect($jenis)
    {
        // Normalisasi input & default
        $data = [];
        foreach ($this->dm->fillable($jenis) as $f) {
            $val = $this->input->post($f, true);
            $data[$f] = ($val === '') ? null : $val;
        }

        // Khusus tipe/konversi
        switch ($jenis) {
            case 'kodim':
                if (isset($data['nomor_kodim'])) $data['nomor_kodim'] = (int)$data['nomor_kodim'];
                break;
            case 'bnn':
                // tingkat enum
                if (isset($data['tingkat']) && !in_array($data['tingkat'], ['Kabupaten','Kota'], true)) {
                    $data['tingkat'] = 'Kabupaten';
                }
                if (!isset($data['singkatan']) || $data['singkatan']==='') $data['singkatan'] = 'BNNK';
                if (!isset($data['provinsi'])  || $data['provinsi']==='')  $data['provinsi']  = 'Sulawesi Selatan';
                break;
            case 'pn':
            case 'pa':
            case 'ptun':
            case 'kejari':
            case 'kejati':
                if (!isset($data['provinsi']) || $data['provinsi']==='') $data['provinsi']  = 'Sulawesi Selatan';
                break;
            case 'opd':
                // no special
                break;
            case 'cabjari':
                if (isset($data['id_kejari'])) $data['id_kejari'] = (int)$data['id_kejari'];
                if (!isset($data['provinsi']) || $data['provinsi']==='') $data['provinsi']  = 'Sulawesi Selatan';
                break;
        }

        // Checkbox aktif → 0/1
        if (array_key_exists('aktif',$data)) {
            $data['aktif'] = (int)($this->input->post('aktif') !== null);
        }

        return $data;
    }

    private function _json_dt($data,$total,$filtered){
        $out = [
            "draw"            => (int)$this->input->post('draw'),
            "recordsTotal"    => $total,
            "recordsFiltered" => $filtered,
            "data"            => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }
}
