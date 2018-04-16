<?php

class Login_mod extends CI_Model {

    function login($username = NULL, $password = NULL) {
        $array = array('user_name' => $username, 'password' => md5($password), 'is_active' => 1);
        $this->db->select('*');
        $this->db->from('user_reg');
        $this->db->where($array);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?>