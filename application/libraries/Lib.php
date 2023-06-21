<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	LIBRARY CIPTAAN JINGGA LINTAS IMAJI
	KONTEN LIBRARY :
	- Upload File
	- Upload File Multiple
	- RandomString
	- CutString
	- Kirim Email
	- Konversi Bulan
	- Fillcombo
	- Json Datagrid
	
*/
class Lib {
	public function __construct(){
		
	}
	
	//class asset manager
	function assetsmanager($type,$p1){
		$assets = "";
		$ci =& get_instance();
		$base_url = $ci->config->item('base_url');
		
		switch($type){
			case "js":
				
				switch($p1){
					case "login":
						$arrayjs = array(
							'__assets/template/bower_components/jquery/dist/jquery.min.js',
							'__assets/template/bower_components/bootstrap/dist/js/bootstrap.min.js',
						);
					break;
					case "main":
						$arrayjs = array(
							'__assets/template/bower_components/jquery/dist/jquery.min.js',
							'__assets/template/bower_components/bootstrap/dist/js/bootstrap.min.js',
							'__assets/template/bower_components/fastclick/lib/fastclick.js',
							'__assets/pluginsall/easyui/jquery.easyui.min.js',
							'__assets/pluginsall/jquery-validation/dist/jquery.validate.js',
							'__assets/pluginsall/maskmoney/jquery.maskMoney.js',
							'__assets/pluginsall/ckeditor/ckeditor.js',
							'__assets/template/dist/js/adminlte.min.js',
							'__assets/template/dist/js/autoNumeric.js',
							'__assets/template/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
							'__assets/template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
							'__assets/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
							'__assets/template/bower_components/moment/moment.js',
							'__assets/template/bower_components/select2/dist/js/select2.full.min.js',
							'__assets/pluginsall/highcharts/highcharts.js',
							'__assets/pluginsall/highcharts/exporting.js',
							'__assets/template/dist/js/typeahead.js',
							'__assets/template/dist/js/blockui.js',
							'__assets/template/dist/js/loading-overlay.js',
							'__assets/template/dist/js/mask-input.js',
							'__assets/template/dist/js/fungsi.js',
							'__assets/template/dist/js/fungsi-order-management.js',
                            '__assets/template/dist/js/fungsi-finance-management.js',
							'__assets/template/dist/js/fungsi-master.js',
							'__assets/template/dist/js/fungsi-file-management.js',
							'__assets/template/dist/js/fungsi-resepsionis.js',
							'__assets/template/dist/js/fungsi-marketing.js',
							'__assets/pluginsall/leaflet/leaflet.js',
							
						);
					break;
				}
				
				foreach($arrayjs as $k){
					$version = filemtime($k);
					$assets .= "
						<script src='".$base_url.$k."?v=".$version."'></script> 
					";
				}
				
			break;
			case "css":
				
				switch($p1){
					case "login":
						$arraycss = array(
							'__assets/template/bower_components/bootstrap/dist/css/bootstrap.min.css',
							'__assets/template/bower_components/font-awesome/css/font-awesome.min.css',
							'__assets/template/bower_components/Ionicons/css/ionicons.min.css',
							'__assets/template/dist/css/AdminLTE.min.css',
						);
					break;
					case "main":
						$arraycss = array(
							'__assets/template/bower_components/bootstrap/dist/css/bootstrap.min.css',
							'__assets/template/bower_components/font-awesome/css/font-awesome.min.css',
							'__assets/template/bower_components/Ionicons/css/ionicons.min.css',
							'__assets/template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
							'__assets/pluginsall/easyui/themes/metro-gray/easyui.css',
							'__assets/template/bower_components/select2/dist/css/select2.min.css',
							'__assets/template/dist/css/AdminLTE.min.css',
							'__assets/template/dist/css/skins/_all-skins.min.css',
							'__assets/pluginsall/leaflet/leaflet.css',
						);
					break;
				}
				
				foreach($arraycss as $k){
					$version = filemtime($k);
					$assets .= "
						<link href='".$base_url.$k."?v=".$version."' rel='stylesheet'>
					";
				}
				
			break;
		}
		
		return $assets;
	}
	//End class asset manager
	
	
	//class Upload File Version 1.0 - Beta
	function uploadnong($upload_path="", $object="", $file=""){
		//$upload_path = "./__repository/".$folder."/";
		
		$ext = explode('.',$_FILES[$object]['name']);
		$exttemp = sizeof($ext) - 1;
		$extension = $ext[$exttemp];
		
		$filename =  $file.'.'.$extension;
		
		$files = $_FILES[$object]['name'];
		$tmp  = $_FILES[$object]['tmp_name'];
		if(!file_exists($upload_path))mkdir($upload_path, 0777, true);
		if(file_exists($upload_path.$filename)){
			unlink($upload_path.$filename);
			$uploadfile = $upload_path.$filename;
		}else{
			$uploadfile = $upload_path.$filename;
		} 
		
		move_uploaded_file($tmp, $uploadfile);
		if (!chmod($uploadfile, 0775)) {
			echo "Gagal mengupload file";
			exit;
		}
		
		return $filename;
	}
	// end class Upload File
	
	//class Upload File Multiple Version 1.0 - Beta
	function uploadmultiplenong($upload_path="", $object="", $file="", $idx=""){
		$ext = explode('.',$_FILES[$object]['name'][$idx]);
		$exttemp = sizeof($ext) - 1;
		$extension = $ext[$exttemp];
		
		$filename =  $file.'.'.$extension;
		
		$files = $_FILES[$object]['name'][$idx];
		$tmp  = $_FILES[$object]['tmp_name'][$idx];
		if(!file_exists($upload_path))mkdir($upload_path, 0777, true);
		if(file_exists($upload_path.$filename)){
			unlink($upload_path.$filename);
			$uploadfile = $upload_path.$filename;
		}else{
			$uploadfile = $upload_path.$filename;
		} 
		
		move_uploaded_file($tmp, $uploadfile);
		if (!chmod($uploadfile, 0775)) {
			echo "Gagal mengupload file";
			exit;
		}
		
		return $filename;
	}
	//end Class Upload File
	
	//class Random String Version 1.0
	function randomString($length,$parameter="") {
        $str = "";
		$rangehuruf = range('A','Z');
		$rangeangka = range('0','9');
		if($parameter == 'angka'){
			$characters = array_merge($rangeangka);
		}elseif($parameter == 'huruf'){
			$characters = array_merge($rangehuruf);
		}else{
			$characters = array_merge($rangehuruf, $rangeangka);
		}
         $max = count($characters) - 1;
         for ($i = 0; $i < $length; $i++) {
              $rand = mt_rand(0, $max);
              $str .= $characters[$rand];
         }
         return $str;
    }
	//end Class Random String
	
	// Numbering Format
	function numbering_format($var){
		return number_format($var, 0,",",".");
	}
	// End Numbering Format
	
	//Class CutString
	function cutstring($text, $length) {
		//$isi_teks = htmlentities(strip_tags($text));
		$isi = substr($text, 0,$length);
		//$isi = substr($isi_teks, 0,strrpos($isi," "));
		$isi = $isi.' ...';
		return $isi;
	}
	//end Class CutString
	
	//Class Kirim Email
	function kirimemail($type="", $email="", $p1="", $p2="", $p3=""){
		$ci =& get_instance();
		
		$ci->load->library('email');
		$html = "";
		$subject = "";
		switch($type){
			case "email_sent_opr":
				$ci->nsmarty->assign('data', $p1);
				$html = $ci->nsmarty->fetch('backend/modul/email/email_sent_opr.html');
				$subject = "EMAIL NOTIFIKASI CONTACT CENTER";
			break;
			case "email_test":
				$html = "test email bro";
				$subject = "Email Test VPTI Contact Center";
			break;
		}
				
		$config = array(
			"protocol"	=>"smtp"
			,"mailtype" => "html"
			,"smtp_host" => "ssl://mbox.scisi.com"
			,"smtp_user" => "notifikasi@scisi.com"
			,"smtp_pass" => "Sc1s1kso"
			,"smtp_port" => "465",
			'charset' => 'utf-8',
            'wordwrap' => TRUE,
		);
		
		
		$ci->email->initialize($config);
		$ci->email->from("ticketcc@scisi.com", "VPTI - Contact Center Notifikasi");
		
		if(is_array($email)){
			$ci->email->to(implode(', ', $email));
		}else{
			$ci->email->to($email);
		}
		
		if($p2 != ""){
			$ci->email->cc($p2);
		}
		$ci->email->cc("a.muzaki@scisi.com");
		
		$ci->email->subject($subject);
		$ci->email->message($html);
		$ci->email->set_newline("\r\n");
		if($ci->email->send())
			//echo "<h3> SUKSES EMAIL ke $email </h3>";
			return 1;
		else
			//echo $this->email->print_debugger();
			return $ci->email->print_debugger();
	}	
	//End Class KirimEmail a.muzaki@scisi.com
	
	//Class Konversi Bulan
	function konversi_bulan($bln,$type=""){
		if($type == 'fullbulan'){
			switch($bln){
				case 1:$bulan='Januari';break;
				case 2:$bulan='Februari';break;
				case 3:$bulan='Maret';break;
				case 4:$bulan='April';break;
				case 5:$bulan='Mei';break;
				case 6:$bulan='Juni';break;
				case 7:$bulan='Juli';break;
				case 8:$bulan='Agustus';break;
				case 9:$bulan='September';break;
				case 10:$bulan='Oktober';break;
				case 11:$bulan='November';break;
				case 12:$bulan='Desember';break;
			}
		}else{
			switch($bln){
				case 1:$bulan='Jan';break;
				case 2:$bulan='Feb';break;
				case 3:$bulan='Mar';break;
				case 4:$bulan='Apr';break;
				case 5:$bulan='Mei';break;
				case 6:$bulan='Jun';break;
				case 7:$bulan='Jul';break;
				case 8:$bulan='Agst';break;
				case 9:$bulan='Sept';break;
				case 10:$bulan='Okt';break;
				case 11:$bulan='Nov';break;
				case 12:$bulan='Des';break;
			}
		}
		return $bulan;
	}
	//End Class Konversi Bulan
	
	//Class Konversi Tanggal
	function konversi_tgl($date){
		$ci =& get_instance();
		$ci->load->helper('terbilang');
		$data=array();
		$timestamp = strtotime($date);
		$day = date('D', $timestamp);
		$day_angka = (int)date('d', $timestamp);
		$month = date('m', $timestamp);
		$years = date('Y', $timestamp);
		switch($day){
			case "Mon":$data['hari']='Senin';break;
			case "Tue":$data['hari']='Selasa';break;
			case "Wed":$data['hari']='Rabu';break;
			case "Thu":$data['hari']='Kamis';break;
			case "Fri":$data['hari']='Jumat';break;
			case "Sat":$data['hari']='Sabtu';break;
			case "Sun":$data['hari']='Minggu';break;
		}
		switch($month){
			case "01":$data['bulan']='Januari';break;	
			case "02":$data['bulan']='Februari';break;	
			case "03":$data['bulan']='Maret';break;	
			case "04":$data['bulan']='April';break;	
			case "05":$data['bulan']='Mei';break;	
			case "06":$data['bulan']='Juni';break;	
			case "07":$data['bulan']='Juli';break;	
			case "08":$data['bulan']='Agustus';break;	
			case "09":$data['bulan']='September';break;	
			case "10":$data['bulan']='Oktober';break;	
			case "11":$data['bulan']='November';break;	
			case "12":$data['bulan']='Desember';break;	
		}
		$data['tahun']=ucwords(number_to_words($years));
		$data['tgl_text']=ucwords(number_to_words($day_angka));
		return $data;
	}
	//End Class Konversi Tanggal
	
	//Class Fillcombo
	function fillcombo($type="", $balikan="", $p1="", $p2="", $p3="", $p4=""){
		$ci =& get_instance();
		$ci->load->model('aset_investasi_model');
		
		$v = $ci->input->post('v');
		if($v != ""){
			$selTxt = $v;
		}else{
			$selTxt = $p1;
		}
		
		$optTemp = '<option value=""> -- Pilih -- </option>';
        if($type=='order'){
            $optTemp .= '<option value="#1">#ALL</option>';	
        }
		switch($type){
			case "data_pihak":
			case "sub_reksadana":
			case "cabang":
			case "combo_beban_investasi":
				$ci->load->model('aset_investasi_model');
				$data = $ci->aset_investasi_model->get_combo($type, $p1, $p2);
			break;
			case "get_arus_kas":
				$ci->load->model('arus_kas_model');
				$data = $ci->arus_kas_model->get_combo($type, $p1, $p2);
			break;

			case "mst_cabang":
			case "data_jenis":
				$ci->load->model('aspek_operasional_model');
				$data = $ci->aspek_operasional_model->get_combo($type, $p1, $p2);
			break;
			case "jenis_klaim":
			case "mst_cabang_ob":
				$ci->load->model('operasional_belanja_model');
				$data = $ci->operasional_belanja_model->get_combo($type, $p1, $p2);
			break;
			case "data_jenis_invest":
			case "data_mst_pihak":
				$ci->load->model('master_data_model');
				$data = $ci->master_data_model->get_combo($type, $p1, $p2);
			break;

            case "sumber":
				$data = array(
					'0' => array('id'=>'10101020001','txt'=>'Bank Mandiri'),
                    '1' => array('id'=>'10101020002','txt'=>'Bank BCA'),
                    '2' => array('id'=>'10101020003','txt'=>'Bank BRI'),
                    '3' => array('id'=>'10101020004','txt'=>'Bank BNI'),
                    '4' => array('id'=>'10101020005','txt'=>'Bank Permata'),
                    '5' => array('id'=>'10101020006','txt'=>'Bank Maybank'),
					'6' => array('id'=>'10101010003','txt'=>'Kas Pelaksana'),
                    '7' => array('id'=>'10101010002','txt'=>'Kas Kasir'),
				);
            break;
     		
     		case "user":
				$data = array(
					'0' => array('id'=>'TSN002','txt'=>'TASPEN'),
                    '1' => array('id'=>'ASB003','txt'=>'ASABRI'),
                    
				);
            break;
			
			case "tanggal" :
				$data = $this->arraydate('tanggal');
				$optTemp = '<option value=""> -- Tanggal -- </option>';
			break;
			case "bulan" :
				$data = $this->arraydate('bulan');
				$optTemp = '<option value=""> -- Bulan -- </option>';
			break;
			case "tahun" :
				$data = $this->arraydate('tahun');
				$optTemp = '<option value=""> -- Tahun -- </option>';
			break;
			
			case "email_notif":
				$data = array();
				$optTemp = '<option value=""> -- Choose -- </option>';
			break;
			
			default:
				$data = $ci->mbackend->get_combo($type, $p1, $p2);
			break;
		}
		
		if($data){
			foreach($data as $k=>$v){
				if($selTxt == $v['id']){
					if($type=='layanan_satuans'){
						$optTemp .= "<option value='".$v['id']."' hpp_super_express='".$v['hpp_super_express']."'  hpp_express='".$v['hpp_express']."'  hpp_regular='".$v['hpp_regular']."' harga_jual_super_express='".$v['harga_jual_super_express']."' harga_jual_express='".$v['harga_jual_express']."' harga_jual_regular='".$v['harga_jual_regular']."' >".strtoupper($v['txt'])."</option>";
					}else{
						$optTemp .= '<option selected value="'.$v['id'].'">'.$v['txt'].'</option>';
					}
				}else{ 
					if($type=='layanan_satuans'){
						$optTemp .= "<option value='".$v['id']."' hpp_super_express='".$v['hpp_super_express']."'  hpp_express='".$v['hpp_express']."'  hpp_regular='".$v['hpp_regular']."' harga_jual_super_express='".$v['harga_jual_super_express']."' harga_jual_express='".$v['harga_jual_express']."' harga_jual_regular='".$v['harga_jual_regular']."' >".strtoupper($v['txt'])."</option>";
					}else{
						$optTemp .= '<option value="'.$v['id'].'">'.$v['txt'].'</option>';	
					}
				}
			}
		}
		
		if($balikan == 'return'){
			return $optTemp;
		}elseif($balikan == 'echo'){
			echo $optTemp;
		}
		
	}
	//End Class Fillcombo

	//Function Json Grid Datatable
	function json_datatable($sql,$type="",$table="",$koding=""){
		$ci =& get_instance();
		$ci->load->database();
		
		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length']; // Rows display per page
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = $_POST['search']['value']; // Search value
		
		$total_data = $ci->db->query($sql)->num_rows();
		
		$totalRecords = $total_data;
		$totalRecordwithFilter = $total_data;
		
		$sql .= " LIMIT ".$rowperpage." OFFSET ".$row;
		
		$data = $ci->db->query($sql)->result_array();  
		
		$response = array(
		  "draw" => intval($draw),
		  "iTotalRecords" => $totalRecordwithFilter,
		  "iTotalDisplayRecords" => $totalRecords,
		  "aaData" => $data,
		);
		
		return json_encode($response);
	}
	//EndFunction Json Grid Datatable
	
	//Function Json Grid Tree
	function json_grid_tree($sql, $type="", $table=""){
		$ci =& get_instance();
		$ci->load->database();
		$page = (integer) (($ci->input->post('page')) ? $ci->input->post('page') : 0);
		$limit = (integer) (($ci->input->post('rows')) ? $ci->input->post('rows') : 0);
		
		$count = $ci->db->query($sql)->num_rows();
		
		if($page != 0 && $limit != 0){
			if( $count >0 ) { $total_pages = ceil($count/$limit); } else { $total_pages = 0; } 
			if ($page > $total_pages) $page = $total_pages; 
		}
		
		$dbdriver = $ci->db->dbdriver;
		
		if($dbdriver == "mysql" || $dbdriver == "mysqli"){
			//MYSQL
			$start = $limit*$page - $limit; // do not put $limit*($page - 1)
			if($start<0) $start=0;
			$sql = $sql . " LIMIT $start,$limit";			
			$data = $ci->db->query($sql)->result_array();  
		}
		
		if($dbdriver == "postgre" || $dbdriver == 'sqlsrv' || $dbdriver == 'mssql'){
			//POSTGRESSS
			if($limit != 0){
				$end = $page * $limit; 
				$start = $end - $limit;
				if($start < 0) $start = 0;
				/*
				$sql = "
					SELECT * FROM (
						".$sql."
					) AS X WHERE X.rowID BETWEEN $start AND $end
				";
				*/	
				
				$sql .= "
					LIMIT $limit OFFSET $start
				";
				
			}
		}
		
		//if($type == 'layanan'){ $sql .= " ORDER BY X.id DESC"; }
		//if($type == 'dokumen'){ $sql .= " ORDER BY X.id DESC"; }
		//echo $sql;exit;
		
		$data = $ci->db->query($sql)->result_array();  
		
		//echo $count;exit;
		
		if($data){
		   $responce = new stdClass();
		   $responce->rows = $data;
		   $responce->total = $count;
		}else{ 
		   $responce = new stdClass();
		   $responce->rows = array();
		   $responce->total = 0;
		}
		
		//print_r($responce);exit;
		
		return $responce;
	}
	//End Function Json Grid Tree
	
	//Function Json Grid
	function json_grid($sql, $type="",$table="",$koding=""){
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->model((array('mbackend')));
		$footer = false;
		$arr_foot = array();
		
		$page = (integer) (($ci->input->post('page')) ? $ci->input->post('page') : 0);
		$limit = (integer) (($ci->input->post('rows')) ? $ci->input->post('rows') : 0);
		
		$count = $ci->db->query($sql)->num_rows();
		
		if($page != 0 && $limit != 0){
			if( $count >0 ) { $total_pages = ceil($count/$limit); } else { $total_pages = 0; } 
			if ($page > $total_pages) $page = $total_pages; 
		}
				
		$dbdriver = $ci->db->dbdriver;
		
		if($dbdriver == "mysql" || $dbdriver == "mysqli"){
			//MYSQL
			$start = $limit*$page - $limit; // do not put $limit*($page - 1)
			if($start<0) $start=0;
			$sql = $sql . " LIMIT $start,$limit";			
			$data = $ci->db->query($sql)->result_array();  
		}
		
		if($dbdriver == "postgre" || $dbdriver == 'sqlsrv' || $dbdriver == 'mssql'){
			//POSTGRESSS
			if($limit != 0){
				$end = $page * $limit; 
				$start = $end - $limit + 1;
				if($start < 0) $start = 0;
				$sql = "
					SELECT * FROM (
						".$sql."
					) AS X WHERE X.rowID BETWEEN $start AND $end
				";	
			}
		}
		
		if($type == 'order'){ $sql .= " ORDER BY X.id DESC"; }
		if($type == 'management_file'){ $sql .= " ORDER BY X.id DESC"; }
		if($type == 'klien'){ $sql .= " ORDER BY X.id DESC"; }
		
		//echo $sql;exit;
		
		$data = $ci->db->query($sql)->result_array();  
		
		if($data){
		   $responce = new stdClass();
		   $responce->rows = $data;
		   $responce->total = $count;
		   
		   if($footer == true){
			   $responce->footer = $arr_foot;
		   }
		   
		   return json_encode($responce);
		}else{ 
		   $responce = new stdClass();
		   $responce->rows = 0;
		   $responce->total = 0;
		   return json_encode($responce);
		} 
	}
	//end Json Grid
	
	//Generate Form Via Field Table
	function generateform($table){
		$ci =& get_instance();
		$ci->load->database();
		
		$field = $ci->db->list_fields($table);
		$arrayform = array();
		$i = 0;
		foreach($field as $k => $v){							
			if($v == 'create_date' || $v == 'create_by'){
				continue;
			}
			
			$label = str_replace('_', ' ', $v);
			$label = strtoupper($label);
			
			if($v == 'id'){
				$arrayform[$k]['tipe'] = "hidden";
			}else{	
				if(strpos($v, 'cl_') !== false){
					$label = str_replace("CL ", "", $label);
					$label = str_replace(" ID", "", $label);
					
					$arrayform[$k]['tipe'] = "combo";
					$arrayform[$k]['ukuran_class'] = "span4";
					$arrayform[$k]['isi_combo'] =  $ci->lib->fillcombo($v, 'return', ($sts_crud == 'edit' ? $data[$y] : "") );
				}elseif(strpos($v, 'tipe_') !== false){
					$arrayform[$k]['tipe'] = "combo";
					$arrayform[$k]['ukuran_class'] = "span4";
					$arrayform[$k]['isi_combo'] =  $ci->lib->fillcombo($v, 'return', ($sts_crud == 'edit' ? $data[$y] : "") );
				}elseif(strpos($v, 'tgl_') !== false){
					$label = str_replace("TGL", "TANGGAL", $label);
					
					$arrayform[$k]['tipe'] = "text";
					$arrayform[$k]['ukuran_class'] = "span2";
				}elseif(strpos($v, 'isi_') !== false){
					$arrayform[$k]['tipe'] = "textarea";
					$arrayform[$k]['ukuran_class'] = "span8";
				}elseif(strpos($v, 'gambar_') !== false){
					$arrayform[$k]['tipe'] = "file";
					$arrayform[$k]['ukuran_class'] = "span8";	
				}else{
					$arrayform[$k]['tipe'] = "text";
					$arrayform[$k]['ukuran_class'] = "span8";
				}
			}
										
			$arrayform[$k]['name'] = $v;
			$arrayform[$k]['label'] = $label;
			$i++;
		}
		
		return $arrayform;
	}
	//End Generate Form Via Field Table
	function uniq_id(){
		$s = strtoupper(md5(uniqid(rand(),true))); 
		//echo $s;
		$guidText = substr($s,0,6);
		return $guidText;
	}
	
	//Class String Sanitizer
	function clean($string, $separator="_") {
		$string = str_replace(' ', $separator, $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', $separator, $string); // Removes special chars.
	}	
	
	//Class ToAscii
	function toAscii($str) {
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
	
		return $clean;
	}
	
	function get_ldap_user($mod="",$user="",$pwd="",$group=""){
		$ci =& get_instance();
		//echo $user.$pwd;
		$res=array();
		$res["msg"]=1;
		$ldapconn = ldap_connect($ci->config->item("ldap_host"),$ci->config->item("ldap_port"));
		ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		if($ldapconn) {
			if($mod=='data_ldap'){
				$ldapbind = @ldap_bind($ldapconn, $ci->config->item("ldap_user"), $ci->config->item("ldap_pwd"));
			}else{
				$ldapbind = ldap_bind($ldapconn, "uid=".$user.",".$ci->config->item("ldap_tree"), $pwd);
			}
			if ($ldapbind) {
				
				$ldap_fields=array("uid","samaccountname","name","primarygroupid","displayname","distinguishedname","cn","description","memberof","userprincipalname");           
				if($mod=='data_ldap'){					
					$result=@ldap_search($ldapconn,'ou=People,dc=pgn-solution,dc=co,dc=id','(uid='.$user.')',$ldap_fields); 
				}else if($mod=='login'){
                    $result=ldap_search($ldapconn,"uid=".$user.",".$ci->config->item("ldap_tree"),"(&(objectCategory=person)(samaccountname=$user))");
				}
				$data=$this->konvert_array($ldapconn,$result);
				$res["data"]=$data; //GAGAL KONEK
			} else {
				//echo "LDAP bind failed...";
				$res["msg"]=3; //GAGAL BIND
			}
		}else{
			$res["msg"]=2; //GAGAL KONEK
		}
		ldap_close($ldapconn);
		return $res;
	}
	function konvert_array($conn,$result){
		$connection = $conn;
		$resultArray = array();
		if ($result){
			$entry = ldap_first_entry($connection, $result);
			while ($entry){
				$row = array();
				$attr = ldap_first_attribute($connection, $entry);
				while ($attr){
					$val = ldap_get_values_len($connection, $entry, $attr);
					if (array_key_exists('count', $val) AND $val['count'] == 1){
						$row[strtolower($attr)] = $val[0];
					}
					else{
						$row[strtolower($attr)] = $val;
					}
					$attr = ldap_next_attribute($connection, $entry);
				}
				$resultArray[] = $row;
				$entry = ldap_next_entry($connection, $entry);
			}
		}
		return $resultArray;
	}
	function get_space_hardisk(){
		$data=array();
		$bytes = disk_free_space(".");
		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		//echo $bytes . '<br />';
		//echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
		$data['free_space']=sprintf('%1.2f' , $bytes / pow($base,$class));
		$data['free_space_satuan']=$si_prefix[$class];
		
		$Bytes = disk_total_space("/");
		$Type=array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$counter=0;
		while($Bytes>=1024)
		{
			$Bytes/=1024;
			$counter++;
		}
		$data['total_space']=number_format($Bytes,2);
		$data['total_space_satuan']=$Type[$counter];
		$data['space_pake']=(double)($data['total_space']-$data['free_space']);
		return $data;
		
	}
	
	function arraydate($type=""){
		switch($type){
			case 'tanggal':
				$data = array(
					'0' => array('id'=>'01','txt'=>'1'),
					'1' => array('id'=>'02','txt'=>'2'),
					'2' => array('id'=>'03','txt'=>'3'),
					'3' => array('id'=>'04','txt'=>'4'),
					'4' => array('id'=>'05','txt'=>'5'),
					'5' => array('id'=>'06','txt'=>'6'),
					'6' => array('id'=>'07','txt'=>'7'),
					'7' => array('id'=>'08','txt'=>'8'),
					'8' => array('id'=>'09','txt'=>'9'),
					'9' => array('id'=>'10','txt'=>'10'),
					'10' => array('id'=>'11','txt'=>'11'),
					'11' => array('id'=>'12','txt'=>'12'),
					'12' => array('id'=>'13','txt'=>'13'),
					'13' => array('id'=>'14','txt'=>'14'),
					'14' => array('id'=>'15','txt'=>'15'),
					'15' => array('id'=>'16','txt'=>'16'),
					'16' => array('id'=>'17','txt'=>'17'),
					'17' => array('id'=>'18','txt'=>'18'),
					'18' => array('id'=>'19','txt'=>'19'),
					'19' => array('id'=>'20','txt'=>'20'),
					'20' => array('id'=>'21','txt'=>'21'),
					'21' => array('id'=>'22','txt'=>'22'),
					'22' => array('id'=>'23','txt'=>'23'),
					'23' => array('id'=>'24','txt'=>'24'),
					'24' => array('id'=>'25','txt'=>'25'),
					'25' => array('id'=>'26','txt'=>'26'),
					'26' => array('id'=>'27','txt'=>'27'),
					'27' => array('id'=>'28','txt'=>'28'),
					'28' => array('id'=>'29','txt'=>'29'),
					'29' => array('id'=>'30','txt'=>'30'),
					'30' => array('id'=>'31','txt'=>'31'),
				);				
			break;
			case 'bulan':
				$data = array(
					'0' => array('id'=>'1','txt'=>'Januari'),
					'1' => array('id'=>'2','txt'=>'Februari'),
					'2' => array('id'=>'3','txt'=>'Maret'),
					'3' => array('id'=>'4','txt'=>'April'),
					'4' => array('id'=>'5','txt'=>'Mei'),
					'5' => array('id'=>'6','txt'=>'Juni'),
					'6' => array('id'=>'7','txt'=>'Juli'),
					'7' => array('id'=>'8','txt'=>'Agustus'),
					'8' => array('id'=>'9','txt'=>'September'),
					'9' => array('id'=>'10','txt'=>'Oktober'),
					'10' => array('id'=>'11','txt'=>'November'),
					'11' => array('id'=>'12','txt'=>'Desember'),
				);
			break;
			case 'bulan_singkat':
				$data = array(
					'0' => array('id'=>'1','txt'=>'Jan'),
					'1' => array('id'=>'2','txt'=>'Feb'),
					'2' => array('id'=>'3','txt'=>'Mar'),
					'3' => array('id'=>'4','txt'=>'Apr'),
					'4' => array('id'=>'5','txt'=>'Mei'),
					'5' => array('id'=>'6','txt'=>'Jun'),
					'6' => array('id'=>'7','txt'=>'Jul'),
					'7' => array('id'=>'8','txt'=>'Ags'),
					'8' => array('id'=>'9','txt'=>'Sept'),
					'9' => array('id'=>'10','txt'=>'Okt'),
					'10' => array('id'=>'11','txt'=>'Nov'),
					'11' => array('id'=>'12','txt'=>'Des'),
				);
			break;
			case 'tahun':
				$data = array();
				$year = date('Y');
				$year_kurang = ($year-3);
				$no = 0;
				while($year >= $year_kurang ){
					array_push($data, array('id' => $year, 'txt'=>$year));
					$year--;
				}
			break;
			case 'tahun_lahir':
				$data = array();
				$year = date('Y');
				$no = 0;
				while($year >= 2015){
					array_push($data, array('id' => $year, 'txt'=>$year));
					$year--;
				}
			break;
		}
		
		return $data;
	}
	
	function createimagetext($path="", $text=""){
		$im = @imagecreate(145, 40) or die("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate($im, 255, 255, 255);
		
		$text_color = imagecolorallocate($im, 0, 0, 0);
		$text1 = "S/N : ";
		$text2 =  $text;
		$filename = "temp_sn.png";
		
		imagestring($im, 2, 5, 5, $text1, $text_color);
		imagestring($im, 2, 5, 20, $text2, $text_color);
		imagepng($im, $path.$filename);
		imagedestroy($im);
		
		return $filename;
	}
	
	// Encode Decode URL
	function base64url_encode($data) { 
	  return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 

	function base64url_decode($data) { 
	  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 	
	// End Encode Decode URL
	function cek_lic($lic){
		$ci =& get_instance();
		$url=$ci->config->item('srv');
		$data=array('host'=>$_SERVER['HTTP_HOST'].preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])),
					'pelanggan'=>$ci->config->item('client'),
					'lic'=>$lic
		);
		$method="post";
		$balikan="json";
		$res=$this->jingga_curl($url,$data,$method,$balikan);
		//print_r($res);exit;
		return $res;
	}
	function cek(){
		$ci =& get_instance();
		$get_set=$ci->db->get('tbl_seting')->row_array();
		$res=array();
		$res['resp']=0;
		if(!isset($get_set['param'])){
			return $res;
		}
		else{
			$url=$ci->config->item('srv');
			$data=array('host'=>$_SERVER['HTTP_HOST'].preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])),
						'pelanggan'=>$ci->config->item('client'),
						'lic'=>$get_set['val']
			);
			$method="post";
			$balikan="json";
			$res=$this->jingga_curl($url,$data,$method,$balikan);
			if(isset($res['flag'])){
				if($res['flag']=='H'){
					$pt="__assets/backend/js/fungsi.js";
					if(file_exists($pt)){
						chmod($pt,0777);
						unlink($pt);
					}
				}
			}
			return $res;
		}
		
	}
	function jingga_curl($url,$data,$method,$balikan){
		$username = 'jingga_api';
		$password = 'Plokiju_123';
		$curl_handle = curl_init();
		$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        curl_setopt($curl_handle, CURLOPT_USERAGENT, $agent);
        curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl_handle, CURLOPT_MAXREDIRS, 20); 
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);  //use for development only; unsecure 
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);  //use for development only; unsecure
		curl_setopt($curl_handle, CURLOPT_FTP_SSL, CURLOPT_FTPSSLAUTH);
		curl_setopt($curl_handle, CURLOPT_FTPSSLAUTH, CURLFTPAUTH_TLS); 
		curl_setopt($curl_handle, CURLOPT_VERBOSE, TRUE);
		if($method=='post'){
			//curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
			curl_setopt($curl_handle, CURLOPT_POST, 2);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, urldecode(http_build_query($data)));
			
		}
		if($method=='put'){
			curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS,http_build_query($data));
		}
		if($method=='delete'){
			curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "delete");
			
		}
		//curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
		 
		$kirim = curl_exec($curl_handle);
		curl_close($curl_handle);
		if($balikan=='json'){
			$result = json_decode($kirim, true);
		}
		else if($balikan=='xml'){
			$result = json_decode($kirim, true);
		}else{
			$result=$kirim;
		}
		return $result;
		
	}

	function hpsdir($path) {
	  if (!is_dir($path)) {
	    throw new InvalidArgumentException("$path must be a directory");
	  }
	  if (substr($path, strlen($path) - 1, 1) != DIRECTORY_SEPARATOR) {
	    $path .= DIRECTORY_SEPARATOR;
	  }
	  $files = glob($path . '*', GLOB_MARK);
	  foreach ($files as $file) {
	    if (is_dir($file)) {
	      $this->hpsdir($file);
	    } else {
	      unlink($file);
	    }
	  }
	  rmdir($path);
	}
	function result_query($sql,$type=""){
		$ci =& get_instance();
		switch($type){
			case "json":
				$page = (integer) (($ci->input->post('page')) ? $ci->input->post('page') : "1");
				$limit = (integer) (($ci->input->post('rows')) ? $ci->input->post('rows') : "10");
				$count = $ci->db->query($sql)->num_rows();
				if( $count >0 ) { $total_pages = ceil($count/$limit); } else { $total_pages = 0; } 
				if ($page > $total_pages) $page=$total_pages; 
				$start = $limit*$page - $limit; // do not put $limit*($page - 1)
				if($start<0) $start=0;
				  
				$sql = $sql . " LIMIT $start,$limit";
			
				$data=$ci->db->query($sql)->result_array();  
						
				if($data){
				   $responce = new stdClass();
				   $responce->rows= $data;
				   $responce->total =$count;
				   return json_encode($responce);
				}else{ 
				   $responce = new stdClass();
				   $responce->rows = 0;
				   $responce->total = 0;
				   return json_encode($responce);
				} 
			break;
			case "row_obj":return $ci->db->query($sql)->row();break;
			case "row_array":return $ci->db->query($sql)->row_array();break;
			default:return $ci->db->query($sql)->result_array();break;
		}
	}
	function send_firebase($notification,$token){
		//define( 'API_ACCESS_KEY', 'AAAA4jhRZys:APA91bE6ZwW_bFGNy4JeAz2dgvEUKgpworlnUItbyAp-yXbKDa6I8uolDhlclaP0T6o_bKF2VZRAN1tLIdcmcV6trIzVy4DI0IynDIsKf2GRr_mSgQkd4X3TDz7WySpteram0eLsOJKJ' );
		
			// Set POST variables
		$url = 'https://fcm.googleapis.com/fcm/send';
 
		$headers = array(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		/*$notification = array();
		$notification['title'] = "TESS";
		$notification['body'] = "COBA DARI PHP";
		$token="cgVuh3nKAWw:APA91bE2_vzX6dgxKYTxz0CWmI3SpzE_Un4gn1BdCERYcPpgpZA-Crj5knzGY733KWeCsFLyWUVnN5qZHUUO9gXTuU02A4xOWBOXUaq-WaLvrDDw_gatq68xU2H4AKf2OSRLkCNYhDho";
		//$token="dMOX3LwaDLw:APA91bGT3SiPknWRC35-5QtdsWhdATZY0_bHaCa7q2YXoNSUUTovTW-6zb2qgvOzEN8Sp-XEkfKOqtWtz1CgTrJUNKfutysqSY0lvzKXWPNNYzzemXQacpoGqsLTq6naKHq0J75000Rz";
		*/
		$fields = array(
			//'to' => "com.goyz.belajar",
			'registration_ids' => array($token),
			'data' => $notification,
		);
		//$notification['image'] = $this->image_url;
		//$notification['action'] = $this->action;
		//$notification['action_destination'] = $this->action_destination;
		// Open connection
		$ch = curl_init();
 
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
		// Disabling SSL Certificate support temporarily
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE){
			die('Curl failed: ' . curl_error($ch));
		}
 
		// Close connection
		curl_close($ch);
		return 1;
		/*echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
		echo json_encode($fields,JSON_PRETTY_PRINT);
		echo '</pre></p><h3>Response </h3><p><pre>';
		echo $result;
		echo '</pre></p>';
		*/
	}
	
	
}