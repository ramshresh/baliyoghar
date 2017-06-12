<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 4/25/2017
 * Time: 4:43 PM
 */
class MY_Form_validation extends CI_Form_validation
{


    public $CI;

    public function __construct()
    {
        parent::__construct();
        // reference to the CodeIgniter super object
        $this->CI =& get_instance();
    }

    /**
     * @see: http://stackoverflow.com/questions/8181779/creating-a-custom-codeigniter-validation-rule
     * @param $access_code
     * @param $table_name
     * @use $this->form_validation->set_rules(
     *                                  'access_code'
     *                                  , $this->lang->line('access_code')
     *                                  , 'trim|xss_clean|access_code_unique[users]'
     *                              );
     * @return bool
     *
     */
    public function access_code_unique($access_code, $table_name)
    {
        $this->CI->form_validation->set_message('access_code_unique', $this->CI->lang->line('access_code_invalid'));

        $where = array(
            'access_code' => $access_code
        );

        $query = $this->CI->db->limit(1)->get_where($table_name, $where);
        return $query->num_rows() === 0;
    }

    /**
     * @param $district_name
     * @return bool
     */
    public function valid_district_name($district_name)
    {
        $this->CI->form_validation->set_message('valid_district_name', 'District with selected name ' . $district_name . ' was not found in the database');

        $where = array(
            'dist_name' => $district_name
        );

        $query = $this->CI->db->limit(1)->get_where('hdx_districts', $where);


        return $query->num_rows() === 1;
    }

    /**
     * @param $vdc_name
     * @param null $district_name
     * @return bool
     */
    public function valid_vdc_name($vdc_name, $district_name = null)
    {

        if (isset($district_name)) {
            $msg = 'VDC with selected name ' . $vdc_name . ' in the selected district ' . $district_name . ' was not found in the database';
        } else {
            $msg = 'VDC with selected name ' . $vdc_name . ' was not found in the database';
        }

        $this->CI->form_validation->set_message('valid_vdc_name', $msg);

        $where = array();
        $where['ocha_vname'] = $vdc_name;
        if (isset($district_name)) {
            $where['dist_name'] = $district_name;
        }

        $query = $this->CI->db->limit(1)->get_where('hdx_vdcs', $where);


        return $query->num_rows() === 1;
    }

    /**
     * @param $vdc_name
     * @param null $district_name
     * @return bool
     */
    public function valid_ward_no($ward_no, $dist_vdc = null)
    {
        if (isset($dist_vdc)) {

            $errMsg = '';
            $district_name = explode(',', $dist_vdc)[0];
            $vdc_name = explode(',', $dist_vdc)[1];

            $where = array();
            if (isset($district_name) && isset($vdc_name)) {
                $where['ocha_vname'] = $vdc_name;
                $where['dist_name'] = $district_name;
            }

            $query = $this->CI->db->limit(1)->get_where('hdx_vdcs', $where);

            if ($query->num_rows() > 0) {
                $totalWards = $query->result()[0]->tot_wards;
                if (intval($ward_no) > $totalWards) {
                    $errMsg = 'Max ward number is  ' . $totalWards . ' for ' . $vdc_name . ' of district ' . $district_name;
                }
            } else {
                $errMsg = 'Could not find District and VDC combination specified for ward';
            }
        } else {
            $errMsg = 'VDC and District name were not specified';
        }

        if ($errMsg == '') {
            return TRUE;
        } else {
            $this->CI->form_validation->set_message('valid_ward_no', $errMsg);
            return FALSE;
        }
    }

    public function latitude($latitude, $row = null)
    {

        $msg = ($row != null)
            ? "row:[$row] -- {field} must be in the range -90 to 90<br>"
            : '%s must be in the range -90 to 90';
        $this->CI->form_validation->set_message('latitude', $msg);

        if (floatval($latitude) >= -90 && floatval($latitude) <= 90) {
            return true;
        }
        return false;
    }

    public function longitude($longitude, $row = null)
    {
        $msg = ($row != null)
            ? "row:[$row] -- {field} must be in the range -180 to 180<br>"
            : '%s must be in the range -180 to 180';
        $this->CI->form_validation->set_message('longitude', $msg);

        if (floatval($longitude) >= -180 && floatval($longitude) <= 180) {
            return true;
        }
        return false;
    }

    public function gender($value, $row = null)
    {
        $list = array(
            'male', 'female', 'other'
        );
        if (in_array(
            $value, $list

        )) {
            return true;
        }
        $msg = isset($row)
            ? "row:[$row] :  -- {field} : $value must be in the list" . json_encode($list) . "<br>"
            : "{field}  : $value must be in the list" . json_encode($list) . "<br>";

        $this->CI->form_validation->set_message('gender', $msg);
        return false;
    }

    public function ethnicity($value, $row = null)
    {
        $list = array(
            'newar', 'dalit', 'janajati', 'muslim', 'other', 'bc'
        );
        if (in_array(
            $value, $list
        )) {
            return true;
        }
        $msg = isset($row)
            ? "row:[$row] :  -- {field} : $value must be in the list" . json_encode($list) . "<br>"
            : "{field}  : $value must be in the list" . json_encode($list) . "<br>";
        $this->CI->form_validation->set_message('ethnicity', $msg);
        return false;
    }

    public function ort_participant_education($value, $row = null)
    {
        $list = array(
            'literate', 'illiterate',
        );
        if (in_array(
            $value, $list
        )) {
            return true;
        }
        $msg = isset($row)
            ? "row:[$row] :  -- {field} : $value must be in the list" . json_encode($list) . "<br>"
            : "{field}  : $value must be in the list" . json_encode($list) . "<br>";
        $this->CI->form_validation->set_message('ort_participant_education', $msg);
        return false;
    }

    public function ort_participant_occupation($value, $row = null)
    {

        $list = array(
            'agriculture', 'business', 'daily_wages', 'housewives', 'service', 'student', 'other', 'not_available',
        );


        if (in_array(
            $value, $list
        )) {
            return true;
        }
        $msg = isset($row)
            ? "row:[$row] :  -- {field} : $value must be in the list" . json_encode($list) . "<br>"
            : "{field}  : $value must be in the list" . json_encode($list) . "<br>";
        $this->CI->form_validation->set_message('ort_participant_occupation', $msg);
        return false;
    }

    public function ort_participant_type($value, $row = null)
    {
        $list = array(
            'house_owner', 'non_house_owner'
        );

        if (in_array(
            $value, $list
        )) {
            return true;
        }
        $msg = isset($row)
            ? "row:[$row] :  -- {field} : $value must be in the list" . json_encode($list) . "<br>"
            : "{field}  : $value must be in the list" . json_encode($list) . "<br>";
        $this->CI->form_validation->set_message('ort_participant_type', $msg);
        return false;
    }

    function unique_event_code($code){
        $this->load->model('eventmodel');
        if (!$this->eventmodel->valid_event_code($code)) {
            $this->CI->form_validation->set_message('is_valid_event_code', 'Invalid Event Code: May be Duplicate');
            return false;
        }
        return true;
    }

    function valid_end_date($end_date, $start_date)
    {
        if($start_date>$end_date){
            $this->CI->form_validation->set_message('valid_end_date', 'Invalid %s : End date must be greater than Start Date');
            return FALSE;
        };
        return TRUE;
    }
}