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
							<h1> ISIAN AUDITEE</h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."auditee/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditee/".$sub_link ?>"><?php echo $sub ?></a></li>
									<li><a href="<?php echo base_url()."auditee/".$subsub_link ?>"><?php echo $subsub ?></a></li>
								</ul>
							</nav>
						</header>
       		<div id="pane-content">
					
					<div class="field g2">
                        <form method="post" action="<?php echo base_url()."auditee/isian/".$id_jadwal ?>">
            				<label><strong>Pilih Standar :</strong></label>
                            <div class="entry"><select name="id_standar" onchange="this.form.submit();">
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
                        
                        <label>* <strong>Kolom berwarna <font color="#FFFF00">kuning</font> diisi oleh Auditee/Prodi</strong></label>
                        <br /><label>* <strong>Geser tabel kesebelah kanan untuk melihat isi tabel lebih lengkap</strong></label>
                    <div style="width:auto; border:1px solid #CCCCCC; overflow:auto;">
                    <table class='table dataTable table-bordered' style="width:1445px">
                    <thead>
                    <tr>
                    	<th width="3%" bgcolor="#999999"><center><strong>No</strong></center></th>
                        <th width="24%" bgcolor="#999999"><center><strong>Rubrik</strong></center></th>
						<th width="17%" bgcolor="#FFFF00"><center><strong>Kondisi Prodi</strong></center></th>
                        <th width="17%" bgcolor="#FFFF00"><center><strong>Hambatan</strong></center></th>
                        <th width="17%" bgcolor="#FFFF00"><center><strong>Inisiatif Perbaikan</strong></center></th>
                        <th width="10%" bgcolor="#FFFF00"><center><strong>Dokumen</strong></center></th>
                        <th width="7%" bgcolor="#FFFF00"><center><strong>Skor Prodi</strong></center></th>
                        <th width="5%" bgcolor="#FFFF00"><center><strong>Action</strong></center></th>
					</tr>
                    </thead>
                    <tbody>
                
		<?php 
		$no = 1;
		foreach($rubrik->result_array() as $r)
		{ ?>
        	<td><center><?php echo $r['sumber_referensi'] ?></center></td>
                <td align="justify"><?php echo $r['rubrik'] ?><hr />Indikator Penilaian :
					<font size="-2"><?php echo $r['kpi'] ?></font></td>
        <?php
		$id_rubrik = $r['id_rubrik'];
		$data['jawab'] = $this->Auditee_model->Total_Data("isian_auditee where id_rubrik = $id_rubrik AND id_jadwal = $id_jadwal");
		if (count($data['jawab']->result_array())>0)
		{	foreach($data['jawab']->result_array() as $j)
			{ ?>
                	<form id="<?php echo "ajax_form".$id_rubrik ?>" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>auditee/update_isian">
            			<td><div class="entry"><textarea name="kondisi"><?php echo $j['kondisi'] ?></textarea></div></td>
                    	<td><div class="entry"><textarea name="hambatan"><?php echo $j['hambatan'] ?></textarea></div></td>
                        <td><div class="entry"><textarea name="inisiatif"><?php echo $j['inisiatif'] ?></textarea></div></td>
                        <td><input name="dokumen" type="file">
                        	<?php 
							if($j['dokumen'] !== "")
							{ ?>
                        	<br /><br /><center><a href="<?php echo base_url().$j['dokumen'] ?>">Download dokumen</a></center></td>
                        	<?php }else
							{ echo "<br /><br /><center>Tidak Ada Dokumen</center>"; } ?>
                        <td>
                        	<div class="entry">
                            <select name="realisasi auditee">
							<?php
                            if($j['realisasi_auditee']==0)
							{ ?>		<option selected="selected" value="0" >0</option>
                            			<option value="1" >1</option>
                                        <option value="2" >2</option>
                                        <option value="3" >3</option>
                                        <option value="4" >4</option>
                            <?php 
							}else if($j['realisasi_auditee']==1)
							{ ?>		<option value="0" >0</option>
                            			<option selected="selected" value="1" >1</option>
                                        <option value="2" >2</option>
                                        <option value="3" >3</option>
                                        <option value="4" >4</option>
                            <?php 
							}else if($j['realisasi_auditee']==2)
							{ ?>		<option value="0" >0</option>
                            			<option value="1" >1</option>
                                        <option selected="selected" value="2" >2</option>
                                        <option value="3" >3</option>
                                        <option value="4" >4</option>
                            <?php 
							}else if($j['realisasi_auditee']==3)
							{ ?>		<option value="0" >0</option>
                            			<option value="1" >1</option>
                                        <option value="2" >2</option>
                                        <option selected="selected" value="3" >3</option>
                                        <option value="4" >4</option>
                            <?php 
							}else if($j['realisasi_auditee']==4)
							{ ?>		<option value="0" >0</option>
                            			<option value="1" >1</option>
                                        <option value="2" >2</option>
                                        <option value="3" >3</option>
                                        <option selected="selected" value="4" >4</option>
                            <?php } ?>
                            </select></div>
                        </td>
                        <td align="center" valign="top"><input type="submit" name="action" class="bt orange small" value="Save"><br />
                        	<iframe frameborder="0" id="<?php echo "ajax_target".$id_rubrik ?>" name="<?php echo "ajax_target".$id_rubrik ?>" src="" height="80px" width="80px"></iframe>
                		</td>
                		<input type="hidden" name="id_rubrik" value="<?php echo $id_rubrik ?>" />
                		<input type="hidden" name="id_jadwal" value="<?php echo $id_jadwal ?>" />
					</form>
                	</tr>
       <?php		 
	   		}
		}
		else
		{
			?>
                	<form id="<?php echo "ajax_form".$id_rubrik ?>" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>auditee/save_isian">
            			<td><div class="entry"><textarea name="kondisi"></textarea></div></td>
                    	<td><div class="entry"><textarea name="hambatan"></textarea></div></td>
                        <td><div class="entry"><textarea name="inisiatif"></textarea></div></td>
                        <td><div class="entry"><input name="dokumen" type="file"></div></td>
                        <td><div class="entry">
                        	<select name="realisasi_auditee">
								<option value="0" >0</option>
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                            </select></div>
                        </td>
                        <td align="center" valign="top"><input type="submit" name="action" class="bt orange small" value="Save"><br />
                        	<iframe frameborder="0" id="<?php echo "ajax_target".$id_rubrik ?>" name="<?php echo "ajax_target".$id_rubrik ?>" src="" height="80px" width="80px"></iframe>
                		</td>
                		<input type="hidden" name="id_rubrik" value="<?php echo $id_rubrik ?>" />
                		<input type="hidden" name="id_jadwal" value="<?php echo $id_jadwal ?>" />
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