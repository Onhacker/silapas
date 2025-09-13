<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Pastikan path benar: sesuaikan nama file CSS sesuai tema kamu -->
  <base href="<?= base_url() ?>"> <!-- penting agar path relatif di partial tetap hidup -->

  <!-- CSS inti tema -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/icons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/app.min.css') ?>">
  <!-- Jika tema punya varian (mis. app-saas.min.css / app-modern.min.css), pakai yang dipakai layout utama -->
  <!-- <link rel="stylesheet" href="<?= base_url('assets/admin/css/app-saas.min.css') ?>"> -->

  <style>
    /* Sedikit reset supaya rapi di iframe */
    html,body{height:100%}
    body{margin:0; background:#f3f6f9}
    .container-fluid{padding-left:1rem; padding-right:1rem}
  </style>
</head>
<body data-bs-theme="dark">
  <!-- Konten partial disuntik di sini -->
  <?= $content ?>

  <!-- JS inti tema (urutan penting: vendor dulu, baru app) -->
  <script src="<?= base_url('assets/admin/js/vendor.min.js') ?>"></script>
  <script src="<?= base_url('assets/admin/js/app.min.js') ?>"></script>
</body>
</html>
