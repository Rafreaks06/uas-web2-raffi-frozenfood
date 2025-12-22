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
    
    $id_user = $this->session->userdata('id_user');

    
    
    $this->db->where('id_user', $id_user);
    $this->db->order_by('id_order_online', 'DESC'); 

    
    $data['orders'] = $this->db->get('order_online')->result(); 
    
    
    
    

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
            
            $id_produk = $this->input->post('id_produk');
            $qty       = $this->input->post('qty');

            
            
            if (empty($id_produk) || empty($qty)) {
                $this->session->set_flashdata('error_upload', 'Gagal memproses. File bukti bayar terlalu besar atau koneksi terputus. Mohon gunakan file gambar < 2MB.');
                redirect('user/order-online/create');
                return; 
            }

            
            $produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->row();

            
            
            if (!$produk) {
                $this->session->set_flashdata('error', 'Produk tidak ditemukan atau tidak valid.');
                redirect('user/order-online/create');
                return;
            }

            if ($qty > $produk->stok) {
                $this->session->set_flashdata('error_stok', "Stok tidak cukup! Sisa stok: " . $produk->stok);
                redirect('user/order-online/create');
                return;
            }

            
            $config['upload_path']   = './assets/bukti/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048; 
            $config['encrypt_name']  = TRUE; 

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('bukti_bayar')) {
                
                $error = $this->upload->display_errors();
                if(empty($error)) {
                    $error = "File terlalu besar (Melebihi batas upload server).";
                }
                
                $this->session->set_flashdata('error_upload', $error);
                redirect('user/order-online/create');
                return;
            }

            $bukti = $this->upload->data('file_name');

            
            $subtotal = $produk->harga * $qty;

            $orderData = [
                'id_user'     => $this->session->userdata('id_user'),
                'total'       => $subtotal,
                'bukti_bayar' => $bukti,
                'status'      => 'Pending',
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $this->db->insert('order_online', $orderData);
            $id_order_online = $this->db->insert_id();

            
            $detailData = [
                'id_order_online' => $id_order_online,
                'id_produk'       => $id_produk,
                'qty'             => $qty,
                'subtotal'        => $subtotal
            ];
            $this->db->insert('order_online_detail', $detailData);

            
            $this->db->set('stok', 'stok - ' . (int)$qty, FALSE);
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk');

            
            $this->session->set_flashdata('success', 'Order berhasil dibuat!');
            redirect('user/order-online');
        }
    public function cancel($id_order_online)
    {
        
        $id_user = $this->session->userdata('id_user');

        
        $order = $this->db->get_where('order_online', [
            'id_order_online' => $id_order_online,
            'id_user'         => $id_user,
            'status'          => 'Pending'
        ])->row();

        if ($order) {
            
            
            $details = $this->db->get_where('order_online_detail', ['id_order_online' => $id_order_online])->result();

            foreach ($details as $d) {
                
                $this->db->set('stok', 'stok + ' . (int)$d->qty, FALSE);
                $this->db->where('id_produk', $d->id_produk);
                $this->db->update('produk');
            }

            
            $this->db->where('id_order_online', $id_order_online);
            $this->db->update('order_online', ['status' => 'Cancelled']);

            $this->session->set_flashdata('success', 'Pesanan berhasil dibatalkan. Stok produk telah dikembalikan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal membatalkan. Pesanan mungkin sudah diproses admin atau bukan milik Anda.');
        }

        
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
