<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_investasi_model extends CI_Model {
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
		$query = $this->db->get_where('ket_lap_semesteran',array('id' => $id,'iduser' => $this->iduser,'tahun' => $this->tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function get_by_id_karakter_invest($id){
		$response = false;
		$query = $this->db->get_where('tbl_karakteristik_invest',array('id' => $id,'iduser' => $this->iduser,'tahun' => $this->tahun));
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
				AND A.tahun = '".$tahun."'
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

			case 'karakteristik_investasi':
				$table_data = "tbl_karakteristik_invest";

				if($sts_crud == "add" || $sts_crud == "edit"){
					$data['karakteristik'] = escape($data['karakteristik']);
					$data['resiko'] = escape($data['resiko']);

					$tahun = $this->session->userdata('tahun');
					$level = $this->session->userdata('level');
					$path = $_FILES['filedata']['name']; // file means your input type file name
					$ext = pathinfo($path, PATHINFO_EXTENSION);

					if ($ext=="pdf" OR $ext=="doc" OR $ext=="docx" OR $ext=="") {
						$upload_path   = './files/file_semesteran/aspek_investasi/'; //path folder
						$data['filedata_lama'] = escape($data['filedata_lama']);

						if(!empty($_FILES['filedata']['name'])){                  
							if(isset($data["filedata_lama"])){
								if($data["filedata_lama"] != ""){
									unlink($upload_path.$data["filedata_lama"]);
								}
							}

							$file_data = 'File_karakteristik_investasi_Semester_'.$data['semester'].'_'.$tahun.'_'.$level;
							$filename_data =  $this->lib->uploadnong($upload_path, 'filedata', $file_data);
						}else{
							$filename_data = (isset($data["filedata_lama"]) ? $data["filedata_lama"] : null );
						}

						$data["filedata"] = $filename_data;
						unset($data["filedata_lama"]);
					}else{
						return false;
					}
						
				}
			break;

			

		}
		
		switch ($sts_crud){
			case "add":
				// print_r($data);exit;
				$data['insert_at'] = date('Y-m-d H:i:s');
				$data['iduser'] = $this->iduser;
				$data['tahun'] = $this->tahun;
				if($table == 'karakteristik_investasi'){
					$insert = $this->db->insert($table_data,$data);
				}

				// ASET BUKAN INVESTASI
				if($table == 'aset_bukan_investasi'){
					if($jns_form == 10){
						unset($data['jns_form']);

						$insert = $this->db->insert($table_data,$data);
						$id = $this->db->insert_id();

						if($insert){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'no_urut' => escape($no[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
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

				if($table == 'karakteristik_investasi'){
					$update = $this->db->update($table_data, $data, array('id' => $id) );
				}

				// ASET BUKAN INVESTASI
				if($table == 'aset_bukan_investasi'){
					if($jns_form == 10){
						unset($data['jns_form']);

						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'no_urut' => escape($no[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}
						}
					}
				}

			break;
			case "delete":
				if($table == 'karakteristik_investasi'){
					$this->db->delete($table_data, array('id_investasi' => $id));	
				}

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
						AND id_bulan BETWEEN 1 AND 6
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 7 AND 12
					";
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.rka, 
					COALESCE(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir_smt1 end, 0) as saldo_akhir_smt1,
					COALESCE(CASE WHEN A.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir_smt2 end, 0) as saldo_akhir_smt2,
					B.id,
					D.mutasi_penambahan as mutasi_penambahan,
					D.mutasi_pengurangan as mutasi_pengurangan
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, rka, sum(saldo_akhir_invest) as saldo_akhir_smt1, sum(mutasi_invest) as mutasi, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						$where_sm1
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id,id_investasi, rka, sum(saldo_akhir_invest) as saldo_akhir_smt2, sum(mutasi_invest) as mutasi, id_bulan, iduser, tahun
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
						AND id_bulan BETWEEN 1 AND 6
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 7 AND 12
					";
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type,B.id,
					B.rka as rka, 
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir end), 0) as saldo_akhir_smt1,
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_smt2,
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
						AND id_bulan BETWEEN 1 AND 6
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 7 AND 12
					";
				}

				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type,B.id,
					B.rka as rka, 
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir end), 0) as saldo_akhir_smt1,
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_smt2,

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
				$where_1  = " WHERE 1=1 ";
				if ($p2 != "") {
                    $where_1 .= "
                    AND semester = '".$p2."'
                    ";
                }else{
                    $where_1 .= "
                    AND semester = '1'
                    ";
                }

                $sql="
                    SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
                    B.karakteristik, B.resiko, B.id
                    FROM mst_investasi A
                    LEFT JOIN(
                        SELECT id,id_investasi, karakteristik, resiko,iduser
                        FROM tbl_karakteristik_invest
                        $where_1
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
				$where_1  = " WHERE 1=1 ";
				if ($p2 != "") {
                    $where_1 .= "
                    AND semester = '".$p2."'
                    ";
                }else{
                    $where_1 .= "
                    AND semester = '1'
                    ";
                }
                
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.karakteristik, B.resiko, B.id
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, karakteristik, resiko,iduser
						FROM tbl_karakteristik_invest
						$where_1
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
			case 'karakteristik_invest':
				$sql = "
					SELECT A.*
					FROM tbl_karakteristik_invest A  
					$where2  
					AND A.id_investasi ='".$p1."'
				";
			break;
			case 'data_aset_investasi_header':
				$sql = "
					SELECT A.*, B.*
					FROM bln_aset_investasi_header A  
					LEFT JOIN mst_investasi B  on B.id_investasi = A.id_investasi
					$where2  
					AND A.id_bulan = '".$id_bulan."'
					AND A.tahun = '".$tahun."'
					AND B.group ='INVESTASI'  
					ORDER BY A.id_investasi ASC
				";
			break;
			case 'data_aset_bkn_investasi_header':
				$sql = "
					SELECT A.*, B.*
					FROM bln_aset_investasi_header A  
					LEFT JOIN mst_investasi B  on B.id_investasi = A.id_investasi
					$where2  
					AND A.id_bulan = '".$id_bulan."'
					AND A.tahun = '".$tahun."'
					AND B.group ='BUKAN INVESTASI'    
					ORDER BY A.id_investasi ASC
				";
			break;
			case 'data_hasil_investasi_header':
				$sql = "
					SELECT A.*, B.*
					FROM bln_aset_investasi_header A  
					LEFT JOIN mst_investasi B  on B.id_investasi = A.id_investasi
					$where2  
					AND A.id_bulan = '".$id_bulan."'
					AND A.tahun = '".$tahun."'
					AND B.group ='HASIL INVESTASI'    
					ORDER BY A.id_investasi ASC
				";
			break;
			case 'data_kewajiban_header':
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.group,
					B.id_bulan, B.saldo_akhir
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id_investasi,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND tahun = '".$tahun."'
						AND iduser =  '".$iduser."'
					) B ON A.id_investasi = B.id_investasi
					WHERE 1=1
					AND A.`group`='KEWAJIBAN'
					AND A.iduser = '".$iduser."'
					ORDER BY A.no_urut ASC
				";
			break;
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
					AND A.group ='INVESTASI'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_bkn_investasi':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND A.group ='BUKAN INVESTASI'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_hasil_investasi':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND A.group ='HASIL INVESTASI'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_jenis_investasi_kewajiban':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND A.group ='KEWAJIBAN'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_jenis_investasi_iuran':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND A.group ='IURAN'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'mst_jenis_investasi_beban':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND A.group ='BEBAN'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'data_bulan_lalu_hasilinvest':
				$bln_lalu = $id_bulan - 1 ;
				$sql = "
					SELECT A.saldo_akhir_invest as saldo_bln_lalu
					FROM bln_aset_investasi_header A
					$where2
					AND A.id_bulan = '".$bln_lalu."' 
					AND A.tahun = '".$tahun."' 
					AND A.id_investasi = '".$p1."'
				";
				// echo $sql;exit;
			break;
			case 'data_bulan_lalu_form':
				$bln_lalu = $id_bulan - 1 ;
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi, 
					C.id as id_detail, C.bln_aset_investasi_header_id, C.iduser, C.id_bulan, C.kode_pihak, C.saldo_awal, B.tahun,
					C.mutasi_pembelian, C.mutasi_penjualan, C.mutasi_amortisasi, C.mutasi_pasar, C.saldo_akhir, C.lembar_saham,
					C.manager_investasi, C.nama_reksadana, C.jml_unit_reksadana, C.harga_saham, C.persentase, 
					C.mutasi_penanaman, C.mutasi_pencairan, C.mutasi_nilai_wajar, C.mutasi_diskonto, C.peringkat, C.tgl_jatuh_tempo,
					C.r_kupon, C.nama_produk,C.jml_unit_penyertaan,C.cabang, C.bunga, C.nilai_perolehan,
					C.no_urut, D.nama_pihak
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					LEFT JOIN bln_aset_investasi_detail C  on C.bln_aset_investasi_header_id = B.id
					LEFT JOIN mst_pihak D ON D.kode_pihak = C.kode_pihak
					$where
					AND B.id_investasi = '".$p1."' 
					AND A.jns_form = '".$p2."' 
					AND B.id_bulan = '".$bln_lalu."' 
					AND B.tahun = '".$tahun."' 
					AND C.bln_aset_investasi_header_id  IS NOT NULL
					ORDER BY C.no_urut ASC
				";

				// echo $sql;exit;
			break;

			case 'data_aset_investasi':
				$sql = "
					SELECT A.iduser, A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head, B.tahun,
					B.saldo_awal_invest, B.mutasi_invest, B.saldo_akhir_invest, B.rka, B.realisasi_rka , B.id
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					$where
					AND B.id = '".$p1."' 
					AND A.jns_form = '".$p2."' 
					AND B.id_bulan = '".$id_bulan."' 
					AND B.tahun = '".$tahun."' 
					ORDER BY A.id_investasi ASC
				";

				// echo $sql;exit;
			break;

			case 'data_detail_aset_investasi':
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi as id_invesatasi_head,  B.tahun,
					C.id as id_detail, C.bln_aset_investasi_header_id, C.iduser, C.id_bulan, C.kode_pihak, C.saldo_awal,
					C.mutasi_pembelian, C.mutasi_penjualan, C.mutasi_amortisasi, C.mutasi_pasar, C.saldo_akhir, C.lembar_saham,
					C.manager_investasi, C.nama_reksadana, C.jml_unit_reksadana, C.harga_saham, C.persentase, 
					C.mutasi_penanaman, C.mutasi_pencairan, C.mutasi_nilai_wajar, C.mutasi_diskonto, C.peringkat, C.tgl_jatuh_tempo,
					C.r_kupon, C.nama_produk,C.jml_unit_penyertaan,C.cabang, C.bunga, C.nilai_perolehan,
					C.no_urut, 
					D.nama_pihak
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					LEFT JOIN bln_aset_investasi_detail C  on C.bln_aset_investasi_header_id = B.id
					LEFT JOIN mst_pihak D ON D.kode_pihak = C.kode_pihak
					$where
					AND B.id = '".$p1."' 
					AND A.jns_form = '".$p2."' 
					AND B.id_bulan = '".$id_bulan."' 
					AND B.tahun = '".$tahun."' 
					AND C.bln_aset_investasi_header_id  IS NOT NULL
					ORDER BY C.no_urut ASC
				";

				// echo $sql;exit;
			break;

			case 'data_hasil_investasi':
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head,
					B.saldo_awal_invest, B.mutasi_invest, B.saldo_akhir_invest, B.rka, B.realisasi_rka , B.tahun, B.id
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					$where
					AND B.id = '".$p1."' 
					AND B.id_bulan = '".$id_bulan."' 
					AND B.tahun = '".$tahun."' 
					ORDER BY A.id_investasi ASC
				";

				// echo $sql;exit;
			break;

			case 'cek_aset_investasi':
				$sql = "
					SELECT count(*) as total, A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head, B.tahun, B.id,
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					$where
					AND  A.id_investasi = '".$p1."' 
					AND  B.id_bulan = '".$id_bulan."' 
					AND  B.tahun = '".$tahun."' 
					ORDER BY A.id_investasi ASC
				";

				// echo $sql;exit;
			break;

			case 'dana_bersih_lv1':
				$sql="
					SELECT A.*, B.id_investasi,B.iduser, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id_investasi = D.id_investasi


					WHERE B.iduser = '".$iduser."'
					GROUP BY A.jenis_laporan
				";
			break;

			case 'dana_bersih_lv2':
				$bln_lalu = $id_bulan - 1 ;
				$sql="
					SELECT A.*, B.id_investasi,B.iduser, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND A. jenis_laporan = '".$p1."'
					GROUP BY A.uraian
					ORDER BY A.id_dana_bersih ASC
				";

				// echo $sql;exit;
			break;

			case 'dana_bersih_lv3':
				$bln_lalu = $id_bulan - 1 ;
				$sql="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.type_sub_jenis_investasi, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
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
				$bln_lalu = $id_bulan - 1 ;
				$sql="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.type_sub_jenis_investasi, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
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
				$bln_lalu = $id_bulan - 1 ;
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					GROUP BY A.uraian
				";
			break;

			case 'perubahan_danabersih_lv2':
				$bln_lalu = $id_bulan - 1 ;
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan  BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan  BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND A.uraian ='".$p1."'
					GROUP BY B.group
				";
				 // echo $sql;exit;
			break;

			case 'perubahan_danabersih_lv3':
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND (B.type_sub_jenis_investasi ='P' OR B.type_sub_jenis_investasi ='PC')
					AND B.group = '".$p1."'
					GROUP BY B.id_investasi
					ORDER BY B.no_urut ASC
				";
			break;

			case 'perubahan_danabersih_lv4':
				$bln_lalu = $id_bulan - 1 ;
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND B.parent_id ='".$p1."'
					AND B.type_sub_jenis_investasi ='".$p2."'
					GROUP BY B.id_investasi
					ORDER BY B.no_urut ASC
				";
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