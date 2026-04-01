<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi: Hanya Admin / Owner
        $role = $this->session->userdata('role');
        if(!$this->session->userdata('userid') || $role == 'user') {
            redirect('auth');
        }
        $this->load->model('M_sales');
    }

    // Menampilkan daftar pesanan online (HARI INI)
    public function index() {
        $today = date('Y-m-d');
        
        $this->db->select('sales.*, users.full_name as user_name');
        $this->db->from('sales');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        $this->db->where_not_in('sales.payment_method', ['Cash', 'Debit']);
        $this->db->where('DATE(sales.created_at)', $today);
        $this->db->order_by('sales.created_at', 'DESC');
        $orders = $this->db->get()->result_array();

        $data = [
            'title'   => 'Pesanan Online Hari Ini',
            'orders'  => $orders,
            'content' => 'admin/order_list'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    // Menampilkan RIWAYAT pesanan online
    public function history() {
        $this->db->select('sales.*, users.full_name as user_name');
        $this->db->from('sales');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        $this->db->where_not_in('sales.payment_method', ['Cash', 'Debit']);
        $this->db->order_by('sales.created_at', 'DESC');
        $orders = $this->db->get()->result_array();

        $data = [
            'title'   => 'Riwayat Order (Online)',
            'orders'  => $orders,
            'content' => 'admin/order_history'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    // Update Status Pesanan
    public function update_status($id, $status) {
        $valid_status = ['pending', 'paid', 'shipped', 'completed', 'canceled'];
        if(in_array($status, $valid_status)) {
            $this->db->where('id', $id);
            $this->db->update('sales', ['status' => $status]);
            $this->session->set_flashdata('success', 'Status pesanan berhasil diperbarui menjadi: ' . strtoupper($status));
        }
        redirect('order');
    }
}
