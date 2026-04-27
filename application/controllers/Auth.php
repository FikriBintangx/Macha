<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
            $this->load->view('auth/login');
        }
    }

    public function process() {
        $post = $this->input->post(null, TRUE);
        if (isset($post['username']) && isset($post['password'])) {
            $user = $this->db->where([
                'username' => trim($post['username']),
                'password' => trim($post['password']),
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
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah.');
                redirect('auth');
            }
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
        $this->load->view('auth/register');
    }

    public function do_register() {
        $post = $this->input->post(null, TRUE);
        $username  = trim($post['username']  ?? '');
        $full_name = trim($post['full_name'] ?? '');
        $password  = trim($post['password']  ?? '');
        $confirm   = trim($post['confirm']   ?? '');

        // Validasi
        if (empty($username) || empty($full_name) || empty($password)) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi!');
            redirect('auth/register');
            return;
        }
        if ($password !== $confirm) {
            $this->session->set_flashdata('error', 'Password dan konfirmasi tidak cocok!');
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
        $this->load->view('auth/forgot');
    }

    public function do_forgot() {
        $username = trim($this->input->post('username', TRUE));
        if (empty($username)) {
            $this->session->set_flashdata('error', 'Username wajib diisi!');
            redirect('auth/forgot'); return;
        }
        $user = $this->db->where('username', $username)->get('users')->row_array();
        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan.');
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

    // ─── LOGOUT ──────────────────────────────────────────
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    private function _redirect_by_role($role) {
        redirect($role == 'admin' ? 'dashboard' : 'home');
    }
}
