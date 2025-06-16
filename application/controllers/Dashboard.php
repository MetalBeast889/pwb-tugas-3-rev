<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model');
		$this->load->model('produk_gambar_model');
		$this->load->model('Produk_diskon_model076');
	}

		public function index()
	{
		$this->load->model('Produk_diskon_Model076'); // pastikan model diskon dimuat
		$data['gambar_model'] = $this->produk_gambar_model;

		$list_produk = $this->produk_model->get_all();

		foreach ($list_produk as &$produk) {
			$produk = $this->__hitung_diskon($produk);
		}

		$data['list_produk'] = $list_produk;

		$this->load_template_home('ecom/pelanggan_produk',$data);
	}

		private function __hitung_diskon($produk)
	{
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
