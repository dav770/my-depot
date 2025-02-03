<?php include 'including/config.php'; ?>
<?php 
	if(isset($_GET['idcli'])){
		die(json_encode(array('html' => Grid4PHP::getGrid('db_extraactivite', $usrActif->cursoc,  $usrActif->id_usrApp, (int)$_GET['idcli']))));
	}else{
		$extra =  Grid4PHP::getGrid('db_extraactivite', $usrActif->cursoc,  $usrActif->id_usrApp);
	}
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
			<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Activités' : 'Activities') ?></strong></h2>
        </div>
	
        <div class="row">
			
			<div class="col-md-12 col-lg-12">
				<div class="block-options pull-right" id="idmob"> 
					
					<div class="btn-group btn-group-sm">
								
					
						
					</div>

				</div>
			
				<!-- <div style="display: flex;margin-bottom:15px">
					
					<a href="javascript:void(0)" class="btn btn-sm btn-info btn-alt" id="btaddview" data-toggle="tooltip" title="Sauvegarder la nouvelle vue"><i class="fa fa-floppy-o"></i></a>&nbsp;
					<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-alt" id="btdelview" data-toggle="tooltip" title="Supprimer une vue"><i class="fa fa-trash"></i></a>&nbsp;
					<select data-show-content="true" class="" id="idviewliste">
						<option value="">Liste des modeles enregistrés</option>
					</select>
				</div> -->
					
				
			</div>
			<div class="col-md-12 col-lg-12">
				<div id="gridextra" class="row push table-responsive">
					<?php echo $extra; ?>
				</div>
			</div>
			<input type="hidden" id="isAppFiche" value="<?php echo isset($_SESSION['idAppFiche']) && (int)$_SESSION['idAppFiche'] > 0 ? (int)$_SESSION['idAppFiche'] : 0 ?>">
			<input type="hidden" id="isAppFlag" value="<?php echo isset($_SESSION['idAppFiche']) && (int)$_SESSION['idAppFiche'] > 0 ? (int)$_SESSION['idAppFiche'] : 0 ?>">
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

    <div id="modal-rglt" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-money"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount') ?></h2>
				</div>
				<div class="modal-body" style="height: 30vh">
					<div class="form-group">
                        <label class="col-md-2 control-label" for="prixextra"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prix activité' : 'Price activity') ?></label>
						<div class="col-md-2">
                            <input type="number" min="0" max="100000" step="0.01" class="form-control"  value="" id="prixextra" name="prixextra" readonly/>
						</div>
                        <div class="col-md-4"></div>
                        <label class="col-md-2 control-label" for="payeextra"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'déjà payé' : 'already paid') ?></label>
						<div class="col-md-2">
							<input type="number" min="0" max="100000" step="0.01" class="form-control"  value="" id="payeextra" name="payeextra" readonly/>
						</div>
					</div>
					<div class="form-group">
                        <label class="col-md-2 control-label" for="rgltextra"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mt règlement (s\'ajoute au déjà payé)' : 'Amount (adds to the already paid)') ?></label>
                        <div class="col-md-2">
                            <input type="number" min="0" max="100000" step="0.5" class="form-control"  value="" id="rgltextra" name="rgltextra" />
						</div>
                        <div class="col-md-4"></div>
                        <label class="col-md-2 control-label" for="resteextra"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Restant' : 'Raimaining') ?></label>
                        <div class="col-md-2">
                            <input type="number" min="0" max="100000" step="0.01" class="form-control"  value="" id="resteextra" name="resteextra" readonly/>
                        </div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:15px;margin-top:15px">
							<input type="hidden" name="idextra" id="idextra" value="0" />
							<input type="hidden" name="idficheextra" id="idficheextra" value="0" />
							<input type="hidden" name="idsejourextra" id="idsejourextra" value="0" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<button class="btn btn-sm btn-primary" id="btokamount" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
					</div>
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
		setTimeout(() => {
			initExtra();
		}, 500);

		
		$(document).on('mouseup', '#gs_id_fiche', function(){
			if($(this).val() == '' && $('#isAppFlag').val() != '0'){
				$.get('extra.php', {idcli:'0',}, function(resp) {
					$('#gridextra').html(resp.html);	
				}, 'json');
				
				return false;
			}
		})

		

		function initExtra(){
			if($('#isAppFiche').val() != '0'){
				
				$.get('extra.php', {idcli:$('#isAppFiche').val(),}, function(resp) {
					// console.log('hh',saveIdFiche)
			
					$('#gridextra').html(resp.html);
					$('#gs_id_fiche').val($('#isAppFiche').val());
					
					$('#isAppFiche').val('0')
					<?php unset($_SESSION['idAppFiche']); ?>


				}, 'json');

			}

			return false;
		}


		var mtRgltPrec = 0;
		var mtPayePrec = 0;
		var mtRestPrec = 0;

        $(document).on('click','.btrglt',function(){
            let idct = $(this).attr('data-idct');
            let idsej = $(this).attr('data-sej');
            let idextra = $(this).attr('data-id');

            HoldOn.open();
			$.post('appajax.php', {
					action: 'recup-rglt-extra', 
					idct:idct,
					idsej:idsej,
					idextra:idextra,
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#prixextra').val(Math.round(parseFloat(resp.prixextra)))
					$('#resteextra').val(Math.round(parseFloat(resp.resteextra)))
					$('#payeextra').val(Math.round(parseFloat(resp.payeextra)))
					if(parseFloat($('#resteextra').val()) < 0){
						$('#resteextra').css({'background-color':'red'})
					}else{
						$('#resteextra').css({'background-color':'default'})
					}

					$('#idextra').val(idextra)
					$('#idficheextra').val(idct)
					$('#idsejourextra').val(idsej)

					mtPayePrec = Math.round(parseFloat(resp.payeextra));
					mtRestPrec = Math.round(parseFloat(resp.resteextra));

					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "right",
						allow_dismiss: true
					});

                    $('#modal-rglt').modal()
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

        $(document).on('click','#btokamount',function(){
            
            HoldOn.open();
			$.post('appajax.php', {
					action: 'add-rglt-extra', 
					prixextra:$('#prixextra').val(),
					mtrglt:$('#rgltextra').val(),
					payeextra:$('#payeextra').val(),
                    idficheextra:$('#idficheextra').val(),
					idsejourextra:$('#idsejourextra').val(),
					idextra:$('#idextra').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {

					if(parseFloat($('#resteextra').val()) < 0){
						$('#resteextra').css({'background-color':'red'})
					}else{
						$('#resteextra').css({'background-color':'default'})
					}

					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "right",
						allow_dismiss: true
					});

                    $('#modal-rglt').modal('hide')
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

        $(document).on('keyup','#rgltextra', function(){
			// on reinitialise les montants a chaque changement du reglement ajouté , afin de recalculer sur la base initiale restante
			$('#resteextra').val( parseFloat(mtRestPrec) )
			$('#payeextra').val( parseFloat(mtPayePrec) )

            $('#resteextra').val( parseFloat($('#prixextra').val()) - parseFloat($('#payeextra').val()) - ($(this).val() == '' || isNaN($(this).val()) ? 0 : parseFloat($(this).val())) )
            $('#payeextra').val( parseFloat($('#payeextra').val()) + ($(this).val() == '' || isNaN($(this).val()) ? 0 : parseFloat($(this).val())) )

        })

        $(document).on('change','#rgltextra', function(){
           // on reinitialise les montants a chaque changement du reglement ajouté , afin de recalculer sur la base initiale restante
			$('#resteextra').val( parseFloat(mtRestPrec) )
			$('#payeextra').val( parseFloat(mtPayePrec) )
			
            $('#resteextra').val( parseFloat($('#prixextra').val()) - parseFloat($('#payeextra').val()) - ($(this).val() == '' || isNaN($(this).val()) ? 0 : parseFloat($(this).val())) )
            $('#payeextra').val(parseFloat($('#payeextra').val()) + ($(this).val() == '' || isNaN($(this).val()) ? 0 : parseFloat($(this).val())) )

        })

		var nameDocSign = '';
		var typeDocSign = '';

		function getNameDoc(name){
			// console.log('name : ',name)
			nameDocSign = name;
			nameDocSign = nameDocSign.substr(nameDocSign.lastIndexOf('/')+1);
			nameDocSign = nameDocSign.substr(0,nameDocSign.indexOf('pdf')-1);
		}

		
	});

		
	function gridcts_onload(ids) {	
		if(ids.rows) 
			jQuery.each(ids.rows,function(i) {
				console.log('llll',$('.btn-group').parent().prev());
				if (this.status_color != '' && this.status_color != undefined)	
					jQuery('#list_extras tr.jqgrow:eq('+i+')').css('background-image','inherit').css({'background-color':this.status_color});
			});
			
		$('.btn-group').parent().css({'background-color':'white'});
		$('.btn-group').parent().prev().css({'background-color':'white'});
		$('.btn-group').parent().prev().prev().css({'background-color':'white'});
		$('.ui-pg-selbox').val(jQuery('#list_extras').getGridParam('rowNum'));
		jQuery('#list_extras').jqGrid('resetSelection');
	}

	
</script>

