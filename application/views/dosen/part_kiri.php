<section id="page">
				<aside id="sidebar">
					<div id="logo">
						<a><img src="<?php echo base_url(); ?>asset/images/logo.png"/></a>
					</div>
					<div class="menus">
						<!-- menu #1 -->
						<nav>
							<h2>Main Menu</h2>
							
							<ul>
								<li>
									<a href="<?php echo base_url(); ?>dosen/">
										<i class="glyph-cloud"></i>
										<div class="label">Dashboard</div>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url('dosen/data_dosen/edit/'.$kode_dosen); ?>">
										<i class="glyph-rating"></i>
										<div class="label">Data Diri</div>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>dosen/penelitian">
										<i class="glyph-rating"></i>
										<div class="label">Penelitian</div>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>dosen/publikasi">
										<i class="glyph-rating"></i>
										<div class="label">Publikasi</div>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>dosen/pm">
										<i class="glyph-rating"></i>
										<div class="label">Pengabdian Masyarakat</div>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>dosen/change_password">
										<i class="glyph-rating"></i>
										<div class="label">Ubah Password</div>
									</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo base_url(); ?>cv.php?id=<?php echo($kode_dosen)?>">
										<i class="glyph-rating"></i>
										<div class="label">CV Online</div>
									</a>
								</li>
								<!--li>
									<a href="<?php echo base_url(); ?>dosen/publikasi">
										<i class="glyph-rating"></i>
										<div class="label">Publikasi</div>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>dosen/matkul">
										<i class="glyph-rating"></i>
										<div class="label">Mata Kuliah</div>
									</a>
								</li-->
                        	</ul>
						</nav>
						<!-- /menu -->
					</div>
				</aside>