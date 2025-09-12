<?php $uri = $this->uri->uri_string(); ?>
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
    color: #F54927 !important; 
  }

  .navbar-bottom .nav-item a:hover i,
  .navbar-bottom .nav-item a:hover span {
    color: #F54927 !important;
  }
  .text-active {
    color: #F54927 !important
  }
</style>

<nav class="navbar fixed-bottom navbar-light bg-white shadow-sm d-lg-none navbar-bottom px-0">
  <div class="w-100 d-flex justify-content-between text-center position-relative mx-0 px-0">

    <div class="nav-item">
      <a href="<?= base_url() ?>" class="<?= ($uri == '' || $uri == 'home') ? 'text-active' : 'text-dark' ?>">
        <i class="fas fa-home d-block mb-1"></i>
        <span class="small">Beranda</span>
      </a>
    </div>

  <div class="nav-item">
      <a href="<?= base_url('hal/jadwal') ?>" class="<?= ($uri == 'hal/jadwal') ? 'text-active' : 'text-dark' ?>">
        <i class="far fa-calendar-alt d-block mb-1"></i>
        <span class="small">Jadwal</span>
      </a>
    </div>
    <div class="space-left"></div>

    <?php $web = $this->om->web_me(); ?>
    <?php
  // pastikan helper menu sudah diload (autoload/helper atau panggil di controller)
    if (!function_exists('user_can_mod')) $this->load->helper('menu');

  // tentukan hak akses untuk fitur scan
    $can_scan = function_exists('user_can_mod')
    ? user_can_mod(['admin_scan','scan','checkin/checkout'])
    : false;

  // tentukan target URL & state aktif (highlight)
    $target_url = $can_scan ? base_url('admin_scan') : base_url('booking');
    $is_active  = $can_scan ? ($uri === 'admin_scan') : ($uri === 'booking');
    ?>
    <a href="<?= $target_url ?>"
     class="center-button <?= $is_active ? 'text-white' : '' ?>"
     style="text-align:center; <?= $is_active ? 'background-color:;' : '' ?>"
     aria-label="<?= $can_scan ? 'Scan (Check-in/Out)' : 'Booking' ?>">
     <div>
      <img src="<?= base_url('assets/images/') . $web->gambar ?>"
      alt="<?= $can_scan ? 'Scan' : 'Booking' ?>"
      style="width:50px;height:50px;object-fit:contain;margin-top:0;">
    </div>
  </a>


  <div class="space-right"></div>

  <div class="nav-item">
    <a href="<?= base_url('hal/struktur') ?>" class="<?= ($uri == 'hal/struktur') ? 'text-active' : 'text-dark' ?>">
      <i class="fas fa-sitemap d-block mb-1"></i>
      <span class="small">Struktur</span>
    </a>
  </div>

  <div class="nav-item">
    <a class="<?= ($uri == 'admin_permohonan' || $uri == 'admin_profil/detail_profil' || $uri == 'booking' || $uri == 'admin_dashboard/monitor' || $uri == 'admin_scan' || $uri == 'admin_user' || $uri == 'hal/kontak') ? 'text-active' : 'text-dark' ?>" data-toggle="modal" data-target="#kontakModal">
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
<div class="modal " id="kontakModal" tabindex="-1" aria-labelledby="menumoLabel" aria-hidden="true">
  <div class="modal-dialog modal-bottom fadeInUp animated modal-dialog-full" style="animation-duration: 0.5s;">
    <div class="modal-content">
     <div class="modal-header bg-blue text-white">
      <h5 class="modal-title d-flex align-items-center text-white" id="menumoLabel">
        <i class="fas fa-concierge-bell mr-2"></i> Menu
      </h5>
      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">
      <!-- Profil -->
    <a href="<?= base_url('admin_profil/detail_profil') ?>" style="text-decoration: none;">
      <div class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
           style="position: relative; z-index: auto; font-size: 16px; background: #c7d5ff; font-weight: 600; width: 100%;">
        <i class="fas fa-user-circle mr-1"></i>Profil
      </div>
    </a>

    <!-- Booking -->
    <a href="<?= base_url('booking') ?>" style="text-decoration: none;">
      <div class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
           style="position: relative; z-index: auto; font-size: 16px; background: #c7d5ff; font-weight: 600; width: 100%;">
        <i class="mdi mdi-calendar-check mr-1"></i>Booking
      </div>
    </a>

     <a href="<?= base_url('hal/alur') ?>" style="text-decoration: none;">
      <div class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
           style="position: relative; z-index: auto; font-size: 16px; background: #c7d5ff; font-weight: 600; width: 100%;">
        <i class="fas fa-project-diagram mr-1"></i>Alur Kunjungan
      </div>
    </a>


   

    <!-- Statistik (dashboard) -->
    <?php if (user_can_mod(['admin_dashboard'])): ?>
      <a id="quick-dashboard-link" href="<?= site_url('admin_dashboard') ?>" style="text-decoration:none;">
        <div id="quick-dashboard-card"
             class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
             style="position:relative; z-index:auto; font-size:16px; background:#c7d5ff; font-weight:600; width:100%;">
          <i class="fas fa-chart-line mr-1"></i>Statistik
        </div>
      </a>
    <?php endif; ?>

    <!-- Monitoring -->
    <?php if (user_can_mod(['admin_dashboard/monitor'])): ?>
      <a id="quick-dashboard-monitor-link" href="<?= site_url('admin_dashboard/monitor') ?>" style="text-decoration:none;">
        <div id="quick-dashboard-monitor-card"
             class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
             style="position:relative; z-index:auto; font-size:16px; background:#c7d5ff; font-weight:600; width:100%;">
          <i class="fas fa-clipboard-list mr-1"></i>Monitoring
        </div>
      </a>
    <?php endif; ?>

    <!-- Checkin/Checkout -->
    <?php if (user_can_mod(['admin_scan'])): ?>
      <a id="quick-scan-link" href="<?= site_url('admin_scan') ?>" style="text-decoration:none;">
        <div id="quick-scan-card"
             class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
             style="position:relative; z-index:auto; font-size:16px; background:#c7d5ff; font-weight:600; width:100%;">
          <i class="mdi mdi-qrcode-scan mr-1"></i>Checkin/Checkout
        </div>
      </a>
    <?php endif; ?>

    <!-- Data -->
    <?php if (user_can_mod(['admin_permohonan'])): ?>
      <a id="quick-data-link" href="<?= site_url('admin_permohonan') ?>" style="text-decoration:none;">
        <div id="quick-data-card"
             class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
             style="position:relative; z-index:auto; font-size:16px; background:#c7d5ff; font-weight:600; width:100%;">
          <i class="fe-database mr-1"></i>Data
        </div>
      </a>
    <?php endif; ?>

    <!-- Manajemen User -->
    <?php if (user_can_mod(['admin_user'])): ?>
      <a id="quick-user-link" href="<?= site_url('admin_user') ?>" style="text-decoration:none;">
        <div id="quick-user-card"
             class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success"
             style="position:relative; z-index:auto; font-size:16px; background:#c7d5ff; font-weight:600; width:100%;">
          <i class="fas fa-users-cog mr-1"></i>Manajemen User
        </div>
      </a>
    <?php endif; ?>



<!-- Kontak -->
<a href="<?php echo base_url('hal/kontak') ?>" style="text-decoration: none;">
  <div class="external-event text-dark ui-draggable ui-draggable-handle" data-class="bg-success" style="position: relative; z-index: auto; font-size: 16px; background: #c7d5ff; font-weight: 600; width: 100%;">
    <i class="fas fa-address-book mr-1"></i>Kontak 
  </div>
</a>
</div>
</div>
</div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const QUICK = {
      admin_user:       { a: document.getElementById("quick-user-link") },
      admin_permohonan: { a: document.getElementById("quick-data-link") },
      admin_scan:       { a: document.getElementById("quick-scan-link") },
      admin_dashboard:       { a: document.getElementById("quick-dashboard-link") },
      admin_dashboard_monitor:       { a: document.getElementById("quick-dashboard_monitor-link") }
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

