<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<title>Sistem Informasi Fakultas Ilmu Komputer</title>
		<!-- Optimized mobile viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        
        <!-- CSS -->
        <?php 
	$this->load->helper('HTML');
	echo link_tag('asset/css/icomoon.css');
	echo link_tag('asset/css/websymbols.css');
	// echo link_tag('asset/css/formalize.css');
	echo link_tag('asset/css/style.css');
	echo link_tag('asset/css/theme-blue.css');
	echo link_tag('asset/plugins/chosen/chosen.css');
	echo link_tag('asset/plugins/ui/ui-custom.css');
	echo link_tag('asset/plugins/tipsy/tipsy.css');
	echo link_tag('asset/plugins/validationEngine/validationEngine.jquery.css');
	echo link_tag('asset/plugins/elrte/css/elrte.min.css');
	echo link_tag('asset/plugins/miniColors/jquery.miniColors.css');
	echo link_tag('asset/plugins/fullCalendar/fullcalendar.css');
	echo link_tag('asset/plugins/elfinder/css/elfinder.css');
	echo link_tag('asset/plugins/farbtastic/farbtastic.css');
	?>
		<!-- The fav icon -->
		<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>asset/img/icon.png">
		<script type="text/javascript" src="<?php echo base_url(); ?>asset/ckeditor2/ckeditor.js"></script> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery-1.9.1.js'></script>
  
  
  
  
  <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/jquery-ui.css">
 
	  
	  <style type='text/css'>
	    .ui-datepicker-calendar {
	    display: none;
	 }
	  </style>

		<script type='text/javascript'>//<![CDATA[ 
$( document ).ready(function() {
$(function() {
	$('.monthYearPicker').datepicker({
		changeMonth: false,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'yy'
	}).focus(function() {
		var thisCalendar = $(this);
		$('.ui-datepicker-calendar').detach();
		$('.ui-datepicker-close').click(function() {
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
thisCalendar.datepicker('setDate', new Date(year, 1, 1));
		});
	});
});
});//]]>  

</script>

	</head>
    
    <body class="fixed fixed-topbar"><!-- .fixed or .fluid -->
		<div id="wrapper">
			<section id="top">
				<header>
					<nav id="menu-bar">
						<ul>
							<li class="with-submenu">
								<a>Selamat Datang, Kaprodi <?php echo $prodi ?></a>
							</li>
							<!--li class="with-submenu">
								<a href="<?php echo base_url(); ?>prodi/theme">Theme</a>
							</li-->
							<!-- .keep makes the element aways visible (even in smaller screens) -->
							<li class="keep"><a href="<?php echo base_url(); ?>prodi/logout" class="bt-alt">Logout</a></li>
						</ul>
					</nav>
				</header>
             </section>
	<!-- topbar ends -->
