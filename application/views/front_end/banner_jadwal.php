<?php
// ====== Ambil & siapkan data dari $rec ======
$rec    = isset($rec) ? $rec : (object)[];
$tzName = !empty($rec->waktu) ? (string)$rec->waktu : 'Asia/Makassar';

try { $tz = new DateTimeZone($tzName); } catch(Exception $e) { $tz = new DateTimeZone('Asia/Makassar'); $tzName = 'Asia/Makassar'; }
$now = new DateTime('now', $tz);

// Helpers kecil
$hariMap  = [0=>'Minggu',1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu'];
$bulanMap = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
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
//   'sat'=>['open'=>'08:00','break_start'=>null,'break_end'=>null,'close'=>'11:30','closed'=>0],
//   'sun'=>['open'=>null,'break_start'=>null,'break_end'=>null,'close'=>null,'closed'=>1],
// ];
$daysKey = ['sun','mon','tue','wed','thu','fri','sat'];

// Ambil konfigurasi per hari dari $rec
$cfg = [];
foreach ($daysKey as $k) {
  $cfg[$k] = [
    'open'        => $norm($rec->{"op_{$k}_open"}       ),
    'break_start' => $norm($rec->{"op_{$k}_break_start"}),
    'break_end'   => $norm($rec->{"op_{$k}_break_end"}  ),
    'close'       => $norm($rec->{"op_{$k}_close"}      ),
    'closed'      => (int)($rec->{"op_{$k}_closed"}     ) ? 1 : 0,
  ];
}

// ===== Hitung status hari ini (informatif) =====
$w       = (int)$now->format('w');           // 0..6
$k       = $daysKey[$w];                     // sun..sat
$nowMin  = (int)$now->format('H')*60 + (int)$now->format('i');

$open    = $cfg[$k]['open'];
$close   = $cfg[$k]['close'];
$bs      = $cfg[$k]['break_start'];
$be      = $cfg[$k]['break_end'];
$isClosedDay = $cfg[$k]['closed'] || !$open || !$close;

$toMinSafe = function($s) use ($toMin){ return $s ? $toMin($s) : null; };
$o = $toMinSafe($open);
$c = $toMinSafe($close);
$bsMin = $toMinSafe($bs);
$beMin = $toMinSafe($be);
$hasBreak = ($bsMin !== null && $beMin !== null && $bsMin < $beMin);

// Default
$statusKey   = 'off';        // ok | rest | off
$statusLabel = 'Tutup';
$statusNote  = '';

if ($isClosedDay) {
  $statusKey   = 'off';
  $statusLabel = 'Libur';
  $statusNote  = 'Tidak ada layanan kunjungan pada hari ini.';
} else {
  if ($nowMin < $o) {
    $statusKey   = 'off';
    $statusLabel = 'Belum buka';
    $statusNote  = 'Jam Kunjungan hari ini: '.$dot($open).'–'.$dot($close).' '.$abbrTZ.'. Silakan datang mulai pukul '.$dot($open).' '.$abbrTZ.'.';
  } elseif ($nowMin > $c) {
    $statusKey   = 'off';
    $statusLabel = 'Sudah tutup';
    $statusNote  = 'Layanan kunjungan hari ini telah berakhir pada pukul '.$dot($close).' '.$abbrTZ.'.';
  } else {
    if ($hasBreak && $nowMin >= $bsMin && $nowMin < $beMin) {
      $statusKey   = 'rest';
      $statusLabel = 'Sedang istirahat';
      $statusNote  = 'Kunjungan dibuka kembali pukul '.$dot($cfg[$k]['break_end']).' '.$abbrTZ.' dan berakhir pukul '.$dot($close).' '.$abbrTZ.'.';
    } else {
      $statusKey   = 'ok';
      $statusLabel = 'Sedang buka';
      if ($hasBreak && $nowMin < $bsMin) {
        $statusNote = 'Istirahat: '.$dot($cfg[$k]['break_start']).'–'.$dot($cfg[$k]['break_end']).' '.$abbrTZ.'. Tutup pukul '.$dot($close).' '.$abbrTZ.'.';
      } else {
        $statusNote = 'Tutup pukul '.$dot($close).' '.$abbrTZ.'.';
      }
    }
  }
}


// Lokasi (opsional)
$kab = isset($rec->kabupaten) ? trim((string)$rec->kabupaten) : '';
$provRaw = isset($rec->provinsi) ? trim((string)$rec->provinsi) : '';
$prov = $provRaw !== '' ? ucwords(mb_strtolower($provRaw, 'UTF-8')) : '';
// Tanggal: "Hari, dd NamaBulan yyyy"
$hariNama   = $hariMap[$w];
$bulanNama  = $bulanMap[(int)$now->format('n')];
$tanggalIndo = "{$hariNama}, ".$now->format('d')." {$bulanNama} ".$now->format('Y');
?>
<style type="text/css">
/* ====== Card gaya “event” ====== */
.op-card{position:relative;border-radius:22px;padding:22px;overflow:hidden;color:#fff;
  background:linear-gradient(135deg,#1e3c72 0%,#4e77be 100%);box-shadow:0 8px 28px rgba(0,0,0,.12)}
.op-card:before{content:"";position:absolute;inset:0;
  background:radial-gradient(1200px 420px at -10% 0%,rgba(255,255,255,.08),transparent 60%),
             radial-gradient(1200px 420px at 110% 100%,rgba(255,255,255,.08),transparent 60%)}
.op-title{font-weight:800;font-size:1.5rem;margin:0 0 .35rem}
.op-row{display:flex;align-items:center;gap:.5rem;margin:.15rem 0}
.op-row .ico{display:inline-flex;width:26px;height:26px;border-radius:8px;align-items:center;justify-content:center;
  background:rgba(255,255,255,.15)}
.op-row .txt{font-weight:600}
.op-row .sub{opacity:.95}
.op-badge{padding:.0rem .7rem;border-radius:999px;font-weight:800;letter-spacing:.2px;background:rgba(255,255,255,.18)}
.op-badge.ok{background:rgba(16,185,129,.9)}     /* hijau */
.op-badge.rest{background:rgba(245,158,11,.95)}  /* oranye */
.op-badge.off{background:rgba(239,68,68,.95)}    /* merah */

/* CTA: mobile = inline, desktop = pojok kanan-bawah (seperti sebelumnya) */
.op-cta{display:inline-block;background:rgba(255,255,255,.18);
  padding:.55rem 1rem;border-radius:999px;color:#fff;font-weight:800;letter-spacing:.3px;text-decoration:none;
  backdrop-filter: blur(6px);transition:all .2s}
.op-cta:hover{background:rgba(255,255,255,.25);transform:scale(1.03)}
@media(min-width: 768px){
  .op-cta{position:absolute;right:20px;bottom:23px}
}

/* Keterangan di dalam card */
.op-note{margin-top:10px;border-radius:14px;padding:10px 12px;color:#fff;background:rgba(255,255,255,.12);
  border:1px dashed rgba(255,255,255,.35);line-height:1.4}
.hero-title .text{font-weight:800}
</style>

<div class="op-card mb-2">
  <div class="op-title">Jam Kunjungan (Hari Ini)</div>

  <div class="op-row">
    <span class="ico" aria-hidden="true">
      <!-- calendar -->
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M7 2v3M17 2v3M3 10h18M4 5h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>
    </span>
    <span class="txt"><?= htmlspecialchars($tanggalIndo, ENT_QUOTES, 'UTF-8') ?></span>
  </div>

  <div class="op-row">
    <span class="ico" aria-hidden="true">
      <!-- timer -->
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M10 2h4M12 8v4l3 2M5.5 5.5l2 2" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="14" r="7" stroke="#fff" stroke-width="1.6"/></svg>
    </span>
    <span class="txt">
      <?php if($isClosedDay): ?>
        LIBUR
      <?php else: ?>
        <?= $dot($open) ?> – <?= $dot($close) ?> <?= $abbrTZ ?>
        <?php if($hasBreak): ?>
          <span class="sub">(Istirahat <?= $dot($bs) ?>–<?= $dot($be) ?>)</span>
        <?php endif; ?>
      <?php endif; ?>
    </span>
  </div>

  <div class="op-row">
    <span class="ico" aria-hidden="true">
      <!-- clock -->
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 6v6l4 2" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.6"/></svg>
    </span>
    <span class="txt" id="liveTime" data-tz="<?= htmlspecialchars($tzName,ENT_QUOTES,'UTF-8'); ?>">
      <?= $now->format('H:i:s') . ' ' . $abbrTZ /* fallback SSR; akan ditimpa JS */ ?>
    </span>
    <span class="op-badge <?= $statusKey ?>" aria-label="Status hari ini"><?= htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8') ?></span>
  </div>

  <?php if ($statusNote): ?>
    <div class="op-row text-center mt-1">
     <!--  <span class="ico" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.6"/><path d="M12 8.2v.01M12 11v5" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
      </span> -->
      <span class="sub"><?= htmlspecialchars($statusNote, ENT_QUOTES, 'UTF-8') ?></span>
    </div>
  <?php endif; ?>

 
  <!-- Keterangan DI DALAM CARD -->
  <div class="op-note" role="note">
    Anda dapat melakukan <strong>booking kunjungan kapan saja</strong>. 
    Pastikan memilih <em>hari</em> dan <em>jam</em> yang sesuai dengan <strong>jam layanan</strong> yang berlaku.
  </div>

  <?php if ($this->uri->segment(2)!="jadwal") { ?>
    <a class="op-cta mt-2" href="<?= site_url('hal/jadwal'); ?>">DETAIL JADWAL</a>
  <?php } ?>
</div>

<script>
// Jam live sesuai timezone dari server-config ($rec->waktu).
(function(){
  const el = document.getElementById('liveTime');
  if (!el) return;
  const tz = el.getAttribute('data-tz') || 'Asia/Makassar';
  const fmtTime = new Intl.DateTimeFormat('id-ID', {
    timeZone: tz, hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:false
  });
  function tick(){ el.textContent = fmtTime.format(new Date()) + ' <?= $abbrTZ ?>'; }
  tick();
  setInterval(tick, 1000);
})();
</script>
