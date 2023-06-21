<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendahuluan extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('bulanan_model/pendahuluan_model');
		
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		// $this->load->library('pdf');
		$this->load->library('upload');
		$this->load->helper('download');

		$this->bulan=$this->session->userdata("id_bulan");
		$this->iduser=$this->session->userdata("iduser");
		$this->tahun=$this->session->userdata("tahun");		
		$this->idusergroup=$this->session->userdata("idusergroup");
		//cek login
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		$userData=$this->session->userdata();
		//cek akses route
		// if($userData['idusergroup'] !== '001') show_404();
		$this->page_limit = 10;
		
	}
	
	public function index($id = ''){


		if(!($this->session->userdata("id_bulan"))){
			$data= array('id_bulan'=>$this->input->post('bulan'));
			$this->session->set_userdata($data);
		} else{
			$this->session->userdata('id_bulan');
		}

		$bln=$this->session->userdata('id_bulan');
		// var_dump($bln);exit;

		$data['data_pendahuluan'] = $this->pendahuluan_model->get_ket($bln);
		$data['bulan'] = bulan();
		$data['status'] = pendahuluan_bln();
		$data['opt_user'] = dtuser();
		
		$data['bread'] = array('header'=>'Pendahuluan ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Pendahuluan');
		$data['view']  = "bulanan/pendahuluan/input_pendahuluan";
		$this->load->view('main/utama', $data);
	}

	function get_index($mod){
		switch($mod){
			case 'index-pendahuluan':
            $data['iduser'] =  $this->input->post('iduser');
            $data['id_bulan'] = $this->input->post('id_bulan');


            $filter['iduser'] =  $data['iduser'];
            $filter['id_bulan'] = $data['id_bulan'];
            $filter['tahun'] = $this->tahun;
            $data['data_pendahuluan'] = $this->pendahuluan_model->get_filter($filter);

            $data['opt_user'] = dtuser();
            $data['bulan'] = bulan();
            $data['bread'] = array('header'=>'Pendahuluan ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Pendahuluan');
            $data['view']  = "bulanan/pendahuluan/input_pendahuluan";

                // print_r($data['data_invest']);exit;
            break;
            case 'index-pernyataan':
			$data['iduser'] =  $this->input->post('iduser');
			$data['id_bulan'] = $this->input->post('id_bulan');


			$filter['iduser'] =  $data['iduser'];
            $filter['id_bulan'] = $data['id_bulan'];
			$filter['tahun'] = $this->tahun;
			$data['data_pendahuluan'] = $this->pendahuluan_model->get_filter($filter);

			$data['opt_user'] = dtuser();
			$data['bulan'] = bulan();
			$data['bread'] = array('header'=>'Surat Pernyataan ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Surat Pernyataan');
            $data['view']  = "bulanan/pendahuluan/input_pernyataan";
			break;
		}

		$data['mod'] = $mod;
		$data['acak'] = md5(date('H:i:s'));
        // echo '<pre>';
        // print_r($data);exit;
		$dt = $this->load->view($data['view'], $data, TRUE);
		echo $dt;
	}


	public function pernyataan_direksi($id = ''){

		$filter['id_bulan'] = $this->bulan;
        $filter['iduser'] = $this->iduser;
        $filter['tahun'] = $this->tahun;
        $data['data_pendahuluan'] = $this->pendahuluan_model->get_filter($filter,url_param());
        $data['bulan'] = bulan();
        $data['opt_user'] = dtuser();
        if ($this->iduser != 'DJA001'){
            $data['iduser'] = $this->iduser;
        }else{
            $data['iduser'] = '';
        }
		
		$data['bread'] = array('header'=>'Surat Pernyataan ('.(isset($data['bulan'][0]->nama_bulan) ? $data['bulan'][0]->nama_bulan : '').' - '. $this->tahun.')', 'subheader'=>'Surat Pernyataan');
		$data['view']  = "bulanan/pendahuluan/input_pernyataan";
		$this->load->view('main/utama', $data);
	}

  	// export pdf
	
    function cetak($mod=""){

    	switch($mod){
    		case "pendahuluan_cetak":
                $data['iduser'] = $this->input->post('iduser');
                $data['id_bulan'] = $this->bulan;
                $data['tahun'] = $this->tahun;
                $data['data_pendahuluan'] = $this->pendahuluan_model->get_ket($data['id_bulan'] );
                $data['opt_user'] = dtuser();
                $data['bulan'] = bulan();
                $template=$this->load->view('bulanan/pendahuluan/index_pdf_export', $data,true);  
                // print_r($data);exit;
                $this->hasil_output('pdf',$mod,'', $data, '', "A4", $template, "ya", "no");
            break;
            case "cetak_bukti":
        		$data['iduser'] = $this->input->post('iduser');
                $data['id_bulan'] = $this->bulan;
                $data['tahun'] = $this->tahun;
        		$data['data_pendahuluan'] = $this->pendahuluan_model->get_ket($data['id_bulan'] );
        		$data['opt_user'] = dtuser();
        		$data['bulan'] = bulan();
        		$template=$this->load->view('bulanan/pendahuluan/cetak_bukti_pdf', $data,true);  
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
       //          $pdf->use_kwt=true; //pagebreak
       //          $pdf->SetTitle($title);
       //          $pdf->WriteHTML($template,2);

       //          $pdf->Output();
            break;
        }
    }	


	public function save(){
		$id_bulan = $this->session->userdata('id_bulan');
        $tahun = $this->session->userdata('tahun');
        $level = $this->session->userdata('level');

        $path = $_FILES['filedata']['name']; // file means your input type file name
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext=="pdf" OR $ext=="doc" OR $ext=="docx" OR $ext=="") {
            $upload_path   = './files/file_bulanan/pendahuluan/'; //path folder
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

            $data["file"] = $filename_data;
            unset($data["filedata_lama"]);
            unset($data["upload_path_lama"]);
            unset($data["nmdoc"]);

            $data['id']                     = $this->input->post('id');
            $data['id_bulan']               = $this->bulan;
            $data['iduser']                 = $this->session->userdata('iduser');
            $data['tahun']                  = $this->session->userdata('tahun');
            $data['tujuan_laporan']         = $this->input->post('tujuan_laporan');
            $data['latar_belakang']         = $this->input->post('latar_belakang');
            $data['periode']                = $this->input->post('periode');
            $data['kejadian_penting']       = $this->input->post('kejadian_penting');
            $data['keterangan']             = $this->input->post('keterangan');
            $data['direksi']                = $this->input->post('direksi');
            $data['insert_at']              = date("Y-m-d H:i:s");


            $this->pendahuluan_model->delete_ket($id_bulan);
            $this->pendahuluan_model->insert_ket($data);

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


    public function update_status(){

    	$bulan 							= $this->bulan;
        $iduser                         = $this->session->userdata('iduser');
    	$tahun 						    = $this->session->userdata('tahun');
    	$data['status'] 				= escape($this->input->post('status'));
    	$data['nama_penandatangan'] 	= escape($this->input->post('nama_penandatangan'));
    	$data['jabatan'] 				= escape($this->input->post('jabatan'));
        $data['status_tgl']             = date("Y-m-d H:i:s");
        $id_ref                         = $iduser.'_'.date("Y-m-d H:i:s");
    	$data['id_ref'] 			    = str_replace('=','',base64_encode($id_ref));
		  // var_dump($data);exit;

        $filter['iduser'] =  $iduser;
        $filter['id_bulan'] = $bulan;
        $filter['tahun'] = $tahun;
        $data_pendahuluan = $this->pendahuluan_model->get_filter($filter);
        $jml =  count($data_pendahuluan);
       // print_r($jml);exit();

        if ( $jml > 0 || $jml == 1) {
          $this->pendahuluan_model->update($bulan,$iduser,$data);

          $this->session->set_flashdata('form_true',
            '<div class="alert alert-success">
            <h4>Berhasil.</h4>
            <p>Data berhasil Disimpan.</p>
            </div>');

          redirect ($this->agent->referrer());

        }else{
            $this->session->set_flashdata('form_true',
                '<div class="alert alert-danger">
                <h4>Gagal.</h4>
                <p>Anda Belum Input Pendahuluan.</p>
                </div>');

            redirect ($this->agent->referrer());
        }
    	
    }

    public function get_file(){
    	$id = $this->uri->segment(4);
    	$get_db = $this->pendahuluan_model->get_by_id($id);
    	$file = $get_db[0]['file'];
    	$path = './files/file_bulanan/pendahuluan/'.$file;
    	$data = file_get_contents($path);
    	$name = $file;
    	force_download($name,$data);
    }

    public function delete($id){
    	$check_id = $this->pendahuluan_model->get_by_id($id);
    	if($check_id){
    		$this->pendahuluan_model->delete($id);
    		$this->session->set_flashdata('form_true',
    			'<div class="alert alert-danger">
    			<h4>Berhasil.</h4>
    			<p>Data berhasil Dihapus.</p>
    			</div>');
    	}
    	redirect ($this->agent->referrer());
    }

}
