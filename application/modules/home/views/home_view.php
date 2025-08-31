<?php $this->load->view("front_end/head.php") ?>
<div class="container-fluid">
  <div class="row mt-3">
    <div class="col-xl-4">
      <div class="card">
        <div class="card-bottom text-center">
          <div class="d-flex justify-content-center">
           <svg id="Layer_1" class="svg-computer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 450.2 450.2" width="150" height="150">
            <style>.st0{fill:none;stroke:green;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10}.logo-text,.logo-text-mo{font-family:Arial,sans-serif;font-weight:bold;font-size:50px;fill:#ee324d}.logo-text-mo{opacity:0;animation:fadeInOutText 5s ease-in-out infinite;filter:url(#textShadow)}.char{opacity:0;animation:fadeChar 3s ease-in-out infinite}.char:nth-child(1){animation-delay:0s}.char:nth-child(2){animation-delay:.2s}.char:nth-child(3){animation-delay:.4s}.char:nth-child(4){animation-delay:.6s}.char:nth-child(5){animation-delay:.8s}.char:nth-child(6){animation-delay:1s}.char:nth-child(7){animation-delay:1.2s}.char:nth-child(8){animation-delay:1.4s}.char:nth-child(9){animation-delay:1.6s}.char:nth-child(10){animation-delay:1.8s}.char:nth-child(11){animation-delay:2s}.char:nth-child(12){animation-delay:2.2s}.char:nth-child(13){animation-delay:2.4s}@keyframes fadeChar{0%{opacity:0;transform:translateY(10px)}30%,70%{opacity:1;transform:translateY(0)}100%{opacity:0;transform:translateY(-10px)}}@keyframes fadeInOutText{0%{opacity:0;transform:translateY(10px)}30%,70%{opacity:1;transform:translateY(0)}100%{opacity:0;transform:translateY(-10px)}}</style>

            <g id="Layer_2">
              <path class="st0" d="M339.7 289h-323c-2.8 0-5-2.2-5-5V55.5c0-2.8 2.2-5 5-5h323c2.8 0 5 2.2 5 5V284c0 2.7-2.2 5-5 5z"/>
              <path class="st0" d="M26.1 64.9h304.6v189.6H26.1zM137.9 288.5l-3.2 33.5h92.6l-4.4-33M56.1 332.6h244.5l24.3 41.1H34.5zM340.7 373.7s-.6-29.8 35.9-30.2c36.5-.4 35.9 30.2 35.9 30.2h-71.8z"/>
              <path class="st0" d="M114.2 82.8v153.3h147V82.8zM261.2 91.1h-147"/>
              <path class="st0" d="M124 8M196.6 170.2H249v51.7h-52.4zM196.6 157.3H249M124.5 170.2h62.2M124.5 183.2h62.2M124.5 196.1h62.2M124.5 209h62.2M124.5 221.9h62.2"/>
              <text x="41%" y="29%" text-anchor="middle" alignment-baseline="middle" class="logo-text-mo">Lapas</text>
              <defs><filter id="textShadow" x="-50%" y="-50%" width="200%" height="200%"><feDropShadow dx="2" dy="2" stdDeviation="2" flood-color="black" flood-opacity="0.5"/></filter></defs>
              <text x="43%" y="100%" text-anchor="middle" class="logo-text">
                <tspan class="char">M</tspan><tspan class="char">a</tspan><tspan class="char">k</tspan><tspan class="char">a</tspan><tspan class="char">s</tspan><tspan class="char">s</tspan><tspan class="char">a</tspan><tspan class="char">r</tspan>
              </text>
            </g>
          </div>

        </div>

        <div class="card-footer bg-white border-top-0">
        </div>
        <div style="text-align: center;">
          <button type="button" id="installButton" style="display: none;"  class="btn btn-success shadow-sm mb-2">
            <i class="fab fa-android me-2"></i> Instal Aplikasi
          </button>
        </div>
      </div>
    </div> <!-- end col-->

    <div class="col-xl-8">
     <div class="card-box ribbon-box d-none d-md-block">
      <div class="ribbon-two ribbon-two-blue"><span>SiLapas</span></div>
      <p class="mb-2" style="margin-left:22px; margin-top: 12px">
        Sistem Informasi Layanan Kunjungan Tamu yang memudahkan proses pendaftaran, pengelolaan jadwal, serta pemantauan kunjungan secara transparan dan real-time di Lapas Kelas I Makassar.
      </p>
    </div>


    <style>.menu-circle{width:100px;height:100px;font-size:28px}.menu-label{font-size:14px}@media(max-width:576px){.menu-circle{width:60px;height:60px;font-size:18px}.menu-label{font-size:9px}}.badge-custom{position:absolute;top:4px;right:14px;background-color:#f1556c;color:#fff;padding:2px 6px;font-size:10px;border-radius:10px;font-weight:bold;z-index:10}.emoji-icon{font-size:40px}@media(min-width:576px){.emoji-icon{font-size:60px}}@media(min-width:768px){.emoji-icon{font-size:60px}}</style>

    <div class="d-flex flex-nowrap overflow-auto text-center">
      <div class="flex-shrink-0 px-1" style="width: 25%; position: relative;">
        <a href="<?= site_url("booking") ?>" class="card p-1 d-block text-white text-decoration-none position-relative">
          <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow menu-circle" style="background-color: #17a2b8;">
            <!-- <span class="badge-custom" data-plugin="counterup"><?php echo $jumper ?></span> -->
            <span class="emoji-icon">📇</span>

          </div>
          <small class="d-block mt-1 text-dark font-weight-bold menu-label">Daftar</small>
        </a>
      </div>


      <div class="flex-shrink-0 px-1" style="width: 25%;">
        <a href="<?= site_url("hal/struktur") ?>" class="card p-1 d-block text-white text-decoration-none">
          <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow menu-circle" style="background-color: #dc7633;">
           <span class="emoji-icon">🕵️‍♂</span>
         </div>
         <small class="d-block mt-1 text-dark font-weight-bold menu-label">Struktur</small>
       </a>
     </div>

     <div class="flex-shrink-0 px-1" style="width: 25%;">
      <a href="<?= site_url("hal/alur") ?>" class="card p-1 d-block text-white text-decoration-none">
        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow menu-circle" style="background-color: #007bff;">
         <span class="emoji-icon">🧩</span>

       </div>
       <small class="d-block mt-1 text-dark font-weight-bold menu-label">Tahapan</small>
     </a>
   </div>

   <div class="flex-shrink-0 px-1" style="width: 25%;">
    <a href="<?= site_url("hal/kontak") ?>" class="card p-1 d-block text-white text-decoration-none">
      <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow menu-circle" style="background-color: #25D366;">
       <span class="emoji-icon">💬</span>
     </div>
     <small class="d-block mt-1 text-dark font-weight-bold menu-label">Kontak</small>
   </a>
 </div>
</div>
</div> 
</div>





<div class="card">
  <div class="card-body">
    <h4 class="header-title">Statistik Kunjungan</h4>
    <div class="row text-center">
      <div class="col-4">
        <p class="text-dark mb-1 text-truncate">Hari Ini</p>
        <h4 id="hari_ini" data-plugin="counterup">Memuat...</h4>
      </div>
      <div class="col-4">
        <p class="text-dark mb-1 text-truncate">Minggu ini</p>
        <h4 id="minggu_ini" data-plugin="counterup">Memuat...</h4>
      </div>
      <div class="col-4">
        <p class="text-dark mb-1 text-truncate">Bulan ini</p>
        <h4 id="bulan_ini" data-plugin="counterup">Memuat...</h4>
      </div>
    </div>
    <div class="mt-1 chartjs-chart">
      <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
          <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">

          </div>
        </div>
        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
      </div>
    </div>
    <style type="text/css">
      #line-chart-example {
        max-height: 300px;
        width: 100%;
      }
    </style>
    <canvas id="line-chart-example" class="chartjs-render-monitor" style="display: block; height: 300px; width: 380px;"></canvas>
    <!-- <small><code>Stat ini masih bersifat sample</code></small> -->
  </div>
</div>
</div> 


<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>
<script src="<?php echo base_url('assets/') ?>/js/install.js">"></script>

<?php

$basePath = parse_url(site_url(), PHP_URL_PATH);
if (!$basePath) $basePath = '/'; 
?>

<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register("/service-worker.js", {
      scope: "/"
    }).then(registration => {
      console.log("✅ Service Worker registered.");

      registration.onupdatefound = () => {
        const newWorker = registration.installing;
        console.log("🔄 Update ditemukan.");

        newWorker.onstatechange = () => {
          if (newWorker.state === 'installed') {
            if (navigator.serviceWorker.controller) {
              Swal.fire({
                title: 'Update Tersedia',
                text: 'Versi baru tersedia. Ingin muat ulang aplikasi?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Muat Ulang',
                cancelButtonText: 'Nanti Saja'
              }).then((result) => {
                if (result.isConfirmed) {
                  forceClearCacheAndUnregisterSW().then(() => {
                    location.reload();
                  });
                }
              });
            }
          }
        };
      };
    }).catch(err => {
      console.warn("❌ Gagal daftar Service Worker:", err);
    });
  }
</script>


<div class="card-box ribbon-box d-block d-md-none">
 <div class="ribbon-two ribbon-two-blue"><span>SiLapas</span></div>
 <p class="mb-2" style="margin-left:22px; margin-top: 12px">
  Sistem Informasi Layanan Kunjungan Tamu yang memudahkan proses pendaftaran, pengelolaan jadwal, serta pemantauan kunjungan secara transparan dan real-time di Lapas Kelas I Makassar.
</p>
</div>

<ul class="sortable-list taskList list-unstyled ui-sortable" id="upcoming">

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-primary text-primary mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-bolt font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Daftar Cepat Tanpa Ribet</strong></h4>
      <p>Pemesanan kunjungan bisa dilakukan dari ponsel atau laptop, kapan pun—tanpa harus datang ke lokasi terlebih dahulu.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-success text-success mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-calendar-check font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Pilih Jadwal Sendiri</strong></h4>
      <p>Pengunjung leluasa memilih tanggal dan jam kunjungan yang paling pas. Penjadwalan ulang juga mudah bila ada perubahan.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-info text-info mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-qrcode font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Tiket Digital & QR Praktis</strong></h4>
      <p>Setelah booking, tiket (PDF) dan QR Code langsung tersedia. Cukup tunjukkan dari layar ponsel saat check-in/checkout.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-warning text-warning mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-bell font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Notifikasi & Pengingat Otomatis</strong></h4>
      <p>Pemberitahuan dikirim otomatis (mis. WhatsApp/SMS/email) berisi status booking, jadwal, dan pengingat sebelum waktu kunjungan.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-secondary text-secondary mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-eye font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Status Transparan, Real-time</strong></h4>
      <p>Pengunjung dapat melacak status booking secara langsung—mulai dari diajukan, disetujui, hingga selesai dikunjungi.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-danger text-danger mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-stopwatch font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Antrian Lebih Tertib, Waktu Tunggu Lebih Singkat</strong></h4>
      <p>Dengan jadwal terencana dan QR, proses kedatangan jadi lebih cepat dan terarah—mengurangi waktu menunggu.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-dark text-dark mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-mobile-alt font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Tanpa Instal Aplikasi</strong></h4>
      <p>Cukup gunakan peramban (browser) favorit. Tautan tiket & detail kunjungan bisa dibuka langsung dari pesan yang diterima.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-info text-info mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-universal-access font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Ramah Akses</strong></h4>
      <p>Antarmuka ringan, dapat diakses dari jaringan terbatas, dan mendukung fitur aksesibilitas untuk kebutuhan khusus.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-secondary text-secondary mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-shield-alt font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Data Aman & Terlindungi</strong></h4>
      <p>Informasi pribadi dikelola dengan izin dan standar keamanan yang baik. QR unik mencegah penyalahgunaan.</p>
    </div>
  </li>

  <li class="media mb-2 align-items-start">
    <div class="avatar-sm rounded-circle bg-soft-primary text-primary mr-3 d-flex align-items-center justify-content-center">
      <i class="fas fa-headset font-20"></i>
    </div>
    <div class="media-body">
      <h4 class="mt-0 mb-1"><strong>Bantuan Mudah Dijangkau</strong></h4>
      <p>Tersedia kontak bantuan jika diperlukan—mulai dari pertanyaan booking hingga kendala saat hari kunjungan.</p>
    </div>
  </li>

</ul>

<div class="text-center mt-3 mb-4">
  <p class="lead">Booking kunjungan kini lebih cepat, praktis, dan transparan. Cukup beberapa langkah dari ponsel, semua kebutuhan kunjungan Anda siap dalam satu tempat.</p>
</div>

</div>
</div> 
</div>

<script type="text/javascript">


  function forceClearCacheAndUnregisterSW() {
    return new Promise(resolve => {
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(regs => {
          const unregisterPromises = regs.map(reg => reg.unregister());
          Promise.all(unregisterPromises).then(() => {
            caches.keys().then(keys => {
              const deletePromises = keys.map(key => caches.delete(key));
              Promise.all(deletePromises).then(() => {
                resolve(); 
              });
            });
          });
        });
      } else {
        resolve();
      }
    });
  }


</script>

<?php $this->load->view("front_end/footer.php") ?>
<script src="<?php echo base_url("assets/admin/libs/chart-js/Chart.bundle.min.js") ?>"></script>
<script type="text/javascript">
  !(function (s) {
    "use strict";

    var e = function () {
      this.$body = s("body");
      this.charts = [];
    };

    e.prototype.respChart = function (a, r, t, o) {
      var n = a.get(0).getContext("2d"),
      i = s(a).parent();
      return (function () {
        var e;
        a.attr("width", s(i).width());
        switch (r) {
          case "Line":
          e = new Chart(n, { type: "line", data: t, options: o });
          break;
        }
        return e;
      })();
    };

    e.prototype.initCharts = function () {
      var e = [];

      if (s("#line-chart-example").length > 0) {
        $.ajax({
          url: "<?php echo site_url('home/chart_data') ?>?t=" + new Date().getTime(),
          method: "GET",
          dataType: "json",
          success: function(response) {
            const dataThisWeek = response.weekly;
            const dataLastWeek = response.last_weekly || [0,0,0,0,0,0,0];

            if (!Array.isArray(dataThisWeek) || !Array.isArray(dataLastWeek)) {
              s("#line-chart-example")
              .parent()
              .append('<div class="text-center text-danger mt-3">⚠️ Data chart tidak valid</div>');
              return;
            }

            const isEmptyThisWeek = dataThisWeek.every(v => v === 0);
            const isEmptyLastWeek = dataLastWeek.every(v => v === 0);

            if (isEmptyThisWeek && isEmptyLastWeek) {
              s("#line-chart-example")
              .parent()
              .append('<div class="text-center text-muted mt-3">📉 Tidak ada data minggu ini dan minggu lalu</div>');
              return;
            }

            e.push(
              s.Dashboard3.respChart(
                s("#line-chart-example"),
                "Line",
                {
                  labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
                  datasets: [
                  { label: "Minggu ini",
                  backgroundColor: "rgba(79, 198, 225, 0.3)",
                  borderColor: "#4fc6e1",
                  data: dataThisWeek
                },
                { label: "Minggu Lalu",
                fill: true,
                backgroundColor: "transparent",
                borderColor: "#7e57c2",
                borderDash: [5, 5],
                data: dataLastWeek
              },
              ],
            },
            {
              maintainAspectRatio: false,
              legend: { display: true },
              tooltips: { intersect: false },
              hover: { intersect: true },
              plugins: { filler: { propagate: false } },
              scales: {
                xAxes: [{ reverse: false, gridLines: { color: "rgba(255,255,255,0.06)" } }],
                yAxes: [{ ticks: { stepSize: 5, beginAtZero: true }, gridLines: { color: "rgba(255,255,255,0.06)" } }]
              }
            }
            )
              );

            s("#hari_ini").text(response.today ?? 0);
            s("#minggu_ini").text(response.week ?? 0);
            s("#bulan_ini").text(response.month ?? 0);
          },
          error: function() {
            s("#line-chart-example")
            .parent()
            .append('<div class="text-center text-danger mt-3">⚠️ Gagal memuat data chart</div>');
          }
        });


      }

      return e;
    };

    e.prototype.init = function () {
      var a = this;
      Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
      a.charts = this.initCharts();

      s(window).on("resize", function () {
        s.each(a.charts, function (_, chart) {
          try {
            chart.destroy();
          } catch (e) {}
        });
        a.charts = a.initCharts();
      });
    };

    s.Dashboard3 = new e();
    s.Dashboard3.Constructor = e;

  })(window.jQuery);

  (function () {
    "use strict";
    window.jQuery.Dashboard3.init();
  })();

</script>

