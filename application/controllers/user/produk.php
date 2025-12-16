<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Cek login user
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') != 'user') {
            redirect('auth');
        }

        // Load Model Produk
        $this->load->model('M_produk');
    }

    public function index()
    {
        $data['title'] = 'Katalog Produk';
        
        // Ambil semua data produk dari database
        $data['produk'] = $this->M_produk->get_all();

        // Load View
        $this->load->view('user/template/header', $data);
        $this->load->view('user/template/sidebar');
        $this->load->view('user/produk/index', $data); // Kita akan buat file ini di langkah 2
        $this->load->view('user/template/footer');
    }
}