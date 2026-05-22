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
        
        // Dummy data for analytics, can be expanded later
        $data['monthly_requests'] = [10, 20, 15, 25, 30, 40, 35, 45, 50, 60, 55, 70];
        $data['monthly_supply'] = [5, 10, 8, 12, 15, 20, 18, 22, 25, 30, 28, 35];
        
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/analytics/index', $data);
        $this->load->view('supplier/layout/footer');
    }
}

