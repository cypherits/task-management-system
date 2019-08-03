<?php

/**
 * Description of Marketing
 *
 * @author Azim
 */
class Marketing extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_logged_in()) {
            redirect('auth');
        }
        $this->load->model('marketing/marketing_model');
    }

    public function index() {
        $data['page_title'] = 'Marketing';
        $data['title'] = 'Marketing';
        $data['subtitle'] = 'list_marketing';
        $this->load->view('marketing/list', $data);
    }

    public function visit() {
        $data['page_title'] = 'Marketing';
        $data['title'] = 'marketing';
        $data['subtitle'] = 'visit';
        $this->load->view('marketing/visit_form', $data);
    }

    public function tele() {
        $data['page_title'] = 'Marketing';
        $data['title'] = 'marketing';
        $data['subtitle'] = 'tele';
        $this->load->view('marketing/tele_form', $data);
    }

    public function save_form_data() {
        $users_form_data = [];
        if ($this->session->userdata('marketing_form_data') != null) {
            $users_form_data = $this->session->userdata('marketing_form_data');
        }
        $users_form_data[$this->input->post('name')] = $this->input->post('value');
        $this->session->set_userdata('marketing_form_data', $users_form_data);
    }

    public function save($type = 'visit') {
        if ($this->input->post('id') == 'ins') {
            if ($type == 'visit') {
                $data['msg'] = $this->marketing_model->visit_insert();
            } else {
                $data['msg'] = $this->marketing_model->tele_insert();
            }
        } else {
            if ($type == 'visit') {
                $data['msg'] = $this->marketing_model->visit_update();
            } else {
                $data['msg'] = $this->marketing_model->tele_update();
            }
        }
        $data['csrf'] = $this->security->get_csrf_hash();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function getAllVisit() {
        $data['data'] = $this->marketing_model->getAllVisit();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function getAllTele() {
        $data['data'] = $this->marketing_model->getAllTele();
        header("Content-Type: Application/json");
        echo json_encode($data);
    }

    public function details($id = 0) {
        $data = $this->marketing_model->details($id);
        $data['page_title'] = 'Marketing';
        $data['title'] = 'marketing';
        $this->load->view('marketing/details', $data);
    }

}
