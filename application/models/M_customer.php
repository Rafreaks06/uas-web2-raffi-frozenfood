<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer extends CI_Model
{
    // 1. Ambil Semua Customer (Murni Tabel Customer)
    public function get_all()
    {
        return $this->db->order_by('created_at', 'DESC')
                        ->get('customer')
                        ->result();
    }

    // 2. Ambil Detail Customer by ID (Join ke User)
    public function get_by_id($id)
    {
        $this->db->select('
            customer.*, 
            user.username, 
            user.nama_lengkap AS nama_akun_online,
            user.id_user AS user_id_verified
        ');
        $this->db->from('customer');
        $this->db->join('user', 'user.id_user = customer.id_user', 'left');
        $this->db->where('customer.id_customer', $id);
        
        return $this->db->get()->row();
    }

    // 3. Ambil Order Offline Saja
    public function get_orders_by_customer($id)
    {
        return $this->db->where('id_customer', $id)
                        ->order_by('created_at', 'DESC')
                        ->get('order_offline')
                        ->result();
    }

    // =========================================================
    // PERBAIKAN UTAMA DI SINI (MENGHINDARI BUG ORDER TERTUKAR)
    // =========================================================
    public function get_history_gabungan($id_customer)
    {
        // A. Ambil Data OFFLINE (Pasti milik customer ini)
        $this->db->select("
            id_order_offline AS id_order, 
            total, 
            status, 
            created_at AS tanggal, 
            'Offline' AS jenis_order
        ");
        $this->db->where('id_customer', $id_customer);
        $this->db->order_by('created_at', 'DESC');
        $offline = $this->db->get('order_offline')->result_array();

        // B. Ambil Data ONLINE (Hanya jika terhubung ke user)
        $online = [];
        
        // Cek dulu customer ini connect ke user ID berapa
        $cust = $this->db->get_where('customer', ['id_customer' => $id_customer])->row();

        // Pastikan id_user ada isinya dan bukan 0/NULL
        if ($cust && !empty($cust->id_user)) {
            $this->db->select("
                id_order_online AS id_order, 
                total, 
                status, 
                created_at AS tanggal, 
                'Online' AS jenis_order
            ");
            $this->db->where('id_user', $cust->id_user); // Filter ketat by ID User
            $this->db->order_by('created_at', 'DESC');
            $online = $this->db->get('order_online')->result_array();
        }

        // C. Gabungkan Array Offline + Online
        $result = array_merge($offline, $online);

        // D. Urutkan Manual berdasarkan Tanggal (Terbaru di atas)
        usort($result, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return $result; // Kembalikan array hasil gabungan yang bersih
    }

    // 5. Fungsi Helper ambil detail barang
    public function get_detail_item_admin($id_order, $jenis_order) {
        if ($jenis_order == 'Offline') {
            $tabel = 'order_offline_detail';
            $fk    = 'id_order_offline';
        } else {
            $tabel = 'order_online_detail'; 
            $fk    = 'id_order_online';
        }

        $this->db->select('produk.nama_produk, ' . $tabel . '.qty');
        $this->db->from($tabel);
        $this->db->join('produk', 'produk.id_produk = ' . $tabel . '.id_produk');
        $this->db->where($tabel . '.' . $fk, $id_order);
        
        return $this->db->get()->result_array();
    }

    // 6. Ambil Daftar Semua Orang (List Gabungan User & Customer)
    public function get_all_gabungan()
    {
        // Ambil Customer Offline
        $query_customer = "
            SELECT 
                id_customer AS id_primary,
                nama_customer AS nama,
                no_hp,
                alamat,
                created_at,
                'Offline' AS tipe,
                id_user
            FROM customer
        ";

        // Ambil User Online (Yang belum jadi customer)
        $query_user = "
            SELECT 
                id_user AS id_primary,
                nama_lengkap AS nama,
                '-' AS no_hp,    
                '-' AS alamat,   
                created_at,
                'Online' AS tipe,
                id_user
            FROM user 
            WHERE role = 'user' 
            AND id_user NOT IN (SELECT id_user FROM customer WHERE id_user IS NOT NULL)
        ";

        $sql = "SELECT * FROM ($query_customer UNION ALL $query_user) AS gabungan 
                ORDER BY created_at DESC";

        return $this->db->query($sql)->result();
    }
}