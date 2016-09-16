<?php

require_once('usermodel.php');
require_once('eventmodel.php');
require_once('workexperiencemodel.php');
include('nepali_calendar.php');

class personmodel extends CI_Model
{

	var $imagepath;
	private $usermodel;
	private $eventmodel;
	private $cal;
	private $person_pagination_totalpage;


	//  var $imagepath_url;

	public function personmodel()
	{
		$this->imagepath = realpath(APPPATH . '../gallery');
		$this->usermodel = new usermodel();
		$this->cal = new Nepali_Calendar();
		// $this->imagepath_url = base_url().'gallery/';
	}

	function do_upload($person_id)
	{
		$picture = $this->getPicture($person_id);
		if ((strpos($picture, 'image_') !== false)) {
			//if any old picture of the person exists, delete tem first.
			unlink(realpath(APPPATH . '../gallery/' . $picture));
			unlink(realpath(APPPATH . '../gallery/thumbs/' . $picture));
		}
		//for image upload
		//$session_id = $this->sessionsession_id();
		$random = rand(11111, 999999999);
		$config = array(
			'file_name' => 'image_' . $person_id . 'PTAS' . $random,
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->imagepath,
			'max_size' => 3000
		);

		$this->load->library('upload', $config);
		$this->upload->do_upload();
		$image_data = $this->upload->data();

		//for thumbnail
		$config = array(
			'source_image' => $image_data['full_path'],
			'new_image' => $this->imagepath . '/thumbs',
			'maintain_ration' => true,
			'width' => 150,
			'height' => 100
		);

		$this->load->library('image_lib', $config);
		$this->image_lib->resize();

		//now update image path to that of new image
		if (strtolower($image_data['file_ext']) == '.jpg' || strtolower($image_data['file_ext']) == '.jpeg' || strtolower($image_data['file_ext']) == '.png' || strtolower($image_data['file_ext']) == '.gif') {
			$this->db->where(array('person_id' => $person_id));
			$success = $this->db->update('person', array('photo' => 'image_' . $person_id . 'PTAS' . $random . "" . $image_data['file_ext']));
		}
	}

	public function savePersonData($data)
	{

		if (trim($data['dob_en']) == '' && trim($data['dob_np']) == '') {

		} else {
			if (trim($data['dob_en']) == '') {
				$data['dob_en'] = $this->getEnglishDate($data['dob_np']);
				echo '<script> alert("given nepali = ' . $data['dob_np'] . ' converted english = ' . $data['dob_en'] . '");</script>';
			}
			if (trim($data['dob_np']) == '') {
				$data['dob_np'] = $this->getNepaliDate($data['dob_en']);
				echo '<script> alert("given english = ' . $data['dob_en'] . ' converted nepali = ' . $data['dob_np'] . '");</script>';
			}
		}

		$success = $this->db->insert('person', $data);
		return $this->db->insert_id();
	}

	public function updateParticipatedInData($data,$event_id){
		$this->db->where('event_id', $event_id);
		$success = $this->db->update('participated_in', $data);
		return $success;
	}
	public function updatePersonData($data, $person_id)
	{


		//if form is submitted without filling both date of birth fields
		if (trim($data['dob_en']) == '') {
			$data['dob_en'] = $this->getEnglishDate($data['dob_np']);
		}
		if (trim($data['dob_np']) == '') {
			$data['dob_np'] = $this->getNepaliDate($data['dob_en']);
		}
		$this->db->where('person_id', $person_id);
		$success = $this->db->update('person', $data);
		return $success;
	}

	public function getPeople($start, $end)
	{
		$query = $this->db->query("SELECT * FROM person where deleted=0  ORDER BY fullname ASC LIMIT " . $start . " , " . $end . " ");
		$person_array = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$person_array[$i][0] = $row->person_id;
			$person_array[$i][1] = $row->title;
			$person_array[$i][2] = $row->fullname;
			$person_array[$i][3] = $row->email;
			$person_array[$i][4] = $row->mobile;
			$i++;
		}
		return $person_array;
	}

	public function getPersonName($person_id, $title = false)
	{
		$query = $this->db->query("SELECT * FROM person where person_id='" . $person_id . "' AND deleted=0 ");
		foreach ($query->result() as $row) {
			if ($title == false) {
				$person_name = $row->fullname;
			} else {
				$person_name = $row->title . ' ' . $row->fullname;
			}
		}
		return $person_name;
	}

	/**
	 * @param $value
	 * @return string
	 * http://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
	 */
	public static function escape($value)
	{
		$return = '';
		for ($i = 0; $i < strlen($value); ++$i) {
			$char = $value[$i];
			$ord = ord($char);
			if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
				$return .= $char;
			else
				$return .= '\\x' . dechex($ord);
		}
		return $return;
	}

	public function getPerson($search_string, $start, $end)
	{
		$query = '';
		if ($this->session->userdata('role') == 'superadmin') {
			$query = $this->db->query("SELECT * FROM person WHERE (fullname like '%" . self::escape($search_string) . "%' OR email like '%" . self::escape($search_string) . "%' or mobile like '%" . self::escape($search_string) . "%')  ORDER BY fullname ASC LIMIT " . $start . " , " . $end);
		} else {
			$query = $this->db->query("SELECT * FROM person WHERE (fullname like '%" . self::escape($search_string) . "%' OR email like '%" . self::escape($search_string) . "%' or mobile like '%" . self::escape($search_string) . "%') AND deleted=0  ORDER BY fullname ASC LIMIT " . $start . " , " . $end);
		}
		$count = $query->num_rows();
		$person_array = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$person_array[$i][0] = $row->person_id;
			$person_array[$i][1] = $row->title;
			$person_array[$i][2] = $row->fullname;
			$person_array[$i][3] = $row->c_address;
			$person_array[$i][4] = $row->mobile;
			$person_array[$i][5] = $row->email;
			$person_array[$i][6] = $row->org_name;
			$person_array[$i][7] = $row->position;

			$i++;
		}
		$this->setPerson_pagination_totalpage($count, ($end - $start));
		return $person_array;
	}

	private function setPerson_pagination_totalpage($rowcount, $howmany)
	{
		$this->person_pagination_totalpage = ceil($rowcount / $howmany);
	}

	public function getPerson_pagination_totalpage()
	{
		return $this->person_pagination_totalpage;
	}

	function getNepaliDate($english_date)
	{
		$nepali_date = $this->cal->eng_to_nep($english_date);
		//  echo $nepali_date;
		return $nepali_date;
	}

	function getEnglishDate($nepali_date)
	{
		$english_date = $this->cal->nep_to_eng($nepali_date);
		//   echo $english_date;
		return $english_date;
	}

	public function getPersonDetail($person_id)
	{
		$query = $this->db->query("SELECT * FROM person where person_id=" . $person_id . "  LIMIT 1");
		$personDetail_array = array();
		//  $i = 0;
		foreach ($query->result() as $row) {
			//   $english_date = $this->getEnglishDate($row->dob_en);
			$english_date = $row->dob_en;
			// $time = abs(strtotime($row->dob) - strtotime(date("Y-m-d")));
			if ($english_date != '0000-00-00') {
				$time = abs(strtotime($english_date) - strtotime(date("Y-m-d")));
				$age = floor($time / (365 * 60 * 60 * 24)) == $time / (365 * 60 * 60 * 24) ? floor($time / (365 * 60 * 60 * 24)) : floor($time / (365 * 60 * 60 * 24)) + 1;
			} else $age = 0;
			$personDetail_array[0] = $row->person_id;
			$personDetail_array[1] = $row->title;
			$personDetail_array[2] = $row->fullname;
			$personDetail_array[3] = $row->dob_en;
			$personDetail_array[4] = $age;
			$personDetail_array[5] = $row->gender;
			$personDetail_array[6] = $row->p_address;
			$personDetail_array[7] = $row->c_address;
			$personDetail_array[8] = $row->photo;
			$personDetail_array[9] = $row->country;
			$personDetail_array[10] = $row->phone;
			$personDetail_array[11] = $row->mobile;
			$personDetail_array[12] = $row->email;
			$personDetail_array[13] = $row->org_name;
			$personDetail_array[14] = $row->org_address;
			$personDetail_array[15] = $row->org_phone;
			$personDetail_array[16] = $row->org_fax;
			$personDetail_array[17] = $row->position;
			$personDetail_array[18] = $row->current_status;
			$personDetail_array[19] = $row->dob_np;  //yo chai pachhi thapeko bhayera last ma pugyo
			$personDetail_array[20] = $row->created_date;
			$personDetail_array[25] = $row->caste_ethnicity;  //yo chai pachhi thapeko bhayera last ma pugyo
			$personDetail_array[26] = $row->citizenship_no;  //yo chai pachhi thapeko bhayera last ma pugyo

			$personDetail_array[27] = $row->education;  //yo chai pachhi thapeko bhayera last ma pugyo
			$personDetail_array[28] = $row->work_type_id;  //yo chai pachhi thapeko bhayera last ma pugyo
			// $i++;
		}
		return $personDetail_array;
	}

	public function deletePerson($id, $user, $role, $date)
	{
		/*
		 * <?php
$filename = '/path/to/foo.txt';

if (file_exists($filename)) {
	echo "The file $filename exists";
} else {
	echo "The file $filename does not exist";
}
?>
		 */

		$persong_detail = $this->getPersonDetail($id);

		//  if ($role == 'superadmin') {
		$this->eventmodel = new eventmodel();

		$participation = $this->eventmodel->getAllParticipation($id);

		if (count($participation) > 0) {
			//if associated data is found in participated_in table , return the event details in which he has participated
			//dont deleted directly
			return $participation;
		} else {
			$array = array('person_id' => $id);
			$success = $this->db->delete('person', $array);
			if ($success == 1) {
				if(isset($persong_detail[8])){
					if (is_file(realpath(APPPATH . '../gallery/' . $persong_detail[8])))
						unlink(realpath(APPPATH . '../gallery/' . $persong_detail[8]));
					if (is_file(realpath(APPPATH . '../gallery/thumbs/' . $persong_detail[8])))
						unlink(realpath(APPPATH . '../gallery/thumbs/' . $persong_detail[8]));
				}

			}

			return $success;
		}
//        } else {
//            $this->db->where('person_id', $id);
//            $success = $this->db->update('person', array('deleted_by' => $user, 'deleted_date' => $date, 'deleted' => 1));
//            return $success;
//        }
	}

	public function getRowCount_person()
	{
		$this->db->select('person_id');
		$this->db->from('person');
		$this->db->where('deleted', 0);
		$query = $this->db->get();
		$count = $query->num_rows();
		return $count;
	}

	public function getTotalPages_person($howmany)
	{
		$total_row = $this->getRowCount_person();
		$pages = ceil($total_row / $howmany);
		return $pages;
	}

	function getPicture($person_id)
	{
		return $this->db->query("select photo from person where person_id=" . $person_id)->row()->photo;
	}

	function removePicture($person_id)
	{
		$picture = $this->getPicture($person_id);
		$this->db->where(array('person_id' => $person_id));
		$success = $this->db->update('person', array('photo' => ''));
		if ($success == 1) {
			unlink(realpath(APPPATH . '../gallery/' . $picture));
			unlink(realpath(APPPATH . '../gallery/thumbs/' . $picture));
		}
	}

	function addWorkExperience($data)
	{
		$success = $this->db->insert('work_experience', $data);
		$insert_id = $this->db->insert_id();
		if ($success == 1)
			return $insert_id;
		else
			return 0;
	}

	public function getTypeOfWorkTable($deleted = 0) {
		// return $this->db->select('*')->from('course_category')->where(array('deleted'=>$deleted));
		return $this->db->get_where('course_category', array('deleted' => $deleted));
	}

}

?>

