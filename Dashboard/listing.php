<?php include 'including/config.php'; ?>
<?php 
	$outuser = Grid4PHP::getGrid('db_listing', $usrActif); 

	$mtypes = ModelMail::find("");
	$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));
?>

<?php include 'including/headPage.php'; ?>
<link rel="stylesheet" href="css/menu.css">

<style>
label {
	display: inline-flex;
	margin-bottom: .5rem;
	margin-top: .5rem;

}

table{
	width:100%;
}


.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.42;
  border-radius: 15px;
}

.buton{
	text-decoration: none;
	color: #3498db;
	font-weight: bold;
	font-size: 14px;
	position: relative;
	padding: 10px;
}

a.buton.one:before, a.buton.one:after{
	content: '';
	position: absolute;
	width: 10px;
	height: 10px;
	transition: all 0.3s ease;
}
a.buton.one:before{
	top: -2.5%;
	left: -1%;
	border-top: 2px solid #3498db;
	border-left: 2px solid #3498db;	
}
a.buton.one:hover, a.buton.one:focus {
    color: #3498db;
    text-decoration: none;
}

a.buton.one:after{
	bottom: -2.5%;
	right: -1%;
	border-bottom: 2px solid #3498db;
	border-right: 2px solid #3498db;
}
a.buton.one:hover:before, a.buton.one:hover:after{
	width: 100%;
	height: 100%;
	transition: all 0.3s ease;
}

.fc-time-grid .fc-highlight-container { 
	position: relative; 
	z-index: 3 ; 
}


/* ----------------------- tabs ----------------------- */
.icon-tab {
    margin-top: 30px;
  
    text-align : center;
    cursor: pointer;
}

.icon-tab span.glyphicon {
    display : block;
    font-size: 35px;

    color: #8d98b8;

    margin:  0px auto;
    line-height: 65px;

    transition-duration: 0.25s;
}

.icon-tab span.glyphicon::before {
    padding: 2px 6.5px;
    border-radius: 80%;
}


.icon-tab.active span.glyphicon {
    color: white;
    margin-bottom: 10px;
}

.icon-tab.active span.glyphicon::before {
    padding: 15px 19.5px;
    border-radius: 100%;

    transition-duration: 0.4s;
}

.icon-tab.active span.glyphicon::before {
    background: linear-gradient(to bottom right, #24C6DC, #514A9D);
}

.icon-tab span.glyphicon::before {
    padding: 15px 19.5px;
    background: linear-gradient(to bottom right, #d8e8e3, #DFCA55);
}


.icon-label {
    color:  #b3b3b3;
    font-size: 16px;  
  
    transition-duration: 0.35s;
}


.icon-tab.active .icon-label, .icon-tab:hover .icon-label {
    color: black;
}

.icon-tab:hover span.glyphicon {
    margin-bottom: 10px;
}


.item {
  margin-top: 50px;
}


@media (max-width:767px) { 
    .icon-tab {
        
    }
  
    .icon-tab span {
        display: inline !important;
        vertical-align : middle;
    }  
  
    .icon-tab.active span.glyphicon {
        padding-right: 10px;
    }
  
    .icon-tab:hover span.glyphicon {
        padding-right: 10px;
        transition-duration: 0.25s;
    }

}

	#bgbtcall{
		background-color: transparent !important;
	}
	
	#bginfcall{
		background-color: transparent !important;
	}

	/* hr {
		border: none;
		border-top: 3px double #333;
		color: #333;
		overflow: visible;
		text-align: center;
		height: 5px;
	}

	hr:after {
		background: #fff;
		content: '§';
		padding: 0 4px;
		position: relative;
		top: -13px;
	} */
</style>


<div id="page-content" class="">
   
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?> 
    </div>
   
    <div class="block full">
        <div class="block-title">
			<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Clients' : 'Customers') ?></strong></h2>
        </div>
	
		<script>
			var opts = {
				"stateOptions": {         
							
							storageKey: "localSstorage-listing",
							columns: true, // remember column chooser settings
							filters: true, // search filters
							selection: false, // row selection
							expansion: false, // subgrid expansion
							pager: true, // page number
							order: true // field ordering
				},
				// 'ondblClickRow': function (id) {
				// 	// jQuery(this).jqGrid('editGridRow', id , {height:275,reloadAfterSubmit:false,closeAfterEdit:true,closeOnEscape:true} ); 
				// 	if (jQuery(this).attr('id') == 'list_listing') {
				// 		location.href = 'fiche.php?id_fiche='+id;
				// 		return false;
				// 	}
				// }

			};
		</script>
	
        <div class="row">
			
			<div class="col-md-12 col-lg-12">
				<div class="block-options pull-right"> 
					
					<div class="btn-group btn-group-sm">
                        <a href="#" id="btmailgroup" <?php echo $arrAccess['send_mail_client'] != '1' ? 'style="display:none"' : "" ?> class="btn btn-xs btn-primary"><i class="fa fa-envelope"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mail multiple' : 'Multiple email') ?></a>
                        <a href="#" id="initgrid" style="margin-left:13px; height:30px; text-align:center; padding-top:5px; color:#000" class="btn btn-xs btn-warning"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Raffraichissement des données' : 'Refresh data') ?></a>
					</div>

				</div>
			
			</div>
			<div class="col-md-12 col-lg-12">
				<div class="row push table-responsive">
					<?php echo $outuser; ?>
				</div>
			</div>
		</div>
        
    </div>
   

	<div id="modal-mailgroupe" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-floppy-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail multiple' : 'Send multiple email') ?></h2>
				</div>
				
				<div class="modal-body">
					<form action="appajax.php" method="post" class="form-horizontal" id="formulairemailgroupe" onsubmit="return false;">
						<fieldset>
							<div class="form-group">
								<label class="col-md-3 control-label" for="namestate"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mail type' : 'Type email') ?></label>
								<div class="col-md-9">
									<select id="id_mailtype" name="id_mailtype" class="form-control">
										<option value="0"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Selectionner le modèle' : 'Choice of model') ?></option>
										<?php
											$mlts = ModelMail::find();
											if ($mlts) {
												foreach($mlts as $mlt) {
													echo '<option value="'.$mlt['id_mailtype'].'">'.$mlt['name_mailtype'].'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group form-actions">
								<div class="col-xs-12 text-right">
									<input type="hidden" name="idmailtype" id="idmailtype" value="0" />
									<input type="hidden" name="ficheid" id="ficheid" value="0" />
									<input type="hidden" name="action" id="action" value="send-mail-multiple" />
									<a href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></a>
									<button type="submit" href="#" class="btn btn-sm btn-primary" id="btsendmailgroupe"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				
			</div>
		</div>
	</div>

	<div id="modal-msg-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail' : 'Send email') ?></h2>
				</div>
				
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsgdoc" method="post" action="appajax.php">
						
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmail" placeholder="sujet" />
									<div class="input-group-btn" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du modèle' : 'Choice of model') ?>">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcont"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<?php foreach ($mtypes as $mtype) {?>
												<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" class="modeltype"><?php echo $mtype['name_mailtype']; ?></a></li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
						<textarea id="msgcontent" name="msgcontent" class="ckeditor">
							
						</textarea>
						<div id="attacheddocs" class="block">
						</div>
						<div id="blksenddocint">
							<div id="lstdocsctt" class="col-md-12"></div>
						</div>

						<div id="txtmailpres" class="display-none">							
						</div>
						<input type="file" name="fileadd[]" id="fileadd"  style="display:none;" multiple>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter pièces jointes' : 'Add attachments') ?>" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown" style="margin-right:10px"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddoc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocin"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
								</div>                    
								<button href="#" class="btn btn-sm btn-danger pull-right" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Retirer pièces jointes' : 'remove attachments') ?>" data-toggle="tooltip" id="btdeldoc"><i class="fa fa-minus"></i></button>
								<input type="hidden" name="id_mailtype" id="id_mailtype" value="0" />
								<input type="hidden" name="attachclr" id="attachclr" value="0" />
								<input type="hidden" name="typeMail" id="typeMail" value="0" />
								<input type="hidden" name="ficheid" id="ficheid" value="0" />
								<input type="hidden" name="idMailType" id="idMailType" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btmailsending" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
								<!-- <button class="btn btn-sm btn-primary" id="btmailsendingGrid" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button> -->
							</div>
						</div>
					</form>				
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
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btmailsendinginsc" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				
			</div>
		</div>
	</div>

	<div id="modal-msg-mail-libre" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail' : 'Send email') ?></h2>
				</div>
				
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsgdoclibre" method="post" action="appajax.php">
						<div id="destmail" class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire(s)' : 'Recipient(s)') ?></label>
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="destemaillibre" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
							<div class="col-md-8">
								<div class="">
									<input type="text" class="form-control"  value="" id="subjectmaillibre" placeholder="sujet" />
								</div>
							</div>
						</div>
						
						<textarea id="msgcontentlibre" name="msgcontentlibre" class="ckeditor">
							
						</textarea>
						<div id="attacheddocslibre" class="block">
						</div>
						<div id="blksenddocintlbre">
							<div id="lstdocscttlibre" class="col-md-12"></div>
						</div>

						<div id="txtmailpreslibre" class="display-none">							
						</div>
						<input type="file" name="fileaddlibre[]" id="fileaddlibre"  style="display:none;" multiple>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter pièces jointes' : 'Add attachments') ?>" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown" style="margin-right:10px"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddoclibre"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocinlibre"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
								</div>                    
								<button href="#" class="btn btn-sm btn-danger pull-right" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Retirer pièces jointes' : 'remove attachments') ?>" data-toggle="tooltip" id="btdeldoclibre"><i class="fa fa-minus"></i></button>
								
								<input type="hidden" name="attachclrlibre" id="attachclrlibre" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btmailsendinglibre" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				
			</div>
		</div>
	</div>

</div>

<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTPCq11w-n5ZN8o3fIzhuUXCwPTTP6OmE&libraries=places"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>


<script>
	
	$(document).ready(function() {

		var nameDocSign = '';
		var typeDocSign = '';

		function getNameDoc(name){
			// console.log('name : ',name)
			nameDocSign = name;
			nameDocSign = nameDocSign.substr(nameDocSign.lastIndexOf('/')+1);
			nameDocSign = nameDocSign.substr(0,nameDocSign.indexOf('pdf')-1);
		}

		$('.btnewfiche').click(function(){
			$('#modal-new-fiche').modal()
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
				url:'<?php echo $template['public_url']?>',
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {

					$('#modal-new-fiche').modal('hide')
					$('#list_listing').trigger("reloadGrid",[{current:true}]);
					
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


		$(document).on('click','.btroom',function(){
			
			// var selrows = $('#list_listing').jqGrid('getGridParam','selarrrow')
			var idct = $(this).attr('data-id')
			var selrows = []
			selrows.push(idct)
			
			$.post('appajax.php', {
				action: 'print-room-list', 
				rowid: selrows,
				type:'P',
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					
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


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

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

		$(document).on('click','#btroomlisttab',function(){
			
			var selrows = $('#list_listing').jqGrid('getGridParam','selarrrow')
			var idct = $(this).attr('data-id')
			
			$.post('appajax.php', {
				action: 'print-room-list', 
				rowid: selrows,
				type:'T',
				app:'1',
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					
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


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

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

		$(document).on('click','#btroomlistpage',function(){
			
			var selrows = $('#list_listing').jqGrid('getGridParam','selarrrow')
			var idct = $(this).attr('data-id')
			
			$.post('appajax.php', {
				action: 'print-room-list', 
				rowid: selrows,
				type:'P',
				app:'1',
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					
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


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

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

		$(document).on('click','.btcleanroom',function(){
						
			$.post('appajax.php', {
				action: 'print-room-cleaning', 
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					
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


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

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

		// $(document).on('click', '.btrappel',function(){
		// 	$('#id_contact_rappel').val($(this).attr('data-id'));
		// 	$('#modal-rappel').modal();
		// 	return false;
		// });


		$('#formulairerecall').submit(function(){
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType:'json',
				success : function (resp) {	
					if (resp.responseAjax == 'SUCCESS') {						
						$('#list_listing').trigger("reloadGrid",[{current:true}]);
						$('#modal-rappel').modal('hide');
					}
					else
					if (resp.responseAjax == 'ERROR')
						alert(resp.message);
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



		$('#formulairecommentgrid').submit(function(){
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType:'json',
				success : function (resp) {	
					if (resp.responseAjax == 'SUCCESS') {						
						$('#list_listing').trigger("reloadGrid",[{current:true}]);
						$('#modal-comment').modal('hide');
					}
					else
					if (resp.responseAjax == 'ERROR')
						alert(resp.message);
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

		$('#btdelct').click(function() {
			var selrows = $('#list_listing').jqGrid('getGridParam','selarrrow');
			if (selrows.length == 0) {
				alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Selectionner les lignes à supprimer' : 'Select lines to delete') ?>');
				return false;
			}
			
			if (confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez la suppression des fiches ?\n\rAINSI QUE DE TOUTES LES INFORMATIONS DU CLIENT' : 'Confirm deletion of records ?\n\rAND ALL INFORMATIONS OF CUSTOMER') ?>')) {
				HoldOn.open();
				$.post('appajax.php', {action:'delete-contacts', rws:selrows}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						//console.log(resp);
						$('#list_listing').trigger("reloadGrid",[{current:true}]);
					}
					else
						alert(resp.message);
				}, 'json');
			
				return false;
			}
		});
		
		var selrowsMail = 0;

		$('#btmailgroup').click(function() {
			var selrows = $('#list_listing').jqGrid('getGridParam','selarrrow');
			selrowsMail = selrows;
			
			if (selrows.length == 0) {
				alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Selectionner les lignes à envoyer' : 'Select lines to send') ?>');
				return false;
			}

			$('#ficheid').val(selrowsMail);

			// $('#msgtype').show();
			// $('#destmail').addClass('display-none');
			// $('.idchange').attr('id','btmailsending');
			$('#modal-msg-mail').modal();
		
			return false;
			
		});
		
		
		$(document).on('click','.btsenddoc',function() {
			$('#ficheid').val($(this).attr('data-id'));
			$('#modal-msg-mail').modal();
		})
		
		$(document).on('click', '.btrappel',function(){
			$('#id_contact_rappel').val($(this).attr('data-id'));
			$('#modal-rappel').modal();
			return false;
		});

		$('.btemaillibre').click(function() {
			// $('#msgtype').hide();
			// $('#destmail').removeClass('display-none');
			// $('.idchange').attr('id','btmailsendinglibre');
			$('#modal-msg-mail-libre').modal();
		
			return false;
			
		});

		$('#id_mailtype').change(function(){
			$('#idmailtype').val($(this).val())
		})

		$('#btsendmailgroupe').click(function(){

			HoldOn.open();
			
			jQuery('#formulairemailgroupe').ajaxSubmit({
				dataType:'json',
				data:{action:'send-mail-multiple', rws:$('#ficheid').val(), idmailtype: $('#idmailtype').val(), subject:$('#subjectmail').val(), msg:CKEDITOR.instances['msgcontent'].getData()},
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
						
						$('#modal-mailgroupe').modal('hide');
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
			CKEDITOR.instances.msgcontentinsc.updateElement();
			CKEDITOR.instances.msgcontentinsc.setData('');

			$('#destemailinsc').val($('#lnk-mail').val());
			$('#lginsc').val($('#lg').val());
			$('#modal-new-fiche').modal('hide')

			$('#modal-msg-mail-i').modal();
		
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
				data:{action:'send-mail-insc', email:$('#destemailinsc').val(), idmailtype: $('#id_mailtypeinsc').val(), subject:$('#subjectmail').val(), msg:$('#msgcontentinsc').val()},
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

		// mail inscription //
		$('.modeltype').click(function() {
			
			$('#typeMail').val($(this).attr('data-typeMail'))
			idmt = $(this).attr('data-id');
			$('#idMailType').val(idmt)
			

			//for($i=1;$i<=selrowsMail.length; $i++){
				HoldOn.open();
				$.post('appajax.php', {
					action: 'affiche-mailtype',
					id_mailtype: idmt,
					id_fiche : '0',
				}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						
						var msg = resp.msg;
						var subject = resp.subject;
						var dest = resp.dest;

						$('#destemail').val(dest)

						$('#subjectmail').val(subject);
						
						$('#msgcontent').val(msg);
						CKEDITOR.instances.msgcontent.setData(msg);
						if (resp.data.attach != '')
							$('#attacheddocs').html('<u>Pièces jointes</u> : ' + JSON.parse(resp.data.attach).join(", "));
						else
							$('#attacheddocs').text('');
						$('#id_mailtype').val(idmt);
						$('#attachclr').val('0');
					} else
						alert(resp.message);

					$('.tooltip.in').remove();
				}, 'json');
			// }

			// HoldOn.close();
			$('#btmtcont').dropdown("toggle");
			return false;
		});

		$('#btadddoc').click(function() {
			$('#fileadd').click();
		});
		$('#btdeldoc').click(function() {
			$('#fileadd').val('');
			$('#attacheddocs').text('');
			$('#attachclr').val('1');
			return false;
		})


		$('#fileadd').change(function() {
			var str = '';
			var files = $(this).prop("files")
			var names = $.map(files, function(val) {
				return val.name;
			});
			$.each(names, function(i, name) {
				str += str == '' ? name : ', ' + name;
			});
			$('#attacheddocs').html(str != '' ? '<u>Pièces jointes</u> : ' + str : '');
			$('#attachclr').val('0');
		});

		$('#btadddocin').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'load-listdocs', idc: $('#id_fiche').val()}, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {
					$('#lstdocsctt').html(resp.html);
					$('#blksenddocint').show();
				}
				else
					alert(resp.message);
				
				HoldOn.close();

			}, 'json');
		
			return false;
		});

		$('#btadddoclibre').click(function() {
			$('#fileaddlibre').click();
		});
		$('#btdeldoclibre').click(function() {
			$('#fileaddlibre').val('');
			$('#attacheddocslibre').text('');
			$('#attachclrlibre').val('1');
			return false;
		})


		$('#fileaddlibre').change(function() {
			var str = '';
			var files = $(this).prop("files")
			var names = $.map(files, function(val) {
				return val.name;
			});
			$.each(names, function(i, name) {
				str += str == '' ? name : ', ' + name;
			});
			$('#attacheddocslibre').html(str != '' ? '<u>Pièces jointes</u> : ' + str : '');
			$('#attachclrlibre').val('0');
		});

		$('#btadddocinlibre').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'load-listdocs-libre', idc: $('#id_fiche').val()}, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {
					$('#lstdocscttlibre').html(resp.html);
					$('#blksenddocintlibre').show();
				}
				else
					alert(resp.message);
				
				HoldOn.close();

			}, 'json');
		
			return false;
		});

		$('#btinsdocin').click(function() {
			if ($('#lstdocsctt input:checked').length == 0) {
				alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Selectionner les pièces jointes' : 'Select  attachments') ?>');
				return false;
			}

			var docs = [];
			$('#lstdocsctt input:checked').each(function() {
				docs.push($(this).attr('data-id'));
			});


			console.log(docs);

			return false;
		});		

		// $(document).on('click','.btmailsending',function() {
		// 	$('#ficheid').val($(this).attr('data-id'));
			
		// 	// $('#msgtype').show();
		// 	// $('#destmail').addClass('display-none');
		// 	// $('.idchange').attr('id','btmailsending');
		// 	$('#modal-msg-mail').modal();
		// })

		$('#btmailsending').click(function() {
			$('#idMailType').val(idmt);
			
			HoldOn.open();
			// console.log('btmailsending', $('#ficheid').val())
			// return false
			
			jQuery('#formulairemsgdoc').ajaxSubmit({
				dataType:'json',
				data:{
					action:'send-mail-grid', 
					rws:$('#ficheid').val(), 
					idmailtype: $('#id_mailtype').val(), 
					subject:$('#subjectmail').val(), 
					msg:CKEDITOR.instances['msgcontent'].getData(), 
					url:'<?php echo $template['public_url'] ?>' ,
					type:'I',
					lg:'FR',
					isSign:'0',
					sejour:'<?php echo $usrActif->cursoc ?>'
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
						
						$('#modal-msg-mail').modal('hide');
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

		// $('#btmailsendingGrid').click(function() {
			
		// 	HoldOn.open();
			
		// 	jQuery('#formulairemsgdoc').ajaxSubmit({
		// 		dataType:'json',
		// 		data:{action:'send-lnk-inscription-grid', 
		// 			type:'I',
		// 			lg:'FR',
		// 			rws:$('#ficheid').val(), 
		// 			isSign:'0',
		// 			url:'<?php echo $template['public_url'] ?>'},
		// 		success : function (resp) {	
		// 			HoldOn.close();
		// 			if (resp.responseAjax == 'SUCCESS') {					
		// 				$.bootstrapGrowl('<h4>Confirmation!</h4> <p>Email envoyé</p>', {
		// 					type: 'success',
		// 					delay: 5000,
		// 					offset: {
		// 					from: "top",
		// 					amount: 100
		// 						},
		// 					align: "center",
		// 					allow_dismiss: true
		// 				});
						
		// 				$('#modal-msg-mail').modal('hide');
		// 			}
		// 			else
		// 				$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 					type: 'danger',
		// 					delay: 5000,
		// 					offset: {
		// 					from: "top",
		// 					amount: 100
		// 						},
		// 						align: "center",
		// 					allow_dismiss: true
		// 				});
								
		// 		},
		// 		error : function() {
		// 			HoldOn.close();
		// 		}
		// 	}); 
			
				
		// 		return false;			
		// });

		$(document).on('click','#btmailsendinglibre',function() {
			$('#idMailType').val(idmt);
			
			HoldOn.open();
			
			jQuery('#formulairemsgdoclibre').ajaxSubmit({
				dataType:'json',
				data:{action:'send-mail-libre', dest:$('#destemaillibre').val(), subject:$('#subjectmaillibre').val(), msg:CKEDITOR.instances['msgcontentlibre'].getData()},
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
						
						
						// $('.idchange').attr('id','btmailsending');
						$('#modal-msg-mail-libre').modal('hide');
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
		

		$(document).on('click', '.btcomment',function(){
			$('#id_contact_comment').val($(this).attr('data-id'));
			$('#modal-comment').modal();
			return false;
		});

		$(document).on('click', '.btcommentform',function(){
			$('#id_contact_comment_form').val($(this).attr('data-id'));
			$('#modal-comment-form').modal();
			return false;
		});
		

		// new
		$('#btstatussec').click(function() {
			var selrows = $('#list_listing').jqGrid('getGridParam','selarrrow');
			if (selrows.length == 0) {
				alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Selectionner les lignes à statuer' : 'Select lines to change status') ?>');
				return false;
			}
			$('#idf').val('0');			
			
			$('#modal-changestatussec').modal();
		});
		

		$('#formulairechangestatussec').submit(function() {
			if ($('#id_status_sec').val() == '0') {
				alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choisissez un statut' : 'Choice status') ?>');
				return false;
			}
			var selrows = $('#list_listing').jqGrid('getGridParam','selarrrow');
			if (selrows.length == 0 && $('#idf').val() == '0') {
				alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Selectionner les lignes à statuer' : 'Select lines to change status') ?>');
				return false;
			}
			if (selrows.length == 0)
				selrows = '-';
			
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType:'json',
				data:{rws:selrows, idf:$('#idf').val()},
				success : function (resp) {	
					if (resp.responseAjax == 'SUCCESS') {						
						$('#list_listing').trigger("reloadGrid",[{current:true}]);
						$('#modal-changestatussec').modal('hide');
					}
					else
					if (resp.responseAjax == 'ERROR')
						alert(resp.message);
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


		$(document).on('click', '.btchangestatussec', function() {
			$('#idf').val($(this).attr('data-id'));
			$('#modal-changestatussec').modal();
		});


		function deleteCookies(name, value, minutes) {
			var endCookies = "";
			if (minutes) {
				var date = new Date();
				date.setTime(date.getTime() + (minutes * 60 * 1000));
				endCookies = "; endCookies=" + date.toGMTString();
			}

			document.cookie = name + "=" + value + endCookies;
		}

		$('#initgrid').click(function() {
			deleteCookies("jqgrid_colchooser",null,-1);
			localStorage.removeItem('jStorage');
			window.location.reload();
			return false;
		});

		$('#btaddview').click(function() {
			$('#modal-save-view').modal();
			$('#namestate').val('');
			$('#namestate').focus();

			return false;
		});

		$('#btsavestate').click(function() {
			//var savedState = JSON.stringify($("#list_listing").getGridParam()); // jQuery.jStorage.get('localSstorage-listing');
			var savedState = jQuery.jStorage.get('localSstorage-listing');
			//if (savedState.colsData != null) {
				var nm = $('#namestate').val();
				if (nm != '') {
					var items = JSON.parse(localStorage.getItem('storageviews')) || [];				
					items.push({'name':nm, val:savedState});
					console.log(items);
					localStorage.setItem('storageviews', JSON.stringify(items));
					$('#idviewliste a.mdcol').addClass('btn-alt');
					// $('#idviewliste').append('<li><a href="#" class="btn btn-sm btn-default mdcol" data-key="'+(items.length-1)+'">'+nm+' <i class="fa fa-times text-danger" data-key="'+(items.length-1)+'"></i></a></li>&nbsp;');
					$('#idviewliste').append('<option value="'+(items.length-1)+'" data-key-supp="'+(items.length-1)+'" class="btn btn-sm btn-default mdcol">'+nm+'</option>&nbsp;');
					$('#modal-save-view').modal('hide');
				}
				else
					alert('Nommez votre modele d\'affichage');

			return false;
		});

		$(document).on('click', '.mdcol', function() {
			var key = $(this).attr('data-key');
			var savedState = JSON.parse(localStorage.getItem('storageviews'));
			if (savedState[key] != null) {
				jQuery.jStorage.set('localSstorage-listing', savedState[key].val);
				
				window.location.reload();
			}

			return false;
		});

		// $(document).on('click', '#idviewliste > a.mdcol > i', function() {
		$(document).on('click', '.mdcol ', function() {
			if (confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez la suppression de la vue ?' : 'Confirm deletion of view ?') ?>')) {
				// var key = $(this).attr('data-key');
				var key = $(this).attr('data-key-supp');
				var savedState = JSON.parse(localStorage.getItem('storageviews'));
				savedState.splice(key, 1);
				localStorage.setItem('storageviews', JSON.stringify(savedState));
				//$('#list_listing').gridState().remove('localSstorage-listing');
				jQuery.jStorage.flush();
				window.location.reload();
			}

			return false;
		});

		// $('#idviewliste').selectpicker();
		function loadsavedState() {
			var savedState = JSON.parse(localStorage.getItem('storageviews'));
			if (savedState != null) {
				var cursavedState = JSON.stringify(jQuery.jStorage.get('localSstorage-listing'));
				for(var d in savedState) {
					// $('#idviewliste').append('<li><a href="#" class="btn btn-sm btn-success mdcol '+(JSON.stringify(savedState[d].val) != cursavedState ? 'btn-alt' : '')+'" data-key="'+d+'">'+savedState[d].name+' <i class="fa fa-times text-danger" data-key="'+d+'"></i></li></a>&nbsp;');
					$('#idviewliste').append('<option data-content="<i class=\'fa fa-trash\'></i> class="" value="" data-key="'+d+'">'+savedState[d].name+'</option>&nbsp;');
				}
			}

		}

		loadsavedState();

	});

		
	function gridctslisting_onload(ids) {	
		if(ids.rows) 
			jQuery.each(ids.rows,function(i) {
				console.log('llll',$('.btn-group').parent().prev());
				if (this.status_color != '' && this.status_color != undefined)	
					jQuery('#list_listing tr.jqgrow:eq('+i+')').css('background-image','inherit').css({'background-color':this.status_color});
			});
			
		$('.btn-group').parent().css({'background-color':'white'});
		$('.btn-group').parent().prev().css({'background-color':'white'});
		$('.btn-group').parent().prev().prev().css({'background-color':'white'});
		$('.ui-pg-selbox').val(jQuery('#list_listing').getGridParam('rowNum'));
		jQuery('#list_listing').jqGrid('resetSelection');
	}

	
</script>

