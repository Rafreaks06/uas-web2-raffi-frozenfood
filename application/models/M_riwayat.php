<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_riwayat extends CI_Model {

    public function get_combined_history($id_user) {
        // 1. Ambil Data Online (Pasti memfilter berdasarkan id_user)
        $this->db->select("id_order_online as id_order, total, status, created_at as tanggal, 'Online' as jenis_order");
        $this->db->where('id_user', $id_user);
        $this->db->order_by('created_at', 'DESC');
        $online = $this->db->get('order_online')->result_array();

        // 2. Ambil Data Offline (Cari dulu id_customer-nya)
        $customer = $this->db->get_where('customer', ['id_user' => $id_user])->row();
        
        $offline = [];
        if ($customer) {
            $this->db->select("id_order_offline as id_order, total, status, created_at as tanggal, 'Offline' as jenis_order");
            $this->db->where('id_customer', $customer->id_customer);
            $this->db->order_by('created_at', 'DESC');
            $offline = $this->db->get('order_offline')->result_array();
        }

        // 3. Gabungkan Datanya di PHP
        $result = array_merge($online, $offline);

        // 4. Urutkan manual berdasarkan Tanggal (Terbaru di atas)
        usort($result, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return $result;
    }

    // Fungsi Pembantu: Ambil nama barang per transaksi
    public function get_detail_item($id_order, $jenis_order) {
        // Tentukan tabel detail mana yang dipakai
        if ($jenis_order == 'Offline') {
            $tabel_detail = 'order_offline_detail'; // Sesuai controller OrderOffline.php baris 60
            $fk_field     = 'id_order_offline';
        } else {
            $tabel_detail = 'order_online_detail';  // Asumsi nama tabel detail online
            $fk_field     = 'id_order_online';
        }

        // Ambil nama produk dan qty
        $this->db->select('produk.nama_produk, ' . $tabel_detail . '.qty');
        $this->db->from($tabel_detail);
        $this->db->join('produk', 'produk.id_produk = ' . $tabel_detail . '.id_produk');
        $this->db->where($tabel_detail . '.' . $fk_field, $id_order);
        
        return $this->db->get()->result_array();
    }
}