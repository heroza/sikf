<?php
class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		@session_start();
		$this->load->database();
		$this->load->helper(array('form','url'));
		$this->load->model('Login_model');
	}
	
	function index()
	{
		$this->load->view('index');
	}
	
	function proses_login()
	{
		// $table = $this->input->post('sebagai');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$pwd = md5($password);
		$pass = md5($pwd);					
		$hasil = $this->Login_model->dologin($username,$pass);
		if ($hasil->num_rows() > 0)
		{
			$row = $hasil->row(); 
			$data_session=$row->username;

			if($row->role == "pimpinan")
			{
				$_SESSION['pimpinan_session']=$data_session;
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."pimpinan'>";
			}
			else if($row->role == "admin")
			{
				foreach($hasil->result() as $items){
					$data_session=$items->id_admin."|".$items->nama;
				}
				$_SESSION['admin_session']=$data_session;
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin'>";
			}
			else if($row->role == "prodi")
			{
				$_SESSION['prodi_session']=$data_session;
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."prodi'>";
			}
			else if($row->role == "dosen")
			{
				$_SESSION['dosen_session']=$data_session;
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."dosen'>";
			}
			else if($row->role == "unit")
			{
				$_SESSION['unit_session']=$data_session;
				if ($row->username == "uppm") {
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."unit/uppm'>";
				} else if ($row->username == "kepegawaian") {
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."unit/kepegawaian'>";
				} else if ($row->username == "kemahasiswaan") {
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."unit/kemahasiswaan'>";
					//echo "Forwarding to..".base_url()."unit/kemahasiswaan'>";
				} else if ($row->username == "standar2") {
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."unit/standar2'>";
					//echo "Forwarding to..".base_url()."unit/standar2'>";
				} else if ($row->username == "perlengkapan") {
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."unit/perlengkapan'>";
					//echo "Forwarding to..".base_url()."unit/perlengkapan'>";
				} else if ($row->username == "upm") {
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."unit/upm'>";
					//echo "Forwarding to..".base_url()."unit/upm'>";
				} else {
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."uppm'>";
				}
				
			}
		}
		else{
			?>
			<script type="text/javascript">
			alert("Username atau Password Yang Anda Masukkan Salah..!!!");			
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
		}
	}
}