<?php
class MY_Controller extends CI_Controller {
    public $menu_item;

    public function __construct() {
        parent::__construct();
        $this->load->model('produk_kategori_model');
        $this->menu_item = $this->produk_kategori_model->get_all(); // sesuaikan dengan fungsi kamu
    }

    public function load_template($view, $data = []) {
        $data['menu_item'] = $this->menu_item;
        $this->load->view('ecom/template/header', $data);
        $this->load->view($view, $data);
        $this->load->view('ecom/template/footer');
    }

    public function load_template_home($view, $data = []){
        // Pastikan data menu tetap tersedia
        $data['menu_item'] = $this->menu_item;
        $this->load->view('ecom/template/header', $data);
        $this->load->view('ecom/template/carausel');
        $this->load->view($view, $data);
        $this->load->view('ecom/template/footer');
    }
}
 