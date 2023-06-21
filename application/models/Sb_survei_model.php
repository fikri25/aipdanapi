<?php
class Sb_survei_model extends CI_Model {
	public function get_data() {
		$query  = $this->db->query("SELECT ID, PROVINSI, KDSTATUS FROM sb_survey_kirim");
		$data = '{"provinsi":'.json_encode($query->result_array()).'}';
		return $data;
	}

	public function get_jml() {
		$query  = $this->db->query("SELECT kdstatus, COUNT(*) AS jml, (COUNT(*)/(SELECT COUNT(*) FROM sb_survey_kirim)) * 100 AS persen FROM sb_survey_kirim GROUP BY 1");
		return $query->result_array();
	}

}
