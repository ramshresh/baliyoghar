<?php

class coursemodel extends CI_Model {

    public function getCourseTable($deleted = 0) {
        // return $this->db->select('*')->from('course_category')->where(array('deleted'=>$deleted));
        return $this->db->get_where('course_category', array('deleted' => $deleted));
    }

    public function saveCourseData($data) {
        $success = $this->db->insert('course_category', $data);
        if ($success == 1) {
            $query = $this->db->query("SELECT * FROM course_category where deleted=0");
            $result = $query->result();
            return json_encode($result);
        } else {
            return "no";
        }
    }

    public function getCourseName($course_id) {
        $this->db->select('coursename');
        $this->db->from('course_category');
        $this->db->where('course_cat_id', $course_id);
        foreach ($this->db->get()->result() as $row) {
            return $row->coursename;
        }
    }

    public function getSubCourseName($subcourse_id) {

        $this->db->select('subcoursename');
        $this->db->from('course_subcategory');
        $this->db->where('course_subcat_id', $subcourse_id);
        foreach ($this->db->get()->result() as $row) {
            return $row->subcoursename;
        }
    }

    public function saveSubCourseData($data) {
        $success = $this->db->insert('course_subcategory', $data);
        return $success;
    }

    public function getCourseData($deleted = 0) {
        $query = $this->db->query("SELECT * FROM course_category where deleted=" . $deleted);
        $courseDetail_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $courseDetail_array[$i][0] = $row->course_cat_id;
            $courseDetail_array[$i][1] = $row->coursename;
            $courseDetail_array[$i][2] = $this->countSubcategories($row->course_cat_id);
            $i++;
        }
        return $courseDetail_array;
    }

    public function getCourseResultSet($deleted = 0) {
        // $query = $this->db->query("SELECT * FROM course_category");
        $this->db->select('*');
        $this->db->from('course_category');
        $this->db->where(array('deleted' => $deleted));
        $query = $this->db->get();
        return $query;
    }

    public function countSubcategories($course_cat_id, $deleted = 0) {
        $this->db->select('*');
        $this->db->from('course_subcategory');

        //for admin
        $this->db->where(array('course_cat_id' => $course_cat_id, 'deleted' => $deleted));

        //for others
        //$this->db->where(array('course_cat_id' => $course_cat_id,'deleted'=>0));

        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    public function getSubCourseData($course_id, $deleted = 0) {
        //for admin
        $query = $this->db->query("SELECT * FROM course_subcategory where course_cat_id = " . $course_id . " AND deleted=" . $deleted);

        //for others
        // $query = $this->db->query("SELECT * FROM course_subcategory where course_cat_id = " . $course_id." AND deleted=0");


        $subCourseDetail_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $subCourseDetail_array[$i][0] = $row->course_subcat_id;
            $subCourseDetail_array[$i][1] = $row->subcoursename;
            $i++;
        }
        return $subCourseDetail_array;
    }

    public function getRowCount_course() {
        $this->db->select('course_cat_id');
        $this->db->from('course_category');
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    public function getTotalPages_course($howmany) {
        $total_row = $this->getRowCount_course();
        $pages = ceil($total_row / $howmany);
        return $pages;
    }

    public function updateSubCourse($subcourse_id, $new_subcourse) {
        $this->db->where('course_subcat_id', $subcourse_id);
        $success = $this->db->update('course_subcategory', array('subcoursename' => $new_subcourse));
        return $success;
    }

    public function updateCourseName($course_id, $course_name) {
        $this->db->where('course_cat_id', $course_id);
        $success = $this->db->update('course_category', array('coursename' => $course_name));
        return $success;
    }

    public function deleteSubCourse($subcourse_id) {
        //for admin
        if ($this->session->userdata('role') == 'superadmin') {
            if (!$this->subcourseHasDependents($subcourse_id)) {
                $array = array('course_subcat_id' => $subcourse_id);
                $success = $this->db->delete('course_subcategory', $array);
                return $success;
            } else {
                return 'associated';
            }
        } else {
            //for user and subadmin
            $date = date("Y-m-d H:i:s");
            $deleted_by = $this->session->userdata('username');
            $this->db->where('course_subcat_id', $subcourse_id);
            $success = $this->db->update('course_subcategory', array('deleted' => 1, 'deleted_date' => $date, 'deleted_by' => $deleted_by));
            return $success;
        }
    }

    function subcourseHasDependents($subcourse_id) {
        $this->db->select('*');
        $this->db->from('events');
        $array = array('course_subcat_id' => $subcourse_id);
        $this->db->where($array);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getEventsWithCourse($course_id,$deleted=0){
        $query = $this->db->query("SELECT * FROM events where course_cat_id = " . $course_id . " AND deleted=" . $deleted." ORDER BY event_id DESC");
        $data = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $data[$i][0] = $row->event_id;
            $data[$i][1] = $row->title;
            $data[$i][2] = $this->getCourseName($row->course_cat_id);
            $data[$i][3] = $this->getSubCourseName($row->course_subcat_id);
            $data[$i][4] = $row->start_date;
            $data[$i][5] = $row->end_date;
            $data[$i][6] = $this->db->query("select count(participated_in_id) as count from participated_in where event_id=" . $row->event_id)->row()->count;
            $i++;
        }
        return $data;
    }
    
    public function deleteCourse($course_id) {

        //for admin
        if ($this->session->userdata('role') == 'superadmin') {
            if (!$this->courseHasDependents($course_id)) {
                $array = array('course_cat_id' => $course_id);
                $success = $this->db->delete('course_subcategory', $array);
                $array = array('course_cat_id' => $course_id);
                $success = $this->db->delete('course_category', $array);
                return $success;
            } else {
                return 'associated';
            }
        } else {
            //for user and subadmin
            $date = date("Y-m-d H:i:s");
            $deleted_by = $this->session->userdata('username');
            $this->db->where('course_cat_id', $course_id);
            $success = $this->db->update('course_subcategory', array('deleted' => 1, 'deleted_date' => $date, 'deleted_by' => $deleted_by));
            $this->db->where('course_cat_id', $course_id);
            $success = $this->db->update('course_category', array('deleted' => 1, 'deleted_date' => $date, 'deleted_by' => $deleted_by));
            return $success;
        }
    }

    function courseHasDependents($course_id) {
        $this->db->select('*');
        $this->db->from('events');
        $array = array('course_cat_id' => $course_id);
        $this->db->where($array);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getDeletedCourses() {
        $query = $this->db->query("SELECT * FROM course_category where deleted=1");
        $courseDetail_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $courseDetail_array[$i][0] = $row->course_cat_id;
            $courseDetail_array[$i][1] = $row->coursename;
            $courseDetail_array[$i][2] = $row->deleted_by;
            $courseDetail_array[$i][3] = $row->deleted_date;
            $courseDetail_array[$i][4] = $this->getSubCourseData($row->course_cat_id, 1);
            $i++;
        }
        return $courseDetail_array;
    }

    function getDeletedSubcourses() {
        $query = $this->db->query("SELECT * FROM course_subcategory where deleted=1");
        $courseDetail_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $courseDetail_array[$i][0] = $row->course_subcat_id;
            $courseDetail_array[$i][1] = $row->subcoursename;
            $courseDetail_array[$i][2] = $row->deleted_by;
            $courseDetail_array[$i][3] = $row->deleted_date;
            $courseDetail_array[$i][4] = $this->getCourseName($row->course_cat_id);
            $i++;
        }
        return $courseDetail_array;
    }

}

?>
