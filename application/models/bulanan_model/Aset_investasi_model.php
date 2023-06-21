<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aset_investasi_model extends CI_Model {
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
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$response = false;
		$query = $this->db->get_where('ket_lap_bulanan',array('id' => $id,'iduser' => $iduser,'tahun' => $tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function get_by_id_jenis($id){
		$tahun = $this->session->userdata('tahun');
		$iduser = $this->session->userdata('iduser');
		$response = false;
		$query = $this->db->get_where('bln_aset_investasi_header',array('id' => $id,'iduser' => $iduser,'tahun' => $tahun));
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
			case "aset_investasi":
			case 'bukan_investasi':
				// $data = escape($data);
				
				$table_data = "bln_aset_investasi_header";

				
				if($sts_crud == "add" || $sts_crud == "edit"){
					$id_bulan = $data['id_bulan'];


					if($table == "aset_investasi"  || $table == "hasil_investasi" || $table == "bukan_investasi"){
						$data['rka'] = str_replace('.', '', escape($data['rka']));
					}

					$data['saldo_awal_invest'] = str_replace('.', '', escape($data['saldo_awal_invest']));
					$data['mutasi_invest'] = str_replace('.', '', escape($data['mutasi_invest']));
					$data['saldo_akhir_invest'] = str_replace('.', '', escape($data['saldo_akhir_invest']));

					if($table == "aset_investasi" || $table == "bukan_investasi"){
						$jns_form = $data['jns_form'];


						$nama_pihak = ( isset( $data['nama_pihak']) ?  $data['nama_pihak'] : array() );
						$saldo_awal = ( isset( $data['saldo_awal']) ?  $data['saldo_awal'] : array() ); 
						$mutasi_penanaman = ( isset( $data['mutasi_penanaman']) ?  $data['mutasi_penanaman'] : array() ); 
						$mutasi_pencairan = ( isset( $data['mutasi_pencairan']) ?  $data['mutasi_pencairan'] : array() ); 
						$mutasi_nilai_wajar = ( isset( $data['mutasi_nilai_wajar']) ?  $data['mutasi_nilai_wajar'] : array() ); 
						$mutasi_diskonto = ( isset( $data['mutasi_diskonto']) ?  $data['mutasi_diskonto'] : array() ); 
						$mutasi_pembelian = ( isset( $data['mutasi_pembelian']) ?  $data['mutasi_pembelian'] : array() ); 
						$mutasi_penjualan = ( isset( $data['mutasi_penjualan']) ?  $data['mutasi_penjualan'] : array() ); 
						$mutasi_amortisasi = ( isset( $data['mutasi_amortisasi']) ?  $data['mutasi_amortisasi'] : array() ); 
						$mutasi_pasar = ( isset( $data['mutasi_pasar']) ?  $data['mutasi_pasar'] : array() ); 
						$lembar_saham = ( isset( $data['lembar_saham']) ?  $data['lembar_saham'] : array() ); 
						$manager_investasi = ( isset( $data['manager_investasi']) ?  $data['manager_investasi'] : array() ); 
						$nama_reksadana = ( isset( $data['nama_reksadana']) ?  $data['nama_reksadana'] : array() ); 
						$jml_unit_reksadana = ( isset( $data['jml_unit_reksadana']) ?  $data['jml_unit_reksadana'] : array() ); 
						$harga_saham = ( isset( $data['harga_saham']) ?  $data['harga_saham'] : array() ); 
						$persentase = ( isset( $data['persentase']) ?  $data['persentase'] : array() ); 
						$saldo_akhir = ( isset( $data['saldo_akhir']) ?  $data['saldo_akhir'] : array() ); 
						$peringkat = ( isset( $data['peringkat']) ?  $data['peringkat'] : array() ); 
						$tgl_jatuh_tempo = ( isset( $data['tgl_jatuh_tempo']) ?  $data['tgl_jatuh_tempo'] : array() ); 
						$r_kupon = ( isset( $data['r_kupon']) ?  $data['r_kupon'] : array() ); 
						$nama_produk = ( isset( $data['nama_produk']) ?  $data['nama_produk'] : array() ); 
						$jml_unit_penyertaan = ( isset( $data['jml_unit_penyertaan']) ?  $data['jml_unit_penyertaan'] : array() ); 
						$no = ( isset( $data['no_urut']) ?  $data['no_urut'] : array() ); 
						$cabang = ( isset( $data['cabang']) ?  $data['cabang'] : array() ); 
						$bunga = ( isset( $data['bunga']) ?  $data['bunga'] : array() ); 
						$nilai_perolehan = ( isset( $data['nilai_perolehan']) ?  $data['nilai_perolehan'] : array() ); 
						$nilai_kapitalisasi_pasar = ( isset( $data['nilai_kapitalisasi_pasar']) ?  $data['nilai_kapitalisasi_pasar'] : array() ); 
						$nilai_dana_kelolaan = ( isset( $data['nilai_dana_kelolaan']) ?  $data['nilai_dana_kelolaan'] : array() ); 

						if(isset($data['nilai_kapitalisasi_pasar'])){
							unset($data['nilai_kapitalisasi_pasar']);
						}
						if(isset($data['nilai_dana_kelolaan'])){
							unset($data['nilai_dana_kelolaan']);
						}
						if(isset($data['nilai_perolehan'])){
							unset($data['nilai_perolehan']);
						}
						if(isset($data['cabang'])){
							unset($data['cabang']);
						}
						if(isset($data['bunga'])){
							unset($data['bunga']);
						}
						if(isset($data['mutasi_penanaman'])){
							unset($data['mutasi_penanaman']);
						}
						if(isset($data['mutasi_pencairan'])){
							unset($data['mutasi_pencairan']);
						}
						if(isset($data['mutasi_nilai_wajar'])){
							unset($data['mutasi_nilai_wajar']);
						}
						if(isset($data['mutasi_diskonto'])){
							unset($data['mutasi_diskonto']);
						}
						if(isset($data['peringkat'])){
							unset($data['peringkat']);
						}
						if(isset($data['tgl_jatuh_tempo'])){
							unset($data['tgl_jatuh_tempo']);
						}
						if(isset($data['r_kupon'])){
							unset($data['r_kupon']);
						}
						if(isset($data['nama_produk'])){
							unset($data['nama_produk']);
						}
						if(isset($data['jml_unit_penyertaan'])){
							unset($data['jml_unit_penyertaan']);
						}

						if(isset($data['nama_pihak'])){
							unset($data['nama_pihak']);
						}
						if(isset($data['saldo_awal'])){
							unset($data['saldo_awal']);
						}
						if(isset($data['mutasi_pembelian'])){
							unset($data['mutasi_pembelian']);
						}
						if(isset($data['mutasi_penjualan'])){
							unset($data['mutasi_penjualan']);
						}
						if(isset($data['saldo_akhir'])){
							unset($data['saldo_akhir']);
						}
						if(isset($data['no_urut'])){
							unset($data['no_urut']);
						}
						if(isset($data['mutasi_amortisasi'])){
							unset($data['mutasi_amortisasi']);
						}
						if(isset($data['mutasi_pasar'])){
							unset($data['mutasi_pasar']);
						}
						if(isset($data['lembar_saham'])){
							unset($data['lembar_saham']);
						}
						if(isset($data['manager_investasi'])){
							unset($data['manager_investasi']);
						}
						if(isset($data['nama_reksadana'])){
							unset($data['nama_reksadana']);
						}
						if(isset($data['jml_unit_reksadana'])){
							unset($data['jml_unit_reksadana']);
						}
						if(isset($data['harga_saham'])){
							unset($data['harga_saham']);
						}
						if(isset($data['persentase'])){
							unset($data['persentase']);
						}

					}
				
				}
				
				if($sts_crud == "delete" || $sts_crud == "edit"){
					$this->db->delete('bln_aset_investasi_detail', array('bln_aset_investasi_header_id'=>$id) );
				}
				if($sts_crud == "add" || $sts_crud == "edit"){

					if($table == "aset_investasi"  || $table == "bukan_investasi"){
						// print_r($data);exit;
						$tahun = $this->session->userdata('tahun');
						$level = $this->session->userdata('level');

						$path = $_FILES['filedata']['name']; // file means your input type file name
						$ext = pathinfo($path, PATHINFO_EXTENSION);

						if ($ext=="pdf" OR $ext=="doc" OR $ext=="docx" OR $ext=="") {
							$upload_path   = './files/file_bulanan/'.$table.'/'; //path folder
							$data['filedata_lama'] = escape($data['filedata_lama']);

							if(!empty($_FILES['filedata']['name'])){                  
								if(isset($data["filedata_lama"])){
									if($data["filedata_lama"] != ""){
										unlink($upload_path.$data["filedata_lama"]);
									}
								}

								$file_data = 'File_'.$data['id_investasi'].'_'.$id_bulan.'_'.$tahun.'_'.$level;
								$filename_data =  $this->lib->uploadnong($upload_path, 'filedata', $file_data);
							}else{
								$filename_data = (isset($data["filedata_lama"]) ? $data["filedata_lama"] : null );
							}

							$data["filedata"] = $filename_data;
							unset($data["filedata_lama"]);
							// unset($data["upload_path_lama"]);
						}else{
							return false;
						}

						
					}
				}
			break;

			case 'hasil_investasi':
				$table_data = "bln_aset_investasi_header";

				if($sts_crud == "add" || $sts_crud == "edit"){
					$data['saldo_awal_invest'] = str_replace('.', '', escape($data['saldo_awal_invest']));
					$data['mutasi_invest'] = str_replace('.', '', escape($data['mutasi_invest']));
					$data['saldo_akhir_invest'] = str_replace('.', '', escape($data['saldo_akhir_invest']));
					$data['rka'] = str_replace('.', '', escape($data['rka']));
					$data['target_yoi'] = str_replace(',', '.', escape($data['target_yoi']));
					// print_r($data);exit;
					$id_bulan = $data['id_bulan'];

					$tahun = $this->session->userdata('tahun');
					$level = $this->session->userdata('level');

						$path = $_FILES['filedata']['name']; // file means your input type file name
						$ext = pathinfo($path, PATHINFO_EXTENSION);

						if ($ext=="pdf" OR $ext=="doc" OR $ext=="docx" OR $ext=="") {
							$upload_path   = './files/file_bulanan/'.$table.'/'; //path folder
							$data['filedata_lama'] = escape($data['filedata_lama']);

							if(!empty($_FILES['filedata']['name'])){                  
								if(isset($data["filedata_lama"])){
									if($data["filedata_lama"] != ""){
										unlink($upload_path.$data["filedata_lama"]);
									}
								}

								$file_data = 'File_'.$data['id_investasi'].'_'.$id_bulan.'_'.$tahun.'_'.$level;
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

			case 'kewajiban':
				$iduser = $this->session->userdata('iduser');
				$tahun = $this->session->userdata('tahun');
				$level = $this->session->userdata('level');

				if($sts_crud == "add" || $sts_crud == "edit"){
					$id_bulan = $data['id_bulan'];

					$id_investasi = ( isset( $data['id_investasi']) ?  $data['id_investasi'] : array() );
					$saldo_akhir_invest = ( isset( $data['saldo_akhir_invest']) ?  $data['saldo_akhir_invest'] : array() );
					$rka = ( isset( $data['rka']) ?  $data['rka'] : array() );
					$keterangan = ( isset( $data['keterangan']) ?  $data['keterangan'] : array() ); 
					$filedata = ( isset( $data['filedata_lama']) ?  $data['filedata_lama'] : array() ); 

					if(isset($data['id_investasi'])){
						unset($data['id_investasi']);
					}
					if(isset($data['saldo_akhir_invest'])){
						unset($data['saldo_akhir_invest']);
					}
					if(isset($data['rka'])){
						unset($data['rka']);
					}
					if(isset($data['keterangan'])){
						unset($data['keterangan']);
					}
					if(isset($data['filedata'])){
						unset($data['filedata']);
					}


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

								$file_data = 'File_'.$id_investasi[$k].'_'.$id_bulan.'_'.$tahun.'_'.$level;

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

				if($sts_crud == "add" || $sts_crud == "edit"){
					if(isset($id_investasi)){
						foreach($id_investasi as $k => $v){
							$delete = $this->db->delete('bln_aset_investasi_header', array('id_investasi'=>$id_investasi[$k],'id_bulan'=>$id_bulan, 'iduser'=>$this->iduser, 'tahun'=>$this->tahun) );
							if($delete){
								$saldo_akhir_invest[$k] = str_replace('.', '', $saldo_akhir_invest[$k]);
								$rka[$k] = str_replace('.', '', $rka[$k]);

								$arr_kewajiban = array(
									'id_bulan' => $id_bulan,
									'iduser' => $this->iduser,
									'tahun' => $this->tahun,
									'id_investasi' => escape($id_investasi[$k]),
									'saldo_akhir_invest' => escape($saldo_akhir_invest[$k]),
									'rka' => escape($rka[$k]),
									'keterangan' => escape($keterangan[$k]),
									'filedata' => escape($name_data[$k]),
									'insert_at' => date('Y-m-d H:i:s'),
								);
								$this->db->insert('bln_aset_investasi_header', $arr_kewajiban);
							}
							
						}
					}
				}
			break;
			case 'iuran_beban':
				$iduser = $this->session->userdata('iduser');
				$tahun = $this->session->userdata('tahun');
				$level = $this->session->userdata('level');
				// echo "<pre>";
				// print_r($data);exit;
				if($sts_crud == "add" || $sts_crud == "edit"){
					$id_bulan = $data['id_bulan'];

					$id_investasi = ( isset( $data['id_investasi']) ?  $data['id_investasi'] : array() );
					$saldo_akhir = ( isset( $data['saldo_akhir']) ?  $data['saldo_akhir'] : array() );
					$rka = ( isset( $data['rka']) ?  $data['rka'] : array() );
					$keterangan = ( isset( $data['keterangan']) ?  $data['keterangan'] : array() ); 
					$filedata = ( isset( $data['filedata_lama']) ?  $data['filedata_lama'] : array() ); 

					if(isset($data['id_investasi'])){
						unset($data['id_investasi']);
					}
					if(isset($data['saldo_akhir'])){
						unset($data['saldo_akhir']);
					}
					if(isset($data['rka'])){
						unset($data['rka']);
					}
					if(isset($data['filedata'])){
						unset($data['filedata']);
					}
					if(isset($data['keterangan'])){
						unset($data['keterangan']);
					}


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

								$file_data = 'File_'.$id_investasi[$k].'_'.$id_bulan.'_'.$tahun.'_'.$level;

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

				if($sts_crud == "add" || $sts_crud == "edit"){
					if(isset($id_investasi)){
						foreach($id_investasi as $k => $v){
							$delete = $this->db->delete('bln_aset_investasi_header', array('id_investasi'=>$id_investasi[$k],'id_bulan'=>$id_bulan, 'iduser'=>$this->iduser, 'tahun'=>$this->tahun) );
							if($delete){
								$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
								$rka[$k] = str_replace('.', '', $rka[$k]);

								$arr_dt = array(
									'id_bulan' => $id_bulan,
									'iduser' => $this->iduser,
									'tahun' => $this->tahun,
									'id_investasi' => escape($id_investasi[$k]),
									'saldo_akhir_invest' => escape($saldo_akhir[$k]),
									'rka' => escape($rka[$k]),
									'keterangan' => escape($keterangan[$k]),
									'filedata' => escape($name_data[$k]),
									'insert_at' => date('Y-m-d H:i:s'),
								);
								$this->db->insert('bln_aset_investasi_header', $arr_dt);
							}
							
						}
					}
				}
			break;

			case 'beban_investasi':
				$iduser = $this->session->userdata('iduser');
				$tahun = $this->session->userdata('tahun');
				$level = $this->session->userdata('level');


				if($sts_crud == "add" || $sts_crud == "edit"){

					$id_bulan = $data['id_bulan'];

					$id_investasi = ( isset( $data['id_investasi']) ?  $data['id_investasi'] : array() );
					$saldo_akhir = ( isset( $data['saldo_akhir']) ?  $data['saldo_akhir'] : array() );
					$rka = ( isset( $data['rka']) ?  $data['rka'] : array() );
					$saldo_awal = ( isset( $data['saldo_awal']) ?  $data['saldo_awal'] : array() ); 
					$keterangan = ( isset( $data['keterangan']) ?  $data['keterangan'] : array() ); 
					$filedata = ( isset( $data['filedata_lama']) ?  $data['filedata_lama'] : array() ); 

					if(isset($data['id_investasi'])){
						unset($data['id_investasi']);
					}
					if(isset($data['saldo_akhir'])){
						unset($data['saldo_akhir']);
					}
					if(isset($data['rka'])){
						unset($data['rka']);
					}
					if(isset($data['saldo_awal'])){
						unset($data['saldo_awal']);
					}
					if(isset($data['filedata'])){
						unset($data['filedata']);
					}
					if(isset($data['keterangan'])){
						unset($data['keterangan']);
					}

					
					$sql_cek = "
						SELECT A.id_investasi as id, A.jenis_investasi as txt
						FROM  mst_investasi A 
						WHERE A.`group` = 'BEBAN'
						AND A.type_sub_jenis_investasi = 'P'
						AND A.iduser = '".$iduser."'
						AND  A.jenis_investasi= 'Beban Investasi'
						ORDER BY A. no_urut ASC
					";

					$cek = $this->db->query($sql_cek)->row_array();
					$id_cek = $cek['id'];
					$txt = $cek['txt'];
					// print_r($data);exit;

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

								$file_data = 'File_'.$id_investasi[$k].'_'.$id_bulan.'_'.$tahun.'_'.$level;

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

				if($sts_crud == "add" || $sts_crud == "edit"){
					if(isset($id_investasi)){
						foreach($id_investasi as $k => $v){
							$delete = $this->db->delete('bln_aset_investasi_header', array('id_investasi'=>$id_investasi[$k],'id_bulan'=>$id_bulan, 'iduser'=>$this->iduser, 'tahun'=>$this->tahun) );
							if($delete){
								$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
								$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
								$rka[$k] = str_replace('.', '', $rka[$k]);

								$arr_kewajiban = array(
									'id_bulan' => $id_bulan,
									'iduser' => $this->iduser,
									'tahun' => $this->tahun,
									'id_investasi' => escape($id_investasi[$k]),
									'saldo_akhir_invest' => escape($saldo_akhir[$k]),
									'saldo_awal_invest' => escape($saldo_awal[$k]),
									'rka' => escape($rka[$k]),
									'keterangan' => escape($keterangan[$k]),
									'filedata' => escape($name_data[$k]),
									'insert_at' => date('Y-m-d H:i:s'),
								);
								$this->db->insert('bln_aset_investasi_header', $arr_kewajiban);
							}
							
						}

						$sql_sum = "
							SELECT A.iduser, B.id_bulan,
							sum(B.saldo_awal) as saldo_awal, sum(B.mutasi) as mutasi, sum(B.rka) as rka, sum(B.realisasi_rka) as realisasi_rka, 
							sum(B.saldo_akhir) as saldo_akhir
							FROM mst_investasi A
							LEFT JOIN(
								SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, tahun,
								saldo_akhir_invest as saldo_akhir, id_bulan, iduser
								FROM bln_aset_investasi_header
								WHERE id_bulan = '".$id_bulan."'
								AND tahun = '".$tahun."'
								AND iduser = '".$iduser."'
							) B ON A.id_investasi = B.id_investasi
							WHERE A.`group` ='BEBAN INVESTASI'
							AND A.iduser = '".$iduser."'
							AND B.id_bulan = '".$id_bulan."'
							AND B.tahun = '".$tahun."'
						";

						$sum = $this->db->query($sql_sum)->row_array();
						
						$dt['saldo_awal_invest'] = $sum['saldo_awal'];
						$dt['saldo_akhir_invest'] = $sum['saldo_akhir'];
						$dt['rka'] = $sum['rka'];
						$dt['iduser'] = $sum['iduser'];
						$dt['id_bulan'] = $sum['id_bulan'];
						$dt['id_investasi'] = $id_cek;

						$sql_tot = "
							SELECT count(*) as total
							FROM mst_investasi A  
							LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
							WHERE  A.iduser = '".$iduser."'
							AND  A.id_investasi = '".$id_cek."' 
							AND  B.id_bulan = '".$id_bulan."' 
							AND  B.tahun = '".$tahun."' 
							ORDER BY A.id_investasi ASC
						";

						$tot = $this->db->query($sql_tot)->row_array();
						// print_r($dt);exit;

						if($tot['total'] != 0){
							$this->db->update('bln_aset_investasi_header', $dt, array('id_investasi' => $id_cek,'id_bulan' => $id_bulan,'iduser' => $iduser,'tahun' => $tahun) );
						}else{
							$this->db->insert('bln_aset_investasi_header', $dt);
						}
						
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
				if($table == 'hasil_investasi'){
					$insert = $this->db->insert($table_data,$data);
				}

				// ASET BUKAN INVESTASI
				if($table == 'bukan_investasi'){
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

					if($jns_form == 11){
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
										$mutasi_amortisasi[$k] = str_replace('.', '', $mutasi_amortisasi[$k]);
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
											'mutasi_amortisasi' => escape($mutasi_amortisasi[$k]),
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

				
				// ASET INVESTASI
				if($table == 'aset_investasi'){
					if($jns_form == 1){
						unset($data['jns_form']);

						$insert = $this->db->insert($table_data,$data);
						$id = $this->db->insert_id();

						if($insert){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_penanaman[$k] = str_replace('.', '', $mutasi_penanaman[$k]);
										$mutasi_pencairan[$k] = str_replace('.', '', $mutasi_pencairan[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$bunga[$k] = str_replace(',', '.', $bunga[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'cabang' => escape($cabang[$k]),
											'bunga' => escape($bunga[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_penanaman' => escape($mutasi_penanaman[$k]),
											'mutasi_pencairan' => escape($mutasi_pencairan[$k]),
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

					if($jns_form == 2){
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
										$mutasi_amortisasi[$k] = str_replace('.', '', $mutasi_amortisasi[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_amortisasi' => escape($mutasi_amortisasi[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
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

					if($jns_form == 3){
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
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$nilai_perolehan[$k] = str_replace(',', '', $nilai_perolehan[$k]);
										$nilai_kapitalisasi_pasar[$k] = str_replace('.', '', $nilai_kapitalisasi_pasar[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nilai_perolehan' => escape($nilai_perolehan[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'lembar_saham' => escape($lembar_saham[$k]),
											'no_urut' => escape($no[$k]),
											'nilai_kapitalisasi_pasar' => escape($nilai_kapitalisasi_pasar[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
					}
					
					if($jns_form == 4){
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
										$mutasi_diskonto[$k] = str_replace('.', '', $mutasi_diskonto[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$nilai_perolehan[$k] = str_replace('.', '', $nilai_perolehan[$k]);
										$nilai_dana_kelolaan[$k] = str_replace('.', '', $nilai_dana_kelolaan[$k]);
										$jml_unit_penyertaan[$k] = str_replace('.', '', $jml_unit_penyertaan[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'nilai_perolehan' =>  escape($nilai_perolehan[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_diskonto' => escape($mutasi_diskonto[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'jml_unit_penyertaan' => escape($jml_unit_penyertaan[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'no_urut' => escape($no[$k]),
											'nilai_dana_kelolaan' => escape($nilai_dana_kelolaan[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
					}

					if($jns_form == 5){
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
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$harga_saham[$k] = str_replace(',', '', $harga_saham[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$persentase[$k] = str_replace(',', '.', $persentase[$k]);


										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'lembar_saham' => escape($lembar_saham[$k]),
											'harga_saham' => escape($harga_saham[$k]),
											'persentase' => escape($persentase[$k]),
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

					if($jns_form == 6){
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
										$mutasi_nilai_wajar[$k] = str_replace('.', '', $mutasi_nilai_wajar[$k]);
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
											'mutasi_nilai_wajar' => escape($mutasi_nilai_wajar[$k]),
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

					if($jns_form == 7){
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
										$mutasi_amortisasi[$k] = str_replace('.', '', $mutasi_amortisasi[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);


										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_amortisasi' => escape($mutasi_amortisasi[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'peringkat' => escape($peringkat[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
											'no_urut' => escape($no[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
						
					}


					if($jns_form == 8){
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
										$mutasi_diskonto[$k] = str_replace('.', '', $mutasi_diskonto[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);


										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_diskonto' => escape($mutasi_diskonto[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'peringkat' => escape($peringkat[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
											'no_urut' => escape($no[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
						
					}


					if($jns_form == 9){
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
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);


										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'peringkat' => escape($peringkat[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
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

				if($table == 'hasil_investasi'){
					$update = $this->db->update($table_data, $data, array('id' => $id) );
				}

				// ASET BUKAN INVESTASI
				if($table == 'bukan_investasi'){
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

					if($jns_form == 11){
						unset($data['jns_form']);

						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_amortisasi[$k] = str_replace('.', '', $mutasi_amortisasi[$k]);
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
											'mutasi_amortisasi' => escape($mutasi_amortisasi[$k]),
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

				if($table == 'aset_investasi'){
					if($jns_form == 1){
						unset($data['jns_form']);
						
						$update = $this->db->update($table_data, $data, array('id' => $id) );	

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_penanaman[$k] = str_replace('.', '', $mutasi_penanaman[$k]);
										$mutasi_pencairan[$k] = str_replace('.', '', $mutasi_pencairan[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$bunga[$k] = str_replace(',', '.', $bunga[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'cabang' => escape($cabang[$k]),
											'bunga' => escape($bunga[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_penanaman' => escape($mutasi_penanaman[$k]),
											'mutasi_pencairan' => escape($mutasi_pencairan[$k]),
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

					if($jns_form == 2){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_amortisasi[$k] = str_replace('.', '', $mutasi_amortisasi[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_amortisasi' => escape($mutasi_amortisasi[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
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

					if($jns_form == 3){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$nilai_perolehan[$k] = str_replace(',', '', $nilai_perolehan[$k]);
										$nilai_kapitalisasi_pasar[$k] = str_replace('.', '', $nilai_kapitalisasi_pasar[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nilai_perolehan' => escape($nilai_perolehan[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'lembar_saham' => escape($lembar_saham[$k]),
											'no_urut' => escape($no[$k]),
											'nilai_kapitalisasi_pasar' => escape($nilai_kapitalisasi_pasar[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
					}
					
					if($jns_form == 4){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_diskonto[$k] = str_replace('.', '', $mutasi_diskonto[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$nilai_perolehan[$k] = str_replace('.', '', $nilai_perolehan[$k]);
										$nilai_dana_kelolaan[$k] = str_replace('.', '', $nilai_dana_kelolaan[$k]);
										$jml_unit_penyertaan[$k] = str_replace('.', '', $jml_unit_penyertaan[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_diskonto' => escape($mutasi_diskonto[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'jml_unit_penyertaan' => escape($jml_unit_penyertaan[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'nilai_perolehan' =>  escape($nilai_perolehan[$k]),
											'no_urut' => escape($no[$k]),
											'nilai_dana_kelolaan' => escape($nilai_dana_kelolaan[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
					}

					if($jns_form == 5){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$harga_saham[$k] = str_replace(',', '', $harga_saham[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$persentase[$k] = str_replace(',', '.', $persentase[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'lembar_saham' => escape($lembar_saham[$k]),
											'harga_saham' => escape($harga_saham[$k]),
											'persentase' => escape($persentase[$k]),
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
					
					if($jns_form == 6){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );;

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_nilai_wajar[$k] = str_replace('.', '', $mutasi_nilai_wajar[$k]);
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
											'mutasi_nilai_wajar' => escape($mutasi_nilai_wajar[$k]),
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

					if($jns_form == 7){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_amortisasi[$k] = str_replace('.', '', $mutasi_amortisasi[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$peringkat[$k] = str_replace('.', '', $peringkat[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);


										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_amortisasi' => escape($mutasi_amortisasi[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'peringkat' => escape($peringkat[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
											'no_urut' => escape($no[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
						
					}


					if($jns_form == 8){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_diskonto[$k] = str_replace('.', '', $mutasi_diskonto[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$peringkat[$k] = str_replace('.', '', $peringkat[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);


										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_diskonto' => escape($mutasi_diskonto[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'peringkat' => escape($peringkat[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
											'no_urut' => escape($no[$k]),
											'insert_at' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
									}
								}

							}

						}
						
					}

					if($jns_form == 9){
						unset($data['jns_form']);
						$update = $this->db->update($table_data, $data, array('id' => $id) );

						if($update){
							if($table_data == "bln_aset_investasi_header"){
								if(isset($nama_pihak)){
									foreach($nama_pihak as $k => $v){
										$saldo_awal[$k] = str_replace('.', '', $saldo_awal[$k]);
										$mutasi_pembelian[$k] = str_replace('.', '', $mutasi_pembelian[$k]);
										$mutasi_penjualan[$k] = str_replace('.', '', $mutasi_penjualan[$k]);
										$mutasi_pasar[$k] = str_replace('.', '', $mutasi_pasar[$k]);
										$saldo_akhir[$k] = str_replace('.', '', $saldo_akhir[$k]);
										$r_kupon[$k] = str_replace(',', '.', $r_kupon[$k]);
										$tgl_jatuh_tempo[$k] = tgl_format_default($tgl_jatuh_tempo[$k]);

										$arr_detail_investasi = array(
											'bln_aset_investasi_header_id' => $id,
											'id_bulan' => $id_bulan,
											'iduser' => $this->iduser,
											'tahun' => $this->tahun,
											'kode_pihak' => escape($nama_pihak[$k]),
											'nama_reksadana' =>  escape($nama_reksadana[$k]),
											'saldo_awal' => escape($saldo_awal[$k]),
											'mutasi_pembelian' => escape($mutasi_pembelian[$k]),
											'mutasi_penjualan' => escape($mutasi_penjualan[$k]),
											'mutasi_pasar' => escape($mutasi_pasar[$k]),
											'saldo_akhir' => escape($saldo_akhir[$k]),
											'peringkat' => escape($peringkat[$k]),
											'tgl_jatuh_tempo' => escape($tgl_jatuh_tempo[$k]),
											'r_kupon' => escape($r_kupon[$k]),
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
			// untuk index aset investasi dan aset bukan Investasi bulan lalu
			case 'aset_investasi_front_lalu':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan - 1;
					$tahun_lalu = $tahun;
				}
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser, B.id_bulan, A.type_sub_jenis_investasi as type, 
					B.saldo_awal, B.mutasi, B.rka, B.realisasi_rka, B.saldo_akhir,B.id, B.filedata
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) B ON A.id_investasi = B.id_investasi
					WHERE A.`group` ='".$p1."'
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'P' OR A.type_sub_jenis_investasi = 'C')
					AND B.id IS NOT NULL
					ORDER BY A.no_urut ASC

				";
				// echo $sql;exit;
			break;

			case 'aset_investasi_detail_lalu':
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.saldo_awal, B.mutasi, B.rka, B.realisasi_rka, B.saldo_akhir,B.id, B.filedata
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					WHERE A.`group` ='".$p1."'
					AND A.iduser = '".$iduser."'
					AND (A.type_sub_jenis_investasi = 'P' OR A.type_sub_jenis_investasi = 'C')
					AND B.id IS NOT NULL
					ORDER BY A.no_urut ASC

				";
			break;
			

			// untuk index aset investasi dan aset bukan Investasi
			case 'aset_investasi_front':
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.jns_form, A.iduser,A.type_sub_jenis_investasi as type, 
					B.saldo_awal, B.mutasi, B.rka, B.realisasi_rka, B.saldo_akhir,B.id, B.filedata, B.target_yoi
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, target_yoi
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
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
					sum(B.saldo_akhir) as saldo_akhir, A.id_investasi as parent_id, C.parent_investasi as jenis_investasi, C.type, B.id, B.filedata, B.target_yoi
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, target_yoi
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
					B.saldo_awal, B.mutasi, B.rka, B.realisasi_rka, B.saldo_akhir, B.id, B.filedata, B.target_yoi
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser, target_yoi
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
					SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, tahun,
					saldo_akhir_invest as saldo_akhir, id_bulan, iduser
					FROM bln_aset_investasi_header
					WHERE id_bulan = '".$id_bulan."'
					AND iduser = '".$iduser."'
					AND tahun = '".$tahun."'
				) B ON A.id_investasi = B.id_investasi
				WHERE A.`group` ='".$p1."'
				AND A.iduser = '".$iduser."'
				AND B.id_bulan = '".$id_bulan."'
				AND B.tahun = '".$tahun."'
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
			case 'yoi_hasil_investasi':
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.`group`, 
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir end), 0) as saldo_akhir,
					COALESCE(B.rka, 0) as rka
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					)B ON A.id_investasi=B.id_investasi
					$where2
					AND A.`group`='HASIL INVESTASI'

				";
				// echo $sql;exit();
			break;
			case 'yoi_investasi':
				
				$sql="
					SELECT
					A.id_bulan,
					A.tahun,
					B.`group`,
					COALESCE(sum(A.saldo_akhir_invest), 0) as saldo_akhir,
					COALESCE(A.rka, 0) as rka,
					COALESCE(sum(A.mutasi_invest), 0) as mutasi,
					A.iduser
					FROM
					bln_aset_investasi_header A
					LEFT JOIN mst_investasi B ON A.id_investasi = B.id_investasi
					WHERE A.iduser = '".$iduser."'
					AND A.tahun = '".$tahun."'
					AND B.`group` = 'INVESTASI'
					AND A.id_bulan BETWEEN 1 AND '".$id_bulan."'
					GROUP BY A.id_bulan
				";
				// echo $sql;exit();
			break;

			case 'aset_investasi_cek_id':
				$iduser = $this->input->post('iduser');
				$id_bulan = $this->input->post('id_bulan');
				$id_investasi = $this->input->post('id_investasi');
				$jns_form = $this->input->post('jns_form');
				$sql="
					SELECT A.id, A.id_investasi, A.id_bulan, A.iduser, B.jns_form, A.tahun
					FROM bln_aset_investasi_header A 
					LEFT JOIN mst_investasi B ON A.id_investasi=B.id_investasi
					WHERE A.id_investasi = '".$id_investasi."'
					AND A.id_bulan = '".$id_bulan."'
					AND A.tahun = '".$tahun."'
					AND B.jns_form = '".$jns_form."'
					AND A.iduser = '".$iduser."'
				";
			break;
			case 'data_header_beban_investasi':
				$sql="
					SELECT A.id_investasi as id, A.jenis_investasi as txt
					FROM mst_investasi A 
					$where2
					AND A.`group` = 'BEBAN INVESTASI'
					AND A.type_sub_jenis_investasi = 'PC'
					AND A.id_investasi = '".$p1."'
					ORDER BY A. no_urut ASC
				";
			break;
			case 'data_detail_beban_investasi':
				$sql="
					SELECT A.id_investasi, A.jenis_investasi, B.saldo_awal_invest as saldo_awal, B.saldo_akhir_invest as saldo_akhir, B.rka, B.filedata, B.id, B.id_bulan, B.keterangan
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id, id_investasi, saldo_awal_invest, tahun,
						saldo_akhir_invest, rka, id_bulan, iduser,filedata, keterangan
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser =  '".$iduser."'
						AND tahun =  '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					$where2
					AND A.`group` = 'BEBAN INVESTASI'
					AND A.type_sub_jenis_investasi = 'C'
					AND A.parent_id = '".$p1."'
					ORDER BY A. no_urut ASC
				";
				// echo $sql;exit;
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
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan - 1;
					$tahun_lalu = $tahun;
				}
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.`group`,
					B.id_bulan, B.saldo_akhir,B.rka, C.rka as rka_bln_lalu,
					B.id, B.keterangan, B.filedata
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id_investasi, id, keterangan, filedata, tahun,
						saldo_akhir_invest as saldo_akhir, rka, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser =  '".$iduser."'
						AND tahun =  '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id_investasi, tahun,
						saldo_akhir_invest as saldo_akhir, rka, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser =  '".$iduser."'
						AND tahun =  '".$tahun."'
					) C ON A.id_investasi = C.id_investasi
					WHERE 1=1
					AND A.`group`='KEWAJIBAN'
					AND A.iduser = '".$iduser."'
					ORDER BY A.no_urut ASC
				";
				// echo $sql;exit;
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
			case 'mst_jenis_investasi_iuran_beban':
				$sql = "
					SELECT A.id_investasi as id, A.jenis_investasi as txt
					FROM mst_investasi A  
					$where2
					AND A.group = '".$p1."'
					AND NOT A.type_sub_jenis_investasi ='PC'
				";
				// echo $sql;exit;
			break;
			case 'data_bulan_lalu_hasilinvest':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql = "
					SELECT A.saldo_akhir_invest as saldo_bln_lalu, A.rka, A.tahun
					FROM bln_aset_investasi_header A
					$where2
					AND A.id_bulan = '".$bln_lalu."' 
					AND A.tahun = '".$tahun_lalu."' 
					AND A.id_investasi = '".$p1."'
				";
				// echo $sql;exit;
			break;
			case 'data_bulan_lalu_form':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi, B.tahun,
					C.id as id_detail, C.bln_aset_investasi_header_id, C.iduser, C.id_bulan, C.kode_pihak, C.saldo_awal,
					C.mutasi_pembelian, C.mutasi_penjualan, C.mutasi_amortisasi, C.mutasi_pasar, C.saldo_akhir, C.lembar_saham,
					C.manager_investasi, C.nama_reksadana, C.jml_unit_reksadana, C.harga_saham, C.persentase, 
					C.mutasi_penanaman, C.mutasi_pencairan, C.mutasi_nilai_wajar, C.mutasi_diskonto, C.peringkat, 
					DATE_FORMAT(C.tgl_jatuh_tempo, '%d-%m-%Y') as tgl_jatuh_tempo, C.nilai_kapitalisasi_pasar, C.nilai_dana_kelolaan,
					C.r_kupon, C.nama_produk,C.jml_unit_penyertaan,C.cabang, C.bunga, C.nilai_perolehan,
					C.no_urut, D.nama_pihak, E.nama_cabang
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					LEFT JOIN bln_aset_investasi_detail C  on C.bln_aset_investasi_header_id = B.id
					LEFT JOIN mst_pihak D ON D.kode_pihak = C.kode_pihak
					LEFT JOIN mst_cabang E ON E.id_cabang = C.cabang
					$where
					AND B.id_investasi = '".$p1."' 
					AND A.jns_form = '".$p2."' 
					AND B.id_bulan = '".$bln_lalu."' 
					AND B.tahun = '".$tahun_lalu."' 
					AND C.bln_aset_investasi_header_id  IS NOT NULL
					ORDER BY C.no_urut ASC
				";

				// echo $sql;exit;
			break;

			case 'data_aset_investasi':
				$sql = "
					SELECT A.iduser, A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head, B.tahun,
					B.saldo_awal_invest, B.mutasi_invest, B.saldo_akhir_invest, B.rka, B.realisasi_rka , B.id, B.filedata, B.keterangan
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
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi as id_invesatasi_head, B.tahun, 
					C.id as id_detail, C.bln_aset_investasi_header_id, C.iduser, C.id_bulan, C.kode_pihak, C.saldo_awal,
					C.mutasi_pembelian, C.mutasi_penjualan, C.mutasi_amortisasi, C.mutasi_pasar, C.saldo_akhir, C.lembar_saham,
					C.manager_investasi, C.nama_reksadana, C.jml_unit_reksadana, C.harga_saham, C.persentase, 
					C.mutasi_penanaman, C.mutasi_pencairan, C.mutasi_nilai_wajar, C.mutasi_diskonto, C.peringkat, C.tgl_jatuh_tempo,
					C.r_kupon, C.nama_produk,C.jml_unit_penyertaan,C.cabang, C.bunga, C.nilai_perolehan,
					C.no_urut, C.nilai_kapitalisasi_pasar, C.nilai_dana_kelolaan,
					D.nama_pihak, E.nama_cabang, B.filedata
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					LEFT JOIN bln_aset_investasi_detail C  on C.bln_aset_investasi_header_id = B.id
					LEFT JOIN mst_pihak D ON D.kode_pihak = C.kode_pihak
					LEFT JOIN mst_cabang E ON E.id_cabang = C.cabang
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
					B.saldo_awal_invest, B.mutasi_invest, B.saldo_akhir_invest, B.rka, B.realisasi_rka , B.id, B.filedata, B.keterangan, B.tahun, B.target_yoi
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
					SELECT count(*) as total, A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head,B.id, B.rka, B.tahun
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					$where
					AND A.id_investasi = '".$p1."' 
					AND B.id_bulan = '".$id_bulan."' 
					AND B.tahun = '".$tahun."' 
					ORDER BY A.id_investasi ASC
				";

				// echo $sql;exit;
			break;
			case 'dana_bersih_lv0':
				// kondisi setelah bulan januari
				// kondisi bulan lalu
				// 151428469320652 nilai default taspen
				// 0 nilai default asabri
				// * angka diatas bisa berubah sesuai ketentuan
				// kurang kolom tahun nanti bisa ditambahkan ketika ada tambahan field tahun.
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql="
					SELECT A.*, B.id_investasi,B.iduser, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir,
					COALESCE (
								(
									CASE
									WHEN C.id_bulan = '1'
									AND B.iduser = 'TSN002'
									AND C.tahun = '2020'
									AND A.uraian = 'ASET INVESTASI' THEN
										151428469320652

									WHEN C.id_bulan = '1'
									AND B.iduser = 'ASB003'
									AND C.tahun = '2020'
									AND A.uraian = 'ASET INVESTASI' THEN
										17669911410364
									ELSE
										SUM(D.saldo_akhir)
									END
								),
								0
							) AS saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi


					WHERE B.iduser = '".$iduser."'
					GROUP BY A.jenis_laporan
				";
				// echo $sql;exit();
			break;
			case 'dana_bersih_lv1':
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
					SELECT A.*, B.id_investasi,B.iduser, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi


					WHERE B.iduser = '".$iduser."'
					GROUP BY A.jenis_laporan
				";
			break;

			case 'dana_bersih_lv2':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql="
					SELECT A.*, B.id_investasi,B.iduser, C.id_bulan, 
					COALESCE(SUM(C.saldo_akhir), 0) as saldo_akhir,
					COALESCE(SUM(D.saldo_akhir), 0) as saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND A. jenis_laporan = '".$p1."'
					GROUP BY A.uraian
					ORDER BY A.id_dana_bersih ASC
				";

				// echo $sql;exit;
			break;

			case 'dana_bersih_lv3':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.type_sub_jenis_investasi, C.id_bulan, C.saldo_akhir, 
					D.saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_bln_lalu, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser ='".$iduser."'
					AND A.id_dana_bersih ='".$p1."'
					AND (B.type_sub_jenis_investasi ='P' OR B.type_sub_jenis_investasi ='PC')
					ORDER BY B.no_urut, A.id_dana_bersih ASC
				";


				// echo $sql;exit;
			break;
			case 'dana_bersih_lv4':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.type_sub_jenis_investasi, C.id_bulan, C.saldo_akhir,
					D.saldo_akhir_bln_lalu
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_bln_lalu, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND B.parent_id ='".$p1."'
					AND B.type_sub_jenis_investasi ='".$p2."'
					ORDER BY B.no_urut, A.id_dana_bersih ASC
				";

				// echo $sql;exit;
			break;
	

			case 'perubahan_danabersih_lv1':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir,
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir end), 0) as saldo_akhir_bln_lalu
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, mutasi_invest as mutasi, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, mutasi_invest as mutasi, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					GROUP BY A.uraian
				";
				// echo $sql;exit;
			break;

			case 'perubahan_danabersih_lv2':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir,
					COALESCE(SUM(CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir end), 0) as saldo_akhir_bln_lalu
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, mutasi_invest as mutasi, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, mutasi_invest as mutasi, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND A.uraian ='".$p1."'
					GROUP BY B.group
					ORDER BY B.no_urut_group ASC
				";
				 // echo $sql;exit;
			break;

			case 'perubahan_danabersih_lv3':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, 
					COALESCE((CASE WHEN B.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir,
					COALESCE((CASE WHEN B.group = 'HASIL INVESTASI' THEN D.mutasi else D.saldo_akhir_bln_lalu end), 0) as saldo_akhir_bln_lalu
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, mutasi_invest as mutasi, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_bln_lalu, mutasi_invest as mutasi, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND (B.type_sub_jenis_investasi ='P' OR B.type_sub_jenis_investasi ='PC')
					AND B.group = '".$p1."'
					ORDER BY B.no_urut ASC
				";
			break;

			case 'perubahan_danabersih_lv4':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql ="
					SELECT A.*, B.id_investasi, B.jenis_investasi, B.iduser, B.group, B.parent_id, 
					B.type_sub_jenis_investasi as type, C.saldo_akhir, D.saldo_akhir_bln_lalu
					FROM mst_perubahan_danabersih A
					LEFT JOIN mst_investasi B ON A.id_perubahan_dana_bersih = B.id_perubahan_dana_bersih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_bln_lalu, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) D ON B.id_investasi = D.id_investasi

					WHERE B.iduser = '".$iduser."'
					AND B.parent_id ='".$p1."'
					AND B.type_sub_jenis_investasi ='".$p2."'
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
					ORDER BY B.no_urut_group ASC
				";
			break;


			case 'data_perubahan_danabersih_header':
				// kondisi bulan lalu
				if($id_bulan == 1){
					$bln_lalu = 12;
					$tahun_lalu = $tahun - 1;
				}else{
					$bln_lalu = $id_bulan -1;
					$tahun_lalu = $tahun;
				}
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.group, A.no_urut_group,
					B.id_bulan, B.saldo_akhir, C.rka as rka_bln_lalu, B.rka,
					B.id, B.keterangan, B.filedata
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id_investasi, id, keterangan, filedata,
						saldo_akhir_invest as saldo_akhir, rka, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser =  '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					LEFT JOIN(
						SELECT id_investasi,
						saldo_akhir_invest as saldo_akhir, rka, id_bulan, tahun, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$bln_lalu."'
						AND iduser =  '".$iduser."'
						AND tahun = '".$tahun_lalu."'
					) C ON A.id_investasi = C.id_investasi
					WHERE 1=1
					AND NOT A.type_sub_jenis_investasi ='PC'
					AND A.`group`= '".$p1."'
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