<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property M_settings $M_settings
 * @property CI_Upload $upload
 */
class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Hanya admin yang bisa mengatur setting
        if(!$this->session->userdata('username') || $this->session->userdata('role') == 'user') {
            redirect('auth');
        }
        $this->load->model('M_settings');
        $this->load->database();
    }

    public function index() {
        $data = [
            'title'          => 'Pusat Pengaturan & Master Data',
            'content'        => 'admin/settings',
            'shop_address'   => $this->M_settings->get_setting('shop_address'),
            'shop_logo'      => $this->M_settings->get_setting('shop_logo'),
            'story_img_1'    => $this->M_settings->get_setting('story_img_1'),
            'story_img_2'    => $this->M_settings->get_setting('story_img_2'),
            'categories'     => $this->M_settings->get_categories(),
            'order_types'    => $this->M_settings->get_order_types(),
            'payment_types'  => $this->M_settings->get_payment_methods()
        ];
        $this->load->view('layout/wrapper', $data);
    }

    public function crud($table) {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        
        if ($action == 'delete') {
            if (strpos($id, ',') !== false) {
                $ids = explode(',', $id);
                $this->db->where_in('id', $ids)->delete($table);
            } else {
                $this->db->where('id', $id)->delete($table);
            }
            $this->session->set_flashdata('success', 'Data berhasil dihapus!');
        } else {
            $data = [];
            if ($table == 'categories') {
                $data['category_name'] = $this->input->post('name');
            } elseif ($table == 'order_types' || $table == 'order_type') {
                $table = 'order_types'; // normalization
                $data['type_name'] = $this->input->post('name');
                $data['type_code'] = $this->input->post('code');
            } elseif ($table == 'payment_methods' || $table == 'payment_method') {
                $table = 'payment_methods'; // normalization
                $data['method_name'] = $this->input->post('name');
                $data['method_code'] = $this->input->post('code');
                $data['description'] = $this->input->post('desc');
            }
            
            $this->M_settings->crud($table, $data, $id);
            $this->session->set_flashdata('success', 'Data berhasil disimpan!');
        }

        // Redirect back to specific tab
        $tab = 'general';
        if($table == 'categories') $tab = 'categories';
        elseif($table == 'order_types') $tab = 'order-types';
        elseif($table == 'payment_methods') $tab = 'payment-methods';

        redirect('settings?tab=' . $tab);
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
