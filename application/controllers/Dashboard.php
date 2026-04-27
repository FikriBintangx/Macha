<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth');
        }
        if ($this->session->userdata('role') !== 'admin') {
            redirect('user');
        }
    }

    public function index() {
        $today = date('Y-m-d');
        $month = date('m');
        $year  = date('Y');

        // ─── Revenue Today ───
        $row = $this->db->query(
            "SELECT COALESCE(SUM(total_price), 0) AS total FROM sales WHERE DATE(created_at) = ? AND status != 'canceled'",
            [$today]
        )->row();
        $revenue_today = $row ? (float)$row->total : 0;

        // ─── Revenue This Month ───
        $row = $this->db->query(
            "SELECT COALESCE(SUM(total_price), 0) AS total FROM sales WHERE MONTH(created_at) = ? AND YEAR(created_at) = ? AND status != 'canceled'",
            [$month, $year]
        )->row();
        $revenue_month = $row ? (float)$row->total : 0;

        // ─── Orders Today ───
        $row = $this->db->query(
            "SELECT COUNT(*) AS total FROM sales WHERE DATE(created_at) = ?",
            [$today]
        )->row();
        $orders_today = $row ? (int)$row->total : 0;

        // ─── Orders Pending ───
        $row = $this->db->query(
            "SELECT COUNT(*) AS total FROM sales WHERE status = 'pending'"
        )->row();
        $orders_pending = $row ? (int)$row->total : 0;

        // ─── Total Products ───
        $total_products = $this->db->count_all('products');

        // ─── Recent 7 Days for Chart ───
        $recent_7_days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $cnt_row = $this->db->query(
                "SELECT COUNT(*) AS total FROM sales WHERE DATE(created_at) = ?",
                [$date]
            )->row();

            $rev_row = $this->db->query(
                "SELECT COALESCE(SUM(total_price), 0) AS total FROM sales WHERE DATE(created_at) = ? AND status != 'canceled'",
                [$date]
            )->row();

            $recent_7_days[] = [
                'label'     => date('d M', strtotime($date)),
                'full_date' => $date,
                'count'     => $cnt_row ? (int)$cnt_row->total : 0,
                'revenue'   => $rev_row ? (float)$rev_row->total : 0,
            ];
        }

        // ─── Low Stock Items (stock <= 5) ───
        $low_stock_items = $this->db
            ->where('stock <=', 5)
            ->order_by('stock', 'ASC')
            ->limit(10)
            ->get('products')
            ->result_array();

        // ─── NEW: Top Selling Products ───
        $top_products = $this->db->query(
            "SELECT p.name, p.image, p.sku, COALESCE(SUM(sd.qty), 0) as total_sold
             FROM products p
             LEFT JOIN sales_detail sd ON sd.product_id = p.id
             LEFT JOIN sales s ON sd.sales_id = s.id AND s.status != 'canceled'
             GROUP BY p.id
             ORDER BY total_sold DESC
             LIMIT 5"
        )->result_array();

        // ─── NEW: Recent Transactions ───
        $recent_transactions = $this->db->query(
            "SELECT invoice_no, customer_name, total_price, payment_method, status, created_at
             FROM sales
             ORDER BY created_at DESC
             LIMIT 5"
        )->result_array();

        $this->load->model('M_settings');
        $data = [
            'title'               => 'Dashboard Admin',
            'content'             => 'dashboard',
            'revenue_today'       => $revenue_today,
            'revenue_month'       => $revenue_month,
            'orders_today'        => $orders_today,
            'orders_pending'      => $orders_pending,
            'total_products'      => $total_products,
            'recent_7_days'       => $recent_7_days,
            'low_stock_items'     => $low_stock_items,
            'top_products'        => $top_products,
            'recent_transactions' => $recent_transactions,
            'is_open'             => $this->M_settings->is_shop_open(),
            'shop_status'         => $this->M_settings->get_setting('shop_status') ?: 'open'
        ];

        $this->load->view('layout/wrapper', $data);
    }

    public function toggle_shop_status() {
        $this->load->model('M_settings');
        $current = $this->M_settings->get_setting('shop_status');
        
        // Logic: If currently 'open' or 'auto', toggle to 'closed'. 
        // If 'closed', toggle to 'open'.
        $new_status = ($current == 'closed') ? 'open' : 'closed';
        
        $this->db->where('setting_key', 'shop_status');
        $this->db->update('settings', ['setting_value' => $new_status]);
        
        echo json_encode(['success' => true, 'new_status' => $new_status]);
    }
}
