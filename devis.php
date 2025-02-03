<?php include __DIR__.'/inc/_global/config.php'; ?>
<?php include __DIR__.'/inc/backend/config.php'; ?>
<?php include __DIR__.'/inc/_global/views/head_start.php'; ?>
<?php include __DIR__.'/inc/_global/views/head_end.php'; ?>
<?php include __DIR__.'/inc/_global/views/page_start.php'; ?>

<?php
    require_once __DIR__ . '/including/dbclass.php';

    $contact = false;
    
    if (isset($_GET['CLID'])) {
        $codekey = substr($_GET['CLID'], 0, 8);
        $idct =  substr($_GET['CLID'], 8);
        $contact = Fiche::findOne(array('c.id_fiche' => $idct, 'c.codekey ' => $codekey));

    }
    
    $dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);
		
    $signDevis = '';
		if($sign != ''){
			$signDevis = '<img src="'.__DIR__.'/'.$sign.'" id="img-sign" style="width:200px; height: 100px;">';
		}
		
        
		$sejour = Setting::getOrganisateur(array('id_organisateur'=> $contact->id_organisateur));
        // echo('===>'.$contact->id_organisateur);
		// $organisateur = Setting::getOrganisateurOrg(array('id_organisateur'=> $contact->id_org));

        $arrct = array();
        if((int)$contact->nodevis <= 0){
            $nodevis = Fiche::getLastNoDevis(array());
            $nodevis += 1;
        }else{
            $nodevis = $contact->nodevis;
        }

        $arrct['numdevis'] = 'D_'.date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT);
        $arrct['nodevis'] = $nodevis;

        Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche));

		$ad = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'1'));
		$enf = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'2'));
		$bb = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'3'));
		
		$nbadulte = $ad->num_rows;
		$nbenf = $enf->num_rows;
		$nbbb = $bb->num_rows;

		$logo = 'Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		
		$date1 = new DateTime($contact->date_start);
		$date2 = new DateTime($contact->date_end);

		$jours = $date2->diff($date1)->days;
        // $jours += 1; //inclure le dernier jour
		// echo(print_r($date2->diff($date1)->days));
		// die;

		$semaine = $jours / 7 ;

		$tarifNuit = false;
		$tarifSemaine = false;
		$tarifSejour = false;

		$istarif = InfosGenes::findOne(array('is_inf_gene'=>'1'));
					
		if($istarif->name_tarif == 'is_tarif_nuit'){
			$tarifNuit = true;
		}

		if($istarif->name_tarif == 'is_tarif_sejour'){
			$tarifSejour = true;
		}

		if($istarif->name_tarif == 'is_tarif_semaine'){
			$tarifSemaine = true;
		}

		
		$infchs = Chambres::getAll(array('id_fiche'=>$contact->id_fiche));
		$addTot = 0;
		$descch = '';
		$supch = '';
		$totsupch = 0;

		foreach($infchs as $ch){
			$prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
			if($prixch->tarif_chambre > 0){
				$addTot += $prixch->tarif_chambre;
			}

			$descch .= $prixch->type_chambre.' : '.$prixch->vue_chambre.'<br>';
			$supch .= ($prixch->tarif_chambre > 0 ? $prixch->tarif_chambre.' €<br>' : '');
			$totsupch += $prixch->tarif_chambre;
		}
		
		$htmldetails ='';
		$alldetails = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche));

		$tt = '';
		foreach($alldetails as $details){
			$sumTarif += $details['tarif_details'];
			$sumTarif += $details['tarif_transport'];
			$sumTarif += $details['tarif_supp_detail'];
			
			$libtarifdetail = Tarif::findOne(array('id_tarif'=>$details['libelle_tarif_details']));

            $libTransp = '';
            $prixTransp = 0;
            if((int)$details['transport_detail'] > 0){
                $transp = Tarif::findOneTransport(array('id_transport'=>$details['transport_detail']));
                $libTransp = $transp->lib_transport;
                $prixTransp = $transp->tarif_transport;
            }

            $libopt1 = '';
            $prixopt1 = 0;
            if((int)$details['opt_lib_1'] > 0){
                $optch = Chambres::findOneOptions(array('id_option_chambre'=>$details['opt_lib_1']));
                $libopt1 = $optch->lib_option_chambre;
                $prixopt1 = $optch->tarif_option_chambre;
            }

            $libopt2 = '';
            $prixopt2 = 0;
            if((int)$details['opt_lib_2'] > 0){
                $optch = Chambres::findOneOptions(array('id_option_chambre'=>$details['opt_lib_2']));
                $libopt2 = $optch->lib_option_chambre;
                $prixopt2 = $optch->tarif_option_chambre;
            }
            

			$htmldetails .= '
				<tr>
					<td style="width:70%"">
						1 x '.$libtarifdetail->libelle_tarif.'
					</td>
					<td style="width:30%">
						<b>'.$details['tarif_details'].' €</b>
					</td>
				</tr>
			';

            if($libTransp != ''){
                $htmldetails .= '
				<tr>
					<td style="width:70%"">
						1 x '.$libTransp.'
					</td>
					<td style="width:30%">
						<b>'.$prixTransp.' €</b>
					</td>
				</tr>
			';
            }

            if($libopt1 != ''){
                $htmldetails .= '
				<tr>
					<td style="width:70%"">
						1 x '.$libopt1.'
					</td>
					<td style="width:30%">
						<b>'.$prixopt1.' €</b>
					</td>
				</tr>
			';
            }

            if($libopt2 != ''){
                $htmldetails .= '
				<tr>
					<td style="width:70%"">
						1 x '.$libopt2.'
					</td>
					<td style="width:30%">
						<b>'.$prixopt2.' €</b>
					</td>
				</tr>
			';
            }
            
		};

		if($tarifSemaine){
			$tot = $sumTarif * $semaine;
		}
		if($tarifNuit){
			$tot = $sumTarif * $jours;
		}
		if($tarifSejour){
			$tot = $sumTarif;
		}

		// if($tarifSemaine){
		// 	$tot = (($nbadulte * $tarifAdulte * $semaine) + ($nbenf * $tarifEnf * $semaine) + ($nbbb * $tarifBb * $semaine));
		// }else{
		// 	$tot = (($nbadulte * $tarifAdulte * $jours) + ($nbenf * $tarifEnf * $jours) + ($nbbb * $tarifBb * $jours));
		// }

		$totFinal = (($tot + $addTot) * (100 - $contact->offre_sejour)) / 100;
?>  

<style type="text/css" media="screen,print">      
    body {background-image: url("/Dashboard/img/MH-DEVIS-fond.jpg");
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-position: center;
                    background-size: cover;}        
    .content-header {height: 10rem !important; display:block !important}
    .text-center {margin-top: 15px !important;}
    .cForm {justify-content:center}            
    * {font-family:helvetica;}
    table {border-collapse: collapse; width: 100% ;}
    td { border : none; padding : 5px 5px;}
    .bold{ font-weight: bold}
    .justify {text-align: justify}
</style>

<!-- Hero Content -->
<!-- END Hero Content -->

<!-- Page Content -->
<div class="">
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <?php
                        if (file_exists($logo)) {
                            echo '<img src="'.$logo.'" style="width:200px" />';
                        }    
                    ?> 
                    
                </div>
                <!-- Article Content -->
                <div class="cForm" style="display:flex">
                    <form onsubmit="return false;" class="form-horizontal" method="post" action="publicajax.php" id="formulairedevis">
                        <div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
                        
                            <div style="text-align:center">
                                <h2>DEVIS DEMO SOC</h2>
                                <span style="font-size:20px;;vertical-align: middle;">Devis numéro : <b><?php echo 'D_'.date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT) ?></b></span>
                            </div>
                            <p>	
                                Chère Madame, cher Monsieur,<br><br>
                                Suite à votre demande, vous trouverez ci-après le devis de DEMO SOC pour Pessah 2023 en Crète (Hors vols) :
                                <!-- Ci-joint le devis demandé pour un séjour du <?php echo date('d/m/Y', strtotime($contact->date_start)).' au '.date('d/m/Y', strtotime($contact->date_end)) ?>, en vous souhaitant bonne réception.<br> -->
                            </p>
                        
                            <table class="center">
                                <tr>
                                    <td style="width:70%">
                                        <b>PANIER</b>
                                    </td>
                                    <td style="width:30%">
                                        <b>PRIX</b>
                                    </td>
                                </tr>	
                                    <?php echo $htmldetails ?>
                            </table>
                            <br>
                            <table class="">
                                <tr>
                                    <td style="width:70%">
                                        <b>TOTAL : </b>
                                    </td>
                                    <td style="width:30%; text-align:left">
                                        <b><?php echo number_format($tot,2).($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ).''.($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' )?></b>
                                    </td>
                                </tr>
                            </table>
                            <br><br>
                        </div>
                
                        <div class="col-md-12" style="margin-top: 10px;">
                            <div class="form-group form-actions">
                                <input type="hidden" name="action" id="action" value="sign-devis" />
                                <button class="btn btn-sm btn-primary" type="submit" id="btupdatedevis"><i class="fa fa-user"></i> Valider</button>
                                <button class="btn btn-sm btn-warning" type="reset" id="btresetdevis"><i class="fa fa-repeat"></i> Annuler</button>
                            </div>
                        </div>   

                            
                        <div class="form-group" id="sign-show" style=";border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
                            <p style="padding:5px;margin-top:20px;margin-bottom:5px;font-weight:600" ><b>Le client</b></p>
                            
                            <div class="col-md-12" style="border:solid 1px #ccc;min-height:200px">
                                <b>Le <?php echo date('d/m/Y'); ?></b><br>
                                <b>Signature du client : </b><br><br>
                                <img src="" id="img-sign" style="width:200px; height: 120px;">
                            </div>
                            <br>
                            <br>
                            Signature enregistrée , vous pouvez passer a l'étape suivante
                            <button class="btn btn-sm btn-info" type="submit" id="btetape2"><i class="fa fa-user"></i> Suivante</button>
                        </div>
                    </form>
                </div>


                <!-- <div id="modal-sign" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"> -->
                <div id="modal-sign" class="modal fade" id="modal-block-tabs-alt" tabindex="-1" role="dialog" aria-labelledby="modal-block-tabs-alt" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h2 class="modal-title"><i class="fa fa-pencil"></i> Signature du document</h2>
                            </div>
                            <div class="modal-body">
                                <label>Veuillez dessiner votre signature ci dessous :</label>
                                <div class="signbox">
                                    <canvas height="250" width="550"></canvas>
                                </div>
                                                                                
                            </div>
                            <div class="modal-footer"> 
                                <input type="hidden" id="idct" name="idct" value="<?php echo $contact ? $contact->id_fiche : '0'; ?>" />
                                <input type="hidden" id="codekey" name="codekey" value="<?php echo $contact ? $contact->codekey : ''; ?>" />
                                <button type="button" id="clearsignbox" class="btn btn-sm btn-danger pull-left"><i class="gi gi-cleaning"></i> Effacer</button>  
                                <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-sm btn-primary" id="btsign"><i class="fa fa-pencil"></i> Valider</button>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h2 class="modal-title"><i class="fa fa-check text-success"></i> Signature apposé au document</h2>
                            </div>
                            <div class="modal-body">
                                Votre signature a été apposé à votre document. Veuillez télécharger le document signé ci dessous.
                            </div>
                            <div class="modal-footer"> 
                                <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal">Fermer</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <!-- Modal PDF -->
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
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include __DIR__.'/inc/_global/views/page_end.php'; ?>
<?php include __DIR__.'/inc/_global/views/footer_start.php'; ?>
<?php include __DIR__.'/inc/_global/views/footer_end.php'; ?>
<script src='assets/signature_pad.min.js'></script>
<script src='assets/js/lib/jquery.min.js'></script>
<script src='assets/HoldOn.min.js'></script>

<script src="assets/js/oneui.app.min.js"></script>

    <!-- jQuery (required for Bootstrap Notify plugin) -->
    <script src="assets/js/lib/jquery.min.js"></script>
    
    <link href="Dashboard/css/HoldOn.min.css" rel="stylesheet">
    <script src="Dashboard/jscript/HoldOn.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>

    <!-- Page JS Plugins -->
    <script src="assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>

<script>
	
	$(document).ready(function() {

    $(document).attr("title", "Devis");
    $('#page-header').css('display','none')
    $('#page-footer').css('display','none')

    $(document).on('click', '#btetape2', function(){
        window.location.href = 'infos-clients.php?CLID=<?php echo str_replace('#','',$_GET['CLID'])?>'
    })
  

    var signeval = '';
    $('#sign-show').hide();

    $(document).on('click','#btupdatedevis', function(){
      // console.log('jj')
        $('#modal-sign').modal('show'); 
        return false;
    });

    $(document).on('click','#btresetdevis', function(){
        window.location.reload();
    });


    // $('#formulaireevalfroid').submit(function() {
    $(document).on('submit', '#formulairedevis', function() {
        // console.log('ici, <?php echo $typeTheme ?>')
        
        HoldOn.open();
        jQuery(this).ajaxSubmit({
            dataType : 'json',
            data:{
                action:'sign-devis',
                idct:$('#idct').val(), 
                codekey:$('#codekey').val(), 
                sign:signeval, 
                },

            success: function(resp) {
  
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    console.log(resp.doc)
                    $('#modal-pdf iframe').attr('src', resp.doc);
                    $('#modal-pdf').modal();

                } else {
                  alert('Erreur!\n' + resp.message)
                    // $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
                    //     type: 'danger',
                    //     delay: 5000,
                    //     offset: {
                    //     from: "top",
                    //     amount: 100
                    //         },
                    //         align: "center",
                    //     allow_dismiss: true
                    // });
                }
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

    $('#clearsignbox').click(function() {
        if (signaturePad != undefined)
            signaturePad.clear();

        return false;
    });

    var respQuest = [];

    
    var canvas = document.querySelector("canvas");
    var signaturePad = canvas != undefined ? new SignaturePad(canvas) : undefined;
                  
    $('#btsign').click(function() {
        
        if (signaturePad == undefined || signaturePad.isEmpty()) {
            alert('Veuillez apposer votre signature sur le pavé de signature');
            return false;			
        }
        
        HoldOn.open();
        $.post('publicajax.php', {action:'enreg-sign',idct:$('#idct').val(), codekey:$('#codekey').val(), sign:signaturePad.toDataURL()}, function(resp) {
            HoldOn.close();
            if (resp.responseAjax == 'SUCCESS') {
                // $('iframe').attr('src', resp.doc);
                $('#modal-sign').modal('hide');
                // $('#modal-confirm').modal();

                console.log(resp.signeval)
                $('#img-sign').attr('src',resp.signeval);
                
                

                signeval = resp.signeval;
            
                $('#sign-show').show();
                $('#formulairedevis').submit();
                

            } else{
                // One.helpers('jq-notify', {type: 'danger', icon: 'fa fa-times me-1', message: resp.message});
              alert('Erreur!\n' + resp.message )
                // $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
                //     type: 'danger',
                //     delay: 5000,
                //     offset: {
                //     from: "top",
                //     amount: 100
                //         },
                //         align: "center",
                //     allow_dismiss: true
                // });
            }
        }, 'json');
        
        return false;
    });
  })
</script>