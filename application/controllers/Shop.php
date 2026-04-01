<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_product');
        $this->load->model('M_sales');
    }

    // Halaman toko – BEBAS, tidak perlu login
    public function index() {
        $data['products'] = $this->M_product->get_all();
        $this->load->view('guest/shop', $data);
    }

    // Tambah ke keranjang – WAJIB LOGIN
    public function add_to_cart($id) {
        if (!$this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Silakan login dulu untuk menambahkan ke keranjang.');
            // Simpan halaman tujuan agar setelah login kembali ke sini
            $this->session->set_userdata('redirect_after_login', base_url('shop/add_to_cart/'.$id));
            redirect('auth');
        }

        if ($this->session->userdata('role') === 'admin') {
            $this->session->set_flashdata('error', 'Ops! Akun Admin hanya diizinkan untuk melihat pratinjau toko (Preview) dan tidak bisa berbelanja.');
            redirect('shop');
        }

        $product = $this->M_product->get_by_id($id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan.');
            redirect('shop');
        }

        if ($product['stock'] < 1) {
            $this->session->set_flashdata('error', 'Maaf, stok produk ini habis.');
            redirect('shop');
        }

        $cart = $this->session->userdata('cart') ?? [];

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] < $product['stock']) {
                $cart[$id]['qty']     += 1;
                $cart[$id]['subtotal'] = $cart[$id]['qty'] * $product['price'];
            } else {
                $this->session->set_flashdata('error', 'Qty sudah mencapai batas stok tersedia.');
                redirect('shop/cart');
            }
        } else {
            $cart[$id] = [
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'qty'      => 1,
                'subtotal' => $product['price'],
                'image'    => $product['image'] ?? ''
            ];
        }

        $this->session->set_userdata('cart', $cart);
        $this->session->set_flashdata('success', htmlspecialchars($product['name']) . ' ditambahkan ke keranjang!');
        
        redirect('shop/cart');
    }

    // Kurangi qty 1 dari keranjang
    public function decrease_cart($id) {
        $cart = $this->session->userdata('cart') ?? [];
        if (isset($cart[$id])) {
            $cart[$id]['qty'] -= 1;
            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];
            }
        }
        $this->session->set_userdata('cart', $cart);
        redirect('shop/cart');
    }

    // Tampilkan keranjang – WAJIB LOGIN
    public function cart() {
        if (!$this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Silakan login dulu untuk melihat keranjang.');
            redirect('auth');
        }

        if ($this->session->userdata('role') === 'admin') {
            $this->session->set_flashdata('error', 'Akun admin tidak memiliki akses ke keranjang belanja.');
            redirect('shop');
        }

        $data['cart']  = $this->session->userdata('cart') ?? [];
        $data['total'] = 0;
        foreach ($data['cart'] as $item) {
            $data['total'] += $item['subtotal'];
        }
        
        // Ambil semua produk untuk ditampilkan langsung di bawah keranjang
        $data['products'] = $this->M_product->get_all();
        
        $this->load->view('guest/cart', $data);
    }

    // Hapus item dari keranjang
    public function remove_cart($id) {
        $cart = $this->session->userdata('cart') ?? [];
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $this->session->set_userdata('cart', $cart);
        redirect('shop/cart');
    }

    // Halaman checkout – harus login
    public function checkout() {
        if (!$this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk checkout.');
            redirect('auth');
        }

        if ($this->session->userdata('role') === 'admin') {
            $this->session->set_flashdata('error', 'Akun admin tidak memiliki akses untuk checkout belanja.');
            redirect('shop');
        }

        // AUTO-MIGRASI KOLOM SALES (ANTI-ERROR)
        $this->_ensure_sales_columns();

        $data['cart'] = $this->session->userdata('cart') ?? [];
        if (empty($data['cart'])) {
            redirect('shop');
        }

        $data['total'] = 0;
        foreach ($data['cart'] as $item) {
            $data['total'] += $item['subtotal'];
        }
        $user_id = $this->session->userdata('userid');
        $data['user'] = $this->db->get_where('users', ['id' => $user_id])->row_array();

        $this->load->view('guest/checkout', $data);
    }

    private function _ensure_sales_columns() {
        $fields = $this->db->list_fields('sales');
        $needed = [
            'phone'          => 'VARCHAR(20) AFTER customer_name',
            'address'        => 'TEXT AFTER phone',
            'google_maps_link' => 'TEXT AFTER address',
            'notes'          => 'TEXT AFTER google_maps_link',
            'payment_method' => 'VARCHAR(50) AFTER notes'
        ];
        foreach ($needed as $col => $def) {
            if (!in_array($col, $fields)) {
                $this->db->query("ALTER TABLE sales ADD $col $def");
            }
        }
    }

    // Proses checkout – simpan ke DB
    public function process_checkout() {
        $this->_ensure_sales_columns(); // Double check columns exist
        if (!$this->session->userdata('userid')) {
            redirect('auth');
        }

        // Ambil data form
        $cart = $this->session->userdata('cart') ?? [];
        if (empty($cart)) {
            redirect('shop');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        $user_id = $this->session->userdata('userid');
        $user_data = $this->db->get_where('users', ['id' => $user_id])->row_array();

        $payment_method    = $this->input->post('payment_method', TRUE) ?: 'Transfer';
        $customer_name     = $this->input->post('customer_name', TRUE) ?: ($user_data['full_name'] ?? $this->session->userdata('full_name'));
        $phone             = $this->input->post('phone', TRUE) ?: ($user_data['phone'] ?? '');
        $address           = $this->input->post('address', TRUE) ?: ($user_data['address'] ?? '');
        $google_maps_link  = $this->input->post('google_maps_link', TRUE) ?: '';
        $notes             = $this->input->post('notes', TRUE) ?: '';


        $invoice_no = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));

        $data_sales = [
            'invoice_no'     => $invoice_no,
            'total_price'    => $total,
            'customer_name'  => $customer_name,
            'phone'          => $phone,
            'address'        => $address,
            'google_maps_link' => $google_maps_link,
            'notes'          => $notes,
            'payment_method' => $payment_method,
            'status'         => 'pending',
            'created_at'     => date('Y-m-d H:i:s'),
            'user_id'        => $this->session->userdata('userid')
        ];

        $details = [];
        foreach ($cart as $item) {
            $details[] = [
                'product_id' => $item['id'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
                'subtotal'   => $item['subtotal']
            ];
        }

        $save = $this->M_sales->save_transaction($data_sales, $details);

        if ($save) {
            $sales_id = $this->M_sales->last_sales_id();
            $this->session->unset_userdata('cart');
            $this->session->set_flashdata('success', 'Pesanan berhasil! Segera lakukan pembayaran.');
            redirect('shop/invoice/' . $sales_id);
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses pesanan. Stok mungkin tidak mencukupi, coba lagi.');
            redirect('shop/cart');
        }
    }

    // Halaman nota / invoice
    public function invoice($sales_id) {
        if (!$this->session->userdata('userid')) {
            redirect('auth');
        }

        $user_id = $this->session->userdata('userid');
        $data['order'] = $this->db->get_where('sales', [
            'id'      => $sales_id,
            'user_id' => $user_id
        ])->row_array();

        if (!$data['order']) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('user');
        }

        $data['details'] = $this->M_sales->get_sales_detail($sales_id);
        $this->load->view('user/invoice', $data);
    }

    public function update_item_preference() {
        $id = $this->input->post('id');
        $pref = $this->input->post('preference');
        $cart = $this->session->userdata('cart') ?: [];

        if (isset($cart[$id])) {
            $current_prefs = isset($cart[$id]['preferences']) ? explode(', ', $cart[$id]['preferences']) : [];
            if (in_array($pref, $current_prefs)) {
                $current_prefs = array_diff($current_prefs, [$pref]);
            } else {
                $current_prefs[] = $pref;
            }
            $cart[$id]['preferences'] = implode(', ', array_filter($current_prefs));
            $this->session->set_userdata('cart', $cart);
            echo json_encode(['status' => 'success', 'preferences' => $cart[$id]['preferences']]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
