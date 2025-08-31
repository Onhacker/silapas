<link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->userdata("admin_level") != "admin") { 
                        $md = "3";
                        ?>
                    <?php } ?>

                    <?php if ($this->session->userdata("admin_level") == "admin") {
                        $md = "2"
                        ?>
                    <?php } ?>
                    <h4 class="header-title mb-2"><?php echo $subtitle ?></h4>
                    <h5 class="font-13 text-dark mb-2">Permohonan <?php echo $deskripsi ?></h5>
                    

                    <form id="form-filter">
                        <div class="row">
                            <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                <div class="col-md-<?php echo $md ?>">
                                    <div class="form-group">
                                        <!-- <label>Kecamatan</label> -->
                                        <?php 
                                        $id_kecamatan = isset($id_kecamatan) ? $id_kecamatan : "";
                                        echo form_dropdown("id_kecamatan", $this->pa->arr_kecamatan(), $id_kecamatan, 'id="id_kecamatan" class="form-control select2" onchange="get_desa(this,\'#id_desa_cari\',1)"');
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-<?php echo $md ?>">
                                    <div class="form-group">
                                        <!-- <label>Desa</label> -->
                                        <?php 
                                        $desa = isset($desa) ? $desa : "";
                                        echo form_dropdown("id_desa", [], $desa, 'id="id_desa_cari" class="form-control select2" onchange="get_dusun(this,\'#id_dusun_cari\',1)"');
                                        ?>
                                        <small id="loading" class="text-danger"></small>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->userdata("admin_level") == "user" or $this->session->userdata("admin_level") == "admin") { ?>
                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <!-- <label>Dusun</label> -->
                                    <?php 
                                    $id_dusun = isset($id_dusun) ? $id_dusun : "";
                                    echo form_dropdown("id_dusun", [], $id_dusun, 'id="id_dusun_cari" class="form-control select2"');

                                    ?>
                                    <small id="loading" class="text-danger"></small>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <!-- <label>Tahun</label> -->
                                    <?php 
                                    $tahun = isset($tahun) ? $tahun : "";
                                    echo form_dropdown("tahun", $this->pa->arr_tahun(), $tahun, 'id="tahun" class="form-control select2"');
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <!-- <label>Nama/NIK/No.KK</label> -->
                                    <input class="form-control" name="nama" type="text" id="nama_cari" placeholder="Nama/ NIK/ No.KK" autocomplete="off">
                                </div>
                            </div>
                            <?php if ($this->session->userdata("admin_level")=="user") {?>
                                <div class="col-md-<?php echo $md ?>">
                                    <div class="form-group">
                                        <!-- <label>Status</label> -->
                                        <select id="filterStatus" class="form-control select2">
                                            <option value="">== Semua Status ==</option>
                                            <option value="0">✏️ Belum Diproses</option>
                                            <option value="1">🔄 Diproses Desa</option>
                                            <option value="2">🕒 Menunggu Proses Capil</option>
                                            <option value="3">✅ Disetujui</option>
                                            <option value="4">❌ Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="col-md-<?php echo $md ?>">
                                    <div class="form-group">
                                        <!-- <label>Status</label> -->
                                        <select id="filterStatus" class="form-control select2">
                                            <option value="">== Semua Status ==</option>
                                            <option value="2">🕒 Belum Diproses</option>
                                            <option value="3">✅ Disetujui</option>
                                            <option value="4">❌ Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                            <?php  } ?>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                    <div class="row">
                                        <div class="col-xl-6 d-none d-md-flex">
                                            <div class="button-list">
                                                <?php if ($this->session->userdata("admin_level") != "admin") { ?>
                                                    <button type="button" onclick="add()" class="btn btn-primary btn-rounded btn-sm waves-effect waves-light me-2">
                                                        <i class="fa fa-plus me-1"></i> Tambah
                                                    </button>
                                                    <button type="button" onclick="edit_data()" class="btn btn-info btn-rounded btn-sm waves-effect waves-light me-2">
                                                        <i class="fa fa-edit me-1"></i> Edit
                                                    </button>
                                                    <button type="button" onclick="edit()" class="btn btn-success btn-rounded btn-sm waves-effect waves-light me-2">
                                                        <i class="fa fa-cogs me-1"></i> Proses
                                                    </button>
                                                    <button type="button" onclick="detail()" class="btn btn-secondary btn-rounded btn-sm waves-effect waves-light me-2">
                                                        <i class="fas fa-eye me-1"></i> Detail
                                                    </button>
                                                    <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light">
                                                        <i class="fa fa-trash me-1"></i> Hapus
                                                    </button>
                                                <?php } ?>
                                                <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                                    <button type="button" onclick="detail()" class="btn btn-blue btn-rounded btn-sm waves-effect waves-light">
                                                        <i class="fas fa-file-contract me-1"></i> Verifikasi
                                                    </button>
                                                <?php } ?>
                                                 <?php if ($this->session->userdata("admin_username") == "admin") { ?>
                                                   
                                                     <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light">
                                                        <i class="fa fa-trash me-1"></i> Hapus
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-xl-6">
                                            <div class="text-sm-right">
                                               <div class="button-list">
                                                <a href="javascript:void(0);" id="btn-filter" class="btn btn-info btn-sm me-2">
                                                    <i class="fa fa-search"></i> Cari
                                                </a>
                                                <a href="javascript:void(0);" id="btn-reset" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-undo"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 mt-2 d-block d-md-none">
                                        <div class="button-list">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="true"> Aksi <i class="mdi mdi-chevron-down"></i> </button>
                                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                                                   <?php if ($this->session->userdata("admin_level") != "admin") { ?>
                                                    <a href="javascript:void(0)" onclick="add()" class="dropdown-item mb-1" style="background-color: #007bff; color: white;">
                                                        <i class="fa fa-plus mr-1"></i> Tambah
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="edit_data()" class="dropdown-item mb-1" style="background-color: #17a2b8; color: white;">
                                                        <i class="fa fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="edit()" class="dropdown-item mb-1" style="background-color: #28a745; color: white;">
                                                        <i class="fa fa-cogs mr-1"></i> Proses
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="detail()" class="dropdown-item mb-1" style="background-color: #6c757d; color: white;">
                                                        <i class="fas fa-eye mr-1"></i> Detail
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="hapus_data()" class="dropdown-item mb-1" style="background-color: #dc3545; color: white;">
                                                        <i class="fa fa-trash mr-1"></i> Hapus
                                                    </a>
                                                <?php } ?>
                                                <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                                    <a href="javascript:void(0)" onclick="detail()" class="dropdown-item mb-1" style="background-color: #007bff; color: white;">
                                                        <i class="fas fa-file-contract me-1"></i> Verifikasi
                                                    </a>
                                                <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end row -->
                                <!-- </div>  end card-box -->
                            </div> <!-- end col -->
                        </div>

                    </form>


                    <style>
                        .bg-soft-warning {
                            background-color: #fff3cd !important;
                            border-left: 4px solid #ffc107;
                            padding: 0.75rem;
                            border-radius: 0.375rem;
                            font-size: 0.875rem;
                        }
                        
                    </style>

                    <table id="datable_1" class="table table table-striped table-bordered table-sm m-0 align-middle text-sm table-centered dt-responsive  w-100">
                        <thead>
                            <tr>
                                <th width="2%" class="text-center">
                                    <div class="checkbox checkbox-primary checkbox-single text-center">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th width="3%" class="d-none d-md-table-cell">No.</th>
                                <th class="d-none d-md-table-cell">Nama Kepala Keluarga</th>
                                <th class="d-none d-md-table-cell">NIK</th>
                                <th class="d-none d-md-table-cell">No. KK</th>
                                <th >Nama Pemohon</th>
                                <th class="d-none d-md-table-cell">Dusun</th>
                                <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                    <th class="d-none d-md-table-cell">Desa</th>
                                <?php } ?>
                                <th class="d-none d-md-table-cell">Tanggal</th>
                                <th>Status</th>
                            </tr>

                        </thead>
                        <tbody></tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                 <form id="form_app" method="post"  enctype="multipart/form-data" >
                    <h5 class="mb-3 text-uppercase text-white bg-primary p-2"><i class="mdi mdi-account"></i> Data Pemohon</h5>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <input type="hidden" name="id_paket" id="id_paket">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                       <label class="text-primary">Nama Pemohon</label>
                                       <input class='form-control' name="nama_pemohon" type="text" id="nama_pemohon" autocomplete="off">
                                   </div>
                               </div>
                               <div class="col-md-12">
                                <div class="form-group mb-3">
                                 <label class="text-primary">No. Whatsapp Pemohon</label>
                                 <input class='form-control' name="no_wa_pemohon" type="text" id="no_wa_pemohon" autocomplete="off">
                             </div>
                         </div> 

                         <?php if ($this->session->userdata("admin_level") == "user") {?>
                           
                             <div class="col-md-12">
                                <div class="form-group mb-3">
                                   <label class="text-primary">Dusun</label>
                                   <?php 
                                   $dusun = isset($dusun)?$dusun:"";
                                   echo form_dropdown("id_dusun",$this->dm->arr_dusun(),$dusun,'id="id_dusun"  class="form-control" data-toggle="select2"') 
                                   ?>
                                </div>
                            </div>

                             <div class="col-md-12">
                                <div class="form-group mb-3">
                                   <label class="text-primary">Alasan Permohonan</label>
                                   <textarea class="form-control" name="alasan_permohonan" id="alasan_permohonan" rows="5" style="margin-top: 0px; margin-bottom: 0px; height: 106px;" placeholder="Harap jelaskan dengan rinci alasan pengajuan permohonan Anda."></textarea>
                               </div>
                           </div>
                    <?php } ?>



               </div>

           </div>

       </form>
   </div>

   <div class="modal-footer">
    <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
    <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
$this->load->view("Paket_js");
?>
</div>

