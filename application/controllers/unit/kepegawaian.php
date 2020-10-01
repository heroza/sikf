<?php
class Kepegawaian extends CI_Controller
{
	
function __construct()
{
	parent::__construct();
	session_start();
	$this->load->database();
	$this->load->helper(array('form','url','cookie','date'));
	$this->load->library('grocery_CRUD');
	$this->load->model('Other_model');
	$this->load->model('Unit_model');
	$this->input->set_cookie();
}

function index()
{
	$data = array();
	$username=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($username!="")
	{
		$unit = $this->Unit_model->unitByUsername($username);
		$data["id_unit"]=$unit->id_unit;
		$data["nama"]=$unit->nama;
	
		$data["info"] = $this->Unit_model->Pilih_Content('informasi','id_informasi = 11');
		$this->load->view('unit/kepegawaian/part_atas',$data);
		$this->load->view('unit/kepegawaian/part_kiri');
		$this->load->view('unit/kepegawaian/index');
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

function main($output = null, $data = null)
{
	$username=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($username!="")
	{
		$unit = $this->Unit_model->unitByUsername($username);
		$data["id_unit"]=$unit->id_unit;
		$data["nama"]=$unit->nama;
		
		$this->load->view('unit/kepegawaian/part_atas',$data);
		$this->load->view('unit/kepegawaian/part_kiri');
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
	$hasil = $this->Other_model->Cek($tabel,$seleksi,$cari);
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

function data_dosen()
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
	$crud->required_fields('nama', 'id_prodi', 'status');
	$crud->columns('nip','nama', 'id_prodi', 'status');
	$crud->display_as('nip','NIP / NIPUS');
	$crud->display_as('id_prodi','Program Studi');
	$crud->set_field_upload('foto','assets/uploads/img/foto');

	$state=$crud->getState();
	if($state == 'edit' || $state=='update_validation')
	{
		$crud->required_fields('nama','username', 'id_prodi', 'status');
	}
	if($state=='add' || $state=='insert_validation')
	{
		$crud->required_fields('nama','username','password', 'id_prodi', 'status');
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
	$hasil = $this->Other_model->Cek($tabel,$seleksi,$cari);
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
		$hasil = $this->Other_model->Cek($tabel,"username",$cari);
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

function data_pegawai()
{
	$data = array();
	$data['title'] = 'Data Pegawai';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('pegawai');
	$crud->set_subject('Data Pegawai');
	$crud->required_fields('nama');
	$crud->columns('nip','nama', 'jabatan');
		 
	$output = $crud->render();

	$this->main($output,$data);
}
	
}