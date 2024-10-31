<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analysis extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Student_model');
    $this->load->library('session');
    $this->load->helper('url');
    
    if (!$this->session->userdata('logged_in')) {
        redirect('login'); 
    }
}
    
  public function index() {
      $jsonFilePath = './assets/json/model_results.json';
  
      if (file_exists($jsonFilePath)) {
          $jsonFile = file_get_contents($jsonFilePath);
          $data['results'] = json_decode($jsonFile, true);
      } else {
          $data['results'] = null;
      }

      $this->load->view('layouts/header');
      $this->load->view('layouts/navigation');
      $this->load->view('analysis/index', $data);
      $this->load->view('layouts/footer');
  }

  public function export_data() {
      $this->load->model('Student_model');
      $students = $this->Student_model->get_all_students(); 

      $json_data = json_encode($students);
      
      $file_path = './assets/json/students_data.json';
      file_put_contents($file_path, $json_data);
      
      $this->load->helper('download');
      force_download($file_path, NULL);
  }
}
