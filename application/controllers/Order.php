<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 */
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
        $date_filter = $this->input->get('date') ?: date('Y-m-d');
        
        $this->db->select('sales.*, users.full_name as user_name');
        $this->db->from('sales');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        $this->db->where_not_in('sales.payment_method', ['Cash', 'Debit']);
        $this->db->where('DATE(sales.created_at)', $date_filter);
        $this->db->order_by('sales.created_at', 'DESC');
        $orders = $this->db->get()->result_array();

        $data = [
            'title'        => 'Daftar Pesanan Online',
            'orders'       => $orders,
            'date_filter'  => $date_filter,
            'content'      => 'admin/order_list'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    // Menampilkan RIWAYAT pesanan online
    public function history() {
        $date_filter = $this->input->get('date');
        
        $this->db->select('sales.*, users.full_name as user_name');
        $this->db->from('sales');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        $this->db->where_not_in('sales.payment_method', ['Cash', 'Debit']);
        
        if($date_filter) {
            $this->db->where('DATE(sales.created_at)', $date_filter);
        }
        
        $this->db->order_by('sales.created_at', 'DESC');
        $orders = $this->db->get()->result_array();

        $data = [
            'title'       => 'Riwayat Order (Online)',
            'orders'      => $orders,
            'date_filter' => $date_filter,
            'content'     => 'admin/order_history'
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
        
        // Dynamic redirect back to the previous page (supports filters)
        if(isset($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('order');
        }
    }
}
