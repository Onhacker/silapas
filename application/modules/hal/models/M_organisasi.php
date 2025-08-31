<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_organisasi extends CI_Model
{
    // Pakai tabel unit_tujuan sesuai skema kamu
    private $table = 'unit_tujuan';

  public function get_all() {
        return $this->db->order_by('id','ASC')->get('unit_tujuan')->result();
    }

}
