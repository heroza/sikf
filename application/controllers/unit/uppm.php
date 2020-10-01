<?php
class Uppm extends CI_Controller
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
	$this->load->model('Publikasi_model');
	$this->load->model('Penulis_model');
	$this->load->model('Other_model');
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
		
		$data["info"] = $this->Unit_model->Pilih_Content('informasi','id_informasi = 10');
		$this->load->view('unit/uppm/part_atas',$data);
		$this->load->view('unit/uppm/part_kiri');
		$this->load->view('unit/uppm/index');
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
	$username=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($username!="")
	{
		$unit = $this->Unit_model->unitByUsername($username);
		$data["id_unit"]=$unit->id_unit;
		$data["nama"]=$unit->nama;
	
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
	$username=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
	if($username!="")
	{
		$unit = $this->Unit_model->unitByUsername($username);
		$data["id_unit"]=$unit->id_unit;
		$data["nama"]=$unit->nama;
	
		$this->load->view('unit/uppm/part_atas',$data);
		$this->load->view('unit/uppm/part_kiri');
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

function dosen_meneliti()
{
	$data = array();
	$data['sub'] = 'Dosen Meneliti';
	$data['home'] = 'uppm';
	$data['sub_link'] = 'uppm/dosen_meneliti';
	$crud = new grocery_CRUD();
	$crud->set_table('dosen_meneliti');
	$crud->set_subject('Dosen Meneliti');
	$crud->set_relation('kode_penelitian','penelitian','judul');
	$crud->set_relation('kode_dosen','dosen','nama');
	$crud->set_relation('kode_meneliti_sebagai','meneliti_sebagai','nama');
	$crud->required_fields('kode_penelitian','kode_dosen','kode_meneliti_sebagai');
	$crud->columns('kode_penelitian','kode_dosen','kode_meneliti_sebagai');
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function anggotapenelitian()
{
	$kode_penelitian = $this->uri->segment(4);

	$data = array();
	$data['title'] = 'Anggota Penelitian';
	$data['crumbs'] = array('Penelitian','Anggota Penelitian');
	$data['crumbs_link'] = array('unit/uppm/penelitian','');
	$crud = new grocery_CRUD();
	$crud->set_table('dosen_meneliti');
	$crud->set_subject('Anggota Penelitian');
	// $crud->set_relation('kode_penelitian','penelitian','judul');
	$crud->set_relation('kode_dosen','dosen','nama');
	$crud->set_relation('kode_meneliti_sebagai','meneliti_sebagai','nama');
	$crud->required_fields('kode_dosen','kode_meneliti_sebagai');
	$crud->columns('kode_dosen','kode_meneliti_sebagai');
	$crud->display_as('kode_penelitian','Penelitian');
	$crud->display_as('kode_dosen','Dosen');
	$crud->display_as('kode_meneliti_sebagai','Meneliti sebagai');

	$crud->field_type('kode_penelitian', 'hidden', $kode_penelitian);
	$crud->where('dosen_meneliti.kode_penelitian',$kode_penelitian);
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function anggotapm()
{
	$kode_pengabdian_masyarakat = $this->uri->segment(4);

	$data = array();
	$data['title'] = 'Anggota Pengabdian Masyarakat';
	$data['crumbs'] = array('Pengabdian Masyarakat','Anggota Pengabdian Masyarakat');
	$data['crumbs_link'] = array('unit/uppm/pm','');
	$crud = new grocery_CRUD();
	$crud->set_table('dosen_mengabdi');
	$crud->set_subject('Anggota Pengabdian Masyarakat');
	$crud->set_relation('kode_pengabdian_masyarakat','pengabdian_masyarakat','judul');
	$crud->set_relation('kode_dosen','dosen','nama');
	$crud->set_relation('kode_mengabdi_sebagai','mengabdi_sebagai','nama');
	$crud->required_fields('kode_pengabdian_masyarakat','kode_dosen','kode_mengabdi_sebagai');
	$crud->columns('kode_pengabdian_masyarakat','kode_dosen','kode_mengabdi_sebagai');
	$crud->display_as('kode_pengabdian_masyarakat','pengabdian_masyarakat');
	$crud->display_as('kode_dosen','Dosen');
	$crud->display_as('kode_mengabdi_sebagai','Mengabdi sebagai');

	$crud->field_type('kode_pengabdian_masyarakat', 'hidden', $kode_pengabdian_masyarakat);
	$crud->where('dosen_mengabdi.kode_pengabdian_masyarakat',$kode_pengabdian_masyarakat);
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function penulis()
{
	$kode_publikasi = $this->uri->segment(4);
	$publikasi = $this->Publikasi_model->getByKodePublikasi($kode_publikasi);
	$id_prodi = 0; 
	$kode_penelitian = 0; 
	foreach($publikasi -> result_array() as $item) 
	{
		// $id_prodi = $item['id_prodi']; 
		$kode_penelitian = $item['penelitian']; 
	}

	$data = array();
	$data['title'] = 'Penulis Publikasi';
	$data['crumbs'] = array('Publikasi','Penulis');
	$data['crumbs_link'] = array('unit/uppm/publikasi/'.$kode_penelitian,'');
	$crud = new grocery_CRUD();
	$crud->set_table('penulis');
	$crud->set_subject('Penulis');
	// $crud->set_relation('kode_publikasi','publikasi','judul');
	$crud->set_relation('kode_dosen','dosen','nama');
	$crud->set_relation('kode_penulis_sebagai','penulis_sebagai','nama');
	$crud->required_fields('kode_dosen','kode_penulis_sebagai');
	$crud->columns('kode_dosen','kode_penulis_sebagai');
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
	$data = array();
	$data['title'] = 'Penelitian';
	$data['crumbs'] = array('');
	$data['crumbs_link'] = array('');
	$crud = new grocery_CRUD();
	$crud->set_table('penelitian');
	$crud->set_subject('Penelitian');
	// $crud->set_relation('id_prodi','prodi','prodi');
	$crud->set_relation('skim','skim','deskripsi');
	$crud->set_relation('sumber_dana','sumber_dana','deskripsi');
	// $crud->set_relation('ketua_peneliti','dosen','nama');
	// $crud->set_relation_n_n('anggota', 'dosen_meneliti', 'dosen', 'kode_penelitian', 'kode_dosen', 'nama');
	$crud->required_fields('judul');
	$crud->set_field_upload('file_laporan','assets/uploads/files');
	// $crud->field_type('sumber_dana', 'hidden', '-');
	$crud->field_type('ketua_peneliti', 'hidden', 0);
	$crud->columns('judul','tahun_pelaksanaan', 'file_laporan', 'pelaksana');
	$crud->callback_column('pelaksana',array($this,'_callback_peneliti')); 
	// $crud->callback_column('publikasi',array($this,'_callback_publikasi')); 
	// $crud->callback_before_insert(array($this,'parse_code_callback'));
	// $crud->callback_before_update(array($this,'parse_code_callback'));

  	$crud->callback_column('jumlah_dana',array($this,'format_currency_callback'));
	$crud->display_as('tahun_pelaksanaan','Tahun');
	// $crud->display_as('id_prodi','Prodi');
		 
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
		$data['crumbs_link'] = array('unit/uppm/penelitian','');
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
	$crud->columns('judul', 'tahun', 'penulis');
	$crud->callback_column('penulis',array($this,'_callback_penulis')); 
	$crud->display_as('tahun_pelaksanaan','Tahun');
	$crud->display_as('url','URL');
	$crud->display_as('tempat','Publisher');
	$output = $crud->render();
	$this->main($output,$data);
}

function _callback_peneliti($value, $row)
{
	$namaArray = $this->Dosen_meneliti_model->getNamaPenelitiByKodePenelitian($row->kode_penelitian);
	return "<a href='".site_url('unit/uppm/anggotapenelitian/'.$row->kode_penelitian)."' title='Anggota'><img src='".base_url()."asset/img/plus.png'> ($namaArray)</a>";
}

function _callback_penulis($value, $row)
{
	$namaArray = $this->Penulis_model->getNamaPenulisByKodePublikasi($row->kode_publikasi);
	return "<a href='".site_url('unit/uppm/penulis/'.$row->kode_publikasi)."' title='Anggota'><img src='".base_url()."asset/img/plus.png'> ($namaArray)</a>";
}

function _callback_publikasi($value, $row)
{
	$hasil = $this->Publikasi_model->getByKodePenelitian($row->kode_penelitian);
	$jumlah = count($hasil->result_array());
			return "
		<a href='".site_url('unit/uppm/publikasi/'.$row->kode_penelitian)."' title='Publikasi'><img src='".base_url()."asset/img/plus.png'> Publikasi ($jumlah)</a>
		";
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
	// $crud->field_type('tahun_pelaksanaan', 'hidden', '-');
	// $crud->field_type('tingkat', 'hidden', '-');
	// $crud->field_type('sumber_dana', 'hidden', '-');
	$crud->columns('judul','tahun_pelaksanaan', 'dosen_mengabdi');
	$crud->callback_column('dosen_mengabdi',array($this,'_callback_dosen_mengabdi')); 
	// $crud->callback_before_insert(array($this,'parse_code_callback'));

  	$crud->callback_column('jumlah_dana',array($this,'format_currency_callback'));
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function anggotapengabdian()
{
	$kode_pengabdian_masyarakat = $this->uri->segment(4);

	$data = array();
	$data['title'] = 'Anggota Pengabdian';
	$data['crumbs'] = array('Pengabdian','Anggota Pengabdian');
	$data['crumbs_link'] = array('unit/uppm/pm','');
	$crud = new grocery_CRUD();
	$crud->set_table('dosen_mengabdi');
	$crud->set_subject('Anggota Pengabdian');
	// $crud->set_relation('kode_pengabdian_masyarakat','pengabdian_masyarakat','judul');
	$crud->set_relation('kode_dosen','dosen','nama');
	$crud->set_relation('kode_mengabdi_sebagai','mengabdi_sebagai','nama');
	$crud->required_fields('kode_dosen','kode_mengabdi_sebagai');
	$crud->columns('kode_dosen','kode_mengabdi_sebagai');
	$crud->display_as('kode_pengabdian_masyarakat','Pengabdian');
	$crud->display_as('kode_dosen','Dosen');
	$crud->display_as('kode_mengabdi_sebagai','Mengabdi sebagai');

	$crud->field_type('kode_pengabdian_masyarakat', 'hidden', $kode_pengabdian_masyarakat);
	$crud->where('dosen_mengabdi.kode_pengabdian_masyarakat',$kode_pengabdian_masyarakat);
		 
	$output = $crud->render();

	$this->main($output,$data);
}

function _callback_dosen_mengabdi($value, $row)
{
	$namaArray = $this->Dosen_mengabdi_model->getNamaPengabdiByKodePengabdian($row->kode_pengabdian_masyarakat);
	return "<a href='".site_url('unit/uppm/anggotapengabdian/'.$row->kode_pengabdian_masyarakat)."' title='Anggota'><img src='".base_url()."asset/img/plus.png'> ($namaArray)</a>";
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

function parse_code_callback($post_array) {

  //pengkodean filename
  $code = explode("-", $post_array['file_publikasi']);
  $code = explode(".", $code[1]);
  $code = explode(":", $code[0]);
  //perlu ditambahkan validasi kode
  $post_array['tahun_publikasi'] = $code[1];

  switch ($code[2]) {
  	case '1':
  		$tingkat = 'Lokal';
  		break;
  	
  	case '2':
  		$tingkat = 'Nasional';
  		break;
  	
  	case '3':
  		$tingkat = 'Internasional';
  		break;
  	
  	default:
  		$tingkat = '';
  		break;
  }
  $post_array['tingkat'] = $tingkat;

  switch ($code[3]) {
  	case '1':
  		$sumber_dana = 'Pembiayaan sendiri oleh peneliti';
  		break;
  	
  	case '2':
  		$sumber_dana = 'PT yang bersangkutan';
  		break;
  	
  	case '3':
  		$sumber_dana = 'Depdiknas';
  		break;
  	
  	case '4':
  		$sumber_dana = 'Institusi dalam negeri di luar Depdiknas';
  		break;
  	
  	case '5':
  		$sumber_dana = 'Institusi luar negeri';
  		break;
  	
  	default:
  		$sumber_dana = '';
  		break;
  }
  $post_array['sumber_dana'] = $sumber_dana;
 
  return $post_array;
} 

function change_password($message = '')
	{
		$data = array();
		$username=isset($_SESSION['unit_session']) ? $_SESSION['unit_session']:'';
		if($username!="")
		{
			$unit = $this->Unit_model->unitByUsername($username);
			$data["username"]=$username;
			$data["nama"]=$unit->nama;
			$data["owner"]='unit/uppm';

			if ($message == 'wrongpassword') {
				$data["message"]="Password lama yang Anda masukkan salah.";
			}
			elseif ($message == 'success') {
				$data["message"]="<font color='#0000FF'>Password Anda berhasil dirubah.</font>";
			}
			else
				$data["message"]='';
			
			$this->load->view('unit/uppm/part_atas',$data);
			$this->load->view('unit/uppm/part_kiri');
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
			redirect('/unit/uppm/change_password/wrongpassword/', 'location');
		} else {
			
		
			$data = array(
				'password' => $_POST['newpassword']
				);
			$this->Other_model->change_password($_POST['username'], $data);
			redirect('/unit/uppm/change_password/success/', 'location');
		}
	}

	function logout()
	{
		unset($_SESSION['unit_session']);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}	
}