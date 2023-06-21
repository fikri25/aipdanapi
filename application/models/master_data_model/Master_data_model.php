<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_data_model extends CI_Model {
	private $table;
	function __construct(){
		parent::__construct();
	}
	
	function simpandata($table,$data,$sts_crud){ //$sts_crud --> STATUS INSERT, UPDATE, DELETE
		$this->db->trans_begin();

		if(isset($data['id_investasi'])){
			$id = $data['id_investasi'];
			//unset($data['id_investasi']);
		}if(isset($data['id'])){
			$id = $data['id'];
			// unset($data['id']);
		}if(isset($data['id_aruskas'])){
			$id = $data['id_aruskas'];
			// unset($data['id']);
		}if(isset($data['kode_klaim'])){
			$id = $data['kode_klaim'];
			// unset($data['id']);
		}if(isset($data['id_kelompok'])){
			$id = $data['id_kelompok'];
			// unset($data['id']);
		}if(isset($data['id_penerima'])){
			$id = $data['id_penerima'];
			// unset($data['id']);
		}
		
		if($sts_crud == "add"){
			unset($data['id_investasi']);
			unset($data['id']);
		}

		switch($table){
			case 'master_investasi':
				 // print_r($data);exit;
				$table_data = "mst_investasi";

				if($sts_crud == "add"){
					$iduser = $data['iduser'];
					$group = $data['group'];
					$id_perdnbersih = $data['id_perubahan_dana_bersih'];

					// nomor urut
					$sql_max = "
					SELECT max(no_urut) as idx FROM mst_investasi
					WHERE `group`= '".$group."'
					AND iduser = '".$iduser."'
					";
					$urutan = $this->db->query($sql_max)->row_array();

					if($urutan['idx'] != "" || $urutan['idx'] != null){
						$no_urut =  $urutan['idx'] + 1;
					}else{
						$no_urut = '1';
					}


					$data['no_urut'] = $no_urut;

					// nomor urut perubahan dana bersih
					$sql_max2 = "
					SELECT max(no_urut_group) as idx2 FROM mst_investasi
					WHERE iduser = '".$iduser."'
					AND id_perubahan_dana_bersih = '".$id_perdnbersih."'
					";

					$urutan2 = $this->db->query($sql_max2)->row_array();

					if($urutan2['idx2'] != "" || $urutan2['idx2'] != null){
						$no_urut2 =  $urutan2['idx2'] + 1;
					}else{
						$no_urut2 = '1';
					}


					$data['no_urut_group'] = $no_urut2;
				}

				if($sts_crud == "add" || $sts_crud == "edit"){
					$jns_form = $data['jns_form'];
					// $no_urut_group = $data['no_urut_group'];
					$type = 'C';


					if($table == "master_investasi"){
						$no = ( isset( $data['no_urut_sub']) ?  $data['no_urut_sub'] : array() ); 
						$jenis = ( isset( $data['jenis_investasi_sub']) ?  $data['jenis_investasi_sub'] : array() );

						if(isset($data['no_urut_sub'])){
							unset($data['no_urut_sub']);
						}

						if(isset($data['jenis_investasi_sub'])){
							unset($data['jenis_investasi_sub']);
						}

					}
					
				}

				if($sts_crud == "edit"){
					if(isset($jenis)){
						$this->db->delete('mst_investasi', array('parent_id'=>$id) );
							// $this->db->delete('mst_investasi', array('id_investasi'=>$id) );
					}
				}
				if($sts_crud == "delete"){
					$this->db->delete('mst_investasi', array('id_investasi'=>$data['id']));
					if($data['tipe'] == 'PC'){
						$this->db->delete('mst_investasi', array('parent_id'=>$data['id']) );
					}
				}
			break;

			case 'master_nama_pihak':
				// print_r($data);exit;

				$table_data = "mst_nama_pihak";
				if($sts_crud == "add" || $sts_crud == "edit"){
					$kd_pihak = $data['nama_pihak'];


					$jns_invest = ( isset( $data['jns_invest']) ?  $data['jns_invest'] : array() );
					if(isset($data['jns_invest'])){
						unset($data['jns_invest']);
					}

					// unset($data['group']);
				}

				if($sts_crud == "edit"){
					$this->db->delete('mst_nama_pihak', array('kode_pihak'=>$data['nama_pihak'],'group'=>$data['group']));	
					
				}
			break;
			case 'mst_pihak':
				$table_data = "mst_pihak";	
			break;
			case 'master_cabang':
				$table_data = "mst_cabang";	
			break;
			case 'master_aruskas':
				$table_data = "mst_aruskas";	
			break;
			case 'master_klaim':
				$table_data = "mst_jenis_klaim";	
			break;
			case 'master_kelompok_penerima':
				$table_data = "mst_kelompok_penerima";	
			break;
			case 'master_jenis_penerima':
				$table_data = "mst_jenis_penerima";	
			break;
		}
		switch ($sts_crud){
			case "add":
				if($table_data != "mst_nama_pihak"){
					$insert = $this->db->insert($table_data,$data);
					$id = $this->db->insert_id();

					if($insert){
						if($table_data == "mst_investasi"){
							if(isset($jenis)){
								foreach($jenis as $k => $v){

									$arr_detail = array(
										'parent_id' => $id,
										'iduser' => $iduser,
										'jns_form' => $jns_form,
										'group' => $group,
										'type_sub_jenis_investasi' => $type,
										'id_dana_besih' => $data['id_dana_besih'],
										'id_perubahan_dana_bersih' => $data['id_perubahan_dana_bersih'],
										'jenis_investasi' => escape($jenis[$k]),
										'no_urut' => escape($no[$k]),
										'no_urut_group' => $data['no_urut_group'],
									);
									// print_r($arr_detail);exit();
									$this->db->insert('mst_investasi', $arr_detail);
								}
							}

						}

					}
				}


				if($table_data == "mst_nama_pihak"){
					if(isset($jns_invest)){
						foreach($jns_invest as $k => $v){
							$arr_detail = array(
								'kode_pihak' => $kd_pihak,
								'group' => $data['group'],
								'id_investasi' => $jns_invest[$k],
							);
							$this->db->insert('mst_nama_pihak', $arr_detail);
						}
					}

				}
			break;
			case "edit":
				if($table == "master_cabang"){
					$this->db->update($table_data,$data, array('id_cabang' => $data['id_cabang']));
				}if($table == "master_aruskas"){
					$this->db->update($table_data,$data, array('id_aruskas' => $data['id_aruskas']));
				}if($table == "master_klaim"){
					$this->db->update($table_data,$data, array('kode_klaim' => $data['kode_klaim']));
				}if($table == "master_kelompok_penerima"){
					$this->db->update($table_data,$data, array('id_kelompok' => $data['id_kelompok']));
				}if($table == "master_jenis_penerima"){
					$this->db->update($table_data,$data, array('id_penerima' => $data['id_penerima']));
				}if($table == "mst_pihak"){
					$this->db->update($table_data,$data, array('id' => $data['id']));
				}

				if($table_data == "mst_nama_pihak"){
					unset($data['id_investasi']);
					if(isset($jns_invest)){
						foreach($jns_invest as $k => $v){
							$arr_detail = array(
								'kode_pihak' => $kd_pihak,
								'group' => $data['group'],
								'id_investasi' => $jns_invest[$k],
							);
							$this->db->insert('mst_nama_pihak', $arr_detail);
						}
					}
				}

				if($table == "master_investasi"){	
					$update = $this->db->update($table_data,$data, array('id_investasi' => $data['id_investasi']));

					if($update){
						if($table_data == "mst_investasi"){
							if(isset($jenis)){
								foreach($jenis as $k => $v){

									$arr_detail = array(
										'parent_id' => $id,
										'iduser' => $data['iduser'],
										'jns_form' => $data['jns_form'],
										'group' => $data['group'],
										'type_sub_jenis_investasi' => $type,
										'id_dana_besih' => $data['id_dana_besih'],
										'id_perubahan_dana_bersih' => $data['id_perubahan_dana_bersih'],
										'jenis_investasi' => escape($jenis[$k]),
										'no_urut' => escape($no[$k]),
										'no_urut_group' => $data['no_urut_group'],
									);
									$this->db->insert('mst_investasi', $arr_detail);
								}
							}

						}
					}
				}
			break;

			case "delete":
				if($table == "master_cabang"){
					$this->db->delete($table_data, array('id_cabang'=>$id) );
				}else if($table == "master_aruskas"){
					$this->db->delete($table_data, array('id_aruskas'=>$id) );
				}else if($table == "master_klaim"){
					$this->db->delete($table_data, array('kode_klaim'=>$id) );
				}else if($table == "master_kelompok_penerima"){
					$this->db->delete($table_data, array('id_kelompok'=>$id) );
				}else if($table == "master_jenis_penerima"){
					$this->db->delete($table_data, array('id_penerima'=>$id) );
				}else if($table == "master_investasi"){
					$this->db->delete($table_data, array('id_investasi'=>$id) );
				}else if($table == "master_nama_pihak"){
					$this->db->delete($table_data, array('kode_pihak'=>$data['tipe'],'group'=>$data['id']) );
				}else if($table == "mst_pihak"){
					$this->db->delete($table_data, array('id'=>$data['id']) );
				}

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
		$wher2  = " WHERE 1=1 ";
		$where3  = " WHERE 1=1 ";

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
			case "data_jenis_invest":
				$sql = "
				SELECT A.id_investasi as id, A.jenis_investasi as txt
				FROM mst_investasi A
				WHERE A.iduser = '".$p1."'
				AND A.group ='".$p2."'
				AND NOT A.type_sub_jenis_investasi ='PC'
				";
					 // echo $sql;exit;
			break;
			case 'data_mst_pihak':
				$sql = "
					SELECT A.kode_pihak as id, A.nama_pihak as txt
					FROM mst_pihak A
					WHERE A.iduser = '".$p1."'
					ORDER BY A.id DESC
				";
				 // echo $sql;exit;
			break;
			case 'mst_dana_bersih':
				$sql="
					SELECT A.id_dana_bersih as id, A.uraian as txt
					FROM mst_dana_bersih A
				";
			break;
			case 'mst_perubahan_danabersih':
				$sql="
					SELECT A.id_perubahan_dana_bersih as id, A.uraian as txt
					FROM mst_perubahan_danabersih A
				";
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
		$id_bulan = $this->session->userdata('id_bulan');

		if($level == 'DJA'){
			$iduser = $this->input->post('iduser');
			if($iduser != ""){
				$where .= "
				AND B.iduser =  '".$iduser."'
				";
				$where2 .= "
				AND A.iduser =  '".$iduser."'
				";
			}
			
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
			case 'mst_jenis_investasi':
				$sql = "
				SELECT A.* 
				FROM mst_investasi A  
				WHERE A.iduser = '".$p1."'
				AND A.`group` = '".$p2."'
				AND NOT A.type_sub_jenis_investasi ='PC'
				";
					// echo $sql;exit;
			break;
			case 'master_investasi':
				$group = $this->input->post('group');
				if($group != ""){
					$where2 .= "
					AND A.group = '".$group."'
					";
				}

				$sql = "
				SELECT A.*, A.type_sub_jenis_investasi as type
				FROM mst_investasi A  
				$where2
				AND (A.type_sub_jenis_investasi ='P' OR A.type_sub_jenis_investasi ='PC')
				ORDER BY A.id_investasi DESC
				";
					// echo $sql;exit;
			break;
			case 'master_nama_pihak':
				$group = $this->input->post('group');
				if($group != ""){
					$where2 .= "
					AND C.group = '".$group."'
					";
				}

				$sql = "
				SELECT A.*, B.id_investasi, C.`group`, C.jenis_investasi
				FROM mst_pihak A
				LEFT JOIN mst_nama_pihak B ON A.kode_pihak = B.kode_pihak
				LEFT JOIN mst_investasi C ON B.id_investasi = C.id_investasi
				$where2
				AND C.`group` IS NOT NULL
				GROUP BY C.`group`, A.kode_pihak, A.iduser
				ORDER BY A.insert_at DESC

				";
				// echo $sql;exit;
			break;
			case 'data_master_nama_pihak_header':
				$sql = "
				SELECT A.*, B.id_investasi, C.`group`, C.jenis_investasi
				FROM mst_pihak A
				LEFT JOIN mst_nama_pihak B ON A.kode_pihak = B.kode_pihak
				LEFT JOIN mst_investasi C ON B.id_investasi=C.id_investasi
				WHERE A.iduser = '".$p3."'
				AND C.group = '".$p1."'
				AND A.`kode_pihak` = '".$p2."'


				";
			break;
			case 'data_master_nama_pihak_detail':
				$sql = "
				SELECT A.*, B.id_investasi, C.`group`, C.jenis_investasi
				FROM mst_pihak A
				LEFT JOIN mst_nama_pihak B ON A.kode_pihak = B.kode_pihak
				LEFT JOIN mst_investasi C ON B.id_investasi=C.id_investasi
				WHERE B.kode_pihak = '".$p1."'
				AND C.group = '".$p2."'

				";
				// echo $sql;exit;
			break;
			case 'mst_pihak':
				if($p1 != ""){
					$where2 .= "
					AND A.id = '".$p1."'
					";
				}

				$sql="
					SELECT A.* 
					FROM mst_pihak A  
					$where2
					ORDER BY A.id DESC
				";
			break;
			case 'master_cabang':
				$sql="
					SELECT A.* 
					FROM mst_cabang A  
					$where2
					ORDER BY A.id_cabang DESC
				";
			break;
			case 'master_aruskas':
				if($p1 != ""){
					$where2 .= "
					AND A.id_aruskas = '".$p1."'
					";
				}

				$kas = $this->input->post('kas');
				if($kas != ""){
					$where2 .= "
					AND A.jenis_kas = '".$kas."'
					";
				}

				$sql="
					SELECT A.* 
					FROM mst_aruskas A  
					$where2
					ORDER BY A.id_aruskas DESC
				";
			break;
			case 'master_klaim':
				if($p1 != ""){
					$where2 .= "
					AND A.kode_klaim = '".$p1."'
					";
				}

				$sql="
					SELECT A.* 
					FROM mst_jenis_klaim A  
					$where2
				";
			break;
			case 'master_kelompok_penerima':
				if($p1 != ""){
					$where2 .= "
					AND A.id_kelompok = '".$p1."'
					";
				}
				$flag = $this->input->post('flag');
				if($flag != ""){
					$where2 .= "
					AND A.flag = '".$flag."'
					";
				}

				$sql="
					SELECT A.* 
					FROM mst_kelompok_penerima A  
					$where2
					ORDER BY A.id_kelompok DESC
				";
			break;
			case 'master_jenis_penerima':
				if($p1 != ""){
					$where2 .= "
					AND A.id_penerima = '".$p1."'
					";
				}
				$sql="
					SELECT A.* 
					FROM mst_jenis_penerima A  
					$where2
					ORDER BY A.id_penerima DESC
				";
			break;
			case 'master_cabang_detail':
				$sql="
					SELECT A.* 
					FROM mst_cabang A  
					$where2
					AND A.id_cabang = '".$p1."'
				";
			break;
			case 'data_master_investasi':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					WHERE A.id_investasi =  '".$p1."'
				";
					  // echo $sql;exit;
			break;
			case 'data_detail_master_investasi':
				$sql = "
					SELECT A.* 
					FROM mst_investasi A  
					$where2
					AND A.parent_id =  '".$p1."'
					AND (A.type_sub_jenis_investasi ='PC' OR A.type_sub_jenis_investasi ='C')
				";
					// echo $sql;exit;
			break;

			case 'cek_kode_pihak':
				$sql = "
					SELECT count(*) as total
					FROM mst_pihak A  
					WHERE A.kode_pihak = '".$p1."' 
					AND A.iduser = '".$p2."' 
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
	
}