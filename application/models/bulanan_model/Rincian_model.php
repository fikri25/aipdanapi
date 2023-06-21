<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rincian_model extends CI_Model {
	private $table;
	function __construct(){
      parent::__construct();
      $tahun = $this->session->userdata('tahun');
      $iduser = $this->session->userdata('iduser');
	}

	
	public function get_by_id_ket($id){
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$response = false;
		$query = $this->db->get_where('ket_lap_bulanan',array('id' => $id,'iduser' => $iduser,'tahun' => $tahun));
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
				AND A.tahun = '".$tahun."'
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



	function get_combo($type="", $p1="", $p2=""){
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

		if($level == 'TASPEN' || $level == 'ASABRI'){ // user Resepsinis
			$iduser = $this->session->userdata('iduser');
			$where .= "
			AND A.iduser = '".$iduser."'
			";
		}

		switch($type){
			case "data_pihak":
				$sql = "
					SELECT A.kode_pihak as id, A.nama_pihak as txt
					FROM mst_pihak A
					LEFT JOIN mst_nama_pihak B ON A.kode_pihak = B.kode_pihak
					$where
					AND B.id_investasi = '".$p1."'
				";
				// echo $sql;exit;
			break;
			case "get_arus_kas":
				$sql = "
					SELECT A.id_aruskas as id, A.arus_kas as txt
					FROM mst_aruskas A  
					$where
					AND A.jenis_kas = '".$p1."'
				";
				// echo $sql;exit;
			break;
		}
		
		return $this->db->query($sql)->result_array();
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

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			$id_bulan = $this->session->userdata('id_bulan');
			$where .= "
				AND B.iduser =  '".$iduser."'
			";
			$where2 .= "
				AND A.iduser =  '".$iduser."'
			";
		}
		

		if($level == 'TASPEN' || $level == 'ASABRI'){ 
			$iduser = $this->session->userdata('iduser');
			$id_bulan = $this->session->userdata('id_bulan');
			$where .= "
				AND B.iduser = '".$iduser."'
			";
			$where2 .= "
				AND A.iduser = '".$iduser."'
			";
		}

		switch($type){
			case 'rincian_investasi':
				if($iduser == 'TSN002'){
					$sql = "
						SELECT A.*
						FROM vw_investasi_perpihak_taspen A  
						$where2
						AND A.id_bulan = '".$id_bulan."'
					";	
					 // echo $sql;exit;
				}elseif ($iduser == 'ASB003') {
					$sql = "
						SELECT A.*
						FROM vw_investasi_perpihak_asabri A
						$where2
						AND A.id_bulan = '".$id_bulan."'
					";	
				}else{
					$sql = "
						SELECT A.*
						FROM vw_investasi_perpihak_taspen A  
						$where2
						AND A.id_bulan = '".$id_bulan."'
					";	
				}
				
			break;

			case 'rincian_bkn_investasi':
				if($iduser == 'TSN002'){
					$sql = "
						SELECT A.*
						FROM vw_bkn_investasi_perpihak_taspen A  
						$where2
						AND A.id_bulan = '".$id_bulan."'
					";	
				}elseif ($iduser == 'ASB003') {
					$sql = "
						SELECT A.*
						FROM vw_bkn_investasi_perpihak_asabri A
						$where2
						AND A.id_bulan = '".$id_bulan."'
					";	
				}else{
					$sql = "
						SELECT A.*
						FROM vw_bkn_investasi_perpihak_taspen A  
						$where2
						AND A.id_bulan = '".$id_bulan."'
					";	
				}
				
			break;
			
			case 'sum_rincian_investasi':
				if($iduser == 'TSN002'){
					$sql="
						SELECT A.iduser, A.id_bulan,
						COALESCE(SUM(A.deposito), 0) as deposito,
						COALESCE(SUM(A.sertifikat_deposito), 0) as sertifikat_deposito,
						COALESCE(SUM(A.sun), 0) as sun,
						COALESCE(SUM(A.sukuk_pemerintah), 0) as sukuk_pemerintah,
						COALESCE(SUM(A.obligasi_korporasi), 0) as obligasi_korporasi,
						COALESCE(SUM(A.sukuk_korporasi), 0) as sukuk_korporasi,
						COALESCE(SUM(A.obligasi_mata_uang), 0) as obligasi_mata_uang,
						COALESCE(SUM(A.mtn), 0) as mtn,
						COALESCE(SUM(A.saham), 0) as saham,
						COALESCE(SUM(A.reksadana), 0) as reksadana,
						COALESCE(SUM(A.dana_invest_kik), 0) as dana_invest_kik,
						COALESCE(SUM(A.penyertaan_langsung), 0) as penyertaan_langsung,
						COALESCE(SUM(A.tanah_bangunan), 0) as tanah_bangunan,
						COALESCE(SUM(A.reksadana_pasar_uang), 0) as reksadana_pasar_uang,
						COALESCE(SUM(A.reksadana_pendapatan_tetap), 0) as reksadana_pendapatan_tetap,
						COALESCE(SUM(A.reksadana_campuran), 0) as reksadana_campuran,
						COALESCE(SUM(A.reksadana_saham), 0) as reksadana_saham,
						COALESCE(SUM(A.reksadana_terproteksi), 0) as reksadana_terproteksi,
						COALESCE(SUM(A.reksadana_pinjaman), 0) as reksadana_pinjaman,
						COALESCE(SUM(A.reksadana_index), 0) as reksadana_index,
						COALESCE(SUM(A.reksadana_kik), 0) as reksadana_kik,
						COALESCE(SUM(A.reksadana_penyertaaan_diperdagangkan), 0) as reksadana_penyertaaan_diperdagangkan,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_taspen A
						WHERE A.iduser = '".$iduser."'
						AND A.id_bulan = '".$id_bulan."'
						AND A.tahun = '".$tahun."'
					";
				}elseif ($iduser == 'ASB003') {
					$sql="
						SELECT A.iduser, A.id_bulan,
						COALESCE(SUM(A.deposito), 0) as deposito,
						COALESCE(SUM(A.sertifikat_deposito), 0) as sertifikat_deposito,
						COALESCE(SUM(A.sun), 0) as sun,
						COALESCE(SUM(A.sukuk_pemerintah), 0) as sukuk_pemerintah,
						COALESCE(SUM(A.obligasi_korporasi), 0) as obligasi_korporasi,
						COALESCE(SUM(A.sukuk_korporasi), 0) as sukuk_korporasi,
						COALESCE(SUM(A.obligasi_mata_uang), 0) as obligasi_mata_uang,
						COALESCE(SUM(A.mtn), 0) as mtn,
						COALESCE(SUM(A.saham), 0) as saham,
						COALESCE(SUM(A.reksadana), 0) as reksadana,
						COALESCE(SUM(A.dana_invest_kik), 0) as dana_invest_kik,
						COALESCE(SUM(A.penyertaan_langsung), 0) as penyertaan_langsung,
						COALESCE(SUM(A.reksadana_pasar_uang), 0) as reksadana_pasar_uang,
						COALESCE(SUM(A.reksadana_pendapatan_tetap), 0) as reksadana_pendapatan_tetap,
						COALESCE(SUM(A.reksadana_campuran), 0) as reksadana_campuran,
						COALESCE(SUM(A.reksadana_saham), 0) as reksadana_saham,
						COALESCE(SUM(A.reksadana_terproteksi), 0) as reksadana_terproteksi,
						COALESCE(SUM(A.reksadana_pinjaman), 0) as reksadana_pinjaman,
						COALESCE(SUM(A.reksadana_index), 0) as reksadana_index,
						COALESCE(SUM(A.reksadana_kik), 0) as reksadana_kik,
						COALESCE(SUM(A.reksadana_penyertaaan_diperdagangkan), 0) as reksadana_penyertaaan_diperdagangkan,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_asabri A
						WHERE A.iduser = '".$iduser."'
						AND A.id_bulan = '".$id_bulan."'
						AND A.tahun = '".$tahun."'
					";
				}else{
					$sql="
						SELECT A.iduser, A.id_bulan,
						COALESCE(SUM(A.deposito), 0) as deposito,
						COALESCE(SUM(A.sertifikat_deposito), 0) as sertifikat_deposito,
						COALESCE(SUM(A.sun), 0) as sun,
						COALESCE(SUM(A.sukuk_pemerintah), 0) as sukuk_pemerintah,
						COALESCE(SUM(A.obligasi_korporasi), 0) as obligasi_korporasi,
						COALESCE(SUM(A.sukuk_korporasi), 0) as sukuk_korporasi,
						COALESCE(SUM(A.obligasi_mata_uang), 0) as obligasi_mata_uang,
						COALESCE(SUM(A.mtn), 0) as mtn,
						COALESCE(SUM(A.saham), 0) as saham,
						COALESCE(SUM(A.reksadana), 0) as reksadana,
						COALESCE(SUM(A.dana_invest_kik), 0) as dana_invest_kik,
						COALESCE(SUM(A.penyertaan_langsung), 0) as penyertaan_langsung,
						COALESCE(SUM(A.tanah_bangunan), 0) as tanah_bangunan,
						COALESCE(SUM(A.reksadana_pasar_uang), 0) as reksadana_pasar_uang,
						COALESCE(SUM(A.reksadana_pendapatan_tetap), 0) as reksadana_pendapatan_tetap,
						COALESCE(SUM(A.reksadana_campuran), 0) as reksadana_campuran,
						COALESCE(SUM(A.reksadana_saham), 0) as reksadana_saham,
						COALESCE(SUM(A.reksadana_terproteksi), 0) as reksadana_terproteksi,
						COALESCE(SUM(A.reksadana_pinjaman), 0) as reksadana_pinjaman,
						COALESCE(SUM(A.reksadana_index), 0) as reksadana_index,
						COALESCE(SUM(A.reksadana_kik), 0) as reksadana_kik,
						COALESCE(SUM(A.reksadana_penyertaaan_diperdagangkan), 0) as reksadana_penyertaaan_diperdagangkan,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_taspen A
						WHERE A.iduser = '".$iduser."'
						AND A.id_bulan = '".$id_bulan."'
						AND A.tahun = '".$tahun."'
					";
				}
			break;

			case 'sum_rincian_bkn_investasi':
				if($iduser == 'TSN002'){
					$sql="
						SELECT A.iduser, A.id_bulan,
						COALESCE(SUM(A.kas_bank), 0) as kas_bank,
						COALESCE(SUM(A.piutang_iuran), 0) as piutang_iuran,
						COALESCE(SUM(A.piutang_investasi), 0) as piutang_investasi,
						COALESCE(SUM(A.piutang_hasil_invest), 0) as piutang_hasil_invest,
						COALESCE(SUM(A.piutang_lainnya), 0) as piutang_lainnya,
						COALESCE(SUM(A.piutang_biaya_konpensasi_bank), 0) as piutang_biaya_konpensasi_bank,
						COALESCE(SUM(A.uangmuka_pph), 0) as uangmuka_pph,
						COALESCE(SUM(A.piutang_pihak_ketiga), 0) as piutang_pihak_ketiga,
						COALESCE(SUM(A.piutang_denda), 0) as piutang_denda,
						COALESCE(SUM(A.cadangan_penyisihan), 0) as cadangan_penyisihan,
						COALESCE(SUM(A.bangunan), 0) as bangunan,
						COALESCE(SUM(A.tanah_bangunan), 0) as tanah_bangunan,
						COALESCE(SUM(A.aset_lainnya), 0) as aset_lainnya,
						COALESCE(SUM(A.kendaraan), 0) as kendaraan,
						COALESCE(SUM(A.komputer), 0) as komputer,
						COALESCE(SUM(A.inventaris_kantor), 0) as inventaris_kantor,
						COALESCE(SUM(A.hak_guna_bangunan), 0) as hak_guna_bangunan,
						COALESCE(SUM(A.aset_tdk_berwujud), 0) as aset_tdk_berwujud,
						COALESCE(SUM(A.aset_tetap), 0) as aset_tetap,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_bkn_investasi_perpihak_taspen A
						WHERE A.iduser = '".$iduser."'
						AND A.id_bulan = '".$id_bulan."'
						AND A.tahun = '".$tahun."'
					";
				}elseif ($iduser == 'ASB003') {
					$sql="
						SELECT A.iduser, A.id_bulan,
						COALESCE(SUM(A.kas_bank), 0) as kas_bank,
						COALESCE(SUM(A.piutang_iuran), 0) as piutang_iuran,
						COALESCE(SUM(A.piutang_investasi), 0) as piutang_investasi,
						COALESCE(SUM(A.piutang_hasil_invest), 0) as piutang_hasil_invest,
						COALESCE(SUM(A.piutang_lainnya), 0) as piutang_lainnya,
						COALESCE(SUM(A.piutang_biaya_konpensasi_bank), 0) as piutang_biaya_konpensasi_bank,
						COALESCE(SUM(A.uangmuka_pph), 0) as uangmuka_pph,
						COALESCE(SUM(A.piutang_pihak_ketiga), 0) as piutang_pihak_ketiga,
						COALESCE(SUM(A.piutang_denda), 0) as piutang_denda,
						COALESCE(SUM(A.cadangan_penyisihan), 0) as cadangan_penyisihan,
						COALESCE(SUM(A.piutang_bum_kpr), 0) as piutang_bum_kpr,
						COALESCE(SUM(A.piutang_pum_kpr), 0) as piutang_pum_kpr,
						COALESCE(SUM(A.bangunan), 0) as bangunan,
						COALESCE(SUM(A.tanah_bangunan), 0) as tanah_bangunan,
						COALESCE(SUM(A.aset_lainnya), 0) as aset_lainnya,
						COALESCE(SUM(A.kendaraan), 0) as kendaraan,
						COALESCE(SUM(A.komputer), 0) as komputer,
						COALESCE(SUM(A.inventaris_kantor), 0) as inventaris_kantor,
						COALESCE(SUM(A.hak_guna_bangunan), 0) as hak_guna_bangunan,
						COALESCE(SUM(A.aset_tdk_berwujud), 0) as aset_tdk_berwujud,
						COALESCE(SUM(A.aset_tetap), 0) as aset_tetap,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_bkn_investasi_perpihak_asabri A
						WHERE A.iduser = '".$iduser."'
						AND A.id_bulan = '".$id_bulan."'
						AND A.tahun = '".$tahun."'
					";
				}else{
					$sql="
						SELECT A.iduser, A.id_bulan,
						COALESCE(SUM(A.kas_bank), 0) as kas_bank,
						COALESCE(SUM(A.piutang_iuran), 0) as piutang_iuran,
						COALESCE(SUM(A.piutang_investasi), 0) as piutang_investasi,
						COALESCE(SUM(A.piutang_hasil_invest), 0) as piutang_hasil_invest,
						COALESCE(SUM(A.piutang_lainnya), 0) as piutang_lainnya,
						COALESCE(SUM(A.piutang_biaya_konpensasi_bank), 0) as piutang_biaya_konpensasi_bank,
						COALESCE(SUM(A.uangmuka_pph), 0) as uangmuka_pph,
						COALESCE(SUM(A.piutang_pihak_ketiga), 0) as piutang_pihak_ketiga,
						COALESCE(SUM(A.piutang_denda), 0) as piutang_denda,
						COALESCE(SUM(A.cadangan_penyisihan), 0) as cadangan_penyisihan,
						COALESCE(SUM(A.bangunan), 0) as bangunan,
						COALESCE(SUM(A.tanah_bangunan), 0) as tanah_bangunan,
						COALESCE(SUM(A.aset_lainnya), 0) as aset_lainnya,
						COALESCE(SUM(A.kendaraan), 0) as kendaraan,
						COALESCE(SUM(A.komputer), 0) as komputer,
						COALESCE(SUM(A.inventaris_kantor), 0) as inventaris_kantor,
						COALESCE(SUM(A.hak_guna_bangunan), 0) as hak_guna_bangunan,
						COALESCE(SUM(A.aset_tdk_berwujud), 0) as aset_tdk_berwujud,
						COALESCE(SUM(A.aset_tetap), 0) as aset_tetap,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_bkn_investasi_perpihak_taspen A
						WHERE A.iduser = '".$iduser."'
						AND A.id_bulan = '".$id_bulan."'
						AND A.tahun = '".$tahun."'
					";
				}
			break;
			
			default:
				if($balikan=='get'){$where .=" AND A.id=".$this->input->post('id');}
				$sql="
					SELECT $select A.*, 
						DATE_FORMAT(A.create_date, '%d-%m-%Y %H:%i') as tanggal_buat 
					FROM ".$type." A ".$where."
					ORDER BY A.id DESC
					";
				if($balikan=='get')return $this->db->query($sql)->row_array();
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