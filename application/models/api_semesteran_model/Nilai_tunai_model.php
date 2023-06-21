<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nilai_tunai_model extends CI_Model {

  private $table;
  function __construct(){
    parent::__construct();
    $this->table = 'tbl_nilai_tunai_header';
    $this->tableDetail = 'tbl_nilai_tunai_detail';
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
    
      $this->db->select('id,iduser,semester,tahun,rka_penerima,rka_pembayaran');
      $this->db->where('semester',$semester);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $result = $this->db->get($this->table)->result_array();
      
      // penghubungnya
      // -id,iduser, semester,tahun, 
      foreach ($result as $key => $value) {
        $idHeader = $value['id'];
        $userHeader = $value['iduser'];
        $semesterHeader = $value['semester'];
        $tahunHeader = $value['tahun'];
        

        $this->db->select('no_urut,id_cabang,jml_penerima,jml_pembayaran');
        $this->db->where('iduser',$userHeader);
        $this->db->where('semester',$semesterHeader);
        $this->db->where('tahun',$tahunHeader);
        $this->db->where('tbl_nilai_tunai_header_id',$idHeader);
        
        $resultDetail = $this->db->get($this->tableDetail)->result_array();
        
        $result[$key]['detail'] = $resultDetail;
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
      $this->db->where('semester',$semester);
      $this->db->where('tahun',$tahun);
      $this->db->delete($this->table);
      $del = $this->db->affected_rows();
      
      if ($del) {
        $this->db->where('iduser',$user);
        $this->db->where('semester',$semester);
        $this->db->where('tahun',$tahun);
        $this->db->where_in('id_cabang',$arrCab);
        $this->db->delete($this->tableDetail);
        // $delDet = $this->db->affected_rows();
      }

      return $this->db->affected_rows();
    
  }

  public function insert($data)
  {

    $dataInsert =array();
    $dataUpdate =array();
    $arrSmt = array(1,2);
    $arrSD = array(1,2);
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
      if (in_array($id_user, $arrUSER) && in_array($smt, $arrSmt) ) {
        // jika key nya not null maka id investasi merupakan INVESTASI
        
        $cekdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun))->num_rows();
        
        if ($cekdata>0) {
          $getdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun))->row();
          $idDetail = $getdata->id;

          
          // update header
          $detail = $value['detail'];
          unset($data[$key]['detail']);
          unset($value['detail']);
          $dataUpdate=$value;
          $dataUpdate['insert_at']=$getdata->insert_at;
          $dataUpdate['update_at']=$insert_at;
          

          $this->db->where('iduser',$value['iduser']);
          $this->db->where('semester',$value['semester']);
          $this->db->where('tahun',$value['tahun']);
          $this->db->update($this->table , $dataUpdate);
          $jumlahUpdate = $this->db->affected_rows();
          // $cekdataDetail = $this->db->get_where($this->tableDetail,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun,'tbl_nilai_tunai_header_id'=>$idDetail))->num_rows();

          // if ($cekdataDetail>0) {
            $del = $this->db->delete($this->tableDetail,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun,'tbl_nilai_tunai_header_id'=>$idDetail));
            
            foreach($detail as $keyDet => $v){

                    $dataInsertDetail = array(
                      'tbl_nilai_tunai_header_id'=>$idDetail,
                       'iduser' => $id_user,
                        'semester' => $smt,
                        'tahun' => $tahun,
                        'id_cabang' => escape($v->id_cabang),
                        'jml_penerima' => escape($v->jml_penerima),
                        'jml_pembayaran' => escape($v->jml_pembayaran),
                        'insert_at' => $getdata->insert_at,
                        'update_at' => $insert_at,
                    );
                    
            
                    $this->db->insert($this->tableDetail, $dataInsertDetail);
                    if ($jumlahUpdate>0) {
                        $msg.= '<< Data Detail ke-'.$noHeader.' Berhasil Diperbarui >>';
                      }
                  }
          

          // }
          if ($jumlahUpdate>0) {
            $msg.= '<< Data Header ke-'.$noHeader.' Berhasil Diperbarui >>';
          }
        }else{
          // insert header
          $detail = $value['detail'];

          unset($data[$key]['detail']);
          unset($value['detail']);
          $dataInsert=$value;

          $dataInsert['insert_at']=$insert_at;
          
          $insert = $this->db->insert($this->table, $dataInsert);
          $idDetail = $this->db->insert_id();
          $jumlahInsert = $this->db->affected_rows();
          if ($jumlahInsert>0) {
            $msg.= '<< Data Header ke-'.$noHeader.' Berhasil Ditambahkan >>';
          }
          if ($insert) {
            
            foreach($detail as $keyDet => $v){

                    $dataInsertDetail = array(
                      'tbl_nilai_tunai_header_id'=>$idDetail,
                      'iduser' => $id_user,
                      'semester' => $smt,
                      'tahun' => $tahun,
                      'id_cabang' => escape($v->id_cabang),
                      'jml_penerima' => escape($v->jml_penerima),
                      'jml_pembayaran' => escape($v->jml_pembayaran),
                      'insert_at' => $insert_at,
                    );
                    
                    $this->db->insert($this->tableDetail, $dataInsertDetail);
                  }
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

    
    

    return $res;
  }

}