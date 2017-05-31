<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 9/6/2016
 * Time: 2:59 PM
 */
class worktypemodel extends CI_Model
{
	public function getWorkTypeTable($deleted = 0,$course_category_id=null){
		$params =array();
		$params['deleted']=$deleted;
		if($course_category_id!=null){
			$params['course_category_id']=$course_category_id;
		}
		return $this->db->get_where('work_type', $params);
	}
    public function getWorkTypeTableByCourseCategoryID($course_ctg_id){
        return $this->db->get_where('work_type', array('deleted' => 0,'course_category_id'=>$course_ctg_id));
    }

	public function getWorkName($work_type_id,$deleted = 0){
		$query = $this->db->get_where('work_type', array(
			'deleted' => $deleted,
			'work_type_id'=>$work_type_id
		));

		$row = $query->row();

		if (!empty($row))
		{
			return $row->work_name;
		}
	}
	public function saveWorkTypeData($data) {
		$success = $this->db->insert('work_type', $data);
		if ($success == 1) {
			$query = $this->db->query("SELECT * FROM work_type where deleted=0");
			$result = $query->result();
			return json_encode($result);
		} else {
			return "no";
		}
	}

	public function getWorkTypeName($work_type_id) {
		$this->db->select('work_name');
		$this->db->from('work_type');
		$this->db->where('work_type_id', $work_type_id);
		foreach ($this->db->get()->result() as $row) {
			return $row->work_name;
		}
	}

	public function getWorkTypeData($deleted = 0) {
		$query = $this->db->query("SELECT * FROM work_type where deleted=" . $deleted);
		$workTypeDetail_array = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$workTypeDetail_array[$i][0] = $row->work_type_id;
			$workTypeDetail_array[$i][1] = $row->work_name;
			$i++;
		}
		return $workTypeDetail_array;
	}

}
