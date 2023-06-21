<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_keuangan extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('bulanan_model/perubahan_dana_bersih_model');
        $this->load->model('bulanan_model/aset_investasi_model');
        $this->load->model('semesteran_model/aspek_keuangan_model');
		$this->load->model('tahunan_model/aspek_keuangan_th_model');
		
        $this->load->library('form_validation');
        $this->load->library('user_agent');
		// $this->load->library('pdf');
		//cek login
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		$userData=$this->session->userdata();
		//cek akses route
		//if($userData['idusergroup'] !== '001') show_404();
		$this->iduser = $this->session->userdata('iduser');
		$this->page_limit = 10;
		
	}
	
	
	public function index(){
        $data['opt_user'] = dtuser();
        $data['opt_audit'] = combo_audit();
        $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
        $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');
        // print_r($data);exit;
        $data['data_dana_bersih_ket_thn'] = $this->aspek_keuangan_th_model->get_ket('ket_lkak_dana_bersih');
        $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
        $data['view']  = "tahunan/aspek_keuangan/index-danabersih";
        $this->load->view('main/utama', $data);
    }

    public function lkak_perubahan_danabersih(){
        $total_row ="";
        $data['opt_user'] = dtuser();
        $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
            //keterangan
        $data['tot_perubahan'] = $this->aspek_keuangan_th_model->getdata('perubahan_danabersih_lv1','result');
        $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');
        $data['data_perubahan_danabersih_ket_thn'] = $this->aspek_keuangan_th_model->get_ket('ket_lkak_perubahan_danabersih');
        // print_r($data);exit;
        $data['paggination'] = get_paggination($total_row,get_search());
        
        $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
        $data['view']  = "tahunan/aspek_keuangan/index-perubahan-danabersih";
        $this->load->view('main/utama', $data);
    }


    public function lkak_yoi(){
        $data['opt_user'] = dtuser();
        $data['yoi'] = $this->nilai_lkak_yoi();
        $data['data_yoi_ket_thn'] = $this->aspek_keuangan_th_model->get_ket('ket_lkak_yoi');
        // print_r($data['yoi']);exit;
        $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
        $data['view']  = "tahunan/aspek_keuangan/index-lkak-yoi";
        $this->load->view('main/utama', $data);
    }


    function get_index($mod){
        switch($mod){
            case 'index-aruskas':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');

                $data['arus_kas'] = $this->nilai_arus_kas();

                $filter['iduser'] =  $data['iduser'];
                $filter['id_bulan'] = $data['id_bulan'];
                $data['data_arus_kas_ket'] = $this->aspek_keuangan_model->get_ket_1($filter);
                // $data['sum_dana_bersih'] = $this->aspek_keuangan_model->get_sum_danabersih($filter['id_bulan']);

                $data['opt_user'] = dtuser();
                $data['bulan_prev'] = bulan_prev();
                $data['bulan'] = bulan();
                $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
                $data['view']  = "bulanan/arus_kas/data_aruskas";
              
                // print_r($data);exit;
            break;
            case 'index-danabersih':
                $data['iduser'] = $this->input->post('iduser');
                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');
                $data['data_dana_bersih_ket_thn'] = $this->aspek_keuangan_th_model->get_ket('ket_lkak_dana_bersih');

                $data['opt_user'] = dtuser();
                $data['opt_audit'] = combo_audit();
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                $data['view']  = "tahunan/aspek_keuangan/index-danabersih";
            break;
            case 'index-lkak-yoi':
                $data['iduser'] = $this->input->post('iduser');
                $data['yoi'] = $this->nilai_lkak_yoi($data['iduser']);
                $data['data_yoi_ket_thn'] = $this->aspek_keuangan_th_model->get_ket('ket_lkak_yoi');

                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                $data['view']  = "tahunan/aspek_keuangan/index-lkak-yoi";
            break;
            case 'index-perubahan-danabersih':
                $data['iduser'] = $this->input->post('iduser');
                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
                $data['tot_perubahan'] = $this->aspek_keuangan_th_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');

                $data['data_perubahan_danabersih_ket_thn'] = $this->aspek_keuangan_th_model->get_ket('ket_lkak_perubahan_danabersih');

                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                $data['view']  = "tahunan/aspek_keuangan/index-perubahan-danabersih";
            break;
            case 'index-audit-danabersih':
                $data['iduser'] = $this->input->post('iduser');
                $jns_lap = $this->input->post('jns_lap');
            
                $data['opt_user'] = dtuser();
                $data['opt_audit'] = combo_audit();
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                if ($jns_lap == 'AUDIT') {
                    $data['data_dana_bersih'] = $this->aspek_keuangan_th_model->getdata('audit_danabersih','result_array');
                    $data['view']  = "tahunan/aspek_keuangan/index-danabersih-audit";
                }else{
                    $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                    $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');
                    $data['data_dana_bersih_ket_thn'] = $this->aspek_keuangan_th_model->get_ket('ket_lkak_dana_bersih');
                    $data['view']  = "tahunan/aspek_keuangan/index-danabersih";
                }
                
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
            case 'keuangan_danabersih':
                $data['opt_user'] = dtuser();
                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                $data['view']  = "tahunan/aspek_keuangan/form-koreksiaudit-danabersih";
            break;
            case 'arus_kas':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->aspek_keuangan_model->getdata('header_arus_kas', 'row_array', $id);
                    $data_detail = $this->aspek_keuangan_model->getdata('data_detail_arus_kas', 'result_array', $id);
                    $combo = $this->aspek_keuangan_model->get_combo('get_arus_kas', $id);
                   
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    $data['combo'] = $combo;
                    
                    // echo '<pre>';
                    // print_r($data);exit;

                }

                $data['data_aktivitas'] = $this->aspek_keuangan_model->getdata('jenis_aktivitas', 'result');
                $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
                $data['view']  = "bulanan/arus_kas/input_aruskas";
             
            break;

            case 'table_arus_kas':
                $array = array();
                $aktivitas = $this->aspek_keuangan_model->get_combo('jenis_aktivitas','result_array');
                foreach ($aktivitas as $k => $v) {
                    $array[$k]['id_aruskas'] = $v['id_aruskas'];
                    $array[$k]['jenis_kas'] = $v['jenis_kas'];
                    $array[$k]['arus_kas'] = $v['arus_kas'];
                }
                // echo '<pre>';
                // print_r($array);exit;
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

  
    function getdisplay($mod){
        switch($mod){
            case "get_arus_kas":
                $id = $this->input->post('jenis_kas');
                $option = $this->lib->fillcombo("get_arus_kas", "return", $id);
                echo $option;
            break;
            case "get_all_kas":
            $id = $this->input->post('jenis_kas');
            $data = $this->aspek_keuangan_model->get_combo('get_arus_kas', $id);

            echo json_encode($data);
            break;
            case "data_pihak":
                $id = $this->input->post('jns_investasi');
                $option = $this->lib->fillcombo("data_pihak", "return", $id);
                echo $option;
            break;
            case "form_invest":
                $id = $this->input->post('jns_investasi');
                $data = $this->aspek_keuangan_model->getdata('form_invest', 'result_array', $id);
                $id_investasi = array();
                $jns_form = array();
                $jenis_investasi = array();
                foreach($data as $k => $v){
                    $id_investasi[$k] = $v['id_investasi'];
                    $jenis_investasi[$k] = $v['jenis_investasi'];
                    $jns_form[$k] = (int)$v['jns_form'];
                    
                }
                
                $array['id_investasi'] =  $id; 
                $array['jns_form'] =  $jns_form; 
                $array['jenis_investasi'] =  $jenis_investasi; 
                
                echo json_encode($array);
            break;
            case "data_bulan_lalu_form":
                $id_invest = $this->input->post('jns_investasi');
                $jns_form = $this->input->post('jns_form');
                $data = $this->aspek_keuangan_model->getdata('data_bulan_lalu_form', 'result_array', $id_invest, $jns_form);
                
                echo json_encode($data);
            break;
            case "cek_aset_investasi":
                $id_invest = $this->input->post('jns_investasi');
                $data = $this->aspek_keuangan_model->getdata('cek_aset_investasi', 'row_array', $id_invest);
                
                echo json_encode($data);
            break;
        }
    }


    function cetak($mod=""){
        
        switch($mod){
            case "dana_bersih_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');
                $template  = $this->load->view('tahunan/aspek_keuangan/cetak/index-danabersih-cetak', $data,true);  
                // print_r($data);exit;
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case "perubahan_dana_bersih_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
                $data['tot_perubahan'] = $this->aspek_keuangan_th_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result');
                $template  = $this->load->view('tahunan/aspek_keuangan/cetak/index-perubahan-danabersih-cetak', $data,true);  

                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'lkak_yoi_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['yoi'] = $this->nilai_lkak_yoi($data['iduser']);
                $template  = $this->load->view('tahunan/aspek_keuangan/cetak/index-lkak-yoi-cetak', $data,true);  

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



    function simpandata($p1="",$p2=""){
        // echo "<pre>";
        // print_r($_POST); exit;
        if($this->input->post('mod'))$p1=$this->input->post('mod');
        $post = array();
        foreach($_POST as $k=>$v){
            if($this->input->post($k)!=""){
                $post[$k] = $this->input->post($k);
            }else{
                $post[$k] = null;
            }
            
        }
        // print_r($post);exit;
        if(isset($post['editstatus'])){$editstatus = $post['editstatus'];unset($post['editstatus']);}
        else $editstatus = $p2;
        // $post1 = htmlspecialchars($post, ENT_COMPAT, 'UTF-8');
        echo $this->aspek_keuangan_th_model->simpandata($p1, $post, $editstatus);
    }

   
    
    public function save_keterangan(){
        $tahun = $this->session->userdata('tahun');
        $level = $this->session->userdata('level');

        $upload_path   = './files/file_tahunan/keterangan/'; //path folder
        $data['filedata_lama'] = escape($this->input->post('filedata_lama'));
        $data['nmdoc'] = escape($this->input->post('nmdok'));

        if(!empty($_FILES['filedata']['name'])){                  
            if(isset($data["filedata_lama"])){
                if($data["filedata_lama"] != ""){
                    unlink($upload_path.$data["filedata_lama"]);
                }
            }

            $file_data = $data['nmdoc'].'_'.$tahun.'_'.$level;
            $filename_data =  $this->lib->uploadnong($upload_path, 'filedata', $file_data);
        }else{
            $filename_data = (isset($data["filedata_lama"]) ? $data["filedata_lama"] : null );
        }

        $data["file_lap"] = $filename_data;
        unset($data["filedata_lama"]);
        unset($data["upload_path_lama"]);
        unset($data["nmdoc"]);

        $data['iduser']       = $this->session->userdata('iduser');
        $data['id']              = escape($this->input->post('id'));
        $data['jenis_lap']       = escape($this->input->post('jns_lap'));
        $data['keterangan_lap']  = escape($this->input->post('keterangan'));
        $data['insert_at']       = date("Y-m-d H:i:s");

        $jns_lap = $data['jenis_lap'];
        $id = $data['iduser'];

        $this->aspek_keuangan_th_model->delete_ket($jns_lap,$id);
        $this->aspek_keuangan_th_model->insert_ket($data);

        $this->session->set_flashdata('form_true',
            '<div class="alert alert-success">
            <h4>Berhasil.</h4>
            <p>Data keterangan berhasil Disimpan.</p>
            </div>');
        redirect ($this->agent->referrer());
    }
    


    public function get_file(){
        $id = $this->uri->segment(4);
        $get_db = $this->aspek_keuangan_th_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_tahunan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function nilai_all_dana_bersih(){
        $array = array();
        $dana_bersih_lv1 = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv1','result_array');
        foreach ($dana_bersih_lv1 as $k => $v) {

            if($v['jenis_laporan'] == 'ASET'){
                $judul_total = 'TOTAL ASET';
                $judul_head = 'ASET';
            }else if($v['jenis_laporan'] == 'KEWAJIBAN'){
                $judul_total = 'TOTAL KEWAJIBAN';
                $judul_head = 'KEWAJIBAN';
            }

            $array[$k]['jenis_laporan'] = $judul_head;
            $array[$k]['total'] = $judul_total;
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir_thn']) ? $v['saldo_akhir_thn'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_thn_lalu']) ? $v['saldo_akhir_thn_lalu'] : 0) ;
            $array[$k]['rka_thn_lvl1'] =  (isset($v['rka_thn']) ? $v['rka_thn'] : 0) ;

            if($v['saldo_akhir_thn_lalu'] && $v['rka_thn'] != 0){
                $pers_lvl1 = ($v['saldo_akhir_thn_lalu']/$v['rka_thn'])*100;
            }else{
                $pers_lvl1 = 0;
            }

            $pers_lvl1 = (!is_nan($pers_lvl1) && !is_infinite($pers_lvl1) ? $pers_lvl1 : '0,00');
            $array[$k]['sum_perst_rkasem2_lvl1'] =  (isset($pers_lvl1) ? $pers_lvl1 : 0) ;
            $nom1= ($v['saldo_akhir_thn_lalu'] - $v['saldo_akhir_thn']);
            $pers1= ($v['saldo_akhir_thn']!=0)?($nom1/$v['saldo_akhir_thn'])*100:0;
            $pers1 = (!is_nan($pers1) && !is_infinite($pers1) ? $pers1 : '0,00');
            $array[$k]['nominal_lvl1'] =  (isset($nom1) ? $nom1 : 0) ;           
            $array[$k]['persentase_lvl1'] =  (isset($pers1) ? $pers1 : 0) ;
            $array[$k]['child'] = array();

            $dana_bersih_lv2 = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv2','result_array', $v['jenis_laporan']);
            foreach ($dana_bersih_lv2 as $key => $val) {
                if($val['uraian'] == 'ASET INVESTASI'){
                    $judul_total = 'Total Aset Dalam Bentuk Investasi';
                    $judul_head = 'DALAM BENTUK INVESTASI';
                }else if($val['uraian'] == 'ASET BUKAN INVESTASI'){
                    $judul_total = 'Total Aset Bukan Investasi';
                    $judul_head = 'DALAM BENTUK BUKAN INVESTASI';
                }else if($val['uraian'] == 'KEWAJIBAN'){
                    $judul_total = 'Total Kewajiban';
                    $judul_head = 'KEWAJIBAN';
                }

                $array[$k]['child'][$key]['id_dana_bersih'] = $val['id_dana_bersih'];
                $array[$k]['child'][$key]['uraian'] = $val['uraian'];
                $array[$k]['child'][$key]['judul_total'] = $judul_total;
                $array[$k]['child'][$key]['judul_head'] = $judul_head;
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir_thn']) ? $val['saldo_akhir_thn'] : 0) ;
                $array[$k]['child'][$key]['sum_prev_lvl2'] = (isset($val['saldo_akhir_thn_lalu']) ? $val['saldo_akhir_thn_lalu'] : 0) ;
                $array[$k]['child'][$key]['rka_thn_lvl2'] = (isset($val['rka_thn']) ? $val['rka_thn'] : 0) ;

                if($val['saldo_akhir_thn_lalu'] && $val['rka_thn'] != 0){
                    $pers_lvl2 = ($val['saldo_akhir_thn_lalu']/$val['rka_thn'])*100;
                }else{
                    $pers_lvl2 = 0;
                }

                $pers_lvl2 = (!is_nan($pers_lvl2) && !is_infinite($pers_lvl2) ? $pers_lvl2 : '0,00');
                $array[$k]['child'][$key]['sum_perst_rkasem2_lvl2'] = (isset($pers_lvl2) ? $pers_lvl2 : 0) ;

                $nom2= ($val['saldo_akhir_thn_lalu'] - $val['saldo_akhir_thn']);
                $pers2= ($val['saldo_akhir_thn']!=0)?($nom2/$val['saldo_akhir_thn'])*100:0;
                $pers2 = (!is_nan($pers2) && !is_infinite($pers2) ? $pers2 : '0,00');
                $array[$k]['child'][$key]['nominal_lvl2'] =  (isset($nom2) ? $nom2 : 0) ;
                $array[$k]['child'][$key]['persentase_lvl2'] =  (isset($pers2) ? $pers2 : 0) ;
                $array[$k]['child'][$key]['subchild'] = array();

                $dana_bersih_lv3 = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv3','result_array', $val['id_dana_bersih']);
                foreach ($dana_bersih_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type_sub_jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_thn'] = (isset($y['saldo_akhir_thn']) ? $y['saldo_akhir_thn'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_thn_lalu'] = (isset($y['saldo_akhir_thn_lalu']) ? $y['saldo_akhir_thn_lalu'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['rka_thn'] = (isset($y['rka_thn']) ? $y['rka_thn'] : 0) ;

                    $pers_rka1= ($y['saldo_akhir_thn_lalu']!=0)?($y['saldo_akhir_thn_lalu']/$y['rka_thn'])*100:0;
                    $nom3= ($y['saldo_akhir_thn_lalu'] - $y['saldo_akhir_thn']);
                    $pers3= ($y['saldo_akhir_thn']!=0)?($nom3/$y['saldo_akhir_thn'])*100:0;
                    $pers_rka1 = (!is_nan($pers_rka1) && !is_infinite($pers_rka1) ? $pers_rka1 : '0,00');
                    $pers3 = (!is_nan($pers3) && !is_infinite($pers3) ? $pers3 : '0,00');

                    $array[$k]['child'][$key]['subchild'][$x]['perst_rka_thn'] = (isset($pers_rka1) ? $pers_rka1 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['nominal'] =  (isset($nom3) ? $nom3 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['persentase'] =  (isset($pers3) ? $pers3 : 0) ;

                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type_sub_jenis_investasi'] == 'PC'){
                        $type = 'C';
                        $dana_bersih_lv4 = $this->aspek_keuangan_th_model->getdata('dana_bersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($dana_bersih_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type_sub_jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_thn'] = (isset($zz['saldo_akhir_thn']) ? $zz['saldo_akhir_thn'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_thn_lalu'] = (isset($zz['saldo_akhir_thn_lalu']) ? $zz['saldo_akhir_thn_lalu'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['rka_thn'] = (isset($zz['rka_thn']) ? $zz['rka_thn'] : 0) ;

                            
                            $pers_rka2= ($zz['saldo_akhir_thn_lalu']!=0)?($zz['saldo_akhir_thn_lalu']/$zz['rka_thn'])*100:0;
                            $pers_rka2 = (!is_nan($pers_rka2) && !is_infinite($pers_rka2) ? $pers_rka2 : '0,00');
                            $nom4= ($zz['saldo_akhir_thn_lalu'] - $zz['saldo_akhir_thn']);
                            $pers4= ($zz['saldo_akhir_thn']!=0)?($nom4/$zz['saldo_akhir_thn'])*100:0;
                            $pers4 = (!is_nan($pers4) && !is_infinite($pers4) ? $pers4 : '0,00');

                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['perst_rka_thn'] = (isset($pers_rka2) ? $pers_rka2 : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['nominal'] =  (isset($nom4) ? $nom4 : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['persentase'] =  (isset($pers4) ? $pers4 : 0) ;
                        }
                    }

                }
            }
        }
        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }

    public function nilai_perubahan_danabersih(){
        $array = array();
        $perubahan_lv1 = $this->aspek_keuangan_th_model->getdata('perubahan_danabersih_lv1','result_array');
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
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir_thn']) ? $v['saldo_akhir_thn'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_thn_lalu']) ? $v['saldo_akhir_thn_lalu'] : 0) ;
            $array[$k]['rka_thn_lvl1'] =  (isset($v['rka_thn']) ? $v['rka_thn'] : 0) ;

             if($v['saldo_akhir_thn_lalu'] && $v['rka_thn'] != 0){
                $pers_lvl1 = ($v['saldo_akhir_thn_lalu']/$v['rka_thn'])*100;
            }else{
                $pers_lvl1 = 0;
            }

            $pers_lvl1 = (!is_nan($pers_lvl1) && !is_infinite($pers_lvl1) ? $pers_lvl1 : '0,00');
            $array[$k]['sum_perst_rkasem2_lvl1'] =  (isset($pers_lvl1) ? $pers_lvl1 : 0) ;
            $nom1= ($v['saldo_akhir_thn_lalu'] - $v['saldo_akhir_thn']);
            $pers1= ($v['saldo_akhir_thn']!=0)?($nom1/$v['saldo_akhir_thn'])*100:0;
            $pers1 = (!is_nan($pers1) && !is_infinite($pers1) ? $pers1 : '0,00');
            $array[$k]['nominal_lvl1'] =  (isset($nom1) ? $nom1 : 0) ;           
            $array[$k]['persentase_lvl1'] =  (isset($pers1) ? $pers1 : 0) ;

            $array[$k]['child'] = array();

            $perubahan_lv2 = $this->aspek_keuangan_th_model->getdata('perubahan_danabersih_lv2','result_array', $v['uraian']);
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
                }

                $array[$k]['child'][$key]['judul_head'] =  $judul_head;
                $array[$k]['child'][$key]['judul_total'] = $judul_total;
                $array[$k]['child'][$key]['id_perubahan_dana_bersih'] = $val['id_perubahan_dana_bersih'];
                $array[$k]['child'][$key]['group'] = $val['group'];
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir_thn']) ? $val['saldo_akhir_thn'] : 0) ;
                $array[$k]['child'][$key]['sum_prev_lvl2'] =  (isset($val['saldo_akhir_thn_lalu']) ? $val['saldo_akhir_thn_lalu'] : 0) ;
                $array[$k]['child'][$key]['rka_thn_lvl2'] = (isset($val['rka_thn']) ? $val['rka_thn'] : 0) ;

                if($val['saldo_akhir_thn_lalu'] && $val['rka_thn'] != 0){
                    $pers_lvl2 = ($val['saldo_akhir_thn_lalu']/$val['rka_thn'])*100;
                }else{
                    $pers_lvl2 = 0;
                }
                $pers_lvl2 = (!is_nan($pers_lvl2) && !is_infinite($pers_lvl2) ? $pers_lvl2 : '0,00');
                $array[$k]['child'][$key]['sum_perst_rkasem2_lvl2'] = (isset($pers_lvl2) ? $pers_lvl2 : 0) ;

                $nom2= ($val['saldo_akhir_thn_lalu'] - $val['saldo_akhir_thn']);
                $pers2= ($val['saldo_akhir_thn']!=0)?($nom2/$val['saldo_akhir_thn'])*100:0;
                $pers2 = (!is_nan($pers2) && !is_infinite($pers2) ? $pers2 : '0,00');
                $array[$k]['child'][$key]['nominal_lvl2'] =  (isset($nom2) ? $nom2 : 0) ;
                $array[$k]['child'][$key]['persentase_lvl2'] =  (isset($pers2) ? $pers2 : 0) ;

                $array[$k]['child'][$key]['subchild'] = array();

                $perubahan_lv3 = $this->aspek_keuangan_th_model->getdata('perubahan_danabersih_lv3','result_array', $val['group']);
                foreach ($perubahan_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_thn'] = (isset($y['saldo_akhir_thn']) ? $y['saldo_akhir_thn'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_thn_lalu'] = (isset($y['saldo_akhir_thn_lalu']) ? $y['saldo_akhir_thn_lalu'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['rka_thn'] = (isset($y['rka_thn']) ? $y['rka_thn'] : 0) ;

                    $pers_rka1= ($y['saldo_akhir_thn_lalu']!=0)?($y['saldo_akhir_thn_lalu']/$y['rka_thn'])*100:0;
                    $nom3= ($y['saldo_akhir_thn_lalu'] - $y['saldo_akhir_thn']);
                    $pers3= ($y['saldo_akhir_thn']!=0)?($nom3/$y['saldo_akhir_thn'])*100:0;
                    $pers_rka1 = (!is_nan($pers_rka1) && !is_infinite($pers_rka1) ? $pers_rka1 : '0,00');
                    $pers3 = (!is_nan($pers3) && !is_infinite($pers3) ? $pers3 : '0,00');

                    $array[$k]['child'][$key]['subchild'][$x]['perst_rka_thn'] = (isset($pers_rka1) ? $pers_rka1 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['nominal'] =  (isset($nom3) ? $nom3 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['persentase'] =  (isset($pers3) ? $pers3 : 0) ;

                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type'] == 'PC'){
                        $type = 'C';
                        $perubahan_lv4 = $this->aspek_keuangan_th_model->getdata('perubahan_danabersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($perubahan_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_thn'] = (isset($zz['saldo_akhir_thn']) ? $zz['saldo_akhir_thn'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_thn_lalu'] = (isset($zz['saldo_akhir_thn_lalu']) ? $zz['saldo_akhir_thn_lalu'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['rka_thn'] = (isset($zz['rka_thn']) ? $zz['rka_thn'] : 0) ;

                            
                            $pers_rka2= ($zz['saldo_akhir_thn_lalu']!=0)?($zz['saldo_akhir_thn_lalu']/$zz['rka_thn'])*100:0;
                            $nom4= ($zz['saldo_akhir_thn_lalu'] - $zz['saldo_akhir_thn']);
                            $pers4= ($zz['saldo_akhir_thn']!=0)?($nom4/$zz['saldo_akhir_thn'])*100:0;
                            $pers_rka2 = (!is_nan($pers_rka2) && !is_infinite($pers_rka2) ? $pers_rka2 : '0,00');
                            $pers4 = (!is_nan($pers4) && !is_infinite($pers4) ? $pers4 : '0,00');

                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['perst_rka_thn'] = (isset($pers_rka2) ? $pers_rka2 : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['nominal'] =  (isset($nom4) ? $nom4 : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['persentase'] =  (isset($pers4) ? $pers4 : 0) ;
                        }
                    }

                }
            }
        }
        // echo '<pre>';
        // print_r($array);exit;
        return $array;

    }


    public function nilai_lkak_yoi($param=""){
        if ($param != "") {
            $iduser = $param;
        }else{ 
            $iduser = $this->session->userdata('iduser');
        }
        // $arr = array('9000','30697100000000','28037100000000','27692100000000','21620500000000','23646000000000');
        // echo geometric_average($arr); 
        $hasil_investasi = $this->aspek_keuangan_th_model->getdata('lkak_yoi_hasil_investasi','row_array');
        $array1a = array();
        $array1b = array();
        $array2a = array();
        $array2b = array();

        // Semester 1
        $investasi_thn = $this->aspek_keuangan_th_model->getdata('lkak_yoi_investasi_thn','result_array');
        foreach ($investasi_thn as $ky => $vy) {
            $array1a[$ky] = $vy['saldo_akhir_thn'];
            $array1b[$ky] = $vy['rka_thn'];
        }

        // Semester 2
        $investasi_thn_lalu = $this->aspek_keuangan_th_model->getdata('lkak_yoi_investasi_thn_lalu','result_array');
        foreach ($investasi_thn_lalu as $kx => $vx) {
            $array2a[$kx] = $vx['saldo_akhir_thn_lalu'];
            $array2b[$kx] = $vx['rka_thn_lalu'];
        }

        
        if($iduser == 'DJA001'){
            if($param != ""){
                $saldo_akhir_thn = geometric_average($array1a);
                $saldo_akhir_thn_lalu = geometric_average($array2a);
                $rka_thn = geometric_average($array1b);

            }else{
                $saldo_akhir_thn = 0;
                $saldo_akhir_thn_lalu = 0;
                $rka_thn = 0;   
            }
        }else{
            $saldo_akhir_thn = geometric_average($array1a);
            $saldo_akhir_thn_lalu = geometric_average($array2a);
            $rka_thn = geometric_average($array1b);

        }

        // echo "<pre>";
        // print_r($hasil_investasi);exit();
        // print_r(geometric_average($array2a));exit;

        $thnjln= ($saldo_akhir_thn!=0)?($hasil_investasi['saldo_akhir_thn']/$saldo_akhir_thn)*100:0;
        $thnlalu= ($saldo_akhir_thn_lalu!=0)?($hasil_investasi['saldo_akhir_thn_lalu']/$saldo_akhir_thn_lalu)*100:0;
        $rka= ($rka_thn!=0)?($hasil_investasi['rka_thn']/$rka_thn):0;
        $per_rka = ($rka!=0)?($thnlalu/$rka)*100:0;
        $naik_turun = ($thnjln!=0)?(($thnlalu-$thnjln)/$thnjln)*100:0;
        $per_rka = (!is_nan($per_rka) && !is_infinite($per_rka) ? $per_rka : '0,00');

        $data['uraian'] = 'Tingkat pengembalian hasil investasi (YOI)';
        $data['lkak_yoi_saldo_akhir_thn'] = $thnjln;
        $data['lkak_yoi_saldo_akhir_thn_lalu'] = $thnlalu;
        $data['lkak_yoi_rka_thn'] = $rka;
        $data['lkak_yoi_pers_capaian'] = $per_rka;
        $data['lkak_yoi_naik'] = $naik_turun;

        return $data;
    }
    	

}
