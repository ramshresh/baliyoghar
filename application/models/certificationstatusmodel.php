<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 9/6/2016
 * Time: 2:59 PM
 */
class certificationstatusmodel extends CI_Model
{
	public function getCertificationStatusTable($deleted = 0){
		return $this->db->get_where('certification_status', array('deleted' => $deleted));
	}

	public function getWorkName($certification_status_id,$deleted = 0){
		$query = $this->db->get_where('certification_status', array(
			'deleted' => $deleted,
			'certification_status_id'=>$certification_status_id
		));

		$row = $query->row();

		if (!empty($row))
		{
			return $row->certification_status_name;
		}
	}
	public function saveCertificationStatusData($data) {
		$success = $this->db->insert('certification_status', $data);
		if ($success == 1) {
			$query = $this->db->query("SELECT * FROM certification_status where deleted=0");
			$result = $query->result();
			return json_encode($result);
		} else {
			return "no";
		}
	}

	public function getCertificationStatusName($certification_status_id) {
		$this->db->select('certification_status_name');
		$this->db->from('certification_status');
		$this->db->where('certification_status_id', $certification_status_id);
		foreach ($this->db->get()->result() as $row) {
			return $row->certification_status_name;
		}
	}

	public function getCertificationStatusData($deleted = 0) {
		$query = $this->db->query("SELECT * FROM certification_status where deleted=" . $deleted);
		$certificationStatusDetail_array = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$certificationStatusDetail_array[$i][0] = $row->certification_status_id;
			$certificationStatusDetail_array[$i][1] = $row->certification_status_name;
			$i++;
		}
		return $certificationStatusDetail_array;
	}

}
