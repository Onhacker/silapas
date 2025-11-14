<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_kamar_detail extends CI_Model {

    private $table         = 'kamar_tahanan d';
    private $column_order  = [null, null, 'd.nama', 'd.no_reg', 'd.expirasi', 'd.status'];
    private $column_search = ['d.nama','d.no_reg','d.perkara'];
    private $order         = ['d.nama' => 'ASC'];

    public function __construct(){
        parent::__construct();
    }

    private function _base_q($id_kamar)
    {
        $this->db->from('kamar_tahanan d')->where('d.id_kamar',(int)$id_kamar);
    }

    private function _build_q($id_kamar)
    {
        $this->_base_q($id_kamar);

        $search = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';
        if ($search !== '') {
            $this->db->group_start();
            foreach ($this->column_search as $i=>$col) {
                if ($i === 0) $this->db->like($col, $search);
                else          $this->db->or_like($col, $search);
            }
            $this->db->group_end();
        }

        if (isset($_POST['order'])) {
            $idx = (int)$_POST['order'][0]['column'];
            $dir = $_POST['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';
            $col = $this->column_order[$idx] ?? key($this->order);
            if ($col) $this->db->order_by($col, $dir);
        } else {
            foreach ($this->order as $col => $dir) {
                $this->db->order_by($col,$dir);
            }
        }
    }

    public function get_data($id_kamar)
    {
        $this->_build_q($id_kamar);
        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit((int)$_POST['length'], (int)$_POST['start']);
        }
        return $this->db->get()->result();
    }

    public function count_filtered($id_kamar)
    {
        $this->_build_q($id_kamar);
        return $this->db->get()->num_rows();
    }

    public function count_all($id_kamar)
    {
        $this->_base_q($id_kamar);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db->from('kamar_tahanan')->where('id_detail',(int)$id)->get()->row();
    }
}
