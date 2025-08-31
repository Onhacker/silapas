<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_capil_profil extends CI_Model {
	var $table2 = "users_capil";
	var $table = 'master_permohonan';
	var $field2 = "id_permohonan";
	var $column_order = array('','master_permohonan.nama_permohonan');
	var $order = array('nama_permohonan' => 'ASC');
	public function __construct(){
		parent::__construct();
	}
	private function get_data_query(){
		// $this->db->where("modul.aktif","Y");
		// $this->db->where("modul.status","user");
		// $this->db->where("modul.publish","Y");
        $this->db->select('*');
        $this->db->from("master_permohonan");
        $i = 0;
		$column_search = array('nama_permohonan');
		foreach ($column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->like($item, $_POST['search']['value']);
				}
				else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i);

			}
			$i++;
		}

		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

	}

	function get_data(){
		$this->get_data_query();
		if ($_POST["length"] == "-1") {
			$query = $this->db->get();
		} else {
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
		}	
		return $query->result();
		
	}

	function count_filtered(){
		$this->get_data_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all(){
        $this->db->select('*');
        $this->db->from("master_permohonan");
		return $this->db->count_all_results();
	}



}
