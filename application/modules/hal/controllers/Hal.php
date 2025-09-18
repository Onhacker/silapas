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

	function semua_menu(){
		$data["rec"]       = $this->fm->web_me();
		$data["title"]     = "Semua Menu";
		$data["deskripsi"] = "Semua Menu ".$data["rec"]->nama_website." ".$data["rec"]->type.".";
		$data["prev"]      = base_url("assets/images/icon_app.png");
		$this->load->view('semua_menu',$data);
	}


	function panduan(){
		$data["rec"] = $this->fm->web_me();
		$data["title"] = "Panduan Permohonan Kunjungan";
		$data["deskripsi"] = "Panduan Permohonan Kunjungan menggunakan aplikasi ".$data["rec"]->nama_website." . ".$data["rec"]->type.". .";
		$data["prev"] = base_url("assets/images/flow_icon.png");
		$this->load->view('panduan',$data);

	}

	// Pastikan di __construct() controller publik Anda:
// $this->load->model('M_pengumuman','mpg');

	public function pengumuman()
	{
	    $this->load->driver('cache', ['adapter' => 'file']);

	    $data["rec"]       = $this->fm->web_me();
	    $data["title"]     = "Pengumuman";
	    $data["deskripsi"] = "Pengumuman Pengunjung Tamu. ".$data["rec"]->type.".";
	    $data["prev"]      = base_url("assets/images/pengumuman.webp");

	    // View hanya rangka; data list diambil via AJAX /pengumuman_data
	    $this->load->view('pengumuman', $data);
	}

	/** Endpoint JSON untuk listing (AJAX) */
	public function pengumuman_data()
	{
	    $this->load->driver('cache', ['adapter' => 'file']);
	    $this->load->model('M_pengumuman','mpg');

	    $q        = trim((string)$this->input->get('q', true));
	    $page     = (int)$this->input->get('page');     if ($page <= 0) $page = 1;
	    $per_page = (int)$this->input->get('per_page'); if ($per_page <= 0) $per_page = 5;

	    // Versi dari cache admin; fallback ke DB jika belum ada
	    $ver = (int)$this->cache->get('pengumuman_ver');
	    if (!$ver) $ver = (int)$this->mpg->last_changed_fallback();

	    // ETag per kombinasi konten & query
	    $etag = 'W/"pgm-'.$ver.'-'.md5($q.'|'.$page.'|'.$per_page).'"';
	    $ifNone = trim((string)$this->input->server('HTTP_IF_NONE_MATCH'));
	    if ($ifNone === $etag) {
	        $this->output
	            ->set_status_header(304)
	            ->set_header('ETag: '.$etag)
	            ->set_header('Cache-Control: public, max-age=30, stale-while-revalidate=120');
	        return;
	    }

	    // Cache server-side untuk respon JSON (cepat!)
	    $ckey = 'pgm_list_'.$ver.'_'.md5($q).'_'.$page.'_'.$per_page;
	    $payload = $this->cache->get($ckey);
	    if ($payload === false) {
	        list($rows, $total) = $this->mpg->list_with_total($q, $page, $per_page);

	        $items = [];
	        foreach ($rows as $r) {
	            $excerpt = $this->_excerpt(strip_tags(html_entity_decode($r['isi'] ?? '', ENT_QUOTES, 'UTF-8')), 180);
	            $items[] = [
	                'id'       => (int)$r['id'],
	                'judul'    => $r['judul'],
	                'tanggal'  => date('d M Y', strtotime($r['tanggal'])),
	                'excerpt'  => $excerpt,
	            ];
	        }

	        $pages = max(1, (int)ceil($total / $per_page));
	        $payload = [
	            'success' => true,
	            'q'       => $q,
	            'page'    => $page,
	            'perPage' => $per_page,
	            'pages'   => $pages,
	            'total'   => $total,
	            'items'   => $items,
	        ];
	        // Simpan 10 menit (aman—admin purge akan menghapus juga)
	        $this->cache->save($ckey, $payload, 600);
	    }

	    $this->output
	        ->set_content_type('application/json')
	        ->set_header('ETag: '.$etag)
	        ->set_header('Cache-Control: public, max-age=30, stale-while-revalidate=120')
	        ->set_output(json_encode($payload));
	}

	/** Detail pengumuman publik */
	public function detail_pengumuman($id = null)
	{
	    $this->load->driver('cache', ['adapter' => 'file']);
	    $this->load->model('M_pengumuman','mpg');

	    $id = (int)$id;
	    $row = $this->mpg->get_one($id);
	    if (!$row) { show_404(); return; }

	    // Meta
	    $desc = $this->_excerpt(strip_tags(html_entity_decode($row->isi ?? '', ENT_QUOTES, 'UTF-8')), 160);

	    $data["rec"]       = $this->fm->web_me();
	    $data["title"]     = $row->judul;
	    $data["deskripsi"] = $desc;
	    $data["prev"]      = base_url("assets/images/pengumuman.webp");
	    $data["item"]      = $row;

	    // ETag per detail
	    $etag = 'W/"pgm-detail-'.$row->id.'-'.md5($row->judul.'|'.$row->tanggal.'|'.sha1($row->isi)).'"';
	    $ifNone = trim((string)$this->input->server('HTTP_IF_NONE_MATCH'));
	    if ($ifNone === $etag) {
	        $this->output
	            ->set_status_header(304)
	            ->set_header('ETag: '.$etag)
	            ->set_header('Cache-Control: public, max-age=60, stale-while-revalidate=300');
	        return;
	    }

	    $this->output
	         ->set_header('ETag: '.$etag)
	         ->set_header('Cache-Control: public, max-age=60, stale-while-revalidate=300');

	    $this->load->view('pengumuman_detail', $data);
	}

	/** Helper ringkas potong teks */
	private function _excerpt(string $text, int $limit = 160): string
	{
	    $text = trim(preg_replace('/\s+/u',' ', $text));
	    if (mb_strlen($text) <= $limit) return $text;
	    $cut = mb_substr($text, 0, $limit);
	    // potong di spasi terdekat
	    $sp  = mb_strrpos($cut, ' ');
	    if ($sp !== false) $cut = mb_substr($cut, 0, $sp);
	    return rtrim($cut, ",.;:-— ").'…';
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
	    $nocache = ($this->input->get('nocache') === '1');

	    // nocache=1 -> driver dummy (tak menyimpan apa pun)
	    $this->load->driver('cache', ['adapter' => $nocache ? 'dummy' : 'file']);
	    $this->load->model('M_organisasi', 'mu');

	    // ETag berbasis versi data
	    $last = (int) $this->mu->last_changed(); // epoch ts; fallback 0
	    $etag = 'W/"unit-tree-'.$last.'"';

	    // 304 jika tidak berubah (skip jika nocache=1)
	    if (!$nocache) {
	        $ifNone = trim((string) $this->input->server('HTTP_IF_NONE_MATCH'));
	        if ($ifNone === $etag) {
	            $this->output
	                ->set_status_header(304)
	                ->set_header('ETag: '.$etag)
	                // ==== Tidak ada TTL klien; selalu revalidate ====
	                ->set_header('Cache-Control: no-cache, must-revalidate, max-age=0, s-maxage=0, proxy-revalidate')
	                ->set_header('Pragma: no-cache')
	                ->set_header('Expires: 0');
	            return;
	        }
	    }

	    // Cache server-side “selamanya”
	    $cacheKey = 'unit_tree';

	    if ($nocache) {
	        $rows = $this->mu->get_all();
	        $tree = $this->build_tree_fast($rows);
	        $this->sort_tree_custom($tree);
	    } else {
	        $tree = $this->cache->get($cacheKey);
	        if ($tree === false) {
	            $rows = $this->mu->get_all();
	            $tree = $this->build_tree_fast($rows);
	            $this->sort_tree_custom($tree);
	            $this->cache->save($cacheKey, $tree, 0); // TTL=0 => permanen (sampai di-invalidate admin)
	        }
	    }

	    $rec = $this->fm->web_me();
	    $data = [
	        'controller' => get_class($this),
	        'deskripsi'  => 'Struktur Organisasi ' . ($rec->type ?? ''),
	        'prev'       => base_url('assets/images/struktur_organisasi.webp'),
	        'title'      => 'Struktur Organisasi',
	        'rec'        => $rec,
	        'tree'       => $tree,
	    ];

	    // ==== Tidak ada TTL klien; selalu revalidate (perubahan langsung terlihat) ====
	    $this->output
	        ->set_header('ETag: '.$etag)
	        ->set_header('Cache-Control: no-cache, must-revalidate, max-age=0, s-maxage=0, proxy-revalidate')
	        ->set_header('Pragma: no-cache')
	        ->set_header('Expires: 0');

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
/** urutkan tree: root -> 'Kepala Lapas' (atau 'Kalapas') dulu, sisanya alfabetis; anak tetap alfabetis */
private function sort_tree_custom(array &$nodes, int $depth = 0): void {
    usort($nodes, function($a, $b) use ($depth) {
        if ($depth === 0) {
            $pa = $this->is_kalapas($a->nama_unit ?? '') ? 0 : 1;
            $pb = $this->is_kalapas($b->nama_unit ?? '') ? 0 : 1;
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

/** match variasi nama "Kepala Lapas" secara robust */
private function is_kalapas(string $nama): bool {
    $n = mb_strtolower(trim($nama), 'UTF-8');
    // match "kepala lapas", "kalapas", atau "kepala lembaga pemasyarakatan"
    return (bool) preg_match('~\b(kepala\s+lapas|kalapas|kepala\s+lembaga\s+pemasyarakatan)\b~u', $n);
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
