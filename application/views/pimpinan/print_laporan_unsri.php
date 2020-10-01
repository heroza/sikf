 	<table width="100%">
    	<tr>
        	<td width="10%" align="center" valign="middle"><img src="<?php echo base_url(); ?>asset/images/unsri.png" width="100px"/></td>
            <td width="90%" align="center">
            	<strong>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</strong><BR>
                <strong><font size="+1">UNIVERSITAS SRIWIJAYA<BR>
                UPT PENJAMINAN MUTU</font></strong><BR>
                <font size="-1">Jalan Palembang - Prabumulih Km.32 Indralaya Ogan Ilir Kode Pos 30662<br>
				Telepon (0711)581010, Faksimile (0711) 581010, Email : upm@unsri.ac.id</font>                 	
            </td>
        </tr>
    </table><hr>
    <h2 align="center">LAPORAN HASIL AMAI</h2>
 	<?php
    foreach($periode -> result_array() as $p) 
    { ?>
	<table width="100%">
        <tr><td width="170">Universitas </td><td width="10"> : </td><td>Sriwijaya</td></tr>
        <tr><td>Periode AMAI </td><td> : </td><td><?php echo $p['periode']." - Tahun ".$p['tahun']; ?></td></tr>
        <tr><td>Tanggal Mulai </td><td> : </td><td><?php echo date('d F Y', strtotime($p['mulai'])); ?></td></tr>
        <tr><td>Tanggal Akhir Pengisian Auditee </td><td> : </td><td><?php echo date('d F Y', strtotime($p['akhir_auditee'])); ?></td></tr>
        <tr><td>Tanggal Akhir Penilaian Auditor </td><td> : </td><td><?php echo date('d F Y', strtotime($p['akhir_auditor'])); ?></td></tr>
    </table><br />
    <?php } ?>
    <table border="1" width="100%" bordercolor="#000000">
    <tr>
        <td align="center" bgcolor="#999999"><strong>Program Studi</strong></td>
        <td align="center" bgcolor="#999999"><strong>Instrumen</strong></td>
        <td align="center" bgcolor="#999999"><strong>Status Validasi Isian Auditee</strong></td>
        <td align="center" bgcolor="#999999"><strong>Status Validasi Penilaian Auditor</strong></td>
        <td align="center" bgcolor="#999999"><strong>Total Nilai [Huruf]</strong></td>
    </tr>
    <?php
	$totalunsri = 0; $selesai_audit = 0;
    foreach($laporan -> result_array() as $l) 
    { ?>
        <tr>
            <td bgcolor="#FFFFFF"><?php echo $l['prodi']; ?></td>
            <td bgcolor="#FFFFFF"><?php echo $l['instrumen']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $l['validasi_auditee']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $l['validasi_auditor']; ?></td>
            <td align="center" bgcolor="#FFFFFF">
	<?php 
	$id_jadwal = $l['id_jadwal'];
	$total = 0; $totalpersen2 = 0;
	$data['jadwal'] = $this->Pimpinan_model->Total_Data("jadwal where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	if (count($data['jadwal']->result_array())>0)
	{
	  foreach($data['jadwal']->result_array() as $i)
	  {
	  $id_instrumen = $i['id_instrumen'];
	  $data['standar_rubrik'] = $this->Pimpinan_model->Standar_Rubrik($id_instrumen);
		foreach($data['standar_rubrik']->result_array() as $sr)
		{
		$id_standar = $sr['id_standar']; 
		$sum_standar = 0;
		$data['rubrik'] = $this->Pimpinan_model->Pilih_Content('rubrik',"id_instrumen = $id_instrumen AND id_standar = $id_standar"); 
		  foreach($data['rubrik']->result_array() as $r)
		  {   
		  $id_rubrik = $r['id_rubrik'];
		  $count_auditor = 0;
		  $sum_rubrik = 0;
		  $data['jadwal_auditor'] = $this->Pimpinan_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
			foreach($data['jadwal_auditor']->result_array() as $ja)
			{   
			$count_auditor++;
			$id_jadwal_auditor = $ja['id_jadwal_auditor'];
			$data['nilai'] = $this->Pimpinan_model->Total_Data("penilaian_auditor where id_rubrik=$id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
				if (count($data['nilai']->result_array())>0)
				{	foreach($data['nilai']->result_array() as $n)
					{ 
						$sum_rubrik = $n['realisasi_auditor']+ $sum_rubrik;
					}
				}else
				{
					$sum_rubrik = 0 + $sum_rubrik;
				}
			}
		  $sum_rubrik = round($sum_rubrik/$count_auditor);
		  $sum_rubrik = round($sum_rubrik/$r['target']*$r['bobot'],2);
		  $sum_standar = $sum_rubrik + $sum_standar;
		  }
		$total = $total + $sum_standar;
		}
	  $data['sum'] = $this->Pimpinan_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen"); 
	  foreach($data['sum'] -> result_array() as $s) 
	  { $totalbobot = $s['sum']; }
	  $totalpersen2 = round($total/$totalbobot*100,2);
	  if($l['validasi_auditor'] == 'Sudah') 
	  { echo $totalpersen2; 
	  	if ($totalpersen2 > 85)
		{ echo " [ A ]"; }
		elseif ($totalpersen2 > 75 && $totalpersen2 <= 85)
		{ echo " [ B ]"; }
		elseif ($totalpersen2 > 60 && $totalpersen2 <= 75)
		{ echo " [ C ]"; }
		elseif ($totalpersen2 > 40 && $totalpersen2 <= 60)
		{ echo " [ D ]"; }
		elseif ($totalpersen2 >= 0 && $totalpersen2 <= 40)
		{ echo " [ E ]"; }
	  }
	  $selesai_audit++;
	  $totalunsri = $totalunsri + $totalpersen2;
	  }
	} ?>                         
    		</td>
       	</tr>
            <?php } ?>
        <tr><td colspan="4" align="center" bgcolor="#FFFF00"><strong>Total Nilai AMAI Univesitas Sriwijaya</strong></td>
            <td align="center" bgcolor="#FFFF00"><strong>
				<?php 
				if($totalunsri != "")
				{
					echo $totalunsri = round($totalunsri/$selesai_audit,2); 
					if ($totalunsri > 85)
					{ echo " [ A ]"; }
					elseif ($totalunsri > 75 && $totalunsri <= 85)
					{ echo " [ B ]"; }
					elseif ($totalunsri > 60 && $totalunsri <= 75)
					{ echo " [ C ]"; }
					elseif ($totalunsri > 40 && $totalunsri <= 60)
					{ echo " [ D ]"; }
					elseif ($totalunsri >= 0 && $totalunsri <= 40)
					{ echo " [ E ]"; }
				}
				?></strong>
            </td>
        </tr>               	
    </table>
