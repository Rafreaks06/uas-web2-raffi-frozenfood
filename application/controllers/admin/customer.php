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

       
        $filter = $this->input->get('filter');
        $keyword = $this->input->get('keyword');

        
        $data['customer'] = $this->M_customer->get_all_gabungan($filter, $keyword);
        
        
        $data['selected_filter'] = $filter;
        $data['keyword'] = $keyword;

        $this->render('admin/customer/index', $data);
    }
    
    public function ajax_search()
    {
        $keyword = $this->input->post('keyword');
        $filter  = $this->input->post('filter'); 

        
        $data['customer'] = $this->M_customer->get_all_gabungan($filter, $keyword);
        
        
        $data['is_offline'] = ($filter == 'offline');

        
        $this->load->view('admin/customer/table_rows', $data);
    }

    

    
    
    public function detail($id, $tipe = 'Offline')
    {
        $data['title'] = 'Detail Data';
        
        if ($tipe == 'Offline') {
            
            $data['row'] = $this->M_customer->get_by_id($id);
            
            $data['riwayat'] = $this->M_customer->get_history_gabungan($data['row']->id_customer);
            
            
            
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
            
            
            $user = $this->db->get_where('user', ['id_user' => $id])->row();
            
            if(!$user) {
                echo "Data user tidak ditemukan"; return;
            }

            
            $fake_customer = new stdClass();
            $fake_customer->nama_customer    = $user->nama_lengkap;
            $fake_customer->no_hp            = $user->no_hp ? $user->no_hp : '-';
            $fake_customer->alamat           = $user->alamat ? $user->alamat : '-';
            $fake_customer->created_at       = $user->created_at;
            $fake_customer->id_user          = $user->id_user;
            $fake_customer->username         = $user->username;
            $fake_customer->nama_akun_online = $user->nama_lengkap;

            $data['row'] = $fake_customer;

            
            
            $this->load->model('M_riwayat'); 
            $raw_history = $this->M_riwayat->get_combined_history($user->id_user);

            
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