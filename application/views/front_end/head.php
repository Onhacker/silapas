<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucfirst(strtolower($rec->nama_website))." - ".$title ; ?></title>
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="robots" content="index, follow">
    <meta content="Onhacker.net" name="author" />
    <meta name="description" content="<?= htmlspecialchars($deskripsi) ?>">
    <meta name="keyword" content="<?= htmlspecialchars($rec->meta_keyword) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($rec->nama_website." - ".$title) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($deskripsi) ?>" />
    <meta property="og:image" content="<?= $prev ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="google" content="notranslate">
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "<?php echo $rec->nama_website ; ?>",
          "url": "<?php echo site_url(); ?>",
          "logo": "<?php echo base_url('assets/images/logo.png'); ?>"
      }
  </script>
 <!-- pilih salah satu pendekatan -->
<!-- pilih warna gelap headermu -->
<meta name="theme-color" media="(prefers-color-scheme: light)" content="#0F172A">
<meta name="theme-color" media="(prefers-color-scheme: dark)"  content="#000000">



  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="manifest" href="<?= site_url('developer/manifest') ?>?v=7">
  <link rel="icon" href="<?php echo base_url('assets/images/favicon.ico') ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico') ?>" type="image/x-icon" />

  <link href="<?php echo base_url('assets/admin/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('assets/admin/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('assets/admin/css/app.min.css'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url() ?>assets/admin/libs/animate/animate.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

  <style type="text/css">
   .d-flex.align-items-center.mb-3>.me-3 img{max-height:50px;width:auto;display:block;transition:all .3s ease-in-out;filter:drop-shadow(2px 2px 6px rgba(0,0,0,.3))}.d-flex.align-items-center.mb-3>.me-3{margin-right:1rem}@media (max-width:767.98px){.logo-desktop{display:none!important}}.search-result-box .kepala{padding-bottom:20px;border-bottom:1px solid #f1f5f7;margin-bottom:20px}.header-title2{font-size:1.2rem;font-weight:600;color:#555;text-align:left;margin:10px 0;font-family:'Arial',sans-serif;border-left:4px solid #ff5722;padding-left:10px;text-shadow:1px 1px 2px rgba(0,0,0,.15)}.d-flex.align-items-center.mb-3>.me-3 img:hover{filter:drop-shadow(0 0 10px rgba(255,87,34,.6));transform:scale(1.05)}.bord{border-left:4px solid #ff5722;padding-left:10px}
   body {
    padding-bottom: 0px;
}
/* default 0 untuk browser lama */
:root {
  --safe-top: 0px;
  --safe-bottom: 0px;
}

/* override dengan nilai real di device yang support */
@supports (padding: max(0px)) {
  :root {
    --safe-top: env(safe-area-inset-top);
    --safe-bottom: env(safe-area-inset-bottom);
  }
}

/* HEADER/FIXED BAR ATAS */
.header-fixed, .app-header, header.sticky {
  /* beri ruang di atas supaya tidak ketimpa status bar */
  padding-top: calc(12px + var(--safe-top));
}

/* NAV BAWAH / TAB BAR */
.bottom-nav, .navbar-bottom, footer.sticky {
  /* beri ruang ekstra di bawah agar tidak nempel gesture bar */
  padding-bottom: calc(8px + var(--safe-bottom));
}

/* TOMBOL/MENU BULAT MENGAMBANG DI TENGAH BAWAH */
.fab, .floating-logo, .btn-fab {
  position: fixed;
  left: 50%;
  transform: translateX(-50%);
  /* naikkan setinggi safe-area */
  bottom: calc(20px + var(--safe-bottom));
  /* z-index kalau perlu di atas nav */
  z-index: 1000;
}

/* (opsional) kalau ada body yang dipakai scroll container  */
body { padding-bottom: var(--safe-bottom); }

</style>
<style>
  :root{
    --c1:#22c55e; /* green */
    --c2:#06b6d4; /* cyan  */
    --c3:#8b5cf6; /* violet*/
  }
  .hero-title{
    padding:24px 0 10px;
    text-align:center;
  }
  .hero-title .text{
  display:inline-block;
  margin:0;
  font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
  font-weight:900;
  letter-spacing:.025em;
  text-transform:uppercase;
  line-height:1.1;
  font-size:clamp(18px,4.2vw,32px);
  /* (opsional) kalau mau efek gradien teks, aktifkan 4 baris ini:
  background:linear-gradient(90deg,var(--c1),var(--c2),var(--c3));
  -webkit-background-clip:text;
          background-clip:text;
  color:transparent;
  */
  filter:drop-shadow(0 2px 10px rgba(139,92,246,.15));
  animation:popIn .7s ease-out both;
}

  .hero-title .accent{
    display:block;
    height:4px;
    width:0;
    margin:10px auto 0;
    border-radius:999px;
    background:linear-gradient(90deg,var(--c1),var(--c2),var(--c3));
    box-shadow:0 0 18px rgba(34,197,94,.35), 0 0 24px rgba(6,182,212,.25);
    animation:grow .9s .70s ease-out forwards;
  }
  @keyframes popIn{
    from{opacity:0; transform:translateY(6px) scale(.98)}
    to  {opacity:1; transform:translateY(0)   scale(1)}
  }
  @keyframes grow{
    from{width:0}
    to  {width:min(520px,80%)}
  }
  @media (prefers-reduced-motion: reduce){
    .hero-title .text,.hero-title .accent{animation:none}
    .hero-title .accent{width:min(520px,80%)}
  }
  
</style>
</head>

<?php $this->load->view("global") ?>
<body class="menubar-gradient gradient-topbar topbar-dark">
    <div id="preloader">
        <div id="status">
         <div class="image-container animated flip infinite">
          <img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="Foto" style="display: none;" onload="this.style.display='block';" />
      </div>
  </div>
</div>
<header id="topnav">

  <div class="navbar-custom">
    <div class="container-fluid">

        <div class="logo-desktop d-flex align-items-center mb-3">
            <div class="me-3">
                <img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="Logo <?php echo $rec->nama_website ?>" height="50px">

            </div>
            <div class="kepala">
                <h4 class="mb-1">
                    <span class="header-title2"><?php echo ($rec->nama_website)." ".strtoupper($rec->kabupaten) ?>

                </a>
            </h4>
            <div class="font-13 text-success mb-2 text-truncate">
                <code><?php echo strtoupper($rec->meta_deskripsi." ") ?></code>
            </div>
        </div>
    </div>
    <style type="text/css">
        .logo-boxx {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
            text-align: center;
        }

        .logo-boxx .logox {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
        }

        .logo-smx img {
            height: 40px;
            margin-right: 10px;
            filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.8));


        }


        .logo-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
            text-align: center;
        }

        .logo-text .header-title-top {
            font-weight: 700;
            font-size: 18px;
            line-height: 1.2;
        }

        .logo-text .header-title-bottom {
            font-weight: 500;
            font-size: 13px;
            line-height: 1.2;
        }

        @media (max-width: 767.98px) {
            .logo-text .header-title-top {
                font-size: 22px;
            }
            .logo-text .header-title-bottom {
                font-size: 16px;
            }
        }

        .white-shadow-text {
            color: #fff !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); 
        }

    </style>
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
        <?php $this->load->view("front_end/menu.php") ?>
    </div>
</div>
</header>

<div class="wrapper">
