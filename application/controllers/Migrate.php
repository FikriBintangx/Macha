<?php
class Migrate extends CI_Controller {
    public function index() {
        $this->load->dbforge();

        // 1. Order Types Table
        if (!$this->db->table_exists('order_types')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'type_name' => ['type' => 'VARCHAR', 'constraint' => 50],
                'type_code' => ['type' => 'VARCHAR', 'constraint' => 20], // takeaway, delivery
                'description' => ['type' => 'TEXT', 'null' => TRUE],
                'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('order_types');
            
            // Initial data
            $this->db->insert_batch('order_types', [
                ['type_name' => 'Ambil Sendiri', 'type_code' => 'takeaway'],
                ['type_name' => 'Antar ke Rumah', 'type_code' => 'delivery']
            ]);
        }

        // 2. Payment Methods Table
        if (!$this->db->table_exists('payment_methods')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'method_name' => ['type' => 'VARCHAR', 'constraint' => 50],
                'method_code' => ['type' => 'VARCHAR', 'constraint' => 20], // transfer, cod
                'description' => ['type' => 'TEXT', 'null' => TRUE],
                'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('payment_methods');

            // Initial data
            $this->db->insert_batch('payment_methods', [
                ['method_name' => 'Transfer Bank / QRIS', 'method_code' => 'transfer'],
                ['method_name' => 'Bayar di Tempat (COD)', 'method_code' => 'cod']
            ]);
        }

        echo "Migration successful!";
    }
}
