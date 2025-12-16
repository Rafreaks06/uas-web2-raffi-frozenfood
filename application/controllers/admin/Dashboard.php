<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $data['title'] = 'Dashboard Admin';

        // Hitung total
        $data['total_produk']   = $this->db->count_all('produk');
        $data['total_supplier'] = $this->db->count_all('supplier');
        $data['total_customer'] = $this->db->count_all('customer');
        $data['order_offline']  = $this->db->count_all('order_offline');
        $data['order_online']   = $this->db->count_all('order_online');

        // Data grafik (OFFLINE)
        $offline = $this->db->query("
            SELECT MONTH(created_at) AS bulan, COUNT(*) AS total
            FROM order_offline
            WHERE YEAR(created_at) = YEAR(CURDATE())
            GROUP BY MONTH(created_at)
        ")->result();

        // Data grafik (ONLINE)
        $online = $this->db->query("
            SELECT MONTH(created_at) AS bulan, COUNT(*) AS total
            FROM order_online
            WHERE YEAR(created_at) = YEAR(CURDATE())
            GROUP BY MONTH(created_at)
        ")->result();

        // Siapkan array 12 bulan
        $bulan = array_fill(1, 12, 0);
        $bulan_online = array_fill(1, 12, 0);

        foreach ($offline as $row) {
            $bulan[$row->bulan] = $row->total;
        }

        foreach ($online as $row) {
            $bulan_online[$row->bulan] = $row->total;
        }

        $data['chart_offline'] = array_values($bulan);
        $data['chart_online']  = array_values($bulan_online);

        $this->render('admin/dashboard/index', $data);
    }
}
