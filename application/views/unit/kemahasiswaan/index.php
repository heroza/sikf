<section id="content">
	<section id="pane">
		<header>
			<h1> Dashboard</h1>
			<nav class="breadcrumbs">
				<ul>
					<li><a href="<?php echo base_url()."unit/kemahasiswaan" ?>">Home</a></li>
					<li><a href="<?php echo base_url()."unit/kemahasiswaan" ?>">Dashboard</a></li>
				</ul>
			</nav>
		</header>
                 
	<div id="pane-content">
						
		<div class="g4 aligncenter space-bottom-20">
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kemahasiswaan/profil_mahasiswa_lulusan">
                                <span class="glyph-portrait-view"></span>
                                <div>Mahasiswa dan Lulusan</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kemahasiswaan/profil_mahasiswa_nonreguler">
                                <span class="glyph-portrait-view"></span>
                                <div>Mahasiswa Non-Reguler</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kemahasiswaan/prestasi_mahasiswa">
                                <span class="glyph-portrait-view"></span>
                                <div>Prestasi Mahasiswa</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kemahasiswaan/pelayanan_mahasiswa">
                                <span class="glyph-portrait-view"></span>
                                <div>Pelayanan Mahasiswa</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kemahasiswaan/evaluasi_lulusan">
                                <span class="glyph-portrait-view"></span>
                                <div>Evaluasi Kinerja Lulusan</div>
			</a>
			<a class="bt large" title="SIKKOM" href="<?php echo base_url(); ?>unit/kemahasiswaan/studi_pelacakan">
                                <span class="glyph-portrait-view"></span>
                                <div>Hasil Studi Pelacakan</div>
			</a>
		</div>
<?php
	//echo "<pre>\n";
	//print_r(get_defined_vars());
	//print_r($info->result_array());
	//echo "</pre>\n";
?>
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
