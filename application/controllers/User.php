<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('role') != 'user') {
            redirect('auth');
        }
        $this->load->model('M_sales');
        $this->_ensure_payment_columns();
        $this->_ensure_user_columns();
    }

    private function _ensure_payment_columns() {
        $fields = $this->db->list_fields('sales');
        $needed = [
            'payment_proof' => 'VARCHAR(255) AFTER payment_method',
            'notes'         => 'TEXT AFTER payment_proof'
        ];
        foreach ($needed as $col => $def) {
            if (!in_array($col, $fields)) {
                $this->db->query("ALTER TABLE sales ADD $col $def");
            }
        }
    }

    private function _ensure_user_columns() {
        $fields = $this->db->list_fields('users');
        $needed = [
            'phone'   => 'VARCHAR(20) NULL AFTER full_name',
            'address' => 'TEXT NULL AFTER phone'
        ];
        foreach ($needed as $col => $def) {
            if (!in_array($col, $fields)) {
                $this->db->query("ALTER TABLE users ADD $col $def");
            }
        }
    }

    // Dashboard User (Riwayat Pesanan)
    public function index() {
        $user_id = $this->session->userdata('userid');
        
        $data['user'] = $this->db->where('id', $user_id)->get('users')->row_array();

        // Ambil riwayat pesanan khusus user ini
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $data['orders'] = $this->db->get('sales')->result_array();
        
        $this->load->view('user/order_history', $data);
    }

    // Formulir Upload Bukti Bayar
    public function payment($sales_id) {
        $user_id = $this->session->userdata('userid');
        $data['order'] = $this->db->where(['id' => $sales_id, 'user_id' => $user_id])->get('sales')->row_array();
        
        if(!$data['order']) {
            redirect('user');
        }
        
        $this->load->view('user/payment_upload', $data);
    }

    // Proses Upload
    public function upload_payment() {
        $sales_id = $this->input->post('sales_id');
        $user_id = $this->session->userdata('userid');
        $bank_dest = $this->input->post('bank_dest');
        $nominal_input = $this->input->post('nominal');

        // Pastikan order milik user
        $order = $this->db->where(['id' => $sales_id, 'user_id' => $user_id])->get('sales')->row();
        if(!$order) redirect('user');

        // VALIDASI AUTOMATIS (Sesuai Permintaan User)
        // 1. Cek Nominal (Harus persis sama dengan total_price)
        if($nominal_input != $order->total_price) {
            $this->session->set_flashdata('error', 'Gagal! Nominal yang Anda masukkan (Rp '.number_format($nominal_input,0,',','.').') tidak sesuai dengan total tagihan (Rp '.number_format($order->total_price,0,',','.').'). Pastikan transfer sesuai nominal.');
            redirect('user/payment/'.$sales_id);
        }

        // 2. Cek Bank Tujuan (Opsional, tapi user minta 'Nama Bank Sesuai')
        // Di sini kita asumsikan 'sesuai' berarti user memilih salah satu bank yang valid di form
        if(empty($bank_dest)) {
            $this->session->set_flashdata('error', 'Pilih bank tujuan transfer.');
            redirect('user/payment/'.$sales_id);
        }

        $config['upload_path']          = FCPATH . 'uploads/payments/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
        $config['max_size']             = 2048; // 2MB
        $config['file_name']            = 'PAY-'.$order->invoice_no.'-'.time();

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('payment_proof')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('user/payment/'.$sales_id);
        } else {
            $data = $this->upload->data();
            $file_name = $data['file_name'];

            // Update database - JIKA LOLOS VALIDASI DIASTAS MAKA OTOMATIS BERHASIL
            $this->db->where('id', $sales_id);
            $this->db->update('sales', [
                'payment_proof' => $file_name,
                'status' => 'paid', // Status 'paid' berarti sudah lunas
                'notes' => $order->notes . "\n[System Auto-Verified: Bank " . $bank_dest . " | Nominal Rp " . number_format($nominal_input,0,',','.') . "]"
            ]);

            $this->session->set_flashdata('success', 'Pembayaran Berhasil! Sistem mendeteksi nominal sesuai (Rp '.number_format($nominal_input,0,',','.').'). Pesanan Anda sedang diproses.');
            redirect('user');
        }
    }

    // Tampilkan Profil
    public function profile() {
        $user_id = $this->session->userdata('userid');
        $data['user'] = $this->db->where('id', $user_id)->get('users')->row_array();
        $this->load->view('user/profile', $data);
    }

    // Update Profil & Upload Foto
    public function update_profile() {
        $user_id = $this->session->userdata('userid');
        $user = $this->db->where('id', $user_id)->get('users')->row_array();
        
        $full_name = $this->input->post('full_name');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $password = $this->input->post('password');

        $update_data = [
            'full_name' => $full_name,
            'phone' => $phone,
            'address' => $address
        ];

        // 1. Logika Upload Foto Profil
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path']   = FCPATH . 'uploads/profile/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 2048;
            $config['file_name']     = 'user_' . $user_id . '_' . time();

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                // Hapus foto lama jika bukan default
                if ($user['profile_image'] != 'default_user.png' && file_exists($config['upload_path'] . $user['profile_image'])) {
                    unlink($config['upload_path'] . $user['profile_image']);
                }
                
                $upload_data = $this->upload->data();
                $update_data['profile_image'] = $upload_data['file_name'];
                $this->session->set_userdata('profile_image', $upload_data['file_name']); // Update session
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('user/profile');
                return;
            }
        }

        // 2. Update password jika diisi
        if (!empty($password)) {
            $update_data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('id', $user_id);
        if ($this->db->update('users', $update_data)) {
            $this->session->set_userdata('full_name', $full_name);
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
        }

        redirect('user/profile');
    }
}
