<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {

    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['user_id' => $id])->row();
    }

    public function update_user($id, $data) {
        $this->db->where('user_id', $id);
        return $this->db->update('users', $data);
    }
}
