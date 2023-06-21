<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index() {
		// $this->generate();
		// $this->grid();
		// $this->order();
		$this->call();
	}

	public function hallo() {
		echo "Helllo World";
	}

	public function generate() {
		$query = $this->db->query("select * from t_user limit 2");

		$hasil = $query->result();
		print_r($hasil);
		echo "<br><br>";

		$hasil = $query->result_array();
		print_r($hasil);
		echo "<br><br>";

		echo "<pre>";
		print_r($hasil);
		echo "</pre>";
	}

	public function grid() {
		$query = $this->db->query("select * from t_user");
		$hasil = $query->result_array();
		$this->fc->browse($hasil);
	}

	public function order() {
		$query = $this->db->query("select * from t_user");
		$hasil = $query->result_array();

		$hasil = $this->fc->array_index($hasil, 'kduser');
		$this->fc->browse($hasil);

		echo "<br><br>";
		$hasil = $this->fc->ToArr($hasil, 'kduser');
		echo $hasil['didik']['nmuser'];
	}

	public function call() {
		$query = $this->db->query("select * from t_user limit 2");
		$hasil = $query->result();
		foreach ($hasil as $row)
		{
		   echo $row->kduser;
		   echo $row->nmuser;
		   echo "<br>";
		}		
		echo "<br><br>";
		echo $hasil[1]->kduser;
		echo "<br><br>";

		$hasil = $query->result_array();
		foreach ($hasil as $row)
		{
		   echo $row['kduser'];
		   echo $row['nmuser'];
		   echo "<br>";
		}		
		echo "<br><br>";
		echo $hasil[1]['kduser'];
	}
}
