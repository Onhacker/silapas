let deferredPrompt;

function isAppInstalled() {
  return window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone === true;
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

function showInstallSwal() {
  Swal.fire({
    title: "Instal Aplikasi?",
    text: "Ingin menginstal aplikasi ini ke perangkat Anda?",
    icon: "info",
    showCancelButton: true,
    confirmButtonText: "Instal",
    cancelButtonText: "Nanti saja",
    footer: '<div><input type="checkbox" id="dontShowAgain" /> Jangan tampilkan lagi peringatan ini</div>'
  }).then((t) => {
    if (t.isConfirmed && deferredPrompt) {
      deferredPrompt.prompt();
      deferredPrompt.userChoice.then((choice) => {
        if (choice.outcome === "accepted") {
          Swal.fire("Berhasil!", "Aplikasi sedang diinstal.", "success");
          document.getElementById("installButton").style.display = "none";
        } else {
          Swal.fire("Dibatalkan", "Anda membatalkan instalasi.", "info");
        }
        deferredPrompt = null;
      });
    }

    const check = document.getElementById("dontShowAgain");
    if (check && check.checked) {
      localStorage.setItem("dontShowInstallSwal", "true");
    }
  });
}

async function setupInstallButton() {
  const installButton = document.getElementById("installButton");
  if (!installButton) return;

  const relatedInstalled = await checkRelatedApps();

  if (isAppInstalled() || relatedInstalled) {
    installButton.style.display = "none";
    return;
  }

  // Jika sudah pernah muncul prompt sebelumnya, tampilkan tombol
  if (localStorage.getItem("hasInstallPrompt") === "true") {
    installButton.style.display = "inline-block";
  }

  window.addEventListener("beforeinstallprompt", (e) => {
    console.log("✅ Event beforeinstallprompt fired");
    e.preventDefault();
    deferredPrompt = e;

    localStorage.setItem("hasInstallPrompt", "true");
    installButton.style.display = "inline-block";

    if (localStorage.getItem("dontShowInstallSwal") !== "true") {
      showInstallSwal();
    }
  });

  installButton.addEventListener("click", () => {
    console.log("Install button clicked");
    if (deferredPrompt) {
      deferredPrompt.prompt();
      deferredPrompt.userChoice.then((choice) => {
        if (choice.outcome === "accepted") {
          Swal.fire("Berhasil!", "Aplikasi sedang diinstal.", "success");
          installButton.style.display = "none";
        } else {
          Swal.fire("Dibatalkan", "Anda membatalkan instalasi.", "info");
        }
        deferredPrompt = null;
      });
    } else {
      Swal.fire("Belum Siap", "Aplikasi belum bisa diinstal saat ini.", "warning");
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  setupInstallButton();
});
