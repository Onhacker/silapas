<?php $this->load->view("front_end/head.php") ?>
<div class="container-fluid">
  <div class="row mt-3">
    <div class="col-lg-12">
      <div class="search-result-box card-box">
        <div class="text-center py-5">
          <h4 class="mb-2"><?= htmlspecialchars($deskripsi, ENT_QUOTES, 'UTF-8') ?></h4>
          <p class="text-muted">Unduhan sedang dipersiapkan…</p>
          <a href="<?= site_url('booking') ?>" class="btn btn-primary">Kembali ke Form Booking</a>
        </div>

        <!-- Pemicu unduh -->
        <iframe src="<?= htmlspecialchars($dl, ENT_QUOTES, 'UTF-8') ?>" style="display:none"></iframe>

        <!-- Redirect halus ke detail -->
        <script>
          setTimeout(function(){
            location.replace(<?= json_encode($to) ?>);
          }, 900); // 900–1500ms lebih aman utk TWA
        </script>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("front_end/footer.php") ?>
