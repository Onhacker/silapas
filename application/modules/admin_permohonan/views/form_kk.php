<?php 
if ($record->status == 1) {
        if ($this->session->userdata("admin_level") == "faskes") {
            $status = "Proses Fasilitas Kesehatan";
            $deskripsi = "Permohonan sedang diproses oleh pihak Fasilitas Kesehatan";
        } else {
            $status = "Proses Desa";
            $deskripsi = "Permohonan sedang diproses oleh pihak Desa";
        }
    $icon = "mdi mdi-eye-check text-success";
    $warna = "success";
} elseif ($record->status == 2) {
    if ($this->session->userdata("admin_level") != "admin") {
        $deskripsi ="Menunggu verifikasi dari Dinas Kependudukan dan Pencatatan Sipil (Dukcapil) Kabupaten Morowali Utara";
    } else {
        $deskripsi ="Menunggu verifikasi";
    }
    $status = "Verifikasi";
    $icon = "mdi mdi-eye-check text-warning";
    $warna = "warning";
} elseif ($record->status == 3) {
    if ($this->session->userdata("admin_level") != "admin") {
        $deskripsi = "Permohonan disetujui oleh Dinas Kependudukan dan Pencatatan Sipil (Dukcapil) Kabupaten Morowali Utara";
    } else {
        $deskripsi ="Permohonan Disetujui";
    }
    $status = "Disetujui";
    $icon = "mdi mdi-bookmark-check text-blue";
    $warna = "blue";
} elseif ($record->status == 4) {
    if ($this->session->userdata("admin_level") != "admin") {
        $deskripsi = "Permohonan ditolak oleh Dinas Kependudukan dan Pencatatan Sipil (Dukcapil) Kabupaten Morowali Utara";
    } else {
        $deskripsi ="Permohonan Ditolak";
    }
    $status = "Ditolak";
    $icon = "mdi mdi-close-box-multiple text-danger";
    $warna = "danger";
} else {
    if ($this->session->userdata("admin_level") == "faskes") {
        $deskripsi = "Belum diproses oleh pihak Fasilitas Kesehatan";
    } else {
        $deskripsi = "Belum diproses oleh Desa";
    }
    
    $status = "✏️ Draft";
    $icon = "mdi mdi-table-edit text-primary";
    $warna = "primary";
}
?>
<div class="card-box text-left mt-3">
    <h4 class="header-title mb-0"><strong>Informasi Pemohon : <?php echo $subtitle ?></strong></h4>
    <div class="card border-0 shadow-sm ">
    </div>
    <style>
        /* Sembunyikan label-inline di desktop */
        .label-inline {
            display: none;
        }

        @media (max-width: 767.98px) {
            .table-stack-mobile colgroup {
                display: none;
            }

            .table-stack-mobile td.label,
            .table-stack-mobile td.colon {
                display: none;
            }

            .table-stack-mobile td.content {
                display: block;
                width: 100%;
                padding: 0.5rem 1rem;
                border-top: 1px solid #dee2e6;
            }

            .label-inline {
                display: block;
                font-weight: bold;
                /*color: #6c757d;*/
                margin-bottom: 0.25rem;
            }
        }
    </style>

    <table class="table table-hover m-0 table-sm table-stack-mobile w-100 no-footer dtr-inline collapsed" id="tickets-table">
        <colgroup>
            <col style="width: 30%;" class="label">
            <col style="width: 1%;" class="colon">
            <col class="content">
        </colgroup>
        <tbody>
            <tr>
                <td class="label"><b><i class="fas fa-user-circle mr-1 text-secondary"></i> Nama Pemohon</b></td>
                <td class="colon">:</td>
                <td class="content">
                    <span class="label-inline"><i class="fas fa-user-circle text-secondary"></i> Nama Pemohon</span>
                    <?php echo $record->nama_pemohon; ?>
                </td>
            </tr>
            <tr>
                <td class="label"><b><i class="fas fa-hashtag mr-1 text-secondary"></i> No. Register</b></td>
                <td class="colon">:</td>
                <td class="content">
                    <span class="label-inline"><i class="fas fa-hashtag text-secondary"></i> No. Register</span>
                    <?php echo $record->no_registrasi_pemohon; ?>
                </td>
            </tr>
            <tr>
                <td class="label"><b><i class="fas fa-barcode mr-1 text-secondary"></i> Kode Tracking</b></td>
                <td class="colon">:</td>
                <td class="content">
                    <span class="label-inline"><i class="fas fa-barcode text-secondary"></i> Kode Tracking</span>
                    <code><strong><?php echo $record->id_pemohon; ?></strong></code>
                </td>
            </tr>
            <tr>
                <td class="label"><b><i class="fab fa-whatsapp mr-1 text-success"></i> No. WA</b></td>
                <td class="colon">:</td>
                <td class="content">
                    <span class="label-inline"><i class="fab fa-whatsapp text-success"></i> No. WA</span>
                    <?php echo $record->no_wa_pemohon; ?>
                </td>
            </tr>
            <tr>
                <td class="label"><b><i class="far fa-clock mr-1 text-warning"></i> Waktu Permohonan</b></td>
                <td class="colon">:</td>
                <td class="content">
                    <span class="label-inline"><i class="far fa-clock text-warning"></i> Waktu Permohonan</span>
                    <?php echo hari($record->create_date) .", ".tgl_indo($record->create_date)." Pukul ".$record->create_time; ?>
                </td>
            </tr>
            <?php if ($this->session->userdata("admin_level") != "faskes") {?> 
            <tr>
                <td class="label"><b><i class="fas fa-map-marker-alt mr-1 text-danger"></i> Alamat</b></td>
                <td class="colon">:</td>
                <td class="content">
                    <span class="label-inline"><i class="fas fa-map-marker-alt text-danger"></i> Alamat</span>
                    Dusun <?php echo $dusun->nama_dusun.", Desa ".ucwords(strtolower($desa->desa)).", Kecamatan ".ucwords(strtolower($desa->kecamatan)); ?>
                </td>
            </tr>
            <tr>
                <td class="label"><b><i class="fas fa-file-alt mr-1 text-info"></i> Deskripsi Permohonan</b></td>
                <td class="colon">:</td>
                <td class="content">
                    <span class="label-inline"><i class="fas fa-file-alt text-info"></i> Deskripsi Permohonan</span>
                    <div class="font-italic text-dark">
                        <i class="mdi mdi-format-quote-open font-20"></i>
                        <?php echo $record->alasan_permohonan; ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if ($record->status == 4) { ?>
        <h4 class="mb-2 mt-2 font-weight-bold text-danger"><?php echo $status; ?></h4>
        <div class="alert alert-danger border rounded shadow-sm p-3">
            <p class="mb-2"><strong>❌ Alasan Penolakan:</strong><br>
                <code class="text-danger"><?php echo $record->alasan_penolakan ?></code>
            </p>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-0">Data Kepala Keluarga</h4>
                <div class="form-check mb-2 mt-2">
                    <div class="checkbox checkbox-danger mb-2">
                        <input type="checkbox" class="form-check-input" id="copyDataPemohon">
                        <label class="form-check-label text-dark" for="copyDataPemohon">Ceklis Samakan dengan data pemohon jika pemohon adalah kepala keluarga</label>
                    </div>
                </div>
                <form id="form_app" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo (isset($record->id_paket)) ? $record->id_paket : ""; ?>" id="id_paket" name="id_paket">
                    <input type="hidden" value="<?php echo $id_permohonan ?>" id="id_permohonan" name="id_permohonan">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-dark" for="nama"><strong>Nama Kepala Keluarga</strong></label>
                            <input type="text" class="form-control" value="<?php echo (isset($record->nama)) ? $record->nama : ""; ?>" id="nama" name="nama" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-dark" for="alamat"><strong>No. KK</strong></label>
                            <input type="text" class="form-control" value="<?php echo (isset($record->no_kk)) ? $record->no_kk : ""; ?>" id="no_kk" name="no_kk">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-dark" for="nik"><strong>NIK</strong></label>
                            <input type="text" class="form-control" value="<?php echo (isset($record->nik)) ? $record->nik : ""; ?>" id="nik" name="nik" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-dark" for="no_kk"><strong>Alamat Lengkap</strong></label>

                            <input type="text" class="form-control" value="<?php echo (isset($record->alamat)) ? $record->alamat : ""; ?>" id="alamat" name="alamat" placeholder="">
                            <?php if ($this->session->userdata("admin_level") == "faskes") {?> 
                            <small><code>Contoh : Jalan Bunga Mawar, RT.001/RW.002, Dusun Melati, Desa Kumbang, Kecamatan Rusa.</code></small>
                            <?php } else { ?>
                            <small><code>Contoh : Jalan Bunga Mawar, RT.001/RW.002</code></small>
                            <?php } ?>
                        </div>
                    </div>
                        <?php foreach ($inputan->result() as $in) { 
                            // Ambil nama kolom dari database
                            $field_name = $in->nama_kolom;

                            // Ambil nilai default jika ada dari $record
                            $value = isset($record->$field_name) ? $record->$field_name : '';
                        ?>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="text-dark" for="<?php echo $field_name; ?>">
                                    <strong><?php echo ucwords(str_replace('_', ' ', $field_name)); ?></strong>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="<?php echo $field_name; ?>" 
                                       name="<?php echo $field_name; ?>" 
                                       value="<?php echo htmlspecialchars($value); ?>">
                            </div>
                        </div>
                        <?php } ?>
