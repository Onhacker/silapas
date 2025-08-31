<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('slugify_mod')) {
  function slugify_mod($s){
    $s = strtolower(trim((string)$s));
    $s = preg_replace('~[^\pL\d]+~u','-',$s);
    $s = trim($s,'-');
    return $s;
  }
}

if (!function_exists('allowed_module_slugs')) {
  function allowed_module_slugs(){
    static $cache = null;
    if ($cache !== null) return $cache;

    $CI = &get_instance();
    $u  = $CI->session->userdata('admin_username');
    $lvl= $CI->session->userdata('admin_level');
    $sid= $CI->session->userdata('admin_session');

    // Super admin: bebas
    if ($lvl === 'admin' && $u === 'admin') {
      $cache = '__ALL__';
      return $cache;
    }

    // Ambil modul yang diizinkan untuk user sekarang
    $CI->db->select('m.nama_modul')
           ->from('modul m')
           ->join('users_modul um','um.id_modul=m.id_modul')
           ->where('um.id_session', $sid)
           ->where('m.aktif','Y')
           ->where('m.publish','Y');
    $rows = $CI->db->get()->result();
    $set  = [];
    foreach($rows as $r){
      $set[ slugify_mod($r->nama_modul) ] = true;
    }
    $cache = $set;
    return $cache;
  }
}

if (!function_exists('user_can_mod')) {
  // $require: string|array label modul (akan di-slug)
  function user_can_mod($require){
    $allow = allowed_module_slugs();
    if ($allow === '__ALL__') return true;

    $reqs = is_array($require) ? $require : [$require];
    foreach($reqs as $r){
      if (isset($allow[ slugify_mod($r) ])) return true;
    }
    return false;
  }
}

if (!function_exists('build_menu')) {
  /**
   * Render LI (tanpa UL root) sesuai theme:
   * - parent: <li class="has-submenu [active-menu]"><a>Label<div class="arrow-down"></div></a><ul class="submenu">...</ul></li>
   * - item:   <li class="[active-menu]"><a href="..."><i class="fe-..."></i> Label</a></li>
   */
  function build_menu(array $items, array $opts = []){
    $CI   = &get_instance();
    $uri  = trim($CI->uri->uri_string(),'/');

    $o = array_merge([
      'li_has_child_class' => 'has-submenu',
      'li_active_class'    => 'active-menu',
      'child_ul_class'     => 'submenu', // penting: hanya untuk anak
      'a_class'            => '',
    ], $opts);

    $renderItems = function($items) use (&$renderItems, $o, $uri){
      $html = '';
      foreach($items as $it){
        // cek akses
        if (isset($it['require']) && !user_can_mod($it['require'])) continue;

        $label = $it['label'] ?? '';
        $url   = $it['url']   ?? '#';
        $icon  = $it['icon']  ?? '';
        $kids  = $it['children'] ?? [];

        // render anak dulu (hanya yang allowed)
        $childHtml = '';
        if ($kids){
          $childHtml = $renderItems($kids);
          if ($childHtml === '') {
            // semua anak ketendang oleh filter akses → sembunyikan parent juga
            continue;
          }
        }

        // active?
        $isActive = false;
        if (!empty($it['active_match'])) {
          // manual pattern
          foreach((array)$it['active_match'] as $pat){
            if (strpos($uri, trim($pat,'/')) === 0){ $isActive=true; break; }
          }
        } else {
          // default: match prefix url route
          $route = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
          if ($route !== '' && strpos($uri, $route) === 0) $isActive = true;
        }

        $liClsArr = [];
        if ($kids) $liClsArr[] = $o['li_has_child_class'];
        if ($isActive) $liClsArr[] = $o['li_active_class'];
        $liCls = $liClsArr ? ' class="'.implode(' ',$liClsArr).'"' : '';

        $iconHtml = $icon ? '<i class="'.htmlspecialchars($icon).'"></i> ' : '';

        if ($kids){
          $html .= '<li'.$liCls.'>';
          $html .= '<a href="#">'.$iconHtml.htmlspecialchars($label).'<div class="arrow-down"></div></a>';
          $html .= '<ul class="'.htmlspecialchars($o['child_ul_class']).'">'.$childHtml.'</ul>';
          $html .= '</li>';
        } else {
          $html .= '<li'.$liCls.'><a href="'.htmlspecialchars($url).'">'.$iconHtml.htmlspecialchars($label).'</a></li>';
        }
      }
      return $html;
    };

    // KEMBALIKAN HANYA <li>...</li> TANPA <ul> ROOT
    return $renderItems($items);
  }
}
