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
  const elView  = document.getElementById('tanggal_view') || document.getElementById('tanggal'); // kalau belum ada tanggal_view, pakai tanggal
  const elISO   = document.getElementById('tanggal');       // hidden YYYY-MM-DD (atau input aslinya kalau belum pakai hidden)
  const jamInput = document.getElementById('jam');
  const infoJam  = document.getElementById('jam-info');
  const infoTgl  = document.getElementById('tanggal-info'); // <- perbaikan ID

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
    // Reset state
    jamInput.value = '';
    jamInput.disabled = true;
    jamInput.removeAttribute('min');
    jamInput.removeAttribute('max');
    if (infoTgl) infoTgl.textContent = '';
    if (infoJam) infoJam.textContent = '';

    if (!(d instanceof Date) || isNaN(d)) return;

    const dayIdx = d.getDay();                   // 0=Min..6=Sab
    const conf   = OP_HOURS?.days?.[String(dayIdx)];

    // Minggu/libur
    if (!conf || conf.closed) {
      if (infoTgl) infoTgl.textContent = `Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`;
      if (window.Swal) Swal.fire({title:'Info', html:`Hari ${HARI_ID[dayIdx]} libur, silakan pilih hari lain.`, icon:'info'});
      // kosongkan hidden biar tidak terkirim
      if (elISO && elISO !== elView) elISO.value = '';
      if (elView && elView.id === 'tanggal') elView.value = '';
      return;
    }

    // Enable jam + min/max dasar
    jamInput.disabled = false;
    let minStr = conf.open || '00:00';
    let maxStr = conf.close || '23:59';

    // Lead time untuk HARI INI (pakai jam server offset bila ada)
    const nowMsServer = Date.now() + (window.serverOffsetMs || 0);
    const nowServer   = new Date(nowMsServer);
    if (sameYmd(d, nowServer)) {
      const lead = Math.max(0, Math.min(1440, +(OP_HOURS?.lead ?? 0)));
      let earliest = nowServer.getHours()*60 + nowServer.getMinutes() + lead;

      // Jika earliest nabrak istirahat, geser ke akhir istirahat
      const bs = toMin(conf.break_start), be = toMin(conf.break_end);
      if (bs!==null && be!==null && bs<be && earliest>=bs && earliest<be) earliest = be;

      // Ambil yang terbesar antara jam buka & earliest
      const openMin = toMin(minStr) ?? 0;
      minStr = fromMin(Math.max(openMin, earliest));
    }

    // Pasang batas ke input
    jamInput.min = minStr;
    jamInput.max = maxStr;

    // Info kecil di bawah input jam
    if (infoJam) infoJam.textContent = buildInfoLine(dayIdx, conf, minStr);
  }

  // ====== Inisialisasi datepicker ======
  if (window.flatpickr && elView && elView.id !== 'tanggal') {
    // Mode 2 input: tanggal_view (dd/mm/yyyy) + hidden tanggal (yyyy-mm-dd)
    flatpickr(elView, {
      locale: flatpickr.l10ns.id,
      dateFormat: 'd/m/Y',
      allowInput: true,
      disableMobile: true,
      minDate: todayYmd(),
      disable: [date => date.getDay() === 0], // disable Minggu di kalender
      onChange: function(selectedDates, _, inst){
        const d = selectedDates && selectedDates[0] ? selectedDates[0] : null;
        // sinkron hidden (yyyy-mm-dd)
        if (elISO) elISO.value = d ? inst.formatDate(d,'Y-m-d') : '';
        applyForDate(d);
      }
    });
  } else {
    // Fallback: pakai <input type="date" id="tanggal">
    if (elView) elView.setAttribute('min', todayYmd());
    elView?.addEventListener('change', function(){
      const d = this.value ? new Date(this.value) : null;
      // Kalau kamu tetap ingin tampil dd/mm/yyyy, tampilkan ke info saja (input native tetap yyyy-mm-dd)
      applyForDate(d);
    });
  }

  // Jalankan sekali (kalau sudah ada nilai awal)
  if (elISO && elISO.value) {
    applyForDate(new Date(elISO.value));
  }
})();
</script>

