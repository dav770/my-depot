<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
include '../including/dbclass.php';

require_once 'libry/sellsign/vendor/autoload.php';

global $usrActif;
function verifAccess($usr)
{
	$respUsr = UsrApp::whatIsProfile($usr);
}

		
$arrAccess['isAdmin'] = ($respUsr == '' ? '1' : '0');
$arrAccess['visu_stats'] = ($respUsr == '' ? '1' : $respUsr->visu_stats);
$arrAccess['valide_stats'] = ($respUsr == '' ? '1' : $respUsr->valide_stats);
$arrAccess['valide_repas'] = ($respUsr == '' ? '1' : $respUsr->valide_repas);
$arrAccess['print_repas'] = ($respUsr == '' ? '1' : $respUsr->print_repas);
$arrAccess['visu_calendar_rappel'] = ($respUsr == '' ? '1' : $respUsr->visu_calendar_rappel);
$arrAccess['acces_page_client_calendar_rappel'] = ($respUsr == '' ? '1' : $respUsr->acces_page_client_calendar_rappel);
$arrAccess['visu_table'] = ($respUsr == '' ? '1' : $respUsr->visu_table);
$arrAccess['add_table'] = ($respUsr == '' ? '1' : $respUsr->add_table);
$arrAccess['add_obj_table'] = ($respUsr == '' ? '1' : $respUsr->add_obj_table);
$arrAccess['visu_client'] = ($respUsr == '' ? '1' : $respUsr->visu_client );
$arrAccess['create_client'] = ($respUsr == '' ? '1' : $respUsr->create_client );
// $arrAccess['import_client'] = ($respUsr == '' ? '1' : $respUsr->import_client );
$arrAccess['email_libre'] = ($respUsr == '' ? '1' : $respUsr->email_libre );
$arrAccess['del_client'] = ($respUsr == '' ? '1' : $respUsr->del_client );
$arrAccess['send_mail_client'] = ($respUsr == '' ? '1' : $respUsr->send_mail_client );
$arrAccess['send_sms_client'] = ($respUsr == '' ? '1' : $respUsr->send_sms_client );
$arrAccess['change_statut_client'] = ($respUsr == '' ? '1' : $respUsr->change_statut_client );
$arrAccess['add_rappel_client'] = ($respUsr == '' ? '1' : $respUsr->add_rappel_client );
$arrAccess['print_list_room'] = ($respUsr == '' ? '1' : $respUsr->print_list_room );
$arrAccess['visu_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->visu_fiche_client );
$arrAccess['send_mail_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->send_mail_fiche_client );
$arrAccess['send_sms_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->send_sms_fiche_client );
$arrAccess['modif_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->modif_fiche_client );
$arrAccess['add_comment_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->add_comment_fiche_client );
$arrAccess['add_rappel_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->add_rappel_fiche_client );
$arrAccess['add_doc_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->add_doc_fiche_client );
$arrAccess['send_doc_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->add_doc_fiche_client );
$arrAccess['annule_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->annule_fiche_client );
$arrAccess['imp_doc_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->imp_doc_fiche_client );
$arrAccess['paiement_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->paiement_fiche_client );
$arrAccess['modif_devise_fiche_client'] = ($respUsr == '' ? '1' : $respUsr->modif_devise_fiche_client );
$arrAccess['visu_planning_ch'] = ($respUsr == '' ? '1' : $respUsr->visu_planning_ch );
$arrAccess['visu_mail_inbox'] = ($respUsr == '' ? '1' : $respUsr->visu_mail_inbox );
$arrAccess['send_mail_inbox'] = ($respUsr == '' ? '1' : $respUsr->send_mail_inbox );
$arrAccess['visu_mail_outbox'] = ($respUsr == '' ? '1' : $respUsr->visu_mail_outbox );
$arrAccess['send_mail_outbox'] = ($respUsr == '' ? '1' : $respUsr->send_mail_outbox );
$arrAccess['visu_infos_stripe'] = ($respUsr == '' ? '1' : $respUsr->visu_infos_stripe );
$arrAccess['visu_settings'] = ($respUsr == '' ? '1' : $respUsr->visu_settings );
$arrAccess['modif_sejour'] = ($respUsr == '' ? '1' : $respUsr->modif_sejour );
$arrAccess['modif_statut_sec'] = ($respUsr == '' ? '1' : $respUsr->modif_statut_sec );
$arrAccess['modif_profil'] = ($respUsr == '' ? '1' : $respUsr->modif_profil );
$arrAccess['modif_tarifs'] = ($respUsr == '' ? '1' : $respUsr->modif_tarifs );
$arrAccess['modif_type_loc'] = ($respUsr == '' ? '1' : $respUsr->modif_type_loc );
$arrAccess['modif_chambre'] = ($respUsr == '' ? '1' : $respUsr->modif_chambre );
$arrAccess['modif_fournisseur'] = ($respUsr == '' ? '1' : $respUsr->modif_fournisseur );
$arrAccess['modif_unite'] = ($respUsr == '' ? '1' : $respUsr->modif_unite );
$arrAccess['modif_stock_produit'] = ($respUsr == '' ? '1' : $respUsr->modif_stock_produit );
$arrAccess['modif_plat'] = ($respUsr == '' ? '1' : $respUsr->modif_plat );
$arrAccess['modif_plat_details'] = ($respUsr == '' ? '1' : $respUsr->modif_plat_details );
$arrAccess['modif_menu'] = ($respUsr == '' ? '1' : $respUsr->modif_menu );
$arrAccess['modif_mail_type'] = ($respUsr == '' ? '1' : $respUsr->modif_mail_type );
$arrAccess['modif_sms_type'] = ($respUsr == '' ? '1' : $respUsr->modif_sms_type );
$arrAccess['visu_enfants'] = ($respUsr == '' ? '1' : $respUsr->visu_enfants );
$arrAccess['visu_monos'] = ($respUsr == '' ? '1' : $respUsr->visu_monos );
$arrAccess['visu_plannig_chambre'] = ($respUsr == '' ? '1' : $respUsr->visu_plannig_chambre );
$arrAccess['link_chambre'] = ($respUsr == '' ? '1' : $respUsr->link_chambre );
$arrAccess['visu_cmd_fournisseur'] = ($respUsr == '' ? '1' : $respUsr->visu_cmd_fournisseur );
$arrAccess['add_rapp_cmd'] = ($respUsr == '' ? '1' : $respUsr->add_rapp_cmd );
$arrAccess['add_cmd'] = ($respUsr == '' ? '1' : $respUsr->add_cmd );
$arrAccess['send_mail_fournisseur'] = ($respUsr == '' ? '1' : $respUsr->send_mail_fournisseur );
$arrAccess['print_cmd_fournisseur'] = ($respUsr == '' ? '1' : $respUsr->print_cmd_fournisseur );
$arrAccess['visu_rglt'] = ($respUsr == '' ? '1' : $respUsr->visu_rglt );
$arrAccess['add_rglt'] = ($respUsr == '' ? '1' : $respUsr->add_rglt );
$arrAccess['modif_rglt'] = ($respUsr == '' ? '1' : $respUsr->modif_rglt );
$arrAccess['duplique_sejour'] = ($respUsr == '' ? '1' : $respUsr->duplique_sejour );
$arrAccess['edit_clean_room'] = ($respUsr == '' ? '1' : $respUsr->edit_clean_room );
$arrAccess['add_client_calendar_rappel'] = ($respUsr == '' ? '1' : $respUsr->add_client_calendar_rappel );
$arrAccess['extra'] = ($respUsr == '' ? '1' : $respUsr->extra );
$arrAccess['visu_bar'] = ($respUsr == '' ? '1' : $respUsr->bar );
// $arrAccess['modif_kid_club'] = ($respUsr == '' ? '1' : $respUsr->modif_kid_club );

use GuzzleHttp\Client;

if (isset($_POST['action'])) {
	$action = $_POST['action'];

	if ($action != 'sign-in' && $action != 'code-demo' && $action != 'clear-demo') {
		session_start();
		if (!isset($_SESSION['loginUsr'])) {
			echo 'Error login : '.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ACCES REFUSE' : 'ACCESS DENIED');
			die;
		} else
			$usrActif = unserialize($_SESSION['user_actif']);
	}

	$URL = 'https://crm-hotel.dev-customer.com/Dashboard/';
	$PUBURL = 'https://crm-hotel.dev-customer.com';

	function convertToPdf($inputPath, $outputPath) {
		$command = "soffice --headless --convert-to pdf --outdir " . escapeshellarg(dirname($outputPath)) . " " . escapeshellarg($inputPath);
		exec($command, $output, $returnCode);
		return $returnCode === 0 ? $outputPath : false;
	}

	function textToPdf($inputPath, $outputPath) {
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 12);
	
		$content = file_get_contents($inputPath);
		$pdf->MultiCell(0, 10, $content);
	
		$pdf->Output($outputPath, 'F');
		return $outputPath;
	}

	function imageToPdf($imagePath, $pdfPath) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image($imagePath, 10, 10, 190);
        $pdf->Output($pdfPath, 'F');
		if (!file_exists($pdfPath)) {
			throw new Exception("Erreur lors de la conversion de l'image en PDF : " . $pdfPath);
		}
		// echo($pdfPath);
        return $pdfPath;
    }

	switch ($action) {
		case 'clear-demo':
			
			$user = UsrApp::findOne(array('email' =>'demo@azuro.com'));
			
			if(UsrApp::update(array('codedemo'=>''), array('id_usrApp'=>$user->id_usrApp))){
				respAjax::successJSON(array('OK' => 'OK'));
			}else{
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ancien code demo non supprimé' : 'Old code demo not deleted')));
			}

			break;

		case 'code-demo':
			
			$user = UsrApp::findOne(array('email' =>'demo@azuro.com'));
			$userAdmin = UsrApp::findOne(array('email' =>'admin@azuro.com'));
			
			$codedemo = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
			
			$prof = Profil::findSql("SELECT id_profil FROM db_profils WHERE UPPER(name_profil) LIKE'%ADMIN%'", true);

			if(!$user){;
				UsrApp::create(array('email'=>'demo@azuro.com', 'psw'=>'fe01ce2a7fbac8fafaed7c982a04e229', 'user_name'=>'demo', 'id_profil'=>$prof->id_profil, 'codedemo'=>$codedemo));
			}else{
				UsrApp::update(array('email'=>'demo@azuro.com', 'psw'=>'fe01ce2a7fbac8fafaed7c982a04e229', 'user_name'=>'demo', 'id_profil'=>$prof->id_profil, 'codedemo'=>$codedemo), array('id_usrApp'=>$user->id_usrApp));
			}

			if(!$userAdmin){;
				UsrApp::create(array('email'=>'admin@azuro.com', 'psw'=>'9b47bfa12c5a49d018a7a847d0b7b2f0', 'user_name'=>'admindemo', 'id_profil'=>$prof->id_profil));
			}else{
				UsrApp::update(array('email'=>'admin@azuro.com', 'psw'=>'9b47bfa12c5a49d018a7a847d0b7b2f0', 'user_name'=>'admindemo', 'id_profil'=>$prof->id_profil), array('id_usrApp'=>$userAdmin->id_usrApp));
			}
			respAjax::successJSON(array('OK' => 'OK','codedemo'=>$codedemo));
			break;

		case 'sign-in':
			// first connexion
					
			$existSejour = Setting::getAllorganisateurs();
			$existUsers = UsrApp::getAll();
			if($existSejour->num_rows <= 0 || $existUsers->num_rows <= 0){
				respAjax::successJSON(array('OK' => 'OK', 'new'=>'1'));
			}

			if (!Ctrl::ctrlflds($_POST, array('email', 'psw')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Champs obligatoires manquants' : 'Missing mandatory fields')));

			$sejour = Setting::getAllorganisateurs();
			if((int)$_POST['id_organisateur'] <= 0 && $sejour->num_rows > 0 ){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du séjour obligatoire' : 'Choice of stay, require')));
			}

			$user = UsrApp::findOne(array('email' => $_POST['email']));
			
			if (!$user) {
				CrmAction::create(array('id_usrApp' => '0', 'type_action' => 'LOGIN ECHEC EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $_POST['email']));
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur non enregistré' : 'Unregistered User')));
			}
			
			if(trim($_POST['email']) == 'demo@azuro.com'){
				if ($user->psw == md5($_POST['psw']) && $user->codedemo == $_POST['codedemo']) {
					
					session_start();
					$_SESSION['loginUsr'] = true;
					$user->cursoc = (int)$_POST['id_organisateur'];
					$_SESSION['user_actif'] = serialize($user);
					UsrApp::update(array('date_last_login' => date('Y-m-d H:i:s')), array('id_usrApp' => $user->id_usrApp));
					CrmAction::create(array('id_usrApp' => $user->id_usrApp, 'type_action' => 'LOGIN', 'date_action' => date('Y-m-d H:i:s')));
					respAjax::successJSON(array('OK' => 'OK'));
				} else {
					CrmAction::create(array('id_usrApp' => '0', 'type_action' => 'LOGIN ECHEC', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $_POST['email']));
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				}
			}else{
				if ($user->psw == md5($_POST['psw'])) {
					
					session_start();
					$_SESSION['loginUsr'] = true;
					$user->cursoc = (int)$_POST['id_organisateur'];
					$_SESSION['user_actif'] = serialize($user);
					UsrApp::update(array('date_last_login' => date('Y-m-d H:i:s')), array('id_usrApp' => $user->id_usrApp));
					CrmAction::create(array('id_usrApp' => $user->id_usrApp, 'type_action' => 'LOGIN', 'date_action' => date('Y-m-d H:i:s')));
					respAjax::successJSON(array('OK' => 'OK'));
				} else {
					CrmAction::create(array('id_usrApp' => '0', 'type_action' => 'LOGIN ECHEC', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $_POST['email']));
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				}
			}

			break;

		case 'read-contact-details':
			if (!Ctrl::ctrlflds($_POST, array('idct','type')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			
			$res = Fiche::getAllDetails(array('type_detail'=>(int)$_POST['type'], 'id_fiche'=>(int)$_POST['idct']));

			$cptidx = 0;

			$str = '';

			foreach($res as $data){
				$cptidx++;

				$str .= '<div class="form-group" style="box-shadow: 5px 5px 5px 7px '.((int)$_POST['type'] == 1 ? "rgba(56, 239, 125, 0.3)" : ((int)$_POST['type'] == 2 ? "rgba(56, 89, 239, 0.3)" : "rgba(239, 166, 56, 0.3)")).'"><div class="col-md-3">';
				$str .= '<div class="form__group field"><input type="input" class="form__field" placeholder="Name" name="name'.((int)$_POST['type'] == 1 ? "adulte" : ((int)$_POST['type'] == 2 ? "enfant" : "bb")).$cptidx.'" id="name'.((int)$_POST['type'] == 1 ? "adulte" : ((int)$_POST['type'] == 2 ? "enfant" : "bb")).$cptidx.'" value="'.$data['last_name_detail'].'" required /><label for="name" class="form__label">Name</label></div>';
				$str .= '</div>';
				$str .= '<div class="col-md-3">';
				$str .= '<div class="form__group field"><input type="input" class="form__field" placeholder="prénom" name="prenom'.((int)$_POST['type'] == 1 ? "adulte" : ((int)$_POST['type'] == 2 ? "enfant" : "bb")).$cptidx.'" id="prenom'.((int)$_POST['type'] == 1 ? "adulte" : ((int)$_POST['type'] == 2 ? "enfant" : "bb")).$cptidx.'" value="'.$data['first_name_detail'].'" required /><label for="prenom" class="form__label">Prénom</label></div>';
				$str .= '</div>';
				$str .= '<div class="col-md-3">';
				$str .= '<div class="form__group field"><input type="date" class="form__field" placeholder="dd/mm/yyyy"  name="datenaissance'.((int)$_POST['type'] == 1 ? "adulte" : ((int)$_POST['type'] == 2 ? "enfant" : "bb")).$cptidx.'" id="datenaissance'.((int)$_POST['type'] == 1 ? "adulte" : ((int)$_POST['type'] == 2 ? "enfant" : "bb")).$cptidx.'" value="'.$data['date_naissance_detail'].'" required ><label for="datenaissance" class="form__label">Date naissance</label></div>';
				$str .= '</div>';
				$str .= '<div class="col-md-3">';
				$str .= '<div class="form__group field"><a href="#" class="btn btn-sm btn-danger" id="btdel'.$cptidx.'" style="margin-right:10px;border-radius:3px;" title="suppression" data-toggle="tooltip"><i class="fa fa-trash"></i></a></div>';
				$str .= '</div></div>';
			}

			respAjax::successJSON(array('OK' => 'OK', 'data'=>$res, 'str'=>$str));

			break;

		case 'global-search':
			if (!Ctrl::ctrlflds($_POST, array('txt')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Champs obligatoires manquants' : 'Missing mandatory fields')));

			$datas = Search::getSearch($_POST['txt'], $usrActif);
			// echo('-----456>'.print_r(loadSqlArray::objSqlCharge($datas)));
			// 	die;
			CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'RECHERCHE', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $_POST['txt']));
			respAjax::successJSON(array('datas' => loadSqlArray::objSqlCharge($datas)));
			break;

		case 'change-soc':
			if (!Ctrl::ctrlflds($_POST, array('soc')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Champs obligatoires manquants' : 'Missing mandatory fields')));

			$soc_current = $usrActif->cursoc;
			
			$soc = max((int)$_POST['soc'], 1);
			UsrApp::update(array('cursoc' => $soc), array('id_usrApp' => $usrActif->id_usrApp));
			$usrActif->cursoc = $soc;
			$_SESSION['user_actif'] = serialize($usrActif);

			if($soc != $soc_current && $_POST['pagect'] > 0){
				
				$lnk = $_POST['lnk'];
				$pos = strpos($lnk,'#');

				if($pos > 0){
					$lnk2 = substr($lnk,0,strlen($lnk)-1);
					$idct = substr($lnk2,strpos($lnk,'=') + 1);
					
				}else{
					$idct = substr($lnk,strpos($lnk,'=') + 1);
				}

				Fiche::update(array('id_organisateur'=>$soc),array('id_fiche'=>$idct));
			}
			respAjax::successJSON(array('OK' => 'OK', 'curusr'=>$usrActif, 'idct'=>$idct));
			break;

		case 'soc-update':
			// print_r($_FILES);
			// die;
			$arr = array();
			$arr['name_soc'] = $_POST['name_soc'];
			$arr['site_soc'] = $_POST['site_soc'];
			$arr['adr_soc'] = $_POST['adr_soc'];
			$arr['tel_soc'] = $_POST['tel_soc'];
			$arr['post_code_soc'] = $_POST['post_code_soc'];
			$arr['city_soc'] = $_POST['city_soc'];
			$arr['email_soc'] = $_POST['email_soc'];
			$arr['whatsapp_soc'] = $_POST['whatsapp_soc'];
			$arr['is_soc'] = '1';

			$socs = Soc::getAll();
			if($socs->num_rows > 0){
				foreach($socs as $soc){
					if(!Soc::update($arr, array('id_soc'=>$soc['id_soc']))){
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Mistake update')));
					}
				}
			}else{
				if(!Soc::create($arr)){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Insertion échouée' : 'Mistake insert')));
				}
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations enregistrée' : 'Informations saved')));			

			break;
			
		case 'logo-update':

			$dir = __DIR__ . '/uploads/socs/';
			
			if (!is_dir($dir)) {
				mkdir($dir);
				copy(__DIR__ . '/uploads/index.php', $dir . '/index.php');
			}


			$image_file = $_FILES["image_logo"];
			// Image not defined, let's exit
			if (isset($image_file)) {
				// Move the temp image file to the images/ directory
				move_uploaded_file(
					// Temp image location
					$image_file["tmp_name"],
	
					// New image location, __DIR__ is the location of the current PHP file
					__DIR__ . "/uploads/socs/" . $image_file["name"]
				);

				$arr['logo_soc'] =  $image_file["name"];
			}
			
			$socs = Soc::getAll();
			if($socs->num_rows > 0){
				foreach($socs as $soc){
					if(!Soc::update($arr, array('id_soc'=>$soc['id_soc']))){
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Mistake update')));
					}
				}
			}else{
				if(!Soc::create($arr)){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Insertion échouée' : 'Mistake insert')));
				}
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'logo'=>'uploads/socs/'.$image_file["name"], 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations enregistrée' : 'Informations saved')));	

			break;
			
		case 'sign-update':

			$dir = __DIR__ . '/uploads/socs/';
			
			if (!is_dir($dir)) {
				mkdir($dir);
				copy(__DIR__ . '/uploads/index.php', $dir . '/index.php');
			}


			$image_file = $_FILES["image_sign"];
			// Image not defined, let's exit
			if (isset($image_file)) {
				// Move the temp image file to the images/ directory
				move_uploaded_file(
					// Temp image location
					$image_file["tmp_name"],
	
					// New image location, __DIR__ is the location of the current PHP file
					__DIR__ . "/uploads/socs/" . $image_file["name"]
				);

				$arr['sign_soc'] =  $image_file["name"];
			}

			$socs = Soc::getAll();
			if($socs->num_rows > 0){
				foreach($socs as $soc){
					if(!Soc::update($arr, array('id_soc'=>$soc['id_soc']))){
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Mistake update')));
					}
				}
			}else{
				if(!Soc::create($arr)){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Insertion échouée' : 'Mistake insert')));
				}
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'sign'=>'uploads/socs/'.$image_file["name"], 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations enregistrée' : 'Informations saved')));	

			break;
			
		case 'fond-update':

			$dir = __DIR__ . '/uploads/socs/';
			
			if (!is_dir($dir)) {
				mkdir($dir);
				copy(__DIR__ . '/uploads/index.php', $dir . '/index.php');
			}


			$image_file = $_FILES["image_fond"];
			// Image not defined, let's exit
			if (isset($image_file)) {
				// Move the temp image file to the images/ directory
				move_uploaded_file(
					// Temp image location
					$image_file["tmp_name"],
	
					// New image location, __DIR__ is the location of the current PHP file
					__DIR__ . "/uploads/socs/" . $image_file["name"]
				);

				$arr['img_fond_soc'] =  $image_file["name"];
			}

			$socs = Soc::getAll();
			if($socs->num_rows > 0){
				foreach($socs as $soc){
					if(!Soc::update($arr, array('id_soc'=>$soc['id_soc']))){
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Mistake update')));
					}
				}
			}else{
				if(!Soc::create($arr)){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Insertion échouée' : 'Mistake insert')));
				}
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'fond'=>'uploads/socs/'.$image_file["name"], 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations enregistrée' : 'Informations saved')));	

			break;
			
		case 'api-update':
			$infsApi = API::findOne(array('id_sejour'=>(int)$_POST['idsejourapi']));

			$arr = array();
			$arr['mail_user_api'] = $_POST['api_user'];
			$arr['mail_key_api'] = $_POST['api_password'];
			$arr['sms_from_api'] = $_POST['fromclicksend'];
			$arr['sms_user_api'] = $_POST['userclicksend'];
			$arr['sms_key_api'] = $_POST['keyclicksend'];
			$arr['is_mail_api'] = (int)$_POST['is_mail_api'];
			$arr['is_sms_api'] = (int)$_POST['is_sms_api'];
			$arr['id_sejour'] = $_POST['idsejourapi'];

			if($infsApi){
				foreach($infsApi as $inf){
					if(!API::update($arr, array('id_sejour'=>(int)$inf['id_sejour']))){
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Mistake update')));
					}
				}
			}else{
				if(!API::create($arr)){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Insertion échouée' : 'Mistake insert')));
				}
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations enregistrée' : 'Informations saved')));	

			break;

		case 'change-lang':
			if (!Ctrl::ctrlflds($_POST, array('lang')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Champs obligatoires manquants' : 'Missing mandatory fields')));

			$lang_current = $usrActif->lang;
			
			$lang = $_POST['lang'];
			UsrApp::update(array('lang' => $lang), array('id_usrApp' => $usrActif->id_usrApp));
			$usrActif->lang = $lang;
			$_SESSION['user_actif'] = serialize($usrActif);

			respAjax::successJSON(array('OK' => 'OK', 'curusr'=>$usrActif));
			break;
			
		case 'get-UsrApp':
			// print_r($GLOBALS['arrAccess']);
			// die;
			if ($arrAccess['isAdmin'] != '1' && $usrActif->id_usrApp != $_POST['idUsrApp'])
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));

			if (!Ctrl::ctrlflds($_POST, array('idUsrApp')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$UsrApp = UsrApp::findOne(array('id_usrApp' => $_POST['idUsrApp']));
			if (!$UsrApp)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur non trouvé' : 'User not found')));

			$UsrApp->date_create = date('d/m/Y H:i', strtotime($UsrApp->date_create));
			$UsrApp->date_upd = strtotime($UsrApp->date_upd) > 0 ? date('d/m/Y H:i', strtotime($UsrApp->date_upd)) : '-';
			$UsrApp->date_last_login = strtotime($UsrApp->date_last_login) > 0 ? date('d/m/Y H:i', strtotime($UsrApp->date_last_login)) : '-';
			unset($UsrApp->psw);
			respAjax::successJSON(array('UsrApp' => $UsrApp));
			break;

		case 'reload-chambre':
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$outch = Chambres::getAllDetails(array('cc.id_fiche'=>$_POST['idct']));
			$htmlbody = '';
			foreach($outch as $ch){
				$htmlbody .= '<tr>
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
			}

			respAjax::successJSON(array('htmlbody' => $htmlbody));
			break;
			
		case 'add-chambre-ct':
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if(count($_POST['resch']) <= 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune chambre sélectionnée' : 'No room selected')));
			}

			// recup des jour de semaine et jour / mois de presence
			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
			
			$datesej = $ct->date_start;
			$datesejend = $ct->date_end;
			
			foreach($_POST['resch'] as $res){
				$datesej = $ct->date_start;
				// echo(print_r($ct));

				while(strtotime($datesej) <= strtotime($datesejend)){
					$dtexplode = explode('-', $datesej);
					$mois = $dtexplode[1];
					$jour = $dtexplode[2];
					$an = $dtexplode[0];

					$chmois = Mois::findOneMois(array('id_chambre'=>$res,'nb_mois'=>(int)$mois,'annee'=>$an, 'id_sejour'=>$usrActif->cursoc));

					if(!$chmois){
						Mois::createMois(array('id_chambre'=>$res, 'nb_mois'=>(int)$mois,'id_sejour'=>$usrActif->cursoc,'mois_'.(int)$jour=>(int)$jour, 'annee'=>$an));
					}else{
						Mois::updateMois(array('mois_'.(int)$jour=>(int)$jour),array('id_chambre'=>$res, 'nb_mois'=>(int)$mois, 'annee'=>$an, 'id_sejour'=>$usrActif->cursoc));
					}

					$datesej = date('Y-m-d',strtotime($datesej. ' + 1 days'));
				}
			}
			
			/* pas necessaire pour l'instant

			$datesej = explode('-', $ct->date_start);
			$datesejend = explode('-', $ct->date_end);
			$arrDtSej = array();

			for($datesej <= $datesejend){

				$timestamp = mktime(0, 0, 0, $datesej[1], $datesej[2], $datesej[0]);
				$joursemaine = date('w', $timestamp);
				$arrDtSej[] = $joursemaine;
				
				$datesej = date('Y-m-d',strtotime($datesej. ' + 1 days'));
			}
			*/

			foreach($_POST['resch'] as $res){
				$idch = Chambres::findOneCh(array('num_chambre'=>$res));
				// creation de la chambre pour le client : db_contacts_chambres
				Chambres::create(array('id_fiche'=>(int)$_POST['idct'], 'num_chambre'=>$res, 'id_chambre'=>$idch->id_chambre));

				Planning::add_planning((int)$_POST['idct'],Tool::dmYtoYmd($_POST['datedeb']),Tool::dmYtoYmd($_POST['dateend']),$_POST['hdeb'],$_POST['hend'],$res, $_POST['sejour']);
			}

			respAjax::successJSON(array('OK','OK'));
			break;


		case 'read-copie':
			if (!Ctrl::ctrlflds($_POST, array('numcmd')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				// 1 enreg suffit puisque toujours meme fournisseur par commande
			$res = CMD::findOne(array('num_cmd'=>$_POST['numcmd']));
			
			if($res){
				$idf = $res->id_fournisseur;
			}else{
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur sur la recupération de la commande' : 'Error retrieving the order')));
			}

			respAjax::successJSON(array('OK','OK','message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Duplication lue' : 'reading'),'idf'=>$idf));
			break;

		case 'copie-prod':
			if (!Ctrl::ctrlflds($_POST, array('numcmd')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = CMD::getAll(array('num_cmd'=>$_POST['numcmd']));
			// print_r($res);
			if($res->num_rows > 0){
				$numcmd = Cmd::getLastNoCmd(array('id_sejour'=>max($usrActif->cursoc, 1)));
				foreach($res as $cmd){
					$idf = $cmd['id_fournisseur'];
					$res = Cmd::create(array('id_fournisseur'=>$cmd['id_fournisseur'], 'id_produit'=>$cmd['id_produit'], 
											'id_unite'=>$cmd['id_unite'], 'val_qte'=>$cmd['val_qte'], 
											'id_sejour'=>$usrActif->cursoc, 'etat_cmd'=>$cmd['etat_cmd'], 'date_cmd'=>date('Y-m-d'), 
											'num_cmd'=>'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT)));
				}
			}

			respAjax::successJSON(array('OK','OK','message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Duplication effectuée' : 'Duplicated'),'numcmd'=>'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT), 'idf'=>$idf));
			break;

		case 'read-prod':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idfourn')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du fournisseur obligatoire' : 'Choice of supplier required')));

			$html = '<select data-placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du produit' : 'Choice of product').' " class="form-control select-chosen" id="id_produit" name="id_produit">
						<option value=""></option>';
			$pdts = Stock::getAllProduitsJoin(array('p.id_fournisseur'=>(int)$_POST['idfourn']));
			if ($pdts) {
				foreach ($pdts as $pdt) {
					$html .= '<option data-name-unit="'.$pdt['name_unite'].'" data-unit="'.$pdt['id_unite'].'" value="' . $pdt['id_produit'] . '" >' . $pdt['name_produit'] . '</option>';
				}
			}
			$html .= '</select>';

			$htmlunit = '<select data-placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix unité' : 'Choice unit').' " class="form-control select-chosen" id="id_unite" name="id_unite" disabled="disabled">
						<option value=""></option>';
			$units = Unite::getAll(array());
			if ($units) {
				foreach ($units as $unit) {
					$htmlunit .= '<option value="' . $unit['id_unite'] . '" >' . $unit['name_unite'] . '</option>';
				}
			}
			$htmlunit .= '</select>';

			respAjax::successJSON(array('OK','OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur mis à jour' : 'Updated Supplier'), 'html'=>$html, 'htmlunit'=>$htmlunit));
			break;

		case 'get-reste':
			if (!Ctrl::ctrlflds($_POST, array('idfiche')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$res = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idfiche']));
				if(!$res){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur montant' : 'Amount error')));
				}

				respAjax::successJSON(array('OK','OK', 'restant'=>$res->tot_ht));
			break;
			
		case 'del-chambre-ct':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'numch', 'idch', 'idctch')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = Chambres::findOneCh(array('id_chambre'=>(int)$_POST['idch'], 'num_chambre'=>(int)$_POST['numch']));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Impossible de trouver la chambre dans la base de données' : 'Room not found')));
			}

			Chambres::delete(array('id_contact_chambre'=>(int)$_POST['idctch']));
			Planning::delete(array('id_fiche'=>(int)$_POST['idct'], 'num_chambre'=>(int)$_POST['numch']));

			respAjax::successJSON(array('OK','OK'));
			break;

		case 'tarif-supp-ch':
			$tarifOption = 0;
			
			if((int)$_POST['opt1'] > 0){
				$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$_POST['opt1']));
				if(!$res){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				}
				$tarifOption += (double)$res->tarif_option_chambre;
			}

			if((int)$_POST['opt2'] > 0){
				$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$_POST['opt2']));
				if(!$res){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				}
				$tarifOption += (double)$res->tarif_option_chambre;
			}
			
			if((int)$_POST['opt3'] > 0){
				$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$_POST['opt3']));
				if(!$res){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				}
				$tarifOption += (double)$res->tarif_option_chambre;
			}
			
			if((int)$_POST['opt4'] > 0){
				$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$_POST['opt4']));
				if(!$res){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				}
				$tarifOption += (double)$res->tarif_option_chambre;
			}
			
			if((int)$_POST['opt5'] > 0){
				$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$_POST['opt5']));
				if(!$res){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				}
				$tarifOption += (double)$res->tarif_option_chambre;
			}

			respAjax::successJSON(array('OK','OK', 'tarif'=>$tarifOption));
			break;

		case 'search-chambres':
			// print_r($_POST);
			// die;
			if($_POST['schedule'] == '1'){
				if (!Ctrl::ctrlflds($_POST, array('dtstart', 'dtend', 'timestart', 'timeend')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));

			}else{
				if (!Ctrl::ctrlflds($_POST, array('dtstart', 'dtend', 'timestart', 'timeend', 'idct')))
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));
			}

			$flts = implode(',',$_POST['idflts']);
			$fltsPiscine = (int)$_POST['idfltspiscine'];
			$fltsopcap = $_POST['idfltsopcap'];
			$valcap = (int)$_POST['valcap'];


			if(!isset($_POST['schedule'])){
				$contact = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
				
				$countDet = Fiche::getCountDetails(array('id_fiche'=>(int)$_POST['idct']));
			}

			// -*
			$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));
				
			$idx = 0 ;

			$sql = "SELECT p.num_chambre FROM db_planning p
					WHERE (
					LEFT('".Tool::dmYtoYmd($_POST['dtstart'])."',10) BETWEEN LEFT(p.rdv_start,10) AND LEFT(p.rdv_end,10) 
					OR 
					LEFT('".Tool::dmYtoYmd($_POST['dtend'])."',10) BETWEEN LEFT(p.rdv_start,10) AND LEFT(p.rdv_end,10)
					) OR
					(
					LEFT('".Tool::dmYtoYmd($_POST['dtstart'])."',10) = LEFT(p.rdv_end,10) AND '".($_POST['timestart'] == '00:00:00' ? '23:59:59' : $_POST['timestart'])."' < RIGHT(p.rdv_end,8)
					) AND p.id_sejour =  ".$usrActif->cursoc
					;

			$res = QueryExec::querySQL($sql);
			// echo($sql);
			$lstch = '';

			foreach($res as $chocc){
				$lstch .= ($lstch == '' ? $chocc['num_chambre'] : ','.$chocc['num_chambre']);
			}

			$sql2 = "SELECT * FROM db_chambres ".($lstch == '' ? ' WHERE id_sejour = '.$usrActif->cursoc : " WHERE num_chambre NOT IN (".$lstch.") AND id_sejour = ".$usrActif->cursoc).($flts != '' ? ' AND type_chambre IN ('.$flts.')' : '').($fltsPiscine > 0 ? ' AND piscine = '.$fltsPiscine : '').($valcap > 0 && $fltsopcap != '' ? ' AND capacite '.$fltsopcap.' '.$valcap : '')." ORDER BY num_chambre, id_chambre, type_chambre";

			$res = '';
			$res = QueryExec::querySQL($sql2);
			
			$htmlres = "";

			
			$htmlres .= "<table id='dispochb' style='text-align: center;'>
							<th style='display:none'></th>
							<th style='display:none'></th>
							<th style='display:none'></th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Num' : 'Number')."</th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Num <br>Communiquante' : 'Number <br>connecting')."</th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etage' : 'Floor')."</th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black; '>Type</th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vue' : 'View')."</th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black; '><img src='../Dashboard/img/lit-double.png'/></th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black; '><img src='../Dashboard/img/lit-simple.png'/></th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black; '><img src='../Dashboard/img/lit-bb.png'/></th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black; '><img src='../Dashboard/img/lit-sup.png'/></th>
							<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black; '>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Capacité' : 'Capacity')."</th>"
							.((int)$infgene->tarif_supp_ch > 0 ?
								"<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif' : 'Rate')."</th>"
							:
								""
							)
							
							.((int)$contact->lnk_reglement > 0 ?
								"<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;' colspan='2'>Action</th>"
							:
								""
							);
			foreach($res as $data){
				
				$loc = Chambres::findOneLoc(array('id_loc_chambre'=>(int)$data['vue_chambre']));
				$type = Chambres::findOneType(array('id_type_chambre'=>(int)$data['type_chambre']));
				$opt1 = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['opt_lib_1']));
				$opt2 = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['opt_lib_2']));
				$opt3 = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['opt_lib_3']));
				$opt4 = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['opt_lib_4']));
				$opt5 = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['opt_lib_5']));
				
				$idx++;
				if($data['tarif_chambre'] > 0){
					$stylecolor = 'background-color:black !important; color:green';
				}else{
					$stylecolor = '';
				}

				$piscine = ($data['piscine'] == 0 ? '' : ($data['piscine'] == 1 ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Privée' : 'Private') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Partagée' : 'Share')));

				$htmlres .= "<tr ".(($idx % 2 ) == 0 ? 'style="background-color:#f3f2f2 !important"' : 'style="background-color:#dad7d7 !important"')." id='ch_".$data['id_chambre']."'>
								<td id='sel_".$data['id_chambre']."' style='display:none'></td>
								<td style='display:none'>".(($idx % 2 ) == 0 ? '#f3f2f2' : '#dad7d7')."</td>
								<td id='idsejour' style='display:none'>".$usrActif->cursoc."</td>
								<td style='border: 1px solid black;'>".$data['num_chambre']."</td>
								<td style='border: 1px solid black;'>".$data['communique_ch']."</td>
								<td style='border: 1px solid black;'>".$data['etage']."</td>
								<td style='border: 1px solid black;'>".$type->name_type_chambre."</td>
								<td style='border: 1px solid black;'>".$loc->name_loc_chambre."</td>
								<td style='border: 1px solid black;'>".$data['nb_lit_double']."</td>
								<td style='border: 1px solid black;'>".$data['nb_lit_simple']."</td>
								<td style='border: 1px solid black;'>".$data['nb_lit_bb']."</td>
								<td style='border: 1px solid black;'>".$data['nb_lit_sup']."</td>
								<td style='border: 1px solid black;'>".$data['capacite']."</td>"
								.((int)$infgene->tarif_supp_ch > 0 ?
									"<td style='border: 1px solid black;".$stylecolor."'>".$data['tarif_chambre']."</td>"
								:
									""
								)
								.((int)$contact->lnk_reglement > 0 ?
									"<td><button href='#' style='margin-bottom:5px;margin-top:5px;; width: 80px;' class='btn btn-sm btn-primary retenir' data-sejour='".$usrActif->cursoc."' data-num-chambre='".$data['num_chambre']."' data-id-chambre='".$data['id_chambre']."'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Retenir' : 'Reserve')."</button></td>
									<td><button href='#' style='margin-bottom:5px;margin-top:5px;; width: 80px;' class='btn btn-sm btn-warning liberer' data-sejour='".$usrActif->cursoc."' data-num-chambre='".$data['num_chambre']."' data-id-chambre='".$data['id_chambre']."' data-color='".(($idx % 2 ) == 0 ? '#f3f2f2' : '#dad7d7')."'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libérer' : 'Detach')."</button></td>"
								:
									""
								)."
								</tr>";
				
			}
			$htmlres .= "</table><br><br>";

			respAjax::successJSON(array('OK' => 'OK', 'count'=>$res->num_rows, 'res'=>$htmlres, 'ids'=>$usrActif->cursoc));
			break;


		case 'search-inf':
			if (!Ctrl::ctrlflds($_POST, array('idfiche')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$lstdet = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune chambre' : 'No room');

				$clts = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idfiche']));
				if(!$clts){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client inexistant' : 'Customer not exist')));
				}

				$cltChs = Chambres::getAllDetails(array('cc.id_fiche'=>(int)$_POST['idfiche']));
				if($cltChs->num_rows > 0){
					$lstdet = '';
					foreach($cltChs as $det){
						$lstdet .= ($lstdet == '' ? '' : ';').'['.$det['num_chambre'].'/'.$det['etage'].']';
					}
				}

				respAjax::successJSON(array('OK' => 'OK', 'res'=>$lstdet, 'res2'=>' du '.date('d/m/Y',strtotime($clts->date_start)).' au '.date('d/m/Y',strtotime($clts->date_end)), 'ids'=>$usrActif->cursoc));

			break;

		case 'search-chambres-jours':
			$dtShare = '0000-00-00';
			$chShare = 0;

			if($_POST['app'] == 'FICHE'){
				if((int)$_POST['idfiche'] == 0){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client obligatoire' : 'Customer require')));
				}
				if((int)$_POST['numch'] == 0){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Chambre obligatoire' : 'Room require')));
				}

				// enregistrement db_planning
				$tmp = $_POST['arrTmp'];
	
				foreach($tmp as $dttmp){
					Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'id_fiche'=>(int)$_POST['idfiche']));
				}
			}

			if($_POST['app'] == 'TMP'){

				// enregistrement db_planning
				$tmp = $_POST['arrTmp'];
	
				foreach($tmp as $dttmp){
					Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp']));
				}
			}
			
			if($_POST['app'] == 'EMP'){

				// enregistrement db_planning
				$tmp = $_POST['arrTmp'];
				$dttmp = $tmp[0];
				$dttmpend = $tmp[1];
				while((int)strtotime($dttmp) <= (int)strtotime($dttmpend)){
				
					Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1', 'is_emp'=>'1','is_name'=>$_POST['nameTmpEmp']));
					$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
				}
			}

			if($_POST['app'] == 'DEL'){

				// suppression db_planning
				Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1'));
			}


			// recup de toutes les chambres
			$chAll = Chambres::getAllCh(array('id_sejour'=>$usrActif->cursoc));
			
			// dates du sejour
			$sej = Setting::getOrganisateur(array('id_organisateur'=>$usrActif->cursoc));
			$debsej = $sej->date_start_organisateur;
			$endsej = $sej->date_end_organisateur;
			$tmpMois = 0;
			$arrMois = [];
			$arrPlan = [];
			$arrPlanTmp = [];
			$arrPlanClts = [];

			$htmlres = '';
			$htmlresEntete = '';

			$idx = 0 ;
			
			while((int)strtotime($debsej) <= (int)strtotime($endsej)){
				
				$moisSej = $dm[1] = explode('-',$debsej);
				$jourSej = $dm[2] = explode('-',$debsej);
				$anSej = $dm[0] = explode('-',$debsej);
				// echo($dm[0].' '.$dm[1].' '.$dm[2]);
				
				if($moisSej != $tmpMois){
					$arrMois[] = $debsej; //$jourSej.'/'.$moisSej.'/'.$anSej;
					$tmpMois = $moisSej;
				}
				$debsej = date('Y-m-d',strtotime($debsej. ' + 1 days'));
			}

			// $htmlres .= "<div class='form-action'><a href='#' style='margin:5px' class='btn btn-info cltmp'>Tmp</a><a href='#' style='margin:5px' class='btn btn-primary clfiche'>Client</a></div>";

			$htmlresEntete .= "<table id='dispochbentete' style='text-align: center;'>";

			$htmlresEntete .= "<tr>
									<th style='display:none'></th>
									<th style='display:none'></th>
									<th style='display:none'></th>
									<th id='' style='width:80px'></th>
									<th style='width:58px'</th>
									<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;' colspan='".count($arrMois)."' >Du ".date('d/m/Y', strtotime($sej->date_start_organisateur)).' AU '.date('d/m/Y', strtotime($sej->date_end_organisateur))."</th>
								</tr>";

			$htmlresEntete .= "<tr>
								<th style='display:none'></th>
								<th style='display:none'></th>
								<th style='display:none'></th>
								<th id='' style='width:80px'></th>
								<th style='width:58px; text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Num' : 'Number')."</th>";

			
			// construction de la table
			foreach($arrMois as $data){
				$expdt = explode('-',$data);
				// $htmlresEntete .= "<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".$expdt[0].'<br>'.$expdt[2].'/'.$expdt[1]."</th>";					
				$htmlresEntete .= "<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".$expdt[2]."</th>";					
			}
			$htmlresEntete .= "</tr></table>";
			
			$htmlres .= "<table id='dispochb' style='text-align: center;'>";

			$colEtage = ['#b5b5b3', '#40567a', '#7a4a43', '#848745', '#498559', '#7b4e87', '#ebd7d5', '#f5f567', '#67f5c8', '#8c64fa', '#0ca2c7' ];
			$colFontEtage = ['#FFF', '#FFF', '#FFF', '#FFF', '#FFF', '#FFF', '#000', '#000', '#000', '#FFF', '#FFF' ];
			
			foreach($chAll as $ch){
				
				$colbkgch = $colEtage[(int)substr($ch['etage'],0,1)];
				$colFtch = $colFontEtage[(int)substr($ch['etage'],0,1)];
				// echo($colbkgch.'<br>');

				$idx++;
				$arrPlan = [];
				// construction de la table
				// $htmlres .= "<tr ".(($idx % 2 ) == 0 ? 'style="background-color:#f3f2f2 !important"' : 'style="background-color:'.$colbkgch.' !important"')." id='ch_".$ch['id_chambre']."'>
				$htmlres .= "<tr ".(($idx % 2 ) == 0 ? 'style="background-color:#f3f2f2 !important"' : 'style="background-color:#dad7d7 !important"')." id='ch_".$ch['id_chambre']."'>
										<td style='display:none'></td>
										<td style='display:none'></td>
										<td style='display:none'></td>
										<td id='".$ch['num_chambre']." - ".$ch['capacite']." - td' style='width:80px'>
											<select class='seltypech ".$ch['num_chambre']."' id='".$ch['num_chambre']." - ".$ch['capacite']."'>
												<option value=\"\" ></option>
												<option style='color:blue' value=\"P\" ><a href='#' data-toggle='tooltip' title='PERSONNELS' style='margin:5px' class='btn btn-warning clemp'>Emp.</a></option>
												<option style='color:red' value=\"T\" ><a href='#' data-toggle='tooltip' title='TEMPORAIRE' style='margin:5px' class='btn btn-info cltmp'>Temp.</a></option>
												<option style='color:green' value=\"C\" ><a href='#' data-toggle='tooltip' title='CLIENTS' style='margin:5px' class='btn btn-primary clfiche'>Client</a></option>
												<option style='color:black' value=\"A\" ><a href='#' data-toggle='tooltip' title='ANNULATION TMP et PERSONNEL' style='margin:5px' class='btn btn-danger cldel'>Annule</a></option>
											</select>
										</td>
										<td style='width:58px; text-align: center; background-color:".$colbkgch."; color:".$colFtch."; border: 1px solid black;'>".$ch['num_chambre']." - ".$ch['capacite']."</td>";
										// <td style='width:58px; text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".$ch['num_chambre']." - ".$ch['capacite']."</td>";

				$isPlan = Planning::getAll(array('id_sejour'=>$sej->id_organisateur, 'num_chambre'=>$ch['num_chambre']));
				if($isPlan->num_rows > 0){
					// recupere derniere date de presence
					$isPlanDateEnd = Planning::findOneMaxDate(array('id_sejour'=>$sej->id_organisateur, 'num_chambre'=>$ch['num_chambre']));
					$endPlan = substr($isPlanDateEnd->MDEND,0,10);
					
					foreach($isPlan as $pl){
						$debPlan = substr($pl['rdv_start'],0,10);
						
						// while(strtotime($debPlan) <= strtotime($endPlan) ){
							$arrPlan[] = $debPlan;
							if($pl['is_tmp'] > 0){
								if($pl['is_emp'] > 0){
									$arrPlanTmp[] = $debPlan.' - '.$pl['num_chambre'].' - '.$pl['is_name'].((int)$pl['is_share'] > 0 ? ' - SHARE' : ' - NOT SHARE').' - PERSONNEL';
									$arrPlanClts[] = $debPlan.' * '.$pl['id_fiche'].' * '.$pl['num_chambre'];
								}else{
									$arrPlanTmp[] = $debPlan.' - '.$pl['num_chambre'].' - '.$pl['is_name'].((int)$pl['is_share'] > 0 ? ' - SHARE' : ' - NOT SHARE');
									$arrPlanClts[] = $debPlan.' * '.$pl['id_fiche'].' * '.$pl['num_chambre'];
								}
							}else{
								$arrPlanClts[] = $debPlan.' * '.$pl['id_fiche'].' * '.$pl['num_chambre'];
							};
							
						// 	$debPlan = date('Y-m-d',strtotime($debPlan. ' + 1 days'));
						// }
					}
				}
				// if($isPlan){
				// 	$debPlan = substr($isPlan->rdv_start,0,10);
				// 	$endPlan = substr($isPlan->rdv_end,0,10);

				// 	while($debPlan <= $endPlan ){
				// 		$arrPlan[] = $debPlan;
				// 		$debPlan = date('Y-m-d',strtotime($debPlan. ' + 1 days'));
				// 	}
				// }

				foreach($arrMois as $data){
					
					if(in_array($data, $arrPlan)){
						$col = 'green';
						$Tle = '';
						foreach($arrPlanTmp as $cl){
							if($ch['num_chambre'] == substr($cl,13,strpos(substr($cl,13),' - ')) && $data == substr($cl,0,10)){
								if(substr($cl,-9) == 'PERSONNEL'){
									$expTle = explode('-',$cl);
									// echo('col : '.$expTle[5].'<br>' );
									$col = (trim($expTle[5]) == 'SHARE' ? 'orange' : 'blue');
									$Tle = "PERSONNEL : ".$expTle[4];
								}else{
									
									// $resDateMinMax = Planning::findOneMinMaxDate(array('id_fiche'=>'0','is_tmp'=>'1',
									// 													'id_sejour'=>$usrActif->cursoc, 
									// 													'num_chambre'=>$ch['num_chambre'],
									// 													'is_name'=>$expTle[4]),true,'','');

									// $isShareTmp = Planning::findOne(array('id_sejour'=>$usrActif->cursoc, 
									// 									'num_chambre'=>$ch['num_chambre'], 
									// 									'is_tmp'=>'1','is_share'=>'1',
									// 									'LEFT(rdv_end,10)'=>$data ));
									// if($isShareTmp){
									// 	$isShTmp = 1;
									// }else{
									// 	$isShTmp = 0;
									// }

									$expTle = explode('-',$cl);
									$col = (trim($expTle[5]) == 'SHARE' || ($isShTmp == 0 && strtotime(substr($resDateMinMax->MDEND,0,10)) == substr($cl,0,10)) ? 'orange' : 'red');
									// echo('col2 : '.$expTle[5].'<br>' );
									$Tle = "TEMPORAIRE : ".$expTle[4];
								}
								// echo($col.' *** '.$cl.'<br> -- '.substr($cl,-9).' ===>'.$ch['num_chambre'] .' == '. substr($cl,13).' && '.$data.' == '.substr($cl,0,10).'<br>');
								break;
							}
						}
						foreach($arrPlanClts as $client){
							$arrTitle = explode('*',$client);
							// echo(print_r($arrTitle).'<br>');
							if($arrTitle[2] == $ch['num_chambre'] && strtotime($arrTitle[0]) == strtotime($data) && ($col != 'red' && $col != 'blue') && (int)$arrTitle[1] > 0){
								$clts = Fiche::findOne(array('c.id_fiche'=>(int)$arrTitle[1]));
								// liste de toutes les chambres occupees par ce client
								$allCltCh = Chambres::getAll(array('id_fiche'=>(int)$arrTitle[1]));
								$addinf = '';
								if($allCltCh->num_rows > 0){
									$addinf .= ' Chb : [ ';
									foreach($allCltCh as $lstcltch){
										$addinf .= $lstcltch['num_chambre'].', ';
									}
									$addinf = substr($addinf, 0, strripos($addinf,','));
									$addinf .=' ]';
									// str_replace($addinf,strripos($addinf,','),1) .=' ]';
								}
								
								$Tle = $clts->first_name.' '.$clts->last_name.' du '.date('d/m/Y',strtotime($clts->date_start)).' au '.date('d/m/Y',strtotime($clts->date_end)).$addinf;
								
								$usectshare = Planning::FindOne(array('LEFT(rdv_end,10)'=>$data,'num_chambre'=>$ch['num_chambre'], 'id_fiche'=>(int)$arrTitle[1]));

								
								$resDateMinMax = Planning::findOneMinMaxDate(array('id_fiche'=>(int)$arrTitle[1],'id_sejour'=>$usrActif->cursoc),true,'','id_fiche');
								$isShareClt = Planning::findOne(array('id_sejour'=>$usrActif->cursoc, 'num_chambre'=>$ch['num_chambre'], 'is_share'=>'1','id_fiche_share'=>(int)$arrTitle[1]));
								if($isShareClt){
									$isShClt = 1;
								}else{
									$isShClt = 0;
								}

								if((strtotime($dtShare) == strtotime($data) && (int)$arrTitle[1] == (int)$usectshare->id_fiche_share) || (int)$usectshare->id_fiche_share > 0 || (strtotime(substr($resDateMinMax->MDEND,0,10)) == strtotime($data) && $isShClt == 0)){
									$col = 'orange';
								}else{
									$col = 'green';
								}
								break;
							}
						}

						$htmlres .= "<td title='".$Tle."' style='text-align: center; background-color:".$col."; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='checkbox' checked disabled='disabled' style=''/></td>";
					}else{
						$htmlres .= "<td title='' style='text-align: center; background-color:white; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='text'  disabled='disabled' style='height:15px;width:15px;border:none;'/></td>";
					}
					// 	$htmlres .= "<td title='".$Tle."' style='text-align: center; background-color:".$col."; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='text'  disabled='disabled' /></td>";
					// }else{
					// 	$htmlres .= "<td title='' style='text-align: center; background-color:white; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='text'  disabled='disabled'/></td>";
					// }
					
				}
				$htmlres .= "</tr>";
			}

			$htmlres .= "</table><br><br>";

			respAjax::successJSON(array('OK' => 'OK','res'=>$htmlres, 'entete'=>$htmlresEntete, 'ids'=>$usrActif->cursoc, 'arrMois'=>json_encode($arrMois), 'ch'=>$chAll->num_rows));

			break;

		case 'check-tmp-chambre':
			// print_r($_POST);
			// die;
			$dtShare = '0000-00-00';
			$chShare = 0;

			/** 0:NULL; 1:new client before; 2:ajout jours sur meme client */
			$addBeforeShare = 0;
			$addBeforeIdFicheShare = 0;
			$addDtShare = 0;
			$idPlanningUpdtShare = 0;
			$addTmpShare = 0;
			$addNameShare = '';
			$addEmpShare = 0;

			if($_POST['app'] != 'DEL'){
				$idctuse = 0;
				$ifTmpUse = 0;

				/* verif sur la plage complete */
				$idxCtrl = 0;
				$dtctrlAll = QueryExec::querySql('SELECT id_planning , LEFT(rdv_start,10) as dtdeb, LEFT(rdv_end,10) as dtend, id_fiche, is_tmp, is_emp, id_fiche_share
												FROM db_planning 
												WHERE num_chambre = '.(int)$_POST['numch'] .' 
												AND id_sejour = '.$usrActif->cursoc.'
												AND (
													(LEFT(rdv_start,10) BETWEEN "'.$_POST['arrTmp'][0].'" AND "'.$_POST['arrTmp'][1].'" )
													OR 
													(LEFT(rdv_end,10) BETWEEN "'.$_POST['arrTmp'][0].'" AND "'.$_POST['arrTmp'][1].'" )
													)', false);

													
				$dttmpctrl = $_POST['arrTmp'][0];
				$dttmpendctrl = $_POST['arrTmp'][1];
				if($dtctrlAll->num_rows > 0){
					while((int)strtotime($dttmpctrl) <= (int)strtotime($dttmpendctrl)){
						foreach($dtctrlAll as $ctrl){
							if((int)strtotime($ctrl['dtdeb']) == (int)strtotime($dttmpctrl)){
								$idxCtrl++;
							}
							// echo($dttmp.' == '.$ctrl['dtdeb'].'<br>'.$idxCtrl.'<br>');
						}
						$dttmpctrl = date('Y-m-d',strtotime($dttmpctrl. ' + 1 days'));
					}
				}
				
													
				if($idxCtrl >= 2){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Cette chambre est déjà occupées<br>sur une partie de la période !' : 'This room are already occupied<br>over part of the period !')));
				}
				// die;
				
				$ctrlPlDeb = Planning::getAll(array('LEFT(rdv_start,10)'=>$_POST['arrTmp'][0], 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc));
				$ctrlPlEnd = Planning::getAll(array('LEFT(rdv_end,10)'=>$_POST['arrTmp'][1], 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc));


				// CTRL des share ou prolongement
				if($ctrlPlEnd->num_rows > 0){
					
					// existe date start == date end du new client pour meme chambre
					// $dtctrl = Planning::findOne(array('MIN(LEFT(rdv_start,10))'=>$_POST['arrTmp'][1], 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc));
					$dtctrl = QueryExec::querySql('SELECT id_fiche, id_planning, MIN(LEFT(rdv_start,10)) as dtmin FROM db_planning WHERE num_chambre = '.(int)$_POST['numch'] .' AND id_sejour = '.$usrActif->cursoc, true);
					
					if($dtctrl){
						if($dtctrl->dtmin == $_POST['arrTmp'][1]){

							$addDtShare = 1;
	
							if($dtctrl->id_fiche == $_POST['idfiche']){
								$addBeforeShare = 2;
							}
							if(isset($_POST['idfiche'])){
								if($dtctrl->id_fiche != (int)$_POST['idfiche']){
									$addBeforeShare = 1;
								}
							}else{
								$addBeforeShare = 1;
							}
							$addBeforeIdFicheShare = $dtctrl->id_fiche;
							$idPlanningUpdtShare = $dtctrl->id_planning;
							$addTmpShare = $dtctrl->is_tmp;
							$addNameShare = $dtctrl->is_name;
							$addEmpShare = $dtctrl->is_emp;
						}
						
					}else{
						$addDtShare = 0;
					}
					
				}
				
				if(($ctrlPlDeb->num_rows > 0 || $ctrlPlEnd->num_rows > 0) && (int)$addDtShare == 0){
					$dtuse = Planning::findOne(array('LEFT(rdv_end,10)'=>$_POST['arrTmp'][0], 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc));
					
					if($dtuse){
						$idctuse = $dtuse->id_fiche;
						$ifTmpUse = ($dtuse->is_tmp > 0 ? '1' : '0');
						
						$dtuse = false;
						$dtusenext = date('Y-m-d',strtotime($_POST['arrTmp'][0]. ' + 1 days'));
						$dtuse = Planning::findOne(array('LEFT(rdv_end,10)'=>$dtusenext, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc));
						if($dtuse){
							if($dtuse->id_fiche == $idctuse && $idctuse != 0){
								respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Cette chambre est occupées !' : 'This room has occupied !')));
							}
							if($dtuse->id_fiche != $idctuse && $idctuse != 0 ){
								respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Cette chambre est déjà occupées !' : 'This room are already occupied !')));
							}
						}
					}else{
						
						/**** CAS OU LA DATE COMMENCE
						 * POSSIBILITE DE METTRE UNE RESA DONT DATE FIN == DATE DEBUT
						 * RECHERCHE PLANNING POUR : LEFT(rdv_start,10) ==  $_POST['arrTmp'][1] && num_chambre == (int)$_POST['numch'] && id_sejour == $usrActif->cursoc
						 * IF(retour requete valide)
						 * ALORS :
						 * IF(retour requete id_fiche == $_POST['idfiche']) => $addBeforeShare = 2
						 * IF(retour requete id_fiche != $_POST['idfiche']) => $addBeforeShare = 1
						 * $addBeforeIdFicheShare = retour requete id_fiche
						 * ensuite action dans app == fiche
						 *****/ 
						
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Certaines dates sont déjà occupées !' : 'Some dates are already occupied !')));
					}
				}
				if($idctuse > 0){
					$dtShare = $_POST['arrTmp'][0];
					$chShare = 1;
				}else{
					if($ifTmpUse > 0){
						$dtShare = $_POST['arrTmp'][0];
						$chShare = 1;
					}
				}
			}
			// echo(' ** '.$ctrlPlDeb->num_rows.' -- '.$ctrlPlEnd->num_rows.' -- '.(int)$addDtShare.' -- '.print_r($dtuse).' ** '.$idctuse);
			// die;
			
			if($_POST['app'] == 'FICHE'){
				// enregistrement db_planning
				$tmp = $_POST['arrTmp'];
				sort($tmp);
				// print_r($tmp);
				// die;


				if((int)$_POST['idfiche'] == 0){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client obligatoire' : 'Customer require')));
				}else{
					/****
					 * CTRL de $addBeforeShare
					 * IF $addBeforeShare == 1
					 * ALORS :
					 * update planning enreg avec :
					 * id_fiche = $_POST['idfiche']
					 * date_create = date()
					 * rdv_start = $dttmpend.' 10:00:00'
					 * rdv_end = $dttmpend.' 16:00:00'
					 * id_usrApp = $usrActif->id_usrApp
					 * id_sejour = $usrActif->cursoc
					 * num_chambre = (int)$_POST['numch']
					 * IF($_POST['idfiche'] == addBeforeIdFicheShare)
					 * ALORS :
					 * pas d'infos share
					 * SINON :
					 * is_share = 1
					 * date_share = date()
					 * id_fiche_share = $addBeforeIdFicheShare
					 * 
					 * $tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));
					 */


					if((int)$addBeforeShare > 0){

						if($_POST['idfiche'] == $addBeforeIdFicheShare){
							// dans cas du prolongement il faut faire 2x
							$tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));

							Planning::create(array('id_fiche'=>$_POST['idfiche'], 'date_create'=>date('Y-m-d'), 
												'rdv_start'=>$tmp[1].' 10:00:00', 'rdv_end'=>$tmp[1].' 16:00:00',
												'id_usrApp'=>$usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc,
												'num_chambre' => (int)$_POST['numch']));

						}else{
							Planning::update(array('id_fiche'=>$_POST['idfiche'], 'date_create'=>date('Y-m-d'), 
												'rdv_start'=>$tmp[1].' 10:00:00', 'rdv_end'=>$tmp[1].' 16:00:00',
												'id_usrApp'=>$usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc,
												'num_chambre' => (int)$_POST['numch'], 'is_share'=>'1',
												'date_share' => date('Y-m-d'), 'id_fiche_share'=>$addBeforeIdFicheShare),
											array('id_planning'=>$idPlanningUpdtShare));
											
										}
						$tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));

					}
				}
				
				$dttmp = $tmp[0];
				$dttmpend = $tmp[1];
				while((int)strtotime($dttmp) <= (int)strtotime($dttmpend)){
					// Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00','is_tmp'=>'1'));
					Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00'));

					if($chShare == 1 && (int)strtotime($dttmp) == (int)strtotime($dtShare)){
						Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00', 
										'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],
										'id_sejour'=>$usrActif->cursoc, 'id_fiche'=>(int)$_POST['idfiche'],
										'is_share'=>'1', 'date_share'=>$dtShare, 'id_fiche_share'=>(int)$idctuse));
					}else{
						Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'id_fiche'=>(int)$_POST['idfiche']));
					}

					$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
				}
	
				// foreach($tmp as $dttmp){
				// 	Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'id_fiche'=>(int)$_POST['idfiche']));
				// }

				$countArr = count($tmp);
				if($countArr > 0){
					$ct_ch = Chambres::findOne(array('id_fiche'=>(int)$_POST['idfiche'], 'num_chambre'=>(int)$_POST['numch']));
					if(!$ct_ch){
						$idch = Chambres::findOneCh(array('num_chambre'=>(int)$_POST['numch']));
						Chambres::create(array('id_fiche'=>(int)$_POST['idfiche'], 'id_chambre'=>$idch->id_chambre, 'num_chambre'=>(int)$_POST['numch']));
					}
					// if($countArr == 1){
					// 	Fiche::update(array('date_start'=>$tmp[0], 'date_end'=>$tmp[0]),array('id_fiche'=>(int)$_POST['idfiche']));
					// }else{
					// 	Fiche::update(array('date_start'=>$tmp[0], 'date_end'=>$tmp[($countArr - 1)]),array('id_fiche'=>(int)$_POST['idfiche']));
					// }
				}
			}

			// if($_POST['app'] == 'TMP'){

			// 	// enregistrement db_planning
			// 	$tmp = $_POST['arrTmp'];
	
			// 	foreach($tmp as $dttmp){
			// 		Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1'));
			// 	}
			// }

			if($_POST['app'] == 'TMP'){

				$tmp = $_POST['arrTmp'];

				/****
				 * CTRL de $addBeforeShare
				 * IF $addBeforeShare == 1
				 * ALORS :
				 * update planning enreg avec :
				 * is_tmp = 1
				 * is_name = $_POST['nameTmpEmp']
				 * is_share = 1
				 * date_share = date()
				 * id_fiche_share = $addBeforeIdFicheShare
				 * 
				 * $tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));
				 */
				if((int)$addBeforeShare > 0){

					if($_POST['nameTmpEmp'] == $addNameShare){
						// dans cas du prolongement il faut faire 2x
						$tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));

						Planning::create(array('id_fiche'=>$_POST['idfiche'], 'date_create'=>date('Y-m-d'), 
											'rdv_start'=>$tmp[1].' 10:00:00', 'rdv_end'=>$tmp[1].' 16:00:00',
											'id_usrApp'=>$usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc,
											'num_chambre' => (int)$_POST['numch'],
											'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp']));

					}else{
						Planning::update(array('rdv_start'=>$tmp[1].' 10:00:00', 'rdv_end'=>$tmp[1].' 16:00:00',
											'is_tmp' => '1', 'is_name' => $_POST['nameTmpEmp'],
											'is_share'=>'1','date_share' => date('Y-m-d'),
											'id_fiche_share'=>$addBeforeIdFicheShare),
										array('id_planning'=>$idPlanningUpdtShare));
										
									}
					$tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));

				}

				// enregistrement db_planning
				$dttmp = $tmp[0];
				$dttmpend = $tmp[1];
				
				while((int)strtotime($dttmp) <= (int)strtotime($dttmpend)){
					Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00'));

					if($chShare == 1 && (int)strtotime($dttmp) == (int)strtotime($dtShare)){
						Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00', 
										'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],
										'id_sejour'=>$usrActif->cursoc, 'id_fiche'=>(int)$_POST['idfiche'],
										'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp'],
										'is_share'=>'1', 'date_share'=>$dtShare, 'id_fiche_share'=>(int)$idctuse));
					}else{
						Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 
										'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],
										'id_sejour'=>$usrActif->cursoc, 
										'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp']));
					}

					$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
					// Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp']));
					// $dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
				}
	
				// foreach($tmp as $dttmp){
				// 	Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1'));
				// }
			}

			// die;

			if($_POST['app'] == 'EMP'){

				// enregistrement db_planning
				$tmp = $_POST['arrTmp'];

				/****
				 * CTRL de $addBeforeShare
				 * IF $addBeforeShare == 1
				 * ALORS :
				 * update planning enreg avec :
				 * is_tmp = 1
				 * is_name = $_POST['nameTmpEmp']
				 * is_share = 1
				 * date_share = date()
				 * id_fiche_share = $addBeforeIdFicheShare
				 * 
				 * $tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));
				 */
				if((int)$addBeforeShare > 0){

					if($_POST['nameTmpEmp'] == $addNameShare){
						// dans cas du prolongement il faut faire 2x
						$tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));

						Planning::create(array('id_fiche'=>$_POST['idfiche'], 'date_create'=>date('Y-m-d'), 
											'rdv_start'=>$tmp[1].' 10:00:00', 'rdv_end'=>$tmp[1].' 16:00:00',
											'id_usrApp'=>$usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc,
											'num_chambre' => (int)$_POST['numch'], 'is_emp' => '1',
											'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp']));

					}else{
						Planning::update(array('rdv_start'=>$tmp[1].' 10:00:00', 'rdv_end'=>$tmp[1].' 16:00:00',
											'is_tmp' => '1', 'is_name' => $_POST['nameTmpEmp'], 'is_emp' => '1',
											'is_share'=>'1','date_share' => date('Y-m-d'),
											'id_fiche_share'=>$addBeforeIdFicheShare),
										array('id_planning'=>$idPlanningUpdtShare));
										
									}
					$tmp[1] = date('Y-m-d',strtotime($tmp[1]. ' - 1 days'));

				}

				$dttmp = $tmp[0];
				$dttmpend = $tmp[1];
				while((int)strtotime($dttmp) <= (int)strtotime($dttmpend)){
					Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00'));

					if($chShare == 1 && (int)strtotime($dttmp) == (int)strtotime($dtShare)){
						Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00:00','rdv_end'=>$dttmp.' 16:00:00', 
										'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],
										'id_sejour'=>$usrActif->cursoc, 'id_fiche'=>(int)$_POST['idfiche'],
										'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp'], 'is_emp' => '1',
										'is_share'=>'1', 'date_share'=>$dtShare, 'id_fiche_share'=>(int)$idctuse));
					}else{
						Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1','is_name'=>$_POST['nameTmpEmp'], 'is_emp'=>'1'));
					}
					$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
					// Planning::create(array('date_create'=>date('Y-m-d H:i'), 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00', 'id_usrApp'=>$usrActif->id_usrApp, 'num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'is_tmp'=>'1', 'is_emp'=>'1','is_name'=>$_POST['nameTmpEmp']));
					// $dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
				}
			}

			if($_POST['app'] == 'DEL'){
				// enregistrement db_planning
				$tmp = $_POST['arrTmp'];
				$dttmp = $tmp[0];
				$dttmpend = $tmp[1];

				// $isDelTmp = 0;
				// $isDelEmp = 0;
				// $isDelId = 0;
				// $verifDels = QueryExec::querySql('SELECT *
				// 									FROM db_planning 
				// 									WHERE num_chambre = '.(int)$_POST['numch'].
				// 									' AND id_sejour = '.$usrActif->cursoc.
				// 									' AND rdv_start BETWEEN "'.$dttmp.' 10:00" AND "'.$dttmpend.' 16:00"', false);

				// foreach($verifDels as $verifDel){
				// 	if($verifDel['is_tmp'] > 0){
				// 		$isDelTmp++;
				// 	}
				// 	if($verifDel['is_emp'] > 0){
				// 		$isDelEmp++;
				// 	}
				// 	if($verifDel['id_fiche'] > 0){
				// 		$isDelId++;
				// 	}
				// }

				// if($isDelId > 0 && ($isDelTmp > 0 || $isDelEmp > 0)){
				// 	respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression non autorisée sur plusieurs types de réservation' : 'Unauthorized deletion on multiple reservation types')));
				// }


				/***** si pour date debut annulation $dttmp ==> is_share==true
				 * ALORS :
				 * id_fiche de l'enreg = id_fiche_share
				 * is_share = false
				 * date_share = '0000-00-00'
				 * id_fiche_share = 0
				 * $dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
				*****/

				// $verifDebDel = Planning::findOne(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00','is_tmp'=>'0'));
				$verifDebDel = QueryExec::querySql('SELECT *
													FROM db_planning 
													WHERE num_chambre = '.(int)$_POST['numch'].
													' AND id_sejour = '.$usrActif->cursoc.
													' AND rdv_start = "'.$dttmp.' 10:00"'.
													' AND rdv_end = "'.$dttmp.' 16:00"'.
													' AND (is_tmp = 0 OR (is_tmp = 1 AND is_share = 1))', true);
					
													// echo('la'.print_r($verifDebDel));
													// die;
				if($verifDebDel && (int)$verifDebDel->is_share > 0){
					if((int)$verifDebDel->is_tmp > 0 && (int)$verifDebDel->id_fiche_share > 0){
						$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
						Planning::update(array('id_fiche'=>$verifDebDel->id_fiche_share, 'is_tmp'=>'0', 'is_name'=>'', 'is_share'=>'0', 'date_share'=>'0000-00-00', 'id_fiche_share'=>'0'),
											array('id_planning'=>$verifDebDel->id_planning));
					}
					if((int)$verifDebDel->is_tmp > 0 && (int)$verifDebDel->id_fiche_share == 0){
						$dttmpprev = date('Y-m-d',strtotime($dttmp. ' - 1 days'));
						$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));

						$previnf = Planning::findOne(array('num_chambre'=>(int)$_POST['numch'], 'LEFT(rdv_end,10)'=>$dttmpprev, 'id_sejour'=>$usrActif->cursoc));
						if($previnf){
							Planning::update(array('id_fiche'=>$verifDebDel->id_fiche_share, 'is_tmp'=>$previnf->is_tmp, 'is_name'=>$previnf->is_name, 
													'is_emp'=>$previnf->is_emp, 'is_share'=>'0', 'date_share'=>'0000-00-00', 'id_fiche_share'=>'0'),
												array('id_planning'=>$verifDebDel->id_planning));	
						}
						
					}		
					// echo(print_r($verifDebDel).'<br>'.(int)$verifDebDel->is_tmp.' -- '.(int)$verifDebDel->id_fiche_share.' << '.$dttmpprev.'<br>'.print_r($previnf))			;
					// die;
					// Planning::update(array('id_fiche'=>$verifDebDel->id_fiche_share, 'is_tmp'=>'0', 'is_name'=>'', 'is_share'=>'0', 'date_share'=>'0000-00-00', 'id_fiche_share'=>'0'),
					// array('id_planning'=>$verifDebDel->id_planning));

				}
			
				/***** si pour date fin annulation $dttmpend ==> is_share==true
				 * ALORS :
				 * id_fiche de l'enreg = id_fiche_share
				 * is_share = false
				 * date_share = '0000-00-00'
				 * id_fiche_share = 0
				 * $dttmpend = date('Y-m-d',strtotime($dttmpend. ' - 1 days'));
				*****/

				// $verifDebDel = Planning::findOne(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmpend.' 10:00','rdv_end'=>$dttmpend.' 16:00','is_tmp'=>'0'));
				$verifDebDel = QueryExec::querySql('SELECT *
													FROM db_planning 
													WHERE num_chambre = '.(int)$_POST['numch'].
													' AND id_sejour = '.$usrActif->cursoc.
													' AND rdv_start = "'.$dttmpend.' 10:00"'.
													' AND rdv_end = "'.$dttmpend.' 16:00"'.
													' AND (is_tmp = 0 OR (is_tmp = 1 AND is_share = 1))', true);

													// echo('la'.print_r($verifDebDel));
													// die;
				if($verifDebDel && (int)$verifDebDel->is_share > 0){
					if((int)$verifDebDel->is_tmp > 0 && (int)$verifDebDel->id_fiche_share > 0){
						$dttmpend = date('Y-m-d',strtotime($dttmpend. ' - 1 days'));
						Planning::update(array('id_fiche'=>$verifDebDel->id_fiche_share, 'is_tmp'=> '0', 'is_name'=>'', 'is_share'=>'0', 'date_share'=>'0000-00-00', 'id_fiche_share'=>'0'),
										array('id_planning'=>$verifDebDel->id_planning));
					}

					if((int)$verifDebDel->is_tmp > 0 && (int)$verifDebDel->id_fiche_share == 0){
						$dttmpprev = date('Y-m-d',strtotime($dttmpend. ' - 1 days'));
						$dttmpend = date('Y-m-d',strtotime($dttmpend. ' - 1 days'));

						$previnf = Planning::findOne(array('num_chambre'=>(int)$_POST['numch'], 'LEFT(rdv_end,10)'=>$dttmpprev, 'id_sejour'=>$usrActif->cursoc));
						if($previnf){
							Planning::update(array('id_fiche'=>$verifDebDel->id_fiche_share, 'is_tmp'=>$previnf->is_tmp, 'is_name'=>$previnf->is_name, 
													'is_emp'=>$previnf->is_emp, 'is_share'=>'0', 'date_share'=>'0000-00-00', 'id_fiche_share'=>'0'),
												array('id_planning'=>$verifDebDel->id_planning));	
						}
						
					}	

					
				}
				
				if($_POST['forceDel'] == '1'){
					
					// suppression db_planning
					while((int)strtotime($dttmp) <= (int)strtotime($dttmpend)){
						$verifTmpDel = QueryExec::querySql('SELECT *
										FROM db_planning 
										WHERE num_chambre = '.(int)$_POST['numch'].
										' AND id_sejour = '.$usrActif->cursoc.
										' AND rdv_start = "'.$dttmp.' 10:00"'.
										' AND rdv_end = "'.$dttmp.' 16:00"'.
										' AND is_tmp = 1', true);

						if($verifTmpDel){
							Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00','is_tmp'=>'1'));
						}else{
							foreach($_POST['lstId'] as $idcli){
								// echo($dttmp.' '.$idcli.' --  <br>');
								Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00','is_tmp'=>'0', 'id_fiche'=>$idcli));
								Chambres::delete(array('id_fiche'=>$idcli,'num_chambre'=>(int)$_POST['numch']));
							}			
						}

						$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
					}
				}else{
					
					// verif si client sur cette chambre
					$arrAnCli = '';
					$arrAnCliId = [];
					$idCliChange = '0';
					
					while((int)strtotime($dttmp) <= (int)strtotime($dttmpend)){
						$verifTmpDel = QueryExec::querySql('SELECT *
										FROM db_planning 
										WHERE num_chambre = '.(int)$_POST['numch'].
										' AND id_sejour = '.$usrActif->cursoc.
										' AND rdv_start = "'.$dttmp.' 10:00"'.
										' AND rdv_end = "'.$dttmp.' 16:00"'.
										' AND is_tmp = 1', true);

						if($verifTmpDel){
							Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00','is_tmp'=>'1'));
						}else{
							$resPlCli = Planning::findOne(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00','is_tmp'=>'0'));
							if($resPlCli){
								$ctdel = Fiche::findOne(array('c.id_fiche'=>$resPlCli->id_fiche));
								$arrAnCli = $ctdel->id_fiche.' : [ '.$ctdel->last_name.' '.$ctdel->first_name.' ]';
								if($idCliChange != $resPlCli->id_fiche){
									$arrAnCliId[] = $resPlCli->id_fiche;
									$idCliChange = $resPlCli->id_fiche;
								}
							}
						}
						$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
					}					
				}

				/*
				// reinitialisation
				$tmp = $_POST['arrTmp'];
				$dttmp = $tmp[0];
				$dttmpend = $tmp[1];
				// suppression db_planning
				while((int)strtotime($dttmp) <= (int)strtotime($dttmpend)){
						
					Planning::delete(array('num_chambre'=>(int)$_POST['numch'],'id_sejour'=>$usrActif->cursoc, 'rdv_start'=>$dttmp.' 10:00','rdv_end'=>$dttmp.' 16:00','is_tmp'=>'1'));
					$dttmp = date('Y-m-d',strtotime($dttmp. ' + 1 days'));
				}
				*/
				
			}

			// mise a jour des dates de presences du client
			$resDateMinMax = Planning::findOneMinMaxDate(array('id_fiche'=>(int)$_POST['idfiche'],'id_sejour'=>$usrActif->cursoc),true,'','id_fiche');
			Fiche::update(array('date_start'=>$resDateMinMax->MDDEB, 'date_end'=>$resDateMinMax->MDEND),array('id_fiche'=>(int)$_POST['idfiche']));
			// print_r($resDateMinMax);
			// die;
			if($_POST['app'] == 'SEARCH'){
				$whCh = '';
				// error_log('is planning)'.$_POST['chkemp'].' --- '.$_POST['chktmp'].' ..... '.$whCh);
				
				$flts = implode(',',$_POST['idflts']);
				$fltsopcap = $_POST['idfltsopcap'];
				$valcap = (int)$_POST['valcap'];
				
				if(trim($flts) != ''){
					$whCh = ' AND c.type_chambre IN ('.$flts.')';
				}
				if((int)$valcap > 0){
					$whCh .= ' AND c.capacite '.$fltsopcap.' '.$valcap;
				}
				if((int)$_POST['chktmp'] > 0){
					$whCh .= ' AND p.is_tmp = 1 ';
				}
				if((int)$_POST['chkemp'] > 0){
					$whCh .= ' AND p.is_emp = 1 ';
				}
				
				if((int)$_POST['chkemp'] > 0 || (int)$_POST['chktmp'] > 0){
					$chAll = QueryExec::querySQL('SELECT c.* FROM db_chambres c 
						INNER JOIN db_planning p ON c.num_chambre = p.num_chambre 
						WHERE c.id_sejour = '. $usrActif->cursoc . $whCh . ' GROUP BY c.num_chambre ');
				}else{
					$chAll = QueryExec::querySQL('SELECT * FROM db_chambres WHERE id_sejour = '. $usrActif->cursoc . $whCh);
				}
				
			}else{
				// recup de toutes les chambres
				$chAll = Chambres::getAllCh(array('id_sejour'=>$usrActif->cursoc));
			}
			
			// dates du sejour
			$sej = Setting::getOrganisateur(array('id_organisateur'=>$usrActif->cursoc));
			$debsej = $sej->date_start_organisateur;
			$endsej = $sej->date_end_organisateur;
			$tmpMois = 0;
			$arrMois = [];
			$arrPlan = [];
			$arrPlanTmp = [];
			$arrPlanCh = [];
			$arrPlanClts = [];
			
			$htmlres = '';
			$htmlresEntete = '';

			$idx = 0 ;
			
			while((int)strtotime($debsej) <= (int)strtotime($endsej)){
				
				$moisSej = $dm[1] = explode('-',$debsej);
				$jourSej = $dm[2] = explode('-',$debsej);
				$anSej = $dm[0] = explode('-',$debsej);
				// echo($dm[0].' '.$dm[1].' '.$dm[2]);
				
				if($moisSej != $tmpMois){
					$arrMois[] = $debsej; //$jourSej.'/'.$moisSej.'/'.$anSej;
					$tmpMois = $moisSej;
				}
				$debsej = date('Y-m-d',strtotime($debsej. ' + 1 days'));
			}

			// $htmlres .= "<div class='form-action'><a href='#' style='margin:5px' class='btn btn-info cltmp'>Tmp</a><a href='#' style='margin:5px' class='btn btn-primary clfiche'>Client</a></div>";

			// $htmlres .= "<table id='dispochb' style='text-align: center;'>
			// 				<tr>
			// 					<th style='display:none'></th>
			// 					<th style='display:none'></th>
			// 					<th style='display:none'></th>
			// 					<td></td>
			// 					<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Num' : 'Number')."</th>";

			
			// // construction de la table
			// foreach($arrMois as $data){
			// 	$expdt = explode('-',$data);
			// 	$htmlres .= "<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".$expdt[0].'<br>'.$expdt[2].'/'.$expdt[1]."</th>";					
			// }
			// $htmlres .= "</tr>";
			$htmlresEntete .= "<table id='dispochbentete' style='text-align: center;'>";

			$htmlresEntete .= "<tr>
									<th style='display:none'></th>
									<th style='display:none'></th>
									<th style='display:none'></th>
									<th id='' style='width:80px'></th>
									<th style='width:58px'</th>
									<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;' colspan='".count($arrMois)."' >Du ".date('d/m/Y', strtotime($sej->date_start_organisateur)).' AU '.date('d/m/Y', strtotime($sej->date_end_organisateur))."</th>
								</tr>";

			$htmlresEntete .= "<tr>
								<th style='display:none'></th>
								<th style='display:none'></th>
								<th style='display:none'></th>
								<th id='' style='width:217px'></th>
								<th style='width:58px; text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Num' : 'Number')."</th>";

			$htmlresEntete .= "<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;' colspan='".count($arrMois)."' >Du ".date('d/m/Y', strtotime($debsej)).' AU '.date('d/m/Y', strtotime($endsej))."</th>";					
			
			// construction de la table
			foreach($arrMois as $data){
				$expdt = explode('-',$data);
				// echo('check...'.print_r($data));
				// $htmlresEntete .= "<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".$expdt[0].'<br>'.$expdt[2].'/'.$expdt[1]."</th>";					
				$htmlresEntete .= "<th style='text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".$expdt[2]."</th>";					
			}
			$htmlresEntete .= "</tr></table>";
			
			$htmlres .= "<table id='dispochb' style='text-align: center;'>";
			
			$colEtage = ['#b5b5b3', '#40567a', '#7a4a43', '#848745', '#498559', '#7b4e87', '#ebd7d5', '#f5f567', '#67f5c8', '#8c64fa', '#0ca2c7' ];
			$colFontEtage = ['#FFF', '#FFF', '#FFF', '#FFF', '#FFF', '#FFF', '#000', '#000', '#000', '#FFF', '#FFF' ];
			
			foreach($chAll as $ch){
				
				$colbkgch = $colEtage[(int)substr($ch['etage'],0,1)];
				$colFtch = $colFontEtage[(int)substr($ch['etage'],0,1)];
				
				$idx++;
				$arrPlan = [];
				// construction de la table
				// $htmlres .= "<tr ".(($idx % 2 ) == 0 ? 'style="background-color:#f3f2f2 !important"' : 'style="background-color:'.$colbkgch.' !important"')." id='ch_".$ch['id_chambre']."'>
				$htmlres .= "<tr ".(($idx % 2 ) == 0 ? 'style="background-color:#f3f2f2 !important"' : 'style="background-color:#dad7d7 !important"')." id='ch_".$ch['id_chambre']."'>
										<td style='display:none'></td>
										<td style='display:none'></td>
										<td style='display:none'></td>
										<td id='".$ch['num_chambre']." - ".$ch['capacite']." - td' style='width:80px'>
											<select class='seltypech ".$ch['num_chambre']."' id='".$ch['num_chambre']." - ".$ch['capacite']."'>
												<option value=\"\" ></option>
												<option style='color:blue' value=\"P\" ><a href='#' data-toggle='tooltip' title='PERSONNELS' style='margin:5px' class='btn btn-warning clemp'>Emp.</a></option>
												<option style='color:red' value=\"T\" ><a href='#' data-toggle='tooltip' title='TEMPORAIRE' style='margin:5px' class='btn btn-info cltmp'>Temp.</a></option>
												<option style='color:green' value=\"C\" ><a href='#' data-toggle='tooltip' title='CLIENTS' style='margin:5px' class='btn btn-primary clfiche'>Client</a></option>
												<option style='color:black' value=\"A\" ><a href='#' data-toggle='tooltip' title='ANNULATION TMP et PERSONNEL' style='margin:5px' class='btn btn-danger cldel'>Annule</a></option>
											</select>
										</td>
										<td style='width:58px; text-align: center; background-color:".$colbkgch."; color:".$colFtch."; border: 1px solid black;'>".$ch['num_chambre']." - ".$ch['capacite']."</td>";
										// <td style='width:58px; text-align: center; background-color:#40567a; color:#FFF; border: 1px solid black;'>".$ch['num_chambre']." - ".$ch['capacite']."</td>";
				$isPlan = Planning::getAll(array('id_sejour'=>$sej->id_organisateur, 'num_chambre'=>$ch['num_chambre']));
				// print_r($isPlan);
				// die;
				// if($isPlan->num_rows > 0){
				// 	foreach($isPlan as $pl){
				// 		$debPlan = substr($pl['rdv_start'],0,10);
				// 		$endPlan = substr($pl['rdv_end'],0,10);

				// 		// echo('****'.$debPlan.' = '.$endPlan.' - '.$pl['is_tmp'].' * '.$pl['num_chambre'].'<br>');
				// 		while($debPlan <= $endPlan ){
				// 			$arrPlan[] = $debPlan;
				// 			if($pl['is_tmp'] > 0){
				// 				// echo($debPlan.' = '.$endPlan.' - '.$pl['is_tmp'].' * '.$pl['num_chambre'].'<br>');
				// 				$arrPlanTmp[] = $debPlan;
				// 			};
				// 			$debPlan = date('Y-m-d',strtotime($debPlan. ' + 1 days'));
				// 		}
				// 	}
				// }

				// foreach($arrMois as $data){
					
				// 	if(in_array($data, $arrPlan)){
				// 		$isPlanCh = Planning::findOne(array('id_sejour'=>$sej->id_organisateur, 'LEFT(rdv_start,10)'=>$data, 'LEFT(rdv_end,10)'=>$data, 'num_chambre'=>$ch['num_chambre']));

				// 		$htmlres .= "<td style='text-align: center; background-color:".($isPlanCh->is_tmp > 0 ? 'red' : 'yellow')."; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='checkbox' checked disabled='disabled' /></td>";
				// 	}else{
				// 		$htmlres .= "<td style='text-align: center; background-color:white; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='checkbox'/></td>";
				// 	}
					
				// }
				// $htmlres .= "</tr>";

				if($isPlan->num_rows > 0){
					// recupere derniere date de presence
					$isPlanDateEnd = Planning::findOneMaxDate(array('id_sejour'=>$sej->id_organisateur, 'num_chambre'=>$ch['num_chambre']));
					$endPlan = substr($isPlanDateEnd->MDEND,0,10);
					
					foreach($isPlan as $pl){
						$debPlan = substr($pl['rdv_start'],0,10);
						
						
						// while(strtotime($debPlan) <= strtotime($endPlan) ){
							$arrPlan[] = $debPlan;
							if($pl['is_tmp'] > 0){
								if($pl['is_emp'] > 0){
									$arrPlanTmp[] = $debPlan.' - '.$pl['num_chambre'].' - '.$pl['is_name'].((int)$pl['is_share'] > 0 ? ' - SHARE' : ' - NOT SHARE').' - PERSONNEL';
									$arrPlanClts[] = $debPlan.' * '.$pl['id_fiche'].' * '.$pl['num_chambre'];
								}else{
									$arrPlanTmp[] = $debPlan.' - '.$pl['num_chambre'].' - '.$pl['is_name'].((int)$pl['is_share'] > 0 ? ' - SHARE' : ' - NOT SHARE');
									$arrPlanClts[] = $debPlan.' * '.$pl['id_fiche'].' * '.$pl['num_chambre'];
								}
							}else{
								$arrPlanClts[] = $debPlan.' * '.$pl['id_fiche'].' * '.$pl['num_chambre'];
							};
							
						// 	$debPlan = date('Y-m-d',strtotime($debPlan. ' + 1 days'));
						// }
					}
				}

				// if($isPlan->num_rows > 0){

				// 	echo(print_r($arrPlanTmp).' -- '.print_r($arrPlanClts));
				// 	die;
				// }

				foreach($arrMois as $data){
					
			// die;
					if(in_array($data, $arrPlan)){
						$col = 'green';
						$Tle = '';
						foreach($arrPlanTmp as $cl){
							
							// echo($col.' *** '.$cl.'<br> -- '.substr($cl,-9).' ===>'.$ch['num_chambre'] .' == '. substr($cl,13,strpos(substr($cl,13),' - ')).' && '.$data.' == '.substr($cl,0,10).'<br>');
							if($ch['num_chambre'] == substr($cl,13,strpos(substr($cl,13),' - ')) && $data == substr($cl,0,10)){
								if(substr($cl,-9) == 'PERSONNEL'){
									$expTle = explode('-',$cl);
									$col = (trim($expTle[5]) == 'SHARE' ? 'orange' : 'blue');
									$Tle = "PERSONNEL : ".$expTle[4];
								}else{

									
									// $resDateMinMax = Planning::findOneMinMaxDate(array('id_fiche'=>'0','is_tmp'=>'1',
									// 													'id_sejour'=>$usrActif->cursoc, 
									// 													'num_chambre'=>$ch['num_chambre'],
									// 													'is_name'=>$expTle[4]),true,'','');
									// $isShareTmp = Planning::findOne(array('id_sejour'=>$usrActif->cursoc, 
									// 									'num_chambre'=>$ch['num_chambre'], 
									// 									'is_tmp'=>'1','is_share'=>'1'));
									// if($isShareTmp){
									// 	$isShTmp = 1;
									// }else{
									// 	$isShTmp = 0;
									// }

									$expTle = explode('-',$cl);
									$col = (trim($expTle[5]) == 'SHARE' || ($isShTmp == 0 && strtotime(substr($resDateMinMax->MDEND,0,10)) == substr($cl,0,10)) ? 'orange' : 'red');
									// echo('T : '.$expTle[5].'<br>' );
									$Tle = "TEMPORAIRE : ".$expTle[4];
								}
								break;
							}
							
						}
						foreach($arrPlanClts as $client){
							$arrTitle = explode('*',$client);
							// echo(print_r($arrTitle).'<br>');
							if($arrTitle[2] == $ch['num_chambre'] && strtotime($arrTitle[0]) == strtotime($data) && ($col != 'red' && $col != 'blue')){
								$clts = Fiche::findOne(array('c.id_fiche'=>(int)$arrTitle[1]));

								// liste de toutes les chambres occupees par ce client
								$allCltCh = Chambres::getAll(array('id_fiche'=>(int)$arrTitle[1]));
								$addinf = '';
								if($allCltCh->num_rows > 0){
									$addinf .= ' Chb : [ ';
									foreach($allCltCh as $lstcltch){
										$addinf .= $lstcltch['num_chambre'].', ';
									}
									$addinf = substr($addinf, 0, strripos($addinf,','));
									$addinf .=' ]';
									// str_replace(',','', strripos($addinf,','),1) .=' ]';
								}
								$Tle = $clts->first_name.' '.$clts->last_name.' du '.date('d/m/Y',strtotime($clts->date_start)).' au '.date('d/m/Y',strtotime($clts->date_end)).$addinf;
								
								$usectshare = Planning::FindOne(array('LEFT(rdv_end,10)'=>$data, 'num_chambre'=>$ch['num_chambre'], 'id_fiche'=>(int)$arrTitle[1]));

								$resDateMinMax = Planning::findOneMinMaxDate(array('id_fiche'=>(int)$arrTitle[1],'id_sejour'=>$usrActif->cursoc),true,'','id_fiche');
								$isShareClt = Planning::findOne(array('id_sejour'=>$usrActif->cursoc, 'num_chambre'=>$ch['num_chambre'], 'is_share'=>'1','id_fiche_share'=>(int)$arrTitle[1]));
								if($isShareClt){
									$isShClt = 1;
								}else{
									$isShClt = 0;
								}

								if((strtotime($dtShare) == strtotime($data) && (int)$arrTitle[1] == (int)$usectshare->id_fiche_share) || (int)$usectshare->id_fiche_share > 0 || (strtotime(substr($resDateMinMax->MDEND,0,10)) == strtotime($data) && $isShClt == 0)){
									$col = 'orange';
								}else{
									$col = 'green';
								}
								break;
							}
						}
						// echo('col : '.$col.'<br>' );
						$htmlres .= "<td title='".$Tle."' style='text-align: center; background-color:".$col."; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='checkbox' checked disabled='disabled' style=''/></td>";
					}else{
						$htmlres .= "<td title='' style='text-align: center; background-color:white; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='text'  disabled='disabled' style='height:15px;width:15px;border:none;'/></td>";
					}
					// 	$htmlres .= "<td title='".$Tle."' style='text-align: center; background-color:".$col."; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='checkbox' checked disabled='disabled' /></td>";
					// }else{
					// 	$htmlres .= "<td title='' style='text-align: center; background-color:white; color:#FFF; border: 1px solid black;'><input id='".$data."' class='clchk' type='checkbox'  disabled='disabled'/></td>";
					// }
					
				}
				$htmlres .= "</tr>";
				
			}

			$htmlres .= "</table><br><br>";

			respAjax::successJSON(array('OK' => 'OK','infdelcli'=>$arrAnCli, 'countidcli'=>(count($arrAnCliId) > 0 ? count($arrAnCliId) : 0), 'delidcli'=>$arrAnCliId[0], 'res'=>$htmlres, 'entete'=>$htmlresEntete, 'ids'=>$usrActif->cursoc, 'arrMois'=>json_encode($arrMois), 'ch'=>$chAll->num_rows, 'arrPlanTmp'=>$arrPlanTmp));

			break;

		case 'recup-rglt-extra':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'idsej', 'idextra')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations manquantes' : 'Missing informations')));

			// $rglts = ExtraRglt::getAll(array('id_extra'=>(int)$_POST['idextra'], 'id_sejour'=>(int)$_POST['idsej'], 'id_fiche'=>(int)$_POST['idct'] ));

			$infextra = Extra::findOne(array('id_extraactivite'=>(int)$_POST['idextra'], 'id_sejour'=>(int)$_POST['idsej'], 'id_fiche'=>(int)$_POST['idct']));

			// print_r($infextra);

			$prixextra = 0;
			$payeextra = 0;
			$resteextra = 0;

			if($infextra){
				$prixextra = $infextra->prix_activite;
				$payeextra = $infextra->mt_paye;
				$resteextra = $prixextra - $payeextra;
			}

			// if($rglts->num_rows > 0){
			// 	foreach($rglts as $rglt){
			// 		$payeextra += $rglt['mt_rglt'];
			// 	}
			// }

			

			respAjax::successJSON(array('OK' => 'OK', 
									'message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations règlement' : 'Payment informations'),
									'prixextra'=>$prixextra, 'resteextra'=>$resteextra, 'payeextra'=>$payeextra));

			break;

		case 'paid-reste-solde' :
			if (!Ctrl::ctrlflds($_POST, array('idct', 'idsejour', 'mt')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations manquantes' : 'Missing informations')));

			if((float)$_POST['mt'] > (float)$_POST['totreste']){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Le montant saisie est superieur au solde du' : 'The amount entered is greater than the balance due')));
			}

			$mt = $_POST['mt'];
			$resteClt = Bar::getAll(array('id_fiche'=>(int)$_POST['idct'], 'id_sejour'=>(int)$_POST['idsejour']));

			foreach($resteClt as $reste){
				if((float)$mt >= (float)$reste['prix_reste_bar']){
					$mt = $mt  - $reste['prix_reste_bar'];
					Bar::update(array('prix_reste_bar'=>'0', 'prix_paye_bar'=>$reste['mt_du_bar']),array('id_bar'=>(int)$reste['id_bar'], 'id_fiche'=>(int)$_POST['idct'], 'id_sejour'=>(int)$_POST['idsejour']));
				}else{
					$prxReste = (float)$reste['prix_reste_bar'] - (float)$mt;
					$prxPaye = (float)$reste['prix_paye_bar'] + (float)$mt;
					Bar::update(array('prix_reste_bar'=>(float)$prxReste, 'prix_paye_bar'=>$prxPaye),array('id_bar'=>(int)$reste['id_bar'], 'id_fiche'=>(int)$_POST['idct'], 'id_sejour'=>(int)$_POST['idsejour']));
					$mt = 0;
				}
			}

			$sql = "SELECT
							SUM(COALESCE(prix_reste_bar,0)) AS SumReste
						FROM
							db_bar";
			$res = QueryExec::querySQL($sql, true);

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Paiement effectué' : 'Amount added'), 'totgl'=>$res->SumReste));
			break;

		case 'add-rglt-extra':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idficheextra', 'idsejourextra', 'idextra')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations manquantes' : 'Missing informations')));

			
			if(!Extra::update(array('prix_activite'=>$_POST['prixextra'],'mt_paye'=>$_POST['payeextra'] + $_POST['mtrglt'],'mt_restant'=>$_POST['prixextra'] - ($_POST['payeextra'] + $_POST['mtrglt'])),
								array('id_extra'=>(int)$_POST['idextra'], 
										'id_sejour'=>(int)$_POST['idsejourextra'], 
										'id_fiche'=>(int)$_POST['idficheextra'],
				))){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur Ajout' : 'Not adding')));
				}

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout effectué' : 'Amount added')));


			/* 
				**** CHANGEMENT DE LOGIQUE, ON NE GARDE QUE LA TABLE db_extra_activite ****
			if(!ExtraRglt::create(array('id_extra'=>(int)$_POST['idextra'], 
										'id_sejour'=>(int)$_POST['idsejourextra'], 
										'id_fiche'=>(int)$_POST['idficheextra'],
										'mt_rglt'=>$_POST['mtrglt'] ))){
											respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur Ajout' : 'Not adding')));
										}

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout effectué' : 'Amount added')));
			*/

			break;

		case 'get-tot-reste-bar' :
			
			$wh = '';
			$selrows = implode(',',$_POST['selrows']);

			$sql = "SELECT
							SUM(COALESCE(prix_reste_bar,0)) AS SumReste
						FROM
							db_bar";

			// echo $sql;
			$res = QueryExec::querySQL($sql, true);
			if ($res) {
				respAjax::successJSON(array('OK' => 'OK', 'totgl'=>Tool::displayMt($res->SumReste)));
			}
			else{
				respAjax::successJSON(array('OK' => 'OK', 'totgl'=>'0'));
			}
		break;

		case 'get-tot-sel-bar' :
			$wh = '';
			if (!Ctrl::ctrlflds($_POST, array('idct'))){
				$wh = " WHERE id_fiche IN (-1) ";
			}else{
				$wh = " WHERE id_fiche IN (". (int)$_POST['idct'] .") ";
			}
				// respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix de client obligatoire' : 'Mandatory customer choice')));

			
			$sql = "SELECT
							SUM(COALESCE(prix_reste_bar,0)) AS SumReste
						FROM
							db_bar";


			$sql .= $wh ;
			
			// echo $sql;
			$res = QueryExec::querySQL($sql, true);
			if ($res) {
				respAjax::successJSON(array('OK' => 'OK', 'totsel'=>Tool::displayMt($res->SumReste)));
			}
			else{
				respAjax::successJSON(array('OK' => 'OK', 'totsel'=>'0'));
			}
		break;


		case 'read-tarif-bar' :
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('app', 'idprod')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations manquantes' : 'Missing informations')));

				$res = Stock::findOneProduit(array('id_produit'=>(int)$_POST['idprod']));

				if($_POST['app'] == 'P'){
					respAjax::successJSON(array('OK' => 'OK', 'tarif'=>$res->prix_bar_produit));
				}
				if($_POST['app'] == 'Q'){
					respAjax::successJSON(array('OK' => 'OK', 'mtdu'=>($res->prix_bar_produit * (int)$_POST['qte'])));
				}
				if($_POST['app'] == 'R'){
					respAjax::successJSON(array('OK' => 'OK', 'mtreste'=>($res->prix_bar_produit * (int)$_POST['qte']) - (float)$_POST['mt']));
				}
			break;

		case 'ctrl-stock' :
			$alerteStocks = Stock::stockSql("SELECT * FROM db_produits WHERE val_produit <= niv_alerte_produit AND niv_alerte_produit > 0");
			$html = '
			
            	<thead>
                            <tr>
                                <th style="width:20%">Nom Produit</th>
                                <th style="width:20%">Description Produit</th>
                                <th style="width:20%">Valeur Produit</th>
                                <th style="width:20%">Alerte</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
                                
			$idpdt = 0;
			foreach($alerteStocks as $stock ){

				$html .= '<tr>';
				if($stock['id_produit'] != $idpdt){
					$html .= '<td>'.$stock['name_produit'].'</td>';
					$html .= '<td>'.$stock['desc_produit'].'</td>';
					$html .= '<td>'.$stock['val_produit'].'</td>';
					$html .= '<td>'.$stock['niv_alerte_produit'].'</td>';
					$html .= '<td><button class="btn-open-page" data-id="1">Ouvrir</button></td>';
					$idpdt = $stock['id_produit'];
				}
				$html .= '</tr>';
			}
            $html .='
                        </tbody>
            ';

			respAjax::successJSON(array('OK' => 'OK', 'html'=>$html, 'isalerte'=>($alerteStocks->num_rows > 0 ? $alerteStocks->num_rows : 0)));
			break;

		case 'ctrl-stock-ajax' :
			// $alerteStocks = Stock::stockSql("SELECT id_produit, name_produit, desc_produit, val_produit, niv_alerte_produit FROM db_produits WHERE val_produit <= niv_alerte_produit AND niv_alerte_produit > 0");
			$alerteStocks = Stock::stockSql("SELECT name_produit, desc_produit, val_produit, niv_alerte_produit FROM db_produits WHERE val_produit <= niv_alerte_produit AND niv_alerte_produit > 0");
                                
			$idpdt = 0;
			foreach($alerteStocks as $stock ){

				$html[] = $stock;
			}

			respAjaxStandard::successJSON(array('OK' => 'OK', 'data'=>$html, 'isalerte'=>($alerteStocks->num_rows > 0 ? $alerteStocks->num_rows : 0)));
			break;

		case 'connect-mail':
			$resInfmail = InfosGenes::findOneMail(array('is_get'=>'1'));
			if(!$resInfmail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune boite mail n\'a été paramétrée pour la réception.<br>Modifiez vos paramétrages !' : 'No mailbox has been configured<br>Modify your parameters')));
			}else{
				// if(strstr(strtoupper($resInfmail->inf_username), 'GMAIL') == false){
				// 	respAjax::errorJSON(array('message' => 'Aucune boite GMAIL n\'a été paramétrée pour la réception.<br>Modifiez vos paramétrages !'));
				// }
			}
			
			function get_attachments($content, $part = null, $skip_parts = false) {
				static $results;
			  
				// First round, emptying results
				if (is_null($part)) {
					$results = array();
				}
				else {
					// Removing first dot (.)
					if (substr($part, 0, 1) == '.') {
						$part = substr($part, 1);
					}
				}
			  
				// Saving the current part
				$actualpart = $part;
				// Split on the "."
				$split = explode('.', $actualpart);
			  
				// Skipping parts
				if (is_array($skip_parts)) {
					foreach ($skip_parts as $p) {
						// Removing a row off the array
						array_splice($split, $p, 1);
					}
					// Rebuilding part string
					$actualpart = implode('.', $split);
				}
			  
				// Each time we get the RFC822 subtype, we skip
				// this part.
				if (strtolower($content->subtype) == 'rfc822') {
					// Never used before, initializing
					if (!is_array($skip_parts)) {
						$skip_parts = array();
					}
					// Adding this part into the skip list
					array_push($skip_parts, count($split));
				}
			  
				// Checking ifdparameters
				if (isset($content->ifdparameters) && $content->ifdparameters == 1 && isset($content->dparameters) && is_array($content->dparameters)) {
					foreach ($content->dparameters as $object) {
						if (isset($object->attribute) && preg_match('~filename~i', $object->attribute)) {
							$results[] = array(
							'type'          => (isset($content->subtype)) ? $content->subtype : '',
							'encoding'      => $content->encoding,
							'part'          => empty($actualpart) ? 1 : $actualpart,
							'filename'      => $object->value
							);
						}
					}
				}
			  
				// Checking ifparameters
				else if (isset($content->ifparameters) && $content->ifparameters == 1 && isset($content->parameters) && is_array($content->parameters)) {
					foreach ($content->parameters as $object) {
						if (isset($object->attribute) && preg_match('~name~i', $object->attribute)) {
							$results[] = array(
							'type'          => (isset($content->subtype)) ? $content->subtype : '',
							'encoding'      => $content->encoding,
							'part'          => empty($actualpart) ? 1 : $actualpart,
							'filename'      => $object->value
							);
						}
					}
				}
			  
				// Recursivity
				if (isset($content->parts) && count($content->parts) > 0) {
					// Other parts into content
					foreach ($content->parts as $key => $parts) {
						get_attachments($parts, ($part.'.'.($key + 1)), $skip_parts);
					}
				}
				return $results;
			}

			// Configuration
			// $serverimap = '{pro2.mail.ovh.net:993/imap/ssl}INBOX';
			// $login = 'kosher@mhpalace.com';
			// $password = 'Amerique67000!';
			// Configuration
			
			// $serverimap = '{imap.gmail.com:993/imap/ssl}INBOX';
			// $serverimap = '{imap.ionos.fr:993/imap/ssl}INBOX';
			// $login = $resInfmail->inf_username; //'Mendibenech@gmail.com';
			// $password = $resInfmail->inf_password; //'laqmhyicukxxamxz';
			// $export_dir ="./attachment/";
			$serverimap = '{imap.gmail.com:993/imap/ssl}INBOX';
			$login = 'cassuto.david770@gmail.com';
			$password = 'ldbepylaqwhplkjp';
			$export_dir ="./attachment/";
			// $serverimap = '{imap.gmail.com:993/imap/ssl}INBOX';
			// $login = 'david.cassuto770@gmail.com';
			// $password = 'bloqlmfwdcwjvhip';
			// $export_dir ="./attachment/";

			//Connexion au serveur email
			$mbox = imap_open("$serverimap", "$login", "$password");

			//Nombre de message dans la boite mail
			$num = imap_num_msg($mbox);
			
			/* Search emails from gmail inbox*/
			// $mails = imap_search($conn, 'SUBJECT "TR: Votre offre"');
			$mails = imap_search($mbox, 'UNSEEN');
			// $mails = imap_search($mbox, 'ALL');
			
			// print_r($mails);

				//Si il y a aucun message
				if($num==0)
				{
					respAjax::successJSON(array('OK'=>'OK', 'html'=>""));
				}
				//Si il y a des messages alors on affiche le nombre $numheaderInfo
				else
				{     
					
					/* Mail output variable starts*/
					
					/* rsort is used to display the latest emails on top */
					rsort($mails);


					// *-*-*-*-*-*-*-*-*-*-
					$mailOutput = '';
					$mailOutput.= '<table id="idimap" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th> 
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'De...' : 'From').'  
											</th> 
											<th> 
												Date 
											</th> 
											<th>
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') .'
											</th>
											<th>
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Message' : 'Message') .'
											</th>
											<th> 
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pieces jointes' : 'Attachments') .'
											</th> 
											<th> 
												Actions 
											</th>
										</tr>
									</thead>
									<tbody>';   


					/* For each email */
					foreach ($mails as $email_number) {
						$arrMail = array();
						$fromMail = '';
						$pj = '';

						//On récupère avec la fonction imap_headerInfoinfo le contenue du mail
						$headers = imap_fetch_overview($mbox, $email_number,0);
						$headerInfo = imap_headerinfo($mbox, $email_number);

						foreach($headerInfo->from as $fromAdd){
							// echo($fromAdd->mailbox.'@'.$fromAdd->host.'<br>');
							$fromMail = $fromAdd->mailbox.'@'.$fromAdd->host;
						}
						
						$uid = $headers[0]->uid;

						$datetime = $headerInfo->date; // L'heure du message
						$subject = $headerInfo->subject; // Le sujet
						$messageid = $headerInfo->message_id; // L'id du message
						$toaddress = $headerInfo->toaddress; // Adresse de réception
						$fromaddress = $headerInfo->fromaddress; // Expéditeur
						$recent = $headerInfo->Recent; // Message récent -> O (oui)  N (non)
						$size = $headerInfo->Size; // Taille du mail
						$numeromail = $headerInfo->Msgno; // Numéro du mail
						$fromemail = '{'.$headerInfo->from[0]->mailbox.'@'.$headerInfo->from[0]->host.'}'; //On récupère les différentes valeurs pour reconstruire l'email de l'expéditeur
						
						
						// Décodage et mise en forme
						$subject = str_replace("_"," ", mb_decode_mimeheader($subject));
						$subject = trim(substr(quoted_printable_decode($subject), 0,500000));
						
						// Maintenant je vais travailler le corps du message pour afficher le contenue en text et télécharger la pièce jointe
					
						$content = false; 
						
						$structure = imap_fetchstructure($mbox, $email_number);

						// Getting attachments
						// Will return an array with all included files
						// Also works with inline attachments
						$attachments = get_attachments($structure);
				
						// print_r($headers);
						// print_r($headerInfo);
						// die;
						// You are now able to get attachments' raw content

						foreach ($attachments as $k => $at) {
							$filename = $export_dir.'id_'.$email_number.'_part_'.str_replace('.', '-', $at['part']).'_'.$at['filename'];
							$content = imap_fetchbody($mbox, $email_number, $at['part']);
				
							if ($content !== false && strlen($content) > 0 && $content != '') {
								switch ($at['encoding']) {
									case '3':
										$content = base64_decode($content);
									break;
				
									case '4':
										$content = quoted_printable_decode($content);
									break;
								}
				
								file_put_contents($filename, $content);
								
								// $pj .= $at['filename'].'<br>';
								$pj .= '<div class=""><a href="'.$filename.'" target="_blank" >' . $at['filename'] . '</a></div>';
							}
						}

						// echo('1.1'.print_r(imap_fetchbody($mbox,$email_number,1.1)));
						// echo('1'.print_r(imap_fetchbody($mbox,$email_number,1.1)));
						// echo('2'.print_r(imap_fetchbody($mbox,$email_number,1.1)));

						/* **************************************************** */
						// if ($content !== false && strlen($content) > 0 && $content != '') {
						// 	$bodyText = imap_fetchbody($mbox,$email_number,1.1);
						// 	if(strlen($bodyText) <= 0){
						// 		$bodyText = imap_fetchbody($mbox,$email_number,1);
						// 		if(strlen($bodyText) <= 0){
						// 			$bodyText = imap_fetchbody($mbox,$email_number,2);
						// 		}
						// 	}
						// 	$bodyText = trim(substr(quoted_printable_decode($bodyText), 0,500000));
						// }else{
						// 	$bodyText = imap_fetchbody($mbox,$email_number,1.1);
						// 	if(strlen($bodyText) <= 0){
						// 		$bodyText = imap_fetchbody($mbox,$email_number,1);
						// 		if(strlen($bodyText) <= 0){
						// 			$bodyText = imap_fetchbody($mbox,$email_number,2);
						// 		}
						// 	}
						// 	$bodyText = trim(quoted_printable_decode($bodyText));
						// }
						/* ********************************************************* */
						$messageimap = imap_fetchbody($mbox, $email_number,  FT_PEEK);
						$messageimap2 = imap_fetchstructure($mbox, $email_number);
						
						switch ((int)$messageimap2->parts[0]->encoding){
							case 0:
								$finalMessageimap = imap_8bit($messageimap);
								break;
							case 1:
								$finalMessageimap = imap_8bit($messageimap);
								break;
							case 2:
								$finalMessageimap = imap_binary($messageimap);
								break;
							case 3:
								$finalMessageimap = imap_base64($messageimap);
								break;
							case 4:
								$finalMessageimap = quoted_printable_decode($messageimap);
								break;
							case 5:
								break;
							default:
								$finalMessageimap = $messageimap;
								break;
						}
						// echo($finalMessageimap.'<br>'.base64_decode($messageimap).'<br>'.$messageimap);
						// echo('...'.print_r($messageimap2->parts[0]->encoding).'<br>'.print_r($messageimap));
						// die;
						

						// $subMessageimap = substr($messageimap, 0, 150);						
						// $finalMessageimap = trim(quoted_printable_decode($subMessageimap));



						// pour test
						// $toto = imap_fetchbody($mbox,$email_number,1.1);
						// echo('1.1'.strlen($bodyText));
						// if(strlen($toto)<=0){
						// 	$toto = imap_fetchbody($mbox,$email_number,1);
						// 	echo('<br>1'.trim(substr(quoted_printable_decode($toto), 0,500000)).' taille :'.strlen($toto));
						// }
						// echo($bodyText);
						// die;
				
						$arrMail['id_fiche'] = 0;
						$arrMail['to'] = $login;
						$arrMail['from'] = $fromMail;
						$arrMail['alias'] = $headers[0]->from;
						$arrMail['subject'] = imap_utf8($headers[0]->subject);
						$arrMail['msg'] = $finalMessageimap; //$bodyText;
						$arrMail['date'] = $headers[0]->date;
						$arrMail['uuid'] = $headers[0]->uid;
						// $arrMail['name_pj'] = $pj;
						// echo($headers[0]->date.'<br>'.$bodyText);
				
						$res = Mailings::saveMail($arrMail, 0); 

						if($res){
							Pj::create(array('id_mail'=>$res->id_mail, 'name_pj'=>$pj));
						}



						// *-*-*-*-*-*-*-*-*-*-
						$mailOutput.= '<tr>';

						/* Gmail MAILS header information */                   
						
						$mailOutput.= '<td>
										<span class="columnClass">' . $fromMail . '<' . $fromMail .'></span>
									</td>';
						$mailOutput.= '<td>
										<span class="columnClass">' . date('d/m/Y', strtotime($headers[0]->date)) . '</span>
									</td>';
									$mailOutput.= '<td>
									<span class="columnClass">' . imap_utf8($headers[0]->subject) . '</span>
									</td> ';
						$mailOutput.= '<td>
										<span class="columnClass">' . $finalMessageimap . '</span>
									</td> ';
						$mailOutput.= '<td>
										<span class="columnClass">' . $pj . '</span>
									</td>';
						$mailOutput.= '<td id="' . $headers[0]->uid . '">
										
									</td>';


						$mailOutput.= '</tr>';
						
					}// End foreach
					$mailOutput.= '</tbody></table>';

				} // Fin de si il y a des messages 
				/* imap connection is closed */
				imap_close($mbox);

				// commentaire tmp pour test en direct plus haut
				/*
					$mailOutput = '';
					$mailOutput.= '<table id="idimap" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th> 
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'De' : 'From').'  
											</th> 
											<th> 
												Date 
											</th> 
											<th>
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') .'
											</th>
											<th>
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Message' : 'Message') .'
											</th>
											<th> 
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pieces jointes' : 'Attachments') .'
											</th> 
											<th> 
												Actions 
											</th>
										</tr>
									</thead>
									<tbody>';   

									
					$resImaps = Imap::getAll();
					// print_r($resImaps);
					// die;
					
					foreach($resImaps as $resImap){
						$mailOutput.= '<tr>';

						// Gmail MAILS header information                   
						
						$mailOutput.= '<td>
										<span class="columnClass">' . $resImap['from_mail'] . '<' . $resImap['from_mail'] .'></span>
									</td>';
						$mailOutput.= '<td>
										<span class="columnClass">' . date('d/m/Y', strtotime($resImap['date_mail'])) . '</span>
									</td>';
									$mailOutput.= '<td>
									<span class="columnClass">' . $resImap['subject_mail'] . '</span>
									</td> ';
						$mailOutput.= '<td>
										<span class="columnClass">' . $resImap['msg_mail'] . '</span>
									</td> ';
						$mailOutput.= '<td>
										<span class="columnClass">' . $resImap['name_pj'] . '</span>
									</td>';
						$mailOutput.= '<td id="' . $resImap['uuid_mail'] . '">
										<div class="btn-group">
											<a href="#" data-toggle="tooltip" data-id-mail="'.$resImap['id_mail'].'" data-to="'.$resImap['to_mail'].'" data-from="'.$resImap['from_mail'].'" data-id="' . $resImap['uuid_mail'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Visualiser le message' : 'Read the message').'" class="btn btn-xs btn-info btread" style="margin:7px"><i class="fa fa-newspaper-o"></i></a>
											<a href="#" data-toggle="tooltip" data-to="'.$resImap['to_mail'].'" data-from="'.$resImap['from_mail'].'" data-id="' . $resImap['uuid_mail'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Répondre' : 'Forward').'" class="btn btn-xs btn-success '.($arrAccess['send_mail_inbox'] == '1' ? 'btforward' : '').'" style="margin:7px"><i class="fa fa-send"></i></a>
										</div>
									</td>';


						$mailOutput.= '</tr>';

					}

					$mailOutput.= '</tbody></table>';
				*/

				respAjax::successJSON(array('OK'=>'OK', 'html'=>$mailOutput));
			break;

		case 'connect-mail-outbox':
			$outBox = Imap::getAll(array('m.is_send_mail'=>'1'));

			// print_r($outBox);
			
			if($outBox->num_rows <= 0)
				{
					$mailOutput.= '<table id="idimap" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th> 
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'De' : 'From').'
											</th> 
											<th> 
												Date  
											</th> 
											<th>
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject').' 
											</th>
											<th> 
												Message 
											</th>
											<th> 
												Actions 
											</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>';
					respAjax::successJSON(array('OK'=>'OK', 'html'=>$mailOutput));
				}
				//Si il y a des messages alors on affiche le nombre $numheaderInfo
				else
				{     
					/* Mail output variable starts*/
					$mailOutput = '';
					$mailOutput.= '<table id="idimap" class="display table table-striped table-bordered" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th> 
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire' : 'Recipient').'  
											</th> 
											<th> 
												Date 
											</th> 
											<th>
												'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject').' 
											</th>
											<th> 
												Message 
											</th>
											<th> 
												Actions 
											</th>
										</tr>
									</thead>
									<tbody>';   

					
					foreach ($outBox as $email_number) {
						$arrMail = array();
						$fromMail = '';
						$pj = '';

						$datetime = $email_number['date_mail']; // L'heure du message
						$subject = $email_number['subject_mail']; // Le sujet
						$toaddress = $email_number['to_mail']; // Adresse de réception
						$fromaddress = $email_number['from_mail']; // Expéditeur
						
						// Décodage et mise en forme
						$subject = str_replace("_"," ", mb_decode_mimeheader($subject));
						$subject = trim(substr(quoted_printable_decode($subject), 0,500000));

						$bodyText = trim(quoted_printable_decode($email_number['msg_mail']));
						$bodyText = str_replace('<br />', '<br>', $email_number['msg_mail']);
						
						$mailOutput.= '<tr>';

						/* Gmail MAILS header information */                   
						
						$mailOutput.= '<td><span class="columnClass">' . $toaddress. '</span>
									</td>';
						$mailOutput.= '<td><span class="columnClass">' . date('d/m/Y', strtotime($datetime)) . '</span>
									</td>';
						$mailOutput.= '<td>
										<span class="columnClass">' . $subject . '</span>
									</td> ';
						/* Mail body is returned */
						$mailOutput.= '<td>
										<span class="column">' . $bodyText . '</span>
									</td>';
						$mailOutput.= '<td id="' . $email_number['id_mail'] . '">
										<a href="#" data-toggle="tooltip" data-to="'.$toaddress.'" data-from="'.$fromaddress.'" data-id="'.$email_number['id_mail'].'" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Répondre' : 'Forward').'" class="btn btn-xs btn-success '.($arrAccess['send_mail_outbox'] == '1' ? 'btforward' : '').'"><i class="fa fa-send" style="width: 100px;height: 23px;text-align: center;vertical-align: sub;"></i></a>
									</td>
								</tr>';
					}// End foreach
					
					$mailOutput.= '</tbody></table>';
				} 

				// print_r($mailOutput);

				respAjax::successJSON(array('OK'=>'OK', 'html'=>$mailOutput));
			break;

		case 'maj-ages-tarifs':
			if (!Ctrl::ctrlflds($_POST, array('ageadulte', 'ageenfant', 'agebb'))){
				
			}else{
				if((int)$_POST['ageadulte'] > 0 && ((int)$_POST['ageenfant'] == 0 || (int)$_POST['agebb'] == 0) ){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Age(s) manquant(s), tous doivent etre renseignés' : 'Missing ages')));
				}
				if((int)$_POST['ageenfant'] > 0 && ((int)$_POST['ageadulte'] == 0 || (int)$_POST['agebb'] == 0) ){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Age(s) manquant(s), tous doivent etre renseignés' : 'Missing ages')));
				}
				if((int)$_POST['agebb'] > 0 && ((int)$_POST['ageadulte'] == 0 || (int)$_POST['ageenfant'] == 0) ){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Age(s) manquant(s), tous doivent etre renseignés' : 'Missing ages')));
				}
			}

			$resage = Tarif::getAllAge('');
			if($resage->num_rows > 0){
				foreach($resage as $age){
					$idage = $age['id_age_tarif'];
				}
				Tarif::updateAge(array('age_adulte'=>(int)$_POST['ageadulte'], 'age_enfant'=>(int)$_POST['ageenfant'], 'age_bb'=>(int)$_POST['agebb']), array('id_age_tarif'=>$idage));
			}else{
				Tarif::createAge(array('age_adulte'=>(int)$_POST['ageadulte'], 'age_enfant'=>(int)$_POST['ageenfant'], 'age_bb'=>(int)$_POST['agebb']));
			}
			respAjax::successJSON(array('OK'=>'OK'));

			break;

		case 'read-msg-mail':
			if (!Ctrl::ctrlflds($_POST, array('idmail')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Identifiant email incorrect' : 'Incorrect email id')));

			$res = Imap::findOne(array('id_mail'=>(int)$_POST['idmail']));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Identifiant email introuvable' : 'Email id not found')));
			}

			respAjax::successJSON(array('OK' => 'OK', 'data'=>$res));
			break;

		case 'recup-infos-mail':
			if (!Ctrl::ctrlflds($_POST, array('uid')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Identifiant email incorrect' : 'Incorrect email id')));

			if((int)$_POST['outbox'] == 1){
				$res = Imap::findOne(array('id_mail'=>$_POST['uid']));
			}else{
				$res = Imap::findOne(array('uuid_mail'=>$_POST['uid']));
			}
			
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Identifiant email introuvable' : 'Email id not found')));
			}

			respAjax::successJSON(array('OK' => 'OK', 'data'=>$res));
			break;

		case 'valide-cmd':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('numcmd', 'idfourn')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations manquante' : 'Missing informations')));

			if($_POST['idfourn'] == '0'){
				respAjax::errorJSON(array('message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Merci de bien selectionner le fournisseur' : 'Please select the supplier carefully')));
			}

			$cptcmd = Cmd::getAll(array('num_cmd'=>$_POST['numcmd']));
			if($cptcmd->num_rows <= 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune ligne de detail, pour cette commande' : 'No details line for this order')));
			}

			$typemail = ModelMail::findOne(array('type_mail'=>'1'));
			if(!$typemail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun modèle de message n\'existe pour les commandes' : 'No message template exists for commands')));
			}

			$dirup = __DIR__ . '/uploads/fournisseurs/';

			$dir = $dirup . (int)$_POST['idfourn'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}
			
			$frn = Fournisseurs::findOne(array('id_fournisseur'=>(int)$_POST['idfourn']));
			$attach = array();

			$doc = IsoPDFBuilder::BuildCommande($frn, $_POST['numcmd'], $usrActif->cursoc, false);

			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			$attach[] = $dir . '/' . $nm;

			$res = Cmd::update(array('etat_cmd'=>'1','is_validate'=>'1','date_cmd'=>date('Y-m-d')), array('id_fournisseur'=>(int)$_POST['idfourn'], 'id_sejour'=>$usrActif->cursoc, 'num_cmd'=>$_POST['numcmd']));

			$msg = $typemail->msg;
			
			$result = ModelMail::replaceVarsCmd($frn->id_fournisseur, $typemail->id_mailtype, $usrActif);

			$res = $result['data'];
			$msg = $result['msg'];

			
			if($res){
			
				if($frn->mail_fournisseur != ''){
					if(Mailings::sendMail('mail-contact', (object)array(
						'subject' => $result['subject'],
						'email' => $frn->mail_fournisseur,
						'msg' => $msg,
						'doc' => $attach
					))){				
						$mailok = '1';
					}else{
						$mailok = '0';
					}
				}
				// $numcmd = Cmd::getLastNoCmd(array('id_sejour'=>max($usrActif->cursoc, 1)));
				
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commande '.$_POST['numcmd'].' validée et transmise par mail' : 'Order validated and sended by email'), 'sendmailfourn'=>$mailok, 'doc'=>$doc, 'cansign'=>'1'));
			}
			

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commande '.$_POST['numcmd'].' non validée' : 'Order not validated')));
			break;

		case 'print-cmd':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('numcmd', 'idfourn')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$dirup = __DIR__ . '/uploads/fournisseurs/';

				$dir = $dirup . (int)$_POST['idfourn'];
				if (!is_dir($dir)) {
					mkdir($dir);
					copy($dirup . 'index.php', $dir . '/index.php');
				}
				
				$frn = Fournisseurs::findOne(array('id_fournisseur'=>(int)$_POST['idfourn']));
				$attach = array();

				$doc = IsoPDFBuilder::BuildCommande($frn, $_POST['numcmd'], $usrActif->cursoc, false);
	
				$nm = substr($doc,strripos($doc, '/') + 1);
				$nm = substr($nm, 0,strpos($nm,'?'));
				$attach[] = $dir . '/' . $nm;

				respAjax::successJSON(array('OK' => 'OK', 'doc'=>$doc, 'cansign'=>'1'));
				
			break;

		case 'cmd-detail':
			if (!Ctrl::ctrlflds($_POST, array('numcmd')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$cpt = 0;
				$html = '<table id="det"'.$_POST['numcmd'].'">
				<tbody style="border-style: inset;border-color: transparent;border-width: 21px;">
					<tr style="background-color:#aae1f2">
						<th>
							'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Produit' : 'Product').'
						</th>
						<th>
							'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Unite' : 'Unit').'
						</th>
						<th>
							Qte
						</th>
					</tr>';
				$res = Cmd::getAllDetails(array('num_cmd'=>$_POST['numcmd'], 'id_sejour'=>$usrActif->cursoc));
				foreach($res as $data){
					$html .= '
								<tr style="'.($cpt % 2 == 0 ? 'background-color:#ebd4bb' : '').'">
									<td>'.$data['name_produit'].'</td>
									<td>'.$data['name_unite'].'</td>
									<td>'.$data['val_qte'].'</td>
								</tr>';
					$cpt++;
				}

				$html .= '</tbody></table>';
				respAjax::successJSON(array('OK' => 'OK', 'html'=>$html));
			break;

		case 'find-mail-fourn':
			if (!Ctrl::ctrlflds($_POST, array('idfourn')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = Fournisseurs::findOne(array('id_fournisseur'=>(int)$_POST['idfourn']));
			if($res){
				respAjax::successJSON(array('OK' => 'OK', 'email'=>$res->mail_fournisseur));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun mail' : 'Not email')));

			break;

		case 'reset-cmd':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('numcmd', 'idfourn')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				// $res = Cmd::delete(array('id_fournisseur'=>(int)$_POST['idfourn'], 'id_sejour'=>$usrActif->cursoc, 'num_cmd'=>$_POST['numcmd']));
				$res = Cmd::update(array('is_annule'=>'1'),array('id_fournisseur'=>(int)$_POST['idfourn'], 'id_sejour'=>$usrActif->cursoc, 'num_cmd'=>$_POST['numcmd']));

				if($res){
					$numcmd = Cmd::getLastNoCmd(array('id_sejour'=>max($usrActif->cursoc, 1)));
	
					$html = '<select data-placeholder="Choisissez la commande " class="form-control select-chosen" id="id_cmd" name="id_cmd" style="/*width: 200px;*/">
					<option value=""></option>';
					
					$cmds = Cmd::getAllEnCours(array('is_validate'=>'0', 'is_annule'=>'0', 'id_sejour'=>$usrActif->cursoc));
					if ($cmds) {
						foreach ($cmds as $cmd) {
							$html .= '<option data-fourn="'.$cmd['id_fournisseur'].'" data-numcmd="'.$cmd['num_cmd'].'" value="' . $cmd['num_cmd'] . '" >' . $cmd['num_cmd'] . '</option>';
						}
					}
					$html .= '</select>';

					respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commande Annulée' : 'Order cancelled'), 
											'numcmd'=>'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT), 'htmlsel'=>$html));
				}

				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commande non annulée' : 'Order not cancelled')));
			break;

		case 'add-cmd':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('numcmd', 'idprod', 'idfourn', 'idunit', 'qte')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$res = Cmd::create(array('id_fournisseur'=>(int)$_POST['idfourn'], 'id_produit'=>(int)$_POST['idprod'], 'id_unite'=>(int)$_POST['idunit'], 'val_qte'=>str_replace(',','.',$_POST['qte']), 'id_sejour'=>$usrActif->cursoc, 'etat_cmd'=>'0', 'date_cmd'=>date('Y-m-d'), 'num_cmd'=>$_POST['numcmd']));

				if($res){
					respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ligne de commande ajoutée' : 'Order details added')));
				}

				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ligne de commande non ajoutée' : 'Order details not added')));
			break;

		case 'update-plan':
			if($_POST['app'] != 'DROP'){
				if (!Ctrl::ctrlflds($_POST, array('hour_start', 'hour_end', 'date_fixed', 'id_activite', 'idmono')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			}
		
			$mono = Monos::findOne(array('id_mono'=>(int)$_POST['idmono']));

			if($_POST['app'] == 'UPDT'){

				$dur = date('H:i', strtotime($_POST['hour_end']) - strtotime($_POST['hour_start']));

				if(KidsClub::updateRdv(array('duration'=>$dur, 'date_rdv'=>Tool::dmYtoYmd($_POST['date_fixed']), 'rdv_start'=>$_POST['hour_start'], 'rdv_end'=>$_POST['hour_end'], 'id_activite'=>$_POST['id_activite'],'lieu_rdv'=>$_POST['lieu']),array('id_mono'=>$_POST['idmono'],'id_rdv'=>(int)$_POST['idrdv']))){
					respAjax::successJSON(array('OK' => 'OK'));
				};
			}else{
				if($_POST['app'] == 'DROP'){
					$evt = KidsClub::findOneRdv(array('id_rdv'=>$_POST['idevt']));
					$t = substr($_POST['start'],11);
					$dur = explode(':',$evt->duration);
					$tEnd = date('H:i', strtotime('+'.$dur[0].' hour +'.$dur[1].' minutes',strtotime($t)));

					if(KidsClub::updateRdv(array('duration'=>$evt->duration, 'date_rdv'=>substr($_POST['start'],0,10), 'rdv_start'=>substr($_POST['start'],11), 'rdv_end'=>$tEnd),array('id_rdv'=>$_POST['idevt'])) ){
						respAjax::successJSON(array('OK' => 'OK'));
					}
				}
				else{
					// echo('ici22');
					$dur = date('H:i', strtotime($_POST['hour_end']) - strtotime($_POST['hour_start']));

					if(KidsClub::CreateRdv(array('color_rdv'=>'#7d067d','id_groupe'=>$mono->id_groupe,'duration'=>$dur, 'id_mono'=>$_POST['idmono'],'date_rdv'=>Tool::dmYtoYmd($_POST['date_fixed']), 'rdv_start'=>$_POST['hour_start'], 'rdv_end'=>$_POST['hour_end'], 'id_activite'=>$_POST['id_activite'],'lieu_rdv'=>$_POST['lieu']))){
						respAjax::successJSON(array('OK' => 'OK'));
					};
				}
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout dans le planing échoué' : 'Addition to planing, failed')));
			break;

		case 'update-planning-chambre':
			if($_POST['app'] != 'DROP'){
			
			$mono = Monos::findOne(array('id_maono'=>(int)$_POST['idmono']));

			if($_POST['app'] == 'UPDT'){

				$dur = date('H:i', strtotime($_POST['hour_end']) - strtotime($_POST['hour_start']));

				if(KidsClub::updateRdv(array('duration'=>$dur, 'date_rdv'=>Tool::dmYtoYmd($_POST['date_fixed']), 'rdv_start'=>$_POST['hour_start'], 'rdv_end'=>$_POST['hour_end'], 'id_activite'=>$_POST['id_activite'],'lieu_rdv'=>$_POST['lieu']),array('id_mono'=>$_POST['idmono'],'id_rdv'=>(int)$_POST['idrdv']))){
					respAjax::successJSON(array('OK' => 'OK'));
				};
			}else{
				if($_POST['app'] == 'DROP'){
					$evt = Planning::findOne(array('id_planning'=>$_POST['idevt']));
					$t = substr($_POST['start'],11);
					$dur = explode(':',$evt->duration);
					$tEnd = date('H:i', strtotime('+'.$dur[0].' hour +'.$dur[1].' minutes',strtotime($t)));

					if(KidsClub::updateRdv(array('duration'=>$evt->duration, 'date_rdv'=>substr($_POST['start'],0,10), 'rdv_start'=>substr($_POST['start'],11), 'rdv_end'=>$tEnd),array('id_rdv'=>$_POST['idevt'])) ){
						respAjax::successJSON(array('OK' => 'OK'));
					}
				}
				else{
					$dur = date('H:i', strtotime($_POST['hour_end']) - strtotime($_POST['hour_start']));

					if(KidsClub::CreateRdv(array('color_rdv'=>'#7d067d','id_groupe'=>$mono->id_groupe,'duration'=>$dur, 'id_mono'=>$_POST['idmono'],'date_rdv'=>Tool::dmYtoYmd($_POST['date_fixed']), 'rdv_start'=>$_POST['hour_start'], 'rdv_end'=>$_POST['hour_end'], 'id_activite'=>$_POST['id_activite'],'lieu_rdv'=>$_POST['lieu']))){
						respAjax::successJSON(array('OK' => 'OK'));
					};
				}
			}

		}
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout dans le planing échoué' : 'Addition to planing, failed')));
			break;


		case 'update-plan-groupe':
			if($_POST['app'] != 'DROP'){
				if (!Ctrl::ctrlflds($_POST, array('hour_start', 'hour_end', 'date_fixed', 'idgroupe')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			}
		
			if($_POST['app'] == 'UPDT'){

				$dur = date('H:i', strtotime($_POST['hour_end']) - strtotime($_POST['hour_start']));

				if(KidsClub::updateRdv(array('duration'=>$dur, 'date_rdv'=>Tool::dmYtoYmd($_POST['date_fixed']), 'rdv_start'=>$_POST['hour_start'], 'rdv_end'=>$_POST['hour_end'], 'id_activite'=>$_POST['id_activite'], 'id_groupe'=>$_POST['idgroupe'],'lieu_rdv'=>$_POST['lieu']),array('id_rdv'=>(int)$_POST['idrdv']))){
					respAjax::successJSON(array('OK' => 'OK'));
				};
			}else{
				if($_POST['app'] == 'DROP'){
					$evt = KidsClub::findOneRdv(array('id_rdv'=>$_POST['idevt']));
					$t = substr($_POST['start'],11);
					$dur = explode(':',$evt->duration);
					$tEnd = date('H:i', strtotime('+'.$dur[0].' hour +'.$dur[1].' minutes',strtotime($t)));

					if(KidsClub::updateRdv(array('duration'=>$evt->duration, 'date_rdv'=>substr($_POST['start'],0,10), 'rdv_start'=>substr($_POST['start'],11), 'rdv_end'=>$tEnd),array('id_rdv'=>$_POST['idevt'])) ){
						respAjax::successJSON(array('OK' => 'OK'));
					}
				}
				else{
					$dur = date('H:i', strtotime($_POST['hour_end']) - strtotime($_POST['hour_start']));

					if(KidsClub::CreateRdv(array('color_rdv'=>'#7d067d','id_groupe'=>$_POST['idgroupe'],'duration'=>$dur, 'date_rdv'=>Tool::dmYtoYmd($_POST['date_fixed']), 'rdv_start'=>$_POST['hour_start'], 'rdv_end'=>$_POST['hour_end'], 'id_activite'=>$_POST['id_activite'],'lieu_rdv'=>$_POST['lieu']))){
						respAjax::successJSON(array('OK' => 'OK'));
					};
				}
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout dans le planing échoué' : 'Addition to planing, failed')));
			break;

			
		case 'del-rdv-mono':
			if (!Ctrl::ctrlflds($_POST, array('idmono', 'idrdv')))
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$rdvadd = KidsClub::DeleteRdv(array('id_rdv'=>(int)$_POST['idrdv']));

			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'update-UsrApp':
			parse_str($_POST['data'], $UsrApp);
			
			if (!Ctrl::ctrlflds($UsrApp, array('user_name', 'email')))
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			
			if ((int)$UsrApp['id_usrApp'] > 0) {
				$exUsrApp = UsrApp::findOne(array('id_usrApp' => $UsrApp['id_usrApp']));
				if (!$exUsrApp)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur non trouvé' : 'User not found')));
				
				if ($exUsrApp->email != $UsrApp['email']) {
					$emUsrApp = UsrApp::findOne(array('email' => $UsrApp['email']));
					if ($emUsrApp)
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Email déjà existant' : 'Email adress, already exist')));
				}
				
				$arr = array(
					'date_upd' => date('Y-m-d H:i:s'),
					'user_name' => $UsrApp['user_name'],
					'title_user' => $UsrApp['title_user'],
					'email' => $UsrApp['email'],
					'tel' => $UsrApp['tel'],
					'tel2' => $UsrApp['tel2'],
					'type_alerte' => implode(',',$UsrApp['type_alerte']),
				);
				
				isset($UsrApp['id_profil']) ? $arr['id_profil'] = (int)$UsrApp['id_profil'] : '';
				
				if (!empty($UsrApp['psw'])){
					$arr['psw'] = md5($UsrApp['psw']);
				}
				// print_r($arr);
				// die;

				if (UsrApp::update($arr, array('id_usrApp' => $UsrApp['id_usrApp']))) {
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'MODIFICATION', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::arrayToStr($arr)));
					
					// alerte UsrApp
					$arrAlertes = array();
					UsrApp::deleteAlerte(array('id_usrApp'=>$UsrApp['id_usrApp']));
					foreach($UsrApp['type_alerte'] as $alerte){
						
						$arrAlertes['id_usrApp'] = $UsrApp['id_usrApp'];
						$arrAlertes['indice_alerte'] = $alerte;
						UsrApp::createAlerte($arrAlertes);
					}
					
					respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modification(s) effectuée(s)' : 'Modification made')));
				} else
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la mise à jours' : 'Mistake update')));
			} else {
				if (empty($UsrApp['psw']))
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Veuillez renseigner le mot de passe' : 'Indicate your password')));

				$emUsrApp = UsrApp::findOne(array('email' => $UsrApp['email']));
				if ($emUsrApp)
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Email déjà existant' : 'Email adress, already exist')));

				isset($UsrApp['id_profil']) ? $arr['id_profil'] = (int)$UsrApp['id_profil'] : '';

				$arr = array(
					'date_create' => date('Y-m-d H:i:s'),
					'user_name' => $UsrApp['user_name'],
					'title_user' => $UsrApp['title_user'],
					'email' => $UsrApp['email'],
					'tel' => $UsrApp['tel'],
					'tel2' => $UsrApp['tel2'],
					'psw' => md5($UsrApp['psw']),
					'type_alerte' => implode(',',$UsrApp['type_alerte']),
				);

				isset($UsrApp['id_profil']) ? $arr['id_profil'] = (int)$UsrApp['id_profil'] : '';
				
				
				if ($idc = UsrApp::create($arr)) {
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'CREATION', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::arrayToStr($arr)));
					
					// alerte UsrApp
					$arrAlertes = array();
					foreach($UsrApp['type_alerte'] as $alerte){
						$arrAlertes['id_usrApp'] = $idc;
						$arrAlertes['indice_alerte'] = $alerte;
					}
					UsrApp::createAlerte(array($arrAlertes));
					
					respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur ajouté' : 'User added')));
				} else
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la mise à jours' : 'Mistake update')));
			}
			break;

		case 'delete-UsrApp':
			if ($arrAccess['isAdmin'] != '1')
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));

			if (!Ctrl::ctrlflds($_POST, array('idUsrApp')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$UsrApp = UsrApp::findOne(array('id_usrApp' => $_POST['idUsrApp']));
			if (!$UsrApp)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur non trouvé' : 'User not found')));
	
			$exct = Fiche::findOne(array('c.id_usrApp' => $_POST['idUsrApp']));
			if ($exct)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression refusée, des clients sont liés a cet utilisateur' : 'Deletion refused, customers are linked to this user')));

			if (UsrApp::delete(array('id_usrApp' => $_POST['idUsrApp']))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'SUPPRESSION', 'date_action' => date('Y-m-d H:i:s')));
				respAjax::successJSON(array('OK' => 'OK'));
			}
			break;

		case 'maj-fiche':
			// print_r($_POST);
			// die;
			// if (!Ctrl::ctrlflds($_POST, array('id_fiche', 'tel1')))
			if (!Ctrl::ctrlflds($_POST, array('id_fiche')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			/* DESACTIVATION DU CTRL DU NUMERO DE TELEPHONE
			-----------------------------------------------

			$numtel = preg_replace('/\D/', '', $_POST['tel1']);
			if (strlen($numtel) != 10)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléphone invalide' : 'Phone number not valid')));
			*/

			if(!isset($_POST['tel1']) || trim($_POST['tel1']) == '' && !isset($_POST['email']) || trim($_POST['email']) == ''){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vous devez indiquer un Téléphone ou un email' : 'You must indicate a Telephone or email')));
			}

			$sej = Setting::getOrganisateur(array('id_organisateur'=>$usrActif->cursoc));

			function isValid($date, $format = 'Y-m-d'){
				$dt = DateTime::createFromFormat($format, $date);
				return $dt && $dt->format($format) === $date;
			}

			if(isValid(Tool::dmYtoYmd($_POST['date_birth']))){
				
				
				$resenf = Tarif::getEnfant();
				$resbb = Tarif::getBb();
				
				$enf = 0;
				$bb = 0;
				$ad = 0;
				
				$dj = date('Y-m-d');
				$typeage = '0';
				
				$dtn = Tool::dmYtoYmd($_POST['date_birth']); 
				$diff = date_diff(date_create($dtn), date_create($dj));
				$myage =  $diff->format('%y');
				
				
				if($myage >= ($resbb->age_bb + 1) && $myage <= $resenf->age_enfant){
					$enf++;
					$typeage = '2';
				}
				
				if($myage <= $resbb->age_bb){
					$bb++;
					$typeage = '3';
				}
				
				if($myage >= $resenf->age_enfant){
					$ad++;
					$typeage = '1';
				}
				
			}
				// 
				
			if ((int)$_POST['id_fiche'] > 0) {
				
				$usr = Fiche::findOne(array('c.id_fiche' => $_POST['id_fiche']));
				if (!$usr)
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client non trouvé' : 'Customer not found')));

				$arr = array(		
					'id_organisateur' => max((int)$_POST['id_organisateur'], 1),
					'id_status_sec' => max((int)$_POST['id_status_sec'], 1),
					'lg' => $_POST['lg'],
					'civ_contact' => (int)$_POST['civ_contact'],
					'first_name' => $_POST['first_name'],
					'last_name' => $_POST['last_name'],
					'tel1' => str_replace(' ' , '', $_POST['tel1']),
					'tel2' => $_POST['tel2'] != '' && $_POST['tel2'] != '0' ? str_replace(' ' , '', $_POST['tel2']) : 0,
					'email' => $_POST['email'],
					'date_birth' => tool::dmYtoYmd($_POST['date_birth']),
					'country' => $_POST['country'],
					'adr1' => $_POST['adr1'],
					'adr2' => $_POST['adr2'],
					'post_code' => $_POST['post_code'],
					'city' => $_POST['city'],
					'raison_sociale' => $_POST['raison_sociale'],
					'adr_facture' => $_POST['adr_facture'],
					'country_facture' => $_POST['country_facture'],
					'city_facture' => $_POST['city_facture'],
					'post_code_facture' => $_POST['post_code_facture'],
					'source' => $_POST['source'],
					'date_update' => date('Y-m-d H:i:s')
				);

				$yearb = '';
				$monthb = '';
				$dayb = '';
				if(isset($_POST['date_birth'])){
					// $arr['date_birth'] = Tool::dmYtoYmd($_POST['date_birth']);
					if((int)$_POST['date_birth'] > 0){
						$arrbirth = explode('/',$_POST['date_birth']);
						$isbirthok = $arrbirth[2].'-'.$arrbirth[1].'-'.$arrbirth[0];
						if(checkdate((int)$arrbirth[1],(int)$arrbirth[0],(int)$arrbirth[2])){
							$arr['date_birth'] = $isbirthok;
						}else{
							respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date non valide' : 'Date not valid')));
						}
					}else{
						$arr['date_birth'] = '0000-00-00';
					}
					
				}else{
					if((int)$_POST['year_birth'] > 0 && strlen($_POST['year_birth']) == 4){
						$yearb = (int)$_POST['year_birth'];
					}

					if((int)$_POST['month_birth'] > 0 && strlen($_POST['month_birth']) == 2){
						$monthb = (int)$_POST['month_birth'];
					}else{
						if((int)$_POST['month_birth'] > 0 && strlen($_POST['month_birth']) == 1){
							$monthb = '0'.(int)$_POST['month_birth'];
						}
					}

					if((int)$_POST['day_birth'] > 0 && strlen($_POST['day_birth']) == 2){
						$dayb = (int)$_POST['day_birth'];
					}else{
						if((int)$_POST['day_birth'] > 0 && strlen($_POST['day_birth']) == 1){
							$dayb = '0'.(int)$_POST['day_birth'];
						}
					}
					
					if($yearb == '' || $monthb == '' || $dayb == ''){
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de naissance incorrecte<br> Ex : 01 19 1988' : 'Date birth not correct<br> Ex : 01 19 1988')));
					}

					$arr['date_birth'] = $yearb.'-'.$monthb.'-'.$dayb;
				}

				if ($arrAccess['isAdmin'] != '1' && (int)$_POST['id_usrApp'] > 0)
					$arr['id_usrApp'] = (int)$_POST['id_usrApp'];
				
				
				$resstatsec = Setting::getStSec(array('id_status_sec'=>(int)$_POST['id_status_sec']));
				if(strstr($resstatsec->name_status_sec, 'ANNULATION')){
					$arr['lnk_annule'] = '1';
				}else{
					$arr['lnk_annule'] = '0';
				}
				
				if (Fiche::update($arr, array('id_fiche' => (int)$_POST['id_fiche']))) {

					$curidstatusconf = $arr['id_status_sec'];
					
					if ($st = Setting::getStSec(array('id_status_sec' => $curidstatusconf))) {
						$arr['id_status_sec'] = $st->name_status_sec;
					}


					// $dtn = Tool::dmYtoYmd($_POST['date_birth']); 
					// $dj = date('Y-m-d');
					// $diff = date_diff(date_create($dtn), date_create($dj));
					// $age =  $diff->format('%y');
					Fiche::updateDetails(
						array('last_name_detail'=>$_POST['last_name'], 
								'first_name_detail'=>$_POST['first_name'], 
								'date_naissance_detail'=>Tool::dmYtoYmd($_POST['date_birth']),
								'age'=>(isset($_POST['date_birth']) && (int)$_POST['date_birth'] > 0 ? $myage : '18'), 
								'type_detail'=>(isset($_POST['date_birth']) && (int)$_POST['date_birth'] > 0 ? $typeage : '1'), 
								'sexe'=>((int)$_POST['civ_contact'] == 1 ? '1' : ((int)$_POST['civ_contact'] == 2 || (int)$_POST['civ_contact'] == 3 ? '2' : '0'))
							),
							array('id_fiche'=>(int)$_POST['id_fiche'], 'is_p'=>'1')
						);
					//general update log
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'MODIFICATION', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::arrayToStr($arr)));


					// update lead sur modele de la fiche
					Leads::update($arr, array('id_fiche' => (int)$_POST['id_fiche']));

					respAjax::successJSON(array('OK' => 'OK'));
				}
			} else {
				//creation
				$arr = array(
					'annee' => date('Y'),
					'id_organisateur' => max((int)$_POST['id_organisateur'], 1),
					'codekey' => substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8),
					'id_status_sec' => max((int)$_POST['id_status_sec'], 1),
					'lg' => $_POST['lg'],
					'civ_contact' => (int)$_POST['civ_contact'],
					'first_name' => (trim($_POST['first_name']) == '' ? 'FN_UNKNOWN' : $_POST['first_name']),
					'last_name' => (trim($_POST['last_name']) == '' ? 'LN_UNKNOWN' : $_POST['last_name']),
					'tel1' => $_POST['tel1'] != '' && $_POST['tel1'] != '0' ? str_replace(' ' , '', $_POST['tel1']) : 33,
					'tel2' => $_POST['tel2'] != '' && $_POST['tel2'] != '0' ? str_replace(' ' , '', $_POST['tel2']) : 33,
					'email' => $_POST['email'],
					'date_birth' => tool::dmYtoYmd($_POST['date_birth']),
					'country' => $_POST['country'],
					'adr1' => $_POST['adr1'],
					'adr2' => $_POST['adr2'],
					'post_code' => $_POST['post_code'],
					'city' => $_POST['city'],
					'raison_sociale' => $_POST['raison_sociale'],
					'adr_facture' => $_POST['adr_facture'],
					'country_facture' => $_POST['country_facture'],
					'city_facture' => $_POST['city_facture'],
					'post_code_facture' => $_POST['post_code_facture'],
					'source' => $_POST['source'],
					'date_start' => $sej->date_start_organisateur,
					'date_end' => $sej->date_end_organisateur,
					'time_start' => '10:00:00',
					'time_end' => '16:00:00',
					'date_update' => date('Y-m-d H:i:s'),
					'date_create' => date('Y-m-d H:i:s')
				);

				$yearb = '';
				$monthb = '';
				$dayb = '';
				if(isset($_POST['date_birth'])){
					// $arr['date_birth'] = Tool::dmYtoYmd($_POST['date_birth']);
					if((int)$_POST['date_birth'] > 0){
						$arrbirth = explode('/',$_POST['date_birth']);
						$isbirthok = $arrbirth[2].'-'.$arrbirth[1].'-'.$arrbirth[0];
						if(checkdate((int)$arrbirth[1],(int)$arrbirth[0],(int)$arrbirth[2])){
							$arr['date_birth'] = $isbirthok;
						}else{
							respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date non valide' : 'Date not valid')));
						}
					}else{
						$arr['date_birth'] = '0000-00-00';
					}
				}else{
					if((int)$_POST['year_birth'] > 0 && strlen($_POST['year_birth']) == 4){
						$yearb = (int)$_POST['year_birth'];
					}

					if((int)$_POST['month_birth'] > 0 && strlen($_POST['month_birth']) == 2){
						$monthb = (int)$_POST['month_birth'];
					}else{
						if((int)$_POST['month_birth'] > 0 && strlen($_POST['month_birth']) == 1){
							$monthb = '0'.(int)$_POST['month_birth'];
						}
					}

					if((int)$_POST['day_birth'] > 0 && strlen($_POST['day_birth']) == 2){
						$dayb = (int)$_POST['day_birth'];
					}else{
						if((int)$_POST['day_birth'] > 0 && strlen($_POST['day_birth']) == 1){
							$dayb = '0'.(int)$_POST['day_birth'];
						}
					}
					
					if($yearb == '' || $monthb == '' || $dayb == ''){
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de naissance incorrecte<br> Ex : 01 19 1988' : 'Date birth not correct<br> Ex : 01 19 1988')));
					}

					$arr['date_birth'] = $yearb.'-'.$monthb.'-'.$dayb;
				}

				$devise = Setting::getDevise(array('devise_en_cours'=>'1'));
				if($devise){
					$arr['code_devise'] = $devise->code_devise;
				}
				
				$arr['id_usrApp'] =  (int)$_POST['id_usrApp'];
				
				$tm = Equipe::findOne(array('id_equipe' => $usrActif->id_equipe));
				if ($tm)
					$arr['source'] = $tm->name_equipe;
				
				$resstatsec = Setting::getStSec(array('id_status_sec'=>(int)$_POST['id_status_sec']));
				if(strstr($resstatsec->name_status_sec, 'ANNULATION')){
					$arr['lnk_annule'] = '1';
				}else{
					$arr['lnk_annule'] = '0';
				}
				
				if ($id_fiche = Fiche::create($arr)) {
					
					if ($st = Setting::getStSec(array('id_status_sec' => $arr['id_status_sec'])))
						$arr['id_status_sec'] = $st->name_status_sec;

					
					// $dtn = Tool::dmYtoYmd($_POST['date_birth']); 
					// $dj = date('Y-m-d');
					// $diff = date_diff(date_create($dtn), date_create($dj));
					// $age =  $diff->format('%y');
					Fiche::createDetails(array('last_name_detail'=>(trim($_POST['last_name']) == '' ? 'FN_UNKNOWN' : $_POST['last_name']), 'first_name_detail'=>(trim($_POST['first_name']) == '' ? 'FN_UNKNOWN' : $_POST['first_name']), 'date_naissance_detail'=>Tool::dmYtoYmd($_POST['date_birth']), 'age'=>(isset($_POST['date_birth']) && (int)$_POST['date_birth'] > 0 ? $myage : '18'), 'type_detail'=>(isset($_POST['date_birth']) && (int)$_POST['date_birth'] > 0 ? $typeage : '1'), 'id_fiche'=>$id_fiche, 'is_p'=>'1', 'sexe'=>((int)$_POST['civ_contact'] == 1 ? '1' : ((int)$_POST['civ_contact'] == 2 || (int)$_POST['civ_contact'] == 3 ? '2' : '0'))));

					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'CREATION', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::arrayToStr($arr)));
					

					// create lead sur modele de la fiche
					$arrLead = [];
					$arrLead = $arr;
					$arrLead['id_fiche'] = $id_fiche;
					Leads::create($arrLead);

					$arropt = [];
					$lstopts = Tarif::getAll(array('is_visible_inscript'=>'1'));
					foreach($lstopts as $opt){
						$arropt['lib_detail_option'] = $opt['libelle_tarif'];
						$arropt['id_lib_option'] = $opt['id_tarif'];
						$arropt['tarif_detail_option'] = $opt['age_tarif'];
						$arropt['id_sejour'] = $usrActif->cursoc;
						$arropt['id_fiche'] = $id_fiche;
						Fiche::CreateDetailsOptions($arropt);
					}

					respAjax::successJSON(array('OK' => 'OK', 'id_fiche' => $id_fiche));
				} else
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Création du client échouée' : 'Creation of customer failed')));
			}
			break;

		case 'delete-contacts':
			if ($arrAccess['isAdmin'] != '1')
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));

			if (!Ctrl::ctrlflds($_POST, array('rws')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if (count($_POST['rws']) == 0)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			foreach ($_POST['rws'] as $idc) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'CONTACT SUPPRESSION', 'date_action' => date('Y-m-d H:i:s')));
				Fiche::delete(array('id_fiche' => $idc));
				Comment::delete(array('id_fiche' => $idc));
				Doc::delete(array('id_fiche' => $idc));

				Chambres::delete(array('id_fiche'=>(int)$idc));
				Planning::delete(array('id_fiche'=>(int)$idc, 'id_sejour'=>$usrActif->cursoc));
				TablesPlans::delete(array('id_fiche'=>(int)$idc, 'id_sejour'=>$usrActif->cursoc));

				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$idc));
				$path = __DIR__ . '/uploads/'.$ct->codekey.$ct->id_fiche;

				if (is_dir($path)){
					if($dir = opendir( $path )){  // ouvre le répertoire
						while ( $files = readdir( $dir ) ) {
							// if ( $files != "index.php" ) // exception avec l'index.php
							unlink( $path.'/'.$files );  // supprime chaque fichier du répertoire
							// }
						}
					}
				}
				
				closedir( $dir );
				
				if(!rmdir($path)){
					$errdir[] = $idc;
				}
			}

			respAjax::successJSON(array('OK' => 'OK', 'errdir'=>$errdir));
			break;

		case 'color-room':
			// print_r($_POST);
			// die;
			if (!Ctrl::ctrlflds($_POST, array('color')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = Cleaning::findOne(array('libelle_nettoyage'=>$_POST['app']));
			if($res){
				Cleaning::update(array('color'=>$_POST['color']),array('libelle_nettoyage'=>$_POST['app']));
			}else{
				Cleaning::create(array('color'=>$_POST['color'], 'libelle_nettoyage'=>$_POST['app']));
			}

			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'update-tab':

			if (!Ctrl::ctrlflds($_POST, array('day_deb', 'day_end')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$wh = '';

			if((int)$_POST['idgroupe'] > 0)
			{
				$wh = ' AND g.id_groupe = '.(int)$_POST['idgroupe'];
			}

			$res = Plans::empTime("'".Tool::dmYtoYmd($_POST['day_deb'])."' BETWEEN e.date_arrivee AND e.date_depart AND '".Tool::dmYtoYmd($_POST['day_end'])."' BETWEEN e.date_arrivee AND e.date_depart ".$wh." 
									GROUP BY
										e.id_groupe
									ORDER BY
										e.age", Tool::dmYtoYmd($_POST['day_deb']), Tool::dmYtoYmd($_POST['day_end']));

			if($res->num_rows <= 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun résultat pour cette journée' : 'No results for today')));
			}

			// echo(print_r($res));
			$doc = IsoPDFBuilder::BuildEmpTime($res, $_POST['day_deb'], $_POST['day_end'], false);

			$fic = substr($doc,strripos($doc,'/'));
			$fl = substr($fic,1,strpos($fic,'?') - 1);

			if ($iddoc = Doc::create(array('id_fiche' => '0', 'date_doc' => date('Y-m-d H:i:s'), 'name_doc' => $fl, 'id_type_doc' => '3'))) {
				respAjax::successJSON(array('OK' => 'OK', 'message'=>$message, 'doc' => $doc, 'id_doc' => $iddoc, 'cansign' => '1'));

			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur' : 'Error')));
			break;

		case 'sign-doc':
			
			if (!Ctrl::ctrlflds($_POST, array('idc', 'idd', 'nameDoc', 'typeDoc')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$typedoc = '';
			$soc = Soc::findOne(array('is_soc'=>'1'));
			
			$contact = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idc']));
			if (!$contact)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client inexistant' : 'Customer not found')));

			$doc = Doc::findOne(array('id_doc' => (int)$_POST['idd']));
			if (!$doc)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Document introuvable' : 'Document not found')));

			if (!Fiche::checkRight($contact))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Droits insuffisants' : 'Insufficient rights')));

			$sellsignurl = 'https://betacloud.sellandsign.com';
			
			$jToken = 'MHPALACE|sRMMuomRe0ANJO0QGeNoi/QiFvx2AIPQrfhgbM+eteE=';

			$client = new Client([
				'timeout'  => 20.0,
			]);
			
			// pour envoi de doc PDF
			$contract_definition_id = 71025 ; 
			$actor_id = 1599309; 
			$vendor_email = 'fo.mh-palace@calindasoftware.com';

			$nameDoc = $_POST['nameDoc'].'pdf'; 
			$libTypeDoc = trim($_POST['typeDoc']);


			$dirup = __DIR__ . '/uploads/';
			$dir = $dirup . $contact->codekey.$contact->id_fiche;

			// pour back-office
			$login = 'kosher@mhpalace.com';
			$Password  = '';

			$msgBody = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vous êtes signataire du document : '.$libTypeDoc.' ci-joint pour la société '.$soc->name_soc.'. Merci de bien vouloir le signer électroniquement en cliquant sur le lien ci-dessous.<br>Cordialement,' : 'You are the signer of the document : '.$libTypeDoc.' attached for company '.$soc->name_soc.'. Please sign it electronically by clicking on the link below.<br>Regards,');

			$arrToJson = Array(
				"customer" => Array(
								"number"=>$contact->id_fiche,
								"mode"=> -1,
								"contractor_id"=> -1,
								"vendor"=> $vendor_email,
								"fields"=>Array()
									
							),				
				"contractors"=> Array(
									Array(
										"number"=>$contact->id_fiche,
										"mode"=> 3,
										"id"=> -1,
										"vendor"=> $vendor_email,
										"fields"=>Array(
												"0" => Array (
													"key"=> "firstname",
													"value"=> $contact->first_name
												),
												"1" => Array (
													"key"=> "lastname",
													"value"=> $contact->last_name
												),
												"2" => Array (
													"key"=> "civility",
													"value"=> ($contact->civ_contact == 1 ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'MONSIEUR' : 'Mr') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'MADAME' : 'Ms'))
												),
												"3" => Array (
													"key"=> "email",
													"value"=> $contact->email
												),
												"4" => Array (
													"key"=> "cell_phone",
													"value"=> $contact->tel1 
												),
											),
									)
								),
				"contract"=> Array(
						"contract_definition_id"=> $contract_definition_id, 
						"pdf_file_path"=> $doc->name_doc,    
						"contract_id"=> -1,
						"message_title"=> ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Votre document : '.$libTypeDoc.' pour signature' : 'Your document : '.$libTypeDoc.' for signature'),
						"message_body"=> $msgBody	
				),
				"contract_properties"=> Array(
					"0" => Array(
						"key"=> "internal_contract_id", // une clé pour votre identifiant interne du contrat, la valeur pourra vous être donné lors du retour du fichier signé
						"value"=> $doc->id_doc, // la valeur de la clé
						"to_fill_by_user"=> 0
					),
					"1" => Array(
						"key"=> "callback:url",
						"value"=>  $PUBURL."/sellAndSign.php?internal_contract_id="
					)
				),
				"files"=> Array(),
				"options"=> Array(),
				"to_sign"=> 1 				
			);
			
			
			$sellsign = json_encode($arrToJson);
			
			if (file_exists(__DIR__ . '/libry/sellsign/adhoc_light.sellsign'.$_POST['idd'])) {
				unlink(__DIR__ . '/libry/sellsign/adhoc_light.sellsign'.$_POST['idd']);
			}

			$bytes = file_put_contents(__DIR__ . '/libry/sellsign/adhoc_light.sellsign'.$_POST['idd'], $sellsign);
			if($bytes <= 0 || $bytes == false){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Echec de la génération du .JSON Sell&Sign' : '.JSON generation failure')));
			}
			
		
			try {
				$response = $client->request('POST', $sellsignurl.'/calinda/hub/selling/do?m=sendCommandPacket', [
					'headers' => [
						'j_token' => $jToken
						],
				
					'multipart' => [
						[
							'name'     => 'adhoc_light.sellsign'.$_POST['idd'],
							'contents' => fopen(__DIR__.'/libry/sellsign/'.'adhoc_light.sellsign'.$_POST['idd'], 'r'),
							'filename' => 'adhoc_light.sellsign'.$_POST['idd'],
							'headers'  => [
								'Content-type' => 'application/json'
							]
						],
						[
							'name'     => $doc->name_doc,
							'contents' => fopen($dir.'/'.$doc->name_doc, 'r'),
							'filename' => $doc->name_doc,
							'headers'  => [
								'Content-type' => 'application/pdf'
							]
						]
					]
				]);

			} catch(GuzzleHttp\Exception\ServerException $e) {
				respAjax::errorJSON(array('message' => $e->getResponse()->getBody()->getContents()));
				}

			
			// print_r($response);
			$resguzzle = json_decode($response->getBody()->getContents(), true);
			
			$iddoc = Doc::update(array('contract_id_sellsign' => $resguzzle['contract_id'], 'date_sellsign' => date('Y-m-d H:i:s')),array('id_doc' => $doc->id_doc));
			

			respAjax::successJSON(array('OK' => 'OK', 'url' =>'','contract_id' => $resguzzle['contract_id']));
			break;
		

		case 'change-status-rows';
			if (!Ctrl::ctrlflds($_POST, array('rws', 'idf', 'id_status_sec')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$st = Setting::getStSec(array('id_status_sec' => (int)$_POST['id_status_sec']));
			if (!$st)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			
			if ((int)$_POST['idf'] > 0) {

				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'CONTACT CHANGE ETAT DU DOSSIER', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $st->name_status_sec));

				$arr = array(
					'id_status_sec' => (int)$_POST['id_status_sec'],
					'date_update' => date('Y-m-d H:i:s')
				);
				if(strstr(strtoupper($st->name_status_sec), 'ANNUL')){
					$arr['lnk_annule'] = '1';
				}else{
					$arr['lnk_annule'] = '0';
				}

				Fiche::update($arr, array('id_fiche' => (int)$_POST['idf']));
			} else {
				
				foreach ($_POST['rws'] as $idct) {
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'CONTACT CHANGE ETAT DU DOSSIER', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $st->name_status_sec));

					$arr = array(
						'id_status_sec' => (int)$_POST['id_status_sec'],
						'date_update' => date('Y-m-d H:i:s')
					);
					if(strstr(strtoupper($st->name_status_sec), 'ANNUL')){
						$arr['lnk_annule'] = '1';
					}else{
						$arr['lnk_annule'] = '0';
					}

					Fiche::update($arr, array('id_fiche' => $idct));

				}
			}

			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'add-comment-grid':
			if (!Ctrl::ctrlflds($_POST, array('id_contact_comment')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if (trim($_POST['comment']) == '')
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Informations incorrectes, aucun commentaire saisi' : 'Incorrect informations, no comments entered')));

			$idc = (int)$_POST['id_contact_comment'];
			if (Comment::create(array('id_fiche' => $idc, 'date_comment' => date('Y-m-d H:i:s'), 'text_comment' => trim($_POST['comment']), 'type_comment' => '0', 'id_user_comment' => $usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT COMMENTAIRE DEPUIS LISTE CLIENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => trim($_POST['txtcomment'])));
				respAjax::successJSON(array('OK' => 'OK'));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur à l\'insertion du commentaire, veuillez vérifier vos informations puis réessayer' : 'Insert failed, check your input and the characters')));
			break;

		case 'add-comment':
			if (!Ctrl::ctrlflds($_POST, array('id_fiche', 'comment', 'type_comment')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			
			$who = $usrActif->user_name;

			if ($idc = Comment::create(array('id_fiche' => $_POST['id_fiche'], 'date_comment' => date('Y-m-d H:i:s'), 'text_comment' => $who.' : '.$_POST['comment'], 'type_comment' => (int)$_POST['type_comment'], 'id_sejour'=>$usrActif->cursoc, 'id_user_comment'=>$usrActif->id_usrApp))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT COMMENTAIRE', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $_POST['comment']));
				respAjax::successJSON(array('OK' => 'OK', 'id_comment' => $idc, 'inits' => $who));
			}
			break;

		case 'delete-comment':
			if (!Ctrl::ctrlflds($_POST, array('id_comment')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$com = Comment::findOne(array('id_comment' => (int)$_POST['id_comment']));
			if (!$com)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if (Comment::delete(array('id_comment' => $_POST['id_comment']))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'SUPPRESSION COMMENTAIRE', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $com->text_comment));
				respAjax::successJSON(array('OK' => 'OK'));
			}
			break;

		case 'add-rappel':
			if (!Ctrl::ctrlflds($_POST, array('id_fiche', 'date_rappel', 'heure_rappel', 'msg_recall')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$dtrecall = Tool::dmYtoYmd($_POST['date_rappel']) . ' ' . $_POST['heure_rappel'];
			$txtcomment = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client à rappeler le <br>' : 'Customer to call back <br>') . date('d/m/Y à H:i', strtotime($dtrecall)).'<br>'.$_POST['msg_recall'];

			if ($idc = Comment::create(array('id_fiche' => $_POST['id_fiche'], 'date_comment' => date('Y-m-d H:i:s'), 'text_comment' => $txtcomment, 'type_comment' => '1', 'date_recall' => $dtrecall, 'id_user_comment' => $usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT RAPPEL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $txtcomment));
				respAjax::successJSON(array('OK' => 'OK', 'comment' => $txtcomment,  'id_comment' => $idc));
			}
			
			break;

		case 'add-global-rappel':
			if (!Ctrl::ctrlflds($_POST, array('date_rappel', 'heure_rappel', 'msg_recall')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if((int)$_POST['id_fiche'] > 0){
				$dtrecall = Tool::dmYtoYmd($_POST['date_rappel']) . ' ' . $_POST['heure_rappel'];
				$txtcomment = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client à rappeler le <br>' : 'Customer to call back <br>') . date('d/m/Y à H:i', strtotime($dtrecall)).'<br>'.$_POST['msg_recall'];
	
				if ($idc = Comment::create(array('id_fiche' => $_POST['id_fiche'], 'date_comment' => date('Y-m-d H:i:s'), 'text_comment' => $txtcomment, 'type_comment' => '1', 'date_recall' => $dtrecall, 'id_user_comment' => $usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc))) {
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT RAPPEL CLIENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $txtcomment));
					respAjax::successJSON(array('OK' => 'OK', 'comment' => $txtcomment,  'id_comment' => $idc));
				}
			}

			if((int)$_POST['id_fournisseur'] > 0){
				$dtrecall = Tool::dmYtoYmd($_POST['date_rappel']) . ' ' . $_POST['heure_rappel'];
				$txtcomment = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur à rappeler le <br>' : 'Provider to call back <br>') . date('d/m/Y à H:i', strtotime($dtrecall)).'<br>'.$_POST['msg_recall'];
	
				if ($idc = Comment::create(array('id_fournisseur' => $_POST['id_fournisseur'], 'date_comment' => date('Y-m-d H:i:s'), 'text_comment' => $txtcomment, 'type_comment' => '2', 'date_recall' => $dtrecall, 'id_user_comment' => $usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc))) {
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT RAPPEL FOURNISSEUR', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $txtcomment));
					respAjax::successJSON(array('OK' => 'OK', 'comment' => $txtcomment,  'id_comment' => $idc));
				}
			}

			if((int)$_POST['id_fournisseur'] == 0 && (int)$_POST['id_fiche'] == 0){
				$dtrecall = Tool::dmYtoYmd($_POST['date_rappel']) . ' ' . $_POST['heure_rappel'];
				$txtcomment = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pour le <br>' : 'For <br>') . date('d/m/Y à H:i', strtotime($dtrecall)).'<br>'.$_POST['msg_recall'];
	
				// echo($dtrecall.' --- '.print_r(Tool::dmYtoYmd($_POST['date_rappel'])));
				// die;
				if ($idc = Comment::create(array('is_commun' => '1', 'date_comment' => date('Y-m-d H:i:s'), 'text_comment' => $txtcomment, 'type_comment' => '3', 'date_recall' => $dtrecall, 'id_user_comment' => $usrActif->id_usrApp, 'id_sejour'=>$usrActif->cursoc))) {
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT RAPPEL COMMUN', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $txtcomment));
					respAjax::successJSON(array('OK' => 'OK', 'comment' => $txtcomment,  'id_comment' => $idc));
				}
			}
			
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Une erreur c\'est produite' : 'An error occured')));
			break;

		case 'popup-rappels':
			if (!Ctrl::ctrlflds($_POST, array('currentTime')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if(session_status() === PHP_SESSION_DISABLED || session_status() === PHP_SESSION_NONE ){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'SESSION EXPIREE' : 'SESSION EXPIRED')));
			}
			// else{
			// 	if(session_status() === PHP_SESSION_ACTIVE){
			// 		respAjax::successJSON(array('data' => $recall, 'lg'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'FR' : 'ENG'), 'session_status :'=>session_status()));
			// 	}
			// }

			$when = new DateTime(explode('(', $_POST['currentTime'])[0]);
			$dt = $when->format('Y-m-d H:i:s');
			$recall = Comment::getFrstPopup($dt, $usrActif->id_usrApp);
			if ($recall)
				respAjax::successJSON(array('data' => $recall, 'lg'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'FR' : 'ENG'), 'session_status'=>session_status()));

			break;

		case 'wait-popup':
			if (!Ctrl::ctrlflds($_POST, array('idcom')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if((int)$_POST['idcli'] > 0){
				$com = Comment::findOne(array('id_comment' => (int)$_POST['idcom'], 'id_fiche' => (int)$_POST['idcli']));
			}

			if((int)$_POST['idfourn'] > 0){
				$com = Comment::findOne(array('id_comment' => (int)$_POST['idcom'], 'id_fournisseur' => (int)$_POST['idfourn']));
			}

			if((int)$_POST['idcommon'] > 0){
				$com = Comment::findOne(array('id_comment' => (int)$_POST['idcom'], 'is_commun' => (int)$_POST['idcommon']));
			}

			// echo($com.' ------ '.print_r($_POST));
			if (!$com){
				// respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pas de rappel' : 'Reminder not exist')));
			}else{
				$when = new DateTime(explode('(', $_POST['tm'])[0]);
				$when->add(new DateInterval('PT' . (int)$_POST['tp'] . 'M'));
				$dt = $when->format('Y-m-d H:i:s');

				Comment::update(array('date_recall' => $dt), array('id_comment' => (int)$_POST['idcom']));
			}
			
			respAjax::successJSON(array('OK' => 'OK'));
			break;


		case 'update-rappel':
			// die(var_dump($_POST));
			if (!Ctrl::ctrlflds($_POST, array('start', 'end', 'debinit', 'endinit', 'idevt')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if($_POST['appForm']){
				if (trim($_POST['day']) == '')
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'La date est obligatoire' : 'Date required')));
				
				$hdeb = explode(':',$_POST['start']);
				$hend = explode(':',$_POST['end']);
				if(intval($hdeb[0]) < 10 ){
					$hdeb = '0'.$hdeb[0].':'.$hdeb[1];
				}
				else{
					$hdeb = $_POST['start'];
				}

				if(intval($hend[0]) < 10 ){
					$hdend = '0'.$hend[0].':'.$hend[1];
				}
				else{
					$hend = $_POST['end'];
				}

				$rdvstart = Tool::dmYtoYmd($_POST['day'])."T".$hdeb;
				$rdvend = Tool::dmYtoYmd($_POST['day'])."T".$hend;

				KidsClub::updateRdv(array('dragDrop'=>($_POST['dragDrop'] ? 1 : 0), 'date_rdv' => Tool::dmYtoYmd($_POST['day']), 'rdv_start' => $hdeb, 'rdv_end' => $hend, 'desc_rdv' => $_POST['desc']),array('id_rdv' => (int)$_POST['idevt']));

			}
			else {

				$newHdeb = explode('T',$_POST['start']);
				$newHend = explode('T',$_POST['end']);
				
				$hdeb = explode(':',$newHdeb[1]);
				$hend = explode(':',$newHend[1]);

				if(intval($hdeb[0]) < 10  ){
					$hdeb = '0'.intval($hdeb[0]).':'.$hdeb[1];
				}
				else{
					$hdeb = $hdeb[0].':'.$hdeb[1];
				}

				if(intval($hend[0]) < 10 ){
					$hend = '0'.intval($hend[0]).':'.$hend[1];
				}
				else{
					$hend = $hend[0].':'.$hend[1];
				}

				$tabDate = explode('-', $_POST['start']);
				$timestamp = mktime(0, 0, 0, $tabDate[1], $tabDate[2], $tabDate[0]);
				$jour = date('w', $timestamp);
				
				KidsClub::updateRdv(array('dragDrop'=>($_POST['dragDrop'] ? 1 : 0), 'date_rdv' => $newHdeb[0], 'rdv_start' => $hdeb, 'rdv_end' => $hend),array('id_rdv' => (int)$_POST['idevt']));
			}

			respAjax::successJSON(array('OK' => 'OK'));

			break;

		case 'duplique-chambres':
			if (!Ctrl::ctrlflds($_POST, array('idsejduplique')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			// verif si des chambres ont ete saisie et affectees
			$verifExisteCtCh = Chambres::getAll(array('id_sejour'=>$usrActif->cursoc));
			if($verifExistCtCh->num_rows > 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression impossible des chambres ont déjà été affectées à des clients sur ce séjour' : 'Unable to delete rooms that have already been assigned to guests on this stay')));
			}

			// recup des toutes les chambres du sejour model a dupliquer
			$dupChs = Chambres::getAllCh(array('id_sejour'=>(int)$_POST['idsejduplique']));
			// suppression des eventuelles chambres saisies pour le sejour actuel
			Chambres::deleteCh(array('id_sejour'=>$usrActif->cursoc));
			
			// copie des chambres pour le sejour actuel
			foreach($dupChs as $dupCh){
				// echo($dupCh['num_chambre'].' - '.$usrActif->cursoc.' vers : '.(int)$_POST['idsejduplique'].'<br>');
				Chambres::createCh(array('id_sejour'=>$usrActif->cursoc, 
									'num_chambre'=>$dupCh['num_chambre'], 'etage'=>$dupCh['etage'], 'vue_chambre'=>$dupCh['vue_chambre'],
									'type_chambre'=>$dupCh['type_chambre'], 'capacite_lib'=>$dupCh['capacite_lib'], 'capacite'=>$dupCh['capacite'], 'nb_lit_simple'=>$dupCh['nb_lit_simple'],
									'nb_lit_double'=>$dupCh['nb_lit_double'], 'nb_lit_bb'=>$dupCh['nb_lit_bb'], 'nb_lit_sup'=>$dupCh['nb_lit_sup'], 'opt_lib_1'=>$dupCh['opt_lib_1'],
									'opt_lib_2'=>$dupCh['opt_lib_2'], 'opt_lib_3'=>$dupCh['opt_lib_3'], 'opt_lib_4'=>$dupCh['opt_lib_4'], 'opt_lib_5'=>$dupCh['opt_lib_5'],
									'douche'=>$dupCh['douche'], 'baignoire'=>$dupCh['baignoire'], 'television'=>$dupCh['television'], 'terrasse_balcon'=>$dupCh['terrasse_balcon'],
									'frigidaire'=>$dupCh['frigidaire'], 'wifi'=>$dupCh['wifi'], 'desc_chambre'=>$dupCh['desc_chambre'], 'tarif_chambre'=>$dupCh['tarif_chambre'],
									'jacuzzi'=>$dupCh['jacuzzi'], 'piscine'=>$dupCh['piscine'], 'jardin'=>$dupCh['jardin'], 'communique_ch'=>$dupCh['communique_ch']));
				// die;
			}

			respAjax::successJSON(array('OK' => 'OK'));

			break;

		case 'read-rdv-mono':
			// print_r($_POST);
			$rdv = KidsClub::findOneRdv(array('id_rdv'=>(int)$_POST['idrdv']));

			if($rdv){
				respAjax::successJSON(array('OK' => 'OK', 'data' => $rdv));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune information' : 'No informations')));
			break;
	
		case 'read-rdv-groupe':
			$allct = Monos::getAll();

			$addRdv = true;

			$wh = '';
			

			$rdvs = KidsClub::getDateRdv(" date_rdv BETWEEN '".$_POST['start']."' AND '".$_POST['end']."' ".$wh);

			$evts = array();

			$idc = 0;

			$strevents = '';
			if(count($rdvs) <= 0 ){
				
				$evts = array();
			}else {
				foreach($rdvs as $rdv){
					$idc = 0;

					$rdvstart = date('Y-m-d',strtotime($rdv['date_rdv']))."T".$rdv['rdv_start'];
					$rdvend = date('Y-m-d',strtotime($rdv['date_rdv']))."T".$rdv['rdv_end'];

					$mono = Monos::findOne(array('id_mono'=>$rdv['id_mono']));
					$activite = Activites::findOne(array('id_activite'=>$rdv['id_activite'], 'is_kid'=>'1'));
					$grp = Groupes::findOne(array('id_groupe'=>$rdv['id_groupe']));

					$strevents = '<span style="border: solid 1px black; padding: 2px; background-color: white; color:black">Mono : '.$mono->first_name.' '.$mono->last_name.'</span><br><br>';
					
					$strevents .= '<br><span style="border: solid 1px black; padding: 2px; background-color: blue; color:white">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lieu' : 'Location').' : '.$rdv['lieu_rdv'].'</span><br>';
					$strevents .= '<br><span style="border: solid 1px black; padding: 2px; background-color: blue; color:white">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Groupe' : 'Band').' : '.$grp->name_groupe.'</span><br>';
					$strevents .= '<br><span style="border: solid 1px black; padding: 2px; background-color: blue; color:white">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Activité' : 'Activity').' : '.$activite->name_activite.'</span><br>';

					$evts[] = array(
						'title'=> 
								'<br>
								<div> <span style="border: solid 1px black; padding: 2px; background-color: black; color:white"><u>Descriptif :</u></span> <br><br>'.$rdv['desc_rdv'].'</div>
								<br><span style="color:black">'.$strevents.'</span><br><br><br>
								',
						'start'=> $rdvstart,
						'end'=> $rdvend,
						'allDay'=> false,
						'color'=> $rdv['color_rdv'], 
						'description'=> $rdv['desc_rdv'],
						'id'=>$rdv['id_rdv']
					);
				
				}
			}

			respAjax::successJSON(array('OK' => 'OK', 'evts' => $evts, 'rows'=>$rdvs->num_rows));


			break;

		case 'read-planning-chambre':
		
			$allch = Planning::getAllSimple("rdv_start BETWEEN '".$_POST['start']."' AND '".$_POST['end']."'" );

			// die(print_r($allch));
			$evts = array();

			$idc = 0;

			$strevents = '';

			if(count($allch) <= 0 ){
				
				$evts = array();
			}
			else {
			
				$idc = 0;

				foreach($allch as $ch){
					$ct = Fiche::findOne(array('c.id_fiche'=>$ch['id_fiche']));
					
						$dataName = $ct->first_name.' '.$ct->last_name;
						
						$strevents = '<br>'.$dataName;
						
						$strevents .= ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<br>Reservation chambre : '.$ch['num_chambre'] : '<br>Room reservation : '.$ch['num_chambre']);
						$idc = $ct->id_fiche;

						$hstart = substr($ch['rdv_start'], 11);
						$hend = substr($ch['rdv_end'], 11);

						// echo($ch['rdv_start']);

						if($hstart == '00:00:00'){
							$hstart = '23:59:59';
						}
						if($hend == '00:00:00'){
							$hend = '23:59:59';
						}
						// $rdvstart = date('Y-m-d',strtotime($rdv['date_rdv']))."T".$rdv['rdv_start'];
						$rdvstart = date('Y-m-d H:m:i',strtotime($ch['rdv_start']))."T".$hstart;
						
						$rdvend = date('Y-m-d H:m:i',strtotime($ch['rdv_end']))."T".$hend;


						// $evts[] = array(
							// 'title'=> 
							// 		'<a href="#" data-name="'.$dataName.'" data-ct="'.$ct->id_fiche.'" data-date="'.date('d/m/Y',strtotime($ch['rdv_start'])).'" data-id="'.trim(strval($rdv['id_planning'])).'" class="btn btn-xs btn-danger deleterdv" title="Supprimer" data-toggle="tooltip" data-placement="right"><i class="fa fa-trash"></i></a>',
									
							// 'start'=> $rdvstart,
							// 'end'=> $rdvend,
							// 'allDay'=> false,
							// 'color'=> $ch['color_rdv'], 
							// 'description'=> $ch['desc_rdv'],
							// 'id'=>$ch['id_planning']
						$evts[] = array(
							'title'=> 
									'<a href="#" data-name="'.$dataName.'" data-ct="'.$ct->id_fiche.'" data-date="'.date('d/m/Y',strtotime($ch['rdv_start'])).'" data-id="'.trim(strval($rdv['id_planning'])).'" class="btn btn-xs btn-danger deleterdv" title="Supprimer" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
									<a href="'.($ct->id_fiche == 0 ? "#" : "fiche.php?id_fiche=".$ct->id_fiche).'" data-ct="'.$ct->id_fiche.'" data-toggle="tooltip" title="Voir le client" class="btn btn-xs btn-primary consult"><i class="fa fa-user"></i></a>
									<a href="#" data-ct="'.$idc.'" data-date="'.date('d/m/Y',strtotime($rdv['date_rdv'])).'" data-start="'.$rdv['rdv_start'].'" data-end="'.$rdv['rdv_end'].'" data-desc="'.$rdv['desc_rdv'].'" data-id="'.trim(strval($rdv['id_planning'])).'" data-toggle="tooltip" title="Modifier le Rdv" class="btn btn-xs btn-success modif"><i class="fa fa-user"></i></a>
									<a href="#" data-name="'.$dataName.'" data-ct="'.$ct->id_fiche.'" data-start="'.$ch['rdv_start'].'" data-end="'.$ch['rdv_end'].'" data-desc="'.$ch['desc_rdv'].'" data-id="'.trim(strval($ch['id_planning'])).'" data-toggle="tooltip" title="Valider le Rdv" class="btn btn-xs btn-primary valideplanning"><i class="fa fa-clock-o"></i></a>
									<a href="#" data-name="'.$dataName.'" data-ct="'.$ct->id_fiche.'" data-start="'.$ch['rdv_start'].'" data-end="'.$ch['rdv_end'].'" data-desc="'.$ch['desc_rdv'].'" data-id="'.trim(strval($ch['id_planning'])).'" data-toggle="tooltip" title="Confirmez les heures" class="btn btn-xs btn-warning conftimerealise"><i class="fa fa-pencil"></i></a>'
									.'<br><span style="color:black">'.$strevents.'</span><br><br><br>
									<div> <span style="border: solid 1px black; padding: 2px; background-color: black; color:white"><u>Descriptif :</u></span> <br><br>'.$rdv['desc_rdv'].'</div>',
							'start'=> $rdvstart,
							'end'=> $rdvend,
							'allDay'=> false,
							'inf'=>'Réservation chambre : '.$ch['num_chambre'].' '.($ct->civ_contact == 1 ? 'Mr' : ($ct->civ_contact == 2 ? 'Mme' : 'Mlle')).' '.$dataName.'Du : '.date('d/m/Y', strtotime($ch['rdv_start'])).' au '.date('d/m/Y', strtotime($ch['rdv_end'])),
							// 'color'=> $ch['color_rdv'], 
							'description'=> $ch['desc_rdv'],
							'id'=>$ch['id_planning']
					);
						
				}
				
			}
			

			respAjax::successJSON(array('OK' => 'OK', 'evts' => $evts, 'rows'=>$rdvs->num_rows));

			break;

			
		case 'read-count-chambre':
			// echo(print_r($_POST));
			// die;
			
			$dts = explode('-',$_POST['start']);
			$dte = explode('-',$_POST['end']);

			
			// $dtEndSejour = 
			$evts = array();
			$dtadd = date('Y-m-d',strtotime($_POST['start']));
			
			$nbCh = Chambres::countChambres(array('id_sejour'=>$usrActif->cursoc));

			while ($dtadd <= $_POST['end']){
				
				$sql = "SELECT COUNT(*) as NB FROM db_planning WHERE num_chambre > 0 AND '$dtadd' BETWEEN LEFT(rdv_start,10) AND LEFT(rdv_end,10) AND id_sejour = $usrActif->cursoc";
				
				$allch = QueryExec::querySQL($sql, true);

				$idc = 0;

				$strevents = '';
				
				$nbChDispo = $nbCh->NB - $allch->NB;
				$col = ($nbChDispo == $nbCh->NB ? '#8ad1ed' : ($nbChDispo > 0 ? '#a1ed8a' : '#d65c54'));

				$rdvstart = date('Y-m-d',strtotime($dtadd));
					
				$rdvend = date('Y-m-d',strtotime($dtadd));

				$ds = explode('-',$rdvstart);
				$de = explode('-',$rdvend);

				$evts[] = array(
					'title'=> '<a href="#" class="idbtdispoch" data-start="'.$ds[2].'/'.$ds[1].'/'.$ds[0].'" data-end="'.$de[2].'/'.$de[1].'/'.$de[0].'" >'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Liste des chambres disponibles' : 'Room list available').'</a>',
					'start'=> $rdvstart,
					'end'=> $rdvend,
					'allDay'=> false,
					'inf'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de chambre restantes : ' : 'Number of rooms remaining : ').$nbChDispo,
					'backgroundColor' => $col,
					// 'color'=> $ch['color_rdv'], 
					'description'=> '',
					'id'=>$ch['id_planning']
				);

				$dtadd = date('Y-m-d',strtotime($dtadd. ' + 1 days'));

			}
			
			respAjax::successJSON(array('OK' => 'OK', 'evts' => $evts, 'rows'=>$rdvs->num_rows));

			break;
			
		case 'read-rappels':
			verifAccess($usrActif);

			// print_r($_POST);

			$dts = explode('-',$_POST['start']);
			$dte = explode('-',$_POST['end']);

			$filt = '';
			$sejour = '';

			if(isset($_POST['filt'])){
				$filt = " type_comment = ".(int)$_POST['filt'];
			}

			
			$sejour = " id_sejour = ". $usrActif->cursoc;
			
			$evts = array();
			$dtadd = date('Y-m-d',strtotime($_POST['start']));

			$sql = "SELECT * FROM db_comments ";
			$wh = " WHERE date_comment BETWEEN '".$_POST['start']."' AND '".$_POST['end']."' OR date_recall BETWEEN '".$_POST['start']."' AND '".$_POST['end']."' ";
			$wh .= ($filt != '' && $sejour != '' ? ' AND '.$filt. ' AND '.$sejour : ($filt != '' ? ' AND '.$filt : ($sejour != '' ? ' AND '.$sejour : '')));

			$sql .= $wh;
			// echo($sql);
			$allcmts = QueryExec::querySQL($sql);
			
			$idc = 0;

			$strevents = '';
				
			foreach($allcmts as $cmt){
				// if($allch->num_rows > 0 ){
					
				$col = ($cmt['type_comment'] == 0 ? '#8ad1ed' : ($cmt['type_comment'] == 1 ? '#e8a71a' : ($cmt['type_comment'] == 2 ? '#b5e69e' : '#e9f0d1')));
				$colortxt = ($cmt['type_comment'] == 0 ? '#000' : ($cmt['type_comment'] == 1 ? '#45618f' : ($cmt['type_comment'] == 2 ? '#000' : '#000')));

				if($cmt['type_comment'] == 1 || $cmt['type_comment'] == 2 || $cmt['type_comment'] == 3){
					$rdvstart = date('Y-m-d',strtotime($cmt['date_recall']))."T".substr($cmt['date_recall'], 11);						
					$rdvend = date('Y-m-d',strtotime($cmt['date_recall']))."T".substr($cmt['date_recall'],11);
				}else{
					$rdvstart = date('Y-m-d',strtotime($cmt['date_comment']))."T".substr($cmt['date_comment'], 11);						
					$rdvend = date('Y-m-d',strtotime($cmt['date_comment']))."T".substr($cmt['date_comment'],11);
				}
				
				$lnkfiche = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers la fiche N°' : 'Link to file number');

				if($cmt['type_comment'] == 2 || $cmt['type_comment'] == 3){
					$evts[] = array(
						'title'=> '<div>'.($cmt['type_comment'] == 2 ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel Fournisseur : <br>' : 'Provider reminder : <br>') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel général : <br>' : 'Common reminder : <br>'))
									.$cmt['text_comment'].'</div>',
						'start'=> $rdvstart,
						'end'=> $rdvend,
						// 'allDay'=> false,
						'inf'=> ($cmt['type_comment'] == 2 ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel Fournisseur : ' : 'Provider reminder : ') : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel général : ' : 'Common reminder : ')).strip_tags(str_replace('<br>',' ',$cmt['text_comment'])),
						'backgroundColor' => ($cmt['is_read'] > 0 ? 'red' : $col),
						'textColor'=> ($cmt['is_read'] > 0 ? 'black' : $colortxt), 
						'description'=> '',
						'id'=>$cmt['id_comment']
					);
				}else{
					$evts[] = array(
						'title'=> ($arrAccess['acces_page_client_calendar_rappel'] == '1' ? '<a href="fiche.php?id_fiche='.$cmt['id_fiche'].'">'.$lnkfiche.' '.$cmt['id_fiche'].'</a>' : "").'
									<div>'.($cmt['type_comment'] == 0 ? 'Note : <br>' : '')
									.$cmt['text_comment'].'</div>',
						'start'=> $rdvstart,
						'end'=> $rdvend,
						// 'allDay'=> false,
						'inf'=> ($cmt['type_comment'] == 0 ? 'Note : ' : ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel : ' : 'Reminder : ')).strip_tags(str_replace('<br>',' ',$cmt['text_comment'])),
						'backgroundColor' => ($cmt['is_read'] > 0 ? 'red' : $col),
						'textColor'=> ($cmt['is_read'] > 0 ? 'black' : $colortxt), 
						'description'=> '',
						'id'=>$cmt['id_comment']
					);
				}

				$dtadd = date('Y-m-d',strtotime($dtadd. ' + 1 days'));

			}
			
			respAjax::successJSON(array('OK' => 'OK', 'evts' => $evts, 'rows'=>$rdvs->num_rows));

			break;

		case 'maj-transport':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'iddet')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));

				$arr =array();
				if($_POST['restransp'] == ''){
					$arr['volnavette'] = 0;
					$arr['volseul'] = 0;
					$arr['navetteseule'] = 0;
				}
				if($_POST['restransp'] == 'vn'){
					$arr['volnavette'] = 1;
					$arr['volseul'] = 0;
					$arr['navetteseule'] = 0;
				}
				if($_POST['restransp'] == 'vs'){
					$arr['volnavette'] = 0;
					$arr['volseul'] = 1;
					$arr['navetteseule'] = 0;
				}
				if($_POST['restransp'] == 'ns'){
					$arr['volnavette'] = 0;
					$arr['volseul'] = 0;
					$arr['navetteseule'] = 1;
				}

				// A FAIRE : recuperer tarif apres creation settings
				Fiche::updateDetails($arr,array('id_contact_detail'=>(int)$_POST['iddet']));

				respAjax::successJSON(array('OK' => 'OK', 'message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour transport effectuée' : 'Transport update done')));

			break;
	
		case 'valide-annule-fiche':
			// print_r($_POST);
			// die;
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' =>(int)$_POST['idct']));
			
			$resstatsec = Setting::getStSecSimple('name_status_sec LIKE "ANNULATION"');
			if((int)$resstatsec->id_status_sec <= 0){
				$residsec = Setting::createStSec(array('name_status_sec'=>'ANNULATION', 'status_color'=>'#f63b3b'));
			}

			Fiche::update(array('lnk_annule'=>'1', 'id_status_sec'=>$residsec),array('id_fiche'=>(int)$_POST['idct']));

			Chambres::delete(array('id_fiche'=>(int)$_POST['idct']));
			Planning::delete(array('id_fiche'=>(int)$_POST['idct'], 'id_sejour'=>$ct->id_organisateur));
			TablesPlans::delete(array('id_fiche'=>(int)$_POST['idct'], 'id_sejour'=>$ct->id_organisateur));
			
			respAjax::successJSON(array('OK' => 'OK','message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fiche annulée' : 'Customer canceled')));
			break;


		case 'find-ct-rdv':
			
			if (!Ctrl::ctrlflds($_POST, array('idct', 'idrdv')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct']));

			$rdv = KidsClub::findOneRdv(array('id_rdv' =>(int)$_POST['idrdv']));

			respAjax::successJSON(array('OK' => 'OK', 'idrdv'=>(int)$_POST['idrdv'], 'name'=> $ct->first_name.' '.$ct->last_name, 'infRdv'=>$rdv));
			break;

		case 'del-rdv':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'idrdv')))
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$rdvadd = KidsClub::DeleteRdv(array('id_rdv'=>(int)$_POST['idrdv']));

			Fiche::update(array('date_rdv'=>'', 'time_rdv'=>''),array('id_fiche'=>(int)$_POST['idct']));

			respAjax::successJSON(array('OK' => 'OK'));
			break;
	
		case 'read-recall':
			if (!Ctrl::ctrlflds($_POST, array('idcom')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if((int)$_POST['idcli'] > 0){
				$cmt = Comment::findOne(array('id_comment' => (int)$_POST['idcom'], 'id_fiche' => (int)$_POST['idcli']));
			}

			if((int)$_POST['idfourn'] > 0){
				$cmt = Comment::findOne(array('id_comment' => (int)$_POST['idcom'], 'id_fournisseur' => (int)$_POST['idfourn']));
			}

			if((int)$_POST['idcommon'] > 0){
				$cmt = Comment::findOne(array('id_comment' => (int)$_POST['idcom'], 'is_commun' => (int)$_POST['idcommon']));
			}

			// echo(print_r($cmt).' ----- <br>'.print_r($_POST));
			if (!$cmt){
				// respAjax::errorJSON(array('message' => 'Rappel inexistant'));
			}else{
				Comment::update(array('is_read' => '1'), array('id_comment' => (int)$_POST['idcom']));
			}
			
			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'upload-doc':
			if (!Ctrl::ctrlflds($_FILES, array('file')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			if (!Ctrl::ctrlflds($_POST, array('id_fiche')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$contact = Fiche::findOne(array('c.id_fiche' => (int)$_POST['id_fiche']));
			if (!$contact)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client inexistant' : 'Customer not found')));
	
			$dirup = __DIR__ . '/uploads/';
			$dir = $dirup . $contact->codekey.$_POST['id_fiche'];

			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			if ($fl = Tool::uploadFile($dir . '/', $_FILES['file'])) {
				$filename = $URL . 'uploads/' . $contact->codekey . $_POST['id_fiche'] . '/' . $fl;
				if ($iddoc = Doc::create(array('id_fiche' => (int)$_POST['id_fiche'], 'date_doc' => date('Y-m-d H:i:s'), 'name_doc' => $fl,  'id_type_doc' => $_POST['id_type_doc']))) {
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT DOCUMENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $fl));
					respAjax::successJSON(array('filename' => $filename, 'fl' => $fl, 'id_doc' => $iddoc, 'isimage' => Tool::isImage($filename) ? '1' : '0'));
				}
			}

			break;

		case 'upload-doc-type':
			if (!Ctrl::ctrlflds($_FILES, array('file')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			if (!Ctrl::ctrlflds($_POST, array('id_fiche')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$contact = Fiche::findOne(array('c.id_fiche' => (int)$_POST['id_fiche']));
			if (!$contact || !Fiche::checkRight($contact))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client inexistant' : 'Customer not found')));
	
			$dirup = __DIR__ . '/uploads/';
			$dir = $dirup . $contact->codekey.$_POST['id_fiche'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			if (is_array($_FILES['file']['name'])) {

				$file_post = $_FILES['file'];
				$file_array = array();
				$file_count = count($file_post['name']);
				$file_keys = array_keys($file_post);

				for ($i = 0; $i<$file_count; $i++) {
					foreach ($file_keys as $key) {
						$file_array[$i][$key] = $file_post[$key][$i];
					}
				}

				foreach ($file_array as $file) {
					if ($fl = Tool::uploadFile ($dir.'/', $file)){

						if ($iddoc = Doc::create(array('id_fiche' => (int)$_POST['id_fiche'], 'date_doc' => date('Y-m-d H:i:s'), 'name_doc' => $fl, 'id_type_doc' => $_POST['id_type_doc']))) {
							CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT DOCUMENTS ', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $fl));
						}
					} else
						respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Le fichier n\'a pas pu être sauvegardé ('.$file['name'].')' : 'File ('.$file['name'].'), not saved')));
				}
			}
			else {			
				if ($fl = Tool::uploadFile($dir . '/', $_FILES['file'])) {
					$filename = $URL . 'uploads/' . $contact->codekey . $_POST['id_fiche'] . '/' . $fl;
					if ($iddoc = Doc::create(array('id_fiche' => (int)$_POST['id_fiche'], 'date_doc' => date('Y-m-d H:i:s'), 'name_doc' => $fl, 'id_type_doc' => (int)$_POST['id_type_doc']))) {
						CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT DOCUMENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $fl));						
					}
				}
			}
			respAjax::successJSON(array('filename' => $filename, 'fl' => $fl, 'id_doc' => $iddoc, 'isimage' => Tool::isImage($filename) ? '1' : '0'));

			break;

		case 'maj-opt-manu-grid':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'iddetail')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$mtTarif = 0;
				$tot_restant = 0;
				$tarifNuit = false;
				$tarifSemaine = false;
				$tarifSejour = false;

				$addTot = 0;

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

				$res = Fiche::updateDetailsOptions(array('tot_tarif_option'=>$_POST['tarif']), array('id_fiche'=>(int)$_POST['idct'], 'id_contact_detail_option'=>(int)$_POST['iddetail']));
				if($res){
					// recalcul du montant
					$allTarifs = Fiche::getAllDetails(array('id_fiche'=>(int)$_POST['idct']));
					foreach($allTarifs as $tarif){
						$mtTarif += $tarif['tarif_details'];
					}
					
					$alldetailsopts = Fiche::getAllDetailsOptions(array('id_fiche'=>(int)$_POST['idct']));
					foreach($alldetailsopts as $detailsopts){
						$mtTarif += $detailsopts['tot_tarif_option'];
					}

					$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
					
					$date1 = new DateTime($ct->date_start);
					$date2 = new DateTime($ct->date_end);
	
					$jours = $date2->diff($date1)->days;
					// $jours += 1; //inclure le dernier jour
				
					$semaine = $jours / 7 ;

					if($tarifSemaine){
						$mtTarif = $mtTarif * $semaine;
					}
					if($tarifNuit){
						$mtTarif = $mtTarif * $jours;
					}
					if($tarifSejour){
						$mtTarif = $mtTarif;
					}

					$mtTarifReal = (($mtTarif + $addTot)  * (100 - $ct->offre_sejour)) / 100;
					$mtTarifReal += $ct->taxe_sejour;

					
					// tarif manuel
					if($ct->is_tot_manu > 0 || (int)$_POST['istotmanu'] > 0){
						$arr['is_tot_manu'] = '1';
						// pour tot reel
						$totFinalReal = (($mtTarif + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin 
						$totFinalReal += $ct->taxe_sejour;
						*/

						// $mtTarif = str_replace(array(' ',','),array(''),$ct->tot_ht);
						$mtTarif = $ct->tot_manu;
						$mtTarif += $ct->taxe_sejour;						
					}else{
						$mtTarif = $mtTarif * ((100 - $ct->offre_sejour) / 100);
						$mtTarif += $ct->taxe_sejour;
						
						// pour tot reel
						$totFinalReal = (($mtTarif + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin 
						$totFinalReal += $ct->taxe_sejour;
						*/
					}

					$totFinalAcpt = ($mtTarif  * (100 - $ct->accompte_25)) / 100;
					
					// echo($mtTarif.' -- '.$ct->is_tot_manu.' -- '.$ct->code_devise);
					if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){						
						
						$arr['tot_ht'] = $mtTarif;
						$arr['tot_real'] = $totFinalReal;
						$arr['mt_ok_ht'] = $totFinalAcpt;
					}else{
						$montant = $mtTarif;
						$montantReal = $totFinalReal;
						$devisefrom = 'EUR';//$_POST['devisefrom'];
						$deviseto = $ct->code_devise;
						
						$url1 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montant";
						$response1 = file_get_contents($url1);
						$data1 = json_decode($response1, true);

						$arr['tot_ht'] = $montant * (isset($data1['result']) ? (float)$data1['result'] : 1);
						$arr['mt_ok_ht'] = ($montant * (isset($data1['result']) ? (float)$data1['result'] : 1))  * ((100 - $ct->accompte_25) / 100);

						$url2 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montantReal";
						$response2 = file_get_contents($url2);
						$data2 = json_decode($response2, true);
						
						$arr['tot_real'] = $montantReal * (isset($data2['result']) ? (float)$data2['result'] : 1);
							
					}

					// ##
					// Pour eviter les erreurs de calcul, on verifie s'il y a un montant des transports a ajouter au tot_real
					$mtTransp = 0;
					$sumTransp = Tarif::totSumTransport(array('id_fiche'=>$ct->id_fiche, 'id_sejour'=>$ct->id_organisateur));
					// print_r('kkkkk'.$sumTransp->Mt);
					if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
						$mtTransp = $sumTransp->Mt;
					}else{
						$devisefrom = 'EUR';//$_POST['devisefrom'];
						$deviseto = $ct->code_devise ;
					
						$mtTransp = $sumTransp->Mt;
					
						$url = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$mtTransp";
						$response = file_get_contents($url);
						$data = json_decode($response, true);
					
						$mtTransp = (isset($data['result']) ? (float)$data['result'] : 0);
					}
					
					$arr['tot_transport'] = $mtTransp;	
					/* 
					mise a jour des 
						tot_real = mt_fin et 
						tot_ht = tot_ht 
					cote client (leur difference est dans l'ajout ou non de la taxe sejour 
					
					ET LE TRANSPORT N'EST AJOUTER QUE SI LE TARIF N"EST PAS MANUEL , DONC PAS DECIDE ARBITRAIREMENT
					*/
					if($ct->is_tot_manu <= 0 || (int)$_POST['istotmanu'] <= 0){
						$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
					}

					$arr['tot_real'] = $arr['tot_real'] + $mtTransp;

					$sum = Reglements::sumRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1'));
					
					if($sum->MT > 0){
						$arr['tot_restant'] = ($arr['tot_ht'] - $sum->MT) ;
						Reglements::updateRglts(array('mt_restant'=>$arr['tot_restant']),array('id_fiche'=>$ct->id_fiche));
					}

					$isvalidate = Reglements::getAllRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1', 'id_sejour'=>$usrActif->cursoc));
					
					if($isvalidate->num_rows > 0){
						$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "CLIENT CONFIRME" ', true,'');
						$arr['id_status_sec'] = $stsec->id_status_sec;
						
					}else{

					}

					/* LA MISE AJOUR DU CLIENT FICHE::UPDATE SE FAIT DEJA DANS LE EVENT UPDATE DE LA GRILLE LIST_DETAILS */
					
					respAjax::successJSON(array('OK' => 'OK', 'totreal'=>$arr['tot_real'], 'mttot'=>(float)$mtTarif, 
												'restant'=>(float)$tot_restant, 'tot_transp'=>(float)$mtTransp));
				}

				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modification échouée' : 'Edit failed')));

			break;	

		case 'maj-amount-rglt':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'tarif')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$mtTarif = 0;
			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));

			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			$soc = Soc::findOne(array('is_soc'=>'1'));
			$sejour = Setting::getOrganisateur(array('id_organisateur'=>$ct->id_organisateur));

			if($resInfmail){
				Mailings::sendMail('mail-contact', (object)array(
					'subject' => $soc->name_soc.' - Lien vers paiement securisé',
					'email' => $ct->email,
					'msg' => 'Bonjour,<br>'.($ct->civ_contact == 1 ? 'MONSIEUR' : 'MADAME').' '.$ct->last_name.' '.$ct->first_name.'<br>'
								.$soc->name_soc.', vous remercie de votre confiance <br>
								Vous trouverez ci-joint le lien vers le paiement sécurisé, pour un montant de : '.$_POST['tarif'].' '.(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR' ? 'EUR' : $ct->code_devise).'<br>
								<a href="https://www.apayer.fr/crystalclub">Cliquez ici</a><br>
								<br>
								<br>
								Nous restons a votre entière disposition pour toutes informations, aux coordonnées ci-dessous : <br>'
								.$soc->tel_soc.'<br>'
								.$soc->email_soc.'<br>
								et vous souhaite un agréable séjour.<br>
								Cordialement<br>',
					'doc'=> array()
				));
			}else{
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Boite d\'envoi non définie\n\rConsultez vos paramétrages' : 'Outbox not defined\nCheck your settings')));
			}
			
			respAjax::successJSON(array('OK' => 'OK' , 'message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers paiement transmis' : 'Link for paiment sended')));

			break;

		case 'maj-tarif-manu-grid':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'iddetail')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$mtTarif = 0;
				$tot_restant = 0;
				$tarifNuit = false;
				$tarifSemaine = false;
				$tarifSejour = false;

				$addTot = 0;

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

				$res = Fiche::updateDetails(array('tarif_details'=>$_POST['tarif']), array('id_fiche'=>(int)$_POST['idct'], 'id_contact_detail'=>(int)$_POST['iddetail']));
				if($res){
					// recalcul du montant
					$allTarifs = Fiche::getAllDetails(array('id_fiche'=>(int)$_POST['idct']));
					foreach($allTarifs as $tarif){
						$mtTarif += $tarif['tarif_details'];
					}
					
					$alldetailsopts = Fiche::getAllDetailsOptions(array('id_fiche'=>(int)$_POST['idct']));
					foreach($alldetailsopts as $detailsopts){
						$mtTarif += $detailsopts['tot_tarif_option'];
					}

					$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
					
					$date1 = new DateTime($ct->date_start);
					$date2 = new DateTime($ct->date_end);
	
					$jours = $date2->diff($date1)->days;
					// $jours += 1; //inclure le dernier jour
				
					$semaine = $jours / 7 ;

					if($tarifSemaine){
						$mtTarif = $mtTarif * $semaine;
					}
					if($tarifNuit){
						$mtTarif = $mtTarif * $jours;
					}
					if($tarifSejour){
						$mtTarif = $mtTarif;
					}

					// tarif manuel
					if($ct->is_tot_manu > 0 || (int)$_POST['istotmanu'] > 0){
						$arr['is_tot_manu'] = '1';
						// $mtTarif = str_replace(array(' ',','),array(''),$ct->tot_ht);
						$mtTarif = $ct->tot_manu;
						$mtTarif += $ct->taxe_sejour;

						// pour tot reel
						$totFinalReal = (($mtTarif + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin 
						$totFinalReal += $ct->taxe_sejour;
						*/
					}else{
						$mtTarif = $mtTarif * ((100 - $ct->offre_sejour) / 100);
						$mtTarif += $ct->taxe_sejour;

						// pour tot reel
						$totFinalReal = (($mtTarif + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin 
						$totFinalReal += $_POST['taxe_sejour'];
						*/
					}

					
					$totFinalAcpt = ($mtTarif  * (100 - $ct->accompte_25)) / 100;

					if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
						$arr['tot_ht'] = $mtTarif;
						$arr['tot_real'] = $totFinalReal;
						$arr['mt_ok_ht'] = $totFinalAcpt;

						// pour tot reel
						// $totFinalReal = (($mtTarif + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						// $totFinalReal += $ct->taxe_sejour;
					}else{
						$montant = $mtTarif;
						$montantReal = $totFinalReal;
						$devisefrom = 'EUR';//$_POST['devisefrom'];
						$deviseto = $ct->code_devise;
						
						$url1 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montant";
						$response1 = file_get_contents($url1);
						$data1 = json_decode($response1, true);

						$arr['tot_ht'] = $montant * (isset($data1['result']) ? (float)$data1['result'] : 1);
						$arr['mt_ok_ht'] = ($montant * (isset($data1['result']) ? (float)$data1['result'] : 1))  * ((100 - $ct->accompte_25) / 100);

						$url2 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montantReal";
						$response2 = file_get_contents($url2);
						$data2 = json_decode($response2, true);
						
						$arr['tot_real'] = $montantReal * (isset($data2['result']) ? (float)$data2['result'] : 1);
										
						// $arr['mt_ok_ht'] = (($montant * (Float)str_replace(',','.',$devise[1]))  * (100 - $ct->accompte_25)) / 100;
					}

					// ##
					// Pour eviter les erreurs de calcul, on verifie s'il y a un montant des transports a ajouter au tot_real
					$mtTransp = 0;
					$sumTransp = Tarif::totSumTransport(array('id_fiche'=>$ct->id_fiche, 'id_sejour'=>$ct->id_organisateur));
					// print_r('kkkkk'.$sumTransp->Mt);
					if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
						$mtTransp = $sumTransp->Mt;
					}else{
						$devisefrom = 'EUR';//$_POST['devisefrom'];
						$deviseto = $ct->code_devise ;
					
						$mtTransp = $sumTransp->Mt;
					
						$url = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$mtTransp";
						$response = file_get_contents($url);
						$data = json_decode($response, true);
					
						$mtTransp = (isset($data['result']) ? (float)$data['result'] : 0);
					}
					
					$arr['tot_transport'] = $mtTransp;
					/* 
					mise a jour des 
						tot_real = mt_fin et 
						tot_ht = tot_ht 
					cote client (leur difference est dans l'ajout ou non de la taxe sejour 
					
					ET LE TRANSPORT N'EST AJOUTER QUE SI LE TARIF N"EST PAS MANUEL , DONC PAS DECIDE ARBITRAIREMENT
					*/
					if($ct->is_tot_manu <= 0 || (int)$_POST['istotmanu'] <= 0){
						$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
					}

					$arr['tot_real'] = $arr['tot_real'] + $mtTransp;

					$sum = Reglements::sumRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1'));
					
					if($sum->MT > 0){
						$arr['tot_restant'] = ($arr['tot_ht'] - $sum->MT) ;
						Reglements::updateRglts(array('mt_restant'=>$arr['tot_restant']),array('id_fiche'=>$ct->id_fiche));
					}
					$isvalidate = Reglements::getAllRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1', 'id_sejour'=>$usrActif->cursoc));
			
					if($isvalidate->num_rows > 0){
						$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "CLIENT CONFIRME" ', true,'');
						$arr['id_status_sec'] = $stsec->id_status_sec;
						
					}else{

					}
					
					/* LA MISE AJOUR DU CLIENT FICHE::UPDATE SE FAIT DEJA DANS LE EVENT UPDATE DE LA GRILLE LIST_DETAILS */
					respAjax::successJSON(array('OK' => 'OK', 'totreal'=>$arr['tot_real'],'mttot'=>(float)$mtTarif, 
											'restant'=>(float)$tot_restant, 'tot_transp'=>(Float)$mtTransp));
				}

				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modification échouée' : 'Edit failed')));

			break;	

		case 'delete-doc':
			if (!Ctrl::ctrlflds($_POST, array('iddoc')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$doc = Doc::findOne(array('id_doc' => (int)$_POST['iddoc']));
			if (!$doc)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if (Doc::delete(array('id_doc' => (int)$_POST['iddoc']))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'SUPPRESSION DOCUMENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $doc->name_doc));
				
				respAjax::successJSON(array('OK' => 'OK'));
			}

			break;

		case 'accept-doc':
			if (!Ctrl::ctrlflds($_POST, array('iddoc')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$doc = Doc::findOne(array('id_doc' => (int)$_POST['iddoc']));
			if (!$doc)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if (Doc::update(array('accept_doc' => $doc->accept_doc == 0 ? true : false),array('id_doc' => (int)$_POST['iddoc']))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'VALIDATION DOCUMENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $doc->name_doc));
				respAjax::successJSON(array('OK' => 'OK'));
			}

			break;

		case 'load-listdocs':
			if (!Ctrl::ctrlflds($_POST, array('idc')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			
			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idc']));
			if (!$ct || !Fiche::checkRight($ct))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vous ne pouvez pas effectuer cette opération' : 'Denied')));


			$docs = Doc::getBy(array('id_fiche' => $ct->id_fiche));
			if (!$docs)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun document CRM' : 'No documents CRM')));

			$html = TemplateHtml::listDocs($ct, $docs);
			
			respAjax::successJSON(array('OK' => 'OK', 'html' => $html));		
			break;

		case 'change-devise':
			// print_r($_POST);
			// die;
			if (!Ctrl::ctrlflds($_POST, array('idct', 'codedevise')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			Fiche::update(array('code_devise'=>$_POST['codedevise']), array('id_fiche'=>(int)$_POST['idct']));

			respAjax::successJSON(array('OK'=>'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour de la devise pour ce client' : 'Rate updated for customer')));
			break;

			
		case 'devises':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'montant', 'devisefrom', 'deviseto' )))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			$montant = $_POST['montant'];
			$devisefrom = $_POST['devisefrom'];
			$deviseto = $_POST['deviseto'];
			
			// $file = file_get_contents('http://www.xe.com/ucc/convert.cgi?Amount='.$montant.'&From='.$devisefrom.'&To='.$deviseto.'');
			$file = file_get_contents('https://www.xe.com/fr/currencyconverter/convert/?Amount='.$montant.'&From='.$devisefrom.'&To='.$deviseto.'');
			
			preg_match('` ([,0-9.]+) '.$deviseto.'`i', $file, $devise);
			
			$total = $_POST['montant'] * (Float)str_replace(',','.',$devise[1]);
			$totalrest = ($total  * (100 - $_POST['ac25'])) / 100;

			$taxe = $_POST['taxesej'] * (Float)str_replace(',','.',$devise[1]);

			Fiche::update(array('tot_ht'=>$total, 'mt_ok_ht'=>$totalrest, 'taxe_sejour'=>$taxe), array('id_fiche'=>(int)$_POST['idct']));
			
			respAjax::successJSON(array('OK'=>'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Devise appliquée sur les montants de : '.$_POST['devisefrom'].' vers : '.$_POST['deviseto'] : 'Currency applied for : '.$_POST['devisefrom'].' to : '.$_POST['deviseto']), 'tot_ht'=>$total, 'mt_ok_ht'=>$totalrest));
			break;

		case 'get-rglt-init':
			$sumglob = QueryExec::querySQL('SELECT SUM(mt_rglt) as MTG FROM db_reglements WHERE id_sejour = '.$usrActif->cursoc, true);

			respAjax::successJSON(array('OK'=>'OK', 'sumglob'=>$sumglob->MTG, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enregistrement du règlement' : 'Payment saved')));
			break;

		case 'get-rglt-det':
			if (!Ctrl::ctrlflds($_POST, array('idct'))) 
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$sumdet = QueryExec::querySQL('SELECT SUM(mt_rglt) as MTG FROM db_reglements WHERE id_sejour = '.$usrActif->cursoc.' AND id_fiche = '.(int)$_POST['idct'], true);
			$sumdetvalide = QueryExec::querySQL('SELECT SUM(mt_rglt) as MTG FROM db_reglements WHERE id_sejour = '.$usrActif->cursoc.' AND id_fiche = '.(int)$_POST['idct'].' AND is_validate = 1', true);


			respAjax::successJSON(array('OK'=>'OK', 'sumdetvalide'=>$sumdetvalide->MTG, 'sumdet'=>$sumdet->MTG, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enregistrement du règlement' : 'Payment saved')));
			break;

		case 'add-rglt':
			if (!Ctrl::ctrlflds($_POST, array('selfiche', 'mtrglt'))) 
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = Reglements::CreateRglts(array('id_fiche'=>(int)$_POST['selfiche'], 
											'date_rglt'=>date('Y-m-d'), 
											'mt_rglt'=>$_POST['mtrglt'], 
											'is_validate'=>(isset($_POST['isvalidate']) ? '1' : '0'), 
											'id_sejour'=>$usrActif->cursoc,
											'mode_rglt'=>(int)$_POST['selmoderglt']));

			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enregistrement du règlement échoué' : 'Payment registration failed')));
			}

			$sumglob = QueryExec::querySQL('SELECT SUM(mt_rglt) as MTG FROM db_reglements WHERE id_sejour = '.$usrActif->cursoc, true);

			if(isset($_POST['isvalidate'])){
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "CLIENT CONFIRME" ', true,'');
				$arr['id_status_sec'] = $stsec->id_status_sec;
				Fiche::update($arr, array('id_fiche'=>(int)$_POST['selfiche']));
			}

			respAjax::successJSON(array('OK'=>'OK', 'sumglob'=>$sumglob->MTG, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enregistrement du règlement' : 'Payment saved')));
			break;

		case 'maj-tot-manu':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'tarifmanu'))) 
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			// oncommence par la mise a jour des dates pour avoir les bonnes valeurs de calcul des periodes			
			$arr['date_start'] = Tool::dmYtoYmd($_POST['dts']);
			$arr['date_end'] = Tool::dmYtoYmd($_POST['dte']);
			$arr['time_start'] = $_POST['ts'];
			$arr['time_end'] = $_POST['te'];
			$arr['tot_manu'] = $_POST['tarifmanu'];
			$arr['is_tot_manu'] = (int)$_POST['is_tot_manu'];

			if(!Fiche::update($arr,array('id_fiche'=>(int)$_POST['idct'], 'id_organisateur'=>$usrActif->cursoc))){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur de mise a jour' : 'Update error')));
			}

			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));

			$ad = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche, 'type_detail'=>'1'));
			$enf = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche, 'type_detail'=>'2'));
			$bb = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche, 'type_detail'=>'3'));
		
			$infchs = Chambres::getAll(array('id_fiche'=>$ct->id_fiche));
			$addTot = 0;
			
			foreach($infchs as $ch){
				$prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
				if($prixch->tarif_chambre > 0){
					$addTot += $prixch->tarif_chambre;
				}
			}

			$tarifNuit = false;
			$tarifSemaine = false;
			$tarifSejour = false;

			$nbadulte = $ad->num_rows;
			$nbenf = $enf->num_rows;
			$nbbb = $bb->num_rows;

		
			$date1 = new DateTime($ct->date_start);
			$date2 = new DateTime($ct->date_end);

			$jours = $date2->diff($date1)->days;
		
			$semaine = $jours / 7 ;

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

			
			$alldetails = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche));
			foreach($alldetails as $details){
				$sumTarif += $details['tarif_details'];
				$sumTarif += $details['tarif_transport'];
				$sumTarif += $details['tarif_supp_detail'];
			}
			
			$alldetailsOptions = Fiche::getAllDetailsOptions(array('id_fiche'=>$ct->id_fiche, 'id_sejour'=>$ct->id_organisateur));
			foreach($alldetailsOptions as $detailsOptions){
				$sumTarif += $detailsOptions['tot_tarif_option'];
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

			// tarif manuel
			if((int)$arr['is_tot_manu'] > 0){
				$totFinal = (int)str_replace(array(' ',','),array(''),$_POST['tarifmanu']);
				$totFinal += $_POST['taxe_sejour'];

				// pour tot reel
				$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $_POST['taxe_sejour'];
				*/
			}else{
				$totFinal = ($tot + $addTot)  * ((100 - $ct->offre_sejour) / 100);
				$totFinal += $_POST['taxe_sejour'];

				// pour tot reel
				$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $_POST['taxe_sejour'];
				*/
			}

			$totFinalAcpt = $totFinal  * ((100 - $ct->accompte_25) / 100);

			if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
				$arr['tot_ht'] = $totFinal;
				$arr['tot_real'] = $totFinalReal;
				$arr['mt_ok_ht'] = $totFinalAcpt;

				// pour tot reel
				// $totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				// $totFinalReal += $_POST['taxe_sejour'];
			}else{
				$montant = $totFinal;
				$montantReal = $totFinalReal;
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $ct->code_devise;
				
				$url1 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montant";
				$response1 = file_get_contents($url1);
				$data1 = json_decode($response1, true);
				
				$arr['tot_ht'] = $montant * (isset($data1['result']) ? (float)$data1['result'] : 1);
				$arr['mt_ok_ht'] = ($montant * (isset($data1['result']) ? (float)$data1['result'] : 1))  * ((100 - $ct->accompte_25) / 100);

				$url2 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montantReal";
				$response2 = file_get_contents($url2);
				$data2 = json_decode($response2, true);
				
				$arr['tot_real'] = $montantReal * (isset($data2['result']) ? (float)$data2['result'] : 1);
				
			}

			// ##
			// Pour eviter les erreurs de calcul, on verifie s'il y a un montant des transports a ajouter au tot_real
			$mtTransp = 0;
			$sumTransp = Tarif::totSumTransport(array('id_fiche'=>$ct->id_fiche, 'id_sejour'=>$ct->id_organisateur));
			if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
				$mtTransp = $sumTransp->Mt;
			}else{
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $ct->code_devise ;
			
				$mtTransp = $sumTransp->Mt;
			
				$url = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$mtTransp";
				$response = file_get_contents($url);
				$data = json_decode($response, true);
			
				$mtTransp = (isset($data['result']) ? (float)$data['result'] : 0);
			}

			$arr['tot_transport'] = $mtTransp;	
			/* 
			mise a jour des 
				tot_real = mt_fin et 
				tot_ht = tot_ht 
			cote client (leur difference est dans l'ajout ou non de la taxe sejour 

			ET LE TRANSPORT N'EST AJOUTER QUE SI LE TARIF N"EST PAS MANUEL , DONC PAS DECIDE ARBITRAIREMENT
			*/
			if((int)$arr['is_tot_manu'] <= 0){
				$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
			}

			$arr['tot_real'] = $arr['tot_real'] + $mtTransp;
			
			$sum = Reglements::sumRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1'));
			if($sum->MT > 0){
				$arr['tot_restant'] = ($arr['tot_ht'] - $sum->MT) ;
				Reglements::updateRglts(array('mt_restant'=>$arr['tot_restant']),array('id_fiche'=>$ct->id_fiche));
			}
			

			if(Fiche::update(array('taxe_sejour'=>((int)$_POST['taxe_sejour'] > 0 ? $_POST['taxe_sejour'] : '0'), 
									'tot_ht'=>$arr['tot_ht'], 
									'tot_real'=>$arr['tot_real'],
									'is_tot_manu'=>'1', 
									'tot_manu'=>$_POST['tarifmanu'], 
									'tot_transport'=>$mtTransp,
									'tot_restant'=>$arr['tot_restant'],
									'date_start'=>Tool::dmYtoYmd($_POST['dts']), 
									'date_end'=>Tool::dmYtoYmd($_POST['dte']),
									'time_start'=>$_POST['ts'], 'time_end'=>$_POST['te']), 
							array('id_fiche'=>(int)$_POST['idct'], 'id_organisateur'=>$usrActif->cursoc))){
			// if(Fiche::update(array('taxe_sejour'=>((int)$_POST['taxe_sejour'] > 0 ? $_POST['taxe_sejour'] : '0'), 
			// 						'tot_ht'=>($_POST['tarifmanu'] + (int)$_POST['taxe_sejour']), 'tot_real'=>$arr['tot_real'],
			// 						'is_tot_manu'=>'1', 'tot_manu'=>$_POST['tarifmanu'], 'tot_transport'=>$mtTransp,
			// 						'date_start'=>Tool::dmYtoYmd($_POST['dts']), 'date_end'=>Tool::dmYtoYmd($_POST['dte']),
			// 						'time_start'=>$_POST['ts'], 'time_end'=>$_POST['te']), 
			// 				array('id_fiche'=>(int)$_POST['idct'], 'id_organisateur'=>$usrActif->cursoc))){

				respAjax::successJSON(array('OK'=>'OK', 'totht'=>($_POST['tarifmanu'] + (int)$_POST['taxe_sejour']), 'totreal'=>$arr['tot_real'], 
										'tot_transp'=>(Float)$mtTransp,	'tot_restant'=>$arr['tot_restant'], 'tot_rglt'=>$sum->MT,
										'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enregistrement du règlement' : 'Payment saved')));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Echec de la mise a jour' : 'Update mistake')));

			break;

		case 'maj-tot-auto':
			if (!Ctrl::ctrlflds($_POST, array('idct'))) 
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			
			// oncommence par la mise a jour des dates pour avoir les bonnes valeurs de calcul des periodes			
			$arr['date_start'] = Tool::dmYtoYmd($_POST['dts']);
			$arr['date_end'] = Tool::dmYtoYmd($_POST['dte']);
			$arr['time_start'] = $_POST['ts'];
			$arr['time_end'] = $_POST['te'];
			$arr['tot_manu'] = $_POST['tarifmanu'];
			
			if(!Fiche::update($arr,array('id_fiche'=>(int)$_POST['idct'], 'id_organisateur'=>$usrActif->cursoc))){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur de mise a jour' : 'Update error')));
			}
			
			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
			if(!$ct){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la récupération des infos' : 'Error retrieving information')));
			}
			
			$arr['is_tot_manu'] = 0;
			
			$ad = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche, 'type_detail'=>'1'));
			$enf = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche, 'type_detail'=>'2'));
			$bb = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche, 'type_detail'=>'3'));
		
			$infchs = Chambres::getAll(array('id_fiche'=>$ct->id_fiche));
			$addTot = 0;
			
			foreach($infchs as $ch){
				$prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
				if($prixch->tarif_chambre > 0){
					$addTot += $prixch->tarif_chambre;
				}
			}

			$tarifNuit = false;
			$tarifSemaine = false;
			$tarifSejour = false;

			$nbadulte = $ad->num_rows;
			$nbenf = $enf->num_rows;
			$nbbb = $bb->num_rows;

		
			$date1 = new DateTime($ct->date_start);
			$date2 = new DateTime($ct->date_end);

			$jours = $date2->diff($date1)->days;
		
			$semaine = $jours / 7 ;

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

			
			$alldetails = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche));
			foreach($alldetails as $details){
				$sumTarif += $details['tarif_details'];
				$sumTarif += $details['tarif_transport'];
				$sumTarif += $details['tarif_supp_detail'];
			}
			
			$alldetailsOptions = Fiche::getAllDetailsOptions(array('id_fiche'=>$ct->id_fiche, 'id_sejour'=>$ct->id_organisateur));
			foreach($alldetailsOptions as $detailsOptions){
				$sumTarif += $detailsOptions['tot_tarif_option'];
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

			// tarif manuel
			if((int)$arr['is_tot_manu'] > 0){
				$totFinal = (int)str_replace(array(' ',','),array(''),$_POST['tarifmanu']);
				$totFinal += $_POST['taxe_sejour'];

				// pour tot reel
				$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $_POST['taxe_sejour'];
				*/
			}else{
				$totFinal = ($tot + $addTot)  * ((100 - $ct->offre_sejour) / 100);
				$totFinal += $_POST['taxe_sejour'];

				// pour tot reel
				$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $_POST['taxe_sejour'];
				*/
			}

			$totFinalAcpt = $totFinal  * ((100 - $ct->accompte_25) / 100);

			if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
				$arr['tot_ht'] = $totFinal;
				$arr['tot_real'] = $totFinalReal;
				$arr['mt_ok_ht'] = $totFinalAcpt;

				// // pour tot reel
				// $totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				// $totFinalReal += $_POST['taxe_sejour'];
			}else{
				$montant = $totFinal;
				$montantReal = $totFinalReal;
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $ct->code_devise ;
				
				// $file = file_get_contents('http://www.xe.com/ucc/convert.cgi?Amount='.$montant.'&From='.$devisefrom.'&To='.$deviseto.'');
				// preg_match('` ([,0-9.]+) '.$deviseto.'`i', $file, $devise);
				$url1 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montant";
				$response1 = file_get_contents($url1);
				$data1 = json_decode($response1, true);

				
				$arr['tot_ht'] = $montant * (isset($data1['result']) ? (float)$data1['result'] : 1); //(Float)str_replace(',','.',$devise[1]);
				$arr['mt_ok_ht'] = ($montant * (isset($data2['result']) ? (float)$data2['result'] : 1))  * ((100 - $ct->accompte_25) / 100);

				// $file = file_get_contents('http://www.xe.com/ucc/convert.cgi?Amount='.$montantReal.'&From='.$devisefrom.'&To='.$deviseto.'');
				// preg_match('` ([,0-9.]+) '.$deviseto.'`i', $file, $devise);
				$url2 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montantReal";
				$response2 = file_get_contents($url2);
				$data2 = json_decode($response2, true);
				
				$arr['tot_real'] = $montantReal * (isset($data2['result']) ? (float)$data2['result'] : 1); //(Float)str_replace(',','.',$devise[1]);
				
				// $arr['mt_ok_ht'] = ($montant * (Float)str_replace(',','.',$devise[1]))  * ((100 - $ct->accompte_25) / 100);
			}

			$arr['date_start'] = Tool::dmYtoYmd($_POST['dts']);
			$arr['date_end'] = Tool::dmYtoYmd($_POST['dte']);
			$arr['time_start'] = $_POST['ts'];
			$arr['time_end'] = $_POST['te'];
			$arr['tot_manu'] = $_POST['tarifmanu'];
			
			// ##
			// Pour eviter les erreurs de calcul, on verifie s'il y a un montant des transports a ajouter au tot_real
			$mtTransp = 0;
			$sumTransp = Tarif::totSumTransport(array('id_fiche'=>$ct->id_fiche, 'id_sejour'=>$ct->id_organisateur));
			if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
				$mtTransp = $sumTransp->Mt;
			}else{
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $ct->code_devise ;
			
				$mtTransp = $sumTransp->Mt;
			
				$url = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$mtTransp";
				$response = file_get_contents($url);
				$data = json_decode($response, true);
			
				$mtTransp = (isset($data['result']) ? (float)$data['result'] : 0);
			}

			$arr['tot_transport'] = $mtTransp;	
			/* 
			mise a jour des 
				tot_real = mt_fin et 
				tot_ht = tot_ht 
			cote client (leur difference est dans l'ajout ou non de la taxe sejour 
			
			ET LE TRANSPORT N'EST AJOUTER QUE SI LE TARIF N"EST PAS MANUEL , DONC PAS DECIDE ARBITRAIREMENT
			*/
			if((int)$arr['is_tot_manu'] <= 0){
				$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
			}

			$arr['tot_real'] = $arr['tot_real'] + $mtTransp;

			$sum = Reglements::sumRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1'));
			if($sum->MT > 0){
				$arr['tot_restant'] = ($arr['tot_ht'] - $sum->MT) ;
				Reglements::updateRglts(array('mt_restant'=>$arr['tot_restant']),array('id_fiche'=>$ct->id_fiche));
			}

			if(Fiche::update($arr,array('id_fiche'=>(int)$_POST['idct'], 'id_organisateur'=>$usrActif->cursoc))){
				respAjax::successJSON(array('totht'=>$arr['tot_ht'], 'totreal'=>$arr['tot_real'], 'tot_transp'=>(Float)$mtTransp,
											'tot_restant'=>$arr['tot_restant'], 'tot_rglt'=>$sum->MT,
											'message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour effectuée' : 'Updated')));
			}
			
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur mise a jour' : 'Update error')));

			break;

		case 'global-update':
			// print_r($_POST);
			// die;
			if (!Ctrl::ctrlflds($_POST, array('id_fiche'))) 
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$contact = Fiche::findOne(array('c.id_fiche' => (int)$_POST['id_fiche']));
			if (!$contact)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client inexistant' : 'Customer not found')));

			$arr['date_update'] = date('Y-m-d H:i:s');

			$mandator = Setting::getOrganisateur(array('id_organisateur' =>$contact->id_organisateur));
			
			$fldsfromgrid = array('id_contact_detail','last_name_detail','first_name_detail','date_naissance_detail','age',
								'etat_fac','num_fac','name_doc','date_receive_fac', 'hour_realized', 'hour_realized_form', 'linesday','lineshdeb','lineshend','signed','to_sign','idth',
								'listeCh_length', 'num_passport', 'type_detail', 'seldevises','codedevisect', 'tarif_detail','age_tarif', 'libelle_tarif','libelle_tarif_details','tarif_details',
								'transport_detail', 'tarif_transport', 'year_birth', 'month_birth', 'day_birth', 'opt_lib_1', 'opt_lib_2','tarif_supp_detail','id_rglt', 'date_rglt', 'mt_rglt', 'mode_rglt',
								'id_virement', 'is_validate', 'tot_rglt', 'contact', 'puburl', 'id_sejour', 'lib_detail_option', 'tarif_detail_option','id_contact_detail_option', 'tot_tarif_option',
								'qte_detail_option', 'id_lib_option', 'mt_restant', 'istotmanu');
			foreach ($_POST as $k => $v) {
				if ($k != 'action' && !in_array($k, $fldsfromgrid)) {
					if (strtolower(substr($k,0,5) == 'date_') )
						$arr[$k] = Tool::dmYtoYmd($v);
					else
						$arr[$k] = $v;
				}
			}	

			if(isset($_POST['volnavette'])){
				$arr['volnavette'] = 1;
			}else{
				$arr['volnavette'] = 0;
			}

			if(isset($_POST['navetteseule'])){
				$arr['navetteseule'] = 1;
			}else{
				$arr['navetteseule'] = 0;
			}

			if(isset($_POST['volseul'])){
				$arr['volseul'] = 1;
			}else{
				$arr['volseul'] = 0;
			}

			if(isset($_POST['handicap'])){
				$arr['handicap'] = 1;
			}else{
				$arr['handicap'] = 0;
			}

			if(isset($_POST['terrasse_balcon_souhait'])){
				$arr['terrasse_balcon_souhait'] = 1;
			}else{
				$arr['terrasse_balcon_souhait'] = 0;
			}

				
			if (!isset($arr['accompte_25']))
				$arr['accompte_25'] = $arr['tarif_formation'] * 0.25;

			if($_POST['istotmanu'] > 0){
				$arr['is_tot_manu'] = 1;
			}else{
				$arr['is_tot_manu'] = 0;
			}
			
			if(strtotime(Tool::dmYtoYmd($_POST['date_devis'])) > 0 && (strtotime($contact->date_devis) <= 0 || trim($contact->numdevis) == '') ){
				$arr['date_devis'] = Tool::dmYtoYmd($_POST['date_devis']);
				
				$nodevis = Fiche::getLastNoDevis(array('id_organisateur'=>$contact->id_organisateur));
				$nodevis++;

				$arr['numdevis'] = 'D'.date('Y').'-'.str_pad($nodevis,5,"0",STR_PAD_LEFT);
				$arr['nodevis'] = $nodevis;
			}

			if(strtotime(Tool::dmYtoYmd($_POST['date_fac'])) > 0 && (strtotime($contact->date_fac) <= 0 || trim($contact->numfac) == '' || $contact->numfac == '0') ){
				$arr['date_fac'] = Tool::dmYtoYmd($_POST['date_fac']);
				
				$nofac = Fiche::getLastNoFacSimple('id_organisateur = '.$contact->id_organisateur.' AND LEFT(date_fac,4) = '.date('Y') );
				if($nofac == 0){
					$nofac = 1 ;
				}else {
					$nofac++;
				}

				$arr['numfac'] = 'F'.date('Y').'-'.str_pad($nofac,5,"0",STR_PAD_LEFT);
				$arr['nofac'] = $nofac;
			}

			$ad = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'1'));
			$enf = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'2'));
			$bb = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'3'));
		
			$infchs = Chambres::getAll(array('id_fiche'=>$contact->id_fiche));
			$addTot = 0;
			
			foreach($infchs as $ch){
				$prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
				if($prixch->tarif_chambre > 0){
					$addTot += $prixch->tarif_chambre;
				}
			}

			$tarifNuit = false;
			$tarifSemaine = false;
			$tarifSejour = false;

			$nbadulte = $ad->num_rows;
			$nbenf = $enf->num_rows;
			$nbbb = $bb->num_rows;

		
			$date1 = new DateTime($arr['date_start']);
			$date2 = new DateTime($arr['date_end']);

			$jours = $date2->diff($date1)->days;
			// $jours += 1; //inclure le dernier jour
		
			$semaine = $jours / 7 ;

			// $tarifs = Tarif::getAll(array());
			// foreach($tarifs as $tarif){
			// 	if(!$tarif['is_tarif_nuit']){
			// 		$tarifSemaine = true;
			// 	}

			// 	$tarifAdulte = $tarif['tarif_adulte'];
			// 	$tarifEnf = $tarif['tarif_enfant'];
			// 	$tarifBb = $tarif['tarif_bb'];
			// }
			// if($tarifSemaine){
			// 	$tot = (($nbadulte * $tarifAdulte * $semaine) + ($nbenf * $tarifEnf * $semaine) + ($nbbb * $tarifBb * $semaine));
			// }else{
			// 	$tot = (($nbadulte * $tarifAdulte * $jours) + ($nbenf * $tarifEnf * $jours) + ($nbbb * $tarifBb * $jours));
			// }


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

			
			$alldetails = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche));
			foreach($alldetails as $details){
				$sumTarif += $details['tarif_details'];
				$sumTarif += $details['tarif_transport'];
				$sumTarif += $details['tarif_supp_detail'];
			}
			
			$alldetailsOptions = Fiche::getAllDetailsOptions(array('id_fiche'=>$contact->id_fiche, 'id_sejour'=>$contact->id_organisateur));
			foreach($alldetailsOptions as $detailsOptions){
				$sumTarif += $detailsOptions['tot_tarif_option'];
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

			// echo($tot.' - '.$semaine.' ** '.print_r($date1).' == '.print_r($date2).' => '.$jours);
			// die;

			// tarif manuel
			if((int)$_POST['istotmanu'] > 0){
				// $totFinal = (int)str_replace(array(' ',','),array(''),$_POST['tot_ht']);
				$totFinal = (int)str_replace(array(' ',','),array(''),$contact->tot_manu);
				$totFinal += $contact->taxe_sejour;
				
				// pour tot reel
				$totFinalReal = (($totFinal + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $contact->taxe_sejour;
				*/
			}else{
				$totFinal = ($tot + $addTot)  * ((100 - $arr['offre_sejour']) / 100);
				$totFinal += $arr['taxe_sejour'];

				// pour tot reel
				$totFinalReal = (($totFinal + $addTot)  * (100 - $contact->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $arr['taxe_sejour'];
				*/
			}

			// $tmpecho = ( str_replace(array(' ',','),array(''),$_POST['tot_ht']).' -> '.$contact->tot_ht.' = '.$arr['tot_ht'].' - '.$sum->MT.' -- '.$totFinal);
			// error_log(' ***** '.$tmpecho);

			$totFinalAcpt = $totFinal  * ((100 - $arr['accompte_25']) / 100);

			if(trim($contact->code_devise) == '' || trim($contact->code_devise) == 'EUR'){
				$arr['tot_ht'] = $totFinal;
				$arr['tot_real'] = $totFinalReal;
				$arr['mt_ok_ht'] = $totFinalAcpt;

				// pour tot reel
				// $totFinalReal = (($totFinal + $addTot)  * (100 - $contact->offre_sejour)) / 100;
				// $totFinalReal += $contact->taxe_sejour;
			}else{
				$montant = $totFinal;
				$montantReal = $totFinalReal;
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $contact->code_devise;
				
				$url1 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montant";
				$response1 = file_get_contents($url1);
				$data1 = json_decode($response1, true);

				$arr['tot_ht'] = $montant * (isset($data1['result']) ? (float)$data1['result'] : 1);
				$arr['mt_ok_ht'] = ($montant * (isset($data1['result']) ? (float)$data1['result'] : 1))  * ((100 - $ct->accompte_25) / 100);

				$url2 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montantReal";
				$response2 = file_get_contents($url2);
				$data2 = json_decode($response2, true);
				
				$arr['tot_real'] = $montantReal * (isset($data2['result']) ? (float)$data2['result'] : 1);
				
			}
			
			// ##
			// Pour eviter les erreurs de calcul, on verifie s'il y a un montant des transports a ajouter au tot_real
			$mtTransp = 0;
			$sumTransp = Tarif::totSumTransport(array('id_fiche'=>$contact->id_fiche, 'id_sejour'=>$contact->id_organisateur));
			// print_r('kkkkk'.$sumTransp->Mt);
			if(trim($contact->code_devise) == '' || trim($contact->code_devise) == 'EUR'){
				$mtTransp = $sumTransp->Mt;
			}else{
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $contact->code_devise ;
			
				$mtTransp = $sumTransp->Mt;
			
				$url = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$mtTransp";
				$response = file_get_contents($url);
				$data = json_decode($response, true);
			
				$mtTransp = (isset($data['result']) ? (float)$data['result'] : 0);
			}
			
			$arr['tot_transport'] = $mtTransp;	
			/* 
			mise a jour des 
				tot_real = mt_fin et 
				tot_ht = tot_ht 
			cote client (leur difference est dans l'ajout ou non de la taxe sejour 
			
			ET LE TRANSPORT N'EST AJOUTER QUE SI LE TARIF N"EST PAS MANUEL , DONC PAS DECIDE ARBITRAIREMENT
			*/
			if((int)$arr['is_tot_manu'] <= 0){
				$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
			}

			$arr['tot_real'] = $arr['tot_real'] + $mtTransp;

			$sum = Reglements::sumRglts(array('id_fiche'=>$contact->id_fiche, 'is_validate'=>'1'));
			
			if($sum->MT > 0){
				$arr['tot_restant'] = ($arr['tot_ht'] - $sum->MT) ;
				Reglements::updateRglts(array('mt_restant'=>$arr['tot_restant']),array('id_fiche'=>$contact->id_fiche));
			}

			$isvalidate = Reglements::getAllRglts(array('id_fiche'=>$contact->id_fiche, 'is_validate'=>'1', 'id_sejour'=>$usrActif->cursoc));
			
			if($isvalidate->num_rows > 0){
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "CLIENT CONFIRME" ', true,'');
				$arr['id_status_sec'] = $stsec->id_status_sec;
				
			}else{

			}

			if (Fiche::update($arr, array('id_fiche' => (int)$_POST['id_fiche']))) {

				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'MODIFICATION DOSSIER', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::arrayToStr($arr)));

				respAjax::successJSON(array('OK' => 'OK', 'totreal'=>$arr['tot_real'],'semaine'=>$semaine, 
											'idtheme'=>$arr['id_theme'], 'id_fiche'=>$_POST['id_fiche'], 
											'hrealized' => date('H:i', $sumHoursRealized), 'tot_transp'=>(Float)$mtTransp,
											'tothourform'=>substr($arr['tot_hour_formation'],0,strripos($arr['tot_hour_formation'], ":"))));
			}

				
			respAjax::errorJSON(array('message' => 'Erreur pendant la mise à jour'));
			break;

		case 'maj-tarifs-details':
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));

			$sumTarif = 0;
			$tot_restant = 0;
			$tarifNuit = false;
			$tarifSemaine = false;
			$tarifSejour = false;
			$arr= array();

			$ct = Fiche::findOne(array('c.id_fiche'=>$_POST['idct']));
			
			
			$date1 = new DateTime($ct->date_start);
			$date2 = new DateTime($ct->date_end);

			$jours = $date2->diff($date1)->days;
			// $jours += 1; //inclure le dernier jour
		
			$semaine = $jours / 7 ;

			// echo($jours.' -- '.$semaine);
			
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

			$alldetails = Fiche::getAllDetails(array('id_fiche'=>$_POST['idct']));
			foreach($alldetails as $details){
				$sumTarif += $details['tarif_details'];
				$sumTarif += $details['tarif_transport'];
				$sumTarif += $details['tarif_supp_detail'];
			}

			$alldetailsopts = Fiche::getAllDetailsOptions(array('id_fiche'=>$_POST['idct']));
			foreach($alldetailsopts as $detailsopts){
				$sumTarif += $detailsopts['tot_tarif_option'];
			}

			$infchs = Chambres::getAll(array('id_fiche'=>$ct->id_fiche));
			$addTot = 0;
			
			foreach($infchs as $ch){
				$prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
				if($prixch->tarif_chambre > 0){
					$addTot += $prixch->tarif_chambre;
				}
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

			// echo(print_r($ct));
			// tarif manuel
			if($ct->is_tot_manu > 0 || (int)$_POST['istotmanu'] > 0){
				$arr['is_tot_manu'] = '1';
				// pour tot reel
				$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $ct->taxe_sejour;
				*/

				// $totFinal = str_replace(array(' ',','),array(''),$ct->tot_ht);
				$totFinal = $ct->tot_manu;
				$totFinal += $ct->taxe_sejour;
				
			}else{
				// pour tot reel
				$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				/* pas la taxe sur le real qui est le tot_fin 
				$totFinalReal += $ct->taxe_sejour; //$_POST['taxe_sejour'];
				*/

				$totFinal = ($tot + $addTot)  * ((100 - $ct->offre_sejour) / 100);
				$totFinal += $ct->taxe_sejour;
				
			}

			$totFinalAcpt = $totFinal  * ((100 - $ct->accompte_25) / 100);

			if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
				$arr['tot_ht'] = $totFinal;
				$arr['tot_real'] = $totFinalReal;
				$arr['mt_ok_ht'] = $totFinalAcpt;
				
				// pour tot reel
				// $totFinalReal = (($totFinal + $addTot)  * (100 - $ct->offre_sejour)) / 100;
				// $totFinalReal += $ct->taxe_sejour;
			}else{
				$montant = $totFinal;
				$montantReal = $totFinalReal;
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $ct->code_devise;
				
				$url1 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montant";
				$response1 = file_get_contents($url1);
				$data1 = json_decode($response1, true);

				$arr['tot_ht'] = $montant * (isset($data1['result']) ? (float)$data1['result'] : 1);
				$arr['mt_ok_ht'] = ($montant * (isset($data1['result']) ? (float)$data1['result'] : 1))  * ((100 - $ct->accompte_25) / 100);

				$url2 = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$montantReal";
				$response2 = file_get_contents($url2);
				$data2 = json_decode($response2, true);
				
				$arr['tot_real'] = $montantReal * (isset($data2['result']) ? (float)$data2['result'] : 1);
								
				// $arr['mt_ok_ht'] = (($montant * (Float)str_replace(',','.',$devise[1]))  * (100 - $ct->accompte_25)) / 100;
			}

			// ##
			// Pour eviter les erreurs de calcul, on verifie s'il y a un montant des transports a ajouter au tot_real
			$mtTransp = 0;
			$sumTransp = Tarif::totSumTransport(array('id_fiche'=>$ct->id_fiche, 'id_sejour'=>$ct->id_organisateur));
			// print_r('kkkkk'.$sumTransp->Mt);
			if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
				$mtTransp = $sumTransp->Mt;
			}else{
				$devisefrom = 'EUR';//$_POST['devisefrom'];
				$deviseto = $ct->code_devise ;
			
				$mtTransp = $sumTransp->Mt;
			
				$url = "https://api.exchangerate.host/convert?from=$devisefrom&to=$deviseto&amount=$mtTransp";
				$response = file_get_contents($url);
				$data = json_decode($response, true);
			
				$mtTransp = (isset($data['result']) ? (float)$data['result'] : 0);
			}
			
			$arr['tot_transport'] = $mtTransp;	
			/* 
			mise a jour des 
				tot_real = mt_fin et 
				tot_ht = tot_ht 
			cote client (leur difference est dans l'ajout ou non de la taxe sejour 
			
			ET LE TRANSPORT N'EST AJOUTER QUE SI LE TARIF N"EST PAS MANUEL , DONC PAS DECIDE ARBITRAIREMENT
			*/
			if($ct->is_tot_manu <= 0 || (int)$_POST['istotmanu'] <= 0){
				$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
			}

			$arr['tot_real'] = $arr['tot_real'] + $mtTransp;

			$sum = Reglements::sumRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1'));
			
			if($sum->MT > 0){
				$arr['tot_restant'] = ($arr['tot_ht'] - $sum->MT) ;
				Reglements::updateRglts(array('mt_restant'=>$arr['tot_restant']),array('id_fiche'=>$ct->id_fiche));
			}

			$isvalidate = Reglements::getAllRglts(array('id_fiche'=>$ct->id_fiche, 'is_validate'=>'1', 'id_sejour'=>$usrActif->cursoc));
			
			if($isvalidate->num_rows > 0){
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "CLIENT CONFIRME" ', true,'');
				$arr['id_status_sec'] = $stsec->id_status_sec;
				
			}else{

			}
			$res = Fiche::update($arr, array('id_fiche'=>$ct->id_fiche));
					

			if($res){
				respAjax::successJSON(array('OK' => 'OK', 'totreal'=>$arr['tot_real'], 'tot'=>$arr['tot_ht'], 
											'sumt'=>(float)$sum->MT, 'majcircle'=>($isvalidate->num_rows > 0 ? 1 : 0 ), 
											'stsec'=>($isvalidate->num_rows > 0 ? $stsec->id_status_sec : 0 ), 
											'restant'=>(float)$arr['tot_restant'], 'totht'=>(float)$arr['tot_ht'], 
											'totrest'=>(float)$arr['mt_ok_ht'], 'tot_transp'=>(float)$mtTransp,
											'message' =>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour du tarif' : 'Rate updated')));
			}else{
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour du tarif sejour echouée' : 'Rate update failled')));
			}

			break;

		case 'age-tarif-details':
			
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if($_POST['dt'] != ''){
				$dtn = Tool::dmYtoYmd($_POST['dt']);

				$dj = date('Y-m-d');
				$diff = date_diff(date_create($dtn), date_create($dj));
				$age =  $diff->format('%y');
			}

			respAjax::successJSON(array('OK' => 'OK', 'age' =>$age));
			break;

		case 'modif-inf-gene':
			if (!Ctrl::ctrlflds($_POST, array('nameinf', 'valinf')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = InfosGenes::getAll();
			
			if($_POST['nameinf'] == 'is_auto_mail'){
				if($res->num_rows > 0){
					$res = InfosGenes::update(array('is_auto_mail'=>$_POST['valinf']),array('is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>'Mise a jour réussie'));
					}
				}else{
					$res = InfosGenes::create(array('is_auto_mail'=>$_POST['valinf'], 'is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout réussi' : 'Added')));
					}
				}
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Update failed')));

			}

			if($_POST['nameinf'] == 'is_decimal'){
				if($res->num_rows > 0){
					$res = InfosGenes::update(array('is_decimal'=>$_POST['valinf']),array('is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>'Mise a jour réussie'));
					}
				}else{
					$res = InfosGenes::create(array('is_decimal'=>$_POST['valinf'], 'is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout réussi' : 'Added')));
					}
				}
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Update failed')));

			}
			
			if($_POST['nameinf'] == 'is_list_opts'){
				if($res->num_rows > 0){
					$res = InfosGenes::update(array('is_list_opts'=>$_POST['valinf']),array('is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>'Mise a jour réussie'));
					}
				}else{
					$res = InfosGenes::create(array('is_list_opts'=>$_POST['valinf'], 'is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout réussi' : 'Added')));
					}
				}
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Update failed')));

			}

			if($_POST['nameinf'] == 'is_capacite_auto'){
				if($res->num_rows > 0){
					$res = InfosGenes::update(array('is_capacite_auto'=>$_POST['valinf']),array('is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>'Mise a jour réussie'));
					}
				}else{
					$res = InfosGenes::create(array('is_capacite_auto'=>$_POST['valinf'], 'is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout réussi' : 'Added')));
					}
				}
			}else{

				if($res->num_rows > 0){
					$res = InfosGenes::update(array('name_tarif'=>$_POST['nameinf'], 'val_tarif'=>$_POST['valinf']),array('is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>'Mise a jour réussie'));
					}
				}else{
					$res = InfosGenes::create(array('name_tarif'=>$_POST['nameinf'], 'val_tarif'=>$_POST['valinf'], 'is_inf_gene'=>'1'));
					if($res){
						respAjax::successJSON(array('OK' => 'OK', 'message' =>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout réussi' : 'Added')));
					}
				}
			}
			
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise a jour échouée' : 'Update failed')));

			break;

		case 'read-tarif-transport-details':
			if (!Ctrl::ctrlflds($_POST, array('idct','idtarif')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));

			$res = Tarif::findOneTransport(array('id_transport'=>(int)$_POST['idtarif']));
			respAjax::successJSON(array('OK' => 'OK', 'tarif' =>$res->tarif_transport));
			break;

		case 'read-tarif-details':
			if (!Ctrl::ctrlflds($_POST, array('idct','idtarif')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));

			$res = Tarif::findOne(array('id_tarif'=>(int)$_POST['idtarif']));
			respAjax::successJSON(array('OK' => 'OK', 'tarif' =>$res->age_tarif));
			break;

		case 'reverse-tel':
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));

			if(Fiche::update(array('tel1'=>$ct->tel2, 'tel2'=>$ct->tel1),array('id_fiche'=>$_POST['idct']))){
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,'type_action' => 'INVERSEMENT TEL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => 'inversement des tels'));	
				respAjax::successJSON(array('OK' => 'OK', 'tel1' => $ct->tel2, 'tel2'=>$ct->tel1));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data') : 'Missing data')));
			break;

		case 'print-cgv':
			if (!Ctrl::ctrlflds($_POST, array('idc')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idc']));
			if (!$ct || !Fiche::checkRight($ct))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vous ne pouvez pas effectuer cette opération' : 'Denied')));

			$doc = IsoPDFBuilder::BuildCGV((int)$_POST['idc'], false);
			

			$dirup = __DIR__ . '/uploads/';

	
			$dir = $dirup . $ct->codekey.$_POST['idc'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}
			
			$fic = substr($doc,strripos($doc,'/'));
			$fl = substr($fic,1,strpos($fic,'?') - 1);

			if ($iddoc = Doc::create(array('id_fiche' => (int)$_POST['idc'], 'date_doc' => date('Y-m-d H:i:s'), 'name_doc' => $fl, 'id_type_doc' => (int)$_POST['typedoc']))) {
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,'type_action' => 'AJOUT DOCUMENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $fl));						
			}	

			Fiche::update(array('lnk_cgv'=>'1'),array('id_fiche'=>$_POST['idc']));
			respAjax::successJSON(array('OK' => 'OK', 'doc' => $doc, 'id_doc' => $iddoc, 'cansign' => '1'));

			break;
	
		case 'print-all':
			
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$contact = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));

			$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);

			if(!Doc::findOne(array('name_doc'=>'DEVIS_SIGNED_'.(int)$_POST['idct'].'.pdf'))){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'En attente de la reception du devis signé' : 'Awaiting receipt of the signed quote')));
			}

			// if(!Doc::findOne(array('name_doc'=>'REGLEMENT_INTERIEUR_'.(int)$_POST['idct'].'.pdf'))){
			// 	respAjax::errorJSON(array('message' => 'En attente de reception signé des RI'));
			// }

			if(!Doc::findOne(array('name_doc'=>'CONTRAT_'.(int)$_POST['idct'].'_SIGNED_ARCHIVED.pdf'))){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'En attente de la reception du contrat signé' : 'Awaiting receipt of the signed contract')));
			}
			
			$files= array();
			$files[] = 'DEVIS_SIGNED_'.(int)$_POST['idct'].'.pdf';
			$files[] = 'CONTRAT_'.(int)$_POST['idct'].'_SIGNED_ARCHIVED.pdf';
			// $files[] = 'EMP_TIME_2022-08-18.pdf';
			// $files[] = 'CONTRAT_'.(int)$_POST['idct'].'.pdf';
			$filename = 'uploads/'.$contact->codekey.$contact->id_fiche.'/DOSSIER_COMPLET_'.$contact->id_fiche.'.pdf?time='.time();
			IsoPDFBuilder::PdfMerging($files, $dir.'/DOSSIER_COMPLET_'.$contact->id_fiche.'.pdf', 'Dashboard/uploads/'.$contact->codekey . $contact->id_fiche.'/');

			// die;
			$nm = substr($filename,strripos($filename, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));
			
			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$contact->id_fiche, 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp, 'id_type_doc' => (int)$_POST['typedoc']));
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'AJOUT DOCUMENT', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $nameDoc));			
				
			}else{
				$infdoc = Doc::findOne(array('id_fiche'=>$contact->id_fiche, 'name_doc'=>$nm,'id_type_doc' => (int)$_POST['typedoc']));
				$iddoc = $infdoc->id_doc;
			}

			if(Fiche::update(array('send_doc_all'=>'1'), array('id_fiche'=>(int)$_POST['idct']))){
				$updct = true;
			}else{
				$updct = false;
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'cansign' => '1', 'id_doc' => $iddoc,'updct'=>$updct,  'doc' => substr($filename, 0,strpos($filename,'?'))));

			break;

		case 'print-fact-libre':
			
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' => $_POST['idct']));
			if (!$ct || !Fiche::checkRight($ct))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));
	
			$arrct = array();
			if((int)$_POST['datefac'] <= 0 ){
				$arrct['date_fac'] = date('Y-m-d');
			}else{
				$arrct['date_fac'] = $_POST['datefac'];
			}
			
			if((int)$ct->nofac <= 0){
				$nofac = Fiche::getLastNoFac(array());
				$nofac += 1;
			}else{
				$nofac = $ct->nofac;
			}
			
			$arrct['numfac'] = 'F_'.date('Y').'_'.str_pad($nofac,5,0,STR_PAD_LEFT);
			$arrct['nofac'] = $nofac;
	
			$dirup = __DIR__ . '/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			$doc = IsoPDFBuilder::Buildfacture($ct, $nofac, '', $_POST['descfact'],$arrct['numfac'], $arrct['date_fac'],$_POST['lg'] , $_POST['tvafact'], $_POST['infbq'], false, 'F');
	
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));

			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'2', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));
	
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			
			if(Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche))){
				$attach = array();
				$attach[] = $dir . '/' . $nm;
				$subject = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture séjour' : 'Send the invoice for the stay');
				
				if($usrActif->lang == 'FR' || $usrActif->lang == ''){
					$msg = 'Bonjour '.($ct->civ_contact == 1 ? 'Mr' : ($ct->civ_contact == '2' ? 'Mme' : 'Mlle')).' '.$ct->last_name.' '.$ct->first_name.'
							<br>
							Veuillez trouvez ci-joint votre facture.
							<br>
							Cordialement,<br>
							';
					
				}else{
					$msg = 'Hi '.($ct->civ_contact == 1 ? 'Mr' : ($ct->civ_contact == '2' ? 'Mme' : 'Mlle')).' '.$ct->last_name.' '.$ct->first_name.'
							<br>
							Please find your invoice attached.
							<br>
							Sincerely,<br>
							';
				}
				

				$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
				if(!$resInfmail){
					respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send the invoice<br>No mailbox configured'),  'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
				}
				if(Mailings::sendMail('mail-contact', (object)array(
					'subject' => $subject,
					'email' => $ct->email,
					'first_name' => $ct->first_name,
					'last_name' => $ct->last_name,
					'msg' => $msg,
					'doc' => $attach
				))){				
					Fiche::update(array('lnk_facture'=>'1'),array('id_fiche'=>$ct->id_fiche));
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI FACTURE', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
				}else{
					respAjax::errorJSON(array('message'=>'Envoi email echoué'));
				}
				
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture effectué' : 'Billing sended'), 'doc' => $doc, 'cansign'=>'0', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}else{
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture échoué' : 'Failed to send invoice'),  'doc' => $doc, 'cansign'=>'0', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}

			break;

		case 'print-note-frais':
			// print_r($_POST['justif']);
			// die;
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' => $_POST['idct']));
			if (!$ct || !Fiche::checkRight($ct))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));
	
			$arrct = array();
			$files = array();
	
			$dirup = __DIR__ . '/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			require_once(__DIR__.'/libry/fpdf/fpdf.php');

			// echo('ic app frais..');
			// die;
			// Vérifier si un fichier a été envoyé
			if (isset($_FILES['justif']) && $_FILES['justif']['error'] == 0) {
				$upload_dir = $dir.'/'; 
				$file_name = basename($_FILES['justif']['name']);
				$upload_path = $upload_dir . str_replace(' ','_',$file_name);
				$pdf_path = $upload_dir . str_replace(' ','_',pathinfo($file_name, PATHINFO_FILENAME)) . '.pdf';
		
				if (move_uploaded_file($_FILES['justif']['tmp_name'], $upload_path)) {
					// $file_url = $upload_path;
					// Identifier le type et convertir si nécessaire
					$fileType = mime_content_type($upload_path);
					switch ($fileType) {
						case 'application/msword':
						case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
							$convertedPath =  pathinfo(convertToPdf($upload_path, $pdf_path), PATHINFO_BASENAME);
							break;
						case 'application/vnd.ms-excel':
						case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
							$convertedPath =  pathinfo(convertToPdf($upload_path, $pdf_path), PATHINFO_BASENAME);
							break;
						case 'text/plain':
							$convertedPath =  pathinfo(textToPdf($upload_path, $pdf_path), PATHINFO_BASENAME);
							break;
						case 'image/jpeg':
							case 'image/png':
							case 'image/gif':
								$convertedPath = imageToPdf($upload_path, str_replace(['.jpg', '.png', '.gif'], '.pdf', $upload_path));
								if (!file_exists($convertedPath) || mime_content_type($convertedPath) !== 'application/pdf') {
									throw new Exception("Le fichier PDF généré est invalide : " . $convertedPath);
								}
								$convertedPath = pathinfo($convertedPath, PATHINFO_BASENAME);
								// echo($convertedPath);
								break;
						default:
							$convertedPath = pathinfo($upload_path, PATHINFO_BASENAME); // Pas besoin de conversion
					}
				} else {
					// $file_url = 'Erreur lors de l\'upload';
					$convertedPath = '';
				}
			} else {
				// $file_url = 'Aucun fichier envoyé';
				$convertedPath = '';
			}

			$doc = IsoPDFBuilder::BuildNoteFrais($ct, '', $_POST['descfrais'],$_POST['lg'] , $_POST['catfrais'], $_POST['datefrais'], $_POST['mtfrais'], false, 'NF', $convertedPath);
	
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));

			// print_r($doc);

			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'2', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));
	
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			
			if(Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche))){
				$attach = array();
				$attach[] = $dir . '/' . $nm;
				$attach[] = $convertedPath;

				$subject = ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture séjour' : 'Send the invoice for the stay');
				
				if($usrActif->lang == 'FR' || $usrActif->lang == ''){
					$msg = 'Bonjour '.($ct->civ_contact == 1 ? 'Mr' : ($ct->civ_contact == '2' ? 'Mme' : 'Mlle')).' '.$ct->last_name.' '.$ct->first_name.'
							<br>
							Veuillez trouvez ci-joint votre facture.
							<br>
							Cordialement,<br>
							';
					
				}else{
					$msg = 'Hi '.($ct->civ_contact == 1 ? 'Mr' : ($ct->civ_contact == '2' ? 'Mme' : 'Mlle')).' '.$ct->last_name.' '.$ct->first_name.'
							<br>
							Please find your invoice attached.
							<br>
							Sincerely,<br>
							';
				}
				

				$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
				if(!$resInfmail){
					respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send the invoice<br>No mailbox configured'),  'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
				}
				if(Mailings::sendMail('mail-contact', (object)array(
					'subject' => $subject,
					'email' => $ct->email,
					'first_name' => $ct->first_name,
					'last_name' => $ct->last_name,
					'msg' => $msg,
					'doc' => $attach
				))){				
					Fiche::update(array('lnk_facture'=>'1'),array('id_fiche'=>$ct->id_fiche));
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI FACTURE', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
				}else{
					respAjax::errorJSON(array('message'=>'Envoi email echoué'));
				}
				
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture effectué' : 'Billing sended'), 'doc' => $doc, 'cansign'=>'0', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}else{
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture échoué' : 'Failed to send invoice'),  'doc' => $doc, 'cansign'=>'0', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}

			break;
		
		case 'print-facture':
			if (!Ctrl::ctrlflds($_POST, array('idct')))
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$typemail = ModelMail::findOne(array('type_mail'=>'3'));
			if(!$typemail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun modèle de message n\'existe pour les factures' : 'No message template exists for billing')));
			}

			$ct = Fiche::findOne(array('c.id_fiche' => $_POST['idct']));
			if (!$ct || !Fiche::checkRight($ct))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));
	
			$arrct = array();

			if((int)$_POST['datefac'] <= 0 ){
				$arrct['date_fac'] = date('Y-m-d');
			}
			
			if((int)$ct->nofac <= 0){
				$nofac = Fiche::getLastNoFac(array());
				$nofac += 1;
			}else{
				$nofac = $ct->nofac;
			}
			
			$arrct['numfac'] = 'F_'.date('Y').'_'.str_pad($nofac,5,0,STR_PAD_LEFT);
			$arrct['nofac'] = $nofac;
	
			$dirup = __DIR__ . '/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			$doc = IsoPDFBuilder::BuildDevis($ct, $nofac, '', false, 'F');
	
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));
			
	
			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'2', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));
	
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche));

			$attach = array();
			$attach[] = $dir . '/' . $nm;

			
			$msg = $typemail->msg;
			
			$result = ModelMail::replaceVars($ct->id_fiche, $typemail->id_mailtype);

			$res = $result['data'];
			$subject = $result['subject'];
			$msg = $result['msg'];

			if($_POST['app'] == 'lnkfac'){
				// $msg = 'Bonjour '.($ct->civ_contact == 1 ? 'Mr' : ($ct->civ_contact == '2' ? 'Mme' : 'Mlle')).' '.$ct->last_name.' '.$ct->first_name.'
				// 		<br>
				// 		Veuillez trouvez ci-joint votre facture.
				// 		<br>
				// 		Cordialement,<br>
				// 		l\'équipe DEMO SOC';

				$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
				if(!$resInfmail){
					respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send the invoice<br>No mailbox configured'),  'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
				}
				if(Mailings::sendMail('mail-contact', (object)array(
					'subject' => $subject,
					'email' => $ct->email,
					'first_name' => $ct->first_name,
					'last_name' => $ct->last_name,
					'msg' => $msg,
					'doc' => $attach
				))){				
					Fiche::update(array('lnk_facture'=>'1'),array('id_fiche'=>$ct->id_fiche));
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI FACTURE', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
				}else{
					respAjax::errorJSON(array('message'=>'Envoi email echoué'));
				}
				
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture effectué' : 'Billing sended'), 'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}else{
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi de la facture échoué' : 'Failed to send invoice'),  'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}
			
			break;

		case 'read-notif':
			if (!Ctrl::ctrlflds($_POST, array('idnotif')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$notif = Notif::findOne(array('id_notif' => (int)$_POST['idnotif']));
			if (!$notif)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Notification inexistante' : 'Notification not found')));

			if ($notif->id_usrApp_notif == '0' && $arrAccess['isAdmin'] != '1')
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));
			else
			if ($notif->id_usrApp_notif > 0 && $usrActif->id_usrApp != $notif->id_usrApp_notif && $arrAccess['isAdmin'] != '1' )
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Action non autorisée' : 'Denied')));

			$idread = Notif::createRead(array('id_usrApp' => $usrActif->id_usrApp, 'id_notif' => $notif->id_notif));
			if (!$idread)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Notification non supprimée' : 'Notification not deleted')));

			Notif::update(array('isread' => 1),array('id_notif' => $notif->id_notif));

			respAjax::successJSON(array('OK' => 'OK'));
			break;		

		case 'save-inf-sejour':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idmandsejour', 'infsejour')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune description enregistrée' : 'No description recorded')));	

			Setting::updateOrganisateur(array('desc_sejour'=>$_POST['infsejour']),(array('id_organisateur'=>(int)$_POST['idmandsejour'])));

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'mise a jour effectuée' : 'Updated')));
			break;

		case 'show-inf-sejour':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idmandsejour')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sejour non identifié' : 'Unidentified stay')));	

			$res = Setting::getOrganisateur(array('id_organisateur'=>$_POST['idmandsejour']));

			respAjax::successJSON(array('OK' => 'OK', 'infsejour'=>$res->desc_sejour));
			break;

		case 'show-inf-sejour-eng':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idmandsejoureng')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sejour non identifié' : 'Unidentified stay')));	

			$res = Setting::getOrganisateur(array('id_organisateur'=>$_POST['idmandsejoureng']));

			respAjax::successJSON(array('OK' => 'OK', 'infsejour'=>$res->desc_sejour_eng));
			break;

	
		case 'save-inf-sejour-eng':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idmandsejoureng', 'infsejoureng')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune description enregistrée' : 'No description recorded')));	

			Setting::updateOrganisateur(array('desc_sejour_eng'=>$_POST['infsejoureng']),(array('id_organisateur'=>(int)$_POST['idmandsejoureng'])));

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mise à jour effectuée' : 'Updated')));
			break;

		case 'send-lnk-inscription':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('email')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)\n\rMail obligatoire' : 'Missing data\n\rEmail required')));

			function validateEmail($email) {
				if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
					return true;
				}
				else {
					return false;
				}
			}
			if(!validateEmail($_POST['email'])){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Email incorrect' : 'Incorrect email')));
			}

			if($_POST['type'] == 'I' || $_POST['type'] == 'A'){
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "DEMANDE DE DEVIS" ', true,'');
				$typemail = ModelMail::findOne(array('type_mail'=>'5')); //5 == inscription; 6 == contrat
			}else{
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "ENVOI DEVIS FINAL" ', true,'');
				$typemail = ModelMail::findOne(array('type_mail'=>'6')); //5 == inscription; 6 == contrat
			}

			if(!$typemail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun modèle de message n\'existe pour les devis' : 'No message template exists for estimate')));
			}

			if($_POST['type'] == 'C'){
				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['id_fiche']));
			}

			if($_POST['type'] == 'A'){
				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
			}
				

			// echo(print_r($ct));
			// die;
			$result = ModelMail::replaceVarsInscript($_POST['email'], $typemail->id_mailtype, $_POST['url'], $usrActif, ($_POST['type'] == 'C' || $_POST['type'] == 'A' ? $ct : ''), ($_POST['type'] == 'C' || $_POST['type'] == 'A' ? $ct->lg : $_POST['lg']), $_POST['isSign']);

			$res = $result['data'];
			$subject = $result['subject'];
			$msg = $result['msg'];

			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::successJSON(array('OK' => 'OK', 'message'=>'Lien vers signature manuelle non transmis<br>Aucune boite d\'envoi configurée',  'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}

			if(Mailings::sendMail('mail-contact', (object)array(
				'subject' => $subject, // ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers signature manuelle du devis' : 'Link to the manual signature of quote'),
				'email' => $_POST['email'],
				'msg' => $msg
			))){				
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI LIEN '.($_POST['type'] == 'C' ? 'CONTRAT' : 'INSCRIPTION'), 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
			}else{
				respAjax::errorJSON(array('message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi email '.($_POST['type'] == 'C' ? 'contrat' : 'inscription').' echoué' : 'Email '.($_POST['type'] == 'C' ? 'contract' : 'registration').' not sended')));
			}

			Fiche::update(array('id_status_sec'=>$stsec->id_status_sec),array('id_fiche'=>(int)($_POST['type'] == 'C' ? $_POST['id_fiche'] : $_POST['idct'])));
			
			respAjax::successJSON(array('OK' => 'OK', 'idstsec'=>$stsec->id_status_sec, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers '.($_POST['type'] == 'C' ? 'contrat' : 'inscription').' transmis' : 'Link to the '.($_POST['type'] == 'C' ? 'contract' : 'registration').' sended')));
		
			break;

		case 'send-lnk-inscription-grid':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('email')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)\n\rMail obligatoire' : 'Missing data\n\rEmail required')));

			function validateEmail($email) {
				if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
					return true;
				}
				else {
					return false;
				}
			}
			if(!validateEmail($_POST['email'])){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Email incorrect' : 'Incorrect email')));
			}

			if($_POST['type'] == 'I' || $_POST['type'] == 'A'){
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "DEMANDE DE DEVIS" ', true,'');
				$typemail = ModelMail::findOne(array('type_mail'=>'5')); //5 == inscription; 6 == contrat
			}else{
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "ENVOI DEVIS FINAL" ', true,'');
				$typemail = ModelMail::findOne(array('type_mail'=>'6')); //5 == inscription; 6 == contrat
			}

			if(!$typemail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun modèle de message n\'existe pour les devis' : 'No message template exists for estimate')));
			}

			if($_POST['type'] == 'C'){
				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['id_fiche']));
			}

			if($_POST['type'] == 'A'){
				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
			}
				

			// echo(print_r($ct));
			// die;
			$result = ModelMail::replaceVarsInscript($_POST['email'], $typemail->id_mailtype, $_POST['url'], $usrActif, ($_POST['type'] == 'C' || $_POST['type'] == 'A' ? $ct : ''), ($_POST['type'] == 'C' || $_POST['type'] == 'A' ? $ct->lg : $_POST['lg']), $_POST['isSign']);

			$res = $result['data'];
			$subject = $result['subject'];
			$msg = $result['msg'];

			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::successJSON(array('OK' => 'OK', 'message'=>'Lien vers signature manuelle non transmis<br>Aucune boite d\'envoi configurée',  'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}

			if(Mailings::sendMail('mail-contact', (object)array(
				'subject' => $subject, // ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers signature manuelle du devis' : 'Link to the manual signature of quote'),
				'email' => $_POST['email'],
				'msg' => $msg
			))){				
				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI LIEN '.($_POST['type'] == 'C' ? 'CONTRAT' : 'INSCRIPTION'), 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
			}else{
				respAjax::errorJSON(array('message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi email '.($_POST['type'] == 'C' ? 'contrat' : 'inscription').' echoué' : 'Email '.($_POST['type'] == 'C' ? 'contract' : 'registration').' not sended')));
			}

			Fiche::update(array('id_status_sec'=>$stsec->id_status_sec),array('id_fiche'=>(int)($_POST['type'] == 'C' ? $_POST['id_fiche'] : $_POST['idct'])));
			
			respAjax::successJSON(array('OK' => 'OK', 'idstsec'=>$stsec->id_status_sec, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers '.($_POST['type'] == 'C' ? 'contrat' : 'inscription').' transmis' : 'Link to the '.($_POST['type'] == 'C' ? 'contract' : 'registration').' sended')));
		
			break;

		case 'print-inscription':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'type')))
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			// creation du document
			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct']));
			if (!$ct)
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Impression du formaulaire d\'inscription impossible\n\rClient introuvable' : 'Unable to print registration form\n\rCustomer not found')));

			$arrct = array();

			$dirup = __DIR__ . '/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			$sign = '';
			if (file_exists(__DIR__.'/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png')) {
				$sign = 'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';
			}

			$doc = IsoPDFBuilder::BuildInscriptContrat($ct, '', $sign, false, $_POST['type'], $_POST['periode'], $ct->lg);
			
			// echo('**'.$doc);
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));
			// echo($doc);
			// die;


			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'9', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));

			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));

				$iddoc = $nameDoc->id_doc;
			}

			Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche));

			respAjax::successJSON(array('OK' => 'OK', 'idct'=>$ct->id_fiche , 'doc'=>'/Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/'.$nm, 'codekey'=>$contact->codekey, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléchargement effectuée' : 'Downloaded')));

			
			break;

		case 'print-devis':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				
			$typemail = ModelMail::findOne(array('type_mail'=>'2'));
			if(!$typemail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun modèle de message n\'existe pour les devis' : 'No message template exists for estimate')));
			}

			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct']));
			if (!$ct)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client introuvable' : 'Customer not found')));

			$arrct = array();

			$arrct['date_devis'] = date('Y-m-d');

			if((int)$ct->nodevis <= 0){
				$nodevis = Fiche::getLastNoDevis(array());
				$nodevis += 1;
			}else{
				$nodevis = $ct->nodevis;
			}
			
			$arrct['numdevis'] = 'D_'.date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT);
			$arrct['nodevis'] = $nodevis;

			
			$dirup = __DIR__ . '/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			$doc = IsoPDFBuilder::BuildDevis($ct, $nodevis, '', false);

			// echo('**'.$doc);
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));

			
	
			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'1', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));
	
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche));

			$result = ModelMail::replaceVars($ct->id_fiche, $typemail->id_mailtype, $_POST['url']);

			$res = $result['data'];
			$subject = $result['subject'];
			$msg = $result['msg'];

			if($_POST['app'] == 'lnkdevis'){
				// $msg = 'Bonjour '.($ct->civ_contact == 1 ? 'Monsieur' : 'Madame').' '.$ct->last_name.' '.$ct->first_name.'
				// 		<br>
				// 		<br>
				// 		Suite à votre demande, vous trouverez sous ce lien le devis pour le séjour DEMO SOC Pessah 2023. Veuillez le signer pour poursuivre votre réservation : 
				// 		<a href="https://demo.azurocrm.com/devis.php?CLID='.$ct->codekey.$ct->id_fiche.'">Devis DEMO SOC 2023</a>
				// 		<br>
				// 		<br>
				// 		Bien à vous,<br>
				// 		L\'équipe DEMO SOC
				// 		<br>
				// 		<img src="https://demo.azurocrm.com/Dashboard/img/signatureMH.png" style="heigth:150px">';

				$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
				if(!$resInfmail){
					respAjax::successJSON(array('OK' => 'OK', 'message'=>'Lien vers signature manuelle non transmis<br>Aucune boite d\'envoi configurée',  'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
				}

				if(Mailings::sendMail('mail-contact', (object)array(
					'subject' => $subject, // ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers signature manuelle du devis' : 'Link to the manual signature of quote'),
					'email' => $ct->email,
					'first_name' => $ct->first_name,
					'last_name' => $ct->last_name,
					'msg' => $msg
				))){				
					Fiche::update(array('lnk_devis'=>'1'),array('id_fiche'=>$ct->id_fiche));
					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI LIEN DEVIS', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
				}else{
					respAjax::errorJSON(array('message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi email echoue' : 'Email not sended')));
				}
				
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers signature manuelle transmis' : 'Link to the manual signature sended'), 'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}else{
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien vers signature manuelle, échoué' : 'Link to the manual signature failed'), 'doc' => $doc, 'cansign'=>'1', 'iddoc'=>$iddoc, 'namedoc'=>$nm));
			}
			
			break;
	
		case 'print-contrat':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'type')))
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			// creation du document
			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct']));
			if (!$ct)
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Impression du contrat impossible\n\rClient introuvable' : 'Unable to print contract\n\rCustomer not found')));

			$arrct = array();

			$dirup = __DIR__ . '/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			$sign = '';
			// on imprime la signature depuis ce menu que si le contrat a ete signe en ligne
			$signContratExist = Doc::findOne(array('name_doc'=>'CONTRAT_SIGNED_'.$ct->id_fiche.'.pdf'));
			if($signContratExist){
				if (file_exists(__DIR__.'/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png')) {
					$sign = 'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';
				}
			}

			$doc = IsoPDFBuilder::BuildInscriptContrat($ct, '', $sign, false, $_POST['type'], $_POST['periode'], $ct->lg);
			
			// echo('**'.$doc);
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));
			// echo($doc);
			// die;


			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'4', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));

			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));

				$iddoc = $nameDoc->id_doc;
			}

			Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche));

			respAjax::successJSON(array('OK' => 'OK', 'idct'=>$ct->id_fiche , 'doc'=>'/Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/'.$nm, 'codekey'=>$contact->codekey, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléchargement effectuée' : 'Downloaded')));

			
			break;

		case 'send-rib':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'app', 'idbq')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
	
			$typemail = ModelMail::findOne(array('type_mail'=>'4'));
			if(!$typemail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucun modèle de message n\'existe pour les devis' : 'No message template exists for estimate')));
			}
	
			$contact = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));

			$attach = array();
			$res = InfosGenes::findOneBq(array('id_inf_banque'=>(int)$_POST['idbq']));
			
			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi du RIB impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send the bank details<br>No mailbox configured')));
			}

			
			$result = ModelMail::replaceVars($contact->id_fiche, $typemail->id_mailtype);

			$res = $result['data'];
			$subject = $result['subject'];
			$msg = $result['msg'];

			// $msg = "'Bonjour,<br>
			// Veuillez trouver ci-joint notre RIB pour procéder au paiment du séjour<br>
			// Code Banque : '.$res->inf_code_bq.'<br>
			// Code Guichet : '.$res->inf_guichet.'<br>
			// N° Compte : '.$res->inf_num_compte.'<br>
			// Clé : '.$res->inf_cle.'<br>
			// IBAN : '.$res->inf_iban.'<br>
			// BIC : '.$res->inf_bic.'<br><br>
			// Cordialement', "

			if (Mailings::sendMail('mail-contact', (object)array(
				'email' => $contact->email,
				'first_name' => $contact->first_name, 
				'last_name' => $contact->last_name,
				'subject' => $subject, //'RIB pour paiement sejour',
				'msg' => $msg,
				'doc' => $attach))) {
					respAjax::successJSON(array('OK' => 'OK', 'doc' => $doc, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'RIB envoyé avec succes' : 'Bank details sended')));
				}else{
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de l\'envoi du RIB' : 'Error while sending bank details')));
				}
			break;	

			
		case 'add-obj':
			if (!Ctrl::ctrlflds($_POST, array('type')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			
			$delelmt = TablesObjs::sqlSimple('posL = 0 AND posT = 0', true);
			// print_r($delelmt);
			if($delelmt->num_div > 0){
				TablesObjs::delete(array('id_table_obj'=>$delelmt->id_table_obj));
			}

			$res = TablesObjs::create(array('posL'=>'4', 'posT'=>'8','id_sejour'=>$usrActif->cursoc, 'type_obj'=>$_POST['type']));

			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la création de la table' : 'Error while creation of table')));
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'delelmt'=>$delelmt->id_table_obj,'id'=>$res));
			break;

			
		case 'update-drag-obj':

			if (!Ctrl::ctrlflds($_POST, array('idobj', 'posL', 'posT')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = TablesObjs::update(array('posL'=>(float)$_POST['posL'], 'posT'=>(float)$_POST['posT']),array('id_sejour'=>$usrActif->cursoc, 'id_table_obj'=>$_POST['idobj']));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la création de l\'objet' : 'Error while creation of object')));
			}
			respAjax::successJSON(array('OK' => 'OK', 'posL'=>(float)$_POST['posL'], 'posT'=>(float)$_POST['posT']));
			break;

		case 'keep-infos':
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur sur la récupération automatique des dates<br>Merci de les saisir manuellement' : 'Error on automatic date retrieval<br>Please enter them manually')));

			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
			if($ct){
				// $deb = explode('-',$ct->date_start);
				// $end = explode('-',$ct->date_end);
				// respAjax::successJSON(array('OK' => 'OK', 'datedeb'=>$deb[2].'/'.$deb[1].'/'.$deb[0], 'dateend'=>$end[2].'/'.$end[1].'/'.$end[0]));
				respAjax::successJSON(array('OK' => 'OK', 'datedeb'=>$ct->date_start, 'dateend'=>$ct->date_end));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune dates trouvées<br>Merci de les saisir manuellement' : 'No dates found<br>Please enter them manually')));
			break;

		case 'get-inf-table':
			if (!Ctrl::ctrlflds($_POST, array('iddiv')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$data = TablesPlans::findOne(array('num_div'=>(int)$_POST['iddiv']));
				$dtdeb = date('d/m/Y', strtotime($data->date_start));
				$dtend =  date('d/m/Y', strtotime($data->date_end));

				respAjax::successJSON(array('OK' => 'OK', 'data'=>$data, 'date_start'=>$dtdeb, 'date_end'=>$dtend));
			break;

		case 'del-table':
			if (!Ctrl::ctrlflds($_POST, array('iddiv')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				TablesPlans::delete(array('num_div'=>(int)$_POST['iddiv']));

				respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'del-obj':
			if (!Ctrl::ctrlflds($_POST, array('iddiv')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				TablesObjs::delete(array('id_table_obj'=>(int)$_POST['iddiv']));

				respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'add-table':
			
			$val = TablesPlans::maxNumDiv(array('id_sejour'=>$usrActif->cursoc));
			
			$delelmt = TablesPlans::sqlSimple('name_table = 0 OR (posL = 0 AND posT = 0)', true);
			// print_r($delelmt);
			if($delelmt->num_div > 0){
				TablesPlans::delete(array('id_table_plan'=>$delelmt->id_table_plan));
			}

			$res = TablesPlans::create(array('id_sejour'=>$usrActif->cursoc, 'num_div'=>($val + 1)));

			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la création de la table' : 'Error while creation of table')));
			}
			$clts = Fiche::getAll(array('id_organisateur'=>$usrActif->cursoc));
			$html = '<select class="form-control nametb" id="nametb'.($val + 1).'" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
						<option value="0"></option>';
			foreach($clts as $clt){
				$html .= '<option value="'.$clt['id_fiche'].'">'.$clt['last_name'].' '.$clt['first_name'].'</option>';
			}
			$html .= '</select>';
			respAjax::successJSON(array('OK' => 'OK', 'delelmt'=>$delelmt->num_div,'id'=>($val + 1), 'html'=>$html));
			break;

		case 'update-drag-table':

			if (!Ctrl::ctrlflds($_POST, array('iddiv', 'posL', 'posT')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = TablesPlans::update(array('posL'=>(float)$_POST['posL'], 'posT'=>(float)$_POST['posT']),array('id_sejour'=>$usrActif->cursoc, 'num_div'=>$_POST['iddiv']));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la création de la table' : 'Error while creation of table')));
			}
			respAjax::successJSON(array('OK' => 'OK', 'posL'=>(float)$_POST['posL'], 'posT'=>(float)$_POST['posT']));
			break;

		case 'update-table':
// print_r($_POST);
// die;
			if (!Ctrl::ctrlflds($_POST, array('iddiv', 'posL', 'posT', 'nametb', 'datedeb', 'dateend')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = TablesPlans::update(array('num_table'=>$_POST['numtb'], 'name_table'=>(int)$_POST['nametb'], 'date_start'=>$_POST['datedeb'], 'date_end'=>$_POST['dateend'], 'nb_adulte'=>(int)$_POST['nbadulte'], 'nb_enfant'=>(int)$_POST['nbenf'], 'nb_bb'=>(int)$_POST['nbbb'], 'note'=>$_POST['note'],'posL'=>(float)$_POST['posL'], 'posT'=>(float)$_POST['posT'], 'id_fiche'=>(int)$_POST['nametb'], 'etage'=>$_POST['etage'], 'capacite'=>$_POST['capacite']),array('id_sejour'=>$usrActif->cursoc, 'num_div'=>$_POST['iddiv']));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la modification de la table' : 'Error while update of table')));
			}
			respAjax::successJSON(array('OK' => 'OK', 'posL'=>(float)$_POST['posL'], 'posT'=>(float)$_POST['posT'], 'numtb'=>$_POST['numtb'], 'nametb'=>(int)$_POST['nametb'], 'datedeb'=>$_POST['datedeb'], 'dateend'=>$_POST['dateend'], 'nbadulte'=>$_POST['nbadulte'], 'nbenf'=>$_POST['nbenf'], 'nbbb'=>$_POST['nbbb'], 'note'=>$_POST['note'], 'idfiche'=>(int)$_POST['nametb'], 'capacite'=>$_POST['capacite'] ));
			break;

		case 'update-modal':

			if (!Ctrl::ctrlflds($_POST, array('iddiv', 'name_table', 'date_start', 'date_end')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$clt = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['name_table']));

			$res = TablesPlans::update(array('num_table'=>$_POST['num_table'], 'name_table'=>(int)$_POST['name_table'], 'date_start'=>Tool::dmYtoYmd($_POST['date_start']), 'date_end'=>Tool::dmYtoYmd($_POST['date_end']), 'nb_adulte'=>(int)$_POST['nb_adulte'], 'nb_enfant'=>(int)$_POST['nb_enfant'], 'nb_bb'=>(int)$_POST['nb_bb'], 'note'=>$_POST['note'], 'id_fiche'=>(int)$_POST['name_table'],'etage'=>$_POST['etage'], 'capacite'=>$_POST['capacite']),array('id_sejour'=>$usrActif->cursoc, 'num_div'=>$_POST['iddiv']));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la création de la table' : 'Error while update of table')));
			}
			respAjax::successJSON(array('OK' => 'OK', 'numtb'=>$_POST['num_table'], 'name_table'=>(int)$_POST['name_table'], 'date_start'=>Tool::dmYtoYmd($_POST['date_start']), 'date_end'=>Tool::dmYtoYmd($_POST['date_end']), 'nb_adulte'=>$_POST['nb_adulte'], 'nb_enfant'=>$_POST['nb_enfant'], 'nb_bb'=>$_POST['nb_bb'], 'note'=>$_POST['note'], 'idfiche'=>(int)$_POST['name_table'], 'iddiv'=>(int)$_POST['iddiv'], 'etage'=>$_POST['etage'], 'capacite'=>$_POST['capacite'], 'name'=>$clt->last_name.' '.$clt->first_name ));
			break;

		case 'display-table':
			$arrT = [];
			
			$delelmts = TablesPlans::sqlSimple('name_table = "" OR (posL = 0 AND posT = 0)', false);
			foreach($delelmts as $delelmt){
				TablesPlans::delete(array('id_table_plan'=>$delelmt['id_table_plan']));
			}
			
			

			$res = TablesPlans::getAll(array('tp.id_sejour'=>$usrActif->cursoc));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la création de la table' : 'Error while creation of table')));
			}

			$clts = Fiche::getAll(array('id_organisateur'=>$usrActif->cursoc));
			foreach($res as $data){
				foreach($clts as $clt){
					if($data['name_table'] == $clt['id_fiche']){
						$data['name_table'] = $clt['last_name'].' '.$clt['first_name'];
						$data['id_fiche'] = $clt['id_fiche'];
					}
				}
				$arrT[] = $data;
			}

			respAjax::successJSON(array('OK' => 'OK', 'data'=>$arrT));
			break;

		case 'display-obj':
			$arrObj = [];
			
			$delelmts = TablesObjs::sqlSimple('posL = 0 AND posT = 0', false);
			foreach($delelmts as $delelmt){
				TablesObjs::delete(array('id_table_obj'=>$delelmt['id_table_obj']));
			}
			
			

			$res = TablesObjs::getAll(array('id_sejour'=>$usrActif->cursoc));
			if(!$res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur lors de la création de l\'objet' : 'Error while creation of object')));
			}

			foreach($res as $data){
				$arrObj[] = $data;
			}

			respAjax::successJSON(array('OK' => 'OK', 'data'=>$arrObj));
			break;

		case 'read-table':
			$maxNumTable = Tables::MaxNumTable(array('id_sejour'=>$usrActif->cursoc));
			//    echo($maxNumTable);
			if($maxNumTable > 0){
				$resTb = Tables::getAll(array('id_sejour'=>$usrActif->cursoc), false, 'num_table');
				$arrTb = [];
				foreach ($resTb as $key) {
					// echo('**'.print_r($key));
					
					$arrTb[] = array('numT'=>$key['num_table'], 'n1'=>$key['name_table'], 'nb1'=>$key['nb_table'], 'ch1'=>$key['num_chambre'],
									'n2'=>$key['name_table_2'], 'nb2'=>$key['nb_table_2'], 'ch2'=>$key['num_chambre_2'],
									'n3'=>$key['name_table_3'], 'nb3'=>$key['nb_table_3'], 'ch3'=>$key['num_chambre_3'],
								);
				}
			}
			respAjax::successJSON(array('OK' => 'OK', 'lgn'=>$resTb->num_rows, 'data'=>json_encode($arrTb)));

			break;

		case 'bloc-table':
			if (!Ctrl::ctrlflds($_POST, array('idtable')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if(trim($_POST['name1']) == '' && trim($_POST['name2']) == '' && trim($_POST['name3']) == ''){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom obligatoire' : 'Name required')));
			}

			$tb = Tables::findOne(array('num_table'=>(int)$_POST['idtable']));
			if($tb){
				$res = Tables::update(array('name_table'=>$_POST['name1'],'name_table_2'=>$_POST['name2'], 'name_table_3'=>$_POST['name3'],
										'nb_table'=>$_POST['nb1'], 'nb_table_2'=>$_POST['nb2'], 'nb_table_3'=>$_POST['nb3'],
										'num_chambre'=>$_POST['ch1'], 'num_chambre_2'=>$_POST['ch2'], 'num_chambre_3'=>$_POST['ch3']),
										array('num_table'=>(int)$_POST['idtable'], 'id_sejour'=>$usrActif->cursoc));
			}

			$res = Tables::create(array('name_table'=>$_POST['name1'],'name_table_2'=>$_POST['name2'], 'name_table_3'=>$_POST['name3'],
										'nb_table'=>$_POST['nb1'], 'nb_table_2'=>$_POST['nb2'], 'nb_table_3'=>$_POST['nb3'],
										'num_chambre'=>$_POST['ch1'], 'num_chambre_2'=>$_POST['ch2'], 'num_chambre_3'=>$_POST['ch3'],
										'num_table'=>(int)$_POST['idtable'], 'id_sejour'=>$usrActif->cursoc));

			if($res){
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Réservation éffectuée' : 'Reserved')));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Réservation échuouée' : 'Reservation failed')));
			break;

		case 'free-table':
			if (!Ctrl::ctrlflds($_POST, array('idtable')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = Tables::delete(array('num_table'=>(int)$_POST['idtable']));
			
			if($res){
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression éffectuée' : 'Deleted')));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression échuouée' : 'Deletion failed')));
			break;

		case 'mod-table':
			if (!Ctrl::ctrlflds($_POST, array('idtable')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if(trim($_POST['name1']) == '' && trim($_POST['name2']) == '' && trim($_POST['name3']) == ''){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom obligatoire' : 'Name required')));
			}

			$tb = Tables::findOne(array('num_table'=>(int)$_POST['idtable']));
			if($tb){
				$res = Tables::update(array('name_table'=>$_POST['name1'],'name_table_2'=>$_POST['name2'], 'name_table_3'=>$_POST['name3'],
										'nb_table'=>$_POST['nb1'], 'nb_table_2'=>$_POST['nb2'], 'nb_table_3'=>$_POST['nb3'],
										'num_chambre'=>$_POST['ch1'], 'num_chambre_2'=>$_POST['ch2'], 'num_chambre_3'=>$_POST['ch3']),
										array('num_table'=>(int)$_POST['idtable'], 'id_sejour'=>$usrActif->cursoc));
			}

			if($res){
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modification éffectuée' : 'Updated')));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modification échuouée' : 'Modification failed')));
			break;

		case 'print-table':
			$dirup = __DIR__.'/uploads';
			$dir = $dirup . '/docs';
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}
			$doc = IsoPDFBuilder::BuildTables($usrActif->cursoc, false);
			// echo$doc;
			// die;
			
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));

			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>'0', 'id_type_doc'=>'0', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));

			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tables éditée' : 'Table printed'), 'doc' => $doc, 'iddoc'=>$iddoc, 'namedoc'=>$nm));

			break;

		case 'print-plan-table':
			$dirup = __DIR__.'/uploads';
			$dir = $dirup . '/docs';
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}
			$doc = IsoPDFBuilder::BuildPlanTables($usrActif->cursoc, false);
			// echo$doc;
			// die;
			
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));

			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>'0', 'id_type_doc'=>'0', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));

			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tables éditée' : 'Table printed'), 'doc' => $doc, 'iddoc'=>$iddoc, 'namedoc'=>$nm));

			break;

		case 'list-rib':
			$allBqs = InfosGenes::getAllBq();
			$htmlbtn = '';
			$cpt = 0;
			// echo(print_r($allBqs));
			// die;
			foreach($allBqs as $bq){
				$cpt++;	
				$htmlbtn .= '<div class="col-md-3">	
								<a href="#"  target="" style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;" class="form-control btn btn-sm btn-info btrib'.$cpt.'" data-id="'.$bq['id_inf_banque'].'" id="btrib'.$cpt.'">RIB '.$bq['inf_nom_rib'].'</a> 
							</div>';
			}

			respAjax::successJSON(array('OK' => 'OK', 'html'=>$htmlbtn));
			break;

		case 'send-reponse-mail':
			// print_r($_POST);
			
			if (!Ctrl::ctrlflds($_POST, array('email', 'subject', 'msg')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			
			$body = stripcslashes($_POST['msg']);
			$subject = stripcslashes($_POST['subject']); 
			
			$attach = array();

			$dir = __DIR__ . '/uploads/box/';
			
			if (!is_dir($dir)) {
				mkdir($dir);
				copy(__DIR__ . '/uploads/index.php', $dir . '/index.php');
			}
			
			if (isset($_FILES['fileadd'])) {
				
				$total = count($_FILES['fileadd']['name']);
				$file = array();
				for( $i=0 ; $i < $total ; $i++ ) {
					$file = array('error' => UPLOAD_ERR_OK, 'name' => $_FILES['fileadd']['name'][$i], 'tmp_name' => $_FILES['fileadd']['tmp_name'][$i]);
					if ($fl = Tool::uploadFile($dir.'/', $file))
						$attach[] = $dir.'/'.$fl;

					move_uploaded_file(
						// Temp image location
						$image_file["tmp_name"],
		
						// New image location, __DIR__ is the location of the current PHP file
						__DIR__ . "/uploads/box/" . $fl
					);
					
				}
			}
			// else {
			// 	if ((int)$_POST['attachclr'] != 1 && isset($_POST['id_mailtype']) && (int)$_POST['id_mailtype'] > 0) {
			// 		$mt = ModelMailfindOne(array('id_mailtype' => (int)$_POST['id_mailtype']));
			// 		if ($mt && $mt->attach != '') {
			// 			$ats = json_decode($mt->attach);
			// 			foreach($ats as $at)
			// 				$attach[] = $dirup . 'mailtypes/'.$at;
			// 		}
			// 	}
			// }
		
			// if (isset($_POST['chkdoc']) && is_array($_POST['chkdoc']) && count($_POST['chkdoc']) > 0) {
			// 	foreach ($_POST['chkdoc'] as $doc) {
			// 		$dc = Doc::findOne(array('id_doc' => (int)$doc));
			// 		if ($dc)
			// 			$attach[] = $dir . '/' . $dc->name_doc;
			// 	}
			// }

		
			// $replyto = $contact->user_name != '' ? $contact->user_name.' <'.$contact->email.'>' : $usrActif->user_name.' <'.$usrActif->email.'>';
			// $from = $contact->user_name != '' ? $contact->user_name : $usrActif->user_name;

			$ctrlemail = explode(';', $_POST['email']);

			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi vers contact impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send<br>No mailbox configured')));
			}

			if(count($ctrlemail) > 1){
				foreach($ctrlemail as $mail){
					
					if (Mailings::sendMail('mail-contact', (object)array(
						'email' => $mail,
						'first_name' => $contact->first_name, 
						'last_name' => $contact->last_name,
						'subject' => $_POST['subject'],
						'msg' => $_POST['msg'], 
						'doc' => $attach))) {
	
						CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($_POST['msg'])));
						
						
						Imap::create(array('from_mail'=>$resInfmail->inf_username, //'david.cassuto770@gmail.com', 
											'to_mail'=>$_POST['email'], 
											'subject_mail'=>$_POST['subject'], 
											'msg_mail'=>$_POST['msg'], 
											'is_send_mail'=>'1', 
											'date_mail'=>date('Y-m-d'),
											'id_fiche'=>$_POST['idc'], 
											'date_create'=>date('Y-m-d'))
						);
						respAjax::successJSON(array('OK' => 'OK'));
					}
				}
			}
			else {
				if (Mailings::sendMail('mail-contact', (object)array(
					'email' => $_POST['email'],
					'first_name' => $contact->first_name, 
					'last_name' => $contact->last_name,
					'subject' => $_POST['subject'],
					'msg' => $_POST['msg'], 
					'doc' => $attach))) {

					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($_POST['msg'])));
				
						
					Imap::create(array('from_mail'=>'david.cassuto770@gmail.com', 
										'to_mail'=>$_POST['email'], 
										'subject_mail'=>$_POST['subject'], 
										'msg_mail'=>$_POST['msg'], 
										'is_send_mail'=>'1', 
										'date_mail'=>date('Y-m-d'),
										'id_fiche'=>$_POST['idc'], 
										'date_create'=>date('Y-m-d'))
					);
					respAjax::successJSON(array('OK' => 'OK'));
				}
			}


			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Problème à l\'envoi du mail' : 'Problem when sending email')));
			break;

		case 'ctrl-type':
			if (!Ctrl::ctrlflds($_POST, array('type')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$res = ModelMail::findOne(array('type_mail'=>(int)$_POST['type']));
			if($res){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Un modéle existe déjà pour ce type' : 'A model already exists for this type')));
			}

			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'send-mail-fiche-ct':
			//print_r($_POST);
			//die;
			
			if (!Ctrl::ctrlflds($_POST, array('idc', 'email', 'subject', 'msg', 'mailtypedest')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
				
			$contact = Fiche::findOne(array('id_fiche'=>(int)$_POST['idc']));

			$dirup = __DIR__ . '/uploads/';
			$dir = $dirup.$contact->codekey . $contact->id_fiche;
			
			$body = stripcslashes($_POST['msg']);
			$subject = stripcslashes($_POST['subject']); 
			
			$attach = array();
			
			if (isset($_FILES['fileadd'])) {
				if (!is_dir($dir)) {
					mkdir($dir);
					copy($dirup . 'index.php', $dir . '/index.php');
				}
				
				$total = count($_FILES['fileadd']['name']);
				$file = array();
				for( $i=0 ; $i < $total ; $i++ ) {
					$file = array('error' => UPLOAD_ERR_OK, 'name' => $_FILES['fileadd']['name'][$i], 'tmp_name' => $_FILES['fileadd']['tmp_name'][$i]);
					if ($fl = Tool::uploadFile($dir.'/', $file))
						$attach[] = $dir.'/'.$fl;
				}

			}
			else {
				if ((int)$_POST['attachclr'] != 1 && isset($_POST['id_mailtype']) && (int)$_POST['id_mailtype'] > 0) {
					$mt = ModelMail::findOne(array('id_mailtype' => (int)$_POST['id_mailtype']));
					if ($mt && $mt->attach != '') {
						$ats = json_decode($mt->attach);
						foreach($ats as $at)
						$attach[] = $dirup . 'mailtypes/'.$at;
				}
			}
			}
		
			if (isset($_POST['chkdoc']) && is_array($_POST['chkdoc']) && count($_POST['chkdoc']) > 0) {
				foreach ($_POST['chkdoc'] as $doc) {
					$dc = Doc::findOne(array('id_doc' => (int)$doc));
					if ($dc)
					$attach[] = $dir . '/' . $dc->name_doc;
			}
			}
			
			$replyto = $contact->user_name != '' ? $contact->user_name.' <'.$contact->email.'>' : $usrActif->user_name.' <'.$usrActif->email.'>';
			$from = $contact->user_name != '' ? $contact->user_name : $usrActif->user_name;
			
			$ctrlemail = explode(';', $_POST['email']);
			
			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi vers contact impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send<br>No mailbox configured')));
			}
			
		// 	print_r($attach);
		// die;
			
			
			if(count($ctrlemail) > 1){
				foreach($ctrlemail as $mail){
					
					if (Mailings::sendMail('mail-contact', (object)array(
						'email' => $mail,
						'first_name' => $contact->first_name, 
						'last_name' => $contact->last_name,
						'subject' => $_POST['subject'],
						'msg' => $_POST['msg'], 
						'doc' => $attach))) {
	
						CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($_POST['msg'])));
						
						
						Imap::create(array('from_mail'=>$resInfmail->inf_username, //'david.cassuto770@gmail.com', 
											'to_mail'=>$_POST['email'], 
											'subject_mail'=>$_POST['subject'], 
											'msg_mail'=>$_POST['msg'], 
											'is_send_mail'=>'1', 
											'date_mail'=>date('Y-m-d'),
											'id_fiche'=>$_POST['idc'], 
											'date_create'=>date('Y-m-d'))
						);
						respAjax::successJSON(array('OK' => 'OK'));
					}
				}
			}
			else {
				if (Mailings::sendMail('mail-contact', (object)array(
					'email' => $_POST['email'],
					'first_name' => $contact->first_name, 
					'last_name' => $contact->last_name,
					'subject' => $_POST['subject'],
					'msg' => $_POST['msg'], 
					'doc' => $attach))) {

					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($_POST['msg'])));
				
						
					Imap::create(array('from_mail'=>'david.cassuto770@gmail.com', 
										'to_mail'=>$_POST['email'], 
										'subject_mail'=>$_POST['subject'], 
										'msg_mail'=>$_POST['msg'], 
										'is_send_mail'=>'1', 
										'date_mail'=>date('Y-m-d'),
										'id_fiche'=>$_POST['idc'], 
										'date_create'=>date('Y-m-d'))
					);
					respAjax::successJSON(array('OK' => 'OK'));
				}
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Problème à l\'envoi du mail' : 'Problem when sending email')));
			break;
	
		case 'send-mail-multiple':
			if (!Ctrl::ctrlflds($_POST, array('email', 'subject', 'msg')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				
			$dirup = __DIR__ . '/uploads/';
			
			$body = stripcslashes($_POST['msg']);
			$subject = stripcslashes($_POST['subject']); 
			
			$attach = array();
			
			if (isset($_FILES['fileadd'])) {
				if (!is_dir($dir)) {
					mkdir($dir);
					copy($dirup . 'index.php', $dir . '/index.php');
				}
				
				$total = count($_FILES['fileadd']['name']);
				$file = array();
				for( $i=0 ; $i < $total ; $i++ ) {
					$file = array('error' => UPLOAD_ERR_OK, 'name' => $_FILES['fileadd']['name'][$i], 'tmp_name' => $_FILES['fileadd']['tmp_name'][$i]);
					if ($fl = Tool::uploadFile($dir.'/', $file))
						$attach[] = $dir.'/'.$fl;
				}
			}
			else {
				if ((int)$_POST['attachclr'] != 1 && isset($_POST['id_mailtype']) && (int)$_POST['id_mailtype'] > 0) {
					$mt = ModelMail::findOne(array('id_mailtype' => (int)$_POST['id_mailtype']));
					if ($mt && $mt->attach != '') {
						$ats = json_decode($mt->attach);
						foreach($ats as $at)
							$attach[] = $dirup . 'mailtypes/'.$at;
					}
				}
			}
		
			if (isset($_POST['chkdoc']) && is_array($_POST['chkdoc']) && count($_POST['chkdoc']) > 0) {
				foreach ($_POST['chkdoc'] as $doc) {
					$dc = Doc::findOne(array('id_doc' => (int)$doc));
					if ($dc)
						$attach[] = $dir . '/' . $dc->name_doc;
				}
			}

			$supcomamail = substr_replace($_POST['email'],"",strripos($_POST['email'],";"));
			
			$ctrlemail = explode(';', $supcomamail);
			
			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi vers contact impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send<br>No mailbox configured')));
			}

			
			if(count($ctrlemail) > 0){
				if (Mailings::sendMail('mail-groupe', (object)array(
					'email' => $ctrlemail,
					'subject' => $_POST['subject'],
					'msg' => $_POST['msg'], 
					'doc' => $attach))) {

					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($_POST['msg'])));
					respAjax::successJSON(array('OK' => 'OK'));
				}
			}
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Problème à l\'envoi du mail' : 'Problem when sending email')));
			break;
	
	
		case 'send-mail-libre':
			
			if (!Ctrl::ctrlflds($_POST, array('dest')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$msgCt = stripcslashes($_POST['msg']);
			$subject = stripcslashes($_POST['subject']);

			if (Mailings::sendMail('mail-contact', (object)array(
				'email' => $_POST['dest'],
				'subject' => $subject,
				'msg' => $msgCt, 
				'doc' => $attach))) {

				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($_POST['msg'])));
				respAjax::successJSON(array('OK' => 'OK'));
			}
			
			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Problème à l\'envoi du mail' : 'Problem when sending email')));
			break;


		case 'count-repas':
			/* PIE */
			$addWh2 = '';
			$arrLab2 = [];
			$arrAn2 = [];

			$ageBb = Tarif::getBb();
			$ageEnfant = Tarif::getEnfant();
			$ageAdulte = Tarif::getAdulte();

			if(isset($_POST['calstart']) && $_POST['calstart'] != '' && isset($_POST['calend']) && $_POST['calend'] != ''){
				if(strtotime(Tool::dmYtoYmd($_POST['calstart'])) > strtotime(Tool::dmYtoYmd($_POST['calend']))){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'La date de fin est inferieure à la date de début' : 'The end date is less than the start date')));
				}
				// $addWh2 = " AND (c.date_start >= '".Tool::dmYtoYmd($_POST['calstart'])."' AND c.date_end  <= '".Tool::dmYtoYmd($_POST['calend'])."') ";
				$addWh2 = " AND ((c.date_start BETWEEN '".Tool::dmYtoYmd($_POST['calstart'])."' AND '".Tool::dmYtoYmd($_POST['calend'])."') OR (c.date_end BETWEEN '".Tool::dmYtoYmd($_POST['calstart'])."' AND '".Tool::dmYtoYmd($_POST['calend'])."'))";
			}

			if(isset($_POST['sejour']) && (int)$_POST['sejour'] > 0){
				$addWh2 .= " AND c.id_organisateur = ".$_POST['sejour'] ;
			}

			
			$sqlBB = "SELECT COUNT(d.age) as 'BB', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
					FROM db_contacts_details d 
					INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
					INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE d.age <= ".$ageBb->age_bb.$addWh2." GROUP BY 'BB' ORDER BY c.date_start ";
			
			$sqlEnfant = "SELECT COUNT(d.age) as 'Enfant', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
					FROM db_contacts_details d 
					INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
					INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE (d.age >= ".($ageBb->age_bb + 1)." AND d.age <= ".$ageEnfant->age_enfant.") ".$addWh2." GROUP BY 'Enfant' ORDER BY c.date_start ";
			
			$sqlAdulte = "SELECT COUNT(d.age) as 'Adulte', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
					FROM db_contacts_details d 
					INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
					INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE d.age >= ".$ageAdulte->age_adulte.$addWh2." GROUP BY 'Adulte' ORDER BY c.date_start ";

					// echo$sqlBB.'<br>'.$sqlEnfant.'<br>'.$sqlAdulte;
					// die;
			$resBB = QueryExec::querySQL($sqlBB, true);
			$resEnfant = QueryExec::querySQL($sqlEnfant, true);
			$resAdulte = QueryExec::querySQL($sqlAdulte, true);

			$arrRepas[] = array('name'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'BB' : 'Baby'), 'y'=>(int)$resBB->BB);
			$arrRepas[] = array('name'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enfant' : 'Child'), 'y'=>(int)$resEnfant->Enfant);
			$arrRepas[] = array('name'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adulte' : 'Adult'), 'y'=>(int)$resAdulte->Adulte);
			
			$date1 = new DateTime(Tool::dmYtoYmd($_POST['calstart'])); 
			$date2 = new DateTime(Tool::dmYtoYmd($_POST['calend'])); 
			$diff = $date2->diff($date1)->format('%a');
			if((int)$diff == 0){
				$sejour = ($resBB->sejour != '' ? $resBB->sejour :($resEnfant->sejour != '' ? $resEnfant->sejour : $resAdulte->sejour));
				$html = '<style>
							tr td {border:solid;text-align:center}
							tr th {text-align:center; background-color:beige}
						</style>
						<a href="#" class="btn btn-primary" style="margin-bottom:10px" id="btimprepas" '.($arrAccess["print_repas"] == 1 ? '' : 'disabled="disabled"').'><i class="fa fa-print"></i></a>
						<table style="width:100%;">
							<tr>
								<th>BB</th>
								<th>Enfant</th>
								<th>Adulte</th>
								<th>Date</th>
								<th>Sejour</th>
							</tr>
							<tr>
								<td>'.$resBB->BB.'</td>
								<td>'.$resEnfant->Enfant.'</td>
								<td>'.$resAdulte->Adulte.'</td>
								<td>'.date('d/m/Y',strtotime(Tool::dmYtoYmd($_POST['calstart']))).'</td>
								<td>'.$sejour.'</td>
							</tr>
						</table>
						';
			}else{
				// Pour inclure tous les jours dans la boucle (du 4 au 6 == 2 donc requete sur le 4 5 et 6 soit 3fois)
				$diff += 1;
				
				$html = '<style>
							tr td {border:solid;text-align:center}
							tr th {text-align:center; background-color:beige}
						</style>
						<a href="#" class="btn btn-primary" style="margin-bottom:10px" id="btimprepas" '.($arrAccess["print_repas"] == 1 ? '' : 'disabled="disabled"').'><i class="fa fa-print"></i></a>
						<table style="width:100%;">
							<tr>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'BB' : 'Baby').'</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enfant' : 'Child').'</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adulte' : 'Adult').'</th>
								<th>Date</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay').'</th>
							</tr>';
				$date1 = Tool::dmYtoYmd($_POST['calstart']); 
				for ($i=0; $i < $diff; $i++) { 
					$j = 0;
					// $date2 = Tool::dmYtoYmd($_POST['calend']); 

					$addWh3 = " AND ((c.date_start BETWEEN '".$date1."' AND '".$date1."') OR (c.date_end BETWEEN '".$date1."' AND '".$date1."'))";
					
					if(isset($_POST['sejour']) && (int)$_POST['sejour'] > 0){
						$addWh3 .= " AND c.id_organisateur = ".$_POST['sejour'];
					}
					// $addWh3 = " AND ('".$date1."' BETWEEN c.date_start AND c.date_end )";

					$sqlBB = "SELECT COUNT(d.age) as 'BB', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
							FROM db_contacts_details d 
							INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
							INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
							WHERE d.age <= ".$ageBb->age_bb.$addWh3." GROUP BY 'BB' ORDER BY c.date_start ";
					
					$sqlEnfant = "SELECT COUNT(d.age) as 'Enfant', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
							FROM db_contacts_details d 
							INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
							INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
							WHERE (d.age >= ".($ageBb->age_bb + 1)." AND d.age <= ".$ageEnfant->age_enfant.") ".$addWh3." GROUP BY 'Enfant' ORDER BY c.date_start ";
					
					$sqlAdulte = "SELECT COUNT(d.age) as 'Adulte', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
							FROM db_contacts_details d 
							INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
							INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
							WHERE d.age >= ".$ageAdulte->age_adulte.$addWh3." GROUP BY 'Adulte' ORDER BY c.date_start ";

							// echo$sqlBB.'<br>'.$sqlEnfant.'<br>'.$sqlAdulte;
							// die;
					$resBB = QueryExec::querySQL($sqlBB, true);
					$resEnfant = QueryExec::querySQL($sqlEnfant, true);
					$resAdulte = QueryExec::querySQL($sqlAdulte, true);

					if($resBB->BB > 0 || $resEnfant->Enfant > 0 || $resAdulte->Adulte > 0){
						$sejour = ($resBB->sejour != '' ? $resBB->sejour :($resEnfant->sejour != '' ? $resEnfant->sejour : $resAdulte->sejour));

						$html .= '<tr>
									<td>'.$resBB->BB.'</td>
									<td>'.$resEnfant->Enfant.'</td>
									<td>'.$resAdulte->Adulte.'</td>
									<td>'.date('d/m/Y',strtotime($date1)).'</td>
									<td>'.$sejour.'</td>
								</tr>';
					}
					$j++;
					$date1 = date('Y-m-d', strtotime($date1. ' + '.$j.' days'));
				}

				$html .= '</table>';
			}

			/* PIE */

			respAjax::successJSON(array('OK' => 'OK','html'=>$html, 'repas'=>json_encode($arrRepas)));
			
			break;

		case 'stats-init':

			/* PIE */
			$addWh2 = '';
			$arrLab2 = [];
			$arrAn2 = [];

			$ageBb = Tarif::getBb();
			$ageEnfant = Tarif::getEnfant();
			$ageAdulte = Tarif::getAdulte();

			if(isset($_POST['calstart']) && $_POST['calstart'] != '' && isset($_POST['calend']) && $_POST['calend'] != ''){
				if(strtotime(Tool::dmYtoYmd($_POST['calstart'])) <= strtotime(Tool::dmYtoYmd($_POST['calend']))){
					$addWh2 = " AND (c.date_start >= '".Tool::dmYtoYmd($_POST['calstart'])."' AND c.date_end  <= '".Tool::dmYtoYmd($_POST['calend'])."') ";
					// $addWh2 = " AND ((c.date_start BETWEEN '".Tool::dmYtoYmd($_POST['calstart'])."' AND '".Tool::dmYtoYmd($_POST['calend'])."') OR (c.date_end BETWEEN '".Tool::dmYtoYmd($_POST['calstart'])."' AND '".Tool::dmYtoYmd($_POST['calend'])."'))";
				}
			}

			if(isset($_POST['sejour']) && (int)$_POST['sejour'] > 0){
				$addWh2 .= " AND c.id_organisateur = ".$_POST['sejour'] ;
			}

			
			$sqlBB = "SELECT COUNT(d.age) as 'BB', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
					FROM db_contacts_details d 
					INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
					INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE d.age <= ".$ageBb->age_bb.$addWh2." GROUP BY 'BB' ORDER BY c.date_start ";
			
			$sqlEnfant = "SELECT COUNT(d.age) as 'Enfant', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
					FROM db_contacts_details d 
					INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
					INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE (d.age >= ".($ageBb->age_bb + 1)." AND d.age <= ".$ageEnfant->age_enfant.") ".$addWh2." GROUP BY 'Enfant' ORDER BY c.date_start ";
			
			$sqlAdulte = "SELECT COUNT(d.age) as 'Adulte', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
					FROM db_contacts_details d 
					INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
					INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE d.age >= ".$ageAdulte->age_adulte.$addWh2." GROUP BY 'Adulte' ORDER BY c.date_start ";

					// echo$sqlBB.'<br>'.$sqlEnfant.'<br>'.$sqlAdulte;
					// die;
			$resBB = QueryExec::querySQL($sqlBB, true);
			$resEnfant = QueryExec::querySQL($sqlEnfant, true);
			$resAdulte = QueryExec::querySQL($sqlAdulte, true);

			$arrRepas[] = array('name'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'BB' : 'Baby'), 'y'=>(int)$resBB->BB);
			$arrRepas[] = array('name'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enfant' : 'Child'), 'y'=>(int)$resEnfant->Enfant);
			$arrRepas[] = array('name'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adulte' : 'Adult'), 'y'=>(int)$resAdulte->Adulte);

			$date1 = new DateTime(Tool::dmYtoYmd($_POST['calstart'])); 
			$date2 = new DateTime(Tool::dmYtoYmd($_POST['calend'])); 
			$diff = $date2->diff($date1)->format('%a');
			if((int)$diff == 0){
				$sejour = ($resBB->sejour != '' ? $resBB->sejour :($resEnfant->sejour != '' ? $resEnfant->sejour : $resAdulte->sejour));

				$html = '<style>
							tr td {border:solid;text-align:center}
							tr th {text-align:center; background-color:beige}
						</style>
						<a href="#" class="btn btn-primary" style="margin-bottom:10px" id="btimprepas" '.($arrAccess["print_repas"] == 1 ? '' : 'disabled="disabled"').'><i class="fa fa-print"></i></a>
						<table style="width:100%;">
							<tr>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'BB' : 'Baby').'</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enfant' : 'Child').'</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adulte' : 'Adult').'</th>
								<th>Date</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay').'</th>
							</tr>
							<tr>
								<td>'.$resBB->BB.'</td>
								<td>'.$resEnfant->Enfant.'</td>
								<td>'.$resAdulte->Adulte.'</td>
								<td>'.date('d/m/Y',strtotime(Tool::dmYtoYmd($_POST['calstart']))).'</td>
								<td>'.$sejour.'</td>
							</tr>
						</table>
						';
			}else{
				// Pour inclure tous les jours dans la boucle (du 4 au 6 == 2 donc requete sur le 4 5 et 6 soit 3fois)
				$diff += 1;
				
				$html = '<style>
							tr td {border:solid;text-align:center}
							tr th {text-align:center; background-color:beige}
						</style>
						<a href="#" class="btn btn-primary" style="margin-bottom:10px" id="btimprepas" '.($arrAccess["print_repas"] == 1 ? '' : 'disabled="disabled"').'><i class="fa fa-print"></i></a>
						<table style="width:100%;">
							<tr>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'BB' : 'Baby').'</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enfant' : 'Child').'</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adulte' : 'Adult').'</th>
								<th>Date</th>
								<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay').'</th>
							</tr>';
				$date1 = Tool::dmYtoYmd($_POST['calstart']); 
				for ($i=0; $i < $diff; $i++) { 
					$j = 0;
					// $date2 = Tool::dmYtoYmd($_POST['calend']); 

					$addWh3 = " AND ((c.date_start BETWEEN '".$date1."' AND '".$date1."') OR (c.date_end BETWEEN '".$date1."' AND '".$date1."'))";

					if(isset($_POST['sejour']) && (int)$_POST['sejour'] > 0){
						$addWh3 .= " AND c.id_organisateur = ".$_POST['sejour'];
					}
					// $addWh3 = " AND ('".$date1."' BETWEEN c.date_start AND c.date_end )";

					$sqlBB = "SELECT COUNT(d.age) as 'BB', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
							FROM db_contacts_details d 
							INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
							INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
							WHERE d.age <= ".$ageBb->age_bb.$addWh3." GROUP BY 'BB' ORDER BY c.date_start ";
					
					$sqlEnfant = "SELECT COUNT(d.age) as 'Enfant', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
							FROM db_contacts_details d 
							INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
							INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
							WHERE (d.age >= ".($ageBb->age_bb + 1)." AND d.age <= ".$ageEnfant->age_enfant.") ".$addWh3." GROUP BY 'Enfant' ORDER BY c.date_start ";
					
					$sqlAdulte = "SELECT COUNT(d.age) as 'Adulte', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
							FROM db_contacts_details d 
							INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
							INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
							WHERE d.age >= ".$ageAdulte->age_adulte.$addWh3." GROUP BY 'Adulte' ORDER BY c.date_start ";

							// echo$sqlBB.'<br>'.$sqlEnfant.'<br>'.$sqlAdulte;
							// die;
					$resBB = QueryExec::querySQL($sqlBB, true);
					$resEnfant = QueryExec::querySQL($sqlEnfant, true);
					$resAdulte = QueryExec::querySQL($sqlAdulte, true);

					if($resBB->BB > 0 || $resEnfant->Enfant > 0 || $resAdulte->Adulte > 0){
						$sejour = ($resBB->sejour != '' ? $resBB->sejour :($resEnfant->sejour != '' ? $resEnfant->sejour : $resAdulte->sejour));

						$html .= '<tr>
									<td>'.$resBB->BB.'</td>
									<td>'.$resEnfant->Enfant.'</td>
									<td>'.$resAdulte->Adulte.'</td>
									<td>'.date('d/m/Y',strtotime($date1)).'</td>
									<td>'.$sejour.'</td>
								</tr>';
					}
					$j++;
					$date1 = date('Y-m-d', strtotime($date1. ' + '.$j.' days'));
				}

				$html .= '</table>';
			}


					
			/* PIE */
			// print_r($_POST);
			$addWh = '';
			$arrLab = [];
			$arrAn = [];
			if($_POST['dt'] != ''){
				$addWh = " AND YEAR(r.date_rglt) = '".$_POST['dt']."'";
			}
			if(isset($_POST['sejour']) && (int)$_POST['sejour'] > 0){
				$addWh .= " AND c.id_organisateur = ".$_POST['sejour'];
			}

			$sql = "SELECT sum(r.mt_rglt) as mt, c.id_organisateur as id_sejour, o.name_organisateur as sejour, YEAR(r.date_rglt) as annee FROM `db_reglements` r 
					INNER JOIN db_contacts c ON c.id_fiche = r.id_fiche 
					INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE r.is_validate = 1 ".$addWh." GROUP BY YEAR(r.date_rglt), c.id_organisateur  ORDER BY annee, id_sejour ";

					// echo$sql;
					// die;
			$res = QueryExec::querySQL($sql);

			
			$arrData = [];

			foreach($res as $data){
				$arrData[] = array(
					'label'=>$data['sejour'].'-('.$data['annee'].')',
					'data'=>$data['mt'],
					'color'=>array('#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#ffbf00', '#ffff00', '#bfff00', '#80ff00'),
				);
				
				$cat[] = array('name'=>$data['sejour'].'-('.$data['annee'].')');
				$dts[] = array((float)$data['mt']);
				// $serie[] = array('name'=>'London','data'=> [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3,51.2]);
				
				// $serie[] = array('name'=>$data['sejour'].'-('.$data['annee'].')', 'data'=>array('0'=>$data['mt']));
				// $serie ='{"name":"'.$data['sejour'].'-('.$data['annee'].')","data":['.$data['mt'].']}';
			}

			$serie[] = array('name'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Chiffre d\'affaire annuel".' '.$_POST['dt'] : "Annual sales".' '.$_POST['dt']), 'data'=>$dts);

			/* -------------- ANNULATION ------------- */
			$sqlAnnule = "SELECT COUNT(c.lnk_annule) as annulation, o.name_organisateur as sejour, YEAR(c.date_create) as annee FROM db_contacts c
					LEFT OUTER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
					WHERE c.lnk_annule = 1 ".($_POST['dt'] != '' ? " AND YEAR(c.date_create) = '".$_POST['dt']."'" : "")." GROUP BY YEAR(c.date_create), c.id_organisateur ORDER BY annee, sejour ";

					// echo$sql;
					// die;
			$resAnnule = QueryExec::querySQL($sqlAnnule);

			$arrDataAnnule = [];

			foreach($resAnnule as $data){
				$arrDataAnnule[] = array(
					'label'=>$data['sejour'].'-('.$data['annee'].')',
					'data'=>$data['annulation'],
					'color'=>array('#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#ffbf00', '#ffff00', '#bfff00', '#80ff00'),
				);
			}

			/* -------------- FREQUENCE ------------- */
			$sqlFreq = "SELECT COUNT(email) as freq, CONCAT(c.last_name,' ',c.first_name) as ident, o.name_organisateur as sejour FROM db_contacts c
						LEFT OUTER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
						WHERE c.lnk_annule = 0            
						GROUP BY c.id_organisateur ORDER BY sejour;";

					// echo$sql;
					// die;
			$resFreq = QueryExec::querySQL($sqlFreq);

			$arrDataFreq = [];

			foreach($resFreq as $data){
				$arrDataFreq[] = array(
					'label'=>$data['ident'],
					'data'=>$data['freq'],
					'color'=>array('#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#ffbf00', '#ffff00', '#bfff00', '#80ff00'),
				);
			}

			// Chart data for ajax request
			
			// $dataCh = array(
			// 	'labels' => $arrLab,
			// 	'datasets' => array(array(
			// 		'label' => "Chart.JS", 
			// 		'fill' => false, 
			// 		'backgroundColor' => array('#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#ffbf00', '#ffff00', '#bfff00', '#80ff00'), 
			// 		'borderColor' => 'black', 
			// 		'data' => $arrAn,

			// 	)),
			// );
			
			
			respAjax::successJSON(array('OK' => 'OK','html'=>$html, 'repas'=>json_encode($arrRepas), 'data'=>$arrData, 'cat'=>json_encode($cat), 'serie'=>json_encode($serie), 'dataAnnule'=>$arrDataAnnule, 'dataFreq'=>$arrDataFreq));
			break;

		case 'print-room-list':
			
			if (count($_POST['rowid']) <= 0	)
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			
			$dirup = __DIR__ . '/uploads/';
			$files= array();

			if($_POST['app'] == '' || !isset($_POST['app'])){
				foreach($_POST['rowid'] as $idct){
					
					$ct = Fiche::findOne(array('c.id_fiche'=>(int)$idct, 'c.lnk_annule'=>'0'));
						
					$dir = $dirup . $ct->codekey.$idct;
					if (!is_dir($dir)) {
						mkdir($dir);
						copy($dirup . 'index.php', $dir . '/index.php');
					}

					$doc = IsoPDFBuilder::BuildRoomList($ct, $_POST['type'], false);
					
				}
			}else{
				$dirAll = $dirup . 'docs';
				if (!is_dir($dirAll)) {
					mkdir($dirAll);
					copy($dirup . 'index.php', $dirAll . '/index.php');
				}
				$doc = IsoPDFBuilder::BuildRoomList('', $_POST['type'], false, $_POST['rowid'], $_POST['app']);
				
			}
			
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));
	
			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'8', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));
	
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Room List éditée' : 'Room list printed'), 'doc' => $doc, 'iddoc'=>$iddoc, 'namedoc'=>$nm));

			break;

		case 'print-room-cleaning':
			// print_r($_POST);
			// die;
			if (!Ctrl::ctrlflds($_POST, array('dm1', 'dm2')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			/* 
			 **** version auto avec edition pour le lendemain ****

			$dtj = date('Y-m-d'); //'2023-08-01';
			$tmj = time('H:m:i');

			if($tmj <= '00:00:01'){
				$dtj = date('Y-m-d',strtotime($dtj. ' + 1 days'));
			}

			$dtnext = date('Y-m-d',strtotime($dtj. ' + 1 days'));

			$allChs = Chambres::getAllCh();
			$arrChColor = [];

			$regular = Cleaning::findOne(array('libelle_nettoyage'=>'regular'));
			$complet = Cleaning::findOne(array('libelle_nettoyage'=>'complet'));
			$waitclean = Cleaning::findOne(array('libelle_nettoyage'=>'waitclean'));

			foreach($allChs as $ch){
				// echo('J '.$ch['num_chambre'].' LEFT(rdv_end,10) ='.$dtj.'<br>');
				$verifChJ = Planning::findOne(array('num_chambre'=>$ch['num_chambre'],'LEFT(rdv_end,10)'=>$dtj));
				$verifChNext = Planning::findOne(array('num_chambre'=>$ch['num_chambre'],'LEFT(rdv_end,10)'=>$dtnext));
				// echo('J+1 '.$ch['num_chambre'].' LEFT(rdv_end,10) ='.$dtnext.'<br>');
				// echo('RJ '.print_r($verifChJ).'<br>');
				// echo('RJ+1 '.print_r($verifChNext).'<br>');

				if($verifChJ){
					if($verifChNext){
						if($verifChJ->id_fiche == $verifChNext->id_fiche){
							$arrChColor[] = array($ch['num_chambre'], $regular->color);
						}else{
							$arrChColor[] = array($ch['num_chambre'], $complet->color);
						}
					}else{
						$arrChColor[] = array($ch['num_chambre'], $waitclean->color);
					}
				}
			}

			// print_r($arrChColor);
			// die;

			$dirup = __DIR__ . '/uploads/';
			$files= array();

			$dirAll = $dirup . 'docs';
			if (!is_dir($dirAll)) {
				mkdir($dirAll);
				copy($dirup . 'index.php', $dirAll . '/index.php');
			}
			$doc = IsoPDFBuilder::BuildRoomClean($arrChColor, $usrActif->cursoc);
			// echo($doc);
			// die;
			
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));
	
			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'10', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));
	
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}

			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Room List éditée' : 'Room list printed'), 'doc' => $doc, 'iddoc'=>$iddoc, 'namedoc'=>$nm));

			*/
			$arrCkDt = explode('/',$_POST['dm1']);
			if(!checkdate($arrCkDt[1],$arrCkDt[0],$arrCkDt[2])){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de début invalide' : 'Start date not valid')));
			}

			
			$arrCkDt = explode('/',$_POST['dm2']);
			if(!checkdate($arrCkDt[1],$arrCkDt[0],$arrCkDt[2])){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de fin invalide' : 'End date not valid')));
			}
			
			
			$dtj = Tool::dmYtoYmd($_POST['dm1']);
			$tmj = time('H:m:i');
			$dtj2 = Tool::dmYtoYmd($_POST['dm2']);
			$tmj2 = time('H:m:i');
			
			$dtAdd = $dtj;
			// echo('avant while <br>'.strtotime(Tool::dmYtoYmd($dtAdd)).' <= '.strtotime(Tool::dmYtoYmd($dtj2)));

			$allChs = Chambres::getAllCh(array('id_sejour'=>$usrActif->cursoc));
			if($allChs->num_rows <= 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune chambre existante' : 'No existing rooms')));
			}

			$arrChColor = [];

			$regular = Cleaning::findOne(array('libelle_nettoyage'=>'regular'));
			$complet = Cleaning::findOne(array('libelle_nettoyage'=>'complet'));
			$waitclean = Cleaning::findOne(array('libelle_nettoyage'=>'waitclean'));
			$files= array();

			$dirup = __DIR__ . '/uploads/';
			$files= array();

			$dirAll = $dirup . 'docs';
			if (!is_dir($dirAll)) {
				mkdir($dirAll);
				copy($dirup . 'index.php', $dirAll . '/index.php');
			}


			while (strtotime($dtAdd) <= strtotime($dtj2))
			{
				// echo(strtotime($dtAdd).' -- '.strtotime($dtj2).'<br>');
				$dtnext = date('Y-m-d',strtotime($dtAdd. ' + 1 days'));
	
				foreach($allChs as $ch){
					$verifChJ = Planning::findOne(array('num_chambre'=>$ch['num_chambre'],'LEFT(rdv_end,10)'=>$dtAdd));
					$verifChNext = Planning::findOne(array('num_chambre'=>$ch['num_chambre'],'LEFT(rdv_end,10)'=>$dtnext));
					
					if($verifChJ){
						if($verifChNext){
							if($verifChJ->id_fiche == $verifChNext->id_fiche){
								$arrChColor[] = array($ch['num_chambre'], $regular->color);
							}else{
								$arrChColor[] = array($ch['num_chambre'], $complet->color);
							}
						}else{
							$arrChColor[] = array($ch['num_chambre'], $waitclean->color);
						}
					}
				}
				// print_r($arrChColor);
				// die;

				$doc = IsoPDFBuilder::BuildRoomClean($arrChColor, $usrActif->cursoc,$dtj,$dtj2);
				$nm = substr($doc,strripos($doc, '/') + 1);
				$nm = substr($nm, 0,strpos($nm,'?'));
				
				
				$files[] = $nm;
				
				$dtAdd = date('Y-m-d',strtotime($dtAdd. ' + 1 days'));
				// echo($dtAdd.' --- '.$dtj2).'<br>';
			}

			if(count($arrChColor) <= 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune données à imprimer' : 'No data to print')));
			}
			// echo(print_r($files));
			// die;
			$filename = 'uploads/docs/MENAGE_'.$dtm1.'_'.$dtj2.'.pdf?time='.time();
			IsoPDFBuilder::PdfMerging($files, $dirAll.'/MENAGE_'.$dtm1.'_'.$dtj2.'.pdf', 'Dashboard/uploads/docs/');
			
			$nameDoc = Doc::findOne(array('name_doc'=>'MENAGE_'.$dtm1.'_'.$dtj2.'.pdf'));
			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'10', 'name_doc'=>$nameDoc,'id_usrApp' => $usrActif->id_usrApp));
	
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));
			
				$iddoc = $nameDoc->id_doc;
			}
			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Room List éditée' : 'Room list printed'), 'doc' => $doc, 'iddoc'=>$iddoc, 'namedoc'=>$nameDoc));

			break;

		case 'read-nettoyage':
			verifAccess($usrActif);
			// print_r($_POST);

			$dts = $_POST['start'];
			$dte = $_POST['end'];
			
			$dtAdd = $dts;
			$sejour = '';
			
			$sejour = " id_sejour = ". $usrActif->cursoc;
			
			$evts = array();
			$dtAdd =  date('Y-m-d',strtotime($_POST['start']));


			$allChs = Chambres::getAllCh(array('id_sejour'=>$usrActif->cursoc));
			if($allChs->num_rows <= 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune chambre existante' : 'No existing rooms')));
			}

			$idc = 0;

			$strevents = '';

			$arrChColor = [];

			$regular = Cleaning::findOne(array('libelle_nettoyage'=>'regular'));
			$complet = Cleaning::findOne(array('libelle_nettoyage'=>'complet'));
			$waitclean = Cleaning::findOne(array('libelle_nettoyage'=>'waitclean'));

			$idxEvt = 1;

			while (strtotime($dtAdd) <= strtotime($dte))
			{
				$dtnext = date('Y-m-d',strtotime($dtAdd. ' + 1 days'));
	
				foreach($allChs as $ch){
					$verifChJ = Planning::findOne(array('num_chambre'=>$ch['num_chambre'],'LEFT(rdv_end,10)'=>$dtAdd));
					$verifChNext = Planning::findOne(array('num_chambre'=>$ch['num_chambre'],'LEFT(rdv_end,10)'=>$dtnext));
					
					$rdvstart = date('Y-m-d',strtotime(substr($verifChJ->rdv_end,0,10)))."T08:00:00"; //.substr($verifChJ->rdv_end, 11);						
					$rdvend = date('Y-m-d',strtotime(substr($verifChJ->rdv_end,0,10)))."T08:00:00"; //.substr($verifChJ->rdv_end,11);

					if($verifChJ){
						if($verifChNext){
							if($verifChJ->id_fiche == $verifChNext->id_fiche){
								$arrChColor[] = array($ch['num_chambre'], $regular->color, $rdvstart, $rdvend, $idxEvt);
								
							}else{
								$arrChColor[] = array($ch['num_chambre'], $complet->color, $rdvstart, $rdvend, $idxEvt);
							}
						}else{
							$arrChColor[] = array($ch['num_chambre'], $waitclean->color, $rdvstart, $rdvend, $idxEvt);
						}
					}
					$idxEvt++;
				}
				
				$dtAdd = date('Y-m-d',strtotime($dtAdd. ' + 1 days'));
				// echo($dtAdd.' --- '.$dtj2).'<br>';
			}

			// print_r($arrChColor);
			$title = '';
			$dtDiv = '';
			foreach($arrChColor as $rc){
				$title = '<div>'.$rc[0].' : <input style="width:20px;height:20px;background-color:'.$rc[1].'" readonly /></div>';
				$evts[] = array(
					'title'=> $title,
					'start'=> $rc[2],
					'end'=> $rc[3],
					// 'allDay'=> false,
					'inf'=> '',
					'backgroundColor' => '',
					'textColor'=> '', 
					'description'=> '',
					'id'=>$rc[4]
				);
				$title = '';
			}

			
			if(count($arrChColor) <= 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Aucune données à imprimer' : 'No data to print'),  'evts' => $evts));
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Room List éditée' : 'Room list printed'),  'evts' => $evts));

			break;

		case 'send-mail-insc':
			// print_r($_POST);
			// die;
			if (!Ctrl::ctrlflds($_POST, array('idmailtype', 'email')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$isContrat = ModelMail::findOne(array('id_mailtype'=>(int)$_POST['idmailtype']));
			if($isContrat->type_mail == 6){
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "ENVOI CONTRAT POUR SIGNATURE" ', true,'');
			}else{
				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "DEMANDE DE DEVIS" ', true,'');
			}





			$dirup = __DIR__ . '/uploads/';

			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi vers contact impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send<br>No mailbox configured')));
			}

			// reprend le mailType pour chaque contact
			$msg = $_POST['msg'];

			$dir = $dirup.$ct->codekey . $ct->id_fiche;
			$attach = array();
		
			if (isset($_FILES['fileadd'])) {
				if (!is_dir($dir)) {
					mkdir($dir);
					copy($dirup . 'index.php', $dir . '/index.php');
				}
				
				$total = count($_FILES['fileadd']['name']);
				$file = array();
				for( $i=0 ; $i < $total ; $i++ ) {
					$file = array('error' => UPLOAD_ERR_OK, 'name' => $_FILES['fileadd']['name'][$i], 'tmp_name' => $_FILES['fileadd']['tmp_name'][$i]);
					if ($fl = Tool::uploadFile($dir.'/', $file))
						$attach[] = $dir.'/'.$fl;
				}
			}
			else {
				if ((int)$_POST['attachclr'] != 1 && isset($_POST['id_mailtype']) && (int)$_POST['id_mailtype'] > 0) {
					$mt = ModelMail::findOne(array('id_mailtype' => (int)$_POST['id_mailtype']));
					if ($mt && $mt->attach != '') {
						$ats = json_decode($mt->attach);
						foreach($ats as $at)
							$attach[] = $dirup . 'mailtypes/'.$at;
					}
				}
			}
		
			if (isset($_POST['chkdoc']) && is_array($_POST['chkdoc']) && count($_POST['chkdoc']) > 0) {
				foreach ($_POST['chkdoc'] as $doc) {
					$dc = Doc::findOne(array('id_doc' => (int)$doc));
					if ($dc)
						$attach[] = $dir . '/' . $dc->name_doc;
				}
			}


			// print_r($attach);
			// die;
			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if (Mailings::sendMail('mail-groupe', (object)array(
				'email' => $_POST['email'],
				'subject' => $_POST['subject'],
				'msg' => $msg, 
				'doc' => $attach))) {

				CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI EMAIL INSCRIPTION', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
				
				Imap::create(array('from_mail'=>$resInfmail->inf_username, //'david.cassuto770@gmail.com', 
										'to_mail'=>$_POST['email'], 
										'subject_mail'=>$_POST['subject'], 
										'msg_mail'=>$_POST['msg'], 
										'is_send_mail'=>'1', 
										'date_mail'=>date('Y-m-d'),
										'id_fiche'=>'UNKNOWN', 
										'date_create'=>date('Y-m-d'))
					);


				fiche::update(array('lnk_devis'=>'1','lnk_contrat_sended'=>($isContrat->type_mail == 6 ? '1' : 0), 'id_status_sec' => $stsec->id_status_sec),array('id_fiche'=>(int)$_POST['idct']));
			}else{
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Problème à l\'envoi du mail groupé' : 'Problem when sending multiple email')));
			}
				
			

			respAjax::successJSON(array('OK' => 'OK'));
			
			break;

		case 'send-mail-grid':
			if (!Ctrl::ctrlflds($_POST, array('idmailtype', 'rws', 'url')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			if($_POST['idmailtype'] == 0){
				$msgCt = stripcslashes($_POST['msg']);
				$subject = stripcslashes($_POST['subject']);

			}else{
				$mailt = ModelMail::findOne(array('id_mailtype' => (int)$_POST['idmailtype']));
				if(!$mailt){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mail type introuvable' : 'Email not found')));
				}
				
				$msgCt = stripcslashes($mailt->msg);
				$subject = stripcslashes($mailt->subject); 
			}
			$dirup = __DIR__ . '/uploads/';

			$vars = VarsType::buildVars($usrActif);

			$url = $_POST['url'];

			function formatDate($d){
				$arrDate = explode('-',$d);

				return $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
			}

			function formatTel($t){
				
				return trim(chunk_split($t, 2, ' '));
			}
			

			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if(!$resInfmail){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi vers contact impossible<br>Aucune boite de d\'envoi configurée' : 'Impossible to send<br>No mailbox configured')));
			}

			$rws = explode(',',$_POST['rws']);
			// die('=='.print_r($rws));
			foreach($rws as $idct){

				// reprend le mailType pour chaque contact
				$msg = $msgCt;

				$ct = Fiche::findOne(array('c.id_fiche' => $idct));
				$UsrApp = UsrApp::findOne(array('id_usrApp' => $ct->id_usrApp));
				
				function format_Date($d){
					$arrDate = explode('-',$d);

					return $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
				}

				function format_Tel($t){
					
					return trim(chunk_split($t, 2, ' '));
				}

				$dir = $dirup.$ct->codekey . $ct->id_fiche;
				$attach = array();
			
				if (isset($_FILES['fileadd'])) {
					if (!is_dir($dir)) {
						mkdir($dir);
						copy($dirup . 'index.php', $dir . '/index.php');
					}
					
					$total = count($_FILES['fileadd']['name']);
					$file = array();
					for( $i=0 ; $i < $total ; $i++ ) {
						$file = array('error' => UPLOAD_ERR_OK, 'name' => $_FILES['fileadd']['name'][$i], 'tmp_name' => $_FILES['fileadd']['tmp_name'][$i]);
						if ($fl = Tool::uploadFile($dir.'/', $file))
							$attach[] = $dir.'/'.$fl;
					}
				}
				else {
					if ((int)$_POST['attachclr'] != 1 && isset($_POST['id_mailtype']) && (int)$_POST['id_mailtype'] > 0) {
						$mt = ModelMail::findOne(array('id_mailtype' => (int)$_POST['id_mailtype']));
						if ($mt && $mt->attach != '') {
							$ats = json_decode($mt->attach);
							foreach($ats as $at)
								$attach[] = $dirup . 'mailtypes/'.$at;
						}
					}
				}
			
				if (isset($_POST['chkdoc']) && is_array($_POST['chkdoc']) && count($_POST['chkdoc']) > 0) {
					foreach ($_POST['chkdoc'] as $doc) {
						$dc = Doc::findOne(array('id_doc' => (int)$doc));
						if ($dc)
							$attach[] = $dir . '/' . $dc->name_doc;
					}
				}

				$UsrApp = UsrApp::findOne(array('id_usrApp' => $usrActif->id_usrApp));
				$sejour = Setting::getOrganisateur(array('id_organisateur'=> $usrActif->cursoc));
				$soc = Soc::findOne(array('is_soc'=>'1'));

				$tb['crm'] = $UsrApp;

				$tb['contact'] = $ct;
				$tb['sejour'] = $sejour;
				$tb['soc'] = $soc;
				
				$listeDates = '';
				$periode = '';
				$tel = '';
				$isSign = $_POST['isSign'];

				$tel = '';
				
				// foreach($vars as $k => $v) {
				// 	if($k == '$DEB' || $k == '$FIN' || $k == '$TEL' || $k == '$2TEL' || $k == '$CIVILITE' 
				// 			|| $k == 'CRMTEL' || $k == 'CRMPORT'){

				// 		if($k == '$DEB'){
							
				// 			$periode = formatDate($tb[$v['table']]->{$v['field']});			
							
				// 			$msg = str_replace($k, $periode, $msg);
				// 		}
						
				// 		if($k == '$FIN'){
	
				// 			$periode = formatDate($tb[$v['table']]->{$v['field']});			
							
				// 			$msg = str_replace($k, $periode, $msg);
				// 		}

				// 		if($k == '$TEL'){
	
				// 			$tel = formatTel($tb[$v['table']]->{$v['field']});			
							
				// 			$msg = str_replace($k, $tel, $msg);
				// 		}

				// 		if($k == '$2TEL'){
				// 			$tel = '';
				// 			$tel = formatTel($tb[$v['table']]->{$v['field']});			
							
				// 			$msg = str_replace($k, $tel, $msg);
				// 		}

				// 		if($k == '$CRMTEL'){
				// 			// error_log('tel form'. $tb[$v['table']]->{$v['field']}. ' ---- '.$v['table'].' ---- '.$v['field']);
				// 			$tel = '';
				// 			$tel = formatTel($tb[$v['table']]->{$v['field']});			
							
				// 			$msg = str_replace($k, $tel, $msg);
				// 		}

				// 		if($k == '$CIVILITE'){
							
				// 			if($tb[$v['table']]->{$v['field']} == 0){
				// 				$msg = str_replace($k, 'M.', $msg);
				// 			}
				// 			if($tb[$v['table']]->{$v['field']} == 1){
				// 				$msg = str_replace($k, 'Mr', $msg);
				// 			}
				// 			if($tb[$v['table']]->{$v['field']} == 2){
				// 				$msg = str_replace($k, 'Mme', $msg);
				// 			}
				// 		}

						
						
				// 	}else{
				// 		$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
				// 	}

						
				// 		$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
				// }
				
				// $subject = str_replace($k, $tb[$v['table']]->{$v['field']}, $subject);

				foreach($vars as $k => $v) {
					if($k == '$DEB' || $k == '$FIN' || $k == '$TEL' || $k == '$2TEL' || $k == '$CIVILITE' ||
						$k == '$CRMTEL' || $k == '$CRMPORT' || $k == '$LNK_DEVIS' || $k == '$LNK_CONTRAT'  || $k == '$SOC'  || $k == '$ZIP_SOC'
						|| $k == '$CITY_SOC'  || $k == '$PHONE_SOC' || $k == '$MAIL_SOC' || $k == '$LOGO_SOC' || $k == '$SIGN_SOC'){
		
							
						if($k == '$LOGO_SOC'){	
							$imglogo = '<img src="'.'../Dashboard/uploads/socs/'.$tb[$v['table']]->{$v['field']}.'" alt="" style="width:150px"/>';
							$msg = str_replace($k,$imglogo , $msg);
						}
		
						if($k == '$SIGN_SOC'){	
							$imgsign = '<img src="'.'../Dashboard/uploads/socs/'.$tb[$v['table']]->{$v['field']}.'" alt="" style="width:150px"/>';
							$msg = str_replace($k,$imgsign , $msg);
						}
						
						if($k == '$SOC'){			
							$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
							$subject = str_replace($k, $tb[$v['table']]->{$v['field']}, $subject);
						}
		
						if($k == '$MAIL_SOC'){			
							$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
						}
		
						if($k == '$CITY_SOC'){			
							$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
						}
		
						if($k == '$ZIP_SOC'){			
							$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
						}
		
						if($k == '$PHONE_SOC'){
		
							$tel = format_Tel($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $tel, $msg);
						}
		
						if($k == '$LNK_DEVIS'){			
							if($ct != ''){
								if($_POST['type'] != 'I'){
									$lnk = '<a href="'.$url.'/fiche-client.php?CLID='.$ct->codekey.$ct->id_fiche.'&KEY='.date('YmdHi').'&type=A'.$sejour->periode.$sejour->id_organisateur.'&mail='.$ct->email.'&LG='.$lg.'&SGN='.$isSign.'">Cliquez ici</a>';
									$msg = str_replace($k, $lnk, $msg);
								}else{
									$lnk = '<a href="'.$url.'/fiche-client.php?KEY='.date('YmdHi').'&type=I'.$sejour->periode.$sejour->id_organisateur.'&mail='.$ct->email.'&LG='.$lg.'&SGN='.$isSign.'&listing='.$ct->id_fiche.'&listingSej='.$usrActif->cursoc.'">Cliquez ici</a>';
									$msg = str_replace($k, $lnk, $msg);
								}
							}else{
								$lnk = '<a href="'.$url.'/fiche-client.php?KEY='.date('YmdHi').'&type=I'.$sejour->periode.$sejour->id_organisateur.'&mail='.$ct->email.'&LG='.$lg.'&SGN='.$isSign.'&listing='.$ct->id_fiche.'&listingSej='.$usrActif->cursoc.'">Cliquez ici</a>';
								$msg = str_replace($k, $lnk, $msg);
							}
						}
		
						if($k == '$LNK_CONTRAT'){			
							$lnk = '<a href="'.$url.'/fiche-client.php?CLID='.$ct->codekey.$ct->id_fiche.'&KEY='.date('YmdHi').'&type=C'.$sejour->periode.$sejour->id_organisateur.'&mail='.$email.'&LG='.$lg.'">Cliquez ici</a>';
							$msg = str_replace($k, $lnk, $msg);
						}
		
						if($k == '$DEB'){
		
							$periode = format_Date($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $periode, $msg);

							$subject = str_replace($k, $periode, $subject);
						}
						
						if($k == '$FIN'){
		
							$periode = format_Date($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $periode, $msg);
							
							$subject = str_replace($k, $periode, $subject);
						}
		
						if($k == '$TEL'){
		
							$tel = format_Tel($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $tel, $msg);
						}
		
						if($k == '$2TEL'){
							$tel = '';
							$tel = format_Tel($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $tel, $msg);
						}
		
						if($k == '$CRMTEL'){
							// error_log('tel form'. $tb[$v['table']]->{$v['field']}. ' ---- '.$v['table'].' ---- '.$v['field']);
							$tel = '';
							$tel = format_Tel($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $tel, $msg);
						}
		
						if($k == '$CRMPORT'){
							// error_log('tel form'. $tb[$v['table']]->{$v['field']}. ' ---- '.$v['table'].' ---- '.$v['field']);
							$tel = '';
							$tel = format_Tel($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $tel, $msg);
						}
		
						if($k == '$CIVILITE'){
							
							if($tb[$v['table']]->{$v['field']} == 0){
								$msg = str_replace($k, 'M.', $msg);
								$subject = str_replace($k, 'M.', $subject);
							}
							if($tb[$v['table']]->{$v['field']} == 1){
								$msg = str_replace($k, 'Mr', $msg);
								$subject = str_replace($k, 'Mr', $subject);
							}
							if($tb[$v['table']]->{$v['field']} == 2){
								$msg = str_replace($k, 'Mme', $msg);								
								$subject = str_replace($k, 'Mme', $subject);
							}
						}
					}
					else {
						$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
						$subject = str_replace($k, $tb[$v['table']]->{$v['field']}, $subject);
					}
				}


				// print_r($msg);
				// die;
				$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
				if (Mailings::sendMail('mail-groupe', (object)array(
					'email' => $ct->email,
					'subject' => $subject,
					'msg' => $msg, 
					'doc' => $attach))) {

					CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'ENVOI EMAIL GROUPE', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::stripTags($msg)));
					
					Imap::create(array('from_mail'=>$resInfmail->inf_username, //'david.cassuto770@gmail.com', 
											'to_mail'=>$_POST['email'], 
											'subject_mail'=>$_POST['subject'], 
											'msg_mail'=>$_POST['msg'], 
											'is_send_mail'=>'1', 
											'date_mail'=>date('Y-m-d'),
											'id_fiche'=>$_POST['idc'], 
											'date_create'=>date('Y-m-d'))
						);
				}else{
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Problème à l\'envoi du mail groupé' : 'Problem when sending multiple email')));
				}
				
			}

			respAjax::successJSON(array('OK' => 'OK'));
			
			break;
	
		// case 'send-mail-multiple':
		// 	if (!Ctrl::ctrlflds($_POST, array('email', 'subject', 'msg')))
		// 		respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				
		// 	$dirup = __DIR__ . '/uploads/';
			
		// 	$body = stripcslashes($_POST['msg']);
		// 	$subject = stripcslashes($_POST['subject']); 
			
		// 	$attach = array();
			
		// 	if (isset($_FILES['fileadd'])) {
		// 		if (!is_dir($dir)) {
		// 			mkdir($dir);
		// 			copy($dirup . 'index.php', $dir . '/index.php');
		// 		}
				
		// 		$total = count($_FILES['fileadd']['name']);
		// 		$file = array();
		// 		for( $i=0 ; $i < $total ; $i++ ) {
		// 			$file = array('error' => UPLOAD_ERR_OK, 'name' => $_FILES['fileadd']['name'][$i], 'tmp_name' => $_FILES['fileadd']['tmp_name'][$i]);
		// 			if ($fl = Tool::uploadFile($dir.'/', $file))
		// 				$attach[] = $dir.'/'.$fl;
		// 		}
		// 	}
		// 	else {
		// 		if ((int)$_POST['attachclr'] != 1 && isset($_POST['id_mailtype']) && (int)$_POST['id_mailtype'] > 0) {
		// 			$mt = ModelMail::findOne(array('id_mailtype' => (int)$_POST['id_mailtype']));
		// 			if ($mt && $mt->attach != '') {
		// 				$ats = json_decode($mt->attach);
		// 				foreach($ats as $at)
		// 					$attach[] = $dirup . 'mailtypes/'.$at;
		// 			}
		// 		}
		// 	}
		
		// 	if (isset($_POST['chkdoc']) && is_array($_POST['chkdoc']) && count($_POST['chkdoc']) > 0) {
		// 		foreach ($_POST['chkdoc'] as $doc) {
		// 			$dc = Doc::findOne(array('id_doc' => (int)$doc));
		// 			if ($dc)
		// 				$attach[] = $dir . '/' . $dc->name_doc;
		// 		}
		// 	}

		// 	$supcomamail = substr_replace($_POST['email'],"",strripos($_POST['email'],";"));
			
		// 	$ctrlemail = explode(';', $supcomamail);
			
		// 	if(count($ctrlemail) > 0){
		// 		if (Mailings::sendMail('mail-groupe', (object)array(
		// 			'email' => $ctrlemail,
		// 			'subject' => $_POST['subject'],
		// 			'msg' => $_POST['msg'], 
		// 			'doc' => $attach))) {

		// 			CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI EMAIL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $_POST['subject']));
		// 			respAjax::successJSON(array('OK' => 'OK'));
		// 		}
		// 	}
		// 	respAjax::errorJSON(array('message' => 'Problème à l\'envoi du mail'));
		// 	break;

		case 'save-smstype':
			if ($arrAccess['modif_sms_type'] != '1')
				respAjax::errorJSON(array('message' => 'Action non autorisée'));

			if (!Ctrl::ctrlflds($_POST, array('name_smstype', 'msgsms')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$arr = array(
				'name_smstype' => stripcslashes($_POST['name_smstype']),
				'msg' => stripcslashes($_POST['msgsms'])
			);

			if ((int)$_POST['id_smstype'] == 0)
				SMSType::create($arr);
			else
				SMSType::update($arr, array('id_smstype' => (int)$_POST['id_smstype']));

			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'send-contact-sms':
			if (!Ctrl::ctrlflds($_POST, array('idc', 'num', 'msg')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$contact = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idc']));
			if (!$contact || !Fiche::checkRight($contact))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vous ne pouvez pas effectuer cette operation' : 'Denied')));

			$body = stripcslashes($_POST['msg']);
			$phone = $_POST['num'];
			if (strlen($phone) == 10 && (substr($phone, 0, 2) == '06' || substr($phone, 0, 2) == '07'))
				$fullnum = '+33' . substr($phone, 1);


			if ($fullnum != '') {

				if ($sms = SMS::SendMessage($body, $fullnum)) {
				//if (strpos($sms, '<result>0000</result>') !== false) {
					// CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp, 'type_action' => 'ENVOI SMS', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => $body));
					respAjax::successJSON(array('OK' => 'OK'));
				} else
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur envoi SMS : ' . $sms : 'Sending error SMS : '.$sms)));
			}

			respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Problème à l\'envoi du SMS' : 'Problem when sending SMS')));
			break;

		case 'show-smstype':
			// print_r('==>'.$_POST);
			if (!Ctrl::ctrlflds($_POST, array('id_smstype')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));
			
			$result = array();

			$result = SMSType::replaceVars($_POST['id_fiche'], $_POST['id_smstype']);

			$res = $result['data'];
			$msg = $result['msg'];

			respAjax::successJSON(array('OK' => 'OK', 'data' => $res, 'msg' => strip_tags($msg)));
			break;

		case 'del-smstype':
			if (!Ctrl::ctrlflds($_POST, array('id_smstype')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			SMSType::delete(array('id_smstype' => (int)$_POST['id_smstype']));
			respAjax::successJSON(array('OK' => 'OK'));
			break;
	

		// case 'update-settings':
		// 	if ($arrAccess[''])
		// 		respAjax::errorJSON(array('message' => 'Action non autorisée'));

		// 	$flds = array(
		// 		'TX_TVA'
		// 	);
		// 	if (!Ctrl::ctrlflds($_POST, $flds))
		// 		respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

		// 	$flds[] = 'STATUS_TO_CUST';
		// 	$flds[] = 'CLICKSEND_UNAME';
		// 	$flds[] = 'CLICKSEND_KEY';
		// 	$flds[] = 'UUID';
		// 	$flds[] = 'TOKEN';

		// 	foreach ($flds as $fld)
		// 		if (!Setting::updateGlobalSettings($fld, $_POST[$fld]))
		// 			respAjax::errorJSON(array('message' => 'Error on update settings (' . $fld . ' => ' . $_POST[$fld] . ')'));

		// 	CrmAction::create(array('id_usrApp' => $usrActif->id_usrApp,  'type_action' => 'MODIFICATION PARAMETRAGE GENERAL', 'date_action' => date('Y-m-d H:i:s'), 'details_action' => Tool::arrayToStr($_POST)));
		// 	respAjax::successJSON(array('OK' => 'OK'));
		// 	break;

		case 'mod-type-ch':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idmodt')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	

			Chambres::updateType(array('name_type_chambre'=>$_POST['modtype']), array('id_type_chambre'=>$_POST['idmodt']));
			respAjax::successJSON(array('OK' => 'OK','lib'=>$_POST['modtype']));
			break;

		case 'mod-loc-ch':
			if (!Ctrl::ctrlflds($_POST, array('idmodl')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	

			Chambres::updateLoc(array('name_loc_chambre'=>$_POST['modloc']), array('id_loc_chambre'=>$_POST['idmodl']));
			respAjax::successJSON(array('OK' => 'OK','lib'=>$_POST['modloc']));
			break;

		case 'del-type-ch':
			// print_r($_POST);
			if (!Ctrl::ctrlflds($_POST, array('idtypech')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	

			Chambres::deleteType(array('id_type_chambre'=>$_POST['idtypech']));
			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'del-loc-ch':
			if (!Ctrl::ctrlflds($_POST, array('idlocch')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	

			Chambres::deleteLoc(array('id_loc_chambre'=>$_POST['idlocch']));
			respAjax::successJSON(array('OK' => 'OK'));
			break;

		case 'add-type-ch':
			if (!Ctrl::ctrlflds($_POST, array('lib')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	

			$res = Chambres::createType(array('name_type_chambre'=>$_POST['lib']));

			$addtr = '<tr id="lgtype' . $res . '">
						<td style="width: 90%;" id="type' . $res . '">
							<span class="columnClass">'.$_POST['lib'].'</span>
						</td> 
						<td style="width: 10%;">
						<a href="#" data-toggle="tooltip" data-id-type="' . $res . '"  data-lib-type="' . $_POST['lib'] . '" title="Modifier" class="btn btn-xs btn-warning btmodtypech"><i class="fa fa-pencil" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
						<a href="#" data-toggle="tooltip" data-id-type="' . $res . '" title="Supprimer" class="btn btn-xs btn-danger btdeltypech"><i class="fa fa-trash" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
						</td>
					</tr>';
			respAjax::successJSON(array('OK' => 'OK','addtr'=>$addtr));
			break;

		case 'add-loc-ch':
			if (!Ctrl::ctrlflds($_POST, array('lib')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	

			$res = Chambres::createLoc(array('name_loc_chambre'=>$_POST['lib']));

			$addtr = '<tr id="lgloc' . $res . '">
						<td style="width: 90%;" id="loc' . $res . '">
							<span class="columnClass">'.$_POST['lib'].'</span>
						</td> 
						<td style="width: 10%;">
						<a href="#" data-toggle="tooltip" data-id-loc="' . $res . '"  data-lib-loc="' . $_POST['lib'] . '" title="Modifier" class="btn btn-xs btn-warning btmodtypech"><i class="fa fa-pencil" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
						<a href="#" data-toggle="tooltip" data-id-loc="' . $res . '" title="Supprimer" class="btn btn-xs btn-danger btdeltypech"><i class="fa fa-trash" style="width: 100px;text-align: center;vertical-align: sub;"></i></a>
						</td>
					</tr>';
			respAjax::successJSON(array('OK' => 'OK','addtr'=>$addtr));
			break;

		case 'ctrl-ext-files':
			if (!Ctrl::ctrlflds($_POST, array('names')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	
		
			$lstext = [];
			$idx = 0;

			foreach($_POST['names'] as $name){
				$ext = explode('.',$name);
				// print_r($ext);
				// die;
				if (!in_array(strtolower($ext[1]), array('txt','jpg', 'gif', 'jpeg', 'png', 'wav', 'mpg','mpeg', 'mp4', 'pdf', 'doc', 'docx', 'xls', 'xlsx'))) {
					$lstext[] = $name;
				}
				$idx++;
			}
			
			if(count($lstext) > 0){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur pièce jointe<br>Verifier les extentions autorisées<br>txt,jpg, gif, jpeg, png, wav, mpg,mpeg, mp4, pdf, doc, docx, xls, xlsx' : 'Attachment error<br>Check allowed extensions<br>txt,jpg, gif, jpeg, png, wav, mpg,mpeg, mp4, pdf, doc, docx, xls, xlsx'),
											'idx'=>$lstext));
			}

			respAjax::successJSON(array('OK' => 'OK'));	
			break;

		case 'save-mailtype':
			// print_r($_POST);
			// die;
			if ($arrAccess['modif_mail_type'] != '1')
				respAjax::errorJSON(array('message' => 'Action non autorisée'));

			if (!Ctrl::ctrlflds($_POST, array('name_mailtype', 'subject', 'msg')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	

			$errFile = 0;
			
			$dirup = __DIR__ . '/uploads/';
			$dir = $dirup.'mailtypes';
			
			$attach = array();
			if (isset($_FILES['fileadd'])) {

				$total = count($_FILES['fileadd']['name']);
				$file = array();
				
				for( $i=0 ; $i < $total ; $i++ ) {
					$errFile = 0;
					foreach($_POST['errExt'] as $errExt){
						if(in_array(strtolower($errExt), $_FILES['fileadd']['name'][$i])){
							$errFile = 1;
						}
					}

					if($errFile == 0){
						$file = array('error' => UPLOAD_ERR_OK, 'name' => $_FILES['fileadd']['name'][$i], 'tmp_name' => $_FILES['fileadd']['tmp_name'][$i]);
						if ($fl = Tool::uploadFile($dir.'/', $file)){
							$attach[] = $fl;
						}else{
							respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Erreur pièce jointe<br>Verifier les extentions autorisées<br>txt,jpg, gif, jpeg, png, wav, mpg,mpeg, mp4, pdf, doc, docx, xls, xlsx' : 'Attachment error<br>Check allowed extensions<br>txt,jpg, gif, jpeg, png, wav, mpg,mpeg, mp4, pdf, doc, docx, xls, xlsx')));
						}
					}
				}
			}
	

			$arr = array(
				'name_mailtype' => str_replace('<br />', '<br>', stripcslashes($_POST['name_mailtype'])), 
				'subject' => str_replace('<br />', '<br>', stripcslashes($_POST['subject'])), 
				'msg' => str_replace('<br />', '<br>', stripcslashes($_POST['msg'])),
				'dest_mail_type' => (int)$_POST['dest_mail_type'],
				'type_mail' => (int)$_POST['typemodel']
			);

			

			if (count($attach) > 0)
				$arr['attach'] = json_encode($attach);
			else
			if ((int)$_POST['attachclr'] == 1)
				$arr['attach'] = '';


				// print_r($arr);
			$table_mailtype = 'db_mailtypes';
			if ((int)$_POST['id_mailtype'] == 0){
				ModelMail::create($arr);
			}
			else{
				ModelMail::update($arr, array('id_mailtype' => (int)$_POST['id_mailtype']));
			}
			
				
			
			respAjax::successJSON(array('OK' => 'OK'));			
			break;

		case 'affiche-mailtype':
			if (!Ctrl::ctrlflds($_POST, array('id_mailtype')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	
			
			$result = array();

			if($_POST['app'] == ''){
				$result = ModelMail::replaceVars($_POST['id_fiche'], $_POST['id_mailtype']);
			}else{
				if($_POST['type'] == 'A' || $_POST['type'] == 'C'){
					$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['id_fiche']));
				}
				$result = ModelMail::replaceVarsInscript($_POST['mail'], $_POST['id_mailtype'], $_POST['url'], $usrActif, ($_POST['type'] == 'C' || $_POST['type'] == 'A' ? $ct : ''), ($_POST['type'] == 'C' || $_POST['type'] == 'A' ? $ct->lg : $_POST['lg']), $_POST['isSign'] );
			}

			$res = $result['data'];
			$msg = $result['msg'];
			$subject = $result['subject'];
			$dest = $result['dest'];
			$model = $result['type_mail'];

			respAjax::successJSON(array('OK' => 'OK', 'data' => $res, 'msg' => $msg, 'subject' => $subject, 'dest' => $dest, 'model'=>$model));
			break;

		case 'affiche-mailtype-fourn':
			if (!Ctrl::ctrlflds($_POST, array('id_mailtype', 'emailto', 'id_fournisseur')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	
			
			$result = array();

			// print_r($_POST);
			// die;
			// $f = Fournisseurs::findOne(array('mail_fournisseur'=>$_POST['emailto']));

			$result = ModelMail::replaceVarsCmd($_POST['id_fournisseur'], $_POST['id_mailtype'],$usrActif);

			$res = $result['data'];
			$msg = $result['msg'];
			$subject = $result['subject'];
			$dest = $result['dest'];
			$model = $result['type_mail'];

			respAjax::successJSON(array('OK' => 'OK', 'data' => $res, 'msg' => $msg, 'subject' => $subject, 'dest' => $dest, 'model'=>$model));
			break;
	
		case'del-mailtype':
			if (!Ctrl::ctrlflds($_POST, array('id_mailtype')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));	
			
			ModelMail::delete(array('id_mailtype' => (int)$_POST['id_mailtype']));
			respAjax::successJSON(array('OK' => 'OK'));
			break;
	}
}