<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MX_Controller {

    private $last_upload_error = null;

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

        $booking = $this->db->get_where('booking_tamu', ['access_token' => $token])->row();
        if (!$booking) {
            return $this->_booked_error("Link tidak valid.");
        }
        if ((int)$booking->token_revoked === 1) {
            return $this->_booked_error("Link sudah tidak berlaku (token dicabut).");
        }
        if (!empty($booking->checkout_at)) {
            $wkt = date('d-m-Y H:i', strtotime($booking->checkout_at));
            return $this->_booked_error("Link tidak berlaku. Anda telah checkout pada {$wkt}.");
        }

        $data = [
            "controller" => get_class($this),
            "title"      => "Detail Booking",
            "deskripsi"  => "Detail",
            "booking"    => $booking,
            "rec"        => $this->fm->web_me(),
            "prev"       => base_url("assets/images/track.png"),
        ];
        $this->load->view('booking_detail', $data);
    }

    private function _booked_error($msg)
    {
        $data = [
            "controller" => get_class($this),
            "title"      => "Link Tidak Berlaku",
            "deskripsi"  => $msg
        ];
        $this->load->view('booking_error', $data);
    }

    /** =========================
     *  SUBMIT BOOKING (AJAX)
     *  ========================= */
    public function add(){
    $data = $this->input->post(NULL, TRUE);
    $this->load->library('form_validation');

    // >>> PENTING: inisialisasi variabel upload agar selalu ada
    $surat_tugas = null;
    $foto        = null;

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

    // 2) Pendamping vs unit_tujuan (cek batas di tabel unit)
    $unit_id    = (int)$data['unit_tujuan'];
    $dimintaRaw = $this->input->post('jumlah_pendamping', true);
    $diminta    = ($dimintaRaw === '' || $dimintaRaw === null) ? 0 : (int)$dimintaRaw;

    [$ok, $unit_nama, $err] = $this->_validate_pendamping($unit_id, $diminta);
    if (!$ok) {
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(["success"=>false,"title"=>"Melebihi Batas Pendamping","pesan"=>$err]));
    }

    // 3) Instansi asal (kategori + instansi_id ATAU manual 'lainnya')
    $kategori   = strtolower((string)$this->input->post('kategori', true));
    $instansiId = (int)$this->input->post('instansi_id', true);
    if ($kategori === 'lainnya') {
        $instansiNama = trim((string)$this->input->post('target_instansi_nama', true));
        if ($instansiNama === '' || mb_strlen($instansiNama) < 3) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>"Nama instansi wajib diisi (minimal 3 karakter) saat memilih kategori Lainnya."]));
        }
        $instansiId = null; // abaikan id saat 'lainnya'
    } else {
        [$ok, $instansiNama, $err] = $this->_resolve_instansi_asal($kategori, $instansiId);
        if (!$ok) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>$err]));
        }
    }

    // 4) Kode & token
    $kode_booking = $this->_make_kode_booking();
    $access_token = bin2hex(random_bytes(24));

    // 5) Upload opsional (jangan gagal kalau user tidak pilih file)
    // helper deteksi "tidak pilih file"
    $no_file = function(string $field){
        return empty($_FILES[$field]) ||
               (isset($_FILES[$field]['error']) && $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) ||
               (isset($_FILES[$field]['name']) && $_FILES[$field]['name'] === '');
    };

    if (!$no_file('surat_tugas')) {
        $tmp = $this->_upload('surat_tugas', './uploads/surat_tugas/', 'pdf|jpg|jpeg|png', 2048, 'surat_tugas');
        if ($tmp === null) {
            $msg = $this->get_last_upload_error();
            // kalau bukan kasus "tidak memilih file", anggap error
            if ($msg && stripos($msg, 'did not select a file') === false) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false,"title"=>"Upload Gagal",
                        "pesan"=>$msg ?: "Surat tugas melebihi batas ukuran (2MB)."
                    ]));
            }
        } else {
            $surat_tugas = $tmp;
        }
    }

    if (!$no_file('foto')) {
        $tmp = $this->_upload('foto', './uploads/foto/', 'jpg|jpeg|png', 1536, 'foto');
        if ($tmp === null) {
            $msg = $this->get_last_upload_error();
            if ($msg && stripos($msg, 'did not select a file') === false) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false,"title"=>"Upload Gagal",
                        "pesan"=>$msg ?: "Foto melebihi batas ukuran (1.5MB)."
                    ]));
            }
        } else {
            $foto = $tmp;
        }
    }

    // 5.x) petugas instansi default dari unit_tujuan (opsional)
    $nama_petugas_instansi = null;
    $unit = $this->db->select('nama_pejabat, nama_unit')
        ->from('unit_tujuan')->where('id', $unit_id)->limit(1)->get()->row();
    if ($unit) {
        $nama_petugas_instansi = !empty($unit->nama_pejabat) ? trim($unit->nama_pejabat) : null;
    }

    // ------- PENDAMPING (ambil dari JSON hidden pendamping_json) -------
    $pendampingRows  = [];
    $pendamping_json = $this->input->post('pendamping_json', true);
    $nik_tamu        = preg_replace('/\D+/', '', (string)$this->input->post('nik', true));

    if ($pendamping_json !== null && $pendamping_json !== '') {
        $arr = json_decode($pendamping_json, true);
        if (!is_array($arr)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode([
                    "success"=>false,"title"=>"Validasi Pendamping",
                    "pesan"=>"Format data pendamping tidak valid."
                ]));
        }
        $seen = [];
        foreach ($arr as $i => $p) {
            $nik  = preg_replace('/\D+/', '', (string)($p['nik'] ?? ''));
            $nama = trim((string)($p['nama'] ?? ''));
            if ($nik === '' && $nama === '') continue;

            if (!preg_match('/^\d{16}$/', $nik)) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false,"title"=>"Validasi Pendamping",
                        "pesan"=>"NIK pendamping #".($i+1)." harus 16 digit."
                    ]));
            }
            if ($nama === '') {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false,"title"=>"Validasi Pendamping",
                        "pesan"=>"Nama pendamping #".($i+1)." wajib diisi."
                    ]));
            }
            if ($nik === $nik_tamu) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false,"title"=>"Validasi Pendamping",
                        "pesan"=>"NIK pendamping #".($i+1)." tidak boleh sama dengan NIK tamu."
                    ]));
            }
            if (isset($seen[$nik])) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false,"title"=>"Validasi Pendamping",
                        "pesan"=>"NIK pendamping #".($i+1)." duplikat."
                    ]));
            }
            $seen[$nik] = true;
            $pendampingRows[] = [
                'kode_booking' => $kode_booking,
                'nik'          => $nik,
                'nama'         => $nama
            ];
        }
    }

    // Pastikan jumlah pendamping sesuai angka (kecuali 0 → loloskan)
    if ($diminta > 0 && count($pendampingRows) !== $diminta) {
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                "success"=>false,"title"=>"Validasi Pendamping",
                "pesan"=>"Jumlah pendamping yang diisi (".count($pendampingRows).") tidak sama dengan jumlah pendamping ($diminta)."
            ]));
    }
    // ------- END PENDAMPING -------

    // 6) INSERT (transaksi)
    $this->db->trans_begin();

    $insert = [
        "kode_booking"          => $kode_booking,
        "nama_tamu"             => $data['nama_tamu'],
        "jabatan"               => $data['jabatan'],
        "nik"                   => $data['nik'],
        "no_hp"                 => $data['no_hp'],
        "instansi"              => $data['instansi'] ?? null,
        "unit_tujuan"           => $unit_id,
        "target_kategori"       => $kategori,
        "target_instansi_id"    => $instansiId,
        "nama_petugas_instansi" => $nama_petugas_instansi,
        "target_instansi_nama"  => $instansiNama,
        "keperluan"             => $data['keperluan'] ?? null,
        "surat_tugas"           => $surat_tugas,   // aman walau null
        "jumlah_pendamping"     => $diminta,
        "tanggal"               => $tanggal,
        "jam"                   => $jam,
        "foto"                  => $foto,          // aman walau null
        "status"                => "approved",
        "access_token"          => $access_token,
        "token_issued_at"       => date('Y-m-d H:i:s'),
        "token_revoked"         => 0
    ];
    $okInsert = $this->db->insert("booking_tamu", $insert);
    if (!$okInsert) {
        $this->db->trans_rollback();
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                "success"=>false,"title"=>"Gagal Menyimpan","pesan"=>"Terjadi kendala saat menyimpan data booking."
            ]));
    }

    // 6b) INSERT pendamping batch (kalau ada)
    if (!empty($pendampingRows)) {
        $values = [];
        foreach ($pendampingRows as $r) {
            $values[] = $this->db->escape($r['kode_booking']).','.$this->db->escape($r['nik']).','.$this->db->escape($r['nama']);
        }
        $sql = "INSERT INTO booking_pendamping (kode_booking, nik, nama) VALUES ".
               '('.implode('),(', $values).') '.
               "ON DUPLICATE KEY UPDATE nama = VALUES(nama)";
        $this->db->query($sql);
        if ($this->db->affected_rows() < 0) {
            $this->db->trans_rollback();
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode([
                    "success"=>false,"title"=>"Gagal Menyimpan Pendamping","pesan"=>"Silakan ulangi pengisian pendamping."
                ]));
        }
    }

    $this->db->trans_commit();

    // 7) QR + redirect
    $qr_url       = $this->_make_qr($kode_booking);
    $redirect_url = site_url('booking/booked?t='.urlencode($access_token));

    // 8) Balas JSON
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


    /** =========================
     *  API Pendamping (opsional)
     *  ========================= */

    // GET /booking/pendamping_list/{kode}
    public function pendamping_list($kode_booking){
        $rows = $this->db->order_by('id_pendamping','ASC')
            ->get_where('booking_pendamping', ['kode_booking' => $kode_booking])->result_array();
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(["ok"=>true,"data"=>$rows]));
    }

    // POST: kode_booking, nik(16), nama
    public function pendamping_add(){
        $kode = trim($this->input->post('kode_booking', true));
        $nik  = preg_replace('/\D/','', (string)$this->input->post('nik', true));
        $nama = trim((string)$this->input->post('nama', true));

        if ($kode==='' || !preg_match('/^\d{16}$/', $nik) || $nama==='') {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(["ok"=>false,"msg"=>"Data tidak lengkap/valid."]));
        }

        $exists = $this->db->select('kode_booking')->limit(1)
            ->get_where('booking_tamu', ['kode_booking'=>$kode])->row();
        if (!$exists) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(["ok"=>false,"msg"=>"Booking tidak ditemukan."]));
        }

        $sql = "INSERT INTO booking_pendamping (kode_booking, nik, nama)
                VALUES (?,?,?)
                ON DUPLICATE KEY UPDATE nama=VALUES(nama)";
        $this->db->query($sql, [$kode,$nik,$nama]);

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(["ok"=>true,"msg"=>"Pendamping disimpan."]));
    }

    // POST: id_pendamping
    public function pendamping_delete(){
        $id = (int)$this->input->post('id_pendamping', true);
        if ($id<=0) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(["ok"=>false,"msg"=>"ID tidak valid."]));
        }
        $this->db->delete('booking_pendamping', ['id_pendamping'=>$id]);
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(["ok"=>true,"deleted"=>$this->db->affected_rows()>0]));
    }

    /** =========================
     *  WA & Util
     *  ========================= */

    public function wa_notify()
{
    $token = $this->input->post('t', TRUE) ?: $this->input->get('t', TRUE);
    if (!$token) return $this->json_exit(['ok'=>false,'err'=>'missing token'], 422);

    $b = $this->db->get_where('booking_tamu', ['access_token' => $token])->row();
    if (!$b) return $this->json_exit(['ok'=>false,'err'=>'not found'], 404);

    if ((int)$b->token_revoked === 1)    return $this->json_exit(['ok'=>true,'skip'=>'token revoked']);
    if (!empty($b->checkout_at))         return $this->json_exit(['ok'=>true,'skip'=>'already checkout']);

    // ===== data bantu umum =====
    $unit_nama_db = $this->db->select('nama_unit')
        ->get_where('unit_tujuan', ['id' => (int)$b->unit_tujuan])
        ->row('nama_unit');

    $qr_url   = base_url('uploads/qr/qr_'.$b->kode_booking.'.png');
    $redir    = site_url('booking/booked?t='.urlencode($b->access_token));
    $instansi = $b->target_instansi_nama ?: ($b->instansi ?: '-');

    // ===== 1) Kirim ke TAMU (hanya sekali) =====
    if (empty($b->wa_sent_at)) {
        $ok_user = $this->_send_wa_konfirmasi($b->no_hp, [
            'nama'                   => $b->nama_tamu,
            'nama_petugas_instansi'  => $b->nama_petugas_instansi,
            'kode'                   => $b->kode_booking,
            'instansi_asal'          => $instansi,
            'unit_tujuan'            => $unit_nama_db ?: '-',
            'tanggal'                => $b->tanggal,
            'jam'                    => $b->jam,
            'qr_url'                 => $qr_url,
            'redirect_url'           => $redir,
            'keperluan'              => $b->keperluan ?: '-',
        ]);
        if ($ok_user) {
            $this->db->where('access_token', $token)
                     ->where('wa_sent_at IS NULL', NULL, FALSE)
                     ->update('booking_tamu', ['wa_sent_at' => date('Y-m-d H:i:s')]);
        }
    }

    // ===== helper kecil =====
    $digits = function($s){ return preg_replace('/\D+/', '', (string)$s); };

    // ===== 2) Kirim ke UNIT TUJUAN (sekali saja bila ada kolom cap) =====
    $child = $this->db->select('id,nama_unit,nama_pejabat,COALESCE(no_hp,whatsapp,hp,telp,phone) AS no_hp,parent_id', false)
        ->from('unit_tujuan')
        ->where('id', (int)$b->unit_tujuan)
        ->limit(1)->get()->row();

    if (!empty($child) && !empty($child->no_hp)) {
        $can_stamp_unit   = $this->db->field_exists('wa_unit_sent_at', 'booking_tamu');
        $should_send_unit = !($can_stamp_unit && !empty($b->wa_unit_sent_at));

        if ($should_send_unit) {
            $ok_unit = $this->_send_wa_info_unit($child->no_hp, [
                'kode'            => $b->kode_booking,
                'nama'            => $b->nama_tamu,
                'instansi_asal'   => $instansi,
                'unit_nama'       => $child->nama_unit ?: ($unit_nama_db ?: '-'),
                'unit_pejabat'    => $child->nama_pejabat ?? '',
                'child_unit_nama' => $child->nama_unit ?: ($unit_nama_db ?: '-'), // Unit Tujuan (anak)
                'tanggal'         => $b->tanggal,
                'jam'             => $b->jam,
                'pendamping'      => (int)$b->jumlah_pendamping,
                'keperluan'       => $b->keperluan ?: '-',
                'redirect_url'    => $redir,
                'is_cc'           => false,
            ]);

            if ($ok_unit && $can_stamp_unit) {
                $this->db->where('access_token', $token)
                         ->where('wa_unit_sent_at IS NULL', NULL, FALSE)
                         ->update('booking_tamu', ['wa_unit_sent_at' => date('Y-m-d H:i:s')]);
            }
        }
    } else {
        log_message('debug', 'No HP Unit tujuan tidak tersedia untuk unit_id='.(int)$b->unit_tujuan);
    }

    // ===== 3) TEMBUSAN ke UNIT INDUK (parent) =====
    if (!empty($child) && !empty($child->parent_id)) {
        $parent = $this->db->select('id,nama_unit,nama_pejabat,COALESCE(no_hp,whatsapp,hp,telp,phone) AS no_hp', false)
            ->from('unit_tujuan')
            ->where('id', (int)$child->parent_id)
            ->limit(1)->get()->row();

        if (!empty($parent) && !empty($parent->no_hp)) {
            $same_number      = $digits($parent->no_hp) === $digits($child->no_hp);
            $can_stamp_parent = $this->db->field_exists('wa_parent_sent_at', 'booking_tamu');
            $already_sent_cc  = $can_stamp_parent && !empty($b->wa_parent_sent_at);

            if (!$same_number && !$already_sent_cc) {
                $ok_cc = $this->_send_wa_info_unit($parent->no_hp, [
                    'kode'            => $b->kode_booking,
                    'nama'            => $b->nama_tamu,
                    'instansi_asal'   => $instansi,
                    'unit_nama'       => $parent->nama_unit ?? '-',     // baris "Kepada Yth." = parent
                    'unit_pejabat'    => $parent->nama_pejabat ?? '',
                    'child_unit_nama' => $child->nama_unit ?: ($unit_nama_db ?: '-'), // tampilkan Unit Tujuan (anak)
                    'tanggal'         => $b->tanggal,
                    'jam'             => $b->jam,
                    'pendamping'      => (int)$b->jumlah_pendamping,
                    'keperluan'       => $b->keperluan ?: '-',
                    'redirect_url'    => $redir,
                    'is_cc'           => true, // header jadi "[Tembusan ...]"
                ]);

                if ($ok_cc && $can_stamp_parent) {
                    $this->db->where('access_token', $token)
                             ->where('wa_parent_sent_at IS NULL', NULL, FALSE)
                             ->update('booking_tamu', ['wa_parent_sent_at' => date('Y-m-d H:i:s')]);
                }
            }
        } else {
            log_message('debug', 'Parent unit tidak ditemukan/tiada no_hp; unit_id='.(int)$child->parent_id);
        }
    }

    return $this->json_exit(['ok'=>true]);
}



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
        exit;
    }

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
            fastcgi_finish_request();
        } else {
            @ob_end_flush(); @flush();
        }
    }

    private function _json(array $payload, int $status = 200)
    {
        return $this->output
            ->set_status_header($status)
            ->set_content_type('application/json; charset=utf-8')
            ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }

    /** =========================
     *  RULES & VALIDATORS
     *  ========================= */

    private function _set_rules(){
        $kat = strtolower((string)$this->input->post('kategori', true));

        // Identitas tamu
        $this->form_validation->set_rules('nama_tamu','Nama Tamu','required|trim|min_length[3]');
        $this->form_validation->set_rules('jabatan','Jabatan','required|trim');

        // NIK 16 digit
        $this->form_validation->set_rules(
            'nik','NIK',
            'required|trim|regex_match[/^\d{16}$/]',
            ['regex_match' => '* %s harus 16 digit angka']
        );

        // No HP 10–13 digit
        $this->form_validation->set_rules(
            'no_hp','No HP',
            'required|trim|regex_match[/^[0-9]{10,13}$/]',
            ['regex_match' => '* %s harus 10–13 digit angka']
        );

        // Tujuan internal Lapas
        $this->form_validation->set_rules('unit_tujuan','Unit Tujuan','required|integer');

        // Kategori asal + instansi
        $this->form_validation->set_rules(
            'kategori','Kategori Asal',
            'required|in_list[opd,pn,pa,ptun,kejati,kejari,cabjari,bnn,kodim,lainnya]'
        );

        if ($kat === 'lainnya') {
            $this->form_validation->set_rules(
                'target_instansi_nama','Nama Instansi',
                'required|trim|min_length[3]|max_length[255]'
            );
            $this->form_validation->set_rules('instansi_id','Instansi Asal','integer');
        } else {
            $this->form_validation->set_rules('instansi_id','Instansi Asal','required|integer');
            $this->form_validation->set_rules('target_instansi_nama','Nama Instansi','trim|max_length[255]');
        }

        // Jadwal & pendamping
        $this->form_validation->set_rules('tanggal','Tanggal','required');
        $this->form_validation->set_rules('jam','Jam','required');
        // $this->form_validation->set_rules('jumlah_pendamping','Jumlah Pendamping','required|is_natural');
        // boleh kosong atau angka >= 0
        $this->form_validation->set_rules(
        	'jumlah_pendamping','Jumlah Pendamping',
        	'trim|regex_match[/^\d*$/]',
        	['regex_match' => '* %s hanya boleh berisi angka']
        );


        // Pesan error
        $this->form_validation->set_message('required',     '* %s Harus diisi');
        $this->form_validation->set_message('integer',      '* %s harus berupa angka bulat');
        $this->form_validation->set_message('is_natural',   '* %s harus berupa angka >= 0');
        $this->form_validation->set_message('min_length',   '* %s minimal %s karakter');
        $this->form_validation->set_message('max_length',   '* %s maksimal %s karakter');
        $this->form_validation->set_message('in_list',      '* %s tidak valid');

        $this->form_validation->set_error_delimiters('<br> ', ' ');
    }

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
                    if   ($hari >= 1 && $hari <= 4) { $min=480; $max=900; }   // Sen–Kam 08:00–15:00
                    elseif ($hari === 5)            { $min=480; $max=840; }   // Jum    08:00–14:00
                    else                            { $min=480; $max=690; }   // Sab    08:00–11:30

                    if ($menit < $min || $menit > $max) {
                        $errors[] = '* Jam kunjungan tidak sesuai dengan jadwal operasional.';
                    }
                }
            }
        }

        if ($errors) return [false, null, null, '<br> '.implode('<br> ', $errors)];
        return [true, $tanggal, $jam, ''];
    }

    private function _validate_pendamping($unit_id, $diminta){
        $row = $this->db->select('nama_unit, jumlah_pendamping')
                        ->get_where('unit_tujuan', ['id' => (int)$unit_id])
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
    {
        $prefix = date('ymd');
        $rand_digits = function(int $len){
            $out = '';
            for ($i=0; $i<$len; $i++) {
                $out .= (string) random_int(0, 9);
            }
            return $out;
        };
        for ($try=0; $try<10; $try++) {
            $code = $prefix . $rand_digits($rand_len);
            $exists = $this->db->select('1', false)
                ->from('booking_tamu')
                ->where('kode_booking', $code)
                ->limit(1)->get()->num_rows() > 0;
            if (!$exists) return $code;
        }
        return $prefix . $rand_digits($rand_len + 3);
    }

    public function get_last_upload_error() {
        return $this->last_upload_error;
    }

    private function _upload($field, $path, $types, $max_kb = 2048, $prefix = null)
    {
        $this->last_upload_error = null;

        if (empty($_FILES[$field]['name'])) return NULL;
        if (!is_dir($path)) { @mkdir($path, 0755, true); }

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

        if ($prefix === null) {
            $prefix = preg_replace('/[^a-z0-9_]+/i', '_', strtolower($field));
        }

        $origName = $_FILES[$field]['name'];
        $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        $rand6    = function_exists('random_bytes') ? bin2hex(random_bytes(3)) : substr(md5(uniqid('', true)), 0, 6);
        $fname    = sprintf('%s_%s_%s.%s', $prefix, date('Ymd_His'), $rand6, $ext);

        if (!isset($this->upload)) { $this->load->library('upload'); }
        $config = [
            'upload_path'      => $path,
            'allowed_types'    => $types,
            'max_size'         => $max_kb,
            'file_name'        => $fname,
            'overwrite'        => false,
            'remove_spaces'    => true,
            'file_ext_tolower' => true,
            'encrypt_name'     => false,
        ];
        $this->upload->initialize($config);

        if ($this->upload->do_upload($field)) {
            return $fname;
        }

        $err = $this->upload->display_errors('', '');
        $this->last_upload_error = $err ?: 'Gagal mengunggah berkas.';
        log_message('error', '[UPLOAD] Gagal '.$field.': '.$this->last_upload_error);
        return NULL;
    }

    private function _make_qr($kode_booking, $with_logo = true)
    {
        $this->load->library('ciqrcode');
        $dir = './uploads/qr/';
        if (!is_dir($dir)) { @mkdir($dir, 0755, true); }

        $file = 'qr_'.$kode_booking.'.png';
        $this->ciqrcode->generate([
            'data'     => $kode_booking,
            'level'    => 'H',
            'size'     => 10,
            'savename' => $dir.$file
        ]);

        if ($with_logo) {
            $logo_path = FCPATH.'assets/images/logo.png';
            if (is_file($logo_path)) {
                $this->_qr_overlay_logo($dir.$file, $logo_path, 0.22, false);
            }
        }
        return base_url('uploads/qr/'.$file);
    }

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

        $dstX = (int)round(($qrW - $targetW) / 2);
        $dstY = (int)round(($qrH - $targetH) / 2);
        imagecopy($qr, $logoResized, $dstX, $dstY, 0, 0, $targetW, $targetH);

        imagepng($qr, $qrPath, 6);
        imagedestroy($logoResized); imagedestroy($logo); imagedestroy($qr);
    }

    private function _send_wa_konfirmasi($no_hp, array $d)
    {
        $redirect_url = !empty($d['redirect_url'])
                        ? $d['redirect_url']
                        : (!empty($d['access_token']) ? site_url('booking/booked?t='.urlencode($d['access_token'])) : site_url('booking'));

        $nama          = isset($d['nama']) ? $d['nama'] : '-';
        $keperluan     = isset($d['keperluan']) ? $d['keperluan'] : '-';
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
        ."📝 Keperluan      : ".$keperluan."\n\n";

        if ($qr_url !== '') {
            $pesan .= "🔳 QR Booking:\n".$qr_url."\n\n";
        }

        $pesan .= "🔗 Detail booking:\n".$redirect_url."\n\n"
        ."_Pesan ini dikirim otomatis oleh sistem antrian tamu Lapas._";

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
            'kejati' => ['table'=>'kejaksaan_tinggi_sulsel',  'id'=>'id_kejati', 'text'=>'nama_kejati',                      'search'=>['nama_kejati']],
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

        $row = $this->db->get_where('booking_tamu', [
            'kode_booking' => $kode_booking,
            'access_token' => $token
        ])->row();

        if (!$row) show_error('Token/booking tidak valid.', 403);
        if ((int)$row->token_revoked === 1) show_error('Token dicabut.', 403);
        if (!empty($row->checkout_at)) show_error('Token sudah tidak berlaku (checkout).', 403);

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
    }

    public function do_checkout($kode_booking)
    {
        $this->db->where('kode_booking', $kode_booking)
                 ->update('booking_tamu', [
                     'checkout_at'   => date('Y-m-d H:i:s'),
                     'token_revoked' => 1
                 ]);
    }

    private function _get_unit_contact(int $unit_id): array
    {
        $table = 'unit_tujuan';
        $candidates = ['no_wa','wa','no_hp','telp','kontak_wa','phone'];
        $fields = [];

        foreach ($candidates as $c) {
            if ($this->db->field_exists($c, $table)) {
                $fields[] = $c;
            }
        }

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

    private function _send_wa_info_unit(string $hp_unit, array $d): bool
{
    if (!function_exists('send_wa_single')) {
        log_message('error', 'send_wa_single tidak tersedia.');
        return false;
    }
    if (method_exists($this, '_normalize_msisdn_id')) {
        $hp_unit = $this->_normalize_msisdn_id($hp_unit);
    }

    // ===== Data & fallback =====
    $kode        = trim((string)($d['kode'] ?? '-'));
    $nama        = trim((string)($d['nama'] ?? '-'));
    $instansi    = trim((string)($d['instansi_asal'] ?? '-'));
    $child_unit  = trim((string)($d['child_unit_nama'] ?? ($d['unit_nama'] ?? '-'))); // Unit tujuan asli
    $unit_nama   = trim((string)($d['unit_nama'] ?? '-'));       // untuk baris "Kepada Yth."
    $unit_pej    = trim((string)($d['unit_pejabat'] ?? ''));     // opsional
    $pendamping  = (int)($d['pendamping'] ?? 0);
    $keperluan   = trim((string)(($d['keperluan'] ?? '-') ?: '-'));
    $redir       = trim((string)($d['redirect_url'] ?? ''));
    $is_cc       = !empty($d['is_cc']);

    // Tanggal & jam (dd-mm-YYYY)
    $tanggal_disp = !empty($d['tanggal']) ? date('d-m-Y', strtotime($d['tanggal'])) : '-';
    $jam_disp     = !empty($d['jam']) ? $d['jam'] : '-';

    // Header + Kepada Yth
    $header = $is_cc ? '🔁 *TEMBUSAN PEMBERITAHUAN KUNJUNGAN*' : '📣 *PEMBERITAHUAN KUNJUNGAN*';
    $kepada = 'Kepada Yth.'."\n";
    if ($unit_pej !== '') {
        $kepada .= '*'.$unit_pej.'* — *'.$unit_nama.'*';
    } else {
        $kepada .= '*'.$unit_nama.'*';
    }

    // Body pesan (gunakan ikon & baris ringkas; hindari spasi alignment karena font WA proporsional)
    $lines = [];
    $lines[] = $header;
    $lines[] = '';
    $lines[] = $kepada;
    $lines[] = '━━━━━━━━━━━━━━━━━━━━';
    $lines[] = '🆔 Kode Booking : *'.$kode.'*';
    $lines[] = '👤 Tamu         : '.$nama;
    $lines[] = '🏢 Instansi     : '.$instansi;

    if ($is_cc) {
        // Jelaskan ini TEMBUSAN untuk kunjungan ke unit anak
        $lines[] = '🔎 Tembusan utk : *'.$child_unit.'*';
    } else {
        $lines[] = '🎯 Unit Tujuan  : '.$child_unit;
    }

    $lines[] = '📅 Tanggal      : '.$tanggal_disp;
    $lines[] = '⏰ Jam          : '.$jam_disp;
    $lines[] = '👥 Pendamping   : '.$pendamping.' orang';
    $lines[] = '📝 Keperluan    : '.$keperluan;

    if (!empty($d['qr_url'])) {
        $lines[] = '🧾 QR: '.$d['qr_url'];
    }
    if ($redir !== '') {
        $lines[] = '';
        $lines[] = '🔗 Detail kunjungan:';
        $lines[] = $redir;
    }

    $lines[] = '';
    $lines[] = '_Pesan otomatis Sistem Antrian Tamu Lapas._';

    $pesan = implode("\n", $lines);

    try {
        send_wa_single($hp_unit, $pesan);
        return true;
    } catch (Throwable $e) {
        log_message('error', 'WA unit gagal: '.$e->getMessage());
        return false;
    }
}




    // ==== DOKUMENTASI: list & upload (opsional) ====

public function dokumentasi_list()
{
    $token = $this->input->post('t', TRUE) ?: $this->input->get('t', TRUE);
    if (!$token) return $this->_json(['ok'=>false,'err'=>'missing token'], 422);

    $b = $this->db->get_where('booking_tamu', ['access_token' => $token])->row();
    if (!$b) return $this->_json(['ok'=>false,'err'=>'not found'], 404);

    $dir = FCPATH.'uploads/dokumentasi/';
    if (!is_dir($dir)) @mkdir($dir, 0755, true);

    $list = [];

    // Kalau ada tabel booking_dokumentasi, ambil dari DB
    if ($this->db->table_exists('booking_dokumentasi')) {
        $rows = $this->db->select('id, filename, uploaded_at')
            ->from('booking_dokumentasi')
            ->where('kode_booking', $b->kode_booking)
            ->order_by('uploaded_at','DESC')
            ->get()->result_array();
        foreach ($rows as $r) {
            $list[] = [
                'filename' => $r['filename'],
                'url'      => base_url('uploads/dokumentasi/'.rawurlencode($r['filename'])),
                'time'     => $r['uploaded_at']
            ];
        }
    } else {
        // fallback: scan file berdasarkan pola nama
        foreach (glob($dir.'doc_'.$b->kode_booking.'_*.*') ?: [] as $f) {
            $list[] = [
                'filename' => basename($f),
                'url'      => base_url('uploads/dokumentasi/'.basename($f)),
                'time'     => date('Y-m-d H:i:s', @filemtime($f))
            ];
        }
        // urut terbaru dulu
        usort($list, function($a,$b){ return strcmp($b['time'] ?? '', $a['time'] ?? ''); });
    }

    return $this->_json(['ok'=>true,'data'=>$list]);
}

public function upload_dokumentasi()
{
    // --- Ambil data dari POST form-urlencoded ---
    $kode = trim((string)$this->input->post('kode', true));
    $b64  = (string)$this->input->post('image', false);

    // --- Fallback: coba body JSON ---
    if ($kode === '' || $b64 === '') {
        $rawIn = $this->input->raw_input_stream;
        if ($rawIn) {
            $j = json_decode($rawIn, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($j)) {
                if ($kode === '') $kode = trim((string)($j['kode'] ?? ''));
                if ($b64  === '') $b64  = (string)($j['image'] ?? '');
            }
        }
    }

    // --- Fallback: multipart file (FormData / input type=file) ---
    if ($b64 === '' && !empty($_FILES)) {
        $f = $_FILES['image'] ?? $_FILES['doc_photo'] ?? null; // terima 'image' atau 'doc_photo'
        if ($f && isset($f['error']) && $f['error'] === UPLOAD_ERR_OK) {
            $tmp  = $f['tmp_name'];
            $mime = function_exists('finfo_open')
                ? (function($p){ $fi = finfo_open(FILEINFO_MIME_TYPE); $m = finfo_file($fi,$p); finfo_close($fi); return $m; })($tmp)
                : mime_content_type($tmp);
            if (!in_array($mime, ['image/jpeg','image/png'], true)) {
                return $this->json_exit(["ok"=>false, "msg"=>"Hanya JPG/PNG"], 400);
            }
            $data = file_get_contents($tmp);
            if ($data === false) return $this->json_exit(["ok"=>false,"msg"=>"Gagal membaca file"],500);
            $b64 = 'data:'.$mime.';base64,'.base64_encode($data);
        }
    }

    // --- Terima token 't' sebagai alternatif 'kode' ---
$tok = trim((string)$this->input->post('t', true));
if ($kode === '' && $tok === '') {
    // kalau body JSON
    $rawIn = $this->input->raw_input_stream;
    if ($rawIn) {
        $j = json_decode($rawIn, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($j)) {
            $tok = trim((string)($j['t'] ?? ''));
        }
    }
}
if ($kode === '' && $tok !== '') {
    $kode_from_tok = $this->db
        ->select('kode_booking')
        ->get_where('booking_tamu', ['access_token' => $tok])
        ->row('kode_booking');
    if ($kode_from_tok) $kode = $kode_from_tok;
}


    // --- Validasi minimal ---
    if ($kode === '' || $b64 === '') {
        return $this->json_exit(["ok"=>false, "msg"=>"Data tidak lengkap (kode/image)"], 400);
    }

    // --- Validasi booking ---
    $row = $this->db->get_where('booking_tamu', ['kode_booking'=>$kode])->row_array();
    if (!$row) return $this->json_exit(["ok"=>false, "msg"=>"Booking tidak ditemukan"], 404);

    // --- Parse dataURL (jpg/png). Perbaiki spasi→plus dulu agar base64 valid ---
    $b64 = preg_replace('/\s+/', ' ', $b64);             // normalisasi whitespace
    $b64 = preg_replace('#^data:\s*image/([^;]+);base64,#i', 'data:image/$1;base64,', $b64);
    $payload = substr($b64, strpos($b64, ',')+1);
    $payload = strtr($payload, ' ', '+');                 // JAGA-JAGA: plus jadi spasi pada x-www-form-urlencoded
    if (!preg_match('#^data:image/(png|jpe?g);base64,#i', $b64, $m)) {
        return $this->json_exit(["ok"=>false, "msg"=>"Format gambar tidak valid"], 400);
    }
    $ext = strtolower($m[1]) === 'jpeg' ? 'jpg' : strtolower($m[1]);

    $bin = base64_decode($payload, true);
    if ($bin === false) return $this->json_exit(["ok"=>false,"msg"=>"Base64 rusak"],400);

    // --- Batas ukuran (5MB biner, ≈ 6.6MB base64) ---
    if (strlen($bin) > 5 * 1024 * 1024) {
        return $this->json_exit(["ok"=>false, "msg"=>"Ukuran gambar melebihi 5MB"], 413);
    }

    // --- Verifikasi gambar ---
    $info = @getimagesizefromstring($bin);
    if ($info === false) return $this->json_exit(["ok"=>false,"msg"=>"Berkas bukan gambar"],400);
    list($w, $h) = $info;

    // --- Re-encode + resize max 1600px, buang EXIF ---
    $src = @imagecreatefromstring($bin);
    if (!$src) return $this->json_exit(["ok"=>false, "msg"=>"Gagal memproses gambar"], 500);
    $maxSide = 1600;
    $scale = min(1, $maxSide / max($w, $h));
    $nw = max(1, (int)floor($w * $scale));
    $nh = max(1, (int)floor($h * $scale));
    $dst = imagecreatetruecolor($nw, $nh);
    if ($ext === 'png') { imagealphablending($dst, false); imagesavealpha($dst, true); }
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

    // --- Simpan atomik ---
    $dir = FCPATH.'uploads/foto/';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        imagedestroy($src); imagedestroy($dst);
        return $this->json_exit(["ok"=>false, "msg"=>"Gagal membuat folder upload"], 500);
    }
    $safeKode = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $kode);
    $fname   = 'dok_'.$safeKode.'_'.date('Ymd_His').'_'.substr(md5(uniqid('',true)),0,6).'.'.$ext;
    $fullTmp = $dir.'.tmp_'.$fname;
    $full    = $dir.$fname;

    $ok = ($ext === 'jpg') ? imagejpeg($dst, $fullTmp, 85) : imagepng($dst, $fullTmp, 6);
    imagedestroy($src); imagedestroy($dst);
    if (!$ok) return $this->json_exit(["ok"=>false, "msg"=>"Gagal menyimpan berkas"], 500);
    @chmod($fullTmp, 0644);
    if (!@rename($fullTmp, $full)) { @unlink($fullTmp); return $this->json_exit(["ok"=>false,"msg"=>"Gagal memindahkan berkas"],500); }

    // --- Update DB + hapus lama (jika kolom 'foto' ada) ---
    if ($this->db->field_exists('foto', 'booking_tamu')) {
        $old = $row['foto'] ?? null;
        $this->db->where('kode_booking', $kode)->update('booking_tamu', ['foto'=>$fname]);
        if ($old && $old !== $fname) {
            $oldPath = $dir.$old;
            if (is_file($oldPath)) @unlink($oldPath);
        }
    }

    return $this->json_exit([
        "ok"  => true,
        "msg" => "Foto tersimpan",
        "url" => base_url('uploads/foto/'.$fname),
        "file"=> $fname,
        "meta"=> ["w"=>$nw, "h"=>$nh]
    ]);
}


}
