<section id="content">
					<section id="pane">
						<header>
							<h1> Penugasan</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."auditee/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditee/Penugasan" ?>">Penugasan</a></li>
									<li><a href="<?php echo base_url()."auditee/jadwal" ?>">Jadwal</a></li>													
                                </ul>
							</nav>
						</header>
                 
						<div id="pane-content">
						
							<div class="g4 aligncenter space-bottom-20">
								<form method="POST" action="<?php echo base_url().'auditee/do_upload' ?>" enctype='multipart/form-data'>
									<input name="file" type="file" title="Search for a file to add" />	
									<input name="id_jadwal" type="hidden" value="<?php echo $id_jadwal; ?>" />
									<input type="submit" class="bt large" value="Upload" />
	                            </form>
							</div>			
                   			<div class="cf"></div>
						</div>
					</section>
</section>