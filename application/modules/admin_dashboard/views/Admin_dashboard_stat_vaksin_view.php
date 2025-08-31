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
    <!-- end page title --> 

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="header-title"><?php echo $title ?> </h4>
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
                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Bulan</label>
                                <?php 
                                $bulan_awal = isset($bulan_awal)?$bulan_awal:"";
                                echo form_dropdown("bulan_awal",$this->ma->arr_bulan(),$bulan_awal,'id="bulan_awal" class="form-control" data-toggle="select2"') 
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


    </div>
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


