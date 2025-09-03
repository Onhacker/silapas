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
  <div class="row mt-3">
    <div class="col-lg-12">
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
    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Nama lengkap" required>
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
    <div class="form-group mb-2">
      <label for="tanggal" class="form-label label-required">Tanggal Kunjungan</label>
      <input type="date" id="tanggal" name="tanggal" class="form-control" required>
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
  // ===== State & elemen (UNIFIED ke window.pendamping) =====
  window.pendamping = Array.isArray(window.pendamping) ? window.pendamping : [];
  let pendamping = window.pendamping;                   // referensi yang sama
  let editIndex  = (typeof window.editIndex === 'number') ? window.editIndex : -1;

  const btnSet   = document.getElementById('btnSetPendamping'); // opsional (tidak wajib ada)
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
        <button type="button" class="btn btn-xs btn-outline-info" onclick="pdEdit(${i})" title="Edit">
        <i class="fas fa-edit"></i>
        </button>
        <button type="button" class="btn btn-xs btn-outline-danger" onclick="pdDel(${i})" title="Hapus">
        <i class="fas fa-trash-alt"></i>
        </button>
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
    window.editIndex = editIndex;
    inNik.value = '';
    inNama.value = '';
    btnAdd.classList.remove('d-none');
    btnSave.classList.add('d-none');
    btnCancel.classList.add('d-none');
  inNik.focus(); // <— tambah baris ini
}

  // Expose untuk tombol tabel
  window.pdEdit = function(i){
    if (i<0 || i>=pendamping.length) return;
    editIndex = i;
    window.editIndex = editIndex;
    inNik.value  = pendamping[i].nik;
    inNama.value = pendamping[i].nama;
    btnAdd.classList.add('d-none');
    btnSave.classList.remove('d-none');
    btnCancel.classList.remove('d-none');
    if (wrap.classList.contains('d-none')) wrap.classList.remove('d-none');
  inNik.focus(); // <— tadinya inNama.focus()
};


window.pdDel = async function(i){
  if (i < 0 || i >= pendamping.length) return;

  const nama = (pendamping[i] && (pendamping[i].nama || pendamping[i].NAMA || ''));
  const { isConfirmed } = await Swal.fire({
    title: 'Hapus pendamping?',
    text: nama ? `Nama: ${nama}` : 'Data ini akan dihapus.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal',
    reverseButtons: true,
    focusCancel: true
  });

  if (!isConfirmed) return;

  pendamping.splice(i, 1);
  if (editIndex === i) resetRowForm();
  else if (editIndex > i) { editIndex--; window.editIndex = editIndex; }
  render();

  Swal.fire({
    title: 'Terhapus',
    text: 'Data pendamping berhasil dihapus.',
    icon: 'success',
    timer: 1200,
    showConfirmButton: false
  });
};

  // Events
  if (btnSet) {
    btnSet.addEventListener('click', ()=>{
      wrap.classList.toggle('d-none');
      pdTarget.textContent = getTarget();
    });
  }

  if (Number(inJumlah?.value || 0) > 0) {
    wrap.classList.remove('d-none');
  }

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

  // ------ EXPOSE ke global agar dipanggil stepper ------
  window.render = render;
  window.editIndex = editIndex;

  // render awal
  render();
})();
</script>

<script>
// batas maksimum baris pendamping (ubah sesuai kebutuhan)
const MAX_PENDAMPING = 20;

// ambil elemen
const elJumlah = document.getElementById('jumlah_pendamping');
const elBadge  = document.getElementById('pdCountBadge');
const btnPlus  = document.getElementById('btnPdPlus');
const btnMinus = document.getElementById('btnPdMinus');

// fallback kalau variabel global belum ada
window.pendamping = Array.isArray(window.pendamping) ? window.pendamping : [];
window.editIndex  = typeof window.editIndex === 'number' ? window.editIndex : -1;

// set nilai awal input = panjang array sekarang
function updateJumlahInput() {
  const n = window.pendamping.length;
  if (elJumlah) elJumlah.value = n;
  if (elBadge)  elBadge.textContent = n;
}

// sinkronkan target jumlah dgn array `pendamping`
async function syncJumlahPendamping(target) {
  let t = parseInt(target, 10);
  if (isNaN(t)) t = 0;
  t = Math.max(0, Math.min(MAX_PENDAMPING, t));

  const cur = window.pendamping.length;
  if (t === cur) { updateJumlahInput(); return; }

  if (t > cur) {
    // tambah baris kosong
    for (let i = cur; i < t; i++) {
      window.pendamping.push({ nik: '', nama: '' });
    }
    updateJumlahInput();

    // Paksa tampilkan panel pendamping
    document.getElementById('pendampingWrap')?.classList.remove('d-none');

    // Render tabel via fungsi global + auto-buka editor baris kosong pertama
    if (typeof window.render === 'function') window.render();
    const firstEmpty = window.pendamping.findIndex(p => !p.nik || !p.nama);
    if (firstEmpty >= 0 && typeof window.pdEdit === 'function') window.pdEdit(firstEmpty);

    return;
  }

  // t < cur → konfirmasi pengurangan
  let ok = true;
  if (typeof Swal !== 'undefined') {
    const { isConfirmed } = await Swal.fire({
      title: 'Kurangi pendamping?',
      text: `${cur - t} baris terakhir akan dihapus.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, kurangi',
      cancelButtonText: 'Batal',
      reverseButtons: true,
      focusCancel: true
    });
    ok = isConfirmed;
  } else {
    ok = confirm(`Hapus ${cur - t} pendamping terakhir?`);
  }
  if (!ok) { updateJumlahInput(); return; }

  window.pendamping.splice(t); // buang sisa di akhir
  if (typeof window.editIndex === 'number' && window.editIndex >= t) window.editIndex = -1;
  updateJumlahInput();
  if (typeof window.render === 'function') window.render();
}

// handler tombol +/-
btnPlus && btnPlus.addEventListener('click', () => syncJumlahPendamping(window.pendamping.length + 1));
btnMinus && btnMinus.addEventListener('click', () => syncJumlahPendamping(window.pendamping.length - 1));

// ketik manual → debounce
let pdTimer = null;
elJumlah && elJumlah.addEventListener('input', () => {
  clearTimeout(pdTimer);
  pdTimer = setTimeout(() => syncJumlahPendamping(elJumlah.value), 250);
});
// perubahan final (enter/tab/blur)
elJumlah && elJumlah.addEventListener('change', () => syncJumlahPendamping(elJumlah.value));

// inisialisasi tampilan awal
updateJumlahInput();
</script>

<script>
// booking_js
function simpan(){
  try {
    // WAJIB: pastikan jumlah pendamping = data yang diisi
    window._ensurePendampingBeforeSubmit();
  } catch (e) {
    alert(e.message);   // contoh: "Jumlah pendamping terisi 1/3."
    return;             // stop submit
  }

  // ... lanjutkan membuat FormData dan kirim AJAX sesuai implementasi kamu
  // const fd = new FormData(document.getElementById('form_app'));
  // $.ajax({ url:'<?= site_url("booking/add") ?>', method:'POST', data: fd, ... });
}
</script>

<!-- Dependensi (pastikan ini ada di layout; FA opsional jika belum ada) -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" referrerpolicy="no-referrer" /> -->

<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>

<?php $this->load->view("front_end/footer.php") ?>
<?php $this->load->view("booking_js"); ?>
