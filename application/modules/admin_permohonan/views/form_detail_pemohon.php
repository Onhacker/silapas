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
    $deskripsi = "Belum diproses oleh Desa";
    $status = "✏️ Draft";
    $icon = "mdi mdi-table-edit text-primary";
    $warna = "primary";
}
?>
<?php $a = explode(" ", $record->update_time); ?>
<style type="text/css">
    .text-muted {
        color: #6c757d !important;
    }

    code.text-danger {
        background-color: #fff0f0;
        padding: 4px 8px;
        border-radius: 4px;
    }
    .label-inline {
        display: none;
    }

    @media (max-width: 767.98px) {
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

        .table-stack-mobile colgroup {
            display: none;
        }
    }

</style>
<div class="card-box ribbon-box mt-3">
    <div class="text-center mb-3"><h4><strong><?php echo $subtitle ?></strong></h4></div>
    <div class="ribbon-two ribbon-two-<?php echo $warna ?>"><span><?php echo $status; ?></span></div>
    <div class="text-center mb-4">
        <i class="h1 <?php echo $icon ?>"></i>
        <h3 class="mb-2 font-weight-bold text-<?php echo $warna ?>"><?php echo $status; ?></h3>
        <p class="text-muted mb-3 font-weight-bold"><?php echo $deskripsi ?></p>

        <?php if ($record->status == 4) { ?>
            <div class="alert alert-danger border rounded shadow-sm">
                <p class="mb-2"><strong>❌ Alasan Penolakan:</strong><br>
                    <code class="text-danger"><?php echo $record->alasan_penolakan ?></code>
                </p>
                <p class="mb-2"><strong>Waktu Penolakan:</strong><br>
                    📅 <?php echo hari($a[0]).", ".tgl_indo($a[0]) ?> Pukul <?php echo $a[1] ?>
                </p>
                <p class="mb-0"><strong>⏳ Lama Proses:</strong><br>
                    🕘 <?php echo hitungLamaProses($record->create_date, $record->create_time, $record->update_time) ?>
                </p>
                <?php if ($this->session->userdata("admin_level") != "admin") {?>
                    <p><button class="btn btn-success float-right" onclick="prosesUlang('<?= $record->id_paket ?>', '<?= $table_name ?>')">
                        🔄 Proses Ulang
                    </button></p>

                <?php  } ?>
            </div>



        <?php } elseif ($record->status == 3) { ?>
            <div class="alert alert-info border rounded shadow-sm">
                <p class="mb-2"><strong>Tanggal Disetujui:</strong><br>
                    📅 <?php echo tgl_indo($a[0]) ?> <span class="text-muted">Pukul</span> <?php echo $a[1] ?>
                </p>
                <p class="mb-0"><strong>⏳ Lama Proses:</strong><br>
                    🕘 <?php echo hitungLamaProses($record->create_date, $record->create_time, $record->update_time) ?>
                </p>
            </div>

        <?php } elseif ($record->status == 2) { 
            if ($this->session->userdata("admin_level") == "admin") {
                if ($table_name == "paket_u") {
                    $ket = "Dikirim Oleh ". $faskes->nama_fasilitas. " pada ";
                } else {
                    $ket = "Dikirim Oleh Desa ".ucwords(strtolower($desa->desa)).", Kecamatan ".ucwords(strtolower($desa->kecamatan))." Pada ";
                }

            } else {
                $ket = "Dikirim Pada Tanggal ";
            }
            ?>
            <div class="alert alert-warning border rounded shadow-sm ">
                <p class="mb-0"><strong><?php echo $ket ?> :</strong><br>
                    📅 <?php echo tgl_indo($a[0]) ?> <span class="text-muted">Pukul</span> <?php echo $a[1] ?>
                </p>
            </div>
        <?php } ?>

        <div class="card shadow-sm text-left">
            <h4 class="header-title mb-3">
                <i class="fas fa-user-circle mr-2"></i><strong>Informasi Pemohon: </strong>
            </h4>

            <table class="table table-hover table-sm m-0 table-centered w-100 table-stack-mobile">
                <colgroup>
                    <col style="width: 35%;">
                    <col style="width: 1%;">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <td class="label">
                            <i class="fas fa-user-circle text-dark"></i> Nama Pemohon
                        </td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline"><i class="fas fa-user-circle text-dark"></i> Nama Pemohon</span>
                            <?= $record->nama_pemohon; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><i class="fas fa-hashtag text-dark"></i> No. Register</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline"><i class="fas fa-hashtag text-dark"></i> No. Register</span>
                            <?= $record->no_registrasi_pemohon; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><i class="fas fa-barcode mr-1"></i> Kode Tracking</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline"><i class="fas fa-barcode mr-1"></i> Kode Tracking</span>
                            <code><strong><?= $record->id_pemohon; ?></strong></code>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><i class="fab fa-whatsapp text-success"></i> No. WA</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline"><i class="fab fa-whatsapp text-success"></i> No. WA</span>
                            <?= $record->no_wa_pemohon; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><i class="far fa-clock text-warning"></i> Waktu Permohonan</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline"><i class="far fa-clock text-warning"></i> Waktu Permohonan</span>
                            <?= hari($record->create_date).", ".tgl_indo($record->create_date)." Pukul ".$record->create_time; ?>
                        </td>
                    </tr>
                    <?php if ($table_name != "paket_u") {?> 
                    <tr>
                        <td class="label"><i class="fas fa-file-alt text-info"></i> Deskripsi Permohonan</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline"><i class="fas fa-file-alt text-info"></i> Deskripsi Permohonan</span>
                            <div class="font-italic text-dark" style="text-align: justify;">
                                <i class="mdi mdi-format-quote-open font-20"></i>
                                <?= $record->alasan_permohonan; ?>
                            </div>
                        </td>
                    </tr>
                <?php  } ?>
                </tbody>
            </table>


            <h4 class="header-title mt-4 mb-3">🏠 Data Kepala Keluarga</h4>
            <table class="table table-hover table-sm m-0 table-centered w-100 table-stack-mobile">
                <colgroup>
                    <col style="width: 35%;" class="label">
                    <col style="width: 1%;" class="colon">
                    <col class="content">
                </colgroup>
                <tbody>
                    <tr>
                        <td class="label">👨 Nama Kepala Keluarga</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline">👨 Nama Kepala Keluarga</span>
                            <?php echo $record->nama; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">🔢 NIK</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline">🔢 NIK</span>
                            <?php echo $record->nik; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">📄 No. KK</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline">📄 No. KK</span>
                            <?php echo $record->no_kk; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">🗺️ Alamat</td>
                        <td class="colon">:</td>
                        <td class="content" style="text-align: justify;">
                            <span class="label-inline">🗺️ Alamat</span>
                            <?php echo $record->alamat; ?>
                        </td>
                    </tr>
                    <?php if ($table_name != "paket_u") {?> 
                    <tr>
                        <td class="label">📍 Dusun</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline">📍 Dusun</span>
                            <?php echo ucwords(strtolower($dusun->nama_dusun)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">🏘️ Desa</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline">🏘️ Desa</span>
                            <?php echo ucwords(strtolower($desa->desa)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">🌐 Kecamatan</td>
                        <td class="colon">:</td>
                        <td class="content">
                            <span class="label-inline">🌐 Kecamatan</span>
                            <?php echo ucwords(strtolower($desa->kecamatan)); ?>
                        </td>
                    </tr>
                    <?php } ?>
                     <?php foreach ($inputan->result() as $in) { 
                            // Ambil nama kolom dari database
                            $field_name = $in->nama_kolom;

                            // Ambil nilai default jika ada dari $record
                            $value = isset($record->$field_name) ? $record->$field_name : '';
                        ?>
                        <tr>
                            <td class="label"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?></td>
                            <td class="colon">:</td>
                            <td class="content"><?php echo htmlspecialchars($value); ?></td>
                        </tr>
                       
                        <?php } ?>
                </tbody>
            </table>
        </div>