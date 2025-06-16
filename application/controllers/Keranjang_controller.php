<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Keranjang_controller extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('keranjang_model');
		$this->load->model('keranjang_produk_model');
		$this->load->model('produk_model');
		$this->load->model('produk_gambar_model');
		$this->load->model('Produk_diskon_model076');
		if (!$this->session->has_userdata('pelanggan_login')){
			redirect('login');
			die;
		}
	}

	public function index()
	{
		$pelanggan_id = $this->session->userdata('id');
		$keranjang = $this->keranjang_model->get_by_pelanggan($pelanggan_id);
		if($keranjang){
			//jika ada keranjang, ambil data produk dari keranjang produk berdasarkan id_keranjang.
			$keranjang_id = $keranjang[0]['id_keranjang'];
			$keranjang_produk = $this->keranjang_produk_model->get_by_keranjang($keranjang_id);
			//jika ada produk di keranjang, ambil data produk berdasarkan id_produk
			$produk = [];
			$total = 0; 
			foreach ($keranjang_produk as $item) {
				$produk_data = $this->produk_model->get_by_id($item['produk_id']);
				if ($produk_data){
					$diskon = $this->Produk_diskon_model076->get_by_produk_id($item['produk_id']);
					$harga_asli = $produk_data['harga'];
					$persen_diskon = $diskon ? $diskon['jumlah_diskon076'] : 0;
					$harga_diskon = $harga_asli - ($harga_asli * $persen_diskon / 100);

					$produk_data['jumlah'] = $item['jumlah'];
					$produk_data['harga_asli'] = $harga_asli;
					$produk_data['harga_diskon'] = round($harga_diskon);
					$produk_data['sub_total'] = round($harga_diskon * $item['jumlah']);
					$produk_data['persen_diskon'] = $persen_diskon;
					$produk_data['gambar'] = $this->produk_gambar_model->get_by_product_id($item['produk_id']);
					$produk_data['id_keranjang_produk'] = $item['id_keranjang_produk'];

					$total += $produk_data['sub_total'];
					$produk[] = $produk_data;
				}
			}
			// masukan ke $data
			$data['produk'] = $produk;
			$data['total'] = $total;
			$data['keranjang_id'] = $keranjang_id;
		} else {
			 $this->session->set_flashdata('message', '
            <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">Tidak ada Produk di Keranjang Anda!</div>');
		}
			 // tampilkan view apapun kondisinya
			$this->load_template('ecom/keranjang',$data);
	}

		private function __hitung_total($keranjang_id)
	{
	    $keranjang_produk = $this->keranjang_produk_model->get_by_keranjang($keranjang_id);
	    $total = 0;
	    foreach ($keranjang_produk as $item) {
	        $produk = $this->produk_model->get_by_id($item['produk_id']);
	        if ($produk) {
	            $diskon = $this->Produk_diskon_model076->get_by_produk_id($item['produk_id']);
	            $harga = $produk['harga'];
	            if ($diskon) {
	                $harga -= ($harga * $diskon['jumlah_diskon076'] / 100);
	            }
	            $total += $harga * $item['jumlah'];
	        }
	    }
	    return $total;
	}


	public function tambah()
	{
		$this->form_validation->set_rules('id_produk', 'ID produk', 'required');
		$this->form_validation->set_rules('jumlah','Jumlah','required');
		if ($this->form_validation->run() !== FALSE){
			$this->__tambah_produk_keranjang();
		}else{
			redirect(base_url());
		}
	}

	private function __tambah_produk_keranjang()
	{
		$id_produk = $this->input->post('id_produk');
		$jumlah = $this->input->post('jumlah');
		$pelanggan_id = $this->session->userdata('id');

		$produk = $this->produk_model->get_by_id($id_produk);
		if (!$produk || $produk['stok'] < $jumlah){
			$this->session->set_flashdata('message','
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Stok produk tidak cukup!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				');
			redirect(base_url());
			return;
		}

		$keranjang  = $this->keranjang_model->get_by_pelanggan($pelanggan_id);

		if (!$keranjang){
			$this->db->insert('keranjang',[
				'pelanggan_id'=> $pelanggan_id, 'total'=> 0
			]);
			$keranjang_id = $this->db->insert_id();
		}else{
			$keranjang_id = $keranjang[0]['id_keranjang'];
		}

		$produk_di_keranjang = $this->keranjang_produk_model->get_by_produk_keranjang($keranjang_id, $id_produk);
		if ($produk_di_keranjang){
			$jumlah_baru = $produk_di_keranjang['jumlah'] + $jumlah;
			$this->keranjang_produk_model->ubah(['jumlah' => $jumlah_baru], $produk_di_keranjang['id_keranjang_produk']);
		}else{
			$this->keranjang_produk_model->tambah([
				'keranjang_id' => $keranjang_id,
				'produk_id' => $id_produk,
				'jumlah' => $jumlah
			]);
		}

		$total = $this->__hitung_total($keranjang_id);
		$this->keranjang_model->ubah(['total'=> $total], $keranjang_id);
		$this->session->set_flashdata('message','
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			Produk berhasil ditambahkan ke keranjang!
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		');
		redirect(base_url("keranjang"));
	}

	public function ubah_keranjang()
	{
		$this->form_validation->set_rules('id_produk','ID produk', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('id_keranjang_produk', 'ID keranjang', 'required');
		if ($this->form_validation->run() !== FALSE){
			$this->__ubah_produk_keranjang();
		} else{
			redirect(base_url('keranjang'));
		}
	}

	private function __ubah_produk_keranjang()
	{
		echo "ubah produk keranjang";
		$id_produk = $this->input->post('id_produk');
		$jumlah = $this->input->post('jumlah');
		$id_keranjang_produk = $this->input->post('id_keranjang_produk');
		//echo $id_keranjang_produk
		// cek dulu apakah benar poduk ini ada di keranjang
		$keranjang_produk = $this->keranjang_produk_model->get_by_id($id_keranjang_produk);

		if(!$keranjang_produk){
			$this->session->set_flashdata('message','
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Produk tidak ada di keranjang!
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			');
			redirect(base_url('keranjang'));
			return;
		}

		//cek stok produk
		$produk = $this->produk_model->get_by_id($id_produk);
		if (!$produk || $produk['stok'] < $jumlah){
			$this->session->set_flashdata('message','
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Stok Produk Tidak Cukup!
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			');
			redirect(base_url('keranjang'));
			return;
		}

		//ubah jumlah produk di keranjang berdasarkan id keranjang dan id produk
		$this->keranjang_produk_model->ubah(['jumlah' => $jumlah], $id_keranjang_produk);
		//hitung total harga produk di keranjang
		$keranjang_id = $keranjang_produk['keranjang_id'];
		$total = $this->__hitung_total($keranjang_id);
		$this->session->set_flashdata('message','
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			Stok berhasil diubah di keranjang!
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			');
		redirect(base_url('keranjang'));
	}

	public function hapus_produk_keranjang()
	{
		$this->form_validation->set_rules('id_keranjang_produk', 'ID keranjang produk', 'required');
		if($this->form_validation->run() !== FALSE){
			$this->__hapus_produk_keranjang();
		}else{
			redirect(base_url('keranjang'));
		}
	}

	private function __hapus_produk_keranjang()
	{
		$id_keranjang_produk = $this->input->post('id_keranjang_produk');
		// cek dulu apakah benar produk isi ada di keranjang
		$keranjang_produk = $this->keranjang_produk_model->get_by_id($id_keranjang_produk);
		if (!$keranjang_produk){
			$this->session->set_flashdata('message','
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Produk tidak ada di keranjang!
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			');
			redirect(base_url('keranjang'));
			return;
		}

		//hapus produk dari keranjang berdasarkan id keranjang produk
		$this->keranjang_produk_model->hapus($id_keranjang_produk);
		// hitung total harga produk di keranjang
		$keranjang_id = $keranjang_produk['keranjang_id'];
		$keranjang_produk = $this->keranjang_produk_model->get_by_keranjang($keranjang_id);
		// jika tidak ada produk di keranjang, harga keranjang
		if (empty($keranjang_produk)){
			$this->keranjang_model->hapus($keranjang_id);
			$this->session->set_flashdata('message','
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			Keranjang Kosong!
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			');
			redirect(base_url('keranjang'));
			return;
		}
		$total= $this->__hitung_total($keranjang_id);
		// ubah total harga di keranjang
		$this->keranjang_model->ubah(['total' => $total], $keranjang_id);
		$this->session->set_flashdata('message','
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			Produk berhasil dihapus dari keranjang!
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		');
		redirect(base_url('keranjang'));
	}
}
