<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_keuangan_model extends CI_Model {
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
						SELECT id,id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
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
					saldo_akhir_invest as saldo_akhir, id_bulan, iduser
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
			case "mst_investasi":
				$sql = "
					SELECT A.id_investasi, A.iduser
					FROM mst_investasi A
					$where2
					ORDER BY A.id_investasi ASC				
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
				$sql = "
					SELECT A.id_investasi, A.jenis_investasi, A.iduser, A.group,
					B.id_bulan, B.saldo_akhir
					FROM mst_investasi A
					LEFT JOIN(
						SELECT id_investasi, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan = '".$id_bulan."'
						AND iduser =  '".$iduser."'
						AND A.tahun = '".$tahun."'
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
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi, B.tahun,
					C.id as id_detail, C.bln_aset_investasi_header_id, C.iduser, C.id_bulan, C.kode_pihak, C.saldo_awal,
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
					SELECT A.id_investasi, A.jenis_investasi,A.jns_form , B.id, B.id_investasi as id_invesatasi_head, B.tahun,
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
					B.saldo_awal_invest, B.mutasi_invest, B.saldo_akhir_invest, B.rka, B.realisasi_rka , B.id, B.tahun
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
					SELECT count(*) as total, A.id_investasi, A.jenis_investasi,A.jns_form , B.id_investasi as id_invesatasi_head,B.id, B.tahun
					FROM mst_investasi A  
					LEFT JOIN bln_aset_investasi_header B  on B.id_investasi = A.id_investasi
					$where
					AND  A.id_investasi = '".$p1."' 
					AND  B.id_bulan = '".$id_bulan."' 
					AND B.tahun = '".$tahun."'
					ORDER BY A.id_investasi ASC
				";

				// echo $sql;exit;
			break;

			case 'dana_bersih_lv0':
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
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE (
								(
									CASE
									WHEN B.iduser = 'TSN002'
									AND C.tahun = '2020'
									AND A.uraian = 'ASET INVESTASI' THEN
										151428469320652

									WHEN B.iduser = 'ASB003'
									AND C.tahun = '2020'
									AND A.uraian = 'ASET INVESTASI' THEN
										17669911410364
									ELSE
										SUM(D.saldo_akhir_smt2)
									END
								),
								0
							) AS saldo_akhir_smt2,

					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '6'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					) D ON B.id_investasi = D.id_investasi


					WHERE B.iduser = '".$iduser."'
					GROUP BY A.jenis_laporan
				";
				// echo $sql;exit();
			break;

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
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '6'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					) D ON B.id_investasi = D.id_investasi


					WHERE B.iduser = '".$iduser."'
					GROUP BY A.jenis_laporan
				";
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
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '6'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
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
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '6'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
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
					COALESCE(SUM(C.saldo_akhir_smt1), 0) as saldo_akhir_smt1,
					COALESCE(SUM(D.saldo_akhir_smt2), 0) as saldo_akhir_smt2,
					C.rka as rka_sem1, D.rka as rka_sem2
					FROM mst_dana_bersih A
					LEFT JOIN mst_investasi B ON A.id_dana_bersih = B.id_dana_besih
					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt1, id_bulan, iduser,rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '6'
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) C ON B.id_investasi = C.id_investasi

					LEFT JOIN(
						SELECT id_investasi,saldo_akhir_invest as saldo_akhir_smt2, id_bulan, iduser, rka, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan = '12'
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

				// echo $sql;exit();
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

				  // echo $sql;exit;
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
						AND tahun = '".$tahun."'
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
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					) B ON A.id_investasi = B.id_investasi
					WHERE 1=1
					AND NOT A.type_sub_jenis_investasi ='PC'
					AND A.`group`='BEBAN'
					AND A.iduser = '".$iduser."'
					ORDER BY A.no_urut ASC
				";
			break;

			case 'lkak_yoi_hasil_investasi':
				//  kondisi untuk YOI sem1 : 1-6
				//  kondisi untuk YOI sem2 : 1-12
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
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN B.mutasi else B.saldo_akhir end), 0) as saldo_akhir_smt1,
					COALESCE(SUM(CASE WHEN A.group = 'HASIL INVESTASI' THEN C.mutasi else C.saldo_akhir end), 0) as saldo_akhir_smt2,
					COALESCE(B.rka, 0) as rka_smt1
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
						GROUP BY id_investasi
					)B ON A.id_investasi=B.id_investasi
					LEFT JOIN(
						SELECT id_investasi, sum(saldo_awal_invest) AS saldo_awal, sum(mutasi_invest) AS mutasi, rka, realisasi_rka, sum(saldo_akhir_invest) AS saldo_akhir, id_bulan, iduser, tahun
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
						GROUP BY id_investasi
					)C ON A.id_investasi=C.id_investasi
					$where2
					AND A.`group`='HASIL INVESTASI'

				";
				// echo $sql;exit();
			break;

			case 'lkak_yoi_investasi':
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
					COALESCE(B.saldo_akhir, 0) as saldo_akhir_smt1,
					COALESCE(C.saldo_akhir, 0) as saldo_akhir_smt2,
					COALESCE(B.rka, 0) as rka_smt1
					FROM mst_investasi A 
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 1 AND 6
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun."'
					)B ON A.id_investasi=B.id_investasi
					LEFT JOIN(
						SELECT id_investasi, saldo_awal_invest as saldo_awal, mutasi_invest as mutasi, rka, realisasi_rka, tahun,
						saldo_akhir_invest as saldo_akhir, id_bulan, iduser
						FROM bln_aset_investasi_header
						WHERE id_bulan BETWEEN 7 AND 12
						AND iduser = '".$iduser."'
						AND tahun = '".$tahun_filter."'
					)C ON A.id_investasi=C.id_investasi
					$where2
					AND A.id_investasi ='".$p1."'
					AND A.`group`='INVESTASI'
					AND B.saldo_akhir IS NOT NULL

				";
				// echo $sql;exit();
			break;

			case 'lkak_yoi_investasi_sm1':
				//  kondisi untuk YOI sem1 : 1-6
				//  kondisi untuk YOI sem2 : 7-12
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
					SELECT
					A.id_bulan,
					A.tahun,
					B.`group`,
					COALESCE(sum(A.saldo_akhir_invest), 0) as saldo_akhir_smt1,
					COALESCE(A.rka, 0) as rka_smt1,
					COALESCE(sum(A.mutasi_invest), 0) as mutasi_smt1,
					A.iduser
					FROM
					bln_aset_investasi_header A
					LEFT JOIN mst_investasi B ON A.id_investasi = B.id_investasi
					WHERE A.iduser = '".$iduser."'
					AND A.tahun = '".$tahun_filter."'
					AND B.`group` = 'INVESTASI'
					AND A.id_bulan BETWEEN 1 AND 6
					GROUP BY A.id_bulan
				";
				// echo $sql;exit();
			break;
			case 'lkak_yoi_investasi_sm2':
				//  kondisi untuk YOI sem1 : 1-6
				//  kondisi untuk YOI sem2 : 7-12
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
					SELECT
					A.id_bulan,
					A.tahun,
					B.`group`,
					COALESCE(sum(A.saldo_akhir_invest), 0) as saldo_akhir_smt2,
					COALESCE(A.rka, 0) as rka_smt2,
					COALESCE(sum(A.mutasi_invest), 0) as mutasi_smt2,
					A.iduser
					FROM
					bln_aset_investasi_header A
					LEFT JOIN mst_investasi B ON A.id_investasi = B.id_investasi
					WHERE A.iduser = '".$iduser."'
					AND A.tahun = '".$tahun_filter."'
					AND B.`group` = 'INVESTASI'
					AND A.id_bulan BETWEEN 7 AND 12
					GROUP BY A.id_bulan
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