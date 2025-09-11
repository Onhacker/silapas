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
        $data["prev"]       = base_url("assets/images/booking.png");

        $data['units_tree'] = $this->mb->get_tree(); // pohon unit
        $data["rec"]        = $this->fm->web_me();

        $this->load->view('booking_view', $data);
    }

    public function download_gate()
{
    $t = trim((string)$this->input->get('t', true));
    $k = trim((string)$this->input->get('k', true));

    // Validasi minimal
    if ($t === '' || $k === '') return $this->_gate_error('Link tidak valid.');

    $row = $this->db->get_where('booking_tamu', [
        'kode_booking' => $k,
        'access_token' => $t
    ])->row();

    if (!$row)                         return $this->_gate_error('Link tidak valid.');
    if ((int)$row->token_revoked === 1)return $this->_gate_error('Token dicabut.');
    if (!empty($row->checkout_at))     return $this->_gate_error('Sudah checkout.');
    if (isset($row->status) && $row->status === 'expired') {
        return $this->_gate_error('Status sudah tidak berlaku (expired).');
    }

    $dl = site_url('booking/print_pdf/'.rawurlencode($k)).'?t='.urlencode($t).'&dl=1';
    $to = site_url('booking/booked?t='.urlencode($t)); 

    $data = [
        'controller' => get_class($this),
        'title'      => 'Mengunduh tiket…',
        'deskripsi'  => 'Menyiapkan unduhan…',
        'prev'       => base_url("assets/images/booking.png"),
        'dl'         => $dl,
        'to'         => $to,
        'rec'        => $this->fm->web_me(),
    ];

    // 200 OK tapi tetap noindex + no-cache
    $this->output
        ->set_header('X-Robots-Tag: noindex, nofollow, noarchive')
        ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
        ->set_header('Pragma: no-cache');

    $this->load->view('download_gate', $data);
}

private function _gate_error($msg)
{
    $this->output
        ->set_status_header(410, 'Gone') // di halaman ERROR boleh 410
        ->set_header('X-Robots-Tag: noindex, nofollow, noarchive')
        ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
        ->set_header('Pragma: no-cache');

    $data = [
        'controller' => get_class($this),
        'title'      => 'Link Tidak Berlaku',
        'deskripsi'  => $msg,
        'prev'       => base_url("assets/images/booking.png"),
        'rec'        => $this->fm->web_me(),
    ];
    $this->load->view('booking_error', $data);
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
        // Jika status sudah expired → link tidak berlaku
        if (isset($booking->status) && $booking->status === 'expired') {
            $wkt = !empty($booking->expired_at)
            ? date('d-m-Y H:i', strtotime($booking->expired_at))
            : ($booking->tanggal.' '.$booking->jam);
            return $this->_booked_error("Link tidak berlaku. Status: Tidak Hadir (Expired) pada {$wkt}.");
        }

        $data = [
            "controller" => get_class($this),
            "title"      => "Detail Booking",
            "deskripsi"  => "Detail",
            "booking"    => $booking,
            "rec"        => $this->fm->web_me(),
            "prev"       => base_url("assets/images/booking.png"),
        ];
        $this->load->view('booking_detail', $data);
    }

    private function _booked_error($msg)
    {
        // 410 lebih tepat untuk link sudah tidak berlaku; 404 juga boleh.
        $this->output
        ->set_status_header(410, 'Gone') // atau 404
        ->set_header('X-Robots-Tag: noindex, nofollow, noarchive')
        ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
        ->set_header('Pragma: no-cache');
        $data = [
            "controller" => get_class($this),
            "rec"        => $this->fm->web_me(),
            "title"      => "Link Tidak Berlaku",
            "prev"       => base_url("assets/images/booking.png"),
            "deskripsi"  => $msg
        ];
        $this->load->view('booking_error', $data);
    }

    /** =========================
     *  SUBMIT BOOKING (AJAX)
     *  ========================= */
    public function add()
        {
            $data = $this->input->post(NULL, TRUE);
            $this->load->library('form_validation');

            // -- inisialisasi supaya selalu ada
            $surat_tugas = null;
            $foto        = null;

            $this->_set_rules();
            if ($this->form_validation->run() === FALSE) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false, "title"=>"Validasi Gagal", "pesan"=>validation_errors()
                    ]));
            }

            // 1) Validasi tanggal & jam
            [$ok, $tanggal, $jam, $err] = $this->_validate_jadwal($data['tanggal'], $data['jam']);
            if (!$ok) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>$err]));
            }

            // 2) Cek batas pendamping per unit
            $unit_id    = (int)$data['unit_tujuan'];
            $dimintaRaw = $this->input->post('jumlah_pendamping', true);
            $diminta    = ($dimintaRaw === '' || $dimintaRaw === null) ? 0 : (int)$dimintaRaw;

            [$ok, $unit_nama, $err] = $this->_validate_pendamping($unit_id, $diminta);
            if (!$ok) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(["success"=>false,"title"=>"Melebihi Batas Pendamping","pesan"=>$err]));
            }
            // 2.b) Cek kuota harian (pre-check cepat)
            [$okQuota, $sisa, $terpakai, $kuota, $errQ] = $this->_validate_kuota_harian($unit_id, $tanggal, false);
            if (!$okQuota) {
                return $this->output->set_content_type('application/json')
                ->set_output(json_encode(["success"=>false,"title"=>"Kuota Penuh","pesan"=>$errQ]));
            }


            // 3) Instansi asal
            $kategori   = strtolower((string)$this->input->post('kategori', true));
            $instansiId = (int)$this->input->post('instansi_id', true);
            if ($kategori === 'lainnya') {
                $instansiNama = trim((string)$this->input->post('target_instansi_nama', true));
                if ($instansiNama === '' || mb_strlen($instansiNama) < 3) {
                    return $this->output->set_content_type('application/json')
                        ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>"Nama instansi (Lainnya) minimal 3 karakter."]));
                }
                $instansiId = null;
            } else {
                [$ok, $instansiNama, $err] = $this->_resolve_instansi_asal($kategori, $instansiId);
                if (!$ok) {
                    return $this->output->set_content_type('application/json')
                        ->set_output(json_encode(["success"=>false,"title"=>"Validasi Gagal","pesan"=>$err]));
                }
            }

            // 4) Token akses
            $access_token = bin2hex(random_bytes(24));

            // 5) Upload opsional
            $no_file = function(string $field){
                return empty($_FILES[$field]) ||
                       (isset($_FILES[$field]['error']) && $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) ||
                       (isset($_FILES[$field]['name']) && $_FILES[$field]['name'] === '');
            };

            if (!$no_file('surat_tugas')) {
                $tmp = $this->_upload('surat_tugas', './uploads/surat_tugas/', 'pdf|jpg|jpeg|png', 2048, 'surat_tugas');
                if ($tmp === null) {
                    $msg = $this->get_last_upload_error();
                    if ($msg && stripos($msg, 'did not select a file') === false) {
                        return $this->output->set_content_type('application/json')
                            ->set_output(json_encode(["success"=>false,"title"=>"Upload Gagal","pesan"=>$msg ?: "Surat tugas melebihi 2MB."]));
                    }
                } else { $surat_tugas = $tmp; }
            }

            if (!$no_file('foto')) {
                $tmp = $this->_upload('foto', './uploads/foto/', 'jpg|jpeg|png', 1536, 'foto');
                if ($tmp === null) {
                    $msg = $this->get_last_upload_error();
                    if ($msg && stripos($msg, 'did not select a file') === false) {
                        return $this->output->set_content_type('application/json')
                            ->set_output(json_encode(["success"=>false,"title"=>"Upload Gagal","pesan"=>$msg ?: "Foto melebihi 1.5MB."]));
                    }
                } else { $foto = $tmp; }
            }

            // 5.x) default nama petugas instansi dari unit_tujuan
            $nama_petugas_instansi = null;
            $unit = $this->db->select('nama_pejabat, nama_unit')
                             ->from('unit_tujuan')->where('id', $unit_id)->limit(1)->get()->row();
            if ($unit && !empty($unit->nama_pejabat)) $nama_petugas_instansi = trim($unit->nama_pejabat);

            // ------- DATA PENDAMPING (validasi JSON) -------
            $pendampingRows  = [];
            $pendamping_json = $this->input->post('pendamping_json', true);
            $nik_tamu        = preg_replace('/\D+/', '', (string)$this->input->post('nik', true));

            if ($pendamping_json !== null && $pendamping_json !== '') {
                $arr = json_decode($pendamping_json, true);
                if (!is_array($arr)) {
                    return $this->output->set_content_type('application/json')
                        ->set_output(json_encode(["success"=>false,"title"=>"Validasi Pendamping","pesan"=>"Format data pendamping tidak valid."]));
                }
                $seen = [];
                foreach ($arr as $i => $p) {
                    $nik  = preg_replace('/\D+/', '', (string)($p['nik'] ?? ''));
                    $nama = trim((string)($p['nama'] ?? ''));
                    if ($nik === '' && $nama === '') continue;

                    if (!preg_match('/^\d{16}$/', $nik)) {
                        return $this->output->set_content_type('application/json')
                            ->set_output(json_encode(["success"=>false,"title"=>"Validasi Pendamping","pesan"=>"NIK pendamping #".($i+1)." harus 16 digit."]));
                    }
                    if ($nama === '') {
                        return $this->output->set_content_type('application/json')
                            ->set_output(json_encode(["success"=>false,"title"=>"Validasi Pendamping","pesan"=>"Nama pendamping #".($i+1)." wajib diisi."]));
                    }
                    if ($nik === $nik_tamu) {
                        return $this->output->set_content_type('application/json')
                            ->set_output(json_encode(["success"=>false,"title"=>"Validasi Pendamping","pesan"=>"NIK pendamping #".($i+1)." tidak boleh sama dengan NIK tamu."]));
                    }
                    if (isset($seen[$nik])) {
                        return $this->output->set_content_type('application/json')
                            ->set_output(json_encode(["success"=>false,"title"=>"Validasi Pendamping","pesan"=>"NIK pendamping #".($i+1)." duplikat."]));
                    }
                    $seen[$nik] = true;
                    $pendampingRows[] = ['nik'=>$nik,'nama'=>$nama]; // kode_booking diisi saat insert
                }
            }
            if ($diminta > 0 && count($pendampingRows) !== $diminta) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        "success"=>false,"title"=>"Validasi Pendamping",
                        "pesan"=>"Jumlah pendamping yang diisi (".count($pendampingRows).") tidak sama dengan jumlah pendamping ($diminta)."
                    ]));
            }
            // ------- END PENDAMPING -------

            // ===== INSERT dengan proteksi duplikasi kode_booking =====
            $insert_base = [
                "nama_tamu"             => $data['nama_tamu'],
                "jabatan"               => $data['jabatan'],
                "nik"                   => $data['nik'],
                "no_hp"                 => $data['no_hp'],
                "instansi"              => $data['instansi'] ?? null,
                "unit_tujuan"           => $unit_id,
                "target_kategori"       => $kategori,
                "target_instansi_id"    => $instansiId,
                "target_instansi_nama"  => $instansiNama,
                "nama_petugas_instansi" => $nama_petugas_instansi,
                "keperluan"             => $data['keperluan'] ?? null,
                "surat_tugas"           => $surat_tugas,
                "jumlah_pendamping"     => $diminta,
                "tanggal"               => $tanggal,
                "jam"                   => $jam,
                "foto"                  => $foto,
                "tanggal_lahir"         => $this->normalize_date_mysql($data['tanggal_lahir'] ?? ''),
                "tempat_lahir"          => $data["tempat_lahir"] ?? null,
                "alamat"                => $data["alamat"] ?? null,
                "status"                => "approved",
                "access_token"          => $access_token,
                "token_issued_at"       => date('Y-m-d H:i:s'),
                "token_revoked"         => 0
            ];

            $MAX_TRY = 7;
            $lastErr = null;
            for ($try=1; $try<=$MAX_TRY; $try++) {

                $kode_booking = $this->_make_kode_booking(); // pastikan ada UNIQUE index di kolom ini
                $insert = $insert_base;
                $insert["kode_booking"] = $kode_booking;

                $this->db->trans_begin();
                // Re-check kuota di dalam transaksi + lock baris unit (FOR UPDATE)
                [$okQuota2, $sisa2, $terpakai2, $kuota2, $errQ2] = $this->_validate_kuota_harian($unit_id, $tanggal, true);
                if (!$okQuota2) {
                    $this->db->trans_rollback();
                    return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(["success"=>false,"title"=>"Kuota Penuh","pesan"=>$errQ2]));
                }


                $okMain = $this->db->insert("booking_tamu", $insert);
                if (!$okMain) {
                    $err = $this->db->error(); // ['code'=>..., 'message'=>...]
                    $this->db->trans_rollback();

                    // 1062 → duplikat kode_booking → ulangi generate
                    if ((int)$err['code'] === 1062 && stripos($err['message'], 'kode_booking') !== false) {
                        $lastErr = $err;
                        continue;
                    }

                    // error lain → stop
                    return $this->output->set_content_type('application/json')
                        ->set_output(json_encode([
                            "success"=>false,"title"=>"Gagal Menyimpan",
                            "pesan"=>"Terjadi kendala saat menyimpan data booking. [DB-{$err['code']}]"
                        ]));
                }

                // Insert pendamping (jika ada)
                if (!empty($pendampingRows)) {
                    $values = [];
                    foreach ($pendampingRows as $r) {
                        $values[] = $this->db->escape($kode_booking).','.$this->db->escape($r['nik']).','.$this->db->escape($r['nama']);
                    }
                    $sql = "INSERT INTO booking_pendamping (kode_booking, nik, nama) VALUES ".
                           '('.implode('),(', $values).') '.
                           "ON DUPLICATE KEY UPDATE nama = VALUES(nama)";
                    $okPend = $this->db->query($sql);
                    if (!$okPend) {
                        $err = $this->db->error();
                        $this->db->trans_rollback();
                        return $this->output->set_content_type('application/json')
                            ->set_output(json_encode([
                                "success"=>false,"title"=>"Gagal Menyimpan Pendamping",
                                "pesan"=>"Silakan ulangi pengisian pendamping. [DB-{$err['code']}]"
                            ]));
                    }
                }

                $this->db->trans_commit();

                // Berhasil!
                $qr_url       = $this->_make_qr($kode_booking);
                $redirect_url = site_url('booking/booked?t='.urlencode($access_token));

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

            // Sampai sini artinya 7x percobaan masih bentrok (hampir mustahil)
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode([
                    "success"=>false,"title"=>"Gagal",
                    "pesan"=>"Gagal membuat kode booking unik. Silakan coba lagi."
                ]));
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
    // helper: parse berbagai format jadi Y-m-d
private function normalize_date_mysql(?string $s): ?string {
    if (!$s) return null;
    $s = trim($s);
    // Samakan delimiter
    $s = str_replace(['/', '.', ' '], '-', $s);

    $formats = [
        'Y-m-d',   // 2025-10-04 (HTML5 date input)
        'd-m-Y',   // 04-10-2025
        'm-d-Y',   // 10-04-2025 (kalau memang dipakai)
        'd-m-y',   // 04-10-25
    ];

    foreach ($formats as $fmt) {
        $dt = DateTime::createFromFormat($fmt, $s);
        // Pastikan presisi format (tidak “auto-correct”)
        $errors = DateTime::getLastErrors();
        if ($dt && empty($errors['warning_count']) && empty($errors['error_count'])) {
            // Confirm kembali sama persis (menghindari 04-13-2025 dst)
            if ($dt->format($fmt) === $s) {
                return $dt->format('Y-m-d');
            }
        }
    }
    return null; // gagal parse
}
    
    public function dev_quick_booking()
    {
        // if (ENVIRONMENT !== 'development') show_404();
        // $ip = $this->input->ip_address();
        // if (!in_array($ip, ['127.0.0.1','::1'])) show_404();

        // ambil unit_tujuan valid
        $unit = (int)($this->db->select('id')->order_by('id','ASC')->limit(1)->get('unit_tujuan')->row('id') ?? 1);

        $kode  = 'BK'.date('ymd').strtoupper(bin2hex(random_bytes(3)));
        $token = bin2hex(random_bytes(16));

        $data = [
            'kode_booking'         => $kode,
            'access_token'         => $token,
            'status'               => 'approved',
            'nama_tamu'            => 'Tester Dev',
            'no_hp'                => '082333265888',
            'keperluan'            => 'Uji fitur',
            'unit_tujuan'          => $unit,
            'target_instansi_nama' => 'Instansi Dev',
            'tanggal'              => date('Y-m-d'),
            'jam'                  => date('H:i', time()+3600),
            'token_revoked'        => 0,
            'create_date'           => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('booking_tamu', $data);

        $urls = [
            'detail' => site_url('booking/booked?t='.urlencode($token)),
            'pdf'    => site_url('booking/print_pdf/'.rawurlencode($kode)).'?t='.urlencode($token).'&dl=1',
            'wa'     => site_url('booking/wa_notify?t='.urlencode($token).'&debug=1&force=1'),
        ];

        $this->output->set_content_type('application/json')
        ->set_output(json_encode(['ok'=>true,'booking'=>$data,'urls'=>$urls], JSON_UNESCAPED_SLASHES));
    }


    public function wa_notify()
    {
        $token = trim((string)($this->input->post('t', TRUE) ?: $this->input->get('t', TRUE)));
        $kode  = trim((string)$this->input->get('k', TRUE));   // dukung kode_booking
        $debug = (int)$this->input->get('debug', TRUE) === 1;
        $force = (int)$this->input->get('force', TRUE) === 1;  // paksa kirim (abaikan stamp)
        $log   = [];

        // Ambil booking by token atau kode
        if ($token !== '') {
            $b = $this->db->get_where('booking_tamu', ['access_token' => $token])->row();
        } elseif ($kode !== '') {
            $b = $this->db->get_where('booking_tamu', ['kode_booking' => $kode])->row();
        } else {
            return $this->json_exit(['ok'=>false,'err'=>'missing token or kode (pakai ?t=token atau ?k=kode_booking)'], 422);
        }

        if (!$b) {
            if ($debug) {
                $last = $this->db->select('kode_booking, access_token, created_at', false)
                                  ->order_by('id','DESC')->limit(5)->get('booking_tamu')->result_array();
                return $this->json_exit([
                    'ok'=>false,
                    'err'=>'not found',
                    'hint'=>'pakai ?t=access_token atau ?k=kode_booking',
                    'peek_last'=>$last
                ], 404);
            }
            return $this->json_exit(['ok'=>false,'err'=>'not found'], 404);
        }
        if ((int)$b->token_revoked === 1)    return $this->json_exit(['ok'=>true,'skip'=>'token revoked']);
        if (!empty($b->checkout_at))         return $this->json_exit(['ok'=>true,'skip'=>'already checkout']);

        // ===== Data bantu: ambil unit tujuan (beserta no_hp) =====
        $unit_row = $this->db
            ->select('id, nama_unit, nama_pejabat, parent_id, no_hp', false)
            ->get_where('unit_tujuan', ['id' => (int)$b->unit_tujuan])
            ->row();

        $unit_nama_db     = $unit_row->nama_unit    ?? '-';
        $unit_pejabat_db  = $unit_row->nama_pejabat ?? '';
        $parent_id        = $unit_row->parent_id    ?? null;

        // nomor WA unit tujuan (ambil langsung dari row; kalau kosong, fallback _get_unit_contact)
        $hp_unit = $this->_extract_phone_from_row($unit_row);
        if (!$hp_unit) {
            list($hp_unit_fb, $nm_fb, $pej_fb) = $this->_get_unit_contact((int)$b->unit_tujuan);
            if ($hp_unit_fb) {
                $hp_unit        = $hp_unit_fb;
                $unit_nama_db   = $unit_nama_db ?: ($nm_fb ?: '-');
                $unit_pejabat_db= $unit_pejabat_db ?: ($pej_fb ?: '');
            }
        }

        $qr_url   = base_url('uploads/qr/qr_'.$b->kode_booking.'.png');
        $redir    = site_url('booking/booked?t='.urlencode($b->access_token));
        // $pdf_url  = site_url('booking/print_pdf/'.rawurlencode($b->kode_booking)).'?t='.urlencode($b->access_token);
        // $query   = http_build_query(['t' => $b->access_token, 'dl' => 1]);
        // $pdf_url = site_url('booking/print_pdf/'.rawurlencode($b->kode_booking)).'?'.$query;

        $pdf_url = site_url('booking/download_gate').'?k='.rawurlencode($b->kode_booking).'&t='.urlencode($b->access_token);


        $instansi = $b->target_instansi_nama ?: ($b->instansi ?: '-');

        // ===== 1) Kirim ke TAMU (sekali saja, kecuali force) =====
        $can_stamp_user = $this->db->field_exists('wa_sent_at', 'booking_tamu');
        $already_user   = $can_stamp_user && !empty($b->wa_sent_at);
        if ($force || !$already_user) {
            $ok_user = $this->_send_wa_konfirmasi($b->no_hp, [
                'access_token'           => $b->access_token,   // <— TAMBAH INI
                'nama'                   => $b->nama_tamu,
                'nama_petugas_instansi'  => $b->nama_petugas_instansi,
                'kode'                   => $b->kode_booking,
                'instansi_asal'          => $instansi,
                'unit_tujuan'            => $unit_nama_db ?: '-',
                'tanggal'                => $b->tanggal,
                'jam'                    => $b->jam,
                'qr_url'                 => $qr_url,
                'redirect_url'           => $redir,
                'pdf_url'                => $pdf_url,
                'keperluan'              => $b->keperluan ?: '-',
            ]);
            $log[] = ['send_user'=>['ok'=>$ok_user]];
            if ($ok_user && $can_stamp_user) {
                if ($token !== '') { $this->db->where('access_token', $token); }
                else               { $this->db->where('kode_booking', $b->kode_booking); }
                $this->db->where('wa_sent_at IS NULL', NULL, FALSE)
                         ->update('booking_tamu', ['wa_sent_at' => date('Y-m-d H:i:s')]);
            }
        } else {
            $log[] = ['send_user'=>'skipped: already stamped'];
        }

        // ===== 2) Kirim ke UNIT TUJUAN (ID) =====
        if (!empty($hp_unit)) {
            $can_stamp_unit = $this->db->field_exists('wa_unit_sent_at', 'booking_tamu');
            $already_unit   = $can_stamp_unit && !empty($b->wa_unit_sent_at);
            if ($force || !$already_unit) {
                $ok_unit = $this->_send_wa_info_unit($hp_unit, [
                    'kode'            => $b->kode_booking,
                    'nama'            => $b->nama_tamu,
                    'instansi_asal'   => $instansi,
                    'hp_tamu'         => $b->no_hp,  
                    'unit_nama'       => $unit_nama_db,      // Kepada Yth.
                    'unit_pejabat'    => $unit_pejabat_db,   // Kepada Yth.
                    'child_unit_nama' => $unit_nama_db,      // tampil di detail
                    'tanggal'         => $b->tanggal,
                    'jam'             => $b->jam,
                    'pendamping'      => (int)$b->jumlah_pendamping,
                    'keperluan'       => $b->keperluan ?: '-',
                    'redirect_url'    => $redir,
                    'qr_url'          => $qr_url,
                    'is_cc'           => false,
                ]);
                $log[] = ['send_unit'=>['to'=>$hp_unit,'ok'=>$ok_unit]];
                if ($ok_unit && $can_stamp_unit) {
                    if ($token !== '') { $this->db->where('access_token', $token); }
                    else               { $this->db->where('kode_booking', $b->kode_booking); }
                    $this->db->where('wa_unit_sent_at IS NULL', NULL, FALSE)
                             ->update('booking_tamu', ['wa_unit_sent_at' => date('Y-m-d H:i:s')]);
                }
            } else {
                $log[] = ['send_unit'=>'skipped: already stamped'];
            }
        } else {
            $log[] = ['send_unit'=>'skipped: no phone','dbg_from'=>$unit_row->no_hp ?? null];
        }

        // ===== 3) TEMBUSAN ke UNIT INDUK (parent_id) =====
        if (!empty($parent_id)) {
            $parent_row = $this->db
                ->select('id, nama_unit, nama_pejabat, no_hp', false)
                ->get_where('unit_tujuan', ['id' => (int)$parent_id])->row();

            $hp_parent = $this->_extract_phone_from_row($parent_row);
            if (!$hp_parent && $parent_row) {
                list($hp_parent_fb, $nm_parent_fb, $pej_parent_fb) = $this->_get_unit_contact((int)$parent_row->id);
                if ($hp_parent_fb) {
                    $hp_parent               = $hp_parent_fb;
                    $parent_row->nama_unit   = $parent_row->nama_unit   ?: $nm_parent_fb;
                    $parent_row->nama_pejabat= $parent_row->nama_pejabat?: $pej_parent_fb;
                }
            }

            if (!empty($hp_parent)) {
                $can_stamp_parent = $this->db->field_exists('wa_parent_sent_at', 'booking_tamu');
                $already_parent   = $can_stamp_parent && !empty($b->wa_parent_sent_at);

                // kirim walau nomornya sama dengan unit tujuan (bisa set ke false jika mau skip)
                $allow_duplicate_cc = true;
                $same_number = isset($hp_unit) &&
                    (preg_replace('/\D+/','',$hp_unit) === preg_replace('/\D+/','',$hp_parent));

                if ($force || (($allow_duplicate_cc || !$same_number) && !$already_parent)) {
                    $ok_cc = $this->_send_wa_info_unit($hp_parent, [
                        'kode'            => $b->kode_booking,
                        'nama'            => $b->nama_tamu,
                        'hp_tamu'         => $b->no_hp,  
                        'instansi_asal'   => $instansi,
                        'unit_nama'       => $parent_row->nama_unit ?? '-',     // Kepada Yth. (parent)
                        'unit_pejabat'    => $parent_row->nama_pejabat ?? '',
                        'child_unit_nama' => $unit_nama_db,                      // unit tujuan asli (anak)
                        'tanggal'         => $b->tanggal,
                        'jam'             => $b->jam,
                        'pendamping'      => (int)$b->jumlah_pendamping,
                        'keperluan'       => $b->keperluan ?: '-',
                        'redirect_url'    => $redir,
                        'qr_url'          => $qr_url,
                        'is_cc'           => true,
                    ]);
                    $log[] = ['send_parent'=>['to'=>$hp_parent,'ok'=>$ok_cc]];

                    if ($ok_cc && $can_stamp_parent) {
                        if ($token !== '') { $this->db->where('access_token', $token); }
                        else               { $this->db->where('kode_booking', $b->kode_booking); }
                        $this->db->where('wa_parent_sent_at IS NULL', NULL, FALSE)
                                 ->update('booking_tamu', ['wa_parent_sent_at' => date('Y-m-d H:i:s')]);
                    }
                } else {
                    $log[] = ['send_parent'=>'skipped: already stamped or same-number'];
                }
            } else {
                $log[] = ['send_parent'=>'skipped: no phone'];
            }
        } else {
            $log[] = ['send_parent'=>'skipped: no parent'];
        }

        if ($debug) return $this->json_exit(['ok'=>true,'debug'=>$log], 200);
        return $this->json_exit(['ok'=>true]);
    }

    /**
     * Ambil nomor WA & info unit.
     * Return: [hp, nama_unit, nama_pejabat]
     */
    private function _get_unit_contact(int $unit_id): array
    {
        $u = $this->db->get_where('unit_tujuan', ['id'=>$unit_id])->row();
        if (!$u) return [null,null,null];

        // coba berbagai nama kolom nomor
        $hp = null;
        foreach (['no_hp','wa','whatsapp','wa_number','no_wa','no_whatsapp','hp','telepon','telp','phone'] as $col) {
            if (isset($u->$col) && trim($u->$col) !== '') { $hp = $u->$col; break; }
        }
        if ($hp && method_exists($this, '_normalize_msisdn_id')) {
            $hp = $this->_normalize_msisdn_id($hp);
        }

        return [$hp, ($u->nama_unit ?? null), ($u->nama_pejabat ?? null)];
    }

    /** Normalisasi MSISDN Indonesia → 628xxxxxxxx */
    private function _normalize_msisdn_id(string $msisdn): string
    {
        $d = preg_replace('/\D+/', '', $msisdn);
        if ($d === '') return $d;
        if (strpos($d, '62') === 0) return $d;
        if ($d[0] === '0') return '62'.substr($d,1);
        if ($d[0] === '8') return '62'.$d;
        return $d;
    }

    private function _extract_phone_from_row($row): ?string
    {
        if (!$row) return null;
        foreach (['no_hp','wa','whatsapp','wa_number','no_wa','no_whatsapp','hp','telepon','telp','phone'] as $col) {
            if (isset($row->$col) && trim((string)$row->$col) !== '') {
                $num = trim((string)$row->$col);
                if (method_exists($this, '_normalize_msisdn_id')) {
                    $num = $this->_normalize_msisdn_id($num);
                }
                return $num;
            }
        }
        return null;
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
        $this->form_validation->set_rules('tempat_lahir','Tempat Lahir','required|trim');
        $this->form_validation->set_rules('alamat','Alamat','required|trim');
        $this->form_validation->set_rules('tanggal_lahir','Tanggal Lahir','required|trim');

        // NIK 16 digit
        // NIK 16 | NIP 18/9 | NRP 8–9 digit
        $this->form_validation->set_rules(
            'nik',
            'NIK/NIP/NRP',
            'required|trim|regex_match[/^(?:\d{16}|\d{18}|\d{8,9})$/]',
            ['regex_match' => '* %s harus: NIK 16 digit, NIP 18/9 digit, atau NRP 8–9 digit (angka saja)']
        );


        // No HP 10–13 digit
        $this->form_validation->set_rules(
            'no_hp','No HP',
            'required|trim|regex_match[/^[0-9]{10,13}$/]',
            ['regex_match' => '* %s harus 10–13 digit angka']
        );

        // Tujuan internal Lapas
        $this->form_validation->set_rules('unit_tujuan','Unit Tujuan','required');

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
        $errors   = [];
        $tanggal  = trim((string)$tanggal);
        $jam_raw  = trim((string)$jam_raw);
        $jam      = null;

    // --- Ambil lead time dari pengaturan website ---
    // Prioritas: $this->fm->web_me(), fallback ke $this->om->web_me()
        $web = null;
        if (isset($this->fm) && method_exists($this->fm, 'web_me')) {
            $web = $this->fm->web_me();
        } elseif (isset($this->om) && method_exists($this->om, 'web_me')) {
            $web = $this->om->web_me();
        }
        $min_lead_minutes = 0;
        if ($web && isset($web->min_lead_minutes)) {
            $min_lead_minutes = (int)$web->min_lead_minutes;
        // jaga-jaga agar tidak nilai aneh
            if ($min_lead_minutes < 0) $min_lead_minutes = 0;
        if ($min_lead_minutes > 240) $min_lead_minutes = 240; // batas 4 jam (opsional)
    }

    // --- Validasi tanggal ---
    $dt = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!$dt || $dt->format('Y-m-d') !== $tanggal) {
        $errors[] = '* Tanggal tidak valid (format harus YYYY-MM-DD).';
    } else {
        $today = date('Y-m-d');
        if (strtotime($tanggal) < strtotime($today)) {
            $errors[] = '* Tanggal tidak boleh mundur (minimal hari ini).';
        }

        $hari = (int) date('w', strtotime($tanggal)); // 0=Min, 1=Sen, ...
        if ($hari === 0) {
            $errors[] = '* Hari Minggu libur, tidak bisa booking.';
        }

        // --- Validasi jam ---
        if ($jam_raw === '') {
            $errors[] = '* Jam harus diisi.';
        } else {
            // normalisasi "16.30" -> "16:30"
            $jam_norm = str_replace('.', ':', $jam_raw);
            $jam_norm = preg_replace('/\s+/', '', $jam_norm);

            if (!preg_match('/^(?:[01]?\d|2[0-3]):[0-5]\d$/', $jam_norm)) {
                $errors[] = '* Format jam tidak valid (pakai HH:MM, contoh 16:55).';
            } else {
                list($hh, $mm) = explode(':', $jam_norm);
                $hh = (int)$hh; $mm = (int)$mm;
                $jam = sprintf('%02d:%02d', $hh, $mm);
                $menit = $hh * 60 + $mm;

                // Jam operasional
                if     ($hari >= 1 && $hari <= 4) { $min=480; $max=900; }   // Sen–Kam 08:00–15:00
                elseif ($hari === 5)              { $min=480; $max=840; }   // Jum      08:00–14:00
                else                               { $min=480; $max=690; }   // Sab      08:00–11:30

                if ($tanggal === $today) {
                    // Minimal menit untuk HARI INI = max(jam buka, sekarang + lead)
                    $nowMin    = ((int)date('H')) * 60 + ((int)date('i')) + $min_lead_minutes;
                    $min_today = max($min, $nowMin);

                    if ($min_today > $max) {
                        $errors[] = '* Jadwal operasional hari ini sudah berakhir.';
                    } else {
                        if ($menit < $min_today) {
                            $minLabel = sprintf('%02d:%02d', intdiv($min_today,60), $min_today%60);
                            $errors[] = '* Untuk hari ini, jam minimal adalah '.$minLabel
                            . ($min_lead_minutes ? ' (lead '.$min_lead_minutes.' menit).' : '.');
                        }
                        if ($menit > $max) {
                            $maxLabel = sprintf('%02d:%02d', intdiv($max,60), $max%60);
                            $errors[] = '* Jam melewati jam operasional (maksimal '.$maxLabel.').';
                        }
                    }
                } else {
                    // Bukan hari ini → hanya cek dalam range operasional
                    if ($menit < $min || $menit > $max) {
                        $errors[] = '* Jam kunjungan tidak sesuai dengan jadwal operasional.';
                    }
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

    /**
 * Validasi kuota harian per unit.
 * Return: [ok(bool), sisa(int|null), terpakai(int), kuota(int|null), err(string)]
 * - kuota NULL/<=0 dianggap tak dibatasi.
 * - $lock=true → kunci baris unit untuk mencegah race (dipakai di dalam transaksi).
 */
private function _validate_kuota_harian(int $unit_id, string $tanggal, bool $lock = false): array
{
    // Ambil kuota & nama unit
    if ($lock) {
        $unit = $this->db->query(
            'SELECT kuota_harian, nama_unit FROM unit_tujuan WHERE id = ? FOR UPDATE',
            [$unit_id]
        )->row();
    } else {
        $unit = $this->db->select('kuota_harian, nama_unit')
                         ->get_where('unit_tujuan', ['id'=>$unit_id])->row();
    }

    if (!$unit) {
        return [false, null, 0, null, 'Unit tujuan tidak ditemukan.'];
    }

    $kuota = isset($unit->kuota_harian) ? (int)$unit->kuota_harian : 0;
    $kuota = $kuota > 0 ? $kuota : null; // null = tak dibatasi

    // Hitung terpakai di tanggal tsb
    $this->db->select('COUNT(1) AS jml', false)
             ->from('booking_tamu')
             ->where('unit_tujuan', $unit_id)
             ->where('tanggal', $tanggal);

    // Hanya hitung yang aktif/berlaku
    if ($this->db->field_exists('status', 'booking_tamu')) {
        $this->db->where_in('status', ['pending','approved','checked_in']);
    }
    if ($this->db->field_exists('token_revoked', 'booking_tamu')) {
        $this->db->where('token_revoked', 0);
    }
    if ($this->db->field_exists('checkout_at', 'booking_tamu')) {
        $this->db->group_start()
                 ->where('checkout_at IS NULL', NULL, FALSE)
                 ->or_where('checkout_at', '')
                 ->group_end();
    }

    $terpakai = (int)($this->db->get()->row('jml') ?? 0);

    if ($kuota === null) {
        return [true, null, $terpakai, null, '']; // tak dibatasi
    }

    if ($terpakai >= $kuota) {
        $tgl_view = date('d-m-Y', strtotime($tanggal));
        $err = sprintf(
            'Kuota harian untuk unit <b>%s</b> pada tanggal <b>%s</b> sudah penuh (kuota %d, terpakai %d).',
            $unit->nama_unit ?? '-', $tgl_view, $kuota, $terpakai
        );
        return [false, 0, $terpakai, $kuota, $err];
    }

    $sisa = max(0, $kuota - $terpakai);
    return [true, $sisa, $terpakai, $kuota, ''];
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

   private function _make_kode_booking(int $len = 6): string
    {
        // Hindari karakter membingungkan: I, O, 0, 1
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $alphabetLen = strlen($alphabet);

        $gen = function(int $n) use ($alphabet, $alphabetLen) {
            $s = '';
            for ($i = 0; $i < $n; $i++) {
                $s .= $alphabet[random_int(0, $alphabetLen - 1)];
            }
            return $s;
        };

        // Coba beberapa kali sampai dapat yang unik
        for ($try = 0; $try < 20; $try++) {
            $code = $gen($len);
            $exists = $this->db->select('1', false)
                ->from('booking_tamu')
                ->where('kode_booking', $code)
                ->limit(1)->get()->num_rows() > 0;

            if (!$exists) return $code;
        }

        // Fallback: panjang +2 jika (sangat jarang) semua bentrok
        return $gen($len + 2);
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
        // false = overwrite file QR asli, true = simpan file baru dengan sufiks
                $this->_qr_overlay_logo($dir.$file, $logo_path, 0.22, false);
            }
        }

        return base_url('uploads/qr/'.$file);
    }

    /**
     * Tempelkan logo ke tengah QR code.
     *
     * @param string  $qr_path      Path file QR (png/jpg)
     * @param string  $logo_path    Path file logo (png/jpg, png transparan didukung)
     * @param float   $scale        Skala lebar logo relatif lebar QR (0.10–0.35 disarankan)
     * @param bool    $save_as_new  true = simpan ke file baru (pakai suffix), false = overwrite
     * @param string  $suffix       Sufiks nama file baru jika $save_as_new = true (mis. _logo)
     * @return string|false         Path output bila sukses, false bila gagal
     */
    private function _qr_overlay_logo($qr_path, $logo_path, $scale = 0.22, $save_as_new = false, $suffix = '_logo')
    {
        try {
            if (!is_file($qr_path) || !is_file($logo_path)) {
                log_message('error', 'QR/Logo path tidak ditemukan.');
                return false;
            }

            // --- helper buat image dari file (png/jpg) ---
            $makeImg = function($path) {
                $info = getimagesize($path);
                if (!$info) return [null, null];
                switch ($info[2]) {
                    case IMAGETYPE_PNG:  $img = imagecreatefrompng($path);  $ext = 'png';  break;
                    case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($path); $ext = 'jpg';  break;
                    default: return [null, null];
                }
                return [$img, $ext];
            };

            list($qr,   $qrExt)   = $makeImg($qr_path);
            list($logo, $logoExt) = $makeImg($logo_path);
            if (!$qr || !$logo) {
                log_message('error', 'Gagal membaca gambar (format harus PNG/JPG).');
                return false;
            }

            // pastikan canvas truecolor + alpha untuk PNG
            imagealphablending($qr, true);
            imagesavealpha($qr, true);
            imagealphablending($logo, true);
            imagesavealpha($logo, true);

            $qr_w = imagesx($qr);  $qr_h = imagesy($qr);
            $lg_w = imagesx($logo);$lg_h = imagesy($logo);

            // clamp scale
            $scale = max(0.10, min(0.35, (float)$scale));

            // ukuran logo target (proporsional)
            $target_w = (int) round($qr_w * $scale);
            $target_h = (int) round($lg_h * ($target_w / max(1, $lg_w)));

            // posisi tengah
            $dst_x = (int) round(($qr_w - $target_w) / 2);
            $dst_y = (int) round(($qr_h - $target_h) / 2);

            // resize logo ke buffer agar hasil tajam
            $logo_resized = imagecreatetruecolor($target_w, $target_h);
            // jaga transparansi
            imagealphablending($logo_resized, false);
            imagesavealpha($logo_resized, true);
            $transparent = imagecolorallocatealpha($logo_resized, 0, 0, 0, 127);
            imagefilledrectangle($logo_resized, 0, 0, $target_w, $target_h, $transparent);

            imagecopyresampled($logo_resized, $logo, 0, 0, 0, 0, $target_w, $target_h, $lg_w, $lg_h);

            // tempel ke QR
            imagecopy($qr, $logo_resized, $dst_x, $dst_y, 0, 0, $target_w, $target_h);

            // tentukan output path
            if ($save_as_new) {
                $pi = pathinfo($qr_path);
                $out = $pi['dirname'].'/'.$pi['filename'].$suffix.'.png'; // output sebagai PNG
            } else {
                $out = $qr_path; // timpa file asli
            }

            // simpan PNG dengan kualitas baik (0-9 → 6 kompromi)
            $ok = imagepng($qr, $out, 6);
            imagedestroy($qr);
            imagedestroy($logo);
            imagedestroy($logo_resized);

            if (!$ok) {
                log_message('error', 'Gagal menyimpan QR hasil overlay.');
                return false;
            }
            return $out;
        } catch (Throwable $e) {
            log_message('error', 'QR overlay error: '.$e->getMessage());
            return false;
        }
    }


   public function contact_vcf()
    {
        $path = FCPATH.'uploads/contact-silaturahmi.vcf';
        if ( ! is_file($path)) { show_404(); return; }

        $this->load->helper('download');
        $filename = 'SilaturahmiMakassar.vcf';

        // Paksa unduh
        force_download($filename, file_get_contents($path));
        exit;
    }




    private function _send_wa_konfirmasi($no_hp, array $d)
    {
        // (A) ambil token lebih dulu
        $token = !empty($d['access_token']) ? $d['access_token'] : null;

        // (B) bangun redirect_url aman
        $redirect_url = !empty($d['redirect_url'])
            ? $d['redirect_url']
            : ($token ? site_url('booking/booked').'?t='.urlencode($token) : site_url('booking'));

        // (C) data utama
        $nama          = $d['nama']             ?? '-';
        $keperluan     = $d['keperluan']        ?? '-';
        $kode          = trim((string)($d['kode'] ?? ''));   // kosong = tidak buat link PDF
        $instansi_asal = $d['instansi_asal']    ?? '-';
        $nama_petugas_instansi = $d['nama_petugas_instansi'] ?? '-';
        $unit_tujuan   = $d['unit_tujuan']      ?? '-';
        $tanggal_disp  = !empty($d['tanggal']) ? date('d-m-Y', strtotime($d['tanggal'])) : '-';

        // (D) rapikan jam (boleh pakai parser longgar seperti di atas jika perlu)
        $jam_disp      = isset($d['jam']) ? $d['jam'] : '-';

        // (E) link PDF (hanya jika ada $kode) + sertakan token
        // $pdf_url = site_url('booking/download_gate').'?k='.rawurlencode($kode).'&t='.urlencode($token); // gateway, bukan print_pdf langsung
        // (E) link PDF (gateway) — HANYA kalau $kode & $token ada
        $pdf_url = $d['pdf_url'] ?? '';
        if ($pdf_url === '' && $kode !== '' && $token) {
            $pdf_url = site_url('booking/download_gate').'?k='.rawurlencode($kode).'&t='.urlencode($token);
        }


      

        // (F) web_me
        $web = $this->fm->web_me();

        // (G) susun & kirim pesan (tampilkan PDF hanya jika ada)
        $pesan  = "*[Konfirmasi Booking Kunjungan]*\n\n";
        $pesan .= "Halo *{$nama}*,\n\n";
        $pesan .= "Pengajuan kunjungan Anda telah *BERHASIL* didaftarkan dengan detail berikut:\n\n";
        $pesan .= "🆔 Kode Booking : *{$kode}*\n";
        $pesan .= "👤 Nama Tamu : {$nama}\n";
        $pesan .= "🏢 Instansi Asal : {$instansi_asal}\n";
        $pesan .= "🏛️ Unit Tujuan : {$unit_tujuan}\n";
        $pesan .= "👔 Pejabat Unit : {$nama_petugas_instansi}\n";
        $pesan .= "📅 Tanggal : {$tanggal_disp}\n";
        $pesan .= "🕒 Jam : {$jam_disp}\n";
        $pesan .= "📝 Keperluan : {$keperluan}\n\n";
        if ($pdf_url !== '') {
            $pesan .= "🔳 Download kode booking (PDF):\n{$pdf_url}\n\n";
        }
        $pesan .= "🔗 Detail booking:\n{$redirect_url}\n\n";
        $pesan .= "📇 Simpan kontak kami agar link bisa diklik langsung\n\n";
        $pesan .= "_Pesan ini dikirim otomatis oleh Aplikasi {$web->nama_website}._";

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
        $data["rec"]        = $this->fm->web_me();

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

    private function _send_wa_info_unit(string $hp_unit, array $d): bool
    {
        if (!function_exists('send_wa_single')) {
            log_message('error', 'send_wa_single tidak tersedia.');
            return false;
        }

        // --- Normalisasi nomor tujuan (unit) ---
        if (method_exists($this, '_normalize_msisdn_id')) {
            $hp_unit = $this->_normalize_msisdn_id($hp_unit); // pastikan 62xxxxxxxxx
        } else {
            $hp_unit = preg_replace('/\D+/', '', $hp_unit ?? '');
            if ($hp_unit !== '' && $hp_unit[0] === '0') $hp_unit = '62'.substr($hp_unit,1);
        }
        if ($hp_unit === '') {
            log_message('error', 'WA unit kosong setelah normalisasi.');
            return false;
        }

        // --- web_me dengan fallback & default aman ---
        $web = null;
        if (isset($this->fm) && method_exists($this->fm, 'web_me'))       $web = $this->fm->web_me();
        elseif (isset($this->om) && method_exists($this->om, 'web_me'))   $web = $this->om->web_me();
        $app_name = $web->nama_website ?? 'Aplikasi';

        // --- Helper kecil untuk aman di WA ---
        $wa_plain = function($s){
            $s = (string)$s;
            // escape karakter markdown dasar: * _ ~ `
            return str_replace(['*','_','~','`'], ['\*','\_','\~','\`'], $s);
        };

        // --- Ambil & rapikan data ---
        $kode        = trim((string)($d['kode'] ?? ''));
        $nama        = $wa_plain(trim((string)($d['nama'] ?? '-')));
        $no_hp_tamu  = trim((string)($d['hp_tamu'] ?? ''));
        $instansi    = $wa_plain(trim((string)($d['instansi_asal'] ?? '-')));
        $child_unit  = $wa_plain(trim((string)($d['child_unit_nama'] ?? ($d['unit_nama'] ?? '-'))));
        $unit_nama   = $wa_plain(trim((string)($d['unit_nama'] ?? '-')));
        $unit_pej    = $wa_plain(trim((string)($d['unit_pejabat'] ?? '')));
        $pendamping  = (int)($d['pendamping'] ?? 0);
        $keperluan   = $wa_plain(trim((string)(($d['keperluan'] ?? '-') ?: '-')));
        $redir       = trim((string)($d['redirect_url'] ?? ''));
        // $qr_url      = trim((string)($d['qr_url'] ?? ''));
        $is_cc       = !empty($d['is_cc']);

        // Tanggal (validasi format Y-m-d agar tidak jadi 1970)
        $tanggal_disp = '-';
        if (!empty($d['tanggal'])) {
            $dt = DateTime::createFromFormat('Y-m-d', (string)$d['tanggal']);
            if ($dt && $dt->format('Y-m-d') === (string)$d['tanggal']) {
                $tanggal_disp = $dt->format('d-m-Y');
            }
        }
        // Jam sederhana
        $jam_disp      = isset($d['jam']) ? $d['jam'] : '-';

        // Link WA tamu (hanya jika valid)
        $wa_link = '';
        if ($no_hp_tamu !== '') {
            $wa_digits = preg_replace('/\D+/', '', $no_hp_tamu);
            if ($wa_digits !== '') {
                if ($wa_digits[0] === '0') $wa_digits = '62'.substr($wa_digits,1);
                // minimal 8-10 digit setelah 62, biar tidak https://wa.me/ kosong
                if (strlen($wa_digits) >= 10) $wa_link = 'https://wa.me/'.$wa_digits;
            }
        }

        // Header
        $header = $is_cc ? '🔁 *TEMBUSAN PEMBERITAHUAN KUNJUNGAN*' : '📣 *PEMBERITAHUAN KUNJUNGAN*';

        // Kepada
        $kepada = "Kepada Yth.\n";
        $kepada .= ($unit_pej !== '') ? ('*'.$unit_pej.'* — *'.$unit_nama.'*') : ('*'.$unit_nama.'*');

        // Susun pesan
        $lines = [];
        $lines[] = $header;
        $lines[] = '';
        $lines[] = $kepada;
        $lines[] = '━━━━━━━━━━━━━━━━━━━━';
        $lines[] = '🆔 Kode Booking : *'.($kode !== '' ? $wa_plain($kode) : '-').'*';
        $lines[] = '👤 Tamu : '.$nama;
        if ($wa_link) $lines[] = '🟢 WhatsApp : '.$wa_link;
        $lines[] = '🏢 Instansi : '.$instansi;
        $lines[] = ($is_cc ? '🔎 Tembusan utk : *'.$child_unit.'*' : '🎯 Unit Tujuan : '.$child_unit);
        $lines[] = '📅 Tanggal : '.$tanggal_disp;
        $lines[] = '⏰ Jam : '.$jam_disp;
        $lines[] = '👥 Pendamping : '.$pendamping.' orang';
        $lines[] = '📝 Keperluan : '.$keperluan;
        // if ($qr_url !== '') { $lines[] = '🧾 QR           : '.$qr_url; }
        if ($redir  !== '') {
            $lines[] = '';
            $lines[] = '🔗 Detail kunjungan:';
            $lines[] = $redir;
        }
        $lines[] = '';
        $lines[] = 'Simpan nomor ini agar link dapat diklik';
        $lines[] = '_Pesan otomatis '.$app_name.'._';

        try {
            send_wa_single($hp_unit, implode("\n", $lines));
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
            foreach (glob($dir.'doc_'.$b->kode_booking.'_*.*') ?: [] as $f) {
                $list[] = [
                    'filename' => basename($f),
                    'url'      => base_url('uploads/dokumentasi/'.basename($f)),
                    'time'     => date('Y-m-d H:i:s', @filemtime($f))
                ];
            }
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

        // --- Fallback: multipart file ---
        if ($b64 === '' && !empty($_FILES)) {
            $f = $_FILES['image'] ?? $_FILES['doc_photo'] ?? null;
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

        // --- Parse dataURL (jpg/png) ---
        $b64 = preg_replace('/\s+/', ' ', $b64);
        $b64 = preg_replace('#^data:\s*image/([^;]+);base64,#i', 'data:image/$1;base64,', $b64);
        $payload = substr($b64, strpos($b64, ',')+1);
        $payload = strtr($payload, ' ', '+');
        if (!preg_match('#^data:image/(png|jpe?g);base64,#i', $b64, $m)) {
            return $this->json_exit(["ok"=>false, "msg"=>"Format gambar tidak valid"], 400);
        }
        $ext = strtolower($m[1]) === 'jpeg' ? 'jpg' : strtolower($m[1]);

        $bin = base64_decode($payload, true);
        if ($bin === false) return $this->json_exit(["ok"=>false,"msg"=>"Base64 rusak"],400);

        if (strlen($bin) > 5 * 1024 * 1024) {
            return $this->json_exit(["ok"=>false, "msg"=>"Ukuran gambar melebihi 5MB"], 413);
        }

        $info = @getimagesizefromstring($bin);
        if ($info === false) return $this->json_exit(["ok"=>false,"msg"=>"Berkas bukan gambar"],400);
        list($w, $h) = $info;

        $src = @imagecreatefromstring($bin);
        if (!$src) return $this->json_exit(["ok"=>false, "msg"=>"Gagal memproses gambar"], 500);
        $maxSide = 1600;
        $scale = min(1, $maxSide / max($w, $h));
        $nw = max(1, (int)floor($w * $scale));
        $nh = max(1, (int)floor($h * $scale));
        $dst = imagecreatetruecolor($nw, $nh);
        if ($ext === 'png') { imagealphablending($dst, false); imagesavealpha($dst, true); }
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

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
