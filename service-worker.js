/* =========================
   SILATURAHMI – Service Worker
   ========================= */

/** 👉 Ganti versi setiap rilis agar cache lama dibersihkan */
const APP      = 'sila';
const VERSION  = '17';                 // ⬅️ bump saat deploy
const STATIC_CACHE  = `${APP}-static-v${VERSION}`;
const RUNTIME_CACHE = `${APP}-runtime-v${VERSION}`;
const KEEP = [STATIC_CACHE, RUNTIME_CACHE];

/** Halaman offline/navigasi fallback (ubah jika home-mu berbeda) */
const OFFLINE_FALLBACK = '/';

/** File inti (app-shell) yang diprecache saat install */
const PRECACHE_URLS = [
  '/', '/home', '/hal', '/hal/alur', '/hal/kontak', '/hal/struktur', '/hal/privacy_policy',
  '/developer/manifest?v=7',
  '/assets/offline.html',

  '/assets/admin/js/jquery-3.1.1.min.js',
  '/assets/admin/js/vendor.min.js',
  '/assets/admin/js/app.min.js',
  '/assets/admin/css/bootstrap.min.css',
  '/assets/admin/css/aos.min.css',
  '/assets/admin/css/icons.min.css',
  '/assets/admin/css/app.min.css',
  '/assets/admin/libs/animate/animate.min.css',
  '/assets/admin/libs/datatables/dataTables.bootstrap4.css',
  '/assets/admin/libs/datatables/jquery.dataTables.min.js',
  '/assets/admin/libs/datatables/dataTables.bootstrap4.js',
  '/assets/admin/libs/dropify/dropify.min.css',
  '/assets/admin/libs/select2/select2.min.css',
  '/assets/admin/js/jquery.easyui.min.js',
  '/assets/admin/libs/dropify/dropify_peng.js',
  '/assets/admin/libs/sweetalert2/sweetalert2.min.js',
  '/assets/admin/libs/tippy-js/tippy.all.min.js',
  '/assets/admin/libs/jquery-toast/jquery.toast.min.js',
  '/assets/admin/js/sw.min.js',
  '/assets/admin/js/install.js',
  '/assets/admin/js/aos.min.js',
  '/assets/admin/js/jspdf.umd.min.js',
  '/assets/admin/js/jspdf.plugin.autotable.min.js',
  '/assets/admin/fonts/fa-brands-400.woff2',
  '/assets/admin/fonts/fa-brands-400.woff',
  '/assets/admin/fonts/fa-brands-400.ttf',
  '/assets/admin/SliderCaptcha-master/src/disk/longbow.slidercaptcha.js',
  '/assets/admin/SliderCaptcha-master/src/disk/slidercaptcha.css',
  '/assets/admin/js/zxing-browser.min.js',
  '/assets/admin/chart/highcharts.js',
  '/assets/admin/chart/exporting.js',
  '/assets/admin/chart/export-data.js',
  '/assets/admin/chart/accessibility.js',
];

/* Util: apakah same-origin? */
const sameOrigin = url => self.location.origin === url.origin;

/* ========== INSTALL ========== */
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(STATIC_CACHE).then(cache => cache.addAll(PRECACHE_URLS))
  );
  // langsung masuk waiting → biar bisa dipromosikan ke active via SKIP_WAITING
  self.skipWaiting();
});

/* ========== ACTIVATE (bersihkan cache lama) ========== */
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys
          .filter(k => k.startsWith(`${APP}-`) && !KEEP.includes(k))
          .map(k => caches.delete(k))
      )
    ).then(() => self.clients.claim())
  );
});

/* ========== FETCH ========== */
self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return; // jangan cache POST/PUT/… 

  const url = new URL(req.url);

  // 1) Navigasi/HTML → network-first (lebih cepat update konten), fallback offline
  const isNavigate = req.mode === 'navigate' || req.destination === 'document';
  if (isNavigate) {
    event.respondWith(
      fetch(req).catch(() =>
        caches.match(OFFLINE_FALLBACK).then(r => r || caches.match('/'))
      )
    );
    return;
  }

  // 2) Static assets same-origin (css, js, font, images) → stale-while-revalidate ringan
  const isStaticAsset =
    sameOrigin(url) &&
    ['style','script','font','image'].includes(req.destination);

  if (isStaticAsset) {
    event.respondWith((async () => {
      const cache = await caches.open(RUNTIME_CACHE);
      const cached = await cache.match(req, { ignoreVary: true, ignoreSearch: false });
      const fetchAndPut = fetch(req).then(resp => {
        // hanya simpan response OK (status 200) atau opaques dari CDN gambar/font
        if (resp && (resp.ok || resp.type === 'opaque')) {
          cache.put(req, resp.clone());
        }
        return resp;
      }).catch(() => cached); // kalau offline, gunakan yang ada
      // SWR: utamakan cache bila ada, sambil refresh di background
      return cached || fetchAndPut;
    })());
    return;
  }

  // 3) Lainnya (mis. API GET same-origin) → network-first agar selalu segar
  if (sameOrigin(url)) {
    event.respondWith((async () => {
      try {
        const resp = await fetch(req);
        const cache = await caches.open(RUNTIME_CACHE);
        if (resp && resp.ok) cache.put(req, resp.clone());
        return resp;
      } catch (err) {
        const cached = await caches.match(req);
        if (cached) return cached;
        throw err;
      }
    })());
    return;
  }

  // 4) Cross-origin: coba network, fallback cache bila ada
  event.respondWith(
    fetch(req).catch(() => caches.match(req))
  );
});

/* ========== MESSAGE (untuk tombol "Update tersedia") ========== */
self.addEventListener('message', (event) => {
  const data = event.data || {};
  if (data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
  if (data.type === 'CLEAR_ALL_CACHES') {
    event.waitUntil(
      caches.keys().then(keys => Promise.all(keys.map(k => caches.delete(k))))
    );
  }
});

/* (Opsional) bantu client tahu SW aktif & versinya */
async function broadcast(message) {
  const clients = await self.clients.matchAll({ includeUncontrolled: true });
  clients.forEach(c => c.postMessage(message));
}
broadcast({ type: 'SW_READY', version: VERSION }).catch(()=>{});