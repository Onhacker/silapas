<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hal extends MX_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper("front");
		$this->load->model("front_model",'fm');
	}

	function index(){
		$data["title"] = "Tracking Permohonan";
		$data["rec"] = $this->fm->web_me();
		$this->load->view('hal_view',$data);

	}

	function alur(){
		$data["title"] = "Alur Permohonan Kunjungan";
		$data["deskripsi"] = "Alur permohonan Kunjungan Silaturahmi Makassar merupakan rangkaian tahapan yang harus dilalui oleh pemohon untuk mengajukan suatu permohonan kunjungan kepada Lapas Kelas I Makassar.";
		$data["prev"] = base_url("assets/images/flow.webp");
		$data["rec"] = $this->fm->web_me();
		$this->load->view('hal_view',$data);
	}

	function privacy_policy(){
		$data["title"] = "Privacy Policy";
		$data["deskripsi"] = "Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi data pribadi pengguna";
		$data["prev"] = base_url("assets/images/flow.webp");
		$data["rec"] = $this->fm->web_me();
		$this->load->view('privacy',$data);
	}

	function kontak(){
		$data["title"] = "Kontak Lapas Kelas I Makassar";
		$data["deskripsi"] = "Kontak Lapas Kelas I Makassar memuat informasi lengkap mengenai nomor penting dan alamat kantor. Fitur ini memudahkan masyarakat dalam menghubungi pihak Lapas untuk berbagai keperluan administrasi maupun layanan.";

		$data["prev"] = base_url("assets/images/icon_app.png");
		$data["rec"] = $this->fm->web_me();
		$this->load->view('kontak_view',$data);
	}

	function struktur(){
		$data['controller'] = get_class($this);
		$this->load->model('M_organisasi', 'mo');
		$rows = $this->mo->get_all();
        $tree = $this->build_tree($rows);
		$data["deskripsi"] = "Struktur Organisasi Lapas Kelas I Makassar.";
		$data["prev"] = base_url("assets/images/icon_app.png");
		$data["title"] = "Struktur Organisasi";
		$data["rec"] = $this->fm->web_me();
		$data['tree']       = $tree;
		$this->load->view('organisasi_view',$data);
	}

	 /** Utility: build nested tree dari rows datar */
   private function build_tree($units, $parent_id = NULL) {
        $branch = [];
        foreach ($units as $unit) {
            if ($unit->parent_id == $parent_id) {
                $children = $this->build_tree($units, $unit->id);
                if ($children) {
                    $unit->children = $children;
                }
                $branch[] = $unit;
            }
        }
        return $branch;
    }

	function get_data_desa() {
		$this->load->model("M_desa", "dm");
		$list = $this->dm->get_data();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $res) {
			$no++;
			$row = array();
			$row["nama_lengkap"] = $res->nama_lengkap;
			$row["kecamatan"] = ucwords(strtolower($res->kecamatan));
			$row["desa"] = ucwords(strtolower($res->desa));
			$row["no_telp"] = $res->no_telp;
			// Memastikan nomor telepon diformat dengan benar (hapus karakter non-angka dan pastikan nomor diawali dengan '62')
			$formattedNoTelp = preg_replace('/[^0-9]/', '', $res->no_telp);

			if (!empty($formattedNoTelp)) {
				if (substr($formattedNoTelp, 0, 1) === '0') {
					$formattedNoTelp = '62' . substr($formattedNoTelp, 1);
				}

				$waLink = "https://wa.me/{$formattedNoTelp}?text=Halo%20Operator%20Sidia%20Desa%20" . ucwords(strtolower($res->desa));

				$row["no_telp"] = "<a href='{$waLink}' target='_blank' class='btn btn-success btn-xs'>
				<i class='fab fa-whatsapp mr-1'></i> {$res->no_telp}
				</a>";
			} else {
			    $row["no_telp"] = ''; // Jangan tampilkan apa pun jika kosong
			}

			$this->db->where("id_desa", $res->id_desa);
			$dusun_list = $this->db->get("master_dusun")->result_array();
			$row["dusun"] = $dusun_list; 


			$data[] = $row;
		}

		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" => $this->dm->count_all(),
			"recordsFiltered" => $this->dm->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}




	function permohonan(){
		$data['list_permohonan'] = $this->db
		->order_by("urutan", "ASC")
		->get('master_permohonan')
		->result();
		$data['jumper'] = $this->db->from("master_permohonan")->count_all_results();

		$data['statistik_permohonan'] = [];
		foreach ($data['list_permohonan'] as $per) {
			$tabel = $per->nama_tabel;

			$jumlah_status = [
				'status_1' => $this->db->where('status', 1)->count_all_results($tabel),
				'status_3' => $this->db->where('status', 3)->count_all_results($tabel),
				'status_4' => $this->db->where('status', 4)->count_all_results($tabel),
				'status_5' => $this->db->where('status', 5)->count_all_results($tabel),
			];

			$data['statistik_permohonan'][] = [
				'id_permohonan' => $per->id_permohonan,
				'nama_permohonan' => $per->nama_permohonan,
				'icon' => $per->icon,
				'deskripsi' => $per->deskripsi,
				'jumlah' => $jumlah_status
			];
		}

		$data["deskripsi"] = "Setiap permohonan administrasi memerlukan dokumen dan persyaratan tertentu. Lengkapi semua syarat agar proses pengajuan cepat dan lancar. Informasi lengkap tersedia untuk membantu pemohon memenuhi kebutuhan dokumen dengan tepat.";
		$data["prev"] = base_url("assets/images/icon_app.png");

		$data["title"] = "Permohonan dan Syarat";
		$data["rec"] = $this->fm->web_me();
		$this->load->view('permohonan_view',$data);
	}

	public function search()
    {
        $limit = 10;
   	 	$offset = (int) $this->input->post('offset', true); // default 0 jika tidak dikirim
        $keyword = $this->input->post('keyword');
       
            $list = $this->db
                ->like('nama_permohonan', $keyword)
                ->or_like('deskripsi', $keyword)
                ->order_by("urutan", "ASC")
                ->limit($limit, $offset)
                ->get("master_permohonan")
                ->result();
        

        $statistik = [];

        foreach ($list as $per) {
            $tabel = $per->nama_tabel;
           
            $per->nama_permohonan = str_ireplace($keyword, '<mark>' . $keyword . '</mark>', $per->nama_permohonan);
            $per->deskripsi = str_ireplace($keyword, '<mark>' . $keyword . '</mark>', $per->deskripsi);

            $statistik[] = [
                'id_permohonan' => $per->id_permohonan,
                'nama_permohonan' => $per->nama_permohonan,
                'icon' => $per->icon,
                'deskripsi' => $per->deskripsi,
            ];
        }
        if (empty($statistik)) {
            $data['message'] = "Tidak ada permohonan yang ditemukan.";
            $data['statistik_permohonan'] = [];
        } else {
            $data['statistik_permohonan'] = $statistik;
            $data['message'] = null;
        }
        $this->load->view('admin_permohonan/card_statistik_partial', $data);
    }

	public function cek()
	{
		$no = $this->input->post('no_registrasi');
		$query = $this->db->get_where('view_semua_paket', ['no_registrasi_pemohon' => $no]);

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$update_time = explode(" ", $row->update_time);

			$status = (int) $row->status;  
			$update_time_arr = explode(" ", $row->update_time);
			$update_time_formatted = $update_time_arr[0] . ' ' . $update_time_arr[1]; 
			$this->db->select('master_dusun.nama_dusun, lokasi.desa, lokasi.kecamatan, lokasi.kota');
			$this->db->from('master_dusun');
			$this->db->join('lokasi', 'lokasi.id_desa = master_dusun.id_desa');
			$this->db->where('master_dusun.id_dusun', $row->id_dusun);
			$query = $this->db->get();

			$alamak = $row->alamat;
			if ($query->num_rows() > 0) {
				$result = $query->row();
				$alamak = $alamak . "<br>Dusun " . $result->nama_dusun .
				" Desa " . ucwords(strtolower($result->desa)) .
				" Kecamatan " . ucwords(strtolower($result->kecamatan)) .
				" " . ucwords(strtolower($result->kota));
				$kantor = " Desa " . ucwords(strtolower($result->desa)) .
				" Kecamatan " . ucwords(strtolower($result->kecamatan)) .
				" " . ucwords(strtolower($result->kota));
			}
			echo json_encode([
				'status' => true,
				'data' => [
					'nama' => $row->nama,
					'nik' => $row->nik,
					'no_kk' => $row->no_kk,
					'nama_permohonan' => $row->nama_permohonan,
					'durasi' => hitungLamaProses($row->create_date, $row->create_time, $update_time_formatted),
					'update_time' => tgl_indo($update_time_arr[0]) . " " . $update_time_arr[1],
					'status' => $status, 
					'alamat' => $alamak,
					'kantor' => $kantor,
					'alasan_penolakan' => $row->alasan_penolakan 
				]
			]);
		} else {
			echo json_encode(['status' => false]);
		}
	}



}
