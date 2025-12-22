<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in') ||
            $this->session->userdata('role') != 'user') 
        {
            redirect('auth');
        }

        $this->load->model('M_order_online');
        $this->load->model('M_produk');
    }

    public function index() {
        $data['title'] = 'Order Online';
        $data['produk'] = $this->M_produk->get_all();

        $this->load->view('user/template/header');
        $this->load->view('user/template/sidebar');
        $this->load->view('user/order_online', $data);
        $this->load->view('user/template/footer');
    }

    public function save() {

        
        $config['upload_path'] = './uploads/order/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti')) {
            $this->session->set_flashdata('error', 'Upload bukti gagal');
            redirect('user/order');
        }

        $file = $this->upload->data('file_name');

        
        $data = [
            'id_user' => $this->session->userdata('id_user'),
            'id_produk' => $this->input->post('produk'),
            'jumlah' => $this->input->post('jumlah'),
            'alamat' => $this->input->post('alamat'),
            'bukti' => $file,
            'status' => 'menunggu',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->M_order_online->insert($data);

        $this->session->set_flashdata('success', 'Order berhasil dikirim!');
        redirect('user/dashboard');
    }
}
