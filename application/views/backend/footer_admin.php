<?php $uri = $this->uri->uri_string(); ?>
<?php
// --- ACTIVE HELPER ---
$uri = trim($this->uri->uri_string(), '/'); // normalize

if (!function_exists('uri_is')) {
  function uri_is(string $uri, $patterns): bool {
    foreach ((array)$patterns as $p) {
      $p = trim((string)$p, '/');
      if ($p === '') { if ($uri === '') return true; continue; }
      // wildcard '*' di akhir = prefix match
      if (substr($p, -1) === '*') {
        $prefix = rtrim($p, '*');
        if ($uri === $prefix || strpos($uri, $prefix) === 0) return true;
      } elseif ($uri === $p) {
        return true;
      }
    }
    return false;
  }
}

if (!function_exists('nav_class')) {
  function nav_class(string $uri, $patterns, string $on='text-active', string $off='text-dark'): string {
    return uri_is($uri, $patterns) ? $on : $off;
  }
}
?>

<style>
  .navbar-bottom {
    height: 65px;
    border-top: 1px solid #dee2e6;
    background-color: #fff;
    box-shadow: 0 -1px 5px rgba(0,0,0,0.05);
    z-index: 1030;
  }

  .navbar-bottom a {
    font-size: 12px;
    color: #666;
    text-decoration: none;
  }

  .navbar-bottom i {
    font-size: 18px;
  }

  .center-button {
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    /*background-image: linear-gradient(to right, #00c6ff 0%, #0072ff 100%) !important;*/
    background-image: linear-gradient(to right, #1e3c72 0%, #2a5298 100%) !important;

    width: 65px;
    height: 65px;
    border-radius: 50%;
    border: 1px solid #dee2e6;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: footerAni 1s infinite;
    z-index: 10;
  }

  .center-button .icon-center {
    width: 30px;
    height: 30px;
    object-fit: contain;
  }

  .nav-item {
    flex: 1;
    text-align: center;
  }

  .space-left, .space-right {
    flex: 0.5;
  }

  @keyframes footerAni {
    0% {
      transform: scale(1,1) translateX(-50%)
    }

    50% {
      transform: scale(1.05,1.05) translateX(-48%)
    }
  }
  .navbar-bottom .nav-item a:hover {
    color: #4a81d4 !important; 
  }

  .navbar-bottom .nav-item a:hover i,
  .navbar-bottom .nav-item a:hover span {
    color: #4a81d4 !important;
  }
  .text-active {
    color: #4a81d4 !important
  }
</style>

<nav class="navbar fixed-bottom navbar-light bg-white shadow-sm d-lg-none navbar-bottom px-0">
  <div class="w-100 d-flex justify-content-between text-center position-relative mx-0 px-0">

    <div class="nav-item">
      <a href="<?= base_url() ?>" class="<?= nav_class($uri, ['', 'home']) ?>">
        <i class="fas fa-home d-block mb-1"></i>
        <span class="small">Beranda</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="<?= base_url('hal/jadwal') ?>" class="<?= nav_class($uri, ['hal/jadwal*']) ?>">
        <i class="far fa-calendar-alt d-block mb-1"></i>
        <span class="small">Jadwal</span>
      </a>
    </div>

    <div class="space-left"></div>

    <?php $web = $this->om->web_me();
    if (!function_exists('user_can_mod')) $this->load->helper('menu');

    $can_scan   = function_exists('user_can_mod') ? user_can_mod(['admin_scan','scan','checkin/checkout']) : false;
    $target_url = $can_scan ? base_url('admin_scan') : base_url('booking');
    $center_on  = uri_is($uri, $can_scan ? ['admin_scan'] : ['booking']);
    ?>
    <a href="<?= $target_url ?>"
       class="center-button <?= $center_on ? 'text-white' : '' ?>"
       style="text-align:center; <?= $center_on ? 'background-image:none;background-color:#2a5298;' : '' ?>"
       aria-label="<?= $can_scan ? 'Scan (Check-in/Out)' : 'Booking' ?>">
      <div>
        <img src="<?= base_url('assets/images/') . $web->gambar ?>"
             alt="<?= $can_scan ? 'Scan' : 'Booking' ?>"
             style="width:50px;height:50px;object-fit:contain;margin-top:0;">
      </div>
    </a>

    <div class="space-right"></div>

    <div class="nav-item">
      <a href="<?= base_url('hal/struktur') ?>" class="<?= nav_class($uri, ['hal/struktur*']) ?>">
        <i class="fas fa-sitemap d-block mb-1"></i>
        <span class="small">Struktur</span>
      </a>
    </div>

    <?php
      // Semua halaman yang “mewakili” Menu → bikin aktif ikon Menu
      $menu_patterns = [
        'admin_permohonan','admin_profil/detail_profil','booking',
        'admin_dashboard/monitor','admin_scan','admin_user','hal/kontak',
        'Admin_setting_web*','Admin_unit_tujuan*','Admin_unit_lain*'
      ];
    ?>
    <div class="nav-item">
      <a href="#" class="<?= nav_class($uri, $menu_patterns) ?>" data-toggle="modal" data-target="#kontakModal">
        <i class="fas fa-bars d-block mb-1"></i>
        <span class="small">Menu</span>
      </a>
    </div>

  </div>
</nav>

<style type="text/css">

  .modal-dialog.modal-bottom {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    transform: translateY(100%); 
    transition: transform 0.3s ease-out; 
    margin: 0;
  }

  .modal.fade.show .modal-dialog.modal-bottom {
    transform: translateY(0); 
  }
  .modal-dialog-full {
    max-width: 100%;
  }

  .modal-content-full {
    height: 100%;
    border-radius: 0;
  }


  .modal-content {
    border-radius: 0; 
    width: 100%; 
    margin: 0;
  }

</style>
<!-- Modal Menu (scrollable + icon rapi) -->
<div class="modal" id="kontakModal" tabindex="-1" aria-labelledby="menumoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-bottom fadeInUp animated modal-dialog-full" style="animation-duration: .5s;">
    <div class="modal-content">
      <div class="modal-header bg-blue text-white">
        <h5 class="modal-title d-flex align-items-center text-white" id="menumoLabel">
          <i class="fas fa-concierge-bell mr-2"></i> Menu
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body p-0">
        <div class="menu-list">

          <!-- Profil -->
          <a href="<?= base_url('admin_profil/detail_profil') ?>" class="menu-item">
            <i class="fas fa-user-circle"></i><span>Profil</span>
          </a>

          <!-- Booking -->
          <a href="<?= base_url('booking') ?>" class="menu-item">
            <i class="fas fa-calendar-check"></i><span>Booking</span>
          </a>

          <!-- Alur Kunjungan -->
          <a href="<?= base_url('hal/alur') ?>" class="menu-item">
            <i class="fas fa-project-diagram"></i><span>Alur Kunjungan</span>
          </a>

          <!-- Statistik (dashboard) -->
          <?php if (user_can_mod(['admin_dashboard'])): ?>
            <a id="quick-dashboard-link" href="<?= site_url('admin_dashboard') ?>" class="menu-item">
              <i class="fas fa-chart-line"></i><span>Statistik</span>
            </a>
          <?php endif; ?>

          <!-- Monitoring -->
          <?php if (user_can_mod(['admin_dashboard/monitor'])): ?>
            <a id="quick-dashboard-monitor-link" href="<?= site_url('admin_dashboard/monitor') ?>" class="menu-item">
              <i class="fas fa-clipboard-list"></i><span>Monitoring</span>
            </a>
          <?php endif; ?>

          <!-- Checkin/Checkout -->
          <?php if (user_can_mod(['admin_scan'])): ?>
            <a id="quick-scan-link" href="<?= site_url('admin_scan') ?>" class="menu-item">
              <i class="fas fa-qrcode"></i><span>Checkin/Checkout</span>
            </a>
          <?php endif; ?>

          <!-- Data -->
          <?php if (user_can_mod(['admin_permohonan'])): ?>
            <a id="quick-data-link" href="<?= site_url('admin_permohonan') ?>" class="menu-item">
              <i class="fas fa-database"></i><span>Data</span>
            </a>
          <?php endif; ?>

          <!-- Manajemen User -->
          <?php if (user_can_mod(['admin_user'])): ?>
            <a id="quick-user-link" href="<?= site_url('admin_user') ?>" class="menu-item">
              <i class="fas fa-users-cog"></i><span>Manajemen User</span>
            </a>
          <?php endif; ?>

          <!-- Pengaturan Sistem -->
          <?php if (user_can_mod(['Admin_setting_web'])): ?>
            <a id="quick-setting-link" href="<?= site_url('Admin_setting_web') ?>" class="menu-item">
              <i class="fas fa-cogs"></i><span>Pengaturan Sistem</span>
            </a>
          <?php endif; ?>

          <!-- Unit Tujuan -->
          <?php if (user_can_mod(['Admin_unit_tujuan'])): ?>
            <a id="quick-unit-link" href="<?= site_url('Admin_unit_tujuan') ?>" class="menu-item">
              <i class="fas fa-building"></i><span>Unit Tujuan</span>
            </a>
          <?php endif; ?>

          <!-- Unit Lain -->
          <?php if (user_can_mod(['Admin_unit_lain'])): ?>
            <a id="quick-unit-lain-link" href="<?= site_url('Admin_unit_lain') ?>" class="menu-item">
              <i class="fas fa-briefcase"></i><span>Unit Lain</span>
            </a>
          <?php endif; ?>

          <?php if (user_can_mod(['Admin_instansi_ref'])): ?>
            <a id="quick-instansi-ref-link" href="<?= site_url('Admin_instansi_ref') ?>" class="menu-item" title="Instansi Asal">
              <i class="fe-briefcase"></i><span>Instansi Asal</span>
            </a>
          <?php endif; ?>


          <!-- Kontak -->
          <a href="<?= base_url('hal/kontak') ?>" class="menu-item">
            <i class="fas fa-address-book"></i><span>Kontak</span>
          </a>

        </div><!-- /.menu-list -->
      </div><!-- /.modal-body -->
    </div>
  </div>
</div>

<!-- Style khusus modal menu -->
<style>
  /*.bg-blue{ background:#1f6feb !important; }*/

  #kontakModal .menu-list{
    max-height: 70vh;        /* bikin body modal bisa discroll */
    overflow-y: auto;
    padding: 12px;
  }
  #kontakModal .menu-item{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 14px;
    margin:10px 12px;
    border-radius:12px;
    background:#c7d5ff;
    font-weight:600;
    color:#111 !important;
    text-decoration:none !important;
    transition: background .2s ease, transform .1s ease;
  }
  #kontakModal .menu-item:hover{ background:#b9c9ff; }
  #kontakModal .menu-item:active{ transform: translateY(1px); }
  #kontakModal .menu-item i{ width:22px; text-align:center; }
  /* optional: rapihin scrollbar */
  #kontakModal .menu-list::-webkit-scrollbar{ width:8px; }
  #kontakModal .menu-list::-webkit-scrollbar-thumb{ background:#1D41D1; border-radius:8px; }
</style>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const QUICK = {
      admin_user:       { a: document.getElementById("quick-user-link") },
      admin_permohonan: { a: document.getElementById("quick-data-link") },
      admin_scan:       { a: document.getElementById("quick-scan-link") },
      admin_dashboard:       { a: document.getElementById("quick-dashboard-link") },
      admin_dashboard_monitor:       { a: document.getElementById("quick-dashboard-monitor-link") },
      admin_setting_web:       { a: document.getElementById("quick-setting-link") },
      admin_unit_tujuan:       { a: document.getElementById("quick-unit-link") },
      admin_unit_lain:       { a: document.getElementById("quick-unit-lain-link") },
      admin_instansi_ref:       { a: document.getElementById("quick-instansi-ref-link") }
    };

    const setVis = (id, show) => {
      const q = QUICK[id];
      if (!q || !q.a) return;
      q.a.style.display = show ? "" : "none";
    };

  // Catatan: JANGAN hideAll di awal. Biarkan tampilan server-side dulu.
  // Hanya sinkronkan jika kita menerima data baru (HTTP 200, success=true).

  fetch("<?= site_url('api/get_menu_mobile') ?>?v=1") // pakai versi kecil agar ETag berfungsi; jangan pakai Date.now()
  .then(async (r) => {
    if (r.status === 304) {
        // Tidak ada perubahan → keep current DOM (server-side sudah benar)
        return null;
      }
      if (!r.ok) throw new Error("HTTP " + r.status);
      const etag = r.headers.get("ETag");
      const data = await r.json();
      return { etag, data };
    })
  .then((res) => {
    if (!res || !res.data || !res.data.success) return;

    const actions = res.data.actions || [];
    const allowed = new Set(actions.map(a => a.id));

      // Sinkronkan visibilitas hanya jika kita punya data segar
      ['admin_user','admin_permohonan'].forEach(id => setVis(id, allowed.has(id)));

      // (Opsional) sinkronkan URL dari server
      actions.forEach(a => {
        const q = QUICK[a.id];
        if (q && q.a && a.url) q.a.href = a.url;
      });
    })
  .catch((err) => {
      // Gagal fetch → biarkan tampilan server-side
      console.warn("get_menu_mobile failed:", err);
    });
});
</script>

