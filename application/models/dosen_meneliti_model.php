<?php
class Dosen_meneliti_model extends CI_Model
	{
		private $table = 'dosen_meneliti';
		function __construct()
		{
			parent::__construct();
		}

		function insert($datainsert)
		{
			$this->db->insert('dosen_meneliti',$datainsert);
		}
		
		function getByKodePenelitian($kode_penelitian)
		{
			$query=$this->db->query("select * from dosen_meneliti where kode_penelitian='$kode_penelitian'");
			return $query;
		}
		
		function getNamaPenelitiByKodePenelitian($kode_penelitian)
		{
			$str = "select nama from dosen_meneliti LEFT JOIN dosen on dosen_meneliti.kode_dosen = dosen.kode_dosen where kode_penelitian=".$kode_penelitian." ORDER BY dosen_meneliti.kode_meneliti_sebagai ASC ";
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