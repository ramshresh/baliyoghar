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


        return $this->db->query("select coverage_level from coverage_level where coverage_level_id=" . $coverage_level_id)->row()->coverage_level;
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
	

	
	
}

?>


