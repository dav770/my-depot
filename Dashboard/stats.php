<?php 
include 'including/config.php'; 
// echo(print_r($arrAccess));
?>

<?php 
	include 'including/headPage.php'; 
	$sejours = Setting::getAllorganisateurs();

?>

<link rel="stylesheet" href="css/menu.css">

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
/* @page { margin: 10% }
@media print {
  body * {
    visibility: hidden;
  }
  #tbrepas, #tbrepas * {
    visibility: visible;
  }
  #tbrepas {
    display:block;
  }

} */

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

#bars {
  width: 300px;
  height: 200px;
}
</style>

<!-- Page content -->
<div id="page-content" class="page-dashboard"> 
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

    <div class="block full row" id="blkcal">
        <!-- eShop Overview Title -->		
		<div class="col-lg-12">
			
			
			<div class="row">
				<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Statistiques' :'Statistics' )?></strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' des séjours' : '') ?></h2>
				<div class="col-md-4">
					<!-- Normal Form Title -->
					<div class="pull-left">
						<!-- <i class="fa fa-calendar"></i> <input  style="height: 25px;" type="text" id="date_calendar" name="date_calendar" class="input-datepicker" data-date-format="yyyy" placeholder="Date du CA"> -->
						<i class="fa fa-calendar"></i> <input  style="height: 25px;" type="text" id="annee" name="annee" value="<?php echo date('Y') ?>" class="form-control" placeholder=<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' Année du CA' : ' Year') ?>>
						<button class="btn btn-info" id="btca" <?php echo ($arrAccess["valide_stats"] == 1 ? '' : 'disabled="disabled"') ?>><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
					</div>
				</div>
				<div class="col-md-4">
					<label for="sejour" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay') ?> </label>
					<select id="sejour" name="sejour" class="form-control" placeholder=<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' Séjour' : ' Stay') ?>>
						<option value="0"></option>
						<?php foreach($sejours as $sejour){
							echo "<option value='".$sejour['id_organisateur']."'>".$sejour['name_organisateur']."</option>";
						}
						?>
					</select>
				</div>
				<div class="col-md-4">
					<div class="pull-right">
						<div style="display:flex">
							
							<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<span style="margin-top:5px">Du</span>' : '<span style="margin-top:5px">From</span>') ?>  <input  style="width: 102px;margin-left: 10px;margin-right: 10px;" type="text" class="form-control input-datepicker" value="<?php echo date('d/m/Y') ?>" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" id="calstart" name="calstart" placeholder="Date">
							<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<span style="margin-top:5px">Au</span>' : '<span style="margin-top:5px">To</span>') ?>  <input  style="width: 102px;margin-left: 10px;margin-right: 10px;" type="text" class="form-control input-datepicker" value="<?php echo date('d/m/Y') ?>" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" id="calend" name="calend" placeholder="Date">
						</div>
						<button class="btn btn-info" id="btrepas" <?php echo ($arrAccess["valide_repas"] == 1 ? '' : 'disabled="disabled"') ?>><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
					</div>
				</div>
			</div>
			<div class="">
				<div class="row">
					<div class="col-md-6">	
						<figure class="highcharts-figure">
							<div id="container"></div>
							<p class="highcharts-description">
								
							</p>
						</figure>
					</div>
					<div class="col-md-3">	
						
						<figure class="highcharts-figure">
							<div id="container-pie"></div>
							<p class="highcharts-description">
								
							</p>
						</figure>
					</div>
					<div class="col-md-3" id="tbrepas" style="margin-top: 100px;">	
						
					</div>
					<!-- <div class="col-md-6">	
						<canvas id="my_Chart"></canvas>
					</div> -->
				</div>
				<!-- <div id="calendar"></div> -->
				<div class="row">
					<div class="col-md-6">
						<canvas id="my_Chart_2"></canvas>
					</div>
					<div class="col-md-6">
						<canvas id="my_Chart_3"></canvas>
					</div>
				</div>
            </div>
		</div>		
    </div>
	
	
</div>
		

<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="/assets/js/plugins/chart.js/chart.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@1.0.0"></script> -->

<script>
	$(document).ready(function(){

		setTimeout(() => {
			initIndex()	
		}, 1000);

		function initIndex(){
			$('.highcharts-credits').html('')
			$('#btca').click()
		}

		$(document).on('click','#btimprepas', function(){

			
			var printContents = document.getElementById('tbrepas').innerHTML;    
			var originalContents = document.body.innerHTML;      
			
			document.body.innerHTML = printContents;     
			window.print(); 
			setTimeout(() => {
				window.location.reload(true);  
			}, 1200);    
			    
			// // document.body.innerHTML = originalContents;
			
		})

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


		/* *********** PIE ************ */
		var pie = Highcharts.chart('container-pie', {
			chart: {
				type: 'pie',
				options3d: {
					enabled: true,
					alpha: 45,
					beta: 0
				}
			},
			title: {
				text: '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Répartition des repas" : "Distribution of meals") ?>',
				align: 'left'
			},
			subtitle: {
				text: '',
				align: 'left'
			},
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					depth: 35,
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Share',
				data: [
					// ['Samsung', 23],
					// ['Apple', 18],
					// {
					// 	name: 'Xiaomi',
					// 	y: 12,
					// 	sliced: true,
					// 	selected: true
					// },
					// ['Oppo*', 9],
					// ['Vivo', 8],
					// ['Others', 30]
				]
			}]
		});

		/* *********** PIE ************ */

		// Create the chart
		var hChart = Highcharts.chart('container', {
			chart: {
				type: 'column',
				options3d: {
					enabled: true,
					alpha: 10,
					beta: 25,
					depth: 70
				},
				backgroundColor: '#ffeabd',
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
        
	
		// Draw default chart with page load
		// var ctx = document.getElementById('my_Chart').getContext('2d');
		// var myChart = new Chart(ctx, {
		// 	type: 'bar',    // Define chart type
		// 	data: []    // Chart data
		// });
		var ctx2 = document.getElementById('my_Chart_2').getContext('2d');
		var myChart2 = new Chart(ctx2, {
			type: 'bar',    // Define chart type
			data: [],
			options:{
				chartArea: {
					backgroundColor: '#ffeabd'
				}
			}
		});
		var ctx3 = document.getElementById('my_Chart_3').getContext('2d');
		var myChart3 = new Chart(ctx3, {
			type: 'bar',    // Define chart type
			data: [],
			options:{
				chartArea: {
					backgroundColor: '#ffeabd'
				}
			}
		});

		// Draw chart with Ajax request
		$('#btca').click(function(){
			
			HoldOn.open();
			$.post('appajax.php', {
				action: 'stats-init', 
				dt:$('#annee').val(), 
				calstart:$('#calstart').val(),
				calend:$('#calend').val(),
				sejour:$('#sejour').val()}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						$('#tbrepas').html(resp.html);

						let cat = []
                        
                        $.each(JSON.parse(resp.cat), function(i, d) {
                           cat.push(d.name)
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
						
						console.log(JSON.parse(resp.repas))
						pie.series[0].setData(JSON.parse(resp.repas))
						
						// var ctx = document.getElementById('my_Chart').getContext('2d');
						// Delete previous chart
						// myChart.destroy();
						myChart2.destroy();
						myChart3.destroy();
						let colors = '';
						// let lab = [];
						// let datas = [];
						// lab = resp.data.map(function(idx){
						// 	return idx.label
						// })
						// datas = resp.data.map(function(idx){
						// 	return idx.data
						// })
						
						let lab2 = [];
						let datas2 = [];
						lab2 = resp.dataAnnule.map(function(idx){
							return idx.label
						})
						datas2 = resp.dataAnnule.map(function(idx){
							return idx.data
						})
						
						let lab3 = [];
						let datas3 = [];
						lab3 = resp.dataFreq.map(function(idx){
							return idx.label
						})
						datas3 = resp.dataFreq		.map(function(idx){
							return idx.data
						})
						
						
						
						// myData = {
						// 	labels: lab,
						// 	datasets: [{
						// 		label: '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Chiffre d\'affaire annuel" : "Annual sales") ?>',
                        //         backgroundColor: ['rgba(255,26,104,0.2)', 'rgba(54,162,235,0.2)', 'rgba(255,206,86,0.2)', 'rgba(75,192,192,0.2)', 'rgba(153,102,255,0.2)', 'rgba(255,159,64,0.2)', 'rgba(0,0,0,0.2)',],
                        //         borderColor: ['rgba(255,26,104,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)', 'rgba(153,102,255,1)', 'rgba(255,159,64,1)', 'rgba(0,0,0,1)',],
                        //         hoverBackgroundColor: '#9fc4cc',
                        //         hoverBorderColor: '#9e6060',
                        //         data: datas,
						// 	}],
						// 	borderWidth: 1
						// };
						
						myData2 = {
							labels: lab2,
							datasets: [{
								label: '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Annulation(s)" : "Cancellation(s)") ?>',
                                backgroundColor: ['rgba(255,26,104,0.2)', 'rgba(54,162,235,0.2)', 'rgba(255,206,86,0.2)', 'rgba(75,192,192,0.2)', 'rgba(153,102,255,0.2)', 'rgba(255,159,64,0.2)', 'rgba(0,0,0,0.2)',],
                                borderColor: ['rgba(255,26,104,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)', 'rgba(153,102,255,1)', 'rgba(255,159,64,1)', 'rgba(0,0,0,1)',],
                                hoverBackgroundColor: '#9fc4cc',
                                hoverBorderColor: '#9e6060',
                                data: datas2,
							}],
							borderWidth: 1
						};
						
						myData3 = {
							labels: lab3,
							datasets: [{
								label: '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Fréquences des présences" : "Frequency of attendance") ?>',
                                backgroundColor: ['rgba(255,26,104,0.2)', 'rgba(54,162,235,0.2)', 'rgba(255,206,86,0.2)', 'rgba(75,192,192,0.2)', 'rgba(153,102,255,0.2)', 'rgba(255,159,64,0.2)', 'rgba(0,0,0,0.2)',],
                                borderColor: ['rgba(255,26,104,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)', 'rgba(153,102,255,1)', 'rgba(255,159,64,1)', 'rgba(0,0,0,1)',],
                                hoverBackgroundColor: '#9fc4cc',
                                hoverBorderColor: '#9e6060',
                                data: datas3,
							}],
							borderWidth: 1
						};

						// myChart = new Chart(ctx, {
						// 	type: 'bar',    // Define chart type
						// 	data: myData   		// Chart data
						// });

						myChart2 = new Chart(ctx2, {
							type: 'bar',    // Define chart type
							data: myData2,
							options:{
								chartArea: {
									backgroundColor: '#ffeabd'
								}
							}
						});

						myChart3 = new Chart(ctx3, {
							type: 'bar',    // Define chart type
							data: myData3,
							options:{
								chartArea: {
									backgroundColor: '#ffeabd'
								}
							}
						});
					}
					else
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
					
					HoldOn.close();

				}, 'json');
		
			return false;
		});

		$('#btrepas').click(function(){
			
			HoldOn.open();
			$.post('appajax.php', {
				action: 'count-repas', 
				calstart:$('#calstart').val(),
				calend:$('#calend').val(),
				sejour:$('#sejour').val()}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						
						$('#tbrepas').html(resp.html);

						console.log(JSON.parse(resp.repas))
						pie.series[0].setData(JSON.parse(resp.repas))
						
					}
					else
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
					
					HoldOn.close();

				}, 'json');
		
			return false;
		});
/* -------------------------------------------- */

        var calfirst = true;
		var saveview = '';
		var currdvid = 0;
		var arres = [];
		<?php 
			$nextday = '';
			if (isset($_GET['dt']))
				$nextday = date('Y-m-d', $_GET['dt']);
			else {
				$w = date('w');
				$decal = $w >= 5 ? 8 - $w : 1;
				$nextday = date('Y-m-d', strtotime('+'.$decal.' days'));
			}
		?>

		$('#date_calendar').change(function(){
				$('.datepicker').hide();
				var ladate = $(this).val();
				ladate = ladate.split("/").reverse().join("-")
				if (ladate)
				{
					$('#calendar').fullCalendar( 'gotoDate', ladate );
				}	
		});	

        // displayFullCall();



		var ladate = '';							
		var calfirst = true;
		var saveview = '';
		var currdvid = 0;
		var arres = [];
		<?php 
			$nextday = '';
			if (isset($_GET['dt']))
				$nextday = date('Y-m-d', $_GET['dt']);
			else {
				$w = date('w');
				$decal = $w >= 5 ? 8 - $w : 1;
				$nextday = date('Y-m-d', strtotime('+'.$decal.' days'));
			}
		?>
		function displayFullCall(){
			$('#calendar').fullCalendar({
				schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				locale: <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'fr' : 'en') ?>,
				dayNames:['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
				/*views: {
					listWeek: {columnFormat: 'dddd', buttonText: 'Semaine'},
					month: {buttonText: 'Mois'},
					listDay: { buttonText: 'Liste jour' },
					listWeek: { buttonText: 'Liste semaine' }
				},*/
				eventStartEditable: true,
				eventDurationEditable: false,
				eventResourceEditable: true,
				now: (ladate == '' ? '<?php echo $nextday; ?>' : ladate),
				defaultView: 'month', 
				allDaySlot: false,
				eventLimit: true,
				height:'800',
				slotWidth:120,
				displayEventTime: true,
				lazyFetching: false,
				//eventOverlap:false,
				/*slotDuration:'00:10:00',*/
				/*defaultTimedEventDuration:'00:20:00',*/
				eventOverlap: true,
				droppable: true,
				minTime: '07:00:00',
				maxTime: '21:00:00',
				resourceLabelText: 'Planning',
				resourceAreaWidth:'190px',
				slotDuration:{minutes:10},
				snapDuration:{minutes:1},
				slotLabelFormat:['dddd DD MMM YYYY', 'HH:mm'],
				viewRender: function( view, element ) {			
					$('.btchent').hide();
					if (view.name == 'month')
						$('#calendar').fullCalendar('option', 'height', 800);
					else {
						$('#calendar').fullCalendar('option', 'height', 'auto');
					}
				},
				eventRender: function(event, element) {
						// console.log(element)
						element.find('div.fc-title').html(element.find('div.fc-title').text());
						element.find('span.fc-title').html(element.find('span.fc-title').text());
						element.find('.fc-list-item-title').html(element.find('.fc-list-item-title').text());

						$("body").tooltip({ selector: '[data-toggle="tooltip"]' });
						

						element.attr('href', 'javascript:void(0);');
						element.popover({
						title: event.inf,
						content: event.description,
						trigger: 'hover',
						placement: 'top',
						container: 'body'
						});
					
						// element.on('dblclick', function() {
						// 	bootbox.alert(
						// 		'Titre : '+event.title,
						// 		'Description : '+event.description,
								
						// 	);
						// });
						
						// element.on('mouseover', function() {
						// 	alert(
						// 		'Titre : '+event.title,
						// 		'Description : '+event.description,
								
						// 	);
						// })
						
					},
				
				// events:[{
				// 			"title":"Live Coding - démo",	
				// 			"start":"2022-03-31 14:00:00",
				// 			"end":"2022-03-31 16:00:00"},
				// 		],
						
				
				events:function(fstart, fend, timezone, callback) {
						
						HoldOn.open();
						
						// console.log(fstart.format(), fend.format())
						$.post('appajax.php', {action:'read-rappels', start:fstart.format(), end:fend.format(),seldate:$('#date_calendar').val()}, function(resp) {
							HoldOn.close();
							if (resp.responseAjax == "SUCCESS") {
								console.log(resp)
								callback(resp.evts);

							}
							else
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
						}, 'json');
					},
				
				// eventDrop: function(event, delta, revertFunc) {
				// 	// console.log('deltat :'+delta,'date : '+event.start.format(),event.end.format())
				// 	// if(event.end == null || event.end == undefined ){
				// 	// 	console.log('null');
				// 		// return
				// 	// }
				// 	if (!confirm("Confirmez le deplacement de l\'évènement?",event.title)) {
				// 		revertFunc();
				// 	}
				// 	else {
				// 		dateHeureInit = event.start._i.split('T')
				// 		dateInit = dateHeureInit[0].split('-')
				// 		HeureDebInit = dateHeureInit[1].split(':')
						
				// 		TmpSplit = (event.end == null || event.end == undefined ? event.start._i : event.end._i)
					
				// 		TmpHeureEndInit = TmpSplit.split('T')
				// 		HeureEndInit = TmpHeureEndInit[1].split(':')

				// 		// console.log(dateInit[2]+"/"+dateInit[1]+"/"+dateInit[0])
				// 		// console.log(HeureDebInit)
				// 		// console.log(HeureEndInit)
				// 		// return
						
				// 		$.post('appajax.php', {action:'update-plan', app:'DROP', start:event.start.format(), end:(event.end == null || event.end == undefined ? event.start.format() : event.end.format()) , debinit:event.start._i, endinit: (event.end == null || event.end == undefined ? event.start._i : event.end._i), idevt: event.id, dragDrop: true}, function(resp) {
				// 			HoldOn.close();
				// 			if (resp.responseAjax == "SUCCESS") {
				// 				event.title.replace(dateInit[2]+"/"+dateInit[1]+"/"+dateInit[0], event.start.format())
				// 				event.title.replace(HeureDebInit[0]+":"+HeureDebInit[1]+":"+HeureDebInit[2], event.start.format())
				// 				event.title.replace(HeureEndInit[0]+":"+HeureEndInit[1]+":"+HeureEndInit[2], (event.end == null || event.end == undefined ? event.start.format() : event.end.format()))

				// 				ladate = event.start.format();
				// 				// console.log(event.title)
				// 			}
				// 			else {
				// 				$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
				// 					type: 'danger',
				// 					delay: 5000,
				// 					offset: {
									// from: "top",
									// amount: 100
									// 	},
									// 	align: "center",
									// allow_dismiss: true
				// 				});
				// 				revertFunc();
				// 			}
				// 		}, 'json');
				// 	}

				// }
			});
		}

    })

</script>