<div class="container-fluid">
    <?php $this->load->view("form_detail_pemohon") ?>
    <h4 class="header-title mt-4">Lampiran Permohonan</h4>
    <style type="text/css">
        @media (max-width: 767.98px) {
            .table-responsive table thead {
                display: none;
            }

            .table-responsive table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
            }

            .table-responsive table tbody td {
                display: block;
                text-align: left !important;
                padding: 6px 10px;
                border: none;
                position: relative;
            }

            .table-responsive table tbody td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 4px;
                color: #333;
            }

            .table-responsive table tbody td:last-child {
                border-bottom: none;
            }
        }
    </style>
    <div class="table-responsive text-left">
        <table class="table table-hover table-striped table-bordered">
            <thead class="bg-light text-center font-weight-bold">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 65%;">📎 Nama Lampiran</th>
                    <th style="width: 30%;">🗂️ Kelengkapan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 0;
                foreach ($dataFile->result() as $key) { 
                    $i++; ?>
                    <tr>
                        <td class="text-center align-middle d-none d-md-table-cell"><?= $i ?></td>
                        <td class="align-middle">
                            <div class="d-flex align-items-start">
                                <i class="mdi mdi-file-document-outline text-primary mr-2 mt-1"></i>
                                <div>
                                    <strong><?= $key->syarat ?></strong>
                                    <small class="d-block mt-1 text-dark" style="text-align: justify;">
                                        <?= $key->penjelasan ?>
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <button 
                                id="btn_preview_<?= $key->kode_file ?>" 
                                onclick="previewFileCustom(
                                    '<?= $record->id_paket ?>', 
                                    '<?= site_url('admin_permohonan/preview_file/' . $table_name . '/file_' . $key->kode_file) ?>', 
                                    '<?= $key->syarat ?>')" 
                                    class="btn btn-sm btn-success shadow-sm mb-1"
                                    style="display: none;">
                                    <i class="mdi mdi-eye mr-1"></i> Lihat
                                </button>
                                <?php if (isset($ukuran[$key->kode_file])): ?>
                                 <div class="file-info">
                                    <small 
                                    id="ukuran_<?= $key->kode_file ?>" 
                                    class="text-dark" 
                                    style="display: none;">
                                    <i class="mdi mdi-file-document-outline"></i>
                                    Ukuran File :<strong> <?= $ukuran[$key->kode_file] ?></strong>
                                </small>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


</div>


<?php if ($record->status == 3) {?>
    <h4 class="header-title mt-4">Permohonan Disetujui</h4>
    <div class="table-responsive text-left">
        <table class="table table-hover table-striped table-bordered">
            <thead class="bg-success">
                <tr class="text-center">
                    <th style="width: 70%">📄 Dokumen yang dihasilkan</th>
                    <th style="width: 30%">🔍 Lihat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($file_balasan_map as $kode => $nama_file): 
                    $field_name = 'file_' . $kode;
                    $file_value = $record->$field_name ?? '';
                    if (!empty($file_value)): ?>
                        <tr>
                            <td class="align-middle">
                                <i class="mdi mdi-file-document-outline text-primary mr-2"></i>
                                <strong><?= $nama_file ?></strong>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <button 
                                    id="btn_preview_<?= $kode; ?>" 
                                    onclick="previewFileCustom('<?= $record->id_paket ?>', '<?= site_url('admin_permohonan/preview_file/'.$table_name.'/file_'.$kode) ?>', '<?= $nama_file ?>')" 
                                    class="btn btn-primary btn-sm shadow-sm mb-1">
                                    <i class="mdi mdi-eye-outline mr-1"></i> Lihat
                                </button>
                                <?php if (isset($ukuran_balasan[$kode])): ?>
                                 <div class="file-info">
                                    <small 
                                    id="ukuran_<?= $kode ?>" 
                                    class="text-dark" 
                                    style="display: none;">
                                    <i class="mdi mdi-file-document-outline"></i>
                                    Ukuran File :<strong> <?= $ukuran_balasan[$kode] ?></strong>
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endif; endforeach; ?>
        <?php if (!empty($ket)) {?>
            <tr>
                <td colspan="2"><strong><?php echo $ket ?></strong></td>
            </tr>
        <?php  } ?>
    </tbody>
</table>

</div>
<?php } ?>

</div>


<?php if ($this->session->userdata("admin_level") == "admin" && ($record->status == 2 || $record->status == 4)) { ?>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="form_app" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo (isset($record->id_paket)) ? $record->id_paket : ""; ?>" id="id_paket" name="id_paket">
                        <input type="hidden" value="<?php echo $id_permohonan ?>" id="id_permohonan" name="id_permohonan">
                        <input type="hidden" name="alasan_penolakan" id="alasan_penolakan">

                        <div class="row">
                            <div class="col-12">
                                <!-- <div class="card-box"> -->
                                    <h4 class="header-title mb-3">Dokumen Baru</h4>
                                    <p>Upload Dokumen dibawah ini jika permohonan telah disetujui</p>
                                    <p><?php if (!empty($ket)) {?>
                                        <strong><?php echo $ket ?></strong>
                                    <?php  } ?>
                                </p>
                                <!-- </div> end card-box -->
                            </div><!-- end col-->
                        </div>

                        <div class="row">
                            <?php foreach ($file_balasan_map as $kode => $nama_file){ ?>
                             <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-header bg-success  text-white">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase<?php echo $kode ?>" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                            <a href="javascript:void(0)" onclick="hapus_file('<?= $record->id_paket ?>', 'file_<?php echo $kode ?>', 'file_<?php echo $kode ?>')"><i class="mdi mdi-trash-can-outline"></i></a>
                                        </div>
                                        <h5 class="card-title mb-0 text-white"><strong><?php echo $nama_file ?></strong></h5>
                                    </div>
                                    <div id="cardCollpase<?php echo $kode ?>" class="collapse show">
                                        <div class="card-body">
                                            <?php $nama_field = 'file_' . $kode;
                                            $dataDefaultFile = !empty($record->$nama_field) 
                                            ? 'data-default-file="' . site_url('admin_permohonan/show_file/' . $record->$nama_field) . '"' 
                                            : ''; ?>
                                            <input type="file" name="file_<?php echo $kode ?>" id="file_<?php echo $kode ?>" class="dropify" <?= $dataDefaultFile ?>
                                            onchange="uploadFileCustom(
                                                'file_<?php echo $kode ?>',
                                                '<?= $record->id_paket ?>',
                                                '<?= site_url('admin_permohonan/upload_file_umum?nama_field=file_'.$kode.'&nama_prefix='.$kode.'_&nama_table='.$table_name) ?>',
                                                'preview_<?= $kode ?>',
                                                'uploadStatus<?php echo $kode ?>',
                                                'uploadProgress<?php echo $kode ?>'
                                                )"
                                                />
                                                <div class="progress mt-2" style="height: 20px; display: none;" id="uploadProgress<?php echo $kode ?>Wrapper">
                                                    <div id="uploadProgress<?php echo $kode ?>Bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%">0%</div>
                                                </div>
                                                <small id="uploadStatus<?php echo $kode ?>" class="form-text text-dark mt-1"></small>
                                                <?php if (isset($ukuran_balasan[$kode])): ?>
                                                   <div class="file-info">
                                                    <small 
                                                    id="ukuran_<?= $kode ?>" 
                                                    class="text-dark" 
                                                    style="display: none;">
                                                    <i class="mdi mdi-file-document-outline"></i>
                                                    Ukuran File :<strong> <?= $ukuran_balasan[$kode] ?></strong>
                                                </small>
                                            </div>
                                        <?php endif; ?>

                                        <a href="javascript:;" id="btn_preview_<?php echo $kode ?>" onclick="previewFileCustom('<?= $record->id_paket ?>', '<?= site_url('admin_permohonan/preview_file/'.$table_name.'/file_'.$kode) ?>', 'Preview <?php echo $nama_file ?>')" class="btn btn-success btn-sm mt-2" style="display:none;">
                                            <i class="mdi mdi-account-card-details mr-1"></i> Lihat
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                </div>

                <!-- Action Buttons -->
                <style>
                    .btn-block {
                        transition: all 0.3s ease;
                    }

                    .btn-block:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                    }
                </style>

                <div class="row text-center">
                    <div class="col-md-4 mb-2">
                        <button id="btn-setujui" onclick="proses('kirim')" class="btn btn-success btn-block">
                            <i class="mdi mdi-check-circle mr-1"></i> <span>Setujui</span>
                        </button>
                    </div>
                    <div class="col-md-4 mb-2">
                        <button id="btn-tolak" onclick="tolak('kirim')" class="btn btn-danger btn-block">
                            <i class="mdi mdi-close-circle-outline mr-1"></i> <span>Tolak</span>
                        </button>
                    </div>
                    <div class="col-md-4 mb-2">
                        <button type="reset" onclick="back()" class="btn btn-secondary btn-block">
                            <i class="mdi mdi-arrow-left-circle mr-1"></i> Batal
                        </button>
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
</div>
<?php } ?>
<!-- Modal Preview File -->

<?php $this->load->view("Preview_file") ?>
<?php $this->load->view("Proses_paket_js"); ?>
</div>
