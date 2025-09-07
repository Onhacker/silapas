<?php $this->load->view("front_end/head.php") ?>
<div class="container-fluid">

 
    <div class="row justify-content-center py-3">
      <div class="col-12">
        <div class="card-box">

          <!-- Header -->
          <header class="mb-3 text-center">
            <h1 class="h2 mb-2">📜 Syarat &amp; Ketentuan  <?php echo $rec->nama_website." ".$rec->kabupaten ?></h1>
            <p class="text-muted fw-semibold mb-2">
              <?php echo $rec->nama_website." ".$rec->kabupaten." (".$rec->meta_deskripsi.")" ?>
            </p>
            <div class="d-flex justify-content-center gap-2">
              <span class="badge bg-light text-dark border">Versi 1.0</span>
              <span class="badge bg-light text-dark border">Terakhir diperbarui: 29 Agustus 2025</span>
            </div>
          </header>

          <!-- Daftar Isi -->
          <section class="card mb-3">
            <div class="card-body">
              <h2 class="h6 mb-2">Daftar Isi</h2>
              <ol class="mb-0">
                <li><a href="#pendahuluan">Pendahuluan</a></li>
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
            </div>
          </section>

          <!-- Callout persetujuan -->
          <div class="alert alert-info mb-3" role="alert">
            Dengan membuat booking, menggunakan fitur check-in/check-out, atau mengakses Aplikasi, Anda menyatakan telah membaca, memahami, dan menyetujui Syarat &amp; Ketentuan ini.
          </div>

          <!-- 1) Pendahuluan -->
          <section id="pendahuluan" class="card mb-3">
            <div class="card-body">
              <p class="mb-0">
                Dokumen ini mengatur ketentuan penggunaan aplikasi/laman <strong>SILATURAHMI Makassar</strong> (“Aplikasi”).
              </p>
            </div>
          </section>

          <!-- 2) Definisi -->
          <section id="definisi" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">1) Definisi</h2>
              <ol class="mb-0">
                <li><strong>Pengelola</strong>: tim/instansi resmi yang mengelola Aplikasi SILATURAHMI Makassar.</li>
                <li><strong>Pengguna/Tamu</strong>: individu yang membuat booking dan/atau melakukan kunjungan.</li>
                <li><strong>Unit Tujuan</strong>: unit/instansi yang menjadi penerima kunjungan.</li>
                <li><strong>Booking</strong>: permohonan jadwal kunjungan yang dibuat melalui Aplikasi.</li>
                <li><strong>Kode Booking/QR</strong>: identitas unik untuk verifikasi kedatangan dan check-in.</li>
              </ol>
            </div>
          </section>

          <!-- 3) Ruang Lingkup -->
          <section id="ruang-lingkup" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">2) Ruang Lingkup Layanan</h2>
              <p class="mb-0">
                Aplikasi menyediakan: pembuatan booking kunjungan antarinstansi, notifikasi (WhatsApp/email),
                verifikasi (QR), check-in/check-out, dokumentasi kunjungan, serta pemantauan durasi kunjungan.
              </p>
            </div>
          </section>

          <!-- 4) Pendaftaran -->
          <section id="pendaftaran" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">3) Pendaftaran &amp; Akurasi Data</h2>
              <ol class="mb-0">
                <li>Pengguna wajib mengisi data secara benar, lengkap, dan dapat dipertanggungjawabkan.</li>
                <li>Pengelola berhak menolak/menunda/membatalkan booking bila ditemukan ketidaksesuaian atau indikasi penyalahgunaan.</li>
                <li>Akun atau identitas yang disalahgunakan dapat dibatasi atau dinonaktifkan.</li>
              </ol>
            </div>
          </section>

          <!-- 5) Booking -->
          <section id="booking" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">4) Booking &amp; Penjadwalan</h2>
              <ol class="mb-0">
                <li>Booking dilakukan sesuai slot dan kapasitas yang tersedia pada Aplikasi.</li>
                <li>Persetujuan booking berada pada kewenangan Unit Tujuan/Pengelola.</li>
                <li>Perubahan jadwal/pembatalan mengikuti ketersediaan dan kebijakan Unit Tujuan.</li>
                <li>Notifikasi dikirim via WhatsApp/email (ketepatan penerimaan bergantung pada penyedia layanan).</li>
              </ol>
            </div>
          </section>

          <!-- 6) Check-in -->
          <section id="checkin" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">5) Check-in, Check-out &amp; Kehadiran</h2>
              <ol class="mb-0">
                <li>Check-in hanya dapat dilakukan <strong>pada tanggal yang tertera</strong> di booking.</li>
                <li><strong>Toleransi keterlambatan</strong>: maksimal <strong>1 (satu) jam</strong> setelah jam jadwal; melebihi itu, check-in dapat ditolak otomatis.</li>
                <li>Kode Booking/QR bersifat <strong>pribadi</strong> dan dilarang disebarluaskan/dipindahtangankan.</li>
                <li>Pengguna wajib menunjukkan identitas yang sah bila diminta petugas.</li>
                <li>Check-out wajib dilakukan saat meninggalkan lokasi untuk pencatatan durasi kunjungan.</li>
              </ol>
            </div>
          </section>

          <!-- 7) Dokumentasi -->
          <section id="dokumentasi" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">6) Dokumentasi &amp; Perangkat</h2>
              <ol class="mb-0">
                <li>Aplikasi dapat menggunakan kamera perangkat untuk <em>scan</em> QR dan foto dokumentasi kedatangan/kunjungan.</li>
                <li>Pengguna memberi persetujuan atas pengambilan dan penyimpanan foto dokumentasi untuk keperluan keamanan, kepatuhan, dan audit internal.</li>
                <li>Dukungan senter/flash dan pilihan kamera (depan/belakang/eksternal) bergantung pada perangkat/peramban.</li>
              </ol>
            </div>
          </section>

          <!-- 8) Larangan -->
          <section id="larangan" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">7) Larangan Penggunaan</h2>
              <ol class="mb-0">
                <li>Memberikan data palsu, memalsukan identitas, atau menggunakan QR/kode orang lain.</li>
                <li>Mengganggu keamanan sistem, mencoba mengakses data yang bukan haknya, atau melakukan <em>scraping</em>/<em>hacking</em>.</li>
                <li>Mengunggah konten yang melanggar hukum, SARA, atau hak pihak ketiga.</li>
              </ol>
            </div>
          </section>

          <!-- 9) Privasi -->
          <section id="privasi" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">8) Privasi &amp; Perlindungan Data</h2>
              <p class="mb-2">
                Pemrosesan data pribadi diatur dalam <a href="<?php echo site_url('hal/privacy_policy') ?>">Kebijakan Privasi</a>.
                Pengelola mematuhi ketentuan perundang-undangan, termasuk <strong>UU PDP No. 27/2022</strong>.
              </p>
              <ul class="mb-0">
                <li>Data diproses untuk penjadwalan, verifikasi, notifikasi, dokumentasi, dan audit layanan.</li>
                <li>Langkah keamanan wajar diterapkan untuk melindungi data.</li>
                <li>Hak subjek data (akses, perbaikan, penghapusan sesuai ketentuan) dapat diajukan melalui kontak Pengelola.</li>
              </ul>
            </div>
          </section>

          <!-- 10) Ketersediaan -->
          <section id="ketersediaan" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">9) Ketersediaan &amp; Perubahan Layanan</h2>
              <ol class="mb-0">
                <li>Layanan disediakan “sebagaimana adanya”. Tidak dijamin bebas gangguan 24/7 (pemeliharaan, jaringan, dan sebab di luar kendali).</li>
                <li>Fitur dan alur layanan dapat ditambah/diubah untuk peningkatan kualitas.</li>
              </ol>
            </div>
          </section>

          <!-- 11) Tanggung Jawab -->
          <section id="tanggung-jawab" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">10) Tanggung Jawab &amp; Batasan</h2>
              <ol class="mb-0">
                <li>Pengelola tidak bertanggung jawab atas keterlambatan/kegagalan notifikasi yang disebabkan pihak ketiga.</li>
                <li>Kerugian akibat pelanggaran Syarat &amp; Ketentuan oleh Pengguna menjadi tanggung jawab Pengguna.</li>
                <li>Sejauh diizinkan hukum, tanggung jawab Pengelola dibatasi pada upaya wajar memperbaiki gangguan layanan.</li>
              </ol>
            </div>
          </section>

          <!-- 12) KI -->
          <section id="ki" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">11) Kekayaan Intelektual</h2>
              <p class="mb-0">
                Seluruh logo, nama layanan, tampilan antarmuka, dan kode pada Aplikasi dilindungi hukum.
                Pengguna tidak diperkenankan menyalin, memodifikasi, atau mendistribusikan tanpa izin tertulis Pengelola.
              </p>
            </div>
          </section>

          <!-- 13) Force Majeure -->
          <section id="force-majeure" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">12) Force Majeure</h2>
              <p class="mb-0">
                Pengelola dibebaskan dari tuntutan akibat kejadian di luar kendali (bencana, gangguan listrik/jaringan,
                kebijakan pemerintah, dan sejenisnya) yang menyebabkan layanan terganggu.
              </p>
            </div>
          </section>

          <!-- 14) Perubahan S&K -->
          <section id="perubahan" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">13) Perubahan Syarat &amp; Ketentuan</h2>
              <p class="mb-0">
                Pengelola dapat memperbarui dokumen ini sewaktu-waktu. Versi terbaru akan ditampilkan pada Aplikasi.
                Penggunaan berkelanjutan setelah perubahan dianggap sebagai persetujuan Pengguna.
              </p>
            </div>
          </section>

          <!-- 15) Hukum -->
          <section id="hukum" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">14) Hukum &amp; Penyelesaian Sengketa</h2>
              <p class="mb-0">
                Syarat &amp; Ketentuan ini tunduk pada hukum Republik Indonesia. Sengketa diselesaikan terlebih dahulu melalui musyawarah.
                Jika tidak tercapai, diselesaikan sesuai mekanisme yang berlaku di wilayah <strong>Kota Makassar</strong>.
              </p>
            </div>
          </section>

          <!-- 16) Kontak -->
          <section id="kontak" class="card mb-3">
            <div class="card-body">
              <h2 class="h5 mb-2">15) Kontak</h2>
              <p class="mb-2">Untuk pertanyaan atau permintaan terkait ketentuan ini, hubungi:</p>
              <address class="mb-0">
                <strong>Dinas/Unit Pengelola</strong><br>
                Email: <a href="mailto:kontak@silaturahmi.org">kontak@silaturahmi.org</a><br>
                Telepon: (0411) 000-000<br>
                Alamat: Lapas Kelas I Makassar, Jl. Sultan Alauddin, Kota Makassar
              </address>
            </div>
          </section>

          <div class="alert alert-secondary my-4" role="alert">
            <strong>Catatan:</strong> Dengan menekan tombol “Buat Booking”, “Check-in”, atau menggunakan fitur lain pada Aplikasi,
            Anda menyetujui Syarat &amp; Ketentuan ini.
          </div>

        

        </div>
      </div>
    </div>


</div>
<?php $this->load->view("front_end/footer.php") ?>
