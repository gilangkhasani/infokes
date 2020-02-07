<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class mpendaftaran extends CI_Model{
	
	function getAllPendaftaran()
	{
		$this->db->select("*");
		$this->db->from("pendaftaran a");
		$this->db->join("pasien b", "a.id_pasien = b.id_pasien");
		$query = $this->db->get();
		return $query->result();
	}
	
	function getAllPendaftaranLimit($p,$u)
	{
		$this->db->order_by('created_date');
		$this->db->limit($p,$u);
		$query = $this->db->get('pendaftaran');
		return $query->result();
	}
	
	function savePendaftaran($id_pendaftaran, $data)
	{
		if($id_pendaftaran != NULL){
			$this->db->where('id_pendaftaran',$id_pendaftaran);
			$query = $this->db->update('pendaftaran',$data);
		} else{
			$query = $this->db->insert('pendaftaran',$data);
		}
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function delPendaftaran($id_pendaftaran)
	{
		$this->db->where('id_pendaftaran',$id_pendaftaran);
		$query = $this->db->delete('pendaftaran');
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function updateStatusPendaftaran($id_pendaftaran, $status_pendaftaran)
	{
		$this->db->where('id_pendaftaran',$id_pendaftaran);
		$this->db->set('status_pendaftaran', $status_pendaftaran);
		$query = $this->db->update('pendaftaran');
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function getPendaftaran($id_pendaftaran)
	{
		$this->db->where('id_pendaftaran',$id_pendaftaran);
		$this->db->select("*");
		$this->db->from("pendaftaran a");
		$this->db->join("pasien b", "a.id_pasien = b.id_pasien");
		$query = $this->db->get();
		return $query->row();
	}
	
	function countPendaftaran($id_pendaftaran)
	{
		$this->db->where('id_pendaftaran',$id_pendaftaran);
		$query = $this->db->get('pendaftaran');
		return $query->num_rows();
	}
	
	function countAllPendaftaran()
	{
		$query = $this->db->get('pendaftaran');
		return $query->num_rows();
	}
	
}