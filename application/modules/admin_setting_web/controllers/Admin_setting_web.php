<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_setting_web extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
	}

	function index(){
		
		$data["controller"] = get_class($this);
		$data["record"] = $this->om->edit('identitas', array('id_identitas' => 1))->row();
		$data["title"] = "Pengaturan Web";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

public function update()
{
    $post = $this->input->post(NULL, TRUE);
    $this->load->library('form_validation');

    // ===== RULES DASAR =====
    $this->form_validation->set_rules('nama_website','Nama Website','trim|required');
    $this->form_validation->set_rules('email','Email','trim|required|valid_email');
    $this->form_validation->set_rules('url','URL Aplikasi','trim|required|valid_url');
    $this->form_validation->set_rules('no_telp','No. HP/WhatsApp','trim|required|regex_match[/^\+?\d{10,15}$/]');
    $this->form_validation->set_rules('waktu','Zona Waktu','trim|required|in_list[Asia/Jakarta,Asia/Makassar,Asia/Jayapura]');
    $this->form_validation->set_rules('min_lead_minutes','Minimal Jeda Booking (menit)','trim|integer|greater_than_equal_to[0]|less_than_equal_to[1440]');
    $this->form_validation->set_rules('early_min','Batas Datang Lebih Awal','trim|integer|greater_than_equal_to[0]|less_than_equal_to[1440]');
    $this->form_validation->set_rules('late_min','Batas Keterlambatan','trim|integer|greater_than_equal_to[0]|less_than_equal_to[1440]');

    // ===== RULES SMTP =====
    $this->form_validation->set_rules('smtp_port','SMTP Port','trim|integer|greater_than_equal_to[1]|less_than_equal_to[65535]');
    $this->form_validation->set_rules('smtp_crypto','Enkripsi','trim|in_list[ssl,tls,]'); // '' artinya none
    $this->form_validation->set_rules('smtp_from','From Email','trim|valid_email');
    $this->form_validation->set_rules('smtp_from_name','From Name','trim');
    $this->form_validation->set_rules('smtp_host','SMTP Host','trim');
    $this->form_validation->set_rules('smtp_user','SMTP Username','trim');
    // smtp_pass: boleh kosong (tidak mengganti)


    $this->form_validation->set_message('required', '* %s Harus diisi');
    $this->form_validation->set_message('valid_email', '* %s Tidak valid');
    $this->form_validation->set_message('valid_url', '* %s Tidak valid (awali dengan http:// atau https://)');
    $this->form_validation->set_message('regex_match', '* %s tidak valid (boleh + di depan, 10–15 digit)');
    $this->form_validation->set_message('in_list', '* %s tidak valid');
    $this->form_validation->set_message('integer', '* %s harus angka bulat');
    $this->form_validation->set_message('greater_than_equal_to', '* %s minimal %s');
    $this->form_validation->set_message('less_than_equal_to', '* %s maksimal %s');
    $this->form_validation->set_error_delimiters('<br> ',' ');

    if ($this->form_validation->run() === FALSE) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
        return;
    }

    // ===== NORMALISASI NILAI UMUM =====
    $url = trim($post['url'] ?? '');
    if ($url !== '' && !preg_match('~^https?://~i',$url)) {
        $url = 'http://'.$url;
    }
    if ($url !== '' && substr($url, -1) !== '/') {
        $url .= '/';
    }

    $no_telp = preg_replace('/\s+/', '', (string)($post['no_telp'] ?? ''));

    // Clamp angka menit
    $clamp = function($v, $min=0, $max=1440){
        if ($v === null || $v === '') return null;
        $n = (int)$v;
        if ($n < $min) $n = $min;
        if ($n > $max) $n = $max;
        return $n;
    };
    $minLead = $clamp($post['min_lead_minutes'] ?? null);
    $earlyMin= $clamp($post['early_min'] ?? null);
    $lateMin = $clamp($post['late_min'] ?? null);

    // ===== SIAPKAN DATA UPDATE (tanpa token/secret dulu) =====
    $row = [
        'nama_website'     => $post['nama_website'] ?? '',
        'email'            => $post['email'] ?? '',
        'url'              => $url,
        'provinsi'         => $post['provinsi'] ?? '',
        'kabupaten'        => $post['kabupaten'] ?? '',
        'alamat'           => $post['alamat'] ?? '',
        'no_telp'          => $no_telp,
        'telp'             => $post['telp'] ?? '',
        'meta_deskripsi'   => $post['meta_deskripsi'] ?? '',
        'meta_keyword'     => $post['meta_keyword'] ?? '',
        'maps'             => $post['maps'] ?? '',
        'waktu'            => $post['waktu'] ?? 'Asia/Makassar',
        'type'             => $post['type'] ?? '',
        'credits'          => $post['credits'] ?? '',
        'batas_edit'          => $post['batas_edit'] ?? '',
        'batas_hari'          => $post['batas_hari'] ?? '',
        'min_lead_minutes' => $minLead,
        'early_min'        => $earlyMin,
        'late_min'         => $lateMin,
        'instagram'        => $post['instagram'] ?? '',
        'facebook'         => $post['facebook'] ?? '',
    ];
    $row['smtp_active']    = isset($post['smtp_active']) ? 1 : 0;
    $row['smtp_host']      = $post['smtp_host'] ?? null;
    $row['smtp_port']      = isset($post['smtp_port']) && $post['smtp_port']!=='' ? (int)$post['smtp_port'] : null;
    $row['smtp_user']      = $post['smtp_user'] ?? null;
// password hanya diset kalau DIISI
    if (isset($post['smtp_pass']) && trim($post['smtp_pass']) !== '') {
        $row['smtp_pass'] = $post['smtp_pass'];
    }
    $crypto = isset($post['smtp_crypto']) ? strtolower(trim($post['smtp_crypto'])) : '';
    $row['smtp_crypto']    = in_array($crypto, ['ssl','tls'], true) ? $crypto : null;
    $row['smtp_from']      = $post['smtp_from'] ?? null;
    $row['smtp_from_name'] = $post['smtp_from_name'] ?? null;


    // ===== Token/Secret WA → hanya set kalau DIISI (tidak kosong) =====
    if (isset($post['wa_api_token']) && trim($post['wa_api_token']) !== '') {
        $row['wa_api_token'] = $post['wa_api_token'];
    }
    if (isset($post['wa_api_secret']) && trim($post['wa_api_secret']) !== '') {
        $row['wa_api_secret'] = $post['wa_api_secret'];
    }

    // ===== UPLOAD FAVICON (opsional) =====
    if (!empty($_FILES['favicon']['name'])) {
        $config = [
            'upload_path'   => FCPATH.'assets/images/',
            'allowed_types' => 'gif|jpg|jpeg|png|ico|GIF|JPG|JPEG|PNG|ICO',
            'max_size'      => 1024,
            'overwrite'     => TRUE,
            'file_name'     => 'favicon',
        ];
        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('favicon')) {
            $rules = "Tipe file: ".str_replace("|", ", ", $config['allowed_types'])
                   ."<br>Maksimal ukuran: ".$config['max_size']." KB";
            echo json_encode([
                "success"=>false,
                "title"=>"Upload Gagal",
                "pesan"=>$this->upload->display_errors('<br> ',' ').$rules
            ]);
            return;
        }
        $fdata = $this->upload->data();
        $row['favicon'] = $fdata['file_name']; // ex: favicon.png
    }

    // ===== JAM OPERASIONAL PER HARI + ISTIRAHAT =====
    // Helper normalisasi HH:MM (boleh "8:5" → "08:05", "08.30" → "08:30")
    $normTime = function($v){
        $v = trim((string)$v);
        if ($v === '') return null;
        $v = str_replace('.', ':', $v);
        if (!preg_match('/^(\d{1,2}):([0-5]\d)$/', $v, $m)) return false;
        $h = (int)$m[1]; $i = (int)$m[2];
        if ($h < 0 || $h > 23) return false;
        return sprintf('%02d:%02d', $h, $i);
    };
    $toMin = function($hhmm){
        if ($hhmm === null) return null;
        [$h,$m] = array_map('intval', explode(':', $hhmm));
        return $h*60 + $m;
    };

    $days = [
        'mon' => 'Senin',  'tue' => 'Selasa', 'wed' => 'Rabu',
        'thu' => 'Kamis',  'fri' => 'Jumat',  'sat' => 'Sabtu',
        'sun' => 'Minggu',
    ];

    $errors = [];

    foreach ($days as $k => $label) {
        $closed = isset($post["op_{$k}_closed"]) ? 1 : 0;

        $open  = $normTime($post["op_{$k}_open"]        ?? '');
        $bSta  = $normTime($post["op_{$k}_break_start"] ?? '');
        $bEnd  = $normTime($post["op_{$k}_break_end"]   ?? '');
        $close = $normTime($post["op_{$k}_close"]       ?? '');

        if ($closed) {
            // Hari libur → kosongkan jam
            $row["op_{$k}_open"]         = null;
            $row["op_{$k}_break_start"]  = null;
            $row["op_{$k}_break_end"]    = null;
            $row["op_{$k}_close"]        = null;
            $row["op_{$k}_closed"]       = 1;
            continue;
        }

        // Validasi dasar format
        if ($open === false || $close === false) {
            $errors[] = "* {$label}: format jam buka/tutup tidak valid (HH:MM).";
            continue;
        }
        if ($open === null || $close === null) {
            $errors[] = "* {$label}: jam buka & tutup wajib diisi.";
            continue;
        }

        $o = $toMin($open);
        $c = $toMin($close);
        if (!is_null($o) && !is_null($c) && $o >= $c) {
            $errors[] = "* {$label}: jam tutup harus lebih besar dari jam buka.";
        }

        // Istirahat opsional: kalau salah satu diisi, keduanya wajib & harus di dalam rentang
        $hasBreak = ($bSta !== null || $bEnd !== null);
        if ($hasBreak) {
            if ($bSta === false || $bEnd === false) {
                $errors[] = "* {$label}: format jam istirahat tidak valid (HH:MM).";
            } elseif ($bSta === null || $bEnd === null) {
                $errors[] = "* {$label}: lengkapi jam istirahat (mulai & selesai).";
            } else {
                $bs = $toMin($bSta);
                $be = $toMin($bEnd);
                if (!($o <= $bs && $bs < $be && $be <= $c)) {
                    $errors[] = "* {$label}: jam istirahat harus berada di dalam rentang buka–tutup.";
                }
            }
        }

        // Simpan nilai normal
        $row["op_{$k}_open"]         = $open;
        $row["op_{$k}_break_start"]  = $bSta;
        $row["op_{$k}_break_end"]    = $bEnd;
        $row["op_{$k}_close"]        = $close;
        $row["op_{$k}_closed"]       = 0;
    }

    if (!empty($errors)) {
        echo json_encode([
            "success"=>false,
            "title"=>"Validasi Jam Operasional",
            "pesan"=>'<br> '.implode('<br> ', $errors)
        ]);
        return;
    }

    // ===== SIMPAN =====
    $this->db->where('id_identitas', 1);
    $ok = $this->db->update('identitas', $row);

    echo json_encode($ok
        ? ["success"=>true, "title"=>"Berhasil", "pesan"=>"Data berhasil diupdate"]
        : ["success"=>false,"title"=>"Gagal", "pesan"=>"Data gagal diupdate"]
    );
}


	public function smtp_test()
{
    if (strtoupper($this->input->method(TRUE)) !== 'POST') {
        echo json_encode(["success"=>false,"pesan"=>"Method not allowed"]); return;
    }
    $to = trim((string)$this->input->post('to', true));
    if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success"=>false,"pesan"=>"Email tujuan tidak valid"]); return;
    }

    // ambil config dari DB
    $rec = $this->db->get_where('identitas', ['id_identitas'=>1])->row();
    if (!$rec || empty($rec->smtp_active)) {
        echo json_encode(["success"=>false,"pesan"=>"SMTP belum diaktifkan"]); return;
    }

    $app_name  = $rec->nama_website ?? 'Aplikasi';
    $smtp_host = $rec->smtp_host ?: '';
    $smtp_user = $rec->smtp_user ?: '';
    $smtp_pass = $rec->smtp_pass ?: '';
    $smtp_port = (int)($rec->smtp_port ?: 0);
    $smtp_crypto = $rec->smtp_crypto ?: ''; // '', 'ssl', 'tls'
    $from_email  = $rec->smtp_from ?: $smtp_user;
    $from_name   = $rec->smtp_from_name ?: $app_name;

    if ($smtp_host==='' || $smtp_user==='' || $smtp_pass==='' || $smtp_port<=0) {
        echo json_encode(["success"=>false,"pesan"=>"Konfigurasi SMTP belum lengkap"]); return;
    }

    $this->load->library('email');
    $cfg = [
        'protocol'    => 'smtp',
        'smtp_host'   => $smtp_host,
        'smtp_user'   => $smtp_user,
        'smtp_pass'   => $smtp_pass,
        'smtp_port'   => $smtp_port,
        'smtp_crypto' => ($smtp_crypto?:null), // CI otomatis abaikan jika null
        'mailtype'    => 'html',
        'charset'     => 'utf-8',
        'newline'     => "\r\n",
        'crlf'        => "\r\n",
        'wordwrap'    => true,
        'validate'    => true,
    ];
    $this->email->initialize($cfg);
    $this->email->clear(true);
    $this->email->from($from_email, $from_name);
    $this->email->to($to);
    $this->email->subject('Tes SMTP - '.$app_name);
    $this->email->message('<p>Halo,</p><p>Ini email uji dari pengaturan SMTP aplikasi <b>'.$app_name.'</b>.</p>');

    try {
        $ok = $this->email->send();
        if (!$ok) {
            $dbg = $this->email->print_debugger(['headers']);
            log_message('error', 'SMTP TEST failed: '.$dbg);
            echo json_encode(["success"=>false,"pesan"=>"Gagal mengirim (lihat log)."]); return;
        }
        echo json_encode(["success"=>true,"pesan"=>"Terkirim ke ".$to]); return;
    } catch (Throwable $e) {
        log_message('error', 'SMTP TEST exception: '.$e->getMessage());
        echo json_encode(["success"=>false,"pesan"=>"Exception: ".$e->getMessage()]); return;
    }
}

	
}