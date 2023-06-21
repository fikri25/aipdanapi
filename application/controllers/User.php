
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->library('form_validation');
		$this->load->model(array('Muser'));
	
		$this->auth = $this->session->userdata();
		if (! $this->session->userdata('isLoggedIn') ) redirect("login/show_login");
		
		$level=$this->session->userdata("level");
		//cek akses route
		if($level != 'DJA') show_error('Error 403 Access Denied', 403);


	}
	
	public function index(){

		if($this->auth){
			$data['user_list'] = $this->Muser->getdata('user_list', 'result_array');
			$data['bread'] = array('header'=>'Pengaturan', 'subheader'=>'Pengaturan');
			$data['view'] = "user/user_list";
			$this->load->view('main/utama',$data);
		}else{
			$this->load->view('main/utama_login');
		}
		
	}

	public function role_setting(){
		$data['bread'] = array('header'=>'Pengaturan', 'subheader'=>'Pengaturan');
		$data['view'] = "user/group_list";
		$data['role'] = $this->db->get('t_user_group')->result_array();
		$this->load->view('main/utama',$data);
	}

	public function roleaccess($role_id){
		$data['role'] = $this->db->get_where('t_user_group', ['idusergroup' => $role_id])->row_array();
		$data['menu_acc'] = $this->Muser->getdata('data_menu_all_usr', 'variable', $role_id);

		$data['bread'] = array('header'=>'Pengaturan', 'subheader'=>'Pengaturan');
		$data['view'] = "user/role_setting_form";
		$this->load->view('main/utama',$data);
	}

	public function simpan_datarole(){
		$pilih = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		if ($pilih != ""){
			$del = $this->db->delete('tbl_access_menu', array('idusergroup'=>$role_id));
			if($del){
				$data = array();
				foreach ($pilih as $k => $v) {
					$data[$k]['tbl_menu_id']       	= $v;
					$data[$k]['idusergroup']   = $role_id;
				}

				$query = $this->Muser->insertData('tbl_access_menu',$data);
				$res = !$query ? 0 : 1;
				echo $res;
			}
			
		}else{
			$query = $this->db->delete('tbl_access_menu', array('idusergroup'=>$role_id));
			$res = !$query ? 0 : 1;
			echo $res;
		}

	}

	public function create_user(){
		$data['acak'] = md5(date('H:i:s'));
		$data['sts'] = "add";
		$data['group'] = $this->db->get('t_user_group')->result_array();
		// print_r($data);exit;
		$this->load->view('user/user_form',$data);
	}

	public function edit_user($id){
		$check_id = $this->db->get_where('t_user', ['iduser' => $id])->row_array();
		if($check_id){
			$data['acak'] = md5(date('H:i:s'));
			$data['sts'] = "edit";
			$data['group'] = $this->db->get('t_user_group')->result_array();
			$data['data_user'] = $check_id;
			$data['pass'] =  $check_id['password'];
            // echo '<pre>'; print_r($data);exit;
			$this->load->view('user/user_form',$data);
		}else{
			redirect(site_url('user'));
		}
	}


	public function simpan_user(){
		$this->form_validation->set_rules('idusergroup', 'User Group', 'required');
		// $this->form_validation->set_rules('nmuser', 'nmuser', 'required');
		$pass = $this->input->post('password');
		$user = $this->input->post('nmuser');
		if ($this->input->post('sts') == 'add') {
			$this->form_validation->set_rules(
		        'nmuser', 'Username',
		        'required|min_length[6]|max_length[12]|is_unique[t_user.nmuser]',
				        array(
				                'required'      => 'You have not provided %s.',
				                'is_unique'     => 'This %s already exists.'
				        )
				);
			$this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
			$number 	= preg_match('@[0-9]@', $pass);
		  	$uppercase 	= preg_match('@[A-Z]@', $pass);
		  	$lowercase 	= preg_match('@[a-z]@', $pass);
		  	$specialChars = preg_match('@[^\w]@', $pass);
		  	$containuser = preg_match("/\b{$user}\b/i", $pass);

		  	$sts = 0;
		  	if($containuser) {
		  		$msg = "Kata sandi tidak mengandung nama pengguna";
		  		$sts=1;
		  	}elseif(!$number) {
		  		$msg = "Kata sandi harus mengandung setidaknya satu nomor";
		  		$sts=1;
		  	}else if(!$uppercase) {
		  		$msg = "Kata sandi harus terdiri dari satu huruf kapital.";
		  		$sts=1;
		  	}else if(!$lowercase) {
		  		$msg = "Kata sandi harus terdiri dari satu huruf kecil.";
		  		$sts=1;
		  	}else if(!$specialChars) {
		  		$msg = "Kata sandi harus terdiri dari satu karakter spesial.";
		  		$sts=1;
			} else {
				$msg = "Password must one special character.";
			    $sts = 0;
			}
		}else{
			$this->form_validation->set_rules(
	        'nmuser', 'Username',
	        'required|min_length[6]|max_length[12]',
			        array(
			                'required'      => 'You have not provided %s.',
			                'is_unique'     => 'This %s already exists.'
			        )
			);
			$sts = 0;
			if ($pass <> '') {
				$this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
				$number 	= preg_match('@[0-9]@', $pass);
			  	$uppercase 	= preg_match('@[A-Z]@', $pass);
			  	$lowercase 	= preg_match('@[a-z]@', $pass);
			  	$specialChars = preg_match('@[^\w]@', $pass);
			  	$containuser = preg_match("/\b{$user}\b/i", $pass);

			  	
			  	if($containuser) {
			  		$msg = "Kata sandi tidak mengandung nama pengguna";
			  		$sts=1;
			  	}elseif(!$number) {
			  		$msg = "Kata sandi harus mengandung setidaknya satu nomor";
			  		$sts=1;
			  	}else if(!$uppercase) {
			  		$msg = "Kata sandi harus terdiri dari satu huruf kapital.";
			  		$sts=1;
			  	}else if(!$lowercase) {
			  		$msg = "Kata sandi harus terdiri dari satu huruf kecil.";
			  		$sts=1;
			  	}else if(!$specialChars) {
			  		$msg = "Kata sandi harus terdiri dari satu karakter spesial.";
			  		$sts=1;
				} else {
					$msg = "Password must one special character.";
				    $sts = 0;
				}
			}
		}
		// $this->form_validation->set_rules('iduser', 'iduser', 'required');
		
		$data['nama_lengkap'] 		= escape($this->input->post('nama_lengkap'));
		$data['idusergroup'] 		= escape($this->input->post('idusergroup'));
		$data['nmuser'] 			= escape($this->input->post('nmuser'));
		// $data['password'] 			= escape(md5($this->input->post('password')));
		$data['sts'] 				= escape($this->input->post('sts'));
		$data['iduser'] 			= escape($this->input->post('iduser'));

		if ($pass == "") {
			$data['password'] 	= $this->input->post('password_lama');
		}else{
			
			$data['password'] 	= password_hash($this->input->post('password'), PASSWORD_BCRYPT);
		}

		

		if ($data['idusergroup'] == 1) {
			$data['level'] = 'DJA';
		}else if ($data['idusergroup'] == 2) {
			$data['level'] = 'TASPEN';
		}else if ($data['idusergroup'] == 3) {
			$data['level'] = 'ASABRI';
		}else{
			$data['level'] = 'DJA';
		}
		
		if ($this->form_validation->run() != FALSE) {
			if ($data['sts'] == "add") {
				unset($data['iduser']);
				$data['iduser'] 			= $this->Muser->get_new_id('t_user',$data['idusergroup']);
				if ($sts == 0) {
					unset($data['sts']);
					$query = $this->Muser->insert_user('t_user',$data);
					$res = !$query ? 0 : 1 ;
					echo $res;
				}else{
					echo json_encode(['error' =>$msg]);
				}
			}elseif ($data['sts'] == "edit" && $data['iduser'] != ""){
				$check_id = $this->db->get_where('t_user', ['iduser' => $data['iduser']])->row_array();
				// print_r($check_id);exit;

				if($check_id && $sts == 0){
					unset($data['iduser']);
					unset($data['sts']);
					$query = $this->Muser->updateData('t_user', $data, $check_id['iduser']);
					$res = !$query ? 0 : 1 ;
					echo $res;
				}else{
					echo json_encode(['error' =>$msg]);
				}
			}
		}else{
			$error = validation_errors();

			echo json_encode(['error' =>$error]);
		}
	}


	public function hapus_user(){
		$where = $this->input->post('where');
		$query = $this->Muser->deleteData('t_user', $where);
		$res = !$query ? 0 : 1;
		echo $res;
	}


	public function create_group(){
		$data['sts'] = "add";
		$data['acak'] = md5(date('H:i:s'));
		$this->load->view('user/group_form',$data);
	}

	public function edit_group($id){
		$check_id = $this->db->get_where('t_user_group', ['idusergroup' => $id])->row_array();
		if($check_id){

			$data['sts'] = "edit";
			$data['data_group'] = $check_id;
			$data['acak'] = md5(date('H:i:s'));
            // echo '<pre>'; print_r($data);exit;
			$this->load->view('user/group_form',$data);
		}else{
			redirect(site_url('user'));
		}
	}


	public function simpan_group(){
		$this->form_validation->set_rules('nmusergroup', 'User Group', 'required');

		$data['nmusergroup'] 		= escape($this->input->post('nmusergroup'));
		$data['sts'] 				= escape($this->input->post('sts'));
		$data['idusergroup'] 		= escape($this->input->post('idusergroup'));

		// print_r($data);exit;
		if ($this->form_validation->run() != FALSE) {
			if ($data['sts'] == "add" && $data['idusergroup'] == "") {
				unset($data['idusergroup']);
				unset($data['sts']);
				$query = $this->Muser->insert_user('t_user_group',$data);
				$res = !$query ? 0 : 1 ;
				echo $res;

			}elseif ($data['sts'] == "edit" && $data['idusergroup'] != ""){
				$check_id = $this->db->get_where('t_user_group', ['idusergroup' => $data['idusergroup']])->row_array();
				if($check_id){
					unset($data['idusergroup']);
					unset($data['sts']);
					$query = $this->Muser->updateDataGroup('t_user_group', $data, $check_id['idusergroup']);
					$res = !$query ? 0 : 1 ;
					echo $res;
				}
			}
		}else{
			$error = validation_errors();
			echo json_encode(['error' =>$error]);
		}
		
	}


	public function hapus_group(){
		$where = $this->input->post('where');
		$query = $this->Muser->deleteData('t_user_group', $where);
		$res = !$query ? 0 : 1;
		echo $res;
	}


}
