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
            <!-- ========= IDENTITAS WEBSITE ========= -->
            <h5 class="mb-3 text-uppercase bg-blue p-2 text-white">

              <i class="fe-globe mr-1"></i> Identitas Website
            </h5>

            <!-- Nama Sistem & URL -->
            <div class="form-group mb-3">
              <label class="text-primary" for="nama_website">Nama Sistem</label>
              <input type="text" class="form-control" id="nama_website" name="nama_website"
                     value="<?= isset($record->nama_website)?$record->nama_website:''; ?>">
            </div>

            <div class="form-group mb-3">
              <label class="text-primary" for="meta_deskripsi">Meta Deskripsi</label>
              <textarea class="form-control" id="meta_deskripsi" name="meta_deskripsi" rows="2"><?= isset($record->meta_deskripsi)?$record->meta_deskripsi:''; ?></textarea>
            </div>

            <div class="form-group mb-3">
              <label class="text-primary" for="url">URL Aplikasi</label>
              <input type="url" class="form-control" id="url" name="url"
                     placeholder="https://domain.tld/"
                     value="<?= isset($record->url)?$record->url:''; ?>">
              <small class="text-muted">Pastikan diawali http:// atau https://</small>
            </div>

            <!-- Kontak -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= isset($record->email)?$record->email:''; ?>">
                <small class="text-info">Dipakai sebagai pengirim notifikasi (reset password, dll).</small>
              </div>
              <div class="form-group col-md-3">
                <label class="text-primary" for="no_telp">No. HP / WhatsApp</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp"
                       value="<?= isset($record->no_telp)?$record->no_telp:''; ?>">
              </div>
              <div class="form-group col-md-3">
                <label class="text-primary" for="telp">Telepon Kantor</label>
                <input type="text" class="form-control" id="telp" name="telp"
                       value="<?= isset($record->telp)?$record->telp:''; ?>">
              </div>
            </div>

            <!-- Lokasi Administratif -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="provinsi">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi"
                       value="<?= isset($record->provinsi)?$record->provinsi:''; ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="kabupaten">Kabupaten / Kota</label>
                <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                       value="<?= isset($record->kabupaten)?$record->kabupaten:''; ?>">
              </div>
            </div>

            <div class="form-group mb-3">
              <label class="text-primary" for="alamat">Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= isset($record->alamat)?$record->alamat:''; ?></textarea>
            </div>

            <!-- Meta SEO -->
            <div class="form-group mb-3">
              <label class="text-primary" for="meta_keyword">Meta Keyword</label>
              <textarea class="form-control" id="meta_keyword" name="meta_keyword" rows="2"
                        placeholder="pisahkan dengan koma, contoh: silaturahmi, kunjungan, lapas"><?= isset($record->meta_keyword)?$record->meta_keyword:''; ?></textarea>
            </div>

            <!-- Sosial Media -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="instagram">Instagram (URL)</label>
                <input type="text" class="form-control" id="instagram" name="instagram"
                       placeholder="https://instagram.com/akun"
                       value="<?= isset($record->instagram)?$record->instagram:''; ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="facebook">Facebook (URL)</label>
                <input type="text" class="form-control" id="facebook" name="facebook"
                       placeholder="https://facebook.com/halaman"
                       value="<?= isset($record->facebook)?$record->facebook:''; ?>">
              </div>
            </div>

            <!-- Maps -->
            <div class="form-group mb-3">
              <label class="text-primary" for="maps">Google Maps (Embed/Share URL)</label>
              <input type="text" class="form-control" id="maps" name="maps"
                     placeholder="https://www.google.com/maps/..."
                     value="<?= isset($record->maps)?$record->maps:''; ?>">
            </div>

            <!-- Favicon -->
          

            <hr class="my-4">

            <!-- ========= PENGATURAN SISTEM ========= -->
            <h5 class="mb-3 text-uppercase bg-warning p-2 text-dark">
              <i class="fe-settings mr-1"></i> Pengaturan Sistem
            </h5>

            <!-- Waktu & Lead time -->
            <div class="form-row">
              <div class="form-group col-md-12">
                <label class="text-primary" for="waktu">Zona Waktu <?php echo date("H:i") ?></label>
                <?php
                  $arr_waktu = [
                    "Asia/Jakarta"  => "WIB (Asia/Jakarta)",
                    "Asia/Makassar" => "WITA (Asia/Makassar)",
                    "Asia/Jayapura" => "WIT (Asia/Jayapura)",
                  ];
                  $waktu = isset($record->waktu)?$record->waktu:"Asia/Makassar";
                  echo form_dropdown("waktu",$arr_waktu,$waktu,'id="waktu" class="form-control"');
                ?>
              </div>
              <div class="form-group col-md-3">
                <label class="text-primary" for="batas_edit">Batas Maksimal Ubah Booking</label>
                <input type="number" class="form-control" id="batas_edit" name="batas_edit"
                min="0" max="5" step="1"
                value="<?= isset($record->batas_edit)?(int)$record->batas_edit:1; ?>">
                <small class="text-danger">
                  Pengunjung diperbolehkan Merubah Bookingan sebanyak X Kali
                </small>
              </div>
              <div class="form-group col-md-3">
                <label class="text-primary" for="batas_hari">Batas Jumlah hari Maksimal Ubah Booking</label>
                <input type="number" class="form-control" id="batas_hari" name="batas_hari"
                min="0" max="5" step="1"
                value="<?= isset($record->batas_hari)?(int)$record->batas_hari:2; ?>">
                <small class="text-danger">
                  Pengunjung diperbolehkan Merubah Bookingan maksimal X Hari sebelum hari kunjungan. Set 0 untuk antisipasi edit jika bookingan dan kunjungan di hari yang sama
                </small>
              </div>


              <div class="form-group col-md-3">
                  <label class="text-primary" for="min_lead_minutes">Jeda Minimum Booking (menit)</label>
                  <input type="number" class="form-control" id="min_lead_minutes" name="min_lead_minutes"
                  min="0" max="1440" step="1"
                  value="<?= isset($record->min_lead_minutes)?(int)$record->min_lead_minutes:10; ?>">
                  <small class="text-danger">
                    Contoh: isi <b>10</b> berarti jam kunjungan paling cepat yang bisa dipilih adalah
                    <b><?= date('H:i'); ?></b> + 10 menit. Tujuannya agar waktu booking dan checkin tidak terlalu mepet
                    sehingga mengurangi risiko gagal check-in. Hal ini terjadi jika pengunjung melakukan booking dan checkin di hari yang sama. Membatasi jam kunjungan minimum saat booking dibuat → ada jeda persiapan.
                </small>
            </div>

            <div class="form-group col-md-3">
              <label class="text-primary" for="early_min">Batas Datang Lebih Awal (menit)</label>
              <input type="number" class="form-control" id="early_min" name="early_min"
              min="0" max="1440" step="1"
              value="<?= isset($record->early_min)?(int)$record->early_min:10; ?>">
              <small class="text-danger">
                Pengunjung diperbolehkan check-in maksimal <b>X</b> menit sebelum jam kunjungan terjadwal.
                (Contoh: isi 10 → boleh checkin 10 menit lebih awal dari jam kunjungan terjadwal.)
              </small>
            </div>

        <div class="form-group col-md-3">
              <label class="text-primary" for="late_min">Batas Keterlambatan (menit)</label>
              <input type="number" class="form-control" id="late_min" name="late_min"
              min="0" max="1440" step="1"
              value="<?= isset($record->late_min)?(int)$record->late_min:60; ?>">
              <small class="text-danger">
                Pengunjung masih diperbolehkan check-in hingga <b>X</b> menit setelah jam kunjungan terjadwal.
                (Contoh: isi 60 → toleransi terlambat 60 menit.)
            </small>
        </div>
     </div>
<!-- ========= JAM OPERASIONAL (PER HARI + ISTIRAHAT) ========= -->
<h5 class="mb-3 text-uppercase bg-success p-2 text-white">
  <i class="fe-clock mr-1"></i> Jam Operasional (per Hari)
</h5>

<?php
  // helper kecil untuk nilai default
  function v($rec, $k, $def=''){ return isset($rec->$k) ? $rec->$k : $def; }
  // $defaults = [
  //   'mon' => ['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
  //   'tue' => ['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
  //   'wed' => ['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
  //   'thu' => ['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
  //   'fri' => ['open'=>'08:00','break_start'=>'11:30','break_end'=>'13:00','close'=>'14:00','closed'=>0],
  //   'sat' => ['open'=>'08:00','break_start'=>'','break_end'=>'','close'=>'11:30','closed'=>0],
  //   'sun' => ['open'=>'','break_start'=>'','break_end'=>'','close'=>'','closed'=>1],
  // ];
  $days = [
    'mon'=>'Senin','tue'=>'Selasa','wed'=>'Rabu','thu'=>'Kamis','fri'=>'Jumat','sat'=>'Sabtu','sun'=>'Minggu'
  ];
?>

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
        $def = $defaults[$key];
        $o = v($record, "op_{$key}_open");
        $bs= v($record, "op_{$key}_break_start");
        $be= v($record, "op_{$key}_break_end");
        $c = v($record, "op_{$key}_close");
        $cl= (int) v($record, "op_{$key}_closed");
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

<script>
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
</script>



            <!-- Integrasi WhatsApp -->
            <div class="form-row mt-2">
              <div class="form-group col-md-6">
                <label class="text-primary" for="wa_api_token">WA API Token</label>
                <input type="password" class="form-control" id="wa_api_token" name="wa_api_token"
                       value="<?= isset($record->wa_api_token)?$record->wa_api_token:''; ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="wa_api_secret">WA API Secret Key</label>
                <input type="password" class="form-control" id="wa_api_secret" name="wa_api_secret"
                       value="<?= isset($record->wa_api_secret)?$record->wa_api_secret:''; ?>">
              </div>
            </div>
            <div class="form-group mb-4">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="showWaSecret">
                <label class="custom-control-label" for="showWaSecret">Tampilkan token/secret</label>
              </div>
            </div>

            <!-- Lainnya -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="text-primary" for="type">Tipe Instansi</label>
                <input type="text" class="form-control" id="type" name="type"
                       value="<?= isset($record->type)?$record->type:''; ?>">
              </div>
              <div class="form-group col-md-6">
                <label class="text-primary" for="credits">Credits</label>
                <input type="text" class="form-control" id="credits" name="credits"
                       placeholder="Nama/URL pengembang"
                       value="<?= isset($record->credits)?$record->credits:''; ?>">
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

<script>
// Toggle tampil/hidden untuk WA token & secret
document.addEventListener('DOMContentLoaded', function(){
  var chk = document.getElementById('showWaSecret');
  var t1  = document.getElementById('wa_api_token');
  var t2  = document.getElementById('wa_api_secret');
  if (!chk || !t1 || !t2) return;
  chk.addEventListener('change', function(){
    var type = chk.checked ? 'text' : 'password';
    t1.type = type; t2.type = type;
  });
});
</script>

<?php $this->load->view($controller."_js"); ?>
