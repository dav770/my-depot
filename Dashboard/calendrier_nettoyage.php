<?php include 'including/config.php'; ?>

<?php include 'including/headPage.php'; ?>


<script>	
	function imprimer_bloc(titre, objet) {
		// Définition de la zone à imprimer
		var zone = document.getElementById(objet).innerHTML;
		
		// Ouverture du popup
		var fen = window.open("", "", "height=500, width=600,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");
		
		// style du popup
		fen.document.body.style.color = '#000000';
		fen.document.body.style.backgroundColor = '#FFFFFF';
		fen.document.body.style.padding = "20px";
		
		// Ajout des données a imprimer
		fen.document.title = titre;
		fen.document.body.innerHTML += " " + zone + " ";
		
			// Impression du popup
			fen.window.print();
			
			//Fermeture du popup
			fen.window.close();
			return true;
		}
		</script>

<link rel="stylesheet" href="css/menu.css">

<!-- Page content -->
<div id="page-content" class="page-planning">
	<!-- eCommerce Dashboard Header --> 
    <div class="content-header">
		<?php include('including/mainMenu.php'); ?>
    </div>
    
    <div class="block full row" id="blkcal">
		
		<div class="col-lg-12">
			<div class="block">
				
				<div class="block-title">
					<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Calendrier' :'Planing' )?></strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' des Rappels' : ' of reminders') ?></h2>
					<div class="block-options pull-right">
						<i class="fa fa-calendar"></i> <input  style="height: 25px;" type="text" id="date_calendar" name="date_calendar" class="input-datepicker" data-date-format="dd/mm/yyyy" placeholder="Date du Calendrier">
						<!-- <a href="#" class="btn btn-primary" id="btrapp" <?php echo ($arrAccess["add_client_calendar_rappel"] == 1 ? '' : 'disabled="disabled"') ?>><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nouveau rappel' :'New reminder' )?></a> -->
					</div>
					<?php /*<div class="block-options pull-right">
						<div class="btn-group btn-group-sm">
						<?php echo str_replace('form-control', '', Tool::DropDown('id_mono_plan',Monos::getAll(),'id_mono','first_name','0','Choix Mono')) ?>
						</div>
						<div class="btn-group btn-group-sm">
						<?php echo str_replace('form-control', '', Tool::DropDown('id_groupe_plan',Groupes::getAll(),'id_groupe','name_groupe','0','Choix Groupe')) ?>
						</div>
						</div>
						
					</div>
					</div>
					<!-- END Normal Form Title -->
					<div style="padding:5px" class="display-none">
					Nb RDV : <strong id="tot_rdv">0</strong> | 
					</div>
					<div style="padding:5px" class="">
					<a href="#" onclick="javascript:imprimer_bloc('titre', 'calendar');">Cliquez ici pour imprimer la zone</a>
					<a href="#" class="btn btn-sm btn-success" id="btaddplan" style="margin-right:10px;border-radius:3px;margin-bottom:15px" title="Ajout planing" data-toggle="tooltip"><i class="fa fa-calendar"></i> Ajouter une entrée planing</a>
					</div> */?>
				<div id="calendar"></div>
				
            </div>
		</div>		
    </div>
	
	<div id="modal-rdv" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		
		<div class="modal-dialog" style="width:50%;">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> Information RDV pour <div id="contact-rdv"></div> </h2>
				</div>
				
				<div class="modal-body" style="height:200px">
					<form onsubmit="return false;" class="form-bordered form-horizontal" id="formulairerdv" method="post" action="appajax.php">
						<div class="form-group">
							<div class="col-md-3">
								<label for="day_rdv" class="control-label">Date RDV</label>
								<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="day_rdv" id="day_rdv" value="">
							</div>
							<!-- <div class="col-md-3">
								<label for="day_rdv" class="control-label">Jour RDV</label>
								<select class="form-control" name="day_rdv" id="day_rdv">
									<option value="0" >Dimanche</option>
									<option value="1" >Lundi</option>
									<option value="2" >Mardi</option>
									<option value="3" >Mercredi</option>
									<option value="4" >Jeudi</option>
									<option value="5" >Vendredi</option>
									<option value="6" >Samedi</option>
								</select>
							</div> -->
							<div class="col-md-2">
								<label for="hdeb" class="control-label">Heure début RDV</label>
								<select class="form-control" name="hdeb" id="hdeb">
									<?php for($i = 0;$i<14; $i++) { 
										$h = 7;
										?>
										<option value="<?php echo $h+$i ?>:00"> <?php echo $h+$i ?>:00</option>
										<option value="<?php echo $h+$i; ?>:30"> <?php echo $h+$i ?>:30</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-2">
									<label for="hend" class="control-label">Heure fin RDV</label>
									<select class="form-control" name="hend" id="hend">
										<?php for($i = 0;$i<14; $i++) { 
											$h = 7;
											?>
										<option value="<?php echo $h+$i ?>:00"><?php echo $h+$i ?>:00</option>
										<option value="<?php echo $h+$i ?>:30"><?php echo $h+$i ?>:30</option>
										<?php } ?>
									</select>
								</div>	
								<div id="desc" class="col-md-3" style="display: grid">
									<label for="desc_rdv" class="control-label" style="vertical-align: top">Description</label>
									<textarea  class="form-control" name="desc_rdv" id="desc_rdv" ></textarea>
								</div>
							<button type="button pull-right" class="btn btn-sm btn-primary" style="margin-top:31px; margin-left:88px" id="validerdv" >Valider</button>			
						</div>
						<!-- <div class="form-group">
							<div class="col-md-12" id="calrdv"></div>
						</div> -->
						<div> 
							<input type="hidden" name="action" id="update-rappel" value="update-rappel" />
							<input type="hidden" name="idct" id="idct" value="" />
							<input type="hidden" name="idrdv" id="idrdv" value="" />
							<button href="#" class="btn btn-sm btn-default pull-right"  style="margin:10px" data-dismiss="modal">Fermer</button>
							<!-- <button class="btn btn-sm btn-primary" id="btaddrdv" type="submit">Valider</button> -->
						</div>
						
						
					</form>	
					
				</div>
				
			</div>
		</div>
	</div>
	
</div>


<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" integrity="sha512-liDnOrsa/NzR+4VyWQ3fBzsDBzal338A1VfUpQvAcdt+eL88ePCOd3n9VQpdA0Yxi4yglmLy/AmH+Lrzmn0eMQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
	$(document).ready(function(){

		$('#cli').click(function(){
			$('#id_fiche').val(0)
			$('#id_fournisseur').val(0)

			if($('#cli').is(':checked')){
				$('#selcli').show()
				$('#fourn').prop('checked', false)
				$('#commun').prop('checked', false)
				$('#selfourn').hide()
			}else{
				$('#selcli').hide()
				$('#fourn').prop('checked', false)
				$('#commun').prop('checked', false)
				$('#selfourn').hide()
			}
		})

		$('#fourn').click(function(){
			$('#id_fiche').val(0)
			$('#id_fournisseur').val(0)

			if($('#fourn').is(':checked')){
				$('#selcli').hide()
				$('#cli').prop('checked', false)
				$('#commun').prop('checked', false)
				$('#selfourn').show()
			}else{
				$('#selcli').hide()
				$('#cli').prop('checked', false)
				$('#commun').prop('checked', false)
				$('#selfourn').hide()
			}
		})

		$('#commun').click(function(){
			if($('#commun').is(':checked')){
				$('#id_fiche').val(0)
				$('#id_fournisseur').val(0)
			}
			$('#selcli').hide()
			$('#cli').prop('checked', false)
			$('#fourn').prop('checked', false)
			$('#selfourn').hide()
		})

		$('#btrapp').click(function(){
			$('#modal-global-rappel').modal()
		})

		$(document).on('change','#idfiche',function(){
			$('#id_fiche').val($('#idfiche').val())
			$('#id_fournisseur').val(0)
			console.log('cl',$('#idfiche').val(),$('#id_fiche').val() )
		})

		$(document).on('change','#idfournisseur',function(){
			$('#id_fiche').val(0)
			$('#id_fournisseur').val($('#idfournisseur').val())
			console.log('frn',$('#idfournisseur').val(),$('#id_fournisseur').val() )
		})

		$('#formulairerecallglobal').submit(function(){
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType:'json',
				success : function (resp) {	
					if (resp.responseAjax == 'SUCCESS') {
						$('#modal-global-rappel').modal('hide');
						
						$('#calendar').fullCalendar('refetchEvents');
						$('#calendar').fullCalendar( 'refetchResources');
						displayFullCall();
					}
					else
					if (resp.responseAjax == 'ERROR'){
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
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
               
					HoldOn.close();
				}
			}); 
			return false; 	
		});
		
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




		var idmono = '';
		var idgroupe = '';

		$('#id_mono_plan').change(function(){
			console.log($(this).val())
			if($(this).val() == ''){
				idmono = "";
			}
			else {
				idmono = $(this).val();
			}
			
			$('#calendar').fullCalendar('refetchEvents');
			$('#calendar').fullCalendar( 'refetchResources');
			displayFullCall();
		})

		$('#id_groupe_plan').change(function(){
			console.log($(this).val())
			if($(this).val() == ''){
				idgroupe = "";
			}
			else {
				idgroupe = $(this).val();
			}
			
			$('#calendar').fullCalendar('refetchEvents');
			$('#calendar').fullCalendar( 'refetchResources');
			displayFullCall();
		})

		$(document).on('click','.consult .modif .valideplanning .conftimerealise',function(){
			if($(this).data('ct') == 0){
				alert('Vous n\'ete pas autorisé a consulter ce contact')
				return false;
			}
		});

		
		$(document).on('click','.conftimerealise',function(){
			if($(this).data('ct') == 0){
				alert('Vous n\'ete pas autorisé a confirmer les heures réalisées sur ce rendez-vous')
				return false;
			}
			if(!confirm('confirmez la réalisation des heures du rendez-vous \n Identifiant : '+$(this).data('id')+'\n Le : '+$(this).data('date')+'\n Contact : '+$(this).data('name'))){
				return false
			}
			$.post('appajax.php', {action:'valide-heures-realised-rdv', idrdv: $(this).data('id'), idct: $(this).data('ct'), starth:$(this).data('start'), endh:$(this).data('end'), daterdv:$(this).data('date')}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						$.bootstrapGrowl('<h4>Confirmation !</h4> <p>' + resp.message + '</p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});
					}
					else {
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

		})
// 
		$(document).on('click','.modif',function(){

				
			$.post('appajax.php', 
				{
				action:'find-ct-rdv', 
				idrdv: $(this).data('id'), 
				idct: $(this).data('ct')
				}, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {

					
					$('#contact-rdv').text(resp.name)
					$('#idrdv').val(resp.idrdv)
					// console.log('lllll',resp.infRdv.date_rdv)
					$('#idct').val(resp.infRdv.id_fiche)

					// alert($(this).data('end').substr(0,5))
					var dateRdv = resp.infRdv.date_rdv.split('-');

					// console.log(dateRdv[2]+'/'+dateRdv[1]+'/'+dateRdv[0],resp.infRdv, resp.infRdv.rdv_start.substr(1,4))
					// return
					
					$('#day_rdv').val(dateRdv[2]+'/'+dateRdv[1]+'/'+dateRdv[0])

					if(resp.infRdv.dragDrop){

						var formatH = '';
						if(resp.infRdv.rdv_start.substr(3,1) == '0' || resp.infRdv.rdv_start.substr(3,1) == '3'){
							formatMinute = resp.infRdv.rdv_start.substr(3,1)
						}
						else {
							if(resp.infRdv.rdv_start.substr(3,1) > '3'){
								formatMinute = '3'
							}
							if(resp.infRdv.rdv_start.substr(3,1) < '3'){
								formatMinute = '0'
							}
						}
						formatMinute += '0'
						
						if(resp.infRdv.rdv_start.substr(0,1) == '0'){
							
							$('#hdeb').val(resp.infRdv.rdv_start.substr(1,1)+':'+formatMinute)
						}
						else {
							$('#hdeb').val(resp.infRdv.rdv_start.substr(0,2)+':'+formatMinute)
						}
						// console.log(resp.infRdv.rdv_start.substr(0,2)+':'+formatMinute)
						//
						if(resp.infRdv.rdv_end.substr(3,1) == '0' || resp.infRdv.rdv_end.substr(3,1) == '3'){
							formatMinute = resp.infRdv.rdv_end.substr(3,1)
						}
						else {
							if(resp.infRdv.rdv_end.substr(3,1) > '3'){
								formatMinute = '3'
							}
							if(resp.infRdv.rdv_end.substr(3,1) < '3'){
								formatMinute = '0'
							}
						}
						formatMinute += '0'

						if(resp.infRdv.rdv_end.substr(0,1) == '0'){
							
							$('#hend').val(resp.infRdv.rdv_end.substr(1,1)+':'+formatMinute)
						}
						else {
							$('#hend').val(resp.infRdv.rdv_end.substr(0,2)+':'+formatMinute)
						}

						

					}
					else {
						if(resp.infRdv.rdv_start.substr(0,1) == '0'){
							$('#hdeb').val(resp.infRdv.rdv_start.substr(1,4))
						}
						else {
							$('#hdeb').val(resp.infRdv.rdv_start.substr(0,5))
						}
						if(resp.infRdv.rdv_end.substr(0,1) == '0'){
							$('#hend').val(resp.infRdv.rdv_end.substr(1,4))
						}
						else {
							$('#hend').val(resp.infRdv.rdv_end.substr(0,5))
						}
					}
				
					$('#desc_rdv').val(resp.infRdv.desc_rdv)

					$('#modal-rdv').modal();
					
				}
				else {
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


		$(document).on('click','.deleterdv',function(){
		if($(this).data('ct') == 0){
			alert('Vous n\'ete pas autorisé a supprimer ce rendez-vous')
			return false;
		}
		if(!confirm('confirmez la suppression du rendez-vous \n Identifiant : '+$(this).data('id')+'\n Le : '+$(this).data('date')+'\n Contact : '+$(this).data('name'))){
			return false
		}
		$.post('appajax.php', {action:'del-rdv', idrdv: $(this).data('id'), idct: $(this).data('ct')}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						window.location.reload();
					}
					else {
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

		})

		$(document).on('click','.valideplanning',function(){
		if($(this).data('ct') == 0){
			alert('Vous n\'ete pas autorisé a valider ce rendez-vous')
			return false;
		}
		if(!confirm('confirmez la validation du rendez-vous \n Identifiant : '+$(this).data('id')+'\n Le : '+$(this).data('date')+'\n Contact : '+$(this).data('name'))){
			return false
		}
		$.post('appajax.php', {action:'valide-heures-rdv', idrdv: $(this).data('id'), idct: $(this).data('ct'), starth:$(this).data('start'), endh:$(this).data('end'), daterdv:$(this).data('date')}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						window.location.reload();
					}
					else {
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

		})


		$('#validerdv').on('click',function(){

		// console.log( $('#day_rdv').val(), 
		// 		 $('#hdeb').val(),
		// 		 $('#hend').val()
		// 		)
		// return
		if( parseFloat($('#hdeb option:selected').val()) >  parseFloat($('#hend option:selected').val())){
			alert('L\'heure de début du rendez ne peux pas etre supérieure a celle de fin');
			return false;
		}
		HoldOn.open();
		$.post('appajax.php', {action:'update-rappel',  
				day: $('#day_rdv').val(), 
				start: $('#hdeb').val(),
				end: $('#hend').val(),
				debinit: '1',
				endinit: '1',
				idevt: $('#idrdv').val(),
				desc: $('#desc_rdv').val(),
				appForm: true,
				}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						$('#modal-rdv').hide()
						
						$('#calendar').fullCalendar('refetchEvents');
						$('#calendar').fullCalendar( 'refetchResources');
						displayFullCall();
					}
					else {
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

		// 
	
		displayFullCall();



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
					// right: 'month,agendaWeek,agendaDay'
				},
				locale: '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'fr' : 'en') ?>',
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
				defaultView: 'agendaDay', //'month', 
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
				maxTime: '23:59:59',
				resourceLabelText: 'Planning',
				resourceAreaWidth:'190px',
				slotDuration:{minutes:10},
				snapDuration:{minutes:1},
				slotLabelFormat:['dddd DD MMM YYYY', 'HH:mm'],
				viewRender: function( view, element ) {			
					$('.btchent').hide();
					// if (view.name == 'month')
					if (view.name == 'day')
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
						$.post('appajax.php', {action:'read-nettoyage', start:fstart.format(), end:fend.format(),seldate:$('#date_calendar').val()}, function(resp) {
							HoldOn.close();
							if (resp.responseAjax == "SUCCESS") {
								// console.log(resp)
								callback(resp.evts);
								
							}
							else{
								// $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
								// 	type: 'danger',
								// 	delay: 5000,
								// 	offset: {
								// 	from: "top",
								// 	amount: 100
								// 		},
								// 		align: "center",
								// 	allow_dismiss: true
								// });
							}
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
	});
</script>

