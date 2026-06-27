<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbtest extends CI_Controller {
    public function index() {
        header('Content-Type: application/json');
        try {
            $this->load->database();
            if ($this->db->initialize()) {
                $tables = $this->db->list_tables();
                
                // Check users table columns
                $columns = array();
                if (in_array('users', $tables)) {
                    $columns = $this->db->list_fields('users');
                }
                
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Connected successfully!',
                    'tables' => $tables,
                    'users_columns' => $columns
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Initialization failed.'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
