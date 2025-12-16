<?php
class M_supplier extends CI_Model {

    public function get_all()
    {
        return $this->db->get('supplier')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('supplier', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('supplier', ['id_supplier' => $id])->row();
    }

    public function update($id, $data)
    {
        return $this->db->update('supplier', $data, ['id_supplier' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete('supplier', ['id_supplier' => $id]);
    }
}
