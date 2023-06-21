<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisis_model extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->tahun = $this->session->userdata('tahun');
		$this->iduser = $this->session->userdata('iduser');
	}

	function get_combo($type="", $p1="", $p2=""){
		$array = array();
		$where  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		
		$tahun = $this->session->userdata('tahun');

		if($level == 'TASPEN' || $level == 'ASABRI'){ // user Resepsinis
			$iduser = $this->session->userdata('iduser');
			$where .= "
				AND A.iduser = '".$iduser."'
			";
		}

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			$where .= "
				AND A.iduser =  '".$iduser."'
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
			case "mst_investasi":
				$sql = "
					SELECT A.id_investasi as id, A.jenis_investasi as txt
					FROM mst_investasi A
					$where
					AND A.`group`= 'INVESTASI'
					ORDER BY A.id_investasi ASC
				";
				// echo $sql;exit;
			break;

			case 'cabang':
				$sql="
					SELECT A.id_cabang as id, A.nama_cabang as txt
					FROM mst_cabang A
					$where
				";
			break;

			case 'combo_beban_investasi':
				if($p1){
					$where .= "
					AND A.id_investasi =  '".$p1."'
					";
				}

				$sql="
					SELECT A.id_investasi as id, A.jenis_investasi as txt
					FROM mst_investasi A 
					$where
					AND A.`group` = 'BEBAN INVESTASI'
					AND A.type_sub_jenis_investasi = 'PC'
					ORDER BY A. no_urut ASC
				";
			break;

			case 'combo_detail_beban_investasi':
				$sql="
					SELECT A.id_investasi as id, A.jenis_investasi as txt
					FROM mst_investasi A 
					$where
					AND A.`group` = 'BEBAN INVESTASI'
					AND A.type_sub_jenis_investasi = 'C'
					AND A.parent_id = '".$p1."'
					ORDER BY A. no_urut ASC
				";
			break;
		}
		
		return $this->db->query($sql)->result_array();
	}

	function getdataSemester($type="", $balikan="", $p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";
		$where2  = " WHERE 1=1 ";
		$where3 = " WHERE 1=1";
		
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
			if ($iduser != "") {
				$iduser = $iduser;
				$where .= "
					AND A.iduser =  '".$iduser."'
				";
			}else{
				$iduser = 'TSN002';
				$where .= "
					AND A.iduser =  'TSN002'
				";
			}
			
		}

		if($level == 'TASPEN' || $level == 'ASABRI'){
			$iduser = $this->session->userdata('iduser');
			$where .= "
				AND A.iduser = '".$iduser."'
			";
		}

		switch($type){
			case 'klaim_detail':
				$tahun_filter = $this->input->post('tahun_awal');
				if ($tahun_filter != "") {
					$tahun_filter = $tahun_filter;
				}else{
					$tahun_filter = $tahun;
				}

				$sql ="
					SELECT A.id, A.iduser, A.jenis_klaim as kode_klaim,
					D.jenis_klaim,
					COALESCE(SUM(B.jml_klaim), 0) as jml_klaim_smt1,
					COALESCE(SUM(B.jml_pembayaran), 0) as jml_pembayaran_smt1,
					COALESCE(SUM(C.jml_klaim), 0) as jml_klaim_smt2,
					COALESCE(SUM(C.jml_pembayaran), 0) as jml_pembayaran_smt2,
					COALESCE(ROUND(C.jml_pembayaran - B.jml_pembayaran), 0) as nom_pertumbuhan,
					COALESCE(ROUND(((C.jml_pembayaran - B.jml_pembayaran)/B.jml_pembayaran)*100, 2), 0) as pers_pertumbuhan
					FROM tbl_lkob_klaim_header A
					LEFT JOIN(
						SELECT id as id_smt1, jenis_klaim, tbl_lkob_klaim_header_id,jml_klaim, jml_pembayaran, tahun
						FROM tbl_lkob_klaim_detail
						WHERE semester = '1'
						AND iduser ='".$iduser."'
						AND tahun ='".$tahun_filter."'
					)B ON A.id=B.tbl_lkob_klaim_header_id
					LEFT JOIN(
						SELECT id as id_smt2, jenis_klaim, tbl_lkob_klaim_header_id,jml_klaim, jml_pembayaran, tahun
						FROM tbl_lkob_klaim_detail
						WHERE semester = '2'
						AND iduser ='".$iduser."'
						AND tahun ='".$tahun_filter."'
					)C ON A.id=C.tbl_lkob_klaim_header_id
					LEFT JOIN mst_jenis_klaim D ON A.jenis_klaim=D.kode_klaim
					WHERE D.iduser ='".$iduser."'
					AND A.iduser ='".$iduser."'
					GROUP BY A.jenis_klaim 
					ORDER BY A.jenis_klaim DESC
			
				";
				// echo $sql;exit;
			break;

			case 'nilai_tunai_detail':
				$tahun_filter = $this->input->post('tahun_awal');
				if ($tahun_filter != "") {
					$tahun_filter = $tahun_filter;
				}else{
					$tahun_filter = $tahun;
				}
				$sql ="
					SELECT 'Manfaat Nilai Tunai' AS judul, A.id, A.iduser, 
					COALESCE(SUM(B.jml_penerima), 0) as jml_penerima_smt1,
					COALESCE(SUM(B.jml_pembayaran), 0) as jml_pembayaran_smt1,
					COALESCE(SUM(C.jml_penerima), 0) as jml_penerima_smt2,
					COALESCE(SUM(C.jml_pembayaran), 0) as jml_pembayaran_smt2,
					COALESCE(ROUND(C.jml_pembayaran - B.jml_pembayaran), 0) as nom_pertumbuhan,
					COALESCE(ROUND(((C.jml_pembayaran - B.jml_pembayaran)/B.jml_pembayaran)*100, 2), 0) as pers_pertumbuhan
					FROM tbl_nilai_tunai_header A
					LEFT JOIN(
						SELECT tbl_nilai_tunai_header_id,jml_penerima, jml_pembayaran, tahun
						FROM tbl_nilai_tunai_detail
						WHERE semester = '1'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					)B ON A.id=B.tbl_nilai_tunai_header_id
					LEFT JOIN(
						SELECT tbl_nilai_tunai_header_id,jml_penerima, jml_pembayaran, tahun
						FROM tbl_nilai_tunai_detail
						WHERE semester = '2'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					)C ON A.id=C.tbl_nilai_tunai_header_id
					WHERE A.iduser = '".$iduser."'
					AND A.tahun = '".$tahun_filter."'
			
				";
				 // echo $sql; exit;
			break;
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

				$tahun_filter = $this->input->post('tahun_awal');
				if ($tahun_filter != "") {
					$tahun_filter = $tahun_filter;
				}else{
					$tahun_filter = $tahun;
				}

				$sql ="
					SELECT A.*,
					COALESCE((C.jml_penerima), 0) as jml_penerima_smt1, 
					COALESCE((C.jml_pembayaran), 0) as jml_pembayaran_smt1, 
					COALESCE((D.jml_penerima), 0) as jml_penerima_smt2, 
					COALESCE((D.jml_pembayaran), 0) as jml_pembayaran_smt2,
					COALESCE(ROUND(D.jml_pembayaran - C.jml_pembayaran), 0) as nom_pertumbuhan,
					COALESCE(ROUND(((D.jml_pembayaran - C.jml_pembayaran)/C.jml_pembayaran)*100, 2), 0) as pers_pertumbuhan
					FROM mst_kelompok_penerima A
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester ='1'
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_kelompok
					) C ON A.id_kelompok=C.id_kelompok
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester ='2'
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
				$tahun_filter = $this->input->post('tahun_awal');
				if ($tahun_filter != "") {
					$tahun_filter = $tahun_filter;
				}else{
					$tahun_filter = $tahun;
				}
				$sql="
					SELECT A.*,
					COALESCE((C.jml_penerima), 0) as jml_penerima_smt1, 
					COALESCE((C.jml_pembayaran), 0) as jml_pembayaran_smt1, 
					COALESCE((D.jml_penerima), 0) as jml_penerima_smt2, 
					COALESCE((D.jml_pembayaran), 0) as jml_pembayaran_smt2,
					COALESCE(ROUND(D.jml_pembayaran - C.jml_pembayaran), 0) as nom_pertumbuhan,
					COALESCE(ROUND(((D.jml_pembayaran - C.jml_pembayaran)/C.jml_pembayaran)*100, 2), 0) as pers_pertumbuhan
					FROM mst_jenis_penerima A
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester ='1'
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_penerima
					) C ON A.id_penerima=C.id_penerima
					LEFT JOIN(
						SELECT semester,id_kelompok, id_penerima,id, tahun,
						COALESCE(SUM(jml_penerima), 0) as jml_penerima, 
						COALESCE(SUM(jml_pembayaran), 0) as jml_pembayaran
						FROM tbl_lkao_pembayaran_pensiun_detail
						WHERE iduser ='".$iduser."'
						AND semester ='2'
						AND sumber_dana ='".$p1."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_penerima
					) D ON A.id_penerima=D.id_penerima
					GROUP BY A.id_penerima
					ORDER BY A.id_penerima
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
			if ($iduser != "") {
				$iduser = $iduser;
				$where .= "
					AND A.iduser =  '".$iduser."'
				";
			}else{
				$iduser = 'TSN002';
				$where .= "
					AND A.iduser =  'TSN002'
				";
			}
			
		}

		if($level == 'TASPEN' || $level == 'ASABRI'){
			$iduser = $this->session->userdata('iduser');
			$where .= "
				AND A.iduser = '".$iduser."'
			";
		}

		switch($type){
			case 'perubahandanabersih_detail':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "tahun = '".$tahun."' ";
				}

				$sql = "
					SELECT
						1 AS id,
						B.id_investasi,
						B.jenis_investasi,
						B.iduser,
						B.group,
						C.id_bulan,
						C.tahun,
						COALESCE (
							SUM(
								CASE
								WHEN B.group = 'HASIL INVESTASI' THEN
									C.mutasi
								ELSE
									C.saldo_akhir
								END
							),
							0
						) AS saldo_akhir
					FROM
						mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN (
						SELECT
							id_investasi,
							saldo_akhir_invest AS saldo_akhir,
							mutasi_invest AS mutasi,
							id_bulan,
							tahun,
							iduser
						FROM
							bln_aset_investasi_header
						WHERE iduser = '".$iduser."'
						AND $beetwen_bln
						AND $beetwen_thn
					) C ON B.id_investasi = C.id_investasi
					WHERE
						B.iduser = '".$iduser."'
						AND A.uraian = '".$p1."'
						AND C.id_bulan IS NOT NULL
					GROUP BY
						C.id_bulan, B.id_investasi
					UNION
					SELECT
						2 AS id,
						B.id_investasi,
						'JUMLAH' AS jenis_investasi,
						B.iduser,
						B.group,
						C.id_bulan,
						C.tahun,
						COALESCE (
							SUM(
								CASE
								WHEN B.group = 'HASIL INVESTASI' THEN
									C.mutasi
								ELSE
									C.saldo_akhir
								END
							),
							0
						) AS saldo_akhir
					FROM
						mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN (
						SELECT
							id_investasi,
							saldo_akhir_invest AS saldo_akhir,
							mutasi_invest AS mutasi,
							id_bulan,
							tahun,
							iduser
						FROM
							bln_aset_investasi_header
						WHERE iduser = '".$iduser."'
						AND $beetwen_bln
						AND $beetwen_thn
					) C ON B.id_investasi = C.id_investasi
					WHERE
						B.iduser = '".$iduser."'
						AND A.uraian = '".$p1."'
						AND C.id_bulan IS NOT NULL
					GROUP BY
						C.id_bulan, C.tahun

					ORDER BY id ASC

				";
			break;
			case 'kas_bank_aruskas':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "B.id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "B.id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "B.tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "B.tahun = '".$tahun."' ";
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.`group`, 
					COALESCE(B.saldo_akhir, 0) as saldo_akhir, COALESCE(B.saldo_awal, 0) as saldo_awal
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."' 
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					)B ON A.id_investasi=B.id_investasi
					$where
					AND A.`group`='BUKAN INVESTASI'
					AND A.jenis_investasi ='Kas & Bank'
				";
				// echo $sql;exit;
			break;
			case 'arus_kas_detail_aktivitas':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "B.id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "B.id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "B.tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "B.tahun = '".$tahun."' ";
				}


				if ($p1 == 'INVESTASI') {
					$tag = 'Arus Kas Bersih Digunakan Untuk Aktivitas Investasi';
				}elseif ($p1 == 'OPERASIONAL') {
					$tag = 'Arus Kas Bersih Diperoleh Untuk Aktivitas Operasional';
				}else {
					$tag = 'Arus Kas Bersih Digunakan Untuk Aktivitas Pendanaan';
				}

				$sql = "
					SELECT
					1 AS id,
					A.id_aruskas, A.jenis_kas,A.arus_kas, A.iduser,
					B.id_bulan, B.tahun,
					COALESCE ((B.saldo_bulan_berjalan), 0) AS saldo_akhir
					FROM
						mst_aruskas A
					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan,id_bulan,iduser, tahun
						FROM bln_arus_kas
					) B ON A.id_aruskas = B.id_aruskas
					WHERE
					B.iduser = '".$iduser."'
					AND A.jenis_kas = '".$p1."'
					AND $beetwen_bln
					AND $beetwen_thn
					AND B.id_bulan IS NOT NULL
					UNION
					SELECT
					2 AS id,
					A.id_aruskas, 'JUMLAH' AS jenis_kas, '$tag' AS arus_kas, A.iduser,
					B.id_bulan, B.tahun,
					COALESCE (SUM(B.saldo_bulan_berjalan), 0) AS saldo_akhir
					FROM
						mst_aruskas A
					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan,id_bulan,iduser, tahun
						FROM bln_arus_kas
					) B ON A.id_aruskas = B.id_aruskas
					WHERE
					B.iduser = '".$iduser."'
					AND A.jenis_kas = '".$p1."'
					AND $beetwen_bln
					AND $beetwen_thn
					AND B.id_bulan IS NOT NULL
					GROUP BY B.id_bulan, B.tahun
					ORDER BY id ASC
				";

				// echo $sql;exit();
			break;

			case 'arus_kas_detail':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "B.id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
					$beetwen_bln2 = "id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "B.id_bulan BETWEEN 1 AND 12 ";
					$beetwen_bln2 = "id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "B.tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
					$beetwen_thn2 = "tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "B.tahun = '".$tahun."' ";
					$beetwen_thn2 = "tahun = '".$tahun."' ";
				}

				$sql = "
					SELECT
					1 AS id,
					A.id_aruskas, A.jenis_kas,A.arus_kas, A.iduser,
					B.id_bulan, B.tahun,
					COALESCE (SUM(B.saldo_bulan_berjalan), 0) AS saldo_akhir
					FROM
						mst_aruskas A
					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan,id_bulan,iduser, tahun
						FROM bln_arus_kas
					) B ON A.id_aruskas = B.id_aruskas
					WHERE
					B.iduser = '".$iduser."'
					AND $beetwen_bln
					AND $beetwen_thn
					AND B.id_bulan IS NOT NULL
					GROUP BY A.jenis_kas, B.id_bulan
					UNION
					SELECT
					2 AS id,
					'00' AS id_aruskas, 'KENAIKAN(PENURUNAN) KAS dan BANK' AS jenis_kas,A.arus_kas, A.iduser,
					B.id_bulan, B.tahun,
					COALESCE (SUM(B.saldo_bulan_berjalan), 0) AS saldo_akhir
					FROM
						mst_aruskas A
					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan,id_bulan,iduser, tahun
						FROM bln_arus_kas
					) B ON A.id_aruskas = B.id_aruskas
					WHERE
					B.iduser = '".$iduser."'
					AND $beetwen_bln
					AND $beetwen_thn
					AND B.id_bulan IS NOT NULL
					GROUP BY B.id_bulan, B.tahun
					UNION
					SELECT 
					3 AS id, '00' as id_aruskas, 'KAS DAN BANK PADA AWAL BULAN' AS jenis_kas,
					A.jenis_investasi AS arus_kas, A.iduser,B.id_bulan, B.tahun, 
					COALESCE(B.saldo_awal, 0) as saldo_akhir
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE 
						iduser = '".$iduser."'
						AND $beetwen_bln2
						AND $beetwen_thn2
						AND id_bulan IS NOT NULL
					)B ON A.id_investasi=B.id_investasi
					WHERE
					A.iduser = '".$iduser."'
					AND A.`group`='BUKAN INVESTASI'
					AND A.jenis_investasi ='Kas & Bank'
					UNION
					SELECT 
					4 AS id, '00' as id_aruskas, 'KAS DAN BANK PADA AKHIR BULAN' AS jenis_kas,
					A.jenis_investasi AS arus_kas, A.iduser,B.id_bulan, B.tahun, 
					COALESCE(B.saldo_akhir, 0) as saldo_akhir
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE 
						iduser = '".$iduser."'
						AND $beetwen_bln2
						AND $beetwen_thn2
						AND id_bulan IS NOT NULL
					)B ON A.id_investasi=B.id_investasi
					WHERE
					A.iduser = '".$iduser."'
					AND A.`group`='BUKAN INVESTASI'
					AND A.jenis_investasi ='Kas & Bank'

					ORDER BY id ASC
				";
				// echo $sql;exit();
			break;
			case 'dana_bersih_invest_pihak_detail':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "C.id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "C.id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "C.tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "C.tahun = '".$tahun."' ";
				}

				$sql = "
					SELECT
						1 AS id,
						A.kode_pihak AS kode_pihak,
						A.nama_pihak AS nama_pihak,
						A.iduser AS iduser,
						C.id_bulan AS id_bulan,
						C.tahun AS tahun,
						C.id_investasi AS id_investasi,
						SUM(IF ((C.id_investasi = '".$p1."'),B.saldo_akhir,0)) AS saldo_akhir
					FROM
						mst_pihak A
						LEFT JOIN bln_aset_investasi_detail B ON B.kode_pihak = A.kode_pihak
						LEFT JOIN bln_aset_investasi_header C ON B.bln_aset_investasi_header_id = C.id
						LEFT JOIN mst_investasi D ON D.id_investasi = C.id_investasi

					WHERE D.group = 'INVESTASI'
						AND C.iduser  = '".$iduser."'
						AND $beetwen_bln
						AND $beetwen_thn
						AND C.id_bulan IS NOT NULL
						AND C.id_investasi  = '".$p1."'
					GROUP BY B.kode_pihak, C.id_bulan, C.tahun
					UNION
					SELECT
						2 AS id,
						A.kode_pihak AS kode_pihak,
						'JUMLAH' AS nama_pihak,
						A.iduser AS iduser,
						C.id_bulan AS id_bulan,
						C.tahun AS tahun,
						C.id_investasi AS id_investasi,
						SUM(IF ((C.id_investasi = '".$p1."'),B.saldo_akhir,0)) AS saldo_akhir
					FROM
						mst_pihak A
						LEFT JOIN bln_aset_investasi_detail B ON B.kode_pihak = A.kode_pihak
						LEFT JOIN bln_aset_investasi_header C ON B.bln_aset_investasi_header_id = C.id
						LEFT JOIN mst_investasi D ON D.id_investasi = C.id_investasi

					WHERE D.group = 'INVESTASI'
						AND C.iduser  = '".$iduser."'
						AND $beetwen_bln
						AND $beetwen_thn
						AND C.id_bulan IS NOT NULL
						AND C.id_investasi  = '".$p1."'
					GROUP BY C.id_bulan, C.tahun
					ORDER BY id ASC

				";
				// echo $sql;exit();
			break;

			case 'dana_bersih_invest_pihak':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "A.id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "A.id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "A.tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "A.tahun = '".$tahun."' ";
				}

				if($iduser == 'TSN002'){
					$sql="
						SELECT A.iduser, A.id_bulan, A.tahun, A.nama_pihak,
						COALESCE((A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_taspen A
						$where
						AND $beetwen_bln
						AND $beetwen_thn
						UNION
						SELECT A.iduser, A.id_bulan, A.tahun, 'JUMLAH' AS nama_pihak,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_taspen A
						$where
						AND $beetwen_bln
						AND $beetwen_thn
						GROUP BY A.id_bulan, A.tahun
					";

					// echo $sql;exit();
				}elseif ($iduser == 'ASB003') {
					$sql="
						SELECT A.iduser, A.id_bulan, A.tahun, A.nama_pihak,
						COALESCE((A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_asabri A
						$where
						AND $beetwen_bln
						AND $beetwen_thn
						UNION
						SELECT A.iduser, A.id_bulan, A.tahun, 'JUMLAH' AS nama_pihak,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_asabri A
						$where
						AND $beetwen_bln
						AND $beetwen_thn
						GROUP BY A.id_bulan, A.tahun
					";
				}else{
					$sql="
						SELECT A.iduser, A.id_bulan, A.tahun, A.nama_pihak,
						COALESCE((A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_taspen A
						$where
						AND $beetwen_bln
						AND $beetwen_thn
						UNION
						SELECT A.iduser, A.id_bulan, A.tahun, 'JUMLAH' AS nama_pihak,
						COALESCE(SUM(A.total_perpihak), 0) as total_perpihak
						FROM vw_investasi_perpihak_taspen A
						$where
						AND $beetwen_bln
						AND $beetwen_thn
						GROUP BY A.id_bulan, A.tahun
					";
				}
			break;
			case 'dana_bersih_invest':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "tahun = '".$tahun."' ";
				}


				$sql = "
					SELECT 
					1 AS id,
					A.id_investasi, A.jenis_investasi, A.iduser, B.id_bulan, B.tahun, 
					A.type_sub_jenis_investasi as type, COALESCE ((B.saldo_akhir), 0) AS saldo_akhir
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, target_yoi
						FROM bln_aset_investasi_header
						WHERE $beetwen_bln
						AND iduser = '".$iduser."'
						AND $beetwen_thn
					) B ON A.id_investasi = B.id_investasi
					WHERE `group` = '".$p1."'
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'P' OR A.type_sub_jenis_investasi = 'C')
					AND B.id_bulan IS NOT NULL
					UNION
					SELECT 
					2 AS id,
					A.id_investasi, 'JUMLAH' AS jenis_investasi,A.iduser, B.id_bulan, B.tahun, 
					A.type_sub_jenis_investasi as type, COALESCE (SUM(B.saldo_akhir), 0) AS saldo_akhir
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, target_yoi
						FROM bln_aset_investasi_header
						WHERE $beetwen_bln
						AND iduser = '".$iduser."'
						AND $beetwen_thn
					) B ON A.id_investasi = B.id_investasi
					WHERE `group` = '".$p1."'
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'P' OR A.type_sub_jenis_investasi = 'C')
					AND B.id_bulan IS NOT NULL
					GROUP BY B.id_bulan, B.tahun

					ORDER BY id ASC
				";

				// echo $sql;exit;
			break;
			case 'dana_bersih':
				$bln_awal = $this->input->post('bln_awal');
				$bln_akhir = $this->input->post('bln_akhir');
				$tahun_awal = $this->input->post('tahun_awal');
				$tahun_akhir = $this->input->post('tahun_akhir');

				if ($bln_awal != "" && $bln_akhir != "") {
					$beetwen_bln = "id_bulan BETWEEN ".$bln_awal." AND ".$bln_akhir." ";
				}else{
					$beetwen_bln = "id_bulan BETWEEN 1 AND 12 ";
				}	

				if ($tahun_awal != "" && $tahun_akhir != "") {
					$beetwen_thn = "tahun BETWEEN ".$tahun_awal." AND ".$tahun_akhir." ";
				}else{
					$beetwen_thn = "tahun = '".$tahun."' ";
				}

				
				$sql="
				SELECT
					1 AS id,
					A.id_dana_bersih as kode, A.uraian,B.id_investasi,
					B.iduser,
					C.id_bulan,
					COALESCE (SUM(C.saldo_akhir), 0) AS saldo_akhir,
					C.tahun
				FROM
					mst_dana_bersih A
				LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
				LEFT JOIN (
					SELECT
						id_investasi,
						saldo_akhir_invest AS saldo_akhir,
						id_bulan,
						tahun,
						iduser
					FROM
						bln_aset_investasi_header
					WHERE
						$beetwen_bln
					AND iduser = '".$iduser."'
					AND $beetwen_thn
				) C ON B.id_investasi = C.id_investasi

				WHERE B.iduser = '".$iduser."' 
				AND C.id_bulan IS NOT NULL
				GROUP BY A.uraian, C.id_bulan, C.tahun
				UNION
				SELECT
					2 AS id,
					A.id_dana_bersih as kode, 'DANA BERSIH' as uraian, B.id_investasi,
					B.iduser,
					C.id_bulan,
					COALESCE (SUM(C.saldo_akhir), 0) AS saldo_akhir,
					C.tahun
				FROM
					mst_dana_bersih A
				LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
				LEFT JOIN (
					SELECT
						id_investasi,
						saldo_akhir_invest AS saldo_akhir,
						id_bulan,
						tahun,
						iduser
					FROM
						bln_aset_investasi_header
					WHERE
						$beetwen_bln
					AND iduser = '".$iduser."'
					AND $beetwen_thn
				) C ON B.id_investasi = C.id_investasi

				WHERE B.iduser = '".$iduser."' 
				AND C.id_bulan IS NOT NULL
				GROUP BY C.id_bulan, C.tahun

				ORDER BY CAST(id_bulan as unsigned),id,tahun ASC
				";

				// echo $sql;exit;
			break;
			case 'summary_periodik':
				// if ($p1 != "") {
				// 	$where .= "
				// 	AND B.id_bulan =  '".$p1."'
				// 	";
				// }

				$sql = "
					SELECT  A.id_investasi, A.jenis_investasi, A.iduser,
					A.type_sub_jenis_investasi as type, A.kelompok_investasi, B.id_bulan, B.tahun, 
					sum(B.saldo_awal_invest) AS saldo_awal_invest, 
					sum(B.rka_invest) AS rka_invest, 
					sum(B.saldo_akhir_invest) AS saldo_akhir_invest,
					sum(C.saldo_awal_hasil) AS saldo_awal_hasil, 
					sum(C.rka_hasil) AS rka_hasil, 
					sum(C.saldo_akhir_hasil) AS saldo_akhir_hasil
					FROM mst_investasi A
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_invest,
							x.rka AS rka_invest,
							x.saldo_akhir_invest AS saldo_akhir_invest
						FROM
							bln_aset_investasi_header x
						INNER JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND x.tahun = '".$tahun."'
						AND y.`group` = 'INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)B ON A.kelompok_investasi = B.kelompok_investasi
					LEFT JOIN(	
						SELECT
							i.id_investasi, j.jenis_investasi,
							i.iduser, i.id_bulan, i.tahun,
							j.`group`, j.kelompok_investasi,
							i.saldo_awal_invest AS saldo_awal_hasil,
							i.rka AS rka_hasil,
							i.saldo_akhir_invest AS saldo_akhir_hasil
						FROM
							bln_aset_investasi_header i
						LEFT JOIN mst_investasi j ON i.id_investasi=j.id_investasi
						WHERE
							1=1
						AND i.iduser = '".$iduser."'
						AND i.tahun = '".$tahun."'
						AND j.`group` = 'HASIL INVESTASI'
						ORDER BY i.id_bulan, i.id_investasi ASC
					)C ON A.kelompok_investasi = C.kelompok_investasi AND B.id_bulan=C.id_bulan
					$where
					AND A.`group` = 'INVESTASI'
					AND B.id_bulan IS NOT NULL
					GROUP BY A.kelompok_investasi, B.id_bulan, C.id_bulan
					ORDER BY A.id_investasi , B.id_bulan ASC
				";

				// echo $sql;exit();
			break;

			case 'summary_periodik_semester':
				if ($p1 != "") {
					$group = "
						GROUP BY A.kelompok_investasi
					";
				}else{
					$group = "";
				}
				$sql = "
					SELECT  A.id_investasi, A.jenis_investasi, A.iduser,
					A.kelompok_investasi,
					B.id_bulan, B.tahun, 
					SUM(IF(B.id_bulan BETWEEN 1 AND 6, B.saldo_awal_invest,0)) as saldo_awal_invest_smt1,
					SUM(IF(B.id_bulan BETWEEN 1 AND 6, B.rka_invest,0)) as rka_invest_smt1,
					SUM(IF(B.id_bulan BETWEEN 1 AND 6, B.saldo_akhir_invest,0)) as saldo_akhir_invest_smt1,
					SUM(IF(B.id_bulan BETWEEN 1 AND 6, C.saldo_awal_hasil,0)) as saldo_awal_hasil_smt1,
					SUM(IF(B.id_bulan BETWEEN 1 AND 6, C.rka_hasil,0)) as rka_hasil_smt1,
					SUM(IF(B.id_bulan BETWEEN 1 AND 6, C.saldo_akhir_hasil,0)) as saldo_akhir_hasil_smt1,
					SUM(IF(B.id_bulan = 1 OR B.id_bulan = 6, B.saldo_akhir_invest,0)) as nil_hasil_smt1,

					SUM(IF(B.id_bulan BETWEEN 7 AND 12, B.saldo_awal_invest,0)) as saldo_awal_invest_smt2,
					SUM(IF(B.id_bulan BETWEEN 7 AND 12, B.rka_invest,0)) as rka_invest_smt2,
					SUM(IF(B.id_bulan BETWEEN 7 AND 12, B.saldo_akhir_invest,0)) as saldo_akhir_invest_smt2,
					SUM(IF(B.id_bulan BETWEEN 7 AND 12, C.saldo_awal_hasil,0)) as saldo_awal_hasil_smt2,
					SUM(IF(B.id_bulan BETWEEN 7 AND 12, C.rka_hasil,0)) as rka_hasil_smt2,
					SUM(IF(B.id_bulan BETWEEN 7 AND 12, C.saldo_akhir_hasil,0)) as saldo_akhir_hasil_smt2,
					SUM(IF(B.id_bulan = 1 OR B.id_bulan = 6, B.saldo_akhir_invest,0)) as nil_hasil_smt2

					FROM mst_investasi A
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_invest,
							x.rka AS rka_invest,
							x.saldo_akhir_invest AS saldo_akhir_invest
						FROM
							bln_aset_investasi_header x
						INNER JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND x.tahun = '".$tahun."'
						AND y.`group` = 'INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)B ON A.kelompok_investasi = B.kelompok_investasi
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_hasil,
							x.rka AS rka_hasil,
							x.saldo_akhir_invest AS saldo_akhir_hasil
						FROM
							bln_aset_investasi_header x
						LEFT JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND x.tahun = '".$tahun."'
						AND y.`group` = 'HASIL INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)C ON A.kelompok_investasi = C.kelompok_investasi AND B.id_bulan=C.id_bulan
					$where
					AND A.`group` = 'INVESTASI'
					AND B.id_bulan IS NOT NULL
					$group
					ORDER BY A.id_investasi ASC
				";
			break;

			case 'summary_periodik_tahunan':
				$tahun_lalu = $tahun - 1;
				if ($p1 != "") {
					$group = "
						GROUP BY A.kelompok_investasi
					";
				}else{
					$group = "";
				}
				
				$sql = "
					SELECT  A.id_investasi, A.jenis_investasi, A.iduser,
					A.kelompok_investasi,
					B.id_bulan, B.tahun, 
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun."', B.saldo_awal_invest,0)) as saldo_awal_invest_thn,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun."', B.rka_invest,0)) as rka_invest_thn,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun."', B.saldo_akhir_invest,0)) as saldo_akhir_invest_thn,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun."', C.saldo_awal_hasil,0)) as saldo_awal_hasil_thn,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun."', C.rka_hasil,0)) as rka_hasil_thn,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun."', C.saldo_akhir_hasil,0)) as saldo_akhir_hasil_thn,
					SUM(IF(B.id_bulan = 1 OR B.id_bulan = 12 AND B.tahun = '".$tahun."', C.saldo_akhir_hasil,0)) as nil_hasil_thn,

					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun_lalu."', B.saldo_awal_invest,0)) as saldo_awal_invest_thn_lalu,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun_lalu."', B.rka_invest,0)) as rka_invest_thn_lalu,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun_lalu."', B.saldo_akhir_invest,0)) as saldo_akhir_invest_thn_lalu,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun_lalu."', C.saldo_awal_hasil,0)) as saldo_awal_hasil_thn_lalu,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun_lalu."', C.rka_hasil,0)) as rka_hasil_thn_lalu,
					SUM(IF(B.id_bulan BETWEEN 1 AND 12 AND B.tahun = '".$tahun_lalu."', C.saldo_akhir_hasil,0)) as saldo_akhir_hasil_thn_lalu,
					SUM(IF(B.id_bulan = 1 OR B.id_bulan = 12 AND B.tahun = '".$tahun_lalu."', C.saldo_akhir_hasil,0)) as nil_hasil_thn_lalu

					FROM mst_investasi A
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_invest,
							x.rka AS rka_invest,
							x.saldo_akhir_invest AS saldo_akhir_invest
						FROM
							bln_aset_investasi_header x
						INNER JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND y.`group` = 'INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)B ON A.kelompok_investasi = B.kelompok_investasi
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_hasil,
							x.rka AS rka_hasil,
							x.saldo_akhir_invest AS saldo_akhir_hasil
						FROM
							bln_aset_investasi_header x
						LEFT JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND y.`group` = 'HASIL INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)C ON A.kelompok_investasi = C.kelompok_investasi AND B.id_bulan=C.id_bulan
					$where
					AND A.`group` = 'INVESTASI'
					AND B.id_bulan IS NOT NULL
					$group
					ORDER BY A.id_investasi ASC
				";

				// echo $sql;exit();
			break;

			case 'summary_periodik_chart':
				if ($p1 != "") {
					$where .= "
					AND B.id_bulan BETWEEN 1 AND '".$p1."'
					";
				}else{
					$where .= "
					AND B.id_bulan BETWEEN 1 AND '".date('m')."'
					";
				}

				$sql = "
				SELECT yy.nama_bulan, xx.*
				FROM t_bulan yy
				LEFT JOIN(
					SELECT  A.iduser,
					B.id_bulan, B.tahun, 
					sum(B.saldo_awal_invest) AS saldo_awal_invest, 
					sum(B.rka_invest) AS rka_invest, 
					sum(B.saldo_akhir_invest) AS saldo_akhir_invest,
					sum(C.saldo_awal_hasil) AS saldo_awal_hasil, 
					sum(C.rka_hasil) AS rka_hasil, 
					sum(C.saldo_akhir_hasil) AS saldo_akhir_hasil
					FROM mst_investasi A
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_invest,
							x.rka AS rka_invest,
							x.saldo_akhir_invest AS saldo_akhir_invest
						FROM
							bln_aset_investasi_header x
						INNER JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND x.tahun = '".$tahun."'
						AND y.`group` = 'INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)B ON A.kelompok_investasi = B.kelompok_investasi
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_hasil,
							x.rka AS rka_hasil,
							x.saldo_akhir_invest AS saldo_akhir_hasil
						FROM
							bln_aset_investasi_header x
						LEFT JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND x.tahun = '".$tahun."'
						AND y.`group` = 'HASIL INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)C ON A.kelompok_investasi = C.kelompok_investasi AND B.id_bulan=C.id_bulan
					$where
					AND A.`group` = 'INVESTASI'
					GROUP BY B.id_bulan
					ORDER BY CAST(B.id_bulan as unsigned) ASC
					) xx ON yy.id_bulan=xx.id_bulan
				";

				// echo $sql;exit();
			break;

			case 'summary_yoi_periodik':
				if ($p1 != "") {
					$where .= "
					AND B.id_bulan BETWEEN 1 AND '".$p1."'
					";
				}else{
					$where .= "
					AND B.id_bulan BETWEEN 1 AND '".date('m')."'
					";
				}

				$sql = "
					SELECT  A.id_investasi, A.jenis_investasi, A.iduser,
					A.type_sub_jenis_investasi as type, A.kelompok_investasi, B.id_bulan, B.tahun, 
					sum(B.saldo_awal_invest) AS saldo_awal_invest, 
					sum(B.rka_invest) AS rka_invest, 
					sum(B.saldo_akhir_invest) AS saldo_akhir_invest,
					sum(C.saldo_awal_hasil) AS saldo_awal_hasil, 
					sum(C.rka_hasil) AS rka_hasil, 
					sum(C.saldo_akhir_hasil) AS saldo_akhir_hasil
					FROM mst_investasi A
					LEFT JOIN(	
						SELECT
							x.id_investasi, y.jenis_investasi,
							x.iduser, x.id_bulan, x.tahun,
							y.`group`, y.kelompok_investasi,
							x.saldo_awal_invest AS saldo_awal_invest,
							x.rka AS rka_invest,
							x.saldo_akhir_invest AS saldo_akhir_invest
						FROM
							bln_aset_investasi_header x
						INNER JOIN mst_investasi y ON x.id_investasi=y.id_investasi
						WHERE
							1=1
						AND x.iduser = '".$iduser."'
						AND x.tahun = '".$tahun."'
						AND y.`group` = 'INVESTASI'
						ORDER BY x.id_bulan, x.id_investasi ASC
					)B ON A.kelompok_investasi = B.kelompok_investasi
					LEFT JOIN(	
						SELECT
							i.id_investasi, j.jenis_investasi,
							i.iduser, i.id_bulan, i.tahun,
							j.`group`, j.kelompok_investasi,
							i.saldo_awal_invest AS saldo_awal_hasil,
							i.rka AS rka_hasil,
							i.saldo_akhir_invest AS saldo_akhir_hasil
						FROM
							bln_aset_investasi_header i
						LEFT JOIN mst_investasi j ON i.id_investasi=j.id_investasi
						WHERE
							1=1
						AND i.iduser = '".$iduser."'
						AND i.tahun = '".$tahun."'
						AND j.`group` = 'HASIL INVESTASI'
						ORDER BY i.id_bulan, i.id_investasi ASC
					)C ON B.id_bulan=C.id_bulan
					$where
					AND A.`group` = 'INVESTASI'
					AND B.id_bulan IS NOT NULL
					GROUP BY B.id_bulan, C.id_bulan
					ORDER BY CAST(B.id_bulan as unsigned) ASC
				";

				// echo $sql;exit();
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