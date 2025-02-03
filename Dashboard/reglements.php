<?php include 'including/config.php'; ?>


<?php
    
    if (isset($_GET['refreshRglt']) && $_GET['refreshRglt'] == 'R' ){
		die(json_encode(array('html' => Grid4PHP::getGrid('details_reglements', $usrActif->cursoc, $_GET['idfiche']))));
	}
    
    $outpaie = Grid4PHP::getGrid('db_reglements', $usrActif->cursoc);
    $outdetails = Grid4PHP::getGrid('details_reglements', $usrActif->cursoc);

    
?>
<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="css/menu.css">

<div id="page-content" class="page-contact">
	
	<div class="content-header">
		<?php include('including/mainMenu.php'); ?>
	</div>
		
  <div id="tabs-page" class="tabs-page">
      <h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Paiements" : "Payments") ?></h2>
  </div><!-- ./ tabs page -->
  
  
    
  <div class="tabs-page">
    <!-- Tab panes -->
    <div class="tab-content">
      <div  class="" id="virement">
        <a href="#" class="btn btn-primary" id="addrglt" name="addrglt"><i class="fa fa-plus"></i></a>
        
        <div class="table-responsive">
            <?php echo $outpaie ?>
        </div>
        <div class="form-group pull-right">														
            <label for="tot_rglt" class="control-label col-md-6"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tot. règlt(s) Saisi(s)' : 'Tot. recorded paymt(s) ') ?> </label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="tot_rglt" id="tot_rglt" value="" readonly>
            </div>
        </div>
      </div>
      <div  class="" id="details"  style="display:none">
        <a href="#" class="btn btn-primary" id="retourrglt" name="retourrglt"><i class="fa fa-arrow-left"></i></a>
        <div class="table-responsive" id="htmlRglt">
            <?php echo $outdetails ?>
        </div>
        <div class="form-group pull-right">														
            <label for="tot_rglt_det" class="control-label col-md-3"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tot. règlt saisi(s)' : 'Tot. paymt entered') ?> </label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="tot_rglt_det" id="tot_rglt_det" value="" readonly>
            </div>
            <label for="tot_rglt_det_validate" class="control-label col-md-3"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tot. règlt(s) validé(s)' : 'Tot. Validated paymt(s)') ?> </label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="tot_rglt_det_validate" id="tot_rglt_det_validate" value="" readonly>
            </div>
        </div>
      </div>


        <div id="modal-rglt" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:42%;">
                <div class="modal-content" style="height: 250px;">

                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-calendar"></i> Règlement <span id="dtd"></span></h2>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return false;" class="form-horizontal" method="post" action="appajax.php" id="formulairerglt" style="margin-top: 0px;">
                            <div class="form-group">
                                <div class="col-md-12" style="display:flex">
                                <div class="col-md-3">
                                    <label for="" >Client :</label>

                                    <select class="form-control" name="selfiche" id="selfiche">
                                        <option value="0"></option>
                                        <?php $clts = Fiche::getAll(array('id_organisateur'=>$usrActif->cursoc));
                                            foreach ($clts as $clt) {
                                                echo '<option value="'.$clt['id_fiche'].'">'.$clt['last_name'].' '.$clt['first_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" >Montant :</label>
                                    <input type="text" id="mtrglt" name="mtrglt" value="" class="form-control" style="">
                                </div>
                                <div class="col-md-3">
                                    <label for="" >Mode de paiement :</label>                                 
                                    <select class="form-control" name="selmoderglt" id="selmoderglt">
                                        <option value="0">Non définie</option>
                                        <option value="1">Espèce</option>
                                        <option value="2">Cb lien</option>
                                        <option value="3">Cb Carte</option>
                                        <option value="4">Chèque</option>
                                        <option value="5">Virement</option>
                                        <option value="6">Ancv</option>
                                        <option value="7">Shkalim</option>
                                        <option value="8">Chnéor</option>
                                        <option value="9">Ezriel</option>
                                        <option value="10">Avrum</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="switch switch-primary">
                                        <input type="checkbox" id="isvalidate" name="isvalidate"><span></span>
                                    </label>Montant validé
                                </div>
                            </div>

                            <div class="form-group form-actions">
                                <div class="col-md-12 text-center" style="margin-top:26px">
									<input type="hidden" name="action" id="action" value="add-rglt" />
                                    <button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
                                    <button class="btn btn-sm btn-primary" id="btokrglt" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
                                </div>
                            </div>
                        </form>
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
<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>

<script>
	
	$(document).ready(function() {
        initField();

        function initField(){
            HoldOn.open();
            $.post('appajax.php', {action: 'get-rglt-init'}, function(resp) {
                if (resp.responseAjax == "SUCCESS") {
                    
                    $('#tot_rglt').val(resp.sumglob);
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
        }

        $(document).on('click','.btmodrglt, .btdetrglt, .btdelrglt', function(){
            var idfiche = $(this).attr('data-id');

            HoldOn.open();
            $.post('appajax.php', {action: 'get-rglt-det',idct: idfiche}, function(resp) {
                if (resp.responseAjax == "SUCCESS") {
                    
                    $('#tot_rglt_det').val(resp.sumdet);
                    $('#tot_rglt_det_validate').val(resp.sumdetvalide);
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


           $('#virement').hide()
           $('#details').show()
          
            // setTimeout(() => {
                $.get('reglements.php', {refreshRglt: 'R', idfiche:idfiche}, function(resp) {
                $('#htmlRglt').html(resp.html);
                }, 'json');

                return false;
            // }, 500);
            
        })

        $('#retourrglt').click(function(){
           $('#virement').show()
           $('#details').hide()
           $('#list_rglt').trigger("reloadGrid",[{current:true}]);
        })
        
        $('#addrglt').click(function(){
           $('#modal-rglt').modal('show')
        })

        $('#formulairerglt').submit(function() {
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType: 'json',
				success: function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						
                        $.bootstrapGrowl('<h4>Confirmation!</h4> <p>'+resp.message+'</p>', {
                            type: 'success',
                            delay: 5000,
                            offset: {
                            from: "top",
                            amount: 100
                                },
                                align: "center",
                            allow_dismiss: true
                        });
						
                        $('#list_rglt').trigger("reloadGrid",[{current:true}]);
                        $('#tot_rglt').val(resp.sumglob);
						
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
    })

</script>