<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campus_model extends CI_Model {

    public function get_all_campus($campus_name='') {
        if ($campus_name) {
            $this->db->like('campus.campus_name', $campus_name);
        }
        $query = $this->db->get('campus');
        return $query->result();
    }

    public function insert_campus($data) {
        $this->db->insert('campus', $data);
    }

    public function get_campus_by_id($id) {
        return $this->db->get_where('campus', ['campus_id' => $id])->row();
    }
    
    public function update_campus($id, $data) {
        $this->db->where('campus_id', $id);
        $this->db->update('campus', $data);
    }

    public function delete_campus($id) {
        $this->db->delete('campus', array('campus_id' => $id));
    }
}
