<?php
class Publikasi_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function getByKodePenelitian($kode_penelitian)
		{
			$query=$this->db->query("select * from publikasi where kode_penelitian='$kode_penelitian'");
			return $query;
		}
		
		function getIdProdiByKodePublikasi($kode_publikasi)
		{
			$query=$this->db->query("select id_prodi from publikasi LEFT JOIN penelitian ON publikasi.kode_penelitian = penelitian.kode_penelitian where publikasi.kode_publikasi='$kode_publikasi'");
			foreach($query -> result_array() as $item) 
			{ $id_prodi = $item['id_prodi']; }
			return $id_prodi;
		}
		
		function getByKodePublikasi($kode_publikasi)
		{
			$query=$this->db->query("select publikasi.penelitian as penelitian from publikasi LEFT JOIN penelitian ON publikasi.penelitian = penelitian.kode_penelitian where publikasi.kode_publikasi='$kode_publikasi'");
			return $query;
		}

		function publikasiPerProdi()
		{
			$query=$this->db->query("SELECT prodi, sum(nilai) as nilai FROM publikasi LEFT JOIN penelitian ON publikasi.kode_penelitian=penelitian.kode_penelitian LEFT JOIN prodi ON penelitian.id_prodi=prodi.id_prodi LEFT JOIN jenis_publikasi ON publikasi.jenis_publikasi=jenis_publikasi.jenis_publikasi GROUP BY prodi");
			return $query;
		}

		function publikasiByDosen($kode_dosen)
		{
			$query=$this->db->query("SELECT * FROM publikasi LEFT JOIN penulis ON publikasi.kode_publikasi=penulis.kode_publikasi WHERE kode_dosen = '$kode_dosen'");
			return $query->result();
		}

		function publikasiApiByDosen($kode_dosen)
		{
			$query=$this->db->query("SELECT tahun, judul, tempat, group_concat(nama order by kode_penulis_sebagai ASC separator ', ') AS penulis FROM publikasi JOIN penulis ON publikasi.kode_publikasi=penulis.kode_publikasi JOIN dosen ON dosen.kode_dosen=penulis.kode_dosen WHERE publikasi.kode_publikasi IN (SELECT penulis.kode_publikasi FROM penulis WHERE penulis.kode_dosen=".$kode_dosen.") GROUP BY publikasi.kode_publikasi order by kode ASC");
			return $query->result();
		}

		function publikasiProdiSejakTahun($id_prodi, $tahun)
		{
			$query=$this->db->query("SELECT judul, tempat, tahun, tingkat, group_concat(nama order by kode_penulis_sebagai ASC separator ', ') AS penulis from penulis join publikasi on publikasi.kode_publikasi=penulis.kode_publikasi join dosen on penulis.kode_dosen=dosen.kode_dosen WHERE id_prodi=$id_prodi AND tahun>=$tahun GROUP BY publikasi.kode_publikasi");
			return $query->result();
		}

		function jumlahPublikasiProdiSejakTahun($id_prodi, $tahunstring)
		{
			$tahun = intval($tahunstring);
			$query=$this->db->query("SELECT count(distinct publikasi.kode_publikasi) as jumlah from penulis join publikasi on publikasi.kode_publikasi=penulis.kode_publikasi join dosen on penulis.kode_dosen=dosen.kode_dosen WHERE id_prodi='$id_prodi' AND tahun>=$tahun");
			$row = $query->row(); 
			return $row->jumlah;
		}

		function jumlahPublikasiProdiPerTahun($id_prodi, $tahunstring)
		{
			$tahun = intval($tahunstring);
			$sql = "SELECT tahun, count(distinct publikasi.kode_publikasi) as jumlah from penulis join publikasi on publikasi.kode_publikasi=penulis.kode_publikasi join dosen on penulis.kode_dosen=dosen.kode_dosen WHERE id_prodi=$id_prodi AND tahun>=$tahun GROUP BY tahun";
			$query=$this->db->query($sql);
			return $query->result();
		}
	}
?>