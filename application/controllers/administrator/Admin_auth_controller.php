<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_auth_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('Administrator_model');
	}


	public function index()
	{
		$data['title'] = 'JUNA';

		$this->form_validation->set_rules('inputUsername','Username','required');
		$this->form_validation->set_rules('inputPassword','Password','required');
		if($this->form_validation->run()!== FALSE){
			$this->__login();
		}else{
			$this->load->view('administrator/login',$data);
		}

	}

	private function __login()
	{
		$username =$this->input->post('inputUsername');
		$password =$this->input->post('inputPassword');
		$check =$this->Administrator_model->check_login($username, md5($password));
		if ($check){
			// jika ada
			$session_data = array(
				'id' => $check['id_admin'],
				'username' => $check['username'],
				'full_name' => $check['full_name'],
				'admin_login' => TRUE
			);
			$this->session->set_userdata($session_data);
			redirect('admin');
		} else{
			//jika tidak ada
			$this->session->set_flashdata('massage','
			<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
				<use xlink:href="#exclamation-triangle-fill" />
				</svg>
				<div>
					Username dan password salah!
				</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="background:none;border:none;font-size:1.5rem;line-height:1;">&times;
			</button>
			</div>
			');
			redirect('admin/login');
		}
	}

	public function logout()
	{
		$session_data = array('id','username','full_name','admin_login');
		$this->session->unset_userdata($session_data);
		redirect('admin/login');
	}

}