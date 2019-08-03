<?php

/**
 * Description of Projects_model
 *
 * @author Azim
 */
class Projects_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_clients() {
        if ($this->session->userdata('users_info')['type'] == 'client') {
            $this->db->where('id', $this->session->userdata('users_info')['id']);
        }
        $sql = $this->db->select(['id', 'first_name', 'last_name'])->where('type', 'client')->get('users');
        $data = [];
        if ($sql->num_rows() > 0) {
            $data = $sql->result_array();
        }
        return $data;
    }

    public function insert() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('clients_id', 'Client', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        }
        $set = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'clients_id' => $this->input->post('clients_id'),
            'users_id' => $this->session->userdata('users_info')['id']
        ];
        $this->db->insert('projects', $set);
        $insert_id = $this->db->insert_id();
        if ($insert_id > 0) {
            $this->session->unset_userdata('projects_form_data');
            $sql = $this->db->select('id')->where('type != "client"')->get('users');
            foreach ($sql->result() as $users) {
                if ($users->id != $this->session->userdata('users_info')['id']) {
                    $set = [
                        'from_users_id' => $this->session->userdata('users_info')['id'],
                        'to_users_id' => $users->id,
                        'table' => 'projects',
                        'table_id' => $insert_id,
                        'notice' => 'New Project Created By ' . get_user_name_by_id($this->session->userdata('users_info')['id'])
                    ];
                    $this->db->insert('notification', $set);
                }
            }
            if ($this->input->post('clients_id') != $this->session->userdata('users_info')['id']) {
                $set = [
                    'from_users_id' => $this->session->userdata('users_info')['id'],
                    'to_users_id' => $this->input->post('clients_id'),
                    'table' => 'projects',
                    'table_id' => $insert_id,
                    'notice' => 'New Project Created By ' . get_user_name_by_id($this->session->userdata('users_info')['id'])
                ];
                $this->db->insert('notification', $set);
            }
            return 'ok';
        } else {
            return '<p>Database Error! Try Again Later.</p>';
        }
    }

    public function update() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('clients_id', 'Client', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        }
        $set = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'clients_id' => $this->input->post('clients_id'),
        ];
        $this->db->where('id', $this->input->post('id'))->update('projects', $set);
        $this->session->unset_userdata('projects_form_data');
        return 'ok';
    }

    public function getAllProjects($clients_id) {
        if ($clients_id != '') {
            $this->db->where('clients_id', $clients_id);
        }
        $sql = $this->db->get('projects');
        $data = [];
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                $data[] = [
                    $row->title,
                    get_user_name_by_id($row->clients_id),
                    get_user_name_by_id($row->users_id),
                    date('d-M-Y', strtotime($row->created_at)),
                    $row->description,
                    '<a href="' . base_url('projects/edit/' . $row->id) . '"><i class="fa fa-edit text-info"></i></a> <a href="' . base_url('projects/details/' . $row->id) . '"><i class="fa fa-eye text-warning"></i></a>'
                ];
            }
        }
        return $data;
    }

    public function get_project($id) {
        $sql = $this->db->where('id', $id)->get('projects');
        if ($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return FALSE;
        }
    }

    public function details($id) {
        $sql = $this->db->where('id', $id)->get('projects');
        if ($sql->num_rows() == 1) {
            $row = $sql->row();
            $project = [
                'name' => $row->title,
                'clients_name' => get_user_name_by_id($row->clients_id),
                'description' => $row->description
            ];
            $sql = $this->db->where('projects_id', $id)->where('status', 'queued')->order_by('id', 'DESC')->get('tasks');
            if ($sql->num_rows() > 0) {
                $tasks = [];
                $i = 1;
                foreach ($sql->result_array() as $qrow) {
                    $tasks[] = $qrow;
                    if ($i > 5) {
                        break;
                    }
                    $i++;
                }
                $queued = [
                    'count' => $sql->num_rows(),
                    'tasks' => $tasks
                ];
            } else {
                $queued = [
                    'count' => 0,
                    'tasks' => []
                ];
            }
            $sql = $this->db->where('projects_id', $id)->where('status', 'ongoing')->order_by('id', 'DESC')->get('tasks');
            if ($sql->num_rows() > 0) {
                $tasks = [];
                $i = 1;
                foreach ($sql->result_array() as $orow) {
                    $tasks[] = $orow;
                    if ($i > 5) {
                        break;
                    }
                    $i++;
                }
                $ongoing = [
                    'count' => $sql->num_rows(),
                    'tasks' => $tasks
                ];
            } else {
                $ongoing = [
                    'count' => 0,
                    'tasks' => []
                ];
            }
            $sql = $this->db->where('projects_id', $id)->where('status', 'completed')->order_by('id', 'DESC')->get('tasks');
            if ($sql->num_rows() > 0) {
                $tasks = [];
                $i = 1;
                foreach ($sql->result_array() as $crow) {
                    $tasks[] = $crow;
                    if ($i > 5) {
                        break;
                    }
                    $i++;
                }
                $completed = [
                    'count' => $sql->num_rows(),
                    'tasks' => $tasks
                ];
            } else {
                $completed = [
                    'count' => 0,
                    'tasks' => []
                ];
            }
            $project['queued'] = $queued;
            $project['ongoing'] = $ongoing;
            $project['completed'] = $completed;
            return $project;
        } else {
            show_404();
            die();
        }
    }

}
