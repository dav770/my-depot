<?php
include 'including/dbclass.php';

require_once 'Dashboard/libry/sellsign/vendor/autoload.php';

use GuzzleHttp\Client;

// $PUBURL = 'localhost/hostel';
$PUBURL = 'crm-hotel.dev-customer.com';
error_reporting(0);


if (isset($_POST['action'])) {
	$action = $_POST['action'];

	$URL = 'https://crm-hotel.dev-customer.com/Dashboard/';
	// $URL = 'localhost/hostel/Dashboard/';

	switch ($action) {

		case 'calcul-age':
			if (!Ctrl::ctrlflds($_POST, array('dtb')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de naissance manquante ou invalide' : 'Missing date of birth or not valid')));

			function isValid($date, $format = 'Y-m-d'){
				$dt = DateTime::createFromFormat($format, $date);
				return $dt && $dt->format($format) === $date;
			}

			if(!isValid($_POST['dtb'])){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date invalide' : 'Date not valid')));
			}
			
			$resenf = Tarif::getEnfant();
			$resbb = Tarif::getBb();

			$enf = 0;
			$bb = 0;
			$ad = 0;

			$dj = date('Y-m-d');
			$typeage = '0';

			if($_POST['dtb'] != '1900-01-01'){

				$dtn = $_POST['dtb']; 
				$diff = date_diff(date_create($dtn), date_create($dj));
				$myage =  $diff->format('%y');
			}else{
				$myage = $_POST['age'];
			}

			if($_POST['app'] == 'DB'){
				respAjax::successJSON(array('OK' => 'OK', 'age'=>$myage));
			}
			
	
			foreach ($_POST['arrDt'] as $value) {
				// echo($enf.' ---- '.$bb.' *** '.$value.' ===='.);
				$dtn ='';
				$diff = '';
				$age = 0;
				
				if($_POST['dtb'] != '1900-01-01'){
					$dtn = $value; 
					$diff = date_diff(date_create($dtn), date_create($dj));
					$age =  $diff->format('%y');
				}else{
					$age = $_POST['age'];
				}
	
				if($age >= ($resbb->age_bb + 1) && $age <= $resenf->age_enfant){
					$enf++;
					$typeage = '2';
				}
	
				if($age <= $resbb->age_bb){
					$bb++;
					$typeage = '3';
				}
	
				if($age >= $resenf->age_enfant){
					$ad++;
					$typeage = '1';
				}
			}

			respAjax::successJSON(array('OK' => 'OK', 'age'=>$myage, 'enf' => $enf, 'bb'=>$bb, 'adulte'=>$ad, 'type'=>$typeage));
			break;
			
		case 'del-inf':
			if (!Ctrl::ctrlflds($_POST, array('iddet')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ctdet = Fiche::findOneDetails(array('cd.id_contact_detail'=>(int)$_POST['iddet']));
			
			if(!$ctdet){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client info introuvable' : 'Information customer not exist')));
			}

			$ctdet = Fiche::DeleteDetails(array('id_contact_detail'=>(int)$_POST['iddet']));

			respAjax::successJSON(array('OK' => 'OK'));
			break;
			

		case 'dspl-inf-i':
			$detopts = Tarif::getAll(array('is_visible_inscript'=>'1'));
		
			$datasopts = [];
			foreach($detopts as $dataopt){
				
				$resopt['lib_detail_option'] = $dataopt['libelle_tarif'];
				$resopt['id_lib_option'] = $dataopt['id_tarif'];
				$resopt['qte_detail_option'] = 0;
				$resopt['tarif_detail_option'] = $dataopt['age_tarif'];
				$datasopts[] = $resopt;
			}
			respAjax::successJSON(array('OK' => 'OK', 'dataopt' => $datasopts));
			break;
			
		case 'dspl-inf':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'codekey', 'idsejour')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct'], 'c.codekey'=>$_POST['codekey'], 'c.id_organisateur'=>(int)$_POST['idsejour']));
			
			if(!$ct){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client introuvable' : 'Customer not exist')));
			}

			$ctdet = Fiche::getAllDetails(array('id_fiche'=>(int)$_POST['idct']));
			$datas = [];

			if($_POST['listopts'] == '1'){
				$detopts = Fiche::getAllDetailsOptions(array('id_fiche'=>(int)$_POST['idct']));
			}else{
				$detopts = Tarif::getAll(array('is_visible_inscript'=>'1'));
			}
			$datasopts = [];

			$resenf = Tarif::getEnfant();
			$resbb = Tarif::getBb();

			$enf = 0;
			$bb = 0;
			$ad = 0;

			foreach($ctdet as $data){
				$res['last_name_detail'] = $data['last_name_detail'];
				$res['first_name_detail'] = $data['first_name_detail'];
				$res['date_naissance_detail'] = $data['date_naissance_detail'];
				$res['age'] = number_format($data['age']);
				$res['sexe'] = $data['sexe'];
				$res['is_p'] = $data['is_p'];
				
				if($data['age'] >= ($resbb->age_bb + 1) && $data['age'] <= $resenf->age_enfant){
					$enf++;
					$typeage = '2';
				}
				
				if($data['age'] <= $resbb->age_bb){
					$bb++;
					$typeage = '3';
				}
				
				if($data['age'] >= $resenf->age_enfant){
					$ad++;
					$typeage = '1';
				}
				
				$res['type'] = $typeage;
				$datas[] = $res;
			}

			if($_POST['listopts'] == '1'){
				foreach($detopts as $dataopt){
					$resopt['lib_detail_option'] = $dataopt['lib_detail_option'];
					$resopt['id_lib_option'] = $dataopt['id_lib_option'];
					$resopt['qte_detail_option'] = $dataopt['qte_detail_option'];
					$resopt['tarif_detail_option'] = $dataopt['tarif_detail_option'];
					$datasopts[] = $resopt;
				}
			}else{
				foreach($detopts as $dataopt){
					$existopt = Fiche::findOneDetailsOptions(array('cd.id_fiche'=>(int)$_POST['idct'], 'cd.id_lib_option'=>(int)$dataopt['id_tarif']));

					$resopt['lib_detail_option'] = $dataopt['libelle_tarif'];
					$resopt['id_lib_option'] = $dataopt['id_tarif'];
					$resopt['qte_detail_option'] = ($existopt->qte_detail_option > 0 ? $existopt->qte_detail_option : 0);
					$resopt['tarif_detail_option'] = $dataopt['age_tarif'];
					$datasopts[] = $resopt;
				}
			}

			respAjax::successJSON(array('OK' => 'OK', 'data' => $datas,  'dataopt' => $datasopts, 'enf' => $enf, 'bb'=>$bb, 'adulte'=>$ad, 'type'=>$typeage));
			break;
			
		case 'sign-doc-public':
			
			if (!Ctrl::ctrlflds($_POST, array('idct', 'idd', 'nameDoc', 'typeDoc')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$typedoc = '';
			
			$contact = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct']));
			if (!$contact)
				respAjax::errorJSON(array('message' => 'Client inexistant'));

			$doc = Doc::findOne(array('id_doc' => (int)$_POST['idd']));
			if (!$doc)
				respAjax::errorJSON(array('message' => 'Document introuvable'));

			$sellsignurl = 'https://betacloud.sellandsign.com';
			
			$jToken = 'MHPALACE|sRMMuomRe0ANJO0QGeNoi/QiFvx2AIPQrfhgbM+eteE=';

			$client = new Client([
				'timeout'  => 20.0,
			]);
			
			// pour envoi de doc PDF
			$contract_definition_id = 71025 ; 
			$actor_id = 1599309; 
			$vendor_email = 'fo.mh-palace@calindasoftware.com';

			$nameDoc = $_POST['nameDoc']; 
			$libTypeDoc = trim($_POST['typeDoc']);


			$dirup = __DIR__ . '/Dashboard/uploads/';
			$dir = $dirup . $contact->codekey.$contact->id_fiche;

			// pour back-office
			$login = 'kosher@mhpalace.com';
			$Password  = '';

			
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
													"value"=> ($contact->civ_contact == 1 ? 'MONSIEUR' : 'MADAME')
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
						"message_title"=> "Votre contrat ".$libTypeDoc." pour signature",
						"message_body"=> "Vous êtes signataire du contrat ".$libTypeDoc." ci-joint pour la société MHPALACE. Merci de bien vouloir le signer électroniquement en cliquant sur le lien ci-dessous.<br>Cordialement,"	
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
			
			if (file_exists(__DIR__ . '/Dashboard/libry/sellsign/adhoc_light.sellsign'.$_POST['idd'])) {
				unlink(__DIR__ . '/Dashboard/libry/sellsign/adhoc_light.sellsign'.$_POST['idd']);
			}

			$bytes = file_put_contents(__DIR__ . '/Dashboard/libry/sellsign/adhoc_light.sellsign'.$_POST['idd'], $sellsign);
			if($bytes <= 0 || $bytes == false){
				respAjax::errorJSON(array('message' => 'echec de la génération du .json Sell&Sign'));
			}
			
		
			try {
				$response = $client->request('POST', $sellsignurl.'/calinda/hub/selling/do?m=sendCommandPacket', [
					'headers' => [
						'j_token' => $jToken
						],
				
					'multipart' => [
						[
							'name'     => 'adhoc_light.sellsign'.$_POST['idd'],
							'contents' => fopen(__DIR__.'/Dashboard/libry/sellsign/'.'adhoc_light.sellsign'.$_POST['idd'], 'r'),
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
			

			respAjax::successJSON(array('OK' => 'OK', 'url' =>'','contract_id' => $resguzzle['contract_id'], 'message'=>'Contrat envoyé par mail<br>pour signature électronique<br>N° '.$resguzzle['contract_id']));
			break;


		case 'sign-contrat':
			
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$nbelement = array();

			for($i=1; $i <= (int)$_POST['nbclic']; $i++){
				
				// verification si suppression elements avant envoi
				if(isset($_POST['addnom'.$i])){
					$nbelement[] = $i;

					if(trim($_POST['addnom'.$i]) == '' || trim($_POST['addprenom'.$i]) == '' || trim($_POST['adddate'.$i]) == '' || trim($_POST['addpasseport'.$i]) == '' ){
						respAjax::errorJSON(array('message' => 'Vous devez indiquer, les Noms, Prénoms , Dates de naissances et N° de passeport, de chacun'));
					}
					
				}

			}

			$doc = Doc::findOne(array('name_doc'=>'CONTRAT_SIGNED_'.(int)$_POST['idct'].'.pdf', 'id_fiche'=>(int)$_POST['idct']));
			if($doc){
				respAjax::errorJSON(array('message' => 'Vous avez déjà signé votre contrat'));
			}

			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));

			$ageAdulte = Tarif::getAdulte('');
			$ageEnfant = Tarif::getEnfant('');
			$ageBb = Tarif::getBb('');

			$arrct = array();
			// $arrct['first_name_detail'] = $ct->first_name;
			// $arrct['last_name_detail'] = $ct->last_name;
			// $arrct['date_naissance_detail'] = $ct->date_birth;

			// $dtn = $ct->date_birth; 
			// $dj = date('Y-m-d');
			// $diff = date_diff(date_create($dtn), date_create($dj));

			// $arrct['age'] = $diff->format('%y');

			// $arrct['id_fiche'] = $ct->id_fiche;
			// $arrct['type_detail'] = '1';
			// $arrct['num_passport'] = $_POST['numpassport'];

			
			$tel = '';
			if(strlen($_POST['tel2']) >= 10){
				$tel = $_POST['tel2'];
			}

			// Fiche::update(array('tel2'=>$tel, 'num_passport'=>$_POST['numpassport']), array('id_fiche'=>$ct->id_fiche));
			Fiche::update(array('tel2'=>$tel), array('id_fiche'=>$ct->id_fiche));

			// Fiche::DeleteDetails(array('id_fiche'=>(int)$_POST['idct']));

			// ajout representant
			// Fiche::CreateDetails($arrct);

			for($i=1; $i <= (int)$_POST['nbclic']; $i++){
				$arrct = array();
				$arrctID = array();

				$arrbirth = explode('/',$_POST['adddate'.$i]);
				$isbirthok = $arrbirth[2].'-'.$arrbirth[1].'-'.$arrbirth[0];
				if(!checkdate((int)$arrbirth[1],(int)$arrbirth[0],(int)$arrbirth[2])){
					respAjax::errorJSON(array('message' => 'Date non valide'));
				}

				// verification si suppression elements avant envoi

				if(in_array($i, $nbelement)){
					$arrct['first_name_detail'] = $_POST['addnom'.$i];
					$arrct['last_name_detail'] = $_POST['addprenom'.$i];
					$arrct['date_naissance_detail'] = $isbirthok; // $_POST['adddate'.$i]; 
					$dtn = $isbirthok; // $_POST['adddate'.$i];
	
					$dj = date('Y-m-d');
					$diff = date_diff(date_create($dtn), date_create($dj));
	
					$arrct['age'] =  $diff->format('%y');
	
					// if((int)$diff->format('%y') <= (int)$ageBb->age_bb){
					// 	$arrct['type_detail'] = 3;
					// }
	
					// if((int)$diff->format('%y') > (int)$ageBb->age_bb && (int)$diff->format('%y') <= (int)$ageEnfant->age_enfant){
					// 	$arrct['type_detail'] = 2;
					// }
	
					// if((int)$diff->format('%y') >= (int)$ageAdulte->age_adulte){
					// 	$arrct['type_detail'] = 1;
					// }
	
					
					$arrct['num_passport'] = $_POST['addpasseport'.$i];
					$arrctID['id_contact_detail'] = $_POST['iddet'.$i];
					$arrctID['id_fiche'] = $ct->id_fiche;
					
					// print_r($arrct);
					// ajout membres
					// Fiche::CreateDetails($arrct);
					Fiche::updateDetails($arrct,$arrctID);
				}
			}

			// die;
			$doc = IsoPDFBuilder::BuildContrat($ct, false);
			// print_r($doc);
			// die;

			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));

	
			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'4', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));
			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));

				$iddoc = $nameDoc->id_doc;
			}

			// print_r($_POST);
			// die;
			
			respAjax::successJSON(array('OK' => 'OK', 'idd'=>$iddoc, 'idct'=>$ct->id_fiche, 'doc'=>'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/CONTRAT_'.$ct->id_fiche.'.pdf','namedoc'=>$nm, 'typedoc'=>'Contrat'));
			
			break;

		case 'sign-devis':
			// if($_POSt['type'] == 'I'){
			// 	if (!Ctrl::ctrlflds($_POST, array('last_name', 'first_name', 'email', 'nb_adulte')))
			// 		respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			// 	if($_POST['nb_adulte'] > 0){
			// 		respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Indiquez le nombre d\'adulte' : 'How much adult')));
			// 	}

			// 	$arr = array(
			// 		'annee' => date('Y'),
			// 		'id_organisateur' => max((int)$usrActif->cursoc, 1),
			// 		'codekey' => substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8),
			// 		'id_status_sec' => '1',
			// 		'civ_contact' => (int)$_POST['civ_contact'],
			// 		'first_name' => $_POST['first_name'],
			// 		'last_name' => $_POST['last_name'],
			// 		'tel1' => str_replace(' ' , '', $_POST['tel1']),
			// 		'email' => $_POST['email'],
			// 		'city' => $_POST['city'],
			// 		'date_update' => date('Y-m-d H:i:s'),
			// 		'date_create' => date('Y-m-d H:i:s')
			// 	);
			// 	$idclt = Fiche::create($arr);

			// 	if($idclt > 0){
			// 		for ($i=1; $i <= $_POST['idxtb'] ; $i++) { 
			// 			$arr = array(
			// 				'last_name_detail' => $_POST['n'.$i],
			// 				'first_name_detail' => $_POST['p'.$i],
			// 				'date_naissance_detail' => $_POST['d'.$i],
			// 				'type_detail' => $_POST['t'.$i],
			// 				'age' => $_POST['a'.$i],
			// 				'id_fiche' => $idclt,
			// 			);

			// 			Fiche::CreateDetails($arr);
			// 		}
			// 	}else{
			// 		respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Echec de la creation de la fiche' : 'Customer not created')));
			// 	}

			// 	$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			// 	$contact = Fiche::findOne(array('c.id_fiche'=>$idclt));
			// 	if($resInfmail){
			// 		Mailings::sendMail('mail-admin', (object)array(
			// 			'subject' => 'Nouvelle fiche d\'inscription',
			// 			'email' => $resInfmail->inf_username,
			// 			'msg' => 'Enregistrement d\une nouvelle fiche d\'inscription : <br>'.
			// 						($contact->civ_contact == 1 ? 'MONSIEUR' : 'MADAME').' '.$contact->last_name.' '.$contact->first_name.'<br>
			// 						Date : '.date('Y-m-d H:i:s')
			// 		));
			// 	}
				
			// 	respAjax::successJSON(array('OK' => 'OK', 'idct'=>$idclt, 'codekey'=>$contact->codekey, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription enregistrée et transmise' : 'Registration recorded and transmitted')));
			
			// }
			
			if (!Ctrl::ctrlflds($_POST, array('idct')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

				$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct']));
			if (!$ct)
				respAjax::errorJSON(array('message' => 'Contact introuvable'));

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
			$arrct['lnk_devis_signed'] = '1';

			
			$dirup = 'Dashboard/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			$doc = IsoPDFBuilder::BuildDevis($ct, $nodevis, $_POST['sign'], false);

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

			respAjax::successJSON(array('OK' => 'OK', 'doc' => 'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/'.$nm));
			break;

		
		case 'enreg-sign':
			// print_r($_POST);
			// die;
			if($_POST['type'] == 'I' || $_POST['type'] == 'A'){

				$obj = $_POST['obj'];
				$objopt = $_POST['objopt'];

				// echo('obj :'.print_r($_POST['obj']));
				if (!Ctrl::ctrlflds($_POST, array('date_birth'))  && isset($_POST['date_birth']))
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de naissance manquante ou invalide' : 'Missing date of birth or not valid')));

				
				if (!Ctrl::ctrlflds($_POST, array('last_name', 'first_name', 'email', 'nb_adulte',  'sign', 'date_start', 'date_end')))
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s) des champs obligatoires' : 'Missing data for required fields')));

				if((int)$_POST['nb_adulte'] <= 0){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Indiquez le nombre d\'adulte' : 'How much adult')));
				}

				if(strtotime($_POST['date_start']) > strtotime($_POST['date_end'])){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Verifier les dates' : 'Verify your dates')));
				}

				if((int)$_POST['date_start'] <= 0 || (int)$_POST['date_end'] <= 0 ){
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Verifier les dates' : 'Verify your dates')));
				}

				$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "RETOUR DEMANDE DEVIS" ', true,'');

				if($_POST['type'] == 'I'){
					$arr = array(
						'annee' => date('Y'),
						// 'inscript_auto' => '1',
						'id_organisateur' => (int)$_POST['idsej'],
						'lg' => $_POST['lg'],
						'lnk_devis' => '1',
						'lnk_devis_signed' => '1',
						// 'list_add_sejour' => (int)$_POST['list_add_sejour'],
						'id_status_sec' => $stsec->id_status_sec, //'12',
						'codekey' => substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8),
						'civ_contact' => (int)$_POST['civ_contact'],
						'first_name' => $_POST['first_name'],
						'last_name' => $_POST['last_name'],
						'tel1' => str_replace(' ' , '', $_POST['tel1']),
						'email' => $_POST['email'],
						'city' => $_POST['city'],
						'country' => $_POST['country'],
						'date_birth' => $_POST['date_birth'],
						'age_ct' => $_POST['agedb'],
						'date_start' => $_POST['date_start'],
						'date_end' => $_POST['date_end'],
						'nb_lit_bb_souhait' => $_POST['nb_lit_bb_souhait'],
						'terrasse_balcon_souhait' => $_POST['terrasse_balcon_souhait'],
						'time_start' => '10:00',
						'time_end' => '16:00',
						'date_update' => date('Y-m-d H:i:s'),
						'date_create' => date('Y-m-d H:i:s')
					);
					$idclt = Fiche::create($arr);

					// ajout du representant dans la table des details pour la liste complete et unifiee
					$arr = array();
					$arr = array(
						'last_name_detail' => $_POST['last_name'],
						'first_name_detail' => $_POST['first_name'],
						// 'date_naissance_detail' => $_POST['d'.$i],
						'date_naissance_detail' => $_POST['date_birth'],
						'age' => $_POST['agedb'],
						'type_detail' => '1',
						'sexe' => ((int)$_POST['civ_contact'] > 1 ? '2' : '1'),
						'id_fiche' => $idclt,
						'is_p'=>'1',
					);
					Fiche::CreateDetails($arr);

					if((int)$_POST['idListing'] > 0){
						$majCliListing = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idListing']));
						// print_r($majCliListing);
						if($majCliListing->list_add_sejour != ''){
							Fiche::update(array('list_add_sejour'=>($majCliListing->list_add_sejour.','.(int)$_POST['idsej'])),array('id_fiche'=>(int)$_POST['idListing']));
						}else{
							Fiche::update(array('list_add_sejour'=>(int)$_POST['idsej']),array('id_fiche'=>(int)$_POST['idListing']));
						}
					}
				}else{
					$resclt = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct']));
					$idclt = $resclt->id_fiche;
					if($_POST['type'] == 'A'){
						$arr = array(
							'annee' => date('Y'),
							// 'inscript_auto' => '1',
							'id_organisateur' => (int)$_POST['idsej'],
							'lnk_devis' => '1',
							'lnk_devis_signed' => '1',
							'id_status_sec' => $stsec->id_status_sec, //'12',
							// 'codekey' => substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8),
							'civ_contact' => (int)$_POST['civ_contact'],
							'first_name' => $_POST['first_name'],
							'last_name' => $_POST['last_name'],
							'tel1' => str_replace(' ' , '', $_POST['tel1']),
							'email' => $_POST['email'],
							'city' => $_POST['city'],
							'country' => $_POST['country'],
							'date_birth' => $_POST['date_birth'],
							'age_ct' => $_POST['agedb'],
							'date_start' => $_POST['date_start'],
							'date_end' => $_POST['date_end'],
							'nb_lit_bb_souhait' => $_POST['nb_lit_bb_souhait'],
							'terrasse_balcon_souhait' => $_POST['terrasse_balcon_souhait'],
							'time_start' => '10:00',
							'time_end' => '16:00',
							'date_update' => date('Y-m-d H:i:s'),
							'date_create' => date('Y-m-d H:i:s')
						);
						Fiche::update($arr, array('id_fiche'=>$idclt));

						// maj details du representant
						$arr = array();
						$arr = array(
							'last_name_detail' => $_POST['last_name'],
							'first_name_detail' => $_POST['first_name'],
							'date_naissance_detail' => $_POST['date_birth'],
							'age' => $_POST['agedb'],
							'type_detail' => '1',
							'sexe' => ((int)$_POST['civ_contact'] > 1 ? '2' : '1'),
						);
						Fiche::updateDetails($arr, array('id_fiche'=> $idclt, 'is_p'=>'1'));
					}
				}
				
				if($idclt > 0){
					$addArr = false;
					$addArrOpt = false;
					Fiche::DeleteDetails(array('id_fiche'=> $idclt, 'is_p'=>'0'));
					Fiche::DeleteDetailsOPtions(array('id_fiche'=> $idclt, 'id_sejour'=>$_POST['idsej']));
					$resenf = Tarif::getEnfant();
					$resbb = Tarif::getBb();

					$enf = 0;
					$bb = 0;
					$ad = 0;
					
					foreach($obj as $k=>$v) { 
						$arr = array();
						
						foreach ($v as $key => $value) {
							
							if(substr($key,0,1) == 'n'){
								$arr['last_name_detail'] = $value;
							}
							if(substr($key,0,1) == 'p'){
								$arr['first_name_detail'] = $value;
							}
							if(substr($key,0,1) == 'd'){
								$arr['date_naissance_detail'] = $value;
							}
							// if(substr($key,0,1) == 't'){
							// 	$arr['type_detail'] = $value;
							// }
							if(substr($key,0,1) == 'a'){
								if(trim($value) == '+' || trim($value) == '>'){
									$value = 18;
								}
								
								$arr['age'] = $value;

								if($value >= ($resbb->age_bb + 1) && $value <= $resenf->age_enfant){
									$arr['type_detail'] = 2;
								}
					
								if($value <= $resbb->age_bb){
									$arr['type_detail'] = 3;
								}
					
								if($value >= $resenf->age_enfant){
									$arr['type_detail'] = 1;
								}
							}
							if(substr($key,0,1) == 's'){
								$arr['sexe'] = $value;
							}
							
							$arr['id_fiche'] = $idclt;
							$addArr = true;
						}
						if($addArr){
							Fiche::CreateDetails($arr);

							// ajout des informations enfants dans le kidsclub
							// si la configuration est bien faite il ne peut pas y avoir > 1 ligne de resultat. Pour eviter toutes erreurs on limit
							$isGrps = Groupes::genericSql($arr['age'].' BETWEEN age_deb AND age_end AND id_genre IN (0,'.$arr['sexe'].') ', true);
							// error_log('retour groupe'.print_r($isGrps));
							if((int)$isGrps->id_groupe > 0 ){
								Enfants::create(array('last_name'=>$arr['last_name_detail'], 'first_name'=>$arr['first_name_detail'],
														'age'=>$arr['age'], 'tel_pere'=>$_POST['tel1'], 'id_groupe'=>(int)$isGrps->id_groupe,
														'date_arrivee'=>$_POST['date_start'], 'date_depart'=>$_POST['date_end'],'id_genre'=>(int)$arr['sexe'],
														'id_sejour'=>(int)$_POST['idsej']));
							}
							
						}
						$addArr = false;
					}


					foreach($objopt as $kopt=>$vopt) { 
						$arropt = array();
						$qteopt = 0;
						$mtopt = 0;
						
						foreach ($vopt as $keyopt => $valueopt) {
							
							if(substr($keyopt,0,1) == 'o'){
								$arropt['id_lib_option'] = $valueopt;
								$lib = Tarif::findOne(array('id_tarif'=>$valueopt));
								$arropt['lib_detail_option'] = $lib->libelle_tarif;
								$arropt['tarif_detail_option'] = $lib->age_tarif;
								$arropt['id_groupe'] = $lib->id_groupe;
								$mtopt = (float)$lib->age_tarif;
								// echo($lib->age_tarif.' -- '.$mtopt);
							}
							if(substr($keyopt,0,1) == 'q'){
								$arropt['qte_detail_option'] = $valueopt;
								$qteopt = (int)$valueopt;
							}
							
							$addArrOpt = true;
						}
						
						$arropt['tot_tarif_option'] = ($qteopt * $mtopt);
						$arropt['id_fiche'] = $idclt;
						$arropt['id_sejour'] = $_POST['idsej'];
						
						if($addArrOpt){
							Fiche::CreateDetailsOptions($arropt);
						}
						$addArrOpt = false;
					}
					
					
				}else{
					respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Echec de la creation de la fiche' : 'Customer not created')));
				}

				$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
				$contact = Fiche::findOne(array('c.id_fiche'=>$idclt));
				if($resInfmail){
					Mailings::sendMail('mail-admin', (object)array(
						'subject' => 'Nouvelle fiche d\'inscription',
						'email' => $resInfmail->inf_username,
						'msg' => 'Enregistrement d\une nouvelle fiche d\'inscription : <br>'.
									($contact->civ_contact == 1 ? 'MONSIEUR' : 'MADAME').' '.$contact->last_name.' '.$contact->first_name.'<br>
									FICHE NUMERO : '.$contact->id_fiche.'<br>
									<a href="'.$PUBURL.'/Dashboard/fiche.php?id_fiche='.$contact->id_fiche.'">ACCES DIRECT</a><br>
									Date : '.date('d/m/Y H:i:s')
					));
				}

				// creation du document
				$ct = Fiche::findOne(array('c.id_fiche' => (int)$idclt));
				if (!$ct)
					respAjax::successJSON(array('OK' => 'OK', 'idct'=>$idclt , 'signeval' => $filename, 'codekey'=>$contact->codekey, 
											'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription enregistrée et transmise<br>Mais document non créé' : 'Registration recorded and transmitted<br>But Document not create')));

				$arrct = array();
				
				if($_POST['isSignature'] == '0'){
					$encoded_image = explode(",", $_POST['sign'])[1];
					$decoded_image = base64_decode($encoded_image);
					$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';
	
					// die($filename);
					if(!is_dir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche)){
						mkdir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche, 0777);
					}
	
					file_put_contents(__DIR__ . '/'.$filename, $decoded_image);

				}else{
					$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';
					if(!is_dir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche)){
						mkdir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche, 0777);
					}

					copy(__DIR__.'/img/devis_gratuit.jpeg', __DIR__.'/'.$filename);
	
				}

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

				$doc = IsoPDFBuilder::BuildInscriptContrat($ct, $nodevis, $filename, false, $_POST['type'], $_POST['periode'], $ct->lg);

				// echo('**'.$doc);
				$nm = substr($doc,strripos($doc, '/') + 1);
				$nm = substr($nm, 0,strpos($nm,'?'));

				$nameDoc = Doc::findOne(array('name_doc'=>$nm));



				if(!$nameDoc){
					$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'9', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));

				}else {
					Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));

					$iddoc = $nameDoc->id_doc;
				}

				Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche));
				
				respAjax::successJSON(array('OK' => 'OK', 'idct'=>$idclt , 'doc'=>$nm, 'signeval' => $filename, 
										'idNewClt'=>(int)$idNewClt, 'list_add_sejour'=>((int)$idNewClt > 0 ? $majCliListing->list_add_sejour : '0'),
										'codekey'=>$contact->codekey, 
										'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Inscription enregistrée et transmise' : 'Registration recorded and transmitted')));
			
			}

			
			if (!Ctrl::ctrlflds($_POST, array('idct', 'codekey', 'sign')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct'], 'c.codekey' => $_POST['codekey']));
			if (!$ct)
				respAjax::errorJSON(array('message' => 'Données invalides'));


			if($_POST['isSignature'] == '0'){
				$encoded_image = explode(",", $_POST['sign'])[1];
				$decoded_image = base64_decode($encoded_image);
				$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';

				// die($filename);
				if(!is_dir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche)){
					mkdir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche, 0777);
				}

				file_put_contents(__DIR__ . '/'.$filename, $decoded_image);
			}else{
				$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';
				if(!is_dir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche)){
					mkdir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche, 0777);
				}

				copy(__DIR__.'/img/devis_gratuit.jpeg', __DIR__.'/'.$filename);
			}

			respAjax::successJSON(array('OK' => 'OK', 'signeval' => $filename));
			break;

		case 'down-contrat':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'type')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			// creation du document
			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct']));
			if (!$ct)
				respAjax::successJSON(array('OK' => 'OK', 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Télechargement impossible' : 'Error download')));

			$arrct = array();

			$dirup = __DIR__ . '/Dashboard/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			if($_POST['type'] == 'C'){
				$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-manu_'.$ct->id_fiche.'.png';			
			}else{
				$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';			
			}
			

			$doc = IsoPDFBuilder::BuildInscriptContrat($ct, '', $filename, false, $_POST['type'], $_POST['periode'], $ct->lg);
			
			// echo('**'.$doc);
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));
			
			$nameDoc = Doc::findOne(array('name_doc'=>$nm));
			// echo($doc);
			// die;


			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'1', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));

			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));

				$iddoc = $nameDoc->id_doc;
			}

			Fiche::update($arrct,array('id_fiche'=>$ct->id_fiche));

			respAjax::successJSON(array('OK' => 'OK', 'idct'=>$ct->id_fiche , 'doc'=>'/Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/'.$nm, 'codekey'=>$contact->codekey, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléchargement effectuée' : 'Downloaded')));

			break;
			
		case 'enreg-sign-manuscrite':
			// die(print_r($_POST));

			if (!Ctrl::ctrlflds($_POST, array('idct', 'codekey', 'sign')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			Fiche::update(array('date_contrat_signed'=>date('Y-m-d')),array('id_fiche'=>(int)$_POST['idct'], 'codekey' => $_POST['codekey']));

			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct'], 'c.codekey' => $_POST['codekey']));
			if (!$ct)
				respAjax::errorJSON(array('message' => 'Données invalides'));


			$encoded_image = explode(",", $_POST['sign'])[1];
			$decoded_image = base64_decode($encoded_image);
			$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-manu_'.$ct->id_fiche.'.png';

			// die($filename);
			if(!is_dir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche)){
				mkdir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche, 0777);
			}

			file_put_contents(__DIR__ . '/'.$filename, $decoded_image);

			$dirup = __DIR__ . '/Dashboard/uploads/';

			$dir = $dirup . $ct->codekey.$_POST['idct'];
			if (!is_dir($dir)) {
				mkdir($dir);
				copy($dirup . 'index.php', $dir . '/index.php');
			}

			$doc = IsoPDFBuilder::BuildInscriptContrat($ct, '', $filename, false, $_POST['type'], $_POST['periode'], $ct->lg);

			// echo('**'.$doc);
			$nm = substr($doc,strripos($doc, '/') + 1);
			$nm = substr($nm, 0,strpos($nm,'?'));

			$nameDoc = Doc::findOne(array('name_doc'=>$nm));



			if(!$nameDoc){
				$iddoc = Doc::create(array('date_doc'=> date('Y-m-d H:i:s'), 'id_fiche'=>$ct->id_fiche, 'id_type_doc'=>'9', 'name_doc'=>$nm,'id_usrApp' => $usrActif->id_usrApp));

			}else {
				Doc::update(array('date_doc'=> date('Y-m-d H:i:s'), 'id_usrApp' => $usrActif->id_usrApp),array('id_doc'=>$nameDoc->id_doc));

				$iddoc = $nameDoc->id_doc;
			}

			
			$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "INSCRIPTION SIGNE" ', true,'');
			Fiche::update(array('lnk_contrat_signed'=>'1','id_status_sec' => $stsec->id_status_sec),array('id_fiche'=>$ct->id_fiche));
			
			// mise a jour du kids club
			$alldetails = Fiche::getAllDetailsOptions(array('id_fiche'=>$ct->id_fiche));
			foreach($alldetails as $det){
				if($det['qte_detail_option'] > 0 && $det['id_groupe'] > 0){
					// $grp = QueryExec::querySQL('SELECT id_groupe FROM db_groupes WHERE id_groupe = '.$det['id_groupe'], true, '');
					Enfants::create(array('id_sejour'=>$ct->id_organisateur, 'date_arrivee'=>$ct->date_start, 'date_depart'=>$ct->date_end, 
										'last_name'=>$ct->last_name, 'tel_pere'=>$ct->tel1, 'tel_mere'=>$ct->tel1, 'id_groupe'=>$det['id_groupe']));
				}
			}

			/********************* VERSION PAR AGE ***************************/
			/*
			$alldetails = Fiche::getAllDetails(array('id_fiche'=>$ct->id_fiche));
			foreach($alldetails as $det){
				if($det['age'] <= 2 && $det['type_detail'] != '1'){
					$grp = QueryExec::querySQL('SELECT id_groupe FROM db_groupes WHERE '.$det['age'].' BETWEEN age_deb AND age_end', true, '');
					Enfants::create(array('age'=>$det['age'], 'id_sejour'=>$ct->id_organisateur, 'date_arrivee'=>$ct->date_start, 'date_depart'=>$ct->date_end, 
										'id_genre'=>$det['sexe'],'last_name'=>$det['last_name_detail'], 'first_name'=>$det['first_name_detail'], 'tel_pere'=>$ct->tel1, 
										'tel_mere'=>$ct->tel1, 'id_groupe'=>$grp->id_groupe));
				}

				if($det['age'] >= 3 && $det['age'] <= 5 && $det['type_detail'] != '1'){
					$grp = QueryExec::querySQL('SELECT id_groupe FROM db_groupes WHERE '.$det['age'].' BETWEEN age_deb AND age_end', true, '');
					Enfants::create(array('age'=>$det['age'], 'id_sejour'=>$ct->id_organisateur, 'date_arrivee'=>$ct->date_start, 'date_depart'=>$ct->date_end, 
										'id_genre'=>$det['sexe'],'last_name'=>$det['last_name_detail'], 'first_name'=>$det['first_name_detail'], 'tel_pere'=>$ct->tel1, 
										'tel_mere'=>$ct->tel1, 'id_groupe'=>$grp->id_groupe));
				}

				if($det['age'] >= 6 && $det['age'] <= 11 && $det['type_detail'] != '1'){
					$grp = QueryExec::querySQL('SELECT id_groupe FROM db_groupes WHERE id_genre = '.$det['sexe'].' AND '.$det['age'].' BETWEEN age_deb AND age_end', true, '');
					Enfants::create(array('age'=>$det['age'], 'id_sejour'=>$ct->id_organisateur, 'date_arrivee'=>$ct->date_start, 'date_depart'=>$ct->date_end, 
										'id_genre'=>$det['sexe'],'last_name'=>$det['last_name_detail'], 'first_name'=>$det['first_name_detail'], 'tel_pere'=>$ct->tel1, 
										'tel_mere'=>$ct->tel1, 'id_groupe'=>$grp->id_groupe));
				}
			}
			*/

			
			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			if($resInfmail){
				Mailings::sendMail('mail-admin', (object)array(
					'subject' => 'Nouveau contrat',
					'email' => $resInfmail->inf_username,
					'msg' => 'Enregistrement d\'un nouveau contrat : <br>'.
								($ct->civ_contact == 1 ? 'MONSIEUR' : 'MADAME').' '.$ct->last_name.' '.$ct->first_name.'<br>
								FICHE NUMERO : '.$ct->id_fiche.'<br>
								<a href="'.$PUBURL.'/Dashboard/fiche.php?id_fiche='.$ct->id_fiche.'">ACCES DIRECT</a><br>
								Date : '.date('d/m/Y H:i:s')
				));
			}
			
			$soc = Soc::findOne(array('is_soc'=>'1'));
			$sejour = Setting::getOrganisateur(array('id_organisateur'=>$ct->id_organisateur));

			if($resInfmail){
				if($ct->lg == 'FR'){

					Mailings::sendMail('mail-contact', (object)array(
						'subject' => 'Contrat du séjour',
						'email' => $ct->email,
						'msg' => 'Bonjour,<br>'.($ct->civ_contact == 1 ? 'MONSIEUR' : 'MADAME').' '.$ct->last_name.' '.$ct->first_name.'<br>'
									.$soc->name_soc.', vous remercie de votre confiance <br>
									Vous trouverez ci-joint votre copie du contrat signé.
									<br>
									<br>
									Nous restons a votre disposition pour toutes informations aux coordonnées ci-dessous : <br>'
									.$soc->tel_soc.'<br>'
									.$soc->email_soc.'<br>
									et vous souhaite un agréable séjour.<br>
									Cordialement<br>',
						'doc'=> array($dirup.$ct->codekey.$ct->id_fiche.'/'.$nm)
					));
				}else{
					Mailings::sendMail('mail-contact', (object)array(
						'subject' => 'Registration of stay',
						'email' => $ct->email,
						'msg' => 'Hi,<br>'.($ct->civ_contact == 1 ? 'Sir' : 'Mrs').' '.$ct->last_name.' '.$ct->first_name.'<br>'
									.$soc->name_soc.', thank you for your trust <br>
									You will find attached your copy of the signed contract
									<br>
									<br>
									We remain at your disposal for any information at the coordinates below. : <br>'
									.$soc->tel_soc.'<br>'
									.$soc->email_soc.'<br>
									and wish you a pleasant stay.<br>
									Cordially<br>',
						'doc'=> array($dirup.$ct->codekey.$ct->id_fiche.'/'.$nm)
					));
				}
			}
			
			respAjax::successJSON(array('OK' => 'OK', 'doc'=>'/Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/'.$nm, 'signmanu' => $filename, 'idct'=>$ct->id_fiche , 'signeval' => $filename, 'codekey'=>$ct->codekey, 'message'=>($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Contrat enregistrée et transmise' : 'Contract recorded and transmitted')));
		
			break;

	
    }
}

