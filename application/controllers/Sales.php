<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Proteksi: Jika belum login, tendang ke login
        if(!$this->session->userdata('userid') || $this->session->userdata('role') == 'user') {
            redirect('auth');
        }

        // SOLUSI ERROR: Load Helper URL agar site_url() dan base_url() bisa digunakan
        $this->load->helper('url');
        
        // Load model yang diperlukan
        $this->load->model(['M_product', 'M_sales']);
    }

    /**
     * Menampilkan halaman kasir
     */
    public function index() {
        // Generate nomor invoice unik
        $invoice = 'INV' . date('YmdHis');
        
        // AMBIL KODE UNIK (3 Angka Terakhir Invoice) untuk verifikasi QRIS
        $unique_code = substr($invoice, -3);

        $data = [
            'title'       => 'Kasir Macha UMKM',
            'products'    => $this->M_product->get_all(), 
            'invoice'     => $invoice,
            'unique_code' => $unique_code, 
            'content'     => 'sales/index'
        ];
        
        $this->load->view('layout/wrapper', $data);
    }

    /**
     * Memproses penyimpanan transaksi
     */
    public function process() {
        $post = $this->input->post();

        // 1. Data utama penjualan
        $data_sales = [
            'invoice_no'     => $post['invoice_no'],
            'total_price'    => $post['total_price'],
            'customer_name'  => $post['customer'],
            'payment_method' => $post['payment_method'],
            'user_id'        => $this->session->userdata('userid'),
            'created_at'     => date('Y-m-d H:i:s')
        ];

        // Simpan nomor kartu jika menggunakan Debit
        if ($post['payment_method'] == 'Debit' && !empty($post['card_number'])) {
            $data_sales['card_number'] = $post['card_number']; 
        }

        // 2. Data detail barang
        $details = [];
        if (!empty($post['product_id'])) {
            foreach ($post['product_id'] as $key => $val) {
                if(empty($val)) continue;

                $details[] = [
                    'product_id' => $val,
                    'qty'        => $post['qty'][$key],
                    'price'      => $post['price'][$key],
                    'subtotal'   => $post['subtotal'][$key]
                ];
            }
        }

        // Jalankan simpan ke database
        $save_status = $this->M_sales->save_transaction($data_sales, $details);

        if($save_status) {
            $this->session->set_flashdata('notif_struk', 'Transaksi Berhasil!');
            echo "<script>
                alert('TRANSAKSI BERHASIL DISIMPAN!'); 
                window.location='".site_url('report')."';
            </script>";
        } else {
            echo "<script>
                alert('GAGAL! Stok tidak mencukupi.'); 
                window.history.back();
            </script>";
        }
    }
}
