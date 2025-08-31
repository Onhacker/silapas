    <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h3 class="mt-4">
                            <span class="badge badge-danger noti-icon-badge" style="vertical-align: super; font-size: 50%;">
                                <?php echo $jumper ?>
                            </span>
                            Jenis <b>Permohonan</b>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="pt-2 pb-4">
                <div class="input-group">
                    <input type="text" id="searchInput" autocomplete="off" class="form-control form-control-sm" placeholder="Cari permohonan" 
                    aria-label="Search input" aria-describedby="searchBtn">
                    <span class="input-group-append">
                        <button type="button" id="searchBtn" class="btn btn-xs waves-effect waves-light btn-primary ml-1">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <button type="button" id="resetBtn" class="btn btn-xs btn-danger ml-1">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </span>
                </div>

                <div class="mt-3 text-center" id="searchTitle" style="display: none;">
                    <h4 class="font-weight-bold">Hasil Pencarian</h4>
                </div>
            </div>

            <div class="row" id="resultContainer">

            </div>
            <style type="text/css">                
                .input-group {
                    max-width: 600px;
                    margin: 0 auto;
                }

                #searchInput {
                    border-radius: 25px;
                    font-size: 14px;
                }

                #searchBtn, #resetBtn {
                    border-radius: 25px;
                }



            </style>
     

        <div class="row" id="defaultContainer">
            <?php foreach (array_slice($statistik_permohonan, 0, 10) as $i => $per): ?>

             <?php 
             if ($per['id_permohonan'] == "1" || $per['id_permohonan'] == "2" || $per['id_permohonan'] == "3" || $per['id_permohonan'] == "21") {
                $lg = "3";
                $rib = 'ribbon-box';
                if ($per['id_permohonan'] == "21") {
                   $ribb = '<div class="ribbon-two ribbon-two-danger"><span>SABIT</span></div>';
                } elseif ($per['id_permohonan'] == "1") {
                $ribb = '<div class="ribbon-two ribbon-two-blue"><span>3-in-1</span></div>';
                } elseif ($per['id_permohonan'] == "2") {
                $ribb = '<div class="ribbon-two ribbon-two-pink"><span>3-in-1</span></div>';
                } elseif($per['id_permohonan'] == "3") {
                $ribb = '<div class="ribbon-two ribbon-two-primary"><span>2-in-1</span></div>';

                }
                
            } else {
                $rib = "";
                $ribb = "";
                $lg = "3";
            }
            ?>

            <div class="col-lg-<?php echo $lg ?> d-flex align-items-stretch">

                <?php if ($this->uri->segment(1) == "admin_permohonan") {?>
                    <div class="card-box <?php echo $rib ?> bg-pattern w-100 <?php echo ($this->uri->segment(1) == "admin_permohonan") ? 'card-clickable' : ''; ?>" onclick="handleCardClick(<?php echo $per['id_permohonan'] ?? 0 ?>)">
                <?php } else { ?>
                    <div class="card-box <?php echo $rib ?> bg-pattern w-100">
                <?php } ?>

                    <?php echo $ribb ?>

                    <div class="d-flex flex-column justify-content-between h-100 rounded shadow-sm bg-white text-center">


                        <div>
                            <img src="<?php echo base_url("assets/images/web/" . (!empty($per['icon']) ? $per['icon'] : 'default.png')) ?>" 
                            alt="logo" 
                            class="avatar-xl img-thumbnail mb-1 border border-light shadow-sm" 
                            style="object-fit: cover; width: 100px; height: 100px;">

                            <h4 class="mb-1 font-weight-bold text-dark">
                                <?php echo $per['nama_permohonan'] ?>
                            </h4>

                            <p class="text-dark font-14">
                                <code class="text-dark"><b>Permohonan</b> :</code> <?php echo $per['deskripsi'] ?? '<i>Tidak ada deskripsi</i>' ?>
                            </p>
                        </div>
                        <?php if ($this->uri->segment(1) == "admin_permohonan") {?>


                            <div class="row justify-content-center text-center">
                                <?php
                                $statusList = [
                                    'status_0' => [
                                        'icon' => 'fa-hourglass-start',
                                        'color' => 'secondary',
                                        'label' => 'Belum Diproses'
                                    ],
                                    'status_1' => [
                                        'icon' => 'fa-sync-alt',
                                        'color' => 'warning',
                                        'label' => 'Sementara Diproses'
                                    ],
                                    'status_2' => [
                                        'icon' => 'fa-building',
                                        'color' => 'primary',
                                        'label' => 'Menunggu Verifikasi Capil'
                                    ],
                                    'status_3' => [
                                        'icon' => 'fa-check-circle',
                                        'color' => 'success',
                                        'label' => 'Disetujui'
                                    ],
                                    'status_4' => [
                                        'icon' => 'fa-times-circle',
                                        'color' => 'danger',
                                        'label' => 'Ditolak'
                                    ],
                                ];
                                ?>

                                <?php foreach ($statusList as $key => $item): ?>
                                    <div class="col-6 col-md-2 position-relative d-none d-md-block mb-2">
                                        <i class="fas <?= $item['icon'] ?> fa-2x text-<?= $item['color'] ?> mb-1"
                                           title="<?= $per['jumlah'][$key] ?? 0; ?> Permohonan <?= $item['label'] ?>"
                                           onmouseover="showToast(this)"
                                           onmouseout="hideToast(this)">
                                       </i>
                                       <div class="toast-hover bg-<?= $item['color'] ?> text-white px-2 py-1 rounded shadow">
                                        <?= $per['jumlah'][$key] ?? 0; ?> <?= $item['label'] ?>
                                        </div>
                                        <h6 class="mb-0">
                                            <span data-plugin="counterup"><?= $per['jumlah'][$key] ?? 0; ?></span>
                                        </h6>
                                    </div>
                                <?php endforeach; ?>
                        </div>
                    <?php } ?>


                    <?php if ($this->uri->segment(1) != "admin_permohonan"): ?>
                        <div class="mt-0 mb-1">
                            <a href="javascript:void(0);" onclick="loadSyarat(<?php echo $per['id_permohonan'] ?? 0 ?>)" class="btn btn-sm btn-primary">Lihat Syarat</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>
<div class="text-center mt-2">
    <button id="loadMoreBtn" type="button" class="btn btn-danger waves-effect waves-light">
        <span class="spinner-border spinner-border-sm mr-2 d-none" id="spinner"></span> 
        Selanjutnya<span class="btn-label-right"><i class="fas fa-chevron-down"></i></span>
    </button>
</div>


<div class="row" id="resultContainer" style="display: none;"></div>

<div class="row my-3">
    <style>
        .card-clickable {
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }
        .card-clickable:hover {
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.15);
        }
        .text-center i {
            display: block;
            margin-bottom: 8px;
            transition: transform 0.2s ease;
        }
        .text-center i:hover {
            transform: scale(1.2);
        }
        .toast-hover {
            position: absolute;
            top: 110%; /* Biar muncul di bawah ikon */
            left: 50%;
            transform: translateX(-50%);
            /*z-index: 999999;  Supaya benar-benar di atas semua */
            display: none;
            pointer-events: none;
            font-size: 13px;
            white-space: nowrap;
        }
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
        .card-box {
            padding: 1rem !important;
        }

    </style>
    

</div>
</div> 

<script type="text/javascript">
    $('#searchBtn').click(function () {
        const keyword = $('#searchInput').val().trim();
        if (keyword === '') {
            Swal.fire("Info", "Masukkan kata kunci pencarian", "warning");
            return;
        }
        $('#resultContainer').html(
            '<div class="col-12 text-center">' +
            '<div class="spinner-grow avatar-md text-primary" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            '</div>' +
            '<p class="mt-3">Sedang mencari <code>'+keyword+'</code>, harap tunggu...</p>' +
            '</div>'
            ).show();
        var isAdminPermohonan = <?= json_encode($this->uri->segment(1) === "admin_permohonan") ?>;
        var searchUrl = isAdminPermohonan 
        ? <?= json_encode(base_url("admin_permohonan/search")) ?> 
        : <?= json_encode(base_url("hal/search")) ?>;
        $.ajax({
            url: searchUrl,
            type: 'POST',
            data: { keyword: keyword },
            success: function (res) {
                var keyword = $('#searchInput').val().trim();
                $('#searchTitle').show();
                
                $('#defaultContainer').fadeOut('400', function() {
                    $('#resultContainer').fadeIn('400').html(res);
                });

                setTimeout(function() {

                    let totalResults = $('#resultContainer').find('.card-box').length;
                    $('#searchTitle').html("<h4>Ditemukan <span class='badge badge-danger ml-1'>"+totalResults+"</span> Permohonan Hasil Pencarian untuk: <strong><code>" + keyword + "</code></strong></h4>");
                    console.log("Jumlah hasil pencarian: " + totalResults);  

                    if (totalResults < 10) {  
                        $('#loadMoreBtn').hide();  
                    } else {
                        $('#loadMoreBtn').show();  
                    }
                }, 500);  
            },
            error: function () {
                $('#resultContainer').html(
                    '<div class="col-12 text-center text-danger">Terjadi kesalahan saat mencari.</div>'
                    ).show();
            }
        });
    });

    $('#searchInput').on('keypress', function (e) {
        if (e.which === 13) {
            $('#searchBtn').click();
        }
    });

    $('#resetBtn').click(function () {
        $('#searchInput').val('');                  
        $('#searchTitle').hide();                   
        $('#resultContainer').hide().empty();       
        $('#defaultContainer').fadeIn();  
        $('#loadMoreBtn').show();     
    });
</script>
<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="statusToast" class="toast align-items-center text-white bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                <!-- Isi dari JS -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>