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
        $is_ajax = $this->input->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest'
                || strpos($this->uri->uri_string(), 'ajax') !== false;

        if (!$this->session->userdata('userid') || $role == 'user') {
            if ($is_ajax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Sesi habis, silakan login ulang.', 'redirect' => site_url('auth')]);
                exit;
            }
            redirect('auth');
        }
        $this->load->model('M_sales');
    }

    // Menampilkan daftar pesanan online (Monitoring Aktif)
    public function index() {
        $date_filter = $this->input->get('date');
        $target_date = $date_filter ?: date('Y-m-d');
        
        $this->db->select('sales.*, users.full_name as user_name');
        $this->db->from('sales');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        
        // Tampilkan semua pesanan, termasuk COD (Tunai) dari frontend
        
        // Filter Tanggal - Selalu terapkan tanggal target (default hari ini)
        $this->db->where('DATE(sales.created_at)', $target_date);
        
        $this->db->order_by('sales.status', 'ASC'); // Pending di atas
        $this->db->order_by('sales.created_at', 'DESC');
        $orders = $this->db->get()->result_array();

        $data = [
            'title'        => 'Kasir Online Monitoring',
            'orders'       => $orders,
            'date_filter'  => $target_date,
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
            // Get current order info for points awarding
            $order = $this->db->where('id', $id)->get('sales')->row();
            
            if ($status == 'completed' && $order->status != 'completed' && !empty($order->user_id)) {
                $points = floor($order->total_price / 10000);
                if ($points > 0) {
                    $this->db->set('points', 'points + ' . (int)$points, FALSE);
                    $this->db->where('id', $order->user_id);
                    $this->db->update('users');
                }
            }

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

    // Update Status Pesanan via AJAX
    public function ajax_update_status() {
        header('Content-Type: application/json');

        $id     = $this->input->post('id');
        $status = $this->input->post('status');

        $valid_status = ['pending', 'paid', 'shipped', 'completed', 'canceled'];
        if (!in_array($status, $valid_status)) {
            echo json_encode(['success' => false, 'message' => 'Status tidak valid.']);
            return;
        }

        try {
            // Get current order info for points awarding
            $order = $this->db->where('id', $id)->get('sales')->row();

            if (!$order) {
                echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan.']);
                return;
            }

            if ($status == 'completed' && $order->status != 'completed' && !empty($order->user_id)) {
                $points = floor($order->total_price / 10000);
                if ($points > 0) {
                    $this->db->set('points', 'points + ' . (int)$points, FALSE);
                    $this->db->where('id', $order->user_id);
                    $this->db->update('users');
                }
            }

            $this->db->where('id', $id);
            $this->db->update('sales', ['status' => $status]);

            echo json_encode([
                'success'    => true,
                'message'    => 'Status berhasil diperbarui menjadi: ' . strtoupper($status),
                'new_status' => $status
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    // Hapus pesanan (hanya pending/canceled yang boleh dihapus)
    public function delete($id) {
        $order = $this->db->where('id', $id)->get('sales')->row_array();
        
        if (!$order) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'order');
            return;
        }

        $deletable_status = ['pending', 'canceled'];
        if (!in_array($order['status'], $deletable_status)) {
            $this->session->set_flashdata('error', '⚠️ Pesanan dengan status "' . strtoupper($order['status']) . '" tidak dapat dihapus karena sudah menjadi transaksi resmi.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'order');
            return;
        }

        $details = $this->db->where('sales_id', $id)->get('sales_detail')->result_array();
        foreach ($details as $d) {
            $this->db->set('stock', 'stock + ' . (int)$d['qty'], FALSE);
            $this->db->where('id', $d['product_id']);
            $this->db->update('products');
        }

        $this->db->delete('sales_detail', ['sales_id' => $id]);
        $this->db->delete('sales', ['id' => $id]);
        
        if (!empty($order['payment_proof'])) {
            $proof_path = FCPATH . 'uploads/payments/' . $order['payment_proof'];
            if (file_exists($proof_path)) {
                unlink($proof_path);
            }
        }

        $this->session->set_flashdata('success', '✅ Pesanan #' . $order['invoice_no'] . ' berhasil dihapus.');
        
        if (isset($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('order');
        }
    }

    // Get order details via AJAX
    public function get_details($id) {
        $this->db->select('sales_detail.*, products.name as product_name');
        $this->db->from('sales_detail');
        $this->db->join('products', 'products.id = sales_detail.product_id');
        $this->db->where('sales_detail.sales_id', $id);
        $details = $this->db->get()->result_array();

        $this->db->where('id', $id);
        $order = $this->db->get('sales')->row_array();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'order'   => $order,
            'details' => $details
        ]);
    }
}
