<!DOCTYPE html>
<html lang="id">
<head>
  <!-- ========== META DASAR ========== -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">

  <!-- JANGAN DIINDEX GOOGLE -->
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <meta name="googlebot" content="noindex, nofollow, noimageindex">
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

  <?php $canon = preg_replace('#^http:#','https:', current_url()); ?>
  <link rel="canonical" href="<?= htmlspecialchars($canon, ENT_QUOTES, 'UTF-8') ?>">

  <!-- ========== PWA / ICONS ========== -->
  <link rel="manifest" href="<?= site_url('developer/manifest') ?>?v=7">
  <link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon" />

  <!-- ========== CSS VENDOR ========== -->
  <link href="<?= base_url('assets/admin/css/bootstrap.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/admin/css/icons.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/admin/css/app.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/admin/libs/animate/animate.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/min/kamar.min.css'); ?>" rel="stylesheet" />

  <!-- ========== CSS KUSTOM (DIKELOMPOKKAN) ========== -->


</head>

<?php $this->load->view("global") ?> 

<body class="menubar-gradient gradient-topbar topbar-dark">
<header id="topnav">
  <div class="navbar-custom kamar-navbar">
    <div class="container-fluid">
      <div class="topbar-inner d-flex align-items-center justify-content-between">

        <!-- KIRI: Judul -->
        <div class="topbar-title-group">
         <!--  <span class="topbar-label">
            Kamar Tahanan
          </span> -->
          <h4 class="mb-0">
            <span class="topbar-title-text">
              <?= 'Kamar '.html_escape($kamar->nama); ?>
            </span>
          </h4>
          <span class="topbar-subtitle d-md-none">
            Data WBP <?php echo $rec->type ?>
          </span>
        </div>

        <!-- KANAN: Badge kecil / info QR (optional) -->
        <ul class="list-unstyled topnav-menu mb-0" id="topnav-right">
          <li class="d-none d-md-inline-block">
            <span class="topbar-badge">
              <i class="fe-smartphone"></i>
              Scan QR Kamar
            </span>
          </li>
        </ul>

      </div><!-- /.topbar-inner -->
    </div>
  </div>

  <div class="topbar-menu">
    <div class="container-fluid"></div>
  </div>
</header>


<style type="text/css">
#app-scroll {
  height: 100%;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  overscroll-behavior: contain;
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

<?php
// helper tanggal singkat
if (!function_exists('tgl_indo_singkat')) {
  function tgl_indo_singkat($tgl){
      if(!$tgl || $tgl === '0000-00-00') return '';
      $bulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Des'];
      $ts = strtotime($tgl);
      if (!$ts) return '';
      $b  = (int)date('n',$ts);
      return date('d',$ts).' '.$bulan[$b].' '.date('Y',$ts);
  }
}
?>

<div class="container-fluid">
  <div id="preloader">
    <div id="status">
      <div class="image-container animated flip infinite">
        <img src="<?= base_url('assets/images/').$rec->gambar ?>"
             alt="Foto" style="display:none;" onload="this.style.display='block';" />
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-lg-12">
      <div class="card-box">

        <div class="kamar-header">
  <div class="kamar-header-main">
    <div class="kamar-chip mb-2">
      <span class="kamar-chip-icon">
        <i class="fe-lock"></i>
      </span>
      <span class="kamar-chip-text">Informasi Kamar</span>
    </div>

    <h3 class="kamar-title mb-1">
      Data Kamar WBP
    </h3>

    <div class="kamar-meta">
      <span class="kamar-meta-item">
        <i class="fe-hash kamar-meta-icon"></i>
        <?= html_escape($kamar->nama); ?>
      </span>

      <?php if (!empty($kamar->blok)): ?>
        <span class="kamar-meta-separator">•</span>
        <span class="kamar-meta-item">
          <i class="fe-grid kamar-meta-icon"></i>
          Blok: <?= html_escape($kamar->blok); ?>
        </span>
      <?php endif; ?>

      <?php if (!empty($kamar->lantai)): ?>
        <span class="kamar-meta-separator">•</span>
        <span class="kamar-meta-item">
          <i class="fe-layers kamar-meta-icon"></i>
          Lantai: <?= html_escape($kamar->lantai); ?>
        </span>
      <?php endif; ?>
    </div>
  </div>

  <div class="kamar-header-stats text-md-right">
    <?php $kapasitas = (int)($kamar->kapasitas ?? 0); ?>
    <?php if ($kapasitas > 0): ?>
      <div class="kamar-stat">
        <div class="kamar-stat-label">Kapasitas</div>
        <div class="kamar-stat-value">
          <i class="fe-users kamar-stat-icon"></i>
          <?= $kapasitas; ?> Orang
        </div>
      </div>
    <?php endif; ?>

    <div class="kamar-stat">
      <div class="kamar-stat-label">Total WBP</div>
      <div class="kamar-stat-value kamar-stat-badge">
        <i class="fe-user-check kamar-stat-icon"></i>
        <?= count($tahanan); ?>
      </div>
    </div>
  </div>
</div>


        <hr>

        <?php if (empty($tahanan)): ?>
          <div class="alert alert-light kamar-empty d-flex align-items-center" role="alert">
            <span class="kamar-empty-icon">
              <i class="fe-info"></i>
            </span>
            <div>
              Belum ada data tahanan yang tercatat pada kamar ini.
            </div>
          </div>
        <?php else: ?>

          <div class="tahanan-list">
            <?php foreach($tahanan as $t): ?>
              <?php
                // STATUS
                $status = strtolower((string)($t->status ?? ''));
                $badgeClass = 'badge-status-lainnya';
                $labelStatus = '';
                if ($status !== '') {
                  $labelStatus = ucfirst($status);
                  if ($status === 'aktif')  $badgeClass = 'badge-status-aktif';
                  if ($status === 'bebas')  $badgeClass = 'badge-status-bebas';
                  if ($status === 'pindah') $badgeClass = 'badge-status-pindah';
                }

                // JK & lahir
                $jkLabel = '';
                if (!empty($t->jenis_kelamin)) {
                  $jkLabel = $t->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
                }

                $lahirText = '';
                if (!empty($t->tempat_lahir) || (!empty($t->tanggal_lahir) && $t->tanggal_lahir !== '0000-00-00')) {
                  if (!empty($t->tempat_lahir)) {
                    $lahirText .= html_escape($t->tempat_lahir);
                  }
                  $tglLahirShort = tgl_indo_singkat($t->tanggal_lahir ?? '');
                  if ($tglLahirShort) {
                    $lahirText .= ($lahirText ? ', ' : '').$tglLahirShort;
                  }
                }

                $noReg   = trim((string)($t->no_reg ?? ''));
                $foto    = !empty($t->foto) ? base_url('uploads/kamar_tahanan/'.rawurlencode($t->foto)) : null;

                // PUTUSAN
                $pt_t = (int)($t->putusan_tahun ?? 0);
                $pt_b = (int)($t->putusan_bulan ?? 0);
                $pt_h = (int)($t->putusan_hari ?? 0);
                $pt_parts = [];
                if ($pt_t > 0) $pt_parts[] = $pt_t.' th';
                if ($pt_b > 0) $pt_parts[] = $pt_b.' bln';
                if ($pt_h > 0) $pt_parts[] = $pt_h.' hr';
                $putusan_text = !empty($pt_parts) ? implode(' ', $pt_parts) : '';

                // EXPIRASI
                $exp_text = '';
                if (!empty($t->expirasi) && $t->expirasi !== '0000-00-00') {
                  $expShort = tgl_indo_singkat($t->expirasi);
                  if ($expShort) $exp_text = $expShort;
                }

                $perkara   = trim((string)($t->perkara ?? ''));
                $alamat    = trim((string)($t->alamat ?? ''));
                $catatan   = isset($t->catatan) ? trim((string)$t->catatan) : '';
                $deskripsi = trim((string)($t->deskripsi ?? ''));

                // ada konten tambahan?
                $has_extra = $labelStatus || $jkLabel || $lahirText || $alamat || $catatan || $deskripsi;
              ?>

              <div class="card tahanan-card">
                <div class="card-body">
                  <!-- FOTO + NAMA -->
                  <div class="tahanan-avatar">
                    <?php if ($foto): ?>
                      <img src="<?= $foto; ?>" alt="Foto <?= html_escape($t->nama); ?>">
                    <?php else: ?>
                      <div class="tahanan-avatar-placeholder">
                        <i class="fe-user"></i>
                      </div>
                    <?php endif; ?>

                    <div class="tahanan-main d-block d-md-none">
                      <div class="tahanan-name">
                        <?= html_escape($t->nama); ?>
                      </div>
                    </div>
                  </div>

                  <div class="tahanan-main">
                    <!-- NAMA (desktop) -->
                    <div class="tahanan-name d-none d-md-block">
                      <?= html_escape($t->nama); ?>
                    </div>

                    <!-- NO.REG (jika ada) -->
                    <?php if ($noReg): ?>
                    <div class="mb-2 tahanan-field">
                      <small>No.Reg</small>
                      <?= html_escape($noReg); ?>
                    </div>
                    <?php endif; ?>

                    <!-- PERKARA -->
                    <?php if ($perkara): ?>
                    <div class="mb-2 tahanan-field">
                      <small>Perkara</small>
                      <?= html_escape($perkara); ?>
                    </div>
                    <?php endif; ?>

                    <!-- PUTUSAN -->
                    <?php if ($putusan_text): ?>
                    <div class="mb-2 tahanan-field">
                      <small>Putusan</small>
                      <?= $putusan_text; ?>
                    </div>
                    <?php endif; ?>

                    <!-- EXPIRASI -->
                    <?php if ($exp_text): ?>
                    <div class="mb-2 tahanan-field">
                      <small>Expirasi</small>
                      <?= $exp_text; ?>
                    </div>
                    <?php endif; ?>

                    <!-- TOMBOL SELENGKAPNYA (SELALU DI SINI, DI BAWAH EXPIRASI) -->
                    <?php if ($has_extra): ?>
                      <div class="mb-2 tahanan-toggle-wrap">
                        <button type="button" class="tahanan-toggle-btn">
                          <span class="tahanan-toggle-text">Selengkapnya</span>
                          <span class="tahanan-toggle-icon">▼</span>
                        </button>
                      </div>

                      <!-- KONTEN EXTRA DENGAN ANIMASI -->
                      <div class="mb-2 tahanan-extra">
                        <?php if ($labelStatus): ?>
                        <div class="mb-2 tahanan-field">
                          <small>Status</small>
                          <span class="badge-status <?= $badgeClass; ?>">
                            <?= $labelStatus; ?>
                          </span>
                        </div>
                        <?php endif; ?>

                        <?php if ($jkLabel): ?>
                        <div class="mb-2 tahanan-field">
                          <small>Jenis kelamin</small>
                          <?= $jkLabel; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($lahirText): ?>
                        <div class="mb-2 tahanan-field">
                          <small>Tempat & Tgl Lahir</small>
                          <?= $lahirText; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($alamat): ?>
                        <div class="mb-2 tahanan-field">
                          <small>Alamat</small>
                          <?= nl2br(html_escape($alamat)); ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($catatan): ?>
                        <div class="mb-2 tahanan-field">
                          <small>Catatan</small>
                          <?= nl2br(html_escape($catatan)); ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($deskripsi): ?>
                        <div class="mb-2 tahanan-field">
                          <small>Deskripsi</small>
                          <?= nl2br(html_escape($deskripsi)); ?>
                        </div>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>

                  </div>
                </div>
              </div>

            <?php endforeach; ?>

          </div>

        <?php endif; ?>

        <div class="text-center mt-3">
          <small class="text-muted">
            Halaman ini diakses melalui pemindaian QR Kamar.<br>
            <!-- Token: <code><?= html_escape($kamar->qr_token); ?></code> -->
          </small>
        </div>

      </div><!-- /.card-box -->
    </div>
  </div>
</div>

</div><!-- /#app-scroll -->

<script src="<?= base_url('assets/admin/js/vendor.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/app.min.js') ?>"></script>

<script>
// Toggle "Selengkapnya" + animasi pelan (tombol tetap di bawah Expirasi)
document.addEventListener('click', function(e){
  var btn = e.target.closest('.tahanan-toggle-btn');
  if (!btn) return;

  e.preventDefault();
  var card = btn.closest('.tahanan-card');
  if (!card) return;

  var extra = card.querySelector('.tahanan-extra');
  if (!extra) return;

  var isShown = extra.classList.contains('is-open');
  var txt = btn.querySelector('.tahanan-toggle-text');
  var icon = btn.querySelector('.tahanan-toggle-icon');

  if (!isShown){
    extra.classList.add('is-open');
    if (txt) txt.textContent = 'Tutup';
    if (icon) icon.textContent = '▲';
  } else {
    extra.classList.remove('is-open');
    if (txt) txt.textContent = 'Selengkapnya';
    if (icon) icon.textContent = '▼';
  }
});
</script>
</body>
</html>
