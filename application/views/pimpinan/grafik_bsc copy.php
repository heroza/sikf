<script type="text/javascript" src="<?php echo base_url(); ?>assets/grocery_crud/js/jquery-1.8.2.min.js"></script>
<?php //Laporan Berdasarkan Perspektif
foreach($sum -> result_array() as $s) 
{ $totalbobot = $s['sum']; }
$data['strategi_bsc'] = $this->Pimpinan_model->Strategi_Bsc("$id_instrumen"); 

foreach($total_penelitian_group -> result_array() as $group) 
{ 
	$tot_penelitian_group[$group['tahun_pelaksanaan']] = $group['jumlah']; 
	$tahuns[] = $group['tahun_pelaksanaan'];
	$tahuns_string[] = $group['tahun_pelaksanaan'].'';
}

foreach($data['strategi_bsc']->result_array() as $str_bsc)
{
  $id_strategi = $str_bsc['id_strategi'];	
  $total[$id_strategi] = 0;
  $totalpersen[$id_strategi] = 0;
  $data1[$id_strategi] = 0;
  foreach($perspektif_bsc->result_array() as $p_bsc)
  {
	$data_p[] = "'".$p_bsc['perspektif']."'";
	$id_perspektif = $p_bsc['id_perspektif'];
	$sum_perspektif = 0;
	$count_perspektif = 0;
	$bobot_perspektif = 0;
	$data_rubrik = "";
	$data2[$id_strategi][$id_perspektif] =0;
	$data3[$id_strategi][$id_perspektif] =0;
	$data['standar_rubrik_bsc'] = $this->Pimpinan_model->Standar_Rubrik_Bsc("$id_instrumen","$id_perspektif","$id_strategi"); 
	foreach($data['standar_rubrik_bsc']->result_array() as $sr)
	{
	  $id_standar = $sr['id_standar']; 
	  $data['rubrik'] = $this->Pimpinan_model->Pilih_Content('rubrik',"id_instrumen = $id_instrumen AND id_standar = $id_standar"); 
	  foreach($data['rubrik']->result_array() as $r)
	  { $id_rubrik = $r['id_rubrik'];
		$count_auditor = 0;
		$sum_rubrik = 0;
		$data['jadwal_auditor'] = $this->Pimpinan_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
		foreach($data['jadwal_auditor']->result_array() as $ja)  
		{   $count_auditor++;
			$id_jadwal_auditor = $ja['id_jadwal_auditor'];
			$data['nilai'] = $this->Pimpinan_model->Total_Data("penilaian_auditor where id_rubrik=$id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
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
		$data_rubrik = $data_rubrik.$sum_rubrik.", " ;
		$sum_perspektif =  $sum_perspektif + $sum_rubrik; // total nilai perspektif
		$bobot_perspektif = $r['bobot'] + $bobot_perspektif; //total bobot perspektif
		$count_perspektif++;	
	  }
	}  
	$data1[$id_strategi] = $bobot_perspektif + $data1[$id_strategi]; // total bobot setiap perspektif
	$data2[$id_strategi][$id_perspektif] = round($sum_perspektif/$bobot_perspektif*100,2); //rumus persentase nilai setiap perspektif = niai perspektif/bobot perspektif * 100%	
	$data3[$id_strategi][$id_perspektif] = $sum_perspektif; //array kumpulan nilai setiap perspektif
	$total[$id_strategi]=$total[$id_strategi] + $data3[$id_strategi][$id_perspektif]; // nilai total setiap strategi
  }  
$totalpersen[$id_strategi] = round($total[$id_strategi]/$data1[$id_strategi]*100,2); //rumus persentase nilai total strategi = nilai total / totol bobot strategi *100% 

}
?>
		
<?php // Laporan Berdasarkan Standar
foreach($standar_rubrik->result_array() as $sr)  // mengambil standar rubrik berdasarkan id_instrumen pada controller
{
$id_standar = $sr['id_standar']; 
$sum_standar = 0;
$bobot_standar = 0;
$data_rubrik = "";
$data_kpi = "";
$data['rubrik'] = $this->Pimpinan_model->Pilih_Content('rubrik',"id_instrumen = $id_instrumen AND id_standar = $id_standar"); 
foreach($data['rubrik']->result_array() as $r)   // mengambil rubrik berdasarkan id_instrumen dan id_standar
{   $id_rubrik = $r['id_rubrik'];
	$count_auditor = 0;
	$sum_rubrik = 0;
	$data['jadwal_auditor'] = $this->Pimpinan_model->Total_Data("jadwal_auditor where id_jadwal = $id_jadwal AND validasi_auditor = 'Sudah'");
	foreach($data['jadwal_auditor']->result_array() as $ja)    // mengambil auditor yang telah input nilai dan validasi sesuai id_jadwal
	{   $count_auditor++;
		$id_jadwal_auditor = $ja['id_jadwal_auditor'];
		$data['nilai'] = $this->Pimpinan_model->Total_Data("penilaian_auditor where id_rubrik=$id_rubrik AND id_jadwal_auditor = $id_jadwal_auditor");
		if (count($data['nilai']->result_array())>0)
		{	foreach($data['nilai']->result_array() as $n)   // mengambil hasil penilaian auditor disetiap rubrik per auditor
			{ 
				$sum_rubrik = $n['realisasi_auditor']+ $sum_rubrik;     // menjumlahkan nilai seluruh rubrik dari semua auditor
			}
		}else
		{
			$sum_rubrik = 0 + $sum_rubrik;     					  // nilai rubrik 0 apabila belum diisi oleh auditor
		}
	}
	$sum_rubrik = round($sum_rubrik/$count_auditor);     			//  total nilai 1 rubrik dari semua auditor dibagi jumlah auditor (rata2 nilai suatu rubrik)
	$data_rubrik= $data_rubrik.$sum_rubrik.", " ;        			// Nilai rubrik disimpan didalam array
	
	$sum_rubrik = round($sum_rubrik/$r['target']*$r['bobot'],2);   // nilai rata2 rubrik di bagi target dikali bobot.
	$sum_standar = $sum_rubrik + $sum_standar;                     // semua rubrik dijumlahkan per standar masing-masing
	$bobot_standar = $r['bobot'] + $bobot_standar;				  // menjumlahkan dan menyimpan bobot rubrik per standar 
	$data_kpi = $data_kpi."'".$r['sumber_referensi']."',";
}
$data4[] = "'".$sr['standar']."'";
$data5[] = round($sum_standar/$bobot_standar*100,2);				// total nilai rubrik telah dibagi bobot *100 disimpan didalam array sesuai standar
$data6[] = $data_kpi;											   // Data judul setiap rubrik
$data7[] = $data_rubrik;											// nilai setiap rubrik disimpan saru per satu
$data8[] = $sum_standar;											// total nilai rubrik disimpan didalam array sesuai standar
}

$num = count($data8);
$total = 0;
for($i=0;$i<$num;$i++)
{ $total=$total + $data8[$i]; }
foreach($sum -> result_array() as $s) 
{ $totalbobot = $s['sum']; }
$totalpersen2 = round($total/$totalbobot*100,2);
?>

		
<script type="text/javascript">
$(function () {
	
    $('#speedo').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 5,
			borderWidth: 5,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Total Nilai <?php echo $prodi; ?>'
	    },
	    subtitle: {
                text: '<?php echo $instrumen.". ".$periode; ?>'
            },
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 120,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'Persentase (%)'
	        },
	        plotBands: [{
	            from: 0,
	            to: 40,
	            color: '#DF5353' // red
	        }, {
	            from: 40,
	            to: 60,
	            color: '#FF3300' // yellow
	        }, {
	            from: 60,
	            to: 75,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: 75,
	            to: 85,
	            color: '#A7FF04' // yellow
	        }, {
	            from: 85,
	            to: 120,
	            color: '#55BF3B' // green
	        }]        
	    },
		credits: {
                enabled: false
            },
	    series: [
			{
	        name: 'Total Nilai <?php echo $prodi; ?>',
	        data: [<?php echo $totalpersen2; ?>],
	        tooltip: {
	            valueSuffix: ' %'
	        	}
	    	}
		]
	});
});
</script>		
<script type="text/javascript">
$(function () {
        $('#grafik').highcharts({
            chart: {
                type: 'column',
				borderWidth: 5,
				plotBorderWidth: 5,
				zoomType: 'x'
            },
            title: {
                text: 'Grafik Hasil Pencapaian Strategi, <?php echo $prodi; ?>'
            },
            subtitle: {
                text: '<?php echo $instrumen.". ".$periode; ?>'
            },
            xAxis: {
                categories: [<?php echo join($data_p, ',') ?>],
				title: {
                    text: 'Perspektif'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai Dalam Persentase (%)'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' %'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [
			<?php
			foreach($data['strategi_bsc']->result_array() as $str_bsc)
			{   $id_strategi = $str_bsc['id_strategi'];
				$strategi = $str_bsc['strategi']; ?>
				{
                name: '<?php echo $strategi; ?>',
                data: [<?php 
				foreach($perspektif_bsc->result_array() as $p_bsc)
  				{
					$id_perspektif = $p_bsc['id_perspektif'];
					echo $data2[$id_strategi][$id_perspektif].','; 
				}
				?>]
            },
			<?php } ?>
			]
        });
    });
</script>
		
<script type="text/javascript">
$(function () {
    
        var colors = Highcharts.getOptions().colors,
            categories = [<?php echo join($data4, ',') ?>],
            name = 'Standar',
            data = [
			<?php
			$num = count($data5);
			for($i=0;$i<$num;$i++)
			{ 
			?>
					{
                    y: <?php echo $data5[$i] ?>,
                    color: colors[<?php echo $i ?>],
                    drilldown: {
                        name: <?php echo $data4[$i] ?>,
                        categories: [<?php echo $data6[$i] ?>],
                        data: [<?php echo $data7[$i] ?>],
                        color: colors[<?php echo $i ?>]
                    }
             },
			 <?php } ?>
			];
    
        function setChart(name, categories, data, color) {
			chart.xAxis[0].setCategories(categories, false);
			chart.series[0].remove(false);
			chart.addSeries({
				name: name,
				data: data,
				color: color || 'white'
			}, false);
			chart.redraw();
        }
    
        var chart = $('#container').highcharts({
            chart: {
                type: 'column',
				borderWidth: 5,
				zoomType: 'x'
            },
            title: {
                text: 'Grafik Hasil Berdasarkan Standar, <?php echo $prodi; ?>'
            },
            subtitle: {
                text: '<?php echo $instrumen.". ".$periode; ?>'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Hasil Penilaian'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    setChart(name, categories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },

                        formatter: function() {
                        	var point = this.point
                    		if (point.drilldown) {
                        	return this.y +'%';
							} else {
							return this.y;
							}
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point
                    if (point.drilldown) {
                        s = 'Hasil Penilaian '+ this.x +':<b> '+ this.y +'% </b><br/>';
						s += 'Click to view drilldown detail';
                    } else {
						s = 'Hasil Penilaian '+ this.x +':<b> '+ this.y +' </b><br/>';
                        s += 'Click to return to Standar';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: '#000000'
            }],
            credits: {
                enabled: false
            }
        })
        .highcharts(); // return chart
    });
</script>
		
<script type="text/javascript">
$(function () {
    
        var colors = Highcharts.getOptions().colors,
            categories = [<?php echo join($tahuns_string, ',') ?>],
            name = 'Penelitian',
            data = [
            <?php
            $index = 0;
			foreach ($tahuns as $tahun) 
			{
			?>
					{
                    y: <?php echo $tot_penelitian_group[$tahun]; ?>,
                    color: colors[<?php echo $index++ ?>],
                    drilldown: {
                        name: <?php echo $tahun ?>,
                        categories: [2012],
                        data: [<?php echo 2 ?>],
                        color: colors[0]
                    }
             },
			 <?php } ?>
			];
    
        function setChart(name, categories, data, color) {
			chart.xAxis[0].setCategories(categories, false);
			chart.series[0].remove(false);
			chart.addSeries({
				name: name,
				data: data,
				color: color || 'white'
			}, false);
			chart.redraw();
        }
    
        var chart = $('#penelitian').highcharts({
            chart: {
                type: 'column',
				borderWidth: 5,
				zoomType: 'x'
            },
            title: {
                text: 'Grafik Total Penelitian, <?php echo $prodi; ?>'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Total Penelitian'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    setChart(name, categories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },

                        formatter: function() {
                        	var point = this.point
                    		if (point.drilldown) {
                        	return this.y;
							} else {
							return this.y;
							}
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point
                    if (point.drilldown) {
                        s = 'Hasil Penilaian '+ this.x +':<b> '+ this.y +'</b><br/>';
						s += 'Click to view drilldown detail';
                    } else {
						s = 'Hasil Penilaian '+ this.x +':<b> '+ this.y +' </b><br/>';
                        s += 'Click to return to Standar';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: '#000000'
            }],
            credits: {
                enabled: false
            }
        })
        .highcharts(); // return chart
    });
</script>

    <section id="content">
    <section id="pane">
        <header>
            <h1> Grafik Hasil</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="<?php echo base_url()."pimpinan/" ?>">Home</a></li>
                    <li><a href="<?php echo base_url()."pimpinan/".$sub_link ?>"><?php echo $sub ?></a></li>
                </ul>
            </nav>
        </header>
    	<div id="pane-content">				
            <div class="g4">
			<div class="table-wrapper">
            <table class='table table-striped dataTable'>
            	<tr><td width="13%">Program Studi </td><td> <?php echo $prodi; ?></td></tr>
                <tr><td>Instrumen </td><td> <?php echo $instrumen; ?></td></tr>
                <tr><td>Periode </td><td> <?php echo $periode; ?></td></tr>
                <tr><td>Auditor </td><td><?php 
				foreach($jadwal_auditor->result_array() as $ja)
				{   $id_auditor = $ja['id_auditor'];
					$data['auditor'] = $this->Pimpinan_model->Total_Data("auditor where auditor.id_auditor = $id_auditor");
            		foreach($data['auditor']->result_array() as $au)
					{ echo "- ".$au['nama']." [ Validasi Penilaian = ".$ja['validasi_auditor']." ]<br />"; }
                } ?>
                </td></tr>
                <tr><td>Total Nilai AMAI (%) </td><td> <?php echo $totalpersen2."%. [ Nilai Huruf = "; 
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
                <tr><td>Total Capaian Strategi(%) </td><td> 
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
            </div>
        
<script src="<?php echo base_url(); ?>asset/chart/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>asset/chart/js/highcharts-more.js"></script>
<script src="<?php echo base_url(); ?>asset/chart/js/modules/exporting.js"></script>
<div id="speedo" style="width: 500px; height: 400px; margin: 0 auto"></div><br />
<div id="grafik" style="min-width: 400px; min-height: 500px; margin: 0 auto"></div><br />
<div id="container" style="min-width: 400px; min-height: 500px; margin: 0 auto"></div><br />
<div id="penelitian" style="min-width: 400px; min-height: 500px; margin: 0 auto"></div>
            </div>
            <div class="cf"></div>
        </div>
	</section>
</section>