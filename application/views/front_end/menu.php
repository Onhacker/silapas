<?php $uri = $this->uri->uri_string(); ?>
<style>
  .active-menu > a {
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
    font-weight: bold;
  }

  .has-submenu a {
    transition: text-shadow 0.3s ease-in-out;
  }

  .has-submenu a:hover {
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
    font-weight: bold;
  }


</style>
<div id="navigation">
  <ul class="navigation-menu">
    <li class="has-submenu <?= ($uri === '' || $uri === 'home') ? 'active-menu' : '' ?>">
      <a href="<?= site_url('home'); ?>"><i class="fe-home"></i> Home</a>
    </li>

    <li class="has-submenu <?= ($uri === 'booking') ? 'active-menu' : '' ?>">
      <a href="<?= site_url('booking'); ?>"><i class="fe-calendar"></i> Booking</a>
    </li>

    <li class="has-submenu <?= ($uri === 'hal/jadwal') ? 'active-menu' : '' ?>">
      <a href="<?= site_url('hal/jadwal'); ?>"><i class="fe-clock"></i> Jadwal</a>
    </li>

    <li class="has-submenu <?= ($uri === 'hal/struktur') ? 'active-menu' : '' ?>">
      <a href="<?= site_url('hal/struktur'); ?>"><i class="fe-users"></i> Struktur Organisasi</a>
    </li>

    <!-- PANDUAN DROPDOWN -->
    <li class="has-submenu <?= ($uri === 'hal/panduan' || $uri === 'hal/alur') ? 'active-menu' : '' ?>">
      <a href="javascript:void(0);"><i class="fe-book-open"></i> Panduan <div class="arrow-down"></div></a>
      <ul class="submenu">
        <li class="<?= ($uri === 'hal/panduan') ? 'active' : '' ?>">
          <a href="<?= site_url('hal/panduan'); ?>"><i class="fe-file-text"></i> Tata Cara</a>
        </li>
        <li class="<?= ($uri === 'hal/alur') ? 'active' : '' ?>">
          <a href="<?= site_url('hal/alur'); ?>"><i class="fe-git-branch"></i> Alur Kunjungan</a>
        </li>
      </ul>
    </li>

    <li class="has-submenu <?= ($uri === 'hal/kontak') ? 'active-menu' : '' ?>">
      <a href="<?= site_url('hal/kontak'); ?>"><i class="fe-phone-call"></i> Kontak</a>
    </li>
  </ul>
  <div class="clearfix"></div>
</div>

