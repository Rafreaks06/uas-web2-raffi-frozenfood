<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller dasar untuk semua halaman yang butuh login
 * File ini harus di: application/core/MY_Controller.php
 */
class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Wajib login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /**
     * Renderer template admin/user
     */
    public function render($view, $data = [])
    {
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view($view, $data);
        $this->load->view('template/footer', $data);
    }
}

/**
 * Controller khusus Admin
 */
class Admin_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        // Cek apakah role adalah admin
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Halaman ini khusus admin.');
            redirect('auth/login');
        }
    }
}

/**
 * Controller khusus User
 */
class User_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        // Cek apakah role adalah user
        if ($this->session->userdata('role') !== 'user') {
            $this->session->set_flashdata('error', 'Akses ditolak! Halaman ini khusus user.');
            redirect('auth/login');
        }
    }
}