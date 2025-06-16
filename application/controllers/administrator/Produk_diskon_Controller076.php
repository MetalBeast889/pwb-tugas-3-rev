<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Produk_diskon_Controller076 extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		is_admin_logged_in();
		$this->load->model('Produk_diskon_model076');
		$this->load->model('produk_model');
	}
	public function index(){
		$data['title']='Diskon Produk';
		$data['list_diskon'] = $this->Produk_diskon_model076->get_all();
		$this->load->view('administrator/templates/header',$data);
		$this->load->view('administrator/templates/sidebar');
		$this->load->view('administrator/diskon/index',$data);
		$this->load->view('administrator/templates/footer');
	}

	public function tambah_diskon()
	{
		$data['title'] = 'Tambah diskon';

		$this->form_validation->set_rules('nama_diskon','Nama diskon','required');
		$this->form_validation->set_rules('produk','Nama Produk','required');
		$this->form_validation->set_rules(
			'jumlah_diskon',
			'Jumlah Diskon',
			'required|regex_match[/^[0-9]+$/]|greater_than_equal_to[1]|less_than_equal_to[100]',
			[
				'regex_match' => 'Hanya angka bulat yang diperbolehkan.',
				'greater_than_equal_to' => 'Nilai minimal diskon adalah 1%.',
				'less_than_equal_to' => 'Nilai maksimal diskon adalah 100%.'
			]
		);
		if ($this->form_validation->run() !== FALSE){
			$this->__simpan_diskon(); 
		}else{
		$data['list_produk'] = $this->produk_model->get_all();
		$this->load->view('administrator/templates/header',$data);
		$this->load->view('administrator/templates/sidebar');
		$this->load->view('administrator/diskon/tambah_diskon',$data);
		$this->load->view('administrator/templates/footer');
		}

	}

	private function __simpan_diskon()
	{
		$data = [
			'nama076' => ucwords($this->input->post('nama_diskon')),
			'jumlah_diskon076' => $this->input->post('jumlah_diskon'),
			'produk_id'=> $this->input->post('produk'),
			'deskripsi076' => ucfirst($this->input->post('deskripsi_diskon'))
		];
		$simpan = $this->Produk_diskon_model076->tambah($data);
		if($simpan){
			$this->session->set_flashdata('message','
			<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Berhasil Menambahkan diskon!!
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
  					Gagal menambahkan diskon!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
		}
		redirect('admin/diskon');
	}


	public function hapus_diskon($id)
	{
		//cek apakah ada diskon
		$diskon =$this->Produk_diskon_model076->get_by_id($id);
		if($diskon){
			$hapus = $this->Produk_diskon_model076->hapus($id);
			if($hapus){
				$this->session->set_flashdata('message','
				<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Berhasil Menghapus diskon!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
					');
			}else{
				$this->session->set_flashdata('message','
				<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Gagal menghapus diskon!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
			}
			redirect('admin/diskon');
		}else{

			$this->session->set_flashdata('message','
				<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			diskon tidak ditemukan!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
			redirect('admin/diskon');
		}
	}

}


