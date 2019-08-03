<?php

/**
 * Description of Auth_model
 *
 * @author Azim
 */
class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function user_auth() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $sql = $this->db->where('username', $username)->where('password', md5($password))->get('users');
        if ($sql->num_rows() == 0) {
            return 'Username And Password Does Not Match!';
        } else {
            $users_info = $sql->row_array();
            $this->session->set_userdata('users_info', $users_info);
            return 'ok';
        }
    }

}
