<?php
class Dosen_mengabdi_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function getByKodePengabdianMasyarakat($kode_pengabdian_masyarakat)
		{
			$query=$this->db->query("select * from dosen_mengabdi where kode_pengabdian_masyarakat='$kode_pengabdian_masyarakat'");
			return $query;
		}

		function insert($datainsert)
		{
			$this->db->insert('dosen_mengabdi',$datainsert);
		}
		
		function getNamaPengabdiByKodePengabdian($kode_pengabdian_masyarakat)
		{
			$str = "select nama from dosen_mengabdi LEFT JOIN dosen on dosen_mengabdi.kode_dosen = dosen.kode_dosen where kode_pengabdian_masyarakat=".$kode_pengabdian_masyarakat." ORDER BY dosen_mengabdi.kode_mengabdi_sebagai ASC ";
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