<script type="text/javascript">
	function init(){ 
	<?php 
		$id_jadwal = $this->uri->segment(3);
		foreach($rubrik->result_array() as $ajax)
		{  ?>
			document.getElementById('<?php echo "ajax_form".$ajax['id_rubrik'] ?>').onsubmit=function() {
			document.getElementById('<?php echo "ajax_form".$ajax['id_rubrik'] ?>').target = '<?php echo "ajax_target".$ajax['id_rubrik'] ?>' ; //'upload_target' is the name of the iframe
			}
	<?php } ?>
	}
	window.onload=init;
</script>
<section id="content">
					<section id="pane">
						<header>
							<h1> <?php echo $subsub ?></h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."auditor/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditor/".$sub_link ?>"><?php echo $sub ?></a></li>
									<li><a href="<?php echo base_url()."auditor/".$subsub_link ?>"><?php echo $subsub ?></a></li>
								</ul>
							</nav>
						</header>
       		<div id="pane-content">
					
					<div class="field g2">
						<form method="post" action="<?php echo base_url()."auditor/penilaian/".$id_jadwal ?>">
            				<label><strong>Pilih Standar :</strong></label>
                            <div class="entry"><select name="id_standar" data-rel="chosen" onchange="this.form.submit();">
							<?php 
							foreach($standar_rubrik->result_array() as $stan)
							{ 	
                            	if($stan['id_standar'] == $id_standar)
								{ ?>
                                	<option selected="selected" value="<?php echo $stan['id_standar']; ?>" ><?php echo $stan['standar']; ?></option>
                          <?php }else
								{ ?>
									<option value="<?php echo $stan['id_standar']; ?>" ><?php echo $stan['standar']; ?></option>
						  <?php }
							}?>
                            </select></div>
                        </form>
                    </div>
                    <div class="g4">
                    <div class="table-wrapper">
                        <label>* <strong>Kolom berwarna <font color="#FFFF00">Kuning</font> diisi oleh auditee/Prodi</strong></label>
                        <br /><label>* <strong>Kolom berwarna <font color="#00FF00">Hijau</font> diisi oleh Auditor</strong></label>
                        <br /><label>* <strong>Geser tabel kesebelah kanan untuk melihat isi tabel lebih lengkap</strong></label>
                    <div style="width:auto; border:1px solid #CCCCCC; overflow:auto;">
                    <table class='table dataTable table-bordered' style="width:1800px">
                    <thead>
                    <tr>
                    	<th width="2%" bgcolor="#999999"><center><strong>No</strong></center></th>
                        <th width="15%" bgcolor="#999999"><center><strong>Rubrik</strong></center></th>
						<th width="15%" bgcolor="#FFFF00"><center><strong>Kondisi Prodi</strong></center></th>
                        <th width="15%" bgcolor="#FFFF00"><center><strong>Hambatan</strong></center></th>
                        <th width="15%" bgcolor="#FFFF00"><center><strong>Inisiatif Perbaikan</strong></center></th>
                        <th width="7%" bgcolor="#FFFF00"><center><strong>Dokumen</strong></center></th>
                        <th width="5%" bgcolor="#FFFF00"><center><strong>Skor Prodi</strong></center></th>
                        <th width="5%" bgcolor="#00FF00"><center><strong>Penilaian Auditor</strong></center></th>
                        <th width="17%" bgcolor="#00FF00"><center><strong>Catatan Auditor</strong></center></th>
                        <th width="4%" bgcolor="#00FF00"><center><strong>Action</strong></center></th>
					</tr>
                    </thead>
                    <tbody>
                
		<?php 
		$no = 1;
		$data['jadwal_auditor'] = $this->Auditor_model->Total_Data("jadwal_auditor where id_auditor = $id_auditor AND id_jadwal = $id_jadwal");
		foreach($data['jadwal_auditor']->result_array() as $ta)
		{
			$id_jadwal_auditor = $ta['id_jadwal_auditor'];
		}

		foreach($rubrik->result_array() as $r)
		{ ?>
            <tr>
                <td><center><?php echo $r['sumber_referensi'] ?></center></td>
                <td align="justify"><?php echo $r['rubrik'] ?><hr />Indikator Penilaian :
					<font size="-2"><?php echo $r['kpi'] ?></font></td>
			<?php
            $id_rubrik = $r['id_rubrik'];
            $data['jawab'] = $this->Auditor_model->Total_Data("isian_auditee where id_rubrik = $id_rubrik AND id_jadwal = $id_jadwal");
            if (count($data['jawab']->result_array())>0)
            {	foreach($data['jawab']->result_array() as $j)
                { ?>
                    <td><div class="entry"><textarea readonly="readonly" name="kondisi"><?php echo $j['kondisi'] ?></textarea></div></td>
                    <td><div class="entry"><textarea readonly="readonly" name="hambatan"><?php echo $j['hambatan'] ?></textarea></div></td>
                    <td><div class="entry"><textarea readonly="readonly" name="inisiatif"><?php echo $j['inisiatif'] ?></textarea></div></td>
                    <td><center>
                    <?php 
							if($j['dokumen'] !== "")
							{ ?>
                        	<br /><center><a href="<?php echo base_url().$j['dokumen'] ?>">Download dokumen</a></center></td>
                        	<?php }else
							{ echo "<br /><center>Tidak Ada Dokumen</center>"; } ?>
                    </center></td>            
                    <td><center><div class="entry">
                        <select name="realisasi auditee" >
                                <option disabled="disabled" selected="selected"><?php echo $j['realisasi_auditee'] ?></option>
                        </select></div></center>
                    </td>        
                  <?php		 
                }
            }
            else
            { ?>
                    <td>Belum diisi</td>
                    <td>Belum diisi</td>
                    <td>Belum diisi</td>
                    <td>Belum diisi</td>
                    <td>Belum diisi</td>
            <?php		
            }
			
            $data['penilaian'] = $this->Auditor_model->Total_Data("penilaian_auditor where id_rubrik = $id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
            if (count($data['penilaian']->result_array())>0)
            {	foreach($data['penilaian']->result_array() as $p)
                { ?>
            		<td>
                    <form id="<?php echo "ajax_form".$id_rubrik ?>" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>auditor/update_penilaian">
                        <center><div class="entry"><select name="realisasi auditor">
                        <?php
                        if($p['realisasi_auditor']==0)
                        { ?>		<option selected="selected" value="0" >0</option>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                        <?php 
                        }else if($p['realisasi_auditor']==1)
                        { ?>		<option value="0" >0</option>
                                    <option selected="selected" value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                        <?php 
                        }else if($p['realisasi_auditor']==2)
                        { ?>		<option value="0" >0</option>
                                    <option value="1" >1</option>
                                    <option selected="selected" value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                        <?php 
                        }else if($p['realisasi_auditor']==3)
                        { ?>		<option value="0" >0</option>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option selected="selected" value="3" >3</option>
                                    <option value="4" >4</option>
                        <?php 
                        }else if($p['realisasi_auditor']==4)
                        { ?>		<option value="0" >0</option>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option selected="selected" value="4" >4</option>
                        <?php } ?>
                        </select></div></center>
                    </td>
                    <td><div class="entry"><textarea name="catatan_auditor" ><?php echo $p['catatan_auditor'] ?></textarea></div></td>
                    <td align="center"><input type="submit" name="action" class="bt green small" value="Save"><br />
                        <iframe frameborder="0" id="<?php echo "ajax_target".$id_rubrik ?>" name="<?php echo "ajax_target".$id_rubrik ?>" src="" height="30px" width="70px"></iframe>
                    </td>
                    <input type="hidden" name="id_rubrik" value="<?php echo $id_rubrik ?>" />
                    <input type="hidden" name="id_jadwal_auditor" value="<?php echo $id_jadwal_auditor ?>" />
                </form>
                </tr>
            <?php }
            }else
            { ?>
                 <form id="<?php echo "ajax_form".$id_rubrik ?>" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>auditor/save_penilaian">
                    <td><center>
                        <div class="entry"><select name="realisasi auditor" data-rel="chosen">
                            <option value="0" >0</option>
                            <option value="1" >1</option>
                            <option value="2" >2</option>
                            <option value="3" >3</option>
                            <option value="4" >4</option>
                        </select></div></center>
                    </td>
                    <td><div class="entry"><textarea name="catatan_auditor"></textarea></div></td>
                    <td><input type="submit" name="action" class="bt green small" value="Save"><br />
                        <iframe frameborder="0" id="<?php echo "ajax_target".$id_rubrik ?>" name="<?php echo "ajax_target".$id_rubrik ?>" src="" height="30px" width="70px"></iframe>
                    </td>
                    <input type="hidden" name="id_rubrik" value="<?php echo $id_rubrik ?>" />
                    <input type="hidden" name="id_jadwal_auditor" value="<?php echo $id_jadwal_auditor ?>" />
                </form>
                </tr>	
            <?php 
            }
		$no++;
			 ?>
		<?php } ?>
        		    <tbody>
                    </table>
				</div>
                    	</div>
                    	</div>
                   			<div class="cf"></div>
					</div>
					</section>
</section>