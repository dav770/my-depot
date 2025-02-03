
<?php 
    // include 'Dashboard/including/config.php';
    
    include __DIR__ . '/including/dbclass.php';
    // Désactiver le rapport d'erreurs
    error_reporting(0);
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS");

    $contact = false;
    
    if (isset($_GET['key'])) {
        $codekey = substr($_GET['key'], 0, 8);
        $idct =  substr($_GET['key'], 8);
        $contact = Contact::findOne(array('c.id_fiche' => $idct, 'c.codekey ' => $codekey));

    }
    if (isset($_GET['type'])) {
        $typeTheme = $_GET['type']; 
    }

    $dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);
		
    $sejour = Setting::getMandator(array('id_organisateur'=> $contact->id_organisateur));
    // $organisateur = Setting::getMandatorOrg(array('id_organisateur'=> $contact->id_org));


    $nodevis = Contact::getLastNoDevis(array());
    $nodevis += 1;

    $ad = Contact::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'1'));
    $enf = Contact::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'2'));
    $bb = Contact::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'3'));
    
    $nbadulte = $ad->num_rows;
    $nbenf = $enf->num_rows;
    $nbbb = $bb->num_rows;

    $logo = './Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
    
    $date1 = new DateTime($contact->date_start);
    $date2 = new DateTime($contact->date_end);

    $jours = $date2->diff($date1)->days;
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
    $alldetails = Contact::getAllDetails(array('id_fiche'=>$contact->id_fiche));
    foreach($alldetails as $details){
        $sumTarif += $details['tarif_details'];
        $sumTarif += $details['tarif_transport'];
        $sumTarif += $details['tarif_supp_detail'];

        $htmldetails .= '
            <tr>
                <td>
                    '.$details['last_name_detail'].' '.$details['first_name_detail'].' - '.$details['first_name_detail'].' '.date('d/m/Y', strtotime($details['date_naissance_detail'])).'
                </td>
                <td>
                    
                </td>
                <td>
                    '.$details['tarif_details'].' €
                </td>
            </tr>
        ';
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


    $totFinal = (($tot + $addTot) * (100 - $contact->offre_sejour)) / 100;

    ?> 

    <style type="text/css" media="screen,print">                    
        * {font-family:helvetica;}
        table {border-collapse: collapse; width: 100% ;}
        td { border : 1px solid black; padding : 5px 10px !important;}
        .bold{ font-weight: bold}
        .justify {text-align: justify}
    </style>

<?php
    // include __DIR__.'/including/dbclass.php';
    $curusr = false;
    
    if (isset($_GET['key'])) {
        $codekey = substr($_GET['key'], 0, 8);
        $idc =  substr($_GET['key'], 8);
        $curusr = Contact::findOne(array('c.id_fiche' => $idc, 'c.codekey ' => $codekey));
    }
    
   
?>
    <!DOCTYPE html>
    <head>
    <link rel="stylesheet" href="Dashboard/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="Dashboard/css/plugins.css"> -->
        <link rel="stylesheet" href="Dashboard/css/main.css">
        <!-- <link rel="stylesheet" href="Dashboard/css/themes.css"> -->

		<!-- CUSTOM JO -->
		<!-- <link rel="stylesheet" href="Dashboard/css/HoldOn.min.css"> -->
		
        <!-- Modernizr (browser feature detection library) & Respond.js (enables responsive CSS code on browsers that don't support it, eg IE8) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js" integrity="sha512-7rusk8kGPFynZWu26OKbTeI+QPoYchtxsmPeBqkHIEXJxeun4yJ4ISYe7C6sz9wdxeE1Gk3VxsIWgCZTc+vX3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><script src="Dashboard/jscript/vendor/modernizr-respond.min.js"></script>
		<!-- <script src="Dashboard/jscript/vendor/jquery-1.12.0.min.js"></script> -->
        
    </head>
    <html>
    <body>
        <div id="page-content">
            <!-- Article Content -->
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                    <!-- Article Content -->
                    <div class="col-md-8 col-md-offset-2 col-sm-12">
                        <form onsubmit="return false;" class="form-horizontal" method="post" action="publicajax.php" id="formulairedevis">
                            <!-- Article Header -->
                            <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
                            <div class="content-header">
                                <div class="header-section text-center">
                                    <?php
                                        if (file_exists($logo)) {
                                            echo '<img src="'.$logo.'" style="width:150px" />';
                                        }    
                                    ?> 
                                    <span style="font-size:20px"><u>Devis numero : </u> <b><?php echo 'D_'.date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT) ?></b></span><br><br><br>
                                </div>
                            </div>
                            <!-- END Article Header -->

                            <p>
                                Cher(e) client,<br>
                                Ci-joint le devis demandé, en vous souhaitant bonne réception.<br>
                                <br>
                                <u>Code confidentiel</u> :  <b><?php echo $contact->codekey ?></b> <br>
                                <u>Contact: </u> <b><?php echo ($contact->civ_contact == 0 ? '' : ($contact->civ_contact == 1 ? 'Mr' : ($contact->civ_contact == 2 ? 'Mme' : 'Mlle'))).' '.strtoupper($contact->first_name).' '.strtoupper($contact->last_name) ?></b><br>
                                
                                <u>Adresse contact : </u> <b><?php echo $contact->adr1 .' '.$contact->city.' '.$contact->country ?></b><br>
                                <u>Date du séjour</u> : <?php echo date('d/m/Y', strtotime($contact->date_start)).' - '.date('d/m/Y', strtotime($contact->date_end)) ?><br>
                                <u>Nombre de jour(s)</u> : <?php echo $jours ?><br><br>
                                <u>Nombre de semaine(s)</u> : <?php echo number_format($semaine,2) ?><br><br>
                                
                                <table class="center">
                                <tr>
                                    <td colspan="3">
                                        Details des personnes
                                    </td>
                                    
                                </tr>	
                                    <?php echo $htmldetails ?>
						
                                    <tr>
                                        <td>
                                            Chambre(s)
                                        </td>
                                        <td>
                                            <?php echo $infchs->num_rows.' chambre '.$descch?>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Supplément(s)
                                        </td>
                                        <td>
                                            <?php echo $supch?>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            Montant de base <?php echo ($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' ) ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($tot,2).($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            Total supplément
                                        </td>
                                        <td>
                                            <?php echo $totsupch.' €'?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            Offre
                                        </td>
                                        <td>
                                            <?php echo $contact->offre_sejour.' %'?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            Monatnt final <?php echo ($contact->code_devise == 'EUR' ? '' : ' converti selon la devise' )?>
                                        </td>
                                        <td>
                                            <?php echo number_format($totFinal,2).($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) )?>
                                        </td>
                                    </tr>
                                    
                                </table>
                                <br>
                            </p>	
                            <div style="text-align:left">
                                <?php echo $sejour->desc_sejour?>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="form-group form-actions">
                                    <input type="hidden" name="action" id="action" value="sign-devis" />
                                    <button class="btn btn-sm btn-primary" type="submit" id="btupdatedevis"><i class="fa fa-user"></i> Valider</button>
                                    <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Annuler</button>
                                </div>
                            </div>   

                            
                            <div class="form-group" id="sign-show">
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
                </div>
            </div>
        </div>


        <div id="modal-sign" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
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
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        
            <!-- Modal PDF BAR EN -->
            <div id="modal-baren" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="text-right display-none" id="blksigndoc" style="padding:15px 15px 0;">
                            <a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> Signer le document</a>
                        </div>
                        <div class="modal-body" style="height: 80vh">
                            <iframe src="" style="width:100%;height:100%;"></iframe>
                            <input type="hidden" id="view_id_docs" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- END view impot -->
        </div>

        <footer class="clearfix">
            <div class="pull-left">
                <span id="y-copy-right"></span> &copy; <?=date('Y')?> <a href="#" target="_blank">DEMO SOC</a>
            </div>
        </footer>
        <!-- END Footer -->

        <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
       

        <script src="Dashboard/jscript/vendor/bootstrap.min.js"></script>
        <script src="Dashboard/jscript/plugins.js"></script>
        <script src="Dashboard/jscript/vendor/jquery.form.min.js"></script>
        <script src="Dashboard/jscript/HoldOn.min.js"></script>
        <script src="Dashboard/jscript/signature_pad.min.js"></script>
        <script src="Dashboard/jscript/one.js"></script>
        
        <!-- <script src="js/one.js"></script> -->

        <script type="text/javascript">
            $(document).ready(function() {

                // $('.linehdeb, .linehend').timepicker({minuteStep: 5,showSeconds: false,showMeridian: false});

                $(document).on('click', '#btetape2', function(){
                    window.location.href = 'infos-clients.php?key=<?php echo str_replace('#','',$_GET['key'])?>'
                })
              

                var signeval = '';
                $('#sign-show').hide();

                $(document).on('click','#btupdatedevis', function(){
                    $('#modal-sign').modal();
                    return false;
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
                                $('#modal-baren iframe').attr('src', resp.doc);
					            $('#modal-baren').modal();

                            } else {
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
                        },
                        error: function() {
                            console.log('NO');
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
                            // $('#formulairedevis').submit();
                           

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
                    
                    return false;
                });
            });
        </script>

    </body>
</html>