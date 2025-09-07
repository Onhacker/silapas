<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_admin_dashboard","ma");
        date_default_timezone_set('Asia/Makassar');
        // cek_session_akses(get_class($this), $this->session->userdata('admin_session'));
    }

    /* =========================================================
     *               Helper JSON (aman & ringkas)
     * ========================================================= */
    private function json_exit($payload, int $status = 200, array $headers = [])
    {
        if (!is_string($payload)) {
            $payload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        foreach ($headers as $k => $v) {
            $this->output->set_header($k . ': ' . $v);
        }
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output($payload)
            ->_display();
        exit; // pastikan eksekusi berhenti
    }

    private function json_flush($payload, int $status = 200, array $headers = [])
    {
        if (!is_string($payload)) {
            $payload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        foreach ($headers as $k => $v) {
            $this->output->set_header($k . ': ' . $v);
        }
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output($payload)
            ->_display();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request(); // PHP-FPM
        } else {
            @ob_end_flush(); @flush();
        }
        // tidak exit; proses bisa lanjut bila diperlukan
    }

    /* =========================================================
     *                     ROUTE UTAMA
     * ========================================================= */
    public function index()
    {
        // Langsung arahkan ke dashboard (default bulanan)
        return $this->dashboard();
    }

    /* =========================================================
     *                     HAK AKSES (opsional)
     * ========================================================= */
    public function hak_akses()
    {
        $data["controller"] = get_class($this);
        $data["title"]      = "Hak Akses";
        $data["subtitle"]   = "Hak Akses Sistem";
        $data["record"]     = $this->om->profil("users")->row();

        $this->db->select('*');
        $this->db->from("modul");
        $this->db->join('users_modul', 'modul.id_modul = users_modul.id_modul');
        $this->db->where("users_modul.id_session", $this->session->userdata("admin_session"));
        $this->db->order_by("nama_modul", "ASC");
        $data["mod"] = $this->db->get();

        $data["content"] = $this->load->view($data["controller"]."_hak_akses_view",$data,true);
        $this->render($data);
    }

   

    /* =========================================================
     *                   NOTIFIKASI (opsional)
     * ========================================================= */
    public function cek_total_notif()
    {
        if (!$this->session->userdata("admin_login")) {
            echo json_encode(['total' => 0]);
            return;
        }

        $id_session = $this->session->userdata("admin_session");

        $asal_tabels = [];
        $cekper = $this->db->get_where("view_users_capil", ["id_session" => $id_session]);
        foreach ($cekper->result() as $t) { $asal_tabels[] = $t->nama_tabel; }

        $this->db->from('view_semua_paket');

        if ($this->session->userdata("admin_level") != "admin") {
            $this->db->where_in('status', [3, 4]);
            $this->db->where('YEAR(update_time)', date('Y'));
            $this->db->where('id_desa', $this->session->userdata("id_desa"));
            $this->db->where('username', $this->session->userdata("admin_username"));
            $this->db->where('status_baca', 0);
        } else {
            if (!empty($asal_tabels)) {
                $this->db->where_in("asal_tabel", $asal_tabels);
            }
            $this->db->where_in('status', [2]);
            $this->db->where('YEAR(update_time)', date('Y'));
            $this->db->where('status_baca', 0);
        }

        $total = $this->db->count_all_results();
        echo json_encode(['total' => $total]);
    }



    public function cek_notifikasi()
    {
        $id_session     = $this->session->userdata("admin_session");
        $admin_level    = $this->session->userdata("admin_level");
        $admin_username = $this->session->userdata("admin_username");

        $asal_tabels = [];
        $cekper = $this->db->get_where("view_users_capil", ["id_session" => $id_session]);
        foreach ($cekper->result() as $t) { $asal_tabels[] = $t->nama_tabel; }

        $this->db->select('*');
        $this->db->limit(8);
        $this->db->from('view_semua_paket');

        if ($admin_level != "admin") {
            $this->db->where_in('status', [3, 4]);
            $this->db->where('id_desa', $this->session->userdata("id_desa"));
            $this->db->where('username', $admin_username);
            $this->db->where('status_baca', 0);
        } else {
            $this->db->where_in('status', [2]);
            $this->db->where('status_baca', 0);
            if (!empty($asal_tabels) && $admin_username != 'admin') {
                $this->db->where_in("asal_tabel", $asal_tabels);
            }
        }

        $this->db->order_by('update_time', 'DESC');
        $query = $this->db->get()->result();

        $data = [];
        foreach ($query as $q) {
            if ($admin_level != "admin") {
                $data[] = [
                    'icon'    => $q->status == 3 ? "fas fa-check-circle text-success" : "fas fa-times-circle text-danger",
                    'text'    => waktu_lalu($q->update_time),
                    'message' => "Permohonan <b>{$q->nama_permohonan}</b> atas nama <b>{$q->nama_pemohon}</b> ".($q->status == 3 ? "Telah Disetujui" : "Ditolak"),
                    'link'    => site_url("admin_permohonan/detail_pemohon/{$q->asal_tabel}/{$q->id_paket}"),
                    'tabel'   => $q->asal_tabel,
                    'id_paket'=> $q->id_paket,
                    'status'  => $q->status,
                ];
            } else {
                $data[] = [
                    'icon'    => "fas fa-exclamation-circle text-warning",
                    'text'    => waktu_lalu($q->update_time),
                    'message' => "Segera proses permohonan <b>{$q->nama_permohonan}</b> atas nama <b>{$q->nama_pemohon}</b>.",
                    'link'    => site_url("admin_permohonan/detail_pemohon/{$q->asal_tabel}/{$q->id_paket}"),
                    'tabel'   => $q->asal_tabel,
                    'id_paket'=> $q->id_paket,
                    'status'  => $q->status,
                ];
            }
        }

        echo json_encode($data);
    }

    public function mark_as_read()
    {
        $id_paket = $this->input->post('id_paket');
        $tabel    = $this->input->post('tabel');

        if ($id_paket && $tabel) {
            $this->db->update($tabel, ['status_baca' => 1], ['id_paket' => $id_paket]);
            echo json_encode(['success' => $this->db->affected_rows() > 0]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    /* =========================================================
     *                    MONITOR (LAYAR UTAMA)
     * ========================================================= */
    public function monitor()
    {
        $data["record"]    = $this->om->profil("users")->row();
        $data["controller"]= get_class($this);
        $data["title"]     = "Layar Utama";
        $data["subtitle"]  = "Daftar Booking & Sedang Berkunjung";
        $data["content"]   = $this->load->view('Admin_dashboard_monitor_view', $data, true);
        $this->render($data);
    }

    /**
     * API data layar utama
     * GET:
     *   q        = keyword (opsional)
     *   page     = halaman (default 1)
     *   per_page = jumlah baris per halaman (default 15, max 100)
     * Return JSON:
     *   - booked       : daftar semua booking (pending/approved) yang BELUM check-in (tanpa filter tanggal)
     *   - in_visit     : daftar yang sudah check-in & belum checkout
     *   - server_time  : waktu server ISO8601 (untuk jam live di UI)
     */
public function monitor_data()
{
    $q        = trim((string)$this->input->get('q', true));
    $page     = max(1, (int)$this->input->get('page'));
    $per_page = (int)$this->input->get('per_page');
    if ($per_page <= 0 || $per_page > 100) $per_page = 15;
    $offset   = ($page - 1) * $per_page;
    $like     = ($q !== '') ? $this->db->escape_like_str($q) : null;

    // ===== helper filter "Sudah Booking" (pending/approved, belum check-in, TIDAK expired)
    $apply_filters = function() use ($like) {
        $this->db->where('b.checkin_at IS NULL', null, false);
        $this->db->where_in('b.status', ['approved','pending']); // cukup pakai kolom langsung (collation sudah _ci)
        $this->db->where('b.status <>', 'expired');              // pastikan bukan expired
        if ($like !== null) {
            $this->db->group_start()
                ->like('b.kode_booking',            $like, 'both', false)
                ->or_like('b.nama_tamu',            $like, 'both', false)
                ->or_like('b.nik',                  $like, 'both', false)
                ->or_like('b.no_hp',                $like, 'both', false)
                ->or_like('b.keperluan',            $like, 'both', false)
                ->or_like('b.target_instansi_nama', $like, 'both', false)
                ->or_like('b.instansi',             $like, 'both', false)
                ->or_like('u.nama_unit',            $like, 'both', false)
                ->or_like('b.nama_petugas_instansi',$like, 'both', false)
            ->group_end();
        }
    };

    // ===== total booked (untuk pagination)
    $this->db->reset_query();
    $this->db->select('b.id_booking');
    $this->db->from('booking_tamu b');
    $this->db->join('unit_tujuan u','u.id=b.unit_tujuan','left');
    $apply_filters();
    $booked_total = (int)$this->db->count_all_results();

    // ===== data booked (halaman berjalan)
    $this->db->reset_query();
    $this->db->select('b.*, u.nama_unit');
    $this->db->from('booking_tamu b');
    $this->db->join('unit_tujuan u','u.id=b.unit_tujuan','left');
    $apply_filters();
    $this->db->order_by('b.tanggal','ASC');
    $this->db->order_by('b.jam','ASC');
    $this->db->limit($per_page, $offset);
    $booked_rows = $this->db->get()->result_array();

    // ===== Sedang berkunjung (sudah check-in & belum checkout), TIDAK expired
    $this->db->reset_query();
    $this->db->select('b.*, u.nama_unit');
    $this->db->from('booking_tamu b');
    $this->db->join('unit_tujuan u','u.id=b.unit_tujuan','left');
    $this->db->where('b.checkin_at IS NOT NULL', null, false);
    $this->db->where('b.checkout_at IS NULL', null, false);
    $this->db->where('b.status <>', 'expired');          // exclude expired
    // (opsional lebih ketat) kalau mau hanya yang status 'checked_in', aktifkan baris di bawah:
    // $this->db->where('b.status', 'checked_in');
    $this->db->order_by('b.checkin_at','DESC');
    $invisit = $this->db->get()->result_array();

    // ===== mapper baris ke format UI (pakai nama_petugas_instansi dari booking_tamu)
    $map = function($r) {
        $petugas = trim((string)($r['nama_petugas_instansi'] ?? ''));
        $pend    = isset($r['jumlah_pendamping']) ? (int)$r['jumlah_pendamping'] : 0;

        return [
            'kode'               => (string)$r['kode_booking'],
            'nama'               => (string)$r['nama_tamu'],
            'unit'               => (string)($r['nama_unit'] ?: '-'),
            'instansi'           => (string)($r['target_instansi_nama'] ?: ($r['instansi'] ?: '-')),
            'jam'                => (string)($r['jam'] ?: ''),
            'tanggal'            => (string)($r['tanggal'] ?: ''),
            'status'             => strtolower((string)$r['status']),
            'checkin_at'         => (string)($r['checkin_at'] ?: ''),
            'checkout_at'        => (string)($r['checkout_at'] ?: ''),
            'jumlah_pendamping'  => $pend,
            'nama_petugas_instansi' => $petugas,
            'petugas_unit'          => $petugas, // alias untuk UI
            'petugas'               => $petugas, // alias untuk UI
            'detail_url'            => site_url('admin_scan/detail/'.rawurlencode($r['kode_booking'])),
        ];
    };

    $total_pages = ($booked_total > 0) ? (int)ceil($booked_total / $per_page) : 0;

    $this->json_exit([
        'ok'            => true,
        'scope'         => 'all',
        'q'             => $q,
        'page'          => $page,
        'per_page'      => $per_page,
        'booked_total'  => $booked_total,
        'booked_pages'  => $total_pages,
        'booked'        => array_map($map, $booked_rows),
        'in_visit'      => array_map($map, $invisit),
        'count_booked'  => $booked_total,
        'count_visit'   => count($invisit),
        'server_time'   => date('c'),
    ]);
}




    /* =========================================================
     *                        DASHBOARD
     * ========================================================= */
    public function dashboard()
    {
        $data["controller"]     = get_class($this);
        $data["title"]          = "Dashboard Kunjungan";
        $data["subtitle"]       = "Harian • Mingguan • Bulanan";
        $data["default_period"] = "month"; // default tampilan = Bulanan

        // ganti sesuai nama file view dashboard Anda
        $view_file = 'Admin_dashboard_dash';

        $data["content"] = $this->load->view($view_file, $data, true);
        $this->render($data);
    }

    /**
     * API data dashboard
     * GET:
     *   period = day | week | month   (default: month)
     *   date   = YYYY-MM-DD           (opsional; default: hari ini)
     *
     * Output:
     *   totals: { visitors, unique_instansi }
     *   top_instansi: [{label, qty}...]
     *   top_units   : [{label, qty}...]
     *   trend: { labels:[], data:[] }  // day=per jam, week=per hari (Sen-Min), month=per tanggal
     */
    public function dashboard_data()
    {
        $period = strtolower((string)$this->input->get('period', true));
        if (!in_array($period, ['day','week','month'])) {
            $period = 'month'; // default bulanan
        }

        $dateParam = $this->input->get('date', true);
        $baseTs    = $dateParam ? strtotime($dateParam) : time();

        if ($period === 'day') {
            $start     = date('Y-m-d 00:00:00', $baseTs);
            $end       = date('Y-m-d 23:59:59', $baseTs);
            $trendBins = range(0, 23); // per jam
        } elseif ($period === 'week') {
            $monday    = strtotime('monday this week', $baseTs);
            $start     = date('Y-m-d 00:00:00', $monday);
            $end       = date('Y-m-d 23:59:59', strtotime('sunday this week', $baseTs));
            $trendBins = range(0, 6); // 0..6 (Sen..Min)
        } else { // 'month'
            $first     = strtotime(date('Y-m-01', $baseTs));
            $last      = strtotime(date('Y-m-t',  $baseTs));
            $start     = date('Y-m-d 00:00:00', $first);
            $end       = date('Y-m-d 23:59:59', $last);
            $trendBins = range(1, (int)date('t', $first)); // 1..t
        }

        $db      = $this->db;
        $between = "checkin_at BETWEEN ".$db->escape($start)." AND ".$db->escape($end);

        // Total pengunjung (berdasar yang check-in pada periode)
        $rowTotal = $db->query("SELECT COUNT(*) c FROM booking_tamu WHERE $between")->row_array();
        $totalVisitors = (int)($rowTotal['c'] ?? 0);

        // Jumlah instansi unik (asal kunjungan) selama periode
        $rowInstUniq = $db->query("
            SELECT COUNT(DISTINCT NULLIF(COALESCE(NULLIF(target_instansi_nama,''), NULLIF(instansi,'')), '')) c
            FROM booking_tamu WHERE $between
        ")->row_array();
        $uniqueInstansi = (int)($rowInstUniq['c'] ?? 0);

        // Top Instansi (asal)
        $topInst = $db->query("
            SELECT 
                COALESCE(NULLIF(target_instansi_nama,''), NULLIF(instansi,''), 'Tidak diketahui') AS label,
                COUNT(*) AS qty
            FROM booking_tamu
            WHERE $between
            GROUP BY label
            ORDER BY qty DESC
            LIMIT 5
        ")->result_array();

        // Top Unit (teramai)
        $topUnit = $db->query("
            SELECT 
                COALESCE(u.nama_unit, CONCAT('Unit#', bt.unit_tujuan)) AS label,
                COUNT(*) AS qty
            FROM booking_tamu bt
            LEFT JOIN unit_tujuan u ON u.id = bt.unit_tujuan
            WHERE $between
            GROUP BY label
            ORDER BY qty DESC
            LIMIT 5
        ")->result_array();

        // Tren (sesuai period)
        if ($period === 'day') {
            $rows = $db->query("
                SELECT HOUR(checkin_at) h, COUNT(*) c
                FROM booking_tamu
                WHERE $between
                GROUP BY HOUR(checkin_at)
            ")->result_array();
            $map    = [];
            foreach ($rows as $r) $map[(int)$r['h']] = (int)$r['c'];
            $labels = array_map(function($h){ return sprintf('%02d:00', $h); }, $trendBins);
            $data   = array_map(function($h) use ($map){ return $map[$h] ?? 0; }, $trendBins);
        } elseif ($period === 'week') {
            $rows = $db->query("
                SELECT WEEKDAY(DATE(checkin_at)) d, COUNT(*) c
                FROM booking_tamu
                WHERE $between
                GROUP BY WEEKDAY(DATE(checkin_at))
            ")->result_array();
            $map    = [];
            foreach ($rows as $r) $map[(int)$r['d']] = (int)$r['c'];
            $hari   = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
            $labels = array_map(function($i) use ($hari){ return $hari[$i]; }, $trendBins);
            $data   = array_map(function($i) use ($map){ return $map[$i] ?? 0; }, $trendBins);
        } else {
            $rows = $db->query("
                SELECT DAY(checkin_at) d, COUNT(*) c
                FROM booking_tamu
                WHERE $between
                GROUP BY DAY(checkin_at)
            ")->result_array();
            $map    = [];
            foreach ($rows as $r) $map[(int)$r['d']] = (int)$r['c'];
            $labels = array_map(function($d){ return (string)$d; }, $trendBins);
            $data   = array_map(function($d) use ($map){ return $map[$d] ?? 0; }, $trendBins);
        }

        $this->json_exit([
            'ok'          => true,
            'period'      => $period,      // day|week|month
            'start'       => $start,
            'end'         => $end,
            'server_time' => date('c'),

            'totals' => [
                'visitors'        => $totalVisitors,
                'unique_instansi' => $uniqueInstansi,
            ],
            'top_instansi' => $topInst,
            'top_units'    => $topUnit,

            'trend' => [
                'labels' => $labels,
                'data'   => $data,
            ],
        ]);
    }
private function _emit($msg)
    {
        // 1) tampilkan (CLI / web)
        $this->output->set_content_type('text/plain')->set_output($msg);

        // 2) tulis ke file di public_html (biasanya writable di Hostinger)
        @file_put_contents(FCPATH.'cron_debug.log', $msg, FILE_APPEND);

        // 3) tulis ke application/logs
        @file_put_contents(APPPATH.'logs/cron_debug.log', $msg, FILE_APPEND);

        // 4) tulis ke CI log
        log_message('error', trim($msg));
    }
   /**
     * Jalankan via CLI:
     *   php index.php cron expire_bookings [grace_minutes]
     * Contoh:
     *   php index.php cron expire_bookings 30
     */
  // --- simpan versi ini, hapus versi cron_test lain ---
public function cron_test($param = 'default')
{
    // Tulis file pasti—tanpa syarat apa pun:
    @file_put_contents(FCPATH.'cron_touch.txt',
        "TOUCHED @ ".date('c')." param={$param}\n", FILE_APPEND);

    // Tulis juga ke application/logs
    @file_put_contents(APPPATH.'logs/cron_debug.log',
        "CRON_TEST @ ".date('c')." param={$param} file=".__FILE__." apppath=".APPPATH."\n", FILE_APPEND);

    // Keluarkan teks langsung (kalau STDOUT tidak dimakan host, ini akan terlihat)
    echo "cron_test HIT @ ".date('c')." param={$param}\n";

    // Hentikan eksekusi supaya output langsung flush
    exit(0);
}


public function expire_bookings($grace_minutes = 30)
{
    // sementara: izinkan via browser untuk verifikasi (?web=1)
    if (!$this->input->is_cli_request() && $this->input->get('web') !== '1') {
        show_404();
        return;
    }

    $grace = (int)$grace_minutes;
    if ($grace < 0 || $grace > 1440) $grace = 30;

    if (isset($this->ma) && method_exists($this->ma, 'expire_past_bookings')) {
        $affected = (int) $this->ma->expire_past_bookings($grace, 'Asia/Makassar');
    } else {
        $tz = new DateTimeZone('Asia/Makassar');
        $dt = new DateTime('now', $tz);
        if ($grace > 0) $dt->modify("-{$grace} minutes");
        $cutoff = $dt->format('Y-m-d H:i:s');

        $this->db->query("
            UPDATE booking_tamu
               SET status = 'expired',
                   expired_at = NOW()
             WHERE checkin_at IS NULL
               AND status IN ('pending','approved')
               AND schedule_dt IS NOT NULL
               AND schedule_dt < ?
        ", [$cutoff]);

        $affected = $this->db->affected_rows();
    }

    $msg = "[EXPIRE] affected={$affected}, grace={$grace}m, at=".date('Y-m-d H:i:s')."\n";

    // tulis ke dua tempat + echo
    @file_put_contents(FCPATH.'cron_debug.log', $msg, FILE_APPEND);
    @file_put_contents(APPPATH.'logs/cron_debug.log', $msg, FILE_APPEND);
    echo $msg;

    log_message('error', "[CRON] ".trim($msg));
    exit(0);
}


    /**
     * Versi HTTP (opsional) — panggil via cron dengan GET param `token`.
     * Tambahkan config item 'cron_secret' di application/config/config.php:
     *   $config['cron_secret'] = 'gantilah_token_rahasia_ini';
     *
     * Contoh panggilan:
     // *   https://domainmu.com/index.php/cron/expire_bookings_http?token=gantilah_token_rahasia_ini&grace=30
     */
    public function expire_bookings_http()
    {
        $secret_cfg = $this->config->item('cron_secret');
        $token      = (string)$this->input->get('token', true);
        if (!$secret_cfg || $token !== $secret_cfg) {
            return $this->_json(['ok'=>false,'msg'=>'Forbidden'], 403);
        }

        $grace = (int)$this->input->get('grace', true);
        if ($grace < 0 || $grace > 1440) $grace = 30;

        $affected = $this->ma->expire_past_bookings($grace, 'Asia/Makassar');
        return $this->_json([
            'ok'       => true,
            'expired'  => $affected,
            'grace'    => $grace,
            'server'   => date('c'),
        ]);
    }

    /** Helper JSON ringkas */
    private function _json($payload, int $status = 200)
    {
        if (!is_string($payload)) {
            $payload = json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
        $this->output->set_status_header($status)
                     ->set_content_type('application/json','utf-8')
                     ->set_output($payload);
    }


}
