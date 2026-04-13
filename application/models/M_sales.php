<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class M_sales extends CI_Model
{
    private $_last_id;

    /**
     * Simpan transaksi + detail + potong stok
     * Dilengkapi DB transaction rollback saat stok tidak cukup
     */
    public function save_transaction($data_sales, $details)
    {
        $this->db->trans_start();

        // 1. Simpan kepala transaksi
        $this->db->insert('sales', $data_sales);
        $this->_last_id = $this->db->insert_id();

        // 2. Detail & potong stok
        foreach ($details as $item) {
            $product = $this->db->get_where('products', ['id' => $item['product_id']])->row();

            if (!$product || $item['qty'] > $product->stock) {
                $this->db->trans_rollback();
                return FALSE;
            }

            $item['sales_id'] = $this->_last_id;
            $this->db->insert('sales_detail', $item);

            // Potong stok dengan pengaman ganda di WHERE
            $this->db->set('stock', 'stock - ' . (int) $item['qty'], FALSE);
            $this->db->where('id', $item['product_id']);
            $this->db->where('stock >=', (int) $item['qty']);
            $this->db->update('products');
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Kembalikan ID penjualan terakhir yang berhasil disimpan
     */
    public function last_sales_id()
    {
        return $this->_last_id ?? 0;
    }

    /**
     * Laporan semua penjualan (admin) dengan detail item
     */
    public function get_report($where = [])
    {
        $this->db->select("
            sales.*, 
            users.full_name,
            GROUP_CONCAT(CONCAT(sales_detail.qty, 'x ', products.name) SEPARATOR ', ') as item_details
        ");
        $this->db->from('sales');
        $this->db->join('users', 'users.id = sales.user_id', 'left');
        $this->db->join('sales_detail', 'sales_detail.sales_id = sales.id', 'left');
        $this->db->join('products', 'products.id = sales_detail.product_id', 'left');
        
        if(!empty($where)) {
            $this->db->where($where);
        }
        
        $this->db->group_by('sales.id');
        $this->db->order_by('sales.created_at', 'DESC');
        return $this->db->get()->result_array();
    }


    /**
     * Detail produk dari satu invoice (untuk nota)
     */
    public function get_sales_detail($sales_id)
    {
        $this->db->select('sales_detail.*, products.name as product_name');
        $this->db->from('sales_detail');
        $this->db->join('products', 'products.id = sales_detail.product_id');
        $this->db->where('sales_id', $sales_id);
        return $this->db->get()->result_array();
    }

    public function get_sales_by_id($id)
    {
        return $this->db->get_where('sales', ['id' => $id])->row_array();
    }
}
