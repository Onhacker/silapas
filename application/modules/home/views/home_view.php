<?php $this->load->view("front_end/head.php") ?>
<link href="<?php echo base_url('assets/min/home.min.css'); ?>" rel="stylesheet" type="text/css" />
<?php
$slides = [
  [
    'src'   => base_url("assets/images/slide/booking.webp"),
    'alt'   => 'Area layanan kunjungan',
    'title' => 'Booking Online',
    'text'  => 'Pesan jadwal kunjungan langsung dari ponsel Anda.',
    'href'  => site_url('booking'),
  ],
  [
    'src'   => base_url("assets/images/slide/unit.webp"),
    'alt'   => 'Siap Menyambut Anda',
    'title' => 'Siap Menyambut Anda',
    'text'  => 'Kenali unit dan pejabat terkait layanan.',
    'href'  => site_url('hal/struktur'),
  ],
  [
    'src'   => base_url("assets/images/slide/laptop.webp"),
    'alt'   => 'Download Aplikasi Di Playstore atau Gunakan Browser',
    'title' => 'Ramah Akses',
    'text'  => 'Download Aplikasi Di Playstore atau Gunakan Browser',
    'href'  => site_url(),
  ],
];
?>


<div class="container-fluid">

  <!-- ===== Pretty Title ===== -->
  <div class="hero-title" role="banner" aria-label="Judul situs">
    <h1 class="text"><?= htmlspecialchars($rec->type ?? '', ENT_QUOTES) ?></h1>
    <span class="accent" aria-hidden="true"></span>
  </div>
  <!-- ===== /Pretty Title ===== -->

  <div class="row">
    <!-- LEFT: HERO -->
    <div class="col-xl-4">
      <section class="pwa-hero" role="region" aria-label="Slideshow sorotan">
        <button class="pwa-hero__nav prev" type="button" aria-label="Sebelumnya">‹</button>
        <button class="pwa-hero__nav next" type="button" aria-label="Berikutnya">›</button>

        <div id="heroTrack" class="pwa-hero__track" tabindex="0" aria-live="polite">
          <?php foreach ($slides as $i => $s): ?>
            <article class="pwa-hero__slide" aria-roledescription="slide" aria-label="<?= ($i+1).' dari '.count($slides) ?>">
              <?php if (!empty($s['href'])): ?><a href="<?= htmlspecialchars($s['href'], ENT_QUOTES) ?>" class="pwa-hero__link"><?php endif; ?>
                <img class="pwa-hero__img"
                     src="<?= htmlspecialchars($s['src'], ENT_QUOTES) ?>"
                     alt="<?= htmlspecialchars($s['alt'], ENT_QUOTES) ?>"
                     loading="<?= $i === 0 ? 'eager' : 'lazy' ?>"
                     decoding="async" />
                <div class="pwa-hero__cap">
                  <h3 class="pwa-hero__title"><?= htmlspecialchars($s['title']) ?></h3>
                  <p class="pwa-hero__text"><?= htmlspecialchars($s['text']) ?></p>
                </div>
              <?php if (!empty($s['href'])): ?></a><?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>

        <div id="heroDots" class="pwa-hero__dots" aria-hidden="false"></div>
      </section>
    </div>

    <!-- RIGHT: RIBBON + QUICK MENU -->
    <div class="col-xl-8 mt-2">
      <div class="card-box ribbon-box d-none d-md-block">
        <div class="ribbon ribbon-blue float-left"><span><?= $rec->nama_website." ".strtoupper($rec->kabupaten) ?></span></div>
        <p class=" ribbon-content" style="margin-left:22px;margin-top:12px">
           <?= $rec->meta_deskripsi ?> yang memudahkan proses pendaftaran, pengelolaan jadwal, serta pemantauan kunjungan secara transparan dan real-time di Lapas Kelas I Makassar.
        </p>
      </div>

      <div class="quickmenu-wrap position-relative">
        <button class="quickmenu-btn left" type="button" aria-label="Geser kiri">&#10094;</button>
        <button class="quickmenu-btn right" type="button" aria-label="Geser kanan">&#10095;</button>
        <div class="quickmenu-fade left"></div>
        <div class="quickmenu-fade right"></div>

        <div id="quickmenu" class="quickmenu-scroll d-flex text-center" tabindex="0" aria-label="Menu cepat geser">
          <div class="quickmenu-item">
            <a href="<?= site_url('booking') ?>" class="qcard d-block text-decoration-none">
              <div class="menu-circle" style="background:#17a2b8;"><span class="emoji-icon">📇</span></div>
              <small class="menu-label">Booking</small>
            </a>
          </div>
          <div class="quickmenu-item">
            <a href="<?= site_url('hal/struktur') ?>" class="qcard d-block text-decoration-none">
              <div class="menu-circle" style="background:#dc7633;"><span class="emoji-icon">🕵️‍♂️</span></div>
              <small class="menu-label">Struktur</small>
            </a>
          </div>
          <div class="quickmenu-item">
            <a href="<?= site_url('hal/alur') ?>" class="qcard d-block text-decoration-none">
              <div class="menu-circle" style="background:#007bff;"><span class="emoji-icon">🧩</span></div>
              <small class="menu-label">Tahapan</small>
            </a>
          </div>
          <div class="quickmenu-item">
            <a href="<?= site_url('hal/kontak') ?>" class="qcard d-block text-decoration-none">
              <div class="menu-circle" style="background:#25D366;"><span class="emoji-icon">💬</span></div>
              <small class="menu-label">Kontak</small>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /row -->

  <!-- RIBBON MOBILE -->
  <div class="card-box ribbon-box d-block d-md-none mt-2">
    <div class="ribbon ribbon-blue float-left"><span><?= $rec->nama_website." ".strtoupper($rec->kabupaten) ?></span></div>
    <p class=" ribbon-content" style="margin-left:12px;margin-top:8px">
       <?= $rec->meta_deskripsi ?>
    </p>
  </div>
 <?php $this->load->view("front_end/banner_jadwal.php"); ?>

    <div class="feature-slider" id="featureSlider">
      <button class="fs-nav prev" type="button" aria-label="Sebelumnya">‹</button>

      <ul class="sortable-list taskList list-unstyled ui-sortable fs-track" id="upcoming" tabindex="0" aria-live="polite">
        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-primary text-primary mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-bolt font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Daftar Cepat Tanpa Ribet</strong></h4>
            <p>Pemesanan kunjungan bisa dilakukan dari ponsel atau laptop, kapan pun—tanpa harus datang ke lokasi terlebih dahulu.</p>
          </div>
        </li>

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-success text-success mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-calendar-check font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Pilih Jadwal Sendiri</strong></h4>
            <p>Pengunjung leluasa memilih tanggal dan jam kunjungan yang paling pas. Penjadwalan ulang juga mudah bila ada perubahan.</p>
          </div>
        </li>

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-info text-info mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-qrcode font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Tiket Digital & QR Praktis</strong></h4>
            <p>Setelah booking, tiket (PDF) dan QR Code langsung tersedia. Cukup tunjukkan dari layar ponsel saat check-in/checkout.</p>
          </div>
        </li>

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-warning text-warning mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-bell font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Notifikasi & Pengingat Otomatis</strong></h4>
            <p>Pemberitahuan dikirim otomatis (mis. WhatsApp/SMS/email) berisi status booking, jadwal, dan pengingat sebelum waktu kunjungan.</p>
          </div>
        </li>

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-secondary text-secondary mr-3 d-flex align-items-center justify-content-center"><i class="fas fa-eye font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Status Transparan, Real-time</strong></h4>
            <p>Pengunjung dapat melacak status booking secara langsung—mulai dari diajukan, disetujui, hingga selesai dikunjungi.</p>
          </div>
        </li>

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-danger text-danger mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-stopwatch font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Antrian Lebih Tertib, Waktu Tunggu Lebih Singkat</strong></h4>
            <p>Dengan jadwal terencana dan QR, proses kedatangan jadi lebih cepat dan terarah—mengurangi waktu menunggu.</p>
          </div>
        </li>

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-dark text-dark mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-mobile-alt font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Instal Aplikasi/ Pakai Browser</strong></h4>
            <p><strong>Unduh aplikasi di Google Play (Android), instal ke iOS sebagai PWA</strong> untuk pengalaman lebih praktis, atau <strong>gunakan browser favorit</strong></p>
          </div>
        </li>

       

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-secondary text-secondary mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-shield-alt font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Data Aman & Terlindungi</strong></h4>
            <p>Informasi pribadi dikelola dengan izin dan standar keamanan yang baik. QR unik mencegah penyalahgunaan.</p>
          </div>
        </li>

        <li class="media mb-2 align-items-center">
          <div class="avatar-sm rounded-circle bg-soft-primary text-primary mr-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-headset font-20"></i>
          </div>
          <div class="media-body">
            <h4 class="mt-0 mb-1"><strong>Bantuan Mudah Dijangkau</strong></h4>
            <p>Tersedia kontak bantuan jika diperlukan—mulai dari pertanyaan booking hingga kendala saat hari kunjungan.</p>
          </div>
        </li>
      </ul>

      <button class="fs-nav next" type="button" aria-label="Berikutnya">›</button>
    </div>
  </section>

  <!-- ===== STATISTIK ===== -->
  <div class="card mt-2">
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
      <div id="visit-line-chart"></div>
    </div>
  </div>

<div class="t-card mb-3" style="--bg:url('<?= base_url('assets/images/slide/laptop.webp') ?>')">
  <blockquote class="t-quote">
    Booking kunjungan kini lebih cepat, praktis, dan transparan. Cukup beberapa langkah dari ponsel, semua kebutuhan kunjungan Anda siap dalam satu tempat.
  </blockquote>
  <div class="t-author"><?php echo $rec->type ?></div>
  <a class="t-btn" href="<?= site_url('booking') ?>">BOOKING</a>
</div>


</div>

<script src="<?= base_url('assets/admin/js/sw.min.js') ?>"></script>
<script src="<?= base_url('assets/min/home.min.js') ?>"></script>
<?php $basePath = parse_url(site_url(), PHP_URL_PATH); if (!$basePath) $basePath = '/'; ?>

<?php $this->load->view("front_end/footer.php") ?>

<script src="<?= base_url('assets/admin/chart/highcharts.js') ?>"></script>
<script src="<?= base_url('assets/admin/chart/exporting.js') ?>"></script>
<script src="<?= base_url('assets/admin/chart/export-data.js') ?>"></script>
<script src="<?= base_url('assets/admin/chart/accessibility.js') ?>"></script>

<script>
/* ===== Chart loader (tetap) ===== */
(function($){
  "use strict";
  const $container = $('#visit-line-chart');

  function renderChart(dataThisWeek, dataLastWeek) {
    Highcharts.chart('visit-line-chart', {
      chart:{type:'spline',height:300,backgroundColor:null},
      title:{text:null},
      xAxis:{categories:['Sen','Sel','Rab','Kam','Jum','Sab','Min'],tickLength:0},
      yAxis:{title:{text:null},allowDecimals:false,min:0,gridLineDashStyle:'ShortDot'},
      legend:{enabled:true},
      tooltip:{shared:true,valueSuffix:' kunjungan'},
      series:[
        {name:'Minggu ini',data:dataThisWeek,color:'#4fc6e1',lineWidth:3,marker:{enabled:false}},
        {name:'Minggu lalu',data:dataLastWeek,color:'#7e57c2',dashStyle:'ShortDash',lineWidth:2,marker:{enabled:false}}
      ],
      credits:{enabled:false},
      // exporting:{enabled:true},
       exporting:{
        enabled:true,
        buttons:{
          contextButton:{
            menuItems:[
              'printChart',
              'downloadPNG','downloadJPEG','downloadPDF','downloadSVG',
              'separator',
              'downloadCSV','downloadXLS'
            ]
          }
        }
      },
      accessibility:{enabled:false}
    });
  }

  function loadData() {
    $.getJSON("<?= site_url('home/chart_data') ?>?t="+Date.now())
      .done(function(resp){
        const a = Array.isArray(resp.weekly) ? resp.weekly : [];
        const b = Array.isArray(resp.last_weekly) ? resp.last_weekly : [0,0,0,0,0,0,0];
        $('#hari_ini').text(resp.today ?? 0);
        $('#minggu_ini').text(resp.week ?? 0);
        $('#bulan_ini').text(resp.month ?? 0);
        const emptyA = a.every(v=>v===0), emptyB = b.every(v=>v===0);
        if (emptyA && emptyB) {
          $container.empty().append('<div class="text-center text-muted mt-3">📉 Tidak ada data minggu ini dan minggu lalu</div>');
          return;
        }
        renderChart(a,b);
      })
      .fail(function(){
        $container.empty().append('<div class="text-center text-danger mt-3">⚠️ Gagal memuat data chart</div>');
      });
  }

  $(loadData);
})(jQuery);
</script>
