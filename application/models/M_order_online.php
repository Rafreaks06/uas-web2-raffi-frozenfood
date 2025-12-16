<?php
class M_order_online extends CI_Model {

    public function get_all()
    {
        return $this->db->get('order_online')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id_order_online', $id)
                        ->get('order_online')
                        ->row();
    }

    public function get_all_with_user()
    {
        return $this->db
            ->select('order_online.*, user.username, user.nama')
            ->from('order_online')
            ->join('user', 'user.id_user = order_online.id_user')
            ->get()
            ->result();
    }

    public function get_all_admin()
    {
        return $this->db
            ->select('order_online.*, user.username, user.nama_lengkap')
            ->from('order_online')
            ->join('user', 'user.id_user = order_online.id_user')
            ->order_by('order_online.id_order_online', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id_admin($id)
    {
        return $this->db
            ->select('order_online.*, user.username, user.nama_lengkap')
            ->from('order_online')
            ->join('user', 'user.id_user = order_online.id_user')
            ->where('order_online.id_order_online', $id)
            ->get()
            ->row();
    }

    // --- ADDED THIS FUNCTION HERE ---
    public function update_status($id_order_online, $status)
    {
        $data = array(
            'status' => $status
        );

        $this->db->where('id_order_online', $id_order_online);
        $this->db->update('order_online', $data);
        
        return $this->db->affected_rows();
    }
}