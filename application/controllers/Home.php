<?php 
	if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('sb_survei_model');
		$this->load->model('statistik_model', 'sm');

      if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
	}

	

	public function index($bln=0, $thn=0) {
		// print_r($this->session->userdata());exit;
		//======================== Investasi ========================
		// print_r($this->sm->getSumHasilInvest());exit;

		$dta = $this->sm->getSumProporsiAset();
		$sumData = array_sum($dta);
		$dt = array();
		for($i=0; $i<count($this->sm->getSumProporsiAset()); $i++) {
			@array_push($dt, ($dta[$i]/$sumData)*100);
		}
		
		$data['double_bar'] = $this->sm->getSumInvest();
		$data['proporsi_aset'] = $dta;
		$data['persen_proporsi_aset'] = $dt;
		$data['hasil_investasi'] = $this->sm->getTableHI();
		$data['radius_bulan'] = $this->sm->getRadiusBulan();
		$data['komposisi_deposito'] = $this->sm->getKomposisiDeposito();
		$data['komposisi_sbn'] = $this->sm->getKomposisiSBN();
		$data['komposisi_korporasi'] = $this->sm->getKomposisiObKorporasi();
		$data['komposisi_saham'] = $this->sm->getKomposisiSaham();
		$data['komposisi_reksa'] = $this->sm->getKomposisiReksa();
		$data['komposisi_penyel'] = $this->sm->getKomposisiPenyel();
		$data['data_tabel_pertama'] = $this->sm->dataTabelPertama();

		$data['total_invest'] = $this->sm->getSumTotalInvest();
		$data['hasil_invest'] = $this->sm->getSumHasilInvest();

		// get data tahun berjalan
		$data['beban_investasi'] = $this->sm->get_beban_investasi();
		$data['beban_operasional'] = $this->sm->get_beban_operasional();
		$data['sum_hasil_invest'] = $this->sm->get_sum_hasil_invest();
		// get data tahun sebelumnya (tahun-1)
		$data['bebanPrev_investasi'] = $this->sm->get_bebanPrev_investasi();
		$data['bebanPrev_operasional'] = $this->sm->get_bebanPrev_operasional();
		$data['sum_hasilPrev_invest'] = $this->sm->get_sumPrev_hasil_invest();

		$data['url'] = "home/menu";
		$data['bread'] = array('header'=>'Dashboard', 'subheader'=>'');
		$data['view'] = "main/dashboard";
		$this->load->view('main/utama', $data);
	}

	public function dash_map() {
		$row = $this->sb_survei_model->get_data();
		echo($row);
	}
}
