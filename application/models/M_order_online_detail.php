<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_order_online_detail extends CI_Model {

    protected $table = 'order_online_detail';

    public function __construct() {
        parent::__construct();
    }

    
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    
    public function get_by_id($id_detail) {
        return $this->db->get_where($this->table, ['id_detail' => $id_detail])->row();
    }

    public function get_by_order($id_order_online)
    {
        return $this->db
            ->select('order_online_detail.*, produk.nama_produk, produk.harga')
            ->from('order_online_detail')
            ->join('produk', 'produk.id_produk = order_online_detail.id_produk')
            ->where('order_online_detail.id_order_online', $id_order_online)
            ->get()
            ->result();
    }


    
    public function insert($data)
    {
        return $this->db->insert('order_online_detail', $data);
    }
    
    public function update($id_detail, $data) {
        return $this->db->where('id_detail', $id_detail)->update($this->table, $data);
    }

    
    public function delete($id_detail) {
        return $this->db->delete($this->table, ['id_detail' => $id_detail]);
    }

    
    public function delete_by_order($id_order_online) {
    return $this->db->delete($this->table, ['id_order_online' => $id_order_online]);
}

}
