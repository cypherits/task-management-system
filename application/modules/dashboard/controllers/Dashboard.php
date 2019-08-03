<?php

/**
 * Description of Dashboard
 *
 * @author Azim
 */
class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if (!is_logged_in()) {
            redirect('auth');
        }
    }

    public function index() {
        $this->load->view('dashboard/home', ['page_title' => 'Home', 'title' => 'home']);
    }
    
    public function notified(){
        $id = $this->input->post('id');
        $this->db->where('id', $id)->update('notification', ['status' => 'read']);
    }

}
