<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dana_bersih_model extends CI_Model {
	private $table;
	function __construct(){
		parent::__construct();
		$this->tahun = $this->session->userdata('tahun');

		if($this->session->userdata('level') === "DJA"){
			$this->iduser = $this->session->userdata('cari');
		}else{
			$this->iduser = $this->session->userdata('iduser');
		}
		$this->table = 'bln_dana_bersih';
	}
	

	public function get_by_id_ket($id){
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$response = false;
		$query = $this->db->get_where('ket_lap_bulanan',array('id' => $id,'iduser' => $iduser, 'tahun' => $tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1,$p2){
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$this->db->delete('ket_lap_bulanan', array('jenis_lap' => $p1, 'id_bulan' => $p2, 'iduser' => $iduser, 'tahun' => $tahun));
	}

	public function insert_ket($data){
		$tahun = $this->session->userdata('tahun');
		$this->db->insert('ket_lap_bulanan', $data);
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
			FROM ket_lap_bulanan A
			$where
			AND A.jenis_lap = '".$p1."'
			AND A.id_bulan = '".$id_bulan."'
		";

		return $this->db->query($sql)->result();
	}


}