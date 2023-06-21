<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operasional_belanja_model extends CI_Model {
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
		$query = $this->db->get_where('ket_lap_semesteran',array('id' => $id,'iduser' => $this->iduser,'tahun' => $this->tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function get_by_id_klaim($id){
		$response = false;
		$query = $this->db->get_where('tbl_lkob_klaim_header',array('id' => $id,'iduser' => $this->iduser,'tahun' => $this->tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1,$p2){
		$this->db->delete('ket_lap_semesteran', array('jenis_lap' => $p1, 'semester' => $p2, 'iduser' => $this->iduser,'tahun' => $this->tahun));
	}

	public function insert_ket($data){
		$this->db->insert('ket_lap_semesteran', $data);
	}


	function get_ket($p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		$tahun = $this->session->userdata('tahun');

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
			FROM ket_lap_semesteran A
			$where
			AND A.jenis_lap = '".$p1."'
			AND A.semester = '".$p2."'
		";

		return $this->db->query($sql)->result();
	}
	
	


	function simpandata($table,$data,$sts_crud){ //$sts_crud --> STATUS INSERT, UPDATE, DELETE
		$this->db->trans_begin();

		if(isset($data['id'])){
			$id = $data['id'];
			unset($data['id']);
		}
		
		if($sts_crud == "add"){
			unset($data['id']);
		}

		switch($table){
			case 'lkob_klaim':
				$table_data = "tbl_lkob_klaim_header";
				if($sts_crud == "add" || $sts_crud == "edit"){
					// print_r($data);exit();
					$data['rka_jml_klaim'] = str_replace('.', '', $data['rka_jml_klaim']);
					$data['rka_jml_pembayaran'] = str_replace('.', '', $data['rka_jml_pembayaran']);
					$cabang = ( isset( $data['cabang']) ?  $data['cabang'] : array() ); 
					$jml_klaim = ( isset( $data['jml_klaim']) ?  $data['jml_klaim'] : array() ); 
					$jml_pembayaran = ( isset( $data['jml_pembayaran']) ?  $data['jml_pembayaran'] : array() ); 
					$no_urut = ( isset( $data['no_urut']) ?  $data['no_urut'] : array() ); 

					if(isset($data['cabang'])){
						unset($data['cabang']);
					}
					if(isset($data['jml_klaim'])){
						unset($data['jml_klaim']);
					}
					if(isset($data['jml_pembayaran'])){
						unset($data['jml_pembayaran']);
					}
					if(isset($data['no_urut'])){
						unset($data['no_urut']);
					}


					$tahun = $this->session->userdata('tahun');
					$level = $this->session->userdata('level');

						$upload_path   = './files/file_semesteran/operasional_belanja/'; //path folder
						$data['filedata_lama'] = escape($data['filedata_lama']);

						if(!empty($_FILES['filedata']['name'])){                  
							if(isset($data["filedata_lama"])){
								if($data["filedata_lama"] != ""){
									unlink($upload_path.$data["filedata_lama"]);
								}
							}

							$file_data = 'File_Klaim_'.$data['jenis_klaim'].'_Semester_'.$data['semester'].'_'.$tahun.'_'.$level;
							$filename_data =  $this->lib->uploadnong($upload_path, 'filedata', $file_data);
						}else{
							$filename_data = (isset($data["filedata_lama"]) ? $data["filedata_lama"] : null );
						}

						$data["filedata"] = $filename_data;
						unset($data["filedata_lama"]);
				
				}
				
				if($sts_crud == "edit" || $sts_crud == "delete"){
					$this->db->delete('tbl_lkob_klaim_detail', array('tbl_lkob_klaim_header_id'=>$id,'semester'=>$data['semester'],'tahun' => $this->tahun) );
				}
			break;
		}
		
		switch ($sts_crud){
			case "add":
				$data['insert_at'] = date('Y-m-d H:i:s');
				$data['iduser'] = $this->iduser;
				$data['tahun'] = $this->tahun;

				$insert = $this->db->insert($table_data,$data);
				$id = $this->db->insert_id();

				// Nilai Tunai
				if($table == 'lkob_klaim'){
					if($insert){
						if($table_data == "tbl_lkob_klaim_header"){
							if(isset($cabang)){
								foreach($cabang as $k => $v){
									$jml_pembayaran[$k] = str_replace('.', '', $jml_pembayaran[$k]);
									$jml_klaim[$k] = str_replace('.', '', $jml_klaim[$k]);
									$arr_detail = array(
										'tbl_lkob_klaim_header_id' => $id,
										'iduser' => $this->iduser,
										'tahun' => $this->tahun,
										'semester' => $data['semester'],
										'jenis_klaim' => $data['jenis_klaim'],
										'id_cabang' => $cabang[$k],
										'jml_klaim' => $jml_klaim[$k],
										'jml_pembayaran' => $jml_pembayaran[$k],
										'no_urut' => escape($no_urut[$k]),
										'insert_at' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('tbl_lkob_klaim_detail', $arr_detail);
								}
							}

						}
					}
				}
			break;
			case "edit":
				$data['update_at'] = date('Y-m-d H:i:s');
				$data['iduser'] = $this->iduser;
				$data['tahun'] = $this->tahun;
				$update = $this->db->update($table_data, $data, array('id' => $id) );

				// LKOB KLAIM
				if($table == 'lkob_klaim'){
					if($update){
						if($table_data == "tbl_lkob_klaim_header"){
							if(isset($cabang)){
								foreach($cabang as $k => $v){
									$jml_pembayaran[$k] = str_replace('.', '', $jml_pembayaran[$k]);
									$jml_klaim[$k] = str_replace('.', '', $jml_klaim[$k]);
									$arr_detail = array(
										'tbl_lkob_klaim_header_id' => $id,
										'iduser' => $this->iduser,
										'tahun' => $this->tahun,
										'semester' => $data['semester'],
										'jenis_klaim' => $data['jenis_klaim'],
										'id_cabang' => $cabang[$k],
										'jml_klaim' => $jml_klaim[$k],
										'jml_pembayaran' => $jml_pembayaran[$k],
										'no_urut' => escape($no_urut[$k]),
										'insert_at' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('tbl_lkob_klaim_detail', $arr_detail);
								}
							}

						}
					}
				}
			break;
			case "delete":
				$this->db->delete($table_data, array('id' => $id));	
			break;
		}
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return 'gagal';
		}else{
			 return $this->db->trans_commit();
		}
	}


	function get_combo($type="", $p1="", $p2=""){
		$array = array();
		$where  = " WHERE 1=1 ";

		$level = $this->session->userdata('level');
		
		$tahun = $this->session->userdata('tahun');

		if($level == 'TASPEN' || $level == 'ASABRI'){ 
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
			case "sub_reksadana":
				$sql = "
					SELECT A.id_investasi as id, A.jenis_investasi as txt
					FROM mst_investasi A
					$where
					AND A.parent_id = '".$p1."'
				";
				// echo $sql;exit;
			break;
			case "mst_cabang":
			case "mst_cabang_ob":
				$sql = "
					SELECT A.id_cabang AS id, A.nama_cabang AS txt
					FROM mst_cabang A
					$where
				";
				 // echo $sql;exit;
			break;
			case "jenis_klaim":
				$sql = "
					SELECT A.kode_klaim AS id, A.jenis_klaim AS txt
					FROM mst_jenis_klaim A
					$where
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
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.saldo_awal, B.mutasi, B.rka, B.realisasi_rka, B.saldo_akhir,B.id
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND tahun = '".$tahun."'
					AND iduser = '".$iduser."'
					) B ON A.id_investasi = B.id_investasi
					WHERE `group` ='".$p1."'
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'P' OR A.type_sub_jenis_investasi = 'PC')
					ORDER BY A.no_urut ASC

				";
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
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.saldo_awal, B.mutasi, B.rka, B.realisasi_rka, B.saldo_akhir, B.id
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan ='".$id_bulan."'
						AND iduser ='".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					WHERE A.`group` ='".$p2."'
					AND A.iduser = '".$iduser."'
					AND A.parent_id ='".$p1."'
					ORDER BY A.no_urut ASC

				";
				// echo $sql;exit;
			break;

			case 'aset_investasi_front_sum':
				$sql="
				SELECT A.iduser, B.id_bulan,
				sum(B.saldo_awal) as saldo_awal, sum(B.mutasi) as mutasi, sum(B.rka) as rka, sum(B.realisasi_rka) as realisasi_rka, 
				sum(B.saldo_akhir) as saldo_akhir
				FROM mst_investasi A
				LEFT JOIN(
					SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
					saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
					FROM bln_aset_investasi_header
					WHERE id_bulan = '".$id_bulan."'
					AND iduser = '".$iduser."'
					AND tahun = '".$tahun."'
				) B ON A.id_investasi = B.id_investasi
				WHERE A.`group` ='".$p1."'
				AND A.iduser = '".$iduser."'
				AND B.id_bulan = '".$id_bulan."'
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
			
			case 'form_invest':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND A.id_investasi = '".$p1."'
				";
				// echo $sql;exit;
			break;
			case 'mst_jenis_investasi':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND a.group ='INVESTASI'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_bkn_investasi':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND a.group ='BUKAN INVESTASI'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_hasil_investasi':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND a.group ='HASIL INVESTASI'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_jenis_investasi_kewajiban':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND a.group ='KEWAJIBAN'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_jenis_investasi_iuran':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND a.group ='IURAN'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_jenis_investasi_beban':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND a.group ='BEBAN'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			
			// QUERY UNTUK MENU LAMPIRAN 

			case 'dana_bersih_lv1':
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

				$sql="
					SELECT A.*, B.id_investasi,B.iduser, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '6'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					) D ON B.id_investasi = D.id_investasi


					WHERE B.iduser = '".$iduser."'
					GROUP BY A.jenis_laporan
				";

				// echo $sql;exit;
			break;

			case 'dana_bersih_lv2':
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

				$sql="
					SELECT A.*, B.id_investasi,B.iduser, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND A. jenis_laporan = '".$p1."'
					GROUP BY A.uraian
					ORDER BY A.id_dana_bersih ASC
				";

				// echo $sql;exit;
			break;

			case 'dana_bersih_lv3':
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

				$sql="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.type_sub_jenis_investasi, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir,
					COALESCE(SUM(D.saldo_akhir_bln_lalu), 0) as saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_bln_lalu, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser ='".$iduser."'
					AND A.id_dana_bersih ='".$p1."'
					AND (B.type_sub_jenis_investasi ='P' OR B.type_sub_jenis_investasi ='PC')
					GROUP BY B.id_investasi
					ORDER BY B.no_urut, A.id_dana_bersih ASC
				";


				// echo $sql;exit;
			break;
			case 'dana_bersih_lv4':
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

				$sql="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.type_sub_jenis_investasi, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir,
					COALESCE(SUM(D.saldo_akhir_bln_lalu), 0) as saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_bln_lalu, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND B.parent_id ='".$p1."'
					AND B.type_sub_jenis_investasi ='".$p2."'
					GROUP BY B.id_investasi
					ORDER BY B.no_urut, A.id_dana_bersih ASC
				";

				// echo $sql;exit;
			break;
	

			case 'perubahan_danabersih_lv1':
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

				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_smt1,
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir end), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					GROUP BY A.uraian
				";
			break;

			case 'perubahan_danabersih_lv2':
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

				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_smt1,
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir end), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan  BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan  BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND A.uraian ='".$p1."'
					GROUP BY B.group
					ORDER BY B.no_urut_group ASC
				";
				 // echo $sql;exit;
			break;

			case 'perubahan_danabersih_lv3':
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

				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end, 0) as saldo_akhir_smt1,
					COALESCE(CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir end, 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND (B.type_sub_jenis_investasi ='P' OR B.type_sub_jenis_investasi ='PC')
					AND B.group = '".$p1."'
					ORDER BY B.no_urut ASC
				";
			break;

			case 'perubahan_danabersih_lv4':
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

				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.`group`, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end, 0) as saldo_akhir_smt1,
					COALESCE(CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir end, 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND B.parent_id ='".$p1."'
					AND B.type_sub_jenis_investasi ='".$p2."'
					ORDER BY B.no_urut ASC
				";
				// echo $sql;exit;
			break;

			
			// untuk form iuran dan beban
			case 'mst_perubahan_danabersih':
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					WHERE B.iduser = '".$iduser."'
					AND NOT B.`group` ='HASIL INVESTASI'
					GROUP BY B.group
				";
			break;

			case 'data_perubahan_danabersih_iuran_header':
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.group,
					B.id_bulan, B.saldo_akhir
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id_investasi,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser =  '".$iduser."'
						AND tahun =  '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					WHERE 1=1
					AND NOT A.type_sub_jenis_investasi ='PC'
					AND A.`group`='IURAN'
					AND A.iduser = '".$iduser."'
					ORDER BY A.no_urut ASC
				";
			break;

			case 'data_perubahan_danabersih_beban_header':
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.group,
					B.id_bulan, B.saldo_akhir
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id_investasi,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser =  '".$iduser."'
						AND tahun =  '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					WHERE 1=1
					AND NOT A.type_sub_jenis_investasi ='PC'
					AND A.`group`='BEBAN'
					AND A.iduser = '".$iduser."'
					ORDER BY A.no_urut ASC
				";
			break;


			// arus kas
			case 'jenis_aktivitas':
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

				$sql = "
					SELECT
					A.jenis_kas,A.arus_kas, 
					SUM(B.saldo_bulan_berjalan) as saldo_smt1,
					SUM(C.saldo_bulan_berjalan) as saldo_smt2
					FROM mst_aruskas A
					LEFT JOIN (
						SELECT
						id_aruskas,id_bulan,iduser,saldo_bulan_berjalan, tahun
						FROM
						bln_arus_kas
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_aruskas = B.id_aruskas

					LEFT JOIN (
						SELECT
						id_aruskas,id_bulan,iduser,saldo_bulan_berjalan, tahun 
						FROM
						bln_arus_kas
						WHERE id_bulan  BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					) C ON A.id_aruskas = C.id_aruskas

					WHERE A.iduser = '".$iduser."'
					GROUP BY A.jenis_kas

				";
				// echo $sql;exit;

			break;

			case 'jenis_aktivitas_by':
				$sql = "
					SELECT A.* 
					FROM mst_aruskas A  
					$where2
					AND A.jenis_kas ='".$p1."'
				";
			break;

			case 'nilai_arus_kas':
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

				$sql = "
					SELECT
					A.id_aruskas, A.jenis_kas,A.arus_kas,
					B.saldo_bulan_berjalan, C.saldo_bulan_lalu, 
					COALESCE(SUM(B.saldo_bulan_berjalan), 0) as saldo_smt1,
					COALESCE(SUM(C.saldo_bulan_lalu), 0) as saldo_smt2
					FROM mst_aruskas A
					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan,id_bulan,iduser, tahun
						FROM bln_arus_kas
						WHERE  id_bulan  BETWEEN 1 AND 6
							AND id_aruskas ='".$p1."'	
							AND iduser = '".$iduser."'
							AND tahun = '".$tahun."'
					) B ON A.id_aruskas = B.id_aruskas

					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan as saldo_bulan_lalu,id_bulan,iduser, tahun
						FROM bln_arus_kas
						WHERE  id_bulan  BETWEEN 7 AND 12
							AND iduser = '".$iduser."'
							AND tahun = '".$tahun_filter."'
					) C ON A.id_aruskas = C.id_aruskas

					WHERE A.id_aruskas ='".$p1."'	
					AND A.iduser = '".$iduser."'
					GROUP BY A.id_aruskas
			
				";
				// echo $sql;exit;
			break;

			case 'kas_bank':
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

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.`group`, 
					COALESCE(SUM(B.saldo_akhir), 0) as saldo_akhir_smt1, COALESCE(SUM(B.saldo_awal), 0) as saldo_awal_smt1,
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir_smt2, COALESCE(SUM(C.saldo_awal), 0) as saldo_awal_smt2,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_smt2_lalu, COALESCE(SUM(D.saldo_awal), 0) as saldo_awal_smt2_lalu
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '6'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					)B ON A.id_investasi=B.id_investasi
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					)C ON A.id_investasi=C.id_investasi
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					)D ON A.id_investasi=D.id_investasi
					$where2
					AND A.`group`='BUKAN INVESTASI'
					AND A.jenis_investasi ='Kas & Bank'
				";

				// echo $sql;exit;

				
			break;
			// END

			case 'lkob_klaim_header':
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

				$sql ="
					SELECT A.id, A.iduser, A.semester, A.jenis_klaim as kode_klaim,
					D.jenis_klaim,
					B.id_smt1,C.id_smt2,
					A.rka_jml_klaim, 
					A.rka_jml_pembayaran, 
					COALESCE(SUM(B.jml_klaim), 0) as jml_klaim_smt1,
					COALESCE(SUM(B.jml_pembayaran), 0) as jml_pembayaran_smt1,
					COALESCE(SUM(C.jml_klaim), 0) as jml_klaim_smt2,
					COALESCE(SUM(C.jml_pembayaran), 0) as jml_pembayaran_smt2,
					COALESCE(ROUND((A.rka_jml_klaim/C.jml_klaim)*100, 2),0) as pers_penerimaan,
					COALESCE(ROUND((A.rka_jml_pembayaran/C.jml_pembayaran)*100, 2),0) as pers_pembayaran,
					COALESCE(ROUND(((C.jml_klaim - B.jml_klaim)/B.jml_klaim)*100, 2),0) as pers_kenaikan_penerima,
					COALESCE(ROUND(((C.jml_pembayaran - B.jml_pembayaran)/B.jml_pembayaran)*100, 2),0) as pers_kenaikan_pembayaran
					FROM tbl_lkob_klaim_header A
					LEFT JOIN(
						SELECT id as id_smt1, jenis_klaim, tbl_lkob_klaim_header_id,jml_klaim, jml_pembayaran, tahun
						FROM tbl_lkob_klaim_detail
						WHERE semester = '1'
						AND iduser ='".$iduser."'
						AND tahun ='".$tahun."'
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

			case 'lkob_klaim_detail':
				

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
				
				$sql = "
					SELECT B.id, B.iduser, B.id_cabang,C.nama_cabang, A.*,
						MAX(IF(B.semester = '1', B.jml_klaim,0)) as jml_klaim_smt1,
						MAX(IF(B.semester = '1', B.jml_pembayaran,0)) as jml_pembayaran_smt1,
						MAX(IF(D.semester = '2', D.jml_klaim,0)) as jml_klaim_smt2,
						MAX(IF(D.semester = '2', D.jml_pembayaran,0)) as jml_pembayaran_smt2
					FROM mst_jenis_klaim A
					LEFT JOIN (
						SELECT id, iduser, semester, jenis_klaim, id_cabang, jml_klaim, jml_pembayaran, tahun
						FROM tbl_lkob_klaim_detail
						WHERE iduser ='".$iduser."'
						AND semester = '1'
						AND tahun ='".$tahun."'
					)B ON A.kode_klaim = B.jenis_klaim
					LEFT JOIN (
						SELECT id, iduser, semester, jenis_klaim, id_cabang, jml_klaim, jml_pembayaran, tahun
						FROM tbl_lkob_klaim_detail
						WHERE iduser ='".$iduser."'
						AND semester = '2'
						AND tahun ='".$tahun_filter."'
					)D ON A.kode_klaim = D.jenis_klaim
					LEFT JOIN mst_cabang C ON C.id_cabang=B.id_cabang
					WHERE B.iduser IS NOT NULL
					AND B.iduser ='".$iduser."'
					GROUP BY A.kode_klaim, C.id_cabang
					ORDER BY B.id_cabang ASC
				";
				 // echo $sql;exit;
			break;
			case 'tbl_lkob_klaim_header':
				$sql="
					SELECT A.*
					FROM tbl_lkob_klaim_header A
					WHERE A.semester = '".$p2."'
					AND A.jenis_klaim = '".$p1."'
					AND A.tahun = '".$tahun."'
				";
			break;

			case 'tbl_lkob_klaim_detail':
				$sql="
					SELECT A.*
					FROM tbl_lkob_klaim_detail A
					WHERE A.semester = '".$p2."'
					AND A.tbl_lkob_klaim_header_id = '".$p1."'
					AND A.tahun = '".$tahun."'
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