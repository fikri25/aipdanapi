<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_investasi_model extends CI_Model {

  private $table;
  function __construct(){
    parent::__construct();
    $this->table = 'bln_aset_investasi_header';
    $this->tableDetail = 'bln_aset_investasi_detail';
    $this->tableMaster = 'mst_investasi';
    date_default_timezone_set('Asia/Jakarta');
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
    $id = $this->db->get_where('mst_investasi',array('mst_investasi.group'=>'INVESTASI','mst_investasi.iduser'=>$user))->result_array();
    
    $arrID = array();
    foreach ($id as $key => $value) {
      $arrID[] = $value['id_investasi'];
    }

      $this->db->select('id,iduser,id_investasi,id_bulan,tahun,saldo_awal_invest,mutasi_invest,saldo_akhir_invest,rka,realisasi_rka,target_yoi,keterangan');
      $this->db->where('id_bulan',$bulan);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $this->db->where_in('id_investasi',$arrID);
      $result = $this->db->get($this->table)->result_array();
      foreach ($result as $key => $value) {
        $idHeader = $value['id'];
        $this->db->select('kode_pihak,saldo_awal,mutasi_pembelian,mutasi_penjualan,mutasi_amortisasi,mutasi_pasar,mutasi_penanaman,mutasi_pencairan,mutasi_nilai_wajar,mutasi_diskonto,saldo_akhir,lembar_saham,manager_investasi,harga_saham,nama_reksadana,jml_unit_reksadana,persentase,peringkat,tgl_jatuh_tempo,r_kupon,nama_produk,jml_unit_penyertaan,cabang,bunga,nilai_perolehan,jenis_reksadana,nilai_kapitalisasi_pasar,nilai_dana_kelolaan');
        $this->db->where('id_bulan',$bulan);
        $this->db->where('tahun',$tahun);
        $this->db->where('iduser',$user);
        $this->db->where_in('bln_aset_investasi_header_id',$idHeader);
        $resultDetail = $this->db->get($this->tableDetail)->result_array();
        $result[$key]['detail'] = $resultDetail;
        unset($result[$key]['id']);
      }
      return $result;
    
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
    $id = $this->db->get_where('mst_investasi',array('mst_investasi.group'=>'INVESTASI','mst_investasi.iduser'=>$user))->result_array();
    $arrID = array();
    foreach ($id as $key => $value) {
      $arrID[] = $value['id_investasi'];
    }

      
      $this->db->where('id_bulan',$bulan);
      $this->db->where('tahun',$tahun);
      $this->db->where('iduser',$user);
      $this->db->where_in('id_investasi',$arrID);
      $this->db->delete($this->table);
      $del = $this->db->affected_rows();
      
      if ($del) {
        $this->db->where('id_bulan',$bulan);
        $this->db->where('tahun',$tahun);
        $this->db->where('iduser',$user);
        $this->db->delete($this->tableDetail);
        // $delDet = $this->db->affected_rows();
      }

      return $this->db->affected_rows();
    
  }

  public function insert($data)
  {
    $dataInsert =array();
    $dataUpdate =array();
    $arrBulan = array(1,2,3,4,5,6,7,8,9,10,11,12);

    $this->db->select('id_investasi');
    $id = $this->db->get_where('mst_investasi',array('mst_investasi.group'=>'INVESTASI'))->result_array();
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
    $msg='-- Trans Begin --';
    $noHeader = 0;
    foreach ($data as $key => $value) {
      $noHeader++;
      $noDetail = 0;
      $id_investasi = $value['id_investasi'];
      $id_bulan = $value['id_bulan'];
      $id_user = $value['iduser'];
      $tahun = $value['tahun'];
      $detail = array();

      // cek data id investasi
      if (in_array($id_investasi, $arrID) && in_array($id_user, $arrUSER) && in_array($id_bulan, $arrBulan)) {
        // jika key nya not null maka id investasi merupakan INVESTASI
        
        $cekdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'id_investasi'=>$id_investasi,'id_bulan'=>$id_bulan,'tahun'=>$tahun))->num_rows();
        
        if ($cekdata>0) {
          $getdata = $this->db->get_where($this->table,array('iduser'=>$id_user,'id_investasi'=>$id_investasi,'id_bulan'=>$id_bulan,'tahun'=>$tahun))->row();
          $idDetail = $getdata->id;
          
          // update header
          $detail = $value['detail'];
          unset($data[$key]['detail']);
          unset($value['detail']);
          $dataUpdate=$value;
          

          $this->db->where('iduser',$value['iduser']);
          $this->db->where('id_investasi',$value['id_investasi']);
          $this->db->where('id_bulan',$value['id_bulan']);
          $this->db->where('tahun',$value['tahun']);
          $this->db->update($this->table , $dataUpdate);
          $jumlahUpdate = $this->db->affected_rows();
          $cekdataDetail = $this->db->get_where($this->tableDetail,array('iduser'=>$id_user,'bln_aset_investasi_header_id'=>$idDetail,'id_bulan'=>$id_bulan,'tahun'=>$tahun))->num_rows();
          if ($cekdataDetail>0) {
            $del = $this->db->delete($this->tableDetail,array('iduser'=>$id_user,'bln_aset_investasi_header_id'=>$idDetail,'id_bulan'=>$id_bulan,'tahun'=>$tahun));
            
            
            foreach($detail as $keyDet => $v){

                    $dataInsertDetail = array(
                      'bln_aset_investasi_header_id' => $idDetail,
                      'id_bulan' => $id_bulan,
                      'iduser' => $id_user,
                      'tahun' => $tahun,
                      'kode_pihak' => escape($v->kode_pihak),
                      'saldo_awal' => escape($v->saldo_awal),
                      'mutasi_pembelian' => escape($v->mutasi_pembelian),
                      'mutasi_penjualan' => escape($v->mutasi_penjualan),
                      'mutasi_amortisasi' => escape($v->mutasi_amortisasi),
                      'mutasi_pasar' => escape($v->mutasi_pasar),
                      'mutasi_penanaman' => escape($v->mutasi_penanaman),
                      'mutasi_nilai_wajar' => escape($v->mutasi_nilai_wajar),
                      'mutasi_pencairan' => escape($v->mutasi_pencairan),
                      'mutasi_diskonto' => escape($v->mutasi_diskonto),
                      'saldo_akhir' => escape($v->saldo_akhir),
                      'lembar_saham' => escape($v->lembar_saham),
                      'manager_investasi' => escape($v->manager_investasi),
                      'harga_saham' => escape($v->harga_saham),
                      'nama_reksadana' => escape($v->nama_reksadana),
                      'jml_unit_reksadana' => escape($v->jml_unit_reksadana),
                      'persentase' => escape($v->persentase),
                      'peringkat' => escape($v->peringkat),
                      'tgl_jatuh_tempo' => escape($v->tgl_jatuh_tempo),
                      'r_kupon' => escape($v->r_kupon),
                      'nama_produk' => escape($v->nama_produk),
                      'jml_unit_penyertaan' => escape($v->jml_unit_penyertaan),
                      'cabang' => escape($v->cabang),
                      'bunga' => escape($v->bunga),
                      'nilai_perolehan' => escape($v->nilai_perolehan),
                      'jenis_reksadana' => escape($v->jenis_reksadana),
                      'nilai_kapitalisasi_pasar' => escape($v->nilai_kapitalisasi_pasar),
                      'nilai_dana_kelolaan' => escape($v->nilai_dana_kelolaan),
                      'insert_at' => date('Y-m-d H:i:s'),
                    );
                    
                    $this->db->insert('bln_aset_investasi_detail', $dataInsertDetail);
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
          $insert = $this->db->insert($this->table, $dataInsert);
          $idDetail = $this->db->insert_id();
          $jumlahInsert = $this->db->affected_rows();
          if ($jumlahInsert>0) {
            $msg.= '<< Data Header ke-'.$noHeader.' Berhasil Ditambahkan >>';
          }
          if ($insert) {
            
            foreach($detail as $keyDet => $v){

                    $dataInsertDetail = array(
                      'bln_aset_investasi_header_id' => $idDetail,
                      'id_bulan' => $id_bulan,
                      'iduser' => $id_user,
                      'tahun' => $tahun,
                      'kode_pihak' => escape($v->kode_pihak),
                      'saldo_awal' => escape($v->saldo_awal),
                      'mutasi_pembelian' => escape($v->mutasi_pembelian),
                      'mutasi_penjualan' => escape($v->mutasi_penjualan),
                      'mutasi_amortisasi' => escape($v->mutasi_amortisasi),
                      'mutasi_pasar' => escape($v->mutasi_pasar),
                      'mutasi_penanaman' => escape($v->mutasi_penanaman),
                      'mutasi_nilai_wajar' => escape($v->mutasi_nilai_wajar),
                      'mutasi_pencairan' => escape($v->mutasi_pencairan),
                      'mutasi_diskonto' => escape($v->mutasi_diskonto),
                      'saldo_akhir' => escape($v->saldo_akhir),
                      'lembar_saham' => escape($v->lembar_saham),
                      'manager_investasi' => escape($v->manager_investasi),
                      'harga_saham' => escape($v->harga_saham),
                      'nama_reksadana' => escape($v->nama_reksadana),
                      'jml_unit_reksadana' => escape($v->jml_unit_reksadana),
                      'persentase' => escape($v->persentase),
                      'peringkat' => escape($v->peringkat),
                      'tgl_jatuh_tempo' => escape($v->tgl_jatuh_tempo),
                      'r_kupon' => escape($v->r_kupon),
                      'nama_produk' => escape($v->nama_produk),
                      'jml_unit_penyertaan' => escape($v->jml_unit_penyertaan),
                      'cabang' => escape($v->cabang),
                      'bunga' => escape($v->bunga),
                      'nilai_perolehan' => escape($v->nilai_perolehan),
                      'jenis_reksadana' => escape($v->jenis_reksadana),
                      'nilai_kapitalisasi_pasar' => escape($v->nilai_kapitalisasi_pasar),
                      'nilai_dana_kelolaan' => escape($v->nilai_dana_kelolaan),
                      'insert_at' => date('Y-m-d H:i:s'),
                    );
                    
                    $this->db->insert('bln_aset_investasi_detail', $dataInsertDetail);
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