<?php

/**
 * Description of Tasks
 *
 * @author Azim
 */
class Tasks extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tasks/tasks_model');
    }

    public function index() {
        $data['page_title'] = 'Tasks';
        $data['title'] = 'tasks';
        $data['subtitle'] = 'list_tasks';
        $data['projects'] = $this->tasks_model->get_projects();
        $this->load->view('tasks/list', $data);
    }

    public function create() {
        $this->session->set_userdata('file_type', 'task_attachment');
        $data['page_title'] = 'Tasks';
        $data['title'] = 'tasks';
        $data['subtitle'] = 'create_task';
        $data['projects'] = $this->tasks_model->get_projects();
        $this->load->view('tasks/form', $data);
    }

    public function save_form_data() {
        $users_form_data = [];
        if ($this->session->userdata('tasks_form_data') != null) {
            $users_form_data = $this->session->userdata('tasks_form_data');
        }
        $users_form_data[$this->input->post('name')] = $this->input->post('value');
        $this->session->set_userdata('tasks_form_data', $users_form_data);
    }

    public function save() {
        if ($this->input->post('id') == 'ins') {
            $data['msg'] = $this->tasks_model->insert();
        } else {
            $data['msg'] = $this->tasks_model->update();
        }
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function getAllTasks($projects_is = '') {
        $data['data'] = $this->tasks_model->getAllTasks($projects_is);
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function attend() {
        $this->db->where('id', $this->input->post('tasks_id'))->update('tasks', ['asign_to' => $this->session->userdata('users_info')['id'], 'duration' => $this->input->post('duration'), 'status' => 'ongoing']);
        $data['msg'] = 'ok';
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function complete() {
        $this->db->where('id', $this->input->post('tasks_id'))->update('tasks', ['status' => 'completed']);
        $data['msg'] = 'ok';
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function details($id = 0) {
        $this->session->set_userdata('file_type', 'comment_attachment');
        $data = $this->tasks_model->details($id);
        $data['page_title'] = 'Tasks';
        $data['title'] = 'tasks';
        $this->load->view('tasks/details', $data);
    }

    public function add_comment() {
        $data = $this->tasks_model->add_comment();
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function remove_attach($id = 0) {
        $this->db->where('file_details_id', $id)->delete('task_attachment');
        $this->db->where('file_details_id', $id)->delete('discussion_attachment');
        $this->db->where('file_details_id', $id)->delete('temp_file_upload');
        $this->db->where('id', $id)->delete('file_details');
        redirect($_SERVER['HTTP_REFERER']);
    }

}
