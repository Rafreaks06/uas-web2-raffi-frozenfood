<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {

    public function get_laporan_periode($tgl_awal, $tgl_akhir)
    {
        // 1. Query untuk Order OFFLINE (Ambil nama dari tabel 'customer')
        $query_offline = "
            SELECT 
                o.id_order_offline AS id_transaksi,
                o.created_at AS tanggal,
                o.total,
                o.status,
                'Offline' AS jenis_order,
                c.nama_customer AS nama_pembeli,  -- Ambil Nama Customer
                (
                    SELECT GROUP_CONCAT(CONCAT(p.nama_produk, ' (', d.qty, ')') SEPARATOR ', ')
                    FROM order_offline_detail d
                    JOIN produk p ON p.id_produk = d.id_produk
                    WHERE d.id_order_offline = o.id_order_offline
                ) as detail_barang
            FROM order_offline o
            JOIN customer c ON c.id_customer = o.id_customer -- Join ke Customer
            WHERE DATE(o.created_at) >= '$tgl_awal' 
            AND DATE(o.created_at) <= '$tgl_akhir'
            AND o.status = 'Success'
        ";

        // 2. Query untuk Order ONLINE (Ambil nama dari tabel 'user')
        $query_online = "
            SELECT 
                o.id_order_online AS id_transaksi,
                o.created_at AS tanggal,
                o.total,
                o.status,
                'Online' AS jenis_order,
                u.nama_lengkap AS nama_pembeli,   -- Ambil Nama User
                (
                    SELECT GROUP_CONCAT(CONCAT(p.nama_produk, ' (', d.qty, ')') SEPARATOR ', ')
                    FROM order_online_detail d
                    JOIN produk p ON p.id_produk = d.id_produk
                    WHERE d.id_order_online = o.id_order_online
                ) as detail_barang
            FROM order_online o
            JOIN user u ON u.id_user = o.id_user  -- Join ke User
            WHERE DATE(o.created_at) >= '$tgl_awal' 
            AND DATE(o.created_at) <= '$tgl_akhir'
            AND o.status = 'Success'
        ";

        // 3. Gabungkan Query
        $sql = "SELECT * FROM ($query_offline UNION ALL $query_online) AS laporanku 
                ORDER BY tanggal ASC"; 

        return $this->db->query($sql)->result();
    }
}