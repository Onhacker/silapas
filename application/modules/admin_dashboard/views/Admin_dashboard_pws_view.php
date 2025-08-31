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
                <h4 class="page-title"><?php echo $subtitle ?></h4>
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
                 
                    <form id="printContainer">
                        <div class="row">
                        
                        <?php if ($this->session->userdata("admin_level") == "admin") {?>

                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">dusun</label>
                                    <?php 
                                    $id_dusun = isset($id_dusun)?$id_dusun:"";
                                    echo form_dropdown("id_dusun",$this->ma->arr_dusun(),$id_dusun,'id="id_dusun" class="form-control"') 
                                    ?>
                                </div>
                            </div>
                        <?php } ?>

                      
                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Tahun </label>
                                <?php 
                                $tahun = isset($tahun)?$tahun:date("Y");
                                echo form_dropdown("tahun",$this->ma->arr_tahun(),$tahun,'id="tahun" class="form-control" data-toggle="select2"') 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Bulan</label>
                                <?php 
                                $bulan_awal = isset($bulan_awal)?$bulan_awal:date("m");
                                echo form_dropdown("bulan_awal",$this->ma->arr_bulan(),$bulan_awal,'id="bulan_awal" class="form-control" data-toggle="select2"') 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label >Jenis Vaksin</label>
                                <?php 
                                $jenis_vaksin = isset($jenis_vaksin)?$jenis_vaksin:"";
                                echo form_dropdown("jenis_vaksin",$this->ma->arr_vaksin_formx(),$jenis_vaksin,'id="jenis_vaksin_form" class="form-control" data-toggle="select2"') 
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
                             <a href="javascript:void(0);" onclick="load_pws()" class="btn btn-blue btn-sm ">
                                <i class="fa fa-search"></i> Tampilkan
                            </a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <script>
                    function printContent(el){
                        var restorepage = document.body.innerHTML;
                        var printcontent = document.getElementById(el).innerHTML;
                        document.body.innerHTML = printcontent;
                        window.print();
                        document.body.innerHTML = restorepage;

                    }
                </script>
 

 
                <div class="d-flex justify-content-center"><div class="spinner-grow text-primary m-2" role="status"></div></div>
                <div id="cartx">
                    <div id="tampil_stat"></div>
                    <style type="text/css">
                        hr.new4 {
                          border: 1px solid red;
                      }

                  </style>
                  <hr class="new4">  
                  <div id="tampil_bulan">

                  </div> 
                  <hr class="new4">  
                  <div id="tampil_trend">

                  </div>
               
                </div>
                    <button class="btn btn-sm btn-primary" id="btn-print" onclick="printContent('cartx')">Print</button>
               
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>


    </div>
</div>
<script src="<?php echo base_url("assets/admin") ?>/chart/highcharts.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/label.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/exporting.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/export-data.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/accessibility.js"></script>
<script type="text/javascript">
   
    $(document).ready(function(){
        $(".new4").hide();
        $('#btn-print').hide(); 
        $('.spinner-grow').hide(); 
        $('#id_dusun,#jenis_vaksin_form,#tahun,#bulan_awal').select2();
        <?php if ($this->session->userdata("admin_level") != "admin") {?>
            load_pws();
            
        <?php } ?>
        

    });
    function reset(){
        $(".new4").hide();
        $("#tahun").val(<?php echo date("Y") ?>).trigger('change');
        $("#bulan_awal").val(<?php echo date("m") ?>).trigger('change');
        $('#jenis_vaksin_form,#id_dusun').val('x').trigger('change');
        <?php if ($this->session->userdata("admin_level") != "admin") {?>
            load_pws();
            
        <?php } ?>
    }
    function load_pws() {
        $(".new4").hide();
        $('.spinner-grow').show(); 
        $('#tampil_stat').html(""); 
        $('#tampil_trend').html(""); 
        $('#tampil_bulan').html(""); 
        $('#btn-print').hide(); 
        jenis_vaksin_form = $("#jenis_vaksin_form").val();
        tahun = $("#tahun").val();
        bulan_awal = $("#bulan_awal").val();
        <?php if ($this->session->userdata("admin_level") == "admin") {?> 
            id_dusun = $("#id_dusun").val();
            if (tahun == "x"  || bulan_awal == "x" || id_dusun=="x" || jenis_vaksin_form == "x") {
                swal({   
                   title: "Peringatan",   
                   type: "warning", 
                   text: "Silahkan Pilih dusun, Tahun, Bulan dan Jenis Vaksin",
                   confirmButtonColor: "#22af47",   
                });
                $('.spinner-grow').hide(); 
            } else {
                $.ajax({
                    <?php if ($this->session->userdata("admin_level") == "admin") {?> 
                       url :'<?php echo site_url(strtolower($controller)."/load_pws"); ?>/'+jenis_vaksin_form+'/'+tahun+'/'+bulan_awal+'/'+id_dusun,
                   <?php } else {?>
                       url :'<?php echo site_url(strtolower($controller)."/load_pws"); ?>/'+jenis_vaksin_form+'/'+tahun+'/'+bulan_awal,
                   <?php } ?>

                   success: function(result){
                    $("#tampil_stat").html(result);
                    $("#tampil_trend").html(result);
                    $("#tampil_bulan").html(result);
                    $('.spinner-grow').hide(); 
                    $('#btn-print').show(); 
                    $(".new4").show();

                    },

                });
            }

        <?php } else {?>
            if (tahun == "x"  || bulan_awal == "x" || jenis_vaksin_form == "x") {
                swal({   
                   title: "Peringatan",   
                   type: "warning", 
                   text: "Silahkan Pilih Tahun, Bulan dan Jenis Vaksin",
                   confirmButtonColor: "#22af47",   
                });
                $('.spinner-grow').hide(); 
            } else {
                $.ajax({
                    <?php if ($this->session->userdata("admin_level") == "admin") {?> 
                       url :'<?php echo site_url(strtolower($controller)."/load_pws"); ?>/'+jenis_vaksin_form+'/'+tahun+'/'+bulan_awal+'/'+id_dusun,
                   <?php } else {?>
                       url :'<?php echo site_url(strtolower($controller)."/load_pws"); ?>/'+jenis_vaksin_form+'/'+tahun+'/'+bulan_awal,
                   <?php } ?>

                   success: function(result){
                    $("#tampil_stat").html(result);
                    $("#tampil_trend").html(result);
                    $("#tampil_bulan").html(result);
                    $('.spinner-grow').hide(); 
                    $('#btn-print').show(); 
                    $(".new4").show();

                    },

                });
            }
        <?php } ?>

       

    }
</script>


