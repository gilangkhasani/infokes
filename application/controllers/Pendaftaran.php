<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		$this->load->model('mpasien');
		$this->load->model('mpendaftaran');
	}

	public function index()
	{
		redirect('pendaftaran/listing');
	}
	
	public function listing()
	{
		if($this->session->flashdata('notify')) $data['notify'] = $this->session->flashdata('notify');
		
		$data['pasien'] = $this->mpasien->getAllPasien();
		$data['result'] = $this->mpendaftaran->getAllPendaftaran();
		$data['content'] = 'pendaftaran/list_pendaftaran';
		
		$this->load->view('template',$data);
	}
	
	public function getPendaftaran()
	{
		$id_pendaftaran = $this->input->get('id_pendaftaran');
		
		$count = $this->mpendaftaran->countPendaftaran($id_pendaftaran);
		$data = array();
		if($count > 0){
			$data['msg'] = "Data Found";
			$data['count'] = $count;
			$data['result'] = $this->mpendaftaran->getPendaftaran($id_pendaftaran);
			$data['status'] = true;
		} else {
			$data['msg'] = "No Data Found";
			$data['count'] = $count;
			$data['result'] = "No Data Found";
			$data['status'] = false;
		}
		
		echo json_encode($data);
	}
	
	public function batal($id_pendaftaran){
		$row = $this->mpendaftaran->getPendaftaran($id_pendaftaran);
		if($row->status_pendaftaran == 'Daftar'){
			$query = $this->mpendaftaran->updateStatusPendaftaran($id_pendaftaran, "Batal");
			if($query){
				$this->session->set_flashdata('notify', "Status Data Pendaftaran Berhasil");
			} else {
				$this->session->set_flashdata('notify', "Status Data Pendaftaran Gagal");
			}
		} else {
			$this->session->set_flashdata('notify', "Status Pendaftaran Gagal Karena Status pendaftaran sekarang ".$row->status_pendaftaran);
		}
		redirect("pendaftaran/listing");
	}
	
	public function save(){
		if(empty($this->input->post('id_pendaftaran'))){
			$data = array(
				'id_pendaftaran' 		=> $this->input->post('id_pendaftaran'),
				'id_pasien' 			=> $this->input->post('id_pasien'),
				'tanggal_pendaftaran' 	=> $this->input->post('tanggal_pendaftaran'),
				'keluhan' 				=> $this->input->post('keluhan'),
				'status_pendaftaran' 	=> "Daftar",
				'created_by' 			=> $this->session->userdata('username'),
				'created_date' 			=> now()
			);
		} else {
			$data = array(
				'id_pendaftaran' 		=> $this->input->post('id_pendaftaran'),
				'id_pasien' 			=> $this->input->post('id_pasien'),
				'tanggal_pendaftaran' 	=> $this->input->post('tanggal_pendaftaran'),
				'keluhan' 				=> $this->input->post('keluhan'),
				'status_pendaftaran'	=> "Daftar",
				'modify_by' 			=> $this->session->userdata('username'),
				'modify_date' 			=> now()
			);
		}
		if($query){
			if(empty($this->input->post('id_pendaftaran'))){
				$this->session->set_flashdata('notify', "Data pendaftaran Berhasil ditambahkan");
			} else {
				$this->session->set_flashdata('notify', "Data pendaftaran Berhasil diubah");
			}
		} else {
			$this->session->set_flashdata('notify', "Data pendaftaran Gagal ditambahkan");
		}
		$this->mpendaftaran->savePendaftaran($this->input->post('id_pendaftaran'), $data);
		redirect("pendaftaran/listing");
	}

}
