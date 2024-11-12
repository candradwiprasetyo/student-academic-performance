<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->model('Campus_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); 
        }
    }

    public function index() {
        $student_name = $this->input->get('student_name');
        $campus_id = $this->input->get('campus_id'); 
        $data['students'] = $this->Student_model->get_students_with_campus($student_name, $campus_id);
        $data['campuses'] = $this->Campus_model->get_all_campus();
        $data['total_students'] = count($data['students']);
        $this->load->view('layouts/header');
        $this->load->view('layouts/navigation');
        $this->load->view('student/index', $data);
        $this->load->view('layouts/footer');
    }

    public function form($id = null) {
        if ($id) {
            $data['student'] = $this->Student_model->get_student_by_id($id);
        } else {
            $data['student'] = null;
        }

        $data['campuses'] = $this->Campus_model->get_all_campus();

        $this->load->view('layouts/header');
        $this->load->view('layouts/navigation');
        $this->load->view('student/form', $data);
        $this->load->view('layouts/footer');
    }

    public function save($id = null) {
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

        if ($id) {
            $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui.');
            $this->Student_model->update_student($id, $data);
        } else {
            $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan.');
            $this->Student_model->insert_student($data);
        }

        redirect('student');
    }

    public function delete($id) {
        $this->Student_model->delete_student($id);
        $this->session->set_flashdata('success', 'Data siswa berhasil dihapus.');
        redirect('student');
    }

    public function export() {
        $student_name = $this->input->get('student_name');
        $campus_id = $this->input->get('campus_id');
        $data = $this->Student_model->get_students_with_campus($student_name, $campus_id);
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="students_data.json"');
        echo json_encode($data);
    }
}
