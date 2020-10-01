<?php
  
  if (isset($_GET['id'])) {
    $kode_dosen = $_GET['id'];
  } else {
    die ("Error. No Id Selected! "); 
  }

  $base_url = 'http://sikf.ilkom.unsri.ac.id/api/';

  $url_dosen = $base_url.'dosen/'.$kode_dosen;
  $url_penelitian = $base_url.'penelitian_dosen/'.$kode_dosen;
  $url_pm = $base_url.'pm_dosen/'.$kode_dosen;
  $url_publikasi = $base_url.'publikasi_dosen/'.$kode_dosen;


  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url_dosen
  ));
  $resp1 = curl_exec($curl);
  $dosen= json_decode($resp1);

  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url_penelitian
  ));
  $resp = curl_exec($curl);
  $list_penelitian= json_decode($resp);
  
  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url_pm
  ));
  $resp = curl_exec($curl);
  $list_pm= json_decode($resp);
  
  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url_publikasi
  ));
  $resp = curl_exec($curl);
  $list_publikasi= json_decode($resp);
?>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<style type="text/css">
.subjudul {
  background-color: #DAE675
}
</style>
<title><?php echo($dosen->nama)?></title>
</head>
<body>
<table width="738" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td valign="top" width="508"><p>        <strong><?php echo($dosen->gelar_depan." ".$dosen->nama." ".$dosen->gelar_belakang)?></strong></p>
      <p><em><?php echo($dosen->jabatan_akademik)?></em></p>
      <p><em>Fakultas Ilmu Komputer </em><br>
        UPN Veteran Jakarta 
        </p>
      <p>
        Email: <a href="mailto:".<?php echo($dosen->email)?>.""><?php echo($dosen->email)?></a></p>
    </td>

    <td valign="top" width="228"><p align="right"><img src="<?php echo ("http://" . $_SERVER['SERVER_NAME'] .'/assets/uploads/img/foto/'.$dosen->foto);?>" width="147" height="200"></p></td>
  </tr>
</tbody></table>

    
	<br>
    <table cellpadding="0" cellspacing="0">
        <tbody><tr>
          <td valign="top" class="subjudul" width="739"><p><em><strong>Riwayat Pendidikan </strong></em></p></td>
        </tr>
      </tbody></table>
        <ul>
          <li>Undergraduate: <?php echo($dosen->s1)?></li>
          <li>Magister: <?php echo($dosen->s2)?></li>
          <?php
          if ($dosen->s3 != "") {
          ?>
          <li>Doctoral: <?php echo($dosen->s3)?></li>
          <?php
          }
          ?>
        </ul>        
        <table cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td valign="top" class="subjudul" width="739"><p><strong>Bidang Keahlian </strong></p></td>
          </tr>
        </tbody></table>      
        <p align="justify"><?php echo($dosen->bidang_keahlian)?></p>
        
        <table cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td valign="top" class="subjudul" width="739"><p><strong>Riwayat Penelitian</strong></p></td>
          </tr>
        </tbody></table>
        
        <p></p>
        <table width="739" height="80" border="0">
          <tbody><tr>
            <td><ul>
              <?php
              foreach ($list_penelitian as $penelitian) {
              ?>
              <li>
                <div align="justify">
                  <p><?php echo($penelitian->peneliti.". <i>".$penelitian->judul."</i>. Tahun ".$penelitian->tahun);?></p>
                </div>
              </li>
              <?php } ?>
              </ul></td>
          </tr>
        </tbody></table>

        <table cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td valign="top" class="subjudul" width="739"><p><strong>Riwayat Pengabdian Masyarakat</strong></p></td>
          </tr>
        </tbody></table>
        
        <p></p>
        <table width="739" height="80" border="0">
          <tbody><tr>
            <td><ul>
              <?php
              foreach ($list_pm as $pm) {
                
              ?>
              <li>
                <div align="justify">
                  <p><?php echo($pm->pengabdi.". <i>".$pm->judul."</i>. Tahun ".$pm->tahun);?></p>
                </div>
              </li>
              <?php } ?>
              </ul></td>
          </tr>
        </tbody></table>

        <table cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td valign="top" class="subjudul" width="739"><p><strong>Riwayat Publikasi</strong></p></td>
          </tr>
        </tbody></table>
        
        <p></p>
        <table width="739" height="80" border="0">
          <tbody><tr>
            <td><ul>
              <?php
              foreach ($list_publikasi as $publikasi) {
                
              ?>
              <li>
                <div align="justify">
                  <p><?php echo($publikasi->penulis.". <i>".$publikasi->judul."</i>. ".$publikasi->tempat.". Tahun ".$publikasi->tahun);?></p>
                </div>
              </li>
              <?php } ?>
              </ul></td>
          </tr>
        </tbody></table>
        
</body></html>