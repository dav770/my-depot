<?php include 'including/config.php'; ?>
<?php
if (!isset($_GET['id_contact']))
	header('Location: contacts.php');

$outdocs = '';
if ($_GET['id_contact'] == '0')
	$curusr = false;
else {

	$curusr = Contact::findOne(array('c.id_contact' => (int)$_GET['id_contact']));
	if ($curusr) {
		// if (!Contact::checkRight($curusr)){
		// 	header('Location: contacts.php');
		// }
		
		if ($arrAccess['isAdmin'] != '1' && $arrAccess['visu_client'] != '1'){
			
			header('Location: contacts.php');
		}
		$outdocs = Grid4PHP::getGrid('db_contacts_docs', (int)$_GET['id_contact']);
		
	} else{
		
		header('Location: contacts.php');
	}
}

// $tarifadulte = Tarif::findOne()
// $tarifenfant
// $tarifbb

// echo ($arrAccess['isAdmin'] != '1' && $arrAccess['send_doc_fiche_client'] != '1' ? print_r($arrAccess) : 'btlnkdevis' );


$comments = Comment::getBy('id_contact = '.(int)$_GET['id_contact'].' AND type_comment IN (0, 1)');
// $commentsplans = Comment::getBy('id_contact = '.(int)$_GET['id_contact'].' AND type_comment IN (2, 3)');
$docs = Doc::getBy(array('id_contact' => (int)$_GET['id_contact']));
$mtypes = MailType::find("");
$stypes = SMSType::find("");
$affStagiaireMail = false;

$outdetails = Grid4PHP::getGrid('db_contacts_details', $_GET['id_contact'], $curusr->last_name);

$outch = QueryType::query('db_contacts_chambres', '*', array('id_contact'=>$_GET['id_contact']));

$devises = Setting::getAllDevises();


?>

<?php include 'including/headPage.php'; ?>



<!-- <script src="jscript/one.js"></script> -->

<?php /*
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
*/?>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<style>

@import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

*:focus,
*:active {
  outline: none !important;
  -webkit-tap-highlight-color: transparent;
}
/* 
html,
body {
  display: grid;
  height: 100%;
  width: 100%;
  font-family: "Poppins", sans-serif;
  place-items: center;
  background: linear-gradient(315deg, #ffffff, #d7e1ec);
} */

.wrapper {
  display: inline-flex;
  list-style: none;
}

@media screen and (max-width:786px) {
    .wrapper{
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
	}
}

.wrapper .icon {
  position: relative;
  background: #ffffff;
  border-radius: 50%;
  padding: 15px;
  margin: 10px;
  width: 100px;
  height: 100px;
  font-size: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.wrapper .tooltip {
  text-align:center;
  position: absolute;
  top: 0;
  font-size: 14px;
  background: #ffffff;
  color: #ffffff;
  padding: 5px 8px;
  border-radius: 5px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
  opacity: 0;
  pointer-events: none;
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.wrapper .tooltip::before {
  position: absolute;
  content: "";
  height: 8px;
  width: 8px;
  background: #ffffff;
  bottom: -3px;
  left: 50%;
  transform: translate(-50%) rotate(45deg);
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  z-index: 1;
}


.wrapper .icon:hover .tooltip {
  top: -45px;
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

.wrapper .icon:hover span,
.wrapper .icon:hover .tooltip {
  text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
}

.wrapper .calendar:hover,
.wrapper .calendar:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .calendar:hover .tooltip::before {
  background: #1877F2;
  color: #ffffff;
}

.wrapper .clients:hover,
.wrapper .clients:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .clients:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}

.wrapper .calch:hover,
.wrapper .calch:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .calch:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}

.wrapper .inbox:hover,
.wrapper .inbox:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .inbox:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}

.wrapper .outbox:hover,
.wrapper .outbox:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}

.wrapper .outbox:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}

.wrapper .stripe:hover,
.wrapper .stripe:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .stripe:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}

.wrapper .set:hover,
.wrapper .set:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .set:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}

.wrapper .usr:hover,
.wrapper .usr:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .usr:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}

.wrapper .clcmds:hover,
.wrapper .clcmds:hover .tooltip,
.wrapper .active {
  background: #DFCA55;
  color: #ffffff;
}
.wrapper .clcmds:hover .tooltip::before {
  background: #1DA1F2;
  color: #ffffff;
}
	/*  */
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

</style>
<!-- Page content -->
<div id="page-content" class="page-contact">
	<!-- eCommerce Dashboard Header -->
	<div class="content-header">
		<?php include('including/mainmenu-test.php'); ?>
		
		
	</div>
	<!-- END eCommerce Dashboard Header -->

	<!-- eShop Overview Block -->
	
	<div class="block full row" >
		<!-- eShop Overview Title -->
		<div class="row">
			<div class="col-lg-12">
				<!-- Normal Form Title -->
				<div class="block-title">
					<span class="label label-info" style="height: 35px;display: block;padding-top: 10px;font-size: large;">N° CLIENT. : <?php echo ($curusr ? $curusr->id_contact : 0); ?></span>
					<h2><strong>Informations</strong> <?php echo ($curusr->is_customer == 1 ? 'Client' : 'Leads')?></h2>
					<?php if ($curusr) { ?>
						<div class="block-options pull-right">								
							<a href="#" class="btn btn-sm btn-info fa-5 fa-3dicon" id="btemailfiche" style="margin-right:5px;border-radius:3px;" title="Envoi Email" data-toggle="tooltip"><i class="fa fa-envelope-o" <?php echo ($arrAccess['send_mail_client'] != '1' ? 'disabled="disabled"' : '' ) ?>></i></a>
							
							<?php if($arrAccess['isAdmin'] == '1' || $arrAccess['send_mail_client'] == '1' ) { ?>
								<a href="#" class="btn btn-sm btn-warning btsmspres fa-5 fa-3dicon" title="Envoyer un SMS" data-toggle="tooltip" style="margin-right: 5px;border-radius:3px;"><i class="fa fa-send" <?php echo ($arrAccess['send_sms_client'] != '1' ? 'disabled="disabled"' : '' ) ?>></i></a>
							<?php } ?>
							
						</div>
					<?php } ?>
					<?php if($arrAccess['imp_doc_fiche_client'] == '1') {?>
						<div class="btn-group btn-group-sm">
							<a href="#" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false" ><i class="fa fa-print"></i> Impression Doc.<span class="caret"></span></a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li>
										<a href="#" class="" id="btall">Document complet</a>
									</li>
									<li>
										<a href="#" class="" id="btcgv">CGV</a>
									</li>
									<li>
										<a href="#" class="" id="btdevis">devis</a>
									</li>
									<li>
										<a href="#" class="" id="btfacture">Facture</a>
									</li>
									<li>
										<a href="#" class="" id="btcontrat">Contrat</a>
									</li>
								</ul>
						</div>
					<?php }?>
					<?php if($arrAccess['annule_fiche_client'] == '1') { ?>
						<a href="#" class="btn btn-sm btn-danger" id="btannule">Annulation dossier</a>
					<?php } ?>
				</div>
				<!-- END Normal Form Title -->
				<div class="block">
					

					<form onsubmit="return false;" class="form-horizontal" method="post" action="appajax.php" id="formulairect">
						<fieldset>	
							
							<div class="form-group" style="border-bottom: solid 3px #ccc;margin-bottom: 10px;">
								<label for="id_organisateur" class="col-md-3 control-label">Séjour</label>
								<div class="col-md-9">
									<select data-placeholder="Choisissez le séjour..." class="form-control select-chosen" id="id_organisateur" name="id_organisateur" readonly>
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
								<label for="id_status_sec" class="col-md-3 control-label">Etat dossier</label>
								<div class="col-md-9">
									<select data-placeholder="Choisissez l'etat du dossier" class="form-control select-chosen" id="id_status_sec" name="id_status_sec" <?php echo $arrAccess['change_statut_client'] != '1' ? 'readonly="readonly"' : ''; ?>>
										<option value=""></option>
										<?php
										$sts = Setting::getAllStatusConf();
										if ($sts) {
											foreach ($sts as $st) {
												$issel = $curusr ? ($st['id_status_sec'] == $curusr->id_status_sec ? 'selected="selected"' : '') : (strstr($st['name_status_sec'], 'Nouveau') ? 'selected="selected"' : '');
												echo '<option value="' . $st['id_status_sec'] . '" ' . $issel . '>' . $st['name_status_sec'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							
							
							<div class="form-group" >
								<label for="civ_contact" class="col-md-3 control-label">Civilité</label>
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
								<label for="first_name" class="col-md-3 control-label">Prénom contact </label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez le prénom..." class="form-control" name="first_name" id="first_name" value="<?php echo ucfirst($curusr->first_name); ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="last_name" class="col-md-3 control-label">Nom contact <span class="text-danger">*</span></label>
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
							<div class="form-group iscli">
								<label for="date_birth" class="col-md-3 control-label">Date naissance </label>
								<div class="col-md-9">
									<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_birth" id="date_birth" value="<?php echo $curusr->date_birth > 0 ? date('d/m/Y', strtotime($curusr->date_birth)) : ''; ?>"  >
								</div>
                            </div>
                            		
						</fieldset>
						
							<div class="form-group">
								<label for="tel1" class="col-md-3 control-label">Tél principal <span class="text-danger">*</span></label>
								<div class="col-md-8">
									<input type="text" placeholder="Saisissez le téléphone principal..." class="form-control" name="tel1" id="tel1" value="<?php echo $curusr->tel1; ?>" required >
								</div>
								<button class="btn btn-sm btn-primary" title="Inversez les Tèl." id="btreversetel" type="button"><i class="fa fa-exchange"></i></button>
							</div>
							<div class="form-group">
								<label for="tel2" class="col-md-3 control-label">Tél secondaire </label>
								<div class="col-md-9">
									<input type="text" placeholder="Téléphone supplementaire..." class="form-control" name="tel2" id="tel2" value="<?php echo $curusr->tel2; ?>" >
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Email <span class="text-danger">*</span></label>
								<div class="col-md-9">
									<input type="email" placeholder="Saisissez l'adresse email..." class="form-control" name="email" id="email" value="<?php echo $curusr->email; ?>" required  >
								</div>
							</div>
						<fieldset <?php echo $zonetodis ? 'disabled="disabled"' : ''; ?>>
                            <div class="form-group">
								<label for="country" class="col-md-3 control-label">Pays </label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez le pays..." class="form-control" name="country" id="country" value="<?php echo $curusr->country; ?>" >
								</div>
							</div>	
                            			
										
							<div class="form-group">
								<label for="adr1" class="col-md-3 control-label">Adresse <span class="text-danger">*</span></label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez l'adresse..." class="form-control" name="adr1" id="adr1" value="<?php echo $curusr->adr1; ?>"  >
								</div>
							</div>
							<div class="form-group">
								<label for="adr2" class="col-md-3 control-label">Compl. adresse</label>
								<div class="col-md-9">
									<input type="text" placeholder="Complément d'adresse..." class="form-control" name="adr2" id="adr2" value="<?php echo $curusr->adr2; ?>"  >
								</div>
							</div>
							<div class="form-group">
								<label for="post_code" class="col-md-3 control-label">Code postal <span class="text-danger">*</span></label>
								<div class="col-md-6">
									<input type="text" placeholder="Saisissez le code postal..." class="form-control" name="post_code" id="post_code" value="<?php echo $curusr->post_code; ?>" >
								</div>
							</div>
							<div class="form-group">
								<label for="city" class="col-md-3 control-label">Ville <span class="text-danger">*</span></label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez la ville..." class="form-control" name="city" id="city" value="<?php echo $curusr->city; ?>" >
								</div>
							</div> 

							<div style="border-bottom: solid 3px #ccc;margin-bottom: 10px;margin-left: 35px; margin-top: 35px;color:red">
								Informations de facturation
							</div>
							<div class="form-group" >
								<label for="raison_sociale" class="col-md-3 control-label">Raison Sociale</label>
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
								<label for="adr_facture" class="col-md-3 control-label">Adresse de facturation</label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="adr_facture" id="adr_facture" value="<?php echo $curusr->adr_facture; ?>" >
								</div>
							</div>
							<div class="form-group" >
								<label for="city_facture" class="col-md-3 control-label">Ville de facturation</label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="city_facture" id="city_facture" value="<?php echo $curusr->city_facture; ?>" >
								</div>
							</div>
							<div class="form-group" >
								<label for="post_code_facture" class="col-md-3 control-label">CP de facturation</label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="post_code_facture" id="post_code_facture" value="<?php echo $curusr->post_code_facture; ?>" >
								</div>
							</div>
							<div class="form-group" >
								<label for="country_facture" class="col-md-3 control-label">Pays de facturation</label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez le nom à facturer..." class="form-control" name="country_facture" id="country_facture" value="<?php echo $curusr->country_facture; ?>" >
								</div>
							</div>
							
							<div class="form-group">
								<label for="id_usrApp" class="col-md-3 control-label">Utilisateur</label>
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
								
							<div class="form-group <?php echo $arrAccess['isAdmin'] == '1' ? '' : 'display-none' ?>">
								<label for="source" class="col-md-3 control-label">Source</label>
								<div class="col-md-9">
									<input type="text" placeholder="Saisissez la source..." class="form-control " name="source" id="source" value="<?php echo $curusr->source; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label for="annee" class="col-md-3 control-label">Année</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="annee" id="annee" value="<?php echo $curusr->annee; ?>" readonly="readonly">
								</div>
							</div>
							<div class="form-group">
								<label for="date_create" class="col-md-3 control-label">Date création</label>
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
							
							<input type="hidden" id="infoprofil" value="<?php echo $usrActif->id_profil ?>" />
							<input type="hidden" name="isadminconnect" id="isadminconnect" value="<?php echo $arrAccess['isAdmin'] = '1' ? '1' : '0'; ?>" />
							<!-- <input type="hidden" name="date_birth" id="date_birth" value="" /> -->
							<input type="hidden" name="action" id="action" value="maj-fiche" />
							<input type="hidden" name="id_contact" id="id_contact" value="<?php echo $_GET['id_contact']; ?>" />
							<input type="hidden" id="iscustomer" value="<?php echo $curusr->is_customer ?>" />
							<!-- END Normal Form Content -->
							<?php if (!$curusr) { ?>
								<div class="form-group form-actions" <?php echo ($arrAccess['modif_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>>
									<button class="btn btn-sm btn-primary" type="submit" id="btupdatect"><i class="fa fa-user"></i> Valider</button>
									<button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Annuler</button>
								</div>
							<?php } ?>
						</fieldset>	
					</form>
				</div>

				<?php if ($curusr) { ?>
					<div class="row">
						<div class="icon-tab col-xs-12 col-sm-2 col-sm-offset-3 active">
							<span class="glyphicon glyphicon-folder-open"></span>
							<span class="icon-label">Dossier</span>
						</div>
						<div class="icon-tab col-xs-12 col-sm-2 ">
							<span class="glyphicon glyphicon-comment"></span>
							<span class="icon-label">Notes</span>
						</div>
						<div class="icon-tab col-xs-12 col-sm-2">
							<span class="glyphicon glyphicon-file"></span>
							<span class="icon-label">Documents</span>
						</div>
					</div>
					<div class="tab-content">
						<div class="item">
    						<div class="panel panel-default">
								
							<h2><strong>Informations</strong> client</h2>
								<div class="block">
									<div class="block-title">		
										<div class="block-options pull-right">
										</div>	
										<div class="block-options pull-left">	
											
											<legend class="display-none">
												<div class="" style="">
													<div class="block-options">
														<div class="pull-right">
															<span class="" style=";padding-right:50px">Code confidentiel : <em class="badge" style="background-color:red;color:black" id="cdcf"><?php echo $curusr->codekey.$curusr->id_contact ?></em></span>
														</div>
														
													</div>
												</div>	
											</legend>
										</div>	
									</div>
									<!-- END Normal Form Title -->

									<form onsubmit="return false;" class="form-bordered form-horizontal" method="post" action="appajax.php" id="formulairedetails" style="margin-top: 0px;">
										<fieldset>	
											<div class="form-group">
												<div class="col-md-3">
													<label class="switch switch-primary">
														<input type="checkbox" id="handicap" name="handicap" <?php echo $curusr && $curusr->handicap > 0 ? 'checked="true"' : ''; ?>><span></span>
													</label> Situation d'handicap
												</div>
												<div class="col-md-6">
													<label class="switch switch-primary">
														<textarea placeholder="Infos handicap.." class="form-control" name="comment_handicap" id="comment_handicap" style="width:826px;height: 64px;"><?php echo $curusr->comment_handicap ?></textarea>
												</div>
												
												<div class="col-md-3">
													<label for="date_contrat" class="control-label">Date de contrat</label>
													<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy"  name="date_contrat" id="date_contrat" value="<?php echo strtotime($curusr->date_contrat) > 0 ? date('d/m/Y', strtotime($curusr->date_contrat)) : ''; ?>" disabled="disabled">
												</div>
											
											</div>
											<div class="form-group">
												<div class="col-md-3">
													<label for="date_start" class="control-label">Date de début</label>
													<input type="text" style="background-color:#c1eaf7" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_start" id="date_start" value="<?php echo $curusr->date_start > 0 ? date('d/m/Y', strtotime($curusr->date_start)) : ''; ?>">
												</div>																							
												<div class="col-md-3">
													<label for="time_start" class="control-label">heure d'arrivée</label>
													<input type="time" style="background-color:#c1eaf7" class="form-control "  name="time_start" id="time_start" value="<?php echo $curusr->time_start ?>" >
												</div>																							
												<div class="col-md-3">
													<label for="date_end" class="control-label">Date de fin</label>
													<input type="text"  style="background-color:#f7e8c1" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_end" id="date_end" value="<?php echo $curusr->date_end > 0 ? date('d/m/Y', strtotime($curusr->date_end)) : ''; ?>">
												</div>
												<div class="col-md-3">
													<label for="time_end" class="control-label">heure de départ</label>
													<input type="time" style="background-color:#f7e8c1" class="form-control "  name="time_end" id="time_end" value="<?php echo $curusr->time_end ?>" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-3">
													Liste des personnes											
												</div>
												<!-- <div class="col-md-3">
													<label for="nb_adulte" class="control-label">Nombre Adulte(s)</label>
													<input type="text" class="form-control" name="nb_adulte" id="nb_adulte" value="<?php echo $curusr->nb_adulte > 0 ? $curusr->nb_adulte : ''; ?>" required>
												</div>	 -->
												<!-- <div class="col-md-3">	
													<a href="#"  style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;width: 98px;" class="form-control btn btn-sm btn-success btaddadulte" id="btaddadulte">Ajoutez Infos</a>
												</div> -->
											</div>
											<div class="form-group <?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												<div id="contentadulte" class="table-responsive col-md-12">
													<?php echo $outdetails ?>
												</div>
											</div>								

											<div class="form-group <?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												
												<div class="col-md-3">	
													<a href="#"  style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-warning btdispoch" id="idbtdispoch">Recherche des disponibilités</a> 
												</div>
												
												<div id="" class="col-md-6">
													<table id="listeCh" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
														<thead>
															<tr>
																<th>
																	N° chambre 
																</th>
																<th> 
																	Actions 
																</th>
															</tr>
														</thead>
														<tbody>
														<?php foreach($outch as $ch){
															echo '<tr>
																	<td>
																		<span class="columnClass">'.$ch['num_chambre'].'</span>
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
														
											<div class="row">
												<div class="col">
													<div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
														<div class="step0 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003"> -->
															<div class="timeline-content <?php echo $curusr->lnk_devis > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="Devis envoyé" data-original-title="">
																<div id="<?php echo ($arrAccess['send_doc_fiche_client'] != '1' ? '' : 'btlnkdevis' ) ?>" class="tooltip-circle pointer <?php echo $curusr->lnk_devis > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"><span class="tooltiptext">envoi du devis en signature pour passer au contrat</span></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_devis > 0 ? 'text-primary' : 'text-muted' ?>" >Devis envoyé</p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt0" style="font-weight: bold;"><?php echo $curusr->notProcessedDate ?></p> -->
															</div>
														</div>
														<div class="step1 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004"> -->
															<div class="timeline-content <?php echo $curusr->lnk_devis_signed > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="Devis signé?" data-original-title="">
																<div class="<?php echo $curusr->lnk_devis_signed > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_devis_signed > 0 ? 'text-primary' : 'text-muted' ?>" >Devis signé</p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt1" style="font-weight: bold;"><?php echo $curusr->validatedDate ?></p> -->
															</div>
														</div>
														<div class="step2 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005"> -->
															<div class="timeline-content <?php echo $curusr->lnk_contrat_signed > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="Contrat signé (électronique)" data-original-title="">
																<div class="<?php echo $curusr->lnk_contrat_signed > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_contrat_signed > 0 ? 'text-primary' : 'text-muted' ?>" >Contrat signé (électronique)</p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt2" style="font-weight: bold;"><?php echo $curusr->acceptedDate ?></p> -->
															</div>
														</div>
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
															<div class="timeline-content <?php echo $curusr->lnk_reglement > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="Règlement complet" data-original-title="">
																<div class="btreadpay tooltip-circle pointer <?php echo $curusr->lnk_reglement > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"><span class="tooltiptext">Voir les règlements</span></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_reglement > 0 ? 'text-primary' : 'text-muted' ?>" >Règlement complet</p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt4" style="font-weight: bold;"><?php echo $curusr->terminatedDate ?></p> -->
															</div>
														</div>
														<div class="step5 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010"> -->
															<div class="timeline-content <?php echo $curusr->lnk_facture > 0 ? 'time-lnk' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="Facturé" data-original-title="">
																<div id="<?php echo ($arrAccess['send_doc_fiche_client'] != '1' ? '' : 'btlnkfac' ) ?>" class="tooltip-circle pointer <?php echo $curusr->lnk_facture > 0 ? 'inner-circle' : 'inner-circle-fad' ?>"></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_facture > 0 ? 'text-primary' : 'text-muted' ?>" >Facturé</p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt5" style="font-weight: bold;"><?php echo $curusr->lnk_facture ?></p> -->
															</div>
														</div>
														<div class="step6 timeline-step">
															<!-- <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010"> -->
															<div class="timeline-content <?php echo $curusr->lnk_annule > 0 ? 'time-lnk-annule' : '' ?>"  data-trigger="hover" data-placement="top" title="" data-content="Annulé" data-original-title="">
															<div id="" class="tooltip-circle pointer <?php echo ($arrAccess['annule_fiche_client'] != '1' ? '' : 'btannule' ) ?>  <?php echo $curusr->lnk_annule > 0 ? 'inner-circle-red' : 'inner-circle-red-fad' ?>"></div>
																<p class="h6 mt-3 mb-1 <?php echo $curusr->lnk_annule > 0 ? 'text-primary' : 'text-muted' ?>" >Annulé</p>
																<!-- <p class="h6 text-muted mb-0 mb-lg-0" id="dt6" style="font-weight: bold;"><?php echo $curusr->serviceDoneValidatedDate ?></p> -->
															</div>
														</div>
														
													</div>
												</div>
											</div>	
											<div class="<?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												<div class="form-group">
													<legend>
														<i class="gi gi-money text-primary"></i>
														Informations Paiement
													</legend>
												</div>
												<div class="form-group">
													<!-- <div class="<?php echo ($arrAccess['modif_fiche_client'] != '1' ? 'display-none' : '' ) ?>">
														<div class="col-md-3">	
															<a href="index-stripe.php?idct=<?php echo $curusr->id_contact ?>&key=<?php echo $curusr->codekey.$curusr->id_contact ?>"  target="_blank" style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-info btpay" id="idbtpay">Paiement en ligne direct</a> 
														</div>
														<div class="col-md-3">	
															<a href="#"  target="_blank" style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-warning btpaylnk" id="idbtpaylnk">envoi lien paiement en ligne</a> 
														</div>
													</div> -->
													<div id="lstrib">

													</div>
												</div>
											</div>
											<div class="<?php echo ((int)strtotime($curusr->date_start) > 0 && (int)strtotime($curusr->date_end) > 0 ? '' : 'display-none') ?>">
												<div class="form-group">
													<legend>
														<i class="gi gi-money text-primary"></i>
														Informations de Facturation
													</legend>
												</div>
												<div class="form-group">
													<div class="col-md-3" >
														<label for="numdevis" class="control-label">Numéro de devis </label>
														<input type="text" class="form-control" name="numdevis" id="numdevis" value="<?php echo $curusr->numdevis; ?>" readonly>
													</div>

													<div class="col-md-3">
														<label for="date_devis" class="control-label">Date de devis </label>
														<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_devis" id="date_devis" value="<?php echo $curusr->date_devis > 0 ? date('d/m/Y', strtotime($curusr->date_devis)) : ''; ?>" readonly>
													</div>
													<div class="col-md-3">
														<label for="seldevises" class="control-label">Devise en cours pour ce client</label>
														<select id="seldevises" name="seldevises" class="form-control" style="background-color: black;color: yellow;">
															<?php foreach($devises as $devise){
																echo '<option value="'.$devise['code_devise'].'" '.($devise['code_devise'] == $curusr->code_devise ? 'style="background-color: #f70606;" selected' : ($curusr->code_devise == '' && $devise['code_devise'] == 'EUR' ? 'style="background-color: #f70606;" selected' : '')).'>'.$devise['name_devise'].' - '.$devise['code_devise'].'</option>';
															} ?>
														</select>
														
													</div>
													<div class="col-md-3">
														<button class="btn btn-sm btn-primary" type="button" id="btvalidedevise" style="margin-top: 37px;" <?php echo ($arrAccess['modif_devise_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-user"></i> Appliquez la devise choisie</button>
													</div>
													
												</div>
												<div class="form-group">
													<div class="col-md-3" >
														<label for="numfac" class="control-label">Numéro de facture </label>
														<input type="text" class="form-control" name="numfac" id="numfac" value="<?php echo $curusr->numfac; ?>" readonly>
													</div>

													
													<div class="col-md-3">
														<label for="date_fac" class="control-label">Date de facturation </label>
														<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_fac" id="date_fac" value="<?php echo $curusr->date_fac > 0 ? date('d/m/Y', strtotime($curusr->date_fac)) : ''; ?>" readonly>
													</div>
													
													<div class="col-md-3" >
														<label for="date_fac_send" class="control-label">Date de reglement</label>
														<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_fac_send" id="date_fac_send" value="<?php echo $curusr->date_fac_send > 0 ? date('d/m/Y', strtotime($curusr->date_fac_send)) : ''; ?>">
													</div>
												</div>
												<div class="form-group">
													
													<div class="col-md-3 display-none" >
														<label for="accompte_25" class="control-label">Acompte de 25%</label>
														<input type="text" class="form-control" name="accompte_25" id="accompte_25" value="<?php echo $curusr->accompte_25; ?>">
													</div>				
													<div class="col-md-3 display-none" >
														<label for="date_acompte" class="control-label">Date acompte</label>
														<input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy"  name="date_acompte" id="date_acompte" value="<?php echo strtotime($curusr->date_acompte) > 0 ? date('d/m/Y', strtotime($curusr->date_acompte)) : ''; ?>">
													</div>				
																		
													
													<div class="col-md-3">
														<label for="tot_ht" class="control-label">Montant facturé</label>
														<input type="text" class="form-control" name="tot_ht" id="tot_ht" value="<?php echo $curusr->tot_ht; ?>">
													</div>
													
													<div class="col-md-3">
														<label for="offre_sejour" class="control-label">remise %</label>
														<input type="text" class="form-control" name="offre_sejour" id="offre_sejour" value="<?php echo $curusr->offre_sejour; ?>">
													</div>
													
													<div class="col-md-3 display-none">
														<label for="mt_ok_ht" class="control-label">Montant restant</label>
														<input type="text" class="form-control" name="mt_ok_ht" id="mt_ok_ht" value="<?php echo $curusr->mt_ok_ht; ?>">
													</div>
													
												</div>
											</div>
											<fieldset <?php echo ($arrAccess['modif_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>>
												<input type="hidden" name="action" id="action" value="global-update" />
												<input type="hidden" name="id_contact" id="id_contact" value="<?php echo $_GET['id_contact']; ?>" />
												<input type="hidden" name="codedevisect" id="codedevisect" value="<?php echo ($curusr->code_devise == '' ? 'EUR' : $curusr->code_devise); ?>" />
												<div class="form-actions">
													<button class="btn btn-sm btn-primary" type="submit" id="btupdatedir"><i class="fa fa-user"></i> Valider</button>
													<button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Annuler</button>
												</div>
											</fieldset>
										</fieldset>
									</form>
									
								</div>
							</div>
						</div>

						<!-- <div id="tabs-coment" class="tab-pane"> -->
						<div class="item">
    						<div class="panel panel-default">
								<div class="block">
									<div class="block-title">
										<h2><strong>Commentaires & Rappels</strong></h2>
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
																<br><i class="fa fa-user"></i> <em> par <?php echo $comment['user_name']; ?></em>
															<?php } ?>
														</td>
														<td class="text-center" style="<?php echo $comment['type_comment'] == '1' ? 'box-shadow: -5px -5px 10px; background-color:#e8a71a;color:#45618f' : 'box-shadow: -5px -5px 10px; background-color:#8ad1ed;color:#000'?>"><?php echo $comment['type_comment'] == '1' ? '<i class="gi gi-alarm"></i>' . $comment['text_comment'] : $comment['text_comment']; ?></td>
														<td class="text-center">														
															<div class="btn-group">
																<a href="#" data-toggle="tooltip" title="Supprimer le <?php echo $comment['type_comment'] == '0' ? 'commentaire' : 'rappel'; ?>" class="btn btn-xs btn-danger btdelcomment" data-id="<?php echo $comment['id_comment']; ?>" <?php echo ($arrAccess['add_comment_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-trash"></i></a>
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
														<textarea placeholder="Nouveau commentaire sur le client..." class="form-control" name="comment" id="comment" style="height:200px;"></textarea>
													</div>
												</div>
												<div class="col-md-12 form-group form-actions">
													<input type="hidden" name="id_contact" id="id_contact" value="<?php echo $_GET['id_contact']; ?>" />
													<input type="hidden" name="action" id="action" value="add-comment" />
													<a href="#" class="btn btn-sm btn-success pull-left" id="btaddrecall" <?php echo ($arrAccess['add_comment_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-plus"></i> Créer un rappel pour ce client</a>&nbsp;												
													<button class="btn btn-sm btn-primary pull-right" type="submit" id="btaddcomment" <?php echo ($arrAccess['add_rappel_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-plus"></i> Ajouter une note</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<!-- <div id="tabs-doc" class="tab-pane"> -->
						<div class="item">
    						<div class="panel panel-default">
								<div class="form-group">
									<div class="pull-right">
										<a href="#" class="btn btn-sm btn-success btadddocsec" <?php echo ($arrAccess['add_doc_fiche_client'] != '1' ? 'disabled="disabled"' : '' ) ?>><i class="fa fa-plus-circle"></i> Ajouter un document</a>
									</div>
								</div>
								<div class="block">
									<div class="block-title">
										<h2><strong>Documents</strong> client</h2>
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
	<!-- END eShop Overview Block -->


	<!-- Modal recall -->
	<div id="modal-rappel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="gi gi-calendar"></i> Rappel Client</h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairerecall" method="post" action="appajax.php">
						<!-- Normal Form Content -->
						<div class="form-group">
							<label for="date_recall" class="col-md-4 control-label">Date de rappel</label>
							<div class="col-md-6">
								<input type="text" id="date_recall" name="date_recall" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="time_recall" class="col-md-4 control-label">Heure de rappel</label>
							<div class="col-md-6">
								<div class="input-group bootstrap-timepicker">
									<input type="text" name="time_recall" id="time_recall" value="" class="form-control input-timepicker24" required>
									<span class="input-group-btn">
										<a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
									</span>
								</div>

							</div>
						</div>
						<div class="form-group">
							<label for="msg_recall" class="col-md-4 control-label">Motif rappel</label>
							<div class="col-md-6">
								<textarea name="msg_recall" id="msg_recall" class="form-control" rows="4" cols="50" required></textarea>
							</div>
						</div>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">
								<input type="hidden" name="id_contact" id="id_contactrecal" value="<?php echo $_GET['id_contact']; ?>" />
								<input type="hidden" name="action" id="actionrecal" value="add-rappel" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
								<button class="btn btn-sm btn-primary" id="btrecall" type="submit">Valider</button>
							</div>
						</div>
					</form>
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
	<!-- END modal recall -->

	<!-- Modal Planning chambres -->
	<div id="modal-dispo-chambre" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="width:95%;">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> liste des chambres disponibles <span id="dtd"></span></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					
					<div id="chdispo" style="overflow: auto;height: 350px"></div>

					<div class="form-group form-actions" style="margin-bottom: 65px;margin-top: 25px;">
						<div class="col-md-12 text-center" style="margin-bottom:35px">
							<input type="hidden" name="resch[]" id="resch" value="" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
							<button class="btn btn-sm btn-primary" id="btokch" type="button">Valider</button>
						</div>
					</div>
					
				</div>
				<!-- END Modal Body -->
				
			</div>
		</div>
	</div>
	
	<div id="modal-transport" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="width:42%;">
			<div class="modal-content" style="height: 200px;">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-calendar"></i> Transports <span id="dtd"></span></h2>
				</div>
				<div class="modal-body">
					
					<div id="transp">
						<div class="form-group">
							<div class="col-md-4">
								<label class="switch switch-primary">
									<input type="checkbox" id="volnavette" name="volnavette" ><span></span>
								</label> Vol + Navette
							</div>
							<div class="col-md-4">
								<label class="switch switch-primary">
									<input type="checkbox" id="volseul" name="volseul" ><span></span>
								</label> Vol seul
							</div>
							<div class="col-md-4">
								<label class="switch switch-primary">
									<input type="checkbox" id="navetteseule" name="navetteseule" ><span></span>
								</label> Navette seule
							</div>
						</div>
					</div>

					<div class="form-group form-actions">
						<div class="col-md-12 text-center" style="margin-bottom:35px">
							<input type="hidden" name="restransp" id="restransp" value="" />
							<input type="hidden" name="iddet" id="iddet" value="" />
							<button href="#" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
							<button class="btn btn-sm btn-primary" id="btoktransport" type="button">Valider</button>
						</div>
					</div>
					
				</div>
				<!-- END Modal Body -->
				
			</div>
		</div>
	</div>
	<!-- END view impot -->

	<!-- Modal message doc  -->
	<div id="modal-msg-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> Envoi Email</h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsgdoc" method="post" action="appajax.php">
							
						
						<div class="form-group">
							<label class="col-md-4 control-label">Destinataire(s)</label>
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="destemail" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Sujet</label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmail" placeholder="sujet" />
									<div class="input-group-btn" data-toggle="tooltip" title="Charger un message type">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcont"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<?php foreach ($mtypes as $mtype) {?>
												<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" class="lnkmailtype"><?php echo $mtype['name_mailtype']; ?></a></li>
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

								<div class="btn-group pull-left" title="Ajouter un document" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddoc">Depuis mon poste local</a></li>
										<li><a href="javascript:void(0)" id="btadddocin">Documents du client</a></li>
									</ul>
									<button href="#" class="btn btn-sm btn-danger pull-left" title="Retier les pièces jointe" data-toggle="tooltip" id="btdeldoc"><i class="fa fa-minus"></i></button>
								</div>                    
								<input type="hidden" name="id_mailtype" id="id_mailtype" value="0" />
								<input type="hidden" name="cleardoc" id="cleardoc" value="0" />
								<input type="hidden" name="typeMail" id="typeMail" value="0" />
								<input type="hidden" name="idMailType" id="idMailType" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
								<button class="btn btn-sm btn-primary" id="btsenddoc" type="submit">Valider</button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
	<!-- END message doc -->

	<!-- Modal PDF BAR EN -->
	<div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="text-right display-none" id="blksigndoc" style="padding:15px 15px 0;">
					<a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> Envoi du document en Signature électronique</a>
				</div>
				<div class="modal-body" style="height: 80vh">
					<iframe src="" style="width:100%;height:100%;"></iframe>
					<input type="hidden" id="view_id_docs" />
				</div>
			</div>
		</div>
	</div>
	<!-- END view impot -->

	<div id="modal-confirm-sellsign" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Procedure de signature electronique démarée</h4>
				</div>
				<div class="modal-body text-center">						
					<h3><i class="fa fa-check fa-3x text-success animation-fadeIn"></i><br>La procedure de signature electronique effectuée</h3>					
					<p>
						Un lien à bien été envoyé au client :<br> <span id="idcontractsellsign" class="label label-success" style="font-size:14px" target="new"></span>
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
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> Envoyer un SMS</h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairesms" method="post" action="appajax.php">
						
						<div class="form-group">
							<label class="col-md-4 control-label">Envoyer le SMS à</label>
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
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal">Fermer</button>
								<button class="btn btn-sm btn-primary" id="btsendsms" type="submit">Valider</button>
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
					<h2 class="modal-title"><i class="fa fa-plus-circle"></i> Ajouter un document</h2>
				</div>
				<!-- Modal Body -->
				<div class="modal-body">					
					<form action="appajax.php" method="post" class="form-horizontal" id="formulairedoc"  onsubmit="return false;">
						<fieldset>
							<div class="form-group">
								<div id="filedocs" class="dropzone"></div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="id_type_doc">Type de document</label>
								<div class="col-md-8">
									<select name="id_type_doc" id="id_type_doc" class="form-control select-chosen">
										<option value="">Choisir le type de document</option>
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
								<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Annuler</button>
								<button type="submit" class="btn btn-sm btn-primary" id="btuploaddoc">Enregistrer</button>
							</div>
						</div>
					</form>
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
 
</div>
<!-- END Page Content -->
<!-- <a href="#" class="btimportth" data-action="add-th-l">test pdf</a> -->

<?php include 'including/footPage.php'; ?> 

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="jscript/helpers/excanvas.min.js"></script><![endif]-->

<?php include 'including/scripts.php'; ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTPCq11w-n5ZN8o3fIzhuUXCwPTTP6OmE&libraries=places"></script>
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

		// $('#day_birth').datepicker({
		// 	format: "dd",
		// 	weekStart: 1,
		// 	orientation: "bottom",
		// 	language: "{{ app.request.locale }}",
		// 	keyboardNavigation: false,
		// 	timeZone: true,
		// 	viewMode: "days",
		// 	minViewMode: "days"
		// });

		// $('#month_birth').datepicker({
		// 	format: "mm",
		// 	weekStart: 1,
		// 	orientation: "bottom",
		// 	language: "{{ app.request.locale }}",
		// 	keyboardNavigation: false,
		// 	timeZone: true,
		// 	viewMode: "months",
		// 	minViewMode: "months"
		// });

		// $('#year_birth').datepicker({
		// 	format: "yyyy",
		// 	weekStart: 1,
		// 	orientation: "bottom",
		// 	language: "{{ app.request.locale }}",
		// 	keyboardNavigation: false,
		// 	timeZone: true,
		// 	viewMode: "years",
		// 	minViewMode: "years"
		// });

		


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
			$.post('appajax.php', {action: 'maj-transport', idct: $('#id_contact').val(), iddet:$('#iddet').val(), restransp:$('#restransp').val() }, function(resp) {
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
		
	
		
		$(document).on('click','.ui-icon-disk',function(){
			$('#list_details').trigger("reloadGrid",[{current:true}]);
		})

		
		$(document).on('click','#sData',function(){
			console.log('gg')
			return
			$.post('appajax.php', {action: 'maj-tarifs-details', idct: $('#id_contact').val() }, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					console.log(resp)
					$('#tot_ht').val(resp.totht)
					$('#mt_ok_ht').val(resp.totrest)

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

		$(document).on('change','#libelle_tarif_details',function(){
			$.post('appajax.php', {action: 'read-tarif-details', idct: $('#id_contact').val(), idtarif:$('#libelle_tarif_details').val() }, function(resp) {
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

		$(document).on('focusout, change','#date_naissance_detail',function(){
			
			$.post('appajax.php', {action: 'age-tarif-details', idct: $('#id_contact').val(), dt:$('#date_naissance_detail').val() }, function(resp) {
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

		$('#btvalidedevise').click(function(){
			if(!confirm("Confirmez-vous le changement de devise et le recalcul des montants ?")){
				return false;
			}
			$.post('appajax.php', {action: 'change-devise', idct: $('#id_contact').val(), codedevise:$('#seldevises').val() }, function(resp) {
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

					$.post('appajax.php', {action: 'devises',idct: $('#id_contact').val(), montant: $('#tot_ht').val(), devisefrom:$('#codedevisect').val(), deviseto:$('#seldevises').val(), ac25:$('#accompte_25').val() }, function(resp) {
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

		$('#btlnkdevis').click(function(){
			$.post('appajax.php', {action: 'print-devis', idct: $('#id_contact').val(), app:'lnkdevis' }, function(resp) {
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

		$('#btlnkfac').click(function(){
			$.post('appajax.php', {action: 'print-facture', idct: $('#id_contact').val(), app:'lnkfac' }, function(resp) {
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
			"bFilter": false
		});
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
					idct:$('#id_contact').val(), 
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

		$(document).on('click', '.btdelch', function(){
			if(!confirm("Confirmez-vous la suppression de cette chambre")){
				return false;
			}
			HoldOn.open();
			$.post('appajax.php', {
					action: 'del-chambre-ct', 
					idct:$('#id_contact').val(), 
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


		$('#idbtdispoch').click(function(){
			HoldOn.open();
			$.post('appajax.php', {
					action: 'search-chambres', 
					dtstart:$('#date_start').val(), 
					dtend:$('#date_end').val(), 
					timestart:$('#time_start').val(), 
					timeend:$('#time_end').val(), 
					idct:$('#id_contact').val()
				}, function(resp) {

				if (resp.responseAjax == 'SUCCESS') {
					$('#dtd').text($('#date_start').val()+' au '+$('#date_end').val())
					$("#chdispo").html(resp.res)
					$('#modal-dispo-chambre').modal()
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
			$.post('appajax.php', {action:'reverse-tel', idct: $('#id_contact').val(), }, 
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
				data:{action:'send-contact-sms', idc:$('#id_contact').val(), num:$('#docnum').val(), msg:$('#msgsms').val()},
				success : function (resp) {	
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {					
						$.bootstrapGrowl('<h4>Confirmation!</h4> <p>SMS envoyé</p>', {
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
			
			if (confirm('Confirmez l\'envoi en Signature éléctronique du document \r\na l\'adresse suivante : '+$('#email').val()+' ?')) {
				HoldOn.open();
				console.log('post :',$('#view_id_docs').val(), $('#id_contact').val(), nameDocSign, typeDocSign)
				// return
				$.post('appajax.php', {action:'sign-doc', idd: $('#view_id_docs').val(), idc: $('#id_contact').val(), nameDoc: nameDocSign, typeDoc: typeDocSign}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('#modal-pdf').modal('hide');
						$('#modal-confirm-sellsign').modal();
						$('#lnksellsign').attr('href', resp.url);
						$('#lnksellsign').text(resp.url);
						$('#idcontractsellsign').text('Votre document a été envoyé avec le CODE suivant : '+resp.contract_id);
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
						if ($('#id_contact').val() == '0') {
							$.bootstrapGrowl('<h4>Confirmation!</h4> <p>Informations contact créées</p>', {
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
								location.href = 'contact.php?id_contact=' + resp.id_contact;
							}, 1000);
						} else {
							$.bootstrapGrowl('<h4>Confirmation!</h4> <p>Modification effectuée</p>', {
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
				error: function(jqXHR, textStatus){
					console.log('NO',jqXHR, textStatus);
					HoldOn.close();
				}
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
						$('#tbclimsg').append('<tr><td class="text-center">A l\'instant</td><td class="text-center"><i class="gi gi-alarm"></i> ' + resp.comment + '</td><td class="text-center"><div class="btn-group"><a href="#" data-toggle="tooltip" title="Supprimer le rappel" class="btn btn-xs btn-danger btdelcomment" data-id="' + resp.id_comment + '"><i class="fa fa-trash"></i></a></div></td></tr>');
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
			dictDefaultMessage:"Cliquez dans cette zone pour ajouter les fichiers",
			init: function () {				
				this.autoDiscover = false;
				dz = this;
	
				this.on('sendingmultiple', function (data, xhr, formData) {
					formData.append("id_contact", $("#id_contact").val());
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
						alert('Veuillez choisir le type de document.');
						return false;
					}
					
					HoldOn.open();
					if (dz.files.length > 0) {
						for(var f in dz.files)
							dz.files[f].status = "queued";
						dz.processQueue();
					}
					else {
						alert('Veuillez ajouter les factures à uploader');
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
							str += '<a href="' + resp.filename + '" class="gallery-link btn btn-sm btn-alt btn-default" title="Ajoutée à maintenant">Zoom</a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default deldoc" title="Supprimer" data-id="' + resp.id_doc + '"><i class="fa fa-trash"></i></a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default acceptdoc" title="Valider" data-id="' + resp.id_doc + '"><i class="fa fa-check"></i></a>';
							str += '</div></div></div>';
						} else {
							str += '<div class="col-sm-3 gallery-image gallery-file"><i class="hi hi-file"></i><br>' + resp.fl + '<div class="gallery-image-options text-center"><div class="btn-group btn-group-sm">';
							str += '<a href="' + resp.filename + '" target="new" class="btn btn-sm btn-alt btn-default" title="Ajoutée à maintenant">Voir</a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default deldoc" title="Supprimer" data-id="' + resp.id_doc + '"><i class="fa fa-trash"></i></a>';
							str += '<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default acceptdoc" title="Valider" data-id="' + resp.id_doc + '"><i class="fa fa-check"></i></a>';
							str += '</div></div></div>';
						}
						$('#contentdocs .gallery .row').append(str);

						$('#list_fiches_docs').trigger("reloadGrid",[{current:true}]);
					}
				});
			}
		};

		$(document).on('click', '.deldoc', function() {
			if (confirm('Supprimer le document ?')) {
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
			if (confirm('Confirmez l\'action sur le document ?')) {
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
		// 	$.post('appajax.php', {action: 'XXXXX', id_contact: $('#id_contact').val()}, function(resp) {
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
						
						$.bootstrapGrowl('<h4>Confirmation!</h4> <p>Modification effectuée</p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});


						$('#formulairect').submit();
						//remettre
						// setTimeout(function() {
						// 	location.href = 'contact.php?id_contact=' + resp.id_contact;
						// }, 1000);

					
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
		// 	$.post('appajax.php', {action: 'print-facture',datefac:$('#date_fac').val() , datedevis:$('#date_devis').val(), idct: $('#id_contact').val(), cptStud: 0}, function(resp) {
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
			$.post('appajax.php', {action: 'print-all', idct:<?php echo $_GET['id_contact'] ?>, typedoc:'6'}, function(resp) {
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

		$("a[href='#tabs-local']").on('shown.bs.tab', function() {
			startGMap();
		});

		$('#btemailfiche').click(function() {
			
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

			$('#aff-stag').hide();
			$('#modal-msg-mail').modal();
			return false;			
		});

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
			

			HoldOn.open();
			$.post('appajax.php', {
				action: 'affiche-mailtype',
				id_mailtype: idmt,
				id_contact : <?php echo $_GET['id_contact']; ?>,
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

			$('#btmtcont').dropdown("toggle");
			return false;
		});

		
		$('#btadddoc').click(function() {
			$('#fileadd').click();
		});

		$('#btdeldoc').click(function() {
			$('#fileadd').val('');
			$('#attacheddocs').text('');
			$('#cleardoc').val('1');
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
			$('#cleardoc').val('0');
		});

		$('#btadddocin').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'load-listdocs', idc: $('#id_contact').val()}, function(resp) {
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
				alert('Veuillez sélectionner les documents à insérer en pièce jointe');
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
				data:{action:'send-mail-fiche-ct', idc:$('#id_contact').val(), email:$('#destemail').val(), subject:$('#subjectmail').val(), msg:CKEDITOR.instances['msgcontent'].getData(), mailtypedest : mailType},
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
			localStorage.setItem('activeTab_<?php echo $_GET['id_contact']; ?>', $(e.target).attr('href'));
		});

		var activeTab = localStorage.getItem('activeTab_<?php echo $_GET['id_contact']; ?>');
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
			// HoldOn.open();
			$.post('appajax.php', {action:'send-rib', idct:$('#id_contact').val(), app:$(this).attr('id'), idbq:$(this).attr('data-id')}, function(resp){

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
			$('#tel1').removeAttr('disabled', false)
			$('#email').removeAttr('disabled', false)

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
		}

		$('#btdevis').click(function(){
			$.post('appajax.php', {action: 'print-devis', idct: $('#id_contact').val() }, function(resp) {
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
			$.post('appajax.php', {action: 'print-facture', idct: $('#id_contact').val() }, function(resp) {
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
		

		$('#btcontrat').click(function(){
			$.post('appajax.php', {action: 'print-contrat', idct: $('#id_contact').val() }, function(resp) {
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
			if(!confirm('confirmez l\'annulation de cette fiche \nainsi que la liberation des chambres')){
				return false
			}
			$.post('appajax.php', {action:'valide-annule-fiche', idct: $('#id_contact').val()}, 
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
			
			var tc = $(this).attr('id') == '######' ? 'plan' : '';

			if ($('#comment'+tc).val() == '') {
				$.bootstrapGrowl('<h4>Erreur!</h4> <p>Veuillez renseigner le message à ajouter</p>', {
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
				data:{type_comment: tc != '' ? '2' : '0'},
				success: function(resp) {
					if (resp.responseAjax == 'SUCCESS') {
						$('#tbclimsg'+tc).append('<tr><td class="text-center">Viens d\'être ajouté </td><td class="text-center">' + resp.inits + ' : ' + $('#comment').val() + '</td><td class="text-center"><div class="btn-group"><a href="#" data-toggle="tooltip" title="Supprimer le commentaire" class="btn btn-xs btn-danger btdelcomment'+tc+'" data-id="' + resp.id_comment + '"><i class="fa fa-trash"></i></a></div></td></tr>');
						$('#nbcomment'+tc).text((parseInt($('#nbcomment'+tc).text()) || 0) + 1);
						$('#comment'+tc).val('');
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
				error: function() {
					console.log('NO');
					HoldOn.close();
				}
			});
			return false;
		});


		$('#btcgv').click(function() {
			HoldOn.open();
			$.post('appajax.php', {action: 'print-cgv', idc:<?php echo $_GET['id_contact'] ?>, typedoc:'21'}, function(resp) {
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

