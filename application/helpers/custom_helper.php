<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function human_date($tgl)
{
	$d = date("l, j F Y",strtotime($tgl));
	return $d;
}

function checkLogin()
{
	$myci = & get_instance();
	if($myci->session->userdata('logged_in') != TRUE){
		redirect('users/login');
	}
}

function checkUser()
{
	$myci = & get_instance();
	if($myci->session->userdata('privilege') != 'admin'){
		redirect('welcome');
		//$this->load->view('admin/template_home');
	} 
}

function now()
{
	return date('Y-m-d H:i:s');
}

function kdauto($table, $inisial)
{
	$con = mysqli_connect("localhost","root","","penjualan");
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql 		= "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
	$result		= mysqli_query($con, $sql);
	$row		= mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	$field 		= $row['Column_name'];
	
	echo $query_max = "SELECT max(".$field.") FROM ".$table." WHERE product_category_code = '".$inisial."'";
	$qry  		= mysqli_query($con, $query_max);
	$row		= mysqli_fetch_array($qry, MYSQLI_NUM);
	if ($row[0] == "") {
		$angka = 0;
	} else {
		$angka = substr($row[0], strlen($inisial));
	}
	
	$panjang = strlen($row[0]);
	$angka++;
	$angka = strval($angka);
	
	$tmp  = "";
	for($i = 1; $i <= ($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp = $tmp."0";
	}
	if($row[0] == ""){
		$tmp = '00000';
	} else {
		$tmp = $tmp;
	}
	return $inisial.$tmp.$angka;
}
