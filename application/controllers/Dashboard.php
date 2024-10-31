<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Campus_model');
    $this->load->model('Student_model');
    $this->load->library('session');
    $this->load->helper('url');
    
    if (!$this->session->userdata('logged_in')) {
      redirect('login'); 
    }
  }

  public function index() {
    $data['campus'] = $this->Campus_model->get_all_campus();
    $data['total_campus'] = count($data['campus']);
    $data['students'] = $this->Student_model->get_students_with_campus();
    $data['total_students'] = count($data['students']);

    $this->load->view('layouts/header');
    $this->load->view('layouts/navigation');
    $this->load->view('dashboard', $data);
    $this->load->view('layouts/footer');
  }
}