<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kategori');
    }

    public function index()
    {
        $data['title'] = 'Daftar Kategori';
        $data['kategori'] = $this->M_kategori->get_all();
        $this->render('admin/kategori/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Kategori';
        $this->render('admin/kategori/form', $data);
    }

    public function store()
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori')
        ];

        $this->M_kategori->insert($data);

        redirect('admin/kategori');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Kategori';
        $data['row'] = $this->M_kategori->get_by_id($id);

        $this->render('admin/kategori/form', $data);
    }

    public function update($id)
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori')
        ];

        $this->M_kategori->update($id, $data);

        redirect('admin/kategori');
    }

    public function delete($id)
    {
        $this->M_kategori->delete($id);
        redirect('admin/kategori');
    }
}
