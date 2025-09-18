<?php $this->load->view("front_end/head.php") ?>

<?php
// ==== helper kecil hari Indonesia ====
if (!function_exists('hari_id')) {
  function hari_id($dateString) {
    if (empty($dateString)) return '-';
    $ts = strtotime($dateString);
    if ($ts === false) return '-';
    $map = [
      'Sun'=>'Minggu','Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu',
      'Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu'
    ];
    return $map[date('D',$ts)] ?? date('D',$ts);
  }
}
?>

<style>
/* ====== LAYERING MODAL, BACKDROP, & FOOTER ====== */
.modal { z-index: 3000 !important; }
.modal-backdrop { z-index: 2040 !important; }
.footer, .page-footer, footer { z-index: 1 !important; }

/* ====== MATIKAN BLUR BACKDROP KHUSUS MODAL BESAR (PDF/IMG) ====== */
body.noblur-backdrop .modal-backdrop {
  backdrop-filter: none !important;
  -webkit-backdrop-filter: none !important;
  filter: none !important;
  background: rgba(0,0,0,.55) !important;
  z-index: 2040 !important;
  position: fixed !important;
}
body.noblur-backdrop .modal { z-index: 222222 !important; }
body.noblur-backdrop .content,
body.noblur-backdrop .page-wrapper,
body.noblur-backdrop .wrapper,
body.noblur-backdrop main,
body.noblur-backdrop #app {
  filter: none !important; -webkit-filter: none !important; transform: none !important;
}

/* Pastikan dialog bisa diklik (beberapa theme set pointer-events:none) */
[id^="modalPDF_"] .modal-dialog,
[id^="modalPDF_"] .modal-content,
[id^="modalSuratTugas_"] .modal-dialog,
[id^="modalSuratTugas_"] .modal-content,
[id^="modalFoto_"] .modal-dialog,
[id^="modalFoto_"] .modal-content { pointer-events: auto !important; }

/* ====== GAYA KARTU/HEADER KECIL ====== */
.kv-card{border:1px solid #e5e7eb;border-radius:14px}
.kv-head{border-bottom:1px dashed #e5e7eb}
.section-title{font-weight:700;color:#0f172a}
.soft{color:#64748b}
.pill{display:inline-block;padding:.35rem .7rem;border-radius:999px;font-weight:700;font-size:.75rem;letter-spacing:.2px;color:#fff}
.pill-primary{background:#2563eb}.pill-info{background:#0ea5e9}.pill-success{background:#16a34a}
.pill-warning{background:#f59e0b}.pill-danger{background:#ef4444}.pill-secondary{background:#64748b}
.qr-wrap img{max-width:190px;border:8px solid #fff;box-shadow:0 6px 24px rgba(0,0,0,.08);border-radius:12px}

/* ====== KV TABLE (SATU-SATUNYA CSS TABEL) ====== */
:root { --kv-label-w: 42%; }                 /* Lebar kolom label di mobile */
@media (min-width: 768px){ :root { --kv-label-w: 34%; } } /* tablet/desktop */

.kv-table-wrap{ border:1px solid #eef0f3; border-radius:14px; overflow:hidden; }
.kv-table{ width:100%; table-layout:fixed; border-collapse:separate; border-spacing:0; margin:0; }
.kv-table th, .kv-table td{ vertical-align:top; padding:.65rem .8rem; }
.kv-table th.kv-label{
  width:var(--kv-label-w);
  font-weight:700; color:#374151; background:#fafbfc;
  white-space:nowrap; box-sizing:border-box;
}
.kv-table td.kv-value{
  background:#fff; white-space:normal; word-break:break-word; overflow-wrap:anywhere;
  box-sizing:border-box;
}
.kv-table code{ word-break:break-all; }
.kv-table tr+tr th.kv-label, .kv-table tr+tr td.kv-value{ border-top:1px dashed #e5e7eb; }

/* Default: tetap 2 kolom di mobile */
@media (max-width:576px){
  .kv-table tr{ display:table-row !important; }
  .kv-table th.kv-label, .kv-table td.kv-value{ display:table-cell !important; }
}

/* Baris tertentu saja yang di-stack di mobile */
@media (max-width:576px){
  .kv-table tr.kv-stack{ display:block !important; padding:.35rem .5rem; }
  .kv-table tr.kv-stack > th.kv-label,
  .kv-table tr.kv-stack > td.kv-value{
    display:block !important; width:100% !important; border-top:0 !important;
    background:transparent;
    padding-left:.25rem; padding-right:.25rem;
  }
  .kv-table tr.kv-stack > th.kv-label{
    color:#6b7280; font-size:.9rem; padding-top:.2rem; padding-bottom:.2rem;
  }
  .kv-table tr.kv-stack > td.kv-value{ padding-top:0; padding-bottom:.5rem; }
  .kv-table tr.kv-stack .table-responsive,
  .kv-table tr.kv-stack .embed-responsive,
  .kv-table tr.kv-stack img,
  .kv-table tr.kv-stack .upload-actions,
  .kv-table tr.kv-stack .form-group{ width:100%; }
}

/* Aksen kecil */
.chip{display:inline-flex;align-items:center;gap:.45rem;padding:.28rem .6rem;border-radius:999px;background:#f1f5f9;border:1px solid #e2e8f0;font-weight:600}
.chip .dot{width:.5rem;height:.5rem;border-radius:999px;background:#22c55e;display:inline-block}
.longtext{line-height:1.7;white-space:pre-wrap;word-break:break-word;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 12px}
.btn-copy{padding:.15rem .55rem;border-radius:8px}

/* ====== Key/Value table – 2 kolom default, stack baris tertentu di mobile ====== */
:root { --kv-label-w: 42%; }                 /* lebar kolom label di mobile */
@media (min-width:768px){ :root { --kv-label-w: 34%; } }

.kv-table-wrap{ border:1px solid #eef0f3; border-radius:14px; overflow:hidden; }
.kv-table{ width:100%; margin:0; border-collapse:separate; border-spacing:0; table-layout:fixed; }
.kv-table th.kv-label{
  width:var(--kv-label-w); background:#fafbfc; color:#374151; font-weight:700;
  padding:.6rem .75rem; vertical-align:top; white-space:nowrap;
}
.kv-table td.kv-value{ background:#fff; padding:.6rem .75rem; vertical-align:top; }
.kv-table tr + tr th.kv-label, .kv-table tr + tr td.kv-value{ border-top:1px dashed #e5e7eb; }

/* boleh bungkus kata, tapi JANGAN pecah setiap karakter (penyebab NIK turun) */
.kv-table th, .kv-table td{ word-break:normal; overflow-wrap:anywhere; }
.kv-table code{ white-space:nowrap; word-break:normal; }   /* <- stop pecah per karakter */

/* Mobile: tetap 2 kolom, KECUALI baris dg .kv-stack-mobile */
@media (max-width:576px){
  .kv-table tr{ display:table-row !important; }
  .kv-table th.kv-label, .kv-table td.kv-value{ display:table-cell !important; }

  /* Baris berat (tabel pendamping, uploader, dll) dibuat full-width/stack */
  .kv-table tr.kv-stack-mobile{ display:block !important; }
  .kv-table tr.kv-stack-mobile > th.kv-label,
  .kv-table tr.kv-stack-mobile > td.kv-value{
    display:block !important; width:100% !important;
    padding-left:.65rem; padding-right:.65rem;
  }
  .kv-table tr.kv-stack-mobile > th.kv-label{ background:transparent; color:#6b7280; }
  .kv-table tr.kv-stack-mobile > td.kv-value{ background:transparent; }

  /* Tabel pendamping: biar bisa scroll hor di layar sempit, dan NIK jangan pecah */
  .kv-value .table-responsive{ margin-top:.35rem; }
  .pendamping-table th, .pendamping-table td{ white-space:nowrap; }
  .pendamping-table code{ white-space:nowrap; word-break:normal; }
}
</style>

<div class="container-fluid">
  <div class="hero-title" role="banner" aria-label="Judul situs">
    <h1 class="text"><?php echo htmlspecialchars($booking->nama_tamu ?? '-', ENT_QUOTES, 'UTF-8'); ?></h1>
    <span class="accent" aria-hidden="true"></span>
  </div>

  <div class="row mt-3">
    <div class="col-lg-12">

<?php if (!empty($booking)): ?>
<?php
  $kode = htmlspecialchars($booking->kode_booking, ENT_QUOTES, 'UTF-8');

  // Unit tujuan (fallback via DB jika belum dipass dari controller)
  $unit_nama = isset($unit_nama)
    ? $unit_nama
    : $this->db->select('nama_unit')->get_where('unit_tujuan', ['id'=>$booking->unit_tujuan])->row('nama_unit');
  $unit_nama = htmlspecialchars($unit_nama ?: '-', ENT_QUOTES, 'UTF-8');

  // Badge status
  $st = strtolower((string)($booking->status ?? ''));
  $badgeMap = [
    'pending'=>'pill-warning','approved'=>'pill-primary',
    'checked_in'=>'pill-info','checked_out'=>'pill-success',
    'expired'=>'pill-secondary','rejected'=>'pill-danger',
  ];
  $badgeCls = $badgeMap[$st] ?? 'pill-secondary';

  // QR
  $qr_file   = 'uploads/qr/qr_'.($booking->kode_booking ?? '').'.png';
  $qr_exists = is_file(FCPATH.$qr_file);
  $qr_url    = base_url($qr_file);

  // Surat & Foto
  $surat_url = !empty($booking->surat_tugas) ? base_url('uploads/surat_tugas/'.rawurlencode(basename($booking->surat_tugas))) : null;
  $foto_url  = !empty($booking->foto)        ? base_url('uploads/foto/'.rawurlencode(basename($booking->foto)))              : null;

  $instansi  = !empty($booking->target_instansi_nama) ? $booking->target_instansi_nama : ($booking->instansi ?? '-');
  $instansi  = htmlspecialchars($instansi, ENT_QUOTES, 'UTF-8');
  $nama_petugas_instansi = !empty($booking->nama_petugas_instansi) ? $booking->nama_petugas_instansi : '-';
  $nama_petugas_instansi = htmlspecialchars($nama_petugas_instansi, ENT_QUOTES, 'UTF-8');

  $kode_safe = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $booking->kode_booking ?? '');

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
  if (!empty($booking->checkin_at)) $checkin_str  = hari_id($booking->checkin_at).', '.date('d-m-Y H:i', strtotime($booking->checkin_at));
  $checkout_str = '';
  if (!empty($booking->checkout_at)) $checkout_str = hari_id($booking->checkout_at).', '.date('d-m-Y H:i', strtotime($booking->checkout_at));

  // Daftar pendamping
  $pendamping_rows = $this->db
      ->order_by('id_pendamping','ASC')
      ->get_where('booking_pendamping', ['kode_booking' => $booking->kode_booking])
      ->result();

  // Durasi
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

  // No HP WA
  $hp_wa = preg_replace('/\D+/', '', (string)($booking->no_hp ?? ''));

  // ====== Hak edit permohonan (DINAMIS dari $batas_edit & $batas_hari) ======
  $batas_edit_view = isset($batas_edit) ? (int)$batas_edit : 1; // dari controller
  $batas_hari_view = isset($batas_hari) ? (int)$batas_hari : 2; // dari controller

  $edit_count = isset($booking->edit_count) ? (int)$booking->edit_count : 0;

  $today = new DateTime('today');
  $days_left = null;
  $allow_by_hari = true;
  if (!empty($booking->tanggal)) {
    try {
      $visit = new DateTime(date('Y-m-d', strtotime($booking->tanggal)));
      $days_left = (int)$today->diff($visit)->format('%r%a'); // negatif kalau lewat
      $allow_by_hari = ($days_left >= $batas_hari_view);
    } catch (Throwable $e) { $allow_by_hari = false; }
  }

  // batas_edit = 0 → fitur edit dimatikan
  $allow_by_count = ($batas_edit_view === 0) ? false : ($edit_count < $batas_edit_view);
  $can_edit = ($batas_edit_view > 0) && $allow_by_hari && $allow_by_count;

  $edit_reason = [];
  if ($batas_edit_view === 0)      $edit_reason[] = 'Fitur ubah dimatikan';
  if (!$allow_by_hari)             $edit_reason[] = 'Lewat batas waktu (≥ H-'.$batas_hari_view.')';
  if (!$allow_by_count)            $edit_reason[] = 'Batas perubahan tercapai ('.$edit_count.'/'.$batas_edit_view.')';

  $edit_title = $can_edit ? '' : implode(' • ', $edit_reason);
  $edit_url   = site_url('booking/edit').'?t='.urlencode($booking->access_token ?? '');
?>

<div class="card kv-card shadow-sm mb-3">
  <div class="card-body">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center kv-head pb-3 mb-3">
      <div class="d-flex align-items-center" style="gap:1rem;">
        <h4 class="mb-0 section-title">Detail Booking</h4>
        <div class="d-flex align-items-center flex-wrap" style="gap:.5rem;">
          <span class="pill <?= $badgeCls ?> text-uppercase"><?= htmlspecialchars($booking->status ?? '-', ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- ====== KIRI ====== -->
      <div class="col-md-7">
        <div class="table-responsive kv-table-wrap">
  <table class="table table-sm kv-table">
    <colgroup>
      <col style="width:var(--kv-label-w)">
      <col>
    </colgroup>
    <tbody>
      <!-- contoh baris biasa: label kiri, isi kanan -->
      <tr>
        <th class="kv-label">🔑 Kode</th>
        <td class="kv-value">
          <span class="chip mr-2"><span class="dot"></span><span><?= html_escape($kode) ?></span></span>
          <button class="btn btn-light btn-sm btn-copy" data-clip="<?= html_escape($kode) ?>">
            <i class="mdi mdi-content-copy"></i>
          </button>
        </td>
      </tr>

      <tr><th class="kv-label">👤 Nama Tamu</th><td class="kv-value"><?= html_escape($booking->nama_tamu) ?></td></tr>
      <tr><th class="kv-label">🧑‍💼 Jabatan</th><td class="kv-value"><?= html_escape($booking->jabatan) ?></td></tr>

      <tr>
        <th class="kv-label">🪪 NIK</th>
        <td class="kv-value">
          <code><?= html_escape($booking->nik) ?></code>
          <button class="btn btn-light btn-sm btn-copy ml-1" data-clip="<?= html_escape($booking->nik) ?>">
            <i class="mdi mdi-content-copy"></i>
          </button>
        </td>
      </tr>

      <tr><th class="kv-label">📍 Alamat</th><td class="kv-value"><?= html_escape($booking->alamat) ?></td></tr>
      <tr><th class="kv-label">🎂 Tempat/Tanggal Lahir</th><td class="kv-value"><?= html_escape($booking->tempat_lahir.", ".tgl_view($booking->tanggal_lahir)) ?></td></tr>

      <tr>
        <th class="kv-label">📱 No. HP</th>
        <td class="kv-value">
          <?= html_escape($booking->no_hp) ?>
          <?php if ($hp_wa): ?>
            <a class="btn btn-light btn-sm ml-1" target="_blank" rel="noopener" href="https://wa.me/<?= $hp_wa ?>">
              <i class="mdi mdi-whatsapp"></i>
            </a>
          <?php endif; ?>
        </td>
      </tr>

      <tr><th class="kv-label"><i class="mdi mdi-email-outline"></i> Email</th><td class="kv-value"><?= html_escape($booking->email) ?></td></tr>
      <tr><th class="kv-label">🏢 Instansi Asal</th><td class="kv-value"><?= $instansi ?></td></tr>
      <tr><th class="kv-label">🎯 Unit Tujuan</th><td class="kv-value"><?= $unit_nama ?></td></tr>
      <tr><th class="kv-label">🏷️ Nama <?= $unit_nama ?></th><td class="kv-value"><?= $nama_petugas_instansi ?></td></tr>

      <tr><th class="kv-label">📝 Keperluan</th><td class="kv-value"><div class="longtext"><?= html_escape($booking->keperluan) ?></div></td></tr>
      <tr><th class="kv-label">📅 Tanggal Kunjungan</th><td class="kv-value"><?= $hari_tgl ?></td></tr>
      <tr><th class="kv-label">⏰ Jam</th><td class="kv-value"><?= $jam ?></td></tr>

      <tr>
        <th class="kv-label">👥 Jumlah Pendamping</th>
        <td class="kv-value"><span class="badge badge-pill badge-primary" style="font-size:.9rem;"><?= (int)$booking->jumlah_pendamping ?> orang</span></td>
      </tr>

      <?php if (!empty($pendamping_rows)): ?>
      <!-- ===== Daftar Pendamping — STACK di mobile agar lebar penuh ===== -->
      <tr class="kv-stack-mobile">
        <th class="kv-label">👥 Daftar Pendamping</th>
        <td class="kv-value">
          <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0 pendamping-table">
              <thead class="thead-light">
                <tr><th style="width:60px;">No</th><th style="width:200px;">NIK</th><th>Nama</th></tr>
              </thead>
              <tbody>
                <?php foreach ($pendamping_rows as $i => $p): ?>
                <tr>
                  <td class="text-center"><?= $i+1 ?></td>
                  <td><code><?= html_escape($p->nik) ?></code></td>
                  <td><?= html_escape($p->nama) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
      <?php elseif ((int)$booking->jumlah_pendamping > 0): ?>
      <tr class="kv-stack-mobile">
        <th class="kv-label">👥 Daftar Pendamping</th>
        <td class="kv-value soft">Belum ada data pendamping.</td>
      </tr>
      <?php endif; ?>

      <?php if ($checkin_str): ?><tr><th class="kv-label">🕘 Check-in</th><td class="kv-value"><?= html_escape($checkin_str) ?></td></tr><?php endif; ?>
      <?php if ($checkout_str): ?><tr><th class="kv-label">🕙 Check-out</th><td class="kv-value"><?= html_escape($checkout_str) ?></td></tr><?php endif; ?>
      <?php if ($durasi): ?><tr><th class="kv-label">⏳ Durasi</th><td class="kv-value"><?= html_escape($durasi) ?></td></tr><?php endif; ?>

      <!-- ===== Surat Tugas — STACK di mobile ===== -->
      <tr class="kv-stack-mobile">
        <th class="kv-label">📄 Surat Tugas</th>
        <td class="kv-value">
          <div id="surat_actions" class="mb-2">
            <?php if ($surat_url): ?>
              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalSuratTugas_<?= $kode_safe ?>"><i class="mdi mdi-file-pdf-box"></i> Lihat</button>
              <a class="btn btn-sm btn-outline-secondary ml-1" href="<?= $surat_url ?>" download><i class="mdi mdi-download"></i> Unduh</a>
            <?php else: ?>
              <span class="soft" id="surat_empty">Belum ada surat tugas.</span>
            <?php endif; ?>
          </div>

          <input type="hidden" id="kode_booking" value="<?= html_escape($booking->kode_booking) ?>">

          <div class="form-group mb-2 d-flex align-items-center" style="gap:.5rem;">
            <input type="file" id="doc_surat" accept="application/pdf,image/*" class="d-none">
            <button type="button" id="btnPickSurat" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-file-upload-outline"></i> Pilih Berkas (PDF/JPG/PNG)</button>
            <small id="pickSuratLabel" class="text-muted">Belum ada file</small>
          </div>

          <div id="surat_preview_wrap" class="mb-2" style="display:none;">
            <img id="surat_preview_img" alt="Preview Surat Tugas" style="max-width:100%;border:1px solid #e5e7eb;border-radius:8px;display:none;">
            <div id="surat_preview_pdf" style="display:none;border:1px solid #e5e7eb;border-radius:8px;">
              <div class="p-2 d-flex align-items-center justify-content-between">
                <span><i class="mdi mdi-file-pdf-box"></i> <strong>PDF terpilih</strong></span>
                <small class="text-muted">Pratinjau PDF terbatas di sebagian perangkat</small>
              </div>
              <embed id="surat_pdf_embed" type="application/pdf" width="100%" height="520px" style="border-top:1px solid #e5e7eb;">
            </div>
          </div>

          <div class="d-flex align-items-center" style="gap:.5rem;">
            <button type="button" id="btnSuratUpload" class="btn btn-blue btn-sm" disabled><i class="mdi mdi-cloud-upload"></i> Upload</button>
            <button type="button" id="btnSuratReset" class="btn btn-light btn-sm" style="display:none;"><i class="mdi mdi-close-circle-outline"></i> Batal</button>
            <small id="surat_status" class="text-muted ms-2"></small>
          </div>
        </td>
      </tr>

      <!-- ===== Foto — STACK di mobile ===== -->
      <tr class="kv-stack-mobile" id="row_foto">
        <th class="kv-label">🖼️ Foto</th>
        <td class="kv-value" id="col_foto">
          <div id="foto_actions" class="mb-2">
            <?php if (!empty($foto_url)): ?>
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFoto_<?= $kode_safe ?>"><i class="mdi mdi-eye"></i> Lihat</button>
              <a href="<?= $foto_url ?>" download class="btn btn-outline-secondary btn-sm ml-1"><i class="mdi mdi-download"></i> Unduh</a>
            <?php else: ?>
              <span class="soft" id="foto_empty">Belum ada dokumentasi. Foto dapat dilakukan saat check-in.</span>
            <?php endif; ?>
          </div>

          <div class="form-group mb-2 d-flex align-items-center" style="gap:.5rem;">
            <input type="file" id="doc_photo" accept="image/*" capture="environment" class="d-none">
            <button type="button" id="btnPick" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-image-plus"></i> Ambil / Pilih Foto</button>
            <small id="pickLabel" class="text-muted">Belum ada file</small>
          </div>

          <div id="doc_preview_wrap" class="mb-2" style="display:none;">
            <img id="doc_preview" alt="Preview" style="max-width:100%;border:1px solid #e5e7eb;border-radius:8px;">
          </div>

          <div class="d-flex align-items-center" style="gap:.5rem;">
            <button type="button" id="btnDocUpload" class="btn btn-primary btn-sm" disabled><i class="mdi mdi-cloud-upload"></i> Upload</button>
            <button type="button" id="btnDocReset" class="btn btn-light btn-sm" style="display:none;"><i class="mdi mdi-close-circle-outline"></i> Batal</button>
            <small id="doc_status" class="text-muted ms-2"></small>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

        <!-- Modal Surat Tugas -->
        <div class="modal fade" id="modalSuratTugas_<?= $kode_safe ?>" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header py-2">
                <h6 class="modal-title"><i class="mdi mdi-file-document"></i> Surat Tugas</h6>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
              </div>
              <div class="modal-body p-0" id="surat_modal_body">
                <?php if (!empty($surat_url)): ?>
                  <?php if ($is_pdf): ?>
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="<?= $surat_url ?>#toolbar=1&navpanes=0&scrollbar=1" allowfullscreen></iframe>
                    </div>
                  <?php elseif ($is_img): ?>
                    <img src="<?= $surat_url ?>" class="img-fluid" alt="Surat Tugas">
                  <?php else: ?>
                    <div class="p-4">Format file tidak didukung untuk pratinjau. Silakan unduh.</div>
                  <?php endif; ?>
                <?php else: ?>
                  <div class="p-4 text-muted">Belum ada surat tugas. Silakan unggah dulu.</div>
                <?php endif; ?>
              </div>
              <div class="modal-footer py-2">
                <?php if (!empty($surat_url)): ?>
                  <a class="btn btn-outline-secondary" href="<?= $surat_url ?>" download><i class="mdi mdi-download"></i> Unduh</a>
                <?php endif; ?>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Foto -->
        <div class="modal fade" id="modalFoto_<?= $kode_safe ?>" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header py-2">
                <h6 class="modal-title"><i class="mdi mdi-image"></i> Foto Lampiran</h6>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
              </div>
              <div class="modal-body text-center">
                <img id="foto_modal_img" src="<?= $foto_url ?? '' ?>" class="img-fluid" style="max-height:75vh" alt="Foto Lampiran">
              </div>
              <div class="modal-footer py-2">
                <a id="foto_modal_download" class="btn btn-outline-secondary" href="<?= !empty($foto_url)?$foto_url:'#' ?>" download style="<?= !empty($foto_url)?'':'display:none' ?>">
                  <i class="mdi mdi-download"></i> Unduh
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>

      </div><!-- /col-md-7 -->

      <!-- ====== KANAN ====== -->
      <div class="col-md-5 mt-3 mt-md-0">
        <div class="border rounded p-3 text-center mb-3">
          <div class="kv-label mb-2"><i class="mdi mdi-qrcode"></i> QR Code Booking</div>
          <?php if ($qr_exists): ?>
            <div class="qr-wrap"><img src="<?= $qr_url ?>" alt="QR Booking <?= $kode ?>" class="img-fluid" loading="lazy"/></div>
            <div class="mt-2"><a href="<?= $qr_url ?>" download="qr_<?= $kode ?>.png" class="btn btn-sm btn-outline-success"><i class="mdi mdi-download"></i> Unduh QR</a></div>
          <?php else: ?>
            <div class="text-muted small">QR belum tersedia.</div>
          <?php endif; ?>
        </div>

        <!-- Tombol Lihat / Unduh PDF -->
        <div class="d-flex flex-wrap mt-3" style="gap:.5rem;">
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalPDF_<?= $kode_safe ?>"><i class="mdi mdi-file-pdf-box"></i> Lihat</button>
          <a href="<?= site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?= urlencode($booking->access_token ?? '') ?>&dl=1" class="btn btn-danger"><i class="mdi mdi-download"></i> Unduh</a>
        </div>

        <!-- Tombol Edit / Hapus -->
        <div class="mt-2">
          <?php
            $reason_str = $can_edit ? '' : ($edit_title ?: 'Tidak memenuhi syarat.');
            $days_left_txt = is_int($days_left) ? (string)$days_left : '';
          ?>
          <a id="btnEditBooking"
             href="<?= $edit_url ?>"
             class="btn btn-warning"
             data-can-edit="<?= $can_edit ? '1':'0' ?>"
             data-reason="<?= htmlspecialchars($reason_str, ENT_QUOTES, 'UTF-8') ?>"
             data-batas-edit="<?= (int)$batas_edit_view ?>"
             data-batas-hari="<?= (int)$batas_hari_view ?>"
             data-edit-count="<?= (int)$edit_count ?>"
             data-days-left="<?= htmlspecialchars($days_left_txt, ENT_QUOTES, 'UTF-8') ?>">
             <i class="mdi mdi-square-edit-outline"></i> Edit Permohonan
          </a>
          <div class="small text-muted mt-1">
            <?php if ((int)$batas_edit_view === 0): ?>
              <code>Fitur ubah permohonan saat ini dinonaktifkan.</code>
            <?php else: ?>
              <code>Anda dapat mengubah permohonan maksimal <b><?= (int)$batas_edit_view ?> kali</b> dan maksimal <b><?= (int)$batas_hari_view ?> hari</b> sebelum Hari <strong><?= $hari_tgl ?></strong>.</code>
            <?php endif; ?>
          </div>

          <?php if (!$can_edit && $edit_title): ?>
            <div class="text-dark small mt-1">
              Alasan nonaktif: <?= htmlspecialchars($edit_title, ENT_QUOTES, 'UTF-8') ?><?= is_int($days_left) ? ' (sisa '.$days_left.' hari)' : '' ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="mt-1">
          <button id="btnDeleteBooking"
                  type="button"
                  class="btn btn-outline-danger"
                  data-kode="<?= htmlspecialchars($booking->kode_booking, ENT_QUOTES, 'UTF-8') ?>"
                  data-token="<?= htmlspecialchars($booking->access_token ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <i class="mdi mdi-trash-can-outline"></i> Hapus Permohonan
          </button>
        </div>

        <!-- Modal PDF -->
        <div class="modal fade" id="modalPDF_<?= $kode_safe ?>" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header py-2">
                <h5 class="modal-title mb-0">Pratinjau PDF – <?= $kode ?></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
              </div>
              <div class="modal-body p-0" style="background:#f8f9fa;">
                <iframe src="<?= site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?= urlencode($booking->access_token ?? '') ?>&dl=0#view=FitH" style="width:100%; height:80vh; border:0;"></iframe>
              </div>
              <div class="modal-footer py-2">
                <a href="<?= site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?= urlencode($booking->access_token ?? '') ?>&dl=1" class="btn btn-danger"><i class="mdi mdi-download"></i> Unduh PDF</a>
                <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>

        <div class="p-3 bg-light rounded mt-3">
          <div class="kv-label mb-2"><i class="mdi mdi-information-outline"></i> Catatan</div>
          <ul class="mb-0 pl-3">
            <li>Check-in <?php echo (int)($rec->early_min ?? 30) ?> menit sebelum jadwal.</li>
            <li>Bawa KTP asli & identitas instansi.</li>
            <li>Tunjukkan QR saat check-in.</li>
            <li>Unduh & simpan berkas agar tidak hilang.</li>
          </ul>
        </div>
      </div>
    </div><!-- /row -->
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
// helper tambah CSRF ke FormData
function addCSRF(fd){
  <?php if (config_item('csrf_protection')): ?>
    fd.set('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
  <?php endif; ?>
  return fd;
}
</script>

<script>
// Kirim notifikasi WA sekali saat halaman dibuka
document.addEventListener('DOMContentLoaded', function () {
  var token = <?= json_encode($booking->access_token ?? null) ?>;
  if (!token) return;

  var guardKey = 'wa_notified_' + token;
  if (sessionStorage.getItem(guardKey)) return;

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
  })
  .then(function(res){ 
    if (res.ok) sessionStorage.setItem(guardKey, '1');
    return res.ok ? res.json() : null;
  })
  .catch(function(){});
});
</script>

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
</script>

<!-- ====== Uploader Foto (SATU SAJA) ====== -->
<script>
(function() {
  const MAX_BYTES = 1.5 * 1024 * 1024;  // 1.5MB
  const MAX_SIDE  = 1600;               // sisi terpanjang saat resize

  const el = {
    kode: document.getElementById('kode_booking'),
    input: document.getElementById('doc_photo'),
    btnPick: document.getElementById('btnPick'),
    previewWrap: document.getElementById('doc_preview_wrap'),
    preview: document.getElementById('doc_preview'),
    btnUpload: document.getElementById('btnDocUpload'),
    btnReset: document.getElementById('btnDocReset'),
    label: document.getElementById('pickLabel'),
    status: document.getElementById('doc_status'),
    gallery: document.getElementById('doc_gallery')
  };

  let dataURL = null;

  if (!el.input) return;

  el.btnPick.addEventListener('click', () => el.input.click());
  el.btnReset.addEventListener('click', resetAll);
  el.input.addEventListener('change', handlePick);
  el.btnUpload.addEventListener('click', doUpload);

  function resetAll() {
    el.input.value = '';
    dataURL = null;
    el.preview.src = '';
    el.previewWrap.style.display = 'none';
    el.btnUpload.disabled = true;
    el.btnReset.style.display = 'none';
    el.label.textContent = 'Belum ada file';
    setStatus('');
  }

  async function handlePick(e) {
    const file = e.target.files?.[0];
    if (!file) { resetAll(); return; }
    if (!/^image\/(jpeg|png)$/i.test(file.type)) { setStatus('Hanya JPG/PNG.', true); resetAll(); return; }

    el.label.textContent = file.name;

    try {
      const out = await fileToCompressedDataURL(file, MAX_SIDE, MAX_BYTES);
      dataURL = out.dataURL;
      el.preview.src = dataURL;
      el.previewWrap.style.display = 'block';
      el.btnUpload.disabled = false;
      el.btnReset.style.display = 'inline-block';
      setStatus(`Siap diupload (${fmtBytes(out.bytes)}, ${out.width}×${out.height})`);
    } catch (err) {
      setStatus(err.message || 'Gagal memproses gambar', true);
      resetAll();
    }
  }

  async function doUpload() {
    const kode = (document.getElementById('kode_booking')?.value || '').trim();
    if (!kode) { setStatus('Kode booking kosong.', true); return; }

    const rawFile = el.input?.files?.[0] || null;
    if (!dataURL && !rawFile) { setStatus('Tidak ada gambar.', true); return; }

    lock(true, 'Mengunggah...');

    try {
      let fd = new FormData();
      fd.append('kode', kode);

      if (dataURL) {
        const blob = dataURLtoBlob(dataURL);
        const name = (rawFile?.name || 'foto.jpg').replace(/\.[^.]+$/, '.jpg');
        fd.append('doc_photo', blob, name);
      } else {
        fd.append('doc_photo', rawFile, rawFile.name);
      }

      fd = addCSRF(fd); // penting!

      const res = await fetch('<?= site_url("booking/upload_dokumentasi") ?>', {
        method: 'POST',
        body: fd,
        credentials: 'same-origin',
        headers: {'X-Requested-With':'XMLHttpRequest'}
      });

      const json = await res.json().catch(()=> ({}));
      if (!res.ok || !json.ok) throw new Error(json?.msg || `HTTP ${res.status}`);

      toastOK('Upload berhasil');
      setStatus('Berhasil diupload.');
      if (json.url) { updateFotoSection(json.url); appendToGallery(json.url); }
      resetAll();
    } catch (e) {
      setStatus(e.message || 'Upload gagal', true);
    } finally {
      lock(false);
    }
  }

  function dataURLtoBlob(dUrl) {
    const arr = dUrl.split(',');
    const mime = (arr[0].match(/:(.*?);/)||[])[1] || 'image/jpeg';
    const bstr = atob(arr[1]); let n = bstr.length; const u8 = new Uint8Array(n);
    while (n--) u8[n] = bstr.charCodeAt(n);
    return new Blob([u8], {type: mime});
  }

  function lock(state, text) {
    el.btnUpload.disabled = state; el.btnPick.disabled = state; el.btnReset.disabled = state;
    el.btnUpload.innerHTML = state ? '<span class="spinner-border spinner-border-sm me-1"></span>'+text : '<i class="mdi mdi-cloud-upload"></i> Upload';
  }

  function setStatus(msg, isErr=false) {
    el.status.textContent = msg;
    el.status.classList.toggle('text-danger', !!isErr);
    el.status.classList.toggle('text-muted', !isErr);
  }

  function appendToGallery(url) {
    const col = document.createElement('div'); col.className = 'col-auto'; col.style.padding = '0';
    col.innerHTML = `<a href="${url}" target="_blank" title="Lihat"><img src="${url}" style="width:110px;height:110px;object-fit:cover;border-radius:10px;border:1px solid #e5e7eb"></a>`;
    el.gallery?.appendChild(col);
  }

  function fileToCompressedDataURL(file, maxSide, maxBytes) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = () => {
        const img = new Image();
        img.onload = () => {
          const scale = Math.min(1, maxSide / Math.max(img.width, img.height));
          const w = Math.max(1, Math.floor(img.width * scale));
          const h = Math.max(1, Math.floor(img.height * scale));

          const cvs = document.createElement('canvas'); cvs.width = w; cvs.height = h;
          const ctx = cvs.getContext('2d'); ctx.fillStyle = '#ffffff'; ctx.fillRect(0,0,w,h);
          ctx.drawImage(img, 0, 0, w, h);

          let q = 0.92, out = cvs.toDataURL('image/jpeg', q);
          while (dataURLBytes(out) > maxBytes && q > 0.5) { q -= 0.07; out = cvs.toDataURL('image/jpeg', q); }
          const bytes = dataURLBytes(out);
          if (bytes > maxBytes) reject(new Error('Gambar terlalu besar setelah kompres. Coba ambil ulang dengan resolusi lebih rendah.'));
          else resolve({ dataURL: out, width: w, height: h, bytes });
        };
        img.onerror = () => reject(new Error('Gagal membaca gambar.'));
        img.src = reader.result;
      };
      reader.onerror = () => reject(new Error('Gagal membaca berkas.'));
      reader.readAsDataURL(file);
    });
  }

  function dataURLBytes(dUrl) {
    const base64 = dUrl.split(',')[1] || ''; let len = base64.length;
    if (base64.endsWith('==')) len -= 2; else if (base64.endsWith('=')) len -= 1;
    return Math.floor(len * 3/4);
  }
  function fmtBytes(n) { return n > 1024*1024 ? (n/1024/1024).toFixed(2)+' MB' : (n/1024).toFixed(0)+' KB'; }
})();
</script>

<!-- Toast + Updater Foto -->
<script>
function toastOK(msg='Upload berhasil') {
  let wrap = document.getElementById('toast-wrap');
  if (!wrap) {
    wrap = document.createElement('div'); wrap.id = 'toast-wrap';
    wrap.style.position = 'fixed'; wrap.style.top = '16px'; wrap.style.right = '16px'; wrap.style.zIndex = 1080;
    document.body.appendChild(wrap);
  }
  const el = document.createElement('div');
  el.style.background = '#10b981'; el.style.color = '#fff'; el.style.padding = '10px 14px';
  el.style.borderRadius = '10px'; el.style.marginTop = '8px'; el.style.boxShadow = '0 6px 18px rgba(0,0,0,.12)';
  el.style.display = 'flex'; el.style.alignItems = 'center'; el.style.gap = '.5rem';
  el.innerHTML = '<i class="mdi mdi-check-circle-outline"></i><span>'+msg+'</span>';
  wrap.appendChild(el);
  setTimeout(()=>{ el.style.opacity='0'; el.style.transition='opacity .35s'; setTimeout(()=>el.remove(), 350); }, 1600);
}
function updateFotoSection(url) {
  const bust = url + (url.includes('?') ? '&' : '?') + 'v=' + Date.now();
  const actions = document.getElementById('foto_actions');
  if (actions) {
    actions.innerHTML = `
      <div class="upload-actions">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFoto_<?= $kode_safe ?>"><i class="mdi mdi-eye"></i> Lihat</button>
        <a class="btn btn-outline-secondary btn-sm ml-1" href="${bust}" download><i class="mdi mdi-download"></i> Unduh</a>
      </div>`;
  }
  const mImg  = document.getElementById('foto_modal_img');
  const mDown = document.getElementById('foto_modal_download');
  if (mImg)  mImg.src  = bust;
  if (mDown) { mDown.href = bust; mDown.style.display = ''; }
}
</script>

<!-- Unifikasi handler modal/backdrop -->
<script>
  $(function () {
    var ids = [
      '#modalPDF_<?= $kode_safe ?>',
      '#modalSuratTugas_<?= $kode_safe ?>',
      '#modalFoto_<?= $kode_safe ?>'
    ];
    var openCount = 0;
    ids.forEach(function(sel){
      var $m = $(sel); if (!$m.length) return;
      $m.appendTo('body');
      $m.on('show.bs.modal', function(){
        if (++openCount === 1) $('body').addClass('noblur-backdrop');
        setTimeout(function(){
          $('.modal-backdrop').last().css({
            'backdrop-filter':'none','-webkit-backdrop-filter':'none','filter':'none',
            'background':'rgba(0,0,0,.55)','z-index': 2040,'position':'fixed'
          });
        }, 0);
      });
      $m.on('hidden.bs.modal', function(){
        if (--openCount <= 0) { openCount = 0; $('body').removeClass('noblur-backdrop'); }
      });
    });
  });
</script>

<!-- Loader dengan hitung mundur untuk unduh PDF -->
<script>
(function () {
  const pdfLinks = document.querySelectorAll('a[href*="booking/print_pdf"][href*="dl=1"]');
  if (!pdfLinks.length) return;

  function showLoader(arg1, arg2) {
    var seconds = 10;
    var message = (typeof arg1 === 'number') ? (arg2 || ('Mohon tunggu sekitar ' + Math.max(1, Math.floor(arg1)) + ' detik')) : (arg1 || 'Mohon tunggu sekitar ' + seconds + ' detik');
    var remain = seconds, timerId = null;
    Swal.fire({
      title: 'Menyiapkan PDF…',
      html: '<div style="font-size:14px;line-height:1.5;">' + (message ? ('<div style="margin-bottom:6px;">' + message + '</div>') : '') + 'Sisa waktu: <b id="swal-countdown">' + remain + '</b> detik</div>',
      allowOutsideClick: false, showConfirmButton: false,
      didOpen: function () {
        Swal.showLoading();
        var el = Swal.getHtmlContainer().querySelector('#swal-countdown');
        timerId = setInterval(function () {
          remain -= 1; if (remain <= 0) { clearInterval(timerId); timerId = null; if (el) el.textContent = '0'; return; }
          if (el) el.textContent = String(remain);
        }, 1000);
      },
      willClose: function () { if (timerId) { clearInterval(timerId); timerId = null; } }
    });
  }
  function hideLoader() { try { Swal.close(); } catch(e) {} }

  let iframe = document.getElementById('pdfDLFrame');
  if (!iframe) { iframe = document.createElement('iframe'); iframe.id = 'pdfDLFrame'; iframe.style.display = 'none'; document.body.appendChild(iframe); }

  let fallbackTimer = null;
  iframe.addEventListener('load', function () { clearTimeout(fallbackTimer); hideLoader(); });

  pdfLinks.forEach(a => {
    a.classList.add('js-download-pdf');
    a.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href'); if (!href) return;
      showLoader('File sedang dibuat, Tunggu 10 detik');
      const url = href + (href.indexOf('?') >= 0 ? '&' : '?') + 'ts=' + Date.now();
      iframe.src = url;
      clearTimeout(fallbackTimer); fallbackTimer = setTimeout(hideLoader, 10000);
    }, { passive: false });
  });

  document.addEventListener('hidden.bs.modal', function () { hideLoader(); });
})();
</script>

<!-- Edit/Hapus -->
<script>
(function(){
  var btn = document.getElementById('btnEditBooking');
  if (!btn) return;

  btn.addEventListener('click', function(e){
    e.preventDefault();

    var href        = this.getAttribute('href') || '#';
    var canEdit     = this.getAttribute('data-can-edit') === '1';
    var reason      = (this.getAttribute('data-reason') || '').trim();
    var batasEdit   = parseInt(this.getAttribute('data-batas-edit') || '0', 10);
    var batasHari   = parseInt(this.getAttribute('data-batas-hari') || '0', 10);
    var editCount   = parseInt(this.getAttribute('data-edit-count') || '0', 10);
    var daysLeft    = this.getAttribute('data-days-left');

    if (!canEdit) {
      var msg =
        '<div style="text-align:left;line-height:1.5;">'
        + '<b>Tidak dapat mengubah.</b><br>'
        + (reason ? (reason + '<br>') : '')
        + 'Pertimbangkan untuk <b>menghapus permohonan ini</b> lalu membuat booking baru.'
        + (daysLeft !== '' ? ('<br><small>(Sisa ' + daysLeft + ' hari menuju jadwal)</small>') : '')
        + '</div>';
      Swal.fire({ icon:'warning', title:'Edit tidak tersedia', html: msg, confirmButtonText:'Mengerti' });
      return;
    }

    var sisaEdit = (batasEdit > 0) ? (batasEdit - editCount) : 0;
    Swal.fire({
      icon: 'info',
      title: 'Lanjut ubah permohonan?',
      html:
        '<div style="text-align:left;line-height:1.5;">'
        + 'Anda masih dapat mengubah permohonan ini.'
        + (batasEdit > 0 ? ('<br>Sisa kesempatan edit: <b>' + sisaEdit + '</b> dari ' + batasEdit + '.') : '')
        + (batasHari > 0 ? ('<br>Batas waktu pengubahan: maksimal H-' + batasHari + '.') : '')
        + '</div>',
      showCancelButton: true,
      cancelButtonText: 'Batal',
      confirmButtonText: 'Lanjut ke Form Edit'
    }).then(function(res){
      if (res.isConfirmed) { window.location.href = href; }
    });
  });
})();
</script>

<script>
(function(){
  var btn = document.getElementById('btnDeleteBooking');
  if (!btn) return;

  btn.addEventListener('click', function(){
    var kode  = this.getAttribute('data-kode') || '';
    var token = this.getAttribute('data-token') || '';

    if (!token || !kode) {
      Swal.fire({icon:'error', title:'Gagal', text:'Token atau kode booking tidak ditemukan.'});
      return;
    }

    Swal.fire({
      icon: 'warning',
      title: 'Hapus permohonan?',
      html:
        '<div style="text-align:left;line-height:1.5;">'
        + 'Tindakan ini akan <b>menghapus permanen</b> data permohonan beserta pendamping dan lampiran terkait.'
        + '<br>Anda yakin ingin melanjutkan?'
        + '</div>',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function(res){
      if (!res.isConfirmed) return;

      var form = new FormData();
      form.set('t', token);
      form.set('kode', kode);
      <?php if (config_item('csrf_protection')): ?>
        form.set('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
      <?php endif; ?>

      Swal.fire({title:'Menghapus…', didOpen:()=>Swal.showLoading(), allowOutsideClick:false, showConfirmButton:false});

      fetch('<?= site_url("booking/hapus") ?>', { method:'POST', body:form, credentials:'same-origin' })
        .then(r => r.json().catch(()=>null).then(j => ({ok:r.ok, status:r.status, json:j})))
        .then(({ok,status,json})=>{
          Swal.close();
          if (!ok || !json || !json.ok) {
            var emsg = (json && json.msg) ? json.msg : ('HTTP ' + status);
            Swal.fire({icon:'error', title:'Gagal menghapus', html:emsg});
            return;
          }

          Swal.fire({icon:'success', title:'Permohonan dihapus', text:'Data telah dihapus.'});
          var container = document.querySelector('.container-fluid .row.mt-3 .col-lg-12');
          if (container) {
            container.innerHTML =
              '<div class="py-5 my-3">'
              +   '<div class="mx-auto" style="max-width:760px">'
              +     '<div class="text-center position-relative p-3 p-md-4"'
              +          ' style="border-radius:20px;background:linear-gradient(135deg,#f0fdf4 0%,#ecfeff 100%);border:1px solid #e5e7eb">'
              +       '<div class="bg-white p-4 p-md-5" style="border-radius:16px">'
              +         '<div class="d-inline-flex align-items-center justify-content-center mb-3"'
              +              ' style="width:90px;height:90px;border-radius:50%;'
              +                     'background:radial-gradient(circle at 30% 30%,#dcfce7,#bbf7d0)">'
              +           '<svg viewBox="0 0 24 24" width="44" height="44" aria-hidden="true">'
              +             '<path d="M20 6L9 17l-5-5" fill="none" stroke="#16a34a" stroke-width="3"'
              +                    ' stroke-linecap="round" stroke-linejoin="round"></path>'
              +           '</svg>'
              +         '</div>'
              +         '<h4 class="mb-2 fw-bold">Permohonan Berhasil Dihapus</h4>'
              +         '<p class="text-muted mb-4">Anda dapat membuat permohonan baru kapan saja.</p>'
              +         '<div class="d-flex flex-wrap justify-content-center gap-2">'
              +           '<a href="<?= site_url('booking') ?>" class="btn btn-primary btn-lg px-4">Buat Booking Baru</a>'
              +           '<a href="<?= site_url() ?>" class="btn btn-outline-secondary btn-lg px-4">Kembali ke Beranda</a>'
              +         '</div>'
              +       '</div>'
              +     '</div>'
              +   '</div>'
              + '</div>';
          }
        })
        .catch(err=>{
          Swal.close();
          Swal.fire({icon:'error', title:'Gagal', text: (err && err.message) || 'Terjadi kesalahan jaringan.'});
        });
    });
  });
})();
</script>

<!-- Uploader Surat Tugas -->
<script>
(function(){
  const pickBtn   = document.getElementById('btnPickSurat');
  const fileInput = document.getElementById('doc_surat');
  const upBtn     = document.getElementById('btnSuratUpload');
  const resetBtn  = document.getElementById('btnSuratReset');
  const label     = document.getElementById('pickSuratLabel');
  const wrapPrev  = document.getElementById('surat_preview_wrap');
  const prevImg   = document.getElementById('surat_preview_img');
  const prevPdfBx = document.getElementById('surat_preview_pdf');
  const pdfEmbed  = document.getElementById('surat_pdf_embed');
  const statusEl  = document.getElementById('surat_status');
  const kodeElm   = document.getElementById('kode_booking');

  if(!pickBtn || !fileInput) return;

  const MAX_SIZE = 10 * 1024 * 1024; // 10 MB
  const URL_UPLOAD = "<?= site_url('booking/upload_surat_tugas') ?>";
  const kode_booking = (kodeElm?.value || '').trim();

  pickBtn.addEventListener('click', ()=> fileInput.click());

  fileInput.addEventListener('change', ()=>{
    const f = fileInput.files && fileInput.files[0];
    if(!f){ label.textContent = 'Belum ada file'; return; }

    const okType = /^application\/pdf$|^image\//i.test(f.type);
    if(!okType){ statusEl.textContent = 'Tipe berkas tidak didukung. Gunakan PDF atau Gambar.'; fileInput.value = ''; upBtn.disabled = true; return; }
    if(f.size > MAX_SIZE){ statusEl.textContent = 'Ukuran berkas > 10MB. Mohon kompres terlebih dulu.'; fileInput.value=''; upBtn.disabled = true; return; }

    label.textContent = f.name;
    upBtn.disabled = false;
    resetBtn.style.display = 'inline-block';

    wrapPrev.style.display = 'block';
    prevImg.style.display  = 'none';
    prevPdfBx.style.display= 'none';

    const reader = new FileReader();
    reader.onload = (e)=>{
      if(/^image\//i.test(f.type)){
        prevImg.src = e.target.result;
        prevImg.style.display = 'block';
      }else{
        pdfEmbed.src = e.target.result;
        prevPdfBx.style.display = 'block';
      }
    };
    reader.readAsDataURL(f);
  });

  resetBtn.addEventListener('click', ()=>{
    fileInput.value = '';
    label.textContent = 'Belum ada file';
    upBtn.disabled = true;
    resetBtn.style.display = 'none';
    wrapPrev.style.display = 'none';
    prevImg.style.display  = 'none';
    prevPdfBx.style.display= 'none';
    statusEl.textContent = '';
  });

  upBtn.addEventListener('click', async ()=>{
    const f = fileInput.files && fileInput.files[0];
    if(!f) return;

    statusEl.textContent = 'Mengunggah…';
    upBtn.disabled = true; pickBtn.disabled = true; resetBtn.disabled = true;

    try{
      let fd = new FormData();
      fd.append('kode_booking', kode_booking);
      fd.append('surat_tugas', f);

      fd = addCSRF(fd); // penting

      const res = await fetch(URL_UPLOAD, {
        method: 'POST',
        body: fd,
        credentials: 'same-origin',
        headers: {'X-Requested-With':'XMLHttpRequest'}
      });

      const data = await res.json().catch(()=> ({}));
      if(!res.ok || !data || data.ok !== true || !data.url){
        throw new Error(data?.msg || 'Upload gagal');
      }

      statusEl.textContent = 'Berhasil diunggah ✓';
      resetBtn.click();

      // update tombol aksi (lihat/unduh) jika sukses
      const actions = document.getElementById('surat_actions');
      if (actions) {
        const bust = data.url + (data.url.indexOf('?')>=0?'&':'?') + 'v=' + Date.now();
        actions.innerHTML =
          `<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalSuratTugas_<?= $kode_safe ?>">
             <i class="mdi mdi-file-pdf-box"></i> Lihat
           </button>
           <a class="btn btn-sm btn-outline-secondary ml-1" href="${bust}" download>
             <i class="mdi mdi-download"></i> Unduh
           </a>`;
      }
    }catch(err){
      statusEl.textContent = 'Gagal mengunggah: ' + err.message;
      upBtn.disabled = false;
    }finally{
      pickBtn.disabled = false;
      resetBtn.disabled = false;
    }
  });
})();
</script>
