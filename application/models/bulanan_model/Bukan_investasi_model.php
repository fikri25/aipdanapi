<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukan_investasi_model extends CI_Model {
	private $table;
	function __construct(){
      parent::__construct();
      $this->tahun = $this->session->userdata('tahun');
      $this->iduser = $this->session->userdata('iduser');
		$this->table = 'dbsmartaip_'.$this->tahun.'.bln_bukan_investasi';
	}

	
	public function get_all($limit_offset = array()){
		if(!empty($limit_offset)){
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi',$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi');
		}
		return $query->result();
	}


	public function count_total(){
		$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi');
		return $query->num_rows();
	}


	public function get_all_array($filter = false){
		if(!empty($filter)) {
			$query = $this->db->get_where('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi', $filter);
		}else{
			$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi');
		}
		return $query->result_array();
	}


	public function get_last_id(){
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi',1,0);
		return $query->result();
	}


	public function insert($data){
		$this->db->insert('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi', $data);
	}


	public function update($id,$iduser,$data){
		$this->db->where('id', $id);
		$this->db->where('iduser', $iduser);
		$this->db->update('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi', $data);
	}


	public function update_pos($id_jns_aset,$bulan,$tahun,$data_pos){
		
		$this->db->where('id_jns_aset',$id_jns_aset);
		$this->db->where('id_bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('iduser', $this->iduser);
		$this->db->update('dbsmartaip_'.$this->tahun.'.bln_lap_bukan_investasi', $data_pos);
	}


	public function get_jumlah_pos($id_jns_aset,$bulan,$tahun){
		
			$query = $this->db->select('SUM(saldo_awal) as saldo, (SUM(mutasi_penambahan)+SUM(mutasi_pengurangan)) as mutasi');
			$this->db->from($this->table);
			$this->db->where('id_jns_aset',$id_jns_aset);
			$this->db->where('id_bulan',$bulan);
			$this->db->where('tahun',$tahun);
			$this->db->where('iduser', $this->iduser);
			$query = $this->db->get();
			return $query->result();
	}


	public function get_jumlah_bangunan($id_jns_aset,$bulan,$tahun){
		
			$query = $this->db->select('SUM(saldo_awal) as saldo, (SUM(mutasi_penambahan)+SUM(mutasi_pengurangan)+SUM(mutasi_depreasi)) as mutasi');
			$this->db->from($this->table);
			$this->db->where('id_jns_aset',$id_jns_aset);
			$this->db->where('id_bulan',$bulan);
			$this->db->where('tahun',$tahun);
			$this->db->where('iduser', $this->iduser);
			$query = $this->db->get();
			return $query->result();
	}


	public function get_by_id($id,$iduser){
		$response = false;
		$query = $this->db->get_where('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi',array('id' => $id, 'iduser' => $iduser));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}


	public function delete($id,$iduser){
		$this->db->delete('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi', array('id' => $id, 'iduser' => $iduser));
	}

	
	public function get_filter($filter = '', $limit_offset = array()){
		if(!empty($filter)){
			// var_dump($filter);exit;
			// $query = $this->db->order_by("id_bulan", "desc")
			// ->join('dbsmartaip_'.$this->tahun.'.mst_nama_pihak', 'dbsmartaip_'.$this->tahun.'.mst_nama_pihak.kode_pihak = dbsmartaip_'.$this->tahun.'.bln_bukan_investasi.kode_pihak')
			// ->join('dbsmartaip_'.$this->tahun.'.mst_pihak', 'dbsmartaip_'.$this->tahun.'.mst_pihak.kode_pihak = dbsmartaip_'.$this->tahun.'.mst_nama_pihak.kode_pihak')
			// ->get_where('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi',$filter,$limit_offset['limit'],$limit_offset['offset']);
			$this->db->select('*');
			$this->db->from('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi a');
			$this->db->join('dbsmartaip_'.$this->tahun.'.mst_pihak c', 'c.kode_pihak = a.kode_pihak','left');
			$this->db->where('a.iduser',$filter['iduser']);
			$this->db->where('a.id_bulan',$filter['bln_bukan_investasi.id_bulan']);
			$this->db->where('a.id_jns_aset',$filter['bln_bukan_investasi.id_jns_aset']);
			$this->db->limit($limit_offset['limit'],$limit_offset['offset']);
			$query = $this->db->get();
		}else{
			$query = $this->db->join('dbsmartaip_'.$this->tahun.'.mst_nama_pihak', 'dbsmartaip_'.$this->tahun.'.mst_nama_pihak.kode_pihak = dbsmartaip_'.$this->tahun.'.bln_bukan_investasi.kode_pihak')->get('dbsmartaip_'.$this->tahun.'.bln_bukan_investasi',$limit_offset['limit'],$limit_offset['offset']);
		}
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

	// insert & update bulan selanjutnya
	// ====================================================================
	public function next_insert($data_next){
		$bulan=$this->session->userdata('id_bulan');
		$thn=$this->session->userdata('tahun');

		if ($bulan >= 12){
				$tahun = $thn + 1;
				}
				else{
					$tahun = $thn;
				}

		$this->db->insert('dbsmartaip_'.$tahun.'.bln_bukan_investasi', $data_next);
		// echo $this->db->last_query();exit;
		$id_jns=$data_next['id_jns_aset'];
		$id_bulan=$this->session->userdata('id_bulan');
			if ($id_bulan > 1){
							$this->get_nilai_depan_now($id_jns);
							$this->get_nilai_depan_next($id_jns);
						}
						else{
							$this->get_nilai_depan($id_jns);
							$this->get_nilai_depan_next($id_jns);
						}
	}

	public function next_update($bulan_next,$pihak,$id_jns,$data_next){
		$bulan=$this->session->userdata('id_bulan');
		$thn=$this->session->userdata('tahun');

		if ($bulan >= 12){
				$tahun = $thn + 1;
				}
				else{
					$tahun = $thn;
				}

		$iduser=$data_next['iduser'];
		$id_jns=$data_next['id_jns_aset'];

		$this->db->where('id_bulan', $bulan_next);
		$this->db->where('kode_pihak', $pihak);
		$this->db->where('id_jns_aset', $id_jns);
		$this->db->where('iduser', $iduser);
		$this->db->update('dbsmartaip_'.$tahun.'.bln_bukan_investasi', $data_next);

		$this->get_next_jml($iduser,$bulan_next,$pihak,$id_jns,$tahun);

		$id_bulan=$this->session->userdata('id_bulan');
		if ($id_bulan > 1){
							$this->get_nilai_depan_now($id_jns);
							$this->get_nilai_depan_next($id_jns);
						}
						else{
							$this->get_nilai_depan($id_jns);
							$this->get_nilai_depan_next($id_jns);
						}
	}

	// reload jika proses update ke bukan investasi gagal
	public function reload_update($id_jns){
		// var_dump($id_jns);exit;
		$id_bulan=$this->session->userdata('id_bulan');
			if ($id_bulan > 1){
				// echo "2";exit;
				$this->get_nilai_depan_now($id_jns);
				// $this->get_nilai_depan_next($id_jns);
			}
			else{
				// echo "1";exit;
				$this->get_nilai_depan($id_jns);
				// $this->get_nilai_depan_next($id_jns);
		}
	}

	public function get_next_jml($iduser,$bulan_next,$pihak,$id_jns,$tahun){
		$query = $this->db->query("UPDATE dbsmartaip_".$tahun.".bln_bukan_investasi nil1,
										(SELECT(saldo_awal)+(mutasi_penambahan)+(mutasi_pengurangan) AS saldo_akhir 
										FROM dbsmartaip_".$tahun.".bln_bukan_investasi WHERE id_bulan = '".$bulan_next."' AND kode_pihak='".$pihak."'AND id_jns_aset='".$id_jns."' AND iduser='".$iduser."') AS nil2
										SET nil1.saldo_akhir = nil2.saldo_akhir
										WHERE id_bulan = '".$bulan_next."' AND kode_pihak='".$pihak."' AND id_jns_aset='".$id_jns."' AND iduser='".$iduser."'");
	}

	// update semua nilai berdasar jenis investasi di menu bukan investasi (jika id bula == 1)
	public function get_nilai_depan($id_jns){
		$id_bulan=$this->session->userdata('id_bulan');
		$tahun=$this->session->userdata('tahun');
		// $id_jns=1;
		$sql = "UPDATE dbsmartaip_".$this->tahun.".bln_lap_bukan_investasi nil1,
										(SELECT SUM(saldo_awal) as saldo_awal
										FROM dbsmartaip_".$this->tahun.".bln_bukan_investasi WHERE id_bulan = '".$id_bulan."' AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."') AS nil2,
										(SELECT SUM(mutasi_penambahan)+SUM(mutasi_pengurangan)+SUM(mutasi_depreasi) as mutasi
										FROM dbsmartaip_".$this->tahun.".bln_bukan_investasi WHERE id_bulan = '".$id_bulan."' AND id_jns_aset='".$id_jns."'  AND iduser='".$this->iduser."') AS nil3,
										(SELECT SUM(saldo_akhir) AS saldo_akhir
										FROM dbsmartaip_".$this->tahun.".bln_bukan_investasi WHERE id_bulan = '".$id_bulan."' AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."') AS nil4
										SET 
										nil1.saldo_awal = nil2.saldo_awal,
										nil1.mutasi = nil3.mutasi,
										nil1.saldo_akhir = nil4.saldo_akhir

										WHERE id_bulan = '".$id_bulan."' AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."'";
		$query = $this->db->query($sql);
			// echo $sql;exit;
		// echo $this->db->last_query();exit;
	}

	// update nilai di menu bukan investasi (jika id bulan > 1)
	public function get_nilai_depan_now($id_jns){
		$id_bulan=$this->session->userdata('id_bulan');
		$tahun=$this->session->userdata('tahun');
		$query = $this->db->query("UPDATE dbsmartaip_".$this->tahun.".bln_lap_bukan_investasi nil1,
						
										(SELECT (SUM(mutasi_penambahan)+SUM(mutasi_pengurangan)+SUM(mutasi_depreasi)) as mutasi
										FROM dbsmartaip_".$this->tahun.".bln_bukan_investasi WHERE id_bulan = '".$id_bulan."'  AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."') AS nil3,
										(SELECT (saldo_awal) AS saldo_awal
										FROM dbsmartaip_".$this->tahun.".bln_lap_bukan_investasi WHERE id_bulan = '".$id_bulan."' AND iduser='".$this->iduser."') AS nil4
										SET 
										nil1.mutasi = nil3.mutasi,
										nil1.saldo_akhir = nil3.mutasi+nil4.saldo_awal

										WHERE id_bulan = '".$id_bulan."' AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."'");

		// echo $this->db->last_query();exit;
	}


	/*
	public function get_nilai_depan_now($id_jns){
		$id_bulan=$this->session->userdata('id_bulan');
		$tahun=$this->session->userdata('tahun');
		$query = $this->db->query("UPDATE dbsmartaip_".$this->tahun.".bln_lap_bukan_investasi nil1,
						
										(SELECT (SUM(mutasi_penambahan)+SUM(mutasi_pengurangan)+SUM(mutasi_depreasi)) as mutasi
										FROM dbsmartaip_".$this->tahun.".bln_bukan_investasi WHERE id_bulan = '".$id_bulan."'  AND id_jns_aset='".$id_jns."' AND tahun='".$tahun."' AND iduser='".$this->iduser."') AS nil3,
										(SELECT (SUM(saldo_awal)+SUM(mutasi_penambahan)+SUM(mutasi_pengurangan)+SUM(mutasi_depreasi)) AS saldo_akhir
										FROM dbsmartaip_".$this->tahun.".bln_bukan_investasi WHERE id_bulan = '".$id_bulan."' AND tahun='".$tahun."' AND iduser='".$this->iduser."') AS nil4
										SET 
										nil1.mutasi = nil3.mutasi,
										nil1.saldo_akhir = nil4.saldo_akhir

										WHERE id_bulan = '".$id_bulan."' AND id_jns_aset='".$id_jns."' AND tahun='".$tahun."' AND iduser='".$this->iduser."'");

		// echo $this->db->last_query();exit;
	}

	*/

	// update nilai di menu bukan investasi id bulan+1 (bulan selanjutya)
	public function get_nilai_depan_next($id_jns){
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
		$query = $this->db->query("UPDATE dbsmartaip_".$this->tahun.".bln_lap_bukan_investasi nil1,
										(SELECT saldo_akhir AS saldo_awal
										FROM dbsmartaip_".$this->tahun.".bln_lap_bukan_investasi WHERE id_bulan = '".$id_bulan."'  AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."') AS nil2,
										(SELECT mutasi
										FROM dbsmartaip_".$tahun_next.".bln_lap_bukan_investasi WHERE id_bulan = '".$bulan_next."'  AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."') AS nil3
										SET 
										nil1.saldo_awal = nil2.saldo_awal,
										nil1.saldo_akhir = nil2.saldo_awal+nil3.mutasi
										WHERE id_bulan = '".$bulan_next."' AND id_jns_aset='".$id_jns."' AND iduser='".$this->iduser."'");

		// echo $this->db->last_query();exit;
	}

	public function get_next_row($iduser,$bulan_next,$pihak,$id_jns){
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
		$query = $this->db->get_where('dbsmartaip_'.$tahun_next.'.bln_bukan_investasi',array('iduser' => $iduser,'id_bulan' => $bulan_next,'kode_pihak' => $pihak,'id_jns_aset' => $id_jns));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	// ====================================================================

}