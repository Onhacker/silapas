<?php $this->load->view("front_end/head.php") ?>

<?php
$slides = [
  [
    'src'   => base_url("assets/images/slide/booking.png"),
    'alt'   => 'Area layanan kunjungan',
    'title' => 'Booking Online',
    'text'  => 'Pesan jadwal kunjungan langsung dari ponsel Anda.',
    'href'  => site_url('booking'),
  ],
  [
    'src'   => base_url("assets/images/slide/unit.png"),
    'alt'   => 'Siap Menyambut Anda',
    'title' => 'Siap Menyambut Anda',
    'text'  => 'Kenali unit dan pejabat terkait layanan.',
    'href'  => site_url('hal/struktur'),
  ],
  [
    'src'   => base_url("assets/images/slide/laptop.png"),
    'alt'   => 'Download Aplikasi Di Playstore atau Gunakan Browser',
    'title' => 'Ramah Akses',
    'text'  => 'Download Aplikasi Di Playstore atau Gunakan Browser',
    'href'  => site_url(),
  ],
];
?>

<style>
/* ===== HERO SLIDESHOW ===== */
.pwa-hero{position:relative;border-radius:16px;overflow:hidden;box-shadow:0 14px 34px rgba(0,0,0,.12);background:#000;margin:8px 0 14px}
.pwa-hero__track{display:flex;overflow-x:auto;overflow-y:hidden;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;scrollbar-width:none}
.pwa-hero__track::-webkit-scrollbar{display:none}
.pwa-hero__slide{flex:0 0 100%;position:relative;scroll-snap-align:center;height:clamp(200px,32vw,420px);background:#111}
.pwa-hero__link{display:block;height:100%;color:inherit;text-decoration:none}
.pwa-hero__img{width:100%;height:100%;object-fit:cover;display:block;filter:saturate(1.05) contrast(1.02)}
.pwa-hero__cap{position:absolute;inset:auto 0 0 0;padding:18px 18px 16px;color:#fff;background:linear-gradient(180deg,rgba(0,0,0,0) 0%,rgba(0,0,0,.55) 48%,rgba(0,0,0,.75) 100%)}
.pwa-hero__title{margin:0 0 4px;font-weight:800;color:#fff;font-size:clamp(16px,1.8vw,22px);letter-spacing:.2px}
.pwa-hero__text{margin:0;font-size:clamp(13px,1.4vw,16px);opacity:.95}
.pwa-hero__nav{position:absolute;top:50%;transform:translateY(-50%);width:42px;height:42px;border-radius:50%;border:0;cursor:pointer;background:rgba(255,255,255,.95);color:#111;font-size:22px;line-height:1;display:flex;align-items:center;justify-content:center;z-index:3;box-shadow:0 10px 28px rgba(0,0,0,.18)}
.pwa-hero__nav.prev{left:10px}.pwa-hero__nav.next{right:10px}
.pwa-hero__nav[disabled]{opacity:.35;cursor:default}
.pwa-hero__dots{position:absolute;left:0;right:0;bottom:8px;display:flex;gap:8px;justify-content:center;z-index:2}
.pwa-hero__dots button{width:8px;height:8px;border-radius:50%;border:0;background:rgba(255,255,255,.45);padding:0;cursor:pointer}
.pwa-hero__dots button[aria-current="true"]{background:#fff;transform:scale(1.15)}
@media (prefers-reduced-motion:reduce){.pwa-hero__track{scroll-behavior:auto}}

/* ===== QUICK MENU SLIDER ===== */
.menu-circle{width:100px;height:100px;font-size:28px}
.menu-label{font-size:14px}
@media(max-width:576px){.menu-circle{width:60px;height:60px;font-size:18px}.menu-label{font-size:9px}}
.emoji-icon{font-size:40px}
@media(min-width:576px){.emoji-icon{font-size:60px}}
@media(min-width:768px){.emoji-icon{font-size:60px}}

.quickmenu-wrap{margin:8px 0 6px;--btn:48px}
.quickmenu-scroll{gap:12px;padding:6px 8px 10px;overflow-x:auto;overflow-y:hidden;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;scrollbar-width:none}
.quickmenu-scroll::-webkit-scrollbar{display:none}
.quickmenu-item{flex:0 0 auto;width:clamp(120px,25vw,180px);scroll-snap-align:start}
.qcard{padding:10px 8px;border-radius:14px;background:#fff;box-shadow:0 6px 18px rgba(0,0,0,.06);border:1px solid #eef2f7;transition:transform .15s ease,box-shadow .2s ease;color:#111}
.qcard:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(0,0,0,.08)}
.menu-circle{width:72px;height:72px;border-radius:50%;margin:0 auto;display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 8px 18px rgba(0,0,0,.12)}
.emoji-icon{font-size:30px;line-height:1}
.menu-label{display:block;margin-top:8px;font-weight:700;color:#1f2937;letter-spacing:.2px}
.quickmenu-btn{position:absolute;top:50%;transform:translateY(-50%);width:var(--btn);height:var(--btn);border-radius:50%;border:none;background:rgba(255,255,255,.9);box-shadow:0 6px 18px rgba(0,0,0,.12);cursor:pointer;z-index:3;font-size:20px;line-height:1;display:flex;align-items:center;justify-content:center;transition:opacity .2s ease,transform .2s ease}
.quickmenu-btn.left{left:4px}.quickmenu-btn.right{right:4px}
.quickmenu-btn[disabled]{opacity:.35;cursor:default}
.quickmenu-fade{pointer-events:none;position:absolute;top:0;bottom:0;width:32px;z-index:2}
.quickmenu-fade.left{left:0;background:linear-gradient(90deg,#fff,rgba(255,255,255,0))}
.quickmenu-fade.right{right:0;background:linear-gradient(270deg,#fff,rgba(255,255,255,0))}
@media(max-width:480px){.quickmenu-wrap{--btn:42px}.menu-circle{width:66px;height:66px}}
/* ===== CHART ===== */
#visit-line-chart{min-height:300px;width:100%}
</style>

<div class="container-fluid">

  <div class="row mt-2">
    <!-- LEFT: HERO -->
    <div class="col-xl-4">
      <section class="pwa-hero" role="region" aria-label="Slideshow sorotan">
        <button class="pwa-hero__nav prev" type="button" aria-label="Sebelumnya">‹</button>
        <button class="pwa-hero__nav next" type="button" aria-label="Berikutnya">›</button>

        <div id="heroTrack" class="pwa-hero__track" tabindex="0" aria-live="polite">
          <?php foreach ($slides as $i => $s): ?>
            <article class="pwa-hero__slide" aria-roledescription="slide" aria-label="<?= ($i+1).' dari '.count($slides) ?>">
              <?php if (!empty($s['href'])): ?><a href="<?= htmlspecialchars($s['href'], ENT_QUOTES) ?>" class="pwa-hero__link"><?php endif; ?>
                <img
                  class="pwa-hero__img"
                  src="<?= htmlspecialchars($s['src'], ENT_QUOTES) ?>"
                  alt="<?= htmlspecialchars($s['alt'], ENT_QUOTES) ?>"
                  loading="<?= $i === 0 ? 'eager' : 'lazy' ?>"
                  decoding="async"
                />
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
    <div class="col-xl-8">
      <div class="card-box ribbon-box d-none d-md-block">
        <div class="ribbon-two ribbon-two-blue"><span>SILATURAHMI</span></div>
        <p class="mb-2" style="margin-left:22px;margin-top:12px">
          Sistem Layanan Tamu Resmi Antar Instansi yang Humanis, Modern, dan Integratif yang memudahkan proses pendaftaran, pengelolaan jadwal, serta pemantauan kunjungan secara transparan dan real-time di Lapas Kelas I Makassar.
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

  <!-- STATISTIK -->
  <div class="card mt-3">
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

  <!-- RIBBON MOBILE -->
  <div class="card-box ribbon-box d-block d-md-none mt-3">
    <div class="ribbon-two ribbon-two-blue"><span>SILATURAHMI</span></div>
    <p class="mb-2" style="margin-left:22px;margin-top:12px">
      Sistem Layanan Tamu Resmi Antar Instansi yang Humanis, Modern, dan Integratif yang memudahkan proses pendaftaran, pengelolaan jadwal, serta pemantauan kunjungan secara transparan dan real-time di Lapas Kelas I Makassar.
    </p>
  </div>

  <!-- KEUNGGULAN -->
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
        <h4 class="mt-0 mb-1"><strong>Instal Aplikasi atau Pakai Browser</strong></h4>
        <p>Pilih yang paling nyaman: <strong>instal aplikasi dari Google Play Store</strong> untuk pengalaman lebih praktis, atau <strong>gunakan peramban (browser) favorit</strong>—tautan tiket dan detail kunjungan tetap bisa dibuka langsung dari pesan yang Anda terima.</p>
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

</div><!-- /container -->

<script src="<?= base_url('assets/admin/js/sw.min.js') ?>"></script>
<?php $basePath = parse_url(site_url(), PHP_URL_PATH); if (!$basePath) $basePath = '/'; ?>

<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register("/service-worker.js", { scope: "/" })
    .then(registration => {
      console.log("✅ Service Worker registered.");
      registration.onupdatefound = () => {
        const newWorker = registration.installing;
        console.log("🔄 Update ditemukan.");
        newWorker.onstatechange = () => {
          if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
            Swal.fire({
              title: 'Update Tersedia',
              text: 'Versi baru tersedia. Ingin muat ulang aplikasi?',
              icon: 'info',
              showCancelButton: true,
              confirmButtonText: 'Muat Ulang',
              cancelButtonText: 'Nanti Saja'
            }).then((result) => {
              if (result.isConfirmed) {
                forceClearCacheAndUnregisterSW().then(() => location.reload());
              }
            });
          }
        };
      };
    })
    .catch(err => console.warn("❌ Gagal daftar Service Worker:", err));
}
</script>

<script>
function forceClearCacheAndUnregisterSW() {
  return new Promise(resolve => {
    if (!('serviceWorker' in navigator)) return resolve();
    navigator.serviceWorker.getRegistrations().then(regs => {
      const unregs = regs.map(reg => reg.unregister());
      Promise.all(unregs).then(() => {
        caches.keys().then(keys => {
          const dels = keys.map(key => caches.delete(key));
          Promise.all(dels).then(() => resolve());
        });
      });
    });
  });
}
</script>

<?php $this->load->view("front_end/footer.php") ?>

<script src="<?= base_url('assets/admin/chart/highcharts.js') ?>"></script>
<script src="<?= base_url('assets/admin/chart/exporting.js') ?>"></script>
<script src="<?= base_url('assets/admin/chart/export-data.js') ?>"></script>
<script src="<?= base_url('assets/admin/chart/accessibility.js') ?>"></script>

<script>
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
      exporting:{enabled:false},
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

<script>
(function(){
  const track = document.getElementById('heroTrack');
  if(!track) return;
  const slides = Array.from(track.querySelectorAll('.pwa-hero__slide'));
  const btnPrev = document.querySelector('.pwa-hero__nav.prev');
  const btnNext = document.querySelector('.pwa-hero__nav.next');
  const dotsWrap = document.getElementById('heroDots');
  const N = slides.length;
  let i = 0, autoplay = null, userPaused = false, ticking = false;

  const dots = slides.map((_,idx)=>{
    const b = document.createElement('button');
    b.type = 'button';
    b.setAttribute('aria-label', `Ke slide ${idx+1}`);
    b.addEventListener('click', ()=>goTo(idx, true));
    dotsWrap.appendChild(b);
    return b;
  });

  function clamp(x){ return (x+N)%N; }
  function updateUI(idx){
    const atStart = idx===0, atEnd = idx===N-1;
    btnPrev.disabled = atStart; btnNext.disabled = atEnd;
    dots.forEach((d,k)=> d.setAttribute('aria-current', k===idx ? 'true':'false'));
  }

  function goTo(idx, fromUser=false){
    i = clamp(idx);
    const target = slides[i];
    track.scrollTo({left:target.offsetLeft, behavior:'smooth'});
    updateUI(i);
    if(fromUser) pauseAuto(6000);
    const next = slides[clamp(i+1)].querySelector('img');
    if(next && next.loading==='lazy'){ next.loading='eager'; }
  }

  function onScroll(){
    if(ticking) return; ticking = true;
    requestAnimationFrame(()=>{
      const sl = track.scrollLeft;
      let best = 0, dist = Infinity;
      for(let k=0;k<N;k++){
        const d = Math.abs(slides[k].offsetLeft - sl);
        if(d < dist){ dist=d; best=k; }
      }
      if(best !== i){ i = best; updateUI(i); }
      ticking = false;
    });
  }

  function startAuto(){ if(!autoplay && !userPaused) autoplay = setInterval(()=>goTo(i+1,false), 5000); }
  function stopAuto(){ if(autoplay){ clearInterval(autoplay); autoplay=null; } }
  let resumeTimer = null;
  function pauseAuto(ms=4000){
    stopAuto();
    if(resumeTimer) clearTimeout(resumeTimer);
    if(!userPaused) resumeTimer = setTimeout(()=> startAuto(), ms);
  }

  btnPrev.addEventListener('click', ()=>goTo(i-1,true));
  btnNext.addEventListener('click', ()=>goTo(i+1,true));
  track.addEventListener('scroll', onScroll, {passive:true});
  track.addEventListener('pointerenter', ()=> pauseAuto(1e6));
  track.addEventListener('pointerleave', ()=> { userPaused=false; startAuto(); });
  track.addEventListener('focusin', ()=> pauseAuto(1e6));
  track.addEventListener('focusout', ()=> { userPaused=false; startAuto(); });
  track.addEventListener('keydown', (e)=>{
    if(e.key==='ArrowRight'){ e.preventDefault(); goTo(i+1,true); }
    if(e.key==='ArrowLeft'){ e.preventDefault(); goTo(i-1,true); }
  });
  document.addEventListener('visibilitychange', ()=> document.hidden ? stopAuto() : startAuto());
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(entries=>{
      entries.forEach(en=>{ if(en.target===track){ en.isIntersecting ? startAuto() : stopAuto(); }});
    }, {threshold:.2});
    io.observe(track);
  }

  updateUI(0);
  const eager2 = slides[1]?.querySelector('img'); if(eager2) eager2.loading='eager';
  startAuto();
})();
</script>
