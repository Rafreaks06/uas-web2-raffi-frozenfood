<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {
    /**
     * Ambil user berdasarkan username
     * @param string $username
     * @return object|null
     */
    public function get_by_username($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }

    /**
     * Ambil user berdasarkan ID
     * @param int $id
     * @return object|null
     */
    public function get_by_id($id)
    {
        return $this->db->get_where('user', ['id_user' => $id])->row();
    }

    /**
     * Ambil semua user
     * @param string|null $role - Filter berdasarkan role (optional)
     * @return array
     */
    public function get_all($role = null)
    {
        if ($role) {
            $this->db->where('role', $role);
        }
        return $this->db->get('user')->result();
    }

    /**
     * Insert user baru
     * @param array $data
     * @return bool
     */
    public function insert($data)
    {
        return $this->db->insert('user', $data);
    }

    /**
     * Update user
     * @param int $id
     * @param array $data
     * @return bool
     */

    /**
     * Delete user
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->db->where('id_user', $id)->delete('user');
    }

    /**
     * Cek apakah username sudah ada
     * @param string $username
     * @param int|null $exclude_id - ID yang dikecualikan (untuk update)
     * @return bool
     */
    public function is_username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id_user !=', $exclude_id);
        }
        return $this->db->get('user')->num_rows() > 0;
    }
    public function get_by_email($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row();
    }
    // Digunakan untuk update data (termasuk password)
    public function update($id, $data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('user', $data);
    }
}