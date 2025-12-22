<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->login();
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role');
            redirect($role == 'admin' ? 'admin/dashboard' : 'user/dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login_process() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username dan Password harus diisi');
            redirect('auth/login');
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->M_user->get_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan');
            redirect('auth/login');
            return;
        }

        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Password salah');
            redirect('auth/login');
            return;
        }

        $session_data = [
            'logged_in' => TRUE,
            'id_user'   => $user->id_user,
            'role'      => $user->role,
            'username'  => $user->username,
            'nama_lengkap' => isset($user->nama_lengkap) ? $user->nama_lengkap : $user->username
        ];
        
        $this->session->set_userdata($session_data);

        if ($user->role == 'admin') {
            redirect('admin/dashboard');
        } else {
            redirect('user/dashboard');
        }
    }

    public function register() {
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role');
            redirect($role == 'admin' ? 'admin/dashboard' : 'user/dashboard');
        }
        $this->load->view('auth/register');
    }

    public function register_process() {
        
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username ini sudah terpakai, pilih yang lain.'
        ]);

        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[user.email]', [
            'is_unique'   => 'Email ini sudah terdaftar.',
            'valid_email' => 'Format email tidak valid.'
        ]);

        
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
            'min_length' => 'Password minimal 6 karakter'
        ]);
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]', [
            'matches' => 'Konfirmasi password tidak cocok'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
            return;
        }

        
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'email'        => $this->input->post('email', TRUE), 
            'username'     => $this->input->post('username', TRUE),
            'password'     => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
            'role'         => 'user',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        if ($this->M_user->insert($data)) {
            $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', 'Gagal mendaftar, silakan coba lagi.');
            redirect('auth/register');
        }
    }

    

    

    public function forgot_password() {
        if ($this->session->userdata('logged_in')) {
            redirect('user/dashboard');
        }
        $this->load->view('auth/forgot_password');
    }

    public function forgot_password_process() {
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', form_error('email'));
            redirect('auth/forgot_password');
            return;
        }

        $email = $this->input->post('email', TRUE);
        
        
        $user = $this->M_user->get_by_email($email);

        if ($user) {
            
            
            
            $data['email'] = $user->email; 
            
            $this->session->set_flashdata('success', 'Email ditemukan. Silakan buat password baru.');
            $this->load->view('auth/reset_password_direct', $data); 
        } else {
            
            $this->session->set_flashdata('error', 'Email tidak terdaftar dalam sistem.');
            redirect('auth/forgot_password');
        }
    }

    public function reset_password_process() {
        
        $this->form_validation->set_rules('email', 'Email', 'required'); 
        $this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[6]', [
            'min_length' => 'Password minimal 6 karakter'
        ]);
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]', [
            'matches' => 'Konfirmasi password tidak cocok'
        ]);

        if ($this->form_validation->run() == FALSE) {
            
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/forgot_password'); 
            return;
        }

        $email = $this->input->post('email', TRUE);
        $new_password = $this->input->post('password', TRUE);

        
        $user = $this->M_user->get_by_email($email);

        if ($user) {
            
            $newPassHashed = password_hash($new_password, PASSWORD_DEFAULT);
            
            
            if ($this->M_user->update($user->id_user, ['password' => $newPassHashed])) {
                $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login dengan password baru.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Gagal mereset password (Error Database).');
                redirect('auth/forgot_password');
            }
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem (Email data hilang).');
            redirect('auth/forgot_password');
        }
    }
    public function logout()
{
    
    $this->session->sess_destroy();
    
    
    redirect('auth');
}
}