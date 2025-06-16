<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pelanggan_controller extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('pelanggan_model');
	}

	public function login()
	{
		if($this->session->has_userdata('pelanggan_login')){
			redirect(base_url());
			die;
		}
		$this->form_validation->set_rules('email','Email', 'required');
		$this->form_validation->set_rules('password','Password', 'required');
		if ($this->form_validation->run() !== FALSE){
			$this->__login();
			}else {
				$this->load_template('ecom/pelanggan_login');
			}
	}

	private function __login()
	{
		$email =$this->input->post('email');
		$password =md5($this->input->post('password'));
		$check =$this->pelanggan_model->check_login($email, $password);
		if ($check){
			// jika ada
			$session_data = array(
				'id' => $check['id_pelanggan'],
				'email' => $check['email'],
				'nama' => $check['nama_pelanggan'],
				'pelanggan_login' => TRUE
			);
			$this->session->set_userdata($session_data);
			redirect(base_url());
		} else{
			//jika tidak ada
			$this->session->set_flashdata('message','
			<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
				<use xlink:href="#exclamation-triangle-fill" />
				</svg>
				<div>
					Username dan atau password salah!
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert"
				aria-label="Close">
				</button>
			</div>
			');
		}
		redirect('login');
	}

	public function register()
	{
		if($this->session->has_userdata('pelanggan_login')){
			redirect(base_url());
			die;
		}
		//set required semua
		//rule lengkap --> https:/codeigniter.com
		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('nopon', 'No Telpon', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('kota', 'Kota Tinggal', 'required');
		$this->form_validation->set_rules('kodepos', 'Kode POS', 'required');
		$this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
		$this->form_validation->set_rules('email', 'Alamat Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run() !== FALSE){
			$this->__register();
		}else{
			$this->load_template('ecom/pelanggan_login');

	}
}

private function __register()
{
	$email = $this->input->post('email');
	if(!($this->pelanggan_model->get_by_email($email))){
		$data = [
			'email'=>$email,
			'password' =>md5($this->input->post('password')),
			'nama_pelanggan' => ucwords($this->input->post('nama')),
			'telp_pelanggan' => $this->input->post('nopon'),
			'alamat' => ucwords($this->input->post('alamat')),
			'kota' => ucwords($this->input->post('kota')),
			'kode_pos' => ucwords($this->input->post('kodepos')),
			'provinsi' => ucwords($this->input->post('provinsi')),

		];

		$simpan = $this->pelanggan_model->tambah($data);
		if ($simpan){
			$this->session->set_flashdata('message','
			<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/>
  				</svg>
  				<div>
    			Berhasil Register, Silahkan <b>LOGIN !</b>
  				</div>	
			<button type="button" class="btn-close" data-bs-dismiss="alert"
				aria-label="Close">
				</button>
			</div>');
		} else {
			$this->session->set_flashdata('message','
			<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/>
  				</svg>
  				<div>
    			<b>Gagal</b> melakukan registrasi!!
  				</div>	
			<button type="button" class="btn-close" data-bs-dismiss="alert"
				aria-label="Close">
				</button>
			</div>');
			}
		} else {
			$this->session->set_flashdata('message','
			<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/>
  				</svg>
  				<div>
    			Email yang anda masukan <b>sudah terdaftar!</b> 
  				</div>	
			<button type="button" class="btn-close" data-bs-dismiss="alert"
				aria-label="Close">
				</button>
			</div>');
		}
		redirect('register');
	}

		public function logout()
	{
		$session_data = array('id','email','nama','pelanggan_login');
		$this->session->unset_userdata($session_data);
		redirect(base_url());
	}
}