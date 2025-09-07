// === versi cache (ganti setiap update) ===
const CACHE_NAME = 'sila-9';
const OFFLINE_URL = '/assets/offline.html';

const urlsToCache = [
  '/', '/home', '/hal', '/hal/alur', '/hal/kontak', '/hal/struktur', '/hal/privacy_policy',
  '/developer/manifest?v=4',
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

// ===== helper normalisasi key (tanpa query & trailing slash) =====
const normKey = (reqOrUrl) => {
  const u = new URL(typeof reqOrUrl === 'string' ? reqOrUrl : reqOrUrl.url, self.location.origin);
  return (u.pathname.replace(/\/+$/, '') || '/');
};

// ===== INSTALL (best-effort, tidak gagal total) =====
self.addEventListener('install', (event) => {
  self.skipWaiting();
  const SKIP_BIG = /\.(mp4|mov|webm|zip|pdf)$/i;

  event.waitUntil((async () => {
    const cache = await caches.open(CACHE_NAME);
    await Promise.allSettled(
      urlsToCache.map(async (url) => {
        try {
          if (SKIP_BIG.test(url)) return;                 // skip file besar
          const res = await fetch(url, { cache: 'no-cache' });
          if (res && res.ok) await cache.put(normKey(url), res.clone());
        } catch (_) { /* jangan gagalkan install */ }
      })
    );
  })());
});

// ===== ACTIVATE (hapus cache lama & klaim klien) =====
self.addEventListener('activate', (event) => {
  event.waitUntil((async () => {
    const names = await caches.keys();
    await Promise.all(names.map((n) => n === CACHE_NAME ? null : caches.delete(n)));
    await self.clients.claim();
  })());
});

// ===== FETCH =====
self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return;

  const accept = req.headers.get('accept') || '';
  const key = normKey(req);
  const sameOrigin = new URL(req.url).origin === self.location.origin;

  // 1) Navigasi/HTML → network-first + fallback cache/offline
  if (req.mode === 'navigate' || accept.includes('text/html')) {
    event.respondWith((async () => {
      try {
        const fresh = await fetch(req);
        const c = await caches.open(CACHE_NAME);
        c.put(key, fresh.clone());
        return fresh;
      } catch (_) {
        return (await caches.match(key, { ignoreSearch: true })) ||
               (await caches.match('/', { ignoreSearch: true })) ||
               (await caches.match(OFFLINE_URL, { ignoreSearch: true })) ||
               new Response('Offline', { status: 503, headers: { 'Content-Type': 'text/plain' } });
      }
    })());
    return;
  }

  // 2) Aset same-origin → stale-while-revalidate (cepat dari cache, update di belakang)
  if (sameOrigin) {
    event.respondWith((async () => {
      const c = await caches.open(CACHE_NAME);
      const cached = await c.match(key, { ignoreSearch: true });
      const updating = fetch(req).then(res => {
        if (res && res.ok) c.put(key, res.clone());
        return res;
      }).catch(() => null);
      return cached || (await updating) || new Response('', { status: 504 });
    })());
    return;
  }

  // 3) Cross-origin → network-first, fallback cache kalau ada
  event.respondWith(fetch(req).catch(() => caches.match(key, { ignoreSearch: true })));
});
