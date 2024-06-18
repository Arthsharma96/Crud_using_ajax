<?php
class UserM extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch all users
    public function get_users() {
        $query = $this->db->get('users');
        return $query->result();
    }

    // Insert user
    public function insert_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    // Update user
    public function update_user($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    // Delete user
    public function delete_user($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    // Fetch single user
    public function get_user($id) {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row();
    }

}
?>
