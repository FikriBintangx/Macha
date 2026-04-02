<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_settings extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_tables();
    }

    // Ambil setting berdasarkan key
    public function get_setting($key) {
        $this->db->where('setting_key', $key);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        return '';
    }

    // Update atau Insert setting
    public function update_setting($key, $value) {
        $this->db->where('setting_key', $key);
        $query = $this->db->get('settings');
        
        if ($query->num_rows() > 0) {
            // Update
            $this->db->where('setting_key', $key);
            return $this->db->update('settings', ['setting_value' => $value]);
        } else {
            // Insert
            return $this->db->insert('settings', ['setting_key' => $key, 'setting_value' => $value]);
        }
    }

    public function ensure_tables() {
        $this->load->dbforge();

        // 1. Order Types
        if (!$this->db->table_exists('order_types')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'type_name' => ['type' => 'VARCHAR', 'constraint' => 50],
                'type_code' => ['type' => 'VARCHAR', 'constraint' => 20],
                'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('order_types');
            
            $this->db->insert_batch('order_types', [
                ['type_name' => 'Ambil Sendiri', 'type_code' => 'takeaway'],
                ['type_name' => 'Antar ke Rumah', 'type_code' => 'delivery']
            ]);
        }

        // 2. Payment Methods
        if (!$this->db->table_exists('payment_methods')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'method_name' => ['type' => 'VARCHAR', 'constraint' => 50],
                'method_code' => ['type' => 'VARCHAR', 'constraint' => 20],
                'description' => ['type' => 'TEXT', 'null' => TRUE],
                'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('payment_methods');

            $this->db->insert_batch('payment_methods', [
                ['method_name' => 'Transfer Bank / QRIS', 'method_code' => 'transfer', 'description' => 'BCA 1234567890 a/n MariMacha'],
                ['method_name' => 'Bayar di Tempat (COD)', 'method_code' => 'cod', 'description' => 'Bayar saat menerima pesanan']
            ]);
        } else {
            // Update table if description column missing
            if (!$this->db->field_exists('description', 'payment_methods')) {
                $this->dbforge->add_column('payment_methods', [
                    'description' => ['type' => 'TEXT', 'null' => TRUE, 'after' => 'method_code']
                ]);
            }
        }
    }

    public function get_categories() {
        return $this->db->get('categories')->result_array();
    }

    public function get_order_types($only_active = false) {
        if($only_active) $this->db->where('is_active', 1);
        return $this->db->get('order_types')->result_array();
    }

    public function get_payment_methods($only_active = false) {
        if($only_active) $this->db->where('is_active', 1);
        return $this->db->get('payment_methods')->result_array();
    }

    public function crud($table, $data, $id = null) {
        if($id) { $this->db->where('id', $id); return $this->db->update($table, $data); }
        return $this->db->insert($table, $data);
    }
}
