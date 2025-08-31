<link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url("assets/admin") ?>/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $title ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $subtitle ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $subtitle ?></h4>
            </div>
        </div>
    </div>     

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="button-list">
                        <button type="button" onclick="add()" class="btn btn-success btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button>
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                    </div>
                    <hr>
                    <table id="datable_1" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="float-center">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th width="5%" ><strong>No.</strong>    </th>
                                <th>Nama Permohonan</th>
                                <th>Tabel</th>
                                              
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->



    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="form_app" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_permohonan" id="id_permohonan">

                        <div class="form-group mb-3">
                            <label for="nama_permohonan" class="text-primary">Nama Permohonan</label>
                            <input class="form-control" name="nama_permohonan" type="text" id="nama_permohonan" autocomplete="off">
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi" class="text-primary">Deskripsi Pendek</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="penjelasan" class="text-primary">Penjelasan</label>
                            <textarea class="form-control" name="penjelasan" id="penjelasan" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_file_balasan" class="text-primary">Nama File Balasan</label>
                            <textarea class="form-control" name="nama_file_balasan" id="nama_file_balasan" rows="2"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="file_balasan" class="text-primary">File Balasan</label>
                            <textarea class="form-control" name="file_balasan" id="file_balasan" rows="2"></textarea>
                            <small>contoh : kk,kkbaru,ktp. Pisahkan dengan koma jika lebih dari 1</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="peringatan" class="text-primary">Info Wajib/Tidak Wajib</label>
                            <textarea class="form-control" name="peringatan" id="peringatan" rows="2"></textarea>
                            <small>Masukkan 1 jika wajib, 0 jika tidak dengan mengikuti File Balasan diatas</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="icon" class="text-primary">Icon</label>
                            <input class="form-control" type="file" name="icon" id="icon">
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
    $this->load->view("backend/global_css");
    $this->load->view($controller."_js");
    ?>
  
</div>
