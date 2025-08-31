<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_admin_dashboard","ma");
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
     *                    UTIL WILAYAH (opsional)
     * ========================================================= */
    public function get_desa()
    {
        $id_kecamatan = $this->input->post('id');
        $data = $this->ma->arr_desa2($id_kecamatan);
        echo form_dropdown("id_desa", $data, "", 'id="id_desa_cari" class="form-control select2" onchange="get_dusun(this,\'#id_dusun_cari\',1)"');
    }

    public function get_dusun()
    {
        $id_desa = $this->input->post('id');
        $data = $this->ma->arr_dusun($id_desa);
        echo form_dropdown("id_dusun", $data, "", 'id="id_dusun_cari" class="form-control select2"');
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

    // Filter untuk "sudah booking" (pending/approved, belum check-in)
    // 1) Tambah kolom pejabat unit ke SELECT + LIKE
$this->db->reset_query();
$this->db->select('b.*, u.nama_unit, u.pejabat_unit');   // <-- tambah u.pejabat_unit
$this->db->from('booking_tamu b');
$this->db->join('unit_tujuan u','u.id=b.unit_tujuan','left');
$apply_filters = function() use ($like) {
    $this->db->where('b.checkin_at IS NULL', null, false);
    $this->db->where_in('LOWER(b.status)', ['approved','pending']);
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
            ->or_like('b.nama_petugas_instansi',$like, 'both', false) // <-- NEW
        ->group_end();
    }
};


    // Hitung total booking (untuk pagination)
   $this->db->reset_query();
$this->db->select('b.*, u.nama_unit, u.pejabat_unit'); // <-- tambah
$this->db->from('booking_tamu b');
$this->db->join('unit_tujuan u','u.id=b.unit_tujuan','left');
    $apply_filters();
    $booked_total = (int)$this->db->count_all_results();

    // Ambil data booking (halaman berjalan)
    $this->db->reset_query();
    $this->db->select('b.*, u.nama_unit'); // b.* sudah termasuk nama_petugas_unit & jumlah_pendamping
    $this->db->from('booking_tamu b');
    $this->db->join('unit_tujuan u','u.id=b.unit_tujuan','left');
    $apply_filters();
    $this->db->order_by('b.tanggal','ASC');
    $this->db->order_by('b.jam','ASC');
    $this->db->limit($per_page, $offset);
    $booked_rows = $this->db->get()->result_array();

    // Sedang berkunjung (sudah check-in & belum checkout) — tanpa pagination
    $this->db->reset_query();
    $this->db->select('b.*, u.nama_unit');
    $this->db->from('booking_tamu b');
    $this->db->join('unit_tujuan u','u.id=b.unit_tujuan','left');
    $this->db->where('b.checkin_at IS NOT NULL', null, false);
    $this->db->where('b.checkout_at IS NULL', null, false);
    $this->db->order_by('b.checkin_at','DESC');
    $invisit = $this->db->get()->result_array();

    // Mapper output baris (tambahkan nama_petugas_unit & jumlah_pendamping)
    // Mapper output baris (pakai nama_petugas_unit & sertakan jumlah_pendamping)
    // Mapper output baris (pakai kolom nama_petugas_instansi)
$map = function($r) {
    // Ambil nama petugas dengan fallback:
    $petugas = trim((string)(
        ($r['nama_petugas_instansi'] ?? '') !== '' ? $r['nama_petugas_instansi'] :
        ($r['pejabat_unit'] ?? '')
    ));

    $pend = isset($r['jumlah_pendamping']) ? (int)$r['jumlah_pendamping'] : 0;

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

        // kunci yang dipakai UI (prioritas nama_petugas_instansi)
        'nama_petugas_instansi' => $petugas,
        'petugas_unit'          => $petugas,   // alias
        'petugas'               => $petugas,   // alias

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

    public function live()
    {
        $sec  = (int) $this->input->get('sec', true);
        if ($sec < 5) { $sec = 5; } // default 45 detik
        $auto = (int) $this->input->get('auto', true) === 1;

        // Tab yang diputar (edit judul/url jika perlu)
        $tabs = [
            ['title' => 'Dashboard', 'url' => site_url('admin_dashboard/dashboard?live=1')],
            ['title' => 'Monitor',   'url' => site_url('admin_dashboard/monitor?live=1')],
        ];

        $tabsJson = json_encode($tabs, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        $autoJson = $auto ? 'true' : 'false';

        // HTML langsung dari controller (tanpa file view)
        $html = <<<HTML
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Live Wallboard</title>
<style>
  :root{--bg:#0b1220;--card:#0f172a;--text:#e5e7eb;--muted:#94a3b8;--accent:#22c55e}
  *{box-sizing:border-box}html,body{height:100%}body{margin:0;background:var(--bg);color:var(--text);font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial}
  .wrap{display:flex;flex-direction:column;height:100vh}
  .topbar{display:flex;align-items:center;justify-content:space-between;padding:.6rem 1rem;border-bottom:1px solid rgba(255,255,255,.08);background:rgba(255,255,255,.03)}
  .brand{display:flex;align-items:center;gap:.6rem}.brand .dot{width:10px;height:10px;border-radius:50%;background:var(--accent);box-shadow:0 0 0 0 rgba(34,197,94,.6);animation:ping 1.6s infinite}
  @keyframes ping{0%{box-shadow:0 0 0 0 rgba(34,197,94,.6)}80%{box-shadow:0 0 0 12px rgba(34,197,94,0)}100%{box-shadow:0 0 0 0 rgba(34,197,94,0)}}
  .brand h1{font-size:1rem;margin:0}.meta{display:flex;align-items:center;gap:1rem;color:var(--muted);font-size:.9rem}.meta b{color:var(--text)}
  .controls button{background:transparent;border:1px solid rgba(255,255,255,.2);color:var(--text);padding:.35rem .6rem;border-radius:.5rem;cursor:pointer}
  .controls button:hover{border-color:#fff}
  .stage{position:relative;flex:1}
  iframe{position:absolute;inset:0;width:100%;height:100%;border:0;background:#fff;opacity:0;transition:opacity .35s ease}
  iframe.show{opacity:1}
  .tabs{position:absolute;left:50%;bottom:12px;transform:translateX(-50%);display:flex;gap:.35rem;background:rgba(15,23,42,.6);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.1);padding:.25rem .35rem;border-radius:999px}
  .tag{color:var(--muted);font-weight:600;font-size:.8rem;padding:.15rem .6rem;border-radius:999px}.tag.active{background:#1f2937;color:#fff}
</style>
</head>
<body>
<div class="wrap">
  <div class="topbar">
    <div class="brand"><span class="dot"></span><h1>Live Wallboard</h1></div>
    <div class="meta">
      <span id="tabTitle">—</span><span>•</span><span id="clock">--:--:--</span><span>•</span>
      <span>Rotasi <b id="durText">{$sec}</b> dtk</span>
    </div>
    <div class="controls">
      <button id="btnPrev" title="Sebelumnya">« Prev</button>
      <button id="btnNext" title="Berikutnya">Next »</button>
      <button id="btnPause" title="Jeda / Lanjut">⏸︎</button>
      <button id="btnFS" title="Fullscreen">⛶</button>
    </div>
  </div>

  <div class="stage">
    <iframe id="frameA" referrerpolicy="same-origin"></iframe>
    <iframe id="frameB" referrerpolicy="same-origin"></iframe>

    <div class="tabs" id="tabsWrap"></div>
  </div>
</div>

<script>
(function(){
  var TABS = {$tabsJson};
  var DURATION = {$sec} * 1000;
  var AUTOFS = {$autoJson};

  var idx = 0, timer = null, paused = false, activeA = true;
  var frameA = document.getElementById('frameA');
  var frameB = document.getElementById('frameB');
  var clock  = document.getElementById('clock');
  var tabTitle = document.getElementById('tabTitle');
  var tabsWrap = document.getElementById('tabsWrap');
  document.getElementById('durText').textContent = (DURATION/1000)|0;

  // render tag tabs
  for (var i=0;i<TABS.length;i++){
    var sp = document.createElement('span');
    sp.className = 'tag' + (i===0?' active':'');
    sp.textContent = (TABS[i].title || ('Tab '+(i+1)));
    (function(n){ sp.addEventListener('click', function(){ swapTo(n); if(!paused) start(); }); })(i);
    tabsWrap.appendChild(sp);
  }

  function setActiveTag(n){
    var tags = tabsWrap.children;
    for (var i=0;i<tags.length;i++){ tags[i].classList.toggle('active', i===n); }
  }

  // jam live
  setInterval(function(){
    var d=new Date(), p=function(n){return (n<10?'0':'')+n};
    clock.textContent = p(d.getHours())+':'+p(d.getMinutes())+':'+p(d.getSeconds());
  }, 1000);

  function bust(url){
    var sep = url.indexOf('?')>-1 ? '&' : '?';
    return url + sep + '_ts=' + Date.now();
  }

  function swapTo(n){
    if (!TABS.length) return;
    idx = (n + TABS.length) % TABS.length;
    var url = bust(TABS[idx].url);
    var title = TABS[idx].title || ('Tab '+(idx+1));
    tabTitle.textContent = title;
    setActiveTag(idx);

    var nextFrame = activeA ? frameB : frameA;
    var curFrame  = activeA ? frameA : frameB;

    nextFrame.classList.remove('show');
    nextFrame.onload = null; // bersih
    nextFrame.src = url;

    nextFrame.onload = function(){
      nextFrame.classList.add('show');
      curFrame.classList.remove('show');
      activeA = !activeA;
    };
    // fallback jika onload tidak terpanggil (3 dtk)
    setTimeout(function(){
      if (!nextFrame.classList.contains('show')){
        nextFrame.classList.add('show');
        curFrame.classList.remove('show');
        activeA = !activeA;
      }
    }, 3000);
  }

  function start(){ stop(); timer = setInterval(function(){ swapTo(idx+1); }, DURATION); }
  function stop(){ if (timer){ clearInterval(timer); timer=null; } }

  // tombol
  document.getElementById('btnNext').addEventListener('click', function(){ swapTo(idx+1); if(!paused) start(); });
  document.getElementById('btnPrev').addEventListener('click', function(){ swapTo(idx-1); if(!paused) start(); });
  document.getElementById('btnPause').addEventListener('click', function(){
    paused = !paused; this.textContent = paused ? '▶︎' : '⏸︎'; if (paused) stop(); else start();
  });

  // Fullscreen toggle
  document.getElementById('btnFS').addEventListener('click', function(){
    if (!document.fullscreenElement){
      (document.documentElement.requestFullscreen
        ? document.documentElement.requestFullscreen({navigationUI:'hide'})
        : document.body.requestFullscreen()).catch(function(){});
    } else {
      document.exitFullscreen().catch(function(){});
    }
  });

  // Hotkeys: n/p (next/prev), spasi (pause), f (fullscreen)
  document.addEventListener('keydown', function(e){
    var k=(e.key||'').toLowerCase();
    if (k==='n'){ e.preventDefault(); document.getElementById('btnNext').click(); }
    else if (k==='p'){ e.preventDefault(); document.getElementById('btnPrev').click(); }
    else if (k===' '){ e.preventDefault(); document.getElementById('btnPause').click(); }
    else if (k==='f'){ e.preventDefault(); document.getElementById('btnFS').click(); }
  });

  // Auto fullscreen jika diminta
  if (AUTOFS){ setTimeout(function(){ try{ document.getElementById('btnFS').click(); }catch(e){} }, 600); }

  // mulai
  swapTo(0); start();
})();
</script>
</body>
</html>
HTML;

        $this->output
             ->set_content_type('text/html; charset=UTF-8')
             ->set_output($html);
    }



       

public function live_combined()
{
    // durasi rotasi & auto fullscreen dari querystring
    $sec  = (int) $this->input->get('sec', true);
    if ($sec < 5) { $sec = 45; }
    $auto = ((int) $this->input->get('auto', true) === 1);

    // tab yang diputar
    $tabs = [
        ['title' => 'Dashboard', 'url' => site_url('admin_dashboard/dashboard?live=1')],
        ['title' => 'Monitor',   'url' => site_url('admin_dashboard/monitor?live=1')],
    ];

    // siapkan data untuk view
    $data["controller"] = get_class($this);
    $data["title"]      = "Live Wallboard";
    $data["subtitle"]   = "Rotating Dashboard & Monitor";
    $data["sec"]        = $sec;
    $data["auto"]       = $auto;
    $data["tabs"]       = $tabs;

    // jika Anda punya layout global, gunakan $this->render seperti biasa:
    $data["content"] = $this->load->view('Admin_dashboard_jsx', $data, true);
    $this->render($data);

    // Jika TIDAK pakai layout global, cukup:
    // $this->load->view('Admin_dashboard_jsx', $data);
}



}
