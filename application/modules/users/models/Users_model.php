<?php

/**
 * Description of Users_model
 *
 * @author Azim
 */
class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        }
        $set = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'type' => $this->input->post('type'),
            'status' => $this->input->post('status'),
            'profile_pic_id' => $this->session->userdata('profile_pic_id')
        ];
        $this->db->insert('users', $set);
        if ($this->db->insert_id() > 0) {
            $this->session->unset_userdata('users_form_data');
            $this->session->unset_userdata('profile_pic_id');
            return 'ok';
        } else {
            return '<p>Database Error! Try Again Later.</p>';
        }
    }

    public function update() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        }
        $set = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'type' => $this->input->post('type'),
            'status' => $this->input->post('status'),
            'profile_pic_id' => $this->session->userdata('profile_pic_id')
        ];
        if ($this->input->post('password') != '') {
            $set['password'] = md5($this->input->post('password'));
        }
        $this->db->where('id', $this->input->post('id'))->update('users', $set);
        $this->session->unset_userdata('users_form_data');
        $this->session->unset_userdata('profile_pic_id');
        return 'ok';
    }

    public function getAllUsers($type) {
        if ($type != '') {
            $this->db->where('type', $type);
        }
        $sql = $this->db->get('users');
        $data = [];
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                $data[] = [
                    $row->first_name . ' ' . $row->last_name,
                    $row->username,
                    $row->email,
                    ucfirst($row->type),
                    ucfirst($row->status),
                    '<a href="' . base_url('users/profile/' . $row->id) . '"><i class="fa fa-eye text-primary"></i></a>&nbsp;&nbsp;<a href="' . base_url('users/edit/' . $row->id) . '"><i class="fa fa-edit text-info"></i></a>'
                ];
            }
        }
        return $data;
    }

    public function get_user($id) {
        $sql = $this->db->where('id', $id)->get('users');
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return FALSE;
        }
    }

}
