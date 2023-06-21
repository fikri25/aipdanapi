<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aset_investasi extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('bulanan_model/aset_investasi_model');
		// echo "string";exit;
        $this->load->model('bulanan_model/pendahuluan_model');
		
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        // $this->load->library('m_pdf');

        // $this->load->library('pdf');
		
		//cek login
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		$userData=$this->session->userdata();
		//cek akses route
		// if($userData['idusergroup'] !== '001') show_404();
        $this->iduser = $this->session->userdata('iduser');
		$this->tahun = $this->session->userdata('tahun');
		$this->page_limit = 15;
		
		
	}
	
	
	public function index(){
		// echo "string";exit;
		$bln=$this->session->userdata('id_bulan');
        $data['data_invest'] = $this->aset_investasi_front();
        $data['data_pendahuluan'] = $this->pendahuluan_model->get_ket($bln);
        $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
        $data['data_posisi_investasi_ket'] = $this->aset_investasi_model->get_ket('ket_aset_investasi');
        $data['bulan'] = bulan();
        $data['status'] = pendahuluan_bln();
        $data['opt_user'] = dtuser();

        $data['bread'] = array('header'=>'Aset Investasi ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Investasi');
        $data['view']  = "bulanan/aset_investasi/index-investasi";
        $this->load->view('main/utama', $data);
    }

    // export pdf
    public function laporan_investasi_PDF(){
        $data['bulan'] = bulan();
        $data['data_invest'] = $this->aset_investasi_front();
        $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
        $html=$this->load->view('bulanan/aset_investasi/index_pdf_export', $data,true);  
        // print_r($data);exit;
        // For PHP 7.4
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html,2);
        $pdf->Output();

        // $this->load->library('Mlpdf');
        // $this->mlpdf->load();
        // $this->mlpdf->pdf->SetDisplayMode('fullpage');
        // $this->mlpdf->pdf->setFooter('{PAGENO}');
        // $this->mlpdf->pdf->simpleTables = true;
        // $this->mlpdf->pdf->packTableData = true;
        // $keep_table_proportions = TRUE;
        // $shrink_tables_to_fit = 1;
        // $this->mlpdf->pdf->use_kwt=true; //pagebreak
        // $this->mlpdf->pdf->SetTitle($title);
        // $this->mlpdf->pdf->WriteHTML($html,2);
        
        // $this->mlpdf->pdf->Output();


    }

    function cetak($mod=""){
        
        switch($mod){
            case "aset_investasi_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['bulan'] = bulan();
                $data['data_invest'] = $this->aset_investasi_front();
                $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
                $template=$this->load->view('bulanan/aset_investasi/index_pdf_export', $data,true);  
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
            case 'index-investasi':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');

                $data['data_invest'] = $this->aset_investasi_front();
                $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
                
                $filter['iduser'] =  $data['iduser'];
                $filter['id_bulan'] = $data['id_bulan'];
                $data['data_posisi_investasi_ket'] = $this->aset_investasi_model->get_ket('ket_aset_investasi');

                $data['opt_user'] = dtuser();
                $data['bulan'] = bulan();
                $data['bread'] = array('header'=>'Aset Investasi ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Investasi');
                $data['view']  = "bulanan/aset_investasi/index-investasi";
              
                // print_r($data['data_invest']);exit;
            break;
            case 'sinkron-investasi':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->iduser;

                // $data['data_invest_bulanlalu'] = $this->GetBulanLaluHeader($data['id_bulan']);
                $data['data_invest'] = $this->aset_investasi_front();
                $data['data_invest_bulanlalu'] = $this->GetBulanLaluDetail($data['id_bulan']);
                $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'INVESTASI');
                
                $filter['iduser'] =  $data['iduser'];
                $filter['id_bulan'] = $data['id_bulan'];
                $data['data_posisi_investasi_ket'] = $this->aset_investasi_model->get_ket('ket_aset_investasi');

                $data['opt_user'] = dtuser();
                $data['bulan'] = bulan();
                $data['bread'] = array('header'=>'Aset Investasi ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Investasi');
                $data['view']  = "bulanan/aset_investasi/index-investasi";
              
                // print_r($data['data_invest']);exit;
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
        $bln = $this->input->post('id_bulan');
		$usr = $this->input->post('iduser');
		if(isset($sts)){
			$data['editstatus'] = $sts;
		}else{
			$data['editstatus'] = "";
		}
		switch($mod){
            case 'aset_investasi':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $jns_form = $this->input->post('jns_form');
                    $data = $this->aset_investasi_model->getdata('data_aset_investasi', 'row_array', $id, $jns_form);
                    $data_detail = $this->aset_investasi_model->getdata('data_detail_aset_investasi', 'result_array', $id, $jns_form);
                    $combo = $this->aset_investasi_model->get_combo('data_pihak', $data['id_investasi']);
                    // print_r($data);exit;
                    $data['cabang'] = $this->aset_investasi_model->get_combo('cabang');
                    $data['combo'] = $combo;
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;

                }

                $data['data_jenis'] = $this->aset_investasi_model->getdata('mst_jenis_investasi', 'result');
                $data['bread'] = array('header'=>'Aset Investasi', 'subheader'=>'Investasi');
                $data['view']  = "bulanan/aset_investasi/input_aset_investasi";
            break;
            case 'detail_aset_investasi':
				if($sts=='edit'){
					$id = $this->input->post('id');
					$jns_form = $this->input->post('jns_form');
					$data = $this->aset_investasi_model->getdata('data_aset_investasi', 'row_array', $id, $jns_form);
					$data_detail = $this->aset_investasi_model->getdata('data_detail_aset_investasi', 'result_array', $id, $jns_form);
					$combo = $this->aset_investasi_model->get_combo('data_pihak', $data['id_investasi']);

					$data['combo'] = $combo;
					$data['data'] = $data;
					$data['data_detail'] = $data_detail;

				}

                $data['data_jenis'] = $this->aset_investasi_model->getdata('mst_jenis_investasi', 'result');

				$data['bread'] = array('header'=>'Aset Investasi', 'subheader'=>'Investasi');
				$data['view']  = "bulanan/aset_investasi/detail_data_aset_investasi";
			break;
            case 'bukan_investasi':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $jns_form = $this->input->post('jns_form');
                    $data = $this->aset_investasi_model->getdata('data_aset_investasi', 'row_array', $id, $jns_form);
                    $data_detail = $this->aset_investasi_model->getdata('data_detail_aset_investasi', 'result_array', $id, $jns_form);
                    $combo = $this->aset_investasi_model->get_combo('data_pihak', $data['id_investasi']);

                    $data['combo'] = $combo;
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;

                }
                $data['data_jenis'] = $this->aset_investasi_model->getdata('mst_bkn_investasi', 'result');
                $data['bread'] = array('header'=>'Aset Bukan Investasi', 'subheader'=>'Bukan Investasi');
                $data['view']  = "bulanan/bukan_investasi/input_aset_bukan_investasi";
            break;
            case 'detail_bukan_investasi':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $jns_form = $this->input->post('jns_form');
                    $data = $this->aset_investasi_model->getdata('data_aset_investasi', 'row_array', $id, $jns_form);
                    $data_detail = $this->aset_investasi_model->getdata('data_detail_aset_investasi', 'result_array', $id, $jns_form);
                    $combo = $this->aset_investasi_model->get_combo('data_pihak', $data['id_investasi']);

                    $data['combo'] = $combo;
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                }

                $data['data_jenis'] = $this->aset_investasi_model->getdata('mst_bkn_investasi', 'result');
                $data['bread'] = array('header'=>'Aset Bukan Investasi', 'subheader'=>'Bukan Investasi');
                $data['view']  = "bulanan/bukan_investasi/detail_aset_bukan_investasi";
            break;
            case 'hasil_investasi':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $data = $this->aset_investasi_model->getdata('data_hasil_investasi', 'row_array', $id);
                    $data['data'] = $data;
                }

                $data['data_jenis'] = $this->aset_investasi_model->getdata('mst_hasil_investasi', 'result');
                $data['bread'] = array('header'=>'Hasil Investasi', 'subheader'=>'Hasil Investasi');
                $data['view']  = "bulanan/hasil_investasi/input_hasil_investasi";
            break;
            case 'danabersih_kewajiban':
                $data['kewajiban'] = $this->aset_investasi_model->getdata('data_kewajiban_header', 'result_array');
                $data['data_jenis'] = $this->aset_investasi_model->getdata('mst_jenis_investasi_kewajiban', 'result');
                $data['bread'] = array('header'=>'Dana Bersih', 'subheader'=>'Dana Bersih');
                $data['view']  = "bulanan/dana_bersih/input_kewajiban";
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
			case "data_pihak":
                $id = $this->input->post('jns_investasi');
                $option = $this->lib->fillcombo("data_pihak", "return", $id);
                echo $option;
            break;
            case "cabang":
                $option = $this->lib->fillcombo("cabang", "return");
                echo $option;
            break;
            case "sub_reksadana":
				$id = $this->input->post('jns_investasi');
				$option = $this->lib->fillcombo("sub_reksadana", "return", $id);
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
            case "data_bulan_lalu_hasilinvest":
				$id_invest = $this->input->post('jns_investasi');
				$data = $this->aset_investasi_model->getdata('data_bulan_lalu_hasilinvest', 'row_array', $id_invest);
				
				echo json_encode($data);
			break;
			case "cek_aset_investasi":
                $id_invest = $this->input->post('jns_investasi');
                $data = $this->aset_investasi_model->getdata('cek_aset_investasi', 'row_array', $id_invest);
                
                echo json_encode($data);
            break;
            case "sum_beban_investasi":
                $data = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'BEBAN INVESTASI');
                
                echo json_encode($data);
            break;
            case "cek_id":
                $data = $this->aset_investasi_model->getdata('aset_investasi_cek_id', 'row_array');
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
		echo $this->aset_investasi_model->simpandata($p1, $post, $editstatus);
	}

    
    public function nilai_dana_bersih(){
        $array = array();
        $dana_bersih_lv1 = $this->aset_investasi_model->getdata('dana_bersih_lv1','result_array');
        foreach ($dana_bersih_lv1 as $k => $v) {

            if($v['jenis_laporan'] == 'ASET'){
                $judul = 'Total Aset';
            }else if($v['jenis_laporan'] == 'KEWAJIBAN'){
                $judul = 'Total Kewajiban';
            }

            $array[$k]['jenis_laporan'] = $v['jenis_laporan'];
            $array[$k]['total'] = $judul;
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
            $array[$k]['child'] = array();

            $dana_bersih_lv2 = $this->aset_investasi_model->getdata('dana_bersih_lv2','result_array', $v['jenis_laporan']);
            foreach ($dana_bersih_lv2 as $key => $val) {
                $array[$k]['child'][$key]['id_dana_bersih'] = $val['id_dana_bersih'];
                $array[$k]['child'][$key]['uraian'] = $val['uraian'];
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir']) ? $val['saldo_akhir'] : 0) ;
                $array[$k]['child'][$key]['subchild'] = array();

                $dana_bersih_lv3 = $this->aset_investasi_model->getdata('dana_bersih_lv3','result_array', $val['id_dana_bersih']);
                foreach ($dana_bersih_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = (isset($y['saldo_akhir']) ? $y['saldo_akhir'] : 0) ;  

                }
            }
        }
        // echo '<pre>';
        // print_r($array);exit;
        // return $array;

        // $data['bread'] = array('header'=>'Arus Kas', 'subheader'=>'Arus Kas');
        // $data['view']  = "bulanan/arus_kas/data_aruskas";
        // $this->load->view('main/utama', $data);
    }

    public function aset_investasi_front(){
        $param_jenis = 'INVESTASI';
        $array = array();
        $invest = $this->aset_investasi_model->getdataindex('aset_investasi_front','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array[$k]['saldo_awal'] = $v['saldo_awal'];
            $array[$k]['saldo_akhir'] = $v['saldo_akhir'];
            $array[$k]['mutasi'] = $v['mutasi'];
            $array[$k]['rka'] = $v['rka'];
            $array[$k]['realisasi_rka'] = $v['realisasi_rka'];
            $array[$k]['type'] = $v['type'];
            $array[$k]['jns_form'] = $v['jns_form'];
            $array[$k]['child'] = array();
            if($v['type'] == "PC"){
                $childinvest = $this->aset_investasi_model->getdataindex('aset_investasi_front_lv2','result_array', $v['id_investasi'], $param_jenis);
                foreach ($childinvest as $key => $val) {
                    $array[$k]['child'][$key]['id'] = $val['id'];
                    $array[$k]['child'][$key]['id_investasi'] = $val['id_investasi'];
                    $array[$k]['child'][$key]['jenis_investasi'] = $val['jenis_investasi'];
                    $array[$k]['child'][$key]['saldo_awal'] = $val['saldo_awal'];
                    $array[$k]['child'][$key]['saldo_akhir'] = $val['saldo_akhir'];
                    $array[$k]['child'][$key]['mutasi'] = $val['mutasi'];
                    $array[$k]['child'][$key]['rka'] = $val['rka'];
                    $array[$k]['child'][$key]['realisasi_rka'] = $val['realisasi_rka'];
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                    $array[$k]['child'][$key]['subchild'] = array();

                    if($val['type'] == "PC"){
                        $childinvestlv3 = $this->aset_investasi_model->getdataindex('aset_investasi_front_lv3','result_array', $val['id_investasi'], $param_jenis);
                        foreach ($childinvestlv3 as $x => $y) {
                            $array[$k]['child'][$key]['subchild'][$x]['id'] = $y['id'];
                            $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['saldo_awal'] = $y['saldo_awal'];
                            $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = $y['saldo_akhir'];
                            $array[$k]['child'][$key]['subchild'][$x]['mutasi'] = $y['mutasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['rka'] = $y['rka'];
                            $array[$k]['child'][$key]['subchild'][$x]['realisasi_rka'] = $y['realisasi_rka'];
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
	
	public function GetBulanLaluHeader($p1){
        $param_jenis = 'INVESTASI';
        $array = array();
        $invest = $this->aset_investasi_model->getdataindex('aset_investasi_front_lalu','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['iduser'] = $this->iduser;
            $array[$k]['id_bulan'] = $p1;
            $array[$k]['id_investasi'] = $v['id_investasi'];
            $array[$k]['saldo_awal_invest'] = $v['saldo_akhir'];
            $array[$k]['saldo_akhir_invest'] = $v['saldo_akhir'];
            $array[$k]['mutasi_invest'] = $v['mutasi'];
            $array[$k]['rka'] = $v['rka'];
            $array[$k]['realisasi_rka'] = $v['realisasi_rka'];
            $array[$k]['insert_at'] = date('Y-m-d H:i:s');


            $this->db->insert('bln_aset_investasi_header', $array[$k]);
        }

        // echo '<pre>';
        // print_r($array);exit;
        // return $array;
    }

    

    public function GetBulanLaluDetail($p1){
        $param_jenis = 'INVESTASI';
        $array = array();
        $invest = $this->aset_investasi_model->getdataindex('aset_investasi_detail_lalu','result_array', $param_jenis);

        foreach ($invest as $k => $v) {
            $array[$k]['id'] = $v['id'];
            $array[$k]['iduser'] = $this->iduser;
            $array[$k]['id_bulan'] = $p1;
            $array[$k]['id_investasi'] = $v['id_investasi'];

        }

        echo '<pre>';
        print_r($array);exit;
        // return $array;
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
            $data['tahun']           = $tahun;
            $data['id']              = escape($this->input->post('id'));
            $data['jenis_lap']       = escape($this->input->post('jns_lap'));
            $data['keterangan_lap']  = escape($this->input->post('keterangan'));
            $data['insert_at']       = date("Y-m-d H:i:s");

            $jns_lap = $data['jenis_lap'];
            $id_bulan = $data['id_bulan'];

            $this->aset_investasi_model->delete_ket($jns_lap,$id_bulan);
            $this->aset_investasi_model->insert_ket($data);

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
        $get_db = $this->aset_investasi_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_bulanan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function get_file_jenis(){
        $id = $this->uri->segment(4);
        $dir = $this->uri->segment(2);
        $get_db = $this->aset_investasi_model->get_by_id_jenis($id);
        // print_r($dir);exit;
        $file = $get_db[0]['filedata'];
        $path = './files/file_bulanan/'.$dir.'/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function get_file_kewajiban(){
        $id = $this->uri->segment(4);
        $get_db = $this->aset_investasi_model->get_by_id_jenis($id);
        // print_r($get_db);exit;
        $file = $get_db[0]['filedata'];
        $path = './files/file_bulanan/kewajiban/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function get_file_beban_investasi(){
        $id = $this->uri->segment(4);
        $get_db = $this->aset_investasi_model->get_by_id_jenis($id);
        // print_r($get_db);exit;
        $file = $get_db[0]['filedata'];
        $path = './files/file_bulanan/beban_investasi/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function get_file_iuran_beban(){
        $id = $this->uri->segment(4);
        $get_db = $this->aset_investasi_model->get_by_id_jenis($id);
        // print_r($get_db);exit;
        $file = $get_db[0]['filedata'];
        $path = './files/file_bulanan/iuran_beban/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 
   
}
