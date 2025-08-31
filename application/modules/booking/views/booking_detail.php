<?php $this->load->view("front_end/head.php") ?>

<?php
// ==== helper kecil hari Indonesia ====
if (!function_exists('hari_id')) {
  function hari_id($dateString) {
    if (empty($dateString)) return '-';
    $ts = strtotime($dateString);
    if ($ts === false) return '-';
    $map = ['Sun'=>'Minggu','Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu','Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu'];
    return $map[date('D',$ts)] ?? date('D',$ts);
  }
}
?>

<style>
  .kv-card{border:1px solid #e5e7eb;border-radius:14px}
  .kv-head{border-bottom:1px dashed #e5e7eb}
  .kv-label{color:#6b7280;font-size:.9rem}
  .kv-value{font-weight:600;color:#111}
  .kv-row{padding:.45rem 0;border-bottom:1px dashed #eef2f7}
  .kv-row:last-child{border-bottom:none}
  .section-title{font-weight:700;color:#0f172a}
  .soft{color:#64748b}
  .chip{display:inline-flex;align-items:center;gap:.4rem;padding:.28rem .6rem;border-radius:999px;background:#f1f5f9}
  .chip .dot{width:.5rem;height:.5rem;border-radius:999px;background:#22c55e}
  .pill{display:inline-block;padding:.35rem .7rem;border-radius:999px;font-weight:700;font-size:.75rem;letter-spacing:.2px;color:#fff}
  .pill-primary{background:#2563eb}.pill-info{background:#0ea5e9}.pill-success{background:#16a34a}
  .pill-warning{background:#f59e0b}.pill-danger{background:#ef4444}.pill-secondary{background:#64748b}
  .qr-wrap img{max-width:190px;border:8px solid #fff;box-shadow:0 6px 24px rgba(0,0,0,.08);border-radius:12px}
  .mini-thumb{max-height:110px;object-fit:cover;cursor:pointer;border-radius:10px}
  .longtext{line-height:1.7;white-space:pre-wrap;word-break:break-word;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 12px}
  .btn-copy{padding:.15rem .55rem;border-radius:8px}
</style>

<div class="container-fluid">
  <div class="row mt-3">
    <div class="col-lg-12">

<?php if (!empty($booking)): ?>
<?php
  $kode = htmlspecialchars($booking->kode_booking, ENT_QUOTES, 'UTF-8');

  // Unit tujuan (sebaiknya dari controller)
  $unit_nama = isset($unit_nama)
    ? $unit_nama
    : $this->db->select('nama_unit')->get_where('unit_tujuan', ['id'=>$booking->unit_tujuan])->row('nama_unit');
  $unit_nama = htmlspecialchars($unit_nama ?: '-', ENT_QUOTES, 'UTF-8');

  // Badge status
  $st = strtolower((string)$booking->status);
  $badgeMap = [
    'pending'     => 'pill-warning',
    'approved'    => 'pill-primary',
    'checked_in'  => 'pill-info',
    'checked_out' => 'pill-success',
    'expired'     => 'pill-secondary',
    'rejected'    => 'pill-danger',
  ];
  $badgeCls = $badgeMap[$st] ?? 'pill-secondary';

  // QR
  $qr_file   = 'uploads/qr/qr_'.$booking->kode_booking.'.png';
  $qr_exists = is_file(FCPATH.$qr_file);
  $qr_url    = base_url($qr_file);

  // Surat & Foto (encode basename utk aman)
  $surat_url = !empty($booking->surat_tugas) ? base_url('uploads/surat_tugas/'.rawurlencode(basename($booking->surat_tugas))) : null;
  $foto_url  = !empty($booking->foto)        ? base_url('uploads/foto/'.rawurlencode(basename($booking->foto)))              : null;

  $instansi  = !empty($booking->target_instansi_nama) ? $booking->target_instansi_nama : ($booking->instansi ?? '-');
  $instansi  = htmlspecialchars($instansi, ENT_QUOTES, 'UTF-8');
  $nama_petugas_instansi = !empty($booking->nama_petugas_instansi) ? $booking->nama_petugas_instansi : '-';
  $nama_petugas_instansi = htmlspecialchars($nama_petugas_instansi, ENT_QUOTES, 'UTF-8');

  $kode_safe = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $booking->kode_booking);

  // Tipe surat
  $surat_ext = $surat_url ? strtolower(pathinfo($booking->surat_tugas, PATHINFO_EXTENSION)) : '';
  $is_pdf    = in_array($surat_ext, ['pdf']);
  $is_img    = in_array($surat_ext, ['jpg','jpeg','png','gif','webp']);

  // Tanggal — tampil hari
  $hari_tgl = '-';
  if (!empty($booking->tanggal)) {
    $hari_tgl = hari_id($booking->tanggal).', '.date('d-m-Y', strtotime($booking->tanggal));
  }
  $jam = !empty($booking->jam) ? htmlspecialchars($booking->jam, ENT_QUOTES, 'UTF-8') : '-';

  // Check-in/out — tampil hari
  $checkin_str  = '';
  if (!empty($booking->checkin_at)) {
    $checkin_str = hari_id($booking->checkin_at).', '.date('d-m-Y H:i', strtotime($booking->checkin_at));
  }
  $checkout_str = '';
  if (!empty($booking->checkout_at)) {
    $checkout_str = hari_id($booking->checkout_at).', '.date('d-m-Y H:i', strtotime($booking->checkout_at));
  }
    // Daftar pendamping dari tabel booking_pendamping
  $pendamping_rows = $this->db
      ->order_by('id_pendamping','ASC')
      ->get_where('booking_pendamping', ['kode_booking' => $booking->kode_booking])
      ->result();

  // Durasi hanya jika ada checkin & checkout
  $durasi = '';
  if (!empty($booking->checkin_at) && !empty($booking->checkout_at)) {
    try {
      $d1 = new DateTime($booking->checkin_at);
      $d2 = new DateTime($booking->checkout_at);
      $diff = $d1->diff($d2);
      $parts = [];
      if ($diff->d) $parts[] = $diff->d.' hari';
      if ($diff->h) $parts[] = $diff->h.' jam';
      if ($diff->i) $parts[] = $diff->i.' mnt';
      if ($diff->s && !$diff->d && !$diff->h) $parts[] = $diff->s.' dtk';
      $durasi = $parts ? implode(' ', $parts) : '0 mnt';
    } catch (Throwable $e) { $durasi = ''; }
  }

  // No HP untuk tautan WA
  $hp_wa = preg_replace('/\D+/', '', (string)$booking->no_hp);
?>

<div class="card kv-card shadow-sm mb-3">
  <div class="card-body">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center kv-head pb-3 mb-3">
      <div class="d-flex align-items-center" style="gap:1rem;">
        <h4 class="mb-0 section-title">Detail Booking</h4>
        <div class="chip"><span class="dot"></span><span class="soft">Kode</span><strong><?= $kode ?></strong></div>
      </div>
      <div class="d-flex align-items-center flex-wrap" style="gap:.5rem;">
        <span class="pill <?= $badgeCls ?> text-uppercase"><?= htmlspecialchars($booking->status) ?></span>
      </div>
    </div>

    <div class="row">
      <!-- KIRI -->
      <div class="col-md-7">
        <dl class="mb-0">
          <div class="kv-row row no-gutters align-items-center">
            <dt class="col-sm-4 kv-label">🔑 Kode</dt>
            <dd class="col-sm-8 kv-value">
              <span class="chip mr-2"><span class="dot"></span><span><?= $kode ?></span></span>
              <button type="button" class="btn btn-light btn-sm btn-copy" data-clip="<?= $kode ?>">
                <i class="mdi mdi-content-copy"></i>
              </button>
            </dd>
          </div>

          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">👤 Nama Tamu</dt><dd class="col-sm-8 kv-value"><?= htmlspecialchars($booking->nama_tamu, ENT_QUOTES, 'UTF-8') ?></dd></div>
          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">🧑‍💼 Jabatan</dt><dd class="col-sm-8 kv-value"><?= htmlspecialchars($booking->jabatan, ENT_QUOTES, 'UTF-8') ?></dd></div>

          <div class="kv-row row no-gutters align-items-center">
            <dt class="col-sm-4 kv-label">🪪 NIK</dt>
            <dd class="col-sm-8 kv-value">
              <?= htmlspecialchars($booking->nik, ENT_QUOTES, 'UTF-8') ?>
              <button type="button" class="btn btn-light btn-sm btn-copy ml-1" data-clip="<?= htmlspecialchars($booking->nik, ENT_QUOTES, 'UTF-8') ?>">
                <i class="mdi mdi-content-copy"></i>
              </button>
            </dd>
          </div>

          <div class="kv-row row no-gutters align-items-center">
            <dt class="col-sm-4 kv-label">📱 No. HP</dt>
            <dd class="col-sm-8 kv-value">
              <?= htmlspecialchars($booking->no_hp, ENT_QUOTES, 'UTF-8') ?>
              <?php if ($hp_wa): ?>
                <a class="btn btn-light btn-sm ml-1" target="_blank" rel="noopener" href="https://wa.me/<?= $hp_wa ?>">
                  <i class="mdi mdi-whatsapp"></i>
                </a>
              <?php endif; ?>
            </dd>
          </div>

          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">🏢 Instansi Asal</dt><dd class="col-sm-8 kv-value"><?= $instansi ?></dd></div>
          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">🎯 Unit Tujuan</dt><dd class="col-sm-8 kv-value"><?= $unit_nama ?></dd></div>
          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">🏷️ Nama <?= $unit_nama ?></dt><dd class="col-sm-8 kv-value"><?= $nama_petugas_instansi ?></dd></div>

          <div class="kv-row row no-gutters">
            <dt class="col-sm-4 kv-label">📝 Keperluan</dt>
            <dd class="col-sm-8"><div class="longtext"><?= htmlspecialchars($booking->keperluan, ENT_QUOTES, 'UTF-8') ?></div></dd>
          </div>

          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">📅 Tanggal</dt><dd class="col-sm-8 kv-value"><?= $hari_tgl ?></dd></div>
          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">⏰ Jam</dt><dd class="col-sm-8 kv-value"><?= $jam ?></dd></div>
          <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">👥 Jumlah Pendamping</dt><dd class="col-sm-8 kv-value"><span class="badge badge-pill badge-primary" style="font-size:.9rem;"><?= (int)$booking->jumlah_pendamping ?> orang</span></dd></div>
          <?php if (!empty($pendamping_rows)): ?>
  <div class="kv-row row no-gutters">
    <dt class="col-sm-4 kv-label">👥 Daftar Pendamping</dt>
    <dd class="col-sm-8 kv-value">
      <div class="table-responsive">
        <table class="table table-sm table-bordered mb-0">
          <thead class="thead-light">
            <tr>
              <th style="width:60px;">No</th>
              <th style="width:200px;">NIK</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pendamping_rows as $i => $p): ?>
              <tr>
                <td class="text-center"><?= $i+1 ?></td>
                <td><code><?= htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8') ?></code></td>
                <td><?= htmlspecialchars($p->nama, ENT_QUOTES, 'UTF-8') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </dd>
  </div>
<?php else: ?>
  <?php if ((int)$booking->jumlah_pendamping > 0): ?>
    <div class="kv-row row no-gutters">
      <dt class="col-sm-4 kv-label">👥 Daftar Pendamping</dt>
      <dd class="col-sm-8 kv-value soft">Belum ada data pendamping.</dd>
    </div>
  <?php endif; ?>
<?php endif; ?>


          <?php if ($checkin_str): ?>
            <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">🕘 Check-in</dt><dd class="col-sm-8 kv-value"><?= htmlspecialchars($checkin_str, ENT_QUOTES, 'UTF-8') ?></dd></div>
          <?php endif; ?>

          <?php if ($checkout_str): ?>
            <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">🕙 Check-out</dt><dd class="col-sm-8 kv-value"><?= htmlspecialchars($checkout_str, ENT_QUOTES, 'UTF-8') ?></dd></div>
          <?php endif; ?>

          <?php if ($durasi): ?>
            <div class="kv-row row no-gutters"><dt class="col-sm-4 kv-label">⏳ Durasi</dt><dd class="col-sm-8 kv-value"><?= htmlspecialchars($durasi, ENT_QUOTES, 'UTF-8') ?></dd></div>
          <?php endif; ?>

          <?php if ($surat_url): ?>
            <div class="kv-row row no-gutters">
              <dt class="col-sm-4 kv-label">📄 Surat Tugas</dt>
              <dd class="col-sm-8">
                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalSuratTugas_<?= $kode_safe ?>">
                  <i class="mdi mdi-file-document"></i> Lihat
                </button>
                <a class="btn btn-sm btn-outline-secondary ml-1" href="<?= $surat_url ?>" download>
                  <i class="mdi mdi-download"></i> Unduh
                </a>
              </dd>
            </div>
          <?php endif; ?>

          <?php if ($foto_url): ?>
            <div class="kv-row row no-gutters">
              <dt class="col-sm-4 kv-label">🖼️ Foto</dt>
              <dd class="col-sm-8">
                <img src="<?= $foto_url ?>" alt="Foto Lampiran" class="mini-thumb img-fluid"
                     data-toggle="modal" data-target="#modalFoto_<?= $kode_safe ?>" loading="lazy">
                <div class="mt-2">
                  <a class="btn btn-sm btn-outline-secondary" href="<?= $foto_url ?>" download>
                    <i class="mdi mdi-download"></i> Unduh Foto
                  </a>
                </div>
              </dd>
            </div>
          <?php endif; ?>

        </dl>
      </div>

      <!-- KANAN -->
      <div class="col-md-5 mt-3 mt-md-0">
        <div class="border rounded p-3 text-center mb-3">
          <div class="kv-label mb-2"><i class="mdi mdi-qrcode"></i> QR Code Booking</div>
          <?php if ($qr_exists): ?>
            <div class="qr-wrap">
              <img src="<?= $qr_url ?>" alt="QR Booking <?= $kode ?>" class="img-fluid" loading="lazy"/>
            </div>
            <div class="mt-2">
              <a href="<?= $qr_url ?>" download="qr_<?= $kode ?>.png" class="btn btn-sm btn-outline-success">
                <i class="mdi mdi-download"></i> Unduh QR
              </a>
            </div>
          <?php else: ?>
            <div class="text-muted small">QR belum tersedia.</div>
          <?php endif; ?>
        </div>

        <div class="p-3 bg-light rounded mb-3">
          <div class="kv-label mb-2"><i class="mdi mdi-information-outline"></i> Catatan</div>
          <ul class="mb-0 pl-3">
            <li>Datang ±10 menit sebelum jadwal.</li>
            <li>Bawa KTP asli & identitas instansi.</li>
            <li>Tunjukkan QR saat check-in.</li>
            <li>Unduh & simpan berkas agar tidak hilang.</li>
          </ul>
        </div>
        <!-- Foto Dokumentasi (Opsional) -->
        <div class="border rounded p-3 mb-3">
        	<div class="kv-label mb-2"><i class="mdi mdi-camera"></i> Foto Dokumentasi <span class="soft">(opsional)</span></div>

        	<div class="form-group mb-2">
        		<input type="file" id="doc_photo" accept="image/*" capture="environment" class="form-control-file">
        		<small class="text-muted d-block mt-1">JPG/PNG • Maks 1.5MB • Kamera belakang disarankan.</small>
        	</div>

        	<div id="doc_preview_wrap" class="mb-2" style="display:none;">
        		<img id="doc_preview" alt="Preview" style="max-width:100%;border:1px solid #e5e7eb;border-radius:8px;">
        	</div>

        	<div class="d-flex align-items-center" style="gap:.5rem;">
        		<button type="button" id="btnDocUpload" class="btn btn-primary btn-sm" disabled>
        			<i class="mdi mdi-cloud-upload"></i> Upload
        		</button>
        		<button type="button" id="btnDocReset" class="btn btn-light btn-sm" style="display:none;">
        			<i class="mdi mdi-close-circle-outline"></i> Batal
        		</button>
        	</div>

        	<hr class="my-3">

        	<div class="kv-label mb-2"><i class="mdi mdi-image-multiple"></i> Galeri</div>
        	<div id="doc_gallery" class="row" style="gap:.75rem .75rem;"></div>
        </div>


        <div class="d-flex flex-wrap" style="gap:.5rem;">
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalPDF_<?= $kode_safe ?>">
            <i class="mdi mdi-file-pdf-box"></i> Lihat PDF
          </button>
          <a href="<?= site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?= urlencode($booking->access_token) ?>&dl=1" class="btn btn-danger">
            <i class="mdi mdi-download"></i> Unduh PDF
          </a>
        </div>
      </div>

    </div><!-- /row -->
  </div>
</div>

<!-- Modal Surat Tugas -->
<?php if ($surat_url): ?>
<div class="modal fade" id="modalSuratTugas_<?= $kode_safe ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title"><i class="mdi mdi-file-document"></i> Surat Tugas</h6>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body p-0">
        <?php if ($is_pdf): ?>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?= $surat_url ?>#toolbar=1&navpanes=0&scrollbar=1" allowfullscreen></iframe>
          </div>
        <?php elseif ($is_img): ?>
          <img src="<?= $surat_url ?>" class="img-fluid" alt="Surat Tugas">
        <?php else: ?>
          <div class="p-4">Format file tidak didukung untuk pratinjau. Silakan unduh.</div>
        <?php endif; ?>
      </div>
      <div class="modal-footer py-2">
        <a class="btn btn-outline-secondary" href="<?= $surat_url ?>" download><i class="mdi mdi-download"></i> Unduh</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Modal Foto -->
<?php if ($foto_url): ?>
<div class="modal fade" id="modalFoto_<?= $kode_safe ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title"><i class="mdi mdi-image"></i> Foto Lampiran</h6>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="<?= $foto_url ?>" class="img-fluid" style="max-height:75vh" alt="Foto Lampiran">
      </div>
      <div class="modal-footer py-2">
        <a class="btn btn-outline-secondary" href="<?= $foto_url ?>" download><i class="mdi mdi-download"></i> Unduh</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Modal PDF -->
<div class="modal fade" id="modalPDF_<?= $kode_safe ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width:95%;">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title mb-0">Pratinjau PDF – <?= $kode ?></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body p-0" style="background:#f8f9fa;">
        <iframe src="<?= site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?= urlencode($booking->access_token) ?>&dl=0#view=FitH"
                style="width:100%; height:80vh; border:0;"></iframe>
      </div>
      <div class="modal-footer py-2">
        <a href="<?= site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?= urlencode($booking->access_token) ?>&dl=1"
           class="btn btn-danger"><i class="mdi mdi-download"></i> Unduh PDF</a>
        <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php else: ?>
  <div class="text-center py-5">
    <h4 class="mb-2">Tidak ada detail untuk ditampilkan</h4>
    <p class="text-muted">Silakan lakukan booking atau buka tautan detail yang valid.</p>
    <a href="<?= site_url('booking') ?>" class="btn btn-primary">Kembali ke Form Booking</a>
  </div>
<?php endif; ?>

    </div>
  </div>
</div>

<?php $this->load->view("front_end/footer.php") ?>

<script>
  // Copy-to-clipboard
  (function(){
    function copyToClipboard(text){
      if (navigator.clipboard) return navigator.clipboard.writeText(text);
      var ta=document.createElement('textarea'); ta.value=text;
      document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
      return Promise.resolve();
    }
    document.querySelectorAll('.btn-copy').forEach(function(btn){
      btn.addEventListener('click', function(){
        var txt = this.getAttribute('data-clip') || '';
        copyToClipboard(txt).then(()=>{
          this.innerHTML = '<i class="mdi mdi-check"></i>';
          this.classList.add('btn-success');
          setTimeout(()=>{
            this.innerHTML = '<i class="mdi mdi-content-copy"></i>';
            this.classList.remove('btn-success');
          }, 1300);
        });
      });
    });
  })();

  // WA auto notify (opsional, sesuai milik Anda)
  document.addEventListener('DOMContentLoaded', function () {
    var token = <?= json_encode($booking->access_token ?? null) ?>;
    if (!token) return;
    var url = "<?= site_url('booking/wa_notify') ?>";
    var params = new URLSearchParams();
    params.set('t', token);
    <?php if (config_item('csrf_protection')): ?>
      params.set('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
    <?php endif; ?>
    fetch(url, {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'},
      body: params.toString(),
      credentials: 'same-origin'
    }).catch(()=>{});
  });


(function(){
  var token = <?= json_encode($booking->access_token ?? null) ?>;
  if (!token) return;

  var upUrl   = "<?= site_url('booking/upload_dokumentasi') ?>";
  var listUrl = "<?= site_url('booking/dokumentasi_list') ?>";

  var elFile   = document.getElementById('doc_photo');
  var elPrevW  = document.getElementById('doc_preview_wrap');
  var elPrev   = document.getElementById('doc_preview');
  var btnUp    = document.getElementById('btnDocUpload');
  var btnReset = document.getElementById('btnDocReset');
  var gal      = document.getElementById('doc_gallery');

  function showPreview(file){
    if (!file){ elPrevW.style.display='none'; btnUp.disabled=true; btnReset.style.display='none'; return; }
    var url = URL.createObjectURL(file);
    elPrev.src = url;
    elPrevW.style.display = 'block';
    btnUp.disabled = false;
    btnReset.style.display = 'inline-block';
  }

  elFile.addEventListener('change', function(){
    var f = this.files && this.files[0];
    showPreview(f || null);
  });

  btnReset.addEventListener('click', function(){
    elFile.value = '';
    showPreview(null);
  });

  function csrfAppend(fdOrParams){
    <?php if (config_item('csrf_protection')): ?>
      fdOrParams.set('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
    <?php endif; ?>
  }

  btnUp.addEventListener('click', function(){
    var f = elFile.files && elFile.files[0];
    if (!f){ alert('Pilih foto dulu.'); return; }

    var fd = new FormData();
    fd.append('t', token);
    fd.append('doc_photo', f);
    csrfAppend(fd);

    btnUp.disabled = true; btnUp.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengunggah...';

    fetch(upUrl, { method:'POST', body: fd, credentials:'same-origin' })
      .then(r=>r.json())
      .then(j=>{
        if (!j.ok){
          alert(j.err || 'Upload gagal.');
        }else{
          // sukses → refresh galeri
          elFile.value=''; showPreview(null);
          refreshGallery();
        }
      })
      .catch(()=>alert('Gagal mengunggah.'))
      .finally(()=>{ btnUp.disabled=false; btnUp.innerHTML='<i class="mdi mdi-cloud-upload"></i> Upload'; });
  });

  function cardTpl(it, idx){
    var name = (it.filename || ('Foto '+(idx+1)));
    return (
      '<div class="col-auto" style="max-width:160px;">' +
        '<div class="card" style="width:160px;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">' +
          '<img src="'+ it.url +'" class="card-img-top" alt="'+ name +'" style="height:110px;object-fit:cover;">' +
          '<div class="card-body p-2 text-center">' +
            '<div class="small soft" title="'+ name +'" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'+ name +'</div>' +
            '<a class="btn btn-sm btn-outline-secondary mt-1" href="'+ it.url +'" download>Unduh</a>' +
          '</div>' +
        '</div>' +
      '</div>'
    );
  }

  function refreshGallery(){
    var params = new URLSearchParams();
    params.set('t', token);
    csrfAppend(params);

    fetch(listUrl, {
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
      body: params.toString(),
      credentials:'same-origin'
    })
    .then(r=>r.json())
    .then(j=>{
      gal.innerHTML = '';
      if (!j.ok || !Array.isArray(j.data) || !j.data.length){
        gal.innerHTML = '<div class="col-12 soft">Belum ada dokumentasi.</div>';
        return;
      }
      j.data.forEach(function(it, i){
        gal.insertAdjacentHTML('beforeend', cardTpl(it, i));
      });
    })
    .catch(()=>{ gal.innerHTML = '<div class="col-12 text-danger">Gagal memuat galeri.</div>'; });
  }

  // load awal
  refreshGallery();
})();


</script>
