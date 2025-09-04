const CACHE_NAME = 'sila-5';
const OFFLINE_URL = '/assets/offline.html';
const BASE_PATH = '/';

const urlsToCache = [
  '/', '/home','/hal/alur', '/booking', '/hal/kontak', 'hal/struktur','/hal/privacy_policy','/hal',
  '/developer/manifest?v=4',
  '/assets/offline.html',
  '/assets/admin/images/bg-login.mp4',
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
  '/assets/admin/js/aos.min.js',
  '/assets/admin/js/jspdf.umd.min.js',
  '/assets/admin/js/jspdf.plugin.autotable.min.js',
  '/assets/admin/fonts/fa-brands-400.woff2',
  '/assets/admin/fonts/fa-brands-400.woff',
  '/assets/admin/fonts/fa-brands-400.ttf',
  '/assets/admin/SliderCaptcha-master/src/disk/longbow.slidercaptcha.js',
  '/assets/admin/SliderCaptcha-master/src/disk/slidercaptcha.css',
  '/assets/admin/libs/chart-js/Chart.bundle.min.js',
  '/assets/admin/js/zxing-browser.min.js',
  '/assets/admin/chart/highcharts.js',
  '/assets/admin/chart/exporting.js',
  '/assets/admin/chart/export-data.js',
  '/assets/admin/chart/accessibility.js',
];

const cachedPaths = urlsToCache.map(url => url.split('?')[0]);

// INSTALL
self.addEventListener('install', event => {
  console.log('[SW] Installing...');
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('[SW] Caching static files...');
        return cache.addAll(urlsToCache);
      })
      .then(() => console.log('[SW] Caching complete ✅'))
      .catch(err => console.error('[SW] ❌ Caching failed:', err))
  );
});

// ACTIVATE
self.addEventListener('activate', event => {
  console.log('[SW] Activating...');
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys.map(key => {
          if (key !== CACHE_NAME) {
            console.log('[SW] Deleting old cache:', key);
            return caches.delete(key);
          }
        })
      )
    ).then(() => self.clients.claim())
  );
});

// FETCH
self.addEventListener('fetch', event => {
  const req = event.request;
  const url = new URL(req.url);

  if (req.method !== 'GET') return;

  const pathname = url.pathname.split('?')[0];

  // Images from /assets/images/
  if (pathname.startsWith(BASE_PATH + 'assets/images/')) {
    event.respondWith(
      caches.match(req).then(cached => {
        return cached || fetch(req).then(res => {
          if (res.ok) {
            const resClone = res.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(req, resClone));
          }
          return res;
        }).catch(() => caches.match(OFFLINE_URL));
      })
    );
    return;
  }

  // Cache-first for known paths
  if (cachedPaths.includes(pathname)) {
    event.respondWith(
      caches.match(req).then(cached => {
        if (cached) return cached;
        return fetch(req).then(res => {
          if (res && res.status === 200) {
            const resClone = res.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(req, resClone));
          }
          return res;
        }).catch(() => caches.match(OFFLINE_URL));
      })
    );
    return;
  }

  // Network-first fallback
  event.respondWith(
    fetch(req).catch(() =>
      caches.match(req).then(cached =>
        cached || (req.headers.get('accept')?.includes('text/html') ? caches.match(OFFLINE_URL) : null)
      )
    )
  );
});
