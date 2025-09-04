<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Developer extends MX_Controller {
	function __construct(){
		parent::__construct();
        $this->output->set_header("X-Robots-Tag: noindex, nofollow", true);
	}

	function index(){
        echo "
        * @Engine   CodeIgniter<br>
        * @Database Mysqli<br>
        * @author   Baso Irwan Sakti<br>
        * @license  Onhacker<br>
        * @since    Version 1.0.0<br>
        * @filesource<br>
        ";
    }

    function manifest(){
        header('Content-Type: application/json');
        $manifest = [
            "id" => "/",
            "name" => "Silaturahmi Makassar",
            "short_name" => "Silaturahmi Makassar",
            "start_url" => site_url("/home"),
            "scope"      => "/",
            "display" => "standalone",
            "display_override" => ["window-controls-overlay", "standalone"],
            "background_color"=> "#ffffff",   
            "theme_color"=> "#0f172a",        
            "icons" => [
                [
                    "src" => site_url("/assets/images/icon_appx.png"),
                    "sizes" => "192x192",
                    "type" => "image/png",
                    "purpose" => "any",
                    "label" => "Icon 192x192"
                ],
                [
                    "src" => site_url("/assets/images/maskable-icon_new.png"),
                    "sizes" => "512x512",
                    "type" => "image/png",
                    "purpose" => "any",
                    "label" => "Icon 512x512"
                ],
            ],
            "description" => "Silaturahmi Makassar merupakan platform digital layanan tamu resmi antar instansi yang humanis, modern, dan terintegrasi untuk mendukung pengelolaan kunjungan tamu di Lapas Kelas I Makassar.",
            "developer" => [
                "name" => "PT. MVIN",
                "url" => "https://mediaverse.com"
            ],
            "permissions" => [
                "notifications"
            ],
            "splash_pages" => [
                [
                    "src" => site_url("/assets/images/logo.png"),
                    "sizes" => "640x1136",
                    "type" => "image/png"
                ]
            ],
            "screenshots" => [
                [
                    "src" => site_url("/assets/images/screenshot-desktop.png"),
                    "sizes" => "1280x720",
                    "type" => "image/png",
                    "form_factor" => "wide"
                ],
                [
                    "src" => site_url("/assets/images/screenshot-mobile.png"),
                    "sizes" => "360x640",
                    "type" => "image/png"
                ]
            ]
        ];

        echo json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    }

    public function service_worker()
    {
        header('Content-Type: application/javascript');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        header('Service-Worker-Allowed: ' . rtrim(parse_url(site_url(), PHP_URL_PATH), '/') . '/');
        $this->load->view('sw_view'); // view yang berisi script sw.js
    }


}
