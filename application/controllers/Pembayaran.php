<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		$this->load->model('mpembayaran');
		$this->load->model('mpendaftaran');
	}

	public function index()
	{
		redirect('pembayaran/listing');
	}
	
	public function listing()
	{
		if($this->session->flashdata('notify')) $data['notify'] = $this->session->flashdata('notify');
		
		$data['result'] = $this->mpembayaran->getAllPembayaran();
		$data['content'] = 'pembayaran/list_pembayaran';
		
		$this->load->view('template',$data);
	}
	
	public function save(){
		
		$data = array(
			'id_pendaftaran' 		=> $this->input->post('id_pendaftaran'),
			'nominal_pembayaran' 	=> $this->input->post('nominal_pembayaran'),
			'tanggal_pembayaran' 	=> now(),
			'created_date' 			=> now(),
			'created_by' 			=> $this->session->userdata('username'),
		);
		
		$query = $this->mpembayaran->savePembayaran($this->input->post('id_pendaftaran'), $data);
		
		if($query){
			$this->mpendaftaran->updateStatusPendaftaran($this->input->post('id_pendaftaran'), "Lunas");
			$this->session->set_flashdata('notify', "Data pembayaran Berhasil");			
		} else {
			$this->session->set_flashdata('notify', "Data pembayaran Gagal");
		}
		redirect("pembayaran/listing");
	}

}
