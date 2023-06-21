<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_keuangan extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('bulanan_model/perubahan_dana_bersih_model');
        $this->load->model('bulanan_model/aset_investasi_model');
		$this->load->model('semesteran_model/aspek_keuangan_model');
		
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
        $data['opt_smt'] = semester();
        $data['semester'] = "";
        $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
        $data['total_bersih'] = $this->aspek_keuangan_model->getdata('dana_bersih_lv1','result');
        // print_r($data);exit;
        $data['data_dana_bersih_ket_smt1'] = $this->aspek_keuangan_model->get_ket('ket_lkak_dana_bersih', '1');
        $data['data_dana_bersih_ket_smt2'] = $this->aspek_keuangan_model->get_ket('ket_lkak_dana_bersih', '2');
        $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
        $data['view']  = "semesteran/aspek_keuangan/index-danabersih";
        $this->load->view('main/utama', $data);
    }

    public function lkak_perubahan_danabersih(){
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";

        $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
            //keterangan
        $data['tot_perubahan'] = $this->aspek_keuangan_model->getdata('perubahan_danabersih_lv1','result');
        $data['total_bersih'] = $this->aspek_keuangan_model->getdata('dana_bersih_lv0','result');

        // echo "<pre>";
        // print_r($data['total_bersih']);exit();
        $data['data_perubahan_danabersih_ket_smt1'] = $this->aspek_keuangan_model->get_ket('ket_lkak_perubahan_danabersih', '1');
        $data['data_perubahan_danabersih_ket_smt2'] = $this->aspek_keuangan_model->get_ket('ket_lkak_perubahan_danabersih', '2');
        // print_r($data);exit;
        
        
        $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
        $data['view']  = "semesteran/aspek_keuangan/index-perubahan-danabersih";
        $this->load->view('main/utama', $data);
    }


    public function lkak_yoi(){
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";

        $data['yoi'] = $this->nilai_lkak_yoi();
        $data['data_yoi_ket_smt1'] = $this->aspek_keuangan_model->get_ket('ket_lkak_yoi', '1');
        $data['data_yoi_ket_smt2'] = $this->aspek_keuangan_model->get_ket('ket_lkak_yoi', '2');
        // print_r($data['yoi']);exit;
        $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
        $data['view']  = "semesteran/aspek_keuangan/index-lkak-yoi";
        $this->load->view('main/utama', $data);
    }


    function get_index($mod){
        switch($mod){
            case 'index-aruskas':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

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
                $data['semester'] = $this->input->post('semester');

                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->aspek_keuangan_model->getdata('dana_bersih_lv1','result');
                $data['data_dana_bersih_ket_smt1'] = $this->aspek_keuangan_model->get_ket('ket_lkak_dana_bersih', '1');
                $data['data_dana_bersih_ket_smt2'] = $this->aspek_keuangan_model->get_ket('ket_lkak_dana_bersih', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                $data['view']  = "semesteran/aspek_keuangan/index-danabersih";
            break;
            case 'index-lkak-yoi':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['yoi'] = $this->nilai_lkak_yoi($data['iduser']);
                $data['data_yoi_ket_smt1'] = $this->aspek_keuangan_model->get_ket('ket_lkak_yoi', '1');
                $data['data_yoi_ket_smt2'] = $this->aspek_keuangan_model->get_ket('ket_lkak_yoi', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                $data['view']  = "semesteran/aspek_keuangan/index-lkak-yoi";
            break;
            case 'index-perubahan-danabersih':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
                $data['tot_perubahan'] = $this->aspek_keuangan_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->aspek_keuangan_model->getdata('dana_bersih_lv0','result');

                $data['data_perubahan_danabersih_ket_smt1'] = $this->aspek_keuangan_model->get_ket('ket_lkak_perubahan_danabersih', '1');
                $data['data_perubahan_danabersih_ket_smt2'] = $this->aspek_keuangan_model->get_ket('ket_lkak_perubahan_danabersih', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Keuangan', 'subheader'=>'Aspek Keuangan');
                $data['view']  = "semesteran/aspek_keuangan/index-perubahan-danabersih";
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
                $data['semester'] = $this->input->post('semester');

                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->aspek_keuangan_model->getdata('dana_bersih_lv1','result');
                $template  = $this->load->view('semesteran/aspek_keuangan/cetak/index-danabersih-cetak', $data,true);  
                // print_r($data);exit;
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case "perubahan_dana_bersih_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
                $data['tot_perubahan'] = $this->aspek_keuangan_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->aspek_keuangan_model->getdata('dana_bersih_lv1','result');
                $template  = $this->load->view('semesteran/aspek_keuangan/cetak/index-perubahan-danabersih-cetak', $data,true);  

                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'lkak_yoi_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                
                $data['yoi'] = $this->nilai_lkak_yoi($data['iduser']);
                $template  = $this->load->view('semesteran/aspek_keuangan/cetak/index-lkak-yoi-cetak', $data,true);  

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
        echo $this->aspek_keuangan_model->simpandata($p1, $post, $editstatus);
    }

   
    
    public function save_keterangan(){
        $tahun = $this->session->userdata('tahun');
        $level = $this->session->userdata('level');
        $semester = $this->input->post('semester');

        $path = $_FILES['filedata']['name']; // file means your input type file name
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext=="pdf" OR $ext=="doc" OR $ext=="docx" OR $ext=="") {
            $upload_path   = './files/file_semesteran/keterangan/'; //path folder
            $data['filedata_lama'] = escape($this->input->post('filedata_lama'));
            $data['nmdoc'] = escape($this->input->post('nmdok'));

            if(!empty($_FILES['filedata']['name'])){                  
                if(isset($data["filedata_lama"])){
                    if($data["filedata_lama"] != ""){
                        unlink($upload_path.$data["filedata_lama"]);
                    }
                }

                $file_data = $data['nmdoc'].'_'.$semester.'_'.$tahun.'_'.$level;
                $filename_data =  $this->lib->uploadnong($upload_path, 'filedata', $file_data);
            }else{
                $filename_data = (isset($data["filedata_lama"]) ? $data["filedata_lama"] : null );
            }

            $data["file_lap"] = $filename_data;
            unset($data["filedata_lama"]);
            unset($data["upload_path_lama"]);
            unset($data["nmdoc"]);

            $data['semester']        = escape($this->input->post('semester'));
            $data['iduser']          = $this->session->userdata('iduser');
            $data['tahun']           = $this->session->userdata('tahun');
            $data['id']              = escape($this->input->post('id'));
            $data['jenis_lap']       = escape($this->input->post('jns_lap'));
            $data['keterangan_lap']  = escape($this->input->post('keterangan'));
            $data['insert_at']       = date("Y-m-d H:i:s");

            $jns_lap = $data['jenis_lap'];
            $smt = $data['semester'];

            $this->aspek_keuangan_model->delete_ket($jns_lap,$smt);
            $this->aspek_keuangan_model->insert_ket($data);

            $this->session->set_flashdata('form_true',
                '<div class="alert alert-success">
                <h4>Berhasil.</h4>
                <p>Data keterangan berhasil Disimpan.</p>
                </div>');
            redirect ($this->agent->referrer());
        }else {
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
        $get_db = $this->aspek_keuangan_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_semesteran/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function nilai_all_dana_bersih(){
        $array = array();
        $dana_bersih_lv1 = $this->aspek_keuangan_model->getdata('dana_bersih_lv1','result_array');
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
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir_smt1']) ? $v['saldo_akhir_smt1'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_smt2']) ? $v['saldo_akhir_smt2'] : 0) ;
            $array[$k]['rka_sem1_lvl1'] =  (isset($v['rka_sem1']) ? $v['rka_sem1'] : 0) ;

            if($v['saldo_akhir_smt2'] && $v['rka_sem1'] != 0){
                $pers_lvl1 = ($v['saldo_akhir_smt2']/$v['rka_sem1'])*100;
            }else{
                $pers_lvl1 = 0;
            }
            $pers_lvl1 = (!is_nan($pers_lvl1) && !is_infinite($pers_lvl1) ? $pers_lvl1 : '0,00');
            $array[$k]['sum_perst_rkasem2_lvl1'] =  (isset($pers_lvl1) ? $pers_lvl1 : 0) ;
            $nom1= ($v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1']);
            $pers1= ($v['saldo_akhir_smt1']!=0)?($nom1/$v['saldo_akhir_smt1'])*100:0;
            $pers1 = (!is_nan($pers1) && !is_infinite($pers1) ? $pers1 : '0,00');
            $array[$k]['nominal_lvl1'] =  (isset($nom1) ? $nom1 : 0) ;           
            $array[$k]['persentase_lvl1'] =  (isset($pers1) ? $pers1 : 0) ;
            $array[$k]['child'] = array();

            $dana_bersih_lv2 = $this->aspek_keuangan_model->getdata('dana_bersih_lv2','result_array', $v['jenis_laporan']);
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
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir_smt1']) ? $val['saldo_akhir_smt1'] : 0) ;
                $array[$k]['child'][$key]['sum_prev_lvl2'] = (isset($val['saldo_akhir_smt2']) ? $val['saldo_akhir_smt2'] : 0) ;
                $array[$k]['child'][$key]['rka_sem1_lvl2'] = (isset($val['rka_sem1']) ? $val['rka_sem1'] : 0) ;

                if($val['saldo_akhir_smt2'] && $val['rka_sem1'] != 0){
                    $pers_lvl2 = ($val['saldo_akhir_smt2']/$val['rka_sem1'])*100;
                }else{
                    $pers_lvl2 = 0;
                }
                $pers_lvl2 = (!is_nan($pers_lvl2) && !is_infinite($pers_lvl2) ? $pers_lvl2 : '0,00');
                $array[$k]['child'][$key]['sum_perst_rkasem2_lvl2'] = (isset($pers_lvl2) ? $pers_lvl2 : 0) ;

                $nom2= ($val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1']);
                $pers2= ($val['saldo_akhir_smt1']!=0)?($nom2/$val['saldo_akhir_smt1'])*100:0;


                $pers2 = (!is_nan($pers2) && !is_infinite($pers2) ? $pers2 : '0,00');
                $array[$k]['child'][$key]['nominal_lvl2'] =  (isset($nom2) ? $nom2 : 0) ;
                $array[$k]['child'][$key]['persentase_lvl2'] =  (isset($pers2) ? $pers2 : 0) ;
                $array[$k]['child'][$key]['subchild'] = array();

                $dana_bersih_lv3 = $this->aspek_keuangan_model->getdata('dana_bersih_lv3','result_array', $val['id_dana_bersih']);
                foreach ($dana_bersih_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type_sub_jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_smt1'] = (isset($y['saldo_akhir_smt1']) ? $y['saldo_akhir_smt1'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_smt2'] = (isset($y['saldo_akhir_smt2']) ? $y['saldo_akhir_smt2'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['rka_sem1'] = (isset($y['rka_sem1']) ? $y['rka_sem1'] : 0) ;

                    $pers_rka1= ($y['saldo_akhir_smt2']!=0)?($y['saldo_akhir_smt2']/$y['rka_sem1'])*100:0;
                    $nom3= ($y['saldo_akhir_smt2'] - $y['saldo_akhir_smt1']);
                    $pers3= ($y['saldo_akhir_smt1']!=0)?($nom3/$y['saldo_akhir_smt1'])*100:0;
                    $pers3 = (!is_nan($pers3) && !is_infinite($pers3) ? $pers3 : '0,00');
                    $pers_rka1 = (!is_nan($pers_rka1) && !is_infinite($pers_rka1) ? $pers_rka1 : '0,00');
                    $array[$k]['child'][$key]['subchild'][$x]['perst_rka_sem1'] = (isset($pers_rka1) ? $pers_rka1 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['nominal'] =  (isset($nom3) ? $nom3 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['persentase'] =  (isset($pers3) ? $pers3 : 0) ;

                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type_sub_jenis_investasi'] == 'PC'){
                        $type = 'C';
                        $dana_bersih_lv4 = $this->aspek_keuangan_model->getdata('dana_bersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($dana_bersih_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type_sub_jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_smt1'] = (isset($zz['saldo_akhir_smt1']) ? $zz['saldo_akhir_smt1'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_smt2'] = (isset($zz['saldo_akhir_smt2']) ? $zz['saldo_akhir_smt2'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['rka_sem1'] = (isset($zz['rka_sem1']) ? $zz['rka_sem1'] : 0) ;

                            
                            $pers_rka2= ($zz['saldo_akhir_smt2']!=0)?($zz['saldo_akhir_smt2']/$zz['rka_sem1'])*100:0;
                            $nom4= ($zz['saldo_akhir_smt2'] - $zz['saldo_akhir_smt1']);
                            $pers4= ($zz['saldo_akhir_smt1']!=0)?($nom4/$zz['saldo_akhir_smt1'])*100:0;

                            $pers4 = (!is_nan($pers4) && !is_infinite($pers4) ? $pers4 : '0,00');
                            $pers_rka2 = (!is_nan($pers_rka2) && !is_infinite($pers_rka2) ? $pers_rka2 : '0,00');
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['perst_rka_sem1'] = (isset($pers_rka2) ? $pers_rka2 : 0) ;
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
        $perubahan_lv1 = $this->aspek_keuangan_model->getdata('perubahan_danabersih_lv1','result_array');
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
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir_smt1']) ? $v['saldo_akhir_smt1'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_smt2']) ? $v['saldo_akhir_smt2'] : 0) ;
            $array[$k]['rka_sem1_lvl1'] =  (isset($v['rka_sem1']) ? $v['rka_sem1'] : 0) ;

             if($v['saldo_akhir_smt2'] && $v['rka_sem1'] != 0){
                $pers_lvl1 = ($v['saldo_akhir_smt2']/$v['rka_sem1'])*100;
            }else{
                $pers_lvl1 = 0;
            }

            $pers_lvl1 = (!is_nan($pers_lvl1) && !is_infinite($pers_lvl1) ? $pers_lvl1 : '0,00');
            $array[$k]['sum_perst_rkasem2_lvl1'] =  (isset($pers_lvl1) ? $pers_lvl1 : 0) ;
            $nom1= ($v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1']);
            $pers1= ($v['saldo_akhir_smt1']!=0)?($nom1/$v['saldo_akhir_smt1'])*100:0;


            $pers1 = (!is_nan($pers1) && !is_infinite($pers1) ? $pers1 : '0,00');
            $array[$k]['nominal_lvl1'] =  (isset($nom1) ? $nom1 : 0) ;           
            $array[$k]['persentase_lvl1'] =  (isset($pers1) ? $pers1 : 0) ;

            $array[$k]['child'] = array();

            $perubahan_lv2 = $this->aspek_keuangan_model->getdata('perubahan_danabersih_lv2','result_array', $v['uraian']);
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
                    $judul_total = 'Sub Jumlah Peningkatan(Penurunan)';
                    $judul_head = 'NILAI INVESTASI';
                }else if($val['group'] == 'ASET TETAP'){
                    $judul_total = 'Sub Jumlah Aset Tetap';
                    $judul_head = 'ASET TETAP';
                }

                $array[$k]['child'][$key]['judul_head'] =  $judul_head;
                $array[$k]['child'][$key]['judul_total'] = $judul_total;
                $array[$k]['child'][$key]['id_perubahan_dana_bersih'] = $val['id_perubahan_dana_bersih'];
                $array[$k]['child'][$key]['group'] = $val['group'];
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir_smt1']) ? $val['saldo_akhir_smt1'] : 0) ;
                $array[$k]['child'][$key]['sum_prev_lvl2'] =  (isset($val['saldo_akhir_smt2']) ? $val['saldo_akhir_smt2'] : 0) ;
                $array[$k]['child'][$key]['rka_sem1_lvl2'] = (isset($val['rka_sem1']) ? $val['rka_sem1'] : 0) ;

                if($val['saldo_akhir_smt2'] && $val['rka_sem1'] != 0){
                    $pers_lvl2 = ($val['saldo_akhir_smt2']/$val['rka_sem1'])*100;
                }else{
                    $pers_lvl2 = 0;
                }
                $pers_lvl2 = (!is_nan($pers_lvl2) && !is_infinite($pers_lvl2) ? $pers_lvl2 : '0,00');
                $array[$k]['child'][$key]['sum_perst_rkasem2_lvl2'] = (isset($pers_lvl2) ? $pers_lvl2 : 0) ;

                $nom2= ($val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1']);
                $pers2= ($val['saldo_akhir_smt1']!=0)?($nom2/$val['saldo_akhir_smt1'])*100:0;
                $pers2 = (!is_nan($pers2) && !is_infinite($pers2) ? $pers2 : '0,00');
                $array[$k]['child'][$key]['nominal_lvl2'] =  (isset($nom2) ? $nom2 : 0) ;
                $array[$k]['child'][$key]['persentase_lvl2'] =  (isset($pers2) ? $pers2 : 0) ;

                $array[$k]['child'][$key]['subchild'] = array();

                $perubahan_lv3 = $this->aspek_keuangan_model->getdata('perubahan_danabersih_lv3','result_array', $val['group']);
                foreach ($perubahan_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_smt1'] = (isset($y['saldo_akhir_smt1']) ? $y['saldo_akhir_smt1'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_smt2'] = (isset($y['saldo_akhir_smt2']) ? $y['saldo_akhir_smt2'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['rka_sem1'] = (isset($y['rka_sem1']) ? $y['rka_sem1'] : 0) ;

                    $pers_rka1= ($y['saldo_akhir_smt2']!=0)?($y['saldo_akhir_smt2']/$y['rka_sem1'])*100:0;
                    $nom3= ($y['saldo_akhir_smt2'] - $y['saldo_akhir_smt1']);
                    $pers3= ($y['saldo_akhir_smt1']!=0)?($nom3/$y['saldo_akhir_smt1'])*100:0;
                    $pers_rka1 = (!is_nan($pers_rka1) && !is_infinite($pers_rka1) ? $pers_rka1 : '0,00');
                    $pers3 = (!is_nan($pers3) && !is_infinite($pers3) ? $pers3 : '0,00');

                    $array[$k]['child'][$key]['subchild'][$x]['perst_rka_sem1'] = (isset($pers_rka1) ? $pers_rka1 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['nominal'] =  (isset($nom3) ? $nom3 : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['persentase'] =  (isset($pers3) ? $pers3 : 0) ;

                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type'] == 'PC'){
                        $type = 'C';
                        $perubahan_lv4 = $this->aspek_keuangan_model->getdata('perubahan_danabersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($perubahan_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_smt1'] = (isset($zz['saldo_akhir_smt1']) ? $zz['saldo_akhir_smt1'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_smt2'] = (isset($zz['saldo_akhir_smt2']) ? $zz['saldo_akhir_smt2'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['rka_sem1'] = (isset($zz['rka_sem1']) ? $zz['rka_sem1'] : 0) ;

                            
                            $pers_rka2= ($zz['saldo_akhir_smt2']!=0)?($zz['saldo_akhir_smt2']/$zz['rka_sem1'])*100:0;
                            $nom4= ($zz['saldo_akhir_smt2'] - $zz['saldo_akhir_smt1']);
                            $pers4= ($zz['saldo_akhir_smt1']!=0)?($nom4/$zz['saldo_akhir_smt1'])*100:0;

                            $pers_rka2 = (!is_nan($pers_rka2) && !is_infinite($pers_rka2) ? $pers_rka2 : '0,00');
                            $pers4 = (!is_nan($pers4) && !is_infinite($pers4) ? $pers4 : '0,00');

                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['perst_rka_sem1'] = (isset($pers_rka2) ? $pers_rka2 : 0) ;
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
        $hasil_investasi = $this->aspek_keuangan_model->getdata('lkak_yoi_hasil_investasi','row_array');
        $array1a = array();
        $array1b = array();
        $array2a = array();
        $array2b = array();

        // Semester 1
        $investasi_sm1 = $this->aspek_keuangan_model->getdata('lkak_yoi_investasi_sm1','result_array');
        foreach ($investasi_sm1 as $ky => $vy) {
            $array1a[$ky] = $vy['saldo_akhir_smt1'];
            $array1b[$ky] = $vy['rka_smt1'];
        }

        // Semester 2
        $investasi_sm2 = $this->aspek_keuangan_model->getdata('lkak_yoi_investasi_sm2','result_array');
        foreach ($investasi_sm2 as $kx => $vx) {
            $array2a[$kx] = $vx['saldo_akhir_smt2'];
            $array2b[$kx] = $vx['rka_smt2'];
        }

        
        if($iduser == 'DJA001'){
            if($param != ""){
                $saldo_akhir_smt1 = geometric_average($array1a);
                $saldo_akhir_smt2 = geometric_average($array2a);
                $rka_smt1 = geometric_average($array1b);

            }else{
                $saldo_akhir_smt1 = 0;
                $saldo_akhir_smt2 = 0;
                $rka_smt1 = 0;   
            }
        }else{
            $saldo_akhir_smt1 = geometric_average($array1a);
            $saldo_akhir_smt2 = geometric_average($array2a);
            $rka_smt1 = geometric_average($array1b);

        }

        // echo "<pre>";
        // print_r($hasil_investasi);exit();
        // print_r(geometric_average($array2a));exit;

        $smt1= ($saldo_akhir_smt1!=0)?($hasil_investasi['saldo_akhir_smt1']/$saldo_akhir_smt1)*100:0;
        $smt2= ($saldo_akhir_smt2!=0)?($hasil_investasi['saldo_akhir_smt2']/$saldo_akhir_smt2)*100:0;
        $rka= ($rka_smt1!=0)?($hasil_investasi['rka_smt1']/$rka_smt1):0;
        $per_rka = ($rka!=0)?($smt2/$rka)*100:0;

        $per_rka = (!is_nan($per_rka) && !is_infinite($per_rka) ? $per_rka : '0,00');
        $naik_turun = ($smt1!=0)?(($smt2-$smt1)/$smt1)*100:0;

        $data['uraian'] = 'Tingkat pengembalian hasil investasi (YOI)';
        $data['lkak_yoi_saldo_akhir_smt1'] = $smt1;
        $data['lkak_yoi_saldo_akhir_smt2'] = $smt2;
        $data['lkak_yoi_rka_smt1'] = $rka;
        $data['lkak_yoi_pers_capaian'] = $per_rka;
        $data['lkak_yoi_naik'] = $naik_turun;

        return $data;
    }
    	

}
