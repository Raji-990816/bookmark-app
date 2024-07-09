<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        // Load the database library
        $this->load->database();
    }

    // Register a new user with username and hashed password
    public function register($username, $password) {
        $data = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        );
        return $this->db->insert('users', $data);
    }

    // Check if a username already exists in the database
    public function check_username_exists($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    // Validate user login by verifying username and password
    public function login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $user = $query->row();

        // Verify the password against the hashed password in the database
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
