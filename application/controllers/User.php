<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    // Handle user login
    public function login() {
        if ($this->input->method() === 'post') {
            $data = json_decode(file_get_contents('php://input'), true);
            $username = $data['username'];
            $password = $data['password'];

            // Check if username and password are provided
            if (empty($username) || empty($password)) {
                $response = array('error' => 'Username and password are required');
                echo json_encode($response);
                return;
            }

            // Attempt to log the user in
            $user = $this->User_model->login($username, $password);

            if ($user) {
                // Set session data if login is successful
                $this->session->set_userdata('user_id', $user->id);
                $response = array('success' => 'Login successful');
                echo json_encode($response);
            } else {
                // Return error if login fails
                $response = array('error' => 'Invalid username or password');
                echo json_encode($response);
            }
        } else {
            // Load the login view
            $this->load->view('login');
        }
    }

    // Handle user registration
    public function register() {
        if ($this->input->method() === 'post') {
            $data = json_decode(file_get_contents('php://input'), true);
            $username = $data['username'];
            $password = $data['password'];

            // Check if username and password are provided
            if (empty($username) || empty($password)) { 
                $response = array('error' => 'Username and password are required');
                log_message('debug', 'Registration attempt with empty username or password');
                echo json_encode($response);
                return;
            }

            // Check if the username already exists
            if ($this->User_model->check_username_exists($username)) {
                $response = array('error' => 'Username already exists');
                log_message('debug', 'Username already exists: ' . $username);
                echo json_encode($response);
            } else {
                // Attempt to register the user
                if ($this->User_model->register($username, $password)) {
                    $response = array('success' => 'Registration successful');
                    log_message('debug', 'Registration successful for user: ' . $username);
                    echo json_encode($response);
                } else {
                    $response = array('error' => 'Registration failed');
                    log_message('debug', 'Registration failed for user: ' . $username);
                    echo json_encode($response);
                }
            }
        } else {
            // Load the register view
            $this->load->view('register');
        }
    }

    // Handle user logout
    public function logout() {
        $this->session->unset_userdata('user_id'); // Unset session data
        $this->session->sess_destroy(); // Destroy the session
        redirect('user/login'); // Redirect to login page
    }
}
