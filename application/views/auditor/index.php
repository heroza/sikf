<section id="content">
					<section id="pane">
						<header>
							<h1> Dashboard</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."auditor/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditor/" ?>">Dashboard</a></li>
								</ul>
							</nav>
						</header>
                 
						<div id="pane-content">
						
							<div class="g4 aligncenter space-bottom-20">
							<a class="bt large" href="<?php echo base_url(); ?>auditor/penugasan">
                                <span class="glyph-clock"></span>
                                <div>Penugasan</div>
                            </a>
                            <a class="bt large" href="<?php echo base_url(); ?>auditor/laporan">
                                <span class="glyph-rating"></span>
                                <div>Laporan AMAI</div>
                            </a>	
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