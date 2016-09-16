<?php
class Login extends CI_Controller{
    function __construct(){
        $this->load->helper('url');
        /*
         * if (!$this->session->userdata('username')) {
            redirect('../../HomeController/index','refresh');
        }
         */
    }
    
     public function verifyLogin() {

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $success = $this->usermodel->verifyLogin($username, $password);
        if ($success === 0) {
            $this->load->View('Login');
        } else {
            $array = array(
                'username' => $success['username'],
                'fullname' => $success['fullname'],
                'role' => $success['role'],
                'prevlogin' => $success['prevlogin']
            );
            $this->session->set_userdata($array);

            $this->load->View('includes/Header');
            $this->load->View('includes/Navigation');
            $this->load->View('Home');
            $this->load->View('includes/Footer');
        }
    }
}
?>
