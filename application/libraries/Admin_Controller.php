<?php
class Admin_Controller extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->timezone();
		$this->load->helper("cpu");
		cek_session_on_login();	
		$this->load->model("Ram_model","om");
		$this->load->helper("on");
		error_reporting(0);
	}

	function render($data){
		$this->om->validasiOnLogin();     // keluarkan jika perintah keluarkan dari prangkat lain
		$this->load->view("backend/admin_template",$data);
	}

	function timezone(){
		$this->db->where("id_identitas", "1");
		$s = $this->db->get("identitas")->row();
		return date_default_timezone_set($s->waktu);
	}

}
?>