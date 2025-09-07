
let deferredPrompt = null;

function isAppInstalled() {
  return window.matchMedia("(display-mode: standalone)").matches
         || window.navigator.standalone === true; // iOS Safari
}

async function checkRelatedApps() {
  if ('getInstalledRelatedApps' in navigator) {
    try {
      const apps = await navigator.getInstalledRelatedApps();
      return apps.length > 0;
    } catch (e) {
      console.warn("⚠️ Gagal cek related apps:", e);
    }
  }
  return false;
}

// Sediakan fallback panduan iOS bila belum ada
(function ensureIOSGuide(){
  if (typeof window.showIOSInstallGuide === 'function') return;
  window.showIOSInstallGuide = function(e){
    if (e) e.preventDefault();
    const ua = navigator.userAgent || navigator.vendor || '';
    const isSafari = /^((?!chrome|android).)*safari/i.test(ua);
    if (!isSafari) {
      Swal.fire({
        title: 'Buka di Safari',
        html:
          '<p>Untuk menambahkan ke Layar Utama di iPhone/iPad, buka halaman ini di <b>Safari</b>.</p>' +
          '<ol style="text-align:left;max-width:520px;margin:0 auto">' +
          '<li>Ketuk ikon <b>Bagikan</b> (kotak dengan panah ke atas).</li>' +
          '<li>Pilih <b>Tambahkan ke Layar Utama</b>.</li>' +
          '<li>Ketuk <b>Tambahkan</b>.</li>' +
          '</ol>',
        icon: 'info'
      });
      return false;
    }
    Swal.fire({
      title: 'Instal ke iOS',
      html:
        '<ol style="text-align:left;max-width:520px;margin:0 auto">' +
        '<li>Ketuk ikon <b>Bagikan</b> (kotak dengan panah ke atas).</li>' +
        '<li>Gulir, pilih <b>Tambahkan ke Layar Utama</b>.</li>' +
        '<li>Ketuk <b>Tambahkan</b>.</li>' +
        '</ol>',
      icon: 'info'
    });
    return false;
  };
})();

function showInstallSwal() {
  Swal.fire({
    title: "Instal Aplikasi?",
    text: "Ingin menginstal aplikasi ini ke perangkat Anda?",
    icon: "info",
    showCancelButton: true,
    confirmButtonText: "Instal",
    cancelButtonText: "Nanti saja"
  }).then(async (t) => {
    if (t.isConfirmed && deferredPrompt) {
      deferredPrompt.prompt();
      const choice = await deferredPrompt.userChoice;
      if (choice && choice.outcome === "accepted") {
        Swal.fire("Berhasil!", "Aplikasi sedang diinstal.", "success");
        const b = document.getElementById("installButton");
        if (b) b.style.display = "none";
      } else {
        Swal.fire("Dibatalkan", "Anda membatalkan instalasi.", "info");
      }
      deferredPrompt = null;
    }
  });
}

async function setupInstallButton() {
  const installButton = document.getElementById("installButton");
  if (!installButton) return;

  const ua = navigator.userAgent || navigator.vendor || '';
  const isIOS = /iPad|iPhone|iPod/i.test(ua) || (ua.includes('Macintosh') && 'ontouchend' in document);

  // 1) Jika sudah terpasang / ada related app -> sembunyikan & selesai
  const relatedInstalled = await checkRelatedApps();
  if (isAppInstalled() || relatedInstalled) {
    installButton.style.display = "none";
    return;
  }

  // 2) Alur iOS (tidak ada beforeinstallprompt)
  if (isIOS) {
    installButton.style.display = "inline-block";
    installButton.addEventListener("click", (e) => {
      e.preventDefault();
      window.showIOSInstallGuide(e);
    });
    return; // penting: jangan pasang handler Android di bawah
  }

  // 3) Alur Android/Chrome (PWA prompt)
  window.addEventListener("beforeinstallprompt", (e) => {
    console.log("✅ beforeinstallprompt");
    e.preventDefault();
    deferredPrompt = e;
    sessionStorage.setItem("hasInstallPrompt", "true");
    installButton.style.display = "inline-block";
  });

  installButton.addEventListener("click", async (e) => {
    e.preventDefault();
    if (!deferredPrompt) {
      Swal.fire("Belum Siap", "Aplikasi belum bisa diinstal saat ini.", "warning");
      return;
    }
    // Langsung prompt, atau panggil showInstallSwal() bila ingin konfirmasi dulu
    deferredPrompt.prompt();
    const choice = await deferredPrompt.userChoice;
    if (choice && choice.outcome === "accepted") {
      Swal.fire("Berhasil!", "Aplikasi sedang diinstal.", "success");
      installButton.style.display = "none";
    } else {
      Swal.fire("Dibatalkan", "Anda membatalkan instalasi.", "info");
    }
    deferredPrompt = null;
  });

  window.addEventListener("appinstalled", () => {
    console.log("✅ App installed");
    installButton.style.display = "none";
    sessionStorage.removeItem("hasInstallPrompt");
    localStorage.removeItem("hasInstallPrompt");
  });

  if (sessionStorage.getItem("hasInstallPrompt") === "true") {
    installButton.style.display = "inline-block";
  }
}

document.addEventListener("DOMContentLoaded", setupInstallButton);

