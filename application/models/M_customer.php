<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer extends CI_Model
{
    
    public function get_all()
    {
        return $this->db->order_by('created_at', 'DESC')
                        ->get('customer')
                        ->result();
    }

    
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

    
    public function get_orders_by_customer($id)
    {
        return $this->db->where('id_customer', $id)
                        ->order_by('created_at', 'DESC')
                        ->get('order_offline')
                        ->result();
    }

    
    
    
    public function get_history_gabungan($id_customer)
    {
        
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

        
        $online = [];
        
        
        $cust = $this->db->get_where('customer', ['id_customer' => $id_customer])->row();

        
        if ($cust && !empty($cust->id_user)) {
            $this->db->select("
                id_order_online AS id_order, 
                total, 
                status, 
                created_at AS tanggal, 
                'Online' AS jenis_order
            ");
            $this->db->where('id_user', $cust->id_user); 
            $this->db->order_by('created_at', 'DESC');
            $online = $this->db->get('order_online')->result_array();
        }

        
        $result = array_merge($offline, $online);

        
        usort($result, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return $result; 
    }

    
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

   public function get_all_gabungan($filter = null, $keyword = null)
    {
        $hasil = [];

        
        if (empty($filter) || $filter == 'online') {
            
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('role', 'user');

            
            if (!empty($keyword)) {
                $this->db->like('nama_lengkap', $keyword);
            }

            $users = $this->db->get()->result();
            
            foreach ($users as $u) {
                $hasil[] = (object) [
                    'id'           => $u->id_user,
                    'nama'         => $u->nama_lengkap,
                    'no_hp'        => $u->no_hp ? $u->no_hp : '-',  
                    'alamat'       => $u->alamat ? $u->alamat : '-',
                    'tipe'         => 'Online',      
                    'tanggal'      => $u->created_at,
                    'badge_color'  => 'primary',     
                    'badge_label'  => 'User Online'
                ];
            }
        }

        
        if (empty($filter) || $filter == 'offline') {
            
            $this->db->select('*');
            $this->db->from('customer');

            
            if (!empty($keyword)) {
                $this->db->like('nama_customer', $keyword);
            }

            $customers = $this->db->get()->result();

            foreach ($customers as $c) {
                $hasil[] = (object) [
                    'id'           => $c->id_customer,
                    'nama'         => $c->nama_customer,
                    'no_hp'        => $c->no_hp,
                    'alamat'       => $c->alamat,
                    'tipe'         => 'Offline',     
                    'tanggal'      => $c->created_at,
                    'badge_color'  => 'success',     
                    'badge_label'  => 'Customer Offline'
                ];
            }
        }

        
        usort($hasil, function($a, $b) {
            return strtotime($b->tanggal) - strtotime($a->tanggal);
        });

        return $hasil;
    }
}
