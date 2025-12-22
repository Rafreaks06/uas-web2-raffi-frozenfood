<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login'); 
        }
        $this->load->model('M_riwayat');
    }

    public function index()
    {
        $id_user = $this->session->userdata('id_user');

        
        $raw_history = $this->m_riwayat->get_combined_history($id_user);
        
        $data_final = [];

        
        foreach ($raw_history as $row) {
            
            $items = $this->m_riwayat->get_detail_item($row['id_order'], $row['jenis_order']);
            
            
            $list_barang = [];
            if(!empty($items)){
                foreach($items as $item){
                    $list_barang[] = $item['nama_produk'] . " (x" . $item['qty'] . ")";
                }
                $row['detail_barang'] = implode(", ", $list_barang);
            } else {
                $row['detail_barang'] = "-";
            }
            
            $data_final[] = $row;
        }

        $data['title']   = 'Riwayat Belanja Saya';
        $data['riwayat'] = $data_final;

        
        $this->load->view('layout/header', $data); 
        $this->load->view('v_riwayat', $data);
        $this->load->view('layout/footer');        
    }
}