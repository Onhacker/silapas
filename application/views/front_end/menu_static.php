
<?php $uri = $this->uri->uri_string(); ?>
<ul class="navigation-menu">
    <li class="has-submenu <?= ($uri == 'booking') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('booking'); ?>"><i class="fe-file-text"></i> Booking</a>
    </li>
    <li class="has-submenu <?= ($uri == 'hal/struktur') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('hal/struktur'); ?>"><i class=" fas fa-building fa-lg"></i> Struktur Organisasi</a>
    </li>
 <!--    <li class="has-submenu <?= ($uri == 'tracking') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('tracking'); ?>"><i class="fas fa-route fa-lg"></i> Tracking</a>
    </li> -->
    <li class="has-submenu <?= ($uri == 'hal/alur') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('hal/alur'); ?>"><i class="fe-layers"></i> Alur Kunjungan</a>
    </li>
    <li class="has-submenu <?= ($uri == 'hal/kontak') ? 'active-menu' : '' ?>">
        <a href="<?= site_url('hal/kontak'); ?>"><i class="fe-layers"></i> Kontak</a>
    </li>
   
</ul>
