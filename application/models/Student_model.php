<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

    public function get_all_students() {
        return $this->db->get('students')->result();
    }

    public function get_student_by_id($id) {
        return $this->db->get_where('students', ['student_id' => $id])->row();
    }

    public function insert_student($data) {
        return $this->db->insert('students', $data);
    }

    public function update_student($id, $data) {
        $this->db->where('student_id', $id);
        return $this->db->update('students', $data);
    }

    public function delete_student($id) {
        return $this->db->delete('students', ['student_id' => $id]);
    }

    public function get_students_with_campus() {
        $this->db->select('students.*, campus.campus_name');
        $this->db->from('students');
        $this->db->join('campus', 'students.campus_id = campus.campus_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
}
