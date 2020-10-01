<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Sistem Informasi Fakultas Ilmu Komputer</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>asset/img/icon.png" />
<?php 
	$this->load->helper('HTML');
	echo link_tag('asset/login/css/screen.css'); 
?>

<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
</head>
<body id="login-bg"> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<img src="<?php echo base_url(); ?>asset/login/images/logo60x60.png" style="float:left;"/>
		<h1 style="font-size: 46px;; margin: 0px 0px 0px 60px; color:#ffffff">Sistem Informasi</h1>
		<h3 style="margin: 0px 0px 0px 60px; font-size:32px; color:#ffffff">Fakultas Ilmu Komputer</h3>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
	<!--  start login-inner -->

	<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-0">
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo base_url(); ?>login/proses_login" method="post">
                            <fieldset>
                                <!--div class="form-group">
	                            	<select class="form-control" name="sebagai">
										<option value="prodi">Prodi</option>
										<option value="pimpinan">Pimpinan Fasilkom</option>
										<option value="admin">Administrator</option>
										<option value="unit">Unit</option>
										<option value="dosen">Dosen</option>
									</select>
                                </div-->
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 	<!--  end login-inner -->
	<div class="clear"></div>
	<!-- <a href="" class="forgot-pwd">Forgot Password?</a> -->
 </div>
 <!--  end loginbox -->
</div>
<!-- End: login-holder -->
</body>
</html>