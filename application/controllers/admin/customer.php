<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_customer');
    }

    public function index()
    {
        $data['title'] = 'Data Customer & User Online';

        // 1. Ambil filter dari URL (jika ada)
        $filter = $this->input->get('filter');

        // 2. Kirim $filter ke Model
        $data['customer'] = $this->M_customer->get_all_gabungan($filter);
        
        // 3. Simpan filter terpilih agar dropdown tidak reset saat direfresh
        $data['selected_filter'] = $filter;

        $this->render('admin/customer/index', $data);
    }

    // UPDATE FUNGSI DETAIL
    // Kita perlu parameter tambahan $tipe karena User Online ID-nya beda tabel
    public function detail($id, $tipe = 'Offline')
    {
        $data['title'] = 'Detail Data';
        
        if ($tipe == 'Offline') {
            // Logika Lama (Ambil dari tabel Customer)
            $data['row'] = $this->M_customer->get_by_id($id);
            // Ambil riwayat gabungan (fungsi yang sudah kita buat sebelumnya)
            $data['riwayat'] = $this->M_customer->get_history_gabungan($data['row']->id_customer);
            
            // Format riwayat (logika string item)
            // ... (Copy logika foreach loop dari kode kamu sebelumnya di sini) ...
             $history_final = [];
             $raw_history = $data['riwayat'];
             foreach ($raw_history as $row) {
                $items = $this->M_customer->get_detail_item_admin($row['id_order'], $row['jenis_order']);
                $list_str = [];
                if(!empty($items)){
                    foreach($items as $item){
                        $list_str[] = $item['nama_produk'] . " (x" . $item['qty'] . ")";
                    }
                    $row['items_string'] = implode(", ", $list_str);
                } else {
                    $row['items_string'] = "-";
                }
                $history_final[] = $row;
            }
            $data['riwayat'] = $history_final;

            $this->render('admin/customer/detail', $data);

        } else {
            // Logika Baru (Khusus User Online Murni)
            // Kita harus mengambil data dari tabel USER, bukan CUSTOMER
            $user = $this->db->get_where('user', ['id_user' => $id])->row();
            
            if(!$user) {
                echo "Data user tidak ditemukan"; return;
            }

            // Kita manipulasi agar strukturnya mirip dengan object customer agar view tidak error
            $fake_customer = new stdClass();
            $fake_customer->nama_customer    = $user->nama_lengkap;
            $fake_customer->no_hp            = $user->no_hp ? $user->no_hp : '-';
            $fake_customer->alamat           = $user->alamat ? $user->alamat : '-';
            $fake_customer->created_at       = $user->created_at;
            $fake_customer->id_user          = $user->id_user;
            $fake_customer->username         = $user->username;
            $fake_customer->nama_akun_online = $user->nama_lengkap;

            $data['row'] = $fake_customer;

            // Ambil riwayat belanja Online user ini
            // Kita pakai M_riwayat yang pernah kita buat (get_combined_history pakai id_user)
            $this->load->model('M_riwayat'); 
            $raw_history = $this->M_riwayat->get_combined_history($user->id_user);

            // Format string item (sama seperti logic sebelumnya)
            $history_final = [];
            foreach ($raw_history as $row) {
                $items = $this->M_riwayat->get_detail_item($row['id_order'], $row['jenis_order']);
                $list_str = [];
                if(!empty($items)){
                    foreach($items as $item){
                        $list_str[] = $item['nama_produk'] . " (x" . $item['qty'] . ")";
                    }
                    $row['items_string'] = implode(", ", $list_str);
                } else {
                    $row['items_string'] = "-";
                }
                $history_final[] = $row;
            }
            $data['riwayat'] = $history_final;

            $this->render('admin/customer/detail', $data);
        }
    }
}