<?php
class Standar2 extends CI_Controller
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
	
	$data["info"] = $this->Unit_model->Pilih_Content('informasi','id_informasi = 13');
	$this->load->view('unit/standar2/part_atas',$data);
	$this->load->view('unit/standar2/part_kiri');
	$this->load->view('unit/standar2/index');
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
	
	$this->load->view('unit/standar2/part_atas',$data);
	$this->load->view('unit/standar2/part_kiri');
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
//----------------------------- standar2 -----------------------------------//	
function tata_pamong()
{
	$data = array();
	
		$data['title'] = 'Tata Pamong';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('tata_pamong');
	$crud->set_subject('Tata Pamong');
	$crud->columns('tata_pamong');
	$crud->unset_delete();
	$crud->unset_add();

	$crud->display_as('tata_pamong', 'Sistem Tata Pamong');
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function kepemimpinan()
{
	$data = array();
	
		$data['title'] = 'Kepemimpinan';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('kepemimpinan');
	$crud->set_subject('Kepemimpinan');
	$crud->columns('kepemimpinan');
	$crud->unset_delete();
	$crud->unset_add();

	$crud->display_as('kepemimpinan', 'Kepemimpinan');
		 
	$output = $crud->render();

	$this->main($output,$data);

}

function sistem_pengelolaan()
{
	$data = array();
	
		$data['title'] = 'Sistem Pengelolaan';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('sistem_pengelolaan');
	$crud->set_subject('Sistem Pengelolaan');
	$crud->columns('sistem_pengelolaan');
	$crud->unset_delete();
	$crud->unset_add();

	$crud->display_as('sistem_pengelolaan', 'Sistem Pengelolaan');
		 
	$output = $crud->render();

	$this->main($output,$data);

}

function penjaminan_mutu()
{
	$data = array();
	
		$data['title'] = 'Penjaminan Mutu';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('penjaminan_mutu');
	$crud->set_subject('Penjaminan Mutu');
	$crud->columns('penjaminan_mutu');
	$crud->unset_delete();
	$crud->unset_add();

	$crud->display_as('penjaminan_mutu', 'Penjaminan Mutu');
		 
	$output = $crud->render();

	$this->main($output,$data);

}

function umpan_balik()
{
	$data = array();
	
		$data['title'] = 'Umpan Balik';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('umpan_balik');
	$crud->set_subject('Umpan Balik');
	$crud->columns('dari', 'isi', 'tindak_lanjut');
	$crud->unset_delete();
	$crud->unset_add();

	$crud->display_as('dari', 'Umpan Balik Dari');
	$crud->display_as('isi', 'Isi Umpan Balik');
	$crud->display_as('tindak_lanjut', 'Tindak Lanjut');

	$crud->callback_field('dari', array($this, 'dari_callback'));
		 
	$output = $crud->render();

	$this->main($output,$data);

}

function dari_callback($value)
{
	return '<p style="padding-top: 7px">'.$value.'</p>';
}

function keberlanjutan()
{
	$data = array();
	
		$data['title'] = 'Keberlanjutan';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('keberlanjutan');
	$crud->set_subject('Keberlanjutan');
	$crud->columns('perihal', 'upaya');
	$crud->unset_delete();
	$crud->unset_add();

	$crud->display_as('perihal', 'Perihal');
	$crud->display_as('upaya', 'Upaya untuk Menjamin Keberlanjutan');

	$crud->callback_field('perihal', array($this, 'perihal_callback'));
	$crud->callback_column('perihal', array($this, 'expand_ellipsis_callback'));
		 
	$output = $crud->render();

	$this->main($output,$data);

}

function perihal_callback($value)
{
	return '<p style="padding-top: 7px">'.$value.'</p>';
}

function expand_ellipsis_callback($value, $row)
{
	return $value;
}

function tingkat_callback($value)
{
	$this->load->helper('form');
	$options = array('' => 'Please select', 'Lokal'=>'Lokal', 'Regional'=>'Regional', 'Nasional'=>'Nasional', 'Internasional'=>'Internasional');
	return form_dropdown('tingkat', $options, $value, "id='tingkat'");
}

function jenispelayanan_callback($value)
{
	return '<p style="padding-top: 7px">'.$value.'</p>';
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
