<?php include 'including/config.php'; 
$outenfants = Grid4PHP::getGrid('db_enfants', $usrActif->cursoc);
?>	

<?php include 'including/headPage.php'; ?>
<link rel="stylesheet" href="css/menu.css">

<!-- Page content -->
<div id="page-content" class="page-dashboard"> 
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

    <div class="row">
        <div class="btn-group pull-left">
            <a href="#" data-toggle="tooltip" title="Impression" class="btn btn-xs btn-primary btimp" style="margin-left: 17px;margin-bottom: 17px;"><i class="gi gi-ip"></i>Impression emploi du temps</a>
        </div>
    </div>
	<div id="blcact" class="table-responsive"><?php echo $outenfants; ?></div>


    <div id="modal-tab" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

		<div class="modal-dialog" style="width:50%;">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> Emploi du temps</h2>
				</div>
				<!-- END Modal Header -->
				
				<!-- Modal Body -->
				<div class="modal-body" style="height:200px">
					<form onsubmit="return false;" class="form-bordered form-horizontal" id="formulairetab" method="post" action="appajax.php">
						<div class="form-group" style="display:flex;justify-content:center">
							<div class="col-md-3">
								<label for="day_deb" class="control-label">Date arrivée</label>
								<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="day_deb" id="day_deb" value="">
							</div>
							<div class="col-md-3">
								<label for="day_end" class="control-label">Date départ</label>
								<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="day_end" id="day_end" value="">
							</div>
							
                            <div class="col-md-3" >
                                <label for="idgroupe" class="control-label">Groupe</label>
                                <?php echo Tool::DropDown('idgroupe',Groupes::getAll(),'id_groupe','name_groupe','','Tous les groupes') ?>
							</div>	
                            
                        </div>
										
						</div>
						<!-- <div class="form-group">
							<div class="col-md-12" id="calrdv"></div>
						</div> -->
						<div style="display:flex;justify-content:center">
							<input type="hidden" name="action" id="update-tab" value="update-tab" />
							<!-- <input type="hidden" name="idct" id="idct" value="" />
							<input type="hidden" name="idrdv" id="idrdv" value="" /> -->
							<button type="button pull-right" class="btn btn-sm btn-warning" style="margin-top:10px; margin-right:10px" id="valideemptime" >Valider</button>
							<button href="#" class="btn btn-sm btn-default pull-right"  style="margin-top:10px" data-dismiss="modal">Fermer</button>
							<!-- <button class="btn btn-sm btn-primary" id="btaddrdv" type="submit">Valider</button> -->
						</div>
						
						
					</form>	
					
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="text-right display-none" id="blksigndoc" style="padding:15px 15px 0;">
					<a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> Signer le document</a>
				</div>
				<div class="modal-body" style="height: 100vh">
					<iframe src="" style="width:100%;height:100%;"></iframe>
					<input type="hidden" id="view_id_docs" />
				</div>
			</div>
		</div>
	</div>
	
</div>
		

<?php include 'including/footPage.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="jscript/helpers/excanvas.min.js"></script><![endif]-->
<script src="jscript/jsplug.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>

<script>
	$(document).ready(function(){
        $('.btimp').click(function(){
            $('#modal-tab').modal();
        })
   

		var infotosubmit = true;
		var nameDocSign = '';
		var typeDocSign = '';

		function getNameDoc(name){
			// console.log('name : ',name)
			nameDocSign = name;
			nameDocSign = nameDocSign.substr(nameDocSign.lastIndexOf('/')+1);
			nameDocSign = nameDocSign.substr(0,nameDocSign.indexOf('pdf')-1);
		}

		$('#day_deb').keyup(function(){
			$('#day_end').val($('#day_deb').val())
		})

		$('#day_deb').change(function(){
			$('#day_end').val($('#day_deb').val())
		})

		$('#formulairetab').submit(function() {
			HoldOn.open();
				jQuery(this).ajaxSubmit({
					dataType: 'json',
					success: function(resp) {
						if (resp.responseAjax == 'SUCCESS') {
							$('#modal-tab').modal('hide');
							
							if (resp.id_doc > 0)
								$('#view_id_docs').val(resp.id_doc);
							else
								$('#view_id_docs').val('');


							$('#modal-pdf iframe').attr('src', resp.doc);

							getNameDoc(resp.doc);
							typeDocSign = 'de sous traitance';

							if (resp.cansign == '1')
								$('#blksigndoc').removeClass('display-none');
							else
								$('#blksigndoc').addClass('display-none');

							$('#modal-pdf').modal();
						
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
						HoldOn.close();
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
               
						HoldOn.close();
					// error: function(jqXHR, textStatus){
					// 	console.log('NO',jqXHR, textStatus);
					// 	HoldOn.close();
					}
				});
				return false;
			});
	})

</script>