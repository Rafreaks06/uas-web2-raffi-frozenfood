<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderOnline extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_order_online');
    }

    public function index()
    {
        $data['title'] = 'Order Online';
        $data['orders'] = $this->M_order_online->get_all_admin();

        $this->render('admin/order_online/index', $data);
    }

    public function detail($id_order_online)
    {
        $data['title']  = 'Detail Order Online';
        $data['order']  = $this->M_order_online->get_by_id_admin($id_order_online);

        $this->load->model('M_order_online_detail');
        $data['detail'] = $this->M_order_online_detail->get_by_order($id_order_online);

        $this->render('admin/order_online/detail', $data);
    }
    
    public function verifikasi($id_order_online)
    {
        // This calls the function in the MODEL
        $this->M_order_online->update_status($id_order_online, 'Success'); 
        redirect('admin/order-online/detail/'.$id_order_online);
    }

    // --- REMOVED THE update_status FUNCTION FROM HERE ---

    public function tolak($id_order_online)
    {
        // 1. Ambil detail barang yang ada di order ini
        // Kita butuh 'id_produk' dan 'qty' untuk mengembalikan stok
        $details = $this->db->get_where('order_online_detail', ['id_order_online' => $id_order_online])->result();

        // 2. Loop setiap barang untuk kembalikan stok
        foreach ($details as $d) {
            // Query: UPDATE produk SET stok = stok + qty WHERE id_produk = ...
            $this->db->set('stok', 'stok + ' . (int)$d->qty, FALSE);
            $this->db->where('id_produk', $d->id_produk);
            $this->db->update('produk');
        }

        // 3. Update status menjadi Cancelled (Pakai kode Model kamu yang lama)
        $this->M_order_online->update_status($id_order_online, 'Cancelled');

        // 4. Beri notifikasi (Opsional, biar admin tahu stok sudah balik)
        $this->session->set_flashdata('success', 'Pesanan ditolak & Stok produk telah dikembalikan.');

        // 5. Redirect kembali ke halaman detail
        redirect('admin/order-online/detail/'.$id_order_online);
    }
}