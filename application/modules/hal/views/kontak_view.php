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
$ig_raw = trim((string)($rec->instagram ?? ''));
$fb_raw = trim((string)($rec->facebook  ?? ''));

/** Normalisasi handle/URL sosmed → [url lengkap, label tampil] */
function social_url_and_label($raw, $type){
  $s = trim((string)$raw);
  if ($s === '') return [null, null];

  $isUrl = preg_match('~^https?://~i', $s);
  $handle = ltrim($s, '@/'); // buang @ atau / awal

  if ($isUrl) {
    // Ambil path terakhir sebagai label
    $p = parse_url($s, PHP_URL_PATH);
    $seg = array_values(array_filter(explode('/', (string)$p)));
    $label = $seg ? '@'.$seg[0] : ($type === 'ig' ? '@instagram' : '@facebook');
    return [$s, $label];
  }

  if ($type === 'ig') {
    return ['https://instagram.com/'.$handle, '@'.$handle];
  } else {
    return ['https://facebook.com/'.$handle, '@'.$handle];
  }
}

[$ig_url, $ig_label] = social_url_and_label($ig_raw, 'ig');
[$fb_url, $fb_label] = social_url_and_label($fb_raw, 'fb');

// Jam kerja: izinkan <br> saja


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
  /* ===== Tampilan Halaman Kontak (polished) ===== */
  :root{
    --brand:#0f172a;         /* slate-900 */
    --brand-2:#1e3a8a;       /* indigo-900 */
    --muted:#64748b;         /* slate-500 */
    --ring:#c7d2fe;          /* indigo-200 */
    --card-border:#eef0f3;
  }

  .contact-hero{
    position:relative;
    background: radial-gradient(1200px 400px at 15% -10%, #e0e7ff 0%, transparent 60%) ,
                linear-gradient(135deg,#f8fafc 0%, #eef2ff 100%);
    border:1px solid var(--card-border);
    border-radius:16px;
    overflow:hidden;
  }
  .contact-hero .headline{
    color:var(--brand);
    letter-spacing:.2px;
  }
  .contact-hero .badge{
    border:1px solid #e5e7eb;
    background:#fff;
    color:#111827;
  }

  .contact-card{
    border:1px solid var(--card-border);
    border-radius:14px;
    box-shadow:0 10px 25px rgba(2,6,23,.06);
    transition:transform .18s ease, box-shadow .18s ease;
  }
  .contact-card:hover{ transform:translateY(-2px); box-shadow:0 16px 32px rgba(2,6,23,.08); }

  .icon-pill{
    width:46px;height:46px;border-radius:999px;
    display:inline-flex;align-items:center;justify-content:center;
    background:#f1f5f9;color:#0f172a;margin-right:.75rem;flex:0 0 46px;
  }
  .icon-pill i{font-size:20px}

  .btn-soft{background:#f8fafc;border:1px solid #e5e7eb;color:#111827}
  .btn-soft:hover{background:#eef2ff;border-color:#e0e7ff}
  .btn-wa{background:#25D366;color:#fff;border:none}
  .btn-wa:hover{filter:brightness(.96);color:#fff}
  .btn-call{background:#16a34a;color:#fff;border:none}
  .btn-email{background:#0ea5e9;color:#fff;border:none}
  .btn-maps{background:#6366f1;color:#fff;border:none}

  .contact-badges .badge{font-size:.84rem}

  /* Map */
  .map-wrap{border:1px solid var(--card-border);border-radius:14px;overflow:hidden}
  .map-ratio{position:relative;width:100%;aspect-ratio: 16/10;}
  @supports not (aspect-ratio: 1){ .map-ratio:before{content:"";display:block;padding-top:62.5%} }
  .map-ratio iframe{position:absolute;inset:0;width:100%;height:100%;border:0}

  /* Skeleton loader untuk map */
  .skeleton{
    background:linear-gradient(90deg,#f3f4f6 25%,#e5e7eb 37%,#f3f4f6 63%);
    background-size:400% 100%;animation:skeleton 1.2s ease-in-out infinite;
  }
  @keyframes skeleton{0%{background-position:100% 0}100%{background-position:0 0}}

  .info-item + .info-item{margin-top:1rem}
  .form-note{font-size:.875rem;color:var(--muted)}

  /* Aksi cepat di hero (stack di mobile) */
  @media (max-width: 575.98px){ .contact-hero .btn{width:100%;margin-bottom:.5rem} }
  .btn-ig{background:#E1306C;color:#fff;border:none}
.btn-ig:hover{filter:brightness(.96);color:#fff}
.btn-fb{background:#1877F2;color:#fff;border:none}
.btn-fb:hover{filter:brightness(.96);color:#fff}

</style>

<div class="container-fluid">
  <!-- Page title -->
  <div class="hero-title" role="banner" aria-label="Judul situs">
    <h1 class="text">Kontak</h1>
    <span class="accent" aria-hidden="true"></span>
  </div>

  <!-- Hero -->
  <div class="row">
    <div class="col-12">
      <div class="contact-hero p-3 p-md-4 mb-3">
        <div class="d-lg-flex align-items-center justify-content-between">
          <div class="mr-lg-3">
            <!-- <h3 class="mb-1 headline">Kontak <?= $nama ?></h3> -->
            <?php if ($deskripsi): ?>
              <p class="text-dark mb-2"><?= $deskripsi ?></p>
            <?php endif; ?>

            <?php
$jam_default = "Senin - Kamis: 08.00 - 15.00<br>Jumat: 08.00 - 14.00<br>Sabtu: 08.00 - 11.30 WITA";
$jam_raw     = (string)($rec->jam_kerja ?? $jam_default);

/* Pecah jadi array baris; dukung <br> & newline */
$jam_lines = preg_split('/\s*<br\s*\/?>\s*|\r\n|\r|\n/i', $jam_raw);
$jam_lines = array_values(array_filter(array_map('trim', $jam_lines), 'strlen'));
?>
<style>
  .jam-kerja .title { color:#0f172a; }
  .jam-kerja .jam-list { margin:0; padding:0; list-style:none; }
  .jam-kerja .jam-list li { display:flex; align-items:flex-start; margin-bottom:.35rem; }
  .jam-kerja .dot { font-size:20px; line-height:1; margin-right:.25rem; color:#4f46e5; } /* indigo */
</style>

<div class="jam-kerja">
  <div class="d-flex align-items-center mb-1">
    <i class="mdi mdi-clock-outline mr-2 text-primary"></i>
    <strong class="title">Jam Layanan</strong>
  </div>
  <ul class="jam-list">
    <?php foreach ($jam_lines as $line): ?>
      <li>
        <i class="mdi mdi-circle-small dot"></i>
        <span><?= htmlspecialchars($line, ENT_QUOTES, 'UTF-8') ?></span>
      </li>
    <?php endforeach; ?>
  </ul>
</div>


          </div>

          <div class="mt-3 mt-lg-0 d-flex flex-wrap" style="gap:.5rem">
            <?php if ($telp_disp && $telp_disp !== '-'): ?>
              <a class="btn btn-call"
                 aria-label="Telepon"
                 href="tel:<?= htmlspecialchars($telp_raw, ENT_QUOTES, 'UTF-8') ?>">
                <i class="mdi mdi-phone"></i> Telepon
              </a>
            <?php endif; ?>

            <?php if ($email_disp && $email_disp !== '-'): ?>
              <a class="btn btn-email"
                 aria-label="Kirim Email"
                 href="mailto:<?= htmlspecialchars($email_raw, ENT_QUOTES, 'UTF-8') ?>">
                <i class="mdi mdi-email"></i> Email
              </a>
            <?php endif; ?>

            <?php if ($wa_norm): ?>
              <a class="btn btn-wa"
                 target="_blank" rel="noopener"
                 aria-label="Chat WhatsApp"
                 href="https://wa.me/<?= $wa_norm ?>?text=Halo%20<?= rawurlencode($site_name) ?>,%20saya%20ingin%20bertanya.">
                <i class="mdi mdi-whatsapp"></i> WhatsApp
              </a>
            <?php endif; ?>
            <?php if ($ig_url): ?>
  <a class="btn btn-ig"
     target="_blank" rel="noopener"
     aria-label="Instagram"
     href="<?= htmlspecialchars($ig_url, ENT_QUOTES, 'UTF-8') ?>">
    <i class="mdi mdi-instagram"></i> Instagram
  </a>
<?php endif; ?>

<?php if ($fb_url): ?>
  <a class="btn btn-fb"
     target="_blank" rel="noopener"
     aria-label="Facebook"
     href="<?= htmlspecialchars($fb_url, ENT_QUOTES, 'UTF-8') ?>">
    <i class="mdi mdi-facebook"></i> Facebook
  </a>
<?php endif; ?>

            <a class="btn btn-maps" target="_blank" rel="noopener"
               aria-label="Buka di Google Maps"
               href="<?= htmlspecialchars($maps_open_url, ENT_QUOTES, 'UTF-8') ?>">
              <i class="mdi mdi-map-marker"></i> Maps
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Konten -->
  <div class="row mb-2">
    <!-- Kiri -->
    <div class="col-lg-6">
      <div class="card contact-card h-100">
        <div class="card-body">
          <h5 class="mb-3">Informasi Kontak</h5>

          <div class="info-item d-flex align-items-start">
            <span class="icon-pill"><i class="mdi mdi-office-building"></i></span>
            <div>
              <div class="font-weight-bold mb-1">Alamat</div>
              <div class="text-dark mb-2" id="alamatText"><?= $alamat ?></div>
              <div class="d-flex" style="gap:.5rem">
                <button type="button" class="btn btn-soft btn-sm" id="btnCopyAlamat">
                  <i class="mdi mdi-content-copy"></i> Salin Alamat
                </button>
                <?php if ($alamat_raw): ?>
                <a class="btn btn-soft btn-sm"
                   target="_blank" rel="noopener"
                   href="https://www.google.com/maps/dir/?api=1&destination=<?= rawurlencode($alamat_raw) ?>">
                  <i class="mdi mdi-navigation"></i> Petunjuk Arah
                </a>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <?php if ($telp_disp && $telp_disp !== '-'): ?>
          <div class="info-item d-flex align-items-start">
            <span class="icon-pill"><i class="mdi mdi-phone"></i></span>
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
            <span class="icon-pill"><i class="mdi mdi-email"></i></span>
            <div>
              <div class="font-weight-bold">Email</div>
              <div class="text-muted">
                <a href="mailto:<?= htmlspecialchars($email_raw, ENT_QUOTES, 'UTF-8') ?>"><?= $email_disp ?></a>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <?php if ($ig_url): ?>
  <div class="info-item d-flex align-items-start">
    <span class="icon-pill"><i class="mdi mdi-instagram"></i></span>
    <div>
      <div class="font-weight-bold">Instagram</div>
      <div class="text-muted">
        <a target="_blank" rel="noopener"
           href="<?= htmlspecialchars($ig_url, ENT_QUOTES, 'UTF-8') ?>">
          <?= htmlspecialchars($ig_label ?? 'Instagram', ENT_QUOTES, 'UTF-8') ?>
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php if ($fb_url): ?>
  <div class="info-item d-flex align-items-start">
    <span class="icon-pill"><i class="mdi mdi-facebook"></i></span>
    <div>
      <div class="font-weight-bold">Facebook</div>
      <div class="text-muted">
        <a target="_blank" rel="noopener"
           href="<?= htmlspecialchars($fb_url, ENT_QUOTES, 'UTF-8') ?>">
          <?= htmlspecialchars($fb_label ?? 'Facebook', ENT_QUOTES, 'UTF-8') ?>
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

          <hr class="my-4">

          <h6 class="mb-2">Tulis Pesan Cepat (WhatsApp)</h6>
          <form id="formKontak" onsubmit="return false;" novalidate>
            <div class="form-group">
              <label for="fNama">Nama</label>
              <input id="fNama" type="text" name="nama" class="form-control" placeholder="Nama Anda"
                     autocomplete="name" aria-required="true">
            </div>
            <div class="form-group">
              <label for="fSubjek">Subjek</label>
              <input id="fSubjek" type="text" name="subjek" class="form-control" placeholder="Judul/Pokok pesan">
            </div>
            <div class="form-group">
              <label for="fPesan">Pesan</label>
              <textarea id="fPesan" name="pesan" rows="4" class="form-control"
                        placeholder="Tulis pertanyaan atau kebutuhan Anda" aria-required="true"></textarea>
              <div class="form-note mt-1">Klik tombol WhatsApp untuk mengirim pesan ke admin.</div>
            </div>

            <?php if ($wa_norm): ?>
              <button id="btnWaForm" class="btn btn-wa btn-block" type="button" aria-label="Kirim via WhatsApp">
                <i class="mdi mdi-whatsapp"></i> Kirim via WhatsApp
              </button>
            <?php else: ?>
              <div class="alert alert-warning mt-2 mb-0">
                Nomor WhatsApp belum dikonfigurasi.
              </div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>

    <!-- Kanan -->
    <div class="col-lg-6 mt-3 mt-lg-0">
      <div class="map-wrap">
        <div class="map-ratio">
          <!-- skeleton di bawah, akan dihapus saat iframe load -->
          <div id="mapSkeleton" class="skeleton" style="position:absolute;inset:0"></div>
          <iframe
            id="mapFrame"
            src="<?= htmlspecialchars($embed_src, ENT_QUOTES, 'UTF-8') ?>"
            loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen
            title="Lokasi di Google Maps" aria-label="Peta lokasi">
          </iframe>
        </div>
      </div>

      <div class="d-flex mt-2 mb-2" style="gap:.5rem;">
        <a href="<?= htmlspecialchars($maps_open_url, ENT_QUOTES, 'UTF-8') ?>"
           class="btn btn-maps"
           target="_blank" rel="noopener" aria-label="Buka di Google Maps">
          <i class="mdi mdi-map-marker"></i> Buka di Google Maps
        </a>
        <?php if ($alamat_raw): ?>
        <a class="btn btn-soft" target="_blank" rel="noopener"
           href="https://www.google.com/maps/dir/?api=1&destination=<?= rawurlencode($alamat_raw) ?>"
           aria-label="Petunjuk Arah">
          <i class="mdi mdi-navigation"></i> Petunjuk Arah
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view("front_end/footer.php"); ?>

<script>
  // ===== Utils =====
  function toast(msg, type='success'){
    if (window.$ && $.toast) {
      $.toast({ text: msg, position: 'bottom-center', hideAfter: 2500, loader:false,
                bgColor: type==='success' ? '#16a34a' : '#dc2626' });
    } else { alert(msg); }
  }

  // Skeleton → hilangkan setelah map load
  (function(){
    var f = document.getElementById('mapFrame');
    var sk = document.getElementById('mapSkeleton');
    if (!f || !sk) return;
    f.addEventListener('load', function(){ sk.remove(); }, { once:true });
    // safety timeout
    setTimeout(function(){ if (sk && sk.parentNode) sk.remove(); }, 4000);
  })();

  // Salin alamat
  (function(){
    var btn = document.getElementById('btnCopyAlamat');
    if (!btn) return;
    btn.addEventListener('click', async function(){
      var t = document.getElementById('alamatText')?.innerText || '';
      try { await navigator.clipboard.writeText(t); toast('Alamat disalin'); }
      catch(e){ toast('Gagal menyalin alamat','error'); }
    });
  })();

  // Compose & buka WhatsApp (validasi ringan)
  (function(){
    var btn = document.getElementById('btnWaForm');
    if (!btn) return;
    btn.addEventListener('click', function(){
      var f     = document.getElementById('formKontak');
      var nama  = (f.nama.value||'').trim();
      var sub   = (f.subjek.value||'').trim();
      var pesan = (f.pesan.value||'').trim();

      if (!nama || !pesan){
        if (window.Swal) {
          Swal.fire('Lengkapi Data','Nama dan Pesan wajib diisi.','warning');
        } else {
          alert('Nama dan Pesan wajib diisi.');
        }
        return;
      }

      var lines = [];
      if (sub)   lines.push('*'+sub+'*');
      if (nama)  lines.push('Nama: '+nama);
      if (pesan) lines.push('', pesan);

      var text = encodeURIComponent(lines.join('\n'));
      var target = 'https://wa.me/<?= $wa_norm ?: '' ?>?text=' + text;
      window.open(target, '_blank', 'noopener');
    });
  })();
</script>
