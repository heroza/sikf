<?php
class dosen extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->database();
		$this->load->helper(array('form','url','cookie','date'));
		$this->load->library(array('grocery_CRUD','Pagination'));
		$this->load->model('Dosen_model');
		$this->load->model('Other_model');
		$this->load->model('Dosen_meneliti_model');
		$this->load->model('Dosen_mengabdi_model');
		$this->load->model('Penelitian_model');
		$this->load->model('Publikasi_model');
		$this->load->model('Prodi_model');
		$this->load->model('Penulis_model');
		$this->input->set_cookie();
	}
	
	function index()
	{
		$data = array();
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$data["kode_dosen"]=$dosen->kode_dosen;
			$data["nama"]=$dosen->nama;
			
			$data["info"] = $this->Other_model->Pilih_Content('informasi','tipe = "index_dosen"');
			$this->load->view('dosen/part_atas',$data);
			$this->load->view('dosen/part_kiri');
			$this->load->view('dosen/index');
			$this->load->view('dosen/part_bawah');
			$this->load->view('dosen/part_js');
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
		
		
		$this->load->view('dosen/part_atas',$data);
		$this->load->view('dosen/part_kiri');
		$this->load->view('dosen/part_isi',$output);
		$this->load->view('dosen/part_bawah');
		// $this->load->view('dosen/part_js');
		
	}
	
	function logout()
	{
		unset($_SESSION['dosen_session']);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}

	function change_password($message = '')
	{
		$data = array();
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$data["username"]=$username;
			$data["kode_dosen"]=$dosen->kode_dosen;
			$data["nama"]=$dosen->nama;
			$data["owner"]='dosen';

		if ($message == 'wrongpassword') {
			$data["message"]="Password lama yang Anda masukkan salah.";
		}
		elseif ($message == 'success') {
			$data["message"]="<font color='#0000FF'>Password Anda berhasil dirubah.</font>";
		}
		else
			$data["message"]='';
		
		$this->load->view('dosen/part_atas',$data);
		$this->load->view('dosen/part_kiri');
		$this->load->view('v_change_password');
		$this->load->view('dosen/part_bawah');
		$this->load->view('dosen/part_js');
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
			redirect('/dosen/change_password/wrongpassword/', 'location');
		} else {
			
		
			$data = array(
				'password' => $_POST['newpassword']
				);
			$this->Other_model->change_password($_POST['username'], $data);
			redirect('/dosen/change_password/success/', 'location');
		}
	}

	function data_dosen()
	{
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$kode_dosen=$dosen->kode_dosen;
			$nama_dosen=$dosen->nama;
			$id_prodi=$dosen->id_prodi;
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
		$data['nama'] = $nama_dosen;
		$data['kode_dosen'] = $kode_dosen;
		$data['title'] = 'Data Kepegawaian';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud = new grocery_CRUD();
		$crud->set_table('dosen');
		$crud->set_subject('Data Dosen');
		$crud->set_relation('id_prodi','prodi','prodi');
		$crud->where('kode_dosen',$kode_dosen);
		$crud->set_relation('status','status_dosen','deskripsi');
		$crud->required_fields('nama', 'id_prodi', 'status');
		// $crud->field_type('id_prodi', 'hidden', $id_prodi);
		$crud->fields('nama', 'id_prodi', 'nip', 'nidn', 'status', 'no_sertifikat', 'tempat_lahir', 'tanggal_lahir', 'jabatan_akademik', 'gelar_depan', 'gelar_belakang', 's1', 's2', 's3', 'bidang_keahlian', 'email', 'foto');
		$crud->set_field_upload('foto','assets/uploads/img/foto');
		$crud->display_as('nip','NIP')
			 ->display_as('id_prodi','Prodi')
			 ->display_as('nidn','NIDN');

		
		$crud->unset_add();
		$crud->unset_delete();

		$crud->unset_back_to_list();
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function anggotapenelitian()
	{
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$kode_dosen=$dosen->kode_dosen;
			$nama_dosen=$dosen->nama;
			$id_prodi=$dosen->id_prodi;
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
		$kode_penelitian = $this->uri->segment(3);

		$data = array();
		$data['nama'] = $nama_dosen;
		$data['kode_dosen'] = $kode_dosen;
		$data['title'] = 'Anggota Penelitian';
		$data['crumbs'] = array('Penelitian','Anggota Penelitian');
		$data['crumbs_link'] = array('dosen/penelitian','');
		$crud = new grocery_CRUD();
		$crud->set_table('dosen_meneliti');
		$crud->set_subject('Anggota Penelitian');
		$crud->set_relation('kode_penelitian','penelitian','judul');
		$crud->set_relation('kode_dosen','dosen','nama');
		$crud->set_relation('kode_meneliti_sebagai','meneliti_sebagai','nama');
		$crud->required_fields('kode_dosen','kode_meneliti_sebagai');
		$crud->columns('kode_penelitian','kode_dosen','kode_meneliti_sebagai');
		$crud->display_as('kode_penelitian','Penelitian');
		$crud->display_as('kode_dosen','Dosen');
		$crud->display_as('kode_meneliti_sebagai','Meneliti sebagai');

		$crud->field_type('kode_penelitian', 'hidden', $kode_penelitian);
		$crud->where('dosen_meneliti.kode_penelitian',$kode_penelitian);
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function anggotapengabdian()
	{
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$kode_dosen=$dosen->kode_dosen;
			$nama_dosen=$dosen->nama;
			$id_prodi=$dosen->id_prodi;
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
		$kode_pengabdian_masyarakat = $this->uri->segment(3);

		$data = array();
		$data['nama'] = $nama_dosen;
		$data['kode_dosen'] = $kode_dosen;
		$data['title'] = 'Anggota Pengabdian';
		$data['crumbs'] = array('Pengabdian','Anggota Pengabdian');
		$data['crumbs_link'] = array('dosen/pm','');
		$crud = new grocery_CRUD();
		$crud->set_table('dosen_mengabdi');
		$crud->set_subject('Anggota Pengabdian');
		$crud->set_relation('kode_pengabdian_masyarakat','pengabdian_masyarakat','judul');
		$crud->set_relation('kode_dosen','dosen','nama');
		$crud->set_relation('kode_mengabdi_sebagai','mengabdi_sebagai','nama');
		$crud->required_fields('kode_pengabdian_masyarakat','kode_dosen','kode_mengabdi_sebagai');
		$crud->columns('kode_pengabdian_masyarakat','kode_dosen','kode_mengabdi_sebagai');
		$crud->display_as('kode_pengabdian_masyarakat','Pengabdian');
		$crud->display_as('kode_dosen','Dosen');
		$crud->display_as('kode_mengabdi_sebagai','Mengabdi sebagai');

		$crud->field_type('kode_pengabdian_masyarakat', 'hidden', $kode_pengabdian_masyarakat);
		$crud->where('dosen_mengabdi.kode_pengabdian_masyarakat',$kode_pengabdian_masyarakat);
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function penulis()
	{
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$kode_dosen=$dosen->kode_dosen;
			$nama_dosen=$dosen->nama;
			$id_prodi=$dosen->id_prodi;
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
		$kode_publikasi = $this->uri->segment(3);

		$data = array();
		$data['nama'] = $nama_dosen;
		$data['kode_dosen'] = $kode_dosen;
		$data['title'] = 'Penulis Publikasi';
		$data['crumbs'] = array('Publikasi','Penulis');
		$data['crumbs_link'] = array('dosen/publikasi/','');
		$crud = new grocery_CRUD();
		$crud->set_table('penulis');
		$crud->set_subject('Penulis');
		$crud->set_relation('kode_publikasi','publikasi','judul');
		$crud->set_relation('kode_dosen','dosen','nama');
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

	function tes(){
		$crud = new grocery_CRUD();
		$crud->set_model('custom_query_model');
		$crud->set_table('employees'); //Change to your table name
		$crud->basic_model->set_query_str('SELECT * FROM employees'); //Query text here
		$output = $crud->render();
	}

	function pm()
	{
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$kode_dosen=$dosen->kode_dosen;
			$nama_dosen=$dosen->nama;
			$id_prodi=$dosen->id_prodi;
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
		$data['nama'] = $nama_dosen;
		$data['kode_dosen'] = $kode_dosen;
		$data['crumbs'] = array('Pengabdian Masyarakat');
		$data['crumbs_link'] = array('');
		$data['title'] = 'Pengabdian Masyarakat';
		$crud = new grocery_CRUD();
		$crud->set_table('pengabdian_masyarakat');
		$crud->set_subject('Pengabdian Masyarakat');
		$crud->set_model('pengabdian_dosen_x_model');
	    $this->pengabdian_dosen_x_model->set_kode_dosen($kode_dosen);
		$crud->required_fields('judul');
		// $crud->required_fields('judul','ketua_kelompok','tempat_pelaksanaan','jumlah_dana','file');
		$crud->set_field_upload('file','assets/uploads/files');
		$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
		$crud->set_relation('tingkat','tingkat','deskripsi');
		$crud->columns('judul','tahun_pelaksanaan','file', 'dosen_mengabdi');
		
		$crud->callback_after_insert(array($this, 'create_dosen_mengabdi'));
		$crud->field_type('id_prodi', 'hidden', $id_prodi);
		$crud->callback_column('dosen_mengabdi',array($this,'_callback_pengabdi')); 
	  	$crud->callback_column('jumlah_dana',array($this,'format_currency_callback'));
			 
		$output = $crud->render();

		$this->main($output,$data);
	}

	function penelitian()
	{
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$kode_dosen=$dosen->kode_dosen;
			$nama_dosen=$dosen->nama;
			$id_prodi=$dosen->id_prodi;
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
		$data['nama'] = $nama_dosen;
		$data['kode_dosen'] = $kode_dosen;
		$data['title'] = 'Penelitian';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud = new grocery_CRUD();
		$crud->set_table('penelitian');
		$crud->set_subject('Penelitian');
	    $crud->set_model('penelitian_dosen_x_model');
	    $this->penelitian_dosen_x_model->set_kode_dosen($kode_dosen);
		$crud->set_relation('skim','skim','deskripsi');
		$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
		$crud->required_fields('judul');
		$crud->set_field_upload('file_laporan','assets/uploads/files');
		$crud->columns('judul','tahun_pelaksanaan', 'file_laporan', 'peneliti');
		$crud->callback_column('peneliti',array($this,'_callback_peneliti')); 
		$crud->callback_after_insert(array($this, 'create_dosen_meneliti'));
		$crud->display_as('tahun_pelaksanaan','Tahun');
			$output = $crud->render();
			$this->main($output,$data);
	}

	function create_dosen_meneliti($post_array,$primary_key)
	{
		$username = $_SESSION['dosen_session'];
		$dosen = $this->Dosen_model->dosenByUsername($username);


	    $data_insert = array(
	        "kode_penelitian" => $primary_key,
	        "kode_dosen" => $dosen->kode_dosen,
	        "kode_meneliti_sebagai" => 1
	    );
	 
	    $this->Dosen_meneliti_model->insert($data_insert);
	 
	    return true;
	}

	function create_dosen_mengabdi($post_array,$primary_key)
	{
		$username = $_SESSION['dosen_session'];
		$dosen = $this->Dosen_model->dosenByUsername($username);

	    $data_insert = array(
	        "kode_pengabdian_masyarakat" => $primary_key,
	        "kode_dosen" => $dosen->kode_dosen,
	        "kode_mengabdi_sebagai" => 1
	    );
	 
	    $this->Dosen_mengabdi_model->insert($data_insert);
	 
	    return true;
	}

	function publikasi()
	{
		$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
		if($username!="")
		{
			$dosen = $this->Dosen_model->dosenByUsername($username);
			$kode_dosen=$dosen->kode_dosen;
			$nama_dosen=$dosen->nama;
			$id_prodi=$dosen->id_prodi;
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
		$crud = new grocery_CRUD();
		$data['nama'] = $nama_dosen;
		$data['title'] = 'Publikasi';
		$data['kode_dosen'] = $kode_dosen;
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
		$crud->set_table('publikasi');
		$crud->set_subject('Publikasi');
	    $crud->set_model('publikasi_dosen_x_model');
	    $this->publikasi_dosen_x_model->set_kode_dosen($kode_dosen);
		$crud->set_relation('tingkat','tingkat','deskripsi');
		$crud->set_relation('penelitian','penelitian','judul');
		$crud->set_relation('jenis_publikasi','jenis_publikasi','deskripsi');
		$crud->required_fields('judul');
		$crud->set_field_upload('file','assets/uploads/files');
		$crud->columns('judul', 'tahun', 'file', 'penulis');
		$crud->callback_column('penulis',array($this,'_callback_penulis')); 
		$crud->callback_after_insert(array($this, 'create_dosen_menulis'));
		$crud->display_as('url','URL');
		$crud->display_as('tempat','Publisher');
		$crud->display_as('penelitian','Penelitian Terkait');
		$output = $crud->render();
		$this->main($output,$data);
	}

	function _callback_peneliti($value, $row)
	{
		$namaArray = $this->Dosen_meneliti_model->getNamaPenelitiByKodePenelitian($row->kode_penelitian);
		return "<a href='".site_url('dosen/anggotapenelitian/'.$row->kode_penelitian)."' title='Anggota'><img src='".base_url()."asset/img/plus.png'> ($namaArray)</a>";
	}

	function _callback_pengabdi($value, $row)
	{
		$namaArray = $this->Dosen_mengabdi_model->getNamaPengabdiByKodePengabdian($row->kode_pengabdian_masyarakat);
		return "<a href='".site_url('dosen/anggotapengabdian/'.$row->kode_pengabdian_masyarakat)."' title='Anggota'><img src='".base_url()."asset/img/plus.png'> ($namaArray)</a>";
	}

	function _callback_penulis($value, $row)
	{
		$namaArray = $this->Penulis_model->getNamaPenulisByKodePublikasi($row->kode_publikasi);
		return "<a href='".site_url('dosen/penulis/'.$row->kode_publikasi)."' title='Anggota'><img src='".base_url()."asset/img/plus.png'> ($namaArray)</a>";
	}

	function create_dosen_menulis($post_array,$primary_key)
	{
		$username = $_SESSION['dosen_session'];
		$dosen = $this->Dosen_model->dosenByUsername($username);

	    $data_insert = array(
	        "kode_publikasi" => $primary_key,
	        "kode_dosen" => $dosen->kode_dosen,
	        "kode_penulis_sebagai" => 1
	    );
	 
	    $this->Penulis_model->insert($data_insert);
	 
	    return true;
	}

	function _callback_action($value, $row)
	{
				return "
			<a href='".site_url('prodi/kelolapenelitian/edit/'.$row->kode_penelitian)."' title='Edit Penelitian'><img src='".base_url()."asset/img/edit.png'></a>
			<a href='".site_url('prodi/penelitian/delete/'.$row->kode_penelitian)."' title='Delete Penelitian' class='delete-row' ><img src='".base_url()."asset/img/close.png'></a></p>"; 	
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
			$username=isset($_SESSION['dosen_session']) ? $_SESSION['dosen_session']:'';
			if($username!="")
			{
				$dosen = $this->Dosen_model->dosenByUsername($username);
				$id_prodi=$dosen->id_prodi;
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
		}
	}

	function format_currency_callback($value, $row){
		setlocale(LC_MONETARY, 'en_US');
		$value = money_format('%.0n', $value);
		$value = str_replace("$","Rp ",$value);
		$value = str_replace(",",".",$value);
		return $value;
	}

}