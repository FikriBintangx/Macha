<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi Login: Hanya yang sudah login yang bisa akses
        if(!$this->session->userdata('userid')) {
            redirect('auth');
        }
        
        // Load Model & Library
        $this->load->model(['M_product']);
        $this->load->library(['upload', 'session']);
        $this->load->helper('url');
    }

    /**
     * Menampilkan daftar produk
     */
    public function index() {
        $data = [
            'title'    => 'Daftar Produk Macha',
            'products' => $this->M_product->get_all(),
            'content'  => 'products/list_product'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Membuka form tambah produk
     */
    public function add() {
        $categories = $this->db->get('categories')->result_array();

        $data = [
            'title'      => 'Tambah Produk Baru',
            'categories' => $categories,
            'content'    => 'products/add_product'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Memproses penyimpanan produk baru
     */
    public function save() { 
        $post   = $this->input->post();
        $price  = $post['price']; 
        $stock  = $post['stock']; 
        $preset = $post['image_preset']; 

        // 1. Proteksi angka negatif 
        if ($price < 0 || $stock < 0) { 
            $this->session->set_flashdata('error', 'Gagal! Harga atau Stok tidak boleh negatif.'); 
            redirect('product/add'); 
            return; 
        } 

        // 2. Logika Pemilihan Gambar
        $gambar = "default.jpg"; 

        if (!empty($preset)) { 
            $gambar = $preset; 
        } elseif (!empty($_FILES['image']['name'])) { 
            $config['upload_path']   = './uploads/'; 
            $config['allowed_types'] = 'jpg|jpeg|png|webp'; 
            $config['max_size']      = 2048; 
            $config['file_name']     = 'macha_' . time(); 

            $this->upload->initialize($config); 

            if ($this->upload->do_upload('image')) { 
                $gambar = $this->upload->data('file_name'); 
            } else { 
                $this->session->set_flashdata('error', $this->upload->display_errors()); 
                redirect('product/add'); 
                return; 
            } 
        } 

        $data = [ 
            'sku'         => $post['sku'],
            'category_id' => $post['category_id'],
            'name'        => $post['name'], 
            'description' => $post['description'] ?? '', 
            'price'       => $price, 
            'stock'       => $stock, 
            'image'       => $gambar 
        ]; 

        if($this->M_product->insert($data)) {
            $this->session->set_flashdata('success', 'Produk berhasil ditambahkan!'); 
            redirect('product'); 
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan ke database.'); 
            redirect('product/add');
        }
    }

    /**
     * Form edit produk
     * URL: /product/edit/ID
     */
    public function edit($id = null) {
        if (!$id) { redirect('product'); }

        $product = $this->M_product->get_by_id($id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan!');
            redirect('product');
        }

        $data = [
            'title'      => 'Edit Produk: ' . $product['name'],
            'product'    => $product,
            'categories' => $this->db->get('categories')->result_array(),
            'content'    => 'products/edit_product'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Proses update produk
     * URL: /product/update/ID (POST)
     */
    public function update($id = null) {
        if (!$id) { redirect('product'); }

        $post  = $this->input->post(null, TRUE);
        $price = (float)$post['price'];
        $stock = (int)$post['stock'];

        if ($price < 0 || $stock < 0) {
            $this->session->set_flashdata('error', 'Harga atau stok tidak boleh negatif!');
            redirect('product/edit/' . $id);
            return;
        }

        $data = [
            'category_id'     => $post['category_id'],
            'name'            => $post['name'],
            'description'     => $post['description'] ?? '',
            'price'           => $price,
            'stock'           => $stock,
            'is_featured'     => isset($post['is_featured']) ? 1 : 0,
            'highlight_label' => $post['highlight_label'] ?? '',
            'highlight_desc'  => $post['highlight_desc']  ?? '',
            'feature_tag'     => $post['feature_tag']     ?? '',
        ];

        // Ganti gambar jika ada upload baru
        if (!empty($_FILES['image']['name'])) {
            $config = [
                'upload_path'   => './uploads/',
                'allowed_types' => 'jpg|jpeg|png|webp',
                'max_size'      => 2048,
                'file_name'     => 'macha_' . time(),
            ];
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $data['image'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('product/edit/' . $id);
                return;
            }
        }

        if ($this->M_product->update($id, $data)) {
            $this->session->set_flashdata('success', 'Produk berhasil diperbarui!');
            redirect('product');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan perubahan.');
            redirect('product/edit/' . $id);
        }
    }

    /**
     * Hapus produk
     * URL: /product/delete/ID
     */
    public function delete($id = null) {
        if ($id == null) { redirect('product'); }

        // Cek apakah produk ini ada dalam riwayat transaksi (apapun statusnya)
        // Hal ini untuk menjaga integritas data laporan penjualan
        $this->db->where('product_id', $id);
        $has_history = $this->db->get('sales_detail')->num_rows();

        if ($has_history > 0) {
            $this->session->set_flashdata('error', '⚠️ Produk tidak bisa dihapus karena sudah memiliki riwayat transaksi. Menghapus produk ini akan merusak data laporan penjualan masa lalu.');
            redirect('product');
            return;
        }

        $product = $this->db->get_where('products', ['id' => $id])->row();
        if ($product) {
            $image_path = './uploads/' . $product->image;
            $is_preset  = preg_match('/^maca\d+\.jpg$/', $product->image);
            if (file_exists($image_path) && $product->image != 'default.jpg' && !$is_preset) {
                unlink($image_path);
            }
            $this->db->delete('products', ['id' => $id]);
            $this->session->set_flashdata('success', 'Produk berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
        }
        redirect('product');
    }
}
