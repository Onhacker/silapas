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
  <style>
/* ============ Variabel tema ============ */
:root{
  --hdr-bg1:#0d2d58;     /* biru tua */
  --hdr-bg2:#184c8a;     /* biru muda */
  --hdr-accent:#f59e0b;  /* oranye aksen */
  --hdr-text:#fff;
  --hdr-muted:#dbe7ff;
  --hdr-shadow:0 12px 30px rgba(0,0,0,.22);
  --safe-top: env(safe-area-inset-top);
}

/* ============ Wrapper header ============ */
/*#topnav{*/
  /*position:sticky; top:0; z-index:1030;*/
  /*color:var(--hdr-text);*/
  /*background:linear-gradient(155deg,var(--hdr-bg1),var(--hdr-bg2));*/
  /*box-shadow:var(--hdr-shadow);*/
  /*padding-top: max(6px, var(--safe-top));*/
/*}*/

/* Bar atas: glassy */
#topnav .navbar-custom{
  background:rgba(8,25,55,.45) !important;
  backdrop-filter:saturate(150%) blur(8px);
  border-bottom:1px solid rgba(255,255,255,.08);
}

/* Logo & judul */
.logo-desktop img{
  height:50px; width:auto;
  border-radius:12px; padding:4px;
  background:rgba(255,255,255,.08);
  box-shadow:inset 0 0 0 1px rgba(255,255,255,.12);
}
.logo-desktop .kepala{ line-height:1.1 }
.header-title2{
  display:inline-block; margin:0; color:#fff;
  font-weight:800; letter-spacing:.3px;
  text-transform:uppercase;
  text-shadow:0 2px 8px rgba(0,0,0,.25);
}
/* garis aksen di bawah judul */
.header-title2::after{
  content:""; display:block; height:3px; width:132px;
  margin-top:.1rem; background:var(--hdr-accent);
  border-radius:999px; box-shadow:0 2px 10px rgba(245,158,11,.5);
}

/* Tagline (kamu pakai <code>) → ubah jadi pill */
.logo-desktop code{
  display:inline-block; color:var(--hdr-muted);
  background:rgba(255,255,255,.08);
  border:1px solid rgba(255,255,255,.14);
  padding:.25rem .5rem; border-radius:999px;
  font-size:.82rem; font-weight:600;
}

/* Versi mobile (blok logo-boxx) */
/*.logo-boxx .logo-smx img{ height:42px; width:42px; border-radius:10px }*/
/*.logo-boxx .header-title-top{ font-weight:800; letter-spacing:.3px }*/
/*.logo-boxx .header-title-bottom{ opacity:.9 }*/

/* ============ Menu utama ============ */
/*.topbar-menu{ background:transparent }*/
/*#navigation{ margin-top:.35rem }*/
.navigation-menu{
  display:flex; gap:.4rem; flex-wrap:wrap; align-items:center;
  padding: .35rem 0; margin:0;
  list-style:none;
}
/* pill */
.navigation-menu > li > a{
  display:flex; align-items:center; gap:.45rem;
  padding:.52rem .8rem; border-radius:12px;
  color:#eef3ff; text-decoration:none; font-weight:600;
  background:rgba(255,255,255,.09);
  border:1px solid rgba(255,255,255,.14);
  transition:transform .15s ease, background .15s ease, border-color .15s ease;
}
.navigation-menu > li > a i{ font-size:1rem; opacity:.95 }
/* hover/focus */
.navigation-menu > li > a:hover,
.navigation-menu > li > a:focus{
  transform:translateY(-1px);
  background:rgba(255,255,255,.16);
  border-color:rgba(255,255,255,.28);
}
/* aktif */
.navigation-menu > li.active-menu > a{
  background:linear-gradient(135deg, var(--hdr-accent), #ffcc66);
  color:#1b2540; border-color:transparent;
  text-shadow:none;
}

/* Dropdown (Panduan) */
.navigation-menu .submenu{
  background:rgba(2,14,32,.6);
  border:1px solid rgba(255,255,255,.14);
  backdrop-filter:saturate(140%) blur(6px);
  border-radius:14px; padding:.35rem; margin-top:.35rem;
}
.navigation-menu .submenu li a{
  border-radius:10px; padding:.5rem .6rem;
}


</style>

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
                <span class="header-title-bottom white-shadow-text"><?php echo $rec->type ?></span>
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
        <a href="<?= site_url('home'); ?>">&nbsp;&nbsp;&nbsp;<i class="fe-home"></i> Home</a>
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
