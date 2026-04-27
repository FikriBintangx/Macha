<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_product extends CI_Model {

    // Mengambil semua data produk dan menggabungkan dengan kategori
    public function get_all() {
        $this->db->select('products.*, categories.category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        return $this->db->get()->result_array();
    }

    // Mengambil semua data kategori untuk dropdown di form
    public function get_categories() {
        return $this->db->get('categories')->result_array();
    }

    // Menambah produk baru
    public function insert($data) {
        return $this->db->insert('products', $data);
    }

    // Mengambil satu data produk berdasarkan ID (untuk Edit)
    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('products')->row_array();
    }

    // Mengupdate data produk
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    // Menghapus produk
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('products');
    }

    // Mengambil rata-rata rating produk
    public function get_average_rating($id) {
        $this->db->select('AVG(rating) as average, COUNT(id) as total');
        $this->db->where('product_id', $id);
        return $this->db->get('product_ratings')->row_array();
    }

    // Mengambil list rating terbaru
    public function get_ratings($id, $limit = 5) {
        $this->db->where('product_id', $id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('product_ratings')->result_array();
    }

    // Simpan rating baru
    public function submit_rating($data) {
        return $this->db->insert('product_ratings', $data);
    }

    public function toggle_featured($id) {
        $product = $this->get_by_id($id);
        if(!$product) return false;
        
        $new_status = $product['is_featured'] ? 0 : 1;
        $this->db->where('id', $id);
        return $this->db->update('products', ['is_featured' => $new_status]);
    }
}

