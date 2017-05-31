<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 9/6/2016
 * Time: 2:59 PM
 */
class educationlevelmodel extends CI_Model
{
	public function getEducationLevelTable($deleted = 0){
		$params =array();
		$params['deleted']=$deleted;
		return $this->db->get_where('education_levels', $params);
	}

	public function getWorkName($education_level_id,$deleted = 0){
		$query = $this->db->get_where('education_levels', array(
			'deleted' => $deleted,
			'education_level_id'=>$education_level_id
		));

		$row = $query->row();

		if (!empty($row))
		{
			return $row->education_level;
		}
	}
	public function saveEducationLevelData($data) {
		$success = $this->db->insert('education_levels', $data);
		if ($success == 1) {
			$query = $this->db->query("SELECT * FROM education_levels where deleted=0");
			$result = $query->result();
			return json_encode($result);
		} else {
			return "no";
		}
	}

	public function getEducationLevelName($education_level_id) {
		$this->db->select('education_level');
		$this->db->from('education_levels');
		$this->db->where('education_level_id', $education_level_id);
		foreach ($this->db->get()->result() as $row) {
			return $row->education_level;
		}
	}

	public function getEducationLevelData($deleted = 0) {
		$query = $this->db->query("SELECT * FROM education_levels where deleted=" . $deleted);
		$educationLevelDetail_array = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$educationLevelDetail_array[$i][0] = $row->education_level_id;
			$educationLevelDetail_array[$i][1] = $row->education_level;
			$i++;
		}
		return $educationLevelDetail_array;
	}

}
