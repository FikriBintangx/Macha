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
}

