<style type="text/css">
    mark {
        background-color: yellow;
        padding: 0 2px;
    }
</style>
<?php if (!empty($message)): ?>
    <div class="col-12 text-center text-muted py-5">
        <h3><?= $message ?></h3>
    </div>
    <?php else: ?>
        <?php foreach ($statistik_permohonan as $i => $per): ?>
            <div class="col-lg-3 d-flex align-items-stretch">
               

                    <?php if ($this->uri->segment(1) == "admin_permohonan") {?>
                    <div class="card-box bg-pattern w-100 <?php echo ($this->uri->segment(1) == "admin_permohonan") ? 'card-clickable' : ''; ?>" 
                        onclick="handleCardClick(<?php echo $per['id_permohonan'] ?? 0 ?>)">
                    <?php } else { ?>
                        <div class="card-box bg-pattern w-100">
                    <?php } ?>

                    <div class="d-flex flex-column justify-content-between h-100 rounded shadow-sm bg-white text-center">

                        <div>
                            <img src="<?php echo base_url("assets/images/web/" . (!empty($per['icon']) ? $per['icon'] : 'default.png')) ?>" 
                            alt="logo" 
                            class="avatar-xl img-thumbnail mb-1 border border-light shadow-sm" 
                            style="object-fit: cover; width: 100px; height: 100px;">

                            <h4 class="mb-1 font-weight-bold text-primary">
                                <?= $per['nama_permohonan'] ?>
                            </h4>

                            <p class="text-dark font-14">
                                <code class="text-dark">Permohonan :</code> 
                                <?= $per['deskripsi'] ?? '<i>Tidak ada deskripsi</i>' ?>

                            </p>
                        </div>
                        <?php if ($this->uri->segment(1) == "admin_permohonan") {?>

                            <div class="row justify-content-center text-center">
                                <?php
                                $statusList = [
                                    'status_0' => [
                                        'icon' => 'fa-hourglass-start',
                                        'color' => 'secondary',
                                        'label' => 'Belum Diproses'
                                    ],
                                    'status_1' => [
                                        'icon' => 'fa-sync-alt',
                                        'color' => 'warning',
                                        'label' => 'Sementara Diproses'
                                    ],
                                    'status_2' => [
                                        'icon' => 'fa-building',
                                        'color' => 'primary',
                                        'label' => 'Menunggu Verifikasi Capil'
                                    ],
                                    'status_3' => [
                                        'icon' => 'fa-check-circle',
                                        'color' => 'success',
                                        'label' => 'Disetujui'
                                    ],
                                    'status_4' => [
                                        'icon' => 'fa-times-circle',
                                        'color' => 'danger',
                                        'label' => 'Ditolak'
                                    ],
                                ];
                                ?>

                                <?php foreach ($statusList as $key => $item): ?>
                                    <div class="col-6 col-md-2 position-relative d-none d-md-block mb-2">
                                        <i class="fas <?= $item['icon'] ?> fa-2x text-<?= $item['color'] ?> mb-1"
                                           title="<?= $per['jumlah'][$key] ?? 0; ?> Permohonan <?= $item['label'] ?>"
                                           onmouseover="showToast(this)"
                                           onmouseout="hideToast(this)">
                                       </i>
                                       <div class="toast-hover bg-<?= $item['color'] ?> text-white px-2 py-1 rounded shadow">
                                        <?= $per['jumlah'][$key] ?? 0; ?> <?= $item['label'] ?>
                                    </div>
                                    <h6 class="mb-0">
                                        <span data-plugin="counterup"><?= $per['jumlah'][$key] ?? 0; ?></span>
                                    </h6>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php } ?>

                    <?php if ($this->uri->segment(1) != "admin_permohonan"): ?>
                        <div class="mt-0 mb-1">
                            <a href="javascript:void(0);" onclick="loadSyarat(<?php echo $per['id_permohonan'] ?? 0 ?>)" class="btn btn-sm btn-primary">Lihat Syarat</a>
                        </div>
                        <?php $this->load->view("hal/hal_js") ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>