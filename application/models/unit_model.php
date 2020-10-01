<?php
class Unit_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function Count_Data($tabel,$seleksi)
		{
			$query=$this->db->query("select count(kode_penelitian) as count from $tabel where $seleksi");
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
		
		function Tugas_Auditor($seleksi)
		{
			$query=$this->db->query("select * from tugas_auditor LEFT JOIN penugasan ON tugas_auditor.id_penugasan = penugasan.id_penugasan LEFT JOIN auditor ON tugas_auditor.id_auditor = auditor.id_auditor where tugas_auditor.id_penugasan = $seleksi");
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
		
		function Prodi()
		{
			$q=$this->db->query("select * from tbl_prodi left join tbl_fakultas on tbl_prodi.id_fakultas=tbl_fakultas.id_fakultas order by tbl_fakultas.id_fakultas");
			return $q;
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
		
		function Rubrik($id)
		{
			$query=$this->db->query("select standar.id_standar, standar.standar, Count(id_rubrik) as jumlah from rubrik, standar where rubrik.id_instrumen = $id AND standar.id_standar = rubrik.id_standar group by rubrik.id_standar");
			return $query;
		}
		
		function Laporan_All()
		{
			$query=$this->db->query("select jadwal.id_jadwal, auditee.prodi, instrumen.instrumen, jadwal.validasi_auditee, jadwal.validasi_auditor from jadwal, auditee, instrumen where jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen");
			return $query;
		}
		
		function Pilih_Laporan_Fakultas($id2)
		{
			$query=$this->db->query("select jadwal.id_jadwal, auditee.prodi, instrumen.instrumen, jadwal.validasi_auditee, jadwal.validasi_auditor from jadwal, auditee, instrumen where auditee.id_fakultas = $id2 AND  jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen");
			return $query;
		}
		
		function Pilih_Laporan_Periode($id)
		{
			$query=$this->db->query("select jadwal.id_jadwal, auditee.prodi, instrumen.instrumen, jadwal.validasi_auditee, jadwal.validasi_auditor from jadwal, auditee, instrumen where jadwal.id_periode = $id AND  jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen");
			return $query;
		}
		
		function Pilih_Laporan($id, $id2)
		{
			$query=$this->db->query("select jadwal.id_jadwal, auditee.prodi, instrumen.instrumen, jadwal.validasi_auditee, jadwal.validasi_auditor from jadwal, auditee, instrumen where jadwal.id_periode = $id AND auditee.id_fakultas = $id2 AND  jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen");
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
		
		function Standar_Rubrik($id)
		{
			$query=$this->db->query("select standar.id_standar, standar.standar, Count(id_rubrik) as jumlah from rubrik, standar where rubrik.id_instrumen = $id AND standar.id_standar = rubrik.id_standar group by rubrik.id_standar");
			return $query;
		}
		function Perspektif_Bsc($id)
		{
			$query=$this->db->query("select standar.id_perspektif, perspektif from strategi, standar_strategi,standar, perspektif where strategi.id_visimisi = $id AND standar_strategi.id_strategi = strategi.id_strategi AND standar.id_standar = standar_strategi.id_standar AND perspektif.id_perspektif = standar.id_perspektif group by standar.id_perspektif");
			return $query;
		}
		function Standar_Rubrik_Bsc($id,$id2,$id3)
		{
			$query=$this->db->query("select standar.id_standar, standar.standar, Count(id_rubrik) as jumlah from rubrik, standar, standar_strategi where rubrik.id_instrumen = $id AND standar.id_standar = rubrik.id_standar AND standar.id_standar = standar_strategi.id_standar AND standar.id_perspektif = $id2 AND standar_strategi.id_strategi = $id3 group by rubrik.id_standar");
			return $query;
		}
		function Strategi_Bsc($id)
		{
			$query=$this->db->query("select strategi, id_strategi from instrumen, strategi where id_instrumen = $id AND strategi.id_visimisi = instrumen.id_visimisi");
			return $query;
		}	


		function password($id_unit='')
		{
			$query = $this->db->get_where('unit', array('id_unit' => $id_unit));

			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 

			   return $row->password;
			}
			else
				return 'notfound';
		}
		function change_password($kode_user, $data)
		{
			$this->db->update('unit', $data, array('id_unit' => $kode_user));
		}
		
		function unitByUsername($username)
		{
			$query=$this->db->query("SELECT * FROM unit WHERE username = '$username'");
			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 
			}
			return $row;
		}
	}
?>