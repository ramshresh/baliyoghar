<?php

class functionsmodel extends CI_Model {

    public $person_pagination_totalpage = 0;
    var $imagepath;
    var $thumbpath;

    ////////////////////////////////////////////////////////////////////////////
    public function functionsmodel() {
        $this->imagepath = realpath(APPPATH . '../slider/images');
        $this->thumbpath = realpath(APPPATH . '../slider/tooltips');
    }

    function saveHelp($content) {
        //About BCIPN will be available soon !
        $updated_by = $this->session->userdata('username');
        $updated_date = date('Y-m-d H:i:s');
        $query = $this->db->query("select help_id from help");
        if ($query->num_rows() == 1) {
            $help_id = $this->db->query("select help_id from help Limit 1")->row()->help_id;
            $array = array('content' => $content, 'updated_by' => $updated_by, 'updated_date' => $updated_date);
            $this->db->where('help_id', $help_id);
            $success = $this->db->update('help', $array);
            return $success;
        } else {
            $success = $this->db->insert('help', array('help_id' => NULL,'content' => $content, 'updated_by' => $updated_by, 'updated_date' => $updated_date));
            return $success;
        }
    }

    function getHelpContent() {
        $query = $this->db->query("select content from help Limit 1");
        if ($query->num_rows() == 1) {
            return $query->row()->content;
        } else {
            return ' About BCIPN  will be available soon !';
        }
    }

    function partyHasDependents($id) {
        $this->db->select('*');
        $this->db->from('event_cost_shares');
        $array = array('party_id' => $id);
        $this->db->where($array);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertCostSharingParty($party_name, $created_by) {
        $created_date = date('Y-m-d H:i:s');
        $array = array('party' => $party_name, 'created_by' => $created_by, 'created_date' => $created_date);
        $success = $this->db->insert('cost_sharing', $array);
        if ($success == 1) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function getALLCostSharingParties($deleted = 0) {
        // $query = $this->db->query("SELECT * FROM cost_sharing where deleted=" . $deleted);
        $query = $this->db->query("SELECT * FROM cost_sharing");
        $costSharingParty_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $costSharingParty_array[$i][0] = $row->id;
            $costSharingParty_array[$i][1] = $row->party;
            $costSharingParty_array[$i][2] = $row->created_by;
            $costSharingParty_array[$i][3] = $row->created_date;
            $i++;
        }
        return $costSharingParty_array;
    }

    public function updateCostSharingParty($party_id, $party_name) {
        $this->db->where('id', $party_id);
        $success = $this->db->update('cost_sharing', array('party' => $party_name));
        return $success;
    }
	
	public function check_connection()
	{
		 $this->db_server = $this->load->database('server', TRUE);  
		 $query=$this->db_server->get('events');
		 return $query->num_rows();
		
		}

    public function deleteCostSharingParty($party_id, $deleted_by) {
        /* if not superadmin
          $this->db->where('id', $party_id);
          $success = $this->db->update('cost_sharing', array('deleted' => 1, 'deleted_by' => $deleted_by));
         */
        $success = $this->db->delete('cost_sharing', array('id' => $party_id));
        if ($success == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function slider($title, $description, $visible, $created_by, $created_date) {
        $data = array('title' => $title,
            'description' => $description,
            'visible' => $visible,
            'created_by' => $created_by,
            'created_date' => $created_date);
        $this->db->insert('slider', $data);
        return $this->db->insert_id();
    }

    //upload slider image
    function do_upload($image_id) {
        //for image upload
        $config = array(
            'file_name' => 'image_' . $image_id,
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => realpath(APPPATH . '../slider/images'),
            'max_size' => 3000,
            'max_width' => 960,
            'min_width' => 960,
            'max_height' => 360,
            'min_height' => 360
        );
        $this->load->library('upload', $config);
        $success = $this->upload->do_upload();
        if ($success == 1) {
            $image_data = $this->upload->data();


            //for thumbnail
            $config1 = array(
                'source_image' => $image_data['full_path'],
                'new_image' => realpath(APPPATH . '../slider/tooltips'),
                'maintain_ration' => false,
                'width' => 128,
                'height' => 48
            );

            $this->load->library('image_lib', $config1);
            $this->image_lib->resize();

            //now update image path to that of new image 
            $this->db->where(array('image_id' => $image_id));
            $success = $this->db->update('slider', array('path_image' => 'image_' . $image_id . "" . $image_data['file_ext']));
            return '1';
        } else {
            $this->db->delete('slider', array('image_id' => $image_id));
            return 'no';
        }
    }

    function getSliderImages($visible, $all) {
        $query;
        if ($all == 0) {
            $query = $this->db->query("SELECT * FROM slider where visible=" . $visible);
        } else {
            $query = $this->db->query("SELECT * FROM slider");
        }
        $slider_images = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $slider_images[$i][0] = $row->image_id;
            $slider_images[$i][1] = $row->title;
            $slider_images[$i][2] = $row->description;
            $slider_images[$i][3] = $row->path_image;
            $slider_images[$i][4] = $row->position;
            $slider_images[$i][5] = $row->created_by;
            $slider_images[$i][6] = $row->created_date;
            $slider_images[$i][7] = $row->visible;
            $i++;
        }
        return $slider_images;
    }

    function getSliderImageName($image_id) {
        //one line on row return query
        return $this->db->query("select path_image from slider where image_id=" . $image_id)->row()->path_image;
    }

    function editSliderImage($id, $title, $description, $publish) {
        $array = array('title' => $title, 'description' => $description, 'visible' => $publish);
        $this->db->where('image_id', $id);
        $success = $this->db->update('slider', $array);
        return $success;
    }

    function deleteSliderImage($id) {
        $path = $this->getSliderImageName($id);
        $array = array('image_id' => $id);
        $success = $this->db->delete('slider', $array);
        if ($success == 1) {
            unlink(realpath(APPPATH . '../slider/images/' . $path));
            unlink(realpath(APPPATH . '../slider/tooltips/' . $path));
        }
        return $success;
    }

    /////////////////////////////////////////////////////////////////////////////////


    public function getTotalPages_course($howmany) {
        $total_row = $this->getRowCount_course();
        $pages = ceil($total_row / $howmany);
        return $pages;
    }

    public function addInstructor($personId, $eventId, $event_instructor, $person_age) {
        /*
         */
        $count = 0;

        $this->db->select('is_instructor');
        $this->db->from('participated_in');
        $array = array('event_id' => $eventId, 'person_id' => $personId);
        $this->db->where($array);
        $is_instructor = 0;
        foreach ($this->db->get()->result() as $row) {
            $is_instructor = $row->is_instructor;
            $count++;
        }
        if ($count == 0) {
            $data = array(
                'participated_in_id' => NULL,
                'person_id' => $personId,
                'event_id' => $eventId,
                'is_instructor' => $event_instructor,
                'person_age' => $person_age
            );

            $success = $this->db->insert('participated_in', $data);
            return $success;
        } else if ($count == 1) {
            // if ($is_instructor == 0) {
            //     $is_instructor = $;
            // } else {
            //     $is_instructor = 0;
            // }
            $data = array(
                'is_instructor' => $event_instructor
            );

            $this->db->where($array);
            $success = $this->db->update('participated_in', $data);
            return $success;
        }
    }

    public function addCandidate_async($personId, $eventId) {
        /*
         */
        $count = 0;

        $this->db->select('person_id');
        $this->db->from('participated_in');
        $array = array('event_id' => $eventId, 'person_id' => $personId);
        $this->db->where($array);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count == 0) {
            $data = array(
                'participated_in_id' => NULL,
                'person_id' => $personId,
                'event_id' => $eventId,
                'is_instructor' => "0"
            );

            $this->db->insert('participated_in', $data);
            return "1";
        } else if ($count == 1) {
            $this->db->delete('participated_in', $array);
            return "0";
        }
    }

    public function deleteCandidate_async($personId, $eventId, $participation_id = 0) {
        if ($participation_id === 0) {
            $array = array('event_id' => $eventId, 'person_id' => $personId);
            $success = $this->db->delete('participated_in', $array);
            echo 'uyy';
            return $success;
        } else {
            $array = array('participated_in_id' => $participation_id);
            $success = $this->db->delete('participated_in', $array);
            echo 'hh';
            return $success;
        }
    }

    public function searchPerson_async($string, $identifier, $deleted = 0) {
        $query = '';
        if (trim($identifier) == "alphabet") {
            $query = $this->db->query("SELECT person_id,title,fullname,email,mobile FROM person where (fullname like '" . $string . "%' OR email like '" . $string . "%' OR mobile like '" . $string . "%') AND deleted=" . $deleted . " ORDER BY fullname ASC");
        } else {
            $query = $this->db->query("SELECT person_id,title,fullname,email,mobile FROM person where (fullname like '%" . $string . "%' OR email like '%" . $string . "%' OR mobile like '%" . $string . "%') AND deleted=" . $deleted . " ORDER BY fullname ASC");
        }
        $result = $query->result();
        return json_encode($result);
    }

    function getDeletedDataCounts() {
        $count = array();
        $count[0] = $this->db->query("select count(person_id)as count from person where deleted=1")->row()->count;
        $count[1] = $this->db->query("select count(event_id)as count from events where deleted=1")->row()->count;
        $count[2] = $this->db->query("select count(course_cat_id)as count from course_category where deleted=1")->row()->count;
        $count[3] = $this->db->query("select count(course_subcat_id)as count from course_subcategory where deleted=1")->row()->count;
        $count[4] = $this->db->query("select count(id)as count from logs")->row()->count;
        $count[5] = $this->db->query("select count(id)as count from cost_sharing where deleted=1")->row()->count;
        return $count;
    }

    function test() {
        // Load the DB utility class
        $this->load->dbutil();
        /* 8**************************8 */
        $prefs = array(
            'tables' => array('person', 'events'),
            'ignore' => array(),
            'format' => 'txt',
            'filename' => 'mybackup.csv',
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );

        $backup = $this->dbutil->backup($prefs);
        /* 8**************************8 */

        // Backup your entire database and assign it to a variable
        //$backup = & $this->dbutil->backup();
        // Load the file helper and write the file to your server
        //  $this->load->helper('file');
        //  write_file('mybackup.sql', $backup);
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('mybackup.csv', $backup);


        /*
          $result = $this->db->query('SELECT * FROM `person`');
          $fp = fopen('php://output', 'w');
          if ($fp && $result) {
          header('Content-Type: text/csv');
          header('Content-Disposition: attachment; filename="export.csv"');
          while ($row = $result->fetch_array(MYSQLI_NUM)) {
          fputcsv($fp, array_values($row));
          }
          die;
          }
         */
    }

    function addCoverageLevel($coverage_level) {
        $data = array('coverage_level' => $coverage_level);
        return $this->db->insert('coverage_level', $data);
    }

    function coverageExists($coverage_level) {
        return $this->db->query("select count(coverage_level_id) as number from coverage_level where coverage_level='" . $coverage_level . "'")->row()->number;
    }

    function updateCoverageLevel($coverage_level_id, $coverage_level) {
        $this->db->where('coverage_level_id', $coverage_level_id);
        $success = $this->db->update('coverage_level', array('coverage_level' => $coverage_level));
        return $success;
    }

    function updateCoverageLocation($coverage_location_id, $coverage_location, $location_code) {
        $this->db->where('id', $coverage_location_id);
        $success = $this->db->update('coverage_location', array('coverage_location_code' => $location_code, 'coverage_location' => $coverage_location));
        return $success;
    }

    function deleteCoverageLevel($coverage_level_id) {
        if ($this->db->delete('coverage_location', array('coverage_level' => $coverage_level_id)))
            return $this->db->delete('coverage_level', array('coverage_level_id' => $coverage_level_id));
        else
            return '0';
    }

    function deleteCoverageLocation($coverage_location_id) {
        return $this->db->delete('coverage_location', array('id' => $coverage_location_id));
    }

    function addCoverageLocation($coverage_location, $coverage_level_id, $code = 0) {
        $data = array('coverage_location' => $coverage_location, 'coverage_level' => $coverage_level_id, 'coverage_location_code' => $code);
        return $this->db->insert('coverage_location', $data);
    }

    function getCoverageLevel() {
        $query = $this->db->query("SELECT * FROM coverage_level");
        $coverage_level_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $coverage_level_array[$i][0] = $row->coverage_level_id;
            $coverage_level_array[$i][1] = $row->coverage_level;
            $i++;
        }
        return $coverage_level_array;
    }

    function getAllCoverageLocations($coverage_level_id) {
        $query = $this->db->query("SELECT * FROM coverage_location where coverage_level='" . $coverage_level_id . "'");
        $coverage_location_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $coverage_location_array[$i][0] = $row->id;
            $coverage_location_array[$i][1] = $row->coverage_level;
            $coverage_location_array[$i][2] = $row->coverage_location;
            $coverage_location_array[$i][3] = $row->coverage_location_code;
            $i++;
        }
        return $coverage_location_array;
    }

    function getCoverageLevelName($coverage_level_id) {
        $dataset = $this->db->query("select coverage_level from coverage_level where coverage_level_id=" . $coverage_level_id);
        if ($dataset->num_rows() == 1) {
            return $dataset->row()->coverage_level;
        }
    }

    public function insertOrganizer($organizer_name) {
        $array = array('organizer' => $organizer_name);
        $success = $this->db->insert('organizer_master', $array);
        if ($success == 1) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function getALLOrganizer($deleted = 0) {
        $query = $this->db->query("SELECT * FROM organizer_master");
        $mainorganizer_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $mainorganizer_array[$i][0] = $row->id;
            $mainorganizer_array[$i][1] = $row->organizer;
            $i++;
        }
        return $mainorganizer_array;
    }

    public function updateOrganizer($organizer_name) {
        $this->db->where('id', $party_id);
        $success = $this->db->update('organizer_master', array('organizer' => $organizer_name));
        return $success;
    }

    public function deleteOrganizer($party_id, $deleted_by) {
        if ($this->session->userdata('role') == 'superadmin') {
            
        } else {
            $this->db->where('id', $party_id);
            $success = $this->db->update('cost_sharing', array('deleted' => 1, 'deleted_by' => $deleted_by));
            if ($success == 1) {
                return 1;
            } else {
                return 0;
            }
        }
    }

}

?>
