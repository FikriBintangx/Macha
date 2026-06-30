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
            $config['upload_path'] = is_dir('/tmp') ? '/tmp/' : './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data['image'] = $uploadData['file_name'];
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
            $config['upload_path'] = is_dir('/tmp') ? '/tmp/' : './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data['image'] = $uploadData['file_name'];
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

    /** DataTables AJAX source */
    public function dt_json() {
        $supplier_id = $this->session->userdata('supplier_id');
        $products = $this->Supplier_model->get_products($supplier_id);
        $rows = [];
        foreach ($products as $p) {
            $img = !empty($p['image'])
                ? '<img src="'.base_url('uploads/'.$p['image']).'" style="width:40px;height:40px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">'
                : '<div style="width:40px;height:40px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:#94a3b8;"></i></div>';
            $stock_color = $p['stock'] < 10 ? '#d97706' : '#1B3B25';
            $status_html = $p['status'] == 'active'
                ? '<span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:999px;font-size:0.72rem;font-weight:700;">Available</span>'
                : '<span style="background:#fee2e2;color:#991b1b;padding:3px 10px;border-radius:999px;font-size:0.72rem;font-weight:700;">Out of Stock</span>';
            $actions = '<div style="display:flex;gap:6px;justify-content:flex-end;">'
                .'<a href="'.base_url('supplier/products/edit/'.$p['id']).'" style="width:32px;height:32px;border-radius:8px;background:#dbeafe;color:#1e40af;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;" title="Edit"><i class="fas fa-edit"></i></a>'
                .'<a href="'.base_url('supplier/products/delete/'.$p['id']).'" onclick="return confirm(\"Delete this product?\")" style="width:32px;height:32px;border-radius:8px;background:#fee2e2;color:#991b1b;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;" title="Delete"><i class="fas fa-trash"></i></a>'
                .'</div>';
            $rows[] = [
                $img,
                htmlspecialchars($p['product_name']),
                htmlspecialchars($p['category']),
                'Rp '.number_format($p['price'], 0, ',', '.'),
                '<span style="font-weight:700;color:'.$stock_color.';">'.$p['stock'].'</span>',
                $status_html,
                $actions,
            ];
        }
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(['data' => $rows]));
    }
}

