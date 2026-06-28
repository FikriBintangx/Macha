<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Input $input
 * @property Supplier_model $Supplier_model
 */
class Shipments extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload']);
        if (!$this->session->userdata('supplier_logged_in')) {
            redirect('auth');
        }
        $this->load->model('Supplier_model');
    }

    public function index() {
        $supplier_id = $this->session->userdata('supplier_id');
        $data['title'] = 'Shipments';
        $data['shipments'] = $this->Supplier_model->get_shipments($supplier_id);
        $data['approved_requests'] = array_filter($this->Supplier_model->get_requests($supplier_id), function($r) {
            return in_array($r['status'], ['approved', 'processing']);
        });
        
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/shipments/index', $data);
        $this->load->view('supplier/layout/footer');
    }

    public function create() {
        $supplier_id = $this->session->userdata('supplier_id');
        $request_id = $this->input->post('request_id');
        $tracking_number = $this->input->post('tracking_number');

        // Auto-generate jika kosong
        if (empty($tracking_number)) {
            $tracking_number = 'MMCH' . strtoupper(substr(uniqid(), -8));
        }
        
        $data = [
            'supplier_id' => $supplier_id,
            'request_id' => $request_id,
            'tracking_number' => $tracking_number,
            'shipped_at' => date('Y-m-d H:i:s'),
            'status' => 'shipped'
        ];

        if (!empty($_FILES['shipping_proof']['name'])) {
            $config['upload_path'] = is_dir('/tmp') ? '/tmp/' : './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('shipping_proof')) {
                $uploadData = $this->upload->data();
                $data['shipping_proof'] = $uploadData['file_name'];
                $this->load->library('supabase');
                $this->supabase->upload($config['upload_path'] . $data['shipping_proof'], $data['shipping_proof']);
            }
        }

        $this->Supplier_model->add_shipment($data);
        $this->Supplier_model->update_request_status($request_id, 'shipped', $supplier_id);
        $this->session->set_flashdata('success', 'Shipment berhasil dicatat! Nomor resi: <strong>' . $tracking_number . '</strong>');
        redirect('supplier/shipments');
    }

    /** DataTables AJAX source */
    public function dt_json() {
        $supplier_id = $this->session->userdata('supplier_id');
        $shipments = $this->Supplier_model->get_shipments($supplier_id);
        $rows = [];
        foreach ($shipments as $ship) {
            $status_html = $ship['status'] == 'shipped'
                ? '<span style="background:#ede9fe;color:#5b21b6;padding:3px 10px;border-radius:999px;font-size:0.72rem;font-weight:700;">Shipped</span>'
                : '<span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:999px;font-size:0.72rem;font-weight:700;">Delivered</span>';
            $proof = !empty($ship['shipping_proof'])
                ? '<a href="'.base_url('uploads/'.$ship['shipping_proof']).'" target="_blank" style="color:#8BAA7C;font-weight:600;font-size:0.8rem;text-decoration:none;"><i class="fas fa-external-link-alt"></i> View</a>'
                : '<span style="color:#94a3b8;font-size:0.8rem;">-</span>';
            $rows[] = [
                '<span style="font-family:monospace;font-weight:700;color:#1B3B25;">'.htmlspecialchars($ship['tracking_number']).'</span>',
                '#REQ-'.str_pad($ship['request_id'], 4, '0', STR_PAD_LEFT),
                date('d M Y', strtotime($ship['shipped_at'])),
                $status_html,
                $proof,
            ];
        }
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(['data' => $rows]));
    }
}

