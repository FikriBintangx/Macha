<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Keepalive Controller
 * 
 * Hit oleh GitHub Actions setiap 5 menit untuk mencegah
 * database Aiven auto-suspend karena tidak ada aktivitas.
 * 
 * Cara kerja: UPDATE 1 row di tabel settings (key: 'last_ping')
 * dengan timestamp sekarang. Data ini tidak penting secara bisnis,
 * tapi cukup membuat koneksi DB tetap aktif.
 * 
 * Endpoint: GET /keepalive atau /ping
 */
class Keepalive extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        // Cek apakah row 'last_ping' sudah ada di settings
        $exists = $this->db
            ->where('setting_key', 'last_ping')
            ->count_all_results('settings');

        $now = date('Y-m-d H:i:s');

        if ($exists) {
            // UPDATE — bukan insert, bukan delete. Data tetap ada.
            $this->db->where('setting_key', 'last_ping');
            $this->db->update('settings', ['setting_value' => $now]);
        } else {
            // INSERT sekali saja (pertama kali)
            $this->db->insert('settings', [
                'setting_key'   => 'last_ping',
                'setting_value' => $now,
            ]);
        }

        // Response JSON sederhana
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'ok',
                'ping'   => $now,
            ]));
    }
}
