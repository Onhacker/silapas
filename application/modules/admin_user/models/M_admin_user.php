<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_user extends CI_Model {

  var $table = 'users u';

  // urutan kolom harus sinkron dengan yang dicari/diurut server-side
  // gunakan alias 'nama_unit' (hasil CASE) untuk kolom Unit
  var $column_order  = [null, null, null, 'u.username', 'u.nama_lengkap', 'nama_unit', 'u.no_telp'];
  var $column_search = ['u.username', 'u.nama_lengkap', 'nama_unit', 'u.no_telp'];
  var $order         = ['u.username' => 'asc']; // default order

  private function expr_nama_unit()
  {
    // Jika skema sudah punya id_unit_lain & unit_source → pakai ul.tugas
    $has_unit_lain = $this->db->field_exists('id_unit_lain', 'users');
    $has_source    = $this->db->field_exists('unit_source',  'users');

    if ($has_unit_lain && $has_source) {
      // CASE berdasarkan sumber
      return "CASE WHEN u.unit_source = 'unit_lain' THEN ul.tugas ELSE ut.nama_unit END";
    }

    // Fallback sesuai skema dump kamu (tanpa id_unit_lain / unit_source)
    // Jika id_unit=0 → tampilkan string 'Unit Lain'
    return "CASE WHEN COALESCE(u.id_unit,0)=0 THEN 'Unit Lain' ELSE ut.nama_unit END";
  }

  private function base_from_joins_and_select()
  {
    $this->db->from($this->table);
    // join unit_tujuan selalu
    $this->db->join('unit_tujuan ut', 'ut.id = u.id_unit', 'left');

    // join unit_lain hanya kalau kolom ada
    if ($this->db->field_exists('id_unit_lain', 'users')) {
      $this->db->join('unit_lain ul', 'ul.id_unit_lain = u.id_unit_lain', 'left');
    }

    // pilih field yang dibutuhkan + alias nama_unit
    $expr = $this->expr_nama_unit();
    $this->db->select("
      u.username,
      u.nama_lengkap,
      u.no_telp,
      u.foto,
      u.id_session,
      {$expr} AS nama_unit
    ", false);

    // filter umum
    $this->db->where('u.deleted', 'N');
    $this->db->where('u.username !=', 'admin'); // EXCLUDE username 'admin'
    // JANGAN filter id_unit<>0, agar 'Unit Lain' ikut tampil
  }

  private function apply_search_and_order()
  {
    // Pencarian global
    $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    if ($search !== '') {
      $like = $this->db->escape_like_str($search);
      $expr = $this->expr_nama_unit();

      $this->db->group_start();
      foreach ($this->column_search as $idx => $col) {
        if ($col === 'nama_unit') {
          // gunakan ekspresi CASE untuk LIKE
          $this->db->or_where("({$expr}) LIKE '%{$like}%'", null, false);
        } else {
          if ($idx === 0) $this->db->like($col, $search);
          else            $this->db->or_like($col, $search);
        }
      }
      $this->db->group_end();
    }

    // Ordering
    if (isset($_POST['order'])) {
      $colIndex = (int)$_POST['order'][0]['column'];
      $dir      = $_POST['order'][0]['dir'] === 'desc' ? 'desc' : 'asc';
      $colName  = $this->column_order[$colIndex] ?? 'u.username';

      if ($colName === 'nama_unit') {
        // ORDER BY alias diperbolehkan
        $this->db->order_by('nama_unit', $dir);
      } else {
        $this->db->order_by($colName, $dir);
      }
    } else {
      foreach($this->order as $col=>$dir) $this->db->order_by($col, $dir);
    }
  }

  private function build_query()
  {
    $this->base_from_joins_and_select();
    $this->apply_search_and_order();
  }

  public function get_data(){
    $this->build_query();
    if (isset($_POST['length']) && $_POST['length'] != -1) {
      $this->db->limit((int)$_POST['length'], (int)$_POST['start']);
    }
    return $this->db->get()->result();
  }

  public function count_filtered(){
    $this->build_query();
    return $this->db->get()->num_rows();
  }

  public function count_all(){
    $this->base_from_joins_and_select();
    return $this->db->count_all_results();
  }

  // === Dropdown Unit (optgroup) ===
  public function arr_unit()
  {
    $out = [
      ''             => '— Pilih Unit —',
      'Unit Tujuan'  => [],
      'Unit Lain'    => [],
    ];

    // 1) unit_tujuan
    $q1 = $this->db->select('id, nama_unit')
                   ->from('unit_tujuan')
                   ->order_by('nama_unit', 'ASC')
                   ->get()->result();
    foreach ($q1 as $r) {
      $out['Unit Tujuan'][$r->id] = $r->nama_unit;
    }

    // 2) unit_lain
    $q2 = $this->db->select('id_unit_lain, tugas')
                   ->from('unit_lain')
                   ->order_by('tugas', 'ASC')
                   ->get()->result();
    foreach ($q2 as $r) {
      $out['Unit Lain']['L:' . $r->id_unit_lain] = $r->tugas;
    }

    return $out;
  }
}
