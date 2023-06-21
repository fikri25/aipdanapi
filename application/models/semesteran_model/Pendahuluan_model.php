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
		$this->table = 'tb_pendahuluan_semesteran';
	}
	

	public function get_all(){
		$semester = $this->session->userdata('semester');
		$this->db->select('*');
		$this->db->from('tb_pendahuluan_semesteran');
		$this->db->where('iduser',$this->iduser);
		$this->db->where('semester',$semester);
		$query= $this->db->get();
		return $query->result();
	}

	public function count_total(){
		$query = $this->db->get('tb_pendahuluan_semesteran');
		return $query->num_rows();
	}


	public function get_all_array($filter = false){
		if(!empty($filter)) {
			$query = $this->db->get_where('tb_pendahuluan_semesteran', $filter);
		}else{
			$query = $this->db->get('tb_pendahuluan_semesteran');
		}
		return $query->result_array();
	}


	public function get_last_id(){
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('tb_pendahuluan_semesteran',1,0);
		return $query->result();
	}


	public function insert($data){
		$this->db->insert('tb_pendahuluan_semesteran', $data);
	}

	
	public function update($semester,$iduser,$data){
		$this->db->where('semester', $semester);
		$this->db->where('iduser',$this->iduser);
		$this->db->where('tahun',$this->tahun);
		$this->db->update('tb_pendahuluan_semesteran', $data);
	}

	public function get_by_id($id){
		$semester = $this->session->userdata('semester');
		$response = false;
		$query = $this->db->get_where('tb_pendahuluan_semesteran',array('id' => $id,'iduser' => $this->iduser,'semester' => $semester));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}


	public function delete($data){
		$semester = $this->session->userdata('semester');
		$this->db->delete('tb_pendahuluan_semesteran', array('semester' => $semester,'iduser' => $this->iduser));
	}

	
	public function get_filter($filter = '',$limit_offset = array()){
		if(!empty($filter)){
			$query = $this->db->order_by('tahun', 'desc')->get_where('tb_pendahuluan_semesteran',$filter,$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get('tb_pendahuluan_semesteran',$limit_offset['limit'],$limit_offset['offset']);
		}
		return $query->result();
	}


	/*============================================================================================================*/
	/* function keterangan */

	public function get_by_id_ket($id){
		$response = false;
		$query = $this->db->get_where('tb_pendahuluan_semesteran',array('id' => $id,'iduser' => $this->iduser,'tahun' => $this->tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1){
		$this->db->delete('tb_pendahuluan_semesteran', array('semester' => $p1, 'iduser' => $this->iduser,'tahun' => $this->tahun));
	}

	public function insert_ket($data){
		$this->db->insert('tb_pendahuluan_semesteran', $data);
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
				AND A.tahun =  '".$tahun."'
			";
		}

		
		$sql = "
			SELECT A.*
			FROM tb_pendahuluan_semesteran A
			$where
			AND A.semester =  '".$p1."'
		";

		return $this->db->query($sql)->result();
	}

	
}