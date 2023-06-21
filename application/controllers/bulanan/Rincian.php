<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Rincian extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->model('bulanan_model/rincian_model');
		
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
	}

	public function index() {
		$iduser = $this->session->userdata('iduser');
		$data['bulan'] = bulan();
		$data['opt_user'] = dtuser();
		$data['rincian_invest'] = $this->rincian_model->getdata('rincian_investasi', 'result_array');
		$data['sum_invest'] = $this->rincian_model->getdata('sum_rincian_investasi', 'row_array');
		$data['persen_sum_invest'] = $this->persen_sum_invest($iduser);

		$data['rincian_bkn_invest'] = $this->rincian_model->getdata('rincian_bkn_investasi', 'result_array');
		$data['sum_bkn_invest'] = $this->rincian_model->getdata('sum_rincian_bkn_investasi', 'row_array');
		$data['persen_sum_bkn_invest'] = $this->persen_sum_bkn_invest($iduser);
        $data['data_rincian_ket'] = $this->rincian_model->get_ket('ket_rincian');


		$data['bread'] = array('header'=>'Rincian ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Rincian');
		if($iduser == 'TSN002'){
			$data['view']  = "bulanan/rincian/index-rincian-investasi-tsn";
		}elseif($iduser == 'ASB003') {
			$data['view']  = "bulanan/rincian/index-rincian-investasi-asb";
		}else{
			$data['view']  = "bulanan/rincian/index-rincian-investasi-tsn";
		}

		// echo "<pre>";
		// print_r($data['rincian_invest']);exit;
		$this->load->view('main/utama', $data);
	}

	function get_index($mod){
        switch($mod){
            case 'index-rincian':
                $data['id_bulan'] = $this->input->post('id_bulan');
                $data['iduser'] = $this->input->post('iduser');

                $data['rincian_invest'] = $this->rincian_model->getdata('rincian_investasi', 'result_array');
                $data['sum_invest'] = $this->rincian_model->getdata('sum_rincian_investasi', 'row_array');
                $data['persen_sum_invest'] = $this->persen_sum_invest($data['iduser']);

                $data['rincian_bkn_invest'] = $this->rincian_model->getdata('rincian_bkn_investasi', 'result_array');
                $data['sum_bkn_invest'] = $this->rincian_model->getdata('sum_rincian_bkn_investasi', 'row_array');
                $data['persen_sum_bkn_invest'] = $this->persen_sum_bkn_invest($data['iduser']);
                $data['data_rincian_ket'] = $this->rincian_model->get_ket('ket_rincian');
                
                $data['bulan'] = bulan();
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Rincian ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Rincian');
                if($data['iduser'] == 'TSN002'){
                	$data['view']  = "bulanan/rincian/index-rincian-investasi-tsn";
                }elseif($data['iduser'] == 'ASB003') {
                	$data['view']  = "bulanan/rincian/index-rincian-investasi-asb";
                }else{
                	$data['view']  = "bulanan/rincian/index-rincian-investasi-tsn";
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

    function cetak($mod=""){
        
        switch($mod){
            case "rincian_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['bulan'] = bulan();
                $data['opt_user'] = dtuser();
                $data['rincian_invest'] = $this->rincian_model->getdata('rincian_investasi', 'result_array');
                $data['sum_invest'] = $this->rincian_model->getdata('sum_rincian_investasi', 'row_array');
                $data['persen_sum_invest'] = $this->persen_sum_invest($data['iduser']);

                $data['rincian_bkn_invest'] = $this->rincian_model->getdata('rincian_bkn_investasi', 'result_array');
                $data['sum_bkn_invest'] = $this->rincian_model->getdata('sum_rincian_bkn_investasi', 'row_array');
                $data['persen_sum_bkn_invest'] = $this->persen_sum_bkn_invest($data['iduser']);
                $data['data_rincian_ket'] = $this->rincian_model->get_ket('ket_rincian');

                if($data['iduser'] == ""){
                    if($this->iduser == "TSN002"){
                        $template=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true); 
                    }else if ($this->iduser == "ASB003") {
                        $template=$this->load->view('bulanan/rincian/index_pdf_export_asb', $data,true);
                    }
                }else{
                    if($data['iduser'] == "TSN002"){
                        $template=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true); 
                    }else if ($data['iduser'] == "ASB003") {
                        $template=$this->load->view('bulanan/rincian/index_pdf_export_asb', $data,true);
                    }
                }
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
                $pdf = new \Mpdf\Mpdf(['orientation' => 'L']);
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

	// export pdf
	public function laporan_Rincian_PDF(){
        $iduser = $this->session->userdata('iduser');
        $data['bulan'] = bulan();
        $data['opt_user'] = dtuser();
        $data['rincian_invest'] = $this->rincian_model->getdata('rincian_investasi', 'result_array');
        $data['sum_invest'] = $this->rincian_model->getdata('sum_rincian_investasi', 'row_array');
        $data['persen_sum_invest'] = $this->persen_sum_invest($iduser);

        $data['rincian_bkn_invest'] = $this->rincian_model->getdata('rincian_bkn_investasi', 'result_array');
        $data['sum_bkn_invest'] = $this->rincian_model->getdata('sum_rincian_bkn_investasi', 'row_array');
        $data['persen_sum_bkn_invest'] = $this->persen_sum_bkn_invest($iduser);
        $data['data_rincian_ket'] = $this->rincian_model->get_ket('ket_rincian');

        if($iduser == 'TSN002'){
            $html=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true);
        }elseif($iduser == 'ASB003') {
            $html=$this->load->view('bulanan/rincian/index_pdf_export_asb', $data,true);
        }else{
            $html=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true);
        }
        // echo '<pre>';
        // print_r($data);exit;
        // For PHP 7.4
        $pdf = new \Mpdf\Mpdf(['orientation' => 'L']);
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

    // export pdf
    public function laporan_Rincian_PDF_taspen(){
        $iduser = $this->session->userdata('iduser');
        $data['bulan'] = bulan();
        $data['opt_user'] = dtuser();
        $data['rincian_invest'] = $this->rincian_model->getdata('rincian_investasi', 'result_array');
        $data['sum_invest'] = $this->rincian_model->getdata('sum_rincian_investasi', 'row_array');
        $data['persen_sum_invest'] = $this->persen_sum_invest($iduser);

        $data['rincian_bkn_invest'] = $this->rincian_model->getdata('rincian_bkn_investasi', 'result_array');
        $data['sum_bkn_invest'] = $this->rincian_model->getdata('sum_rincian_bkn_investasi', 'row_array');
        $data['persen_sum_bkn_invest'] = $this->persen_sum_bkn_invest($iduser);
        $data['data_rincian_ket'] = $this->rincian_model->get_ket('ket_rincian');

        if($iduser == 'TSN002'){
            $html=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true);
        }elseif($iduser == 'ASB003') {
            $html=$this->load->view('bulanan/rincian/index_pdf_export_asb', $data,true);
        }else{
            $html=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true);
        }
        // echo '<pre>';
        // print_r($data);exit;
        // For PHP 7.4
        $pdf = new \Mpdf\Mpdf(['orientation' => 'L']);
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

    // export pdf
    public function laporan_Rincian_PDF_asabri(){
        $iduser = $this->session->userdata('iduser');
        $data['bulan'] = bulan();
        $data['opt_user'] = dtuser();
        $data['rincian_invest'] = $this->rincian_model->getdata('rincian_investasi', 'result_array');
        $data['sum_invest'] = $this->rincian_model->getdata('sum_rincian_investasi', 'row_array');
        $data['persen_sum_invest'] = $this->persen_sum_invest($iduser);

        $data['rincian_bkn_invest'] = $this->rincian_model->getdata('rincian_bkn_investasi', 'result_array');
        $data['sum_bkn_invest'] = $this->rincian_model->getdata('sum_rincian_bkn_investasi', 'row_array');
        $data['persen_sum_bkn_invest'] = $this->persen_sum_bkn_invest($iduser);
        $data['data_rincian_ket'] = $this->rincian_model->get_ket('ket_rincian');

        if($iduser == 'TSN002'){
            $html=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true);
        }elseif($iduser == 'ASB003') {
            $html=$this->load->view('bulanan/rincian/index_pdf_export_asb', $data,true);
        }else{
            $html=$this->load->view('bulanan/rincian/index_pdf_export_tsn', $data,true);
        }
        // echo '<pre>';
        // print_r($data);exit;
        // For PHP 7.4
        $pdf = new \Mpdf\Mpdf(['orientation' => 'L']);
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
            $data['tahun']           = $this->session->userdata('tahun');
            $data['id']              = escape($this->input->post('id'));
            $data['jenis_lap']       = escape($this->input->post('jns_lap'));
            $data['keterangan_lap']  = escape($this->input->post('keterangan'));
            $data['insert_at']       = date("Y-m-d H:i:s");

            $jns_lap = $data['jenis_lap'];
            $id_bulan = $data['id_bulan'];

            $this->rincian_model->delete_ket($jns_lap,$id_bulan);
            $this->rincian_model->insert_ket($data);

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
        $get_db = $this->rincian_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_bulanan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    public function persen_sum_invest($iduser){
    	$sum_invest = $this->rincian_model->getdata('sum_rincian_investasi', 'row_array');
    	$tot_pihak = $sum_invest['total_perpihak'] ;
    	$dt['deposito'] = ($tot_pihak!=0)?($sum_invest['deposito']/$tot_pihak)*100:0;
    	$dt['sertifikat_deposito'] = ($tot_pihak!=0)?($sum_invest['sertifikat_deposito']/$tot_pihak)*100:0;
    	$dt['sun'] = ($tot_pihak!=0)?($sum_invest['sun']/$tot_pihak)*100:0;
    	$dt['sukuk_pemerintah'] = ($tot_pihak!=0)?($sum_invest['sukuk_pemerintah']/$tot_pihak)*100:0;
    	$dt['obligasi_korporasi'] = ($tot_pihak!=0)?($sum_invest['obligasi_korporasi']/$tot_pihak)*100:0;
    	$dt['sukuk_korporasi'] = ($tot_pihak!=0)?($sum_invest['sukuk_korporasi']/$tot_pihak)*100:0;
    	$dt['obligasi_mata_uang'] = ($tot_pihak!=0)?($sum_invest['obligasi_mata_uang']/$tot_pihak)*100:0;
    	$dt['mtn'] = ($tot_pihak!=0)?($sum_invest['mtn']/$tot_pihak)*100:0;
    	$dt['saham'] = ($tot_pihak!=0)?($sum_invest['saham']/$tot_pihak)*100:0;
    	$dt['reksadana'] = ($tot_pihak!=0)?($sum_invest['reksadana']/$tot_pihak)*100:0;
    	$dt['dana_invest_kik'] = ($tot_pihak!=0)?($sum_invest['dana_invest_kik']/$tot_pihak)*100:0;
    	$dt['penyertaan_langsung'] = ($tot_pihak!=0)?($sum_invest['penyertaan_langsung']/$tot_pihak)*100:0;
    	$dt['reksadana_pasar_uang'] = ($tot_pihak!=0)?($sum_invest['reksadana_pasar_uang']/$tot_pihak)*100:0;
    	$dt['reksadana_pendapatan_tetap'] = ($tot_pihak!=0)?($sum_invest['reksadana_pendapatan_tetap']/$tot_pihak)*100:0;
    	$dt['reksadana_campuran'] = ($tot_pihak!=0)?($sum_invest['reksadana_campuran']/$tot_pihak)*100:0;
    	$dt['reksadana_saham'] = ($tot_pihak!=0)?($sum_invest['reksadana_saham']/$tot_pihak)*100:0;
    	$dt['reksadana_terproteksi'] = ($tot_pihak!=0)?($sum_invest['reksadana_terproteksi']/$tot_pihak)*100:0;
    	$dt['reksadana_pinjaman'] = ($tot_pihak!=0)?($sum_invest['reksadana_pinjaman']/$tot_pihak)*100:0;
    	$dt['reksadana_index'] = ($tot_pihak!=0)?($sum_invest['reksadana_index']/$tot_pihak)*100:0;
    	$dt['reksadana_kik'] = ($tot_pihak!=0)?($sum_invest['reksadana_kik']/$tot_pihak)*100:0;
    	$dt['reksadana_penyertaaan_diperdagangkan'] = ($tot_pihak!=0)?($sum_invest['reksadana_penyertaaan_diperdagangkan']/$tot_pihak)*100:0;
    	
    	if ($iduser != 'ASB003') {
    		$dt['tanah_bangunan'] = ($tot_pihak!=0)?($sum_invest['tanah_bangunan']/$tot_pihak)*100:0;
    	}

    	$dt['total_perpihak'] = array_sum($dt);

    	// echo '<pre>';
    	// print_r($dt);exit;
    	return $dt;
    }
    public function persen_sum_bkn_invest($iduser){
    	$sum_bkn_invest = $this->rincian_model->getdata('sum_rincian_bkn_investasi', 'row_array');
    	$tot_pihak = $sum_bkn_invest['total_perpihak'] ;
    	$dt['kas_bank'] = ($tot_pihak!=0)?($sum_bkn_invest['kas_bank']/$tot_pihak)*100:0;

    	$dt['piutang_iuran'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_iuran']/$tot_pihak)*100:0;
    	$dt['piutang_investasi'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_investasi']/$tot_pihak)*100:0;
    	$dt['piutang_hasil_invest'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_hasil_invest']/$tot_pihak)*100:0;
    	$dt['piutang_lainnya'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_lainnya']/$tot_pihak)*100:0;
    	$dt['piutang_biaya_konpensasi_bank'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_biaya_konpensasi_bank']/$tot_pihak)*100:0;
    	$dt['uangmuka_pph'] = ($tot_pihak!=0)?($sum_bkn_invest['uangmuka_pph']/$tot_pihak)*100:0;
    	$dt['piutang_pihak_ketiga'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_pihak_ketiga']/$tot_pihak)*100:0;
    	$dt['piutang_denda'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_denda']/$tot_pihak)*100:0;
    	$dt['cadangan_penyisihan'] = ($tot_pihak!=0)?($sum_bkn_invest['cadangan_penyisihan']/$tot_pihak)*100:0;
    	$dt['bangunan'] = ($tot_pihak!=0)?($sum_bkn_invest['bangunan']/$tot_pihak)*100:0;
    	$dt['tanah_bangunan'] = ($tot_pihak!=0)?($sum_bkn_invest['tanah_bangunan']/$tot_pihak)*100:0;
    	$dt['aset_lainnya'] = ($tot_pihak!=0)?($sum_bkn_invest['aset_lainnya']/$tot_pihak)*100:0;
    	$dt['kendaraan'] = ($tot_pihak!=0)?($sum_bkn_invest['kendaraan']/$tot_pihak)*100:0;
    	$dt['komputer'] = ($tot_pihak!=0)?($sum_bkn_invest['komputer']/$tot_pihak)*100:0;
    	$dt['inventaris_kantor'] = ($tot_pihak!=0)?($sum_bkn_invest['inventaris_kantor']/$tot_pihak)*100:0;

    	$dt['hak_guna_bangunan'] = ($tot_pihak!=0)?($sum_bkn_invest['hak_guna_bangunan']/$tot_pihak)*100:0;
    	$dt['aset_tdk_berwujud'] = ($tot_pihak!=0)?($sum_bkn_invest['aset_tdk_berwujud']/$tot_pihak)*100:0;
    	$dt['aset_tetap'] = ($tot_pihak!=0)?($sum_bkn_invest['aset_tetap']/$tot_pihak)*100:0;
    	$dt['inventaris_kantor'] = ($tot_pihak!=0)?($sum_bkn_invest['inventaris_kantor']/$tot_pihak)*100:0;

    	if ($iduser == 'ASB003') {
    		$dt['piutang_bum_kpr'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_bum_kpr']/$tot_pihak)*100:0;
    		$dt['piutang_pum_kpr'] = ($tot_pihak!=0)?($sum_bkn_invest['piutang_pum_kpr']/$tot_pihak)*100:0;
    	}
    	
    	$dt['total_perpihak'] = array_sum($dt);

    	// echo '<pre>';
    	// print_r($dt);exit;
    	return $dt;
    }
}