<?php
// Pastikan $booking terisi object dari DB
$booking   = $booking ?? null;
$title     = $title ?? 'Detail Booking';
$subtitle  = $subtitle ?? 'Informasi Pengunjung';

// Ambil instance CI untuk akses db & csrf
$CI =& get_instance();

// ===== Helper Hari/Tanggal Indonesia =====
if (!function_exists('hari_indo')) {
  function hari_indo($timestamp){
    $map = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
    $n = (int)date('N', $timestamp ?: time());
    return $map[$n] ?? '';
  }
}
if (!function_exists('fmt_hari_tanggal')) {
  function fmt_hari_tanggal($datetimeStr, $with_time=false){
    if (!$datetimeStr) return '-';
    $ts = is_numeric($datetimeStr) ? (int)$datetimeStr : strtotime($datetimeStr);
    if (!$ts) return '-';
    $hari = hari_indo($ts);
    $tgl  = date('d-m-Y', $ts);
    if ($with_time) {
      $jam = date('H:i', $ts);
      return "{$hari}, {$tgl} {$jam}";
    }
    return "{$hari}, {$tgl}";
  }
}

// Unit tujuan (fallback jika $unit_nama tidak dipassing)
if (!isset($unit_nama)) {
  $unit_nama = '-';
  if (!empty($booking->unit_tujuan)) {
    $u = $CI->db->select('nama_unit')->get_where('unit_tujuan', ['id'=>$booking->unit_tujuan])->row('nama_unit');
    if ($u) $unit_nama = $u;
  }
}

$surat_url = $surat_url ?? null;
$foto_url  = $foto_url  ?? null;

// Badge status
$badgeMap = [
  'pending'     => 'warning',
  'approved'    => 'primary',
  'checkin'     => 'info',
  'checked_in'  => 'info',
  'checkout'    => 'success',
  'checked_out' => 'success',
  'expired'     => 'secondary',
  'rejected'    => 'danger',
];
$st = strtolower((string)($booking->status ?? ''));
$badgeCls = $badgeMap[$st] ?? 'secondary';

// Boleh ambil dokumentasi hanya saat approved / checkin / checked_in
$can_capture  = in_array($st, ['approved','checkin','checked_in'], true);
$status_label = strtoupper(str_replace('_',' ', $st ?: '-'));

// Durasi kunjungan (hanya jika sudah check-in & check-out)
$durasi_text = null;
if (!empty($booking->checkin_at) && !empty($booking->checkout_at)) {
  $a = new DateTime($booking->checkin_at);
  $b = new DateTime($booking->checkout_at);
  $diff = $a->diff($b);
  $menitTotal = $diff->days*24*60 + $diff->h*60 + $diff->i;
  $jam = floor($menitTotal/60); $mnt = $menitTotal%60;
  $durasi_text = ($jam>0? $jam.' jam ' : '').$mnt.' menit';
}

// Link PDF
$pdf_url = site_url('admin_scan/print_pdf/'.rawurlencode($booking->kode_booking ?? '')).'?inline=1&ts='.time();
$pernyataan_pdf = $pernyataan_pdf
  ?? ($pdf_pernyataan ?? null)
  ?? site_url('admin_scan/pernyataan_pdf/'.rawurlencode($booking->kode_booking ?? '')).'?inline=1&ts='.time();

// Jadwal kunjungan (hari + tanggal + jam)
$jadwal_text = '-';
if (!empty($booking->tanggal) || !empty($booking->jam)) {
  $base = trim(($booking->tanggal ?? '').' '.($booking->jam ?? ''));
  $jadwal_text = fmt_hari_tanggal($base, true);
}

// Check-in / Checkout
$checkin_text  = !empty($booking->checkin_at)  ? fmt_hari_tanggal($booking->checkin_at,  true) : null;
$checkout_text = !empty($booking->checkout_at) ? fmt_hari_tanggal($booking->checkout_at, true) : null;

// Petugas (jika ada)
$petugas_checkin  = $booking->petugas_checkin  ?? null;
$petugas_checkout = $booking->petugas_checkout ?? null;

// Sanitizer ringkas
$e = fn($s)=>htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');

// WA link
$wa_digits = preg_replace('/\D+/', '', (string)($booking->no_hp ?? ''));
?>
<style>
  .kv-card{border:1px solid #eef0f3;border-radius:14px}
  .kv-head{border-bottom:1px dashed #e5e7eb}
  .kv-label{color:#6b7280;font-size:.95rem}
  .kv-value{font-weight:600}
  .kv-row{padding:.6rem 0;border-bottom:1px dashed #f1f5f9}
  .kv-row:last-child{border-bottom:none}
  .badge.text-uppercase{letter-spacing:.02em}
  .btn-soft{background:#f8fafc;border-color:#e5e7eb}

  .doc-card .preview{max-width:50%;border-radius:12px;box-shadow:0 4px 18px rgba(0,0,0,.06)}
  .pdf-card .pdf-frame{border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:#111}
  .pdf-card object{width:100%;height:68vh;border:0}
  @media (max-width: 991px){ .pdf-card object{height:60vh} }

  .header-stat .h5{font-weight:700}

  /* Overlay kunci kamera */
  .cam-card{position:relative}
  .cam-card .overlay{
    position:absolute; inset:0;
    background:rgba(255,255,255,.88);
    display:flex; align-items:center; justify-content:center;
    border-radius:12px; text-align:center; padding:1rem;
  }
  .cam-card .overlay .msg{max-width:420px; color:#374151;}

  /* Keperluan panjang */
  .keperluan-box{background:#f8fafc;border:1px dashed #e5e7eb;border-radius:10px;padding:.75rem}

  /* ===== Kamera Dokumentasi (tanpa garis/guide) ===== */
  #docCamWrap{position:relative}
  .fs-exit-btn{
    position:absolute; top:10px; right:10px; z-index: 1070;
    width:42px; height:42px; border:0; border-radius:999px;
    display:flex; align-items:center; justify-content:center;
    background:rgba(0,0,0,.6); color:#fff;
  }
  .fs-shutter{
    position:absolute; left:50%; transform:translateX(-50%);
    bottom:18px; z-index:1070;
    width:68px; height:68px; border:0; border-radius:999px;
    display:flex; align-items:center; justify-content:center;
    background:rgba(255,255,255,.85); color:#111;
    box-shadow:0 8px 30px rgba(0,0,0,.35);
  }

  #docCamWrap:not(.is-fs):not(:fullscreen) video {
    aspect-ratio:16/9; width:100%; border-radius:12px; background:#000; object-fit:cover;
  }

  /* Fullscreen API */
  #docCamWrap:fullscreen,
  #docCamWrap:-webkit-full-screen { background:#000; }
  #docCamWrap:fullscreen video,
  #docCamWrap:-webkit-full-screen video,
  video:fullscreen, video:-webkit-full-screen {
    position:absolute; inset:0;
    width:100vw !important;
    height:100svh !important; height:100dvh !important; height:100vh !important;
    object-fit:cover !important; border-radius:0 !important; aspect-ratio:auto !important;
    background:#000;
  }

  /* Fallback CSS bila API ditolak */
  body.scan-lock { overflow: hidden; }
  #docCamWrap.fullscreen-scan{
    position: fixed !important; inset: 0 !important; z-index: 1060 !important;
    background:#000; margin:0 !important; border-radius:0 !important;
    padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
  }
  #docCamWrap.fullscreen-scan video{
    position:absolute; inset:0;
    width:100vw !important;
    height:100svh !important; height:100dvh !important; height:100vh !important;
    object-fit:cover !important; border-radius:0 !important; aspect-ratio:auto !important;
    background:#000;
  }
  #docCamWrap.is-fs video{
    position:absolute; inset:0;
    width:100vw !important;
    height:100svh !important; height:100dvh !important; height:100vh !important;
    object-fit:cover !important; border-radius:0 !important; aspect-ratio:auto !important;
  }
  /* Tombol senter saat fullscreen (mengambang di kiri-bawah) */
.fs-torch-btn{
  position:absolute; bottom:10px; left:10px;
  z-index:1070; width:auto; min-width:42px; height:42px;
  border:0; border-radius:999px; padding:0 .9rem;
  display:flex; align-items:center; gap:.35rem;
  background:rgba(0,0,0,.6); color:#fff;
}
.fs-torch-btn.active{ background:rgba(255,200,0,.9); color:#111; }
.fs-torch-btn i{ font-size:18px; }

</style>

<div class="container-fluid">
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><?= $e($title) ?></li>
            <li class="breadcrumb-item active"><?= $e($subtitle) ?></li>
          </ol>
        </div>
        <h4 class="page-title"><?= $e($subtitle) ?></h4>
      </div>
    </div>
  </div>

  <!-- Header ringkas -->
  <div class="card kv-card shadow-sm mb-3">
    <div class="card-body header-stat">
      <div class="d-flex justify-content-between align-items-center kv-head pb-2 mb-2">
        <div>
          <div class="kv-label">🔖 Kode Booking</div>
          <div class="h5 mb-0"><?= $e($booking->kode_booking ?? '-') ?></div>
        </div>
        <span class="badge badge-<?= $badgeCls ?> text-uppercase px-3 py-2">
          <?= $e($booking->status ?? '-') ?>
        </span>
      </div>
    </div>
  </div>

  <!-- ======================== BARIS ATAS ======================== -->
  <div class="row">
    <!-- Kiri: DETAIL BOOKING -->
    <div class="col-lg-7">
      <div class="card kv-card shadow-sm mb-3">
        <div class="card-body">
          <div class="kv-head pb-3 mb-3">
            <h6 class="mb-0"><i class="mdi mdi-information-outline"></i> Detail Booking</h6>
          </div>

          <div class="row">
            <div class="col-12">
              <dl class="mb-0">

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">👤 Nama Tamu</dt>
                  <dd class="col-sm-9 kv-value"><?= $e($booking->nama_tamu ?? '-') ?></dd>
                </div>
                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">📍 Alamat</dt>
                  <dd class="col-sm-9 kv-value"><?= $e($booking->alamat ?? '-') ?></dd>
                </div>
                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">🎂 Tempat/Tanggal Lahir</dt>
                  <dd class="col-sm-9 kv-value"><?= $e($booking->tempat_lahir ?? '-') ?>, <?= tgl_view($e($booking->tanggal_lahir ?? '-')) ?></dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">🧰 Jabatan</dt>
                  <dd class="col-sm-9 kv-value"><?= $e($booking->jabatan ?? '-') ?></dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">🪪 NIK/NIP/NRP</dt>
                  <dd class="col-sm-9 kv-value">
                    <?= $e($booking->nik ?? '-') ?>
                    <?php if (!empty($booking->nik)): ?>
                      <button type="button" class="btn btn-light btn-sm ml-1 btn-copy" data-clip="<?= $e($booking->nik) ?>">
                        <i class="mdi mdi-content-copy"></i> Salin
                      </button>
                    <?php endif; ?>
                  </dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">📞 No. HP</dt>
                  <dd class="col-sm-9 kv-value">
                    <?= $e($booking->no_hp ?? '-') ?>
                    <?php if ($wa_digits): ?>
                      <a class="btn btn-light btn-sm ml-1" target="_blank" rel="noopener" href="https://wa.me/<?= $wa_digits ?>">
                        <i class="mdi mdi-whatsapp"></i>
                      </a>
                    <?php endif; ?>
                  </dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">🏷️ Instansi Asal</dt>
                  <dd class="col-sm-9 kv-value">
                    <?= $e(($booking->target_instansi_nama ?? '') ?: (($booking->instansi ?? '') ?: '-')) ?>
                  </dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">🎯 Unit Tujuan</dt>
                  <dd class="col-sm-9 kv-value"><?= $e($unit_nama) ?></dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">👔 Nama <?= $e($unit_nama) ?></dt>
                  <dd class="col-sm-9 kv-value"><?= $e($booking->nama_petugas_instansi ?? '-') ?></dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">📝 Keperluan</dt>
                  <dd class="col-sm-9 kv-value">
                    <div class="keperluan-box"><?= nl2br($e($booking->keperluan ?? '-')) ?></div>
                  </dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">📅 Jadwal Kunjungan</dt>
                  <dd class="col-sm-9 kv-value"><?= $e($jadwal_text) ?></dd>
                </div>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">👥 Pendamping</dt>
                  <dd class="col-sm-9 kv-value">
                    <span class="badge badge-pill badge-primary" style="font-size:.9rem;">
                      <?= (int)($booking->jumlah_pendamping ?? 0) ?> orang
                    </span>
                  </dd>
                </div>

                <?php if (!empty($pendamping_rows)): ?>
                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">📋 Daftar Pendamping</dt>
                  <dd class="col-sm-9 kv-value">
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
                              <td class="text-center"><?= $i + 1 ?></td>
                              <td><code><?= $e($p->nik ?? '') ?></code></td>
                              <td><?= $e($p->nama ?? '') ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </dd>
                </div>
                <?php elseif ((int)($booking->jumlah_pendamping ?? 0) > 0): ?>
                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">📋 Daftar Pendamping</dt>
                  <dd class="col-sm-9 kv-value text-muted">Belum ada data pendamping.</dd>
                </div>
                <?php endif; ?>

                <?php if (!empty($checkin_text)): ?>
                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">⏱️ Check-in</dt>
                  <dd class="col-sm-9 kv-value">
                    <?= $e($checkin_text) ?>
                    <?php if (!empty($petugas_checkin)): ?>
                      <div class="small text-muted">👮 Petugas: <?= $e($petugas_checkin) ?></div>
                    <?php endif; ?>
                  </dd>
                </div>
                <?php endif; ?>

                <?php if (!empty($checkout_text)): ?>
                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">✅ Checkout</dt>
                  <dd class="col-sm-9 kv-value">
                    <?= $e($checkout_text) ?>
                    <?php if (!empty($petugas_checkout)): ?>
                      <div class="small text-muted">👮 Petugas: <?= $e($petugas_checkout) ?></div>
                    <?php endif; ?>
                  </dd>
                </div>
                <?php endif; ?>

                <?php if (!empty($durasi_text)): ?>
                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">🕒 Durasi</dt>
                  <dd class="col-sm-9 kv-value"><?= $e($durasi_text) ?></dd>
                </div>
                <?php endif; ?>

                <div class="kv-row row no-gutters">
                  <dt class="col-sm-3 kv-label">🖼️ Foto</dt>
                  <dd class="col-sm-9 kv-value">
                    <div id="lampiranFotoBox">
                      <?php if (!empty($foto_url)): ?>
                        <img
                          src="<?= $foto_url ?>"
                          alt="Foto Lampiran"
                          class="img-thumbnail js-lampiran-foto"
                          style="max-height:120px;object-fit:cover;cursor:zoom-in;display:block"
                          data-full="<?= $foto_url ?>"
                        >
                        <a class="btn btn-sm btn-outline-secondary mt-2" href="<?= $foto_url ?>" download>
                          <i class="mdi mdi-download"></i> Unduh Foto
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 ml-1"
                                data-toggle="modal" data-target="#modalFotoLampiran">
                          <i class="mdi mdi-magnify-plus"></i> Perbesar
                        </button>
                      <?php else: ?>
                        <div class="text-muted">Belum ada foto lampiran.</div>
                      <?php endif; ?>
                    </div>
                  </dd>
                </div>

              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Kanan: Kamera Dokumentasi -->
    <div class="col-lg-5">
      <div class="card doc-card shadow-sm mb-3 cam-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="mdi mdi-camera-outline"></i> Dokumentasi</h6>
            <small class="text-muted">Kode: <?= $e($booking->kode_booking ?? '-') ?></small>
          </div>

          <div class="mt-2" id="docCamWrap">
            <video id="camPreview" autoplay muted playsinline></video>
            <button id="btnFsTorch" type="button" class="fs-torch-btn d-none" aria-label="Senter">
              <i class="mdi mdi-flashlight"></i><span class="d-none d-sm-inline"> Senter</span>
            </button>
            <button id="btnDocExitFs" type="button" class="fs-exit-btn d-none" aria-label="Tutup layar penuh">
              <i class="mdi mdi-close"></i>
            </button>
            <button id="btnFsShutter" type="button" class="fs-shutter d-none" aria-label="Ambil foto">
              <i class="mdi mdi-camera" style="font-size:28px;"></i>
            </button>
            

          </div>

          <canvas id="camCanvas" class="d-none"></canvas>

          <div class="d-flex flex-wrap mt-2" style="gap:.5rem;">
            <select id="camSelect" class="form-control" style="max-width:300px"></select>
            <button id="btnCamStart"  type="button" class="btn btn-outline-primary btn-sm" <?= $can_capture ? '' : 'disabled' ?>>
              <i class="mdi mdi-play"></i> Nyalakan Kamera
            </button>
            <button id="btnCamCapture" type="button" class="btn btn-primary btn-sm" disabled>
              <i class="mdi mdi-camera"></i> Ambil Foto
            </button>
            <button id="btnCamStop"    type="button" class="btn btn-outline-secondary btn-sm" disabled>
              <i class="mdi mdi-stop"></i> Matikan
            </button>
            <button id="btnCamTorch" type="button" class="btn btn-outline-warning btn-sm" disabled>
              <i class="mdi mdi-flashlight"></i> Senter
            </button>
            <button id="btnFsTorch" type="button" class="fs-torch-btn d-none" aria-label="Senter">
              <i class="mdi mdi-flashlight"></i><span class="d-none d-sm-inline"> Senter</span>
            </button>


            <button id="btnDocFull" class="btn btn-outline-dark btn-sm d-none">
              <i class="mdi mdi-arrow-expand-all"></i> Layar Penuh
            </button>
            <label class="btn btn-blue btn-sm mb-0 <?= $can_capture ? '' : 'disabled' ?>" style="<?= $can_capture?'':'pointer-events:none;opacity:.6;'?>">
              <input id="fileFallback" type="file" accept="image/*" capture="environment" hidden <?= $can_capture ? '' : 'disabled' ?>>
              <i class="mdi mdi-upload"></i> Unggah dari Laptop/HP (kamera penuh)
            </label>
          </div>

          <div class="mt-2">
            <img id="docPreview" class="preview d-none" alt="Pratinjau Dokumentasi">
            <div id="docMsg" class="small text-muted">Belum ada foto.</div>
          </div>

          <div class="mt-2">
            <button id="btnDocSave" type="button" class="btn btn-success btn-sm" disabled>
              <i class="mdi mdi-content-save"></i> Simpan Foto
            </button>
          </div>
        </div>

        <?php if (!$can_capture): ?>
          <div class="overlay">
            <div class="msg">
              <div class="h6 mb-1"><i class="mdi mdi-lock-outline"></i> Kamera dinonaktifkan</div>
              <div>Status saat ini: <b><?= $e($status_label) ?></b>.<br>
                  Ambil dokumentasi hanya tersedia pada status <b>APPROVED</b> atau <b>CHECKED IN</b>.
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- ======================== BARIS BAWAH ======================== -->
  <div class="row">
    <!-- Kiri: PDF Ticket -->
    <div class="col-lg-6">
      <div class="card shadow-sm pdf-card mb-3">
        <div class="card-body">
          <h6 class="mb-2 d-flex align-items-center">
            <i class="mdi mdi-file-pdf-box mr-1"></i> Ticket Pengunjung (PDF)
          </h6>
          <div class="pdf-frame">
            <object data="<?= $pdf_url ?>" type="application/pdf">
              <div class="p-3 bg-white">
                <div class="mb-2 font-weight-bold">Pratinjau PDF tidak didukung browser ini.</div>
                <a href="<?= $pdf_url ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                  Buka PDF di tab baru
                </a>
              </div>
            </object>
          </div>
          <small class="text-muted d-block mt-2">
            Catatan: Jika PDF tidak otomatis muncul, klik “Buka PDF di tab baru”.
          </small>
        </div>
      </div>
    </div>

    <!-- Kanan: SURAT PERNYATAAN (PDF) -->
    <div class="col-lg-6">
      <div class="card shadow-sm pdf-card mb-3">
        <div class="card-body">
          <h6 class="mb-2 d-flex align-items-center">
            <i class="mdi mdi-file-pdf-box mr-1"></i> Surat Pernyataan (PDF)
          </h6>
          <div class="pdf-frame">
            <object data="<?= $pernyataan_pdf ?>" type="application/pdf">
              <div class="p-3 bg-white">
                <div class="mb-2 font-weight-bold">Pratinjau PDF tidak didukung browser ini.</div>
                <a href="<?= $pernyataan_pdf ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                  Buka PDF di tab baru
                </a>
              </div>
            </object>
          </div>
          <small class="text-muted d-block mt-2">
            Catatan: Jika PDF tidak otomatis muncul, klik “Buka PDF di tab baru”.
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Perbesar Foto -->
<div class="modal fade" id="modalFotoLampiran" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title mb-0"><i class="mdi mdi-image"></i> Foto Lampiran</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span>&times;</span></button>
      </div>
      <div class="modal-body p-2 text-center" style="background:#000;">
        <img id="lampiranFotoModalImg" src="<?= !empty($foto_url)?$foto_url:'' ?>"
             alt="Foto Lampiran" style="max-width:100%;max-height:80vh;object-fit:contain">
      </div>
      <div class="modal-footer py-2">
        <a id="lampiranFotoDownload" href="<?= !empty($foto_url)?$foto_url:'#' ?>"
           class="btn btn-outline-primary" download>
          <i class="mdi mdi-download"></i> Unduh
        </a>
        <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  // tombol salin
  (function(){
    function copyToClipboard(text){
      if (navigator.clipboard) return navigator.clipboard.writeText(text);
      const ta=document.createElement('textarea'); ta.value=text; document.body.appendChild(ta);
      ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
      return Promise.resolve();
    }
    document.querySelectorAll('.btn-copy').forEach(btn=>{
      btn.addEventListener('click', function(){
        const txt = this.getAttribute('data-clip') || '';
        copyToClipboard(txt).then(()=>{
          this.innerHTML = '<i class="mdi mdi-check"></i> Disalin';
          this.classList.add('btn-success');
          setTimeout(()=>{ this.innerHTML = '<i class="mdi mdi-content-copy"></i> Salin'; this.classList.remove('btn-success'); }, 1500);
        });
      });
    });
  })();

  // Foto Lampiran (modal & refresh)
  function setLampiranModal(url){
    const img = document.getElementById('lampiranFotoModalImg');
    const dl  = document.getElementById('lampiranFotoDownload');
    if (img) img.src = url || '';
    if (dl)  dl.href = url || '#';
  }
  function renderLampiranFoto(url) {
    const box = document.getElementById('lampiranFotoBox');
    if (!box) return;
    if (!url) {
      box.innerHTML = '<div class="text-muted">Belum ada foto lampiran.</div>';
      setLampiranModal('');
      return;
    }
    box.innerHTML = `
      <img src="${url}" alt="Foto Lampiran"
           class="img-thumbnail js-lampiran-foto"
           style="max-height:120px;object-fit:cover;cursor:zoom-in;display:block"
           data-full="${url}">
      <a class="btn btn-sm btn-outline-secondary mt-2" href="${url}" download>
        <i class="mdi mdi-download"></i> Unduh Foto
      </a>
      <button type="button" class="btn btn-sm btn-outline-primary mt-2 ml-1"
              data-toggle="modal" data-target="#modalFotoLampiran">
        <i class="mdi mdi-magnify-plus"></i> Perbesar
      </button>
    `;
    setLampiranModal(url);
  }
  document.addEventListener('click', function(e){
    const el = e.target.closest('.js-lampiran-foto');
    if (!el) return;
    const full = el.getAttribute('data-full') || el.getAttribute('src') || '';
    setLampiranModal(full);
    if (window.jQuery){ $('#modalFotoLampiran').modal('show'); }
    else { document.querySelector('[data-target="#modalFotoLampiran"]')?.click(); }
  });
</script>

<script>
(function(){
  const CAN_CAPTURE  = <?= $can_capture ? 'true' : 'false' ?>;
  const STATUS_LABEL = <?= json_encode($status_label) ?>;
  const KODE    = <?= json_encode($booking->kode_booking ?? '') ?>;

  const wrap    = document.getElementById('docCamWrap');   // pastikan ada <div id="docCamWrap">
  const video   = document.getElementById('camPreview');
  const canvas  = document.getElementById('camCanvas');
  const imgPrev = document.getElementById('docPreview');
  const msg     = document.getElementById('docMsg');

  const ddlCam  = document.getElementById('camSelect');
  const bStart  = document.getElementById('btnCamStart');
  const bStop   = document.getElementById('btnCamStop');
  const bShot   = document.getElementById('btnCamCapture');
  const bSave   = document.getElementById('btnDocSave');
  const bFull   = document.getElementById('btnDocFull');      // jika ada tombol fullscreen normal
  const bExitFs = document.getElementById('btnDocExitFs');    // jika ada tombol exit fullscreen
  const bFsShut = document.getElementById('btnFsShutter');    // jika ada tombol shutter fullscreen
  const bTorch  = document.getElementById('btnCamTorch');     // ← tombol senter normal
  const bFsTorch= document.getElementById('btnFsTorch');      // ← tombol senter fullscreen
  const fFile   = document.getElementById('fileFallback');

  const safeRenderLampiran = (window.renderLampiranFoto || function(){}).bind(window);

  let stream = null;
  let currentDeviceId = null;

  // torch
  let torchTrack = null;
  let torchOn    = false;
  let torchCap   = false;

  function setMsg(t, ok=false){ if(!msg) return; msg.textContent = t; msg.className = ok ? 'small text-success' : 'small text-muted'; }
  const isFsActive = () => document.fullscreenElement === wrap || wrap?.classList.contains('fullscreen-scan') || wrap?.classList.contains('is-fs');

  async function ensureLabels(){ try { const t=await navigator.mediaDevices.getUserMedia({video:true,audio:false}); t.getTracks().forEach(x=>x.stop()); } catch(e){} }
  async function listCams(){ const devs = await navigator.mediaDevices.enumerateDevices(); return devs.filter(d=>d.kind==='videoinput'); }
  function pickDefault(cams){
    if (!cams.length) return null;
    const by = re => cams.find(d => re.test(d.label||''));
    return by(/usb|external|logitech|webcam|brio|hd pro/i) || by(/back|rear|environment/i) || cams[0];
  }
  async function fillCamSelect(selectedId=null){
    if (!ddlCam) return [];
    const cams = await listCams();
    ddlCam.innerHTML = '';
    cams.forEach((c,i)=>{
      const opt = document.createElement('option');
      opt.value = c.deviceId || '';
      opt.textContent = c.label || `Kamera ${i+1}`;
      ddlCam.appendChild(opt);
    });
    const def = selectedId && cams.some(c=>c.deviceId===selectedId)
      ? selectedId : (pickDefault(cams)?.deviceId || (cams[0]?.deviceId || ''));
    if (def) ddlCam.value = def;
    return cams;
  }

  async function startWithDevice(deviceId){
    if (stream){ stream.getTracks().forEach(t=>t.stop()); stream=null; }
    const constraints = deviceId
      ? { video:{ deviceId:{ exact: deviceId }, width:{ideal:1280}, height:{ideal:720} }, audio:false }
      : { video:{ facingMode:{ ideal:'environment' }, width:{ideal:1280}, height:{ideal:720} }, audio:false };

    stream = await navigator.mediaDevices.getUserMedia(constraints);
    video.srcObject = stream;
    await video.play().catch(()=>{});
    currentDeviceId = stream.getVideoTracks()[0]?.getSettings()?.deviceId || deviceId || null;

    if (bShot) bShot.disabled = false;
    if (bStop) bStop.disabled = false;
    if (bFull) bFull.classList?.remove('d-none');

    await setupTorch();       // ← cek & aktifkan kemampuan senter
    setMsg('Kamera aktif.', true);
  }

  async function startCam(){
    if (!CAN_CAPTURE){ setMsg('Kamera dinonaktifkan (status: '+STATUS_LABEL+').'); return; }
    try{
      await ensureLabels();
      const cams = await fillCamSelect(currentDeviceId || localStorage.getItem('doc.camId'));
      if (!cams.length){ setMsg('Tidak ada kamera terdeteksi.'); return; }
      const chosenId = ddlCam?.value || pickDefault(cams)?.deviceId || null;
      await startWithDevice(chosenId);
      try { localStorage.setItem('doc.camId', chosenId || ''); } catch(e){}
    }catch(e){
      setMsg('Tidak bisa mengakses kamera: '+(e?.message || e));
    }
  }

  function stopCam(){
    turnOffTorch();   // ← matikan senter saat berhenti
    if (stream){ stream.getTracks().forEach(t=>t.stop()); stream=null; }
    if (video) video.srcObject = null;
    if (bShot) bShot.disabled = true;
    if (bStop) bStop.disabled = true;
    if (bFull) bFull.classList?.add('d-none');
    disableTorchUI();
    hideFsUi();
    exitFullscreen();
    setMsg('Kamera dimatikan.');
  }

  function capture(){
    if (!video || !video.videoWidth) return;
    const w = video.videoWidth, h = video.videoHeight;
    const maxW = 1280, scale = Math.min(1, maxW / w);
    canvas.width  = Math.round(w*scale);
    canvas.height = Math.round(h*scale);
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
    imgPrev.src = dataUrl;
    imgPrev.classList.remove('d-none');
    if (bSave) bSave.disabled = false;
    setMsg('Pratinjau siap. Klik "Simpan Foto".', true);
  }

  function captureAndExit(){
    capture();
    if (isFsActive()){
      setTimeout(()=> exitFullscreen(), 80);
    }
  }

  function readFile(file){
    const r = new FileReader();
    r.onload = ()=>{
      imgPrev.src = r.result;
      imgPrev.classList.remove('d-none');
      if (bSave) bSave.disabled = false;
      setMsg('Pratinjau siap (unggah). Klik "Simpan Foto".', true);
    };
    r.readAsDataURL(file);
  }

  async function saveDoc(){
    const dataUrl = imgPrev.src || '';
    if (!/^data:image\//.test(dataUrl)) return;

    const params = new URLSearchParams();
    params.set('kode', KODE);
    params.set('image', dataUrl);
    <?php if (config_item('csrf_protection')): ?>
      params.set('<?= $CI->security->get_csrf_token_name() ?>','<?= $CI->security->get_csrf_hash() ?>');
    <?php endif; ?>

    if (bSave) bSave.disabled = true;
    setMsg('Menyimpan...', false);

    try{
      const r = await fetch('<?= site_url('admin_scan/upload_doc_photo') ?>', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: params.toString(),
        credentials: 'same-origin'
      });
      const j = await r.json();
      if (j.ok){
        setMsg('Tersimpan: '+ (j.file || ''), true);
        if (j.url){
          imgPrev.src = j.url;
          safeRenderLampiran(j.url);
        }
      } else {
        setMsg('Gagal: '+(j.msg||'')); if (bSave) bSave.disabled = false;
      }
    }catch(e){
      setMsg('Error: '+(e?.message || e)); if (bSave) bSave.disabled = false;
    }
  }

  // ====== SENTER ======
  function updateTorchUI(){
    // normal button
    if (bTorch){
      bTorch.disabled = !torchCap;
      bTorch.classList.toggle('btn-warning', torchOn);
      bTorch.classList.toggle('btn-outline-warning', !torchOn);
      bTorch.innerHTML = `<i class="mdi ${torchOn?'mdi-flashlight-off':'mdi-flashlight'}"></i> ${torchOn?'Matikan':'Senter'}`;
    }
    // fullscreen button
    if (bFsTorch){
      if (isFsActive() && torchCap) bFsTorch.classList.remove('d-none');
      else bFsTorch.classList.add('d-none');
      bFsTorch.classList.toggle('active', torchOn);
      bFsTorch.innerHTML = `<i class="mdi ${torchOn?'mdi-flashlight-off':'mdi-flashlight'}"></i><span class="d-none d-sm-inline"> ${torchOn?'Matikan':'Senter'}</span>`;
    }
  }
  function disableTorchUI(){
    torchTrack = null; torchOn = false; torchCap = false;
    updateTorchUI();
  }
  async function setupTorch(){
    disableTorchUI();
    const stream = video.srcObject;
    if (!stream) return;
    const track = stream.getVideoTracks()[0];
    if (!track) return;
    const caps = (track.getCapabilities && track.getCapabilities()) || {};
    if (caps.torch){
      torchTrack = track;
      torchCap   = true;
      torchOn    = (track.getSettings && !!track.getSettings().torch) || false;
    }
    updateTorchUI();
  }
  async function toggleTorch(){
    if (!torchTrack) return;
    try{
      await torchTrack.applyConstraints({ advanced:[{ torch: !torchOn }] });
      torchOn = !torchOn;
      updateTorchUI();
    }catch(e){
      setMsg('Senter tidak didukung/ditolak di perangkat ini.', false);
      // fallback: disable tombol agar tidak menipu user
      disableTorchUI();
    }
  }
  function turnOffTorch(){
    if (!torchTrack || !torchOn) return;
    try { torchTrack.applyConstraints({ advanced:[{ torch:false }] }); } catch(e){}
    torchOn=false; updateTorchUI();
  }

  // ===== Fullscreen (API + fallback) =====
  async function enterFullscreen(){
    try{
      if (wrap && wrap.requestFullscreen) {
        await wrap.requestFullscreen();
        wrap.classList.add('is-fs');
        showFsUi();
        return;
      }
      if (video && video.webkitEnterFullscreen) {
        video.webkitEnterFullscreen();
        wrap.classList.add('is-fs');
        showFsUi();
        return;
      }
    }catch(e){ /* fallback */ }
    wrap?.classList.add('fullscreen-scan','is-fs');
    document.body.classList.add('scan-lock');
    showFsUi();
  }
  function exitFullscreen(){
    if (document.fullscreenElement && document.exitFullscreen) {
      document.exitFullscreen();
    }
    wrap?.classList.remove('fullscreen-scan','is-fs');
    document.body.classList.remove('scan-lock');
    hideFsUi();
  }
  function showFsUi(){
    bExitFs?.classList.remove('d-none');
    bFsShut?.classList.remove('d-none');
    updateTorchUI(); // tampilkan btn senter FS jika bisa
  }
  function hideFsUi(){
    bExitFs?.classList.add('d-none');
    bFsShut?.classList.add('d-none');
    bFsTorch?.classList.add('d-none');
  }
  document.addEventListener('fullscreenchange', ()=>{
    if (!document.fullscreenElement) {
      wrap?.classList.remove('fullscreen-scan','is-fs');
      document.body.classList.remove('scan-lock');
      hideFsUi();
    } else {
      wrap?.classList.add('is-fs');
      showFsUi();
    }
  });

  // ===== Events =====
  bStart && bStart.addEventListener('click', startCam);
  bStop  && bStop .addEventListener('click', stopCam);

  bShot  && bShot .addEventListener('click', capture);
  bFsShut&& bFsShut?.addEventListener('click', captureAndExit);
  video  && video .addEventListener('click', ()=>{ if (isFsActive()) captureAndExit(); });

  bSave  && bSave .addEventListener('click', saveDoc);
  fFile  && fFile .addEventListener('change', (e)=>{ if (e.target.files && e.target.files[0]) readFile(e.target.files[0]); });

  ddlCam && ddlCam.addEventListener('change', async (e)=>{
    const id = e.target.value || null;
    try {
      await startWithDevice(id);
      try { localStorage.setItem('doc.camId', id || ''); } catch(_){}
    } catch(err){
      setMsg('Gagal beralih kamera: '+(err?.message || err));
    }
  });

  bFull  && bFull .addEventListener('click', async ()=>{ if (stream){ await enterFullscreen(); } });
  bExitFs&& bExitFs?.addEventListener('click', exitFullscreen);

  // tombol senter
  bTorch && bTorch.addEventListener('click', toggleTorch);
  bFsTorch && bFsTorch.addEventListener('click', toggleTorch);

  // ESC untuk keluar (desktop)
  document.addEventListener('keydown', (e)=>{ if (e.key === 'Escape') exitFullscreen(); });

  // Hot-swap saat device colok/cabut
  navigator.mediaDevices?.addEventListener?.('devicechange', async ()=>{
    const cams = await fillCamSelect(currentDeviceId);
    const stillThere = cams.some(c=>c.deviceId === currentDeviceId);
    if (!stillThere){
      const next = pickDefault(cams);
      if (next && stream){
        setMsg('Perangkat berubah—beralih kamera…');
        await startWithDevice(next.deviceId);
        if (ddlCam) ddlCam.value = next.deviceId;
      } else if (stream){
        stopCam();
        setMsg('Semua kamera tidak tersedia.');
      }
    }
  });

  // init dropdown
  (async ()=>{
    if (!CAN_CAPTURE){
      bStart?.setAttribute('disabled','disabled');
      bShot ?.setAttribute('disabled','disabled');
      bStop ?.setAttribute('disabled','disabled');
      fFile ?.setAttribute('disabled','disabled');
      ddlCam ?.setAttribute('disabled','disabled');
      setMsg('Kamera dinonaktifkan (status: '+STATUS_LABEL+').');
      return;
    }
    await ensureLabels();
    await fillCamSelect(localStorage.getItem('doc.camId'));
  })();

  window.addEventListener('beforeunload', stopCam);
})();
</script>

