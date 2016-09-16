<?php

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ReportModel');
        $this->load->model('functionsmodel');
        $this->load->model('eventmodel');
        $this->load->model('coursemodel');
    }

    public function refresh($page = 'Report/peopleReport') {
        redirect($page, 'refresh');
    }

    public function loadpage($data = null, $view = 'report/ReportByPeople', $pagetitle = 'Report by people| BCIPN', $page = array('includes/Header', 'includes/Navigation')) {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['pagetitle'] = $pagetitle;
        for ($i = 0; $i < count($page); $i++) {
            $this->load->View($page[$i], $data);
        }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

    public function searchbyname() { // raj
        if ($this->input->post('identifier')) {
            $name = $this->input->post('search_string_peoplereport');
            $result = $this->ReportModel->search_by_name($name);
$data['name']=$name;
            if ($result != 0) {
                $data['person_result_array'] = $result;
                $this->loadpage($data);
            } else {
                $this->loadpage($data);
            }
        } else {
            $this->loadpage();
        }
    }

    public function peopleReport1() {
        // TODO 
        $data['peopleReport_array'] = $this->ReportModel->getPersonDetailReport();
        $this->load->view('includes/Header');
        $this->load->view('includes/Navigation');
        $this->load->view('report/PeopleReport', $data);
        $this->load->view('includes/Footer');
    }

    public function peoplereport() {
        $this->loadpage();
    }

    public function agereport() {
     
        $data['coverage_level_array'] = $this->functionsmodel->getCoverageLevel();

        if ($this->input->post('clicked')) {

            $datefrom = $this->input->post('event_start_date');
            $dateto = $this->input->post('event_end_date');
            $coverage = $this->input->post('coverage');
            $location = $this->input->post('location');
            $event_type = $this->input->post('Event');
            $course = $this->input->post('course');
           
              if(trim($datefrom)!=''){$data['datefrom']=$datefrom;}
            if(trim($dateto )!=''){$data['dateto']=$dateto;}
            if(trim($coverage)!=''){$data['coverage']=$coverage;}
            if(trim($location)!=''){$data['location']=$location;}
            if(trim($event_type)!=''){$data['event_type']=$event_type;}
            if(trim($course)!=''){$data['course']=$this->coursemodel->getSubCourseName($course);}
         
            
            
            $result = $this->ReportModel->get_report_by_age($datefrom, $dateto, $coverage, $location, $event_type, $course);
            $data['agereport_array'] = $result;
        }

          $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
           $content .= '<option value="' . $row->course_cat_id . '"';
            if(isset($event_type) && $row->course_cat_id==$event_type ){$content .=" selected";}
            $content .= '>' . $row->coursename . '</option>';
        }

        $data['CourseContent'] = $content;

        $this->loadpage($data, 'report/ReportByAge', 'Report by age | BCIPN');
    }

    public function coveragereport() {
        
        $data['coverage_level_array'] = $this->functionsmodel->getCoverageLevel();

        if ($this->input->post('clicked')) {
            $datefrom = $this->input->post('event_start_date');
            $dateto = $this->input->post('event_end_date');
            $coverage = $this->input->post('coverage');
            $location = $this->input->post('location');
            $event_type = $this->input->post('Event');
            $course = $this->input->post('course');
            
            if(trim($datefrom)!=''){$data['datefrom']=$datefrom;}
            if(trim($dateto )!=''){$data['dateto']=$dateto;}
            if(trim($coverage)!=''){$data['coverage']=$coverage;}
            if(trim($location)!=''){$data['location']=$location;}
            if(trim($event_type)!=''){$data['event_type']=$event_type;}
            if(trim($course)!=''){$data['course']=$this->coursemodel->getSubCourseName($course);}
         
            $result = $this->ReportModel->get_report_by_coverage($datefrom, $dateto, $coverage, $location, $event_type, $course);
            $data['coverage_report'] = $result;
        }
        
        $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '"';
            if(isset($event_type) && $row->course_cat_id==$event_type ){$content .=" selected";}
            $content .= '>' . $row->coursename . '</option>';
        }

        $data['CourseContent'] = $content;


        $this->loadpage($data, 'report/ReportByCoverage', 'Report by coverage | BCIPN');
    }

    public function summaryreport() {
        $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '">' . $row->coursename . '</option>';
        }

        $data['CourseContent'] = $content;
        $coverage_level_array = $this->functionsmodel->getCoverageLevel();
        $data['coverage_level_array'] = $coverage_level_array;
        $this->loadpage($data, 'report/SummaryReport', 'Summary report | BCIPN');
    }

    function summaryreportresult() {
        
 
        $coverage_level_array = $this->functionsmodel->getCoverageLevel();
        $data['coverage_level_array'] = $coverage_level_array;
        
        $from_date = $this->input->post('event_start_date');
        $to_date = $this->input->post('event_end_date');
        $coverage = $this->input->post('coverage');
        $location = $this->input->post('location');
        $event_type = $this->input->post('Event');
        $course = $this->input->post('course');
        
          if(trim($from_date)!=''){$data['from_date']=$from_date;}
            if(trim($to_date )!=''){$data['to_date']=$to_date;}
            if(trim($coverage)!=''){$data['coverage']=$coverage;}
            if(trim($location)!=''){$data['location']=$location;}
            if(trim($event_type)!=''){$data['event_type']=$event_type;}
            if(trim($course)!=''){$data['course']=$this->coursemodel->getSubCourseName($course);}
            
             $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
           $content .= '<option value="' . $row->course_cat_id . '"';
            if(isset($event_type) && $row->course_cat_id==$event_type ){$content .=" selected";}
            $content .= '>' . $row->coursename . '</option>';
        }
         $data['CourseContent'] = $content;    

        $data['summary_array'] = $this->ReportModel->getSummaryReport($from_date, $to_date, $coverage, $location, $event_type, $course);
    $data['subcat_report']= $this->ReportModel->getsubcatReport($from_date, $to_date, $coverage, $location, $event_type, $course);
        $this->loadpage($data, 'report/SummaryReport', 'Summary report | BCIPN');
// echo "from : ".$from_date."<br />to : ".$to_date."<br />coverage : ".$coverage."<br />location : ".$location."<br />event type : ".$event_type."<br /> course : ".$course."<br />";
    }

}

?>
