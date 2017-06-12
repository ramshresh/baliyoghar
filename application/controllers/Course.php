<?php

require_once 'Home.php';

class Course extends CI_Controller {


    private $homeController;

    /*
     * CONSTRUCTOR
     */

    public function __construct() {
        parent::__construct();

        $this->load->model('coursemodel');

        $this->load->model('functionsmodel');
        //$this->homeController = new Home();
        //exit;
    }


    /*
     * METHOD : course()
     * from view : 
     * when : 
     * why : 
     */

    public function course() {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('course');
        $this->load->View('includes/Footer');
    }

    /*
     * METHOD : grabAndValidateSubCourseData_async()
     * from view : 
     * when : 
     * why : 
     */

    public function grabAndValidateSubCourseData_async() {
        $course_category_id = $this->input->post('course_category');
        $course_subcategory_name = $this->input->post('course_subcategory');
        $index = $this->input->post('dropdownindex');
        $counter = 1;
        $date = date("Y-m-d H:i:s");
        $created_by = $this->session->userdata('username');
        $data = array(
            'course_subcat_id' => NULL,
            'course_cat_id' => $course_category_id,
            'subcoursename' => $course_subcategory_name,
            'created_by' => $created_by,
            'created_date' => $date);
        $this->load->model('coursemodel');
        $success = $this->coursemodel->saveSubCourseData($data);
        if ($success == 1) {
            echo "yes";
        } else {
            echo "no";
        }
    }

    /*
     * Method : grabCourseData_async()
     * from view : 
     * when : 
     * why : 
     */

    public function grabCourseData_async() {
        $course_name = $this->input->post('course_name');
        $date = date("Y-m-d H:i:s");
        $created_by = $this->session->userdata('username');
        $data = array('course_cat_id' => NULL, 'coursename' => $course_name, 'created_by' => $created_by, 'created_date' => $date);
        $this->load->model('coursemodel');
        $success = $this->coursemodel->saveCourseData($data);
        echo $success;
    }

    /*
     * Method : viewCourse()
     * from view : 
     * when : 
     * why : 
     */

    public function viewCourse() {
        $course_id = $this->input->get('id', TRUE);
        $data['coursename'] = $this->coursemodel->getCourseName($course_id);
        $data['subcourse_data'] = $this->coursemodel->getSubCourseData($course_id);
        $data['course_id'] = $course_id;
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['associated_events'] = $this->coursemodel->getEventsWithCourse($course_id);
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('CourseDetail', $data);
        $this->load->View('includes/Footer');
    }

    /*
     * Method : editCourse()
     * from view : 
     * when : 
     * why : 
     */

    public function editCourse() {
        $course_id = $this->input->get('id', TRUE);
        $data['coursename'] = $this->coursemodel->getCourseName($course_id);
        $data['courseid'] = $course_id;
        $data['subcourse_array'] = $this->coursemodel->getSubCourseData($course_id);
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('EditCourse', $data);
        $this->load->View('includes/Footer');
    }

    /*
     * Method : updateCourseName()
     * from view : 
     * when : 
     * why : 
     */

    public function updateCourseName() {
        $course_id = $this->input->post('editcourse_id');
        $course_name = $this->input->post('editcourse_name');
        $success = $this->coursemodel->updateCourseName($course_id, $course_name);
        if ($success == "1")
            $this->homeController->course();
        else
            echo 'no';
    }

    /*
     * Method :deleteCourse()
     * from view : 
     * when : 
     * why : 
     */

    public function deleteCourse() {
        $course_id = $this->input->get('id', TRUE);
        $success = $this->coursemodel->deleteCourse($course_id);
        // $this->homeController->course();
        if ($success == '1') {
            $data['associated_message'] = '<div class="message-success">Course deleted successfully with all it\'s belonging subcourses.</div>';
        } else if ($success == 'associated') {
            $data['associated_message'] = '<div class="message-error">The course couldn\'t be deleted. It is associated with some events.</div>';
        } else {
            $data['associated_message'] = '';
        }
        $data['course_data'] = $this->coursemodel->getCourseData();
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $this->load->View('includes/Header');
        $this->load->View('includes/Navigation', $data);
        $this->load->View('CourseManagement', $data);
        $this->load->View('includes/Footer');
        // else
        //   echo 'no';
    }

    /*
     * Method : editSubcourse_async()
     * from view : 
     * when : 
     * why : 
     */

    public function editSubcourse_async() {
        $subcourse_id = $this->input->post('subcourse_id');
        $new_subcourse = $this->input->post('new_subcourse');
        $this->load->model('coursemodel');
        $success = $this->coursemodel->updateSubCourse($subcourse_id, $new_subcourse);
        if ($success == "1")
            echo 'yes';
        else
            echo 'no';
    }

    /*
     * Method : deleteSubcourse_async()
     * from view : 
     * when : 
     * why : 
     */

    public function deleteSubcourse_async() {
        $subcourse_id = $this->input->post('subcourse_id');
        $this->load->model('coursemodel');
        $success = $this->coursemodel->deleteSubCourse($subcourse_id);
        if ($success == "1")
            echo 'yes';
        else if ($success == 'associated') {
            echo 'associated';
        } else {
            echo 'no';
        }
    }

}

?>
