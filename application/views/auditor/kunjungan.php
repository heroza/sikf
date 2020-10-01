<section id="content">
  			<section id="pane">
						<header>
							<h1> Profil</h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."auditor/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."auditor/".$sub_link ?>"><?php echo $sub ?></a></li>
                                    <li><a href="<?php echo base_url()."auditor/".$subsub_link ?>"><?php echo $subsub ?></a></li>
								</ul>
							</nav>
						</header>
			<div id="pane-content">
					
                <div class="g4">
                    <div class="table-wrapper">
			<?php
            if (count($kunjungan->result_array())>0)
            {	foreach($kunjungan->result_array() as $k)
				{
				?>
				<form method="post" action="<?php echo base_url(); ?>auditor/update_kunjungan">
				<table class='table table-striped dataTable'>
				<tr><td width="13%"><label><strong>PRAKTIK BAIK.</strong></label>
                Tuliskan hal-hal menurut Auditor yang merupakan kekuatan, keunggulan, atau praktik baik yang teridentifikasi dan terbukti dengan jelas dalam audit.<br /><br /> 
                <textarea class="ckeditor" name="praktik_baik"><?php echo $k['praktik_baik']; ?></textarea></td></tr>
				<tr><td width="13%"><label><strong>KELEMAHAN.</strong></label>
                Tuliskan hal-hal menurut Auditor yang merupakan kelemahan, kekurangan, inkonsistensi, ketidak-wajaran, atau bahkan kesalahan yang teridentifikasi dan terbukti dengan jelas dalam audit.<br /><br /> 
                <textarea class="ckeditor" name="kelemahan"><?php echo $k['kelemahan']; ?></textarea></td></tr>
				<tr><td width="13%"><label><strong>REKOMENDASI.</strong></label>
                Tuliskan langkah atau tindakan apa yang menurut Auditor layak direkomendasikan terutama kepada Auditee, UPT Penjaminan Mutu, atau Pimpinan tertinggi Universitas, terkait dengan hasil AMAI terhadap Auditee. Jika memungkinkan, sebaiknya rekomendasi tersebut terbagi menjadi 3 (tiga) kategori yaitu rekomendasi yang berisi :<br />
(a) langkah-langkah yang amat esensial dan harus segera dilakukan/ditindak-lanjuti<br />
(b) langkah-langkah yang disarankan agar ditindak-lanjuti tetapi tidak mendesak sifatnya, dan<br />
(c) langkah-langkah yang diharapkan dapat ditindak-lanjuti demi peningkatan mutu di masa depan.<br /><br />
				<textarea class="ckeditor" name="rekomendasi"><?php echo $k['rekomendasi']; ?></textarea></td></tr>
				<tr><td width="13%"><label><strong>KESIMPULAN.</strong></label>
                Tuliskan uraian secara ringkas, padat, dan jelas seluruh rangkuman dari awal dimulainya AMAI hingga selesai kunjungan audit.<br /><br /> 
                <textarea class="ckeditor" name="kesimpulan"><?php echo $k['kesimpulan']; ?></textarea></td></tr>
				<input type="hidden" class="input" size="70" name="id_kunjungan" value="<?php echo $k['id_kunjungan']; ?>"/>
				<tr><td><input type="submit" class="bt small" value="Save" /></td></tr> 
                </table></form>
            <?php }
			}else
			{ ?>
            	<form method="post" action="<?php echo base_url(); ?>auditor/save_kunjungan">
				<table class='table table-striped dataTable'>
				<tr><td width="13%"><label><strong>PRAKTIK BAIK.</strong></label>
                Tuliskan hal-hal menurut Auditor yang merupakan kekuatan, keunggulan, atau praktik baik yang teridentifikasi dan terbukti dengan jelas dalam audit.<br /><br /> 
                <textarea class="ckeditor" name="praktik_baik"></textarea></td></tr>
				<tr><td width="13%"><label><strong>KELEMAHAN.</strong></label>
                Tuliskan hal-hal menurut Auditor yang merupakan kelemahan, kekurangan, inkonsistensi, ketidak-wajaran, atau bahkan kesalahan yang teridentifikasi dan terbukti dengan jelas dalam audit.<br /><br /> 
                <textarea class="ckeditor" name="kelemahan"></textarea></td></tr>
				<tr><td width="13%"><label><strong>REKOMENDASI.</strong></label>
                Tuliskan langkah atau tindakan apa yang menurut Auditor layak direkomendasikan terutama kepada Auditee, UPT Penjaminan Mutu, atau Pimpinan tertinggi Universitas, terkait dengan hasil AMAI terhadap Auditee. Jika memungkinkan, sebaiknya rekomendasi tersebut terbagi menjadi 3 (tiga) kategori yaitu rekomendasi yang berisi :<br />
(a) langkah-langkah yang amat esensial dan harus segera dilakukan/ditindak-lanjuti<br />
(b) langkah-langkah yang disarankan agar ditindak-lanjuti tetapi tidak mendesak sifatnya, dan<br />
(c) langkah-langkah yang diharapkan dapat ditindak-lanjuti demi peningkatan mutu di masa depan.<br /><br />
				<textarea class="ckeditor" name="rekomendasi"></textarea></td></tr>
				<tr><td width="13%"><label><strong>KESIMPULAN.</strong></label>
                Tuliskan uraian secara ringkas, padat, dan jelas seluruh rangkuman dari awal dimulainya AMAI hingga selesai kunjungan audit.<br /><br /> 
                <textarea class="ckeditor" name="kesimpulan"></textarea></td></tr>
				<input type="hidden" class="input" size="70" name="id_jadwal_auditor" value="<?php echo $id_jadwal_auditor ?>"/>
				<tr><td><input type="submit" class="bt small" value="Save" /></td></tr> 
                </table></form>
			<?php }?>
			</div>
                        </div>
                   			<div class="cf"></div>
					</div>
					</section>
</section>