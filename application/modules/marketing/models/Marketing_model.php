<?php

/**
 * Description of Marketing_model
 *
 * @author Azim
 */
class Marketing_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function visit_insert() {
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
        $this->form_validation->set_rules('company_phone', 'Phone/Mobile', 'required');
        $this->form_validation->set_rules('brief', 'Brief', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        }
        $set = [
            'company_name' => $this->input->post('company_name'),
            'contact_person' => $this->input->post('contact_person'),
            'company_address' => $this->input->post('company_address'),
            'company_phone' => $this->input->post('company_phone'),
            'company_email' => $this->input->post('company_email'),
            'company_website' => $this->input->post('company_website'),
            'brief' => $this->input->post('brief'),
            'followup_date' => $this->input->post('followup_date'),
            'users_id' => $this->session->userdata('users_info')['id']
        ];
        $this->db->insert('market_visit', $set);
        if ($this->db->insert_id() > 0) {
            $this->session->unset_userdata('marketing_form_data');
            return 'ok';
        } else {
            return '<p>Database Error! Try Again Later.</p>';
        }
    }

    public function tele_insert() {
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
        $this->form_validation->set_rules('company_phone', 'Phone/Mobile', 'required');
        $this->form_validation->set_rules('brief', 'Brief', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        }
        $set = [
            'company_name' => $this->input->post('company_name'),
            'contact_person' => $this->input->post('contact_person'),
            'company_phone' => $this->input->post('company_phone'),
            'brief' => $this->input->post('brief'),
            'users_id' => $this->session->userdata('users_info')['id']
        ];
        $this->db->insert('telemerketing', $set);
        if ($this->db->insert_id() > 0) {
            $this->session->unset_userdata('marketing_form_data');
            return 'ok';
        } else {
            return '<p>Database Error! Try Again Later.</p>';
        }
    }

    public function getAllVisit() {
        $sql = $this->db->get('market_visit');
        $data = [];
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                $data[] = [
                    $row->company_name,
                    $row->contact_person,
                    $row->company_phone,
                    date('d-M-Y', strtotime($row->created_at)),
                    $row->brief,
                    date('d-M-Y', strtotime($row->followup_date)),
                    '<a href="' . base_url('marketing/details/' . $row->id) . '"><i class="fa fa-eye text-warning"></i></a>'
                ];
            }
        }
        return $data;
    }

    public function getAllTele() {
        $sql = $this->db->get('telemerketing');
        $data = [];
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                $data[] = [
                    $row->company_name,
                    $row->contact_person,
                    $row->company_phone,
                    date('d-M-Y', strtotime($row->created_at)),
                    $row->brief
                ];
            }
        }
        return $data;
    }

    public function details($id) {
        $data = [];
        $sql = $this->db->where('id', $id)->get('market_visit');
        if ($sql->num_rows() > 0) {
            $data = $sql->row_array();
        } else {
            show_404();
            die();
        }
        return $data;
    }

}
