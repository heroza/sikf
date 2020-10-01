<section id="content">
					<section id="pane">
						<header>
							<h1> <?php echo $subsub ?></h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."auditor/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditor/".$sub_link ?>"><?php echo $sub ?></a></li>
									<li><a href="<?php echo base_url()."auditor/".$subsub_link ?>"><?php echo $subsub ?></a></li>
								</ul>
							</nav>
						</header>
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>                        
						<div id="pane-content">
						
							<div class="g4 aligncenter space-bottom-20">
								<?php echo $output; ?>
							</div>
                   			<div class="cf"></div>
						</div>
					</section>
</section>