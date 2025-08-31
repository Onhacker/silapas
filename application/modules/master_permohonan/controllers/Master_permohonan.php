<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_permohonan extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_master_permohonan", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Permohonan";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}


	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_permohonan"] = $res->id_permohonan;
            $row["nama_permohonan"] = $res->nama_permohonan;
            $row["nama_tabel"] = $res->nama_tabel;
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_permohonan.'"><label></label></div>';

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
        $res = $this->dm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        echo json_encode($data);
    }


    
    function update() {
        cek_session_akses("master_permohonan", $this->session->userdata('admin_session'));
        $input = $this->input->post();
        $escaped_input = $this->db->escape_str($input);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_permohonan', 'Nama Permohonan', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('nama_file_balasan', 'Nama File Balasan', 'required');
        $this->form_validation->set_rules('file_balasan', 'File Balasan', 'required');
        $this->form_validation->set_rules('peringatan', 'Info Wajib/tidak wajib', 'required');

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');

        if ($this->form_validation->run() !== TRUE) {
            echo json_encode([
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => validation_errors()
            ]);
            return;
        }

    // Upload ICON (optional)
        if (!empty($_FILES['icon']['name'])) {
            $config = [
                'upload_path'   => 'assets/images/web/',
                'allowed_types' => 'jpg|jpeg|png|gif|webp',
                'max_size'      => 2048,
                'file_name'     => 'icon_' . time()
            ];
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('icon')) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Gagal Upload",
                    "pesan"   => $this->upload->display_errors('', '')
                ]);
                return;
            }

        // Hapus icon lama jika ada
            $old = $this->db->get_where("master_permohonan", ["id_permohonan" => $escaped_input["id_permohonan"]])->row();
            if (!empty($old->icon) && file_exists('assets/images/web/' . $old->icon)) {
                unlink('assets/images/web/' . $old->icon);
            }

            $upload_data = $this->upload->data();
            $escaped_input['icon'] = $upload_data['file_name'];

        // Resize image
            $resize_conf = [
                'image_library'  => 'gd2',
                'source_image'   => $upload_data['full_path'],
                'maintain_ratio' => FALSE,
                'width'          => 200,
                'height'         => 200
            ];
            $this->load->library('image_lib', $resize_conf);

            if (!$this->image_lib->resize()) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Resize Gagal",
                    "pesan"   => $this->image_lib->display_errors()
                ]);
                return;
            }
            $this->image_lib->clear();
        }

    // Validasi karakter aman untuk kolom file_balasan
        $new_file_cols = isset($input['file_balasan']) ? $input['file_balasan'] : '';
        if (!preg_match('/^[a-zA-Z0-9_, ]+$/', $new_file_cols)) {
            echo json_encode([
                "success" => false,
                "title"   => "Invalid",
                "pesan"   => "Format kolom file balasan tidak valid. Gunakan huruf, angka, koma."
            ]);
            return;
        }

    // Ambil data lama untuk cek perubahan kolom
        $old = $this->db->get_where("master_permohonan", ["id_permohonan" => $escaped_input["id_permohonan"]])->row();
        if (!$old) {
            echo json_encode([
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => "Data permohonan tidak ditemukan."
            ]);
            return;
        }

        $tabel_detail = $old->nama_tabel;
        if (!$this->db->table_exists($tabel_detail)) {
            echo json_encode([
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => "Tabel detail tidak ditemukan: " . $tabel_detail
            ]);
            return;
        }

        $old_fields_raw = $old->file_balasan ?? '';
        if ($old_fields_raw !== $new_file_cols) {
            $old_fields = array_map('trim', explode(',', $old_fields_raw));
            $new_fields = array_map('trim', explode(',', $new_file_cols));
            $existing_fields = $this->db->list_fields($tabel_detail);

        // Hapus kolom lama
            foreach ($old_fields as $old_col) {
                $col_name = 'file_' . $old_col;
                if (!in_array($old_col, $new_fields) && in_array($col_name, $existing_fields)) {
                    $this->db->query("ALTER TABLE `$tabel_detail` DROP COLUMN `$col_name`;");
                }
            }

        // Tambah kolom baru
            foreach ($new_fields as $new_col) {
                $col_name = 'file_' . $new_col;
                if (!in_array($col_name, $existing_fields)) {
                    $this->db->query("ALTER TABLE `$tabel_detail` ADD COLUMN `$col_name` varchar(255) DEFAULT NULL;");
                }
            }

        // Simpan kolom baru
            $escaped_input['file_balasan'] = $new_file_cols;
        }

    // Update ke database
        $this->db->where("id_permohonan", $escaped_input["id_permohonan"]);
        $res = $this->om->update("master_permohonan", $escaped_input);

        echo json_encode([
            "success" => $res,
            "title"   => $res ? "Berhasil" : "Gagal",
            "pesan"   => $res ? "Data berhasil diupdate" : "Data gagal diupdate"
        ]);
    }




    function add() {
        cek_session_akses("master_permohonan", $this->session->userdata('admin_session'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_permohonan', 'Nama Permohonan', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('nama_file_balasan', 'Nama File Balasan', 'required');
        $this->form_validation->set_rules('file_balasan', 'File Balasan', 'required');
        $this->form_validation->set_rules('peringatan', 'Info Wajib/tidak wajib', 'required');
        $this->form_validation->set_message('required', '* %s Harus diisi');
        $this->form_validation->set_message('numeric', '* %s Harus angka');
        $this->form_validation->set_error_delimiters('<br> ', ' ');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->db->escape_str($this->input->post());

        // Ambil id_permohonan terakhir
        $last_id = $this->db->select('id_permohonan')->order_by('id_permohonan', 'DESC')->limit(1)->get('master_permohonan')->row();
        $data["id_permohonan"] = $last_id ? $last_id->id_permohonan + 1 : 1;

        // Ambil nama_tabel terakhir dari master_permohonan
        $last_table = $this->db->select('nama_tabel')->order_by('id_permohonan', 'DESC')->limit(1)->get('master_permohonan')->row();
        $tabel_baru = 'paket_a'; // default jika kosong

        if ($last_table && preg_match('/^paket_([a-z])$/', $last_table->nama_tabel, $matches)) {
            $huruf = $matches[1];
            $huruf_selanjutnya = chr(ord($huruf) + 1);
            $tabel_baru = 'paket_' . $huruf_selanjutnya;
        }

        $data["nama_tabel"] = $tabel_baru;

        // Cek apakah tabel sudah ada
        if (!$this->db->table_exists($tabel_baru)) {
            $file_balasan = isset($data['file_balasan']) ? $data['file_balasan'] : '';
            $file_columns = '';

            if ($file_balasan != '') {
                $file_names = explode(',', $file_balasan);
                foreach ($file_names as $f) {
                    $f = trim($f);
                    if ($f != '') {
                        $file_columns .= "`file_" . $f . "` varchar(255),\n";
                    }
                }
            }

            $create_table_query = "
            CREATE TABLE `" . $tabel_baru . "` (
                `id_paket` varchar(100) NOT NULL,
                `id_pemohon` char(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                `nama` varchar(255) DEFAULT NULL,
                `nik` varchar(255) DEFAULT NULL,
                `no_kk` varchar(255) DEFAULT NULL,
                `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
                `nama_pemohon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                `no_wa_pemohon` varchar(255) DEFAULT NULL,
                `alamat` varchar(255) DEFAULT NULL,
                `id_desa` varchar(50) NOT NULL,
                `create_date` date NOT NULL,
                `create_time` varchar(20) NOT NULL,
                `username` varchar(100) NOT NULL,
                `id_dusun` int NOT NULL,
                `update_time` datetime NOT NULL,
                `status` int DEFAULT '0',
                `alasan_penolakan` text,
                `status_baca` int DEFAULT '0',
                `alasan_permohonan` text,
                $file_columns
                PRIMARY KEY (`id_paket`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            ";

            $this->db->query($create_table_query);
        }

        // Upload icon jika ada
        if (!empty($_FILES['icon']['name'])) {
            $config['upload_path']   = 'assets/images/web';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('icon')) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Gagal Upload",
                    "pesan"   => $this->upload->display_errors()
                ]);
                return;
            }

            $upload_data = $this->upload->data();
            $data['icon'] = $upload_data['file_name'];

            // Resize
            $resize_config = [
                'image_library'  => 'gd2',
                'source_image'   => $upload_data['full_path'],
                'maintain_ratio' => FALSE,
                'width'          => 200,
                'height'         => 200
            ];
            $this->load->library('image_lib', $resize_config);
            if (!$this->image_lib->resize()) {
                echo json_encode([
                    "success" => false,
                    "title"   => "Resize Gagal",
                    "pesan"   => $this->image_lib->display_errors()
                ]);
                return;
            }
            $this->image_lib->clear();
        }

        // Insert ke master_permohonan
        $res = $this->db->insert("master_permohonan", $data);
        echo json_encode([
            "success" => $res,
            "title"   => $res ? "Berhasil" : "Gagal",
            "pesan"   => $res ? "Data berhasil disimpan" : "Data gagal disimpan"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => validation_errors()
        ]);
    }
}




function hapus_data(){
    $list_id = $this->input->post('id');
    foreach ($list_id as $id) {
        // Ambil data dari master_permohonan berdasarkan id_permohonan
        $this->db->where("id_permohonan", $id);
        $t = $this->db->get("master_permohonan")->row();
        
        $tabel = $t->nama_tabel; // Nama tabel yang akan di-drop
        $file_balasan = $t->file_balasan; // Ambil nama file balasan jika ada
        $icon = $t->icon; // Ambil nama file icon jika ada

        if (!empty($icon) && file_exists('assets/images/web/' . $icon)) {
            unlink('assets/images/web/' . $icon); // Menghapus file icon
        }

        // Pastikan tabel ada dan kemudian lakukan DROP
        if (!empty($tabel)) {
            // Membuat query untuk DROP tabel
            $drop_table_query = "DROP TABLE IF EXISTS `" . $tabel . "`;";
            $this->db->query($drop_table_query);  // Eksekusi query DROP
        }

        // Hapus data dari master_permohonan
        $this->db->where("id_permohonan", $id);
        $res = $this->om->delete("master_permohonan"); // Menggunakan model 'om' untuk menghapus data

        // Menentukan respon berdasarkan hasil hapus data
        if ($res) {    
            $ret = array("success" => true,
                "title" => "Berhasil",
                "pesan" => "Data berhasil dihapus");
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => "Data gagal dihapus");
        }
    }
    echo json_encode($ret);
}




}
