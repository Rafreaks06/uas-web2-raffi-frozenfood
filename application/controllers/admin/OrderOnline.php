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
       $data['title'] = 'Data Order Online';
        
        
        $status = $this->input->get('status');

        
        $this->db->select('order_online.*, user.nama_lengkap');
        $this->db->from('order_online');
        $this->db->join('user', 'user.id_user = order_online.id_user', 'left');
        
        
        if (!empty($status)) {
            $this->db->where('order_online.status', $status);
        }

        $this->db->order_by('order_online.created_at', 'DESC');
        $data['orders'] = $this->db->get()->result();

        
        $data['selected_status'] = $status;

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
        
        $this->M_order_online->update_status($id_order_online, 'Success'); 
        redirect('admin/order-online/detail/'.$id_order_online);
    }

    

    public function tolak($id_order_online)
    {
        
        
        $details = $this->db->get_where('order_online_detail', ['id_order_online' => $id_order_online])->result();

        
        foreach ($details as $d) {
            
            $this->db->set('stok', 'stok + ' . (int)$d->qty, FALSE);
            $this->db->where('id_produk', $d->id_produk);
            $this->db->update('produk');
        }

        
        $this->M_order_online->update_status($id_order_online, 'Cancelled');

        
        $this->session->set_flashdata('success', 'Pesanan ditolak & Stok produk telah dikembalikan.');

        
        redirect('admin/order-online/detail/'.$id_order_online);
    }
}