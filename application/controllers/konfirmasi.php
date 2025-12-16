<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Konfirmasi extends CI_Controller {

    public function index($id_order)
    {
        $data['order'] = $this->db->get_where('orders', [
            'id_order' => $id_order
        ])->row();

        $this->load->view('konfirmasi/index', $data);
    }


    public function upload($id_order)
    {
        $config['upload_path'] = './assets/bukti/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti')) {

            $file = $this->upload->data('file_name');

            $this->db->where('id_order', $id_order);
            $this->db->update('orders', [
                'bukti_bayar' => $file
            ]);

            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diupload.');
        } 
        else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }

        redirect('konfirmasi/index/' . $id_order);
    }
}
