<?php if ($this->uri->segment(1) != 'on_login'): ?>
  <script>
    const thisUri = "<?= site_url($this->uri->uri_string()); ?>";

    function shareTo(platform) {
      const url = encodeURIComponent(thisUri); 
      const text = encodeURIComponent("<?= htmlspecialchars($rec->nama_website." ".$rec->kabupaten.". ".$title, ENT_QUOTES, 'UTF-8') ?>");


      let shareUrl = "";

      switch (platform) {
        case "whatsapp":
        shareUrl = `https://wa.me/?text=${text}%20${url}`;
        break;
        case "facebook":
        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
        break;
        case "twitter":
        shareUrl = `https://twitter.com/intent/tweet?text=${text}&url=${url}`;
        break;
        case "telegram":
        shareUrl = `https://t.me/share/url?url=${url}&text=${text}`;
        break;
        default:
        alert("Platform tidak didukung");
        return;
      }

      window.open(shareUrl, "_blank");
    }

  </script>

  <style type="text/css">
   .share-buttons {
    display: flex;
    align-items: center;
    justify-content: center; 
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
  }

/*  .share-buttons p {
    margin: 0;
    font-weight: bold;
    margin-right: 10px;
  }
  */
  .share-buttons button {
    display: flex;
    align-items: center;
    gap: 6px;
    /*padding: 8px 14px;*/
    border: none;
    border-radius: 6px;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s;
  }

  .btn-whatsapp { background-color: #25D366; }
  .btn-whatsapp:hover { background-color: #1ebe5b; }

  .btn-facebook { background-color: #3b5998; }
  .btn-facebook:hover { background-color: #334b86; }

  .btn-twitter { background-color: #1DA1F2; }
  .btn-twitter:hover { background-color: #198dd6; }

  .btn-telegram { background-color: #0088cc; }
  .btn-telegram:hover { background-color: #007ab8; }

  .share-buttons svg {
    width: 18px;
    height: 18px;
    fill: white;
  }
  .card-box-carbul {
    background: #fff;
    border-radius: 30px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
  }

</style>


<div class="container-fluid mb-5">
  <div class="row">
    <div class="col-12">
      <div class="card-box-carbul">
        <h3 class=" text-center"><strong><?php echo $rec->nama_website ?></strong></h3>
        <p class="boxed-text-l text-center mb-1">
          <?php echo $rec->meta_keyword ?>
        </p>
        <div class="text-center">
            Bagikan:
            <div class="share-buttons">
              <button class=" btn btn-whatsapp btn-xs" onclick="shareTo('whatsapp')">
                <svg viewBox="0 0 32 32"><path d="M16.003 2.002a14 14 0 00-12.081 20.9l-1.586 5.8 5.954-1.558A14 14 0 1016.003 2zM8.463 24.43l-.35.093.093-.338.618-2.25-.446-.65a11.798 11.798 0 112.007 2.043l-.648-.43-2.28.58.006.003zM23.4 19.7c-.33.93-1.62 1.722-2.215 1.837-.573.11-1.285.16-2.068-.127-.477-.17-1.09-.352-1.894-.692-3.326-1.436-5.514-4.84-5.685-5.07-.17-.23-1.36-1.813-1.36-3.455 0-1.642.86-2.45 1.168-2.788.307-.34.668-.42.89-.42.223 0 .445.002.64.01.206.01.483-.078.756.576.29.682.985 2.353 1.07 2.526.085.17.142.36.028.577-.11.217-.165.35-.33.54-.165.19-.35.43-.5.577-.17.17-.345.357-.15.707.2.352.893 1.47 1.915 2.38 1.317 1.17 2.426 1.537 2.776 1.708.35.17.552.15.755-.092.197-.23.855-.997 1.084-1.34.223-.34.447-.287.76-.17.312.118 1.98.935 2.317 1.102.337.17.56.24.642.37.086.124.086.716-.24 1.647z"/></svg>
                
              </button>

              <button class=" btn btn-facebook btn-xs" onclick="shareTo('facebook')">
                <svg viewBox="0 0 24 24"><path d="M22 12.073C22 6.505 17.523 2 12 2S2 6.505 2 12.073C2 17.096 5.656 21.158 10.438 22v-7.01h-3.14v-2.917h3.14V9.845c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.464.099 2.797.143v3.24l-1.92.001c-1.504 0-1.796.716-1.796 1.767v2.316h3.588l-.467 2.917h-3.12V22C18.344 21.158 22 17.096 22 12.073z"/></svg>
                
              </button>

              <button class="btn btn-twitter btn-xs" onclick="shareTo('twitter')">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0022.4 1.64a9.03 9.03 0 01-2.88 1.1 4.52 4.52 0 00-7.71 4.12A12.84 12.84 0 013 2.24a4.51 4.51 0 001.39 6.02 4.41 4.41 0 01-2.05-.56v.06a4.52 4.52 0 003.63 4.42 4.52 4.52 0 01-2.04.08 4.53 4.53 0 004.23 3.14A9.05 9.05 0 012 19.54a12.76 12.76 0 006.92 2.03c8.3 0 12.84-6.87 12.84-12.84 0-.2-.01-.39-.02-.58A9.22 9.22 0 0023 3z"/></svg>
                
              </button>

              <button class=" btn btn-telegram btn-xs" onclick="shareTo('telegram')">
                <svg viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.103 3.194 9.426 7.675 11.185.561.104.766-.243.766-.54 0-.266-.01-1.142-.015-2.072-3.124.681-3.787-1.507-3.787-1.507-.511-1.295-1.248-1.64-1.248-1.64-1.02-.698.077-.684.077-.684 1.127.079 1.72 1.158 1.72 1.158 1.003 1.718 2.63 1.222 3.272.934.103-.726.392-1.222.714-1.503-2.494-.284-5.115-1.247-5.115-5.548 0-1.225.438-2.228 1.157-3.014-.116-.285-.5-1.431.108-2.984 0 0 .94-.302 3.08 1.151A10.74 10.74 0 0112 6.845a10.77 10.77 0 012.808.377c2.14-1.453 3.08-1.151 3.08-1.151.609 1.553.225 2.699.11 2.984.72.786 1.156 1.789 1.156 3.014 0 4.31-2.625 5.26-5.126 5.538.403.345.763 1.023.763 2.06 0 1.488-.014 2.688-.014 3.053 0 .299.202.648.772.538A12.005 12.005 0 0024 12c0-6.628-5.373-12-12-12z"/></svg>
                
              </button>
            </div>
            <style type="text/css">
              .divider {
                border: 0;
                height: 1px;
                background-color: rgba(0, 0, 0, 0.05);
                margin: 20px 0;
                border-radius: 1px;
              }

            </style>
            <div class="divider mb-3"></div>
            <div class="row text-center mb-3 ">
              <a class="col-5" href="<?php echo site_url("hal/privacy_policy") ?>">Kebijakan Privasi</a>
              <a class="col-2" href="#topnav" onclick="scrollToTop()" aria-label="Kembali ke atas"><i class="fas fa-arrow-up" style="color: #4a81d4"></i></a>
              <a class="col-5" href="<?php echo site_url("hal/kontak") ?>">Kontak</a>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>

</div>

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

    width: 58px;
    height: 58px;
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
    0% { transform: scale(1) translateX(-50%) }
    50% { transform: scale(1.05) translateX(-48%) }
  }
  .modal-dialog.modal-bottom {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
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
  .modal-content-full,
  .modal-content {
    height: 100%;
    border-radius: 0;
    width: 100%;
    margin: 0;
  }
  .navbar-bottom .nav-item a:hover {
    color: #008000 !important;
  }
  .navbar-bottom .nav-item a:hover i,
  .navbar-bottom .nav-item a:hover span {
    color: #008000 !important;
  }

</style>

<nav class="navbar fixed-bottom navbar-light bg-white shadow-sm d-lg-none navbar-bottom px-0">
  <div class="w-100 d-flex justify-content-between text-center position-relative mx-0 px-0">
    <div class="nav-item">
      <a href="<?= base_url() ?>" class="<?= ($uri == '' || $uri == 'home') ? 'text-primary' : 'text-dark' ?>">
        <i class="fas fa-home d-block mb-1"></i>
        <span class="small">Beranda</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="<?= base_url('tracking') ?>" class="<?= ($uri == 'tracking') ? 'text-primary' : 'text-dark' ?>">
        <i class="fas fa-route d-block mb-1"></i>
        <span class="small">Tracking</span>
      </a>
    </div>

    <div class="space-left"></div>
    <div id="link-permohonan">
      <span class="spinner-grow text-danger"></span>
    </div>
    <div class="space-right"></div>

    <div class="nav-item">
      <a href="javascript:void(0)" class="<?= in_array($uri, ['hal/kontak', 'hal/kontak_capil', 'hal/alur']) ? 'text-primary' : 'text-dark' ?>" data-toggle="modal" data-target="#kontakModal">
        <i class="fas fa-briefcase d-block mb-1"></i>
        <span class="small">Layanan</span>
      </a>
    </div>

    <div class="nav-item" id="akun-section">
      <span class="spinner-grow text-danger"></span>
    </div>
  </div>
</nav>

<div class="modal" id="kontakModal" tabindex="-1" aria-labelledby="kontakModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-bottom fadeInUp animated modal-dialog-full" style="animation-duration: 0.5s;">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title d-flex align-items-center text-white">
          <i class="fas fa-concierge-bell mr-2 text-white"></i> Layanan
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $links = [
          ['hal/permohonan', 'fe-file-text', 'Syarat Permohonan'],
          ['hal/alur', 'mdi mdi-puzzle', 'Alur Permohonan'],
          ['hal/kontak_capil', 'fas fa-phone', 'Kontak Dukcapil'],
          ['hal/kontak', 'fas fa-mobile-alt', 'Kontak Desa & Dusun']
        ];
        foreach ($links as [$url, $icon, $label]) : ?>
          <a href="<?= base_url($url) ?>" style="text-decoration: none;">
            <div class="external-event text-dark" style="font-size: 16px; background: #c7d5ff; font-weight: 600; width: 100%;">
              <i class="<?= $icon ?> mr-1"></i><?= $label ?>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- <?php if ($this->uri->segment(1) != "on_login") : ?>
  <footer class="footer d-none d-md-block">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <a href="javascript:">PT. MVIN</a>
        </div>
      </div>
    </div>
  </footer>
<?php endif; ?> -->

<script src="<?= base_url('assets/admin/js/vendor.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/app.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>
<script>
  const base_url = "<?= base_url() ?>";

  document.addEventListener("DOMContentLoaded", function () {
    fetch(base_url + "api/get_link_permohonan")
    .then(res => res.ok ? res.text() : Promise.reject("Gagal mengambil data."))
    .then(html => {
      document.getElementById('link-permohonan').innerHTML = html;
    })
    .catch(() => {
      document.getElementById('link-permohonan').innerHTML = `
      <a href="<?= base_url('booking') ?>"
      class="center-button <?= ($uri == 'booking') ? 'text-white' : '' ?>"
      style="text-align: center; <?= ($uri == 'booking') ? 'background-color: #28a745;' : '' ?>">
      <img src="<?= base_url('assets/images/logo.png') ?>" alt="Permohonan"
      style="width: 50px; height: 50px; object-fit: contain; margin-top: 0px;">
      </a>
      `;
    });


    fetch(base_url + "api/check_login")
    .then(res => res.json())
    .then(data => {
      const el = document.getElementById('akun-section');
      const adminLevel = "<?= $this->session->userdata('admin_level') ?>";
    const base_url = "<?= base_url() ?>";

    const isAdmin = data.is_admin;
    const path = window.location.pathname;

    const linkHref = adminLevel === 'faskes'
      ? base_url + 'admin_permohonan/detail_paket/paket_u'
      : base_url + (isAdmin ? 'admin_dashboard' : 'on_login');

    const isActive = path.includes(
      adminLevel === 'faskes'
        ? 'admin_permohonan/detail_paket/paket_u'
        : (isAdmin ? 'admin_dashboard' : 'on_login')
    );

    const linkText = adminLevel === 'faskes'
      ? 'Faskes'
      : (isAdmin ? 'Akun' : 'Login');
      if (!el) return;
      el.innerHTML = `
      <a href="${linkHref}" class="${isActive ? 'text-primary' : 'text-dark'}">
      <i class="fas fa-user d-block mb-1"></i>
      <span class="small">${linkText}</span>
      </a>`;
    })
    .catch(() => {
      const el = document.getElementById('akun-section');
      if (el) el.innerHTML = `
        <a href="<?= base_url('on_login') ?>" class="<?= ($uri == 'on_login') ? 'text-primary' : 'text-dark' ?>">
      <i class="fas fa-user d-block mb-1"></i>
      <span class="small">Login</span>
      </a>
      `;
    });
  });

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>
<?php if ($this->session->userdata("admin_login")): ?>
  <script src="<?= base_url('assets/js/notifikasi.js?v=1.3') ?>"></script>
<?php endif; ?>

</body>
</html>