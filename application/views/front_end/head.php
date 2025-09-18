<!DOCTYPE html>
<html lang="id">
<head>
  <!-- ========== META DASAR ========== -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
  <meta name="robots" content="index, follow">
  <meta name="google" content="notranslate">
  <meta name="author" content="Onhacker.net">

  <title><?= ucfirst(strtolower($rec->nama_website)).' - '.$title; ?></title>

  <!-- ========== THEME COLOR (LIGHT/DARK) ========== -->
  <meta name="theme-color" media="(prefers-color-scheme: light)" content="#0F172A">
  <meta name="theme-color" media="(prefers-color-scheme: dark)"  content="#000000">

  <!-- ========== SEO / OPEN GRAPH / TWITTER ========== -->
  <meta name="description" content="<?= htmlspecialchars($deskripsi) ?>">
  <meta name="keywords" content="<?= htmlspecialchars($rec->meta_keyword) ?>">
  <meta property="og:title" content="<?= htmlspecialchars($rec->nama_website.' - '.$title) ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($deskripsi) ?>" />
  <meta property="og:image" content="<?= $prev ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:url" content="<?= current_url() ?>" />
  <meta property="og:type" content="website" />
  <meta name="twitter:card" content="summary_large_image" />

  <!-- ========== PWA / ICONS ========== -->
  <link rel="manifest" href="<?= site_url('developer/manifest') ?>?v=7">
  <link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon" />

  <!-- ========== JSON-LD ORGANIZATION ========== -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "<?= addslashes($rec->nama_website) ?>",
      "url": "<?= site_url() ?>",
      "logo": "<?= base_url('assets/images/logo.png'); ?>"
    }
  </script>

  <!-- ========== CSS VENDOR ========== -->
  <link href="<?= base_url('assets/admin/css/bootstrap.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/admin/css/icons.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/admin/css/app.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/admin/libs/animate/animate.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/admin/libs/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" />
   <!-- ========== CSS KUSTOM (DIKELOMPOKKAN) ========== -->
  <link href="<?= base_url('assets/min/head.min.css'); ?>" rel="stylesheet" />
  <script>
   
    (function(){
      // Jangan tampilkan di mobile (≤768px)
      if (window.matchMedia('(max-width: 767.98px)').matches) return;

      var url = "<?= site_url('api/status') ?>";
      fetch(url, {
        method: 'GET',
        credentials: 'same-origin',
        cache: 'no-store',
        headers: { 'Accept': 'application/json' }
      })
      .then(function(r){ return r.ok ? r.json() : null; })
      .then(function(j){
        if (!j || !j.success || !j.data || !j.data.logged_in) return;

        var ul = document.getElementById('topnav-right'); // pastikan <ul id="topnav-right">
        if (!ul) return;

        var li = document.createElement('li');
        li.className = 'dropdown notification-list';

        var a = document.createElement('a');
        a.className = 'nav-link dropdown-toggle waves-effect';
        a.href = j.data.dashboard || "<?= site_url('admin_profil/detail_profil') ?>";
        a.innerHTML = '<i class="fe-user user"></i> Ke Dashboard';

        li.appendChild(a);
        ul.appendChild(li);
      })
      .catch(function(){ /* offline: diamkan saja */ });
    })();
    </script>

</head>

<?php $this->load->view("global") ?> 
<body class="menubar-gradient gradient-topbar topbar-dark">
   <div id="preloader">
        <div id="status">
            <div class="image-container animated flip infinite"> <img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="Foto" style="display: none;" onload="this.style.display='block';" /> </div>
        </div>
    </div>
<header id="topnav">

  <div class="navbar-custom">
    <div class="container-fluid">
      <ul class="list-unstyled topnav-menu float-right mb-0" id="topnav-right"></ul>
     
        <div class="logo-desktop d-flex align-items-center mb-3">
            <div class="me-3">
                <img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="Logo <?php echo $rec->nama_website ?>" height="50px">

            </div>
            <div class="kepala">
                <h4 class="mb-1">
                    <span class="header-title2"><?php echo ($rec->nama_website)." ".strtoupper($rec->kabupaten) ?>
            </h4>
            <div class="font-13 text-success mb-2 text-truncate">
                <code><?php echo strtoupper($rec->meta_deskripsi." ") ?></code>
            </div>
        </div>
    </div>
   
    <div class="logo-boxx d-block d-md-none">
        <div class="logox">
            <div class="logo-smx">
                <img src="<?php echo base_url('assets/images/') . $rec->gambar ?>" alt="Logo <?php echo $rec->nama_website ?>">

            </div>
            <div class="logo-text">
                <span class="header-title-top white-shadow-text"><?php echo $rec->nama_website ?></span>
                <span class="header-title-bottom white-shadow-text"><?php echo $rec->kabupaten ?></span>
            </div>
        </div>
    </div>

</div>
</div>
<div class="topbar-menu">
    <div class="container-fluid">

<?php $uri = $this->uri->uri_string(); ?>
  <div id="navigation">
    <ul class="navigation-menu">
      <li class="has-submenu <?= ($uri === '' || $uri === 'home') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('home'); ?>"><i class="fe-home"></i> Home</a>
      </li>

      <li class="has-submenu <?= ($uri === 'booking') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('booking'); ?>"><i class="fe-calendar"></i> Booking</a>
      </li>

      <li class="has-submenu <?= ($uri === 'hal/jadwal') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('hal/jadwal'); ?>"><i class="fe-clock"></i> Jadwal</a>
      </li>

      <li class="has-submenu <?= ($uri === 'hal/struktur') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('hal/struktur'); ?>"><i class="fe-users"></i> Struktur Organisasi</a>
      </li>
      <li class="has-submenu <?= ($uri === 'hal/pengumuman') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('hal/pengumuman'); ?>">
          <i class="fe-bell"></i> Pengumuman
        </a>
      </li>


      <!-- PANDUAN DROPDOWN -->
      <li class="has-submenu <?= ($uri === 'hal/panduan' || $uri === 'hal/alur') ? 'active-menu' : '' ?>">
        <a href="javascript:void(0);"><i class="fe-book-open"></i> Panduan <div class="arrow-down"></div></a>
        <ul class="submenu">
          <li class="<?= ($uri === 'hal/panduan') ? 'active' : '' ?>">
            <a href="<?= site_url('hal/panduan'); ?>"><i class="fe-file-text"></i> Tata Cara</a>
          </li>
          <li class="<?= ($uri === 'hal/alur') ? 'active' : '' ?>">
            <a href="<?= site_url('hal/alur'); ?>"><i class="fe-git-branch"></i> Alur Kunjungan</a>
          </li>
        </ul>
      </li>

      <li class="has-submenu <?= ($uri === 'hal/kontak') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('hal/kontak'); ?>"><i class="fe-phone-call"></i> Kontak</a>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>

    </div>
</div>
</header>
<style type="text/css">
  /* Kunci root agar Chrome tidak mengaktifkan P2R di root scroller */
/*html, body {
  height: 100%;
  overflow: hidden !important;
}*/

/* Scroll di container saja */
#app-scroll {
  height: 100%;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;   /* tetap halus */
  overscroll-behavior: contain;        /* blokir overscroll chain & P2R */
}

</style>
<script>
(function () {
  if (document.referrer && document.referrer.indexOf('android-app://') === 0) {
    const st = document.createElement('style');
    st.textContent = 'html,body{overscroll-behavior-y:none!important}';
    document.head.appendChild(st);
  }
})();
</script>

<div class="wrapper curved" style="--curve-h: 320px" id="app-scroll">
