<?php
class Jadwal_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function tahun($id_jadwal)
		{
			$result=$this->db->query("SELECT tahun FROM jadwal LEFT JOIN periode ON jadwal.id_periode=periode.id_periode WHERE id_jadwal = $id_jadwal");

			foreach($result -> result_array() as $c) {
				$tahun = $c['tahun'];	
			}
			return $tahun;
		}

		function prodi($id_jadwal)
		{
			$result=$this->db->query("SELECT prodi FROM jadwal LEFT JOIN auditee ON jadwal.id_auditee=auditee.id_auditee WHERE id_jadwal = $id_jadwal");

			foreach($result -> result_array() as $c) {
				$prodi = $c['prodi'];	
			}
			return $prodi;
		}
	}
?>