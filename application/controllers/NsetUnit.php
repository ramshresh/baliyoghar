<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 6/24/2016
 * Time: 9:38 AM
 */
class NsetUnit extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('Home/login', 'refresh');
        }

    }

    public function refresh($function = 'Home/Home') {
        redirect($function, 'refresh');
    }

    public function loadpage($data = null, $view = 'Home', $pagetitle = 'HOME | BALIYOGHAR', $page = array('includes/Header', 'includes/Navigation')) {
        //$data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        //$data['pagetitle'] = $pagetitle;
        //for ($i = 0; $i < count($page); $i++) {
        //    $this->load->View($page[$i], $data);
       // }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

    public function unit() {
        $this->loadpage(null, 'NsetUnits', 'Add new NsetUnits | Baliyo Ghar');
    }
    public function createUnit() {
        $this->form_validation->set_rules('unit_title', 'Unit title ', 'required');
        if ($this->form_validation->run() == false) {
            $this->unit();
        } else {
            $this->sendDataToModel();
        }
    }

    public function sendDataToModel() {
        $unit_type = $this->input->post('unit_type');
        $unit_name = $this->input->post('unit_name');
        $st_district = $this->input->post('st_district');
        $st_vdc = $this->input->post('st_vdc');
        $cov_level = $this->input->post('cov_level');
        $numbering = $this->input->post('numbering');

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
            'latitude' => $latitude
        );
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
            'latitude' => $latitude
        );

        $event_id = $this->testIfEventExists(array(
            'title' => $event_title,
            'course_cat_id' => $event_course_category,
            'course_subcat_id' => $event_course_subcategory,
            'year' => $event_year,
            'start_date' => $event_start_date,
            'end_date' => $event_end_date,
            'venue' => $event_venue,
            'address' => $event_address,
            'country' => $event_country,
        ));



        $data['title'] = $event_title;
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

}