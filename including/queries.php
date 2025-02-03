<?php

require __DIR__ . '/../libry/vendor/autoload.php';


class Cmd
{
	public static function getAllEnCours($conds='')
	{
		return QueryType::query('db_commandes', 'DISTINCT (num_cmd), id_fournisseur, id_sejour', $conds);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_commandes', '*', $conds);
	}

	public static function getAllDetails($conds='')
	{
		return QueryType::query('db_commandes c 
									INNER JOIN db_produits p ON p.id_produit = c.id_produit
									INNER JOIN db_fournisseurs f ON f.id_fournisseur = c.id_fournisseur
									INNER JOIN db_unites u ON u.id_unite = c.id_unite 
									INNER JOIN db_organisateurs s ON s.id_organisateur = c.id_sejour', 'c.val_qte, c.num_cmd, p.name_produit, u.name_unite, f.name_fournisseur, s.name_organisateur', $conds);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_commandes', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_commandes', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_commandes', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_commandes', $flds, $wh);
	}	

	public static function getLastNoCmd($conds='')
	{
		$res = QueryType::query('db_commandes', 'MAX(SUBSTR(num_cmd,5)) as MCMD', $conds, true);
		return $res && (int)$res->MCMD > 0 ? (int)$res->MCMD + 1 : 1;
	}
}

class Colors
{
	public static function getAll($conds='', $retour=false , $ordby = '')
	{
		return QueryType::query('db_colors', '*', $conds, $retour, $ordby);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_colors', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_colors', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_colors', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_colors', $flds, $wh);
	}	
}

class Cleaning
{
	public static function getAll($conds='', $retour=false , $ordby = '')
	{
		return QueryType::query('db_nettoyages', '*', $conds, $retour, $ordby);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_nettoyages', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_nettoyages', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_nettoyages', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_nettoyages', $flds, $wh);
	}	
}

class Fournisseurs
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_fournisseurs', '*', $conds);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_fournisseurs', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_fournisseurs', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_fournisseurs', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_fournisseurs', $flds, $wh);
	}	

}

class Tables
{
	public static function getAll($conds='', $retour=false , $ordby = '')
	{
		return QueryType::query('db_tables', '*', $conds, $retour, $ordby);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_tables', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_tables', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_tables', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_tables', $flds, $wh);
	}	
		
	public static function MaxNumTable($conds='') 
	{
		$res = QueryType::query('db_tables', 'MAX(num_table) as MNT', $conds, true);
		return ((int)$res->MNT > 0 ? $res->MNT : 0);
	}	
}

class TablesPlans
{
	public static function getAll($conds='', $retour=false , $ordby = '')
	{
		return QueryType::query('db_tables_plans tp LEFT OUTER JOIN db_contacts f ON tp.id_fiche = f.id_fiche', 'tp.*, f.last_name, f.first_name', $conds, $retour, $ordby);
	}

	public static function findOne($wh='')
	{
		return QueryType::query('db_tables_plans', '*', $wh, true);
	}

	public static function create($flds='')
	{
		return QueryType::insert('db_tables_plans', $flds);
	}

	public static function delete($flds='')
	{
		return QueryType::delete('db_tables_plans', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_tables_plans', $flds, $wh);
	}	
		
	public static function MaxNumTable($conds='') 
	{
		$res = QueryType::query('db_tables_plans', 'MAX(num_table) as MNT', $conds, true);
		return ((int)$res->MNT > 0 ? $res->MNT : 0);
	}	
		
	public static function MaxNumDiv($conds='') 
	{
		$res = QueryType::query('db_tables_plans', 'MAX(num_div) as MND', $conds, true);
		return ((int)$res->MND > 0 ? $res->MND : 0);
	}	
		
	public static function sqlSimple($wh='', $retourne=false) 
	{
		return QueryType::querySimple('db_tables_plans', '*', $wh, $retourne);
	}	

}

class TablesObjs
{
	public static function getAll($conds='', $retour=false , $ordby = '')
	{
		return QueryType::query('db_tables_objs', '*', $conds, $retour, $ordby);
	}

	public static function findOne($wh='')
	{
		return QueryType::query('db_tables_objs', '*', $wh, true);
	}

	public static function create($flds='')
	{
		return QueryType::insert('db_tables_objs', $flds);
	}

	public static function delete($flds='')
	{
		return QueryType::delete('db_tables_objs', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_tables_objs', $flds, $wh);
	}	
	
	public static function sqlSimple($wh='', $retourne=false) 
	{
		return QueryType::querySimple('db_tables_objs', '*', $wh, $retourne);
	}	

}

class Soc
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_socs', '*', $conds);
	}

	public static function findOne($wh='')
	{
		return QueryType::query('db_socs', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_socs', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_socs', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_socs', $flds, $wh);
	}	
}

class SMSType {

	public static function find($wh = '')
	{
		return QueryType::query('db_smstypes', '*', $wh);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_smstypes', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_smstypes', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_smstypes', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_smstypes', $flds, $wh);
	}	

	
	public static function replaceVars($id_fiche, $id_smstype) 
	{
		global $usrActif;

		
		$res = SMSType::findOne(array('id_smstype' => (int)$id_smstype));
		// successJSON->$errorJSON->errorJSON(array('OK' => 'OK', 'data' => $res));
		// break;
		$msg = $res->msg;
		$nameSMSType = $res->name_smstype;

		// $sets = (object)Setting::getGlobalSettings();
			$tb['UsrApp'] = UsrApp::findOne(array('id_usrApp' => $usrActif->id_usrApp));
		
			function formatDate($d){
				$arrDate = explode('-',$d);

				return $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
			}

			function formatTel($t){
				
				return trim(chunk_split($t, 2, ' '));
			}

			if ((int)$_POST['id_fiche'] > 0) {	
				
				$contact = Fiche::findOne(array('c.id_fiche' => (int)$id_fiche));		
				
				$UsrApp = UsrApp::findOne(array('id_usrApp' => $contact->id_usrApp));

				$soc = Soc::findOne(array('is_soc'=>'1'));


				$tb['contact'] = $contact;
				$tb['crm'] = $UsrApp;
				$tb['soc'] = $soc;

				
				$tel = '';

				$dest = $contact->email;
				
				$vars = VarsType::buildVars($usrActif);

				foreach($vars as $k => $v) {
					if($k == '$DEB' || $k == '$FIN' || $k == '$TEL' || $k == '$2TEL' || $k == '$CIVILITE' || $k == '$SOC'  || $k == '$ZIP_SOC'
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

						if($k == '$DEB'){
	
							$periode = formatDate($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $periode, $msg);
							$subject = str_replace($k, $periode, $subject);
						}
						
						if($k == '$FIN'){
	
							$periode = formatDate($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $periode, $msg);
							$subject = str_replace($k, $periode, $subject);
						}

						if($k == '$TEL'){
	
							$tel = formatTel($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $tel, $msg);
						}

						if($k == '$2TEL'){
							$tel = '';
							$tel = formatTel($tb[$v['table']]->{$v['field']});			
							
							$msg = str_replace($k, $tel, $msg);
						}

						if($k == '$CRMTEL'){
							// error_log('tel form'. $tb[$v['table']]->{$v['field']}. ' ---- '.$v['table'].' ---- '.$v['field']);
							$tel = '';
							$tel = formatTel($tb[$v['table']]->{$v['field']});			
							
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
					}
				}
			}
		
		return array('data'=> $res, 'msg'=> $msg);
	}
}

class SMS
{
	public static function SendMessage($txt, $fullnum)
	{
		global $usrActif;

		$resapi = API::findOne(array('id_sejour'=>$usrActif->cursoc));

		// Récupérez les données envoyées depuis l'appel AJAX
		$phoneNumber = $_POST['num'] ?? null;
		$message = $_POST['msg'] ?? null;
	
		// Vérifiez les données nécessaires
		if (empty($phoneNumber) || empty($message)) {
			echo json_encode([
				'responseAjax' => 'ERROR',
				'message' => 'Le numéro ou le message est vide.'
			]);
			exit;
		}
	
		// Vos credentials API ClickSend
		$username = $resapi->sms_user_api; //'your_username';
		$apiKey = $resapi->sms_key_api; //'your_api_key';
	
		// Données à envoyer
		$data = [
			'messages' => [
				[
					'source' => 'php',
					'from' => $resapi->sms_from_api, //'YourName',
					'body' => $message,
					'to' => $phoneNumber
				]
			]
		];
	
		// Requête cURL vers l'API ClickSend
		$ch = curl_init('https://rest.clicksend.com/v3/sms/send');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Basic ' . base64_encode("$username:$apiKey")
		]);
	
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
		if (curl_errno($ch)) {
			echo json_encode([
				'responseAjax' => 'ERROR',
				'message' => 'Erreur cURL : ' . curl_error($ch)
			]);
		} else {
			if ($httpCode == 200) {
				echo json_encode([
					'responseAjax' => 'SUCCESS',
					'message' => 'SMS envoyé avec succès.'
				]);
			} else {
				echo json_encode([
					'responseAjax' => 'ERROR',
					'message' => 'Erreur lors de l\'envoi du SMS : ' . $response
				]);
			}
		}
	
		curl_close($ch);
	}

}

class Imap
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_mails m 
								LEFT JOIN db_mails_pjs pj ON m.id_mail = pj.id_mail', 
								'm.*, pj.name_pj', $conds);
	}

	public static function findOne($conds='')
	{
		return QueryType::query('db_mails', '*', $conds, true);	
	}
	
	public static function update($flds, $conds)
	{
		return QueryType::update('db_mails', $flds, $conds);
	}

	public static function create($conds)
	{
		return QueryType::insert('db_mails',$conds);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_mails',$conds);
	}
}

class Pj
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_mails_pjs', '*', $conds);
	}

	public static function findOne($conds='')
	{
		return QueryType::query('db_mails_pjs', '*', $conds, true);	
	}
	
	public static function update($flds, $conds)
	{
		return QueryType::update('db_mails_pjs', $flds, $conds);
	}

	public static function create($conds)
	{
		return QueryType::insert('db_mails_pjs',$conds);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_mails_pjs',$conds);
	}

}

class InfosGenes
{
	public static function findOne($conds)
	{
		return QueryType::query('db_infos_generales', '*', $conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_infos_generales', '*', $conds);
	}

	public static function update($flds, $conds)
	{
		return QueryType::update('db_infos_generales', $flds, $conds);
	}

	public static function create($conds)
	{
		return QueryType::insert('db_infos_generales',$conds);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_infos_generales',$conds);
	}

	/*------ infos mails --------*/
	public static function findOneMail($conds)
	{
		return QueryType::query('db_infos_emails', '*', $conds, true);
	}

	public static function getAllMail($conds='')
	{
		return QueryType::query('db_infos_emails', '*', $conds);
	}

	public static function updateMail($flds, $conds)
	{
		return QueryType::update('db_infos_emails', $flds, $conds);
	}

	public static function createMail($conds)
	{
		return QueryType::insert('db_infos_emails',$conds);
	}

	public static function deleteMail($conds)
	{
		return QueryType::delete('db_infos_emails',$conds);
	}

	public static function mailSql($sql, $retourne=false)
	{
		return QueryExec::querySQL($sql, $retourne);
	}

	/*------ infos banques -------*/
	public static function findOneBq($conds)
	{
		return QueryType::query('db_infos_banques', '*', $conds, true);
	}

	public static function getAllBq($conds='')
	{
		return QueryType::query('db_infos_banques', '*', $conds);
	}

	public static function updateBq($flds, $conds)
	{
		return QueryType::update('db_infos_banques', $flds, $conds);
	}

	public static function createBq($conds)
	{
		return QueryType::insert('db_infos_banques',$conds);
	}

	public static function deleteBq($conds)
	{
		return QueryType::delete('db_infos_banques',$conds);
	}
}

class Tarif
{
	public static function findOne($conds)
	{
		return QueryType::query('db_tarifs', '*', $conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_tarifs', '*', $conds);
	}

	public static function update($flds, $conds)
	{
		return QueryType::update('db_tarifs', $flds, $conds);
	}

	public static function create($conds)
	{
		return QueryType::insert('db_tarifs',$conds);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_tarifs',$conds);
	}

	/* -------- AGE TARIFS ---------- */
	public static function getAllAge($conds='')
	{
		return QueryType::query('db_ages_tarifs', '*', $conds);
	}
	
	public static function updateAge($flds, $conds)
	{
		return QueryType::update('db_ages_tarifs', $flds, $conds);
	}

	public static function createAge($conds)
	{
		return QueryType::insert('db_ages_tarifs',$conds);
	}

	public static function deleteAge($conds)
	{
		return QueryType::delete('db_ages_tarifs',$conds);
	}

	public static function getAdulte($conds='')
	{
		return QueryType::query('db_ages_tarifs', 'age_adulte', $conds, true);
	}
	public static function getEnfant($conds='')
	{
		return QueryType::query('db_ages_tarifs', 'age_enfant', $conds, true);
	}
	public static function getBb($conds='')
	{
		return QueryType::query('db_ages_tarifs', 'age_bb', $conds, true);
	}

	/* --------- Transports ------------ */
	public static function findOneTransport($conds)
	{
		return QueryType::query('db_transports', '*', $conds, true);
	}

	public static function getAllTransport($conds='')
	{
		return QueryType::query('db_transports', '*', $conds);
	}

	public static function updateTransport($flds, $conds)
	{
		return QueryType::update('db_transports', $flds, $conds);
	}

	public static function createTransport($conds)
	{
		return QueryType::insert('db_transports',$conds);
	}

	public static function deleteTransport($conds)
	{
		return QueryType::delete('db_transports',$conds);
	}

	/* --------- Contacts Transports Details ------------ */
	public static function totSumTransport($conds)
	{
		return QueryType::query('db_contacts_transports_details', 'COALESCE(SUM(tarif_transport_detail),0) as Mt', $conds, true);
	}
}

class Search
{
	public static function getSearch($txt, $usrActif)
	{
		$wh = '';
		if((int)$txt > 0){
			$wh = " WHERE (c.tel1 LIKE '".$txt."%' OR c.tel2 LIKE '".$txt."%' OR c.post_code LIKE '".$txt."%' OR c.id_fiche = ".$txt.") ";
		}else{
			$wh = " WHERE (c.raison_sociale LIKE'%".$txt."%' OR c.first_name LIKE'%".$txt."%' OR c.last_name LIKE'%".$txt."%' OR c.email LIKE'%".$txt."%' OR c.tel1 LIKE '".$txt."%' OR c.tel2 LIKE '".$txt."%' OR c.post_code LIKE '".$txt."%' )";
		}
		
		
		$sql = "SELECT REQ.* FROM (
					SELECT c.id_fiche as id, CONCAT(c.raison_sociale, ' ' ,c.first_name, ' ', c.last_name) as name, c.tel1, c.tel2, c.adr1, u.user_name,
					c.post_code, c.city, c.email, c.id_fiche,st.name_status_sec
					FROM db_contacts c
						LEFT JOIN db_users u ON u.id_usrApp = c.id_usrApp
						LEFT JOIN db_status_secs st ON st.id_status_sec = c.id_status_sec
					".$wh." AND c.id_organisateur = ".$usrActif->cursoc ." GROUP BY c.id_fiche 										
				) REQ
				LIMIT 0, 10";

		return QueryExec::querySQL($sql, false, '1');
	}
}

class GeneSql
{
	public static function genericSql($tb, $flds, $conds)
	{
		return QueryType::querySimple($tb, $flds, $conds);
	}
}


class Enfants
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_enfants', '*', $conds);
	}

	public static function findQuery($conds='', $retour = false)
	{
		return QueryType::querySimple('db_enfants', '*', $conds, $retour);
	}

	public static function findOne($conds='')
	{
		return QueryType::query('db_enfants', '*',$conds, true);
	}
	
	public static function create($flds)
	{
		return QueryType::insert('db_enfants', $flds);
	}
	
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_enfants', $flds, $wh);
	}
	
	public static function delete($conds)
	{
		return QueryType::delete('db_enfants', $conds);
	}
}

class Groupes
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_groupes', '*', $conds);
	}

	public static function findQuery($conds='', $retour = false)
	{
		return QueryType::querySimple('db_groupes', '*', $conds, $retour);
	}

	
	public static function findOne($conds='')
	{
		return QueryType::query('db_groupes', '*',$conds, true);
	}
	
	public static function genericSql($Whs, $retourne=false)
	{
		return QueryType::querySimple('db_groupes', '*', $Whs, $retourne);
	}
}

class Monos
{
	public static function findOne($conds)
	{
		return QueryType::query('db_monos m 
								LEFT JOIN db_groupes g ON m.id_groupe = g.id_groupe
								LEFT JOIN db_enfants e ON e.id_groupe = m.id_groupe', 
							'm.*, e.last_name, e.first_name, g.name_groupe', 
							$conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_monos', '*',$conds);
	}
}

class Activites
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_activites', '*',$conds);
	}

	public static function findOne($conds='')
	{
		return QueryType::query('db_activites', '*',$conds, true);
	}
}

class Plans
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_rdv r 
								LEFT JOIN db_monos m ON m.id_mono = r.id_mono
								LEFT JOIN db_enfants e ON e.id_groupe = m.id_groupe
								LEFT JOIN db_groupes g ON g.id_groupe = m.id_groupe
								LEFT JOIN db_activites a ON a.id_activite = r.id_activite', 
							'r.*, e.last_name, e.first_name, g.name_groupe, a.name_activite', 
							$conds);
	}

	public static function tabTime($conds='')
	{
		return QueryType::querySimple('db_enfants', '*', $conds, $retour);
	}

	public static function empTime($conds='', $pred1='', $pred2='')
	{
		return QueryType::querySimple(' `db_enfants` e 
		LEFT OUTER JOIN db_groupes g on e.id_groupe = g.id_groupe
		LEFT OUTER JOIN db_monos m on m.id_groupe = g.id_groupe
		LEFT OUTER JOIN db_postes p on m.poste = p.id_poste
		LEFT OUTER JOIN db_rdv r on r.id_groupe = g.id_groupe AND r.date_rdv BETWEEN "'.$pred1.'" AND "'.$pred2.'"
		LEFT OUTER JOIN db_activites a on a.id_activite = r.id_activite',
		"count(concat(e.last_name,' ' ,e.first_name)) as tot, GROUP_CONCAT(
			e.last_name,' ',e.first_name,
			' : ',
			e.age,
			' ans' SEPARATOR '<br><hr>'
		) AS enfants,
		g.name_groupe,
		r.lieu_rdv,
		a.name_activite,
		GROUP_CONCAT(DISTINCT
			m.last_name,' ',m.first_name,
			' : ',
			p.name_poste SEPARATOR '<br><hr>'
		) AS monos",
		$conds);
	}
}

class Leads
{

	public static function getAll($conds='')
	{
		return QueryType::query('db_leads', '*',$conds);
	}	

	public static function create($flds)
	{
		return QueryType::insert('db_leads', $flds);
	}
	
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_leads', $flds, $wh);
	}
	
	public static function updateSimple($flds, $wh) 
	{
		return QueryType::updateSimple('db_leads', $flds, $wh);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_leads', $conds);
	}
}

class Extra
{

	public static function findOne($conds='')
	{
		return QueryType::query('db_extra_activites', '*',$conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_extra_activites', '*',$conds);
	}	

	public static function create($flds)
	{
		return QueryType::insert('db_extra_activites', $flds);
	}
	
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_extra_activites', $flds, $wh);
	}
	
	public static function updateSimple($flds, $wh) 
	{
		return QueryType::updateSimple('db_extra_activites', $flds, $wh);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_extra_activites', $conds);
	}
	
	public static function soldeExtra($sql, $retourne=false)
	{
		return QueryExec::querySQL($sql, $retourne);
	}
}

class ExtraRglt
{

	public static function findOne($conds='')
	{
		return QueryType::query('db_extra_rglts', '*',$conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_extra_rglts', '*',$conds);
	}	

	public static function create($flds)
	{
		return QueryType::insert('db_extra_rglts', $flds);
	}
	
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_extra_rglts', $flds, $wh);
	}
	
	public static function updateSimple($flds, $wh) 
	{
		return QueryType::updateSimple('db_extra_rglts', $flds, $wh);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_extra_rglts', $conds);
	}
}

class Bar
{
	public static function findOne($conds='')
	{
		return QueryType::query('db_bars', '*',$conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_bar', '*',$conds);
	}

	public static function soldeBar($sql, $retourne=false)
	{
		return QueryExec::querySQL($sql, $retourne);
	}
	
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_bar', $flds, $wh);
	}
}

class Fiche
{
	public static function checkRight($ct)
	{
		global $usrActif;
		
		if (!isset($usrActif) || !$usrActif || (int)$usrActif->id_profil == 0 || !$ct)
			return false;
		
		return true;
	}

	
	public static function findOne($conds)
	{
		return QueryType::query('db_contacts c 
								LEFT JOIN db_users u ON u.id_usrApp = c.id_usrApp', 
							'c.*, u.id_equipe, u.user_name, u.tel', 
							$conds, true);
	}

	
	public static function find($conds)
	{
		return QueryType::query('db_contacts c 
								LEFT JOIN db_users u ON u.id_usrApp = c.id_usrApp
								LEFT JOIN db_status_secs sc ON sc.id_status_sec = c.id_status_sec', 
							'c.*, u.id_equipe, sc.cancel_update_team', 
							$conds);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_contacts', '*',$conds);
	}
	
	
	public static function findDoublonTel($tel1, $tel2)
	{
		return QueryType::querySimple('db_contacts', '*', "tel1 LIKE '%".$tel1."%' 
														OR tel2 LIKE '%".$tel1."%' "
														.($tel2 != '' ? "
														OR tel1 LIKE '%".$tel2."%'
														OR tel2 LIKE '%".$tel2."%'" : '')."
														OR '".$tel1."' LIKE CONCAT('%', tel1, '%') AND tel1 <> '')
														OR ('".$tel1."' LIKE CONCAT('%', tel2, '%') AND tel2 <> '' AND tel2 <> '0') "
														.($tel2 != '' ? "
														OR '".$tel2."' LIKE CONCAT('%', tel1, '%')  AND tel1 <> '')
														OR ('".$tel2."' LIKE CONCAT('%', tel2, '%') AND tel2 <> '' AND tel2 <> '0') " : ''), true);
	}
	
	public static function create($flds)
	{
		return QueryType::insert('db_contacts', $flds);
	}
	
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_contacts', $flds, $wh);
	}
	
	public static function updateSimple($flds, $wh) 
	{
		return QueryType::updateSimple('db_contacts', $flds, $wh);
	}

	public static function delete($conds)
	{
		return QueryType::delete('db_contacts', $conds);
	}

	public static function getLastNoDevis($conds)
	{
		$res = QueryType::query('db_contacts', 'MAX(nodevis) as MDEVIS', $conds, true);
		return $res && (int)$res->MDEVIS > 0 ? (int)$res->MDEVIS : 0;
	}

	public static function getLastNoFac($conds)
	{
		$res = QueryType::query('db_contacts', 'MAX(nofac) as MFAC', $conds, true);
		// die('===>'.print_r($res));
		return $res && (int)$res->MFAC > 0 ? (int)$res->MFAC : 0;
	}
	
	public static function findOneDetails($conds)
	{
		return QueryType::query('db_contacts_details cd 
								LEFT JOIN db_contacts c ON c.id_fiche = cd.id_fiche', 
							'cd.*, c.id_organisateur', 
							$conds, true);
	}
	
	public static function getAllCliDetails($conds)
	{
		return QueryType::query('db_contacts_details cd 
								LEFT JOIN db_contacts c ON c.id_fiche = cd.id_fiche', 
							'cd.*, c.last_name, c.first_name, c.tel1, c.id_organisateur', 
							$conds, false);
	}

	public static function getAllDetails($conds=''){
		return QueryType::query('db_contacts_details', '*', $conds, false, 'is_p DESC, age DESC');
	}

	public static function getCountDetails($conds=''){
		return QueryType::query('db_contacts_details', 'COUNT(*), type_detail', $conds, 'type_detail','type_detail');
	}
	
	public static function updateDetails($flds, $wh) 
	{
		return QueryType::update('db_contacts_details', $flds, $wh);
	}
	
	public static function CreateDetails($flds)
	{
		return QueryType::insert('db_contacts_details', $flds);
	}

	public static function DeleteDetails($conds)
	{
		return QueryType::delete('db_contacts_details', $conds);
	}
	// 
	
	public static function findOneDetailsOptions($conds)
	{
		return QueryType::query('db_contacts_details_options cd 
								LEFT JOIN db_contacts c ON c.id_fiche = cd.id_fiche', 
							'cd.*, c.id_organisateur', 
							$conds, true);
	}

	public static function getAllDetailsOptions($conds=''){
		return QueryType::query('db_contacts_details_options', '*', $conds);
	}

	public static function getCountDetailsOptions($conds=''){
		return QueryType::query('db_contacts_details_options', 'COUNT(*), type_detail', $conds, 'type_detail','type_detail');
	}
	
	public static function updateDetailsOptions($flds, $wh) 
	{
		return QueryType::update('db_contacts_details_options', $flds, $wh);
	}
	
	public static function CreateDetailsOptions($flds)
	{
		return QueryType::insert('db_contacts_details_options', $flds);
	}

	public static function DeleteDetailsOptions($conds)
	{
		return QueryType::delete('db_contacts_details_options', $conds);
	}
}

class KidsClub
{
	public static function findOneRdv($conds)
	{
		return QueryType::query('db_rdv', '*', $conds, true);
	}

	public static function getAllRdv($conds, $retourneOne = false, $order = '')
	{
		return QueryType::query('db_rdv', '*', $conds, $retourneOne, $order);
	}

	public static function getDateRdv($Whs)
	{
		return QueryType::querySimple('db_rdv', '*', $Whs);
	}

	public static function CreateRdv($flds)
	{
		return QueryType::insert('db_rdv', $flds);
	}

	public static function DeleteRdv($conds)
	{
		return QueryType::delete('db_rdv', $conds);
	}

	public static function updateRdv($flds, $wh) 
	{
		return QueryType::update('db_rdv', $flds, $wh);
	}
	
}

class Reglements
{
	public static function sumRglts($conds='')
	{
		return QueryType::query('db_reglements', 'SUM(mt_rglt) as MT', $conds, true);
	}
	public static function countRglts($conds='')
	{
		return QueryType::query('db_reglements', 'COUNT(*) as NB', $conds, true);
	}

	public static function findOneRglts($conds)
	{
		return QueryType::query('db_reglements', '*', $conds, true);
	}

	public static function getAllRglts($conds, $retourneOne = false, $order = '')
	{
		return QueryType::query('db_reglements', '*', $conds, $retourneOne, $order);
	}

	public static function getDateRglts($Whs)
	{
		return QueryType::querySimple('db_reglements', '*', $Whs);
	}

	public static function CreateRglts($flds)
	{
		return QueryType::insert('db_reglements', $flds);
	}

	public static function DeleteRglts($conds)
	{
		return QueryType::delete('db_reglements', $conds);
	}

	public static function updateRglts($flds, $wh) 
	{
		return QueryType::update('db_reglements', $flds, $wh);
	}
}

class Mois
{
	public static function countMois($conds='')
	{
		return QueryType::query('db_mois', 'COUNT(*) as NB', $conds, true);
	}

	public static function findOneMois($conds)
	{
		return QueryType::query('db_mois', '*', $conds, true);
	}

	public static function getAllMois($conds, $retourneOne = false, $order = '')
	{
		return QueryType::query('db_mois', '*', $conds, $retourneOne, $order);
	}

	public static function getDateMois($Whs)
	{
		return QueryType::querySimple('db_mois', '*', $Whs);
	}

	public static function CreateMois($flds)
	{
		return QueryType::insert('db_mois', $flds);
	}

	public static function DeleteMois($conds)
	{
		return QueryType::delete('db_mois', $conds);
	}

	public static function updateMois($flds, $wh) 
	{
		return QueryType::update('db_mois', $flds, $wh);
	}
}

class Chambres
{
	
	public static function createCh($flds)
	{
		return QueryType::insert('db_chambres', $flds);
	}

	public static function updateCh($flds, $wh) 
	{
		return QueryType::update('db_chambres', $flds, $wh);
	}

	public static function deleteCh($flds)
	{
		return QueryType::delete('db_chambres', $flds);
	}

	public static function countChambres($conds='')
	{
		return QueryType::query('db_chambres', 'COUNT(*) as NB', $conds, true);
	}

	public static function findOneCh($conds='')
	{
		return QueryType::query('db_chambres', '*', $conds, true);
	}
	
	public static function getAllCh($conds='', $retourne=false, $ordBy='num_chambre')
	{
		return QueryType::query('db_chambres', '*', $conds, $retourne, $ordBy);
	}

	public static function findOne($conds='')
	{
		return QueryType::query('db_contacts_chambres', '*', $conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_contacts_chambres', '*', $conds);
	}

	public static function getAllDetails($conds='')
	{
		return QueryType::query('db_contacts_chambres cc 
								INNER JOIN `db_chambres` ch ON cc.id_chambre = ch.id_chambre
								LEFT OUTER JOIN db_types_chambres tc ON ch.type_chambre = tc.id_type_chambre 
								LEFT OUTER JOIN db_vues_chambres vc ON ch.vue_chambre = vc.id_loc_chambre ', 
								'cc.id_contact_chambre, cc.id_chambre, tc.name_type_chambre, vc.name_loc_chambre, ch.num_chambre, ch.capacite, ch.communique_ch, ch.etage, ch.nb_lit_simple, ch.nb_lit_double, ch.nb_lit_bb, ch.nb_lit_sup', $conds);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_contacts_chambres', $flds);
	}

	public static function update($flds, $wh) 
	{
		return QueryType::update('db_contacts_chambres', $flds, $wh);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_contacts_chambres', $flds);
	}

	public static function findOneType($conds='')
	{
		return QueryType::query('db_types_chambres', '*', $conds, true);
	}

	public static function getAllType($conds='')
	{
		return QueryType::query('db_types_chambres', '*', $conds);
	}

	public static function createType($flds)
	{
		return QueryType::insert('db_types_chambres', $flds);
	}

	public static function updateType($flds, $wh) 
	{
		return QueryType::update('db_types_chambres', $flds, $wh);
	}

	public static function deleteType($flds)
	{
		return QueryType::delete('db_types_chambres', $flds);
	}

	public static function findOneLoc($conds='')
	{
		return QueryType::query('db_vues_chambres', '*', $conds, true);
	}

	public static function getAllLoc($conds='')
	{
		return QueryType::query('db_vues_chambres', '*', $conds);
	}

	public static function createLoc($flds)
	{
		return QueryType::insert('db_vues_chambres', $flds);
	}

	public static function updateLoc($flds, $wh) 
	{
		return QueryType::update('db_vues_chambres', $flds, $wh);
	}

	public static function deleteLoc($flds)
	{
		return QueryType::delete('db_vues_chambres', $flds);
	}

	public static function findOneOptions($conds='')
	{
		return QueryType::query('db_options_chambres', '*', $conds, true);
	}

	public static function getAllOptions($conds='')
	{
		return QueryType::query('db_options_chambres', '*', $conds);
	}

	public static function createOptions($flds)
	{
		return QueryType::insert('db_options_chambres', $flds);
	}

	public static function updateOptions($flds, $wh) 
	{
		return QueryType::update('db_options_chambres', $flds, $wh);
	}

	public static function deleteOptions($flds)
	{
		return QueryType::delete('db_options_chambres', $flds);
	}
}

class Planning
{
	public static function findOneMinMaxDate($conds='', $retourne= true, $ordBy='', $grpBy='')
	{
		return QueryType::query('db_planning', 'MIN(rdv_start) as MDDEB, MAX(rdv_end) as MDEND', $conds, $retourne, $ordBy, $grpBy);
	}

	public static function findOneMaxDate($conds='')
	{
		return QueryType::query('db_planning', 'MAX(rdv_end) as MDEND', $conds, true);
	}

	public static function findOneMinDate($conds='')
	{
		return QueryType::query('db_planning', 'MIN(rdv_start) as MDDEB', $conds, true);
	}

	public static function findOne($conds='')
	{
		return QueryType::query('db_planning', '*', $conds, true);
	}

	public static function getAll($conds='')
	{
		return QueryType::query('db_planning', '*', $conds);
	}

	public static function getAllSimple($conds='')
	{
		return QueryType::querySimple('db_planning', '*', $conds);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_planning', $flds);
	}

	public static function update($flds, $wh) 
	{
		return QueryType::update('db_planning', $flds, $wh);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_planning', $flds);
	}
	public static function add_planning($idct, $daydeb, $dayend, $hdeb, $hend, $numch, $idsejour)
	{
		$ct = Fiche::findOne(array('c.id_fiche' => (int)$idct));
		
		$rdvstart = $daydeb."T".$hdeb;
		$rdvend = $dayend."T".$hend;

		$evts[] = array('title'=> $strevents,'start'=> $rdvstart,'end'=> $rdvend,'allDay'=> false,'color'=> '#cccdff', 'id'=>$rdv['id_rdv']);
		$colorRdv = '#7d067d';

		$strevents = 'Informations privées';

		QueryType::insert('db_planning',array('id_fiche'=>$ct->id_fiche,
											'num_chambre'=>$numch,
											'id_usrApp'=>$UsrApp->id_usrApp,
											'date_create'=>date('Y-m-d H:i:s'),
											'rdv_start'=>$rdvstart,
											'rdv_end'=>$rdvend, 
											'desc_rdv' => '', 
											'id_sejour' => $idsejour, 
											'color_rdv'=>$colorRdv));
		
		return true;
	}

}

class Notif 
{
	public static function findOne($conds)
	{
		return QueryType::query('db_notifs', '*', $conds, true);
	}
	
	public static function find($conds, $ordby = '', $grpby = '', $lmtst = 0, $lmtend = 0)
	{
		return QueryType::querySimple('db_notifs n LEFT JOIN db_users u ON u.id_usrApp = n.id_usrApp_notif', 'n.*, u.id_equipe', $conds, false, $ordby, $grpby, $lmtst, $lmtend);
	}
	
	public static function create($flds)
	{
		return QueryType::insert('db_notifs', $flds);
	}

	public static function update($flds, $wh) 
	{
		return QueryType::update('db_notifs', $flds, $wh);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_notifs', $flds);
	}

	public static function createRead($flds)
	{
		return QueryType::insert('db_notifs_reads', $flds);
	}

	public static function deleteRead($flds)
	{
		return QueryType::delete('db_notifs_reads', $flds);
	}
}


class Comment
{
	public static function findOne($conds)
	{
		return QueryType::query('db_comments', '*', $conds, true);
	}
	
	public static function getBy($conds)
	{
		return QueryType::querySimple('db_comments c LEFT JOIN db_users u ON u.id_usrApp = c.id_user_comment', 'c.*, u.user_name', $conds, false,'date_comment');
	}
	
	public static function getFrstPopup($dt, $id_usrApp)
	{
		return QueryType::querySimple('db_comments cm 
								LEFT JOIN db_contacts c ON c.id_fiche = cm.id_fiche
								LEFT JOIN db_fournisseurs f ON f.id_fournisseur = cm.id_fournisseur
								LEFT JOIN db_status_secs s ON s.id_status_sec = c.id_status_sec', 
							'cm.id_comment, cm.text_comment, cm.date_recall, cm.id_fiche, cm.id_fournisseur, cm.is_commun, c.raison_sociale, c.first_name, c.last_name, c.tel1, c.email, c.post_code, c.city, s.name_status_sec, f.name_fournisseur, f.mail_fournisseur, f.tel_fournisseur',
							"(cm.type_comment IN (1,2) OR cm.is_commun = 1) AND cm.date_recall < '".$dt."' AND is_read = 0 AND cm.id_user_comment = ".$id_usrApp, 
							true);
	}

	public static function getPopup($conds)
	{
		return QueryType::query('db_comments cm 
								INNER JOIN db_contacts c ON c.id_fiche = cm.id_fiche
								LEFT JOIN db_users u ON u.id_usrApp = c.id_usrApp', 
							'cm.id_comment, cm.text_comment, cm.date_recall, c.id_fiche, c.first_name, c.last_name',
							$conds);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_comments', $flds);
	}

	public static function update($flds, $wh) 
	{
		return QueryType::update('db_comments', $flds, $wh);
	}
	
	public static function delete($conds)
	{
		return QueryType::delete('db_comments', $conds);
	}
}

class Doc
{
	public static function findOne($conds)
	{
		return QueryType::query('db_contacts_docs', '*', $conds, true);
	}
	
	public static function getBy($conds)
	{
		return QueryType::query('db_contacts_docs', '*', $conds);
	}
	
	public static function create($flds)
	{
		return QueryType::insert('db_contacts_docs', $flds);
	}

	public static function update($flds, $wh) 
	{
		return QueryType::update('db_contacts_docs', $flds, $wh);
	}
	
	public static function delete($conds)
	{
		return QueryType::delete('db_contacts_docs', $conds);
	}

	
	public static function getTypeDocs()
	{
		return QueryType::query('db_type_docs', '*');
	}
	
}

class Equipe
{
	public static function findOne($wh)
	{
		return QueryType::query('db_equipes', '*', $wh, true);
	}
	public static function getAll()
	{
		return QueryType::query('db_equipes', '*');
	}

	public static function GiveNameFromTeams($teams)
	{
		$res = QueryType::querySimple('db_equipes', "GROUP_CONCAT(name_equipe SEPARATOR ', ') as name_equipes", "id_equipe IN (".$teams.")", true);
		return $res->name_equipes;
	}

	public static function create($flds)
	{
		return QueryType::insert('db_equipes', $flds);
	}

}

class Unite
{
	public static function getAll($conds='')
	{
		return QueryType::query('db_unites', '*', $conds);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_unites', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_unites', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_unites', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_unites', $flds, $wh);
	}	
}

class Stock
{
	public static function getAllProduits($conds)
	{
		return QueryType::query('db_produits', '*', $conds);
	}

	public static function getAllProduitsJoin($conds)
	{
		return QueryType::query('db_produits p 
									LEFT JOIN db_unites u ON p.id_unite = u.id_unite
									LEFT JOIN db_fournisseurs f ON p.id_fournisseur = f.id_fournisseur', 
									'p.*, u.name_unite, f.name_fournisseur', $conds);
	}
	
	public static function findOneProduit($conds)
	{
		return QueryType::query('db_produits', '*', $conds, true);
	}
	
	public static function createProduit($flds)
	{
		return QueryType::insert('db_produits', $flds);
	}

	public static function deleteProduit($conds)
	{
		return QueryType::delete('db_produits', $conds);
	}

	public static function updateProduit($flds, $wh)
	{
		return QueryType::update('db_produits', $flds, $wh);
	}

	public static function produitSql($flds, $wh, $retourne=false)
	{
		return QueryType::querySimple('db_produits', $flds, $wh, $retourne);
	}

	public static function findOnePlatDetail($conds)
	{
		return QueryType::query('db_plats_details', '*', $conds, true);
	}
	
	public static function createPlatDetail($flds)
	{
		return QueryType::insert('db_plats_details', $flds);
	}

	public static function deletePlatDetail($conds)
	{
		return QueryType::delete('db_plats_details', $conds);
	}

	public static function updatePlatDetail($flds, $wh)
	{
		return QueryType::update('db_plats_details', $flds, $wh);
	}

	public static function platDetailSql($flds, $wh, $retourne=false)
	{
		return QueryType::querySimple('db_plats_details', $flds, $wh, $retourne);
	}

	public static function stockSql($sql, $retourne=false)
	{
		return QueryExec::querySQL($sql, $retourne);
	}


}

class Profil
{
	public static function findOne($conds='')
	{
		return QueryType::query('db_profils', '*', $conds, true);
	}

	public static function getAll()
	{
		return QueryType::query('db_profils', '*');
	}
		
	public static function findSql($sql, $retourne=false)
	{
		return QueryExec::querySQL($sql, $retourne);
	}

}



class UsrApp
{
	public static function findOne($wh)
	{
		return QueryType::query('db_users u LEFT JOIN db_equipes t ON t.id_equipe = u.id_equipe', 'u.*, t.name_equipe', $wh, true);
	}

	public static function findOneSimple($wh) 
	{
		return QueryType::querySimple('db_users u LEFT JOIN db_equipes t ON t.id_equipe = u.id_equipe', 'u.*, t.name_equipe', $wh, true);
	}
	
	public static function getAll($conds = '')
	{
		return QueryType::query('db_users', '*', $conds, false, 'user_name');
	}
	
	public static function whatIsProfile($whoUsr, $winPage='')
	{
		if(is_object($whoUsr)){
			
			$res = Profil::findOne(array('id_profil'=>(int)$whoUsr->id_profil));
			
			if(strstr(strtoupper($res->name_profil), 'ADMIN')){
				return '';
			}else{
				return $res;
			}
		}else{
			$res = Profil::findOne(array('id_profil'=>(int)$whoUsr));
			if(strstr(strtoupper($res->name_profil), 'ADMIN')){
				return '';
			}else{
				return $res;
			}
		}

	}
	
	public static function create($flds)
	{
		return QueryType::insert('db_users', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_users', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_users', $flds, $wh);
	}	
	
	public static function findOneAlerte($wh)
	{
		return QueryType::insert('db_users_type_alerte', '*',$wh, true);
	}
	
	public static function createAlerte($flds)
	{
		return QueryType::insert('db_users_type_alerte', $flds);
	}

	public static function deleteAlerte($flds)
	{
		return QueryType::delete('db_users_type_alerte', $flds);
	}
		
	public static function updateAlerte($flds, $wh) 
	{
		return QueryType::update('db_users_type_alerte', $flds, $wh);
	}	
}


class UsrAppTeam
{
	public static function findOne($wh)
	{
		return QueryType::query('db_users_teams', '*', $wh, true);
	}
}

class CrmAction
{
	public static function create($flds)
	{
		return QueryType::insert('db_crmaction', $flds);
	}
}

class API
{
	public static function findOne($wh)
	{
		return QueryType::query('db_apis', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_apis', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_apis', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_apis', $flds, $wh);
	}	
}

class Setting
{
	
	
	public static function getAllStSec()
	{
		return QueryType::query('db_status_secs', '*');
	}
	
	public static function getStSec($conds = '')
	{
		return QueryType::query('db_status_secs', '*', $conds, true);
	}
	
	public static function getStSecSimple($wh = '', $retourne=false)
	{
		return QueryType::querySimple('db_status_secs', '*', $wh, $retourne,'name_status_sec', 'name_status_sec');
	}

	public static function createStSec($flds)
	{
		return QueryType::insert('db_status_secs', $flds);
	}

	public static function getAllorganisateurs($conds = '')
	{
		return QueryType::query('db_organisateurs', '*', $conds);
	}
	
	public static function getOrganisateur($conds = '')
	{
		return QueryType::query('db_organisateurs', '*', $conds, true);
	}

	public static function updateOrganisateur($flds ='', $wh ='')
	{
		return QueryType::update('db_organisateurs', $flds, $wh);
	}

	public static function getAllorganisateursOrg($conds = '')
	{
		return QueryType::query('db_organisateurs_orgs', '*', $conds);
	}
	
	public static function getOrganisateurOrg($conds = '')
	{
		return QueryType::query('db_organisateurs_orgs', '*', $conds, true);
	}

	// devises
	public static function getAllDevises($conds='')
	{
		return QueryType::query('db_devises', '*',$conds);
	}

	public static function getDevise($conds='')
	{
		return QueryType::query('db_devises', '*',$conds, true);
	}
	
	public static function updateDevises($flds, $wh)
	{
		return QueryType::update('db_devises', $flds, $wh);
	}
	
	public static function updateDevisesSql($sql, $retourne=false)
	{
		return QueryExec::querySQL($sql, $retourne);
	}
	
}

class VarsType
{
	public static function buildVars($usrActif){
		$vars = array(
			'$NOM' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'last_name',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom du client' : 'Last name customer')
			),
			'$PRENOM' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'first_name',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom du client' : 'First name customer')
			),
			'$CIVILITE' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'civ_contact',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Civilité' : 'Title')
			),
			'$ADR1' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'adr1',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse du client' : 'Customer adress')
			),
			'$CP' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'post_code',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code postal' : 'Zip code')
			),
			'$VILLE' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'city',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ville du client' : 'City')
			),
			'$EMAIL' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'email',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Email du client' : 'Email')
			),
			'$TEL' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'tel1',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléphone du client' : 'Phone number')
			),
			'$2TEL' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'tel2',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléphone secondaire du client' : 'Scondary phone number')
			),
			'$RAISON_SOCIALE' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'raison_sociale',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Raison sociale' : 'Social reason')
			),
			'$SIRET' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'siret',
				'label' => 'Siret'
			),
			'$FONCTION' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'fonction',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fonction' : 'Job')
			),
			'$DEB' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'date_start',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de debut' : 'Start date')
			),
			'$FIN' => array(
				'src'=>'Customer',
				'table' => 'contact',
				'field' => 'date_end',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de fin' : 'End date')
			),
			'$LNK_DEVIS' => array(
				'src'=>'D',
				'table' => 'contact',
				'field' => '',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien signature devis' : 'Link estimate signature')
			),
			'$LNK_CONTRAT' => array(
				'src'=>'C',
				'table' => 'contact',
				'field' => '',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lien signature contrat' : 'Link contract signature')
			),
			'$SOC' => array(
				'src'=>'Soc',
				'table' => 'soc',
				'field' => 'name_soc',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom de la société' : 'Sociel reason')
			),
			'$ZIP_SOC' => array(
				'src'=>'Soc',
				'table' => 'soc',
				'field' => 'post_code_soc',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code postal société' : 'Zip code society')
			),
			'$CITY_SOC' => array(
				'src'=>'Soc',
				'table' => 'soc',
				'field' => 'city_soc',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ville société' : 'City society')
			),
			'$PHONE_SOC' => array(
				'src'=>'Soc',
				'table' => 'soc',
				'field' => 'tel_soc',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléphone société' : 'Phone number society')
			),
			'$MAIL_SOC' => array(
				'src'=>'Soc',
				'table' => 'soc',
				'field' => 'email_soc',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mail société' : 'Email society')
			),
			'$LOGO_SOC' => array(
				'src'=>'Soc',
				'table' => 'soc',
				'field' => 'logo_soc',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Logo société' : 'Logo society')
			),
			'$SIGN_SOC' => array(
				'src'=>'Soc',
				'table' => 'soc',
				'field' => 'sign_soc',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Signature société' : 'Signature society')
			),
			'$SEJOUR_LOGO' => array(
				'src'=>'sej',
				'table' => 'org',
				'field' => 'logo_organisateur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Logo du séjour' : 'Logo of the stay')
			),
			'$USER_ACTIF' => array(
				'src'=>'User',
				'table' => 'crm',
				'field' => 'user_name',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom utilisateur' : 'User name')
			),
			'$CRMTEL' => array(
				'src'=>'User',
				'table' => 'crm',
				'field' => 'tel',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Numéro de tel utilisateur' : 'User phone number')
			),
			'$CRMPORT' => array(
				'src'=>'User',
				'table' => 'crm',
				'field' => 'tel2',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Numéro de portable utilisateur' : 'User cellphone')
			),
			'$CRMEMAIL' => array(
				'src'=>'User',
				'table' => 'crm',
				'field' => 'email',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mail utilisateur' : 'User email')
			),
			'$FOUR_NAME' => array(
				'src'=>'F',
				'table' => 'fournisseur',
				'field' => 'name_fournisseur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom fournisseur' : 'Provider name')
			),
			'$FOUR_ADR' => array(
				'src'=>'F',
				'table' => 'fournisseur',
				'field' => 'adr_fournisseur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse fournisseur' : 'Provider adress')
			),
			'$FOUR_ZIP' => array(
				'src'=>'F',
				'table' => 'fournisseur',
				'field' => 'code_post_fournisseur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'CP fournisseur' : 'Provider zip code')
			),
			'$FOUR_CITY' => array(
				'src'=>'F',
				'table' => 'fournisseur',
				'field' => 'city_fournisseur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ville fournisseur' : 'Provider city')
			),
			'$FOUR_COUNTRY' => array(
				'src'=>'F',
				'table' => 'fournisseur',
				'field' => 'country_fournisseur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pays fournisseur' : 'Provider country')
			),
			'$FOUR_TEL' => array(
				'src'=>'F',
				'table' => 'fournisseur',
				'field' => 'tel_fournisseur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tél. fournisseur' : 'Provider phone number')
			),
			'$FOUR_MAIL' => array(
				'src'=>'F',
				'table' => 'fournisseur',
				'field' => 'mail_fournisseur',
				'label' => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mail fournisseur' : 'Provider email')
			),
		);

			return $vars;
	}
	
}

class ModelMail {
	public static function find($wh = '')
	{
		return QueryType::query('db_mailtypes', '*', $wh);
	}

	public static function findOne($wh)
	{
		return QueryType::query('db_mailtypes', '*', $wh, true);
	}

	public static function create($flds)
	{
		return QueryType::insert('db_mailtypes', $flds);
	}

	public static function delete($flds)
	{
		return QueryType::delete('db_mailtypes', $flds);
	}
		
	public static function update($flds, $wh) 
	{
		return QueryType::update('db_mailtypes', $flds, $wh);
	}	

	
	public static function replaceVars($id_fiche, $id_mailtype, $url='') 
	{
		global $usrActif;


		$res = ModelMail::findOne(array('id_mailtype' => (int)$id_mailtype));

		// echo('name mail type'.$res->name_mailtype);

		$msg = $res->msg;
		$dest = $res->dest_mail_type;
		$subject = $res->subject;
		$nameMailType = $res->name_mailtype;

		// $sets = (object)Setting::getGlobalSettings();
		$tb['UsrApp'] = UsrApp::findOne(array('id_usrApp' => $usrActif->id_usrApp));
		
		function format_Date($d){
			$arrDate = explode('-',$d);

			return $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
		}

		function format_Tel($t){
			
			return trim(chunk_split($t, 2, ' '));
		}

		if ((int)$id_fiche > 0) {	
			
			
			$contact = Fiche::findOne(array('c.id_fiche' => (int)$id_fiche));
			$UsrApp = UsrApp::findOne(array('id_usrApp' => $contact->id_usrApp));
			$soc = Soc::findOne(array('is_soc'=>'1'));

			$tb['contact'] = $contact;
			$tb['dates'] = $dates;
			$tb['crm'] = $UsrApp;
			$tb['soc'] = $soc;
			
			$listeDates = '';
			$periode = '';
			$tel = '';

			$dest = $contact->email;
			
			$vars = VarsType::buildVars($usrActif);

			foreach($vars as $k => $v) {
				if($k == '$DEB' || $k == '$FIN' || $k == '$TEL' || $k == '$2TEL' || $k == '$CIVILITE' ||
					$k == '$CRMTEL' || $k == '$CRMPORT' || $k == '$LNK_DEVIS'  || $k == '$SOC'  || $k == '$ZIP_SOC'
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
						$lnk = '<a href="'.$url.'/devis.php?CLID='.$contact->codekey.$contact->id_fiche.'" >Cliquez ici</a>';
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
		}
		

		return array('data' => $res, 'msg' => $msg, 'subject' => $subject, 'dest' => $dest);
	}


	public static function replaceVarsCmd($id_fournisseur, $id_mailtype,$usrActif) 
	{
		
		$res = ModelMail::findOne(array('id_mailtype' => (int)$id_mailtype));

		// echo('name mail type'.$res->name_mailtype);
		// die;

		$msg = $res->msg;
		$dest = $res->dest_mail_type;
		$subject = $res->subject;
		$nameMailType = $res->name_mailtype;

		
		function format_Date($d){
			$arrDate = explode('-',$d);

			return $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
		}

		function format_Tel($t){
			
			return trim(chunk_split($t, 2, ' '));
		}

		if ((int)$id_fournisseur > 0) {	
			
			
			$fourn = Fournisseurs::findOne(array('id_fournisseur' => (int)$id_fournisseur));
			$UsrApp = UsrApp::findOne(array('id_usrApp' => $usrActif->id_usrApp));
			$soc = Soc::findOne(array('is_soc'=>'1'));

			$tb['fournisseur'] = $fourn;
			$tb['crm'] = $UsrApp;
			$tb['soc'] = $soc;

			
			$listeDates = '';
			$periode = '';
			$tel = '';

			$dest = $fourn->mail_fournisseur;
			
			$vars = VarsType::buildVars($usrActif);

			foreach($vars as $k => $v) {
				if($k == '$FOUR_NAME' || $k == '$FOUR_ADR' || $k == '$FOUR_ZIP' || $k == '$FOUR_CITY' || $k == '$FOUR_COUNTRY' ||
					$k == '$FOUR_TEL' || $k == '$FOUR_MAIL'|| $k == '$SOC'  || $k == '$ZIP_SOC' || $k == '$CITY_SOC'  || 
					$k == '$PHONE_SOC' || $k == '$MAIL_SOC' || $k == '$LOGO_SOC' || $k == '$SIGN_SOC'){
	
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
					

					if($k == '$FOUR_TEL'){

						$tel = format_Tel($tb[$v['table']]->{$v['field']});			
						
						$msg = str_replace($k, $tel, $msg);
					}else {
						$msg = str_replace($k, $tb[$v['table']]->{$v['field']}, $msg);
						$subject = str_replace($k, $tb[$v['table']]->{$v['field']}, $subject);
					}	
				}
			}
		}
		

		return array('data' => $res, 'msg' => $msg, 'subject' => $subject, 'dest' => $dest);
	}

	public static function replaceVarsInscript($email, $id_mailtype, $url, $usrActif, $ct = '', $lg = 'FR', $isSign=0) 
	{
		
		$res = ModelMail::findOne(array('id_mailtype' => (int)$id_mailtype));

		// echo('name mail type'.$res->name_mailtype);
		// echo(print_r($usrActif));
		// die;

		$msg = $res->msg;
		$dest = $res->dest_mail_type;
		$subject = $res->subject;
		$nameMailType = $res->name_mailtype;
		$url = $url;
		
		function format_Date($d){
			$arrDate = explode('-',$d);

			return $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
		}

		function format_Tel($t){
			
			return trim(chunk_split($t, 2, ' '));
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

		$dest = $email;
		
		$vars = VarsType::buildVars($usrActif);

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
						$lnk = '<a href="'.$url.'/fiche-client.php?CLID='.$ct->codekey.$ct->id_fiche.'&KEY='.date('YmdHi').'&type=A'.$sejour->periode.$sejour->id_organisateur.'&mail='.$ct->email.'&LG='.$lg.'&SGN='.$isSign.'">Cliquez ici</a>';
						$msg = str_replace($k, $lnk, $msg);
					}else{
						$lnk = '<a href="'.$url.'/fiche-client.php?KEY='.date('YmdHi').'&type=I'.$sejour->periode.$sejour->id_organisateur.'&mail='.$email.'&LG='.$lg.'&SGN='.$isSign.'">Cliquez ici</a>';
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

		return array('data' => $res, 'msg' => $msg, 'subject' => $subject, 'dest' => $dest, 'jj'=>$lnk);
	}

}

class TemplateHtml
{


	public static function listDocs($ct, $docs)
	{
		global $URL;
		$dirup = $URL . '/uploads/';
		$html = '<table class="table table-striped table-vcenter table-borderless table-condensed table-hover"><tr><th>&nbsp;</th><th>Uploadé le</th><th>Nom du document</th></tr>';	
		foreach($docs as $doc) {
			$filename = $dirup . $ct->codekey . $ct->id_fiche . '/' . $doc['name_doc'];
			$html .= '<tr>
						<td><input type="checkbox" name="chkdoc[]" value="'.$doc['id_doc'].'"/></td>
						<td>'.date('d/m/Y H:i', strtotime($doc['date_doc'])).'</td>
						<td><a href="'.$filename.'" target="_blank">'.$doc['name_doc'].'</a></td>
					</tr>';
		}
		$html .= '</table>';

		return $html;
	}
}

?>