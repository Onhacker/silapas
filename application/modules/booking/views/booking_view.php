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
  .form-label {
    font-weight: 600;
  }
  .label-required::after{
    content:" *";
    color:#dc3545;
    font-weight:700;
  }
  .small-muted{ color:#6c757d; font-size:.85rem; }
  .help-hint{ font-size:.8rem; color:#6c757d; }
  .btn-blue{ background: linear-gradient(90deg,#2563eb,#1d4ed8); border:0; }
  .btn-blue:hover{ filter: brightness(1.05); }
  .divider-soft{
    height:1px; background:linear-gradient(to right,transparent,#e9ecef,transparent);
    margin: 1rem 0 1.25rem 0;
  }
</style>

<div class="container-fluid">
  <div class="row mt-3">
    <div class="col-lg-10 offset-lg-1">
      <div class="card card-elev">
        <div class="card-body">
          <div class="text-center mb-2">
            <h3 class="mb-1"><?php echo $title ?></h3>
            <div class="small-muted">Isi data dengan benar untuk mempercepat proses konfirmasi.</div>
          </div>

          <form id="form_app" method="post" enctype="multipart/form-data">
            <!-- ====== Data Tamu ====== -->
            <div class="header-title">Data Tamu</div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="nama_tamu" class="form-label label-required">Nama Tamu</label>
                  <input type="text" id="nama_tamu" name="nama_tamu" class="form-control" placeholder="Nama lengkap" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="nik" class="form-label label-required">NIK</label>
                  <input type="text" id="nik" name="nik" class="form-control"
                         placeholder="16 digit NIK" inputmode="numeric" pattern="\d{16}" maxlength="16" required>
                  <small class="help-hint">Masukkan tepat 16 digit.</small>
                </div>
              </div>
             

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="jabatan" class="form-label label-required">Jabatan</label>
                  <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Contoh: Staf / Kepala Seksi" required>
                </div>

                <div class="form-group mb-3">
                  <label for="jumlah_pendamping" class="form-label label-required">Jumlah Pendamping</label>
                  <input type="number" id="jumlah_pendamping" name="jumlah_pendamping" class="form-control"
                         placeholder="0" min="0" required>
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="no_hp" class="form-label label-required">No. HP</label>
                  <input type="text" id="no_hp" name="no_hp" class="form-control"
                         placeholder="08xxxxxxxxxx" inputmode="numeric" minlength="10" maxlength="13" required>
                  <small class="help-hint">Gunakan nomor aktif untuk menerima WhatsApp konfirmasi.</small>
                </div>
              </div>
              
            </div>

            <div class="divider-soft"></div>

            <!-- ====== Asal Instansi ====== -->
            <div class="header-title">Asal Instansi</div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
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
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="instansi" class="form-label label-required">Instansi</label>
                  <select id="instansi" name="instansi_id" class="form-control" required disabled>
                    <option value="">-- Pilih Instansi --</option>
                  </select>
                  <small class="help-hint">Pilih kategori terlebih dahulu untuk menampilkan daftar instansi.</small>
                </div>
              </div>
            </div>

            <div class="divider-soft"></div>

            <!-- ====== Tujuan di Lapas ====== -->
            <div class="header-title">Unit Tujuan Lapas</div>
            <div class="form-group mb-3">
              <label for="unit_tujuan" class="form-label label-required">Unit Tujuan</label>
              <select id="unit_tujuan" name="unit_tujuan" class="form-control" title="-- Pilih Unit --" required>
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

            <!-- ====== Jadwal Kunjungan ====== -->
            <div class="header-title">Jadwal Kunjungan</div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="tanggal" class="form-label label-required">Tanggal Kunjungan</label>
                  <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                  <small id="tanggal-info" class="form-text text-muted"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
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
                <div class="form-group mb-3">
                  <label for="keperluan" class="form-label">Keperluan Kunjungan</label>
                  <textarea id="keperluan" name="keperluan" class="form-control" rows="3" placeholder="Tuliskan keperluan kunjungan"></textarea>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label">Surat Tugas (Opsional)</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="surat_tugas" id="surat_tugas">
                    <label class="custom-file-label" for="surat_tugas">Pilih file...</label>
                  </div>
                  <small class="help-hint">PDF/JPG/PNG • Maks 2 MB.</small>
                </div>

              <!--   <div class="form-group mb-3">
                  <label for="foto" class="form-label">Foto Dokumentasi</label>
                  <input type="file" id="foto" name="foto" class="form-control">
                  <small class="help-hint">Bisa upload sekarang atau difoto petugas saat check-in.</small>
                </div> -->

                
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

<script>
  // ====== Perapihan kecil: label file custom-update ======
  (function(){
    var st = document.getElementById('surat_tugas');
    if (st) {
      st.addEventListener('change', function(e){
        var f = e.target.files && e.target.files[0] ? e.target.files[0].name : 'Pilih file...';
        var lbl = document.querySelector('label[for="surat_tugas"].custom-file-label');
        if (lbl) lbl.textContent = f;
      });
    }
  })();

  // ====== Enable/disable dropdown Instansi berdasarkan kategori ======
  (function(){
    var kat = document.getElementById('kategori');
    var ins = document.getElementById('instansi');
    if (!kat || !ins) return;

    kat.addEventListener('change', function(){
      if (this.value) {
        ins.removeAttribute('disabled');
        // TODO: panggil AJAX untuk load opsi instansi sesuai kategori
        // Kosongkan dulu:
        ins.innerHTML = '<option value="">-- Pilih Instansi --</option>';
      } else {
        ins.setAttribute('disabled', 'disabled');
        ins.value = '';
      }
    });
  })();

  // ====== (Opsional) bantu UX: angka saja utk NIK & HP ======
  ['nik','no_hp'].forEach(function(id){
    var el = document.getElementById(id);
    if(!el) return;
    el.addEventListener('input', function(){
      this.value = this.value.replace(/[^\d]/g,'');
    });
  });
</script>


<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>


<?php $this->load->view("front_end/footer.php") ?>
<?php $this->load->view("booking_js"); ?>


                 