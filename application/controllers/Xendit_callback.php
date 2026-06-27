<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xendit_callback extends CI_Controller {

    public function index()
    {
        // Only accept POST requests
        if ($this->input->method() !== 'post') {
            $this->output->set_status_header(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        // Optional callback token validation
        $configured_token = getenv('XENDIT_CALLBACK_TOKEN') ?: $_ENV['XENDIT_CALLBACK_TOKEN'] ?? '';
        if (!empty($configured_token)) {
            $headers = $this->input->request_headers();
            $incoming_token = $headers['x-callback-token'] ?? $headers['X-Callback-Token'] ?? '';
            if ($incoming_token !== $configured_token) {
                $this->output->set_status_header(401);
                echo json_encode(['status' => 'error', 'message' => 'Unauthorized callback token']);
                return;
            }
        }

        // Read POST body
        $raw_body = file_get_contents('php://input');
        $data = json_decode($raw_body, true);

        if (empty($data) || empty($data['external_id']) || empty($data['status'])) {
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid webhook payload']);
            return;
        }

        $invoice_no = $data['external_id'];
        $status = strtoupper($data['status']);

        // Find the order
        $order = $this->db->where('invoice_no', $invoice_no)->get('sales')->row_array();
        if (!$order) {
            $this->output->set_status_header(404);
            echo json_encode(['status' => 'error', 'message' => 'Order not found']);
            return;
        }

        if ($status === 'PAID' || $status === 'SETTLED') {
            $payment_channel = $data['payment_channel'] ?? $data['payment_method'] ?? 'Online';
            $paid_amount = $data['paid_amount'] ?? $data['amount'] ?? 0;
            
            $update_data = [
                'status' => 'paid',
                'notes' => $order['notes'] . "\n[System Auto-Verified via Xendit: " . $payment_channel . " | Nominal Rp " . number_format($paid_amount, 0, ',', '.') . "]"
            ];
            
            $this->db->where('id', $order['id'])->update('sales', $update_data);
            
            echo json_encode(['status' => 'success', 'message' => 'Order status updated to paid']);
            return;
        } elseif ($status === 'EXPIRED') {
            // Optional: Handle expired invoice
            $update_data = [
                'status' => 'expired',
                'notes' => $order['notes'] . "\n[Xendit Invoice Expired]"
            ];
            $this->db->where('id', $order['id'])->update('sales', $update_data);
            echo json_encode(['status' => 'success', 'message' => 'Order marked as expired']);
            return;
        }

        echo json_encode(['status' => 'success', 'message' => 'Webhook received but no action required']);
    }
}
