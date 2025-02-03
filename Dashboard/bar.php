<?php include 'including/config.php'; ?>
<?php 
	if(isset($_GET['idct'])){
		$idctGrd = (int)$_GET['idct'];
		// $_SERVER['REQUEST_URI'] = '/Dashboard/bar.php';
		// $_GET['idct'] = 0;
		die(json_encode(array('html' => Grid4PHP::getGrid('db_bar', $usrActif->cursoc,  $usrActif->id_usrApp, (int)$idctGrd))));
	}else{
		$bar =  Grid4PHP::getGrid('db_bar', $usrActif->cursoc,  $usrActif->id_usrApp);
	}
	$mtypes = ModelMail::find("");
	$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));

?>

<?php include 'including/headPage.php'; ?>
<link rel="stylesheet" href="css/menu.css">
<script>
			var opts = {
				'ondblClickRow': function (id) {
					if (jQuery(this).attr('id') == 'list_bar') {
						
						return false;
					}
				}

			};
</script>

<style>
/* #list_bar td {
    pointer-events: none;
} */

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

	#id_fiche_select_chosen {
		box-shadow: 3px 8px #876848 !important;
		border: 1px solid black !important;
	}
</style>


<div id="page-content" class="">
   
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?> 
    </div>
   
    <div class="block full">
        <div class="block-title">
			<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Bar' : 'Bar') ?></strong></h2>
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
			<div class="form-group">
				<div class="col-md-12" style="height: 80px;">
					<div class="col-md-1"></div>
					<div class="col-md-11">
						<div class="form-group col-sm-2">
							<div style="height:8px">
								<span class="label label-info" style="font-size:15px; margin-bottom:15px; margin-top:15px;width: 230px;display: block;" id="totbar">
									Total en attente : 0.00 €
								</span>&nbsp;
							</div>							
						</div>
						<div class="form-group col-sm-2">
						</div>
						<div class="form-group col-sm-2">
						</div>
						<div class="form-group col-sm-2">
							<div style="height:8px">
								<select data-placeholder="Choix..." class="form-control select-chosen" id="id_fiche_select" name="id_fiche_select" >
									<option value="">---</option>
									<?php
									$cls = Fiche::getAll(array('id_organisateur'=>$usrActif->cursoc));
									if ($cls) {
										foreach ($cls as $cl) {
											echo '<option value="' . $cl['id_fiche'] . '">' . $cl['last_name'].' '.$cl['first_name'] . '</option>';
										}
									}
									?>
								</select>
								&nbsp;
							</div>
						</div>
						<div class="form-group col-sm-1" style="display:none">
							<div style="height:8px">
								<!-- <span class="label" style="background-color: rgb(181, 125, 209);font-size:15px; margin-bottom:15px; margin-top:15px;width: 230px;display: block;" id="tothtr2"> -->
									<a href="#" class="btn btn-warning" id="btsolde" style="padding:3px !important"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Solde client' : 'Customer balance') ?></a>
								<!-- </span>&nbsp; -->
							</div>
						</div>
						
						<div class="form-group col-sm-2">
							<div style="height:8px">
								<span class="label" style="background-color: rgb(181, 125, 209);font-size:15px; margin-bottom:15px; margin-top:15px;width: 230px;display: block;" id="totselbar">
									Solde demandé : 0.00 €
								</span>&nbsp;
							</div>
						</div>
						<div class="form-group col-sm-1" style="display:none" id="rgltSolde">
							<div style="height:8px">
								<!-- <span class="label" style="background-color: rgb(181, 125, 209);font-size:15px; margin-bottom:15px; margin-top:15px;width: 230px;display: block;" id="tothtr2"> -->
									<a href="#" class="btn btn-info" id="btpaid" style="padding:3px !important"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Paiement solde' : 'Bbalance payment') ?> </a>
								<!-- </span>&nbsp; -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-12">
				<div id="idbar" class="row push table-responsive">
					<?php echo $bar; ?>
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
					<h2 class="modal-title"><i class="fa fa-money"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Paiement solde' : 'Bbalance payment') ?></h2>
				</div>
				<div class="modal-body" style="height: 30vh">
					<div class="form-group">
                        <label class="col-md-2 control-label" for="soldereste"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Solde client' : 'Customer balance') ?></label>
						<div class="col-md-2">
                            <input type="text" class="form-control"  value="0.00" id="soldereste" name="soldereste" readonly/>
						</div>
                        <div class="col-md-4"></div>
                        <label class="col-md-2 control-label" for="paidsolde"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount') ?></label>
						<div class="col-md-2">
							<input type="text" class="form-control"  value="0.00" id="paidsolde" name="paidsolde"/>
						</div>
					</div>
					
					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:15px;margin-top:15px">
							<input type="hidden" name="idfichesolde" id="idfichesolde" value="0" />
							<input type="hidden" name="idsejoursolde" id="idsejoursolde" value="0" />
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
		// $('.ui-icon-plus').click(function(){
		// 	console.log('add', $(this))

		// 	setTimeout(function() {
		// 		var addgrid = document.getElementById("sData");
	
		// 		addgrid.addEventListener("click", function(){
		// 			console.log('add 22')
		// 			majTarifsDetails();
		// 		});
		// 	}, 1000);

		// 	// return false;
		// })
		
		initBar();

		function initBar(){
			$.post('appajax.php', {action:'get-tot-reste-bar', }, function(resp) {
				
				if (resp.responseAjax == 'SUCCESS') {
					$('#totbar').text('Total en attente : '+resp.totgl+' €');										
				}
				else
				if (resp.responseAjax == 'ERROR')
					$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
						type: 'danger',
						delay: 2500,
						allow_dismiss: true
					});
	
			}, 'json'); 

			if($('#isAppFiche').val() != '0'){
				
				$('#id_fiche_select').val($('#isAppFiche').val())
				$('#id_fiche_select').trigger("chosen:updated");
				$('#gs_id_fiche').val($('#id_fiche_select').val());
				<?php unset($_SESSION['idAppFiche']); ?>
				$('#isAppFiche').val('0')
				setTimeout(() => {
					$('#btsolde').click()
				}, 700);
			}

			return false;
		}

		$(document).on('click', '.cbox', function(){
			
			let cbx = false;
			let tb = '';
			let dtrange = '';
			let dtstart = 0;
			let dtsend = 0;
			let team = 0;
			let nametb = '';
			
			if($(this).parent().parent().attr('aria-selected')){
				cbx = true;
			}else{
				cbx = false;
			}

			var grid = $("#list_bar");
			var filt = grid.getGridParam("postData").filters;				

			selrows = $('#list_bar').jqGrid('getGridParam','selarrrow');

			$.post('appajax.php', {action:'get-tot-sel-bar2', 
									filter:filt, 
									idct:"0",
									selrows : selrows}, function(resp) {
					
					if (resp.responseAjax == 'SUCCESS') {
										
						$('#totselbar').text('Total sélection : '+resp.totsel+' €');						
					}
					else
					if (resp.responseAjax == 'ERROR')
						$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
							type: 'danger',
							delay: 2500,
							allow_dismiss: true
						});

				}, 'json'); 
				
				return false;
		})

		$('#id_fiche_select').on('change', function(){
			if($('#id_fiche_select').val() == ''){
				$('#totselbar').text('Solde demandé : 0.00 €');	
				
				$('#rgltSolde').css('display', 'none')
				$('#isAppFlag').val('0') 
			}
			$('#btsolde').click()
		})
		
		// evenement change de la grille provoque immediatement le get
		var isReset = 0;

		$(document).on('blur input', '#gs_id_fiche', function(){
			console.log('blur input gs_id_fiche',$(this).val())
			if($(this).val() == ''){
				
				$('#id_fiche_select').val('')
				$('#id_fiche_select').trigger("chosen:updated");
				$('#totselbar').text('Solde demandé : 0.00 €');	
				$('#rgltSolde').css('display', 'none')
				$('#isAppFlag').val('0') 
				isReset = 0;		
				$('#btsolde').click()		
			}else{
				$('#isAppFlag').val($(this).val());
				$('#id_fiche_select').val($(this).val())
				$('#id_fiche_select').trigger("chosen:updated");

				$.post('appajax.php', {action:'get-tot-sel-bar', 
									idct: $(this).val(),
									}, function(resp) {
					
					if (resp.responseAjax == 'SUCCESS') {
						if(parseFloat(resp.totsel) > 0){
							$('#rgltSolde').css('display', 'block')
							$('#soldereste').val(resp.totsel)
						}else{
							$('#rgltSolde').css('display', 'none')
							$('#soldereste').val(0)
						}			
						$('#totselbar').text('Solde demandé : '+resp.totsel+' €');	
					}
					else
					if (resp.responseAjax == 'ERROR')
						$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
							type: 'danger',
							delay: 2500,
							allow_dismiss: true
						});

				}, 'json');
			
			}
			
			// return false;
		})
		// $(document).on('click', '#gs_id_fiche', function(){
		// 	console.log('click gs_id_fiche',$('#isAppFlag').val())
		// 	if(isReset == '0'){
		// 		$('#id_fiche_select').val('')
		// 		$('#id_fiche_select').trigger("chosen:updated");
		// 		$('#totselbar').text('Solde demandé : 0.00 €');	
		// 		$('#rgltSolde').css('display', 'none')
		// 	}
		// 	return false;
		// })
		// $(document).on('mouseup', '#gs_id_fiche', function(){
		// 	console.log('mouse up',$(this).val(), $('#isAppFlag').val())
		// 	if($(this).val() == '' && $('#isAppFlag').val() != '0'){
		// 		console.log('mouse not else',$(this).val(), $('#isAppFlag').val())
		// 		$('#isAppFlag').val('0') 
		// 		isReset = 0;

		// 		$.get('bar.php', {idct:'0',}, function(resp) {
					
		// 			$('#idbar').html(resp.html);
		// 			$('#gs_id_fiche').val($('#id_fiche_select').val());
					
		// 			// const url = new URL('https://crm-hotel.dev-customer.com/Dashboard/bar.php?idct='+$('#id_fiche_select').val());
		// 			// const params = new URLSearchParams(url.search);
		// 			// params.delete("idct");
	
		// 		}, 'json');
				
		// 		return false;
		// 	}
		// 	else{
		// 		if($(this).val() != ''){
		// 			console.log('mouse else',$(this).val(), $('#isAppFlag').val())
		// 			$('#isAppFlag').val($(this).val());
		// 			$('#id_fiche_select').val($(this).val())
		// 			$('#id_fiche_select').trigger("chosen:updated");

		// 			$.post('appajax.php', {action:'get-tot-sel-bar', 
		// 							idct: $(this).val(),
		// 							}, function(resp) {
					
		// 				if (resp.responseAjax == 'SUCCESS') {
		// 					if(parseFloat(resp.totsel) > 0){
		// 						$('#rgltSolde').css('display', 'block')
		// 						$('#soldereste').val(resp.totsel)
		// 					}else{
		// 						$('#rgltSolde').css('display', 'none')
		// 						$('#soldereste').val(0)
		// 					}			
		// 					$('#totselbar').text('Solde demandé : '+resp.totsel+' €');	
							
							
		// 					$.get('bar.php', {idct:$('#isAppFlag').val(),}, function(resp) {
								
		// 						$('#idbar').html(resp.html);
		// 						$('#gs_id_fiche').val($('#isAppFlag').val());
								
		// 						// const url = new URL('https://crm-hotel.dev-customer.com/Dashboard/bar.php?idct='+$('#id_fiche_select').val());
		// 						// const params = new URLSearchParams(url.search);
		// 						// params.delete("idct");
				
		// 					}, 'json');
		// 				}
		// 				else
		// 				if (resp.responseAjax == 'ERROR')
		// 					$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 						type: 'danger',
		// 						delay: 2500,
		// 						allow_dismiss: true
		// 					});

		// 			}, 'json'); 
		// 		}
				
				
		// 		return false;
		// 	}
		// })

		$(document).on('click', '#btsolde', function(){
			
			$.post('appajax.php', {action:'get-tot-sel-bar', 
									idct:$('#id_fiche_select').val(),
									}, function(resp) {
					
					if (resp.responseAjax == 'SUCCESS') {
						if(parseFloat(resp.totsel) > 0){
							$('#rgltSolde').css('display', 'block')
							$('#soldereste').val(resp.totsel)
						}else{
							$('#rgltSolde').css('display', 'none')
							$('#soldereste').val(0)
						}			
						$('#totselbar').text('Solde demandé : '+resp.totsel+' €');						
					}
					else
					if (resp.responseAjax == 'ERROR')
						$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
							type: 'danger',
							delay: 2500,
							allow_dismiss: true
						});

				}, 'json'); 
				
			$.get('bar.php', {idct:$('#id_fiche_select').val(),}, function(resp) {
				
				$('#idbar').html(resp.html);
				$('#gs_id_fiche').val($('#id_fiche_select').val());
				
				// const url = new URL('https://crm-hotel.dev-customer.com/Dashboard/bar.php?idct='+$('#id_fiche_select').val());
				// const params = new URLSearchParams(url.search);
				// params.delete("idct");

			}, 'json');

			return false;
		})
		
		$(document).on('change','#id_produit',function(){
			$.post('appajax.php', {action: 'read-tarif-bar', app:'P', idprod:$(this).val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#prix_produit_bar').val(resp.tarif)
					$('#mt_du_bar').val(resp.tarif * $('#qte_bar').val())
					$('#prix_paye_bar').val(0)
					$('#prix_reste_bar').val(resp.tarif * $('#qte_bar').val())
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

		$(document).on('click', '#btpaid', function(){
			$('#modal-rglt').modal('show')
			
		})
		// Ajouter un écouteur d'événement sur les champs `qte_bar`
		// document.addEventListener('keyup', function (event) {
		// 	console.log($('#id_bar').val())
		// 	// Vérifier si l'élément modifié est un champ `qte_bar`
		//     if (event.target && event.target.id === 'qte_bar') {
		// 		// Trouver le parent le plus proche (par exemple, une ligne <tr>)
		//         var parentRow = event.target.closest('tbody');
				
		//         if (parentRow) {
		// 			// Trouver le <select> avec l'id `id_produit` dans la même ligne
		//             var relatedSelect = parentRow.querySelector('select#id_produit');
		// 			console.log(relatedSelect.selectedIndex)
					
		//             if (relatedSelect) {
		//                 // Récupérer la valeur et le texte de l'option sélectionnée
		//                 var selectedValue = relatedSelect.value;
		//                 var selectedText = relatedSelect.options[relatedSelect.selectedIndex].text;

		//                 // Affichage pour débogage
		//                 console.log('Valeur sélectionnée :', selectedValue);
		//                 console.log('Texte sélectionné :', selectedText);
		//             } else {
		//                 console.error("Aucun select avec l'id 'id_produit' trouvé dans la ligne.");
		//             }
		//         } else {
		//             console.error("Impossible de trouver la ligne parent.");
		//         }
		//     }
		// });


		$(document).on('keyup','#qte_bar',function(){
			
			$.post('appajax.php', {action: 'read-tarif-bar', app:'Q', idprod:$('#id_produit').val(), qte:$('#qte_bar').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#mt_du_bar').val(resp.mtdu)

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
				
			
			return false;
			
		})

		$(document).on('keyup','#prix_paye_bar',function(){
			$.post('appajax.php', {action: 'read-tarif-bar', app:'R', idprod:$('#id_produit').val(), qte:$('#qte_bar').val(), mt:$('#prix_paye_bar').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#prix_reste_bar').val(resp.mtreste)

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

		$(document).on('click','#btokamount',function(){
			$.post('appajax.php', {action: 'paid-reste-solde', idct:$('#id_fiche_select').val(), idsejour:<?php echo $usrActif->cursoc ?>, mt:$('#paidsolde').val() , totreste:$('#soldereste').val()}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#btsolde').click()
					$('#totbar').text('Total en attente : '+resp.totgl+' €');
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
				
			$('#modal-rglt').modal('hide')
			return false;
			
		})
	})

	// $("#list_bar").jqGrid('setGridParam', {
	// 	ondblClickRow: function(rowid, iRow, iCol, e) {
	// 		console.log('jj')
	// 		return false;
	// 	}
	// });

	// function gridcts_onload(ids) {	
	// 	if(ids.rows) 
	// 		jQuery.each(ids.rows,function(i) {
	// 			console.log('llll',$('.btn-group').parent().prev());
	// 			if (this.status_color != '' && this.status_color != undefined)	
	// 				jQuery('#list_bar tr.jqgrow:eq('+i+')').css('background-image','inherit').css({'background-color':this.status_color});
	// 		});
			
	// 	$('.btn-group').parent().css({'background-color':'white'});
	// 	$('.btn-group').parent().prev().css({'background-color':'white'});
	// 	$('.btn-group').parent().prev().prev().css({'background-color':'white'});
	// 	$('.ui-pg-selbox').val(jQuery('#list_bar').getGridParam('rowNum'));
	// 	jQuery('#list_bar').jqGrid('resetSelection');
	// }

	// $("table.ui-jqgrid-btable").jqGrid({
    //     onCellEdit: function (rowid, cellname, value, iRow, iCol) {
    //         if (cellname === "qte_bar") {
    //             var prix = parseFloat($("#list_bar").jqGrid("getCell", rowid, "prix_produit_bar"));
    //             var montant = prix * parseFloat(value || 0);
    //             $("#list_bar").jqGrid("setCell", rowid, "mt_du_bar", mt_du_bar.toFixed(2));
    //         }
    //     }
    // });

	
</script>

