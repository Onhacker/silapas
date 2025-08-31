<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_capil extends CI_Model {
	var $table = 'users';
	var $column_order = array('','','','username','nama_lengkap','no_telp');
	var $column_search = array('username','nama_lengkap','no_telp'); 
	var $order = array('tanggal_reg' => 'asc');	

	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
		$this->db->where("level", "admin");
		$this->db->where("deleted", "N");
		$this->db->where("username <>", $this->session->userdata("admin_username"));
		$this->db->from($this->table);

		
		$i = 0;

		foreach ($this->column_search as $item) {
			if($_POST['search']['value']) {
				 if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket

			}
			$i++;
		}

		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			// $this->db->order_by('tahun', 'DESC');
			// $this->db->order_by('id_ibu', 'DESC');
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
		$this->db->where("level","admin");
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	function arr_dusun(){
		// $this->db->order_by("bentuk", "ASC");
        $this->db->order_by("nama_dusun", "ASC");
        // $this->db->where("aktif","Y");
		$this->db->where("id_desa", $this->session->userdata("id_desa"));
		$res = $this->db->get("master_dusun");
		$arr[""]  = "== Pilih ".$this->om->engine_nama_menu("Admin_dusun")." ==";
		foreach($res->result() as $row) :
			$arr[$row->id_dusun]  = $row->nama_dusun;
		endforeach;
		return $arr;
	}
	
	function get_by_id($id){
		$this->db->from($this->table);
		$this->db->where('id_berita',$id);
		$query = $this->db->get();
		return $query;
	}


}
