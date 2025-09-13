<script>

const MARGIN_CLASS = 'ml-2';

function setLoading(isLoading, btn, opts) {
  btn  = btn  || document.getElementById('btnBooking');
  opts = opts || {};

  const steps = opts.steps || [
    'Memvalidasi data…',
    'Cek hari & jam…',
    'Cek kuota pendamping…',
    'Cek slot jadwal…',
    'Menyimpan…',
    'Generate QR…',
    'Kirim WhatsApp…'
  ];
  const intervalMs = opts.interval || 900;

  if (isLoading) {
    if (btn.dataset.loadingActive === '1') return; // sudah loading, abaikan
    btn.dataset.originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.dataset.loadingActive = '1';

    let i = 0;
    // render pertama
    btn.innerHTML =
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
      `<span class="${MARGIN_CLASS}">${steps[i]}</span>`;

    // rotasi teks
    const id = setInterval(() => {
      i = (i + 1) % steps.length;
      btn.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
        `<span class="${MARGIN_CLASS}">${steps[i]}</span>`;
    }, intervalMs);

    btn.dataset.loadingInterval = id;
  } else {
    // matikan interval & kembalikan tombol
    if (btn.dataset.loadingInterval) {
      clearInterval(+btn.dataset.loadingInterval);
      delete btn.dataset.loadingInterval;
    }
    btn.disabled = false;
    btn.innerHTML = btn.dataset.originalHtml || 'Booking Sekarang';
    delete btn.dataset.loadingActive;
  }
}


function simpan(btn){
  btn = btn || document.getElementById('btnBooking');
  const url = "<?= site_url(strtolower($controller).'/add')?>/";

  const title             = 'Kirim Booking?';
  const text              = 'Pastikan seluruh data sudah benar.';
  const confirmButtonText = 'Ya, kirim sekarang';
  const cancelButtonText  = 'Batal';
  


  Swal.fire({
    title: title,
    // text: text,
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
    // Pakai customClass agar cocok dengan Bootstrap
    buttonsStyling: true,
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton:  "btn btn-warning" // Bootstrap 5 => ganti ml-2 -> ms-2
    },
    // Checkbox konfirmasi
    input: "checkbox",
    inputValue: 0, // default: belum dicentang
    inputPlaceholder: "Ceklis: Ya, saya setuju !!!",
    confirmButtonText: confirmButtonText,
    cancelButtonText:  cancelButtonText,
    inputValidator: (result) => {
      if (!result) {
        return "Silakan ceklis persetujuan terlebih dahulu.";
      }
      return undefined;
    }
  }).then((res) => {
    if (!res.isConfirmed) return;

    // Lanjut submit AJAX setelah konfirmasi & ceklis OK
    const form = document.getElementById('form_app');
    const formData = new FormData(form);

    setLoading(true, btn, {
      steps: [
        'Memvalidasi data…',
        'Cek hari & jam…',
        'Cek kuota pendamping…',
        'Cek slot jadwal…',
        'Menyimpan…',
        'Generate QR…',
        'Kirim WhatsApp…'
      ],
      interval: 900
    });
    loader();

    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      processData: false, // biarkan FormData apa adanya
      contentType: false, // multipart/form-data otomatis
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
      if (obj.redirect_url) {
        window.location.assign(obj.redirect_url);
        return;
    }
      // jika kamu menampilkan form di modal
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

window.OP_HOURS = <?= json_encode([
  'tz'    => $rec->waktu ?? 'Asia/Makassar',
  'lead'  => (int)($rec->min_lead_minutes ?? 10),
  'days'  => [
    // 0=Min..6=Sab (ikut getDay())
    '0' => ['open'=>$rec->op_sun_open ?? null, 'break_start'=>$rec->op_sun_break_start ?? null, 'break_end'=>$rec->op_sun_break_end ?? null, 'close'=>$rec->op_sun_close ?? null, 'closed'=>(int)($rec->op_sun_closed ?? 1)],
    '1' => ['open'=>$rec->op_mon_open ?? '08:00','break_start'=>$rec->op_mon_break_start ?? null,'break_end'=>$rec->op_mon_break_end ?? null,'close'=>$rec->op_mon_close ?? '15:00','closed'=>(int)($rec->op_mon_closed ?? 0)],
    '2' => ['open'=>$rec->op_tue_open ?? '08:00','break_start'=>$rec->op_tue_break_start ?? null,'break_end'=>$rec->op_tue_break_end ?? null,'close'=>$rec->op_tue_close ?? '15:00','closed'=>(int)($rec->op_tue_closed ?? 0)],
    '3' => ['open'=>$rec->op_wed_open ?? '08:00','break_start'=>$rec->op_wed_break_start ?? null,'break_end'=>$rec->op_wed_break_end ?? null,'close'=>$rec->op_wed_close ?? '15:00','closed'=>(int)($rec->op_wed_closed ?? 0)],
    '4' => ['open'=>$rec->op_thu_open ?? '08:00','break_start'=>$rec->op_thu_break_start ?? null,'break_end'=>$rec->op_thu_break_end ?? null,'close'=>$rec->op_thu_close ?? '15:00','closed'=>(int)($rec->op_thu_closed ?? 0)],
    '5' => ['open'=>$rec->op_fri_open ?? '08:00','break_start'=>$rec->op_fri_break_start ?? null,'break_end'=>$rec->op_fri_break_end ?? null,'close'=>$rec->op_fri_close ?? '14:00','closed'=>(int)($rec->op_fri_closed ?? 0)],
    '6' => ['open'=>$rec->op_sat_open ?? '08:00','break_start'=>$rec->op_sat_break_start ?? null,'break_end'=>$rec->op_sat_break_end ?? null,'close'=>$rec->op_sat_close ?? '11:30','closed'=>(int)($rec->op_sat_closed ?? 0)],
  ]
], JSON_UNESCAPED_SLASHES) ?>;
const tanggalInput = document.getElementById('tanggal');
const jamInput     = document.getElementById('jam');
const infoTanggal  = document.getElementById('infoTanggal');
const infoJam      = document.getElementById('jam-info');

const HARI_ID = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

function pad(n){ return (n<10?'0':'')+n; }
function toMin(hhmm){ if(!hhmm) return null; const [h,m]=hhmm.split(':').map(x=>+x); return h*60+m; }
function fromMin(m){ const h=Math.floor(m/60), i=m%60; return `${pad(h)}:${pad(i)}`; }
function dot(hhmm){ return hhmm ? hhmm.replace(':','.') : ''; }

// Hari ini (YYYY-MM-DD) di TZ server kalau offset ada, fallback browser
function todayYmd(){
  const base = Date.now() + (window.serverOffsetMs || 0);
  const d = new Date(base);
  return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
}

// set min tanggal = hari ini (di TZ server bila tersedia)
if (tanggalInput) {
  tanggalInput.setAttribute('min', todayYmd());
}

function buildInfoLine(dayIdx, conf){
  const hari = HARI_ID[dayIdx] || '';
  if (!conf || conf.closed) return `${hari}: Libur`;
  let line = `${hari}: ${dot(conf.open)} - ${dot(conf.close)}`;
  if (conf.break_start && conf.break_end) {
    line += ` (Istirahat ${dot(conf.break_start)} - ${dot(conf.break_end)})`;
  }
  if (window.OP_HOURS?.tz) line += ` ${({'Asia/Jakarta':'WIB','Asia/Makassar':'WITA','Asia/Jayapura':'WIT'})[window.OP_HOURS.tz] || ''}`;
  return line;
}

function sameYmd(a,b){ return a && b && a.getFullYear()===b.getFullYear() && a.getMonth()===b.getMonth() && a.getDate()===b.getDate(); }

tanggalInput?.addEventListener('change', function() {
  const picked = this.value ? new Date(this.value) : null;
  // reset UI
  jamInput.value = '';
  jamInput.disabled = true;
  jamInput.removeAttribute('min');
  jamInput.removeAttribute('max');
  if (infoTanggal) infoTanggal.innerText = '';
  if (infoJam) infoJam.innerText = '';

  if (!picked || isNaN(picked)) return;

  const dayIdx = picked.getDay(); // 0=Min..6=Sab
  const conf   = window.OP_HOURS?.days?.[String(dayIdx)];

  // jika tidak ada konfigurasi → treat libur
  if (!conf || conf.closed) {
    this.value = '';
    if (infoTanggal) infoTanggal.innerText = `Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`;
    if (window.Swal) {
      Swal.fire({ title:'Info', html:`Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`, icon:'error', allowOutsideClick:false });
    }
    return;
  }

  // enable input time + set min/max dari DB
  jamInput.disabled = false;

  // min/max dasar dari jam buka–tutup
  let minStr = conf.open || '00:00';
  let maxStr = conf.close || '23:59';

  // jika tanggal yang dipilih adalah "hari ini" (di TZ server), terapkan lead-time
  const nowMsServer = Date.now() + (window.serverOffsetMs || 0);
  const todayServer = new Date(nowMsServer);
  if (sameYmd(picked, todayServer)) {
    const lead = Math.max(0, Math.min(1440, +(window.OP_HOURS?.lead ?? 0)));
    const nowMin = todayServer.getHours()*60 + todayServer.getMinutes() + lead;
    const minByLead = fromMin(nowMin);
    // ambil yang paling besar: jam buka vs (sekarang+lead)
    minStr = fromMin( Math.max( toMin(minStr), nowMin ) );
  }

  jamInput.min = minStr;
  jamInput.max = maxStr;

  // Tampilkan info di bawah field
  if (infoJam) {
    infoJam.innerText = buildInfoLine(dayIdx, conf);
    // info tambahan untuk HARI INI (bila min terdorong oleh lead)
    const pushed = toMin(minStr) > toMin(conf.open || '00:00');
    if (pushed) {
      infoJam.innerText += ` • Minimal untuk hari ini: ${dot(minStr)}`;
    }
  }
});




$('#unit_tujuan').on('change', function(){
  const unitId = $(this).val();
  if(!unitId){ return; }

  $.getJSON('<?= site_url("booking/get_limit_pendamping"); ?>', { id: unitId }, function(res){
    const input = document.getElementById('jumlah_pendamping');
    if(res.max === null){         // NULL = tak dibatasi
      input.removeAttribute('max');
    } else {
      input.setAttribute('max', res.max);
    }
  });
});


$(function(){
  const URL_OPTIONS = '<?= site_url("booking/options_by_kategori"); ?>';

  function setInstansiLoading(){
    $('#instansi').prop('disabled', true)
      .html('<option value="">Memuat data...</option>');
  }
  function resetInstansi(){
    $('#instansi').prop('disabled', true)
      .html('<option value="">-- Pilih Instansi --</option>');
  }
  function loadInstansi(jenis){
    if(!jenis){ resetInstansi(); return; }
    setInstansiLoading();

    $.getJSON(URL_OPTIONS, { jenis: jenis })
      .done(function(resp){
        var list = Array.isArray(resp) ? resp : (resp.results || []);
        var $i = $('#instansi');
        $i.empty().append('<option value="">-- Pilih Instansi --</option>');
        list.forEach(function(r){
          $i.append('<option value="'+r.id+'">'+r.text+'</option>');
        });
        $i.prop('disabled', list.length === 0);
      })
      .fail(function(xhr){
        console.error('Gagal load instansi:', xhr.status, xhr.responseText);
        resetInstansi();
        alert('Gagal memuat data instansi.');
      });
  }

  $('#kategori').on('change', function(){
    loadInstansi(this.value);
  });

  // optional: set default kategori saat page load
  // $('#kategori').val('opd').trigger('change');
});

function loader() {
    Swal.fire({
        title: "Prosess...",
        html: "Jangan tutup halaman ini",
        allowOutsideClick: false,
        didOpen: function() {
            Swal.showLoading();
        }
    })
}

// document.getElementById('foto').addEventListener('change', function(){
//   const f = this.files[0];
//   if (f && f.size/1024 > 1536) {
//     Swal.fire('File terlalu besar','Maksimal 1.5 MB','warning');
//     this.value = '';
//   }
// });

</script>
<script>
(function(){
  // ====== Elemen ======
  const elView  = document.getElementById('tanggal_view') || document.getElementById('tanggal'); // jika tidak pakai tanggal_view, dia akan pakai #tanggal (native)
  const elISO   = document.getElementById('tanggal');       // hidden YYYY-MM-DD (atau input aslinya kalau belum pakai hidden)
  const jamInput = document.getElementById('jam');
  const infoJam  = document.getElementById('jam-info');
  const infoTgl  = document.getElementById('tanggal-info');

  // ====== Util ======
  const HARI_ID = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const TZ_ABBR = {'Asia/Jakarta':'WIB','Asia/Makassar':'WITA','Asia/Jayapura':'WIT'};
  const tzAbbr  = TZ_ABBR[(window.OP_HOURS && OP_HOURS.tz) || 'Asia/Makassar'] || '';

  const pad = n => (n<10?'0':'')+n;
  const toMin = s => !s ? null : ( (h=s.split(':')[0]|0, m=s.split(':')[1]|0), h*60+m );
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
    // reset
    jamInput.value = '';
    jamInput.disabled = true;
    jamInput.removeAttribute('min');
    jamInput.removeAttribute('max');
    if (infoTgl) infoTgl.textContent = '';
    if (infoJam) infoJam.textContent = '';

    if (!(d instanceof Date) || isNaN(d)) return;

    const dayIdx = d.getDay();                   // 0=Min..6=Sab
    const conf   = OP_HOURS?.days?.[String(dayIdx)];

    if (!conf || conf.closed) {
      if (infoTgl) infoTgl.textContent = `Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`;
      if (window.Swal) Swal.fire({title:'Info', html:`Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`, icon:'info'});
      if (elISO && elISO !== elView) elISO.value = '';
      if (elView && elView.id === 'tanggal') elView.value = '';
      return;
    }

    // Enable jam + min/max dasar
    jamInput.disabled = false;
    let minStr = conf.open || '00:00';
    let maxStr = conf.close || '23:59';

    // Lead time utk HARI INI
    const nowMsServer = Date.now() + (window.serverOffsetMs || 0);
    const nowServer   = new Date(nowMsServer);
    if (sameYmd(d, nowServer)) {
      const lead = Math.max(0, Math.min(1440, +(OP_HOURS?.lead ?? 0)));
      let earliest = nowServer.getHours()*60 + nowServer.getMinutes() + lead;

      // jika earliest di sela istirahat → geser ke akhir istirahat
      const bs = toMin(conf.break_start), be = toMin(conf.break_end);
      if (bs!==null && be!==null && bs<be && earliest>=bs && earliest<be) earliest = be;

      // ambil terbesar: buka vs earliest
      const openMin = toMin(minStr) ?? 0;
      minStr = fromMin(Math.max(openMin, earliest));
    }

    jamInput.min = minStr;
    jamInput.max = maxStr;

    if (infoJam) infoJam.textContent = buildInfoLine(dayIdx, conf, minStr);
  }

  // ====== Inisialisasi datepicker (DISABLE tanggal sebelumnya) ======
  const minToday = todayYmd(); // YYYY-MM-DD, patokan min

  if (window.flatpickr && elView && elView.id !== 'tanggal') {
    // Mode 2 input: tanggal_view (dd/mm/yyyy) + hidden tanggal (yyyy-mm-dd)
    flatpickr(elView, {
      locale: flatpickr.l10ns.id,
      dateFormat: 'd/m/Y',        // tampilan
      allowInput: true,
      disableMobile: true,
      minDate: minToday,          // <<— MATIIN tanggal sebelumnya
      // opsional: disable Minggu
      // disable: [date => date.getDay() === 0],

      onChange: function(selectedDates, _, inst){
        const d = selectedDates && selectedDates[0] ? selectedDates[0] : null;
        if (elISO) elISO.value = d ? inst.formatDate(d,'Y-m-d') : '';
        applyForDate(d);
      },
      onClose: function(_, __, inst){
        // Jika user ngetik manual: validasi ulang & tolak tanggal < hari ini
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
    // Fallback: native <input type="date"> — set min & hard-guard
    if (elView) elView.setAttribute('min', minToday);
    elView?.addEventListener('change', function(){
      // Tolak manual input < min
      if (this.value && this.value < minToday) {
        this.value = '';
        if (infoTgl) infoTgl.textContent = 'Tidak bisa memilih tanggal sebelum hari ini.';
        if (window.Swal) Swal.fire({title:'Tanggal tidak valid', text:'Tidak bisa memilih tanggal sebelum hari ini.', icon:'warning'});
        return;
      }
      const d = this.value ? new Date(this.value) : null;
      applyForDate(d);
    });
  }

  // Jika sudah ada nilai awal, terapkan aturan (mis. ketika kembali ke form)
  if (elISO && elISO.value) {
    // Jika default value lebih kecil dari hari ini, kosongkan
    if (elISO.value < minToday) {
      elISO.value = '';
      if (elView && elView.id === 'tanggal') elView.value = '';
    } else {
      applyForDate(new Date(elISO.value));
    }
  }
})();
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
    if (pendamping.some(p => !/^\d{16}$/.test(p.nik) || !p.nama?.trim())) {
      throw new Error('Lengkapi NIK (16 digit) dan Nama semua pendamping.');
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

<script>
(function(){
  const view = document.getElementById('tanggal_lahir_view');
  const iso  = document.getElementById('tanggal_lahir');
  if (!view || !iso) return;

  function pad(n){ return (n<10?'0':'')+n; }
  function todayYmd(){
    const base = Date.now() + (window.serverOffsetMs || 0); // pakai offset server jika tersedia
    const d = new Date(base);
    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
  }

  if (window.flatpickr) {
    flatpickr(view, {
      locale: flatpickr.l10ns.id,
      dateFormat: 'd/m/Y',     // tampilan
      allowInput: true,
      disableMobile: true,     // paksa UI flatpickr di mobile
      maxDate: todayYmd(),     // tidak boleh di masa depan
      defaultDate: iso.value || null, // kalau hidden sudah punya nilai awal (Y-m-d)

      onChange: function(selectedDates, _, inst){
        const d = selectedDates && selectedDates[0] ? selectedDates[0] : null;
        iso.value = d ? inst.formatDate(d, 'Y-m-d') : '';
      },
      onReady: function(_, __, inst){
        // Jika hidden sudah terisi (Y-m-d), sinkron tampilan dd/mm/Y
        if (iso.value) {
          const parsed = inst.parseDate(iso.value, 'Y-m-d');
          if (parsed) view.value = inst.formatDate(parsed, 'd/m/Y');
        }
      }
    });
  } else {
    // Fallback: pakai native date (format tampil bisa beda-beda per device)
    view.type = 'date';
    view.setAttribute('max', todayYmd());
    view.addEventListener('change', function(){
      iso.value = this.value || '';
    });
  }
})();
</script>
