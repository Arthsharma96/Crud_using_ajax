<?php
class UserC extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserM');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('view_user');
    }

    // Fetch all users
    public function fetch_users() {
        $data = $this->UserM->get_users();
        echo json_encode($data);
    }

    // Insert user
    public function insert_user() {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email')
        );
        $insert_id = $this->UserM->insert_user($data);
        echo json_encode(array("id" => $insert_id));
    }

    // Update user
    public function update_user() {
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email')
        );
        $this->UserM->update_user($id, $data);
        echo json_encode("User updated successfully");
    }

    // Delete user
    public function delete_user() {
        $id = $this->input->post('id');
        $this->UserM->delete_user($id);
        echo json_encode("User deleted successfully");
    }

    // Fetch single user
    public function get_user() {
        $id = $this->input->post('id');
        $data = $this->UserM->get_user($id);
        echo json_encode($data);
    }

}

?>
