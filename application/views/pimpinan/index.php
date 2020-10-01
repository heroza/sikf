

    <!-- Core CSS - Include with every page -->

    <!-- Page-Level Plugin CSS - Morris -->
    <link href="<?php echo base_url("dashboard-assets")?>/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->

    <style type="text/css">


.row {
}

.row:before,
.row:after {
  display: table;
  content: " ";
}

.row:after {
  clear: both;
}

.row:before,
.row:after {
  display: table;
  content: " ";
}

.row:after {
  clear: both;
}

.col-lg-6 {
	width: 47%; 
	float: left;
  position: relative;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}

.panel {
  margin-bottom: 20px;
  background-color: #ffffff;
  border: 1px solid transparent;
  border-radius: 4px;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
          box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
}

.panel-body {
  padding: 15px;
}

.panel-body:before,
.panel-body:after {
  display: table;
  content: " ";
}

.panel-body:after {
  clear: both;
}

.panel-body:before,
.panel-body:after {
  display: table;
  content: " ";
}

.panel-body:after {
  clear: both;
}

.panel-heading {
  padding: 10px 15px;
  border-bottom: 1px solid transparent;
  border-top-right-radius: 3px;
  border-top-left-radius: 3px;
}

.panel-heading > .dropdown .dropdown-toggle {
  color: inherit;
}

.panel-default {
  border-color: #dddddd;
}

.panel-default > .panel-heading {
  color: #333333;
  background-color: #f5f5f5;
  border-color: #dddddd;
}
    </style>

<section id="content">
					<section id="pane">
						<header>
							<h1> Dashboard</h1>
							<nav class="breadcrumbs">
								<ul>
									<li><a href="<?php echo base_url()."pimpinan/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."pimpinan/" ?>">Dashboard</a></li>
								</ul>
							</nav>
						</header>
						<div class="row">
			                <div class="col-lg-6">
			                    <div class="panel panel-default">
			                        <div class="panel-heading">
			                            Penelitian 5 Tahun Terakhir
			                        </div>
			                        <!-- /.panel-heading -->
			                        <div class="panel-body">
				                        <input type="hidden" id="publikasiti" value="<?php echo($publikasiti)?>">
				                        <input type="hidden" id="publikasisi" value="<?php echo($publikasisi)?>">
				                        <input type="hidden" id="publikasisk" value="<?php echo($publikasisk)?>">
				                        <input type="hidden" id="penelitianti" value="<?php echo($penelitianti)?>">
				                        <input type="hidden" id="penelitiansi" value="<?php echo($penelitiansi)?>">
				                        <input type="hidden" id="penelitiansk" value="<?php echo($penelitiansk)?>">
			                            <div id="morris-donut-chart"></div>
			                        </div>
			                        <!-- /.panel-body -->
			                    </div>
			                    <!-- /.panel -->
			                </div>
			                <!-- /.col-lg-6 -->
							<div class="col-lg-6">
			                    <div class="panel panel-default">
			                        <div class="panel-heading">
			                            Penelitian per Tahun
			                        </div>
			                        <!-- /.panel-heading -->
			                        <div class="panel-body">
			                        	<?php
			                        		for ($i=$tahun; $i <= $tahun+4 ; $i++) { 
	                        			?>
			                        			<input type="hidden" id="publikasiti<?php echo($i)?>" value=0>
			                        			<input type="hidden" id="publikasisi<?php echo($i)?>" value=0>
			                        			<input type="hidden" id="publikasisk<?php echo($i)?>" value=0>
			                        			<input type="hidden" id="penelitianti<?php echo($i)?>" value=0>
			                        			<input type="hidden" id="penelitiansi<?php echo($i)?>" value=0>
			                        			<input type="hidden" id="penelitiansk<?php echo($i)?>" value=0>
	                        			<?php
			                        		}

			                        		foreach ($penelitiantipertahun as $penelitiantitahun) {
			                        	?>
			                        	<script type="text/javascript">
			                        		document.getElementById("penelitianti"+<?php echo($penelitiantitahun->tahun)?>).value = <?php echo($penelitiantitahun->jumlah)?>;
			                        	</script>
				                        

				                        <?php
						                    }

						                    foreach ($penelitiansipertahun as $penelitiansitahun) {
			                        	?>
			                        	<script type="text/javascript">
			                        		document.getElementById("penelitiansi"+<?php echo($penelitiansitahun->tahun)?>).value = <?php echo($penelitiansitahun->jumlah)?>;
			                        	</script>
				                        

				                        <?php
						                    }

						                    foreach ($penelitianskpertahun as $penelitiansktahun) {
			                        	?>
			                        	<script type="text/javascript">
			                        		document.getElementById("penelitiansk"+<?php echo($penelitiansktahun->tahun)?>).value = <?php echo($penelitiansktahun->jumlah)?>;
			                        	</script>
				                        

				                        <?php
						                    }
				                        ?>
			                            <div id="morris-bar-chart"></div>
			                        </div>
			                        <!-- /.panel-body -->
			                    </div>
			                    <!-- /.panel -->
			                </div>
			                <!-- /.col-lg-6 -->

			                <div class="col-lg-6">
			                    <div class="panel panel-default">
			                        <div class="panel-heading">
			                            Publikasi 5 Tahun Terakhir
			                        </div>
			                        <!-- /.panel-heading -->
			                        <div class="panel-body">
			                            <div id="pub-donut-chart"></div>
			                        </div>
			                        <!-- /.panel-body -->
			                    </div>
			                    <!-- /.panel -->
			                </div>
			                <!-- /.col-lg-6 -->
							<div class="col-lg-6">
			                    <div class="panel panel-default">
			                        <div class="panel-heading">
			                            Publikasi per Tahun
			                        </div>
			                        <!-- /.panel-heading -->
			                        <div class="panel-body">
			                        	<?php
			                        		foreach ($publikasitipertahun as $publikasititahun) {
			                        	?>
			                        	<script type="text/javascript">
			                        		document.getElementById("publikasiti"+<?php echo($publikasititahun->tahun)?>).value = <?php echo($publikasititahun->jumlah)?>;
			                        	</script>
				                        

				                        <?php
						                    }

						                    foreach ($publikasisipertahun as $publikasisitahun) {
			                        	?>
			                        	<script type="text/javascript">
			                        		document.getElementById("publikasisi"+<?php echo($publikasisitahun->tahun)?>).value = <?php echo($publikasisitahun->jumlah)?>;
			                        	</script>
				                        

				                        <?php
						                    }

						                    foreach ($publikasiskpertahun as $publikasisktahun) {
			                        	?>
			                        	<script type="text/javascript">
			                        		document.getElementById("publikasisk"+<?php echo($publikasisktahun->tahun)?>).value = <?php echo($publikasisktahun->jumlah)?>;
			                        	</script>
				                        

				                        <?php
						                    }
				                        ?>
			                            <div id="pub-bar-chart"></div>
			                        </div>
			                        <!-- /.panel-body -->
			                    </div>
			                    <!-- /.panel -->
			                </div>
			                <!-- /.col-lg-6 -->
		                </div>
					</section>
</section>



    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo base_url("dashboard-assets")?>/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url("dashboard-assets")?>/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("dashboard-assets")?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Morris -->
    <script src="<?php echo base_url("dashboard-assets")?>/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo base_url("dashboard-assets")?>/js/plugins/morris/morris.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?php echo base_url("dashboard-assets")?>/js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Morris - Use for reference -->
    <script src="<?php echo base_url("dashboard-assets")?>/js/demo/morris-demo.js"></script>