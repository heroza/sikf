<script>
		var drz, kata, x;
		function cekid(){
		kata = document.getElementById("userid").value;
		if(kata.length>0){
		document.getElementById("teks").innerHTML = "checking…";
		drz = buatajax();
		var url="<?php echo base_url();?>admin/cekid/";
		url=url+"?q="+kata;
		url=url+"&sid="+Math.random();
		drz.onreadystatechange=stateChanged;
		drz.open("GET",url,true);
		drz.send(null);
		}else{
		fokus();
		
		}
		}
		
		function buatajax(){
		if (window.XMLHttpRequest){
		return new XMLHttpRequest();
		}
		if (window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
		}
		return null;
		}
		
		function stateChanged(){
		var data;
		if (drz.readyState==4){
		data=drz.responseText;
		document.getElementById("teks").innerHTML = data;
		}
		}
		
		function fokus(){
		document.getElementById("userid").focus();
		}
    </script> 
<section id="content">
  			<section id="pane">
						<header>
							<h1> Profil</h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."admin/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."admin/profil" ?>">Profil</a></li>
								</ul>
							</nav>
						</header>
			<div id="pane-content">
					
                <div class="g4">
                    <div class="table-wrapper">
				<?php
				foreach($edit->result_array() as $d)
				{
					$id_admin = $d['id_admin'];
					$nama = $d['nama'];
					$username = $d['username'];
					$email = $d['email'];
				}
				?>
				<form method="post" action="<?php echo base_url(); ?>admin/updateprofil">
				<table class='table table-striped dataTable'>
                    <tr><td width="20%">Nama </td><td><div class="entry"><input type="text" size="70" name="nama" value="<?php echo $nama; ?>" /></div></td></tr>
                    <tr><td>Username </td><td><div class="entry"><input type="text" size="70" name="username" value="<?php echo $username; ?>" id="userid" onchange="cekid()"/></div><span id=teks style="color:red;font-size:10pt"></span></td></tr>
                    <input type="hidden" class="input" size="70" name="user_lama" value="<?php echo $username; ?>"/>
                    <tr><td>Email </td><td><div class="entry"><input type="text" class="span6 typeahead" size="70" name="email" value="<?php echo $email; ?>" /></div></td></tr>
                    <tr><td>Ganti Password </td><td><div class="entry"><input type="password" size="70" name="password"/></div><font color='#FF0000'> Hanya diisi apabila ingin mengganti password</font><br /></td></tr>
                    <tr><td>Ulangi Password Baru </td><td><div class="entry"><input type="password" size="70" name="password2"/></div><font color='#FF0000'> Hanya diisi apabila ingin mengganti password</font><br /><br /></td></tr>
                    <tr><td colspan="3">
                    
                        <input type="submit"  class="bt small" value="Save" /> 
                        <input type="reset"  class="bt small" value="Reset" />
                        <input type="hidden" name="id_admin"  value="<?php echo $id_admin; ?>"  />
                    </td></tr>
				</table></form>
			</div>
                        </div>
                   			<div class="cf"></div>
					</div>
					</section>
</section>