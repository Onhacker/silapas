<?php $this->load->view("front_end/head.php"); ?>

<?php
// ====== Ambil & siapkan data dari $rec ======
$rec    = isset($rec) ? $rec : (object)[];
$tzName = !empty($rec->waktu) ? (string)$rec->waktu : 'Asia/Makassar';

try { $tz = new DateTimeZone($tzName); } catch(Exception $e) { $tz = new DateTimeZone('Asia/Makassar'); $tzName = 'Asia/Makassar'; }
$now = new DateTime('now', $tz);

// Helpers kecil
$hariMap  = [0=>'Minggu',1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu'];
$abbrTZ   = ($tzName==='Asia/Jakarta'?'WIB':($tzName==='Asia/Makassar'?'WITA':($tzName==='Asia/Jayapura'?'WIT':'')));

$norm = function($s){ // "8.00" / "08:00" -> "08:00" (atau null)
$s = trim((string)$s);
if ($s === '') return null;
$s = str_replace('.', ':', $s);
if (!preg_match('/^(\d{1,2}):([0-5]\d)$/', $s, $m)) return null;
$h = max(0, min(23, (int)$m[1]));
$i = (int)$m[2];
return sprintf('%02d:%02d', $h, $i);
};

$toMin = function($hhmm){
  if ($hhmm===null) return null;
  [$h,$i] = array_map('intval', explode(':', $hhmm));
  return $h*60 + $i;
};
$dot = fn($s)=> $s ? str_replace(':', '.', $s) : '';

// Default bila DB kosong
// $def = [
//   'mon'=>['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
//   'tue'=>['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
//   'wed'=>['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
//   'thu'=>['open'=>'08:00','break_start'=>'12:00','break_end'=>'13:00','close'=>'15:00','closed'=>0],
//   'fri'=>['open'=>'08:00','break_start'=>'11:30','break_end'=>'13:00','close'=>'14:00','closed'=>0],
//   'sat'=>['open'=>'08:00','break_start'=>null,   'break_end'=>null,   'close'=>'11:30','closed'=>0],
//   'sun'=>['open'=>null,   'break_start'=>null,   'break_end'=>null,   'close'=>null,   'closed'=>1],
// ];
$daysKey = ['sun','mon','tue','wed','thu','fri','sat'];

// Ambil konfigurasi per hari dari $rec
$cfg = [];
foreach ($daysKey as $k) {
  $cfg[$k] = [
    'open'        => $norm($rec->{"op_{$k}_open"}),
    'break_start' => $norm($rec->{"op_{$k}_break_start"}),
    'break_end'   => $norm($rec->{"op_{$k}_break_end"}),
    'close'       => $norm($rec->{"op_{$k}_close"}),
    'closed'      => (int)($rec->{"op_{$k}_closed"}) ? 1 : 0,
  ];
}

// Hitung info hari ini (untuk highlight dan label "(hari ini)")
$w = (int)$now->format('w');               // 0..6
$k = $daysKey[$w];                          // sun..sat
$nowMin = (int)$now->format('H')*60 + (int)$now->format('i');

$open  = $cfg[$k]['open'];
$close = $cfg[$k]['close'];
$bs    = $cfg[$k]['break_start'];
$be    = $cfg[$k]['break_end'];
$isClosedDay = $cfg[$k]['closed'] || !$open || !$close;

// (Status detail masih dihitung bila sewaktu-waktu mau dipakai di tempat lain)
$statusToday = 'Tutup';
if (!$isClosedDay) {
  $o = $toMin($open); $c = $toMin($close);
  $inOpen = ($o!==null && $c!==null && $nowMin >= $o && $nowMin <= $c);
  $inBreak = ($bs && $be) ? ($nowMin >= $toMin($bs) && $nowMin < $toMin($be)) : false;
  $statusToday = $inOpen ? ($inBreak ? 'Istirahat' : 'Buka') : 'Tutup';
}
?>

<style>
  /* ====== Card tabel jadwal (lebih manis) ====== */
  .op-tablecard{
    border-radius:16px;
    background:#fff;
    box-shadow:0 8px 28px rgba(0,0,0,.08);
    overflow:hidden;
    border:1px solid #e5e7eb;
  }
  .op-tablecard__head{
    display:flex;align-items:center;gap:.5rem;
    padding:12px 16px;
    background:linear-gradient(135deg,#4f46e5 0%, #06b6d4 100%);
    color:#fff;
  }
  .op-tablecard__head .hint{
    margin-left:auto;opacity:.95;font-weight:600
  }

  .op-table{width:100%;border-collapse:separate;border-spacing:0}
  .op-table thead th{
    background:#f8fafc;color:#0f172a;
    font-weight:700;text-transform:uppercase;
    letter-spacing:.02em;font-size:.78rem;
    border-bottom:1px solid #e5e7eb;
    padding:12px 14px;
  }
  .op-table tbody td{padding:12px 14px;border-bottom:1px dashed #eef2f7;vertical-align:middle}
  .op-table tbody tr:last-child td{border-bottom:0}

  .pill{display:inline-block;padding:.2rem .55rem;border-radius:999px;font-weight:700;font-size:.72rem}
  .pill.today{background:#e0e7ff;color:#3730a3}
  .pill.off{background:#fee2e2;color:#991b1b}
  .pill.tz{background:rgba(255,255,255,.2);color:#fff;border:1px solid rgba(255,255,255,.35)}

  .row-today{background:#f8fafc}
  .row-off{opacity:.8}
  .time-dash{font-variant-numeric:tabular-nums}

  @media (max-width:576px){
    .op-table thead th:nth-child(3),
    .op-table tbody td:nth-child(3){display:none} /* sembunyikan kolom Istirahat di mobile */
  }
</style>

<div class="container-fluid">

  <div class="hero-title" role="banner" aria-label="Judul situs">
    <h1 class="text"><?= htmlspecialchars($rec->title ?? ($title ?? 'Jadwal Kunjungan'), ENT_QUOTES, 'UTF-8') ?></h1>
    <?php if (!empty($deskripsi)): ?>
      <div class="text-muted"><?= htmlspecialchars($deskripsi, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <span class="accent" aria-hidden="true"></span>
  </div>

  <div class="row justify-content-center">
    <div class="col-12">

      <?php $this->load->view("front_end/banner_jadwal.php"); ?>

      <!-- Tabel Jam Operasional (Seminggu) -->
      <div class="op-tablecard mb-4">
        <div class="op-tablecard__head">
          <!-- ikon kalender kecil -->
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M7 2v3M17 2v3M3 10h18M4 5h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <strong>Jam Kunjungan</strong>
          <span class="hint pill tz"><?= htmlspecialchars($abbrTZ,ENT_QUOTES,'UTF-8') ?></span>
        </div>

        <table class="op-table">
          <thead>
            <tr>
              <th style="width:30%">Hari</th>
              <th style="width:35%">Buka – Tutup</th>
              <th style="width:35%">Istirahat</th>
            </tr>
          </thead>
          <tbody>
      <?php foreach ([1,2,3,4,5,6,0] as $d): // Sen..Sab, Minggu terakhir
      $kk    = $daysKey[$d];
      $row   = $cfg[$kk];
      $o     = $row['open'];   $c = $row['close'];
      $bsr   = $row['break_start']; $ber = $row['break_end'];
      $isOff = $row['closed'] || !$o || !$c;

      $rowClass = ($d === $w) ? 'row-today' : ($isOff ? 'row-off' : '');
      ?>
      <tr class="<?= $rowClass ?>">
        <td>
          <strong><?= $hariMap[$d] ?></strong>
          <?php if ($d === $w): ?>
            <span class="pill today ml-1">Hari ini</span>
            <?php elseif ($isOff): ?>
              <span class="pill off ml-1">Libur</span>
            <?php endif; ?>
          </td>
          <td class="time-dash">
            <?php if($isOff): ?>
              <span class="text-muted">—</span>
              <?php else: ?>
                <?= $dot($o) ?> – <?= $dot($c) ?> <?= $abbrTZ ?>
              <?php endif; ?>
            </td>
            <td class="time-dash">
              <?php if(!$isOff && $bsr && $ber): ?>
                <?= $dot($bsr) ?> – <?= $dot($ber) ?> <?= $abbrTZ ?>
                <?php else: ?>
                  <span class="text-muted">—</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<?php $this->load->view("front_end/footer.php"); ?>
