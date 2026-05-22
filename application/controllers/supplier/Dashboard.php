<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Supplier_model $Supplier_model
 */
class Dashboard extends CI_Controller {

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
        $data['title'] = 'Supplier Dashboard';
        $data['stats'] = $this->Supplier_model->get_dashboard_stats($supplier_id);
        $data['recent_requests'] = array_slice($this->Supplier_model->get_requests($supplier_id), 0, 5);
        $data['products'] = $this->Supplier_model->get_products($supplier_id);
        
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/dashboard', $data);
        $this->load->view('supplier/layout/footer');
    }
}

