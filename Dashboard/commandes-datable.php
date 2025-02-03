<?php

include 'including/config.php'; ?>


<?php
    $outcmds = Grid4PHP::getGrid('db_commandes');
    $numcmd = Cmd::getLastNoCmd(array('id_sejour'=>max($usrActif->cursoc, 1)        ));
?>
<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/menu.css">
<style>
    table, th, td {
      border: 1px solid black !important;
      border-collapse: collapse !important;
    }
</style>


    
<div id="page-content" class="page-dashboard"> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

    <h2>Commandes fournisseur(s) </h2>
  
    <div id="dataDivID" class="form-container">
        <div class="block-full">
            <div class="row">
                <div class="pull-right" style="margin:15px">
                    <a href="#" class="btn btn-primary" id="newcmd">Passez une commande</a>
                    <a href="#" class="btn btn-info" id="viewcmd" style="display:none">Liste des commandes</a>
                    <a href="#" class="btn btn-success" id="mailcmd">Envoyez un mail au fournisseur</a>
                </div>
            </div>
        </div>
        <div id="lstcmd">
          <div class="block">
              <div class="table-responsive">
                  <?php echo $outcmds ?>
              </div>
          </div>
        </div>
        <div id="sendcmd" style="display:none">
          <div class="block">
          <div class="container">
                        <div class="row" style="">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">
                                <label for="fourn" style="" class="control-label" style="">Fournisseur</label>
                                <select data-placeholder="Choisissez le fournisseur " class="form-control select-chosen" id="id_fournisseur" name="id_fournisseur" style="/*width: 200px;*/">
                                    <option value=""></option>
                                    <?php
                                    $frns = Fournisseurs::getAll();
                                    if ($frns) {
                                        foreach ($frns as $frn) {
                                            echo '<option value="' . $frn['id_fournisseur'] . '" >' . $frn['name_fournisseur'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="idfourn" id="idfourn" value="0" />
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row" style="margin-top: 25px;">
                            <div class="col-md-3">
                                
                            </div>
                            
                            <div class="col-md-6" style="display: flex;">
                                <label for="numcmd" style="margin-right:5px" class="control-label">N° commande</label>
                                <input type="text" class="form-control" id="numcmd" name="numcmd" value="CMD_1" style="width: 150px;" readonly="">
                            </div>
                        </div>
                    </div>

                    <!--  -->
                    <div class="container">
                        <div class="row" style="margin-top: 25px;">
                            <table id="tbcmd" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            Produits
                                        </th>
                                        <th> 
                                            Qté 
                                        </th>
                                        <th> 
                                            Unités 
                                        </th>
                                        <th> 
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td id="prod">
                                        
                                    </td> 
                                    <td id="unit">
                                        
                                    </td>
                                    <td id="">
                                        <input type="text" class="form-control" name="qtecmd" id="qtecmd"></input>
                                    </td>
                                    <td id="">
                                      <label for="addcmd" class="control-label" style="margin-right:5px">Ajout</label>
                                      <button href="#" id="addcmd" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
                            
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table id="listeCmd" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
                        <thead>
                            <tr>
                                <th>
                                    Produit
                                </th>
                                <th> 
                                    Qté 
                                </th>
                                <th> 
                                    Unité 
                                </th>
                                <th> 
                                     
                                </th>
                            </tr>
                        </thead>
                        <tbody id="elemcmd">
                        </tbody>
                    </table>
                    <div>
      <button class="btn" onclick="firstPage()">|<</button>
          <button class="btn" onclick="previous()">
            <</button>
              <span id="pageInfo"></span>
              <button class="btn" onclick="nextPage()">></button>
              <button class="btn" onclick="lastPage()">>|</button>
    </div>
				</div>
          </div>
        </div>
	</div>

	<div id="modal-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> Envoi Email</h2>
				</div>
				<div class="modal-body">
					<form onsubmit="return false;" class="" id="formulairemsgdoc" method="post" action="appajax.php">
							
						<label class="col-md-4 control-label">Destinataire(s)</label>
						<div class="form-group">
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="destemail" />
							</div>
						</div>

                        <label class="col-md-4 control-label">Sujet</label>
						<div class="form-group">	
							<div class="col-md-6">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmail" placeholder="sujet" />
									<div class="input-group-btn" data-toggle="tooltip" title="Charger un message type">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcont" style="width: 50px;height: 34px;"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<?php foreach ($mtypes as $mtype) {?>
												<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" class="lnkmailtype"><?php echo $mtype['name_mailtype']; ?></a></li>
											<?php } ?>
										</ul>
									</div>
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

                        <label class="col-md-4 control-label">Attachement</label>
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
								<input type="hidden" name="cleardoc" id="cleardoc" value="0" />
								<input type="hidden" name="typeMail" id="typeMail" value="0" />
								<input type="hidden" name="idMailType" id="idMailType" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btsenddoc" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				
			</div>
		</div>
	</div>

    <div id="modal-cmd" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-file"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Passez une commande' : 'To order') ?></h2>
				</div>
				<div class="modal-body">
                    
				
			</div>
		</div>
	</div>
	
</div>


<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTPCq11w-n5ZN8o3fIzhuUXCwPTTP6OmE&libraries=places"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>


<script>
	$(document).ready(function() {

        
        var options = {
                theme:"sk-cube-grid",
                message:'<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Chargement des données en cours ....' : 'Message loading ....') ?>',
                backgroundColor:"#1847B1",
                textColor:"white"
            };
        InitFields()

        var emailfrom = '';
        var emailto = '';
    
        $('#newcmd').click(function(){
            // $('#modal-cmd').modal()
            $(this).css('display', 'none');
            $('#lstcmd').css('display', 'none');
            $('#sendcmd').show();
            $('#viewcmd').show();
            $('#listeCmd').DataTable({        
                "destroy": true, 
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                "iDisplayLength": -1,
                "bFilter": true,
            });
        })

        $('#viewcmd').click(function(){
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Les saisies en cours seront perdues \\n\\rConfirmer votre choix !" : "Entries will be lost \\n\\rConfirm !") ?>')){
              return false;
            }

            $(this).css('display', 'none');
            $('#lstcmd').show();
            $('#sendcmd').hide();
            $('#newcmd').show();
            $('#listeCmd').DataTable({    
                "destroy": true, 
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                "iDisplayLength": -1,
                "bFilter": true,
            });

            var table = $('#listeCmd').DataTable();
            
            table.clear().draw();
        })

        $(document).on('change','#id_fournisseur', function(){
            $('#idfourn').val($(this).val())

            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'read-prod',
              idfourn: $('#idfourn').val(),
            }, function(resp) {
              HoldOn.close();
              $('#prod').html(resp.html);
              $('#unit').html(resp.htmlunit)

            }, 'json');

            return false;
        })

        $(document).on('change','#id_produit', function(){
           let unit = $('#id_produit option:selected').attr('data-unit');
            console.log('lll',unit, this);
          //  $('#id_unite option[value="'+unit+'"]').prop('selected', true);
           $('#id_unite').val(unit);
           $('#id_unite').trigger('chosen:updated');
        })

        var arrelem = [];
        var elem = '';
        var elemList = '';
        var numberOfItems = 10;
        var first = 0;
        var actualPage = 1;

        $(document).on('click','#addcmd', function(){
            // $('.dataTables_empty').remove()
            elem += "<tr><td>"+$('#id_produit option:selected').text()+"</td>";
            elem += "<td>"+$('#qtecmd').val()+"</td>";
            elem += "<td>"+$('#id_unite option:selected').text()+"</td>";
            elem += "<td><button href='#' class='btn btn-sm btn-danger pull-left' id='supcmd'><i class='fa fa-minus'></i></button></td></tr>";

            arrelem.push(elem);
            // row.add($(elem));
            // $('#elemcmd').append(elem)
            showList()
        })

        function showList(){
          let tableList = "";
          for(let i = first; i < first + numberOfItems;i++){
            console.log(i);
            if(i<arrelem.length){
              $('#elemcmd').append(arrelem[i])
            }
          }
          // document.getElementById('listeCmd').innerHTML=tableList;
          showPageInfo();
        }

        function nextPage(){
          if(first+numberOfItems<=arrelem.length){
            first+=numberOfItems;
            actualPage ++;
            showList();
          }
        }

        function previous(){
          if(first-numberOfItems >= 0){
            first-=numberOfItems
            actualPage --;
            showList();
          }
        }

        function firstPage(){
          first = 0
          actualPage = 1;
          showList();
        }

        let maxPages = Math.ceil(arrelem.length / numberOfItems );
 
        function lastPage(){
          first = (maxPages * numberOfItems)-numberOfItems;
          actualPage = maxPages;
          showList(); 
        }
      
        function showPageInfo(){
          document.getElementById('pageInfo').innerHTML = `
            Page ${actualPage} / ${maxPages}
          `
        }

        $('#idconnect').click(function(){
            getEmails();
        })

        function InitFields(){
            
            // console.log('init')
            // getEmails();
        }

        function getEmails(){
            
            var options = {
                theme:"sk-cube-grid",
                message:'<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Chargement des données en cours ....' : 'Message loading ....') ?>',
                backgroundColor:"#1847B1",
                textColor:"white"
            };
            
            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'connect-mail-outbox',
            }, function(resp) {
              HoldOn.close();
              $('#idmail').html(resp.html);

                      $('#idimap').DataTable({     
                      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                          "iDisplayLength": 5
                      });

            }, 'json');

        }
        
        $(document).on('click','.btforward',function(){
            emailfrom = $(this).attr('data-from');
            emailto = $(this).attr('data-to');

            $('#destemail').val(emailfrom)

            $.post('appajax.php', {
				        action: 'recup-infos-mail',
                uid:  $(this).attr('data-id'),
                outbox:1,
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
			$('#cleardoc').val('0');
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
					$('#cleardoc').val('0');
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