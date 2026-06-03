<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    // ─── LOGIN ───────────────────────────────────────────
    public function index() {
        if ($this->session->userdata('userid')) {
            $this->_redirect_by_role($this->session->userdata('role'));
        } else {
            $this->load->view('auth/login', ['form_type' => 'login']);
        }
    }

    public function process() {
        $post = $this->input->post(null, TRUE);
        if (isset($post['username']) && isset($post['password'])) {
            $username = trim($post['username']);
            $password = trim($post['password']);

            $user = $this->db->where([
                'username' => $username,
                'password' => $password,
            ])->get('users')->row_array();

            if ($user) {
                $this->session->set_userdata([
                    'userid'    => $user['id'],
                    'username'  => $user['username'],
                    'full_name' => $user['full_name'],
                    'role'      => $user['role'],
                ]);
                $this->session->set_flashdata('welcome_msg',
                    $user['role'] == 'admin' ? 'Selamat datang Admin!' : 'Selamat datang, '.$user['full_name'].'!');
                $this->_redirect_by_role($user['role']);
                return;
            }

            // Cek jika login sebagai Supplier (email atau name)
            $supplier = $this->db->where('email', $username)->or_where('name', $username)->get('suppliers')->row_array();
            if ($supplier && password_verify($password, $supplier['password'])) {
                if ($supplier['status'] == 'active') {
                    $session_data = [
                        'supplier_id' => $supplier['id'],
                        'supplier_name' => $supplier['name'],
                        'supplier_email' => $supplier['email'],
                        'supplier_logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);
                    redirect('supplier/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Akun supplier tidak aktif.');
                    redirect('auth');
                }
                return;
            }

            $this->session->set_flashdata('error', 'Username atau password salah.');
            redirect('auth');
        } else {
            redirect('auth');
        }
    }

    // ─── REGISTER ────────────────────────────────────────
    public function register() {
        if ($this->session->userdata('userid')) {
            $this->_redirect_by_role($this->session->userdata('role'));
            return;
        }
        $this->load->view('auth/login', ['form_type' => 'register']);
    }

    public function do_register() {
        $post = $this->input->post(null, TRUE);
        $username  = trim($post['username']  ?? '');
        $full_name = trim($post['full_name'] ?? '');
        $password  = trim($post['password']  ?? '');

        // Validasi
        if (empty($username) || empty($full_name) || empty($password)) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi!');
            redirect('auth/register');
            return;
        }
        if (strlen($password) < 6) {
            $this->session->set_flashdata('error', 'Password minimal 6 karakter!');
            redirect('auth/register');
            return;
        }

        // Cek username unik
        $exists = $this->db->where('username', $username)->get('users')->num_rows();
        if ($exists) {
            $this->session->set_flashdata('error', 'Username sudah digunakan, coba yang lain.');
            redirect('auth/register');
            return;
        }

        $this->db->insert('users', [
            'username'   => $username,
            'full_name'  => $full_name,
            'password'   => $password,
            'role'       => 'user',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->set_flashdata('success', 'Akun berhasil dibuat! Silakan login.');
        redirect('auth');
    }

    // ─── FORGOT PASSWORD ─────────────────────────────────
    public function forgot() {
        if ($this->session->userdata('userid')) { redirect('home'); return; }
        $this->load->view('auth/login', ['form_type' => 'forgot']);
    }

    public function do_forgot() {
        $identity = trim($this->input->post('identity', TRUE));
        if (empty($identity)) {
            $this->session->set_flashdata('error', 'Username atau Email wajib diisi!');
            redirect('auth/forgot'); return;
        }
        $user = $this->db->where('username', $identity)->or_where('email', $identity)->get('users')->row_array();
        if (!$user) {
            $this->session->set_flashdata('error', 'Akun tidak ditemukan.');
            redirect('auth/forgot'); return;
        }
        // Tampilkan form reset password
        $this->session->set_userdata('reset_uid', $user['id']);
        redirect('auth/reset');
    }

    public function reset() {
        if (!$this->session->userdata('reset_uid')) { redirect('auth/forgot'); return; }
        $this->load->view('auth/forgot', ['mode' => 'reset']);
    }

    public function do_reset() {
        $uid     = $this->session->userdata('reset_uid');
        $pass    = trim($this->input->post('password',  TRUE));
        $confirm = trim($this->input->post('confirm',   TRUE));
        if (!$uid) { redirect('auth/forgot'); return; }
        if (empty($pass) || $pass !== $confirm) {
            $this->session->set_flashdata('error', 'Password tidak cocok!');
            redirect('auth/reset'); return;
        }
        if (strlen($pass) < 6) {
            $this->session->set_flashdata('error', 'Password minimal 6 karakter!');
            redirect('auth/reset'); return;
        }
        $this->db->update('users', ['password' => $pass], ['id' => $uid]);
        $this->session->unset_userdata('reset_uid');
        $this->session->set_flashdata('success', 'Password berhasil diubah! Silakan login.');
        redirect('auth');
    }

    // ─── GOOGLE LOGIN (FIREBASE) ─────────────────────────
    public function google_login() {
        $email = $this->input->post('email', TRUE);
        $name = $this->input->post('display_name', TRUE);
        $uid = $this->input->post('uid', TRUE);
        $photo = $this->input->post('photo_url', TRUE);

        if (!$email || !$uid) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap dari Google']);
            return;
        }

        // Cek apakah user dengan email atau oauth_uid sudah ada
        $user = $this->db->where('email', $email)
                         ->or_where('oauth_uid', $uid)
                         ->get('users')
                         ->row_array();

        if (!$user) {
            // Jika belum ada, daftarkan otomatis
            $username = explode('@', $email)[0] . rand(100, 999);
            
            $data = [
                'username'       => $username,
                'email'          => $email,
                'password'       => password_hash($uid, PASSWORD_DEFAULT), // Dummy password
                'full_name'      => $name ?: 'Pengguna Google',
                'role'           => 'user',
                'oauth_provider' => 'google',
                'oauth_uid'      => $uid,
                'created_at'     => date('Y-m-d H:i:s'),
            ];
            
            if (!empty($photo)) {
                $data['profile_image'] = $photo;
            }

            $this->db->insert('users', $data);
            $user = $this->db->where('id', $this->db->insert_id())->get('users')->row_array();
        } else {
            // Update provider jika sebelumnya daftar manual tapi emailnya sama
            if (empty($user['oauth_uid'])) {
                $this->db->update('users', [
                    'oauth_provider' => 'google',
                    'oauth_uid'      => $uid
                ], ['id' => $user['id']]);
            }
        }

        // Set session
        $this->session->set_userdata([
            'userid'    => $user['id'],
            'username'  => $user['username'],
            'full_name' => $user['full_name'],
            'role'      => $user['role'],
        ]);
        
        $this->session->set_flashdata('welcome_msg', 'Selamat datang, '.$user['full_name'].'!');

        echo json_encode([
            'status' => 'success',
            'redirect' => base_url($user['role'] == 'admin' ? 'dashboard' : 'home')
        ]);
    }

    // ─── LOGOUT ──────────────────────────────────────────
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    private function _redirect_by_role($role) {
        redirect($role == 'admin' ? 'dashboard' : 'home');
    }
}
