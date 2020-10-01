<?php
class Other_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function Count_Data($counter,$tabel,$seleksi)
		{
			$query=$this->db->query("select count($counter) as count from $tabel where $seleksi");
			return $query;
		}
		
		function Total_Data($tabel)
		{
			$q=$this->db->query("select * from $tabel");
			return $q;
		}
		
		function Pilih_Content($tabel,$seleksi)
		{
			$query=$this->db->query("select * from $tabel where $seleksi");
			return $query;
		}
		
		function Group_By($tabel,$group)
		{
			$query=$this->db->query("select * from $tabel group by $group");
			return $query;
		}
		
		function Save_Content($tabel,$datainsert)
		{
			$this->db->insert($tabel,$datainsert);
		}
		
		function Update_Content($tabel,$isi,$seleksi)
		{
			$this->db->where($seleksi,$isi[$seleksi]);
			$this->db->update($tabel,$isi);
		}
		
		function Delete_Content($id,$seleksi,$tabel)
		{
			$this->db->where($seleksi,$id);
			$this->db->delete($tabel);
		}
		
		function Cek($tabel,$seleksi,$cari)
		{
			$query=$this->db->query("select * from $tabel where $seleksi='$cari'");
			return $query;

		}
		
		function Sum_Pilih($tabel,$kolom,$seleksi)
		{
			$query=$this->db->query("select sum($kolom) AS sum from $tabel where $seleksi");
			return $query;
		}
		
		function Max($max,$tabel,$seleksi)
		{
			$query=$this->db->query("select max($max) AS max from $tabel where $seleksi");
			return $query;
		}

		function Min($min,$tabel,$seleksi)
		{
			$query=$this->db->query("select min($min) AS min from $tabel where $seleksi");
			return $query;
		}

		function Selection($select, $from, $where)
		{
			$q=$this->db->query("select $select from $from where $where");
			return $q;
		}

		function Query($query)
		{
			$q=$this->db->query($query);
			return $q;	
		}
		

		function password($username='')
		{
			$query = $this->db->get_where('user', array('username' => $username));

			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 

			   return $row->password;
			}
			else
				return 'notfound';
		}

		function change_password($username, $data)
		{
			$this->db->update('user', $data, array('username' => $username));
		}
	}
?>