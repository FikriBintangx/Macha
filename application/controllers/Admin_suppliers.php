<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Admin_suppliers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Hanya Admin/Owner yang bisa akses fitur ini
        if(!$this->session->userdata('userid') || $this->session->userdata('role') == 'user') {
            redirect('auth');
        }
        $this->load->database();
    }

    /**
     * Manajemen Data Supplier
     */
    public function index() {
        $suppliers = $this->db->get('suppliers')->result_array();

        $data = [
            'title' => 'Manajemen Supplier',
            'suppliers' => $suppliers,
            'content' => 'admin/supplier_list'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Simpan / Update Supplier
     */
    public function save() {
        $post = $this->input->post();
        $id = $post['id'] ?? null;

        $data = [
            'name'    => $post['name'],
            'email'   => $post['email'],
            'phone'   => $post['phone'],
            'address' => $post['address'],
            'status'  => $post['status'] ?? 'active'
        ];

        // Update password jika diisi (password required saat insert, opsional saat update)
        if (!empty($post['password'])) {
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }

        if ($id) {
            // Edit
            $this->db->where('id', $id);
            $this->db->update('suppliers', $data);
            $this->session->set_flashdata('success', 'Supplier berhasil diperbarui!');
        } else {
            // Add - Cek email unik
            $exists = $this->db->where('email', $post['email'])->get('suppliers')->num_rows();
            if ($exists > 0) {
                $this->session->set_flashdata('error', 'Email sudah terdaftar sebagai supplier!');
                redirect('admin_suppliers');
                return;
            }
            if (empty($post['password'])) {
                $this->session->set_flashdata('error', 'Password wajib diisi untuk supplier baru!');
                redirect('admin_suppliers');
                return;
            }
            $this->db->insert('suppliers', $data);
            $this->session->set_flashdata('success', 'Supplier berhasil ditambahkan!');
        }

        redirect('admin_suppliers');
    }

    /**
     * Hapus Supplier
     */
    public function delete($id) {
        // Cek jika supplier punya transaksi dll bisa ditambahkan di sini
        $this->db->where('id', $id);
        $this->db->delete('suppliers');
        $this->session->set_flashdata('success', 'Supplier berhasil dihapus!');
        redirect('admin_suppliers');
    }
}
