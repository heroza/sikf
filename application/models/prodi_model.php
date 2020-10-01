<?php
class Prodi_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function deskripsiProdi($prodi)
		{
			$result=$this->db->query("SELECT * FROM auditee WHERE prodi = '$prodi'");
			return $result;
		}
		
		function getIdByDeskripsi($prodi)
		{
			$query=$this->db->query("SELECT id_prodi FROM prodi WHERE prodi = '$prodi'");
			foreach($query -> result_array() as $item) 
			{ $id_prodi = $item['id_prodi']; }
			return $id_prodi;
		}
		
		function prodiById($id_prodi)
		{
			$query=$this->db->query("SELECT prodi FROM prodi WHERE id_prodi = '$id_prodi'");
			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 
			   $prodi = $row->prodi;
			}
			return $prodi;
		}
		
		function prodiByUsername($username)
		{
			$query=$this->db->query("SELECT * FROM prodi WHERE username = '$username'");
			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 
			}
			return $row;
		}
		
		function prodiAllById($id_prodi)
		{
			$query=$this->db->query("SELECT * FROM prodi WHERE id_prodi = '$id_prodi'");
			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 
			}
			return $row;
		}
	}
?>