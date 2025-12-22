<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') != 'user') {
            redirect('auth');
        }

        
        $this->load->model('M_produk');
    }

    public function index()
    {
        $data['title'] = 'Katalog Produk';
        
        
        $data['produk'] = $this->M_produk->get_all();

        
        $this->load->view('user/template/header', $data);
        $this->load->view('user/template/sidebar');
        $this->load->view('user/produk/index', $data); 
        $this->load->view('user/template/footer');
    }
}