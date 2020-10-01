<section id="content">
					<section id="pane">
						<header>
							<h1> Laporan</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."prodi/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."prodi/pilih_laporan" ?>">Pilih Laporan</a></li>													
                                </ul>
							</nav>
						</header>
                 
						<div id="pane-content">
                        
						<div class="field g2">
                        <h1>Laporan Prodi</h1>
                        <form method="post" action="<?php echo base_url()."prodi/daftar_laporan" ?>">
            				<label><strong>Pilih Periode Pelaksanaan SIKKOM :</strong></label>
                            <div class="entry"><select name="id_periode">
                            		<option selected="selected" value="ALL">Seluruh Periode</option>
							<?php 
							foreach($periode->result_array() as $p)
							{ 	?>
                                	<option value="<?php echo $p['id_periode']; ?>" ><?php echo $p['periode']." - Tahun ".$p['tahun']; ?></option>
                            <?php }?>
                            </select></div>
                            <!--label><strong>Pilih Fakultas :</strong></label>
                            <div class="entry"><select name="id_fakultas">
                            		<option selected="selected" value="ALL">Seluruh Fakultas</option>
							<?php 
							foreach($fakultas->result_array() as $f)
							{ 	?>
                                	<option value="<?php echo $f['id_fakultas']; ?>" ><?php echo $f['fakultas']; ?></option>
                            <?php }?>
                            </select></div--><br />
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