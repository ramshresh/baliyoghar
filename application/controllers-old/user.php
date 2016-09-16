<?php

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usermodel');
    }

    public function userList() {
        $data['user_data'] = $this->usermodel->getAllUsers();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation');
        $this->load->View('UserList', $data);
        $this->load->View('includes/Footer');
    }

    public function createUser() {
        $fullname = $this->input->post('fullname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role = $this->input->post('role');
        echo $this->usermodel->createUser(array('username' => $username, 'password' => md5($password), 'fullname' => $fullname, 'role' => $role, 'created_by' => $this->session->userdata('username'), 'created_date' => date("Y-m-d H:i:s")));
    }

    function deleteUser() {
        $id = $this->input->post('id');
        echo $this->usermodel->deleteUser($id);
    }

    public function privilege_subadmin() {
        
    }

    public function privilege_user() {
        
    }

}

?>
