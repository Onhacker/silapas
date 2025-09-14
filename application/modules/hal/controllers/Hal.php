<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hal extends MX_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper("front");
		$this->load->model("front_model",'fm');
	}

	function index(){
		$data["rec"] = $this->fm->web_me();
		$data["title"] = "Syarat dan Ketentuan";
		$data["deskripsi"] = "Dokumen ini mengatur ketentuan penggunaan aplikasi/laman ".$data["rec"]->nama_website." ".$data["rec"]->kabupaten." (“Aplikasi”). Dengan membuat booking, menggunakan fitur check-in/check-out, atau mengakses Aplikasi, Anda (“Pengguna”) menyatakan telah membaca, memahami, dan menyetujui Syarat & Ketentuan ini.";
		$data["prev"] = base_url("assets/images/icon_app.png");
		
		$this->load->view('hal_syarat',$data);

	}

	function jadwal(){
		$data["rec"] = $this->fm->web_me();
		$data["title"] = "Jadwal Kunjungan";
		$data["deskripsi"] = "Jadwal Kunjungan Tamu ".$data["rec"]->type.". .";
		$data["prev"] = base_url("assets/images/icon_app.png");
		$this->load->view('jadwal',$data);

	}

	function panduan(){
		$data["rec"] = $this->fm->web_me();
		$data["title"] = "Panduan Permohonan Kunjungan";
		$data["deskripsi"] = "Panduan Permohonan Kunjungan menggunakan aplikasi SILATURAHMI. ".$data["rec"]->type.". .";
		$data["prev"] = base_url("assets/images/flow_icon.png");
		$this->load->view('panduan',$data);

	}

	function alur(){
		$data["rec"] = $this->fm->web_me();
		$data["title"] = "Alur Permohonan Kunjungan";
		$data["deskripsi"] = "Alur permohonan Kunjungan ".$data["rec"]->nama_website." ".$data["rec"]->kabupaten." merupakan rangkaian tahapan yang harus dilalui oleh pemohon untuk mengajukan suatu permohonan kunjungan kepada Lapas Kelas I Makassar.";
		$data["prev"] = base_url("assets/images/flow_icon.jpg");
		
		$this->load->view('hal_view',$data);
	}

	function privacy_policy(){
		$data["title"] = "Privacy Policy";
		$data["deskripsi"] = "Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi data pribadi pengguna";
		$data["prev"] = base_url("assets/images/flow_icon.jpg");
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

	public function struktur()
{
    // === toggle dev: ?nocache=1 akan mem-bypass seluruh mekanisme cache ===
    $nocache = ($this->input->get('nocache') === '1');

    // Saat nocache=1 pakai driver dummy (tidak menyimpan apa pun)
    $this->load->driver('cache', ['adapter' => $nocache ? 'dummy' : 'file']);
    $this->load->model('M_organisasi', 'mu');

    // versi data berdasar last change -> dipakai untuk cache & ETag
    $last = (int) $this->mu->last_changed(); // epoch ts; fallback 0
    $etag = 'W/"unit-tujuan-'.$last.'"';

    // 304 jika tidak berubah (skip jika nocache=1)
    if (!$nocache) {
        $ifNone = trim((string) $this->input->server('HTTP_IF_NONE_MATCH'));
        if ($ifNone === $etag) {
            $this->output
                ->set_status_header(304)
                ->set_header('ETag: '.$etag)
                ->set_header('Cache-Control: public, max-age=60, stale-while-revalidate=120');
            return;
        }
    }

    $cacheKey = 'unit_tujuan_tree_'.$last;

    if ($nocache) {
        // Selalu rebuild dari DB, tanpa get/save cache
        $rows = $this->mu->get_all();            // SELECT ringan + ORDER
        $tree = $this->build_tree_fast($rows);         // O(n)
        $this->sort_tree_by_name($tree);               // urutkan agar rapi
    } else {
        // Jalur normal dengan cache
        $tree = $this->cache->get($cacheKey);
        if ($tree === false) {
            $rows = $this->mu->get_all();
            // $tree = $this->build_tree_fast($rows);
            // $this->sort_tree_by_name($tree);
            $tree = $this->build_tree_fast($rows);
$this->sort_tree_custom($tree); // <-- ganti dari sort_tree_by_name()

            $this->cache->save($cacheKey, $tree, 300); // 5 menit
        }
    }

    $data = [
        'controller' => get_class($this),
        'deskripsi'  => 'Struktur Organisasi '.$this->fm->web_me()->type,
        'prev'       => base_url('assets/images/struktur_organisasi.webp'),
        'title'      => 'Struktur Organisasi',
        'rec'        => $this->fm->web_me(),
        'tree'       => $tree,
    ];

    // // Header respons sesuai mode
    // if ($nocache) {
    //     $this->output
    //         ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
    //         ->set_header('Pragma: no-cache')
    //         ->set_header('Expires: 0');
    // } else {
    //     $this->output
    //         ->set_header('ETag: '.$etag)
    //         ->set_header('Cache-Control: public, max-age=60, stale-while-revalidate=120');
    // }

    $this->load->view('organisasi_view', $data);
}


/** O(n): bangun tree cepat dari rows datar tabel unit_tujuan */
private function build_tree_fast(array $rows): array {
    $byId = [];
    $tree = [];
    foreach ($rows as $r) { $r->children = []; $byId[$r->id] = $r; }
    foreach ($rows as $r) {
        $pid = $r->parent_id;
        if (!empty($pid) && isset($byId[$pid])) $byId[$pid]->children[] = $r;
        else $tree[] = $r; // root (parent_id NULL/0)
    }
    return $tree;
}

/** urutkan per nama_unit lalu id (ubah kalau mau) */
private function sort_tree_by_name(array &$nodes): void {
    usort($nodes, function($a,$b){
        $c = strcasecmp($a->nama_unit ?? '', $b->nama_unit ?? '');
        return $c ?: ($a->id <=> $b->id);
    });
    foreach ($nodes as $n) if (!empty($n->children)) $this->sort_tree_by_name($n->children);
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

    /** urutkan tree: root -> 'Kepala Lapas' dulu, sisanya alfabetis; anak tetap alfabetis */
private function sort_tree_custom(array &$nodes, int $depth = 0): void {
    usort($nodes, function($a, $b) use ($depth) {
        // Hanya di depth 0 (root) kita prioritaskan 'Kepala Lapas'
        if ($depth === 0) {
            $pa = (strcasecmp($a->nama_unit ?? '', 'Kepala Lapas') === 0) ? 0 : 1;
            $pb = (strcasecmp($b->nama_unit ?? '', 'Kepala Lapas') === 0) ? 0 : 1;
            if ($pa !== $pb) return $pa <=> $pb;
        }
        // Default: alfabetis nama_unit, lalu id
        $c = strcasecmp($a->nama_unit ?? '', $b->nama_unit ?? '');
        return $c ?: ($a->id <=> $b->id);
    });
    foreach ($nodes as $n) {
        if (!empty($n->children)) $this->sort_tree_custom($n->children, $depth + 1);
    }
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
