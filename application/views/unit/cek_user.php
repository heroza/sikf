<script>
		var drz, kata, x;
		function cekid(){
		kata = document.getElementById("userid").value;
		table = document.getElementById("usertabel").value;
		if(kata.length>0){
		document.getElementById("teks").innerHTML = "checking…";
		drz = buatajax();
		var url="<?php echo base_url();?>admin/cekid_tabel/";
		url=url+"?q="+kata;
		url=url+"&t="+table;
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