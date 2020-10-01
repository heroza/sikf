<script type="text/javascript" src="<?php echo base_url(); ?>assets/grocery_crud/js/jquery-1.8.2.min.js"></script>
<?php
foreach($total_penelitian_group -> result_array() as $group) 
{ 
	$tot_penelitian_group[$group['tahun_pelaksanaan']] = $group['jumlah']; 
    $tahuns[] = $group['tahun_pelaksanaan'];
    $prodis[] = $group['prodi'];
	$tahuns_string[] = $group['tahun_pelaksanaan'].'';
}
?>
		
		
<script type="text/javascript">
$(function () {
        $('#penelitian').highcharts({
    
            chart: {
                type: 'column'
            },
    
            title: {
                text: 'Total Penelitian Per Tahun'
            },
    
            xAxis: {
                categories: [2010, 2011, 2012, 2013, 2014]
            },
    
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Number of fruits'
                }
            },
    
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
    
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
    
            series: [{
                name: 'John',
                data: [5, 3, 4, 7, 2],
                stack: 'male'
            }, {
                name: 'Joe',
                data: [3, 4, 4, 2, 5],
                stack: 'male'
            }, {
                name: 'Jane',
                data: [2, 5, 6, 2, 1],
                stack: 'female'
            }, {
                name: 'Janet',
                data: [3, 0, 4, 4, 3],
                stack: 'female'
            }]
        });
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
                <tr><td width="13%">Fakultas </td><td> Ilmu Komputer</td></tr>
                <tr><td width="13%">Kode Prodi 1 </td><td> Teknik Informatika</td></tr>
                <tr><td width="13%">Kode Prodi 2 </td><td> Sistem Informasi</td></tr>
                <tr><td width="13%">Kode Prodi 3 </td><td> Sistem Komputer</td></tr>
            </table>
            </div>
        
<script src="<?php echo base_url(); ?>asset/chart/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>asset/chart/js/highcharts-more.js"></script>
<script src="<?php echo base_url(); ?>asset/chart/js/modules/exporting.js"></script>
<div id="penelitian" style="min-width: 400px; min-height: 500px; margin: 0 auto"></div>
            </div>
            <div class="cf"></div>
        </div>
	</section>
</section>