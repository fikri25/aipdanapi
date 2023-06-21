<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->library('botdetect/BotDetectCaptcha', array('captchaConfig' => 'ExampleCaptcha'));
	}

    function index() {

        $isLoggedIn = $this->session->userdata('isLoggedIn');
        $level = $this->session->userdata('level');

        if($isLoggedIn) {
            // redirect('/home');
            redirect('bulanan/lihat_laporan_bulan');
        }
        else {
            $this->show_login(false);
        }
    }

    function login_user() {
        
        $nmuser = escape($this->input->post('nmuser'));
        $user = escape($this->input->post('nmuser'));
        $password = escape($this->input->post('password'));
        $pass = escape($this->input->post('password'));
        $code = escape($this->input->post('CaptchaCode'));


        // TAMBAHAN

        $this->form_validation->set_rules(
                'nmuser', 'Username',
                'required|min_length[6]|max_length[12]',
                        array(
                                'required'      => 'You have not provided %s.',
                        )
                );
            $this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
            $number     = preg_match('@[0-9]@', $pass);
            $uppercase  = preg_match('@[A-Z]@', $pass);
            $lowercase  = preg_match('@[a-z]@', $pass);
            $specialChars = preg_match('@[^\w]@', $pass);
            $containuser = preg_match("/\b{$nmuser}\b/i", $pass);

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
            if ($this->form_validation->run() != FALSE) {
            //set SESSION tahun
                if ($sts == 0) {
                    $tahun= array('tahun'=>$this->input->post('tahun'));
                    $this->session->set_userdata($tahun);
                // var_dump($iduser);exit;
                // Check User ID dan Password is null ?
                    if( $nmuser && $password && $tahun) {
                        if ($this->login_model->validate_user($nmuser, $password)) {
                            if ($this->botdetectcaptcha->Validate($code)) {
                                $this->index();
                            }else{
                                $this->session->set_flashdata('sukses','Captcha yang anda masukan salah');
                                redirect(base_url('login/show_login'));    
                            }
                        }else{
                            $this->session->set_flashdata('sukses','Nama Pengguna atau Kata Sandi yang anda masukan salah');
                            redirect(base_url('login/show_login'));    
                        }
                    } else {
                        $this->session->set_flashdata('sukses','Isian Form Login Belum Lengkap');
                        redirect(base_url('login/show_login'));
                    }
                }else{
                    $this->session->set_flashdata('sukses',$msg);
                    redirect(base_url('login/show_login'));
                }

            }else{
                $error = validation_errors();
                $this->session->set_flashdata('sukses',$error);
                redirect(base_url('login/show_login'));
            }
    }

    public function change_password(){
        $sts = 0;
        $nmuser     = $_POST['nmuser_change'];
        $old_pw     = $_POST['c_password'];
        $new_pw     = $_POST['n_password'];
        $con_pw     = $_POST['n2_password'];
        $old_pw_hash = password_hash($old_pw, PASSWORD_BCRYPT);
        $cekUser = $this->db->get_where('t_user', array('nmuser' => $nmuser))->row_array();
       if(count($cekUser)>0){
            $validPassword = password_verify($old_pw, $cekUser['password']);
            if ($validPassword) {
                if (strlen($new_pw)>=8) {
                    $number     = preg_match('@[0-9]@', $new_pw);
                    $uppercase  = preg_match('@[A-Z]@', $new_pw);
                    $lowercase  = preg_match('@[a-z]@', $new_pw);
                    $specialChars = preg_match('@[^\w]@', $new_pw);
                    $containuser = preg_match("/\b{$nmuser}\b/i", $new_pw);

                    
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
                        if ($new_pw == $con_pw) {
                            $data = array(
                                'password' => password_hash($new_pw, PASSWORD_BCRYPT)
                            );
                            $this->db->where(array('nmuser'=>$nmuser));
                            $this->db->update('t_user',$data);
                            $result = $this->db->affected_rows();
                            $msg = 'Password Diperbarui!';
                            $sts = 0;
                        }else{
                            $msg = 'Kata Sandi Baru dan Konfirmasi kata sandi harus sama';
                            $sts = 1;
                        }
                    }
                }else{
                    $msg = 'Kata sandi harus > 8 karakter!';
                    $sts = 1;
                }
            }else{
                $msg = 'Kata Sandi Lama Salah!';
                $sts = 1;
            }
        }else{
            $msg = 'Nama Pengguna Salah!';
            $sts = 1;
        }

        $data['msg']=$msg;
        $data['sts']=$sts;

        
        
        echo json_encode($data);
    
    }

    function show_login( $show_error = false ) {
        // load the BotDetect Captcha library and set its parameter
          $this->load->library('botdetect/BotDetectCaptcha', array(
            'captchaConfig' => 'ExampleCaptcha'
          ));

        // make Captcha Html accessible to View code
        $data['captchaHtml'] = $this->botdetectcaptcha->Html();

        $data['error'] = $show_error;
		$this->load->view('main/utama_login', $data);
    }

    function logout_user() {
      $this->session->sess_destroy();
      $this->index();
    }

    function showphpinfo() {
        echo phpinfo();
    }


}
