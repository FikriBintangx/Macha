<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 */
class Home extends CI_Controller {

    public function index() {
        // Pastikan tabel & kolom yang dibutuhkan ada (auto-migrasi)
        $this->_ensure_featured_columns();
        $this->_ensure_testimonials_table();

        // Ambil data testimonial dari database
        $this->db->where('is_visible', 1);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(6);
        $data['testimonials'] = $this->db->get('testimonials')->result_array();
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

    /**
     * Pastikan tabel testimonials ada
     */
    private function _ensure_testimonials_table() {
        $db_name = $this->db->database;
        $table   = 'testimonials';

        // Cek apakah tabel sudah ada
        $check = $this->db->query("SHOW TABLES LIKE '{$table}'")->num_rows();

        if ($check == 0) {
            $sql = "CREATE TABLE `{$table}` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `location` VARCHAR(100) DEFAULT NULL,
                `stars` INT DEFAULT 5,
                `quote` TEXT NOT NULL,
                `is_visible` TINYINT(1) DEFAULT 1,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $this->db->query($sql);

            // Dummy data awal
            $this->db->insert_batch($table, [
                [
                    'name' => 'Rina Kusuma',
                    'location' => 'Jakarta Selatan',
                    'stars' => 5,
                    'quote' => 'Matchanya enak banget! Seger, nggak terlalu manis. Udah langganan setiap minggu. Recommended banget buat matcha lovers!!'
                ],
                [
                    'name' => 'Dimas Prasetyo',
                    'location' => 'Bekasi',
                    'stars' => 5,
                    'quote' => 'Pelayanan ramah, pengiriman cepat. Packaging juga rapi dan tebal, jadi aman di jalan. Puas banget belanja di MariMacha!'
                ],
                [
                    'name' => 'Sari Dewi',
                    'location' => 'Tangerang',
                    'stars' => 5,
                    'quote' => 'Udah coba beberapa varian dan semuanya juara. Signature iced matcha jadi favorit di kantor sekarang. Makasih ya!'
                ]
            ]);
        }
    }

    /**
     * Simpan ulasan baru dari pemirsa
     */
    public function submit_review() {
        $name     = $this->input->post('name', TRUE);
        $location = $this->input->post('location', TRUE);
        $stars    = $this->input->post('stars', TRUE);
        $quote    = $this->input->post('quote', TRUE);

        if ($name && $quote) {
            $data = [
                'name'     => $name,
                'location' => $location,
                'stars'    => (int)$stars,
                'quote'    => $quote,
                'is_visible' => 1 // Langsung tampil, atau bisa set 0 untuk moderasi
            ];
            $this->db->insert('testimonials', $data);
            $this->session->set_flashdata('success', 'Terima kasih atas ulasannya! ❤️');
        } else {
            $this->session->set_flashdata('error', 'Mohon isi nama dan pesan ulasan Anda.');
        }

        redirect(base_url('#testi-kami'));
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
