<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operasional_belanja extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->model('bulanan_model/perubahan_dana_bersih_model');
        $this->load->model('bulanan_model/aset_investasi_model');
        $this->load->model('semesteran_model/operasional_belanja_model');
        $this->load->model('semesteran_model/aspek_operasional_model');
        $this->load->model('tahunan_model/operasional_belanja_th_model');
        $this->load->model('tahunan_model/aspek_operasional_th_model');
		
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
        
        $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
        $data['view']  = "tahunan/operasional_belanja/index-danabersih";
        $this->load->view('main/utama', $data);
    }


    public function Klaim(){
        $data['opt_user'] = dtuser();
        $data['klaim_header'] = $this->operasional_belanja_th_model->getdata('lkob_klaim_header','result_array');
        $data['klaim_detail'] = $this->data_klaim_detail();

        $data['data_klaim_ket_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lkob_klaim');
        // print_r($data);exit;
        $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
        $data['view']  = "tahunan/operasional_belanja/index-klaim-header";
        $this->load->view('main/utama', $data);
    }

    public function pembayaran_pensiun(){

        $data['opt_user'] = dtuser();
        $data['data_kelompok'] = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_kelompok', 'result_array','1');
        $data['data_jenis'] = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_jenis', 'result_array','1');

        $data['data_pembayaran_pensiun_ket_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lkob_pembayaran_pensiun');
        $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
        $data['view']  = "tahunan/operasional_belanja/index-pembayaran-kelompok";
        $this->load->view('main/utama', $data);
    }

    public function pembayaran_pensiun_cabang(){

        $data['opt_user'] = dtuser();
        $data['data_cabang_bayar'] = $this->jumlah_pembayaran_cabang();
        $data['data_cabang_terima'] = $this->jumlah_penerima_cabang();
        $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');

        $data['data_pembayaran_pensiun_cbg_ket_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lkob_pembayaran_pensiun_cbg');

        if($this->iduser == "TSN002" || $this->iduser == "DJA001"){
            $data['view']  = "tahunan/operasional_belanja/index-pembayaran-cabang-tsn";
        }else{
            $data['view']  = "tahunan/operasional_belanja/index-pembayaran-cabang-asb";
        }
        // echo '<pre>';
        // print_r($data);exit;
        $this->load->view('main/utama', $data);
    }

    public function lampiran(){
        $data['opt_user'] = dtuser();

        $data['lampiran_lkob_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lamporan_pendukung_lkob');
        // print_r($data);exit;
        $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
        $data['view']  = "tahunan/operasional_belanja/index-lampiran-pendukung";
        $this->load->view('main/utama', $data);
    }

    function get_index($mod){
        switch($mod){
            case 'index-pembayaran-pensiun':
                $data['iduser'] = $this->input->post('iduser');

                $data['data_kelompok'] = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_kelompok', 'result_array','1');
                $data['data_jenis'] = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_jenis', 'result_array','1');
                $data['data_pembayaran_pensiun_ket_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lkob_pembayaran_pensiun');

                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
                $data['view']  = "tahunan/operasional_belanja/index-pembayaran-kelompok";
            break;
            case 'index-pembayaran-pensiun-cabang':
                $data['iduser'] = $this->input->post('iduser');

                $data['data_cabang_bayar'] = $this->jumlah_pembayaran_cabang();
                $data['data_cabang_terima'] = $this->jumlah_penerima_cabang();
                
                $data['data_pembayaran_pensiun_cbg_ket_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lkob_pembayaran_pensiun_cbg');

                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');

                if($data['iduser'] == "TSN002"){
                    $data['view']  = "tahunan/operasional_belanja/index-pembayaran-cabang-tsn";
                }else if ($data['iduser'] == "ASB003") {
                    $data['view']  = "tahunan/operasional_belanja/index-pembayaran-cabang-asb";
                }else{
                    $data['view']  = "tahunan/operasional_belanja/index-pembayaran-cabang-tsn";
                }

                // print_r($data);exit;
            break;
            case 'index-klaim':
                $data['iduser'] = $this->input->post('iduser');
                $data['klaim_header'] = $this->operasional_belanja_th_model->getdata('lkob_klaim_header','result_array');
                $data['klaim_detail'] = $this->data_klaim_detail();

                $data['data_klaim_ket_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lkob_klaim');
        
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
                $data['view']  = "tahunan/operasional_belanja/index-klaim-header";
            break;
            case 'index-lampiran':
                $data['iduser'] = $this->input->post('iduser');

                $data['lampiran_lkob_thn'] = $this->operasional_belanja_th_model->get_ket('ket_lamporan_pendukung_lkob');
                
                $data['opt_user'] = dtuser();
                $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
                $data['view']  = "tahunan/operasional_belanja/index-lampiran-pendukung";
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

            case 'lkob_klaim':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $smt = $this->input->post('semester');
                    $data = $this->operasional_belanja_model->getdata('tbl_lkob_klaim_header', 'row_array', $id, $smt);
                    $data_detail = $this->operasional_belanja_model->getdata('tbl_lkob_klaim_detail', 'result_array', $data['id'], $smt);
                   
                    $data['data'] = $data;
                    $data['data_detail'] = $data_detail;
                    
                    // echo '<pre>';
                    // print_r($data);exit;

                }

                $data['opt_smt'] = semester();
                $data['cabang'] = $this->operasional_belanja_model->get_combo('mst_cabang');
                $data['jenis_klaim'] = $this->operasional_belanja_model->get_combo('jenis_klaim');
                $data['bread'] = array('header'=>'Operasional Belanja', 'subheader'=>'Operasional Belanja');
                $data['view']  = "tahunan/operasional_belanja/input-klaim";
             
            break;

            case 'pembayaran_pensiun_apbn':
                if($sts=='edit'){
                    $id = $this->input->post('id');
                    $smt = $this->input->post('semester');

                    $data = $this->aspek_operasional_model->getdata('pembayaran_aip_header', 'row_array', $id, $smt, '1');
                    $data_detail = $this->aspek_operasional_model->getdata('pembayaran_aip_detail', 'result_array', $id, $smt, '1');
                   
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
                $data['view']  = "tahunan/operasional_belanja/input-pembayaran-aip";
             
            break;
            case 'pembayaran_pensiun_apbn_cabang':
                if($sts=='edit'){

                    $id = $this->input->post('id');
                    $smt = $this->input->post('semester');

                    $data = $this->aspek_operasional_model->getdata('pembayaran_aip_cbg_header', 'row_array', $id, $smt, '1');
                    $array = array();
                    $data_detail = $this->aspek_operasional_model->getdata('pembayaran_aip_cbg_detail', 'result_array', $id, $smt, '1');
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

                        $data_detail_cbg = $this->aspek_operasional_model->getdata('pembayaran_aip_cbg_detail_cabang', 'result_array', $id, $smt, $v['id_cabang'], '1');
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
                $data['view']  = "tahunan/operasional_belanja/input-pembayaran-aip-cabang";

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
            case "mst_cabang_ob":
                $option = $this->lib->fillcombo("mst_cabang_ob", "return");
                echo $option;
            break;
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
                $data = $this->operasional_belanja_model->getdata('form_invest', 'result_array', $id);
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
                $data = $this->operasional_belanja_model->getdata('data_bulan_lalu_form', 'result_array', $id_invest, $jns_form);
                
                echo json_encode($data);
            break;
            case "cek_aset_investasi":
                $id_invest = $this->input->post('jns_investasi');
                $data = $this->operasional_belanja_model->getdata('cek_aset_investasi', 'row_array', $id_invest);
                
                echo json_encode($data);
            break;
        }
    }


    function cetak($mod=""){
        
        switch($mod){
            case 'pembayaran_pensiun_apbn_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['data_kelompok'] = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_kelompok', 'result_array','1');
                $data['data_jenis'] = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_jenis', 'result_array','1');
                $template  = $this->load->view('tahunan/operasional_belanja/cetak/index-pembayaran-aip-cetak', $data,true);  
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'pembayaran_pensiun_apbn_cabang_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['data_cabang_bayar'] = $this->jumlah_pembayaran_cabang();
                $data['data_cabang_terima'] = $this->jumlah_penerima_cabang();

                if($data['iduser'] == ""){
                    if($this->iduser == "TSN002"){
                        $template  = $this->load->view('tahunan/operasional_belanja/cetak/index-pembayaran-cabang-tsn-cetak', $data,true);  
                    }else if ($this->iduser == "ASB003") {
                        $template  = $this->load->view('tahunan/operasional_belanja/cetak/index-pembayaran-cabang-asb-cetak', $data,true); 
                    }
                }else{
                    if($data['iduser'] == "TSN002"){
                        $template  = $this->load->view('tahunan/operasional_belanja/cetak/index-pembayaran-cabang-tsn-cetak', $data,true);  
                    }else if ($data['iduser'] == "ASB003") {
                        $template  = $this->load->view('tahunan/operasional_belanja/cetak/index-pembayaran-cabang-asb-cetak', $data,true); 
                    }
                }
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case 'klaim_cetak':
                $data['iduser'] = $this->input->post('iduser');
                $data['klaim_header'] = $this->operasional_belanja_th_model->getdata('lkob_klaim_header','result_array');
                $data['klaim_detail'] = $this->data_klaim_detail();
                $template  = $this->load->view('tahunan/operasional_belanja/cetak/index-klaim-cetak', $data,true);  

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

        $data['iduser']          = $this->session->userdata('iduser');
        $data['id']              = escape($this->input->post('id'));
        $data['jenis_lap']       = escape($this->input->post('jns_lap'));
        $data['keterangan_lap']  = escape($this->input->post('keterangan'));
        $data['insert_at']       = date("Y-m-d H:i:s");

        $jns_lap = $data['jenis_lap'];
        $iduser = $data['iduser'];

        $this->operasional_belanja_th_model->delete_ket($jns_lap,$iduser);
        $this->operasional_belanja_th_model->insert_ket($data);

        $this->session->set_flashdata('form_true',
            '<div class="alert alert-success">
            <h4>Berhasil.</h4>
            <p>Data keterangan berhasil Disimpan.</p>
            </div>');
        redirect ($this->agent->referrer());
    }


    public function get_file(){
        $id = $this->uri->segment(4);
        $get_db = $this->operasional_belanja_th_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_tahunan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

    

    public function jumlah_pembayaran_cabang(){
        $array = array();    
        $mst_cabang = $this->aspek_operasional_th_model->get_combo('data_cabang', 'result_array', '1');
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

            $data_cabang = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_cabang', 'result_array', $v['id'], '1');
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
        $mst_cabang = $this->aspek_operasional_th_model->get_combo('data_cabang', 'result_array', '1');
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

            $data_cabang = $this->aspek_operasional_th_model->getdata('pembayaran_pensiun_cabang', 'result_array', $v['id'], '1');
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


    public function data_klaim_detail($value=''){        
        $array = array();
        $klaim_detail = $this->operasional_belanja_th_model->getdata('lkob_klaim_detail', 'result_array');
        foreach ($klaim_detail as $k => $v) {

            $array[$k]['nama_cabang'] = $v['nama_cabang'] ;
            $array[$k]['jenis_klaim'] = $v['jenis_klaim'] ;
            $array[$k]['jml_klaim_thn'] = $v['jml_klaim_thn'] ;
            $array[$k]['jml_pembayaran_thn'] = $v['jml_pembayaran_thn'] ;
            $array[$k]['jml_klaim_thn_lalu'] = $v['jml_klaim_thn_lalu'] ;
            $array[$k]['jml_pembayaran_thn_lalu'] = $v['jml_pembayaran_thn_lalu'] ;

            $jml_klaim_min = $v['jml_klaim_thn_lalu'] - $v['jml_klaim_thn'];
            $jml_pembayaran_min = $v['jml_pembayaran_thn_lalu'] - $v['jml_pembayaran_thn'];

            $array[$k]['pers_kenaikan_penerima'] = ($v['jml_klaim_thn']!=0)?($jml_klaim_min/$v['jml_klaim_thn'])*100:0;
            $array[$k]['pers_kenaikan_pembayaran'] = ($v['jml_klaim_thn']!=0)?($jml_pembayaran_min/$v['jml_pembayaran_thn'])*100:0;
        }

        // echo '<pre>';
        // print_r($array);exit;
        return $array;
    }
    

}

