<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Cek Login
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Profil Saya';
        $id_user = $this->session->userdata('id_user');
        
        // Ambil data user terbaru dari database
        $data['user'] = $this->db->get_where('user', ['id_user' => $id_user])->row();

        $this->load->view('user/template/header', $data);
        $this->load->view('user/template/sidebar');
        $this->load->view('user/profile', $data); // Kita buat view ini di langkah B
        $this->load->view('user/template/footer');
    }

    public function update()
    {
        $id_user = $this->session->userdata('id_user');

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'email'        => $this->input->post('email'),
            'no_hp'        => $this->input->post('no_hp'),
            'alamat'       => $this->input->post('alamat'),
        ];

        // Update password hanya jika diisi
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);

        // Update session nama jika berubah
        $this->session->set_userdata('nama_lengkap', $data['nama_lengkap']);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
        redirect('user/profile');
    }
}