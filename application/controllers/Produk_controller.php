<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Produk_controller extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model');
		$this->load->model('produk_kategori_model');
		$this->load->model('produk_gambar_model');
		$this->load->model('Produk_diskon_model076');
	}

		public function index($kategori_id = 0)
	{
		$data['title'] = 'Daftar Produk';
		$data['gambar_model'] = $this->produk_gambar_model;

		if ($kategori_id != 0) {
			$produk_list = $this->produk_model->get_by_kategori($kategori_id);
			$kategori = $this->produk_kategori_model->get_by_id($kategori_id);
			$data['kategori_nama'] = $kategori ? $kategori['nama'] : 'Kategori Tidak Diketahui';
			// Tampilkan tombol "Lihat Semua Produk"
        	$data['tampilkan_lihat_semua'] = true;
		} else {
			$produk_list = $this->produk_model->get_all();
			$data['kategori_nama'] = "Semua Produk";
		}

		// Hitung diskon di sini
		foreach ($produk_list as &$produk) {
			$produk = $this->__hitung_diskon($produk);
		}

		$data['list_produk'] = $produk_list;

		$this->load_template('ecom/pelanggan_produk', $data);
	}

	public function detail($id = 0)
	{
		if ($id == 0){
			redirect('/');
			die;
		}

		$produk = $this->produk_model->get_by_id($id);
		if (!$produk){
			redirect('/');
			die;
		}

		$produk = $this->__hitung_diskon($produk);

		$data['menu_item'] = $this->menu_item;		
		$data['produk'] = $produk;
		$data['list_gambar'] = $this->produk_gambar_model->get_by_product_id($id);
		$data['kategori'] = $this->produk_kategori_model->get_by_id($produk['categori_id']);

		$this->load_template('ecom/produk_detail', $data);
	}

		private function __hitung_diskon($produk)
	{
		// cek apakah produk punya diskon
		$diskon = $this->Produk_diskon_model076->get_by_produk_id($produk['id_produk']);

		if ($diskon) {
			$produk['diskon'] = $diskon;
			$persen = $diskon['jumlah_diskon076'];
			$produk['harga_setelah_diskon'] = $produk['harga'] - ($produk['harga'] * $persen / 100);
		} else {
			$produk['diskon'] = null;
			$produk['harga_setelah_diskon'] = $produk['harga'];
		}

		return $produk;
	}

}