<section id="content">
					<section id="pane">
						<header>
							<h1> Dashboard</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."unit/kepegawaian" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."unit/kepegawaian" ?>">Dashboard</a></li>
								</ul>
							</nav>
						</header>
                 
						<div id="pane-content">
						
						<!--div class="g4 aligncenter space-bottom-20">
							<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kepegawaian/data_dosen">
                                <span class="glyph-portrait-view"></span>
                                <div>Data Dosen</div>
                            </a>
							<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kepegawaian/data_pegawai">
                                <span class="glyph-portrait-view"></span>
                                <div>Data Pegawai</div>
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