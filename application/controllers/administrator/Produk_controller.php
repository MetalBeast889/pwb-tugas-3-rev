<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Produk_controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		is_admin_logged_in();
		$this->load->model('produk_model');
		$this->load->model('produk_kategori_model');
		$this->load->model('produk_gambar_model');

	}
	public function index(){
		$data['title']='Daftar Produk';
		$data['list_produk'] = $this->produk_model->get_all();
		$this->load->view('administrator/templates/header',$data);
		$this->load->view('administrator/templates/sidebar');
		$this->load->view('administrator/produk/index',$data);
		$this->load->view('administrator/templates/footer');
	}

		public function tambah_produk()
	{
		$data['title'] = 'Tambah Produk';

		$this->form_validation->set_rules('nama_produk','Nama produk','required');
		$this->form_validation->set_rules('kategori_produk','Kategori','required');
		if ($this->form_validation->run() !== FALSE){
			$this->__simpan_produk(); 
		}else{
		$data['list_kategori'] = $this->produk_kategori_model->get_all();
		$this->load->view('administrator/templates/header',$data);
		$this->load->view('administrator/templates/sidebar');
		$this->load->view('administrator/produk/tambah_produk',$data);
		$this->load->view('administrator/templates/footer');
		}

	}

	private function __simpan_produk()
	{
		$data = [
			'nama' => ucwords($this->input->post('nama_produk')),
			'categori_id' => $this->input->post('kategori_produk'),
			'harga' => $this->input->post('harga_produk'),
			'stok'=> $this->input->post('stok_produk'),
			'deskripsi' => ucfirst($this->input->post('deskripsi_produk'))
		];

		#simpan dan return id_produk yg disimpan
		$id_produk = $this->produk_model->tambah($data);

		$count = count($_FILES['gambar_produk']['name']);
		if($count > 0){
			//jika ada gambar upload
			$this->__produk_gambar_upload($count, $id_produk);
		}
			$this->session->set_flashdata('message','
			<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Berhasil Menambahkan Produk!!
  				</div>	
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
		redirect('admin/produk');
	}

	private function __produk_gambar_upload($count, $id_produk)
	{
		for ($i= 0; $i<$count; $i++){
			if(!empty($_FILES['gambar_produk']['name'][$i])){
				$_FILES['file']['name'] = $_FILES['gambar_produk']['name'][$i];
				$_FILES['file']['type'] = $_FILES['gambar_produk']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['gambar_produk']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['gambar_produk']['error'][$i];
				$_FILES['file']['size'] = $_FILES['gambar_produk']['size'][$i];

				$config['upload_path']='uploads/produk/';
				$config['allowed_types']='jpg|jpeg|png|gif';
				$config['max_size']='5000';
				$config['file_name']="produk-".$id_produk.'-'.$i; //untuk merubah nama gambar

				$this->load->library('upload',$config);

				if($this->upload->do_upload('file')){
					$uploadData=$this->upload->data();
					$filename=$uploadData['file_name'];
					$data = [
						'nama_gambar' => $filename,
						'produk_id' => $id_produk
					];
					$this->produk_gambar_model->tambah($data);
				}else{
					  // Menangani error upload
   				 $this->session->set_flashdata('message','
			<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
  			<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  				<div>
  					Size Gambar tidak sesuai, coba gambar lainnya!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
    			redirect('admin/produk/ubah/'.$id_produk);
				}
			}
		}
	}

		public function ubah_produk($id)
	{
		$produk = $this->produk_model->get_by_id($id); //ini definisi variablenya
		if($produk){
			$this->form_validation->set_rules('nama_produk','Nama produk','required');
			$this->form_validation->set_rules('kategori_produk','Kategori','required');
			if($this->form_validation->run() !== FALSE){
				$this->__ubah_produk($id);
			}else{
				//Nama yang di dalam ['...'] akan jadi nama variabel di view.
				//Variabel yang disebelah = ($profil, $pelanggan, $user, dll) sudah di-define sebelumnya di controller.
				$data['title'] ='Ubah produk';
				$data['produk']= $produk;
				$data['list_kategori']=$this->produk_kategori_model->get_all();
				$data['gambar_model']=$this->produk_gambar_model;
				$this->load->view('administrator/templates/header',$data);
				$this->load->view('administrator/templates/sidebar');
				$this->load->view('administrator/produk/ubah_produk',$data);
				$this->load->view('administrator/templates/footer');
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			produk tidak ditemukan!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
				');
			redirect('admin/produk');
		}
	}

	public function __ubah_produk($id)
	{
		$data = [ 
			'nama' => ucwords($this->input->post('nama_produk')),
			'categori_id' => $this->input->post('kategori_produk'),
			'harga'=> $this->input->post('harga_produk'),
			'stok'=> $this->input->post('stok_produk'),
			'deskripsi' => ucfirst($this->input->post('deskripsi_produk'))
		];
		$ubah = $this->produk_model->ubah($data, $id);

		 // Tambahkan ini supaya gambar bisa diupload saat ubah produk
    	$count = count($_FILES['gambar_produk']['name']);
    	if($count > 0 && $_FILES['gambar_produk']['name'][0] != ''){
        $this->__produk_gambar_upload($count, $id);
    }

		if($ubah !==FALSE){
			$this->session->set_flashdata('message','
			<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Berhasil Mengubah Produk!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
		} else {
			$this->session->set_flashdata('message','
			<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
  			<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  				<div>
  					Gagal mengubah produk!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
		}
		redirect('admin/produk');
	}

	public function hapus_produk($id)
	{
		//cek apakah ada kategori
		$produk =$this->produk_model->get_by_id($id);
		if ($produk){
			//ambil data gambar
			$list_gambar = $this->produk_gambar_model->get_by_product_id($id);
			foreach ($list_gambar as $gambar){
				$id_gambar = $gambar['id_gambar'];
				$nama_gambar = $gambar['nama_gambar'];
				// hapus gambar di db
				$this->produk_gambar_model->hapus($id_gambar);
				//hapus gambar di file
				$path = './uploads/produk/'.$nama_gambar;
				unlink($path);
			}

			//hapus produk di db
				$this->produk_model->hapus($id);
				$this->session->set_flashdata('message','
				<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Berhasil Menghapus Produk!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
					');
				redirect('admin/produk');
			}else{
				$this->session->set_flashdata('message','
				<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Produk tidak ditemukan!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
			redirect('admin/produk');
		}
	}

	public function hapus_gambar($id_gambar, $id_produk)
	{
	    $gambar = $this->produk_gambar_model->get_by_id($id_gambar);
	    
	    if ($gambar) {
	        // Hapus gambar di folder
	        $path = './uploads/produk/' . $gambar['nama_gambar'];
	        if(file_exists($path)){
	            unlink($path);
	        }

	        // Hapus di database
	        $this->produk_gambar_model->hapus($id_gambar);

	        $this->session->set_flashdata('message', '
	        <div class="alert alert-success alert-dismissible fade show" role="alert">
	            Gambar Berhasil Dihapus!
	            	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
	        </div>');
	    } else {
	        $this->session->set_flashdata('message', '
	        <div class="alert alert-danger alert-dismissible fade show" role="alert">
	            Gambar tidak ditemukan!
	            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	        </div>');
	    }

	    // Redirect kembali ke halaman edit produk
	    redirect('admin/produk/ubah/'.$id_produk);
	}


}