<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends MY_Controller {

    public function index()
    {
        $data['orders'] = $this->db->get('orders')->result();
        $this->render('admin/order/index', $data);
    }

    public function detail($id_order)
    {
        $data['order'] = $this->db->get_where('orders', [
            'id_order' => $id_order
        ])->row();

        $this->render('admin/order/detail', $data);
    }

    public function validasi($id_order)
    {
        $this->db->where('id_order', $id_order);
        $this->db->update('orders', ['status' => 'Paid']);

        $this->session->set_flashdata('success', 'Pembayaran telah divalidasi.');
        redirect('order');
    }
}
