<?php
class Pa_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function paByIdKelompok($id_kelompok)
		{
			$query=$this->db->query("select * from pa where id_kelompok='$id_kelompok'");
			return $query;
		}
	}
?>