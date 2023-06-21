<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulan_model extends CI_Model {
	function __construct(){
        parent::__construct();
        $this->tahun = $this->session->userdata('tahun');
	}
	
	public function get_all($limit_offset = array()){
		if(!empty($limit_offset)){
			$query =$this->db->get('t_bulan',$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get('t_bulan');
		}
		return $query->result();
	}


	
}