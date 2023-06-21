
<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Aset_investasi extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config = 'rest');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('api_bulanan_model/aset_investasi_model','modelnya');
        $this->load->library('Authorization_Token');  
        $this->load->library('form_validation');  
        // $this->methods['index_post']['limit'] = 12;
        // $this->methods['index_delete']['limit'] = 12;
    }
    public function index_get()
    {
        $headers = $this->input->request_headers(); 
        if (isset($headers['Authorization'])) {

          $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
          if ($decodedToken['status']) {

              // start
            if (isset($headers['bulan']) && isset($headers['tahun'])) {
              $bulan = $headers['bulan']==null?null:$headers['bulan'];  
              $tahun = $headers['tahun']==null?null:$headers['tahun'];  
              // get from token
              $user = $decodedToken['data']->id_aktif;
              $res = $this->modelnya->get($bulan,$tahun,$user);

              if ($res) {
                $this->response([
                    'status'=>true,
                    'data'=>$res
                    ],REST_Controller::HTTP_OK);
                
              }else{
                $this->response([
                    'status'=>false,
                    'message'=>'Data Not Found'
                    ],REST_Controller::HTTP_NOT_FOUND);
              }

            }else{
              $this->response([
              'status'=>false,
              'message'=>'Request Gagal'
              ],REST_Controller::HTTP_BAD_REQUEST);
            }
            // end
            
          }else{
            $this->response($decodedToken); 
          }
        }else{
          $this->response(array('status'=> false, 'msg'=> 'Please Enter Your Authorization Token'));  
        }
        

      }

    public function index_delete()
    {
        $headers = $this->input->request_headers(); 
        if (isset($headers['Authorization'])) {

          $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
          if ($decodedToken['status']) {

              // start
            if (isset($headers['bulan']) && isset($headers['tahun'])) {
              $bulan = $headers['bulan']==null?null:$headers['bulan'];  
              $tahun = $headers['tahun']==null?null:$headers['tahun'];
              // get from token
              $user = $decodedToken['data']->id_aktif;
              $res = $this->modelnya->delete($bulan,$tahun,$user);
              if ($res>0) {
                $this->response([
                  'status'=>true,
                  'count'=>$res,
                  'message'=>'Berhasil Menghapus Data'
                  ],REST_Controller::HTTP_OK);
              }else{
                $this->response([
                    'status'=>false,
                    'message'=>'Gagal Menghapus Data'
                    ],REST_Controller::HTTP_BAD_REQUEST);
              }

            }else{
              $this->response([
              'status'=>false,
              'message'=>'Request Gagal'
              ],REST_Controller::HTTP_BAD_REQUEST);
            }
            // end
            
          }else{
            $this->response($decodedToken); 
          }
        }else{
          $this->response(array('status'=> false, 'msg'=> 'Please Enter Your Authorization Token'));  
        }

      }



      public function index_post() {
        $headers = $this->input->request_headers(); 
        if (isset($headers['Authorization'])) {

          $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
          if ($decodedToken['status']) {
            $data = (array)json_decode(file_get_contents('php://input'));
            $post = array();

            foreach($data as $k=>$v){
              foreach ($v as $j => $y) {
                if($y!=""){
                  $post[$k][$j] = escape($y);
                }else{
                  $post[$k][$j] = null;
                }
              }
            }
            $insert = $this->modelnya->insert($post);
            if ($insert['error']===false) {
              $this->response([
                'status'=>true,
                'message'=> $insert['msg']
                ],REST_Controller::HTTP_CREATED);
            }else{
              $this->response([
                  'status'=>false,
                  'message'=>$insert['msg']
                  ],REST_Controller::HTTP_BAD_REQUEST);
            }

          }else{
            $this->response($decodedToken); 
          }
        }else{
          $this->response(array('status'=> false, 'msg'=> 'Please Enter Your Authorization Token'));  
        }


        
    }

}