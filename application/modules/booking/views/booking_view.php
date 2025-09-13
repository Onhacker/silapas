<?php $this->load->view("front_end/head.php") ?>
<style>
  /* ====== Poles Tampilan ====== */
  .card-elev {
    border: 0;
    border-radius: 14px;
    box-shadow: 0 6px 22px rgba(0,0,0,.06);
  }
  .section-title {
    font-size: 14px;
    letter-spacing: .04em;
    text-transform: uppercase;
    color: #6c757d;
    margin-bottom: .75rem;
    font-weight: 600;
  }
  .form-label { font-weight: 600; }
  .label-required::after{ content:" *"; color:#dc3545; font-weight:700; }
  .small-muted{ color:#6c757d; font-size:.85rem; }
  .help-hint{ font-size:.8rem; color:#6c757d; }
  .btn-blue{ background: linear-gradient(90deg,#2563eb,#1d4ed8); border:0; }
  .btn-blue:hover{ filter: brightness(1.05); }
  .divider-soft{
    height:1px; background:linear-gradient(to right,transparent,#e9ecef,transparent);
    margin: 1rem 0 1.25rem 0;
  }
  .nifty-stepper .btn { min-width: 38px; }
  .nifty-stepper .input-group-text { background:#f8fafc; }
</style>

<div class="container-fluid">
  <div class="hero-title" role="banner" aria-label="Judul situs">
    <h1 class="text"><?= $title ?></h1>
      <div class="text-muted">Isi data dengan benar untuk mempercepat proses konfirmasi</div>

    <span class="accent" aria-hidden="true"></span>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-elev">
        <div class="card-body">
         <!--  <div class="text-center mb-2">
            <h3 class="mb-1"><?php echo $title ?></h3>
            <div class="small-muted">Isi data dengan benar untuk mempercepat proses konfirmasi.</div>
          </div> -->

          <form id="form_app" method="post" enctype="multipart/form-data">
            <!-- ====== Asal Instansi ====== -->
<div class="header-title">Asal Instansi</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group mb-2">
      <label for="kategori" class="form-label label-required">Kategori Instansi</label>
      <select id="kategori" name="kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="opd">Dinas Pemprov Sulsel</option>
        <option value="pn">Pengadilan Negeri</option>
        <option value="pa">Pengadilan Agama</option>
        <option value="ptun">PTUN Makassar</option>
        <option value="kejati">Kejaksaan Tinggi</option>
        <option value="kejari">Kejaksaan Negeri</option>
        <option value="cabjari">Cabang Kejaksaan Negeri</option>
        <option value="bnn">BNN</option>
        <option value="kodim">Kodim Wil. Kodam XIV/Hasanuddin</option>
        <option value="lainnya">Lainnya</option>
      </select>
      <small class="help-hint">Jika tidak ada di daftar, pilih <b>Lainnya</b>.</small>
    </div>
  </div>

  <div class="col-md-6">
    <!-- MODE SELECT (default) -->
    <div class="form-group mb-2" id="instansi_select_wrap">
      <label for="instansi" class="form-label label-required">Instansi</label>
      <select id="instansi" name="instansi_id" class="form-control" required disabled>
        <option value="">-- Pilih Instansi --</option>
      </select>
      <small class="help-hint">Pilih kategori terlebih dahulu untuk menampilkan daftar instansi.</small>
    </div>

    <!-- MODE MANUAL (muncul saat kategori = Lainnya) -->
    <div class="form-group mb-2 d-none" id="instansi_manual_wrap">
      <label for="instansi_manual" class="form-label label-required">Nama Instansi</label>
      <input type="text" id="instansi_manual" name="target_instansi_nama"
      class="form-control" placeholder="Tulis nama instansi">
      <small class="help-hint">Contoh: KPP Pratama Makassar Utara</small>
    </div>
  </div>
</div>

<div class="divider-soft"></div>

<!-- ====== Tujuan di Lapas ====== -->
<div class="header-title">Unit Tujuan Lapas</div>
<div class="form-group mb-2">
  <label for="unit_tujuan" class="form-label label-required">Unit Tujuan</label>
  <select id="unit_tujuan" name="unit_tujuan" class="form-control" title="-- Pilih Unit --" required>
    <option value="">-- Pilih Unit --</option>
    <?php 
    function render_options($tree, $level = 0) {
      $no = 1;
      foreach ($tree as $node) {
        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
        $prefix = ($level > 0) ? $no . '. ' : '';
        $label  = htmlspecialchars($node->nama_unit, ENT_QUOTES, 'UTF-8');
        $content = $indent . $prefix . $label;

        echo '<option value="' . (int)$node->id . '" data-content="' . $content . '">' . $content . '</option>';

        if (!empty($node->children)) {
          render_options($node->children, $level + 1);
        }
        $no++;
      }
    }
    render_options($units_tree);
    ?>
  </select>
</div>

<div class="divider-soft"></div>
            <!-- ====== Data Tamu ====== -->
            <div class="header-title">Data Tamu</div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label for="nama_tamu" class="form-label label-required">Nama Tamu</label>
                  <input type="text" id="nama_tamu" name="nama_tamu" class="form-control" placeholder="Nama lengkap" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label for="id_number" class="form-label label-required">NIK/NIP/NRP</label>
                  <input
                  type="text"
                  id="id_number"
                  name="nik"                    
                  class="form-control"
                  placeholder="NIK 16 / NIP 18 atau 9 / NRP 8–9"
                  inputmode="numeric"
                  pattern="(?:\d{8,9}|\d{16}|\d{18})" 
                  maxlength="18"                     
                  required>
                  <small id="id_help" class="help-hint">
                    Boleh: <b>NIK</b> 16 digit • <b>NIP</b> 18 atau 9 digit • <b>NRP</b> 8–9 digit.
                  </small>
                </div>

                <script>
                  (function(){
                    const input = document.getElementById('id_number');
                    const help  = document.getElementById('id_help');
    // sama dengan pattern di atribut (tanpa ^$ karena pattern HTML sudah implicit full-match)
    const rx = /^(?:\d{8,9}|\d{16}|\d{18})$/;

    // hanya angka + batasi 18 digit
    function sanitize() {
      const digits = (input.value || '').replace(/\D/g, '').slice(0, 18);
      if (digits !== input.value) input.value = digits;
    }

    // pesan validasi yang jelas
    function setValidity() {
      if (!input.value) { input.setCustomValidity('Wajib diisi'); return; }
      if (!rx.test(input.value)) {
        input.setCustomValidity(
          'Format tidak valid. Isi salah satu: NIK 16 digit, NIP 18/9 digit, atau NRP 8–9 digit.'
          );
      } else {
        input.setCustomValidity('');
      }
    }

    input.addEventListener('input', () => { sanitize(); setValidity(); });
    input.addEventListener('invalid', setValidity);
    // inisialisasi
    sanitize(); setValidity();
  })();
</script>

</div>
<div class="col-md-6">
  <div class="form-group mb-2">
    <label for="alamat" class="form-label label-required">Alamat Tamu</label>
    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat lengkap" required>
    <small class="help-hint">Alamat sesuai KTP.</small>

  </div>
</div>
<div class="col-md-6">
  <div class="form-group mb-2">
    <label class="form-label label-required mb-1">Tempat / Tanggal Lahir</label>
    <div class="row">
      <!-- KIRI: Tempat lahir -->
      <div class="col-6">
        <input type="text"
        class="form-control"
        id="tempat_lahir"
        name="tempat_lahir"
        placeholder="Tempat lahir (mis. Makassar)"
        required
        autocomplete="off">
        <div class="invalid-feedback">Tempat lahir wajib diisi.</div>
      </div>

      <!-- KANAN: Tanggal lahir -->
      <div class="col-6">
        <input type="date"
        class="form-control"
        id="tanggal_lahir"
        name="tanggal_lahir"
        required
        max="<?= date('Y-m-d') ?>">
        <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
      </div>
    </div>
    <small class="form-text text-muted">Contoh: Makassar — 21-02-1990</small>
  </div>
</div>

<!-- </div> -->

<div class="col-md-6">
  <div class="form-group mb-2">
    <label for="jabatan" class="form-label label-required">Jabatan</label>
    <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Contoh: Staf / Kepala Seksi" required>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group mb-2">
    <label for="no_hp" class="form-label label-required">No. HP</label>
    <input type="text" id="no_hp" name="no_hp" class="form-control"
    placeholder="08xxxxxxxxxx" inputmode="numeric" minlength="10" maxlength="13" required>
    <small class="help-hint">Gunakan nomor aktif untuk menerima WhatsApp konfirmasi.</small>
  </div>
</div>

<div class="col-md-12">
  <!-- ====== Jumlah Pendamping + Panel Inline ====== -->
  <div class="form-group mb-2">
    <label for="jumlah_pendamping" class="form-label">Jumlah Pendamping</label>
    <div class="input-group input-group-sm nifty-stepper">
      <div class="input-group-prepend">
        <button type="button" class="btn btn-outline-secondary" id="btnPdMinus" title="Kurangi">
          <i class="fas fa-minus"></i>
        </button>
      </div>
      <input type="number" id="jumlah_pendamping" name="jumlah_pendamping"
      class="form-control text-center" min="0" max="20" step="1" placeholder="0">
      <div class="input-group-append">
        <span class="input-group-text">
          <i class="fas fa-users"></i>
          <span class="ml-1" id="pdCountBadge">0</span>
        </span>
        <button type="button" class="btn btn-outline-secondary" id="btnPdPlus" title="Tambah">
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>
    <small class="form-text text-muted">
      Geser jumlah di atas — baris pendamping akan menyesuaikan otomatis.
    </small>
  </div>

  <!-- Panel inline pendamping -->
  <div id="pendampingWrap" class="card border mb-2 d-none">
    <div class="card-body p-2">
      <!-- Info kuota -->
      <div class="d-flex align-items-center justify-content-between mb-2">
        <strong>Pendamping</strong>
        <small class="text-muted">
          Terisi: <span id="pdFilled">0</span> / <span id="pdTarget">0</span>
        </small>
      </div>

      <!-- Form baris pendamping -->
      <div class="row">
        <div class="col-md-4">
          <label class="form-label mb-1">NIK/NIP/NRP Pendamping</label>
          <input type="text" id="pd_nik" class="form-control form-control-sm"
          placeholder="16 digit NIK" maxlength="16" inputmode="numeric">
          <small class="text-muted">Wajib 16 digit & unik.</small>
        </div>
        <div class="col-md-5">
          <label class="form-label mb-1">Nama Pendamping</label>
          <input type="text" id="pd_nama" class="form-control form-control-sm" placeholder="Nama lengkap">
        </div>
        <div class="col-md-3 d-flex align-items-end mt-2" style="gap:.5rem;">
          <button type="button" class="btn btn-sm btn-success" id="btnPdAdd">Tambah</button>
          <button type="button" class="btn btn-sm btn-warning d-none" id="btnPdSave">Simpan</button>
          <button type="button" class="btn btn-sm btn-secondary d-none" id="btnPdCancel">Batal</button>
        </div>
      </div>

      <hr class="my-2">

      <!-- Tabel pendamping -->
      <div class="table-responsive">
        <table class="table table-sm table-bordered mb-0" id="tblPendampingLocal">
          <thead class="thead-light">
            <tr>
              <th style="width:60px">No</th>
              <th style="width:180px">NIK/NIP/NRP</th>
              <th>Nama</th>
              <th style="width:150px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="4" class="text-center text-muted">Belum ada pendamping.</td></tr>
          </tbody>
        </table>
      </div>

      <small id="pdHelp" class="text-muted d-block mt-2">
        Pastikan jumlah pendamping sesuai field “Jumlah Pendamping”.
      </small>
    </div>
  </div>

  <!-- Hidden untuk dikirim ke server -->
  <input type="hidden" name="pendamping_json" id="pendamping_json">
  <!-- /Panel inline pendamping -->
</div>
</div>

<div class="divider-soft"></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>



<!-- ====== Jadwal Kunjungan ====== -->
<div class="header-title">Jadwal Kunjungan</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group mb-2">
      <label for="tanggal_view" class="form-label label-required">Tanggal Kunjungan</label>
      <input
        type="text"
        id="tanggal_view"
        class="form-control"
        placeholder="dd/mm/yyyy"
        inputmode="numeric"
        autocomplete="off"
        required
      >
      <input type="hidden" id="tanggal" name="tanggal">
      <small id="tanggal-info" class="form-text text-muted"></small>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group mb-2">
      <label for="jam" class="form-label label-required">Jam Kunjungan</label>
      <input type="time" id="jam" name="jam" class="form-control" disabled required>
      <small id="jam-info" class="form-text text-muted"></small>
    </div>
  </div>
</div>


<div class="divider-soft"></div>

<!-- ====== Keperluan & Lampiran ====== -->
<div class="header-title">Keperluan & Lampiran</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group mb-2">
      <label for="keperluan" class="form-label">Keperluan Kunjungan</label>
      <textarea id="keperluan" name="keperluan" class="form-control" rows="3" placeholder="Tuliskan keperluan kunjungan"></textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group mb-2">
      <label class="form-label">Surat Tugas (Opsional)</label>
      <div class="custom-file">
        <input type="file" class="custom-file-input" name="surat_tugas" id="surat_tugas">
        <label class="custom-file-label" for="surat_tugas">Pilih file...</label>
      </div>
      <small class="help-hint">PDF/JPG/PNG ≤2 MB. Unggah atau tunjukkan saat check-in.</small>
    </div>
  </div>
</div>

<div class="text-center">
  <button type="button" class="btn btn-blue px-4" id="btnBooking" onclick="simpan()">
    Booking Sekarang
  </button>
</div>
</form>

</div>
</div>
</div>
</div>
</div>

<!-- Dependensi (pastikan ini ada di layout; FA opsional jika belum ada) -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" referrerpolicy="no-referrer" /> -->

<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>

<?php $this->load->view("front_end/footer.php") ?>
<?php $this->load->view("booking_js"); ?>
