<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('musers');
	}

	public function login()
	{
		$this->load->view('login');
	}
	
	public function doLogin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$login = $this->musers->getLogin($username, $password);
		if($login != ""){
			$data = array(
				'logged_in' 	=> TRUE,
				'username' 	 	=> $login->username,
				'nama'	 		=> $login->nama,
				'email'	 		=> $login->email,
			);
			$this->session->set_userdata($data);
			$this->musers->saveHistory($email, "login");
			redirect('pasien');
		} else {
			$this->session->set_flashdata('message','Password or Username is WRONG !!!');
			redirect('users/login');
		}
	}
	
	public function logout()
	{
		$username =  $this->session->userdata('username');
		$this->session->sess_destroy();
		$this->musers->saveHistory($username, "logout");
		redirect('users/login');
	}
}
