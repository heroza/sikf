<section id="content">
					<?php
                    foreach($info->result_array() as $i)
                    {
                        $judul = $i['judul'];
                        $isi = $i['isi'];
                        $tipe = $i['tipe'];
                    }
                    ?>
                    <section id="pane">
						<header>
							<h1> Informasi Halaman <?php echo $tipe ?></h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."admin/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."admin/informasi/?tipe=".$tipe ?>">Informasi</a></li>
								</ul>
							</nav>
						</header>
                 
					<div id="pane-content">
					
					<div class="widget minimizable g4">
						<form method="post" action="<?php echo base_url(); ?>admin/update_info">
                        <header>
                            <h2><div class="entry"><input type="text" size="250" name="judul" value="<?php echo $judul ?>"/></div></h2>
                        </header>
                        <div class="widget-section">
                            	<textarea name="isi" class="ckeditor"><?php echo $isi ?></textarea>
								<br />
                            	<input type="submit" class="bt small" value="Save" /> 
                                <input type="reset" class="bt small" value="Reset" />
                                <input type="hidden" name="tipe" value="<?php echo $tipe ?>" />
                                
                            
						</div>
                        </form>
					</div>
			
                   			<div class="cf"></div>
						</div>
					</section>
</section>