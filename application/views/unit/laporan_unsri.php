<section id="content">
					<section id="pane">
						<header>
							<h1>Laporan AMAI Universitas Sriwijaya</h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."admin/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."admin/pilih_laporan" ?>">Pilih Laporan</a></li>
								</ul>
							</nav>
						</header>
                    
                    <div id="pane-content">
						
					  <div class="g4">
    <?php
    foreach($periode -> result_array() as $p) 
    { ?>
	<table>
        <tr><td width="200">Universitas </td><td width="10px"> : </td><td>Sriwijaya</td></tr>
        <tr><td>Periode AMAI </td><td> : </td><td><?php echo $p['periode']." - Tahun ".$p['tahun']; ?></td></tr>
        <tr><td>Tanggal Mulai </td><td> : </td><td><?php echo date('d F Y', strtotime($p['mulai'])); ?></td></tr>
        <tr><td>Tanggal Akhir Pengisian Auditee </td><td> : </td><td><?php echo date('d F Y', strtotime($p['akhir_auditee'])); ?></td></tr>
        <tr><td>Tanggal Akhir Penilaian Auditor </td><td> : </td><td><?php echo date('d F Y', strtotime($p['akhir_auditor'])); ?></td></tr>
    </table><br />
    <?php } ?>
    <div class="table-wrapper">
    <table class='table table-striped dataTable'>
    <tr>
        <td align="center" bgcolor="#999999"><strong><font color="#000000">Program Studi</font></strong></td>
        <td align="center" bgcolor="#999999"><strong><font color="#000000">Instrumen</font></strong></td>
        <td align="center" bgcolor="#999999"><strong><font color="#000000">Status Validasi Isian Auditee</font></strong></td>
        <td align="center" bgcolor="#999999"><strong><font color="#000000">Status Validasi Penilaian Auditor</font></strong></td>
        <td align="center" bgcolor="#999999"><strong><font color="#000000">Total Nilai [Huruf]</font></strong></td>
    </tr>
    <?php
	$totalunsri = 0; $selesai_audit = 0;
    foreach($laporan -> result_array() as $l) 
    { ?>
        <tr>
            <td><?php echo $l['prodi']; ?></td>
            <td><?php echo $l['instrumen']; ?></td>
            <td align="center"><?php echo $l['validasi_auditee']; ?></td>
            <td align="center"><?php echo $l['validasi_auditor']; ?></td>
            <td align="center">
	<?php 
	$id_jadwal = $l['id_jadwal'];
	$total = 0; $totalpersen2 = 0;
	$data['jadwal'] = $this->Admin_model->Total_Data("jadwal where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	if (count($data['jadwal']->result_array())>0)
	{
	  foreach($data['jadwal']->result_array() as $i)
	  {
	  $id_instrumen = $i['id_instrumen'];
	  $data['standar_rubrik'] = $this->Admin_model->Standar_Rubrik($id_instrumen);
		foreach($data['standar_rubrik']->result_array() as $sr)
		{
		$id_standar = $sr['id_standar']; 
		$sum_standar = 0;
		$data['rubrik'] = $this->Admin_model->Pilih_Content('rubrik',"id_instrumen = $id_instrumen AND id_standar = $id_standar"); 
		  foreach($data['rubrik']->result_array() as $r)
		  {   
		  $id_rubrik = $r['id_rubrik'];
		  $count_auditor = 0;
		  $sum_rubrik = 0;
		  $data['jadwal_auditor'] = $this->Admin_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
			foreach($data['jadwal_auditor']->result_array() as $ja)
			{   
			$count_auditor++;
			$id_jadwal_auditor = $ja['id_jadwal_auditor'];
			$data['nilai'] = $this->Admin_model->Total_Data("penilaian_auditor where id_rubrik=$id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
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
	  $data['sum'] = $this->Admin_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen"); 
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
                		</div>
                      </div>    
                   			<div class="aligncenter space-bottom-20">
								<form method="post" action="<?php echo base_url()."admin/print_laporan_unsri" ?>">
                                <input type="hidden" name="id_periode" value="<?php echo $id_periode ?>" />
                                <input type="submit" class="bt small" value="Cetak Laporan" />
                            	</form><br />	
                            </div>   
                   			<div class="cf"></div>
					</div>
					</section>
</section>