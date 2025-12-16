<?php
class M_produk extends CI_Model {

    public function get_all()
    {
        $this->db->select('produk.*, kategori.nama_kategori, supplier.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'kategori.id_kategori = produk.id_kategori', 'left');
        $this->db->join('supplier', 'supplier.id_supplier = produk.id_supplier', 'left');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('produk.*, kategori.nama_kategori, supplier.nama_supplier');
        $this->db->from('produk');
        $this->db->join('kategori', 'kategori.id_kategori = produk.id_kategori', 'left');
        $this->db->join('supplier', 'supplier.id_supplier = produk.id_supplier', 'left');
        $this->db->where('produk.id_produk', $id);
        return $this->db->get()->row();
    }

    public function insert($data)
    {
        return $this->db->insert('produk', $data);
    }

    public function update($id, $data)
    {
        return $this->db->update('produk', $data, ['id_produk' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete('produk', ['id_produk' => $id]);
    }
}
