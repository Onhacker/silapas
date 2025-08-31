<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title><?php echo $rec->nama_website." - ".$title ; ?></title>
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover,user-scalable=no">
    <meta name="robots" content="index, follow">
    <meta content="Onhacker.net" name="author" />
    <meta name="description" content="<?= htmlspecialchars($deskripsi) ?>">
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

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="manifest" href="<?= site_url('developer/manifest') ?>?v=1">
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
          const container = document.getElementById('header_notif_container');

          function initDropdowns(ctx) {
            // Bootstrap 4 (pakai jQuery)
            if (window.jQuery && $.fn.dropdown) {
              $(ctx).find('.dropdown-toggle').dropdown();
              return;
            }
            // Bootstrap 5 (tanpa jQuery)
            if (window.bootstrap && bootstrap.Dropdown) {
              ctx.querySelectorAll('[data-bs-toggle="dropdown"],[data-toggle="dropdown"]').forEach(el => {
                // hindari duplikasi instance
                try { bootstrap.Dropdown.getOrCreateInstance(el); } catch(e){}
              });
            }
          }

          async function loadStatusUser() {
            try {
              const r = await fetch('<?= site_url("api/ajax_status_user") ?>', { method:'GET', credentials:'same-origin' });
              const data = await r.json();

              if (!container) return;

              // API harus mengirim HTML <li>...</li> saja (bukan <ul>)
              const html = (data && typeof data.html === 'string' && data.html.trim() !== '')
                ? data.html
                : '<li class="dropdown notification-list"><a class="nav-link nav-user mr-0 waves-effect" href="<?= site_url("on_login") ?>"><span class="d-flex align-items-center"><i class="fas fa-user-circle mr-1" style="font-size:28px;color:green;"></i><span class="pro-user-name">Login</span></span></a></li>';

              container.innerHTML = html;

              // pastikan semua toggle dropdown aktif
              initDropdowns(container);
            } catch (err) {
              console.error('Error fetching status:', err);
              if (container) {
                container.innerHTML =
                  '<li class="dropdown notification-list"><a class="nav-link nav-user mr-0 waves-effect" href="<?= site_url("on_login") ?>"><span class="d-flex align-items-center"><i class="fas fa-user-circle mr-1" style="font-size:28px;color:green;"></i><span class="pro-user-name">Login</span></span></a></li>';
              }
            }
          }

          loadStatusUser();
          // opsional: auto-refresh tiap beberapa menit
          // setInterval(loadStatusUser, 180000);
        });
</script>



        <div class="logo-desktop d-flex align-items-center mb-3">
            <div class="me-3">
                <img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="Logo <?php echo $rec->nama_website ?>" height="50px">
              
            </div>
            <div class="kepala">
                <h4 class="mb-1">
                    <span class="header-title2"><?php echo ($rec->nama_website)." Makassar" ?>

                </a>
            </h4>
            <div class="font-13 text-success mb-2 text-truncate">
                <code><?php echo strtoupper($rec->meta_keyword." ") ?></code>
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
            <!-- <span class="header-title-top white-shadow-text"><?php echo $rec->nama_website ?></span> -->
            <span class="header-title-top white-shadow-text">SiLapas</span>
            <span class="header-title-bottom white-shadow-text">Kota Makassar</span>
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
