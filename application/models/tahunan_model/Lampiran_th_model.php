<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lampiran_th_model extends CI_Model {
	private $table;
	function __construct(){
      parent::__construct();
      $this->tahun = $this->session->userdata('tahun');
      $this->bulan = $this->session->userdata('id_bulan');
      $this->semester = $this->session->userdata('semester');
		$this->table = 'bln_aset_investasi_header';

		if($this->session->userdata('level') === "DJA"){
			$this->iduser = $this->session->userdata('cari');
		}else{
			$this->iduser = $this->session->userdata('iduser');
		}
	}


	public function get_by_id_ket($id){
		$response = false;
		$query = $this->db->get_where('ket_lap_tahunan',array('id' => $id,'iduser' => $this->iduser));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1,$p2){
		$this->db->delete('ket_lap_tahunan', array('jenis_lap' => $p1, 'iduser' => $this->iduser));
	}

	public function insert_ket($data){
		$this->db->insert('ket_lap_tahunan', $data);
	}


	// public function get_ket($filter, $smt){
	// 	$this->db->select("*");
	// 	$this->db->from('ket_lap_tahunan');
	// 	$this->db->where('jenis_lap', $filter);
	// 	$this->db->where('semester', $smt);
	// 	$query=$this->db->get();
	// 	return $query->result();

	// }

	function get_ket($p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		$tahun = $this->session->userdata('tahun');

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			$where .= "
				AND A.iduser =  '".$iduser."'
			";
		}

		if($level == 'TASPEN' || $level == 'ASABRI'){
			$iduser = $this->session->userdata('iduser');
			$where .= "
				AND A.iduser = '".$iduser."'
			";
		}

		$sql = "
			SELECT A.*
			FROM ket_lap_tahunan A
			$where
			AND A.jenis_lap = '".$p1."'
		";

		return $this->db->query($sql)->result();
	}
	
}