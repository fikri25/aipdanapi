<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dana_bersih extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('bulanan_model/posisi_investasi_model');
		$this->load->model('bulanan_model/lap_bukan_investasi_model');
        $this->load->model('bulanan_model/dana_bersih_model');
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
		$this->page_limit = "";
		
	}
	
	
	public function index(){
        $data['bulan'] = bulan();
        $data['opt_user'] = dtuser();
        $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
        $data['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv1','result');
        $data['data_dana_bersih_ket'] = $this->dana_bersih_model->get_ket('ket_dana_bersih');
		
		
		$data['bread'] = array('header'=>'Dana Bersih ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Dana Bersih');
		$data['view']  = "bulanan/dana_bersih/index-bersih";
		$this->load->view('main/utama', $data);
    }

    // export pdf
    public function laporan_DanaBersih_PDF(){
        $data['bulan'] = bulan();
        $data['opt_user'] = dtuser();
        $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
        $data['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv1','result');
        $data['data_dana_bersih_ket'] = $this->dana_bersih_model->get_ket('ket_dana_bersih');
        $html=$this->load->view('bulanan/dana_bersih/index_pdf_export', $data,true);  
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
            case "dana_bersih_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['bulan'] = bulan();
                $data['opt_user'] = dtuser();
                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv1','result');
                $data['data_dana_bersih_ket'] = $this->dana_bersih_model->get_ket('ket_dana_bersih');
                $template=$this->load->view('bulanan/dana_bersih/index_pdf_export', $data,true);  
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
            case 'index-danabersih':
                $data['iduser'] = $this->input->post('iduser');
                $data['id_bulan'] = $this->input->post('id_bulan');

                $data['opt_user'] = dtuser();
                $data['data_dana_bersih'] = $this->nilai_all_dana_bersih();
                $data['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv1','result');

                $filter['iduser'] =  $data['iduser'];
                $filter['id_bulan'] = $data['id_bulan'];
                $data['data_dana_bersih_ket'] = $this->dana_bersih_model->get_ket('ket_dana_bersih');

                $data['bulan'] = bulan();
                $data['bulan_prev'] = bulan_prev();
                $data['bread'] = array('header'=>'Dana Bersih ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Dana Bersih');
                $data['view']  = "bulanan/dana_bersih/index-bersih";

                // print_r($filter);exit;
            break;
        }

        $data['mod'] = $mod;
        $data['acak'] = md5(date('H:i:s'));
        // echo '<pre>';
        // print_r($data);exit;
        $dt = $this->load->view($data['view'], $data, TRUE);
        echo $dt;
    }

    public function nilai_all_dana_bersih(){
        $array = array();
        $dana_bersih_lv1 = $this->aset_investasi_model->getdata('dana_bersih_lv1','result_array');
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
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_bln_lalu']) ? $v['saldo_akhir_bln_lalu'] : 0) ;
            $array[$k]['child'] = array();

            $dana_bersih_lv2 = $this->aset_investasi_model->getdata('dana_bersih_lv2','result_array', $v['jenis_laporan']);
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
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir']) ? $val['saldo_akhir'] : 0) ;
                $array[$k]['child'][$key]['sum_prev_lvl2'] =  (isset($val['saldo_akhir_bln_lalu']) ? $val['saldo_akhir_bln_lalu'] : 0) ;
                $array[$k]['child'][$key]['subchild'] = array();

                $dana_bersih_lv3 = $this->aset_investasi_model->getdata('dana_bersih_lv3','result_array', $val['id_dana_bersih']);
                foreach ($dana_bersih_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type_sub_jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = (isset($y['saldo_akhir']) ? $y['saldo_akhir'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_bln_lalu'] = (isset($y['saldo_akhir_bln_lalu']) ? $y['saldo_akhir_bln_lalu'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type_sub_jenis_investasi'] == 'PC'){
                        $type = 'C';
                        $dana_bersih_lv4 = $this->aset_investasi_model->getdata('dana_bersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($dana_bersih_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type_sub_jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['id_investasi'] = $zz['id_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['jenis_investasi'] = $zz['jenis_investasi'];
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir'] = (isset($zz['saldo_akhir']) ? $zz['saldo_akhir'] : 0) ;
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['saldo_akhir_bln_lalu'] = (isset($zz['saldo_akhir_bln_lalu']) ? $zz['saldo_akhir_bln_lalu'] : 0) ;
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
            $data['id']              = escape($this->input->post('id'));
            $data['jenis_lap']       = escape($this->input->post('jns_lap'));
            $data['keterangan_lap']  = escape($this->input->post('keterangan'));
            $data['insert_at']       = date("Y-m-d H:i:s");

            $jns_lap = $data['jenis_lap'];
            $id_bulan = $data['id_bulan'];

            $this->dana_bersih_model->delete_ket($jns_lap,$id_bulan);
            $this->dana_bersih_model->insert_ket($data);

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
        $get_db = $this->dana_bersih_model->get_by_id_ket($id);
        $file = $get_db[0]['file_lap'];
        $path = './files/file_bulanan/keterangan/'.$file;
        $data = file_get_contents($path);
        $name = $file;
        force_download($name,$data);
    } 

   
}
