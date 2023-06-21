<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perubahan_dana_bersih_model extends CI_Model {
	private $table;

	function __construct(){
		parent::__construct();
		$this->tahun = $this->session->userdata('tahun');
		$this->iduser = $this->session->userdata('iduser');
		$this->table = "bln_perubahan_dana_bersih";
	}

	
	public function get_by_id_ket($id){
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$response = false;
		$query = $this->db->get_where('ket_lap_bulanan',array('id' => $id,'iduser' => $iduse,'tahun' => $tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1,$p2){
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$this->db->delete('ket_lap_bulanan', array('jenis_lap' => $p1, 'id_bulan' => $p2, 'iduser' => $iduser,'tahun' => $tahun));
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

	function getdata($type="", $balikan="", $p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";
		$where2  = " WHERE 1=1 ";
		$where3 = "";
		
		$dbdriver = $this->db->dbdriver;
		if($dbdriver == "postgre"){
			$select = " ROW_NUMBER() OVER (ORDER BY A.id DESC) as rowID, ";
		}else{
			$select = "";
		}
		
		if($this->input->post('key')){
			$key = $this->input->post('key');
			$kat = $this->input->post('kat');
			$where .= " AND LOWER(".$kat.") like '%".strtolower(trim($key))."%' ";
		}
		

		$level = $this->session->userdata('level');
		$tahun = $this->session->userdata('tahun');
		$id_bulan = $this->session->userdata('id_bulan');

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			$where .= "
				AND B.iduser =  '".$iduser."'
			";
			$where2 .= "
				AND A.iduser =  '".$iduser."'
			";
		}

		if($level == 'TASPEN' || $level == 'ASABRI'){
			$iduser = $this->session->userdata('iduser');
			$where .= "
				AND B.iduser = '".$iduser."'
			";
			$where2 .= "
				AND A.iduser = '".$iduser."'
			";
		}

		switch($type){
			case 'aset_investasi_front':
				// kondisi setelah bulan januari
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.rka, B.saldo_akhir, B.saldo_awal, C.saldo_akhir_lalu, B.id
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, rka, saldo_akhir_invest as saldo_akhir, saldo_awal_invest as saldo_awal, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id,id_investasi, rka, saldo_akhir_invest as saldo_akhir_lalu, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) C ON A.id_investasi = C.id_investasi
					WHERE `group`='".$p1."' 
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'P' OR A.type_sub_jenis_investasi = 'PC')
					GROUP BY A.id_investasi
					ORDER BY A.no_urut ASC

				";
				// echo $sql;exit;
			break;
			case 'aset_investasi_front_lv2':
				$sql="
					SELECT A.parent_id as id_investasi, A.jns_form, A.iduser, B.id_bulan,
					sum(B.saldo_awal) as saldo_awal, sum(B.mutasi) as mutasi, sum(B.rka) as rka, sum(B.realisasi_rka) as realisasi_rka, 
					sum(B.saldo_akhir) as saldo_akhir, A.id_investasi as parent_id, C.parent_investasi as jenis_investasi, C.type, B.id
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id_investasi, jenis_investasi as parent_investasi, tahun,
						type_sub_jenis_investasi as type
						FROM mst_investasi
					)C on A.parent_id = C.id_investasi
					WHERE A.`group` ='".$p2."'
					AND A.iduser = '".$iduser."'
					AND tahun = '".$tahun."'
					AND (A.type_sub_jenis_investasi = 'C')
					AND A.parent_id ='".$p1."'
					ORDER BY A.no_urut ASC

				";
			break;

			case 'aset_investasi_front_lv3':
				// kondisi setelah bulan januari
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type,B.id,
					B.rka as rka, 
					B.saldo_akhir as saldo_akhir, B.saldo_awal,
					C.saldo_akhir as saldo_akhir_lalu
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) C ON A.id_investasi = C.id_investasi
					
					WHERE A.`group` ='".$p2."'
					AND A.iduser = '".$iduser."'
					AND A.parent_id ='".$p1."'
					GROUP BY A.id_investasi
					ORDER BY A.no_urut ASC

				";
				// echo $sql;exit;
			break;

			case 'aset_investasi_front_sum':
				// kondisi setelah bulan januari
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}


				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.iduser,B.id,
					COALESCE(SUM(B.rka), 0) as rka,
					COALESCE(SUM(B.saldo_akhir), 0) as saldo_akhir,
					COALESCE(SUM(B.saldo_awal), 0) as saldo_awal,
					COALESCE(SUM(C.saldo_akhir_lalu), 0) as saldo_akhir_lalu
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, rka, saldo_akhir_invest as saldo_akhir, saldo_awal_invest as saldo_awal, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id,id_investasi, rka, saldo_akhir_invest as saldo_akhir_lalu, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) C ON A.id_investasi = C.id_investasi
		
					WHERE A.`group` ='".$p1."'
					AND A.iduser = '".$iduser."'
					ORDER BY A.no_urut ASC
				";

			break;



		}

		if($balikan == 'json'){
			return $this->lib->json_grid($sql,$type);
		}elseif($balikan == 'row_array'){
			return $this->db->query($sql)->row_array();
		}elseif($balikan == 'result'){
			return $this->db->query($sql)->result();
		}elseif($balikan == 'result_array'){
			return $this->db->query($sql)->result_array();
		}elseif($balikan == 'json_variable'){
			return json_encode($array);
		}elseif($balikan == 'json_encode'){
			$data = $this->db->query($sql)->result_array(); 
			return json_encode($data);
		}elseif($balikan == 'variable'){
			return $array;
		}elseif($balikan == 'json_datatable'){
			return $this->lib->json_datatable($sql, $type);
		}
	}

}