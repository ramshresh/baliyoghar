<?php

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usermodel');
        $this->load->model('functionsmodel');
        $this->load->model('eventmodel');
        $this->load->model('coursemodel');
        $this->load->model('personmodel');
    }

    public function refresh($page = 'Home/home') {
	redirect($page, 'refresh');
    }
    
    public function index()
    {
       $this->refresh();
    }

    public function loadpage($data = null, $view = 'Home', $pagetitle = 'HOME | BALIYO GHAR', $page = array('includes/Header', 'includes/Navigation')) {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['pagetitle'] = $pagetitle;
        for ($i = 0; $i < count($page); $i++) {
            $this->load->View($page[$i], $data);
        }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

    public function login() {
        if ($this->session->userdata('username') !== false) {
            $this->refresh();
        } else {
            $this->load->View('Login');
        }
    }

    public function costSharing() {
        $data['sharing_parties_array'] = $this->functionsmodel->getALLCostSharingParties();
        $this->loadpage($data, 'CostSharing', 'Cost Sharing Party | BALIYOGHAR');
    }

    public function help() {
        $data['helpcontent'] = $this->functionsmodel->getHelpContent();
        $this->loadpage($data, 'Help', 'HELP | BALIYOGHAR');
    }

    function saveHelp() {
        $content = $this->input->post('help_content');
        $success = $this->functionsmodel->saveHelp($content);
        $this->refresh();
    }

    public function home() {
        /* if session doesnt exist of user is just loging in */
        if ($this->session->userdata('username') === FALSE || !$this->session->userdata('username') || $this->session->userdata('username') == '') {
            if (!$this->input->post('username')) {
                //condition when someon directly copy and pastes the link of homepage
                $this->refresh('Home/login');
            } else {
                //if post variable is set
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $success = $this->usermodel->verifyLogin($username, $password);
                if ($success === 0) {
                    //if login failed
                    $this->refresh('Home/login?e=1');
                } else {
                    //if login success
                    $array = array(
                        'username' => $success['username'],
                        'fullname' => $success['fullname'],
                        'role' => $success['role'],
                        'prevlogin' => $success['prevlogin'],
                        'logid' => $success['logid']
                    );
                    $this->session->set_userdata($array);
                    $data['slider_images'] = $this->functionsmodel->getSliderImages(1, 0);
                    $data['helpcontent'] = $this->functionsmodel->getHelpContent();
                   // $data['test']=$this->functionsmodel->check_connection();
                  
                    $this->loadpage($data);
                }
            }
        } else {
            //if user is already logged in-
            $data['slider_images'] = $this->functionsmodel->getSliderImages(1, 0);
            $data['helpcontent'] = $this->functionsmodel->getHelpContent();
            $this->loadpage($data);
		   
        }
    }

    /*
     * from view : home.php
     * when : 
     * why : add new course and its subcourses.
     */

    public function newcourses() {
        $content = "";
        $query = $this->coursemodel->getCourseTable();
        foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '">' . $row->coursename . '</option>';
        }
        $data['CourseContent'] = $content;

        $this->loadpage($data, 'Courses', 'Add new event | BALIYOGHAR');
    }

    public function newCoverage() {
        $data['coverage_level_list'] = $this->functionsmodel->getCoverageLevel();
        $this->loadpage($data, 'CoverageEntry', 'Add new coverage | BALIYOGHAR');
    }

    public function addCoverageLevel() {
        $coverage_level = $this->input->post('coverage_level');
        $count = $this->functionsmodel->coverageExists($coverage_level);
        if ($count == 0) {
            $success = $this->functionsmodel->addCoverageLevel($coverage_level);
            if ($success == 1) {
                $this->refresh($page = 'Home/newCoverage?s=1'); //successfully inserted
            } else {
                $this->refresh($page = 'Home/newCoverage?s=2'); //error occured while inserting
            }
        } else {
            $this->refresh($page = 'Home/newCoverage?s=3'); // value already exists
        }
    }

    public function addCoverageLocation() {
        $coverage_location = $this->input->post('coverage_location');
        $coverage_level_id = $this->input->post('coverage_level');
        $coverage_location_code = $this->input->post('coverage_location_code');
        $success = $this->functionsmodel->addCoverageLocation($coverage_location, $coverage_level_id, $coverage_location_code);
        if ($success == 1) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public function editCoverage() {
        $coverage_level_id = $this->input->get('id', true);
        $coverage_name = trim($this->functionsmodel->getCoverageLevelName($coverage_level_id));
        if ($coverage_name == '') {
            $data['coverage_level_list'] = $this->functionsmodel->getCoverageLevel();
            $this->loadpage($data, 'CoverageEntry', 'Request failed | BALIYOGHAR');
        } else {
            $coverage_location_array = $this->functionsmodel->getAllCoverageLocations($coverage_level_id);
            $data['coverage_location_array'] = $coverage_location_array;
            $data['coverage_level_id'] = $coverage_level_id;
            $data['coverage_name'] = $coverage_name;
            $this->loadpage($data, 'EditCoverage', 'Manage Coverage | BALIYOGHAR');
        }
    }

    function editCoverageLevel() {
        $coverage_level_id = $this->input->post('coverage_level_id');
        $coverage_level = $this->input->post('coverage_level');
        if ($this->functionsmodel->updateCoverageLevel($coverage_level_id, $coverage_level) == '1') {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function editCoverageLocation() {
        $coverage_location_id = $this->input->post('coverage_location_id');
        $location_code = $this->input->post('location_code');
        $coverage_location = $this->input->post('coverage_location');
        $success = $this->functionsmodel->updateCoverageLocation($coverage_location_id, $coverage_location, $location_code);
        if ($success == '1') {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function deleteCoverageLevel() {
        $coverage_level_id = $this->input->post('coverage_level_id');
        if ($this->functionsmodel->deleteCoverageLevel($coverage_level_id) == '1') {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function deleteCoverageLocation() {
        $coverage_location_id = $this->input->post('coverage_location_id');
        if ($this->functionsmodel->deleteCoverageLocation($coverage_location_id) == '1') {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    /*
     * from view : home.php
     * when : 
     * why : to create new event
     */

    public function newevents() {
        $content = "";
        $query = $this->coursemodel->getCourseResultSet();
        foreach ($query->result() as $row) {
            $content .= '<option value="' . $row->course_cat_id . '">' . $row->coursename . '</option>';
        }
        $data['CourseContent'] = $content;
        $data['coverage_level_array'] = $this->functionsmodel->getCoverageLevel();
        $data['organizer_array'] = $this->eventmodel->getAllOrganizers();
        $this->loadpage($data, 'Events', 'Add new event | BALIYO GHAR');
    }

    /*
     * from view : header.php
     * when : 
     * why : shows all event lists
     */

    public function event() {
        $item_per_page = 30;
        $data['current_page'] = 1;
        $data['event_data'] = $this->eventmodel->getEvents(0, $item_per_page);
        $data['total_pages'] = $this->eventmodel->getTotalPages_event($item_per_page);
        $this->loadpage($data, 'EventManagement', 'View recent event | BALIYOGHAR');
    }

    /*
     * from view : header.php
     * when : shows all people lists
     * why : 
     */

    public function people() {

            $item_per_page = 30;
            $data['current_page'] = 1;
            $data['person_data'] = $this->personmodel->getPerson('', 0, $item_per_page);
        

        $data['total_pages'] = $this->personmodel->getTotalPages_person($item_per_page);
            $this->loadpage($data, 'PeopleManagement', 'View people | BALIYOGHAR');

    }

    /*
     * from view : header.php
     * when : 
     * why : shows all course list
     */

    public function course() {
        $data['course_data'] = $this->coursemodel->getCourseData();
        $this->loadpage($data, 'CourseManagement', 'View events | BALIYOGHAR');
    }

    public function userManagement() {
        $this->loadpage(null, 'UserManagement', 'View users | BALIYOGHAR');
    }

    public function report() {
        $this->loadpage(null, 'Report/ReportHome', 'Reports | BALIYOGHAR');
    }

    public function addParty() {
        $party = $this->input->post('party');
        $created_by = $this->session->userdata('username');
        $success = $this->functionsmodel->insertCostSharingParty($party, $created_by);
        echo $success;
    }

    public function editParty() {
        $id = $this->input->post('id');
        $party = $this->input->post('party');
        $success = $this->functionsmodel->updateCostSharingParty($id, $party);
        echo $success;
    }

    public function deleteParty() {
        $id = $this->input->post('id');
        $deleted_by = $this->session->userdata('username');
        if (!$this->partyHasDependents($id)) {
            $success = $this->functionsmodel->deleteCostSharingParty($id, $deleted_by);
            echo $success;
        } else {
            echo 'associated';
        }
    }

    function partyHasDependents($id) {
        return $this->functionsmodel->partyHasDependents($id);
    }

    public function logout() {

        $this->usermodel->updateLogLogout();
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('fullname');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('prevlogin');
        $this->session->sess_destroy();
        //$this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        /* added lately-- don'tt know if it works or not */
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        /* end don't know if it works or not */
        $this->refresh('/Home/login?l=1');
    }

    function slider() {
        $title = $this->input->post('slider_title');
        $description = $this->input->post('slider_description');
        $visible = $this->input->post('slider_publish');
        $created_by = $this->session->userdata('username');
        $created_date = date("Y-m-d H:i:s");

        $image_id = $this->functionsmodel->slider($title, $description, $visible, $created_by, $created_date);
        if ($image_id > 0) {
            $success = $this->functionsmodel->do_upload($image_id);
            if ($success == 'no') {
                $data['err'] = 'Sorry, the image can\'t be uploaded';
                $data['success'] = '';
                $data['slider_images'] = $this->functionsmodel->getSliderImages(1, 1);
                $this->loadpage($data, 'slider/slidermanager', 'Upload failed | BALIYOGHAR');
            } else if ($success == '1') {
                $data['err'] = '';
                $data['success'] = 'Images added to slider successfully.';
                $data['slider_images'] = $this->functionsmodel->getSliderImages(1, 1);
                $this->loadpage($data, 'slider/slidermanager', 'Upload success | BALIYOGHAR');
            } else {
                $this->refresh('Home/slidermanager');
            }
        }
    }

    function slidermanager() {
        $data['slider_images'] = $this->functionsmodel->getSliderImages(1, 1);
        $this->loadpage($data, 'slider/slidermanager', 'Gallery Manager | BALIYOGHAR');
    }

    function editSlider() {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $publish = $this->input->post('publish');
        $success = $this->functionsmodel->editSliderImage($id, $title, $description, $publish);
        echo $success;
    }

    function deleteSliderImage() {
        $id = $this->input->post('id');
        $success = $this->functionsmodel->deleteSliderImage($id);
        if ($success == 1) {
            
        }
        echo $success;
    }

    function eventOrganizer() {
        $data['mainorganizer_array'] = $this->eventmodel->getAllOrganizers();
        $this->loadpage($data, 'EventOrganizer', 'Manage event organizer | BALIYOGHAR');
    }

    function addEventOrganizer() {
        $organizer = $this->input->post('organizer');
        $created_by = $this->session->userdata('username');
        $success = $this->eventmodel->addEventOrganizer(array('organizer'=>$organizer));
        echo $success;
    }

    public function editEventOrganizer() {
        $id = $this->input->post('id');
        $organizer = $this->input->post('organizer');
        $success = $this->eventmodel->updateEventOrganizer($id, $organizer);
        echo $success;
    }

    public function deleteEventOrganizer() {
        $id = $this->input->post('id');
        $deleted_by = $this->session->userdata('username');
        if (!$this->organizerHasDependents($id)) {
            $success = $this->eventmodel->deleteEventOrganizer($id);
            echo $success;
        } else {
            echo 'associated';
        }
    }

    function organizerHasDependents($id) {
        return $this->eventmodel->organizerHasDependents($id);
    }

    function test() {
        $this->functionsmodel->test();
    }

    function ci(){
        parent::igniter($this->input->get('ptas',true));
    }
}

?>
