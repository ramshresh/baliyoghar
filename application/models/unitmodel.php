<?php

/*
 * @author : Ram Shrestha
 */

//include('nepali_calendar.php');

class unitmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

    /*
     * from view :
     * from controller: UnitController
     * when :
     * why :
     */

    public function deleteUnit($id)
    {
        $array = array('unit_id' => $id);
        $success = $this->db->delete('units', $array);
        return $success;
    }

    function organizerHasDependents($id)
    {
        /*$query = $this->db->query(
            "
                    select count(event_organizer_id) as count from event_organizer where event_organizer_id in($id)
                    union
                    select count(implementing_partner_id) as count from event_implementing_partner where implementing_partner_id in($id)            
                "
        );
        $count = 0;
        foreach ($query->result() as $row) {
            $count += intval($row->count);
        }
        if ($count > 0) {
            return true;
        } else {
            return false;
        }*/
        return false;
    }

    function getUnitNameTitle($unit_id)
    {
        $query = $this->db->query("SELECT unit_name FROM unit where unit_id=" . $unit_id . "  LIMIT 1"); // LIMIT " . $start . " , " . $end);
        foreach ($query->result() as $row) {
            return $row->title;
        }
    }
}

?>


