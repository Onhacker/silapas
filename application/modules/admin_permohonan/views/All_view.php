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
                    <h4 class="header-title mb-2"><?php echo $deskripsi ?></h4>
                    <p class="sub-header">

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
                                <?php if ($this->session->userdata("admin_level")!="admin") {?>

                                    <div class="col-md-<?php echo $md ?>">
                                        <div class="form-group">
                                            <select id="filterStatus" class="form-control select2">
                                                <option value="" <?php echo ($selectedStatus === '') ? 'selected' : ''; ?>>== Semua Status ==</option>
                                                <option value="0" <?php echo ($selectedStatus === '0') ? 'selected' : ''; ?>>✏️ Belum Diproses</option>
                                                <option value="1" <?php echo ($selectedStatus === '1') ? 'selected' : ''; ?>>🔄 Diproses Desa</option>
                                                <option value="2" <?php echo ($selectedStatus === '2') ? 'selected' : ''; ?>>🕒 Menunggu Proses Capil</option>
                                                <option value="3" <?php echo ($selectedStatus === '3') ? 'selected' : ''; ?>>✅ Disetujui</option>
                                                <option value="4" <?php echo ($selectedStatus === '4') ? 'selected' : ''; ?>>❌ Ditolak</option>
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
                                
                                <div class="col-12 mb-2">

                                    <div class="row">
                                        <div class="col-xl-6 d-none d-md-flex">
                                            <div class="button-list">
                                                <button type="button" onclick="detail()" class="btn btn-blue btn-rounded btn-sm waves-effect waves-light">
                                                    <i class="fas <?php echo ($this->session->userdata("admin_level") == "admin") ? 'fa-file-contract' : 'fa-eye'; ?> me-1"></i>
                                                    <?php echo ($this->session->userdata("admin_level") == "admin") ? 'Verifikasi' : 'Detail'; ?>
                                                </button>
                                            </div>

                                        </div> 

                                        <div class="col-xl-6 mt-xl-0">
                                            <div class="text-sm-right">
                                               <div class="button-list">
                                                <button type="button" onclick="detail()" class="btn btn-blue btn-rounded btn-sm waves-effect waves-light d-md-none">
                                                    <i class="fas <?php echo ($this->session->userdata("admin_level") == "admin") ? 'fa-file-contract' : 'fa-eye'; ?> me-1"></i>
                                                    <?php echo ($this->session->userdata("admin_level") == "admin") ? 'Verifikasi' : 'Detail'; ?>
                                                </button>
                                                <a href="javascript:void(0);" id="btn-filter" class="btn btn-info btn-sm me-2">
                                                    <i class="fa fa-search"></i> Cari
                                                </a>
                                                <a href="javascript:void(0);" id="btn-reset" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-undo"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 

                            </div> 


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
                    <div class="table-responsive">
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
                                    <th class="d-none d-md-table-cell">Jenis Permohonan</th>
                                    <th >Nama Kepala Keluarga/ Pemohon</th>
                                    <th class="d-none d-md-table-cell">NIK</th>
                                    <th class="d-none d-md-table-cell">NO. KK</th>
                                     <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                        <th class="d-none d-md-table-cell">Alamat</th>
                                    <?php } else {?>
                                        <th class="d-none d-md-table-cell">Dusun</th>
                                    <?php } ?>
                                    <th class="d-none d-md-table-cell">Tanggal</th>
                                    <th>Status</th>
                                </tr>

                            </thead>
                            <tbody></tbody>
                        </table>



                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

    <?php
    $this->load->view("All_js");
    ?>
</div>

