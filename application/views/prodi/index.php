<section id="content">
					<section id="pane">
						<header>
							<h1> Dashboard</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."prodi/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."prodi/" ?>">Dashboard</a></li>
								</ul>
							</nav>
						</header>
                 
						<div id="pane-content">
						
							<!--div class="g4 aligncenter space-bottom-20">
							<a class="bt large" href="<?php echo base_url(); ?>prodi/deskripsi_diri">
                                <span class="glyph-clock"></span>
                                <div>Deskripsi Diri</div>
                            </a>
                            <a class="bt large" href="<?php echo base_url(); ?>prodi/data_dosen">
                                <span class="glyph-rating"></span>
                                <div>Dosen</div>
                            </a>
                            <a class="bt large" href="<?php echo base_url(); ?>prodi/penelitian">
                                <span class="glyph-rating"></span>
                                <div>Penelitian</div>
                            </a>
                            <a class="bt large" href="<?php echo base_url(); ?>prodi/publikasi">
                                <span class="glyph-rating"></span>
                                <div>Publikasi</div>
                            </a>
                            <a class="bt large" href="<?php echo base_url(); ?>prodi/matkul">
                                <span class="glyph-rating"></span>
                                <div>Mata Kuliah</div>
                            </a>
                            <a class="bt large" href="<?php echo base_url(); ?>prodi/laporan">
                                <span class="glyph-rating"></span>
                                <div>Grafik</div>
                            </a>
                            <a class="bt large" href="<?php echo base_url(); ?>prodi/borang">
                                <span class="glyph-rating"></span>
                                <div>Borang</div>
                            </a>	
						</div-->
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