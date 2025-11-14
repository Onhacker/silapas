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

  <!-- ========== CSS KUSTOM (DIKELOMPOKKAN) ========== -->
  <link href="<?= base_url('assets/min/head.min.css'); ?>" rel="stylesheet" />

  <style>
  :root{
    --hdr-bg1:#0d2d58;
    --hdr-bg2:#184c8a;
    --hdr-accent:#f59e0b;
    --hdr-text:#fff;
    --hdr-muted:#dbe7ff;
    --hdr-shadow:0 12px 30px rgba(0,0,0,.22);
    --safe-top: env(safe-area-inset-top);
  }

  #topnav .navbar-custom{
    background:rgba(8,25,55,.45) !important;
    backdrop-filter:saturate(150%) blur(8px);
    border-bottom:1px solid rgba(255,255,255,.08);
  }

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
  .header-title2::after{
    content:""; display:block; height:3px; width:132px;
    margin-top:.1rem; background:var(--hdr-accent);
    border-radius:999px; box-shadow:0 2px 10px rgba(245,158,11,.5);
  }
  .logo-desktop code{
    display:inline-block; color:var(--hdr-muted);
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.14);
    padding:.25rem .5rem; border-radius:999px;
    font-size:.82rem; font-weight:600;
  }

  .logo-boxx{
    padding:.25rem 0 .5rem;
  }
  .logox{
    display:flex; align-items:center; gap:.75rem;
  }
  .logo-smx img{
    height:40px; width:auto;
    border-radius:10px;
    background:rgba(255,255,255,.08);
    padding:3px;
  }
  .logo-text{
    display:flex; flex-direction:column;
  }
  .header-title-top{
    font-weight:700; font-size:1rem;
  }
  .header-title-bottom{
    font-size:.8rem; opacity:.8;
  }
  .white-shadow-text{
    color:#fff; text-shadow:0 1px 4px rgba(0,0,0,.6);
  }

  .kamar-header{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:1rem;
    flex-wrap:wrap;
  }
  .kamar-title{
    margin-bottom:.25rem;
  }
  .kamar-meta{
    font-size:.85rem;
    color:#6c757d;
  }
  .kamar-summary{
    margin-top:.35rem;
    font-size:.84rem;
    color:#6c757d;
  }
  .kamar-summary span{
    margin-right:1rem;
  }
  .kamar-badge{
    font-size:.8rem;
  }
  .kamar-empty{
    border-style:dashed !important;
    font-size:.9rem;
  }
  .kamar-empty-icon{
    font-size:1.3rem;
    line-height:1;
    margin-right:.5rem;
  }

  .tahanan-list{
    margin-top:.75rem;
  }

  /* ========== STRIPED ROWS UNTUK SETIAP TAHANAN ========== */
  .tahanan-card{
    border-radius:0;
    border:0;
    margin-bottom:0;
    box-shadow:none;
    background:transparent;
  }
  .tahanan-card .card-body{
    padding:.85rem .75rem .8rem;
    border-bottom:1px solid rgba(148,163,184,.35);
    display:flex;
    flex-direction:column;
  }
  /* striping selang-seling */
  .tahanan-card:nth-of-type(odd) .card-body{
    background:linear-gradient(90deg,#f9fafb,#eff6ff);
  }
  .tahanan-card:nth-of-type(even) .card-body{
    background:linear-gradient(90deg,#ffffff,#f9fafb);
  }

  .tahanan-avatar{
    margin:0 0 .6rem;
    display:flex;
    align-items:center;
    justify-content:flex-start;
    gap:.75rem;
  }
  .tahanan-avatar img,
  .tahanan-avatar-placeholder{
    width:56px;
    height:56px;
    border-radius:999px;
    object-fit:cover;
  }
  .tahanan-avatar img{
    border:2px solid rgba(15,23,42,.18);
    box-shadow:0 2px 6px rgba(15,23,42,.18);
    background:#fff;
  }
  .tahanan-avatar-placeholder{
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#e5e7eb,#cbd5f5);
    border:2px solid rgba(148,163,184,.6);
    color:#4b5563;
    font-size:1.2rem;
  }

  .tahanan-main{
    flex:1 1 auto;
    min-width:0;
  }

  .tahanan-name{
    font-size:1rem;
    font-weight:700;
    margin-bottom:.35rem;
  }

  .tahanan-field{
    font-size:.875rem;
    margin-top:.25rem;
    padding:.25rem .55rem;
    border-radius:.4rem;
  }
  .tahanan-field small{
    display:block;
    text-transform:uppercase;
    letter-spacing:.04em;
    font-size:.7rem;
    color:#6b7280;
    margin-bottom:.1rem;
  }
  /* striping halus di dalam satu tahanan (label/value) */
  .tahanan-main .tahanan-field:nth-of-type(odd){
    background:rgba(148,163,184,.10);
  }
  .tahanan-main .tahanan-field:nth-of-type(even){
    background:rgba(148,163,184,.05);
  }

  .badge-status-aktif{
    background:linear-gradient(135deg,#16a34a,#22c55e);
    color:#ecfdf3;
  }
  .badge-status-bebas{
    background:linear-gradient(135deg,#2563eb,#38bdf8);
    color:#eff6ff;
  }
  .badge-status-pindah{
    background:linear-gradient(135deg,#f97316,#facc15);
    color:#fffbeb;
  }
  .badge-status-lainnya{
    background:linear-gradient(135deg,#6b7280,#9ca3af);
    color:#f9fafb;
  }

  .badge-status{
    border-radius:999px;
    padding:.15rem .6rem;
    font-size:.7rem;
    font-weight:600;
    box-shadow:0 2px 6px rgba(15,23,42,.25);
    white-space:nowrap;
  }

  /* WRAP tombol selengkapnya: tetap di bawah Expirasi, rata kanan */
  .tahanan-toggle-wrap{
    margin-top:.45rem;
    display:flex;
    justify-content:flex-end;
  }

  .tahanan-toggle-btn{
    font-size:.8rem;
    padding:.2rem .7rem;
    border-radius:999px;
    border:0;
    background:rgba(37,99,235,.08);
    color:#2563eb;
    display:inline-flex;
    align-items:center;
    font-weight:600;
    cursor:pointer;
    white-space:nowrap;
  }
  .tahanan-toggle-btn:focus{
    outline:none;
    box-shadow:0 0 0 2px rgba(37,99,235,.3);
  }
  .tahanan-toggle-icon{
    font-size:.85rem;
    line-height:1;
    margin-left:.25rem;
  }

  /* Konten selengkapnya dengan animasi pelan (buka/tutup) */
  .tahanan-extra{
    margin-top:.35rem;
    padding-top:.4rem;
    font-size:.82rem;
    max-height:0;
    opacity:0;
    overflow:hidden;
    border-top:1px dashed transparent;
    transition:max-height .55s ease, opacity .55s ease, border-color .55s ease;
  }
  .tahanan-extra.is-open{
    max-height:900px;
    opacity:1;
    border-top-color:rgba(148,163,184,.6);
  }

  @media (min-width: 768px){
    .tahanan-card .card-body{
      padding:.9rem 1rem .9rem;
      flex-direction:row;
      align-items:flex-start;
      gap:1rem;
    }
    .tahanan-avatar{
      margin:0;
      flex-direction:column;
      align-items:center;
      justify-content:flex-start;
      min-width:80px;
    }
    .tahanan-avatar img,
    .tahanan-avatar-placeholder{
      width:72px;
      height:72px;
    }
    .tahanan-name{
      font-size:1.05rem;
    }
  }
  .kamar-header{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:1.25rem;
  flex-wrap:wrap;
  padding:1rem 1rem 1.05rem;
  border-radius:1rem;
  background:linear-gradient(135deg,#eef2ff,#eff6ff);
  border:1px solid rgba(148,163,184,.55);
  position:relative;
  overflow:hidden;
}

/* efek glow sudut kanan bawah */
.kamar-header::before{
  content:"";
  position:absolute;
  right:-40px;
  bottom:-40px;
  width:150px;
  height:150px;
  background:radial-gradient(circle at center,rgba(37,99,235,.20),transparent 70%);
}

/* sisi kiri (judul + info kamar) */
.kamar-header-main{
  position:relative;
  z-index:1;
  min-width:0;
}

/* chip kecil di atas judul */
.kamar-chip{
  display:inline-flex;
  align-items:center;
  padding:.18rem .6rem;
  border-radius:999px;
  background:rgba(37,99,235,.07);
  border:1px solid rgba(129,140,248,.5);
  font-size:.72rem;
  font-weight:600;
  text-transform:uppercase;
  letter-spacing:.06em;
  color:#1d4ed8;
}
.kamar-chip-icon{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  font-size:.8rem;
  margin-right:.3rem;
}

/* judul besar */
.kamar-title{
  font-weight:700;
  color:#111827;
  display:flex;
  align-items:center;
  gap:.4rem;
}
.kamar-title::after{
  content:"";
  flex:0 0 46px;
  height:3px;
  border-radius:999px;
  background:linear-gradient(90deg,#6366f1,#f97316);
  opacity:.9;
}

/* meta: nama kamar, blok, lantai */
.kamar-meta{
  margin-top:.45rem;
  font-size:.85rem;
  color:#4b5563;
  display:flex;
  flex-wrap:wrap;
  gap:.35rem;
  align-items:center;
}
.kamar-meta-item{
  display:inline-flex;
  align-items:center;
  gap:.25rem;
}
.kamar-meta-icon{
  font-size:.9rem;
  color:#6366f1;
}
.kamar-meta-separator{
  opacity:.6;
}

/* sisi kanan (statistik kecil) */
.kamar-header-stats{
  position:relative;
  z-index:1;
  display:flex;
  flex-direction:column;
  gap:.3rem;
  min-width:160px;
}
.kamar-stat{
  font-size:.8rem;
}
.kamar-stat-label{
  text-transform:uppercase;
  letter-spacing:.06em;
  font-weight:600;
  color:#6b7280;
}
.kamar-stat-value{
  margin-top:.05rem;
  font-size:.9rem;
  font-weight:600;
  display:inline-flex;
  align-items:center;
  gap:.3rem;
  color:#111827;
}
.kamar-stat-icon{
  font-size:.95rem;
  opacity:.8;
}
.kamar-stat-badge{
  padding:.15rem .65rem;
  border-radius:999px;
  background:rgba(22,163,74,.06);
  color:#166534;
}

/* responsif */
@media (max-width: 575.98px){
  .kamar-header{
    padding:.8rem .85rem .95rem;
  }
  .kamar-header-stats{
    width:100%;
    flex-direction:row;
    justify-content:flex-start;
    gap:.75rem;
    margin-top:.35rem;
  }
}
/* Navbar khusus halaman kamar */
.kamar-navbar{
  background:radial-gradient(circle at 0% 0%,rgba(59,130,246,.45),transparent 55%),
              radial-gradient(circle at 100% 0%,rgba(236,72,153,.35),transparent 55%),
              rgba(8,25,55,.96) !important;
  backdrop-filter:saturate(150%) blur(10px);
  border-bottom:1px solid rgba(148,163,184,.45);
}

.topbar-inner{
  min-height:64px;
  padding-top:.35rem;
  padding-bottom:.35rem;
}

/* Kiri: group judul */
.topbar-title-group{
  display:flex;
  flex-direction:column;
  align-items:flex-start;
  gap:.1rem;
}

/* label kecil di atas judul */
.topbar-label{
  font-size:.72rem;
  text-transform:uppercase;
  letter-spacing:.12em;
  color:rgba(226,232,240,.9);
  font-weight:600;
}

/* judul kamar */
.topbar-title-text{
  display:inline-block;
  color:#f9fafb;
  font-weight:700;
  letter-spacing:.3px;
  text-transform:uppercase;
  text-shadow:0 2px 8px rgba(0,0,0,.35);
  position:relative;
}

/* garis kecil di bawah judul */
.topbar-title-text::after{
  content:"";
  display:block;
  height:3px;
  width:120px;
  margin-top:.16rem;
  background:linear-gradient(90deg,#38bdf8,#f97316);
  border-radius:999px;
  box-shadow:0 2px 10px rgba(248,250,252,.45);
}

/* subtitle mobile */
.topbar-subtitle{
  font-size:.78rem;
  color:rgba(226,232,240,.85);
}

/* badge di kanan (desktop) */
.topbar-badge{
  display:inline-flex;
  align-items:center;
  gap:.35rem;
  padding:.25rem .75rem;
  border-radius:999px;
  font-size:.78rem;
  font-weight:600;
  color:#e5e7eb;
  background:rgba(15,23,42,.6);
  border:1px solid rgba(148,163,184,.6);
  box-shadow:0 3px 10px rgba(15,23,42,.75);
  white-space:nowrap;
}
.topbar-badge i{
  font-size:.9rem;
}

/* mobile */
@media (max-width: 767.98px){
  .topbar-inner{
    min-height:56px;
    padding-top:.25rem;
    padding-bottom:.25rem;
  }
  .topbar-badge{
    display:none;
  }
}

  </style>

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
            Data Tahanan <?php echo $rec->type ?>
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
      Data Kamar Tahanan
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
      <div class="kamar-stat-label">Total Tahanan</div>
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
            Token: <code><?= html_escape($kamar->qr_token); ?></code>
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
