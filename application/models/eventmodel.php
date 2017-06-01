<?php

/*
 * @author : Gaurab Dahal 
 */

require_once 'coursemodel.php';
require_once 'personmodel.php';
require_once 'beneficiarytypemodel.php';

//include('nepali_calendar.php');

class eventmodel extends CI_Model
{

    private $courseModel;
    private $personModel;
    private $event_pagination_totalpage;

    private static $db;
    private static $course;

    public $BENEFICIARY_TYPES = [
        1 => "Mason",
        2 => "Engineer",
        3 => "Architect",
        4 => "House Owner",
        5 => "Social Mobilizer",
        6 => "Student",
        7 => "Political Leader",
        8 => "Government Official"
    ];

    public $CERTIFICATION_STATUSES = [
        1 => "Certified",
        2 => "Withheld",
    ];
    public $PARTICIPATION_TYPE = [
        //-->column : is_instructor
        0 => "Participant",
        1 => "Instructor",
        3 => "Asst. Instructor",
    ];
    //private static $courseModel;

//private $cal;
    /*
     * from view :
     * from controller:
     * when : when class first loads
     * why :
     */

    public function getParticipationTypes()
    {
        return $this->PARTICIPATION_TYPE;
    }

    public function getBeneficiaryTypes()
    {
        return $this->BENEFICIARY_TYPES;
    }

    public function getBeneficiaryType($id)
    {
        return $this->beneficiarytypemodel->getBeneficiaryName($id);
        //if(isset($this->BENEFICIARY_TYPES[$id]))
        //return $this->BENEFICIARY_TYPES[$id];
    }

    public function getCertificationStatus($id)
    {
        return $this->certificationstatusmodel->getCertificationStatusName($id);
        //if(isset($this->BENEFICIARY_TYPES[$id]))
        //return $this->BENEFICIARY_TYPES[$id];
    }

    public function getCertificationStatuses()
    {
        return $this->CERTIFICATION_STATUSES;
    }


    public function __construct()
    {
        parent::__construct();
        $this->courseModel = new coursemodel();
        $this->personModel = new personmodel();
        $this->beneficiarytypemodel = new beneficiarytypemodel();
        self::$db = &get_instance()->db;
        self::$course = new coursemodel();
        //self::$courseModel = &get_instance()->courseModel;
// $this->cal = new Nepali_Calendar();
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

    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function deleteEvent($id)
    {
        $array = array('event_id' => $id);
        $success = $this->db->delete('events', $array);
        return $success;
    }


    public function getcurrency()
    {
        $query = $this->db->get("currency_unit");


        if ($query->num_rows() > 0) {
            $i = 0;
            $currency = array();
            foreach ($query->result() as $row) {
                $currency[$i][0] = $row->unit;
                $i++;
            }
        } else {

            $currency = 0;
        }
        return $currency;
    }


    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function deleteParticipants($event_id)
    {
        $array = array('event_id' => $event_id);
        $success = $this->db->delete('participated_in', $array);
        return $success;
    }

    function getShare($event_id)
    {
        $query = $this->db->query("SELECT * FROM event_cost_shares where event_id= " . $event_id . " ORDER BY share Desc");
        $share = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $party = $this->getPartyName($row->party_id);
            $share[$i][0] = $row->id;
            $share[$i][1] = $party; //$this->personModel->getPersonName($row->person_id);
            $share[$i][2] = $row->share;
            $share[$i][3] = $row->party_id;
            $i++;
        }
        return $share;
    }

    function getDirectCost($event_id)
    {
        $query = $this->db->query("SELECT * FROM direct_cost where event_id= " . $event_id . " LIMIT 1");
        $direct_cost_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $direct_cost_array[$i][0] = $row->tdc;
            $direct_cost_array[$i][1] = $row->staff_cost;
            $direct_cost_array[$i][2] = $row->travel_cost;
            $i++;
        }
        if (count($direct_cost_array) == 0) {
            $direct_cost_array[0][0] = 0;
            $direct_cost_array[0][1] = 0;
            $direct_cost_array[0][2] = 0;
        }
        return $direct_cost_array;
    }

    function getInkindContribution($event_id)
    {
        $query = $this->db->query("SELECT * FROM inkind_contribution where event_id= " . $event_id);
        $inkind_contribution_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $inkind_contribution_array[$i][0] = $row->id;
            $inkind_contribution_array[$i][1] = $row->level;
            $inkind_contribution_array[$i][2] = $row->description;
            $inkind_contribution_array[$i][3] = $row->pax;
            $inkind_contribution_array[$i][4] = $row->hour;
            $inkind_contribution_array[$i][5] = $row->rate;
            $inkind_contribution_array[$i][6] = $row->updated_by;
            $inkind_contribution_array[$i][7] = $row->updated_date;
            $i++;
        }
        return $inkind_contribution_array;
    }

//08209146998893
//one line return
    function getPartyName($party_id)
    {
        return $this->db->query("select party from cost_sharing where id=" . $party_id)->row()->party;
    }

    function getAllOrganizers()
    {
        $query = $this->db->query("SELECT * FROM organizer_master");
        $organizer_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $organizer_array[$i][0] = $row->id;
            $organizer_array[$i][1] = $row->organizer;
            $i++;
        }
        return $organizer_array;
    }

    function getMainOrganizer($event_id)
    {
        $query = $this->db->query("SELECT * FROM event_organizer where event_id=" . $event_id);
        $organizer_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $organizer_array[$i][0] = $row->id;
            $organizer_array[$i][1] = $this->getOrganizerName($row->event_organizer_id);
            $organizer_array[$i][2] = $row->event_organizer_id;
            $i++;
        }
        return $organizer_array;
    }

    function getImplementingPartner($event_id)
    {
        $query = $this->db->query("SELECT * FROM event_implementing_partner where event_id=" . $event_id);
        $impl_partner_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $impl_partner_array[$i][0] = $row->id;
            $impl_partner_array[$i][1] = $this->getOrganizerName($row->implementing_partner_id);
            $impl_partner_array[$i][2] = $row->implementing_partner_id;
            $i++;
        }
        return $impl_partner_array;
    }

    function getOrganizerName($organizer_id)
    {
        $query = $this->db->query("select organizer from organizer_master where id=" . $organizer_id);
        if ($query->num_rows() > 0) {
            return $query->row()->organizer;
        } else
            return 'n/a';
    }

    function addEventOrganizer($data)
    {
        $success = $this->db->insert('organizer_master', $data);
        $insert_id = $this->db->insert_id();
        if ($success == 1)
            return $insert_id;
        else
            return 0;
    }

    function updateEventOrganizer($id, $organizer)
    {
        $this->db->where('id', $id);
        $success = $this->db->update('organizer_master', array('organizer' => $organizer));
        return $success;
    }

    public function deleteEventOrganizer($id)
    {
        $array = array('id' => $id);
        $success = $this->db->delete('organizer_master', $array);
        return $success;
    }

    function organizerHasDependents($id)
    {
        $query = $this->db->query(
            "
                    select count(event_organizer_id) as count from event_organizer where event_organizer_id in($id)
                    union
                    select count(implementing_partner_id) as count from event_implementing_partner where implementing_partner_id in($id)            
                "
        );
        $count = 0;
        foreach ($query->result() as $row) {
            $count += intval($row->count);
        }
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getParticipant($event_id, $person_id)
    {
        $participants_array = $this->getAllParticipants($event_id);
        $data = [];
        for ($i = 0; $i < count($participants_array); $i++) {
            if ($participants_array[$i][0] == $person_id) {
                $data = ['event_id' => $event_id, 'participant' => $participants_array[$i], 'i' => $i];
            }
        }
        return $data;
    }

    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function getAllParticipants($event_id)
    {
        $query = $this->db->query("SELECT * FROM participated_in where event_id= " . $event_id . " AND deleted =0 ORDER BY is_instructor DESC");


        $participants_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $person_detail = $this->personModel->getPersonDetail($row->person_id);
            $participants_array[$i][0] = $row->person_id;
            $participants_array[$i][1] = $person_detail[2]; //$this->personModel->getPersonName($row->person_id);
            $participants_array[$i][2] = $row->is_instructor;
            $participants_array[$i][3] = $person_detail[7];
            $participants_array[$i][4] = $person_detail[12];
            $participants_array[$i][5] = $person_detail[11];
            $participants_array[$i][6] = $this->getBeneficiaryType($row->beneficiary_type);//beneficiary_type
            $participants_array[$i][7] = $this->getCertificationStatus($row->certification_status);//beneficiary_type
            $i++;

        }

        return $participants_array;
    }

    function getParticipation($event_id, $person_id)
    {
        $query = $this->db->query("SELECT * FROM participated_in where event_id= " . $event_id . " AND person_id=" . $person_id . " AND deleted =0 ORDER BY is_instructor DESC");
        $row = $query->result()[0];
        return [
            "participated_in_id" => $row->participated_in_id,
            "event_id" => $row->event_id,
            "person_id" => $row->person_id,
            "is_instructor" => $row->is_instructor,
            "deleted" => $row->deleted,
            "certification_status" => $row->certification_status,
            //"certification_code" => $row->certification_code,
            //"certification_date" => $row->certification_date,
            "beneficiary_type" => $row->beneficiary_type,
            //"participation_role" => $row->participation_role,
        ];
    }

    function getAllParticipation($person_id)
    {
        $query = $this->db->query("SELECT * FROM participated_in where person_id=" . $person_id . "  ORDER BY event_id DESC"); // LIMIT " . $start . " , " . $end);


        $count = $count = $query->num_rows();
        $event_array = array();
        $i = 0;

        foreach ($query->result() as $row) {
            $role = '';

            $event_array[$i][0] = $this->getEventTitle($row->event_id); //event

            if ($row->is_instructor == '0') {
                $role = 'Participant';
            }
            if ($row->is_instructor == '1') {
                $role = 'Instructor';
            }
            if ($row->is_instructor == '2') {
                $role = 'Asst. Instructor';
            }
            $event_array[$i][1] = $role; //role

            $event_detail = $this->getEventDetail($row->event_id);
            if (!empty($event_detail)) {
                $event_array[$i][2] = $event_detail[2]; //event year
                $event_array[$i][3] = $event_detail[5]; //start_date
                $event_array[$i][4] = $event_detail[6]; //end date
                $event_array[$i][5] = $event_detail[7]; //venue
                $event_array[$i][6] = $row->event_id; //event_id
                $event_array[$i][7] = $row->participated_in_id;
                $event_array[$i][8] = isset($this->BENEFICIARY_TYPES[$row->beneficiary_type]) ? $this->BENEFICIARY_TYPES[$row->beneficiary_type] : '';
                $i++;
            }


        }
        return $event_array;

    }


//for ajax request
    function getAllCoverageLocation($coverage_level_id)
    {
        $query = $this->db->query("SELECT coverage_location FROM coverage_location where coverage_level=" . $coverage_level_id);
        $result = $query->result();
        return json_encode($result);
    }

//for php request form controller
    public function getCoverageLocation($coverage_level_id, $deleted = 0)
    {
////similar to getAllCoverageLocation($coverage_level_id)
        $sql = "SELECT id,coverage_location FROM coverage_location ";
        if ($coverage_level_id) {
            $sql .= "where coverage_level=" . $coverage_level_id;
        }
        $query = $this->db->query($sql);
        $location_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $location_array[$i][0] = $row->id;
            $location_array[$i][1] = $row->coverage_location;
            $i++;
        }
        return $location_array;
    }


    //for php request form controller
    public function getCourseSubCourses($course_id, $deleted = 0)
    {

        $sql = "SELECT * FROM course_subcategory  WHERE deleted=" . $deleted;

        if ($course_id) {
            $sql .= " AND course_cat_id=" . $course_id;
        }
        $query = $this->db->query($sql);
        $result = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $result[$i][0] = $row->course_subcat_id;
            $result[$i][1] = $row->subcoursename;
            $i++;
        }
        return $result;
    }


    function getEventTitle($event_id)
    {
        $query = $this->db->query("SELECT title FROM events where event_id=" . $event_id . "  LIMIT 1"); // LIMIT " . $start . " , " . $end);
        foreach ($query->result() as $row) {
            return $row->title;
        }
    }

    function getEventCode($event_id)
    {
        $query = $this->db->query("SELECT event_code FROM events where event_id=" . $event_id . "  LIMIT 1"); // LIMIT " . $start . " , " . $end);
        foreach ($query->result() as $row) {
            return $row->event_code;
        }
    }

    function getEventDates($event_id)
    {
        $query = $this->db->query("SELECT year,start_date,end_date,venue FROM events where event_id=" . $event_id . "  LIMIT 1"); // LIMIT " . $start . " , " . $end);
        foreach ($query->result() as $row) {
            return $row->year;
        }
    }

    public static function queryEvents($q = null, $deleted = 0)
    {

        if ($q == null) {
            $query = self::$db->query("SELECT * FROM events  LEFT JOIN course_category ON course_category.course_cat_id = events.course_cat_id where events.deleted=" . $deleted);
        } else {
            $query = self::$db->query("SELECT * FROM events  LEFT JOIN course_category ON course_category.course_cat_id = events.course_cat_id where events.deleted=" . $deleted . " AND course_category.coursename LIKE '%" . self::escape($q) . "%'");
        }
        $event_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $event_array[$i]['event_id'] = $row->event_id;
            $event_array[$i]['title'] = $row->title;
            $event_array[$i]['year'] = $row->year;
            $event_array[$i]['course_name'] = self::$course->getCourseName($row->course_cat_id);
            //$event_array[$i][4] = self::$courseModel->getSubCourseName($row->course_subcat_id);
            $event_array[$i]['venue'] = $row->venue;
            $event_array[$i]['start_date'] = $row->start_date;
            $event_array[$i]['latitude'] = floatval($row->latitude);
            $event_array[$i]['longitude'] = floatval($row->longitude);
            $i++;
        }
        return $event_array;
    }
    /*
      public function getEvent($search_string, $start, $end) {
      $query = '';
      // $query = $this->db->query("SELECT * FROM person WHERE (fullname like '%" . mysql_real_escape_string($search_string) . "%' OR email like '%" . mysql_real_escape_string($search_string) . "%' or mobile like '%" . mysql_real_escape_string($search_string) . "%')  ORDER BY fullname ASC LIMIT " . $start . " , " . $end);
      $query = $this->db->query("SELECT * FROM events WHERE title like '%" . mysql_real_escape_string($search_string) . "%' AND deleted=0  ORDER BY start_date DESC LIMIT " . $start . " , " . $end);
      $count = $query->num_rows();
      $event_array = array();
      $i = 0;
      foreach ($query->result() as $row) {
      $event_array[$i][0] = $row->event_id;
      $event_array[$i][1] = $row->title;
      $event_array[$i][2] = $row->year;
      $event_array[$i][3] = $this->courseModel->getCourseName($row->course_cat_id);
      $event_array[$i][4] = $this->courseModel->getSubCourseName($row->course_subcat_id);
      $event_array[$i][5] = $row->venue;
      $event_array[$i][6] = $row->start_date;
      $i++;
      }
      $this->setPerson_pagination_totalpage($count, ($end - $start));
      return $person_array;
      }
     */
    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */


    public function getEvents($start = null, $end = null, $deleted = 0, $search_string = null)
    {
        if ($search_string == null) {
            $qStr = "SELECT * FROM events where deleted=" . $deleted . " ORDER BY start_date DESC LIMIT " . $start . " , " . $end;
            $query = $this->db->query($qStr);
        } else {
            $qStr = "SELECT * FROM events WHERE title like '%"
                . self::escape($search_string) . "%' AND deleted=0  ORDER BY start_date DESC LIMIT " . $start . " , " . $end;
            $query = $this->db->query($qStr);
            $count = $query->num_rows();
            $this->setEvent_pagination_totalpage($count, ($end - $start));
        }
        $event_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $event_array[$i][0] = $row->event_id;
            $event_array[$i][1] = $row->title;
            $event_array[$i][2] = $row->year;
            $event_array[$i][3] = $this->courseModel->getCourseName($row->course_cat_id);
            $event_array[$i][4] = $this->courseModel->getSubCourseName($row->course_subcat_id);
            $event_array[$i][5] = $row->venue;
            $event_array[$i][6] = $row->start_date;

            $i++;
        }
        return $event_array;
    }

    private function setEvent_pagination_totalpage($rowcount, $howmany)
    {
        $this->event_pagination_totalpage = ceil($rowcount / $howmany);
    }

    public function getEvent_pagination_totalpage()
    {
        return $this->event_pagination_totalpage;
    }

    function getEventDate($event_id, $deleted = 0)
    {
        $this->db->select('event_id');
        $this->db->from('events');
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        return $query->result()[0]['start_date'];

    }

    public function getRowCount_event()
    {
        $this->db->select('event_id');
        $this->db->from('events');
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    public function getTotalPages_event($howmany)
    {
        $total_row = $this->getRowCount_event();
        $pages = ceil($total_row / $howmany);
        return $pages;
    }

    /*
     * from view : people
     * from controller: EventController
     * when : after creating event
     * why : to check if the person with the given detail alredy exists
     */

    public function person_exists($fullname, $dob_en, $dob_np, $mobile, $phone, $citizenship_no)
    {
        $sql = "SELECT * FROM person where fullname like '%" . self::escape($fullname) . "%'
    AND citizenship_no like '%" . self::escape($citizenship_no) . "%'
    AND (dob_en like '%" . self::escape($dob_en) . "%' OR dob_np like '%" . self::escape($dob_np) . "%')
    AND mobile like '%" . self::escape($mobile) . "%' AND phone like '%" . self::escape($phone) .
            "%' LIMIT 100";
        $query = $this->db->query($sql);

        $result = $query->result();
        return json_encode($result);
    }

    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function getEventDetail($event_id)
    {

        $query = $this->db->query("SELECT * FROM events where event_id=" . $event_id . " LIMIT 1");

        $eventDetail_array = array();
        foreach ($query->result() as $row) {
            $eventDetail_array[0] = $row->event_id;
            $eventDetail_array[1] = $row->title;
            $eventDetail_array[2] = $row->year;
            $eventDetail_array[3] = $row->course_cat_id;
            $eventDetail_array[4] = $row->course_subcat_id;
            $eventDetail_array[5] = $row->start_date;
            $eventDetail_array[6] = $row->end_date;
            $eventDetail_array[7] = $row->venue;

            $eventDetail_array[8] = ($row->coverage_level != "") ? $this->getCoverageLevelName($row->coverage_level) : null;

            $eventDetail_array[9] = $row->coverage_location;
            $eventDetail_array[10] = $row->address;
            $eventDetail_array[11] = $row->country;
            $eventDetail_array[12] = $row->coverage_level;
            $eventDetail_array[13] = $row->longitude;
            $eventDetail_array[14] = $row->latitude;
            $eventDetail_array[15] = $row->event_code;
            $eventDetail_array[16] = $row->district;
            $eventDetail_array[17] = $row->vdc;
            $eventDetail_array[18] = $row->ward_no;
// $eventDetail_array[12] = $row->cost_sharing;
        }
        return $eventDetail_array;
    }

    function getCoverageLevelName($coverage_level_id)
    {
        $query=$this->db->query(
            "select coverage_level from coverage_level where coverage_level_id=" . $coverage_level_id
        );
        return ($query->num_rows()>0)?$query->row()->coverage_level:$coverage_level_id;
    }

    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function getRowCount_events($deleted = 0)
    {
        $this->db->select('event_id');
        $this->db->from('events');
        $this->db->where(array('deleted' => $deleted));
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function getTotalPages_events($howmany)
    {
        $total_row = $this->getRowCount_events();
        $pages = ceil($total_row / $howmany);
        return $pages;
    }

    /*
     * from view :
     * from controller: EventController,CourseController
     * when :
     * why :
     */

    public function getSubCourseData($course_id, $deleted = 0)
    {
        $query = $this->db->query("SELECT * FROM course_subcategory where course_cat_id = " . $course_id . " AND deleted=" . $deleted);
        $result = $query->result();
        return json_encode($result);
    }


    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function saveEventData($data, $main_organizers, $impl_partners)
    {
        $success = $this->db->insert('events', $data);
        $insert_id = $this->db->insert_id();
        if ($success == 1) {
            if (count($main_organizers) > 0) {
                $this->saveMainOrganizer($insert_id, $main_organizers);
            }
            if (count($impl_partners) > 0) {
                $this->saveImplPartners($insert_id, $impl_partners);
            }
            return $insert_id;
        } else {
            return 0;
        }
    }

//-------------------------------------------------------------------------------------------------
    function saveBudget($event_id, $csparty_value, $total_direct_cost, $staff_cost, $travel_cost, $unit)
    {
        $directcost_array = array('event_id' => $event_id, 'tdc' => $total_direct_cost, 'staff_cost' => $staff_cost, 'travel_cost' => $travel_cost, 'updated_by' => $this->session->userdata('username'), 'updated_date' => date("Y-m-d H:i:s"));
        $this->saveDirectCost($event_id, $directcost_array);
        $this->saveCostShareData($event_id, $csparty_value);

        $data = array(
            'Budget_unit' => $unit
        );

        $this->db->where('event_id', $event_id);
        $this->db->update('events', $data);

    }

    function saveDirectCost($event_id, $directcost_array)
    {
        $this->deleteDirectCost($event_id);
        $this->db->insert('direct_cost', $directcost_array);
    }

    public function getBudgetCurrency($event_id)
    {
        $this->db->select('Budget_unit');
        $query = $this->db->get_where('events', array('event_id' => $event_id));
        foreach ($query->result() as $row) {
            return $row->Budget_unit;
        }
    }

    function saveCostShareData($event_id, $csparty_value)
    {
        $this->deleteCostShare($event_id);
        for ($z = 0;
             $z < count($csparty_value);
             $z++) {
            if (intval($csparty_value[$z][1]) != 0) {
                $this->db->insert('event_cost_shares', array('event_id' => $event_id, 'party_id' => $csparty_value[$z][0], 'share' => $csparty_value[$z][1]));
            }
        }
    }

    function saveInkindContribution($inkind_contribution_array)
    {
        $success = $this->db->insert('inkind_contribution', $inkind_contribution_array);
        if ($success == 1)
            return $this->db->insert_id();
        else
            return 0;
    }

    function deleteInkindContribution($inkind_id)
    {
        return $this->db->delete('inkind_contribution', array('id' => $inkind_id));
    }

    function deleteCostShare($event_id)
    {
        $array = array('event_id' => $event_id);
        $success = $this->db->delete('event_cost_shares', $array);
        return $success;
    }

    function deleteDirectCost($event_id)
    {
        $array = array('event_id' => $event_id);
        $success = $this->db->delete('direct_cost', $array);
        return $success;
    }

//-----------------------------------------------------------------------------------------------------
    function saveMainOrganizer($event_id, $main_organizers)
    {
        $array = array('event_id' => $event_id);
        $success = $this->db->delete('event_organizer', $array);
        for ($z = 0;
             $z < count($main_organizers);
             $z++) {
            $this->db->insert('event_organizer', array('event_id' => $event_id, 'event_organizer_id' => $main_organizers[$z][0]));
        }
    }

    function saveImplPartners($event_id, $impl_partners)
    {
        $array = array('event_id' => $event_id);
        $success = $this->db->delete('event_implementing_partner', $array);
        for ($z = 0;
             $z < count($impl_partners);
             $z++) {
            $this->db->insert('event_implementing_partner', array('event_id' => $event_id, 'implementing_partner_id' => $impl_partners[$z][0]));
        }
    }

    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function testIfEventExists($data_array)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where($data_array);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count > 0) {
            foreach ($query->result() as $row) {
                return $row->event_id;
            }
        }
        return "0";
    }

    /*
     * from view :
     * from controller: EventController
     * when :
     * why :
     */

    public function updateEventData($data, $event_id, $main_organizers, $impl_partners)
    {
        $this->db->where('event_id', $event_id);
        $success = $this->db->update('events', $data);
        if ($success == 1) {
            if (count($main_organizers) > 0) {
                $this->saveMainOrganizer($event_id, $main_organizers);
            }
            if (count($impl_partners) > 0) {
                $this->saveImplPartners($event_id, $impl_partners);
            }
        }
        return $success;
    }

    /*
      function updateCostShareData($event_id, $csparty_value) {
      if ($this->deleteCostShare($event_id)) {
      for ($z = 0; $z < count($csparty_value); $z++) {
      if (intval($csparty_value[$z][1]) != 0) {
      $this->db->insert('event_cost_shares', array('event_id' => $event_id, 'party_id' => $csparty_value[$z][0], 'share' => $csparty_value[$z][1]));
      }
      }
      }
      }
     */

    function deleteMainOrganizer($event_id)
    {
//deletes all main organizer of implementing partner detail belonging to this event id
        $array = array('event_id' => $event_id);
        $success = $this->db->delete('event_organizer', $array);
        return $success;
    }

    /**
     * Generate GEOJSON from events
     *
     * @param Database_Result|array $events collection of events
     * @return array $json_features geojson features array
     **/
    public static function markers_geojson($events = [], $include_geometries = FALSE)
    {
        $json_features = array();
        $events = self::queryEvents();
        /*$events=[
            [
                'title'=>'Event 1',
                'latitude'=>28.038046419369945,
                'longitude'=>84.38186645507812,
            ],
            [
                'title'=>'Event 2',
                'latitude'=>27.67710543767721,
                'longitude'=>86.07476949691772,
            ],
        ];*/

        foreach ($events as $marker) {

            // Handle both reports::fetch_incidents() response and actual ORM objects
            //$marker->id = isset($marker->event_id) ? $marker->event_id : $marker->id;
            if (isset($marker['latitude']) AND isset($marker['longitude'])) {
                $latitude = $marker['latitude'];
                $longitude = $marker['longitude'];
            } else {
                // No location - skip this report
                continue;
            }

            $json_item = array();
            $json_item['type'] = 'Feature';
            $json_item['properties'] = array(
                'event_id' => $marker['event_id'],
                'title' => $marker['title'],
                'course_name' => $marker['course_name'],

            );
            $json_item['geometry'] = array(
                'type' => 'Point',
                'coordinates' => array($longitude, $latitude)
            );
            array_push($json_features, $json_item);
        }
        return $json_features;
    }

    function getTotalRowsCount($deleted=0)
    {
        return count($this->getRows(
            null,//start
            null,//limit
            $deleted,//deleted
            array()//searchParams
        ));
    }
    function getRows($start = null, $limit = null,$deleted=null, $params = array())
    {
        $deleted=($deleted!=null)?$deleted:0;
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where(array('deleted'=>$deleted));

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('title',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('title',$params['search']['sortBy']);
        }else{
            $this->db->order_by('start_date', 'desc');
        }

        if($start!=null && $limit != null){
            $this->db->limit($limit,$start);
        }elseif($start==null && $limit != null){
            $this->db->limit($limit);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
	
	public function getPreviousRecord($event_id){
		$sql = "select * from events where event_id = (select max(event_id) from events where event_id < $event_id) limit 1";
		$query = $this->db->query($sql);
		$rows = $query->result_array();
       
        return (count($rows) > 0) ? $query->result_array()[0] : FALSE;
	}
	public function getNextRecord($event_id){
		$sql = "select * from events where event_id = (select min(event_id) from events where event_id > $event_id) limit 1";
		$query = $this->db->query($sql);
		$rows = $query->result_array();
        return (count($rows) > 0) ? $query->result_array()[0] : FALSE;
	}
	
	public function getPreviousRecordId($event_id){
		$record = $this->getPreviousRecord($event_id);
		return ($record)?$record['event_id']:null;
	}
	
	public function getNextRecordId($event_id){
		$record = $this->getNextRecord($event_id);
		return ($record)?$record['event_id']:null;
	}
	

	
	function getEventYears($deleted=0){
	    //SELECT DISTINCT YEAR(created) FROM table
        $sql = "select DISTINCT(YEAR(start_date)) as event_year from events where deleted = ".$deleted;
        $query = $this->db->query($sql);
        $rows = $query->result_array();

        return (count($rows) > 0) ? $query->result_array() : FALSE;
    }

    public function getFilteredEvents(
        $start = null,//start-->offset
        $limit = null,//limit-->per_page
        $deleted = null,//deleted
        $params = array()//searchParams
    )
    {


        $limit_str = '';
        if($start != null && $limit!= null){
            $limit_str = " LIMIT ".$start.",".$limit;
        }

        if($start == null && $limit!= null){
            $limit_str = " LIMIT ".$limit;
        }

        $deleted = ($deleted != null) ? $deleted : 0;
        $event_year =(isset($params['event_year']))?$params['event_year']:'';
        $event_month =(isset($params['event_month']))?$params['event_month']:'';
        $event_district =(isset($params['event_district']))?$params['event_district']:'';
        $event_vdc =(isset($params['event_vdc']))?$params['event_vdc']:'';
        $event_ward_no =(isset($params['event_ward_no']))?$params['event_ward_no']:'';
        $keywords =(isset($params['keywords']))?$params['keywords']:'';
        $event_course_cat_id =(isset($params['event_course_cat_id']))?$params['event_course_cat_id']:'';
        //$event_course_cat_id =;//(isset($params['event_course_cat_id']))?$params['event_course_cat_id']:'';


        $order_arr = array(
            'event_start_date desc',
        );
        $order_expr_str = implode(' , ',$order_arr );
        $order_clause_str = ($order_expr_str!='')?' ORDER BY  '.$order_expr_str:'';

        // sort data by ascending or desceding order
        // sortBy 'asc:event_district,event_vdc|desc:person_fullname';
        /*
        if (isset($params['search']['sortBy']) && !empty($params['search']['sortBy'])) {
            $this->db->order_by('title', $params['search']['sortBy']);
        } else {
            $this->db->order_by('start_date', 'desc');
        }
        */

        //||*********************Keywords Joined with OR
        $wh_keywords_expr_arr = array();
        if(isset($keywords) && $keywords!='' && $keywords!=null){
            array_push($wh_keywords_expr_arr,"event_district LIKE '%".$keywords."%'" );
            array_push($wh_keywords_expr_arr,"event_vdc LIKE '%".$keywords."%'" );
            array_push($wh_keywords_expr_arr,"event_ward_no LIKE '%".$keywords."%'" );
            array_push($wh_keywords_expr_arr,"event_address LIKE '%".$keywords."%'" );
            array_push($wh_keywords_expr_arr,"event_venue LIKE '%".$keywords."%'" );
            array_push($wh_keywords_expr_arr,"event_code LIKE '%".$keywords."%'" );
            array_push($wh_keywords_expr_arr,"event_title LIKE '%".$keywords."%'" );
        }
        $wh_keywords_expr_str = implode(' OR ',$wh_keywords_expr_arr );
        $wh_keywords_expr_str=(''!=$wh_keywords_expr_str)?'('.$wh_keywords_expr_str.')':$wh_keywords_expr_str;
        //||END*********************Keywords

        //||*********************Fields Joined with AND
        $wh_params_expr_arr = array();
        if(isset($deleted) && $deleted!='' && $deleted!=null){
            array_push($wh_params_expr_arr,"event_deleted = '".$deleted."'" );
            array_push($wh_params_expr_arr,"person_deleted = '".$deleted."'" );
            array_push($wh_params_expr_arr,"participation_deleted = '".$deleted."'" );
        }

        if(isset($event_month) && $event_month!='' && $event_month!=null){
            array_push($wh_params_expr_arr,"event_sd_month = ".$event_month );
        }
        if(isset($event_year) && $event_year!='' && $event_year!=null){
            array_push($wh_params_expr_arr,"event_sd_year = ".$event_year );
        }
        if(isset($event_course_cat_id) && $event_course_cat_id!='' && $event_course_cat_id!=null){
            array_push($wh_params_expr_arr,"event_course_cat_id = ".$event_course_cat_id );
        }

        if(isset($event_district) && $event_district!='' && $event_district!=null){
            array_push($wh_params_expr_arr,"event_district = '".$event_district."'" );
        }
        if(isset($event_vdc) && $event_vdc!='' && $event_vdc!=null){
            array_push($wh_params_expr_arr,"event_vdc = '".$event_vdc."'" );
        }if(isset($event_ward_no) && $event_ward_no!='' && $event_ward_no!=null){
        array_push($wh_params_expr_arr,"event_ward_no = '".$event_ward_no."'" );
    }

        $wh_params_expr_str = implode(' AND ',$wh_params_expr_arr );
        $wh_params_expr_str=(''!=$wh_params_expr_str)?'('.$wh_params_expr_str.')':$wh_params_expr_str;
        //||END *********************Fields

        $wh_clause_expr_arr = array();
        if($wh_params_expr_str!=''){
            array_push($wh_clause_expr_arr,$wh_params_expr_str);
        }
        if($wh_keywords_expr_str!=''){
            array_push($wh_clause_expr_arr,$wh_keywords_expr_str);
        }
        $wh_clause_expr_str = implode(' AND ',$wh_clause_expr_arr);
        $wh_clause_str = ($wh_clause_expr_str!='')?'WHERE '.$wh_clause_expr_str:'';

        $select_str = <<<SQL
		SELECT 
		agg.*,
		 COUNT(participation_person_id) as total_participants
		, SUM(CASE  WHEN person_gender = 'male'  THEN 1 ELSE 0 END) as gender_male
		, SUM(CASE  WHEN person_gender = 'female'  THEN 1 ELSE 0 END) as gender_female
		, SUM(CASE  WHEN person_gender  = 'other'  THEN 1 ELSE 0 END) as gender_other
		
		, SUM(CASE  WHEN participation_person_age BETWEEN 0 AND 14  THEN 1 ELSE 0 END) as age_below_14
		,SUM(CASE  WHEN participation_person_age BETWEEN 15 AND 19  THEN 1 ELSE 0 END) as age_15_19
		,SUM(CASE  WHEN participation_person_age BETWEEN 20 AND 24 THEN 1 ELSE 0 END) as age_20_24
		,SUM(CASE  WHEN  participation_person_age BETWEEN 25 AND 29 THEN 1 ELSE 0 END) as age_25_29
		,SUM(CASE WHEN participation_person_age BETWEEN 30 AND 34 THEN 1 ELSE 0 END) as age_30_34
		,SUM(CASE WHEN participation_person_age>=35 THEN 1 ELSE 0 END) as age_35_above

		,SUM(CASE WHEN person_work_type_id=91 THEN 1 ELSE 0 END) as 'Other'
		,SUM(CASE WHEN person_work_type_id=23 THEN 1 ELSE 0 END) as 'Daily Wages'
		,SUM(CASE WHEN person_work_type_id=22 THEN 1 ELSE 0 END) as 'Business'
		,SUM(CASE WHEN person_work_type_id=19 THEN 1 ELSE 0 END) as 'Student'
		,SUM(CASE WHEN person_work_type_id=17 THEN 1 ELSE 0 END) as 'Service'
		,SUM(CASE WHEN person_work_type_id=15 THEN 1 ELSE 0 END) as 'Housewife'
		,SUM(CASE WHEN person_work_type_id=35 THEN 1 ELSE 0 END) as 'Agriculture'
		,SUM(CASE WHEN person_work_type_id=90 THEN 1 ELSE 0 END) as 'Sub/Asst. engineers'
		,SUM(CASE WHEN person_work_type_id=89 THEN 1 ELSE 0 END) as 'Contractors'
		,SUM(CASE WHEN person_work_type_id=88 THEN 1 ELSE 0 END) as 'Architects'
		,SUM(CASE WHEN person_work_type_id=87 THEN 1 ELSE 0 END) as 'Engineers'
		
		
		,SUM(CASE WHEN participation_beneficiary_type=11 THEN 1 ELSE 0 END) as 'House Owner'
		,SUM(CASE WHEN participation_beneficiary_type=28 THEN 1 ELSE 0 END) as 'Non House Owner'
		,SUM(CASE WHEN participation_beneficiary_type=23 THEN 1 ELSE 0 END) as 'Existing Mason'
		,SUM(CASE WHEN participation_beneficiary_type=24 THEN 1 ELSE 0 END) as 'New Mason'
		
	 FROM (
		SELECT et.*, 
		p.deleted as person_deleted, p.work_type_id as person_work_type_id, p.fullname as person_fullname, p.dob_en as person_dob_en, p.gender as person_gender, p.p_address as person_p_address, p.c_address as person_c_address, p.photo as person_photo,p.country as person_country, p.phone as person_phone, p.mobile as person_mobile 
		FROM (SELECT YEAR(e.start_date) as event_sd_year, MONTH(e.start_date) as event_sd_month,  e.deleted as event_deleted, e.event_id as event_event_id, e.title as event_title, e.course_cat_id as event_course_cat_id, e.district as event_district, e.vdc as event_vdc,e.ward_no as event_ward_no, e.year as event_year,e.start_date as event_start_date,e.end_date as event_end_date,e.venue as event_venue,e.address as event_address, e.latitude as event_latitude,e.longitude as event_longitude, e.event_code,
t.deleted as participation_deleted, t.person_id as participation_person_id, t.person_age as participation_person_age, t.is_instructor as participation_is_instructor,t.beneficiary_type as participation_beneficiary_type,t.certification_status as participation_certification_status
FROM events  e LEFT JOIN participated_in t ON e.event_id = t.event_id) AS et LEFT JOIN person p ON p.person_id  = et.participation_person_id
) as agg 
SQL;


        $sql =$select_str.' '.$wh_clause_str.' '.' GROUP BY event_event_id '.' '.$order_clause_str.' '.$limit_str;

        $query = $this->db->query($sql);

        $reports = $query->result_array();

        return (count($reports) > 0) ? $query->result_array() : FALSE;

    }
}


?>


