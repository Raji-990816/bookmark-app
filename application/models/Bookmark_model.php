<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookmark_model extends CI_Model {
    
    public function __construct() {
        // Load the database library
        $this->load->database();
    }
    
    // Get the total number of bookmarks for a specific user
    public function get_total_bookmarks($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->from('bookmarks');
        return $this->db->count_all_results();
    }
    
    // Retrieve a limited number of bookmarks for a specific user
    public function get_bookmarks($user_id, $limit, $start) {
        $this->db->where('user_id', $user_id);
        $this->db->limit($limit, $start);
        $query = $this->db->get('bookmarks');
        return $query->result_array();
    }
    
    // Create a new bookmark for a user
    public function create_bookmark($user_id, $title, $url, $tags) {
        $data = array(
            'user_id' => $user_id,
            'title' => $title,
            'url' => $url,
            'tags' => $tags
        );
        return $this->db->insert('bookmarks', $data);
    }
    
    // Delete a specific bookmark for a user
    public function delete_bookmark($id, $user_id) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('bookmarks');
        return $this->db->affected_rows() > 0; // Return true if a row was affected (deleted)
    }
    
    // Retrieve all bookmarks for a specific user
    public function get_all_user_bookmarks($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('bookmarks');
        return $query->result_array();
    }
    
    // Get a specific bookmark for a user by bookmark ID
    public function get_bookmark($id, $user_id) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('bookmarks');
        return $query->row_array();
    }    

    // Update a specific bookmark for a user
    public function update_bookmark($id, $user_id, $title, $url, $tags) {
        $data = array(
            'title' => $title,
            'url' => $url,
            'tags' => $tags
        );
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->update('bookmarks', $data);
    }

    // Search bookmarks by tags for a specific user
    public function search_bookmarks($tagsArray, $user_id) {
        $this->db->select('*');
        $this->db->from('bookmarks');
        $this->db->where('user_id', $user_id); // Filter by user ID
    
        // Group conditions for tags
        $this->db->group_start();
        foreach ($tagsArray as $tag) {
            $this->db->or_like('tags', $tag);
        }
        $this->db->group_end();
    
        $query = $this->db->get();
        return $query->result_array();
    }
}
