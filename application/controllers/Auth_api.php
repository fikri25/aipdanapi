<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
class Auth_api extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();	
		$this->load->model('login_model');
		$this->load->library('Authorization_Token');	
		$this->load->library('form_validation');  
		date_default_timezone_set('Asia/Jakarta');   
	}
  
	
	public function index_post()
	{   
		$username = escape($this->post('username'));
        $password = escape($this->post('password'));
        $this->form_validation->set_rules(
                'username', 'Username',
                'required|min_length[6]|max_length[12]',
                        array(
                                'required'      => 'Mohon Masukkan %s.',
                        )
                );
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]',array(
                                'required'      => 'Mohon Masukkan %s.',
                        ));
        // cek username dan password
        if ($this->form_validation->run() != FALSE) {
        	// cek username dan password
        	if( $username && $password) {
        		$validate = $this->login_model->validate_api($username, $password);
        		
        		if ($validate['sts']=='true') {
        			$token_data = array('id_aktif'=>$validate['data']->iduser,'username_aktif'=>$validate['data']->nmuser,);
        			$tokenData = $this->authorization_token->generateToken($token_data);
					 $this->response([
		              'status'=>true,
		              'token'=>$tokenData
		              ],REST_Controller::HTTP_OK);
        		}else{
        			$this->response([
	                'status'=>false,
	                'message'=>$validate['pesan']
	                ],REST_Controller::HTTP_BAD_REQUEST);
        		}
        		
        	}else{
        		$this->response([
                'status'=>false,
                'message'=>'Form Login Belum Lengkap'
                ],REST_Controller::HTTP_BAD_REQUEST);
        	}
        }else{
			$error = validation_errors();
			$this->response([
                'status'=>false,
                'message'=>$error
                ],REST_Controller::HTTP_BAD_REQUEST);
        }
        

	}
	


 
}

