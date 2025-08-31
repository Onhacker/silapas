<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_booking extends CI_Model {
	var $table = 'im_reg';
	var $column_order_user = array('', '', 'nama', 'no_wa', 'id_permohonan', 'id_dusun', 'create_date');
	var $column_order_admin = array('', '', 'nama', 'no_wa', 'id_permohonan', 'id_dusun', 'id_desa', 'create_date');
	var $column_search = array('nama', 'no_wa'); 
	var $order = array('create_date' => 'DESC', 'create_time' => 'DESC');

	public function __construct() {
	    parent::__construct();
	}

	private function get_data_query() {
	    $admin_level = $this->session->userdata("admin_level");
	    $id_desa = $this->session->userdata("id_desa");

	    $this->db->from($this->table);

	    if ($admin_level !== "admin") {
	        $this->db->where("id_desa", $id_desa);
	    }

	    // Search
	    if (!empty($_POST['search']['value'])) {
	        $search_value = $_POST['search']['value'];
	        $this->db->group_start();
	        foreach ($this->column_search as $item) {
	            $this->db->or_like($item, $search_value);
	        }
	        $this->db->group_end();
	    }

	    // Order
	    if (isset($_POST['order'])) {
	        $order_column_index = $_POST['order']['0']['column'];
	        $order_dir = $_POST['order']['0']['dir'];

	        $columns = ($admin_level == "admin") ? $this->column_order_admin : $this->column_order_user;

	        if (isset($columns[$order_column_index]) && !empty($columns[$order_column_index])) {
	            $this->db->order_by($columns[$order_column_index], $order_dir);
	        }
	    } else {
	        foreach ($this->order as $key => $val) {
	            $this->db->order_by($key, $val);
	        }
	    }
	}

	// var $table = 'im_reg';
	// var $column_order_user = array('','','nama','no_wa','id_permohonan','id_dusun','create_date');
	// var $column_order_admin = array('','','nama','no_wa','id_permohonan','id_dusun','id_desa','create_date');
	// var $column_search = array('nama','no_wa'); 
	// var $order = array('create_date' => 'DESC','create_time' => "DESC");
	// public function __construct(){
	// 	parent::__construct();
	// }
	
	// private function get_data_query(){

	// 	if ($this->session->userdata("admin_level") == "admin") {
	// 		$this->db->from($this->table);
	// 	} else {
	// 		$this->db->where("id_desa",$this->session->userdata("id_desa"));
	// 		$this->db->from($this->table);
	// 	}
        
	// 	$i = 0;
	// 	foreach ($this->column_search as $item) // loop column 
 //        {
 //            if($_POST['search']['value']) // if datatable send POST for search
 //            {
                 
 //                if($i===0) // first loop
 //                {
 //                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
 //                    $this->db->like($item, $_POST['search']['value']);
 //                }
 //                else
 //                {
 //                    $this->db->or_like($item, $_POST['search']['value']);
 //                }
 
 //                if(count($this->column_search) - 1 == $i) //last loop
 //                    $this->db->group_end(); //close bracket
 //            }
 //            $i++;
 //        }

	// 	if(isset($_POST['order'])) {
	// 		if ($this->session->userdata("admin_level") == "admin") {
	// 			$this->db->order_by($this->column_order_admin[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	// 		} else {
	// 			$this->db->where("id_desa",$this->session->userdata("id_desa"));
	// 			$this->db->order_by($this->column_order_user[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	// 		}
	// 	} else if(isset($this->order)){
	// 		$order = $this->order;
	// 		$this->db->order_by('create_date', 'DESC');
	// 		$this->db->order_by('create_time', 'DESC');
	// 	}

	// }

	function get_data() {
	    $this->get_data_query();

	    if ($_POST['length'] != -1) {
	        $this->db->limit($_POST['length'], $_POST['start']);
	    }

	    $query = $this->db->get();
	    return $query->result();
	}

	function count_filtered() {
		$this->get_data_query();
		return $this->db->count_all_results();
	}

	
	function count_all() {
		$admin_level = $this->session->userdata("admin_level");
		$id_desa = $this->session->userdata("id_desa");

		$this->db->from($this->table);

		if ($admin_level !== "admin") {
			$this->db->where("id_desa", $id_desa);
		}

		return $this->db->count_all_results();
	}


	function get_by_id($id){
		$this->db->where("username",$this->session->userdata("admin_username"));
		$this->db->from($this->table);
		$this->db->where('id_reg',$id);
		$query = $this->db->get();

		return $query;
	}

	function arr_dusun(){
		$this->db->where("id_desa", $this->session->userdata("id_desa"));
        $this->db->order_by("nama_dusun", "ASC");
		$res = $this->db->get("master_dusun");
		$arr[""]  = "== Semua Dusun == ";
		foreach($res->result() as $row) :
			$arr[$row->id_dusun]  = $row->nama_dusun;
		endforeach;
		return $arr;
	}

	function arr_permohonan(){
        $this->db->order_by("id_permohonan", "ASC");
		$res = $this->db->get("master_permohonan");
		$arr[""]  = "== Pilih Permohonan == ";
		foreach($res->result() as $row) :
			$arr[$row->id_permohonan]  = $row->nama_permohonan;
		endforeach;
		return $arr;
	}

	// public function get_unit_tujuan() {
 //        return $this->db->where('status', 1)->get('unit_tujuan')->result();
 //    }
    public function get_units()
    {
        return $this->db->order_by('id', 'ASC')->get('unit_tujuan')->result();
    }

    public function get_tree($parent_id = NULL)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('unit_tujuan');
        $result = $query->result();

        $tree = [];
        foreach ($result as $row) {
            $row->children = $this->get_tree($row->id); // rekursif
            $tree[] = $row;
        }
        return $tree;
    }

	

}
