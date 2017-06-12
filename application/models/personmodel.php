<?php

require_once('usermodel.php');
require_once('eventmodel.php');
require_once('workexperiencemodel.php');
require_once('educationlevelmodel.php');
require_once('certificationstatusmodel.php');
require_once('worktypemodel.php');
require_once('beneficiarytypemodel.php');
include('nepali_calendar.php');

class personmodel extends CI_Model
{

    var $imagepath;
    private $usermodel;
    private $eventmodel;
    private $cal;
    private $person_pagination_totalpage;


    //  var $imagepath_url;

    public function personmodel()
    {
        $this->imagepath = realpath(APPPATH . '../gallery');
        $this->usermodel = new usermodel();
        $this->cal = new Nepali_Calendar();
        // $this->imagepath_url = base_url().'gallery/';
    }

    function do_upload($person_id)
    {
        $picture = $this->getPicture($person_id);
        if ((strpos($picture, 'image_') !== false)) {
            //if any old picture of the person exists, delete tem first.
            unlink(realpath(APPPATH . '../gallery/' . $picture));
            unlink(realpath(APPPATH . '../gallery/thumbs/' . $picture));
        }
        //for image upload
        //$session_id = $this->sessionsession_id();
        $random = rand(11111, 999999999);
        $config = array(
            'file_name' => 'image_' . $person_id . 'PTAS' . $random,
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->imagepath,
            'max_size' => 3000
        );

        $this->load->library('upload', $config);
        $this->upload->do_upload();

        $image_data = $this->upload->data();

        //for thumbnail
        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $this->imagepath . '/thumbs',
            'maintain_ration' => true,
            'width' => 150,
            'height' => 100
        );

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        //now update image path to that of new image
        if (strtolower($image_data['file_ext']) == '.jpg' || strtolower($image_data['file_ext']) == '.jpeg' || strtolower($image_data['file_ext']) == '.png' || strtolower($image_data['file_ext']) == '.gif') {
            $this->db->where(array('person_id' => $person_id));
            $success = $this->db->update('person', array('photo' => 'image_' . $person_id . 'PTAS' . $random . "" . $image_data['file_ext']));
        }
    }

    public function savePersonData($data)
    {


        if (trim($data['dob_en']) == '' && trim($data['dob_np']) == '') {


        } else {
            if (trim($data['dob_en']) == '') {
                $data['dob_en'] = $this->getEnglishDate($data['dob_np']);
                echo '<script> alert("given nepali = ' . $data['dob_np'] . ' converted english = ' . $data['dob_en'] . '");</script>';
            }
            if (trim($data['dob_np']) == '') {
                $data['dob_np'] = $this->getNepaliDate($data['dob_en']);
                echo '<script> alert("given english = ' . $data['dob_en'] . ' converted nepali = ' . $data['dob_np'] . '");</script>';
            }

            if (isset($data['dob_en']) && !isset($data['age'])) {
                $data['age'] = $this->calculateAge($data['dob_en'], $data['dob_ref_en']);
            }
        }


        $success = $this->db->insert('person', $data);
        return $this->db->insert_id();
    }

    public function updateParticipatedInData($data, $event_id)
    {
        $this->db->where('event_id', $event_id);
        $success = $this->db->update('participated_in', $data);
        return $success;
    }

    public function updateParticipationInData_participated_in_id($data, $participated_in_id)
    {
        $this->db->where('participated_in_id', $participated_in_id);
        $success = $this->db->update('participated_in', $data);
        return $success;
    }

    public function updatePersonData($data, $person_id)
    {


        //if form is submitted without filling both date of birth fields
        if (trim($data['dob_en']) == '' && trim($data['dob_np']) == '') {

        } else {
            if (trim($data['dob_en']) == '') {
                $data['dob_en'] = $this->getEnglishDate($data['dob_np']);
            }
            if (trim($data['dob_np']) == '') {
                $data['dob_np'] = $this->getNepaliDate($data['dob_en']);
            }
            if (trim($data['age']) == '' && trim($data['dob_np']) != '' && trim($data['dob_en']) != '') {
                $data['age'] = $this->calculateAge($data['dob_en'], date_create('today'));
            }
        }


        $this->db->where('person_id', $person_id);
        $success = $this->db->update('person', $data);
        return $success;
    }

    public function getPeople($start, $end)
    {
        $query = $this->db->query("SELECT * FROM person where deleted=0  ORDER BY fullname ASC LIMIT " . $start . " , " . $end . " ");
        $person_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $person_array[$i][0] = $row->person_id;
            $person_array[$i][1] = $row->title;
            $person_array[$i][2] = $row->fullname;
            $person_array[$i][3] = $row->email;
            $person_array[$i][4] = $row->mobile;
            $i++;
        }
        return $person_array;
    }

    public function getPersonName($person_id, $title = false)
    {
        $query = $this->db->query("SELECT * FROM person where person_id='" . $person_id . "' AND deleted=0 ");
        foreach ($query->result() as $row) {
            if ($title == false) {
                $person_name = $row->fullname;
            } else {
                $person_name = $row->title . ' ' . $row->fullname;
            }
        }
        return $person_name;
    }

    /**
     * @param $value
     * @return string
     * http://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
     */
    public static function escape($value)
    {
        $return = '';
        for ($i = 0; $i < strlen($value); ++$i) {
            $char = $value[$i];
            $ord = ord($char);
            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
                $return .= $char;
            else
                $return .= '\\x' . dechex($ord);
        }
        return $return;
    }

    public function calculateAge_Today($dob_en)
    {
        return $this->calculateAge($dob_en, date_create('today'));
    }

    /*
     * @param $dob Date of Birth in English '1970-02-01'
     */
    public function calculateAge($dob_en = null, $dob_ref_en = null)
    {
        if (!isset($dob_ref_en)) {
            $dob_ref_en = date_create('today');
        }
        if (isset($dob_en)) {
            //return date_diff(date_create($dob_en), date_create('today'))->y;
            return date_diff(date_create($dob_en), $dob_ref_en)->y;
        }
    }

    public function getPerson($search_string, $start, $end)
    {
        $query = '';
        if ($this->session->userdata('role') == 'superadmin') {
            $query = $this->db->query("SELECT * FROM person WHERE (fullname like '%" . self::escape($search_string) . "%' OR email like '%" . self::escape($search_string) . "%' or mobile like '%" . self::escape($search_string) . "%')  ORDER BY fullname ASC LIMIT " . $start . " , " . $end);
        } else {
            $query = $this->db->query("SELECT * FROM person WHERE (fullname like '%" . self::escape($search_string) . "%' OR email like '%" . self::escape($search_string) . "%' or mobile like '%" . self::escape($search_string) . "%') AND deleted=0  ORDER BY fullname ASC LIMIT " . $start . " , " . $end);
        }
        $count = $query->num_rows();
        $person_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $person_array[$i][0] = $row->person_id;
            $person_array[$i][1] = $row->title;
            $person_array[$i][2] = $row->fullname;
            $person_array[$i][3] = $row->c_address;
            $person_array[$i][4] = $row->mobile;
            $person_array[$i][5] = $row->email;
            $person_array[$i][6] = $row->org_name;
            $person_array[$i][7] = $row->position;

            $i++;
        }
        $this->setPerson_pagination_totalpage($count, ($end - $start));
        return $person_array;
    }

    private function setPerson_pagination_totalpage($rowcount, $howmany)
    {
        $this->person_pagination_totalpage = ceil($rowcount / $howmany);
    }

    public function getPerson_pagination_totalpage()
    {
        return $this->person_pagination_totalpage;
    }

    function getNepaliDate($english_date)
    {
        $nepali_date = $this->cal->eng_to_nep($english_date);
        //  echo $nepali_date;
        return $nepali_date;
    }

    function getEnglishDate($nepali_date)
    {
        $english_date = $this->cal->nep_to_eng($nepali_date);
        //   echo $english_date;
        return $english_date;
    }

    public function getCurrentAge($dob_en)
    {
        if ($dob_en != '0000-00-00') {
            $time = abs(strtotime($dob_en) - strtotime(date("Y-m-d")));
            $age = floor($time / (365 * 60 * 60 * 24)) == $time / (365 * 60 * 60 * 24) ? floor($time / (365 * 60 * 60 * 24)) : floor($time / (365 * 60 * 60 * 24)) + 1;
        } else $age = null;

        return $age;
    }

    public function getPersonDetail($person_id)
    {

        $selectsArr = array(
            '*'
        );
        $queryStr = "SELECT "
            . implode(',', $selectsArr)
            . " FROM person p where p.person_id=" . $person_id . "  LIMIT 1";


        $query = $this->db->query($queryStr);
        $personDetail_array = array();
        //  $i = 0;
        foreach ($query->result() as $row) {
            //   $english_date = $this->getEnglishDate($row->dob_en);
            // $time = abs(strtotime($row->dob) - strtotime(date("Y-m-d")));
            $personDetail_array[0] = $row->person_id;
            $personDetail_array[1] = $row->title;
            $personDetail_array[2] = $row->fullname;
            $personDetail_array[3] = $row->dob_en;
            /*$english_date = $row->dob_en;
            $personDetail_array[4] = $this->getCurrentAge($english_date);*/
            $personDetail_array[4] = $row->age;
            $personDetail_array[5] = $row->gender;
            $personDetail_array[6] = $row->p_address;
            $personDetail_array[7] = $row->c_address;
            $personDetail_array[8] = $row->photo;
            $personDetail_array[9] = $row->country;
            $personDetail_array[10] = $row->phone;
            $personDetail_array[11] = $row->mobile;
            $personDetail_array[12] = $row->email;
            $personDetail_array[13] = $row->org_name;
            $personDetail_array[14] = $row->org_address;
            $personDetail_array[15] = $row->org_phone;
            $personDetail_array[16] = $row->org_fax;
            $personDetail_array[17] = $row->position;
            $personDetail_array[18] = $row->current_status;
            $personDetail_array[19] = $row->dob_np;  //yo chai pachhi thapeko bhayera last ma pugyo
            $personDetail_array[20] = $row->created_date;
            $personDetail_array[25] = $row->caste_ethnicity;  //yo chai pachhi thapeko bhayera last ma pugyo
            $personDetail_array[26] = $row->citizenship_no;  //yo chai pachhi thapeko bhayera last ma pugyo
            $personDetail_array[27] = $row->education_level;  //yo chai pachhi thapeko bhayera last ma pugyo
            $personDetail_array[28] = $row->work_type_id;  //yo chai pachhi thapeko bhayera last ma pugyo
            $personDetail_array[29] = $row->education;  //yo chai pachhi thapeko bhayera last ma pugyo
            $personDetail_array[30] = $row->age;  //yo chai pachhi thapeko bhayera last ma pugyo
            $personDetail_array[37] = $row->work_experience_years;  //yo chai pachhi thapeko bhayera last ma pugyo
            // $i++;
        }

        return $personDetail_array;
    }

    public function deletePerson($id, $user, $role, $date)
    {
        /*
         * <?php
$filename = '/path/to/foo.txt';

if (file_exists($filename)) {
    echo "The file $filename exists";
} else {
    echo "The file $filename does not exist";
}
?>
         */

        $persong_detail = $this->getPersonDetail($id);

        //  if ($role == 'superadmin') {
        $this->eventmodel = new eventmodel();

        $participation = $this->eventmodel->getAllParticipation($id);

        if (count($participation) > 0) {
            //if associated data is found in participated_in table , return the event details in which he has participated
            //dont deleted directly
            return $participation;
        } else {
            $array = array('person_id' => $id);
            $success = $this->db->delete('person', $array);
            if ($success == 1) {
                if (isset($persong_detail[8])) {
                    if (is_file(realpath(APPPATH . '../gallery/' . $persong_detail[8])))
                        unlink(realpath(APPPATH . '../gallery/' . $persong_detail[8]));
                    if (is_file(realpath(APPPATH . '../gallery/thumbs/' . $persong_detail[8])))
                        unlink(realpath(APPPATH . '../gallery/thumbs/' . $persong_detail[8]));
                }

            }

            return $success;
        }
//        } else {
//            $this->db->where('person_id', $id);
//            $success = $this->db->update('person', array('deleted_by' => $user, 'deleted_date' => $date, 'deleted' => 1));
//            return $success;
//        }
    }

    public function getRowCount_person()
    {
        $this->db->select('person_id');
        $this->db->from('person');
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    public function getTotalPages_person($howmany)
    {
        $total_row = $this->getRowCount_person();
        $pages = ceil($total_row / $howmany);
        return $pages;
    }

    function getPicture($person_id)
    {
        return $this->db->query("select photo from person where person_id=" . $person_id)->row()->photo;
    }

    function removePicture($person_id)
    {
        $picture = $this->getPicture($person_id);
        $this->db->where(array('person_id' => $person_id));
        $success = $this->db->update('person', array('photo' => ''));
        if ($success == 1) {
            unlink(realpath(APPPATH . '../gallery/' . $picture));
            unlink(realpath(APPPATH . '../gallery/thumbs/' . $picture));
        }
    }

    function addWorkExperience($data)
    {
        $success = $this->db->insert('work_experience', $data);
        $insert_id = $this->db->insert_id();
        if ($success == 1)
            return $insert_id;
        else
            return 0;
    }

    public function getTypeOfWorkTable($deleted = 0)
    {
        // return $this->db->select('*')->from('course_category')->where(array('deleted'=>$deleted));
        return $this->db->get_where('course_category', array('deleted' => $deleted));
    }

    public function getRelatedDropDownSelects()
    {
        $data = [];

        $this->load->model('certificationstatusmodel');
        $this->load->model('beneficiarytypemodel');
        $this->load->model('worktypemodel');
        $this->load->model('educationlevelmodel');
        //{{
        $query = $this->certificationstatusmodel->getCertificationStatusTable();
        $certificationStatusSelect = "";
        foreach ($query->result() as $row) {
            $certificationStatusSelect .= '<option value="' . $row->certification_status_id . '">' . $row->certification_status_name . '</option>';
        }
        $data['certificationStatusSelect'] = $certificationStatusSelect;
        //}}
        //{{{
        $query = $this->beneficiarytypemodel->getBeneficiaryTypeTable();
        $beneficiaryTypeSelect = "";
        foreach ($query->result() as $row) {
            $beneficiaryTypeSelect .= '<option value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
        }
        $data['beneficiaryTypeSelect'] = $beneficiaryTypeSelect;
        //}}}
        //{{{
        $query = $this->worktypemodel->getWorkTypeTable();
        $workTypeSelect = "";
        foreach ($query->result() as $row) {
            $workTypeSelect .= '<option value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
        }
        $data['WorkTypeSelect'] = $workTypeSelect;
        //}}}

        //{{{
        $query = $this->educationlevelmodel->getEducationLevelTable();
        $educationLevelSelect = "";
        foreach ($query->result() as $row) {
            $educationLevelSelect .= '<option value="' . $row->education_level_id . '">' . $row->education_level . '</option>';
        }
        $data['educationLevelSelect'] = $educationLevelSelect;
        //}}}

        return $data;
    }

    public function makeWhereClause(
        $deleted = null,//deleted
        $params = array()//searchParams
    )
    {
        $deleted = ($deleted != null) ? $deleted : 0;
        $event_year = (isset($params['event_year'])) ? $params['event_year'] : '';
        $event_month = (isset($params['event_month'])) ? $params['event_month'] : '';
        $event_district = (isset($params['event_district'])) ? $params['event_district'] : '';
        $event_vdc = (isset($params['event_vdc'])) ? $params['event_vdc'] : '';
        $event_ward_no = (isset($params['event_ward_no'])) ? $params['event_ward_no'] : '';
        $keywords = (isset($params['keywords'])) ? $params['keywords'] : '';
        $event_course_cat_id = (isset($params['event_course_cat_id'])) ? $params['event_course_cat_id'] : '';
        //$event_course_cat_id =;//(isset($params['event_course_cat_id']))?$params['event_course_cat_id']:'';

        //||*********************Keywords Joined with OR
        $wh_keywords_expr_arr = array();
        if (isset($keywords) && $keywords != '' && $keywords != null) {
            array_push($wh_keywords_expr_arr, "person_fullname LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_dob_np LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_p_address LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_c_address LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_mobile LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_phone LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_email LIKE '%" . $keywords . "%'");

            array_push($wh_keywords_expr_arr, "person_org_address LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_org_phone LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_org_fax LIKE '%" . $keywords . "%'");
            array_push($wh_keywords_expr_arr, "person_org_position LIKE '%" . $keywords . "%'");

            array_push($wh_keywords_expr_arr, "event_event_code LIKE '%" . $keywords . "%'");

        }
        $wh_keywords_expr_str = implode(' OR ', $wh_keywords_expr_arr);
        $wh_keywords_expr_str = ('' != $wh_keywords_expr_str) ? '(' . $wh_keywords_expr_str . ')' : $wh_keywords_expr_str;
        //||END*********************Keywords

        //||*********************Fields Joined with AND
        $wh_params_expr_arr = array();
        if (isset($deleted) && $deleted != '' && $deleted != null) {
            array_push($wh_params_expr_arr, "event_deleted = '" . $deleted . "'");
            array_push($wh_params_expr_arr, "person_deleted = '" . $deleted . "'");
            array_push($wh_params_expr_arr, "participation_deleted = '" . $deleted . "'");
        }

        if (isset($event_month) && $event_month != '' && $event_month != null) {
            array_push($wh_params_expr_arr, "event_sd_month = " . $event_month);
        }
        if (isset($event_year) && $event_year != '' && $event_year != null) {
            array_push($wh_params_expr_arr, "event_sd_year = " . $event_year);
        }
        if (isset($event_course_cat_id) && $event_course_cat_id != '' && $event_course_cat_id != null) {
            array_push($wh_params_expr_arr, "event_course_cat_id = " . $event_course_cat_id);
        }

        if (isset($event_district) && $event_district != '' && $event_district != null) {
            array_push($wh_params_expr_arr, "event_district = '" . $event_district . "'");
        }
        if (isset($event_vdc) && $event_vdc != '' && $event_vdc != null) {
            array_push($wh_params_expr_arr, "event_vdc = '" . $event_vdc . "'");
        }
        if (isset($event_ward_no) && $event_ward_no != '' && $event_ward_no != null) {
            array_push($wh_params_expr_arr, "event_ward_no = '" . $event_ward_no . "'");
        }

        $wh_params_expr_str = implode(' AND ', $wh_params_expr_arr);
        $wh_params_expr_str = ('' != $wh_params_expr_str) ? '(' . $wh_params_expr_str . ')' : $wh_params_expr_str;
        //||END *********************Fields

        $wh_clause_expr_arr = array();
        if ($wh_params_expr_str != '') {
            array_push($wh_clause_expr_arr, $wh_params_expr_str);
        }
        if ($wh_keywords_expr_str != '') {
            array_push($wh_clause_expr_arr, $wh_keywords_expr_str);
        }
        $wh_clause_expr_str = implode(' AND ', $wh_clause_expr_arr);
        $wh_clause_str = ($wh_clause_expr_str != '') ? 'WHERE ' . $wh_clause_expr_str : '';

        return $wh_clause_str;
    }

    public function makeOrderByClause($order_by_arr=array())
    {
        if(is_array($order_by_arr) && empty($order_by_arr)){
            $order_by_arr=array('event_start_date'=> 'desc');
        }

        $order_by_expr_arr =array();
        foreach ($order_by_arr as $attribute=>$order) {
            array_push($order_by_expr_arr, $attribute.' '.$order);
        }
        $order_by_expr_str = implode(' , ', $order_by_expr_arr);
        $order_by_clause_str = ($order_by_expr_str != '') ? ' ORDER BY  ' . $order_by_expr_str : '';

        return $order_by_clause_str;
    }
    public function makeGroupByClause($group_arr=array())
    {
        if(is_array($group_arr) && empty($group_arr)){
            $group_arr=array('event_id');
        }
        $group_by_expr_str = implode(' , ', $group_arr);
        $group_by_clause_str = ($group_by_expr_str != '') ? ' GROUP BY  ' . $group_by_expr_str : '';

        return $group_by_clause_str;
    }
    public function makeLimitClause(
        $start = null,//start-->offset
        $limit = null//limit-->per_page
    )
    {
        $limit_str = '';
        if ($start != null && $limit != null) {
            $limit_str = " LIMIT " . $start . "," . $limit;
        }
        if ($start == null && $limit != null) {
            $limit_str = " LIMIT " . $limit;
        }

        return $limit_str;
    }

    public function getFilteredPeople(
        $start = null,//start-->offset
        $limit = null,//limit-->per_page
        $deleted = null,//deleted
        $params = array()//searchParams
    )
    {
        //Make Where Clause
        $wh_clause_str=$this->makeWhereClause( $deleted, $params);

        //Making GroupBy Clause
        $group_by_clause_str= $this->makeGroupByClause();

        //Making OrderBy Clause
        $order_by_clause_str= $this->makeOrderByClause();

        //Making Limit Clause
        $limit_str=$this->makeLimitClause($start,$limit);

        $select_str = <<<SQL
		SELECT r.* FROM(
		SELECT 
		    p.person_id as person_id,
            p.title as person_title,
            p.fullname as person_fullname,
            p.dob_np as person_dob_np,
            p.dob_en as person_dob_en,
            p.gender as person_gender,
            p.p_address as person_p_address,
            p.c_address as person_c_address,
            p.photo   as person_photo ,
            p.country  as person_country,
            p.phone  as person_phone,
            p.mobile  as person_mobile,
            p.email  as person_email,
            p.org_name  as person_org_name,
            p.org_address   as person_org_address,
            p.org_phone   as person_org_phone,
            p.org_fax   as person_org_fax,
            p.position  as person_org_position,
            p.current_status  as person_current_status,
            p.created_by  as person_created_by,
            p.created_date  as person_created_date,
            p.deleted_by  as person_deleted_by,
            p.deleted_date  as person_deleted_date,
            p.deleted  as person_deleted,
            p.caste_ethnicity  as person_caste_ethnicity,

            t.participated_in_id,
        	t.event_id as event_id,
        	t.person_age as participation_person_age,
        	t.is_instructor as participation_is_instructor,
        	t.deleted as participation_deleted,
        	t.certification_code as participation_certification_code,
        	t.certification_status as participation_certification_status,
        	t.certification_date as participation_certification_date,
        	t.beneficiary_type as participation_beneficiary_type,
        	t.participation_role as participation_role,
        	t.experience_years as participation_experience_years,

            e.title as event_title,
            e.course_cat_id  as event_course_cat_id,
            e.course_subcat_id  as event_course_subcat_id,
            e.coverage_level  as event_coverage_level,
            e.coverage_location  as event_coverage_location,
            e.year  as event_year,
            e.start_date  as event_start_date,
            e.end_date  as event_end_date,
            e.venue  as event_venue,
            e.address  as event_address,
            e.country  as event_country,
            e.created_by  as event_created_by,
            e.created_date  as event_created_date,
            e.deleted_by  as event_deleted_by,
            e.deleted_date  as event_deleted_date,
            e.deleted  as event_deleted,
            e.longitude  as event_longitude,
            e.latitude  as event_latitude,
            e.Budget_unit  as event_Budget_unit,
            e.event_code  as event_event_code,
            e.district  as event_district,
            e.vdc  as event_vdc,
            e.ward_no  as event_ward_no,
            e.tole  as event_tole,
            YEAR(e.start_date) as event_sd_year, 
            MONTH(e.start_date) as event_sd_month,
            
            COUNT(e.event_id) as count_events,
            GROUP_CONCAT(e.event_code ORDER BY e.event_code ASC SEPARATOR ', ') as csv_event_codes,
            GROUP_CONCAT(e.event_id ORDER BY e.event_id ASC SEPARATOR ', ') as csv_event_ids,
            GROUP_CONCAT(t.participated_in_id ORDER BY t.participated_in_id ASC SEPARATOR ', ') as csv_participated_in_ids
            
                 
		FROM person  p
		LEFT JOIN participated_in t ON p.person_id=t.person_id 
		LEFT JOIN events e on e.event_id = t.event_id
        GROUP BY p.person_id
        ) as r
SQL;

        $sql = $select_str
            .' '. $wh_clause_str
            .' '.$group_by_clause_str
            .' '. $order_by_clause_str
            .' '. $limit_str;

        $query = $this->db->query($sql);

        $reports = $query->result_array();

        return (count($reports) > 0) ? $query->result_array() : FALSE;

    }
}

?>

