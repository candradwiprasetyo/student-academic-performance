<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

  public function get_student_count_per_campus() {
    $this->db->select('campus.campus_name, COUNT(students.student_id) as student_count');
    $this->db->from('students');
    $this->db->join('campus', 'students.campus_id = campus.campus_id', 'left');
    $this->db->group_by('campus.campus_name');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_average_gpa_per_campus() {
    $this->db->select('campus.campus_name, AVG(students.student_gpa) as average_gpa');
    $this->db->from('students');
    $this->db->join('campus', 'students.campus_id = campus.campus_id', 'left');
    $this->db->group_by('campus.campus_name');
    $this->db->order_by('average_gpa', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_average_transportation_score_per_campus() {
    $this->db->select('campus.campus_name, AVG(students.student_transportation_access_score) as average_transportation_score');
    $this->db->from('students');
    $this->db->join('campus', 'students.campus_id = campus.campus_id', 'left');
    $this->db->group_by('campus.campus_name');
    $query = $this->db->get();
    return $query->result();
  }

}
