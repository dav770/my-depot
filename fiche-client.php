<?php include __DIR__.'/inc/_global/config.php'; ?>
<?php include __DIR__.'/inc/backend/config.php'; ?>
<?php include __DIR__.'/inc/_global/views/head_start.php'; ?>
<?php include __DIR__.'/inc/_global/views/head_end.php'; ?>
<?php include __DIR__.'/inc/_global/views/page_start.php'; ?>

<?php
    require_once __DIR__ . '/including/dbclass.php';
    
    // include_once __DIR__ . '/including/Grid4PHP.php'; 

    $contact = false;
    $idct = 0;
    $codekey = '';
    $idsej = 0;
    $type = '';
    $couriel = '';
    $cptch = 0;
    $lg = 'FR';
    
    date_default_timezone_set('Europe/Paris');
    // setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
    // setlocale(LC_ALL, 'fr_FR.UTF-8');
    // setlocale(LC_ALL, 'fr_FR');
    // $dateformat = strftime('%A %d %B %Y %I:%M');
    function date_fr($dt = '1970-01-01')
    {
        $Jour = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi");
        $Mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        return  $Jour[date("w")]." ".date("d")." ".$Mois[date("n")]." ".date("Y");
    }

    function date_eng($dt = '1970-01-01')
    {
        $Jour = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday","Saturday");
        $Mois = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        return  $Jour[date("w")]." ".date("d")." ".$Mois[date("n")]." ".date("Y");
    }


    $soc = Soc::findOne();

    $infgene = InfosGenes::getAll();
    $listopts = 0;
    if($infgene){
        if($infgene->is_inf_gene > 0 && $infgene->is_list_opts > 0){
            $listopts = 1;
        }
    }
    
    $logo_soc = 'Dashboard/uploads/socs/'.$soc->logo_soc;
    

    if (isset($_GET['CLID'])) {
        $codekey = substr($_GET['CLID'], 0, 8);
        $idct =  substr($_GET['CLID'], 8);
        $contact = Fiche::findOne(array('c.id_fiche' => $idct, 'c.codekey ' => $codekey));
        $contactDetails = Fiche::getAllDetails(array('id_fiche' => $idct));

        $dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);
		
        $signDevis = '';
        if($sign != ''){
            $signDevis = '<img src="'.__DIR__.'/'.$sign.'" id="img-sign-manu" style="width:200px; height: 100px;">';
        }
        
        $sejour = Setting::getOrganisateur(array('id_organisateur'=> $contact->id_organisateur));
        $idsej = $sejour->id_organisateur;
    }else{
        if(isset($_GET['listing'])){
            if((int)$_GET['listing'] > 0){
                $contact = Fiche::findOne(array('c.id_fiche' => (int)$_GET['listing']));
                $idListing = (int)$_GET['listing'];
            }
        }
        if(isset($_GET['listingSej'])){
            $idSejList = (int)$_GET['listingSej'];
        }
       
    }

    if (isset($_GET['KEY'])) {
        $dt = substr($_GET['KEY'], 0, 8); //ex: 200201121025
        $tm = substr($_GET['KEY'], 8, 4);
        if(date('Y-m-d') >= date('Y-m-d', strtotime(substr($dt,0,4).'-'.substr($dt,4,2).'-'.substr($dt,6,2).' + 1 days')) && (int)date('Hi') > (int)$tm){
            if(substr($_GET['type'],0,1) == 'C'){
                echo "Cette page n'est plus disponible<br>";
                echo "------------------------------------<br>";
                echo "This page is no longer available";
                return false;
            }
        }


    }

    // IHXXXX == inscription Hiver; CHXXXX == Contrat Hiver; IEXXXX == inscription Ete; CEXXXX == Contrat Ete
    // XXXX id du sejour
    if (isset($_GET['type'])) {
        $type = substr($_GET['type'],0,1); 
        $periode = substr($_GET['type'],1,1); 
        $idsej = substr($_GET['type'],2);
    
        $sejour = Setting::getOrganisateur(array('id_organisateur'=> $idsej));
        $logo = 'Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
    }

    if (isset($_GET['mail'])) {
        $couriel = substr($_GET['mail'],0); 

        if($type == 'A'){
            $couriel = $contact->email;
            // verif si deja inscript
            // if(is_file('Dashboard/uploads/'.$codekey.$idct.'/INSCRIPTION_SIGNED_'.$idct.'.pdf')){
            //     echo "Cette page n'est plus disponible - Inscription existante - Client dupliqué -<br>";
            //     echo "----------------------------------------------------------------------------<br>";
            //     echo "This page is no longer available - Registration existed - Duplicate customer -";
            //     return false;
            // }
        }
        
        if($type == 'I'){
            // verif si deja inscript
            $verif = Fiche::findOne(array('c.email'=>$couriel));
            // if($verif){
            //     if(is_file('Dashboard/uploads/'.$verif->codekey.$verif->id_fiche.'/INSCRIPTION_SIGNED_'.$verif->id_fiche.'.pdf')){
            //         echo "Cette page n'est plus disponible - Inscription existante - Email dupliqué -<br>";
            //         echo "---------------------------------------------------------------------------<br>";
            //         echo "This page is no longer available - Registration existed - Email duplicate -";
            //         return false;
            //     }
            // }
        }

    }else{
        
        echo "Cette page n'est plus disponible - Erreur informations parametres - <br>";
        echo "------------------------------------<br>";
        echo "This page is no longer available - Error parameters informations -";
        return false;
    }

    if (isset($_GET['LG'])) {
        if($_GET['LG'] == 'FR'){
            $lg = 'FR';
        }else{
            $lg = 'ENG';
        }
    }

    $SGN = '0';
    if (isset($_GET['SGN'])) {
        if($_GET['SGN'] == '1'){
            $SGN = '1';
        }
    }
    
    
    if($lg == 'FR' || $lg == ''){
        $dateformat = date_fr(date('Y-m-d'));
    }else{
        $dateformat = date_eng(date('Y-m-d'));
    }
    
    if($contact != false){
        $arrct = array();
        if((int)$contact->nodevis <= 0){
            $nodevis = Fiche::getLastNoDevis(array());
            $nodevis += 1;
        }else{
            $nodevis = $contact->nodevis;
        }

        
        if($contact->numdevis == ''){
            $arrct['numdevis'] = 'D_'.date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT);
            $arrct['nodevis'] = $nodevis;

            Fiche::update($arrct,array('id_fiche'=>$contact->id_fiche));
        }

        $ad = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'1'));
        $enf = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'2'));
        $bb = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'3'));
        // echo($ad->num_rows.' -- '.$enf->num_rows. '-- '.$bb->num_rows);
        
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

		$lstTypeCh = '';
		$nblitdouble = 0;
		$nblitsimple = 0;
		$nblitsup = 0;
		$nblitbb = 0;
    
        foreach($infchs as $ch){
            $prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
            if($prixch->tarif_chambre > 0){
                $addTot += $prixch->tarif_chambre;
            }
            
			$lstTypeCh .= ($lstTypeCh == '' ? '' : ';').$prixch->type_chambre;
			$nblitdouble += $prixch->nb_lit_double;
			$nblitsimple += $prixch->nb_lit_simple;
			$nblitsup += $prixch->nb_lit_sup;
			$nblitbb += $prixch->nb_lit_bb;

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

        };

        
		$alldetailsopts = Fiche::getAllDetailsOptions(array('id_fiche'=>$contact->id_fiche));
		foreach($alldetailsopts as $detailsopts){
			$sumTarif += $detailsopts['tot_tarif_option'];
		}

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

        if((int)$contact->is_tot_manu > 0){
            $totFinal = $contact->tot_ht;
            $totInit = (($totFinal + $addTot) - $contact->taxe_sejour);
        }else{
            $totFinal = (($tot + $addTot) * (100 - $contact->offre_sejour)) / 100;
            $totFinal += $contact->taxe_sejour;
            $totInit = ($tot + $addTot);
        }

        $remise = $contact->offre_sejour;
        
		if($contact->code_devise == 'EUR'){
			$devise = '€';
		}
		if($contact->code_devise == 'USD'){
			$devise = '$';
		}
		if($contact->code_devise == 'CAD'){
			$devise = 'CAD';
		}
		if($contact->code_devise == 'AUD'){
			$devise = 'AUD';
		}
		if($contact->code_devise == 'CHF'){
			$devise = 'CHF';
		}
		if($contact->code_devise == 'ILS'){
			$devise = '₪';
		}

        $detopts = Fiche::getAllDetailsOptions(array('id_fiche'=>$contact->id_fiche));

        $outch = Chambres::getAllDetails(array('cc.id_fiche'=>$contact->id_fiche));
    }else{
        // $outdetails = Grid4PHP::getGrid('db_contacts_details_options',0,$idsej);
    }

    $lstopts = Tarif::getAll(array('is_visible_inscript'=>'1'));

			// $htmldetails .= '
			// 	<tr>
			// 		<td style="width:70%"">
			// 			1 x '.$libtarifdetail->libelle_tarif.'
			// 		</td>
			// 		<td style="width:30%">
			// 			<b>'.$details['tarif_details'].' €</b>
			// 		</td>
			// 	</tr>
			// ';

            // if($libTransp != ''){
            //     $htmldetails .= '
			// 	<tr>
			// 		<td style="width:70%"">
			// 			1 x '.$libTransp.'
			// 		</td>
			// 		<td style="width:30%">
			// 			<b>'.$prixTransp.' €</b>
			// 		</td>
			// 	</tr>
			// ';
            // }

            // if($libopt1 != ''){
            //     $htmldetails .= '
			// 	<tr>
			// 		<td style="width:70%"">
			// 			1 x '.$libopt1.'
			// 		</td>
			// 		<td style="width:30%">
			// 			<b>'.$prixopt1.' €</b>
			// 		</td>
			// 	</tr>
			// ';
            // }

            // if($libopt2 != ''){
            //     $htmldetails .= '
			// 	<tr>
			// 		<td style="width:70%"">
			// 			1 x '.$libopt2.'
			// 		</td>
			// 		<td style="width:30%">
			// 			<b>'.$prixopt2.' €</b>
			// 		</td>
			// 	</tr>
			// ';
            // }
            
		
    

?>  

<style type="text/css" media="screen,print">      
    /* body {background-image: url("/Dashboard/img/MH-DEVIS-fond.jpg");
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-position: center;
                    background-size: cover;}         */
    .content-header {height: 10rem !important; display:block !important}
    .text-center {margin-top: 15px !important;}
    .cForm {display:flex; justify-content:center; margin-top:15px}            
    /* .cForm {text-align:center}             */
    * {font-family:helvetica;}
    table {border-collapse: collapse; width: 100% ;}
    td { border : none; padding : 5px 5px;}
    .bold{ font-weight: bold}
    .justify {text-align: justify}
    ul{
        list-style-type: none;
      }
</style>

<!-- Hero Content -->
<!-- END Hero Content -->

<!-- Page Content -->
<div class="">
    <div id="page-content">
        <div class="row" style="justify-content: center;">
            <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                <div class="block block-alt-noborder">
            
                    <div class="text-center">
                        <?php
                            if (file_exists($logo)) {
                                echo '<img src="'.$logo.'" style="width:200px" />';
                            }    
                        ?> 
                        
                    </div>
               
                    <form onsubmit="return false;" class="form-horizontal" method="post" action="publicajax.php" id="formulairedevis">
                        <div class="inscOk">                            
                            <div class="" style="line-height:20px;border:0px solid #e8cc81; background-color:white;color:black;padding-left:7px">
                            
                                <div style="text-align:center">
                                    <h3><span style="color:#e8cc81"><?php echo ($type == 'I' || $type == 'A' ? 'FICHE D\'INSCRIPTION' : 'REGISTRATION FORM')?></span></h3>
                                    <?php echo $dateformat ?>
                                    <h2><?php echo $sejour->name_organisateur ?></h2>
                                </div>
                                <div class="form-group row cForm" style="">
                                    <label for="date_start" style="" class="col-sm-1 col-form-label">Date : <?php echo ($lg == 'FR' || $lg == '' ? 'Du ' : 'From ') ?></label>
                                    <div class="col-sm-2">
                                        <input type="date" style="" min="<?php echo $sejour->date_start_organisateur?>" max="<?php echo $sejour->date_end_organisateur?>" class="form-control" name="date_start" id="date_start" value="<?php echo $contact->date_start > 0 ? $contact->date_start : $sejour->date_start_organisateur; ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>
                                    <label for="date_end" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Au ' : 'To ') ?></label>
                                    <div class="col-sm-2">
                                        <input type="date" style="" min="<?php echo $sejour->date_start_organisateur?>" max="<?php echo $sejour->date_end_organisateur?>" class="form-control" name="date_end" id="date_end" value="<?php echo $contact->date_end > 0 ? $contact->date_end : $sejour->date_end_organisateur; ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group row cForm" style="">
                                    
                                    <label style="" for="civ_contact" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Civilité : ' : 'Title : ') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="civ_contact" id="civ_contact" required>
                                            <option value="0" <?php echo $contact && $contact->civ_contact == '0' ? 'selected="selected"' : ''; ?>></option>
                                            <option value="1" <?php echo $contact && $contact->civ_contact == '1' ? 'selected="selected"' : ''; ?>>M.</option>
                                            <option value="2" <?php echo $contact && $contact->civ_contact == '2' ? 'selected="selected"' : ''; ?>>Mme</option>
                                            <option value="3" <?php echo $contact && $contact->civ_contact == '3' ? 'selected="selected"' : ''; ?>>Mlle</option>
                                        </select>
                                    </div>
                                    
                                    <label style="" for="last_name" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Nom : ' : 'Last name : ') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-2"> 
                                        <input type="text" style="" class="form-control" name="last_name" id="last_name" value="<?php echo $contact->last_name ?>" <?php echo ($type == 'I'  || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>
                                    
                                    <label style="" for="first_name" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Prénom : ' : 'First name : ') ?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-2"> 
                                        <input type="text" style="" class="form-control" name="first_name" id="first_name" value="<?php echo $contact->first_name ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>
                                </div>
                                
                                <div class="form-group row cForm">
                                    <!-- <label for="date_birth" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Naissance' : 'Date birth') ?></label>
                                    <div class="col-sm-2">
                                        <input type="date" style="" class="form-control" name="date_birth" id="date_birth" value="<?php echo $contact->date_birth ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div> -->
                                    
                                    <label for="email" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Email : ' : 'Email ') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" style="" class="form-control" name="email" id="email" value="<?php echo $couriel ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>
                                    
                                    <!-- <label for="age_ct" style="" pattern="\d{3}\" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Age : ' : 'Age ') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" style="" class="form-control" name="age_ct" id="age_ct" value="<?php echo $contact->age_ct ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div> -->
                                    
                                    <label for="tel1" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Tél : ' : 'Phone ') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" style="" class="form-control" name="tel1" id="tel1" value="<?php echo $contact->tel1 ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>

                                    <label for="" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? ' ' : ' ') ?></label>
                                    <div class="col-sm-2">
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group row cForm">

                                    <label for="city" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Ville : ' : 'City : ') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" style="" class="form-control" name="city" id="city" value="<?php echo $contact->city ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>
                                    
                                    <label for="country" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Pays : ' : 'Country ') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" style="" class="form-control" name="country" id="country" value="<?php echo $contact->country ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>

                                    <label for="" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? ' ' : ' ') ?></label>
                                    <div class="col-sm-2">
                                        
                                    </div>
                                
                                </div>
                                
                                <!-- <div class="form-group row cForm">
                                    
                                    <label for="nb_lit_bb_souhait" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Nb lit bébé' : 'Nb bed baby') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" style="" class="form-control" name="nb_lit_bb_souhait" id="nb_lit_bb_souhait" value="<?php echo $contact->nb_lit_bb_souhait ?>" <?php echo ($type == 'I' || $type == 'A' ? '' : 'disabled="disabled"')?>>
                                    </div>
                                    
                                    <label for="terrasse_balcon_souhait" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Balcon : ' : 'Balcon : ') ?></label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="terrasse_balcon_souhait" id="terrasse_balcon_souhait" required>
                                            <option value="0" <?php echo $contact && $contact->terrasse_balcon_souhait == '0' ? 'selected="selected"' : ''; ?>>NON</option>
                                            <option value="1" <?php echo $contact && $contact->terrasse_balcon_souhait == '1' ? 'selected="selected"' : ''; ?>>OUI</option>
                                        </select>
                                    </div>

                                    <label for="" style="" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? ' ' : ' ') ?></label>
                                    <div class="col-sm-2">
                                        
                                    </div>
                                
                                </div> -->

                                <div class="form-group row cForm">
                                    <?php if($type == 'C'){?>
                                        <label for="nb_adulte" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Nb adulte : ' : 'Nb Adult : ') ?></label>
                                    <?php }?>
                                    <div class="col-sm-2">
                                        <input type="<?php echo ($type != 'C' ? 'hidden' : 'text')?>" class="form-control" name="nb_adulte" id="nb_adulte" value="<?php echo $nbadulte ?>" <?php echo ($type == 'I' || $type == 'A' ? 'disabled="disabled"' : 'disabled="disabled"')?>>
                                    </div>
                                    
                                    <?php if($type == 'C'){?>
                                        <label for="nb_enfant" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Nb enfant : ' : 'Nb children : ') ?></label>
                                    <?php }?>
                                    <div class="col-sm-2">
                                        <input type="<?php echo ($type != 'C' ? 'hidden' : 'text')?>" class="form-control" name="nb_enfant" id="nb_enfant" value="<?php echo $nbenf ?>" disabled="disabled">
                                    </div>
                                    
                                    <?php if($type == 'C'){?>
                                        <label for="nb_bb" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Nb bébé : ' : 'Nb baby ') ?></label>
                                    <?php }?>
                                    <div class="col-sm-2">
                                        <input type="<?php echo ($type != 'C' ? 'hidden' : 'text')?>" class="form-control" name="nb_bb" id="nb_bb" value="<?php echo $nbbb ?>" disabled="disabled">
                                    </div>
                                </div>
                                <?php if($type == 'C'){?>
                                    <?php /*
                                    <div class="form-group row cForm">
                                        <label for="nb_chambre" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Nb chambre : ' : 'Room count : ') ?></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" name="nb_chambre" id="nb_chambre" value="<?php echo $nbchambre ?>" disabled="disabled">
                                        </div>
                                        
                                        <label for="type_chambre" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Type chambre : ' : 'Room type : ') ?></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" name="type_chambre" id="type_chambre" value="<?php echo $lstTypeCh ?>" disabled="disabled">
                                        </div>
                                        
                                        <label for="nb_lit_bb" class="col-sm-1 col-form-label"></label>
                                        <div class="col-sm-2">
                                            
                                        </div>
                                        <!-- <label for="nb_lit_bb" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Lit bébé : ' : 'Baby bed : ') ?></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" name="nb_lit_bb" id="nb_lit_bb" value="<?php echo $nblitbb ?>" disabled="disabled">
                                        </div> -->
                                    </div>
                                    */ ?>

                                    
                                <?php }?>
                                <br>
                                <hr>

                                <div id="idgrpadd">
                                    <?php echo ($lg == 'FR' || $lg == '' ? ($type == 'I'  || $type == 'A' ? 'Ajout de personne(s) via le bouton ci-dessous : <span style="color:red">(Pour les personnes de plus de 18 ans vous pouvez simplement ecrire "+" ou ">" au lieu de l\'age)</span>' : '') : ($type == 'I' || $type == 'A' ? 'Add person(s) via the button below : <span style="color:red">(For peoples over 18 you can simply write "+" or ">" instead of age)</span>' : '')) ?>
                                    <br><br>
                                    <?php echo ($type == 'I' || $type == 'A' ? '<a href="#"  class="btn btn-primary" id="btaddinf"><i class="fa fa-plus"></i></a>' : '')?>
                                    <div class="form-group cForm col-md-12">
                                        <table  id="inftb" class="" style="width:100%">
                                            <tr >
                                                <th style="width: 0px;visibility: hidden;display:none"><?php echo ($lg == 'FR' || $lg == '' ? 'Nom ' : 'Name ') ?></th>
                                                <th <?php echo ($type == 'I' || $type == 'A' ? 'style="width: 30px;"' : '') ?>><?php echo ($lg == 'FR' || $lg == '' ? 'Prénom ' : 'First name ') ?></th>
                                                <th class="clfirstage" <?php echo ($type == 'I' || $type == 'A' ? 'style="width: 30px;"' : '') ?>><?php echo ($lg == 'FR' || $lg == '' ? 'Age ' : 'Age ') ?></th>
                                                <th class="clfirstsexe" <?php echo ($type == 'I' || $type == 'A' ? 'style="width: 20px;"' : '') ?>><?php echo ($lg == 'FR' || $lg == '' ? 'Sexe ' : 'Sex ') ?></th>
                                                <th style="width: 0px;visibility: hidden;"><?php echo ($lg == 'FR' || $lg == '' ? '' : '') ?></th>
                                                <th style="width: 0px;visibility: hidden;display:none"></th> <?php //echo ($lg == 'FR' || $lg == '' ? 'Date naissance : ' : 'Date birth : ') ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <br>
                                <hr>
                                <div class="form-group cForm" <?php echo ($type == 'I' || $type == 'A' ? '' : 'style="display:none"') ?>>
                                    <label style="" for="det_options" class="col-sm-2 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Options supp. ' : 'Add options ') ?></label>
                                <?php if($listopts == 1){?>                               
                                        <div class="col-sm-2">
                                            <select class="form-control" name="det_options" id="det_options">
                                                <option value="0">Choix des options</option>
                                            <?php foreach($lstopts as $opt){
                                                echo '<option data-tarif="'.$opt['age_tarif'].'" value ="'.$opt['id_tarif'].'">'.$opt['libelle_tarif'].'</option>';
                                            }?>
                                            </select>                                    
                                        </div>
                                        <?php echo ($type == 'I' || $type == 'A' ? '<a href="#" class="btn btn-warning" id="btaddopts"><i class="fa fa-plus"></i></a>' : '')?>
                                    <?php }?>
                                </div>	
                                
                                <div class="form-group cForm col-md-12">
                                    <table  id="infopttb" style="width:100%">
                                        <tr >
                                            <th style="width:75%"><?php echo ($lg == 'FR' || $lg == '' ? 'Options : ' : 'Options : ') ?></th>
                                            <th style="width:20%"><?php echo ($lg == 'FR' || $lg == '' ? 'Qte : ' : 'Qte : ') ?></th>
                                            <th style="width:20%"><?php echo ($lg == 'FR' || $lg == '' ? '' : '') ?></th>
                                        </tr>
                                    </table>
                                </div>
                                <?php if($type == 'C'){?>
                                    <br>
                                    <hr>
                                    <strong><?php echo ($lg == 'FR' || $lg == '' ? 'Chambres / Room: ' : 'Room : ') ?></strong>
                                    <div class="form-group cForm col-md-10">
                                    <table id="listeCh" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>
                                                        <?php echo ($lg == 'FR' || $lg == '' ? 'N° chambre' : 'Room number') ?> 
                                                    </th>
                                                    <th>
                                                        <?php echo ($lg == 'FR' || $lg == '' ? 'Etage' : 'Floor') ?> 
                                                    </th> -->
                                                    <th>
                                                        <?php echo ($lg == 'FR' || $lg == '' ? '#' : '#') ?> 
                                                    </th>
                                                    <th>
                                                        <?php echo ($lg == 'FR' || $lg == '' ? 'Etage' : 'Etage') ?> 
                                                    </th>
                                                    <th>
                                                        <?php echo ($lg == 'FR' || $lg == '' ? 'Capacité' : 'Capacity') ?> 
                                                    </th>
                                                    <th>
                                                        <?php echo ($lg == 'FR' || $lg == '' ? 'Type' : 'Type') ?> 
                                                    </th>
                                                    <th style="display:none">
                                                        <?php echo ($lg == 'FR' || $lg == '' ? 'Vue' : 'View') ?> 
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($outch as $ch){
                                                $cptch++;
                                                echo '<tr>
                                                        <td>
                                                            <span class="columnClass">'.$cptch.'</span>
                                                        </td>
                                                        <td>
                                                            <span class="columnClass">'.$ch['etage'].'</span>
                                                        </td> 
                                                        <td>
                                                            <span class="columnClass">'.$ch['capacite'].'</span>
                                                        </td> 
                                                        <td>
                                                            <span class="columnClass">'.$ch['name_type_chambre'].'</span>
                                                        </td> 
                                                        <td style="display:none">
                                                            <span class="columnClass">'.$ch['name_loc_chambre'].'</span>
                                                        </td>
                                                    </tr>';
                                            } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php }?>
                                <br><hr>
                            </div>
                        </div>

                        <?php if($type == 'C'){?>
                            <!-- <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? ' REGLEMENT : ' : 'Acount : ') ?></label>
                            </div> -->
                            <div class="form-group cForm">
                                <div>
                                    <label for="tot_ht" style="width:140px !important;" class="col-sm-2 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Mt total séjour : ' : 'Total stay amount : ') ?></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="tot_ht" id="tot_ht" value="<?php echo ($infgene->is_decimal > 0 ? number_format($totInit,2) :number_format($totInit)) .' '.$devise ?>" disabled="disabled">
                                    </div>
                                </div>

                                <!-- <div>
                                    <label for="remise" style="width:140px !important;" class="col-sm-2 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Remise : ' : 'Discount : ') ?></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="remise" id="remise" value="<?php echo number_format($remise,2).' %' ?>" disabled="disabled">
                                    </div>
                                </div> -->
                                
                                <div>
                                    <label for="taxe_sejour" style="" class="col-sm-2 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Taxe : ' : 'Tax : ') ?></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="taxe_sejour" id="taxe_sejour" value="<?php echo ($infgene->is_decimal > 0 ? number_format($contact->taxe_sejour,2) : number_format($contact->taxe_sejour)).' '.$devise ?>" disabled="disabled">
                                    </div>
                                </div>

                                <div>
                                    <label for="mttot" class="col-sm-2 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Total : ' : 'Total : ') ?></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="mttot" id="mttot" value="<?php echo ($infgene->is_decimal > 0 ? number_format($totFinal,2) : number_format($totFinal) ).' '.$devise ?>" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <br><hr>
                            <!-- <div class="form-group row">
                                <label for="reglt" class="col-sm-1 col-form-label"><?php echo ($lg == 'FR' || $lg == '' ? 'Note : ' : 'Note : ') ?></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="reglt" id="reglt" rows="2" cols="100" disabled="disabled"><?php echo $note ?></textarea>
                                </div>
                            </div> -->
                            <?php /*
                            <div class="row">

                                <div class="col-md-3"style="">
                                </div>

                                <div class="col-md-7"style="">
                                    <div >
                                        <p>Nous vous remercions d’adresser ce formulaire dûment rempli et signé soit :</p>
                                        <ul>
                                            <li>
                                                1. En le signant directement depuis cette page internet
                                            </li>
                                            <!-- <li>
                                                2. En le telechargeant et en l'envoyant à l’adresse suivante : <a href="#" id="dwdoc" class="btn btn-info">en cliquant ici</a>
                                                <ul>
                                                    <li style="color:red">
                                                        CRYSTAL CLUB
                                                    </li>
                                                    <li style="color:red">
                                                        118-130 AVENUE JEAN JAURÈS - 75169 PARIS - FRANCE
                                                    </li>
                                                </ul>
                                            </li> -->
                                            <li>
                                                2. Ou bien nous l’envoyer par mail à : crystalclub18@gmail.com
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2"style="">
                                </div>
                            </div>
                            */?>
                        <?php }?>
                
                        <div class="col-md-12" style="margin-top: 10px;">
                            <div class="form-group form-actions">
                                <?php if($type == 'C'){?>
                                    <input type="hidden" name="action" id="action" value="enreg-sign-manuscrite" />
                                <?php }else{?>
                                        <input type="hidden" name="action" id="action" value="sign-devis" />
                                <?php }?>
                                <input type="hidden" name="id_sejour" id="id_sejour" value="<?php echo $idsej ?>" />
                                <input type="hidden" name="idct" id="idct" value="<?php echo $idct ?>" />
                                <input type="hidden" name="listopts" id="listopts" value="<?php echo $listopts ?>" />
                                <input type="hidden" name="age_ct" id="age_ct" value="<?php echo $contact->age_ct ?>" />
                                <input type="hidden" name="codekey" id="codekey" value="<?php echo $codekey ?>" />
                                <input type="hidden" name="list_add_sejour" id="list_add_sejour" value="<?php echo $idSejList ?>" />
                                <input type="hidden" name="idListing" id="idListing" value="<?php echo $idListing ?>" />
                                <input type="hidden" name="type" id="type" value="<?php echo $type ?>" />
                                <input type="hidden" name="periode" id="periode" value="<?php echo $periode ?>" />
                                <input type="hidden" name="ageDb" id="ageDb" value="" />
                                <button class="btn btn-sm btn-primary sign-show" type="submit" id="btupdatedevis"><i class="fa fa-user"></i> <?php echo ($lg == 'FR' || $lg == '' ? ($SGN == 0 ? 'Valider' : 'Signer') : ($SGN == 0 ? 'Confirm' : 'To Sign') )?></button>
                                <button class="btn btn-sm btn-warning sign-show" type="reset" id="btresetdevis"><i class="fa fa-repeat"></i> <?php echo ($lg == 'FR' || $lg == '' ? 'Annuler' : 'Canceled') ?></button>
                            </div>
                        </div>   

                        <?php /*
                        <span class="clshow" >Signature enregistrée , <?php echo ($type == 'I' || $type == 'A' ? '<br>Merci votre demande de devis à bien été envoyée.<br>Thanks, your quote request has been sent' : 'Merci, votre contrat à bien été transmis.<br>Thanks, your contract request has been sent')?> <?php echo ($type == 'C' ?  '<br>Vous pouvez fermer cette page<div>Téléchargez le document <a href="#" id="dwdoc" class="btn btn-info">en cliquant ici</a></div>' : '') ?></span>   
                        */?>
                        <span class="clshow" >Signature enregistrée , <?php echo ($type == 'I' || $type == 'A' ? '<br>Merci votre demande de devis à bien été envoyée.<br>Thanks, your quote request has been sent' : 'Merci, votre contrat à bien été transmis.<br>Thanks, your contract request has been sent')?> </span>   
                        <div class="form-group" id="sign-show" style=";border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
                        <?php if($type == 'C'){?>
                            <input type="checkbox" id="chkcgv" ></input><span style="padding:5px;margin-top:20px;margin-bottom:5px;font-weight:600" ><b><?php echo ($type == 'C' ? ($lg == 'FR' || $lg == '' ? 'Je confirme avoir lu et approuvé les Conditions Générales de Ventes du Crystal Club : www.crystal-club.fr/cgv' : 'I have read and approved the terms and conditions of the Crystal Club : www.crystal-club.fr/cgv') : ($lg == 'FR' || $lg == '' ? 'Le client' : 'Customer')) ?></b></span>
                        <?php }?>

                            <div class="col-md-12" style="border:solid 1px #ccc;min-height:200px;padding-left: 11px;margin-left: -4px;">
                                <b><?php echo ($type == 'C' ? ' '.$contact->city : '')?> Le <?php echo date('d/m/Y'); ?></b><br>
                                <b>Signature : </b><br><br>
                                <img src="" id="img-sign" style="width:200px; height: 120px;">
                            </div>
                            <br>
                        <?php if($type == 'C'){?>
                            <span class="cForm" style="color:red"><?php echo ($lg == 'FR' || $lg == '' ? 'Le Crystal Club vous remercie de votre confiance et vous souhaite un agréable séjour' : 'The Crystal Club thanks you and wishes you a pleasant stay') ?></span>
                            <br>
                            <div style="text-align:center">CONDITIONS GÉNÉRALES DE VENTES</div>
                            <div class="container" style="padding-left: 7px;">

                                <div class="row">
    
                                    <div class="col-md-6" style="background-color:gray;color:#FFF">
                                        INSCRIPTION<br>
                                        L’inscription à notre séjour implique l’acceptation des conditions
                                        énumérées ci-dessous.
                                        Toute inscription devra être accompagnée d’un acompte de 40% par
                                        personne et du bordereau d’inscription dûment complété et signé.
                                        Le solde devra être réglé au plus tard 7 jours avant votre arrivée.
                                        L’inscription ne prend effet qu’à l’encaissement de l’acompte. Un
                                        séjour écourté ne donne pas droit à un remboursement.<br>
                                        ANNULATION<br>
                                        Toute annulation de votre part devra nous être notifiée dans les plus
                                        brefs délais par téléphone et confirmée par courrier, télécopie ou
                                        e-mail. Le paiement du séjour devra toutefois être complété d’après
                                        les conditions suivantes : 
                                    </div>
                                    <div class="col-md-6" style="background-color:gray;color:#FFF">
                                        ■ De la signature à 45 jours avant le début du séjour, 40% du prix total du
                                        séjour devra être payé (acompte à déduire).<br>
                                        ■ De 30 à 45 jours, 70% du prix total du séjour devra être payé (acompte
                                        à déduire).<br>
                                        ■ De 7 à 30 jours, 90% du prix total du séjour devra être payé (acompte
                                        à déduire).<br>
                                        ■ De 6 jours au jour J, 100% du prix total du séjour devra être payé
                                        (acompte à déduire).<br>
                                        Tous les prestataires de services par air, par train ou par route sont des
                                        sociétés indépendantes qui assument leurs responsabilités respectives.
                                        Nous vous recommandons donc de souscrire à une assurance.
                                        En cas d’événements exceptionnels et indépendants de notre volonté,
                                        nous nous réservons le droit de modifier ou d’annuler notre séjour.
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="container" style="padding-left: 7px;">
                                <div class="row">
                                    <div class="col-md-6" style="background-color:gray;color:#FFF">
                                        SIGN<br>
                                        Registration for our stay implies acceptance of the conditions listed below.
                                        All registration must be accompanied by a deposit of 40% per person and the registration form duly completed and signed.
                                        The balance must be paid no later than 7 days before your arrival.
                                        Registration only takes effect upon receipt of the deposit. 
                                        A shortened stay does not give right to a refund.
                                    </div>
                                    <div class="col-md-6" style="background-color:gray;color:#FFF">
                                        CANCEL<br>
                                        Any cancellation on your part must be notified to us as soon as possible by telephone and confirmed by mail, fax or e-mail.
                                        The payment of the stay will however have to be completed according to the conditions below:<br>
                                        ■ From the signature to 45 days before the start of the stay, 40% of the total price of the stay must be paid (down payment).<br>
                                        ■ From 30 to 45 days, 70% of the total price of the stay must be paid (deposit to be deducted).<br>
                                        ■ From 6 days to D-day, 100% the total price of the stay must be paid (down payment).
                                        All other services by air, rail or road are independent companies that assume their own responsibilities.<br>
                                        We recommend that you apply for insurance.
                                        In case of exceptional events beyond our control, we reserve the right to modify or cancel our trip.
                                    </div>
                                </div>
                            </div>
                            <div class="container" style="padding-left: 7px;">
                                <div class="row">
    
                                    <div class="col-md-6" style="background-color:#781c44;color:#FFF">
                                        <?php
                                            if (file_exists($logo_soc)) {
                                                echo '<img src="'.$logo_soc.'" style="width: 100px" />';
                                            }    
                                        ?> 
                                    </div>
                                    <div class="col-md-6" style="background-color:#781c44;color:#FFF; text-align:right">
                                        Tèl : <?php echo $soc->tel_soc ?><br>
                                        <?php echo $soc->site_soc ?> - <?php echo $soc->email_soc ?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                            <!-- <button class="btn btn-sm btn-info" type="submit" id="btetape2"><i class="fa fa-user"></i> Suivante</button> -->
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
                                <input type="hidden" id="idctsign" name="idctsign" value="<?php echo $contact ? $contact->id_fiche : '0'; ?>" />
                                <input type="hidden" id="codekeysign" name="codekeysign" value="<?php echo $contact ? $contact->codekey : ''; ?>" />
                                <button type="button" id="clearsignbox" class="btn btn-sm btn-danger pull-left"><i class="gi gi-cleaning"></i> <?php echo ($lg == 'FR' || $lg == '' ? 'Effacer' : 'Clear') ?></button>  
                                <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-sm btn-primary" id="btsign"><i class="fa fa-pencil"></i> <?php echo ($lg == 'FR' || $lg == '' ? 'Valider' : 'Validate') ?></button>
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
                                <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal"><?php echo ($lg == 'FR' || $lg == '' ? 'Fermer' : 'Close') ?></button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <!-- Modal PDF -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
	
	$(document).ready(function() {
        var idxtb = 0;
        var idxtbopt = 0;

        var modifDb = 0;
        var modifDbDet = 0;
        var modifDbD = 0;
        
        // initNbAdulte()
        initFields()
        initListing()

        // function verifDate(dt, inpt){
        //     if(dt.length != 10){
        //         $('#'+inpt).focus()
        //         return false;
        //     }
        // }
        
        // // $('#date_birth').keydown(function(){
            
        //     window.addEventListener("keydown", function (event) {        
        //         if(event.target.attributes[3] == 'name="date_birth"'){

        //             if (event.key !== undefined || event.which !== undefined) {
        //                 // Handle the event with KeyboardEvent.key
        //                 if($('#date_birth').val().length == 2 && event.key != 'Backspace'){
        //                     console.log('1',$('#date_birth').val().length ,event.key)
        //                     $('#date_birth').val($('#date_birth').val() + '/')
        //                 }
        //                 if($('#date_birth').val().length == 5  && event.key != 'Backspace'){
        //                     $('#date_birth').val($('#date_birth').val() + '/')
        //                 }
        //             }
        //         }        
        //     });            
        // });

        function initFields(){
            if(idxtb == 0 && $('#type').val() == 'I'){
                $('.clfirstage').text('');
                $('.clfirstsexe').text('');
                $('#btaddinf').css('display','none');
                $('#idgrpadd').css('display','none');
            }else{

            }

            if(isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0){
                $('#nb_adulte').val(0)
            }

            if(isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0){
                $('#nb_enfant').val(0)
            }

            if(isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0){
                $('#nb_bb').val(0)
            }

            if($('#type').val() == 'C'){
                document.title = 'Contrat';
                // $(document).attr("title", "Devis");

                $('.clshow').hide()
                
                if(parseInt($('#idct').val()) > 0 && $('#codekey').val() != '' && parseInt($('#id_sejour').val()) > 0){
                    // console.log('kkkk',$('#type').val())
                    let str = '';
                    HoldOn.open();
                    $.post('publicajax.php', {action:'dspl-inf',idct:$('#idct').val(), codekey:$('#codekey').val(), idsejour:$('#id_sejour').val(), listopts:$('#listopts').val()}, function(resp) {
                        HoldOn.close();
                        if (resp.responseAjax == 'SUCCESS') {
                            resp.data.forEach(d => {
                                    idxtb++;
                                    str += '<tr id="trinf'+idxtb+'" ><td style="width: 0%;visibility: hidden;display:none"><input id="n'+idxtb+'" name="n'+idxtb+'" type="text" class="form-control" value="'+d.last_name_detail+'" readonly/></td>';
                                    str += '<td ><input id="p'+idxtb+'" name="p'+idxtb+'" type="text" class="form-control" value="'+d.first_name_detail+'" readonly/></td>';
                                    str += '<td ><input id="a'+idxtb+'" name="a'+idxtb+'" type="text" class="form-control" value="'+d.age+'" readonly/></td>';
                                    str += '<td ><input id="s'+idxtb+'" name="s'+idxtb+'" type="text" class="form-control" value="'+(d.sexe == 0 ? '' : (d.sexe == 1 ? 'M' : 'F'))+'" readonly/></td>';
                                    // str += '<td><button id="b'+idxtb+'" name="b'+idxtb+'" type="button" class="cldel"><i class="fa fa-trash cldel2"></i></button></td>';
                                    str += '<td style="visibility: hidden;width:0px;display:none"><input style="visibility: hidden;width:0px; color:#FFF;border:none" id="d'+idxtb+'" name="d'+idxtb+'" type="date" data-id="'+idxtb+'" class="cldate" value="'+d.date_naissance_detail+'" disabled="disabled"/></td>';
                                    str += '<td style="visibility: hidden;width:0px;display:none"><input id="t'+idxtb+'" name="t'+idxtb+'" type="text" class="" value=""></input></td></tr>';
                                
                                    $('#inftb').append(str);
                                    str= ''; 
                            })
                           
                            resp.dataopt.forEach(d => {
                                    
                                    idxtbopt++;
                                    let str = '';
                                    str += '<tr id="trinfopt'+idxtbopt+'" ><td><input id="o'+idxtbopt+'" name="o'+idxtbopt+'" type="text" class="form-control" data-tarif="'+d.tarif_detail_option+'" data-id="'+d.id_lib_option+'" value="'+d.lib_detail_option+'" disabled="disabled"/></td>';
                                    str += '<td><input id="q'+idxtbopt+'" name="q'+idxtbopt+'" type="text" class="form-control" value="'+d.qte_detail_option+'" readonly/></td>';
                                    // str += '<td><button id="v'+idxtbopt+'" name="v'+idxtbopt+'" type="button" class="cldelnewopt"><i class="fa fa-trash cldelnewopt2"></i></button></td>';
                                    $('#infopttb').append(str)
                                    str= ''; 
                            })
                                
                        } else{
                            
                            alert('Erreur!\n' + resp.message )
                        
                        }
                    }, 'json');
                    
                    return false;
                }
            }else{
                
                document.title = 'Inscription';
                if($('#type').val() == 'A'){
                    $('.clshow').hide()
                
                    if(parseInt($('#idct').val()) > 0 && $('#codekey').val() != '' && parseInt($('#id_sejour').val()) > 0){
                        // console.log('kkkk',$('#type').val())
                        let str = '';
                        HoldOn.open();
                        $.post('publicajax.php', {action:'dspl-inf',idct:$('#idct').val(), codekey:$('#codekey').val(), idsejour:$('#id_sejour').val()}, function(resp) {
                            HoldOn.close();
                            if (resp.responseAjax == 'SUCCESS') {
                                console.log()
                                resp.data.forEach(d => {
                                        idxtb++;
                                        str += '<tr id="trinf'+idxtb+'" ><td style="width: 0%;visibility: hidden;display:none"><input id="n'+idxtb+'" name="n'+idxtb+'" type="text" class="form-control" value="'+d.last_name_detail+'" '+(d.is_p > 0 ? 'readonly' : '')+' /></td>';
                                        str += '<td style="width: 30px;"><input id="p'+idxtb+'" name="p'+idxtb+'" type="text" class="form-control" value="'+d.first_name_detail+'" '+(d.is_p > 0 ? 'readonly' : '')+' /></td>';
                                        str += '<td style="width: 30px;"><input id="a'+idxtb+'" name="a'+idxtb+'" type="text" class="form-control clage" value="'+d.age+'" /></td>';
                                        str += '<td style="width: 20px;"><select id="s'+idxtb+'" name="s'+idxtb+'" class="form-control" '+(d.is_p > 0 ? 'disabled="disabled"' : '')+' ><option value="0"></option><option value="1" '+(d.is_p > 0 && $('#civ_contact').val() == '1' ? 'selected="selected"' : '')+'>M</option><option value="2" '+(d.is_p > 0 && ($('#civ_contact').val() == '2' || $('#civ_contact').val() == '3') ? 'selected="selected"' : '')+'>F</option></select></td>';
                                        str += '<td style="width: 20px;"><button id="b'+idxtb+'" name="b'+idxtb+'" type="button" class="cldelnew" style="'+(d.is_p > 0 ? 'display:none' : '')+'" ><i class="fa fa-trash cldelnew2"></i></button></td>';
                                        str += '<td style="visibility: hidden;width:0px;display:none"><input style="visibility: hidden;width:0px; color:#FFF;border:none" id="d'+idxtb+'" name="d'+idxtb+'" type="date" data-id="'+idxtb+'" class="cldate" value="'+d.date_naissance_detail+'" '+(d.is_p > 0 ? 'disabled="disabled"' : 'disabled="disabled"')+' /></td>';
                                        str += '<td style="visibility: hidden;width:0px;display:none"><input id="t'+idxtb+'" name="t'+idxtb+'" type="text" class="" value=""></input></td></tr>';
                                    
                                        $('#inftb').append(str);

                                        $('#d'+idxtb).attr('data-add-nb', d.type);
                                        str= ''; 
                                        if(d.is_p == 1){
                                            if(d.age == 0 && (isNaN(parseInt($('#age_ct').val())) || parseInt($('#age_ct').val()) == 0)){
                                                $('#a'+idxtb).val(18);
                                                $('#age_ct').val(18);
                                                $('#ageDb').val(18);
                                            }else{
                                                if(d.age > 0 && (isNaN(parseInt($('#age_ct').val())) || parseInt($('#age_ct').val()) == 0)){
                                                    $('#age_ct').val(d.age);
                                                    $('#ageDb').val(d.age);
                                                }else{
                                                    if(d.age < parseInt($('#age_ct').val())){
                                                        $('#a'+idxtb).val($('#age_ct').val());
                                                        $('#ageDb').val($('#age_ct').val());
                                                    }
                                                }
                                            }

                                        }
                                })

                                // $('#nb_adulte').val(parseInt($('#nb_adulte').val()) + (parseInt(resp.adulte) - 1 )) //pour retirer la presence du representant dans le tableau des personnes (car ajouter par defaut)
                                // $('#nb_adulte').val(parseInt($('#nb_adulte').val()) + (parseInt(resp.adulte))) 
                                // $('#nb_enfant').val(parseInt($('#nb_enfant').val()) + parseInt(resp.enf))
                                // $('#nb_bb').val(parseInt($('#nb_bb').val()) + parseInt(resp.bb))

                                resp.dataopt.forEach(d => {
                                    
                                        idxtbopt++;
                                        let str = '';
                                        let selopt = '';
                                        str += '<tr id="trinfopt'+idxtbopt+'" ><td><input id="o'+idxtbopt+'" name="o'+idxtbopt+'" type="text" class="form-control" data-tarif="'+d.tarif_detail_option+'" data-id="'+d.id_lib_option+'" value="'+d.lib_detail_option+'" disabled="disabled"/></td>';
                                             
                                        if($('#listopts').val() == '1'){
                                            str += '<td><input id="q'+idxtbopt+'" name="q'+idxtbopt+'" type="text" class="form-control" value="'+d.qte_detail_option+'" /></td>';
                                            str += '<td><button id="v'+idxtbopt+'" name="v'+idxtbopt+'" type="button" class="cldelnewopt"><i class="fa fa-trash cldelnewopt2"></i></button></td>';
                                        }else{
                                            str += '<td><select id="q'+idxtbopt+'" name="q'+idxtbopt+'" class="form-control">';
                                            for(idopt=0;idopt<=15;idopt++){
                                                selopt = (idopt == d.qte_detail_option ? 'selected="selected"' : '');
                                                str += '<option value value="'+idopt+'" '+selopt+'/>'+idopt+'</option>';
                                                selopt = '';
                                            }
                                            str += '</select></td>';
                                        }
                                        
                                        
                                        // str += '<td><input id="q'+idxtbopt+'" name="q'+idxtbopt+'" type="text" class="form-control" value="'+d.qte_detail_option+'" /></td>';
                                        // if($('#listopts').val() == '1'){
                                        //     str += '<td><button id="v'+idxtbopt+'" name="v'+idxtbopt+'" type="button" class="cldelnewopt"><i class="fa fa-trash cldelnewopt2"></i></button></td>';
                                        // }
                                        $('#infopttb').append(str)
                                        str= ''; 
                                })

                            } else{
                                
                                alert('Erreur!\n' + resp.message )
                            
                            }
                        }, 'json');
                        
                        return false;
                    }
                }else{
                    if($('#type').val() == 'I'){
                        $('.clshow').hide()
                        let str = '';

                        // on affiche le representant en grisé pour garder le meme modele
                        // mais en idxtb a 0 pour ne pas fausser le calcul du traitement en cours
                        str += '<tr id="trinf'+0+'" ><td style="width: 0px;visibility: hidden;display:none"><input id="n'+0+'" name="n'+0+'" type="text" class="form-control" value="" readonly/></td>';
                        str += '<td style="width: 30px;"><input id="p'+0+'" name="p'+0+'" type="text" class="form-control" value="" readonly/></td>';
                        str += '<td style="width: 30px;visibility:hidden"><input id="a'+0+'" name="a'+0+'" type="text" class="form-control clage" value="18" /></td>';
                        str += '<td style="width: 20px;visibility:hidden"><select id="s'+0+'" name="s'+0+'" class="form-control" disabled="disabled" ><option value="0"></option><option value="1">M</option><option value="2">F</option></select></td>';
                        str += '<td style="width: 20px;"><button id="b'+0+'" name="b'+0+'" type="button" class="cldelnew" style="display:none" ><i class="fa fa-trash cldelnew2"></i></button></td>';
                        str += '<td style="visibility: hidden;width:0px;display:none"><input style="visibility: hidden;width:0px; color:#FFF;border:none" id="d'+0+'" name="d'+0+'" type="date" data-id="'+0+'" class="cldate" value="" disabled="disabled"/></td>';
                        str += '<td style="visibility: hidden;width:0px;display:none"><input id="t'+0+'" name="t'+0+'" type="text" class="" value=""></input></td></tr>';
                    
                        $('#inftb').append(str);

                        $('#d'+0).attr('data-add-nb', '1');
                        str= ''; 
                    
                        
                        HoldOn.open();
                        $.post('publicajax.php', {action:'dspl-inf-i',idct:$('#idct').val(), codekey:$('#codekey').val(), idsejour:$('#id_sejour').val()}, function(resp) {
                            HoldOn.close();
                            if (resp.responseAjax == 'SUCCESS') {
                                resp.dataopt.forEach(d => {                                    
                                        idxtbopt++;
                                        let str = '';
                                        let selopt = '';

                                        str += '<tr id="trinfopt'+idxtbopt+'" ><td><input id="o'+idxtbopt+'" name="o'+idxtbopt+'" type="text" class="form-control" data-tarif="'+d.tarif_detail_option+'" data-id="'+d.id_lib_option+'" value="'+d.lib_detail_option+'" disabled="disabled"/></td>';
                                            
                                        if($('#listopts').val() == '1'){
                                            str += '<td><input id="q'+idxtbopt+'" name="q'+idxtbopt+'" type="text" class="form-control" value="'+d.qte_detail_option+'" /></td>';
                                            str += '<td><button id="v'+idxtbopt+'" name="v'+idxtbopt+'" type="button" class="cldelnewopt"><i class="fa fa-trash cldelnewopt2"></i></button></td>';
                                        }else{
                                            str += '<td><select id="q'+idxtbopt+'" name="q'+idxtbopt+'" class="form-control">';
                                            for(idopt=0;idopt<=15;idopt++){
                                                selopt = (idopt == d.qte_detail_option ? 'selected="selected"' : '');
                                                str += '<option value value="'+idopt+'" '+selopt+'/>'+idopt+'</option>';
                                                selopt = '';
                                            }
                                            str += '</select></td>';
                                        }
                                        
                                        // str += '<td><input id="q'+idxtbopt+'" name="q'+idxtbopt+'" type="text" class="form-control" value="'+d.qte_detail_option+'" /></td>';
                                        // if($('#listopts').val() == '1'){
                                        //     str += '<td><button id="v'+idxtbopt+'" name="v'+idxtbopt+'" type="button" class="cldelnewopt"><i class="fa fa-trash cldelnewopt2"></i></button></td>';
                                        // }
                                        $('#infopttb').append(str)
                                        str= ''; 
                                })

                            } else{
                                
                                alert('Erreur!\n' + resp.message )
                            
                            }
                        }, 'json');
                        
                        return false;
                    }
                }
            }
        }

        function initListing(){
            $('#last_name').focus();
            $('#n0').val($('#last_name').val())
            $('#p0').val($('#first_name').val())
        }

        $(document).on('click','#dwdoc', function(){
            HoldOn.open();
            
			$.post('publicajax.php', {
				action: 'down-contrat',
				idct:$('#idct').val(), 
                codekey:$('#codekey').val(), 
                type:$('#type').val(),
                periode:$('#periode').val(),
                idxtb:idxtb,
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
                    $('#modal-pdf iframe').attr('src', resp.doc);
					console.log(resp.doc);
                    $('#modal-pdf').modal('show');

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
        })

        function initNbAdulte(){
            if(idxtb == 0 && (parseInt($('#nb_adulte').val()) == 0 || parseInt($('#nb_adulte').val().trim() == '') ||  isNaN(parseInt($('#nb_adulte').val()))) && $('#last_name').val().trim() != ''){
                
                $('#nb_adulte').val('1')
            }
        }

        $("#age_ct").mask("999");
        $(".clage").mask("999");



        $('#age_ct').keyup(function(){
            let key = event.key;
            if ((parseInt(key) >= 0  && parseInt(key) <= 9) || key == 'Backspace') { 
                modifDb = '0';
                $('#ageDb').val($('#age_ct').val());
                $('#date_birth').val('1900-01-01');

                if($('#type').val() == 'A'){
                    $('#a1').val($(this).val())
                }
            }
        })

        $('#age_ct').focusout(function(){
            if(parseInt($('#age_ct').val()) > 0 && modifDb == '0'){

                if(parseInt($('#age_ct').val()) < 18 ){
                    alert("vous devez être majeur pas moins de 18 ans");
                    $('#age_ct').val(18)
                    $('#ageDb').val(18);
                    $('#date_birth').val('1900-01-01');
                }else{
                    $('#ageDb').val($('#age_ct').val());
                    $('#date_birth').val('1900-01-01');
                    
                }
            }else{
                $('#age_ct').val($('#ageDb').val());
            }
        })

        $('#date_birth').focusout(function(){
            // if(!verifDate($('#date_birth').val(), 'date_birth')){
            //     alert('date de naissance invalide')
            //     return false
            // }
            modifDb = '0';

            let dtb = $('#date_birth').val().split('-');
            if($(this).val() == ''){
                dtb = "1900-01-01";
            }else{
                dtb = $(this).val();
            }

            HoldOn.open();
            $.post('publicajax.php', {action:'calcul-age',dtb:dtb, app:'DB'}, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    $('#ageDb').val(resp.age);
                    $('#age_ct').val(resp.age);

                    if(idxtb > 0){
                        $('#d1').val( $('#date_birth').val())
                        $('#a1').val( resp.age)
                    }

                    modifDb = 1;

                } else{
                    alert('Erreur!\n' + resp.message )
                    $('#date_birth').focus()
                    return false
                }
            }, 'json');
            
            return false;
        })

        $('#last_name').keyup(function(){
            if($('#type').val() == 'I'){
                $('#n0').val($('#last_name').val())
            }
        })

        $('#first_name').keyup(function(){
            if($('#type').val() == 'I'){
                $('#p0').val($('#first_name').val())
            }
        })
        
        $('#age_ct').keyup(function(){
            if($('#type').val() == 'I'){
                $('#a0').val($('#age_ct').val())
            }
        })
        
        $('#civ_contact').change(function(){
            if($('#type').val() == 'I'){
                $('#s0').val(($('#civ_contact').val() == '0' || $('#civ_contact').val() == '1' ? $('#civ_contact').val() : 2))
            }
        })

        $('#last_name').focusout(function(){   
            if((idxtb == 0 || ( 
                (isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0 || parseInt($('#nb_adulte').val()) == 1 ) && 
                (isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0) && 
                (isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0))) && 
                $('#last_name').val().trim() == ''){

                $('#btaddinf').css('display','none');
                $('#idgrpadd').css('display','none');
            }else{
                if((idxtb > 0 && ( 
                (isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0 || parseInt($('#nb_adulte').val()) == 1 ) && 
                (isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0) && 
                (isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0))) && 
                $('#last_name').val().trim() == ''){

                    $('#btaddinf').css('display','none');
                    $('#idgrpadd').css('display','none');
                }else{
                    $('#btaddinf').css('display','initial');
                    $('#idgrpadd').css('display','block');
                }
            }    

            if($('#last_name').val().trim() == '' && idxtb > 0){
                alert("<?php echo ($lg == 'FR' || $lg == '' ? 'Nom obligatoire' : 'Last name require') ?>")
                $('#last_name').val($('#n'+idxtb).val())
                return false;
            }
             
            if(idxtb > 0){
                $('#n1').val( $('#last_name').val())
            }
            initNbAdulte()
        })

        $('#first_name').focusout(function(){

            if(idxtb > 0){
                $('#p1').val( $('#first_name').val())
            }
        })


        $('#civ_contact').change(function(){
            if(idxtb > 0){
                $('#s1').val('0')

                if($('#civ_contact').val() == '1'){
                    $('#s1').val('1')
                }
                if($('#civ_contact').val() == '2' || $('#civ_contact').val() == '3'){
                    $('#s1').val('2')
                }
                
            }
        })

    
    $('#btaddinf').click(function(){
        if($('#last_name').val().trim() == '' && idxtb == 0){
            alert("<?php echo ($lg == 'FR' || $lg == '' ? 'Nom obligatoire' : 'Last name require') ?>")
            return false;
        }

        $('.clfirstage').text("<?php echo ($lg == 'FR' || $lg == '' ? 'Age' : 'Age') ?>");
        $('.clfirstsexe').text("<?php echo ($lg == 'FR' || $lg == '' ? 'Sexe' : 'Sex') ?>");
        
        
        initNbAdulte()
        // if(idxtb == 0 && parseInt($('#nb_adulte').val()) == 0){
        //     $('#nb_adulte').val('1')
        // }

        idxtb++;
        let str = '';
        str += '<tr id="trinf'+idxtb+'" ><td style="width: 0%;visibility: hidden;display:none"><input id="n'+idxtb+'" name="n'+idxtb+'" type="text" class="form-control" value="'+$('#last_name').val()+'"/></td>';
        str += '<td style="width: 30px;"><input id="p'+idxtb+'" name="p'+idxtb+'" type="text" class="form-control" value=""/></td>';
        str += '<td style="width: 30px;"><input id="a'+idxtb+'" name="a'+idxtb+'" type="text" class="form-control clage" value="" /></td>';
        str += '<td style="width: 20px;"><select id="s'+idxtb+'" name="s'+idxtb+'" class="form-control" ><option value="0"></option><option value="1">M</option><option value="2">F</option></select></td>';
        str += '<td style="width: 20px;"><button id="b'+idxtb+'" name="b'+idxtb+'" type="button" class="cldelnew"><i class="fa fa-trash cldelnew2"></i></button></td>';
        str += '<td style="visibility: hidden;width:0px;display:none"><input style="visibility: hidden;width:0px; color:#FFF;border:none" id="d'+idxtb+'" name="d'+idxtb+'" type="date" data-id="'+idxtb+'" data-add-nb="0" class="cldate" value="" disabled="disabled"/></td>';
        str += '<td style="visibility: hidden;width:0px;display:none"><input id="t'+idxtb+'" name="t'+idxtb+'" type="text" class="" value=""></input></td></tr>';
        $('#inftb').append(str)

        return false
    })
    
    $('#btaddopts').click(function(){
        
        idxtbopt++;
        let str = '';
        str += '<tr id="trinfopt'+idxtbopt+'" ><td><input id="o'+idxtbopt+'" name="o'+idxtbopt+'" type="text" class="form-control" data-tarif="'+$('#det_options option:selected').attr('data-tarif')+'" data-id="'+$('#det_options').val()+'" value="'+$('#det_options option:selected').text()+'" disabled="disabled"/></td>';
        str += '<td><input id="q'+idxtbopt+'" name="q'+idxtbopt+'" type="text" class="form-control" value="1"/></td>';
        str += '<td><button id="v'+idxtbopt+'" name="v'+idxtbopt+'" type="button" class="cldelnewopt"><i class="fa fa-trash cldelnewopt2"></i></button></td>';
        $('#infopttb').append(str)
        return false
    })

    $(document).on('focusin','.clage', function(){
        if(isNaN(parseInt( $(this).val())) || parseInt( $(this).val()) == 0){
            modifDbD = 0
        }else{
            modifDbD = $(this).val()
        }
    })

    $(document).on('keyup','.clage', function(){
        let idage = $(this).attr('id').substring(1)
        
        let key = event.key;
        // console.log(key, idage, $(this))
        if ((parseInt(key) >= 0  && parseInt(key) <= 9) || key == 'Backspace') { 
            modifDbDet = '0';
            $('#d'+idage).val('1900-01-01');

            if(idage == 1 && $('#type').val() == 'A'){
                $('#age_ct').val($(this).val())
                $('#ageDb').val($(this).val())
                $('#date_birth').val('1900-01-01');
            }
        }
        return false;
    })

    $(document).on('focusout','.clage', function(){
        let idage = $(this).attr('id').substring(1)

        if(parseInt($(this).val()) >= 0 && ($('#d'+idage).val() == '1900-01-01' || $('#d'+idage).val() == '') && parseInt($(this).val()) != parseInt(modifDbD)){
            // $('#d'+idage).val('1900-01-01');
            console.log('blur',parseInt($(this).val()),$('#d'+idage).val())
       
            // if($('#d'+idage).val() == ''){
            //     console.log('vide')
            //     return false;
            // }
            let id = $('#d'+idage).attr('data-id');
            let addNb = $('#d'+idage).attr('data-add-nb');
            console.log('---',idage, addNb)

            let arrDt = [];
            
            arrDt.push($('#d'+idage).val());
            
            modifDbDet = '0';
            
            HoldOn.open();
            // $.post('publicajax.php', {action:'calcul-age',dtb:$('#d'+idage).val(), arrDt:arrDt, id:idage, addNb:addNb, modifDbDet:modifDbDet, age:$('#a'+idage).val()}, function(resp) {
            $.post('publicajax.php', {action:'calcul-age',dtb:'1900-01-01', arrDt:arrDt, id:idage, addNb:addNb, modifDbDet:modifDbDet, age:$('#a'+idage).val()}, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    console.log('resp',resp)
                    $('#a'+idage).val(resp.age);
                    
                    if(parseInt(addNb) > 0){
                        if(addNb == '1'){
                            $('#nb_adulte').val(parseInt($('#nb_adulte').val()) - 1)
                        }
                        if(addNb == '2'){
                            $('#nb_enfant').val(parseInt($('#nb_enfant').val()) - 1)
                        }
                        if(addNb == '3'){
                            $('#nb_bb').val(parseInt($('#nb_bb').val()) - 1)
                        }

                        if(parseInt(resp.adulte) > 0){
                            $('#d'+idage).attr('data-add-nb','1');
                        }
                        if(parseInt(resp.enf) > 0){
                            $('#d'+idage).attr('data-add-nb','2');
                        }
                        if(parseInt(resp.bb) > 0){
                            $('#d'+idage).attr('data-add-nb','3');
                        }

                    }else{
                        if(parseInt(resp.adulte) > 0){
                            $('#d'+idage).attr('data-add-nb','1');
                        }
                        if(parseInt(resp.enf) > 0){
                            $('#d'+idage).attr('data-add-nb','2');
                        }
                        if(parseInt(resp.bb) > 0){
                            $('#d'+idage).attr('data-add-nb','3');
                        }
                        
                    }

                    if(isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0){
                        $('#nb_adulte').val(resp.adulte)
                    }else{
                        $('#nb_adulte').val(parseInt($('#nb_adulte').val()) + resp.adulte)
                    }

                    if(isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0){
                        $('#nb_enfant').val(resp.enf)
                    }else{
                        $('#nb_enfant').val(parseInt($('#nb_enfant').val()) + resp.enf)
                    }

                    if(isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0){
                        $('#nb_bb').val(resp.bb)
                    }else{
                        $('#nb_bb').val(parseInt($('#nb_bb').val()) + resp.bb)
                    }

                    $('#t'+idage).val(resp.type)

                    modifDbDet = '1';
                    modifDbD = '0';
                   
                
                } else{
                    
                    alert('Erreur!\n' + resp.message )
                
                }
            }, 'json');
            
            return false;
        }
        
    })

    $(document).on('blur','.cldate',function(){
        
        // ajax calcul age et verif si enf ou bb
        // if(enf => nbenf++) ; if(bb => nbbb++)
        console.log($(this).val())
        if($(this).val() != '' && $(this).val() != '1900-01-01'){
            if($(this).val() == ''){
                console.log('vide')
                return false;
            }
            let id = $(this).attr('data-id');
            let addNb = $(this).attr('data-add-nb');

            let arrDt = [];
            // for (let index = 1; index <= id; index++) {
                // arrDt.push($('#d'+index).val());
                arrDt.push($('#d'+id).val());
                
            // }
            // console.log(arrDt, $('#inftb'))

            modifDbDet = '0';
            
            HoldOn.open();
            $.post('publicajax.php', {action:'calcul-age',dtb:$(this).val(), arrDt:arrDt, id:id, addNb:addNb , modifDBDet:modifDbDet, age:$('#a'+id).val(), app:'B.CLD'}, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    $('#a'+id).val(resp.age);
                    
                    if(parseInt(addNb) > 0){
                        if(addNb == '1'){
                            $('#nb_adulte').val(parseInt($('#nb_adulte').val()) - 1)
                        }
                        if(addNb == '2'){
                            $('#nb_enfant').val(parseInt($('#nb_enfant').val()) - 1)
                        }
                        if(addNb == '3'){
                            $('#nb_bb').val(parseInt($('#nb_bb').val()) - 1)
                        }

                        if(parseInt(resp.adulte) > 0){
                            $('#d'+id).attr('data-add-nb','1');
                        }
                        if(parseInt(resp.enf) > 0){
                            $('#d'+id).attr('data-add-nb','2');
                        }
                        if(parseInt(resp.bb) > 0){
                            $('#d'+id).attr('data-add-nb','3');
                        }
                        
                    }else{
                        if(parseInt(resp.adulte) > 0){
                            $('#d'+id).attr('data-add-nb','1');
                        }
                        if(parseInt(resp.enf) > 0){
                            $('#d'+id).attr('data-add-nb','2');
                        }
                        if(parseInt(resp.bb) > 0){
                            $('#d'+id).attr('data-add-nb','3');
                        }
                        
                    }

                    if(isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0){
                        $('#nb_adulte').val(resp.adulte)
                    }else{
                        $('#nb_adulte').val(parseInt($('#nb_adulte').val()) + resp.adulte)
                    }

                    if(isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0){
                        $('#nb_enfant').val(resp.enf)
                    }else{
                        $('#nb_enfant').val(parseInt($('#nb_enfant').val()) + resp.enf)
                    }

                    if(isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0){
                        $('#nb_bb').val(resp.bb)
                    }else{
                        $('#nb_bb').val(parseInt($('#nb_bb').val()) + resp.bb)
                    }

                    $('#t'+id).val(resp.type)

                    modifDbDet = '1';
                    console.log('resp 2',modifDbDet)
                
                } else{
                    
                    alert('Erreur!\n' + resp.message )
                
                }
            }, 'json');
            
            console.log('blur 2', $(this).val(), modifDbDet)
        }
        return false;
    
    })

    $(document).on('click','.cldel',function(){
        let id = $(this).attr('id').substring(1)
        let type = $('#t'+id).val();

        HoldOn.open();
        $.post('publicajax.php', {action:'del-inf',id:id}, function(resp) {
            HoldOn.close();
            if (resp.responseAjax == 'SUCCESS') {
                if(type == '1'){
                    if(isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0){
                        $('#nb_adulte').val('0')
                    }else{
                        $('#nb_adulte').val(parseInt($('#nb_adulte').val()) - 1)
                    }
                }

                if(type == '2'){
                    if(isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0){
                        $('#nb_enfant').val('0')
                    }else{
                        $('#nb_enfant').val(parseInt($('#nb_enfant').val()) - 1)
                    }
                }
              

                if(type == '3'){
                    if(isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0){
                        $('#nb_bb').val('0')
                    }else{
                        $('#nb_bb').val(parseInt($('#nb_bb').val()) - 1)
                    }
                }

                $('#trinf'+id).remove()

                // console.log((isNaN(parseInt($('#nb_adulte').val())) , parseInt($('#nb_adulte').val()) == 0 , parseInt($('#nb_adulte').val()) == 1 ))
                if( (isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0 || parseInt($('#nb_adulte').val()) == 1 ) && 
                    (isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0) && 
                    (isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0) ){
                    $('.clfirstage').text('');
                    $('.clfirstsexe').text('');
                }
              
              
            } else{
                
                alert('Erreur!\n' + resp.message )
            
            }
        }, 'json');
        
        return false;
    })

    $('.cldel2').click(function(){
        let id = $(this).parent().attr('id').substring(1) 
        $('#b'+id).click()
    })

    $(document).on('click','.cldelnew',function(){
        let id = $(this).attr('id').substring(1)
        let type = $('#t'+id).val();
        if(type == '1'){
            if(isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0){
                $('#nb_adulte').val('0')
            }else{
                $('#nb_adulte').val(parseInt($('#nb_adulte').val()) - 1)
            }
        }

        if(type == '2'){
            if(isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0){
                $('#nb_enfant').val('0')
            }else{
                $('#nb_enfant').val(parseInt($('#nb_enfant').val()) - 1)
            }
        }
        

        if(type == '3'){
            if(isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0){
                $('#nb_bb').val('0')
            }else{
                $('#nb_bb').val(parseInt($('#nb_bb').val()) - 1)
            }
        }
        $('#trinf'+id).remove()

        // console.log((isNaN(parseInt($('#nb_adulte').val())) , parseInt($('#nb_adulte').val()) , parseInt($('#nb_adulte').val()) ))
        if( (isNaN(parseInt($('#nb_adulte').val())) || parseInt($('#nb_adulte').val()) == 0 || parseInt($('#nb_adulte').val()) == 1 ) && 
            (isNaN(parseInt($('#nb_enfant').val())) || parseInt($('#nb_enfant').val()) == 0) && 
            (isNaN(parseInt($('#nb_bb').val())) || parseInt($('#nb_bb').val()) == 0) ){
            $('.clfirstage').text('');
            $('.clfirstsexe').text('');
        }
        
    })

    $(document).on('click','.cldelnewopt',function(){
        let id = $(this).attr('id').substring(1)
        
        $('#trinfopt'+id).remove()
    })

    $('.cldelnew2').click(function(){
        let id = $(this).parent().attr('id').substring(1) 
        $('#b'+id).click()
    })


    // $(document).attr("title", "Devis");
    $('#page-header').css('display','none')
    $('#page-footer').css('display','none')

    $(document).on('click', '#btetape2', function(){
        window.location.href = 'infos-clients.php?CLID=<?php echo str_replace('#','',$_GET['CLID'])?>'
    })
  

    var signeval = '';
    var SansSignature = 0;


    if($('#type').val() == 'I' || $('#type').val() == 'A'){
        $('#sign-show').hide();
    }

    $(document).on('click','#btupdatedevis', function(){

        for (let index = 1; index <= idxtb; index++) {
            let verif_n = 'n'+index;
            let verif_p = 'p'+index;
            let verif_d = 'd'+index;
            let verif_t = 't'+index;
            let verif_a = 'a'+index;
            let verif_s = 's'+index;

            if($('#'+verif_p).val().trim() == '' || $('#'+verif_a).val().trim() == '' || ($('#'+verif_s).val().trim() == '' || $('#'+verif_p).val() == '0')){
                alert('Le prénom , l\'age, et le sexe des personnes ajoutées en inscription\n\r sont OBLIGATOIRE !!!');
                return false;
                break;
            }
        }

        let dts = $('#date_start').val().split('-')
        let dte = $('#date_end').val().split('-')

        if($('#type').val() != 'C'){
            
            if(!confirm('Confirmez vos dates / Confirm the period : '+dts[2]+'/'+dts[1]+'/'+dts[0]+' - '+dte[2]+'/'+dte[1]+'/'+dte[0]+' ?')){
                return false;
            }
        }

        if($('#type').val() == 'C'){
            if($('#chkcgv').is(':checked')){
                $('#modal-sign').modal('show'); 
            }else{
                alert("<?php echo ($lg == 'FR' || $lg == '' ? 'Vous devez accepter les conditions générales de ventes ci-dessous, pour continuer' : 'Please, accept the terms of sale.') ?>")
            }
        }else{
            if("<?php echo $SGN == '0' ?>"){
                SansSignature = 1;
                $('#btsign').click();
            }else{
                $('#modal-sign').modal('show'); 
            }
                
        }
      // console.log('jj')
        return false;
    });

    $(document).on('click','#btresetdevis', function(){
        window.location.reload();
    });


    // $('#formulaireevalfroid').submit(function() {
        
    $(document).on('submit', '#formulairedevis', function() {
        console.log('submit formulaire')
        HoldOn.open();
        jQuery(this).ajaxSubmit({
            dataType : 'json',
            data:{
                action:($('#type').val() == 'C' ? 'enreg-sign-manuscrite' : 'sign-devis'),
                idct:$('#idct').val(), 
                codekey:$('#codekey').val(), 
                sign:signaturePad.toDataURL(), 
                type:$('#type').val(),
                periode:$('#periode').val(),
                agedb:$('#ageDb').val(),
                idxtb:idxtb,
                },

            success: function(resp) {
  
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    console.log('doc',resp.doc)
                    
                    $('#modal-sign').modal('hide');

                    
                    $('#img-sign').attr('src',resp.signeval);
                    $('.clshow').show();
                    
                    
                    signeval = resp.signeval;
                    
                    $('#sign-show').show();
                    $('.sign-show').hide();
                    
                    // $('#modal-pdf iframe').attr('src', resp.doc);
                    // $('#modal-pdf').modal('show');
                    
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
        var objdetail = {};
        var keys = [];
        var values = [];
        var cpt = 0;

        var objdetailopt = {};
        var keysopt = [];
        var valuesopt = [];
        var cptopt = 0;


        if ((signaturePad == undefined || signaturePad.isEmpty()) && SansSignature == 0) {
            alert('Veuillez apposer votre signature sur le pavé de signature');
            return false;			
        }

        if($('#type').val() == 'C'){
            $('#formulairedevis').submit();
            return false;
        }

        for (let index = 1; index <= idxtb; index++) {
            let verif_n = 'n'+index;
            let verif_p = 'p'+index;
            let verif_d = 'd'+index;
            let verif_t = 't'+index;
            let verif_a = 'a'+index;
            let verif_s = 's'+index;

            if($('#'+verif_p).val().trim() == '' || $('#'+verif_a).val().trim() == '' || ($('#'+verif_s).val().trim() == '' || $('#'+verif_p).val() == '0')){
                alert('Le prénom , l\'age, et le sexe des personnes ajoutées en inscription\n\r sont OBLIGATOIRE !!!');
                return false;
                break;
            }
        }

        // if($('#type').val() == 'C'){
        //     $('#formulairedevis').submit();
        //     return false;
        // }

        for (let index = 1; index <= idxtb; index++) {
            // index == 1 => represenatnt donc info principal de la fiche a ne pas reprendre
            // on modifie sont detail lors de l'update de la fiche
            if($('#type').val() == 'A'){
                if(index > 1){
                    let n = 'n'+index;
                    let p = 'p'+index;
                    let d = 'd'+index;
                    let t = 't'+index;
                    let a = 'a'+index;
                    let s = 's'+index;

                    keys.push(n) ;
                    keys.push(p) ;
                    keys.push(d) ;
                    keys.push(a) ;
                    keys.push(t) ;
                    keys.push(s) ;

                    values.push($('#n'+index).val()) ;
                    values.push($('#p'+index).val()) ;
                    values.push($('#d'+index).val()) ;
                    values.push($('#a'+index).val()) ;
                    values.push($('#t'+index).val()) ;
                    values.push($('#s'+index).val()) ;
                    
                    // Object.assign(objdetail,{n:$('#n'+index).val(), p:$('#p'+index).val(), d:$('#d'+index).val(), t:$('#t'+index).val()})
                }
            }else{
                let n = 'n'+index;
                let p = 'p'+index;
                let d = 'd'+index;
                let t = 't'+index;
                let a = 'a'+index;
                let s = 's'+index;

                keys.push(n) ;
                keys.push(p) ;
                keys.push(d) ;
                keys.push(a) ;
                keys.push(t) ;
                keys.push(s) ;

                values.push($('#n'+index).val()) ;
                values.push($('#p'+index).val()) ;
                values.push($('#d'+index).val()) ;
                values.push($('#a'+index).val()) ;
                values.push($('#t'+index).val()) ;
                values.push($('#s'+index).val()) ;
                
                // Object.assign(objdetail,{n:$('#n'+index).val(), p:$('#p'+index).val(), d:$('#d'+index).val(), t:$('#t'+index).val()})
            }
        }

        for (let index = 1; index <= idxtbopt; index++) {
            // pour les options
            let o = 'o'+index;
            let q = 'q'+index;

            keysopt.push(o) ;
            keysopt.push(q) ;

            valuesopt.push($('#o'+index).attr('data-id')) ;
            if($('#listopts').val() == '1'){
                valuesopt.push($('#q'+index).val()) ;
            }else{
                valuesopt.push($('#q'+index+' option:selected').text()) ;
            }
            
        }


        arr = [];
        arropt = [];
    
        for(i = 0 ; i < keys.length && i < values.length ; i++){
            cpt++;
            objdetail[keys[i]] = values[i];
            if(6 == cpt){
                arr.push(objdetail);
                objdetail = {}
                cpt = 0;
            }
        }
    
        for(i = 0 ; i < keysopt.length && i < valuesopt.length ; i++){
            cptopt++;
            objdetailopt[keysopt[i]] = valuesopt[i];
            if(2 == cptopt){
                arropt.push(objdetailopt);
                objdetailopt = {}
                cptopt = 0;
            }
        }

        // console.log(arr,arropt)
        // return false
        
        HoldOn.open();
        $.post('publicajax.php', {action:'enreg-sign',
                idct:$('#idct').val(), 
                lg:'<?php echo $lg ?>',
                codekey:$('#codekey').val(), 
                sign:signaturePad.toDataURL(),
                isSignature:SansSignature,
                type:$('#type').val(),
                periode:$('#periode').val(),
                agedb:$('#ageDb').val(),
                idsej:$('#id_sejour').val(),
                idxtb:idxtb,
                obj:arr,
                idxtbopt:idxtbopt,
                objopt:arropt,
                last_name:$('#last_name').val(),
                first_name:$('#first_name').val(),
                tel1:$('#tel1').val(),
                city:$('#city').val(),
                country:$('#country').val(),
                email:$('#email').val(),
                nb_adulte:$('#nb_adulte').val(),
                civ_contact:$('#civ_contact').val(),
                date_start:$('#date_start').val(),
                date_end:$('#date_end').val(),
                date_birth:$('#date_birth').val(),
                nb_lit_bb_souhait:$('#nb_lit_bb_souhait').val(),
                terrasse_balcon_souhait:$('#terrasse_balcon_souhait').val(),
                list_add_sejour:$('#list_add_sejour').val(),
                idListing:$('#idListing').val(),
            }, function(resp) {
            HoldOn.close();
            if (resp.responseAjax == 'SUCCESS') {
                // $('iframe').attr('src', resp.doc);
                $('#modal-sign').modal('hide');
                // $('#modal-confirm').modal();

                console.log('signval',resp.signeval)
                $('#img-sign').attr('src',resp.signeval);
                $('.clshow').show();
                
                if($('#type').val() == 'I' || $('#type').val() == 'A'){
                    $('#idct').val(resp.idct)
                    $('#codekey').val(resp.codekey)
                }
                

                signeval = resp.signeval;
            
                $('#sign-show').show();
                $('.sign-show').hide();
                $('.inscOk').hide();
                // $('#formulairedevis').submit();
                

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