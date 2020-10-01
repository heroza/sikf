<?php
class Penulis_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function insert($datainsert)
		{
			$this->db->insert('penulis',$datainsert);
		}
		
		function getByKodePublikasi($kode_publikasi)
		{
			$query=$this->db->query("select * from penulis where kode_publikasi='$kode_publikasi'");
			return $query;
		}
		
		function getNamaPenulisByKodePublikasi($kode_publikasi)
		{
			$str = "select nama from penulis LEFT JOIN dosen on penulis.kode_dosen = dosen.kode_dosen where kode_publikasi=".$kode_publikasi." ORDER BY penulis.kode_penulis_sebagai ASC ";
			// echo($str);
			$query=$this->db->query($str);
			$hasil = array();
			foreach ($query->result() as $row)
			{
			   $hasil[] = $row->nama;
			}
			if (count($hasil) == 0) {
				return "-";
			}
			else
				return implode(" | ", $hasil);
		}
	}
?>