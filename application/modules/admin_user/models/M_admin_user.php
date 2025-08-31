<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_user extends CI_Model {

  var $table = 'users u';
  // urutan kolom harus sinkron dengan yang dicari/diurut server-side
  var $column_order  = [null, null, null, 'u.username','u.nama_lengkap','ut.nama_unit','u.no_telp']; 
  var $column_search = ['u.username','u.nama_lengkap','ut.nama_unit','u.no_telp'];
  var $order         = ['u.username' => 'asc']; // default order

  private function base_filters(){
    // user unit aktif, tidak dihapus
    $this->db->from($this->table);
    $this->db->join('unit_tujuan ut', 'ut.id = u.id_unit', 'left');

    // sesuaikan dengan skema Anda:
    $this->db->where('u.deleted', 'N');
    // jika pakai level, contoh:
    // $this->db->where('u.level', 'user');
    // pastikan hanya user yang punya unit
    $this->db->where('COALESCE(u.id_unit,0) <>', 0, false);
  }

  private function get_data_query(){
    $this->base_filters();

    // pencarian global
    $i = 0;
    if (!empty($_POST['search']['value'])) {
      $search = $_POST['search']['value'];
      $this->db->group_start();
      foreach ($this->column_search as $item) {
        if($i===0) $this->db->like($item, $search);
        else       $this->db->or_like($item, $search);
        $i++;
      }
      $this->db->group_end();
    }

    // ordering
    if (isset($_POST['order'])) {
      // index kolom dari DataTables → map ke column_order
      $colIndex = $_POST['order'][0]['column'];
      $dir      = $_POST['order'][0]['dir'];
      $colName  = $this->column_order[$colIndex] ?? 'u.username';
      if ($colName) $this->db->order_by($colName, $dir);
    } else {
      // default
      foreach($this->order as $col=>$dir) $this->db->order_by($col, $dir);
    }
  }

  public function get_data(){
    $this->get_data_query();
    if ($_POST['length'] != -1) {
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    return $this->db->get()->result();
  }

  public function count_filtered(){
    $this->get_data_query();
    return $this->db->get()->num_rows();
  }

  public function count_all(){
    $this->base_filters();
    return $this->db->count_all_results();
  }

  // dropdown unit, jika diperlukan di form
  public function arr_unit(){
    $out = ['' => '— Pilih Unit —'];
    $q = $this->db->select('id, nama_unit')->order_by('nama_unit','ASC')->get('unit_tujuan')->result();
    foreach($q as $r) $out[$r->id] = $r->nama_unit;
    return $out;
  }
}
