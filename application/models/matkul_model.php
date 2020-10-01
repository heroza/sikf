<?php
class Matkul_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function matkulProdi($id_prodi)
		{
			$result=$this->db->query("SELECT * FROM matkul WHERE id_prodi = $id_prodi ORDER BY  semester ASC ");
			return $result;
		}

		function matkulByKurikulum($kode_kurikulum, $jenis = '')
		{
			$result=$this->db->query("SELECT * FROM matkul WHERE kode_kurikulum = '$kode_kurikulum' AND is_pilihan = '$jenis'");
			return $result;
		}
	}
?>