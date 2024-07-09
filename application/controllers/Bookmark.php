<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookmark extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Bookmark_model');
        $this->load->library('session');
        $this->load->helper('url');

        // Redirect to login if user is not logged in
        if (!$this->session->userdata('user_id')) {
            redirect('user/login');
        }
    }

    // Display the list of bookmarks with pagination
    public function index($page = 0) {
        $user_id = $this->session->userdata('user_id'); // Get the logged-in user's ID
    
        $config = array();
        $config['base_url'] = site_url('bookmark/index');
        $config['total_rows'] = $this->Bookmark_model->get_total_bookmarks($user_id);
        $config['per_page'] = 10;
    
        $this->pagination->initialize($config);
    
        $data['bookmarks'] = $this->Bookmark_model->get_bookmarks($user_id, $config['per_page'], $page);
        $data['links'] = $this->pagination->create_links();
    
        $this->load->view('bookmarks/index', $data);
    }

    // Create a new bookmark
    public function create() {
        if ($this->input->method() === 'post') {
            $postData = json_decode(file_get_contents('php://input'), true);
    
            $user_id = $this->session->userdata('user_id');
            $title = $postData['title'];
            $url = $postData['url'];
            $tags = $postData['tags'];
    
            // Attempt to create the bookmark
            if ($this->Bookmark_model->create_bookmark($user_id, $title, $url, $tags)) {
                $response = ['status' => 'success', 'message' => 'Bookmark added successfully'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to add bookmark'];
            }
    
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Load the create bookmark view
            $this->load->view('bookmarks/create');
        }
    }

    // View and delete bookmarks
    public function delete_view($id = null) {
        $user_id = $this->session->userdata('user_id');
        $data['bookmarks'] = $this->Bookmark_model->get_all_user_bookmarks($user_id);
    
        // Check if an ID is provided for deletion
        if ($id !== null) {
            // Delete the bookmark and return JSON response
            if ($this->Bookmark_model->delete_bookmark($id, $user_id)) {
                $response = ['status' => 'success', 'message' => 'Bookmark deleted successfully'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to delete bookmark'];
            }
    
            header('Content-Type: application/json');
            echo json_encode($response);
            return; // Stop further execution to prevent loading the view
        }
    
        // Load the view with bookmarks list
        $this->load->view('bookmarks/delete_list', $data);
    }

    // View and edit bookmarks
    public function edit_view($id = null) {
        $user_id = $this->session->userdata('user_id');

        if ($id === null) {
            // No ID provided, load the list of bookmarks
            $data['bookmarks'] = $this->Bookmark_model->get_all_user_bookmarks($user_id);
            $this->load->view('bookmarks/edit_list', $data);
        } else {
            if ($this->input->method() === 'put' || $this->input->method() === 'post') {
                // Handle form submission for updating title, URL, and tags
                $input_data = json_decode(file_get_contents('php://input'), true);
                $title = $input_data['title'];
                $url = $input_data['url'];
                $tags = $input_data['tags'];

                // Update the bookmark
                $this->Bookmark_model->update_bookmark($id, $user_id, $title, $url, $tags);

                // Respond with JSON
                echo json_encode(['status' => 'success', 'message' => 'Bookmark updated successfully']);
                return;
            } else {
                // Load the edit form with the bookmark details
                $data['bookmark'] = $this->Bookmark_model->get_bookmark($id, $user_id);
                $this->load->view('bookmarks/edit', $data);
            }
        }
    }

    // Search bookmarks by tags
    public function search() {
        if ($this->input->is_ajax_request() || $this->input->method() === 'get') {
            // Handle incoming search request
            $tags = $this->input->get('tags'); // Use get() to retrieve query string parameters
    
            if (!empty($tags)) {
                // Process tags (split by comma)
                $tagsArray = explode(',', $tags);
    
                // Get logged-in user ID
                $user_id = $this->session->userdata('user_id');
    
                // Fetch bookmarks based on tagsArray and user ID
                $data['results'] = $this->Bookmark_model->search_bookmarks($tagsArray, $user_id);
    
                if ($this->input->is_ajax_request()) {
                    // Send JSON response for AJAX requests
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
                } else {
                    // Load the view with search results
                    $this->load->view('bookmarks/search', $data); 
                }
            } else {
                // Handle case where tags parameter is empty
                if ($this->input->is_ajax_request()) {
                    // Send JSON response for AJAX requests
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(['error' => 'No tags specified']));
                } else {
                    // Load the view with error message
                    $this->load->view('bookmarks/search', ['error' => 'No tags specified']); 
                }
            }
        } else {
            // Handle non-GET/POST requests
            show_error('Method not allowed', 405);
        }
    }
}
