<?php
class admin extends CI_Controller
{
	
function __construct()
{
	parent::__construct();
	session_start();
	$this->load->database();
	$this->load->helper(array('form','url','cookie','date'));
	$this->load->library('grocery_CRUD');
	$this->load->model('Admin_model');
	$this->input->set_cookie();
}

function index()
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
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/cek_user');
	$this->load->view('admin/part_isi',$output);
	$this->load->view('admin/part_js_other');	
	$this->load->view('admin/part_bawah');
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
//----------------------------- instrumen -----------------------------------//	
function borang()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data["info"] = $this->Admin_model->Pilih_Content('informasi','id_informasi = 2');
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/borang');
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

function visi_misi()
{
	$data = array();
	$data['sub'] = 'Borang';
	$data['sub_link'] = 'borang';
	$data['subsub'] = 'Visi & Misi';
	$data['subsub_link'] = 'visi_misi'; 
	$crud = new grocery_CRUD();
	$crud->set_table('visimisi');
	$crud->set_subject('Visi & Misi');
	$crud->required_fields('visi','misi');	
	$crud->columns('visi','misi','keterangan','Strategi');
	$crud->callback_column('Strategi',array($this,'_callback_strategi_instrumen'));
	
	$output = $crud->render();

	$this->main($output,$data);
}

function _callback_strategi_instrumen($value, $row)
{
	$hasil = $this->Admin_model->Pilih_Content("strategi","id_visimisi = $row->id_visimisi");
	$jumlah = count($hasil->result_array());
			return "
		<a href='".site_url('admin/strategi/'.$row->id_visimisi)."' title='Manajemen Strategi'><img src='".base_url()."asset/img/plus.png'> Manajemen Strategi ($jumlah)</a>
		";
}

function strategi()
{
	$id = $this->uri->segment(3);
	if($id=="")
	{ $id = 0;}
	$data = array();
	$data['sub'] = 'Visi & Misi';
	$data['sub_link'] = 'visi_misi';
	$data['subsub'] = 'Strategi';
	$data['subsub_link'] = 'strategi'; 
	$crud = new grocery_CRUD();
	$crud->set_table('strategi');
	$crud->columns('strategi','Standar');
	$crud->set_subject('Strategi');
	$crud->set_relation('id_visimisi','visimisi','visi',array('id_visimisi' => $id));
	$crud->set_relation_n_n('Standar','standar_strategi','standar','id_strategi','id_standar','standar');
	$crud->required_fields('strategi');
	$crud->field_type('id_visimisi', 'hidden', $id);
	$crud->display_as('id_visimisi','Visi');
	$crud->where('strategi.id_visimisi',$id);
	$crud->order_by('id_strategi','desc');
	
	$output = $crud->render();
	
	$this->main($output,$data);
}

function perspektif()
{
	$data = array();
	$data['sub'] = 'Borang';
	$data['sub_link'] = 'borang';
	$data['subsub'] = 'Perspektif';
	$data['subsub_link'] = 'perspektif'; 
	$crud = new grocery_CRUD();
	$crud->set_table('perspektif');
	$crud->set_subject('Perspektif');
	$crud->required_fields('perspektif');
	
	$output = $crud->render();

	$this->main($output,$data);
}

function standar()
{
	$data = array();
	$data['sub'] = 'Borang';
	$data['sub_link'] = 'borang';
	$data['subsub'] = 'Standar';
	$data['subsub_link'] = 'standar'; 
	$crud = new grocery_CRUD();
	$crud->set_table('standar');
	$crud->set_subject('Standar');
	$crud->required_fields('standar','id_perspektif');
	$crud->set_relation('id_perspektif','perspektif','perspektif',null,'id_perspektif ASC');
	$crud->display_as('id_perspektif','Perspektif');
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function instrumen()
{
	$data = array();
	$data['sub'] = 'Borang';
	$data['sub_link'] = 'borang';
	$data['subsub'] = 'Instrumen';
	$data['subsub_link'] = 'instrumen'; 
	$crud = new grocery_CRUD();
	$crud->set_table('instrumen');
	$crud->set_subject('Instrumen');
	$crud->set_relation('id_visimisi','visimisi','visi');
	$crud->display_as('id_visimisi','Visi');
	$crud->required_fields('instrumen','jenjang','edisi','id_visimisi');
	$crud->field_type('status', 'hidden', 'Persiapan');
	$crud->columns('instrumen','jenjang','edisi','status','rubrik','Total_Bobot','Action');
	$crud->callback_column('Action',array($this,'_callback_actions_instrumen'));
	$crud->callback_column('rubrik',array($this,'_callback_rubrik_instrumen'));
	$crud->callback_column('Total_Bobot',array($this,'_callback_total_bobot'));
	$crud->order_by('id_instrumen','desc');
	$crud->hidden_editdelete();
	$output = $crud->render();

	$this->main($output,$data);
}
function _callback_actions_instrumen($value, $row)
{
		if($row->status == 'Persiapan')
		{
		return "<p align='right'>
		<a href='".site_url('admin/aktif_instrumen/'.$row->id_instrumen)."' title='Aktifkan Instrumen' onclick='return confirm(\"Instrumen yang telah DI-AKTIF-KAN dapat digunakan untuk Audit tetapi tidak dapat edit lagi, Apakah Anda yakin ingin mengaktifkan instrumen ini?\")'><img src='".base_url()."asset/img/on.png'></a> 	
		<a href='".site_url('admin/instrumen/edit/'.$row->id_instrumen)."' title='Edit Instrumen'><img src='".base_url()."asset/img/edit.png'></a>
		<a href='".site_url('admin/instrumen/delete/'.$row->id_instrumen)."' title='Delete Instrumen' class='delete-row' ><img src='".base_url()."asset/img/close.png'></a></p>"; 	
		}
		else if($row->status == 'Aktif')
		{
		return "<p align='right'>
		<a href='".site_url('admin/arsip_instrumen/'.$row->id_instrumen)."' title='Arsipkan Instrumen' onclick='return confirm(\"Instrumen yang telah DI-ARSIP-KAN akan disimpan dan tidak dapat digunakan lagi, Apakah Anda yakin ingin mengarsipkan instrumen ini?\")'><img src='".base_url()."asset/img/off.png'></a></p>"; 	
		}
		else if($row->status == 'Arsip')
		{
		return "<p align='right'>
		<a href='".site_url('admin/aktif_instrumen/'.$row->id_instrumen)."' title='Aktifkan Kembali Instrumen' onclick='return confirm(\"Instrumen yang akan DI-AKTIF-KAN dapat digunakan untuk Audit, Apakah Anda yakin ingin mengaktifkan kembali instrumen ini?\")'><img src='".base_url()."asset/img/on.png'></a></p>";	
		}		
}
function aktif_instrumen()
{
	$data['id_instrumen'] = $this->uri->segment(3);
	$data['status'] = "Aktif";
	$this->Admin_model->Update_Content("instrumen",$data,"id_instrumen");
	echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/instrumen'>";
}
function arsip_instrumen()
{
	$data['id_instrumen'] = $this->uri->segment(3);
	$data['status'] = "Arsip";
	$this->Admin_model->Update_Content("instrumen",$data,"id_instrumen");
	echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/instrumen'>";
} 

function _callback_rubrik_instrumen($value, $row)
{
	$hasil = $this->Admin_model->Pilih_Content("rubrik","id_instrumen = $row->id_instrumen");
	$jumlah = count($hasil->result_array());
			return "
		<a href='".site_url('admin/manajemen_rubrik/'.$row->id_instrumen)."' title='Manajemen rubrik'><img src='".base_url()."asset/img/plus.png'> Manajemen rubrik ($jumlah)</a>
		";
}
function _callback_total_bobot($value, $row)
{
	$hasil = $this->Admin_model->Sum_Pilih("rubrik","bobot","id_instrumen = $row->id_instrumen");
		foreach($hasil -> result_array() as $s) {
			return $s['sum'];
		}	
}

function manajemen_rubrik()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$id = $this->uri->segment(3);
	if($id=="")
	{ $id = 0;}
	$data['sub'] = 'Borang';
	$data['sub_link'] = 'borang';
	$data['subsub'] = 'Manajemen Rubrik';
	$data['subsub_link'] = 'manajemen_rubrik/'.$id;
	$data['instrumen'] = $this->Admin_model->Pilih_Content("instrumen","id_instrumen = $id"); 
	$data['sum'] = $this->Admin_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id");
	$data['rubrik'] = $this->Admin_model->Standar_Rubrik($id); 
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/m_rubrik');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
	}else{
		?>
		<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
	<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
}

function standar_rubrik()
{
	$id = $this->uri->segment(3);
	if($id=="")
	{ $id = 0;}
	$data = array();
	$data['sub'] = 'Manajemen Rubrik';
	$data['sub_link'] = 'manajemen_rubrik/'.$id;
	$data['subsub'] = 'Add Rubrik Baru';
	$data['subsub_link'] = 'standar_rubrik/'.$id.'/add'; 
	$crud = new grocery_CRUD();
	$crud->set_table('rubrik');
	$crud->set_subject('Rubrik');
	$crud->set_relation('id_standar','standar','standar',null,'id_standar ASC')
		 ->set_relation('id_instrumen','instrumen','instrumen',array('id_instrumen' => $id));
	$crud->field_type('id_instrumen', 'hidden', $id);
	$crud->display_as('id_standar','Standar')
		 ->display_as('id_instrumen','Instrumen');
	$crud->order_by('id_rubrik','asc');
	$crud->where('rubrik.id_instrumen',$id);
	$crud->required_fields('rubrik','kpi','bobot','target','id_standar','id_perspektif','id_instrumen','Strategi');
	$crud->set_lang_string('insert_success_message',
			 'Your data has been successfully stored into the database.<br/>Please wait while you are redirecting to the list page.
			 <script type="text/javascript">
			  window.location = "'.site_url('admin/manajemen_rubrik/'.$id).'";
			 </script>
			 <div style="display:none">
			 ');
	$crud->unset_back_to_list();
	$hasil = $this->Admin_model->Pilih_Content("instrumen","id_instrumen = $id");
	$crud->unset_edit();
	$crud->unset_delete();
		foreach($hasil -> result_array() as $b) {
			if($b['status'] != 'Persiapan')
			{
				$crud->unset_operations();
			}
		}	
	$output = $crud->render();
	
	$this->main($output,$data);
}

function rubrik()
{
	$id = $this->uri->segment(3);
	$id_p = $this->uri->segment(4);
	if($id=="" && $id_p=="")
	{ $id = 0; $id_p=0;}
	$data = array();
	$data['sub'] = 'Manajemen Rubrik';
	$data['sub_link'] = 'manajemen_rubrik/'.$id;
	$data['subsub'] = 'Rubrik';
	$data['subsub_link'] = 'rubrik/'.$id.'/'.$id_p; 
	$crud = new grocery_CRUD();
	$crud->set_table('rubrik');
	$crud->set_subject('Rubrik');
	$crud->set_relation('id_standar','standar','standar',array('id_standar' => $id_p))
		 ->set_relation('id_instrumen','instrumen','instrumen',array('id_instrumen' => $id));
	$crud->field_type('id_standar', 'hidden', $id_p);
	$crud->field_type('id_instrumen', 'hidden', $id);
	$crud->display_as('id_standar','Standar')
		 ->display_as('id_instrumen','Instrumen');
	$crud->order_by('id_rubrik','asc');
	$crud->where('rubrik.id_instrumen',$id);
	$crud->where('rubrik.id_standar',$id_p);
	$crud->required_fields('rubrik','kpi','bobot','target','id_standar','id_instrumen');
	$hasil = $this->Admin_model->Pilih_Content("instrumen","id_instrumen = $id");
		foreach($hasil -> result_array() as $b) {
			if($b['status'] != 'Persiapan')
			{
				$crud->unset_operations();
			}
		}	
	$output = $crud->render();
	
	$this->main($output,$data);
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

//------------------------- Penugasan ------------------------------//	
function penugasan()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data["info"] = $this->Admin_model->Pilih_Content('informasi','id_informasi = 4');
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/penugasan');
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

function periode()
{
	$data = array();
	$data['sub'] = 'Penugasan';
	$data['sub_link'] = 'penugasan';
	$data['subsub'] = 'Periode';
	$data['subsub_link'] = 'periode'; 
	$crud = new grocery_CRUD();
	$crud->set_table('periode');
	$crud->set_subject('Periode');
	$crud->required_fields('tahun','periode','mulai','akhir_auditee','akhir_auditor');
	$crud->order_by('id_periode','desc');
	
	$output = $crud->render();

	$this->main($output,$data);
}

function jadwal()
{
	$data = array();
	$data['sub'] = 'Penugasan';
	$data['sub_link'] = 'penugasan';
	$data['subsub'] = 'Jadwal';
	$data['subsub_link'] = 'jadwal'; 
	$crud = new grocery_CRUD();
	$crud->set_table('jadwal');
	$crud->set_subject('Jadwal');
	$crud->where('validasi_auditor = "Belum"');	 
	$crud->columns('id_periode','id_instrumen','id_auditee','validasi_auditee','auditor','validasi_auditor');
	$crud->set_relation('id_auditee','auditee','prodi',null,'id_auditee asc')
		 ->set_relation('id_periode','periode','{periode} - tahun {tahun}')
		 ->set_relation('id_instrumen','instrumen','{instrumen} - {jenjang}',array('status' => 'Aktif'));
	$crud->unset_fields('validasi_auditor','validasi_auditee');
	$crud->set_relation_n_n('auditor', 'jadwal_auditor', 'auditor', 'id_jadwal', 'id_auditor','<br>{nama}');
	//$crud->set_relation_n_n('validasi_auditor', 'jadwal_auditor', 'auditor', 'id_jadwal', 'id_auditor', '<br>{nama} - {jadwal_auditor.validasi_auditor}');
	$crud->callback_column('auditor',array($this,'_callback_validasi_auditor'));
	$crud->order_by('id_jadwal','desc');
	$crud->display_as('id_periode','Periode')
		 ->display_as('id_instrumen','instrumen')
		 ->display_as('id_auditee','Auditee')
		 ->display_as('validasi_auditee','Status Validasi Auditee')
		 ->display_as('validasi_auditor','Status Validasi Auditor');
	$crud->required_fields('id_auditee','id_periode','id_instrumen','auditor');
	
	$output = $crud->render();

	$this->main($output,$data);
}

function _callback_validasi_auditor($value, $row)
{
	return ltrim($value,'<br>');	
}

//------------------------- Laporan ------------------------------//	
function pilih_laporan()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data["periode"] = $this->Admin_model->Total_Data('periode');
	$data["fakultas"] = $this->Admin_model->Total_Data('fakultas');
	$data["info"] = $this->Admin_model->Pilih_Content('informasi','id_informasi = 5');
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/pilih_laporan');
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

function laporan_unsri()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$id_periode = $this->input->post('id_periode');
	$data['id_periode'] = $id_periode;
	$data['periode'] = $this->Admin_model->Total_Data("periode where id_periode = $id_periode");
	$data['laporan'] = $this->Admin_model->Pilih_Laporan_Periode($id_periode); 
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/laporan_unsri');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
	}else{
		?>
		<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
	<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
}

function print_laporan_unsri()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$id_periode = $this->input->post('id_periode');
	$data['id_periode'] = $id_periode;
	$data['periode'] = $this->Admin_model->Total_Data("periode where id_periode = $id_periode");
	$data['laporan'] = $this->Admin_model->Pilih_Laporan_Periode($id_periode); 
	//$this->load->view('pimpinan/print_laporan_unsri',$data);
	
	$this->load->library('pdf');
	$this->pdf->set_paper('A4', 'portrait');
	$this->pdf->load_view('admin/print_laporan_unsri',$data);
 	$this->pdf->render();
 	foreach($data['periode']->result_array() as $p)
		{	
			$semester = $p['periode'];
			$tahun = $p['tahun'];
			$this->pdf->stream("Laporan AMAI ".$semester." - ".$tahun.".pdf");
		}
	 }else{
		?>
		<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
	<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
}

function daftar_laporan()
{
	$data = array();
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$id_periode = $this->input->post('id_periode');
	$id_fakultas = $this->input->post('id_fakultas');
	if($id_periode == "ALL")
	{   if($id_fakultas == "ALL")
		{ $data['laporan'] = $this->Admin_model->Laporan_All(); } 
		else
		{ $data['laporan'] = $this->Admin_model->Pilih_Laporan_Fakultas($id_fakultas); }
	}
	else
	{
		if($id_fakultas == "ALL")
		{ $data['laporan'] = $this->Admin_model->Pilih_Laporan_Periode($id_periode); } 
		else
		{ $data['laporan'] = $this->Admin_model->Pilih_Laporan($id_periode,$id_fakultas); }
	}
	$this->load->view('admin/part_atas',$data);
	$this->load->view('admin/part_kiri');
	$this->load->view('admin/daftar_laporan');
	$this->load->view('admin/part_bawah');
	$this->load->view('admin/part_js');
	}else{
		?>
		<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
	<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
}

function hasil()
{
	$id_jadwal = $this->uri->segment(3);
	$data = array();
	
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$data['sub'] = 'Pilih Laporan';
	$data['sub_link'] = 'pilih_laporan';
		$data['jadwal'] = $this->Admin_model->Total_Data("jadwal, auditee, instrumen, periode where id_jadwal = $id_jadwal AND jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen AND periode.id_periode = jadwal.id_periode AND validasi_auditor = 'Sudah'");
		if (count($data['jadwal']->result_array())>0)
		{
			foreach($data['jadwal']->result_array() as $i)
			{
				$id_instrumen = $i['id_instrumen'];
				$data['id_instrumen'] = $id_instrumen;
				$validasi_auditee = $i['validasi_auditee'];
				$data['id_jadwal']= $i['id_jadwal'];
				$data['prodi'] = $i['prodi'];
				$data['instrumen'] = $i['instrumen'];
				$id_visimisi = $i['id_visimisi'];
				$data['id_visimisi'] = $i['id_visimisi'];
				$data['periode']=$i['periode']." - Tahun ".$i['tahun'];
			}	
			
			$data['strategi'] = $this->Admin_model->Total_Data("strategi where id_visimisi = $id_visimisi");
			$data['jadwal_auditor'] = $this->Admin_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal");
			$data['sum'] = $this->Admin_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['standar_rubrik'] = $this->Admin_model->Standar_Rubrik($id_instrumen); 
			$data['sum'] = $this->Admin_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['perspektif_bsc'] = $this->Admin_model->Perspektif_Bsc("$id_instrumen");
			$this->load->view('admin/part_atas',$data);
			$this->load->view('admin/part_kiri');
			$this->load->view('admin/grafik_bsc');
			$this->load->view('admin/part_bawah');
			$this->load->view('admin/part_js_other');
		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Auditor belum melakukan validasi, Laporan belum tersedia...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/pilih_laporan'>";
			}
	}
	else{
		?>
		<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
	<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/jadwal'>";
	}	
}

function print_laporan_auditee()
{
	$id_jadwal = $this->uri->segment(3);
	$data = array();
	
	$session=isset($_SESSION['admin_session']) ? $_SESSION['admin_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_pimpinan"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$data['sub'] = 'Pilih Laporan';
	$data['sub_link'] = 'pilih_laporan';
		$data['jadwal'] = $this->Admin_model->Total_Data("jadwal, auditee, instrumen, periode where id_jadwal = $id_jadwal AND jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen AND periode.id_periode = jadwal.id_periode AND validasi_auditor = 'Sudah'");
		if (count($data['jadwal']->result_array())>0)
		{
			foreach($data['jadwal']->result_array() as $i)
			{
				$id_instrumen = $i['id_instrumen'];
				$data['id_instrumen'] = $id_instrumen;
				$validasi_auditee = $i['validasi_auditee'];
				$data['id_jadwal']= $i['id_jadwal'];
				$data['prodi'] = $i['prodi'];
				$data['instrumen'] = $i['instrumen'];
				$id_visimisi = $i['id_visimisi'];
				$data['id_visimisi'] = $i['id_visimisi'];
				$data['periode']=$i['periode']." - Tahun ".$i['tahun'];
			}	
			
			$data['strategi'] = $this->Admin_model->Total_Data("strategi where id_visimisi = $id_visimisi");
			$data['jadwal_auditor'] = $this->Admin_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal");
			$data['sum'] = $this->Admin_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['standar_rubrik'] = $this->Admin_model->Standar_Rubrik($id_instrumen); 
			$data['perspektif_bsc'] = $this->Admin_model->Perspektif_Bsc("$id_instrumen");
			//$this->load->view('pimpinan/laporan_auditee',$data);
	
			$this->load->library('pdf');
			$this->pdf->set_paper('A4', 'portrait');
			$this->pdf->load_view('admin/laporan_auditee',$data);
 			$this->pdf->render();
 			$this->pdf->stream("Laporan AMAI - ".$data['prodi']." ".$data['periode'].".pdf");
	 }else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Auditor belum melakukan validasi, Laporan belum tersedia...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/pilih_laporan'>";
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
	
}