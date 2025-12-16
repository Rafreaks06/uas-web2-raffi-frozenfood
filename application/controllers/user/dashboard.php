<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // harus login dan role = user
        if (!$this->session->userdata('logged_in') ||
            $this->session->userdata('role') != 'user') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard User';
        $data['nama']  = $this->session->userdata('nama_lengkap');

        $this->load->view('user/template/header', $data);
        $this->load->view('user/template/sidebar');
        $this->load->view('user/template/topbar'); // TAMBAHKAN INI
        $this->load->view('user/dashboard', $data);
        $this->load->view('user/template/footer');
    }
}