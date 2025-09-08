<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller {
	function __construct(){
        parent::__construct();

        // Mencegah halaman ini diindeks oleh mesin pencari
        $this->output->set_header("X-Robots-Tag: noindex, nofollow", true);
    }


    public function get_menu_desktop()
{
    $this->load->library('user_agent');
    $this->load->helper('menu');

    $is_logged = (bool)$this->session->userdata("admin_login");
    $level     = (string)$this->session->userdata('admin_level');
    $username  = (string)$this->session->userdata('admin_username');

    // ====== Definisi menu (tetap) ======
    $MENU_DEF = [
        [ 'label'=>'Statistik',  'url'=>site_url('admin_dashboard'),         'icon'=>'fe-activity',
          // boleh pakai beberapa alias require:
        'require'=>['Statistik','dashboard','admin_dashboard'] ],

        [ 'label'=>'Monitoring', 'url'=>site_url('admin_dashboard/monitor'), 'icon'=>'fe-eye',
        'require'=>['Monitoring','admin_dashboard/monitor','admin_monitor'] ],

        [ 'label'=>'Scan',       'url'=>site_url('admin_scan'),              'icon'=>'mdi mdi-qrcode-scan',
        'require'=>['Scan QR','scan','admin_scan'] ],

        [ 'label'=>'Data',       'url'=>site_url('admin_permohonan'),        'icon'=>'fe-eye',
        'require'=>['Admin Permohonan','admin_permohonan'] ],
    ];

    // Opsi group admin (hanya muncul jika user punya akses child-nya)
    $MENU_DEF[] = [
        'label'=>'Master', 'icon'=>'fe-git-commit',
        'children'=>[
            [ 'label'=>'Manajemen User','url'=>site_url('admin_user'),
              'require'=>['Manajemen User','admin_user','user'] ],
        ]
    ];

    // ====== Header dasar ======
    $this->output->set_content_type('application/json');

    // ====== Belum login → no cache & empty ======
    if (!$is_logged) {
        $this->output
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, private')
            ->set_header('Pragma: no-cache')
            ->set_header('Expires: 0')
            ->set_header('Vary: Cookie');

        echo json_encode(["success" => false, "menu" => ""]);
        return;
    }

    // ====== Build menu (otomatis terfilter oleh akses di build_menu) ======
    $html = build_menu($MENU_DEF, [
        'li_has_child_class' => 'has-submenu',
        'li_active_class'    => 'active-menu',
        'child_ul_class'     => 'submenu',
    ]);

    // ====== ETag sensitif user & akses ======
    // Hash-kan juga "allowed set" agar ETag berubah saat hak akses berubah
    $allowed = allowed_module_slugs();
    $allowed_sig = is_array($allowed) ? md5(json_encode(array_keys($allowed))) : (string)$allowed;

    $signature = $username.'|'.$level.'|'.md5(json_encode($MENU_DEF)).'|'.$allowed_sig.'|'.md5($html);
    $etag = 'W/"menu-'.substr(sha1($signature), 0, 20).'"';

    // 304 handling
    $ifNoneMatch = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : '';
    if ($ifNoneMatch === $etag) {
        $this->output
            ->set_status_header(304)
            ->set_header('ETag: '.$etag)
            ->set_header('Cache-Control: private, max-age=900, stale-while-revalidate=600')
            ->set_header('Vary: Cookie');
        return;
    }

    // Header cache untuk respons 200
    $this->output
        ->set_header('ETag: '.$etag)
        ->set_header('Cache-Control: private, max-age=900, stale-while-revalidate=600') // 15 menit, SWR 10 menit
        ->set_header('Vary: Cookie')
        ->set_header('X-Menu-Version: '.$etag);

    echo json_encode([
        "success" => true,
        "menu"    => $html
    ]);
}
public function get_menu_mobile()
{
    $this->load->helper('menu'); // butuh user_can_mod(), allowed_module_slugs()
    $is_logged = (bool)$this->session->userdata("admin_login");
    $level     = (string)$this->session->userdata('admin_level');
    $username  = (string)$this->session->userdata('admin_username');

    $this->output->set_content_type('application/json');

    if (!$is_logged) {
        $this->output
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, private')
            ->set_header('Pragma: no-cache')
            ->set_header('Expires: 0')
            ->set_header('Vary: Cookie');
        echo json_encode(["success"=>false, "actions"=>[]]);
        return;
    }

    // Definisi quick actions (mobile)
    $ACTIONS_DEF = [
      [
        'id'      => 'admin_user',
        'label'   => 'Manajemen User',
        'url'     => site_url('admin_user'),
        'icon'    => 'fas fa-users-cog',
        'require' => ['admin_user'] // cukup link modul
        ],
        [
            'id'      => 'admin_permohonan',
            'label'   => 'Data',
            'url'     => site_url('admin_permohonan'),
            'icon'    => 'fe-file-text',
            'require' => ['admin_permohonan'] // cukup link modul
        ],
        [
            'id'      => 'admin_scan',
            'label'   => 'Checkin/Checkout',
            'url'     => site_url('admin_scan'),
            'icon'    => 'mdi mdi-qrcode-scan',
            'require' => ['admin_scan'] // cukup link modul
        ],
        [
            'id'      => 'admin_dashboard/monitor',
            'label'   => 'Monitoring',
            'url'     => site_url('admin_dashboard/monitor'),
            'icon'    => 'mdi mdi-qrcode-scan',
            'require' => ['admin_dashboard/monitor'] // cukup link modul
        ],
        [
            'id'      => 'admin_dashboard',
            'label'   => 'Statistik',
            'url'     => site_url('admin_dashboard'),
            'icon'    => 'mdi mdi-qrcode-scan',
            'require' => ['admin_dashboard'] // cukup link modul
        ],
    ];


    // Filter berdasarkan hak akses
    $allowed_actions = [];
    foreach ($ACTIONS_DEF as $a) {
        if (!isset($a['require']) || user_can_mod($a['require'])) {
            $allowed_actions[] = [
                'id'    => $a['id'],
                'label' => $a['label'],
                'url'   => $a['url'],
                'icon'  => $a['icon']
            ];
        }
    }

    // ETag sensitif user & izin
    $allowed = allowed_module_slugs();
    $allowed_sig = is_array($allowed) ? md5(json_encode(array_keys($allowed))) : (string)$allowed;
    $payload_sig = md5(json_encode($allowed_actions));
    $signature   = $username.'|'.$level.'|'.$allowed_sig.'|'.$payload_sig;
    $etag = 'W/"mobile-'.substr(sha1($signature), 0, 20).'"';

    $ifNoneMatch = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : '';
    if ($ifNoneMatch === $etag) {
        $this->output
            ->set_status_header(304)
            ->set_header('ETag: '.$etag)
            ->set_header('Cache-Control: private, max-age=900, stale-while-revalidate=600')
            ->set_header('Vary: Cookie');
        return;
    }

    $this->output
        ->set_header('ETag: '.$etag)
        ->set_header('Cache-Control: private, max-age=900, stale-while-revalidate=600')
        ->set_header('Vary: Cookie');

    echo json_encode([
        "success" => true,
        "actions" => $allowed_actions
    ]);
}



	public function check_login()
    {
        $is_admin = false;
        if ($this->session->userdata('admin_login') === true) {
            $is_admin = true;
        }

        session_write_close(); // tutup session agar tidak blocking

        // sleep(5);

        $response = ['is_admin' => $is_admin];
        echo json_encode($response);
    }

    public function get_link_permohonan()
    {
        $is_admin = false;
        if ($this->session->userdata('admin_login') === true) {
            $is_admin = true;
        }

        session_write_close(); 
        $this->load->helper('url');
        $rec = (object)[
        'gambar' => 'permohonan.png' // bisa juga ambil dari DB atau parameter
    ];

    $uri = $this->uri->segment(1);

    ob_start();
    // if ($this->session->userdata("admin_login") == true) { 
        ?>
        
     <?php ?>
        <a href="<?= base_url('booking') ?>"
         class="center-button <?= ($uri == 'booking') ? 'text-white' : '' ?>"
         style="text-align: center; <?= ($uri == 'booking') ? 'background-color: #28a745;' : '' ?>">
         <img src="<?= base_url('assets/images/logo.png') ?>" alt="Permohonan"
         style="width: 45px; height: 45px; object-fit: contain; margin-top: 0px;">
     </a>
 <!-- } -->

    <?php

    $html = ob_get_clean();
    echo $html;
    }

    public function ajax_status_user()
{
    // Ambil session (lakukan sebelum session_write_close)
    $is_login  = ($this->session->userdata('admin_login') === true);
    $username  = (string)$this->session->userdata('admin_username');
    $nama_ses  = (string)$this->session->userdata('admin_nama');   // dari $data_session baru
    $foto_ses  = (string)$this->session->userdata('admin_foto');   // dari $data_session baru

    // Hindari deadlock saat render view
    session_write_close();

    if (!$is_login) {
        // Item login (LI saja, tanpa <ul>)
        $login_html = '
        <li class="dropdown notification-list">
          <a class="nav-link nav-user mr-0 waves-effect"
             href="'.site_url("on_login").'">
            <span class="d-flex align-items-center">
              <i class="fas fa-user-circle mr-1" style="font-size:28px;color:green;"></i>
              <span class="pro-user-name">Login</span>
            </span>
          </a>
        </li>';

        echo json_encode([
            'logged_in' => false,
            'html'      => $login_html
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return;
    }

    // Nama & foto dari session (fallback aman)
    $display_name = $nama_ses !== '' ? $nama_ses : $username;
    $foto_url     = base_url('upload/users/no-image.png');
    if (!empty($foto_ses)) {
        // Jika sudah URL penuh, pakai langsung; kalau cuma filename, prepend base_url
        if (filter_var($foto_ses, FILTER_VALIDATE_URL)) {
            $foto_url = $foto_ses;
        } else {
            $foto_url = base_url('upload/users/'.$foto_ses);
        }
    }

    // Notifikasi (pastikan view mengembalikan <li>...</li> TANPA <ul>)
    $notif_html = $this->load->view('backend/notif', [], true);

    // Dropdown user (LI saja)
    $user_html = '
    <li class="dropdown notification-list">
      <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect"
         href="#" role="button"
         data-toggle="dropdown" data-bs-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false">
        <span class="d-flex align-items-center">
          <img src="'.htmlspecialchars($foto_url, ENT_QUOTES, 'UTF-8').'"
               alt="user" class="rounded-circle mr-1" height="28">
          <span class="pro-user-name">'.htmlspecialchars($display_name, ENT_QUOTES, 'UTF-8').'</span>
        </span>
      </a>
      <div class="dropdown-menu dropdown-menu-right profile-dropdown">
        <a href="'.site_url('admin_dashboard').'" class="dropdown-item">
          <i class="fe-activity"></i> Dashboard
        </a>
        <a href="'.site_url('admin_user').'" class="dropdown-item">
          <i class="fe-user"></i> Profil
        </a>
        <div class="dropdown-divider"></div>
        <a href="'.site_url('on_login/logout').'" class="dropdown-item text-danger">
          <i class="fe-log-out"></i> Keluar
        </a>
      </div>
    </li>';

    echo json_encode([
        'logged_in' => true,
        // gabungkan notif (<li>...</li>) + user dropdown
        'html'      => (string)$notif_html . $user_html
    ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
}



}