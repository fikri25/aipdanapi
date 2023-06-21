<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendahuluan_model extends CI_Model {
	private $table;
	function __construct(){
		parent::__construct();
		$this->tahun = $this->session->userdata('tahun');
		if($this->session->userdata('level') === "DJA"){
			$this->iduser = $this->session->userdata('cari');
		}else{
			$this->iduser = $this->session->userdata('iduser');
		}
		$this->table = 'tb_pendahuluan_tahunan';
	}
	

	public function get_all(){
		$semester = $this->session->userdata('semester');
		$this->db->select('*');
		$this->db->from('tb_pendahuluan_tahunan');
		$this->db->where('iduser',$this->iduser);
		$this->db->where('tahun',$this->tahun);
		$query= $this->db->get();
		return $query->result();
	}

	public function count_total(){
		$query = $this->db->get('tb_pendahuluan_tahunan');
		return $query->num_rows();
	}


	public function get_all_array($filter = false){
		if(!empty($filter)) {
			$query = $this->db->get_where('tb_pendahuluan_tahunan', $filter);
		}else{
			$query = $this->db->get('tb_pendahuluan_tahunan');
		}
		return $query->result_array();
	}


	public function get_last_id(){
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('tb_pendahuluan_tahunan',1,0);
		return $query->result();
	}


	public function insert($data){
		$this->db->insert('tb_pendahuluan_tahunan', $data);
	}

	
	public function update($tahun,$iduser,$data){
		$this->db->where('tahun',$this->tahun);
		$this->db->where('iduser',$this->iduser);
		$this->db->update('tb_pendahuluan_tahunan', $data);
	}

	public function get_by_id($id){
		$tahun = $this->session->userdata('tahun');
		$response = false;
		$query = $this->db->get_where('tb_pendahuluan_tahunan',array('id' => $id,'iduser' => $this->iduser,'tahun' => $tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}


	public function delete($data){
		$tahun = $this->session->userdata('tahun');
		$this->db->delete('tb_pendahuluan_tahunan', array('tahun' => $tahun,'iduser' => $this->iduser));
	}

	
	public function get_filter($filter = '',$limit_offset = array()){
		if(!empty($filter)){
			$query = $this->db->order_by('tahun', 'desc')->get_where('tb_pendahuluan_tahunan',$filter,$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get('tb_pendahuluan_tahunan',$limit_offset['limit'],$limit_offset['offset']);
		}
		return $query->result();
	}


	/*============================================================================================================*/
	/* function keterangan */

	public function get_by_id_ket($id){
		$response = false;
		$query = $this->db->get_where('tb_pendahuluan_tahunan',array('id' => $id,'iduser' => $this->iduser,'tahun' => $this->tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1=''){
		$this->db->delete('tb_pendahuluan_tahunan', array('iduser' => $this->iduser,'tahun' => $this->tahun));
	}

	public function insert_ket($data){
		$this->db->insert('tb_pendahuluan_tahunan', $data);
	}


	function get_ket($p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		$tahun = $this->session->userdata('tahun');
		$smt = $this->input->post('semester');

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
				AND A.tahun = '".$tahun."'
			";
		}

		
		$sql = "
			SELECT A.*
			FROM tb_pendahuluan_tahunan A
			$where
		";

		return $this->db->query($sql)->result();
	}

	function get_tbl_keterangan($p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		$tahun = $this->session->userdata('tahun');
		$smt = $this->input->post('semester');

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			$where .= "
				AND A.iduser =  '".$iduser."'
				AND A.tahun = '".$tahun."'
			";
		}

		if($level == 'TASPEN' || $level == 'ASABRI'){
			$iduser = $this->session->userdata('iduser');
			$where .= "
				AND A.iduser = '".$iduser."'
				AND A.tahun = '".$tahun."'
			";
		}

		
		$sql = "
			SELECT A.*
			FROM ket_lap_tahunan A
			$where
		";

		return $this->db->query($sql)->result();
	}

	
}