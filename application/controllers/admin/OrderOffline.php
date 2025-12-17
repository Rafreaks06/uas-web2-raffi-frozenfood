<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderOffline extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_produk');
        $this->load->model('M_customer');
        $this->load->model('M_order_offline');
        $this->load->model('M_order_offline_detail');
    }

    public function index()
    {
        $data['title'] = 'Data Order Offline';
        
        // 1. Ambil Input Filter
        $keyword   = $this->input->get('keyword');
        $tgl_awal  = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');

        // 2. Mulai Query
        $this->db->select('order_offline.*, customer.nama_customer'); // Ambil nama dari tabel customer
        $this->db->from('order_offline');
        $this->db->join('customer', 'customer.id_customer = order_offline.id_customer', 'left'); // JOIN WAJIB

        // --- FILTER TANGGAL ---
        if (!empty($tgl_awal)) {
            $this->db->where('DATE(order_offline.created_at) >=', $tgl_awal);
        }
        if (!empty($tgl_akhir)) {
            $this->db->where('DATE(order_offline.created_at) <=', $tgl_akhir);
        }

        // --- FILTER PENCARIAN (Keyword) ---
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('customer.nama_customer', $keyword); 
            $this->db->or_like('order_offline.id_order_offline', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('order_offline.created_at', 'DESC');
        $data['orders'] = $this->db->get()->result();
        
        $data['keyword']   = $keyword;
        $data['tgl_awal']  = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $this->render('admin/order_offline/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Order Offline';
        $data['produk'] = $this->M_produk->get_all();
        $this->render('admin/order_offline/form', $data);
    }

    public function store()
    {
        // 1. TANGKAP INPUT (Sesuai name di Form.php)
        $input_nama   = $this->input->post('customer_name'); // Dari form input text
        $id_produk    = $this->input->post('id_produk');     // Single Value
        $qty          = $this->input->post('qty');           // Single Value
        
        // Validasi Sederhana
        if(empty($input_nama) || empty($id_produk)) {
             $this->session->set_flashdata('error_stok', "Data nama atau produk tidak boleh kosong!");
             redirect('admin/order-offline/create');
             return;
        }

        // 2. CEK STOK DULU
        $produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->row();
        if ($qty > $produk->stok) {
            $this->session->set_flashdata('error_stok', "Stok tidak cukup! Sisa: " . $produk->stok);
            redirect('admin/order-offline/create');
            return;
        }

        // Hitung Subtotal di Backend
        $subtotal_fix = $produk->harga * $qty;

        // ==========================================================
        // LANGKAH A: SIMPAN NAMA KE TABEL CUSTOMER (SESUAI REQUEST)
        // ==========================================================
        $dataCustomer = [
            'nama_customer' => $input_nama,
            'alamat'        => '-', // Default strip karena offline biasanya cepat
            'no_hp'         => '-', 
            'created_at'    => date('Y-m-d H:i:s')
        ];
        $this->db->insert('customer', $dataCustomer);
        $id_customer_baru = $this->db->insert_id(); // AMBIL ID YANG BARU DIBUAT

        // ==========================================================
        // LANGKAH B: SIMPAN KE TABEL ORDER OFFLINE (HEADER)
        // ==========================================================
        // Disini kita pakai ID Customer yang baru dibuat tadi
        $orderData = [
            'id_customer'   => $id_customer_baru, 
            'total'         => $subtotal_fix,
            'status'        => 'Success',
            'created_at'    => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('order_offline', $orderData);
        $id_order = $this->db->insert_id(); 

        // ==========================================================
        // LANGKAH C: SIMPAN KE TABEL DETAIL
        // ==========================================================
        $detailData = [
            'id_order_offline' => $id_order,
            'id_produk'        => $id_produk,
            'qty'              => $qty,
            'subtotal'         => $subtotal_fix
        ];
        $this->db->insert('order_offline_detail', $detailData);

        // ==========================================================
        // LANGKAH D: KURANGI STOK
        // ==========================================================
        $this->db->set('stok', 'stok - ' . (int)$qty, FALSE);
        $this->db->where('id_produk', $id_produk);
        $this->db->update('produk');

        $this->session->set_flashdata('success', 'Transaksi berhasil disimpan!');
        redirect('admin/order-offline');
    }
        
    public function detail($id)
    {
        // Load data order + Nama Customer (lewat Join di Model atau Query langsung)
        $this->db->select('order_offline.*, customer.nama_customer, customer.alamat, customer.no_hp');
        $this->db->from('order_offline');
        $this->db->join('customer', 'customer.id_customer = order_offline.id_customer', 'left');
        $this->db->where('order_offline.id_order_offline', $id);
        $data['order'] = $this->db->get()->row();

        $data['detail'] = $this->M_order_offline_detail->get_detail($id);
        $data['title']  = "Detail Order Offline";

        $this->render('admin/order_offline/detail', $data);
    }

    public function cetak($id)
    {
        // Query manual biar pasti dapat nama customer
        $this->db->select('order_offline.*, customer.nama_customer');
        $this->db->from('order_offline');
        $this->db->join('customer', 'customer.id_customer = order_offline.id_customer', 'left');
        $this->db->where('order_offline.id_order_offline', $id);
        $data['order'] = $this->db->get()->row();

        $data['detail'] = $this->M_order_offline_detail->get_detail($id);
        $this->load->view('admin/order_offline/cetak', $data);
    }

    public function delete($id)
    {
        // Hapus detail dulu
        $this->db->delete('order_offline_detail', ['id_order_offline' => $id]);
        
        // Cek dulu ID customernya siapa (Opsional: kalau mau hapus data customernya juga)
        // $order = $this->db->get_where('order_offline', ['id_order_offline' => $id])->row();
        
        // Hapus header
        $this->db->delete('order_offline', ['id_order_offline' => $id]);
        
        // (Opsional) Hapus customer 'sampah' jika mau
        // $this->db->delete('customer', ['id_customer' => $order->id_customer]);

        redirect('admin/order-offline');
    }
}