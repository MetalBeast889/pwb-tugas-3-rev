<?php
defined('BASEPATH') or exit('No direct script access allowed');

class profil_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pelanggan_model');
		$this->load->helper('format');

		// Cek apakah sudah login
		if (!$this->session->has_userdata('pelanggan_login')) {
			redirect('login');
			exit;
		}
	}

public function tampil_profil()
{
    $id = $this->session->userdata('id');
    // Ambil data pelanggan berdasarkan id
    $data['pelanggan'] = $this->pelanggan_model->get_by_id($id);

    // Format nomor telepon di sini
    $data['pelanggan']['telp_pelanggan'] = format_nomor($data['pelanggan']['telp_pelanggan']);
    $this->load_template('ecom/pelanggan_profil', $data);
}

public function ubah_profil($id)
	{
		$pelanggan = $this->pelanggan_model->get_by_id($id);
		if($pelanggan){
				$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
				$this->form_validation->set_rules('nopon', 'No Telpon', 'required');
				$this->form_validation->set_rules('alamat', 'Alamat', 'required');
				$this->form_validation->set_rules('kota', 'Kota Tinggal', 'required');
				$this->form_validation->set_rules('kodepos', 'Kode POS', 'required');
				$this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
			if($this->form_validation->run() !== FALSE){
				$this->__ubah_profil($id);
			}else{
				$data['title'] ='Ubah produk';
				$data['pelanggan']= $pelanggan;

			$this->load_template('ecom/pelanggan_profil', $data);
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			profil tidak ditemukan!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
				');
			redirect('profil');
		}
	}

	public function __ubah_profil($id)
	{
		$data = [ 
			'nama_pelanggan' => ucwords($this->input->post('nama')),
			'telp_pelanggan' => format_nomor($this->input->post('nopon')),
			'kode_pos' => $this->input->post('kodepos'),
			'kota' => ucwords($this->input->post('kota')),
			'provinsi' => ucwords($this->input->post('provinsi')),
			'alamat' => ucwords($this->input->post('alamat'))
		];
		$password = $this->input->post('password');
		if (!empty($password)) {
		    $data['password'] = md5($password);
		}

		$config['upload_path']   = './uploads/profil/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048; // 2MB
		$config['file_name']     = 'profil_' . $id . '_' . time();
		$this->load->library('upload', $config);

		if (!empty($_FILES['foto_profil']['name'])) {
		    if ($this->upload->do_upload('foto_profil')) {
		        $upload_data = $this->upload->data();
		        $data['foto_profil'] = $upload_data['file_name'];

		        // Hapus foto lama jika ada
		        if (!empty($pelanggan['foto_profil']) && file_exists('./uploads/foto_profil/' . $pelanggan['foto_profil'])) {
		            unlink('./uploads/foto_profil/' . $pelanggan['foto_profil']);
		        }
		    } else {
		        $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal mengupload foto: ' . $this->upload->display_errors('', '') . '</div>');
		        redirect('profil');
		    }
		}

		$ubah = $this->pelanggan_model->ubah($data, $id);

		if($ubah !==FALSE){
			$this->session->set_flashdata('message','
			<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  				<div>
    			Berhasil Mengubah Profil pelanggan!!
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
  					Gagal mengubah profil pelanggan!!
  				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>

			</div>
			');
		}
		redirect('profil');
	}


}