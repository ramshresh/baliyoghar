<?php

class Event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('Home/login', 'refresh');
        }
        $this->load->model('eventmodel');
        $this->load->model('functionsmodel');
        $this->load->model('coursemodel');
        $this->load->model('personmodel');
    }

    public function refresh($function = 'Home/Home') {
        redirect($function, 'refresh');
    }

    public function loadpage($data = null, $view = 'Home', $pagetitle = 'HOME | BCIPN', $page = array('includes/Header', 'includes/Navigation')) {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['pagetitle'] = $pagetitle;
        for ($i = 0; $i < count($page); $i++) {
            $this->load->View($page[$i], $data);
        }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

    public function event() {
        $this->loadpage(null, 'Events', 'Add new Event | BCIPN');
    }

    public function createEvent() {
        $this->form_validation->set_rules('event_title', 'Event title ', 'required');
        if ($this->form_validation->run() == false) {
            $this->event();
        } else {
            $this->sendDataToModel();
        }
    }

    public function sendDataToModel() {
        $event_title = $this->input->post('event_title');
        $event_course_category = $this->input->post('event_course_category');
        $event_course_subcategory = $this->input->post('event_course_subcategory');
        $event_level = $this->input->post('event_level');
        $event_year = $this->input->post('event_year');
        $event_start_date = $this->input->post('event_start_date');
        $event_end_date = $this->input->post('event_end_date');
        $event_implementedby = $this->input->post('event_implementedby');
        $event_venue = $this->input->post('event_venue');
        $event_address = $this->input->post('event_address');
        $event_country = $this->input->post('event_country');
        //  $event_cost_sharing = $this->input->post('event_cost_sharing');

        /* get the cost shares percentage of the parties */
        /*
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
         */

        $date = date("Y-m-d H:i:s");
        $created_by = $this->session->userdata('username');
        $event_data = array(
            'event_id' => NULL,
            'title' => $event_title,
            'course_cat_id' => $event_course_category,
            'course_subcat_id' => $event_course_subcategory,
            'level' => $event_level,
            'year' => $event_year,
            'start_date' => $event_start_date,
            'end_date' => $event_end_date,
            'implemented_by' => $event_implementedby,
            'venue' => $event_venue,
            'address' => $event_address,
            'country' => $event_country,
            'created_by' => $created_by,
            'created_date' => $date
                // 'cost_sharing' => $event_cost_sharing,
        );

        $event_id = $this->testIfEventExists(array(
            'title' => $event_title,
            'course_cat_id' => $event_course_category,
            'course_subcat_id' => $event_course_subcategory,
            'level' => $event_level,
            'year' => $event_year,
            'start_date' => $event_start_date,
            'end_date' => $event_end_date,
            'implemented_by' => $event_implementedby,
            'venue' => $event_venue,
            'address' => $event_address,
            'country' => $event_country,
                //'cost_sharing' => $event_cost_sharing,
                ));



        $data['title'] = $event_title;
        $data['course'] = $this->coursemodel->getCourseName($event_course_category);
        $data['subcourse'] = $this->coursemodel->getSubCourseName($event_course_subcategory);
        $data['start_date'] = $event_start_date;
        $data['end_date'] = $event_end_date;
        $data['venue'] = $event_venue;
        $data['address'] = $event_address;
        $data['person_data'] = $this->personmodel->getPeople(0, 30);

        if ($event_id != "0") {
            $this->loadEventDetail($event_id);
        } else {
            /* save event detail and cost shares */
            //$event_id = $this->eventmodel->saveEventData($event_data, $csparty_value);
            $event_id = $this->eventmodel->saveEventData($event_data);
            if ($event_id != 0) {
                $data['event_id'] = $event_id;
                $data['event_title'] = $event_title;
                $this->loadpage($data, 'People', 'Add participants | BCIPN');
            }
        }
    }

    function person_exists() {
        $fullname = $this->input->post('fullname');
        $dob = $this->input->post('dob');
        $mobile = $this->input->post('mobile');
        $person_data = $this->eventmodel->person_exists($fullname, $dob, $mobile);
        echo $person_data;
    }

    function addParticipant() {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['event_id'] = $this->input->get('id', TRUE);
        $event_detail = $this->eventmodel->getEventDetail($this->input->get('id', TRUE));
        $data['event_title'] = $event_detail[1];
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('people', $data);
        $this->load->View('includes/Footer');
    }

    public function updateEvent() {
        $event_id = $this->input->post('event_id');
        $event_title = $this->input->post('event_title');
        $event_course_category = $this->input->post('event_course_category');
        $event_course_subcategory = $this->input->post('event_course_subcategory');
        $event_level = $this->input->post('event_level');
        $event_year = $this->input->post('event_year');
        $event_start_date = $this->input->post('event_start_date');
        $event_end_date = $this->input->post('event_end_date');
        $event_implementedby = $this->input->post('event_implementedby');
        $event_venue = $this->input->post('event_venue');
        $event_address = $this->input->post('event_address');
        $event_country = $this->input->post('event_country');
        // $event_cost_sharing = $this->input->post('event_cost_sharing');
        //  $this->load->model('eventmodel');
        //  $this->load->model('functionsmodel');

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

        $event_data = array(
            'title' => $event_title,
            'course_cat_id' => $event_course_category,
            'course_subcat_id' => $event_course_subcategory,
            'level' => $event_level,
            'year' => $event_year,
            'start_date' => $event_start_date,
            'end_date' => $event_end_date,
            'implemented_by' => $event_implementedby,
            'venue' => $event_venue,
            'address' => $event_address,
            'country' => $event_country
                //  'cost_sharing' => $event_cost_sharing,
        );
        $this->updateEventData($event_data, $event_id, $csparty_value);
    }

    public function updateEventData($data, $event_id, $csparty_value) {
        $this->load->model('personmodel');
        $success = $this->eventmodel->updateEventData($data, $event_id, $csparty_value);
        $this->loadEventDetail($event_id);
    }

    public function testIfEventExists($data_array) {
        //  $this->load->model('functionsmodel');
        $success = $this->eventmodel->testIfEventExists($data_array);
        return $success;
    }

    public function deleteEvent() {
        // $this->load->model('functionsmodel');
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $success = $this->eventmodel->deleteEvent($this->input->get('id', TRUE));
        $this->deleteParticipants($this->input->get('id', TRUE));
        $data['event_data'] = $this->eventmodel->getEvents(0, 30);
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('EventManagement', $data);
        $this->load->View('includes/Footer');
    }

    public function deleteParticipants($event_id) {
        //  $this->load->model('functionsmodel');
        $success = $this->eventmodel->deleteParticipants($event_id);
    }

//--------------------------------------------------------------------------------------------------------
    public function editEvent() {
        //TODO
        $event_id = $this->input->get('id', TRUE);

        // $this->load->model('functionsmodel');
        $eventDetail_array = $this->eventmodel->getEventDetail($event_id);

        $data['share'] = $this->eventmodel->getShare($event_id);
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
        $data['implemented_by'] = $eventDetail_array[9];
        $data['address'] = $eventDetail_array[10];
        $data['country'] = $eventDetail_array[11];
        // $data['cost_sharing'] = $eventDetail_array[12];

        $data['csparty_array'] = $this->functionsmodel->getALLCostSharingParties();
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('EditEvent', $data);
        $this->load->View('includes/Footer');
    }

//--------------------------------------------------------------------------------------------------------------    



    public function viewEvent() {
        //  $this->load->model('functionsmodel');
        $event_id = $this->input->get('id', TRUE);
        $this->loadEventDetail($event_id);
    }

    public function loadEventDetail($event_id) {
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
        $data['implemented_by'] = $event_detail_array[9];
        $data['address'] = $event_detail_array[10];
        $data['country'] = $event_detail_array[11];
        // $data['cost_sharing'] = $event_detail_array[12];

        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('EventDetail', $data);
        $this->load->View('includes/Footer');
    }

    /* just for the ajax call */

    public function grabSubCourseData_async() {
        $course_id = $this->input->post('course_cat_id');

        //  $this->load->model('eventmodel');
        $success = $this->eventmodel->getSubCourseData($course_id);

        if ($success == "no") {
            echo "no";
        } else {
            echo $success;
        }
    }

    public function addInstructor_async() {
        $personId = $this->input->post('person_id');
        $eventId = $this->input->post('event_id');
        $event_instructor = $this->input->post('event_inst');
        // $this->load->model('functionsmodel');
        $success = $this->functionsmodel->addInstructor($personId, $eventId, $event_instructor);
        if ($success == "1") {
            echo "yes";
        } else {
            echo "no";
        }
    }

    public function addCandidate_async() {
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

    public function deleteCandidate_async() {
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

    public function search_person_async() {
        $string = $this->input->post('search_string');
        $identifier = $this->input->post('identifier');
        //  $this->load->model('functionsmodel');
        $success = $this->functionsmodel->searchPerson_async($string, $identifier);
        echo $success;
    }

    public function searchEvent() {
        $item_per_page = 30;
        $page_no = 1;
        $string = $this->input->post('event_searchString');

        $data['search_string'] = $string;
        $deleted = 0; // show data which are not deleted
        $data['event_data'] = $this->eventmodel->getEvents(($page_no - 1) * $item_per_page, ($page_no * $item_per_page), $deleted, $string);
        $data['total_pages'] = $this->eventmodel->getEvent_pagination_totalpage();
        $data['current_page'] = $page_no;
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();

        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('eventManagement', $data);
        $this->load->View('includes/Footer');
    }

    public function event_pagination() {
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
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('eventManagement', $data);
        $this->load->View('includes/Footer');
    }

}

?>
