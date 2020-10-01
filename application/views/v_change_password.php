<section id="content">
					<section id="pane">
						<header>
							<h1>Ubah Password</h1>
							
						</header>
                 
						<div id="pane-content">
						
							<div class="widget minimizable g4">
								<header>
		                            <h2><?php echo "Form Ubah Password" ?></h2>
		                        </header>
		                        <div class="widget-section">
		                            <div class="content">
		                            	<div style="color:#FF0000;"><?php echo($message)?></div>
										<form id="form_change_password" method="post" action="<?php echo base_url($owner); ?>/do_change_password" onsubmit="return validate();">
											<table class='table table-striped dataTable'>
											<tr><td width="22%">Password Lama </td><td width="80%"><div class="entry"><input type="password" class="span6 typeahead" size="70" name="oldpassword" id="oldpassword" style="margin-bottom:10px;" /></div></td></tr>
											<tr><td>Password Baru </td><td><div class="entry"><input type="password" size="70" name="newpassword" id="newpassword" style="margin-bottom:10px;" /></div></td></tr>
											<tr><td>Ulangi Password Baru </td><td><div class="entry"><input type="password" size="70" name="confirmnewpassword" id="confirmnewpassword" style="margin-bottom:10px;" /></div></td></tr>
											<tr><td>&nbsp;</td><td><div id="warningconfirmpassword" style="color:#FF0000;"></div></td></tr>
											<input type="hidden" class="input" size="70" name="username" value="<?php echo $username; ?>"/>
											<tr><td>&nbsp;</td><td><input type="submit"  class="bt small" value="Simpan" style="font-size: 12px;" /></td></tr>
											</table>
										</form>
		                            </div>
								</div>
							</div>
			
                   			<div class="cf"></div>
						</div>
					</section>
</section>
<script type="text/javascript">
function validate () {
	if(document.getElementById('newpassword').value != document.getElementById('confirmnewpassword').value)
	{
		document.getElementById('warningconfirmpassword').innerHTML = "Password baru yang Anda tulis tidak sesuai.";
		return false;
	}
	else if(document.getElementById('newpassword').value == ""){
		document.getElementById('warningconfirmpassword').innerHTML = "Password baru tidak boleh kosong.";
		return false;
	}
	else
	{
		var regexp = /^[a-zA-Z0-9-_]+$/;
		var check = document.getElementById('newpassword').value;
		if (check.search(regexp) == -1)
	    { 
	    	document.getElementById('warningconfirmpassword').innerHTML = "Karakter yang diperbolehkan hanya huruf, angka, karakter dash, dan karakter underscore.";
			return false;
	    }
		else
		    {
				document.getElementById('oldpassword').value = md5(md5(document.getElementById('oldpassword').value));
				document.getElementById('newpassword').value = md5(md5(document.getElementById('newpassword').value));
				document.getElementById('confirmnewpassword').value = md5(document.getElementById('confirmnewpassword').value);
			}
	}
}
</script>
<script src="<?php echo base_url(); ?>asset/js/md5.js"></script>