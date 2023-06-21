<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendahuluan_model extends CI_Model {
	private $table;
	function __construct(){
		parent::__construct();
		$this->tahun = $this->session->userdata('tahun');
		$this->iduser = $this->session->userdata('iduser');
		$this->table = 'bln_pendahuluan';
	}
	
	public function get_all($limit_offset = array()){
		if(!empty($limit_offset)){
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('bln_pendahuluan',$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get('bln_pendahuluan');
		}
		return $query->result();
	}


	public function count_total(){
		$query = $this->db->get('bln_pendahuluan');
		return $query->num_rows();
	}


	public function get_all_array($filter = false){
		if(!empty($filter)) {
			$query = $this->db->get_where('bln_pendahuluan', $filter);
		}else{
			$query = $this->db->get('bln_pendahuluan');
		}
		return $query->result_array();
	}


	public function get_last_id(){
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('bln_pendahuluan',1,0);
		return $query->result();
	}


	public function insert($data){
		$this->db->insert('bln_pendahuluan', $data);
	}


	public function update($bulan,$iduser,$data){
		$this->db->where('id_bulan', $bulan);
		$this->db->where('iduser', $iduser);
		$this->db->update('bln_pendahuluan', $data);
	}

	public function get_by_id($id){
		$response = false;
		$query = $this->db->get_where('bln_pendahuluan',array('id' => $id,'iduser' => $this->iduser));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}


	public function delete($data){
		$bulan=$this->session->userdata('id_bulan');
		$this->db->delete('bln_pendahuluan', array('id_bulan' => $bulan,'iduser' => $this->iduser));
	}

	
	public function get_filter($filter = '',$limit_offset = array()){
		if(!empty($filter)){
			$query = $this->db->order_by("id_bulan", "desc")->get_where('bln_pendahuluan',$filter);
		}else{
			$query = $this->db->get('bln_pendahuluan',$limit_offset['limit'],$limit_offset['offset']);
		}
		// echo $this->db->last_query();exit;
		return $query->result();
	}
	

	public function count_total_filter($filter = array()){
		if(!empty($filter)){
			$query = $this->db->order_by("id_bulan", "desc")->get_where($this->table,$filter);
		}else{
			$query = $this->db->order_by("id_bulan", "desc")->get($this->table);
		}
		return $query->num_rows();
	}


	/*============================================================================================================*/
	/* function keterangan */

	public function get_by_id_ket($id){
		$response = false;
		$query = $this->db->get_where('bln_pendahuluan',array('id' => $id,'iduser' => $this->iduser,'iduser' => $this->iduser));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1){
		$this->db->delete('bln_pendahuluan', array('id_bulan' => $p1, 'iduser' => $this->iduser,'iduser' => $this->iduser));
	}

	public function insert_ket($data){
		$this->db->insert('bln_pendahuluan', $data);
	}


	function get_ket($p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		$tahun = $this->session->userdata('tahun');
		$id_bulan = $this->session->userdata('id_bulan');

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			$where .= "
				AND A.iduser =  '".$iduser."'
				AND A.tahun =  '".$tahun."'
			";
		}

		if($level == 'TASPEN' || $level == 'ASABRI'){
			$iduser = $this->session->userdata('iduser');
			$where .= "
				AND A.iduser = '".$iduser."'
				AND A.tahun =  '".$tahun."'
			";
		}

		
		$sql = "
			SELECT A.*
			FROM bln_pendahuluan A
			$where
			AND A.id_bulan = '".$p1."'
		";

		return $this->db->query($sql)->result();
	}
}