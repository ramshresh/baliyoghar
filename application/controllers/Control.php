<?php

class Control extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usermodel');
        $this->load->model('functionsmodel');
        $this->load->model('eventmodel');
        
        $this->load->model('personmodel');
    }

    function dc() {
        //deleted courses and subcourses
        $this->load->model('coursemodel');
        $data['detail']=$this->coursemodel->getDeletedCourses();
        $data['sdetail']=$this->coursemodel->getDeletedSubcourses();
        $data['page'] = 'course';
        $this->findControl($data);
    }

    function de() {
        //deleted events
        $data['page'] = 'event';
        $this->findControl($data);
    }

    function dp() {
        //deleted people
        $data['page'] = 'people';
        $this->findControl($data);
    }

    function vu() {
        //view user login/logout logs
        $data['page'] = 'user';
        $data['login_logout_array'] = $this->usermodel->getLoginLogoutList();
        $this->findControl($data);
    }
 
    function deleteAllLogs(){
        $this->usermodel->deleteAllLogs();
        $this->vu();
    }
    function deleteAllLogsExceptTop(){
        $this->usermodel->deleteAllLogsExceptTop();
        $this->vu();
    }
    
    function findControl($data) {
         $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->view('includes/Header');
        $this->load->view('includes/Navigation',$data);
        $this->load->view('ControlPanel',$data);
        $this->load->view('includes/Footer');
    }

}

?>
