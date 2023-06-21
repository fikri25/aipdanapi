<?php 
if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
	}


	public function index()
	{
		$data['bread'] = array('header'=>'Dashboard', 'subheader'=>'Dashboard-1');
		$data['view']  = "dashboard/dashboard_1";
		$this->load->view('main/utama', $data);
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
				$array['arr_data'] = array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4);
				// print($array);exit();
				echo json_encode($array);
			break;
		}
	}

}
