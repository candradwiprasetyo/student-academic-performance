<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Profile_model');
        $this->load->library('session');

        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->Profile_model->get_user_by_id($user_id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/navigation');
        $this->load->view('profile', $data);
        $this->load->view('layouts/footer');
    }

    public function update() {
      $user_id = $this->session->userdata('user_id');
      $user = $this->Profile_model->get_user_by_id($user_id);
  
      $data = [
          'user_name' => $this->input->post('user_name'),
          'user_email' => $this->input->post('user_email'),
      ];
  
      $old_password = $this->input->post('user_password_old');
      $new_password = $this->input->post('user_password');
  
      if (!password_verify($old_password, $user->user_password)) {
          $this->session->set_flashdata('error', 'Password lama tidak cocok.');
          redirect('profile');
      }
  
      if (!empty($new_password)) {
          $data['user_password'] = password_hash($new_password, PASSWORD_DEFAULT);
      }
  
      $this->Profile_model->update_user($user_id, $data);
      $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
      redirect('profile');
  }
}
