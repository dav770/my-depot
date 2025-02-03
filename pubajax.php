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

		case 'dspl-inf':
			if (!Ctrl::ctrlflds($_POST, array('idct', 'codekey', 'idsejour')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_POST['idct'], 'c.codekey'=>$_POST['codekey'], 'c.id_organisateur'=>(int)$_POST['idsejour']));
			echo('kk'.print_r($ct->id_fiche));
			if($ct){
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client introuvable' : 'Customer not exist')));
			}

			$ctdet = Fiche::getAllDetails(array('id_fiche'=>(int)$_POST['idct']));

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

				// verification si suppression elements avant envoi

				if(in_array($i, $nbelement)){
					$arrct['first_name_detail'] = $_POST['addnom'.$i];
					$arrct['last_name_detail'] = $_POST['addprenom'.$i];
					$arrct['date_naissance_detail'] = $_POST['adddate'.$i]; 
					$dtn = $_POST['adddate'.$i]; 
	
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
			// die(print_r(__DIR__));
			// die(print_r($_POST));

			if (!Ctrl::ctrlflds($_POST, array('idct', 'codekey', 'sign')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idct'], 'c.codekey' => $_POST['codekey']));
			if (!$ct)
				respAjax::errorJSON(array('message' => 'Données invalides'));

			$encoded_image = explode(",", $_POST['sign'])[1];
			$decoded_image = base64_decode($encoded_image);
			$filename =  'Dashboard/uploads/'.$ct->codekey.$ct->id_fiche.'/sign-eval_'.$ct->id_fiche.'.png';

			// die($filename);
			if(!is_dir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche)){
				mkdir('Dashboard/uploads/'.$ct->codekey.$ct->id_fiche, 0777);
			}

			file_put_contents(__DIR__ . '/'.$filename, $decoded_image);

			respAjax::successJSON(array('OK' => 'OK', 'signeval' => $filename));
			break;

			
		case 'enreg-sign-manuscrite':
			// die(print_r(__DIR__));

			if (!Ctrl::ctrlflds($_POST, array('idc', 'codekey', 'sign')))
				respAjax::errorJSON(array('message' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Donnée(s) manquante(s)' : 'Missing data')));

			$ct = Fiche::findOne(array('c.id_fiche' => (int)$_POST['idc'], 'c.codekey' => $_POST['codekey']));
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

			respAjax::successJSON(array('OK' => 'OK', 'signmanu' => $filename));
			break;

	
    }
}

