<?php

/**
 * Description of Users
 *
 * @author Azim
 */
class Users extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_logged_in()) {
            redirect('auth');
        }
        $this->load->model('users/users_model');
    }

    public function index() {
        $data['page_title'] = 'Users';
        $data['title'] = 'users';
        $data['subtitle'] = 'list_users';
        $this->load->view('users/list', $data);
    }

    public function create() {
        $this->session->set_userdata('file_type', 'profile_pic');
        $data['page_title'] = 'Users';
        $data['title'] = 'users';
        $data['subtitle'] = 'create_user';
        $this->load->view('users/form', $data);
    }

    public function save_form_data() {
        $users_form_data = [];
        if ($this->session->userdata('users_form_data') != null) {
            $users_form_data = $this->session->userdata('users_form_data');
        }
        $users_form_data[$this->input->post('name')] = $this->input->post('value');
        $this->session->set_userdata('users_form_data', $users_form_data);
    }

    public function save() {
        if ($this->input->post('id') == 'ins') {
            $data['msg'] = $this->users_model->insert();
        } else {
            $data['msg'] = $this->users_model->update();
        }
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function getAllUsers($type = '') {
        $data['data'] = $this->users_model->getAllUsers($type);
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function profile($id = 0) {
        if ($id == 0) {
            $id = $this->session->userdata('users_info')['id'];
        }
        $data = $this->users_model->get_user($id);
        if (!$data) {
            die(show_404());
        }
        $data['page_title'] = 'Profile';
        $data['title'] = 'users';
        $this->load->view('users/profile', $data);
    }

    public function edit($id) {
        if ($id == 0) {
            $id = $this->session->userdata('users_info')['id'];
        }
        $data = $this->users_model->get_user($id);
        if (!$data) {
            die(show_404());
        }
        $users_form_data = [
            'id' => $data['id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'type' => $data['type'],
            'status' => $data['status'],
        ];
        if ($this->session->userdata('profile_pic_id') == null) {
            $this->session->set_userdata('profile_pic_id', $data['profile_pic_id']);
        }
        $this->session->set_userdata('users_form_data', $users_form_data);
        $this->session->set_userdata('file_type', 'profile_pic');
        $data['page_title'] = 'Users';
        $data['title'] = 'users';
        $this->load->view('users/form', $data);
    }

}
