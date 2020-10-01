<section id="content">
					<section id="pane">
						<header>
							<h1> Penugasan</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."admin/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."admin/Penugasan" ?>">Penugasan</a></li>													
                                </ul>
							</nav>
						</header>
                 
						<div id="pane-content">
                        
						<div class="g4 aligncenter space-bottom-20">
							<a class="bt large" title="Periode AMAI" href="<?php echo base_url(); ?>admin/periode">
                                <span class="glyph-clock"></span>
                                <div>Periode AMAI</div>
                            </a>	
						
                			<a class="bt large" title="Jadwal AMAI" href="<?php echo base_url(); ?>admin/jadwal">
                                <span class="glyph-clock"></span>
                                <div>Jadwal AMAI</div>
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
							
                            	<div class="aligncenter space-bottom-20">
								<a href="<?php echo base_url()."admin/informasi/?tipe=".$tipe ?>" class="bt small">Edit Informasi</a>
								</div>
                            </div>
						</div>
					</div>
			
                   			<div class="cf"></div>
						</div>
					</section>
</section>