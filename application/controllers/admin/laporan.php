<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_laporan');
    }

    public function index()
    {
        $data['title'] = 'Laporan Penjualan';
        $this->render('admin/laporan/index', $data);
    }

    public function cetak()
    {
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $submit    = $this->input->post('submit');

        // Validasi Form Kosong
        if (empty($tgl_awal) || empty($tgl_akhir)) {
            $this->session->set_flashdata('pesan', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Tanggal awal dan akhir harus diisi!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
            redirect('admin/laporan');
        }

        // Validasi Tanggal Terbalik
        if (strtotime($tgl_awal) > strtotime($tgl_akhir)) {
            $this->session->set_flashdata('pesan', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Tanggal Awal tidak boleh lebih besar dari Tanggal Akhir.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
            redirect('admin/laporan');
        }

        // Ambil Data dari Model
        $data['laporan'] = $this->M_laporan->get_laporan_periode($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        // --- LOGIKA TOMBOL ---
        if ($submit == 'print') {
            // Cetak PDF (tanpa sidebar)
            $this->load->view('admin/laporan/cetak_print', $data);
        } elseif ($submit == 'excel') {
            // Export Excel (tanpa sidebar)
            $this->load->view('admin/laporan/cetak_excel', $data);
        } elseif ($submit == 'web') {
            // --- INI TAMBAHAN BARU ---
            // Lihat di Web (pakai render agar ada sidebar & header)
            $data['title'] = 'Laporan: ' . date('d M Y', strtotime($tgl_awal)) . ' - ' . date('d M Y', strtotime($tgl_akhir));
            $this->render('admin/laporan/lihat_laporan', $data);
        }
    }
}