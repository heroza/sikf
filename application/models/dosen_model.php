<?php
class Dosen_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function dosenWithStatus($status)
		{
			$result=$this->db->query("SELECT nama FROM dosen WHERE status = $status");
			return $result;
		}

		function dosenApiWithKode($kode_dosen)
		{
			$result=$this->db->query("SELECT kode_dosen, nama, nip, nidn, no_sertifikat, tempat_lahir, tanggal_lahir, jabatan_akademik, gelar_depan, gelar_belakang, s1, s2, s3, bidang_keahlian, email, foto FROM dosen WHERE kode_dosen = $kode_dosen");
			return $result->row();
		}

		function dosenWithKode($kode_dosen)
		{
			$result=$this->db->query("SELECT * FROM dosen WHERE kode_dosen = $kode_dosen");
			return $result->row();
		}

		function dosenByUsername($username)
		{
			$result=$this->db->query("SELECT * FROM dosen WHERE username = $username");
			return $result->row();
		}

		function dosenProdiWithStatus($id_prodi, $status)
		{
			$result=$this->db->query("SELECT * FROM dosen WHERE id_prodi = $id_prodi AND status = $status ");
			return $result;
		}

		function password($kode_dosen='')
		{
			$query = $this->db->get_where('dosen', array('kode_dosen' => $kode_dosen));

			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 

			   return $row->password;
			}
			else
				return 'notfound';
		}

		function change_password($kode_dosen, $data)
		{
			$this->db->update('dosen', $data, array('kode_dosen' => $kode_dosen));
		}
	}
?>