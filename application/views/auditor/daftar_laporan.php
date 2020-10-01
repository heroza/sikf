<section id="content">
					<section id="pane">
						<header>
							<h1> Daftar Laporan</h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."auditor/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditor/pilih_laporan" ?>">Pilih Laporan</a></li>
								</ul>
							</nav>
						</header>
                    
                    <div id="pane-content">
						
						<div class="g4">
                    	<table class="datatable">
                        <thead>
                            <tr>
                                <th>Prodi</th>
                                <th>instrumen</th>
                                <th>Status Validasi Isian Auditee</th>
                                <th>Status Validasi Penilaian Auditor</th>
                                <th>Total Nilai</th>
                                <th>Action</th>
                            </tr>
						</thead>
                        <tbody>
						<?php
                        foreach($laporan -> result_array() as $l) 
                        { ?>
                    	  	<tr>
                                <td><?php echo $l['prodi']; ?></td>
                                <td><?php echo $l['instrumen']; ?></td>
                                <td><?php echo $l['validasi_auditee']; ?></td>
                                <td><?php echo $l['validasi_auditor']; ?></td>
                                <td>
	<?php 
	$id_jadwal = $l['id_jadwal'];
	$total = 0; $totalpersen2 = 0;
	$data['jadwal'] = $this->Auditor_model->Total_Data("jadwal where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	if (count($data['jadwal']->result_array())>0)
	{
	  foreach($data['jadwal']->result_array() as $i)
	  {
	  $id_instrumen = $i['id_instrumen'];
	  $data['standar_rubrik'] = $this->Auditor_model->Standar_Rubrik($id_instrumen);
		foreach($data['standar_rubrik']->result_array() as $sr)
		{
		$id_standar = $sr['id_standar']; 
		$sum_standar = 0;
		$data['rubrik'] = $this->Auditor_model->Pilih_Content('rubrik',"id_instrumen = $id_instrumen AND id_standar = $id_standar"); 
		  foreach($data['rubrik']->result_array() as $r)
		  {   
		  $id_rubrik = $r['id_rubrik'];
		  $count_auditor = 0;
		  $sum_rubrik = 0;
		  $data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
			foreach($data['jadwal_auditor']->result_array() as $ja)
			{   
			$count_auditor++;
			$id_jadwal_auditor = $ja['id_jadwal_auditor'];
			$data['nilai'] = $this->Auditor_model->Total_Data("penilaian_auditor where id_rubrik=$id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
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
	  $data['sum'] = $this->Auditor_model->Sum_Pilih("rubrik","bobot","id_instrumen = $id_instrumen"); 
	  foreach($data['sum'] -> result_array() as $s) 
	  { $totalbobot = $s['sum']; }
	  $totalpersen2 = round($total/$totalbobot*100,2);
	  echo $totalpersen2;
	  }
	}?>						 </td>
                                <td align="center">
                                <?php if($l['validasi_auditor'] == 'Sudah') 
									{ ?>	
                                    <a href="<?php echo base_url()."auditor/hasil/".$l['id_jadwal']; ?>" target="_blank" title='Lihat Grafik Hasil Penilaian Audit'><img src="<?php echo base_url()."asset/img/bar.png" ?>">Lihat Grafik</a> 
									<a href="<?php echo base_url()."auditor/print_laporan_auditee/".$l['id_jadwal']; ?>" target="_blank" title='Cetak Laporan Audit'><img src="<?php echo base_url()."asset/img/printer.png" ?>">Cetak Laporan
                                <?php } 
									else{
									echo "Belum ada data";
									}?>
                                </td>
                        	</tr>
	                    <?php } ?>
                    	</tbody>
						</table>
                		</div>
                   			<div class="cf"></div>
						</div>
					</section>
</section>