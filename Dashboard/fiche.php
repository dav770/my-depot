<?php include 'including/config.php';?>
<?php
if (!isset($_GET['id_fiche']))
	header('Location: fiches.php');

$outdocs = '';
if ($_GET['id_fiche'] == '0')
	$curusr = false;
else {

	$curusr = Fiche::findOne(array('c.id_fiche' => (int)$_GET['id_fiche']));
	// echo $curusr->tot_ht;
	if ($curusr) {
		// if (!Fiche::checkRight($curusr)){
		// 	header('Location: fiches.php');
		// }
		
		if ($arrAccess['isAdmin'] != '1' && $arrAccess['visu_client'] != '1'){
			
			header('Location: fiches.php');
		}
		$outdocs = Grid4PHP::getGrid('db_contacts_docs', (int)$_GET['id_fiche']);
		
	} else{
		
		header('Location: fiches.php');
	}
}

// $tarifadulte = Tarif::findOne()
// $tarifenfant
// $tarifbb

// echo ($arrAccess['isAdmin'] != '1' && $arrAccess['send_doc_fiche_client'] != '1' ? print_r($arrAccess) : 'btlnkdevis' );

$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));

$bqs = InfosGenes::getAllBq();

$comments = Comment::getBy('id_fiche = '.(int)$_GET['id_fiche'].' AND type_comment IN (0)');
$reminders = Comment::getBy('id_fiche = '.(int)$_GET['id_fiche'].' AND type_comment IN (1)');
// $commentsplans = Comment::getBy('id_fiche = '.(int)$_GET['id_fiche'].' AND type_comment IN (2, 3)');
$docs = Doc::getBy(array('id_fiche' => (int)$_GET['id_fiche']));
$mtypes = ModelMail::find("");
$stypes = SMSType::find("");
$affStagiaireMail = false;

$outdetails = Grid4PHP::getGrid('db_contacts_details', $_GET['id_fiche'], $curusr->last_name);
$outdetailsoptions = Grid4PHP::getGrid('db_contacts_details_options', $_GET['id_fiche'], $usrActif->cursoc);
$outdettransp = Grid4PHP::getGrid('db_contacts_transports_details', $_GET['id_fiche'], $usrActif->cursoc);

// $outch = QueryType::query('db_contacts_chambres', '*', array('id_fiche'=>$_GET['id_fiche']));
$outch = Chambres::getAllDetails(array('cc.id_fiche'=>$_GET['id_fiche']));

$devises = Setting::getAllDevises();

$outvirement = Grid4PHP::getGrid('inf_virements_client', (int)$_GET['id_fiche'], $usrActif->cursoc);

$sej = Setting::getOrganisateur(array('id_organisateur'=>$usrActif->cursoc));

$isbar = Bar::soldeBar("SELECT SUM(COALESCE(prix_reste_bar)) AS solde FROM db_bar WHERE id_fiche = ".(int)$_GET['id_fiche']." AND id_sejour = ".(int)$usrActif->cursoc, true);
$isextra = Extra::soldeExtra("SELECT SUM(COALESCE(mt_restant)) AS solde FROM db_extra_activites WHERE id_fiche = ".(int)$_GET['id_fiche']." AND id_sejour = ".(int)$usrActif->cursoc, true);

?>

<?php include 'including/headPage.php'; ?>



<?php /*
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
*/?>
<!-- <link rel="stylesheet" href="https://unpkg.com/govicons@latest/css/govicons.min.css"> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<link rel="stylesheet" href="css/menu.css">
<style>
#id_sel_filtre_chosen{
	width: 300px !important;
}
	

.timeline-steps .timeline-content .inner-circle-yellow {
    border-radius: 100%;
    height: 5rem;
    width: 5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #e6dc53;
    box-shadow: 7px 6px 0px gray;
}

.timeline-steps .timeline-content .inner-circle-yellow:before {
    content: "";
    background-color: #FFF;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5;
    box-shadow: 10px 5px 5px gray;
    /*
    animation-name: clickbtn;
    animation-duration: 4s;
    animation-iteration-count: infinite;
    */
}

.alertconf  {
   animation-duration: 1.8s;
   animation-name: clignoter;
   animation-iteration-count: infinite;
   transition: none;
  color: 
}
@keyframes clignoter {
  0%   { color:#000000; }
  40%   {color:#ff0303; }
  100% { opacity:#000000; }
}

#example_filter{
	float:right;
}
#example_paginate{
	float:right;
}
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

.alertes {
   animation-duration: 1.3s;
   animation-name: clignoter;
   animation-iteration-count: infinite;
   transition: none;
  color: 
}
@keyframes clignoter {
  0%   { color:#000000; }
  /* 40%   {color:#F1A200; } */
  40%   {color:red; }
  100% { opacity:#000000; }
}

</style>

<!-- Page content -->
<div id="page-content" class="page-contact">
	<!-- eCommerce Dashboard Header -->
	<div class="content-header">
		<?php include('including/mainMenu.php'); ?>
	</div>
	<!-- END eCommerce Dashboard Header -->

	<!-- eShop Overview Block -->
	
	<div class="block full row" >
		<!-- eShop Overview Title -->
		<div class="row">
			<div class="col-lg-12">
				<!-- Normal Form Title -->
				<div class="block-title">
					<?php if($isextra->solde > 0){ ?>
						<span id="alertesExtra" class="pull-left label alertes btn" style="height: 35px;display: block;padding: 10px;font-size:large"> Activitée(s) non soldée(s) </span>
					<?php } ?>
					<?php if($isbar->solde > 0){ ?>
						<span id="alertesBar" class="pull-left label alertes btn" style="height: 35px;display: block;padding: 10px;font-size:large"> Bar non soldé </span>
					<?php } ?>
					<span class="label label-info" style="height: 35px;display: block;padding-top: 10px;font-size: large;">N° <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client' : 'Customer') ?> : <?php echo ($curusr ? $curusr->id_fiche.' - <span style="color:#000">[ '.($curusr->civ_contact == '' ? '' : ($curusr->civ_contact == '1' ? 'Mr' : 'Me')).' '.$curusr->last_name.' '.$curusr->first_name.' ]</span>' : 0); ?></span>
					<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations Client' : 'Customer informations') ?></strong> </h2>
					<?php if ($curusr) { ?>
						<div class="block-options pull-right">								
							<a href="#" class="btn btn-sm btn-info fa-5 fa-3dicon" id="btemailfiche" style="margin-right:5px;border-radius:3px;" title="Envoi Email" data-toggle="tooltip"><i class="fa fa-envelope-o" <?php echo ($arrAccess['send_mail_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail' : 'Send email') ?></a>
							
							<?php if($arrAccess['isAdmin'] == '1' || $arrAccess['send_sms_fiche_client'] == '1' ) { ?>
								<a href="#" class="btn btn-sm btn-warning btsmspres fa-5 fa-3dicon" title="Envoyer un SMS" data-toggle="tooltip" style="margin-right: 5px;border-radius:3px;"><i class="fa fa-send" <?php echo ($arrAccess['send_sms_client'] != '1' ? 'disabled="disabled"' : '' ) ?>></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi SMS' : 'Send SMS') ?></a>
							<?php } ?>

							<?php if($arrAccess['imp_doc_fiche_client'] == '1') {?>		
								<div class="btn-group btn-group-sm">					
									<a href="#" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false" ><i class="fa fa-print"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Impression des documents' : 'Printing of documents') ?><span class="caret"></span></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<!-- <li>
											<a href="#" class="" id="btall"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Documents fusionnés' : 'Merged documents') ?></a>
										</li> -->
										<!-- <li>
											<a href="#" class="" id="btcgv">CGV</a>
										</li> -->
										<!-- <li>
											<a href="#" class="" id="btinscription"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription' : 'Registration') ?></a>
										</li>
										<li>
											<a href="#" class="" id="btcontrat"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat' : 'Contract') ?></a>
										</li> -->
										<li>
											<a href="#" class="" id="btfacture"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Facture' : 'Invoice') ?></a>
										</li>
										<li>
											<a href="#" class="" id="btfrais"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Note de frais' : 'Expense report') ?></a>
										</li>
									</ul>	
								</div>						
							<?php }?>
					
							
							<?php if($arrAccess['annule_fiche_client'] == '1') { ?>
								<a href="#" class="btn btn-sm btn-danger" id="btannule"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annulation du dossier' : 'Cancellation of file') ?></a>
							<?php } ?>							
						</div>
					<?php } ?>

				</div>
				<!-- END Normal Form Title -->
				<a href="#" class="btn btn-sm btn-default" id="btinfcligene"><i class="<?php echo ($curusr->lnk_contrat_signed > 0 || 1==1 ? "fa fa-angle-up" : "fa fa-angle-down") ?>"></i><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' Afficher déatils client' : ' Display customer details') ?></a>
				
				<div class="" id="infcligene" style="<?php echo (($curusr->lnk_contrat_signed > 0 || 1==1) && $curusr->id_fiche > 0 ? 'display:none' : '') ?>">
					<span style="font-size:medium" class="alertconf"><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N\'oubliez pas de valider vos modifications' : 'Don\'t forget to validate your changes') ?></strong></span>

					<form onsubmit="return false;" class="form-horizontal" method="post" action="appajax.php" id="formulairect">
						<div class="">
							<div class="blok-full">
								<div class="col-md-6">
									<fieldset>	
										<div class="form-group" style="border-bottom: solid 3px #ccc;margin-bottom: 10px;">
											<label for="id_organisateur" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay') ?></label>
											<div class="col-md-9">
												<select data-placeholder="Choix..." class="form-control select-chosen" id="id_organisateur" name="id_organisateur" readonly>
													<option value=""></option>
													<?php
													$mds = Setting::getAllorganisateurs();
													if ($mds) {
														foreach ($mds as $md) {
															$issel = $curusr ? ($md['id_organisateur'] == $curusr->id_organisateur ? 'selected="selected"' : '') : ($md['id_organisateur'] == max($usrActif->cursoc, 1) ? 'selected="selected"' : '');
															echo '<option value="' . $md['id_organisateur'] . '" ' . $issel . '>' . $md['name_organisateur'] . '</option>';
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group" >
											<label for="id_status_sec" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etat du dossier' : 'Status of folder') ?></label>
											<div class="col-md-9">
												<select data-placeholder="Choix..." class="form-control select-chosen" id="id_status_sec" name="id_status_sec" <?php echo $arrAccess['change_statut_client'] != '1' ? 'readonly="readonly"' : ''; ?>>
													<option value=""></option>
													<?php
													$sts = Setting::getAllStSec();
													if ($sts) {
														foreach ($sts as $st) {
															$issel = $curusr ? ($st['id_status_sec'] == $curusr->id_status_sec ? 'selected="selected"' : '') : (strstr($st['name_status_sec'], 'NOUVEAU') ? 'selected="selected"' : '');
															echo '<option value="' . $st['id_status_sec'] . '" ' . $issel . '>' . $st['name_status_sec'] . '</option>';
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group" >
											<label for="lg" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Langage' : 'Language') ?></label>
											<div class="col-md-9">
												<select class="form-control" name="lg" id="lg">
													<option value="FR" <?php echo $curusr && $curusr->lg == 'FR' ? 'selected="selected"' : ''; ?>>FR</option>
													<option value="ENG" <?php echo $curusr && $curusr->lg == 'ENG' ? 'selected="selected"' : ''; ?>>ENG</option>
												</select>
											</div>
										</div>
										
										<div class="form-group" >
											<label for="civ_contact" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Civilité' : 'Title') ?></label>
											<div class="col-md-9">
												<select class="form-control" name="civ_contact" id="civ_contact" required>
													<option value="0" <?php echo $curusr && $curusr->civ_contact == '0' ? 'selected="selected"' : ''; ?>></option>
													<option value="1" <?php echo $curusr && $curusr->civ_contact == '1' ? 'selected="selected"' : ''; ?>>M.</option>
													<option value="2" <?php echo $curusr && $curusr->civ_contact == '2' ? 'selected="selected"' : ''; ?>>Mme</option>
													<option value="3" <?php echo $curusr && $curusr->civ_contact == '3' ? 'selected="selected"' : ''; ?>>Mlle</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="first_name" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom du contact' : 'First name') ?> </label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le prénom..." class="form-control" name="first_name" id="first_name" value="<?php echo ucfirst($curusr->first_name); ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="last_name" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom du contact' : 'Last name') ?> <span class="text-danger">*</span></label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le nom..." class="form-control" name="last_name" id="last_name" value="<?php echo strtoupper($curusr->last_name); ?>" required>
											</div>
										</div>

										<!-- <div class="form-group iscli">
											<label for="date_birth" class="col-md-3 control-label">Date naissance </label>
											<div class="col-md-3" style="display: flex">
												<input type="text" style="text-align:center;margin-right:5px" class="form-control" placeholder="JOUR" name="day_birth" id="day_birth" value="<?php echo $curusr->date_birth > 0 ? date('d', strtotime($curusr->date_birth)) : ''; ?>"  ><label for="date_birth" style="margin-top: 12px;margin-right: 5px;" class="">JOUR</label>
												<input type="text" style="text-align:center;margin-right:5px" class="form-control" placeholder="MOIS" name="month_birth" id="month_birth" value="<?php echo $curusr->date_birth > 0 ? date('m', strtotime($curusr->date_birth)) : ''; ?>"  ><label for="date_birth" style="margin-top: 12px;margin-right: 5px;" class="">MOIS</label> 
												<input type="text" style="text-align:center;margin-right:5px" class="form-control" placeholder="ANNEE" name="year_birth" id="year_birth" value="<?php echo $curusr->date_birth > 0 ? date('Y', strtotime($curusr->date_birth)) : ''; ?>"  ><label for="date_birth" style="margin-top: 12px;margin-right: 5px;" class="">ANNEE</label> 
											</div>
										</div> -->
										<a href="#" class="btn btn-sm btn-default" id="btaddbd"><i class="<?php echo ($curusr->lnk_contrat_signed > 0 || 1==1 ? "fa fa-angle-up" : "fa fa-angle-down") ?>"></i></a>
										<div class="form-group iscli bd" style="display:none">
											<label for="date_birth" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date naissance' : 'Date of birth') ?> </label>
											<div class="col-md-9">
												<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_birth" id="date_birth" value="<?php echo $curusr->date_birth > 0 ? date('d/m/Y', strtotime($curusr->date_birth)) : ''; ?>"  >
												<!-- <input type="input" class="form-control" placeholder="dd/mm/yyyy" name="date_birth" id="date_birth" value="<?php echo $curusr->date_birth > 0 ? date('d/m/Y', strtotime($curusr->date_birth)) : ''; ?>"  > -->
											</div>
										</div>
												
									</fieldset>
							
									<div class="form-group">
										<label for="tel1" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tèl. principal' : 'Main phone') ?> <span class="text-danger">*</span></label>
										<div class="col-md-8">
											<input type="text" placeholder="Saisissez le téléphone principal..." class="form-control" name="tel1" id="tel1" value="<?php echo $curusr->tel1; ?>"  >
										</div>
										<button class="btn btn-sm btn-primary" title="Inversez les Tèl." id="btreversetel" type="button"><i class="fa fa-exchange"></i></button>
									</div>

									<a href="#" class="btn btn-sm btn-default" id="btaddph2"><i class="<?php echo ($curusr->lnk_contrat_signed > 0 || 1==1 ? "fa fa-angle-up" : "fa fa-angle-down") ?>"></i></a>
									<div class="form-group ph2" style="display:none">
										<label for="tel2" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tèl. secondaire' : 'Secondary phone') ?> </label>
										<div class="col-md-9">
											<input type="text" placeholder="Téléphone supplementaire..." class="form-control" name="tel2" id="tel2" value="<?php echo $curusr->tel2; ?>" >
										</div>
									</div>
									<div class="form-group">
										<label for="email" class="col-md-3 control-label">Email <span class="text-danger">*</span></label>
										<div class="col-md-9">
											<input type="email" placeholder="Saisissez l'adresse email..." class="form-control" name="email" id="email" value="<?php echo $curusr->email; ?>"  >
										</div>
									</div>
									
									<div class="form-group">
										<label for="adr1" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse' : 'Adress') ?> </label>
										<div class="col-md-9">
											<input type="text" placeholder="Saisissez l'adresse..." class="form-control" name="adr1" id="adr1" value="<?php echo $curusr->adr1; ?>"  >
										</div>
									</div>
									<div class="form-group">
										<label for="city" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ville' : 'City') ?> </label>
										<div class="col-md-9">
											<input type="text" placeholder="Saisissez la ville..." class="form-control" name="city" id="city" value="<?php echo $curusr->city; ?>" >
										</div>
									</div> 

									<a href="#" class="btn btn-sm btn-default" id="btaddadr"><i class="<?php echo ($curusr->lnk_contrat_signed > 0 || 1==1 ? "fa fa-angle-up" : "fa fa-angle-down") ?>"></i></a>
									<div class="form-group addadr" style="display:none">
										<label for="adr2" class="col-md-3 control-label">Compl. <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'adresse' : 'adress') ?></label>
										<div class="col-md-9">
											<input type="text" placeholder="Complément d'adresse..." class="form-control" name="adr2" id="adr2" value="<?php echo $curusr->adr2; ?>"  >
										</div>
									</div>
									<div class="form-group addadr" style="display:none">
										<label for="post_code" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code postal' : 'Zip code') ?> </label>
										<div class="col-md-6">
											<input type="text" placeholder="Saisissez le code postal..." class="form-control" name="post_code" id="post_code" value="<?php echo $curusr->post_code; ?>" >
										</div>
									</div>									
									<div class="form-group addadr" style="display:none">
										<label for="country" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pays' : 'Country') ?> </label>
										<div class="col-md-9">
											<input type="text" placeholder="Saisissez le pays..." class="form-control" name="country" id="country" value="<?php echo $curusr->country; ?>" >
										</div>
									</div>	
									<hr>
									<a href="#" class="btn btn-sm btn-default" id="btaddinfcreate"><i class="<?php echo ($curusr->lnk_contrat_signed > 0 || 1==1 ? "fa fa-angle-up" : "fa fa-angle-down") ?>"></i></a>
									<div class="infcreate" style="display:none">
										<div class="form-group <?php echo $arrAccess['isAdmin'] == '1' ? '' : 'display-none' ?>">
											<label for="source" class="col-md-3 control-label">Source</label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez la source..." class="form-control " name="source" id="source" value="<?php echo $curusr->source; ?>">
											</div>
										</div>
										
										<div class="form-group">
											<label for="annee" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Année' : 'Year') ?></label>
											<div class="col-md-9">
												<input type="text" class="form-control" name="annee" id="annee" value="<?php echo $curusr->annee; ?>" readonly="readonly">
											</div>
										</div>
										<div class="form-group">
											<label for="date_create" class="col-md-3 control-label">Date <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'création' : 'create') ?></label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="date_create" id="date_create" readonly="readonly" value="<?php echo $curusr->date_create > 0 ? date('d/m/Y H:i', strtotime($curusr->date_create)) : ''; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="date_update" class="col-md-3 control-label">Date modif.</label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="date_update" id="date_update" readonly="readonly" value="<?php echo $curusr->date_update > 0 ? date('d/m/Y H:i', strtotime($curusr->date_update)) : ''; ?>">
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group" style="border-bottom: solid 3px #ccc;margin-bottom: 10px;margin-left: 35px; margin-top: 15px;color:red">
										<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Information de facturation' : 'Billing information') ?>
										<a href="#" class="btn btn-sm btn-default" id="btinfclifact"><i class="fa fa-angle-up"></i></a>
									</div>
									<div id="infclifact" style="display:none">
										<div class="form-group" >
											<label for="raison_sociale" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Raison Sociale' : 'Social reason') ?></label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="raison_sociale" id="raison_sociale" value="<?php echo $curusr->raison_sociale; ?>" >
											</div>
										</div>
										<div class="form-group" >
											<label for="siret" class="col-md-3 control-label">Siret</label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le siret..." class="form-control" name="siret" id="siret" value="<?php echo $curusr->siret; ?>" >
											</div>
										</div>
										<div class="form-group" >
											<label for="adr_facture" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse de facturation' : 'Billing adress') ?></label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="adr_facture" id="adr_facture" value="<?php echo $curusr->adr_facture; ?>" >
											</div>
										</div>
										<div class="form-group" >
											<label for="city_facture" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ville de facturation' : 'Billing city') ?></label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="city_facture" id="city_facture" value="<?php echo $curusr->city_facture; ?>" >
											</div>
										</div>
										<div class="form-group" >
											<label for="post_code_facture" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'CP de facturation' : 'Billing zip code') ?></label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="post_code_facture" id="post_code_facture" value="<?php echo $curusr->post_code_facture; ?>" >
											</div>
										</div>
										<div class="form-group" >
											<label for="country_facture" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pays de facturation' : 'Billing country') ?></label>
											<div class="col-md-9">
												<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="country_facture" id="country_facture" value="<?php echo $curusr->country_facture; ?>" >
											</div>
										</div>
										
										<div class="form-group">
											<label for="id_usrApp" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur' : 'User') ?></label>
											<div class="col-md-9">
												<select data-placeholder="Choisissez l'Utilisateur de saisie..." class="form-control select-chosen" id="id_usrApp" name="id_usrApp" <?php echo $arrAccess['isAdmin'] != '1' ? 'disabled="disabled"' : ''; ?>>
													<option value=""></option>
													<?php
													$whoUsrs = UsrApp::getAll($arrAccess['isAdmin'] != '1' ? array('id_equipe' => $usrActif->id_equipe) : '');
													if ($whoUsrs) {
														foreach ($whoUsrs as $whoUsr) {
															echo '<option value="' . $whoUsr['id_usrApp'] . '" ' . ($whoUsr['id_usrApp'] == $curusr->id_usrApp ? 'selected="selected"' : '') . '>' . $whoUsr['user_name'] . '</option>';
														}
													}
													?>
												</select>
											</div>
										</div>
									</div>

									<input type="hidden" id="infoprofil" value="<?php echo $usrActif->id_profil ?>" />
									<input type="hidden" name="isadminconnect" id="isadminconnect" value="<?php echo $arrAccess['isAdmin'] = '1' ? '1' : '0'; ?>" />
									<!-- <input type="hidden" name="date_birth" id="date_birth" value="" /> -->
									<input type="hidden" name="action" id="action" value="maj-fiche" />
									<input type="hidden" name="id_fiche" id="id_fiche" value="<?php echo $_GET['id_fiche']; ?>" />
									<input type="hidden" id="iscustomer" value="<?php echo $curusr->is_customer ?>" />
									<!-- END Normal Form Content -->
									<?php /*if (!$curusr) { */?>
										<div style="display: flex;justify-content: center;">
											<div class="form-group form-actions" <?php echo ($arrAccess['modif_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>>
												<button class="btn btn-sm btn-primary" type="submit" id="btupdatect"><i class="fa fa-user"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
												<button class="btn btn-sm btn-warning clresetct" type="reset"><i class="fa fa-repeat"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel') ?></button>
											</div>
										</div>
									<?php /* } */?>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?php if ($curusr) { ?>
					<div class="row" style="">
						<div class="" style="justify-content:center;display:flex">
							<div class="icon-tab col-sm-2  ">
								<span class="glyphicon glyphicon-folder-open"></span>
								<span class="icon-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails du dossier' : 'File details') ?></span>
							</div>
							<div class="icon-tab col-sm-2  ">
								<span class="glyphicon glyphicon-bed"></span>
								<span class="icon-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Chambres' : 'Rooms') ?></span>
							</div>
							<!-- <div class="icon-tab col-sm-2 ">
								<span class="glyphicon glyphicon-list-alt"></span>
								<span class="icon-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Facturation' : 'Billing') ?></span>
							</div> -->
							<div class="icon-tab col-sm-2 ">
								<span class="glyphicon glyphicon-euro"></span>
								<span class="icon-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Règlements' : 'Payments') ?></span>
							</div>
							<div class="icon-tab col-sm-2 ">
								<span class="glyphicon glyphicon-comment"></span>
								<span class="icon-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappels & Commentaires' : 'Reminders & Comments') ?></span>
							</div>
							<div class="icon-tab col-sm-2">
								<span class="glyphicon glyphicon-file"></span>
								<span class="icon-label">Documents</span>
							</div>
						</div>
					</div>

					<div class="tab-content" id="itemtab1">
						<div class="item">
    						<div class="panel panel-default">
								<div class="block">
									
									<form onsubmit="return false;" class="form-bordered form-horizontal" method="post" action="appajax.php" id="formulairedetails" style="margin-top: 0px;">
										<fieldset>	
											<div class="row">
												<div class="col">
													<div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
														<div class="step0 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003"> -->
															<div class="timeline-content <?php echo $curusr->lnk_devis > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription envoyée' : 'Sended registration') ?>" data-original-title="">
																<div id="<?php echo ($arrAccess['send_doc_fiche_client'] != '1' || $curusr->inscript_auto > 0 ? '' : ($infgene->is_auto_mail > 0 ? 'btlnkdevis' : 'btsendinfmail') ) ?>" class="tooltip-circle pointer <?php echo $curusr->lnk_devis > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"><span class="tooltiptext"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'envoi du devis en signature et accés au contrat' : 'Sending the quote for signature to access the contract') ?></span></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_devis > 0 ? 'text-primary' : 'text-muted' ?>" ><?php echo $curusr->lnk_devis > 0 ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription envoyée' : 'Registration sended') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoyer l\'inscription' : 'Send the registration') ?></p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt0" style="font-weight: bold;"><?php echo $curusr->notProcessedDate ?></p> -->
															</div>
														</div>
														<div class="step1 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004"> -->
															<div class="timeline-content <?php echo $curusr->lnk_devis_signed > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription signée' : 'Signed registration') ?>" data-original-title="">
																<div class="<?php echo $curusr->lnk_devis_signed > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_devis_signed > 0 ? 'text-primary' : 'text-muted' ?>" ><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription signée' : 'Signed registration') ?></p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt1" style="font-weight: bold;"><?php echo $curusr->validatedDate ?></p> -->
															</div>
														</div>
														<?php if($curusr->lnk_contrat_sended > 0){ ?>
															<div class="step2 timeline-step">
																<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005"> -->
																<div class="timeline-content <?php echo $curusr->lnk_contrat_signed > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat signé (électronique)' : 'Signed contract(electronic)') ?>" data-original-title="">
																	<div id="<?php echo ($arrAccess['send_contrat_fiche_client'] == '1' ? '' : ($infgene->is_auto_mail > 0 ? 'btlnkcontrat' : 'btsendinfmailcont') ) ?>" class="tooltip-circle pointer <?php echo $curusr->lnk_contrat_sended > 0 ? 'inner-circle-yellow' : 'inner-circle-fad' ?>"><span class="tooltiptext"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'envoi du contrat en signature' : 'Sending the contract for signature') ?></span></div>
																	<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_contrat_sended > 0 ? 'text-primary' : 'text-muted' ?>" ><?php echo $curusr->lnk_contrat_sended > 0 ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat envoyé' : 'Contract sended') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat signé (électronique)' : 'Signed contract (electronic)') ?></p>
																	<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt2" style="font-weight: bold;"><?php echo $curusr->acceptedDate ?></p> -->
																</div>
															</div>
														<?php }else{ ?>
															<div class="step2 timeline-step">
																<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005"> -->
																<div class="timeline-content <?php echo $curusr->lnk_contrat_signed > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat signé (électronique)' : 'Signed contract(electronic)') ?>" data-original-title="">
																	<div id="<?php echo ($arrAccess['send_contrat_fiche_client'] == '1' ? '' : ($infgene->is_auto_mail > 0 ? 'btlnkcontrat' : 'btsendinfmailcont') ) ?>" class="tooltip-circle pointer <?php echo $curusr->lnk_contrat_signed > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"><span class="tooltiptext"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'envoi du contrat en signature' : 'Sending the contract for signature') ?></span></div>
																	<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_contrat_signed > 0 ? 'text-primary' : 'text-muted' ?>" ><?php echo $curusr->lnk_contrat_signed > 0 ?($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat signé (électronique)' : 'Signed contract (electronic)') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat envoyé' : 'Contract sended') ?></p>
																	<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt2" style="font-weight: bold;"><?php echo $curusr->acceptedDate ?></p> -->
																</div>
															</div>
														<?php } ?>
														<?php /*
														<div class="step3 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010"> -->
															<div class="timeline-content"  data-trigger="hover" data-placement="top" title="" data-content="Règlement partiel" data-original-title="">
																<div class="btreadpay tooltip-circle  pointer <?php echo $curusr->lnk_devis > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"><span class="tooltiptext">Voir les règlements</span></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_devis > 0 ? 'text-primary' : 'text-muted' ?>" >Règlement partiel</p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt3" style="font-weight: bold;"><?php echo $curusr->inTrainingDate ?></p> -->
															</div>
														</div>
														*/ ?>
														<div class="step4 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010"> -->
															<div class="timeline-content <?php echo $curusr->lnk_reglement > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Règlement(s) effectué(s)' : 'Payment made') ?>" data-original-title="">
																<!-- <div class="btreadpay tooltip-circle pointer <?php echo $curusr->lnk_reglement > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"></div> -->
																<div class="<?php echo $curusr->lnk_reglement > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_reglement > 0 ? 'text-primary' : 'text-muted' ?>" ><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Règlement(s) effectué(s)' : 'Payment made') ?></p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt4" style="font-weight: bold;"><?php echo $curusr->terminatedDate ?></p> -->
															</div>
														</div>
														<div class="step5 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010"> -->
															<div class="timeline-content <?php echo $curusr->lnk_facture > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Facturé' : 'Invoice') ?>" data-original-title="">
																<div id="<?php echo ($arrAccess['send_doc_fiche_client'] != '1' ? '' : 'btlnkfac' ) ?>" class="tooltip-circle pointer <?php echo $curusr->lnk_facture > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"><span class="tooltiptext"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'envoi de la facture' : 'Send invoice') ?></span></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_facture > 0 ? 'text-primary' : 'text-muted' ?>" ><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Facturé' : 'Invoice') ?></p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt5" style="font-weight: bold;"><?php echo $curusr->lnk_facture ?></p> -->
															</div>
														</div>
														<div class="step6 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010"> -->
															<div class="timeline-content <?php echo $curusr->lnk_annule > 0 ? 'time-lnk-annule' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annulé' : 'Canceled') ?>" data-original-title="">
															<div id="" class="tooltip-circle pointer <?php echo ($arrAccess['annule_fiche_client'] != '1' ? '' : 'btannule' ) ?>  <?php echo $curusr->lnk_annule > 0 ? 'inner-circle-red' : 'inner-circle-red-fad' ?>"><span class="tooltiptext"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annulation complète de la Fiche' : 'Complete cancellation') ?></span></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_annule > 0 ? 'text-primary' : 'text-muted' ?>" ><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annulé' : 'Canceled') ?></p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt6" style="font-weight: bold;"><?php echo $curusr->serviceDoneValidatedDate ?></p> -->
															</div>
														</div>
														
													</div>
												</div>

												<div class="col-md-12">
													<!-- <a href="#" style="margin-bottom:15px" class="btn btn-sm btn-default" id="btinfclidetails"><i class="fa fa-angle-down"></i></a> -->
													<!-- <div id="infclidetails" style="<?php echo ($curusr->lnk_contrat_signed > 0 || 1==1 ? 'display:none' : '') ?>"> -->
													
														<!-- <div class="block-title"> -->
															<!-- <legend> -->
																<!-- <i class="gi gi-world text-primary"></i> -->
																<i class="fa fa-globe text-primary" style="font-size:36px"></i>
																<strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails' : 'Customer') ?></strong> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'séjour' : 'stay') ?>
																<span style="margin-left:25px;font-size:medium" class="alertconf"><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N\'oubliez pas de valider vos modifications' : 'Don\'t forget to validate your changes') ?></strong></span>
															<!-- </legend>		 -->
															
															<!-- <div class="block-options pull-right">
															</div>	
															<div class="block-options pull-left">	
																
																<legend class="display-none">
																	<div class="" style="">
																		<div class="block-options">
																			<div class="pull-right">
																				<span class="" style=";padding-right:50px"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code confidentiel :' : 'Personal code') ?> <em class="badge" style="background-color:red;color:black" id="cdcf"><?php echo $curusr->codekey.$curusr->id_fiche ?></em></span>
																			</div>
																			
																		</div>
																	</div>	
																</legend>
															</div>	 -->
														<!-- </div> -->
														<!-- END Normal Form Title -->
	
														<!-- <div class="form-group">
															<div class="col-md-3">
																<label for="nb_lit_bb_souhait" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb lit bébé' : 'Nb baby bed') ?></label>
																<input type="text" class="form-control" name="nb_lit_bb_souhait" id="nb_lit_bb_souhait" value="<?php echo $curusr->nb_lit_bb_souhait ?>">
															</div>																							
															<div class="col-md-3">
																<label for="terrasse_balcon_souhait" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Terrasse - Balcon' : 'Terrace - Balcony') ?></label>
																<div>
																	<label class="switch switch-primary">
																		<input type="checkbox" id="terrasse_balcon_souhait" name="terrasse_balcon_souhait" <?php echo $curusr && $curusr->terrasse_balcon_souhait > 0 ? 'checked="true"' : ''; ?>><span></span>
																	</label>
																</div>
															</div>																							
														</div> -->
														<div class="form-group">
															
															<!-- <div class="col-md-3">
																<label for="nb_adulte" class="control-label">Nombre Adulte(s)</label>
																<input type="text" class="form-control" name="nb_adulte" id="nb_adulte" value="<?php echo $curusr->nb_adulte > 0 ? $curusr->nb_adulte : ''; ?>" required>
															</div>	 -->
															<!-- <div class="col-md-3">	
																<a href="#"  style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;width: 98px;" class="form-control btn btn-sm btn-success btaddadulte" id="btaddadulte">Ajoutez Infos</a>
															</div> -->
														</div>
	
													<!-- </div>	 -->
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-1">
												</div>
												<div class="col-md-1">
													<label for="date_start" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de début' : 'Date start') ?></label>
													<input type="text" style="background-color:#c1eaf7" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_start" id="date_start" value="<?php echo $curusr->date_start > 0 ? date('d/m/Y', strtotime($curusr->date_start)) : ''; ?>">
												</div>																							
												<div class="col-md-1">
													<label for="time_start" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Heure d\'arrivée' : 'Arriving time') ?></label>
													<input type="time" style="background-color:#c1eaf7" class="form-control "  name="time_start" id="time_start" value="<?php echo $curusr->time_start ?>" >
												</div>																							
												<div class="col-md-6"></div>
												<div class="col-md-1">
													<label for="date_end" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de fin' : 'Date end') ?></label>
													<input type="text"  style="background-color:#f7e8c1" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_end" id="date_end" value="<?php echo $curusr->date_end > 0 ? date('d/m/Y', strtotime($curusr->date_end)) : ''; ?>">
												</div>
												<div class="col-md-1">
													<label for="time_end" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Heure départ' : 'Departure time') ?></label>
													<input type="time" style="background-color:#f7e8c1" class="form-control "  name="time_end" id="time_end" value="<?php echo $curusr->time_end ?>" >
												</div>
											</div>

											<div class="form-group <?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												<div class="col-md-3">
													<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Liste des personnes' : 'List of people') ?>											
												</div>
												<div id="contentadulte1" class="table-responsive col-md-12">
													<?php echo $outdetails ?>
												</div>
											</div>								
											<div class="form-group <?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												<div class="col-md-3">
													<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Options supplémentaires' : 'Additional options') ?>											
												</div>
												<div id="contentadulte2" class="table-responsive col-md-12">
													<?php echo $outdetailsoptions ?>
												</div>
											</div>
													<!-- A VOIR SI AFFICHE PAR DEFAUT OU SUR DEMANDE  -->
											<div class="form-group <?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												<div class="col-md-3">
													<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Options transports' : 'Travels options') ?>											
												</div>
												<div id="contentadulte3" class="table-responsive col-md-12">
													<?php echo $outdettransp ?>
												</div>
											</div>		

											<div class="form-group" style="display:none">
												<div class="col-md-3">
													<label class="switch switch-primary">
														<input type="checkbox" id="handicap" name="handicap" <?php echo $curusr && $curusr->handicap > 0 ? 'checked="true"' : ''; ?>><span></span>
													</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Situation d\'handicap' : 'Disability') ?>
												</div>
												<div class="col-md-6">
													<label class="switch switch-primary">
														<textarea placeholder="Infos handicap.." class="form-control" name="comment_handicap" id="comment_handicap" style="width:826px;height: 64px;"><?php echo $curusr->comment_handicap ?></textarea>
													</label> 
												</div>
												
												<!-- <div class="col-md-3">
													<label for="date_contrat" class="control-label">Date de contrat</label>
													<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy"  name="date_contrat" id="date_contrat" value="<?php echo strtotime($curusr->date_contrat) > 0 ? date('d/m/Y', strtotime($curusr->date_contrat)) : ''; ?>" disabled="disabled">
												</div> -->
											
											</div>
															<?php/* inf montant facture */?>
											<div class="col-md-3">
												<label for="mt_fin" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant réel' : 'Real amount') ?></label>
												<?php /*<input type="text" class="form-control" id="mt_fin" value="<?php echo ($infgene->is_decimal > 0 ? number_format(($curusr->tot_real / ((100 - $curusr->offre_sejour) / 100)) - $curusr->taxe_sejour,2) : number_format(($curusr->tot_real / ((100 - $curusr->offre_sejour) / 100)) - $curusr->taxe_sejour)); ?> €" readonly> */ ?>
												<input type="text" class="form-control" id="mt_fin" value="<?php echo ($infgene->is_decimal > 0 ? number_format(($curusr->tot_real / ((100 - $curusr->offre_sejour) / 100)),2) : number_format(($curusr->tot_real / ((100 - $curusr->offre_sejour) / 100)))); ?> €" readonly>
											</div>
											
											<div class="col-md-3">
												<label for="taxe_sejour" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Taxe séjour' : 'City tax') ?></label>
												<!-- <input type="text" class="form-control" name="taxe_sejour" id="taxe_sejour" value="<?php echo ($infgene->is_decimal > 0 ? number_format($curusr->taxe_sejour,2) : number_format($curusr->taxe_sejour)); ?>"> -->
												<input type="text" class="form-control" name="taxe_sejour" id="taxe_sejour" value="<?php echo ($infgene->is_decimal > 0 ? $curusr->taxe_sejour : $curusr->taxe_sejour); ?>">
											</div>

											<div class="col-md-2">
												<div class="cltotmanu <?php echo ($curusr->is_tot_manu > 0 ? '' : 'display-none')?>">
													<label for="tot_manu" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mt manuel' : 'Manual amount') ?></label>
													<!-- <input type="text" class="form-control" name="tot_manu" id="tot_manu" value="<?php echo ($infgene->is_decimal > 0 ? number_format($curusr->tot_manu,2) : number_format($curusr->tot_manu)); ?> " <?php echo ($curusr->is_tot_manu > 0 ? "" : "disabled='disabled'" )?> > -->
													<input type="text" class="form-control" name="tot_manu" id="tot_manu" value="<?php echo ($infgene->is_decimal > 0 ? $curusr->tot_manu : $curusr->tot_manu); ?> " >
												</div>
											</div>
											
											<div class="col-md-2">
												<label for="tot_ht" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mt appliqué (taxe incluse)' : 'Amount applied (tax included)') ?></label>
												<input type="text" class="form-control" name="tot_ht" id="tot_ht" value="<?php echo ($infgene->is_decimal > 0 ? number_format($curusr->tot_ht,2) : number_format($curusr->tot_ht)); ?> " <?php echo ($curusr->is_tot_manu > 0 ? "" : "disabled='disabled'" )?> readonly>
											</div>

											<div class="col-md-2">
												<a href="#" style="height: ;margin-top: 26px;" class="btn btn-default bttotmanu"><?php echo ($curusr->is_tot_manu > 0 ? '<i class="fa fa-pencil fa-3x"></i>' : '<i class="fa fa-gear fa-3x"></i>')?></a>
												
											</div>
											<div class="col-md-6">
											</div>
											<div class="<?php echo ($curusr->is_tot_manu > 0 ? '' : 'display-none')?>">
												<a href="#" style=";margin-top: 26px;" class="btn btn-primary btoktotmanu"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm')?></a>
												<!-- <a href="#" style=";margin-top: 26px;" class="btn btn-sm btn-warning clresetdir" type="reset"><i class="fa fa-repeat"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel') ?></a> -->
											</div>
											<div class="<?php echo ($curusr->is_tot_manu > 0 ? 'display-none' : '')?>">
												<a href="#" style=";margin-top: 26px;" class="btn btn-primary btoktotauto"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider.' : 'Confirm')?></a>
												<!-- <a href="#" style=";margin-top: 26px;" class="btn btn-sm btn-warning clresetdir" type="reset"><i class="fa fa-repeat"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel') ?></a> -->
											</div>
											
															<?php/* inf montant facture */?>
															
											<!-- date time sejour client -->
											
											
											<!-- <div class="<?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>"> -->
											
											<!-- il y avait le block informations paiements -->

											<div class="<?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												
												<?php /*
												<div class="form-group">
													<div class="col-md-3" >
														<label for="numdevis" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Numéro de devis' : 'Quote number') ?> </label>
														<input type="text" class="form-control" name="numdevis" id="numdevis" value="<?php echo $curusr->numdevis; ?>" readonly>
													</div>

													<div class="col-md-3">
														<label for="date_devis" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de devis' : 'Quote date') ?> </label>
														<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_devis" id="date_devis" value="<?php echo $curusr->date_devis > 0 ? date('d/m/Y', strtotime($curusr->date_devis)) : ''; ?>" readonly>
													</div>
													<div class="col-md-3">
														<label for="seldevises" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Devise en cours pour ce client' : 'Current currency for this customer') ?></label>
														<select id="seldevises" name="seldevises" class="form-control" style="background-color: black;color: yellow;">
															<?php foreach($devises as $devise){
																echo '<option value="'.$devise['code_devise'].'" '.($devise['code_devise'] == $curusr->code_devise ? 'style="background-color: #f70606;" selected' : ($curusr->code_devise == '' && $devise['code_devise'] == 'EUR' ? 'style="background-color: #f70606;" selected' : '')).'>'.$devise['name_devise'].' - '.$devise['code_devise'].'</option>';
															} ?>
														</select>
														
													</div>
													<div class="col-md-3">
														<button class="btn btn-sm btn-primary" type="button" id="btvalidedevise" style="margin-top: 37px;" <?php echo ($arrAccess['modif_devise_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-user"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Appliquez la devise choisie' : 'Apply currency') ?></button>
													</div>
													
												</div>
												*/?>
												<!-- <div class="form-group">
													<div class="col-md-3" >
														<label for="numfac" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Numéro de facture' : 'Invoice number') ?> </label>
														<input type="text" class="form-control" name="numfac" id="numfac" value="<?php echo $curusr->numfac; ?>" readonly>
													</div>

													
													<div class="col-md-3">
														<label for="date_fac" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de facturation' : 'Billing date') ?> </label>
														<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_fac" id="date_fac" value="<?php echo $curusr->date_fac > 0 ? date('d/m/Y', strtotime($curusr->date_fac)) : ''; ?>" readonly>
													</div> -->
													
													<!-- <div class="col-md-3" >
														<label for="date_fac_send" class="control-label">Date de reglement</label>
														<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_fac_send" id="date_fac_send" value="<?php echo $curusr->date_fac_send > 0 ? date('d/m/Y', strtotime($curusr->date_fac_send)) : ''; ?>">
													</div> 
												</div>-->
											</div>
											
											<!-- il y avait le block informations de facturation -->
												
											<fieldset style="margin-top:10px;margin-bottom:10px;display:flex;justify-content:center" <?php echo ($arrAccess['modif_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>>
												<input type="hidden" name="action" id="action" value="global-update" />
												<input type="hidden" name="id_fiche" id="id_fiche" value="<?php echo $_GET['id_fiche']; ?>" />
												<input type="hidden" name="istotmanu" id="istotmanu" value="<?php echo $curusr->is_tot_manu; ?>" />
												<input type="hidden" name="puburl" id="puburl" value="<?php echo $template['public_url']; ?>" />
												<input type="hidden" name="codedevisect" id="codedevisect" value="<?php echo ($curusr->code_devise == '' ? 'EUR' : $curusr->code_devise); ?>" />
												<div class="form-actions">
													<!-- <button class="btn btn-sm btn-primary" type="submit" id="btupdatedir"><i class="fa fa-user"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button> -->
													<!-- <button class="btn btn-sm btn-warning clresetdir" type="reset"><i class="fa fa-repeat"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel') ?></button> -->
												</div>
											</fieldset>
										</fieldset>

										
									</form>
									
								</div>
							</div>
						</div>

						<div class="item" id="itemtab2">
    						<div class="panel panel-default">
								<div class="col-md-12">
									<div class="block-title">
										<legend>
											<i class="fa fa-bed text-primary"></i>
											<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Résa. chambres' : 'Resa. romms') ?>
										</legend>
									</div>
									<div class="">
										<div class="form-group <?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
																
											<div class="col-md-3">	
												<a href="#"  style="color:#FFF; font-weight: bold;margin-top: 30px;border-radius: 30px;<?php echo $arrAccess['visu_planning_ch'] != '1' ? 'style="display:none"' : '' ?>" class="form-control btn btn-sm btn-primary btdispochdetails" id="idbtdispochdetails"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails des disponibilités' : 'Details of availability') ?></a> 
												<!-- <a href="#"  style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-warning btdispoch" id="idbtdispoch"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Recherche des disponibilités' : 'Search of availability') ?></a>  -->
											</div>
											
											<div id="" class="col-md-6">
												<table id="listeCh" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
													<thead>
														<tr>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° chambre' : 'Room number') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etage' : 'Floor') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Capacité' : 'Capacity') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<img src="img/lit-double.png"/>' : '<img src="img/lit-double.png"/>') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<img src="img/lit-simple.png"/>' : '<img src="img/lit-simple.png"/>') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<img src="img/lit-bb.png"/>' : '<img src="img/lit-bb.png"/>') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<img src="img/lit-sup.png"/>' : '<img src="img/lit-sup.png"/>') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Type' : 'Type') ?> 
															</th>
															<th>
																<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vue' : 'View') ?> 
															</th>
															<th> 
																Actions 
															</th>
														</tr>
													</thead>
													<tbody id="chReload">
													<?php foreach($outch as $ch){
														echo '<tr>
																<td>
																	<span class="columnClass">'.$ch['num_chambre'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['etage'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['capacite'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['nb_lit_double'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['nb_lit_simple'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['nb_lit_bb'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['nb_lit_sup'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['name_type_chambre'].'</span>
																</td> 
																<td>
																	<span class="columnClass">'.$ch['name_loc_chambre'].'</span>
																</td> 
																<td>
																	<a href="#" data-toggle="tooltip" data-num-ch="' . $ch['num_chambre'] . '" data-id-ch="' . $ch['id_chambre'] . '" data-id="' . $ch['id_contact_chambre'] . '" title="Supprimer" class="btn btn-xs btn-danger btdelch"><i class="fa fa-trash" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
																</td>
															</tr>';
													} ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<?php /* ancienne tab pour affichage des totaux dans onglet independant 

						<div class="item">
    						<div class="panel panel-default">
								<div class="col-md-12">
									<div class="block-title">
										<legend>
											<i class="fa fa-file-text text-primary"></i>
											<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations de Facturation' : 'Billing informations') ?>
										</legend>
									</div>
									<div class="form-group">
										
										<!-- <div class="col-md-3 display-none" >
											<label for="accompte_25" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Acompte de 25%' : '25% deposit') ?></label>
											<input type="text" class="form-control" name="accompte_25" id="accompte_25" value="<?php echo $curusr->accompte_25; ?>">
										</div>				
										<div class="col-md-3 display-none" >
											<label for="date_acompte" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date acompte' : 'Deposit date') ?></label>
											<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy"  name="date_acompte" id="date_acompte" value="<?php echo strtotime($curusr->date_acompte) > 0 ? date('d/m/Y', strtotime($curusr->date_acompte)) : ''; ?>">
										</div>				 -->
															
										<div class="col-md-3">
											<label for="mt_fin" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant réel' : 'Real amount') ?></label>
											<input type="text" class="form-control" id="mt_fin" value="<?php echo ($infgene->is_decimal > 0 ? number_format(($curusr->tot_real / ((100 - $curusr->offre_sejour) / 100)) - $curusr->taxe_sejour,2) : number_format(($curusr->tot_real / ((100 - $curusr->offre_sejour) / 100)) - $curusr->taxe_sejour)); ?> €" readonly>
										</div>
										
										<!-- <div class="col-md-3">
											<label for="offre_sejour" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Remise %' : 'Discount %') ?></label>
											<input type="text" class="form-control" name="offre_sejour" id="offre_sejour" value="<?php echo $curusr->offre_sejour; ?>">
										</div> -->
										
										<div class="col-md-3">
											<label for="taxe_sejour" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Taxe séjour' : 'City tax') ?></label>
											<input type="text" class="form-control" name="taxe_sejour" id="taxe_sejour" value="<?php echo ($infgene->is_decimal > 0 ? number_format($curusr->taxe_sejour,2) : number_format($curusr->taxe_sejour)); ?>">
										</div>

										<div class="col-md-2">
											
										</div>
										
										
										<div class="col-md-2">
											<label for="tot_ht" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant appliqué' : 'Amount applied') ?></label>
											<input type="text" class="form-control" name="tot_ht" id="tot_ht" value="<?php echo ($infgene->is_decimal > 0 ? number_format($curusr->tot_ht,2) : number_format($curusr->tot_ht)); ?> " <?php echo ($curusr->is_tot_manu > 0 ? "" : "disabled='disabled'" )?> >
										</div>

										<div class="col-md-2">
											<a href="#" style="height: ;margin-top: 26px;" class="btn btn-default bttotmanu"><?php echo ($curusr->is_tot_manu > 0 ? '<i class="fa fa-pencil fa-3x"></i>' : '<i class="fa fa-gear fa-3x"></i>')?></a>
											
										</div>
										<div class="col-md-6">
										</div>
										<div class="<?php echo ($curusr->is_tot_manu > 0 ? '' : 'display-none')?>">
											<a href="#" style=";margin-top: 26px;" class="btn btn-primary btoktotmanu"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm')?></a>
										</div>
										<div class="<?php echo ($curusr->is_tot_manu > 0 ? 'display-none' : '')?>">
											<a href="#" style=";margin-top: 26px;" class="btn btn-primary btoktotauto"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider.' : 'Confirm')?></a>
										</div>
										<!-- <div class="col-md-3 display:none">
											<label for="mt_ok_ht" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant restant' : 'Reamaning amount') ?></label>
											<input type="text" class="form-control" name="mt_ok_ht" id="mt_ok_ht" value="<?php echo $curusr->mt_ok_ht; ?> " readonly>
										</div> -->
										
									</div>
								</div>
							</div>
						</div>
						ancienne tab pour affichage des totaux dans onglet independant */ ?>

						<div class="item">
    						<div class="panel panel-default">
								<div class="col-md-12">
									<div class="block-title">
										<legend>
											<i class="gi gi-money text-primary"></i>
											<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations Paiement' : 'Payment informations') ?>
										</legend>
									</div>
									<div class="">
										<div class="form-group">
											
										</div>

										<a href="#" class="btn btn-sm btn-default" id="btinfclipaie" style=""><i class="fa fa-angle-down"></i></a>
										<!-- <div id="infclipaie" style="<?php echo ($curusr->lnk_contrat_signed > 0 || 1==1 ? 'display:none' : '') ?>"> -->
										<!-- <div id="infclipaie" style="display:none"> -->
										<div id="infclipaie" style="">
											<div class="col-md-3">	
												<a href="#"  style="color:#FFF; font-weight: bold;margin-top: 30px;border-radius: 30px;margin-bottom:15px" class="form-control btn btn-sm btn-primary btsendrglt" id="idbtsendrglt"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi lien paiement' : 'Send link paiment') ?></a> 
												<!-- <a href="#"  style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-warning btdispoch" id="idbtdispoch"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Recherche des disponibilités' : 'Search of availability') ?></a>  -->
											</div>
											<div class="form-group">
												<!-- <div class="<?php echo ($arrAccess['modif_fiche_client'] != '1' ? 'display-none' : '' ) ?>">
													<div class="col-md-3">	
														<a href="index-stripe.php?idct=<?php echo $curusr->id_fiche ?>&key=<?php echo $curusr->codekey.$curusr->id_fiche ?>"  target="_blank" style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-info btpay" id="idbtpay">Paiement en ligne direct</a> 
													</div>
													<div class="col-md-3">	
														<a href="#"  target="_blank" style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-warning btpaylnk" id="idbtpaylnk">envoi lien paiement en ligne</a> 
													</div>
												</div> -->
												<div id="lstrib" class="col-md-9">
												</div>
											</div>
											<div class="form-group">
												<div class="table-responsive col-sm-12">
													<?php echo $outvirement ?>
												</div>
											</div>
											<div class="form-group col-md-12 ">														
												<label for="tot_global" class="control-label col-md-2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tot. séjour' : 'Tot. stay') ?> </label>
												<div class="col-md-2">
													<input type="text" class="form-control" name="" id="tot_global" value="<?php echo ($infgene->is_decimal > 0 ? number_format($curusr->tot_ht ,2) : number_format($curusr->tot_ht)); ?> €" readonly>
												</div>
											
												<label for="tot_rglt" class="control-label col-md-2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tot. règlt(s) validé(s)' : 'Tot. pymt(s) validated') ?> </label>
												<div class="col-md-2">
													<input type="text" class="form-control" name="tot_rglt" id="tot_rglt" value="" readonly>
												</div>
												<label for="tot_restant" class="control-label col-md-2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Total restant' : 'Total remaining') ?> </label>
												<div class="col-md-2">
													<input type="text" class="form-control" name="" id="tot_restant" value="" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="item">
    						<div class="panel panel-default">
								<div class="col-md-6">
									<div class="block-title">
										<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commentaires' : 'Comments') ?></strong></h2>
									</div>
									<div class="table-responsive">
										<table id="tbclimsg" class="table table-striped table-bordered table-vcenter table-condensed table-hover">
											<?php if ($comments && $comments->num_rows > 0) { ?>
												<tr>
													<th class="text-center">Date</th>
													<th class="text-center">Message</th>
													<th class="text-center">&nbsp;</th>
												</tr>
												<?php
												foreach ($comments as $comment) {
													?>
													<tr>
														<td class="text-center">
															<i class="fa fa-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($comment['date_comment'])); ?>
															<?php if ($comment['user_name'] != '') { ?>
																<br><i class="fa fa-user"></i> <em> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'par' : 'from') ?> <?php echo $comment['user_name']; ?></em>
															<?php } ?>
														</td>
														<td class="text-center" style="<?php echo $comment['type_comment'] == '1' ? 'box-shadow: -5px -5px 10px; background-color:#e8a71a;color:#45618f' : 'box-shadow: -5px -5px 10px; background-color:#8ad1ed;color:#000'?>"><?php echo $comment['type_comment'] == '1' ? '<i class="gi gi-alarm"></i>' . $comment['text_comment'] : $comment['text_comment']; ?></td>
														<td class="text-center">														
															<div class="btn-group">
																<a href="#" data-toggle="tooltip" data-type="<?php echo $comment['type_comment']?>" title="<?php echo $comment['type_comment'] == '0' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le commentaire' : 'Delete Comment') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le rappel' : 'Delete the reminde'); ?>" class="btn btn-xs btn-danger btdelcomment" data-id="<?php echo $comment['id_comment']; ?>" <?php echo ($arrAccess['add_comment_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-trash"></i></a>
															</div>														
														</td>
													</tr>
												<?php
											}
											?>
											<?php } ?>
										</table>
									</div>
									<form onsubmit="return false;" class="form-horizontal" method="post" action="appajax.php" id="formulaireaddcomment">
										<div class="row" style="margin-top:20px">
											<div class="col-md-12 col-lg-12">
												<div class="form-group">
													<div class="col-md-12">
														<textarea placeholder="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nouveau ....' : 'New ....') ?>" class="form-control" name="comment" id="comment" style="height:200px;"></textarea>
													</div>
												</div>
												<div class="col-md-12 form-group form-actions">
													<input type="hidden" name="id_fiche" id="id_fiche" value="<?php echo $_GET['id_fiche']; ?>" />
													<input type="hidden" name="action" id="action" value="add-comment" />											
													<button class="btn btn-sm btn-primary pull-right" type="submit" id="btaddcomment" <?php echo ($arrAccess['add_comment_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-plus"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter un commentaire' : 'Add a comment') ?></button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-6">
									<div class="block-title">
										<h2><strong><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappels' : 'Reminders') ?></strong></h2>
									</div>
									<div class="table-responsive">
										<table id="tbclimsg-rap" class="table table-striped table-bordered table-vcenter table-condensed table-hover">
											<?php if ($reminders && $reminders->num_rows > 0) { ?>
												<tr>
													<th class="text-center">Date</th>
													<th class="text-center">Message</th>
													<th class="text-center">&nbsp;</th>
												</tr>
												<?php
												foreach ($reminders as $reminde) {
													?>
													<tr>
														<td class="text-center">
															<i class="fa fa-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($reminde['date_comment'])); ?>
															<?php if ($reminde['user_name'] != '') { ?>
																<br><i class="fa fa-user"></i> <em> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'par' : 'from') ?> <?php echo $reminde['user_name']; ?></em>
															<?php } ?>
														</td>
														<td class="text-center" style="<?php echo $reminde['type_comment'] == '1' ? 'box-shadow: -5px -5px 10px; background-color:#e8a71a;color:#45618f' : 'box-shadow: -5px -5px 10px; background-color:#8ad1ed;color:#000'?>"><?php echo $reminde['type_comment'] == '1' ? '<i class="gi gi-alarm"></i>' . $reminde['text_comment'] : $reminde['text_comment']; ?></td>
														<td class="text-center">														
															<div class="btn-group">
																<a href="#" data-toggle="tooltip" data-type="<?php echo $reminde['type_comment']?>" title="<?php echo $reminde['type_comment'] == '0' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le commentaire' : 'Delete Comment') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le rappel' : 'Delete the reminde'); ?>" class="btn btn-xs btn-danger btdelcomment" data-id="<?php echo $reminde['id_comment']; ?>" <?php echo ($arrAccess['add_comment_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-trash"></i></a>
															</div>														
														</td>
													</tr>
												<?php
											}
											?>
											<?php } ?>
										</table>
									</div>
									<a href="#" class="btn btn-sm btn-success pull-right" id="btaddrecall" <?php echo ($arrAccess['add_rappel_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-plus"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter un rappel' : 'Add a reminder') ?> </a>&nbsp;												
									
								</div>
							</div>
						</div>

						<!-- <div id="tabs-doc" class="tab-pane"> -->
						<div class="item">
    						<div class="panel panel-default">
								<div class="form-group">
									<div class="pull-right">
										<a href="#" class="btn btn-sm btn-success btadddocsec" <?php echo ($arrAccess['add_doc_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-plus-circle"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter un fichier' : 'Add a file') ?></a>
									</div>
								</div>
								<div class="block">
									<div class="block-title">
										<h2><strong>Documents</strong></h2>
									</div>
									
									<div class="form-group">
										<div id="contentdocs" style="margin-top:20px;">
											<div class="gallery" data-toggle="lightbox-gallery">
												
												<div class="row">
													<?php
														echo $outdocs;
													?>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

		</div>
	</div>
	
	
	<div id="modal-rappel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="gi gi-calendar"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel client' : 'Customer callback') ?></h2>
				</div>
				
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairerecall" method="post" action="appajax.php">
						<!-- Normal Form Content -->
						<div class="form-group">
							<label for="date_rappel" class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date du rappel' : 'Recall date') ?></label>
							<div class="col-md-6">
								<input type="text" id="date_rappel" name="date_rappel" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="heure_rappel" class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Heure du rappel' : 'Reminder time') ?></label>
							<div class="col-md-6">
								<div class="input-group bootstrap-timepicker">
									<input type="text" name="heure_rappel" id="heure_rappel" value="" class="form-control input-timepicker24" required>
									<span class="input-group-btn">
										<a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
									</span>
								</div>

							</div>
						</div>
						<div class="form-group">
							<label for="msg_recall" class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Motif du rappel' : 'Reason of recall') ?></label>
							<div class="col-md-6">
								<textarea name="msg_recall" id="msg_recall" class="form-control" rows="4" cols="50" required></textarea>
							</div>
						</div>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">
								<input type="hidden" name="id_fiche" id="id_contactrecal" value="<?php echo $_GET['id_fiche']; ?>" />
								<input type="hidden" name="action" id="actionrecal" value="add-rappel" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btrecall" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>
	
	
	<div id="modal-dispo-chambre" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="width:95%;">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client prévu du ' : 'Intended customer of ') ?> <span id="dtd"></span></h2>
					<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
				</div>
				<div class="modal-body">
					<div class='form-group' style="display: flex;justify-content:center">
						<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Filtre chambre sur : ' : 'Filter room on : ') ?> &nbsp;</label><label class="switch switch-primary">
							<input type="checkbox" id="chkemp" name="chkemp" value="P"><span></span>
						</label>  &nbsp;<label><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Employés ET ' : 'Staff AND ') ?> &nbsp;</label>
						&nbsp;<label class="switch switch-primary">
							<input type="checkbox" id="chktmp" name="chktmp" value="T"><span></span>
						</label>  &nbsp;<label><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Temporaire ' : 'Temporary ') ?> &nbsp;</label>
						&nbsp;
						
						<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' ET Types' : ' AND Types') ?> &nbsp;</label><?php echo Tool::DropDown('id_sel_filtre',Chambres::getAllType(),'id_type_chambre','name_type_chambre','id_type_chambre','', true) ?> <label>&nbsp; <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ET Capacité' : 'And Capacity') ?> 	 </label>
						<select class="form-control" id="sel_op_cap" style="width: 50px;margin-left: 15px;">
							<option value=""></option>
							<option value="=">=</option>
							<option value=">=">>=</option>
							<option value="<="><=</option>
						</select>
						<input type="text" class="form-control" value="" id="val_cap" name="val_cap" style="width: 50px;"/>
						<!-- <label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Filtre sur Types' : 'Filter on types') ?> &nbsp;</label> <?php echo Tool::DropDown('id_sel_filtre',Chambres::getAllType(),'id_type_chambre','name_type_chambre','id_type_chambre','', true) ?> <label>&nbsp; <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ET Piscine' : 'And pool') ?> 	 </label>
						<select class="form-control" id="sel_piscine_filtre" style="width: 111px;margin-left: 15px;">
							<option value="0"></option>
							<option value="1"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Privée' : 'Private') ?></option>
							<option value="2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Partagée' : 'Share') ?></option>
						</select> -->
						<button href="#" class="btn btn-sm btn-default" id="btvalidefiltre" style="margin-left: 15px;height: 35px;"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Filtrer' : 'Filter') ?></button>
						<button href="#" class="btn btn-sm btn-default" id="btsearchinf" style="margin-left: 15px;height: 35px;"><i class="fa fa-search"></i></button>
					</div>	
					<div class='form-group' style="display: flex;justify-content:center">
						<div id="clclts" style="display:none; margin-left:20px">
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client ' : 'Customer') ?> &nbsp;</label> 
							<select class="form-control" id="sel_clts" style="width: 150px;margin-left: 15px;">
								<option value="0"></option>
							<?php $clts = Fiche::getAll();
							foreach($clts as $clt){
								$sel = ($clt['id_fiche'] == $_GET['id_fiche'] ? "selected='selected'" : "");
								echo '<option value="'.$clt['id_fiche'].'" '.$sel.'>'.$clt['last_name'].' '.$clt['first_name'].'</option>';
							}?>
							</select>
							<!-- <button href="#" class="btn btn-sm btn-default" id="btclfiche" style="margin-left: 15px;height: 35px;"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button> -->
						
						</div>
						<div id="clinf" style="display:none; margin-left:20px">
						
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client ' : 'Customer') ?> &nbsp;</label> 
							<select class="form-control" id="sel_clts_inf" style="width: 150px;margin-left: 15px;">
								<option value="0"></option>
							<?php $clts = Fiche::getAll();
							foreach($clts as $clt){
								$sel = ($clt['id_fiche'] == $_GET['id_fiche'] ? "selected='selected'" : "selected");
								echo '<option value="'.$clt['id_fiche'].'" '.$sel.'>'.$clt['last_name'].' '.$clt['first_name'].'</option>';
							}?>
							</select>
							<!-- <input type="text" id="clt_inf" name="clt_inf" class="form-control" value="" style="margin-left: 10px;width:425px; color:red" readonly> -->
							<span id="clt_inf" name="clt_inf" class="form-control" style="margin-left: 10px;width:450px;"></span>
							<button href="#" class="btn btn-sm btn-default" id="btclinf" style="margin-left: 15px;height: 35px;"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
						<div id="cltmp" style="display:none; margin-left:20px">
							<label class="clntp"> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom ' : 'Name ') ?> &nbsp;</label> 
							<input type="text" id="name_tmp_emp" name="name_tmp_emp" class="form-control clntp" value="" required>
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date ' : 'Date ') ?> &nbsp;</label> 
							<input type="text" id="date_deb_sej" name="date_deb_sej" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($sej->date_start_organisateur))?>" required>
							<label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Au ' : 'To ') ?> &nbsp;</label> 
							<input type="text" id="date_end_sej" name="date_end_sej" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($sej->date_end_organisateur))?>" required>
							<button href="#" class="btn btn-sm btn-default" id="btclemp" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							<button href="#" class="btn btn-sm btn-default" id="btcltmp" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							<button href="#" class="btn btn-sm btn-default" id="btcldel" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							<button href="#" class="btn btn-sm btn-default" id="btclfiche" style="margin-left: 15px;height: 35px;display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						
						</div>
					</div>
					<div class="form-group">
						<div id="chdispoentete" style=""></div>
						<div id="chdispo" style="overflow: auto;height: 600px"></div>
					</div>
					
					<div class="form-group form-actions" style="margin-bottom: 65px;margin-top: 25px;">
						<div class="col-md-12 text-center" style="margin-bottom:35px">
							<input type="hidden" name="resch[]" id="resch" value="" />
							<button href="#" class="btn btn-sm btn-default clclosemod" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<?php if((int)$curusr->lnk_reglement > 0){ ?>
								<!-- <button class="btn btn-sm btn-primary" id="btokch" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button> -->
							<?php } ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	<div id="modal-transport" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="width:42%;">
			<div class="modal-content" style="height: 200px;">
			
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> Transports <span id="dtd"></span></h2>
				</div>
				<div class="modal-body">
					
					<div id="transp">
						<div class="form-group">
							<div class="col-md-4">
								<label class="switch switch-primary">
									<input type="checkbox" id="volnavette" name="volnavette" ><span></span>
								</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vol + Navette' : 'Flight & shuttle') ?>
							</div>
							<div class="col-md-4">
								<label class="switch switch-primary">
									<input type="checkbox" id="volseul" name="volseul" ><span></span>
								</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vol seul' : 'Flight only') ?>
							</div>
							<div class="col-md-4">
								<label class="switch switch-primary">
									<input type="checkbox" id="navetteseule" name="navetteseule" ><span></span>
								</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Navette seule' : 'Shuttle only') ?>
							</div>
						</div>
					</div>

					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:35px">
							<input type="hidden" name="restransp" id="restransp" value="" />
							<input type="hidden" name="iddet" id="iddet" value="" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<button class="btn btn-sm btn-primary" id="btoktransport" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<div id="modal-msg-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail' : 'Send email') ?></h2>
				</div>
				
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsgdoc" method="post" action="appajax.php">
							
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire(s)' : 'Recipient(s)') ?></label>
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="destemail" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmail" placeholder="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?>" />
									<div class="input-group-btn" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du modèle' : 'Choice of model') ?>">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcont"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
										<?php foreach ($mtypes as $mtype) { ?>
												<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" data-type="<?php echo $mtype['type_mail']; ?>" class="modeltype cl-<?php echo $mtype['type_mail']; ?>"><?php echo $mtype['name_mailtype']; ?></a></li>
											<?php } ?>
										</ul>
											
									</div>
								</div>
							</div>
						</div>
						
						<textarea id="msgcontent" name="msgcontent" class="ckeditor">
							
						</textarea>
						<div id="attacheddocs" class="block">
						</div>
						<div id="blksenddocint">
							<div id="lstdocsctt" class="col-md-12"></div>
						</div>

						<div id="txtmailpres" class="display-none">							
						</div>
						<input type="file" name="fileadd[]" id="fileadd"  style="display:none;" multiple>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter pièces jointes' : 'Add attachments') ?>" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddoc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocin"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
								</div>                    
								<button href="#" class="btn btn-sm btn-danger pull-right" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Retirer pièces jointes' : 'remove attachments') ?>" data-toggle="tooltip" id="btdeldoc"><i class="fa fa-minus"></i></button>
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
			</div>
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
	
	<div id="modal-tarif-manu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-money"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nouveau tarif' : 'New price') ?></h2>
				</div>
				<div class="modal-body" style="height: 15vh">
					<div class="form-group">
						<div class="col-md-4">
							
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control"  value="" id="tarif_manu_grid" name="tarif_manu_grid" />
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:15px;margin-top:15px">
							<input type="hidden" name="idfichetarifmanu" id="idfichetarifmanu" value="0" />
							<input type="hidden" name="iddetailtarifmanu" id="iddetailtarifmanu" value="0" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<button class="btn btn-sm btn-primary" id="btoktarifmanu" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="modal-amount-rglt" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-money"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount') ?></h2>
				</div>
				<div class="modal-body" style="height: 15vh">
					<div class="form-group">
						<div class="col-md-4">
							
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control"  value="" id="amount_rglt" name="amount_rglt" />
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:15px;margin-top:15px">
							<input type="hidden" name="idficheamount" id="idficheamount" value="0" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<button class="btn btn-sm btn-primary" id="btokamount" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="modal-option-manu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-money"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nouveau tarif' : 'New price') ?></h2>
				</div>
				<div class="modal-body" style="height: 15vh">
					<div class="form-group">
						<div class="col-md-4">
							
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control"  value="" id="tarif_opt_manu_grid" name="tarif_opt_manu_grid" />
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:15px;margin-top:15px">
							<input type="hidden" name="idfichetarifmanuopt" id="idfichetarifmanuopt" value="0" />
							<input type="hidden" name="iddetailtarifmanuopt" id="iddetailtarifmanuopt" value="0" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<button class="btn btn-sm btn-primary" id="btoktarifmanuopt" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="modal-confirm-sellsign" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Signature electronique en cours' : 'Signature electronic in progress') ?></h4>
				</div>
				<div class="modal-body text-center">						
					<h3><i class="fa fa-check fa-3x text-success animation-fadeIn"></i><br><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitement effectué' : 'Treatment carried out') ?></h3>					
					<p>
					<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi du lien vers le document à signer ' : 'Send the link to the document to be signed ') ?><br> <span id="idcontractsellsign" class="label label-success" style="font-size:14px" target="new"></span>
					</p>
				</div>

			</div>
		</div>
	</div>

	<div id="modal-sms" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi SMS' : 'Send SMS') ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairesms" method="post" action="appajax.php">
						
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoyer à' : 'Send to') ?></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" class="form-control"  value="<?php echo $curusr ? $curusr->tel1 : ''; ?>" id="docnum" />
									<div class="input-group-btn" data-toggle="tooltip" title="Charger un SMS type">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcontsms"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<?php foreach ($stypes as $stype) { ?>
												<li><a href="javascript:void(0)" data-id="<?php echo $stype['id_smstype']; ?>" class="lnksmstype"><?php echo $stype['name_smstype']; ?></a></li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Message</label>
							<div class="col-md-8">
								<textarea id="msgsms" name="msgsms" class="form-control" style="height:250px"></textarea>
							</div>
						</div>

						<div class="form-group form-actions">
							<div class="col-md-12 text-center">
								<input type="hidden" name="id_smstype" id="id_smstype" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btsendsms" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-updocument" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter un fichier' : 'Add a file') ?></h2>
				</div>
				<!-- Modal Body -->
				<div class="modal-body">					
					<form action="appajax.php" method="post" class="form-horizontal" id="formulairedoc"  onsubmit="return false;">
						<fieldset>
							<div class="form-group">
								<div id="filedocs" class="dropzone"></div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="id_type_doc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Type de document' : 'Document type') ?></label>
								<div class="col-md-8">
									<select name="id_type_doc" id="id_type_doc" class="form-control select-chosen">
										<option value=""><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du type' : 'Choice of type') ?></option>
										<?php
											$tdocs = Doc::getTypeDocs();
											foreach($tdocs as $tdoc) {
												echo '<option value="'.$tdoc['id_type_doc'].'">'.$tdoc['name_doc'].'</option>';		
											}
										?>
									</select>
								</div>
							</div>
						</fieldset>
						<div class="form-group form-actions">
							<div class="col-xs-12 text-right">
								<input type="hidden" name="action" id="action" value="upload-doc-type" />
								<button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button type="submit" class="btn btn-sm btn-primary" id="btuploaddoc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-msg-mail-i" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail' : 'Send email') ?></h2>
				</div>
				
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsginsc" method="post" action="appajax.php">
						
						<div class="form-group">
							<div id="" class="form-group">
								<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire(s)' : 'Recipient(s)') ?></label>
								<div class="col-md-8">
									<input type="text" class="form-control"  value="" id="destemailinsc" readonly/>
								</div>
							</div>
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmailinsc" placeholder="sujet" />
									<div class="input-group-btn" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du modèle' : 'Choice of model') ?>">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcontinsc"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
										<?php foreach ($mtypes as $mtype) {
												if($mtype['type_mail'] == '5' || $mtype['type_mail'] == '6'){?>
													<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" class="modeltypeinsc"><?php echo $mtype['name_mailtype']; ?></a></li>
												<?php } 
											} ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
						<textarea id="msgcontentinsc" name="msgcontentinsc" class="ckeditor">
							
						</textarea>
						<div id="attacheddocsinsc" class="block">
						</div>
						<div id="blksenddocintinsc">
							<div id="lstdocscttinsc" class="col-md-12"></div>
						</div>

						<div id="txtmailpresinsc" class="display-none">							
						</div>
						<input type="file" name="fileaddinsc[]" id="fileaddinsc"  style="display:none;" multiple>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter pièces jointes' : 'Add attachments') ?>" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown" style="margin-right:10px"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddocinsc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocininsc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
								</div>                    
								<button href="#" class="btn btn-sm btn-danger pull-right" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Retirer pièces jointes' : 'remove attachments') ?>" data-toggle="tooltip" id="btdeldocinsc"><i class="fa fa-minus"></i></button>
								<input type="hidden" name="id_mailtypeinsc" id="id_mailtypeinsc" value="0" />
								<input type="hidden" name="lginsc" id="lginsc" value="FR" />
								<input type="hidden" name="attachclrinsc" id="attachclrinsc" value="0" />
								<input type="hidden" name="typeMailinsc" id="typeMailinsc" value="0" />
								<input type="hidden" name="ficheidinsc" id="ficheidinsc" value="0" />
								<input type="hidden" name="idMailTypeinsc" id="idMailTypeinsc" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btmailsendinginsc" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				
			</div>
		</div>
	</div>

	<div id="modal-inf-facture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-money"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails facture' : 'Invoice details') ?></h2>
				</div>
				<div class="modal-body" style="height: 50vh">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group" >
							<label for="lg" class="col-md-2 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Langage' : 'Language') ?></label>
							<div class="col-md-4">
								<select class="form-control" name="lgfact" id="lgfact">
									<option value="FR" <?php echo $curusr && $curusr->lg == 'FR' ? 'selected="selected"' : ''; ?>>FR</option>
									<option value="ENG" <?php echo $curusr && $curusr->lg == 'ENG' ? 'selected="selected"' : ''; ?>>ENG</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="date_start" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date Facture' : 'Invoice date') ?></label>
								<input type="text" style="background-color:#c1eaf7" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_fac" id="date_fac" value="<?php echo $curusr->date_fac > 0 ? date('d/m/Y', strtotime($curusr->date_fac)) : date('d/m/Y', strtotime(date('Y-m-d'))); ?>">
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Taux TVA' : 'Taxe %') ?></label>
							<div class="col-md-2">
								<input type="number" value="0" class="form-control" id="tvafact">
							</div>
						
							<label class="col-md-2 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Infos BQ' : 'BQ infos') ?></label>
							<div class="col-md-4">
								<div class="input-group">
									<select name="bqfact" id="bqfact" class="form-control">
											<option value='0'>Choisissez votre banque</option>
											<?php foreach ($bqs as $bq) {
												echo '<option value="'.$bq['id_inf_banque '].'">'.$bq['inf_iban'].' . '.$bq['inf_bic'].'</option>';
											} ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br><br><hr>
				<div class="row">
					<div class="col-md-12">
						<label class="col-md-2 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount') ?></label>
						<div class="col-md-2">
							<input type="text" class="form-control"  value="" id="mtfact" name="mtfact" />
						</div>
					
						<div class="col-md-8">
							<textarea class="form-control" name="descfact" id="descfact" cols='80' rows='3' ></textarea>
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:15px;margin-top:15px">
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
							<button class="btn btn-sm btn-primary" id="btokfacture" type="button"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
 
</div>
<!-- END Page Content -->
<!-- <a href="#" class="btimportth" data-action="add-th-l">test pdf</a> -->

<?php include 'including/footPage.php'; ?> 

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="jscript/helpers/excanvas.min.js"></script><![endif]-->

<script src="jscript/jsplug.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTPCq11w-n5ZN8o3fIzhuUXCwPTTP6OmE&libraries=places"></script> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>



<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->


<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>
<!-- <script src="<?php echo $template['url']; ?>/jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="<?php echo $template['url']; ?>/jscript/helpers/ckeditor/config.js"></script> -->

<!-- Load and execute javascript code used only in this page -->
<script>

	
	
	$(document).ready(function() {

		// if(window.matchMedia("(max-width: 600px)").matches){
		// 	// La fenêtre a moins de 600 pixels de large
		// 	$('#idmob').removeClass('pull-right');
		// } else{
		// 	// La fenêtre fait au moins 600 pixels de large
		// 	// alert("Ceci est une tablette ou un desktop.");
		// 	$('#idmob').removeClass('pull-right');
		// 	$('#idmob').addClass('pull-right');
    	// }maj-tot

		$(document).on('click', '#alertesBar',function(){
			<?php $_SESSION['idAppFiche'] = (int)$_GET['id_fiche'] ?>;
			window.location.href = 'https://crm-hotel.dev-customer.com/Dashboard/bar.php';
		})

		$(document).on('click', '#alertesExtra',function(){
			<?php $_SESSION['idAppFiche'] = (int)$_GET['id_fiche'] ?>;
			window.location.href = 'https://crm-hotel.dev-customer.com/Dashboard/extra.php';
		})

		$('.btoktotmanu').click(function(){
			console.log($('#tot_ht').val())
			HoldOn.open();
			$.post('appajax.php', {
					action: 'maj-tot-manu', 
					idct:$('#id_fiche').val(), 
					tarif:$('#tot_ht').val(), 
					tarifmanu:$('#tot_manu').val(), 
					is_tot_manu: 1,
					taxe_sejour:$('#taxe_sejour').val(),
					dts:$('#date_start').val(),
					dte:$('#date_end').val(),
					ts:$('#time_start').val(),
					te:$('#time_end').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#tot_ht').val(Math.round(parseFloat(resp.totht)))
					$('#mt_fin').val(Math.round(parseFloat(resp.totreal)))
					$('#tot_global').val(Math.round(parseFloat($('#tot_ht').val())))
					$('#tot_restant').val(Math.round(parseFloat(resp.tot_restant)))
					$('#tot_rglt').val(Math.round(parseFloat(resp.tot_rglt)))

					modifDateS = 0;
					modifDateE = 0;
					modifHeureS = 0;
					modifHeureE = 0;

					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});
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

		$('.btoktotauto').click(function(){
			HoldOn.open();
			$.post('appajax.php', {
					action: 'maj-tot-auto', 
					idct:$('#id_fiche').val(),
					tarifmanu:$('#tot_manu').val(),
					taxe_sejour:$('#taxe_sejour').val(),
					dts:$('#date_start').val(),
					dte:$('#date_end').val(),
					ts:$('#time_start').val(),
					te:$('#time_end').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#tot_ht').val(Math.round(parseFloat(resp.totht)))
					$('#mt_fin').val(Math.round(parseFloat(resp.totreal)))
					$('#tot_global').val(Math.round(parseFloat($('#tot_ht').val())))
					$('#tot_restant').val(Math.round(parseFloat(resp.tot_restant)))
					$('#tot_rglt').val(Math.round(parseFloat(resp.tot_rglt)))

					modifDateS = 0;
					modifDateE = 0;
					modifHeureS = 0;
					modifHeureE = 0;

					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});

					// setTimeout(function() {
					// 		window.location.reload();
					// 	}, 5000);
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

		$(document).on('click','.bttotmanu',function(){
			if($('#istotmanu').val() == '1'){
				console.log('1')
				$('#tot_ht').attr('disabled', true);
				$('.bttotmanu > i').removeClass('fa fa-pencil fa-3x')
				$('.bttotmanu > i').addClass('fa fa-gear fa-3x')
				$('#istotmanu').val('0')
				$('.btoktotmanu').parent().hide()
				$('.cltotmanu').hide()
				$('.btoktotauto').parent().show()
			}else{
				if($('#tot_ht').attr('disabled')){
					console.log('2')
					$('#tot_ht').attr('disabled', false);
					$('.bttotmanu > i').removeClass('fa fa-gear fa-3x')
					$('.bttotmanu > i').addClass('fa fa-pencil fa-3x')
					$('.btoktotmanu').parent().show()
					$('.cltotmanu').show()
					$('.btoktotauto').parent().hide()
				}else{
					$('#tot_ht').attr('disabled', true);
					$('.bttotmanu > i').removeClass('fa fa-pencil fa-3x')
					$('.bttotmanu > i').addClass('fa fa-gear fa-3x')
					console.log('3')
					$('.btoktotmanu').parent().hide()
					$('.cltotmanu').hide()
					$('.btoktotauto').parent().show()
				}
			}
			return false
		})

		$(document).on('keyup','#tot_ht',function(){
			$('#istotmanu').val('1');
		})

		// console.log(document.getElementById('email'))
		// $('#date_birth').datepicker().datepicker('setDate', new Date())
		$(document).on('click', '.bttarifmanu', function(){
			let idfichemanu = $(this).attr('data-id');
			let iddetailmanu = $(this).attr('data-id-detail');

			$('#iddetailtarifmanu').val(iddetailmanu)
			$('#idfichetarifmanu').val(idfichemanu)

			$('#modal-tarif-manu').modal('show')
			return false;
		})

		// $(document).on('click','#btmtcont',function(){
			
		// 	
		// 	
		// })

		$('#idbtsendrglt').click(function(){
			$('.modeltype').hide();
			$('.cl-7').show();
					
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

			$('#aff-stag').hide();
			$('#modal-msg-mail').modal();
			
			// $('#modal-amount-rglt').modal('show')
			return false
		})
		
		$('#btokamount').click(function(){
			$('#modal-amount-rglt').modal('hide')

			HoldOn.open();
			$.post('appajax.php', {
					action: 'maj-amount-rglt', 
					idct:$('#id_fiche').val(), 
					tarif:$('#amount_rglt').val(), 
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});
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

		$('#btoktarifmanu').click(function(){
			$('#modal-tarif-manu').modal('hide')

			HoldOn.open();
			$.post('appajax.php', {
					action: 'maj-tarif-manu-grid', 
					iddetail:$('#iddetailtarifmanu').val(), 
					idct:$('#idfichetarifmanu').val(), 
					tarif:$('#tarif_manu_grid').val(), 
					tarifmanu:$('#tot_manu').val(),
					remise:$('#offre_sejour').val(), 
					istotmanu:$('#istotmanu').val(), 
					tot_ht:$('#tot_ht').val(), 
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#list_details').trigger("reloadGrid",[{current:true}]);
					$('#tot_ht').val(Math.round(resp.mttot));
					$('#tot_global').val(Math.round(parseFloat($('#tot_ht').val())))
					$('#tot_restant').val((typeof resp.restant == 'number' ? Math.round(resp.restant) : 0 ))
					$('#mt_fin').val(Math.round(parseFloat(resp.totreal)));	
					// $('#mt_fin').val(Math.round((parseFloat($('#tot_ht').val())) / ((100 - $('#offre_sejour').val()) / 100)) - $('#taxe_sejour').val());	
					
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

		
		$(document).on('click', '.bttarifmanuoption', function(){
			let idfichemanu = $(this).attr('data-id');
			let iddetailmanu = $(this).attr('data-id-detail');

			$('#iddetailtarifmanuopt').val(iddetailmanu)
			$('#idfichetarifmanuopt').val(idfichemanu)

			$('#modal-option-manu').modal('show')
			return false;
		})

		$('#btoktarifmanuopt').click(function(){
			$('#modal-option-manu').modal('hide')

			HoldOn.open();
			$.post('appajax.php', {
					action: 'maj-opt-manu-grid', 
					iddetail:$('#iddetailtarifmanuopt').val(), 
					idct:$('#idfichetarifmanuopt').val(), 
					tarif:$('#tarif_opt_manu_grid').val(), 
					tarifmanu:$('#tot_manu').val(),
					remise:$('#offre_sejour').val(), 
					taxe:$('#taxe_sejour').val(), 
					istotmanu:$('#istotmanu').val(),
					tot_ht:$('#tot_ht').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#list_details_options').trigger("reloadGrid",[{current:true}]);
					$('#tot_ht').val(Math.round(resp.mttot));
					$('#tot_global').val(Math.round(parseFloat($('#tot_ht').val())))
					$('#tot_restant').val((typeof resp.restant == 'number' ? Math.round(resp.restant) : 0 ))
					$('#mt_fin').val(Math.round(resp.totreal));	
					// $('#mt_fin').val((Math.round(parseFloat($('#tot_ht').val())) / ((100 - $('#offre_sejour').val()) / 100)) - $('#taxe_sejour').val());	
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


		$('#date_deb_sej').datepicker( "setDate", "<?php echo date('d/m/Y', strtotime($sej->date_start_organisateur)) ?>" );
		$('#date_end_sej').datepicker( "setDate", "<?php echo date('d/m/Y', strtotime($sej->date_end_organisateur)) ?>" );

		// console.log($('#date_start').val())
		if($('#id_status_sec').val() == '1' && $('#date_start').val() == ''){
			$('#date_start').datepicker( "setDate", "<?php echo date('d/m/Y', strtotime($sej->date_start_organisateur)) ?>" );
			$('#time_start').val('10:00:00');
		}
		if($('#id_status_sec').val() == '1' && $('#date_end').val() == ''){
			$('#date_end').datepicker( "setDate", "<?php echo date('d/m/Y', strtotime($sej->date_end_organisateur)) ?>" );
			$('#time_end').val('16:00:00');
		}


		var modifDateS = 0;
		var modifDateE = 0;
		var modifHeureS = 0;
		var modifHeureE = 0;

		$('#date_start').change(function(){
			modifDateS = 1;
		})

		// $('#date_start').focusout(function(){
		// 	if(modifDate == 1){
		// 		alert("Attention vous avez modifié la date de départ\n\rValidation obligatoire");
		// 	}
		// })

		$('#date_start').blur(function(){
			if(modifDateS == 1){
				alert("Attention vous avez modifié la date d\'arrivée\n\rLa validation est obligatoire pour conserver la modification !");
			}
		})

		$('#date_end').change(function(){
			modifDateE = 1;
		})

		$('#date_end').blur(function(){
			if(modifDateE == 1){
				alert("Attention vous avez modifié la date de départ\n\rLa validation est obligatoire pour conserver la modification !");
			}
		})

		$('#time_start').change(function(){
			modifHeureS = 1;
		})

		$('#time_start').blur(function(){
			if(modifHeureS == 1){
				alert("Attention vous avez modifié l\'heure d\'arrivée\n\rLa validation est obligatoire pour conserver la modification !");
			}
		})

		$('#time_end').change(function(){
			modifHeure = 1;
		})
		
		$('#time_end').blur(function(){
			if(modifHeureE == 1){
				alert("Attention vous avez modifié l\'heure de départ\n\rLa validation est obligatoire pour conserver la modification !");
			}
		})

		$('#id_status_sec').change(function(){
			
			if($('#id_status_sec').val() != '1'){		
				$($('#civ_contact').attr('required',true))
				$($('#last_name').attr('required',true))
				$($('#email').attr('required',true))
				$($('#tel1').attr('required',false))
				$($('label span').text('*'))
			}else{
				$($('#civ_contact').attr('required',false))
				$($('#last_name').attr('required',false))
				$($('#email').attr('required',false))
				$($('#tel1').attr('required',false))
				$($('label span').text(''))
			}
		})
		

		$(document).on('change','#sel_op_cap', function(){
			if($(this).val() == ''){
				$('#val_cap').val('')
			}
		})
		
		$(document).on('click','#btvalidefiltre', function(){
			HoldOn.open();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					idflts:$('#id_sel_filtre').val(),
					idfltsopcap: $('#sel_op_cap').val(),
					valcap: $('#val_cap').val(),
					chktmp: ($('#chktmp').is(':checked') ? 1 : 0),
					chkemp: ($('#chkemp').is(':checked') ? 1 : 0),
					app:'SEARCH',
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					// $('#cltmp').css('display','none');
					// $('#btcltmp').css('display','none');
					// $('.clntp').css('display','none');
					arrTmp = [];
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
		// $(document).on('click','#btvalidefiltre', function(){
		// 	HoldOn.open();
		// 	$.post('appajax.php', {
		// 			action: 'search-chambres', 
		// 			dtstart:$('#date_start').val(), 
		// 			dtend:$('#date_end').val(), 
		// 			timestart:$('#time_start').val(), 
		// 			timeend:$('#time_end').val(), 
		// 			idct:$('#id_fiche').val(),
		// 			idflts:$('#id_sel_filtre').val(),
		// 			idfltspiscine: $('#sel_piscine_filtre').val(),
		// 			idfltsopcap: $('#sel_op_cap').val(),
		// 			valcap: $('#val_cap').val(),
		// 		}, function(resp) {

		// 		if (resp.responseAjax == 'SUCCESS') {
		// 			$("#chdispo").html(resp.res)
		// 		}
		// 		else
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
				
		// 		HoldOn.close();

		// 	}, 'json');
		
		// 	return false;
		// })

		$('#btinfclifact').click(function(){
			if($("#infclifact").css("display") == "none" ){
				console.log('jjj99')
				$("#btinfclifact > i").removeClass('fa fa-angle-up')
				$("#btinfclifact > i").addClass('fa fa-angle-down')
				$("#infclifact").fadeIn("slow","linear");
			}else{
				$("#btinfclifact > i").removeClass('fa fa-angle-down')
				$("#btinfclifact > i").addClass('fa fa-angle-up')
				$("#infclifact").fadeOut("slow","linear");
			}
			return false
		})

		$('#btinfcligene').click(function(){
			// $('.glyphicon').parent().removeClass('active');
			// $('#itemtab1').css('display',true)
			// $('#itemtab2').css('display',true)

			if( $("#infcligene").css("display") == "none" ){
				$('#btinfcligene > i').removeClass('fa fa-angle-up')
				$('#btinfcligene > i').addClass('fa fa-angle-down')
				$('#infcligene').fadeIn("slow","linear");
				$('#btinfcligene').text('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' Masquer déatils client' : ' Hide customer details') ?>')
			}else{
				$('#btinfcligene > i').removeClass('fa fa-angle-down')
				$('#btinfcligene > i').addClass('fa fa-angle-up')
				$('#infcligene').fadeOut("slow","linear");
				$('#btinfcligene').text('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ' Afficher déatils client' : ' Display customer details') ?>')
			}
			return false;
		})

		$('#btinfclidetails').click(function(){
			if( $("#infclidetails").css("display") == "none" ){
				$('#btinfclidetails > i').removeClass('fa fa-angle-up')
				$('#btinfclidetails > i').addClass('fa fa-angle-down')
				$('#infclidetails').fadeIn("slow","linear");
			}else{
				$('#btinfclidetails > i').removeClass('fa fa-angle-down')
				$('#btinfclidetails > i').addClass('fa fa-angle-up')
				$('#infclidetails').fadeOut("slow","linear");
			}
			return false;
		})

		$('#btinfclipaie').click(function(){
			if( $("#infclipaie").css("display") == "none" ){
				$('#btinfclipaie > i').removeClass('fa fa-angle-up')
				$('#btinfclipaie > i').addClass('fa fa-angle-down')
				$('#infclipaie').fadeIn("slow","linear");
			}else{
				$('#btinfclipaie > i').removeClass('fa fa-angle-down')
				$('#btinfclipaie > i').addClass('fa fa-angle-up')
				$('#infclipaie').fadeOut("slow","linear");
			}
			return false;
		})

		$('#btaddbd').click(function(){
			if( $(".bd").css("display") == "none" ){
				$('#btaddbd > i').removeClass('fa fa-angle-up')
				$('#btaddbd > i').addClass('fa fa-angle-down')
				$(".bd").fadeIn("slow","linear");
			}else{
				$('#btaddbd > i').removeClass('fa fa-angle-down')
				$('#btaddbd > i').addClass('fa fa-angle-up')
				$(".bd").fadeOut("slow","linear");
			}
			return false;
		})

		$('#btaddph2').click(function(){
			if( $(".ph2").css("display") == "none" ){
				$('#btaddph2 > i').removeClass('fa fa-angle-up')
				$('#btaddph2 > i').addClass('fa fa-angle-down')
				$(".ph2").fadeIn("slow","linear");
			}else{
				$('#btaddph2 > i').removeClass('fa fa-angle-down')
				$('#btaddph2 > i').addClass('fa fa-angle-up')
				$(".ph2").fadeOut("slow","linear");
			}
			return false;
		})

		$('#btaddadr').click(function(){
			if( $(".addadr").css("display") == "none" ){
				$('#btaddadr > i').removeClass('fa fa-angle-up')
				$('#btaddadr > i').addClass('fa fa-angle-down')
				$(".addadr").fadeIn("slow","linear");
			}else{
				$('#btaddadr > i').removeClass('fa fa-angle-down')
				$('#btaddadr > i').addClass('fa fa-angle-up')
				$(".addadr").fadeOut("slow","linear");
			}
			return false;
		})

		$('#btaddinfcreate').click(function(){
			if( $(".infcreate").css("display") == "none" ){
				$('#btaddinfcreate > i').removeClass('fa fa-angle-up')
				$('#btaddinfcreate > i').addClass('fa fa-angle-down')
				$(".infcreate").fadeIn("slow","linear");
			}else{
				$('#btaddinfcreate > i').removeClass('fa fa-angle-down')
				$('#btaddinfcreate > i').addClass('fa fa-angle-up')
				$(".infcreate").fadeOut("slow","linear");
			}
			return false;
		})


		var iddet = 0;
		$(document).on('click','.bttransport', function(){

			iddet = $(this).attr('data-id');
			var vn =  $(this).attr('data-vn');
			var vs =  $(this).attr('data-vs');
			var ns =  $(this).attr('data-ns');
			if(vn == '1'){
				$('#volnavette').prop('checked', true)
				$('#volseul').prop('checked', false)
				$('#navetteseule').prop('checked', false)
			}
			if(vs == '1'){
				$('#volnavette').prop('checked', false)
				$('#volseul').prop('checked', true)
				$('#navetteseule').prop('checked', false)
			}
			if(ns == '1'){
				$('#volnavette').prop('checked', false)
				$('#volseul').prop('checked', false)
				$('#navetteseule').prop('checked', true)
			}
			$('#iddet').val(iddet);

			$('#modal-transport').modal();
			return false
		})

		$('#volnavette').click(function(){
			if($('#volnavette').is(':checked')){
				$('#restransp').val('vn');

				$('#volseul').prop('checked', false)
				$('#navetteseule').prop('checked', false)
			}
		})
		$('#volseul').click(function(){
			if($('#volseul').is(':checked')){
				$('#restransp').val('vs');
				
				$('#volnavette').prop('checked', false)
				$('#navetteseule').prop('checked', false)
			}
		})
		$('#navetteseule').click(function(){
			if($('#navetteseule').is(':checked')){
				$('#restransp').val('ns');

				$('#volnavette').prop('checked', false)
				$('#volseul').prop('checked', false)
			}
		})
				
		$('#btoktransport').click(function(){
			HoldOn.open();
			$.post('appajax.php', {action: 'maj-transport', idct: $('#id_fiche').val(), iddet:$('#iddet').val(), restransp:$('#restransp').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#list_details').trigger("reloadGrid",[{current:true}]);
					
					$('#modal-transport').modal('hide');
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

		$(document).on('click','.clresetdir, .clresetct', function(){
			window.location.reload();
		})
		
		function majTarifsDetails(){
			$.post('appajax.php', {action: 'maj-tarifs-details', 
				idct: $('#id_fiche').val(), 
				istotmanu:$('#istotmanu').val(), 
				tot_ht:$('#tot_ht').val(),
				tarifmanu:$('#tot_manu').val(),
			 }, function(resp) {
				
				if (resp.responseAjax == "SUCCESS") {
					// console.log('ddd',typeof parseInt(resp.totht), typeof resp.totht)
					$('#tot_ht').val(Math.round(resp.totht))
					$('#tot_global').val(Math.round(parseFloat($('#tot_ht').val())))
					$('#tot_restant').val((typeof resp.restant == 'number' ? Math.round(resp.restant) : 0 ))
					$('#mt_fin').val(Math.round(resp.totreal));
					// $('#mt_fin').val((Math.round(parseFloat($('#tot_ht').val())) / ((100 - $('#offre_sejour').val()) / 100)) - $('#taxe_sejour').val());
					
					$('#list_virement_client').trigger("reloadGrid",[{current:true}]);

					if(resp.stsec > 0){
						$('#id_status_sec').val(resp.stsec);
						$('#id_status_sec').trigger('chosen:updated');
					}

					// window.location.reload();
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
			return false
		}

		$(document).keypress(function(){
            let key = event.key;
			console.log('key',key)
            if (key == 'Enter')  { 
				$('#list_details').trigger("reloadGrid",[{current:true}]);
				$('#list_details_options').trigger("reloadGrid",[{current:true}]);
				$('#list_virement_client').trigger("reloadGrid",[{current:true}]);
				$('#list_transports_details').trigger("reloadGrid",[{current:true}]);

				majTarifsDetails();
			}
		})

		
		$(document).on('click','.ui-icon-disk',function(){
			
			$('#list_details').trigger("reloadGrid",[{current:true}]);
			$('#list_details_options').trigger("reloadGrid",[{current:true}]);
			$('#list_virement_client').trigger("reloadGrid",[{current:true}]);
			$('#list_transports_details').trigger("reloadGrid",[{current:true}]);

			majTarifsDetails();
		})
		
		$(document).on('click','.ui-icon-trash',function(){
			console.log('trash')
			setTimeout(function() {
				var delgrid = document.getElementById("dData");

				delgrid.addEventListener("click", function(){
					console.log('trash222')
					majTarifsDetails();
				});
			}, 1000);

			return false;
		})


		// var addgrid = document.getElementById("sData");
		$('.ui-icon-plus ,.ui-icon-pencil').click(function(){
			console.log('add', $(this))

			setTimeout(function() {
				var addgrid = document.getElementById("sData");
	
				addgrid.addEventListener("click", function(){
					console.log('add 22')
					majTarifsDetails();
				});
			}, 1000);

			// return false;
		})
		
		// $(document).on('click','#sData',function(){
		// 	console.log('sData')
		// 	majTarifsDetails();
		// 	return false;
		// })		

		// $(document).on('click','#dData',function(){
		// 	console.log('trash')
		// 	majTarifsDetails();
		// 	return false;
		// })

		$(document).on('change','#libelle_tarif_details',function(){
			$.post('appajax.php', {action: 'read-tarif-details', idct: $('#id_fiche').val(), idtarif:$('#libelle_tarif_details').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#tarif_details').val(resp.tarif)

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

		$(document).on('change','#id_lib_option',function(){
			$.post('appajax.php', {action: 'read-tarif-details', idct: $('#id_fiche').val(), idtarif:$('#id_lib_option').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#tarif_detail_option').val(resp.tarif)
					$('#tot_tarif_option').val(resp.tarif * $('#qte_detail_option').val())

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

		$(document).on('keyup','#qte_detail_option',function(){
			$.post('appajax.php', {action: 'read-tarif-details', idct: $('#id_fiche').val(), idtarif:$('#id_lib_option').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#tarif_detail_option').val(resp.tarif)
					$('#tot_tarif_option').val(resp.tarif * $('#qte_detail_option').val())

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

		// $(document).on('change','#lib_detail_option',function(){
		// 	$.post('appajax.php', {action: 'read-tarif-details', idct: $('#id_fiche').val(), idtarif:$('#lib_detail_option').val() }, function(resp) {
		// 		if (resp.responseAjax == "SUCCESS") {
		// 			$('#tarif_detail_option').val(resp.tarif)

		// 		}
		// 		else {
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
		// 		}
		// 	}, 'json');
				
		// 	HoldOn.close();
		// 	return false;
			
		// })

		$(document).on('focusout, change','#date_naissance_detail',function(){
			
			$.post('appajax.php', {action: 'age-tarif-details', idct: $('#id_fiche').val(), dt:$('#date_naissance_detail').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#age_details').val(resp.tarif)

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

		// gestion des options sur les transports //
		$(document).on('change','#id_transport_detail',function(){
			$.post('appajax.php', {action: 'read-tarif-transport-details', idct: $('#id_fiche').val(), idtarif:$('#id_transport_detail').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#tarif_transport_detail').val(resp.tarif)
					
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

		$('#btvalidedevise').click(function(){
			if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez le changement de devise et le recalcul des montants' : 'Confirm currency change and recalculation of amounts') ?>')){
				return false;
			}
			$.post('appajax.php', {action: 'change-devise', idct: $('#id_fiche').val(), codedevise:$('#seldevises').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});

					$.post('appajax.php', {action: 'devises',idct: $('#id_fiche').val(), montant: $('#tot_ht').val(), devisefrom:$('#codedevisect').val(), deviseto:$('#seldevises').val(), ac25:$('#accompte_25').val(),taxesej:$('#taxe_sejour').val() }, function(resp) {
						if (resp.responseAjax == "SUCCESS") {
							$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
								type: 'success',
								delay: 5000,
								offset: {
								from: "top",
								amount: 100
									},
									align: "center",
								allow_dismiss: true
							});

							window.location.reload(true); 
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



		// envoi devis et contrat avec affichage prealable //
		// $('#btsendinfmail').click(function(){
		$(document).on('click', '#btsendinfmail, #btsendinfmailcont', function(){
			if($('#lnk-mail').val() == ''){
				alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse mail obligatoire' : 'Email require') ?>")
				return false;
			}
			$('#id_mailtypeinsc').val('0');
			$('#typeMailinsc').val('0');
			$('#attachclrinsc').val('0');
			$('#idMailTypeinsc').val('0');
			$('#name_mailtype').val('');
			$('#subjectmailinsc').val('');
			CKEDITOR.instances.msgcontentinsc.updateElement();
			CKEDITOR.instances.msgcontentinsc.setData('');

			$('#destemailinsc').val($('#email').val());
			$('#lginsc').val($('#lg').val());
			$('#modal-new-fiche').modal('hide')

			$('#modal-msg-mail-i').modal();
		
			return false;
		})

		$('.modeltype').click(function() {
			$('#id_mailtype').val('0');
			$('#typeMail').val('0');
			$('#idMailType').val('0');
			$('#name_mailtype').val('');
			$('#msgcontent').val('');
			CKEDITOR.instances.msgcontent.updateElement();
			CKEDITOR.instances.msgcontent.setData('');
			
			$('#typeMail').val($(this).attr('data-typeMail'))
			idmt = $(this).attr('data-id');
			$('#idMailType').val(idmt)
			

			//for($i=1;$i<=selrowsMail.length; $i++){
				HoldOn.open();
				$.post('appajax.php', {
					action: 'affiche-mailtype',
					id_mailtype: idmt,
					id_fiche : $('#id_fiche').val(),
					mail:$('#destemail').val(),
					app:'',
					url:'<?php echo $template['public_url']?>',
					lg:$('#lg').val(),
				}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						
						var msg = resp.msg;
						var subject = resp.subject;
						var dest = resp.dest;

						$('#destemail').val(dest)

						$('#subjectmail').val(subject);
						
						$('#msgcontent').val(msg);
						CKEDITOR.instances.msgcontent.setData(msg);
						if (resp.data.attach != '')
							$('#attacheddocs').html('<u>Pièces jointes</u> : ' + JSON.parse(resp.data.attach).join(", "));
						else
							$('#attacheddocs').text('');
						$('#id_mailtype').val(idmt);
						$('#attachclr').val('0');
					} else
						alert(resp.message);

					$('.tooltip.in').remove();
				}, 'json');
			// }

			// HoldOn.close();
			$('#btmtcontinsc').dropdown("toggle");
			return false;
		});

		$('.modeltypeinsc').click(function() {
			$('#id_mailtypeinsc').val('0');
			$('#typeMailinsc').val('0');
			$('#idMailTypeinsc').val('0');
			$('#name_mailtype').val('');
			$('#msgcontentinsc').val('');
			CKEDITOR.instances.msgcontentinsc.updateElement();
			CKEDITOR.instances.msgcontentinsc.setData('');
			
			$('#typeMailinsc').val($(this).attr('data-typeMail'))
			idmt = $(this).attr('data-id');
			$('#idMailTypeinsc').val(idmt)
			

			//for($i=1;$i<=selrowsMail.length; $i++){
				HoldOn.open();
				$.post('appajax.php', {
					action: 'affiche-mailtype',
					id_mailtype: idmt,
					id_fiche : $('#id_fiche').val(),
					mail:$('#destemailinsc').val(),
					app:'A',
					url:'<?php echo $template['public_url']?>',
					type:'A',
					lg:$('#lg').val(),
				}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						
						var msg = resp.msg;
						var subject = resp.subject;
						var dest = resp.dest;

						$('#destemailinsc').val(dest)

						$('#subjectmailinsc').val(subject);
						
						$('#msgcontentinsc').val(msg);
						CKEDITOR.instances.msgcontentinsc.setData(msg);
						if (resp.data.attach != '')
							$('#attacheddocsinsc').html('<u>Pièces jointes</u> : ' + JSON.parse(resp.data.attach).join(", "));
						else
							$('#attacheddocsinsc').text('');
						$('#id_mailtypeinsc').val(idmt);
						$('#attachclrinsc').val('0');
					} else
						alert(resp.message);

					$('.tooltip.in').remove();
				}, 'json');
			// }

			// HoldOn.close();
			$('#btmtcontinsc').dropdown("toggle");
			return false;
		});


		$('#btadddocinsc').click(function() {
			$('#fileaddinsc').click();
		});
		$('#btdeldocinsc').click(function() {
			$('#fileaddinsc').val('');
			$('#attacheddocsinsc').text('');
			$('#attachclrinsc').val('1');
			return false;
		})


		$('#fileaddinsc').change(function() {
			var str = '';
			var files = $(this).prop("files")
			var names = $.map(files, function(val) {
				return val.name;
			});
			$.each(names, function(i, name) {
				str += str == '' ? name : ', ' + name;
			});
			$('#attacheddocsinsc').html(str != '' ? '<u>Pièces jointes</u> : ' + str : '');
			$('#attachclrinsc').val('0');
		});

		$('#btadddocininsc').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'load-listdocs', idc: $('#id_fiche').val()}, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {
					$('#lstdocscttinsc').html(resp.html);
					$('#blksenddocintinsc').show();
				}
				else
					alert(resp.message);
				
				HoldOn.close();

			}, 'json');
		
			return false;
		});

		$('#btmailsendinginsc').click(function() {
			$('#idMailTypeinsc').val(idmt);
			
			HoldOn.open();
			
			jQuery('#formulairemsginsc').ajaxSubmit({
				dataType:'json',
				data:{action:'send-mail-insc', idct:$('#id_fiche').val(), email:$('#destemailinsc').val(), idmailtype: $('#id_mailtypeinsc').val(), subject:$('#subjectmailinsc').val(), msg:$('#msgcontentinsc').val()},
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
						
						$('#modal-msg-mail-i').modal('hide');
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
		
		// envoi devis et contrat avec affichage prealable //


		$('#btlnkdevis').click(function(){
			console.log('isncript')
			if($('#email').val() == ''){
				alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mail obligatoire \n\rPensez a valider la fiche pour l\'enregistrer' : 'Email required \n\rremember to validate the form to save it ') ?>")
				return false;
			}
			// send email avec lien
			$.post('appajax.php', {
				action: 'send-lnk-inscription', 
				type:'A',
				email:$('#email').val(),
				idct: $('#id_fiche').val(), 
				app:'lnkdevis', 
				url:'<?php echo $template['public_url']?>',
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {

					$('#modal-new-fiche').modal('hide')
					$('#id_status_sec').val(resp.idstsec);
					$('#id_status_sec').trigger('chosen:updated');

					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});
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

		// $('#btlnkdevis').click(function(){
		// 	$.post('appajax.php', {action: 'print-devis', idct: $('#id_fiche').val(), app:'lnkdevis', url:$('#puburl').val() }, function(resp) {
		// 		if('<?php echo $curusr->lnk_devis > 0 ?>' ){
		// 			if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Devis déjà envoyé ! Confirmez l\'envoi' : 'Quote already sent ! Confirm sending') ?>")){
		// 				return false;
		// 			}
		// 		}else{
		// 			if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez l\'envoi' : 'Confirm sending') ?>")){
		// 				return false;
		// 			}
		// 		}
		// 		if (resp.responseAjax == "SUCCESS") {
		// // 				console.log(resp)

		// 			$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'success',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});

		// 		}
		// 		else {
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
		// 		}
		// 	}, 'json');
				
		// 	HoldOn.close();
		// 	return false;
		// })

		$('#btlnkcontrat').click(function(){
			console.log($('#email').val(),$('#id_fiche').val())
			if($('#email').val() == ''){
				alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse mail obligatoire' : 'Email require') ?>")
				return false;
			}
			// send email avec lien
			$.post('appajax.php', {
				action: 'send-lnk-inscription', 
				id_fiche:$('#id_fiche').val(),
				type:'C',
				email:$('#email').val(),
				url:'<?php echo $template['public_url']?>',
			}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#id_status_sec').val(resp.idstsec);
					$('#id_status_sec').trigger('chosen:updated');

					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});
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

		// $('#btlnkcontrat').click(function(){
		// 	$.post('appajax.php', {action: 'print-contrat', idct: $('#id_fiche').val(), app:'lnkcontrat', url:$('#puburl').val() }, function(resp) {
		// 		if('<?php echo $curusr->lnk_contrat_sended > 0 ?>' ){
		// 			if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat déjà envoyé ! Confirmez l\'envoi' : 'Contract already sent ! Confirm sending') ?>")){
		// 				return false;
		// 			}
		// 		}else{
		// 			if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez l\'envoi' : 'Confirm sending') ?>")){
		// 				return false;
		// 			}
		// 		}
		// 		if (resp.responseAjax == "SUCCESS") {
		// // 				console.log(resp)

		// 			$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'success',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});

		// 		}
		// 		else {
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
		// 		}
		// 	}, 'json');
				
		// 	HoldOn.close();
		// 	return false;
		// })

		$('#btlnkfac').click(function(){
			$.post('appajax.php', {action: 'print-facture', idct: $('#id_fiche').val(), app:'lnkfac' }, function(resp) {
				if('<?php echo $curusr->lnk_facture > 0 ?>' ){
					if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Facture déjà envoyée ! Confirmez l\'envoi' : 'Invoice already sent ! Confirm sending') ?>")){
						return false;
					}
				}else{
					if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez l\'envoi' : 'Confirm sending') ?>")){
						return false;
					}
				}
				if (resp.responseAjax == "SUCCESS") {
		// 				console.log(resp)

					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});

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

		// $('#volnavette').click(function(){
		// 	if($('#volnavette').is(':checked')){
		// 		$('#volseul').prop('checked', false)
		// 		$('#navetteseule').prop('checked', false)
		// 	}
		// })
		
		// $('#volseul').click(function(){
		// 	if($('#volseul').is(':checked')){
		// 		$('#volnavette').prop('checked', false)
		// 		$('#navetteseule').prop('checked', false)
		// 	}
		// })

		// $('#navetteseule').click(function(){
		// 	if($('#navetteseule').is(':checked')){
		// 		$('#volnavette').prop('checked', false)
		// 		$('#volseul').prop('checked', false)
		// 	}
		// })

		
		$('#listeCh').DataTable({     
		"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
			"iDisplayLength": -1,
			"bFilter": false,
		});
		
		$('#listeCh_length').text('');
		$('#listeCh_info').text('');
		$('#listeCh_paginate').css('display','none');

		// Tabs
		$(function() {
			$('div.icon-tab').click(function() {
				$(this).addClass('active').siblings().removeClass('active');
				setDisplay(450);
			});

			function setDisplay(time) {
				$('div.icon-tab').each(function(rang) {
					$('.item').eq(rang).css('display', 'none');

					if($(this).hasClass('active')){
						$('.item').eq(rang).fadeIn(time);
					}
				});
			}
			setDisplay(0);
		});

		let oldstatuscont = 0;
		let previouscontconf = '';
		let previouscont = '';
		var nbclickadulte = 0;
		var nbclickenfant = 0;
		var nbclickbb = 0;

		var arrResCh = [];

		function CalculTarif(){
			
		}
		
		initFields();

		$('#btokch').click(function() {
			HoldOn.open();
			$.post('appajax.php', {
					action: 'add-chambre-ct', 
					idct:$('#id_fiche').val(), 
					datedeb:$('#date_start').val(), 
					dateend:$('#date_end').val(), 
					hdeb:$('#time_start').val(), 
					hend:$('#time_end').val(), 
					sejour: sejourActif,
					resch:arrResCh,
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					
					$('#modal-dispo-chambre').modal('hide')

					// CalculTarif();

					// window.location.reload(true); 
					// $('#formulairedetails').submit();
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

		$(document).on('click', '.btdelch', function(){
			if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez la suppresion de la chambre' : 'Confirm room deletion') ?>')){
				return false;
			}
			HoldOn.open();
			$.post('appajax.php', {
					action: 'del-chambre-ct', 
					idct:$('#id_fiche').val(), 
					numch:  $(this).attr('data-num-ch'), //num chambre
					idch:  $(this).attr('data-id-ch'), //id de db_chambre
					idctch:  $(this).attr('data-id'), //id de db_contacts_chambres
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					// CalculTarif();

					// window.location.reload(true); 
					$('#formulairedetails').submit();
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

		$('#last_name').blur(function(){
			if($('#raison_sociale').val() == ''){
				$('#raison_sociale').val($('#last_name').val())
			}
		})

		$('#adr1').blur(function(){
			if($('#adr_facture').val() == ''){
				$('#adr_facture').val($('#adr1').val())
			}
		})

		$('#city').blur(function(){
			if($('#city_facture').val() == ''){
				$('#city_facture').val($('#city').val())
			}
		})

		$('#post_code').blur(function(){
			if($('#post_code_facture').val() == ''){
				$('#post_code_facture').val($('#post_code').val())
			}
		})

		$('#country').blur(function(){
			if($('#country_facture').val() == ''){
				$('#country_facture').val($('#country').val())
			}
		})

		var sejourActif = 0;

		$(document).on('click','.retenir',function(){
			let idch = $(this).attr('data-id-chambre');
			let numch = $(this).attr('data-num-chambre');
			sejourActif =  $(this).attr('data-sejour');
			// $('#ch_'+idch).css({'background-color':'red !important'})
			$('#ch_'+idch).attr('style', 'background-color:red !important')
			$('#sel_'+idch).text('1')
			let posch = arrResCh.indexOf(numch)
			if(parseInt(posch) < 0){
				arrResCh.push(numch)
			}
		})

		$(document).on('click','.liberer',function(){
			let idch = $(this).attr('data-id-chambre');
			let numch = $(this).attr('data-num-chambre');
			
			sejourActif =  $(this).attr('data-sejour');

			let couleur = $(this).attr('data-color');
			// $('#ch_'+idch).css({'background-color':'red !important'})
			$('#ch_'+idch).attr('style', 'background-color:'+couleur+' !important')
			$('#sel_'+idch).text('0')
			let posch = arrResCh.indexOf(numch)
			if(parseInt(posch) >= 0){
				arrResCh.splice(posch)
			}
		})


		var searchInf = false;

		$(document).on('click','#btsearchinf',function(){
			$('#btcltmp').css('display','none');
			$('#btcldel').css('display','none');
			$('#btclemp').css('display','none');

			if(searchInf){
				$('#clinf').css('display','none');
				searchInf = false;
			}else{
				$('#clinf').css('display','flex');
				searchInf = true;
			}

			$('#clclts').css('display','none');
			$('#cltmp').css('display','none');
			$('#btclfiche').css('display','none');
		})

		$(document).on('click','#btclinf',function(){
			HoldOn.open();

			$.post('appajax.php', {
					action: 'search-inf',
					idfiche:$('#sel_clts_inf').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					// $("#clt_inf").val(resp.res).css('color', 'black');
					let resaff = '<b>'+resp.res+'</b>' + '<span style = "color:red">'+resp.res2.toUpperCase()+'</span>';
					$("#clt_inf").html(resaff);
					arrTmp = [];
					numChLine = 0;
					// $('#clinf').css('display','none');
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

		var selclear = 0;
		var colorElement = '';

		$(document).on('change', '.seltypech', function(){
			
			numChLine = $(this).parent().attr('id').split('-')
			
			console.log(selclear, $(this).attr('id'))
			if(selclear != $(this).attr('id') && selclear != 0){
				if(colorElement != ''){
					document.getElementById(selclear).parentElement.style.backgroundColor = colorElement 
					
					colorElement = $(this).parent().parent().css("background-color");
				}				


				selclear = selclear.split('-')
				$('.'+selclear[0].trim()).val('')
				selclear = $(this).attr('id')

				$(this).parent().css("background-color", "black")
			}else{
				if(colorElement == ''){
					colorElement = $(this).parent().parent().css("background-color");
				}

				selclear = $(this).attr('id')
				$(this).parent().css("background-color", "black")
			}

			console.log(numChLine)
			if($(this).val() == 'T'){
				$('#btclfiche').css('display','none');
				$('#btcldel').css('display','none');
				$('#btclemp').css('display','none');
				
				$('#clinf').css('display','none');
				$('#clclts').css('display','none');
				
				$('#cltmp').css('display','flex');
				$('#btcltmp').css('display','block');
				$('.clntp').css('display','block');
				
			}
			
			if($(this).val() == 'C'){
				$('#btcltmp').css('display','none');
				$('#btcldel').css('display','none');
				$('#btclemp').css('display','none');
				
				$('.clntp').css('display','none');

				$('#clinf').css('display','none');

				$('#clclts').css('display','flex');
				$('#cltmp').css('display','flex');
				$('#btclfiche').css('display','block');
				
			}
			
			if($(this).val() == 'P'){
				$('#btclfiche').css('display','none');
				$('#btcldel').css('display','none');
				$('#btcltmp').css('display','none');

				$('#clinf').css('display','none');
				$('#clclts').css('display','none');

				$('#cltmp').css('display','flex');
				$('.clntp').css('display','block');
				$('#btclemp').css('display','block');
				
			}
			
			if($(this).val() == 'A'){
				$('#btcltmp').css('display','none');
				$('#btclfiche').css('display','none');
				$('#btclemp').css('display','none');

				$('#clinf').css('display','none');
				$('#clclts').css('display','none');
				
				$('#cltmp').css('display','flex');
				$('#btcldel').css('display','block');
				$('.clntp').css('display','none');
				
			}
			
			if($(this).val() == ''){
				$('#btcltmp').css('display','none');
				$('#btclfiche').css('display','none');
				$('#btclemp').css('display','none');
				$('#btcldel').css('display','none');

				$('#clinf').css('display','none');
				$('#clclts').css('display','none');
				
				$('#cltmp').css('display','none');
				$('.clntp').css('display','none');
				
			}

			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
			
		})

		// ANCIENNE METHODE AVEC BOUTON ALIGNES
		$(document).on('click','.clfiche',function(){
			$('#btcltmp').css('display','none');
			$('#btcldel').css('display','none');
			$('#btclemp').css('display','none');
			
			$('.clntp').css('display','none');

			$('#clinf').css('display','none');

			$('#clclts').css('display','flex');
			$('#cltmp').css('display','flex');
			$('#btclfiche').css('display','block');
			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})

		$(document).on('click','#btclfiche',function(){
			

			HoldOn.open();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'FICHE',
					numch:numChLine[0].trim(),
					idfiche:$('#sel_clts').val(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					arrTmp = [];
					numChLine = 0;
					$('#clclts').css('display','none');
					$('#cltmp').css('display','none');
					$('#btclfiche').css('display','none');
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

		
		$(document).on('click','.cltmp',function(){
			$('#btclfiche').css('display','none');
			$('#btcldel').css('display','none');
			$('#btclemp').css('display','none');
			
			$('#clinf').css('display','none');
			$('#clclts').css('display','none');
			
			$('#cltmp').css('display','flex');
			$('#btcltmp').css('display','block');
			$('.clntp').css('display','block');
			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})


		$(document).on('click','#btcltmp',function(){
			
			HoldOn.open();

			let nameTmpEmp = $('#name_tmp_emp').val();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'TMP',
					nameTmpEmp:nameTmpEmp,
					numch:numChLine[0].trim(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btcltmp').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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

		// ANCIENNE METHODE AVEC BOUTON ALIGNES
		$(document).on('click','.clemp',function(){
			$('#btclfiche').css('display','none');
			$('#btcldel').css('display','none');
			$('#btcltmp').css('display','none');

			$('#clinf').css('display','none');
			$('#clclts').css('display','none');

			$('#cltmp').css('display','flex');
			$('.clntp').css('display','block');
			$('#btclemp').css('display','block');

			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})


		$(document).on('click','#btclemp',function(){
			
			HoldOn.open();

			let nameTmpEmp = $('#name_tmp_emp').val();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'EMP',
					nameTmpEmp:nameTmpEmp,
					numch:numChLine[0].trim(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btclemp').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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

		// $(document).on('click','.cltmp',function(){
		// 	HoldOn.open();
		// 	$.post('appajax.php', {
		// 			action: 'check-tmp-chambre', 
		// 			arrTmp:arrTmp,
		// 			app:'TMP',
		// 			numch:$(this).parent().attr('id'),
		// 		}, function(resp) {

		// 		if (resp.responseAjax == 'SUCCESS') {
		// 			$("#chdispo").html(resp.res);
		// 			arrTmp = [];
		// 		}
		// 		else
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
				
		// 		HoldOn.close();

		// 	}, 'json');
		
		// 	return false;
		// })

		// ANCIENNE METHODE AVEC BOUTON ALIGNES
		$(document).on('click','.cldel',function(){
			$('#btcltmp').css('display','none');
			$('#btclfiche').css('display','none');
			$('#btclemp').css('display','none');

			$('#clinf').css('display','none');
			$('#clclts').css('display','none');
			
			$('#cltmp').css('display','flex');
			$('#btcldel').css('display','block');
			$('.clntp').css('display','none');
			numChLine = $(this).parent().attr('id').split('-')
			arrTmp = [];
		})

		$(document).on('click','#btcldel',function(){
			if((!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression des réservations de cette chambre ?' : 'Deletion of the registration for this room ?')?>"))){
				return false;
			}
			

			HoldOn.open();
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'DEL',
					numch:numChLine[0].trim(),
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					if(resp.countidcli == '1'){
						HoldOn.close();
						if(confirm('Cette chambre est actuellement attribuée au client ID : '+resp.infdelcli+'\n\rConfirmez la suppression de cette chambre pour toute sa periode ?')){
							forwardDel(resp.delidcli);
							arrTmp = [];
						}
						return false;
					}
					if(parseInt(resp.countidcli) > 1){
						HoldOn.close();
						alert('Cette chambre est actuellement attribuée à plusieurs clients sur la pèriode sélectionnée\n\rSeul la suppression des chambres du personnel et temporaire seront effectuée\n\rPour supprimer la chambre du client vous devrez passer par sa fiche pour éviter toute erreur de date')
						arrTmp = [];	
						return false;
					}

					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btcldel').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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

		function forwardDel(idcli=0){
			HoldOn.open();
			arrTmp = [];

			let arrId= [];
			arrId.push(idcli)
			let dst = $('#date_deb_sej').val().split('/')
			let dend = $('#date_end_sej').val().split('/')
			arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
			arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

			$.post('appajax.php', {
					action: 'check-tmp-chambre', 
					arrTmp:arrTmp,
					app:'DEL',
					numch:numChLine[0].trim(),
					forceDel:'1',
					lstId:arrId
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					
					$("#chdispo").html(resp.res);
					$('#cltmp').css('display','none');
					$('#btcldel').css('display','none');
					$('.clntp').css('display','none');
					arrTmp = [];
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
		}

		// $(document).on('click','.clemp',function(){
		// 	$('#btcltmp').css('display','none');
		// 	$('#btclfiche').css('display','none');
		// 	$('#btcldel').css('display','none');

		// 	$('#clinf').css('display','none');

		// 	$('#clclts').css('display','none');
		// 	$('#cltmp').css('display','flex');
		// 	$('#btcldel').css('display','block');
		// 	numChLine = $(this).parent().attr('id').split('-')
		// 	arrTmp = [];
		// })

		// $(document).on('click','#btclemp',function(){
			
		// 	HoldOn.open();
		// 	let nameTmpEmp = $('#name_tmp_emp').val();
		// 	let dst = $('#date_deb_sej').val().split('/')
		// 	let dend = $('#date_end_sej').val().split('/')
		// 	arrTmp.push(dst[2]+'-'+dst[1]+'-'+dst[0]);
		// 	arrTmp.push(dend[2]+'-'+dend[1]+'-'+dend[0]);

		// 	$.post('appajax.php', {
		// 			action: 'check-tmp-chambre', 
		// 			arrTmp:arrTmp,
		// 			app:'EMP',
		// 			nameTmpEmp:nameTmpEmp,
		// 			numch:numChLine[0].trim(),
		// 		}, function(resp) {

		// 		if (resp.responseAjax == 'SUCCESS') {
		// 			$("#chdispo").html(resp.res);
		// 			$('#cltmp').css('display','none');
		// 			$('#btcldel').css('display','none');
		// 			arrTmp = [];
		// 		}
		// 		else
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
				
		// 		HoldOn.close();

		// 	}, 'json');
		
		// 	return false;
		// })

		var arrTmp = [];
		var numChLine = 0;

		$(document).on('click','.clchk',function(){
			if($(this).prop('checked')){
				$(this).parent().css('background-color','blue')[0];
				arrTmp.push($(this).attr('id'))
			}else{
				$(this).parent().css('background-color','white')[0];
				let index = arrTmp.indexOf($(this).attr('id'));
				if (index > -1) {
					arrTmp.splice(index, 1);
				}
				
			}
			// console.log(arrTmp);
		})

		var isModalOpen = false;

		$('#idbtdispochdetails').click(function(){
			$('#date_deb_sej').datepicker( "setDate", $('#date_start').val() );
			$('#date_end_sej').datepicker( "setDate", $('#date_end').val() );

			HoldOn.open();
			$.post('appajax.php', {
					action: 'search-chambres-jours', 
					dtstart:$('#date_start').val(), 
					dtend:$('#date_end').val(), 
					timestart:$('#time_start').val(), 
					timeend:$('#time_end').val(), 
					idct:$('#id_fiche').val()
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#dtd').text($('#date_start').val()+' au '+$('#date_end').val())

					$("#chdispoentete").html(resp.entete)
					$("#chdispo").html(resp.res)
					$('.chosen-search-input.default').val("");
					// $('.chosen-search-input').attr("placeholder",'Type de chambre');
					$('#modal-dispo-chambre').modal("show")
					isModalOpen = true;
					$(".select-chosen").chosen();
					$("#id_sel_filtre_chosen").css('width','600px');
					$("#id_sel_filtre_chosen").css('margin-bottom','10px');
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

		$('#idbtdispoch').click(function(){
			HoldOn.open();
			$.post('appajax.php', {
					action: 'search-chambres', 
					dtstart:$('#date_start').val(), 
					dtend:$('#date_end').val(), 
					timestart:$('#time_start').val(), 
					timeend:$('#time_end').val(), 
					idct:$('#id_fiche').val()
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#dtd').text($('#date_start').val()+' au '+$('#date_end').val())

					$("#chdispo").html(resp.res)
					$('.chosen-search-input.default').val("");
					// $('.chosen-search-input').attr("placeholder",'Type de chambre');
					$('#modal-dispo-chambre').modal()
					isModalOpen = true;
					$(".select-chosen").chosen();
					$("#id_sel_filtre_chosen").css('width','600px');
					$("#id_sel_filtre_chosen").css('margin-bottom','10px');
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


		

		$('#nb_adulte').keyup(function(){
			if(parseInt($('#nb_adulte').val()) > 0){
				$('#btaddadulte').show();
			}else{
				$('#btaddadulte').hide();
			}

			tarifSejour();
		})

		$('#nb_enfant').keyup(function(){
			if(parseInt($('#nb_enfant').val()) > 0){
				$('#btaddenfant').show();
			}else{
				$('#btaddenfant').hide();
			}
			
			tarifSejour();
		})

		$('#nb_bb').keyup(function(){
			if(parseInt($('#nb_bb').val()) > 0){
				$('#btaddbb').show();
			}else{
				$('#btaddbb').hide();
			}
			
			tarifSejour();
		})

		$('#btreversetel').click(function(){
			$.post('appajax.php', {action:'reverse-tel', idct: $('#id_fiche').val(), }, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						$('#tel1').val(resp.tel1)
						$('#tel2').val(resp.tel2)
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
					HoldOn.close();
				}, 'json');	
			return false;
		})

		$('.btsmspres').click(function() {
			$('#modal-sms').modal();
			return false;			
		});

		$('#btsendsms').click(function() {
			HoldOn.open();
			
			jQuery('#formulairesms').ajaxSubmit({
				dataType:'json',
				data:{action:'send-contact-sms', idc:$('#id_fiche').val(), num:$('#docnum').val(), msg:$('#msgsms').val()},
				success : function (resp) {	
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {					
						$.bootstrapGrowl('<h4>Confirmation!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'SMS envoyé' : 'SMS sended')?></p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});
						
						$('#modal-sms').modal('hide');
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

		$('#btsigndoc').click(function() {
			
			if (confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez l\'envoi en signature à : ' : 'Confirm sending for signature to : ') ?>"+$('#email').val()+" ?")) {
				HoldOn.open();
				console.log('post :',$('#view_id_docs').val(), $('#id_fiche').val(), nameDocSign, typeDocSign)
				// return
				$.post('appajax.php', {action:'sign-doc', idd: $('#view_id_docs').val(), idc: $('#id_fiche').val(), nameDoc: nameDocSign, typeDoc: typeDocSign}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('#modal-pdf').modal('hide');
						$('#modal-confirm-sellsign').modal();
						$('#lnksellsign').attr('href', resp.url);
						$('#lnksellsign').text(resp.url);
						$('#idcontractsellsign').text('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Document transmis avec le CODE suivant : ' : 'Document transmitted with the following code : ') ?>'+resp.contract_id);
						idcallback = resp.contract_id;
						$('#list_signs').trigger("reloadGrid",[{current:true}]);
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
			}
			return false;
		});

		$('.btprint').click(function() {
			HoldOn.open();
			var act = $(this).attr('data-action');
			$.post('appajax.php', {
				action: act,
				id_prestation: $('#id_prestation').val()
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
					
					//$('body').append(resp.html);
					if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');

					if (resp.id_doc > 0)
						$('#view_id_docs').val(resp.iddoc);
					else
						$('#view_id_docs').val('');
					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();
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

		$('#formulairect').submit(function() {
			// console.log('==>ok');

			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType: 'json',
				success: function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						if ($('#id_fiche').val() == '0') {
							$.bootstrapGrowl('<h4>Confirmation!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client créé' : 'Customer created')?></p>', {
								type: 'success',
								delay: 5000,
								offset: {
								from: "top",
								amount: 100
									},
									align: "center",
								allow_dismiss: true
							});
							
							//remettre
							setTimeout(function() {
								window.location.href = 'fiche.php?id_fiche=' + resp.id_fiche;
							}, 1000);
						} else {
							$.bootstrapGrowl('<h4>Confirmation!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modification effectuée' : 'Updated')?></p>', {
								type: 'success',
								delay: 5000,
								offset: {
								from: "top",
								amount: 100
									},
									align: "center",
								allow_dismiss: true
							});
							setTimeout(function() {
								window.location.reload();
							}, 1000);

						}
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
				// error: function(jqXHR, textStatus){
				// 	console.log('NO',jqXHR, textStatus);
				// 	HoldOn.close();
				// }
			});
			return false;
		});

		$('#btaddrecall').click(function() {
			$('#modal-rappel').modal();
			return false;
		});

		$('#formulairerecall').submit(function() {
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType: 'json',
				success: function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('#tbclimsg-rap').append('<tr><td class="text-center"><i class="fa fa-calendar"></i> <?php echo date('d/m/Y H:i'); ?></td><td class="text-center"><i class="gi gi-alarm"></i> ' + resp.comment + '</td><td class="text-center"><div class="btn-group"><a href="#" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le rappel' : 'Delete the reminde')?>" class="btn btn-xs btn-danger btdelcomment" data-id="' + resp.id_comment + '"><i class="fa fa-trash"></i></a></div></td></tr>');
						$('#nbcomment').text((parseInt($('#nbcomment').text()) || 0) + 1);
						$("body").tooltip({
							selector: '[data-toggle="tooltip"]'
						});
						$('#modal-rappel').modal('hide');
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
				error: function() {
					HoldOn.close();
				}
			});
			return false;
		});

		$('.btadddocsec').click(function() {
			$('#formulairedoc').trigger("reset");
			$('#id_type_doc').val('');
			$('#id_type_doc').trigger('chosen:updated');
			// dz.removeAllFiles();
			$('#modal-updocument').modal();
			return false;
		});

		var dz;
		Dropzone.options.filedocs = {
			url: 'appajax.php',
			maxFiles:45,
			parallelUploads:45,
			maxFilesize:30,
			timeout: 600000,
			addRemoveLinks:true,
			thumbnailWidth:100,
			thumbnailHeight:100,
			autoProcessQueue: false,
			uploadMultiple: true,
			dictDefaultMessage:"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Cliquez ici pour ajouter des fichiers' : 'Click here for add files') ?>",
			init: function () {				
				this.autoDiscover = false;
				dz = this;
	
				this.on('sendingmultiple', function (data, xhr, formData) {
					formData.append("id_fiche", $("#id_fiche").val());
					formData.append("id_type_doc", $("#id_type_doc").val());
					formData.append("action", "upload-doc-type");
					$('#filedocs.dropzone .dz-progress').show();
                });
				
				this.on("successmultiple", function(file, txt) {
					
					HoldOn.close();
					var resp = JSON.parse(txt);
					if (resp.responseAjax == 'SUCCESS') {
						$('#list_fiches_docs').trigger("reloadGrid",[{current:true}]);
						// location.reload(true);
						$('#modal-updocument').modal('hide');						
					}
					else
					if (resp.responseAjax == 'ERROR')
						alert(resp.message);

					dz.removeAllFiles();
				});
								
				$('#btuploaddoc').click(function() {
					if ($('#id_type_doc').val() == '') {
						alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du type' : 'Choice of type') ?>');
						return false;
					}
					
					HoldOn.open();
					if (dz.files.length > 0) {
						for(var f in dz.files)
							dz.files[f].status = "queued";
						dz.processQueue();
					}
					else {
						alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun fichier ajouté' : 'No file uploaded') ?>');
						HoldOn.close();
					}
					
					dz.removeAllFiles();
					
					return false;
				});

			}
		};

		Dropzone.options.myAwesomeDropzone = {
			init: function() {
				this.on("success", function(file, txt) {
					var resp = JSON.parse(txt);
					if (resp.responseAjax == 'SUCCESS') {
						this.removeFile(file);
						$('#nbdoc').text((parseInt($('#nbdoc').text()) || 0) + 1);
						var str = '';
						if (resp.isimage == '1') {
							str += '<div class="col-sm-3 gallery-image"><img src="' + resp.filename + '" alt="image"><div class="gallery-image-options text-center"><div class="btn-group btn-group-sm">';
							str += '<a href="' + resp.filename + '" class="gallery-link btn btn-sm btn-alt btn-default" title="Zoom">Zoom</a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default deldoc" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer' : 'Delete') ?>" data-id="' + resp.id_doc + '"><i class="fa fa-trash"></i></a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default acceptdoc" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer' : 'Delete') ?>" data-id="' + resp.id_doc + '"><i class="fa fa-check"></i></a>';
							str += '</div></div></div>';
						} else {
							str += '<div class="col-sm-3 gallery-image gallery-file"><i class="hi hi-file"></i><br>' + resp.fl + '<div class="gallery-image-options text-center"><div class="btn-group btn-group-sm">';
							str += '<a href="' + resp.filename + '" target="new" class="btn btn-sm btn-alt btn-default" title="Zoom">Voir</a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default deldoc" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer' : 'Delete') ?>" data-id="' + resp.id_doc + '"><i class="fa fa-trash"></i></a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default acceptdoc" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?>" data-id="' + resp.id_doc + '"><i class="fa fa-check"></i></a>';
							str += '</div></div></div>';
						}
						$('#contentdocs .gallery .row').append(str);

						$('#list_fiches_docs').trigger("reloadGrid",[{current:true}]);
					}
				});
			}
		};

		$(document).on('click', '.deldoc', function() {
			if (confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le document' : 'Delete file') ?>')) {
				var obj = $(this);
				
				HoldOn.open();
				$.post('appajax.php', {
					action: 'delete-doc',
					iddoc: obj.attr('data-id')
				}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						obj.parents('.gallery-image').remove();
						$('#nbdoc').text(parseInt($('#nbdoc').text()) - 1);
						$('#list_fiches_docs').trigger("reloadGrid",[{current:true}]);
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
			}
			return false;
		});

		$(document).on('click', '.acceptdoc', function() {
			if (confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmez' : 'Confirm') ?>')) {
				var obj = $(this);
				HoldOn.open();
				$.post('appajax.php', {
					action: 'accept-doc',
					iddoc: obj.attr('data-id'),
					acceptdoc: obj.attr('data-accept')
				}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						obj.parents('.gallery-image').remove();
						
						$('#list_fiches_docs').trigger("reloadGrid",[{current:true}]);
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
			}
			return false;
		});

		$('#btupdatedir').click(function() {
			infotosubmit = false;
		});

		// $(document).on('click','.ui-icon-disk',function(){
		// 	HoldOn.open();
		// 	$.post('appajax.php', {action: 'XXXXX', id_fiche: $('#id_fiche').val()}, function(resp) {
		// 		if (resp.responseAjax == 'SUCCESS') {
		// 			$('#tot_hour_formation').val(resp.tothourform);
		// 		}
		// 		else
		// 			$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 				type: 'danger',
		// 				delay: 5000,
		// 				offset: {
		// 				from: "top",
		// 				amount: 100
		// 					},
		// 					align: "center",
		// 				allow_dismiss: true
		// 			});
				
		// 		HoldOn.close();

		// 	}, 'json');
				
		// 	return false;
			
		// })


		$('#formulairedetails').submit(function() {
			
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType: 'json',
				success: function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						
						$.bootstrapGrowl('<h4>Confirmation!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modification effectuée' : 'Updated')?></p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});


						$('#tot_global').val(Math.round(parseFloat($('#tot_ht').val())))
						$('#mt_fin').val(Math.round(resp.totreal));

						// console.log('tot_ht',parseFloat($('#tot_ht').val()), 'totreal',resp.totreal, 'tot_transp',parseFloat(resp.tot_transp))
						// $('#mt_fin').val((Math.round(parseFloat($('#tot_ht').val())) / ((100 - $('#offre_sejour').val()) / 100)) - $('#taxe_sejour').val());
						
						// $('#formulairect').submit();
						//remettre
						setTimeout(function() {
							console.log('134464646')
							window.location.href = 'fiche.php?id_fiche=' + resp.id_fiche;
						}, 1000);

					
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
				error: function() {
					HoldOn.close();
				}
			});

			return false;
		});

		// $('.btfac').click(function() {
		// 	var obj = $(this);
		// 	HoldOn.open();
		// 	$.post('appajax.php', {action: 'print-facture',datefac:$('#date_fac').val() , datedevis:$('#date_devis').val(), idct: $('#id_fiche').val(), cptStud: 0}, function(resp) {
		// 			if (resp.responseAjax == 'SUCCESS') {
		// 				console.log(resp)
		// 				if (resp.cansign == '1') {
		// 					$('#btsigndoc').removeClass('display-none');
		// 					curdoc = resp.iddoc;
		// 					namecurdoc = resp.namedoc;
		// 				}
		// 				else
		// 					$('#btsigndoc').addClass('display-none');


		// 				$('#modal-pdf iframe').attr('src', resp.doc);
		// 				$('#modal-pdf').modal();
		// 			}
		// 			else
		// 				$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
		// 					type: 'danger',
		// 					delay: 5000,
		// 					offset: {
		// 					from: "top",
		// 					amount: 100
		// 						},
		// 						align: "center",
		// 					allow_dismiss: true
		// 				});
					
		// 			HoldOn.close();

		// 		}, 'json');
		
		// 	return false;
		// });

		$('#btall').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'print-all', idct:<?php echo $_GET['id_fiche'] ?>, typedoc:'6'}, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {
					
					$('#modal-pdf iframe').attr('src', resp.doc);

					if (resp.id_doc > 0)
						$('#view_id_docs').val(resp.id_doc);
					else
						$('#view_id_docs').val('');
										
					getNameDoc(resp.doc);
					typeDocSign = 'de document complet';

					if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');


					$('#modal-pdf').modal();
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
		});

		$("#modal-msg-mail").on('hide.bs.modal', function () {
			$('.modeltype').show();
		});

		$("#modal-dispo-chambre").on('hide.bs.modal', function () {
			HoldOn.open();
			$.post('appajax.php', {
				action: 'reload-chambre',
				idct: $('#id_fiche').val(),
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
					
					$('#chReload').html(resp.htmlbody);
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
			HoldOn.close();
			// return false;
		});
		
		$(document).on('click','.clclosemod', function(){
			window.location.reload();
		})

		$("a[href='#tabs-local']").on('shown.bs.tab', function() {
			startGMap();
		});

		$('#btemailfiche').click(function() {
			
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

			$('#aff-stag').hide();
			$('#modal-msg-mail').modal();
			return false;			
		});

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
			

			HoldOn.open();
			$.post('appajax.php', {
				action: 'affiche-mailtype',
				id_mailtype: idmt,
				id_fiche : <?php echo $_GET['id_fiche']; ?>,
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
							$('#attacheddocs').html('<u><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pièces jointes' : 'Attach')?></u> : ' + JSON.parse(resp.data.attach).join(", "));
						else
							$('#attacheddocs').text('');
					}
					$('#id_mailtype').val(idmt);
					$('#attachclr').val('0');
				} else
					alert(resp.message);

				$('.tooltip.in').remove();
			}, 'json');	

			$('#btmtcont').dropdown("toggle");
			return false;
		});

		
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
				alert('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sélectionner les documents à joindre' : 'Select the documents to attach')?>');
				return false;
			}

			var docs = [];
			$('#lstdocsctt input:checked').each(function() {
				docs.push($(this).attr('data-id'));
			});

			return false;
		});	
		
		$('.readonly').find('input, textarea, select, ul, li').attr('disabled', 'disabled');

		$('#btsenddoc').click(function() {
			
			var mailType = $('#typeMail').val();
			
			HoldOn.open();
			//var tdoc = $('#curtypeord').val();
			jQuery('#formulairemsgdoc').ajaxSubmit({
				dataType:'json',
				data:{action:'send-mail-fiche-ct', idc:$('#id_fiche').val(), email:$('#destemail').val(), subject:$('#subjectmail').val(), msg:CKEDITOR.instances['msgcontent'].getData(), mailtypedest : mailType},
				success : function (resp) {	
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {					
						$.bootstrapGrowl('<h4>Confirmation!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Email envoyé' : 'Email sended')?></p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});
						
						$('#modal-msg-mail').modal('hide');
						$('#modal-pdf').modal('hide');
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

		// App.datatables();

		// /* Initialize Datatables */
		// $('#tbcliprox').dataTable({
		// 	pageLength: 10,
		// 	lengthMenu: [
		// 		[10, 20, 30, -1],
		// 		[10, 20, 30, 'All']
		// 	]
		// });

		$('.dataTables_filter input').attr('placeholder', 'Search');

		$('ul[data-toggle="tabs"] a').on('show.bs.tab', function(e) {
			localStorage.setItem('activeTab_<?php echo $_GET['id_fiche']; ?>', $(e.target).attr('href'));
		});

		var activeTab = localStorage.getItem('activeTab_<?php echo $_GET['id_fiche']; ?>');
		if (activeTab) {
			$('ul[data-toggle="tabs"] a[href="' + activeTab + '"]').tab('show');
		}

		function tarifSejour(){
			
			var d1 = $('#date_start').val().split('/');
			var d2 = $('#date_end').val().split('/');

			var date1 = new Date(d1[1]+'/'+d1[0]+'/'+d1[2]);
			
			var date2 = new Date(d2[1]+'/'+d2[0]+'/'+d2[2]);

			var Diff_temps = date2.getTime() - date1.getTime(); 
			var Diff_jours = Diff_temps / (1000 * 3600 * 24); 
			// alert("Le nombre de jours entre les deux dates est de " + Math.round(Diff_jours) + " jours"); 

			$('#tot_ht').val((parseInt($('#nb_adulte').val()) * parseFloat($('#tarif_adulte').val())) + (parseInt($('#nb_enfant').val()) * parseFloat($('#tarif_enfant').val())) + (parseInt($('#nb_bb').val()) * parseFloat($('#tarif_bb').val())) )
		}

		function getFloatVal(s) {
			return isNaN(parseFloat(s)) ? 0 : parseFloat(s);
		}


		$(document).on('click','.ui-icon-disk',function(e){
			$('#list_adultes').trigger("reloadGrid",[{current:true}]);
			$('#list_enfants').trigger("reloadGrid",[{current:true}]);
			$('#list_bb').trigger("reloadGrid",[{current:true}]);
		})

		$(document).on('click', "#btrib1, #btrib2, #btrib3, #btrib4, #btrib5", function(){
			if('<?php echo $curusr->lnk_contrat_signed <= 0 ?>' ){
				alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Le contrat n\'est pas revenu signé !\nEnvoi du RIB refusé' : 'The contract did not come back signed !\nSending of bank details refused') ?>")
				return false;
			}
			if('<?php echo $curusr->lnk_contrat_signed > 0 ?>' ){
				if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmer l\'envoi du RIB' : 'Confirm the sending of the bank details') ?>")){
					return false;
				}
			}
			// HoldOn.open();
			$.post('appajax.php', {action:'send-rib', idct:$('#id_fiche').val(), app:$(this).attr('id'), idbq:$(this).attr('data-id')}, function(resp){

				if (resp.responseAjax == "SUCCESS") {
					$.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
						type: 'success',
						delay: 5000,
						offset: {
						from: "top",
						amount: 100
							},
							align: "center",
						allow_dismiss: true
					});
				}else {
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
						
				HoldOn.close();
			}, 'json');
			return false
		})
		
		function initFields(){
			console.log('aa','<?php echo $curusr->tot_ht?>', $('#tot_ht').val(), $('#istotmanu').val(), ($('#tot_ht').attr('disabled') ? '1' : '0'))
			// HoldOn.open();
			$.post('appajax.php', {action:'list-rib'}, function(resp){
				if (resp.responseAjax == "SUCCESS") {
					
					$('#lstrib').html(resp.html)

				}else {
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
						
				HoldOn.close();
			}, 'json');
		

			$('#idsigned').hide()
			// $('#tel1').removeAttr('disabled', false)
			// $('#email').removeAttr('disabled', false)

			if(parseInt($('#nb_adulte').val()) > 0){
				$('#btaddadulte').show();
			}else{
				$('#btaddadulte').hide();
			}

			if(parseInt($('#nb_enfant').val()) > 0){
				$('#btaddenfant').show();
			}else{
				$('#btaddenfant').hide();
			}

			if(parseInt($('#nb_bb').val()) > 0){
				$('#btaddbb').show();
			}else{
				$('#btaddbb').hide();
			}

			if($('#id_status_sec').val() == '1'){
				$($('#civ_contact').attr('required',false))
				$($('#last_name').attr('required',false))
				$($('#email').attr('required',false))
				$($('#tel1').attr('required',false))
				$($('label span').text(''))
			}
		}

		$('#btinscription').click(function(){
			$.post('appajax.php', {action: 'print-inscription', idct: $('#id_fiche').val(), type:'I' }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					
					if (resp.iddoc > 0)
						$('#view_id_docs').val(resp.iddoc);
					else
						$('#view_id_docs').val('');

					if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');

					getNameDoc(resp.doc);
					typeDocSign = 'du Devis';


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

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

		$('#btdevis').click(function(){
			$.post('appajax.php', {action: 'print-devis', idct: $('#id_fiche').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					
					if (resp.iddoc > 0)
						$('#view_id_docs').val(resp.iddoc);
					else
						$('#view_id_docs').val('');

					if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');

					getNameDoc(resp.doc);
					typeDocSign = 'du Devis';


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

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

		$('#btfacture').click(function(){
			$('#mtfact').val($('#tot_ht').val())
			$('#modal-inf-facture').modal();
			return false
		})

		$('#btfrais').click(function(){
			// $('#mtfact').val($('#tot_ht').val())
			$('#modal-note-frais').modal();
			return false
		})

		$(document).on('click', '#btokfrais', function(){
			$('#modal-note-frais').modal('hide');

			// Récupérer le fichier sélectionné
			let formData = new FormData();
			formData.append('action', 'print-note-frais');
			formData.append('idct', $('#id_fiche').val());
			formData.append('mtfrais', $('#mtfrais').val());
			formData.append('catfrais', $('#catfrais option:selected').val());
			formData.append('datefrais', $('#date_frais').val());
			formData.append('descfrais', $('#descfrais').val());
			formData.append('lg', $('#lgfrais').val());

			// Ajouter le fichier s'il est sélectionné
			var justificatif = $('#justificatif')[0].files[0]; 
			if (justificatif) {
				formData.append('justif', justificatif);
			}
			
			HoldOn.open();
			$.ajax({
					url: 'appajax.php',
					type: 'POST',
					data: formData,
					contentType: false, 
					processData: false,  // Indispensable pour envoyer un fichier
					dataType: 'json',
					success: function(resp) {
					HoldOn.close();
					if (resp.responseAjax === "SUCCESS") {
						if (resp.iddoc > 0)
							$('#view_id_docs').val(resp.iddoc);
						else
							$('#view_id_docs').val('');

						if (resp.cansign === '1')
							$('#blksigndoc').removeClass('display-none');
						else
							$('#blksigndoc').addClass('display-none');

						getNameDoc(resp.doc);
						typeDocSign = 'de la facture';

						$('#modal-pdf iframe').attr('src', resp.doc);
						$('#modal-pdf').modal();
					} else {
						$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
							type: 'danger',
							delay: 5000,
							offset: { from: "top", amount: 100 },
							align: "center",
							allow_dismiss: true
						});
					}
				},
				error: function() {
					HoldOn.close();
					alert('Erreur lors de l\'envoi des données.');
				}
			});
				
			HoldOn.close();
			return false;
		})

		$(document).on('click', '#btokfacture', function(){
			$('#modal-inf-facture').modal('hide');
			HoldOn.open();
			$.post('appajax.php', {action: 'print-fact-libre', 
					idct: $('#id_fiche').val(),
					tvafact: $('#tvafact').val(),
					infbq: $('#bqfact option:selected').val(),
					datefac:$('#date_fac').val(),
					descfact:$('#descfact').val(),
					lg:$('#lgfact').val()}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					HoldOn.close();
					if (resp.iddoc > 0)
						$('#view_id_docs').val(resp.iddoc);
					else
						$('#view_id_docs').val('');

					if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');

					getNameDoc(resp.doc);
					typeDocSign = 'de la facture';


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

				}
				else {
					HoldOn.close();
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
		

		$('#btcontrat').click(function(){
			$.post('appajax.php', {action: 'print-contrat', idct: $('#id_fiche').val(), type:'C' }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					
					if (resp.iddoc > 0)
						$('#view_id_docs').val(resp.iddoc);
					else
						$('#view_id_docs').val('');

					if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');

					getNameDoc(resp.doc);
					typeDocSign = 'du Devis';


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();

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
		
		$(document).on('click','#btannule, .btannule',function(){
			// if($(this).attr('data-ct') == 0){
			// 	alert('Vous n\'ete pas autorisé a annuler ce rendez-vous')
			// 	return false;
			// }
			if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmer l\'annulation complette et la libération des chambres' : 'Confirm full reset and handover available rooms') ?>")){
				return false
			}
			$.post('appajax.php', {action:'valide-annule-fiche', idct: $('#id_fiche').val()}, 
				function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						$.bootstrapGrowl('<h4>Confirmation !</h4> <p>' + resp.message + '</p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});
						window.location.reload();
						
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
					HoldOn.close();
				}, 'json');	
			return false;

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

		$('#formulaireaddcomment').submit(function() {
			
			if ($('#comment').val() == '') {
				$.bootstrapGrowl('<h4>Erreur!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Indiquer le message à ajouter' : 'Write the message to add')?></p>', {
					type: 'danger',
					delay: 5000,
					offset: {
					from: "top",
					amount: 100
						},
						align: "center",
					allow_dismiss: true
				});
				return false;
			}			

			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType: 'json',
				data:{type_comment: '0'},
				success: function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						$('#tbclimsg').append('<tr><td class="text-center"><i class="fa fa-calendar"></i> <?php echo date('d/m/Y H:i'); ?></td><td class="text-center">' + resp.inits + ' : ' + $('#comment').val() + '</td><td class="text-center"><div class="btn-group"><a href="#" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le commentaire' : 'Delete comment') ?>" class="btn btn-xs btn-danger btdelcomment" data-id="' + resp.id_comment + '"><i class="fa fa-trash"></i></a></div></td></tr>');
						$('#nbcomment').text((parseInt($('#nbcomment').text()) || 0) + 1);
						$('#comment').val('');
						$("body").tooltip({
							selector: '[data-toggle="tooltip"]'
						});
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

		$(document).on('click', '.btdelcomment', function() {
			let typeComment = ($(this).attr('data-type'))
			let detMsg = '';
			if(typeComment == '0'){
				detMsg = '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le commentaire ?' : 'Delete comment ?') ?>'
			}else{
				detMsg = '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le rappel ?' : 'Delete reminde ?') ?>'
			}
			
			if (confirm(detMsg)) {
				var obj = $(this);
				HoldOn.open();
				$.post('appajax.php', {
					action: 'delete-comment',
					id_comment: obj.attr('data-id')
				}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						obj.parents('tr').remove();
						$('#nbcomment').text((parseInt($('#nbcomment').text()) || 0) - 1);
					} else
						$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
							type: 'danger',
							delay: 2500,
							allow_dismiss: true
						});

					$('.tooltip.in').remove();
				}, 'json');
			}

			return false;
		});


		$('#btcgv').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'print-cgv', idc:<?php echo $_GET['id_fiche'] ?>, typedoc:'21'}, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {
					
					$('#modal-pdf iframe').attr('src', resp.doc);

					
					getNameDoc(resp.doc);
					typeDocSign = 'de CGV';

					if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');


					$('#modal-pdf').modal();
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
		});
	});
</script>

