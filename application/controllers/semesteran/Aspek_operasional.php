<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspek_operasional extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('bulanan_model/perubahan_dana_bersih_model');
        $this->load->model('bulanan_model/aset_investasi_model');
        $this->load->model('semesteran_model/aspek_operasional_model');
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
        
        $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
        $data['view']  = "semesteran/aspek_operasional/index-pembayaran-kelompok";
        $this->load->view('main/utama', $data);
    }

    public function pembayaran_pensiun_aip(){

        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";
        $data['data_kelompok'] = $this->aspek_operasional_model->getdata('pembayaran_pensiun_kelompok', 'result_array','2');
        $data['data_jenis'] = $this->aspek_operasional_model->getdata('pembayaran_pensiun_jenis', 'result_array','2');

        $data['data_pembayaran_pensiun_aip_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_aip', '1');
        $data['data_pembayaran_pensiun_aip_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_aip', '2');

        $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
        $data['view']  = "semesteran/aspek_operasional/index-pembayaran-kelompok";
        $this->load->view('main/utama', $data);
    }

    public function pembayaran_pensiun_cabang(){

        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";
        $data['data_cabang_bayar'] = $this->jumlah_pembayaran_cabang();
        $data['data_cabang_terima'] = $this->jumlah_penerima_cabang();

        $data['data_pembayaran_pensiun_cbg_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_cbg', '1');
        $data['data_pembayaran_pensiun_cbg_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_cbg', '2');

        $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');

        if($this->iduser == "TSN002" || $this->iduser == "DJA001"){
            $data['view']  = "semesteran/aspek_operasional/index-pembayaran-cabang-tsn";
        }else{
            $data['view']  = "semesteran/aspek_operasional/index-pembayaran-cabang-asb";
        }
        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('main/utama', $data);
    }

    public function nilai_tunai(){

        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";

        $data['nilai_tunai_header'] = $this->nilai_tunai_header();

        $data['data_nilai_tunai_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_nilai_tunai', '1');
        $data['data_nilai_tunai_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_nilai_tunai', '2');

        $data['nilai_tunai_detail'] = $this->aspek_operasional_model->getdata('nilai_tunai_detail', 'result_array');
        $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
        $data['view']  = "semesteran/aspek_operasional/index-nilai-tunai-header";
        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('main/utama', $data);
    }

    public function beban(){

        $data['opt_user'] = dtuser();
        $data['opt_smt'] = semester();
        $data['semester'] = "";
        $data['data_beban'] = $this->beban_investasi_semester();
        $data['imbal_jasa'] = $this->nilai_imbal_jasa();
        $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'BEBAN INVESTASI');
        $data['tenaga_kerja'] = $this->aspek_operasional_model->getdata('data_beban_tenaga_kerja', 'result_array');

        $data['data_beban_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_beban', '1');
        $data['data_beban_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_beban', '2');
        $data['data_kebijakan_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_kebijakan_alokasi_smt', '1');

        $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
        $data['view']  = "semesteran/aspek_operasional/index-beban";
        $this->load->view('main/utama', $data);
    }



    function get_index($mod){
        switch($mod){
            case 'index-nilai-tunai':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['nilai_tunai_header'] = $this->nilai_tunai_header();
                $data['nilai_tunai_detail'] = $this->aspek_operasional_model->getdata('nilai_tunai_detail', 'result_array');

                $data['data_nilai_tunai_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_nilai_tunai', '1');
                $data['data_nilai_tunai_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_nilai_tunai', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
                $data['view']  = "semesteran/aspek_operasional/index-nilai-tunai-header";
                // print_r($data);exit;
            break;

            case 'index-pembayaran-kelompok':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_kelompok'] = $this->aspek_operasional_model->getdata('pembayaran_pensiun_kelompok', 'result_array','2');
                $data['data_jenis'] = $this->aspek_operasional_model->getdata('pembayaran_pensiun_jenis', 'result_array','2');
                $data['data_pembayaran_pensiun_aip_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_aip', '1');
                $data['data_pembayaran_pensiun_aip_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_aip', '2');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
                $data['view']  = "semesteran/aspek_operasional/index-pembayaran-kelompok";
            break;

            case 'index-pembayaran-cabang':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_cabang_bayar'] = $this->jumlah_pembayaran_cabang();
                $data['data_cabang_terima'] = $this->jumlah_penerima_cabang();

                $data['data_pembayaran_pensiun_cbg_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_cbg', '1');
                $data['data_pembayaran_pensiun_cbg_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_pembayaran_pensiun_cbg', '2');


                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');

                // if($data['iduser'] == "TSN002" || $this->iduser == "TSN002"){
                //     $data['view']  = "semesteran/aspek_operasional/index-pembayaran-cabang-tsn";
                // }else if ($data['iduser'] == "ASB003" || $this->iduser == "ASB003") {
                //     $data['view']  = "semesteran/aspek_operasional/index-pembayaran-cabang-asb";
                // }else{
                //     $data['view']  = "semesteran/aspek_operasional/index-pembayaran-cabang-tsn";
                // }

                if($data['iduser'] == ""){
                    if($this->iduser == "TSN002"){
                         $data['view']  = 'semesteran/aspek_operasional/index-pembayaran-cabang-tsn';  
                    }else if ($this->iduser == "ASB003") {
                         $data['view']  = 'semesteran/aspek_operasional/index-pembayaran-cabang-asb'; 
                    }
                }else{
                    if($data['iduser'] == "TSN002"){
                         $data['view']  = 'semesteran/aspek_operasional/index-pembayaran-cabang-tsn';    
                    }else if ($data['iduser'] == "ASB003") {
                         $data['view']  = 'semesteran/aspek_operasional/index-pembayaran-cabang-asb';
                    }
                }
            break;

            case 'index-beban':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');
                
                $data['data_beban'] = $this->beban_investasi_semester();
                $data['imbal_jasa'] = $this->nilai_imbal_jasa();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'BEBAN INVESTASI');
                $data['tenaga_kerja'] = $this->aspek_operasional_model->getdata('data_beban_tenaga_kerja', 'result_array');

                $data['data_beban_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_lkao_beban', '1');
                $data['data_beban_ket_smt2'] = $this->aspek_operasional_model->get_ket('ket_lkao_beban', '2');
                $data['data_kebijakan_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_kebijakan_alokasi_smt', '1');

                $data['opt_user'] = dtuser();
                $data['opt_smt'] = semester();
                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
                $data['view']  = "semesteran/aspek_operasional/index-beban";
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
            case 'pembayaran_aip':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $smt = $this->input->post('semester');

                    $data = $this->aspek_operasional_model->getdata('pembayaran_aip_header', 'row_array', $id, $smt, '2');
                    $data_detail = $this->aspek_operasional_model->getdata('pembayaran_aip_detail', 'result_array', $id, $smt, '2');
                   
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    
                    // echo '<pre>';
                    // print_r($data);exit;

                }

                $data['opt_smt'] = semester();
                $data['kelompok'] = $this->aspek_operasional_model->get_combo('data_kelompok');
                $data['jenis'] = $this->aspek_operasional_model->get_combo('data_jenis');
                $data['cabang'] = $this->aspek_operasional_model->get_combo('mst_cabang');
                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
                $data['view']  = "semesteran/aspek_operasional/input-pembayaran-aip";
             
            break;
            case 'pembayaran_pensiun_aip_cabang':
                if($sts=='edit'){

                    $id = $this->input->post('id');
                    $smt = $this->input->post('semester');

                    $data = $this->aspek_operasional_model->getdata('pembayaran_aip_cbg_header', 'row_array', $id, $smt, '2');
                    $array = array();
                    $data_detail = $this->aspek_operasional_model->getdata('pembayaran_aip_cbg_detail', 'result_array', $id, $smt, '2');
                    foreach ($data_detail as $k => $v) {
                        $array[$k]['id'] = $v['id'] ;
                        $array[$k]['iduser'] = $v['iduser'] ;
                        $array[$k]['id_cabang'] = $v['id_cabang'] ;
                        $array[$k]['id_penerima'] = $v['id_penerima'] ;
                        $array[$k]['id_kelompok'] = $v['id_kelompok'] ;
                        $array[$k]['jml_penerima'] = $v['jml_penerima'] ;
                        $array[$k]['jml_pembayaran'] = $v['jml_pembayaran'] ;
                        $array[$k]['semester'] = $v['semester'] ;
                        $array[$k]['nama_cabang'] = $v['nama_cabang'] ;
                        $array[$k]['jenis_penerima'] = $v['jenis_penerima'] ;
                        $array[$k]['child'] = array();

                        $data_detail_cbg = $this->aspek_operasional_model->getdata('pembayaran_aip_cbg_detail_cabang', 'result_array', $id, $smt, $v['id_cabang'], '2');
                        foreach ($data_detail_cbg as $key => $val) {
                            $array[$k]['child'][$key]['id'] = $val['id'] ;
                            $array[$k]['child'][$key]['iduser'] = $val['iduser'] ;
                            $array[$k]['child'][$key]['id_cabang'] = $val['id_cabang'] ;
                            $array[$k]['child'][$key]['id_penerima'] = $val['id_penerima'] ;
                            $array[$k]['child'][$key]['id_kelompok'] = $val['id_kelompok'] ;
                            $array[$k]['child'][$key]['jml_penerima'] = $val['jml_penerima'] ;
                            $array[$k]['child'][$key]['jml_pembayaran'] = $val['jml_pembayaran'] ;
                            $array[$k]['child'][$key]['semester'] = $val['semester'] ;
                            $array[$k]['child'][$key]['jenis_penerima'] = $val['jenis_penerima'] ;
                            $array[$k]['child'][$key]['nama_cabang'] = $val['nama_cabang'] ;

                        }
                    }

                    $data['data'] = $data;
                    $data['data_detail'] = $array;

                    // print_r($data);exit;
                }

                $data['opt_smt'] = semester();
                $data['kelompok'] = $this->aspek_operasional_model->get_combo('data_kelompok');
                $data['jenis'] = $this->aspek_operasional_model->get_combo('data_jenis');
                $data['cabang'] = $this->aspek_operasional_model->get_combo('mst_cabang');

                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
                $data['view']  = "semesteran/aspek_operasional/input-pembayaran-aip-cabang";

            break;

            case 'nilai_tunai':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $smt = $this->input->post('semester');
                    $data = $this->aspek_operasional_model->getdata('tbl_nilai_tunai_header', 'row_array', $id, $smt);
                    $data_detail = $this->aspek_operasional_model->getdata('tbl_nilai_tunai_detail', 'result_array', $id, $smt);
                   
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    
                    // echo '<pre>';
                    // print_r($data);exit;

                }

                $data['opt_smt'] = semester();
                $data['cabang'] = $this->aspek_operasional_model->get_combo('mst_cabang');
                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
                $data['view']  = "semesteran/aspek_operasional/input-nilai-tunai";
             
            break;
            case 'beban_tenaga_kerja':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->aspek_operasional_model->getdata('data_beban_tenaga_kerja', 'row_array', $id);
                   
                    $data['data'] = $data;
                    
                    // echo '<pre>';
                    // print_r($data);exit;

                }

                $data['opt_smt'] = semester();
                $data['cabang'] = $this->aspek_operasional_model->get_combo('mst_cabang');
                $data['bread'] = array('header'=>'Aspek Operasional', 'subheader'=>'Aspek Operasional');
                $data['view']  = "semesteran/aspek_operasional/input-beban-tenaga-kerja";
             
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
            case "cabang":
                $option = $this->lib->fillcombo("mst_cabang", "return");
                echo $option;
            break;
            case "data_jenis":
                // $option = $this->lib->fillcombo("data_jenis", "return");
                $data = $this->aspek_operasional_model->get_combo('data_jenis');
                echo json_encode($data);
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
                $data = $this->aspek_operasional_model->getdata('form_invest', 'result_array', $id);
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
                $data = $this->aspek_operasional_model->getdata('data_bulan_lalu_form', 'result_array', $id_invest, $jns_form);
                
                echo json_encode($data);
            break;
            case "cek_aset_investasi":
                $id_invest = $this->input->post('jns_investasi');
                $data = $this->aspek_operasional_model->getdata('cek_aset_investasi', 'row_array', $id_invest);
                
                echo json_encode($data);
            break;
            case "cek_nilai_tunai":
                $smt = $this->input->post('semester');
                $data = $this->aspek_operasional_model->getdata('cek_nilai_tunai', 'row_array', $smt);
                
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
        echo $this->aspek_operasional_model->simpandata($p1, $post, $editstatus);
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

            $this->aspek_operasional_model->delete_ket($jns_lap,$smt);
            $this->aspek_operasional_model->insert_ket($data);

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
        $get_db = $this->aspek_operasional_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_semesteran/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function get_file_nilai_tunai(){
        $id = $this->uri->segment(4);
        $get_db = $this->aspek_operasional_model->get_by_id_nilai_tunai($id);
        $file = $get_db[0]['filedata'];
        $path = './files/file_semesteran/aspek_operasional/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function get_file_tenaga_kerja(){
        $id = $this->uri->segment(4);
        $get_db = $this->aspek_operasional_model->get_by_id_tenaga_kerja($id);
        // print_r($get_db);exit;
        $file = $get_db[0]['filedata'];
        $path = './files/file_semesteran/aspek_operasional/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 


    function cetak($mod=""){
        
        switch($mod){
            case "nilai_tunai_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['nilai_tunai_header'] = $this->nilai_tunai_header();
                $data['nilai_tunai_detail'] = $this->aspek_operasional_model->getdata('nilai_tunai_detail', 'result_array');
                $template  = $this->load->view('semesteran/aspek_operasional/cetak/index-nilai-tunai-cetak', $data,true);  

                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'pembayaran_pensiun_aip_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_kelompok'] = $this->aspek_operasional_model->getdata('pembayaran_pensiun_kelompok', 'result_array','2');
                $data['data_jenis'] = $this->aspek_operasional_model->getdata('pembayaran_pensiun_jenis', 'result_array','2');
                $template  = $this->load->view('semesteran/aspek_operasional/cetak/index-pembayaran-aip-cetak', $data,true);  
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'pembayaran_pensiun_cabang_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_cabang_bayar'] = $this->jumlah_pembayaran_cabang();
                $data['data_cabang_terima'] = $this->jumlah_penerima_cabang();
                // echo "<pre>";
                // print_r($data);exit;
                if($data['iduser'] == ""){
                    if($this->iduser == "TSN002"){
                        $template  = $this->load->view('semesteran/aspek_operasional/cetak/index-pembayaran-cabang-tsn-cetak', $data,true);  
                    }else if ($this->iduser == "ASB003") {
                        $template  = $this->load->view('semesteran/aspek_operasional/cetak/index-pembayaran-cabang-asb-cetak', $data,true); 
                    }
                }else{
                    if($data['iduser'] == "TSN002"){
                        $template  = $this->load->view('semesteran/aspek_operasional/cetak/index-pembayaran-cabang-tsn-cetak', $data,true);  
                    }else if ($data['iduser'] == "ASB003") {
                        $template  = $this->load->view('semesteran/aspek_operasional/cetak/index-pembayaran-cabang-asb-cetak', $data,true); 
                    }
                }
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'beban_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['semester'] = $this->input->post('semester');

                $data['data_beban'] = $this->beban_investasi_semester();
                $data['imbal_jasa'] = $this->nilai_imbal_jasa();
                $data['sum'] = $this->aspek_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'BEBAN INVESTASI');
                $data['tenaga_kerja'] = $this->aspek_operasional_model->getdata('data_beban_tenaga_kerja', 'result_array');
                $data['data_kebijakan_ket_smt1'] = $this->aspek_operasional_model->get_ket('ket_kebijakan_alokasi_smt', '1');

                $template  = $this->load->view('semesteran/aspek_operasional/cetak/index-beban-cetak', $data,true);  
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

    public function nilai_tunai_header(){
        $array = array();    
        $header = $this->aspek_operasional_model->getdata('nilai_tunai_header', 'result_array');
        foreach ($header as $k => $v) {
            $judul_total = 'Manfaat Nilai Tunai'; 
            $array[$k]['uraian'] = $judul_total;
            $array[$k]['id'] = $v['id'] ;
            $array[$k]['jml_penerima_smt1'] = $v['jml_penerima_smt1'] ;
            $array[$k]['jml_pembayaran_smt1'] = $v['jml_pembayaran_smt1'] ;
            $array[$k]['jml_penerima_smt2'] = $v['jml_penerima_smt2'] ;
            $array[$k]['jml_pembayaran_smt2'] = $v['jml_pembayaran_smt2'] ;

            $array[$k]['rka_penerima'] = (isset($v['rka_penerima']) ? $v['rka_penerima'] : 0) ;
            $array[$k]['rka_pembayaran'] = (isset($v['rka_pembayaran']) ? $v['rka_pembayaran'] : 0) ;
            $array[$k]['pers_penerimaan'] = $v['pers_penerimaan'] ;
            $array[$k]['pers_pembayaran'] = $v['pers_pembayaran'] ;
            $array[$k]['pers_kenaikan_penerima'] = $v['pers_kenaikan_penerima'] ;
            $array[$k]['pers_kenaikan_pembayaran'] = $v['pers_kenaikan_pembayaran'] ;

        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }

    public function jumlah_pembayaran_cabang(){
        $array = array();    
        $mst_cabang = $this->aspek_operasional_model->get_combo('data_cabang', 'result_array', '2');
        foreach ($mst_cabang as $k => $v) {
            $judul_total = 'Jumlah';
            $array[$k]['judul_sum_bawah'] = $judul_total;
            $array[$k]['id_cabang'] = $v['id'] ;
            $array[$k]['nama_cabang'] = $v['txt'] ;

            // SEMESTER I
            $array[$k]['pns_pusat_bayar_1'] = $v['pns_pusat_bayar_1'] ;
            $array[$k]['pns_do_bayar_1'] = $v['pns_do_bayar_1'] ;
            $array[$k]['pejabat_bayar_1'] = $v['pejabat_bayar_1'] ;
            $array[$k]['hakim_bayar_1'] = $v['hakim_bayar_1'] ;
            $array[$k]['pkri_bayar_1'] = $v['pkri_bayar_1'] ;
            $array[$k]['veteran_bayar_1'] = $v['veteran_bayar_1'] ;
            $array[$k]['tni_polri_bayar_1'] = $v['tni_polri_bayar_1'] ;
            $array[$k]['pegadaian_bayar_1'] = $v['pegadaian_bayar_1'] ;
            $array[$k]['dana_kehormatan_bayar_1'] = $v['dana_kehormatan_bayar_1'] ;

            $jumlah_tsn_1 =  $v['pns_pusat_bayar_1'] + $v['pns_do_bayar_1'] + $v['pejabat_bayar_1'] + $v['hakim_bayar_1'] +
                        $v['pkri_bayar_1'] + $v['veteran_bayar_1'] +  $v['tni_polri_bayar_1'] +  $v['pegadaian_bayar_1'] + 
                        $v['dana_kehormatan_bayar_1'] ;

            $array[$k]['jumlah_smt_1_tsn'] = $jumlah_tsn_1 ;

            $array[$k]['prajurit_tni_bayar_1'] = $v['prajurit_tni_bayar_1'] ;
            $array[$k]['anggota_polri_bayar_1'] = $v['anggota_polri_bayar_1'] ;
            $array[$k]['asn_kemhan_bayar_1'] = $v['asn_kemhan_bayar_1'] ;
            $array[$k]['asn_polri_bayar_1'] = $v['asn_polri_bayar_1'] ;
            $jumlah_asb_1 = $v['prajurit_tni_bayar_1'] +  $v['anggota_polri_bayar_1'] + $v['asn_kemhan_bayar_1'] + 
                            $v['asn_polri_bayar_1'] ;
            $array[$k]['jumlah_smt_1_asb'] = $jumlah_asb_1 ;

            // SEMESTER II
            $array[$k]['pns_pusat_bayar_2'] = $v['pns_pusat_bayar_2'] ;
            $array[$k]['pns_do_bayar_2'] = $v['pns_do_bayar_2'] ;
            $array[$k]['pejabat_bayar_2'] = $v['pejabat_bayar_2'] ;
            $array[$k]['hakim_bayar_2'] = $v['hakim_bayar_2'] ;
            $array[$k]['pkri_bayar_2'] = $v['pkri_bayar_2'] ;
            $array[$k]['veteran_bayar_2'] = $v['veteran_bayar_2'] ;
            $array[$k]['tni_polri_bayar_2'] = $v['tni_polri_bayar_2'] ;
            $array[$k]['pegadaian_bayar_2'] = $v['pegadaian_bayar_2'] ;
            $array[$k]['dana_kehormatan_bayar_2'] = $v['dana_kehormatan_bayar_2'] ;

            $jumlah_tsn_2 =  $v['pns_pusat_bayar_2'] + $v['pns_do_bayar_2'] + $v['pejabat_bayar_2'] + $v['hakim_bayar_2'] +
                        $v['pkri_bayar_2'] + $v['veteran_bayar_2'] +  $v['tni_polri_bayar_2'] +  $v['pegadaian_bayar_2'] + 
                        $v['dana_kehormatan_bayar_2'] ;

            $array[$k]['jumlah_smt_2_tsn'] = $jumlah_tsn_2 ;

            $array[$k]['prajurit_tni_bayar_2'] = $v['prajurit_tni_bayar_2'] ;
            $array[$k]['anggota_polri_bayar_2'] = $v['anggota_polri_bayar_2'] ;
            $array[$k]['asn_kemhan_bayar_2'] = $v['asn_kemhan_bayar_2'] ;
            $array[$k]['asn_polri_bayar_2'] = $v['asn_polri_bayar_2'] ;
            $jumlah_asb_2 = $v['prajurit_tni_bayar_2'] +  $v['anggota_polri_bayar_2'] + $v['asn_kemhan_bayar_2'] + 
                            $v['asn_polri_bayar_2'] ;
            $array[$k]['jumlah_smt_2_asb'] = $jumlah_asb_2 ;
            $array[$k]['child'] = array();

            $data_cabang = $this->aspek_operasional_model->getdata('pembayaran_pensiun_cabang', 'result_array', $v['id'], '2');
            foreach ($data_cabang as $key => $val) {
                $array[$k]['child'][$key]['id_cabang'] = $val['id_cabang'];
                $array[$k]['child'][$key]['nama_cabang'] = $val['nama_cabang'];
                $array[$k]['child'][$key]['id_penerima'] = $val['id_penerima'];
                $array[$k]['child'][$key]['jenis_penerima'] = $val['jenis_penerima'];

                // SEMESTER I
                $array[$k]['child'][$key]['pns_pusat_bayar_1'] = $val['pns_pusat_bayar_1'];
                $array[$k]['child'][$key]['pns_do_bayar_1'] = $val['pns_do_bayar_1'];
                $array[$k]['child'][$key]['pejabat_bayar_1'] = $val['pejabat_bayar_1'];
                $array[$k]['child'][$key]['hakim_bayar_1'] = $val['hakim_bayar_1'];
                $array[$k]['child'][$key]['pkri_bayar_1'] = $val['pkri_bayar_1'];
                $array[$k]['child'][$key]['veteran_bayar_1'] = $val['veteran_bayar_1'];
                $array[$k]['child'][$key]['tni_polri_bayar_1'] = $val['tni_polri_bayar_1'];
                $array[$k]['child'][$key]['pegadaian_bayar_1'] = $val['pegadaian_bayar_1'];
                $array[$k]['child'][$key]['dana_kehormatan_bayar_1'] = $val['dana_kehormatan_bayar_1'];

                $jumlah_tsn_1 =  $val['pns_pusat_bayar_1'] + $val['pns_do_bayar_1'] + $val['pejabat_bayar_1'] + $val['hakim_bayar_1'] +
                $val['pkri_bayar_1'] + $val['veteran_bayar_1'] +  $val['tni_polri_bayar_1'] +  $val['pegadaian_bayar_1'] + 
                $val['dana_kehormatan_bayar_1'] ;

                $array[$k]['child'][$key]['jumlah_smt_1_tsn'] = $jumlah_tsn_1 ;

                $array[$k]['child'][$key]['prajurit_tni_bayar_1'] = $val['prajurit_tni_bayar_1'];
                $array[$k]['child'][$key]['anggota_polri_bayar_1'] = $val['anggota_polri_bayar_1'];
                $array[$k]['child'][$key]['asn_kemhan_bayar_1'] = $val['asn_kemhan_bayar_1'];
                $array[$k]['child'][$key]['asn_polri_bayar_1'] = $val['asn_polri_bayar_1'];

                $jumlah_asb_1 = $val['prajurit_tni_bayar_1'] +  $val['anggota_polri_bayar_1'] + $val['asn_kemhan_bayar_1'] + 
                $val['asn_polri_bayar_1'] ;
                $array[$k]['child'][$key]['jumlah_smt_1_asb'] = $jumlah_asb_1 ;

                // SEMESTER II
                $array[$k]['child'][$key]['pns_pusat_bayar_2'] = $val['pns_pusat_bayar_2'];
                $array[$k]['child'][$key]['pns_do_bayar_2'] = $val['pns_do_bayar_2'];
                $array[$k]['child'][$key]['pejabat_bayar_2'] = $val['pejabat_bayar_2'];
                $array[$k]['child'][$key]['hakim_bayar_2'] = $val['hakim_bayar_2'];
                $array[$k]['child'][$key]['pkri_bayar_2'] = $val['pkri_bayar_2'];
                $array[$k]['child'][$key]['veteran_bayar_2'] = $val['veteran_bayar_2'];
                $array[$k]['child'][$key]['tni_polri_bayar_2'] = $val['tni_polri_bayar_2'];
                $array[$k]['child'][$key]['pegadaian_bayar_2'] = $val['pegadaian_bayar_2'];
                $array[$k]['child'][$key]['dana_kehormatan_bayar_2'] = $val['dana_kehormatan_bayar_2'];

                $jumlah_tsn_2 =  $val['pns_pusat_bayar_2'] + $val['pns_do_bayar_2'] + $val['pejabat_bayar_2'] + $val['hakim_bayar_2'] +
                $val['pkri_bayar_2'] + $val['veteran_bayar_2'] +  $val['tni_polri_bayar_2'] +  $val['pegadaian_bayar_2'] + 
                $val['dana_kehormatan_bayar_2'] ;

                $array[$k]['child'][$key]['jumlah_smt_2_tsn'] = $jumlah_tsn_2 ;

                $array[$k]['child'][$key]['prajurit_tni_bayar_2'] = $val['prajurit_tni_bayar_2'];
                $array[$k]['child'][$key]['anggota_polri_bayar_2'] = $val['anggota_polri_bayar_2'];
                $array[$k]['child'][$key]['asn_kemhan_bayar_2'] = $val['asn_kemhan_bayar_2'];
                $array[$k]['child'][$key]['asn_polri_bayar_2'] = $val['asn_polri_bayar_2'];

                $jumlah_asb_2 = $val['prajurit_tni_bayar_2'] +  $val['anggota_polri_bayar_2'] + $val['asn_kemhan_bayar_2'] + 
                $val['asn_polri_bayar_2'] ;
                $array[$k]['child'][$key]['jumlah_smt_2_asb'] = $jumlah_asb_2 ;

            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }

    public function jumlah_penerima_cabang(){
        $array = array();    
        $mst_cabang = $this->aspek_operasional_model->get_combo('data_cabang', 'result_array', '2');
        foreach ($mst_cabang as $k => $v) {
            $judul_total = 'Jumlah';
            $array[$k]['judul_sum_bawah'] = $judul_total;
            $array[$k]['id_cabang'] = $v['id'] ;
            $array[$k]['nama_cabang'] = $v['txt'] ;

            // SEMESTER I
            $array[$k]['pns_pusat_terima_1'] = $v['pns_pusat_terima_1'] ;
            $array[$k]['pns_do_terima_1'] = $v['pns_do_terima_1'] ;
            $array[$k]['pejabat_terima_1'] = $v['pejabat_terima_1'] ;
            $array[$k]['hakim_terima_1'] = $v['hakim_terima_1'] ;
            $array[$k]['pkri_terima_1'] = $v['pkri_terima_1'] ;
            $array[$k]['veteran_terima_1'] = $v['veteran_terima_1'] ;
            $array[$k]['tni_polri_terima_1'] = $v['tni_polri_terima_1'] ;
            $array[$k]['pegadaian_terima_1'] = $v['pegadaian_terima_1'] ;
            $array[$k]['dana_kehormatan_terima_1'] = $v['dana_kehormatan_terima_1'] ;

            $jumlah_tsn_1 =  $v['pns_pusat_terima_1'] + $v['pns_do_terima_1'] + $v['pejabat_terima_1'] + $v['hakim_terima_1'] +
                        $v['pkri_terima_1'] + $v['veteran_terima_1'] +  $v['tni_polri_terima_1'] +  $v['pegadaian_terima_1'] + 
                        $v['dana_kehormatan_terima_1'] ;

            $array[$k]['jumlah_smt_1_tsn'] = $jumlah_tsn_1 ;

            $array[$k]['prajurit_tni_terima_1'] = $v['prajurit_tni_terima_1'] ;
            $array[$k]['anggota_polri_terima_1'] = $v['anggota_polri_terima_1'] ;
            $array[$k]['asn_kemhan_terima_1'] = $v['asn_kemhan_terima_1'] ;
            $array[$k]['asn_polri_terima_1'] = $v['asn_polri_terima_1'] ;
            $jumlah_asb_1 = $v['prajurit_tni_terima_1'] +  $v['anggota_polri_terima_1'] + $v['asn_kemhan_terima_1'] + 
                            $v['asn_polri_terima_1'] ;
            $array[$k]['jumlah_smt_1_asb'] = $jumlah_asb_1 ;

            // SEMESTER II
            $array[$k]['pns_pusat_terima_2'] = $v['pns_pusat_terima_2'] ;
            $array[$k]['pns_do_terima_2'] = $v['pns_do_terima_2'] ;
            $array[$k]['pejabat_terima_2'] = $v['pejabat_terima_2'] ;
            $array[$k]['hakim_terima_2'] = $v['hakim_terima_2'] ;
            $array[$k]['pkri_terima_2'] = $v['pkri_terima_2'] ;
            $array[$k]['veteran_terima_2'] = $v['veteran_terima_2'] ;
            $array[$k]['tni_polri_terima_2'] = $v['tni_polri_terima_2'] ;
            $array[$k]['pegadaian_terima_2'] = $v['pegadaian_terima_2'] ;
            $array[$k]['dana_kehormatan_terima_2'] = $v['dana_kehormatan_terima_2'] ;

            $jumlah_tsn_2 =  $v['pns_pusat_terima_2'] + $v['pns_do_terima_2'] + $v['pejabat_terima_2'] + $v['hakim_terima_2'] +
                        $v['pkri_terima_2'] + $v['veteran_terima_2'] +  $v['tni_polri_terima_2'] +  $v['pegadaian_terima_2'] + 
                        $v['dana_kehormatan_terima_2'] ;

            $array[$k]['jumlah_smt_2_tsn'] = $jumlah_tsn_2 ;

            $array[$k]['prajurit_tni_terima_2'] = $v['prajurit_tni_terima_2'] ;
            $array[$k]['anggota_polri_terima_2'] = $v['anggota_polri_terima_2'] ;
            $array[$k]['asn_kemhan_terima_2'] = $v['asn_kemhan_terima_2'] ;
            $array[$k]['asn_polri_terima_2'] = $v['asn_polri_terima_2'] ;
            $jumlah_asb_2 = $v['prajurit_tni_terima_2'] +  $v['anggota_polri_terima_2'] + $v['asn_kemhan_terima_2'] + 
                            $v['asn_polri_terima_2'] ;
            $array[$k]['jumlah_smt_2_asb'] = $jumlah_asb_2 ;
            $array[$k]['child'] = array();

            $data_cabang = $this->aspek_operasional_model->getdata('pembayaran_pensiun_cabang', 'result_array', $v['id'], '2');
            foreach ($data_cabang as $key => $val) {
                $array[$k]['child'][$key]['id_cabang'] = $val['id_cabang'];
                $array[$k]['child'][$key]['nama_cabang'] = $val['nama_cabang'];
                $array[$k]['child'][$key]['id_penerima'] = $val['id_penerima'];
                $array[$k]['child'][$key]['jenis_penerima'] = $val['jenis_penerima'];

                // SEMESTER I
                $array[$k]['child'][$key]['pns_pusat_terima_1'] = $val['pns_pusat_terima_1'];
                $array[$k]['child'][$key]['pns_do_terima_1'] = $val['pns_do_terima_1'];
                $array[$k]['child'][$key]['pejabat_terima_1'] = $val['pejabat_terima_1'];
                $array[$k]['child'][$key]['hakim_terima_1'] = $val['hakim_terima_1'];
                $array[$k]['child'][$key]['pkri_terima_1'] = $val['pkri_terima_1'];
                $array[$k]['child'][$key]['veteran_terima_1'] = $val['veteran_terima_1'];
                $array[$k]['child'][$key]['tni_polri_terima_1'] = $val['tni_polri_terima_1'];
                $array[$k]['child'][$key]['pegadaian_terima_1'] = $val['pegadaian_terima_1'];
                $array[$k]['child'][$key]['dana_kehormatan_terima_1'] = $val['dana_kehormatan_terima_1'];

                $jumlah_tsn_1 =  $val['pns_pusat_terima_1'] + $val['pns_do_terima_1'] + $val['pejabat_terima_1'] + $val['hakim_terima_1'] +
                $val['pkri_terima_1'] + $val['veteran_terima_1'] +  $val['tni_polri_terima_1'] +  $val['pegadaian_terima_1'] + 
                $val['dana_kehormatan_terima_1'] ;

                $array[$k]['child'][$key]['jumlah_smt_1_tsn'] = $jumlah_tsn_1 ;

                $array[$k]['child'][$key]['prajurit_tni_terima_1'] = $val['prajurit_tni_terima_1'];
                $array[$k]['child'][$key]['anggota_polri_terima_1'] = $val['anggota_polri_terima_1'];
                $array[$k]['child'][$key]['asn_kemhan_terima_1'] = $val['asn_kemhan_terima_1'];
                $array[$k]['child'][$key]['asn_polri_terima_1'] = $val['asn_polri_terima_1'];

                $jumlah_asb_1 = $val['prajurit_tni_terima_1'] +  $val['anggota_polri_terima_1'] + $val['asn_kemhan_terima_1'] + 
                $val['asn_polri_terima_1'] ;
                $array[$k]['child'][$key]['jumlah_smt_1_asb'] = $jumlah_asb_1 ;

                // SEMESTER II
                $array[$k]['child'][$key]['pns_pusat_terima_2'] = $val['pns_pusat_terima_2'];
                $array[$k]['child'][$key]['pns_do_terima_2'] = $val['pns_do_terima_2'];
                $array[$k]['child'][$key]['pejabat_terima_2'] = $val['pejabat_terima_2'];
                $array[$k]['child'][$key]['hakim_terima_2'] = $val['hakim_terima_2'];
                $array[$k]['child'][$key]['pkri_terima_2'] = $val['pkri_terima_2'];
                $array[$k]['child'][$key]['veteran_terima_2'] = $val['veteran_terima_2'];
                $array[$k]['child'][$key]['tni_polri_terima_2'] = $val['tni_polri_terima_2'];
                $array[$k]['child'][$key]['pegadaian_terima_2'] = $val['pegadaian_terima_2'];
                $array[$k]['child'][$key]['dana_kehormatan_terima_2'] = $val['dana_kehormatan_terima_2'];

                $jumlah_tsn_2 =  $val['pns_pusat_terima_2'] + $val['pns_do_terima_2'] + $val['pejabat_terima_2'] + $val['hakim_terima_2'] +
                $val['pkri_terima_2'] + $val['veteran_terima_2'] +  $val['tni_polri_terima_2'] +  $val['pegadaian_terima_2'] + 
                $val['dana_kehormatan_terima_2'] ;

                $array[$k]['child'][$key]['jumlah_smt_2_tsn'] = $jumlah_tsn_2 ;

                $array[$k]['child'][$key]['prajurit_tni_terima_2'] = $val['prajurit_tni_terima_2'];
                $array[$k]['child'][$key]['anggota_polri_terima_2'] = $val['anggota_polri_terima_2'];
                $array[$k]['child'][$key]['asn_kemhan_terima_2'] = $val['asn_kemhan_terima_2'];
                $array[$k]['child'][$key]['asn_polri_terima_2'] = $val['asn_polri_terima_2'];

                $jumlah_asb_2 = $val['prajurit_tni_terima_2'] +  $val['anggota_polri_terima_2'] + $val['asn_kemhan_terima_2'] + 
                $val['asn_polri_terima_2'] ;
                $array[$k]['child'][$key]['jumlah_smt_2_asb'] = $jumlah_asb_2 ;

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
            $array[$k]['mutasi_penambahan'] = (isset($v['mutasi_penambahan']) ? $v['mutasi_penambahan'] : 0) ;
            $array[$k]['mutasi_pengurangan'] = (isset($v['mutasi_pengurangan']) ? $v['mutasi_pengurangan'] : 0) ;
            $array[$k]['rka'] = $v['rka'];
            $pers_rka= ($v['rka']!=0)?($v['mutasi_penambahan']/$v['rka'])*100:0;
            $array[$k]['pers_rka'] = $pers_rka;
            $array[$k]['type'] = $v['type'];
            $array[$k]['nominal'] = $v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'];
            $array[$k]['persentase'] = ($v['saldo_akhir_smt1']!=0)?(($v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'])/$v['saldo_akhir_smt1'])*100:0;
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
                    $array[$k]['child'][$key]['pers_rka'] = $pers_rka2;
                    $array[$k]['child'][$key]['nominal'] = $val['saldo_akhir_smt2'] - $val['saldo_akhir_smt1'];
                    $array[$k]['child'][$key]['persentase'] = ($v['saldo_akhir_smt1']!=0)?(($v['saldo_akhir_smt2'] - $v['saldo_akhir_smt1'])/$v['saldo_akhir_smt1'])*100:0;
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }

    public function nilai_imbal_jasa(){
        $array = array();
        $imbal_jasa = $this->aspek_operasional_model->getdata('lkob_imbal_jasa', 'result_array');
        foreach ($imbal_jasa as $k => $v) {
            if($v['group'] == 'BEBAN'){
                $judul='Beban Investasi';
            }else{
                $judul='Hasil Investasi';
            }

            $nominal = $v['saldo_akhir_smt2']-$v['saldo_akhir_smt1'];
            $persen = ($v['saldo_akhir_smt1']!=0)?($nominal/$v['saldo_akhir_smt1'])*100:0;

            $array[$k]['id_perubahan_dana_bersih'] = $v['id_perubahan_dana_bersih'];
            $array[$k]['group'] = $judul;
            $array[$k]['saldo_akhir_smt1'] = $v['saldo_akhir_smt1'];
            $array[$k]['saldo_akhir_smt2'] = $v['saldo_akhir_smt2'];
            $array[$k]['nominal'] = $nominal;
            $array[$k]['persentase'] = $persen;
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }
}
