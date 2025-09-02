<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends Admin_Controller {
	function __construct(){
		parent::__construct();
		// cek_session_admin();
        $this->load->model("M_admin_user", "dm");
		// $this->load->model("M_admin_user_d", "ddm");
        $this->load->model("M_admin_user_profil", "cm");
  //       $this->load->model("M_faskes", "fs");
        $this->load->library("email");
        cek_session_akses(get_class($this), $this->session->userdata('admin_session'));
        
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Manajemen User";
        $data['arr_unit'] = $this->dm->arr_unit();
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

    function capil() {
    // Hanya bisa diakses oleh user dengan username 'admin'
        if ($this->session->userdata("admin_username") !== "admin") {
            return;
        }

        $controller = get_class($this);
        $data = [
            "controller" => $controller,
            "title"      => "Manajemen User Dukcapil",
            "subtitle"   => $this->om->engine_nama_menu($controller) . " Dukcapil",
            "content"    => $this->load->view("Capil_view", compact('controller'), true)
        ];

        $this->render($data);
    }

    function faskes() {
    // Hanya bisa diakses oleh user dengan username 'admin'
        if ($this->session->userdata("admin_username") !== "admin") {
            return;
        }

        $controller = get_class($this);
        $data = [
            "controller" => $controller,
            "title"      => "Manajemen User Faskes",
            "subtitle"   => "Faskes",
            "content"    => $this->load->view("Faskes_view", compact('controller'), true)
        ];

        $this->render($data);
    }


    public function detail_profil($id){
        $data["controller"] = get_class($this);

    // Ambil profil + nama unit (join unit_tujuan)
        $this->db->select("
            users.username,
            users.nama_lengkap,
            users.foto,
            users.no_telp,
            users.permission_publish,
            users.email,
            users.tanggal_reg,
            users.level,
            users.blokir,
            u.nama_unit
            ");
        $this->db->from("users");
        $this->db->join("unit_tujuan u", "u.id = users.id_unit", "left");
        $this->db->where("users.id_session", $id);

        $q = $this->db->get();
        if ($q->num_rows() === 0) {
            show_error("Pengguna tidak ditemukan.", 404, "Not Found");
            return;
        }

        $ret = $q->row();
        $data["record"]   = $ret;
        $data["title"]    = "Manajemen User";
        $data["subtitle"] = ucfirst($ret->level)." ".$ret->nama_lengkap;

        $data["content"] = $this->load->view($data["controller"]."_profil_view", $data, true);
        $this->render($data);
    }


    

    public function get_data_modul($id_session)
{
    $this->load->model('M_admin_user_profil', 'mprof');

    $list = $this->mprof->get_data($id_session);
    $data = [];
    $no   = (int)$this->input->post('start');

    foreach ($list as $r) {
        $no++;

        // tombol toggle hak akses
        $isOn = ((int)$r->granted === 1);
        $btn  = $isOn
          ? '<button class="btn btn-sm btn-success" onclick="pub('.(int)$r->id_modul.', \''.$id_session.'\')"><i class="fe-check"></i> Aktif</button>'
          : '<button class="btn btn-sm btn-outline-secondary" onclick="pub('.(int)$r->id_modul.', \''.$id_session.'\')"><i class="fe-plus"></i> Aktifkan</button>';

        $row = [
            'id_modul'   => (int)$r->id_modul,       // akan ditimpa nomor urut di rowCallback
            'nama_modul' => $r->nama_modul,
            'aksi'       => $btn,
        ];
        $data[] = $row;
    }

    $out = [
        "draw"            => (int)$this->input->post('draw'),
        "recordsTotal"    => $this->mprof->count_all(),
        "recordsFiltered" => $this->mprof->count_filtered($id_session),
        "data"            => $data,
    ];

    $this->output->set_content_type('application/json')->set_output(json_encode($out));
}


    function get_data_modul_capil($id){ 
        $this->load->model("M_capil_profil", "cpm");  
        $list = $this->cpm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_permohonan"] = $res->id_permohonan;
            $row["nama_permohonan"] = $res->nama_permohonan;

            $this->db->where("id_permohonan", $res->id_permohonan);
            $this->db->where("id_session", $id);
            $cek = $this->db->get("users_capil");

            if ($cek->num_rows() == "1") {
                $ck = "checked";
            } else {
                $ck = "";
            }

            $row["aksi"] = '<div class="custom-control custom-switch" ><a href="javascript:void(0)" onclick="pub('.$res->id_permohonan.','.$id.')">
            <input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
            <label class="custom-control-label" for="cek"></label>
            </a></div>';
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cpm->count_all(),
            "recordsFiltered" => $this->cpm->count_filtered(),
            "data" => $data,
        );
        // echo $this->db->last_query();
        echo json_encode($output);
    }


    public function get_data()
    {
    // pastikan model ter-load sebagai $this->m_admin_user
        $this->load->model('M_admin_user','m_admin_user');

        $list = $this->m_admin_user->get_data();
        $data = [];
        foreach($list as $res){
        // foto
            if (empty($res->foto)) {
                $foto = '<img src="'.base_url('upload/users/no-image.png').'" class="rounded-circle avatar-sm" width="50" alt="foto">';
            } else {
                $foto = '<img src="'.base_url('upload/users/'.$res->foto).'" class="rounded-circle avatar-sm" width="50" alt="foto">';
            }

            $row = [];
        // checkbox → gunakan id_session supaya unik
            $row['cek']          = '<div class="checkbox checkbox-primary checkbox-single"><input type="checkbox" class="data-check" value="'.htmlspecialchars($res->id_session).'"><label></label></div>';
            $row['foto']         = $foto;
            $row['username']     = htmlspecialchars($res->username);
            $row['nama_lengkap'] = htmlspecialchars($res->nama_lengkap ?: '—');
            $row['unit']         = htmlspecialchars($res->nama_unit ?: '—');
            $row['no_telp']      = htmlspecialchars($res->no_telp ?: '—');

        // url detail profil
            $row['detail_url']   = site_url(strtolower($this->router->class)."/detail_profil/".$res->id_session);

            $data[] = $row;
        }

        $output = [
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $this->m_admin_user->count_all(),
            "recordsFiltered" => $this->m_admin_user->count_filtered(),
            "data"            => $data,
        ];
        echo json_encode($output);
    }


    function get_data_capil(){  
        $this->load->model("M_capil", "cp");
        $list = $this->cp->get_data();
       
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->username;
            $row["nama_lengkap"] = $res->nama_lengkap;
            $row["username"] = $res->username;
            $row["no_telp"] = $res->no_telp;
            
            if (empty($res->foto)) {
                $row["foto"] = '<img src="'.base_url('upload/users/no-image.png').'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm" width="50">  <a href="javascript:void(0)" onclick="det('.$res->id_session.')">'.$res->nama_lengkap.'</a>';
            } else {
                $row["foto"] = '<img src="'.base_url("upload/users/").$res->foto.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm" width="50">  <a href="javascript:void(0)" onclick="det('.$res->id_session.')">'.$res->nama_lengkap.'</a>';
            }
           
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->username.'"><label></label></div>';

            $data[] = $row;
        }


            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->cp->count_all(),
                "recordsFiltered" => $this->cp->count_filtered(),
                "data" => $data,
            );
       

        
        // echo $this->db->last_query();
        echo json_encode($output);
    }


    function get_data_faskes(){  
        $this->load->model("M_faskes", "fs");
        $list = $this->fs->get_data();
       
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->username;
            $row["nama_lengkap"] = $res->nama_lengkap;
            $row["username"] = $res->username;
            $row["no_telp"] = $res->no_telp;
            $row["fasilitas_kesehatan"] = $res->nama_fasilitas;
            
            if (empty($res->foto)) {
                $row["foto"] = '<img src="'.base_url('upload/users/no-image.png').'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm" width="50">  <a href="javascript:void(0)" onclick="det('.$res->id_session.')">'.$res->nama_lengkap.'</a>';
            } else {
                $row["foto"] = '<img src="'.base_url("upload/users/").$res->foto.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm" width="50">  <a href="javascript:void(0)" onclick="det('.$res->id_session.')">'.$res->nama_lengkap.'</a>';
            }
           
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->username.'"><label></label></div>';

            $data[] = $row;
        }


            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->fs->count_all(),
                "recordsFiltered" => $this->fs->count_filtered(),
                "data" => $data,
            );
       

        
        // echo $this->db->last_query();
        echo json_encode($output);
    }

    
   public function add()
{
    // Ambil POST (XSS-filtered)
    $data = $this->input->post(NULL, TRUE);

    $this->load->library('form_validation');
    // Validasi
    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|max_length[12]|alpha_dash');
    $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
    $this->form_validation->set_rules('no_telp', 'Nama HP/WA', 'trim|required');
    $this->form_validation->set_rules('id_unit', 'Unit', 'required'); // ganti dari id_dusun → id_unit
    $this->form_validation->set_rules('password_baru', 'Password Baru', 'trim|required|min_length[8]');
    $this->form_validation->set_rules('password_baru_lagi', 'Konfirmasi Password', 'trim|required|min_length[8]|matches[password_baru]');

    // Pesan validasi (Indonesia)
    $this->form_validation->set_message('required', '* %s harus diisi');
    $this->form_validation->set_message('alpha_dash', '* %s hanya boleh huruf, angka, underscore (_), atau strip (-)');
    $this->form_validation->set_message('min_length', '* %s minimal %s karakter');
    $this->form_validation->set_message('max_length', '* %s maksimal %s karakter');
    $this->form_validation->set_message('matches', '* %s tidak sama');

    $this->form_validation->set_error_delimiters('<br> ', ' ');

    if ($this->form_validation->run() !== TRUE) {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => validation_errors()
        ]);
        return;
    }

    // Pastikan username minimal 6 (double guard, walau rule sudah ada)
    if (strlen($data["username"]) < 6) {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Username minimal 6 karakter"
        ]);
        return;
    }

    // ===== Buat id_session angka 10 digit unik =====
    do {
        $id_session = substr(str_shuffle(str_repeat("0123456789", 10)), 0, 10);
        $exists = $this->db->where('id_session', $id_session)->count_all_results('users');
    } while ($exists > 0);

    // Cek username sudah dipakai?
    $dupeUser = $this->db->where("username", $data["username"])
                         ->limit(1)->get("users");
    if ($dupeUser->num_rows() > 0) {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Username sudah ada"
        ]);
        return;
    }

    // (Opsional) Batasi 1 akun per unit: cek apakah id_unit sudah terdaftar
    // $dupeUnit = $this->db->where("id_unit", $data["id_unit"])
    //                      ->limit(1)->get("users");
    // if ($dupeUnit->num_rows() > 0) {
    //     echo json_encode([
    //         "success" => false,
    //         "title"   => "Gagal",
    //         "pesan"   => "Unit tersebut sudah memiliki akun"
    //     ]);
    //     return;
    // }

    // Siapkan data insert
    $row = [];
    $row["id_session"]   = $id_session;
    $row["id_unit"]      = $data["id_unit"];          // ← ganti dari id_dusun
    $row["nama_lengkap"] = $data["nama_lengkap"];
    $row["no_telp"]      = $data["no_telp"];
    $row["username"]     = $data["username"];
    $row["id_desa"]      = $this->session->userdata("id_desa");
    $row["blokir"]       = "N";
    $row["attack"]       = md5(date("Ymdhis"));
    $row["valid_reset"]  = "0000-00-00";
    $row["tanggal_reg"]  = date("Y-m-d");
    $row["id_reset"]     = hash("sha512", md5(date("Ymdhis")));
    $row["password"]     = password_hash($data["password_baru"], PASSWORD_ARGON2ID);

    // Simpan
    $res = $this->db->insert("users", $row);

    if ($res) {
        // Ambil nama unit untuk pesan
        $unit = $this->db->select('nama_unit')
                         ->get_where('unit_tujuan', ['id' => $data['id_unit']])
                         ->row();
        $nama_unit = $unit ? $unit->nama_unit : 'Unit';

        // Info website & wilayah (pakai helper $this->om jika tersedia)
        $web   = $this->om->web_me();
        $usr   = $this->om->user();
        $site  = site_url();

        // Kirim WA (jika fungsi tersedia)
        $plainPassword = $data["password_baru"]; // untuk dikirim via WA
        $pesan = "Akun Level *Unit* {$nama_unit} {$web->nama_website} ({$web->meta_keyword})"
               . " berhasil dibuat.\n"
               . "Silakan login di {$site} dengan:\n"
               . "username: *{$row['username']}*\n"
               . "password: *{$plainPassword}*";

        if (function_exists('send_wa_single') && !empty($row["no_telp"])) {
            @send_wa_single($row["no_telp"], $pesan);
        }

        echo json_encode([
            "success" => true,
            "title"   => "Berhasil",
            "id"      => $row["id_session"],
            "pesan"   => "Akun berhasil dibuat"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Data gagal disimpan"
        ]);
    }
}


    function generate_password($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($chars), 0, $length);
    }

    function add_capil(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','trim|required|max_length[12]'); 
        $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        // $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_message('min_length', '* %s Minimal 8  Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Karakter ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE) { 
            // Generate password dan ID session
            $password_plain = $this->generate_password(); 
            
            // Proses data session
            do {
                $id_session = substr(str_shuffle(str_repeat("0123456789", 5)), 0, 10);
                $exists = $this->db->where('id_session', $id_session)
                                   ->count_all_results('users');
            } while ($exists > 0);

            $data["id_session"] = $id_session;
            $data["level"] = "admin";
            unset($data["blokir"], $data["permission_publish"], $data["foto"], $data["attack"]);
            
            if (strlen($data["username"]) < 6) {
                $ret = array(
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "Username harus Minimal 6 karakter"
                );
                echo json_encode($ret);
                return false;
            }

            // Cek apakah username atau no_telp sudah ada di database
            $cek_user = $this->db->where("username", $data["username"])->limit(1)->get("users");
            if ($cek_user->num_rows() > 0) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "Username sudah ada"
                ]);
                return false;
            }

            $cek_user = $this->db->where("no_telp", $data["no_telp"])->limit(1)->get("users");
            if ($cek_user->num_rows() > 0) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "No. Telp sudah ada"
                ]);
                return false;
            }

            // Insert data user baru
            $data["password"] = password_hash($password_plain, PASSWORD_ARGON2ID);
            $data["blokir"] = "N";
            $data["attack"] = md5(date("Ymdhis"));
            $data["valid_reset"] = "0000-00-00";
            $data["tanggal_reg"] = date("Y-m-d");
            $data["id_reset"] = hash("sha512", md5(date("Ymdhis")));
            
            $res = $this->db->insert("users", $data);    

            if ($res) {
                // Jika berhasil simpan, kirim pesan WA
                $pesan = "Akun Level *Admin Dukcapil* " . $this->om->web_me()->nama_website . 
                         " (" . $this->om->web_me()->meta_keyword . ") Kabupaten Morowali Utara berhasil dibuat.\n" .
                         "Silakan login di: " . site_url() . "\n" .
                         "Username: *" . $data["username"] . "*\n" .
                         "Password: *" . $password_plain . "*";
                         
                // Mengirim pesan WA
                send_wa_single($data["no_telp"], $pesan);

                // Return success response
                $ret = array(
                    "success" => true,
                    "title"   => "Berhasil",
                    "id"      => $data["id_session"],
                    "pesan"   => "Akun Berhasil Dibuat"
                );
            } else {
                // Jika gagal simpan
                $ret = array(
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "Data Gagal disimpan"
                );
            }
        } else {
            // Jika form validation gagal
            $ret = array(
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => validation_errors()
            );
        }

        // Menampilkan hasil JSON
        echo json_encode($ret);

    }

    function add_faskes(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','trim|required|max_length[12]'); 
        $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required'); 
        $this->form_validation->set_rules('id_faskes','Faskes','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        // $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_message('min_length', '* %s Minimal 8  Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Karakter ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE) { 
            // Generate password dan ID session
            $password_plain = $this->generate_password(); 
            
            // Proses data session
            do {
                $id_session = substr(str_shuffle(str_repeat("0123456789", 5)), 0, 10);
                $exists = $this->db->where('id_session', $id_session)
                                   ->count_all_results('users');
            } while ($exists > 0);

            $data["id_session"] = $id_session;
            $data["level"] = "faskes";
            $data["id_desa"] = $data["id_faskes"];
            unset($data["blokir"], $data["permission_publish"], $data["foto"], $data["attack"]);
            
            if (strlen($data["username"]) < 6) {
                $ret = array(
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "Username harus Minimal 6 karakter"
                );
                echo json_encode($ret);
                return false;
            }

            // Cek apakah username atau no_telp sudah ada di database
            $cek_user = $this->db->where("username", $data["username"])->limit(1)->get("users");
            if ($cek_user->num_rows() > 0) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "Username sudah ada"
                ]);
                return false;
            }

            $cek_user = $this->db->where("no_telp", $data["no_telp"])->limit(1)->get("users");
            if ($cek_user->num_rows() > 0) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "No. Telp sudah ada"
                ]);
                return false;
            }

            // Insert data user baru
            $data["password"] = password_hash($password_plain, PASSWORD_ARGON2ID);
            $data["blokir"] = "N";
            $data["attack"] = md5(date("Ymdhis"));
            $data["valid_reset"] = "0000-00-00";
            $data["tanggal_reg"] = date("Y-m-d");
            $data["id_reset"] = hash("sha512", md5(date("Ymdhis")));
            
            $res = $this->db->insert("users", $data);    

            if ($res) {
                $this->db->where("id",$data["id_desa"]);
                $fas = $this->db->get("fasilitas_kesehatan")->row();
                // Jika berhasil simpan, kirim pesan WA
                $pesan = "Akun Level *Faskes $fas->nama_fasilitas* " . $this->om->web_me()->nama_website . 
                         " (" . $this->om->web_me()->meta_keyword . ") Kabupaten Morowali Utara berhasil dibuat.\n" .
                         "Silakan login di: " . site_url() . "\n" .
                         "Username: *" . $data["username"] . "*\n" .
                         "Password: *" . $password_plain . "*";
                         
                // Mengirim pesan WA
                send_wa_single($data["no_telp"], $pesan);

                // Return success response
                $ret = array(
                    "success" => true,
                    "title"   => "Berhasil",
                    "id"      => $data["id_session"],
                    "pesan"   => "Akun Berhasil Dibuat"
                );
            } else {
                // Jika gagal simpan
                $ret = array(
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "Data Gagal disimpan"
                );
            }
        } else {
            // Jika form validation gagal
            $ret = array(
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => validation_errors()
            );
        }

        // Menampilkan hasil JSON
        echo json_encode($ret);

    }


    function addx(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
           
            $this->db->where("email", $data["email"]);
            $cek_user = $this->db->get("users");
            if ($cek_user->num_rows() > 0) {
                $rules = "Email sudah digunakan";
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Email sudah digunakan");
                echo json_encode($ret);
                return false;
            } else {
                $kode = hash("sha512", md5(date("YmdHis")));
                $data["id_reset"] = hash("sha512", $kode);
                $datetime = new DateTime('today');
                $datetime->modify('+3 day');
                $link_valid = $datetime->format('Y-m-d');
                $data["valid_reset"] = $link_valid;
                $kode_reset = site_url("kmzwa8awaa/verifikasi_email/".$kode."-".$data["id_reset"]);

                $generate_pass = md5("YmdHis");
                $data["username"] = $data["email"];
                $data["blokir"] = "P";
                $data["id_session"] = "1".substr(preg_replace("/[^0-9]/", '', md5(date("Ymdhis"))),0,10);
                $data["password"] = hash("sha512", md5($generate_pass));
                $this->db->insert("users", $data);
                // rec(get_class($this));

                // set penerima
                $this->db->where("email", $data["email"]);
                $this->db->select("id_session, attack, tanggal_reg, email, nama_lengkap")->from("users");
                $cek_user = $this->db->get();
                $em = $cek_user->row();

                // set pengirim
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();
                
                // isi body pesan 
                $data["title"] = "Verifikasi Email";
                $data["p1"] = $web->nama_website ." mengirim verifikasi email untuk turut mengelola website. ";
                $data["p2"] = "Email verifikasi ini berlaku hingga ". tgl_view($link_valid)." Klik Verifikasi Email ";
                $data["btn"] = "Verifikasi Email";
                $data["link_reset"] = $kode_reset;
                $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
                // end of isi body

                $email                  = $em->email;
                $subject                = "Verifikasi Email";
                $this->email->from($web->email, $web->nama_website);
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject($subject);
                $body = $this->load->view('password/reset_password_mail_template',$data,TRUE);
                $this->email->message($body);  
                $this->email->set_mailtype("html");
                $this->email->send();

                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $res = $this->email->initialize($config);


            }
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "id" => $data["id_session"],
                    "pesan" => "Email verifikasi akun telah dikirim ke email<br>". $data["email"]);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan ");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
        
    }


    function resend(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
           
                $kode = hash("sha512", md5(date("YmdHis")));
                $data["id_reset"] = hash("sha512", $kode);
                $datetime = new DateTime('today');
                $datetime->modify('+3 day');
                $link_valid = $datetime->format('Y-m-d');
                $data["valid_reset"] = $link_valid;
                $kode_reset = site_url("kmzwa8awaa/verifikasi_email/".$kode."-".$data["id_reset"]);
                $generate_pass = md5("YmdHis");
                $data["blokir"] = "P";
                $data["password"] = hash("sha512", md5($generate_pass));
                $this->db->where("email", $data["email"]);
                $this->db->update("users", $data);
                // rec(get_class($this));

                // set penerima
                $this->db->where("email", $data["email"]);
                $this->db->select("id_session, attack, tanggal_reg, email, nama_lengkap")->from("users");
                $cek_user = $this->db->get();
                $em = $cek_user->row();

                // set pengirim
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();
                
                // isi body pesan 
                $data["title"] = "Verifikasi Email";
                $data["p1"] = $web->nama_website ." mengirim verifikasi email untuk turut mengelola website. ";
                $data["p2"] = "Email verifikasi ini berlaku hingga ". tgl_view($link_valid)." Klik Verifikasi Email ";
                $data["btn"] = "Verifikasi Email";
                $data["link_reset"] = $kode_reset;
                $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
                // end of isi body

                $email                  = $em->email;
                $subject                = "Verifikasi Email";
                $this->email->from($web->email, $web->nama_website);
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject($subject);
                $body = $this->load->view('password/reset_password_mail_template',$data,TRUE);
                $this->email->message($body);  
                $this->email->set_mailtype("html");
                $this->email->send();

                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $res = $this->email->initialize($config);
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    
                    "pesan" => "Email verifikasi akun telah dikirim ke email<br>". $data["email"]);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan ");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
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
            // rec(get_class($this));
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
       // echo $this->db->last_query();

    }

    function pub_capil($id,$ses){
        $this->db->where("id_session", $ses);
        $this->db->where("id_permohonan", $id);
        $cek = $this->db->get("users_capil");

        $this->db->where("id_permohonan", $id);
        $rul = $this->db->get("master_permohonan")->row();

        if ($cek->num_rows() == 0) {
            $data["id_permohonan"] = $id;
            $data["id_session"] = $ses;
            $rec = $this->db->insert("users_capil", $data);
            // rec(get_class($this));
            if ($rec) {
            $ret = array("success" => true,
                "title" => "Akses Dibuka",
                "pesan" => "Akses ".$rul->nama_permohonan  ." <br>Diizinkan");
            } else {
                $ret = array("success" => false,
                    "title" => " Gagal",
                    "pesan" => " Gagal prosess");
            }
        } else {
            $data["id_permohonan"] = $id;
            $data["id_session"] = $ses;
            $res = $this->db->delete("users_capil", $data);
            if ($res) {
                $ret = array("success" => true,
                    "title" => "Akses Ditutup",
                    "pesan" => "Akses ".$rul->nama_permohonan  ." <br>tidak diizinkan");
            } else {
                $ret = array("success" => false,
                    "title" => " Gagal",
                    "pesan" => " Gagal prosess");
            }
        }         
       echo json_encode($ret);
       // echo $this->db->last_query();

    }

    function hapus_data(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("username",$id);
                $res =$this->db->delete("users");
                if($res) {    
                    $ret = array("success" => true,
                        "title" => "Berhasil",
                        "pesan" => "Data berhasil dihapus");
                } else {
                    $ret = array("success" => false,
                        "title" => "Gagal",
                        "pesan" => "Data Gagal dihapus");
                }
            }
        echo json_encode($ret);
    } 

    function update_setting_profil($id){
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_website','Nama Website','required'); 
        $this->form_validation->set_rules('url','Domain','required');  
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == false ) { 

                $this->db->where("id_session",$id);
                $res  = $this->db->update("users",$data);    
                // rec(get_class($this));   
            
            
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

function reset_password_user($id){
    $this->db->where("blokir", "N");
    $this->db->where("id_session", $id);
    $this->db->select("id_session, attack, tanggal_reg, no_telp, nama_lengkap")->from("users");
    $cek_user = $this->db->get();
    $em = $cek_user->row();
    

     // buat kode reset dlu bro
    $kode = hash("sha512", md5(date("YmdHis")));
    $x["id_reset"] = hash("sha512", $kode);
    $datetime = new DateTime('today');
    $datetime->modify('+3 day');
    $link_valid = $datetime->format('Y-m-d');
    $x["valid_reset"] = $link_valid;
    $kode_reset = site_url("kmzwa8awaa/reset_password/".$kode."-".$x["id_reset"]);
                // insert tgl expired dan id_reset ke database untuk validasi
    $this->db->where("id_session", $id);
    $this->db->update("users", $x);
    // echo $this->db->last_query();
    // isi body pesan 
    $data["title"] = "Reset Password";
    $data["p1"] = "Hai ".$em->nama_lengkap.". Pengguna Aplikasi ".$this->om->web_me()->nama_website.". Jika permintaan ini adalah anda, Silahkan reset password anda";
    $data["p2"] = "Reset password ini berlaku hingga ". tgl_view($link_valid)." Klik Link Reset Password ";
    $data["btn"] = "Reset Password";
    $data["link_reset"] = $kode_reset;
    // $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
    $pesan = $data["title"]."<br>".$data["p1"].".<br>".$data["p2"].".<br>".$data["link_reset"]."";
    $noti = "Link Reset Password telah dikirim ke Whatsapp ". $em->no_telp."";
    send_wa_single($em->no_telp,$pesan); 
    if($noti) {    
        $ret = array("success" => true,
            "title" => "Berhasil",
            "type" => "success",
            "pesan" => $noti);
    } else {
        $ret = array("success" => false,
            "title" => "Gagal",
            "type" => "error",
            "pesan" => "Reset Password Gagal ");
    }
     echo json_encode($ret);

}

function reset_password_userx(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        // $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("blokir", "N");
            $this->db->where("email", $data["email"]);
            $this->db->select("id_session, attack, tanggal_reg, email, nama_lengkap")->from("users");
            $cek_user = $this->db->get();
            $em = $cek_user->row();

            if ($cek_user->num_rows() == 0) {
                $rules = "Email ini tidak terdaftar. Masukkan email yang sudah terdaftar";
            } else {
                // buat kode reset dlu bro
                $kode = hash("sha512", md5(date("YmdHis")));
                $x["id_reset"] = hash("sha512", $kode);
                $datetime = new DateTime('today');
                $datetime->modify('+3 day');
                $link_valid = $datetime->format('Y-m-d');
                $x["valid_reset"] = $link_valid;
                $kode_reset = site_url("kmzwa8awaa/reset_password/".$kode."-".$x["id_reset"]);
                // insert tgl expired dan id_reset ke database untuk validasi
                $this->db->where("email", $data["email"]);
                $this->db->update("users", $x);
                // // rec(get_class($this));

                // set pengirim
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();
                
                // isi body pesan 
                $data["title"] = "Reset Password";
                $data["p1"] = "Hai ".$em->nama_lengkap.". Jika permintaan ini adalah anda, Silahkan reset password anda";
                $data["p2"] = "Email reset password ini berlaku hingga ". tgl_view($link_valid)." Klik Reset Password ";
                $data["btn"] = "Reset Password";
                $data["link_reset"] = $kode_reset;
                $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
                // end of isi body

                $email                  = $em->email;
                $subject                = "Reset Password ".$web->nama_website;
                $this->email->from($web->email, $web->nama_website);
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject($subject);
                $body = $this->load->view('password/reset_password_mail_template',$data,TRUE);
                $this->email->message($body);  
                $this->email->set_mailtype("html");
                $this->email->send();

                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $res = $this->email->initialize($config);

                $rules = "Link Reset Password telah dikirim ke Email ". $data["email"]." Silahkan cek inbox atau spam";
            }
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "type" => "success",
                    "pesan" => $rules);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "type" => "error",
                    "pesan" => "Reset Password Gagal ".$rules);
            }

        } else {
            $ret = array("success"=>false,
                    "title" => "Gagal",
                    "type" => "error",
                   "pesan" => validation_errors());

        }
        echo json_encode($ret);
    }
	
}
