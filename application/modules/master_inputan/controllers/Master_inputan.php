<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_inputan extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_master_inputan", "dm");
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
            $row["id"] = $res->id;
            if ($res->wajib == "1") {
                $row["wajib"] = "wajib";
            } else {
                $row["wajib"] = "tidak";
            }
            $row["nama_kolom"] = $res->nama_kolom;
            $row["nama_permohonan"] = $res->nama_permohonan;
            
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id.'"><label></label></div>';

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
    cek_session_akses("master_inputan", $this->session->userdata('admin_session'));

    $this->load->library('form_validation');
    $this->form_validation->set_rules('tabel', 'Pilih Permohonan', 'required');
    $this->form_validation->set_rules('nama_kolom', 'Nama Kolom', 'required');
    $this->form_validation->set_rules('wajib', 'Wajib', 'required');
    $this->form_validation->set_message('required', '* %s Harus diisi ');
    $this->form_validation->set_error_delimiters('<br> ', ' ');

    if ($this->form_validation->run() !== TRUE) {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => validation_errors()
        ]);
        return;
    }

    $id        = $this->input->post('id', true);
    $tabel     = $this->input->post('tabel', true);
    $nama_kolom_baru = $this->input->post('nama_kolom', true);
    $wajib     = $this->input->post('wajib', true);

    // Ambil data lama dari master_inputan (untuk nama kolom lama)
    $data_lama = $this->db->get_where('master_inputan', ['id' => $id])->row();
    if (!$data_lama) {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Data tidak ditemukan."
        ]);
        return;
    }

    $nama_kolom_lama = $data_lama->nama_kolom;

    // Update data di master_inputan dulu
    $data_update = [
        'tabel'     => $tabel,
        'nama_kolom'=> $nama_kolom_baru,
        'wajib'     => $wajib,
    ];

    $this->db->where('id', $id);
    $res = $this->db->update('master_inputan', $data_update);

    if ($res) {
        // Rename kolom di tabel dinamis
        // Pastikan nama tabel dan kolom valid dan aman (hindari SQL Injection)
        // Gunakan backtick untuk identifier
        $sql = "ALTER TABLE `".$this->db->escape_str($tabel)."` CHANGE `".$this->db->escape_str($nama_kolom_lama)."` `".$this->db->escape_str($nama_kolom_baru)."` VARCHAR(255)";

        $rename = $this->db->query($sql);

        if (!$rename) {
            // Kalau gagal rename kolom, rollback atau beri peringatan
            echo json_encode([
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => "Gagal mengganti nama kolom di tabel $tabel"
            ]);
            return;
        }
    }

    echo json_encode([
        "success" => $res && $rename,
        "title"   => ($res && $rename) ? "Berhasil" : "Gagal",
        "pesan"   => ($res && $rename) ? "Data berhasil diupdate dan kolom berhasil diganti nama" : "Terjadi kesalahan saat update"
    ]);
}




    function generate_kode_file($label) {
    // Ubah ke huruf kecil
        $label = strtolower($label);

    // Hapus semua karakter selain huruf dan angka
        $kode = preg_replace('/[^a-z0-9]/', '', $label);

    // Jika kosong, fallback dengan timestamp
        if (empty($kode)) {
        $kode = 'file' . time(); // contoh: file1714450123
    }

    return $kode;
}

function add() {
    cek_session_akses("master_inputan", $this->session->userdata('admin_session'));

    $this->load->library('form_validation');
    $this->form_validation->set_rules('tabel', 'Pilih Permohonan', 'required');
    $this->form_validation->set_rules('nama_kolom', 'Nama Kolom', 'required');
    $this->form_validation->set_rules('wajib', 'Wajib', 'required');
    $this->form_validation->set_message('required', '* %s Harus diisi');
    $this->form_validation->set_error_delimiters('<br> ', ' ');

    if ($this->form_validation->run() !== TRUE) {
        echo json_encode([
            "success" => false,
            "title"   => "Validasi Gagal",
            "pesan"   => validation_errors()
        ]);
        return;
    }

    // Ambil input
    $tabel      = $this->input->post('tabel', true);
    $nama_kolom = $this->input->post('nama_kolom', true);
    $wajib      = $this->input->post('wajib', true);

    // Data untuk insert ke master_inputan
    $data = [
        'tabel'      => $tabel,
        'nama_kolom' => $nama_kolom,
        'wajib'      => $wajib
    ];

    // Insert data ke master_inputan
    $res = $this->db->insert('master_inputan', $data);

    if ($res) {
        // Setelah berhasil insert, tambahkan kolom di tabel dinamis
        // Validasi nama tabel dan kolom (simple)
        if ($this->db->table_exists($tabel)) {
            // Cek dulu apakah kolom sudah ada agar tidak error
            if (!$this->db->field_exists($nama_kolom, $tabel)) {
                // Tambah kolom baru VARCHAR(255) NULL DEFAULT NULL
                $sql = "ALTER TABLE `".$this->db->escape_str($tabel)."` ADD COLUMN `".$this->db->escape_str($nama_kolom)."` VARCHAR(255) NULL DEFAULT NULL";

                $alter = $this->db->query($sql);

                if (!$alter) {
                    // Kalau gagal tambahkan kolom, rollback insert master_inputan
                    $this->db->where('tabel', $tabel);
                    $this->db->where('nama_kolom', $nama_kolom);
                    $this->db->delete('master_inputan');

                    echo json_encode([
                        "success" => false,
                        "title"   => "Gagal",
                        "pesan"   => "Gagal menambahkan kolom baru di tabel $tabel"
                    ]);
                    return;
                }
            } else {
                // Kolom sudah ada
                echo json_encode([
                    "success" => false,
                    "title"   => "Gagal",
                    "pesan"   => "Kolom $nama_kolom sudah ada di tabel $tabel"
                ]);
                return;
            }
        } else {
            // Tabel tidak ada
            echo json_encode([
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => "Tabel $tabel tidak ditemukan di database"
            ]);
            return;
        }
    }

    // Jika semua sukses
    echo json_encode([
        "success" => $res,
        "title"   => $res ? "Berhasil" : "Gagal",
        "pesan"   => $res ? "Data berhasil disimpan dan kolom baru berhasil ditambahkan" : "Data gagal disimpan"
    ]);
}






function hapus_data() {
    $list_id = $this->input->post('id');
    $berhasil = false;

    foreach ($list_id as $id) {
        // Ambil data lama
        $row = $this->db->get_where('master_inputan', ['id' => $id])->row();
        if ($row) {
            $tabel = $row->tabel;
            $nama_kolom = $row->nama_kolom;

            // Hapus kolom di tabel yang bersangkutan jika ada
            if ($this->db->table_exists($tabel) && $this->db->field_exists($nama_kolom, $tabel)) {
                $sql = "ALTER TABLE `" . $this->db->escape_str($tabel) . "` DROP COLUMN `" . $this->db->escape_str($nama_kolom) . "`";
                $this->db->query($sql);
            }

            // Hapus data dari master_inputan
            $this->db->where("id", $id);
            $berhasil = $this->db->delete("master_inputan");
        }
    }

    // Respon
    if ($berhasil) {
        $ret = [
            "success" => true,
            "title"   => "Berhasil",
            "pesan"   => "Data dan kolom berhasil dihapus"
        ];
    } else {
        $ret = [
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Data gagal dihapus"
        ];
    }

    echo json_encode($ret);
}



}
