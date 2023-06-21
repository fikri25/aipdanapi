<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hasil_investasi_model extends CI_Model {

  private $table;
  function __construct(){
    parent::__construct();
    $this->table = 'bln_aset_investasi_header';
    $this->tableMaster = 'mst_investasi';
    date_default_timezone_set('Asia/Jakarta');
  }

  public function getCount($type)
  {
    $this->db->select('id_investasi');
    $id = $this->db->get_where('mst_investasi',array('mst_investasi.group'=>'HASIL INVESTASI'))->result_array();
    if ($type=='bulanan') {
      if (null !== $this->input->get('bulan')) {
        $bulan = $this->input->get('bulan');
      }else{
        $bulan = 0;
      }
      if (null !== $this->input->get('tahun')) {
        $tahun = $this->input->get('tahun');
      }else{
        $tahun = 0;
      }
      if (null !== $this->input->get('user')) {
        if($this->input->get('user') == 'TASPEN'){
          $user = 'TSN002';
        }elseif ($this->input->get('user') == 'ASABRI') {
          $user = 'ASB002';
        }else{
          $user = '';
        }
      }else{
        $user = '';
      }
      $this->db->where('id_bulan',$bulan);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $this->db->where_in($id);
      return $this->db->count_all_results($this->table, FALSE);
    }
  }

  public function get($type)
  {
    $this->db->select('id_investasi');
    $id = $this->db->get_where('mst_investasi',array('mst_investasi.group'=>'HASIL INVESTASI'))->result_array();
    if ($type=='bulanan') {
       if (null !== $this->input->get('bulan')) {
        $bulan = $this->input->get('bulan');
      }else{
        $bulan = 0;
      }
      if (null !== $this->input->get('tahun')) {
        $tahun = $this->input->get('tahun');
      }else{
        $tahun = 0;
      }
      if (null !== $this->input->get('user')) {
        if($this->input->get('user') == 'TASPEN'){
          $user = 'TSN002';
        }elseif ($this->input->get('user') == 'ASABRI') {
          $user = 'ASB002';
        }else{
          $user = '';
        }
      }else{
        $user = '';
      }
      $this->db->select('iduser,id_investasi,id_bulan,tahun,saldo_awal_invest,mutasi_invest,saldo_akhir_invest,rka,realisasi_rka,keterangan');
      $this->db->where('id_bulan',$bulan);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $this->db->where_in($id);
      return $this->db->get($this->table);
    }
  }

  public function insert($data)
  {
    $this->db->select('id_investasi');
    $id = $this->db->get_where('mst_investasi',array('mst_investasi.group'=>'HASIL INVESTASI'))->result_array();

    $dataInsert=array();
    foreach ($data as $value) {
      $dataInsert[] = array(
                            "iduser"      =>$value->iduser,
                            "id_investasi"=>$value->id_investasi,
                            "id_bulan"    =>$value->id_bulan,
                            "tahun"       =>$value->tahun,
                            "saldo_awal_invest"=>$value->saldo_awal_invest,
                            "mutasi_invest"=>$value->mutasi_invest,
                            "saldo_akhir_invest"=>$value->saldo_akhir_invest,
                            "rka"=>$value->rka,
                            "realisasi_rka"=>$value->realisasi_rka,
                            "filedata"=>"",
                            "keterangan"=> $value->keterangan,
                            "insert_at"=> date("Y-m-d H:i:s"),
                            "insert_by"=> "API",
                            );
    }
    
    $this->db->insert_batch($this->table, $dataInsert);
    $res = $this->db->affected_rows();
    return $res;
  }

}