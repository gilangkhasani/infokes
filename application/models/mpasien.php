<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class mpasien extends CI_Model{
	
	function getAllPasien()
	{
		$query = $this->db->get('Pasien');
		return $query->result();
	}
	
	function getAllPasienLimit($p,$u)
	{
		$this->db->order_by('created_date');
		$this->db->limit($p,$u);
		$query = $this->db->get('Pasien');
		return $query->result();
	}
	
	function savePasien($id_pasien, $data)
	{
		if($id_pasien != NULL){
			$this->db->where('id_pasien',$id_pasien);
			$query = $this->db->update('Pasien',$data);
		} else{
			$query = $this->db->insert('Pasien',$data);
		}
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function delPasien($id_pasien)
	{
		$this->db->where('id_pasien',$id_pasien);
		$query = $this->db->delete('Pasien');
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function getPasien($id_pasien)
	{
		$this->db->where('id_pasien',$id_pasien);
		$query = $this->db->get('Pasien');
		
		return $query->row();
	}
	
	function countPasien($id_pasien)
	{
		$this->db->where('id_pasien',$id_pasien);
		$query = $this->db->get('Pasien');
		return $query->num_rows();
	}
	
	function countAllPasien()
	{
		$query = $this->db->get('Pasien');
		return $query->num_rows();
	}
	
	public function getLogin($email, $password){
		$this->db->where('email',$email);
		$this->db->where('password',$password);
		$query = $this->db->get('Pasiens');
		if($query -> num_rows() == 1){
			return $query->row();
		}else{
			return "";
		}
	}
	
	public function saveHistory($email, $activity){
		$data = array(
			'email' 	 	=> $email,
			'activity'	 	=> $activity
		);
		$this->db->insert("history", $data);
	}
}