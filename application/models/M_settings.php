<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_settings extends CI_Model {

    // Ambil setting berdasarkan key
    public function get_setting($key) {
        $this->db->where('setting_key', $key);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        return '';
    }

    // Update atau Insert setting
    public function update_setting($key, $value) {
        $this->db->where('setting_key', $key);
        $query = $this->db->get('settings');
        
        if ($query->num_rows() > 0) {
            // Update
            $this->db->where('setting_key', $key);
            return $this->db->update('settings', ['setting_value' => $value]);
        } else {
            // Insert
            return $this->db->insert('settings', ['setting_key' => $key, 'setting_value' => $value]);
        }
    }
}
