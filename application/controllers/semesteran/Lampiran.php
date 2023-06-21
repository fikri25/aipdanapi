<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lampiran extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('bulanan_model/perubahan_dana_bersih_model');
        $this->load->model('bulanan_model/aset_investasi_model');
        $this->load->model('semesteran_model/operasional_belanja_model');
        $this->load->model('semesteran_model/aspek_operasional_model');
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
        $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
        $data['total_bersih'] = $this->operasional_belanja_model->getdata('dana_bersih_lv1','result');
        // print_r($data);exit;
        
        $data['bread'] = array('header'=>'Lampiran Pendukung', 'subheader'=>'Lampiran Pendukung');
        $data['view']  = "semesteran/lampiran/index-danabersih";
        $this->load->view('main/utama', $data);
    }

    public function perubahan_danabersih(){
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";

        $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
        $data['tot_perubahan'] = $this->operasional_belanja_model->getdata('perubahan_danabersih_lv1','result');
        $data['total_bersih'] = $this->operasional_belanja_model->getdata('dana_bersih_lv1','result');
        // echo "<pre>";
        // print_r( $data['tot_perubahan']);exit;

        $data['data_perubahan_danabersih_ket_smt1'] = $this->operasional_belanja_model->get_ket('ket_lkob_perubahan_danabersih', '1');
        $data['data_perubahan_danabersih_ket_smt2'] = $this->operasional_belanja_model->get_ket('ket_lkob_perubahan_danabersih', '2');
        
        $data['bread'] = array('header'=>'Lampiran Pendukung', 'subheader'=>'Lampiran Pendukung');
        $data['view']  = "semesteran/lampiran/index-perubahan-danabersih";
        $this->load->view('main/utama', $data);
    }


    public function dana_bersih(){
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";

        $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
        $data['total_bersih'] = $this->operasional_belanja_model->getdata('dana_bersih_lv1','result');
        // print_r($data);exit;

        $data['data_dana_bersih_ket_smt1'] = $this->operasional_belanja_model->get_ket('ket_lkob_dana_bersih', '1');
        $data['data_dana_bersih_ket_smt2'] = $this->operasional_belanja_model->get_ket('ket_lkob_dana_bersih', '2');
        
        $data['bread'] = array('header'=>'Lampiran Pendukung', 'subheader'=>'Lampiran Pendukung');
        $data['view']  = "semesteran/lampiran/index-danabersih";
        $this->load->view('main/utama', $data);
    }

    public function Aruskas(){
        $data['arus_kas'] = $this->nilai_arus_kas();
        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";

        $data['kas_bank'] = $this->operasional_belanja_model->getdata('kas_bank', 'row_array');
        $data['data_aruskas_ket_smt1'] = $this->operasional_belanja_model->get_ket('ket_lkob_aruskas', '1');
        $data['data_aruskas_ket_smt2'] = $this->operasional_belanja_model->get_ket('ket_lkob_aruskas', '2');
        // print_r($data);exit;
        $data['bread'] = array('header'=>'Lampiran Pendukung', 'subheader'=>'Lampiran Pendukung');
        $data['view']  = "semesteran/lampiran/index-aruskas";
        $this->load->view('main/utama', $data);
    }

    

    function get_index($mod){
        switch($mod){
            case 'index-lampiran-aruskas':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['arus_kas'] = $this->nilai_arus_kas();
                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['kas_bank'] = $this->operasional_belanja_model->getdata('kas_bank', 'row_array');
                $data['data_aruskas_ket_smt1'] = $this->operasional_belanja_model->get_ket('ket_lkob_aruskas', '1');
                $data['data_aruskas_ket_smt2'] = $this->operasional_belanja_model->get_ket('ket_lkob_aruskas', '2');

                $data['bread'] = array('header'=>'Lampiran Pendukung', 'subheader'=>'Lampiran Pendukung');
                $data['view']  = "semesteran/lampiran/index-aruskas";
              
                // print_r($data);exit;
            break;
            case 'index-lampiran-perubahan-danabersih':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
          
                $data['tot_perubahan'] = $this->operasional_belanja_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->operasional_belanja_model->getdata('dana_bersih_lv1','result');
          

                $data['data_perubahan_danabersih_ket_smt1'] = $this->operasional_belanja_model->get_ket('ket_lkob_perubahan_danabersih', '1');
                $data['data_perubahan_danabersih_ket_smt2'] = $this->operasional_belanja_model->get_ket('ket_lkob_perubahan_danabersih', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Lampiran Pendukung', 'subheader'=>'Lampiran Pendukung');
                $data['view']  = "semesteran/lampiran/index-perubahan-danabersih";
            break;
            case 'index-lampiran-danabersih':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->operasional_belanja_model->getdata('dana_bersih_lv1','result');

                $data['data_dana_bersih_ket_smt1'] = $this->operasional_belanja_model->get_ket('ket_lkob_dana_bersih', '1');
                $data['data_dana_bersih_ket_smt2'] = $this->operasional_belanja_model->get_ket('ket_lkob_dana_bersih', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Lampiran Pendukung', 'subheader'=>'Lampiran Pendukung');
                $data['view']  = "semesteran/lampiran/index-danabersih";
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
                    $data = $this->arus_kas_model->getdata('header_arus_kas', 'row_array', $id);
                    $data_detail = $this->arus_kas_model->getdata('data_detail_arus_kas', 'result_array', $id);
                    $combo = $this->arus_kas_model->get_combo('get_arus_kas', $id);
                   
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    $data['combo'] = $combo;

                }

                $data['data_aktivitas'] = $this->arus_kas_model->getdata('jenis_aktivitas', 'result');
                $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
                $data['view']  = "bulanan/arus_kas/input_aruskas";
             
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
            case "jenis_klaim":
                $option = $this->lib->fillcombo("jenis_klaim", "return");
                echo $option;
            break; 
            
        }
    }

    function cetak($mod=""){
        
        switch($mod){
            case "lampiran_danabersih_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->operasional_belanja_model->getdata('dana_bersih_lv1','result');

                $template  = $this->load->view('semesteran/lampiran/cetak/index-danabersih-cetak', $data,true);  
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case "lampiran_perubahan_danabersih_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                $data['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
                $data['tot_perubahan'] = $this->operasional_belanja_model->getdata('perubahan_danabersih_lv1','result');
                $data['total_bersih'] = $this->operasional_belanja_model->getdata('dana_bersih_lv1','result');
                
                $template  = $this->load->view('semesteran/lampiran/cetak/index-perubahan-danabersih-cetak', $data,true);
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case "lampiran_aruskas_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                $data['arus_kas'] = $this->nilai_arus_kas();
                $data['kas_bank'] = $this->operasional_belanja_model->getdata('kas_bank', 'row_array');

                $template  = $this->load->view('semesteran/lampiran/cetak/index-aruskas-cetak', $data,true);
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
        echo $this->operasional_belanja_model->simpandata($p1, $post, $editstatus);
    }

   
    
    public function save_keterangan(){
        $tahun = $this->session->userdata('tahun');
        $level = $this->session->userdata('level');
        $semester = $this->input->post('semester');

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

        $this->operasional_belanja_model->delete_ket($jns_lap,$smt);
        $this->operasional_belanja_model->insert_ket($data);

        $this->session->set_flashdata('form_true',
            '<div class="alert alert-success">
            <h4>Berhasil.</h4>
            <p>Data keterangan berhasil Disimpan.</p>
            </div>');
        redirect ($this->agent->referrer());
    }


    public function get_file(){
        $id = $this->uri->segment(4);
        $get_db = $this->arus_kas_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_semesteran/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function nilai_arus_kas(){
        $array = array();
        $aktivitas = $this->operasional_belanja_model->getdata('jenis_aktivitas','result_array');
        foreach ($aktivitas as $k => $v) {

            if($v['jenis_kas'] == 'INVESTASI'){
                $judul = 'Arus Kas Bersih Digunakan Untuk Aktivitas Investasi';
            }else if($v['jenis_kas'] == 'OPERASIONAL'){
                $judul = 'Arus Kas Bersih Diperoleh Dari Aktivitas Operasional';
            }else if($v['jenis_kas'] == 'PENDANAAN'){
                $judul = 'Arus Kas Bersih Diperoleh dari Aktivitas Pendanaan';
            }

            $array[$k]['judul_kas'] = 'ARUS KAS DARI AKTIVITAS '.$v['jenis_kas'];
            $array[$k]['jenis_kas'] = $v['jenis_kas'];
            $array[$k]['judul'] = $judul;
            $array[$k]['sum'] =  (isset($v['saldo_smt1']) ? $v['saldo_smt1'] : 0) ;
            $array[$k]['sumprev'] = (isset($v['saldo_smt2']) ? $v['saldo_smt2'] : 0) ;
            $array[$k]['child'] = array();

            $arus_kas = $this->operasional_belanja_model->getdata('jenis_aktivitas_by','result_array', $v['jenis_kas']);
            foreach ($arus_kas as $key => $val) {
                $array[$k]['child'][$key]['id_aruskas'] = $val['id_aruskas'];
                $array[$k]['child'][$key]['arus_kas'] = $val['arus_kas'];
                $array[$k]['child'][$key]['subchild'] = array();

                $nilai_arus_kas = $this->operasional_belanja_model->getdata('nilai_arus_kas','result_array', $val['id_aruskas']);
                foreach ($nilai_arus_kas as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['id_aruskas'] = $y['id_aruskas'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_smt1'] = (isset($y['saldo_smt1']) ? $y['saldo_smt1'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_smt2'] = (isset($y['saldo_smt2']) ? $y['saldo_smt2'] : 0) ;

                    

                }
            }
        }
        // echo '<pre>';
        // print_r($array);exit;
        return $array;

        // $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
        // $data['view']  = "bulanan/arus_kas/data_aruskas";
        // $this->load->view('main/utama', $data);
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
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir']) ? $v['saldo_akhir_smt1'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_bln_lalu']) ? $v['saldo_akhir_smt2'] : 0) ;
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
                $array[$k]['child'][$key]['sum_prev_lvl2'] =  (isset($val['saldo_akhir_smt2']) ? $val['saldo_akhir_smt2'] : 0) ;
                $array[$k]['child'][$key]['subchild'] = array();

                $dana_bersih_lv3 = $this->aspek_keuangan_model->getdata('dana_bersih_lv3','result_array', $val['id_dana_bersih']);
                foreach ($dana_bersih_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type_sub_jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = (isset($y['saldo_akhir_smt1']) ? $y['saldo_akhir_smt1'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_bln_lalu'] = (isset($y['saldo_akhir_smt2']) ? $y['saldo_akhir_smt2'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type_sub_jenis_investasi'] == 'PC'){
                        $type = 'C';
                        $dana_bersih_lv4 = $this->aspek_keuangan_model->getdata('dana_bersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($dana_bersih_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type_sub_jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir'] = (isset($zz['saldo_akhir_smt1']) ? $zz['saldo_akhir_smt1'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_bln_lalu'] = (isset($zz['saldo_akhir_smt2']) ? $zz['saldo_akhir_smt2'] : 0) ;
                        }
                    }

                }
            }
        }
        // echo '<pre>';
        // print_r($array);exit;
        return $array;

        // $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
        // $data['view']  = "bulanan/arus_kas/data_aruskas";
        // $this->load->view('main/utama', $data);
    }

    public function nilai_perubahan_danabersih(){
        $array = array();
        $perubahan_lv1 = $this->operasional_belanja_model->getdata('perubahan_danabersih_lv1','result_array');
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
            $array[$k]['child'] = array();

            $perubahan_lv2 = $this->operasional_belanja_model->getdata('perubahan_danabersih_lv2','result_array', $v['uraian']);
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
                $array[$k]['child'][$key]['subchild'] = array();

                $perubahan_lv3 = $this->operasional_belanja_model->getdata('perubahan_danabersih_lv3','result_array', $val['group']);
                foreach ($perubahan_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = (isset($y['saldo_akhir_smt1']) ? $y['saldo_akhir_smt1'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_bln_lalu'] = (isset($y['saldo_akhir_smt2']) ? $y['saldo_akhir_smt2'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type'] == 'PC'){
                        $type = 'C';
                        $perubahan_lv4 = $this->operasional_belanja_model->getdata('perubahan_danabersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($perubahan_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir'] = (isset($zz['saldo_akhir_smt1']) ? $zz['saldo_akhir_smt1'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_bln_lalu'] = (isset($zz['saldo_akhir_smt2']) ? $zz['saldo_akhir_smt2'] : 0) ;
                        }
                    }

                }
            }
        }
        // echo '<pre>';
        // print_r($array);exit;
        return $array;

        // $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
        // $data['view']  = "bulanan/arus_kas/data_aruskas";
        // $this->load->view('main/utama', $data);
    }

    

}

