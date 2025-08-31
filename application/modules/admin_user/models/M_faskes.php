<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_faskes extends CI_Model {
	var $table = 'users';
	var $column_order = array('','','','username','nama_lengkap','nama_fasilitas','no_telp');
	var $column_search = array('username','nama_lengkap','nama_fasilitas','no_telp'); 
	var $order = array('tanggal_reg' => 'asc');	

	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
		$this->db->select('users.*, fasilitas_kesehatan.nama_fasilitas');
		$this->db->from($this->table); // Misalnya: 'users'
		$this->db->join('fasilitas_kesehatan', 'fasilitas_kesehatan.id = users.id_faskes', 'left');
		$this->db->where('users.level', 'faskes');
		$this->db->where('users.deleted', 'N');


		
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

	function arr_faskes(){
		// $this->db->order_by("bentuk", "ASC");
        $this->db->order_by("id", "ASC");
        // $this->db->where("aktif","Y");
		$res = $this->db->get("fasilitas_kesehatan");
		$arr[""]  = "== Pilih Faskes ==";
		foreach($res->result() as $row) :
			$arr[$row->id]  = $row->nama_fasilitas;
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
