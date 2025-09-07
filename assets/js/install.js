let deferredPrompt = null;

function isAppInstalled() {
  return window.matchMedia("(display-mode: standalone)").matches
         || window.navigator.standalone === true; // iOS Safari
}
function isIOSUA() {
  const ua = navigator.userAgent || navigator.vendor || '';
  return /iPad|iPhone|iPod/i.test(ua) || (ua.includes('Macintosh') && 'ontouchend' in document);
}

/* Fallback panduan iOS (A2HS) */
(function ensureIOSGuide(){
  if (typeof window.showIOSInstallGuide === 'function') return;
  window.showIOSInstallGuide = function(e){
    if (e) e.preventDefault();
    const ua = navigator.userAgent || navigator.vendor || '';
    const isSafari = /^((?!chrome|android|crios|fxios).)*safari/i.test(ua);

    const show = (title, html, icon) => {
      if (window.Swal) Swal.fire({title, html, icon});
      else alert(title.replace(/<[^>]+>/g,'') + '\n\n' + html.replace(/<[^>]+>/g,''));
    };

    if (!isSafari) {
      show('Buka di Safari',
        '<p>Untuk menambahkan ke Layar Utama di iPhone/iPad, buka halaman ini di <b>Safari</b>.</p>' +
        '<ol style="text-align:left;max-width:520px;margin:0 auto">' +
        '<li>Ketuk ikon <b>Bagikan</b> (kotak dengan panah ke atas).</li>' +
        '<li>Pilih <b>Tambahkan ke Layar Utama</b>.</li>' +
        '<li>Ketuk <b>Tambahkan</b>.</li>' +
        '</ol>',
        'info'
      );
      return false;
    }
    show('Instal ke iOS',
      '<ol style="text-align:left;max-width:520px;margin:0 auto">' +
      '<li>Ketuk ikon <b>Bagikan</b> (kotak dengan panah ke atas).</li>' +
      '<li>Gulir, pilih <b>Tambahkan ke Layar Utama</b>.</li>' +
      '<li>Ketuk <b>Tambahkan</b>.</li>' +
      '</ol>',
      'info'
    );
    return false;
  };
})();

/* SIMPAN event, jangan prompt otomatis */
window.addEventListener("beforeinstallprompt", (e) => {
  e.preventDefault();
  deferredPrompt = e;
  console.log("✅ beforeinstallprompt ditangkap (siap saat user klik badge).");
});

/* Notifikasi jika sudah standalone (sekali per sesi tab) */
document.addEventListener("DOMContentLoaded", () => {
  if (isAppInstalled() && !sessionStorage.getItem("shownStandaloneNotice")) {
    if (window.Swal) Swal.fire("Aplikasi Sudah Terinstal","Anda sedang menjalankan aplikasi dalam mode mandiri (standalone).","info");
    else alert("Aplikasi Sudah Terinstal - Anda sedang menjalankan aplikasi dalam mode mandiri (standalone).");
    sessionStorage.setItem("shownStandaloneNotice","1");
  }

  /* Klik badge iOS/PWA → baru tampilkan prompt/panduan */
  const installButton = document.getElementById("installButton");
  if (!installButton) return;
  installButton.addEventListener("click", async (e) => {
    e.preventDefault();

    // Jika sudah terpasang/standalone → beri peringatan (tombol tetap tidak disembunyikan)
    if (isAppInstalled()) {
      if (window.Swal) Swal.fire("Aplikasi Sudah Terinstal","Aplikasi sudah berjalan dalam mode mandiri (standalone).","info");
      else alert("Aplikasi Sudah Terinstal - Aplikasi sudah berjalan dalam mode mandiri (standalone).");
      return;
    }

    // iOS: panduan A2HS (tidak ada beforeinstallprompt)
    if (isIOSUA()) {
      return window.showIOSInstallGuide(e);
    }

    // Android/Chrome: gunakan deferredPrompt jika tersedia
    if (!deferredPrompt) {
      if (window.Swal) Swal.fire("Belum Siap","Aplikasi belum bisa diinstal saat ini (syarat PWA belum terpenuhi).","warning");
      else alert("Belum Siap - Aplikasi belum bisa diinstal saat ini.");
      return;
    }

    deferredPrompt.prompt();
    const choice = await deferredPrompt.userChoice;
    if (choice && choice.outcome === "accepted") {
      if (window.Swal) Swal.fire("Berhasil!","Aplikasi sedang diinstal.","success");
      else alert("Berhasil! Aplikasi sedang diinstal.");
    } else {
      if (window.Swal) Swal.fire("Dibatalkan","Anda membatalkan instalasi.","info");
      else alert("Dibatalkan - Anda membatalkan instalasi.");
    }
    deferredPrompt = null;
  });
});

/* Event saat terinstal */
window.addEventListener("appinstalled", () => {
  console.log("✅ App installed");
  if (window.Swal) Swal.fire("Terpasang","Aplikasi berhasil diinstal.","success");
  else alert("Aplikasi berhasil diinstal.");
});

/* Fallback agar onclick="openPlayStore(event)" tidak error */
function openPlayStore(e){ return true; }
