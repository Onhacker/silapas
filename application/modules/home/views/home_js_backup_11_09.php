
<script>
/* ===== Hero slider (tetap) ===== */
(function(){
  const track = document.getElementById('heroTrack');
  if(!track) return;
  const slides = Array.from(track.querySelectorAll('.pwa-hero__slide'));
  const btnPrev = document.querySelector('.pwa-hero__nav.prev');
  const btnNext = document.querySelector('.pwa-hero__nav.next');
  const dotsWrap = document.getElementById('heroDots');
  const N = slides.length;
  let i = 0, autoplay = null, userPaused = false, ticking = false;

  const dots = slides.map((_,idx)=>{
    const b = document.createElement('button');
    b.type = 'button';
    b.setAttribute('aria-label', `Ke slide ${idx+1}`);
    b.addEventListener('click', ()=>goTo(idx, true));
    dotsWrap.appendChild(b);
    return b;
  });

  function clamp(x){ return (x+N)%N; }
  function updateUI(idx){
    const atStart = idx===0, atEnd = idx===N-1;
    btnPrev.disabled = atStart; btnNext.disabled = atEnd;
    dots.forEach((d,k)=> d.setAttribute('aria-current', k===idx ? 'true':'false'));
  }

  function goTo(idx, fromUser=false){
    i = clamp(idx);
    const target = slides[i];
    track.scrollTo({left:target.offsetLeft, behavior:'smooth'});
    updateUI(i);
    if(fromUser) pauseAuto(6000);
    const next = slides[clamp(i+1)].querySelector('img');
    if(next && next.loading==='lazy'){ next.loading='eager'; }
  }

  function onScroll(){
    if(ticking) return; ticking = true;
    requestAnimationFrame(()=>{
      const sl = track.scrollLeft;
      let best = 0, dist = Infinity;
      for(let k=0;k<N;k++){
        const d = Math.abs(slides[k].offsetLeft - sl);
        if(d < dist){ dist=d; best=k; }
      }
      if(best !== i){ i = best; updateUI(i); }
      ticking = false;
    });
  }

  function startAuto(){ if(!autoplay && !userPaused) autoplay = setInterval(()=>goTo(i+1,false), 5000); }
  function stopAuto(){ if(autoplay){ clearInterval(autoplay); autoplay=null; } }
  let resumeTimer = null;
  function pauseAuto(ms=4000){
    stopAuto();
    if(resumeTimer) clearTimeout(resumeTimer);
    if(!userPaused) resumeTimer = setTimeout(()=> startAuto(), ms);
  }

  btnPrev.addEventListener('click', ()=>goTo(i-1,true));
  btnNext.addEventListener('click', ()=>goTo(i+1,true));
  track.addEventListener('scroll', onScroll, {passive:true});
  track.addEventListener('pointerenter', ()=> pauseAuto(1e6));
  track.addEventListener('pointerleave', ()=> { userPaused=false; startAuto(); });
  track.addEventListener('focusin', ()=> pauseAuto(1e6));
  track.addEventListener('focusout', ()=> { userPaused=false; startAuto(); });
  track.addEventListener('keydown', (e)=>{
    if(e.key==='ArrowRight'){ e.preventDefault(); goTo(i+1,true); }
    if(e.key==='ArrowLeft'){ e.preventDefault(); goTo(i-1,true); }
  });
  document.addEventListener('visibilitychange', ()=> document.hidden ? stopAuto() : startAuto());
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(entries=>{
      entries.forEach(en=>{ if(en.target===track){ en.isIntersecting ? startAuto() : stopAuto(); }});
    }, {threshold:.2});
    io.observe(track);
  }

  updateUI(0);
  const eager2 = slides[1]?.querySelector('img'); if(eager2) eager2.loading='eager';
  startAuto();
})();
</script>

<script>
/* ===== Quickmenu slider (tetap) ===== */
(function(){
  const scroller = document.getElementById('quickmenu');
  const btnL = document.querySelector('.quickmenu-btn.left');
  const btnR = document.querySelector('.quickmenu-btn.right');
  if (!scroller || !btnL || !btnR || scroller.dataset.inited) return;
  scroller.dataset.inited = "1";

  const STEP = () => Math.max(scroller.clientWidth * 0.9, 160);
  const atStart = () => scroller.scrollLeft <= 2;
  const atEnd   = () => scroller.scrollLeft + scroller.clientWidth >= scroller.scrollWidth - 2;

  function update() { btnL.disabled = atStart(); btnR.disabled = atEnd(); }
  function scrollByDir(dir) {
    scroller.scrollTo({ left: scroller.scrollLeft + dir * STEP(), behavior: 'smooth' });
  }

  btnL.addEventListener('click', () => scrollByDir(-1));
  btnR.addEventListener('click', () => scrollByDir(1));

  let ticking = false;
  scroller.addEventListener('scroll', () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => { update(); ticking = false; });
  }, { passive: true });
  window.addEventListener('resize', update);

  scroller.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') { e.preventDefault(); scrollByDir(1); }
    if (e.key === 'ArrowLeft')  { e.preventDefault(); scrollByDir(-1); }
  });

  update();
})();
</script>

<script>
/* ===== Feature list slider (baru; tidak mengubah fungsi lain) ===== */
(() => {
  const slider   = document.getElementById('featureSlider');
  if (!slider) return;

  const track    = slider.querySelector('.fs-track');
  const prevBtn  = slider.querySelector('.fs-nav.prev');
  const nextBtn  = slider.querySelector('.fs-nav.next');
  const dotsWrap = slider.querySelector('#featureDots');

  if (!track) return;

  const pageW    = () => track.clientWidth;
  const pages    = () => Math.max(1, Math.round(track.scrollWidth / pageW()));
  const curIndex = () => Math.round(track.scrollLeft / pageW());
  const clamp    = (n, a, b) => Math.max(a, Math.min(b, n));

  function goTo(i){
    const idx = clamp(i, 0, pages()-1);
    track.scrollTo({ left: idx * pageW(), behavior: 'smooth' });
    // setDot(idx);
  }

  prevBtn?.addEventListener('click', () => goTo(curIndex()-1));
  nextBtn?.addEventListener('click', () => goTo(curIndex()+1));

  // drag desktop
  let down=false, startX=0, startLeft=0;
  track.addEventListener('pointerdown', e => {
    down=true; startX=e.clientX; startLeft=track.scrollLeft;
    track.setPointerCapture(e.pointerId);
  });
  track.addEventListener('pointermove', e => {
    if (!down) return;
    track.scrollLeft = startLeft - (e.clientX - startX);
  });
  ['pointerup','pointercancel','mouseleave'].forEach(ev => track.addEventListener(ev, ()=> down=false));

  // sync
  let raf=0;
  track.addEventListener('scroll', () => {
    cancelAnimationFrame(raf);
    // raf = requestAnimationFrame(() => setDot(curIndex()));
  }, {passive:true});
  // new ResizeObserver(() => { buildDots(); setDot(curIndex()); }).observe(track);

  // buildDots(); setDot(curIndex());
})();
</script>
