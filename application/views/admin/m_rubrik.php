<section id="content">
					<section id="pane">
						<header>
							<h1> <?php echo $subsub ?></h1>
							<nav class="breadcrumbs">
								<ul>
                                	<li><a href="<?php echo base_url()."admin/" ?>">Home</a></li>
									<li><a href="<?php echo base_url()."admin/".$sub_link ?>"><?php echo $sub ?></a></li>
									<li><a href="<?php echo base_url()."admin/".$subsub_link ?>"><?php echo $subsub ?></a></li>
								</ul>
							</nav>
						</header>
                    
                    <div id="pane-content">
						
						<div class="g4">
                    	<div class="table-wrapper">
					<?php
					foreach($instrumen->result_array() as $i)
					{
						$id_instrumen = $i['id_instrumen'];
						$instrumen = $i['instrumen'];
						$jenjang = $i['jenjang'];
						$edisi = $i['edisi'];
						$status = $i['status'];
					}
					foreach($sum -> result_array() as $s) 
					{
						$bobot = $s['sum'];
					}
					?>
                    <table class='table table-striped dataTable'>
                    <tr><td width="13%">Instrumen  </td><td> <?php echo $instrumen; ?></td></tr>
                    <tr><td>Jenjang </td><td> <?php echo $jenjang; ?></td></tr>
                    <tr><td>Tahun Edisi</td><td> <?php echo $edisi; ?></td></tr>
                    <tr><td>Status </td><td> <?php echo $status; ?></td></tr>
                    <tr><td>Total Bobot </td><td> <?php echo $bobot; ?></td></tr>
                    </table>
					<br /><?php
                    	if($status =="Persiapan")
						{ ?>
					<a href="<?php echo base_url()."admin/standar_rubrik/$id_instrumen/add" ?>" class="bt small"/>Tambah Rubrik dengan Standar Lain</a> 
                    <?php } ?>
                    <table class='table table-striped dataTable table-bordered'>
                    <thead>
                    <tr>
                    	<th><center><strong>Standar</strong></center></th>
						<th><center><strong>Jumlah rubrik berdasarkan standar</strong></center></th>
					</tr>
                    </thead>
                    <tbody>
                    <?php
					$total =0;
					foreach($rubrik->result_array() as $i)
					{ $total = $total + $i['jumlah'];?>
                    <tr align='center' bgcolor='#fff'>
					<td><center><?php echo $i['standar']; ?></center></td>
                    <td><center><a href="<?php echo base_url()."admin/rubrik/$id_instrumen/".$i['id_standar'] ?>">Jumlah Rubrik (<?php echo $i['jumlah']; ?>)</a></center></td>
					</tr>
                    <?php } ?>
                    <tr align='center' bgcolor='#fff'>
					<td><center><strong>Total Rubrik</strong></center></td>
                    <td><center><strong><?php echo $total; ?></strong></center></td>
					</tr>
                    <tbody>
                    </table>
                		</div>
                		</div>
                   			<div class="cf"></div>
						</div>
					</section>
</section>