<?php

require_once 'Home.php';

class Person extends CI_Controller {

    CONST  CASTE_ETHNICITY_LOOKUP = [
            "1"=>"Newar",
            "2"=>"Janajati",
            "3"=>"Bahun/Chhetri",
            "4"=>"Muslim",
            "5"=>"Dalit",
            "6"=>"Other"
        ];
    private $homeController;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('personmodel');
        $this->load->model('functionsmodel');
        $this->load->model('eventmodel');
        $this->load->model('worktypemodel');
        $this->homeController = new Home();
    }

    public function people() {
        $this->homeController->people();
    }

    public function addPerson() {
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

        $education = $this->input->post('education');
        $work_type_id = $this->input->post('work_type_id');

		if(trim($person_dob_np)=='' && trim($person_dob_en)==''){
			$person_dob_np = $person_dob_en = '0000-00-00';
		}

		// nepali date of birth contains / as day,month,year separator..
		//change the separator from / to -
		else if(trim($person_dob_np)!=''){
			$dob_np = explode('/',$person_dob_np);
			$person_dob_np = $dob_np[0].'-'.$dob_np[1].'-'.$dob_np[2];
		}
		
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

        if ($this->form_validation->run() == false) {
            $this->people();
        } else {

            if ($identifier == "insert") {
                $person_id = $this->insertPersonData($data);
                $person_detail = $this->personmodel->getPersonDetail($person_id);
                $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
                if ($person_id != '0') {
                    $this->functionsmodel->addInstructor($person_id, $event_id, $event_instructor,$person_detail[4]);//$person_detail[4]=age
                    $this->personmodel->do_upload($person_id);
                    $msg['insert'] = "1 record inserted successfully";
                    $msg['event_id'] = $event_id;
                    $msg['event_title'] = $event_title;
                    $this->load->View('includes/Header');
                    $this->load->View('includes/Navigation', $data);
                    $this->load->View('People', $msg);
                    $this->load->View('includes/Footer');
                } else {
                    $msg['insert'] = "Insertion failed.";
                    $msg['event_id'] = $event_id;
                    $msg['event_title'] = $event_title;
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

    public function insertPersonData($data) {

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

    public function updatePersonData($data, $person_id) {
        //$this->load->model('personmodel');

        $success = $this->personmodel->updatePersonData($data, $person_id);
        $this->loadPersonDetail($person_id);
    }

    public function viewPerson($action = null) {
        // $this->load->model('functionsmodel');
        $person_id = $this->input->get('id', TRUE);
        if ($action !== null) {
            $action = 'delete';
        }
        $this->loadPersonDetail($person_id, $action);
    }

    public function loadPersonDetail($person_id, $action = null) {
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
        $data['caste_ethnicity_value']=$data['caste_ethnicity']?self::CASTE_ETHNICITY_LOOKUP[$data['caste_ethnicity']]:'';

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

    public function delete() {

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

    public function person_pagination() {
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

    public function searchPeople() {
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

    public function edit() {
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

        $data['education'] =$personDetail_array[27];
        $data['work_type_id'] =$personDetail_array[28];

        $query = $this->worktypemodel->getWorkTypeTable();

        $workTypeSelect = "";
        foreach ($query->result() as $row) {
            if($row->work_type_id==$data['work_type_id']){
                $workTypeSelect .= '<option selected value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
            }
            $workTypeSelect .= '<option value="' . $row->work_type_id . '">' . $row->work_name . '</option>';
        }


        $data['WorkTypeSelect'] = $workTypeSelect;


        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('EditPerson', $data);
        $this->load->View('includes/Footer');
    }

    function changePicture() {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        if ($this->input->get('id', TRUE) != '') {
            $person_id = explode('_', $this->input->get('id', TRUE));
            if ($person_id[0] === 'r') {
                $this->personmodel->removePicture($person_id[1]);
                redirect('Person/edit?id='.$person_id[1], 'refresh');
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

    function addNewPicture() {
        $person_id = $this->input->post('person_id');
        $this->personmodel->do_upload($person_id);
         redirect('Person/edit?id='.$person_id, 'refresh');
    }

    function convertDate(){
        $identifier = $this->input->post('identifier');
        switch($identifier){
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
    }

    /*
   * Method : grbabWorkTypeData_async()
   * from view :
   * when :
   * why :
   */
    public function grabWorkTypeData_async() {
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

}

?>
