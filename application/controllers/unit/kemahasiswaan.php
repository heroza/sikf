<?php
class Kemahasiswaan extends CI_Controller
{
	
function __construct()
{
	parent::__construct();
	session_start();
	$this->load->database();
	$this->load->helper(array('form','url','cookie','date'));
	$this->load->library('grocery_CRUD');
	$this->load->model('Unit_model');
	$this->input->set_cookie();
}

function index_lama()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data["info"] = $this->Admin_model->Pilih_Content('informasi','id_informasi = 1');
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/index');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
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

function index()
{
	$data = array();
	$session=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_unit"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data["info"] = $this->Unit_model->Pilih_Content('informasi','id_informasi = 12');
	$this->load->view('unit/kemahasiswaan/part_atas',$data);
	$this->load->view('unit/kemahasiswaan/part_kiri');
	$this->load->view('unit/kemahasiswaan/index');
	$this->load->view('unit/part_bawah');
	$this->load->view('unit/part_js');
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

function theme()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/theme');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
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
	$session=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_unit"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$this->load->view('unit/kemahasiswaan/part_atas',$data);
	$this->load->view('unit/kemahasiswaan/part_kiri');
	$this->load->view('unit/cek_user');
	$this->load->view('unit/part_isi',$output);
	$this->load->view('unit/part_js_other');	
	$this->load->view('unit/part_bawah');
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

function informasi()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$tipe= $_GET['tipe'];
	
	$data["info"] = $this->Admin_model->Pilih_Content("informasi","tipe = '$tipe'");
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/informasi');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
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
function update_info()
{
	$data = array();
	$judul=$this->input->post('judul'); $data['judul']=strip_tags($judul);
	$isi=$this->input->post('isi'); $data['isi']=$isi;
	$tipe=$this->input->post('tipe'); $data['tipe']=strip_tags($tipe);
	$this->Admin_model->Update_Content("informasi",$data,"tipe");
	echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/$data[tipe]'>";	
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
	$tabel = "admin";
	$seleksi = "username"; 
	$hasil = $this->Admin_model->Cek($tabel,$seleksi,$cari);
	if (count($hasil->result_array())==0){
		echo "<br><font color='#00FF00'>Username ' $cari ' belum digunakan, silahkan melanjutkan mengisi form </font>";
	}else{
		echo "<br><blink><font color='#FF0000'>Maaf, username ' $cari ' sudah digunakan, silahkan ganti dengan yang lain</font></blink>";
	}
}

function profil()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!=""){
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$id=$pecah[0];
	$data["edit"] = $this->Admin_model->Pilih_Content("admin","id_admin=$id");
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/profil');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
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

function updateprofil()
{
	$data = array();
	$data2 = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!=""){
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data2["id_admin"] = $this->input->post('id_admin');
	$data2["username"] = $this->input->post('username');
	$data2["nama"] = $this->input->post('nama');
	$data2["email"] = $this->input->post('email');
	
	$cari = $this->input->post('username');
	$tabel = "admin";
	$seleksi = "username"; 
	$hasil = $this->Admin_model->Cek($tabel,$seleksi,$cari);
		if (count($hasil->result_array())==0)
		{
			if($this->input->post('password') != '')
			{   
				if($this->input->post('password') == $this->input->post('password2'))
				{
					$passwordmd5 = md5($this->input->post('password'));
					$passwordhash = md5($passwordmd5);							
					$data2["password"] = $passwordhash;
					$this->Admin_model->Update_Content("admin",$data2,"id_admin");
					$admin_session=$this->input->post("id_admin")."|".$this->input->post("nama");
					$_SESSION['admin_session']=$admin_session;
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin'>";
				}
				else{?>
					<script type="text/javascript" language="javascript">
					alert("Password Anda tidak sama...!!!");</script><?php
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/profil'>";
				}
			}
			else{	
			$this->Admin_model->Update_Content("admin",$data2,"id_admin");
			$admin_session=$this->input->post("id_admin")."|".$this->input->post("nama");
			$_SESSION['admin_session']=$admin_session;
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin'>";
			}
		}
		else
		{
			if($this->input->post("username") == $this->input->post("user_lama"))
			{
				if($this->input->post('password') != '')
				{   
					if($this->input->post('password') == $this->input->post('password2'))
					{
						$passwordmd5 = md5($this->input->post('password'));
						$passwordhash = md5($passwordmd5);							
						$data2["password"] = $passwordhash;
						$this->Admin_model->Update_Content("admin",$data2,"id_admin");
						$admin_session=$this->input->post("id_admin")."|".$this->input->post("nama");
						$_SESSION['admin_session']=$admin_session;
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin'>";
					}
					else{?>
						<script type="text/javascript" language="javascript">
						alert("Password Anda tidak sama...!!!");</script><?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/profil'>";
					}
				}
				else{	
				$this->Admin_model->Update_Content("admin",$data2,"id_admin");
				$admin_session=$this->input->post("id_admin")."|".$this->input->post("nama");
				$_SESSION['admin_session']=$admin_session;
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin'>";
				}
			}
			else
			{
			?>
			<script type="text/javascript" language="javascript">
				alert("Username telah digunakan, Silahkan ganti dengan username lain");
			</script><?php	
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/profil'>";
			}
		}
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
	unset($_SESSION['admin_session']);
	echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
}
//----------------------------- kemahasiswaan -----------------------------------//	
function prestasi_mahasiswa()
{
	$data = array();
	$data['title'] = 'Prestasi Mahasiswa';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('prestasi_mahasiswa');
	$crud->set_subject('Prestasi Mahasiswa');
	$crud->required_fields('kegiatan_waktu', 'prestasi', 'tingkat');
	$crud->columns('nim', 'kegiatan_waktu', 'prestasi','tingkat');

	$crud->display_as('kegiatan_waktu', 'Nama Kegiatan dan Waktu');
	$crud->callback_field('tingkat', array($this, 'tingkat_callback') );
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function tingkat_callback($value)
{
	$this->load->helper('form');
	$options = array('' => 'Please select', 'Lokal'=>'Lokal', 'Regional'=>'Regional', 'Nasional'=>'Nasional', 'Internasional'=>'Internasional');
	return form_dropdown('tingkat', $options, $value, "id='tingkat'");
}

function profil_mahasiswa_lulusan()
{
	$data = array();
	$data['title'] = 'Profil Mahasiswa Reguler';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('mahasiswa_lulusan');
	$crud->set_subject('Profil Mahasiswa Reguler');
	$crud->required_fields('tahun');
	$crud->columns('tahun','dayatampung','cama_seleksi', 'cama_lulus', 'maba_reguler', 'maba_transfer',
		'total_reguler', 'total_transfer', 'lulusan_reguler', 'lulusan_transfer',
	        'ipk_min', 'ipk_avg', 'ipk_max', 'ipk_lt_2_75', 'ipk_lt_3_50', 'ipk_gt_3_50');
	$crud->display_as('tahun', 'Tahun');
	$crud->display_as('dayatampung', 'Daya Tampung');
	$crud->display_as('cama_seleksi', 'Jml Cama Ikut Seleksi');
	$crud->display_as('cama_lulus', 'Jml Cama Lulus Seleksi');
	$crud->display_as('maba_reguler', 'Jml Maba Reguler');
	$crud->display_as('maba_trasnfer', 'Jml Maba Transfer');
	$crud->display_as('total_reguler', 'Total Mhs Reguler');
	$crud->display_as('total_transfer', 'Total Mhs Transfer');
	$crud->display_as('lulusan_reguler', 'Jml Lulusan Reguler');
	$crud->display_as('lulusan_transfer', 'Jml Lulusan Transfer');
	$crud->display_as('ipk_min', 'IPK Lulusan Min');
	$crud->display_as('ipk_avg', 'IPK Lulusan Rata2');
	$crud->display_as('ipk_max', 'IPK Lulusan Maks');
	$crud->display_as('ipk_lt_2_75', 'Lulusan IPK < 2,75 (%)');
	$crud->display_as('ipk_lt_3_50', 'Lulusan IPK 2,75 - 3,50 (%)');
	$crud->display_as('ipk_gt_3_50', 'Lulusan IPK > 3,50 (%)');
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function profil_mahasiswa_nonreguler()
{
	$data = array();
	$data['title'] = 'Profil Mahasiswa Non-Reguler (Professional)';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('mahasiswa_nonreguler');
	$crud->set_subject('Profil Mahasiswa Non-Reguler');
	$crud->required_fields('tahun');
	$crud->columns('tahun','dayatampung','cama_seleksi', 'cama_lulus', 'maba_nonreguler', 'maba_transfer',
		'total_nonreguler', 'total_transfer');
	$crud->display_as('tahun', 'Tahun');
	$crud->display_as('dayatampung', 'Daya Tampung');
	$crud->display_as('cama_seleksi', 'Jml Cama Ikut Seleksi');
	$crud->display_as('cama_lulus', 'Jml Cama Lulus Seleksi');
	$crud->display_as('maba_reguler', 'Jml Maba Non-Reguler');
	$crud->display_as('maba_trasnfer', 'Jml Maba Transfer');
	$crud->display_as('total_reguler', 'Total Mhs Reguler');
	$crud->display_as('total_transfer', 'Total Mhs Transfer');
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function pelayanan_mahasiswa()
{
	$data = array();
	$data['title'] = 'Pelayanan Mahasiswa';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('layanan_mahasiswa');
	$crud->set_subject('Pelayanan Mahasiswa');
	$crud->columns('id', 'jenis_pelayanan', 'bentuk_pelaksanaan_hasil');

	$crud->display_as('id', 'Nomer');
	$crud->display_as('jenis_pelayanan', 'Jenis Pelayanan');
	$crud->display_as('bentuk_pelaksanaan_hasil', 'Bentuk, Pelaksanaan dan Hasil');
	$crud->callback_field('jenis_pelayanan', array($this, 'jenispelayanan_callback') );


	//disable add
	$crud->unset_add();
	//disable delete
	$crud->unset_delete();
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function jenispelayanan_callback($value)
{
	return '<p style="padding-top: 7px">'.$value.'</p>';
}

function evaluasi_lulusan()
{
	$data = array();
	$data['title'] = 'Evaluasi Kinerja Lulusan';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('evaluasi_lulusan');
	$crud->set_subject('Evaluasi Kinerja Lulusan');
	$crud->required_fields('metode_proses_mekanisme');
	$crud->columns('metode_proses_mekanisme', 'penjelasan');

	$crud->display_as('metode_proses_mekanisme', 'Metode, Proses dan Mekanisme');
	$crud->display_as('penjelasan', 'Penjelasan');
	$crud->callback_field('metode_proses_mekanisme', array($this, 'metodeprosesmekanisme_callback') );
	$crud->callback_field('penjelasan', array($this, 'penjelasan_callback') );


	$output = $crud->render();

	$this->main($output,$data);
}

function metodeprosesmekanisme_callback($value)
{
	$this->load->helper('form');
	$data = array();
	$data['name'] = 'metode_proses_mekanisme';
	return '<div style="padding-top: 7px">'.form_input($data, $value).'</div>';
}

function penjelasan_callback($value)
{
	$this->load->helper('form');
	$data = array();
	$data['name'] = 'penjelasan';
	return form_textarea($data, $value);
}

function studi_pelacakan()
{
	$data = array();
	$data['title'] = 'Hasil Studi Pelacakan';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('hasil_studi_pelacakan');
	$crud->set_subject('Hasil Studi Pelacakan');
	$crud->columns('nomer', 'jenis_kemampuan', 'tanggapan_sangatbaik', 'tanggapan_baik', 'tanggapan_cukup', 'tanggapan_kurang', 'tindak_lanjut');

	$crud->display_as('nomer', 'No.');
	$crud->display_as('jenis_kemampuan', 'Jenis Kemampuan');
	$crud->display_as('tanggapan_sangatbaik', 'Sangat Baik (%)');
	$crud->display_as('tanggapan_baik', 'Baik (%)');
	$crud->display_as('tanggapan_cukup', 'Cukup (%)');
	$crud->display_as('tanggapan_kurang', 'Kurang (%)');
	$crud->display_as('tindaklanjut', 'Rencana Tindak Lanjut oleh Prodi');
	$crud->callback_field('nomer', array($this, 'nomer_callback') );
	$crud->callback_field('tindaklanjut', array($this, 'tindaklanjut_callback') );

	$crud->unset_add();
	$crud->unset_delete();


	$output = $crud->render();

	$this->main($output,$data);
}

function nomer_callback($value)
{
	return '<p style="padding-top: 7px">'.$value.'</p>';
}

function tindaklanjut_callback($value)
{
	$this->load->helper('form');
	$data = array();
	$data['name'] = 'tindaklanjut';
	return form_textarea($data, $value);
}

//------------------------- USER ------------------------------//
function user()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data["info"] = $this->Admin_model->Pilih_Content('informasi','id_informasi = 3');
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/user');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
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

function admin_account()
{
	$data = array();
	$data['sub'] = 'User';
	$data['sub_link'] = 'user';
	$data['subsub'] = 'Admin';
	$data['subsub_link'] = 'admin_account'; 
	$crud = new grocery_CRUD();
	$crud->set_table('admin');
	$crud->set_subject('Admin');
	$crud->unset_columns('password');
	$state=$crud->getState();
	if($state == 'edit' || $state=='update_validation')
	{
		$crud->required_fields('nama','username');
	}
	if($state=='add' || $state=='insert_validation')
	{
		$crud->required_fields('nama','username','password');
	} 
	$crud->callback_field('username',array($this,'username_callback_admin'));
	$crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
	$crud->callback_before_insert(array($this,'insert_validasi'));
	$crud->callback_before_update(array($this,'update_validasi'));
	
	$output = $crud->render();

	$this->main($output,$data);
}
function username_callback_admin($value = '', $primary_key = null)
{
	return '<input type="text" class="input" name="username" value="'.$value.'" id="userid" onchange="cekid()"/><span id=teks style="color:red;font-size:10pt"></span>
	<input type="hidden" class="input" name="user_lama" value="'.$value.'"/>
	<input type="hidden" class="input" name="tabel" id="usertabel" value="admin"/>';	
}

function auditor_account()
{
	$data = array();
	$data['sub'] = 'User';
	$data['sub_link'] = 'user';
	$data['subsub'] = 'Auditor';
	$data['subsub_link'] = 'auditor_account'; 
	$crud = new grocery_CRUD();
	$crud->set_table('auditor');
	$crud->set_subject('Auditor');
	$crud->unset_columns('password');
	$state=$crud->getState();
	if($state == 'edit' || $state=='update_validation')
	{
		$crud->required_fields('nama','username');
	}
	if($state=='add' || $state=='insert_validation')
	{
		$crud->required_fields('nama','username','password');
	} 
	$crud->callback_field('username',array($this,'username_callback_auditor'));
	$crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
	$crud->callback_before_insert(array($this,'insert_validasi'));
	$crud->callback_before_update(array($this,'update_validasi'));
	
	$output = $crud->render();

	$this->main($output,$data);
}
function username_callback_auditor($value = '', $primary_key = null)
{
	return '<input type="text" class="input" name="username" value="'.$value.'" id="userid" onchange="cekid()"/><span id=teks style="color:red;font-size:10pt"></span>
	<input type="hidden" class="input" name="user_lama" value="'.$value.'"/>
	<input type="hidden" class="input" name="tabel" id="usertabel" value="auditor"/>';	
}

function pimpinan()
{
	$data = array();
	$data['sub'] = 'User';
	$data['sub_link'] = 'user';
	$data['subsub'] = 'Pimpinan';
	$data['subsub_link'] = 'pimpinan'; 
	$crud = new grocery_CRUD();
	$crud->set_table('pimpinan');
	$crud->set_subject('Fimpinan');
	$crud->unset_columns('password');
	$state=$crud->getState();
	if($state == 'edit' || $state=='update_validation')
	{
		$crud->required_fields('nama','username');
	}
	if($state=='add' || $state=='insert_validation')
	{
		$crud->required_fields('nama','username','password');
	} 
	$crud->callback_field('username',array($this,'username_callback_pimpinan'));
	$crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
	$crud->callback_before_insert(array($this,'insert_validasi'));
	$crud->callback_before_update(array($this,'update_validasi'));
	
	$output = $crud->render();

	$this->main($output,$data);
}
function username_callback_pimpinan($value = '', $primary_key = null)
{
	return '<input type="text" class="input" name="username" value="'.$value.'" id="userid" onchange="cekid()"/><span id=teks style="color:red;font-size:10pt"></span>
	<input type="hidden" class="input" name="user_lama" value="'.$value.'"/>
	<input type="hidden" class="input" name="tabel" id="usertabel" value="pimpinan"/>';	
}

function fakultas()
{
	$data = array();
	$data['sub'] = 'User';
	$data['sub_link'] = 'user';
	$data['subsub'] = 'Fakultas';
	$data['subsub_link'] = 'fakultas'; 
	$crud = new grocery_CRUD();
	$crud->set_table('fakultas');
	$crud->set_subject('Fakultas');
	$crud->columns('fakultas','Program_Studi');
	$crud->callback_column('Program_Studi',array($this,'_callback_auditee_user'));
	$crud->required_fields('fakultas');
	
	$output = $crud->render();

	$this->main($output,$data);
}

function _callback_auditee_user($value, $row)
{
	$hasil = $this->Admin_model->Pilih_Content("auditee","id_fakultas = $row->id_fakultas");
	$jumlah = count($hasil->result_array());
			return "
		<a href='".site_url('admin/auditee_account/'.$row->id_fakultas)."' title='Manajemen Program Srudi'><img src='".base_url()."asset/img/plus.png'> Manajemen Program Studi ($jumlah)</a>
		";
}

function auditee_account()
{
	$id = $this->uri->segment(3);
	if($id=="")
	{ $id = 0;}
	$data = array();
	$data['sub'] = 'Fakultas';
	$data['sub_link'] = 'fakultas';
	$data['subsub'] = 'Prodi';
	$data['subsub_link'] = 'auditee_account'; 
	$crud = new grocery_CRUD();
	$crud->set_table('auditee');
	$crud->set_subject('Prodi');
	$crud->set_relation('id_fakultas','fakultas','fakultas',array('id_fakultas' => $id));
	$crud->where('auditee.id_fakultas',$id);
	$crud->field_type('id_fakultas', 'hidden', $id);
	$crud->display_as('id_fakultas','Fakultas');
	$crud->unset_columns('password');
	$state=$crud->getState();
	if($state == 'edit' || $state=='update_validation')
	{
		$crud->required_fields('prodi','username','id_fakultas');
	}
	if($state=='add' || $state=='insert_validation')
	{
		$crud->required_fields('prodi','username','password','id_fakultas');
	} 
	$crud->callback_field('username',array($this,'username_callback_auditee'));
	$crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
	$crud->callback_before_insert(array($this,'insert_validasi'));
	$crud->callback_before_update(array($this,'update_validasi'));
	
	$output = $crud->render();

	$this->main($output,$data);
}
function username_callback_auditee($value = '', $primary_key = null)
{
	return '<input type="text" class="input" name="username" value="'.$value.'" id="userid" onchange="cekid()"/><span id=teks style="color:red;font-size:10pt"></span>
	<input type="hidden" class="input" name="user_lama" value="'.$value.'"/>
	<input type="hidden" class="input" name="tabel" id="usertabel" value="auditee"/>';	
}

function cekid_tabel()
{   
	$cari=''; $tabel='';
	if ($this->uri->segment(3) === FALSE)
	{
			$cari= $_GET['q'];
			$tabel= $_GET['t'];
	}
	$hasil = $this->Admin_model->Cek($tabel,'username',$cari);
	if (count($hasil->result_array())==0){
		echo "<br><font color='#00FF00'>Username ' $cari ' belum digunakan, silahkan melanjutkan pendaftaran </font>";
	}else{
		echo "<br><blink><font color='#FF0000'>Maaf, ' $cari ' sudah digunakan, silahkan ganti dengan yang lain</font></blink>";
	}
}

function set_password_input_to_empty() 
{
return "<input type='password' name='password' value=''/><br><font color='#FF0000'>Hanya diisi apabila inggin mengganti password</font>";
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
