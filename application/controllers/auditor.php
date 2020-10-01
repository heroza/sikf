<?php
class auditor extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->database();
		$this->load->helper(array('form','url','cookie','date'));
		$this->load->library('grocery_CRUD');
		$this->load->model('Auditor_model');
		$this->input->set_cookie();
	}
	
	function index()
	{
		$data = array();
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		
		$data["info"] = $this->Auditor_model->Pilih_Content('informasi','id_informasi = 1');
		$this->load->view('auditor/part_atas',$data);
		$this->load->view('auditor/part_kiri');
		$this->load->view('auditor/index');
		$this->load->view('auditor/part_bawah');
		$this->load->view('auditor/part_js');
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
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		
		$this->load->view('auditor/part_atas',$data);
		$this->load->view('auditor/part_kiri');
		$this->load->view('auditor/theme');
		$this->load->view('auditor/part_bawah');
		$this->load->view('auditor/part_js');
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
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		
		$this->load->view('auditor/part_atas',$data);
		$this->load->view('auditor/part_kiri');
		$this->load->view('auditor/part_isi',$output);
		$this->load->view('auditor/part_bawah');
		$this->load->view('auditor/part_js_other');	
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
		$tabel = "auditor";
		$seleksi = "username"; 
		$hasil = $this->Auditor_model->Cek($tabel,$seleksi,$cari);
		if (count($hasil->result_array())==0){
			echo "<br><font color='#00FF00'>Username ' $cari ' belum digunakan, silahkan melanjutkan mengisi form </font>";
   		}else{
    		echo "<br><blink><font color='#FF0000'>Maaf, username ' $cari ' sudah digunakan, silahkan ganti dengan yang lain</font></blink>";
    	}
	}
	
	function profil()
	{
		$data = array();
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$id=$pecah[0];
		$data["edit"] = $this->Auditor_model->Pilih_Content("auditor","id_auditor=$id");
		$this->load->view('auditor/part_atas',$data);
		$this->load->view('auditor/part_kiri');
		$this->load->view('auditor/profil');
		$this->load->view('auditor/part_bawah');
		$this->load->view('auditor/part_js');
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
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		
		$data2["id_auditor"] = $this->input->post('id_auditor');
		$data2["nama"] = $this->input->post('nama');
		$data2["nip"] = $this->input->post('nip');
		$data2["ttl"] = $this->input->post('ttl');
		$data2["jabatan"] = $this->input->post('jabatan');
		$data2["telp"] = $this->input->post('telp');
		$data2["email"] = $this->input->post('email');
		$data2["alamat"] = $this->input->post('alamat');
		$data2["pendidikan"] = $this->input->post('pendidikan');
		$data2["pelatihan"] = $this->input->post('pelatihan');
		$data2["pengalaman"] = $this->input->post('pengalaman');
		$data2["username"] = $this->input->post('username');
		
		$cari = $this->input->post('username');
		$tabel = "auditor";
		$seleksi = "username"; 
		$hasil = $this->Auditor_model->Cek($tabel,$seleksi,$cari);
			if (count($hasil->result_array())==0)
			{
				if($this->input->post('password') != '')
				{   
					if($this->input->post('password') == $this->input->post('password2'))
					{
						$passwordmd5 = md5($this->input->post('password'));
						$passwordhash = md5($passwordmd5);							
						$data2["password"] = $passwordhash;
						$this->Auditor_model->Update_Content("auditor",$data2,"id_auditor");
						$auditor_session=$this->input->post("id_auditor")."|".$this->input->post("nama");
						$_SESSION['auditor_session']=$auditor_session;
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor'>";
					}
					else{?>
						<script type="text/javascript" language="javascript">
						alert("Password Anda tidak sama...!!!");</script><?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/profil'>";
					}
				}
				else{	
				$this->Auditor_model->Update_Content("auditor",$data2,"id_auditor");
				$auditor_session=$this->input->post("id_auditor")."|".$this->input->post("nama");
				$_SESSION['auditor_session']=$auditor_session;
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor'>";
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
							$this->Auditor_model->Update_Content("auditor",$data2,"id_auditor");
							$auditor_session=$this->input->post("id_auditor")."|".$this->input->post("nama");
							$_SESSION['auditor_session']=$auditor_session;
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor'>";
						}
						else{?>
							<script type="text/javascript" language="javascript">
							alert("Password Anda tidak sama...!!!");</script><?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/profil'>";
						}
					}
					else{	
					$this->Auditor_model->Update_Content("auditor",$data2,"id_auditor");
					$auditor_session=$this->input->post("id_auditor")."|".$this->input->post("nama");
					$_SESSION['auditor_session']=$auditor_session;
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor'>";
					}
				}
				else
				{
				?>
				<script type="text/javascript" language="javascript">
					alert("Username telah digunakan, Silahkan ganti dengan username lain");
				</script><?php	
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/profil'>";
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
		unset($_SESSION['auditor_session']);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
//------------------------- jadwal ------------------------------//	
	function Penugasan()
	{
		$data = array();
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		
		$data["info"] = $this->Auditor_model->Pilih_Content('informasi','id_informasi = 4');
		$this->load->view('auditor/part_atas',$data);
		$this->load->view('auditor/part_kiri');
		$this->load->view('auditor/penugasan');
		$this->load->view('auditor/part_bawah');
		$this->load->view('auditor/part_js');
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
	
	function jadwal()
	{
		$data = array();
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$id = $data["id_auditor"];
		}
		$data['sub'] = 'Penugasan';
		$data['sub_link'] = 'penugasan';
		$data['subsub'] = 'Jadwal';
		$data['subsub_link'] = 'jadwal'; 
		
		
		$crud = new grocery_CRUD();
		$crud->set_table('jadwal');
		$crud->set_subject('Jadwal');
		$data2 = array();
		$data2["cek"] = $this->Auditor_model->Pilih_Content("jadwal_auditor","id_auditor = $id");
		if (count($data2["cek"]->result_array())>0)
		{
			if (count($data2["cek"]->result_array())==1)
			{
			$hasil = $this->Auditor_model->Max_Tugas("jadwal_auditor","id_auditor = $id order by id_jadwal desc");
			foreach($hasil -> result_array() as $max) {
			$maxtugas = $max['teratas'];		
			$where = "id_jadwal = $maxtugas AND validasi_auditor = 'Belum'";
			$crud->where($where);
			}
			}
			else
			{
			$hasil = $this->Auditor_model->Max_Tugas("jadwal_auditor","id_auditor = $id order by id_jadwal desc");
			foreach($hasil -> result_array() as $max) {
			$maxtugas = $max['teratas'];		
			$where = "id_jadwal = $maxtugas AND validasi_auditor = 'Belum'";
			$crud->where($where);
			}
			$data["info"] = $this->Auditor_model->Pilih_Content("jadwal_auditor","id_auditor = $id AND id_jadwal != $maxtugas order by id_jadwal desc");
			foreach($data["info"] -> result_array() as $row) {
				$tugas = $row['id_jadwal'];		
				$where = "id_jadwal = $tugas AND validasi_auditor = 'Belum'";
				$crud->or_where($where);
			}
			}
		}
		else
		{
			$crud->where('id_jadwal',0);	
		}
		$crud->columns('id_periode','id_instrumen','id_auditee','validasi_auditee','auditor','Actions');
		$crud->set_relation('id_auditee','auditee','prodi')
			 ->set_relation('id_periode','periode','{periode} - Tahun {tahun}<br>{mulai} s/d {akhir_auditor}')
			 ->set_relation('id_instrumen','instrumen','{instrumen} - {jenjang}');
		$crud->unset_fields('validasi_auditee');
		$crud->unset_fields('Validasi');
		$crud->set_relation_n_n('auditor', 'jadwal_auditor', 'auditor', 'id_jadwal', 'id_auditor', '<br>{nama} - {validasi_auditor}');
		$crud->callback_column('auditor',array($this,'_callback_validasi_auditor'));
		$crud->order_by('id_jadwal','desc');
		$crud->unset_add()
			 ->unset_edit()
			 ->unset_delete();
		$crud->display_as('id_periode','Jadwal Penilaian dan Kunjungan Audit')
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
		$data = array();
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$id_auditor = $data["id_auditor"];
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
		
		$data["cek_tgl"] = $this->Auditor_model->Pilih_Content("periode","id_periode = $row->id_periode");
		foreach($data["cek_tgl"] -> result_array() as $c) 
		{
		  if($c['mulai']<=$tanggal && $tanggal<=$c['akhir_auditor'])
		  {
			if($row->validasi_auditee == 'Sudah')
			{
				$data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_jadwal = $row->id_jadwal AND id_auditor = $id_auditor AND validasi_auditor = 'Belum'");
			if (count($data['jadwal_auditor']->result_array())>0)
            	{
				return "<center><a href='".site_url('auditor/penilaian/'.$row->id_jadwal)."' title='Input Penilaian Audit'><img src='".base_url()."asset/img/audit.png'>Penilaian</a>
					<a href='".site_url('auditor/kunjungan/'.$row->id_jadwal)."' title='Input Kunjungan Audit'><img src='".base_url()."asset/img/kunjungan.png'>Kunjungan</a>
					<a href='".site_url('auditor/validasi/'.$row->id_jadwal)."' title='Validasi Penilaian dan Kunjungan Audit' onclick='return confirm(\"Penilaian Auditor tidak dapat diubah apabila telah divalidasi, Apakah Anda yakin ingin melakukan validasi?\")'><img src='".base_url()."asset/img/padlock.png'>Validasi</a></center>"; 
				}
			else{
				return "<center><blink><font color='#006600'>Anda telah melakukan validasi penilaian<br>Laporan akan keluar apabila semua auditor telah validasi</font></blink></center>";
				}
			}
			else
			{
			return "<center><blink><font color='#FF0000'>Auditee belum melakukan validasi isian</font></blink></center>";	
			}
		  }else
		  {
			if($row->validasi_auditee == 'Sudah')
			{
		  	return "<center><blink><font color='#FF0000'>Maaf, waktu Penilaian habis. Silahkan langsung validasi</font></blink><br>
					<a href='".site_url('auditor/validasi_telat/'.$row->id_jadwal)."' title='Validasi Hasil Penilaian Auditor' onclick='return confirm(\"Penilaian auditor tidak dapat diubah apabila telah divalidasi, Apakah Anda yakin ingin melakukan validasi?\")'><img src='".base_url()."asset/img/padlock.png'>Validasi</a></center>"; 
			}
			else
			{
			return "<center><blink><font color='#FF0000'>Waktu penilaian telah habis dan<br> Auditee belum melakukan validasi isian</font></blink></center>";	
			}
		  } 
		}
	}
	function validasi_telat()
	{
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$id_jadwal = $this->uri->segment(3);
			
		$datainsert = array();	
		$datainsert['validasi_auditor'] = 'Sudah';
		$datainsert['id_jadwal'] = $id_jadwal;
		$this->Auditor_model->Update_Content("jadwal",$datainsert,"id_jadwal");
		
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
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
	
//------------------------- Penilaian ------------------------------//		
	function penilaian()
	{
		$id_jadwal = $this->uri->segment(3);
		$data = array();
		
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data['sub'] = 'Penugasan';
		$data['sub_link'] = 'penugasan';
		$data['subsub'] = 'Jadwal';
		$data['subsub_link'] = 'jadwal'; 
		$id_auditor = $data["id_auditor"];
		$data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND id_auditor = $id_auditor AND validasi_auditor = 'Belum'");
		if (count($data['jadwal_auditor']->result_array())>0)
            {
			$data['jadwal'] = $this->Auditor_model->Total_Data("jadwal where id_jadwal = $id_jadwal AND validasi_auditee = 'Sudah'");
			if (count($data['jadwal']->result_array())>0)
            {
				foreach($data['jadwal']->result_array() as $i)
				{
					$id_instrumen = $i['id_instrumen'];
					$validasi_auditee = $i['validasi_auditee'];
				}	
					$id_standar=$this->input->post('id_standar');
					if(!$id_standar)
					{
						$standar = $this->Auditor_model->Min('id_standar','rubrik',"id_instrumen = $id_instrumen");	
						foreach($standar->result_array() as $s)
						{
						$id_standar = $s['min'];
						}
					}
					$data['id_standar']= $id_standar;
					$data['rubrik'] = $this->Auditor_model->Pilih_Content('rubrik',"id_standar = $id_standar AND id_instrumen = $id_instrumen"); 
					$data['standar_rubrik'] = $this->Auditor_model->Standar_Rubrik($id_instrumen); 
					$this->load->view('auditor/part_atas',$data);
					$this->load->view('auditor/part_kiri');
					$this->load->view('auditor/penilaian');
					$this->load->view('auditor/part_bawah');
					$this->load->view('auditor/part_js');
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Auditee belum melakukan validasi isian, Anda dilarang untuk mengakses halaman ini...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
				}
		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda dilarang untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
			}	
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
		}	
	}
	
	function save_penilaian()
	{
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$id_rubrik=$this->input->post('id_rubrik'); $id_rubrik=strip_tags($id_rubrik);
		$id_jadwal_auditor=$this->input->post('id_jadwal_auditor'); $id_jadwal_auditor=strip_tags($id_jadwal_auditor);
		$realisasi_auditor=$this->input->post('realisasi_auditor'); $realisasi_auditor=strip_tags($realisasi_auditor);
		$catatan_auditor=$this->input->post('catatan_auditor'); $catatan_auditor=strip_tags($catatan_auditor);
		
		$data['cek_save'] = $this->Auditor_model->Total_Data("penilaian_auditor where id_jadwal_auditor = $id_jadwal_auditor AND id_rubrik = $id_rubrik");
		if (count($data['cek_save']->result_array())>0)
            {
				$this->update_penilaian();
			}
		else{
			$datainsert = array();	
			$datainsert['realisasi_auditor'] = $realisasi_auditor;
			$datainsert['catatan_auditor'] = $catatan_auditor;
			$datainsert['id_rubrik'] = $id_rubrik;
			$datainsert['id_jadwal_auditor'] = $id_jadwal_auditor;
			$this->Auditor_model->Save_Content("penilaian_auditor",$datainsert);
			
			echo"<font color='#00FF00'>Berhasil Disimpan</font>";
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
	function update_penilaian()
	{
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$id_rubrik=$this->input->post('id_rubrik'); $id_rubrik=strip_tags($id_rubrik);
		$id_jadwal_auditor=$this->input->post('id_jadwal_auditor'); $id_jadwal_auditor=strip_tags($id_jadwal_auditor);
		$realisasi_auditor=$this->input->post('realisasi_auditor'); $realisasi_auditor=strip_tags($realisasi_auditor);
		$catatan_auditor=$this->input->post('catatan_auditor'); $catatan_auditor=strip_tags($catatan_auditor);
			
		$datainsert = array();	
		$datainsert['realisasi_auditor'] = $realisasi_auditor;
		$datainsert['catatan_auditor'] = $catatan_auditor;
		$datainsert['id_rubrik'] = $id_rubrik;
		$datainsert['id_jadwal_auditor'] = $id_jadwal_auditor;
		$this->Auditor_model->Update_Content2("penilaian_auditor",$datainsert,"id_jadwal_auditor","id_rubrik");
		echo"<font color='#00FF00'>Berhasil Disimpan</font>";
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
	
	function kunjungan()
	{
		$id_jadwal = $this->uri->segment(3);
		$data = array();
		
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!="")
		{
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data['sub'] = 'Penugasan';
		$data['sub_link'] = 'penugasan';
		$data['subsub'] = 'Jadwal';
		$data['subsub_link'] = 'jadwal'; 
		$id_auditor = $data["id_auditor"];
		$data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND id_auditor = $id_auditor AND validasi_auditor = 'Belum'");
		if (count($data['jadwal_auditor']->result_array())>0)
            {
			$data['jadwal'] = $this->Auditor_model->Total_Data("jadwal where id_jadwal = $id_jadwal AND validasi_auditee = 'Sudah'");
			if (count($data['jadwal']->result_array())>0)
            {	
				foreach($data['jadwal_auditor']->result_array() as $ja)
				{
					$id_jadwal_auditor = $ja['id_jadwal_auditor'];
				}	
				$data['id_jadwal_auditor'] = $id_jadwal_auditor;
				$data['kunjungan'] = $this->Auditor_model->Total_Data("kunjungan_auditor where id_jadwal_auditor = $id_jadwal_auditor");				
				$this->load->view('auditor/part_atas',$data);
				$this->load->view('auditor/part_kiri');
				$this->load->view('auditor/kunjungan');
				$this->load->view('auditor/part_bawah');
				$this->load->view('auditor/part_js');
			}else{
				?>
				<script type="text/javascript" language="javascript">
					alert("Auditee belum melakukan validasi isian, Anda dilarang untuk mengakses halaman ini...!!!");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
				}
		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda dilarang untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
			}	
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
		}	
	}
	
	function save_kunjungan()
	{
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$praktik_baik=$this->input->post('praktik_baik'); 
		$kelemahan=$this->input->post('kelemahan'); 
		$rekomendasi=$this->input->post('rekomendasi'); 
		$kesimpulan=$this->input->post('kesimpulan'); 
		$id_jadwal_auditor=$this->input->post('id_jadwal_auditor'); $id_jadwal_auditor=strip_tags($id_jadwal_auditor);

		$datainsert = array();	
		$datainsert['praktik_baik'] = $praktik_baik;
		$datainsert['kelemahan'] = $kelemahan;
		$datainsert['rekomendasi'] = $rekomendasi;
		$datainsert['kesimpulan'] = $kesimpulan;
		$datainsert['id_jadwal_auditor'] = $id_jadwal_auditor;
		$this->Auditor_model->Save_Content("kunjungan_auditor",$datainsert);
			?>
			<script type="text/javascript" language="javascript">
				alert("Hasil kunjungan audit telah berhasil disimpan, silahkan validasi apabila tidak ada perubahan.");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
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
	
	function update_kunjungan()
	{
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$praktik_baik=$this->input->post('praktik_baik'); 
		$kelemahan=$this->input->post('kelemahan'); ;
		$rekomendasi=$this->input->post('rekomendasi'); 
		$kesimpulan=$this->input->post('kesimpulan'); 
		$id_kunjungan=$this->input->post('id_kunjungan'); $id_kunjungan=strip_tags($id_kunjungan);

		$datainsert = array();	
		$datainsert['praktik_baik'] = $praktik_baik;
		$datainsert['kelemahan'] = $kelemahan;
		$datainsert['rekomendasi'] = $rekomendasi;
		$datainsert['kesimpulan'] = $kesimpulan;
		$datainsert['id_kunjungan'] = $id_kunjungan;
		$this->Auditor_model->Update_Content("kunjungan_auditor",$datainsert,"id_kunjungan");
		?>
			<script type="text/javascript" language="javascript">
				alert("Hasil kunjungan audit telah berhasil disimpan, silahkan validasi apabila tidak ada perubahan.");
			</script>
		<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
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
		$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
		if($session!=""){
		$id_jadwal = $this->uri->segment(3);
		$pecah=explode("|",$session);
		$data["id_auditor"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$id_auditor = $data["id_auditor"];
			
		$datainsert = array();	
		$datainsert['validasi_auditor'] = 'Sudah';
		$datainsert['id_jadwal'] = $id_jadwal;
		$datainsert['id_auditor'] = $id_auditor;
		$this->Auditor_model->Update_Content2("jadwal_auditor",$datainsert,"id_jadwal","id_auditor");
		
		$data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Belum'");
		if (count($data['jadwal_auditor']->result_array())==0)
            {
			$datainsert = array();	
			$datainsert['validasi_auditor'] = 'Sudah';
			$datainsert['id_jadwal'] = $id_jadwal;
			$this->Auditor_model->Update_Content("jadwal",$datainsert,"id_jadwal");			
			}
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/jadwal'>";
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
	$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_auditor"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$data["periode"] = $this->Auditor_model->Total_Data('periode');
	$data["fakultas"] = $this->Auditor_model->Total_Data('fakultas');
	$data["info"] = $this->Auditor_model->Pilih_Content('informasi','id_informasi = 5');
	$this->load->view('auditor/part_atas',$data);
	$this->load->view('auditor/part_kiri');
	$this->load->view('auditor/pilih_laporan');
	$this->load->view('auditor/part_bawah');
	$this->load->view('auditor/part_js');
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
	$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_prodi"]=$pecah[0];
	$data["prodi"]=$pecah[1];
	
	$id_periode = $this->input->post('id_periode');
	$data['periode'] = $this->Auditor_model->Total_Data("periode where id_periode = $id_periode");
	$data['laporan'] = $this->Auditor_model->Pilih_Laporan_Periode($id_periode); 
	$this->load->view('auditor/part_atas',$data);
	$this->load->view('auditor/part_kiri');
	$this->load->view('auditor/laporan_unsri');
	$this->load->view('auditor/part_bawah');
	$this->load->view('auditor/part_js');
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
	$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_auditor"]=$pecah[0];
	$data["nama"]=$pecah[1];
	
	$id_periode = $this->input->post('id_periode');
	$id_fakultas = $this->input->post('id_fakultas');
	if($id_periode == "ALL")
	{   if($id_fakultas == "ALL")
		{ $data['laporan'] = $this->Auditor_model->Laporan_All(); } 
		else
		{ $data['laporan'] = $this->Auditor_model->Pilih_Laporan_Fakultas($id_fakultas); }
	}
	else
	{
		if($id_fakultas == "ALL")
		{ $data['laporan'] = $this->Auditor_model->Pilih_Laporan_Periode($id_periode); } 
		else
		{ $data['laporan'] = $this->Auditor_model->Pilih_Laporan($id_periode,$id_fakultas); }
	}
	$this->load->view('auditor/part_atas',$data);
	$this->load->view('auditor/part_kiri');
	$this->load->view('auditor/daftar_laporan');
	$this->load->view('auditor/part_bawah');
	$this->load->view('auditor/part_js');
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
	
	$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_admin"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$data['sub'] = 'Pilih Laporan';
	$data['sub_link'] = 'pilih_laporan';
		$data['jadwal'] = $this->Auditor_model->Total_Data("jadwal, auditee, instrumen, periode where id_jadwal = $id_jadwal AND jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen AND periode.id_periode = jadwal.id_periode AND validasi_auditor = 'Sudah'");
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
			
			$data['strategi'] = $this->Auditor_model->Total_Data("strategi where id_visimisi = $id_visimisi");
			$data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal");
			$data['sum'] = $this->Auditor_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['standar_rubrik'] = $this->Auditor_model->Standar_Rubrik($id_instrumen); 
			$data['sum'] = $this->Auditor_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['perspektif_bsc'] = $this->Auditor_model->Perspektif_Bsc("$id_instrumen");
			$this->load->view('auditor/part_atas',$data);
			$this->load->view('auditor/part_kiri');
			$this->load->view('auditor/grafik_bsc');
			$this->load->view('auditor/part_bawah');
			$this->load->view('auditor/part_js_other');
		}else{
			?>
			<script type="text/javascript" language="javascript">
				alert("Auditor belum melakukan validasi, Laporan belum tersedia...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."auditor/pilih_laporan'>";
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
	
	$session=isset($_SESSION['auditor_session']) ? $_SESSION['auditor_session']:'';
	if($session!="")
	{
	$pecah=explode("|",$session);
	$data["id_pimpinan"]=$pecah[0];
	$data["nama"]=$pecah[1];
	$data['sub'] = 'Pilih Laporan';
	$data['sub_link'] = 'pilih_laporan';
		$data['jadwal'] = $this->Auditor_model->Total_Data("jadwal, auditee, instrumen, periode where id_jadwal = $id_jadwal AND jadwal.id_auditee = auditee.id_auditee AND instrumen.id_instrumen = jadwal.id_instrumen AND periode.id_periode = jadwal.id_periode AND validasi_auditor = 'Sudah'");
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
			
			$data['strategi'] = $this->Auditor_model->Total_Data("strategi where id_visimisi = $id_visimisi");
			$data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal");
			$data['sum'] = $this->Auditor_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen");
			$data['standar_rubrik'] = $this->Auditor_model->Standar_Rubrik($id_instrumen); 
			$data['perspektif_bsc'] = $this->Auditor_model->Perspektif_Bsc("$id_instrumen");
			//$this->load->view('pimpinan/laporan_auditee',$data);
	
			$this->load->library('pdf');
			$this->pdf->set_paper('A4', 'portrait');
			$this->pdf->load_view('auditor/laporan_auditee',$data);
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