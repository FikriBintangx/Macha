<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbtest extends CI_Controller {
    public function index() {
        header('Content-Type: application/json');
        try {
            $this->load->database();
            
            // Check if column 'points' exists in 'users'
            $fields = $this->db->list_fields('users');
            $has_points = in_array('points', $fields);
            
            if (!$has_points) {
                // Add the missing column
                $this->db->query("ALTER TABLE users ADD COLUMN points INT DEFAULT 0 AFTER role");
                $fields = $this->db->list_fields('users');
                $message = "Column 'points' added successfully!";
            } else {
                $message = "Column 'points' already exists.";
            }

            echo json_encode([
                'status' => 'success',
                'message' => $message,
                'users_columns' => $fields
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
