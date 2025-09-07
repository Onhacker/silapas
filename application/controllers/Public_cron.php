<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_cron extends Onhacker_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->output->set_content_type('text/plain'); // biar respons jelas
    }

    /** Izinkan CLI tanpa key; HTTP wajib pakai key */
    private function _require_key(): void
    {
        if ($this->input->is_cli_request()) return;
        $key    = (string)$this->input->get('key', true);
        $expect = (string)$this->config->item('cron_secret');
        if (!$expect || !hash_equals($expect, $key)) {
            show_404();
            exit;
        }
    }

    /** Hitung cutoff WITA dari menit grace */
    private function _cutoff(int $grace, string $tz = 'Asia/Makassar'): string
    {
        if ($grace < 0 || $grace > 1440) $grace = 30;
        $dt = new DateTime('now', new DateTimeZone($tz));
        if ($grace > 0) $dt->modify("-{$grace} minutes");
        return $dt->format('Y-m-d H:i:s');
    }

    /** Ping cepat */
    public function ping(): void
    {
        $this->_require_key();
        $msg = "[PING] ".date('c')."\n";
        echo $msg;
        @file_put_contents('/tmp/cron_ping.log', $msg, FILE_APPEND);
        exit(0);
    }

    /** Dry-run: hitung yang akan di-expire */
    public function korban($grace_minutes = 30): void
    {
        $this->_require_key();
        $cutoff = $this->_cutoff((int)$grace_minutes);

        $q = $this->db->query("
            SELECT COUNT(*) AS n
              FROM booking_tamu
             WHERE checkin_at IS NULL
               AND status IN ('pending','approved')
               AND jadwal_at < ?
        ", [$cutoff])->row();

        $will = (int)($q->n ?? 0);
        echo "[CHECK] will_expire={$will}, cutoff={$cutoff}\n";
        exit(0);
    }

    /** Eksekusi expire */
    public function expire_bookings($grace_minutes = 30): void
    {
        $this->_require_key();

        $grace  = (int)$grace_minutes;
        $cutoff = $this->_cutoff($grace);

        // Hitung calon (untuk log)
        $will = (int)$this->db->query("
            SELECT COUNT(*) AS n
              FROM booking_tamu
             WHERE checkin_at IS NULL
               AND status IN ('pending','approved')
               AND jadwal_at < ?
        ", [$cutoff])->row()->n;

        // Update: set expired + cap waktu sekarang
        $this->db->query("
            UPDATE booking_tamu
               SET status = 'expired',
                   expired_at = NOW()
             WHERE checkin_at IS NULL
               AND status IN ('pending','approved')
               AND jadwal_at < ?
        ", [$cutoff]);

        $err = $this->db->error();
        $affected = $this->db->affected_rows();

        if (!empty($err['code'])) {
            $msg = "[SQLERR] code={$err['code']} msg={$err['message']} cutoff={$cutoff}\n";
            echo $msg;
            log_message('error', "[CRON] ".$msg);
            @file_put_contents('/tmp/cron_expire.log', $msg, FILE_APPEND);
            exit(1);
        }

        $msg = "[EXPIRE] will={$will} affected={$affected} grace={$grace}m cutoff={$cutoff}\n";
        echo $msg;
        log_message('error', "[CRON] ".trim($msg));
        @file_put_contents('/tmp/cron_expire.log', $msg, FILE_APPEND);
        exit(0);
    }
}
