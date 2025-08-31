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
                </div>
                <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="no_hp" class="form-label label-required">No. HP</label>
                  <input type="text" id="no_hp" name="no_hp" class="form-control"
                         placeholder="08xxxxxxxxxx" inputmode="numeric" minlength="10" maxlength="13" required>
                  <small class="help-hint">Gunakan nomor aktif untuk menerima WhatsApp konfirmasi.</small>
                </div>
              </div>
                 <div class="col-md-12">
                <!-- ====== Jumlah Pendamping + Panel Inline ====== -->
                <div class="form-group mb-3">
                  <label for="jumlah_pendamping" class="form-label ">Jumlah Pendamping</label>
                  <div class="input-group">
                    <input type="number" id="jumlah_pendamping" name="jumlah_pendamping" class="form-control"
                           placeholder="0" min="0" >
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-primary" id="btnSetPendamping">
                        Set Pendamping
                      </button>
                    </div>
                  </div>
                  <small class="help-hint">Isi angka, lalu klik <b>Set Pendamping</b> untuk memasukkan data pendamping.</small>
                </div>

                <!-- Panel inline pendamping -->
                <div id="pendampingWrap" class="card border mb-3 d-none">
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
                        <label class="form-label mb-1">NIK Pendamping</label>
                        <input type="text" id="pd_nik" class="form-control form-control-sm"
                               placeholder="16 digit NIK" maxlength="16" inputmode="numeric">
                        <small class="text-muted">Wajib 16 digit & unik.</small>
                      </div>
                      <div class="col-md-5">
                        <label class="form-label mb-1">Nama Pendamping</label>
                        <input type="text" id="pd_nama" class="form-control form-control-sm" placeholder="Nama lengkap">
                      </div>
                      <div class="col-md-3 d-flex align-items-end" style="gap:.5rem;">
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
                            <th style="width:180px">NIK</th>
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
                    <option value="lainnya">Lainnya</option><!-- NEW -->
                  </select>
                  <small class="help-hint">Jika tidak ada di daftar, pilih <b>Lainnya</b>.</small>
                </div>
              </div>

              <div class="col-md-6">
                <!-- MODE SELECT (default) -->
                <div class="form-group mb-3" id="instansi_select_wrap">
                  <label for="instansi" class="form-label label-required">Instansi</label>
                  <select id="instansi" name="instansi_id" class="form-control" required disabled>
                    <option value="">-- Pilih Instansi --</option>
                  </select>
                  <small class="help-hint">Pilih kategori terlebih dahulu untuk menampilkan daftar instansi.</small>
                </div>

                <!-- MODE MANUAL (muncul saat kategori = Lainnya) -->
                <div class="form-group mb-3 d-none" id="instansi_manual_wrap">
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
  // ====== Label file custom ======
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

  // ====== Mode instansi: Select vs Manual (Lainnya) ======
  (function(){
    var kat   = document.getElementById('kategori');
    var selW  = document.getElementById('instansi_select_wrap');
    var sel   = document.getElementById('instansi');
    var manW  = document.getElementById('instansi_manual_wrap');
    var man   = document.getElementById('instansi_manual');

    function useSelectMode(){
      selW.classList.remove('d-none');
      sel.removeAttribute('disabled');
      sel.setAttribute('required','required');

      manW.classList.add('d-none');
      man.setAttribute('disabled','disabled');
      man.removeAttribute('required');
      man.value = '';
    }

    function useManualMode(){
      manW.classList.remove('d-none');
      man.removeAttribute('disabled');
      man.setAttribute('required','required');

      selW.classList.add('d-none');
      sel.setAttribute('disabled','disabled');
      sel.removeAttribute('required');
      sel.value = '';
    }

    kat.addEventListener('change', function(){
      var v = this.value || '';
      if (v === 'lainnya'){
        useManualMode();
      } else if (v){
        useSelectMode();
        // TODO: AJAX load daftar instansi berdasarkan kategori `v`
        sel.innerHTML = '<option value="">-- Pilih Instansi --</option>';
        // Contoh:
        // fetch('<?= site_url('api/instansi_by_kategori') ?>?kategori='+encodeURIComponent(v))
        //  .then(r=>r.json()).then(j=>{
        //    (j.data||[]).forEach(function(it){
        //      var opt = document.createElement('option');
        //      opt.value = it.id; opt.textContent = it.nama;
        //      sel.appendChild(opt);
        //    });
        //  });
      } else {
        sel.value=''; sel.setAttribute('disabled','disabled'); sel.removeAttribute('required');
        man.value=''; man.setAttribute('disabled','disabled'); man.removeAttribute('required');
        selW.classList.remove('d-none'); manW.classList.add('d-none');
      }
    });

    // trigger awal
    kat.dispatchEvent(new Event('change'));
  })();

  // ====== Batasi input angka untuk NIK & HP ======
  ['nik','no_hp'].forEach(function(id){
    var el = document.getElementById(id);
    if(!el) return;
    el.addEventListener('input', function(){
      this.value = this.value.replace(/[^\d]/g,'');
    });
  });
</script>

<script>
/**
 * Panel Pendamping (inline) — simpan ke hidden `pendamping_json`.
 * Pastikan panggil window._ensurePendampingBeforeSubmit() di awal simpan().
 */
(function(){
  // State & elemen
  let pendamping = [];    // [{nik, nama}]
  let editIndex  = -1;

  const btnSet   = document.getElementById('btnSetPendamping');
  const wrap     = document.getElementById('pendampingWrap');
  const inJumlah = document.getElementById('jumlah_pendamping');

  const inNik    = document.getElementById('pd_nik');
  const inNama   = document.getElementById('pd_nama');
  const btnAdd   = document.getElementById('btnPdAdd');
  const btnSave  = document.getElementById('btnPdSave');
  const btnCancel= document.getElementById('btnPdCancel');

  const tbody    = document.querySelector('#tblPendampingLocal tbody');
  const pdHelp   = document.getElementById('pdHelp');
  const pdFilled = document.getElementById('pdFilled');
  const pdTarget = document.getElementById('pdTarget');
  const hidJson  = document.getElementById('pendamping_json');

  // NIK pemohon (agar tidak sama)
  const inNikPemohon = document.getElementById('nik');

  // Utils
  const onlyDigits = s => String(s||'').replace(/\D+/g,'');
  const is16Digits = s => /^\d{16}$/.test(String(s||''));
  // function esc(s){return String(s||'').replace(/[&<>"']/g, m=>({'&':'&amp;','<':'&gt;','>':'&gt;','"':'&quot;'}[m]))}
function esc(s){
  return String(s||'').replace(/[&<>"']/g, m => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'
  }[m]));
}

  function getTarget(){
    return parseInt(inJumlah.value,10) || 0;
  }

  function render(){
    pdFilled.textContent = pendamping.length;
    pdTarget.textContent = getTarget();

    if (!pendamping.length){
      tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Belum ada pendamping.</td></tr>`;
    } else {
      tbody.innerHTML = pendamping.map((p,i)=>`
        <tr>
          <td class="text-center">${i+1}</td>
          <td><code>${esc(p.nik)}</code></td>
          <td>${esc(p.nama)}</td>
          <td class="text-center">
            <button type="button" class="btn btn-xs btn-outline-info" onclick="pdEdit(${i})">Edit</button>
            <button type="button" class="btn btn-xs btn-outline-danger" onclick="pdDel(${i})">Hapus</button>
          </td>
        </tr>
      `).join('');
    }

    // sinkron hidden json
    hidJson.value = JSON.stringify(pendamping);

    // warning kuota
    if (pendamping.length !== getTarget()){
      pdHelp.classList.remove('text-muted');
      pdHelp.classList.add('text-danger');
      pdHelp.textContent = `Jumlah pendamping terisi ${pendamping.length}/${getTarget()}.`;
    } else {
      pdHelp.classList.remove('text-danger');
      pdHelp.classList.add('text-muted');
      pdHelp.textContent = 'Pastikan jumlah pendamping sesuai field “Jumlah Pendamping”.';
    }
  }

  function resetRowForm(){
    editIndex = -1;
    inNik.value = '';
    inNama.value = '';
    btnAdd.classList.remove('d-none');
    btnSave.classList.add('d-none');
    btnCancel.classList.add('d-none');
  }

  // Expose untuk tombol tabel
  window.pdEdit = function(i){
    if (i<0 || i>=pendamping.length) return;
    editIndex = i;
    inNik.value  = pendamping[i].nik;
    inNama.value = pendamping[i].nama;
    btnAdd.classList.add('d-none');
    btnSave.classList.remove('d-none');
    btnCancel.classList.remove('d-none');
    if (wrap.classList.contains('d-none')) wrap.classList.remove('d-none');
    inNik.focus();
  };

  window.pdDel = function(i){
    if (i<0 || i>=pendamping.length) return;
    if (!confirm('Hapus pendamping ini?')) return;
    pendamping.splice(i,1);
    if (editIndex === i) resetRowForm();
    render();
  };

  // Events
  btnSet.addEventListener('click', ()=>{
    // toggle panel
    wrap.classList.toggle('d-none');
    // update target label
    pdTarget.textContent = getTarget();
  });

  inJumlah.addEventListener('change', ()=>{
    pdTarget.textContent = getTarget();
    if (pendamping.length !== getTarget()){
      wrap.classList.remove('d-none');
    }
    render();
  });

  // filter nik (16 digit)
  inNik.addEventListener('input', ()=>{
    inNik.value = onlyDigits(inNik.value).slice(0,16);
  });

  btnAdd.addEventListener('click', ()=>{
    const nik  = onlyDigits(inNik.value);
    const nama = String(inNama.value||'').trim();

    if (!is16Digits(nik)) { alert('NIK pendamping wajib 16 digit.'); inNik.focus(); return; }
    if (!nama)           { alert('Nama pendamping wajib diisi.'); inNama.focus(); return; }

    if (inNikPemohon && onlyDigits(inNikPemohon.value) === nik){
      alert('NIK pendamping tidak boleh sama dengan NIK tamu.');
      inNik.focus(); return;
    }
    if (pendamping.some(p=>p.nik===nik)){
      alert('NIK pendamping sudah ada di daftar.'); inNik.focus(); return;
    }

    const target = getTarget();
    if (target && pendamping.length >= target){
      alert('Jumlah pendamping sudah mencapai batas.');
      return;
    }

    pendamping.push({nik, nama});
    resetRowForm();
    render();
  });

  btnSave.addEventListener('click', ()=>{
    if (editIndex < 0) return;
    const nik  = onlyDigits(inNik.value);
    const nama = String(inNama.value||'').trim();

    if (!is16Digits(nik)) { alert('NIK pendamping wajib 16 digit.'); inNik.focus(); return; }
    if (!nama)           { alert('Nama pendamping wajib diisi.'); inNama.focus(); return; }
    if (inNikPemohon && onlyDigits(inNikPemohon.value) === nik){
      alert('NIK pendamping tidak boleh sama dengan NIK tamu.');
      inNik.focus(); return;
    }
    if (pendamping.some((p,idx)=> idx!==editIndex && p.nik===nik)){
      alert('NIK pendamping sudah ada di daftar.'); inNik.focus(); return;
    }

    pendamping[editIndex] = {nik, nama};
    resetRowForm();
    render();
  });

  btnCancel.addEventListener('click', resetRowForm);

  // Hook untuk submit (panggil ini di awal simpan())
  window._ensurePendampingBeforeSubmit = function(){
    hidJson.value = JSON.stringify(pendamping);
    const target = getTarget();
    if (target !== pendamping.length){
      throw new Error(`Jumlah pendamping terisi ${pendamping.length}/${target}.`);
    }
  };

  // render awal
  render();
})();

// booking_js
function simpan(){
  try {
    // WAJIB: pastikan jumlah pendamping = data yang diisi
    window._ensurePendampingBeforeSubmit();
  } catch (e) {
    alert(e.message);   // contoh: "Jumlah pendamping terisi 1/3."
    return;             // stop submit
  }

  // ... lanjutkan membuat FormData dan kirim AJAX seperti biasa
  // const fd = new FormData(document.getElementById('form_app'));
  // $.ajax({ url:'<?= site_url("booking/add") ?>', method:'POST', data: fd, ... });
}

</script>

<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>

<?php $this->load->view("front_end/footer.php") ?>
<?php $this->load->view("booking_js"); ?>
