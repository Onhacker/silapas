<?php
// kontak_view.php
$this->load->view("front_end/head.php");

// Data profil
$rec    = isset($rec) ? $rec : (object)[];
$nama   = htmlspecialchars($rec->nama_website ?? 'Lapas Kelas I Makassar', ENT_QUOTES, 'UTF-8');
$alamat = htmlspecialchars($rec->alamat       ?? '-', ENT_QUOTES, 'UTF-8');
$telp   = trim((string)($rec->no_telp         ?? ($rec->telepon ?? '')));
$email  = htmlspecialchars($rec->email        ?? '-', ENT_QUOTES, 'UTF-8');
$wa     = trim((string)($rec->no_wa           ?? ($rec->wa ?? $telp)));
$jam    = htmlspecialchars($rec->jam_kerja    ?? 'Sen–Jum 08:00–16:00 WITA', ENT_QUOTES, 'UTF-8');
$map_link_raw = trim((string)($rec->map ?? '')); // <-- kolom map (link biasa)

// Normalisasi WA → 62
function norm_wa($n){
  $n = preg_replace('/\D+/', '', (string)$n);
  if ($n === '') return '';
  if (strpos($n, '62') === 0) return $n;
  if ($n[0] === '0') return '62'.substr($n,1);
  return $n;
}
$wa_norm = norm_wa($wa);

// Buat URL embed dari link map (fallback ke alamat/nama bila tak bisa)
$embed_src = '';
if ($map_link_raw !== '') {
  if (strpos($map_link_raw, 'google.com/maps') !== false) {
    $embed_src = $map_link_raw . (strpos($map_link_raw,'?')!==false ? '&' : '?') . 'output=embed';
  } else {
    // shortlink (maps.app.goo.gl/goo.gl/maps) biasanya tak bisa di-iframe → fallback ke q=alamat/nama
    $embed_src = 'https://www.google.com/maps?q='.rawurlencode($alamat ?: $nama).'&output=embed';
  }
} else {
  $embed_src = 'https://www.google.com/maps?q='.rawurlencode($alamat ?: $nama).'&output=embed';
}
$maps_open_url = $map_link_raw !== '' ? $map_link_raw : ('https://www.google.com/maps/search/?api=1&query='.rawurlencode($alamat ?: $nama));
?>
<style>
  /* --- tampilan cantik --- */
  .contact-hero{
    background: linear-gradient(135deg,#f8fafc 0%, #eef2ff 100%);
    border:1px solid #eef0f3;border-radius:16px
  }
  .contact-card{border:1px solid #eef0f3;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,.05)}
  .icon-pill{width:44px;height:44px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;background:#f1f5f9;margin-right:.7rem}
  .icon-pill i{font-size:20px}
  .map-wrap{min-height:380px;border-radius:14px;overflow:hidden;border:1px solid #eef0f3;box-shadow:0 6px 18px rgba(0,0,0,.05)}
  .btn-wa{background:#25D366;color:#fff;border:none}
  .btn-wa:hover{filter:brightness(.95);color:#fff}
  .btn-soft{background:#f8fafc;border:1px solid #e5e7eb}
  .form-note{font-size:.875rem;color:#64748b}
  .contact-badges .badge{font-size:.85rem}
</style>

<div class="container-fluid">
  <!-- Title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><?= htmlspecialchars($title ?? 'Kontak', ENT_QUOTES, 'UTF-8') ?></li>
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
          <div>
            <h3 class="mb-1"><?= htmlspecialchars($title ?? 'Kontak Lapas Kelas I Makassar', ENT_QUOTES, 'UTF-8') ?></h3>
            <p class="text-muted mb-2"><?= htmlspecialchars($deskripsi ?? '', ENT_QUOTES, 'UTF-8') ?></p>
            <div class="contact-badges">
              <span class="badge badge-soft-primary mr-1 mb-1"><i class="mdi mdi-clock-outline"></i> <?= $jam ?></span>
              <?php if ($email && $email!=='-'): ?>
                <span class="badge badge-soft-info mr-1 mb-1"><i class="mdi mdi-email-outline"></i> <?= $email ?></span>
              <?php endif; ?>
            </div>
          </div>
          <?php if (!empty($wa_norm)): ?>
          <div class="mt-2 mt-md-0">
            <a class="btn btn-wa btn-lg shadow-sm"
               target="_blank" rel="noopener"
               href="https://wa.me/<?= $wa_norm ?>?text=Halo%20<?= rawurlencode($nama) ?>,%20saya%20ingin%20bertanya.">
              <i class="mdi mdi-whatsapp"></i> Chat WhatsApp
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Konten -->
  <div class="row">
    <!-- Kiri: Info + Form compose WA (tanpa submit) -->
    <div class="col-lg-6">
      <div class="card contact-card">
        <div class="card-body">
          <h5 class="mb-3">Informasi Kontak</h5>

          <div class="d-flex align-items-start mb-3">
            <span class="icon-pill bg-soft-primary text-primary"><i class="mdi mdi-office-building"></i></span>
            <div>
              <div class="font-weight-bold">Alamat</div>
              <div class="text-muted"><?= $alamat ?></div>
            </div>
          </div>

          <?php if (!empty($telp)): ?>
          <div class="d-flex align-items-start mb-3">
            <span class="icon-pill bg-soft-info text-info"><i class="mdi mdi-phone"></i></span>
            <div>
              <div class="font-weight-bold">Telepon</div>
              <div class="text-muted"><a href="tel:<?= htmlspecialchars($telp, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($telp, ENT_QUOTES, 'UTF-8') ?></a></div>
            </div>
          </div>
          <?php endif; ?>

          <hr>

          <h6 class="mb-2">Tulis Pesan Cepat (WhatsApp)</h6>
          <!-- Tidak ada tombol Kirim form, hanya WhatsApp -->
          <form id="formKontak" onsubmit="return false;">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama Anda">
            </div>
            <div class="form-group">
              <label>Subjek</label>
              <input type="text" name="subjek" class="form-control" placeholder="Judul/Pokok pesan">
            </div>
            <div class="form-group">
              <label>Pesan</label>
              <textarea name="pesan" rows="4" class="form-control" placeholder="Tulis pertanyaan atau kebutuhan Anda"></textarea>
              <div class="form-note mt-1">Klik tombol WhatsApp untuk mengirim pesan ke admin.</div>
            </div>

            <?php if (!empty($wa_norm)): ?>
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

        <div style="height: 96%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">  <iframe
          src="<?= htmlspecialchars($embed_src, ENT_QUOTES, 'UTF-8') ?>"
          width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
      </div>
      <div class="d-flex" style="gap:.5rem;">
        <a href="<?= htmlspecialchars($maps_open_url, ENT_QUOTES, 'UTF-8') ?>"
           class="btn btn-blue"
           target="_blank" rel="noopener">
          <i class="mdi mdi-map-marker"></i> Buka di Google Maps
        </a>
      </div>
    </div>
  </div>
</div>
</div>
<!-- <br> -->

<?php $this->load->view("front_end/footer.php") ?>

<script>
  // Compose & buka WhatsApp
  (function(){
    var btn = document.getElementById('btnWaForm');
    if (!btn) return;
    btn.addEventListener('click', function(){
      var f = document.getElementById('formKontak');
      var nama  = (f.nama.value||'').trim();
      var sub   = (f.subjek.value||'').trim();
      var pesan = (f.pesan.value||'').trim();

      var lines = [];
      if (sub)   lines.push('*'+sub+'*');
      if (nama)  lines.push('Nama: '+nama);
      if (pesan) lines.push('\n'+pesan);

      var text = encodeURIComponent(lines.join('\n'));
      var target = 'https://wa.me/<?= $wa_norm ?: '' ?>?text=' + text;
      window.open(target, '_blank', 'noopener');
    });
  })();
</script>
