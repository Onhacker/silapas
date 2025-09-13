<?php
$cycle   = isset($cycle) ? (int)$cycle : 20;
$dashUrl = $dashboard_url ?? site_url('admin_dashboard/dashboard_partial');
$monUrl  = $monitor_url   ?? site_url('admin_dashboard/monitor_partial');
?>
<style>
  /* Area rotator */
  .rotor-wrap{ position:relative; height:calc(100vh - 140px); background:transparent; }
  .rotor-frame{
    position:absolute; inset:0; width:100%; height:100%; border:0;
    opacity:0; pointer-events:none; transition:opacity .4s ease;
    background:#fff; /* card putih tetap kontras */
  }
  .rotor-frame.active{ opacity:1; pointer-events:auto; }

  /* Latar hitam saat container fullscreen */
  #rotor:fullscreen{ background:#0b1220 !important; }
  /* Gelapkan juga dokumen induk saat fullscreen */
  html.fs-dark, html.fs-dark body{ background:#0b1220 !important; }

  /* Bullet/tab kecil, tampil hanya saat fullscreen */
  .fs-dots{
    position:fixed; left:50%; bottom:18px; transform:translateX(-50%);
    display:none; gap:10px; z-index:9999;
  }
  #rotor:fullscreen + .fs-dots{ display:flex; }
  .fs-dot{
    width:10px; height:10px; border-radius:999px; border:0; cursor:pointer;
    background:#64748b; opacity:.6; transition:transform .2s, opacity .2s;
  }
  .fs-dot.active{ background:#e5e7eb; opacity:1; transform:scale(1.15); }

  /* Badge “Live” */
  .badge-dot{display:inline-flex;align-items:center;gap:.4rem}
  .badge-dot::before{content:"";width:8px;height:8px;border-radius:50%;background:#22c55e;
    box-shadow:0 0 0 0 rgba(34,197,94,.55);animation:livePing 1.25s cubic-bezier(0,0,.2,1) infinite}
  @keyframes livePing{0%{box-shadow:0 0 0 0 rgba(34,197,94,.55)}80%{box-shadow:0 0 0 10px rgba(34,197,94,0)}100%{box-shadow:0 0 0 0 rgba(34,197,94,0)}}
</style>

<div class="container-fluid">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div>
      <h4 class="mb-0"><?= htmlspecialchars($title ?? 'Wallboard', ENT_QUOTES, 'UTF-8') ?></h4>
      <div class="text-muted small"><?= htmlspecialchars($subtitle ?? 'Dashboard ↔ Monitor', ENT_QUOTES, 'UTF-8') ?></div>
    </div>
    <div class="rotor-toolbar">
      <span class="badge-dot small">Live</span>
      <button id="btnPrev"  class="btn btn-sm btn-outline-secondary" type="button">« Sebelumnya</button>
      <button id="btnNext"  class="btn btn-sm btn-outline-secondary" type="button">Berikutnya »</button>
      <button id="btnPause" class="btn btn-sm btn-outline-primary"   type="button" title="Jeda/lanjut">Jeda</button>
      <button id="btnFS"    class="btn btn-sm btn-outline-dark"      type="button" title="Fullscreen">
        <i class="mdi mdi-fullscreen"></i> Fullscreen
      </button>
    </div>
  </div>

  <div class="rotor-wrap" id="rotor">
    <iframe id="frame0" class="rotor-frame active" src="<?= $dashUrl ?>" title="Dashboard"></iframe>
    <iframe id="frame1" class="rotor-frame"         src="<?= $monUrl  ?>" title="Monitor"></iframe>
  </div>
  <div id="dots" class="fs-dots" aria-label="Navigasi slide"></div>
</div>

<script>
(function(){
  const wrap    = document.getElementById('rotor');
  const frames  = Array.from(wrap.querySelectorAll('.rotor-frame'));
  const dots    = document.getElementById('dots');
  const btnPrev = document.getElementById('btnPrev');
  const btnNext = document.getElementById('btnNext');
  const btnPause= document.getElementById('btnPause');
  const btnFS   = document.getElementById('btnFS');

  const CYCLE_MS = <?= $cycle ?> * 1000;
  let idx = 0, paused = false, iv = null;

  function renderDots(){
    dots.innerHTML = frames.map((_,i)=>
      `<button class="fs-dot ${i===idx?'active':''}" data-i="${i}" aria-label="Slide ${i+1}"></button>`
    ).join('');
  }

  function reflowInside(frame){
    try{
      const cw = frame.contentWindow;
      if (cw && cw.Highcharts && Array.isArray(cw.Highcharts.charts)) {
        cw.Highcharts.charts.filter(Boolean).forEach(c => c.reflow && c.reflow());
      }
    }catch(e){}
  }

  // suntik kelas gelap ke HTML di dalam iframe (same-origin)
  function setInnerDark(frame, on){
    try{
      const doc = frame.contentWindow && frame.contentWindow.document;
      if (doc) doc.documentElement.classList.toggle('fs-dark', !!on);
      reflowInside(frame);
    }catch(e){}
  }

  function show(i){
    idx = (i + frames.length) % frames.length;
    frames.forEach((f,k)=> f.classList.toggle('active', k===idx));
    renderDots();
    setInnerDark(frames[idx], !!document.fullscreenElement);
  }

  function next(){ show(idx+1); }
  function prev(){ show(idx-1); }

  function start(){ stop(); iv = setInterval(()=>{ if(!paused) next(); }, CYCLE_MS); }
  function stop(){ if (iv) { clearInterval(iv); iv = null; } }

  // Controls
  btnNext.addEventListener('click', ()=>{ paused=false; next(); start(); });
  btnPrev.addEventListener('click', ()=>{ paused=false; prev(); start(); });
  btnPause.addEventListener('click', (e)=>{ paused=!paused; e.currentTarget.textContent = paused?'Lanjut':'Jeda'; });

  dots.addEventListener('click', (e)=>{
    const b = e.target.closest('.fs-dot'); if(!b) return;
    paused=false; show(+b.dataset.i); start();
  });

  // Fullscreen container rotator
  btnFS.addEventListener('click', async ()=>{
    try{
      if (!document.fullscreenElement){
        await wrap.requestFullscreen({navigationUI:'hide'});
        btnFS.innerHTML = '<i class="mdi mdi-fullscreen-exit"></i> Exit Fullscreen';
      } else {
        await document.exitFullscreen();
        btnFS.innerHTML = '<i class="mdi mdi-fullscreen"></i> Fullscreen';
      }
    }catch(e){}
  });

  // Saat masuk/keluar fullscreen
  document.addEventListener('fullscreenchange', ()=>{
    const on = !!document.fullscreenElement;
    document.documentElement.classList.toggle('fs-dark', on);
    setInnerDark(frames[idx], on);
    start(); // reset interval biar “bangun”
  });

  // Pause saat tab pindah; resume saat kembali
  document.addEventListener('visibilitychange', ()=> { paused = document.hidden; });

  // Hover pause (opsional)
  wrap.addEventListener('mouseenter', ()=> paused=true);
  wrap.addEventListener('mouseleave', ()=> paused=false);

  // Init
  renderDots(); show(0); start();
})();
</script>
