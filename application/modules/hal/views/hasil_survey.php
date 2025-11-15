<?php $this->load->view("front_end/head.php") ?>

<?php
// Helper kecil untuk format "YYYY-MM" -> "November 2025"
if (!function_exists('bulan_tahun_indo')) {
  function bulan_tahun_indo($bln){
    if (!$bln) return '';
    $parts = explode('-', $bln);
    if (count($parts) < 2) return $bln;

    $tahun = $parts[0];
    $bulan = (int)$parts[1];

    $nama_bulan = [
      '', 'Januari','Februari','Maret','April','Mei','Juni',
      'Juli','Agustus','September','Oktober','November','Desember'
    ];

    return ($nama_bulan[$bulan] ?? $bln).' '.$tahun;
  }
}
?>

<style>
  .skm-wrapper{
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(15,23,42,.08);
    padding: 18px 20px 20px;
    background: linear-gradient(145deg,#f9fafb,#eef2ff);
  }
  .skm-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 10px;
    border-radius:999px;
    font-size:.78rem;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.05em;
    background:#e0f2fe;
    color:#0369a1;
  }
  .skm-badge i{
    font-size:.9rem;
  }
  .skm-title{
    font-size:1.1rem;
    font-weight:700;
    color:#0f172a;
    margin-bottom:2px;
  }
  .skm-desc{
    font-size:.86rem;
    color:#64748b;
    margin-bottom:0;
  }
  .skm-btn-isi{
    white-space:normal;
    text-align:center;
    width:100%;
  }
  .skm-qr-wrap{
    text-align:center;
  }
  .skm-qr-img{
    max-width:190px;
    width:100%;
    height:auto;
    border-radius:10px;
    box-shadow:0 6px 16px rgba(15,23,42,.18);
  }
  .skm-qr-caption{
    font-size:.8rem;
    color:#64748b;
    margin-top:8px;
    margin-bottom:6px;
  }

  @media (min-width: 768px){
    .skm-btn-isi{
      white-space:nowrap;
    }
  }
</style>

<div class="container-fluid">

  <!-- Hero Title -->
  <div class="hero-title" role="banner" aria-label="Judul situs">
    <h1 class="text"><?= html_escape($title) ?></h1>
    <span class="accent" aria-hidden="true"></span>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="search-result-box card-box">

        <div class="skm-wrapper">

          <!-- Header & Tombol Isi Survey + Barcode -->
          <div class="row align-items-center mb-3">
            <!-- Keterangan di kiri -->
            <div class="col-lg-7 mb-3 mb-lg-0">
              <div class="skm-badge">
                <i class="fe-smile"></i> Survey Kepuasan Masyarakat
              </div>
              <p class="skm-title mt-2">Ikuti Survey Kepuasan Masyarakat</p>
              <p class="skm-desc">
                Bantu kami meningkatkan kualitas layanan dengan mengisi survey kepuasan masyarakat.
                Pengisian hanya membutuhkan beberapa menit.
              </p>
            </div>

            <!-- Barcode + tombol di kanan -->
            <div class="col-lg-5">
              <div class="skm-qr-wrap">
                <!-- Barcode / QR -->
                <img src="<?= base_url('assets/images/survey.jpeg'); ?>"
                     alt="Barcode Survey Kepuasan Masyarakat"
                     class="skm-qr-img">

                <div class="skm-qr-caption">
                  Scan barcode di atas untuk mengisi survey,<br>
                  atau klik tombol di bawah.
                </div>

                <!-- Tombol Isi Survey (diperkecil, tanpa btn-lg) -->
                <a href="https://star-survei3a.kemenimipas.go.id/ly/91QpdXUo"
                   target="_blank"
                   rel="noopener"
                   class="btn btn-success btn-rounded skm-btn-isi">
                  <i class="fe-edit-3 mr-1"></i>
                  Isi Survey Kepuasan Masyarakat
                </a>
              </div>
            </div>
          </div>

          <!-- <hr class="my-3"> -->

          <!-- Judul Hasil Survey -->
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2">
            <div>
              <h4 class="mb-1">Hasil Survey Kepuasan Masyarakat</h4>
              <small class="text-muted">
                Pilih bulan dan tahun untuk melihat ringkasan hasil survey.
              </small>
            </div>
          </div>

          <!-- Pilih Bulan & Tahun -->
          <div class="row align-items-end mt-2">
            <div class="col-md-6 col-lg-4">
              <div class="form-group mb-2 mb-md-0">
                <label for="bulan_survey" class="text-blue mb-1">Bulan & Tahun</label>
                <select id="bulan_survey"
                        class="selectpicker form-control"
                        data-style="btn-blue"
                        title="Pilih Bulan & Tahun">
                  <?php if (!empty($survey_list)): ?>
                    <?php foreach ($survey_list as $s): ?>
                      <option value="<?= (int)$s->id ?>"
                              data-url="<?= html_escape($s->link_survey) ?>">
                        <?= html_escape(bulan_tahun_indo($s->bulan)) ?>
                      </option>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <option disabled>Belum ada data survey</option>
                  <?php endif; ?>
                </select>
              </div>
            </div>

            <div class="col-md-4 col-lg-2">
              <div class="form-group mb-2 mb-md-0">
                <label class="d-none d-md-block">&nbsp;</label>
                <button type="button" id="btn-lihat"
                        class="btn btn-blue btn-block">
                  <i class="fe-bar-chart-2"></i> Lihat Hasil
                </button>
              </div>
            </div>
          </div>

        </div> <!-- /.skm-wrapper -->

      </div> <!-- /.card-box -->
    </div>
  </div>
</div>

<!-- JS -->
<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/sw.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>
<script>
  (function($){
    $(function(){

      // init plugin bootstrap-select kalau ada
      if ($.fn.selectpicker) {
        $('.selectpicker').selectpicker();
      }

      // Tombol LIHAT HASIL
      $('#btn-lihat').on('click', function(){
        var $opt = $('#bulan_survey').find('option:selected');
        var url  = $opt.data('url');

        if(!url){
          if (window.Swal) {
            Swal.fire('Info','Silakan pilih bulan & tahun dulu.','info');
          } else {
            alert('Silakan pilih bulan & tahun dulu.');
          }
          return;
        }

        // buka hasil di tab baru
        window.open(url, '_blank');
      });

    });
  })(jQuery);
</script>

<?php $this->load->view("front_end/footer.php") ?>
