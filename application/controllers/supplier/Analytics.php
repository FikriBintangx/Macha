<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Supplier_model $Supplier_model
 */
class Analytics extends CI_Controller {

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
        $data['title'] = 'Analytics';
        
        $data['monthly_requests'] = $this->Supplier_model->get_monthly_requests($supplier_id);
        $data['monthly_supply'] = $this->Supplier_model->get_monthly_shipments($supplier_id);
        
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/analytics/index', $data);
        $this->load->view('supplier/layout/footer');
    }
}

