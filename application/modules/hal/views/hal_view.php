<?php $this->load->view("front_end/head.php") ?>
<div class="container-fluid">
   
  <div class="row mt-3">
    <div class="col-lg-12">
      <div class="search-result-box card-box">

        <style>
          .timeline-sm-item{padding-left:40px;position:relative}
          .timeline-sm-item:before{
            content:'';
            position:absolute;left:-20px;top:2px;width:18px;height:18px;border-radius:50%;
            /*background-color:#00008B;border:2px solid #fff;box-shadow:0 0 5px rgba(0,0,0,.15)*/
          }
          .timeline-sm-date{font-weight:bold}
          .timeline-sm-item h4{font-weight:600;color:#333}
          .timeline-sm-item p{font-size:1rem;line-height:1.6;text-align:justify}
          .text-muted{color:#6c757d!important}
          .timeline-sm-item:hover h4{color:#00008B}
          .timeline-sm-item:hover .timeline-sm-date{color:#007bff}
          .gal-box img{border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,.08)}
          .badge-step{display:inline-block;min-width:28px;height:28px;line-height:24px;border-radius:50%;
            text-align:center;border:2px solid #00008B;color:#00008B;font-weight:700;margin-right:.35rem}
        </style>

        <div class="container">
          <link href="<?= base_url('assets/admin/libs/magnific-popup/magnific-popup.css'); ?>" rel="stylesheet" type="text/css" />

          <h3 class="text-center mb-3">
            <i class="mdi mdi-qrcode-scan mr-1"></i> Alur Pembooking(an) Kunjungan Tamu
          </h3>

          <!-- Flowchart (opsional) -->
       

          <ul class="list-unstyled timeline-sm mt-4">
            <!-- Step 1 -->
            <li class="timeline-sm-item">
              <span class="timeline-sm-date"><span class="badge-step">1</span> Tahap 1</span>
              <h4 class="mt-0">Buat Booking</h4>
              <p>
                Pengunjung membuka halaman <a href="<?= site_url('booking') ?>">Form Booking</a>,
                memilih <strong>tanggal & jam</strong> kunjungan, mengisi <strong>data tamu</strong> (nama, NIK, instansi),
                memilih <strong>unit tujuan</strong>, serta menuliskan keperluan.
                Setelah disubmit, sistem akan membuat <strong>kode booking</strong> (angka) dan menampilkan ringkasan permohonan.
              </p>
            </li>

           <!-- Step 2 -->
<li class="timeline-sm-item">
  <span class="timeline-sm-date"><span class="badge-step">2</span> Tahap 2</span>
  <h4 class="mt-0">Verifikasi Admin</h4>
  <p>
    Admin memeriksa data booking. Jika sesuai, status diubah menjadi <strong>Approved</strong>.
    Sistem menyiapkan <strong>QR Code</strong> &amp; <strong>Ticket (PDF)</strong> yang dapat diunduh pengunjung.
    (Opsional) Notifikasi dapat dikirim via WhatsApp/SMS berisi kode booking dan tautan ticket.
  </p>
  <p class="text-dark mb-0">
    <em>
      <strong>Auto-approve:</strong> Jika fitur ini diaktifkan, sistem otomatis menyetujui booking yang memenuhi kriteria
      (mis. jadwal masih tersedia, data valid, dan tidak bentrok) lalu langsung menerbitkan QR &amp; ticket tanpa menunggu
      persetujuan manual admin.
    </em>
  </p>
</li>


            <!-- Step 3 -->
            <li class="timeline-sm-item">
              <span class="timeline-sm-date"><span class="badge-step">3</span> Tahap 3</span>
              <h4 class="mt-0">Persiapan Pengunjung</h4>
              <p>
                Pengunjung menyimpan/ mencetak ticket (PDF) yang berisi <strong>QR Code</strong>.
                Datang sesuai jadwal ke lokasi/ unit tujuan. Siapkan identitas asli
                (KTP/ tanda pengenal instansi) untuk ditunjukkan ke petugas jika diperlukan.
              </p>
            </li>

            <!-- Step 4 -->
            <li class="timeline-sm-item">
              <span class="timeline-sm-date"><span class="badge-step">4</span> Tahap 4</span>
              <h4 class="mt-0">Check-in (Hari H)</h4>
              <p>
                Setibanya di lokasi, pengunjung melakukan <strong>scan QR</strong> pada pos check-in.
                Sistem menandai status menjadi <strong>Checked&nbsp;In</strong> dan mencatat <strong>waktu check-in</strong>.
                Jika belum approved atau jadwal tidak sesuai, petugas dapat melakukan verifikasi manual.
              </p>
            </li>

            <!-- Step 5 -->
            <li class="timeline-sm-item">
              <span class="timeline-sm-date"><span class="badge-step">5</span> Tahap 5</span>
              <h4 class="mt-0">Proses Kunjungan</h4>
              <p>
                Pengunjung dilayani oleh unit tujuan sesuai keperluan.
                Petugas dapat mengambil <strong>dokumentasi</strong> melalui kamera pada halaman detail booking (fitur dokumentasi),
                serta mengisi catatan internal bila diperlukan.
              </p>
            </li>

            <!-- Step 6 -->
            <li class="timeline-sm-item">
              <span class="timeline-sm-date"><span class="badge-step">6</span> Tahap 6</span>
              <h4 class="mt-0">Checkout</h4>
              <p>
                Sebelum meninggalkan lokasi, pengunjung melakukan <strong>scan QR</strong> pada pos checkout.
                Sistem menandai status menjadi <strong>Checked&nbsp;Out</strong>, mencatat <strong>waktu checkout</strong>,
                dan menghitung <strong>durasi kunjungan</strong>.
              </p>
            </li>

            <!-- Step 7 -->
            <li class="timeline-sm-item">
              <span class="timeline-sm-date"><span class="badge-step">7</span> Tahap 7</span>
              <h4 class="mt-0">Selesai & Arsip</h4>
              <p>
                Data kunjungan tersimpan pada sistem.
                Pengunjung dapat menyimpan kembali ticket sebagai bukti kunjungan apabila diperlukan.
              </p>
            </li>
          </ul>

          <div class="alert alert-info mt-3 mb-0">
            <i class="mdi mdi-information-outline mr-1"></i>
            <strong>Tips:</strong> Datang 10 menit lebih awal, pastikan ponsel memiliki koneksi data/stok baterai,
            dan simpan kode booking untuk keperluan verifikasi cepat di tempat.
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php $this->load->view("front_end/footer.php") ?>
<script src="<?= base_url('assets/admin/libs/magnific-popup/jquery.magnific-popup.min.js') ?>"></script>
<script>
  $(function(){
    $(".image-popup").magnificPopup({
      type: "image",
      closeOnContentClick: false,
      closeBtnInside: false,
      mainClass: "mfp-with-zoom mfp-img-mobile",
      image: { verticalFit: true, titleSrc: e => e.el.attr("title") },
      gallery: { enabled: true },
      zoom: { enabled: true, duration: 300, opener: e => e.find("img") }
    });
  });
</script>
