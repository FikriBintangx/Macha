<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth');
        }
        if ($this->session->userdata('role') !== 'admin') {
            redirect('user'); // user biasa ke riwayat pesanan
        }
        $this->load->model('M_product');
    }

    public function index() {
        $total_produk   = $this->db->count_all('products');
        $total_kategori = $this->db->count_all('categories');

        // Stok menipis (≤5)
        $this->db->where('stock <=', 5);
        $low_stock = $this->db->count_all_results('products');

        // Produk terbaru (untuk tabel)
        $recent_products = [];
        if ($total_produk > 0) {
            $this->db->select('products.*, categories.category_name');
            $this->db->from('products');
            $this->db->join('categories', 'categories.id = products.category_id', 'left');
            $this->db->order_by('products.id', 'DESC');
            $this->db->limit(5);
            $recent_products = $this->db->get()->result_array();
        }

        $data = [
            'title'           => 'Dashboard Admin',
            'content'         => 'dashboard',
            'total_produk'    => $total_produk,
            'total_kategori'  => $total_kategori,
            'low_stock'       => $low_stock,
            'recent_products' => $recent_products,
        ];

        $this->load->view('layout/wrapper', $data);
    }
}
