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
        $this->load->database();
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
        if (!$this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk menambah ke keranjang.');
            redirect('auth');
            return;
        }

        // Proteksi: Admin tidak boleh belanja
        if ($this->session->userdata('role') == 'admin') {
            $this->session->set_flashdata('error', 'Admin tidak diperbolehkan melakukan pemesanan.');
            redirect('shop');
            return;
        }

        if (!$this->M_settings->is_shop_open()) {
            $reason = $this->M_settings->get_setting('shop_close_reason');
            $msg = $reason ? $reason : 'Maaf, toko sedang tutup. Silakan cek kembali nanti!';
            $this->session->set_flashdata('error', $msg);
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
        if (!$this->M_settings->is_shop_open()) {
            $reason = $this->M_settings->get_setting('shop_close_reason');
            $msg = $reason ? $reason : 'Maaf, toko sedang tutup. Silakan cek kembali nanti!';
            echo json_encode(['status' => 'error', 'message' => $msg]);
            return;
        }

        if (!$this->session->userdata('userid')) {
            echo json_encode(['status' => 'redirect', 'url' => site_url('auth')]);
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

    public function search_ajax()
    {
        $query = $this->input->get('q', TRUE);
        if (empty($query)) {
            echo json_encode([]);
            return;
        }

        $this->db->select('id, name, price, image');
        $this->db->from('products');
        $this->db->like('name', $query);
        $this->db->where('stock >', 0);
        $this->db->limit(5);
        $products = $this->db->get()->result_array();

        foreach ($products as &$p) {
            $p['price_formatted'] = 'Rp ' . number_format($p['price'], 0, ',', '.');
            $p['image_url'] = !empty($p['image']) ? base_url('uploads/' . $p['image']) : 'default';
        }

        echo json_encode($products);
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
        if (!$this->session->userdata('userid')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk melakukan pesanan.');
            redirect('auth');
            return;
        }

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

        // Get user data if logged in
        $user_id = $this->session->userdata('userid');
        $user = null;
        if ($user_id) {
            $user = $this->db->where('id', $user_id)->get('users')->row_array();
        }

        $data = [
            'title'           => 'Checkout Pesanan',
            'cart'            => $cart,
            'total'           => $total,
            'user'            => $user ?: [],
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
            'customer_name'   => $this->input->post('customer_name'),
            'phone'           => $this->input->post('phone'),
            'address'         => $this->input->post('address'),
            'google_maps_link'=> $this->input->post('google_maps_link'),
            'notes'           => $this->input->post('notes'),
            'total_price'     => (int) $total_price,
            'status'          => 'pending',
            'order_type'      => $this->input->post('order_type'),
            'payment_method'  => $this->input->post('payment_method'),
            'user_id'         => (int) ($this->session->userdata('userid') ?: 0),
            'created_at'      => date('Y-m-d H:i:s')
        ];

        $details = [];
        foreach ($cart as $item) {
            $details[] = [
                'product_id' => (int) $item['id'],
                'qty'        => (int) $item['qty'],
                'price'      => (int) $item['price'],
                'subtotal'   => (int) ($item['price'] * $item['qty']),
                'item_notes' => $item['preferences'] ?? '' 
            ];
        }

        if ($this->M_sales->save_transaction($data_sales, $details)) {
            $last_id = $this->M_sales->last_sales_id();
            $this->session->set_userdata('cart', []);
            $this->session->set_flashdata('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran.');
            redirect('shop/payment/' . $last_id);
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem.');
            redirect('shop/checkout');
        }
    }

    public function payment($sales_id) {
        $this->_ensure_sales_columns();
        $this->load->model('M_sales');
        $order = $this->db->where('id', $sales_id)->get('sales')->row_array();
        
        if(!$order) {
            redirect('shop');
        }

        // Check if Xendit is active and it's not a COD order
        $is_cod = (stripos($order['payment_method'], 'cod') !== false || stripos($order['payment_method'], 'tempat') !== false);
        if (!$is_cod && empty($order['xendit_invoice_url'])) {
            $xendit_invoice = $this->_create_xendit_invoice($order);
            if ($xendit_invoice && !empty($xendit_invoice['invoice_url'])) {
                $this->db->where('id', $sales_id)->update('sales', [
                    'xendit_invoice_id' => $xendit_invoice['id'],
                    'xendit_invoice_url' => $xendit_invoice['invoice_url']
                ]);
                $order['xendit_invoice_id'] = $xendit_invoice['id'];
                $order['xendit_invoice_url'] = $xendit_invoice['invoice_url'];
            }
        }

        // Auto-redirect to Xendit payment link if online payment and invoice URL exists
        if (!$is_cod && !empty($order['xendit_invoice_url'])) {
            redirect($order['xendit_invoice_url']);
            return;
        }
        
        $data['order'] = $order;
        // Cek admin phone dan setting
        $data['admin_phone'] = $this->M_settings->get_setting('admin_whatsapp');
        $data['shop_logo'] = $this->M_settings->get_setting('shop_logo');
        $data['qris_barcode'] = $this->M_settings->get_setting('qris_barcode');
        
        $this->load->view('guest/payment', $data);
    }

    public function payment_success($sales_id) {
        $order = $this->db->where('id', $sales_id)->get('sales')->row_array();
        if ($order) {
            $this->session->set_flashdata('success', 'Pembayaran Anda berhasil diproses! Terima kasih.');
        }
        redirect('shop/invoice/' . $sales_id);
    }

    private function _create_xendit_invoice($order) {
        $secret_key = getenv('XENDIT_SECRET_KEY') ?: $_ENV['XENDIT_SECRET_KEY'] ?? '';
        if (empty($secret_key)) {
            return null;
        }

        $url = 'https://api.xendit.co/v2/invoices';
        
        $payload = [
            'external_id' => $order['invoice_no'],
            'amount' => (int)$order['total_price'],
            'description' => 'Pembayaran Pesanan MariMatcha - ' . $order['invoice_no'],
            'customer' => [
                'given_names' => $order['customer_name'] ?: 'Customer MariMatcha',
                'mobile_number' => $order['phone'] ?: ''
            ],
            'success_redirect_url' => base_url('shop/payment_success/' . $order['id']),
            'failure_redirect_url' => base_url('shop/payment/' . $order['id'])
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($secret_key . ':')
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Fix for Vercel missing certificate authority bundle

        $response = curl_exec($ch);
        $curl_error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code >= 200 && $http_code < 300) {
            $result = json_decode($response, true);
            return $result;
        }
        
        log_message('error', 'Xendit Invoice Creation Failed: Code ' . $http_code . ' Error: ' . $curl_error . ' Response: ' . $response);
        return null;
    }

    public function upload_payment() {
        $sales_id = $this->input->post('sales_id');
        $bank_dest = $this->input->post('bank_dest');
        $nominal_input = $this->input->post('nominal');

        $order = $this->db->where('id', $sales_id)->get('sales')->row();
        if(!$order) {
            redirect('shop');
        }

        if(empty($bank_dest)) {
            $this->session->set_flashdata('error', 'Pilih bank tujuan transfer.');
            redirect('shop/payment/'.$sales_id);
        }

        $local_path = FCPATH . 'uploads/payments/';
        $is_writable = is_dir($local_path) && is_writable($local_path);
        if (!$is_writable) {
            $is_writable = @mkdir($local_path, 0777, true);
        }
        $config['upload_path']          = $is_writable ? $local_path : sys_get_temp_dir() . DIRECTORY_SEPARATOR;
        $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
        $config['max_size']             = 2048; // 2MB
        $config['file_name']            = 'PAY-'.$order->invoice_no.'-'.time();

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('payment_proof')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('shop/payment/'.$sales_id);
        } else {
            $data = $this->upload->data();
            $file_name = $data['file_name'];
            $this->load->library('supabase');
            $this->supabase->upload($config['upload_path'] . $file_name, $file_name, 'uploads/payments');

            $this->db->where('id', $sales_id);
            $this->db->update('sales', [
                'payment_proof' => $file_name,
                'status' => 'paid',
                'notes' => $order->notes . "\n[User Uploaded Proof: Bank " . $bank_dest . " | Nominal Rp " . number_format($nominal_input,0,',','.') . "]"
            ]);

            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diupload! Pesanan Anda segera diverifikasi admin.');
            redirect('shop/invoice/'.$sales_id);
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
            
            $user_rating = null;
            if ($this->session->userdata('userid')) {
                $user_name = $this->session->userdata('full_name');
                $this->db->where(['product_id' => $id, 'full_name' => $user_name]);
                $existing = $this->db->get('product_ratings')->row();
                if ($existing) {
                    $user_rating = [
                        'rating' => $existing->rating,
                        'comment' => $existing->comment
                    ];
                }
            }

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
                    'recent_reviews' => $recent_ratings,
                    'user_rating' => $user_rating
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
        if ($this->db->dbdriver === 'postgre') {
            return;
        }
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
        if (!$this->db->field_exists('xendit_invoice_id', 'sales')) {
            $this->dbforge->add_column('sales', [
                'xendit_invoice_id' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
                'xendit_invoice_url' => ['type' => 'TEXT', 'null' => TRUE]
            ]);
        }
    }

    private function _ensure_product_columns()
    {
        if ($this->db->dbdriver === 'postgre') {
            return;
        }
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
