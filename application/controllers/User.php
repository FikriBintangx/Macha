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
        if ($this->db->dbdriver === 'postgre') {
            return;
        }
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
        if ($this->db->dbdriver === 'postgre') {
            return;
        }
        $fields = $this->db->list_fields('users');
        $needed = [
            'phone'         => 'VARCHAR(20) NULL AFTER full_name',
            'address'       => 'TEXT NULL AFTER phone',
            'profile_image' => "MEDIUMTEXT NULL AFTER address"
        ];
        foreach ($needed as $col => $def) {
            if (!in_array($col, $fields)) {
                $this->db->query("ALTER TABLE users ADD $col $def");
            }
        }
        // Widen profile_image to MEDIUMTEXT so it can hold base64 data URIs up to 16MB
        $this->db->query("ALTER TABLE users MODIFY COLUMN profile_image MEDIUMTEXT NULL");
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


    // Tampilkan Profil
    public function profile() {
        redirect('user');
    }

    // Update Profil & Upload Foto
    public function update_profile() {
        $user_id = $this->session->userdata('userid');
        
        $full_name = $this->input->post('full_name');
        $phone     = $this->input->post('phone');
        $address   = $this->input->post('address');
        $password  = $this->input->post('password');

        $update_data = [
            'full_name' => $full_name,
            'phone'     => $phone,
            'address'   => $address
        ];

        // 1. Foto Profil — simpan sebagai base64 data URI langsung ke DB
        //    Tidak perlu menulis ke disk sama sekali, kompatibel dengan Vercel.
        if (!empty($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $mime = function_exists('mime_content_type') 
                ? mime_content_type($_FILES['image']['tmp_name']) 
                : (!empty($_FILES['image']['type']) ? $_FILES['image']['type'] : 'image/jpeg');

            if (!in_array($mime, $allowed_mime)) {
                $this->session->set_flashdata('error', 'Tipe file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                redirect('user');
                return;
            }

            $max_bytes = 2 * 1024 * 1024; // 2 MB
            if ($_FILES['image']['size'] > $max_bytes) {
                $this->session->set_flashdata('error', 'Ukuran foto maksimal 2 MB.');
                redirect('user');
                return;
            }

            $raw      = file_get_contents($_FILES['image']['tmp_name']);
            $b64      = base64_encode($raw);
            $data_uri = 'data:' . $mime . ';base64,' . $b64;

            $update_data['profile_image'] = $data_uri;
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

        $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || $this->input->is_ajax_request();
        if ($is_ajax) {
            echo json_encode([
                'status'        => $this->session->flashdata('success') ? 'success' : 'error',
                'message'       => $this->session->flashdata('success') ?: $this->session->flashdata('error'),
                'profile_image' => $update_data['profile_image'] ?? null,
                'full_name'     => $full_name
            ]);
            return;
        }

        redirect('user');
    }
}
