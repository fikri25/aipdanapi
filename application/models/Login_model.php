<?php


class Login_model extends CI_Model {
    function __construct(){
      parent::__construct();
    }

    var $details;

    function validate_user($nmuser,$password) {

        $this->tahun = $this->session->userdata('tahun');
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->where('nmuser',$nmuser);
        // $this->db->where('password',md5($password));
        $query = $this->db->get();

        $login = $query->result();
        
        if ( is_array($login) && count($login) == 1 ) {
            $result = $query->row_array();
            
            if(password_verify($password, $result['password'])){
                $this->details = $login[0];
                $this->set_session();
                return true;
            }else{
                return false;
            } 
        }
        return false;

    }

    function validate_api($nmuser,$password) {

        $this->tahun = $this->session->userdata('tahun');
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->where('nmuser',$nmuser);
        // $this->db->where('password',md5($password));
        $query = $this->db->get();

        $login = $query->result();
        
        if ( is_array($login) && count($login) == 1 ) {
            $result = $query->row_array();

            if(password_verify($password, $result['password'])){
                
                $ret['sts'] = 'true';
                $ret['data'] = $login[0];
                return $ret;
            }else{
                $ret['sts'] = 'false';
                $ret['pesan'] = 'Password Salah';
                return $ret;
            } 
        }else{
            $ret['sts'] = 'false';
            $ret['pesan'] = 'Username Tidak Terdaftar';
            return $ret;
        }
        

    }

    function set_session() {
		// $arlevel  = array('level','Admin','User','Non User','Manager');
		// $arwenang = array('Admin','Read Write','Read','None','Manager');
		// print_r($arlevel);exit;
        $this->session->set_userdata( array(
                'iduser' => $this->details->iduser,
                'nmuser' => $this->details->nmuser,
                'level' => $this->details->level,
                'idusergroup' => $this->details->idusergroup,
                'nama_lengkap' => $this->details->nama_lengkap,
                'isLoggedIn' => true
            )
        );
    }


    function getdata($type="", $balikan="", $p1="", $p2="", $p3=""){
        $where = "";
        $array = array();
        
        switch($type){
            case "data_login":
                $sql = "
                    SELECT *
                    FROM t_user
                    WHERE nmuser = '".$p1."'
                ";
            break;
        }
        
        if($balikan == 'json'){
            return $this->lib->json_grid($sql,$type);
        }elseif($balikan == 'row_array'){
            return $this->db->query($sql)->row_array();
        }elseif($balikan == 'result'){
            return $this->db->query($sql)->result();
        }elseif($balikan == 'result_array'){
            return $this->db->query($sql)->result_array();
        }elseif($balikan == 'json_encode'){
            $data = $this->db->query($sql)->result_array(); 
            return json_encode($data);
        }elseif($balikan == 'variable'){
            return $array;
        }
        
    }

}
