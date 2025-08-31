<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card-box ribbon-box">
                <div class="ribbon ribbon-blue float-left"> <img src="<?= base_url('assets/images/').$this->om->web_me()->gambar ?>" alt="Logo" height="24" class="rounded mr-2">
                    <?php if ($this->session->userdata("admin_level") != "admin") { ?>
                        Hak Akses Desa <?= ucwords(strtolower($record->desa)) ?>
                    <?php } else { ?>
                        Hak Akses Dukcapil Morowali Utara
                    <?php } ?>
                </div>
                <h5 class="text-blue float-right mt-0" id="clock">
                    <i class="fa fa-clock mr-1 pulse-icon rotate-icon"></i>
                    <span id="clock-text"></span>
                </h5>

                <div class="ribbon-content p-3 bg-light rounded shadow-sm">
                    <?php 
                    $name = "<span class='fw-bold text-primary'>" . htmlspecialchars($record->nama_lengkap) . "</span>";
                    $web = $this->om->web_me();
                    ?>

                    <p class="mb-2">
                        <?php echo ucapan() ?> <?= $name ?>, selamat datang di 
                        <span class="fw-bold text-dark"><?= htmlspecialchars($web->nama_website) ?></span> 
                        <small class="text-dark"> (<?= htmlspecialchars($web->meta_keyword) ?>)</small>, 
                        Kabupaten <?= htmlspecialchars($web->kabupaten) ?>.
                    </p>
                    <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                        <div class="mt-3">
                            <?php if ($hak_capil->num_rows() > 0): ?>
                                <p class="mb-2 fw-semibold"><i class="fas fa-unlock-alt text-primary me-1"></i> Daftar Hak Akses Permohonan Anda:</p>
                                <div class="row">
                                    <?php
                                    $half = ceil($hak_capil->num_rows() / 2);
                                    $rows = $hak_capil->result();
                                    ?>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Permohonan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; $i < $half; $i++): ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?= site_url("admin_permohonan/detail_paket/{$rows[$i]->nama_tabel}") ?>" class="text-decoration-none">
                                                                <?= htmlspecialchars($rows[$i]->nama_permohonan) ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Permohonan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = $half; $i < count($rows); $i++): ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?= site_url("admin_permohonan/detail_paket/{$rows[$i]->nama_tabel}") ?>" class="text-decoration-none">
                                                                <?= htmlspecialchars($rows[$i]->nama_permohonan) ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php else: ?>
                                    <p class="text-muted fst-italic">Anda adalah <strong>Super Admin</strong>. Semua akses terbuka.</p>
                                <?php endif; ?>
                            </div>
                        <?php } ?>


                    </div>

                </div>
            </div>
        </div>
        <style type="text/css">
            .rotate-icon {
                animation: rotate 4s linear infinite;
                color: #007bff;
            }

            @keyframes rotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .pulse-icon {
                animation: pulse 2s infinite;
                color: #007bff;
            }

            @keyframes pulse {
                0% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.1); opacity: 0.75; }
                100% { transform: scale(1); opacity: 1; }
            }

            #clock {
                /*font-size: 12px;*/
                font-weight: 600;
                color: #007bff;
                /*text-shadow: 1px 1px 4px rgba(0, 123, 255, 0.4);*/
                background: rgba(255, 255, 255, 0.85);
                padding: 8px 16px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                transition: 0.3s ease-in-out;
            }

            #clock:hover {
                background-color: rgba(0, 123, 255, 0.1);
                transform: scale(1.05);
            }


            /* Hover Effect */
            .hover-effect {
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
            }

            .hover-effect:hover {
                transform: translateY(-10px); /* sedikit mengangkat card */
                box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1); /* menambah bayangan saat hover */
            }

            /* Animasi counter pada angka */
            [data-plugin="counterup"] {
                font-size: 30px;
                font-weight: 600;
                color: #3c3c3c;
            }

            [data-plugin="counterup"] span {
                font-size: 32px;
                font-weight: 700;
                color: #1a202c;
            }

            .widget-rounded-circle .row {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .widget-rounded-circle .text-right {
                padding-right: 15px;
            }

            .widget-rounded-circle h3 {
                font-size: 1.5rem;
                font-weight: 700;
                color: #333;
            }

            .widget-rounded-circle p {
                font-size: 0.875rem;
                color: #6c757d;
            }

        </style>

        <?php if ($this->session->userdata("admin_level") != "admin") {?>
            <div class="row">
                <!-- Row 1 - 3 cards above -->
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-secondary">
                                    <i class="fe-edit-2 font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[0] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Belum Diproses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-info">
                                    <i class="fe-refresh-cw font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[1] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Diproses Desa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-warning">
                                    <i class="fe-clock font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[2] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Menunggu Capil</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-success">
                                    <i class="fe-check-circle font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[3] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Row 2 - 3 cards below -->
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-danger">
                                    <i class="fe-x-circle font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[4] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-primary">
                                    <i class="fe-layers font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= array_sum($status_count) ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else {?>

            <div class="row">
                <!-- Row 1 - 3 cards above -->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-warning">
                                    <i class="fe-clock font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[2] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Belum Diproses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-success">
                                    <i class="fe-check-circle font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[3] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-danger">
                                    <i class="fe-x-circle font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= $status_count[4] ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box shadow-lg hover-effect">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-primary">
                                    <i class="fe-layers font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <h3 class="text-dark mt-1" data-plugin="counterup"><span><?= array_sum($status_count) ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>



        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="header-title">Statistik Permohonan Dokumen </h4>
                        </div>
                    </div> 
                    <p></p>
                    <?php if ($this->session->userdata("admin_level") != "admin") {
                        $md = "6";
                    } else {
                        $md = "3";
                    } ?>
                    <form>
                        <div class="row">
                            <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                              <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <?php 
                                    $id_kecamatan = isset($id_kecamatan) ? $id_kecamatan : "";
                                    echo form_dropdown("id_kecamatan", $this->ma->arr_kecamatan(), $id_kecamatan, 'id="id_kecamatan" class="form-control select2" onchange="get_desa(this,\'#id_desa_cari\',1)"');
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label>Desa</label>
                                    <?php 
                                    $desa = isset($desa) ? $desa : "";
                                    echo form_dropdown("id_desa", [], $desa, 'id="id_desa_cari" class="form-control select2" onchange="get_dusun(this,\'#id_dusun_cari\',1)"');
                                    ?>
                                </div>
                                <small id="loading" class="text-danger"></small>
                            </div> 
                        <?php } ?>

                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label>Dusun</label>
                                <?php 
                                $id_dusun = isset($id_dusun) ? $id_dusun : "";
                                echo form_dropdown("id_dusun", [], $id_dusun, 'id="id_dusun_cari" class="form-control select2"');
                                ?>
                            </div>
                            <small id="loading" class="text-danger"></small>
                        </div>

                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label>Tahun</label>
                                <?php 
                                $tahun = isset($tahun)?$tahun:"";
                                echo form_dropdown("tahun",$this->ma->arr_tahun(),$tahun,'id="tahun" class="form-control select2"') 
                                ?>
                            </div>
                            <small id="loading" class="text-danger"></small>
                        </div>


                        <!--  -->


                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <a href="javascript:void(0);" onclick="reset()" class="btn btn-danger btn-sm mr-1">
                                    <i class="fa fa-undo"></i> Reset
                                </a>
                                <a href="javascript:void(0);" onclick="load_stat()" class="btn btn-blue btn-sm ">
                                    <i class="fa fa-search"></i> Tampilkan
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="d-flex justify-content-center"><div class="spinner-grow text-primary m-2" role="status"></div></div>
                <div id="tampil_stat"></div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>

    <script src="<?php echo base_url("assets/admin") ?>/chart/highcharts.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/exporting.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/export-data.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/accessibility.js"></script>
    
    <script type="text/javascript">


        $(document).ready(function() {
            load_stat();
            $('.spinner-grow').hide(); 

    // Inisialisasi select2 untuk semua dropdown terkait
    if (window.innerWidth > 767.98) { // Anggap 768px sebagai batas mobile
        $('#id_kecamatan, #id_desa_cari, #id_dusun_cari, #tahun').select2();
    }
    
});

        function get_desa(el, target, auto_load = 0) {
            $("#loading").html('Loading data....');
            var id = $(el).val();
            $.post("<?= site_url('admin_dashboard/get_desa') ?>", { id: id }, function(html) {
                $("#loading").hide();
                $(target).html(html);
            });
        }
        <?php if ($this->session->userdata("admin_level") == "user"): ?>
            $(document).ready(function() {
                get_dusun(null, '#id_dusun_cari');
            });
        <?php endif; ?>

        function get_dusun(el, target, mode = 1) {
            $("#loading").html('Loading data....');

            <?php if ($this->session->userdata("admin_level") == "user") { ?>
        // Ambil id_desa langsung dari session (karena dropdown desa tidak tersedia untuk user)
        var id = "<?php echo $this->session->userdata('id_desa'); ?>";
    <?php } else { ?>
        // Ambil id_desa dari elemen yang dipilih
        var id = $(el).val();
    <?php } ?>

    $.post("<?= site_url('admin_dashboard/get_dusun') ?>", { id: id }, function(html) {
        $("#loading").hide();
        $(target).html(html);
    });
}




function reset(){
 $('#id_desa_cari,#tahun,#id_kecamatan').val('').trigger('change');
 load_stat();
}
function load_stat() {
    $('.spinner-grow').show(); 
    $('#tampil_stat').html(""); 

    var id_kecamatan = $("#id_kecamatan").val(); // hanya dipakai jika admin
    var id_dusun     = $("#id_dusun_cari").val();
    var tahun        = $("#tahun").val();

    // Ambil id_desa sesuai level user
    <?php if ($this->session->userdata("admin_level") == "user") { ?>
        var id_desa = "<?php echo $this->session->userdata('id_desa'); ?>";
    <?php } else { ?>
        var id_desa = $("#id_desa_cari").val();
    <?php } ?>

    // AJAX POST
    $.ajax({
        type: "POST",
        url: "<?php echo site_url(strtolower($controller) . '/load_stat'); ?>",
        data: {
            id_kecamatan: id_kecamatan,
            id_desa: id_desa,
            id_dusun: id_dusun,
            tahun: tahun
        },
        success: function(result) {
            $("#tampil_stat").html(result);
            $('.spinner-grow').hide(); 
        },
        error: function(xhr, status, error) {
            $('.spinner-grow').hide(); 
            swal({
                title: "Error",
                text: "Gagal mengambil data. Silakan coba lagi.",
                icon: "error",
                button: "Tutup"
            });
            console.error("AJAX Error:", status, error);
        }
    });
}

function updateClock() {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const monthNames = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    const month = monthNames[now.getMonth()];

    const dateString = `${day} ${month} ${year}`;
    const timeString = `${hours}:${minutes}:${seconds}`;

    document.getElementById('clock-text').textContent = `${dateString} ${timeString}`;
}

setInterval(updateClock, 1000);
updateClock();


</script>
