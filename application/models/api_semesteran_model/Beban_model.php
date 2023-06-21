<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beban_model extends CI_Model {

  private $table;
  function __construct(){
    parent::__construct();
    $this->table = 'tbl_lkao_tenaga_kerja';
    date_default_timezone_set('Asia/Jakarta');
  }

  

  public function get($semester=null,$tahun=null,$user=null)
  {
    if (null === $semester) {
      $semester = 0;
    }

    if (null === $tahun) {
      $tahun = 0;
    }
    
      $this->db->select('id,iduser,tahun,id_cabang,jml_penyelenggaraan,persen_penyelenggaraan,jml_lain,persen_lain');
      // $this->db->where('semester',$semester);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $result = $this->db->get($this->table)->result_array();
      // penghubungnya
     foreach ($result as $key => $value) {
        unset($result[$key]['id']);
      }
      return $result;
    
  }

  public function delete($semester=null,$tahun=null,$user=null)
  {
    if (null === $semester) {
        $semester = 0;
    }
    if (null === $tahun) {
        $tahun = 0;
    }
    
    

    // master cabang
      $this->db->select('id_cabang');
      $this->db->where('iduser',$user);
      $resCab = $this->db->get('mst_cabang')->result_array();
      $arrCab = array();
      foreach ($resCab as $keyCab => $valueCab) {
        $arrCab[] = $valueCab['id_cabang'];
      }


      
      $this->db->where('iduser',$user);
      $this->db->where('tahun',$tahun);
      $this->db->where_in('id_cabang',$arrCab);
      $this->db->delete($this->table);
      
      
      

      return $this->db->affected_rows();
    
  }

  public function insert($data)
  {

    $dataInsert =array();
    $dataUpdate =array();
    $arrSmt = array(1,2);
    $insert_at = date('Y-m-d H:i:s');
    // master user
    $this->db->select('iduser');
    $resUser = $this->db->get('t_user')->result_array();
    $arrUSER = array();
    foreach ($resUser as $key => $value) {
      $arrUSER[] = $value['iduser'];
    }

   



    $status = 1;
    $msg='-- Trans Begin --';
    $noHeader = 0;
    foreach ($data as $key => $value) {
      $noHeader++;
      $noDetail = 0;
      $id_user = $value['iduser'];
      $smt = $value['semester'];
      $tahun = $value['tahun'];
      $id_cabang = $value['id_cabang'];


      // master cabang
      $this->db->select('id_cabang');
      $this->db->where('iduser',$id_user);
      $resCab = $this->db->get('mst_cabang')->result_array();
      $arrCab = array();
      foreach ($resCab as $keyCab => $valueCab) {
        $arrCab[] = $valueCab['id_cabang'];
      }

      $detail = array();

      // cek data id investasi
      if (in_array($id_user, $arrUSER) && in_array($id_cabang, $arrCab)) {
        // jika key nya not null maka id investasi merupakan INVESTASI
        
        $cekdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'tahun'=>$tahun,'id_cabang'=>$id_cabang))->num_rows();
        
        if ($cekdata>0) {
          $getdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'tahun'=>$tahun,'id_cabang'=>$id_cabang))->row();

          
          // update header

          $dataUpdate=$value;
          $dataUpdate['insert_at']=$getdata->insert_at;
          $dataUpdate['update_at']=$insert_at;
          

          $this->db->where('iduser',$value['iduser']);
          $this->db->where('tahun',$value['tahun']);
          $this->db->where('id_cabang',$value['id_cabang']);
          $this->db->update($this->table , $dataUpdate);
          $jumlahUpdate = $this->db->affected_rows();
          if ($jumlahUpdate>0) {
            $msg.= '<< Data Header ke-'.$noHeader.' Berhasil Diperbarui >>';
          }
        }else{
          // insert header
          
          $dataInsert=$value;
          $dataInsert['insert_at']=$insert_at;
          $insert = $this->db->insert($this->table, $dataInsert);
          
          $jumlahInsert = $this->db->affected_rows();
          if ($jumlahInsert>0) {
            $msg.= '<< Data Header ke-'.$noHeader.' Berhasil Ditambahkan >>';
          }
          
          

          // insert detail
          
        }

      }else{
        $status = 0;
        // jika key nya null maka error karna bukan INVESTASI
      }
    }

    $msg.='-- Trans End --';

    $res=array();
    $res['error']=false;
    $res['msg']=$msg;

    // if ($status==0) {
    //   $res['error']=true;
    //   $res['msg']='Data Invalid';
    // }else{
    //   if ((is_countable($dataInsert)?$dataInsert:[])) { 
    //     // jika ada data yg diinput
    //     $this->db->insert_batch($this->table, $dataInsert);
    //     $jumlahInsert = $this->db->affected_rows();
    //     $msg.= $jumlahInsert.' Data Berhasil Ditambahkan | ';
    //   }

    //   if ((is_countable($dataUpdate)?$dataUpdate:[])) { 
    //     $jumlahUpdate = 0;
    //     $jumlahUpdateAll = 0;
    //     foreach ($dataUpdate as $keyUpdate => $valueUpdate) {
    //       $dataUpdateRow = $valueUpdate;

    //       $this->db->where('iduser',$valueUpdate['iduser']);
    //       $this->db->where('id_investasi',$valueUpdate['id_investasi']);
    //       $this->db->where('id_bulan',$valueUpdate['id_bulan']);
    //       $this->db->where('tahun',$valueUpdate['tahun']);
    //       $this->db->update($this->table , $dataUpdateRow);
    //       $jumlahUpdate = $this->db->affected_rows();
    //       $jumlahUpdateAll = $jumlahUpdateAll+$jumlahUpdate;
    //     }
    //     // jika ada data yg diinput
        
    //     $msg.= $jumlahUpdateAll.' Data Berhasil Diperbarui | ';
    //   }

    //   $res['error']=false;
    //   $res['msg']=$msg;
    // }
    
    

    return $res;
  }

}