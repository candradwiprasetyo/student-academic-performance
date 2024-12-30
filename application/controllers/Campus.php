<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campus extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->model('Campus_model');
      $this->load->library('session');
      $this->load->helper('url');
      
      if (!$this->session->userdata('logged_in')) {
        redirect('login'); 
      }
  }

  public function index() {
      $campus_name = $this->input->get('campus_name');
      $data['campus'] = $this->Campus_model->get_all_campus($campus_name);
      $data['total_campus'] = count($data['campus']);
      $this->load->view('layouts/header');
      $this->load->view('layouts/navigation');
      $this->load->view('campus/index', $data);
      $this->load->view('layouts/footer');
  }

  public function form($id = null) {
      $this->load->model('Campus_model');
      
      if ($id) {
          $data['campus'] = $this->Campus_model->get_campus_by_id($id);
      } else {
          $data['campus'] = null;
      }

      $this->load->view('layouts/header');
      $this->load->view('layouts/navigation');
      $this->load->view('campus/form', $data);
      $this->load->view('layouts/footer');
  }

  public function save($id = null) {
      $this->load->model('Campus_model');

      $data = [
          'campus_name' => $this->input->post('campus_name'),
          'campus_address' => $this->input->post('campus_address'),
      ];

      if ($id) {
          $this->session->set_flashdata('success', 'Data kampus berhasil diperbarui.');
          $this->Campus_model->update_campus($id, $data);
      } else {
          $this->session->set_flashdata('success', 'Data kampus berhasil ditambahkan.');
          $this->Campus_model->insert_campus($data);
      }

      redirect('campus');
  }

  public function delete($id) {
      $this->load->model('Campus_model');
      $this->Campus_model->delete_campus($id);
      $this->session->set_flashdata('success', 'Data kampus berhasil dihapus.');
      redirect('campus');
  }
}
