<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_setting_web extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
	}

	function index(){
		
		$data["controller"] = get_class($this);
		$data["record"] = $this->om->edit('identitas', array('id_identitas' => 1))->row();
		$data["title"] = "Pengaturan Web";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	public function update()
{
    $post = $this->input->post(NULL, TRUE);
    $this->load->library('form_validation');

    // ===== RULES =====
    $this->form_validation->set_rules('nama_website','Nama Website','trim|required');
    $this->form_validation->set_rules('email','Email','trim|required|valid_email');
    $this->form_validation->set_rules('url','URL Aplikasi','trim|required|valid_url');
    // no_telp: 10–15 digit, boleh diawali +
    $this->form_validation->set_rules('no_telp','No. HP/WhatsApp','trim|required|regex_match[/^\+?\d{10,15}$/]');
    // waktu: batasi ke tiga zona waktu Indonesia
    $this->form_validation->set_rules('waktu','Zona Waktu','trim|required|in_list[Asia/Jakarta,Asia/Makassar,Asia/Jayapura]');
    // min_lead_minutes: 0–1440
    $this->form_validation->set_rules('min_lead_minutes','Minimal Jeda Booking (menit)','trim|integer|greater_than_equal_to[0]|less_than_equal_to[1440]');

    $this->form_validation->set_message('required', '* %s Harus diisi');
    $this->form_validation->set_message('valid_email', '* %s Tidak valid');
    $this->form_validation->set_message('valid_url', '* %s Tidak valid (awali dengan http:// atau https://)');
    $this->form_validation->set_message('regex_match', '* %s tidak valid (boleh + di depan, 10–15 digit)');
    $this->form_validation->set_message('in_list', '* %s tidak valid');
    $this->form_validation->set_message('integer', '* %s harus angka bulat');
    $this->form_validation->set_message('greater_than_equal_to', '* %s minimal %s');
    $this->form_validation->set_message('less_than_equal_to', '* %s maksimal %s');
    $this->form_validation->set_error_delimiters('<br> ',' ');

    if ($this->form_validation->run() === FALSE) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
        return;
    }

    // ===== NORMALISASI NILAI =====
    $url = trim($post['url'] ?? '');
    // pastikan punya skema, valid_url sudah menjamin ini, tapi jaga-jaga
    if ($url !== '' && !preg_match('~^https?://~i',$url)) {
        $url = 'http://'.$url;
    }
    // opsional: pastikan trailing slash
    if ($url !== '' && substr($url, -1) !== '/') {
        $url .= '/';
    }

    $no_telp = preg_replace('/\s+/', '', (string)($post['no_telp'] ?? ''));
    $minLead = isset($post['min_lead_minutes']) ? (int)$post['min_lead_minutes'] : null;
    if ($minLead !== null) {
        if ($minLead < 0)   $minLead = 0;
        if ($minLead > 1440)$minLead = 1440;
    }

    // ===== SIAPKAN DATA UPDATE (HANYA KOLOM YANG ADA DI TABEL) =====
    $row = [
        'nama_website'    => $post['nama_website'] ?? '',
        'email'           => $post['email'] ?? '',
        'url'             => $url,
        'provinsi'        => $post['provinsi'] ?? '',
        'kabupaten'       => $post['kabupaten'] ?? '',
        'alamat'          => $post['alamat'] ?? '',
        'no_telp'         => $no_telp,
        'telp'            => $post['telp'] ?? '',
        'meta_deskripsi'  => $post['meta_deskripsi'] ?? '',
        'meta_keyword'    => $post['meta_keyword'] ?? '',
        'maps'            => $post['maps'] ?? '',
        'waktu'           => $post['waktu'] ?? 'Asia/Makassar',
        'type'            => $post['type'] ?? '',
        'credits'         => $post['credits'] ?? '',
        'min_lead_minutes'=> $minLead,
    ];

    // ===== UPLOAD FAVICON (OPSIONAL) =====
    $hasFile = !empty($_FILES['favicon']['name']);
    if ($hasFile) {
        $config = [
            'upload_path'   => FCPATH.'assets/images/',
            'allowed_types' => 'gif|jpg|jpeg|png|ico|GIF|JPG|JPEG|PNG|ICO',
            'max_size'      => 1024,         // KB (naikkan dari 500 agar tidak terlalu ketat)
            'overwrite'     => TRUE,
            'file_ext_tolower' => TRUE,
            'file_name'     => 'favicon',    // akan otomatis diberi ekstensi asli oleh CI
        ];
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('favicon')) {
            $rules = "Tipe file: ".str_replace("|", ", ", $config['allowed_types'])
                   ."<br>Maksimal ukuran: ".$config['max_size']." KB";
            echo json_encode([
                "success"=>false,
                "title"=>"Upload Gagal",
                "pesan"=>$this->upload->display_errors('<br> ',' ').$rules
            ]);
            return;
        } else {
            $fdata = $this->upload->data();
            $row['favicon'] = $fdata['file_name']; // contoh: favicon.png
        }
    }

    // ===== SIMPAN KE DB =====
    $this->db->where('id_identitas', 1);
    $ok = $this->db->update('identitas', $row);

    if ($ok) {
        echo json_encode([
            "success"=>true,
            "title"=>"Berhasil",
            "pesan"=>"Data berhasil diupdate"
        ]);
    } else {
        echo json_encode([
            "success"=>false,
            "title"=>"Gagal",
            "pesan"=>"Data gagal diupdate"
        ]);
    }
}


	
	
}