<?php

/**
 * Description of Projects
 *
 * @author Azim
 */
class Projects extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_logged_in()) {
            redirect('auth');
        }
        $this->load->model('projects/projects_model');
    }

    public function index() {
        $data['page_title'] = 'Projects';
        $data['title'] = 'projects';
        $data['subtitle'] = 'list_projects';
        $data['clients'] = $this->projects_model->get_clients();
        $this->load->view('projects/list', $data);
    }

    public function create() {
        $data['page_title'] = 'Projects';
        $data['title'] = 'projects';
        $data['subtitle'] = 'create_project';
        $data['clients'] = $this->projects_model->get_clients();
        $this->load->view('projects/form', $data);
    }

    public function save_form_data() {
        $users_form_data = [];
        if ($this->session->userdata('projects_form_data') != null) {
            $users_form_data = $this->session->userdata('projects_form_data');
        }
        $users_form_data[$this->input->post('name')] = $this->input->post('value');
        $this->session->set_userdata('projects_form_data', $users_form_data);
    }

    public function save() {
        if ($this->input->post('id') == 'ins') {
            $data['msg'] = $this->projects_model->insert();
        } else {
            $data['msg'] = $this->projects_model->update();
        }
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function getAllProjects($clients_id = '') {
        $data['data'] = $this->projects_model->getAllProjects($clients_id);
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function edit($id) {
        $data = $this->projects_model->get_project($id);
        if (!$data) {
            die(show_404());
        }
        $users_form_data = [
            'id' => $data['id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'clients_id' => $data['clients_id']
        ];
        $this->session->set_userdata('projects_form_data', $users_form_data);
        $data['page_title'] = 'Projects';
        $data['title'] = 'projects';
        $data['clients'] = $this->projects_model->get_clients();
        $this->load->view('projects/form', $data);
    }

    public function details($id = 0) {
        $data = $this->projects_model->details($id);
        $data['page_title'] = 'Projects';
        $data['title'] = 'projects';
        $this->load->view('projects/details', $data);
    }

}
