<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->_ensure_tables_exist();
    }

    private function _ensure_tables_exist() {
        if ($this->db->dbdriver === 'postgre') {
            return;
        }
        $this->load->dbforge();

        if (!$this->db->table_exists('supplier_products')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'supplier_id' => ['type' => 'INT', 'constraint' => 11],
                'product_name' => ['type' => 'VARCHAR', 'constraint' => '100'],
                'category' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE],
                'description' => ['type' => 'TEXT', 'null' => TRUE],
                'price' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
                'stock' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
                'unit' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => TRUE],
                'image' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE],
                'status' => ['type' => "ENUM('active','inactive')", 'default' => 'active'],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('supplier_products');
        }

        if (!$this->db->table_exists('supplier_requests')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'supplier_id' => ['type' => 'INT', 'constraint' => 11],
                'requested_by_admin_id' => ['type' => 'INT', 'constraint' => 11],
                'product_name' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
                'quantity' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
                'notes' => ['type' => 'TEXT', 'null' => TRUE],
                'status' => ['type' => "ENUM('pending','approved','rejected','processing','shipped','completed')", 'default' => 'pending'],
                'rejection_reason' => ['type' => 'TEXT', 'null' => TRUE],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('supplier_requests');
        }

        // Migration: ensure 'rejection_reason' column exists in 'supplier_requests' table
        if ($this->db->table_exists('supplier_requests')) {
            if (!$this->db->field_exists('rejection_reason', 'supplier_requests')) {
                $this->dbforge->add_column('supplier_requests', [
                    'rejection_reason' => ['type' => 'TEXT', 'null' => TRUE]
                ]);
            }
        }

        if (!$this->db->table_exists('supplier_shipments')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'supplier_id' => ['type' => 'INT', 'constraint' => 11],
                'request_id' => ['type' => 'INT', 'constraint' => 11],
                'tracking_number' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
                'courier' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
                'shipping_proof' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE],
                'estimated_arrival' => ['type' => 'DATE', 'null' => TRUE],
                'notes' => ['type' => 'TEXT', 'null' => TRUE],
                'status' => ['type' => "ENUM('preparing','shipped','delivered')", 'default' => 'preparing'],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('supplier_shipments');
        }

        // Migration: ensure 'shipping_proof' column exists in 'supplier_shipments' table
        if ($this->db->table_exists('supplier_shipments')) {
            if (!$this->db->field_exists('shipping_proof', 'supplier_shipments')) {
                $this->dbforge->add_column('supplier_shipments', [
                    'shipping_proof' => [
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                        'null' => TRUE,
                        'after' => 'courier'
                    ]
                ]);
            }
            // Migration: ensure 'shipped_at' column exists
            if (!$this->db->field_exists('shipped_at', 'supplier_shipments')) {
                $this->dbforge->add_column('supplier_shipments', [
                    'shipped_at' => [
                        'type' => 'DATETIME',
                        'null' => TRUE,
                        'after' => 'shipping_proof'
                    ]
                ]);
            }
        }
    }
    // ─── SUPPLIER AUTH ──────────────────────────────────────────────
    public function get_supplier($email) {
        return $this->db->get_where('suppliers', ['email' => $email])->row_array();
    }

    public function get_supplier_by_id($id) {
        return $this->db->get_where('suppliers', ['id' => $id])->row_array();
    }

    public function get_all_suppliers() {
        return $this->db->where('status', 'active')->get('suppliers')->result_array();
    }

    // ─── SUPPLIER PRODUCTS ──────────────────────────────────────────
    public function get_products($supplier_id) {
        return $this->db->get_where('supplier_products', ['supplier_id' => $supplier_id])->result_array();
    }

    public function get_all_products() {
        $this->db->select('supplier_products.*, suppliers.name as supplier_name');
        $this->db->from('supplier_products');
        $this->db->join('suppliers', 'suppliers.id = supplier_products.supplier_id', 'left');
        $this->db->order_by('supplier_products.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_product($id, $supplier_id) {
        return $this->db->get_where('supplier_products', ['id' => $id, 'supplier_id' => $supplier_id])->row_array();
    }

    public function add_product($data) {
        $this->db->insert('supplier_products', $data);
        return $this->db->insert_id();
    }

    public function update_product($id, $supplier_id, $data) {
        $this->db->where('id', $id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->update('supplier_products', $data);
    }

    public function delete_product($id, $supplier_id) {
        $this->db->where('id', $id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->delete('supplier_products');
    }

    // ─── SUPPLIER REQUESTS ──────────────────────────────────────────
    public function get_requests($supplier_id) {
        // Fix: users table uses 'full_name' not 'name'
        $this->db->select('supplier_requests.*, users.full_name as admin_name');
        $this->db->from('supplier_requests');
        $this->db->join('users', 'users.id = supplier_requests.requested_by_admin_id', 'left');
        $this->db->where('supplier_requests.supplier_id', $supplier_id);
        $this->db->order_by('supplier_requests.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_requests() {
        $this->db->select('supplier_requests.*, suppliers.name as supplier_name, users.full_name as admin_name, supplier_shipments.tracking_number, supplier_shipments.courier, supplier_shipments.shipping_proof');
        $this->db->from('supplier_requests');
        $this->db->join('suppliers', 'suppliers.id = supplier_requests.supplier_id', 'left');
        $this->db->join('users', 'users.id = supplier_requests.requested_by_admin_id', 'left');
        $this->db->join('supplier_shipments', 'supplier_shipments.request_id = supplier_requests.id', 'left');
        $this->db->order_by('supplier_requests.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_request($id, $supplier_id = null) {
        if ($supplier_id) {
            return $this->db->get_where('supplier_requests', ['id' => $id, 'supplier_id' => $supplier_id])->row_array();
        }
        return $this->db->get_where('supplier_requests', ['id' => $id])->row_array();
    }

    public function create_request($data) {
        $this->db->insert('supplier_requests', $data);
        return $this->db->insert_id();
    }

    public function update_request_status($id, $status, $supplier_id = null) {
        $this->db->where('id', $id);
        if ($supplier_id) {
            $this->db->where('supplier_id', $supplier_id);
        }
        return $this->db->update('supplier_requests', ['status' => $status]);
    }

    public function reject_request($id, $supplier_id, $reason) {
        $this->db->where('id', $id);
        $this->db->where('supplier_id', $supplier_id);
        return $this->db->update('supplier_requests', [
            'status' => 'rejected',
            'rejection_reason' => $reason
        ]);
    }

    // ─── SUPPLIER SHIPMENTS ─────────────────────────────────────────
    public function add_shipment($data) {
        $this->db->insert('supplier_shipments', $data);
        return $this->db->insert_id();
    }

    public function get_shipments($supplier_id) {
        $this->db->select('supplier_shipments.*, supplier_requests.product_name, supplier_requests.quantity');
        $this->db->from('supplier_shipments');
        $this->db->join('supplier_requests', 'supplier_requests.id = supplier_shipments.request_id');
        $this->db->where('supplier_shipments.supplier_id', $supplier_id);
        $this->db->order_by('supplier_shipments.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_all_shipments() {
        $this->db->select('supplier_shipments.*, supplier_requests.product_name, supplier_requests.quantity, suppliers.name as supplier_name');
        $this->db->from('supplier_shipments');
        $this->db->join('supplier_requests', 'supplier_requests.id = supplier_shipments.request_id');
        $this->db->join('suppliers', 'suppliers.id = supplier_shipments.supplier_id', 'left');
        $this->db->order_by('supplier_shipments.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_shipment($id) {
        return $this->db->get_where('supplier_shipments', ['id' => $id])->row_array();
    }

    public function update_shipment($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('supplier_shipments', $data);
    }

    // ─── SUPPLIER PROFILE ───────────────────────────────────────────
    public function update_profile($supplier_id, $data) {
        $this->db->where('id', $supplier_id);
        return $this->db->update('suppliers', $data);
    }

    // ─── DASHBOARD STATS ────────────────────────────────────────────
    public function get_dashboard_stats($supplier_id) {
        $stats = [];
        $stats['total_products']   = $this->db->where('supplier_id', $supplier_id)->count_all_results('supplier_products');
        $stats['pending_requests'] = $this->db->where(['supplier_id' => $supplier_id, 'status' => 'pending'])->count_all_results('supplier_requests');
        $stats['approved_requests']= $this->db->where(['supplier_id' => $supplier_id, 'status' => 'approved'])->count_all_results('supplier_requests');
        $stats['total_shipments']  = $this->db->where('supplier_id', $supplier_id)->count_all_results('supplier_shipments');
        return $stats;
    }

    // ─── ADMIN STATS ────────────────────────────────────────────────
    public function get_admin_stats() {
        $stats = [];
        $stats['total_suppliers']  = $this->db->count_all('suppliers');
        $stats['pending_requests'] = $this->db->where('status', 'pending')->count_all_results('supplier_requests');
        $stats['shipped']          = $this->db->where('status', 'shipped')->count_all_results('supplier_requests');
        $stats['completed']        = $this->db->where('status', 'completed')->count_all_results('supplier_requests');
        return $stats;
    }

    // ─── ANALYTICS ──────────────────────────────────────────────────
    /** Count supplier_requests per month for the current year. Returns 12-element array (Jan=index 0). */
    public function get_monthly_requests($supplier_id) {
        $year = date('Y');
        $this->db->select('MONTH(created_at) as m, COUNT(*) as cnt');
        $this->db->from('supplier_requests');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('YEAR(created_at)', $year);
        $this->db->group_by('MONTH(created_at)');
        $rows = $this->db->get()->result_array();
        $result = array_fill(1, 12, 0);
        foreach ($rows as $r) { $result[(int)$r['m']] = (int)$r['cnt']; }
        return array_values($result);
    }

    /** Count supplier_shipments per month for the current year. Returns 12-element array (Jan=index 0). */
    public function get_monthly_shipments($supplier_id) {
        $year = date('Y');
        $this->db->select('MONTH(created_at) as m, COUNT(*) as cnt');
        $this->db->from('supplier_shipments');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('YEAR(created_at)', $year);
        $this->db->group_by('MONTH(created_at)');
        $rows = $this->db->get()->result_array();
        $result = array_fill(1, 12, 0);
        foreach ($rows as $r) { $result[(int)$r['m']] = (int)$r['cnt']; }
        return array_values($result);
    }
}
