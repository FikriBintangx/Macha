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
        return $this->db->get_where('products', ['id' => $id])->row_array();
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
}
