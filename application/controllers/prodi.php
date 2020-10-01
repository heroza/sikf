<?php
class prodi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->database();
		$this->load->helper(array('form','url','cookie','date'));
		$this->load->library(array('grocery_CRUD','Pagination'));
		$this->load->model('Prodi_model');
		$this->load->model('Dosen_model');
		$this->load->model('Dosen_meneliti_model');
		$this->load->model('Dosen_mengabdi_model');
		$this->load->model('Penelitian_model');
		$this->load->model('Publikasi_model');
		$this->load->model('Penulis_model');
		$this->load->model('Kurikulum_model');
		$this->load->model('Pa_model');
		$this->load->model('Other_model');
		$this->input->set_cookie();
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function index()
	{
		$data = array();
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$data["id_prodi"]=$prodi->id_prodi;
			$data["prodi"]=$prodi->prodi;
		
			$data["info"] = $this->Other_model->Pilih_Content('informasi','id_informasi = 1');
			$this->load->view('prodi/part_atas',$data);
			$this->load->view('prodi/part_kiri');
			$this->load->view('prodi/index');
			$this->load->view('prodi/part_bawah');
			$this->load->view('prodi/part_js');
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}	
	}
	
	function borang()
	{
		$data = array();
		date_default_timezone_set('Asia/Jakarta');
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$data["id_prodi"]=$prodi->id_prodi;
			$data["prodi"]=$prodi->prodi;
		
			$this->load->view('prodi/part_atas',$data);
			$this->load->view('prodi/part_kiri');
			$this->load->view('prodi/borang');
			$this->load->view('prodi/part_bawah');
		// $this->load->view('prodi/part_js');
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}	
	}
	
	function main($output = null, $data = null)
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$data["id_prodi"]=$prodi->id_prodi;
			$data["prodi"]=$prodi->prodi;
		
			$this->load->view('prodi/part_atas',$data);
			$this->load->view('prodi/part_kiri');
			$this->load->view('prodi/part_isi',$output);
			$this->load->view('prodi/part_bawah');
			$this->load->view('prodi/part_js_other');	
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}
	
	function cekid()
	{   
		$cari='';
		if ($this->uri->segment(3) === FALSE)
		{
    			$cari= $_GET['q'];
		}
		else
		{
    			$cari = $this->uri->segment(3);
		}
		$tabel = "prodi";
		$seleksi = "username"; 
		$hasil = $this->Prodi_model->Cek($tabel,$seleksi,$cari);
		if (count($hasil->result_array())==0){
			echo "<br><font color='#00FF00'>Username ' $cari ' belum digunakan, silahkan melanjutkan mengisi form </font>";
   		}else{
    		echo "<br><blink><font color='#FF0000'>Maaf, username ' $cari ' sudah digunakan, silahkan ganti dengan yang lain</font></blink>";
    	}
	}
	
	function logout()
	{
		unset($_SESSION['prodi_session']);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}

	function matkul()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			// $prodi = $this->Prodi_model->prodiByUsername($username);
			// $id_prodi = $prodi->id_prodi;
			// $prodi = $prodi->prodi;
			// $kode_kurikulum = $this->Kurikulum_model->kurikulum_berlaku_prodi($id_prodi);

			$data = array();
			$data['title'] = 'Mata Kuliah';
			// $data['crumbs'] = array('');
			// $data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('matkul');
			// $crud->where('matkul.kode_kurikulum',$kode_kurikulum);
			// $crud->set_subject('Mata Kuliah');
			// $crud->required_fields('kode', 'mata_kuliah', 'sks', 'semester');
			// $crud->set_field_upload('deskripsi','assets/uploads/files');
			// $crud->set_field_upload('silabus','assets/uploads/files');
			// $crud->set_field_upload('sap','assets/uploads/files');
			// $crud->field_type('kode_kurikulum', 'hidden', $kode_kurikulum);
			// $crud->columns('semester', 'kode', 'mata_kuliah', 'sks', 'deskripsi', 'silabus', 'sap');
			// $crud->display_as('sap','SAP');
			// $crud->display_as('sks','SKS');
			// $crud->display_as('sks_inti','SKS Inti');
			// $crud->display_as('sks_institusional','SKS Institusional');
			// $crud->display_as('is_bobot_20','Bobot tugas >= 20%');
			// $crud->display_as('is_pilihan','Wajib/Pilihan');
				 
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function data_deskripsi()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;

			$data = array();
			$data['title'] = 'Data Deskripsi';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('deskripsi');
			$crud->where('id_prodi',$id_prodi);
			$crud->set_subject('Data Deskripsi');
			$crud->columns('nama', 'isian');
			$crud->order_by('prioritas','asc');
			$crud->unset_texteditor('isian','full_text');

			$crud->unset_add()
				 ->unset_delete();
				 
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function praktikum()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;
			
			$kode_kurikulum = $this->Kurikulum_model->kurikulum_berlaku_prodi($id_prodi);

			$data = array();
			$data['title'] = 'Praktikum';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('praktikum');
			$crud->set_subject('Praktikum');
			$crud->set_model('praktikum_prodi_x_model');
		    $this->praktikum_prodi_x_model->set_kode_kurikulum($kode_kurikulum);
			$crud->required_fields('kode', 'matkul');
			$crud->set_relation('matkul','matkul','mata_kuliah', array('matkul.kode_kurikulum' => $kode_kurikulum));
			$crud->display_as('sks','SKS')
				 ->display_as('matkul','Mata Kuliah Terkait');
			// $crud->columns('kode', 'nama', 'sks', 'matkul', 'kode_kurikulum');
			// $crud->where('matkul.kode_kurikulum',$kode_kurikulum);

			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function perbaikan_pembelajaran()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			
			$data = array();
			$data['title'] = 'Perbaikan Pembelajaran';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->where('id_prodi',$id_prodi);
			$crud->set_table('upaya_perbaikan_pembelajaran');
			$crud->set_subject('Perbaikan Pembelajaran');
			$crud->field_type('id_prodi', 'hidden', $id_prodi);
			$crud->columns('butir', 'tindakan', 'hasil');
			$crud->unset_texteditor('hasil','full_text');

			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function data_dosen()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;

			$data = array();
			$data['title'] = 'Data Dosen';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('dosen');
			$crud->set_subject('Data Dosen');
			$crud->set_relation('id_prodi','prodi','prodi');
			$crud->where('prodi',$prodi);
			$crud->set_relation('status','status_dosen','deskripsi');
			$crud->required_fields('nama', 'id_prodi', 'status');
			$crud->field_type('id_prodi', 'hidden', $id_prodi);
			$crud->columns('nama', 'nip', 'nidn', 'status');

			$crud->display_as('nip','NIP')
				 ->display_as('nidn','NIDN');

			$crud->unset_add()
				 ->unset_edit()
				 ->unset_delete();
				 
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function kelompok_pa()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;

			$data = array();
			$data['title'] = 'Data Pembimbing Akademik';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('kelompok_pa');
			$crud->set_subject('Data PA');
			$crud->required_fields('nama_kelompok');		
			$crud->where('id_prodi',$id_prodi);
			$crud->columns('nama_kelompok','sk', 'detail_kelompok');
			$crud->display_as('sk','SK');
			$crud->set_field_upload('sk','assets/uploads/sk/pa');
			$crud->callback_column('detail_kelompok',array($this,'_callback_daftar_pa')); 

			$output = $crud->render();
			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function pa($id_kelompok = 0)
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;

			$data = array();
			$data['title'] = 'Data Pembimbing Akademik';
			$data['crumbs'] = array('Kelompok PA','Daftar PA');
			$data['crumbs_link'] = array('prodi/kelompok_pa','');
			$crud = new grocery_CRUD();
			$crud->set_table('pa');
			$crud->set_subject('Data PA');
			$crud->set_relation('kode_dosen','dosen','nama',array('dosen.id_prodi' => $id_prodi));
			// $crud->set_relation('nim_mahasiswa','mahasiswa','nama',array('mahasiswa.id_prodi' => $id_prodi));
			$crud->field_type('id_kelompok', 'hidden', $id_kelompok);
			$crud->columns('kode_dosen', 'nim_mahasiswa');
			$crud->where('id_kelompok',$id_kelompok);
			
			$crud->required_fields('nip_dosen', 'nim_mahasiswa');
			
				 
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function ta()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;

			$data = array();
			$data['title'] = 'Data Tugas Akhir';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('ta');
			$crud->set_subject('Data TA');
			//$crud->set_relation('nim_mahasiswa','mahasiswa','nama',array('mahasiswa.id_prodi' => $id_prodi));
			$crud->set_relation('pembimbing1','dosen','nama');
			$crud->set_relation('pembimbing2','dosen','nama');
			$crud->columns('judul', 'nim_mahasiswa', 'pembimbing1', 'pembimbing2', 'waktu_mulai');
			$crud->required_fields('judul', 'nim_mahasiswa');	
			$crud->set_field_upload('sk_pembimbing','assets/uploads/sk');
			$crud->display_as('nim_mahasiswa', 'NIM Mahasiswa');	
			$crud->display_as('pembimbing1', 'Pembimbing pertama');
			$crud->display_as('pembimbing2', 'Pembimbing kedua');
			// $crud->display_as('sk', 'SK');
				 
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function anggotapenelitian()
	{
		$kode_penelitian = $this->uri->segment(3);
		$id_prodi = $this->Penelitian_model->getIdProdi($kode_penelitian);

		$data = array();
		$data['title'] = 'Anggota Penelitian';
		$data['crumbs'] = array('Penelitian','Anggota Penelitian');
		$data['crumbs_link'] = array('prodi/penelitian','');
		$crud = new grocery_CRUD();
		$crud->set_table('dosen_meneliti');
		$crud->set_subject('Anggota Penelitian');
		$crud->set_relation('kode_penelitian','penelitian','judul');
		$crud->set_relation('kode_dosen','dosen','nama',array('dosen.id_prodi' => $id_prodi));
		$crud->set_relation('kode_meneliti_sebagai','meneliti_sebagai','nama');
		$crud->required_fields('kode_penelitian','kode_dosen','kode_meneliti_sebagai');
		$crud->columns('kode_penelitian','kode_dosen','kode_meneliti_sebagai');
		$crud->display_as('kode_penelitian','Penelitian');
		$crud->display_as('kode_dosen','Dosen');
		$crud->display_as('kode_meneliti_sebagai','Meneliti sebagai');

		$crud->field_type('kode_penelitian', 'hidden', $kode_penelitian);
		$crud->where('dosen_meneliti.kode_penelitian',$kode_penelitian);
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function penulis()
	{
		$kode_publikasi = $this->uri->segment(3);
		$publikasi = $this->Publikasi_model->getByKodePublikasi($kode_publikasi);
		$id_prodi = 0; 
		$kode_penelitian = 0; 
		foreach($publikasi -> result_array() as $item) 
		{
			$id_prodi = $item['id_prodi']; 
			$kode_penelitian = $item['kode_penelitian']; 
		}

		$data = array();
		$data['title'] = 'Penulis Publikasi';
		$data['crumbs'] = array('Penelitian','Publikasi','Penulis');
		$data['crumbs_link'] = array('prodi/penelitian','prodi/publikasi/'.$kode_penelitian,'');
		$crud = new grocery_CRUD();
		$crud->set_table('penulis');
		$crud->set_subject('Penulis');
		$crud->set_relation('kode_publikasi','publikasi','judul');
		$crud->set_relation('kode_dosen','dosen','nama',array('dosen.id_prodi' => $id_prodi));
		$crud->set_relation('kode_penulis_sebagai','penulis_sebagai','nama');
		$crud->required_fields('kode_publikasi','kode_dosen','kode_penulis_sebagai');
		$crud->columns('kode_publikasi','kode_dosen','kode_penulis_sebagai');
		$crud->display_as('kode_publikasi','Publikasi');
		$crud->display_as('kode_dosen','Dosen');
		$crud->display_as('kode_penulis_sebagai','Penulis sebagai');

		$crud->field_type('kode_publikasi', 'hidden', $kode_publikasi);
		$crud->where('penulis.kode_publikasi',$kode_publikasi);
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function penelitian()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;
		}
		else
		{
			?>
				<script type="text/javascript" language="javascript">
					alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
				</script>
			<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}

		$data = array();
		$data['title'] = 'Penelitian';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud = new grocery_CRUD();
		$crud->set_table('penelitian');
		$crud->set_subject('Penelitian');
	    // $crud->set_model('penelitian_prodi_x_model');
	    // $this->penelitian_prodi_x_model->set_kode_prodi($id_prodi);
		$crud->set_relation('skim','skim','deskripsi');
		$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
		$crud->required_fields('judul');
		$crud->set_field_upload('file_laporan','assets/uploads/files');
		$crud->columns('judul','tahun_pelaksanaan', 'file_laporan', 'peneliti');
		$crud->callback_column('peneliti',array($this,'_callback_peneliti')); 
		$crud->display_as('tahun_pelaksanaan','Tahun');

		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$output = $crud->render();
		$this->main($output,$data);
	}

	function pm()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;
		}
		else
		{
			?>
				<script type="text/javascript" language="javascript">
					alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
				</script>
			<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}

		$data = array();
		$data['title'] = 'Pengabdian Masyarakat';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud = new grocery_CRUD();
		$crud->set_table('pengabdian_masyarakat');
		$crud->set_subject('Pengabdian Masyarakat');
	    // $crud->set_model('penelitian_prodi_x_model');
	    // $this->penelitian_prodi_x_model->set_kode_prodi($id_prodi);
		// $crud->set_relation('skim','skim','deskripsi');
		$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
		$crud->required_fields('judul');
		$crud->set_field_upload('file','assets/uploads/files');
		$crud->columns('judul','tahun_pelaksanaan', 'file', 'pengabdi');
		$crud->callback_column('pengabdi',array($this,'_callback_pengabdi')); 
		$crud->display_as('tahun_pelaksanaan','Tahun');

		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$output = $crud->render();
		$this->main($output,$data);
	}

	function publikasi()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
			$prodi = $prodi->prodi;
		}
		else
		{
			?>
				<script type="text/javascript" language="javascript">
					alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
				</script>
			<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}

		$data = array();
		$data['title'] = 'Publikasi';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud = new grocery_CRUD();
		$crud->set_table('publikasi');
		$crud->set_subject('Publikasi');
	    // $crud->set_model('publikasi_prodi_x_model');
	    // $this->publikasi_prodi_x_model->set_kode_prodi($id_prodi);
		$crud->set_relation('tingkat','tingkat','deskripsi');
		$crud->set_relation('jenis_publikasi','jenis_publikasi','deskripsi');
		$crud->required_fields('judul');
		$crud->set_field_upload('file','assets/uploads/files');
		$crud->columns('judul', 'tahun', 'file', 'penulis');
		$crud->callback_column('penulis',array($this,'_callback_penulis')); 
		$crud->display_as('tahun_pelaksanaan','Tahun');
		$crud->display_as('url','URL');
		$crud->display_as('tempat','Publisher');
	
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$output = $crud->render();
		$this->main($output,$data);
	}

	function _callback_peneliti($value, $row)
	{
		$namaArray = $this->Dosen_meneliti_model->getNamaPenelitiByKodePenelitian($row->kode_penelitian);
		return "($namaArray)";
	}

	function _callback_pengabdi($value, $row)
	{
		$namaArray = $this->Dosen_mengabdi_model->getNamaPengabdiByKodePengabdian($row->kode_pengabdian_masyarakat);
		return "($namaArray)";
	}

	function _callback_penulis($value, $row)
	{
		$namaArray = $this->Penulis_model->getNamaPenulisByKodePublikasi($row->kode_publikasi);
		return "($namaArray)";
	}

	function _callback_publikasi($value, $row)
	{
		$hasil = $this->Publikasi_model->getByKodePenelitian($row->kode_penelitian);
		$jumlah = count($hasil->result_array());
				return "
			<a href='".site_url('prodi/publikasi/'.$row->kode_penelitian)."' title='Publikasi'><img src='".base_url()."asset/img/plus.png'> Publikasi ($jumlah)</a>
			";
	}

	function _callback_action($value, $row)
	{
				return "
			<a href='".site_url('prodi/kelolapenelitian/edit/'.$row->kode_penelitian)."' title='Edit Penelitian'><img src='".base_url()."asset/img/edit.png'></a>
			<a href='".site_url('prodi/penelitian/delete/'.$row->kode_penelitian)."' title='Delete Penelitian' class='delete-row' ><img src='".base_url()."asset/img/close.png'></a></p>"; 	
	}

	function _callback_daftar_pa($value, $row)
	{
		$hasil = $this->Pa_model->paByIdKelompok($row->id);
		$jumlah = count($hasil->result_array());
				return "
			<a href='".site_url('prodi/pa/'.$row->id)."' title='Daftar'><img src='".base_url()."asset/img/plus.png'> Daftar ($jumlah)</a>
			";
	}

	function kelolapenelitian()
	{
		$crud = new grocery_CRUD();
		$state=$crud->getState();
		if($state != 'edit' && $state!='update_validation' && $state!='add' && $state!='insert_validation')
		// if(false)
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."prodi/penelitian'>";
		}
		else
		{
			$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
			if($username!="")
			{
				$prodi = $this->Prodi_model->prodiByUsername($username);
				$id_prodi = $prodi->id_prodi;
				$prodi = $prodi->prodi;

				$data = array();
				$data['sub'] = 'Penelitian';
				$data['home'] = 'prodi';
				$data['sub_link'] = 'prodi/penelitian';
				$crud->set_table('penelitian');
				$crud->set_subject('Penelitian');
				$crud->columns('judul','tahun_pelaksanaan','skim', 'jumlah_dana', 'sumber_dana', 'tahun_publikasi', 'tingkat', 'Dosen_Peneliti');
				$crud->set_relation('skim','skim','deskripsi');
				$crud->set_relation('tingkat','tingkat','deskripsi');
				$crud->set_relation('jenis_publikasi','jenis_publikasi','deskripsi');
				$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
				$crud->set_relation_n_n('Dosen_Peneliti','dosen_meneliti','dosen','kode_penelitian','kode_dosen','nama',null,array('id_prodi' => $id_prodi));
				$crud->required_fields('judul');
				$crud->set_field_upload('file_publikasi','assets/uploads/files');
			  	$crud->callback_column('jumlah_dana',array($this,'format_currency_callback'));	
				$output = $crud->render();
				$this->main($output,$data);
			} else
			{
				?>
				<script type="text/javascript" language="javascript">
					alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
			}
		}
	}

	function format_currency_callback($value, $row){
		setlocale(LC_MONETARY, 'en_US');
		$value = money_format('%.0n', $value);
		$value = str_replace("$","Rp ",$value);
		$value = str_replace(",",".",$value);
		return $value;
	}

	function identitas()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
		
			$data = array();
			$data['title'] = 'Identitas';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->where('id_prodi',$id_prodi);
			$crud->set_table('prodi');
			$crud->set_subject('Identitas');
			$crud->set_relation('id_fakultas','fakultas','fakultas');
			// $crud->unset_columns('password','id_fakultas','sk_pendirian','jurusandepartemen','tanggal_sk_pendirian','penandatangan_sk_pendirian','waktu_mulai_penyelenggaraan','tanggal_sk_operasional','alamat','faks','sk_operasional','telp','homepage','email', 'mekanisme', 'visi', 'misi', 'tujuan', 'sasaran', 'sosialisasi', 'tatapamong', 'kepemimpinan', 'pengelolaan', 'penjaminanmutu');
			$crud->fields('prodi','nip', 'kaprodi', 'jurusandepartemen', 'jenjang', 'sk_pendirian', 'tanggal_sk_pendirian', 'penandatangan_sk_pendirian', 'waktu_mulai_penyelenggaraan', 'sk_operasional', 'tanggal_sk_operasional', 'peringkat_akreditasi', 'berlaku_akreditasi', 'sk_banpt', 'status', 'telp', 'email', 'alamat', 'faks', 'homepage');
			$crud->display_as('id_fakultas','Fakultas')
				->display_as('peringkat_akreditasi','Peringkat Akreditasi')
				->display_as('sk_akreditasi','Nomor SK Akreditasi')
				->display_as('berlaku_akreditasi','Masa Berlaku Akreditasi')
				->display_as('sk_pendirian','Nomor SK Pendirian')
				->display_as('tanggal_sk_pendirian','Tanggal SK Pendirian')
				->display_as('penandatangan_sk_pendirian','Pejabat Penandatangan SK Pendirian')
				->display_as('waktu_mulai_penyelenggaraan','Bulan & Tahun Dimulainya Penyelenggaraan')
				->display_as('sk_operasional','Nomor SK Izin Operasional')
				->display_as('tanggal_sk_operasional','Tanggal SK Izin Operasional')
				->display_as('sk_banpt','Nomor SK BAN-PT')
				->display_as('email','E-mail')
				->display_as('jurusandepartemen','Jurusan/Departemen')
				->display_as('prodi','Program Studi')
				->display_as('nip','NIP Kaprodi')
				->display_as('faks','Faksimili');

			$crud->unset_texteditor('alamat','full_text');
			$crud->unset_back_to_list();

			$state=$crud->getState();
			if($state == 'edit' || $state=='update_validation')
			{
				$crud->required_fields('prodi','username');
			}
			if($state=='add' || $state=='insert_validation')
			{
				$crud->required_fields('prodi','username','password');
			} 
			$crud->callback_field('username',array($this,'username_callback_admin'));
			$crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
			$crud->callback_before_insert(array($this,'insert_validasi'));
			$crud->callback_before_update(array($this,'update_validasi'));
			$crud->unset_add();
			$crud->unset_delete();
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function visimisi()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
		
			$data = array();
			$data['title'] = 'Visi Misi';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->where('id_prodi',$id_prodi);
			$crud->set_table('prodi');
			$crud->set_subject('Visi Misi');
			$crud->fields('mekanisme','visi', 'misi', 'tujuan', 'sasaran', 'sosialisasi');
			$crud->unset_texteditor('mekanisme','full_text');
			$crud->unset_texteditor('visi','full_text');
			$crud->unset_texteditor('misi','full_text');
			$crud->unset_texteditor('tujuan','full_text');
			$crud->unset_texteditor('sasaran','full_text');
			$crud->unset_texteditor('sosialisasi','full_text');
			
			$crud->unset_add();
			$crud->unset_delete();

			$crud->unset_back_to_list();
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function tatapamong()
	{
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
		
			$data = array();
			$data['title'] = 'Tata Pamong';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->where('id_prodi',$id_prodi);
			$crud->set_table('prodi');
			$crud->set_subject('Tata Pamong');
			$crud->fields('tatapamong', 'kepemimpinan', 'pengelolaan', 'penjaminanmutu');
			$crud->display_as('penjaminanmutu','Penjaminan Mutu');
			$crud->display_as('tatapamong','Tata Pamong');
			$crud->unset_texteditor('tatapamong','full_text');
			$crud->unset_texteditor('kepemimpinan','full_text');
			$crud->unset_texteditor('pengelolaan','full_text');
			$crud->unset_texteditor('penjaminanmutu','full_text');

			$crud->unset_add();
			$crud->unset_delete();

			$crud->unset_back_to_list();
			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function kurikulum(){
		$username=isset($_SESSION['prodi_session']) ? $_SESSION['prodi_session']:'';
		if($username!="")
		{
			$prodi = $this->Prodi_model->prodiByUsername($username);
			$id_prodi = $prodi->id_prodi;
		
			$data = array();
			$data['title'] = 'Kurikulum';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->where('id_prodi',$id_prodi);
			$crud->set_table('kurikulum');
			$crud->set_subject('Kurikulum');
			$crud->field_type('id_prodi', 'hidden', $id_prodi);
			$crud->display_as('komp_utama_lulusan','Kompetensi Utama Lulusan');
			$crud->display_as('komp_pdk_lulusan','Kompetensi Pendukung Lulusan');
			$crud->display_as('komp_pil_lulusan','Kompetensi Pilihan Lulusan');
			$crud->unset_texteditor('komp_utama_lulusan','full_text');
			$crud->unset_texteditor('komp_pdk_lulusan','full_text');
			$crud->unset_texteditor('komp_pil_lulusan','full_text');
			$crud->unset_columns('id_prodi');

			$output = $crud->render();

			$this->main($output,$data);
		} else
		{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}

	function username_callback_admin($value = '', $primary_key = null)
	{
		return '<input type="text" class="input" name="username" value="'.$value.'" id="userid" onchange="cekid()"/><span id=teks style="color:red;font-size:10pt"></span>
		<input type="hidden" class="input" name="user_lama" value="'.$value.'"/>
		<input type="hidden" class="input" name="tabel" id="usertabel" value="admin"/>';	
	}

	function set_password_input_to_empty() 
	{
	return "<input type='password' name='password' value=''/><br><font color='#FF0000'>Hanya diisi apabila ingin mengganti password</font>";
	}

	function insert_validasi($post_array, $primary_key) 
	{
		$password=$post_array['password'];
		$passwordmd5 = md5($password);
		$passwordhash = md5($passwordmd5);							
		$post_array['password'] = $passwordhash;

		$cari=$post_array['username'];
		$tabel = $post_array['tabel'];
		$seleksi = "username"; 
		$hasil = $this->Admin_model->Cek($tabel,$seleksi,$cari);
		if (count($hasil->result_array())==0)
		{
			return $post_array;
		}else{
			return FALSE;
		}
	}

	function update_validasi($post_array, $primary_key) 
	{
		$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
		if($session!=""){
			$cari = $post_array['username'];
			$tabel = $post_array['tabel'];
			$hasil = $this->Admin_model->Cek($tabel,"username",$cari);
			if (count($hasil->result_array())==0)
			{
				if(!empty($post_array['password']))
				{   
					$pass=$post_array['password'];
					$passwordmd5 = md5($pass);
					$passwordhash = md5($passwordmd5);							
					$post_array['password'] = $passwordhash;
					return $post_array;
				}
				else
				{
					unset($post_array['password']);
					return $post_array;
				}
			}else{
				if($post_array["username"] == $post_array["user_lama"])
				{
					if(!empty($post_array['password']))
					{   
						$pass=$post_array['password'];
						$passwordmd5 = md5($pass);
						$passwordhash = md5($passwordmd5);							
						$post_array['password'] = $passwordhash;
						return $post_array;
					}
					else
					{
						unset($post_array['password']);
						return $post_array;	
					}				
				}
				else{
					return FALSE;
					}
			}
		}
	}

}