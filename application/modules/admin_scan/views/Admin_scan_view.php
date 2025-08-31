<style>
  /* kamera + guide box */
  #cameraWrap{position:relative}
  #cameraWrap .guide{position:absolute;inset:0;display:grid;place-items:center;pointer-events:none}
  #cameraWrap .guide .box{width:40%;aspect-ratio:1/1;border:2px solid rgba(255,255,255,.7);border-radius:12px}

  /* result styles */
  #resultBox{background:#f8fafc;min-height:160px;border-radius:8px}
  .rbody{padding:4px 0;text-transform:none}
  .is-checkin{color:#16a34a}   /* hijau */
  .is-checkout{color:#dc2626}  /* merah */
</style>

<div class="container-fluid">
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><?= htmlspecialchars($title ?? 'Scan QR') ?></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($subtitle ?? 'Check-in / Checkout') ?></li>
          </ol>
        </div>
        <h4 class="page-title"><?= htmlspecialchars($subtitle ?? 'Check-in / Checkout') ?></h4>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- KAMERA -->
    <div class="col-lg-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <div id="cameraWrap" class="mb-2">
            <video id="preview" autoplay muted playsinline style="width:100%;border-radius:12px;background:#000;aspect-ratio:16/9;"></video>
            <div class="guide"><div class="box"></div></div>
          </div>

          <div class="d-flex flex-wrap" style="gap:.5rem;">
            <select id="cameraSelect" class="form-control" style="max-width:320px"></select>
            <button id="btnStart" class="btn btn-primary"><i class="mdi mdi-play"></i> Mulai</button>
            <button id="btnStop"  class="btn btn-outline-secondary" disabled><i class="mdi mdi-stop"></i> Stop</button>
            <button id="btnFlip"  class="btn btn-outline-info"><i class="mdi mdi-camera-switch"></i> Flip</button>
            <button id="btnTorch" class="btn btn-outline-warning" disabled><i class="mdi mdi-flashlight"></i> Senter</button>

            <!-- Mode Scan (radio) -->
            <div class="form-inline ml-sm-2">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="modeCheckin" name="scanMode" value="checkin" class="custom-control-input" checked>
                <label class="custom-control-label" for="modeCheckin">Check-in</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="modeCheckout" name="scanMode" value="checkout" class="custom-control-input">
                <label class="custom-control-label" for="modeCheckout">Checkout</label>
              </div>
            </div>
          </div>

          <div class="form-group mt-3 mb-0">
            <label class="small text-muted mb-1">Fallback (scanner gun / manual)</label>
            <div class="input-group">
              <input type="text" id="kodeManual" class="form-control" placeholder="Tempel/ketik kode booking lalu Enter">
              <div class="input-group-append">
                <button class="btn btn-outline-primary" id="btnManual">Kirim</button>
              </div>
            </div>
            <small class="text-muted">Format: sama seperti pada QR (contoh: <em>20250827-U1-opd-12-123</em>).</small>
          </div>
        </div>
      </div>
    </div>

    <!-- HASIL -->
    <div class="col-lg-5 mt-3 mt-lg-0">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="mb-2"><i class="mdi mdi-shield-check-outline"></i> Tips</h6>
          <ul class="mb-0 pl-3">
            <li>Gunakan pencahayaan cukup. Aktifkan <b>Senter</b> bila tersedia.</li>
            <li>Jarak kamera ±15–25 cm, sejajarkan QR dalam frame.</li>
            <li>Untuk barcode gun, fokuskan kursor di kolom input lalu scan.</li>
          </ul>
        </div>
      </div>

      <div class="card shadow-sm mt-3">
        <div class="card-body">
          <h6 class="mb-2"><i class="mdi mdi-information-outline"></i> Hasil</h6>
          <div id="resultBox" class="p-3">
            <div class="text-muted">Belum ada hasil.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ZXing -->
<script src="https://unpkg.com/@zxing/browser@0.1.5/umd/zxing-browser.min.js"></script>

<!-- SFX: Suara untuk check-in / checkout (tanpa vibrate) -->
<script>
let audioCtx;
function initAudio(){
  if (!audioCtx) {
    const AC = window.AudioContext || window.webkitAudioContext;
    if (AC) audioCtx = new AC();
  }
}
function playTone(freq=880, durMs=180){
  if (!audioCtx) return;
  const ctx = audioCtx;
  const osc = ctx.createOscillator();
  const gain = ctx.createGain();
  osc.type = 'sine';
  osc.frequency.setValueAtTime(freq, ctx.currentTime);
  gain.gain.setValueAtTime(0.0001, ctx.currentTime);
  osc.connect(gain).connect(ctx.destination);
  osc.start();

  // Attack cepat lalu release
  gain.gain.exponentialRampToValueAtTime(0.2, ctx.currentTime + 0.02);
  gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + durMs/1000);

  osc.stop(ctx.currentTime + durMs/1000 + 0.02);
}
function sfx(kind){
  if (kind === 'checkin')       playTone(880, 180);     // A5
  else if (kind === 'checkout') playTone(523.25, 180);  // C5
  else if (kind === 'error')    playTone(200, 220);
}
</script>

<script>
  // Ambil mode dari radio
  function getScanMode(){
    const el = document.querySelector('input[name="scanMode"]:checked');
    return (el ? el.value : 'checkin');
  }

  (function(){
    const { BrowserMultiFormatReader, BrowserCodeReader } = ZXingBrowser;
    const reader    = new BrowserMultiFormatReader();

    const video     = document.getElementById('preview');
    const sel       = document.getElementById('cameraSelect');
    const btnStart  = document.getElementById('btnStart');
    const btnStop   = document.getElementById('btnStop');
    const btnFlip   = document.getElementById('btnFlip');
    const btnTorch  = document.getElementById('btnTorch');
    const kodeManual= document.getElementById('kodeManual');
    const btnManual = document.getElementById('btnManual');
    const resultBox = document.getElementById('resultBox');

    let controls = null;
    let facing   = 'environment';
    let torchTrack = null;

    function setResult(html, ok){
      resultBox.innerHTML = html;
      resultBox.style.background = ok ? '#ecfdf5' : '#fff7ed'; // hijau muda saat ok, oranye muda saat error
    }
    function isSecureOk(){
      return window.isSecureContext || ['localhost','127.0.0.1'].includes(location.hostname);
    }
    function setMirror(isFront){
      video.style.transform = isFront ? 'scaleX(-1)' : 'none';
    }

    async function setupTorch(){
      for (let i=0;i<25;i++){
        if (video.srcObject) break;
        await new Promise(r=>setTimeout(r,120));
      }
      const stream = video.srcObject;
      if (!stream) { btnTorch.disabled = true; return; }
      torchTrack = stream.getVideoTracks()[0];
      const caps = (torchTrack.getCapabilities && torchTrack.getCapabilities()) || {};
      btnTorch.disabled = !caps.torch;
    }

    async function listCameras(){
      let devices = [];
      if (BrowserCodeReader && BrowserCodeReader.listVideoInputDevices) {
        devices = await BrowserCodeReader.listVideoInputDevices();
      } else if (navigator.mediaDevices?.enumerateDevices) {
        devices = (await navigator.mediaDevices.enumerateDevices()).filter(d=>d.kind==='videoinput');
      }
      sel.innerHTML = '';
      devices.forEach((d, i)=>{
        const opt = document.createElement('option');
        opt.value = d.deviceId;
        opt.textContent = d.label || `Kamera ${i+1}`;
        sel.appendChild(opt);
      });
      const last = localStorage.getItem('scan.camId');
      if (last && [...sel.options].some(o=>o.value===last)) sel.value = last;
    }

    async function startScan(deviceId){
      stopScan();
      if (!isSecureOk()){
        setResult(`<div class="text-danger rbody"><b>Kamera diblokir:</b> akses via <b>HTTPS</b> atau <code>localhost</code>.</div>`);
        return;
      }
      try{
        const byDevice = !!deviceId;
        const constraints = byDevice
          ? { audio:false, video:{ deviceId: { exact: deviceId } } }
          : { audio:false, video:{ facingMode:{ ideal: facing }, width:{ ideal:1280 }, height:{ ideal:720 } } };

        setMirror(!byDevice && facing === 'user');

        controls = await reader.decodeFromConstraints(constraints, video, (res, err)=>{
          if (res && res.text){
            const code = (res.text || '').trim();
            stopScan();
            doAction(code);
          }
        });

        btnStop.disabled = false;
        await listCameras();
        await setupTorch();
        try { await video.play(); } catch(e){}
      }catch(e){
        console.error(e);
        setResult(`<div class="text-danger rbody"><b>Gagal akses kamera:</b> ${e.message || e}</div>`);
      }
    }

    function stopScan(){
      btnStop.disabled = true;
      if (controls && controls.stop) controls.stop();
      controls = null;
      if (video.srcObject){
        video.srcObject.getTracks().forEach(t=>t.stop());
        video.srcObject = null;
      }
      btnTorch.disabled = true;
    }

    function toggleTorch(){
      try{
        if (!torchTrack) return;
        const cur = torchTrack.getSettings && torchTrack.getSettings().torch;
        torchTrack.applyConstraints({ advanced:[{torch: !cur}] });
      }catch(e){}
    }

    // Kirim ke endpoint sesuai mode (radio)
    function doAction(kode){
      const mode = getScanMode(); // <-- ambil dari radio
      const endpoint = mode === 'checkout'
        ? '<?= site_url('admin_scan/checkout_api') ?>'
        : '<?= site_url('admin_scan/checkin_api') ?>';

      const m = (kode||'').match(/[A-Za-z0-9_\-]+/g);
      if (!m){ sfx('error'); setResult(`<div class="text-danger rbody">Kode tidak valid.</div>`); return; }
      const clean = m.join('');
      setResult(`<div class="rbory">Memproses <b>${mode}</b>: <b>${clean}</b>...</div>`); // tetap normal case

      const params = new URLSearchParams();
      params.set('kode', clean);
      <?php if (config_item('csrf_protection')): ?>
        params.set('<?= $this->security->get_csrf_token_name() ?>','<?= $this->security->get_csrf_hash() ?>');
      <?php endif; ?>

      fetch(endpoint, {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: params.toString(),
        credentials:'same-origin'
      })
      .then(r=>r.json()).then(j=>{
        if (j.ok){
          const d          = j.data || {};
          const isCheckout = (mode === 'checkout');
          const statusText = d.status ? `<div class="rbory">Status: <b>${d.status}</b></div>` : '';
          const petugas    = isCheckout ? (d.petugas_checkout || '-') : (d.petugas_checkin || '-');

          // SUARA: sukses (beda nada)
          sfx(isCheckout ? 'checkout' : 'checkin');

          setResult(`
            <div class="rboy ${isCheckout ? 'is-checkout' : 'is-checkin'}" style="text-transform:none;">
              <h5 class="mb-1" style="text-transform:none;">
                ✔ ${isCheckout ? 'Checkout' : 'Check-in'} berhasil
              </h5>
              <div class="rbory">Kode: <b>${d.kode || '-'}</b></div>
              <div class="rbory">Nama: <b>${d.nama || '-'}</b></div>
              <div class="rbory">Waktu: <b>${(d.checkin_at || d.checkout_at || '-')}</b></div>
              <div class="rbory">Petugas: <b>${petugas}</b></div>
              ${statusText}
              ${j.already ? '<div class="mt-1 text-warning rbody">Aksi ini sudah pernah dilakukan.</div>' : ''}
              <div class="mt-2 d-flex flex-wrap" style="gap:.5rem;">
                ${j.detail_url ? `<a class="btn btn-sm btn-outline-primary" href="${j.detail_url}" target="_blank" rel="noopener"><i class="mdi mdi-open-in-new"></i> Buka Detail Booking</a>` : ''}
                <button class="btn btn-sm btn-outline-secondary" id="btnScanAgain"><i class="mdi mdi-qrcode-scan"></i> Scan lagi</button>
              </div>
            </div>
          `, true);

          const btnAgain = document.getElementById('btnScanAgain');
          if (btnAgain) btnAgain.addEventListener('click', ()=> { initAudio(); startScan(sel.value || null); });

        } else {
          // SUARA: error
          sfx('error');
          setResult(`<div class="text-danger rbody"><b>Gagal:</b> ${j.msg || 'Tidak diketahui'}</div>`);
          setTimeout(()=>startScan(sel.value || null), 1200);
        }
      })
      .catch(err=>{
        sfx('error');
        setResult(`<div class="text-danger rbody"><b>Error:</b> ${err && err.message ? err.message : err}</div>`);
        setTimeout(()=>startScan(sel.value || null), 1200);
      });
    }

    // UI handlers (panggil initAudio agar audio unlocked)
    btnStart.addEventListener('click', ()=> { initAudio(); startScan(sel.value || null); });
    btnStop .addEventListener('click', stopScan);
    btnFlip .addEventListener('click', ()=>{ initAudio(); facing = (facing==='environment' ? 'user' : 'environment'); setMirror(facing === 'user'); startScan(null); });
    btnTorch.addEventListener('click', toggleTorch);
    btnManual.addEventListener('click', ()=> { initAudio(); doAction(kodeManual.value); });
    kodeManual.addEventListener('keydown', (e)=>{ if (e.key==='Enter'){ initAudio(); doAction(kodeManual.value); }});
    sel.addEventListener('change', ()=>{
      localStorage.setItem('scan.camId', sel.value);
      setMirror(false);
      startScan(sel.value);
    });

    // init
    listCameras();
  })();
</script>
