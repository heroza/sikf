<script type="text/javascript" src="<?php echo base_url(); ?>assets/grocery_crud/js/jquery-1.8.2.min.js"></script>
<?php
foreach($total_penelitian_group -> result_array() as $group) 
{ 
	$tot_penelitian_group[$group['tahun_pelaksanaan']] = $group['jumlah']; 
	$tahuns[] = $group['tahun_pelaksanaan'];
	$tahuns_string[] = $group['tahun_pelaksanaan'].'';
}
?>
		
		
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
                text: 'Grafik Total Penelitian'
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
            <h1> Grafik Hasil Penelitian</h1>
        </header>
    	<div id="pane-content">				
            <div class="g4">
        
<script src="<?php echo base_url(); ?>asset/chart/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>asset/chart/js/highcharts-more.js"></script>
<script src="<?php echo base_url(); ?>asset/chart/js/modules/exporting.js"></script>
<div id="penelitian" style="min-width: 400px; min-height: 500px; margin: 0 auto"></div>
            </div>
            <div class="cf"></div>
        </div>
	</section>
</section>