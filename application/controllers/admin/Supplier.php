    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Supplier extends Admin_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_supplier');
        }

        public function index()
        {
            $data['title'] = 'Daftar Supplier';
            $data['supplier'] = $this->M_supplier->get_all();

            $this->render('admin/supplier/index', $data);
        }

        public function create()
        {
            $data['title'] = 'Tambah Supplier';
            $this->render('admin/supplier/form', $data);
        }

        public function store()
        {
            $data = [
                'nama_supplier' => $this->input->post('nama_supplier'),
                'no_hp'          => $this->input->post('no_hp'),
                'alamat'        => $this->input->post('alamat'),
            ];

            $this->M_supplier->insert($data);

            redirect('admin/supplier');
        }

        public function edit($id)
        {
            $data['title'] = 'Edit Supplier';
            $data['row']   = $this->M_supplier->get_by_id($id);

            $this->render('admin/supplier/form', $data);
        }

        public function update($id)
        {
            $data = [
                'nama_supplier' => $this->input->post('nama_supplier'),
                'no_hp'          => $this->input->post('no_hp'),
                'alamat'        => $this->input->post('alamat'),
            ];

            $this->M_supplier->update($id, $data);

            redirect('admin/supplier');
        }

        public function delete($id)
        {
            $this->M_supplier->delete($id);
            redirect('admin/supplier');
        }
    }
