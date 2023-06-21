<?php 
if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Analisis extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

        $this->load->model('analisis_model/analisis_model');
        $this->load->model('bulanan_model/aset_investasi_model');

		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		$userData=$this->session->userdata();
		$level=$this->session->userdata("level");
        //cek akses route
        if($level != 'DJA') show_error('Error 403 Access Denied', 403);
		
	}

	public function index(){	
		$data['opt_dashboard'] = combo_dashboard();
        $data['opt_bln'] = combo_bulan();
		$data['opt_user'] = dtuser();
		$data['bln'] = date('m');
        $data['summary_periodik'] = $this->analisis_periodik();
		$data['bread'] = array('header'=>'Dashboard', 'subheader'=>'Dashboard-Analisis');
		$data['view']  = "dashboard/dashboard_executive_summary";
		$this->load->view('main/utama', $data);
	}

    public function aspek_belanja(){
        $dt['opt_user'] = dtuser();
        $dt['klaim'] =  $this->analisis_model->getdataSemester('klaim_detail', 'result_array');
        $dt['data_kelompok'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_kelompok', 'result_array','1');
        $dt['data_jenis'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_jenis', 'result_array','1');
        $dt['bread'] = array('header'=>'Dashboard - Aspek Belanja Pensiun APBN', 'subheader'=>'Dashboard');
        $dt['view']  = "dashboard/dashboard_aspek_belanja";
        $this->load->view('main/utama', $dt);
    }

    public function aspek_operasional(){
        $dt['opt_user'] = dtuser();
        $dt['nilai_tunai'] =  $this->analisis_model->getdataSemester('nilai_tunai_detail', 'result_array');
        $dt['data_kelompok'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_kelompok', 'result_array','2');
        $dt['data_jenis'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_jenis', 'result_array','2');
        $dt['bread'] = array('header'=>'Dashboard - Aspek Operasional', 'subheader'=>'Dashboard');
        $dt['view']  = "dashboard/dashboard_aspek_operasional";
        $this->load->view('main/utama', $dt);
    }

    public function perubahandanabersih(){
        $dt['opt_dashboard'] = combo_dashboard();
        $dt['opt_bln'] = combo_bulan();
        $dt['opt_user'] = dtuser();
        $dt['opt_perubahandanabersih'] = combo_perubahandanabersih();
        $dt['bln'] = date('m');

        // $dt['data_perubahan_danabersih'] = $this->nilai_perubahan_danabersih();
        // $dt['tot_perubahan'] = $this->aset_investasi_model->getdata('perubahan_danabersih_lv1','result');
        // $dt['total_bersih'] = $this->aset_investasi_model->getdata('dana_bersih_lv0','result');

        
        $flag =  'PENAMBAHAN';
        $dt_perubahandanabersih = $this->analisis_model->getdata('perubahandanabersih_detail', 'result_array', $flag);
        $data1 = $names = [];
        foreach($dt_perubahandanabersih as $item) {
            $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
            $data1[$item['jenis_investasi']][$bln_indo] = $item['saldo_akhir'];
            $data1[$item['jenis_investasi']]['uraian'] = $item['jenis_investasi'];
            $names[] = $bln_indo;
            $bln_thn[] = $bln_indo.' - '.$item['tahun'];

        }
                    // filter data
        $dt['first'] = konversi_bln($bln_awal, 'fullbulan');
        $dt['last'] = konversi_bln($bln_akhir, 'fullbulan');

        $dt['data'] =  $data1;
        $dt['flag'] =  $flag;
        $dt['names'] = array_unique($names);
        $dt['bln_thn'] = array_unique($bln_thn);
        $dt['count'] = count($dt['bln_thn']);


        $dt['bread'] = array('header'=>'Dashboard - Perubahan Dana Bersih', 'subheader'=>'Dashboard');
        $dt['view']  = "dashboard/dashboard_perubahandanabersih";
        $this->load->view('main/utama', $dt);
        // echo "<pre>";
        // print_r($dt);exit();
    }

    public function danabersih(){
        $dt['opt_dashboard'] = combo_dashboard();
        $dt['opt_bln'] = combo_bulan();
        $dt['opt_user'] = dtuser();
        $dt['opt_dbersih'] = combo_danabersih();
        $dt['opt_invest'] =  $this->analisis_model->get_combo('mst_investasi');
        $dt['bln'] = date('m');

        $sum_dbersih = $this->dbersih();
        $data = $names = [];
        foreach($sum_dbersih as $item) {
            $data[$item['judul_head']][$item['bulan']] = $item['saldo_akhir'];
            $data[$item['judul_head']]['uraian'] = $item['uraian'];
            $names[] = $item['bulan'];
            $bln_thn[] = $item['bulan'].' - '.$item['tahun'];

        }
        // filter data
        $dt['first'] = konversi_bln('1', 'fullbulan');
        $dt['last'] = konversi_bln('12', 'fullbulan');

        $dt['data'] =  $data;
        $dt['names'] = array_unique($names);
        $dt['bln_thn'] = array_unique($bln_thn);
        $dt['count'] = count($dt['bln_thn']);
        $dt['bread'] = array('header'=>'Dashboard - Dana Bersih', 'subheader'=>'Dashboard');
        $dt['view']  = "dashboard/dashboard_danabersih";
        $this->load->view('main/utama', $dt);


        // echo "<pre>";
        // print_r($data);exit();
    }

    public function aruskas(){
        $dt['opt_dashboard'] = combo_dashboard();
        $dt['opt_bln'] = combo_bulan();
        $dt['opt_user'] = dtuser();
        $dt['opt_aruskas'] = aruskas();
        $dt['bln'] = date('m');

        $sum_aruskas = $this->analisis_model->getdata('arus_kas_detail', 'result_array');
        $data = $names = [];
        foreach($sum_aruskas as $item) {
            $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
            
            if ($item['jenis_kas'] == 'INVESTASI') {
                $tag =  'Arus Kas Dari Aktivitas Investasi';
            }elseif ($item['jenis_kas'] == 'OPERASIONAL'){
                $tag =  'Arus Kas Dari Aktivitas Operasional'; 
            }elseif ($item['jenis_kas'] == 'PENDANAAN'){
                $tag =  'Arus Kas Dari Aktivitas Pendanaan'; 
            }else{
                $tag = $item['jenis_kas'];
            }
            $data[$item['jenis_kas']][$bln_indo] = $item['saldo_akhir'];
            $data[$item['jenis_kas']]['uraian'] = $tag;
            $data[$item['jenis_kas']]['id_aruskas'] = $item['id_aruskas'];
            $names[] =  $bln_indo;
            $bln_thn[] =  $bln_indo.' - '.$item['tahun'];

        }
        // filter data
        $dt['first'] = konversi_bln('1', 'fullbulan');
        $dt['last'] = konversi_bln('12', 'fullbulan');

        $dt['data'] =  $data;
        $dt['names'] = array_unique($names);
        $dt['bln_thn'] = array_unique($bln_thn);
        $dt['count'] = count($dt['bln_thn']);
        $dt['bread'] = array('header'=>'Dashboard - Arus Kas', 'subheader'=>'Dashboard');
        $dt['view']  = "dashboard/dashboard_aruskas";
        $this->load->view('main/utama', $dt);


        // echo "<pre>";
        // print_r($sum_aruskas);exit();

    }

    public function coba()
    {

        $input = [
            ['tahun' => '2020', 'name' => 'Fred', 'value' => '16.00', 'bulan' => 'Desember'],
            ['tahun' => '2021', 'name' => 'Fred', 'value' => '12.00', 'bulan' => 'Januari'],
            ['tahun' => '2021', 'name' => 'Tom', 'value' => '160.00', 'bulan' => 'Februari'],
            ['tahun' => '2021', 'name' => 'Mike', 'value' => '9.00', 'bulan' => 'Maret'],
            ['tahun' => '2021', 'name' => 'Tony', 'value' => '200.00', 'bulan' => 'April'],
            ['tahun' => '2021', 'name' => 'Fred', 'value' => '43.00', 'bulan' => 'Mei'],
            ['tahun' => '2021', 'name' => 'Tom', 'value' => '114.00', 'bulan' => 'Juni'],
            ['tahun' => '2021', 'name' => 'Mike', 'value' => '28.00', 'bulan' => 'Juli'],
        ];

        $data = $names = [];

        foreach($input as $item) {
            $data[$item['name']][$item['bulan']] = $item['value'];
            $names[] = $item['bulan'];
            $bln_thn[] = $item['bulan'].'-'.$item['tahun'];
        }
        $dt['data'] =  $data;
        $dt['names'] = array_unique($names);
        $dt['bln_thn'] = array_unique($bln_thn);
        $dt['count'] = count($bln_thn);
        $dt['bread'] = array('header'=>'Dashboard', 'subheader'=>'Dashboard-TEST');
        $dt['view']  = "dashboard/test";
        $this->load->view('main/utama', $dt);

        echo "<pre>";
        print_r($data);exit();
    }


	function getdisplay($type){
		switch($type){
			case 'testing_array':

				$array['nil1'] = 50;
				$array['nil2'] = 50;

				echo json_encode($array);
			break;
			case 'testing_array_bar':

				$array['arr_bln'] = array('Jan',
					'Feb',
					'Mar',
					'Apr',
					'May',
					'Jun',
					'Jul',
					'Aug',
					'Sep',
					'Oct',
					'Nov',
					'Dec');
				$array['arr_data'] = array( 152269108584170, 152920195880354, 145491894948828 , 0, 0, 0, 0, 0, 0, 0, 0, 0);
				$array['arr_data1'] = array( 1020682613596, 943102347709, 952572228287 , 0, 0, 0, 0, 0, 0, 0, 0, 0);
				$array['arr_data2'] = array( 1020682613596, 1963784961305, 2916357189592 , 0, 0, 0, 0, 0, 0, 0, 0, 0);
				$array['arr_data3'] = array( 0.67, 1.29, 1.94 , 0, 0, 0, 0, 0, 0, 0, 0, 0);
				// print($array);exit();
				echo json_encode($array);
			break;

			case 'testing_array_bar_smt2':

				$array['arr_bln'] = array('Semester-I', 'Semester-II');
				$array['arr_data'] = array( 5949969270987, 6822796897766);
				$array['arr_data1'] = array( 149598834438118, 1626288265749.78);
				$array['arr_data2'] = array( 5949969270987.07 , 6822796897766);
				$array['arr_data3'] = array( 1.97 , 2.10);
				$array['arr_data4'] = array( 3.99 , 4.30);
				// print($array);exit();
				echo json_encode($array);
			break;


			case 'summary_periodik_bulanan':
				$array_bln = array();
				$array1 = array();
                $array2 = array();
				$array3 = array();

				$bln = $this->input->post('id_bulan');
				if($bln != ''){
					$bln = $bln;
				}else{
					$bln = date('m');
				}

				$data = $this->analisis_model->getdata('summary_periodik_chart','result_array', $bln);
				
				foreach ($data as $ky => $vy) {
					$array_bln[$ky] = $vy['nama_bulan'];
					$array1[$ky] = (float)$vy['saldo_akhir_invest'];
					$array2[$ky] = (float)$vy['saldo_akhir_hasil'];

				}

                $data_yoi= $this->analisis_periodik_yoi();
                foreach ($data_yoi as $k => $v) {
                    $array3[$k] = (float)$v['yoi'];

                }

				$array['arr_bln'] = $array_bln;
				$array['invest'] = $array1;
                $array['hasil'] = $array2;
				$array['yoi'] = $array3;

				// echo "<pre>";
				// print_r($array3);exit();

				echo json_encode($array);
			break;

			case 'summary_periodik_semester':
				$data = $this->analisis_model->getdata('summary_periodik_semester','row_array','');
				$roi_hasil_smt1 = ($data['nil_hasil_smt1']!=0)?($data['saldo_akhir_hasil_smt1']/$data['nil_hasil_smt1'])*100:0;
				$roi_hasil_smt2 = ($data['nil_hasil_smt2']!=0)?($data['saldo_akhir_hasil_smt2']/$data['nil_hasil_smt2'])*100:0;

                $array4 = array();
                $yoi_semester = $this->analisis_periodik_semesteran();
                foreach ($yoi_semester as $k => $v) {
                    $array4['yoi_smt1'] = (float)round($v['yoi_smt1_chart'],2);
                    $array4['yoi_smt2'] = (float)round($v['yoi_smt2_chart'],2);
            
                }

				$array1[0] = (float)$data['saldo_akhir_hasil_smt1'];
				$array1[1] = (float)$data['saldo_akhir_hasil_smt2'];
				$array2[0] = (float)$data['saldo_akhir_invest_smt1'];
				$array2[1] = (float)$data['saldo_akhir_invest_smt2'];
				$array3[0] = (float)round($roi_hasil_smt1,2);
				$array3[1] = (float)round($roi_hasil_smt2,2);
                $array5[0] = (float)$array4['yoi_smt1'];
                $array5[1] = (float)$array4['yoi_smt2'];
                


				$dt['semester'] = array('Semester-I', 'Semester-II');
				$dt['hasil'] = $array1;
				$dt['invest'] = $array2;
				$dt['roi'] = $array3;
				$dt['yoi'] = $array5;
				// echo "<pre>";
				// print_r($array5);exit();

				echo json_encode($dt);
			break;

			case 'summary_periodik_tahunan':
				$tahun = $this->session->userdata('tahun');
				$data = $this->analisis_model->getdata('summary_periodik_tahunan','row_array','');
				$roi_hasil_thn = ($data['nil_hasil_thn']!=0)?($data['saldo_akhir_hasil_thn']/$data['nil_hasil_thn'])*100:0;
				$roi_hasil_thn_lalu = ($data['nil_hasil_thn_lalu']!=0)?($data['saldo_akhir_hasil_thn_lalu']/$data['nil_hasil_thn_lalu'])*100:0;

                $array4 = array();
                $yoi_tahunan = $this->analisis_periodik_tahunan();
                foreach ($yoi_semester as $k => $v) {
                    $array4['yoi_thn'] = (float)round($v['yoi_thn_chart'],2);
                    $array4['yoi_thn_lalu'] = (float)round($v['yoi_thn_lalu_chart'],2);
            
                }

				$array[0] = (int)$tahun - 1;
				$array[1] = (int)$tahun;
				$array1[0] = (float)$data['saldo_akhir_hasil_thn_lalu'];
				$array1[1] = (float)$data['saldo_akhir_hasil_thn'];
				$array2[0] = (float)$data['saldo_akhir_invest_thn_lalu'];
				$array2[1] = (float)$data['saldo_akhir_invest_thn'];
				$array3[0] = (float)round($roi_hasil_thn_lalu,2);
				$array3[1] = (float)round($roi_hasil_thn,2);
                $array5[0] = (float)$array4['yoi_thn'];
                $array5[1] = (float)$array4['yoi_thn_lalu'];


				$dt['tahun'] = $array;
				$dt['hasil'] = $array1;
				$dt['invest'] = $array2;
				$dt['roi'] = $array3;
				$dt['yoi'] = $array5;

				// echo "<pre>";
				// print_r($dt);exit();

				echo json_encode($dt);
			break;

            case 'summary_dana_bersih':
                $array1 = array();
                $array2 = array();

                $sum_dbersih = $this->analisis_model->getdata('dana_bersih', 'result_array');
                $i=0;
                foreach ($sum_dbersih as $k => $v) {
                    if ($v['uraian'] === 'DANA BERSIH') {
                        $array1[$i] = (float)(isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
                        $array2[$i] = konversi_bln($v['id_bulan'], 'fullbulan').' - '.$v['tahun'];

                        $i++;
                    }
                    
                }

                $dt['arr_bln'] = $array2;
                $dt['nilai'] = $array1;
                // echo "<pre>";
                // print_r($sum_dbersih);exit();
                echo json_encode($dt);
            break;

            case 'summary_dana_bersih_invest':
                $ds = $this->input->post('dashboard');
                $kode_invest = $this->input->post('detail_invest');

                $array1 = array();
                $array2 = array();

                if ($ds == '2') {
                    $flag =  'BUKAN INVESTASI';
                }elseif ($ds == '3'){
                    $flag =  'KEWAJIBAN'; 
                }else{
                    $flag =  'INVESTASI'; 
                }

                // kondisi jika combo investasi di pilih / detail_invest terisi
                if ($kode_invest != "") {
                    $sum_dbersih = $this->analisis_model->getdata('dana_bersih_invest_pihak_detail', 'result_array', $kode_invest);
                    $nil=0;
                    foreach ($sum_dbersih as $k => $v) {
                        if ($v['nama_pihak'] === 'JUMLAH') {
                            $array1[$nil] = (float)(isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
                            $array2[$nil] = konversi_bln($v['id_bulan'], 'fullbulan').' - '.$v['tahun'];

                            $nil++;
                        }
                    }
                }else{
                    $sum_dbersih = $this->analisis_model->getdata('dana_bersih_invest', 'result_array', $flag);
                    $nil=0;
                    foreach ($sum_dbersih as $k => $v) {
                        if ($v['jenis_investasi'] === 'JUMLAH') {
                            $array1[$nil] = (float)(isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
                            $array2[$nil] = konversi_bln($v['id_bulan'], 'fullbulan').' - '.$v['tahun'];

                            $nil++;
                        }
                    }
                }
                

                $dt['arr_bln'] = $array2;
                $dt['nilai'] = $array1;
                // echo "<pre>";
                // print_r($array2);exit();
                echo json_encode($dt);
            break;
            case 'summary_aruskas_head':
                $array1 = array();
                $array2 = array();

                $sum_aruskas = $this->analisis_model->getdata('arus_kas_detail', 'result_array');
                $nil=0;
                foreach ($sum_aruskas as $k => $v) {
                    if ($v['jenis_kas'] === 'KAS DAN BANK PADA AKHIR BULAN') {
                        $array1[$nil] = (float)(isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
                        $array2[$nil] = konversi_bln($v['id_bulan'], 'fullbulan').' - '.$v['tahun'];

                        $nil++;
                    }
                }

                $dt['arr_bln'] = $array2;
                $dt['nilai'] = $array1;
                // echo "<pre>";
                // print_r($sum_aruskas);exit();
                echo json_encode($dt);
            break;
            case 'summary_aruskas_detail':
                $ds = $this->input->post('jns_lap');

                $array1 = array();
                $array2 = array();

                if ($ds == 'INVESTASI') {
                    $flag =  'INVESTASI';
                }elseif ($ds == 'OPERASIONAL'){
                    $flag =  'OPERASIONAL'; 
                }else{
                    $flag =  'PENDANAAN'; 
                }

                $sum_aruskas = $this->analisis_model->getdata('arus_kas_detail_aktivitas', 'result_array', $flag);
                $nil=0;
                foreach ($sum_aruskas as $k => $v) {
                    if ($v['jenis_kas'] === 'JUMLAH') {
                        $array1[$nil] = (float)(isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
                        $array2[$nil] = konversi_bln($v['id_bulan'], 'fullbulan').' - '.$v['tahun'];

                        $nil++;
                    }
                }

                $dt['arr_bln'] = $array2;
                $dt['nilai'] = $array1;
                // echo "<pre>";
                // print_r($sum_aruskas);exit();
                echo json_encode($dt);
            break;
            case 'summary_perubahan_dana_bersih':
                $ds = $this->input->post('jns_lap');

                $array1 = array();
                $array2 = array();

                if ($ds == 'PENAMBAHAN') {
                    $flag =  'PENAMBAHAN';
                }elseif ($ds == 'PENGURANGAN'){
                    $flag =  'PENGURANGAN'; 
                }else{
                    $flag =  'PENAMBAHAN';
                }

                $sum_perubahandanabersih = $this->analisis_model->getdata('perubahandanabersih_detail', 'result_array', $flag);
                $nil=0;
                foreach ($sum_perubahandanabersih as $k => $v) {
                    if ($v['jenis_investasi'] === 'JUMLAH') {
                        $array1[$nil] = (float)(isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
                        $array2[$nil] = konversi_bln($v['id_bulan'], 'fullbulan').' - '.$v['tahun'];

                        $nil++;
                    }
                }

                $dt['arr_bln'] = $array2;
                $dt['nilai'] = $array1;
                // echo "<pre>";
                // print_r($sum_perubahandanabersih);exit();
                echo json_encode($dt);
            break;
		}
	}

	function get_index($mod){
        switch($mod){
            case 'index-dashboard-analisis':
            	$data['iduser'] = $this->input->post('iduser');
            	$ds = $this->input->post('dashboard');

	            // $data['opt_dashboard'] = combo_dashboard();
	            // $data['bread'] = array('header'=>'Dashboard', 'subheader'=>'Dashboard-Analisis');

	            if ($ds == "BULANAN") {
	            	$bln = $this->input->post('id_bulan');
	            	if($bln != ''){
	            		$data['bln'] = $bln;
	            	}else{
	            		$data['bln'] = date('m');
	            	}

	            	$data['summary_periodik'] = $this->analisis_periodik();
	            	$data['view']  = "dashboard/dashboard_executive_summary_bulanan";
	            }elseif ($ds == "SEMESTERAN") {
	            	$data['summary_periodik_semester'] = $this->analisis_periodik_semesteran('group');
	            	$data['view']  = "dashboard/dashboard_executive_summary_semesteran";
	            }elseif ($ds == "TAHUNAN"){
	            	$data['summary_periodik_tahunan'] = $this->analisis_periodik_tahunan('group');
	            	$data['view']  = "dashboard/dashboard_executive_summary_tahunan";
	            }
              
                // print_r($data);exit;
            break;

            case 'index-dashboard-danabersih':
                $data['iduser'] = $this->input->post('iduser');
                $ds = $this->input->post('dashboard');
                $kode_invest = $this->input->post('detail_invest');

                $dshbrd = $this->input->post('dashboard');
                $thn_awal = $this->input->post('tahun_awal');
                $bln_awal = $this->input->post('bln_awal');
                $thn_akhir = $this->input->post('tahun_akhir');
                $bln_akhir = $this->input->post('bln_akhir');

                $data['opt_dashboard'] = combo_dashboard();
                $data['opt_bln'] = combo_bulan();
                $data['opt_user'] = dtuser();
                $data['bln'] = date('m');

                if ($ds) {
                    if ($ds == '2') {
                       $flag =  'BUKAN INVESTASI';
                    }elseif ($ds == '3') {
                        $flag =  'KEWAJIBAN';
                    }else{
                        $flag =  'INVESTASI'; 

                        if ($kode_invest != "") {
                            $rincian_invest = $this->analisis_model->getdata('dana_bersih_invest_pihak_detail', 'result_array', $kode_invest);
                            $data2 = $names = [];
                            foreach($rincian_invest as $item) {
                                $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
                                $data2[$item['nama_pihak']][$bln_indo] = $item['saldo_akhir'];
                                $data2[$item['nama_pihak']]['uraian'] = $item['nama_pihak'];
                                $names[] = $bln_indo;
                                $bln_thn[] = $bln_indo.' - '.$item['tahun'];

                            }
                            // filter data
                            $data['first1'] = konversi_bln($bln_awal, 'fullbulan');
                            $data['last1'] = konversi_bln($bln_akhir, 'fullbulan');

                            $data['data1'] =  $data2;
                            $data['flag1'] =  $flag;
                            $data['names1'] = array_unique($names);
                            $data['bln_thn1'] = array_unique($bln_thn);
                            $data['count1'] = count($data['bln_thn1']);
                            $data['nama_invest'] = getJenisInvest($kode_invest);

                            // echo '<pre>';
                            // print_r($rincian_invest);exit;
                        }else {
                            $rincian_invest = $this->analisis_model->getdata('dana_bersih_invest_pihak', 'result_array');
                            $data2 = $names = [];
                            foreach($rincian_invest as $item) {
                                $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
                                $data2[$item['nama_pihak']][$bln_indo] = $item['total_perpihak'];
                                $data2[$item['nama_pihak']]['uraian'] = $item['nama_pihak'];
                                $names[] = $bln_indo;
                                $bln_thn[] = $bln_indo.' - '.$item['tahun'];

                            }
                            // filter data
                            $data['first1'] = konversi_bln($bln_awal, 'fullbulan');
                            $data['last1'] = konversi_bln($bln_akhir, 'fullbulan');

                            $data['data1'] =  $data2;
                            $data['flag1'] =  $flag;
                            $data['names1'] = array_unique($names);
                            $data['bln_thn1'] = array_unique($bln_thn);
                            $data['count1'] = count($data['bln_thn1']);
                            // echo '<pre>';
                            // print_r($data2);exit;
                        }
                    }
                    $dbersih_invest = $this->analisis_model->getdata('dana_bersih_invest', 'result_array', $flag);
                    $data1 = $names = [];
                    foreach($dbersih_invest as $item) {
                        $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
                        $data1[$item['jenis_investasi']][$bln_indo] = $item['saldo_akhir'];
                        $data1[$item['jenis_investasi']]['uraian'] = $item['jenis_investasi'];
                        $names[] = $bln_indo;
                        $bln_thn[] = $bln_indo.' - '.$item['tahun'];

                    }
                    // filter data
                    $data['first'] = konversi_bln($bln_awal, 'fullbulan');
                    $data['last'] = konversi_bln($bln_akhir, 'fullbulan');

                    $data['data'] =  $data1;
                    $data['flag'] =  $flag;
                    $data['kode_invest'] =  $kode_invest;
                    $data['names'] = array_unique($names);
                    $data['bln_thn'] = array_unique($bln_thn);
                    $data['count'] = count($data['bln_thn']);
                    $data['view']  = "dashboard/dashboard_danabersih_invest_detail";

                }else{
                    $sum_dbersih = $this->dbersih();
                    $data1 = $names = [];
                    foreach($sum_dbersih as $item) {
                        $data1[$item['judul_head']][$item['bulan']] = $item['saldo_akhir'];
                        $data1[$item['judul_head']]['uraian'] = $item['uraian'];
                        $names[] = $item['bulan'];
                        $bln_thn[] = $item['bulan'].' - '.$item['tahun'];

                    }
                    // filter data
                    $data['first'] = konversi_bln($bln_awal, 'fullbulan');
                    $data['last'] = konversi_bln($bln_akhir, 'fullbulan');

                    $data['data'] =  $data1;
                    $data['names'] = array_unique($names);
                    $data['bln_thn'] = array_unique($bln_thn);
                    $data['count'] = count($data['bln_thn']);


                    $data['view']  = "dashboard/dashboard_danabersih_invest_head";

                }
                
                // echo '<pre>';
                // print_r($data);exit;
            break;
            case 'index-dashboard-aruskas':
                $data['iduser'] = $this->input->post('iduser');
                $ds = $this->input->post('jns_lap');

                $dshbrd = $this->input->post('dashboard');
                $thn_awal = $this->input->post('tahun_awal');
                $bln_awal = $this->input->post('bln_awal');
                $thn_akhir = $this->input->post('tahun_akhir');
                $bln_akhir = $this->input->post('bln_akhir');

                $data['opt_dashboard'] = combo_dashboard();
                $data['opt_bln'] = combo_bulan();
                $data['opt_user'] = dtuser();
                $data['bln'] = date('m');
                $data['opt_aruskas'] = aruskas();

                if ($ds) {
                    if ($ds == 'INVESTASI') {
                        $flag =  'INVESTASI';
                    }elseif ($ds == 'OPERASIONAL'){
                        $flag =  'OPERASIONAL'; 
                    }else{
                        $flag =  'PENDANAAN'; 
                    }

                    $dt_aruskas = $this->analisis_model->getdata('arus_kas_detail_aktivitas', 'result_array', $flag);
                    $data1 = $names = [];
                    foreach($dt_aruskas as $item) {
                        $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
                        $data1[$item['arus_kas']][$bln_indo] = $item['saldo_akhir'];
                        $data1[$item['arus_kas']]['uraian'] = $item['arus_kas'];
                        $data1[$item['arus_kas']]['jenis_kas'] = $item['jenis_kas'];
                        $names[] = $bln_indo;
                        $bln_thn[] = $bln_indo.' - '.$item['tahun'];

                    }
                        // filter data
                    $data['first'] = konversi_bln($bln_awal, 'fullbulan');
                    $data['last'] = konversi_bln($bln_akhir, 'fullbulan');

                    $data['data'] =  $data1;
                    $data['flag'] =  $flag;
                    $data['names'] = array_unique($names);
                    $data['bln_thn'] = array_unique($bln_thn);
                    $data['count'] = count($data['bln_thn']);

                    $data['view']  = "dashboard/dashboard_aruskas_detail";
                }else{
                    $sum_aruskas = $this->analisis_model->getdata('arus_kas_detail', 'result_array');
                    $data1 = $names = [];
                    foreach($sum_aruskas as $item) {
                        $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
                        
                        if ($item['jenis_kas'] == 'INVESTASI') {
                            $tag =  'Arus Kas Dari Aktivitas Investasi';
                        }elseif ($item['jenis_kas'] == 'OPERASIONAL'){
                            $tag =  'Arus Kas Dari Aktivitas Operasional'; 
                        }elseif ($item['jenis_kas'] == 'PENDANAAN'){
                            $tag =  'Arus Kas Dari Aktivitas Pendanaan'; 
                        }else{
                            $tag = $item['jenis_kas'];
                        }
                        $data1[$item['jenis_kas']][$bln_indo] = $item['saldo_akhir'];
                        $data1[$item['jenis_kas']]['uraian'] = $tag;
                        $data1[$item['jenis_kas']]['id_aruskas'] = $item['id_aruskas'];
                        $names[] =  $bln_indo;
                        $bln_thn[] =  $bln_indo.' - '.$item['tahun'];

                    }
                    // filter data
                    $data['first'] = konversi_bln($bln_awal, 'fullbulan');
                    $data['last'] = konversi_bln($bln_akhir, 'fullbulan');

                    $data['data'] =  $data1;
                    $data['names'] = array_unique($names);
                    $data['bln_thn'] = array_unique($bln_thn);
                    $data['count'] = count($data['bln_thn']);
                    $data['view']  = "dashboard/dashboard_aruskas_head";
                }

                // echo '<pre>';
                // print_r($data);exit;
            break;

            case 'index-dashboard-perubahandanabersih':
                $data['iduser'] = $this->input->post('iduser');
                $ds = $this->input->post('jns_lap');

                $dshbrd = $this->input->post('dashboard');
                $thn_awal = $this->input->post('tahun_awal');
                $bln_awal = $this->input->post('bln_awal');
                $thn_akhir = $this->input->post('tahun_akhir');
                $bln_akhir = $this->input->post('bln_akhir');

                $data['opt_dashboard'] = combo_dashboard();
                $data['opt_bln'] = combo_bulan();
                $data['opt_user'] = dtuser();
                $data['bln'] = date('m');
                $data['opt_aruskas'] = aruskas();

                if ($ds) {
                    if ($ds == 'PENAMBAHAN') {
                        $flag =  'PENAMBAHAN';
                    }elseif ($ds == 'PENGURANGAN'){
                        $flag =  'PENGURANGAN'; 
                    }

                    $dt_perubahandanabersih = $this->analisis_model->getdata('perubahandanabersih_detail', 'result_array', $flag);
                    $data1 = $names = [];
                    foreach($dt_perubahandanabersih as $item) {
                        $bln_indo = konversi_bln($item['id_bulan'], 'fullbulan');
                        $data1[$item['jenis_investasi']][$bln_indo] = $item['saldo_akhir'];
                        $data1[$item['jenis_investasi']]['uraian'] = $item['jenis_investasi'];
                        $names[] = $bln_indo;
                        $bln_thn[] = $bln_indo.' - '.$item['tahun'];

                    }
                    // filter data
                    $data['first'] = konversi_bln($bln_awal, 'fullbulan');
                    $data['last'] = konversi_bln($bln_akhir, 'fullbulan');

                    $data['data'] =  $data1;
                    $data['flag'] =  $flag;
                    $data['names'] = array_unique($names);
                    $data['bln_thn'] = array_unique($bln_thn);
                    $data['count'] = count($data['bln_thn']);

                    $data['view']  = "dashboard/dashboard_perubahandanabersih_detail";
                }
            break;

            case 'index-aspek-operasional':
                $data['iduser'] = $this->input->post('iduser');
                $thn_awal = $this->input->post('tahun_awal');

                $data['opt_user'] = dtuser();
                $data['tahun'] =  $thn_awal;
                $data['nilai_tunai'] =  $this->analisis_model->getdataSemester('nilai_tunai_detail', 'result_array');
                $data['data_kelompok'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_kelompok', 'result_array','2');
                $data['data_jenis'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_jenis', 'result_array','2');
                $data['view']  = "dashboard/dashboard_aspek_operasional_head";
            break;

            case 'index-aspek-belanja':
                $data['iduser'] = $this->input->post('iduser');
                $thn_awal = $this->input->post('tahun_awal');

                $data['opt_user'] = dtuser();
                $data['tahun'] =  $thn_awal;
                $data['klaim'] =  $this->analisis_model->getdataSemester('klaim_detail', 'result_array');
                $data['data_kelompok'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_kelompok', 'result_array','1');
                $data['data_jenis'] = $this->analisis_model->getdataSemester('pembayaran_pensiun_jenis', 'result_array','1');
                $data['view']  = "dashboard/dashboard_aspek_belanja_head";
            break;
            
        }

        $data['mod'] = $mod;
        $data['acak'] = md5(date('H:i:s'));
        // echo '<pre>';
        // print_r($data);exit;
        $dt = $this->load->view($data['view'], $data, TRUE);
        echo $dt;
    }

    function dbersih(){
        $array = array();
        $dana_bersih = $this->analisis_model->getdata('dana_bersih','result_array');
        foreach ($dana_bersih as $key => $val) {
            if($val['uraian'] == 'ASET INVESTASI'){
                $judul_total = 'Aset Dalam Bentuk Investasi';
                $judul_head = 'DALAM BENTUK INVESTASI';
            }else if($val['uraian'] == 'ASET BUKAN INVESTASI'){
                $judul_total = 'Total Aset Bukan Investasi';
                $judul_head = 'DALAM BENTUK BUKAN INVESTASI';
            }else if($val['uraian'] == 'KEWAJIBAN'){
                $judul_total = 'Total Kewajiban';
                $judul_head = 'KEWAJIBAN';
            }else if($val['uraian'] == 'DANA BERSIH'){
                $judul_total = 'Total Dana Bersih';
                $judul_head = 'DANA BERSIH';
            }

            $array[$key]['uraian'] = $val['uraian'];
            $array[$key]['bulan'] = konversi_bln($val['id_bulan'], 'fullbulan');
            $array[$key]['id_bulan'] = $val['id_bulan'];
            $array[$key]['tahun'] = $val['tahun'];
            $array[$key]['tbln'] = konversi_bln($val['id_bulan'], 'fullbulan').' - '.$val['tahun'];
            $array[$key]['judul_total'] = $judul_total;
            $array[$key]['judul_head'] = $judul_head;
            $array[$key]['saldo_akhir'] =  (isset($val['saldo_akhir']) ? $val['saldo_akhir'] : 0) ;


        }

        return $array;
    }

    function analisis_periodik(){
    	$array = array();
    	$array_nil = array();
    	$array_yoi = array();

    	$bln = $this->input->post('id_bulan');
        if($bln != ''){
            $bln = $bln;
        }else{
            $bln = date('m');
        }
  
    	$data = $this->analisis_model->getdata('summary_periodik','result_array', $bln);
    	$total_invest = 0;
        $total_hasil = 0;
    	$yoi_total = 0;
    	foreach ($data as $ky => $vy) {
            $array[$ky]['jenis_investasi'] = $vy['jenis_investasi'];
            $array[$ky]['bulan'] = $vy['id_bulan'];
            $array[$ky]['saldo_akhir_invest'] = $vy['saldo_akhir_invest'];
            $array[$ky]['saldo_akhir_hasil'] = $vy['saldo_akhir_hasil'];
            $array[$ky]['rka_invest'] = $vy['rka_invest'];
            $array[$ky]['rka_hasil'] = $vy['rka_hasil'];

            $total_invest += $vy['saldo_akhir_invest'];
            $total_hasil += $vy['saldo_akhir_hasil'];
        }
        $data['total_invest'] = $total_invest;
        $data['total_hasil'] = $total_hasil;
        $i=1;
        foreach ($array as $k => $v) {
        	$porsi_invest = ($data['total_invest']!=0)?($v['saldo_akhir_invest']/$data['total_invest'])*100:0;
        	$porsi_hasil = ($data['total_hasil']!=0)?($v['saldo_akhir_hasil']/$data['total_hasil'])*100:0;
        	$pers_invest = ($v['rka_invest']!=0)?($v['saldo_akhir_invest']/$v['rka_invest']):0;
        	$pers_hasil = ($v['rka_hasil']!=0)?($v['saldo_akhir_hasil']/$v['rka_hasil']):0;

        	$array_nil[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array_nil[$k]['bulan'] = $v['bulan'];
            $array_nil[$k]['saldo_akhir_invest'] = $v['saldo_akhir_invest'];
            $array_nil[$k]['porsi_invest'] = persen($porsi_invest);
            $array_nil[$k]['capaian_rit_invest'] = persen($pers_invest);
            $array_nil[$k]['saldo_akhir_hasil'] = $v['saldo_akhir_hasil'];
            $array_nil[$k]['porsi_hasil'] = persen($porsi_hasil);
            $array_nil[$k]['capaian_rit_hasil'] = persen($pers_hasil);
            $array_nil[$k]['rka_invest'] = $v['rka_invest'];
            $array_nil[$k]['rka_hasil'] = $v['rka_hasil'];

            $mul1 = $array_nil[$k]['saldo_akhir_invest'];
            $mul2 = $array_nil[$k]['saldo_akhir_invest'];
            $hsl = $array_nil[$k]['saldo_akhir_hasil'];
            $dt = ($k == 0) ? $mul2 : $dt*$mul2; 
            $dt_hasil = ($k == 0) ? $hsl : $dt_hasil+$hsl; 

         
            $nil_yoi = pow($dt,1/$array_nil[$k]['bulan']);
             
            $hasil = ($nil_yoi !=0)?($dt_hasil/$nil_yoi)*100:0;
       		$array_nil[$k]['yoi'] =  (!is_nan($hasil) ? persen($hasil) : '0,00');
            // $yoi_total += $array_nil[$k]['yoi'];

        }


        // echo '<pre>';
        // print_r($yoi_total);exit;

        return $array_nil;
    }


    function analisis_periodik_yoi(){
        $array = array();
        $array_nil = array();
        $array_yoi = array();

        $bln = $this->input->post('id_bulan');
        if($bln != ''){
            $bln = $bln;
        }else{
            $bln = date('m');
        }
  
        $data = $this->analisis_model->getdata('summary_yoi_periodik','result_array', $bln);
        $total_invest = 0;
        $total_hasil = 0;
        foreach ($data as $ky => $vy) {
            $array[$ky]['bulan'] = $vy['id_bulan'];
            $array[$ky]['saldo_akhir_invest'] = $vy['saldo_akhir_invest'];
            $array[$ky]['saldo_akhir_hasil'] = $vy['saldo_akhir_hasil'];
            $array[$ky]['rka_invest'] = $vy['rka_invest'];
            $array[$ky]['rka_hasil'] = $vy['rka_hasil'];

            $total_invest += $vy['saldo_akhir_invest'];
            $total_hasil += $vy['saldo_akhir_hasil'];
        }
        $data['total_invest'] = $total_invest;
        $data['total_hasil'] = $total_hasil;
        $i=1;
        foreach ($array as $k => $v) {
            $porsi_invest = ($data['total_invest']!=0)?($v['saldo_akhir_invest']/$data['total_invest'])*100:0;
            $porsi_hasil = ($data['total_hasil']!=0)?($v['saldo_akhir_hasil']/$data['total_hasil'])*100:0;
            $pers_invest = ($v['rka_invest']!=0)?($v['saldo_akhir_invest']/$v['rka_invest']):0;
            $pers_hasil = ($v['rka_hasil']!=0)?($v['saldo_akhir_hasil']/$v['rka_hasil']):0;

            $array_nil[$k]['bulan'] = $v['bulan'];
            $array_nil[$k]['saldo_akhir_invest'] = $v['saldo_akhir_invest'];
            $array_nil[$k]['porsi_invest'] = persen($porsi_invest);
            $array_nil[$k]['capaian_rit_invest'] = persen($pers_invest);
            $array_nil[$k]['saldo_akhir_hasil'] = $v['saldo_akhir_hasil'];
            $array_nil[$k]['porsi_hasil'] = persen($porsi_hasil);
            $array_nil[$k]['capaian_rit_hasil'] = persen($pers_hasil);
            $array_nil[$k]['rka_invest'] = $v['rka_invest'];
            $array_nil[$k]['rka_hasil'] = $v['rka_hasil'];

            $mul1 = $array_nil[$k]['saldo_akhir_invest'];
            $mul2 = $array_nil[$k]['saldo_akhir_invest'];
            $hsl = $array_nil[$k]['saldo_akhir_hasil'];
            $dt = ($k == 0) ? $mul2 : $dt*$mul2; 
            $dt_hasil = ($k == 0) ? $hsl : $dt_hasil+$hsl; 

         
            $nil_yoi = pow($dt,1/$array_nil[$k]['bulan']);
             
            $hasil = ($nil_yoi !=0)?($dt_hasil/$nil_yoi)*100:0;
            $array_nil[$k]['yoi'] =  (!is_nan($hasil) ? round($hasil,2) : '0,00');

        }

        // echo '<pre>';
        // print_r($array_nil);exit;

        return $array_nil;
    }


    function analisis_periodik_semesteran($p1=""){
    	$array = array();
    	$array_nil = array();
  
    	$data = $this->analisis_model->getdata('summary_periodik_semester','result_array', $p1);
    	$total_invest_smt1 = 0;
    	$total_hasil_smt1 = 0;
    	$total_invest_smt2 = 0;
    	$total_hasil_smt2 = 0;
    	foreach ($data as $ky => $vy) {
            $array[$ky]['jenis_investasi'] = $vy['jenis_investasi'];
            $array[$ky]['bulan'] = $vy['id_bulan'];
            $array[$ky]['saldo_akhir_invest_smt1'] = $vy['saldo_akhir_invest_smt1'];
            $array[$ky]['saldo_akhir_hasil_smt1'] = $vy['saldo_akhir_hasil_smt1'];
            $array[$ky]['rka_invest_smt1'] = $vy['rka_invest_smt1'];
            $array[$ky]['rka_hasil_smt1'] = $vy['rka_hasil_smt1'];
            $array[$ky]['nil_hasil_smt1'] = $vy['nil_hasil_smt1'];

            $array[$ky]['saldo_akhir_invest_smt2'] = $vy['saldo_akhir_invest_smt2'];
            $array[$ky]['saldo_akhir_hasil_smt2'] = $vy['saldo_akhir_hasil_smt2'];
            $array[$ky]['rka_invest_smt2'] = $vy['rka_invest_smt2'];
            $array[$ky]['rka_hasil_smt2'] = $vy['rka_hasil_smt2'];
            $array[$ky]['nil_hasil_smt2'] = $vy['nil_hasil_smt2'];

            $total_invest_smt1 += $vy['saldo_akhir_invest_smt1'];
            $total_hasil_smt1 += $vy['saldo_akhir_hasil_smt1'];
            $total_invest_smt2 += $vy['saldo_akhir_invest_smt2'];
            $total_hasil_smt2 += $vy['saldo_akhir_hasil_smt2'];
        }
        $data['total_invest_smt1'] = $total_invest_smt1;
        $data['total_hasil_smt1'] = $total_hasil_smt1;
        $data['total_invest_smt2'] = $total_invest_smt2;
        $data['total_hasil_smt2'] = $total_hasil_smt2;

        foreach ($array as $k => $v) {
        	$porsi_invest_smt1 = ($data['total_invest_smt1']!=0)?($v['saldo_akhir_invest_smt1']/$data['total_invest_smt1'])*100:0;
        	$porsi_hasil_smt1 = ($data['total_hasil_smt1']!=0)?($v['saldo_akhir_hasil_smt1']/$data['total_hasil_smt1'])*100:0;
        	$roi_hasil_smt1 = ($v['nil_hasil_smt1']!=0)?($v['saldo_akhir_hasil_smt1']/$v['nil_hasil_smt1'])*100:0;
        	$pers_invest_smt1 = ($v['rka_invest_smt1']!=0)?($v['saldo_akhir_invest_smt1']/$v['rka_invest_smt1']):0;
        	$pers_hasil_smt1 = ($v['rka_hasil_smt1']!=0)?($v['saldo_akhir_hasil_smt1']/$v['rka_hasil_smt1']):0;

        	$porsi_invest_smt2 = ($data['total_invest_smt2']!=0)?($v['saldo_akhir_invest_smt2']/$data['total_invest_smt2'])*100:0;
        	$porsi_hasil_smt2 = ($data['total_hasil_smt2']!=0)?($v['saldo_akhir_hasil_smt2']/$data['total_hasil_smt2'])*100:0;
        	$roi_hasil_smt2 = ($v['nil_hasil_smt2']!=0)?($v['saldo_akhir_hasil_smt2']/$v['nil_hasil_smt2'])*100:0;
        	$pers_invest_smt2 = ($v['rka_invest_smt2']!=0)?($v['saldo_akhir_invest_smt2']/$v['rka_invest_smt2']):0;
        	$pers_hasil_smt2 = ($v['rka_hasil_smt2']!=0)?($v['saldo_akhir_hasil_smt2']/$v['rka_hasil_smt2']):0;

        	$array_nil[$k]['jenis_investasi'] = $v['jenis_investasi'];
        	$array_nil[$k]['bulan'] = $v['bulan'];
            $array_nil[$k]['saldo_akhir_invest_smt1'] = $v['saldo_akhir_invest_smt1'];
            $array_nil[$k]['porsi_invest_smt1'] = persen($porsi_invest_smt1);
            $array_nil[$k]['capaian_rit_invest_smt1'] = persen($pers_invest_smt1);
            $array_nil[$k]['saldo_akhir_hasil_smt1'] = $v['saldo_akhir_hasil_smt1'];
            $array_nil[$k]['porsi_hasil_smt1'] = persen($porsi_hasil_smt1);
            $array_nil[$k]['roi_hasil_smt1'] = persen($roi_hasil_smt1);
            $array_nil[$k]['capaian_rit_hasil_smt1'] = persen($pers_hasil_smt1);
            $array_nil[$k]['rka_invest_smt1'] = $v['rka_invest_smt1'];
            $array_nil[$k]['rka_hasil_smt1'] = $v['rka_hasil_smt1'];

            $mul_smt1[$k] = (float)$v['saldo_akhir_invest_smt1'];
            $hsl_smt1[$k] = (float)$v['saldo_akhir_hasil_smt1'];
            $dt_smt1 = ($k == 0) ? $mul_smt1[$k] : $dt_smt1*$mul_smt1[$k]; 
            $dt_hasil_smt1 = ($k == 0) ? $hsl_smt1[$k] : $dt_hasil_smt1+$hsl_smt1[$k]; 
            $nil_yoi_smt1 = pow($dt_smt1,1/$array_nil[$k]['bulan']);
            $hasil_smt1 = ($nil_yoi_smt1 !=0)?($dt_hasil_smt1/$nil_yoi_smt1)*100:0;
            $array_nil[$k]['yoi_smt1'] =  (!is_nan($hasil_smt1) ? persen($hasil_smt1) : '0,00');
       		$array_nil[$k]['yoi_smt1_chart'] =  (!is_nan($hasil_smt1) ? $hasil_smt1 : '0,00');

            $array_nil[$k]['saldo_akhir_invest_smt2'] = $v['saldo_akhir_invest_smt2'];
            $array_nil[$k]['porsi_invest_smt2'] = persen($porsi_invest_smt2);
            $array_nil[$k]['capaian_rit_invest_smt2'] = persen($pers_invest_smt2);
            $array_nil[$k]['saldo_akhir_hasil_smt2'] = $v['saldo_akhir_hasil_smt2'];
            $array_nil[$k]['porsi_hasil_smt2'] = persen($porsi_hasil_smt2);
            $array_nil[$k]['roi_hasil_smt2'] = persen($roi_hasil_smt2);
            $array_nil[$k]['capaian_rit_hasil_smt2'] = persen($pers_hasil_smt2);
            $array_nil[$k]['rka_invest_smt2'] = $v['rka_invest_smt2'];
            $array_nil[$k]['rka_hasil_smt2'] = $v['rka_hasil_smt2'];

            $mul_smt2[$k] = (float)$v['saldo_akhir_invest_smt2'];
            $hsl_smt2[$k] = (float)$v['saldo_akhir_hasil_smt2'];
            $dt_smt2 = ($k == 0) ? $mul_smt2[$k] : $dt_smt2*$mul_smt2[$k]; 
            $dt_hasil_smt2 = ($k == 0) ? $hsl_smt2[$k] : $dt_hasil_smt2+$hsl_smt2[$k]; 
            $nil_yoi_smt2 = pow($dt_smt2,1/$array_nil[$k]['bulan']);
            $hasil_smt2 = ($nil_yoi_smt2 !=0)?($dt_hasil_smt2/$nil_yoi_smt2)*100:0;
            $array_nil[$k]['yoi_smt2'] =  (!is_nan($hasil_smt2) ? persen($hasil_smt2) : '0,00');
       		$array_nil[$k]['yoi_smt2_chart'] =  (!is_nan($hasil_smt2) ? $hasil_smt2 : '0,00');

        }

    	// echo '<pre>';
     //    print_r($array_nil);exit;

        return $array_nil;
    }


    function analisis_periodik_tahunan($p1=""){
    	$array = array();
    	$array_nil = array();
  
    	$data = $this->analisis_model->getdata('summary_periodik_tahunan','result_array',$p1);
    	$total_invest_thn = 0;
    	$total_hasil_thn = 0;
    	$total_invest_thn_lalu = 0;
    	$total_hasil_thn_lalu = 0;
    	foreach ($data as $ky => $vy) {
            $array[$ky]['jenis_investasi'] = $vy['jenis_investasi'];
            $array[$ky]['saldo_akhir_invest_thn'] = $vy['saldo_akhir_invest_thn'];
            $array[$ky]['saldo_akhir_hasil_thn'] = $vy['saldo_akhir_hasil_thn'];
            $array[$ky]['rka_invest_thn'] = $vy['rka_invest_thn'];
            $array[$ky]['rka_hasil_thn'] = $vy['rka_hasil_thn'];
            $array[$ky]['nil_hasil_thn'] = $vy['nil_hasil_thn'];

            $array[$ky]['saldo_akhir_invest_thn_lalu'] = $vy['saldo_akhir_invest_thn_lalu'];
            $array[$ky]['saldo_akhir_hasil_thn_lalu'] = $vy['saldo_akhir_hasil_thn_lalu'];
            $array[$ky]['rka_invest_thn_lalu'] = $vy['rka_invest_thn_lalu'];
            $array[$ky]['rka_hasil_thn_lalu'] = $vy['rka_hasil_thn_lalu'];
            $array[$ky]['nil_hasil_thn_lalu'] = $vy['nil_hasil_thn_lalu'];

            $total_invest_thn += $vy['saldo_akhir_invest_thn'];
            $total_hasil_thn += $vy['saldo_akhir_hasil_thn'];
            $total_invest_thn_lalu += $vy['saldo_akhir_invest_thn_lalu'];
            $total_hasil_thn_lalu += $vy['saldo_akhir_hasil_thn_lalu'];
        }
        $data['total_invest_thn'] = $total_invest_thn;
        $data['total_hasil_thn'] = $total_hasil_thn;
        $data['total_invest_thn_lalu'] = $total_invest_thn_lalu;
        $data['total_hasil_thn_lalu'] = $total_hasil_thn_lalu;

        foreach ($array as $k => $v) {
        	$porsi_invest_thn = ($data['total_invest_thn']!=0)?($v['saldo_akhir_invest_thn']/$data['total_invest_thn'])*100:0;
        	$porsi_hasil_thn = ($data['total_hasil_thn']!=0)?($v['saldo_akhir_hasil_thn']/$data['total_hasil_thn'])*100:0;
        	$roi_hasil_thn = ($v['nil_hasil_thn']!=0)?($v['saldo_akhir_hasil_thn']/$v['nil_hasil_thn'])*100:0;
        	$pers_invest_thn = ($v['rka_invest_thn']!=0)?($v['saldo_akhir_invest_thn']/$v['rka_invest_thn']):0;
        	$pers_hasil_thn = ($v['rka_hasil_thn']!=0)?($v['saldo_akhir_hasil_thn']/$v['rka_hasil_thn']):0;

        	$porsi_invest_thn_lalu = ($data['total_invest_thn_lalu']!=0)?($v['saldo_akhir_invest_thn_lalu']/$data['total_invest_thn_lalu'])*100:0;
        	$porsi_hasil_thn_lalu = ($data['total_hasil_thn_lalu']!=0)?($v['saldo_akhir_hasil_thn_lalu']/$data['total_hasil_thn_lalu'])*100:0;
        	$roi_hasil_thn_lalu = ($v['nil_hasil_thn_lalu']!=0)?($v['saldo_akhir_hasil_thn_lalu']/$v['nil_hasil_thn_lalu'])*100:0;
        	$pers_invest_thn_lalu = ($v['rka_invest_thn_lalu']!=0)?($v['saldo_akhir_invest_thn_lalu']/$v['rka_invest_thn_lalu']):0;
        	$pers_hasil_thn_lalu = ($v['rka_hasil_thn_lalu']!=0)?($v['saldo_akhir_hasil_thn_lalu']/$v['rka_hasil_thn_lalu']):0;

        	$array_nil[$k]['jenis_investasi'] = $v['jenis_investasi'];
            $array_nil[$k]['saldo_akhir_invest_thn'] = $v['saldo_akhir_invest_thn'];
            $array_nil[$k]['porsi_invest_thn'] = persen($porsi_invest_thn);
            $array_nil[$k]['capaian_rit_invest_thn'] = persen($pers_invest_thn);
            $array_nil[$k]['saldo_akhir_hasil_thn'] = $v['saldo_akhir_hasil_thn'];
            $array_nil[$k]['porsi_hasil_thn'] = persen($porsi_hasil_thn);
            $array_nil[$k]['roi_hasil_thn'] = persen($roi_hasil_thn);
            $array_nil[$k]['capaian_rit_hasil_thn'] = persen($pers_hasil_thn);
            $array_nil[$k]['rka_invest_thn'] = $v['rka_invest_thn'];
            $array_nil[$k]['rka_hasil_thn'] = $v['rka_hasil_thn'];

            $mul_thn[$k] = (float)$v['saldo_akhir_invest_thn'];
            $hsl_thn[$k] = (float)$v['saldo_akhir_hasil_thn'];
            $dt_thn = ($k == 0) ? $mul_thn[$k] : $dt_thn*$mul_thn[$k]; 
            $dt_hasil_thn = ($k == 0) ? $hsl_thn[$k] : $dt_hasil_thn+$hsl_thn[$k]; 
            $nil_yoi_thn = pow($dt_thn,1/1);
            $hasil_thn = ($nil_yoi_thn !=0)?($dt_hasil_thn/$nil_yoi_thn)*100:0;
            $array_nil[$k]['yoi_thn'] =  (!is_nan($hasil_thn) ? persen($hasil_thn) : '0,00');
            $array_nil[$k]['yoi_thn_chart'] =  (!is_nan($hasil_thn) ? $hasil_thn : '0,00');

            $array_nil[$k]['saldo_akhir_invest_thn_lalu'] = $v['saldo_akhir_invest_thn_lalu'];
            $array_nil[$k]['porsi_invest_thn_lalu'] = persen($porsi_invest_thn_lalu);
            $array_nil[$k]['capaian_rit_invest_thn_lalu'] = persen($pers_invest_thn_lalu);
            $array_nil[$k]['saldo_akhir_hasil_thn_lalu'] = $v['saldo_akhir_hasil_thn_lalu'];
            $array_nil[$k]['porsi_hasil_thn_lalu'] = persen($porsi_hasil_thn_lalu);
            $array_nil[$k]['roi_hasil_thn_lalu'] = persen($roi_hasil_thn_lalu);
            $array_nil[$k]['capaian_rit_hasil_thn_lalu'] = persen($pers_hasil_thn_lalu);
            $array_nil[$k]['rka_invest_thn_lalu'] = $v['rka_invest_thn_lalu'];
            $array_nil[$k]['rka_hasil_thn_lalu'] = $v['rka_hasil_thn_lalu'];

            $mul_thn_lalu[$k] = (float)$v['saldo_akhir_invest_thn_lalu'];
            $hsl_thn_lalu[$k] = (float)$v['saldo_akhir_hasil_thn_lalu'];
            $dt_thn_lalu = ($k == 0) ? $mul_thn_lalu[$k] : $dt_thn_lalu*$mul_thn_lalu[$k]; 
            $dt_hasil_thn_lalu = ($k == 0) ? $hsl_thn_lalu[$k] : $dt_hasil_thn_lalu+$hsl_thn_lalu[$k]; 
            $nil_yoi_thn_lalu = pow($dt_thn_lalu,1/1);
            $hasil_thn_lalu = ($nil_yoi_thn_lalu !=0)?($dt_hasil_thn_lalu/$nil_yoi_thn_lalu)*100:0;
            $array_nil[$k]['yoi_thn_lalu'] =  (!is_nan($hasil_thn_lalu) ? persen($hasil_thn_lalu) : '0,00');
            $array_nil[$k]['yoi_thn_lalu_chart'] =  (!is_nan($hasil_thn_lalu) ? $hasil_thn_lalu : '0,00');
        }

    	// echo '<pre>';
     //    print_r($array_nil);exit;

        return $array_nil;
    }


    public function nilai_perubahan_danabersih(){
        $array = array();
        $perubahan_lv1 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv1','result_array');
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
            $array[$k]['sum_lvl1'] =  (isset($v['saldo_akhir']) ? $v['saldo_akhir'] : 0) ;
            $array[$k]['sum_prev_lvl1'] =  (isset($v['saldo_akhir_bln_lalu']) ? $v['saldo_akhir_bln_lalu'] : 0) ;
            $array[$k]['child'] = array();

            $perubahan_lv2 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv2','result_array', $v['uraian']);
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
                    $judul_total = 'Jumlah Peningkatan(Penurunan)';
                    $judul_head = 'NILAI INVESTASI';
                }else if($val['group'] == 'ASET TETAP'){
                    $judul_total = 'Sub Jumlah Aset Tetap';
                    $judul_head = 'ASET TETAP';
                }

                $array[$k]['child'][$key]['judul_head'] =  $judul_head;
                $array[$k]['child'][$key]['judul_total'] = $judul_total;
                $array[$k]['child'][$key]['id_perubahan_dana_bersih'] = $val['id_perubahan_dana_bersih'];
                $array[$k]['child'][$key]['group'] = $val['group'];
                $array[$k]['child'][$key]['sum_lvl2'] =  (isset($val['saldo_akhir']) ? $val['saldo_akhir'] : 0) ;
                $array[$k]['child'][$key]['sum_prev_lvl2'] =  (isset($val['saldo_akhir_bln_lalu']) ? $val['saldo_akhir_bln_lalu'] : 0) ;
                $array[$k]['child'][$key]['subchild'] = array();

                $perubahan_lv3 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv3','result_array', $val['group']);
                foreach ($perubahan_lv3 as $x => $y) {
                    $array[$k]['child'][$key]['subchild'][$x]['type'] = $y['type'];
                    $array[$k]['child'][$key]['subchild'][$x]['id_investasi'] = $y['id_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['jenis_investasi'] = $y['jenis_investasi'];
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir'] = (isset($y['saldo_akhir']) ? $y['saldo_akhir'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['saldo_akhir_bln_lalu'] = (isset($y['saldo_akhir_bln_lalu']) ? $y['saldo_akhir_bln_lalu'] : 0) ;
                    $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'] =  array();
                   
                    if($y['type'] == 'PC'){
                        $type = 'C';
                        $perubahan_lv4 = $this->aset_investasi_model->getdata('perubahan_danabersih_lv4','result_array', $y['id_investasi'], $type);
                        foreach ($perubahan_lv4 as $xx => $zz) {
                            $array[$k]['child'][$key]['subchild'][$x]['subchild_sub'][$xx]['type'] = $zz['type'];
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
    }

}
