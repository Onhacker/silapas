<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_admin();
		$this->load->model("M_admin_user", "dm");
        $this->load->model("M_admin_user_profil", "cm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Manajemen User";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	function detail_profil($id){
		$data["controller"] = get_class($this);   
        $this->db->select("username,nama_lengkap,foto,no_telp,email,tanggal_reg,level")->where("id_session",$id)->from("users");
        $a = $this->db->get();
        $ret = $a->row();
        $data["record"] = $a->row();
        $data["title"] = "Manajemen User";
        $data["subtitle"] = ucfirst($ret->level) ." ".$ret->nama_lengkap ;
        $data["content"] = $this->load->view($data["controller"]."_profil_view",$data,true); 
        $this->render($data);
	}

    function get_data_modul($id){   
        $list = $this->cm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_modul"] = $res->id_modul;
            $row["nama_modul"] = $res->nama_modul;

            $this->db->where("id_modul", $res->id_modul);
            $this->db->where("id_session", $id);
            $cek = $this->db->get("users_modul");

            if ($cek->num_rows() == "1") {
                $ck = "checked";
            } else {
                $ck = "";
            }

            $row["aksi"] = '<div class="custom-control custom-switch" ><a href="javascript:void(0)" onclick="pub('.$res->id_modul.','.$id.')">
            <input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
            <label class="custom-control-label" for="cek"></label>
            </a></div>';
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cm->count_all(),
            "recordsFiltered" => $this->cm->count_filtered(),
            "data" => $data,
        );
        // echo $this->db->last_query();
        echo json_encode($output);
    }


	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->username;
            $row["nama_lengkap"] = $res->nama_lengkap;
            $row["username"] = $res->username;
            $row["email"] = $res->email;
            $row["no_telp"] = $res->no_telp;
            $row["level"] = $res->level;
            $row["tanggal_reg"] = tgl_indo($res->tanggal_reg);

            if (empty($res->foto)) {
                $row["foto"] = '<img src="'.base_url('upload/users/no-image.png').'" alt="contact-img" title="contact-img" class="rounded-circle avatar-md" width="50"><br>&nbsp;  <a href="javascript:void(0)" onclick="det('.$res->id_session.')"><span class="badge badge-danger">Detail</span></a>';
            } else {
                $row["foto"] = '<img src="'.base_url("upload/users/").$res->foto.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-md" width="50"><br>&nbsp;  <a href="javascript:void(0)" onclick="det('.$res->id_session.')"><span class="badge badge-danger">Detail</span></a>';
            }
            if ($res->blokir == "N") {
            	$row["aksi"] = '<span class="badge badge-success p-1">Aktif</span>';
            } elseif ($res->blokir == "P") {
                $row["aksi"] = '<span class="badge badge-warning p-1">Pending</span>';
            } else {
            	$row["aksi"] = '<span class="badge badge-danger p-1">Terblokir</span>';
            }

            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->username.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
        	"draw" => $_POST['draw'],
        	"recordsTotal" => $this->dm->count_all(),
        	"recordsFiltered" => $this->dm->count_filtered(),
        	"data" => $data,
        );
        // echo $this->db->last_query();
        echo json_encode($output);
    }

    function edit($id){
        $data = array();
        $this->db->where("username", $id);
        $this->db->select("username,nama_lengkap,email,no_telp,foto,blokir,permission_publish,tanggal_reg")->from("users");
        $res = $this->db->get();
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        echo json_encode($data);
    }

    function hapus_gambar($id){
    	$this->db->where("username", $id);
        $this->db->select("foto")->from("users");
        $gbr = $this->db->get()->row();
    	$path = 'upload/users/';
    	$filename =  $path.$gbr->foto;
     	if ($this->session->userdata("admin_level") == "admin") {
    		unlink($filename);
    	}
     	$data["foto"] = "";
     	$this->db->where("username",$id);
     	$res = $this->om->update("users",$data);
        if($res) {    
        	// echo $this->db->last_query();
        	$ret = array("success" => true,
        		"title" => "Berhasil",
        		"pesan" => "Foto berhasil dihapus");
        } else {
        	$ret = array("success" => false,
        		"title" => "Berhasil",
        		"pesan" => "Foto Berhasil dihapus");
        }

       echo json_encode($ret);

    }

    function add(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('member','Username','required'); 
        $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required'); 
        $this->form_validation->set_rules('pass_member','Password','required'); 
        $this->form_validation->set_rules('konfirmasi','Konfirmasi Password','required'); 
        $this->form_validation->set_rules('no_telp','No Telpon','trim|numeric|required|min_length[10]|max_length[12]'); 
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["level"] = $data["posisi"];
            $data["username"] = $data["member"];
            unset($data["member"]);
            unset($data["posisi"]);
            $this->db->where("username", $data["username"]);
            $cek_user = $this->db->get("users");
            if ($cek_user->num_rows() > 0) {
                $rules = "Username telah digunakan";
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Username sudah ada");
                echo json_encode($ret);
                return false;
            }
            if ($data["pass_member"] <> $data["konfirmasi"]) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Password  dan Konfirmas Password  Tidak Sama");
                echo json_encode($ret);
                return false;
            } 

            $data["password"] = hash("sha512", md5($data["pass_member"]));
            unset($data["pass_member"]);
            unset($data["konfirmasi"]);
            $data["tanggal_reg"] = date("Y-m-d");
            $data["id_session"] = substr(preg_replace("/[^0-9]/", '', md5(date("Ymdhis"))),0,12)."685242777544222444";
            $data["attack"] = md5(date("Ymdhis")."sudo shutdwon -r now");
            $new_name = $data["nama_lengkap"];
            $config['upload_path'] = 'upload/users/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|PNG|JPEG|GIF';
            $config['max_size'] = '1000'; // kb
            $config['overwrite'] = TRUE;
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            

            if (empty($_FILES['foto']["name"])){
                $res  = $this->db->insert("users",$data);   
            } 

            if (! $this->upload->do_upload('foto')) {
                $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

            } else {
                $this->db->where("username", $data["username"]);
                $gbr = $this->db->get("users")->row();
                $path = 'upload/users/';
                $filename =  $path.$gbr->foto;
                if ($this->session->userdata("admin_level") == "admin") {
                    unlink($filename);
                } 
                $fdata =  $this->upload->data();
                $data['foto'] = $fdata['file_name'];    
                $res  = $this->db->insert("users",$data);       
            }
            
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    }


   

	function update(){
		$data = $this->db->escape_str($this->input->post());
        unset($data["member"]);
        unset($data["pass_member"]);
        unset($data["konfirmasi"]);
        unset($data["posisi"]);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required'); 
        $this->form_validation->set_rules('no_telp','No Telpon','numeric'); 
        $this->form_validation->set_rules('email','Email','valid_email'); 
        $this->form_validation->set_rules('no_telp','No Telpon','min_length[10]'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 

			$new_name = $data["nama_lengkap"];
            $config['upload_path'] = 'upload/users/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|PNG|JPEG|GIF';
            $config['max_size'] = '1000'; // kb
            $config['overwrite'] = TRUE;
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if ($data["blokir"] == "Y") {
                $data["attack"] = md5(date("Ymdhis"));
            } 

            if (empty($_FILES['foto']["name"])){
				$this->db->where("username",$data["username"]);
				$res  = $this->db->update("users",$data);	
			} 

			if (! $this->upload->do_upload('foto')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$this->db->where("username", $data["username"]);
                $gbr = $this->db->get("users")->row();
                $path = 'upload/users/';
                $filename =  $path.$gbr->foto;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } 
				$fdata =  $this->upload->data();
				$data['foto'] = $fdata['file_name'];	
				$this->db->where("username",$data["username"]);
				$res  = $this->db->update("users",$data);		
			}
            
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil diupdate");
			} else {
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

	function hapus_data(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("username", $id);
                $gbr = $this->db->get("users")->row();
                if ($gbr->level == "admin") {
                    $rules = "<br>Akun level admin tidak dapat dihapus";
                } else {
                    $path = 'upload/users/';
                    $filename =  $path.$gbr->foto;
                    if ($this->session->userdata("admin_level") == "admin") {
                        unlink($filename);
                    } 
                    $data["deleted"] = "Y";
                    $data["blokir"] = "Y";
                    $data["email"] = "";
                    $data["id_session"] = "";
                    $data["password"] = md5(date("YmdHis")."sudo shutdown dsdsk");
                    $data["attack"] = md5(date("YmdHis"));
                    $data["permission_publish"] = "N";
                    $this->db->where("username",$id);
                    $res =$this->db->update("users",$data);
                }                
            }
	        if($res) {    
	        	$ret = array("success" => true,
	        		"title" => "Berhasil",
	        		"pesan" => "Data berhasil dihapus");
	        } else {
	        	$ret = array("success" => false,
	        		"title" => "Gagal",
	        		"pesan" => "Data Gagal dihapus ".$rules);
	        }

        echo json_encode($ret);
    } 


    function pub($id,$ses){
        $this->db->where("id_session", $ses);
        $this->db->where("id_modul", $id);
        $cek = $this->db->get("users_modul");

        $this->db->where("id_modul", $id);
        $rul = $this->db->get("modul")->row();

        if ($cek->num_rows() == 0) {
            $data["id_modul"] = $id;
            $data["id_session"] = $ses;
            $rec = $this->db->insert("users_modul", $data);
            if ($rec) {
            $ret = array("success" => true,
                "title" => "Akses Dibuka",
                "pesan" => "Akses ".$rul->nama_modul." <br>Diizinkan");
            } else {
                $ret = array("success" => false,
                    "title" => " Gagal",
                    "pesan" => " Gagal prosess");
            }
        } else {
            $data["id_modul"] = $id;
            $data["id_session"] = $ses;
            $res = $this->db->delete("users_modul", $data);
            if ($res) {
                $ret = array("success" => true,
                    "title" => "Akses Ditutup",
                    "pesan" => "Akses ".$rul->nama_modul." <br>tidak diizinkan");
            } else {
                $ret = array("success" => false,
                    "title" => " Gagal",
                    "pesan" => " Gagal prosess");
            }
        }         
       echo json_encode($ret);

    }

	
}
