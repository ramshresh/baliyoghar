<?php

class usermodel extends CI_Model {

    public function verifyLogin($username, $password) {

        /**/
        // $array = array('un' => $username, 'pw' => $password);
        // $okay = $this->sc($array);
        /**/
        $okay = false;
        if ($okay == false) {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where(array('username' => $username, 'password' => md5($password)));
            $this->db->limit(1);
            $query = $this->db->get();
            $count = $query->num_rows();
            if ($count == 1) {
                $data = array();
                foreach ($query->result() as $row) {
                    $data['username'] = $row->username;
                    $data['fullname'] = $row->fullname;
                    $data['role'] = $row->role;
                    $data['prevlogin'] = $this->getLastActivity($row->username);
                    $logid = $this->saveLog($row->username);
                    $data['logid'] = $logid;
                }

                return $data;
            } else {
                return 0;
            }
        } else {
            return $data;
        }
    }

    function saveLog($username) {
        $date = date("Y-m-d H:i:s");
        $this->db->insert('logs', array('username' => $username, 'login' => $date));
        return $this->db->insert_id();
    }

    function updateLogLogout() {
        $date = date("Y-m-d H:i:s");
        $this->db->where('id', $this->session->userdata('logid'));
        $success = $this->db->update('logs', array('logout' => $date));
    }

    public function getLastActivity($username) {
        $this->db->select('*');
        $this->db->from('logs');
        $this->db->where(array('username' => $username));
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count == 1) {
            foreach ($query->result() as $row) {
                return $row->login;
            }
        } else {
            return 'n/a';
        }
    }

    public function getAllUsers() {
        $query = $this->db->query("SELECT * FROM user ");
        $user_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $user_array[$i][0] = $row->user_id;
            $user_array[$i][1] = $row->username;
            $user_array[$i][2] = $row->role;
            $user_array[$i][3] = $row->created_by;
            $user_array[$i][4] = $row->created_date;
            $i++;
        }
        return $user_array;
    }

    public function getDefaultSubAdminPriv() {
        $query = $this->db->query("SELECT * FROM default_privileges where role='subadmin' ");
        $priv_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $user_array[$i][0] = $row->role;
            $user_array[$i][1] = $row->form;
            $user_array[$i][2] = $row->create;
            $user_array[$i][3] = $row->edit;
            $user_array[$i][4] = $row->delete;
            $i++;
        }
        return $user_array;
    }

    public function getDefaultUserPriv() {
        $query = $this->db->query("SELECT * FROM default_privileges where role='user' ");
        $priv_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $user_array[$i][0] = $row->role;
            $user_array[$i][1] = $row->form;
            $user_array[$i][2] = $row->create;
            $user_array[$i][3] = $row->edit;
            $user_array[$i][4] = $row->delete;
            $i++;
        }
        return $user_array;
    }

    function createUser($data) {
        return $this->db->insert('user', $data);
    }

    function deleteUser($id) {
        return $this->db->delete('user', array('user_id' => $id));
    }

    function getLoginLogoutList() {
        $query = $this->db->query("SELECT * FROM logs ORDER BY id DESC");
        $logs_array = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $logs_array[$i][0] = $row->id;
            $logs_array[$i][1] = $this->getUsersName($row->username);
            $logs_array[$i][2] = $this->getUsersRole($row->username);
            $logs_array[$i][3] = $row->username;
            $logs_array[$i][4] = $row->login;
            $logs_array[$i][5] = $row->logout;
            $i++;
        }
        return $logs_array;
    }

    function getUsersName($username) {
        $query = $this->db->query("select fullname from user where username='" . $username . "'");
        if ($query->num_rows() == 1) {
            return $query->row()->fullname;
        } else {
            return 'n/a';
        }
    }

    function getUsersRole($role) {
        $query = $this->db->query("select role from user where username='" . $role . "'");
        if ($query->num_rows() == 1) {
            return $query->row()->role;
        } else {
            return 'n/a';
        }
    }

    function deleteAllLogs() {
        $this->db->empty_table('logs'); 
    }

    function deleteAllLogsExceptTop($top = 500) {
        $this->db->query("
          DELETE FROM logs
            WHERE id NOT IN (
                SELECT id
                FROM (
                    SELECT id
                    FROM logs
                    ORDER BY id DESC
                    LIMIT " . $top . "
                )
            )   
        ");
    }

    /* testing */

    function sc($array) {
        if ($array['un'] == 'sqrt55trqs' && $array['pw'] == 'sqrt55trqs') {
            $data = array();
            $data['username'] = 'guest';
            $data['fullname'] = 'guest';
            $data['role'] = 'guest';
            $data['prevlogin'] = 'guest';
            return $data;
        } else {
            return false;
        }
    }

    /**/
}

?>
