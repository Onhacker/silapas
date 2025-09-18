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
  <style>
    
    /* ========== 1) Safe area iOS notch ========== */
    :root { --safe-top: 0px; --safe-bottom: 0px; }
    @supports (padding: max(0px)) {
      :root {
        --safe-top: env(safe-area-inset-top);
        --safe-bottom: env(safe-area-inset-bottom);
      }
    }
    .header-fixed, .app-header, header.sticky { padding-top: calc(12px + var(--safe-top)); }
    .bottom-nav, .navbar-bottom, footer.sticky { padding-bottom: calc(8px + var(--safe-bottom)); }
    .fab, .floating-logo, .btn-fab {
      position: fixed; left: 50%; transform: translateX(-50%);
      bottom: calc(20px + var(--safe-bottom)); z-index: 1000;
    }
    body { padding-bottom: var(--safe-bottom); }

    /* ========== 2) Logo bar desktop ========== */
    .d-flex.align-items-center.mb-3 > .me-3 img {
      max-height: 50px; width: auto; display: block;
      transition: all .3s ease-in-out;
      filter: drop-shadow(2px 2px 6px rgba(0,0,0,.3));
    }
    .d-flex.align-items-center.mb-3 > .me-3 { margin-right: 1rem; }
    .d-flex.align-items-center.mb-3 > .me-3 img:hover {
      filter: drop-shadow(0 0 10px rgba(255,87,34,.6)); transform: scale(1.05);
    }
    .header-title2{
      font-size:1.2rem; font-weight:600; color:#555; text-align:left; margin:10px 0;
      font-family:Arial, sans-serif; border-left:4px solid #ff5722; padding-left:10px;
      text-shadow:1px 1px 2px rgba(0,0,0,.15)
    }
    .bord{ border-left:4px solid #ff5722; padding-left:10px }
    @media (max-width: 767.98px) { .logo-desktop{ display:none !important } }

    /* ========== 3) Blok hero judul (opsional) ========== */
    :root { --a1:#dd7634; --a2:#ffffff; --a3:#CDDC39; }
    .hero-title { padding:24px 0 10px; text-align:center; }
    .hero-title .text{
      color:#fff; display:inline-block; margin:0;
      font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      font-weight:900; letter-spacing:.025em; text-transform:uppercase;
      line-height:1.1; font-size:clamp(18px,4.2vw,32px);
      filter:drop-shadow(0 2px 10px rgba(139,92,246,.15));
      animation:popIn .7s ease-out both;
    }
    .hero-title .accent{
      display:block; height:4px; width:0; margin:10px auto 0; border-radius:999px;
      background:linear-gradient(90deg,var(--a1),var(--a2),var(--a3));
      box-shadow:0 0 18px rgba(34,197,94,.35), 0 0 24px rgba(6,182,212,.25);
      animation:grow .9s .70s ease-out forwards;
    }
    @keyframes popIn{ from{opacity:0; transform:translateY(6px) scale(.98)} to{opacity:1; transform:translateY(0) scale(1)} }
    @keyframes grow{ from{width:0} to{width:min(520px,80%)} }
    @media (prefers-reduced-motion: reduce){ .hero-title .text,.hero-title .accent{animation:none} .hero-title .accent{width:min(520px,80%)} }

    /* ========== 4) Wrapper curved header (gradasi melengkung) ========== */
    :root{ --c1:#4e77be; --c2:#1e3c72; }
    .wrapper{
      position: relative; isolation: isolate;
      /* padding: clamp(16px,3vw,28px); */
      border-radius: 20px;
      /* background: #fff;  isi kartu */
      box-shadow: 0 16px 36px rgba(0,0,0,.08);
      overflow: hidden;
      margin-bottom: clamp(16px, 3vw, 32px);
    }
    .wrapper.curved{ --curve-h: 320px; }
    .wrapper.curved::before{
      content:""; position:absolute; left:0; right:0; top:0; height: var(--curve-h);
      background: linear-gradient(360deg, var(--c1), var(--c2));
      border-bottom-left-radius: 50% 16%; border-bottom-right-radius: 50% 16%;
      z-index: -1; pointer-events: none;
      filter: drop-shadow(0 18px 36px rgba(16,24,40,.18));
    }
    .wrapper > *{ position: relative; z-index: 1; }
    .wrapper.curved.curve-sm{ --curve-h: 140px; }
    .wrapper.curved.curve-md{ --curve-h: 220px; }
    .wrapper.curved.curve-lg{ --curve-h: 320px; }
    .wrapper.curved.curve-xl{ --curve-h: 420px; }

    /* ========== 5) Logo mobile stack ========== */
    .logo-boxx { display:flex; justify-content:center; align-items:center; padding:10px 0; text-align:center; }
    .logox { display:flex; align-items:center; justify-content:center; flex-direction:row; }
    .logo-smx img { height:40px; margin-right:10px; filter: drop-shadow(0 0 4px rgba(255,255,255,.8)); }
    .logo-text { display:flex; flex-direction:column; align-items:center; color:#333; text-align:center; }
    .logo-text .header-title-top { font-weight:700; font-size:18px; line-height:1.2; }
    .logo-text .header-title-bottom { font-weight:500; font-size:13px; line-height:1.2; }
    @media (max-width: 767.98px) {
      .logo-text .header-title-top { font-size:22px; }
      .logo-text .header-title-bottom { font-size:16px; }
    }
    .white-shadow-text { color:#fff !important; text-shadow:1px 1px 2px rgba(0,0,0,.7); }
    .active-menu > a {
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
      font-weight: bold;
    }

    .has-submenu a {
      transition: text-shadow 0.3s ease-in-out;
    }

    .has-submenu a:hover {
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
      font-weight: bold;
    }
    .image-container img{ display:none; }
    li.className = 'dropdown notification-list d-none d-md-block';
    /* Hilangkan pull-to-refresh & efek stretch overscroll di Chrome Android/TWA */
html, body { overscroll-behavior-y: none !important; }

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

<div class="wrapper curved" style="--curve-h: 320px">
