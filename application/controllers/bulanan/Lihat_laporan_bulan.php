<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lihat_laporan_bulan extends CI_Controller {
   function __construct(){
      parent::__construct();
      $this->load->model('bulanan_model/bulan_model');
      $this->load->library('form_validation');

      //cek login
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		$userData=$this->session->userdata();
		//cek akses route
		// if($userData['idusergroup'] !== '001') show_404();
		
		$this->page_limit = 10;
		
	}

   public function index(){
   	$this->session->unset_userdata('id_bulan');
   	$this->session->unset_userdata('cari');
   	// var_dump($this->session->userdata('id_bulan'));exit;

      $data['data_bulan'] = $this->bulan_model->get_all();
      // $data['data_bulan'] = $this->bulan_model->get_jan();
		$data['bread'] = array('header'=>'Laporan Bulanan', 'subheader'=>'Lihat Laporan Bulan');
		$data['view']  = "bulanan/bulan/lihat_laporan_bulan";
		$this->load->view('main/utama', $data);
    }
}
