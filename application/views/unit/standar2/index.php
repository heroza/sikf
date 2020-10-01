<section id="content">
	<section id="pane">
		<header>
			<h1> Dashboard</h1>
			<nav class="breadcrumbs">
				<ul>
					<li><a href="<?php echo base_url()."unit/standar2" ?>">Home</a></li>
					<li><a href="<?php echo base_url()."unit/standar2" ?>">Dashboard</a></li>
				</ul>
			</nav>
		</header>
                 
	<div id="pane-content">
						
		<div class="g4 aligncenter space-bottom-20">
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/standar2/tata_pamong">
                                <span class="glyph-portrait-view"></span>
                                <div>Sistem Tata Pamong</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/standar2/kepemimpinan">
                                <span class="glyph-portrait-view"></span>
                                <div>Kepemimpinan</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/standar2/sistem_pengelolaan">
                                <span class="glyph-portrait-view"></span>
                                <div>Sistem Pengelolaan</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/standar2/penjaminan_mutu">
                                <span class="glyph-portrait-view"></span>
                                <div>Penjaminan Mutu</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/standar2/umpan_balik">
                                <span class="glyph-portrait-view"></span>
                                <div>Umpan Balik</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/standar2/keberlanjutan">
                                <span class="glyph-portrait-view"></span>
                                <div>Keberlanjutan</div>
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
