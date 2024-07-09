<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Controller {
    
    // Check the database connection
    public function check() {
        $this->load->database();

        if ($this->db->conn_id) {
            echo 'Database connection is successful.';
        } else {
            echo 'Database connection failed.';
        }
    }
}
