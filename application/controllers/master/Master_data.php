<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_data extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('master_data_model/master_data_model');
		$this->load->model('bulanan_model/aset_investasi_model');
		
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        // $this->load->library('encryption');
		//cek login
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
        $userData=$this->session->userdata();
		$level=$this->session->userdata("level");

		//cek akses route
		if($level != 'DJA') show_error('Error 403 Access Denied', 403);
		
		$this->page_limit = 10;
		
	}
	

    public function master_nama_pihak(){
        $data['data_nama_pihak'] = $this->master_data_model->getdata('master_nama_pihak', 'result_array');
        $data['opt_user'] = dtuser();
        $data['group'] = group_pihak_investasi();
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Nama Pihak');
        $data['view']  = "master_data/nama_pihak/index_nama_pihak";
        $this->load->view('main/utama', $data);
    }

    public function mst_pihak(){
        $data['data_mst_pihak'] = $this->master_data_model->getdata('mst_pihak', 'result_array');
        $data['opt_user'] = dtuser();
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Nama Pihak');
        $data['view']  = "master_data/nama_pihak/index_mst_pihak";
        $this->load->view('main/utama', $data);
    }


    public function master_investasi(){
        $data['mst_invest'] = $this->master_data_model->getdata('master_investasi', 'result_array');
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Jenis Investasi');
        $data['view']  = "master_data/investasi/index-investasi";
        $data['opt_user'] = dtuser();
        $data['group'] = group_investasi();
        $this->load->view('main/utama', $data);
    }

    public function master_cabang(){
        $data['data_cabang'] = $this->master_data_model->getdata('master_cabang', 'result_array');
        $data['opt_user'] = dtuser();
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Cabang');
        $data['view']  = "master_data/cabang/index-cabang";
        $this->load->view('main/utama', $data);
    }


    public function master_aruskas(){
        $data['data_aruskas'] = $this->master_data_model->getdata('master_aruskas', 'result_array');
        $data['opt_user'] = dtuser();
        $data['opt_kas'] = aruskas();
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'arus kas');
        $data['view']  = "master_data/aruskas/index-aruskas";

        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('main/utama', $data);
    }

    public function master_klaim(){
        $data['data_klaim'] = $this->master_data_model->getdata('master_klaim', 'result_array');
        $data['opt_user'] = dtuser();
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Klaim');
        $data['view']  = "master_data/jenis_klaim/index-klaim";

        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('main/utama', $data);
    }


    public function master_kelompok_penerima(){
        $data['data_kelompok'] = $this->master_data_model->getdata('master_kelompok_penerima', 'result_array');
        $data['opt_user'] = dtuser();
        $data['opt_kelompok'] = flag_kelompok();
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Kelompok Penerima');
        $data['view']  = "master_data/kelompok/index-kelompok";

        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('main/utama', $data);
    }

    public function master_jenis_penerima(){
        $data['data_jenis'] = $this->master_data_model->getdata('master_jenis_penerima', 'result_array');
        $data['opt_user'] = dtuser();
        $data['bread'] = array('header'=>'Master Data', 'subheader'=>'jenis Penerima');
        $data['view']  = "master_data/jenis_penerima/index-jenis";

        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('main/utama', $data);
    }

    function get_index($mod){
        switch($mod){
            case 'index-master-investasi':
                $data['iduser'] = $this->input->post('iduser');
                $data['dtgroup'] = $this->input->post('group');

                $data['mst_invest'] = $this->master_data_model->getdata('master_investasi', 'result_array');
                $data['opt_user'] = dtuser();
                $data['group'] = group_investasi();
                $data['bread'] = array('header'=>'Jenis Investasi', 'subheader'=>'Jenis Investasi');
                $data['view']  = "master_data/investasi/index-investasi";
                // echo '<pre>';
                // print_r($data);exit;
            break;
            case 'index-master-nama-pihak':
                $data['iduser'] = $this->input->post('iduser');
                $data['dtgroup'] = $this->input->post('group');

                $data['data_nama_pihak'] = $this->master_data_model->getdata('master_nama_pihak', 'result_array');
                $data['opt_user'] = dtuser();
                $data['group'] = group_pihak_investasi();
                $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Nama Pihak');
                $data['view']  = "master_data/nama_pihak/index_nama_pihak";
                // echo '<pre>';
                // print_r($data);exit;
            break; 
            case 'index-mst-pihak':
                $data['iduser'] = $this->input->post('iduser');

                $data['data_mst_pihak'] = $this->master_data_model->getdata('mst_pihak', 'result_array');
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Nama Pihak');
                $data['view']  = "master_data/nama_pihak/index_mst_pihak";
                // echo '<pre>';
                // print_r($data);exit;
            break;
            case 'index-master-cabang':
                $data['iduser'] = $this->input->post('iduser');

                $data['data_cabang'] = $this->master_data_model->getdata('master_cabang', 'result_array');
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Cabang');
                $data['view']  = "master_data/cabang/index-cabang";
                // echo '<pre>';
                // print_r($data);exit;
            break;
            case 'index-master-aruskas':
                $data['iduser'] = $this->input->post('iduser');
                $data['kas'] = $this->input->post('kas');

                $data['data_aruskas'] = $this->master_data_model->getdata('master_aruskas', 'result_array');
                $data['opt_user'] = dtuser();
                $data['opt_kas'] = aruskas();
                $data['bread'] = array('header'=>'Master Data', 'subheader'=>'arus kas');
                $data['view']  = "master_data/aruskas/index-aruskas";
                // echo '<pre>';
                // print_r($data);exit;
            break;
            case 'index-master-klaim':
                $data['iduser'] = $this->input->post('iduser');

                $data['data_klaim'] = $this->master_data_model->getdata('master_klaim', 'result_array');
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Klaim');
                $data['view']  = "master_data/jenis_klaim/index-klaim";
                // echo '<pre>';
                // print_r($data);exit;
            break;
            case 'index-master-kelompok-penerima':
                $data['flag'] = $this->input->post('flag');

                $data['data_kelompok'] = $this->master_data_model->getdata('master_kelompok_penerima', 'result_array');
                $data['opt_kelompok'] = flag_kelompok();
                $data['bread'] = array('header'=>'Master Data', 'subheader'=>'Kelompok Penerima');
                $data['view']  = "master_data/Kelompok/index-kelompok";
                // echo '<pre>';
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
            case 'master_aset_investasi':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->master_data_model->getdata('data_master_investasi', 'row_array', $id);
                    $data_detail = $this->master_data_model->getdata('data_detail_master_investasi', 'result_array', $id);

                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    // echo '<pre>';
                    // print_r($data);exit;
                }
                $data['opt_user'] = dtuser();
                $data['group'] = group_investasi();
                $data['type'] = typeParent();
                $data['form'] = form();
                $data['opt_danabersih'] = $this->master_data_model->get_combo('mst_dana_bersih');
                $data['opt_perubahan'] = $this->master_data_model->get_combo('mst_perubahan_danabersih');
                $data['bread'] = array('header'=>'Jenis Investasi', 'subheader'=>'Jenis Investasi');
                $data['view']  = "master_data/investasi/input-master-investasi";
                 // echo '<pre>';
                 // print_r($data);exit;
                
            break;
            // per jenis investasi
            case 'master_nama_pihak':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $kd = $this->input->post('kd');
                    $iduser = $this->input->post('iduser');
                    $data = $this->master_data_model->getdata('data_master_nama_pihak_header', 'row_array', $id, $kd, $iduser);
                    $data_detail = $this->master_data_model->getdata('data_master_nama_pihak_detail', 'result_array', $data['kode_pihak'],$data['group']);

                    $data_jenis = $this->master_data_model->getdata('mst_jenis_investasi', 'result',$data['iduser'],$data['group']);
                    $data['opt_pihak'] = $this->master_data_model->get_combo('data_mst_pihak', $data['iduser']);
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    $data['data_jenis'] = $data_jenis;
                    // echo '<pre>';
                    // print_r($data);exit;
                }
                $data['opt_user'] = dtuser();
                $data['group_pihak'] = group_pihak_investasi();
                $data['bread'] = array('header'=>'Nama Pihak', 'subheader'=>'Nama Pihak');
                $data['view']  = "master_data/nama_pihak/input-nama-pihak";
            break;
            case 'mst_pihak':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->master_data_model->getdata('mst_pihak', 'row_array', $id);
                    
                    $data['data'] = $data;
                    // echo '<pre>';
                    // print_r($data);exit;
                }
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Nama Pihak', 'subheader'=>'Nama Pihak');
                $data['view']  = "master_data/nama_pihak/input-mst-pihak";
            break;
            case 'master_cabang':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->master_data_model->getdata('master_cabang_detail', 'row_array', $id);
                    $data['data'] = $data;
                }
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Cabang', 'subheader'=>'Cabang');
                $data['view']  = "master_data/cabang/input-cabang";
            break;
            case "master_aruskas":
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->master_data_model->getdata('master_aruskas', 'row_array', $id);
                    $data['data'] = $data;
                }

                $data['opt_user'] = dtuser();
                $data['opt_kas'] = aruskas();
                $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
                $data['view']  = "master_data/aruskas/input-aruskas";
            break;
            case "master_klaim":
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->master_data_model->getdata('master_klaim', 'row_array', $id);
                    $data['data'] = $data;
                }
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Klaim', 'subheader'=>'Klaim');
                $data['view']  = "master_data/jenis_klaim/input-klaim";
            break;
            case "master_kelompok_penerima":
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->master_data_model->getdata('master_kelompok_penerima', 'row_array', $id);
                    $data['data'] = $data;
                }
                $data['opt_kelompok'] = flag_kelompok();
                $data['bread'] = array('header'=>'Kelompok Penerima', 'subheader'=>'Kelompok Penerima');
                $data['view']  = "master_data/kelompok/input-kelompok";
            break;
            case "master_jenis_penerima":
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->master_data_model->getdata('master_jenis_penerima', 'row_array', $id);
                    $data['data'] = $data;
                }
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Jenis Penerima', 'subheader'=>'Jenis Penerima');
                $data['view']  = "master_data/jenis_penerima/input-jenis";
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
            case "data_jenis_invest":
                $id = $this->input->post('iduser');
                $grp = $this->input->post('group');
                $option = $this->lib->fillcombo("data_jenis_invest", "return", $id, $grp);
                echo $option;
            break;
            case "data_mst_pihak":
                $id = $this->input->post('iduser');
                $option = $this->lib->fillcombo("data_mst_pihak", "return", $id);
                echo $option;
            break;
            case "cek_kode_pihak":
                $kode_pihak = $this->input->post('kode_pihak');
                $iduser = $this->input->post('iduser');
                $data = $this->master_data_model->getdata('cek_kode_pihak', 'row_array', $kode_pihak, $iduser);
                
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
                $post[$k] = escape($this->input->post($k));
            }else{
                $post[$k] = null;
            }
            
        }
        // print_r($post);exit;
        if(isset($post['editstatus'])){$editstatus = $post['editstatus'];unset($post['editstatus']);}
        else $editstatus = $p2;
        // $post1 = htmlspecialchars($post, ENT_COMPAT, 'UTF-8');
        echo $this->master_data_model->simpandata($p1, $post, $editstatus);
    }



    public function test($value='')
    {
        $link = '12345';
        $res = str_replace('=','',base64_encode($link));
        $dec = base64_decode($res);
        echo $res.'<br>';
        echo $dec;
    }


}
