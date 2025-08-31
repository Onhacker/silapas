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

	function update(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_website','Nama Website','required'); 
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email'); 
		$this->form_validation->set_rules('no_telp','No Telpon','trim|numeric|required|min_length[10]|max_length[12]'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
		$this->form_validation->set_message('numeric', '* %s Harus angka ');
		$this->form_validation->set_message('valid_url', '* %s Tidak Valid ');
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["facebook"] = $data2["facebook"];
			$data["maps"] = $data2["maps"];
			$data["url"] = site_url();
			$data["alamat"] = $data2["alamat"];
			$data["meta_deskripsi"] = $data2["meta_deskripsi"];
			$data["no_telp"] = preg_replace('/\s+/', '',$data["no_telp"]);
			$new_name = "favicon";
			$config['upload_path'] = 'assets/images/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png|ico|JPG|PNG|ICO|JPEG|GIF';
            $config['max_size'] = '500'; // kb
            $config['overwrite'] = TRUE;
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (empty($_FILES['favicon']["name"])){
				$this->db->where("id_identitas","1");
				$res  = $this->db->update("identitas",$data);	
				// rec(get_class($this));	
			} 

			if (! $this->upload->do_upload('favicon')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size'])." Kb)";

			} else {
				$fdata =  $this->upload->data();
				$data['favicon'] = $fdata['file_name'];	
				$this->db->where("id_identitas","1");
				$res  = $this->db->update("identitas",$data);
				// rec(get_class($this));		
			}
            
			if($res) {
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil diupdate");
			} else {
				// rec(get_class($this));
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal diupdate ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
		
		
	}

	
	
}