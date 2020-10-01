<section id="content">
					<section id="pane">
						<header>
							<h1> Borang AMAI</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."admin/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."admin/borang" ?>">Borang</a></li>													
                                </ul>
							</nav>
						</header>
                 
						<div id="pane-content">
                        
						<div class="g4 aligncenter space-bottom-20">
							<a class="bt large" title="Perspektif" href="<?php echo base_url(); ?>admin/perspektif">
                                <span class="glyph-portrait-view"></span>
                                <div>Perspektif</div>
                            </a>
                            
                            <a class="bt large" title="Standar" href="<?php echo base_url(); ?>admin/standar">
                                <span class="glyph-portrait-view"></span>
                                <div>Standar</div>
                            </a>	
						
                			<a class="bt large" title="Visi Misi dan Strategi" href="<?php echo base_url(); ?>admin/visi_misi">
                                <span class="glyph-portrait-view"></span>
                                <div>Visi Misi Universitas</div>
                            </a>	
						
                			<a class="bt large" title="Instrumen dan Rubrik" href="<?php echo base_url(); ?>admin/instrumen">
                                <span class="glyph-portrait-view"></span>
                                <div>Instrumen Borang</div>
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