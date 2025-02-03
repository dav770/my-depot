
<?php include 'including/config.php'; ?>
<?php 
	if (isset($_GET['refreshCh']) && $_GET['refreshCh'] == 'CH' ){
		die(json_encode(array('html' => Grid4PHP::getGrid('db_chambres', $usrActif->cursoc))));
	}

	$existSejour = Setting::getAllorganisateurs();
	$soc = Soc::findOne(array('is_soc'=>'1'));
	$resapi = API::findOne(array('id_sejour'=>$usrActif->cursoc));

	$outorganisateurs = Grid4PHP::getGrid('db_sejours');
	$outuser = Grid4PHP::getGrid('db_users');
	$outprofils = Grid4PHP::getGrid('db_profils');

	$ageBb = Tarif::getBb();
	$ageEnfant = Tarif::getEnfant();
	$ageAdulte = Tarif::getAdulte();

	
	if($existSejour->num_rows > 0){

		$regular = Cleaning::findOne(array('libelle_nettoyage'=>'regular'));
		$complet = Cleaning::findOne(array('libelle_nettoyage'=>'complet'));
		$waitclean = Cleaning::findOne(array('libelle_nettoyage'=>'waitclean'));

		$outstatusconf = Grid4PHP::getGrid('db_status_secs'); 
		$outemail = Grid4PHP::getGrid('db_infos_emails'); 
		$outbq = Grid4PHP::getGrid('db_infos_banques'); 
		$outgroupe = Grid4PHP::getGrid('db_groupes'); 
		$outtransport = Grid4PHP::getGrid('db_transports'); 
		$outactivite = Grid4PHP::getGrid('db_activites'); 
		$outmono = Grid4PHP::getGrid('db_monos', $usrActif->cursoc); 
		$outposte = Grid4PHP::getGrid('db_postes'); 
		$outtarifs = Grid4PHP::getGrid('db_tarifs');
		// $outoptions = Grid4PHP::getGrid('db_options_chambres');
		$outchambres = Grid4PHP::getGrid('db_chambres', $usrActif->cursoc);
		// $outlocchambres = Grid4PHP::getGrid('db_vues_chambres');
		// $outtypeschambres = Grid4PHP::getGrid('db_types_chambres');
		$outmailtype = Grid4PHP::getGrid('db_mailtypes');
		$outsmstype = Grid4PHP::getGrid('db_smstypes');
		$outfournisseurs = Grid4PHP::getGrid('db_fournisseurs');
		$outunites = Grid4PHP::getGrid('db_unites');
		$outstock = Grid4PHP::getGrid('db_produits');
		$outplats = Grid4PHP::getGrid('db_plats');
		$outplatsd = Grid4PHP::getGrid('db_plats_details');
		$outmenus = Grid4PHP::getGrid('db_menus');
		$outdevises = Grid4PHP::getGrid('db_devises');

		// -*
		$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));

		$outlocchambres = Chambres::getAllLoc();
		$outtypeschambres = chambres::getAllType();
	}
?>

<?php include 'including/headPage.php'; ?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
<link rel="stylesheet" href="css/menu.css">

<style>

	@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);
\:root {
  font-size: 16px; }

* {
  font-family: "Open Sans", Helvetica, Arial, sans-serif; }

body {
  height: 100vh;
  background: #F3F4F8; }

.tabs-page {
  position: relative; }
  .tabs-page > .nav-tabs {
    position: relative;
    min-height: 50px;
    margin: 0;
    padding-left: 15px;
    text-align: left;
    cursor: auto;
    border: none;
    z-index: 1; }
    .tabs-page > .nav-tabs li[role="presentation"] {
      display: inline-block;
      height: 50px;
      border: none; }
      .tabs-page > .nav-tabs li[role="presentation"]:not(:last-child) {
        padding-right: 2px; }
      .tabs-page > .nav-tabs li[role="presentation"] a[role="tab"] {
        height: 50px;
        margin: 0;
        padding: 0px 3px 0px 3px;
        /* padding: 0px; */
        /* font-size: 0.875rem; */
        font-weight: 700;
        text-transform: none;
        text-align: center;
        letter-spacing: 0.25px;
        color: black;
        background: #EAE7DA;
        /* background: none; */
        border: none;
		/* border:2px solid black; */
        line-height: 50px;
        transition: color 0.3s ease, box-shadow 0.2s ease; }
        .tabs-page > .nav-tabs li[role="presentation"] a[role="tab"]:hover {
          color: #0075AD; }
      .tabs-page > .nav-tabs li[role="presentation"].active a {
		font-style: oblique;
			font-weight: bold;
			font-size: 25px;
			color: #1f6de6;
        /* color: #0075AD; */
        box-shadow: inset 0 -2px 0 #0075AD;
        background: #FFF; }
        .tabs-page > .nav-tabs li[role="presentation"].active a:hover, .tabs-page > .nav-tabs li[role="presentation"].active a:focus {
			font-style: oblique;
			font-weight: bold;
			font-size: 25px;
			color: #1f6de6;
          background: #FFF;
          border: none; }
  .tabs-page > .tab-content {
    position: relative;
    min-height: 800px;
    margin: 0;
    padding: 0;
    background: white;
    border-top: 1px solid #edeef4;
    border-bottom: 1px solid #edeef4; }

.tabs-secondary {
  position: relative;
  text-align: center; }
  .tabs-secondary > .nav-tabs {
    display: inline-block;
    margin: 0 auto 15px;
    border-bottom: 1px solid #edeef4; }
    .tabs-secondary > .nav-tabs li[role="presentation"]:not(:last-child) {
      margin-right: 20px; }
    .tabs-secondary > .nav-tabs li[role="presentation"] a[role="tab"] {
      padding: 12px 0;
      /* font-size: 0.6875rem; */
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.02rem;
      color: #BDC4D0;
      border: none !important;
      background: none !important; }
      .tabs-secondary > .nav-tabs li[role="presentation"] a[role="tab"]:hover {
        color: #0075AD; }
    .tabs-secondary > .nav-tabs li.active a[role="tab"] {
      color: #0075AD;
      background: none;
      box-shadow: inset 0 -2px 0 0 #0075AD; }


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

	.password-container {
		position: relative;
		width: 300px;
	}
	.password-container input {
		width: 100%;
		padding-right: 40px; /* Laisser de l'espace pour le bouton */
	}
	.password-container .toggle-password {
		position: absolute;
		top: 70%;
		right: 17px; /* Aligné à droite du champ */
		transform: translateY(-50%);
		cursor: pointer;
		background: none;
		border: none;
		font-size: 16px;
		color: #666;
	}
</style>

<div id="page-content" class="page-settings">
    <!-- eCommerce Dashboard Header -->
    <div class="content-header">
        <?php include('including/mainMenu.php'); 
		include('./load_page.php');		
		?>
    </div>


  <!-- Tabs - Page -->
	<div id="tabs-page" class="tabs-page">
		<!-- Nav Tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#sejour" aria-controls="sejour" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Séjours" : "Stay") ?></a></li>
			<?php if($existSejour->num_rows > 0){?>
				<li role="presentation"><a href="#gene" aria-controls="gene" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Infos Générales" : "General informations") ?></a></li>
				<li role="presentation"><a href="#infApi" aria-controls="infApi" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Infos API" : "API informations") ?></a></li>
				<li role="presentation"><a href="#usr" aria-controls="usr" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Utilisateurs" : "Users") ?></a></li>
				<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Droits utilisateurs" : "Users right") ?></a></li>
				<li role="presentation"><a href="#sec" aria-controls="sec" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Etats Dossier" : "Status folder") ?></a></li>
				<li role="presentation"><a href="#tarifs" aria-controls="tarifs" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Tarifications & devises" : "Princing & Currency") ?></a></li>
				<li role="presentation"><a href="#transp" aria-controls="transp" role="tab" data-toggle="tab">Transports</a></li>
				<li role="presentation"><a href="#typelocch" aria-controls="typelocch" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Types et vues" : " Types & Views") ?></a></li>
				<!-- <li role="presentation"><a href="#opt" aria-controls="opt" role="tab" data-toggle="tab">Options</a></li> -->
				<li role="presentation"><a href="#chb" aria-controls="chb" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Chambres" : "Rooms") ?></a></li>
				<li role="presentation"><a href="#fourn" aria-controls="fourn" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Fournisseurs" : "Providers") ?></a></li>
				<li role="presentation"><a href="#unit" aria-controls="unit" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Unités" : "Units") ?></a></li>
				<li role="presentation"><a href="#stock" aria-controls="stock" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Stock - Produits" : "Stock - Products") ?></a></li>
				<li role="presentation"><a href="#plats" aria-controls="plats" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Plats" : "Dishes") ?></a></li>
				<li role="presentation"><a href="#platsd" aria-controls="platsd" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Plats Détails" : "Details dishes") ?></a></li>
				<li role="presentation"><a href="#menus" aria-controls="menus" role="tab" data-toggle="tab">Menus</a></li>
				<li role="presentation"><a href="#mlt" aria-controls="mlt" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Modèle de mail" : "Mail types") ?></a></li>
				<li role="presentation"><a href="#smst" aria-controls="smst" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Modèle SMS" : "SMS types") ?></a></li>
				<li role="presentation"><a href="#kd" aria-controls="kd" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Kids Club & Activités" : "Kids club & Activities") ?></a></li>
			<?php }?>
		</ul><!-- ./ nav tabs -->	
	</div><!-- ./ tabs page -->

	<div class="tabs-page">
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="sejour">
				<div class="<?php echo ($existSejour->num_rows > 0 ? 'display-none' : '') ?>">
					<a href="#" class="btn btn-sm btn-primary pull-left" style="margin-right:10px" id="btrefreshsettings"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Raffraichir" : "Refresh") ?></a>
				</div>
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Séjours" : "Stay") ?></h2>
				<div class="table-responsive">
					<?php echo $outorganisateurs; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="gene">
				<div class="tabs-page">
					<!-- Nav Tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#detailssoc" aria-controls="detailssoc" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Infos société" : "Society informations") ?></a>
							
						</li>
						
						<li role="presentation"><a href="#detailsgene" aria-controls="detailsgene" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Infos Complémentaires" : "Complementary informations") ?></a>
							
						</li>
					</ul><!-- ./ nav tabs -->	
				</div>
				<div class="tabs-page">
					<div class="tab-content">
						
						<div class="tabs-page">
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane isactgene active" id="detailssoc">
									<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Société" : "Society") ?></h2>
									<div class="container">
										<form onsubmit="return false;" action="appajax.php" class="form-horizontal" method="post" id="formulairesoc" enctype="multipart/form-data">
											
											<div class="form-group">
												<div class="col-md-6" >
													<label for="name_soc" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nom de la société" : "Society name") ?> </label>
													<input type="text" class="form-control" name="name_soc" id="name_soc" value="<?php echo $soc->name_soc; ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6" >
													<label for="site_soc" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Site de la société" : "Society url") ?> </label>
													<input type="text" class="form-control" name="site_soc" id="site_soc" value="<?php echo $soc->site_soc; ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-3" >
													<label for="adr_soc" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Adresse" : "Adress") ?> </label>
													<input type="text" class="form-control" name="adr_soc" id="adr_soc" value="<?php echo $soc->adr_soc; ?>">
												</div>
												<div class="col-md-3" >
													<label for="post_code_soc" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Code Postal" : "Zip code") ?> </label>
													<input type="text" class="form-control" name="post_code_soc" id="post_code_soc" value="<?php echo $soc->post_code_soc; ?>">
												</div>
												<div class="col-md-3" >
													<label for="city_soc" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Ville" : "City") ?> </label>
													<input type="text" class="form-control" name="city_soc" id="city_soc" value="<?php echo $soc->city_soc; ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-3" >
													<label for="tel_soc" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Téléphone" : "Phone number") ?> </label>
													<input type="text" class="form-control" name="tel_soc" id="tel_soc" value="<?php echo $soc->tel_soc; ?>">
												</div>
												<div class="col-md-3" >
													<label for="mail_soc" class="control-label">Email </label>
													<input type="text" class="form-control" name="email_soc" id="email_soc" value="<?php echo $soc->email_soc; ?>">
												</div>
												<div class="col-md-3" >
													<label for="whatsapp_soc" class="control-label">Whatsapp </label>
													<input type="text" class="form-control" name="whatsapp_soc" id="whatsapp_soc" value="<?php echo $soc->whatsapp_soc; ?>">
												</div>
											</div>

											<input type="hidden" name="action" id="action" value="soc-update" />
											<div class="form-group form-actions">
												<button class="btn btn-xs btn-primary" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
											</div>
										</form>

										<form onsubmit="return false;" action="appajax.php" class="form-horizontal" method="post" id="formulairesoclogo" enctype="multipart/form-data" <?php echo !$soc ? 'style="display:none"' : '' ?>>
											<div class="form-group">
												<div class="col-md-4" style="text-align: right;">
													<img src="<?php echo $template['url'].'/uploads/socs/'.$soc->logo_soc?>" id="imglogo" style="width:70px">
												</div>
												<div class="col-md-4">
													<label for="image_logo" class="control-label">Logo </label>
													<input type="file" name="image_logo" accept="image/*" />
												</div>
											</div>
											
											<input type="hidden" name="action" id="action" value="logo-update" />
											<div class="form-group form-actions" style="text-align: center;">
												<button class="btn btn-xs btn-primary" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Envoyer" : "Upload") ?></button>
											</div>
										</form>

										
										<form onsubmit="return false;" action="appajax.php" class="form-horizontal" method="post" id="formulairesocsign" enctype="multipart/form-data" <?php echo !$soc ? 'style="display:none"' : '' ?>>
											<div class="form-group">
												<div class="col-md-4" style="text-align: right;">
													<img src="<?php echo $template['url'].'/uploads/socs/'.$soc->sign_soc?>" id="imgsign"  style="width:70px">
												</div>
												<div class="col-md-4" >
													<label for="imgage_sign" class="control-label">Signature </label>
													<input type="file" name="image_sign" accept="image/*" />
												</div>
											</div>
											
											<input type="hidden" name="action" id="action" value="sign-update" />
											<div class="form-group form-actions" style="text-align: center;">
												<button class="btn btn-xs btn-primary" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Envoyer" : "Upload") ?></button>
											</div>
										</form>

										<form onsubmit="return false;" action="appajax.php" class="form-horizontal" method="post" id="formulairesocfond" enctype="multipart/form-data" <?php echo !$soc ? 'style="display:none"' : '' ?>>
											<div class="form-group">
												<div class="col-md-4" style="text-align: right;">
													<img src="<?php echo $template['url'].'/uploads/socs/'.$soc->img_fond_soc?>" id="imgfond"  style="width:70px">
												</div>
												<div class="col-md-4" >
													<label for="image_fond" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Image de fond" : "Background image") ?> </label>
													<input type="file" name="image_fond" accept="image/*" />
												</div>
											</div>
											
											<input type="hidden" name="action" id="action" value="fond-update" />
											<div class="form-group form-actions" style="text-align: center;">
												<button class="btn btn-xs btn-primary" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Envoyer" : "Upload") ?></button>
											</div>
										</form>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="detailsgene">
									<h2> Infos EMAIL</h2>
									<div class="table-responsive">
										<?php echo $outemail; ?>
									</div>
									<h2> Infos <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "BANQUE" : "BANK") ?></h2>
									<div class="table-responsive">
										<?php echo $outbq; ?>
									</div>
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="infApi">
				<form onsubmit="return false;" action="appajax.php" class="form-horizontal" method="post" id="formulaireapi" enctype="multipart/form-data" <?php echo !$soc ? 'style="display:none"' : '' ?>>
					<div class="container" style="border:1px solid black; margin-top:10px">	
						<div>
							<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "API MailTrap" : "MailTrap API") ?></h2>
						</div>
					
						<div class="col-md-3 form-group">
							<label for="api_user" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Identifiant Mailtrap" : "Mailtrap ident") ?> </label>
							<input type="text" class="form-control" id="api_user" name="api_user" value="<?php echo $resapi->mail_user_api?>" >
						</div>
						<div class="col-md-1 form-group">
						</div>
						<div class="col-md-3 form-group password-container">
							<label for="api_password" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Mot de passe API Mailtrap" : "Mailtrap API password") ?> </label>
							<input type="password" class="form-control" id="api_password" name="api_password" value="<?php echo $resapi->mail_key_api ?>" >
							<button class="toggle-password" type="button">👁️</button>
						</div>
						<div class="col-md-2 form-group">
						</div>
						<div class="col-md-1 form-group" style="padding-top:36px">
							<label class="switch switch-primary">
								<input type="checkbox" id="is_mail_api" name="is_mail_api" <?php echo $resapi && $resapi->is_mail_api > 0 ? 'checked="true"' : ''; ?>><span></span>
							</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "ACTIVE" : "ACTIVATE") ?>
						</div>
					</div>	

					<div class="container" style="border:1px solid black; margin-top:10px">	
						<div>
							<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "API ClickSend" : "ClickSend API") ?></h2>
						</div>
						<div class="col-md-2 form-group">
							<label for="fromclicksend" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nom envoyeur" : "From") ?> </label>
							<input type="text" class="form-control" id="fromclicksend" name="fromclicksend" value="<?php echo $resapi->sms_from_api?>" >
						</div>
						<div class="col-md-1 form-group">
						</div>
						<div class="col-md-3 form-group">
							<label for="userclicksend" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Identifiant ClickSend" : "ClickSend ident") ?> </label>
							<input type="text" class="form-control" id="userclicksend" name="userclicksend" value="<?php echo $resapi->sms_user_api?>" >
						</div>
						<div class="col-md-1 form-group">
						</div>
						<div class="col-md-3 form-group">
							<label for="keyclicksend" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Key API ClickSend" : "ClickSend API Key") ?> </label>
							<input type="text" class="form-control" id="keyclicksend" name="keyclicksend" value="<?php echo $resapi->sms_key_api?>" >
						</div>
						<div class="col-md-2 form-group">
						</div>
						<div class="col-md-1 form-group" style="padding-top:36px">
							<label class="switch switch-primary">
								<input type="checkbox" id="is_sms_api" name="is_sms_api" <?php echo $resapi && $resapi->is_sms_api > 0 ? 'checked="true"' : ''; ?>><span></span>
							</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "ACTIVE" : "ACTIVATE") ?>
						</div>
					</div>

					<input type="hidden" name="action" id="action" value="api-update" />
					<input type="hidden" name="idsejourapi" id="idsejourapi" value="<?php echo $usrActif->cursoc ?>" />
					<div class="form-group form-actions" style="text-align: center;">
						<button class="btn btn-xs btn-primary" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Envoyer" : "Upload") ?></button>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="usr">
				<a href="#" onclick="showUsrApp(0)" class="btn btn-sm btn-primary pull-right" id=""><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Ajouer utilisateur" : "Add user") ?></a>
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Utilisateurs" : "Users") ?></h2>
				
				<div class="table-responsive">
					<?php echo $outuser; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="profile">
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Droits utilisateurs" : "Users right") ?></h2>
				<div class="table-responsive">
					<?php echo $outprofils; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="sec">
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Etats Dossier" : "Status folder") ?></h2>
				<div class="table-responsive">
					<?php echo $outstatusconf; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="tarifs">
				<fieldset style="background-color: floralwhite;padding-bottom: 10px;">
					<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Age" : "Age") ?></h2>
					<div class="form-group">
						<div class="col-md-3" >
							<label for="age_bb" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "BB jusqu'à :" : "Baby until :") ?> </label>
							<input type="text" class="form-control" name="age_bb" id="age_bb" value="<?php echo $ageBb->age_bb; ?>" style="max-width: 86px;display: inline;"> an(s)
						</div>
					
						<div class="col-md-3" >
							<label for="age_enfant" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Enfant de :" : "Child of :") ?> <span id="iddebageenf" style="color:red;font-size: 20px;" ><?php echo $ageBb->age_bb + 1; ?></span> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "an(s) jusqu'à :" : "year(s) until :") ?> </label>
							<input type="text" class="form-control" name="age_enfant" id="age_enfant" value="<?php echo $ageEnfant->age_enfant; ?>" style="max-width: 86px;display: inline;"> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "an(s)" : "year(s)") ?>
						</div>
					
						<div class="col-md-3" >
							<label for="age_adulte" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Adulte à partir de :" : "Adult of :") ?> </label>
							<input type="text" class="form-control" name="age_adulte" id="age_adulte" value="<?php echo $ageAdulte->age_adulte; ?>" style="max-width: 86px;display: inline;"> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "an(s)" : "year(s)") ?>
						</div>
					
						<div class="col-md-3" >
							<button class="btn btn-sm btn-primary" type="button" id="btvalideages"><i class="fa fa-user"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider les ages" : "Confirm") ?></button>
						</div>
					</div>
					
				</fieldset>
				<br>
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Tarifications" : "Princing") ?></h2>
				<div>
					<div class="col-md-3">
						<label class="switch switch-primary">
							<input type="checkbox" id="istarifnuit" name="is_tarif_nuit" <?php echo $infgene && $infgene->name_tarif == 'is_tarif_nuit' ? 'checked="true"' : ''; ?>><span></span>
						</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Tarifs applicable à la Nuit" : "Princing applicable per night") ?>
					</div>
					<div class="col-md-3">
						<label class="switch switch-primary">
							<input type="checkbox" id="istarifsemaine" name="is_tarif_nuit" <?php echo $infgene && $infgene->name_tarif == 'is_tarif_semaine' ? 'checked="true"' : ''; ?>><span></span>
						</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Tarifs applicable à la Semaine" : "Princing applicable per week") ?>
					</div>
					<div class="col-md-3">
						<label class="switch switch-primary">
							<input type="checkbox" id="istarifsejour" name="is_tarif_nuit" <?php echo $infgene && $infgene->name_tarif == 'is_tarif_sejour' ? 'checked="true"' : ''; ?>><span></span>
						</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Tarifs applicable au Sejour" : "Princing applicable to the duration of the stay") ?>
					</div>
					<div class="col-md-3">
						<label class="switch switch-primary">
							<input type="checkbox" id="islisteopts" name="is_list_opts" <?php echo $infgene && $infgene->is_list_opts > 0 ? 'checked="true"' : ''; ?>><span></span>
						</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Opts mode liste" : "Opts list mode") ?>
					</div>
					<div class="col-md-3">
						<label class="switch switch-primary">
							<input type="checkbox" id="isdecimal" name="is_decimal" <?php echo $infgene && $infgene->is_decimal > 0 ? 'checked="true"' : ''; ?>><span></span>
						</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Tarifs avec décimal" : "Rates with decimal") ?>
					</div>
				</div>
				
				<div class="block">
					<!-- <div class="table-responsive" style="margin-top:70px"> -->
					<div class="table-responsive" style="margin-top:70px">
						<?php echo $outtarifs; ?><br><br>
						<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Devises" : "Currency") ?></h2>
						<div class="table-responsive">
							<?php echo $outdevises; ?>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="transp">
				<h2>Transports</h2>
				<div class="table-responsive">
					<?php echo $outtransport; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="typelocch">
				<div id="" class="col-md-6" style="">
					<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Types et vues" : " Types & Views") ?></h2>
					<a href="#" title="Ajouter" class="btn btn-xs btn-primary btaddtypech" style="margin-bottom: 5px;"><i class="fa fa-pencil" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
									
					<table id="typeCh" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
						<thead>
							<tr>
								<th>
								<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Libellé du type de chambre" : "Types label") ?> 
								</th>
								<th> 
									Actions 
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($outtypeschambres as $ch){
							echo '<tr id="lgtype' . $ch['id_type_chambre'] . '">
									<td style="width: 90%;" id="type' . $ch['id_type_chambre'] . '">
										<span class="columnClass">'.$ch['name_type_chambre'].'</span>
									</td> 
									<td style="width: 10%;">
									<a href="#" data-toggle="tooltip" data-id-type="' . $ch['id_type_chambre'] . '"  data-lib-type="' . $ch['name_type_chambre'] . '" title="Modifier" class="btn btn-xs btn-warning btmodtypech"><i class="fa fa-pencil" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
									<a href="#" data-toggle="tooltip" data-id-type="' . $ch['id_type_chambre'] . '" title="Supprimer" class="btn btn-xs btn-danger btdeltypech"><i class="fa fa-trash" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
									</td>
								</tr>';
						} ?>
						</tbody>
					</table>
				</div>
				<div id="" class="col-md-6" style="">
					<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "vues des chambres" : "View") ?></h2>
					<a href="#" title="Ajouter" class="btn btn-xs btn-primary btaddlocch" style="margin-bottom: 5px;"><i class="fa fa-pencil" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
									
					<table id="locCh" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
						<thead>
							<tr>
								<th>
								<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Libellé de la vue" : "View label") ?>
								</th>
								<th> 
									Actions 
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($outlocchambres as $ch){
							echo '<tr id="lgloc' . $ch['id_loc_chambre'] . '">
									<td style="width: 90%;" id="loc' . $ch['id_loc_chambre'] . '">
										<span class="columnClass">'.$ch['name_loc_chambre'].'</span>
									</td> 
									<td style="width: 10%;">
									<a href="#" data-toggle="tooltip" data-id-loc="' . $ch['id_loc_chambre'] . '" data-lib-loc="' . $ch['name_loc_chambre'] . '" title="Modifier" class="btn btn-xs btn-warning btmodlocch"><i class="fa fa-pencil" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
									<a href="#" data-toggle="tooltip" data-id-loc="' . $ch['id_loc_chambre'] . '" title="Supprimer" class="btn btn-xs btn-danger btdellocch"><i class="fa fa-trash" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
									</td>
								</tr>';
						} ?>
						</tbody>
					</table>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="chb">
				<div style="display:flex">				
					<a href="#" class="btn btn-sm btn-primary pull-right" id="sej_duplique"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dupliquer les chambres du séjour suivant " : "Duplicate the rooms of the next stay") ?></a>				
					<select data-placeholder="Choix..." class="form-control" style="margin-left:15px;width:200px" id="id_sej_duplique" name="id_sej_duplique" <?php echo $arrAccess['duplique_sejour'] == '1' ? 'readonly="readonly"' : ''; ?>>
						<option value=""></option>
						<?php
						$sejs = Setting::getAllorganisateurs();
						if ($sejs) {
							foreach ($sejs as $sj) {
								if($sj['id_organisateur'] != $usrActif->cursoc){
									echo '<option value="' . $sj['id_organisateur'] . '">' . $sj['name_organisateur'] . '</option>';
								}
							}
						}
						?>
					</select>
					
					<span style="margin-left:100px;margin-right:15px;margin-top:10px"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nettoyage classique " : "Regular cleaning ") ?></span>
					<input type="color" id="regular_clean" name="regular_clean" value="<?php echo $regular->color ?>">
					<span style="margin-left:100px;margin-right:15px;margin-top:10px"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nettoyage complet " : "Complet cleaning ") ?></span>
					<input type="color" id="complet_clean" name="complet_clean" value="<?php echo $complet->color ?>">
					<span style="margin-left:100px;margin-right:15px;margin-top:10px"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "En attente " : "Waiting ") ?></span>
					<input type="color" id="wait_clean" name="wait_clean" value="<?php echo $waitclean->color ?>">
				
					<div class="col-md-3">
						<label class="switch switch-primary">
							<input type="checkbox" id="iscapacityauto" name="is_capacite_auto" <?php echo $infgene && $infgene->is_capacite_auto > 0 ? 'checked="true"' : ''; ?>><span></span>
						</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Calcul auto. de la capacité" : "Auto calculation capacity") ?>
					</div>
				</div>

				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Chambres" : "Rooms") ?></h2>

				<div class="table-responsive" id="htmlChb">
					<?php echo $outchambres; ?>
				</div>
			</div>
			<!-- <div role="tabpanel" class="tab-pane" id="opt">
				<h2>Options</h2>
				<div class="table-responsive">
					<?php echo $outoptions; ?>
				</div>
			</div> -->
			<div role="tabpanel" class="tab-pane" id="fourn">
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Fournisseurs" : "Providers") ?></h2>
				<div class="table-responsive">
					<?php echo $outfournisseurs; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="unit">
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Unités" : "Units") ?></h2>
				<div class="table-responsive">
					<?php echo $outunites; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="stock">
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Stock - Produits" : "Stock - Products") ?></h2>
				<div class="table-responsive">
					<?php echo $outstock; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="plats">
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Plats" : "Dishes") ?></h2>
				<div class="table-responsive">
					<?php echo $outplats; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="platsd">
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Plats Détails" : "Details dishes") ?></h2>
				<div class="table-responsive">
					<?php echo $outplatsd; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="menus">
				<h2>Menus</h2>
				<div class="table-responsive">
					<?php echo $outmenus; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="mlt">
				<a href="#" class="btn btn-sm btn-primary pull-right" id="btaddmailtype"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Ajouter un modèle" : "Add a model") ?></a>
				<div class="col-md-3">
					<label class="switch switch-primary">
						<input type="checkbox" id="isautomail" name="is_auto_mail" <?php echo $infgene && $infgene->is_auto_mail > 0 ? 'checked="true"' : ''; ?>><span></span>
					</label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Envoi mail auto" : "Send email auto") ?>
				</div>
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Modèle de mail" : "Mail types") ?></h2>
				<div class="table-responsive">
					<?php echo $outmailtype; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="smst">
				<a href="#" class="btn btn-sm btn-primary pull-right" id="btaddsmstype"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Ajouter un modèle" : "Add a model") ?></a>
				<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Modèle SMS" : "SMS types") ?></h2>
				<div class="table-responsive">
					<?php echo $outsmstype; ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="kd">
				<div class="tabs-page">
					<!-- Nav Tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#child1" aria-controls="child1" role="tab" data-toggle="tab">Fonctions</a>
							
						</li>
						<li role="presentation"><a href="#child2" aria-controls="child2" role="tab" data-toggle="tab">Groupes</a>
							
						</li>
						<li role="presentation"><a href="#child3" aria-controls="child3" role="tab" data-toggle="tab">activites</a>
							
						</li>
					</ul><!-- ./ nav tabs -->	
				</div>
			

				<div class="tabs-page">
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane isact" id="child1">
							<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Fonctions" : "Job") ?></h2>
							<div class="table-responsive" style="margin-top:20px">
								<?php echo $outposte; ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="child2">
							<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Groupes" : "Band") ?></h2>
							<div class="table-responsive" style="margin-top:20px">
								<?php echo $outgroupe; ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="child3">
							<h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "activites" : "Activities") ?></h2>
							<div class="table-responsive" style="margin-top:20px">
								<?php echo $outactivite; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>

	


	<div id="modal-sms" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Modèle SMS" : "SMS types") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairesms" method="post" action="appajax.php">
						
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nom du modèle SMS" : "Name of model") ?></label>
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" name="name_smstype" id="name_smstype" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Message</label>
						</div>
						<div class="form-group">
							<div class="col-md-12" >
								<textarea id="msgsms" name="msgsms" class="form-control" style="height:250px"></textarea>
							</div>
							<div class="col-md-12">
								<u><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Variables disponibles :" : "Variables available") ?></u> <br>
								<table style="width=100%">
									<?php
										$vars = VarsType::buildVars($usrActif);
										$cpt=0;
										foreach($vars as $k => $v) {
											$cpt++;
											echo '<tr><td><a href="#" class="clsvarsms" id="varsms'.$cpt.'" data-var="'.$k.'">'.$k.'</a></td>
													<td style="width:25px"> </td>
													<td>'.$v['label'].'</td>
												</tr>';
										}
									?>
								</table>
							</div>
						</div>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								<input type="hidden" id="action" name="action" value="save-smstype" />
								<input type="hidden" id="id_smstype" name="id_smstype" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btsavesmstype" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-msg-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Modèle MAIL" : "Email types") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsgdoc" method="post" action="appajax.php">
						
						<div class="form-group">
							<label class="col-md-4 control-label"> Type</label>
							<div class="col-md-8">
								<select class="form-control" id="typemodel" style="width: 111px;margin-left: 15px;">
									<option value="0"></option>
									<option value="1"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commande' : 'Order') ?></option>
									<option value="2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Devis' : 'Estimate') ?></option>
									<option value="3"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Facture' : 'Invoice') ?></option>
									<option value="4"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'RIB-IBAN' : 'Bank details') ?></option>
									<option value="5"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription' : 'Registration') ?></option>
									<option value="6"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat' : 'Contract') ?></option>
									<option value="7"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien paiement' : 'Payment link') ?></option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nom du Modèle" : "Name of model") ?></label>
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" name="name_mailtype" id="name_mailtype" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Sujet" : "Subject") ?></label>
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="subject" name="subject" />									
							</div>
						</div>
						
						<label class="col-md-6 control-label">Message</label>
						<div class="form-group">
							<div class="col-md-12 blctxtcomment">
								<div class="col-md-6">
									<label>
										<em>
											<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Shift + Entrée = Retour à la ligne" : "Shift + Enter = Carriage return") ?><br>
										</em>
									</label>
								</div>
								<div class="col-md-6">
									<label>
										<em>
											<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Entrée = Nouveau paragraphe" : "Enter = New paragraph") ?>
										</em>
									</label>
								</div>
								<textarea id="msg" name="msg" class="ckeditor"></textarea>
								
							</div>
							<div class="col-md-12">
								<u><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Variables disponibles pour ce type de modèle. <span style='color:red'>Celles en rouges le sont également dans le `Sujet`</span> :" : "Variables available for this model. <span style='color:red'>Those in red are also in the `Subject`</span> :") ?></u> <br>
								<table style="width=100%">
									<?php
										$vars = VarsType::buildVars($usrActif);
										$cpt=0;
										foreach($vars as $k => $v) {
											$cpt++;
											echo '<tr data-src="'.$v['src'].'" >
													<td><a href="#" '.($k == '$NOM' || $k == '$PRENOM' || $k == '$SOC' || $k == '$DEB' || $k == '$FIN' || $k == '$CIVILITE' ? " style='color:red;' " : "").' class="clsvar" id="var'.$cpt.'" data-var="'.$k.'">'.$k.'</a></td>
													<td style="width:25px"> </td>
													<td>'.$v['label'].'</td>
												</tr>';
										}
									?>
								</table>
							</div>
								
						</div>
						<div id="attacheddocs" class="block">
						</div>

						<input type="file" name="fileadd[]" id="fileadd"  style="display:none;" multiple>
					
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								<button href="#" class="btn btn-sm btn-success pull-left" title="Ajouter une pièce jointe" data-toggle="tooltip" id="btadddoc"><i class="fa fa-plus"></i></button>
								<button href="#" class="btn btn-sm btn-danger pull-right" title="Retier les pièces jointe" data-toggle="tooltip" id="btdeldoc"><i class="fa fa-minus"></i></button>

								<input type="hidden" id="action" name="action" value="save-mailtype" />
								<input type="hidden" id="id_mailtype" name="id_mailtype" value="0" />
								<input type="hidden" id="attachclr" name="attachclr" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btsavemailtype" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
	
	<div id="hashtaglst" class="display-none">
		<input type="text" class="form-control" id="txtsearchusr">
		<ul>
			<?php
				
				$htvars = VarsType::buildVars($usrActif); 
				foreach($htvars as $htvar)
					echo '<li>'.$htvar.'</li>';
			?>
		</ul>
	</div>

	<div id="modal-type-ch" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Type de chambre" : "Room type") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairetypech" method="post" action="appajax.php">
						<div class="form-group">
							
							<label for="type" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Libellé" : "Label") ?></label>
							<input type="text" class="form-control"  value="" id="type" name="type" />		
						</div>
						
						
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								<input type="hidden" id="action" name="action" value="add-type-ch" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btaddtypechok" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-loc-ch" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Vue chambre :" : "Room view") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairelocch" method="post" action="appajax.php">
						<div class="form-group">
							
							<label for="loc" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Libellé" : "Label") ?></label>
							<input type="text" class="form-control"  value="" id="loc" name="loc" />		
						</div>
						
						
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								<input type="hidden" id="action" name="action" value="add-loc-ch" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btaddlocchok" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-modloc" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "vue chambre :" : "Room view") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemodiflocch" method="post" action="appajax.php">
						<div class="form-group">
							
							<label for="modloc" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Libellé" : "Label") ?></label>
							<input type="text" class="form-control"  value="" id="modloc" name="modloc" />		
						</div>
						
						
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								<input type="hidden" id="action" name="action" value="mod-loc-ch" />
								<input type="hidden" id="idmodl" name="idmodl" value="" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btmodlocchok" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-modtype" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Type de chambre" : "Room type") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemodiftypech" method="post" action="appajax.php">
						<div class="form-group">
							
							<label for="modtype" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Libellé" : "Label") ?></label>
							<input type="text" class="form-control"  value="" id="modtype" name="modtype" />		
						</div>
						
						
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								<input type="hidden" id="action" name="action" value="mod-type-ch" />
								<input type="hidden" id="idmodt" name="idmodt" value="" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btmodtypechok" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-desc-sejour" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-commenting-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Informations du séjour" : "Stay informations") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulaireinfsejour" method="post" action="appajax.php">
						
						<div class="form-group">
							<div class="col-md-12">
								<textarea id="infsejour" name="infsejour" class="ckeditor"></textarea>
							</div>
						</div>
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								
								<input type="hidden" id="action" name="action" value="save-inf-sejour" />
								<input type="hidden" id="idmandsejour" name="idmandsejour" value="0" />

								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btsaveinfsejour" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
							</div>
						</div>
					</form>				
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>

	<div id="modal-desc-sejour-eng" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-commenting-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Informations du séjour" : "Stay informations") ?></h2>
				</div>
				<!-- END Modal Header -->

				<!-- Modal Body -->
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulaireinfsejoureng" method="post" action="appajax.php">
						
						<div class="form-group">
							<div class="col-md-12">
								<textarea id="infsejoureng" name="infsejoureng" class="ckeditor"></textarea>
							</div>
						</div>
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">															
								
								<input type="hidden" id="action" name="action" value="save-inf-sejour-eng" />
								<input type="hidden" id="idmandsejoureng" name="idmandsejoureng" value="0" />

								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
								<button class="btn btn-sm btn-primary" id="btsaveinfsejoureng" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
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

<?php include 'including/footPage.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="jscript/helpers/excanvas.min.js"></script><![endif]-->

<script src="jscript/jsplug.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>

<script>	
		$(document).ready(function() {

			$('.toggle-password').click(function () {
				const passwordInput = $('#api_password');

				// Basculer entre type 'password' et 'text'
				const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
				passwordInput.attr('type', type);

				// Modifier le texte ou l'icône du bouton
				$(this).text(type === 'password' ? '👁️' : '🙈');
			});
		
			// $(document).on('change', '#regular_clean', function(){
			// 	$.post('appajax.php', 
			// 		{
			// 			action: 'color-room',
			// 			color:$(this).val() ,
			// 			app:'regular',
			// 		}, function(resp) {
			// 		if (resp.responseAjax == "SUCCESS") {
						
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
			// 	return false
			// })

			// $(document).on('change', '#complet_clean', function(){
			// 	$.post('appajax.php', 
			// 		{
			// 			action: 'color-room',
			// 			color:$(this).val() ,
			// 			app:'complet',
			// 		}, function(resp) {
			// 		if (resp.responseAjax == "SUCCESS") {
						
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
			// 	return false
			// })

			// $(document).on('change', '#wait_clean', function(){
			// 	$.post('appajax.php', 
			// 		{
			// 			action: 'color-room',
			// 			color:$(this).val() ,
			// 			app:'waitclean',
			// 		}, function(resp) {
			// 		if (resp.responseAjax == "SUCCESS") {
						
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
			// 	return false
			// })

			function displayVars(){
				if($('#typemodel').val() == '0'){
					$('[data-src="F"]').show()
					$('[data-src="Customer"]').show()
					$('[data-src="Soc"]').show()
					$('[data-src="User"]').show()
					$('[data-src="D"]').show()
				}

				if($('#typemodel').val() == '1'){
					$('[data-src="F"]').show()
					$('[data-src="Customer"]').show()
					$('[data-src="Soc"]').show()
					$('[data-src="User"]').show()
					
					$('[data-src="D"]').hide()
				}

				if($('#typemodel').val() == '2'){
					$('[data-src="D"]').show()
					$('[data-src="Customer"]').show()
					$('[data-src="Soc"]').show()
					$('[data-src="User"]').show()
					
					$('[data-src="F"]').hide()
				}

				if($('#typemodel').val() == '3' || $('#typemodel').val() == '4'){
					$('[data-src="Customer"]').show()
					$('[data-src="Soc"]').show()
					$('[data-src="User"]').show()
					
					$('[data-src="D"]').hide()
					$('[data-src="F"]').hide()
				}

				if($('#typemodel').val() == '5' || $('#typemodel').val() == '6'){
					$('[data-src="Customer"]').show()
					$('[data-src="Soc"]').show()
					$('[data-src="User"]').show()
					
					$('[data-src="D"]').show()
					$('[data-src="F"]').hide()
				}
				
			}

			$('#sej_duplique').click(function(){
				if(!confirm('---- !!! ATENTION !!! ----\nSi des chambres existent pour ce séjour, elles seront remplacées par celles du modèle choisi\nCONFIRMEZ VOTRE CHOIX')){
					return false
				}
				HoldOn.open();
				$.post('appajax.php', 
					{
						action: 'duplique-chambres',
						idsejduplique:$('#id_sej_duplique').val() ,
					}, function(resp) {
					if (resp.responseAjax == "SUCCESS") {
						$('#list_chambres').trigger("reloadGrid",[{current:true}]);
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

			$(document).on('change','#typemodel', function(){
				HoldOn.open();
				$.post('appajax.php', 
					{
						action: 'ctrl-type',
						type:$('#typemodel').val() ,
					}, function(resp) {
					if (resp.responseAjax == "SUCCESS") {
						displayVars()	
					}
					else {
						$('#typemodel').val('0').change()
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


			$(document).on('click','.clsvar', function(){
				CKEDITOR.instances['msg'].insertHtml($(this).attr('data-var'));
			})

			$(document).on('click','.clsvarsms', function(){
				var curPos =
				document.getElementById("msgsms").selectionStart;
				let x= $('#msgsms').val(); 
				$('#msgsms').val(x.slice(0,curPos)+$(this).attr('data-var')+x.slice(curPos));
				// $('#msgsms').insertHtml($(this).attr('data-var'));
			})

			$('.nav-tabs').on("click", "li", function (event) {         
				var activeTab = $(this).find('a').attr('href');
				if(activeTab == '#chb'){
					// $('#list_chambres').trigger("reloadGrid",[{current:true}])
					setTimeout(() => {
						$.get('settings.php', {refreshCh: 'CH'}, function(resp) {
						$('#htmlChb').html(resp.html);
						}, 'json');

						return false;
					}, 1000);
				}
			});

			$('#kd').change(function(){
				console.log('isact')
				$('.isact').addClass('active');
			})

			$('#gene').change(function(){
				console.log('isactgene')
				$('.isactgene').addClass('active');
			})

			$('#formulairesoc').submit(function() {
				
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
							$('#formulairesoclogo').css('display', 'block');
							$('#formulairesocsign').css('display', 'block');
							$('#formulairesocfond').css('display', 'block');
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

			$('#formulairesoclogo').submit(function() {
				
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
							$('#imglogo').attr('src', resp.logo);
							
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

			$('#formulairesocsign').submit(function() {
				
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
							$('#imgsign').attr('src', resp.sign);
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

			$('#formulairesocfond').submit(function() {
				
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
							$('#imgfond').attr('src', resp.fond);
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

			$('#formulaireapi').submit(function() {
				
				HoldOn.open();
				jQuery(this).ajaxSubmit({
					dataType: 'json',
					data : {
						is_mail_api: ($('#is_mail_api').is(':checked') ? '1' : '0'),
						is_sms_api: ($('#is_sms_api').is(':checked') ? '1' : '0'),
					},
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
							$('#imgfond').attr('src', resp.fond);
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

			$(document).on('click', '#btrefreshsettings', function(){
				window.location.reload(true); 
			})
			
			$(document).on('change','#opt_lib_1, #opt_lib_2, #opt_lib_3, #opt_lib_4, #opt_lib_5',function(){
				$.post('appajax.php', {action: 'tarif-supp-ch', opt1:$('#opt_lib_1').val() , opt2:$('#opt_lib_2').val(), opt3:$('#opt_lib_3').val(), opt4:$('#opt_lib_4').val() , opt5:$('#opt_lib_5').val()}, function(resp) {
					if (resp.responseAjax == "SUCCESS") {
						$('#tarif_chambre').val(resp.tarif)

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

			$(document).on('click','.btmodtypech', function(){
				$('#modtype').val($(this).attr('data-lib-type'))
				$('#idmodt').val($(this).attr('data-id-type'));

				$('#modal-modtype').modal();
				return false;
			})

			
			$('#btmodtypechok').click(function() {
				HoldOn.open();
				$('#formulairemodiftypech').ajaxSubmit({
					dataType:'json',
					data:{},
					success : function (resp) {	
						HoldOn.close();
						if (resp.responseAjax == 'SUCCESS') {	
							
							$('#type'+$('#idmodt').val()).html('<span class="columnClass">'+resp.lib+'</span>');

							var objloc = $('#lgtype'+$('#idmodt').val()).children().find('a').attr('data-lib-type',resp.lib);

							$('#modal-modtype').modal('hide');
						}
						else
						$.bootstrapGrowl('<h4>ERREUR!</h4> <p>'+resp.message+'</p>', {
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
				}); HoldOn.close();
				return false;
			})
			
			$('#btmodlocchok').click(function() {
				HoldOn.open();
				$('#formulairemodiflocch').ajaxSubmit({
					dataType:'json',
					data:{},
					success : function (resp) {	
						HoldOn.close();
						if (resp.responseAjax == 'SUCCESS') {	
							$('#loc'+$('#idmodl').val()).html('<span class="columnClass">'+resp.lib+'</span>');

							var objloc = $('#lgloc'+$('#idmodl').val()).children().find('a').attr('data-lib-loc',resp.lib);
				
							$('#modal-modloc').modal('hide');
						}
						else
						$.bootstrapGrowl('<h4>ERREUR!</h4> <p>'+resp.message+'</p>', {
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
				}); HoldOn.close();
				return false;
			})

			$(document).on('click','.btdeltypech', function(){
				if(!confirm('Confirmez la suppression de la ligne')){
					return false;
				}
				var idtypech = $(this).attr('data-id-type');
				console.log('jj',idtypech)
				HoldOn.open()
				$.post('appajax.php', {
					action:'del-type-ch', 
					idtypech: idtypech,
					
					}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('table tr#lgtype'+idtypech).remove();
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
				
				}, 'json');	
				HoldOn.close();
				return false;
			})

			$(document).on('click','.btmodlocch', function(){
				$('#modloc').val($(this).attr('data-lib-loc'))
				
				$('#idmodl').val($(this).attr('data-id-loc'));
				$('#modal-modloc').modal();
				return false;
			})

			$(document).on('click','.btdellocch', function(){
				if(!confirm('Confirmez la suppression de la ligne')){
					return false;
				}
				var idlocch = $(this).attr('data-id-loc');

				HoldOn.open()
				$.post('appajax.php', {
					action:'del-loc-ch', 
					idlocch: idlocch,
					
					}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('table tr#lgloc'+idlocch).remove();
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
				
				}, 'json');	
				HoldOn.close();
				return false;
			})

			$(document).on('click','.btaddtypech', function(){
				$('#modal-type-ch').modal();
				return false;
			})

			$(document).on('click','.btaddlocch', function(){
				$('#modal-loc-ch').modal();
				return false;
			})

			$('#btaddtypechok').click(function() {
				HoldOn.open();
				$('#formulairetypech').ajaxSubmit({
					dataType:'json',
					data:{lib:$('#type').val()},
					success : function (resp) {	
						HoldOn.close();
						if (resp.responseAjax == 'SUCCESS') {	
							// $.bootstrapGrowl('<h4>Confirmation!</h4> <p>'+resp.message+'</p>', {
							// 	type: 'success',
							// 	delay: 5000,
							// 	offset: {
							// from: "top",
							// amount: 100
							// 	},
							// 	align: "center",
							// allow_dismiss: true
							// });
							$('#typeCh').append(resp.addtr);
							// ('#typeCh').DataTable().ajax.reload();
						}
						else
						$.bootstrapGrowl('<h4>ERREUR!</h4> <p>'+resp.message+'</p>', {
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
							
				$('#modal-type-ch').modal('hide');
				return false;			
			});

			$('#btaddlocchok').click(function() {
				HoldOn.open();
				$('#formulairelocch').ajaxSubmit({
					dataType:'json',
					data:{lib:$('#loc').val()},
					success : function (resp) {	
						HoldOn.close();
						if (resp.responseAjax == 'SUCCESS') {	
							// $.bootstrapGrowl('<h4>Confirmation!</h4> <p>'+resp.message+'</p>', {
							// 	type: 'success',
							// 	delay: 5000,
							// 	offset: {
							// from: "top",
							// amount: 100
							// 	},
							// 	align: "center",
							// allow_dismiss: true
							// });
							
							$('#locCh').append(resp.addtr);
							// $('#locCh').DataTable().ajax.reload();
						}
						else
						$.bootstrapGrowl('<h4>ERREUR!</h4> <p>'+resp.message+'</p>', {
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
							
				$('#modal-loc-ch').modal('hide');
				return false;			
			});

			
			$('#typeCh').DataTable({     
			"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
				"iDisplayLength": 5,
				"bFilter": false
			});

			$('#locCh').DataTable({     
			"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
				"iDisplayLength": 5,
				"bFilter": false
			});

			var valinf = 0;
			var nameinf = '';

			function manageMail(){
				
				$.post('appajax.php', {action: 'modif-inf-gene', nameinf: nameinf, valinf:valinf }, function(resp) {
					// HoldOn.open();
					if (resp.responseAjax == "SUCCESS") {
						// HoldOn.close();
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
						// HoldOn.close();
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
					
			};

			function manageTarif(){
				if(!$('#istarifnuit').is(':checked') && !$('#istarifsemaine').is(':checked') && !$('#istarifsejour').is(':checked')){
					valinf = 1;
					nameinf = 'is_tarif_sejour'
					$('#istarifsejour').prop('checked', true)
					alert('Vous devez avoir un type de tarification\r\nPar defaut il s\'agit du tarif Sejour')
					
				}
				
				$.post('appajax.php', {action: 'modif-inf-gene', nameinf: nameinf, valinf:valinf }, function(resp) {
					// HoldOn.open();
					if (resp.responseAjax == "SUCCESS") {
						// HoldOn.close();
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
						// HoldOn.close();
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
					
			};

			$('#islisteopts').click(function(){
				if($('#islisteopts').is(':checked')){
					valinf = 1;
					nameinf = 'is_list_opts'
				}else{
					valinf = 0;
					nameinf = 'is_list_opts'
				}
				
				$.post('appajax.php', {action: 'modif-inf-gene', nameinf: nameinf, valinf:valinf }, function(resp) {
					// HoldOn.open();
					if (resp.responseAjax == "SUCCESS") {
						// HoldOn.close();
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
						// HoldOn.close();
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
			})

			
			$('#isautomail').click(function(){
				if($('#isautomail').is(':checked')){
					valinf = 1;
					nameinf = 'is_auto_mail'
				}else{
					valinf = 0;
					nameinf = 'is_auto_mail'
				}
				manageMail()
			})

			
			$('#isdecimal').click(function(){
				if($('#isdecimal').is(':checked')){
					valinf = 1;
					nameinf = 'is_decimal'
				}else{
					valinf = 0;
					nameinf = 'is_decimal'
				}
				manageTarif()
			})

			$('#istarifnuit').click(function(){
				if($('#istarifnuit').is(':checked')){
					valinf = 1;
					nameinf = 'is_tarif_nuit'

					$('#istarifsemaine').prop('checked', false)
					$('#istarifsejour').prop('checked', false)
				}
				manageTarif()
			})
			$('#istarifsemaine').click(function(){
				if($('#istarifsemaine').is(':checked')){
					valinf = 1;
					nameinf = 'is_tarif_semaine'
					
					$('#istarifnuit').prop('checked', false)
					$('#istarifsejour').prop('checked', false)
				}
				manageTarif()
			})
			$('#istarifsejour').click(function(){
				if($('#istarifsejour').is(':checked')){
					valinf = 1;
					nameinf = 'is_tarif_sejour'
							
					$('#istarifsemaine').prop('checked', false)
					$('#istarifnuit').prop('checked', false)
				}
				manageTarif()
			})


			$('#iscapacityauto').click(function(){
				
				if($('#iscapacityauto').is(':checked')){
					valinf = 1;
					nameinf = 'is_capacite_auto';
				}else{
					valinf = 0;
					nameinf = 'is_capacite_auto';
				}
				$.post('appajax.php', {action: 'modif-inf-gene', nameinf: nameinf, valinf:valinf }, function(resp) {
					// HoldOn.open();
					if (resp.responseAjax == "SUCCESS") {
						// HoldOn.close();
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
						// HoldOn.close();
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
			})

			// --- htag avec gestion du keypress ne fonctionne pas sur class ckeditor ------
			var frommail;
			$('#msg').keypress(function(e) {
				frommail = $(this);
				if (frommail.attr('id') == 'msg')
					$('#hashtaglst').detach().appendTo('.blctxtcomment');
				
				if (e.which == 35) {		
								
					var element = $(this)[0];
					var coordinates = getCaretCoordinates(element, element.selectionEnd, { debug: true });
					$('#hashtaglst').css('top', element.offsetTop - element.scrollTop + coordinates.top + 'px');
					$('#hashtaglst').css('left', element.offsetLeft - element.scrollLeft + coordinates.left + 10 + 'px');
					$('#hashtaglst li').show();
					$('#hashtaglst li').removeClass('lisel');
					$('#hashtaglst li:first').addClass('lisel');
					$('#hashtaglst').show();	
					setTimeout(function() {
						$('#txtsearchusr').focus();
					}, 200);
				}
				else
					$('#hashtaglst').hide();
			});


			$('#hashtaglst li').click(function() {
				var cursorPos = frommail.prop('selectionStart');
				var v = frommail.val();
				var textBefore = v.substring(0,  cursorPos);
				var textAfter  = v.substring(cursorPos, v.length);
				var cursel = $(this);
				frommail.val(textBefore + cursel.text()+ '. ' + textAfter);	
				$('#hashtaglst').hide();
				frommail.focus();
			});

			$('#msg').click(function() {
				$('#hashtaglst').hide();
				frommail.focus();
			});

			$('#txtsearchusr').keydown(function(e) {
				console.log(e.which);
				if (e.which == 40) {
					var cursel = $('#hashtaglst li.lisel');					
					if (cursel.nextAll('li:visible').length > 0) {
						$('#hashtaglst li').removeClass('lisel');
						cursel.nextAll('li:visible').first().addClass('lisel');
					}
				}
				else
				if (e.which == 38) {
					var cursel = $('#hashtaglst li.lisel');					
					if (cursel.prevAll('li:visible').length > 0) {
						$('#hashtaglst li').removeClass('lisel');
						cursel.prevAll('li:visible').first().addClass('lisel');
					}
				}
				else
				if (e.which == 13) {
					var cursorPos = frommail.prop('selectionStart');
					var v = frommail.val();
					var textBefore = v.substring(0,  cursorPos);
					var textAfter  = v.substring(cursorPos, v.length);
					var cursel = $('#hashtaglst li.lisel');
					frommail.val(textBefore + cursel.text() +'. '+ textAfter);	
					$('#hashtaglst').hide();
					frommail.focus();
					e.stopPropagation();
					e.preventDefault();					
					return false;
				}
				else
				if (e.which == 27) {
					$('#hashtaglst').hide();
					frommail.focus();
				}
				else {
					setTimeout(function() {
						$('#hashtaglst li').show();
						if ($('#txtsearchusr').val() != '') {
							$('#hashtaglst li').each(function() {
								if ($(this).text().toLowerCase().indexOf($('#txtsearchusr').val().toLowerCase()) == -1)
									$(this).hide();
							});
							$('#hashtaglst li').removeClass('lisel');
							$('#hashtaglst li:first').addClass('lisel');
						}
					}, 100);
				}

			});

			// --- htag ------

			$(document).on('click','.btinfsejour', function(){
				console.log('jj')
				var idmandsejour = $(this).attr('data-id');

				HoldOn.open()
				$.post('appajax.php', {
					action:'show-inf-sejour', 
					idmandsejour: idmandsejour,
					
					}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('#infsejour').val(resp.infsejour)
						CKEDITOR.instances.infsejour.setData(resp.infsejour);

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
				
				}, 'json');	

				$('#modal-desc-sejour').modal();
				$('#idmandsejour').val(idmandsejour)
				
				return false;
			})

			$(document).on('click','.btinfsejourENG', function(){
				
				var idmandsejour = $(this).attr('data-id');

				HoldOn.open()
				$.post('appajax.php', {
					action:'show-inf-sejour-eng', 
					idmandsejoureng: idmandsejour,
					
					}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('#infsejoureng').val(resp.infsejour)
						CKEDITOR.instances.infsejoureng.setData(resp.infsejour);

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
				
				}, 'json');	

				$('#modal-desc-sejour-eng').modal();
				$('#idmandsejoureng').val(idmandsejour)
				
				return false;
			})

			
			$('#btsaveinfsejour').click(function() {
				HoldOn.open();
				$('#formulaireinfsejour').ajaxSubmit({
					dataType:'json',
					data:{infsejour:CKEDITOR.instances['infsejour'].getData()},
					success : function (resp) {	
						HoldOn.close();
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
							$('#modal-desc-sejour').modal('hide');
						}
						else
						$.bootstrapGrowl('<h4>ERREUR!</h4> <p>'+resp.message+'</p>', {
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
			
			$('#btsaveinfsejoureng').click(function() {
				HoldOn.open();
				$('#formulaireinfsejoureng').ajaxSubmit({
					dataType:'json',
					data:{infsejoureng:CKEDITOR.instances['infsejoureng'].getData()},
					success : function (resp) {	
						HoldOn.close();
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
							$('#modal-desc-sejour-eng').modal('hide');
						}
						else
						$.bootstrapGrowl('<h4>ERREUR!</h4> <p>'+resp.message+'</p>', {
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

			$('#age_bb').keyup(function(){
				if(isNaN(parseInt($('#age_bb').val()))){
					$('#iddebageenf').text(1)
				}else{
					$('#iddebageenf').text(parseInt($('#age_bb').val()) + 1)
				}
				
			})
			$('#age_enfant').keyup(function(){
				if(isNaN(parseInt($('#age_enfant').val()))){
					$('#age_adulte').val(1)
				}else{
					$('#age_adulte').val(parseInt($('#age_enfant').val()) + 1)
				}
				
			})


			$('#btvalideages').click(function(){
				HoldOn.open()
				$.post('appajax.php', {
					action:'maj-ages-tarifs', 
					ageadulte:$('#age_adulte').val(),
					ageenfant:$('#age_enfant').val(),
					agebb:$('#age_bb').val(),
					
					}, function(resp) {
					HoldOn.close();
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
				
				}, 'json');	
			})

			
			$('#btaddmailtype').click(function() {
				
				$('[data-src="F"]').show()
				$('[data-src="Customer"]').show()
				$('[data-src="Soc"]').show()
				$('[data-src="User"]').show()
				$('[data-src="D"]').show()
				
				
				$('#id_mailtype').val('0');
				$('#name_mailtype').val('');
				$('#subject').val('');
				$('#msg').val('');
				
				CKEDITOR.instances.msg.setData('');
				$('#attacheddocs').text('');
				$('#modal-msg-mail').modal();
				return false;
			});

			$('#btsavemailtype').click(function() {
				HoldOn.open();
				$('#formulairemsgdoc').ajaxSubmit({
					dataType:'json',
					data:{
						msg:CKEDITOR.instances['msg'].getData(),
						typemodel:$('#typemodel').val(),
						errExt:errExt,
					},
					success : function (resp) {	
						HoldOn.close();
						if (resp.responseAjax == 'SUCCESS') {					
							$('#list_mailtypes').trigger("reloadGrid",[{page:1}]);
							$('#modal-msg-mail').modal('hide');
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
			
			
			var errExt = [];

			$(document).on('click', '.btupdmailtype', function() {
				errExt = [];
				var idmt = $(this).attr('data-id');
				HoldOn.open();
				$.post('appajax.php', {action:'affiche-mailtype', id_mailtype:idmt}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						
						$('#id_mailtype').val(idmt);
						$('#name_mailtype').val(resp.data.name_mailtype);
						$('#subject').val(resp.data.subject);
						$('#msg').val(resp.data.msg);
						$('#typemodel').val(resp.data.type_mail);
						$('#dest_mail_type').val(resp.data.dest_mail_type);
						CKEDITOR.instances.msg.setData(resp.data.msg);
						$('#attachclr').val('0');
						if (resp.data.attach != ''){
							$('#attacheddocs').html('<u>Pièces jointes</u> : ' + JSON.parse(resp.data.attach).join(", "));
						}else{
							$('#attacheddocs').text('');
						}
						displayVars()
						$('#modal-msg-mail').modal();
					}
					else
						alert(resp.message);
					
					$('.tooltip.in').remove();
				}, 'json');	
			});
			
			$(document).on('click', '.btdelmailtype', function() {
				if (!confirm('Suppression du mail type ?'))
					return false;
					
				var idmt = $(this).attr('data-id');
				HoldOn.open();
				$.post('appajax.php', {action:'del-mailtype', id_mailtype:idmt}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('#list_mailtypes').trigger("reloadGrid",[{page:1}]);
					}
					else
						alert(resp.message);
					
					$('.tooltip.in').remove();
				}, 'json');	

				return false;
			});


			$('#btadddoc').click(function() {
				$('#fileadd').click();
				return false;
			});
			$('#btdeldoc').click(function() {
				$('#fileadd').val('');
				$('#attacheddocs').text('');
				$('#attachclr').val('1');
				return false;
			})


			$('#fileadd').change(function() {

				errExt=[];
				var str = '';
				var files = $(this).prop("files")
				var names = $.map(files, function(val) {
					return val.name;
				});
				
				HoldOn.open();
				$.post('appajax.php', {
					action:'ctrl-ext-files', 
					names:names,					
				}, function(resp) {
					HoldOn.close();
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

							$.each(names, function(i, name) {
								str += str == '' ? name : ', ' + name;
							});

							$('#attacheddocs').html(str != '' ? '<u>Pièces jointes</u> : ' + str : '');
							$('#attachclr').val('0');
							
						}
					else{
						HoldOn.close();
						$.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
							type: 'danger',
							delay: 7000,
							offset: {
								from: "top",
								amount: 100
							},
							align: "center",
							allow_dismiss: true
						});
						errExt = resp.idx;
						console.log(errExt)
						return false;
					}
				
				}, 'json');	
				
				HoldOn.close();

				
			});

			$('#btaddsmstype').click(function() {
				$('#id_smstype').val('0');
				$('#name_smstype').val('');
				$('#msgsms').val('');
				$('#modal-sms').modal();
				return false;
			});

			$('#btsavesmstype').click(function() {
				HoldOn.open();
				console.log('')
				$('#formulairesms').ajaxSubmit({
					dataType:'json',
					data:{
						msg:$('#msgsms').val(),
					}, //{msg:CKEDITOR.instances['msgsms'].getData()},
					success : function (resp) {	
						HoldOn.close();
						if (resp.responseAjax == 'SUCCESS') {					
							$('#list_smstypes').trigger("reloadGrid",[{page:1}]);
							$('#modal-sms').modal('hide');
						}
						else
							alert(resp.message);									
					},
					error : function() {
						HoldOn.close();
					}
				}); 
				
				return false;			
			});


			$(document).on('click', '.btupdsmstype', function() {
				var idmt = $(this).attr('data-id');
				HoldOn.open();
				$.post('appajax.php', {action:'show-smstype', id_smstype:idmt}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						
						$('#id_smstype').val(idmt);
						$('#name_smstype').val(resp.data.name_smstype);
						
						$('#msgsms').val(resp.msg);
						
						// CKEDITOR.instances.msgsms.setData(resp.data.msg);
						$('#modal-sms').modal();
					}
					else
						alert(resp.message);
					
					$('.tooltip.in').remove();
				}, 'json');	
				
				return false;
			});
			
			$(document).on('click', '.btdelsmstype', function() {
				if (!confirm('Suppression du SMS type ?'))
					return false;
					
				var idmt = $(this).attr('data-id');
				HoldOn.open();
				$.post('appajax.php', {action:'del-smstype', id_smstype:idmt}, function(resp) {
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {
						$('#list_smstypes').trigger("reloadGrid",[{page:1}]);
					}
					else
						alert(resp.message);
					
					$('.tooltip.in').remove();
				}, 'json');	

				return false;
			});

		});
	
</script>
