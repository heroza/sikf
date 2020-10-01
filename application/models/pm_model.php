<?php
class Pm_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function pmByDosen($kode_dosen)
		{
			$query=$this->db->query("SELECT * FROM pengabdian_masyarakat LEFT JOIN dosen_mengabdi ON pengabdian_masyarakat.kode_pengabdian_masyarakat=dosen_mengabdi.kode_pengabdian_masyarakat WHERE kode_dosen = '$kode_dosen'");
			return $query->result();
		}

		function pmApiByDosen($kode_dosen)
		{
			$query=$this->db->query("SELECT tahun_pelaksanaan AS tahun, judul, group_concat(nama order by kode_mengabdi_sebagai ASC separator ', ') AS pengabdi FROM pengabdian_masyarakat JOIN dosen_mengabdi ON pengabdian_masyarakat.kode_pengabdian_masyarakat=dosen_mengabdi.kode_pengabdian_masyarakat JOIN dosen ON dosen.kode_dosen=dosen_mengabdi.kode_dosen WHERE pengabdian_masyarakat.kode_pengabdian_masyarakat IN (SELECT dosen_mengabdi.kode_pengabdian_masyarakat FROM dosen_mengabdi WHERE dosen_mengabdi.kode_dosen=".$kode_dosen.") GROUP BY pengabdian_masyarakat.kode_pengabdian_masyarakat order by kode ASC");
			return $query->result();
		}

		function jumlahPmProdiPerTahunBySumber($id_prodi, $tahun, $sumber_dana)
		{
			$sql = "SELECT tahun_pelaksanaan as tahun, count(distinct pengabdian_masyarakat.kode_pengabdian_masyarakat) as jumlah from dosen_mengabdi join pengabdian_masyarakat on pengabdian_masyarakat.kode_pengabdian_masyarakat=dosen_mengabdi.kode_pengabdian_masyarakat join dosen on dosen_mengabdi.kode_dosen=dosen.kode_dosen WHERE id_prodi=$id_prodi AND tahun_pelaksanaan>=$tahun AND sumber_dana=$sumber_dana GROUP BY tahun_pelaksanaan";
			$query=$this->db->query($sql);
			return $query->result();
		}
	}
?>