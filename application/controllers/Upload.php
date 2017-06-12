<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 6/8/2017
 * Time: 2:29 PM
 */
class Upload extends CI_Controller
{

    public function makeDate($inputDate)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $inputDate)) {
            return $inputDate;
        } else {
            if (is_numeric($inputDate)) {
                $unixDate = ($inputDate - 25569) * 86400;
                return gmdate("Y-m-d", $unixDate);
            } else {
                return FALSE;
            }

        }
    }


    public function loadpage($data = null, $view = 'Home', $pagetitle = 'HOME | BALIYO GHAR', $page = array('includes/Header', 'includes/Navigation'))
    {
        $data['pagetitle'] = $pagetitle;
        for ($i = 0; $i < count($page); $i++) {
            $this->load->View($page[$i], $data);
        }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

    private function excel_import($fileName)
    {
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($fileName);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

        $keys = array();
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            if ($row == 1) {
                $keys[$column] = $data_value;
            } else {
                $arr_data[$row - 2][$keys[$column]] = $data_value;
            }
        }
        return $arr_data;
    }

    public function testIfEventExists($data_array)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where($data_array);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count > 0) {
            foreach ($query->result() as $row) {
                if ($row->uid !== null) {
                    return $row->event_id;
                }
            }
        }
    }

    public function loadEventDetail($event_id)
    {
        $this->load->model('personmodel');
        $this->load->model('coursemodel');
        $this->load->model('eventmodel');
        $this->load->model('functionsmodel');

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

    private function sendEventDataToModel($events)
    {
        $response = array(
            'status' => 'failed',
            'message' => 'Could not save',
            'errors' => array(),
        );
        $this->load->model('personmodel');
        $this->load->model('coursemodel');
        $this->load->model('eventmodel');
        $event_title = isset($events['title']) ? $events['title'] : '';
        $event_code = isset($events['event_code']) ? $events['event_code'] : null;
        $event_course_category = isset($events['course_cat_id']) ? $events['course_cat_id'] : null;
        $event_course_subcategory = isset($events['event_course_subcategory']) ? $events['event_course_subcategory'] : null;
        $coverage_level = isset($events['coverage_level']) ? $events['coverage_level'] : null;
        $coverageLocation = isset($events['coverage_location']) ? $events['coverage_location'] : null;
        $event_year = isset($events['year']) ? $events['year'] : -1;
        $event_start_date = isset($events['start_date']) ? $events['start_date'] : null;
        $event_end_date = isset($events['end_date']) ? $events['end_date'] : null;
        $event_venue = isset($events['venue']) ? $events['venue'] : null;
        $event_address = isset($events['address']) ? $events['address'] : null;
        $event_country = isset($events['country']) ? $events['country'] : null;
        $longitude = isset($events['longitude']) ? $events['longitude'] : null;
        $latitude = isset($events['latitude']) ? $events['latitude'] : null;
        $district = isset($events['district']) ? $events['district'] : null;
        $vdc = isset($events['vdc']) ? $events['vdc'] : null;
        $ward_no = isset($events['ward_no']) ? $events['ward_no'] : null;
        $tole = isset($events['tole']) ? $events['tole'] : null;
        $uid = isset($events['uid']) ? $events['uid'] : null;


        $date = date("Y-m-d H:i:s");
        $created_by = $this->session->userdata('username');

        $event_data_insert = array(
            'uid' => $uid,
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


        $event_id = $this->testIfEventExists(array(
            'title' => $event_title,
            'uid' => $uid,
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

        $data = array_merge($data, $this->personmodel->getRelatedDropDownSelects());


        if ($event_id !== null) {
            //  if ($identifier != 'edit') {
            $data['course'] = $this->coursemodel->getCourseName($event_course_category);
            $data['subcourse'] = $this->coursemodel->getSubCourseName($event_course_subcategory);
            $data['start_date'] = $event_start_date;
            $data['end_date'] = $event_end_date;
            $data['venue'] = $event_venue;
            $data['address'] = $event_address;
            $data['person_data'] = $this->personmodel->getPeople(0, 30);

            $response = array(
                'status' => 'failed',
                'message' => 'Event already exists',
                'errors' => array('uid' => $uid, 'event_id' => $event_id),
            );
            //Duplicate
            //$this->loadEventDetail($event_id);
            //  }
        } else {
            $event_id = $this->eventmodel->saveEventData($event_data_insert, [], []);
            if ($event_id != 0) {
                $data['event_id'] = $event_id;
                $data['event_title'] = $event_title;
                //Success
                $response = array(
                    'status' => 'success',
                    'message' => 'Saved Successfully',
                    'errors' => array(),
                );

            } else {
                $response = array(
                    'status' => 'failed',
                    'message' => 'Failed while saving to database',
                    'errors' => $this->db->_error_message()
                );
            }
        }
        return $response;
    }

    private function sendPersonDataToModel($data)
    {

        $response = array(
            'status' => 'failed',
            'message' => 'Could not save',
            'errors' => array(),
        );
        $this->load->model('personmodel');
        $this->load->model('functionsmodel');

        //$success = $this->personmodel->savePersonData($data);

        $event_id = $data['event_id'];
        unset($data['event_id']);
        $participant_type = $data['participant_type'];
        unset($data['participant_type']);
        $beneficiary_type = $data['beneficiary_type'];
        unset($data['beneficiary_type']);
        $certification_status = $data['certification_status'];
        unset($data['certification_status']);
        $person_id = $this->personmodel->savePersonData($data);


        $person_detail = $this->personmodel->getPersonDetail($person_id);

        if ($person_id != '0') {
            // public function addInstructor($personId, $eventId, $event_instructor, $person_age, $beneficiary_type=null,$certification_status=null) {
            $success = $this->functionsmodel->addInstructor($person_id, $event_id, $participant_type, $data['age'], $beneficiary_type, $certification_status);//$person_detail[4]=age

            if ($success) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Saved Successfully',
                    'errors' => array(),
                );
            } else {
                $response = array(
                    'status' => 'failed',
                    'message' => 'Failed while saving to database',
                    'errors' => $this->db->_error_message()
                );
            }
        }

        return $response;
    }

    public
    function upload_trainings()
    {

        $data = [];
        $this->load->model('eventmodel');
        $config['upload_path'] = './assets/upload';
        $config['allowed_types'] = 'xls|ods|xlsx';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $this->load->library('upload', $config);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_FILES['userfile']) || (!file_exists($_FILES['userfile']['tmp_name'])
                    || !is_uploaded_file($_FILES['userfile']['tmp_name']))
            ) {
                $data['toast_message'] = array('title' => 'Error', 'message' => 'Please upload file', 'class' => 'danger');
            } else {
                $uploadedFile = $_FILES["userfile"]["tmp_name"];
                $importedData = $this->excel_import($uploadedFile);
                $validateData_trainings = [];
                foreach ($importedData as $training) {
                    $tempTraining['uid'] = isset($training['uid']) ? $training['uid'] : null;
                    $tempTraining['event_title'] = isset($training['title']) ? $this->makeDate($training['title']) : null;
                    $tempTraining['event_start_date'] = isset($training['start_date']) ? $this->makeDate($training['start_date']) : null;
                    $tempTraining['event_end_date'] = isset($training['end_date']) ? $this->makeDate($training['end_date']) : null;
                    $tempTraining['event_venue'] = isset($training['venue']) ? $training['venue'] : null;
                    $tempTraining['event_address'] = isset($training['address']) ? $training['address'] : null;
                    $tempTraining['event_country'] = isset($training['country']) ? $training['country'] : null;
                    $tempTraining['longitude'] = isset($training['longitude']) ? $training['longitude'] : null;
                    $tempTraining['latitude'] = isset($training['latitude']) ? $training['latitude'] : null;
                    $tempTraining['event_code'] = isset($training['event_code']) ? $training['event_code'] : null;
                    $tempTraining['district'] = isset($training['district']) ? $training['district'] : null;
                    $tempTraining['year'] = isset($training['year']) ? $training['year'] : -1;
                    $tempTraining['vdc'] = isset($training['vdc']) ? $training['vdc'] : null;
                    $tempTraining['ward_no'] = isset($training['ward_no']) ? $training['ward_no'] : null;
                    $tempTraining['course_cat_id'] = isset($training['course_cat_id']) ? $training['course_cat_id'] : null;
                    $tempTraining['coverage_level'] = isset($training['coverage_level']) ? $training['coverage_level'] : null;
                    $tempTraining['coverage_location'] = isset($training['coverage_location']) ? $training['coverage_location'] : null;

                    $year = intval(explode('-', $tempTraining['event_start_date'])[0]);
                    $tempTraining['event_year'] = isset($training['year']) ? $training['year'] : $year;

                    //
                    array_push($validateData_trainings, $training);
                }

                //Prepare and run validation
                $validateData = array(
                    'events' => $validateData_trainings
                );
                $this->form_validation->set_data($validateData);
                //setting rules for participants data
                foreach ($validateData_trainings as $key => $data) {
                    $row = $key + 1;
                    if (isset($data['event_code'])) {
                        $this->form_validation->set_rules(
                            "events[$key][code]",
                            'Code',
                            //'trim|required|callback__unique_code',
                            'trim|is_unique[events.code]',
                            array(
                                'is_unique' => "row:[$row] -- {field} : " . $data['event_code'] . " already exists in the database<br>",
                            )
                        );


                    }

                    $this->form_validation->set_rules(
                        "events[$key][course_cat_id]",
                        'Event Type (course_cat_id)',
                        //'trim|required|callback__unique_code',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- %s is  required ",
                        )
                    );


                    if (isset($data['uid']) && $data['uid'] != "") {
                        $this->form_validation->set_rules(
                            "events[$key][uid]",
                            'Unque IDs',
                            'trim|max_length[36]|is_unique[events.uid]',
                            array(
                                'is_unique' => "row:[$row] -- {field} : " . $data['uid'] . " already exists in the database<br>",
                                'max_length' => "row:[$row] -- {field} : " . $data['uid'] . " cannot exceed 36 characters<br>",
                            )
                        );
                    }

                    $this->form_validation->set_rules(
                        "events[$key][district]",
                        'District',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- {field} is required<br>",
                        )
                    );
                    if (isset($data['district'])) {
                        $this->form_validation->set_rules(
                            "events[$key][district]",
                            'District',
                            'trim|valid_district_name',
                            array(
                                'valid_district_name' => "row:[$row] -- Invalid value " . $data['district'] . " for {field}<br>"
                            )
                        );
                        $this->form_validation->set_rules(
                            "events[$key][vdc]",
                            'VDC',
                            //'required|valid_vdc_name[' . $data['district'] . ']',
                            'valid_vdc_name[' . $data['district'] . ']',
                            array(
                                //'required' => "row:[$row] -- {field} is required at row $row<br>",
                                'valid_vdc_name' => "row:[$row] -- {field} with name '" . $data['vdc'] . "' in  district '" . $data['district'] . "' was not found in database <br>"
                            )
                        );
                    }
                    if (isset($data['latitude'])) {
                        $this->form_validation->set_rules(
                            "events[$key][latitude]",
                            'Latitude',
                            'trim|required|latitude[' . $row . ']',
                            array(
                                'required' => "row:[$row] -- {field} is required<br>",
                            )
                        );
                        $this->form_validation->set_rules(
                            "events[$key][longitude]",
                            'Longitude',
                            'trim|required|longitude[' . $row . ']',
                            array(
                                'required' => "row:[$row] -- {field} is required<br>",
                            )
                        );
                    }
                    if (isset($data['longitude'])) {
                        $this->form_validation->set_rules(
                            "events[$key][longitude]",
                            'Longitude',
                            'trim|required|longitude[' . $row . ']',
                            array(
                                'required' => "row:[$row] -- {field} is required<br>"
                            )
                        );
                        $this->form_validation->set_rules(
                            "events[$key][latitude]",
                            'Latitude',
                            'trim|required|latitude[' . $row . ']',
                            array(
                                'required' => "row:[$row] -- {field} is required<br>",
                            )
                        );
                    }
                }
                if ($this->form_validation->run() == FALSE) {
                    $data['toast_message'] = array(
                        'title' => 'Data Validation Failed',
                        'message' => validation_errors(),
                        'class' => 'danger');
                } else {
                    $this->db->trans_begin();
                    foreach ($validateData_trainings as $tempTraining) {
                        $this->sendEventDataToModel($tempTraining);
                    }
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        //if something went wrong, rollback everything
                        $this->db->trans_rollback();
                        $error = $this->db->error();
                        $data['toast_message'] = array('title' => 'Database Insert Failed', 'message' => $error, 'class' => 'danger');
                    } else {
                        //if everything went right, commit the data to the database
                        $this->db->trans_commit();
                        $data['toast_message'] = array('title' => 'Success', 'message' => '', 'class' => 'info');
                    }
                }
            }
        }
        $this->loadpage($data, 'upload/training/form', 'Upload | Training Events');
    }

    public
    function upload_participants()
    {

        $data = [];
        $duplicates = [];
        $this->load->model('eventmodel');
        $config['upload_path'] = './assets/upload';
        $config['allowed_types'] = 'xls|ods|xlsx';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $this->load->library('upload', $config);


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!isset($_FILES['userfile']) || (!file_exists($_FILES['userfile']['tmp_name'])
                    || !is_uploaded_file($_FILES['userfile']['tmp_name']))
            ) {
                $data['toast_message'] = array('title' => 'Error', 'message' => 'Please upload file', 'class' => 'danger');
            } else {
                $uploadedFile = $_FILES["userfile"]["tmp_name"];
                $importedData = $this->excel_import($uploadedFile);
                $validationData_people = [];
                $insertData_people = [];

                foreach ($importedData as $participant) {
                    $addr = '';
                    if (isset($participant['person_district'])) {
                        if (isset($participant['person_vdc'])) {
                            if (isset($participant['person_ward_no'])) {
                                $addr = $participant['person_ward_no'] . '-' . $participant['person_vdc'] . ', ' . $participant['person_district'];
                            } else {
                                $addr = $participant['person_vdc'] . ', ' . $participant['person_district'];
                            }

                        }
                    }


                    $participant['training_uid'] = isset($participant['training_uid']) ? $participant['training_uid'] : null;
                    $participant['event_id'] = isset($participant['event_id']) ? $participant['event_id'] : null;
                    $participant['participant_type'] = isset($participant['participant_type']) ? $participant['participant_type'] : null;
                    $participant['person_title'] = isset($participant['title']) ? $participant['person_title'] : null;
                    $participant['person_name'] = isset($participant['person_name']) ? $participant['person_name'] : null;
                    $participant['person_dob_np'] = isset($participant['person_dob_np']) ? $participant['person_dob_np'] : null;
                    $participant['person_dob_en'] = isset($participant['person_dob_en']) ? $participant['person_dob_en'] : null;
                    $participant['person_gender'] = isset($participant['person_gender']) ? $participant['person_gender'] : null;

                    $participant['person_district'] = isset($participant['person_district']) ? $participant['person_district'] : null;
                    $participant['person_vdc'] = isset($participant['person_vdc']) ? $participant['person_vdc'] : null;
                    $participant['person_ward_no'] = isset($participant['person_ward_no']) ? $participant['person_ward_no'] : null;


                    $participant['person_paddress'] = isset($participant['person_paddress']) ? $participant['person_paddress'] : $addr;
                    $participant['person_caddress'] = isset($participant['person_caddress']) ? $participant['person_caddress'] : $addr;
                    $participant['person_country'] = isset($participant['person_country']) ? $participant['person_country'] : null;
                    $participant['person_phone'] = isset($participant['person_phone']) ? $participant['person_phone'] : null;
                    $participant['person_mobile'] = isset($participant['person_mobile']) ? $participant['person_mobile'] : null;
                    $participant['person_email'] = isset($participant['person_email']) ? $participant['person_email'] : null;
                    $participant['person_org_name'] = isset($participant['person_org_name']) ? $participant['person_org_name'] : null;
                    $participant['person_org_address'] = isset($participant['person_org_address']) ? $participant['person_org_address'] : null;
                    $participant['person_org_phone'] = isset($participant['person_org_phone']) ? $participant['person_org_phone'] : null;
                    $participant['person_org_fax'] = isset($participant['person_org_fax']) ? $participant['person_org_fax'] : null;
                    $participant['person_position'] = isset($participant['person_position']) ? $participant['person_position'] : null;
                    $participant['person_current_status'] = isset($participant['person_current_status']) ? $participant['person_current_status'] : null;
                    $participant['person_caste_ethnicity'] = isset($participant['person_caste_ethnicity']) ? $participant['person_caste_ethnicity'] : null;
                    $participant['person_citizenship_no'] = isset($participant['person_citizenship_no']) ? $participant['person_citizenship_no'] : null;
                    $participant['age'] = isset($participant['person_age']) ? $participant['person_age'] : null;
                    $participant['education_level'] = isset($participant['education_level']) ? $participant['education_level'] : null;
                    $participant['education'] = isset($participant['education']) ? $participant['education'] : null;
                    $participant['work_type_id'] = isset($participant['work_type_id']) ? $participant['work_type_id'] : null;
                    $participant['work_experience_years'] = isset($participant['work_experience_years']) ? $participant['work_experience_years'] : null;
                    $participant['beneficiary_type'] = isset($participant['beneficiary_type']) ? $participant['beneficiary_type'] : null;
                    $participant['certification_status'] = isset($participant['certification_status']) ? $participant['certification_status'] : null;

                    $participant['person_district'] = isset($participant['person_district']) ? $participant['person_district'] : null;
                    $participant['person_vdc'] = isset($participant['person_vdc']) ? $participant['person_vdc'] : null;
                    $participant['person_ward_no'] = isset($participant['person_ward_no']) ? $participant['person_ward_no'] : null;


                    $personTempData = array(
                        'training_uid' => $participant['training_uid'],
                        'title' => $participant['person_title'],
                        'fullname' => $participant['person_name'],
                        'dob_np' => $participant['person_dob_np'],
                        'dob_en' => $participant['person_dob_en'],
                        'age' => $participant['age'],
                        'gender' => $participant['person_gender'],


                        'district' => $participant['person_district'],
                        'vdc' => $participant['person_vdc'],
                        'ward_no' => $participant['person_ward_no'],


                        'p_address' => $participant['person_paddress'],
                        'c_address' => $participant['person_caddress'],
                        'country' => $participant['person_country'],
                        'phone' => $participant['person_phone'],
                        'mobile' => $participant['person_mobile'],
                        'email' => $participant['person_email'],
                        'org_name' => $participant['person_org_name'],
                        'org_address' => $participant['person_org_address'],
                        'org_phone' => $participant['person_org_phone'],
                        'org_fax' => $participant['person_org_fax'],
                        'position' => $participant['person_position'],
                        'current_status' => $participant['person_current_status'],
                        'created_by' => $this->session->userdata('username'),
                        'created_date' => date("Y-m-d H:i:s"),
                        'caste_ethnicity' => $participant['person_caste_ethnicity'],
                        'citizenship_no' => $participant['person_citizenship_no'],

                        'education' => $participant['education'],
                        'work_type_id' => $participant['work_type_id'],
                        'education_level' => $participant['education_level'],
                        'work_experience_years' => $participant['work_experience_years'],

                        'participant_type' => $participant['participant_type'],
                        'beneficiary_type' => $participant['beneficiary_type'],
                        'certification_status' => $participant['certification_status'],
                    );


                    $event_id = $this->testIfEventExists(
                        array(
                            'uid' => $participant['training_uid']
                        )
                    );

                    //echo $event_id;exit;
                    $personTempData['event_id'] = $event_id;
                    $participant['event_id'] = $event_id;
                    //

                    array_push($validationData_people, $participant);
                    array_push($insertData_people, $personTempData);
                }


                //Prepare and run validation
                $validateData = array(
                    'people' => $validationData_people
                );
                $this->form_validation->set_data($validateData);
                //setting rules for participants data
                foreach ($validationData_people as $key => $data) {
                    $row = $key + 1;
                    $this->form_validation->set_rules(
                        "people[$key][person_name]",
                        'Person Name (person_name)',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- %s Required "
                        )
                    );


                    $this->form_validation->set_rules(
                        "people[$key][event_id]",
                        'event_id',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- %s Required "
                        )
                    );


                    $this->form_validation->set_rules(
                        "people[$key][age]",
                        'Age',
                        //'trim|required|callback__unique_code',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- %s is  required ",
                        )
                    );

                    $this->form_validation->set_rules(
                        "people[$key][training_uid]",
                        'Training UID (training_uid)',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- %s is  required ",
                        )
                    );


                    $this->form_validation->set_rules(
                        "people[$key][person_gender]",
                        'Gender',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- %s is  required ",
                        )
                    );
                    $this->form_validation->set_rules(
                        "people[$key][person_caste_ethnicity]",
                        'caste_ethnicity',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- %s is  required ",
                        )
                    );

                    $this->form_validation->set_rules(
                        "people[$key][person_district]",
                        'District',
                        'trim|required',
                        array(
                            'required' => "row:[$row] -- {field} is required<br>",
                        )
                    );


                    if (isset($data['district'])) {
                        $this->form_validation->set_rules(
                            "people[$key][person_district]",
                            'District',
                            'trim|valid_district_name',
                            array(
                                'valid_district_name' => "row:[$row] -- Invalid value " . $data['district'] . " for {field}<br>"
                            )
                        );
                        $this->form_validation->set_rules(
                            "people[$key][person_vdc]",
                            'VDC',
                            //'required|valid_vdc_name[' . $data['district'] . ']',
                            'valid_vdc_name[' . $data['district'] . ']',
                            array(
                                //'required' => "row:[$row] -- {field} is required at row $row<br>",
                                'valid_vdc_name' => "row:[$row] -- {field} with name '" . $data['vdc'] . "' in  district '" . $data['district'] . "' was not found in database <br>"
                            )
                        );
                    }

                }

                if ($this->form_validation->run() == FALSE) {
                    $data['toast_message'] = array(
                        'title' => 'Data Validation Failed',
                        'message' => validation_errors(),
                        'class' => 'danger');
                } else {
                    $this->db->trans_begin();
                    $hasError = false;
                    foreach ($insertData_people as $tempPerson) {
                        $insert = $this->sendPersonDataToModel($tempPerson);
                        if ($insert['status'] == 'failed') {
                            $hasError = false;
                            $data['toast_message'] = array(
                                'title' => 'Database Insert Failed'
                            , 'message' => $insert['message'] . '<hr/' . json_encode($insert['errors']),
                                'class' => 'danger');
                            break;
                        }
                    }

                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        //if something went wrong, rollback everything
                        $this->db->trans_rollback();
                        $error = $this->db->error();
                        $data['toast_message'] = array('title' => 'Database Insert Failed', 'message' => $error, 'class' => 'danger');
                    } else {
                        if (!$hasError) {
                            //if everything went right, commit the data to the database
                            $this->db->trans_commit();
                            $data['toast_message'] = array('title' => 'Success', 'message' => '', 'class' => 'info');
                        } else {
                            $this->db->trans_rollback();
                        }

                    }
                }


            }
        }

        $this->loadpage($data, 'upload/participants/form', 'Upload | Training Events');

    }

}