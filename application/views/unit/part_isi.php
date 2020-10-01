<section id="content">
					<section id="pane">
						<header>
							<h1> <?php echo $title ?></h1>
							<nav class="breadcrumbs">
								<ul>
<?php 
$i=0;
foreach($crumbs as $crumb): ?>									
                                	<li>
                            		<?php 
                            		if ($crumbs_link[$i]==''){
	                                	echo $crumb;
	                                }else{
	                                	echo "<a href='".base_url().$crumbs_link[$i]."'>" ?><?php echo $crumb."</a>";
	                                }
	                                $i++;
                                	?>
                                	</li>
<?php endforeach; ?>                                	
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
						
							<div class="g4 space-bottom-90">
								<?php echo $output; ?>
							</div>
                   			<div class="cf"></div>
						</div>
					</section>
</section>