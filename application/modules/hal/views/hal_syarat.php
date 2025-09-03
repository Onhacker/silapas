<?php $this->load->view("front_end/head.php") ?>
<div class="container-fluid">

    <style>
    :root{
      --ink:#0f172a; --muted:#475569; --border:#e2e8f0; --bg:#fff; --accent:#0ea5e9;
    }
    html,body{margin:0;padding:0;background:var(--bg);color:var(--ink);font:15px/1.6 system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,"Apple Color Emoji","Segoe UI Emoji";}
    .wrap{max-width:920px;margin:32px auto;padding:0 18px}
    h1{font-size:28px;line-height:1.2;margin:0 0 4px}
    .subtitle{color:var(--muted);margin:0 0 18px;font-weight:600}
    .meta{font-size:13px;color:var(--muted);margin-bottom:22px}
    h2{font-size:18px;margin:26px 0 10px}
    ol{padding-left:18px}
    li+li{margin-top:6px}
    .card{border:1px solid var(--border);border-radius:12px;padding:18px;margin:14px 0;background:#fff}
    .toc a{color:var(--accent);text-decoration:none}
    .toc a:hover{text-decoration:underline}
    code{background:#f1f5f9;padding:.1rem .35rem;border-radius:6px}
    hr{border:0;border-top:1px solid var(--border);margin:24px 0}
    .footer{font-size:13px;color:var(--muted);margin-top:28px}
  </style>
</head>
<body>
  <main class="wrap">
    <header>
      <h1>Syarat &amp; Ketentuan</h1>
      <p class="subtitle"><strong>SILATURAHMI MAKASSAR</strong> — Sistem Layanan Tamu Resmi Antarinstansi yang Humanis, Modern, dan Integratif</p>
      <div class="meta">
        Versi 1.0 • Berlaku per: <strong><!-- TODO: isi tanggal berlaku -->01-10-2025</strong>
      </div>
    </header>

    <section class="card toc" aria-label="Daftar Isi">
      <strong>Daftar Isi</strong>
      <ol>
        <li><a href="#definisi">Definisi</a></li>
        <li><a href="#ruang-lingkup">Ruang Lingkup Layanan</a></li>
        <li><a href="#pendaftaran">Pendaftaran &amp; Akurasi Data</a></li>
        <li><a href="#booking">Booking &amp; Penjadwalan</a></li>
        <li><a href="#checkin">Check-in, Check-out &amp; Kehadiran</a></li>
        <li><a href="#dokumentasi">Dokumentasi &amp; Perangkat</a></li>
        <li><a href="#larangan">Larangan Penggunaan</a></li>
        <li><a href="#privasi">Privasi &amp; Perlindungan Data</a></li>
        <li><a href="#ketersediaan">Ketersediaan &amp; Perubahan Layanan</a></li>
        <li><a href="#tanggung-jawab">Tanggung Jawab &amp; Batasan</a></li>
        <li><a href="#ki">Kekayaan Intelektual</a></li>
        <li><a href="#force-majeure">Force Majeure</a></li>
        <li><a href="#perubahan">Perubahan Syarat &amp; Ketentuan</a></li>
        <li><a href="#hukum">Hukum &amp; Penyelesaian Sengketa</a></li>
        <li><a href="#kontak">Kontak</a></li>
      </ol>
    </section>

    <section id="pendahuluan" class="card">
      <p>Dokumen ini mengatur ketentuan penggunaan aplikasi/laman <strong>Silaturahmi Makassar</strong> (“Aplikasi”). Dengan membuat booking, menggunakan fitur check-in/check-out, atau mengakses Aplikasi, Anda (“Pengguna”) menyatakan telah membaca, memahami, dan menyetujui Syarat &amp; Ketentuan ini.</p>
    </section>

    <section id="definisi" class="card">
      <h2>1) Definisi</h2>
      <ol>
        <li><strong>Pengelola</strong>: tim/instansi resmi yang mengelola Aplikasi Silaturahmi Makassar.</li>
        <li><strong>Pengguna/Tamu</strong>: individu yang membuat booking dan/atau melakukan kunjungan.</li>
        <li><strong>Unit Tujuan</strong>: unit/instansi yang menjadi penerima kunjungan.</li>
        <li><strong>Booking</strong>: permohonan jadwal kunjungan yang dibuat melalui Aplikasi.</li>
        <li><strong>Kode Booking/QR</strong>: identitas unik untuk proses verifikasi kedatangan dan check-in.</li>
      </ol>
    </section>

    <section id="ruang-lingkup" class="card">
      <h2>2) Ruang Lingkup Layanan</h2>
      <p>Aplikasi menyediakan: pembuatan booking kunjungan antarinstansi, notifikasi (WhatsApp/email), verifikasi (QR), check-in/check-out, dokumentasi kunjungan, serta pemantauan durasi kunjungan.</p>
    </section>

    <section id="pendaftaran" class="card">
      <h2>3) Pendaftaran &amp; Akurasi Data</h2>
      <ol>
        <li>Pengguna wajib mengisi data secara benar, lengkap, dan dapat dipertanggungjawabkan.</li>
        <li>Pengelola berhak menolak, menunda, atau membatalkan booking bila ditemukan ketidaksesuaian/indikasi penyalahgunaan.</li>
        <li>Akun atau identitas yang disalahgunakan dapat dibatasi atau dinonaktifkan.</li>
      </ol>
    </section>

    <section id="booking" class="card">
      <h2>4) Booking &amp; Penjadwalan</h2>
      <ol>
        <li>Booking dilakukan melalui Aplikasi sesuai slot dan kapasitas yang tersedia.</li>
        <li>Persetujuan booking berada pada kewenangan Unit Tujuan/Pengelola.</li>
        <li>Perubahan jadwal/pembatalan mengikuti ketersediaan dan kebijakan Unit Tujuan.</li>
        <li>Notifikasi dikirim melalui WhatsApp/email (ketepatan penerimaan bergantung pada penyedia layanan).</li>
      </ol>
    </section>

    <section id="checkin" class="card">
      <h2>5) Check-in, Check-out &amp; Kehadiran</h2>
      <ol>
        <li>Check-in hanya dapat dilakukan <strong>pada tanggal yang tertera</strong> di booking.</li>
        <li><strong>Toleransi keterlambatan</strong>: maksimal <strong>1 (satu) jam setelah jam jadwal</strong>; melebihi itu, check-in dapat ditolak otomatis.</li>
        <li>Kode Booking/QR bersifat <strong>pribadi</strong> dan dilarang disebarluaskan/dipindahtangankan.</li>
        <li>Pengguna wajib menunjukkan identitas yang sah bila diminta petugas.</li>
        <li>Check-out wajib dilakukan saat meninggalkan lokasi untuk pencatatan durasi kunjungan.</li>
      </ol>
    </section>

    <section id="dokumentasi" class="card">
      <h2>6) Dokumentasi &amp; Perangkat</h2>
      <ol>
        <li>Aplikasi dapat menggunakan kamera perangkat untuk <em>scan</em> QR dan foto dokumentasi kedatangan/kunjungan.</li>
        <li>Pengguna memberi persetujuan atas pengambilan dan penyimpanan foto dokumentasi untuk keperluan pencatatan keamanan, kepatuhan, dan audit internal.</li>
        <li>Penggunaan senter/flash dan pilihan kamera (depan/belakang/eksternal) bergantung dukungan perangkat/peramban.</li>
      </ol>
    </section>

    <section id="larangan" class="card">
      <h2>7) Larangan Penggunaan</h2>
      <ol>
        <li>Memberikan data palsu, memalsukan identitas, atau menggunakan QR/kode orang lain.</li>
        <li>Mengganggu keamanan sistem, mencoba mengakses data yang bukan haknya, atau melakukan <em>scraping</em>/<em>hacking</em>.</li>
        <li>Mengunggah konten yang melanggar hukum, SARA, atau hak pihak ketiga.</li>
      </ol>
    </section>

    <section id="privasi" class="card">
      <h2>8) Privasi &amp; Perlindungan Data</h2>
      <ol>
        <li>Data pribadi diproses untuk menjalankan layanan (penjadwalan, verifikasi, notifikasi, dokumentasi, audit).</li>
        <li>Pengelola menerapkan langkah keamanan yang wajar untuk melindungi data.</li>
        <li>Pengelola mematuhi ketentuan perundang-undangan, termasuk <strong>UU PDP No. 27/2022</strong>.</li>
        <li>Hak subjek data (akses, perbaikan, penghapusan sesuai ketentuan) dapat diajukan melalui kontak Pengelola.</li>
      </ol>
    </section>

    <section id="ketersediaan" class="card">
      <h2>9) Ketersediaan &amp; Perubahan Layanan</h2>
      <ol>
        <li>Layanan disediakan “sebagaimana adanya”. Tidak dijamin bebas gangguan 24/7 (pemeliharaan, jaringan, dan sebab di luar kendali).</li>
        <li>Fitur dan alur layanan dapat ditambah/diubah untuk peningkatan kualitas.</li>
      </ol>
    </section>

    <section id="tanggung-jawab" class="card">
      <h2>10) Tanggung Jawab &amp; Batasan</h2>
      <ol>
        <li>Pengelola tidak bertanggung jawab atas keterlambatan/kegagalan notifikasi yang disebabkan pihak ketiga.</li>
        <li>Kerugian akibat pelanggaran Syarat &amp; Ketentuan oleh Pengguna menjadi tanggung jawab Pengguna.</li>
        <li>Sejauh diizinkan hukum, tanggung jawab Pengelola dibatasi pada upaya wajar memperbaiki gangguan layanan.</li>
      </ol>
    </section>

    <section id="ki" class="card">
      <h2>11) Kekayaan Intelektual</h2>
      <p>Seluruh logo, nama layanan, tampilan antarmuka, dan kode pada Aplikasi dilindungi hukum. Pengguna tidak diperkenankan menyalin, memodifikasi, atau mendistribusikan tanpa izin tertulis Pengelola.</p>
    </section>

    <section id="force-majeure" class="card">
      <h2>12) Force Majeure</h2>
      <p>Pengelola dibebaskan dari tuntutan akibat kejadian di luar kendali (bencana, gangguan listrik/jaringan, kebijakan pemerintah, dan sejenisnya) yang menyebabkan layanan terganggu.</p>
    </section>

    <section id="perubahan" class="card">
      <h2>13) Perubahan Syarat &amp; Ketentuan</h2>
      <p>Pengelola dapat memperbarui dokumen ini sewaktu-waktu. Versi terbaru akan ditampilkan pada Aplikasi. Penggunaan berkelanjutan setelah perubahan dianggap sebagai persetujuan Pengguna.</p>
    </section>

    <section id="hukum" class="card">
      <h2>14) Hukum &amp; Penyelesaian Sengketa</h2>
      <p>Syarat &amp; Ketentuan ini tunduk pada hukum Republik Indonesia. Sengketa diselesaikan terlebih dahulu melalui musyawarah. Jika tidak tercapai, diselesaikan sesuai mekanisme yang berlaku di wilayah <strong>Kota Makassar</strong>.</p>
    </section>

    <section id="kontak" class="card">
      <h2>15) Kontak</h2>
      <p>Untuk pertanyaan, permintaan terkait data pribadi, atau pengaduan layanan, hubungi:</p>
      <ul>
        <li><strong><!-- TODO: Nama Pengelola/Unit -->Dinas/Unit Pengelola</strong></li>
        <li>Email: <a href="mailto:admin@silaturahmi.org">kontak@silaturahmi.org</a></li>
        <li>Telepon: <!-- TODO: nomor telepon --> (0411) 000-000</li>
        <li>Alamat: <!-- TODO: alamat kantor -->Lapas Kelas I Makassar, Jl. Sultan Alauddin, Kota Makassar</li>
      </ul>
    </section>

    <hr>
    <p><strong>Dengan menekan tombol “Buat Booking”, “Check-in”, atau menggunakan fitur lain pada Aplikasi, Anda menyetujui Syarat &amp; Ketentuan ini.</strong></p>
  </main>
</div>

<?php $this->load->view("front_end/footer.php") ?>
