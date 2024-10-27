<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        if ($this->session->userdata('logged_in')) {
            redirect('dashboard'); 
        }
    }
    
    public function index() {
        $this->load->view('layouts/header');
        $this->load->view('login');
        $this->load->view('layouts/footer');
    }
}