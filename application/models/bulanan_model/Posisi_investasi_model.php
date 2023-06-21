<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posisi_investasi_model extends CI_Model {
	private $table;
	function __construct(){
      parent::__construct();
      $this->tahun = $this->session->userdata('tahun');
      $this->bulan = $this->session->userdata('id_bulan');
      $this->semester = $this->session->userdata('semester');
		$this->table = 'dbsmartaip_'.$this->tahun.'.bln_posisi_investasi';

		if($this->session->userdata('level') === "DJA"){
			$this->iduser = $this->session->userdata('cari');
		}else{
			$this->iduser = $this->session->userdata('iduser');
		}
	}
	
	public function get_all($limit_offset = array()){
		if(!empty($limit_offset)){
			$this->db->order_by('id', 'DESC');
			$query = $this->db->order_by("id_bulan","tahun","id_investasi", "ASC")->join('dbsmartaip_'.$this->tahun.'.mst_jenis_investasi', 'dbsmartaip_'.$this->tahun.'.mst_jenis_investasi.id_investasi = dbsmartaip_'.$this->tahun.'.bln_posisi_investasi.id_investasi')->get('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi',$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->order_by("id_bulan","tahun","id_investasi", "ASC")->join('dbsmartaip_'.$this->tahun.'.mst_jenis_investasi', 'dbsmartaip_'.$this->tahun.'.mst_jenis_investasi.id_investasi = dbsmartaip_'.$this->tahun.'.bln_posisi_investasi.id_investasi')->get('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi');
		}
		return $query->result();
	}

	public function get_all_jenis($limit_offset = array()){
		if(!empty($limit_offset)){
			$this->db->order_by('id_investasi', 'DESC');
			$query = $this->db->get('dbsmartaip_'.$this->tahun.'.mst_jenis_investasi',$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get('dbsmartaip_'.$this->tahun.'.mst_jenis_investasi');
		}
		return $query->result();
	}


	public function count_total(){
		$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi');
		return $query->num_rows();
	}

// data 
	public function get_sum_hasil_invest() {
		$semester = $this->session->userdata('semester');
		if ($semester == 1){
			$bln='BETWEEN 1 and 6';
		}elseif($semester == 2){
			$bln='BETWEEN 7 and 12';
		}
		$query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.saldo_awal) as saldo_awal,sum(a.saldo_akhir) as saldo_akhir,sum(a.rka) as rka FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (select id_investasi from mst_jenis_investasi) AND iduser='".$this->iduser."' AND a.id_bulan ".$bln." group by a.id_investasi");
		// echo $this->db->last_query();exit;
		return $query->result();
	}

	public function get_sum_hasil_invest_sm2() {
		$query = $this->db->query("SELECT a.id,a.id_investasi, b.jenis_investasi ,sum(a.saldo_awal) as saldo_awal,sum(a.saldo_akhir) as saldo_akhir,sum(a.rka) as rka FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (select id_investasi from mst_jenis_investasi) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 7 and 12 group by a.id_investasi");
		return $query->result();
	}

	public function get_sum_hasil_invest_th() {
		$query = $this->db->query("SELECT a.id,a.id_investasi, b.jenis_investasi ,sum(a.saldo_awal) as saldo_awal,sum(a.saldo_akhir) as saldo_akhir,sum(a.rka) as rka FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (select id_investasi from mst_jenis_investasi) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 12 group by a.id_investasi");
		return $query->result();
	}

	public function get_all_array($filter = false){
		if(!empty($filter)) {
			$query = $this->db->get_where('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi', $filter);
		}else{
			$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi');
		}
		return $query->result_array();
	}


	public function get_last_id(){
		$this->db->order_by('id', 'DESC');

		$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi',1,0);
		return $query->result();
	}


	public function insert($data){
		$this->db->insert('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi', $data);
	}


	public function update_new($id,$bulan,$tahun,$data){
		$this->db->where('id_investasi', $id);
		$this->db->where('id_bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->update('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi', $data);
	}


	public function update($id,$iduser,$data){
		$this->db->where('id', $id);
		$this->db->where('iduser', $iduser);
		$this->db->update('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi', $data);
	}


	public function get_by_id($id,$iduser){
		$response = false;
		$query = $this->db->join('dbsmartaip_'.$this->tahun.'.mst_jenis_investasi', 'dbsmartaip_'.$this->tahun.'.mst_jenis_investasi.id_investasi = dbsmartaip_'.$this->tahun.'.bln_posisi_investasi.id_investasi')->get_where('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi',array('id' => $id,'iduser' => $iduser));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}


	// insert & update bulan selanjutnya
	// ====================================================================
	public function next_insert($data_next){
		$id_bulan=$this->session->userdata('id_bulan');
		$tahun=$this->session->userdata('tahun');
			if ($id_bulan >= 12){
						$bulan_next = $id_bulan = 1;
						$tahun_next = $tahun + 1;
						}
						else{
							$bulan_next = $id_bulan + 1;
							$tahun_next = $tahun;
						}
		$this->db->insert('dbsmartaip_'.$tahun_next.'.bln_posisi_investasi', $data_next);
	}

	public function next_update($bulan_next,$id_investasi,$data_next){
		$id_bulan=$this->session->userdata('id_bulan');
		$tahun=$this->session->userdata('tahun');
			if ($id_bulan >= 12){
						$bulan_next = $id_bulan = 1;
						$tahun_next = $tahun + 1;
						}
						else{
							$bulan_next = $id_bulan + 1;
							$tahun_next = $tahun;
						}

		$iduser=$data_next['iduser'];

		$this->db->where('id_bulan', $bulan_next);
		$this->db->where('id_investasi', $id_investasi);
		$this->db->where('iduser', $iduser);
		$this->db->update('dbsmartaip_'.$tahun_next.'.bln_posisi_investasi', $data_next);

		$this->get_next_jml($iduser,$bulan_next,$id_investasi,$tahun_next);
	}


	public function get_next_jml($iduser,$bulan_next,$id_investasi,$tahun_next){
		$query = $this->db->query("UPDATE dbsmartaip_".$tahun_next.".bln_posisi_investasi nil1,
										(SELECT(saldo_awal)+(mutasi) AS saldo_akhir 
										FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi WHERE id_bulan = '".$bulan_next."' AND id_investasi='".$id_investasi."' AND iduser='".$iduser."') AS nil2,
										(SELECT((saldo_awal)+(mutasi))/(rka) AS realisasi_rka
										FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi WHERE id_bulan = '".$bulan_next."' AND id_investasi='".$id_investasi."' AND iduser='".$iduser."') AS nil3
										SET 
										nil1.saldo_akhir = nil2.saldo_akhir,
										nil1.realisasi_rka = nil3.realisasi_rka
										
										WHERE id_bulan = '".$bulan_next."' AND id_investasi='".$id_investasi."'AND iduser='".$iduser."'");
	}

	public function get_next_row($iduser,$bulan_next,$id_investasi){
		$id_bulan=$this->session->userdata('id_bulan');
		$tahun=$this->session->userdata('tahun');
			if ($id_bulan >= 12){
						$bulan_next = $id_bulan = 1;
						$tahun_next = $tahun + 1;
						}
						else{
							$bulan_next = $id_bulan + 1;
							$tahun_next = $tahun;
						}

		$response = false;
		$query = $this->db->get_where('dbsmartaip_'.$tahun_next.'.bln_posisi_investasi',array('iduser' => $iduser,'id_bulan' => $bulan_next,'id_investasi' => $id_investasi));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	// ====================================================================

	public function delete($id,$iduser){
		$this->db->delete('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi', array('id' => $id,'iduser,' => $iduser));
	}
	

	public function get_filter($filter = '',$limit_offset = array()){
		if(!empty($filter)){
			$query = $this->db->order_by("id_bulan","id_investasi", "ASC")->join('dbsmartaip_'.$this->tahun.'.mst_jenis_investasi', 'dbsmartaip_'.$this->tahun.'.mst_jenis_investasi.id_investasi = dbsmartaip_'.$this->tahun.'.bln_posisi_investasi.id_investasi')->get_where('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi',$filter,$limit_offset['limit'],$limit_offset['offset']);

		}else{
			$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi',$limit_offset['limit'],$limit_offset['offset']);
		}
		// var_dump($query->result());exit;
		return $query->result();
	}
	
	public function count_total_filter($filter = array()){
		if(!empty($filter)){
			$query = $this->db->order_by("id_bulan", "desc")->get_where($this->table,$filter);
		}else{
			$query = $this->db->order_by("id_bulan", "desc")->get($this->table);
		}
		return $query->num_rows();
	}

	/*============================================================================================================*/
	/* function keterangan */

	public function get_by_id_ket($id){
		$response = false;
		$query = $this->db->get_where('dbsmartaip_'.$this->tahun.'.ket_lap_bulanan',array('id' => $id,'iduser' => $this->iduser));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($data){
		$bulan = $this->session->userdata('id_bulan');
		$this->db->delete('dbsmartaip_'.$this->tahun.'.ket_lap_bulanan', array('jenis_lap' => $data,'id_bulan' => $bulan ,'iduser' => $this->iduser));
	}

	public function insert_ket($data){
		$this->db->insert('dbsmartaip_'.$this->tahun.'.ket_lap_bulanan', $data);
	}


	public function get_ket_1($filter=""){
		$id="ket_posisi_investasi";
		$this->db->select("*");
		$this->db->from('dbsmartaip_'.$this->tahun.'.ket_lap_bulanan');
		$this->db->where('jenis_lap', $id);
		$this->db->where($filter);
		$query=$this->db->get();
		return $query->result();

	}


	function get_combo($type="", $p1="", $p2=""){
		$where = "";
		switch($type){
			case "data_pihak":
				$sql = "
					SELECT A.kode_pihak as id, B.nama_pihak as txt
					FROM dbsmartaip_".$this->tahun.".mst_nama_pihak A
					LEFT JOIN dbsmartaip_".$this->tahun.".mst_pihak B ON A.kode_pihak = B.kode_pihak
					WHERE id_investasi = '".$p1."'
				";
				// echo $sql;exit;
			break;
		}
		
		return $this->db->query($sql)->result_array();
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
				$table = "bln_posisi_investasi";
				$id_bulan = $data['id_bulan'];
				$jns_form = $data['jns_form'];
				$data['rka'] = str_replace(',', '', $data['rka']);
				$data['saldo_awal_invest'] = str_replace(',', '', $data['saldo_awal_invest']);
				$data['mutasi_invest'] = str_replace(',', '', $data['mutasi_invest']);
				$data['saldo_akhir_invest'] = str_replace(',', '', $data['saldo_akhir_invest']);

				if($sts_crud == "add" || $sts_crud == "edit"){
					$nama_pihak = ( isset( $data['nama_pihak']) ?  $data['nama_pihak'] : array() );
					$saldo_awal = ( isset( $data['saldo_awal']) ?  $data['saldo_awal'] : array() ); 
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
					$no = ( isset( $data['no_urut']) ?  $data['no_urut'] : array() ); 

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
				
				if($sts_crud == "delete" || $sts_crud == "edit"){
					$this->db->delete('bln_aset_investasi_detail', array('bln_posisi_investasi_id'=>$id) );
				}
			break;

		}
		
		switch ($sts_crud){
			case "add":
				$data['insert_at'] = date('Y-m-d H:i:s');
				$data['iduser'] = $this->iduser;

				if($jns_form == 1){
					unset($data['jns_form']);

					$insert = $this->db->insert($table,$data);
					$id = $this->db->insert_id();

					if($insert){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
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

					$insert = $this->db->insert($table,$data);
					$id = $this->db->insert_id();

					if($insert){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_amortisasi[$k] = str_replace(',', '', $mutasi_amortisasi[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_amortisasi' => $mutasi_amortisasi[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
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
					$insert = $this->db->insert($table,$data);
					$id = $this->db->insert_id();

					if($insert){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'lembar_saham' => $lembar_saham[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
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
					$insert = $this->db->insert($table,$data);
					$id = $this->db->insert_id();

					if($insert){
						if($table == "bln_posisi_investasi"){
							if(isset($manager_investasi)){
								foreach($manager_investasi as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_amortisasi[$k] = str_replace(',', '', $mutasi_amortisasi[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'manager_investasi' => $manager_investasi[$k],
										'nama_reksadana' => $nama_reksadana[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_amortisasi' => $mutasi_amortisasi[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'jml_unit_reksadana' => $jml_unit_reksadana[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
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
					$insert = $this->db->insert($table,$data);
					$id = $this->db->insert_id();

					if($insert){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$harga_saham[$k] = str_replace(',', '', $harga_saham[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'lembar_saham' => $lembar_saham[$k],
										'harga_saham' => $harga_saham[$k],
										'persentase' => $persentase[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
										'insert_at' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
								}
							}

						}

					}
				}
			break;
			case "edit":
				$data['update_at'] = date('Y-m-d H:i:s');
				$data['iduser'] = $this->iduser;

				if($jns_form == 1){
					unset($data['jns_form']);
					
					// $data['saldo_awal'] = str_replace(',', '', $data['saldo_awal']);
					// $data['mutasi'] = str_replace(',', '', $data['mutasi']);
					// $data['saldo_akhir'] = str_replace(',', '', $data['saldo_akhir']);

					
					$update = $this->db->update($table, $data, array('id' => $id) );	

					if($update){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
										'update_at' => date('Y-m-d H:i:s'),
									);
									// print_r($arr_detail_investasi);exit;
									$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
								}
							}

						}

					}
				}

				if($jns_form == 2){
					unset($data['jns_form']);
					$update = $this->db->update($table, $data, array('id' => $id) );

					if($update){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_amortisasi[$k] = str_replace(',', '', $mutasi_amortisasi[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_amortisasi' => $mutasi_amortisasi[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
										'update_at' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
								}
							}

						}

					}
				}

				if($jns_form == 3){
					unset($data['jns_form']);
					$update = $this->db->update($table, $data, array('id' => $id) );

					if($update){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'lembar_saham' => $lembar_saham[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
										'update_at' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
								}
							}

						}

					}
				}
				
				if($jns_form == 4){
					unset($data['jns_form']);
					$update = $this->db->update($table, $data, array('id' => $id) );

					if($update){
						if($table == "bln_posisi_investasi"){
							if(isset($manager_investasi)){
								foreach($manager_investasi as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_amortisasi[$k] = str_replace(',', '', $mutasi_amortisasi[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'manager_investasi' => $manager_investasi[$k],
										'nama_reksadana' => $nama_reksadana[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_amortisasi' => $mutasi_amortisasi[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'jml_unit_reksadana' => $jml_unit_reksadana[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
										'update_at' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
								}
							}

						}

					}
				}

				if($jns_form == 5){
					unset($data['jns_form']);
					$update = $this->db->update($table, $data, array('id' => $id) );

					if($update){
						if($table == "bln_posisi_investasi"){
							if(isset($nama_pihak)){
								foreach($nama_pihak as $k => $v){
									$saldo_awal[$k] = str_replace(',', '', $saldo_awal[$k]);
									$mutasi_pembelian[$k] = str_replace(',', '', $mutasi_pembelian[$k]);
									$mutasi_penjualan[$k] = str_replace(',', '', $mutasi_penjualan[$k]);
									$mutasi_pasar[$k] = str_replace(',', '', $mutasi_pasar[$k]);
									$harga_saham[$k] = str_replace(',', '', $harga_saham[$k]);
									$saldo_akhir[$k] = str_replace(',', '', $saldo_akhir[$k]);

									$arr_detail_investasi = array(
										'bln_posisi_investasi_id' => $id,
										'id_bulan' => $id_bulan,
										'iduser' => $this->iduser,
										'kode_pihak' => $nama_pihak[$k],
										'saldo_awal' => $saldo_awal[$k],
										'mutasi_pembelian' => $mutasi_pembelian[$k],
										'mutasi_penjualan' => $mutasi_penjualan[$k],
										'mutasi_pasar' => $mutasi_pasar[$k],
										'lembar_saham' => $lembar_saham[$k],
										'harga_saham' => $harga_saham[$k],
										'persentase' => $persentase[$k],
										'saldo_akhir' => $saldo_akhir[$k],
										'no_urut' => $no[$k],
										'update_at' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('bln_aset_investasi_detail', $arr_detail_investasi);
								}
							}

						}

					}
				}
			break;
			case "delete":
				if($table == "data_invoice" or $table == "data_order" or $table == "data_lain"){
					$table = "tbl_order_pengantaran";
				}
				$this->db->delete($table, array('id' => $id));	
			break;
		}
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return 'gagal';
		}else{
			 return $this->db->trans_commit();
		}
	}

	function getdata($type="", $balikan="", $p1="", $p2="",$p3="",$p4=""){
		$array = array();
		$where  = " WHERE 1=1 ";
		$where2 = "";
		
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
		

		$this->level = $this->session->userdata('level');
		$this->iduser = $this->session->userdata('iduser');

		if($this->level != 'DJA'){ // user Resepsinis
			$where .= "
				AND B.iduser = '".$this->iduser."'
			";
		}

		switch($type){
			case 'form_invest':
				$sql = "
					SELECT A.* 
					FROM mst_jenis_investasi A  
					WHERE A.id_investasi = '".$p1."'
				";
			break;
			case 'data_bulan_lalu_form':
				$id_bulan=$this->session->userdata('id_bulan');
				$bln_lalu = $id_bulan - 1 ;
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi as id_invesatasi_head, 
					C.id as id_detail, C.bln_posisi_investasi_id, C.iduser, C.id_bulan, C.kode_pihak, C.saldo_awal,
					C.mutasi_pembelian, C.mutasi_penjualan, C.mutasi_amortisasi, C.mutasi_pasar, C.saldo_akhir, C.lembar_saham,
					C.manager_investasi, C.nama_reksadana, C.jml_unit_reksadana, C.harga_saham, C.persentase, C.no_urut, D.nama_pihak
					FROM mst_jenis_investasi A  
					LEFT JOIN bln_posisi_investasi B  on B.id_investasi = A.id_investasi
					LEFT JOIN bln_aset_investasi_detail C  on C.bln_posisi_investasi_id = B.id
					LEFT JOIN mst_pihak D ON D.kode_pihak = C.kode_pihak
					$where
					AND A.id_investasi = '".$p1."' 
					AND A.jns_form = '".$p2."' 
					AND B.id_bulan = '".$bln_lalu."' 
					ORDER BY C.no_urut ASC
				";

				// echo $sql;exit;
			break;

			case 'data_aset_investasi':
				$id_bulan=$this->session->userdata('id_bulan');
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head,
					B.saldo_awal_invest, B.mutasi_invest, B.saldo_akhir_invest, B.rka, B.realisasi_rka , B.id
					FROM mst_jenis_investasi A  
					LEFT JOIN bln_posisi_investasi B  on B.id_investasi = A.id_investasi
					$where
					AND B.id = '".$p1."' 
					AND A.jns_form = '".$p2."' 
					AND B.id_bulan = '".$id_bulan."' 
					ORDER BY A.id_investasi ASC
				";

				// echo $sql;exit;
			break;

			case 'data_detail_aset_investasi':
				$id_bulan=$this->session->userdata('id_bulan');
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi as id_invesatasi_head, 
					C.id as id_detail, C.bln_posisi_investasi_id, C.iduser, C.id_bulan, C.kode_pihak, C.saldo_awal,
					C.mutasi_pembelian, C.mutasi_penjualan, C.mutasi_amortisasi, C.mutasi_pasar, C.saldo_akhir, C.lembar_saham,
					C.manager_investasi, C.nama_reksadana, C.jml_unit_reksadana, C.harga_saham, C.persentase, C.no_urut, D.nama_pihak
					FROM mst_jenis_investasi A  
					LEFT JOIN bln_posisi_investasi B  on B.id_investasi = A.id_investasi
					LEFT JOIN bln_aset_investasi_detail C  on C.bln_posisi_investasi_id = B.id
					LEFT JOIN mst_pihak D ON D.kode_pihak = C.kode_pihak
					$where
					AND B.id = '".$p1."' 
					AND A.jns_form = '".$p2."' 
					AND B.id_bulan = '".$id_bulan."' 
					ORDER BY C.no_urut ASC
				";

				// echo $sql;exit;
			break;

			case 'cek_aset_investasi':
				$id_bulan=$this->session->userdata('id_bulan');
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head,
					B.saldo_awal_invest, B.mutasi_invest, B.saldo_akhir_invest, B.rka, B.realisasi_rka , B.id
					FROM mst_jenis_investasi A  
					LEFT JOIN bln_posisi_investasi B  on B.id_investasi = A.id_investasi
					$where
					AND B.id = '".$p1."' 
					AND  A.jns_form = '".$p2."' 
					AND  B.id_bulan = '".$id_bulan."' 
					ORDER BY A.id_investasi ASC
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