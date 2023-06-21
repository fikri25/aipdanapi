<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_investasi extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('bulanan_model/perubahan_dana_bersih_model');
        $this->load->model('bulanan_model/aset_investasi_model');
		$this->load->model('semesteran_model/aspek_investasi_model');
		
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
        $data['data_invest'] = $this->aset_investasi_semester();
        $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
        // print_r($data);exit;
        $data['data_penempatan_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_penempatan_investasi', '1');
        $data['data_penempatan_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_penempatan_investasi', '2');
        $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
        $data['view']  = "semesteran/aspek_investasi/index-investasi";
        $this->load->view('main/utama', $data);
    }

    public function hasil_investasi(){
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";
        $data['data_hasil'] = $this->hasil_investasi_semester();
        $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'HASIL INVESTASI');
     
        $data['data_penerimaan_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_penerimaan_investasi', '1');
        $data['data_penerimaan_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_penerimaan_investasi', '2');
        // echo'<pre>';
        // print_r($data);exit;
        $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
        $data['view']  = "semesteran/aspek_investasi/index-hasil-investasi";
        $this->load->view('main/utama', $data);
    }

    public function beban_investasi(){
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";
        $data['data_beban'] = $this->beban_investasi_semester();
        $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'BEBAN INVESTASI');
        // print_r($data);exit;
        $data['data_beban_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_beban_investasi', '1');
        $data['data_beban_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_beban_investasi', '2');
        $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
        $data['view']  = "semesteran/aspek_investasi/index-beban-investasi";
        $this->load->view('main/utama', $data);
    }

    public function karakteristik_invest(){
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";
        $data['data_karakter'] = $this->karakteristik_invest_semester();
        // print_r($data);exit;
        $data['data_karakteristik_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_karakteristik_investasi', '1');
        $data['data_karakteristik_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_karakteristik_investasi', '2');
        $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
        $data['view']  = "semesteran/aspek_investasi/index-karakteristik-investasi";
        $this->load->view('main/utama', $data);
    }



    function get_index($mod){
        switch($mod){
            case 'index-penempatan-investasi':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_invest'] = $this->aset_investasi_semester();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
          
                $data['data_penempatan_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_penempatan_investasi', '1');
                $data['data_penempatan_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_penempatan_investasi', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
                $data['view']  = "semesteran/aspek_investasi/index-investasi";
            break;

            case 'index-hasil-investasi':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_hasil'] = $this->hasil_investasi_semester();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'HASIL INVESTASI');
         
                $data['data_penerimaan_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_penerimaan_investasi', '1');
                $data['data_penerimaan_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_penerimaan_investasi', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
                $data['view']  = "semesteran/aspek_investasi/index-hasil-investasi";
            break;
            case 'index-beban-investasi':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_beban'] = $this->beban_investasi_semester();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'BEBAN');
       
                $data['data_beban_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_beban_investasi', '1');
                $data['data_beban_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_beban_investasi', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
                $data['view']  = "semesteran/aspek_investasi/index-beban-investasi";
            break;
            case 'index-karakteristik-investasi':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                $smt = $data['semester'] ;
                $data['data_karakter'] = $this->karakteristik_invest_semester($smt);
                $data['data_karakteristik_investasi_ket_smt1'] = $this->aspek_investasi_model->get_ket('ket_lkai_karakteristik_investasi', '1');
                $data['data_karakteristik_investasi_ket_smt2'] = $this->aspek_investasi_model->get_ket('ket_lkai_karakteristik_investasi', '2');
                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
                $data['view']  = "semesteran/aspek_investasi/index-karakteristik-investasi";
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
                    $data = $this->aspek_investasi_model->getdata('header_arus_kas', 'row_array', $id);
                    $data_detail = $this->aspek_investasi_model->getdata('data_detail_arus_kas', 'result_array', $id);
                    $combo = $this->aspek_investasi_model->get_combo('get_arus_kas', $id);
                   
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    $data['combo'] = $combo;
                    
                    // echo '<pre>';
                    // print_r($data);exit;

                }

                $data['data_aktivitas'] = $this->aspek_investasi_model->getdata('jenis_aktivitas', 'result');
                $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
                $data['view']  = "bulanan/arus_kas/input_aruskas";
             
            break;

            case 'karakteristik_investasi':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->aspek_investasi_model->getdata('karakteristik_invest', 'row_array', $id);
                    $data['data'] = $data;

                }
                $data['opt_smt'] = semester();
                $data['data_jenis'] = $this->aspek_investasi_model->getdata('mst_jenis_investasi', 'result');
                $data['bread'] = array('header'=>'Aspek Investasi', 'subheader'=>'Aspek Investasi');
                $data['view']  = "semesteran/aspek_investasi/input-karakter-invest";

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
            $data = $this->aspek_investasi_model->get_combo('get_arus_kas', $id);

            echo json_encode($data);
            break;
            case "data_pihak":
                $id = $this->input->post('jns_investasi');
                $option = $this->lib->fillcombo("data_pihak", "return", $id);
                echo $option;
            break;
            case "form_invest":
                $id = $this->input->post('jns_investasi');
                $data = $this->aspek_investasi_model->getdata('form_invest', 'result_array', $id);
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
                $data = $this->aspek_investasi_model->getdata('data_bulan_lalu_form', 'result_array', $id_invest, $jns_form);
                
                echo json_encode($data);
            break;
            case "cek_aset_investasi":
                $id_invest = $this->input->post('jns_investasi');
                $data = $this->aspek_investasi_model->getdata('cek_aset_investasi', 'row_array', $id_invest);
                
                echo json_encode($data);
            break;
        }
    }

    function cetak($mod=""){
        
        switch($mod){
            case "penempatan_investasi_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_invest'] = $this->aset_investasi_semester();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
                $template  = $this->load->view('semesteran/aspek_investasi/cetak/index-penempatan-investasi-cetak', $data,true);  
                // print_r($data);exit;
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case "penerimaan_hasil_investasi_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_hasil'] = $this->hasil_investasi_semester();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'HASIL INVESTASI');
                $template  = $this->load->view('semesteran/aspek_investasi/cetak/index-penerimaan-hasil-investasi-cetak', $data,true);  

                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'beban_investasi_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_beban'] = $this->beban_investasi_semester();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'BEBAN');
                $template  = $this->load->view('semesteran/aspek_investasi/cetak/index-beban-investasi-cetak', $data,true);  

                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;

            case 'karakteristik_investasi_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                
                $data['data_karakter'] = $this->karakteristik_invest_semester();
                $template  = $this->load->view('semesteran/aspek_investasi/cetak/index-karakteristik-investasi-cetak', $data,true);  

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
        echo $this->aspek_investasi_model->simpandata($p1, $post, $editstatus);
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
            $data['id']              = escape($this->input->post('id'));
            $data['jenis_lap']       = escape($this->input->post('jns_lap'));
            $data['keterangan_lap']  = escape($this->input->post('keterangan'));
            $data['insert_at']       = date("Y-m-d H:i:s");

            $jns_lap = $data['jenis_lap'];
            $smt = $data['semester'];

            $this->aspek_investasi_model->delete_ket($jns_lap,$smt);
            $this->aspek_investasi_model->insert_ket($data);

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
        $get_db = $this->aspek_investasi_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_semesteran/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 


     public function get_file_karakter_invest(){
        $id = $this->uri->segment(4);
        $get_db = $this->aspek_investasi_model->get_by_id_karakter_invest($id);
        $file = $get_db[0]['filedata'];
        $path = './files/file_semesteran/aspek_investasi/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    
    public function aset_investasi_semester(){
        $param_jenis = 'INVESTASI';
        $array = array();
        $invest = $this->aspek_investasi_model->getdataindex('aset_investasi_front','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array[$k]['saldo_akhir_smt1'] = (isset($v['saldo_akhir_smt1']) ? $v['saldo_akhir_smt1'] : 0) ;
            $array[$k]['saldo_akhir_smt2'] = (isset($v['saldo_akhir_smt2']) ? $v['saldo_akhir_smt2'] : 0) ;
            $array[$k]['mutasi_penambahan'] = (isset($v['mutasi_penambahan']) ? $v['mutasi_penambahan'] : 0) ;
            $array[$k]['mutasi_pengurangan'] = (isset($v['mutasi_pengurangan']) ? $v['mutasi_pengurangan'] : 0) ;
            $array[$k]['rka'] = $v['rka'];
            $pers_rka= ($v['rka']!=0)?($v['mutasi_penambahan']/$v['rka'])*100:0;
            $pers_rka = (!is_nan($pers_rka) && !is_infinite($pers_rka) ? $pers_rka : '0,00');
            $array[$k]['pers_rka'] = $pers_rka;
            $array[$k]['type'] = $v['type'];
            $array[$k]['nominal'] = $v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'];
            $pers_nom = ($v['saldo_akhir_smt1']!=0)?(($v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'])/$v['saldo_akhir_smt1'])*100:0;
            $pers_nom = (!is_nan($pers_nom) && !is_infinite($pers_nom) ? $pers_nom : '0,00');
            $array[$k]['persentase'] = $pers_nom;
            $array[$k]['jns_form'] = $v['jns_form'];
            $array[$k]['child'] = array();
            if($v['type'] == "PC"){
                $childinvest = $this->aspek_investasi_model->getdataindex('aset_investasi_front_lv3','result_array', $v['id_investasi'], $param_jenis);
                foreach ($childinvest as $key => $val) {
                    $array[$k]['child'][$key]['id'] = $val['id'];
                    $array[$k]['child'][$key]['id_investasi'] = $val['id_investasi'];
                    $array[$k]['child'][$key]['jenis_investasi'] = $val['jenis_investasi'];
                    $array[$k]['child'][$key]['saldo_akhir_smt1'] = (isset($val['saldo_akhir_smt1']) ? $val['saldo_akhir_smt1'] : 0) ;
                    $array[$k]['child'][$key]['saldo_akhir_smt2'] = (isset($val['saldo_akhir_smt2']) ? $val['saldo_akhir_smt2'] : 0) ;
                    $array[$k]['child'][$key]['mutasi_penambahan'] = (isset($val['mutasi_penambahan']) ? $val['mutasi_penambahan'] : 0) ;
                    $array[$k]['child'][$key]['mutasi_pengurangan'] = (isset($val['mutasi_pengurangan']) ? $val['mutasi_pengurangan'] : 0) ;
                    $array[$k]['child'][$key]['rka'] = $val['rka'];

                    $pers_rka2= ($val['rka']!=0)?($val['mutasi_penambahan']/$val['rka'])*100:0;
                    $pers_rka2 = (!is_nan($pers_rka2) && !is_infinite($pers_rka2) ? $pers_rka2 : '0,00');
                    $array[$k]['child'][$key]['pers_rka'] = $pers_rka2;
                    $array[$k]['child'][$key]['nominal'] = $val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1'];

                    $pers_nom2 = ($val['saldo_akhir_smt1']!=0)?(($val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1'])/$val['saldo_akhir_smt1'])*100:0;
                    $pers_nom2 = (!is_nan($pers_nom2) && !is_infinite($pers_nom2) ? $pers_nom2 : '0,00');
                    $array[$k]['child'][$key]['persentase'] = $pers_nom2;
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }

    public function hasil_investasi_semester(){
        $param_jenis = 'HASIL INVESTASI';
        $array = array();
        $invest = $this->aspek_investasi_model->getdataindex('aset_investasi_front','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array[$k]['saldo_akhir_smt1'] = (isset($v['saldo_akhir_smt1']) ? $v['saldo_akhir_smt1'] : 0) ;
            $array[$k]['saldo_akhir_smt2'] = (isset($v['saldo_akhir_smt2']) ? $v['saldo_akhir_smt2'] : 0) ;
            $array[$k]['mutasi_penambahan'] = (isset($v['mutasi_penambahan']) ? $v['mutasi_penambahan'] : 0) ;
            $array[$k]['mutasi_pengurangan'] = (isset($v['mutasi_pengurangan']) ? $v['mutasi_pengurangan'] : 0) ;
            $array[$k]['rka'] = $v['rka'];
            $pers_rka= ($v['rka']!=0)?($v['mutasi_penambahan']/$v['rka'])*100:0;
            $pers_rka = (!is_nan($pers_rka) && !is_infinite($pers_rka) ? $pers_rka : '0,00');
            $array[$k]['pers_rka'] = $pers_rka;
            $array[$k]['type'] = $v['type'];
            $array[$k]['nominal'] = $v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'];
            $pers_nom = ($v['saldo_akhir_smt1']!=0)?(($v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'])/$v['saldo_akhir_smt1'])*100:0;
            $pers_nom = (!is_nan($pers_nom) && !is_infinite($pers_nom) ? $pers_nom : '0,00');
            $array[$k]['persentase'] = $pers_nom;
            $array[$k]['jns_form'] = $v['jns_form'];
            $array[$k]['child'] = array();
            if($v['type'] == "PC"){
                $childinvest = $this->aspek_investasi_model->getdataindex('aset_investasi_front_lv3','result_array', $v['id_investasi'], $param_jenis);
                foreach ($childinvest as $key => $val) {
                    $array[$k]['child'][$key]['id'] = $val['id'];
                    $array[$k]['child'][$key]['id_investasi'] = $val['id_investasi'];
                    $array[$k]['child'][$key]['jenis_investasi'] = $val['jenis_investasi'];
                    $array[$k]['child'][$key]['saldo_akhir_smt1'] = (isset($val['saldo_akhir_smt1']) ? $val['saldo_akhir_smt1'] : 0) ;
                    $array[$k]['child'][$key]['saldo_akhir_smt2'] = (isset($val['saldo_akhir_smt2']) ? $val['saldo_akhir_smt2'] : 0) ;
                    $array[$k]['child'][$key]['mutasi_penambahan'] = (isset($val['mutasi_penambahan']) ? $val['mutasi_penambahan'] : 0) ;
                    $array[$k]['child'][$key]['mutasi_pengurangan'] = (isset($val['mutasi_pengurangan']) ? $val['mutasi_pengurangan'] : 0) ;
                    $array[$k]['child'][$key]['rka'] = $val['rka'];

                    $pers_rka2= ($val['rka']!=0)?($val['mutasi_penambahan']/$val['rka'])*100:0;
                    $pers_rka2 = (!is_nan($pers_rka2) && !is_infinite($pers_rka2) ? $pers_rka2 : '0,00');
                    $array[$k]['child'][$key]['pers_rka'] = $pers_rka2;
                    $array[$k]['child'][$key]['nominal'] = $val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1'];
                    $pers_nom2 = ($val['saldo_akhir_smt1']!=0)?(($val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1'])/$val['saldo_akhir_smt1'])*100:0;
                    $pers_nom2 = (!is_nan($pers_nom2) && !is_infinite($pers_nom2) ? $pers_nom2 : '0,00');
                    $array[$k]['child'][$key]['persentase'] = $pers_nom2;
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }


    public function beban_investasi_semester(){
        $param_jenis = 'BEBAN INVESTASI';
        $array = array();
        $invest = $this->aspek_investasi_model->getdataindex('aset_investasi_front','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array[$k]['saldo_akhir_smt1'] = (isset($v['saldo_akhir_smt1']) ? $v['saldo_akhir_smt1'] : 0) ;
            $array[$k]['saldo_akhir_smt2'] = (isset($v['saldo_akhir_smt2']) ? $v['saldo_akhir_smt2'] : 0) ;
            $array[$k]['rka'] = $v['rka'];
            $pers_rka= ($v['rka']!=0)?($v['saldo_akhir_smt2']/$v['rka'])*100:0;
            $pers_rka = (!is_nan($pers_rka) && !is_infinite($pers_rka) ? $pers_rka : '0,00');
            $array[$k]['pers_rka'] = $pers_rka;
            $array[$k]['type'] = $v['type'];
            $array[$k]['nominal'] = $v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'];
            $pers_nom = ($v['saldo_akhir_smt1']!=0)?(($v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'])/$v['saldo_akhir_smt1'])*100:0;
            $pers_nom = (!is_nan($pers_nom) && !is_infinite($pers_nom) ? $pers_nom : '0,00');
            $array[$k]['persentase'] = $pers_nom;
            $array[$k]['jns_form'] = $v['jns_form'];
            $array[$k]['child'] = array();
            if($v['type'] == "PC"){
                $childinvest = $this->aspek_investasi_model->getdataindex('aset_investasi_front_lv3','result_array', $v['id_investasi'], $param_jenis);
                foreach ($childinvest as $key => $val) {
                    $array[$k]['child'][$key]['id'] = $val['id'];
                    $array[$k]['child'][$key]['id_investasi'] = $val['id_investasi'];
                    $array[$k]['child'][$key]['jenis_investasi'] = $val['jenis_investasi'];
                    $array[$k]['child'][$key]['saldo_akhir_smt1'] = (isset($val['saldo_akhir_smt1']) ? $val['saldo_akhir_smt1'] : 0) ;
                    $array[$k]['child'][$key]['saldo_akhir_smt2'] = (isset($val['saldo_akhir_smt2']) ? $val['saldo_akhir_smt2'] : 0) ;
                    $array[$k]['child'][$key]['rka'] = $val['rka'];

                    $pers_rka2= ($val['rka']!=0)?($val['saldo_akhir_smt2']/$val['rka'])*100:0;
                    $pers_rka2 = (!is_nan($pers_rka2) && !is_infinite($pers_rka2) ? $pers_rka2 : '0,00');
                    $array[$k]['child'][$key]['pers_rka'] = $pers_rka2;
                    $array[$k]['child'][$key]['nominal'] = $val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1'];
                    $pers_nom2 = ($val['saldo_akhir_smt1']!=0)?(($val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1'])/$val['saldo_akhir_smt1'])*100:0;
                    $pers_nom2 = (!is_nan($pers_nom2) && !is_infinite($pers_nom2) ? $pers_nom2 : '0,00');
                    $array[$k]['child'][$key]['persentase'] = $pers_nom2;
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }
    
    public function karakteristik_invest_semester($smt=""){
        $param_jenis = 'INVESTASI';
        $array = array();
        $invest = $this->aspek_investasi_model->getdataindex('karakteristik_invest_lv1','result_array', $param_jenis, $smt);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array[$k]['karakteristik'] = $v['karakteristik'];
            $array[$k]['resiko'] = $v['resiko'] ;
            $array[$k]['type'] = $v['type'];
            $array[$k]['child'] = array();
            if($v['type'] == "PC"){
                $childinvest = $this->aspek_investasi_model->getdataindex('karakteristik_invest_lv2','result_array', $v['id_investasi'], $param_jenis, $smt);
                foreach ($childinvest as $key => $val) {
                    $array[$k]['child'][$key]['id'] = $val['id'];
                    $array[$k]['child'][$key]['id_investasi'] = $val['id_investasi'];
                    $array[$k]['child'][$key]['jenis_investasi'] = $val['jenis_investasi'];
                    $array[$k]['child'][$key]['karakteristik'] = $val['karakteristik'];
                    $array[$k]['child'][$key]['resiko'] = $val['resiko'];
                    $array[$k]['child'][$key]['type'] = $val['type'];
                   
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }


    

    
    
}
