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
        
        $data = [
            'supplier_id' => $supplier_id,
            'request_id' => $request_id,
            'tracking_number' => $this->input->post('tracking_number'),
            'shipped_at' => date('Y-m-d H:i:s'),
            'status' => 'shipped'
        ];

        if (!empty($_FILES['shipping_proof']['name'])) {
            $config['upload_path'] = './uploads/';
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
        $this->Supplier_model->update_request_status($request_id, $supplier_id, 'shipped');
        $this->session->set_flashdata('success', 'Shipment recorded successfully.');
        redirect('supplier/shipments');
    }
}

