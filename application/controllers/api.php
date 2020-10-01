<?php
class api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Dosen_model');
		$this->load->model('Penelitian_model');
		$this->load->model('Pm_model');
		$this->load->model('Publikasi_model');
	}
	
	function dosen($kode_dosen = 0)
	{
		$dosen = $this->Dosen_model->dosenApiWithKode($kode_dosen);
		echo json_encode($dosen);
	}

	function penelitian_dosen($kode_dosen = 0){
		$penelitian = $this->Penelitian_model->penelitianApiByDosen($kode_dosen);
		echo json_encode($penelitian);
	}

	function pm_dosen($kode_dosen = 0){
		$pm = $this->Pm_model->pmApiByDosen($kode_dosen);
		echo json_encode($pm);
		// print_r($pm);
	}

	function publikasi_dosen($kode_dosen = 0){
		$publikasi = $this->Publikasi_model->publikasiApiByDosen($kode_dosen);
		echo json_encode($publikasi);
	}
}