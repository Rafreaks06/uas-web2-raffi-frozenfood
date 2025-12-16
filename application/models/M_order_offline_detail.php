<?php
class M_order_offline_detail extends CI_Model {

    
    public function get_detail($id_order_offline)
    {
        $this->db->select('order_offline_detail.*, produk.nama_produk, produk.harga');
        $this->db->from('order_offline_detail');
        $this->db->join('produk', 'produk.id_produk = order_offline_detail.id_produk');
        $this->db->where('id_order_offline', $id_order_offline);
        return $this->db->get()->result();
    }
    
}


