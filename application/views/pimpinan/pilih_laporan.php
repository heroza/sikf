<section id="content">
					<section id="pane">
						<header>
							<h1> Laporan</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."pimpinan/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."pimpinan/pilih_laporan" ?>">Pilih Laporan</a></li>													
                                </ul>
							</nav>
						</header>
                 
						<div id="pane-content">
                        
						<div class="field g2">
                        <h1>Laporan Fakultas</h1>
                        <form method="post" action="<?php echo base_url()."pimpinan/laporan_unsri" ?>">
            				<label><strong>Pilih Periode Pelaksanaan :</strong></label>
                            <div class="entry"><select name="id_periode">
							<?php 
							foreach($periode->result_array() as $p)
							{ 	?>
                                	<option value="<?php echo $p['id_periode']; ?>" ><?php echo $p['periode']." - Tahun ".$p['tahun']; ?></option>
                            <?php }?>
                            </select></div>
                            <br />
                            <input type="submit" class="bt small" value="Pilih" />
                        </form><br />
                    	</div>
                        
						<div class="field g2">
                        <h1>Laporan Prodi</h1>
                        <form method="post" action="<?php echo base_url()."pimpinan/daftar_laporan" ?>">
            				<label><strong>Pilih Periode Pelaksanaan :</strong></label>
                            <div class="entry"><select name="id_periode">
                            		<option selected="selected" value="ALL">Seluruh Periode</option>
							<?php 
							foreach($periode->result_array() as $p)
							{ 	?>
                                	<option value="<?php echo $p['id_periode']; ?>" ><?php echo $p['periode']." - Tahun ".$p['tahun']; ?></option>
                            <?php }?>
                            </select></div>
                            <label><strong>Pilih Prodi :</strong></label>
                            <div class="entry"><select name="prodi">
                            		<option selected="selected" value="ALL">Seluruh Prodi</option>
							<?php 
							foreach($prodi->result_array() as $f)
							{ 	?>
                                	<option value="<?php echo $f['prodi']; ?>" ><?php echo $f['prodi']; ?></option>
                            <?php }?>
                            </select></div><br />
                            <input type="submit" class="bt small" value="Pilih" />
                        </form><br />
                    </div>
			<?php
			foreach($info->result_array() as $i)
			{
				$judul = $i['judul'];
				$isi = $i['isi'];
				$tipe = $i['tipe'];
			}
			?>
			<div class="widget minimizable g4">
						<header>
                            <h2><?php echo $judul ?></h2>
                        </header>
                        <div class="widget-section">
                            <div class="content">
								<?php echo $isi ?>	
							</div>
						</div>
					</div>
			
                   			<div class="cf"></div>
						</div>
					</section>
</section>