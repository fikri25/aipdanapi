<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_investasi_th_model extends CI_Model {
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
		$query = $this->db->get_where('ket_lap_tahunan',array('id' => $id,'iduser' => $this->iduser,'tahun' => $this->tahun));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}

	public function delete_ket($p1,$p2){
		$this->db->delete('ket_lap_tahunan', array('jenis_lap' => $p1, 'iduser' => $this->iduser,'tahun' => $this->tahun));
	}

	public function insert_ket($data){
		$this->db->insert('ket_lap_tahunan', $data);
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
			FROM ket_lap_tahunan A
			$where
			AND A.jenis_lap = '".$p1."'
		";

		return $this->db->query($sql)->result();
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
				$tahun_filter = $tahun - 1;

				if ($p1 == 'INVESTASI') {
					$where_sm1 .= "
						AND id_bulan = '12'
					";

					$where_sm2 .= "
						AND id_bulan = '12'
					";
				}else if ($p1 == 'HASIL INVESTASI') {
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 12
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 1 AND 12
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
						WHERE id_bulan BETWEEN 1 AND 12
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
						AND id_bulan = '12'
					";

					$where_sm2 .= "
						AND id_bulan = '12'
					";
				}else if ($p1 == 'HASIL INVESTASI') {
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 12
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 1 AND 12
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
						WHERE id_bulan BETWEEN 1 AND 12
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
				$tahun_filter = $tahun - 1;

				if ($p1 == 'INVESTASI') {
					$where_sm1 .= "
						AND id_bulan = '12'
					";

					$where_sm2 .= "
						AND id_bulan = '12'
					";
				}else if ($p1 == 'HASIL INVESTASI') {
					$where_sm1 .= "
						AND id_bulan BETWEEN 1 AND 12
					";

					$where_sm2 .= "
						AND id_bulan BETWEEN 1 AND 12
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
						WHERE id_bulan BETWEEN 1 AND 12
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

	

}	