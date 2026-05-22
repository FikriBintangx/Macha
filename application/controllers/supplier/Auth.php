<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        // supplier/auth → redirect ke login utama
        redirect('auth');
    }

    public function logout() {
        $this->session->unset_userdata(['supplier_id', 'supplier_name', 'supplier_email', 'supplier_logged_in']);
        $this->session->set_flashdata('success', 'Berhasil logout dari akun Supplier.');
        redirect('auth');
    }
}
