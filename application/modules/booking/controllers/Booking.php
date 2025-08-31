<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('front');
        $this->load->model('front_model','fm');
        $this->load->model('M_booking','mb');
      
    }

    public function index()
    {
        $data["controller"] = get_class($this);
        $data["title"]      = "Booking Kunjungan Tamu";
        $data["deskripsi"]  = "Pemohon dapat memantau status permohonan secara real-time mulai dari pengajuan hingga selesai diproses. Fitur ini memudahkan pemantauan dan memastikan transparansi pelayanan";
        $data["prev"]       = base_url("assets/images/track.png");

        $data['units_tree'] = $this->mb->get_tree(); // pohon unit
        $data["rec"]        = $this->fm->web_me();

        $this->load->view('booking_view', $data);
    }

    public function booked()
    {
    	$token = $this->input->get('t', TRUE);
    	if (!$token) { return $this->_booked_error("Link tidak valid."); }

    // ambil booking berdasar token
    	$booking = $this->db->get_where('booking_tamu', ['access_token' => $token])->row();

    	if (!$booking) {
    		return $this->_booked_error("Link tidak valid.");
    	}
    	if ((int)$booking->token_revoked === 1) {
    		return $this->_booked_error("Link sudah tidak berlaku (token dicabut).");
    	}
    	if (!empty($booking->checkout_at)) {
        // setelah checkout → token otomatis hangus
    		$wkt = date('d-m-Y H:i', strtotime($booking->checkout_at));
    		return $this->_booked_error("Link tidak berlaku. Anda telah checkout pada {$wkt}.");
    	}

    // token masih valid → tampilkan detail
    	$data = [
    		"controller" => get_class($this),
    		"title"      => "Detail Booking",
    		"deskripsi"  => "Detail",
    		"booking"    => $booking,
    		"rec" => $this->fm->web_me(),
    		"prev" => base_url("assets/images/track.png"),
    	];
    	$this->load->view('booking_detail', $data);
    }

  

	private function _booked_error($msg)
	{
	    // Kamu bisa pakai view terpisah (booking_expired) atau SweetAlert, ini contoh sederhana:
	    $data = [
	        "controller" => get_class($this),
	        "title"      => "Link Tidak Berlaku",
	        "deskripsi"  => $msg
	    ];
	    $this->load->view('booking_error', $data);
	}


public function add(){
    $data = $this->input->post(NULL, TRUE);
    $this->load->library('form_validation');

    $this->_set_rules();
    if ($this->form_validation->run() == FALSE) {
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                "success"=>false,"title"=>"Validasi Gagal","pesan"=>validation_errors()
            ]));
    }

    // 1) Validasi tanggal & jam
    [$ok, $tanggal, $jam, $err] = $this->_validate_jadwal($data['tanggal'], $data['jam']);
    if (!$ok) {
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>$err]));
    }

    // 2) Pendamping vs unit_tujuan
    $unit_id = (int)$data['unit_tujuan'];
    $diminta = (int)$data['jumlah_pendamping'];
    [$ok, $unit_nama, $err] = $this->_validate_pendamping($unit_id, $diminta);
    if (!$ok) {
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(["success"=>false,"title"=>"Melebihi Batas Pendamping","pesan"=>$err]));
    }

    // 3) Instansi asal
    $kategori   = $this->input->post('kategori', true);
    $instansiId = (int)$this->input->post('instansi_id', true);
    [$ok, $instansiNama, $err] = $this->_resolve_instansi_asal($kategori, $instansiId);
    if (!$ok) {
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>$err]));
    }

    // 4) Kode & token (langsung ikut di insert)
    $kode_booking = $this->_make_kode_booking();
    $access_token = bin2hex(random_bytes(24));

    // 5) Upload opsional
    $surat_tugas = NULL;
    if (!empty($_FILES['surat_tugas']['name'])) {
        $surat_tugas = $this->_upload('surat_tugas', './uploads/surat_tugas/', 'pdf|jpg|jpeg|png', 2048, 'surat_tugas');
        if ($surat_tugas === NULL) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode([
                    "success"=>false,"title"=>"Upload Gagal",
                    "pesan"=>$this->get_last_upload_error() ?: "Surat tugas melebihi batas ukuran (2MB)."
                ]));
        }
    }
    $foto = NULL;
    if (!empty($_FILES['foto']['name'])) {
        $foto = $this->_upload('foto', './uploads/foto/', 'jpg|jpeg|png', 1536, 'foto');
        if ($foto === NULL) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode([
                    "success"=>false,"title"=>"Upload Gagal",
                    "pesan"=>$this->get_last_upload_error() ?: "Foto melebihi batas ukuran (1.5MB)."
                ]));
        }
    }
    // 5.x) Ambil nama petugas instansi (pejabat unit tujuan) dari tabel unit_tujuan
    $nama_petugas_instansi = NULL;
    $unit = $this->db->select('nama_pejabat, nama_unit')
    ->from('unit_tujuan')
    ->where('id', $unit_id)
    ->limit(1)
    ->get()
    ->row();

    if ($unit) {
    	$nama_petugas_instansi = !empty($unit->nama_pejabat) ? trim($unit->nama_pejabat) : NULL;
    // (opsional) kalau Anda ingin fallback nama asal instansi dari unit_tujuan saat $instansiNama kosong:
    // if (empty($instansiNama) && !empty($unit->nama_unit)) {
    //     $instansiNama = $unit->nama_unit;
    // }
    } else {
    // (opsional) kalau unit_id tidak valid, bisa kembalikan error
    // return $this->output->set_content_type('application/json')
    //     ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>"Unit tujuan tidak ditemukan."]));
    }

    // 6) INSERT — sekali saja
    $insert = [
        "kode_booking"          => $kode_booking,
        "nama_tamu"             => $data['nama_tamu'],
        "jabatan"               => $data['jabatan'],
        "nik"                   => $data['nik'],
        "no_hp"                 => $data['no_hp'],
        "instansi"              => $data['instansi'] ?? NULL,
        "unit_tujuan"           => $unit_id,
        "target_kategori"       => $kategori,
        "target_instansi_id"    => $instansiId,
        "nama_petugas_instansi" => $nama_petugas_instansi,
        "target_instansi_nama"  => $instansiNama,
        "keperluan"             => $data['keperluan'] ?? NULL,
        "surat_tugas"           => $surat_tugas,
        "jumlah_pendamping"     => $diminta,
        "tanggal"               => $tanggal,
        "jam"                   => $jam,
        "foto"                  => $foto,
        "status"                => "approved",
        "access_token"          => $access_token,
        "token_issued_at"       => date('Y-m-d H:i:s'),
        "token_revoked"         => 0
    ];
    if (!$this->db->insert("booking_tamu", $insert)) {
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                "success"=>false,"title"=>"Gagal Menyimpan","pesan"=>"Terjadi kendala saat menyimpan data booking."
            ]));
    }

    // 7) QR + redirect
    $qr_url       = $this->_make_qr($kode_booking);
    $redirect_url = site_url('booking/booked?t='.urlencode($access_token));

    // 8) Balas JSON (biar FE bisa redirect cepat)
    return $this->output->set_content_type('application/json')
        ->set_output(json_encode([
            "success"      => true,
            "title"        => "Booking Berhasil",
            "pesan"        => "Kunjungan berhasil didaftarkan.<br>Kode Booking: <b>".$kode_booking."</b>",
            "kode_booking" => $kode_booking,
            "qr_url"       => $qr_url,
            "redirect_url" => $redirect_url
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
}


// =========================
// Helpers (private methods)
// =========================
public function wa_notify()
{
    $token = $this->input->post('t', TRUE) ?: $this->input->get('t', TRUE);
    if (!$token) return $this->json_exit(['ok'=>false,'err'=>'missing token'], 422);

    $b = $this->db->get_where('booking_tamu', ['access_token' => $token])->row();
    if (!$b) return $this->json_exit(['ok'=>false,'err'=>'not found'], 404);

    if ((int)$b->token_revoked === 1)    return $this->json_exit(['ok'=>true,'skip'=>'token revoked']);
    if (!empty($b->checkout_at))         return $this->json_exit(['ok'=>true,'skip'=>'already checkout']);

    // ---------- kirim WA ke TAMU (sekali saja) ----------
    $unit_nama_db = $this->db->select('nama_unit')->get_where('unit_tujuan', ['id'=>$b->unit_tujuan])->row('nama_unit');
    $qr_url   = base_url('uploads/qr/qr_'.$b->kode_booking.'.png');
    $redir    = site_url('booking/booked?t='.urlencode($b->access_token));
    $instansi = $b->target_instansi_nama ?: ($b->instansi ?: '-');

    if (empty($b->wa_sent_at)) {
        $ok_user = $this->_send_wa_konfirmasi($b->no_hp, [
            'nama'          => $b->nama_tamu,
            'nama_petugas_instansi'          => $b->nama_petugas_instansi,
            'kode'          => $b->kode_booking,
            'instansi_asal' => $instansi,
            'unit_tujuan'   => $unit_nama_db ?: '-',
            'tanggal'       => $b->tanggal,
            'jam'           => $b->jam,
            'qr_url'        => $qr_url,
            'redirect_url'  => $redir,
            'keperluan'     => $b->keperluan ?: '-',
        ]);
        if ($ok_user) {
            $this->db->where('access_token', $token)
                     ->where('wa_sent_at IS NULL', NULL, FALSE)
                     ->update('booking_tamu', ['wa_sent_at' => date('Y-m-d H:i:s')]);
        }
    }

    // ---------- kirim WA ke UNIT TUJUAN (sekali saja) ----------
    // cari no HP unit
    [$hp_unit, $unit_nama] = $this->_get_unit_contact((int)$b->unit_tujuan);

    if (!empty($hp_unit)) {
        // Cek apakah tabel punya kolom wa_unit_sent_at untuk idempotensi
        $can_stamp_unit = $this->db->field_exists('wa_unit_sent_at', 'booking_tamu');

        $should_send_unit = true;
        if ($can_stamp_unit && !empty($b->wa_unit_sent_at)) {
            $should_send_unit = false; // sudah pernah kirim
        }

        if ($should_send_unit) {
            $ok_unit = $this->_send_wa_info_unit($hp_unit, [
                'kode'          => $b->kode_booking,
                'nama'          => $b->nama_tamu,
                'instansi_asal' => $instansi,
                'unit_nama'     => $unit_nama ?: ($unit_nama_db ?: '-'),
                'tanggal'       => $b->tanggal,
                'jam'           => $b->jam,
                'pendamping'    => (int)$b->jumlah_pendamping,
                'keperluan'     => $b->keperluan ?: '-',
                'redirect_url'  => $redir,
            ]);

            if ($ok_unit && $can_stamp_unit) {
                $this->db->where('access_token', $token)
                         ->where('wa_unit_sent_at IS NULL', NULL, FALSE)
                         ->update('booking_tamu', ['wa_unit_sent_at' => date('Y-m-d H:i:s')]);
            }
        }
    } else {
        log_message('debug', 'No HP Unit tidak tersedia untuk unit_id='.$b->unit_tujuan);
    }

    return $this->json_exit(['ok'=>true]);
}

// --- JSON helpers ---
private function json_exit($payload, int $status = 200, array $headers = [])
{
    if (!is_string($payload)) {
        $payload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    foreach ($headers as $k => $v) {
        $this->output->set_header($k.': '.$v);
    }
    $this->output
        ->set_status_header($status)
        ->set_content_type('application/json', 'utf-8')
        ->set_output($payload)
        ->_display();
    exit; // stop total agar tidak double output
}

/**
 * Kirim JSON ke client lalu lanjut proses server (untuk kirim WA, log, dsb).
 */
private function json_flush($payload, int $status = 200, array $headers = [])
{
    if (!is_string($payload)) {
        $payload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    foreach ($headers as $k => $v) {
        $this->output->set_header($k.': '.$v);
    }
    $this->output
        ->set_status_header($status)
        ->set_content_type('application/json', 'utf-8')
        ->set_output($payload)
        ->_display();

    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request(); // PHP-FPM: tutup koneksi ke client
    } else {
        @ob_end_flush(); @flush(); // fallback umum
    }
    // Tidak exit: eksekusi lanjut
}

/** helper response JSON ringkas */
private function _json(array $payload, int $status = 200)
{
    return $this->output
        ->set_status_header($status)
        ->set_content_type('application/json; charset=utf-8')
        ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
}


private function _set_rules(){
    $this->form_validation->set_rules('nama_tamu','Nama Tamu','required');
    $this->form_validation->set_rules('no_hp','No HP','required|numeric|min_length[10]|max_length[13]');

    // Wajib: Jabatan & NIK
    $this->form_validation->set_rules('jabatan','Jabatan','required|trim');
    $this->form_validation->set_rules('nik','NIK','required|numeric|exact_length[16]');

    // Tujuan internal Lapas (selalu wajib)
    $this->form_validation->set_rules('unit_tujuan','Unit Tujuan','required|integer');

    // Asal pengunjung
    $this->form_validation->set_rules('kategori','Kategori Asal',
        'required|in_list[opd,pn,pa,ptun,kejari,cabjari,bnn,kodim,kejati]');
    $this->form_validation->set_rules('instansi_id','Instansi Asal','required|integer');

    // Jadwal
    $this->form_validation->set_rules('tanggal','Tanggal','required'); // Y-m-d
    $this->form_validation->set_rules('jam','Jam','required');         // HH:MM
    $this->form_validation->set_rules('jumlah_pendamping','Jumlah Pendamping','required|is_natural');

    // Pesan
    $this->form_validation->set_message('required', '* %s Harus diisi ');
    $this->form_validation->set_message('numeric',  '* %s harus berupa angka');
    $this->form_validation->set_message('exact_length', '* %s harus berjumlah %s digit');
    $this->form_validation->set_message('is_natural', '* %s harus berupa angka >= 0');
    $this->form_validation->set_error_delimiters('<br> ', ' ');
}

/**
 * @return array [$ok,bool, $tanggalYmd,string, $jamHHmm,string, $errorHtml,string]
 */
private function _validate_jadwal($tanggal, $jam_raw){
    $errors = [];
    $tanggal = trim((string)$tanggal);
    $jam_raw = trim((string)$jam_raw);
    $jam = null;

    $dt = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!$dt || $dt->format('Y-m-d') !== $tanggal) {
        $errors[] = '* Tanggal tidak valid (format harus YYYY-MM-DD).';
    } else {
        $today = date('Y-m-d');
        if (strtotime($tanggal) < strtotime($today)) {
            $errors[] = '* Tanggal tidak boleh mundur (minimal hari ini).';
        }
        $hari = (int) date('w', strtotime($tanggal)); // 0=Min
        if ($hari === 0) $errors[] = '* Hari Minggu libur, tidak bisa booking.';

        if ($jam_raw === '') {
            $errors[] = '* Jam Harus diisi ';
        } else {
            $jam_norm = str_replace('.', ':', $jam_raw);
            $jam_norm = preg_replace('/\s+/', '', $jam_norm);
            if (!preg_match('/^(?:[01]?\d|2[0-3]):[0-5]\d$/', $jam_norm)) {
                $errors[] = '* Format jam tidak valid (pakai HH:MM, contoh 16:55).';
            } else {
                list($hh, $mm) = explode(':', $jam_norm);
                $hh = (int)$hh; $mm=(int)$mm;
                $jam = sprintf('%02d:%02d', $hh, $mm);
                $menit = $hh*60+$mm;
                if ($hari >= 1 && $hari <= 4) { $min=480; $max=900; }      // Sen–Kam 08:00–15:00
                elseif ($hari === 5)          { $min=480; $max=840; }      // Jum    08:00–14:00
                else                          { $min=480; $max=690; }      // Sab    08:00–11:30

                if ($menit < $min || $menit > $max) {
                    $errors[] = '* Jam kunjungan tidak sesuai dengan jadwal operasional.';
                }
            }
        }
    }

    if ($errors) return [false, null, null, '<br> '.implode('<br> ', $errors)];
    return [true, $tanggal, $jam, ''];
}

/**
 * @return array [$ok,bool, $unit_nama,string, $errorHtml,string]
 */
private function _validate_pendamping($unit_id, $diminta){
    $row = $this->db->select('nama_unit, jumlah_pendamping')
                    ->get_where('unit_tujuan', ['id' => (int)$unit_id]) // sesuaikan PK
                    ->row();
    $unit_nama = $row ? $row->nama_unit : '-';
    $batas     = $row ? $row->jumlah_pendamping : null; // null = tidak dibatasi

    if ($batas !== null && (int)$diminta > (int)$batas) {
        $err = sprintf('Unit tujuan <b>%s</b> membatasi pendamping maksimal <b>%d</b>. Anda mengajukan <b>%d</b>.',
                        $unit_nama, (int)$batas, (int)$diminta);
        return [false, $unit_nama, $err];
    }
    return [true, $unit_nama, ''];
}

/**
 * @return array [$ok,bool, $instansiNama,string, $errorHtml,string]
 */
private function _resolve_instansi_asal($kategori, $instansiId){
    $map = $this->_kategori_map();
    if (!isset($map[$kategori])) {
        return [false, '', 'Kategori asal tidak dikenal.'];
    }
    $cfg = $map[$kategori];

    $this->db->select($cfg['text'].' AS nama', false)
             ->from($cfg['table'])
             ->where($cfg['id'], (int)$instansiId);
    if ($this->db->field_exists('aktif', $cfg['table'])) {
        $this->db->where('aktif', 1);
    }
    $row = $this->db->get()->row();
    if (!$row) return [false, '', 'Instansi asal tidak ditemukan / tidak aktif pada kategori terpilih.'];
    return [true, $row->nama, ''];
}

private function _kategori_map(){
    return [
        'opd'    => ['table'=>'opd_sulsel',               'id'=>'id_opd',    'text'=>'nama_opd'],
        'pn'     => ['table'=>'pengadilan_negeri_sulsel', 'id'=>'id_pn',     'text'=>'nama_pn'],
        'pa'     => ['table'=>'pengadilan_agama_sulsel',  'id'=>'id_pa',     'text'=>'nama_pa'],
        'ptun'   => ['table'=>'pengadilan_tun_sulsel',    'id'=>'id_ptun',   'text'=>'nama_ptun'],
        'kejari' => ['table'=>'kejaksaan_negeri_sulsel',  'id'=>'id_kejari', 'text'=>'nama_kejari'],
        'cabjari'=> ['table'=>'kejari_cabang_sulsel',     'id'=>'id_cabjari','text'=>"CONCAT(nama_cabang,' – ',lokasi)"],
        'bnn'    => ['table'=>'bnn_sulsel',               'id'=>'id_bnn',    'text'=>'nama_unit'],
        'kodim'  => ['table'=>'kodim_sulawesi',           'id'=>'id_kodim',  'text'=>'label'],
        'kejati' => ['table'=>'kejaksaan_tinggi_sulsel',  'id'=>'id_kejati', 'text'=>'nama_kejati'],
    ];
}

private function _make_kode_booking(int $rand_len = 6): string

// private function _make_kode_booking($tanggal, $unit_id, $kategori, $instansiId)
{
    // $tglYmd = date("Ymd", strtotime($tanggal));
    // return $tglYmd . "-U{$unit_id}-{$kategori}-{$instansiId}-" . rand(100,999);
     // prefix tanggal (YYMMDD)
    $prefix = date('ymd');

    // fungsi pembuat n-digit acak yang benar-benar random (cryptographically secure)
    $rand_digits = function(int $len){
        $out = '';
        for ($i=0; $i<$len; $i++) {
            $out .= (string) random_int(0, 9);
        }
        return $out;
    };

    // coba beberapa kali sampai unik
    for ($try=0; $try<10; $try++) {
        $code = $prefix . $rand_digits($rand_len);

        $exists = $this->db->select('1', false)
            ->from('booking_tamu')
            ->where('kode_booking', $code)
            ->limit(1)->get()->num_rows() > 0;

        if (!$exists) return $code;
    }

    // fallback: tambahkan 3 digit ekstra kalau 10x masih tabrakan (sangat kecil kemungkinannya)
    return $prefix . $rand_digits($rand_len + 3);
}

/**
 * @return string|null nama file tersimpan atau NULL jika tidak ada upload/ gagal
 */
// Simpan pesan terakhir biar bisa diambil di controller (opsional)
private $last_upload_error = null;

public function get_last_upload_error() {
    return $this->last_upload_error;
}

// Simpan pesan error terakhir (opsional)
// private $last_upload_error = null;
// public function get_last_upload_error(){ return $this->last_upload_error; }

/**
 * Upload dengan prefix nama file per field:
 * contoh:
 *  - field 'surat_tugas' -> surat_tugas_20250826_162233_ab12cd.pdf
 *  - field 'foto'        -> foto_20250826_162233_ab12cd.jpg
 */
private function _upload($field, $path, $types, $max_kb = 2048, $prefix = null)
{
    $this->last_upload_error = null;

    if (empty($_FILES[$field]['name'])) return NULL;
    if (!is_dir($path)) { @mkdir($path, 0755, true); }

    // ==== Guard ukuran manual (KB) sebelum CI Upload ====
    if (isset($_FILES[$field]['size'])) {
        $sizeKB = (int)ceil($_FILES[$field]['size'] / 1024);
        if ($sizeKB > (int)$max_kb) {
            $this->last_upload_error = sprintf(
                'Ukuran file %s %dKB melebihi batas %dKB.',
                htmlspecialchars($_FILES[$field]['name'], ENT_QUOTES, 'UTF-8'),
                $sizeKB, (int)$max_kb
            );
            log_message('error', '[UPLOAD] Ditolak (terlalu besar): '.$this->last_upload_error);
            return NULL;
        }
    }

    // Tentukan prefix nama file
    if ($prefix === null) {
        // default: pakai nama field yang disanitasi
        $prefix = preg_replace('/[^a-z0-9_]+/i', '_', strtolower($field));
    }

    // Ambil ekstensi asli & buat nama baru
    $origName = $_FILES[$field]['name'];
    $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION)); // tanpa titik
    // random suffix pendek
    $rand6    = function_exists('random_bytes') ? bin2hex(random_bytes(3)) : substr(md5(uniqid('', true)), 0, 6);
    $fname    = sprintf('%s_%s_%s.%s', $prefix, date('Ymd_His'), $rand6, $ext);

    // Konfigurasi CI Upload
    $config = [
        'upload_path'      => $path,
        'allowed_types'    => $types,   // contoh: 'pdf|jpg|jpeg|png'
        'max_size'         => $max_kb,  // KB (guard kedua oleh CI)
        'file_name'        => $fname,   // sudah termasuk ekstensi
        'overwrite'        => false,
        'remove_spaces'    => true,
        'file_ext_tolower' => true,
        'encrypt_name'     => false,    // kita sudah pakai nama custom
    ];

    if (!isset($this->upload)) { $this->load->library('upload'); }
    $this->upload->initialize($config);

    if ($this->upload->do_upload($field)) {
        return $fname; // sukses → kembalikan nama file baru
    }

    // error dari CI upload
    $err = $this->upload->display_errors('', '');
    $this->last_upload_error = $err ?: 'Gagal mengunggah berkas.';
    log_message('error', '[UPLOAD] Gagal '.$field.': '.$this->last_upload_error);
    return NULL;
}



/**
 * @return string URL QR
 */
private function _make_qr($kode_booking, $with_logo = true)
{
    $this->load->library('ciqrcode');
    $dir = './uploads/qr/';
    if (!is_dir($dir)) { @mkdir($dir, 0755, true); }

    $file = 'qr_'.$kode_booking.'.png';

    // Gunakan EC level H agar tetap mudah discan meski ada logo
    $this->ciqrcode->generate([
        'data'     => $kode_booking,
        'level'    => 'H',
        'size'     => 10,
        'savename' => $dir.$file
    ]);

    if ($with_logo) {
        $logo_path = FCPATH.'assets/images/logo.png'; // pakai PNG transparan jika ada
        if (is_file($logo_path)) {
            // scale 0.22 = lebar logo ±22% dari lebar QR; TANPA padding/overlay
            $this->_qr_overlay_logo($dir.$file, $logo_path, 0.22, false);
        }
    }

    return base_url('uploads/qr/'.$file);
}

/**
 * Overlay logo ke tengah QR.
 * @param string $qrPath    Path PNG QR (akan dioverwrite)
 * @param string $logoPath  Path logo (png/jpg)
 * @param float  $scale     Lebar logo relatif lebar QR (0.18–0.28 aman)
 * @param bool   $withWhitePad  Tambah bantalan putih di belakang logo
 */
private function _qr_overlay_logo($qrPath, $logoPath, $scale = 0.22, $unused = false)
{
    if (!extension_loaded('gd')) { log_message('error','GD tidak aktif'); return; }

    $qr = @imagecreatefrompng($qrPath);
    if (!$qr) { log_message('error','Gagal buka QR'); return; }
    imagealphablending($qr, true); imagesavealpha($qr, true);
    $qrW = imagesx($qr); $qrH = imagesy($qr);

    $ext = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
    $logo = ($ext === 'png') ? @imagecreatefrompng($logoPath)
           : (($ext==='jpg'||$ext==='jpeg') ? @imagecreatefromjpeg($logoPath) : null);
    if (!$logo) { imagedestroy($qr); log_message('error','Gagal buka logo'); return; }
    imagealphablending($logo, true); imagesavealpha($logo, true);

    $logoW = imagesx($logo); $logoH = imagesy($logo);
    $targetW = max(20, (int)round($qrW * $scale));
    $ratio = $targetW / $logoW;
    $targetH = (int)round($logoH * $ratio);

    $logoResized = imagecreatetruecolor($targetW, $targetH);
    imagealphablending($logoResized, false);
    $transparent = imagecolorallocatealpha($logoResized, 0, 0, 0, 127);
    imagefilledrectangle($logoResized, 0, 0, $targetW, $targetH, $transparent);
    imagesavealpha($logoResized, true);
    imagecopyresampled($logoResized, $logo, 0, 0, 0, 0, $targetW, $targetH, $logoW, $logoH);

    // Tempel pas di tengah — TANPA padding/overlay warna
    $dstX = (int)round(($qrW - $targetW) / 2);
    $dstY = (int)round(($qrH - $targetH) / 2);
    imagecopy($qr, $logoResized, $dstX, $dstY, 0, 0, $targetW, $targetH);

    imagepng($qr, $qrPath, 6);
    imagedestroy($logoResized); imagedestroy($logo); imagedestroy($qr);
}


private function _send_wa_konfirmasi($no_hp, array $d)
{
    // siapkan redirect_url
    if (!empty($d['redirect_url'])) {
        $redirect_url = $d['redirect_url'];
    } elseif (!empty($d['access_token'])) {
        $redirect_url = site_url('booking/booked?t='.urlencode($d['access_token']));
    } else {
        $redirect_url = site_url('booking'); // fallback aman
    }

    // sanitasi & fallback
    $nama          = isset($d['nama']) ? $d['nama'] : '-';
    $keperluan          = isset($d['keperluan']) ? $d['keperluan'] : '-';
    $kode          = isset($d['kode']) ? $d['kode'] : '-';
    $instansi_asal = isset($d['instansi_asal']) ? $d['instansi_asal'] : '-';
    $nama_petugas_instansi = isset($d['nama_petugas_instansi']) ? $d['nama_petugas_instansi'] : '-';
    $unit_tujuan   = isset($d['unit_tujuan']) ? $d['unit_tujuan'] : '-';
    $tanggal_disp  = !empty($d['tanggal']) ? date("d-m-Y", strtotime($d['tanggal'])) : '-';
    $jam_disp      = isset($d['jam']) ? $d['jam'] : '-';
    $qr_url        = isset($d['qr_url']) ? $d['qr_url'] : '';

    $pesan = "*[Konfirmasi Booking Kunjungan]*\n\n"
    ."Halo *".$nama."*,\n\n"
    ."Pengajuan kunjungan Anda telah *BERHASIL* didaftarkan dengan detail berikut:\n\n"
    ."🆔 Kode Booking   : *".$kode."*\n"
    ."👤 Nama Tamu      : ".$nama."\n"
    ."🏢 Instansi Asal  : ".$instansi_asal."\n"
    ."🏛️ Unit Tujuan    : ".$unit_tujuan."\n"
    ."👔 Pejabat Unit   : ".$nama_petugas_instansi."\n"
    ."📅 Tanggal        : ".$tanggal_disp."\n"
    ."🕒 Jam            : ".$jam_disp."\n"
    ."📝 Keperluan      : ".$keperluan."\n\n"
    ."Mohon hadir sesuai jadwal dan membawa *KTP asli*.\n\n";

    if ($qr_url !== '') {
    	$pesan .= "🔳 QR Booking:\n".$qr_url."\n\n";
    }

    $pesan .= "🔗 Detail booking:\n".$redirect_url."\n\n"
    ."_Pesan ini dikirim otomatis oleh sistem antrian tamu Lapas._";


    // $hp = $this->_normalize_msisdn_id($no_hp);

    if (function_exists('send_wa_single')) {
        try {
            send_wa_single($no_hp, $pesan);
            return true;
        } catch (Throwable $e) {
            log_message('error', 'send_wa_single error: '.$e->getMessage());
            return false;
        }
    } else {
        log_message('error', 'Fungsi send_wa_single tidak ditemukan.');
        return false;
    }
}


	public function get_limit_pendamping(){
		$id = (int)$this->input->get('id');
		$row = $this->db->select('jumlah_pendamping')->get_where('unit_tujuan',['id'=>$id])->row();
	    $max = $row ? $row->jumlah_pendamping : null; // NULL berarti tak dibatasi
	    echo json_encode(["max" => $max === null ? null : (int)$max]);
	}

	public function options_by_kategori()
	{
		$jenis = $this->input->get('jenis', true);

		$map = [
			'opd'    => ['table'=>'opd_sulsel',               'id'=>'id_opd',    'text'=>'nama_opd',                         'search'=>['nama_opd']],
			'pn'     => ['table'=>'pengadilan_negeri_sulsel', 'id'=>'id_pn',     'text'=>'nama_pn',                          'search'=>['nama_pn','kabkota']],
			'pa'     => ['table'=>'pengadilan_agama_sulsel',  'id'=>'id_pa',     'text'=>'nama_pa',                          'search'=>['nama_pa','kabkota']],
			'ptun'   => ['table'=>'pengadilan_tun_sulsel',    'id'=>'id_ptun',   'text'=>'nama_ptun',                        'search'=>['nama_ptun','kabkota']],
			'kejari' => ['table'=>'kejaksaan_negeri_sulsel',  'id'=>'id_kejari', 'text'=>'nama_kejari',                      'search'=>['nama_kejari','kabkota']],
			'cabjari'=> ['table'=>'kejari_cabang_sulsel',     'id'=>'id_cabjari','text'=>"CONCAT(nama_cabang,' – ',lokasi)", 'search'=>['nama_cabang','lokasi','kabkota']],
			'bnn'    => ['table'=>'bnn_sulsel',               'id'=>'id_bnn',    'text'=>'nama_unit',                        'search'=>['nama_unit','kabkota']],
			'kodim'  => ['table'=>'kodim_sulawesi',           'id'=>'id_kodim',  'text'=>'label',                            'search'=>['label','wilayah','provinsi']],
			'kejati' => ['table'=>'kejaksaan_tinggi_sulsel', 'id'=>'id_kejati', 'text'=>'nama_kejati', 'search'=>['nama_kejati']],

		];

		if (!$jenis || !isset($map[$jenis])) {
			return $this->output->set_content_type('application/json')
			->set_output(json_encode([]));
		}

		$cfg = $map[$jenis];
		$this->db->select($cfg['id'].' AS id, '.$cfg['text'].' AS text', false)
		->from($cfg['table']);

		if ($this->db->field_exists('aktif', $cfg['table'])) {
			$this->db->where('aktif', 1);
		}

		if ($jenis === 'kodim') {
			$this->db->order_by('nomor_kodim', 'ASC');
		} else {
			$this->db->order_by('text', 'ASC');
		}

		$rows = $this->db->get()->result_array();

		return $this->output->set_content_type('application/json')
		->set_output(json_encode($rows));
	}

	public function print_pdf($kode_booking)
	{
	    $token = $this->input->get('t', TRUE);
	    if (!$token) show_error('Token wajib.', 403);

	    // validasi token & status checkout
	    $row = $this->db->get_where('booking_tamu', [
	        'kode_booking' => $kode_booking,
	        'access_token' => $token
	    ])->row();

	    if (!$row) show_error('Token/booking tidak valid.', 403);
	    if ((int)$row->token_revoked === 1) show_error('Token dicabut.', 403);
	    if (!empty($row->checkout_at)) show_error('Token sudah tidak berlaku (checkout).', 403);

	    // render HTML → TCPDF (atau Dompdf)
	    $data['booking'] = $row;
	    $html = $this->load->view('booking_pdf', $data, TRUE);

	    $dl = (int)$this->input->get('dl');
	    $filename = 'Booking_'.$kode_booking.'.pdf';

	    $this->load->library('pdf'); // TCPDF wrapper
	    $pdf = new Pdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
	      if (method_exists($pdf, 'setPrintHeader')) $pdf->setPrintHeader(false);
    if (method_exists($pdf, 'setPrintFooter')) $pdf->setPrintFooter(false);
	    $pdf->SetTitle($filename);
	    $pdf->SetMargins(15, 15, 15);
	    $pdf->SetAutoPageBreak(TRUE, 15);
	    $pdf->AddPage();
	    $pdf->writeHTML($html, true, false, true, false, '');
	    $pdf->Output($filename, $dl ? 'D' : 'I');
	}


// contoh minimal; lindungi dengan auth petugas!
public function do_checkin($kode_booking)
{
    $this->db->where('kode_booking', $kode_booking)
             ->update('booking_tamu', ['checkin_at' => date('Y-m-d H:i:s')]);
    // redirect/info sukses...
}

public function do_checkout($kode_booking)
{
    $this->db->where('kode_booking', $kode_booking)
             ->update('booking_tamu', [
                 'checkout_at'   => date('Y-m-d H:i:s'),
                 'token_revoked' => 1 // langsung matikan token juga
             ]);
    // redirect/info sukses...
}


/**
 * Ambil nomor WA unit tujuan secara fleksibel.
 * Mengembalikan [ $hp_unit_or_null, $nama_unit_or_dash ]
 */
private function _get_unit_contact(int $unit_id): array
{
    $table = 'unit_tujuan';
    // kandidat nama kolom nomor WA/HP yang mungkin ada
    $candidates = ['no_wa','wa','no_hp','telp','kontak_wa','phone'];
    $fields = [];

    foreach ($candidates as $c) {
        if ($this->db->field_exists($c, $table)) {
            $fields[] = $c;
        }
    }

    // minimal ambil nama unit
    $this->db->select('nama_unit');
    foreach ($fields as $f) $this->db->select($f);
    $row = $this->db->get_where($table, ['id' => $unit_id])->row();

    $unit_nama = $row ? $row->nama_unit : '-';
    $hp = null;
    if ($row) {
        foreach ($fields as $f) {
            if (!empty($row->{$f})) { $hp = $row->{$f}; break; }
        }
    }
    return [$hp, $unit_nama];
}

private function _normalize_msisdn_id($hp)
{
    $hp = preg_replace('/\D+/', '', (string)$hp);
    if ($hp === '') return '';
    if (strpos($hp,'62') === 0) return $hp;
    if ($hp[0] === '0') return '62'.substr($hp,1);
    return $hp;
}
/**
 * Kirim WA pemberitahuan ke unit tujuan
 * $d = [
 *   'kode','nama','instansi_asal','unit_nama',
 *   'tanggal','jam','pendamping','keperluan','redirect_url'
 * ]
 */
private function _send_wa_info_unit(string $hp_unit, array $d): bool
{
    if (!function_exists('send_wa_single')) {
        log_message('error', 'send_wa_single tidak tersedia.');
        return false;
    }
    // (opsional) normalisasi
    if (method_exists($this, '_normalize_msisdn_id')) {
        $hp_unit = $this->_normalize_msisdn_id($hp_unit);
    }

    $tanggal_disp = !empty($d['tanggal']) ? date('d-m-Y', strtotime($d['tanggal'])) : '-';
    $jam_disp     = $d['jam'] ?? '-';
    $pesan =
        "*[Pemberitahuan Kunjungan]*\n\n".
        "Yth. Unit *".$d['unit_nama']."*,\n\n".
        "Akan ada kunjungan terjadwal:\n".
        "• Kode Booking : *".$d['kode']."*\n".
        "• Tamu         : ".$d['nama']."\n".
        "• Instansi     : ".$d['instansi_asal']."\n".
        "• Tanggal/Jam  : ".$tanggal_disp." ".$jam_disp."\n".
        "• Pendamping   : ".((int)($d['pendamping'] ?? 0))."\n".
        "• Keperluan    : ".($d['keperluan'] ?? '-')."\n\n".
        "Mohon menyiapkan penerimaan sesuai jadwal.\n".
        (!empty($d['redirect_url']) ? "Detail: ".$d['redirect_url']."\n\n" : "").
        "_Pesan otomatis sistem antrian tamu Lapas._";

    try {
        send_wa_single($hp_unit, $pesan);
        return true;
    } catch (Throwable $e) {
        log_message('error', 'WA unit gagal: '.$e->getMessage());
        return false;
    }
}


}
