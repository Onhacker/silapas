<?php
// kontak_view.php
$this->load->view("front_end/head.php");

// ===== Data profil (fallback aman) =====
$rec  = isset($rec) ? $rec : (object)[];
$title_page = $title ?? 'Kontak';
$site_name  = $rec->nama_website ?? 'Lapas Kelas I Makassar';
$nama       = htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8');

$alamat_raw = trim((string)($rec->alamat ?? '-'));
$alamat     = htmlspecialchars($alamat_raw, ENT_QUOTES, 'UTF-8');

$telp_raw   = trim((string)($rec->no_telp ?? ($rec->telepon ?? '')));
$telp_disp  = htmlspecialchars($telp_raw, ENT_QUOTES, 'UTF-8');

$email_raw  = trim((string)($rec->email ?? ''));
$email_disp = htmlspecialchars($email_raw !== '' ? $email_raw : '-', ENT_QUOTES, 'UTF-8');

$wa_raw     = trim((string)($rec->no_wa ?? ($rec->wa ?? $telp_raw)));

// Jam kerja: izinkan <br> saja
$jam_default = "Senin - Kamis: 08.00 - 15.00<br>Jumat: 08.00 - 14.00<br>Sabtu: 08.00 - 11.30 WITA";
$jam_raw     = (string)($rec->jam_kerja ?? $jam_default);
$jam_html    = strip_tags($jam_raw, '<br><br/>');

// Link Google Maps (bebas: shortlink/long)
$map_link_raw = trim((string)($rec->map ?? ''));

// ===== Helper =====
function norm_wa_id($n){
  $d = preg_replace('/\D+/', '', (string)$n);
  if ($d === '') return '';
  if (strpos($d, '62') === 0) return $d;
  if ($d[0] === '0') return '62'.substr($d,1);
  return $d;
}
$wa_norm = norm_wa_id($wa_raw);

// Buat URL embed dari link map (fallback q=alamat/nama)
if ($map_link_raw !== '') {
  if (strpos($map_link_raw, 'google.com/maps') !== false) {
    $embed_src = $map_link_raw.(strpos($map_link_raw,'?')!==false ? '&' : '?').'output=embed';
  } else {
    // shortlink (maps.app.goo.gl / goo.gl/maps) → pakai q=
    $embed_src = 'https://www.google.com/maps?q='.rawurlencode($alamat_raw ?: $site_name).'&output=embed';
  }
} else {
  $embed_src = 'https://www.google.com/maps?q='.rawurlencode($alamat_raw ?: $site_name).'&output=embed';
}
$maps_open_url = $map_link_raw !== '' ? $map_link_raw : ('https://www.google.com/maps/search/?api=1&query='.rawurlencode($alamat_raw ?: $site_name));

// Deskripsi opsional
$deskripsi = isset($deskripsi) ? htmlspecialchars($deskripsi, ENT_QUOTES, 'UTF-8') : '';
?>
<style>
  /* ===== Styling halaman kontak ===== */
  .contact-hero{
    background: linear-gradient(135deg,#f8fafc 0%, #eef2ff 100%);
    border:1px solid #eef0f3; border-radius:16px
  }
  .contact-card{border:1px solid #eef0f3; border-radius:14px; box-shadow:0 6px 18px rgba(0,0,0,.06)}
  .icon-pill{
    width:44px; height:44px; border-radius:999px; display:inline-flex;
    align-items:center; justify-content:center; background:#f1f5f9; margin-right:.7rem
  }
  .icon-pill i{font-size:20px}
  .btn-wa{background:#25D366; color:#fff; border:none}
  .btn-wa:hover{filter:brightness(.95); color:#fff}
  .btn-soft{background:#f8fafc; border:1px solid #e5e7eb}
  .form-note{font-size:.875rem; color:#64748b}
  .contact-badges .badge{font-size:.85rem}

  /* Map responsive */
  .map-wrap{border:1px solid #eef0f3; border-radius:14px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,.05)}
  .map-ratio{
    position:relative; width:100%;
    /* gunakan aspect-ratio bila tersedia, fallback ke padding-top */
    aspect-ratio: 16 / 10;
  }
  @supports not (aspect-ratio: 1) {
    .map-ratio::before{content:""; display:block; padding-top:62.5%;}
  }
  .map-ratio iframe{
    position:absolute; inset:0; width:100%; height:100%; border:0;
  }

  /* List info */
  .info-item + .info-item{ margin-top:1rem; }

  /* Kecilkan jarak di mobile */
  @media (max-width: 575.98px){
    .contact-hero .btn{width:100%}
  }
</style>

<div class="container-fluid">
  <!-- Page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><?= htmlspecialchars($title_page, ENT_QUOTES, 'UTF-8') ?></li>
            <li class="breadcrumb-item active">Hubungi Kami</li>
          </ol>
        </div>
        <h4 class="page-title">Kontak</h4>
      </div>
    </div>
  </div>

  <!-- Hero -->
  <div class="row">
    <div class="col-12">
      <div class="contact-hero p-3 p-md-4 mb-3">
        <div class="d-md-flex align-items-center justify-content-between">
          <div class="mr-md-3">
            <h3 class="mb-1">Kontak <?= $nama ?></h3>
            <?php if ($deskripsi): ?>
              <p class="text-dark mb-2"><?= $deskripsi ?></p>
            <?php endif; ?>
            <div class="contact-badges">
              <span class="badge badge-light border"><i class="mdi mdi-clock-outline"></i> <?= $jam_html ?></span>
              <?php if ($email_disp && $email_disp !== '-'): ?>
                <span class="badge badge-info ml-1"><i class="mdi mdi-email-outline"></i> <?= $email_disp ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="mt-2 mt-md-0">
            <?php if ($wa_norm): ?>
              <a class="btn btn-wa btn-lg shadow-sm"
                 target="_blank" rel="noopener"
                 href="https://wa.me/<?= $wa_norm ?>?text=Halo%20<?= rawurlencode($site_name) ?>,%20saya%20ingin%20bertanya.">
                <i class="mdi mdi-whatsapp"></i> Chat WhatsApp
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Konten -->
  <div class="row">
    <!-- Kiri: Info + Form compose WA -->
    <div class="col-lg-6">
      <div class="card contact-card">
        <div class="card-body">
          <h5 class="mb-3">Informasi Kontak</h5>

          <div class="info-item d-flex align-items-start">
            <span class="icon-pill bg-soft-primary text-primary"><i class="mdi mdi-office-building"></i></span>
            <div>
              <div class="font-weight-bold">Alamat</div>
              <div class="text-muted"><?= $alamat ?></div>
            </div>
          </div>

          <?php if ($telp_disp && $telp_disp !== '-'): ?>
          <div class="info-item d-flex align-items-start">
            <span class="icon-pill bg-soft-info text-info"><i class="mdi mdi-phone"></i></span>
            <div>
              <div class="font-weight-bold">Telepon</div>
              <div class="text-muted">
                <a href="tel:<?= htmlspecialchars($telp_raw, ENT_QUOTES, 'UTF-8') ?>"><?= $telp_disp ?></a>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if ($email_disp && $email_disp !== '-'): ?>
          <div class="info-item d-flex align-items-start">
            <span class="icon-pill bg-soft-success text-success"><i class="mdi mdi-email"></i></span>
            <div>
              <div class="font-weight-bold">Email</div>
              <div class="text-muted">
                <a href="mailto:<?= htmlspecialchars($email_raw, ENT_QUOTES, 'UTF-8') ?>"><?= $email_disp ?></a>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <hr class="my-4">

          <h6 class="mb-2">Tulis Pesan Cepat (WhatsApp)</h6>
          <form id="formKontak" onsubmit="return false;">
            <div class="form-group">
              <label for="fNama">Nama</label>
              <input id="fNama" type="text" name="nama" class="form-control" placeholder="Nama Anda">
            </div>
            <div class="form-group">
              <label for="fSubjek">Subjek</label>
              <input id="fSubjek" type="text" name="subjek" class="form-control" placeholder="Judul/Pokok pesan">
            </div>
            <div class="form-group">
              <label for="fPesan">Pesan</label>
              <textarea id="fPesan" name="pesan" rows="4" class="form-control" placeholder="Tulis pertanyaan atau kebutuhan Anda"></textarea>
              <div class="form-note mt-1">Klik tombol WhatsApp untuk mengirim pesan ke admin.</div>
            </div>

            <?php if ($wa_norm): ?>
              <a id="btnWaForm" class="btn btn-wa btn-block">
                <i class="mdi mdi-whatsapp"></i> Kirim via WhatsApp
              </a>
            <?php else: ?>
              <div class="alert alert-warning mt-2 mb-0">
                Nomor WhatsApp belum dikonfigurasi.
              </div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>

    <!-- Kanan: Peta -->
    <div class="col-lg-6 mt-3 mt-lg-0">
      <div class="map-wrap mb-2">
        <div class="map-ratio">
          <iframe
            src="<?= htmlspecialchars($embed_src, ENT_QUOTES, 'UTF-8') ?>"
            loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen>
          </iframe>
        </div>
      </div>

      <div class="d-flex" style="gap:.5rem;">
        <a href="<?= htmlspecialchars($maps_open_url, ENT_QUOTES, 'UTF-8') ?>"
           class="btn btn-soft"
           target="_blank" rel="noopener">
          <i class="mdi mdi-map-marker"></i> Buka di Google Maps
        </a>
        <?php if ($alamat_raw): ?>
        <a class="btn btn-soft"
           target="_blank" rel="noopener"
           href="https://www.google.com/maps/dir/?api=1&destination=<?= rawurlencode($alamat_raw) ?>">
          <i class="mdi mdi-navigation"></i> Petunjuk Arah
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view("front_end/footer.php"); ?>

<script>
  // Compose & buka WhatsApp
  (function(){
    var btn = document.getElementById('btnWaForm');
    if (!btn) return;
    btn.addEventListener('click', function(){
      var f     = document.getElementById('formKontak');
      var nama  = (f.nama.value||'').trim();
      var sub   = (f.subjek.value||'').trim();
      var pesan = (f.pesan.value||'').trim();

      var lines = [];
      if (sub)   lines.push('*'+sub+'*');
      if (nama)  lines.push('Nama: '+nama);
      if (pesan) lines.push('', pesan); // baris kosong = newline

      var text = encodeURIComponent(lines.join('\n'));
      var target = 'https://wa.me/<?= $wa_norm ?: '' ?>?text=' + text;
      window.open(target, '_blank', 'noopener');
    });
  })();
</script>
