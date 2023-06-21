<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beban_model extends CI_Model {

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
    $this->db->where_in('mst_investasi.group',array('BEBAN','IURAN'));
    $id = $this->db->get('mst_investasi')->result_array();
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
     
      $this->db->where('id_bulan',$bulan);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $this->db->where_in($id);
      return $this->db->count_all_results($this->table, FALSE);
    }
  }

  public function get($bulan=null,$tahun=null,$user=null)
  {
    if (null === $bulan) {
      $bulan = 0;
    }

    if (null === $tahun) {
      $tahun = 0;
    }
    

    $this->db->select('id_investasi');
    $this->db->where('mst_investasi.iduser',$user);
    $this->db->where_in('mst_investasi.group',array('BEBAN','IURAN'));
    $id = $this->db->get('mst_investasi')->result_array();
    
    $arrID = array();
    foreach ($id as $key => $value) {
      $arrID[] = $value['id_investasi'];
    }

      $this->db->select('iduser,id_investasi,id_bulan,tahun,saldo_awal_invest,mutasi_invest,saldo_akhir_invest,rka,realisasi_rka,keterangan');
      $this->db->where('id_bulan',$bulan);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $this->db->where_in('id_investasi',$arrID);
      return $this->db->get($this->table)->result_array();
    
  }

  public function delete($bulan=null,$tahun=null,$user=null)
  {
    if (null === $bulan) {
        $bulan = 0;
    }
    if (null === $tahun) {
        $tahun = 0;
    }
    
    $this->db->select('id_investasi');
    $this->db->where('mst_investasi.iduser',$user);
    $this->db->where_in('mst_investasi.group',array('BEBAN','IURAN'));
    $id = $this->db->get('mst_investasi')->result_array();
    $arrID = array();
    foreach ($id as $key => $value) {
      $arrID[] = $value['id_investasi'];
    }

      
      $this->db->where('id_bulan',$bulan);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $this->db->where_in('id_investasi',$arrID);
      $this->db->delete($this->table);
      return $this->db->affected_rows();
    
  }

  public function insert($data)
  {
    $dataInsert =array();
    $dataUpdate =array();
    $arrBulan = array(1,2,3,4,5,6,7,8,9,10,11,12);

    $this->db->select('id_investasi');
    $this->db->where_in('mst_investasi.group',array('BEBAN','IURAN'));
    $id = $this->db->get('mst_investasi')->result_array();
    
    $arrID = array();
    foreach ($id as $key => $value) {
      $arrID[] = $value['id_investasi'];
    }

    $this->db->select('iduser');
    $resUser = $this->db->get('t_user')->result_array();
    $arrUSER = array();
    foreach ($resUser as $key => $value) {
      $arrUSER[] = $value['iduser'];
    }

    $status = 1;
    foreach ($data as $key => $value) {
      $id_investasi = $value['id_investasi'];
      $id_bulan = $value['id_bulan'];
      $id_user = $value['iduser'];
      $tahun = $value['tahun'];
      

      // cek data id investasi
      if (in_array($id_investasi, $arrID) && in_array($id_user, $arrUSER) && in_array($id_bulan, $arrBulan)) {
        // jika key nya not null maka id investasi merupakan BEBAN
        
        $cekdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'id_investasi'=>$id_investasi,'id_bulan'=>$id_bulan,'tahun'=>$tahun))->num_rows();
        
        if ($cekdata>0) {

          // update
          $dataUpdate[]=$value;
        }else{
          $dataInsert[]=$value;
          // insert
          
        }

      }else{
        $status = 0;
        // jika key nya null maka error karna bukan BEBAN
      }
    }

    $msg='| ';
    $res=array();
    if ($status==0) {
      $res['error']=true;
      $res['msg']='Data Invalid';
    }else{
      if ((is_countable($dataInsert)?$dataInsert:[])) { 
        // jika ada data yg diinput
        $this->db->insert_batch($this->table, $dataInsert);
        $jumlahInsert = $this->db->affected_rows();
        $msg.= $jumlahInsert.' Data Berhasil Ditambahkan | ';
      }

      if ((is_countable($dataUpdate)?$dataUpdate:[])) { 
        $jumlahUpdate = 0;
        $jumlahUpdateAll = 0;
        foreach ($dataUpdate as $keyUpdate => $valueUpdate) {
          $dataUpdateRow = $valueUpdate;

          $this->db->where('iduser',$valueUpdate['iduser']);
          $this->db->where('id_investasi',$valueUpdate['id_investasi']);
          $this->db->where('id_bulan',$valueUpdate['id_bulan']);
          $this->db->where('tahun',$valueUpdate['tahun']);
          $this->db->update($this->table , $dataUpdateRow);
          $jumlahUpdate = $this->db->affected_rows();
          $jumlahUpdateAll = $jumlahUpdateAll+$jumlahUpdate;
        }
        // jika ada data yg diinput
        
        $msg.= $jumlahUpdateAll.' Data Berhasil Diperbarui | ';
      }

      $res['error']=false;
      $res['msg']=$msg;
    }
    
    

    return $res;
  }

}