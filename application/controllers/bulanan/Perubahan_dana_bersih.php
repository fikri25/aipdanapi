<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perubahan_dana_bersih extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('bulanan_model/perubahan_dana_bersih_model');
        $this->load->model('bulanan_model/dana_bersih_model');
        $this->load->model('bulanan_model/aset_investasi_model');
		
        $this->load->library('form_validation');
        $this->load->library('user_agent');
		// $this->load->library('pdf');
		//cek login
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		$userData=$this->session->userdata();
		//cek akses route
		// if($userData['idusergroup'] !== '001') show_404();
        $this->iduser = $this->session->userdata('iduser');
		$this->tahun = $this->session->userdata('tahun');
		$this->page_limit = 20;
		
	}
	
	
	public function index(){
		$data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
        $data['tot_perubahan'] = $this->aset_investasi_model->getdata('perubahan_danabersih_lv1','result');
        $data['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv0','result');

        $data['data_perubahan_dana_bersih_ket'] = $this->perubahan_dana_bersih_model->get_ket('ket_perubahan_dana_bersih');

        $data['opt_user'] = dtuser();
        $data['bulan'] = bulan();
        $data['bulan_prev'] = bulan_prev();
		
		$data['bread'] = array('header'=>'Perubahan Dana Bersih ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Perubahan Dana Bersih');
		$data['view']  = "bulanan/perubahan_dana_bersih/index_perubahan_danabersih";
		$this->load->view('main/utama', $data);
    }

    public function beban_investasi(){
        $data['opt_user'] = dtuser();
        $data['bulan'] = bulan();
        $data['bulan_prev'] = bulan_prev();
        $data['data_beban'] = $this->nilai_beban_investasi();
        $data['sum'] = $this->sum_nilai_beban_investasi();

        $data['data_beban_investasi_ket'] = $this->perubahan_dana_bersih_model->get_ket('ket_beban_investasi');
        
        $data['bread'] = array('header'=>'Beban Investasi ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Beban Investasi');
        $data['view']  = "bulanan/perubahan_dana_bersih/index_beban_investasi";
        $this->load->view('main/utama', $data);
    }

     function cetak($mod=""){
        
        switch($mod){
            case "perubahan_danabersih_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['bulan'] = bulan();
                $data['opt_user'] = dtuser();
                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
                $data['data_perubahan_dana_bersih_ket'] = $this->perubahan_dana_bersih_model->get_ket('ket_perubahan_dana_bersih');
                $data['tot_perubahan'] = $this->aset_investasi_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv0','result');
                $template=$this->load->view('bulanan/perubahan_dana_bersih/index_pdf_export', $data,true);  
                // print_r($data);exit;
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case "beban_investasi_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['bulan'] = bulan();
                $data['opt_user'] = dtuser();
                $data['data_beban'] = $this->nilai_beban_investasi();
                $data['sum'] = $this->perubahan_dana_bersih_model->getdata('aset_investasi_front_sum', 'row_array', 'BEBAN INVESTASI');

                $template=$this->load->view('bulanan/perubahan_dana_bersih/index_beban_pdf_export', $data,true);  
                // print_r($data);exit;
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
        }
        
    }
    
    function hasil_output($p1,$mod,$data_detail,$data,$filename="",$ukuran="A4",$template="",$footer="", $header=""){
        switch($p1){
            case "pdf":
                // print_r($data);exit;
                // For PHP 7.4
                $pdf = new \Mpdf\Mpdf();
                $pdf->WriteHTML($template,2);
                $pdf->Output();


                // $this->load->library('m_pdf');
                // $pdf=$this->m_pdf->load();
                // $pdf->SetDisplayMode('fullpage');
                // $pdf->setFooter('{PAGENO}');
                // $pdf->simpleTables = true;
                // $pdf->packTableData = true;
                // $keep_table_proportions = TRUE;
                // $shrink_tables_to_fit = 1;
                // $pdf->use_kwt=true; //pagebreak
                // $pdf->SetTitle($title);
                // $pdf->WriteHTML($template,2);

                // $pdf->Output();
            break;
        }
    }


    function get_index($mod){
        switch($mod){
            case 'index-perubahan-danabersih':
                $data['iduser'] = $this->input->post('iduser');
                $data['id_bulan'] = $this->input->post('id_bulan');

                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
                $data['tot_perubahan'] = $this->aset_investasi_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv0','result');

                $data['data_perubahan_dana_bersih_ket'] = $this->perubahan_dana_bersih_model->get_ket('ket_perubahan_dana_bersih');

                $data['opt_user'] = dtuser();
                $data['bulan'] = bulan();
                $data['bulan_prev'] = bulan_prev();
                $data['bread'] = array('header'=>'Perubahan Dana Bersih ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Perubahan Dana Bersih');
                $data['view']  = "bulanan/perubahan_dana_bersih/index_perubahan_danabersih";

                // print_r($filter);exit;
            break;
            case 'index-beban-investasi':
                $data['iduser'] = $this->input->post('iduser');
                $data['id_bulan'] = $this->input->post('id_bulan');

                $data['data_beban'] = $this->nilai_beban_investasi();
                $data['sum'] = $this->perubahan_dana_bersih_model->getdata('aset_investasi_front_sum', 'row_array', 'BEBAN INVESTASI');

                $data['data_beban_investasi_ket'] = $this->perubahan_dana_bersih_model->get_ket('ket_beban_investasi');
                
                $data['opt_user'] = dtuser();
                $data['bulan'] = bulan();
                $data['bulan_prev'] = bulan_prev();
                $data['bread'] = array('header'=>'Beban Investasi ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Beban Investasi');
                $data['view']  = "bulanan/perubahan_dana_bersih/index_beban_investasi";

                // print_r($filter);exit;
            break;
        }

        $data['mod'] = $mod;
        $data['acak'] = md5(date('H:i:s'));
        // echo '<pre>';
        // print_r($data);exit;
        $dt = $this->load->view($data['view'], $data, TRUE);
        echo $dt;
    }

    function get_form($mod){
        $sts = $this->input->post('editstatus');
        if(isset($sts)){
            $data['editstatus'] = $sts;
        }else{
            $data['editstatus'] = "";
        }
        switch($mod){
            case 'beban_investasi':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->aset_investasi_model->getdata('data_header_beban_investasi', 'row_array', $id);
                    $data_detail = $this->aset_investasi_model->getdata('data_detail_beban_investasi', 'result_array', $id);
                    $combo_detail_beban = $this->aset_investasi_model->get_combo('combo_detail_beban_investasi', $id);

                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    $data['combo_detail_beban'] = $combo_detail_beban;
                    // echo '<pre>';
                    // print_r($data);exit;
                }

                $data['combo'] = $this->aset_investasi_model->get_combo('combo_beban_investasi');
                $data['bread'] = array('header'=>'Beban Investasi', 'subheader'=>'Beban Investasi');
                $data['view']  = "bulanan/perubahan_dana_bersih/input_beban_investasi";
            break;
            case 'perubahan_dana_bersih':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->aset_investasi_model->getdata('data_perubahan_danabersih_header', 'row_array', $id);
                    $data_detail = $this->aset_investasi_model->getdata('data_perubahan_danabersih_header', 'result_array', $id);
                    $combo_detail_beban = $this->aset_investasi_model->getdata('mst_jenis_investasi_iuran_beban', 'result_array', $id);

                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    $data['combo_detail_beban'] = $combo_detail_beban;
                    // echo '<pre>';
                    // print_r($data);exit;
                }
               
                $data['data_perubahan'] = $this->aset_investasi_model->getdata('mst_perubahan_danabersih', 'result');
                $data['bread'] = array('header'=>'Perubahan Dana Bersih', 'subheader'=>'Perubahan Dana Bersih');
                $data['view']  = "bulanan/perubahan_dana_bersih/input_iuran_beban";
            break;
        }
        $data['editstatus'] = $this->input->post('editstatus');
        $data['mod'] = $mod;
        $data['acak'] = md5(date('H:i:s'));
        // echo '<pre>';
        // print_r($data);exit;
        $dt = $this->load->view($data['view'], $data, TRUE);
        echo $dt;
    }

    public function nilai_perubahan_danabersih(){
        $array = array();
        $perubahan_lv1 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv1','result_array');
        foreach ($perubahan_lv1 as $k => $v) {

            if($v['uraian'] == 'PENAMBAHAN'){
                $judul_total = 'Jumlah Penambahan';
                $judul_head = 'PENAMBAHAN';
            }else if($v['uraian'] == 'PENGURANGAN'){
                $judul_total = 'Jumlah Pengurangan';
                $judul_head = 'PENGURANGAN';
            }

            $array[$k]['judul_head'] = $judul_head;
            $array[$k]['judul_total'] = $judul_total;
            $array[$k]['uraian'] = $v['uraian'];
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_bln_lalu']) ? $v['saldo_akhir_bln_lalu'] : 0) ;
            $array[$k]['child'] = array();

            $perubahan_lv2 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv2','result_array', $v['uraian']);
            foreach ($perubahan_lv2 as $key => $val) {
                if($val['group'] == 'BEBAN'){
                    $judul_total = 'Total Beban';
                    $judul_head = 'BEBAN';
                }else if($val['group'] == 'HASIL INVESTASI'){
                    $judul_total = 'Total Hasil Investasi';
                    $judul_head = 'HASIL INVESTASI';
                }else if($val['group'] == 'IURAN'){
                    $judul_total = 'Total Iuran';
                    $judul_head = 'IURAN';
                }else if($val['group'] == 'NILAI INVESTASI'){
                    $judul_total = 'Jumlah Peningkatan(Penurunan)';
                    $judul_head = 'NILAI INVESTASI';
                }else if($val['group'] == 'ASET TETAP'){
                    $judul_total = 'Sub Jumlah Aset Tetap';
                    $judul_head = 'ASET TETAP';
                }

                $array[$k]['child'][$key]['judul_head'] =  $judul_head;
                $array[$k]['child'][$key]['judul_total'] = $judul_total;
                $array[$k]['child'][$key]['id_perubahan_dana_bersih'] = $val['id_perubahan_dana_bersih'];
                $array[$k]['child'][$key]['group'] = $val['group'];
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir']) ? $val['saldo_akhir'] : 0) ;
                $array[$k]['child'][$key]['sum_prev_lvl2'] =  (isset($val['saldo_akhir_bln_lalu']) ? $val['saldo_akhir_bln_lalu'] : 0) ;
                $array[$k]['child'][$key]['subchild'] = array();

                $perubahan_lv3 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv3','result_array', $val['group']);
                foreach ($perubahan_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = (isset($y['saldo_akhir']) ? $y['saldo_akhir'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_bln_lalu'] = (isset($y['saldo_akhir_bln_lalu']) ? $y['saldo_akhir_bln_lalu'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type'] == 'PC'){
                        $type = 'C';
                        $perubahan_lv4 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($perubahan_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir'] = (isset($zz['saldo_akhir']) ? $zz['saldo_akhir'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_bln_lalu'] = (isset($zz['saldo_akhir_bln_lalu']) ? $zz['saldo_akhir_bln_lalu'] : 0) ;
                        }
                    }

                }
            }
        }
        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }

    public function nilai_beban_investasi_bkp(){
        $param_jenis = 'BEBAN INVESTASI';
        $array = array();
        $invest = $this->perubahan_dana_bersih_model->getdata('aset_investasi_front','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array[$k]['saldo_akhir'] = (isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
            $array[$k]['saldo_awal'] = (isset($v['saldo_awal']) ? $v['saldo_awal'] : 0) ;
            $array[$k]['rka'] = $v['rka'];
            $pers_rka= ($v['rka']!=0)?($v['saldo_akhir']/$v['rka'])*100:0;
            $array[$k]['pers_rka'] = $pers_rka;
            $array[$k]['type'] = $v['type'];
            $array[$k]['nominal'] = $v['saldo_akhir'] - $v['saldo_awal'];
            $min1 = $v['saldo_akhir'] - $v['saldo_awal'];
            $array[$k]['persentase'] =($v['saldo_awal']!=0)?($min1/$v['saldo_awal'])*100:0;;
            $array[$k]['jns_form'] = $v['jns_form'];
            $array[$k]['child'] = array();
            if($v['type'] == "PC"){
                $childinvest = $this->perubahan_dana_bersih_model->getdata('aset_investasi_front_lv3','result_array', $v['id_investasi'], $param_jenis);
                foreach ($childinvest as $key => $val) {
                    $array[$k]['child'][$key]['id'] = $val['id'];
                    $array[$k]['child'][$key]['id_investasi'] = $val['id_investasi'];
                    $array[$k]['child'][$key]['jenis_investasi'] = $val['jenis_investasi'];
                    $array[$k]['child'][$key]['saldo_akhir'] = (isset($val['saldo_akhir']) ? $val['saldo_akhir'] : 0) ;
                    $array[$k]['child'][$key]['saldo_awal'] = (isset($val['saldo_awal']) ? $val['saldo_awal'] : 0) ;
                    $array[$k]['child'][$key]['rka'] = $val['rka'];

                    $pers_rka2= ($val['rka']!=0)?($val['saldo_akhir']/$val['rka'])*100:0;
                    $array[$k]['child'][$key]['pers_rka'] = $pers_rka2;
                    $min = $val['saldo_akhir'] - $val['saldo_awal'];
                    $array[$k]['child'][$key]['nominal'] = $val['saldo_akhir'] - $val['saldo_awal'];
                    $array[$k]['child'][$key]['persentase'] =  ($val['saldo_awal']!=0)?($min/$val['saldo_awal'])*100:0;
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }

    public function sum_nilai_beban_investasi(){
        $param_jenis = 'BEBAN INVESTASI';
        $v = $this->perubahan_dana_bersih_model->getdata('aset_investasi_front_sum', 'row_array', $param_jenis);

        $array['id_investasi'] = $v['id_investasi'];
        $array['jenis_investasi'] = $v['jenis_investasi'];
        $array['saldo_akhir'] = (isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
        $array['saldo_awal'] = (isset($v['saldo_awal']) ? $v['saldo_awal'] : 0) ;
        $array['rka'] = $v['rka'];
        $pers_rka= ($v['rka']!=0)?($v['saldo_akhir']/$v['rka'])*100:0;
        $array['pers_rka'] = $pers_rka;
        $array['nominal'] = $v['saldo_akhir'] - $v['saldo_awal'];
        $min1 = $v['saldo_akhir'] - $v['saldo_awal'];
        $array['persentase'] =($v['saldo_awal']!=0)?($min1/$v['saldo_awal'])*100:0;
        

        // echo '<pre>';
        // print_r($array);exit;
        return $array;

    }


    public function nilai_beban_investasi(){
        $param_jenis = 'BEBAN INVESTASI';
        $array = array();
        $invest = $this->aset_investasi_model->getdataindex('aset_investasi_front','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array[$k]['saldo_akhir'] = (isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
            $array[$k]['saldo_awal'] = (isset($v['saldo_awal']) ? $v['saldo_awal'] : 0) ;
            $array[$k]['rka'] = $v['rka'];
            $pers_rka= ($v['rka']!=0)?($v['saldo_akhir']/$v['rka'])*100:0;
            $array[$k]['pers_rka'] = $pers_rka;
            $array[$k]['type'] = $v['type'];
            $array[$k]['nominal'] = $v['saldo_akhir'] - $v['saldo_awal'];
            $min1 = $v['saldo_akhir'] - $v['saldo_awal'];
            $array[$k]['persentase'] =($v['saldo_awal']!=0)?($min1/$v['saldo_awal'])*100:0;
            $array[$k]['jns_form'] = $v['jns_form'];
            $array[$k]['child'] = array();
            if($v['type'] == "PC"){
                $childinvest = $this->aset_investasi_model->getdataindex('aset_investasi_front_lv2','result_array', $v['id_investasi'], $param_jenis);
                foreach ($childinvest as $key => $val) {
                    $array[$k]['child'][$key]['id'] = $val['id'];
                    $array[$k]['child'][$key]['id_investasi'] = $val['id_investasi'];
                    $array[$k]['child'][$key]['jenis_investasi'] = $val['jenis_investasi'];
                    $array[$k]['child'][$key]['saldo_awal'] =  (isset($val['saldo_awal']) ? $val['saldo_awal'] : 0) ;
                    $array[$k]['child'][$key]['saldo_akhir'] = (isset($val['saldo_akhir']) ? $val['saldo_akhir'] : 0) ;
                    $array[$k]['child'][$key]['rka'] = $val['rka'];
                    $pers_rka1= ($val['rka']!=0)?($val['saldo_akhir']/$val['rka'])*100:0;
                    $array[$k]['child'][$key]['pers_rka'] = $pers_rka1;
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['nominal'] = $val['saldo_akhir'] - $val['saldo_awal'];
                    $min2 = $val['saldo_akhir'] - $val['saldo_awal'];
                    $array[$k]['child'][$key]['persentase'] = ($val['saldo_awal']!=0)?($min2/$val['saldo_awal'])*100:0;
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                    $array[$k]['child'][$key]['subchild'] = array();

                    if($val['type'] == "PC"){
                        $childinvestlv3 = $this->aset_investasi_model->getdataindex('aset_investasi_front_lv3','result_array', $val['id_investasi'], $param_jenis);
                        foreach ($childinvestlv3 as $x => $y) {
                            $array[$k]['child'][$key]['subchild'][$x]['id'] = $y['id'];
                            $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['saldo_awal'] = (isset($y['saldo_awal']) ? $y['saldo_awal'] : 0);
                            $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = (isset($y['saldo_akhir']) ? $y['saldo_akhir'] : 0);
                            $array[$k]['child'][$key]['subchild'][$x]['rka'] = $y['rka'];
                            $pers_rka2= ($y['rka']!=0)?($y['saldo_akhir']/$y['rka'])*100:0;
                            $array[$k]['child'][$key]['subchild'][$x]['pers_rka'] = $pers_rka2;
                            $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type'];
                            $array[$k]['child'][$key]['subchild'][$x]['nominal'] = $y['saldo_akhir'] - $y['saldo_awal'];
                            $min3 = $y['saldo_akhir'] - $y['saldo_awal'];
                            $array[$k]['child'][$key]['subchild'][$x]['persentase'] =  ($y['saldo_awal']!=0)?($min3/$y['saldo_awal'])*100:0;
                            $array[$k]['child'][$key]['subchild'][$x]['jns_form'] = $y['jns_form'];
                        }
                    }
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }


	
    public function save_keterangan(){
        $id_bulan = $this->session->userdata('id_bulan');
        $tahun = $this->session->userdata('tahun');
        $level = $this->session->userdata('level');

        $path = $_FILES['filedata']['name']; // file means your input type file name
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        
        if ($ext=="pdf" OR $ext=="doc" OR $ext=="docx" OR $ext=="") {
            $upload_path   = './files/file_bulanan/keterangan/'; //path folder
            $data['filedata_lama'] = escape($this->input->post('filedata_lama'));
            $data['nmdoc'] = escape($this->input->post('nmdok'));

            if(!empty($_FILES['filedata']['name'])){                  
                if(isset($data["filedata_lama"])){
                    if($data["filedata_lama"] != ""){
                        unlink($upload_path.$data["filedata_lama"]);
                    }
                }

                $file_data = $data['nmdoc'].'_'.$id_bulan.'_'.$tahun.'_'.$level;
                $filename_data =  $this->lib->uploadnong($upload_path, 'filedata', $file_data);
            }else{
                $filename_data = (isset($data["filedata_lama"]) ? $data["filedata_lama"] : null );
            }

            $data["file_lap"] = $filename_data;
            unset($data["filedata_lama"]);
            unset($data["upload_path_lama"]);
            unset($data["nmdoc"]);

            $data['id_bulan']        = $this->session->userdata('id_bulan');
            $data['iduser']          = $this->session->userdata('iduser');
            $data['id']              = escape($this->input->post('id'));
            $data['jenis_lap']       = escape($this->input->post('jns_lap'));
            $data['keterangan_lap']  = escape($this->input->post('keterangan'));
            $data['insert_at']       = date("Y-m-d H:i:s");

            $jns_lap = $data['jenis_lap'];
            $id_bulan = $data['id_bulan'];

            $this->perubahan_dana_bersih_model->delete_ket($jns_lap,$id_bulan);
            $this->perubahan_dana_bersih_model->insert_ket($data);

            $this->session->set_flashdata('form_true',
                '<div class="alert alert-success">
                <h4>Berhasil.</h4>
                <p>Data keterangan berhasil Disimpan.</p>
                </div>');
            redirect ($this->agent->referrer());
        }else{
            $this->session->set_flashdata('form_true',
                '<div class="alert alert-danger">
                <h4>GAGAL UPLAOD.</h4>
                <p>Format dokumen tidak sesuai ketentuan</p> <p>Format dokumen harus bertipe pdf,doc atau docx</p>
                </div>');
            redirect ($this->agent->referrer());
        }

    }


    public function get_file(){
        $id = $this->uri->segment(4);
        $get_db = $this->perubahan_dana_bersih_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_bulanan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 
    
	
}
