<script>
    $(document).ready(function() {
    $('#btn_cari').on('click', function() {
        var noTracking = $('#no_tracking').val().trim();

        if (noTracking === '') {
            $('#hasil_tracking').html(`<div class="alert alert-danger text-center col-md-6">Masukkan No. Tracking terlebih dahulu.</div>`);
            return;
        }

        // Menampilkan spinner loading saat permintaan AJAX dimulai
        $.ajax({
            url: '<?= site_url("tracking/cek") ?>',
            type: 'POST',
            data: { no_registrasi: noTracking },
            dataType: 'json',
            beforeSend: function() {
                $('#hasil_tracking').empty(); // Kosongkan hasil sebelumnya
                $('#loading-spinner').show(); // Tampilkan spinner loading
            },
            success: function(res) {
                $('#loading-spinner').hide(); // Sembunyikan spinner setelah respons diterima
                $('#icl').hide(); // Sembunyikan spinner setelah respons diterima
                if (res.status === true) {
                    const statusInfo = getStatusIcon(res.data.status);
                    const durasiLabel = res.data.status === 3 ? 'Durasi Permohonan' : 'Proses Berlangsung';

                    // Menambahkan pesan berkas telah dikirim via WhatsApp atau bisa diambil di kantor desa
                    let berkasInfo = '';
                    if (res.data.status === 3) {
                        berkasInfo = '<li><strong>Berkas:</strong> Berkas digital telah dikirim melalui WhatsApp. Anda juga dapat mengambil berkas fisik langsung di kantor ' + res.data.kantor + '.</li>';

                    }
                    let fisik = "";
                    if (res.data.ket && res.data.ket.trim() !== "") {
                        fisik = '<li><strong>' + res.data.ket + '</strong></li>';
                    }



                    $('#hasil_tracking').html(`
                        <div class="col-md-8">
                            <div class="card card-pricing">
                                <div class="card-body text-center">
                                    <p class="card-pricing-plan-name font-weight-bold text-uppercase">${res.data.nama_permohonan}</p>
                                    <p class="card-pricing-plan-name font-weight-bold">${res.data.deskripsi}</p>
                                    <span class="card-pricing-icon ${statusInfo.color}">
                                        <i class="${statusInfo.icon}"></i>
                                    </span>
                                    <h4 class="card-pricing-price text-dark font-weight-bold">🧑‍ ${res.data.nama}</h4>
                                    <ul class="card-pricing-features text-center text-dark mt-2">
                                        <li><strong>NIK:</strong><br> ${res.data.nik}</li>
                                        <li><strong>No. KK:</strong><br> ${res.data.no_kk}</li>
                                        <li><strong>Alamat:</strong><br> ${res.data.alamat}</li>
                                        <li><strong>Tanggal Permohonan:</strong><br> ${res.data.tgl_permohonan}</li>
                                        <li><strong>Update Terakhir:</strong><br> ${res.data.update_time}</li>
                                        <li><strong>${durasiLabel}:</strong><br> ${res.data.durasi}</li>
                                        <li><strong>Status:</strong><br> <span class="badge ${statusInfo.badgeClass}">${statusInfo.label}</span></li>
                                        ${res.data.status == 4 ? `<li><strong>Alasan Penolakan:</strong> ${res.data.alasan_penolakan}</li>` : ''}
                                        ${berkasInfo}
                                        ${fisik}
                                    </ul>
                                    <button class="btn btn-info waves-effect mt-3 mb-2 text-dark" disabled>No. Tracking: ${$('#no_tracking').val()}</button>
                                </div>
                            </div>
                        </div>
                    `);
                }
                else {
                    $('#hasil_tracking').html(`<div class="alert alert-warning text-center col-md-6">❗ Data tidak ditemukan.</div>`);
                }
            },
            error: function() {
                $('#loading-spinner').hide(); // Sembunyikan spinner setelah error
                $('#hasil_tracking').html(`<div class="alert alert-danger text-center col-md-6">Terjadi kesalahan. Coba lagi.</div>`);
            }
        });
    });
});

// versi bootstrap 4 pakai 'ml-2', kalau bootstrap 5 ganti jadi 'ms-2'
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
    text: text,
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
    inputPlaceholder: "Ceklis: Ya, saya sangat yakin !!!",
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


const tanggalInput = document.getElementById('tanggal');
const jamInput = document.getElementById('jam');
const infoTanggal = document.getElementById('tanggal-info');
const infoJam = document.getElementById('jam-info');

// Set agar tanggal minimum = hari ini
const today = new Date().toISOString().split("T")[0];
tanggalInput.setAttribute("min", today);

tanggalInput.addEventListener('change', function() {
    const tgl = new Date(this.value);
    const hari = tgl.getDay(); // 0 = Minggu, 1 = Senin, dst.

    // reset jam
    jamInput.value = "";
    jamInput.disabled = true;
    jamInput.removeAttribute("min");
    jamInput.removeAttribute("max");
    infoTanggal.innerText = "";
    infoJam.innerText = "";

    if (isNaN(hari)) return; // input kosong

    if (hari === 0) { // Minggu
        this.value = ""; // kosongkan lagi
        infoTanggal.innerText = "Hari Minggu libur, silakan pilih hari lain.";
        Swal.fire({
            title: "Info",
            html: "Hari Minggu libur, silakan pilih hari lain.",
            icon: "error",
            allowOutsideClick: false,
        });
        return;
    }

    // hari valid → enable jam sesuai aturan
    jamInput.disabled = false;

    if (hari === 5) { // Jumat
        jamInput.min = "08:00";
        jamInput.max = "14:00";
        infoJam.innerText = "Jam kunjungan Jumat: 08.00 - 14.00";
    } else if (hari === 6) { // Sabtu
        jamInput.min = "08:00";
        jamInput.max = "11:30";
        infoJam.innerText = "Jam kunjungan Sabtu: 08.00 - 11.30";
    } else { // Senin - Kamis
        jamInput.min = "08:00";
        jamInput.max = "15:00";
        infoJam.innerText = "Jam kunjungan Senin-Kamis: 08.00 - 15.00";
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

