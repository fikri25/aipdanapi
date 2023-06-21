<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembayaran_pensiun_model extends CI_Model {

  private $table;
  function __construct(){
    parent::__construct();
    $this->table = 'tbl_lkao_pembayaran_pensiun_header';
    $this->tableDetail = 'tbl_lkao_pembayaran_pensiun_detail';
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
    
      $this->db->select('id,iduser,semester,tahun,id_penerima,id_kelompok,rka_penerima,rka_pembayaran,sumber_dana');
      $this->db->where('semester',$semester);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $result = $this->db->get($this->table)->result_array();
      // penghubungnya
      // -iduser, semester,tahun, id_penerima,id_kelompok,sumber_dana
      foreach ($result as $key => $value) {
        $idHeader = $value['id'];
        $userHeader = $value['iduser'];
        $semesterHeader = $value['semester'];
        $tahunHeader = $value['tahun'];
        $penerimaHeader = $value['id_penerima'];
        $kelompokHeader = $value['id_kelompok'];
        $sdHeader = $value['sumber_dana'];

        $this->db->select('id_cabang,jml_penerima,jml_pembayaran');
        $this->db->where('iduser',$userHeader);
        $this->db->where('semester',$semesterHeader);
        $this->db->where('tahun',$tahunHeader);
        $this->db->where('id_penerima',$penerimaHeader);
        $this->db->where('id_kelompok',$kelompokHeader);
        $this->db->where('sumber_dana',$sdHeader);
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

    // master kelompok
    $this->db->select('id_kelompok');
    $resKel = $this->db->get('mst_kelompok_penerima')->result_array();
    $arrKel = array();
    foreach ($resKel as $keyKel => $valueKel) {
      $arrKel[] = $valueKel['id_kelompok'];
    }

    // master jenis penerima
    $this->db->select('id_penerima');
    $resPen = $this->db->get('mst_jenis_penerima')->result_array();
    $arrPen = array();
    foreach ($resPen as $keyPen => $valuePen) {
      $arrPen[] = $valuePen['id_penerima'];
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
      $id_penerima = $value['id_penerima'];
      $id_kelompok = $value['id_kelompok'];
      $sd = $value['sumber_dana'];


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
      if (in_array($id_user, $arrUSER) && in_array($smt, $arrSmt) && in_array($id_penerima, $arrPen) && in_array($id_kelompok, $arrKel) && in_array($sd, $arrSD)) {
        // jika key nya not null maka id investasi merupakan INVESTASI
        
        $cekdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun,'id_penerima'=>$id_penerima,'id_kelompok'=>$id_kelompok))->num_rows();
        
        if ($cekdata>0) {
          $getdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun,'id_penerima'=>$id_penerima,'id_kelompok'=>$id_kelompok))->row();

          
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
          $this->db->where('id_penerima',$value['id_penerima']);
          $this->db->where('id_kelompok',$value['id_kelompok']);
          $this->db->update($this->table , $dataUpdate);
          $jumlahUpdate = $this->db->affected_rows();
          $cekdataDetail = $this->db->get_where($this->tableDetail,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun,'id_penerima'=>$id_penerima,'id_kelompok'=>$id_kelompok))->num_rows();
          if ($cekdataDetail>0) {
            $del = $this->db->delete($this->tableDetail,array('iduser'=>$id_user,'semester'=>$smt,'tahun'=>$tahun,'id_penerima'=>$id_penerima,'id_kelompok'=>$id_kelompok));
            
            
            foreach($detail as $keyDet => $v){

                    $dataInsertDetail = array(
                       'iduser' => $id_user,
                        'semester' => $smt,
                        'tahun' => $tahun,
                        'id_cabang' => escape($v->id_cabang),
                        'id_penerima' => $id_penerima,
                        'id_kelompok' => $id_kelompok,
                        'jml_penerima' => escape($v->jml_penerima),
                        'jml_pembayaran' => escape($v->jml_pembayaran),
                        'sumber_dana' => $sd,
                        'insert_at' => $getdata->insert_at,
                        'update_at' => $insert_at,
                    );
                    
                    $this->db->insert($this->tableDetail, $dataInsertDetail);
                    if ($jumlahUpdate>0) {
                        $msg.= '<< Data Detail ke-'.$noHeader.' Berhasil Diperbarui >>';
                      }
                  }
          

          }
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
          $jumlahInsert = $this->db->affected_rows();
          if ($jumlahInsert>0) {
            $msg.= '<< Data Header ke-'.$noHeader.' Berhasil Ditambahkan >>';
          }
          if ($insert) {
            
            foreach($detail as $keyDet => $v){

                    $dataInsertDetail = array(
                      'iduser' => $id_user,
                      'semester' => $smt,
                      'tahun' => $tahun,
                      'id_cabang' => escape($v->id_cabang),
                      'id_penerima' => $id_penerima,
                      'id_kelompok' => $id_kelompok,
                      'jml_penerima' => escape($v->jml_penerima),
                      'jml_pembayaran' => escape($v->jml_pembayaran),
                      'sumber_dana' => $sd,
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