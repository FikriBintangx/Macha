<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload', 'form_validation']);
        if (!$this->session->userdata('supplier_logged_in')) {
            redirect('auth');
        }
        $this->load->model('Supplier_model');
    }

    public function index() {
        $supplier_id = $this->session->userdata('supplier_id');
        $data['title'] = 'My Products';
        $data['products'] = $this->Supplier_model->get_products($supplier_id);
        
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/products/index', $data);
        $this->load->view('supplier/layout/footer');
    }

    public function create() {
        $data['title'] = 'Add Product';
        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/products/create');
        $this->load->view('supplier/layout/footer');
    }

    public function store() {
        $supplier_id = $this->session->userdata('supplier_id');
        $data = [
            'supplier_id' => $supplier_id,
            'product_name' => $this->input->post('product_name'),
            'category' => $this->input->post('category'),
            'stock' => $this->input->post('stock'),
            'unit' => $this->input->post('unit'),
            'price' => $this->input->post('price'),
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status')
        ];

        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data['image'] = $uploadData['file_name'];
                $this->load->library('supabase');
                $this->supabase->upload($config['upload_path'] . $data['image'], $data['image']);
            }
        }

        $this->Supplier_model->add_product($data);
        $this->session->set_flashdata('success', 'Product added successfully.');
        redirect('supplier/products');
    }

    public function edit($id) {
        $supplier_id = $this->session->userdata('supplier_id');
        $data['title'] = 'Edit Product';
        $data['product'] = $this->Supplier_model->get_product($id, $supplier_id);
        
        if (!$data['product']) {
            redirect('supplier/products');
        }

        $this->load->view('supplier/layout/header', $data);
        $this->load->view('supplier/layout/sidebar');
        $this->load->view('supplier/products/edit', $data);
        $this->load->view('supplier/layout/footer');
    }

    public function update($id) {
        $supplier_id = $this->session->userdata('supplier_id');
        $data = [
            'product_name' => $this->input->post('product_name'),
            'category' => $this->input->post('category'),
            'stock' => $this->input->post('stock'),
            'unit' => $this->input->post('unit'),
            'price' => $this->input->post('price'),
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status')
        ];

        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data['image'] = $uploadData['file_name'];
                $this->load->library('supabase');
                $this->supabase->upload($config['upload_path'] . $data['image'], $data['image']);
            }
        }

        $this->Supplier_model->update_product($id, $supplier_id, $data);
        $this->session->set_flashdata('success', 'Product updated successfully.');
        redirect('supplier/products');
    }

    public function delete($id) {
        $supplier_id = $this->session->userdata('supplier_id');
        $this->Supplier_model->delete_product($id, $supplier_id);
        $this->session->set_flashdata('success', 'Product deleted successfully.');
        redirect('supplier/products');
    }
}

