<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		$this->load->model('mpasien');
	}

	public function index()
	{
		redirect('pasien/listing');
	}
	
	public function listing()
	{
		if($this->session->flashdata('notify')) $data['notify'] = $this->session->flashdata('notify');
		echo $this->session->flashdata('notify');
		$data['result'] = $this->mpasien->getAllPasien();
		$data['content'] = 'pasien/list_pasien';
		
		$this->load->view('template',$data);
	}
	
	public function getPasien()
	{
		$id_pasien = $this->input->get('id_pasien');
		
		$count = $this->mpasien->countPasien($id_pasien);
		$data = array();
		if($count > 0){
			$data['msg'] = "Data Found";
			$data['count'] = $count;
			$data['result'] = $this->mpasien->getPasien($id_pasien);
			$data['status'] = true;
		} else {
			$data['msg'] = "No Data Found";
			$data['count'] = $count;
			$data['result'] = "No Data Found";
			$data['status'] = false;
		}
		
		echo json_encode($data);
	}
	
	public function delete($id_pasien){
		$query = $this->mpasien->delPasien($id_pasien);
		if($query){
			$this->session->set_flashdata('notify', "Data Pasien Berhasil Dihapus");
		} else {
			$this->session->set_flashdata('notify', "Data Pasien Gagal Dihapus");
		}
		
		redirect("pasien/listing");
	}
	
	public function save(){
		if(empty($this->input->post('id_pasien'))){
			$data = array(
				'id_pasien' 			=> $this->input->post('id_pasien'),
				'nama_pasien' 			=> $this->input->post('nama_pasien'),
				'alamat_pasien' 		=> $this->input->post('alamat_pasien'),
				'telepon_pasien' 		=> $this->input->post('telepon_pasien'),
				'created_by' 			=> $this->session->userdata('username'),
				'created_date' 			=> now()
			);
		} else {
			$data = array(
				'id_pasien' 			=> $this->input->post('id_pasien'),
				'nama_pasien' 			=> $this->input->post('nama_pasien'),
				'alamat_pasien' 		=> $this->input->post('alamat_pasien'),
				'telepon_pasien' 		=> $this->input->post('telepon_pasien'),
				'modify_by' 			=> $this->session->userdata('username'),
				'modify_date' 			=> now()
			);
		}
		$query = $this->mpasien->savePasien($this->input->post('id_pasien'), $data);
		if($query){
			if(empty($this->input->post('id_pasien'))){
				$this->session->set_flashdata('notify', "Data Pasien Berhasil ditambahkan");
			} else {
				$this->session->set_flashdata('notify', "Data Pasien Berhasil diubah");
			}
		} else {
			$this->session->set_flashdata('notify', "Data Pasien Gagal ditambahkan");
		}
		
		redirect("pasien/listing");
	}

}
