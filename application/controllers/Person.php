<?php

require_once 'Home.php';

class Person extends CI_Controller
{

    public $perPage=30;

    private $homeController;

    public $CASTE_ETHNICITY_LOOKUP = [
        "1" => "Newar",
        "2" => "Janajati",
        "3" => "Bahun/Chhetri",
        "4" => "Muslim",
        "5" => "Dalit",
        "6" => "Other"
    ];

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('Home/login', 'refresh');
        }
        $this->load->library('Ajax_pagination');
        $this->load->model('eventmodel');
        $this->load->model('coursemodel');
        $this->load->model('personmodel');

        $this->load->library('user_agent');
        $this->load->helper(array('form', 'url'));
        $this->load->model('personmodel');
        $this->load->model('functionsmodel');
        $this->load->model('eventmodel');
        $this->load->model('worktypemodel');
        $this->load->model('educationlevelmodel');
        $this->load->model('certificationstatusmodel');
        $this->load->model('beneficiarytypemodel');
        $this->load->model('certificationstatusmodel');


        $this->load->helper('url');
        //$this->homeController = new Home();
    }


    public function people()
    {

        redirect('Home/people');
        //$this->homeController->people();
    }

    public function addPerson()
    {

        $referred_from = $this->session->userdata('referred_from');

        $this->form_validation->set_rules('person_name', 'Full name ', 'required');
        $identifier = $person_title = $this->input->post('identifier');

        $event_id = $this->input->post('event_id');

        $event_title = $this->input->post('event_title');
        $event_instructor = $this->input->post('participant_type');

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
        $person_age = $this->input->post('age');

        $education_level = $this->input->post('education_level');


        $education = $this->input->post('education');
        $work_type_id = $this->input->post('work_type_id');
        $work_experience_years = $this->input->post('work_experience_years');

        $beneficiary_type = $this->input->post('beneficiary_type');
        $certification_status = $this->input->post('certification_status');


        if (trim($person_dob_np) == '' && trim($person_dob_en) == '') {
            //$person_dob_np = $person_dob_en = '0000-00-00';
        }

        // nepali date of birth contains / as day,month,year separator..
        //change the separator from / to -
        /*else if (trim($person_dob_np) != '') {
            $dob_np = explode('/', $person_dob_np);
            $person_dob_np = $dob_np[0] . '-' . $dob_np[1] . '-' . $dob_np[2];
        }*/

        $data = array(

            'title' => $person_title,
            'fullname' => $person_name,
            'dob_np' => $person_dob_np,
            'dob_en' => $person_dob_en,
            'age' => $person_age,
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
            'education_level' => $education_level,
            'work_experience_years' => $work_experience_years,
        );


        if ($this->form_validation->run() == false) {
            $this->people();
        } else {

            if ($identifier == "insert") {
                $person_id = $this->insertPersonData($data);
                $person_detail = $this->personmodel->getPersonDetail($person_id);

                $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
                if ($person_id != '0') {
                    $this->functionsmodel->addInstructor($person_id, $event_id, $event_instructor, $person_detail[4], $beneficiary_type, $certification_status);//$person_detail[4]=age
                    $this->personmodel->do_upload($person_id);
                    $msg['insert'] = "1 record inserted successfully";
                    $msg['event_id'] = $event_id;
                    $msg['event_title'] = $event_title;

                    if ($this->input->post('repeat_page') == '1') {
                        $data1 = [];
                        $data1 = array_merge($data1, $this->personmodel->getRelatedDropDownSelects());
                        $data1['event_id'] = $this->input->post('event_id');
                        $data1['event_title'] = $this->input->post('event_title');

                        //{{&&&&&&&&&&&&&
                        $data['event_id'] = $event_id;
                        $event_detail = $this->eventmodel->getEventDetail($event_id);
                        $data['event_title'] = $event_detail[0];


                        $query = $this->worktypemodel->getWorkTypeTable(0, $event_detail[3]);
                        //$query = $this->worktypemodel->getWorkTypeTable();
                        //$query = $this->worktypemodel->getWorkTypeTableByCourseCategoryID($event_detail[3]);
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
                        //$query = $this->beneficiarytypemodel->getBeneficiaryTypeTable(0);
                        $beneficiaryTypeSelect = "";
                        foreach ($query->result() as $row) {
                            $beneficiaryTypeSelect .= '<option value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
                        }
                        $data['beneficiaryTypeSelect'] = $beneficiaryTypeSelect;
                        //}}}
                        //{{{
                        //$query = $this->worktypemodel->getWorkTypeTable();
                        $query = $this->worktypemodel->getWorkTypeTableByCourseCategoryID($event_detail[3]);
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
                            $educationLevelSelect .= '<option value="' . $row->education_level . '">' . $row->education_level . '</option>';
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
                        //}}&&&&&&&&&&&&&&&&

                        $this->load->View('includes/Header');
                        $this->load->View('includes/Navigation', $data);
                        $this->load->View('People', $data);
                        $this->load->View('includes/Footer');
                    }


                } else {
                    $msg['insert'] = "Insertion failed.";
                    $msg['event_id'] = $event_id;
                    $msg['event_title'] = $event_title;

                    if (isset($referred_from)) {
                        redirect($referred_from);
                    }

                    $this->load->View('includes/Header');
                    $this->load->View('includes/Navigation', $data);
                    $this->load->View('People', $msg);
                    $this->load->View('includes/Footer');
                }
            } else if ($identifier == "update") {
                $person_id = $this->input->post('person_id');
                $this->updatePersonData($data, $person_id);
            }
        }
    }

    public function insertPersonData($data)
    {


        $success = $this->personmodel->savePersonData($data);
        return $success;
        if ($success != 0) {
//            $msg['insert'] = "1 record inserted successfully";
//            $this->load->View('includes/Header');
//            $this->load->View('includes/Navigation');
//            $this->load->View('People', $msg);
//            $this->load->View('includes/Footer');
        }
    }

    public function updatePersonData($data, $person_id)
    {
        //$this->load->model('personmodel');

        $success = $this->personmodel->updatePersonData($data, $person_id);
        $this->loadPersonDetail($person_id);
    }

    public function viewPerson($action = null)
    {
        // $this->load->model('functionsmodel');
        $person_id = $this->input->get('id', TRUE);
        if ($action !== null) {
            $action = 'delete';
        }
        $this->loadPersonDetail($person_id, $action);
    }

    public function loadPersonDetail($person_id, $action = null)
    {
        // $this->load->model('FuncgetPersonDetailtionsModel');
        $personDetail_array = $this->personmodel->getPersonDetail($person_id);
        if ($action !== null) {
            $data['action'] = $action;
        }
        $data['person_id'] = $personDetail_array[0];
        $data['title'] = $personDetail_array[1];
        $data['fullname'] = $personDetail_array[2];
        $data['dob_en'] = $personDetail_array[3];
        $data['dob_np'] = $personDetail_array[19];
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
        $data['updated_date'] = $personDetail_array[20];
        $data['caste_ethnicity'] = $personDetail_array[25];
        $data['caste_ethnicity_value'] = $data['caste_ethnicity'] ? $this->CASTE_ETHNICITY_LOOKUP[$data['caste_ethnicity']] : '';

        $data['citizenship_no'] = $personDetail_array[26];

        $data['education'] = $personDetail_array[27];
        $data['work_type_id'] = $personDetail_array[28];

        $work_type_id = $personDetail_array[28];

        $data['work_name'] = $this->worktypemodel->getWorkName($work_type_id);

        $data['participation'] = $this->eventmodel->getAllParticipation($person_id);
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('PersonDetail', $data);
        $this->load->View('includes/Footer');
    }

    public function delete()
    {

        // $this->load->model('functionsmodel');
        $success = $this->personmodel->deletePerson($this->input->get('id', TRUE), $this->session->userdata('username'), $this->session->userdata('role'), date("Y-m-d H:i:s"));

        if (is_array($success)) {
            $data['participation_record'] = $success;
            $this->viewPerson('delete');
        } else {
            $item_per_page = 30;
            $pages = $this->personmodel->getTotalPages_person($item_per_page);
            $data['person_data'] = $this->personmodel->getPerson('', 0, $item_per_page);
            $data['total_pages'] = $pages;
            $data['current_page'] = 1;


            $data['person_data'] = $this->personmodel->getPerson('', 0, 30);
            $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
            $this->load->View('includes/Header');
            $this->load->View('includes/Navigation', $data);
            $this->load->View('PeopleManagement', $data);
            $this->load->View('includes/Footer');
        }
    }

    public function person_pagination()
    {
        $item_per_page = 30;
        $page_no = $this->input->get('page', TRUE);
        $search_string = $this->input->get('search_string', TRUE);

        $pages = $this->personmodel->getTotalPages_person($item_per_page);

        $data['total_pages'] = $pages;
        $data['current_page'] = $page_no;
        $data['person_data'] = $this->personmodel->getPerson($search_string, ($page_no - 1) * $item_per_page, ($page_no * $item_per_page));
        $data['search_string'] = $search_string;
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('PeopleManagement', $data);
        $this->load->View('includes/Footer');
    }

    public function searchPeople()
    {
        $item_per_page = 30;
        $page_no = 1;
        $string = $this->input->post('person_searchString');

        $data['search_string'] = $string;
        $data['person_data'] = $this->personmodel->getPerson($string, ($page_no - 1) * $item_per_page, ($page_no * $item_per_page));
        $data['total_pages'] = $this->personmodel->getPerson_pagination_totalpage();
        $data['current_page'] = $page_no;
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();

        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('PeopleManagement', $data);
        $this->load->View('includes/Footer');
    }

    public function edit()
    {
        $person_id = $this->input->get('id', TRUE);
        //  $person_id = $this->uri->segment(3);

        $personDetail_array = $this->personmodel->getpersonDetail($person_id);

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

        $data['education_level'] = $personDetail_array[27];

        $data['work_type_id'] = $personDetail_array[28];

        $data['work_experience_years'] = $personDetail_array[37];
        //$data['person_work_experience_years'] = $personDetail_array[37];

        $data['age'] = $personDetail_array[30];
        //$data['person_age'] = $personDetail_array[30];

        $data['participations'] = $this->eventmodel->getAllParticipation($person_id);

        /*
        $data['beneficiary_type_id'] =$participation_array[10];
        $query = $this->beneficiarytypemodel->getBeneficiaryTypeTable();
        $beneficiaryTypeSelect = "";
        foreach ($query->result() as $row) {
            if($row->beneficiary_type_id==$data['beneficiary_type_id']){
                $workTypeSelect .= '<option selected value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
            }
            $beneficiaryTypeSelect .= '<option value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
        }
        $data['BeneficiaryTypeSelect'] = $beneficiaryTypeSelect;


        //$data['certification_status_id'] =$participation_array[8];
        */

        //{{{
        $query = $this->worktypemodel->getWorkTypeTable();
        //$query = $this->worktypemodel->getWorkTypeTableByCourseCategoryID($event_detail[3]);
        $workTypeSelect = "";
        foreach ($query->result() as $row) {
            if ($row->work_type_id == $data['work_type_id']) {
                $workTypeSelect .= '<option selected value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
            } else {

                $workTypeSelect .= '<option value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
            }
        }
        $data['WorkTypeSelect'] = $workTypeSelect;
        //}}}

        //{{{


        $query = $this->educationlevelmodel->getEducationLevelTable();
        $educationLevelSelect = "";
        foreach ($query->result() as $row) {

            if ($row->education_level_id == $data['education_level']) {
                $educationLevelSelect .= '<option selected value="' . $row->education_level_id . '">' . $row->education_level . '</option>';
            } else {
                $educationLevelSelect .= '<option value="' . $row->education_level_id . '">' . $row->education_level . '</option>';
            }
        }
        $data['educationLevelSelect'] = $educationLevelSelect;
        //}}}

        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('EditPerson', $data);
        $this->load->View('includes/Footer');
    }

    public function editParticipationForm_async()
    {

        $event_id = $this->input->post('event_id');
        $person_id = $this->input->post('person_id');

        $this->load->model('eventmodel');
        $course_category_id =$this->eventmodel->getCourseCategory($event_id);


        $i = $this->input->post('i');

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
        $data['i']=$i;

        $this->load->model('certificationstatusmodel');
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

        $query = $this->beneficiarytypemodel->getBeneficiaryTypeTable(0,$course_category_id);
        $beneficiaryTypeSelect = "";
        foreach ($query->result() as $row) {
            if ($row->beneficiary_type_id == $data['beneficiary_type_id']) {
                $beneficiaryTypeSelect .= '<option selected value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
            } else {
                $beneficiaryTypeSelect .= '<option value="' . $row->beneficiary_type_id . '">' . $row->beneficiary_name . '</option>';
            }
        }
        $data['beneficiaryTypeSelect'] = $beneficiaryTypeSelect;

        echo $this->load->view('person/edit_participation/_editParticipationForm_async', $data, true);
    }

    public function editParticipationSave_async()
    {
        //$this->form_validation->set_rules('participated_in_id', 'Person Id', 'required');

        $participated_in_id = $this->input->post('participated_in_id');

        $person_id = $this->input->post('person_id');
        $event_id = $this->input->post('event_id');
        $i = $this->input->post('i');

        $is_instructor = $this->input->post('is_instructor');
        $beneficiary_type = $this->input->post('beneficiary_type');
        $certification_status = $this->input->post('certification_status');

        $data = array(
            'is_instructor' => $is_instructor,
            'beneficiary_type' => $beneficiary_type,
            'certification_status' => $certification_status,
        );

        $success = $this->personmodel->updateParticipationInData_participated_in_id($data, $participated_in_id);

        //$participantData = $this->eventmodel->getParticipant($event_id, $person_id);
        $participantData = $this->eventmodel->getSingleParticipationDerail($event_id, $person_id);

        $data = [];
        $data['event_id'] = $event_id;
        $data['person_id'] = $person_id;
        $data['participation'] = $participantData;
        $data['i'] = $i;

        echo $this->load->view('person/edit_participation/_editParticipationRow', $data, true);
    }

    public function unlinkEvent_async()
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

    function changePicture()
    {

        $path1=realpath(APPPATH . '../gallery');
        $path2=realpath(APPPATH . '../gallery/thumbs/');

        if (!is_writable($path1) || !is_writable($path2)) {
            $this->session->set_flashdata('error', validation_errors());
            //throw new Exception("Value must be 1 or below");
            echo 'the upload directory is not writeable: ../gallery    and  ../gallery/thumbs/';exit;
        }
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        if ($this->input->get('id', TRUE) != '') {
            $person_id = explode('_', $this->input->get('id', TRUE));
            if ($person_id[0] === 'r') {
                $this->personmodel->removePicture($person_id[1]);
                redirect('Person/edit?id=' . $person_id[1], 'refresh');
            } else {
                if (is_int(intval($person_id[0]))) {
                    $data['person_id'] = $person_id[0];
                    $data['person_name'] = $this->personmodel->getPersonName($person_id[0], true);
                    $image = $this->personmodel->getPicture($person_id[0]);
                    if ((strpos($image, 'image_') !== false)) {
                        $data['image'] = $image;
                    } else {
                        $data['image'] = '';
                    }
                    $this->load->View('includes/Header');
                    $this->load->View('includes/Navigation', $data);
                    $this->load->View('ChangePicture');
                    $this->load->View('includes/Footer');
                } else {
                    // this may happen if user tries to change url directly
                    $this->people();
                }
            }
        } else {
            // this may happen if user tries to change url directly
            $this->people();
        }
    }

    function addNewPicture()
    {
        $person_id = $this->input->post('person_id');
        $this->personmodel->do_upload($person_id);
        redirect('Person/edit?id=' . $person_id, 'refresh');
    }

    function calculateAge()
    {

        $identifier = $this->input->post('identifier');
        switch ($identifier) {
            case 'en':
                //convert from english to nepali
                $english_date = $this->input->post('dob_en');
                // echo $nepali_date." dt";
                echo $this->personmodel->calculateAge($english_date);
                break;
            case 'np':
                //convert from nepali to english
                $nepali_date = $this->input->post('dob_np');
                //   echo $english_date." dt";
                $english_date = $this->personmodel->getEnglishDate($nepali_date);
                echo $this->personmodel->calculateAge($english_date);
                break;
            default:
                echo 'nothing';
                break;
        }
    }

    function convertDate()
    {
        $identifier = $this->input->post('identifier');
        if (($identifier == 'en' && $this->input->post('dob_en') != '') || ($identifier == 'np' && $this->input->post('dob_np') != '')) {
            switch ($identifier) {
                case 'en':
                    //convert from english to nepali
                    $english_date = $this->input->post('dob_en');
                    // echo $nepali_date." dt";
                    echo $this->personmodel->getNepaliDate($english_date);
                    break;
                case 'np':
                    //convert from nepali to english
                    $nepali_date = $this->input->post('dob_np');
                    //   echo $english_date." dt";
                    echo $this->personmodel->getEnglishDate($nepali_date);
                    break;
                default:
                    echo 'nothing';
                    break;
            }
        } else {
            echo 'nothing';
        }
    }

    /*
   * Method : grbabWorkTypeData_async()
   * from view :
   * when :
   * why :
   */
    public function grabWorkTypeData_async()
    {
        $work_name = $this->input->post('work_name');
        $work_type_id = $this->input->post('work_type_id');
        $date = date("Y-m-d H:i:s");
        $created_by = $this->session->userdata('username');
        $data = array(
            'work_type_id' => $work_type_id,
            'work_name' => $work_name,
            'created_by' => $created_by,
            'created_date' => $date
        );
        $this->load->model('worktypemodel');

        $success = $this->worktypemodel->saveWorkTypeData($data);
        echo $success;
    }

    //START: Pagignated data
    public function people_list_pagination_getViewData(){

        $searchParams = array();
        $data=array();
        //For Ajax POST Request:
        $event_year =(null !== $this->input->post('event_year'))? $this->input->post('event_year'):'';
        $event_month =(null !== $this->input->post('event_month'))? $this->input->post('event_month'):'';
        $event_course_cat_id =(null !== $this->input->post('event_course_category'))? $this->input->post('event_course_category'):'';
        $event_district =(null !== $this->input->post('district'))? $this->input->post('district'):'';
        $event_vdc = (null !== $this->input->post('vdc'))?$this->input->post('vdc'):'';
        $event_ward_no = (null !== $this->input->post('ward_no'))?$this->input->post('ward_no'):'';
        $keywords = (null !== $this->input->post('keywords'))?$this->input->post('keywords'):'';
        $per_page=(null !== $this->input->post('per_page') && '' != $this->input->post('per_page'))?$this->input->post('per_page'):$this->perPage;

        //calc offset number
        $page = $this->input->post('page');
        if(null ===$page || '' ==$page ){
            $offset = 0;
        }else{
            $offset = $page;
        }

        //For AJAX POST REquest Only
        $searchParams['event_year']=$event_year;
        $searchParams['event_month']=$event_month;
        $searchParams['event_course_cat_id']=$event_course_cat_id;
        $searchParams['event_district']=$event_district;
        $searchParams['event_vdc']=$event_vdc;
        $searchParams['event_ward_no']=$event_ward_no;
        $searchParams['keywords']=$keywords;

        $totalRec = count($this->personmodel->getFilteredPeople(
            null,//start
            null,//limit
            null,//deleted
            $searchParams//searchParams
        ));

        //pagination configuration
        $config['target']      = '#peopleList';
        $config['base_url']    = base_url().'person/people_list_pagination_ajax';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';

        $this->ajax_pagination->initialize($config);;
        $data['pagination_links']=$this->ajax_pagination->create_links();

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $per_page;

        //get event data
        $records =$this->personmodel->getFilteredPeople(
            $offset,//start
            $per_page,//limit
            null,//deleted
            $searchParams//searchParams
        );

        //get event data
       /* $records =$this->personmodel->getFilteredPeopleSummary(
            $offset,//start
            $per_page,//limit
            null,//deleted
            $searchParams//searchParams
        );*/



        if(isset($records) && !empty($records)){
            foreach ($records as $index=>$record){
                $event_ids_csvStr = $record['csv_event_ids'];
                $eventIds = explode(',',$event_ids_csvStr);
                $html_list = '<ul class="paginated-tbl-listval-ul" data-person_id="'.$record['person_id'].'">';

                foreach ($eventIds as $eventId){
                    if(isset($eventId) && ''!=$eventId){
                        $event_code=$this->eventmodel->getEventCode($eventId);
                        $link_url =base_url().'Event/viewEvent?id='.$eventId;
                        $link_label =isset($event_code)?'Code: '.$event_code:
                            'ID: '.$record[$eventId];
                        $html_list.='<li class="paginated-tbl-listval-li"><a href="'.$link_url.'">'.$link_label.'</a></li>';
                    }
                }
                $html_list.='</ul>';
                $records[$index]['events_html_links'] = $html_list;
            }
        }



        $data['people']=$records;



        //For Drop Down of Primary Search Panel Initial Load Only
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


        //Selected Filters
        $data['applied_filters']=array();
        $data['applied_filters']['event_year'] = $event_year;
        $this->load->helper('english_dates_helper');
        $data['applied_filters']['event_month'] = $event_month;
        $data['applied_filters']['event_month_name'] = numToEngMonth($event_month);
        $data['applied_filters']['event_course_cat_id'] = $event_course_cat_id;
        $data['applied_filters']['event_type'] = $event_course_cat_id;
        $data['applied_filters']['event_type_name'] = $this->coursemodel->getCourseName($event_course_cat_id);
        $data['applied_filters']['event_district'] = $event_district;
        $data['applied_filters']['event_vdc'] = $event_vdc;
        $data['applied_filters']['event_ward_no'] = $event_ward_no;
        $data['applied_filters']['keywords'] = $keywords;


        return $data;
    }
    public function people_list_pagination(){
        $data = $this->people_list_pagination_getViewData();
        //load the view

        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('person/list_pagination/main', $data);
        $this->load->View('includes/Footer');

        //$this->loadpage($data, 'person/list_pagination/main', 'Event | List');
    }
    public function people_list_pagination_ajax()
    {
        $data = $this->people_list_pagination_getViewData();
        //load the partial view
        $this->load->view('person/list_pagination/ajax', $data, false);
    }
    //END: Pagignated data

}

?>
