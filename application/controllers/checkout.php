<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CI_Controller {

    public function index($id_produk)
    {
        $data['produk'] = $this->db->get_where('produk', [
            'id_produk' => $id_produk
        ])->row();

        $this->load->view('checkout/index', $data);
    }

    public function proses()
    {
        $total = $this->input->post('qty') * $this->input->post('harga');

        $data = [
            'id_produk'     => $this->input->post('id_produk'),
            'nama_customer' => $this->input->post('nama'),
            'alamat'        => $this->input->post('alamat'),
            'no_wa'         => $this->input->post('no_wa'),
            'qty'           => $this->input->post('qty'),
            'total'         => $total,
            'status'        => 'Pending'
        ];

        $this->db->insert('orders', $data);
        $id_order = $this->db->insert_id();

        redirect('konfirmasi/index/' . $id_order);
    }
}
