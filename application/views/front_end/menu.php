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

    function isMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    const isAdmin = <?= $this->session->userdata("admin_login") ? 'true' : 'false' ?>;

    if (isAdmin && !isMobile()) {
        fetch("<?= site_url("api/get_menu_desktop?uri=" . $uri) ?>&t=" + new Date().getTime())
            .then(res => res.json())
            .then(data => {
                container.innerHTML = data.menu;
                console.log("✅ Menu dinamis dimuat dari server (desktop)");
            })
            .catch(() => {
                container.innerHTML = "<li><em>Gagal memuat menu dinamis</em></li>";
            });
    } else {
        container.innerHTML = "";
        console.log("ℹ️ Mobile device atau non-admin, tidak memuat menu dinamis");
    }
});
</script>

