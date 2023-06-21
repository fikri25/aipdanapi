<?php 
    if ( !defined('BASEPATH')) exit('No direct script access allowed');
    
class Statistik_model extends CI_Model {
    
    function __construct(){
      parent::__construct();
      $this->level = $this->session->userdata('level');
      $this->tahun = $this->session->userdata('tahun');
      $this->tahun_prev = $this->session->userdata('tahun')-1;
      if($this->level === "DJA"){
        $this->iduser = "TSN002";
      }else{
        $this->iduser = $this->session->userdata('iduser');
      }
    }

    private function getIdHI() {
        $this->db->select('id_investasi');
        $this->db->from('dbsmartaip_'.$this->tahun.'.mst_jenis_investasi');
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $r) {
            array_push($data, $r->id_investasi);
        }
        return $data;
    }

    public function getTableHI() {
        $arrBln = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $arrJI = $this->getIdHI();
        $this->db->select('sum(rka) as trka, sum(saldo_akhir) as sa, sum(realisasi_rka) as rrka');
        $this->db->from('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where_in('id_investasi', $arrJI);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $rs){
            array_push($data, $rs->trka, $rs->sa, $rs->rrka);
        }
        return $data;
    }

    public function getSumInvest() {
        $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.saldo_akhir) as saldo_akhir,sum(a.mutasi) as mutasi,sum(a.rka) as rka FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a 
            LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) 
            WHERE a.id_investasi IN (select id_investasi from mst_jenis_investasi) 
            AND a.iduser='".$this->iduser."' 
            AND a.id_bulan BETWEEN 1 and 10 group by a.id_investasi");
        // echo $this->db->last_query();exit;
        return $query->result();
    }


    public function getSumProporsiAset() {
        $arrJenis = $arrJI = $this->getIdHI();
        $arrBln = array(1,2,3,4,5,6,7,8,9,10,11,12);

        $this->db->select('sum(saldo_akhir) as total');
        $this->db->from('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where_in('id_investasi', $arrJenis);
        $this->db->where_in('id_bulan', $arrBln);
        $this->db->group_by('id_investasi');
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $r) {
            array_push($data, $r->total);
        }
        return $data;
    }

    public function getRadiusBulan() {
        $dt = new DateTime();
        $thn = $this->session->userdata('tahun');
        $bln = date('n');
        $hr = date('d');
        $data = array();
        for ($i=12; $i >= 0; $i--) {
            $dt->setDate($thn, $bln-$i, $hr);
            array_push($data, $dt->format('M Y'));
        }
        return $data;
    }

    public function getKomposisiDeposito() {
        $arrBln = array();
        $skrg = date('n');
        for($i=$skrg; $i < 13; $i++) {
            array_push($arrBln, $i);
        }
        $arrSelBln = array();
        for($j=$skrg; $j <= $skrg; $j++) {
            array_push($arrSelBln, $j);
        }
        $intsct = array_intersect($arrBln, $arrSelBln);
        $thnl = $this->session->userdata('tahun') - 1;
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$thnl.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 2);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $res) {
            array_push($data, $res->saldo_akhir);
        }
        $data2 = array();
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 2);
        $this->db->where_in('id_bulan', $intsct);
        $query2 = $this->db->get();
        foreach($query2->result() as $res2) {
            array_push($data2, $res2->saldo_akhir);
        }
        $hasil = array_merge($data, $data2);
        return $hasil;
    }

    public function getKomposisiSBN() {
        $arrBln = array();
        $skrg = date('n');
        for($i=$skrg; $i < 13; $i++) {
            array_push($arrBln, $i);
        }
        $arrSelBln = array();
        for($j=$skrg; $j <= $skrg; $j++) {
            array_push($arrSelBln, $j);
        }
        $intsct = array_intersect($arrBln, $arrSelBln);
        $thnl = $this->session->userdata('tahun') - 1;
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$thnl.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 1);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $res) {
            array_push($data, $res->saldo_akhir);
        }
        $data2 = array();
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$this->session->userdata('tahun').'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 1);
        $this->db->where_in('id_bulan', $intsct);
        $query2 = $this->db->get();
        foreach($query2->result() as $res2) {
            array_push($data2, $res2->saldo_akhir);
        }
        $hasil = array_merge($data, $data2);
        return $hasil;
    }

    public function getKomposisiObKorporasi() {
        $arrBln = array();
        $skrg = date('n');
        for($i=$skrg; $i < 13; $i++) {
            array_push($arrBln, $i);
        }
        $arrSelBln = array();
        for($j=$skrg; $j <= $skrg; $j++) {
            array_push($arrSelBln, $j);
        }
        $intsct = array_intersect($arrBln, $arrSelBln);
        $thnl = $this->session->userdata('tahun') - 1;
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$thnl.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 4);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $res) {
            array_push($data, $res->saldo_akhir);
        }
        $data2 = array();
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$this->session->userdata('tahun').'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 4);
        $this->db->where_in('id_bulan', $intsct);
        $query2 = $this->db->get();
        foreach($query2->result() as $res2) {
            array_push($data2, $res2->saldo_akhir);
        }
        $hasil = array_merge($data, $data2);
        return $hasil;
    }

    public function getKomposisiSaham() {
        $arrBln = array();
        $skrg = date('n');
        for($i=$skrg; $i < 13; $i++) {
            array_push($arrBln, $i);
        }
        $arrSelBln = array();
        for($j=$skrg; $j <= $skrg; $j++) {
            array_push($arrSelBln, $j);
        }
        $intsct = array_intersect($arrBln, $arrSelBln);
        $thnl = $this->session->userdata('tahun') - 1;
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$thnl.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 3);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $res) {
            array_push($data, $res->saldo_akhir);
        }
        $data2 = array();
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$this->session->userdata('tahun').'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 3);
        $this->db->where_in('id_bulan', $intsct);
        $query2 = $this->db->get();
        foreach($query2->result() as $res2) {
            array_push($data2, $res2->saldo_akhir);
        }
        $hasil = array_merge($data, $data2);
        return $hasil;
    }

    public function getKomposisiReksa() {
        $arrBln = array();
        $skrg = date('n');
        for($i=$skrg; $i < 13; $i++) {
            array_push($arrBln, $i);
        }
        $arrSelBln = array();
        for($j=$skrg; $j <= $skrg; $j++) {
            array_push($arrSelBln, $j);
        }
        $intsct = array_intersect($arrBln, $arrSelBln);
        $thnl = $this->session->userdata('tahun') - 1;
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$thnl.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 7);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $res) {
            array_push($data, $res->saldo_akhir);
        }
        $data2 = array();
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$this->session->userdata('tahun').'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 7);
        $this->db->where_in('id_bulan', $intsct);
        $query2 = $this->db->get();
        foreach($query2->result() as $res2) {
            array_push($data2, $res2->saldo_akhir);
        }
        $hasil = array_merge($data, $data2);
        return $hasil;
    }

    public function getKomposisiPenyel() {
        $arrBln = array();
        $skrg = date('n');
        for($i=$skrg; $i < 13; $i++) {
            array_push($arrBln, $i);
        }
        $arrSelBln = array();
        for($j=$skrg; $j <= $skrg; $j++) {
            array_push($arrSelBln, $j);
        }
        $intsct = array_intersect($arrBln, $arrSelBln);
        $thnl = $this->session->userdata('tahun') - 1;
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$thnl.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 8);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $res) {
            array_push($data, $res->saldo_akhir);
        }
        $data2 = array();
        $this->db->select('saldo_akhir');
        $this->db->from('dbsmartaip_'.$this->session->userdata('tahun').'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where('id_investasi', 8);
        $this->db->where_in('id_bulan', $intsct);
        $query2 = $this->db->get();
        foreach($query2->result() as $res2) {
            array_push($data2, $res2->saldo_akhir);
        }
        $hasil = array_merge($data, $data2);
        return $hasil;
    }

    public function getSumKomposisi_Penyertaan() {
        // $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.realisasi_rka) as realisasi FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (8) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10 group by a.id_investasi, a.id_bulan");
        // echo $this->db->last_query();exit;
        $arrJenis = $arrJI = $this->getIdHI();
        $arrBln = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $this->db->select('sum(saldo_akhir) as total');
        $this->db->from('dbsmartaip_'.$this->tahun.'bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where_in('id_investasi', $arrJenis);
        $this->db->where_in('id_bulan', $arrBln);
        $this->db->group_by('id_investasi');
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $r) {
            array_push($data, $r->total);
        }
        return $data;
    }

    public function dataTabelPertama() {
        $arrJenis = $this->getIdHI();
        $arrBln = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $this->db->select('sum(rka) as trka, sum(saldo_akhir) as tsa');
        $this->db->from('dbsmartaip_'.$this->tahun.'.bln_posisi_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where_in('id_investasi', $arrJenis);
        $this->db->where_in('id_bulan', $arrBln);
        $query = $this->db->get();
        $dataRka = array();
        foreach($query->result() as $r) {
            array_push($dataRka, $r->trka);
        }
        $dataSa = array();
        foreach($query->result() as $s) {
            array_push($dataSa, $s->tsa);
        }
        $this->db->select('sum(rka) as trka2, sum(saldo_akhir) as tsa2');
        $this->db->from('dbsmartaip_'.$this->tahun.'.bln_hasil_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where_in('id_jns_investasi', $arrJenis);
        $this->db->where_in('id_bulan', $arrBln);
        $query2 = $this->db->get();
        $dataRka2 = array();
        foreach($query2->result() as $r) {
            array_push($dataRka2, $r->trka2);
        }
        $dataSa2 = array();
        foreach($query2->result() as $s) {
            array_push($dataSa2, $s->tsa2);
        }
        $dataMerge1 = array_merge($dataRka, $dataSa);
        $dataMerge2 = array_merge($dataRka2, $dataSa2);
        $totalMerge = array_merge($dataMerge1, $dataMerge2);
        return $totalMerge;
    }

    public function getSumHasilInvest() {
        // $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi, sum(a.realisasi_rka) as realisasi FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10 group by id_bulan");
        // return $query->result();
        $arrJenis = array(1,2,3,4,5,6,7,8);
        $arrBln = array(1,2,3,4,5,6,7,8,9,10,11,12);

        $this->db->select('sum(saldo_akhir) as sa');
        $this->db->from('dbsmartaip_'.$this->tahun.'.bln_hasil_investasi');
        $this->db->where('iduser', $this->iduser);
        $this->db->where_in('id_jns_investasi', $arrJenis);
        $this->db->where_in('id_bulan', $arrBln);
        $this->db->group_by('id_bulan');
        $this->db->order_by('id_bulan', 'asc');
        $query = $this->db->get();
        $data = array();
        foreach($query->result() as $r) {
            array_push($data, $r->sa);
        }
        $selisih = count($arrBln) - count($data);
        $dt = array();
        if($selisih > 0) {
            for($i=0; $i<$selisih; $i++) {
                array_push($dt, 0);
            }
            $data = array_merge($data, $dt);
        }
        return $data;

    }

    public function getSumKomposisi_deposito() {
        $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.realisasi_rka) as realisasi FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (2) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10 group by a.id_investasi, a.id_bulan");
        // echo $this->db->last_query();exit;
        return $query->result();
    }

    public function getSumKomposisi_obligasi() {
        $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.realisasi_rka) as realisasi FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (4) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10 group by a.id_investasi, a.id_bulan");
        // echo $this->db->last_query();exit;
        return $query->result();
    }

    public function getSumKomposisi_sbn() {
        $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.realisasi_rka) as realisasi FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (1) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10 group by a.id_investasi, a.id_bulan");
        // echo $this->db->last_query();exit;
        return $query->result();
    }

    public function getSumKomposisi_shm() {
        $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.realisasi_rka) as realisasi FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (3) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10 group by a.id_investasi, a.id_bulan");
        // echo $this->db->last_query();exit;
        return $query->result();
    }

    public function getSumKomposisi_rek() {
        $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.realisasi_rka) as realisasi FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (7) AND iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10 group by a.id_investasi, a.id_bulan");
        // echo $this->db->last_query();exit;
        return $query->result();
    }

    public function getSumTotalInvest() {
        $query = $this->db->query("SELECT a.id, a.id_investasi, b.jenis_investasi ,sum(a.saldo_akhir) as saldo_akhir FROM dbsmartaip_".$this->tahun.".bln_posisi_investasi a LEFT JOIN mst_jenis_investasi b ON (a.id_investasi = b.id_investasi) WHERE a.id_investasi IN (select id_investasi from mst_jenis_investasi) AND a.iduser='".$this->iduser."' AND a.id_bulan BETWEEN 1 and 10");
        // echo $this->db->last_query();exit;
        return $query->result();
    }


    public function get_sum_hasil_invest() {
        $query = $this->db->query('SELECT sum(rka) as rka,sum(saldo_akhir_smt1) as smt_1,sum(saldo_akhir_smt2) as smt_2,sum(saldo_akhir_th) as thn FROM dbsmartaip_'.$this->tahun.'.tb_lkak_perubahan_dana_bersih WHERE id_sub_level_2 IN(1,2,3,4,5,6,7,0) AND iduser="'.$this->iduser.'"');
        return $query->result();
    }

    public function get_beban_investasi() {
        $this->db->select('*');
        $this->db->from('dbsmartaip_'.$this->tahun.'.tb_lkak_perubahan_dana_bersih');
        $this->db->where('iduser',$this->iduser);
        $this->db->like('nama_sub_level_1', 'Beban Investasi');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_beban_operasional() {
        $this->db->select('*');
        $this->db->from('dbsmartaip_'.$this->tahun.'.tb_lkak_perubahan_dana_bersih');
        $this->db->where('iduser',$this->iduser);
        $this->db->like('nama_sub_level_1', 'Beban Operasional');
        $query = $this->db->get();
        return $query->result();
    }

    // get data ke tahun sebelumnya (tahun-1)
    public function get_sumPrev_hasil_invest() {
        $query = $this->db->query('SELECT sum(rka) as rka,sum(saldo_akhir_smt1) as smt_1,sum(saldo_akhir_smt2) as smt_2,sum(saldo_akhir_th) as thn FROM dbsmartaip_'.$this->tahun_prev.'.tb_lkak_perubahan_dana_bersih WHERE id_sub_level_2 IN(1,2,3,4,5,6,7,0) AND iduser="'.$this->iduser.'"');
        return $query->result();
    }

    public function get_bebanPrev_investasi() {
        $this->db->select('*');
        $this->db->from('dbsmartaip_'.$this->tahun_prev.'.tb_lkak_perubahan_dana_bersih');
        $this->db->where('iduser',$this->iduser);
        $this->db->like('nama_sub_level_1', 'Beban Investasi');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_bebanPrev_operasional() {
        $this->db->select('*');
        $this->db->from('dbsmartaip_'.$this->tahun_prev.'.tb_lkak_perubahan_dana_bersih');
        $this->db->where('iduser',$this->iduser);
        $this->db->like('nama_sub_level_1', 'Beban Operasional');
        $query = $this->db->get();
        return $query->result();
    }

}
