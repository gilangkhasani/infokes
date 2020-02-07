<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class musers extends CI_Model{
	
	public function getLogin($username, $password){
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$query = $this->db->get('users');
		if($query -> num_rows() == 1){
			return $query->row();
		}else{
			return "";
		}
	}
	
	public function saveHistory($username, $activity){
		$data = array(
			'username' 	 	=> $username,
			'activity'	 	=> $activity
		);
		$this->db->insert("history", $data);
	}
}