<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

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
        $this->db->select('supplier_requests.*, suppliers.name as supplier_name, users.full_name as admin_name');
        $this->db->from('supplier_requests');
        $this->db->join('suppliers', 'suppliers.id = supplier_requests.supplier_id', 'left');
        $this->db->join('users', 'users.id = supplier_requests.requested_by_admin_id', 'left');
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
}
