<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arus_kas_model extends CI_Model {
	private $table;
	function __construct(){
      parent::__construct();
      $this->tahun = $this->session->userdata('tahun');
      $this->iduser = $this->session->userdata('iduser');
	  $this->table = 'bln_arus_kas_investasi';
	}
	
	/*===================================================================================================*/
	/* function keterangan */

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

	public function get_by_id_kas($id){
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$response = false;
		$query = $this->db->get_where('bln_arus_kas',array('id' => $id,'iduser' => $iduser,'tahun' => $tahun));
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
			case "arus_kas":
				$iduser = $this->session->userdata('iduser');
				$tahun = $this->session->userdata('tahun');
				$level = $this->session->userdata('level');

				$table_data = "bln_arus_kas";

				if($sts_crud == "add" || $sts_crud == "edit"){
					$id_bulan = $data['id_bulan'];
					$jenis_kas = $data['jenis_kas'];

					$id_aruskas = ( isset( $data['id_aruskas']) ?  $data['id_aruskas'] : array() );
					$saldo_bulan_berjalan = ( isset( $data['saldo_bulan_berjalan']) ?  $data['saldo_bulan_berjalan'] : array() );
					$keterangan = ( isset( $data['keterangan']) ?  $data['keterangan'] : array() ); 
					$filedata = ( isset( $data['filedata_lama']) ?  $data['filedata_lama'] : array() ); 
					// $saldo_bulan_lalu = ( isset( $data['saldo_bulan_lalu']) ?  $data['saldo_bulan_lalu'] : array() ); 
					

					if(isset($data['id_aruskas'])){
						unset($data['id_aruskas']);
					}
					if(isset($data['saldo_bulan_berjalan'])){
						unset($data['saldo_bulan_berjalan']);
					}
					if(isset($data['filedata'])){
						unset($data['filedata']);
					}
					if(isset($data['keterangan'])){
						unset($data['keterangan']);
					}
					// if(isset($data['saldo_bulan_lalu'])){
					// 	unset($data['saldo_bulan_lalu']);
					// }

					// UPLOAD MULTIPLE FILE
					$name_data = array();
					foreach($filedata as $k => $v){
						$path[$k] = $_FILES['filedata']['name'][$k]; // file means your input type file name
						$ext[$k] = pathinfo($path[$k], PATHINFO_EXTENSION);

						if ($ext[$k]=="pdf" OR $ext[$k]=="doc" OR $ext[$k]=="docx" OR $ext[$k]=="") {
							$upload_path   = './files/file_bulanan/'.$table.'/'; //path folder
							$data['filedata_lama'][$k] = escape($data['filedata_lama'][$k]);

							if(!empty($_FILES['filedata']['name'][$k])){                  
								if(isset($data["filedata_lama"][$k])){
									if($data["filedata_lama"][$k] != ""){
										unlink($upload_path.$data["filedata_lama"][$k]);
									}
								}

								$file_data = 'File_Arus_Kas_'.$id_aruskas[$k].'_'.$id_bulan.'_'.$tahun.'_'.$level;

								$filename_data =  $this->lib->uploadmultiplenong($upload_path, 'filedata', $file_data, $k);
							}else{
								$filename_data = (isset($data["filedata_lama"][$k]) ? $data["filedata_lama"][$k] : null );
							}

							$name_data[$k] = $filename_data;
							unset($data["filedata_lama"][$k]);
						}else{
							return false;
						}
	

					}
				
				}
				
				if($sts_crud == "delete" || $sts_crud == "edit"){
					$this->db->delete('bln_arus_kas', array('jenis_kas'=>$jenis_kas,'id_bulan'=>$id_bulan,'iduser'=>$this->iduser,'tahun'=>$tahun) );
				}
			break;

		}
		
		switch ($sts_crud){
			case "add":
				// print_r($data);exit;
				if($table_data == "bln_arus_kas"){
					unset($data['aktivitas']);
					if(isset($id_aruskas)){
						foreach($id_aruskas as $k => $v){
							$saldo_bulan_berjalan[$k] = str_replace('.', '', $saldo_bulan_berjalan[$k]);
							// $saldo_bulan_lalu[$k] = str_replace('.', '', $saldo_bulan_lalu[$k]);

							$arr_aruskas = array(
								'id_bulan' => $id_bulan,
								'jenis_kas' => $jenis_kas,
								'iduser' => $this->iduser,
								'tahun' => $tahun,
								'id_aruskas' => escape($id_aruskas[$k]),
								'saldo_bulan_berjalan' => escape($saldo_bulan_berjalan[$k]),
								'keterangan' => escape($keterangan[$k]),
								'filedata' => escape($name_data[$k]),
								// 'saldo_bulan_lalu' => escape($saldo_bulan_lalu[$k]),
								'insert_at' => date('Y-m-d H:i:s'),
							);
							// print_r($arr_aruskas);
							$this->db->insert('bln_arus_kas', $arr_aruskas);
						}
					}

				}

			break;
			case "edit":
				if($table_data == "bln_arus_kas"){
					unset($data['aktivitas']);
					if(isset($id_aruskas)){
						foreach($id_aruskas as $k => $v){
							$saldo_bulan_berjalan[$k] = str_replace('.', '', $saldo_bulan_berjalan[$k]);
							// $saldo_bulan_lalu[$k] = str_replace('.', '', $saldo_bulan_lalu[$k]);

							$arr_aruskas = array(
								'id_bulan' => $id_bulan,
								'jenis_kas' => $jenis_kas,
								'iduser' => $this->iduser,
								'tahun' => $tahun,
								'id_aruskas' => escape($id_aruskas[$k]),
								'saldo_bulan_berjalan' => escape($saldo_bulan_berjalan[$k]),
								'keterangan' => escape($keterangan[$k]),
								'filedata' => escape($name_data[$k]),
								// 'saldo_bulan_lalu' => escape($saldo_bulan_lalu[$k]),
								'insert_at' => date('Y-m-d H:i:s'),
							);
							$this->db->insert('bln_arus_kas', $arr_aruskas);
						}
					}

				}

				
			break;
			case "delete":
				$this->db->delete($table_data, array('id' => $id,'tahun'=>$tahun));	
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
			case 'header_arus_kas':
				$sql = "
					SELECT A.*
					FROM mst_aruskas A  
					$where2
					AND A.jenis_kas ='".$p1."'
				";
			break;
			case 'data_detail_arus_kas':
				// konsisi bulan lalu
				if($id_bulan == 1){
					if($id_bulan == 1 and $tahun == 2020){
						$bln_lalu = $id_bulan -1;
						$tahun_lalu = $tahun;
					}else{	
						$bln_lalu = 12;
						$tahun_lalu = $tahun - 1;
					}
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql ="
					SELECT
					A.id_aruskas, A.jenis_kas,A.arus_kas,A.iduser,
					B.saldo_bulan_berjalan, C.saldo_bulan_lalu, B.id, B.keterangan, B.filedata
					FROM
						mst_aruskas A
					LEFT JOIN (
						SELECT id, keterangan, filedata,
						id_aruskas,saldo_bulan_berjalan,id_bulan,iduser, tahun
						FROM bln_arus_kas
						WHERE  id_bulan = '".$id_bulan."'	
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_aruskas = B.id_aruskas

					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan as saldo_bulan_lalu,id_bulan,iduser,tahun
						FROM bln_arus_kas
						WHERE  id_bulan = '".$bln_lalu."'	
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) C ON A.id_aruskas = C.id_aruskas

					WHERE A.jenis_kas ='".$p1."'
					AND A.iduser = '".$iduser."'
				";

				// echo $sql; exit;
			break;
			case 'jenis_aktivitas':
				// konsisi bulan lalu
				if($id_bulan == 1){
					if($id_bulan == 1 and $tahun == 2020){
						$bln_lalu = $id_bulan -1;
						$tahun_lalu = $tahun;
					}else{	
						$bln_lalu = 12;
						$tahun_lalu = $tahun - 1;
					}
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql = "
					SELECT
					A.jenis_kas,A.arus_kas, 
					-- COALESCE(SUM(B.saldo_bulan_berjalan), 0) as sum_bulan_berjalan,
					-- COALESCE(SUM(C.saldo_bulan_berjalan), 0) as sum_bulan_lalu
					SUM(IF(A.flag = 'plus', B.saldo_bulan_berjalan,0)) as saldo_bulan_berjalan,
					SUM(IF(A.flag = 'plus', C.saldo_bulan_berjalan,0)) as sum_bulan_lalu,
					SUM(IF(A.flag = 'min', B.saldo_bulan_berjalan,0)) as saldo_bulan_berjalan_min,
					SUM(IF(A.flag = 'min', C.saldo_bulan_berjalan,0)) as sum_bulan_lalu_min,
					(SUM(IF(A.flag = 'plus', B.saldo_bulan_berjalan,0)) - SUM(IF(A.flag = 'min', B.saldo_bulan_berjalan,0))) as sum,
					(SUM(IF(A.flag = 'plus', C.saldo_bulan_berjalan,0)) - SUM(IF(A.flag = 'min', C.saldo_bulan_berjalan,0))) as sumprev
					FROM mst_aruskas A
					LEFT JOIN (
						SELECT
						id_aruskas,id_bulan,iduser,saldo_bulan_berjalan,tahun
						FROM
						bln_arus_kas
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_aruskas = B.id_aruskas

					LEFT JOIN (
						SELECT
						id_aruskas,id_bulan,iduser,saldo_bulan_berjalan,tahun
						FROM
						bln_arus_kas
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) C ON A.id_aruskas = C.id_aruskas

					WHERE A.iduser = '".$iduser."'
					GROUP BY A.jenis_kas

				";
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
				// konsisi bulan lalu
				if($id_bulan == 1){
					if($id_bulan == 1 and $tahun == 2020){
						$bln_lalu = $id_bulan -1;
						$tahun_lalu = $tahun;
					}else{	
						$bln_lalu = 12;
						$tahun_lalu = $tahun - 1;
					}
				}
				else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql = "
					SELECT
					A.id_aruskas, A.jenis_kas,A.arus_kas,
					B.saldo_bulan_berjalan, C.saldo_bulan_lalu
					FROM
						mst_aruskas A
					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan,id_bulan,iduser, tahun
						FROM bln_arus_kas
						WHERE  id_bulan = '".$id_bulan."'
						AND id_aruskas ='".$p1."'	
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_aruskas = B.id_aruskas

					LEFT JOIN (
						SELECT id_aruskas,saldo_bulan_berjalan as saldo_bulan_lalu,id_bulan,iduser, tahun
						FROM bln_arus_kas
						WHERE  id_bulan = '".$bln_lalu."'	
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) C ON A.id_aruskas = C.id_aruskas

					WHERE A.id_aruskas ='".$p1."'	
					AND A.iduser = '".$iduser."'
			
				";
				// echo $sql;exit;
			break;

			

			case 'cek_aset_investasi':
				$id_bulan=$this->session->userdata('id_bulan');
				$sql = "
					SELECT count(*) as total, A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head,B.id, B.tahun
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

			case 'kas_bank':
				// konsisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan - 1;
					$tahun_lalu = $tahun;
				}
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.`group`, 
					COALESCE(B.saldo_akhir, 0) as saldo_akhir, COALESCE(B.saldo_awal, 0) as saldo_awal,
					COALESCE(C.saldo_akhir, 0) as saldo_akhir_bln_lalu, COALESCE(C.saldo_awal, 0) as saldo_awal_bln_lalu
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."' 
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					)B ON A.id_investasi=B.id_investasi
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."' 
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					)C ON A.id_investasi=C.id_investasi
					$where2
					AND A.`group`='BUKAN INVESTASI'
					AND A.jenis_investasi ='Kas & Bank'
				";
				// echo $sql;exit;
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