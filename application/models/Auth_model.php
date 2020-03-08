<?php

class Auth_model extends CI_Model
{

    public function email_validation($email)
    {
        $result = [];
        $email = $this->db->escape_str(trim(strtolower($email)));
        $query = $this->db->query("SELECT * FROM users WHERE email='$email'");
        if ($query->num_rows() === 0) {
            return array('user' => 'none');
        } else {
            return array('user' => 'exist');
        }
    }

    public function create_user($data, $account_type) { // Inserting information
        $new_user = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        );

        if($account_type != 'users' && $account_type != 'admins' ){
            return false;
        }

        return $this->db->insert($account_type, $new_user);
    }

}