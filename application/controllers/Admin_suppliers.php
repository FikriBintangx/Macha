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
        $this->_ensure_table_exists();
    }

    private function _ensure_table_exists() {
        if ($this->db->dbdriver === 'postgre') {
            return;
        }
        if (!$this->db->table_exists('suppliers')) {
            $this->load->dbforge();
            $fields = [
                'id'         => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'name'       => ['type' => 'VARCHAR', 'constraint' => '100'],
                'email'      => ['type' => 'VARCHAR', 'constraint' => '100'],
                'password'   => ['type' => 'VARCHAR', 'constraint' => '255'],
                'phone'      => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => TRUE],
                'address'    => ['type' => 'TEXT', 'null' => TRUE],
                'logo'       => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE],
                'status'     => ['type' => "ENUM('active','inactive')", 'default' => 'active'],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE]
            ];
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('suppliers');
        } else {
            if (!$this->db->field_exists('logo', 'suppliers')) {
                $this->load->dbforge();
                $this->dbforge->add_column('suppliers', [
                    'logo' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE]
                ]);
            }
        }
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
     * Manajemen Bahan Produk Supplier
     */
    public function products() {
        $this->load->model('Supplier_model');
        $products = $this->Supplier_model->get_all_products();

        $data = [
            'title' => 'Bahan Produk dari Supplier',
            'products' => $products,
            'content' => 'admin/supplier_products_list'
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

    /**
     * Manajemen Permintaan Supply
     */
    public function requests() {
        $this->load->model('Supplier_model');
        $requests = $this->Supplier_model->get_all_requests();
        $suppliers = $this->db->get_where('suppliers', ['status' => 'active'])->result_array();
        $products = $this->Supplier_model->get_all_products();

        $data = [
            'title' => 'Permintaan & Pengiriman Supply',
            'requests' => $requests,
            'suppliers' => $suppliers,
            'products' => $products,
            'content' => 'admin/supplier_requests_list'
        ];
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Kirim Request Supply Baru
     */
    public function create_supply_request() {
        $this->load->model('Supplier_model');
        
        $supplier_id = $this->input->post('supplier_id');
        $product_name = $this->input->post('product_name');
        $quantity = $this->input->post('quantity');
        $notes = $this->input->post('notes');
        $admin_id = $this->session->userdata('userid');

        $data = [
            'supplier_id' => $supplier_id,
            'requested_by_admin_id' => $admin_id,
            'product_name' => $product_name,
            'quantity' => $quantity,
            'notes' => $notes,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Supplier_model->create_request($data);
        $this->session->set_flashdata('success', 'Permintaan supply berhasil dikirim ke supplier!');
        redirect('admin_suppliers/requests');
    }

    /**
     * Konfirmasi Terima Pengiriman (Complete Request)
     */
    public function complete_supply_request($id) {
        $this->load->model('Supplier_model');
        
        // Update status di request
        $this->Supplier_model->update_request_status($id, 'completed');
        
        // Update status di shipment juga jika ada
        $this->db->where('request_id', $id)->update('supplier_shipments', ['status' => 'delivered']);

        $this->session->set_flashdata('success', 'Pasokan berhasil diterima! Status diperbarui menjadi Selesai.');
        redirect('admin_suppliers/requests');
    }

    /**
     * Batalkan Permintaan Supply (Jika masih pending)
     */
    public function cancel_supply_request($id) {
        $this->db->where('id', $id);
        $this->db->where('status', 'pending');
        $this->db->delete('supplier_requests');

        $this->session->set_flashdata('success', 'Permintaan supply berhasil dibatalkan.');
        redirect('admin_suppliers/requests');
    }
}
