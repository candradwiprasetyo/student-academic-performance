<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuesioner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Campus_model');
        $this->load->library('session');
        $this->load->helper('url');

    }

    public function index() {

        $data['campuses'] = $this->Campus_model->get_all_campus();

        $this->load->view('layouts/header');
        $this->load->view('kuesioner/form', $data);
        $this->load->view('layouts/footer');
    }

    public function save() {
        $data = [
            'student_name' => $this->input->post('student_name'),
            'student_gpa' => $this->input->post('student_gpa'),
            'student_transportation_access_score' => $this->input->post('student_transportation_access_score'),
            'student_distance_to_campus_km' => $this->input->post('student_distance_to_campus_km'),
            'student_address' => $this->input->post('student_address'),
            'student_enrollment_year' => $this->input->post('student_enrollment_year'),
            'area_id' => $this->input->post('area_id'),
            'campus_id' => $this->input->post('campus_id'),
        ];

        $this->session->set_flashdata('success', 'Data berhasil disimpan.');
        $this->Student_model->insert_student($data);
        
        redirect('kuesioner');
    }

}
