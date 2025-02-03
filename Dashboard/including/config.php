<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/../../including/dbclass.php';
include __DIR__ . '/../../including/Grid4PHP.php'; 

$arrAccess = array();

session_start();
if (isset($_GET['logoff'])) {
	$_SESSION['loginUsr'] = false;
	session_destroy();
} else {
	if (!isset($_SESSION['loginUsr']) && !isset($ispagelogin)) {
		header('location:sign-in.php');
		die;
	} else 
	
	if (isset($_SESSION['loginUsr']) && $_SESSION['loginUsr'] == true) {
		$usrActif = unserialize($_SESSION['user_actif']);

		$respUsr = UsrApp::whatIsProfile($usrActif);
		
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

	}

	if (!isset($ispagelogin) && (!isset($usrActif) || !$usrActif || (int)$usrActif->id_profil == 0)) {
		
		header('location:sign-in.php');
		die;
	}else{
	// 	print_r($arrAccess);
	// die;

	}
}

/* Template variables */
$template = array(
	'name'              => '',
	'version'           => '1.0',
	'author'            => 'david',
	'robots'            => 'noindex, nofollow',
	'title'             => ' DEMO AZURO CRM',
	'description'       => ' DEMO AZURO CRM',
	'url'				=> 'http://crm-hotel.dev-customer.com/Dashboard',
	'public_url'		=> 'http://crm-hotel.dev-customer.com',
	
	'page_preloader'    => false,
	
	'menu_scroll'       => true,
	
	'header_navbar'     => 'navbar-default',
	
	'header'            => '',
	
	'sidebar'           => '',
	
	'footer'            => '',
	
	'main_style'        => '',
	
	'cookies'           => '',
	
	'theme'             => 'plage', //'#6bb9e3', //	'waterlily',
	
	'header_content'    => '',
	'active_page'       => basename($_SERVER['PHP_SELF'])
);


?>