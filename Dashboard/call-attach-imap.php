<?php

include 'including/config.php'; 	

// $outmails = Grid4PHP::getGrid('db_mails'); ?>

<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<link rel="stylesheet" href="css/menu.css">

<?php 
$mtypes = ModelMail::find("");

?>

    
<div id="page-content" class="page-dashboard"> 
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

    <h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Boite de réception' : 'Inbox') ?> </h2>
  
    <div id="btnContainer">
        <button class="btn active" id="idconnect">
            <i class="fa fa-bars"></i><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Clickez ici pour raffraichir' : 'Click here to refresh') ?>
        </button>
    </div>
    <br>

    <!-- <div id="dataD" class="form-container">
        <div class="row">
            <div id="idmail2">
				<?php echo $outmails ?>
            </div>
        </div>
	</div> -->
    <div id="dataDivID" class="form-container">
        <div class="row">
            <div id="idmail">
            </div>
        </div>
	</div>

    <!-- Modal message doc  -->
	<div id="modal-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" style="min-width: 80%;">
			<div class="modal-content" style="min-height: 70rem;">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi Email' : 'Send email') ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="" id="formulairemsgdoc" method="post" action="appajax.php">
							
						<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire(s)' : 'Recipient(s)') ?></label>
						<div class="form-group">
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="destemail" />
							</div>
						</div>

                        <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
						<div class="form-group">	
							<div class="col-md-6">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control"  value="" id="subjectmail" placeholder="sujet" />
								</div>
							</div>
						</div>
                        
							<label class="col-md-4 control-label">Message</label>
						<div class="form-group">
                            <div class="col-md-12">
                                <textarea id="msgcontent" name="msgcontent" class="ckeditor">
                                    
                                </textarea>
                            </div>
                        </div>

                        <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pièces jointes' : 'Attachments') ?></label>
                        <div class="form-group">
                            <div id="attacheddocs" class="col-md-12 block">
                            </div>
                            <div id="blksenddocint">
                                <div id="lstdocsctt" class="col-md-12"></div>
                            </div>

                            <div id="txtmailpres" class="display-none">							
                            </div>
                            <input type="file" name="fileadd[]" id="fileadd"  style="display:none;" multiple>
                        </div>
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="Ajouter un document" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddoc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocin"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
									<button href="#" class="btn btn-sm btn-danger pull-left" title="Retier les pièces jointe" data-toggle="tooltip" id="btdeldoc"><i class="fa fa-minus"></i></button>
								</div>                    
								<input type="hidden" name="id_mailtype" id="id_mailtype" value="0" />
								<input type="hidden" name="attachclr" id="attachclr" value="0" />
								<input type="hidden" name="typeMail" id="typeMail" value="0" />
								<input type="hidden" name="idMailType" id="idMailType" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btsenddoc" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
	<!-- END message doc -->

	<div id="modal-read-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" style="min-width: 80%;">
			<div class="modal-content" style="min-height: 70rem;">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contenu du email' : 'Informations') ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="" id="formulairereadmail" method="post" action="appajax.php">
                        <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
						<div class="form-group">	
							<div class="col-md-6">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control"  value="" id="subjectreadmail" placeholder="sujet" />
								</div>
							</div>
						</div>
                        
						<label class="col-md-4 control-label">Message</label>
						<div class="form-group">
                            <div class="col-md-12">
                                <textarea id="msgreadmail" name="msgreadmail" class="ckeditor" readonly='readonly'>
                                    
                                </textarea>
                            </div>
                        </div>
						
					</form>		
					<div class="form-group form-actions">
						<div class="col-md-12 text-center">
							<button href="#" class="btn btn-sm btn-default" style="margin-top: 30px;" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
						</div>
					</div>		
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>

<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTPCq11w-n5ZN8o3fIzhuUXCwPTTP6OmE&libraries=places"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>
<script>
	$(document).ready(function() {

		// $('#idimap').DataTable({     
		// 	"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
		// 		"iDisplayLength": 5,
		// 		"bFilter": false
		// 	});
		
		
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

			console.log($(files))
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

		$('#btinsdocin').click(function() {
			if ($('#lstdocsctt input:checked').length == 0) {
				alert('Veuillez sélectionner les documents à insérer en pièce jointe');
				return false;
			}

			var docs = [];
			$('#lstdocsctt input:checked').each(function() {
				docs.push($(this).attr('data-id'));
			});

			return false;
		});	

		$('#btsenddoc').click(function() {
		
			HoldOn.open();
			
			jQuery('#formulairemsgdoc').ajaxSubmit({
				dataType:'json',
				data:{action:'send-reponse-mail', email:$('#destemail').val(), subject:$('#subjectmail').val(), msg:CKEDITOR.instances['msgcontent'].getData()},
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
						
						$('#modal-mail').modal('hide');
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

        InitFields()

        var emailfrom = '';
        var emailto = '';
    
       

        $('#idconnect').click(function(){
            getEmails();
        })

        function InitFields(){
            console.log('init')
            getEmails();
        }

        function getEmails(){
            
            var options = {
                theme:"sk-cube-grid",
                message:'Chargement des données en cours .... ',
                backgroundColor:"#1847B1",
                textColor:"white"
            };
            
			HoldOn.open(options);
            $.post('appajax.php', {
				action: 'connect-mail',
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
					$('#idmail').html(resp.html);

					$('#idimap').DataTable({     
						"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
						"iDisplayLength": 5
					});
				}else{
					$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
						type: 'danger',
						delay: 6000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});
				}

			}, 'json');

        }
        
        $(document).on('click','.btread',function(){
            emailfrom = $(this).attr('data-from');
            emailto = $(this).attr('data-to');
            idmail = $(this).attr('data-id-mail');

            $.post('appajax.php', {
				action: 'read-msg-mail',
                uid:  $(this).attr('data-id'),
                idmail:  idmail,
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
                    $('#subjectreadmail').val(resp.data.subject_mail)
                    $('#msgreadmail').val(resp.data.msg_mail)
                    CKEDITOR.instances.msgreadmail.setData(resp.data.msg_mail);
				} else
					alert(resp.message);

				$('.tooltip.in').remove();
			}, 'json');

           
            $('#modal-read-mail').modal()
			$('#cke_msgreadmail').css('height','460px')
			$('#cke_2_contents').css('height','336px')
        })
        
        $(document).on('click','.btforward',function(){
			let sendmailinbox = '<?php echo ($arrAccess['send_mail_inbox'] != '1' ? 0 : 1)?>'
			if(sendmailinbox == 0){
				alert('ACTION REFUSEE');
				return false;
			}
            emailfrom = $(this).attr('data-from');
            emailto = $(this).attr('data-to');

            $('#destemail').val(emailfrom)

            $.post('appajax.php', {
				action: 'recup-infos-mail',
                uid:  $(this).attr('data-id'),
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
                    $('#subjectmail').val('RE : '+resp.data.subject_mail)
                    $('#msgcontent').val('\n\n\n\n\n\n'+'- - - - - - - - - - - - - - - -'+'\n\n'+resp.data.msg_mail)
                    CKEDITOR.instances.msgcontent.setData('\n\n\n\n\n\n'+'- - - - - - - - - - - - - - - -'+'\n\n'+resp.data.msg_mail);
				} else
					alert(resp.message);

				$('.tooltip.in').remove();
			}, 'json');

           
            $('#modal-mail').modal()
        })

        $('.lnkmailtype').click(function() {
			$('#id_mailtype').val('0');
			$('#typeMail').val('0');
			$('#attachclr').val('0');
			$('#idMailType').val('0');
			$('#name_mailtype').val('');
			$('#stagiaire').val('');
			$('#subjectmail').val('');

			$('#destemail').val($('#email').val())

			$('#msgcontent').val('');
			CKEDITOR.instances.msgcontent.setData('')
		
			$('#typeMail').val($(this).attr('data-typeMail'))
			var idmt = $(this).attr('data-id');
			$('#idMailType').val(idmt)

			HoldOn.open(options);
			$.post('appajax.php', {
				action: 'affiche-mailtype',
                emailfrom: emailfrom,
                emailto: emailto,
				id_mailtype: idmt,
				id_fiche : 0,
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
										
					var msg = resp.msg;
					var subject = resp.subject;
					var dest = resp.dest;

					$('#typeMail').val() != 3 ? "" : $('#destemail').val(dest)

					$('#subjectmail').val(subject);
					
					$('#msgcontent').val(msg);
					CKEDITOR.instances.msgcontent.setData(msg);
					if(resp.data !== null){
						if (resp.data.attach != '')
							$('#attacheddocs').html('<u>Pièces jointes</u> : ' + JSON.parse(resp.data.attach).join(", "));
						else
							$('#attacheddocs').text('');
					}
					$('#id_mailtype').val(idmt);
					$('#attachclr').val('0');
				} else
					alert(resp.message);

				$('.tooltip.in').remove();
			}, 'json');
            HoldOn.close();

			$('#btmtcont').dropdown("toggle");
			return false;
		});
    });


    function checkAll(bx) {
    var cbs = document.getElementsByTagName('input');
    for(var i=0; i < cbs.length; i++) {
        if(cbs[i].type == 'checkbox') {
        cbs[i].checked = bx.checked;
        }
    }


}
</script>