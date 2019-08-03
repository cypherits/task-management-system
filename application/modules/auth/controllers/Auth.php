<?php

/**
 * Description of Auth
 *
 * @author Azim
 */
class Auth extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth/auth_model');
    }

    public function index() {
        if (is_logged_in()) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function user_auth() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $data['msg'] = validation_errors();
        } else {
            $data['msg'] = $this->auth_model->user_auth();
        }
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function logout() {
        $this->session->unset_userdata('users_info');
        redirect('auth');
    }

}
