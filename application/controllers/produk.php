
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Produk extends User_Controller {

    public function index()
    {
        $data['produk'] = $this->db->get('produk')->result();
        $this->load->view('produk/index', $data);
    }

    public function detail($id)
    {
        $data['produk'] = $this->db
            ->get_where('produk', ['id_produk' => $id])
            ->row();

        $this->load->view('produk/detail', $data);
    }
}
