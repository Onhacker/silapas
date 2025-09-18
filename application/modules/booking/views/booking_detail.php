<?php $this->load->view("front_end/head.php") ?>

<?php
// ==== helper kecil hari Indonesia (tanpa CSS tambahan) ====
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

<div class="container-fluid">

  <div class="row">
    <div class="col-12">
      <h3 class="mb-3"><?php echo htmlspecialchars($booking->nama_tamu ?? '-', ENT_QUOTES, 'UTF-8'); ?></h3>
    </div>
  </div>

  <?php if (!empty($booking)): ?>
  <?php
    $kode = htmlspecialchars($booking->kode_booking ?? '-', ENT_QUOTES, 'UTF-8');

    // Unit tujuan (fallback via DB jika belum dipass dari controller)
    $unit_nama = isset($unit_nama)
      ? $unit_nama
      : $this->db->select('nama_unit')->get_where('unit_tujuan', ['id'=>$booking->unit_tujuan])->row('nama_unit');
    $unit_nama = htmlspecialchars($unit_nama ?: '-', ENT_QUOTES, 'UTF-8');

    // Status → badge class bootstrap sederhana
    $st = strtolower((string)($booking->status ?? ''));
    $badgeMap = [
      'pending'=>'badge-warning','approved'=>'badge-primary',
      'checked_in'=>'badge-info','checked_out'=>'badge-success',
      'expired'=>'badge-secondary','rejected'=>'badge-danger',
    ];
    $badgeCls = $badgeMap[$st] ?? 'badge-secondary';

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

    // Tanggal/Jam
    $hari_tgl = '-';
    if (!empty($booking->tanggal)) {
      $hari_tgl = hari_id($booking->tanggal).', '.date('d-m-Y', strtotime($booking->tanggal));
    }
    $jam = !empty($booking->jam) ? htmlspecialchars($booking->jam, ENT_QUOTES, 'UTF-8') : '-';

    // Check-in/out
    $checkin_str  = !empty($booking->checkin_at)  ? (hari_id($booking->checkin_at).', '.date('d-m-Y H:i', strtotime($booking->checkin_at))) : '';
    $checkout_str = !empty($booking->checkout_at) ? (hari_id($booking->checkout_at).', '.date('d-m-Y H:i', strtotime($booking->checkout_at))) : '';

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

    // WA telp
    $hp_wa = preg_replace('/\D+/', '', (string)($booking->no_hp ?? ''));

    // Hak edit/hapus (sederhana)
    $batas_edit_view = isset($batas_edit) ? (int)$batas_edit : 1;
    $batas_hari_view = isset($batas_hari) ? (int)$batas_hari : 2;
    $edit_count = isset($booking->edit_count) ? (int)$booking->edit_count : 0;
    $today = new DateTime('today');
    $days_left = null; $allow_by_hari = true;
    if (!empty($booking->tanggal)) {
      try {
        $visit = new DateTime(date('Y-m-d', strtotime($booking->tanggal)));
        $days_left = (int)$today->diff($visit)->format('%r%a');
        $allow_by_hari = ($days_left >= $batas_hari_view);
      } catch (Throwable $e) { $allow_by_hari = false; }
    }
    $allow_by_count = ($batas_edit_view === 0) ? false : ($edit_count < $batas_edit_view);
    $can_edit = ($batas_edit_view > 0) && $allow_by_hari && $allow_by_count;
    $edit_url = site_url('booking/edit').'?t='.urlencode($booking->access_token ?? '');
  ?>

  <div class="row">
    <!-- Kartu profil ringkas (MENGIKUTI HTML ANDA, TANPA CSS TAMBAHAN) -->
    <div class="col-md-4">
      <div class="card-box text-center">
        <img
          src="<?php echo $foto_url ?: base_url('assets/images/users/user-1.jpg'); ?>"
          class="rounded-circle avatar-lg img-thumbnail"
          alt="profile-image">

        <h4 class="mb-0"><?php echo htmlspecialchars($booking->nama_tamu ?? '-', ENT_QUOTES, 'UTF-8'); ?></h4>
        <p class="text-muted">
          <span class="badge <?php echo $badgeCls; ?>"><?php echo htmlspecialchars($booking->status ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
          &nbsp;•&nbsp; Kode: <strong><?php echo $kode; ?></strong>
        </p>

        <a href="<?php echo site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?php echo urlencode($booking->access_token ?? '') ?>&dl=0"
           class="btn btn-success btn-xs waves-effect mb-2 waves-light" target="_blank">
           Lihat PDF
        </a>
        <a href="<?php echo site_url('booking/print_pdf/'.$booking->kode_booking) ?>?t=<?php echo urlencode($booking->access_token ?? '') ?>&dl=1"
           class="btn btn-danger btn-xs waves-effect mb-2 waves-light">
           Unduh PDF
        </a>

        <div class="text-left mt-3">
          <h4 class="font-13 text-uppercase">Ringkasan :</h4>
          <p class="text-muted font-13 mb-3">
            <?php echo htmlspecialchars($booking->keperluan ?? '-', ENT_QUOTES, 'UTF-8'); ?>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Full Name :</strong>
            <span class="ml-2"><?php echo htmlspecialchars($booking->nama_tamu ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Mobile :</strong>
            <span class="ml-2">
              <?php echo htmlspecialchars($booking->no_hp ?? '-', ENT_QUOTES, 'UTF-8'); ?>
              <?php if ($hp_wa): ?>
                <a class="ml-1" target="_blank" rel="noopener" href="https://wa.me/<?php echo $hp_wa; ?>"><i class="mdi mdi-whatsapp"></i></a>
              <?php endif; ?>
            </span>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Email :</strong>
            <span class="ml-2 "><?php echo htmlspecialchars($booking->email ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Instansi :</strong>
            <span class="ml-2"><?php echo $instansi; ?></span>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Unit Tujuan :</strong>
            <span class="ml-2"><?php echo $unit_nama; ?></span>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Nama <?php echo $unit_nama; ?> :</strong>
            <span class="ml-2"><?php echo $nama_petugas_instansi; ?></span>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Tanggal Kunjungan :</strong>
            <span class="ml-2"><?php echo $hari_tgl; ?></span>
          </p>

          <p class="text-muted mb-2 font-13">
            <strong>Jam :</strong>
            <span class="ml-2"><?php echo $jam; ?></span>
          </p>

          <?php if ($checkin_str): ?>
          <p class="text-muted mb-2 font-13">
            <strong>Check-in :</strong>
            <span class="ml-2"><?php echo htmlspecialchars($checkin_str, ENT_QUOTES, 'UTF-8'); ?></span>
          </p>
          <?php endif; ?>

          <?php if ($checkout_str): ?>
          <p class="text-muted mb-2 font-13">
            <strong>Check-out :</strong>
            <span class="ml-2"><?php echo htmlspecialchars($checkout_str, ENT_QUOTES, 'UTF-8'); ?></span>
          </p>
          <?php endif; ?>

          <?php if ($durasi): ?>
          <p class="text-muted mb-2 font-13">
            <strong>Durasi :</strong>
            <span class="ml-2"><?php echo htmlspecialchars($durasi, ENT_QUOTES, 'UTF-8'); ?></span>
          </p>
          <?php endif; ?>
        </div>

        <ul class="social-list list-inline mt-3 mb-0">
          <li class="list-inline-item">
            <a href="javascript:void(0)" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
          </li>
          <li class="list-inline-item">
            <a href="javascript:void(0)" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
          </li>
          <li class="list-inline-item">
            <a href="javascript:void(0)" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
          </li>
          <li class="list-inline-item">
            <a href="javascript:void(0)" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
          </li>
        </ul>
      </div>

      <!-- QR sederhana -->
      <div class="card-box text-center">
        <h5 class="mb-2">QR Code Booking</h5>
        <?php if ($qr_exists): ?>
          <img src="<?php echo $qr_url; ?>" alt="QR <?php echo $kode; ?>" class="img-thumbnail" style="max-width:180px;">
          <div class="mt-2">
            <a href="<?php echo $qr_url; ?>" download="qr_<?php echo $kode; ?>.png" class="btn btn-light btn-sm">Unduh QR</a>
          </div>
        <?php else: ?>
          <div class="text-muted small">QR belum tersedia.</div>
        <?php endif; ?>
      </div>

      <!-- Aksi Edit/Hapus -->
      <div class="card-box">
        <div class="d-flex">
          <a id="btnEdit" href="<?php echo $edit_url; ?>" class="btn btn-warning btn-sm mr-2">Edit Permohonan</a>

          <form id="formDelete" method="post" action="<?php echo site_url('booking/hapus'); ?>" class="ml-auto">
            <input type="hidden" name="t" value="<?php echo htmlspecialchars($booking->access_token ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="kode" value="<?php echo htmlspecialchars($booking->kode_booking ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <?php if (config_item('csrf_protection')): ?>
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <?php endif; ?>
            <button type="button" id="btnHapus" class="btn btn-outline-danger btn-sm">Hapus Permohonan</button>
          </form>
        </div>
        <p class="text-muted mt-2 mb-0" style="font-size:12px;">
          <?php if ((int)$batas_edit_view === 0): ?>
            Fitur ubah dinonaktifkan.
          <?php else: ?>
            Maks. edit <?php echo (int)$batas_edit_view; ?>x dan paling lambat H-<?php echo (int)$batas_hari_view; ?> sebelum hari kunjungan.
          <?php endif; ?>
        </p>
      </div>
    </div>

    <!-- Kolom kanan: pendamping, surat tugas, foto -->
    <div class="col-md-8">

      <!-- Daftar Pendamping -->
      <div class="card-box">
        <h5 class="mb-3">Daftar Pendamping
          <span class="badge badge-primary ml-1"><?php echo (int)$booking->jumlah_pendamping; ?> orang</span>
        </h5>

        <?php if (!empty($pendamping_rows)): ?>
          <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th style="width:60px;">No</th>
                  <th style="width:220px;">NIK</th>
                  <th>Nama</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($pendamping_rows as $i => $p): ?>
                <tr>
                  <td class="text-center"><?php echo $i + 1; ?></td>
                  <td><code><?php echo htmlspecialchars($p->nik ?? '-', ENT_QUOTES, 'UTF-8'); ?></code></td>
                  <td><?php echo htmlspecialchars($p->nama ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php elseif ((int)$booking->jumlah_pendamping > 0): ?>
          <div class="text-muted">Belum ada data pendamping.</div>
        <?php else: ?>
          <div class="text-muted">Tidak ada pendamping.</div>
        <?php endif; ?>
      </div>

      <!-- Surat Tugas -->
      <div class="card-box">
        <h5 class="mb-3">Surat Tugas</h5>
        <div class="mb-2">
          <?php if ($surat_url): ?>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalSuratTugas_<?php echo $kode_safe; ?>">
              <i class="mdi mdi-file-pdf-box"></i> Lihat
            </button>
            <a class="btn btn-outline-secondary btn-sm" href="<?php echo $surat_url; ?>" download>
              <i class="mdi mdi-download"></i> Unduh
            </a>
          <?php else: ?>
            <span class="text-muted">Belum ada surat tugas.</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Foto -->
      <div class="card-box">
        <h5 class="mb-3">Foto</h5>
        <div class="mb-2">
          <?php if (!empty($foto_url)): ?>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFoto_<?php echo $kode_safe; ?>">
              <i class="mdi mdi-eye"></i> Lihat
            </button>
            <a href="<?php echo $foto_url; ?>" download class="btn btn-outline-secondary btn-sm">
              <i class="mdi mdi-download"></i> Unduh
            </a>
          <?php else: ?>
            <span class="text-muted">Belum ada dokumentasi. Foto dapat dilakukan saat check-in.</span>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

  <!-- Modal Surat Tugas -->
  <div class="modal fade" id="modalSuratTugas_<?php echo $kode_safe; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header py-2">
          <h6 class="modal-title"><i class="mdi mdi-file-document"></i> Surat Tugas</h6>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body p-0">
          <?php if (!empty($surat_url)): ?>
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="<?php echo $surat_url; ?>#toolbar=1&navpanes=0&scrollbar=1" allowfullscreen></iframe>
            </div>
          <?php else: ?>
            <div class="p-4 text-muted">Belum ada surat tugas.</div>
          <?php endif; ?>
        </div>
        <div class="modal-footer py-2">
          <?php if (!empty($surat_url)): ?>
            <a class="btn btn-outline-secondary" href="<?php echo $surat_url; ?>" download><i class="mdi mdi-download"></i> Unduh</a>
          <?php endif; ?>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Foto -->
  <div class="modal fade" id="modalFoto_<?php echo $kode_safe; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header py-2">
          <h6 class="modal-title"><i class="mdi mdi-image"></i> Foto Lampiran</h6>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body text-center">
          <img id="foto_modal_img" src="<?php echo $foto_url ?? ''; ?>" class="img-fluid" alt="Foto Lampiran">
        </div>
        <div class="modal-footer py-2">
          <?php if (!empty($foto_url)): ?>
            <a class="btn btn-outline-secondary" href="<?php echo $foto_url; ?>" download><i class="mdi mdi-download"></i> Unduh</a>
          <?php endif; ?>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <?php else: ?>
    <div class="text-center py-5">
      <h4 class="mb-2">Tidak ada detail untuk ditampilkan</h4>
      <p class="text-muted">Silakan lakukan booking atau buka tautan detail yang valid.</p>
      <a href="<?php echo site_url('booking'); ?>" class="btn btn-primary">Kembali ke Form Booking</a>
    </div>
  <?php endif; ?>

</div>

<?php $this->load->view("front_end/footer.php") ?>

<script>
// Notifikasi WA sekali saat halaman dibuka (tanpa CSS tambahan)
document.addEventListener('DOMContentLoaded', function () {
  var token = <?php echo json_encode($booking->access_token ?? null); ?>;
  if (!token) return;

  var guardKey = 'wa_notified_' + token;
  if (sessionStorage.getItem(guardKey)) return;

  var url = "<?php echo site_url('booking/wa_notify'); ?>";
  var params = new URLSearchParams();
  params.set('t', token);
  <?php if (config_item('csrf_protection')): ?>
    params.set('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
  <?php endif; ?>

  fetch(url, {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'},
    body: params.toString(),
    credentials: 'same-origin'
  })
  .then(function(res){ if (res.ok) sessionStorage.setItem(guardKey, '1'); })
  .catch(function(){});
});

// Edit guard sederhana (pakai alert() saja)
(function(){
  var canEdit = <?php echo json_encode($can_edit); ?>;
  var btn = document.getElementById('btnEdit');
  if (!btn) return;
  btn.addEventListener('click', function(e){
    if (!canEdit) {
      e.preventDefault();
      alert('Edit tidak tersedia. Silakan hapus dan buat permohonan baru.');
    }
  });
})();

// Hapus (konfirmasi + submit form POST)
(function(){
  var b = document.getElementById('btnHapus');
  if (!b) return;
  b.addEventListener('click', function(){
    if (confirm('Hapus permohonan ini secara permanen?')) {
      document.getElementById('formDelete').submit();
    }
  });
})();
</script>
