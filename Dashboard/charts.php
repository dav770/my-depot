<?php 
include 'including/config.php'; ?>

<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="css/menu.css">

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
#container {
    height: 400px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

    </style>

<!-- Page content -->
<div id="page-content" class="page-dashboard"> 
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>
    <div class="block-title">
        <!-- <h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Calendrier' :'Planing' )?></strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' des Rappels' : ' of reminders') ?></h2> -->
        <h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Statistiques' :'Statistics' )?></strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' des séjours' : '') ?></h2>
        <div class="block-options pull-right">
            <!-- <i class="fa fa-calendar"></i> <input  style="height: 25px;" type="text" id="date_calendar" name="date_calendar" class="input-datepicker" data-date-format="yyyy" placeholder="Date du CA"> -->
            <i class="fa fa-calendar"></i> <input  style="height: 25px;" type="text" id="annee" name="annee" class="form-control" placeholder=<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' Année du CA' : ' Year') ?>>
            <button class="btn btn-info" id="btca"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
        </div>
    </div>
    <figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Chart showing browser market shares. Clicking on individual columns
        brings up more detailed data. This chart makes use of the drilldown
        feature in Highcharts to easily switch between datasets.
    </p>
    </figure>
</div>


<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script>
	$(document).ready(function(){

		setTimeout(() => {
			initIndex()	
		}, 1000);
		function initIndex(){
			$('#btca').click()
		}

		

		$('#annee').datepicker({
			format: "yyyy",
			weekStart: 1,
			orientation: "bottom",
			language: "{{ app.request.locale }}",
			keyboardNavigation: false,
			timeZone: true,
			viewMode: "years",
			minViewMode: "years"
		});
// Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

// Create the chart
var hChart = Highcharts.chart('container', {
    chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 10,
            beta: 25,
            depth: 70
        }
    },
    title: {
        text: '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Chiffre d\'affaire annuel" : "Annual sales") ?>'
    },
    subtitle: {
        text: '',
        align: 'left'
    },
    plotOptions: {
        column: {
            depth: 25
        }
    },
    xAxis: {
        categories: [],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'K'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [],
});

$('#btca').click(function(){
			
			HoldOn.open();
			$.post('appajax.php', {
				action: 'stats-init', 
				dt:$('#annee').val()}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
                        let cat = []
                        
                        $.each(JSON.parse(resp.cat), function(i, d) {
                           cat.push(d.name)
                        //    console.log(cat)
                        });
                        
                        $.each(JSON.parse(resp.serie), function(i, d) {
                            
                            

                            if(hChart.series[i]) {
                                hChart.series[i].setData(d.data,false, false);
                            } else { // series doesn't exist
                               
                                hChart.addSeries(d, false);
                            }
                        });
                        console.log(cat)
                        hChart.xAxis[0].categories = cat
                        hChart.redraw(true);
                        // hChart.addSeries(JSON.parse(resp.serie))
                        // hChart.series[0].setData(JSON.parse(resp.serie))
                    }else{
						$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
							type: 'danger',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});
                    }
					HoldOn.close();

				}, 'json');
		
			return false;
		});

    })
</script>