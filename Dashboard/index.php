<?php 
include 'including/config.php'; 
// echo(print_r($arrAccess));
?>

<?php 
	include 'including/headPage.php'; 
	$sejours = Setting::getAllorganisateurs();

    $soc = Soc::findOne(array('is_soc'=>'1'));
    $mtypes = ModelMail::find("");
	$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));
?>


<link rel="stylesheet" href="css/menu.css">

<style>
    .back-image {
        background-image: url("/img/fond-menu-2.jpg");
        /* background-color: #cccccc; */
        height: 500px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        /* opacity: 0.6; */
    }
</style>

<div id="page-content" class="back-image page-dashboard"> 
   
    <div class="" id="blkcal">
        <!-- eShop Overview Title -->		
		<div class="col-lg-12">
            <div class="row" >
                <?php /*<div class="row">*/?>
                <div class="block-full">
                    <div class="" style="justify-content:center;display: flex;">
                    
                        <ul class="wrapper text-center" style="margin-top: 100px;margin-bottom: 100px;">
                        <?php if($arrAccess['visu_stats'] == 1){?>
                            <li style="margin-right: 50px;" class="icon stat clstat <?php echo strstr($template['active_page'], 'index') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Statistiques" : "Statistics") ?></span>
                            <span class="clstat"><a href="stats.php"><i class="fa fa-bar-chart clstat"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_calendar_rappel'] == 1){?>
                            <li style="margin-right: 50px;" class="icon calendar clcalendar <?php echo strstr($template['active_page'], '-rappels') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Planing des rappels" : "Schedule of callbacks") ?></span>
                            <span class="clcalendar"><a href="calendar-rappels.php"><i class="fa fa-calendar-check-o clcalendar"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_table'] == 1){?>
                            <li style="margin-right: 50px;" class="icon table cltable <?php echo strstr($template['active_page'], 'tables') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Gestion des tables" : "Tables managment") ?></span>
                            <span class="cltable"><a href="tables-plan.php"><i class="fa fa-table cltable"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['create_client'] == 1){?>
                            <li style="margin-right: 50px;" class="icon clnew clclnew <?php echo strstr($template['active_page'], 'contacts') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "New Clients" : "New customers") ?></span>
                            <span class="clclnew"><a href="#" class="btnewcl" ><i class="fa fa-address-card clclnew"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_client'] == 1){?>
                            <li style="margin-right: 50px;" class="icon clients clclients <?php echo strstr($template['active_page'], 'contacts') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Clients" : "Customers") ?></span>
                            <span class="clclients"><a href="fiches.php"><i class="gi gi-parents clclients"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_planning_ch'] == 1){?>
                            <li style="margin-right: 50px;" class="icon calch clcalch <?php echo strstr($template['active_page'], 'planning') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Planing des chambres" : "Schedule of rooms") ?></span>
                            <span class="clcalch"><a href="schedule.php"><i class="gi gi-calendar clcalch"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_commandes'] == 0){?>
                            <li style="margin-right: 50px;" class="icon cmds clcmds <?php echo strstr($template['active_page'], 'commandes') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Commndes fournisseurs" : "Orders") ?></span>
                            <span class="clcmds"><a href="commandes.php"><i class="fa fa-file clcmds"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['send_mail_client'] == 1){?>
                            <li style="margin-right: 50px;" class="icon list cllist <?php echo strstr($template['active_page'], 'listing') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Listing" : "Listing") ?></span>
                            <span class="cllist"><a href="listing.php"><i class="fa fa-copy cllist"></i> </a></span>
                            </li>
                        <?php }?>
                        </ul>
                        
                        </div>
                        
                        </div>
                    </div>
                </div>
        <div class="col-lg-12">
            <div class="row" >
                <?php /*<div class="row">*/?>
                <div class="block-full">
                    <div class="" style="justify-content:center;display: flex;">
                    
                        <ul class="wrapper text-center">

                        <?php if($arrAccess['visu_mail_inbox'] == 1){?>
                            <li style="margin-right: 50px;" class="icon inbox clinbox <?php echo strstr($template['active_page'], 'call-') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Boite de réception" : "Inbox") ?></span>
                            <!-- <span class="clinbox"><a href="call-attach-imap.php"><i class="fa fa-envelope-open-o clinbox"></i> </a></span> -->
                            <span class="clinbox"><a href="inbox-imap.php"><i class="fa fa-envelope-open-o clinbox"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_mail_outbox'] == 1){?>
                            <li style="margin-right: 50px;" class="icon outbox cloutbox <?php echo strstr($template['active_page'], 'outbox') ? ' active' : ''; ?>">
                            <span class="tooltip active"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Messages envoyés" : "Outbox") ?></span>
                            <span class="cloutbox"><a href="outbox.php"><i class="fa fa-send cloutbox"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_infos_stripe'] == 1){?>
                            <li style="margin-right: 50px;" class="icon stripe clstripe <?php echo strstr($template['active_page'], 'reglements') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Suivi des paiments" : "Payments") ?></span>
                            <span class="clstripe"><a href="reglements.php"><i class="fa fa-money clstripe"></i> </a></span>
                            </li>
                        <?php }?> 
                        <?php if($arrAccess['edit_clean_room'] == 1){?>
                            <li style="margin-right: 50px;" class="icon clean clclean <?php echo strstr($template['active_page'], 'Nettoyage') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nettoyage chambres" : "Cleaning rooms") ?></span>
                            <span class="clclean"><a href="#" class="btclean"><i class="fa fa-bath clclean"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['extra'] == 1){?>
                            <li style="margin-right: 50px;" class="icon extra clextra <?php echo strstr($template['active_page'], 'extra') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Extra activité" : "Extra activity") ?></span>
                            <span class="clextra"><a href="extra.php" class="btextra"><i class="fa fa-tag clextra"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_enfants'] == 1){?>
                            <li style="margin-right: 50px;" class="icon enf clenf <?php echo strstr($template['active_page'], 'enfants') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Enfants" : "Childrens") ?></span>
                            <span class="clenf"><a href="enfants.php"><i class="fa fa-child clenf"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_monos'] == 1){?>
                            <li style="margin-right: 50px;" class="icon mono clmono <?php echo strstr($template['active_page'], 'monos') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Monos" : "Instructors") ?></span>
                            <span class="clmono"><a href="monos.php"><i class="fa fa-users clmono"></i> </a></span>
                            </li>
                        <?php }?>
                        <?php if($arrAccess['visu_bar'] == 1){?>
                            <li style="margin-right: 50px;" class="icon bar clbar <?php echo strstr($template['active_page'], 'bar') ? ' active' : ''; ?>">
                            <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Bar" : "Bar") ?></span>
                            <span class ="clbar"><a href="bar.php"><i class="fa fa-coffee clbar"></i> </a></span>
                        	</li>
                        <?php }?>
                        
                        </ul>
                        
                    </div>
                    
                    </div>
                </div>
            </div>
		</div>		
        <div class="col-lg-12">
            <div class="row" >
                <?php /*<div class="row">*/?>
                <div class="block-full">
                    <div class="" style="justify-content:center;display: flex;">
                    
                        <ul class="wrapper text-center">
							<?php if($arrAccess['visu_settings'] == 1){?>
								<li style="margin-right: 50px;" class="icon set clset <?php echo strstr($template['active_page'], 'setting') ? ' active' : ''; ?>">
								<span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Parametrages" : "Settings") ?></span>
								<span class ="clset"><a href="settings.php"><i class="fa fa-gear clset"></i> </a></span>
								</li>
							<?php }?>                        
                        </ul>                        
                    </div>
                </div>
            </div>
		</div>		
    </div>
	
	<div id="modal-new-fiche" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="gi gi-calendar"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix de création' : 'Choice of creation') ?></h2>
				</div>
				
				<div class="modal-body clhgtbody" style="height: 400px;">
					<div class="form-group form-actions">
						<div class="col-md-12" style="margin-bottom:10px;text-align: center;">
							<a href="#" id="bttapeinf" class="btn btn-primary">Saisie manuelle</a><br>
							<hr>
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="form-group" style="text-align:center" >
							
								<label for="lg" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Langage' : 'Language') ?></label>
								<div class="col-md-3">
									<select class="form-control" name="lg" id="lg">
										<option value="FR" <?php echo $curusr && $curusr->lg == 'FR' ? 'selected="selected"' : ''; ?>>FR</option>
										<option value="ENG" <?php echo $curusr && $curusr->lg == 'ENG' ? 'selected="selected"' : ''; ?>>ENG</option>
									</select>
									<hr>
								</div>							
								<label for="signinsc" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Signature inscription' : 'Signing registration') ?></label>
								<div>
									<label class="switch switch-primary">
										<input type="checkbox" id="signinsc" name="signinsc"><span></span>
									</label>
								</div>
							
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-12" style="/*display:flex;*/margin-bottom:10px">
							<div class="col-md-7">
								<span style="margin-left:15px;">Email : </span><input type="text" class="form-control" id="lnk-mail" value="" style="margin-left:10px; margin-right:10px;width:200px"></input>
							</div>
							<div class="col-md-5" style="margin-top:18px">
								<a href="#" id="<?php echo $infgene->is_auto_mail > 0 ? 'btsendinf' : 'btsendinfmail' ?>" class="btn btn-warning"><?php echo $infgene->is_auto_mail > 0 ? 'Envoi lien automatique' : 'Affichez mail lien'?></a>
							</div>
						</div>
						<div class="col-md-12" style="text-align:center">
							<button href="#" class="btn btn-sm btn-danger" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


    <div id="modal-msg-mail-i" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail' : 'Send email') ?></h2>
				</div>
				
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsginsc" method="post" action="appajax.php">
						
						<div class="form-group">
							<div id="" class="form-group">
								<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire(s)' : 'Recipient(s)') ?></label>
								<div class="col-md-8">
									<input type="text" class="form-control"  value="" id="destemailinsc" readonly/>
								</div>
							</div>
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmailinsc" placeholder="sujet" />
									<div class="input-group-btn" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du modèle' : 'Choice of model') ?>">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcontinsc"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
										<?php foreach ($mtypes as $mtype) {
												if($mtype['type_mail'] == '5'){?>
													<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" class="modeltype"><?php echo $mtype['name_mailtype']; ?></a></li>
												<?php } 
											} ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
						<textarea id="msgcontentinsc" name="msgcontentinsc" class="ckeditor">
							
						</textarea>
						<div id="attacheddocsinsc" class="block">
						</div>
						<div id="blksenddocintinsc">
							<div id="lstdocscttinsc" class="col-md-12"></div>
						</div>

						<div id="txtmailpresinsc" class="display-none">							
						</div>
						<input type="file" name="fileaddinsc[]" id="fileaddinsc"  style="display:none;" multiple>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter pièces jointes' : 'Add attachments') ?>" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown" style="margin-right:10px"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddocinsc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocininsc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
								</div>                    
								<button href="#" class="btn btn-sm btn-danger pull-right" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Retirer pièces jointes' : 'remove attachments') ?>" data-toggle="tooltip" id="btdeldocinsc"><i class="fa fa-minus"></i></button>
								<input type="hidden" name="id_mailtypeinsc" id="id_mailtypeinsc" value="0" />
								<input type="hidden" name="lginsc" id="lginsc" value="FR" />
								<input type="hidden" name="attachclrinsc" id="attachclrinsc" value="0" />
								<input type="hidden" name="typeMailinsc" id="typeMailinsc" value="0" />
								<input type="hidden" name="ficheidinsc" id="ficheidinsc" value="0" />
								<input type="hidden" name="idMailTypeinsc" id="idMailTypeinsc" value="0" />
								<input type="hidden" name="signinsc2" id="signinsc2" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btmailsendinginsc" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				
			</div>
		</div>
	</div>

    <div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="text-right display-none" id="blksigndoc" style="padding:15px 15px 0;">
					<a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi du document en Signature électronique' : 'Send document in electonic signature') ?></a>
				</div>
				<div class="modal-body" style="height: 100vh">
					<iframe src="" style="width:100%;height:100%;"></iframe>
					<input type="hidden" id="view_id_docs" />
				</div>
			</div>
		</div>
	</div>

    <div id="modal-menage" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		
			

			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-document"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Feuille ménage' : 'Clear sheet') ?></h2>
				</div>
				<div class="modal-body" style="height: 25vh">
					<div class="form-group" style="display: flex;justify-content: center;">
						<label for="date_m1" class="col-md-2 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date début' : 'Date start') ?></label>
						<div class="col-md-2">
							<input type="text" id="date_m1" name="date_m1" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="" required>
						</div>
						<label for="date_m2" class="col-md-2 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date fin' : 'Date end') ?></label>
						<div class="col-md-2">
							<input type="text" id="date_m2" name="date_m2" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="" required>
						</div>
					</div>
					
					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-top:15px">
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<button class="btn btn-sm btn-primary" id="btmenage" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
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


<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>

<script>
    $(document).ready(function(){
		console.log($.fn.jquery, '---', $.ui.version)

		if(window.matchMedia("(max-width: 600px)").matches){
			// La fenêtre a moins de 600 pixels de large
			// alert("Ceci est un appareil mobile.");
			$('.clhgtbody').css({'height':'435px'});
		} else{
			// @media (min-width: 900px) and (max-width: 911px) and (orientation: portrait) {}
			// La fenêtre fait au moins 600 pixels de large
			// alert("Ceci est une tablette ou un desktop.");
			$('.clhgtbody').css({'height':'400px'});
		}
        
		var nameDocSign = '';
		var typeDocSign = '';

		function getNameDoc(name){
			// console.log('name : ',name)
			nameDocSign = name;
			nameDocSign = nameDocSign.substr(nameDocSign.lastIndexOf('/')+1);
			nameDocSign = nameDocSign.substr(0,nameDocSign.indexOf('pdf')-1);
		}


        $(document).on('click','.btclean',function(){
			// $('#modal-menage').modal('show')
			window.location.href='calendrier_nettoyage.php'
			return false
		})
		
		$(document).on('click','#btmenage',function(){
			// console.log($('#date_m1').val(), $('#date_m2').val())


            $.post('appajax.php', {
                action: 'print-room-cleaning', 
				dm1: $('#date_m1').val(),
				dm2: $('#date_m2').val(),
            }, function(resp) {
                if (resp.responseAjax == "SUCCESS") {
                    $('#modal-menage').modal('hide');
                    
                    if (resp.iddoc > 0)
                        $('#view_id_docs').val(resp.iddoc);
                    else
                        $('#view_id_docs').val('');

                    if (resp.cansign == '1')
                        $('#blksigndoc').removeClass('display-none');
                    else
                        $('#blksigndoc').addClass('display-none');

                    getNameDoc(resp.doc);
                    typeDocSign = 'de la room liste';

					$('#modal-menage').modal('hide')
                    $('#modal-pdf iframe').attr('src', resp.doc);
                    $('#modal-pdf').modal('show');

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
            }, 'json');
                
            HoldOn.close();
            return false;
        })

        $('.btnewcl').click(function(){
			$('#modal-new-fiche').modal('show')
		})

        $('#bttapeinf').click(function(){
			$('#modal-new-fiche').modal('hide')
			window.location.href='fiche.php?id_fiche=0'
		})

		$('#btsendinf').click(function(){
			if($('#lnk-mail').val() == ''){
				alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse mail obligatoire' : 'Email require') ?>")
				return false;
			}
			// send email avec lien
			$.post('appajax.php', {
				action: 'send-lnk-inscription', 
				type:'I',
				lg:$('#lg').val(),
				email:$('#lnk-mail').val(),
				isSign:($('#signinsc').is(':checked') ? '1' : '0'),
				url:'<?php echo $template['public_url']?>',
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {

					$('#modal-new-fiche').modal('hide')
					
					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
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
			}, 'json');
				
			HoldOn.close();
			return false;

		})


        var idmt = ''
		$('#btsendinfmail').click(function(){
			if($('#lnk-mail').val() == ''){
				alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse mail obligatoire' : 'Email require') ?>")
				return false;
			}
			$('#id_mailtypeinsc').val('0');
			$('#typeMailinsc').val('0');
			$('#attachclrinsc').val('0');
			$('#idMailTypeinsc').val('0');
			$('#name_mailtype').val('');
			$('#subjectmailinsc').val('');
			$('#signinsc2').val(($('#signinsc').is(':checked') ? '1' : '0'));
			CKEDITOR.instances.msgcontentinsc.updateElement();
			CKEDITOR.instances.msgcontentinsc.setData('');

			$('#destemailinsc').val($('#lnk-mail').val());
			$('#lginsc').val($('#lg').val());
			$('#modal-new-fiche').modal('hide')

			$('#modal-msg-mail-i').modal('show');
		
			return false;
		})

		$('.modeltype').click(function() {
			$('#id_mailtypeinsc').val('0');
			$('#typeMailinsc').val('0');
			$('#idMailTypeinsc').val('0');
			$('#name_mailtype').val('');
			$('#msgcontentinsc').val('');
			CKEDITOR.instances.msgcontentinsc.updateElement();
			CKEDITOR.instances.msgcontentinsc.setData('');
			
			$('#typeMailinsc').val($(this).attr('data-typeMail'))
			idmt = $(this).attr('data-id');
			$('#idMailTypeinsc').val(idmt)
			

			//for($i=1;$i<=selrowsMail.length; $i++){
				HoldOn.open();
				$.post('appajax.php', {
					action: 'affiche-mailtype',
					id_mailtype: idmt,
					id_fiche : '0',
					mail:$('#destemailinsc').val(),
					app:'I',
					url:'<?php echo $template['public_url']?>',
					type:'I',
					lg:$('#lginsc').val(),
					isSign:$('#signinsc2').val(),
				}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						
						var msg = resp.msg;
						var subject = resp.subject;
						var dest = resp.dest;

						$('#destemailinsc').val(dest)

						$('#subjectmailinsc').val(subject);
						
						$('#msgcontentinsc').val(msg);
						CKEDITOR.instances.msgcontentinsc.setData(msg);
						if (resp.data.attach != '')
							$('#attacheddocsinsc').html('<u>Pièces jointes</u> : ' + JSON.parse(resp.data.attach).join(", "));
						else
							$('#attacheddocsinsc').text('');
						$('#id_mailtypeinsc').val(idmt);
						$('#attachclrinsc').val('0');
					} else
						alert(resp.message);

					$('.tooltip.in').remove();
				}, 'json');
			// }

			// HoldOn.close();
			$('#btmtcontinsc').dropdown("toggle");
			return false;
		});

        $('#btadddocinsc').click(function() {
			$('#fileaddinsc').click();
		});
		$('#btdeldocinsc').click(function() {
			$('#fileaddinsc').val('');
			$('#attacheddocsinsc').text('');
			$('#attachclrinsc').val('1');
			return false;
		})


		$('#fileaddinsc').change(function() {
			var str = '';
			var files = $(this).prop("files")
			var names = $.map(files, function(val) {
				return val.name;
			});
			$.each(names, function(i, name) {
				str += str == '' ? name : ', ' + name;
			});
			$('#attacheddocsinsc').html(str != '' ? '<u>Pièces jointes</u> : ' + str : '');
			$('#attachclrinsc').val('0');
		});

		$('#btadddocininsc').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'load-listdocs', idc: $('#id_fiche').val()}, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {
					$('#lstdocscttinsc').html(resp.html);
					$('#blksenddocintinsc').show();
				}
				else
					alert(resp.message);
				
				HoldOn.close();

			}, 'json');
		
			return false;
		});

		$('#btmailsendinginsc').click(function() {
			$('#idMailTypeinsc').val(idmt);
			
			HoldOn.open();
			
			jQuery('#formulairemsginsc').ajaxSubmit({
				dataType:'json',
				data:{action:'send-mail-insc', 
					email:$('#destemailinsc').val(), 
					idmailtype: $('#id_mailtypeinsc').val(), 
					subject:$('#subjectmailinsc').val(), 
					msg:$('#msgcontentinsc').val(),

				},
				success : function (resp) {	
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {					
						$.bootstrapGrowl('<h4>Confirmation!</h4> <p>Email envoyé</p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
							align: "center",
							allow_dismiss: true
						});
						
						$('#modal-msg-mail-i').modal('hide');
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
								
				},
				error : function() {
					HoldOn.close();
				}
			}); 
			
				
				return false;			
		});
    })

</script>