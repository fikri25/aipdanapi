<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_investasi extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('bulanan_model/hasil_investasi_model');
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
		$this->page_limit = 50;
		
	}
	
	
	public function index(){
        // $data['data_hasil_investasi'] = $this->aset_investasi_model->getdata('data_hasil_investasi_header', 'result');
        $data['data_hasil_investasi'] = $this->hasil_investasi_front();
        $data['yoi'] = $this->nilai_yoi();
        $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'HASIL INVESTASI');
        //keterangan
        $data['data_hasil_investasi_ket'] = $this->hasil_investasi_model->get_ket('ket_hasil_investasi');
        $data['bulan'] = bulan();
        $data['status'] = pendahuluan_bln();
        $data['opt_user'] = dtuser();

        // print_r($data['yoi']);exit;
		
		$data['bread'] = array('header'=>'Hasil Investasi ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Hasil Investasi');
		$data['view']  = "bulanan/hasil_investasi/index_hasil_investasi";
		$this->load->view('main/utama', $data);
    }

    // export pdf
    public function laporan_HasilInvestasi_PDF(){
        $data['data_hasil_investasi'] = $this->aset_investasi_model->getdata('data_hasil_investasi_header', 'result');
        $data['data_hasil_investasi_ket'] = $this->hasil_investasi_model->get_ket('ket_hasil_investasi');
        $data['bulan'] = bulan();
        $html=$this->load->view('bulanan/hasil_investasi/index_pdf_export', $data,true);  
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
            case "hasil_investasi_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['bulan'] = bulan();
                // $data['data_hasil_investasi'] = $this->aset_investasi_model->getdata('data_hasil_investasi_header', 'result');
                $data['data_hasil_investasi'] = $this->hasil_investasi_front();
                $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'HASIL INVESTASI');
                
                $data['data_hasil_investasi_ket'] = $this->hasil_investasi_model->get_ket('ket_hasil_investasi');
                $template=$this->load->view('bulanan/hasil_investasi/index_pdf_export', $data,true);  
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
            case 'index-hasil-investasi':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');

                // $data['data_hasil_investasi'] = $this->aset_investasi_model->getdata('data_hasil_investasi_header', 'result');
                $data['data_hasil_investasi'] = $this->hasil_investasi_front();
                $data['sum'] = $this->aset_investasi_model->getdataindex('aset_investasi_front_sum', 'row_array', 'HASIL INVESTASI');
                $filter['iduser'] =  $data['iduser'];
                $filter['id_bulan'] = $data['id_bulan'];
                $data['data_hasil_investasi_ket'] = $this->hasil_investasi_model->get_ket('ket_hasil_investasi');

                $data['opt_user'] = dtuser();
                $data['paggination']="";
                $data['bulan'] = bulan();
                $data['bread'] = array('header'=>'Hasil Investasi ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Hasil Investasi');
                $data['view']  = "bulanan/hasil_investasi/index_hasil_investasi";
              
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

            $this->hasil_investasi_model->delete_ket($jns_lap,$id_bulan);
            $this->hasil_investasi_model->insert_ket($data);

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
        $get_db = $this->hasil_investasi_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_bulanan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 


    public function hasil_investasi_front(){
        $param_jenis = 'HASIL INVESTASI';
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
            $array[$k]['target_yoi'] = $v['target_yoi'];
            $array[$k]['type'] = $v['type'];
            $array[$k]['jns_form'] = $v['jns_form'];
            $array[$k]['filedata'] = $v['filedata'];
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
                    $array[$k]['child'][$key]['target_yoi'] = $val['target_yoi'];
                    $array[$k]['child'][$key]['type'] = $val['type'];
                    $array[$k]['child'][$key]['jns_form'] = $val['jns_form'];
                    $array[$k]['child'][$key]['filedata'] = $val['filedata'];
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
                            $array[$k]['child'][$key]['subchild'][$x]['target_yoi'] = $y['target_yoi'];
                            $array[$k]['child'][$key]['subchild'][$x]['jns_form'] = $y['jns_form'];
                            $array[$k]['child'][$key]['subchild'][$x]['filedata'] = $y['filedata'];
                        }
                    }
                }
            }
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }
    
    public function nilai_yoi($param=""){
        if ($param != "") {
            $iduser = $param;
        }else{ 
            $iduser = $this->session->userdata('iduser');
        }

        $hasil_investasi = $this->aset_investasi_model->getdata('yoi_hasil_investasi','row_array');
        $array1a = array();
        $array1b = array();

        
        $investasi = $this->aset_investasi_model->getdata('yoi_investasi','result_array');
        foreach ($investasi as $ky => $vy) {
            $array1a[$ky] = $vy['saldo_akhir'];
            $array1b[$ky] = $vy['rka'];
        }

        
        
        if($iduser == 'DJA001'){
            if($param != ""){
                $saldo_akhir = geometric_average($array1a);

            }else{
                $saldo_akhir = 0;
            }
        }else{
            $saldo_akhir = geometric_average($array1a);

        }

        // echo "<pre>";
        // print_r($hasil_investasi);exit();
        // print_r(geometric_average($array2a));exit;

        $yoi= ($saldo_akhir!=0)?($hasil_investasi['saldo_akhir']/$saldo_akhir)*100:0;
        $data['yoi'] = $yoi;
        

        return $data;
    }

	
}
