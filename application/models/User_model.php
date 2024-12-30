<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_all_users($user_name = null) {
        if ($user_name) {
            $this->db->like('users.user_name', $user_name);
        }
        $query = $this->db->get('users');
        return $query->result();
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['user_id' => $id])->row();
    }

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data) {
        return $this->db->update('users', $data, ['user_id' => $id]);
    }

    public function delete_user($id) {
        return $this->db->delete('users', ['user_id' => $id]);
    }
}
