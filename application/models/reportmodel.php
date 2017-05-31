<?php

class ReportModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('beneficiarytypemodel');


    }

    /* people report */

    public function getPersonDetailReport()
    {
        $query = $this->db->query("SELECT * FROM person");
        $peoplereport_array = array();

        $total_people = 0;
        $male = 0;
        $female = 0;
        $other = 0;
        $above30 = 0;
        $below30 = 0;
        $active = 0;
        $retired = 0;
        $outsideCountry = 0;
        $insideCountry = 0;
        $death = 0;
        foreach ($query->result() as $row) {

            $total_people++;

            if (strtoupper($row->gender) == 'MALE')
                $male++;
            else if (strtoupper($row->gender) == 'FEMALE')
                $female++;
            else
                $other++;

            $time = abs(strtotime($row->dob) - strtotime(date("Y-m-d")));
            $year = floor($time / (365 * 60 * 60 * 24)) == $time / (365 * 60 * 60 * 24) ? floor($time / (365 * 60 * 60 * 24)) : floor($time / (365 * 60 * 60 * 24)) + 1;
            if ($year > 30)
                $above30++;
            else if ($year < 30)
                $below30++;

            if (strtoupper($row->current_status) == 'ACTIVE')
                $active++;
            else if (strtoupper($row->current_status) == 'RETIRED')
                $retired++;
            else if (strtoupper($row->current_status) == 'MIGRATED WITHIN COUNTRY')
                $insideCountry++;
            else if (strtoupper($row->current_status) == 'MIGRATED OUTSIDE COUNTRY')
                $outsideCountry++;
            else if (strtoupper($row->current_status) == 'DEATH')
                $death++;
        }
        $peoplereport_array[0] = $total_people;
        $peoplereport_array[1] = $male;
        $peoplereport_array[2] = $female;
        $peoplereport_array[3] = $other;
        $peoplereport_array[4] = $above30;
        $peoplereport_array[5] = $below30;
        $peoplereport_array[6] = $active;
        $peoplereport_array[7] = $retired;
        $peoplereport_array[8] = $insideCountry;
        $peoplereport_array[9] = $outsideCountry;
        $peoplereport_array[10] = $death;
        return $peoplereport_array;
    }

    function getSummaryReport($from_date, $to_date, $coverage, $location, $event_type, $course)
    {

        $sql = '';
        /*    $sql = "select count(*) as num,e.course_cat_id,c.coursename ,
                            (
                            select count(p.person_ID) from person p
                            inner join participated_in pt on p.person_ID = pt.person_ID
                            inner join events  ev on ev.event_id=pt.event_id
                            where p.Gender = 'Male'
                            and pt.is_instructor=0
                            and ev.course_cat_id=e.course_cat_id

                            ) as Male,
                            (
                            select count(p.person_ID) from person p
                            inner join participated_in pt on p.person_ID = pt.person_ID
                            inner join events  ev on ev.event_id=pt.event_id
                            where p.Gender = 'Female'
                            and pt.is_instructor=0
                           and ev.course_cat_id=e.course_cat_id

                            ) as Female
                        FROM events as e inner join course_category c
                        on e.course_cat_id = c.course_cat_id where ";

            $sql .= trim($from_date) == '' ? " e.start_date >='1901-01-01'" : " e.start_date >='" . $from_date . "'";
            $sql .= trim($to_date) == '' ? " && e.end_date <='2099-01-01'" : " && e.end_date <='" . $to_date . "'";
            $sql .= trim($coverage) == '' ? '' : ' && e.coverage_level=' . $coverage;
            $sql .= trim($location) == '' ? '' : " && e.coverage_location='" . $location . "'";
            $sql .= trim($event_type) == '' ? '' : ' &&  e.course_cat_id=' . $event_type;
            $sql .= trim($course) == '' ? '' : ' && e.course_subcat_id=' . $course;
    */
        $sql = '';
        $sql = "select count(*) as num,e.course_cat_id,c.coursename , ";
        $sql .= "( ";
        $sql .= "   select count(p.person_ID) from person p ";
        $sql .= "   inner join participated_in pt on p.person_ID = pt.person_ID ";
        $sql .= "   inner join events  ev on ev.event_id=pt.event_id ";
        $sql .= "   where p.Gender = 'Male'  ";
        $sql .= "   and pt.is_instructor=0 ";
        $sql .= "   and ev.course_cat_id=e.course_cat_id  ";
        $sql .= trim($from_date) == '' ? " and ev.start_date >='1901-01-01'" : " and ev.start_date >='" . $from_date . "'";
        $sql .= trim($to_date) == '' ? " AND ev.end_date <='2099-01-01'" : " AND ev.end_date <='" . $to_date . "'";
        $sql .= trim($coverage) == '' ? '' : ' AND ev.coverage_level=' . $coverage;
        $sql .= trim($location) == '' ? '' : " AND ev.coverage_location='" . $location . "'";
        $sql .= trim($event_type) == '' ? '' : ' AND  ev.course_cat_id=' . $event_type;
        $sql .= trim($course) == '' ? '' : ' AND ev.course_subcat_id=' . $course;

        $sql .= ") as Male, ";
        $sql .= "( ";
        $sql .= "   select count(p.person_ID) from person p ";
        $sql .= "   inner join participated_in pt on p.person_ID = pt.person_ID ";
        $sql .= "   inner join events  ev on ev.event_id=pt.event_id ";
        $sql .= "   where p.Gender = 'Female'  ";
        $sql .= "   and pt.is_instructor=0  ";
        $sql .= "   and ev.course_cat_id=e.course_cat_id  ";
        $sql .= trim($from_date) == '' ? " and ev.start_date >='1901-01-01'" : " and ev.start_date >='" . $from_date . "'";
        $sql .= trim($to_date) == '' ? " AND ev.end_date <='2099-01-01'" : " AND ev.end_date <='" . $to_date . "'";
        $sql .= trim($coverage) == '' ? '' : ' AND ev.coverage_level=' . $coverage;
        $sql .= trim($location) == '' ? '' : " AND ev.coverage_location='" . $location . "'";
        $sql .= trim($event_type) == '' ? '' : ' AND  ev.course_cat_id=' . $event_type;
        $sql .= trim($course) == '' ? '' : ' AND ev.course_subcat_id=' . $course;
        $sql .= ") as Female ";
        $sql .= "FROM events as e inner join course_category c ";
        $sql .= "on e.course_cat_id = c.course_cat_id where ";
        $sql .= trim($from_date) == '' ? "  e.start_date >='1901-01-01'" : "  e.start_date >='" . $from_date . "'";
        $sql .= trim($to_date) == '' ? " AND e.end_date <='2099-01-01'" : " AND e.end_date <='" . $to_date . "'";
        $sql .= trim($coverage) == '' ? '' : ' AND e.coverage_level=' . $coverage;
        $sql .= trim($location) == '' ? '' : " AND e.coverage_location='" . $location . "'";
        $sql .= trim($event_type) == '' ? '' : ' AND  e.course_cat_id=' . $event_type;
        $sql .= trim($course) == '' ? '' : ' AND e.course_subcat_id=' . $course;

        $sql .= " group by e.course_cat_id";


        $query = $this->db->query($sql);

        $count = $query->num_rows();
        if ($count >= 1) {
            //$summary_report = array();
            $summary_array = array();
            $i = 0;
            foreach ($query->result() as $row) {
                $summary_array[$i][0] = $row->course_cat_id;
                $event_type_detailed_report = $this->getEventReportByCourseId($row->course_cat_id, $from_date, $to_date, $coverage, $location, $event_type, $course);
                //  if ($this->eventTypeHasCourse($row->course_cat_id)) {
                //          $course_detailed_report = $this->getEventReportBySubcourseId($row->course_cat_id);
                //      }
                $summary_array[$i][1] = $row->coursename;
                $summary_array[$i][2] = $row->num;
                $summary_array[$i][3] = $row->Male;
                $summary_array[$i][4] = $row->Female;
                $summary_array[$i][5] = $event_type_detailed_report;
                $i++;
            }
            return $summary_array;
        } else {
            return 0;
        }
    }

    function getEventReportByCourseId($course_cat_id, $from_date, $to_date, $coverage, $location, $event_type, $course)
    {
        $sql = '';
        //   $sql = "select e.title,e.start_date,e.end_date,e.year,c.coursename ,cc.subcoursename,
        $sql = "select e.title,e.start_date,e.end_date,e.year,c.coursename ,
                        (
                        select count(p.person_ID) from person p
                        inner join participated_in pt on p.person_ID = pt.person_ID
                        where p.Gender = 'Male' 
                        and pt.is_instructor=0
                        and e.course_cat_id = c.course_cat_id
                        and e.Event_ID = pt.Event_ID
                        ) as Male,
                        (
                        select count(p.person_ID) from person p
                        inner join participated_in pt on p.person_ID = pt.person_ID
                        where p.Gender = 'Female' 
                        and pt.is_instructor=0 
                        and e.course_cat_id = c.course_cat_id
                        and e.Event_ID = pt.Event_ID
                        ) as Female ,
                       (
                        select count(p.person_ID) from person p
                        inner join participated_in pt on p.person_ID = pt.person_ID
                        where pt.is_instructor=1 
                        and e.course_cat_id = c.course_cat_id
                        and e.Event_ID = pt.Event_ID
                        ) as Instructor,
                        (
                        select count(p.person_ID) from person p
                        inner join participated_in pt on p.person_ID = pt.person_ID
                        where pt.is_instructor=2 
                        and e.course_cat_id = c.course_cat_id
                        and e.Event_ID = pt.Event_ID
                        ) as Asst_Instructor 
                    FROM events as e inner join course_category c
                    on e.course_cat_id = c.course_cat_id where (e.course_subcat_id=0 || course_subcat_id=null) &&";
//                    inner join course_subcategory cc 
//                    on c.course_cat_id = cc.course_cat_id


        $sql .= trim($from_date) == '' ? " e.start_date >='1901-01-01'" : " e.start_date >='" . $from_date . "'";
        $sql .= trim($to_date) == '' ? " && e.end_date <='2099-01-01'" : " && e.end_date <='" . $to_date . "'";
        $sql .= trim($coverage) == '' ? '' : ' && e.coverage_level=' . $coverage;
        $sql .= trim($location) == '' ? '' : " && e.coverage_location='" . $location . "'";
        $sql .= trim($course_cat_id) == '' ? '' : ' &&  e.course_cat_id=' . $course_cat_id;
        $sql .= trim($course) == '' ? '' : ' && e.course_subcat_id=' . $course;

        // $sql .= " group by e.event_title";
        $query = $this->db->query($sql);
        $report = array();
        $i = 0;
        foreach ($query->result() as $row) {

            $report[$i][0] = $row->title;
            $report[$i][1] = $row->start_date;
            $report[$i][2] = $row->end_date;
            $report[$i][3] = $row->year;
            $report[$i][4] = $row->coursename;
            $report[$i][5] = $row->Male;
            $report[$i][6] = $row->Female;
            $report[$i][7] = $row->Instructor;
            $report[$i][8] = $row->Asst_Instructor;
            //   $report[$i][9] = $row->subcoursename;

            $i++;
        }
        return $report;
    }

    public function getsubcatReport($from_date, $to_date, $coverage, $location, $event_type, $course)
    {
        $sql = "select distinct(event_id) as event_id  FROM events as e inner join course_category c
                    on e.course_cat_id = c.course_cat_id where (course_subcat_id !=0 || course_subcat_id !=null) &&";

        $sql .= trim($from_date) == '' ? " e.start_date >='1901-01-01'" : " e.start_date >='" . $from_date . "'";
        $sql .= trim($to_date) == '' ? " && e.end_date <='2099-01-01'" : " && e.end_date <='" . $to_date . "'";
        $sql .= trim($coverage) == '' ? '' : ' && e.coverage_level=' . $coverage;
        $sql .= trim($location) == '' ? '' : " && e.coverage_location='" . $location . "'";
        $sql .= trim($event_type) == '' ? '' : ' &&  e.course_cat_id=' . $event_type;
        $sql .= trim($course) == '' ? '' : ' && e.course_subcat_id=' . $course;
        $query = $this->db->query($sql);
        $count = $query->num_rows();

        $event_ids = ' ';
        if ($count >= 1) {
            //$summary_report = array();

            $i = 0;
            foreach ($query->result() as $row) {
                $event_ids .= $row->event_id . ' , ';
            }

            $event_ids = substr($event_ids, 0, strlen($event_ids) - 2);
        }

        if (trim($event_ids) == '') {
            $event_ids = 0;
        }


        $sql = "select course_cat_id,course_subcat_id,title,start_date,end_date,year,(select subcoursename from course_subcategory where course_subcat_id=e.course_subcat_id)  as coursename,
(select count(*) from participated_in pi inner join person p on pi.person_id=p.person_id where gender='Male' and pi.event_id=e.event_id and pi.is_instructor=0 ) as 'male',
(select count(*) from participated_in pi inner join person p on pi.person_id=p.person_id where gender='Female' and pi.event_id=e.event_id and pi.is_instructor=0 ) as 'female',
(select count(*) from participated_in pi inner join person p on pi.person_id=p.person_id where pi.event_id=e.event_id and pi.is_instructor=1 ) as 'instructor',
(select count(*) from participated_in pi inner join person p on pi.person_id=p.person_id where pi.event_id=e.event_id and pi.is_instructor=2 ) as 'assistant_instructor'
 from
events e where event_id in (" . $event_ids . ") order by course_cat_id,course_subcat_id";
        $query = $this->db->query($sql);
        $report = array();
        $i = 0;

        foreach ($query->result() as $row) {
            $report[$i][0] = $row->title;
            $report[$i][1] = $row->course_cat_id;
            $report[$i][2] = $row->course_subcat_id;
            $report[$i][3] = $row->start_date;
            $report[$i][4] = $row->end_date;
            $report[$i][5] = $row->male;
            $report[$i][6] = $row->female;
            $report[$i][7] = $row->instructor;
            $report[$i][10] = $row->assistant_instructor;
            $report[$i][8] = $row->coursename;
            $report[$i][9] = $row->year;
            //   $report[$i][9] = $row->subcoursename;

            $i++;
        }
        return $report;
    }


///////////////////////////////////////////////////////////////////////////////////
///////////////////// raj le banayeko model function haru /////////////////////////
///////////////////////////////////////////////////////////////////////////////////
    ///////\\\\\\
    ///\\\
    //\/\\


    public function search_by_name($name)
    {

        $query = $this->db->query("SELECT * FROM person where fullname like '" . $name . "%'");
//$this->db->get('person');
//$this->db->from('person');
//$this->db->like('fullname',$name,'after');
//$query=$this->db->get('person');
        $count = $query->num_rows();

        if ($count >= 1) {
            $data = array();
            $i = 0;
            foreach ($query->result() as $row) {

                if ($row->mobile != '') {
                    $phone = 'M :' . $row->mobile;
                } else if ($row->phone != '') {
                    $phone = 'H :' . $row->phone;
                } else if ($row->org_phone != '') {
                    $phone = 'O :' . $row->org_phone;
                } else {
                    $phone = 'n/a';
                }
                $data[$i]['name'] = $row->fullname;
                $data[$i]['address'] = $row->p_address;
                $data[$i]['dob'] = $row->dob_en;
                $data[$i]['phone'] = $phone;
                $data[$i]['status'] = $row->current_status;
                $data[$i]['id'] = $row->person_id;
                $i = $i + 1;
            }
            return $data;
        } else {
            return 0;
        }
    }

    public function get_report_by_coverage($from, $to, $coverage, $location, $event_type, $course)
    {
        $string = "SELECT * FROM person where person_id  in (select person_id from participated_in p inner join events e on p.event_id=e.event_id ";

        $wherecondition = "where ";
        if (strlen(trim($from)) > 0 && strlen(trim($to)) > 0) {

            $wherecondition .= "e.start_date >='" . $from . "' && e.end_date <='" . $to . "' &&";
        } elseif (strlen(trim($from)) > 0 && strlen(trim($to)) == 0) {
            $wherecondition .= "e.start_date >='" . $from . "' &&";
        } elseif (strlen(trim($from)) == 0 && strlen(trim($to)) > 0) {
            $wherecondition .= "e.end_date <='" . $to . "' &&";
        }

        if (trim($coverage) != '') {
            $wherecondition .= " coverage_level='" . $coverage . "' &&";
        }

        if (trim($location) != '') {
            $wherecondition .= " coverage_location='" . $location . "' &&";
        }

        if (trim($event_type) != '') {
            $wherecondition .= " course_cat_id='" . $event_type . "' &&";
        }

        if (trim($course) != '') {
            $wherecondition .= " course_subcat_id='" . $course . "' &&";
        }

        if (strlen($wherecondition) > 6) {
            $wherecondition = substr($wherecondition, 0, strlen($wherecondition) - 2);
        } else {
            $wherecondition = "";
        }

        $string .= $wherecondition . " )";

        $query = $this->db->query($string);

        $male = 0;
        $female = 0;
        $i = 0;
        $coveragereport_array = array();

        foreach ($query->result() as $row) {
            if (strtoupper($row->gender) == 'MALE') {
                $male++;
            } elseif (strtoupper($row->gender) == 'FEMALE') {
                $female++;
            }

            $coveragereport_array[$i]['id'] = $row->person_id;
            $coveragereport_array[$i]['fullname'] = $row->title . ' ' . $row->fullname;
            $coveragereport_array[$i]['address'] = $row->p_address;
            $coveragereport_array[$i]['dob_en'] = $row->dob_en;
            $coveragereport_array[$i]['dob_np'] = $row->dob_np;
            $coveragereport_array[$i]['phone'] = $row->phone;
            $coveragereport_array[$i]['status'] = $row->current_status;
            $coveragereport_array[$i]['gender'] = $row->gender;
            $coveragereport_array[$i]['org_name'] = $row->org_name;
            $coveragereport_array[$i]['org_address'] = $row->org_address;
            $coveragereport_array[$i]['org_phone'] = $row->org_phone;
            $coveragereport_array[$i]['totalmale'] = $male;
            $coveragereport_array[$i]['totalfemale'] = $female;
            $i++;
        }

        return $coveragereport_array;
    }

//{{{
    public function get_report_by_beneficiary($from, $to, $coverage, $location, $event_type, $course)
    {
        $report_array = [];
        $string = "SELECT event_id,title,start_date,end_date from events ";

        $wherecondition = "where ";
        if (strlen(trim($from)) > 0 && strlen(trim($to)) > 0) {

            $wherecondition .= "start_date >='" . $from . "' && end_date <='" . $to . "' &&";
        } elseif (strlen(trim($from)) > 0 && strlen(trim($to)) == 0) {
            $wherecondition .= "start_date >='" . $from . "' &&";
        } elseif (strlen(trim($from)) == 0 && strlen(trim($to)) > 0) {
            $wherecondition .= "end_date <='" . $to . "' &&";
        }

        if (trim($coverage) != '') {
            $wherecondition .= " coverage_level='" . $coverage . "' &&";
        }

        if (trim($location) != '') {
            $wherecondition .= " coverage_location='" . $location . "' &&";
        }

        if (trim($event_type) != '') {
            $wherecondition .= " course_cat_id='" . $event_type . "' &&";
        }

        if (trim($course) != '') {
            $wherecondition .= " course_subcat_id='" . $course . "' &&";
        }

        if (strlen($wherecondition) > 6) {
            $wherecondition = substr($wherecondition, 0, strlen($wherecondition) - 2);
        } else {
            $wherecondition = "";
        }

        $string .= $wherecondition;


        $query = $this->db->query($string);

        $i = 0;

        //$group_beneficiary_types[$i] = [];

        foreach ($query->result() as $row) {
            $total = 0;
            $total_arr = [];
            $report_array[$i]['event_id'] = $row->event_id;
            $report_array[$i]['title'] = $row->title;
            $report_array[$i]['start_date'] = $row->start_date;
            $report_array[$i]['end_date'] = $row->end_date;

            $string1 = 'select beneficiary_type from person p inner join participated_in pi on p.person_id=pi.person_id where pi.is_instructor=0 && pi.event_id=' . $row->event_id;

            $query1 = $this->db->query($string1);
            $count = $query1->num_rows();


            if ($count > 0) {

                foreach ($query1->result() as $row1) {

                    $beneficiary_name = $this->beneficiarytypemodel->getBeneficiaryName($row1->beneficiary_type);

                    if (!isset($total_arr[$beneficiary_name])) {
                        //$group_beneficiary_types[$i][$row->beneficiary_type] =1;
                        $total_arr[$beneficiary_name] = 1;
                    } else {
                        $total_arr[$beneficiary_name] += 1;
                        //$group_beneficiary_types[$i][$row->beneficiary_type] =1;
                    }
                    $total++;
                    $total_arr['total'] = $total;
                }
            }

            $report_array[$i] = array_merge($report_array[$i], $total_arr);

            $i++;
        }

        return $report_array;
    }

//}}}
    public function get_report_by_caste($from, $to, $coverage, $location, $event_type, $course)
    {
        $castereport_array = [];
        $string = "SELECT event_id,title,start_date,end_date from events ";

        $wherecondition = "where ";
        if (strlen(trim($from)) > 0 && strlen(trim($to)) > 0) {

            $wherecondition .= "start_date >='" . $from . "' && end_date <='" . $to . "' &&";
        } elseif (strlen(trim($from)) > 0 && strlen(trim($to)) == 0) {
            $wherecondition .= "start_date >='" . $from . "' &&";
        } elseif (strlen(trim($from)) == 0 && strlen(trim($to)) > 0) {
            $wherecondition .= "end_date <='" . $to . "' &&";
        }

        if (trim($coverage) != '') {
            $wherecondition .= " coverage_level='" . $coverage . "' &&";
        }

        if (trim($location) != '') {
            $wherecondition .= " coverage_location='" . $location . "' &&";
        }

        if (trim($event_type) != '') {
            $wherecondition .= " course_cat_id='" . $event_type . "' &&";
        }

        if (trim($course) != '') {
            $wherecondition .= " course_subcat_id='" . $course . "' &&";
        }

        if (strlen($wherecondition) > 6) {
            $wherecondition = substr($wherecondition, 0, strlen($wherecondition) - 2);
        } else {
            $wherecondition = "";
        }

        $string .= $wherecondition;


        $query = $this->db->query($string);

        $i = 0;
        $agereport_array = array();

        foreach ($query->result() as $row) {
            $total = 0;

            $totalCaste_1 = 0;
            $totalCaste_2 = 0;
            $totalCaste_3 = 0;
            $totalCaste_4 = 0;
            $totalCaste_5 = 0;
            $totalCaste_6 = 0;


            $castereport_array[$i]['event_id'] = $row->event_id;
            $castereport_array[$i]['title'] = $row->title;
            $castereport_array[$i]['start_date'] = $row->start_date;
            $castereport_array[$i]['end_date'] = $row->end_date;

            $string1 = 'select gender,caste_ethnicity,person_age from person p inner join participated_in pi on p.person_id=pi.person_id where pi.is_instructor=0 && pi.event_id=' . $row->event_id;
            $query1 = $this->db->query($string1);
            $count = $query1->num_rows();

            if ($count > 0) {
                foreach ($query1->result() as $row1) {
                    switch ($row1->caste_ethnicity) {
                        case '1':
                            $totalCaste_1++;
                            break;
                        case '2':
                            $totalCaste_2++;
                            break;
                        case '3':
                            $totalCaste_3++;
                            break;
                        case '4':
                            $totalCaste_4++;
                            break;
                        case '5':
                            $totalCaste_5++;
                            break;
                        case '6':
                            $totalCaste_6++;
                            break;
                        default:
                            break;
                    }
                    $total++;
                }
            }

            $castereport_array[$i]['total'] = $total;
            $castereport_array[$i]['1'] = $totalCaste_1;
            $castereport_array[$i]['2'] = $totalCaste_2;
            $castereport_array[$i]['3'] = $totalCaste_3;
            $castereport_array[$i]['4'] = $totalCaste_4;
            $castereport_array[$i]['5'] = $totalCaste_5;
            $castereport_array[$i]['6'] = $totalCaste_6;

            $i++;
        }


        //return $agereport_array;
        return $castereport_array;
    }


    public function get_report_by_age($from, $to, $coverage, $location, $event_type, $course)
    {
        $string = "SELECT event_id,title,start_date,end_date from events ";

        $wherecondition = "where ";
        if (strlen(trim($from)) > 0 && strlen(trim($to)) > 0) {

            $wherecondition .= "start_date >='" . $from . "' && end_date <='" . $to . "' &&";
        } elseif (strlen(trim($from)) > 0 && strlen(trim($to)) == 0) {
            $wherecondition .= "start_date >='" . $from . "' &&";
        } elseif (strlen(trim($from)) == 0 && strlen(trim($to)) > 0) {
            $wherecondition .= "end_date <='" . $to . "' &&";
        }

        if (trim($coverage) != '') {
            $wherecondition .= " coverage_level='" . $coverage . "' &&";
        }

        if (trim($location) != '') {
            $wherecondition .= " coverage_location='" . $location . "' &&";
        }

        if (trim($event_type) != '') {
            $wherecondition .= " course_cat_id='" . $event_type . "' &&";
        }

        if (trim($course) != '') {
            $wherecondition .= " course_subcat_id='" . $course . "' &&";
        }

        if (strlen($wherecondition) > 6) {
            $wherecondition = substr($wherecondition, 0, strlen($wherecondition) - 2);
        } else {
            $wherecondition = "";
        }

        $string .= $wherecondition;


        $query = $this->db->query($string);

        $i = 0;
        $agereport_array = array();

        foreach ($query->result() as $row) {

            $totalmale = 0;
            $totalfemale = 0;
            $total = 0;
            $less_than_20 = 0;
            $between_21_30 = 0;
            $between_31_40 = 0;
            $between_41_50 = 0;
            $between_51_60 = 0;
            $more_than_60 = 0;

            $agereport_array[$i]['event_id'] = $row->event_id;
            $agereport_array[$i]['title'] = $row->title;
            $agereport_array[$i]['start_date'] = $row->start_date;
            $agereport_array[$i]['end_date'] = $row->end_date;

            $string1 = 'select gender,person_age from person p inner join participated_in pi on p.person_id=pi.person_id where pi.is_instructor=0 && pi.event_id=' . $row->event_id;
            $query1 = $this->db->query($string1);
            $count = $query1->num_rows();
            if ($count > 0) {
                foreach ($query1->result() as $row1) {

                    $total++;

                    if (strtoupper($row1->gender) == 'MALE') {
                        $totalmale++;
                    }

                    if (strtoupper($row1->gender) == 'FEMALE') {
                        $totalfemale++;
                    }

                    if ($row1->person_age < 20) {
                        $less_than_20++;
                    } elseif ($row1->person_age > 20 && $row1->person_age <= 30) {
                        $between_21_30++;
                    } elseif ($row1->person_age > 30 && $row1->person_age <= 40) {
                        $between_31_40++;
                    } elseif ($row1->person_age > 40 && $row1->person_age <= 50) {
                        $between_41_50++;
                    } elseif ($row1->person_age > 50 && $row1->person_age <= 60) {
                        $between_21_30++;
                    } elseif ($row1->person_age > 60) {
                        $more_than_60++;
                    }
                }
            }
            $agereport_array[$i]['total'] = $total;
            $agereport_array[$i]['totalmale'] = $totalmale;
            $agereport_array[$i]['totalfemale'] = $totalfemale;
            $agereport_array[$i]['less_than_20'] = $less_than_20;
            $agereport_array[$i]['between_21_30'] = $between_21_30;
            $agereport_array[$i]['between_31_40'] = $between_31_40;
            $agereport_array[$i]['between_41_50'] = $between_41_50;
            $agereport_array[$i]['between_51_60'] = $between_51_60;
            $agereport_array[$i]['more_than_60'] = $more_than_60;

            $i++;
        }


        return $agereport_array;
    }

    public function get_aggregated_report(
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
		$event_district =(isset($params['event_district']))?$params['event_district']:'';
		$event_vdc =(isset($params['event_vdc']))?$params['event_vdc']:'';
		$event_ward_no =(isset($params['event_ward_no']))?$params['event_ward_no']:'';
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
		
		$wh_expr_arr = array();
		if(isset($deleted) && $deleted!='' && $deleted!=null){
			array_push($wh_expr_arr,"event_deleted = '.".$deleted."'" );
			array_push($wh_expr_arr,"person_deleted = '.".$deleted."'" );
			array_push($wh_expr_arr,"participation_deleted = '.".$deleted."'" );
		}
		
		if(isset($event_course_cat_id) && $event_course_cat_id!='' && $event_course_cat_id!=null){
			array_push($wh_expr_arr,"event_course_cat_id = ".$event_course_cat_id );
		}if(isset($event_district) && $event_district!='' && $event_district!=null){
				array_push($wh_expr_arr,"event_district = '".$event_district."'" );
		}
		if(isset($event_vdc) && $event_vdc!='' && $event_vdc!=null){
				array_push($wh_expr_arr,"event_vdc = '".$event_vdc."'" );
		}if(isset($event_ward_no) && $event_ward_no!='' && $event_ward_no!=null){
				array_push($wh_expr_arr,"event_ward_no = '".$event_ward_no."'" );
		}
		$wh_expr_str = implode(' AND ',$wh_expr_arr );
		$wh_clause_str = ($wh_expr_str!='')?'WHERE '.$wh_expr_str:'';
		
		
        $select_str = <<<SQL
		SELECT 
		agg.*,
		 COUNT(*) as total_participants
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
		SELECT et.*, p.deleted as person_deleted, p.work_type_id as person_work_type_id, p.fullname as person_fullname, p.dob_en as person_dob_en, p.gender as person_gender, p.p_address as person_p_address, p.c_address as person_c_address, p.photo as person_photo,p.country as person_country, p.phone as person_phone, p.mobile as person_mobile FROM (SELECT e.deleted as event_deleted, e.event_id as event_event_id, e.title as event_title, e.course_cat_id as event_course_cat_id, e.district as event_district, e.vdc as event_vdc,e.ward_no as event_ward_no, e.year as event_year,e.start_date as event_start_date,e.end_date as event_end_date,e.venue as event_venue,e.address as event_address, e.latitude as event_latitude,e.longitude as event_longitude, e.event_code,
t.deleted as participation_deleted, t.person_id as participation_person_id, t.person_age as participation_person_age, t.is_instructor as participation_is_instructor,t.beneficiary_type as participation_beneficiary_type,t.certification_status as participation_certification_status
FROM events  e JOIN participated_in t ON e.event_id = t.event_id) AS et JOIN person p ON p.person_id  = et.participation_person_id
) as agg 
SQL;

		$sql =$select_str.' '.$wh_clause_str.' '.' GROUP BY event_event_id '.' '.$order_clause_str.' '.$limit_str;
     
		$query = $this->db->query($sql);
        
		$reports = $query->result_array();
       
        return (count($reports) > 0) ? $query->result_array() : FALSE;

    }

}

?>
