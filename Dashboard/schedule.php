<?php include 'including/config.php'; ?>

<?php 
include 'including/headPage.php'; 
$sej = Setting::getOrganisateur(array('id_organisateur'=>$usrActif->cursoc));
?>
<link rel="stylesheet" href="css/menu.css">

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

	<style>
		#id_sel_filtre_chosen{
			width: 300px !important;
		}
	</style>

<!-- Page content -->
<div id="page-content" class="page-planning">
	<!-- eCommerce Dashboard Header --> 
    <div class="content-header">
		<?php include('including/mainMenu.php'); ?>
    </div>
    <!-- END eCommerce Dashboard Header -->
	
    <!-- eShop Overview Block --> 
    <div class="block full row" id="blkcal">
		<!-- eShop Overview Title -->		
		<div class="col-lg-12">
			<div class="block">
				<!-- Normal Form Title -->
                <div class="block-title">
					<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Planing des Chambres' : 'Rooms schedule') ?></strong></h2>
					<div class="block-options pull-right">
						<i class="fa fa-calendar"></i> <input  style="height: 25px;" type="text" id="date_calendar" name="date_calendar" class="input-datepicker" data-date-format="dd/mm/yyyy" placeholder="Date du Calendrier">
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
    <!-- END eShop Overview Block -->
	
	<div id="modal-plan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" >
		
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-cal"></i> Plan activité </h2>
				</div>
				<!-- END Modal Header -->
				
				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-bordered form-horizontal" id="formulaireplan" method="post" action="appajax.php">
						
					<div class="form-group">
						<label class="col-md-4 control-label">date</label>
						<div class="col-md-4">
							<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_fixed" id="date_fixed" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">Heure début</label>
						<div class="input-group bootstrap-timepicker col-md-4">
							<input type="text"  id="hour_start" name="hour_start" value="" class="form-control input-timepicker24 hour_start">
							<span class="input-group-btn">
								<a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
							</span>
						</div>	
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label">Heure fin</label>
						<div class="input-group bootstrap-timepicker col-md-4">
							<input type="text"  id="hour_end" name="hour_end" value="" class="form-control input-timepicker24 hour_end">
							<span class="input-group-btn">
								<a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
							</span>
						</div>
					</div>
					<div class="form-group" style="margin-left: 19rem;">
						<div class="col-md-3" >
							<label for="idgroupe" class="control-label">Groupe</label>
                                <?php echo Tool::DropDown('idgroupe',Groupes::getAll(),'id_groupe','name_groupe','','Choix groupe') ?>
							</div>	
                            
                        </div>
                        <div class="form-group" style="margin-left: 19rem;">
                            <div class="col-md-3" >
								<label for="activite" class="control-label">Activité</label>
                                <?php echo Tool::DropDown('id_activite',Activites::getAll(array('is_kid'=>'1')),'id_activite','name_activite','','Choix activite') ?>
							</div>	
                            <div class="col-md-6" >
								<label for="lieu" class="control-label">Lieu</label>
                                <input type="text" class="form-control" name="lieu" id="lieu" value="">
							</div>
                        </div>
                        
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">
								<!-- <input type="hidden" name="idth2" id="idth2" value="0" /> -->
								<!-- <input type="hidden" name="action" id="action" value="add-th2" /> -->
								<input type="hidden" name="idmono" id="idmono" value="0" />
								<input type="hidden" name="app" id="app" value="" />
								<input type="hidden" name="idrdv" id="idrdv" value="0" />
                                <input type="hidden" name="action" id="action" value="update-plan-groupe" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
								<button class="btn btn-sm btn-primary" id="btvalplan" type="submit">Valider</button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
    </div>
	
	
	
	<!-- Modal Planning rendez vous -->
	<div id="modal-rdv" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		
		<div class="modal-dialog" style="width:50%;">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> Information RDV pour <div id="contact-rdv"></div> </h2>
				</div>
				<!-- END Modal Header -->
				
				<!-- Modal Body -->
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
				<!-- END Modal Body -->
			</div>
		</div>
	</div>


	<div id="modal-dispo-chambre" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="width:95%;">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'liste des chambres disponibles' : 'List of available rooms') ?> <span id="dtd"></span></h2>
					<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
				</div>
				<div class="modal-body">
					<div class='form-group' style="display: flex;justify-content:center">
						<?php /*<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Filtre sur Types' : 'Filter on types') ?> &nbsp;</label> <?php echo Tool::DropDown('id_sel_filtre',Chambres::getAllType(),'id_type_chambre','name_type_chambre','id_type_chambre','', true) ?> <label>&nbsp; <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ET Capacité' : 'And Capacity') ?> 	 </label> */?>
						<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Filtre chambre sur : ' : 'Filter room on : ') ?> &nbsp;</label><label class="switch switch-primary">
							<input type="checkbox" id="chkemp" name="chkemp" value="P"><span></span>
						</label>  &nbsp;<label><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Employés ET ' : 'Staff AND ') ?> &nbsp;</label>
						&nbsp;<label class="switch switch-primary">
							<input type="checkbox" id="chktmp" name="chktmp" value="T"><span></span>
						</label>  &nbsp;<label><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Temporaire ' : 'Temporary ') ?> &nbsp;</label>
						&nbsp;
						
						<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' ET Types' : ' AND Types') ?> &nbsp;</label><?php echo Tool::DropDown('id_sel_filtre',Chambres::getAllType(),'id_type_chambre','name_type_chambre','id_type_chambre','', true) ?> <label>&nbsp; <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ET Capacité' : 'And Capacity') ?> 	 </label>
						
						<select class="form-control" id="sel_op_cap" style="width: 50px;margin-left: 15px;">
							<option value=""></option>
							<option value="=">=</option>
							<option value=">=">>=</option>
							<option value="<="><=</option>
						</select>
						<input type="text" class="form-control" value="" id="val_cap" name="val_cap" style="width: 50px;"/>
						<!-- <label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Filtre sur Types' : 'Filter on types') ?> &nbsp;</label> <?php echo Tool::DropDown('id_sel_filtre',Chambres::getAllType(),'id_type_chambre','name_type_chambre','id_type_chambre','', true) ?> <label>&nbsp; <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ET Piscine' : 'And pool') ?> 	 </label>
						<select class="form-control" id="sel_piscine_filtre" style="width: 111px;margin-left: 15px;">
							<option value="0"></option>
							<option value="1"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Privée' : 'Private') ?></option>
							<option value="2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Partagée' : 'Share') ?></option>
						</select> -->
						<button href="#" class="btn btn-sm btn-default" id="btvalidefiltre" style="margin-left: 15px;height: 35px;"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Filtrer' : 'Filter') ?></button>
						<button href="#" class="btn btn-sm btn-default" id="btsearchinf" style="margin-left: 15px;height: 35px;"><i class="fa fa-search"></i></button>
					</div>	
					<div class='form-group' style="display: flex;justify-content:center">
						<div id="clclts" style="display:none; margin-left:20px;">
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client ' : 'Customer') ?> &nbsp;</label> 
							<select class="form-control" id="sel_clts" style="width: 150px;margin-left: 15px;">
								<option value="0"></option>
							<?php $clts = Fiche::getAll();
							foreach($clts as $clt){
								echo '<option value="'.$clt['id_fiche'].'">'.$clt['last_name'].' '.$clt['first_name'].'</option>';
							}?>
							</select>
							<!-- <button href="#" class="btn btn-sm btn-default" id="btclfiche" style="margin-left: 15px;height: 35px;"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button> -->
						
						</div>
						<div id="clinf" style="display:none; margin-left:20px">
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client ' : 'Customer') ?> &nbsp;</label> 
							<select class="form-control" id="sel_clts_inf" style="width: 150px;margin-left: 15px;">
								<option value="0"></option>
							<?php $clts = Fiche::getAll();
							foreach($clts as $clt){
								echo '<option value="'.$clt['id_fiche'].'">'.$clt['last_name'].' '.$clt['first_name'].'</option>';
							}?>
							</select>
							<!-- <input type="text" id="clt_inf" name="clt_inf" class="form-control" value="" style="margin-left: 10px;width:425px; color:red" readonly> -->
							<span id="clt_inf" name="clt_inf" class="form-control" style="margin-left: 10px;width:450px;"></span>
							<button href="#" class="btn btn-sm btn-default" id="btclinf" style="margin-left: 15px;height: 35px;"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
						<div id="cltmp" style="display:none; margin-left:20px">
							<label class="clntp"> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom ' : 'Name ') ?> &nbsp;</label> 
							<input type="text" id="name_tmp_emp" name="name_tmp_emp" class="form-control clntp" value="" required>
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date ' : 'Date ') ?> &nbsp;</label> 
							<input type="text" id="date_deb_sej" name="date_deb_sej" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($sej->date_start_organisateur))?>" required>
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Au ' : 'To ') ?> &nbsp;</label> 
							<input type="text" id="date_end_sej" name="date_end_sej" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($sej->date_end_organisateur))?>" required>
							<button href="#" class="btn btn-sm btn-default" id="btclemp" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							<button href="#" class="btn btn-sm btn-default" id="btcltmp" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							<button href="#" class="btn btn-sm btn-default" id="btcldel" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							<button href="#" class="btn btn-sm btn-default" id="btclfiche" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						
						</div>
					</div>
					<div class="form-group">
						<div id="chdispoentete" style=""></div>
						<div id="chdispo" style="overflow: auto;height: 600px"></div>
					</div>
					
					<div class="form-group form-actions" style="margin-bottom: 65px;margin-top: 25px;">
						<div class="col-md-12 text-center" style="margin-bottom:35px">
							<input type="hidden" name="resch[]" id="resch" value="" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<?php if((int)$curusr->lnk_reglement > 0){ ?>
								<button class="btn btn-sm btn-primary" id="btokch" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							<?php } ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
</div>
<!-- END Page Content -->

<?php include 'including/footPage.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="jscript/helpers/excanvas.min.js"></script><![endif]-->

<script src="jscript/jsplug.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js"></script>
<!-- Load and execute javascript code used only in this page -->
<script>
	$(document).ready(function() {

		
		$('#date_deb_sej').datepicker( "setDate", "<?php echo date('d/m/Y', strtotime($sej->date_start_organisateur)) ?>" );
		$('#date_end_sej').datepicker( "setDate", "<?php echo date('d/m/Y', strtotime($sej->date_end_organisateur)) ?>" );

		var isModalOpen = false;
		var arrTmp = [];
		var numChLine = 0;
		var numChLineBkg = 0;
		var searchInf = false;
		var selclear = '';
		var colorElement = '';

		
		$(document).on('change', '.seltypech', function(){
			
			numChLine = $(this).parent().attr('id').split('-')
			numChLineBkg = $(this).parent().attr('id')
			console.log('hh',selclear, $(this).attr('id'), '#'+numChLineBkg)
			
			if(selclear != $(this).attr('id') && selclear != ''){
				if(colorElement != ''){
					console.log('444',$('.seltypech '+selclear.split('-')[0].trim()), colorElement)
					document.getElementById(selclear).parentElement.style.backgroundColor = colorElement 
					// $('#'+selclear).parent().css("background-color", "blue");
					colorElement = $(this).parent().parent().css("background-color");
					console.log('333',colorElement)
				}				

				selclear = selclear.split('-')
				$('.'+selclear[0].trim()).val('')
				
				selclear = $(this).attr('id')
				
				$(this).parent().css("background-color", "black")
			}else{
				if(colorElement == ''){
					colorElement = $(this).parent().parent().css("background-color");
				}
				console.log('555',selclear, $(this).attr('id'), $('#'+selclear), colorElement)
				selclear = $(this).attr('id')
				
				$(this).parent().css("background-color", "black")
				// $('#'+selclear).parent().css("background-color", "")
				// $(this).parent().css("background-color", "yellow")
			}

			console.log('ff',numChLine)
			if($(this).val() == 'T'){
				$('#btclfiche').css('display','none');
				$('#btcldel').css('display','none');
				$('#btclemp').css('display','none');
				
				$('#clinf').css('display','none');
				$('#clclts').css('display','none');
				
				$('#cltmp').css('display','flex');
				$('#btcltmp').css('display','block');
				$('.clntp').css('display','block');
				
			}
			
			if($(this).val() == 'C'){
				$('#btcltmp').css('display','none');
				$('#btcldel').css('display','none');
				$('#btclemp').css('display','none');
				
				$('.clntp').css('display','none');

				$('#clinf').css('display','none');

				$('#clclts').css('display','flex');
				$('#cltmp').css('display','flex');
				$('#btclfiche').css('display','block');
				
			}
			
			if($(this).val() == 'P'){
				$('#btclfiche').css('display','none');
				$('#btcldel').css('display','none');
				$('#btcltmp').css('display','none');

				$('#clinf').css('display','none');
				$('#clclts').css('display','none');

				$('#cltmp').css('display','flex');
				$('.clntp').css('display','block');
				$('#btclemp').css('display','block');
				
			}
			
			if($(this).val() == 'A'){
				$('#btcltmp').css('display','none');
				$('#btclfiche').css('display','none');
				$('#btclemp').css('display','none');

				$('#clinf').css('display','none');
				$('#clclts').css('display','none');
				
				$('#cltmp').css('display','flex');
				$('#btcldel').css('display','block');
				$('.clntp').css('display','none');
				
			}
			
			if($(this).val() == ''){
				$('#btcltmp').css('display','none');
				$('#btclfiche').css('display','none');
				$('#btclemp').css('display','none');
				$('#btcldel').css('display','none');

				$('#clinf').css('display','none');
				$('#clclts').css('display','none');
				
				$('#cltmp').css('display','none');
				$('.clntp').css('display','none');
				
			}

			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
			
		})

		$(document).on('click','#btsearchinf',function(){
			$('#btcltmp').css('display','none');
			$('#btcldel').css('display','none');

			if(searchInf){
				$('#clinf').css('display','none');
				searchInf = false;
			}else{
				$('#clinf').css('display','flex');
				searchInf = true;
			}

			$('#clclts').css('display','none');
			$('#cltmp').css('display','none');
			$('#btclfiche').css('display','none');
		})

		$(document).on('click','#btclinf',function(){
			HoldOn.open();

			$.post('appajax.php', {
					action: 'search-inf',
					idfiche:$('#sel_clts_inf').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					let resaff = '<b>'+resp.res+'</b>' + '<span style = "color:red">'+resp.res2.toUpperCase()+'</span>';
					$("#clt_inf").html(resaff);
					arrTmp = [];
					numChLine = 0;
					// $('#clinf').css('display','none');
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
		})

		$(document).on('click','.clemp',function(){
			$('#btclfiche').css('display','none');
			$('#btcldel').css('display','none');
			$('#btcltmp').css('display','none');

			$('#clinf').css('display','none');
			$('#clclts').css('display','none');

			$('#cltmp').css('display','flex');
			$('.clntp').css('display','block');
			$('#btclemp').css('display','block');

			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})


		$(document).on('click','#btclemp',function(){
			HoldOn.open();

			let nameTmpEmp = $('#name_tmp_emp').val();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'EMP',
					nameTmpEmp:nameTmpEmp,
					numch:numChLine[0].trim(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btclemp').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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
		})

		$(document).on('click','.clfiche',function(){
			$('#btcltmp').css('display','none');
			$('#btcldel').css('display','none');
			$('#btclemp').css('display','none');
			
			$('.clntp').css('display','none');

			$('#clinf').css('display','none');

			$('#clclts').css('display','flex');
			$('#cltmp').css('display','flex');
			$('#btclfiche').css('display','block');
			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})

		$(document).on('click','#btclfiche',function(){
			HoldOn.open();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'FICHE',
					numch:numChLine[0].trim(),
					idfiche:$('#sel_clts').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					arrTmp = [];
					numChLine = 0;
					$('#clclts').css('display','none');
					$('#cltmp').css('display','none');
					$('#btclfiche').css('display','none');
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
		})

		$(document).on('click','.cltmp',function(){
			$('#btclfiche').css('display','none');
			$('#btcldel').css('display','none');
			$('#btclemp').css('display','none');
			
			$('#clinf').css('display','none');
			$('#clclts').css('display','none');
			
			$('#cltmp').css('display','flex');
			$('#btcltmp').css('display','block');
			$('.clntp').css('display','block');
			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})


		$(document).on('click','#btcltmp',function(){
			HoldOn.open();

			let nameTmpEmp = $('#name_tmp_emp').val();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'TMP',
					nameTmpEmp:nameTmpEmp,
					numch:numChLine[0].trim(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btcltmp').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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
		})

		$(document).on('click','.cldel',function(){
			$('#btcltmp').css('display','none');
			$('#btclfiche').css('display','none');
			$('#btclemp').css('display','none');

			$('#clinf').css('display','none');
			$('#clclts').css('display','none');
			
			$('#cltmp').css('display','flex');
			$('#btcldel').css('display','block');
			$('.clntp').css('display','none');
			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})

		$(document).on('click','#btcldel',function(){
			if((!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression des réservations de cette chambre ?' : 'Deletion of the registration for this room ?')?>"))){
				return false;
			}

			HoldOn.open();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'DEL',
					numch:numChLine[0].trim(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					if(resp.countidcli == '1'){
						HoldOn.close();
						if(confirm('Cette chambre est actuellement attribuée au client ID : '+resp.infdelcli+'\n\rConfirmez la suppression pour toute sa periode ?')){
							forwardDel(resp.delidcli);
							arrTmp = [];
						}
						return false;
					}
					if(parseInt(resp.countidcli) > 1){
						HoldOn.close();
						alert('Cette chambre est actuellement attribuée à plusieurs clients sur la pèriode sélectionnée\n\rSeul la suppression des chambres du personnel et temporaire seront effectuée\n\rPour supprimer la chambre du client vous devrez passer par sa fiche pour éviter toute erreur de date')
						arrTmp = [];	
						return false;
					}

					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btcldel').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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
		})

		function forwardDel(idcli=0){
			HoldOn.open();
			arrTmp = [];

			let arrId= [];
			arrId.push(idcli)
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'DEL',
					numch:numChLine[0].trim(),
					forceDel:'1',
					lstId:arrId
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					
					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btcldel').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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
		}

		$(document).on('click','.idbtdispoch',function(){
			let start = $(this).attr('data-start').split('/')
			let end = $(this).attr('data-end').split('/')

			console.log($(this).attr('data-start'),$(this).attr('data-end'), start, end)
			HoldOn.open();
			$.post('appajax.php', {
					action: 'search-chambres-jours', 
					dtstart:start[2]+'-'+start[1]+'-'+start[0], 
					dtend:end[2]+'-'+end[1]+'-'+end[0], 
					timestart:'10:00', 
					timeend:'16:00', 
					schedule:'1',
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					// $('#dtd').text($('#date_start').val()+' au '+$('#date_end').val())
					
					$('#dtstart').val(start[2]+'-'+start[1]+'-'+start[0])
					$('#dtend').val(end[2]+'-'+end[1]+'-'+end[0])

					$("#chdispoentete").html(resp.entete)
					$("#chdispo").html(resp.res)
					$('.chosen-search-input.default').val("");
					// $('.chosen-search-input').attr("placeholder",'Type de chambre');
					$('#modal-dispo-chambre').modal()
					isModalOpen = true;
					$(".select-chosen").chosen();
					$("#id_sel_filtre_chosen").css('width','600px');
					$("#id_sel_filtre_chosen").css('margin-bottom','10px');
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
		})

		
		$(document).on('change','#sel_op_cap', function(){
			if($(this).val() == ''){
				$('#val_cap').val('')
			}
		})

		$(document).on('click','#btvalidefiltre', function(){
			HoldOn.open();
			let dst = $('#dtstart').val()
			let dend = $('#dtend').val()
			arrTmp.push(dst);
			arrTmp.push(dend);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					idflts:$('#id_sel_filtre').val(),
					idfltsopcap: $('#sel_op_cap').val(),
					valcap: $('#val_cap').val(),
					chktmp: ($('#chktmp').is(':checked') ? 1 : 0),
					chkemp: ($('#chkemp').is(':checked') ? 1 : 0),
					app:'SEARCH',
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					// $('#cltmp').css('display','none');
					// $('#btcltmp').css('display','none');
					// $('.clntp').css('display','none');
					arrTmp = [];
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
		})
		
		// $(document).on('click','#btvalidefiltre', function(){
		// 	HoldOn.open();
		// 	$.post('appajax.php', {
		// 			action: 'search-chambres-jours', 
		// 			dtstart:$('#dtstart').val(), 
		// 			dtend:$('#dtend').val(), 
		// 			timestart:'12:00', 
		// 			timeend:'16:00', 
		// 			idflts:$('#id_sel_filtre').val(),
		// 			idfltspiscine: $('#sel_piscine_filtre').val(),
		// 			idfltsopcap: $('#sel_op_cap').val(),
		// 			valcap: $('#val_cap').val(),
		// 			schedule:'1',
		// 		}, function(resp) {

		// 		if (resp.responseAjax == 'SUCCESS') {
		// 			$("#chdispoentete").html(resp.entete)
		// 			$("#chdispo").html(resp.res)
		// 		}
		// 		else
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
				
		// 		HoldOn.close();

		// 	}, 'json');
		
		// 	return false;
		// })

		// $('.printBtn').on('click', function () {
		// 	html2canvas(document.querySelector("#calendar")).then(canvas => {
		// 		document.getElementById('shot').appendChild(canvas)
		// 		$('#modal-shot').modal()
		// 	});
        // });

		$('#btaddplan').click(function(){
			console.log('hh')
			// $('#app').val('UPDT')
			$('#modal-plan').modal();
		})

		$('#formulaireplan').submit(function() {
			
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType: 'json',
				success: function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
					
						// $('#list_activites').trigger("reloadGrid",[{current:true}]);
                        // window.location.reload();
						idmono = '0';
						idgroupe = $('#idgroupe').val();
						$("#calendar").fullCalendar('render');

					} else
					if (resp.responseAjax == 'ERROR')
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
					
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
               
				}

			});
			
			$('#modal-plan').modal('hide');
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

		$('#date_calendar').change(function() 
			{
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
				defaultView: 'month', 
				allDaySlot: false,
				eventLimit: true,
				height:'600',
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
						$('#calendar').fullCalendar('option', 'height', 600);
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
						$.post('appajax.php', {action:'read-count-chambre', start:fstart.format(), end:fend.format(),seldate:$('#date_calendar').val()}, function(resp) {
							HoldOn.close();
							if (resp.responseAjax == "SUCCESS") {
								console.log(resp)
								callback(resp.evts);
								// $('.fc-time').text('')
								$('.fc-time').html('')
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
				// 			from: "top",
				// 			amount: 100
				// 				},
				// 				align: "center",
				// 			allow_dismiss: true
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
