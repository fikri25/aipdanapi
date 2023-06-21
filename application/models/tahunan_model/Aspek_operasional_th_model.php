<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_operasional_th_model extends CI_Model {
	private $table;
	function __construct(){
		parent::__construct();
		$this->tahun = $this->session->userdata('tahun');
		$this->iduser = $this->session->userdata('iduser');

	}

	/*============================================================================================================*/
	/* function keterangan */

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
	// 	$this->db->where('iduser', $smt);
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

	function get_combo($type="", $p1="", $p2=""){
		$array = array();
		$where  = " WHERE 1=1 ";
		$wher2  = " WHERE 1=1 ";
		$where3  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		
		$tahun = $this->session->userdata('tahun');

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			$where .= "
				AND B.iduser =  '".$iduser."'
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
			case "data_kelompok":
				if($level == 'DJA'){
					$iduser = $this->input->post('iduser');
					if ($iduser == 'TSN002') {
						$where3 .= "
						AND A.flag = '1'
						";
					}else if ($iduser == 'ASB003') {
						$where3 .= "
						AND A.flag = '2'
						";
					}
				}

				if($level == 'TASPEN'){
					$where3 .= "
					AND A.flag = '1'
					";
				}
				if($level == 'ASABRI'){
					$where3 .= "
					AND A.flag = '2'
					";
				}
				$sql = "
					SELECT A.id_kelompok as id, A.kelompok_penerima as txt
					FROM mst_kelompok_penerima A
					$where3
				";
				 // echo $sql;exit;
			break;
			case "data_jenis":
				$sql = "
					SELECT A.id_penerima as id, A.jenis_penerima as txt
					FROM mst_jenis_penerima A
				";
				 // echo $sql;exit;
			break;
			case "mst_cabang":
				$sql = "
					SELECT A.id_cabang AS id, A.nama_cabang AS txt
					FROM mst_cabang A
					$where
				";
				 // echo $sql;exit;
			break;
			case "data_cabang":
				// $sql = "
				// 	SELECT A.id_cabang AS id, A.nama_cabang AS txt, B.id_cabang,
				// 	SUM(B.pns_pusat_bayar_1) as pns_pusat_bayar_1, 
				// 	SUM(B.pns_do_bayar_1) as pns_do_bayar_1,
				// 	SUM(B.pejabat_bayar_1) as pejabat_bayar_1, 
				// 	SUM(B.hakim_bayar_1) as hakim_bayar_1, 
				// 	SUM(B.pkri_bayar_1) as pkri_bayar_1, 
				// 	SUM(B.veteran_bayar_1) as veteran_bayar_1, 
				// 	SUM(B.tni_polri_bayar_1) as tni_polri_bayar_1, 
				// 	SUM(B.pegadaian_bayar_1) as pegadaian_bayar_1, 
				// 	SUM(B.dana_kehormatan_bayar_1) as dana_kehormatan_bayar_1, 
				// 	SUM(B.prajurit_tni_bayar_1) as prajurit_tni_bayar_1, 
				// 	SUM(B.anggota_polri_bayar_1) as anggota_polri_bayar_1, 
				// 	SUM(B.asn_kemhan_bayar_1) as asn_kemhan_bayar_1, 
				// 	SUM(B.asn_polri_bayar_1) as asn_polri_bayar_1,

				// 	SUM(C.pns_pusat_bayar_2) as pns_pusat_bayar_2, 
				// 	SUM(C.pns_do_bayar_2) as pns_do_bayar_2,
				// 	SUM(C.pejabat_bayar_2) as pejabat_bayar_2, 
				// 	SUM(C.hakim_bayar_2) as hakim_bayar_2, 
				// 	SUM(C.pkri_bayar_2) as pkri_bayar_2, 
				// 	SUM(C.veteran_bayar_2) as veteran_bayar_2, 
				// 	SUM(C.tni_polri_bayar_2) as tni_polri_bayar_2, 
				// 	SUM(C.pegadaian_bayar_2) as pegadaian_bayar_2, 
				// 	SUM(C.dana_kehormatan_bayar_2) as dana_kehormatan_bayar_2, 
				// 	SUM(C.prajurit_tni_bayar_2) as prajurit_tni_bayar_2, 
				// 	SUM(C.anggota_polri_bayar_2) as anggota_polri_bayar_2, 
				// 	SUM(C.asn_kemhan_bayar_2) as asn_kemhan_bayar_2, 
				// 	SUM(C.asn_polri_bayar_2) as asn_polri_bayar_2,
					
				// 	SUM(B.pns_pusat_terima_1) as pns_pusat_terima_1, 
				// 	SUM(B.pns_do_terima_1) as pns_do_terima_1,
				// 	SUM(B.pejabat_terima_1) as pejabat_terima_1, 
				// 	SUM(B.hakim_terima_1) as hakim_terima_1, 
				// 	SUM(B.pkri_terima_1) as pkri_terima_1, 
				// 	SUM(B.veteran_terima_1) as veteran_terima_1, 
				// 	SUM(B.tni_polri_terima_1) as tni_polri_terima_1, 
				// 	SUM(B.pegadaian_terima_1) as pegadaian_terima_1, 
				// 	SUM(B.dana_kehormatan_terima_1) as dana_kehormatan_terima_1, 
				// 	SUM(B.prajurit_tni_terima_1) as prajurit_tni_terima_1, 
				// 	SUM(B.anggota_polri_terima_1) as anggota_polri_terima_1, 
				// 	SUM(B.asn_kemhan_terima_1) as asn_kemhan_terima_1, 
				// 	SUM(B.asn_polri_terima_1) as asn_polri_terima_1,

				// 	SUM(C.pns_pusat_terima_2) as pns_pusat_terima_2, 
				// 	SUM(C.pns_do_terima_2) as pns_do_terima_2,
				// 	SUM(C.pejabat_terima_2) as pejabat_terima_2, 
				// 	SUM(C.hakim_terima_2) as hakim_terima_2, 
				// 	SUM(C.pkri_terima_2) as pkri_terima_2, 
				// 	SUM(C.veteran_terima_2) as veteran_terima_2, 
				// 	SUM(C.tni_polri_terima_2) as tni_polri_terima_2, 
				// 	SUM(C.pegadaian_terima_2) as pegadaian_terima_2, 
				// 	SUM(C.dana_kehormatan_terima_2) as dana_kehormatan_terima_2, 
				// 	SUM(C.prajurit_tni_terima_2) as prajurit_tni_terima_2, 
				// 	SUM(C.anggota_polri_terima_2) as anggota_polri_terima_2, 
				// 	SUM(C.asn_kemhan_terima_2) as asn_kemhan_terima_2, 
				// 	SUM(C.asn_polri_terima_2) as asn_polri_terima_2

				// 	FROM dbsmartaip_".$tahun.".mst_cabang A
				// 	INNER JOIN(
				// 		SELECT * FROM dbsmartaip_".$tahun.".vw_pembayaran_pensiun_cabang
				// 	)B ON A.id_cabang=B.id_cabang
				// 	INNER JOIN(
				// 		SELECT * FROM dbsmartaip_".$tahun.".vw_pembayaran_pensiun_cabang
				// 	)C ON C.id_cabang=A.id_cabang
				// 	$where
				// 	AND B.id_cabang IS NOT NULL
				// 	AND B.sumber_dana = '".$p2."'
				// 	GROUP BY A.id_cabang
				// 	ORDER BY A.id_cabang ASC
				// ";

				$tahun_filter = $tahun - 1;

				$sql = "
					SELECT
						A.id_cabang AS id,
						A.nama_cabang AS txt,
						B.*, C.*
					FROM mst_cabang A
					LEFT JOIN (
						SELECT
						id_cabang,sumber_dana,iduser, tahun,
						SUM(pns_pusat_bayar_1) as pns_pusat_bayar_1, 
						SUM(pns_do_bayar_1) as pns_do_bayar_1,
						SUM(pejabat_bayar_1) as pejabat_bayar_1, 
						SUM(hakim_bayar_1) as hakim_bayar_1, 
						SUM(pkri_bayar_1) as pkri_bayar_1, 
						SUM(veteran_bayar_1) as veteran_bayar_1, 
						SUM(tni_polri_bayar_1) as tni_polri_bayar_1, 
						SUM(pegadaian_bayar_1) as pegadaian_bayar_1, 
						SUM(dana_kehormatan_bayar_1) as dana_kehormatan_bayar_1, 
						SUM(prajurit_tni_bayar_1) as prajurit_tni_bayar_1, 
						SUM(anggota_polri_bayar_1) as anggota_polri_bayar_1, 
						SUM(asn_kemhan_bayar_1) as asn_kemhan_bayar_1, 
						SUM(asn_polri_bayar_1) as asn_polri_bayar_1,

						SUM(pns_pusat_terima_1) as pns_pusat_terima_1, 
						SUM(pns_do_terima_1) as pns_do_terima_1,
						SUM(pejabat_terima_1) as pejabat_terima_1, 
						SUM(hakim_terima_1) as hakim_terima_1, 
						SUM(pkri_terima_1) as pkri_terima_1, 
						SUM(veteran_terima_1) as veteran_terima_1, 
						SUM(tni_polri_terima_1) as tni_polri_terima_1, 
						SUM(pegadaian_terima_1) as pegadaian_terima_1, 
						SUM(dana_kehormatan_terima_1) as dana_kehormatan_terima_1, 
						SUM(prajurit_tni_terima_1) as prajurit_tni_terima_1, 
						SUM(anggota_polri_terima_1) as anggota_polri_terima_1, 
						SUM(asn_kemhan_terima_1) as asn_kemhan_terima_1, 
						SUM(asn_polri_terima_1) as asn_polri_terima_1
						FROM
						vw_pembayaran_pensiun_cabang
						WHERE iduser = '".$iduser."'
						AND sumber_dana = '".$p2."'
						AND tahun = '".$tahun."'
						GROUP BY id_cabang
					) B ON A.id_cabang = B.id_cabang
					LEFT JOIN (
						SELECT
						id_cabang,sumber_dana,iduser, tahun,
						SUM(pns_pusat_bayar_2) as pns_pusat_bayar_2, 
						SUM(pns_do_bayar_2) as pns_do_bayar_2,
						SUM(pejabat_bayar_2) as pejabat_bayar_2, 
						SUM(hakim_bayar_2) as hakim_bayar_2, 
						SUM(pkri_bayar_2) as pkri_bayar_2, 
						SUM(veteran_bayar_2) as veteran_bayar_2, 
						SUM(tni_polri_bayar_2) as tni_polri_bayar_2, 
						SUM(pegadaian_bayar_2) as pegadaian_bayar_2, 
						SUM(dana_kehormatan_bayar_2) as dana_kehormatan_bayar_2, 
						SUM(prajurit_tni_bayar_2) as prajurit_tni_bayar_2, 
						SUM(anggota_polri_bayar_2) as anggota_polri_bayar_2, 
						SUM(asn_kemhan_bayar_2) as asn_kemhan_bayar_2, 
						SUM(asn_polri_bayar_2) as asn_polri_bayar_2,

						SUM(pns_pusat_terima_2) as pns_pusat_terima_2, 
						SUM(pns_do_terima_2) as pns_do_terima_2,
						SUM(pejabat_terima_2) as pejabat_terima_2, 
						SUM(hakim_terima_2) as hakim_terima_2, 
						SUM(pkri_terima_2) as pkri_terima_2, 
						SUM(veteran_terima_2) as veteran_terima_2, 
						SUM(tni_polri_terima_2) as tni_polri_terima_2, 
						SUM(pegadaian_terima_2) as pegadaian_terima_2, 
						SUM(dana_kehormatan_terima_2) as dana_kehormatan_terima_2, 
						SUM(prajurit_tni_terima_2) as prajurit_tni_terima_2, 
						SUM(anggota_polri_terima_2) as anggota_polri_terima_2, 
						SUM(asn_kemhan_terima_2) as asn_kemhan_terima_2, 
						SUM(asn_polri_terima_2) as asn_polri_terima_2
						FROM
						vw_pembayaran_pensiun_cabang
						WHERE iduser = '".$iduser."'
						AND sumber_dana = '".$p2."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_cabang
					) C ON C.id_cabang = A.id_cabang
					WHERE A.iduser = '".$iduser."'
					AND B.id_cabang IS NOT NULL
					AND B.sumber_dana = '".$p2."'
					GROUP BY A.id_cabang
					ORDER BY A.id_cabang ASC
				";
				// echo $sql;exit;
			break;
			case "sub_reksadana":
				$sql = "
					SELECT A.id_investasi as id, A.jenis_investasi as txt
					FROM mst_investasi A
					$where
					AND A.parent_id = '".$p1."'
				";
				// echo $sql;exit;
			break;
		}
		
		return $this->db->query($sql)->result_array();
	}

	function getdataindex($type="", $balikan="", $p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";
		$where2  = " WHERE 1=1 ";
		$where3 = "";
		$where_sm1 = " WHERE 1=1 ";
		$where_sm2 = " WHERE 1=1 ";
		
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
			case 'data_aset_investasi_header':
				$sql = "
					SELECT A.*, B.*
					FROM bln_aset_investasi_header A  
					LEFT JOIN mst_investasi B  on B.id_investasi = A.id_investasi
					WHERE A.iduser ='".$p1."' 
					AND A.id_bulan = '".$p2."'
					AND A.tahun = '".$tahun."'
					AND B.`group` ='INVESTASI'  
					ORDER BY A.id_investasi ASC
				";
				// echo $sql;exit;
			break;
			// untuk index aset investasi dan aset bukan Investasi
			case 'aset_investasi_front':
				$tahun_filter = $tahun - 1;

				if ($p1 == 'INVESTASI') {
					$where_sm1 .= "
						AND id_bulan = '6'
					";

					$where_sm2 .= "
						AND id_bulan = '12'
					";
				}else if ($p1 == 'HASIL INVESTASI') {
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 6
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 7 AND 12
					";
				}else{
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 12
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 1 AND 12
					";
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.rka, 
					COALESCE(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir_thn end, 0) as saldo_akhir_thn,
					COALESCE(CASE WHEN A.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir_thn_lalu end, 0) as saldo_akhir_thn_lalu,
					B.id,
					D.mutasi_penambahan as mutasi_penambahan,
					D.mutasi_pengurangan as mutasi_pengurangan
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, rka, sum(saldo_akhir_invest) as saldo_akhir_thn, sum(mutasi_invest) as mutasi, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						$where_sm1
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id,id_investasi, rka, sum(saldo_akhir_invest) as saldo_akhir_thn_lalu, sum(mutasi_invest) as mutasi, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						$where_sm2
						AND iduser= '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) C ON A.id_investasi = C.id_investasi
					LEFT JOIN (
						SELECT bln_aset_investasi_header_id, COALESCE(mutasi_pembelian, 0) as mutasi_pembelian,
							COALESCE(mutasi_penjualan, 0) as mutasi_penjualan, 
							COALESCE(mutasi_penanaman, 0) as mutasi_penanaman, 
							COALESCE(mutasi_pencairan, 0) as mutasi_pencairan, 
							(COALESCE(sum(mutasi_pembelian), 0)+COALESCE(sum(mutasi_penanaman), 0)) as mutasi_penambahan,
							(COALESCE(sum(mutasi_penjualan), 0)+COALESCE(sum(mutasi_pencairan), 0)) as mutasi_pengurangan,
							id_bulan, iduser, tahun
						FROM bln_aset_investasi_detail
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id = D.bln_aset_investasi_header_id
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
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id_investasi, jenis_investasi as parent_investasi,
						type_sub_jenis_investasi as type
						FROM mst_investasi
					)C on A.parent_id = C.id_investasi
					WHERE A.`group` ='".$p2."'
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'C')
					AND A.parent_id ='".$p1."'
					ORDER BY A.no_urut ASC

				";
			break;

			case 'aset_investasi_front_lv3':
				$tahun_filter = $tahun - 1;

				if ($p1 == 'INVESTASI') {
					$where_sm1 .= "
						AND id_bulan = '6'
					";

					$where_sm2 .= "
						AND id_bulan = '12'
					";
				}else if ($p1 == 'HASIL INVESTASI') {
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 6
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 7 AND 12
					";
				}else{
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 12
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 1 AND 12
					";
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type,B.id,
					B.rka as rka, 
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir end), 0) as saldo_akhir_thn,
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_thn_lalu,
					D.mutasi_penambahan as mutasi_penambahan,
					D.mutasi_pengurangan as mutasi_pengurangan
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, sum(saldo_awal_invest) as saldo_awal, sum(mutasi_invest) as mutasi, rka, realisasi_rka,
						sum(saldo_akhir_invest) as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						$where_sm1
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id,id_investasi, sum(saldo_awal_invest) as saldo_awal, sum(mutasi_invest) as mutasi, rka, realisasi_rka,
						sum(saldo_akhir_invest) as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						$where_sm2
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) C ON A.id_investasi = C.id_investasi
					LEFT JOIN (
						SELECT bln_aset_investasi_header_id, COALESCE(mutasi_pembelian, 0) as mutasi_pembelian,
							COALESCE(sum(mutasi_penjualan), 0) as mutasi_penjualan, 
							COALESCE(sum(mutasi_penanaman), 0) as mutasi_penanaman, 
							COALESCE(sum(mutasi_pencairan), 0) as mutasi_pencairan, 
							(COALESCE(sum(mutasi_pembelian), 0)+COALESCE(sum(mutasi_penanaman), 0)) as mutasi_penambahan,
							(COALESCE(sum(mutasi_penjualan), 0)+COALESCE(sum(mutasi_pencairan), 0)) as mutasi_pengurangan,
							id_bulan, iduser, tahun
						FROM bln_aset_investasi_detail
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id = D.bln_aset_investasi_header_id
					WHERE A.`group` ='".$p2."'
					AND A.iduser = '".$iduser."'
					AND A.parent_id ='".$p1."'
					GROUP BY A.id_investasi
					ORDER BY A.no_urut ASC

				";
				// echo $sql;exit;
			break;

			case 'aset_investasi_front_sum':
				$semester = $this->input->post('semester');
				if($semester != ""){
					if ($semester == 1) {
						$tahun_filter = $tahun - 1;
					}else{
						$tahun_filter = $tahun;
					}
				}else{
					$tahun_filter = $tahun;
				}

				if ($p1 == 'INVESTASI') {
					$where_sm1 .= "
						AND id_bulan = '6'
					";

					$where_sm2 .= "
						AND id_bulan = '12'
					";
				}else if ($p1 == 'HASIL INVESTASI') {
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 6
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 7 AND 12
					";
				}else{
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 12
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 1 AND 12
					";
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type,B.id,
					B.rka as rka, 
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir end), 0) as saldo_akhir_thn,
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_thn_lalu,

					COALESCE(SUM(D.mutasi_penambahan), 0) AS mutasi_penambahan,
					COALESCE(SUM(D.mutasi_pengurangan), 0) AS mutasi_pengurangan
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, sum(saldo_awal_invest) as saldo_awal, sum(mutasi_invest) as mutasi, rka, realisasi_rka,
						sum(saldo_akhir_invest) as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						$where_sm1
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id,id_investasi, sum(saldo_awal_invest) as saldo_awal, sum(mutasi_invest) as mutasi, rka, realisasi_rka,
						sum(saldo_akhir_invest) as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						$where_sm2
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) C ON A.id_investasi = C.id_investasi
					LEFT JOIN (
						SELECT bln_aset_investasi_header_id, COALESCE(mutasi_pembelian, 0) as mutasi_pembelian,
							COALESCE(mutasi_penjualan, 0) as mutasi_penjualan, 
							COALESCE(mutasi_penanaman, 0) as mutasi_penanaman, 
							COALESCE(mutasi_pencairan, 0) as mutasi_pencairan, 
							(COALESCE(sum(mutasi_pembelian), 0)+COALESCE(sum(mutasi_penanaman), 0)) as mutasi_penambahan,
							(COALESCE(sum(mutasi_penjualan), 0)+COALESCE(sum(mutasi_pencairan), 0)) as mutasi_pengurangan,
							id_bulan, iduser
						FROM bln_aset_investasi_detail
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id = D.bln_aset_investasi_header_id
					WHERE A.`group` ='".$p1."'
					AND A.iduser = '".$iduser."'
					ORDER BY A.no_urut ASC
				";

				// echo $sql;exit();
			break;


			case 'karakteristik_invest_lv1':
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.karakteristik, B.resiko, B.id
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, karakteristik, resiko,iduser
						FROM tb_karakteristik_invest
						WHERE semester='1'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					WHERE A.`group`='".$p1."' 
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'P' OR A.type_sub_jenis_investasi = 'PC')
					GROUP BY A.id_investasi
					ORDER BY A.no_urut ASC
				";
				// echo $sql;exit;
			break;

			case 'karakteristik_invest_lv2':
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.karakteristik, B.resiko, B.id
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, karakteristik, resiko,iduser
						FROM tb_karakteristik_invest
						WHERE semester='1'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					WHERE A.`group` ='".$p2."'
					AND A.iduser = '".$iduser."'
					AND A.parent_id ='".$p1."'
					GROUP BY A.id_investasi
					ORDER BY A.no_urut ASC

				";
				// echo $sql;exit;
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

	function getdata($type="", $balikan="", $p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";
		$where2  = " WHERE 1=1 ";
		$where3 = "WHERE 1=1";
		
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
			case 'pembayaran_pensiun_kelompok':
				if($level == 'TASPEN'){
					$where3 .= "
					AND A.flag = '1'
					";
				}
				if($level == 'ASABRI'){
					$where3 .= "
					AND A.flag = '2'
					";
				}

				if($level == 'DJA'){
					$iduser = $this->input->post('iduser');
					if ($iduser == 'TSN002') {
						$where3 .= "
						AND A.flag = '1'
						";
					}else if ($iduser == 'ASB003') {
						$where3 .= "
						AND A.flag = '2'
						";
					}else{
						$where3 .= "
						AND A.flag = '1'
						";
					}
				}

				$tahun_filter = $tahun - 1;

				$sql ="
					SELECT A.*,
					COALESCE((B.rka_penerima), 0) as rka_penerima, 
					COALESCE((B.rka_pembayaran), 0) as rka_pembayaran, 
					COALESCE((C.jml_penerima), 0) as jml_penerima_thn, 
					COALESCE((C.jml_pembayaran), 0) as jml_pembayaran_thn, 
					COALESCE((D.jml_penerima), 0) as jml_penerima_thn_lalu, 
					COALESCE((D.jml_pembayaran), 0) as jml_pembayaran_thn_lalu,
					ROUND((B.rka_penerima/C.jml_penerima)*100, 2) as pers_penerimaan,
					ROUND((B.rka_pembayaran/C.jml_pembayaran)*100, 2) as pers_pembayaran,
					ROUND(((D.jml_penerima - C.jml_penerima)/C.jml_penerima)*100, 2) as pers_kenaikan_penerima,
					ROUND(((D.jml_pembayaran - C.jml_pembayaran)/C.jml_pembayaran)*100, 2) as pers_kenaikan_pembayaran,
					C.id as id_thn, D.id as id_thn_lalu, B.id as id_rka_thn
					FROM mst_kelompok_penerima A
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(rka_penerima), 0) as rka_penerima, 
						COALESCE(SUM(rka_pembayaran), 0) as rka_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_header
						WHERE iduser ='".$iduser."'
						AND semester IN ('1', '2')
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun."'
						GROUP BY id_kelompok
					) B ON A.id_kelompok=B.id_kelompok
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester IN ('1', '2')
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun."'
						GROUP BY id_kelompok
					) C ON A.id_kelompok=C.id_kelompok
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester IN ('1', '2')
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_kelompok
					) D ON A.id_kelompok=D.id_kelompok
					$where3
					GROUP BY id_kelompok
					ORDER BY A.id_kelompok
				";
				  // echo $sql;exit;
			break;

			case 'pembayaran_pensiun_jenis':
				$tahun_filter = $tahun - 1;
				$sql="
					SELECT A.*,
					COALESCE(SUM(B.rka_penerima), 0) as rka_penerima, 
					COALESCE(SUM(B.rka_pembayaran), 0) as rka_pembayaran, 
					COALESCE((C.jml_penerima), 0) as jml_penerima_thn, 
					COALESCE((C.jml_pembayaran), 0) as jml_pembayaran_thn, 
					COALESCE((D.jml_penerima), 0) as jml_penerima_thn_lalu, 
					COALESCE((D.jml_pembayaran), 0) as jml_pembayaran_thn_lalu,
					ROUND((B.rka_penerima/C.jml_penerima)*100, 2) as pers_penerimaan,
					ROUND((B.rka_pembayaran/C.jml_pembayaran)*100, 2) as pers_pembayaran,
					ROUND(((D.jml_penerima - C.jml_penerima)/C.jml_penerima)*100, 2) as pers_kenaikan_penerima,
					ROUND(((D.jml_pembayaran - C.jml_pembayaran)/C.jml_pembayaran)*100, 2) as pers_kenaikan_pembayaran
					FROM mst_jenis_penerima A
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id,rka_penerima,rka_pembayaran,tahun
						FROM tbl_lkao_pembayaran_pensiun_header
						WHERE iduser ='".$iduser."'
						AND semester IN ('1', '2')
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun."'
					) B ON A.id_penerima=B.id_penerima
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester IN ('1', '2')
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun."'
						GROUP BY id_penerima
					) C ON A.id_penerima=C.id_penerima
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester IN ('1', '2')
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_penerima
					) D ON A.id_penerima=D.id_penerima
					GROUP BY A.id_penerima
					ORDER BY A.id_penerima
				";
			break;
			case 'pembayaran_pensiun_cabang':
				// $sql ="
					// select * from dbsmartaip_".$tahun.".vw_pembayaran_pensiun_cabang
					// WHERE id_cabang ='".$p1."'
					// AND iduser ='".$iduser."'
					// AND sumber_dana ='".$p2."'
				// ";

				$tahun_filter = $tahun - 1;

				$sql ="
					SELECT A.*, B.id_penerima, B.jenis_penerima,
						B.pns_pusat_bayar_1, 
						B.pns_do_bayar_1,
						B.pejabat_bayar_1, 
						B.hakim_bayar_1, 
						B.pkri_bayar_1, 
						B.veteran_bayar_1, 
						B.tni_polri_bayar_1, 
						B.pegadaian_bayar_1, 
						B.dana_kehormatan_bayar_1, 
						B.prajurit_tni_bayar_1, 
						B.anggota_polri_bayar_1, 
						B.asn_kemhan_bayar_1, 
						B.asn_polri_bayar_1,

						B.pns_pusat_terima_1, 
						B.pns_do_terima_1,
						B.pejabat_terima_1, 
						B.hakim_terima_1, 
						B.pkri_terima_1, 
						B.veteran_terima_1, 
						B.tni_polri_terima_1, 
						B.pegadaian_terima_1, 
						B.dana_kehormatan_terima_1, 
						B.prajurit_tni_terima_1, 
						B.anggota_polri_terima_1, 
						B.asn_kemhan_terima_1, 
						B.asn_polri_terima_1,

						C.pns_pusat_bayar_2, 
						C.pns_do_bayar_2,
						C.pejabat_bayar_2, 
						C.hakim_bayar_2, 
						C.pkri_bayar_2, 
						C.veteran_bayar_2, 
						C.tni_polri_bayar_2, 
						C.pegadaian_bayar_2, 
						C.dana_kehormatan_bayar_2, 
						C.prajurit_tni_bayar_2, 
						C.anggota_polri_bayar_2, 
						C.asn_kemhan_bayar_2, 
						C.asn_polri_bayar_2,

						C.pns_pusat_terima_2, 
						C.pns_do_terima_2,
						C.pejabat_terima_2, 
						C.hakim_terima_2, 
						C.pkri_terima_2, 
						C.veteran_terima_2, 
						C.tni_polri_terima_2, 
						C.pegadaian_terima_2, 
						C.dana_kehormatan_terima_2, 
						C.prajurit_tni_terima_2, 
						C.anggota_polri_terima_2, 
						C.asn_kemhan_terima_2, 
						C.asn_polri_terima_2

					FROM mst_cabang A
					LEFT JOIN(
						SELECT * FROM vw_pembayaran_pensiun_cabang
						WHERE iduser ='".$iduser."'
						AND tahun = '".$tahun."'
					)B ON A.id_cabang=B.id_cabang
					LEFT JOIN(
						SELECT * FROM vw_pembayaran_pensiun_cabang
						WHERE 
						iduser ='".$iduser."'
						AND tahun = '".$tahun_filter."'
					)C ON C.id_cabang=A.id_cabang
					WHERE B.id_cabang ='".$p1."'
					AND A.iduser ='".$iduser."'
					AND B.sumber_dana ='".$p2."'
					AND B.id_cabang IS NOT NULL
					GROUP BY A.id_cabang, B.jenis_penerima
					ORDER BY B.id_penerima ASC
				";

				// echo $sql; exit;
			break;

			case 'nilai_tunai_header':
				$tahun_filter = $tahun - 1;

				$sql ="
					SELECT A.id, A.iduser, A.semester, 
					A.rka_penerima, 
					A.rka_pembayaran, A.filedata,
					COALESCE(SUM(B.jml_penerima), 0) as jml_penerima_thn,
					COALESCE(SUM(B.jml_pembayaran), 0) as jml_pembayaran_thn,
					COALESCE(SUM(C.jml_penerima), 0) as jml_penerima_thn_lalu,
					COALESCE(SUM(C.jml_pembayaran), 0) as jml_pembayaran_thn_lalu,
					COALESCE(ROUND((rka_penerima/C.jml_penerima)*100, 2), 0) as pers_penerimaan,
					COALESCE(ROUND((rka_pembayaran/C.jml_pembayaran)*100, 2), 0) as pers_pembayaran,
					COALESCE(ROUND(((C.jml_penerima - B.jml_penerima)/B.jml_penerima)*100, 2), 0) as pers_kenaikan_penerima,
					COALESCE(ROUND(((C.jml_pembayaran - B.jml_pembayaran)/B.jml_pembayaran)*100, 2), 0) as pers_kenaikan_pembayaran
					FROM tbl_nilai_tunai_header A
					LEFT JOIN(
						SELECT tbl_nilai_tunai_header_id,jml_penerima, jml_pembayaran, tahun
						FROM tbl_nilai_tunai_detail
						WHERE semester IN ('1','2')
						AND iduser ='".$iduser."'
						AND tahun = '".$tahun."'
					)B ON A.id=B.tbl_nilai_tunai_header_id
					LEFT JOIN(
						SELECT tbl_nilai_tunai_header_id,jml_penerima, jml_pembayaran, tahun
						FROM tbl_nilai_tunai_detail
						WHERE semester IN ('1','2')
						AND iduser ='".$iduser."'
						AND tahun = '".$tahun_filter."'
					)C ON A.id=C.tbl_nilai_tunai_header_id
					WHERE A.iduser ='".$iduser."'
					AND A.tahun = '".$tahun_filter."'
			
				";
				 // echo $sql; exit;
			break;

			case 'nilai_tunai_detail':
				$tahun_filter = $tahun - 1;

				$sql="
					SELECT A.*,
					COALESCE(B.jml_penerima, 0) as jml_penerima_thn,
					COALESCE(B.jml_pembayaran, 0) as jml_pembayaran_thn,
					COALESCE(C.jml_penerima, 0) as jml_penerima_thn_lalu,
					COALESCE(C.jml_pembayaran, 0) as jml_pembayaran_thn_lalu,
					COALESCE(ROUND(((C.jml_penerima - B.jml_penerima)/B.jml_penerima)*100, 2), 0) as pers_kenaikan_penerima,
					COALESCE(ROUND(((C.jml_pembayaran - B.jml_pembayaran)/B.jml_pembayaran)*100, 2), 0) as pers_kenaikan_pembayaran
					FROM mst_cabang A
					LEFT JOIN(
						SELECT id_cabang,tbl_nilai_tunai_header_id,jml_penerima, jml_pembayaran, tahun
						FROM tbl_nilai_tunai_detail
						WHERE semester IN ('1','2')
						AND iduser ='".$iduser."'
						AND tahun = '".$tahun."'
					)B ON A.id_cabang=B.id_cabang
					LEFT JOIN(
						SELECT id_cabang,tbl_nilai_tunai_header_id,jml_penerima, jml_pembayaran, tahun 
						FROM tbl_nilai_tunai_detail
						WHERE semester IN ('1','2')
						AND iduser ='".$iduser."'
						AND tahun = '".$tahun_filter."'
					)C ON A.id_cabang=C.id_cabang
					WHERE B.tbl_nilai_tunai_header_id IS NOT NULL
					AND A.iduser ='".$iduser."'

				";

				// echo $sql; exit;
			break;
			case 'tbl_nilai_tunai_header':
				$sql="
					SELECT A.*
					FROM tbl_nilai_tunai_header A
					WHERE A.semester = '".$p2."'
					AND tahun = '".$tahun."'
				";
			break;

			case 'tbl_nilai_tunai_detail':
				$sql="
					SELECT A.*
					FROM tbl_nilai_tunai_detail A
					WHERE A.semester = '".$p2."'
					AND tahun = '".$tahun."'
				";
			break;

			case 'lkob_imbal_jasa':
				$tahun_filter = $tahun - 1;
				
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_thn,
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir end), 0) as saldo_akhir_thn_lalu,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND NOT B.`group`= 'IURAN'
					AND (B.jenis_investasi = 'Beban Investasi' OR B.`group`= 'HASIL INVESTASI')
					GROUP BY B.group
					ORDER BY B.no_urut_group ASC
				";
			break;

			case 'pembayaran_aip_cbg_header':
				$sql="
					SELECT A.id, A.iduser, A.id_cabang, A.id_penerima, A.id_kelompok, A.semester, A.tahun
					FROM tbl_lkao_pembayaran_pensiun_detail A
					WHERE A.sumber_dana ='".$p3."'
					AND A.iduser ='".$iduser."'
					AND A.id_kelompok ='".$p1."'
					AND A.semester ='".$p2."'
					AND A.tahun = '".$tahun."'
					GROUP BY A.id_kelompok
				";
			break;

			case 'pembayaran_aip_cbg_detail':
				$sql="
					SELECT A.id, A.iduser, A.id_cabang, A.id_penerima, A.id_kelompok, A.jml_penerima, A.jml_pembayaran, A.semester, A.tahun,
					B.nama_cabang, C.jenis_penerima
					FROM tbl_lkao_pembayaran_pensiun_detail A
					LEFT JOIN mst_cabang B ON A.id_cabang = B.id_cabang
					LEFT JOIN mst_jenis_penerima C ON A.id_penerima = C.id_penerima
					WHERE A.sumber_dana ='".$p3."'
					AND A.id_kelompok ='".$p1."'
					AND A.semester ='".$p2."'
					AND A.iduser ='".$iduser."'
					AND A.tahun = '".$tahun."'
					GROUP BY A.id_kelompok, A.id_cabang
				";
				 // echo $sql;exit;
			break;

			case 'pembayaran_aip_cbg_detail_cabang':
				$sql="
					SELECT A.id, A.iduser, A.id_cabang, A.id_penerima, A.id_kelompok, A.jml_penerima, A.jml_pembayaran, A.semester, B.nama_cabang, A.tahun,
					C.jenis_penerima
					FROM tbl_lkao_pembayaran_pensiun_detail A
					LEFT JOIN mst_cabang B ON A.id_cabang = B.id_cabang
					LEFT JOIN mst_jenis_penerima C ON A.id_penerima = C.id_penerima
					WHERE A.sumber_dana ='".$p4."'
					AND A.id_kelompok ='".$p1."'
					AND A.semester ='".$p2."'
					AND A.iduser ='".$iduser."'
					AND A.id_cabang ='".$p3."'
					AND A.tahun = '".$tahun."'
					ORDER BY A.id_penerima ASC
				";
			break;

			case 'pembayaran_aip_header':
				$sql="
					SELECT A.id, A.iduser, A.id_penerima, A.id_kelompok, A.semester, A.tahun
					FROM tbl_lkao_pembayaran_pensiun_header A
					WHERE A.sumber_dana ='".$p3."'
					AND A.iduser ='".$iduser."'
					AND A.id_kelompok ='".$p1."'
					AND A.semester ='".$p2."'
					AND A.tahun = '".$tahun."'
					GROUP BY A.id_kelompok
				";
			break;

			case 'pembayaran_aip_detail':
				$sql="
					SELECT A.id, A.iduser,A.id_penerima, A.id_kelompok, A.rka_penerima, A.rka_pembayaran, A.semester, A.tahun,
					B.jenis_penerima
					FROM tbl_lkao_pembayaran_pensiun_header A
					LEFT JOIN mst_jenis_penerima B ON A.id_penerima = B.id_penerima
					WHERE A.sumber_dana ='".$p3."'
					AND A.id_kelompok ='".$p1."'
					AND A.semester ='".$p2."'
					AND A.iduser ='".$iduser."'
					AND A.tahun = '".$tahun."'
					ORDER BY A.id_penerima ASC
				";
			break;
			case 'data_beban_tenaga_kerja':
				$sql="
					SELECT
					B.nama_cabang,
					COALESCE (SUM(A.jml_penyelenggaraan), 0) AS jml_penyelenggaraan,
					COALESCE (SUM(A.persen_penyelenggaraan), 0) AS persen_penyelenggaraan,
					COALESCE (SUM(A.jml_lain), 0) AS jml_lain,
					COALESCE (SUM(A.persen_lain), 0) AS persen_lain
					FROM
					tbl_lkao_tenaga_kerja A
					LEFT JOIN mst_cabang B ON A.id_cabang = B.id_cabang
					WHERE A.iduser ='".$iduser."'
					AND A.tahun = '".$tahun."'
					GROUP BY A.iduser, A.id_cabang
					ORDER BY
					A.id DESC
				";

				// echo $sql;exit();
			break;

			case 'cek_nilai_tunai':
				$sql="
					SELECT COUNT(*) as total
					FROM tbl_nilai_tunai_header 
					WHERE semester ='".$p1."'
					AND iduser ='".$iduser."'
					AND tahun = '".$tahun."'
				";
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