<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper('url');
    
    if (!$this->session->userdata('logged_in')) {
      redirect('login'); 
    }
  }

  public function index() {
    $this->load->view('layouts/header');
    $this->load->view('layouts/navigation');
    $this->load->view('dashboard');
    $this->load->view('layouts/footer');
  }
}