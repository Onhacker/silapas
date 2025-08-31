<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($title ?? 'Laporan Booking Tamu'); ?></title>
<style>
  /* CSS sederhana yang didukung TCPDF */
  .title { font-size: 14px; font-weight: bold; margin-bottom: 6px; }
  .meta  { font-size: 10px; color: #444; margin-bottom: 10px; }
  table { width: 100%; border-collapse: collapse; }
  th, td { border: 1px solid #777; padding: 5px 6px; font-size: 10px; }
  th { background-color: #f0f0f0; }
  .small { font-size: 9px; color:#555; }
  .center { text-align: center; }
</style>
</head>
<body>

<div class="title"><?= htmlspecialchars($title ?? 'Laporan Booking Tamu'); ?></div>
<div class="meta">
  <?php
  $f = $filters ?? [];
  $bagian = [];
  if (!empty($f['tanggal_mulai']))   $bagian[] = 'Mulai: '.$f['tanggal_mulai'];
  if (!empty($f['tanggal_selesai'])) $bagian[] = 'Selesai: '.$f['tanggal_selesai'];

  // GANTI: dari Unit ID -> nama unit
  if (!empty($f['unit_tujuan_nama'])) {
      $bagian[] = 'Unit: '.$f['unit_tujuan_nama'];
  } else {
      // (opsional) tampilkan "Semua Unit" bila tidak difilter
      // $bagian[] = 'Unit: Semua';
  }

  if (!empty($f['form_asal']))       $bagian[] = 'Kata kunci: "'.$f['form_asal'].'"';
  $bagian[] = 'Status: '.(isset($f['status']) && $f['status']!=='' ? $f['status'] : 'Semua');
  echo implode(' | ', $bagian);
?>

</div>

<table>
  <thead>
    <tr>
      <th width="6%" class="center">No</th>
      <th width="18%">Kode Booking</th>
      <th width="18%">Tanggal / Jam</th>
      <th>Nama Tamu / Jabatan</th>
      <th width="24%">Asal</th>
      <th width="22%">Unit Tujuan / Petugas</th>
      <th width="12%">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($rows)): $no=1; foreach ($rows as $r): ?>
    <tr>
      <td width="6%" class="center"><?= $no++; ?></td>
      <td width="18%"><?= htmlspecialchars($r->kode_booking ?? '-'); ?></td>
      <td width="18%"><?= htmlspecialchars(($r->tanggal ?? '-') . ' ' . ($r->jam ?? '')); ?></td>
      <td>
        <b><?= htmlspecialchars($r->nama_tamu ?? '-'); ?></b><br>
        <span class="small"><?= htmlspecialchars($r->jabatan ?? '-'); ?></span>
      </td>
      <td width="24%"><?= htmlspecialchars($r->asal ?? $r->target_instansi_nama ?? '-'); ?></td>
      <td width="22%">
        <?= htmlspecialchars($r->unit_tujuan_nama ?? '-'); ?><br>
        <span class="small">
          <?= htmlspecialchars($r->nama_petugas_instansi ?? '-'); ?>
        </span>
      </td>
      <td width="12%"><?= htmlspecialchars($r->status ?? '-'); ?></td>
    </tr>
    <?php endforeach; else: ?>
    <tr>
      <td colspan="7" class="center">Tidak ada data</td>
    </tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>
