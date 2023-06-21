<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Class of Idub-Libraries
class Fc {

// MANIPULASI STRING / ARRAY
	public function GetPosBy($string, $position) {
		$hasil = explode(',', $string);
		return trim($hasil[$position-1]);
	}

	public function ToArr($arr, $idkey) {
		$str = array();
		foreach($arr as $row) $str[ $row[$idkey] ] = $row;
		return $str;
	}

	public function InVar($arr, $kode) {
		$in = "in (";
		foreach ($arr as $row) {
			if (trim($row[$kode])!='') {
			  if ( !strpos($in, $row[$kode]) ) $in .= "'$row[$kode]'";
			}
		}
		$in = str_replace("''", "','", $in) .")";
		return $in;
	}

	public function array_index( $a, $subkey) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return $c;
	}

	public function idtgl($tgl, $str=null) {
		$tgl = strtotime($tgl);
		if ( date('d-m-Y', $tgl)=='01-01-1970' ) return '&nbsp;';

		if ($str==null) {
				$var = date('d-m-Y', $tgl);
				if ($var=='01-01-1970') $var='&nbsp;';
		}

		if ($str=='tgljam') {
				$bulan = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des');
				$var   = date('d', $tgl) .' '. $bulan[date('m', $tgl)] .' '. date('Y', $tgl) .' '. date('H:i', $tgl) ;
		}

		if ($str=='hari' || $str=='full') {
				$hari  = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jum\'at','Saturday'=>'Sabtu');
				$bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
				$var   = $hari[date('l', $tgl)] .', '. date('d', $tgl) .' '. $bulan[date('m', $tgl)] .' '. date('Y', $tgl);
				if ($str=='full') $var .= ' '. date('H:i', $tgl) . ' WIB';
		}

		if ($str=='hr') {
				$hari  = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jum\'at','Saturday'=>'Sabtu');
				$bulan = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des');
				$var   = $hari[date('l', $tgl)] .', '. date('d', $tgl) .' '. $bulan[date('m', $tgl)] .' '. date('Y', $tgl);
		}

		if ($str=='mig') {
				$hari  = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jum\'at','Saturday'=>'Sabtu');
				$var   = $hari[date('l', $tgl)];
		}
		return $var;
	}

	function ustgl($tgl, $str=null) {
		if ( $tgl=='&nbsp;' ) return '&nbsp;';
		switch ($str) {
			case null:
				$arr = explode('-', $tgl);
				$var = $arr[2].'-'. $arr[1] .'-'.$arr[0] ;
				break;
			case 'hari' || 'full':
				$bulan = array('Januari'=>'01','Pebruari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05','Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
				$arr = explode(' ', $tgl);
				$var = $arr[3].'-'.$bulan[ $arr[2] ].'-'.$arr[1] ;
				if ($str=='full') $var .= ' '. $arr[6] .':00 ';
				break;
		}
		return $var;
	}


	function pagination( $base_url, $total_rows, $per_page, $uri_segment ) {
		$config['total_rows'] = $total_rows;
		$config['base_url'] = $base_url;
		$config['per_page'] = $per_page;
		$config['uri_segment'] = $uri_segment;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li><a href=""  class="active">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		return $config;
	}

}
