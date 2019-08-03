<?php

/**
 * Description of Tasks_model
 *
 * @author Azim
 */
class Tasks_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_projects() {
        if ($this->session->userdata('users_info')['type'] == 'client') {
            $this->db->where('clients_id', $this->session->userdata('users_info')['id']);
        }
        $sql = $this->db->select(['id', 'title'])->get('projects');
        $data = [];
        if ($sql->num_rows() > 0) {
            $data = $sql->result_array();
        }
        return $data;
    }

    public function insert() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('projects_id', 'Project', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        }
        $set = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'projects_id' => $this->input->post('projects_id'),
            'priority' => $this->input->post('priority'),
            'users_id' => $this->session->userdata('users_info')['id']
        ];
        $this->db->insert('tasks', $set);
        if ($this->db->insert_id() > 0) {
            $insert_id = $this->db->insert_id();
            $this->session->unset_userdata('tasks_form_data');
            $this->session->unset_userdata('file_type');
            $queued = get_queued_attach('tasks');
            $qarr = [];
            foreach ($queued as $attach) {
                $qarr[] = $attach['file_details_id'];
            }
            if (!empty($qarr)) {
                $this->db->where_in('file_details_id', $qarr)->update('task_attachment', ['tasks_id' => $insert_id]);
                $this->db->where_in('file_details_id', $qarr)->update('temp_file_upload', ['status' => 'done']);
            }
            $this->create_notification_task($insert_id, $this->input->post('projects_id'));
            return 'ok';
        } else {
            return '<p>Database Error! Try Again Later.</p>';
        }
    }

    private function create_notification_task($insert_id, $projects_id) {
        $project = $this->db->select(['title', 'clients_id'])->where('id', $projects_id)->get('projects')->row();
        $sql = $this->db->select('id')->where('type', 'admin')->or_where('type', 'developer')->get('users');
        foreach ($sql->result() as $users) {
            if ($users->id != $this->session->userdata('users_info')['id']) {
                $set = [
                    'from_users_id' => $this->session->userdata('users_info')['id'],
                    'to_users_id' => $users->id,
                    'table' => 'tasks',
                    'table_id' => $insert_id,
                    'notice' => 'New Task Created at ' . $project->title . ' By ' . get_user_name_by_id($this->session->userdata('users_info')['id'])
                ];
                $this->db->insert('notification', $set);
            }
        }
        if ($project->clients_id != $this->session->userdata('users_info')['id']) {
            $set = [
                'from_users_id' => $this->session->userdata('users_info')['id'],
                'to_users_id' => $project->clients_id,
                'table' => 'tasks',
                'table_id' => $insert_id,
                'notice' => 'New Task Created at ' . $project->title . ' By ' . get_user_name_by_id($this->session->userdata('users_info')['id'])
            ];
            $this->db->insert('notification', $set);
        }
    }

    public function getAllTasks($projects_id) {
        if ($projects_id != '') {
            $this->db->where('projects_id', $projects_id);
        }
        $sql = $this->db->order_by('status', 'ASC')->order_by('priority', 'ASC')->order_by('id', 'DESC')->get('tasks');
        $data = [];
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                if ($row->asign_to != 0) {
                    if ($row->status != 'completed') {
                        if ($row->asign_to != $this->session->userdata('users_info')['id']) {
                            $status = get_user_name_by_id($row->asign_to) . ' Is Attending';
                        } else {
                            $status = '<button class="complete btn btn-primary" data-id="' . $row->id . '">Complete</button>';
                        }
                    } else {
                        $status = 'Completed by ' . get_user_name_by_id($row->asign_to);
                    }
                } else {
                    $status = '<button class="attend btn btn-info" data-id="' . $row->id . '">Attend</button>';
                }
                $data[] = [
                    get_project_name_by_id($row->projects_id),
                    $row->title,
                    get_user_name_by_id($row->users_id),
                    $row->priority,
                    $row->duration,
                    date('d-M-Y', strtotime($row->created_at)),
                    $status,
                    '<a href="' . base_url('tasks/details/' . $row->id) . '"><i class="fa fa-eye text-warning"></i></a>'
                ];
            }
        }
        return $data;
    }

    public function details($id) {
        $data = [];
        if ($id != 0) {
            $sql = $this->db->select([
                        't.id as id',
                        't.title as task_title',
                        'p.title as project_title',
                        't.projects_id as projects_id',
                        't.users_id as users_id',
                        't.asign_to as asign_to',
                        't.created_at as created_at',
                        't.duration as duration',
                        't.description as description',
                        't.status as status'
                    ])->where('t.id', $id)->join('projects as p', 't.projects_id = p.id')->get('tasks as t');
            if ($sql->num_rows() == 1) {
                $data = $sql->row_array();
                $data['created_by'] = get_user_name_by_id($data['users_id']);
                $data['attended_by'] = get_user_name_by_id($data['asign_to']);
                $data['created_at'] = date('d-M-Y', strtotime($data['created_at']));
                $data['attachemnts'] = $this->tasks_attachments($id);
                $data['comments'] = $this->get_comments($id);
            }
        }
        return $data;
    }

    private function tasks_attachments($id = 0) {
        $data = [];
        $sql = $this->db->select('file_details_id')->where('tasks_id', $id)->get('task_attachment');
        if ($sql->num_rows() > 0) {
            $data = $sql->result_array();
        }
        return $data;
    }

    private function get_comments($tasks_id = 0) {
        $data = [];
        if ($tasks_id != 0) {
            $sql = $this->db->select([
                        'd.id as id',
                        'd.comment as comment',
                        'd.created_at as created_at',
                        'u.first_name as first_name',
                        'u.last_name as last_name',
                        'u.profile_pic_id as profile_pic_id'
                    ])->where('tasks_id', $tasks_id)->join('users as u', 'd.users_id = u.id')->order_by('id', 'ASC')->get('discussion as d');
            if ($sql->num_rows() > 0) {
                $data = $sql->result_array();
                foreach ($data as $key => $value) {
                    $data[$key]['attachemnts'] = $this->discussion_attachments($value['id']);
                }
            }
        }
        return $data;
    }

    private function discussion_attachments($id = 0) {
        $data = [];
        $sql = $this->db->select('file_details_id')->where('discussion_id', $id)->get('discussion_attachment');
        if ($sql->num_rows() > 0) {
            $data = $sql->result_array();
        }
        return $data;
    }

    public function add_comment() {
        $this->form_validation->set_rules('tasks_id', 'Title', 'required');
        $this->form_validation->set_rules('comment', 'Comment', 'required');
        if ($this->form_validation->run() == FALSE) {
            return ['msg' => validation_errors()];
        }
        $set = [
            'tasks_id' => $this->input->post('tasks_id'),
            'comment' => $this->input->post('comment'),
            'users_id' => $this->session->userdata('users_info')['id']
        ];
        $this->db->insert('discussion', $set);
        if ($this->db->insert_id() > 0) {
            $insert_id = $this->db->insert_id();
            $queued = get_queued_attach('discussion');
            $qarr = [];
            foreach ($queued as $attach) {
                $qarr[] = $attach['file_details_id'];
            }
            if (!empty($qarr)) {
                $this->db->where_in('file_details_id', $qarr)->update('discussion_attachment', ['discussion_id' => $insert_id]);
                $this->db->where_in('file_details_id', $qarr)->update('temp_file_upload', ['status' => 'done']);
            }
            $this->create_notification_discussion($this->input->post('tasks_id'));
            return [
                'msg' => 'ok',
            ];
        } else {
            return [
                'msg' => '<p>Something Went Wrong! Please Try Again Later!</p>',
            ];
        }
    }

    private function create_notification_discussion($tasks_id) {
        $task = $this->db->select(['title', 'asign_to'])->where('id', $tasks_id)->get('tasks')->row();
        $sql = $this->db->select('id')->where('type', 'admin')->get('users');
        foreach ($sql->result() as $users) {
            if ($users->id != $this->session->userdata('users_info')['id']) {
                $set = [
                    'from_users_id' => $this->session->userdata('users_info')['id'],
                    'to_users_id' => $users->id,
                    'table' => 'discussion',
                    'table_id' => $tasks_id,
                    'notice' => 'New Comment Made at ' . $task->title . ' By ' . get_user_name_by_id($this->session->userdata('users_info')['id'])
                ];
                $this->db->insert('notification', $set);
            }
        }
        if ($task->asign_to != $this->session->userdata('users_info')['id']) {
            $set = [
                'from_users_id' => $this->session->userdata('users_info')['id'],
                'to_users_id' => $task->asign_to,
                'table' => 'discussion',
                'table_id' => $tasks_id,
                'notice' => 'New Comment Made at ' . $task->title . ' By ' . get_user_name_by_id($this->session->userdata('users_info')['id'])
            ];
            $this->db->insert('notification', $set);
        }
    }

}
