<?php
class Admin_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
    }
}
