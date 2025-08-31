<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_profil extends Admin_Controller {
    function __construct(){
        parent::__construct();
        // Pastikan helper/model profil tersedia; $this->om->profil() sudah kita perbaiki sebelumnya
    }

    public function index(){
        $data["controller"] = get_class($this);
        $row = $this->om->profil()->row(); // fungsi profil() sudah disesuaikan sebelumnya
        $data["record"]   = $row ?: (object)[
            'username' => $this->session->userdata('admin_username'),
            'nama_lengkap' => $this->session->userdata('admin_nama') ?: $this->session->userdata('admin_username'),
            'no_telp'  => '',
            'foto'     => '',
            'tanggal_reg' => date('Y-m-d'),
            'level'    => $this->session->userdata('admin_level'),
            'desa'     => '',
            'kecamatan'=> '',
        ];
        $data["title"]    = "Pengaturan Profil";
        $data["subtitle"] = ucfirst($this->session->userdata("admin_level"));
        $data["content"]  = $this->load->view($data["controller"]."_view",$data,true);
        $this->render($data);
    }

    /** JSON untuk view (AJAX) */
    public function load_profil(){
        $row = $this->om->profil()->row_array();
        if (!$row) {
            $row = [
                'username'      => $this->session->userdata('admin_username'),
                'nama_lengkap'  => $this->session->userdata('admin_nama') ?: $this->session->userdata('admin_username'),
                'no_telp'       => '',
                'foto'          => '',
                'tanggal_reg'   => date('Y-m-d'),
                'desa'          => '',
                'kecamatan'     => '',
            ];
        }
        // fallback foto
        if (empty($row['foto'])) $row['foto'] = 'Dewis.jpg';
        // format tanggal untuk tampilan
        $row['tanggal_reg'] = function_exists('tgl_indo') ? tgl_indo($row['tanggal_reg']) : date('d-m-Y', strtotime($row['tanggal_reg']));
        $this->output->set_content_type('application/json')->set_output(json_encode($row));
    }

    /** Update profil + upload foto */
    public function update(){
        // Ambil POST aman (XSS Filtering)
        $data = $this->input->post(NULL, TRUE);
        $username = $this->session->userdata("admin_username");

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required');
        $this->form_validation->set_rules('no_telp','No Whatsapp','trim|required|numeric|min_length[10]|max_length[12]');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
            return;
        }

        // Cek unik no_telp selain user ini
        $cek = $this->db->where('no_telp', $data['no_telp'])
                        ->where('username !=', $username)
                        ->get('users')->row();
        if ($cek) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"No. Whatsapp ".$data["no_telp"]." sudah digunakan"]);
            return;
        }

        // Ambil user saat ini
        $user = $this->db->where('username',$username)->get('users')->row();
        if (!$user) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"User tidak ditemukan"]);
            return;
        }

        // Siapkan data update dasar
        $upd = [
            'nama_lengkap'       => $data['nama_lengkap'],
            'no_telp'            => $data['no_telp'],
            'permission_publish' => $user->permission_publish,
            'blokir'             => $user->blokir,
            'level'              => $user->level,
        ];

        // ==== Upload Foto (opsional) ====
        if (!empty($_FILES['foto']['name'])) {
            $this->load->library('upload');
            $base_name = ($this->session->userdata('id_desa') ?: $username) . "_" . (function_exists('buat_name') ? buat_name($data['nama_lengkap'], "0") : preg_replace('~\s+~','-', strtolower($data['nama_lengkap']))) . "_" . substr(md5(date("Ymdhis")), 0, 8);
            $cfg = [
                'upload_path'   => FCPATH.'upload/users/',
                'allowed_types' => 'jpg|jpeg|png|JPG|PNG|JPEG',
                'max_size'      => 2048,
                'overwrite'     => TRUE,
                'file_name'     => $base_name,
            ];
            $this->upload->initialize($cfg);

            if (!$this->upload->do_upload('foto')) {
                $err = $this->upload->display_errors('', '');
                echo json_encode([
                    "success"=>false,
                    "title"=>"Gagal",
                    "pesan"=>"Upload gagal: ".$err."<br>Tipe diizinkan: jpg, jpeg, png. Maks 2MB."
                ]);
                return;
            }

            // Hapus foto lama (jika ada & bukan default)
            if (!empty($user->foto)) {
                $old = FCPATH.'upload/users/'.$user->foto;
                if (is_file($old)) @unlink($old);
            }

            // Resize ringan
            $fdata = $this->upload->data();
            $upd['foto'] = $fdata['file_name'];

            $this->load->library('image_lib');
            $this->image_lib->clear();
            $rz = [
                'image_library'  => 'gd2',
                'source_image'   => $fdata['full_path'],
                'maintain_ratio' => TRUE,
                'width'          => 300,
                'height'         => 300,
            ];
            $this->image_lib->initialize($rz);
            @$this->image_lib->resize();
        }

        // Simpan
        $this->db->where('username', $username);
        $res = $this->db->update('users', $upd);

        if ($res) {
            // Sinkronkan session agar header menampilkan nama/foto terbaru
            if (!empty($upd['nama_lengkap'])) $this->session->set_userdata('admin_nama', $upd['nama_lengkap']);
            if (!empty($upd['foto']))         $this->session->set_userdata('admin_foto', $upd['foto']);

            echo json_encode(["success"=>true,"title"=>"Berhasil","pesan"=>"Data berhasil diupdate"]);
        } else {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data gagal diupdate"]);
        }
    }

    /** Ganti password */
    public function update_pass(){
        $data     = $this->input->post(NULL, TRUE);
        $username = $this->session->userdata("admin_username");

        $this->load->library('form_validation');
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password_baru_lagi', 'Konfirmasi Password', 'trim|required|min_length[8]');
        $this->form_validation->set_message('required', '* %s Harus diisi');
        $this->form_validation->set_message('min_length', '* %s Minimal 8 karakter');
        $this->form_validation->set_error_delimiters('<br> ', ' ');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
            return;
        }

        $user = $this->db->where('username',$username)->get('users')->row();
        if (!$user) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"User tidak ditemukan"]);
            return;
        }

        if (!password_verify($data['password_lama'], $user->password)) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Password Lama salah"]);
            return;
        }

        if ($data['password_baru'] !== $data['password_baru_lagi']) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Password Baru dan Konfirmasi Password tidak sama"]);
            return;
        }

        $upd = ['password' => password_hash($data['password_baru'], PASSWORD_ARGON2ID)];
        if (!empty($data['out']) && $data['out'] === 'out') {
            $upd['attack'] = md5(date("YmdHis"));
            $this->session->set_userdata("admin_attack", $upd['attack']);
        }

        $this->db->where('username',$username);
        $ok = $this->db->update('users', $upd);

        echo json_encode($ok
            ? ["success"=>true,"title"=>"Berhasil","pesan"=>"Password berhasil diperbarui"]
            : ["success"=>false,"title"=>"Gagal","pesan"=>"Gagal memperbarui password"]
        );
    }

    /* ====== (Opsional) Konversi password legacy ====== */
    public function convert_password_to_password_hash(){
        $operators = $this->db->get('operator')->result();
        $updated = 0;
        foreach ($operators as $op) {
            if (empty($op->rah)) continue;
            $new_hash = password_hash($op->rah, PASSWORD_ARGON2ID);
            $this->db->where('username', $op->username)->update('users', ['password' => $new_hash]);
            $updated++;
        }
        echo "Berhasil update $updated user ke password_hash() berdasarkan kolom rah.";
    }

    public function convert_password_to_password_hashx(){
        $this->db->where("username", "admin"); // contoh filter
        $users = $this->db->get('users')->result();
        $updated = 0;
        foreach ($users as $u) {
            $new_hash = password_hash('onhacker', PASSWORD_ARGON2ID); // ganti kemudian!
            $this->db->where('username', $u->username)->update('users', ['password' => $new_hash]);
            $updated++;
        }
        echo "Berhasil update $updated user ke password_hash() (default).";
    }

    public function detek(){
        $users = $this->db->get('users')->result();
        $i=1;
        foreach ($users as $user) {
            $info = password_get_info($user->password);
            $algo = $info['algoName'];
            $uname = $user->username;
            $uname_mask = substr($uname, 0, 2) . str_repeat('*', max(3, strlen($uname)-2));
            if ($algo === 'unknown') {
                $ket = "❌ Hash tidak dikenali atau bukan hasil dari password_hash()";
            } else {
                $ket = "✅ Hash menggunakan algoritma: <b>{$algo}</b>";
            }
            echo "User <b>{$i}</b> (<code>{$uname_mask}</code>): {$ket}<br>";
            $i++;
        }
    }
}
