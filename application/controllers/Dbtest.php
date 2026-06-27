<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbtest extends CI_Controller {
    public function index() {
        header('Content-Type: application/json');
        try {
            $this->load->database();
            
            $sales_fields = $this->db->list_fields('sales');
            $has_invoice_id = in_array('xendit_invoice_id', $sales_fields);
            $has_invoice_url = in_array('xendit_invoice_url', $sales_fields);
            
            $messages = [];
            
            if (!$has_invoice_id) {
                $this->db->query("ALTER TABLE sales ADD COLUMN xendit_invoice_id VARCHAR(255) DEFAULT NULL");
                $messages[] = "Added column xendit_invoice_id.";
            }
            if (!$has_invoice_url) {
                $this->db->query("ALTER TABLE sales ADD COLUMN xendit_invoice_url TEXT DEFAULT NULL");
                $messages[] = "Added column xendit_invoice_url.";
            }
            
            $updated_fields = $this->db->list_fields('sales');
            
            echo json_encode([
                'status' => 'success',
                'actions' => $messages,
                'sales_columns' => $updated_fields
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
