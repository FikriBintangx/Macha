<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Hanya admin yang bisa mengatur setting
        if(!$this->session->userdata('username') || $this->session->userdata('role') == 'user') {
            redirect('auth');
        }
        $this->load->model('M_settings');
    }

    public function index() {
        $data = [
            'title'        => 'Pengaturan Website',
            'content'      => 'admin/settings',
            'shop_address' => $this->M_settings->get_setting('shop_address'),
            'shop_logo'    => $this->M_settings->get_setting('shop_logo'),
            'story_img_1'  => $this->M_settings->get_setting('story_img_1'),
            'story_img_2'  => $this->M_settings->get_setting('story_img_2')
        ];
        $this->load->view('layout/wrapper', $data);
    }

    public function update() {
        $address = $this->input->post('shop_address');
        if ($address) {
            $this->M_settings->update_setting('shop_address', $address);
        }

        // Setup upload configuration
        $config['upload_path']   = FCPATH . 'uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
        $config['max_size']      = 2048; // 2MB max
        
        $this->load->library('upload', $config);
        $errors = [];

        // Upload Story Img 1
        if (!empty($_FILES['story_img_1']['name'])) {
            $this->upload->initialize($config);
            if ($this->upload->do_upload('story_img_1')) {
                $upload_data = $this->upload->data();
                $this->M_settings->update_setting('story_img_1', $upload_data['file_name']);
            } else {
                $errors[] = 'Story 1: ' . $this->upload->display_errors('','');
            }
        }

        // Upload Story Img 2
        if (!empty($_FILES['story_img_2']['name'])) {
            $this->upload->initialize($config);
            if ($this->upload->do_upload('story_img_2')) {
                $upload_data = $this->upload->data();
                $this->M_settings->update_setting('story_img_2', $upload_data['file_name']);
            } else {
                $errors[] = 'Story 2: ' . $this->upload->display_errors('','');
            }
        }

        // Upload Logo Toko
        if (!empty($_FILES['shop_logo']['name'])) {
            $this->upload->initialize($config);
            if ($this->upload->do_upload('shop_logo')) {
                $upload_data = $this->upload->data();
                $this->M_settings->update_setting('shop_logo', $upload_data['file_name']);
            } else {
                $errors[] = 'Logo: ' . $this->upload->display_errors('','');
            }
        }

        if(!empty($errors)) {
            $this->session->set_flashdata('error', implode(' | ', $errors));
        } else {
            $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui!');
        }
        
        redirect('settings');
    }
}
