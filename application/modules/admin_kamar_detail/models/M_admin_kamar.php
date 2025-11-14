<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_kamar extends CI_Model {

    private $table         = 'kamar k';
    private $column_order  = [null, null, 'k.nama', 'k.kapasitas', null, 'k.status']; // DataTables
    private $column_search = ['k.nama','k.blok','k.keterangan'];
    private $order         = ['k.nama' => 'ASC'];

    public function __construct(){
        parent::__construct();
    }

    private function _base_q()
    {
        $this->db
            ->select('k.*, COUNT(t.id_detail) AS jumlah_tahanan')
            ->from('kamar k')
            ->join('kamar_tahanan t','t.id_kamar = k.id_kamar','left')
            ->group_by('k.id_kamar');
    }

    private function _build_q()
    {
        $this->_base_q();

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

    public function get_data()
    {
        $this->_build_q();
        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit((int)$_POST['length'], (int)$_POST['start']);
        }
        return $this->db->get()->result();
    }

    public function count_filtered()
    {
        $this->_build_q();
        return $this->db->get()->num_rows();
    }

    public function count_all()
    {
        $this->_base_q();
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->select('k.*')
            ->from('kamar k')
            ->where('k.id_kamar',(int)$id)
            ->get()
            ->row();
    }
}
