<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cetak QR - <?= html_escape($row->nama) ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  :root{
    /* Palet biru & biru muda */
    --poster:#0f4c81;   /* biru tua / navy */
    --pad:#a6d8ff;      /* biru muda */
    --ink:#06233f;      /* tinta biru gelap */

    /* lebar dasar poster: 10.5 cm (tinggi kita hitung proporsional) */
    --size:10.5cm;

    --radius-outer:20px; --radius-inner:14px;
    --stroke:6px; --marker:56px; --qr-pad:10px;
  }
  *{box-sizing:border-box}
  html,body{height:100%}
  body{
    margin:0;
    font-family:Arial,Helvetica,sans-serif;
    background:#f3f7fb; /* latar belakang lembut biru muda */
    color:#000;
    -webkit-print-color-adjust:exact;
    print-color-adjust:exact;
  }

  .poster{
    width:var(--size);
    /* tinggi = 16.5 / 10.5 ≈ 1.5714 × lebar -> potrait 10.5 x 16.5 cm */
    height:calc(var(--size) * 1.5714);
    margin:12px auto;
    background:var(--poster);
    border-radius:12px;
    position:relative;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    align-items:center;
  }

  .title {
    margin-top: 12px;
    margin-bottom: -30px;
    text-align: center;
    color: #fff;
    line-height: 1.05;
  }
  .title h1{
    margin:0;
    font-weight:900;
    font-size:clamp(28px,7vw,44px);
    letter-spacing:.3px
  }
  .title p{
    margin:6px 0 2px;
    font-weight:800;
    font-size:clamp(14px,3.6vw,20px);
    color:#eaf4ff; /* sedikit lebih lembut */
  }
  .title .subtitle{
    display:block;
    margin-top:4px;
    margin-bottom:0;
    font-weight:500;
    font-size:clamp(11px,3vw,13px);
    line-height:1.3;
    color:rgba(230,244,255,.9);
  }

  .stack{
    position:relative;
    width:94%;
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center
  }
  .pad{
    position:absolute;
    left:0;right:0;
    margin:auto;
    width:100%;
    height:50%;
    background:var(--pad);
    border:var(--stroke) solid var(--ink);
    border-radius:calc(var(--radius-outer) + 4px);
    box-shadow:0 2px 0 rgba(0,0,0,.15) inset;
    transform:translateY(2px);
  }
  .qr-card{
    position:relative;
    width:80%;
    height:78%;
    background:#fff;
    border:var(--stroke) solid var(--ink);
    border-radius:var(--radius-outer);
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 6px 0 rgba(0,0,0,.06);
  }
  .qr-inner{
    position:relative;
    width:98%;
    height:94%;
    border-radius:var(--radius-inner);
    background:#fff
  }

  .corner{
    position:absolute;
    width:var(--marker);
    height:var(--marker);
    border-radius:10px
  }
  .tl{
    top:14px;
    left:14px;
    border-top:6px solid var(--ink);
    border-left:6px solid var(--ink)
  }
  .tr{
    top:14px;
    right:14px;
    border-top:6px solid var(--ink);
    border-right:6px solid var(--ink)
  }
  .br{
    bottom:14px;
    right:14px;
    border-bottom:6px solid var(--ink);
    border-right:6px solid var(--ink)
  }
  .bl{
    bottom:14px;
    left:14px;
    border-bottom:6px solid var(--ink);
    border-left:6px solid var(--ink)
  }

  .qr-fit{
    position:absolute;
    inset:var(--qr-pad);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
  }
  .qr-fit img{
    max-width:100%;
    max-height:100%;
    width:auto;
    height:auto;
    aspect-ratio:1/1;
    display:block;
    image-rendering:crisp-edges;
  }

  @media print{
    .no-print{display:none}
    body{margin:0; background:#fff;} /* saat print pakai putih */

    /* paksa ukuran kertas & poster 10.5 x 16.5 cm potrait */
    @page{
      size:10.5cm 16.5cm;
      margin:0;
    }
    .poster{
      margin:0 auto;
      width:10.5cm;
      height:16.5cm;
    }
  }

  @media (max-width:760px){
    /* di HP pakai lebar layar, tapi tetap proporsi 10.5 : 16.5 */
    :root{
      --size:92vw;
      --marker:clamp(34px,10vw,56px);
      --qr-pad:clamp(8px,2.4vw,10px)
    }
    .poster{
      width:var(--size);
      height:calc(var(--size) * 1.5714);
    }
  }

  .no-print{
    text-align:center;
    margin:10px 0 18px;
  }
  #btnDownload{
    appearance:none;
    border:0;
    border-radius:10px;
    background:#0f4c81; /* senada dengan poster */
    color:#fff;
    font-size:15px;
    font-weight:600;
    line-height:1.2;
    padding:10px 16px;
    cursor:pointer;
    min-width:180px;
    box-shadow:0 6px 16px rgba(0,0,0,.3);
    transition:background .15s, transform .1s;
  }
  #btnDownload:hover{
    background:#06233f;
  }
  #btnDownload:active{
    transform:scale(.98);
  }
 .title h1{
  margin:0;
  padding:.2rem 1.1rem .3rem;
  display:inline-block;
  text-transform:uppercase;
  font-weight:900;
  font-size:clamp(16px,3vw,24px); /* <<< diperkecil */
  letter-spacing:.12em;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  color:#ffffff;
  text-shadow:0 2px 4px rgba(0,0,0,.55);
  border-radius:999px;
  background:linear-gradient(135deg,
      rgba(255,255,255,.16),
      rgba(255,255,255,.03)
  );
  border:1px solid rgba(255,255,255,.35);
  box-shadow:0 4px 16px rgba(0,0,0,.35);
}


</style>
</head>
<body>
<div class="poster" id="poster" role="img" aria-label="QR Kamar Tahanan - Scan untuk lihat data">
  <div class="title">
    <h1><?= html_escape(strtoupper($row->nama)) ?></h1>
    <p>SCAN UNTUK DATA KAMAR</p>
    <span class="subtitle">Menampilkan informasi &amp; daftar Penghuni WBP</span>
  </div>

  <div class="stack">
    <div class="pad" aria-hidden="true"></div>
    <div class="qr-card">
      <div class="qr-inner">
        <span class="corner tl" aria-hidden="true"></span>
        <span class="corner tr" aria-hidden="true"></span>
        <span class="corner br" aria-hidden="true"></span>
        <span class="corner bl" aria-hidden="true"></span>
        <div class="qr-fit">
          <img src="<?= $qr_url ?>" alt="QR Kamar <?= html_escape($row->nama) ?>">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="no-print">
  <button id="btnDownload">Download PNG</button>
</div>

<script src="<?php echo base_url("assets/js/canva.js") ?>"></script>

<script>
(function(){
  const btn = document.getElementById('btnDownload');
  const poster = document.getElementById('poster');

  btn.addEventListener('click', function(){
    btn.disabled = true;
    const oldText = btn.textContent;
    btn.textContent = 'Generating...';

    html2canvas(poster, {
      scale: 3,
      backgroundColor: '#ffffff',
      useCORS: true
    }).then(function(canvas){
      const dataURL = canvas.toDataURL('image/png');

      const a = document.createElement('a');
      a.href = dataURL;
      a.download = "QR-Kamar-<?= preg_replace('/[^A-Za-z0-9_-]+/','_', $row->nama) ?>.png";
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    }).catch(function(err){
      console.error('Gagal capture poster:', err);
      alert('Maaf, tidak bisa buat gambar otomatis.');
    }).finally(function(){
      btn.disabled = false;
      btn.textContent = oldText;
    });
  });
})();
</script>

</body>
</html>
