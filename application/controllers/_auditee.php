<?php
class auditee extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->database();
		$this->load->helper(array('form','url','cookie','date'));
		$this->load->library(array('grocery_CRUD','Pagination'));
		$this->load->model('Auditee_model');
		$this->input->set_cookie();
	}
	
	function index()
	{
		$data = array();
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		
		$data["info"] = $this->Auditee_model->Pilih_Content('informasi','id_informasi = 1');
		$this->load->view('auditee/part_atas',$data);
		$this->load->view('auditee/part_kiri');
		$this->load->view('auditee/index');
		$this->load->view('auditee/part_bawah');
		$this->load->view('auditee/part_js');
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
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		
		$this->load->view('auditee/part_atas',$data);
		$this->load->view('auditee/part_kiri');
		$this->load->view('auditee/theme');
		$this->load->view('auditee/part_bawah');
		$this->load->view('auditee/part_js');
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
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		
		$this->load->view('auditee/part_atas',$data);
		$this->load->view('auditee/part_kiri');
		$this->load->view('auditee/part_isi',$output);
		$this->load->view('auditee/part_bawah');
		$this->load->view('auditee/part_js_other');	
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
		$tabel = "auditee";
		$seleksi = "username"; 
		$hasil = $this->Auditee_model->Cek($tabel,$seleksi,$cari);
		if (count($hasil->result_array())==0){
			echo "<br><font color='#00FF00'>Username ' $cari ' belum digunakan, silahkan melanjutkan mengisi form </font>";
   		}else{
    		echo "<br><blink><font color='#FF0000'>Maaf, username ' $cari ' sudah digunakan, silahkan ganti dengan yang lain</font></blink>";
    	}
	}
	
	function profil()
	{
		$data = array();
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		$id=$pecah[0];
		$data["edit"] = $this->Auditee_model->Pilih_Content("auditee","id_auditee=$id");
		$this->load->view('auditee/part_atas',$data);
		$this->load->view('auditee/part_kiri');
		$this->load->view('auditee/profil');
		$this->load->view('auditee/part_bawah');
		$this->load->view('auditee/part_js');
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
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		
		$data2["id_auditee"] = $this->input->post('id_auditee');
		$data2["nip"] = $this->input->post('nip');
		$data2["kaprodi"] = $this->input->post('kaprodi');
		$data2["telp"] = $this->input->post('telp');
		$data2["email"] = $this->input->post('email');
		$data2["alamat"] = $this->input->post('alamat');
		$data2["username"] = $this->input->post('username');
		
		$cari = $this->input->post('username');
		$tabel = "auditee";
		$seleksi = "username"; 
		$hasil = $this->Auditee_model->Cek($tabel,$seleksi,$cari);
			if (count($hasil->result_array())==0)
			{
				if($this->input->post('password') != '')
				{   
					if($this->input->post('password') == $this->input->post('password2'))
					{
						$passwordmd5 = md5($this->input->post('password'));
						$passwordhash = md5($passwordmd5);							
						$data2["password"] = $passwordhash;
						$this->Auditee_model->Update_Content("auditee",$data2,"id_auditee");
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee'>";
					}
					else{?>
						<script type="text/javascript" language="javascript">
						alert("Password Anda tidak sama...!!!");</script><?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/profil'>";
					}
				}
				else{	
				$this->Auditee_model->Update_Content("auditee",$data2,"id_auditee");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee'>";
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
							$this->Auditee_model->Update_Content("auditee",$data2,"id_auditee");
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee'>";
						}
						else{?>
							<script type="text/javascript" language="javascript">
							alert("Password Anda tidak sama...!!!");</script><?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/profil'>";
						}
					}
					else{	
						$this->Auditee_model->Update_Content("auditee",$data2,"id_auditee");
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee'>";
					}
				}
				else
				{
				?>
				<script type="text/javascript" language="javascript">
					alert("Username telah digunakan, Silahkan ganti dengan username lain");
				</script><?php	
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/profil'>";
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
		unset($_SESSION['auditee_session']);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
//------------------------- Penugasan ------------------------------//	
	function penugasan()
	{
		$data = array();
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		
		$data["info"] = $this->Auditee_model->Pilih_Content('informasi','id_informasi = 4');
		$this->load->view('auditee/part_atas',$data);
		$this->load->view('auditee/part_kiri');
		$this->load->view('auditee/penugasan');
		$this->load->view('auditee/part_bawah');
		$this->load->view('auditee/part_js');
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

	function upload()
	{
		$id_jadwal = $this->uri->segment(3);
		$data = array();
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		$data["id_jadwal"]=$id_jadwal;
		
		$data["info"] = $this->Auditee_model->Pilih_Content('informasi','id_informasi = 4');
		$this->load->view('auditee/part_atas',$data);
		$this->load->view('auditee/part_kiri');
		$this->load->view('auditee/upload');
		$this->load->view('auditee/part_bawah');
		$this->load->view('auditee/part_js');
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

	function do_upload()
	{
		$id_jadwal = $this->input->post('id_jadwal'); 
		$this->load->library('parsecsv.php');
		$csv = new parseCSV();
		$csv->auto($_FILES["file"]["tmp_name"]);
		$tempkode = "";
		$tempjudul = "";
		$tempkondisi = "";
		$temphambatan = "";
		$tempinisiatif = "";
		foreach ($csv->data as $column => $row):
			foreach ($row as $key => $value):
				if ($key == "kode") {
					if ($value == "END")
						break;
					else
						$tempkode = $value;
				} else if ($key == "judul") {
					$tempjudul = $value;
				} else if ($key == "isian") {
					if ($tempjudul == "kondisi") {
						$tempkondisi = $value;
					} else if ($tempjudul == "hambatan") {
						$temphambatan = $value;
					} else if ($tempjudul == "inisiatif") {
						$tempinisiatif = $value;
					} else if ($tempjudul == "realisasi") {
						$this->save_isian_with($id_jadwal, $tempkode, $tempkondisi, $temphambatan, $tempinisiatif, $value);
					} else {
						$datainsert = array();
						$datainsert['judul'] = $tempjudul;
						$datainsert['isi'] = $value;
						$this->Auditee_model->Update_Content('informasi', $datainsert, "judul");
					}
					
				}
			endforeach;
		endforeach;
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/isian/".$id_jadwal."'>";
	}
	
	function jadwal()
	{
		$data = array();
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		}
		$data['sub'] = 'Penugasan';
		$data['sub_link'] = 'penugasan';
		$data['subsub'] = 'Jadwal';
		$data['subsub_link'] = 'jadwal'; 
		$crud = new grocery_CRUD();
		$crud->set_table('jadwal');
		$crud->set_subject('Jadwal');
		$crud->where('jadwal.id_auditee',$data["id_auditee"]);
		$crud->where('jadwal.validasi_auditor','Belum');
		$crud->columns('id_periode','id_instrumen','id_auditee','validasi_auditee','auditor','Actions');
		$crud->set_relation('id_auditee','auditee','prodi')
			 ->set_relation('id_periode','periode','{periode} - Tahun {tahun}<br>{mulai} s/d {akhir_auditee}')
			 ->set_relation('id_instrumen','instrumen','{instrumen} - {jenjang}');
		$crud->unset_fields('validasi_auditee');
		$crud->unset_fields('Validasi');
		$crud->set_relation_n_n('auditor', 'jadwal_auditor', 'auditor', 'id_jadwal', 'id_auditor', '<br>{nama} - {validasi_auditor}');
		$crud->callback_column('auditor',array($this,'_callback_validasi_auditor'));
		$crud->order_by('id_jadwal','desc');
		$crud->unset_add()
			 ->unset_edit()
			 ->unset_delete();
		$crud->display_as('id_periode','Jadwal Isian Auditee')
			 ->display_as('id_instrumen','Instrumen')
			 ->display_as('id_auditee','Auditee')
			 ->display_as('validasi_auditee','Status Validasi Auditee')
			 ->display_as('auditor','Auditor - Status Validasi Auditor');
		$crud->callback_column('Actions',array($this,'_callback_actions_penilaian'));
		$output = $crud->render();
		$this->main($output,$data);
	}
	function _callback_validasi_auditor($value, $row)
	{
	  return ltrim($value,'<br>');
	}
	
	function _callback_actions_penilaian($value, $row)
	{
		//Kode Jam Indonesia
		$dat_server = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));
		$diff_gmt = substr(date("O",$dat_server),1,2);
		$datdif_gmt = 60 * 60 * $diff_gmt;
		if (substr(date("O",$dat_server),0,1) == '+') {
		$dat_gmt = $dat_server - $datdif_gmt;
		} else {
		$dat_gmt = $dat_server + $datdif_gmt;
		}
		$datdif_id = 60 * 60 * 7;
		$dat_id = $dat_gmt + $datdif_id;
		$tanggal = date("Y-m-d", $dat_id);
		
		$data = array();
		$data["cek_tgl"] = $this->Auditee_model->Pilih_Content("periode","id_periode = $row->id_periode");
		foreach($data["cek_tgl"] -> result_array() as $c) 
		{
		  if($c['mulai']<=$tanggal && $tanggal<=$c['akhir_auditee'])
		  {
			if($row->validasi_auditee == 'Belum')
			{
			return "<center>
					<a href='".site_url('auditee/isian/'.$row->id_jadwal)."' title='Input Isian Auditee'><img src='".base_url()."asset/img/audit.png'>Isian Auditee</a>
					<a href='".site_url('auditee/validasi/'.$row->id_jadwal)."' title='Validasi Hasil Isian Auditee' onclick='return confirm(\"Isian Auditee tidak dapat diubah apabila telah divalidasi, Apakah Anda yakin ingin melakukan validasi?\")'><img src='".base_url()."asset/img/padlock.png'>Validasi</a>
					<a href='".site_url('auditee/upload/'.$row->id_jadwal)."' title='Upload Isian Auditee'><img src='".base_url()."asset/img/upload.png'>Upload Isian</a></center>"; 
			}else
			{
			return "<center><blink><font color='#006600'>Anda telah melakukan Validasi Isian Auditee<br>Auditor akan melakukan penilaian dan kunjungan audit</font></blink>
					<a href='".site_url('cetak/borang/'.$row->id_jadwal)."' title='Cetak Borang'><br /><img src='".base_url()."asset/img/icon/print.png'>Cetak Borang</a></center>";	
			}
		  }else
		  {
			if($row->validasi_auditee == 'Belum')
			{
		  	return "<center><blink><font color='#FF0000'>Maaf, waktu pengisian habis. Silahkan langsung validasi</font></blink><br>
					<a href='".site_url('auditee/validasi/'.$row->id_jadwal)."' title='Validasi Hasil Isian Auditee' onclick='return confirm(\"Isian Auditee tidak dapat diubah apabila telah divalidasi, Apakah Anda yakin ingin melakukan validasi?\")'><img src='".base_url()."asset/img/padlock.png'>Validasi</a></center>"; 
			}
			else
			{
			return "<center><blink><font color='#006600'>Anda telah melakukan Validasi Isian Auditee<br>Auditor akan melakukan penilaian dan kunjungan audit</font></blink></center>";	
			}
		  } 
		}
	}

//------------------------- Isian ------------------------------//		
	function isian()
	{
		$id_jadwal = $this->uri->segment(3);
		$data = array();
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditee"]=$pecah[0];
		$data["prodi"]=$pecah[1];
		$data['sub'] = 'Penugasan';
		$data['sub_link'] = 'penugasan';
		$data['subsub'] = 'Jadwal';
		$data['subsub_link'] = 'jadwal'; 
		$id_auditee = $data["id_auditee"];
		
		$jadwal = $this->Auditee_model->Total_Data("jadwal where id_jadwal = $id_jadwal");
		foreach($jadwal->result_array() as $i)
		{
			$id_instrumen = $i['id_instrumen'];
			$validasi_auditee = $i['validasi_auditee'];
			$id_cek = $i['id_auditee'];
			$id_periode = $i['id_periode'];
		}
		//Kode Jam Indonesia
		$dat_server = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));
		$diff_gmt = substr(date("O",$dat_server),1,2);
		$datdif_gmt = 60 * 60 * $diff_gmt;
		if (substr(date("O",$dat_server),0,1) == '+') {
		$dat_gmt = $dat_server - $datdif_gmt;
		} else {
		$dat_gmt = $dat_server + $datdif_gmt;
		}
		$datdif_id = 60 * 60 * 7;
		$dat_id = $dat_gmt + $datdif_id;
		$tanggal = date("Y-m-d", $dat_id);
		
		$data["cek_tgl"] = $this->Auditee_model->Pilih_Content("periode","id_periode = $id_periode");
		foreach($data["cek_tgl"] -> result_array() as $c) 
		{
		  if($c['mulai']<=$tanggal && $tanggal<=$c['akhir_auditee'])
		  {
			  
			if($validasi_auditee == 'Belum' && $id_auditee == $id_cek)
			{	
				
				$id_standar=$this->input->post('id_standar');
				if(!$id_standar)
				{
					$standar = $this->Auditee_model->Min('id_standar','rubrik',"id_instrumen = $id_instrumen");	
					foreach($standar->result_array() as $s)
					{
					$id_standar = $s['min'];
					}
				}
				$data['id_standar']= $id_standar;
				$data['rubrik'] = $this->Auditee_model->Pilih_Content('rubrik',"id_standar = $id_standar AND id_instrumen = $id_instrumen"); 
				$data['standar_rubrik'] = $this->Auditee_model->Standar_Rubrik($id_instrumen); 
				$this->load->view('auditee/part_atas',$data);
				$this->load->view('auditee/part_kiri');
				$this->load->view('auditee/isian');
				$this->load->view('auditee/part_bawah');
				$this->load->view('auditee/part_js');
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Anda dilarang untuk mengakses halaman ini...!!!");
				</script>
			<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/jadwal'>";
			}
		  }
		}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/jadwal'>";
		}	
	}
	
	function save_isian()
	{
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!=""){
		$id_rubrik=$this->input->post('id_rubrik'); $id_rubrik=strip_tags($id_rubrik);
		$id_jadwal=$this->input->post('id_jadwal'); $id_jadwal=strip_tags($id_jadwal);
		$kondisi=$this->input->post('kondisi'); 
		$hambatan=$this->input->post('hambatan'); 
		$inisiatif=$this->input->post('inisiatif'); 
		$realisasi_auditee=$this->input->post('realisasi_auditee'); $realisasi_auditee=strip_tags($realisasi_auditee);
		
		$data['cek_save'] = $this->Auditee_model->Total_Data("isian_auditee where id_jadwal = $id_jadwal AND id_rubrik = $id_rubrik");
		if (count($data['cek_save']->result_array())>0)
            {
				$this->update_isian();
			}
		else{	
			$datainsert = array();	
			if(!empty($_FILES['dokumen']['name']))
			{
				ini_set('post_max_size', '64M');
				ini_set('upload_max_filesize', '64M');
				$acak=rand(00000000000,99999999999);
				$bersih=$_FILES['dokumen']['name'];
				$bersih2=str_replace(" ","_","$bersih");
				$nm=str_replace("'","_","$bersih2");
				$pisah=explode(".",$nm);
				$nama_murni_lama = preg_replace("/^(.+?);.*$/", "\\1",$pisah[0]);
				$nama_murni=strtolower($nama_murni_lama);
				$num = (count($pisah) - 1);
				$ekstensi_kotor = $pisah[$num];
				
				$file_type = preg_replace("/^(.+?);.*$/", "\\1", $ekstensi_kotor);
				$file_type_baru = strtolower($file_type);
				
				$ubah=$acak.'-'.$nama_murni; 
				$n_baru = $ubah.'.'.$file_type_baru;
				$ori_src="asset/dokumen/".strtolower( str_replace(' ','_',$n_baru) );
				if(move_uploaded_file ($_FILES['dokumen']['tmp_name'],$ori_src))
				{
					chmod("$ori_src",0777);
					$datainsert['dokumen'] = $ori_src;
				echo"<font color='#00FF00'>Diupload<br></font>";
				}else{
					echo "Gagal upload<br><br>";
				}
			
			}
			$datainsert['realisasi_auditee'] = $realisasi_auditee;
			$datainsert['kondisi'] = $kondisi;
			$datainsert['hambatan'] = $hambatan;
			$datainsert['inisiatif'] = $inisiatif;
			$datainsert['id_rubrik'] = $id_rubrik;
			$datainsert['id_jadwal'] = $id_jadwal;
			$this->Auditee_model->Save_Content("isian_auditee",$datainsert);
			
			echo"<font color='#00FF00'>Disimpan</font>";
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

	
	function save_isian_with($id_jadwal, $id_rubrik, $kondisi, $hambatan, $inisiatif, $realisasi_auditee)
	{
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!=""){
		
		$data['cek_save'] = $this->Auditee_model->Total_Data("isian_auditee where id_jadwal = $id_jadwal AND id_rubrik = $id_rubrik");
		if (count($data['cek_save']->result_array())>0)
            {
				$this->update_isian_with($id_jadwal, $id_rubrik, $kondisi, $hambatan, $inisiatif, $realisasi_auditee);
			}
		else{	
			$datainsert = array();	
			$datainsert['realisasi_auditee'] = $realisasi_auditee;
			$datainsert['kondisi'] = $kondisi;
			$datainsert['hambatan'] = $hambatan;
			$datainsert['inisiatif'] = $inisiatif;
			$datainsert['id_rubrik'] = $id_rubrik;
			$datainsert['id_jadwal'] = $id_jadwal;
			$this->Auditee_model->Save_Content("isian_auditee",$datainsert);
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

	function update_isian()
	{
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!=""){
		$id_rubrik=$this->input->post('id_rubrik'); $id_rubrik=strip_tags($id_rubrik);
		$id_jadwal=$this->input->post('id_jadwal'); $id_jadwal=strip_tags($id_jadwal);
		$kondisi=$this->input->post('kondisi'); 
		$hambatan=$this->input->post('hambatan');
		$inisiatif=$this->input->post('inisiatif');
		$realisasi_auditee=$this->input->post('realisasi_auditee'); $realisasi_auditee=strip_tags($realisasi_auditee);
		
		$datainsert = array();	
		if(!empty($_FILES['dokumen']['name']))
		{
			ini_set('post_max_size', '64M');
			ini_set('upload_max_filesize', '64M');
			$acak=rand(00000000000,99999999999);
			$bersih=$_FILES['dokumen']['name'];
			$bersih2=str_replace(" ","_","$bersih");
			$nm=str_replace("'","_","$bersih2");
			$pisah=explode(".",$nm);
			$nama_murni_lama = preg_replace("/^(.+?);.*$/", "\\1",$pisah[0]);
			$nama_murni=strtolower($nama_murni_lama);
			$num = (count($pisah) - 1);
			$ekstensi_kotor = $pisah[$num];
			
			$file_type = preg_replace("/^(.+?);.*$/", "\\1", $ekstensi_kotor);
			$file_type_baru = strtolower($file_type);
			
			$ubah=$acak.'-'.$nama_murni; 
			$n_baru = $ubah.'.'.$file_type_baru;
			$ori_src="asset/dokumen/".strtolower( str_replace(' ','_',$n_baru) );
			if(move_uploaded_file ($_FILES['dokumen']['tmp_name'],$ori_src))
			{
				chmod("$ori_src",0777);
				$datainsert['dokumen'] = $ori_src;
				echo"<font color='#00FF00'>Diupload<br></font>";
			}else{
				echo "Gagal Upload<br><br>";
			}
		
		}
		$datainsert['realisasi_auditee'] = $realisasi_auditee;
		$datainsert['kondisi'] = $kondisi;
		$datainsert['hambatan'] = $hambatan;
		$datainsert['inisiatif'] = $inisiatif;
		$datainsert['id_rubrik'] = $id_rubrik;
		$datainsert['id_jadwal'] = $id_jadwal;
		$this->Auditee_model->Update_Content2("isian_auditee",$datainsert,"id_jadwal","id_rubrik");
		echo"<font color='#00FF00'>Disimpan</font>";
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

	function update_isian_with($id_jadwal, $id_rubrik, $kondisi, $hambatan, $inisiatif, $realisasi_auditee)
	{
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!=""){

		$datainsert = array();	
		$datainsert['realisasi_auditee'] = $realisasi_auditee;
		$datainsert['kondisi'] = $kondisi;
		$datainsert['hambatan'] = $hambatan;
		$datainsert['inisiatif'] = $inisiatif;
		$datainsert['id_rubrik'] = $id_rubrik;
		$datainsert['id_jadwal'] = $id_jadwal;
		$this->Auditee_model->Update_Content2("isian_auditee",$datainsert,"id_jadwal","id_rubrik");
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
	
	function validasi()
	{
		$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
		if($session!=""){
		$id_jadwal = $this->uri->segment(3);
			
		$datainsert = array();	
		$datainsert['validasi_auditee'] = 'Sudah';
		$datainsert['id_jadwal'] = $id_jadwal;
		$this->Auditee_model->Update_Content("jadwal",$datainsert,"id_jadwal");
		
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/jadwal'>";
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

//------------------------- Laporan ------------------------------//	
function pilih_laporan()
{
	$data = array();
	$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_prodi"]=$pecah[0];
	$data["prodi"]=$pecah[1];
	
	$data["periode"] = $this->Auditee_model->Total_Data('periode');
	$data["fakultas"] = $this->Auditee_model->Total_Data('fakultas');
	// $data["prodis"] = $this->Auditee_model->Total_Data('prodi');
	$data["info"] = $this->Auditee_model->Pilih_Content('informasi','id_informasi = 5');
	$this->load->view('auditee/part_atas',$data);
	$this->load->view('auditee/part_kiri');
	$this->load->view('auditee/pilih_laporan');
	$this->load->view('auditee/part_bawah');
	$this->load->view('auditee/part_js');
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

function daftar_laporan()
{
	$data = array();
	$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_prodi"]=$pecah[0];
	$data["prodi"]=$pecah[1];
	
	$id_periode = $this->input->post('id_periode');
	$prodi = $pecah[1];
	if($id_periode == "ALL")
	{   
		$data['laporan'] = $this->Auditee_model->Pilih_Laporan_Prodi($prodi);
	}
	else
	{
		$data['laporan'] = $this->Auditee_model->Pilih_Laporan($id_periode,$prodi);
	}
	$this->load->view('auditee/part_atas',$data);
	$this->load->view('auditee/part_kiri');
	$this->load->view('auditee/daftar_laporan');
	$this->load->view('auditee/part_bawah');
	$this->load->view('auditee/part_js');
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
	
	$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$data['sub'] = 'Pilih Laporan';
	$data['sub_link'] = 'pilih_laporan';
		$data['jadwal'] = $this->Auditee_model->Total_Data("jadwal, auditee, instrumen, periode where id_jadwal = $id_jadwal AND jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen AND periode.id_periode = jadwal.id_periode AND validasi_auditor = 'Sudah'");
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
			
			$data['strategi'] = $this->Auditee_model->Total_Data("strategi where id_visimisi = $id_visimisi");
			$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal");
			$data['sum'] = $this->Auditee_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['standar_rubrik'] = $this->Auditee_model->Standar_Rubrik($id_instrumen); 
			$data['sum'] = $this->Auditee_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['perspektif_bsc'] = $this->Auditee_model->Perspektif_Bsc("$id_instrumen");
			$data['total_penelitian_group'] = $this->Auditee_model->total_penelitian_group($data['prodi']);
			$this->load->view('auditee/part_atas',$data);
			$this->load->view('auditee/part_kiri');
			$this->load->view('auditee/grafik_bsc');
			$this->load->view('auditee/part_bawah');
			$this->load->view('auditee/part_js_other');
		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Auditor belum melakukan validasi, Laporan belum tersedia...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/pilih_laporan'>";
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

function print_laporan_auditee()
{
	$id_jadwal = $this->uri->segment(3);
	$data = array();
	
	$session=isset($_SESSION['auditee_session']) ? $_SESSION['auditee_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_pimpinan"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$data['sub'] = 'Pilih Laporan';
	$data['sub_link'] = 'pilih_laporan';
		$data['jadwal'] = $this->Auditee_model->Total_Data("jadwal, auditee, instrumen, periode where id_jadwal = $id_jadwal AND jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen AND periode.id_periode = jadwal.id_periode AND validasi_auditor = 'Sudah'");
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
			
			$data['strategi'] = $this->Auditee_model->Total_Data("strategi where id_visimisi = $id_visimisi");
			$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal");
			$data['sum'] = $this->Auditee_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['standar_rubrik'] = $this->Auditee_model->Standar_Rubrik($id_instrumen); 
			$data['perspektif_bsc'] = $this->Auditee_model->Perspektif_Bsc("$id_instrumen");
			//$this->load->view('pimpinan/laporan_auditee',$data);
	
			$this->load->library('pdf');
			$this->pdf->set_paper('A4', 'portrait');
			$this->pdf->load_view('auditee/laporan_auditee',$data);
 			$this->pdf->render();
 			$this->pdf->stream("Laporan AMAI - ".$data['prodi']." ".$data['periode'].".pdf");
	 }else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Auditor belum melakukan validasi, Laporan belum tersedia...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditee/pilih_laporan'>";
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