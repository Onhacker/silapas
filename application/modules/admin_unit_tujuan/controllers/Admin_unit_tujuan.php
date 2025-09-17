<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_unit_tujuan extends Admin_Controller {
    public function __construct(){
        parent::__construct();
        cek_session_akses(get_class($this), $this->session->userdata('admin_session'));
        $this->load->model('M_admin_unit_tujuan','dm');

        // === untuk auto clear cache ===
        $this->load->driver('cache', ['adapter' => 'file']); // sesuaikan adapter bila perlu
    }

    public function index(){
        $data["controller"] = get_class($this);
        $data["title"]      = "Master";
        $data["subtitle"]   = "Unit Tujuan";
        $data["content"]    = $this->load->view(($data["controller"])."_view",$data,true);
        $this->render($data);
    }

    /* ===== DataTables ===== */
    public function get_data(){
        $list = $this->dm->get_data();
        $data = [];
        $no   = (int)($_POST['start'] ?? 0);

        foreach ($list as $r) {
            $no++;
            $row                 = [];
            $row['cek']          = '<div class="checkbox checkbox-primary checkbox-single"><input type="checkbox" class="data-check" value="'.$r->id.'"><label></label></div>';
            $row['id']           = $r->id;
            $row['nama_unit']    = '<strong>'.$r->nama_unit.'</strong>';
            $row['parent_nama']  = $r->parent_id ? ('[#'.$r->parent_id.'] '.$r->parent_nama) : '<span class="text-muted">— Root —</span>';
            $row['nama_pejabat'] = $r->nama_pejabat ?: '<span class="text-muted">-</span>';
            $row['no_hp']        = $r->no_hp ?: '<span class="text-muted">-</span>';
            $row['kuota']        = (int)$r->kuota_harian;
            $row['pendamping']   = is_null($r->jumlah_pendamping) ? '<span class="text-muted">∞</span>' : (int)$r->jumlah_pendamping;
            $row['updated']      = date('d-m-Y H:i', strtotime($r->updated_at));
            $data[] = $row;
        }

        $output = [
            "draw"            => (int)($_POST['draw'] ?? 0),
            "recordsTotal"    => $this->dm->count_all(),
            "recordsFiltered" => $this->dm->count_filtered(),
            "data"            => $data,
        ];
        echo json_encode($output);
    }

    public function edit($id){
        $res = $this->dm->get_by_id((int)$id);
        echo json_encode($res ?: []);
    }

    /* ===== Create ===== */
    public function add(){
        $this->_validate();
        $in = $this->_collect();

        $this->db->trans_begin();
        $this->db->insert('unit_tujuan', $in);
        $ok = $this->db->trans_status();
        $ok ? $this->db->trans_commit() : $this->db->trans_rollback();

        // === auto clear cache saat sukses ===
        if ($ok) { $this->_invalidate_unit_tree_cache(); }

        echo json_encode([
            "success" => $ok,
            "title"   => $ok ? "Berhasil" : "Gagal",
            "pesan"   => $ok ? "Data berhasil disimpan" : "Data gagal disimpan"
        ]);
    }

    /* ===== Update ===== */
    public function update(){
        $this->_validate(true);
        $id = (int)$this->input->post('id', true);
        if ($id <= 0) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"ID tidak valid"]); return;
        }
        $in = $this->_collect();

        // cegah parent mengacu ke dirinya sendiri
        if (!empty($in['parent_id']) && (int)$in['parent_id'] === $id) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Parent tidak boleh diri sendiri."]); return;
        }

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('unit_tujuan', $in);
        $ok = $this->db->trans_status();
        $ok ? $this->db->trans_commit() : $this->db->trans_rollback();

        // === auto clear cache saat sukses ===
        if ($ok) { $this->_invalidate_unit_tree_cache(); }

        echo json_encode([
            "success" => $ok,
            "title"   => $ok ? "Berhasil" : "Gagal",
            "pesan"   => $ok ? "Data berhasil diupdate" : "Data gagal diupdate"
        ]);
    }

    /* ===== Delete (cek anak) ===== */
    public function hapus_data(){
        $ids = (array)$this->input->post('id');
        if (!$ids) { echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Tidak ada data dipilih"]); return; }

        // Tolak jika punya child
        foreach ($ids as $id) {
            $cnt = $this->db->where('parent_id',(int)$id)->count_all_results('unit_tujuan');
            if ($cnt > 0) {
                echo json_encode([
                    "success"=>false,
                    "title"=>"Gagal",
                    "pesan"=>"ID #$id memiliki anak ($cnt). Hapus/ubah anak terlebih dahulu."
                ]);
                return;
            }
        }

        $this->db->where_in('id',$ids)->delete('unit_tujuan');
        $ok = $this->db->affected_rows() > 0;

        // === auto clear cache saat sukses ===
        if ($ok) { $this->_invalidate_unit_tree_cache(); }

        echo json_encode([
            "success"=>$ok,
            "title"=>$ok?"Berhasil":"Gagal",
            "pesan"=>$ok?"Data dihapus":"Tidak ada data dihapus"
        ]);
    }

    /* ===== Helpers ===== */
    private function _validate($is_update = false){
        $this->load->library('form_validation');

        if ($is_update) {
            $this->form_validation->set_rules('id', 'ID', 'required|integer');
        }

        // Wajib
        $this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required|max_length[150]');
        $this->form_validation->set_rules('kuota_harian', 'Kuota Harian', 'required|is_natural'); 
        // is_natural = 0 atau lebih (>=0) di CI3

        // Opsional: kalau diisi baru divalidasi
        $nama_pejabat = $this->input->post('nama_pejabat', true);
        if ($nama_pejabat !== null && $nama_pejabat !== '') {
            $this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'max_length[150]');
        }

        $no_hp = $this->input->post('no_hp', true);
        if ($no_hp !== null && $no_hp !== '') {
            $this->form_validation->set_rules('no_hp', 'No HP', 'max_length[20]');
        }

        $parent_id = $this->input->post('parent_id', true);
        if ($parent_id !== null && $parent_id !== '') {
            $this->form_validation->set_rules('parent_id', 'Parent', 'integer');
        }

        $jumlah_pendamping = $this->input->post('jumlah_pendamping', true);
        if ($jumlah_pendamping !== null && $jumlah_pendamping !== '') {
            $this->form_validation->set_rules('jumlah_pendamping', 'Jumlah Pendamping', 'is_natural'); // >= 0
        }

        // Pesan
        $this->form_validation->set_message('required', '* %s harus diisi');
        $this->form_validation->set_message('integer', '* %s harus berupa angka bulat');
        $this->form_validation->set_message('is_natural', '* %s minimal 0');
        $this->form_validation->set_error_delimiters('<br> ', ' ');

        if ($this->form_validation->run() !== TRUE) {
            echo json_encode([
                "success" => false,
                "title"   => "Validasi Gagal",
                "pesan"   => validation_errors()
            ]);
            exit;
        }
    }

    private function _collect(){
        $nama_unit   = trim((string)$this->input->post('nama_unit', true));
        $nama_pej    = trim((string)$this->input->post('nama_pejabat', true));
        $no_hp       = trim((string)$this->input->post('no_hp', true));
        $kuota       = (int)$this->input->post('kuota_harian', true);
        $parent_id   = $this->input->post('parent_id', true);
        $pendamping  = $this->input->post('jumlah_pendamping', true);

        // normalisasi no hp (gunakan helpermu jika ada)
        if (method_exists($this, '_normalize_msisdn_id')) {
            $no_hp = $this->_normalize_msisdn_id($no_hp);
        } else {
            $digits = preg_replace('/\D+/', '', $no_hp);
            if ($digits !== '' && $digits[0] === '0') $digits = '0'.substr($digits,1);
            $no_hp = $digits ?: null;
        }

        return [
            'nama_unit'         => $nama_unit,
            'nama_pejabat'      => ($nama_pej!=='' ? $nama_pej : null),
            'no_hp'             => ($no_hp!=='' ? $no_hp : null),
            'kuota_harian'      => $kuota,
            'parent_id'         => ($parent_id === '' ? null : (int)$parent_id),
            'jumlah_pendamping' => ($pendamping === '' ? null : (int)$pendamping),
        ];
    }

    /* dipakai Select2 parent (optional) */
    public function parent_options(){
        $q = $this->input->get('q', true);
        $rows = $this->dm->search_parent($q);
        $out = [];
        $out[] = ["id"=>"","text"=>"— Root (tanpa parent) —"];
        foreach($rows as $r){
            $out[] = ["id"=>$r->id, "text"=>"[#{$r->id}] ".$r->nama_unit];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }

    /* ===== Cache invalidation helper ===== */
    private function _invalidate_unit_tree_cache(){
        // Ubah daftar key jika Anda memakai nama lain/prefix berbeda
        $keys = ['unit_tree'];
        foreach($keys as $k){
            $this->cache->delete($k);
        }
        // Jika di sisi pembaca cacheKey menyertakan versi/timestamp yang berubah-ubah,
        // pertimbangkan invalidasi global: $this->cache->clean(); (hati-hati: bersihkan semua cache)
    }
}
