<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function register() {
        $email = 'candra@gmail.com';
        $plain_password = '1';
        
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
    
        $data = [
            'user_name' => 'Candra',
            'user_email' => $email,
            'user_password' => $hashed_password,
        ];
    
        if ($this->db->insert('users', $data)) {
            redirect('login'); 
        } else {
            $this->session->set_flashdata('error', 'Registration failed. Please try again.');
            redirect('register'); 
        }
    }

    public function do_login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->db->where('user_email', $email);
        $user = $this->db->get('users')->row();

        if ($user && password_verify($password, $user->user_password)) {
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('user_id', $user->user_id);
            $this->session->set_userdata('user_name', $user->user_name);
            $this->session->set_userdata('user_role', $user->user_role);
            redirect('/dashboard'); 
        } else {
            $this->session->set_flashdata('error', 'Login failed. Wrong email or password');
            redirect('login?err=1');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
