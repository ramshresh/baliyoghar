<?php

class Report extends CI_Controller {
    public $perPage=10;

    public function __construct() {
        parent::__construct();
        $this->load->model('ReportModel');
        $this->load->model('functionsmodel');
        $this->load->model('eventmodel');
        $this->load->model('coursemodel');
    }

	
    public function refresh($page = '/report/peopleReport') {
        redirect($page, 'refresh');
    }

    public function loadpage($data = null, $view = 'report/ReportByPeople', $pagetitle = 'Report by people| BALIYOGHAR', $page = array('includes/Header', 'includes/Navigation')) {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['pagetitle'] = $pagetitle;
        for ($i = 0; $i < count($page); $i++) {
            $this->load->View($page[$i], $data);
        }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

	public function dashboard(){
		$data = array();
		$this->loadpage($data, 'report/dashboard', 'BALIYOGHAR | Reports');
	}
    public function beneficiaryreport(){
        $data['coverage_level_array'] = $this->functionsmodel->getCoverageLevel();
        $data['beneficiary_types_list'] = $this->functionsmodel->getBeneficiaryTypesList();

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

            $result = $this->ReportModel->get_report_by_beneficiary($datefrom, $dateto, $coverage, $location, $event_type, $course);

            $data['beneficiaryreport'] = $result;


        }
        $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '"';
            if(isset($event_type) && $row->course_cat_id==$event_type ){$content .=" selected";}
            $content .= '>' . $row->coursename . '</option>';
        }
        $data['CourseContent'] = $content;
        $this->loadpage($data, 'report/ReportByBeneficiaryType', 'Report by Beneficiary Type | BALIYOGHAR');
    }
    public function castereport() {

        $data['coverage_level_array'] = $this->functionsmodel->getCoverageLevel();
        $data['caste_ethnicity_array'] = $this->functionsmodel->getCasteEthnicityList();


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



            $result = $this->ReportModel->get_report_by_caste($datefrom, $dateto, $coverage, $location, $event_type, $course);
            $data['castereport_array'] = $result;
        }

        $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '"';
            if(isset($event_type) && $row->course_cat_id==$event_type ){$content .=" selected";}
            $content .= '>' . $row->coursename . '</option>';
        }

        $data['CourseContent'] = $content;

        $this->loadpage($data, 'report/ReportByCaste', 'Report by Caste | BALIYOGHAR');
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
        $this->load->view('/report/PeopleReport', $data);
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


        $this->loadpage($data, 'report/ReportByCoverage', 'Report by coverage | BALIYOGHAR');
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
        $this->loadpage($data, 'report/SummaryReport', 'Summary report | BALIYOGHAR');
    }

    function summaryreportresult() {

        $coverage_level_array = $this->functionsmodel->getCoverageLevel();
        $data['coverage_level_array'] = $coverage_level_array;
        
        $from_date = $this->input->post('event_start_date');
        $to_date = $this->input->post('event_end_date');
        $coverage = $this->input->post('coverage');
        $location = $this->input->post('location');

        

        // $event_type = $this->input->post('event_type');
        $event_type = $this->input->post('Event');
        $event = $this->input->post('Event');
        $course = $this->input->post('course');

          if(trim($from_date)!=''){$data['from_date']=$from_date;}
            if(trim($to_date )!=''){$data['to_date']=$to_date;}
            if(trim($coverage)!=''){$data['coverage']=$coverage;}
            if(trim($location)!=''){$data['location']=$location;}
            if(trim($event_type)!=''){$data['event_type']=$event_type;}
            if(trim($event)!=''){$data['event']=$event;}
            if(trim($course)!=''){$data['course']=$this->coursemodel->getSubCourseName($course);}


     		 //////////////////////
        $contentCoverageLevel ='<option value="">All</option>';
        $coverage_level_array = $this->functionsmodel->getCoverageLevel();
        foreach ($coverage_level_array as $coverage_level) {
            $selected = ($coverage == $coverage_level[0] )? "selected":"";
            $contentCoverageLevel .= '<option value="' . $coverage_level[0] . '" '. $selected .'>' . $coverage_level[1] . '</option>';
        }
        $data['CoverageLevelContent'] = $contentCoverageLevel;

        $coverageLocations= $this->functionsmodel->getAllCoverageLocationByCoverageLevelID($coverage);
		$coverageLocationContent= '<option value="">All</option>';
        foreach($coverageLocations as $coverageLocation){
            $selected = ($location == $coverageLocation[0] )? "selected":"";
            $coverageLocationContent .='<option value="'.$coverageLocation[0].'" '.$selected.' >'.$coverageLocation[1].'</option>';
        }
        $data['coverageLocationContent']=$coverageLocationContent;

		 ////////////////
         $content ='<option value="">All</option>';
         $query = $this->coursemodel->getCourseResultSet();


        foreach ($query->result() as $row) {
            $selected = ($row->course_cat_id==$event)? "selected":"";
            $content .= '<option value="' . $row->course_cat_id . '" '. $selected. '>' . $row->coursename . '</option>';
         }
         $data['CourseContent'] = $content;    

        ///
        $subCourses = $this->functionsmodel->getCourseSubCoursesByCourseCatID($event);

        $contentSubCourse= '<option value="">All</option>';
        foreach($subCourses as $subCourse){
            $selected = ($course == $subCourse )? "selected":"";
            $contentSubCourse .='<option value="'.$subCourse[0].'" '.$selected.' >'.$subCourse[1].'</option>';
        }
        $data['ContentSubCourse']=$contentSubCourse;
        ///

        $data['summary_array'] = $this->ReportModel->getSummaryReport($from_date, $to_date, $coverage, $location, $event_type, $course);
        $data['subcat_report']= $this->ReportModel->getsubcatReport($from_date, $to_date, $coverage, $location, $event_type, $course);

        $this->loadpage($data, 'report/SummaryReport', 'Summary report | BALIYOGHAR');


// echo "from : ".$from_date."<br />to : ".$to_date."<br />coverage : ".$coverage."<br />location : ".$location."<br />event type : ".$event_type."<br /> course : ".$course."<br />";
    }

    public function aggregate(){

        $this->load->model('reportmodel');
        $this->load->model('eventmodel');
        $this->load->model('coursemodel');

        /////
        $per_page=($this->input->post('per_page'))?$this->input->post('per_page'):$this->perPage;

        $data = array();

        $this->load->model('eventmodel');
        $this->load->library('Ajax_pagination');

      //$totalRec = count($this->eventmodel->getTotalRowsCount());
        $reports = $this->reportmodel->get_aggregated_report();
		$totalRec = count($reports);

        //pagination configuration
        $config['target']      = '#eventsList';
        $config['base_url']    = base_url().'report/ajaxAggregateData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['events'] =$this->reportmodel->get_aggregated_report(
            0,//start
            $per_page,//limit
            0,//deleted
            array()//searchParams
        );

		
		$content = "";
        $query = $this->coursemodel->getCourseResultSet();
        $data['courses'] =array();
		foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '">' . $row->coursename . '</option>';
			$data['courses'][$row->course_cat_id] = $row->coursename;
		}
        $data['CourseContent'] = $content;

        $eventYearsContent = "";
        $eventYearsResult = $this->eventmodel->getEventYears();

        $data['eventYears'] =array();

        if($eventYearsResult && is_array($eventYearsResult)){
            foreach ($eventYearsResult as $eventYearItem) {
                $eventYear = $eventYearItem['event_year'];
                $eventYearsContent .= '<option value="' . $eventYear . '">' . $eventYear . '</option>';
                $data['eventYears'][$eventYear] = $eventYear;
            }
        }

        $data['eventYearsContent'] = $eventYearsContent;

        //load the view
        $this->loadpage($data, 'report/aggregate/main', 'Report | Aggregate');

    }
    public function ajaxAggregateData(){
        $this->load->model('reportmodel');
        $this->load->model('coursemodel');
        $this->load->model('eventmodel');
        $this->load->library('Ajax_pagination');
		
		$searchParams = array();
		
		$event_year =(null !== $this->input->post('event_year'))? $this->input->post('event_year'):'';
		$event_month =(null !== $this->input->post('event_month'))? $this->input->post('event_month'):'';
		$event_course_cat_id =(null !== $this->input->post('event_course_category'))? $this->input->post('event_course_category'):'';
		$event_district =(null !== $this->input->post('district'))? $this->input->post('district'):'';
		$event_vdc = (null !== $this->input->post('vdc'))?$this->input->post('vdc'):'';
		$event_ward_no = (null !== $this->input->post('ward_no'))?$this->input->post('ward_no'):'';
        $per_page=(null !== $this->input->post('per_page') && '' != $this->input->post('per_page'))?$this->input->post('per_page'):$this->perPage;

        //calc offset number
        $page = $this->input->post('page');
        if(null ===$page || '' ==$page ){
            $offset = 0;
        }else{
            $offset = $page;
        }

		$searchParams['event_year']=$event_year;
		$searchParams['event_month']=$event_month;
		$searchParams['event_course_cat_id']=$event_course_cat_id;
		$searchParams['event_district']=$event_district;
		$searchParams['event_vdc']=$event_vdc;
		$searchParams['event_ward_no']=$event_ward_no;
		
        $totalRec = count($this->reportmodel->get_aggregated_report(
            null,//start
            null,//limit
            null,//deleted
            $searchParams//searchParams
        ));

        //pagination configuration
        $config['target']      = '#eventsList';
        $config['base_url']    = base_url().'report/ajaxAggregateData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $per_page;

		
		
		
        //get report data
        $events = $this->reportmodel->get_aggregated_report(
            $offset,//start
            $per_page,//limit
            null,//deleted
            $searchParams//searchParams
        );

		$data['events']=$events;




		$content = "";
        $query = $this->coursemodel->getCourseResultSet();
        $data['courses'] =array();
		foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '">' . $row->coursename . '</option>';
			$data['courses'][$row->course_cat_id] = $row->coursename;
		}
        $data['CourseContent'] = $content;


		$eventYearsContent = "";
        $eventYearsResult = $this->eventmodel->getEventYears();
        $data['eventYears'] =array();
        if($eventYearsResult && is_array($eventYearsResult)){
            foreach ($eventYearsResult as $eventYearItem) {
                $eventYear = $eventYearItem['event_year'];
                $eventYearsContent .= '<option value="' . $eventYear . '">' . $eventYear . '</option>';
                $data['eventYears'][$eventYear] = $eventYear;
            }
        }
        $data['eventYearsContent'] = $eventYearsContent;

		$data['applied_filters']=array();
        $data['applied_filters']['event_year'] = $event_year;
        $this->load->helper('english_dates_helper');
        $data['applied_filters']['event_month'] = numToEngMonth($event_month);
        $data['applied_filters']['event_course_cat_id'] = $event_course_cat_id;
        $data['applied_filters']['event_type'] = $this->coursemodel->getCourseName($event_course_cat_id);
        $data['applied_filters']['event_district'] = $event_district;
        $data['applied_filters']['event_vdc'] = $event_vdc;
        $data['applied_filters']['event_ward_no'] = $event_ward_no;

        //load the partial view
        $this->load->view('report/aggregate/ajax', $data, false);
    }

}

?>
