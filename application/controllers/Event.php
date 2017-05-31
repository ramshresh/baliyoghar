<?php

class Event extends CI_Controller
{
	public $perPage=30;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('Home/login', 'refresh');
		}
		$this->load->model('eventmodel');
		$this->load->model('functionsmodel');
		$this->load->model('coursemodel');
		$this->load->model('personmodel');
		$this->load->model('worktypemodel');
		$this->load->model('educationlevelmodel');
		$this->load->library('user_agent');
		$this->load->model('beneficiarytypemodel');
		$this->load->model('certificationstatusmodel');
	}

	public function refresh($function = 'Home/Home')
	{
		redirect($function, 'refresh');
	}

	public function loadpage($data = null, $view = 'Home', $pagetitle = 'HOME | BALIYOGHAR', $page = array('includes/Header', 'includes/Navigation'))
	{
		$data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
		$data['pagetitle'] = $pagetitle;
		for ($i = 0; $i < count($page); $i++) {
			$this->load->View($page[$i], $data);
		}
		$this->load->View($view, $data);
		$this->load->View('includes/Footer');
	}

	public function event()
	{
		$this->load->model('coursemodel');
		$this->load->model('functionsmodel');
		$this->load->model('eventmodel');
        $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '">' . $row->coursename . '</option>';
        }

        $data['CourseContent'] = $content;
        $data['coverage_level_array'] = $this->functionsmodel->getCoverageLevel();
        $data['organizer_array'] = $this->eventmodel->getAllOrganizers();

        $this->loadpage($data, 'Events', 'Add new Event | BALIYOGHAR');
	}

	public function createEvent()
	{
		$event_start_date = $this->input->post('event_start_date');
		$this->form_validation->set_rules('event_title', 'Event title ', 'required');
		$this->form_validation->set_rules('event_code', 'Event Code ', 'required|is_unique[events.event_code]');
		$this->form_validation->set_rules('event_start_date', 'Event End Date ', 'required|date');
		$this->form_validation->set_rules('event_end_date', 'Event End Date ', 'callback_is_valid_end_date['.$event_start_date.']');
		$this->form_validation->set_rules('district', 'District ', 'required');
		$this->form_validation->set_rules('vdc', 'VDC/Municipality ', 'required');
		$this->form_validation->set_rules('ward_no', 'Ward No ', 'required');
		$this->form_validation->set_rules('tole', 'Tole/placename ', '');

		$this->form_validation->set_rules('event_latitude', 'Latitude ', 'latitude');
		$this->form_validation->set_rules('event_longitude', 'Longitude ', 'longitude');

		if ($this->form_validation->run() == false) {


            $this->event();
		} else {
			$this->sendDataToModel();
		}
	}

	public function sendDataToModel()
	{
		$event_title = $this->input->post('event_title');
		$event_code = $this->input->post('event_code');
		/* course category is now event_type */
		$event_course_category = $this->input->post('event_course_category');
		/* course sub-category is now course */
		$event_course_subcategory = $this->input->post('event_course_subcategory');
		/* event level is now coverage level */
		$coverage_level = $this->input->post('coverage_level');
		$coverageLocation = $this->input->post('coverage_location');
		$event_year = $this->input->post('event_year');
		$event_start_date = $this->input->post('event_start_date');
		$event_end_date = $this->input->post('event_end_date');
		/* $event_implementedby = $this->input->post('event_implementedby'); */
		$event_venue = $this->input->post('event_venue');
		$tole = $this->input->post('tole');
		$event_address = $this->input->post('event_address');
		$event_country = $this->input->post('event_country');
		$organizer_identifier = $this->input->post('org_identifier');
		$longitude = $this->input->post('longitude');
		$latitude = $this->input->post('latitude');
		$district = $this->input->post('district');
		$vdc = $this->input->post('vdc');
		$ward_no = $this->input->post('ward_no');

		/* 888888888888888888888 start 88888888888888888888888 */
		//if implementing partners are checked
		$impl_partners = array();
		//If main organizers are checked follow this block
		$main_organizers = array();

		//  if ($organizer_identifier == 'main') {
		$k = 0;
		foreach ($_POST as $key => $value) {
			$array = explode('_', $key);
			if ($array[0] == 'mainorg') {

				$main_organizers[$k][0] = $array[1];
				$main_organizers[$k][1] = $this->input->post($key);
				// echo $this->input->post($key);
				$k++;
			}
		}
		//   } else if ($organizer_identifier == 'partner') {
		$k = 0;
		foreach ($_POST as $key => $value) {
			$array = explode('_', $key);
			if ($array[0] == 'implpartner') {

				$impl_partners[$k][0] = $array[1];
				$impl_partners[$k][1] = $this->input->post($key);
				// echo $this->input->post($key);
				$k++;
			}
		}
		//  }
		/* 88888888888888888888888 end 8888888888888888888888 */

		$date = date("Y-m-d H:i:s");
		$created_by = $this->session->userdata('username');

//
//        $identifier = $this->input->post('identifier');
//        $event_id;
//        switch ($identifier) {
//            case 'insert':
//                $event_id = NULL;
//                break;
//            case 'edit':
//                $event_id = $this->input->post('event_id');
//                echo $event_id."==";
//                break;
//        }
///

		$event_data_insert = array(
			'event_id' => NULL,
			'title' => $event_title,
			'event_code' => $event_code,
			'course_cat_id' => $event_course_category,
			'course_subcat_id' => $event_course_subcategory,
			'coverage_level' => $coverage_level,
			'coverage_location' => $coverageLocation,
			'year' => $event_year,
			'start_date' => $event_start_date,
			'end_date' => $event_end_date,
			'venue' => $event_venue,
			'address' => $event_address,
			'country' => $event_country,
			'created_by' => $created_by,
			'created_date' => $date,
			'longitude' => $longitude,
			'latitude' => $latitude,
			'district' => $district,
			'vdc' => $vdc,
			'ward_no' => $ward_no,
			'tole' => $tole
		);
		$event_data_update = array(
			'title' => $event_title,
			'event_code' => $event_code,
			'course_cat_id' => $event_course_category,
			'course_subcat_id' => $event_course_subcategory,
			'coverage_level' => $coverage_level,
			'coverage_location' => $coverageLocation,
			'year' => $event_year,
			'start_date' => $event_start_date,
			'end_date' => $event_end_date,
			'venue' => $event_venue,
			'address' => $event_address,
			'longitude' => $longitude,
			'latitude' => $latitude,
            'district' => $district,
            'vdc' => $vdc,
            'ward_no' => $ward_no,
            'tole' => $tole
		);

		$event_id = $this->testIfEventExists(array(
			'title' => $event_title,
			'event_code' => $event_code,
			'course_cat_id' => $event_course_category,
			'course_subcat_id' => $event_course_subcategory,
			'year' => $event_year,
			'start_date' => $event_start_date,
			'end_date' => $event_end_date,
			'venue' => $event_venue,
			'address' => $event_address,
			'country' => $event_country,
            'district' => $district,
            'vdc' => $vdc,
            'ward_no' => $ward_no,
            'tole' => $tole
		));


		$data['title'] = $event_title;

		$data=array_merge($data,$this->personmodel->getRelatedDropDownSelects());

//        $data['course'] = $this->coursemodel->getCourseName($event_course_category);
//        $data['subcourse'] = $this->coursemodel->getSubCourseName($event_course_subcategory);
//        $data['start_date'] = $event_start_date;
//        $data['end_date'] = $event_end_date;
//        $data['venue'] = $event_venue;
//        $data['address'] = $event_address;
//        $data['person_data'] = $this->personmodel->getPeople(0, 30);

		if ($event_id != "0") {
			//  if ($identifier != 'edit') {
			$data['course'] = $this->coursemodel->getCourseName($event_course_category);
			$data['subcourse'] = $this->coursemodel->getSubCourseName($event_course_subcategory);
			$data['start_date'] = $event_start_date;
			$data['end_date'] = $event_end_date;
			$data['venue'] = $event_venue;
			$data['address'] = $event_address;
			$data['person_data'] = $this->personmodel->getPeople(0, 30);
			$this->loadEventDetail($event_id);
			//  }
		} else {
			$event_id = $this->eventmodel->saveEventData($event_data_insert, $main_organizers, $impl_partners);
			if ($event_id != 0) {
				$data['event_id'] = $event_id;
				$data['event_title'] = $event_title;
				$this->loadpage($data, 'People', 'Add participants | BALIYOGHAR');
			} else {
				$this->loadpage();
			}
		}
	}

	function getCoverageLocation()
	{
		$coverage_level_id = $this->input->post('coverage_level');
		echo $this->eventmodel->getAllCoverageLocation($coverage_level_id);
	}

	function person_exists()
	{
		$fullname = $this->input->post('fullname');
		$citizenship_no = $this->input->post('citizenship_no');
		$dob_en = $this->input->post('dob_en');
		$dob_np = $this->input->post('dob_np');
		//replace /(slash) by -(hyphen)
		// $dob_np = str_replace("/","-",$dob_np);
		$mobile = $this->input->post('mobile');
		$phone = $this->input->post('phone');
		$person_data = $this->eventmodel->person_exists($fullname, $dob_en, $dob_np, $mobile, $phone, $citizenship_no);

		echo $person_data;
	}

	function addParticipant()
	{
		$data['event_id'] = $this->input->get('id', TRUE);
		$event_detail = $this->eventmodel->getEventDetail($this->input->get('id', TRUE));
		$course_category_id=$event_detail[3];
		$data['event_title'] = $event_detail[0];

		//$query = $this->worktypemodel->getWorkTypeTable();
        $query = $this->worktypemodel->getWorkTypeTableByCourseCategoryID($course_category_id);


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

        //$query = $this->worktypemodel->getWorkTypeTableByCourseCategoryID($event_detail[3]);
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
		//{{{
		/*$workTypeSelect = "";
		foreach ($query->result() as $row) {
			$workTypeSelect .= '<option value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
		}
		$data['WorkTypeSelect'] = $workTypeSelect;*/
		//}}}

		$this->loadpage($data, 'People', 'Add participants | BALIYOGHAR');
	}

	public function updateEvent()
	{
		/*
		select * from foo where id = (select max(id) from foo where id < 4)
		select * from foo where id = (select min(id) from foo where id > 4)
		*/
		$event_id = $this->input->post('event_id');
		$event_title = $this->input->post('event_title');
		$event_code = $this->input->post('event_code');
		/* course category is now event_type */
		$event_course_category = $this->input->post('event_course_category');
		/* course sub-category is now course */
		$event_course_subcategory = $this->input->post('event_course_subcategory');
		/* event level is now coverage level */
		$coverage_level = $this->input->post('coverage_level');
		$coverageLocation = $this->input->post('coverage_location');
		$event_year = $this->input->post('event_year');
		$event_start_date = $this->input->post('event_start_date');
		$event_end_date = $this->input->post('event_end_date');
		/* $event_implementedby = $this->input->post('event_implementedby'); */
		$event_venue = $this->input->post('event_venue');
		$event_address = $this->input->post('event_address');
		$longitude = $this->input->post('longitude');
		$latitude = $this->input->post('latitude');
		
		$district = $this->input->post('district');
		$vdc = $this->input->post('vdc');
		$ward_no = $this->input->post('ward_no');
		
		

		//if implementing partners are checked
		$impl_partners = array();


		//If main organizers are checked follow this block
		$main_organizers = array();

		$k = 0;
		foreach ($_POST as $key => $value) {
			$array = explode('_', $key);
			if ($array[0] == 'mainorg') {

				$main_organizers[$k][0] = $array[1];
				$main_organizers[$k][1] = $this->input->post($key);
				// echo $this->input->post($key);
				$k++;
			}
		}

		$k = 0;
		foreach ($_POST as $key => $value) {
			$array = explode('_', $key);
			if ($array[0] == 'implpartner') {

				$impl_partners[$k][0] = $array[1];
				$impl_partners[$k][1] = $this->input->post($key);
				// echo $this->input->post($key);
				$k++;
			}
		}


		$event_data_update = array(
			'title' => $event_title,
			'course_cat_id' => $event_course_category,
			'course_subcat_id' => $event_course_subcategory,
			'coverage_level' => $coverage_level,
			'coverage_location' => $coverageLocation,
			'year' => $event_year,
			'start_date' => $event_start_date,
			'end_date' => $event_end_date,
			'venue' => $event_venue,
			'address' => $event_address,
			'longitude' => $longitude,
			'latitude' => $latitude,
			'event_code' => $event_code,
			'district' => $district,
			'vdc' => $vdc,
			'ward_no' => $ward_no,
		);

		$this->eventmodel->updateEventData($event_data_update, $event_id, $main_organizers, $impl_partners);
		
		redirect('Event/viewEvent?id=' . $event_id);
		
		//http://192.168.100.18/baliyoghar/Event/viewEvent?id=21
		//$this->viewEvent($event_id);
	}

	public function updateEventData($data, $event_id, $csparty_value)
	{
		$this->load->model('personmodel');
		$success = $this->eventmodel->updateEventData($data, $event_id, $csparty_value);
		$this->loadEventDetail($event_id);
	}

	public function testIfEventExists($data_array)
	{
		$success = $this->eventmodel->testIfEventExists($data_array);
		return $success;
	}

	public function deleteEvent()
	{
		$data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
		$success = $this->eventmodel->deleteEvent($this->input->get('id', TRUE));
		$this->deleteParticipants($this->input->get('id', TRUE));
		//$data['event_data'] = $this->eventmodel->getEvents(0, 30);
//        $this->load->View('includes/Header');
//        $this->load->View('includes/Navigation', $data);
//        $this->load->View('EventManagement', $data);
//        $this->load->View('includes/Footer');
		//$this->loadpage($data, 'EventManagement', 'Manage events| BALIYOGHAR');

		redirect('Event/event_list_pagination');
	}

	public function deleteParticipants($event_id)
	{
		//  $this->load->model('functionsmodel');
		$success = $this->eventmodel->deleteParticipants($event_id);
	}

//------------------------------------------------------------------------------
	public function editEvent()
	{
		$event_id = $this->input->get('id', TRUE);
		$eventDetail_array = $this->eventmodel->getEventDetail($event_id);
		$previous_event_id = $this->eventmodel->getPreviousRecordId($event_id);
		$next_event_id = $this->eventmodel->getNextRecordId($event_id);
		$total_count = $this->eventmodel->getRowCount_event();
		
		$data['previous_event_id'] = $previous_event_id;
		$data['next_event_id'] = $next_event_id;
		$data['total_records'] = $total_count;
		
		/*
		  $eventDetail_array[0] = $row->event_id;
		  $eventDetail_array[1] = $row->title;
		  $eventDetail_array[2] = $row->year;
		  $eventDetail_array[3] = $row->course_cat_id;
		  $eventDetail_array[4] = $row->course_subcat_id;
		  $eventDetail_array[5] = $row->start_date;
		  $eventDetail_array[6] = $row->end_date;
		  $eventDetail_array[7] = $row->venue;
		  $eventDetail_array[8] = $this->getCoverageLevelName($row->coverage_level);
		  $eventDetail_array[9] = $row->coverage_location;
		  $eventDetail_array[10] = $row->address;
		  $eventDetail_array[11] = $row->country;
		$eventDetail_array[12] = $row->coverage_level;
			$eventDetail_array[13] = $row->longitude;
			$eventDetail_array[14] = $row->latitude;
			$eventDetail_array[15] = $row->event_code;
		 *///----------------

		$data['event_id'] = $eventDetail_array[0];
		$data['title'] = $eventDetail_array[1];
		$data['event_year'] = $eventDetail_array[2];
		$data['course_cat_list'] = $this->coursemodel->getCourseData();
		$data['course_cat_id'] = $eventDetail_array[3];
		$data['course_subcat_list'] = $this->coursemodel->getSubCourseData($eventDetail_array[3]);
		$data['course_subcat_id'] = $eventDetail_array[4];
		$data['start_date'] = $eventDetail_array[5];
		$data['end_date'] = $eventDetail_array[6];
		$data['venue'] = $eventDetail_array[7];
		$data['level'] = $eventDetail_array[8];
		$data['location'] = $eventDetail_array[9];
		$data['address'] = $eventDetail_array[10];
		$data['country'] = $eventDetail_array[11];
		$data['coverage_level_id'] = $eventDetail_array[12];
		$data['longitude'] = $eventDetail_array[13];
		$data['latitude'] = $eventDetail_array[14];
		$data['event_code'] = $eventDetail_array[15];
		
	
		$data['district'] = $eventDetail_array[16];
		$data['vdc'] = $eventDetail_array[17];
		$data['ward_no'] = $eventDetail_array[18];
		$locationstring = '';
		switch (strtoupper($data['level'])) {
			case 'MUNICIPALITY':
			case 'DISTRICT':
			case 'REGION':
			case 'VDC':
				$location = $this->eventmodel->getCoverageLocation($data['coverage_level_id']);
				for ($i = 0; $i < count($location); $i++) {
					$selected = '';
					if (trim($data['location']) == trim($location[$i][1])) {
						$selected = 'selected';
					}
					$locationstring .= '<option value = "' . $location[$i][1] . '" ' . $selected . '>' . $location[$i][1] . '</option>';
				}
				break;
			default:
				$locationstring .= '<input id="coverage_location" type="text" value="' . $data['location'] . '" name="coverage_location" placeholder="Enter location..">';
				break;
		}
		$data['location'] = $locationstring;

		$content = "";
		$query = $this->coursemodel->getCourseResultSet();
		foreach ($query->result() as $row) {
			$selected = '';
			if ($data['course_cat_id'] == $row->course_cat_id) {
				$selected = 'selected';
			}
			$content .= '<option value="' . $row->course_cat_id . '" ' . $selected . '>' . $row->coursename . '</option>';
		}
		$data['CourseContent'] = $content;
		$data['coverage_level_array'] = $this->functionsmodel->getCoverageLevel();
		$data['organizer_array'] = $this->eventmodel->getAllOrganizers(); //contains a list of all organizers
		//------------------------------------------------------------------------
		$data['main_organizer_array'] = $this->eventmodel->getMainOrganizer($event_id); //contains a list of selected organizers
		$data['impl_partner_array'] = $this->eventmodel->getImplementingPartner($event_id);
		//------------------------------------------------------------------------
		$this->loadpage($data, 'EditEvent', 'Edit events| BALIYOGHAR');
	}

//--------------------------------------------------------------------------------------------------------------

	public function budgetEntry()
	{
		$content = '';
		$event_id = $this->input->get('id', TRUE);
		$data['event_id'] = $event_id;
		$data['event_title'] = $this->eventmodel->getEventTitle($data['event_id']);
		$data['budget_currency'] = $this->eventmodel->getBudgetCurrency($data['event_id']);
		$currency = $this->eventmodel->getcurrency();
		$data['share'] = $this->eventmodel->getShare($event_id);
		$data['csparty_array'] = $this->functionsmodel->getALLCostSharingParties();
		$data['direct_cost_array'] = $this->eventmodel->getDirectCost($event_id);
		$data['inkind_contribution_array'] = $this->eventmodel->getInkindContribution($event_id);


		if ($currency != 0) {
			for ($i = 0; $i < count($currency); $i++) {
				$content .= ' <option value="' . $currency[$i][0] . '"';
				if (isset($data['budget_currency']) && $data['budget_currency'] == $currency[$i][0]) {
					$content .= ' selected ';
				}
				$content .= '>' . $currency[$i][0] . '</option> ';
			}
			$data['currency'] = $content;
		}


		$this->loadpage($data, 'BudgetEntry', 'Budget entry | BALIYOGHAR');
	}

	public function saveBudget()
	{
		$csparty_value = array();
		$k = 0;
		foreach ($_POST as $key => $value) {
			$array = explode('_', $key);
			if ($array[0] == 'csparty') {

				$csparty_value[$k][0] = $array[1];
				$csparty_value[$k][1] = $this->input->post($key);
				$k++;
			} else {

			}
		}
		$event_id = $this->input->post('event_id');
		$total_direct_cost = $this->input->post('total_direct_cost');
		$staff_cost = $this->input->post('staff_cost');
		$travel_cost = $this->input->post('travel_cost');
		$unit = $this->input->post('currency_unit');

		$success = $this->eventmodel->saveBudget($event_id, $csparty_value, $total_direct_cost, $staff_cost, $travel_cost, $unit);

		$data['event_id'] = $event_id;
		$data['event_title'] = $this->eventmodel->getEventTitle($data['event_id']);
		$data['share'] = $this->eventmodel->getShare($event_id);
		$data['csparty_array'] = $this->functionsmodel->getALLCostSharingParties();
		$data['direct_cost_array'] = $this->eventmodel->getDirectCost($event_id);
		$data['inkind_contribution_array'] = $this->eventmodel->getInkindContribution($event_id);
		$data['budget_currency'] = $this->eventmodel->getBudgetCurrency($event_id);
		$currency = $this->eventmodel->getcurrency();
		if ($currency != 0) {
			$content = '';
			for ($i = 0; $i < count($currency); $i++) {
				$content .= ' <option value="' . $currency[$i][0] . '"';
				if (isset($data['budget_currency']) && $data['budget_currency'] == $currency[$i][0]) {
					$content .= ' selected ';
				}
				$content .= '>' . $currency[$i][0] . '</option> ';
			}
			$data['currency'] = $content;
		}


		$this->loadpage($data, 'BudgetEntry', 'Budget entry | BALIYOGHAR');
	}

	function saveInkindContribution()
	{
		$event_id = $this->input->post('event_id');
		$level = $this->input->post('level');
		$description = $this->input->post('description');
		$pax = $this->input->post('pax');
		$rate = $this->input->post('rate');
		$hour = $this->input->post('hour');
		$inkind_contribution_array = array(
			'event_id' => $event_id,
			'level' => $level,
			'description' => $description,
			'pax' => $pax,
			'hour' => $hour,
			'rate' => $rate,
			'updated_by' => $this->session->userdata('username'),
			'updated_date' => date("Y-m-d H:i:s")
		);

		$inkind_id = $this->eventmodel->saveInkindContribution($inkind_contribution_array);
		if ($inkind_id == 0) {
			echo '0';
		} else {
			//if data is inserted successfully , return the insert_id as ajax response
			echo $inkind_id;
		}
	}

	function deleteInkindContribution()
	{
		$inkind_id = $this->input->post('inkind_id');
		$success = $this->eventmodel->deleteInkindContribution($inkind_id);
		echo $success;
	}

	public function viewEvent($id = 0)
	{
		//  $this->load->model('functionsmodel');
		if ($id == 0) {
			$event_id = $this->input->get('id', TRUE);
		} else {
			$event_id = $id;
		}
		$data = $this->loadEventDetail($event_id);
		$data['directcost_array'] = $this->eventmodel->getDirectCost($event_id);
		$data['inkind_contribution_array'] = $this->eventmodel->getInkindContribution($event_id);
		$data['main_organizer_array'] = $this->eventmodel->getMainOrganizer($event_id);
		$data['impl_partner_array'] = $this->eventmodel->getImplementingPartner($event_id);
		$data['unit'] = $this->eventmodel->getBudgetCurrency($event_id);
		
		
		$previous_event_id = $this->eventmodel->getPreviousRecordId($event_id);
		$next_event_id = $this->eventmodel->getNextRecordId($event_id);
		$total_count = $this->eventmodel->getRowCount_event();
		
		
		$data['previous_event_id'] = $previous_event_id;
		$data['next_event_id'] = $next_event_id;
		$data['total_records'] = $total_count;
		
		$this->loadpage($data, 'EventDetail', 'Event Details | BALIYOGHAR');
	}

	public function editParticipationSave_async()
	{
		//$this->form_validation->set_rules('participated_in_id', 'Person Id', 'required');

		$participated_in_id = $this->input->post('participated_in_id');

		$person_id = $this->input->post('person_id');
		$event_id = $this->input->post('event_id');
		$is_instructor = $this->input->post('is_instructor');
		$beneficiary_type = $this->input->post('beneficiary_type');
		$certification_status = $this->input->post('certification_status');

		$data = array(
			'is_instructor' => $is_instructor,
			'beneficiary_type' => $beneficiary_type,
			'certification_status' => $certification_status,
		);
		$success = $this->personmodel->updateParticipationInData_participated_in_id($data, $participated_in_id);

		$participantData = $this->eventmodel->getParticipant($event_id, $person_id);

		$data = [];
		$data['event_id'] = $event_id;
		$data['person_id'] = $person_id;
		$data['participant_array'] = $participantData['participant'];
		$data['i'] = $participantData['i'];


		echo $this->load->view('event/_editParticipationRow', $data, true);
	}

	public function editParticipationForm_async()
	{

		$event_id = $this->input->post('event_id');
		$person_id = $this->input->post('person_id');

		$participationDetail = $this->eventmodel->getParticipation($event_id, $person_id);
		/**
		 * array(9) { ["event_id"]=> string(2) "24" ["person_id"]=> string(2) "43" ["is_instructor"]=> string(1) "2" ["deleted"]=> string(1) "0" ["certification_status"]=> NULL ["certification_code"]=> NULL ["certification_date"]=> NULL ["beneficiary_type"]=> string(1) "5" ["participation_role"]=> NULL }
		 **/
		$data = [];
		$data['event_id'] = $event_id;
		$data['person_id'] = $person_id;
		$data['participationDetail'] = $participationDetail;
		$data['participated_in_id'] = $participationDetail['participated_in_id'];
		$data['beneficiary_type_id'] = $participationDetail['beneficiary_type'];
		$data['certification_status_id'] = $participationDetail['certification_status'];


		//{{
		$query = $this->certificationstatusmodel->getCertificationStatusTable();
		$certificationStatusSelect = "";
		foreach ($query->result() as $row) {
			if ($row->certification_status_id == $data['certification_status_id']) {
				$certificationStatusSelect .= '<option selected value="' . $row->certification_status_id . '">' . $row->certification_status_name . '</option>';
			} else {
				$certificationStatusSelect .= '<option value="' . $row->certification_status_id . '">' . $row->certification_status_name . '</option>';
			}

		}
		$data['certificationStatusSelect'] = $certificationStatusSelect;
		//}}


		$participationTypeSelect = "";
		$participationTypes = $this->eventmodel->getParticipationTypes();
		foreach ($participationTypes as $key => $value) {
			if ($key == $participationDetail['is_instructor']) {
				$participationTypeSelect .= '<option selected value="' . $key . '">' . $value . '</option>';
			} else {
				$participationTypeSelect .= '<option value="' . $key . '">' . $value . '</option>';
			}

		}

		$data['participationTypeSelect'] = $participationTypeSelect;

		$data['beneficiary_type_id'] = $participationDetail['beneficiary_type'];

		$query = $this->beneficiarytypemodel->getBeneficiaryTypeTable();
		$beneficiaryTypeSelect = "";
		foreach ($query->result() as $row) {
			if ($row->beneficiary_type_id == $data['beneficiary_type_id']) {
				$beneficiaryTypeSelect .= '<option selected value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
			} else {
				$beneficiaryTypeSelect .= '<option value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
			}
		}
		$data['beneficiaryTypeSelect'] = $beneficiaryTypeSelect;

		echo $this->load->view('event/_editParticipationForm_async', $data, true);
	}

	public function editCandidateForm_async()
	{
		if (is_int(intval(($this->input->post('participation_id')))) && $this->input->post('participation_id') > 0) {
			$participation_id = $this->input->post('participation_id');
			//$success = $this->functionsmodel->deleteCandidate_async(0, 0, $participation_id);
			/*if ($success == "1") {
				echo "yes";
			} else {
				echo "no";
			}*/
		} else {

			$personId = $this->input->post('person_id');
			$eventId = $this->input->post('event_id');
            $event_detail = $this->eventmodel->getEventDetail($eventId);
            $course_category_id =$event_detail[3];
			$personDetail_array = $this->personmodel->getpersonDetail($personId);

			$data['event_id'] = $eventId;
			$data['person_id'] = $personDetail_array[0];
			$data['title'] = $personDetail_array[1];
			$data['fullname'] = $personDetail_array[2];
			$data['dob_en'] = $personDetail_array[3];
			$data['dob_np'] = $personDetail_array[19];//yo chai pachhi thapeko bhayera last ma pugyo
			$data['caste_ethnicity'] = $personDetail_array[25];//yo chai pachhi thapeko bhayera last ma pugyo
			$data['citizenship_no'] = $personDetail_array[26];//yo chai pachhi thapeko bhayera last ma pugyo
			$data['age'] = $personDetail_array[4];
			$data['gender'] = $personDetail_array[5];
			$data['p_address'] = $personDetail_array[6];
			$data['c_address'] = $personDetail_array[7];
			$data['photo'] = $personDetail_array[8];
			$data['country'] = $personDetail_array[9];
			$data['phone'] = $personDetail_array[10];
			$data['mobile'] = $personDetail_array[11];
			$data['email'] = $personDetail_array[12];
			$data['org_name'] = $personDetail_array[13];
			$data['org_address'] = $personDetail_array[14];
			$data['org_phone'] = $personDetail_array[15];
			$data['org_fax'] = $personDetail_array[16];
			$data['position'] = $personDetail_array[17];
			$data['current_status'] = $personDetail_array[18];
			$data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();

			$data['education'] = $personDetail_array[27];
			$data['work_type_id'] = $personDetail_array[28];
			$data['event_id'] = $eventId;

			//$query = $this->worktypemodel->getWorkTypeTable();
            $query = $this->worktypemodel->getWorkTypeTableByCourseCategoryID($course_category_id);
			$workTypeSelect = "";
			foreach ($query->result() as $row) {
				if ($row->work_type_id == $data['work_type_id']) {
					$workTypeSelect .= '<option selected value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
				}
				$workTypeSelect .= '<option value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
			}
			$data['WorkTypeSelect'] = $workTypeSelect;

			echo $this->load->view('event/_editCandidateForm_async', $data, true);

			exit();
		}
	}

	public function editCandidateSave_async()
	{


		$this->form_validation->set_rules('person_name', 'Full name ', 'required');

		$participant_type = $this->input->post('participant_type');

		$event_id = $this->input->post('event_id');
		$person_title = $this->input->post('person_title');
		$person_name = $this->input->post('person_name');
		$person_dob_np = $this->input->post('person_dob_np');
		$person_dob_en = $this->input->post('person_dob_en');
		$person_gender = $this->input->post('person_gender');
		$person_paddress = $this->input->post('person_paddress');
		$person_caddress = $this->input->post('person_caddress');
		//  $person_photo = "photo";
		$person_country = $this->input->post('person_country');
		$person_phone = $this->input->post('person_phone');
		$person_mobile = $this->input->post('person_mobile');
		$person_email = $this->input->post('person_email');
		$person_org_name = $this->input->post('person_org_name');
		$person_org_address = $this->input->post('person_org_address');
		$person_org_phone = $this->input->post('person_org_phone');
		$person_org_fax = $this->input->post('person_org_fax');
		$person_position = $this->input->post('person_position');
		$person_current_status = $this->input->post('person_current_status');
		$person_caste_ethnicity = $this->input->post('person_caste_ethnicity');
		$person_citizenship_no = $this->input->post('person_citizenship_no');

		$education = $this->input->post('education');
		$work_type_id = $this->input->post('work_type_id');

		/*   if (trim($person_dob_np) == '' && trim($person_dob_en) == '') {
			   $person_dob_np = $person_dob_en = '0000-00-00';
		   }

		   // nepali date of birth contains / as day,month,year separator..
		   //change the separator from / to -
		   else if (trim($person_dob_np) != '') {
			   $dob_np = explode('/', $person_dob_np);
			   $person_dob_np = $dob_np[0] . '-' . $dob_np[1] . '-' . $dob_np[2];
		   }*/

		$data = array(
			'title' => $person_title,
			'fullname' => $person_name,
			'dob_np' => $person_dob_np,
			'dob_en' => $person_dob_en,
			'gender' => $person_gender,
			'p_address' => $person_paddress,
			'c_address' => $person_caddress,
			'country' => $person_country,
			'phone' => $person_phone,
			'mobile' => $person_mobile,
			'email' => $person_email,
			'org_name' => $person_org_name,
			'org_address' => $person_org_address,
			'org_phone' => $person_org_phone,
			'org_fax' => $person_org_fax,
			'position' => $person_position,
			'current_status' => $person_current_status,
			'created_by' => $this->session->userdata('username'),
			'created_date' => date("Y-m-d H:i:s"),
			'caste_ethnicity' => $person_caste_ethnicity,
			'citizenship_no' => $person_citizenship_no,

			'education' => $education,
			'work_type_id' => $work_type_id,
		);

		$participated_in_Data = [];

		$participated_in_Data["participant_type"] = $participant_type;
		if ($this->form_validation->run() == false) {
			echo 'no';
		} else {
			$person_id = $this->input->post('person_id');
			$success = $this->personmodel->updatePersonData($data, $person_id);
			$success = $this->personmodel->updateParticipatedInData($participated_in_Data, $event_id);

			$participantData = $this->eventmodel->getParticipant($event_id, $person_id);

			$data = [];
			$data['event_id'] = $event_id;
			$data['person_id'] = $person_id;
			$data['participant_array'] = $participantData['participant'];
			$data['i'] = $participantData['i'];

			echo $this->load->view('event/_editCandidatePersonTable', $data, true);
			exit();
			echo $success;
		}
	}


	public function loadEventDetail($event_id)
	{
		$event_detail_array = $this->eventmodel->getEventDetail($event_id);
		$data['share'] = $this->eventmodel->getShare($event_id);
		$data['participants_array'] = $this->eventmodel->getAllParticipants($event_id);
		$data['event_id'] = $event_detail_array[0];
		$data['title'] = $event_detail_array[1];
		$data['year'] = $event_detail_array[2];
		$data['course'] = $this->coursemodel->getCourseName($event_detail_array[3]);
		$data['subcourse'] = $this->coursemodel->getSubCourseName($event_detail_array[4]);
		$data['start_date'] = $event_detail_array[5];
		$data['end_date'] = $event_detail_array[6];
		$data['venue'] = $event_detail_array[7];
		$data['level'] = $event_detail_array[8];
		$data['location'] = $event_detail_array[9];
		$data['address'] = $event_detail_array[10];
		$data['country'] = $event_detail_array[11];
		// $data['cost_sharing'] = $event_detail_array[12];
		//coverage level is 12
		$data['longitude'] = $event_detail_array[13];
		$data['latitude'] = $event_detail_array[14];
		$data['district'] = $event_detail_array[16];
		$data['vdc'] = $event_detail_array[17];
		$data['ward_no'] = $event_detail_array[18];
		

		$data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
//        $this->load->View('includes/Header');
//        $this->load->View('includes/Navigation', $data);
//        $this->load->View('EventDetail', $data);
//        $this->load->View('includes/Footer');
		return $data;
	}

	/* just for the ajax call */

	public function grabSubCourseData_async()
	{
		$course_id = $this->input->post('course_cat_id');

		//  $this->load->model('eventmodel');
		$success = $this->eventmodel->getSubCourseData($course_id);

		if ($success == "no") {
			echo "no";
		} else {
			echo $success;
		}
	}

	public function addInstructor_async()
	{
		$personId = $this->input->post('person_id');
		$eventId = $this->input->post('event_id');
		$event_instructor = $this->input->post('event_inst');
		$person = $this->personmodel->getPersonDetail($personId);
		$person_age = $person[4];
		// $this->load->model('functionsmodel');
		$success = $this->functionsmodel->addInstructor($personId, $eventId, $event_instructor, $person_age);
		if ($success == "1") {
			echo "yes";
		} else {
			echo "no";
		}
	}

	public function addCandidate_async()
	{
		$personId = $this->input->post('person_id');
		$eventId = $this->input->post('event_id');
		// $this->load->model('functionsmodel');
		$success = $this->functionsmodel->addCandidate_async($personId, $eventId);
		if ($success == "1") {
			echo "yes";
		} else {
			echo "no";
		}
	}

	public function deleteCandidate_async()
	{
		if (is_int(intval(($this->input->post('participation_id')))) && $this->input->post('participation_id') > 0) {
			$participation_id = $this->input->post('participation_id');
			$success = $this->functionsmodel->deleteCandidate_async(0, 0, $participation_id);
			if ($success == "1") {
				echo "yes";
			} else {
				echo "no";
			}
		} else {
			$personId = $this->input->post('person_id');
			$eventId = $this->input->post('event_id');
			//  $this->load->model('functionsmodel');
			$success = $this->functionsmodel->deleteCandidate_async($personId, $eventId);
			if ($success == "1") {
				echo "yes";
			} else {
				echo "no";
			}
		}
	}

	public function search_person_async()
	{
		$string = $this->input->post('search_string');
		$identifier = $this->input->post('identifier');
		//  $this->load->model('functionsmodel');
		$success = $this->functionsmodel->searchPerson_async($string, $identifier);
		echo $success;
	}

	public function searchEvent()
	{
		$item_per_page = 30;
		$page_no = 1;
		$string = $this->input->post('event_searchString');

		$data['search_string'] = $string;
		$deleted = 0; // show data which are not deleted
		$data['event_data'] = $this->eventmodel->getEvents(($page_no - 1) * $item_per_page, ($page_no * $item_per_page), $deleted, $string);
		$data['total_pages'] = $this->eventmodel->getEvent_pagination_totalpage();
		$data['current_page'] = $page_no;
		$data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();

//        $this->load->View('includes/Header');
//        $this->load->View('includes/Navigation', $data);
//        $this->load->View('EventManagement', $data);
//        $this->load->View('includes/Footer');
		$this->loadpage($data, 'EventManagement', 'Manage event | BALIYOGHAR');
	}

    public function event_list_pagination(){

        $this->load->model('reportmodel');
        $this->load->model('eventmodel');
        $this->load->model('coursemodel');

        /////
        $per_page=($this->input->post('per_page'))?$this->input->post('per_page'):$this->perPage;

        $data = array();

        $this->load->model('eventmodel');
        $this->load->library('Ajax_pagination');

        //$totalRec = count($this->eventmodel->getTotalRowsCount());
        $reports = $this->eventmodel->getFilteredEvents();
        $totalRec = count($reports);

        //pagination configuration
        $config['target']      = '#eventsList';
        $config['base_url']    = base_url().'event/event_list_pagination_ajax';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['events'] =$this->eventmodel->getFilteredEvents(
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
        $this->loadpage($data, 'event/list_pagination/main', 'Report | Aggregate');

    }

    public function event_list_pagination_ajax()
    {
        $this->load->model('reportmodel');
        $this->load->model('coursemodel');
        $this->load->model('eventmodel');
        $this->load->library('Ajax_pagination');

        $searchParams = array();
        $data=array();

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


        $totalRec = count($this->eventmodel->getFilteredEvents(
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

        //get event data
        $events = $this->eventmodel->getFilteredEvents(
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
        $this->load->view('event/list_pagination/ajax', $data, false);

        //$this->loadpage($data, 'EventManagement', 'Manage event | BALIYOGHAR');
    }

	public function event_pagination()
	{
		$item_per_page = 30;
		$page_no = $this->input->get('page', TRUE);
		$search_string = $this->input->get('search_string', TRUE);

		$pages = $this->eventmodel->getTotalPages_event($item_per_page);

		$data['total_pages'] = $pages;
		$data['current_page'] = $page_no;
		$deleted = 0;
		$data['event_data'] = $this->eventmodel->getEvents(($page_no - 1) * $item_per_page, ($page_no * $item_per_page), $deleted, $search_string);
		$data['search_string'] = $search_string;
		$data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
//        $this->load->View('includes/Header');
//        $this->load->View('includes/Navigation', $data);
//        $this->load->View('EventManagement', $data);
//        $this->load->View('includes/Footer');
		$this->loadpage($data, 'EventManagement', 'Manage event | BALIYOGHAR');
	}

	//Form Validations
    function is_valid_end_date($end_date, $start_date)
    {
		if($start_date>$end_date){
            $this->form_validation->set_message('is_valid_end_date', 'Invalid %s : End date must be greater than Start Date');
            return FALSE;
		};
        return TRUE;
    }

}

?>
