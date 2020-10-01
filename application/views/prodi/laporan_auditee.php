<?php //Laporan Berdasarkan Perspektif
$data['strategi_bsc'] = $this->Auditee_model->Strategi_Bsc("$id_instrumen"); 
foreach($data['strategi_bsc']->result_array() as $str_bsc)
{
  $id_strategi = $str_bsc['id_strategi'];	
  $total[$id_strategi] = 0;
  $totalpersen[$id_strategi] = 0;
  $data1[$id_strategi] = 0;
  foreach($perspektif_bsc->result_array() as $p_bsc)
  {
	$id_perspektif = $p_bsc['id_perspektif'];
	$sum_perspektif = 0;
	$count_perspektif = 0;
	$bobot_perspektif = 0;
	$data3[$id_strategi][$id_perspektif] =0;
	$data['standar_rubrik_bsc'] = $this->Auditee_model->Standar_Rubrik_Bsc("$id_instrumen","$id_perspektif","$id_strategi"); 
	foreach($data['standar_rubrik_bsc']->result_array() as $sr)
	{
	  $id_standar = $sr['id_standar']; 
	  $data['rubrik'] = $this->Auditee_model->Pilih_Content('rubrik',"id_instrumen = $id_instrumen AND id_standar = $id_standar"); 
	  foreach($data['rubrik']->result_array() as $r)
	  { $id_rubrik = $r['id_rubrik'];
		$count_auditor = 0;
		$sum_rubrik = 0;
		$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
		foreach($data['jadwal_auditor']->result_array() as $ja)
		{   $count_auditor++;
			$id_jadwal_auditor = $ja['id_jadwal_auditor'];
			$data['nilai'] = $this->Auditee_model->Total_Data("penilaian_auditor where id_rubrik=$id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
			if (count($data['nilai']->result_array())>0)
			{	foreach($data['nilai']->result_array() as $n)
				{ 
					$sum_rubrik = $n['realisasi_auditor']+ $sum_rubrik;
				}
			}else
			{
				$sum_rubrik = 0 + $sum_rubrik;
			}
		}
		$sum_rubrik = round($sum_rubrik/$count_auditor); //total nilai 1 rubrik dibagi jumlah auditor
		$sum_rubrik = round($sum_rubrik/$r['target']*$r['bobot'],2); //rumus bsc nilai rubrik/target*bobot
		$sum_perspektif =  $sum_perspektif + $sum_rubrik; // total nilai perspektif
		$bobot_perspektif = $r['bobot'] + $bobot_perspektif; //total bobot perspektif
		$count_perspektif++;	
	  }
	}  
	$data1[$id_strategi] = $bobot_perspektif + $data1[$id_strategi]; // total bobot setiap perspektif
	$data3[$id_strategi][$id_perspektif] = $sum_perspektif; //array kumpulan nilai setiap perspektif
	$total[$id_strategi]=$total[$id_strategi] + $data3[$id_strategi][$id_perspektif]; // nilai total setiap strategi
  }  
$totalpersen[$id_strategi] = round($total[$id_strategi]/$data1[$id_strategi]*100,2); //rumus persentase nilai total strategi = nilai total / totol bobot strategi *100% 

}
?>
		
<?php // Laporan Berdasarkan Standar
foreach($standar_rubrik->result_array() as $sr)
{
$id_standar = $sr['id_standar']; 
$sum_standar = 0;
$data['rubrik'] = $this->Auditee_model->Pilih_Content('rubrik',"id_instrumen = $id_instrumen AND id_standar = $id_standar"); 
foreach($data['rubrik']->result_array() as $r)
{   $id_rubrik = $r['id_rubrik'];
	$count_auditor = 0;
	$sum_rubrik = 0;
	$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	foreach($data['jadwal_auditor']->result_array() as $ja)
	{   $count_auditor++;
		$id_jadwal_auditor = $ja['id_jadwal_auditor'];
		$data['nilai'] = $this->Auditee_model->Total_Data("penilaian_auditor where id_rubrik=$id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
		if (count($data['nilai']->result_array())>0)
		{	foreach($data['nilai']->result_array() as $n)
			{ 
				$sum_rubrik = $n['realisasi_auditor']+ $sum_rubrik;
			}
		}else
		{
			$sum_rubrik = 0 + $sum_rubrik;
		}
	}
	$sum_rubrik = round($sum_rubrik/$count_auditor);
	$sum_rubrik = round($sum_rubrik/$r['target']*$r['bobot'],2);
	$sum_standar = $sum_rubrik + $sum_standar;
	}
$data8[] = $sum_standar;
}

$num = count($data8);
$total = 0;
for($i=0;$i<$num;$i++)
{ $total=$total + $data8[$i]; }
foreach($sum -> result_array() as $s) 
{ $totalbobot = $s['sum']; }
$totalpersen2 = round($total/$totalbobot*100,2);
?>
    <table width="100%">
    	<tr>
        	<td width="10%" align="center" valign="middle"><img src="<?php echo base_url(); ?>asset/images/unsri.png" width="100px"/></td>
            <td width="90%" align="center">
            	<strong>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</strong><BR>
                <strong><font size="+1">UNIVERSITAS SRIWIJAYA<BR>
                UPT PENJAMINAN MUTU</font></strong><BR>
                <font size="-1">Jalan Palembang - Prabumulih Km.32 Indralaya Ogan Ilir Kode Pos 30662<br>
				Telepon (0711)581010, Faksimile (0711) 581010, Email : upm@unsri.ac.id</font>                 	
            </td>
        </tr>
    </table><hr>
    <h2 align="center">LAPORAN HASIL AMAI</h2>
    <table width="100%">
            	<tr valign="top"><td width="130">Program Studi </td><td width="10"> : </td><td> <?php echo $prodi; ?></td></tr>
                <tr valign="top"><td>Instrumen </td><td> : </td><td> <?php echo $instrumen; ?></td></tr>
                <tr valign="top"><td>Periode </td><td> : </td><td> <?php echo $periode; ?></td></tr>
                <tr valign="top"><td>Auditor </td><td> : </td><td><?php 
				foreach($jadwal_auditor->result_array() as $ja)
				{   $id_auditor = $ja['id_auditor'];
					$data['auditor'] = $this->Auditee_model->Total_Data("auditor where auditor.id_auditor = $id_auditor");
            		foreach($data['auditor']->result_array() as $au)
					{ echo "- ".$au['nama']." [ Validasi Penilaian = ".$ja['validasi_auditor']." ]<br />"; }
                } ?>
                </td></tr>
                <tr valign="top"><td>Total Nilai AMAI (%) </td><td> : </td><td> <?php echo $totalpersen2."%. [ Nilai Huruf = "; 
				if ($totalpersen2 > 85)
					{echo "A ]"; }
					elseif ($totalpersen2 > 75 && $totalpersen2 <= 85)
					{echo "B ]"; }
					elseif ($totalpersen2 > 60 && $totalpersen2 <= 75)
					{echo "C ]"; }
					elseif ($totalpersen2 > 40 && $totalpersen2 <= 60)
					{echo "D ]";
					}
					elseif ($totalpersen2 >= 0 && $totalpersen2 <= 40)
					{ echo "E ]"; }
					echo "<br />"; ?>
                </td></tr>
                <tr valign="top"><td>Total Capaian Strategi(%) </td><td> : </td><td> 
				<?php
                foreach($data['strategi_bsc']->result_array() as $str_bsc)
				{   $id_strategi = $str_bsc['id_strategi'];
					$strategi = $str_bsc['strategi'];
					echo "- Strategi ".$strategi." = ".$totalpersen[$id_strategi]."%. [ Nilai Huruf = "; 
					if ($totalpersen[$id_strategi] > 85)
					{echo "A ]"; }
					elseif ($totalpersen[$id_strategi] > 75 && $totalpersen[$id_strategi] <= 85)
					{echo "B ]"; }
					elseif ($totalpersen[$id_strategi] > 60 && $totalpersen[$id_strategi] <= 75)
					{echo "C ]"; }
					elseif ($totalpersen[$id_strategi] > 40 && $totalpersen[$id_strategi] <= 60)
					{echo "D ]";
					}
					elseif ($totalpersen[$id_strategi] >= 0 && $totalpersen[$id_strategi] <= 40)
					{ echo "E ]"; }
					echo "<br />";
				}?></td></tr>
            </table>
			<br />
			<table border="1" width="100%" bordercolor="#000000">
            	<tr>
                	<td align="center" bgcolor="#999999"><strong>Praktik BAIK</strong></td>
                </tr>
                <tr>
                	<td align="center" bgcolor="#FFFFFF">Hal-hal menurut Auditor yang merupakan kekuatan, keunggulan, atau praktik baik yang teridentifikasi dan terbukti dengan jelas dalam audit.</td>
                </tr>
                <tr>
                	<td bgcolor="#FFFFFF" align="justify">
<?php 
	$i = 1;
	$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor, auditor where auditor.id_auditor = jadwal_auditor.id_auditor AND id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	foreach($data['jadwal_auditor']->result_array() as $ja)
	{ 
		echo $i.". ".$ja['nama']." : "; 
		$i++;
		$id_jadwal_auditor = $ja['id_jadwal_auditor'];
		$data['kunjungan_auditor'] = $this->Auditee_model->Total_Data("kunjungan_auditor where id_jadwal_auditor = $id_jadwal_auditor");
		if (count($data['kunjungan_auditor']->result_array())>0)
		{
			foreach($data['kunjungan_auditor']->result_array() as $ka)
			{			
				echo $ka['praktik_baik'];
 	  		} 
      	}
		else
		{
			echo "<center> - </center>";
		} 
	}?>			</td>
            	</tr>
            </table>
            <br />
            <table border="1" width="100%" bordercolor="#000000">
            	<tr>
                	<td align="center" bgcolor="#999999"><strong>Kelemahan</strong></td>
                </tr>
                <tr>
                	<td align="center" bgcolor="#FFFFFF">Hal-hal menurut Auditor yang merupakan kelemahan, kekurangan, inkonsistensi, ketidak-wajaran, atau bahkan kesalahan yang teridentifikasi dan terbukti dengan jelas dalam audit.</td>
                </tr>
                <tr>
                	<td bgcolor="#FFFFFF" align="justify">
<?php 
	$i = 1;
	$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor, auditor where auditor.id_auditor = jadwal_auditor.id_auditor AND id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	foreach($data['jadwal_auditor']->result_array() as $ja)
	{ 
		echo $i.". ".$ja['nama']." : "; 
		$i++;
		$id_jadwal_auditor = $ja['id_jadwal_auditor'];
		$data['kunjungan_auditor'] = $this->Auditee_model->Total_Data("kunjungan_auditor where id_jadwal_auditor = $id_jadwal_auditor");
		if (count($data['kunjungan_auditor']->result_array())>0)
		{
			foreach($data['kunjungan_auditor']->result_array() as $ka)
			{			
				echo $ka['kelemahan'];
 	  		} 
      	}
		else
		{
			echo "<center> - </center>";
		} 
	}?>			</td>
            	</tr>
            </table>
            <br />
            <table border="1" width="100%" bordercolor="#000000">
            	<tr>
                	<td align="center" bgcolor="#999999"><strong>Rekomendasi</strong></td>
                </tr>
                <tr>
                	<td align="center" bgcolor="#FFFFFF">Langkah atau tindakan apa yang menurut Auditor layak direkomendasikan terutama kepada Auditee, UPT Penjaminan Mutu, atau Pimpinan tertinggi Universitas, terkait dengan hasil AMAI terhadap Auditee.</td>
                </tr>
                <tr>
                	<td bgcolor="#FFFFFF" align="justify">
<?php 
	$i=1;
	$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor, auditor where auditor.id_auditor = jadwal_auditor.id_auditor AND id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	foreach($data['jadwal_auditor']->result_array() as $ja)
	{ 
		echo $i.". ".$ja['nama']." : "; 
		$i++;
		$id_jadwal_auditor = $ja['id_jadwal_auditor'];
		$data['kunjungan_auditor'] = $this->Auditee_model->Total_Data("kunjungan_auditor where id_jadwal_auditor = $id_jadwal_auditor");
		if (count($data['kunjungan_auditor']->result_array())>0)
		{
			foreach($data['kunjungan_auditor']->result_array() as $ka)
			{			
				echo $ka['rekomendasi'];
 	  		} 
      	}
		else
		{
			echo "<center> - </center>";
		} 
	}?>			</td>
            	</tr>
            </table>
            <br />
            <table border="1" width="100%" bordercolor="#000000">
            	<tr>
                	<td align="center" bgcolor="#999999"><strong>Kesimpulan</strong></td>
                </tr>
                <tr>
                	<td align="center" bgcolor="#FFFFFF">Uraian secara ringkas, padat, dan jelas seluruh rangkuman dari awal dimulainya AMAI hingga selesai kunjungan audit.</td>
                </tr>
                <tr>
                	<td bgcolor="#FFFFFF" align="justify">
<?php 
	$i=1;
	$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor, auditor where auditor.id_auditor = jadwal_auditor.id_auditor AND id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	foreach($data['jadwal_auditor']->result_array() as $ja)
	{ 
		echo $i.". ".$ja['nama']." : "; 
		$i++;
		$id_jadwal_auditor = $ja['id_jadwal_auditor'];
		$data['kunjungan_auditor'] = $this->Auditee_model->Total_Data("kunjungan_auditor where id_jadwal_auditor = $id_jadwal_auditor");
		if (count($data['kunjungan_auditor']->result_array())>0)
		{
			foreach($data['kunjungan_auditor']->result_array() as $ka)
			{			
				echo $ka['kesimpulan'];
 	  		} 
      	}
		else
		{
			echo "<center> - </center>";
		} 
	}?>			</td>
            	</tr>
            </table>
            <br />
            <table border="1" width="100%" bordercolor="#000000">
            	<tr>
                	<td align="center" bgcolor="#999999" colspan="3"><strong>Pernyataan Auditor</strong></td>
                </tr>
                <tr>
                	<td align="center" bgcolor="#FFFFFF" width="8%">No.</td>
                    <td align="center" bgcolor="#FFFFFF" width="42%">Nama</td>
                    <td align="center" bgcolor="#FFFFFF" width="50%">Tanda tangan</td>
                </tr>
<?php $i = 1; 
	$data['jadwal_auditor'] = $this->Auditee_model->Total_Data("jadwal_auditor, auditor where auditor.id_auditor = jadwal_auditor.id_auditor AND id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	foreach($data['jadwal_auditor']->result_array() as $ja)
	{ 
		?>
            	<tr valign="top">
                	<td align="center" bgcolor="#FFFFFF"><?php echo $i."."; ?></td>
                    <td bgcolor="#FFFFFF"><?php echo $ja['nama']; ?></td>
					<td bgcolor="#FFFFFF"><br /><br /></td> 
                </tr>
			  <?php $i++; 
	}?>		
            </table>