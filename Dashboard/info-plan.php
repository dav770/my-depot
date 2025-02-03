<?php include 'including/config.php'; ?>
<?php
if (!isset($_GET['id_mono']))
	header('Location: monos.php');

	

$outdocs = '';
if ($_GET['id_mono'] == '0')
	$curusr = false;
else {

	$curusr = Monos::findOne(array('m.id_mono' => (int)$_GET['id_mono']));
	if ($curusr) {
		// if (!Fiche::checkRight($curusr)){
		// 	header('Location: index.php');
		// }
		$outdocs = Grid4PHP::getGrid('db_contacts_docs', (int)$_GET['id_mono']);
        $plans = Plans::getAll(array('r.id_mono'=>(int)$_GET['id_mono']));
// echo(print_r($plans));
	} else
		header('Location: monos.php');
}

?>


<?php include 'including/headPage.php'; ?>
<link rel="stylesheet" href="css/menu.css">

<!-- Page content -->
<div id="page-content" class="page-contact">
	<!-- eCommerce Dashboard Header -->
	<div class="content-header">
		<?php include('including/mainMenu.php'); ?>
	</div>
	<!-- END eCommerce Dashboard Header -->

	<!-- eShop Overview Block -->
	
	<div class="block full row" >
        <div class="col-lg-4">
			<div class="block">
                <!-- Normal Form Title -->
                <div class="block-title">
                    <h2><strong>Informations</strong> Monos / Enfants</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
			<div class="block">
                <a href="#" class="btn btn-sm btn-success" id="btaddplan" style="margin-right:10px;border-radius:3px;margin-bottom:15px" title="Ajout planing" data-toggle="tooltip"><i class="fa fa-calendar"></i> Ajouter une entrée planing</a>
                <a href="#" data-toggle="tooltip" title="Impression" class="btn btn-sm btn-primary btimp" style="margin-left: 17px;margin-bottom: 15px;"><i class="gi gi-ip"></i>Impression emploi du temps</a>
        
                <div class="form-group">
                <table style="width:100%;text-align: center;"> 
                    <tr>
                        <td colspan="6" style="background-color:#000000; color:#FFFFFF; border:solid 1px #000000;">
                            Organisations
                        </td>
                    </tr>
	                <tr></tr>
                   
                    <tr>
                        <td style="border:solid 1px #000000;background-color:grey;color:yellow">
                            Date
                        </td>
                        <td style="border:solid 1px #000000;background-color:grey;color:yellow">
                            Heure début
                        </td>
                        <td style="border:solid 1px #000000;background-color:grey;color:yellow">
                            Heure Fin
                        </td>
                        <td style="border:solid 1px #000000;background-color:grey;color:yellow">
                            Groupe
                        </td>
                        <td style="border:solid 1px #000000;background-color:grey;color:yellow">
                            Activité
                        </td>
                        <td style="border:solid 1px #000000;background-color:grey;color:yellow">
                            Lieu
                        </td>
                    </tr>
                    <?php 
                        foreach($plans as $plan)
                        {
                        ?>
                            <tr>
                            <td style="border:solid 1px #000000;">
                                <?php echo date('d/m/Y', strtotime($plan['date_rdv'])) ?>
                            </td>
                            <td style="border:solid 1px #000000;">
                                <?php echo $plan['rdv_start'] ?>
                            </td>
                            <td style="border:solid 1px #000000;">
                                <?php echo $plan['rdv_end'] ?>
                            </td>
                            <td style="border:solid 1px #000000;">
                                <?php echo $plan['name_groupe'] ?>
                            </td>
                            <td style="border:solid 1px #000000;">
                                <?php echo $plan['name_activite'] ?>
                            </td>
                            <td style="border:solid 1px #000000;text-align: left;border-right: solid 1px #FFF">
                                <?php echo $plan['lieu_rdv'] ?>
                            </td>
                            <td style="text-align:left" >
                                <a href="" style="margin-bottom:1.3px" class="btn btn-danger btsupp" id="<?php echo $plan['id_rdv'] ?>" >-</a>
                                <a href="" class="btn btn-primary btupdt" id="<?php echo $plan['id_rdv'] ?>" >+</a>
                            </td>
                        </tr>
                    <?php      
                        }
                    ?>
	            </table>
            </div>
        </div>
    </div>

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
					<form onsubmit="return false;" class="form-horizontal" id="formulaireplan" method="post" action="appajax.php">
						
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
								<input type="hidden" name="idmono" id="idmono" value="<?php echo $_GET['id_mono'] ?>" />
								<input type="hidden" name="app" id="app" value="" />
								<input type="hidden" name="idrdv" id="idrdv" value="0" />
                                <input type="hidden" name="action" id="action" value="update-plan" />
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
					<form onsubmit="return false;" class="form-horizontal" id="formulairetab" method="post" action="appajax.php">
						<div class="form-group" style="display:flex;justify-content:center">
							<div class="col-md-3">
								<label for="day_deb" class="control-label">Date arrivée</label>
								<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="day_deb" id="day_deb" value="">
							</div>
							<div class="col-md-3">
								<label for="day_end" class="control-label">Date départ</label>
								<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="day_end" id="day_end" value="">
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
					<!-- <a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> Signer le document</a> -->
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

<script src="jscript/jsplug.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>
<!-- <script src="<?php echo $template['url']; ?>/jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="<?php echo $template['url']; ?>/jscript/helpers/ckeditor/config.js"></script> -->
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
					}
				});
				return false;
			});


    // 
    $('#btaddplan').click(function(){
        console.log('hh')
        $('#modal-plan').modal();
    })


    $(".btsupp").click(function(){
        if(!confirm("Confimez la suppression de la ligne et du planing ?")){
            return false
        }
        HoldOn.open();
			var id = $(this).attr('id');
			
            $.post('appajax.php', {action:'del-rdv-mono', idmono:$('#idmono').val(), idrdv:id}, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    $.bootstrapGrowl('<h4>OK!</h4> <p>' + resp.message + '</p>', {
                        type: 'succes',
                        delay: 5000,
                        offset: {
                        from: "top",
                        amount: 100
                          },
                          align: "center",
                        allow_dismiss: true
                    });

                    window.location.reload();
                } else
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
			
			
        return false
    })

    $(".btupdt").click(function(){
        if(!confirm("Confimez la modification de la ligne et du planing ?")){
            return false
        }
        HoldOn.open();
			var id = $(this).attr('id');
			
            $.post('appajax.php', {action:'read-rdv-mono', idmono:$('#idmono').val(), idrdv:id}, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    $('#hour_start').val(resp.data.rdv_start)
                    $('#hour_end').val(resp.data.rdv_end)
                    let dt = resp.data.date_rdv.split('-')
                    $('#date_fixed').val(dt[2]+'/'+dt[1]+'/'+dt[0])
                    $('#id_activite').val(resp.data.id_activite)
                    $('#id_activite').trigger('chosen:updated')
                    $('#idmono').val($('#idmono').val())
                    $('#lieu').val(resp.data.lieu_rdv)
                    $('#idrdv').val(id)
                    $('#app').val('UPDT')

                    $('#modal-plan').modal();
                } else
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
			
			
        return false
    })

    $('#formulaireplan').submit(function() {
			
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType: 'json',
				success: function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
					
						// $('#list_activites').trigger("reloadGrid",[{current:true}]);
                        window.location.reload();

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
               
					 HoldOn.close();
				}
       
			});
			
			
			return false;
		});
})
</script>
