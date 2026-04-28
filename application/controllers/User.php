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
            'phone'         => 'VARCHAR(20) NULL AFTER full_name',
            'address'       => 'TEXT NULL AFTER phone',
            'profile_image' => "VARCHAR(255) NULL DEFAULT 'default_user.png' AFTER address"
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
                // Hapus foto lama jika bukan default dan ada filenya
                $old_img = $user['profile_image'] ?? 'default_user.png';
                if ($old_img != 'default_user.png' && !empty($old_img)) {
                    $old_path = $config['upload_path'] . $old_img;
                    if (is_file($old_path) && file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
                
                $upload_data = $this->upload->data();
                $update_data['profile_image'] = $upload_data['file_name'];
                $this->session->set_userdata('profile_image', $upload_data['file_name']); // Update session
            }
 else {
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
