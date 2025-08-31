<div class="container-fluid">
    <?php $this->load->view("form_kk") ?>
    <div class="row">
        <div class="col-12">
            <!-- <div class="card-box"> -->
                <h4 class="header-title mb-3">Lampiran Dokumen Persyaratan</h4>
                <!-- </div> end card-box -->
            </div><!-- end col-->
        </div>

        <div class="row">
            <?php foreach ($dataFile->result() as $key){?>
                <div class="col-md-6 col-xl-3">
                    <div class="card mb">
                        <div class="card-header bg-dark  text-white">
                            <div class="card-widgets">
                                <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                <a data-toggle="collapse" href="#cardCollpase<?php echo $key->kode_file ?>" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                <a href="javascript:void(0)" onclick="hapus_file('<?= $record->id_paket ?>', 'file_<?php echo $key->kode_file ?>', 'file_<?php echo $key->kode_file ?>')"><i class="mdi mdi-trash-can-outline"></i></a>
                            </div>
                            <h5 class="card-title mb-0 text-white"><strong><?php echo $key->label ?></strong></h5>
                        </div>
                        <div id="cardCollpase<?php echo $key->kode_file ?>" class="collapse show">
                            <div class="card-body">
                                <?php $nama_field = 'file_' . $key->kode_file;
                                $dataDefaultFile = !empty($record->$nama_field) 
                                ? 'data-default-file="' . site_url('admin_permohonan/show_file/' . $record->$nama_field) . '"' 
                                : ''; ?>
                                <input type="file" name="file_<?php echo $key->kode_file ?>" id="file_<?php echo $key->kode_file ?>" class="dropify" <?= $dataDefaultFile ?>
                                onchange="uploadFileCustom(
                                    'file_<?php echo $key->kode_file ?>',
                                    '<?= $record->id_paket ?>',
                                    '<?= htmlspecialchars(site_url('admin_permohonan/upload_file_umum?nama_field=file_'.$key->kode_file.'&nama_prefix='.$key->kode_file.'_&nama_table='.$table_name), ENT_QUOTES, 'UTF-8') ?>',
                                    'preview_<?= $key->kode_file ?>',
                                    'uploadStatus<?php echo $key->kode_file ?>',
                                    'uploadProgress<?php echo $key->kode_file ?>'
                                    )"
                                    />
                                    <div class="progress mt-2" style="height: 20px; display: none;" id="uploadProgress<?php echo $key->kode_file ?>Wrapper">
                                        <div id="uploadProgress<?php echo $key->kode_file ?>Bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%">0%</div>
                                    </div>
                                    <small id="uploadStatus<?php echo $key->kode_file ?>" class="form-text text-dark mt-1"></small>
                                    <footer class="blockquote-footer mt-1"><b><?php echo $key->syarat ?></b></footer>
                                    <div style="text-align: justify;">
                                      <small><?php echo $key->penjelasan ?></small>
                                  </div>
                                    <?php if ($key->peringatan == '1') : ?>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('#file_<?php echo $key->kode_file ?>').dropify({
                                                    messages: {
                                                        'default': '<span class="badge bg-soft-danger text-danger">* Wajib diisi</span>',
                                                        'replace': 'Ganti file',
                                                        'remove': 'Hapus',
                                                        'error': 'Ooops, terjadi kesalahan.'
                                                    }
                                                });
                                            });
                                        </script>
                                        <?php else: ?>
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('#file_<?php echo $key->kode_file ?>').dropify({
                                                        messages: {
                                                            'default': '<span class="badge bg-soft-secondary text-muted">Opsional</span>',
                                                            'replace': 'Ganti file',
                                                            'remove': 'Hapus',
                                                            'error': 'Ooops, terjadi kesalahan.'
                                                        }
                                                    });
                                                });
                                            </script>
                                        <?php endif; ?>
                                        <?php if (isset($ukuran[$key->kode_file])): ?>
                                                <small style="display:none;" id="ukuran_<?php echo $key->kode_file ?>"><i class="mdi mdi-file-document-outline"></i> Ukuran file: <strong><?= $ukuran[$key->kode_file] ?></strong></small>
                                        <?php endif; ?>

                                        <a href="javascript:;" id="btn_preview_<?php echo $key->kode_file ?>" onclick="previewFileCustom('<?= $record->id_paket ?>', '<?= site_url('admin_permohonan/preview_file/'.$table_name.'/file_'.$key->kode_file) ?>', 'Preview <?php echo $key->syarat ?>')" class="btn btn-dark btn-block  btn-sm mt-2" style="display:none;">
                                            <i class="mdi mdi-eye mr-1"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                        <a href="javascript:;" onclick="proses('simpan')" id="btn-simpan-user" class="btn btn-primary btn-block">
                            <i class="mdi mdi-content-save mr-1"></i> Simpan
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="javascript:;" onclick="proses('kirim')" id="btn-user-kirim" class="btn btn-info btn-block">
                            <i class="mdi mdi-send mr-1"></i> Simpan & Kirim
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <button type="reset" onclick="back()" class="btn btn-secondary btn-block">
                            <i class="mdi mdi-close-circle mr-1"></i> Batal
                        </button>
                    </div>
                </div>



            </form>
        </div>
    </div>
</div>
</div>

<?php $this->load->view("Preview_file") ?>
<!-- Impor PDF.js dari CDN -->


<?php $this->load->view("Proses_paket_js"); ?>
</div>
