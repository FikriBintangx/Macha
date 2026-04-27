<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Hanya Admin/Owner yang bisa akses fitur ini
        if(!$this->session->userdata('userid') || $this->session->userdata('role') == 'user') {
            redirect('auth');
        }
        $this->load->database();
    }

    /**
     * Manajemen Admin & Staff
     */
    public function index() {
        $this->db->where_in('role', ['admin', 'owner', 'staff']);
        $users = $this->db->get('users')->result_array();

        $data = [
            'title' => 'Manajemen Admin & Staff',
            'users' => $users,
            'type'  => 'staff',
            'content' => 'admin/user_list'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Manajemen Data Pelanggan
     */
    public function customers() {
        $this->db->where('role', 'user');
        $users = $this->db->get('users')->result_array();

        $data = [
            'title' => 'Data Pelanggan Terdaftar',
            'users' => $users,
            'type'  => 'customer',
            'content' => 'admin/user_list'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Simpan / Update User
     */
    public function save() {
        $post = $this->input->post();
        $id = $post['id'] ?? null;

        $data = [
            'username'  => $post['username'],
            'full_name' => $post['full_name'],
            'phone'     => $post['phone'],
            'role'      => $post['role'],
            'address'   => $post['address']
        ];

        // Update password jika diisi
        if (!empty($post['password'])) {
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }

        if ($id) {
            // Edit
            $this->db->where('id', $id);
            $this->db->update('users', $data);
            $this->session->set_flashdata('success', 'User berhasil diperbarui!');
        } else {
            // Add - Cek username unik
            $exists = $this->db->where('username', $post['username'])->get('users')->num_rows();
            if ($exists > 0) {
                $this->session->set_flashdata('error', 'Username sudah digunakan!');
                redirect($post['redirect_url'] ?: 'admin_users');
                return;
            }
            $this->db->insert('users', $data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        }

        redirect($post['redirect_url'] ?: 'admin_users');
    }

    /**
     * Hapus User
     */
    public function delete($id) {
        // Jangan biarkan admin menghapus dirinya sendiri
        if ($id == $this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
            redirect('admin_users');
            return;
        }

        $this->db->where('id', $id);
        $this->db->delete('users');
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect($_SERVER['HTTP_REFERER'] ?: 'admin_users');
    }
}
