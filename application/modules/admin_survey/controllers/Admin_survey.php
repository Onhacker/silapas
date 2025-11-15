<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_survey extends Admin_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_admin_survey','dm');
        $this->load->helper(['url','text']);
        cek_session_akses(get_class($this), $this->session->userdata('admin_session'));
    }

    /** Purge cache publik (dipanggil setiap CRUD berhasil) */
    private function purge_public_caches()
    {
        $this->load->driver('cache', ['adapter' => 'file']);
        // Bump versi survey publik
        $this->cache->save('survey_ver', time(), 365*24*3600);
        $this->output->set_header('X-Cache-Purged: survey');
    }

    public function index(){
        $data["controller"] = get_class($this);
        $data["title"]      = "Master";
        $data["subtitle"]   = $this->om->engine_nama_menu(get_class($this));
        $data["content"]    = $this->load->view("admin_survey_view",$data,true);
        $this->render($data);
    }

    /** DataTables server-side */
    public function get_dataa()
    {
        $list = $this->dm->get_data();
        $data = [];
        foreach ($list as $r) {
            $row = [];
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single">'
                        . '<input type="checkbox" class="data-check" value="'.(int)$r->id.'"><label></label>'
                        . '</div>';
            $row['no']  = ''; // diisi rowCallback

            // bulan (langsung dari DB, ex: 2025-11)
            $row['bulan'] = htmlspecialchars($r->bulan, ENT_QUOTES, 'UTF-8');

            // link_survey jadi link yang bisa diklik
            $link_safe = htmlspecialchars($r->link_survey, ENT_QUOTES, 'UTF-8');
            $row['link_survey'] = '<a href="'.$link_safe.'" target="_blank" rel="noopener">'.$link_safe.'</a>';

            $btnEdit = '<button type="button" class="btn btn-sm btn-warning" onclick="edit('.(int)$r->id.')">'
                     . '<i class="fe-edit"></i> Edit</button>';

            $row['aksi'] = $btnEdit;

            $data[] = $row;
        }

        $out = [
            "draw"            => (int)$this->input->post('draw'),
            "recordsTotal"    => $this->dm->count_all(),
            "recordsFiltered" => $this->dm->count_filtered(),
            "data"            => $data,
        ];
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($out));
    }

    /** Ambil satu baris untuk form edit */
    public function get_one($id)
    {
        $id  = (int)$id;
        $row = $this->db->get_where('survey',['id'=>$id])->row();
        if (!$row) {
            echo json_encode([
                "success"=>false,
                "title"=>"Gagal",
                "pesan"=>"Data tidak ditemukan"
            ]);
            return;
        }
        echo json_encode([
            "success"=>true,
            "data"=>$row
        ]);
    }

    /** Create */
    public function add()
    {
        $this->load->library('form_validation');
        // bulan format bebas, yang penting diisi (disarankan YYYY-MM dari input type="month")
        $this->form_validation->set_rules('bulan','Bulan','trim|required|max_length[10]');
        $this->form_validation->set_rules('link_survey','Link Survey','trim|required|max_length[500]');

        if ($this->form_validation->run() !== TRUE) {
            echo json_encode([
                "success"=>false,
                "title"=>"Validasi Gagal",
                "pesan"=>validation_errors()
            ]);
            return;
        }

        $bulan       = $this->input->post('bulan', true);       // ex: 2025-11
        $link_survey = $this->input->post('link_survey', true); // URL survey

        // Cek duplikat bulan
        $exists = $this->db->from('survey')->where('bulan',$bulan)->count_all_results();
        if ($exists > 0) {
            echo json_encode([
                "success"=>false,
                "title"=>"Gagal",
                "pesan"=>"Survey untuk bulan ini sudah ada."
            ]);
            return;
        }

        $ok = $this->db->insert('survey', [
            'bulan'       => $bulan,
            'link_survey' => $link_survey,
        ]);

        if ($ok) { $this->purge_public_caches(); }

        echo json_encode([
            "success"=>$ok,
            "title"=>$ok?"Berhasil":"Gagal",
            "pesan"=>$ok?"Data berhasil disimpan":"Data gagal disimpan"
        ]);
    }

    /** Update */
    public function update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id','ID','required|integer');
        $this->form_validation->set_rules('bulan','Bulan','trim|required|max_length[10]');
        $this->form_validation->set_rules('link_survey','Link Survey','trim|required|max_length[500]');

        if ($this->form_validation->run() !== TRUE) {
            echo json_encode([
                "success"=>false,
                "title"=>"Validasi Gagal",
                "pesan"=>validation_errors()
            ]);
            return;
        }

        $id          = (int)$this->input->post('id', true);
        $bulan       = $this->input->post('bulan', true);
        $link_survey = $this->input->post('link_survey', true);

        $row = $this->db->get_where('survey',['id'=>$id])->row();
        if (!$row) {
            echo json_encode([
                "success"=>false,
                "title"=>"Gagal",
                "pesan"=>"Data tidak ditemukan"
            ]);
            return;
        }

        // Cek duplikat bulan (exclude id sendiri)
        $exists = $this->db->from('survey')
                           ->where('bulan',$bulan)
                           ->where('id !=', $id)
                           ->count_all_results();
        if ($exists > 0) {
            echo json_encode([
                "success"=>false,
                "title"=>"Gagal",
                "pesan"=>"Survey untuk bulan ini sudah ada."
            ]);
            return;
        }

        $data_update = [
            'bulan'       => $bulan,
            'link_survey' => $link_survey,
        ];

        $ok = $this->db->where('id',$id)->update('survey', $data_update);

        if ($ok) { $this->purge_public_caches(); }

        echo json_encode([
            "success"=>$ok,
            "title"=>$ok?"Berhasil":"Gagal",
            "pesan"=>$ok?"Data berhasil diupdate":"Data gagal diupdate"
        ]);
    }

    /** Delete (bulk) */
    public function hapus_data()
    {
        $ids = $this->input->post('id');
        if (!is_array($ids) || count($ids) === 0) {
            echo json_encode([
                "success"=>false,
                "title"=>"Gagal",
                "pesan"=>"Tidak ada data"
            ]);
            return;
        }

        $ok = true;
        foreach ($ids as $id) {
            $id = (int)$id;
            if ($id <= 0) continue;
            $ok = $ok && $this->db->delete('survey', ['id'=>$id]);
        }

        if ($ok) { $this->purge_public_caches(); }

        echo json_encode([
            "success"=>$ok,
            "title"=>$ok?"Berhasil":"Gagal",
            "pesan"=>$ok?"Data berhasil dihapus":"Sebagian data gagal dihapus"
        ]);
    }
}
