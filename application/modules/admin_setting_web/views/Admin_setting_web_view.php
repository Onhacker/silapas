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
              <div class="form-group col-md-6">
                <label class="text-primary" for="waktu">Zona Waktu</label>
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
              <div class="form-group col-md-6">
                <label class="text-primary" for="min_lead_minutes">Minimal Jeda Booking (menit)</label>
                <input type="number" class="form-control" id="min_lead_minutes" name="min_lead_minutes"
                       min="0" max="1440" step="1"
                       value="<?= isset($record->min_lead_minutes)?(int)$record->min_lead_minutes:10; ?>">
                <small class="text-info">Contoh: 10 = slot paling cepat 10 menit dari sekarang.</small>
              </div>
            </div>

            <!-- Integrasi WhatsApp -->
            <div class="form-row">
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
