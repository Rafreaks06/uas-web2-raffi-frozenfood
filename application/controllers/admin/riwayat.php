<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Cek Login User (Sesuaikan session 'role' atau 'id_user' kamu)
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login'); 
        }
        $this->load->model('M_riwayat');
    }

    public function index()
    {
        $id_user = $this->session->userdata('id_user');

        // 1. Ambil data mentah (Header Transaksi)
        $raw_history = $this->m_riwayat->get_combined_history($id_user);
        
        $data_final = [];

        // 2. Loop data untuk mengisi detail barang
        foreach ($raw_history as $row) {
            // Ambil item produk untuk order ini
            $items = $this->m_riwayat->get_detail_item($row['id_order'], $row['jenis_order']);
            
            // Format tampilan barang: "Bakso (x2), Sosis (x1)"
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

        // Load View (Sesuaikan dengan template frontend kamu)
        $this->load->view('layout/header', $data); // Contoh header
        $this->load->view('v_riwayat', $data);
        $this->load->view('layout/footer');        // Contoh footer
    }
}