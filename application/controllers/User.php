<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $data['total_users'] = count($data['users']);
        $this->load->view('layouts/header');
        $this->load->view('layouts/navigation');
        $this->load->view('user/index', $data);
        $this->load->view('layouts/footer');
    }

    public function form($id = null) {
        if ($id) {
            $data['user'] = $this->User_model->get_user_by_id($id);
        } else {
            $data['user'] = null;
        }

        $this->load->view('layouts/header');
        $this->load->view('layouts/navigation');
        $this->load->view('user/form', $data);
        $this->load->view('layouts/footer');
    }

    public function save($id = null) {
        $data = [
            'user_name' => $this->input->post('user_name'),
            'user_email' => $this->input->post('user_email'),
            'user_role' => $this->input->post('user_role'),
        ];
    
        $password = $this->input->post('user_password');
        if (!empty($password)) {
            $data['user_password'] = password_hash($password, PASSWORD_DEFAULT);
        } else {
            if ($id) {
                $existing_user = $this->User_model->get_user_by_id($id);
                if ($existing_user) {
                    $data['user_password'] = $existing_user->user_password; 
                }
            }
        }
    
        if ($id) {
            $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui.');
            $this->User_model->update_user($id, $data);
        } else {
            $this->session->set_flashdata('success', 'Data pengguna berhasil ditambahkan.');
            $this->User_model->insert_user($data);
        }
    
        redirect('user');
    }

    public function delete($id) {
        $this->User_model->delete_user($id);
        $this->session->set_flashdata('success', 'Data pengguna berhasil dihapus.');
        redirect('user');
    }
}
