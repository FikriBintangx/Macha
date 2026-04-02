<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 */
class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Hanya admin yang bisa akses laporan
        if (!$this->session->userdata('userid') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('M_sales');
    }

    // Laporan semua transaksi
    public function index() {
        $data = [
            'title'   => 'Laporan Penjualan Keseluruhan',
            'content' => 'reports/index.php', // Explicitly add .php just in case the server environment requires it
            'reports' => $this->M_sales->get_report()
        ];
        $this->load->view('layout/wrapper', $data);
    }

    // Laporan harian
    public function daily() {
        $today = date('Y-m-d');
        $this->db->where('DATE(created_at)', $today);
        $query = $this->db->get('sales');

        $data = [
            'title'   => 'Laporan Penjualan Hari Ini',
            'date'    => date('d M Y'),
            'content' => 'reports/daily_report',
            'reports' => $query->result_array()
        ];
        $this->load->view('layout/wrapper', $data);
    }

    // Cetak Struk per Invoice
    public function print_struk($invoice_no) {
        $this->db->select('sales.*, users.full_name as cashier');
        $this->db->from('sales');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        $this->db->where('invoice_no', $invoice_no);
        $sales = $this->db->get()->row_array();

        if (!$sales) {
            show_404();
        }

        if (empty($sales['cashier'])) {
            $sales['cashier'] = 'Admin (Automated)';
        }

        $data = [
            'title'   => 'Struk ' . $invoice_no,
            'sales'   => $sales,
            'details' => $this->M_sales->get_sales_detail($sales['id'])
        ];

        $this->load->view('reports/print_struk', $data);
    }
}
