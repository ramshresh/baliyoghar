<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 9/6/2016
 * Time: 2:59 PM
 */
class beneficiarytypemodel extends CI_Model
{
	public function getBeneficiaryTypeTable($deleted = 0,$course_category_id=null){
		$params =array();
		$params['deleted']=$deleted;
		if($course_category_id!=null){
			$params['course_category_id']=$course_category_id;
		}
		return $this->db->get_where('beneficiary_type', $params);
	}

	public function getBeneficiaryName($beneficiary_type_id,$deleted = 0){
		$query = $this->db->get_where('beneficiary_type', array(
			'deleted' => $deleted,
			'beneficiary_type_id'=>$beneficiary_type_id
		));

		$row = $query->row();

		if (!empty($row))
		{
			return $row->beneficiary_name;
		}
	}
	public function saveBeneficiaryTypeData($data) {
		$success = $this->db->insert('beneficiary_type', $data);
		if ($success == 1) {
			$query = $this->db->query("SELECT * FROM beneficiary_type where deleted=0");
			$result = $query->result();
			return json_encode($result);
		} else {
			return "no";
		}
	}

	public function getBeneficiaryTypeName($beneficiary_type_id) {
		$this->db->select('beneficiary_name');
		$this->db->from('beneficiary_type');
		$this->db->where('beneficiary_type_id', $beneficiary_type_id);
		foreach ($this->db->get()->result() as $row) {
			return $row->beneficiary_name;
		}
	}

	public function getBeneficiaryTypeData($deleted = 0) {
		$query = $this->db->query("SELECT * FROM beneficiary_type where deleted=" . $deleted);
		$beneficiaryTypeDetail_array = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$beneficiaryTypeDetail_array[$i][0] = $row->beneficiary_type_id;
			$beneficiaryTypeDetail_array[$i][1] = $row->beneficiary_name;
			$i++;
		}
		return $beneficiaryTypeDetail_array;
	}

}
