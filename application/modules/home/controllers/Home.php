<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->timezone(); // set zona waktu dari DB (fallback Asia/Makassar)
        $this->load->helper(['front', 'download']);
        $this->load->model('front_model', 'fm');
    }

    /**
     * Halaman utama
     */
    public function index()
    {
        $data['rec']       = $this->fm->web_me();
        $data['title']     = 'Home';
        $data['deskripsi'] = $data["rec"]->nama_website." ".$data["rec"]->kabupaten." ".$data["rec"]->meta_deskripsi." adalah aplikasi untuk pemesanan (booking) kunjungan tamu, check-in/out di Lapas Kelas I Makassar";
        $data['prev']      = base_url('assets/images/icon_app.png');
        $this->load->view('home_view', $data);
    }

    /**
     * Data statistik kunjungan untuk grafik (JSON)
     */
    public function chart_data()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
            ->set_header('Pragma: no-cache');

        $db    = $this->db;
        $now   = time();

        // Rentang pekanan (Senin–Minggu)
        $startWeek = date('Y-m-d 00:00:00', strtotime('monday this week', $now));
        $endWeek   = date('Y-m-d 23:59:59', strtotime('sunday this week', $now));
        $startLast = date('Y-m-d 00:00:00', strtotime('monday last week', $now));
        $endLast   = date('Y-m-d 23:59:59', strtotime('sunday last week', $now));

        // Harian & bulanan
        $todayStart = date('Y-m-d 00:00:00', $now);
        $todayEnd   = date('Y-m-d 23:59:59', $now);
        $monthStart = date('Y-m-01 00:00:00', $now);
        $monthEnd   = date('Y-m-t 23:59:59', $now);

        // Minggu ini
        $rows = $db->query(
            "SELECT WEEKDAY(checkin_at) AS d, COUNT(*) AS c
               FROM booking_tamu
              WHERE checkin_at IS NOT NULL
                AND checkin_at BETWEEN ? AND ?
              GROUP BY WEEKDAY(checkin_at)",
            [$startWeek, $endWeek]
        )->result_array();

        $weekly = array_fill(0, 7, 0);
        foreach ($rows as $r) {
            $idx = (int) $r['d'];
            if ($idx >= 0 && $idx <= 6) {
                $weekly[$idx] = (int) $r['c'];
            }
        }

        // Minggu lalu
        $rows2 = $db->query(
            "SELECT WEEKDAY(checkin_at) AS d, COUNT(*) AS c
               FROM booking_tamu
              WHERE checkin_at IS NOT NULL
                AND checkin_at BETWEEN ? AND ?
              GROUP BY WEEKDAY(checkin_at)",
            [$startLast, $endLast]
        )->result_array();

        $last_weekly = array_fill(0, 7, 0);
        foreach ($rows2 as $r) {
            $idx = (int) $r['d'];
            if ($idx >= 0 && $idx <= 6) {
                $last_weekly[$idx] = (int) $r['c'];
            }
        }

        // KPI
        $today = (int) $db->query(
            "SELECT COUNT(*) AS c FROM booking_tamu WHERE checkin_at BETWEEN ? AND ?",
            [$todayStart, $todayEnd]
        )->row()->c;

        $week = (int) $db->query(
            "SELECT COUNT(*) AS c FROM booking_tamu WHERE checkin_at BETWEEN ? AND ?",
            [$startWeek, $endWeek]
        )->row()->c;

        $month = (int) $db->query(
            "SELECT COUNT(*) AS c FROM booking_tamu WHERE checkin_at BETWEEN ? AND ?",
            [$monthStart, $monthEnd]
        )->row()->c;

        $this->output->set_output(json_encode([
            'ok'          => true,
            'today'       => $today,
            'week'        => $week,
            'month'       => $month,
            // urutan = Sen, Sel, Rab, Kam, Jum, Sab, Min
            'weekly'      => $weekly,
            'last_weekly' => $last_weekly,
            'labels'      => ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
            'server_time' => date('c'),
            'range'       => ['start' => $startWeek, 'end' => $endWeek],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Set timezone dari tabel identitas; fallback ke Asia/Makassar
     */
    private function timezone()
    {
        $tz = 'Asia/Makassar';
        $row = $this->db->where('id_identitas', '1')->get('identitas')->row();
        if ($row && !empty($row->waktu)) {
            $tz = $row->waktu;
        }
        date_default_timezone_set($tz);
    }

    /**
     * Reload ke dashboard admin
     */
    public function reload()
    {
        redirect(site_url('admin_dashboard'));
    }
}
