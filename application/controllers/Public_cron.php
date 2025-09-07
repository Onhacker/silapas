<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_cron extends Onhacker_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        // Controller ini sengaja tanpa cek session/login
        // Pastikan dilindungi dengan secret key (lihat fungsi _require_key di bawah)
    }

    /** JANGAN panggil tanpa key */
    private function _require_key()
    {
        // izinkan CLI tanpa key
        if ($this->input->is_cli_request()) return;

        $key = $this->input->get('key', true);
        $expect = $this->config->item('cron_key');
        if (!$expect || !hash_equals($expect, (string)$key)) {
            show_404(); // atau: show_error('Forbidden', 403);
            exit;
        }
    }

    /** Ping untuk uji cepat */
    public function ping()
    {
        $this->_require_key();
        $msg = "[PING] ".date('c')."\n";
        echo $msg;
        @file_put_contents('/tmp/cron_ping.log', $msg, FILE_APPEND);
        exit(0);
    }

    /** Expire booking (HTTP + token / CLI) */
    public function expire_bookings($grace_minutes = 30)
    {
        $this->_require_key();

        $grace = (int)$grace_minutes;
        if ($grace < 0 || $grace > 1440) $grace = 30;

        // Jika Anda punya model $this->ma->expire_past_bookings(), pakai ini:
        // $this->load->model('M_admin','ma');
        // $affected = (int)$this->ma->expire_past_bookings($grace, 'Asia/Makassar');

        // Fallback raw SQL (aman & cepat)
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

        $msg = "[EXPIRE] affected={$affected} grace={$grace}m cutoff={$cutoff} at=".date('c')."\n";
        echo $msg;
        @file_put_contents('/tmp/cron_expire.log', $msg, FILE_APPEND);
        log_message('error', "[CRON] ".trim($msg));
        exit(0);
    }
}
