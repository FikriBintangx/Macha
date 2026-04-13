<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_User_agent $agent
 * @property M_product $M_product
 * @property M_settings $M_settings
 * @property M_sales $M_sales
 */
class Shop extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_product');
        $this->load->model('M_settings');
        $this->load->library('user_agent', NULL, 'agent');
        $this->_ensure_product_columns();
    }

    public function index()
    {
        $data = [
            'title'          => 'Menu Macha',
            'products'       => $this->M_product->get_all(),
            'categories'     => $this->M_settings->get_categories(),
            'shop_logo'      => $this->M_settings->get_setting('shop_logo'),
            'shop_address'   => $this->M_settings->get_setting('shop_address'),
            'shop_status'    => $this->M_settings->get_setting('shop_status') ?: 'open',
            'whatsapp_number'=> $this->M_settings->get_setting('whatsapp_number')
        ];
        $this->load->view('guest/shop', $data);
    }

    public function cart()
    {
        if ($this->session->userdata('role') == 'admin') {
            redirect('dashboard');
            return;
        }
        $cart = $this->session->userdata('cart') ?: [];
        $total = 0;
        foreach($cart as &$item) {
            $item['subtotal'] = $item['price'] * $item['qty'];
            $total += $item['subtotal'];
        }
        
        $data = [
            'title'        => 'Keranjang Belanja',
            'cart'         => $cart,
            'total'        => $total,
            'products'     => $this->M_product->get_all(),
            'shop_logo'    => $this->M_settings->get_setting('shop_logo'),
            'shop_address' => $this->M_settings->get_setting('shop_address'),
            'shop_status'  => $this->M_settings->get_setting('shop_status') ?: 'open'
        ];
        $this->load->view('guest/cart', $data);
    }

    public function add_to_cart($product_id)
    {
        // Proteksi: Admin tidak boleh belanja
        if ($this->session->userdata('role') == 'admin') {
            $this->session->set_flashdata('error', 'Admin tidak diperbolehkan melakukan pemesanan.');
            redirect('shop');
            return;
        }

        $product = $this->M_product->get_by_id($product_id);

        if (!$product) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan.');
            redirect('shop');
        }

        $preferences = $this->input->post('preferences') ?: ''; 

        $cart = $this->session->userdata('cart') ?: [];
        $found = false;

        foreach ($cart as &$item) {
            if ($item['id'] == $product_id && ($item['preferences'] ?? '') == $preferences) {
                $item['qty']++;
                $item['subtotal'] = $item['price'] * $item['qty'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'id'          => $product['id'],
                'name'        => $product['name'],
                'price'       => $product['price'],
                'image'       => $product['image'],
                'qty'         => 1,
                'subtotal'    => $product['price'],
                'preferences' => $preferences
            ];
        }

        $this->session->set_userdata('cart', $cart);
        $this->session->set_flashdata('success', 'Berhasil ditambahkan ke keranjang!');
        redirect($this->agent->is_referral() ? $this->agent->referrer() : 'shop');
    }

    public function add_to_cart_ajax($product_id)
    {
        // Check shop status
        $status = $this->M_settings->get_setting('shop_status') ?: 'open';
        if ($status == 'closed') {
            echo json_encode(['status' => 'error', 'message' => 'Maaf, toko sedang tutup. Silakan cek kembali nanti!']);
            return;
        }

        if ($this->session->userdata('role') == 'admin') {
            echo json_encode(['status' => 'error', 'message' => 'Admin tidak diperbolehkan memesan.']);
            return;
        }

        $product = $this->M_product->get_by_id($product_id);
        if (!$product) {
            echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan.']);
            return;
        }

        if ($product['stock'] <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Maaf, stok habis!']);
            return;
        }

        $preferences = $this->input->post('preferences') ?: '';
        $cart = $this->session->userdata('cart') ?: [];
        $found = false;

        foreach ($cart as &$item) {
            if ($item['id'] == $product_id && ($item['preferences'] ?? '') == $preferences) {
                $item['qty']++;
                $item['subtotal'] = $item['price'] * $item['qty'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'id'          => $product['id'],
                'name'        => $product['name'],
                'price'       => $product['price'],
                'image'       => $product['image'],
                'qty'         => 1,
                'subtotal'    => $product['price'],
                'preferences' => $preferences
            ];
        }

        $this->session->set_userdata('cart', $cart);
        echo json_encode([
            'status' => 'success',
            'message' => 'Berhasil ditambahkan ke keranjang!',
            'cart_count' => count($cart)
        ]);
    }


    public function decrease_cart($index) {
        $cart = $this->session->userdata('cart') ?: [];
        if (isset($cart[$index])) {
            if ($cart[$index]['qty'] > 1) {
                $cart[$index]['qty']--;
                $cart[$index]['subtotal'] = $cart[$index]['price'] * $cart[$index]['qty'];
            } else {
                unset($cart[$index]);
            }
        }
        $this->session->set_userdata('cart', array_values($cart));
        redirect('shop/cart');
    }

    public function increase_cart($index) {
        $cart = $this->session->userdata('cart') ?: [];
        if (isset($cart[$index])) {
            $cart[$index]['qty']++;
            $cart[$index]['subtotal'] = $cart[$index]['price'] * $cart[$index]['qty'];
        }
        $this->session->set_userdata('cart', $cart);
        redirect('shop/cart');
    }

    public function remove_cart($index) {
        $cart = $this->session->userdata('cart') ?: [];
        if (isset($cart[$index])) {
            unset($cart[$index]);
        }
        $this->session->set_userdata('cart', array_values($cart));
        redirect('shop/cart');
    }

    public function remove_from_cart($id)
    {
        $cart = $this->session->userdata('cart') ?: [];
        // Since we can have same product with different prefs, removing by index or exact match
        // For simplicity here, removing by key index if passed as such, or first match
        foreach ($cart as $index => $item) {
            if ($item['id'] == $id) {
                unset($cart[$index]);
                break;
            }
        }
        $this->session->set_userdata('cart', array_values($cart));
        redirect('shop/cart');
    }

    public function update_cart()
    {
        $qtys = $this->input->post('qty');
        $cart = $this->session->userdata('cart') ?: [];

        if (!empty($qtys)) {
            foreach ($qtys as $index => $qty) {
                if (isset($cart[$index])) {
                    $cart[$index]['qty'] = max(1, (int) $qty);
                }
            }
        }

        $this->session->set_userdata('cart', $cart);
        redirect('shop/cart');
    }

    public function checkout()
    {
        if ($this->session->userdata('role') == 'admin') {
            redirect('dashboard');
            return;
        }
        $cart = $this->session->userdata('cart') ?: [];
        if (empty($cart)) {
            $this->session->set_flashdata('error', 'Keranjang Anda masih kosong.');
            redirect('shop');
        }

        $total = 0;
        foreach($cart as &$item) {
            $item['subtotal'] = $item['price'] * $item['qty'];
            $total += $item['subtotal'];
        }

        $data = [
            'title'           => 'Checkout Pesanan',
            'cart'            => $cart,
            'total'           => $total,
            'order_types'     => $this->M_settings->get_order_types(true),
            'payment_methods' => $this->M_settings->get_payment_methods(true),
            'shop_logo'       => $this->M_settings->get_setting('shop_logo'),
            'shop_address'    => $this->M_settings->get_setting('shop_address'),
            'qris_barcode'    => $this->M_settings->get_setting('qris_barcode')
        ];
        $this->load->view('guest/checkout', $data);
    }

    public function process_checkout()
    {
        $this->_ensure_sales_columns();
        $this->load->model('M_sales');

        $cart = $this->session->userdata('cart');
        if (empty($cart)) {
            redirect('shop');
        }

        $total_price = 0;
        foreach ($cart as $item) {
            $total_price += $item['price'] * $item['qty'];
        }

        $data_sales = [
            'invoice_no'      => 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
            'customer_name'   => $this->input->post('name'),
            'phone'           => $this->input->post('phone'),
            'address'         => $this->input->post('address'),
            'google_maps_link'=> $this->input->post('maps_link'),
            'notes'           => $this->input->post('notes'),
            'total_price'     => $total_price,
            'status'          => 'pending',
            'order_type'      => $this->input->post('order_type'),
            'payment_method'  => $this->input->post('payment_method'),
            'user_id'         => $this->session->userdata('userid') ?: 0,
            'created_at'      => date('Y-m-d H:i:s')
        ];

        $details = [];
        foreach ($cart as $item) {
            $details[] = [
                'product_id' => $item['id'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
                'subtotal'   => $item['price'] * $item['qty'],
                'item_notes' => $item['preferences'] ?? '' 
            ];
        }

        if ($this->M_sales->save_transaction($data_sales, $details)) {
            $last_id = $this->M_sales->last_sales_id();
            $this->session->set_userdata('cart', []);
            $this->session->set_flashdata('success', 'Pesanan Anda berhasil dikirim!');
            redirect('shop/invoice/' . $last_id);
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem.');
            redirect('shop/checkout');
        }
    }

    public function reorder($sales_id)
    {
        $this->load->model('M_sales');
        $this->load->model('M_product');
        
        $sales = $this->M_sales->get_sales_by_id($sales_id);
        if (!$sales) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('shop');
        }

        // Opsional: Cek jika pesanan milik user
        $user_id = $this->session->userdata('userid');
        if($sales['user_id'] != 0 && $sales['user_id'] != $user_id) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('shop');
        }

        $details = $this->M_sales->get_sales_detail($sales_id);
        $cart = $this->session->userdata('cart') ?: [];

        foreach($details as $d) {
            // Ambil info produk terbaru (takut harga atau stok berubah)
            $p = $this->M_product->get_by_id($d['product_id']);
            if($p && $p['stock'] > 0) {
                // Tambahkan ke keranjang
                $cart[] = [
                    'id'          => $p['id'],
                    'name'        => $p['name'],
                    'price'       => $p['price'],
                    'image'       => $p['image'],
                    'qty'         => $d['qty'],
                    'subtotal'    => $p['price'] * $d['qty'],
                    'preferences' => $d['item_notes'] ?? ''
                ];
            }
        }

        $this->session->set_userdata('cart', $cart);
        $this->session->set_flashdata('success', 'Menu pesanan lama telah dimasukkan kembali ke keranjang.');
        redirect('shop/cart');
    }

    public function invoice($id)
    {
        $this->load->model('M_sales');
        $this->load->model('M_settings');
        
        $sales = $this->M_sales->get_sales_by_id($id);
        if (!$sales) {
            redirect('shop');
        }

        $data = [
            'title'           => 'Invoice Pesanan #' . $sales['invoice_no'],
            'sales'           => $sales,
            'details'         => $this->M_sales->get_sales_detail($id),
            'shop_logo'       => $this->M_settings->get_setting('shop_logo'),
            'shop_address'    => $this->M_settings->get_setting('shop_address'),
            'payment_methods' => $this->M_settings->get_payment_methods(true)
        ];
        $this->load->view('guest/nota', $data);
    }

    public function update_item_preference()
    {
        $id = $this->input->post('id');
        $pref = $this->input->post('preference');
        $cart = $this->session->userdata('cart') ?: [];

        if (isset($cart[$id])) {
            $current_prefs = !empty($cart[$id]['preferences']) ? explode(', ', $cart[$id]['preferences']) : [];
            
            if (($key = array_search($pref, $current_prefs)) !== false) {
                unset($current_prefs[$key]);
            } else {
                $current_prefs[] = $pref;
            }
            
            $cart[$id]['preferences'] = implode(', ', $current_prefs);
            $this->session->set_userdata('cart', $cart);
            
            echo json_encode([
                'status' => 'success',
                'preferences' => $cart[$id]['preferences']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Item not found']);
        }
    }

    public function get_product_details($id)
    {
        $this->load->model('M_product');
        $p = $this->M_product->get_by_id($id);
        if ($p) {
            $rating = $this->M_product->get_average_rating($id);
            $recent_ratings = $this->M_product->get_ratings($id, 5);
            
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'id'          => $p['id'],
                    'name'        => $p['name'],
                    'description' => $p['description'] ?: 'Tidak ada deskripsi.',
                    'price'       => number_format($p['price'], 0, ',', '.'),
                    'stock'       => $p['stock'],
                    'image'       => !empty($p['image']) ? base_url('uploads/'.$p['image']) : 'default',
                    'avg_rating'  => round($rating['average'] ?? 0, 1),
                    'total_rating'=> $rating['total'] ?? 0,
                    'is_featured' => $p['is_featured'],
                    'recent_reviews' => $recent_ratings
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan.']);
        }
    }

    public function submit_rating()
    {
        // Proteksi: Hanya yang login bisa kasih rating
        if (!$this->session->userdata('userid')) {
            echo json_encode(['status' => 'error', 'message' => 'Silakan login terlebih dahulu untuk memberikan penilaian.']);
            return;
        }

        $this->load->model('M_product');
        $product_id = $this->input->post('product_id');
        $user_name = $this->session->userdata('full_name');

        $data = [
            'product_id' => $product_id,
            'full_name'  => $user_name,
            'rating'     => $this->input->post('rating'),
            'comment'    => $this->input->post('comment'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Cek apakah sudah pernah rating produk ini
        $this->db->where(['product_id' => $product_id, 'full_name' => $user_name]);
        $existing = $this->db->get('product_ratings')->row();

        if ($existing) {
            $this->db->where('id', $existing->id);
            $status = $this->db->update('product_ratings', $data);
            $msg = 'Penilaian Anda berhasil diperbarui!';
        } else {
            $status = $this->M_product->submit_rating($data);
            $msg = 'Terima kasih atas penilaian Anda!';
        }

        if ($status) {
            echo json_encode(['status' => 'success', 'message' => $msg]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim penilaian.']);
        }
    }

    private function _ensure_sales_columns()
    {
        $this->load->dbforge();
        if (!$this->db->table_exists('sales')) return;
        
        if (!$this->db->field_exists('order_type', 'sales')) {
            $this->dbforge->add_column('sales', [
                'order_type' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE],
                'payment_method' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE]
            ]);
        }
        if (!$this->db->field_exists('item_notes', 'sales_detail')) {
            $this->dbforge->add_column('sales_detail', [
                'item_notes' => ['type' => 'TEXT', 'null' => TRUE]
            ]);
        }
    }

    private function _ensure_product_columns()
    {
        $this->load->dbforge();
        if (!$this->db->field_exists('description', 'products')) {
            $this->dbforge->add_column('products', [
                'description' => ['type' => 'TEXT', 'null' => TRUE, 'after' => 'name']
            ]);
        }

        $query = "CREATE TABLE IF NOT EXISTS product_ratings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT,
            full_name VARCHAR(100),
            rating INT,
            comment TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->query($query);
    }
}
