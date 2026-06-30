<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload']);
        if (!$this->session->userdata('supplier_logged_in')) {
            redirect('auth');
        }
        $this->load->model('Supplier_model');
    }

    public function index() {
        $supplier_email = $this->session->userdata('supplier_email');
        $data['title'] = 'Profile';
        $data['supplier'] = $this->Supplier_model->get_supplier($supplier_email);
        
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/profile/index', $data);
        $this->load->view('supplier/layout/footer');
    }

    public function update() {
        $supplier_id = $this->session->userdata('supplier_id');
        $data = [
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address')
        ];

        if (!empty($this->input->post('password'))) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path'] = is_dir('/tmp') ? '/tmp/' : './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo')) {
                $uploadData = $this->upload->data();
                $data['logo'] = $uploadData['file_name'];
            }
        }

        $this->Supplier_model->update_profile($supplier_id, $data);
        $this->session->set_userdata('supplier_name', $data['name']);
        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect('supplier/profile');
    }
}

