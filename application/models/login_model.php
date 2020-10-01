<?php
class Login_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function Data_Login($table,$username,$pass)
		{
			
			$query=$this->db->query("select * from $table where username='$username' and password='$pass'");
			return $query;
		}

		function dologin($username,$pass)
		{
			$query=$this->db->query("select * from user where username='$username' and password='$pass'");
			return $query;
		}
	}
?>