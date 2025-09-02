<?php $uri = $this->uri->uri_string(); ?>
<style>
    .active-menu > a {
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
    font-weight: bold;
    }

    .has-submenu a {
        transition: text-shadow 0.3s ease-in-out;
    }

    .has-submenu a:hover {
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
        font-weight: bold;
    }


</style>
<div id="navigation">
    <ul class="navigation-menu">
        <li class="has-submenu <?= ($uri == '') ? 'active-menu' : '' ?>">
            <a href="<?= site_url("home"); ?>"><i class="fe-airplay"></i> Home</a>
        </li>
    </ul>
    <ul id="menu-dynamic" class="navigation-menu"></ul>
    <?php $this->load->view("front_end/menu_static"); ?>
    <div class="clearfix"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById("menu-dynamic");
  const quickDataLink = document.getElementById("quick-data-link");
  const quickDataCard = document.getElementById("quick-data-card");

  function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  }

  const isAdmin = <?= $this->session->userdata("admin_login") ? 'true' : 'false' ?>;

  // helper: update Quick Link "Data" berdasarkan HTML menu server
  function applyQuickLinkData(menuHTML) {
    try {
      // Bungkus sebagai <ul> agar DOMParser mudah cari <li>/<a>
      const parser = new DOMParser();
      const doc = parser.parseFromString(`<ul>${menuHTML}</ul>`, "text/html");

      // Cari item menu "admin_permohonan"
      const link = doc.querySelector('a[href*="/admin_permohonan"]');
      if (!link) {
        // Tidak punya akses -> sembunyikan kartu
        quickDataLink.style.display = "none";
        return;
      }

      // Sinkronkan href (jaga-jaga jika base_url berubah)
      quickDataLink.href = link.getAttribute("href");

      // Tandai aktif (opsional, sesuai class di build_menu)
      const li = link.closest("li");
      const isActive = li && li.classList.contains("active-menu");
      quickDataCard.classList.toggle("active", !!isActive);
    } catch (e) {
      console.warn("Gagal mem-parsing menu untuk quick link:", e);
    }
  }

  if (isAdmin && !isMobile()) {
    fetch("<?= site_url("api/get_menu_desktop?uri=" . $uri) ?>&t=" + Date.now())
      .then(res => res.json())
      .then(data => {
        container.innerHTML = data.menu;                 // render menu di header/sidebar
        applyQuickLinkData(data.menu);                   // sinkronkan kartu Data
        console.log("✅ Menu dinamis dimuat & quick link sinkron");
      })
      .catch(() => {
        container.innerHTML = "<li><em>Gagal memuat menu dinamis</em></li>";
        // fallback: tampilkan kartu Data default
        quickDataLink.style.display = "";
        console.log("⚠️ Gagal fetch menu; pakai quick link default");
      });
  } else {
    container.innerHTML = "";
    // untuk mobile / non-admin: bebas pilih
    // quickDataLink.style.display = "none"; // kalau mau sembunyikan di mobile
    console.log("ℹ️ Mobile atau non-admin, tidak memuat menu dinamis");
  }
});
</script>
