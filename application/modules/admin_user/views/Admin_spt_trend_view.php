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
                        <h4 class="header-title">Trend Pengunjung 14 Hari Terakhir</h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right">
                           <!--  <select id="type" class="form-control form-control-sm d-inline-block" style="max-width: 100px;">
                                <option value="line">Line</option>
                                <option value="bar">Bar</option>
                            </select> -->
                            <!-- <button id="update" class="btn btn-sm btn-primary ml-1">Update</button> -->
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
                <div id="tren_new"></div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>


    </div>
</div>
<!-- <?php $this->load->view($controller."_js") ?> -->
