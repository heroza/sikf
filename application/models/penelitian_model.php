<?php
class Penelitian_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function getIdProdi($kode_penelitian)
		{
			$query=$this->db->query("select id_prodi from penelitian where kode_penelitian='$kode_penelitian'");
			foreach($query -> result_array() as $item) 
			{ $id_prodi = $item['id_prodi']; }
			return $id_prodi;
		}

		function getDeskripsiById($id_mahasiswa)
		{
			$query=$this->db->query("select nim,nama from mahasiswa where id_mahasiswa='$id_mahasiswa'");
			foreach($query -> result_array() as $item) 
			{ $desc = $item['nim'].'-'.$item['nama']; }
			return $desc;
		}

		function penelitianPerProdi()
		{
			$query=$this->db->query("SELECT prodi, sum(nilai) as nilai FROM penelitian LEFT JOIN prodi ON penelitian.id_prodi=prodi.id_prodi LEFT JOIN jenis_publikasi ON penelitian.jenis_publikasi=jenis_publikasi.jenis_publikasi GROUP BY prodi");
			return $query;
		}

		function count($sumber_dana, $tahun_pelaksanaan, $prodi)
		{
			$result=$this->db->query("select count(penelitian.kode_penelitian) as count from penelitian LEFT JOIN dosen_meneliti ON penelitian.kode_penelitian=dosen_meneliti.kode_penelitian LEFT JOIN dosen ON dosen_meneliti.kode_dosen=dosen.kode_dosen LEFT JOIN prodi ON dosen.id_prodi=prodi.id_prodi where prodi = '$prodi' AND sumber_dana = '$sumber_dana' AND tahun_pelaksanaan = $tahun_pelaksanaan AND kode_meneliti_sebagai = 3");
			foreach($result -> result_array() as $c) {
				$count = $c['count'];	
			}
			return $count;	
		}

		function total_penelitian()
		{
			// $query=$this->db->query("select tahun_pelaksanaan, prodi, count(kode) as jumlah from dosen_meneliti, dosen, prodi, penelitian where dosen.id_prodi = prodi.id_prodi AND kode_meneliti_sebagai = 3 AND dosen_meneliti.kode_dosen = dosen.kode_dosen AND penelitian.kode_penelitian = dosen_meneliti.kode_penelitian GROUP BY prodi.id_prodi");
			$query=$this->db->query("select tahun_pelaksanaan, prodi, count(kode) as jumlah from dosen_meneliti, dosen, prodi, penelitian where dosen.id_prodi = prodi.id_prodi AND kode_meneliti_sebagai = 3 AND dosen_meneliti.kode_dosen = dosen.kode_dosen AND penelitian.kode_penelitian = dosen_meneliti.kode_penelitian GROUP BY tahun_pelaksanaan, prodi");
			return $query;
		}

		function total_penelitian_group($prodi)
		{
			$query=$this->db->query("select tahun_pelaksanaan, count(kode) as jumlah from dosen_meneliti, dosen, prodi, penelitian where dosen.id_prodi = prodi.id_prodi AND prodi = '$prodi' AND kode_meneliti_sebagai = 3 AND dosen_meneliti.kode_dosen = dosen.kode_dosen AND penelitian.kode_penelitian = dosen_meneliti.kode_penelitian GROUP BY tahun_pelaksanaan");
			return $query;
		}

		function penelitianByDosen($kode_dosen)
		{
			$query=$this->db->query("SELECT * FROM penelitian LEFT JOIN dosen_meneliti ON penelitian.kode_penelitian=dosen_meneliti.kode_penelitian WHERE kode_dosen = '$kode_dosen'");
			return $query->result();
		}

		function penelitianApiByDosen($kode_dosen)
		{
			// $query=$this->db->query("SELECT tahun_pelaksanaan AS tahun, judul, group_concat(nama order by kode_meneliti_sebagai ASC separator ', ') AS peneliti, dosen_meneliti.kode_dosen FROM penelitian JOIN dosen_meneliti ON penelitian.kode_penelitian=dosen_meneliti.kode_penelitian JOIN dosen ON dosen.kode_dosen=dosen_meneliti.kode_dosen GROUP BY penelitian.kode_penelitian HAVING dosen_meneliti.kode_dosen=".$kode_dosen);
			$query=$this->db->query("SELECT tahun_pelaksanaan AS tahun, judul, group_concat(nama order by kode_meneliti_sebagai ASC separator ', ') AS peneliti FROM penelitian JOIN dosen_meneliti ON penelitian.kode_penelitian=dosen_meneliti.kode_penelitian JOIN dosen ON dosen.kode_dosen=dosen_meneliti.kode_dosen WHERE penelitian.kode_penelitian IN (SELECT dosen_meneliti.kode_penelitian FROM dosen_meneliti WHERE dosen_meneliti.kode_dosen=".$kode_dosen.") GROUP BY penelitian.kode_penelitian order by kode ASC");
			return $query->result();
		}

		function jumlahPenelitianProdi($id_prodi)
		{
			$query=$this->db->query("SELECT count(distinct penelitian.kode_penelitian) as jumlah from dosen_meneliti join penelitian on penelitian.kode_penelitian=dosen_meneliti.kode_penelitian join dosen on dosen_meneliti.kode_dosen=dosen.kode_dosen WHERE id_prodi='$id_prodi'");
			$row = $query->row(); 
			return $row->jumlah;
		}

		function jumlahPenelitianProdiSejakTahun($id_prodi, $tahunstring)
		{
			$tahun = intval($tahunstring);
			$query=$this->db->query("SELECT count(distinct penelitian.kode_penelitian) as jumlah from dosen_meneliti join penelitian on penelitian.kode_penelitian=dosen_meneliti.kode_penelitian join dosen on dosen_meneliti.kode_dosen=dosen.kode_dosen WHERE id_prodi='$id_prodi' AND tahun_pelaksanaan>=$tahun");
			$row = $query->row(); 
			return $row->jumlah;
		}

		function jumlahPenelitianProdiPerTahun($id_prodi, $tahunstring)
		{
			$tahun = intval($tahunstring);
			$sql = "SELECT tahun_pelaksanaan as tahun, count(distinct penelitian.kode_penelitian) as jumlah from dosen_meneliti join penelitian on penelitian.kode_penelitian=dosen_meneliti.kode_penelitian join dosen on dosen_meneliti.kode_dosen=dosen.kode_dosen WHERE id_prodi=$id_prodi AND tahun_pelaksanaan>=$tahun GROUP BY tahun_pelaksanaan";
			$query=$this->db->query($sql);
			return $query->result();
		}

		function jumlahPenelitianProdiPerTahunBySumber($id_prodi, $tahunstring, $sumber_dana)
		{
			$tahun = intval($tahunstring);
			$sql = "SELECT tahun_pelaksanaan as tahun, count(distinct penelitian.kode_penelitian) as jumlah from dosen_meneliti join penelitian on penelitian.kode_penelitian=dosen_meneliti.kode_penelitian join dosen on dosen_meneliti.kode_dosen=dosen.kode_dosen WHERE id_prodi=$id_prodi AND tahun_pelaksanaan>=$tahun AND sumber_dana=$sumber_dana GROUP BY tahun_pelaksanaan";
			$query=$this->db->query($sql);
			return $query->result();
		}

		function penelitianTerbaru($limit = 0)
		{
			$sql = "SELECT * FROM  `penelitian` ORDER BY tahun_pelaksanaan DESC , kode_penelitian DESC LIMIT 0, $limit";
			$query=$this->db->query($sql);
			return $query->result();
		}
	}
?>