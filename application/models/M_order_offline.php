<?php
class M_order_offline extends CI_Model {

    public function get_all()
    {
        $this->db->select('o.*, c.nama_customer');
        $this->db->from('order_offline o');
        $this->db->join('customer c', 'c.id_customer = o.id_customer');
        $this->db->order_by('o.id_order_offline', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('o.*, c.*');
        $this->db->from('order_offline o');
        $this->db->join('customer c', 'c.id_customer = o.id_customer');
        $this->db->where('o.id_order_offline', $id);
        return $this->db->get()->row();
    }

    public function get_detail($id)
    {
        $this->db->select('d.*, p.nama_produk');
        $this->db->from('order_offline_detail d');
        $this->db->join('produk p', 'p.id_produk = d.id_produk');   
        $this->db->where('d.id_order_offline', $id);
        return $this->db->get()->result();
    }
}
