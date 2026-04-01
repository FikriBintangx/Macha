<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index() {
        // Pastikan kolom featured ada; jika belum, auto-migrasi
        $this->_ensure_featured_columns();

        // Featured products untuk scroll storytelling
        $this->db->select('products.*, categories.category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.stock >', 0);
        $this->db->where('products.is_featured', 1);
        $this->db->order_by('products.id', 'ASC');
        $featured = $this->db->get()->result_array();

        // Fallback: jika tidak ada yang difeatured, ambil 4 pertama
        if (empty($featured)) {
            $this->db->select('products.*, categories.category_name');
            $this->db->from('products');
            $this->db->join('categories', 'categories.id = products.category_id', 'left');
            $this->db->where('products.stock >', 0);
            $this->db->limit(4);
            $featured = $this->db->get()->result_array();
        }

        // Semua produk untuk section katalog preview
        $this->db->select('products.*, categories.category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.stock >', 0);
        $this->db->limit(6);
        $products = $this->db->get()->result_array();

        $this->load->model('M_settings');
        $story_1 = $this->M_settings->get_setting('story_img_1');
        $story_2 = $this->M_settings->get_setting('story_img_2');

        $data['story_img_1']       = !empty($story_1) ? base_url('uploads/' . $story_1) : 'https://images.unsplash.com/photo-1594911772125-07fc7a2d8d9f?w=600&auto=format&fit=crop&q=80';
        $data['story_img_2']       = !empty($story_2) ? base_url('uploads/' . $story_2) : 'https://images.unsplash.com/photo-1613143213508-251f4c7f0d06?w=600&auto=format&fit=crop&q=80';

        $data['featured_products'] = $featured;
        $data['products']          = $products;

        $this->load->view('guest/home', $data);
    }

    /**
     * Cek & tambah kolom featured jika belum ada (auto-migrasi)
     */
    private function _ensure_featured_columns() {
        $db_name = $this->db->database;
        $table   = 'products';

        // Cek apakah kolom is_featured sudah ada
        $check = $this->db->query(
            "SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = 'is_featured'",
            [$db_name, $table]
        )->row()->cnt;

        if ($check == 0) {
            // Jalankan migrasi otomatis
            $sqls = [
                "ALTER TABLE `{$table}` ADD COLUMN `is_featured` TINYINT(1) NOT NULL DEFAULT 0",
                "ALTER TABLE `{$table}` ADD COLUMN `highlight_label` VARCHAR(255) DEFAULT NULL",
                "ALTER TABLE `{$table}` ADD COLUMN `highlight_desc` TEXT DEFAULT NULL",
                "ALTER TABLE `{$table}` ADD COLUMN `feature_tag` VARCHAR(100) DEFAULT NULL",
            ];
            foreach ($sqls as $sql) {
                $this->db->query($sql);
            }
        }
    }

    public function tentang() {
        $this->load->model('M_settings');
        $data['shop_address'] = $this->M_settings->get_setting('shop_address');
        if (empty($data['shop_address'])) {
            $data['shop_address'] = "Citra Raya, Tangerang, Banten";
        }
        $this->load->view('guest/tentang', $data);
    }
}
