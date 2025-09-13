<?php $this->load->view("front_end/head.php") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

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
                    const rx = /^(?:\d{8,9}|\d{16}|\d{18})$/;
                    function sanitize() {
                      const digits = (input.value || '').replace(/\D/g, '').slice(0, 18);
                      if (digits !== input.value) input.value = digits;
                    }
                    function setValidity() {
                      if (!input.value) { input.setCustomValidity('Wajib diisi'); return; }
                      if (!rx.test(input.value)) {
                        input.setCustomValidity('Format tidak valid. Isi salah satu: NIK 16 digit, NIP 18/9 digit, atau NRP 8–9 digit.');
                      } else { input.setCustomValidity(''); }
                    }
                    input.addEventListener('input', () => { sanitize(); setValidity(); });
                    input.addEventListener('invalid', setValidity);
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

                    <div class="col-6">
                      <!-- Visible: dd/mm/yyyy -->
                      <input type="text"
                             class="form-control"
                             id="tanggal_lahir_view"
                             placeholder="dd/mm/yyyy"
                             autocomplete="off"
                             required>
                      <!-- Hidden: YYYY-MM-DD -->
                      <input type="hidden" id="tanggal_lahir" name="tanggal_lahir" required>
                      <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                    </div>
                  </div>
                  <small class="form-text text-muted">Contoh: Makassar — 21-02-1990</small>
                </div>
              </div>

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
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <strong>Pendamping</strong>
                      <small class="text-muted">
                        Terisi: <span id="pdFilled">0</span> / <span id="pdTarget">0</span>
                      </small>
                    </div>

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

                <input type="hidden" name="pendamping_json" id="pendamping_json">
              </div>
            </div>

            <div class="divider-soft"></div>

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
<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>

<?php $this->load->view("front_end/footer.php") ?>
<!-- HAPUS include yang bisa menimpa fungsi simpan()
<?php /* $this->load->view("booking_js"); */ ?> -->

<script>
/* =========================
   UTIL & STATE GLOBAL
========================= */
const MARGIN_CLASS = 'ml-2';

window.OP_HOURS = <?= json_encode([
  'tz'    => $rec->waktu ?? 'Asia/Makassar',
  'lead'  => (int)($rec->min_lead_minutes ?? 10),
  'days'  => [
    '0' => ['open'=>$rec->op_sun_open ?? null, 'break_start'=>$rec->op_sun_break_start ?? null, 'break_end'=>$rec->op_sun_break_end ?? null, 'close'=>$rec->op_sun_close ?? null, 'closed'=>(int)($rec->op_sun_closed ?? 1)],
    '1' => ['open'=>$rec->op_mon_open ?? '08:00','break_start'=>$rec->op_mon_break_start ?? null,'break_end'=>$rec->op_mon_break_end ?? null,'close'=>$rec->op_mon_close ?? '15:00','closed'=>(int)($rec->op_mon_closed ?? 0)],
    '2' => ['open'=>$rec->op_tue_open ?? '08:00','break_start'=>$rec->op_tue_break_start ?? null,'break_end'=>$rec->op_tue_break_end ?? null,'close'=>$rec->op_tue_close ?? '15:00','closed'=>(int)($rec->op_tue_closed ?? 0)],
    '3' => ['open'=>$rec->op_wed_open ?? '08:00','break_start'=>$rec->op_wed_break_start ?? null,'break_end'=>$rec->op_wed_break_end ?? null,'close'=>$rec->op_wed_close ?? '15:00','closed'=>(int)($rec->op_wed_closed ?? 0)],
    '4' => ['open'=>$rec->op_thu_open ?? '08:00','break_start'=>$rec->op_thu_break_start ?? null,'break_end'=>$rec->op_thu_break_end ?? null,'close'=>$rec->op_thu_close ?? '15:00','closed'=>(int)($rec->op_thu_closed ?? 0)],
    '5' => ['open'=>$rec->op_fri_open ?? '08:00','break_start'=>$rec->op_fri_break_start ?? null,'break_end'=>$rec->op_fri_break_end ?? null,'close'=>$rec->op_fri_close ?? '14:00','closed'=>(int)($rec->op_fri_closed ?? 0)],
    '6' => ['open'=>$rec->op_sat_open ?? '08:00','break_start'=>$rec->op_sat_break_start ?? null,'break_end'=>$rec->op_sat_break_end ?? null,'close'=>$rec->op_sat_close ?? '11:30','closed'=>(int)($rec->op_sat_closed ?? 0)],
  ]
], JSON_UNESCAPED_SLASHES) ?>;

function setLoading(isLoading, btn, opts) {
  btn  = btn  || document.getElementById('btnBooking');
  opts = opts || {};
  const steps = opts.steps || [
    'Memvalidasi data…','Cek hari & jam…','Cek kuota pendamping…',
    'Cek slot jadwal…','Menyimpan…','Generate QR…','Kirim WhatsApp…'
  ];
  const intervalMs = opts.interval || 900;

  if (isLoading) {
    if (btn.dataset.loadingActive === '1') return;
    btn.dataset.originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.dataset.loadingActive = '1';
    let i = 0;
    btn.innerHTML =
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
      `<span class="${MARGIN_CLASS}">${steps[i]}</span>`;
    const id = setInterval(() => {
      i = (i + 1) % steps.length;
      btn.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
        `<span class="${MARGIN_CLASS}">${steps[i]}</span>`;
    }, intervalMs);
    btn.dataset.loadingInterval = id;
  } else {
    if (btn.dataset.loadingInterval) {
      clearInterval(+btn.dataset.loadingInterval);
      delete btn.dataset.loadingInterval;
    }
    btn.disabled = false;
    btn.innerHTML = btn.dataset.originalHtml || 'Booking Sekarang';
    delete btn.dataset.loadingActive;
  }
}

function loader() {
  Swal.fire({
    title: "Proses...",
    html: "Jangan tutup halaman ini",
    allowOutsideClick: false,
    didOpen: function() { Swal.showLoading(); }
  });
}
</script>

<script>
/* =========================
   TANGGAL KUNJUNGAN + JAM
========================= */
(function(){
  const elView  = document.getElementById('tanggal_view');
  const elISO   = document.getElementById('tanggal');
  const jamInput = document.getElementById('jam');
  const infoJam  = document.getElementById('jam-info');
  const infoTgl  = document.getElementById('tanggal-info');

  const HARI_ID = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const TZ_ABBR = {'Asia/Jakarta':'WIB','Asia/Makassar':'WITA','Asia/Jayapura':'WIT'};
  const tzAbbr  = TZ_ABBR[(window.OP_HOURS && OP_HOURS.tz) || 'Asia/Makassar'] || '';

  const pad = n => (n<10?'0':'')+n;
  const toMin = s => !s ? null : ((h=s.split(':')[0]|0, m=s.split(':')[1]|0), h*60+m);
  const fromMin = n => `${pad(Math.floor(n/60))}:${pad(n%60)}`;
  const dot = s => s ? s.replace(':','.') : '';

  function todayYmd(){
    const base = Date.now() + (window.serverOffsetMs || 0);
    const d = new Date(base);
    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
  }

  function buildInfoLine(dayIdx, conf, pushedMin=null){
    if (!conf || conf.closed) return `Hari ${HARI_ID[dayIdx]}: Libur`;
    let line = `Hari ${HARI_ID[dayIdx]}: ${dot(conf.open)}–${dot(conf.close)} ${tzAbbr}`;
    if (conf.break_start && conf.break_end) {
      line += ` (Istirahat ${dot(conf.break_start)}–${dot(conf.break_end)} ${tzAbbr})`;
    }
    if (pushedMin && toMin(pushedMin) > toMin(conf.open||'00:00')) {
      line += ` • Minimal hari ini: ${dot(pushedMin)}`;
    }
    return line;
  }

  function sameYmd(a,b){ return a&&b && a.getFullYear()===b.getFullYear() && a.getMonth()===b.getMonth() && a.getDate()===b.getDate(); }

  function applyForDate(d){
    jamInput.value = '';
    jamInput.disabled = true;
    jamInput.removeAttribute('min');
    jamInput.removeAttribute('max');
    if (infoTgl) infoTgl.textContent = '';
    if (infoJam) infoJam.textContent = '';

    if (!(d instanceof Date) || isNaN(d)) return;

    const dayIdx = d.getDay();
    const conf   = OP_HOURS?.days?.[String(dayIdx)];

    if (!conf || conf.closed) {
      if (infoTgl) infoTgl.textContent = `Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`;
      if (window.Swal) Swal.fire({title:'Info', html:`Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`, icon:'info'});
      if (elISO) elISO.value = '';
      if (elView) elView.value = '';
      return;
    }

    jamInput.disabled = false;
    let minStr = conf.open || '00:00';
    let maxStr = conf.close || '23:59';

    const nowMsServer = Date.now() + (window.serverOffsetMs || 0);
    const nowServer   = new Date(nowMsServer);
    if (sameYmd(d, nowServer)) {
      const lead = Math.max(0, Math.min(1440, +(OP_HOURS?.lead ?? 0)));
      let earliest = nowServer.getHours()*60 + nowServer.getMinutes() + lead;
      const bs = toMin(conf.break_start), be = toMin(conf.break_end);
      if (bs!==null && be!==null && bs<be && earliest>=bs && earliest<be) earliest = be;
      const openMin = toMin(minStr) ?? 0;
      minStr = fromMin(Math.max(openMin, earliest));
    }

    jamInput.min = minStr;
    jamInput.max = maxStr;
    if (infoJam) infoJam.textContent = buildInfoLine(dayIdx, conf, minStr);
  }

  const minToday = todayYmd(); // disable tanggal sebelumnya

  if (window.flatpickr && elView) {
    flatpickr(elView, {
      locale: flatpickr.l10ns.id,
      dateFormat: 'd/m/Y',
      allowInput: true,
      disableMobile: true,
      minDate: minToday,
      onChange: function(selectedDates, _, inst){
        const d = selectedDates && selectedDates[0] ? selectedDates[0] : null;
        if (elISO) elISO.value = d ? inst.formatDate(d,'Y-m-d') : '';
        applyForDate(d);
      },
      onClose: function(_, __, inst){
        const typed = elView.value && inst.parseDate(elView.value, 'd/m/Y');
        const minD  = inst.parseDate(minToday, 'Y-m-d');
        if (typed && typed < minD) {
          elView.value = '';
          if (elISO) elISO.value = '';
          if (window.Swal) Swal.fire({title:'Tanggal tidak valid', text:'Tidak bisa memilih tanggal sebelum hari ini.', icon:'warning'});
        }
      }
    });
  } else {
    // Fallback (jarang terjadi krn flatpickr sudah disertakan)
    elView.type = 'date';
    elView.setAttribute('min', minToday);
    elView.addEventListener('change', function(){
      if (this.value && this.value < minToday) {
        this.value = '';
        if (infoTgl) infoTgl.textContent = 'Tidak bisa memilih tanggal sebelum hari ini.';
        if (window.Swal) Swal.fire({title:'Tanggal tidak valid', text:'Tidak bisa memilih tanggal sebelum hari ini.', icon:'warning'});
        return;
      }
      const d = this.value ? new Date(this.value) : null;
      elISO.value = this.value || '';
      applyForDate(d);
    });
  }

  // Jika sudah ada nilai awal valid, terapkan
  if (elISO && elISO.value && elISO.value >= minToday) {
    applyForDate(new Date(elISO.value));
  }
})();
</script>

<script>
/* =========================
   TANGGAL LAHIR (flatpickr)
========================= */
(function(){
  const view = document.getElementById('tanggal_lahir_view');
  const iso  = document.getElementById('tanggal_lahir');
  if (!view || !iso) return;

  function pad(n){ return (n<10?'0':'')+n; }
  function todayYmd(){
    const base = Date.now() + (window.serverOffsetMs || 0);
    const d = new Date(base);
    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
  }

  if (window.flatpickr) {
    flatpickr(view, {
      locale: flatpickr.l10ns.id,
      dateFormat: 'd/m/Y',
      allowInput: true,
      disableMobile: true,
      maxDate: todayYmd(),
      defaultDate: iso.value || null,
      onChange: function(selectedDates, _, inst){
        const d = selectedDates && selectedDates[0] ? selectedDates[0] : null;
        iso.value = d ? inst.formatDate(d, 'Y-m-d') : '';
      },
      onReady: function(_, __, inst){
        if (iso.value) {
          const parsed = inst.parseDate(iso.value, 'Y-m-d');
          if (parsed) view.value = inst.formatDate(parsed, 'd/m/Y');
        }
      }
    });
  } else {
    view.type = 'date';
    view.setAttribute('max', todayYmd());
    view.addEventListener('change', function(){ iso.value = this.value || ''; });
  }
})();
</script>

<script>
/* =========================
   MODE INSTANSI & LIMIT PENDAMPING
========================= */
(function(){
  var kat   = document.getElementById('kategori');
  var selW  = document.getElementById('instansi_select_wrap');
  var sel   = document.getElementById('instansi');
  var manW  = document.getElementById('instansi_manual_wrap');
  var man   = document.getElementById('instansi_manual');

  function useSelectMode(){
    selW.classList.remove('d-none');
    sel.removeAttribute('disabled'); sel.setAttribute('required','required');
    manW.classList.add('d-none');    man.setAttribute('disabled','disabled'); man.removeAttribute('required'); man.value = '';
  }
  function useManualMode(){
    manW.classList.remove('d-none');
    man.removeAttribute('disabled'); man.setAttribute('required','required');
    selW.classList.add('d-none');    sel.setAttribute('disabled','disabled'); sel.removeAttribute('required'); sel.value = '';
  }

  kat.addEventListener('change', function(){
    var v = this.value || '';
    if (v === 'lainnya'){ useManualMode(); }
    else if (v){ useSelectMode(); $('#instansi').html('<option value="">-- Pilih Instansi --</option>'); }
    else {
      sel.value=''; sel.setAttribute('disabled','disabled'); sel.removeAttribute('required');
      man.value=''; man.setAttribute('disabled','disabled'); man.removeAttribute('required');
      selW.classList.remove('d-none'); manW.classList.add('d-none');
    }
  });
  kat.dispatchEvent(new Event('change'));

  $('#unit_tujuan').on('change', function(){
    const unitId = $(this).val(); if(!unitId){ return; }
    $.getJSON('<?= site_url("booking/get_limit_pendamping"); ?>', { id: unitId }, function(res){
      const input = document.getElementById('jumlah_pendamping');
      if(res.max === null){ input.removeAttribute('max'); } else { input.setAttribute('max', res.max); }
    });
  });

  const URL_OPTIONS = '<?= site_url("booking/options_by_kategori"); ?>';
  function setInstansiLoading(){ $('#instansi').prop('disabled', true).html('<option value="">Memuat data...</option>'); }
  function resetInstansi(){ $('#instansi').prop('disabled', true).html('<option value="">-- Pilih Instansi --</option>'); }
  function loadInstansi(jenis){
    if(!jenis){ resetInstansi(); return; }
    setInstansiLoading();
    $.getJSON(URL_OPTIONS, { jenis: jenis })
      .done(function(resp){
        var list = Array.isArray(resp) ? resp : (resp.results || []);
        var $i = $('#instansi'); $i.empty().append('<option value="">-- Pilih Instansi --</option>');
        list.forEach(function(r){ $i.append('<option value="'+r.id+'">'+r.text+'</option>'); });
        $i.prop('disabled', list.length === 0);
      })
      .fail(function(){ resetInstansi(); alert('Gagal memuat data instansi.'); });
  }
  $('#kategori').on('change', function(){ loadInstansi(this.value); });
})();
</script>

<script>
/* =========================
   PANEL PENDAMPING (INLINE)
========================= */
(function(){
  window.pendamping = Array.isArray(window.pendamping) ? window.pendamping : [];
  let pendamping = window.pendamping;
  let editIndex  = (typeof window.editIndex === 'number') ? window.editIndex : -1;

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
  const inNikPemohon = document.getElementById('id_number');

  const onlyDigits = s => String(s||'').replace(/\D+/g,'');
  const is16Digits = s => /^\d{16}$/.test(String(s||''));
  function esc(s){ return String(s||'').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[m])); }
  function getTarget(){ return parseInt(inJumlah.value,10) || 0; }

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
            <button type="button" class="btn btn-xs btn-outline-info" onclick="pdEdit(${i})" title="Edit"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-xs btn-outline-danger" onclick="pdDel(${i})" title="Hapus"><i class="fas fa-trash-alt"></i></button>
          </td>
        </tr>
      `).join('');
    }
    hidJson.value = JSON.stringify(pendamping);
    if (pendamping.length !== getTarget()){
      pdHelp.classList.remove('text-muted'); pdHelp.classList.add('text-danger');
      pdHelp.textContent = `Jumlah pendamping terisi ${pendamping.length}/${getTarget()}.`;
    } else {
      pdHelp.classList.remove('text-danger'); pdHelp.classList.add('text-muted');
      pdHelp.textContent = 'Pastikan jumlah pendamping sesuai field “Jumlah Pendamping”.';
    }
  }

  function resetRowForm(){
    editIndex = -1; window.editIndex = editIndex;
    inNik.value = ''; inNama.value = '';
    btnAdd.classList.remove('d-none'); btnSave.classList.add('d-none'); btnCancel.classList.add('d-none');
    inNik.focus();
  }

  window.pdEdit = function(i){
    if (i<0 || i>=pendamping.length) return;
    editIndex = i; window.editIndex = editIndex;
    inNik.value  = pendamping[i].nik;
    inNama.value = pendamping[i].nama;
    btnAdd.classList.add('d-none'); btnSave.classList.remove('d-none'); btnCancel.classList.remove('d-none');
    if (wrap.classList.contains('d-none')) wrap.classList.remove('d-none');
    inNik.focus();
  };

  window.pdDel = async function(i){
    if (i < 0 || i >= pendamping.length) return;
    const nama = (pendamping[i] && (pendamping[i].nama || ''));
    const { isConfirmed } = await Swal.fire({
      title: 'Hapus pendamping?', text: nama ? `Nama: ${nama}` : 'Data ini akan dihapus.',
      icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal',
      reverseButtons: true, focusCancel: true
    });
    if (!isConfirmed) return;
    pendamping.splice(i, 1);
    if (editIndex === i) resetRowForm(); else if (editIndex > i) { editIndex--; window.editIndex = editIndex; }
    render();
    Swal.fire({ title: 'Terhapus', text: 'Data pendamping berhasil dihapus.', icon: 'success', timer: 1200, showConfirmButton: false });
  };

  if (Number(inJumlah?.value || 0) > 0) { wrap.classList.remove('d-none'); }
  inJumlah.addEventListener('change', ()=>{
    pdTarget.textContent = getTarget();
    if (pendamping.length !== getTarget()) wrap.classList.remove('d-none');
    render();
  });

  inNik.addEventListener('input', ()=>{ inNik.value = onlyDigits(inNik.value).slice(0,16); });

  btnAdd.addEventListener('click', ()=>{
    const nik  = onlyDigits(inNik.value);
    const nama = String(inNama.value||'').trim();
    if (!is16Digits(nik)) { alert('NIK pendamping wajib 16 digit.'); inNik.focus(); return; }
    if (!nama)           { alert('Nama pendamping wajib diisi.'); inNama.focus(); return; }
    if (inNikPemohon && onlyDigits(inNikPemohon.value) === nik){ alert('NIK pendamping tidak boleh sama dengan NIK tamu.'); inNik.focus(); return; }
    if (pendamping.some(p=>p.nik===nik)){ alert('NIK pendamping sudah ada di daftar.'); inNik.focus(); return; }
    const target = getTarget();
    if (target && pendamping.length >= target){ alert('Jumlah pendamping sudah mencapai batas.'); return; }
    pendamping.push({nik, nama});
    resetRowForm(); render();
  });

  btnSave.addEventListener('click', ()=>{
    if (editIndex < 0) return;
    const nik  = onlyDigits(inNik.value);
    const nama = String(inNama.value||'').trim();
    if (!is16Digits(nik)) { alert('NIK pendamping wajib 16 digit.'); inNik.focus(); return; }
    if (!nama)           { alert('Nama pendamping wajib diisi.'); inNama.focus(); return; }
    if (inNikPemohon && onlyDigits(inNikPemohon.value) === nik){ alert('NIK pendamping tidak boleh sama dengan NIK tamu.'); inNik.focus(); return; }
    if (pendamping.some((p,idx)=> idx!==editIndex && p.nik===nik)){ alert('NIK pendamping sudah ada di daftar.'); inNik.focus(); return; }
    pendamping[editIndex] = {nik, nama};
    resetRowForm(); render();
  });

  btnCancel.addEventListener('click', resetRowForm);

  window._ensurePendampingBeforeSubmit = function(){
    hidJson.value = JSON.stringify(pendamping);
    const target = getTarget();
    if (target !== pendamping.length){
      throw new Error(`Jumlah pendamping terisi ${pendamping.length}/${target}.`);
    }
    if (pendamping.some(p => !/^\d{16}$/.test(p.nik) || !p.nama?.trim())) {
      throw new Error('Lengkapi NIK (16 digit) dan Nama semua pendamping.');
    }
  };

  // Stepper +/- jumlah
  const MAX_PENDAMPING = 20;
  const elBadge  = document.getElementById('pdCountBadge');
  const btnPlus  = document.getElementById('btnPdPlus');
  const btnMinus = document.getElementById('btnPdMinus');

  function updateJumlahInput() {
    const n = window.pendamping.length;
    if (inJumlah) inJumlah.value = n;
    if (elBadge)  elBadge.textContent = n;
  }

  async function syncJumlahPendamping(target) {
    let t = parseInt(target, 10); if (isNaN(t)) t = 0;
    t = Math.max(0, Math.min(MAX_PENDAMPING, t));
    const cur = window.pendamping.length;
    if (t === cur) { updateJumlahInput(); return; }

    if (t > cur) {
      for (let i = cur; i < t; i++) { window.pendamping.push({ nik: '', nama: '' }); }
      updateJumlahInput();
      document.getElementById('pendampingWrap')?.classList.remove('d-none');
      render();
      const firstEmpty = window.pendamping.findIndex(p => !p.nik || !p.nama);
      if (firstEmpty >= 0) window.pdEdit(firstEmpty);
      return;
    }

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

    window.pendamping.splice(t);
    if (typeof window.editIndex === 'number' && window.editIndex >= t) window.editIndex = -1;
    updateJumlahInput(); render();
  }

  btnPlus && btnPlus.addEventListener('click', () => syncJumlahPendamping(window.pendamping.length + 1));
  btnMinus && btnMinus.addEventListener('click', () => syncJumlahPendamping(window.pendamping.length - 1));
  let pdTimer = null;
  inJumlah && inJumlah.addEventListener('input', () => {
    clearTimeout(pdTimer); pdTimer = setTimeout(() => syncJumlahPendamping(inJumlah.value), 250);
  });
  inJumlah && inJumlah.addEventListener('change', () => syncJumlahPendamping(inJumlah.value));

  render(); updateJumlahInput();
})();
</script>

<script>
/* =========================
   SUBMIT / BOOKING
========================= */
function simpan(btn){
  btn = btn || document.getElementById('btnBooking');
  const url = "<?= site_url(strtolower($controller).'/add')?>/";

  Swal.fire({
    title: 'Kirim Booking?',
    html: `
      Saya setuju
      <a href="<?= site_url('hal'); ?>" target="_blank" rel="noopener">Syarat &amp; Ketentuan</a>
      dan telah membaca
      <a href="<?= site_url('hal/privacy_policy'); ?>" target="_blank" rel="noopener">Kebijakan Privasi</a>.
    `,
    icon: "question",
    showCancelButton: true,
    allowOutsideClick: false,
    reverseButtons: true,
    buttonsStyling: true,
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton:  "btn btn-warning"
    },
    input: "checkbox",
    inputValue: 0,
    inputPlaceholder: "Ceklis: Ya, saya setuju !!!",
    confirmButtonText: "Ya, kirim sekarang",
    cancelButtonText:  "Batal",
    inputValidator: (result) => {
      if (!result) return "Silakan ceklis persetujuan terlebih dahulu.";
      return undefined;
    }
  }).then((res) => {
    if (!res.isConfirmed) return;

    // Validasi pendamping + sinkron hidden
    try {
      if (typeof window._ensurePendampingBeforeSubmit === 'function') {
        window._ensurePendampingBeforeSubmit();
      }
    } catch (e) {
      Swal.fire({ title:'Validasi Gagal', text: e.message || 'Cek kembali data pendamping.', icon:'error' });
      return;
    }

    const form = document.getElementById('form_app');
    const formData = new FormData(form);

    setLoading(true, btn, {
      steps: ['Memvalidasi data…','Cek hari & jam…','Cek kuota pendamping…','Cek slot jadwal…','Menyimpan…','Generate QR…','Kirim WhatsApp…'],
      interval: 900
    });
    loader();

    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json"
    })
    .done(function(obj){
      if(!obj || obj.success === false){
        Swal.fire({
          title: obj?.title || "Validasi Gagal",
          icon: "error",
          html: obj?.pesan || "Terjadi kesalahan.",
          allowOutsideClick: false,
          buttonsStyling: false,
          customClass: { confirmButton: "btn btn-danger" },
          confirmButtonText: "OK"
        });
        return;
      }

      if (obj.redirect_url) {
        window.location.assign(obj.redirect_url);
        return;
      }

      const htmlInfo = (obj.pesan || "") + "<br><br>" +
                       "<b>QR Code:</b><br>" +
                       "<img src='" + obj.qr_url + "' alt='QR Code' style='width:150px;height:150px;'>";

      Swal.fire({
        title: obj.title || "Booking Berhasil",
        html: htmlInfo,
        icon: "success",
        allowOutsideClick: false,
        buttonsStyling: false,
        customClass: { confirmButton: "btn btn-success" },
        confirmButtonText: "Selesai"
      });

      if (typeof $ !== 'undefined' && $("#full-width-modal").length) {
        $("#full-width-modal").modal("hide");
      }
      if (typeof reload_table === 'function') reload_table();
    })
    .fail(function(xhr, status, error){
      Swal.fire({
        title: "Error",
        text: "Terjadi kesalahan pada server: " + (error || status),
        icon: "error",
        buttonsStyling: false,
        customClass: { confirmButton: "btn btn-danger" },
        confirmButtonText: "OK"
      });
    })
    .always(function(){
      setLoading(false, btn);
    });
  });
}
</script>
