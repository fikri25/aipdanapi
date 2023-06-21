<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arus_kas extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('bulanan_model/arus_kas_model');
        $this->load->model('bulanan_model/perubahan_dana_bersih_model');
		$this->load->model('bulanan_model/aset_investasi_model');
		
        $this->load->library('form_validation');
        $this->load->library('user_agent');
		// $this->load->library('pdf');
		//cek login
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		$userData=$this->session->userdata();
		//cek akses route
		//if($userData['idusergroup'] !== '001') show_404();
        $this->iduser = $this->session->userdata('iduser');
        $this->tahun = $this->session->userdata('tahun');
		$this->page_limit = 10;
		
	}
	
	
	public function index(){
        $data['arus_kas'] = $this->nilai_arus_kas();
        $data['kas_bank'] = $this->arus_kas_model->getdata('kas_bank', 'row_array');
        $data['data_arus_kas_ket'] = $this->arus_kas_model->get_ket('ket_arus_kas');
        $data['bulan'] = bulan();
        $data['bulan_prev'] = bulan_prev();
        $data['status'] = pendahuluan_bln();
        $data['opt_user'] = dtuser();
  //       echo "<pre>";
		// print_r($data);exit;
		$data['bread'] = array('header'=>'Arus Kas ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Arus Kas');
		$data['view']  = "bulanan/arus_kas/data_aruskas";
		$this->load->view('main/utama', $data);
    }



    // export pdf
    public function laporan_ArusKas_PDF(){
       $data['bulan'] = bulan();
       $data['arus_kas'] = $this->nilai_arus_kas();
       $data['kas_bank'] = $this->arus_kas_model->getdata('kas_bank', 'row_array');
       $data['data_arus_kas_ket'] = $this->arus_kas_model->get_ket('ket_arus_kas');
       $html=$this->load->view('bulanan/arus_kas/index_pdf_export', $data,true);  
        // print_r($data);exit;
        // For PHP 7.4
       $pdf = new \Mpdf\Mpdf();
       $pdf->WriteHTML($html,2);
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
        // $pdf->WriteHTML($html,2);

        // $pdf->Output();
        
    }

    function cetak($mod=""){
        
        switch($mod){
            case "aruskas_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['bulan'] = bulan();
                $data['arus_kas'] = $this->nilai_arus_kas();
                $data['kas_bank'] = $this->arus_kas_model->getdata('kas_bank', 'row_array');
                $data['data_arus_kas_ket'] = $this->arus_kas_model->get_ket('ket_arus_kas');
                $template=$this->load->view('bulanan/arus_kas/index_pdf_export', $data,true);  
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
            case 'index-aruskas':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');

                $data['arus_kas'] = $this->nilai_arus_kas();
                $data['kas_bank'] = $this->arus_kas_model->getdata('kas_bank', 'row_array');
                $data['data_arus_kas_ket'] = $this->arus_kas_model->get_ket('ket_arus_kas');
                // $data['sum_dana_bersih'] = $this->arus_kas_model->get_sum_danabersih($filter['id_bulan']);

                $data['opt_user'] = dtuser();
                $data['bulan_prev'] = bulan_prev();
                $data['bulan'] = bulan();
                $data['bread'] = array('header'=>'Arus Kas ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Arus Kas');
                $data['view']  = "bulanan/arus_kas/data_aruskas";
              
                // print_r($data);exit;
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
                    
                    // echo '<pre>';
                    // print_r($data);exit;

                }

                $data['data_aktivitas'] = $this->arus_kas_model->getdata('jenis_aktivitas', 'result');
                $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
                $data['view']  = "bulanan/arus_kas/input_aruskas";
             
            break;

            case 'table_arus_kas':
                $array = array();
                $aktivitas = $this->arus_kas_model->get_combo('jenis_aktivitas','result_array');
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
            $data = $this->arus_kas_model->get_combo('get_arus_kas', $id);

            echo json_encode($data);
            break;
            case "data_pihak":
                $id = $this->input->post('jns_investasi');
                $option = $this->lib->fillcombo("data_pihak", "return", $id);
                echo $option;
            break;
            case "form_invest":
                $id = $this->input->post('jns_investasi');
                $data = $this->aset_investasi_model->getdata('form_invest', 'result_array', $id);
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
                $data = $this->aset_investasi_model->getdata('data_bulan_lalu_form', 'result_array', $id_invest, $jns_form);
                
                echo json_encode($data);
            break;
            case "cek_aset_investasi":
                $id_invest = $this->input->post('jns_investasi');
                $data = $this->aset_investasi_model->getdata('cek_aset_investasi', 'row_array', $id_invest);
                
                echo json_encode($data);
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
        echo $this->arus_kas_model->simpandata($p1, $post, $editstatus);
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
            $data['tahun']          = $this->session->userdata('tahun');
            $data['id']              = escape($this->input->post('id'));
            $data['jenis_lap']       = escape($this->input->post('jns_lap'));
            $data['keterangan_lap']  = escape($this->input->post('keterangan'));
            $data['insert_at']       = date("Y-m-d H:i:s");

            $jns_lap = $data['jenis_lap'];
            $id_bulan = $data['id_bulan'];

            $this->arus_kas_model->delete_ket($jns_lap,$id_bulan);
            $this->arus_kas_model->insert_ket($data);

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
        $get_db = $this->arus_kas_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_bulanan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function get_file_kas(){
        $id = $this->uri->segment(4);
        $get_db = $this->arus_kas_model->get_by_id_kas($id);
        // print_r($get_db);exit();
        $file = $get_db[0]['filedata'];
        $path = './files/file_bulanan/arus_kas/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    }

    public function nilai_arus_kas(){
        $array = array();
        $aktivitas = $this->arus_kas_model->getdata('jenis_aktivitas','result_array');
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
            $array[$k]['sum'] =  (isset($v['sum']) ? $v['sum'] : 0) ;
            $array[$k]['sumprev'] =(isset($v['sumprev']) ? $v['sumprev'] : 0) ;
            $array[$k]['child'] = array();

            $arus_kas = $this->arus_kas_model->getdata('jenis_aktivitas_by','result_array', $v['jenis_kas']);
            foreach ($arus_kas as $key => $val) {
                $array[$k]['child'][$key]['id_aruskas'] = $val['id_aruskas'];
                $array[$k]['child'][$key]['arus_kas'] = $val['arus_kas'];
                $array[$k]['child'][$key]['subchild'] = array();

                $nilai_arus_kas = $this->arus_kas_model->getdata('nilai_arus_kas','result_array', $val['id_aruskas']);
                foreach ($nilai_arus_kas as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['id_aruskas'] = $y['id_aruskas'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_bulan_berjalan'] = (isset($y['saldo_bulan_berjalan']) ? $y['saldo_bulan_berjalan'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_bulan_lalu'] = (isset($y['saldo_bulan_lalu']) ? $y['saldo_bulan_lalu'] : 0) ;

                    

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
