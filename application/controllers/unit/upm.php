<?php
class Upm extends CI_Controller
{
	
function __construct()
{
	parent::__construct();
	session_start();
	$this->load->database();
	$this->load->helper(array('form','url','cookie','date'));
	$this->load->library('grocery_CRUD');
	$this->load->model('Unit_model');
	$this->load->model('Dosen_meneliti_model');
	$this->load->model('Dosen_mengabdi_model');
	$this->load->model('Other_model');
	$this->load->model('Publikasi_model');
	$this->load->model('Penulis_model');
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
	
		$data["info"] = $this->Unit_model->Pilih_Content('informasi','id_informasi = 15');
		$this->load->view('unit/upm/part_atas',$data);
		$this->load->view('unit/upm/part_kiri');
		$this->load->view('unit/upm/index');
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
	
		$this->load->view('unit/upm/part_atas',$data);
		$this->load->view('unit/upm/part_kiri');
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

function riwayat()
{
	$data = array();
	$data['title'] = 'Histori Pengisian';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('dosen');
	$crud->set_subject('Histori Pengisian');
	$crud->set_relation('id_prodi','prodi','prodi');
	$crud->columns('id_prodi','nama','nip','nidn','actions');
	$crud->display_as('id_prodi','Program Studi');
	$crud->display_as('nip','NIP');
	$crud->display_as('nidn','NIDN');
	$crud->callback_column('actions',array($this,'_callback_histori')); 
	$crud->unset_add()
		 ->unset_read()
		 ->unset_edit()
		 ->unset_delete();
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function _callback_histori($value, $row)
{
	return "<a href='".site_url('cetak/skpengisian/'.$row->kode_dosen)."' title='Riwayat Pengisian'><img src='".base_url()."asset/img/histori.png'>Riwayat Pengisian</a>";
}

function historidosen()
{
	$username=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($username!="")
	{
		$unit = $this->Unit_model->unitByUsername($username);

		$data = array();
		$data['title'] = 'Histori Pengisian';
		$data['crumbs'] = array('');
		$data['crumbs_link'] = array('');
	
		$data["id_unit"]=$unit->id_unit;
		$data["nama"]=$unit->nama;
		
		$this->load->view('unit/upm/part_atas',$data);
		$this->load->view('unit/upm/part_kiri');
		$this->load->view('tabel_4_kolom');
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

function logout()
{
	unset($_SESSION['unit_session']);
	echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
}

function change_password($message = '')
{
	$data = array();
	$username=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($username!="")
	{
		$unit = $this->Unit_model->unitByUsername($username);
		
	
		$data["owner"]='unit/upm';
		$data["username"]=$username;
		$data["nama"]=$unit->nama;

		if ($message == 'wrongpassword') {
			$data["message"]="Password lama yang Anda masukkan salah.";
		}
		elseif ($message == 'success') {
			$data["message"]="<font color='#0000FF'>Password Anda berhasil dirubah.</font>";
		}
		else
			$data["message"]='';
		
		$this->load->view('unit/upm/part_atas',$data);
		$this->load->view('unit/upm/part_kiri');
		$this->load->view('v_change_password');
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

	public function do_change_password()
	{
		$password = $this->Other_model->password($_POST['username']);
		if ($password != $_POST['oldpassword']) {
			redirect('/unit/upm/change_password/wrongpassword/', 'location');
		} else {
			
		
			$data = array(
				'password' => $_POST['newpassword']
				);
			$this->Other_model->change_password($_POST['username'], $data);
			redirect('/unit/upm/change_password/success/', 'location');
		}
	}
	
}