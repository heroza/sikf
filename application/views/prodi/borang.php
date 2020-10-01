<section id="content">
					<section id="pane">
						<header>
							<h1> Dashboard</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."prodi/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."prodi/borang" ?>">Borang</a></li>
								</ul>
							</nav>
						</header>
                 
						<div id="pane-content">
							<form method="POST" action="<?php echo base_url(); ?>cetak/borang">
							<div class="g4 aligncenter space-bottom-20"><label for="myDate">Masa Evaluasi :</label>
							<input name="masa" class="monthYearPicker" value="<?php echo date('Y');?>"/>
							<input type="hidden" name="id_prodi" value="<?php echo $id_prodi;?>"> 
							</div>
							<div class="g4 aligncenter space-bottom-20">
                            <button class="bt large" type="submit">
                                
                                <div>Cetak Borang</div>
                            </button>
                            </form>
						</div>
                   			<div class="cf"></div>
						</div>
					</section>
</section>