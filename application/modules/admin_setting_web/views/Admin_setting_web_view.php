<div class="container-fluid">
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><?= $title ?></li>
            <li class="breadcrumb-item active"><?= $subtitle ?></li>
          </ol>
        </div>
        <h4 class="page-title"><?= $subtitle ?></h4>
      </div>
    </div>
  </div>

  <!-- FORM IDENTITAS + PENGATURAN -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <form id="form_app" method="post" enctype="multipart/form-data">
            <?php
              // helper kecil untuk ambil nilai
              function v($rec, $k, $def=''){ return isset($rec->$k) ? $rec->$k : $def; }
              $days = ['mon'=>'Senin','tue'=>'Selasa','wed'=>'Rabu','thu'=>'Kamis','fri'=>'Jumat','sat'=>'Sabtu','sun'=>'Minggu'];
            ?>

            <!-- ========= 1) IDENTITAS WEBSITE ========= -->
            <h5 class="mb-3 text-uppercase bg-blue p-2 text-white">
              <i class="fe-globe mr-1"></i> Identitas Website
            </h5>

            <div class="form-group mb-3">
              <label class="text-primary" for="nama_website">Nama Sistem</label>
              <input type="text" class="form-control" id="nama_website" name="nama_website"
                     value="<?= v($record,'nama_website') ?>">
            </div>

            <div class="form-group mb-3">
              <label class="text-primary" for="url">URL Aplikasi</label>
              <input type="url" class="form-control" id="url" name="url"
                     placeholder="https://domain.tld/"
                     value="<?= v($record,'url') ?>">
              <small class="text-muted">Pastikan diawali http:// atau https://</small>
            </div>

            <div class="form-group mb-3">
              <label class="text-primary" for="meta_deskripsi">Meta Deskripsi</label>
              <textarea class="form-control" id="meta_deskripsi" name="meta_deskripsi" rows="2"><?= v($record,'meta_deskripsi') ?></textarea>
            </div>

            <!-- Favicon -->
            <div class="form-group mb-4">
              <label class="text-primary" for="favicon">Favicon</label>
              <input type="file" class="form-control-file" id="favicon" name="favicon" accept=".ico,.png,.jpg,.jpeg,.gif">
              <small class="text-muted d-block">Maks 1 MB. Disimpan sebagai <code>assets/images/favicon.*</code></small>
            </div>

            <!-- ========= 2) KONTAK ========= -->
            <h5 class="mb-3 text-uppercase bg-light p-2">
              <i class="fe-user mr-1"></i> Kontak
            </h5>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= v($record,'email') ?>">
                <small class="text-info">Dipakai sebagai pengirim notifikasi (reset password, dll).</small>
              </div>
              <div class="form-group col-md-3">
                <label class="text-primary" for="no_telp">No. HP / WhatsApp</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp"
                       value="<?= v($record,'no_telp') ?>">
              </div>
              <div class="form-group col-md-3">
                <label class="text-primary" for="telp">Telepon Kantor</label>
                <input type="text" class="form-control" id="telp" name="telp"
                       value="<?= v($record,'telp') ?>">
              </div>
            </div>

            <!-- ========= 3) LOKASI ========= -->
            <h5 class="mb-3 text-uppercase bg-light p-2">
              <i class="fe-map-pin mr-1"></i> Lokasi
            </h5>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="provinsi">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi"
                       value="<?= v($record,'provinsi') ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="kabupaten">Kabupaten / Kota</label>
                <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                       value="<?= v($record,'kabupaten') ?>">
              </div>
            </div>
            <div class="form-group mb-4">
              <label class="text-primary" for="alamat">Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= v($record,'alamat') ?></textarea>
            </div>

            <!-- ========= 4) SEO & SOSIAL ========= -->
            <h5 class="mb-3 text-uppercase bg-light p-2">
              <i class="fe-hash mr-1"></i> SEO & Sosial Media
            </h5>
            <div class="form-group mb-3">
              <label class="text-primary" for="meta_keyword">Meta Keyword</label>
              <textarea class="form-control" id="meta_keyword" name="meta_keyword" rows="2"
                        placeholder="pisahkan dengan koma, contoh: silaturahmi, kunjungan, lapas"><?= v($record,'meta_keyword') ?></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="instagram">Instagram (URL)</label>
                <input type="text" class="form-control" id="instagram" name="instagram"
                       placeholder="https://instagram.com/akun"
                       value="<?= v($record,'instagram') ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="facebook">Facebook (URL)</label>
                <input type="text" class="form-control" id="facebook" name="facebook"
                       placeholder="https://facebook.com/halaman"
                       value="<?= v($record,'facebook') ?>">
              </div>
            </div>

            <!-- ========= 5) PETA ========= -->
            <h5 class="mb-3 text-uppercase bg-light p-2">
              <i class="fe-map mr-1"></i> Peta Lokasi
            </h5>
            <div class="form-group mb-4">
              <label class="text-primary" for="maps">Google Maps (Embed/Share URL)</label>
              <input type="text" class="form-control" id="maps" name="maps"
                     placeholder="https://www.google.com/maps/..."
                     value="<?= v($record,'maps') ?>">
            </div>

            <hr class="my-4">

            <!-- ========= 6) PENGATURAN SISTEM ========= -->
            <h5 class="mb-3 text-uppercase bg-warning p-2 text-dark">
              <i class="fe-settings mr-1"></i> Pengaturan Sistem
            </h5>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label class="text-primary" for="waktu">Zona Waktu <?php echo date("H:i") ?></label>
                <?php
                  $arr_waktu = [
                    "Asia/Jakarta"  => "WIB (Asia/Jakarta)",
                    "Asia/Makassar" => "WITA (Asia/Makassar)",
                    "Asia/Jayapura" => "WIT (Asia/Jayapura)",
                  ];
                  $waktu = v($record,'waktu','Asia/Makassar');
                  echo form_dropdown("waktu",$arr_waktu,$waktu,'id="waktu" class="form-control"');
                ?>
              </div>

              <div class="form-group col-md-3">
                <label class="text-primary" for="batas_edit">Batas Maksimal Ubah Booking</label>
                <input type="number" class="form-control" id="batas_edit" name="batas_edit"
                       min="0" max="5" step="1"
                       value="<?= (int) v($record,'batas_edit',1) ?>">
                <small class="text-danger">Pengunjung diperbolehkan Merubah Bookingan sebanyak X kali.</small>
              </div>

              <div class="form-group col-md-3">
                <label class="text-primary" for="batas_hari">Batas Jumlah Hari Maksimal Ubah Booking</label>
                <input type="number" class="form-control" id="batas_hari" name="batas_hari"
                       min="0" max="5" step="1"
                       value="<?= (int) v($record,'batas_hari',2) ?>">
                <small class="text-danger">Set 0 untuk antisipasi edit jika booking & kunjungan di hari yang sama.</small>
              </div>

              <div class="form-group col-md-3">
                <label class="text-primary" for="min_lead_minutes">Jeda Minimum Booking (menit)</label>
                <input type="number" class="form-control" id="min_lead_minutes" name="min_lead_minutes"
                       min="0" max="1440" step="1"
                       value="<?= (int) v($record,'min_lead_minutes',10) ?>">
                <small class="text-danger">Contoh: 10 → jam kunjungan tercepat adalah sekarang + 10 menit.</small>
              </div>

              <div class="form-group col-md-3">
                <label class="text-primary" for="early_min">Batas Datang Lebih Awal (menit)</label>
                <input type="number" class="form-control" id="early_min" name="early_min"
                       min="0" max="1440" step="1"
                       value="<?= (int) v($record,'early_min',10) ?>">
                <small class="text-danger">Contoh: 10 → boleh check-in 10 menit lebih awal.</small>
              </div>

              <div class="form-group col-md-3">
                <label class="text-primary" for="late_min">Batas Keterlambatan (menit)</label>
                <input type="number" class="form-control" id="late_min" name="late_min"
                       min="0" max="1440" step="1"
                       value="<?= (int) v($record,'late_min',60) ?>">
                <small class="text-danger">Contoh: 60 → toleransi terlambat 60 menit.</small>
              </div>
            </div>

            <!-- ========= 7) JAM OPERASIONAL ========= -->
            <h5 class="mb-3 text-uppercase bg-success p-2 text-white">
              <i class="fe-clock mr-1"></i> Jam Operasional (per Hari)
            </h5>

            <div class="table-responsive">
              <table class="table table-sm table-bordered mb-2">
                <thead class="thead-light">
                  <tr class="text-center">
                    <th style="width:14%">Hari</th>
                    <th style="width:18%">Buka</th>
                    <th style="width:22%">Istirahat Mulai</th>
                    <th style="width:22%">Istirahat Selesai</th>
                    <th style="width:18%">Tutup</th>
                    <th style="width:6%">Libur</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($days as $key=>$label): 
                    $o  = v($record, "op_{$key}_open");
                    $bs = v($record, "op_{$key}_break_start");
                    $be = v($record, "op_{$key}_break_end");
                    $c  = v($record, "op_{$key}_close");
                    $cl = (int) v($record, "op_{$key}_closed");
                  ?>
                  <tr data-day="<?= $key ?>">
                    <td><strong><?= $label ?></strong></td>
                    <td><input type="time" class="form-control form-control-sm" name="op_<?= $key ?>_open" value="<?= $o ?>"></td>
                    <td><input type="time" class="form-control form-control-sm" name="op_<?= $key ?>_break_start" value="<?= $bs ?>"></td>
                    <td><input type="time" class="form-control form-control-sm" name="op_<?= $key ?>_break_end" value="<?= $be ?>"></td>
                    <td><input type="time" class="form-control form-control-sm" name="op_<?= $key ?>_close" value="<?= $c ?>"></td>
                    <td class="text-center align-middle">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input day-closed" id="op_<?= $key ?>_closed"
                               name="op_<?= $key ?>_closed" <?= $cl ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="op_<?= $key ?>_closed"></label>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <small class="text-muted d-block">
                • Kosongkan jam istirahat bila tidak ada.<br>
                • Jika <b>Libur</b> dicentang, semua input jam hari tersebut akan dinonaktifkan saat simpan.
              </small>
            </div>

            <!-- ========= 8) INTEGRASI WHATSAPP ========= -->
            <h5 class="mb-3 text-uppercase bg-success p-2 text-white">
              <i class="fe-message-circle mr-1"></i> Integrasi Notifikasi WhatsApp
            </h5>
            <div class="form-row mt-2">
              <div class="form-group col-md-6">
                <label class="text-primary" for="wa_api_token">WA API Token</label>
                <input type="password" class="form-control" id="wa_api_token" name="wa_api_token"
                       value="<?= v($record,'wa_api_token') ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="wa_api_secret">WA API Secret Key</label>
                <input type="password" class="form-control" id="wa_api_secret" name="wa_api_secret"
                       value="<?= v($record,'wa_api_secret') ?>">
              </div>
            </div>
            <div class="form-group mb-4">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="showWaSecret">
                <label class="custom-control-label" for="showWaSecret">Tampilkan token/secret</label>
              </div>
            </div>

            <!-- ========= 9) SMTP EMAIL ========= -->
            <h5 class="mb-3 text-uppercase bg-info p-2 text-white">
              <i class="fe-mail mr-1"></i> Notifikasi ke Email Pengunjung
            </h5>

            <div class="form-row">
              <div class="form-group col-md-3">
                <div class="custom-control custom-checkbox mt-4">
                  <input type="checkbox" class="custom-control-input" id="smtp_active" name="smtp_active"
                         <?= !empty($record->smtp_active) ? 'checked' : '' ?>>
                  <label class="custom-control-label" for="smtp_active">Aktifkan SMTP</label>
                </div>
              </div>
              <div class="form-group col-md-5">
                <label class="text-primary" for="smtp_host">SMTP Host</label>
                <input type="text" class="form-control" id="smtp_host" name="smtp_host"
                       placeholder="contoh: smtp.gmail.com (Gmail)"
                       value="<?= v($record,'smtp_host') ?>">
                <small class="text-muted d-block">
                  Contoh lain: <code>smtp-mail.outlook.com</code> (Outlook), <code>email-smtp.&lt;region&gt;.amazonaws.com</code> (Amazon SES)
                </small>
              </div>
              <div class="form-group col-md-2">
                <label class="text-primary" for="smtp_port">Port</label>
                <input type="number" class="form-control" id="smtp_port" name="smtp_port" min="1" max="65535" step="1"
                       placeholder="465/587"
                       value="<?= (int) v($record,'smtp_port',465) ?>">
              </div>
              <div class="form-group col-md-2">
                <label class="text-primary" for="smtp_crypto">Enkripsi</label>
                <?php $cry = strtolower(v($record,'smtp_crypto','ssl')); ?>
                <select id="smtp_crypto" name="smtp_crypto" class="form-control">
                  <option value=""      <?= $cry===''?'selected':''; ?>>(none)</option>
                  <option value="ssl"   <?= $cry==='ssl'?'selected':''; ?>>SSL (465)</option>
                  <option value="tls"   <?= $cry==='tls'?'selected':''; ?>>TLS (587)</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="smtp_user">Username</label>
                <input type="text" class="form-control" id="smtp_user" name="smtp_user"
                       placeholder="akun@gmail.com (Gmail) / kredensial SMTP Anda"
                       value="<?= v($record,'smtp_user') ?>">
              </div>
              <div class="form-group col-md-4">
                <label class="text-primary" for="smtp_pass">Password</label>
                <input type="password" class="form-control" id="smtp_pass" name="smtp_pass" value=""
                       placeholder="App Password (Gmail) / SMTP Password">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
              </div>
              <div class="form-group col-md-2 d-flex align-items-end">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="showSmtpPass">
                  <label class="custom-control-label" for="showSmtpPass">Tampilkan</label>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="smtp_from">From Email</label>
                <input type="email" class="form-control" id="smtp_from" name="smtp_from"
                       placeholder="akun@gmail.com (disarankan sama dengan Username)"
                       value="<?= v($record,'smtp_from') ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="smtp_from_name">From Name</label>
                <input type="text" class="form-control" id="smtp_from_name" name="smtp_from_name"
                       placeholder="<?= htmlspecialchars(v($record,'nama_website','Aplikasi'), ENT_QUOTES) ?>"
                       value="<?= v($record,'smtp_from_name') ?>">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-8">
                <label class="text-primary" for="smtp_test_to">Uji Kirim ke Email</label>
                <input type="email" class="form-control" id="smtp_test_to" placeholder="nama@example.com">
                <small class="text-muted">
                  Simpan dulu pengaturan, lalu klik Test SMTP. <br>
                  <b>Catatan Gmail:</b> gunakan <i>App Password</i> + aktifkan 2FA. Gunakan TLS (587) atau SSL (465).
                </small>
              </div>
              <div class="form-group col-md-4 d-flex align-items-end">
                <button type="button" class="btn btn-outline-info btn-block" onclick="testSmtp()">Test SMTP</button>
              </div>
            </div>

            <!-- ========= 10) LAINNYA ========= -->
            <h5 class="mb-3 text-uppercase bg-light p-2">
              <i class="fe-more-horizontal mr-1"></i> Lainnya
            </h5>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="type">Tipe Instansi</label>
                <input type="text" class="form-control" id="type" name="type"
                       value="<?= v($record,'type') ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="credits">Credits</label>
                <input type="text" class="form-control" id="credits" name="credits"
                       placeholder="Nama/URL pengembang"
                       value="<?= v($record,'credits') ?>">
              </div>
            </div>

            <!-- Tombol -->
            <div class="row">
              <div class="col-6">
                <a href="javascript:void(0)" onclick="update()" class="btn btn-primary btn-block">Update</a>
              </div>
              <div class="col-6">
                <button type="reset" onclick="home()" class="btn btn-secondary btn-block">Batal</button>
              </div>
            </div>
          </form>

        </div><!-- card-body -->
      </div>
    </div>
  </div>
</div>

<!-- ========= SCRIPTS ========= -->
<script>
// Toggle tampil/hidden untuk WA token & secret
document.addEventListener('DOMContentLoaded', function(){
  var chk = document.getElementById('showWaSecret');
  var t1  = document.getElementById('wa_api_token');
  var t2  = document.getElementById('wa_api_secret');
  if (chk && t1 && t2){
    chk.addEventListener('change', function(){
      var type = chk.checked ? 'text' : 'password';
      t1.type = type; t2.type = type;
    });
  }
});

// Toggle tampil/hidden untuk SMTP password
document.addEventListener('DOMContentLoaded', function(){
  var chk = document.getElementById('showSmtpPass');
  var p   = document.getElementById('smtp_pass');
  if (chk && p) chk.addEventListener('change', function(){
    p.type = chk.checked ? 'text' : 'password';
  });
});

// Validasi jam operasional per-hari
document.addEventListener('DOMContentLoaded', function(){
  const rows = document.querySelectorAll('tr[data-day]');
  const toMin = v => {
    if (!v) return null;
    const m = /^(\d{2}):(\d{2})$/.exec(v.trim());
    if (!m) return null;
    return (+m[1])*60 + (+m[2]);
  };

  rows.forEach(tr => {
    const day = tr.getAttribute('data-day');
    const el = {
      open:  tr.querySelector(`[name="op_${day}_open"]`),
      bs:    tr.querySelector(`[name="op_${day}_break_start"]`),
      be:    tr.querySelector(`[name="op_${day}_break_end"]`),
      close: tr.querySelector(`[name="op_${day}_close"]`),
      closed:tr.querySelector(`#op_${day}_closed`)
    };

    function toggleClosed(){
      const dis = el.closed.checked;
      [el.open, el.bs, el.be, el.close].forEach(x => { if (x) x.disabled = dis; });
      if (dis){ [el.open, el.bs, el.be, el.close].forEach(x => { if (x) x.setCustomValidity(''); }); }
    }

    function validateRanges(){
      [el.open, el.bs, el.be, el.close].forEach(x => { if (x) x.setCustomValidity(''); });
      if (el.closed.checked) return;

      const o  = toMin(el.open?.value);
      const c  = toMin(el.close?.value);
      const bs = toMin(el.bs?.value);
      const be = toMin(el.be?.value);

      if (o===null || c===null || o>=c){
        el.close?.setCustomValidity('Jam tutup harus > jam buka');
        return;
      }
      if ((bs!==null || be!==null) && !(bs!==null && be!==null)){
        (el.bs?.setCustomValidity('Lengkapi jam istirahat'), el.be?.setCustomValidity('Lengkapi jam istirahat'));
        return;
      }
      if (bs!==null && be!==null){
        if (!(o<=bs && bs<be && be<=c)){
          el.be?.setCustomValidity('Istirahat harus di dalam rentang buka–tutup');
          return;
        }
      }
    }

    ['input','change'].forEach(evt=>{
      [el.open, el.bs, el.be, el.close].forEach(x => x && x.addEventListener(evt, validateRanges));
      el.closed && el.closed.addEventListener(evt, ()=>{ toggleClosed(); validateRanges(); });
    });

    toggleClosed();
    validateRanges();
  });
});

// Test SMTP
function testSmtp(){
  const to = document.getElementById('smtp_test_to')?.value.trim();
  if(!to){
    if (window.Swal) {
      Swal.fire({icon:'warning', title:'Email tujuan kosong', text:'Isi email yang akan menerima email uji.'});
    } else {
      alert('Isi email tujuan uji terlebih dahulu');
    }
    return;
  }

  const url  = '<?= site_url('admin_setting_web/smtp_test'); ?>';
  const body = new URLSearchParams();
  body.append('to', to);
  body.append('<?= $this->security->get_csrf_token_name(); ?>', '<?= $this->security->get_csrf_hash(); ?>');

  if (window.Swal) {
    Swal.fire({
      title: 'Mengirim email uji…',
      html: 'Harap tunggu sebentar',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });
  }

  fetch(url, {
    method: 'POST',
    headers: {
      'X-Requested-With':'XMLHttpRequest',
      'Content-Type':'application/x-www-form-urlencoded'
    },
    body: body.toString()
  })
  .then(r => r.ok ? r.json() : Promise.reject({status:r.status, message:'HTTP '+r.status}))
  .then(j => {
    if (window.Swal) {
      Swal.fire({
        icon: j.success ? 'success' : 'error',
        title: j.success ? 'Berhasil' : 'Gagal',
        html: j.pesan || (j.success ? 'Email uji terkirim.' : 'Gagal mengirim email uji.')
      });
    } else {
      alert((j.success?'OK: ':'Gagal: ')+ (j.pesan||''));
    }
    // optional: refresh CSRF bila backend mengirimkan token baru
    if (j.csrf_name && j.csrf_hash){
      document.querySelectorAll('input[name="'+j.csrf_name+'"]').forEach(i=>i.value=j.csrf_hash);
    }
  })
  .catch(e => {
    if (window.Swal) {
      Swal.fire({icon:'error', title:'Error', text: e?.message || 'Terjadi masalah koneksi.'});
    } else {
      alert('Error: '+(e?.message||e));
    }
  });
}

</script>

<?php $this->load->view($controller."_js"); ?>
