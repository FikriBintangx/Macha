<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Supplier_model $Supplier_model
 */
class Requests extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('supplier_logged_in')) {
            redirect('auth');
        }
        $this->load->model('Supplier_model');
    }

    public function index() {
        $supplier_id = $this->session->userdata('supplier_id');
        $data['title'] = 'Requests';
        $data['requests'] = $this->Supplier_model->get_requests($supplier_id);
        
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/requests/index', $data);
        $this->load->view('supplier/layout/footer');
    }

    public function update_status($id, $status) {
        $supplier_id = $this->session->userdata('supplier_id');
        $valid_statuses = ['approved', 'rejected', 'processing'];
        
        if (in_array($status, $valid_statuses)) {
            $this->Supplier_model->update_request_status($id, $supplier_id, $status);
            $this->session->set_flashdata('success', 'Request status updated.');
        } else {
            $this->session->set_flashdata('error', 'Invalid status.');
        }
        redirect('supplier/requests');
    }

    /** DataTables AJAX source */
    public function dt_json() {
        $supplier_id = $this->session->userdata('supplier_id');
        $requests = $this->Supplier_model->get_requests($supplier_id);
        $badge_map = [
            'pending'    => 'background:#fef9c3;color:#92400e;',
            'approved'   => 'background:#dcfce7;color:#166534;',
            'rejected'   => 'background:#fee2e2;color:#991b1b;',
            'processing' => 'background:#dbeafe;color:#1e40af;',
            'shipped'    => 'background:#ede9fe;color:#5b21b6;',
            'completed'  => 'background:#d1fae5;color:#065f46;',
        ];
        $rows = [];
        foreach ($requests as $req) {
            $style = isset($badge_map[$req['status']]) ? $badge_map[$req['status']] : 'background:#f1f5f9;color:#64748b;';
            $badge = '<span style="'.$style.'padding:3px 10px;border-radius:999px;font-size:0.72rem;font-weight:700;">'.ucfirst($req['status']).'</span>';
            if ($req['status'] == 'pending') {
                $actions = '<div style="display:flex;gap:6px;">'
                    .'<a href="'.base_url('supplier/requests/update_status/'.$req['id'].'/approved').'" onclick="return confirm(\"Approve?\")" style="background:#dcfce7;color:#166534;padding:4px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;text-decoration:none;">Approve</a>'
                    .'<a href="'.base_url('supplier/requests/update_status/'.$req['id'].'/rejected').'" onclick="return confirm(\"Reject?\")" style="background:#fee2e2;color:#991b1b;padding:4px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;text-decoration:none;">Reject</a>'
                    .'</div>';
            } elseif ($req['status'] == 'approved') {
                $actions = '<a href="'.base_url('supplier/requests/update_status/'.$req['id'].'/processing').'" style="background:#dbeafe;color:#1e40af;padding:4px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;text-decoration:none;">Start Processing</a>';
            } elseif ($req['status'] == 'processing') {
                $actions = '<a href="'.base_url('supplier/shipments').'" style="background:#ede9fe;color:#5b21b6;padding:4px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;text-decoration:none;">Create Shipment</a>';
            } else {
                $actions = '<span style="color:#94a3b8;font-size:0.8rem;">-</span>';
            }
            $rows[] = [
                '#REQ-'.str_pad($req['id'], 4, '0', STR_PAD_LEFT),
                htmlspecialchars($req['product_name']),
                $req['quantity'],
                !empty($req['note']) ? htmlspecialchars($req['note']) : '-',
                date('d M Y, H:i', strtotime($req['created_at'])),
                $badge,
                $actions,
            ];
        }
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(['data' => $rows]));
    }
}

