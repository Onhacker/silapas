<?php $this->load->view("front_end/head.php") ?>

<div class="container-fluid">
  <div class="hero-title" role="banner" aria-label="Judul situs">
    <h1 class="text"><?= $title ?></h1>
            <div class="text-muted"><?php echo $rec->type ?></div>

    <span class="accent" aria-hidden="true"></span>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow-sm border-0">
        <div class="card-body">
         <!--  <div class="text-center mb-4">
            <h3 class="mb-1 fw-bold">🏢 <?= $title ?></h3>
            <div class="text-muted">Lapas Kelas I Makassar</div>
          </div> -->

          <style>
            ul.tree, ul.tree ul {
              list-style: none;
              margin: 0;
              padding: 0;
            }
            ul.tree ul {
              margin-left: 25px;
              border-left: 2px dashed #ccc;
              padding-left: 18px;
            }
            ul.tree li {
              margin: 6px 0;
              padding: 6px 8px;
              position: relative;
              font-size: 15px;
              transition: all 0.3s ease;
            }
            ul.tree li strong {
              color: black;
              font-weight: 600;
            }
            ul.tree li:hover {
              background: #f8f9fa;
              border-radius: 6px;
            }
            .pejabat {
              font-size: 14px;
              color: #6c757d;
              margin-left: 6px;
            }
            .icon {
              margin-right: 8px;
            }
          </style>
           <link href="<?= base_url('assets/admin/libs/magnific-popup/magnific-popup.css'); ?>" rel="stylesheet" type="text/css" />
            <div class="gal-box">
            <a href="<?php echo base_url("assets/images/struktur_organisasi.webp") ?>" class="image-popup" title="Struktur Organisasi">
              <img src="<?php echo base_url("assets/images/struktur_organisasi.webp") ?>" class="img-fluid" alt="work-thumbnail">
            </a>
            <div class="gall-info">
              <h4 class="font-16 mt-0">Struktur Organisasi</h4>
            </div> 
          </div>
          <?php 
          function get_icon($nama_unit) {
              $nama = strtolower($nama_unit);
              if (strpos($nama, 'kepala lapas') !== false) return '<i class="fas fa-crown text-warning icon"></i>';
              if (strpos($nama, 'kabag') !== false || strpos($nama, 'kabid') !== false || strpos($nama, 'ka. kplp') !== false) return '<i class="fas fa-building text-primary icon"></i>';
              if (strpos($nama, 'kasubag') !== false || strpos($nama, 'kasi') !== false) return '<i class="fas fa-user-tie text-success icon"></i>';
              if (strpos($nama, 'regu') !== false) return '<i class="fas fa-shield-alt text-danger icon"></i>';
              return '<i class="fas fa-circle text-muted icon"></i>';
          }

          function render_tree($nodes) { ?>
            <ul class="tree">
              <?php foreach ($nodes as $node): ?>
                <li>
                  <?= get_icon($node->nama_unit) ?>
                  <strong><?= $node->nama_unit ?></strong>
                  <?php if (!empty($node->nama_pejabat)) : ?>
                    <span class="pejabat">(<?= $node->nama_pejabat ?>)</span>
                  <?php endif; ?>

                  <?php if (!empty($node->children)) : ?>
                    <?php render_tree($node->children); ?>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php } ?>

          <?php render_tree($tree); ?>

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
