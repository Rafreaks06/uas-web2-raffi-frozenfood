<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_produk');
    }

    public function index()
    {
        $data['title'] = 'Daftar Produk';
        $data['produk'] = $this->M_produk->get_all();
        $this->render('admin/produk/index', $data);
    }

    public function create()
    {
        $this->load->model('M_supplier');
        $this->load->model('M_kategori');
        $data['title'] = 'Tambah Produk';
        $data['supplier'] = $this->M_supplier->get_all();
        $data['kategori'] = $this->M_kategori->get_all();

        $this->render('admin/produk/form', $data);
    }

    public function store()
    {
        
        $kategori_baru = $this->input->post('kategori_baru');
        $id_kategori = $this->input->post('id_kategori');

        if (!empty($kategori_baru)) {
            $this->db->insert('kategori', [
                'nama_kategori' => $kategori_baru,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $id_kategori = $this->db->insert_id();
        }

        
        $supplier_baru = $this->input->post('supplier_baru');
        $id_supplier = $this->input->post('id_supplier');

        if (!empty($supplier_baru)) {
            $this->db->insert('supplier', [
                'nama_supplier' => $supplier_baru,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $id_supplier = $this->db->insert_id();
        }

        
        $gambar = null;
        if (!empty($_FILES['gambar']['name'])) {
            $gambar = $this->_upload_image();
            
            
            if ($gambar === false) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/produk/create');
                return;
            }
        }

        
        $data = [
            'nama_produk' => $this->input->post('nama_produk'),
            'harga'       => $this->input->post('harga'),
            'stok'        => $this->input->post('stok'),
            'id_supplier' => $id_supplier,
            'id_kategori' => $id_kategori,
            'gambar'      => $gambar
        ];

        $this->M_produk->insert($data);
        $this->session->set_flashdata('success', 'Produk berhasil ditambahkan');
        redirect('admin/produk');
    }

    public function edit($id)
    {
        $this->load->model('M_supplier');
        $this->load->model('M_kategori');
        $data['title'] = 'Edit Produk';
        $data['row'] = $this->M_produk->get_by_id($id);
        $data['supplier'] = $this->M_supplier->get_all();
        $data['kategori'] = $this->M_kategori->get_all();

        $this->render('admin/produk/form', $data);
    }

    public function update($id)
    {
        $this->load->model('M_supplier');
        $this->load->model('M_kategori');

        
        $id_kategori = $this->input->post('id_kategori');
        $kategori_baru = $this->input->post('kategori_baru');

        if (!empty($kategori_baru)) {
            $this->db->insert('kategori', [
                'nama_kategori' => $kategori_baru,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
            $id_kategori = $this->db->insert_id();
        }

        
        $id_supplier = $this->input->post('id_supplier');
        $supplier_baru = $this->input->post('supplier_baru');

        if (!empty($supplier_baru)) {
            $this->db->insert('supplier', [
                'nama_supplier' => $supplier_baru,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
            $id_supplier = $this->db->insert_id();
        }

        
        $data = [
            'nama_produk' => $this->input->post('nama_produk'),
            'harga'       => $this->input->post('harga'),
            'stok'        => $this->input->post('stok'),
            'id_kategori' => $id_kategori,
            'id_supplier' => $id_supplier,
        ];

        
        if (!empty($_FILES['gambar']['name'])) {
            
            $gambar_baru = $this->_upload_image();
            
            if ($gambar_baru !== false) {
                
                $gambar_lama = $this->input->post('gambar_lama');
                if ($gambar_lama && file_exists('./assets/uploads/produk/' . $gambar_lama)) {
                    @unlink('./assets/uploads/produk/' . $gambar_lama);
                }
                
                $data['gambar'] = $gambar_baru;
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/produk/edit/' . $id);
                return;
            }
        }

        
        $this->M_produk->update($id, $data);
        $this->session->set_flashdata('success', 'Produk berhasil diupdate');
        redirect('admin/produk');
    }

    public function delete($id)
    {
        
        $produk = $this->M_produk->get_by_id($id);
        
        
        if ($produk && $produk->gambar) {
            $file_path = './assets/uploads/produk/' . $produk->gambar;
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
        }

        
        $this->M_produk->delete($id);
        $this->session->set_flashdata('success', 'Produk berhasil dihapus');
        redirect('admin/produk');
    }

    private function _upload_image()
    {
        
        $upload_path = './assets/uploads/produk/';
        
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        
        if (!is_writable($upload_path)) {
            log_message('error', 'Upload folder is not writable: ' . $upload_path);
            return false;
        }

        
        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size']      = 2048; 
        $config['encrypt_name']  = TRUE; 

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('gambar')) {
            $upload_data = $this->upload->data();
            log_message('info', 'Upload success: ' . $upload_data['file_name']);
            return $upload_data['file_name'];
        } else {
            $error = $this->upload->display_errors('', '');
            log_message('error', 'Upload failed: ' . $error);
            return false;
        }
    }
}