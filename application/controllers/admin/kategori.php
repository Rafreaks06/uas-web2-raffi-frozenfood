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
        // 1. Cek dulu, apakah ada produk yang pakai kategori ini?
        // Kita hitung jumlah produk yang punya id_kategori = $id
        $jumlah_produk = $this->db->get_where('produk', ['id_kategori' => $id])->num_rows();

        if ($jumlah_produk > 0) {
            // JIKA ADA: Beri pesan error dan jangan dihapus
            $this->session->set_flashdata('error', "Gagal hapus! Kategori ini masih digunakan oleh $jumlah_produk produk. Hapus atau pindahkan produknya terlebih dahulu.");
        } else {
            // JIKA KOSONG: Aman untuk dihapus
            $this->db->delete('kategori', ['id_kategori' => $id]);
            $this->session->set_flashdata('success', 'Data kategori berhasil dihapus.');
        }

        redirect('admin/kategori');
    }
}
