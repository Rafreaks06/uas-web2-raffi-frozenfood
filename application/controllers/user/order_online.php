<?php
class Order_online extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') != 'user') {
            redirect('auth');
        }

        $this->load->model('M_order_online');
        $this->load->model('M_order_online_detail');
        $this->load->model('M_produk');
    }

    public function index()
{
    // 1. Ambil ID User dari session login
    $id_user = $this->session->userdata('id_user');

    // 2. Kita filter query-nya SEBELUM memanggil data
    // Pastikan tabel database kamu punya kolom 'id_user'
    $this->db->where('id_user', $id_user);
    $this->db->order_by('id_order_online', 'DESC'); // Opsional: urutkan dari yang terbaru

    // 3. Ambil data (menggunakan direct query agar lebih aman jika Model-nya belum diupdate)
    $data['orders'] = $this->db->get('order_online')->result(); 
    
    // CATATAN: Jika kamu tetap ingin pakai Model, pastikan fungsi get_all() di model mendukung chaining Query Builder,
    // atau buat fungsi baru di Model: get_by_user($id_user).
    // Tapi cara di atas ($this->db->get) adalah cara tercepat tanpa ubah Model.

    $this->load->view('user/template/header');
    $this->load->view('user/template/sidebar');
    $this->load->view('user/order_online/index', $data);
    $this->load->view('user/template/footer');
}

    public function create()
    {
        $data['produk'] = $this->M_produk->get_all();
        $this->load->view('user/template/header');
        $this->load->view('user/template/sidebar');
        $this->load->view('user/order_online/form', $data);
        $this->load->view('user/template/footer');
    }

    public function store()
    {
        // 1. Ambil Input
        $id_produk = $this->input->post('id_produk');
        $qty       = $this->input->post('qty');

        // 2. CEK STOK PRODUK DULU
        $produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->row();

        if ($qty > $produk->stok) {
            // Jika minta lebih banyak dari stok
            $this->session->set_flashdata('error_stok', "Stok tidak cukup! Sisa stok: " . $produk->stok);
            redirect('user/order-online/create');
            return; // Stop proses
        }

        // 3. Upload Bukti Bayar (Kode Lama Kamu)
        $config['upload_path']   = './assets/bukti/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE; // Enkripsi nama file biar aman

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti_bayar')) {
            $this->session->set_flashdata('error_upload', $this->upload->display_errors());
            redirect('user/order-online/create');
            return;
        }

        $bukti = $this->upload->data('file_name');

        // 4. Hitung Total
        $subtotal = $produk->harga * $qty;

        // 5. Insert ke order_online
        $orderData = [
            'id_user'     => $this->session->userdata('id_user'),
            'total'       => $subtotal,
            'bukti_bayar' => $bukti,
            'status'      => 'Pending',
            'created_at'  => date('Y-m-d H:i:s')
        ];
        $this->db->insert('order_online', $orderData);
        $id_order_online = $this->db->insert_id();

        // 6. Insert ke Detail
        $detailData = [
            'id_order_online' => $id_order_online,
            'id_produk'       => $id_produk,
            'qty'             => $qty,
            'subtotal'        => $subtotal
        ];
        $this->db->insert('order_online_detail', $detailData);

        // 7. KURANGI STOK (UPDATE PRODUK)
        // Rumus: stok = stok - qty
        $this->db->set('stok', 'stok - ' . (int)$qty, FALSE);
        $this->db->where('id_produk', $id_produk);
        $this->db->update('produk');

        // 8. Sukses
        $this->session->set_flashdata('success', 'Order berhasil dibuat!');
        redirect('user/order-online');
    }
    public function cancel($id_order_online)
    {
        // 1. Ambil ID User yang login (Keamanan: biar gak asal batalin punya orang)
        $id_user = $this->session->userdata('id_user');

        // 2. Cek apakah order ini milik user tersebut DAN statusnya masih Pending
        $order = $this->db->get_where('order_online', [
            'id_order_online' => $id_order_online,
            'id_user'         => $id_user,
            'status'          => 'Pending'
        ])->row();

        if ($order) {
            // 3. LOGIKA KEMBALIKAN STOK
            // Ambil barang apa saja yang ada di order ini
            $details = $this->db->get_where('order_online_detail', ['id_order_online' => $id_order_online])->result();

            foreach ($details as $d) {
                // Balikin stok ke tabel produk
                $this->db->set('stok', 'stok + ' . (int)$d->qty, FALSE);
                $this->db->where('id_produk', $d->id_produk);
                $this->db->update('produk');
            }

            // 4. Update status jadi Cancelled
            $this->db->where('id_order_online', $id_order_online);
            $this->db->update('order_online', ['status' => 'Cancelled']);

            $this->session->set_flashdata('success', 'Pesanan berhasil dibatalkan. Stok produk telah dikembalikan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal membatalkan. Pesanan mungkin sudah diproses admin atau bukan milik Anda.');
        }

        // Redirect kembali ke halaman detail
        redirect('user/order-online/detail/' . $id_order_online);
    }

    public function detail($id)
    {
        $data['order'] = $this->M_order_online->get_by_id($id);
        $data['items'] = $this->M_order_online_detail->get_by_order($id);

        $this->load->view('user/template/header');
        $this->load->view('user/template/sidebar');
        $this->load->view('user/order_online/detail', $data);
        $this->load->view('user/template/footer');
    }
}
