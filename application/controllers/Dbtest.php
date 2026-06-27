<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbtest extends CI_Controller {
    public function index() {
        header('Content-Type: application/json');
        try {
            $this->load->database();
            
            // 1. Ensure 'points' column exists in 'users'
            $fields = $this->db->list_fields('users');
            $has_points = in_array('points', $fields);
            
            $points_msg = "";
            if (!$has_points) {
                $this->db->query("ALTER TABLE users ADD COLUMN points INT DEFAULT 0 AFTER role");
                $points_msg = "Column 'points' added successfully.";
            } else {
                $points_msg = "Column 'points' already exists.";
            }

            // 2. Update QRIS Payment Method to Online Payment
            $this->db->where('id', 1);
            $this->db->update('payment_methods', [
                'method_name' => 'Online Payment',
                'description' => 'Bayar instan otomatis (QRIS, E-Wallet, Virtual Account)'
            ]);
            
            echo json_encode([
                'status' => 'success',
                'points_column' => $points_msg,
                'payment_methods_updated' => true,
                'message' => 'Database updates applied successfully!'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
