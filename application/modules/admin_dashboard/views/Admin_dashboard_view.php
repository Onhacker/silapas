<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><?php echo $title ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title ?></h4>
            </div>
        </div>
    </div>     
    <style type="text/css">
        .toast {
            max-width: 100% !important;
        }
    </style>
    <!-- end page title --> 
    <div class="row ">
        <div class="col-lg-12 col-xl-12 ">
            <div class="toast fade show mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                <div class="toast-header">
                    <img src="<?php echo base_url('upload/gambar/favicon.ico') ?>" alt="brand-logo" height="12" class="mr-1">
                    <strong class="mr-auto">Desa <?php echo ucwords(strtolower($this->om->user()->desa)) ?></strong>
                    <small class="text-danger"><?php echo hari_ini(date("Y-m-d")).", ".tgl_indo(date("Y-m-d")) ?> </small>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
           </div>
       </div>
   </div>

</div>
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card-box" style="background-color: #4a81d4;">
            <!-- <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i> -->
            <h4 class="mt-0 font-16 text-white">Vaksin Anak <code><?php echo getBulan(date("m"))." ".date("Y") ?></code></h4>
            <h2 class="text-white my-3 text-center"><span data-plugin="counterup"><?php echo $vaksin_bulan_ini ?></span></h2>
            <p class="text-white mb-0">Total Vaksin (<?php echo date("Y") ?>) : <?php echo uang($vaksin_total) ?><!--  <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>10.25%</span> --></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card-box" style="background-color: #fd7e14">
            <!-- <i class="fa fa-info-circle text-dark float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i> -->
            <h4 class="mt-0 font-16 text-white">Vaksin Ibu <code style="color: white !important"><?php echo getBulan(date("m"))." ".date("Y") ?></code></h4>
            <h2 class="text-white my-3 text-center"><span data-plugin="counterup"><?php echo $vaksin_bulan_ini_ibu ?></span></h2>
            <p class="text-white mb-0">Total Vaksin (<?php echo date("Y") ?>) : <?php echo uang($vaksin_total_ibu) ?><!--  <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>10.25%</span> --></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
     <div class="card-box" style="background-color: #1abc9c">
        <!-- <i class="fa fa-info-circle text-dark float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i> -->
        <h4 class="mt-0 font-16">Vaksin Luar Wil. <code><?php echo getBulan(date("m"))." ".date("Y") ?></code></h4>
        <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?php echo $vaksin_bulan_ini_luar ?></span></h2>
        <p class="text-dark mb-0">Total Vaksin (<?php echo date("Y") ?>) : <?php echo uang($vaksin_total_luar) ?><!--  <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>10.25%</span> --></p>
    </div>
</div>

<div class="col-md-6 col-xl-3">
 <div class="card-box" style="background-color: #6658dd">
    <!-- <i class="fa fa-info-circle text-dark float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i> -->
    <h4 class="mt-0 font-16 text-white">KIPI <code><?php echo getBulan(date("m"))." ".date("Y") ?></code></h4>
    <h2 class="text-white my-3 text-center"><span data-plugin="counterup"><?php echo $vaksin_bulan_ini_kipi ?></span></h2>
    <p class="text-white mb-0">Total KIPI (<?php echo date("Y") ?>) : <?php echo uang($vaksin_total_kipi) ?><!--  <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>10.25%</span> --></p>
</div>
</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="header-title">Statistik Imunisasi </h4>
                </div>
            </div> <!-- end row -->
               <!--  <p class="text-muted font-13">
                    Gunakan filter pencarian untuk menampilkan grafik
                </p> -->
                <p></p>
                <?php if ($this->session->userdata("admin_level") != "admin") {
                    $md = "4";
                } else {
                    $md = "3";
                } ?>
                <form>
                    <div class="row">

                        <?php if ($this->session->userdata("admin_level") == "admin") {?>

                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">dusun</label>
                                    <?php 
                                    $id_dusun = isset($id_dusun)?$id_dusun:"";
                                    echo form_dropdown("id_dusun",$this->ma->arr_dusun(),$id_dusun,'id="id_dusun" onchange="get_desa(this,\'#id_desa_cari\',1)" class="form-control"') 
                                    ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Desa</label>
                                <?php 
                                $desa = isset($desa)?$desa:"";
                                echo form_dropdown("id_desa",$this->ma->arr_desa2(),$desa,'id="id_desa_cari"  class="form-control" data-toggle="select2"') 
                                ?>
                                <small id="loading" class="text-danger"></small>
                            </div>
                        </div>

                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Tahun </label>
                                <?php 
                                $tahun = isset($tahun)?$tahun:"";
                                echo form_dropdown("tahun",$this->ma->arr_tahun(),$tahun,'id="tahun" class="form-control" data-toggle="select2"') 
                                ?>
                            </div>
                        </div>
                    

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <a href="javascript:void(0);" onclick="reset()" class="btn btn-danger btn-sm ">
                                    <i class="fa fa-undo"></i> Reset
                                </a>
                                <a href="javascript:void(0);" onclick="load_stat_vaksin()" class="btn btn-blue btn-sm ">
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

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                            <i class="fe-map-pin font-22 avatar-title text-warning"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $kec ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Kecamatan</p>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                            <i class="fe-map font-22 avatar-title text-danger"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $desa ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Desa/Kelurahan</p>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                            <i class="fe-thermometer font-22 avatar-title text-info"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $dusun ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">RS/dusun</p>
                        </div>
                    </div>
                </div> 
            </div> 
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                            <i class="fe-users font-22 avatar-title text-primary"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $users ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Pengguna</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>
    <script src="<?php echo base_url("assets/admin") ?>/chart/highcharts.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/exporting.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/export-data.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/accessibility.js"></script>
    <script type="text/javascript">
        function get_desa(id,target,dropdown){
           $("#loading").html('Loading data....');
           console.log('id kecamatan' + $(id).val() );
           $.ajax({
            url:'<?php echo site_url(strtolower($controller)."/get_desa2"); ?>/'+$(id).val()+'/'+dropdown,
            success: function(data){
                $("#loading").hide();
                $(target).html('').append(data);
            }
        });
       }
       $(document).ready(function(){
        load_stat_vaksin();
        $('.spinner-grow').hide(); 
        $('#id_dusun,#id_desa_cari,#tahun,#bulan_awal').select2();

    });
       function reset(){
           $('#id_desa_cari,#tahun,#bulan_awal,#id_dusun').val('x').trigger('change');
           load_stat_vaksin();
       }
       function load_stat_vaksin() {
        $('.spinner-grow').show(); 
        $('#tampil_stat').html(""); 
        id_desa_cari = $("#id_desa_cari").val();
        tahun = $("#tahun").val();
        bulan_awal = $("#bulan_awal").val();
        <?php if ($this->session->userdata("admin_level") == "admin") {?> 
            id_dusun = $("#id_dusun").val();
        <?php } ?>
        if (tahun =="" ) {
            swal({   
             title: "Peringatan",   
             type: "warning", 
             text: "Silahkan Pilih Tahun",
             confirmButtonColor: "#22af47",   
         });
            $('.spinner-grow').hide(); 
        } else {
            $.ajax({
                <?php if ($this->session->userdata("admin_level") == "admin") {?> 
                   url :'<?php echo site_url(strtolower($controller)."/load_stat_vaksin"); ?>/'+id_desa_cari+'/'+tahun+'/'+bulan_awal+'/'+id_dusun,
               <?php } else {?>
                   url :'<?php echo site_url(strtolower($controller)."/load_stat_vaksin"); ?>/'+id_desa_cari+'/'+tahun+'/'+bulan_awal,
               <?php } ?>

               success: function(result){
                $("#tampil_stat").html(result);
                $('.spinner-grow').hide(); 

            },

        });
        }
    }
</script>

