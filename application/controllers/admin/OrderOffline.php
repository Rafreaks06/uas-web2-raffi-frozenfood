<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderOffline extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_produk');
        $this->load->model('M_customer');
        $this->load->model('M_order_offline');
        $this->load->model('M_order_offline_detail');
    }

    public function index()
    {
        $data['title'] = 'Order Offline';
        $data['order'] = $this->M_order_offline->get_all();
        $this->render('admin/order_offline/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Order Offline';
        $data['produk'] = $this->M_produk->get_all();
        $this->render('admin/order_offline/form', $data);
    }

    public function store()
    {
        $produk_ids = $this->input->post('produk'); // Array
        $qtys       = $this->input->post('qty');    // Array
        $subtotals  = $this->input->post('subtotal'); // Array

        // 1. Validasi Stok (Looping Cek Dulu)
        foreach ($produk_ids as $key => $id_produk) {
            $minta = $qtys[$key];
            
            // Ambil stok di DB
            $cek = $this->db->get_where('produk', ['id_produk' => $id_produk])->row();
            
            if ($minta > $cek->stok) {
                // Jika ada satu saja barang yang stoknya kurang, batalkan semua
                $this->session->set_flashdata('error_stok', "Stok '$cek->nama_produk' tidak cukup! Sisa: $cek->stok");
                redirect('admin/order-offline/create');
                return;
            }
        }

        // 2. Jika Lolos Validasi, Baru Simpan Transaksi
        
        // A. Insert Customer
        $customerData = [
            'nama_customer' => $this->input->post('nama_customer')
        ];
        $this->db->insert('customer', $customerData);
        $id_customer = $this->db->insert_id();

        // B. Insert Order Offline
        $orderData = [
            'id_customer' => $id_customer,
            'total'       => $this->input->post('total'),
            'status'      => 'Success',
            'created_at'  => date('Y-m-d H:i:s')
        ];
        $this->db->insert('order_offline', $orderData);
        $id_order = $this->db->insert_id();

        // C. Insert Detail & Kurangi Stok
        foreach ($produk_ids as $key => $id_produk) {
            $jumlah_beli = $qtys[$key];

            // Simpan Detail
            $detailData = [
                'id_order_offline' => $id_order,
                'id_produk'        => $id_produk,
                'qty'              => $jumlah_beli,
                'subtotal'         => $subtotals[$key]
            ];
            $this->db->insert('order_offline_detail', $detailData);

            // KURANGI STOK
            $this->db->set('stok', 'stok - ' . (int)$jumlah_beli, FALSE);
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk');
        }

        $this->session->set_flashdata('success', 'Transaksi berhasil disimpan!');
        redirect('admin/order-offline');
    }
        

    public function detail($id)
    {
        $this->load->model('M_order_offline');
        $this->load->model('M_order_offline_detail');

        $data['order']  = $this->M_order_offline->get_by_id($id);
        $data['detail'] = $this->M_order_offline_detail->get_detail($id);

        $data['title'] = "Detail Order Offline";

        $this->render('admin/order_offline/detail', $data);
    }
    public function cetak($id)
    {
        // 1. Ambil data order dan detailnya
        $data['order']  = $this->M_order_offline->get_by_id($id);
        $data['detail'] = $this->M_order_offline_detail->get_detail($id);
        
        // 2. Load view khusus cetak (tanpa sidebar/header admin)
        $this->load->view('admin/order_offline/cetak', $data);
    }


    public function delete($id)
    {
        $this->db->delete('order_offline_detail', ['id_order_offline' => $id]);
        $this->db->delete('order_offline', ['id_order_offline' => $id]);

        redirect('admin/order-offline');
    }
}
