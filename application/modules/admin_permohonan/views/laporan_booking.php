<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= htmlspecialchars($title ?? 'Laporan Booking Tamu'); ?></title>
<style>
  /* CSS sederhana (aman untuk TCPDF) */
  .title   { font-size: 13px; font-weight: bold; margin: 2px 0 4px; text-transform: uppercase; }
  .kop-org { font-size: 12pt; font-weight: 800; letter-spacing: .3px; }
  .kop-sub { font-size: 9pt;  color:#555; }
  .meta    { font-size: 10px; color:#444; margin: 6px 0 10px; text-align: center; }
  table    { width: 100%; border-collapse: collapse; }
  th, td   { border: 1px solid #777; padding: 5px 6px; font-size: 10px; }
  th       { background-color: #f0f0f0; }
  .small   { font-size: 9px; color:#555; }
  .center  { text-align: center; }
  .no-border td { border: none !important; }
</style>
</head>
<body>
<?php 
$logo_file   = FCPATH.'assets/images/logo.png';
$logo_exists = is_file($logo_file);

/* Helper hari + tanggal Indonesia */
if (!function_exists('hari_tanggal_id')) {
  function hari_tanggal_id($tgl, $jam = null){
    if (empty($tgl)) return '-';
    $ts = strtotime(trim($tgl.' '.($jam ?? '')));
    if (!$ts) return '-';
    $map = ['Sun'=>'Minggu','Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu','Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu'];
    $hari = $map[date('D',$ts)] ?? date('D',$ts);
    $tglf = date('d-m-Y', $ts);
    $jamf = $jam ? date('H:i', $ts) : '';
    return trim($hari.', '.$tglf.' '.$jamf);
  }
}

/* Bangun baris filter (ditaruh di bawah kop, center) */
$f = $filters ?? [];
$bagian = [];
if (!empty($f['tanggal_mulai']) || !empty($f['tanggal_selesai'])) {
  $mulai   = !empty($f['tanggal_mulai'])   ? date('d-m-Y', strtotime($f['tanggal_mulai']))   : '-';
  $selesai = !empty($f['tanggal_selesai']) ? date('d-m-Y', strtotime($f['tanggal_selesai'])) : '-';
  $bagian[] = "Periode: {$mulai} s/d {$selesai}";
}
if (!empty($f['unit_tujuan_nama'])) {
  $bagian[] = 'Unit: '.$f['unit_tujuan_nama'];
}
if (!empty($f['form_asal'])) {
  $bagian[] = 'Kata kunci: "'.$f['form_asal'].'"';
}
$bagian[] = 'Status: '.(isset($f['status']) && $f['status']!=='' ? $f['status'] : 'Semua');
$filter_line = implode('  |  ', $bagian);
?>

<!-- KOP SURAT (tengah) -->
<table class="no-border" style="margin-bottom:6px;">
  <tr>
    <td class="center" style="padding-bottom:4px;">
      <?php if ($logo_exists): ?>
        <img src="<?= $logo_file ?>" alt="Logo" style="height:42px"><br>
      <?php endif; ?>
      <div class="kop-org">LAPAS KELAS I MAKASSAR</div>
      <div class="kop-sub">Jl. Sultan Alauddin, Gn. Sari, Kec. Rappocini, Kota Makassar, Sulawesi Selatan 90221</div>
      <div class="title"><?= htmlspecialchars($title ?? 'Laporan Booking Tamu'); ?></div>
    </td>
  </tr>
</table>

<!-- Garis pemisah dobel ala kop -->
<table class="no-border" style="margin:0 0 8px 0;">
  <tr><td style="border-top:1px solid #000;height:0;"></td></tr>
  <tr><td style="border-top:0.8px solid #000;height:0;"></td></tr>
</table>

<!-- Baris filter (center) -->
<?php if (!empty($filter_line)): ?>
  <div class="meta"><?= htmlspecialchars($filter_line); ?></div>
<?php endif; ?>

<table>
  <thead>
    <tr>
      <th width="5%"  class="center">No</th>
      <th width="12%" class="center">Kode Booking</th>
      <th width="17%" class="center">Tanggal / Jam</th>
      <th width="20%" class="center">Nama Tamu / Jabatan</th>
      <th width="18%" class="center">Asal</th>
      <th width="20%" class="center">Unit Tujuan / Petugas</th>
      <th width="8%"  class="center">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($rows)): $no=1; foreach ($rows as $r): ?>
    <tr>
      <td width="5%"  class="center"><?= $no++; ?></td>
      <td width="12%"><?= htmlspecialchars($r->kode_booking ?? '-'); ?></td>
      <td width="17%"><?= htmlspecialchars(hari_tanggal_id($r->tanggal ?? null, $r->jam ?? null), ENT_QUOTES, 'UTF-8'); ?></td>
      <td width="20%">
        <b><?= htmlspecialchars($r->nama_tamu ?? '-'); ?></b><br>
        <span class="small"><?= htmlspecialchars($r->jabatan ?? '-'); ?></span>
      </td>
      <td width="18%"><?= htmlspecialchars($r->asal ?? $r->target_instansi_nama ?? '-'); ?></td>
      <td width="20%">
        <?= htmlspecialchars($r->unit_tujuan_nama ?? '-'); ?><br>
        <span class="small"><?= htmlspecialchars($r->nama_petugas_instansi ?? '-'); ?></span>
      </td>
      <td width="8%" class="center"><?= htmlspecialchars(strtoupper($r->status ?? '-')); ?></td>
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
