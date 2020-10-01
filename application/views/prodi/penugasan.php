<section id="content">
					<section id="pane">
						<header>
							<h1> Penugasan</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."auditee/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditee/Penugasan" ?>">Penugasan</a></li>													
                                </ul>
							</nav>
						</header>
                 
						<div id="pane-content">
						
							<div class="g4 aligncenter space-bottom-20">
							<a class="bt large" href="<?php echo base_url(); ?>auditee/jadwal">
                                <span class="glyph-clock"></span>
                                <div>Jadwal</div>
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