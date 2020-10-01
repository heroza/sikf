<?php
class pimpinan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->database();
		$this->load->helper(array('form','url','cookie','date'));
		$this->load->library('grocery_CRUD');
		$this->load->model('Dosen_meneliti_model');
		$this->load->model('Dosen_mengabdi_model');
		$this->load->model('Publikasi_model');
		$this->load->model('Penulis_model');
		$this->load->model('Other_model');
		$this->load->model('Penelitian_model');

		$this->load->model('Kurikulum_model');
		$this->input->set_cookie();
	}
	
	function index()
	{
		$data = array();
		$username=isset($_SESSION['pimpinan_session']) ? $_SESSION['pimpinan_session']:'';
		if($username!="")
		{			
			$tahunstring = date("Y");
			$tahun = intval($tahunstring)-4;
			$data["tahun"] = $tahun;

			$data["penelitianti"] = $this->Penelitian_model->jumlahPenelitianProdiSejakTahun(1, $tahun);
			$data["penelitiansi"] = $this->Penelitian_model->jumlahPenelitianProdiSejakTahun(2, $tahun);
			$data["penelitiansk"] = $this->Penelitian_model->jumlahPenelitianProdiSejakTahun(3, $tahun);

			$data["penelitiantipertahun"] = $this->Penelitian_model->jumlahPenelitianProdiPerTahun(1, $tahun);
			$data["penelitiansipertahun"] = $this->Penelitian_model->jumlahPenelitianProdiPerTahun(2, $tahun);
			$data["penelitianskpertahun"] = $this->Penelitian_model->jumlahPenelitianProdiPerTahun(3, $tahun);

			$data["publikasiti"] = $this->Publikasi_model->jumlahPublikasiProdiSejakTahun(1, $tahun);
			$data["publikasisi"] = $this->Publikasi_model->jumlahPublikasiProdiSejakTahun(2, $tahun);
			$data["publikasisk"] = $this->Publikasi_model->jumlahPublikasiProdiSejakTahun(3, $tahun);

			$data["publikasitipertahun"] = $this->Publikasi_model->jumlahPublikasiProdiPerTahun(1, $tahun);
			$data["publikasisipertahun"] = $this->Publikasi_model->jumlahPublikasiProdiPerTahun(2, $tahun);
			$data["publikasiskpertahun"] = $this->Publikasi_model->jumlahPublikasiProdiPerTahun(3, $tahun);

			$data["info"] = $this->Other_model->Pilih_Content('informasi','id_informasi = 1');
			$this->load->view('pimpinan/part_atas',$data);
			$this->load->view('pimpinan/part_kiri',$data);
			$this->load->view('pimpinan/index');
			$this->load->view('pimpinan/part_bawah');
			// $this->load->view('pimpinan/part_js');
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
		$username=isset($_SESSION['pimpinan_session']) ? $_SESSION['pimpinan_session']:'';
		if($username!="")
		{		
			$this->load->view('pimpinan/part_atas',$data);
			$this->load->view('pimpinan/part_kiri');
			$this->load->view('pimpinan/part_isi',$output);
			$this->load->view('pimpinan/part_bawah');
			$this->load->view('pimpinan/part_js_other');	
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
	
	function logout()
	{
		unset($_SESSION['pimpinan_session']);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}

	function penelitian()
	{
		$data = array();
		$data['title'] = 'Penelitian';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud = new grocery_CRUD();
		$crud->set_table('penelitian');
		$crud->set_subject('Penelitian');
		$crud->set_relation('skim','skim','deskripsi');
		$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
		$crud->required_fields('judul');
		$crud->set_field_upload('file_laporan','assets/uploads/files');
		$crud->field_type('ketua_peneliti', 'hidden', 0);
		$crud->columns('judul','tahun_pelaksanaan', 'file_laporan', 'pelaksana');
		$crud->callback_column('pelaksana',array($this,'_callback_peneliti')); 

	  	$crud->callback_column('jumlah_dana',array($this,'format_currency_callback'));
		$crud->display_as('tahun_pelaksanaan','Tahun');

		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function publikasi()
	{
		$kode_penelitian = $this->uri->segment(4);
		if ($kode_penelitian == "") {
			$kode_penelitian = 0;
		}
		$crud = new grocery_CRUD();
		$data = array();
		
		if ($kode_penelitian == 0) {
			$data['crumbs'] = array('Publikasi');
			$data['crumbs_link'] = array('');
			$crud->set_relation('penelitian','penelitian','judul');
		} else {
			$data['crumbs'] = array('Penelitian','Publikasi');
			$data['crumbs_link'] = array('pimpinan/penelitian','');
			$crud->field_type('kode_penelitian', 'hidden', $kode_penelitian);
			$crud->where('publikasi.penelitian',$kode_penelitian);
		}
		$data['title'] = 'Publikasi';
		$crud->set_table('publikasi');
		$crud->set_subject('Publikasi');
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
		return $namaArray;
	}

	function _callback_penulis($value, $row)
	{
		$namaArray = $this->Penulis_model->getNamaPenulisByKodePublikasi($row->kode_publikasi);
		return $namaArray;
	}

	function pm()
	{
		$data = array();
		$data['crumbs'] = array('Pengabdian Masyarakat');
		$data['crumbs_link'] = array('');
		$data['title'] = 'Pengabdian Masyarakat';
		$crud = new grocery_CRUD();
		$crud->set_table('pengabdian_masyarakat');
		$crud->set_subject('Pengabdian Masyarakat');
		$crud->required_fields('judul');
		$crud->set_field_upload('file','assets/uploads/files');
		$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
		$crud->set_relation('tingkat','tingkat','deskripsi');
		$crud->columns('judul','tahun_pelaksanaan','file', 'dosen_mengabdi');
		$crud->callback_column('dosen_mengabdi',array($this,'_callback_dosen_mengabdi')); 

	  	$crud->callback_column('jumlah_dana',array($this,'format_currency_callback'));
			 
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$output = $crud->render();

		$this->main($output,$data);
	}

	function _callback_dosen_mengabdi($value, $row)
	{
		$namaArray = $this->Dosen_mengabdi_model->getNamaPengabdiByKodePengabdian($row->kode_pengabdian_masyarakat);
		return $namaArray;
	}

	function dosen_mengabdi()
	{
		$data = array();
		$data['sub'] = 'Dosen Mengabdi';
		$data['home'] = 'uppm';
		$data['sub_link'] = 'uppm/dosen_mengabdi';
		$crud = new grocery_CRUD();
		$crud->set_table('dosen_mengabdi');
		$crud->set_subject('Dosen Mengabdi');
		$crud->set_relation('kode_pengabdian_masyarakat','pengabdian_masyarakat','judul');
		$crud->set_relation('kode_dosen','dosen','nama');
		$crud->set_relation('kode_mengabdi_sebagai','mengabdi_sebagai','nama');
		$crud->required_fields('kode_pengabdian_masyarakat','kode_dosen','kode_mengabdi_sebagai');
		$crud->columns('kode_pengabdian_masyarakat','kode_dosen','kode_mengabdi_sebagai');
		$output = $crud->render();
		$this->main($output,$data);
	}

	function format_currency_callback($value, $row){
		setlocale(LC_MONETARY, 'en_US');
		$value = money_format('%.0n', $value);
		$value = str_replace("$","Rp ",$value);
		$value = str_replace(",",".",$value);
		return $value;
	}

	function change_password($message = '')
	{
		$data = array();
		$username=isset($_SESSION['pimpinan_session']) ? $_SESSION['pimpinan_session']:'';
		if($username!="")
		{
			$data["username"]=$username;
			$data["nama"]="Pimpinan Fasilkom";
			$data["owner"]='pimpinan';

			if ($message == 'wrongpassword') {
				$data["message"]="Password lama yang Anda masukkan salah.";
			}
			elseif ($message == 'success') {
				$data["message"]="<font color='#0000FF'>Password Anda berhasil dirubah.</font>";
			}
			else
				$data["message"]='';
			
			$this->load->view('pimpinan/part_atas',$data);
			$this->load->view('pimpinan/part_kiri');
			$this->load->view('v_change_password');
			$this->load->view('pimpinan/part_bawah');
			$this->load->view('pimpinan/part_js');
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

	public function do_change_password()
	{
		$password = $this->Other_model->password($_POST['username']);
		if ($password != $_POST['oldpassword']) {
			redirect('/pimpinan/change_password/wrongpassword/', 'location');
		} else {
			
		
			$data = array(
				'password' => $_POST['newpassword']
				);
			$this->Other_model->change_password($_POST['username'], $data);
			redirect('/pimpinan/change_password/success/', 'location');
		}
	}

	function dosen()
	{
		$data = array();
		$data['title'] = 'Data Dosen';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud = new grocery_CRUD();
		$crud->set_table('dosen');
		$crud->set_subject('Data Dosen');
		$crud->set_relation('id_prodi','prodi','prodi');
		$crud->set_relation('status','status_dosen','deskripsi');
		$crud->unset_fields('username');
		$crud->columns('nama', 'id_prodi', 'status', 'CV');
		$crud->display_as('id_prodi','Prodi');
		$crud->callback_column('CV',array($this,'_callback_action')); 

		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function _callback_action($value, $row)
	{
				return "
			<a href='".site_url('cv.php?id='.$row->kode_dosen)."' title='Edit Penelitian'><img src='".base_url()."asset/images/fugue/address-book.png'></a>"; 	
	}

	function prodi()
	{
		$username=isset($_SESSION['pimpinan_session']) ? $_SESSION['pimpinan_session']:'';
		if($username!="")
		{
			$data = array();
			$data['title'] = 'Identitas Prodi';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('prodi');
			$crud->set_subject('Identitas Prodi');
			$crud->set_relation('id_fakultas','fakultas','fakultas');
			// $crud->unset_columns('password','id_fakultas','sk_pendirian','jurusandepartemen','tanggal_sk_pendirian','penandatangan_sk_pendirian','waktu_mulai_penyelenggaraan','tanggal_sk_operasional','alamat','faks','sk_operasional','telp','homepage','email', 'mekanisme', 'visi', 'misi', 'tujuan', 'sasaran', 'sosialisasi', 'tatapamong', 'kepemimpinan', 'pengelolaan', 'penjaminanmutu');
			$crud->fields('prodi','nip', 'kaprodi', 'jurusandepartemen', 'jenjang', 'sk_pendirian', 'tanggal_sk_pendirian', 'penandatangan_sk_pendirian', 'waktu_mulai_penyelenggaraan', 'sk_operasional', 'tanggal_sk_operasional', 'peringkat_akreditasi', 'berlaku_akreditasi', 'sk_banpt', 'status', 'telp', 'email', 'alamat', 'faks', 'homepage', 'id_fakultas');
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
			$crud->columns('prodi', 'peringkat_akreditasi', 'berlaku_akreditasi');
			$crud->unset_add();
			$crud->unset_edit();
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

	function matkul()
	{
		$username=isset($_SESSION['pimpinan_session']) ? $_SESSION['pimpinan_session']:'';
		if($username!="")
		{
			$kode_kurikulum_ti = $this->Kurikulum_model->kurikulum_berlaku_prodi(1);
			$kode_kurikulum_si = $this->Kurikulum_model->kurikulum_berlaku_prodi(2);
			$kode_kurikulum_sk = $this->Kurikulum_model->kurikulum_berlaku_prodi(3);

			$data = array();
			$data['title'] = 'Mata Kuliah';
			$data['crumbs'] = array('');
			$data['crumbs_link'] = array('');
			$crud = new grocery_CRUD();
			$crud->set_table('matkul');
			$crud->where('matkul.kode_kurikulum',$kode_kurikulum_sk);
			$crud->or_where('matkul.kode_kurikulum',$kode_kurikulum_si);
			$crud->or_where('matkul.kode_kurikulum',$kode_kurikulum_ti);
			$crud->set_subject('Mata Kuliah');
			$crud->required_fields('kode', 'mata_kuliah', 'sks', 'semester');
			$crud->set_field_upload('deskripsi','assets/uploads/files');
			$crud->set_field_upload('silabus','assets/uploads/files');
			$crud->set_field_upload('sap','assets/uploads/files');
			$crud->columns('semester', 'kode', 'mata_kuliah', 'sks', 'deskripsi', 'silabus', 'sap');
			$crud->display_as('sap','SAP');
			$crud->display_as('sks','SKS');
			$crud->display_as('sks_inti','SKS Inti');
			$crud->display_as('sks_institusional','SKS Institusional');
			$crud->display_as('is_bobot_20','Bobot tugas >= 20%');
			$crud->display_as('is_pilihan','Wajib/Pilihan');

			$crud->unset_add();
			$crud->unset_edit();
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

}