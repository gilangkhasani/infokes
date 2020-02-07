<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class mpembayaran extends CI_Model{
	
	function getAllPembayaran()
	{
		$this->db->select("*");
		$this->db->from("pembayaran a");
		$this->db->join("pendaftaran b", "a.id_pendaftaran = b.id_pendaftaran");
		$this->db->join("pasien c", "b.id_pasien = c.id_pasien");
		$query = $this->db->get();
		return $query->result();
	}
	
	function savePembayaran($id_pendaftaran, $data)
	{
		$query = $this->db->insert('pembayaran',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
}