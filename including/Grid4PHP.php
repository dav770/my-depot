<?php

include __DIR__ . '/../libry/uitools.php';

if(isset($_GET['id_fiche'])){
	$paramIdCt = $_GET['id_fiche'];
}else{
	$paramIdCt = 0;
}

class Grid4PHP
{
	

	public static function getValGridToFormat($param, $fld, $val)
	{
		$str = '';
		foreach ($param['grid']->options["colModel"] as $colmod)
			if ($colmod['name'] == $fld) {
				$lst = $colmod["searchoptions"]["value"];
				if ($lst != '') {
					$lst = explode(';', $lst);
					foreach ($lst as $l) {
						$v = explode(':', $l);
						if ($v[0] == $val) {
							$str = $v[1];
							break;
						}
					}
				}
			}
		return $str;
	}

	public static function getGrid($tbname, $infosup = '', $infosup2 = '', $infosup3 = '')
	{
		global $usrActif;
		global $arrAccess;
		$arrMt = array('formatter' => 'currency', 'formatoptions' => array("thousandsSeparator" => " ", "decimalSeparator" => ",", "decimalPlaces" => 2));
		$arrPcts = array('formatter' => 'currency', 'formatoptions' => array("thousandsSeparator" => " ", "decimalSeparator" => ",", "decimalPlaces" => 2, "suffix" => '%'));

		switch ($tbname) {

			case 'db_contacts':
				$email =  $usrActif->email;

				$sql = "SELECT c.*, u.id_equipe, sc.status_color,
								COUNT(DISTINCT cm.id_comment) as nb_com, 
								IF(TRIM(c.adr1) != '' ,CONCAT(c.adr1,' ,',c.post_code,' ',c.city), '') as adresse,
								GROUP_CONCAT(DISTINCT CONCAT('<strong>', DATE_FORMAT(cm.date_comment, '%d/%m/%Y %H:%i'), '</strong> - <span>', cm.text_comment, '</span>') ORDER BY cm.id_comment DESC SEPARATOR '<hr>') as comments,			
								GROUP_CONCAT(DISTINCT CONCAT('[',ch.num_chambre,' / ',ch.etage,']')) as ch

						FROM db_contacts c 
							LEFT JOIN db_contacts_chambres cc ON cc.id_fiche = c.id_fiche
							LEFT JOIN db_chambres ch ON ch.num_chambre = cc.num_chambre
							LEFT JOIN db_status_secs sc ON sc.id_status_sec = c.id_status_sec
							LEFT JOIN db_users u ON u.id_usrApp = c.id_usrApp
							LEFT JOIN db_comments cm ON cm.id_fiche = c.id_fiche AND cm.type_comment IN (0, 1)
						WHERE c.id_organisateur = ".max($usrActif->cursoc, 1);

				$sql .= " GROUP BY c.id_fiche";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('export_pdf' => false, 'export_csv' => true, 'export_excel' => true, 'search' => true));
				
				$opt["sortable"] = true;
				$opt["sortname"] = 'id_fiche';
				$opt["sortorder"] = 'desc';
				$opt["loadComplete"] = "function(ids) { gridcts_onload(ids); }";
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$opt['width'] = '100%';
				$opt['height'] = 'auto';
				$opt["autowidth"] = true;
				$opt["shrinkToFit"] = false;
				$opt["multiselect"] = true  ;
			
				$opt["rowList"] = array(20, 50, 100, 200);
				
				$opt["rowList"][] = 'All';
				$opt["rowNum"] =  20;
				// $opt["height"] = '450'; //"100%";
				// $opt["scroll"] = true;
				//$opt["autoresize"] = true;

				$cols = array();
				
				UIGrid::add_cols($cols, 'id_fiche', 'ID.', array('width' => 70, 'dbname' => 'c.id_fiche'));
				UIGrid::add_cols( $cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitements' : 'Treatments'), array(
					// 'frozen'=>true,
					'align' => 'center', 
					'sortable' => false, 
					'search' => false, 
					'export' => false, 
					'width' => '200px', 
					'on_data_display' => array('display_action', '')
				));

				UIGrid::add_cols($cols, 'annee', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Année' : 'Year'), array('hidden'=>true));
				
				UIGrid::add_cols($cols, 'source', 'Source', array('hidden'=>true));
		
				// UIGrid::add_cols($cols, 'nb_com', 'Commentaires', array(
				// 	'sortable' => false,
				// 	'search' => false,
				// 	'export' => false,
				// 	'on_data_display' => array('display_comments', ''))
				// );				
			
				// function display_comments($data) {
					
				// 		// error_log("===>".$data['comments']);
				// 	$crmusr = UsrApp::findOne(array('id_usrApp' => $data['id_usrApp']));

				// 	$btn = '';
				// 	if ((int)$data['nb_com'] > 0)
				// 		$btn = '<label data-toggle="tooltip2" title="<div>Utilisateur : <b>'.$crmusr->user_name.'</b></div>'.str_replace('"', "'", $data['comments']).'" data-placement="left" class="label label-success">'.$data['nb_com'].' comment.</label>';

				// 	return $btn;
				// }		

				UIGrid::add_cols($cols, 'ch', 'Chambre/Etage', array(
					'dbname'=>"ch.num_chambre",
					'hidden'=>false
				));

				$lststatus = $grid->get_dropdown_values("select DISTINCT id_status_sec as k, name_status_sec as v from db_status_secs");
				UIGrid::add_cols($cols, 'id_status_sec', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Statut <br>dossier' : 'Folder <br>Status'), array(
					'dbname' => 'c.id_status_sec',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lststatus),
					'stype' => "select",
					'searchoptions' => array("value" => $lststatus)
				));
						

				UIGrid::add_cols($cols, 'last_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Last name'));
				UIGrid::add_cols($cols, 'first_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First name'));
				
				UIGrid::add_cols($cols, 'tel1', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tel' : 'Phone <br>number'), array(
					'dbname' => 'c.tel1', 
					'on_data_display' => array('display_tel1', '')
				));

				function display_tel1($data) {
					return trim(chunk_split($data['tel1'], 2, ' '));	
				}



				UIGrid::add_cols($cols, 'tel2', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tel Secondaire' : 'Secondary <br>Phone number'), array(
					'hidden'=>true,
					'dbname' => 'c.tel2',
					'on_data_display' => array('display_tel2', '')
				));

				function display_tel2($data) {
					$arrTel = '';

					for($i=0; $i<strlen($data['tel2']); $i++){

						$arrTel .= ($i == 2 || $i == 4 || $i == 6 || $i == 8) ?  ' '.$data['tel2'][$i] : $data['tel2'][$i] ;	
					}
					
					return $arrTel;
				}


				UIGrid::add_cols($cols, 'email', 'Email', array(
					'dbname' => 'c.email',
					// 'width'=> '170px',
				));

				UIGrid::add_cols($cols, 'date_start', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de début' : 'Start date'), array(
					'hidden'=>true,
					'dbname' => 'DATE(c.date_start)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_start"] > 0', "{date_start}", '')
				));
				UIGrid::add_cols($cols, 'date_end', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de fin' : 'End date'), array(
					'hidden'=>true,
					'dbname' => 'DATE(c.date_end)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_end"] > 0', "{date_end}", '')
				));

				
				UIGrid::add_cols($cols, 'date_contrat', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date du<br>contrat' : 'Date of<br>contract'), array(
					'hidden'=>true,
					'dbname' => 'DATE(c.date_contrat)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_contrat"] > 0', "{date_contrat}", '')
				));
						
				UIGrid::add_cols($cols, 'raison_sociale', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Raison sociale' : 'Social reason'), array(
					'hidden'=>true,
					'width' => '120',
				));

				UIGrid::add_cols($cols, 'siret', 'SIRET', array(
					'hidden'=>true,
				));
				
				UIGrid::add_cols($cols, 'adresse', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse' : 'Adress'), array(
					// 'width'=> '120',
				));	
				// UIGrid::add_cols($cols, 'adr1', 'Adresse');	
				
				// UIGrid::add_cols($cols, 'post_code', 'Code Postal',array('dbname'=> 'c.post_code'));				
				// UIGrid::add_cols($cols, 'city', 'Ville');	
				UIGrid::add_cols($cols, 'mt_ok_ht', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant <br>accordé' : 'Amount <br>awarded'), array(
					'hidden'=>true,
					'formatter' => 'currency', 
					'formatoptions' => array("thousandsSeparator" => " ", "decimalSeparator" => ",", "decimalPlaces" => 2),
				));
				UIGrid::add_cols($cols, 'mt_rac', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Reste à charge' : 'Remains <br>dependent'), array(
					'hidden'=>true,
					'formatter' => 'currency', 
					'formatoptions' => array("thousandsSeparator" => " ", "decimalSeparator" => ",", "decimalPlaces" => 2),
				));

				UIGrid::add_cols($cols, 'accompte_25', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Acompte <br>25%' : '25% <br>deposit'), array(
					'hidden'=>true,
					'formatter' => 'currency', 
					'formatoptions' => array("thousandsSeparator" => " ", "decimalSeparator" => ",", "decimalPlaces" => 2),
				));

				UIGrid::add_cols($cols, 'numfac', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° Facture <br>Client' : 'Invoice <br>number'), array(
					'hidden'=>true,
				));

				UIGrid::add_cols($cols, 'date_fac', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date <br>Facture' : 'Bill <br>date'), array(
					'hidden'=>true,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_fac"] > 0', "{date_fac}", '')
				));
						
				UIGrid::add_cols($cols, 'tot_ht', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant <br>facturé' : 'Amount <br>charged'), array(
					'hidden'=>true,
					'formatter' => 'currency', 
					'formatoptions' => array("thousandsSeparator" => " ", "decimalSeparator" => ",", "decimalPlaces" => 2),
				));
				
						
				UIGrid::add_cols($cols, 'date_create', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date <br>création' : 'Date <br>create'), array(
					'dbname' => 'DATE(c.date_create)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d H:i:s', "newformat" => 'd/m/Y H:i'),
					'condition' => array('$row["date_create"] > 0', "{date_create}", '')
				));

				UIGrid::add_cols($cols, 'status_color', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Couleur' : 'Color'), array('hidden' => true));

				
				function display_action($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						. '<a href="fiche.php?id_fiche=' . $data['id_fiche'] . '" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails du client' : 'Customer details').'" class="btn btn-xs btn-info" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-eye"></i></a>'
						. '<a href="#" data-toggle="tooltip2" data-id="' . $data['id_fiche'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commentaire' : 'Comment').'" class="btn btn-xs btn-success btcomment" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-comment"></i></a>'
						. '<a href="#" data-toggle="tooltip2" data-id="' . $data['id_fiche'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel' : 'Reminder').'" class="btn btn-xs btn-primary btrappel" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-comment-o"></i></a>'
						. '<a href="#" data-toggle="tooltip2" data-id="' . $data['id_fiche'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Changer etat dossier' : 'Change folder status').'" class="btn btn-xs btn-warning btchangestatussec" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="gi gi-iphone_exchange"></i></a>'
						. '<a href="#" data-toggle="tooltip2" data-id="' . $data['id_fiche'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enoyer un mail' : 'Send email').'" class="btn btn-xs btn-info btsenddoc" style="background-color:#e6e473d4 !important;border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-envelope-o"></i></a>'
						. ($data['lnk_annule'] == '0' ? 
							'<a href="#" data-toggle="tooltip2" data-id="' . $data['id_fiche'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Editer la liste des chambres' : 'Print room list').'" class="btn btn-xs btn-secondary btroom" style="background-color:#d1a1d5d4 !important;border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-bed"></i></a>'
						:
							''
						)
						. '</div>';

					return $btn;
				}


				function export_contacts($param)
				{
					//print_r($param); die;
					$data = &$param["data"]; // the complete grid object reference
					//error_log(print_r($data, true).PHP_EOL);
					$i = 0;
					$doc = new DOMDocument;
					foreach ($data as &$d) {
						// skip first column title
						if ($i++ == 0) {
							foreach($d as $c => $v)
								$d[$c] = str_replace('<br>', '', $v);
							continue;
						}

						$d["id_status_sec"] = Grid4PHP::getValGridToFormat($param, 'id_status_sec', $d["id_status_sec"]);
						$d["id_usrApp"] = Grid4PHP::getValGridToFormat($param, 'id_usrApp', $d["id_usrApp"]);
						$d['comments'] = strip_tags($d['comments']);
					}
				}


				//$grid->set_conditional_css(array(array('column' => 'date_rdv', 'css' => "'font-weight':'600'")));

				$grid->set_options($opt);

				$grid->set_events(array(
					'js_on_load_complete' => "gridAll",
					'on_render_excel' => array("export_contacts", null, true),
					'on_render_pdf' => array("export_contacts", null, true)
				));
				$grid->set_columns($cols);
				return $grid->render("list_fiches");

				break;

			case 'db_listing':
				$email =  $usrActif->email;

				$sql = "SELECT DISTINCT(c.email) as distinct_email, c.*
						FROM db_contacts c
						WHERE c.id_organisateur != ".max($usrActif->cursoc, 1)." AND c.list_add_sejour NOT IN (".$usrActif->cursoc.")";

				$sql .= " GROUP BY c.id_fiche";

				// $sql = "SELECT c.*, u.id_equipe, sc.status_color,
				// 				COUNT(DISTINCT cm.id_comment) as nb_com, 
				// 				IF(TRIM(c.adr1) != '' ,CONCAT(c.adr1,' ,',c.post_code,' ',c.city), '') as adresse,
				// 				GROUP_CONCAT(DISTINCT CONCAT('<strong>', DATE_FORMAT(cm.date_comment, '%d/%m/%Y %H:%i'), '</strong> - <span>', cm.text_comment, '</span>') ORDER BY cm.id_comment DESC SEPARATOR '<hr>') as comments,			
				// 				GROUP_CONCAT(DISTINCT CONCAT('[',ch.num_chambre,' / ',ch.etage,']')) as ch

				// 		FROM db_contacts c 
				// 			LEFT JOIN db_contacts_chambres cc ON cc.id_fiche = c.id_fiche
				// 			LEFT JOIN db_chambres ch ON ch.num_chambre = cc.num_chambre
				// 			LEFT JOIN db_status_secs sc ON sc.id_status_sec = c.id_status_sec
				// 			LEFT JOIN db_users u ON u.id_usrApp = c.id_usrApp
				// 			LEFT JOIN db_comments cm ON cm.id_fiche = c.id_fiche AND cm.type_comment IN (0, 1) ";
				// 		// WHERE c.id_organisateur = ".max($usrActif->cursoc, 1);

				// $sql .= " GROUP BY c.id_fiche";

				$grid = UIGrid::getGrid('', 'db_contacts', $sql);
				$grid->set_actions(array('export_pdf' => false, 'export_csv' => true, 'export_excel' => true, 'search' => true));
				
				$opt["sortable"] = true;
				$opt["sortname"] = 'id_fiche';
				$opt["sortorder"] = 'desc';
				$opt["loadComplete"] = "function(ids) { gridctslisting_onload(ids); }";
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				// $opt['width'] = 'auto';
				$opt['height'] = 'auto';
				// $opt["autowidth"] = true;
				// $opt["shrinkToFit"] = false;
				$opt["multiselect"] = true  ;
			
				$opt["rowList"] = array(20, 50, 100, 200);
				
				$opt["rowList"][] = 'All';
				$opt["rowNum"] =  20;
				// $opt["height"] = '450'; //"100%";
				// $opt["scroll"] = true;
				// $opt["autoresize"] = true;

				$cols = array();
				
				UIGrid::add_cols($cols, 'id_fiche', 'ID.', array('width' => 70, 'dbname' => 'c.id_fiche'));
				
				UIGrid::add_cols($cols, 'last_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Last name'));
				UIGrid::add_cols($cols, 'first_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First name'));
				
				UIGrid::add_cols($cols, 'tel1', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tel' : 'Phone <br>number'), array(
					'dbname' => 'c.tel1', 
					'on_data_display' => array('display_tel1', '')
				));

				function display_tel1($data) {
					return trim(chunk_split($data['tel1'], 2, ' '));	
				}



				UIGrid::add_cols($cols, 'tel2', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tel Secondaire' : 'Secondary <br>Phone number'), array(
					'hidden'=>true,
					'dbname' => 'c.tel2',
					'on_data_display' => array('display_tel2', '')
				));

				function display_tel2($data) {
					$arrTel = '';

					for($i=0; $i<strlen($data['tel2']); $i++){

						$arrTel .= ($i == 2 || $i == 4 || $i == 6 || $i == 8) ?  ' '.$data['tel2'][$i] : $data['tel2'][$i] ;	
					}
					
					return $arrTel;
				}


				UIGrid::add_cols($cols, 'email', 'Email', array(
					'dbname' => 'c.email',
					// 'width'=> '170px',
				));

				
				UIGrid::add_cols($cols, 'adresse', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse' : 'Adress'), array(
					// 'width'=> '120',
				));	
				// UIGrid::add_cols($cols, 'adr1', 'Adresse');	
				
				// UIGrid::add_cols($cols, 'post_code', 'Code Postal',array('dbname'=> 'c.post_code'));				
				// UIGrid::add_cols($cols, 'city', 'Ville');	
				


				function export_listing($param)
				{
					//print_r($param); die;
					$data = &$param["data"]; // the complete grid object reference
					//error_log(print_r($data, true).PHP_EOL);
					$i = 0;
					$doc = new DOMDocument;
					foreach ($data as &$d) {
						// skip first column title
						if ($i++ == 0) {
							foreach($d as $c => $v)
								$d[$c] = str_replace('<br>', '', $v);
							continue;
						}

						// $d["id_status_sec"] = Grid4PHP::getValGridToFormat($param, 'id_status_sec', $d["id_status_sec"]);
						// $d["id_usrApp"] = Grid4PHP::getValGridToFormat($param, 'id_usrApp', $d["id_usrApp"]);
						// $d['comments'] = strip_tags($d['comments']);
					}
				}


				//$grid->set_conditional_css(array(array('column' => 'date_rdv', 'css' => "'font-weight':'600'")));

				$grid->set_options($opt);

				$grid->set_events(array(
					'js_on_load_complete' => "gridAll",
					'on_render_excel' => array("export_listing", null, true),
					'on_render_pdf' => array("export_listing", null, true)
				));
				$grid->set_columns($cols);
				return $grid->render("list_listing");

				break;
	
					
			case 'db_commandes_fournisseurs':
				$tbname = 'db_commandes';

				$sql = "SELECT c.num_cmd, c.date_cmd, f.name_fournisseur, s.name_organisateur, c.id_sejour
						FROM `db_commandes` c 
						INNER JOIN db_fournisseurs f ON c.id_fournisseur = f.id_fournisseur
						INNER JOIN db_organisateurs s ON c.id_sejour = s.id_organisateur
						WHERE c.id_sejour = ".$infosup." GROUP BY c.num_cmd";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				
				$opt["sortable"] = true;
				// $opt["loadComplete"] = "function(ids) { gridcts_onload(ids); }";
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$opt['subGrid'] = true;
				$opt['subgridurl'] = 'commandes_details.php';
				$opt['subgridparams'] = 'c.num_cmd,c.id_sejour';
				$opt['width'] = '100%';
				$opt['height'] = 'auto';
				$opt["autowidth"] = true;
				// $opt["shrinkToFit"] = false;
				$opt["multiselect"] = false  ;
			
				$opt["rowList"] = array(20, 50, 100, 200);
				
				$opt["rowList"][] = 'All';
				$opt["rowNum"] =  20;
				$cols = array();

				// $cond["column"] = "id_mail";
				// $cond["target"] = "id_mail";
				// $cond["op"] = ">=";
				// $cond["value"] = "0";
				// $cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				// $cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_cmd', 'ID.', array('hidden'=>true, 'editable' => false,'width' => 10));
				
				UIGrid::add_cols($cols, 'num_cmd', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de commande' : 'Order number'), array());

				UIGrid::add_cols($cols, 'name_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur' : 'Provider'), array());

				UIGrid::add_cols($cols, 'date_cmd', 'date', array(
					'width' => 40,
					'dbname' => 'DATE(date_cmd)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_cmd"] > 0', "{date_cmd}", '')
				));

				UIGrid::add_cols($cols, 'name_organisateur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array());

				$grid->set_events(array(
					// 'js_on_load_complete' => "dbgridmail",
				));
				
				$grid->set_options($opt);

				$grid->set_columns($cols);
				// $grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_cmd_fourn");

				break;
					
			case 'db_commandes':
				$sql = "SELECT * FROM db_commandes WHERE is_validate = 1 ".($infosup != '' ? ' AND num_cmd = "'.$infosup.'"'	 : '');

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				
				$opt["sortable"] = true;
				// $opt["loadComplete"] = "function(ids) { gridcts_onload(ids); }";
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				
				// $opt['width'] = '100%';
				// $opt['height'] = 'auto';
				// $opt["autowidth"] = true;
				// $opt["shrinkToFit"] = false;
				// $opt["multiselect"] = true  ;
			
				$opt["rowList"] = array(20, 50, 100, 200);
				
				$opt["rowList"][] = 'All';
				$opt["rowNum"] =  20;
				$cols = array();

				// $cond["column"] = "id_mail";
				// $cond["target"] = "id_mail";
				// $cond["op"] = ">=";
				// $cond["value"] = "0";
				// $cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				// $cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_cmd', 'ID.', array('editable' => false,'width' => 10));
				
				$lstfourn = $grid->get_dropdown_values("select DISTINCT id_fournisseur as k, name_fournisseur as v from db_fournisseurs");
				UIGrid::add_cols($cols, 'id_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur' : 'Provider'), array(
					'dbname' => 'id_fournisseur',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstfourn),
					'stype' => "select",
					'searchoptions' => array("value" => $lstfourn)
				));

				$lstprod = $grid->get_dropdown_values("select DISTINCT id_produit as k, name_produit as v from db_produits");
				UIGrid::add_cols($cols, 'id_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Produit' : 'Product'), array(
					'dbname' => 'id_produit',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstprod),
					'stype' => "select",
					'searchoptions' => array("value" => $lstprod)
				));

				$lstunit = $grid->get_dropdown_values("select DISTINCT id_unite as k, name_unite as v from db_unites");
				UIGrid::add_cols($cols, 'id_unite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Unité' : 'Unit'), array(
					'dbname' => 'id_unite',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstunit),
					'stype' => "select",
					'searchoptions' => array("value" => $lstunit)
				));

				UIGrid::add_cols($cols, 'val_qte', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quantité' : 'Quantity'), array('editable' => true,'width' => 70));

				
				$lstsej = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs");
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'dbname' => 'id_sejour',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstsej),
					'stype' => "select",
					'searchoptions' => array("value" => $lstsej)
				));
				
				UIGrid::add_cols($cols, 'etat_cmd', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Statut' : 'Status'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:En cours;1:Envoyée;2:Recue;3:Annulée;4:Retournée" . $lstsej),
					'stype' => "select",
					'searchoptions' => array("value" => "0:En cours;1:Envoyée;2:Recue;3:Annulée;4:Retournée")
				));

				UIGrid::add_cols($cols, 'date_cmd', 'date', array(
					'width' => 40,
					'dbname' => 'DATE(date_cmd)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_cmd"] > 0', "{date_cmd}", '')
				));

				$grid->set_events(array(
					// 'js_on_load_complete' => "dbgridmail",
				));
				
				$grid->set_options($opt);

				$grid->set_columns($cols);
				// $grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_cmd");

				break;
					
			case 'db_commandes_details':
				$tbname = 'db_commandes';
				
				$sql = "SELECT * FROM db_commandes WHERE is_validate = 1 ".($infosup != '' ? ' AND num_cmd = "'.$infosup.'"'	 : '');

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => false));
				

				// $opt["sortable"] = true;
				// // $opt["loadComplete"] = "function(ids) { gridcts_onload(ids); }";
				// $opt["export"] = array(
				// 	"range" => "filtered",
				// 	"orientation" => "landscape"
				// );
				
				$opt['width'] = 'auto';
				// $opt['height'] = '';
				
				$opt["autowidth"] = true;
				$opt['height'] = 'auto';
				$opt['footerrow'] = false;
				$opt["shrinkToFit"] = false;
				// // $opt["multiselect"] = true  ;
			
				// $opt["rowList"] = array(20, 50, 100, 200);
				
				// $opt["rowList"][] = 'All';
				// $opt["rowNum"] =  20;
				$cols = array();

				// $cond["column"] = "id_mail";
				// $cond["target"] = "id_mail";
				// $cond["op"] = ">=";
				// $cond["value"] = "0";
				// $cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				// $cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_cmd', 'ID.', array('editable' => false,'width' => 10));
				
				$lstfourn = $grid->get_dropdown_values("select DISTINCT id_fournisseur as k, name_fournisseur as v from db_fournisseurs");
				UIGrid::add_cols($cols, 'id_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur' : 'Provider'), array(
					'width' => 10,
					'dbname' => 'id_fournisseur',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstfourn),
					'stype' => "select",
					'searchoptions' => array("value" => $lstfourn)
				));

				$lstprod = $grid->get_dropdown_values("select DISTINCT id_produit as k, name_produit as v from db_produits");
				UIGrid::add_cols($cols, 'id_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Produit' : 'Product'), array(
					'dbname' => 'id_produit',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstprod),
					'stype' => "select",
					'searchoptions' => array("value" => $lstprod)
				));

				$lstunit = $grid->get_dropdown_values("select DISTINCT id_unite as k, name_unite as v from db_unites");
				UIGrid::add_cols($cols, 'id_unite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Unité' : 'Unit'), array(
					'dbname' => 'id_unite',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstunit),
					'stype' => "select",
					'searchoptions' => array("value" => $lstunit)
				));

				UIGrid::add_cols($cols, 'val_qte', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quantité' : 'Quantity'), array('editable' => true,'width' => 70));

				
				$lstsej = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs");
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'dbname' => 'id_sejour',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstsej),
					'stype' => "select",
					'searchoptions' => array("value" => $lstsej)
				));
				
				UIGrid::add_cols($cols, 'etat_cmd', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Statut' : 'Status'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:En cours;1:Envoyée;2:Recue;3:Annulée;4:Retournée" . $lstsej),
					'stype' => "select",
					'searchoptions' => array("value" => "0:En cours;1:Envoyée;2:Recue;3:Annulée;4:Retournée")
				));

				UIGrid::add_cols($cols, 'date_cmd', 'date', array(
					'dbname' => 'DATE(date_cmd)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_cmd"] > 0', "{date_cmd}", '')
				));

				$grid->set_events(array(
					// 'js_on_load_complete' => "dbgridmail",
				));
				
				$grid->set_options($opt);

				$grid->set_columns($cols);
				// $grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_cmd_details");

				break;

			case 'commandes_add':
				$sql = "SELECT * FROM db_commandes WHERE is_annule = 0 ".($infosup != '' ? ' AND num_cmd = "'.$infosup.'"'	 : '');

				$tbname = 'db_commandes';
				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => false, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt['width'] = '100%';
				$opt['height'] = 'auto';
				$opt["autowidth"] = true;
				$opt["shrinkToFit"] = false;

				$cols = array();

				// $cond["column"] = "id_mail";
				// $cond["target"] = "id_mail";
				// $cond["op"] = ">=";
				// $cond["value"] = "0";
				// $cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				// $cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_cmd', 'ID.', array('editable' => false,'width' => 10));
				
				$lstfourn = $grid->get_dropdown_values("select DISTINCT id_fournisseur as k, name_fournisseur as v from db_fournisseurs");
				UIGrid::add_cols($cols, 'id_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur' : 'Provider'), array(
					'editable'=>false,
					'dbname' => 'id_fournisseur',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstfourn),
					'stype' => "select",
					'searchoptions' => array("value" => $lstfourn)
				));

				UIGrid::add_cols($cols, 'num_cmd', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° <br>commande' : 'Order <br>number'), array('editable' => false));

				$lstprod = $grid->get_dropdown_values("select DISTINCT id_produit as k, name_produit as v from db_produits");
				UIGrid::add_cols($cols, 'id_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Produit' : 'Product'), array(
					'dbname' => 'id_produit',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstprod),
					'stype' => "select",
					'searchoptions' => array("value" => $lstprod)
				));

				$lstunit = $grid->get_dropdown_values("select DISTINCT id_unite as k, name_unite as v from db_unites");
				UIGrid::add_cols($cols, 'id_unite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Unité' : 'Unit'), array(
					'dbname' => 'id_unite',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstunit),
					'stype' => "select",
					'searchoptions' => array("value" => $lstunit)
				));

				UIGrid::add_cols($cols, 'val_qte', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quantité' : 'Quantity'), array('editable' => true,'width' => 70));

				
				$lstsej = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs");
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'editable'=>false,
					'dbname' => 'id_sejour',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstsej),
					'stype' => "select",
					'searchoptions' => array("value" => $lstsej)
				));
				
				UIGrid::add_cols($cols, 'etat_cmd', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Statut' : 'Status'), array(
					'editable'=>false,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:En cours;1:Envoyée;2:Recue;3:Annulée;4:Retournée" . $lstsej),
					'stype' => "select",
					'searchoptions' => array("value" => "0:En cours;1:Envoyée;2:Recue;3:Annulée;4:Retournée")
				));

				UIGrid::add_cols($cols, 'date_cmd', 'date', array(
					'width' => 40,
					'dbname' => 'DATE(date_cmd)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_cmd"] > 0', "{date_cmd}", '')
				));

				$grid->set_events(array(
					// 'js_on_load_complete' => "dbgridmail",
				));

				
				$grid->set_options($opt);

				$grid->set_columns($cols);
				// $grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_cmd_add");

				break;
					
			case 'db_mails':
				$sql = "SELECT * FROM db_mails";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$cols = array();

				// $cond["column"] = "id_mail";
				// $cond["target"] = "id_mail";
				// $cond["op"] = ">=";
				// $cond["value"] = "0";
				// $cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				// $cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_mail', 'ID.', array('editable' => false,'width' => 10));
				UIGrid::add_cols($cols, 'subject_mail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject'),array(
					'width' => 120, 
					'on_data_display' => array('display_subject_mails', '')
				));

				function display_subject_mails($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						.quoted_printable_decode(strip_tags($data['subject_mail']))
						. '</div>';

					return $btn;
				}

				UIGrid::add_cols($cols, 'from_mail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'De' : 'From'),array(
					'width' => 50,
				));
				UIGrid::add_cols($cols, 'date_mail', 'date', array(
					'width' => 40,
					'dbname' => 'DATE(date_mail)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d H:i:s', "newformat" => 'd/m/Y H:i'),
					'condition' => array('$row["date_mail"] > 0', "{date_mail}", '')
				));

				UIGrid::add_cols($cols, 'msg_mail', 'Message',array(
					'width' => 120, 
					'on_data_display' => array('display_msg_mails', '')
				));

				function display_msg_mails($data)
				{
					global $usrActif;
					if(strpos($data['msg_mail'], 'Content-Transfer-Encoding') !== false){
						$btn = '<div class="btn-group">'
						.quoted_printable_decode($data['msg_mail'])
						. '</div>';

					}else{
						$btn = '<div class="btn-group">'
						.$data['msg_mail']
						. '</div>';

					}
					
					return $btn;
				}

				UIGrid::add_cols( $cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitements' : 'Treatments'), array(
					'align' => 'center', 
					'editable' => false,
					'sortable' => false, 
					'search' => false, 
					'export' => false, 
					'width' => '30px', 
					'on_data_display' => array('display_action_mails', '')
				));

				function display_action_mails($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						.'<a href="#" data-toggle="tooltip2" data-to="'.$data['to_mail'].'" data-from="'.$resImap['from_mail'].'" data-id="' . $data['uuid_mail'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Répondre' : 'Forward').'" class="btn btn-xs btn-success btforward" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-send" style="width: 100px;height: 23px;text-align: center;vertical-align: sub;"></i></a>'
						. '</div>';

					return $btn;
				}



				$grid->set_events(array(
					// 'js_on_load_complete' => "dbgridmail",
				));
				$grid->set_columns($cols);
				// $grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_mails");

				break;


				
			case 'db_monos':
				$sql = "SELECT * FROM db_monos WHERE id_sejour = ".$infosup;

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				


				$cols = array();
				UIGrid::add_cols($cols, 'id_mono', 'ID.', array('editable' => false,'width' => 70));

				$lstmd = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup);				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstmd,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstmd),
					'stype' => "select",
					'searchoptions' => array("value" => $lstmd),
				));

				UIGrid::add_cols( $cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitements' : 'Treatments'), array(
					'align' => 'center', 
					'editable' => false,
					'sortable' => false, 
					'search' => false, 
					'export' => false, 
					'width' => '200px', 
					'on_data_display' => array('display_action_mono', '')
				));

				function display_action_mono($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						.'<a href="info-plan.php?id_mono='.$data['id_mono'].'" data-toggle="tooltip2" data-id="' . $data['id_fiche'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Gestion planing' : 'Schedule management').'" class="btn btn-xs btn-primary btplan" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="gi gi-calendar"></i></a>'
						. '</div>';

					return $btn;
				}

				UIGrid::add_cols($cols, 'last_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Last name'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'first_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First name'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'tel1', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tel' : 'Phone<br>number'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'age', 'age', array('editable' => true,'width' => 70));

				UIGrid::add_cols($cols, 'date_deb', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Arrivée' : 'Arrival'), array(
					'dbname' => 'DATE(date_deb)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d H:i:s', "newformat" => 'd/m/Y H:i'),
					'condition' => array('$row["date_deb"] > 0', "{date_deb}", '')
				));

				UIGrid::add_cols($cols, 'date_fin', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Départ' : 'Departure'), array(
					'dbname' => 'DATE(date_fin)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d H:i:s', "newformat" => 'd/m/Y H:i'),
					'condition' => array('$row["date_fin"] > 0', "{date_fin}", '')
				));

					
				$lstposte = $grid->get_dropdown_values("select DISTINCT id_poste as k, name_poste as v from db_postes ");
				UIGrid::add_cols($cols, 'poste', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Poste' : 'Job'), array(
					'dbname'=>'poste',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstposte),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstposte)
				));		
					
				$lstgroupe = $grid->get_dropdown_values("select DISTINCT id_groupe as k, name_groupe as v from db_groupes ");
				UIGrid::add_cols($cols, 'id_groupe', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Groupe' : 'Band'), array(
					'dbname'=>'id_groupe',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstgroupe),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstgroupe)
				));		

					
				$lstcolor = $grid->get_dropdown_values("select DISTINCT id_color as k, color as v from db_colors ");
				UIGrid::add_cols($cols, 'color', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Couleur' : 'Color'), array(
					'dbname'=>'color',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstcolor),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstcolor)
				));		

				$grid->set_events(array(
					'js_on_load_complete' => "dbgridmono",
				));
				$grid->set_columns($cols);
				return $grid->render("list_mono");

				break;
			
			case 'db_reglements':
				// $sql = "SELECT r.*, c.last_name, c.first_name, GROUP_CONCAT('<a href=\"fiche.php?id_fiche=',r.id_fiche,'\">',last_name,' ',first_name,'</a>') as contact FROM db_reglements r
				$sql = "SELECT r.*, c.last_name, c.first_name, CONCAT('<a href=\"fiche.php?id_fiche=',r.id_fiche,'\">',last_name,' ',first_name,'</a>') as contact, c.tot_ht,
								SUM(mt_rglt) as  Tot, 
								COUNT(*) as nb,
								(c.tot_ht - SUM(r.mt_rglt)) as reste
						FROM db_reglements r
						INNER JOIN db_contacts c ON c.id_fiche = r.id_fiche 
						WHERE r.id_sejour = ".$infosup." AND r.is_validate = 1
						GROUP BY r.id_fiche";

				
				$opt['height'] = 'auto';
				$opt["sortname"] = 'reste';
				$opt["sortorder"] = "DESC";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$cols = array();
				
				$cond["column"] = "id_sejour";
				$cond["target"] = "id_sejour";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_rglt";
				$cond["target"] = "id_rglt";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "is_validate";
				$cond["target"] = "is_validate";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#88bf50','color':'#000'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_fiche";
				$cond["target"] = "id_fiche";
				$cond["op"] = "<>";
				$cond["value"] = "";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_rglt', 'ID.', array('editable' => false,'width' => '0px', 'resizable'=>false));
				
				UIGrid::add_cols( $cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vue détails' : 'Details view'), array(
					// 'frozen'=>true,
					'align' => 'center', 
					'sortable' => false, 
					'search' => false, 
					'export' => false, 
					'width' => '70px', 
					'on_data_display' => array('display_rglt', '')
				));

				function display_rglt($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						. '<a href="#" data-id="'.$data['id_fiche'].'" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails des paiements' : 'Payments details').'" class="btn btn-xs btn-info btdetrglt" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-eye"></i></a>'
						. '</div>';

					return $btn;
				}

				$lstmd = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup);				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstmd,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstmd),
					'stype' => "select",
					'searchoptions' => array("value" => $lstmd),
				));


				UIGrid::add_cols($cols, 'contact', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ident. Client' : 'Customer ident.'), array(
					'dbname'=> "CONCAT(last_name,' ',first_name)",
					'editable'=>false,
					// 'on_data_display' => array('display_action_vir', ''),
				));

				// $lstcli = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(last_name,' ',first_name) as v from db_contacts ");
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Client' : 'Customer<br>number'), array(
						// 'dbname'=> "CONCAT(last_name,' ',first_name)",
						'dbname'=> "r.id_fiche",
						'editable' => false,
						'width'=>'0px',
						'resizable'=>false,
						'formatter' => 'select',
						'edittype' => "select",
						'editoptions' => array("value" => ":;" . $lstcli),
						'stype' => "select", //-multiple",
						'searchoptions' => array("value" => $lstcli),
				));

				UIGrid::add_cols($cols, 'tot_ht', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant dû' : 'Global amount'), array(
					'dbname'=> "c.tot_ht",
					'search'=> true,
				));

				UIGrid::add_cols($cols, 'Tot', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant Saisi<br>validé' : 'Amount entered<br>validate'), array(
					'dbname'=> "SUM(mt_rglt)",
					'search'=> false,
				));

				UIGrid::add_cols($cols, 'nb', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre' : 'Number'), array(
					'dbname'=> "COUNT(*)",
					'search'=> false,
				))
				;
				UIGrid::add_cols($cols, 'reste', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Reste' : 'The rest of'), array(
					'dbname'=> "(c.tot_ht - SUM(r.mt_rglt))",					
					'search'=> false,
				));


				$grid->set_columns($cols);
				
				$grid->set_options($opt);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_rglt");

				break;
			
			case 'details_reglements':
				$tbname = "db_reglements";
				// $sql = "SELECT r.*, c.last_name, c.first_name, GROUP_CONCAT('<a href=\"fiche.php?id_fiche=',r.id_fiche,'\">',last_name,' ',first_name,'</a>') as contact FROM db_reglements r
				$sql = "SELECT r.*, c.last_name, c.first_name, CONCAT('<a href=\"fiche.php?id_fiche=',r.id_fiche,'\">',last_name,' ',first_name,'</a>') as contact 
						FROM db_reglements r
						INNER JOIN db_contacts c ON c.id_fiche = r.id_fiche ".((int)$infosup2 > 0 ? " AND c.id_fiche = ".$infosup2 : "")."
						WHERE r.id_sejour = ".$infosup;
						// ORDER BY r.id_fiche";

						
				$opt['height'] = 'auto';
				$opt["sortname"] = 'r.id_fiche';
				$opt["sortorder"] = "DESC";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$cols = array();
				
				$cond["column"] = "id_rglt";
				$cond["target"] = "id_rglt";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "is_validate";
				$cond["target"] = "is_validate";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#88bf50','color':'#000'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_fiche";
				$cond["target"] = "id_fiche";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#FFF','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_rglt', 'ID.', array('editable' => false,'width' => '0px', 'resizable'=>false));
				
				$lstmd = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup);				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstmd,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstmd),
					'stype' => "select",
					'searchoptions' => array("value" => $lstmd),
				));


				UIGrid::add_cols($cols, 'contact', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ident. Client' : 'Customer ident.'), array(
					'dbname'=> "CONCAT(last_name,' ',first_name)",
					'editable'=>false,
					// 'on_data_display' => array('display_action_vir', ''),
				));

				$lstcli = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(last_name,' ',first_name) as v from db_contacts ".((int)$infosup2 > 0 ? " WHERE id_fiche = ".$infosup2 : ""));
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Client' : 'Customer<br>number'), array(
						'dbname'=> 'r.id_fiche',
						'editoptions'=> array("defaultValue"=>$lstcli,"readonly"=>'readonly',"style"=>"border:0"),
						'editable' => true,
						'width'=>'0px',
						'resizable'=>false,
						'formatter' => 'select',
						'edittype' => "select",
						'editoptions' => array("value" => "" . $lstcli),
						'stype' => "select", //-multiple",
						'searchoptions' => array("value" => $lstcli),
				));

				UIGrid::add_cols($cols, 'mt_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount'), array(
				));

				UIGrid::add_cols($cols, 'mode_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mode de<br>Règlement' : 'Payment <br>choice'), array(
					'editable' => true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Non défini;1:Espèce;2:Cb lien; 3:Cb Carte; 4:Chèque; 5:Virement; 6:Ancv; 7:Shkalim; 8:Chnéor; 9:Ezriel; 10:Avrum"),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "0:Non défini;1:Espèce;2:Cb lien; 3:Cb Carte; 4:Chèque; 5:Virement; 6:Ancv; 7:Shkalim; 8:Chnéor; 9:Ezriel; 10:Avrum"),
				));
				
				UIGrid::add_cols($cols, 'objet_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Objet du<br>Règlement' : 'Purpose of<br>the regulation'), array(
					'editable' => true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Autre;1:Séjour;2:Taxe; 3:Supplements; 4:Consommations; 5:Transport"),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "0:Autre;1:Séjour;2:Taxe; 3:Supplements; 4:Consommations; 5:Transport"),
				));

				UIGrid::add_cols($cols, 'is_validate', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Paiement<br>Validé' : 'Payment<br>validated'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));

				$grid->set_columns($cols);
				$grid->set_events(array(
					'on_update'=>array("update_detrglt", null, true),
					'on_insert'=>array("update_detrglt", null, true),
				));

				function update_detrglt(&$data) {

					if($data['params']['is_validate'] > 0){
						$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "%CLIENT SEJOUR%" ', true,'');
						$arr['id_status_sec'] = $stsec->id_status_sec;
						Fiche::update($arr, array('id_fiche'=>(int)$data['params']['id_fiche']));
					}					
				}
				
				$grid->set_options($opt);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_det_rglt");

				break;
			
			case 'inf_virements':
				$tbname = 'db_reglements';
				// $sql = "SELECT r.*, c.last_name, c.first_name, GROUP_CONCAT('<a href=\"fiche.php?id_fiche=',r.id_fiche,'\">',last_name,' ',first_name,'</a>') as contact FROM db_reglements r
				$sql = "SELECT r.*, c.last_name, c.first_name, CONCAT('<a href=\"fiche.php?id_fiche=',r.id_fiche,'\">',last_name,' ',first_name,'</a>') as contact FROM db_reglements r
						INNER JOIN db_contacts c ON c.id_fiche = r.id_fiche 
						WHERE r.is_card = 0";
						// ORDER BY r.id_fiche";

				
				$opt['height'] = 'auto';
				$opt["sortname"] = 'r.id_fiche';
				$opt["sortorder"] = "DESC";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$cols = array();
				
				$cond["column"] = "id_rglt";
				$cond["target"] = "id_rglt";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "is_validate";
				$cond["target"] = "is_validate";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#88bf50','color':'#000'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_fiche";
				$cond["target"] = "id_fiche";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#FFF','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "contact";
				$cond["css"] = "'background-color':'#FFF','color':'#FFF'"; 
				$cond_conditions[] = $cond;


				UIGrid::add_cols($cols, 'id_rglt', 'ID.', array('editable' => false,'width' => '0px', 'resizable'=>false));

				UIGrid::add_cols($cols, 'contact', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ident. Client' : 'Customer ident.'), array(
					'dbname'=> "CONCAT(last_name,' ',first_name)",
					'editable'=>false,
					// 'on_data_display' => array('display_action_vir', ''),
				));

				$lstcli = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(last_name,' ',first_name) as v from db_contacts ");
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Client' : 'Customer<br>number'), array(
						'dbname'=> 'r.id_fiche',
						'editable' => true,
						'width'=>'0px',
						'resizable'=>false,
						'formatter' => 'select',
						'edittype' => "select",
						'editoptions' => array("value" => ":;" . $lstcli),
						'stype' => "select", //-multiple",
						'searchoptions' => array("value" => $lstcli),
				));

				// function display_action_vir($data)
				// {
				// 	// echo(print_r($data));
				// 	global $usrActif;
				// 	$btn = "<div class='btn-group'>"
				// 		."<a href=fiche.php?id_fiche=".$data['id_fiche'].">".$data['last_name'].' '.$data['first_name']."</a>"
				// 		. "</div>";

				// 	return $btn;
				// }

					
				UIGrid::add_cols($cols, 'date_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date<br>règlement' : 'Date of<br>payment'), array(
					'dbname' => 'DATE(r.date_rglt)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d H:i:s', "newformat" => 'd/m/Y H:i'),
					'condition' => array('$row["date_rglt"] > 0', "{date_rglt}", '')
				));

				UIGrid::add_cols($cols, 'mt_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount'), $arrMt);

				UIGrid::add_cols($cols, 'mode_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mode de<br>Règlement' : 'Payment <br>choice'), array(
					'editable' => true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Non défini;1:Espèce;2:Cb lien; 3:Cb Carte; 4:Chèque; 5:Virement"),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "0:Non défini;1:Espèce;2:Cb lien; 3:Cb Carte; 4:Chèque; 5:Virement"),
				));

				UIGrid::add_cols($cols, 'objet_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Objet du<br>Règlement' : 'Purpose of<br>the regulation'), array(
					'editable' => true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Autre;1:Séjour;2:Taxe; 3:Supplements; 4:Consommations; 5:Transport"),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "0:Autre;1:Séjour;2:Taxe; 3:Supplements; 4:Consommations; 5:Transport"),
				));


				UIGrid::add_cols($cols, 'id_virement', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de règlement<br>(Chèque - Virement - Carte)' : 'Payment number <br>(Check - Payment - Card)'), array('editable' => true));
				UIGrid::add_cols($cols, 'is_validate', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Paiement<br>Validé' : 'Payment<br>validated'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));

				$grid->set_events(array(
					'js_on_load_complete' => "gridvirement",
					'on_after_update'=>array("update_after_rglt", null, false),
					'on_after_insert'=>array("update_after_rglt", null, false),
				));

				function update_after_rglt(&$data) {
					$data['params']['contact'] = "<a href=fiche.php?id_fiche=".$data['params']['id_fiche'].">".$data['params']['last_name'].' '.$data['params']['first_name']."</a>";
					$cntrglt = Reglements::countRglts(array('is_validate'=>'1'));

					$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "CLIENT CONFIRME" ', true,'');
					
					if((int)$cntrglt->NB > 0){
						Fiche::update(array('lnk_reglement'=>'1', 'id_status_sec' => $stsec->id_status_sec),array('id_fiche'=>$data['params']['id_fiche']));
					}else{
						Fiche::update(array('lnk_reglement'=>'0'),array('id_fiche'=>$data['params']['id_fiche']));
					}
				}

				$grid->set_columns($cols);
				
				$grid->set_options($opt);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_virement");

				break;
				
			
			case 'inf_virements_client':
				
				$tbname = 'db_reglements';
				// $sql = "SELECT r.*, c.last_name, c.first_name, GROUP_CONCAT('<a href=\"fiche.php?id_fiche=\"',r.id_fiche,'>',last_name,' ',first_name,'</a>') as contact FROM db_reglements r
				$sql = "SELECT r.*, c.last_name, c.first_name, CONCAT('<a href=\"fiche.php?id_fiche=',r.id_fiche,'\">',last_name,' ',first_name,'</a>') as contact FROM db_reglements r
						INNER JOIN db_contacts c ON c.id_fiche = r.id_fiche 
						WHERE r.is_card = 0
						AND r.id_fiche = ".(int)$infosup ;
						// GROUP BY r.id_fiche";

				
				$opt['height'] = 'auto';
				$opt["sortname"] = 'r.id_fiche';
				$opt["sortorder"] = "DESC";
				$opt["loadComplete"] = "function(ids) { gridvirementcli(ids); }";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$cols = array();
				
				$cond["column"] = "id_rglt";
				$cond["target"] = "id_rglt";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "is_validate";
				$cond["target"] = "is_validate";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#88bf50','color':'#000'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_fiche";
				$cond["target"] = "id_fiche";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#FFF','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "mt_restant";
				$cond["target"] = "mt_restant";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "contact";
				$cond["cellcss"] = "'background-color':'#FFF','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_rglt', 'ID.', array('editable' => false,'width' => '0px', 'resizable'=>false));

				$lstmd = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup2);				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstmd,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstmd),
					'stype' => "select",
					'searchoptions' => array("value" => $lstmd),
				));

				// $lstct = $grid->get_dropdown_values("select id_fiche as k, CONCAT(last_name,' ',first_name) as v from db_contacts WHERE id_fiche = ".$infosup);				
				// UIGrid::add_cols($cols, 'contact', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'ident. Client' : 'Customer ident.'), array(
				// 	'dbname'=> "CONCAT(last_name,' ',first_name)",
				// 	'hidden'=>true,
				// 	'width'=> '0px',
				// 	'editoptions'=> array("defaultValue"=>$lstct,"readonly"=>'readonly',"style"=>"border:0"),
				// 	'editable'=>false,
				// 	'formatter' => 'select',
				// 	'edittype' => "select",
				// 	'editoptions' => array("value" => "" . $lstct),
				// 	'stype' => "select",
				// 	'searchoptions' => array("value" => $lstct),
				// 	// 'on_data_display' => array('display_action_vir', ''),
				// ));

				$lstcli = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(last_name,' ',first_name) as v from db_contacts WHERE id_fiche = ".(int)$infosup );
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Client' : 'Customer<br>number'), array(
						'dbname'=> 'r.id_fiche',
						'editable' => true,
						'editoptions'=> array("readonly"=>'readonly',"style"=>"border:0"),
						'width'=>'0px',
						'resizable'=>false,
						'formatter' => 'select',
						'edittype' => "select",
						'editoptions' => array("value" => "" . $lstcli),
						'stype' => "select", //-multiple",
						'searchoptions' => array("value" => $lstcli),
				));

				// function display_action_vir($data)
				// {
				// 	// echo(print_r($data));
				// 	global $usrActif;
				// 	$btn = "<div class='btn-group'>"
				// 		."<a href=fiche.php?id_fiche=".$data['id_fiche'].">".$data['last_name'].' '.$data['first_name']."</a>"
				// 		. "</div>";

				// 	return $btn;
				// }

					
				UIGrid::add_cols($cols, 'date_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date<br>règlement' : 'Date of<br>payment'), array(
					'dbname' => 'DATE(r.date_rglt)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d H:i:s', "newformat" => 'd/m/Y H:i'),
					'condition' => array('$row["date_rglt"] > 0', "{date_rglt}", '')
				));

				UIGrid::add_cols($cols, 'mt_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount'), $arrMt);
				UIGrid::add_cols($cols, 'mt_restant', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Reste' : 'Total remaining'), array(
					'width'=> '0px',
					'editoptions'=> array("readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>false,
					'search'=>false,
				));

				UIGrid::add_cols($cols, 'mode_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mode de<br>Règlement' : 'Payment<br>choice'), array(
					'editable' => true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Non défini;1:Espèce;2:Cb lien; 3:Cb Carte; 4:Chèque; 5:Virement; 6:Ancv; 7:Shkalim; 8:Chnéor; 9:Ezriel; 10:Avrum"),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "0:Non défini;1:Espèce;2:Cb lien; 3:Cb Carte; 4:Chèque; 5:Virement; 6:Ancv; 7:Shkalim; 8:Chnéor; 9:Ezriel; 10:Avrum"),
				));

				
				UIGrid::add_cols($cols, 'objet_rglt', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Objet du<br>Règlement' : 'Purpose of<br>the regulation'), array(
					'editable' => true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Autre;1:Séjour;2:Taxe; 3:Supplements; 4:Consommations; 5:Transport"),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "0:Autre;1:Séjour;2:Taxe; 3:Supplements; 4:Consommations; 5:Transport"),
				));

				UIGrid::add_cols($cols, 'id_virement', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de règlement<br>(Chèque - Virement - Carte)' : 'Payment number <br>(Check - Payment - Card)'), array('editable' => true));
				UIGrid::add_cols($cols, 'is_validate', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Paiement<br>Validé' : 'Payment<br>validated'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));

				$grid->set_events(array(
					// 'js_on_load_complete' => "gridvirementcli(ids)",
					'on_update'=>array("update_rglt", null, true),
					'on_update'=>array("update_rglt", null, true),
					'on_delete'=>array("delete_rglt", null, true),
					'on_after_update'=>array("update_after_rglt", "", true),
					'on_after_insert'=>array("update_after_rglt", "", true),
				));


				function update_rglt(&$data) {
					
					$data['params']['id_fiche'] = (int)$_GET['id_fiche'];
					
					$sum = Reglements::sumRglts(array('id_fiche'=>(int)$_GET['id_fiche']));
					
					if($sum->MT > 0){
						$clt = Fiche::findOne(array('id_fiche'=>(int)$_GET['id_fiche']));
						Fiche::update(array('tot_restant'=>($clt->tot_ht - $sum->MT) ),array('id_fiche'=>(int)$_GET['id_fiche']));
						Reglements::updateRglts(array('mt_restant'=>($clt->tot_ht - $sum->MT) ),array('id_fiche'=>(int)$_GET['id_fiche']));
						$data['params']['mt_restant'] = ($clt->tot_ht - $sum->MT);
					}
				}

				
				function delete_rglt(&$data) {
					
					$rglts = QueryExec::querySQL('SELECT * FROM db_reglements WHERE id_fiche = '.(int)$_GET['id_fiche'].' AND is_validate = 1 AND id_rglt != '.$data['id_rglt'] , true);
					
					if(!$rglts){
						Fiche::update(array('lnk_reglement'=>'0'),array('id_fiche'=>(int)$_GET['id_fiche']));
					}
				}
				
				function update_after_rglt(&$data) {
					// print_r($data);
					// die;
					// $data['params']['contact'] = "<a href=fiche.php?id_fiche=".$data['params']['id_fiche'].">".$data['params']['last_name'].' '.$data['params']['first_name']."</a>";

					if((int)$data['params']['is_validate'] > 0){
						$stsec = QueryExec::querySQL('SELECT id_status_sec FROM db_status_secs WHERE name_status_sec LIKE "CLIENT CONFIRME" ', true,'');
					
						Fiche::update(array('lnk_reglement'=>'1', 'id_status_sec' => $stsec->id_status_sec),array('id_fiche'=>(int)$_GET['id_fiche']));
					}
					/* ON GARDE LE LNK_REGLEMENT POUR AU MOINS 1 RGLT VALIDATE */
					// else{
					// 	Fiche::update(array('lnk_reglement'=>'0'),array('id_fiche'=>$data['params']['id_fiche']));
					// }

				}

				$grid->set_columns($cols);
				
				$grid->set_options($opt);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_virement_client");

				break;
				
			case 'db_postes':
				$sql = "SELECT * FROM db_postes";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				


				$cols = array();
				UIGrid::add_cols($cols, 'id_poste', 'ID.', array('editable' => false,'width' => 70));
				UIGrid::add_cols($cols, 'name_poste', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fonction' : 'Job'), array('editable' => true,'width' => 70));
				

				$grid->set_events(array(
					'js_on_load_complete' => "gridposte",
				));
				$grid->set_columns($cols);
				return $grid->render("list_postes");

				break;
			
			case 'db_activites':
				$sql = "SELECT * FROM db_activites";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				


				$cols = array();
				UIGrid::add_cols($cols, 'id_activite', 'ID.', array('editable' => false,'width' => 70));
				UIGrid::add_cols($cols, 'name_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé' : 'Label'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'lieu_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lieu' : 'Place'), array('editable' => true,'width' => 70), array(
					'editable' => true,
					'edittype' => 'textarea',
					'editoptions' => array("rows" => 5, "cols" => 80)
				));
				UIGrid::add_cols($cols, 'details_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails' : 'Details'), array(
					'editable' => true,
					'edittype' => 'textarea',
					'editoptions' => array("rows" => 5, "cols" => 80)
				));
				UIGrid::add_cols($cols, 'is_kid', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Extra' : 'Extra'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				
				UIGrid::add_cols($cols, 'prix_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prix activité' : 'Price activity'), array('editable' => true,'width' => 70));

				$grid->set_events(array(
					'js_on_load_complete' => "gridactivite",
				));
				$grid->set_columns($cols);
				return $grid->render("list_activites");

				break;
			
			case 'db_enfants':
				$sql = "SELECT * FROM db_enfants WHERE id_sejour = ".$infosup;

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				


				$cols = array();

				$cond["column"] = "id_sejour";
				$cond["target"] = "id_sejour";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_enfant', 'ID.', array('editable' => false,'width' => 70));
				
				$lstmd = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup);				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstmd,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstmd),
					'stype' => "select",
					'searchoptions' => array("value" => $lstmd),
				));

				UIGrid::add_cols($cols, 'last_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Last name'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'first_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First name'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'age', 'Age', array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'id_genre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Genre' : 'Type'), array(
					'dbname' => 'id_genre',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Mixte;1:Garcon;2:Fille"),
					'stype' => "select",
					'searchoptions' => array("value" => "0:Mixte;1:Garcon;2:Fille")
				));
				UIGrid::add_cols($cols, 'date_arrivee', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date debut' : 'Start date'), array(
					'editable' => true,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_arrivee"] > 0', "{date_arrivee}", ''),
					'editrules' => array("required"=>true)
				));

				UIGrid::add_cols($cols, 'date_depart', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date fin' : 'End date'), array(
					'editable' => true,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_depart"] > 0', "{date_depart}", ''),
					'editrules' => array("required"=>true)
				));

				UIGrid::add_cols($cols, 'tel_pere', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tel. Pere' : 'Phone number<br>father'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'tel_mere', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tel. Mere' : 'Phone number<br>mother'), array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'num_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Chambre' : 'Room<br>number'), array('editable' => true,'width' => 50));

				$lstgroupe = $grid->get_dropdown_values("select DISTINCT id_groupe as k, name_groupe as v from db_groupes ");
				UIGrid::add_cols($cols, 'id_groupe', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Groupe' : 'Band'), array(
					'dbname'=>'id_groupe',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstgroupe),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstgroupe)
				));	

				UIGrid::add_cols($cols, 'infos', 'Informations', array(
					'editable' => true,
					'edittype' => 'textarea',
					'editoptions' => array("rows" => 5, "cols" => 80)
				));
				
				$grid->set_events(array(
					'js_on_load_complete' => "gridenfant",
					"on_update" => array("update_enf", null, true),
					"on_insert" => array("insert_enf", null, true),
					"on_delete" => array("delete_enf", null, true)
				));
				
				function insert_enf(&$data){
					$grp = Groupes::findQuery($data['params']['age'].' BETWEEN age_deb AND age_end AND id_genre = '.$data['params']['id_genre'], true);
					if($grp->id_groupe > 0){
						$data['params']['id_groupe'] = $grp->id_groupe;
					}else{
						$grp = 	Groupes::findQuery($data['params']['age'].' BETWEEN age_deb AND age_end', true);
						$data['params']['id_groupe'] = $grp->id_groupe;
					}
				}

				function update_enf(&$data){
					// echo(print_r($data));
					$grp = Groupes::findQuery($data['params']['age'].' BETWEEN age_deb AND age_end AND id_genre = '.$data['params']['id_genre'], true);
					
					if($grp->id_groupe > 0){
						$data['params']['id_groupe'] = $grp->id_groupe;
					}else{
						$grp = 	Groupes::findQuery($data['params']['age'].' BETWEEN age_deb AND age_end', true);
						$data['params']['id_groupe'] = $grp->id_groupe;
					}
				}
				
				
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_enfants");

				break;
			
			
			case 'db_groupes':
				$sql = "SELECT * FROM db_groupes";

				$grid = UIGrid::getGrid('', $tbname, $sql);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				


				$cols = array();
				UIGrid::add_cols($cols, 'id_groupe', 'ID.', array('editable' => false,'width' => 70));
				UIGrid::add_cols($cols, 'name_groupe', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fonction' : 'Job'), array('editable' => true,'width' => 70));
				
				UIGrid::add_cols($cols, 'age_deb', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Age<br>debut' : 'Starting<br>age'), array(
					'dbname'=>'age_deb',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;1:1 an;2:2 ans;3:3 ans;4:4 ans;5:5 ans;6:6 ans;7:7 ans;8:8 ans;9: 9 ans;10:10 ans;11:11 ans" . $lstgroupe),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "1:1 an;2:2 ans;3:3 ans;4:4 ans;5:5 ans;6:6 ans;7:7 ans;8:8 ans;9: 9 ans;10:10 ans;11:11 ans")
				));	
				UIGrid::add_cols($cols, 'age_end', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Age<br>fin' : 'End<br>age'), array(
					'dbname'=>'age_end',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;1:1 an;2:2 ans;3:3 ans;4:4 ans;5:5 ans;6:6 ans;7:7 ans;8:8 ans;9: 9 ans;10:10 ans;11:11 ans" . $lstgroupe),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => "1:1 an;2:2 ans;3:3 ans;4:4 ans;5:5 ans;6:6 ans;7:7 ans;8:8 ans;9: 9 ans;10:10 ans;11:11 ans")
				));	

				UIGrid::add_cols($cols, 'id_genre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Genre' : 'Type'), array(
					'dbname' => 'id_genre',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Mixte;1:Garcon;2:Fille"),
					'stype' => "select",
					'searchoptions' => array("value" => "0:Mixte;1:Garcon;2:Fille")
				));
				$grid->set_events(array(
					'js_on_load_complete' => "gridgroupe",
				));
				$grid->set_columns($cols);
				return $grid->render("list_groupes");

				break;
			
			case 'db_status_secs':
				$sql = "SELECT * FROM db_status_secs";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt['height'] = 'auto';
				
				$cols = array();
				
				$cond["column"] = "id_status_sec";
				$cond["target"] = "id_status_sec";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;
				// $opt["loadComplete"] = "function(ids) { gridstsec_onload(ids); }";

				UIGrid::add_cols($cols, 'id_status_sec', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_status_sec', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom statut' : 'Status name'));
				UIGrid::add_cols($cols, 'status_color', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Couleur' : 'Color'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;#fff:Blanc;#f97979:Rouge;#9fdaff:Bleu;#c3f8c1:Vert clair;#5ab557:Vert;#efc466:Orange;#f7f30a:Jaune;#a88332:Maron;#e85ada:Fushia"),
					'stype' => "select",
					'searchoptions' => array("value" => '#fff:Blanc;#f97979:Rouge;#9fdaff:Bleu;#c3f8c1:Vert clair;#5ab557:Vert;#efc466:Orange;#f7f30a:Jaune;#a88332:Maron;#e85ada:Fushia')
				));

				function check_delete_status_sec($data)
				{

					$sec = Setting::getStSec(array('id_status_sec'=>$data['id_status_sec']));
					
					if(strstr(trim(strtoupper($sec->name_status_sec)),'ANNULATION') 
								|| strstr(trim(strtoupper($sec->name_status_sec)),'CLIENT GENERAL') 
								|| strstr(trim(strtoupper($sec->name_status_sec)),'DEMANDE DE DEVIS') 
								|| strstr(trim(strtoupper($sec->name_status_sec)),'RETOUR DEMANDE DEVIS') 
								|| strstr(trim(strtoupper($sec->name_status_sec)),'ENVOI DEVIS FINAL')
								|| strstr(trim(strtoupper($sec->name_status_sec)),'INSCRIPTION SIGNE')
								|| strstr(trim(strtoupper($sec->name_status_sec)),'ENVOI CONTRAT POUR SIGNATURE')
								|| strstr(trim(strtoupper($sec->name_status_sec)),'CLIENT CONFIRME')){
									phpgrid_error('CE STATUT EST UTILISÉ PAR DEFAUT ! SUPPRISSION IMPOSSIBLE.');
									die;
								}

					$ct = Fiche::findOne(array('c.id_status_sec' => $data['id_status_sec']));
					if ($ct) {
						phpgrid_error('CE STATUT EST UTILISÉ PAR UN CLIENT ! MOFIFIER LE STATUT DES CLIENTS QUI UTILISENT CE STATUT AVANT DE LE SUPPRIMER.');
						die;
					}
				}

				function check_update_status_sec($data)
				{
					$sec = Setting::getStSec(array('id_status_sec'=>$data['id_status_sec']));
					// print_r($data);
					// die;
					
					if((strstr(trim(strtoupper($sec->name_status_sec)),'ANNULATION')  && $data['params']['name_status_sec'] != 'ANNULATION')
								|| (strstr(trim(strtoupper($sec->name_status_sec)),'CLIENT GENERAL')  && $data['params']['name_status_sec'] != 'CLIENT GENERAL')
								|| (strstr(trim(strtoupper($sec->name_status_sec)),'DEMANDE DE DEVIS')  && $data['params']['name_status_sec'] != 'DEMANDE DE DEVIS')
								|| (strstr(trim(strtoupper($sec->name_status_sec)),'RETOUR DEMANDE DEVIS')  && $data['params']['name_status_sec'] != 'RETOUR DEMANDE DEVIS')
								|| (strstr(trim(strtoupper($sec->name_status_sec)),'ENVOI DEVIS FINAL')  && $data['params']['name_status_sec'] != 'ENVOI DEVIS FINAL')
								|| (strstr(trim(strtoupper($sec->name_status_sec)),'INSCRIPTION SIGNE')  && $data['params']['name_status_sec'] != 'INSCRIPTION SIGNE')
								|| (strstr(trim(strtoupper($sec->name_status_sec)),'CLIENT CONFIRME')  && $data['params']['name_status_sec'] != 'CLIENT CONFIRME')
								|| (strstr(trim(strtoupper($sec->name_status_sec)),'ENVOI CONTRAT POUR SIGNATURE')  && $data['params']['name_status_sec'] != 'ENVOI CONTRAT POUR SIGNATURE')
								){
									phpgrid_error('CE STATUT EST UTILISÉ PAR DEFAUT ! MODIFICATION IMPOSSIBLE.');
									die;
								}
				}

				$grid->set_options($opt);
				$grid->set_events(array(
					"on_delete" => array("check_delete_status_sec", null, true),
					"on_update" => array("check_update_status_sec", null, true),
				));

				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_status_sec");

				break;

			case 'db_mailtypes':
				$sql = "SELECT * FROM db_mailtypes";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$opt = array();
				$grid->set_options($opt);
				
				$grid->set_actions(array('add'=> false, 'edit'=> false, 'delete'=> true, 'view'=>false, 'clone'=>false, 'export_pdf'=>false, 'export_excel'=>false, 'export_csv'=>false, 'search'=>false, 'showhidecolumns'=>false,  'rowactions'=>false));
				$cols = array();

				$cond["column"] = "id_mailtype";
				$cond["target"] = "id_mailtype";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_mailtype', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_mailtype', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom template' : 'Template name'));
				UIGrid::add_cols($cols, 'subject', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject'));
				
				UIGrid::add_cols($cols, 'attach', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pièces jointes' : 'Attachments'), array('editable' => false,'on_data_display' => array('display_attach', '')));
				
				function display_attach($data) {
					global $template;
					$str = '';
					if ($data['attach'] != '') {
						$ats = json_decode($data['attach']);
						foreach($ats as $at) {
							if (Tool::isImage($at))
								$str .= '<img src="'.$template['url'].'/uploads/mailtypes/'.$at.'" title="'.$at.'" />&nbsp;';
							else
								$str = '<i class="fa fa-file-pdf-o" title="'.$at.'" style="font-size:24px;"></i>&nbsp;';
						}
					}
					
					return $str;
				}

				UIGrid::add_cols($cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitement' : 'Treatment'), array(
					'editable' => false,
					'align'=>'center', 
					'sortable'=>false, 
					'search'=>false,
					'export' => false,
					'on_data_display' => array('display_action', ''))
				);
				
				function display_action($data) {
					$btn = '<a href="#" data-id="'.$data['id_mailtype'].'" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifier' : 'Modify').'" class="btn btn-xs btn-success btupdmailtype" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-edit"></i></a> <a href="#" data-id="'.$data['id_mailtype'].'" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer' : 'Delete').'" class="btn btn-xs btn-danger btdelmailtype" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-trash"></i></a>';

					return $btn;
				}
				
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_mailtypes");				
				
				break;
				
			case 'db_smstypes':
				$sql = "SELECT * FROM db_smstypes";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$opt = array();
				$grid->set_options($opt);
				
				$grid->set_actions(array('add'=> false, 'edit'=> false, 'delete'=> true, 'view'=>false, 'clone'=>false, 'export_pdf'=>false, 'export_excel'=>false, 'export_csv'=>false, 'search'=>false, 'showhidecolumns'=>false,  'rowactions'=>false));
				$cols = array();

				$cond["column"] = "id_smstype";
				$cond["target"] = "id_smstype";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_smstype', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_smstype', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom template' : 'Template name'));

				UIGrid::add_cols($cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitement' : 'Treatment'), array(
					'align'=>'center', 
					'sortable'=>false, 
					'search'=>false,
					'export' => false,
					'on_data_display' => array('display_actionsms', ''))
				);
				
				function display_actionsms($data) {
					$btn = '<a href="#" data-id="'.$data['id_smstype'].'" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifier' : 'Modify').'" class="btn btn-xs btn-success btupdsmstype" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-edit"></i></a> <a href="#" data-id="'.$data['id_smstype'].'" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer' : 'Delete').'" class="btn btn-xs btn-danger btdelsmstype" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-trash"></i></a>';

					return $btn;
				}
				
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_smstypes");				
				
				break;	
			
			case 'db_profils':
				$sql = "SELECT * FROM db_profils";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt["sortable"] = true;
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$opt['width'] = '100%';
				$opt['height'] = 'auto';
				$opt["autowidth"] = true;
				$opt["shrinkToFit"] = false;
				
				$cols = array();

				$cond["column"] = "id_profil";
				$cond["target"] = "id_profil";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_profil', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_profil', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom du<br>Profile' : 'Profil<br>name'));

				/* STATS */
				UIGrid::add_cols($cols, 'visu_stats', 'Acces stats', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	

				UIGrid::add_cols($cols, 'valide_stats', 'Validation stats', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	

				UIGrid::add_cols($cols, 'valide_repas', 'Validation repas', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	

				UIGrid::add_cols($cols, 'print_repas', 'Impression repas', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* STATS */


				/* RAPPELS */
				UIGrid::add_cols($cols, 'visu_calendar_rappel', 'Acces palnning<br>des rappels', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'acces_page_client_calendar_rappel', 'Acces lien<br>planning des rappels', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'add_client_calendar_rappel', 'Ajout d\'un rappel', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* RAPPELS */

				/* CLIENTS */
				UIGrid::add_cols($cols, 'visu_client', 'Acces liste<br>des clients', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'create_client', 'Ajout client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'edit_clean_room', 'Impression nettoyage<br>chambres', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'email_libre', 'Envoi email Libre', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'del_client', 'Suppression<br>client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'send_mail_client', 'Envoi mail<br>Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'send_sms_client', 'Envoi sms<br>Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'change_statut_client', 'modif statut<br>Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'add_rappel_client', 'Ajouter un rappel<br>Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'print_list_room', 'Impression des<br>romm list', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'visu_fiche_client', 'Acces fiche<br>Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	

				/* Au niveau de la fiche */
				UIGrid::add_cols($cols, 'send_mail_fiche_client', 'Envoi mail<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'send_sms_fiche_client', 'Envoi sms<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'annule_fiche_client', 'Annulation.<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_fiche_client', 'Modif<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'imp_doc_fiche_client', 'Impression doc.<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));		
				UIGrid::add_cols($cols, 'add_comment_fiche_client', 'Ajout Commentaire<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'add_rappel_fiche_client', 'Ajout rappel<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'add_doc_fiche_client', 'Ajout doc.<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'send_doc_fiche_client', 'Envoi doc.<br>fiche Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				
				UIGrid::add_cols($cols, 'paiement_fiche_client', 'Paiement Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_devise_fiche_client', 'Modi. de la<br>devise Client', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'visu_planning_ch', 'Acces planning<br>de chambrest', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* Au niveau de la fiche */

				/* INBOX */
				UIGrid::add_cols($cols, 'visu_mail_inbox', 'Acces mail<br>société', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'send_mail_inbox', 'Envoi mail<br>société', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* INBOX */

				/* OUTBOX */
				UIGrid::add_cols($cols, 'visu_mail_outbox', 'Acces mail<br>Crm', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'send_mail_outbox', 'Envoi mail<br>Crm', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* OUTBOX */

				/* STRIPE */
				UIGrid::add_cols($cols, 'visu_infos_stripe', 'Acces infos.<br>paiment en ligne', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* STRIPE */

				/* SETTING */
				UIGrid::add_cols($cols, 'visu_settings', 'Acces parametrages', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_sejour', 'Modif sejours', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_statut_sec', 'Modif état dossier', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_profil', 'Modif profil<br>et droits', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_tarifs', 'Modif tarifications', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_type_loc', 'Modif type et vue<br>des chambres', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_chambre', 'Modif des chambres', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				
				UIGrid::add_cols($cols, 'duplique_sejour', 'dupliquer<br> chambres', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_fournisseur', 'Modif des fournisseurs', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_unite', 'Modif des unités', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_stock_produit', 'Modif des stocks', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_plat', 'Modif des plats', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_plat_details', 'Modif des<br>infos. plats', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_menu', 'Modif des<br>menus', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_mail_type', 'Modif des<br>mails type', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_sms_type', 'Modif des<br>sms type', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* SETTING */

				/* KIDS CLUB */
				UIGrid::add_cols($cols, 'visu_enfants', 'Acces aux<br>enfants', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'visu_monos', 'Acces aux monos', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* KIDS CLUB */

				/* PLANING CH */
				UIGrid::add_cols($cols, 'visu_plannig_chambre', 'Acces au planning<br>des chambres', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'link_chambre', 'Lien vers<br>chambres', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* PLANING CH */

				/* CMD FOURNISSEUR */
				UIGrid::add_cols($cols, 'visu_cmd_fournisseur', 'Acces aux commandes<br>fournisseurs', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'add_rapp_cmd', 'Ajout rappel<br>fournisseur', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'add_cmd', 'Ajout commande<br>fournisseur', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'send_mail_fournisseur', 'Envoi mail<br>fournisseur', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'print_cmd_fournisseur', 'Imprimer commande<br>fournisseur', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* CMD FOURNISSEUR */

				/* PAIEMENT */
				UIGrid::add_cols($cols, 'visu_rglt', 'Acces aux règlements', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'add_rglt', 'Ajout règlement', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'modif_rglt', 'Modif des règlements', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				/* PAIEMENT */

				$grid->set_events(array(
					"on_update" => array("update_opt", null, true),
					"on_insert" => array("update_opt", null, true),
				));
				
				function update_opt(&$data) {
					if(strstr(strtoupper($data['params']['name_profil']),'ADMIN')){
						$data['params']['visu_stats'] = '1';
						$data['params']['valide_stats'] = '1';
						$data['params']['valide_repas'] = '1';
						$data['params']['print_repas'] = '1';
						$data['params']['visu_calendar_rappel'] = '1';
						$data['params']['acces_page_client_calendar_rappel'] = '1';
						$data['params']['add_client_calendar_rappel'] = '1';
						$data['params']['visu_client'] = '1';
						$data['params']['create_client'] = '1';
						$data['params']['edit_clean_room'] = '1';
						$data['params']['email_libre'] = '1';
						$data['params']['del_client'] = '1';
						$data['params']['send_mail_client'] = '1';
						$data['params']['send_sms_client'] = '1';
						$data['params']['change_statut_client'] = '1';
						$data['params']['add_rappel_client'] = '1';
						$data['params']['print_list_room'] = '1';
						$data['params']['visu_fiche_client'] = '1';
						$data['params']['send_mail_fiche_client'] = '1';
						$data['params']['send_sms_fiche_client'] = '1';
						$data['params']['annule_fiche_client'] = '1';
						$data['params']['modif_fiche_client'] = '1';
						$data['params']['imp_doc_fiche_client'] = '1';
						$data['params']['add_comment_fiche_client'] = '1';
						$data['params']['add_rappel_fiche_client'] = '1';
						$data['params']['add_doc_fiche_client'] = '1';
						$data['params']['send_doc_fiche_client'] = '1';
						$data['params']['paiement_fiche_client'] = '1';
						$data['params']['modif_devise_fiche_client'] = '1';
						$data['params']['visu_planning_ch'] = '1';
						$data['params']['visu_mail_inbox'] = '1';
						$data['params']['send_mail_inbox'] = '1';
						$data['params']['visu_mail_outbox'] = '1';
						$data['params']['send_mail_outbox'] = '1';
						$data['params']['visu_infos_stripe'] = '1';
						$data['params']['visu_settings'] = '1';
						$data['params']['modif_sejour'] = '1';
						$data['params']['modif_statut_sec'] = '1';
						$data['params']['modif_profil'] = '1';
						$data['params']['modif_tarifs'] = '1';
						$data['params']['modif_type_loc'] = '1';
						$data['params']['modif_chambre'] = '1';
						$data['params']['duplique_sejour'] = '1';
						$data['params']['modif_fournisseur'] = '1';
						$data['params']['modif_unite'] = '1';
						$data['params']['modif_stock_produit'] = '1';
						$data['params']['modif_plat'] = '1';
						$data['params']['modif_plat_details'] = '1';
						$data['params']['modif_menu'] = '1';
						$data['params']['modif_mail_type'] = '1';
						$data['params']['modif_sms_type'] = '1';
						$data['params']['visu_enfants'] = '1';
						$data['params']['visu_monos'] = '1';
						$data['params']['visu_plannig_chambre'] = '1';
						$data['params']['link_chambre'] = '1';
						$data['params']['visu_cmd_fournisseur'] = '1';
						$data['params']['add_rapp_cmd'] = '1';
						$data['params']['add_cmd'] = '1';
						$data['params']['send_mail_fournisseur'] = '1';
						$data['params']['print_cmd_fournisseur'] = '1';
						$data['params']['visu_rglt'] = '1';
						$data['params']['add_rglt'] = '1';
						$data['params']['modif_rglt'] = '1';
					}
					
				}

				$grid->set_options($opt);
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);

				return $grid->render("list_profils");

				break;

			case 'db_devises':
				$sql = "SELECT * FROM db_devises";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$opt["height"] = "100%";
				$grid->set_options($opt);

				$cond["column"] = "devise_en_cours";
				$cond["target"] = "code_devise";
				$cond["op"] = "=";
				$cond["value"] = "1";
				$cond["cellcss"] = "'background-color':'#ff851b','color':'#000'"; 
				$cond_conditions[] = $cond;
				
				$cols = array();
				UIGrid::add_cols($cols, 'id_devise', 'Id.', array('editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'code_devise', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code devise' : 'Currency code'),array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;EUR:EUR;USD:USD;CAD:CAD;AUD:AUD;CHF:CHF;ILS:ILS"),
					'stype' => "select",
					'searchoptions' => array("value" => 'EUR:EUR;USD:USD;CAD:CAD;AUD:AUD;CHF:CHF;ILS:ILS')					
				));

				UIGrid::add_cols($cols, 'name_devise', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé devise' : 'Currency name'), array(
					'editable' => false,
				));

				UIGrid::add_cols($cols, 'devise_en_cours', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Devise<br>en cours' : 'Current<br>currency'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	

				$grid->set_events(array(
					"on_update" => array("update_devise", null, true),
					"on_insert" => array("update_devise", null, true),
					"on_after_update" => array("update_after_devise", null, false),
					"on_after_insert" => array("update_after_devise", null, false)
				));
				
				function update_devise(&$data) {
					// echo(print_r($data));
					// die;
					if($data['params']['code_devise'] == 'EUR'){
						$dv = 'Monnaie Européenne';
					}
					if($data['params']['code_devise'] == 'USD'){
						$dv = 'Dollar USA';
					}
					if($data['params']['code_devise'] == 'CAD'){
						$dv = 'Dollar Cannadien';
					}
					if($data['params']['code_devise'] == 'AUD'){
						$dv = 'Dollar Australien';
					}
					if($data['params']['code_devise'] == 'CHF'){
						$dv = 'Franc Suisse';
					}
					if($data['params']['code_devise'] == 'ILS'){
						$dv = 'Shekel Israelien';
					}
					
					$data['params']['name_devise'] = $dv;
					
				}
				
				function update_after_devise(&$data) {
					
					$dvcours = Setting::getAllDevises(array('devise_en_cours'=>'1'));

					if($dvcours->num_rows <= 0){
						$dvmin = Setting::updateDevisesSql("SELECT MIN(id_devise) as iddv FROM db_devises", true);
							
						if((int)$dvmin->iddv > 0){
							$res = Setting::updateDevisesSql("UPDATE db_devises SET devise_en_cours = 1 WHERE id_devise = ".$dvmin->iddv);
							$res = Setting::updateDevisesSql("UPDATE db_devises SET devise_en_cours = 0 WHERE id_devise != ".$dvmin->iddv);
						}
						phpgrid_error(($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vous devez avoir une devise en cours<br>La 1ere a été prise par defaut' : 'You must have a current currency<br>The 1st was taken by default'));
						die;
					}

					if($dvcours->num_rows == 1){
						foreach($dvcours as $dvc){
							if((int)$dvc['id_devise'] != $data['id_devise'] && $data['params']['devise_en_cours'] > 0){
								$res = Setting::updateDevisesSql("UPDATE db_devises SET devise_en_cours = 0 WHERE id_devise != ".$data['id_devise']);
							}
						}
					}

					if($dvcours->num_rows > 1){
						if($data['params']['devise_en_cours'] > 0){
							$res = Setting::updateDevisesSql("UPDATE db_devises SET devise_en_cours = 0 WHERE id_devise != ".$data['id_devise']);
						}else{
							$dvmin = Setting::updateDevisesSql("SELECT MIN(id_devise) as iddv FROM db_devises", true);
							
							if((int)$dvmin->iddv > 0){
								$res = Setting::updateDevisesSql("UPDATE db_devises SET devise_en_cours = 1 WHERE id_devise = ".$dvmin->iddv);
								$res = Setting::updateDevisesSql("UPDATE db_devises SET devise_en_cours = 0 WHERE id_devise != ".$dvmin->iddv);
							}
							phpgrid_error(($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Vous ne devez avoir qu'une devise en cours<br>La 1ere a été prise par defaut" : "You must only have one current currency<br>The 1st was taken by default"));
							die;
						}
					}
				}

				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_devises");

				break;

			case 'db_tarifs':
				$sql = "SELECT * FROM db_tarifs";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$opt["height"] = "100%";
				$grid->set_options($opt);
				
				$cols = array();
				
				$cond["column"] = "id_tarif";
				$cond["target"] = "id_tarif";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_tarif', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'libelle_tarif', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé<br>tarif' : 'Tariff<br>label'));
				UIGrid::add_cols($cols, 'de_age_tarif', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'A partir<br>de' : 'From'), array('hidden'=>true));
				UIGrid::add_cols($cols, 'a_age_tarif', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'jusqu\'a' : 'Up to'), array('hidden'=>true));
				UIGrid::add_cols($cols, 'age_tarif', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif' : 'Tariff'));

				$lstgroupe = $grid->get_dropdown_values("select DISTINCT id_groupe as k, name_groupe as v from db_groupes ");
				UIGrid::add_cols($cols, 'id_groupe', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Groupe' : 'Band'), array(
					'dbname'=>'id_groupe',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstgroupe),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstgroupe)
				));	
				
				UIGrid::add_cols($cols, 'is_visible_inscript', 'Visible<br>inscription', array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));
				
				// UIGrid::add_cols($cols, 'tarif_adulte', 'Tarif adulte');
				// UIGrid::add_cols($cols, 'tarif_enfant', 'Tarif enfant');
				// UIGrid::add_cols($cols, 'tarif_bb', 'Tarif bb');
				// UIGrid::add_cols($cols, 'is_tarif_nuit', 'Tarfif<br>Nuit', array(
				// 	'editable' => true,
				// 	'formatter' =>  'checkbox',
				// 	'edittype' => 'checkbox',
				// 	'editoptions' => array('value'=>'true:false'),
				// ));	
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_tarifs");

				break;

			case 'db_fournisseurs':
				$sql = "SELECT * FROM db_fournisseurs";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$cols = array();

				$cond["column"] = "id_fournisseur";
				$cond["target"] = "id_fournisseur";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_fournisseur', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name'));
				UIGrid::add_cols($cols, 'adr_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adresse' : 'Adress'));
				UIGrid::add_cols($cols, 'code_post_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code postal' : 'Zip code'));
				UIGrid::add_cols($cols, 'city_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ville' : 'City'));
				UIGrid::add_cols($cols, 'country_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pays' : 'Country'));
				UIGrid::add_cols($cols, 'tel_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Téléphonne' : 'Phone number'));
				UIGrid::add_cols($cols, 'mail_fournisseur', 'Email');
				
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_fournisseurs");

				break;

			case 'db_unites':
				$sql = "SELECT * FROM db_unites";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$cols = array();

				$cond["column"] = "id_unite";
				$cond["target"] = "id_unite";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_unite', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_unite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé<br>(ex : Kg, L,..)' : 'Label<br>(ex : Kg, L,..)'));
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_unites");

				break;

			case 'db_plats':
				$sql = "SELECT * FROM db_plats";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$cols = array();

				$cond["column"] = "id_plat";
				$cond["target"] = "id_plat";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_plat', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_plat', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé' : 'Label'));
				UIGrid::add_cols($cols, 'desc_plat', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Descriptif' : 'Description'));
				UIGrid::add_cols($cols, 'base_nb_personne', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "NB personne(s)<br>minimum" : "minimum number<br>of people(s)"));
				UIGrid::add_cols($cols, 'type_personne', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Pour" : "For"), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Tout le monde;1:Adulte;2:Enfant;3:BB"),
					'stype' => "select",
					'searchoptions' => array("value" => '0:Tout le monde;1:Adulte;2:Enfant;3:BB')					
				));

				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);

				
				$grid->set_events(array(
					"on_update" => array("update_plat", null, true),
					"on_insert" => array("update_plat", null, true),
				));
				
				function update_plat(&$data) {
					
					if((int)$data['params']['base_nb_personne'] == 0){
						$data['params']['base_nb_personne'] = 10;
					};

				}
				
				return $grid->render("list_plats");

				break;

				
			case 'db_plats_details':
				$sql = "SELECT * FROM db_plats_details";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$cols = array();

				$cond["column"] = "id_plat_detail";
				$cond["target"] = "id_plat_detail";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_plat_detail', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				

				$lstpl = $grid->get_dropdown_values("select DISTINCT id_plat as k, name_plat as v from db_plats");
				UIGrid::add_cols($cols, 'id_plat', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Plat' : 'Main dish'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstpl),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstpl)
				));
				

				$lstprod = $grid->get_dropdown_values("select DISTINCT id_produit as k, name_produit as v from db_produits");
				UIGrid::add_cols($cols, 'id_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Produit' : 'Product'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstprod),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstprod)
				));
				

				$lstunit = $grid->get_dropdown_values("select DISTINCT id_unite as k, name_unite as v from db_unites");
				UIGrid::add_cols($cols, 'id_unite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Unité' : 'Unit'), array(
					'editable' => false,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstunit),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstunit)
				));

				$grid->set_events(array(
					"on_update" => array("update_pld", null, true),
					"on_insert" => array("update_pld", null, true)
				));
				
				function update_pld(&$data) {
					$unit = stock::stockSql("SELECT id_unite FROM db_produits WHERE id_produit = ".$data['params']['id_produit'], true);
					$data['params']['id_unite'] = $unit->id_unite;
					
				}

				UIGrid::add_cols($cols, 'val_plat_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valeur - Qte' : 'Value - Qte'));
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_plats_details");

				break;

			case 'db_menus':
				$sql = "SELECT * FROM db_menus";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$cols = array();

				$cond["column"] = "id_menu";
				$cond["target"] = "id_menu";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_menu', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));

				$lstplat = $grid->get_dropdown_values("select DISTINCT id_plat as k, name_plat as v from db_plats");
				UIGrid::add_cols($cols, 'id_plat', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Plat' : 'Main dish'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstplat),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstplat)
				));

				UIGrid::add_cols($cols, 'date_menu', 'Date', array(
					'editable' => true,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_menu"] > 0', "{date_menu}", '')
				));
				

				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_menus");

				break;

			case 'db_produits':
				$sql = "SELECT * FROM db_produits";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$cols = array();

				$cond["column"] = "id_produit";
				$cond["target"] = "id_produit";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "niv_alerte_produit";
				$cond["target"] = "niv_alerte_produit";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'red','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "niv_alerte_produit";
				$cond["target"] = "niv_alerte_produit";
				$cond["op"] = "=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'green','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_produit', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'name_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom du<br>produit' : 'Name product'));
				
				UIGrid::add_cols($cols, 'date_apro_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date<br>approvisionnement' : 'Supply<br>date'), array(
					'editable' => true,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_apro_produit"] > 0', "{date_apro_produit}", '')
				));

				UIGrid::add_cols($cols, 'desc_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Description du<br>Produit' : 'Product<br>description'));

				$lstfourn = $grid->get_dropdown_values("select DISTINCT id_fournisseur as k, name_fournisseur as v from db_fournisseurs");
				UIGrid::add_cols($cols, 'id_fournisseur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur' : 'Provider'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstfourn),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstfourn)
				));

				$lstunit = $grid->get_dropdown_values("select DISTINCT id_unite as k, name_unite as v from db_unites");
				UIGrid::add_cols($cols, 'id_unite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ?'Unité' : 'Unit'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstunit),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstunit)
				));

				UIGrid::add_cols($cols, 'val_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valeur - Qte' : 'Value - Qte'));
				UIGrid::add_cols($cols, 'code_barre_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code-Barre' : 'Bar code'));
				UIGrid::add_cols($cols, 'niv_alerte_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valeur - Qte<br>d\'alerte' : 'Alert<br>Value - Qte'));
				UIGrid::add_cols($cols, 'is_bar_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vente au bar' : 'Bar sales'),array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));
				UIGrid::add_cols($cols, 'prix_bar_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prix de vente' : 'Selling price'));
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_produits");

				break;

				
			case 'db_transports':
				$sql = "SELECT * FROM db_transports";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt['height'] = 'auto';
				$cols = array();

				$cond["column"] = "id_transport";
				$cond["target"] = "id_transport";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_transport', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'lib_transport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé' : 'Label'));

				UIGrid::add_cols($cols, 'tarif_transport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif<br>transport' : 'Transport rate'));

				
				$grid->set_options($opt);
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_transp");

				break;

			case 'db_contacts_transports_details':
				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_GET['id_fiche']));
				$sql = "SELECT * FROM db_contacts_transports_details WHERE id_fiche = ".$infosup ." AND id_sejour = ".$infosup2;
				$tbname = "db_contacts_transports_details";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true , 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt['width'] = '100%';
				$opt['height'] = 'auto';


				$opt["rowNum"] =  20;
				$opt["height"] = "100%";
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$opt["add_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$opt["edit_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$opt["delete_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$grid->set_options($opt);
				
				$cols = array();

				$cond["column"] = "id_fiche";
				$cond["target"] = "id_fiche";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_sejour";
				$cond["target"] = "id_sejour";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_contact_transport_detail";
				$cond["target"] = "id_contact_transport_detail";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_contact_transport_detail', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '0px', 'resizable'=>false));
				
				$lstct = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(last_name,' ',first_name) as v from db_contacts WHERE id_fiche = ".$infosup);
				
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Id client' : 'Customer id'), array(
					'dbname'=> 'id_fiche',
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$infosup,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'search'=>false,
					'resizable'=>false,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstct),
					'stype' => "select",
					'searchoptions' => array("value" => $lstct),
				));
				

				$lstsj = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup2);
				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstsj,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstsj),
					'stype' => "select",
					'searchoptions' => array("value" => $lstsj),
				));

				$lsttr = $grid->get_dropdown_values("select DISTINCT id_transport as k, lib_transport as v from db_transports");
				UIGrid::add_cols($cols, 'id_transport_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Transport' : 'Transport'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lsttr),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lsttr)
				));

				UIGrid::add_cols($cols, 'tarif_transport_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif' : 'Amount'), array(
					'editoptions'=> array("readonly"=>'readonly'),
				));
				UIGrid::add_cols($cols, 'last_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name'), array(
					'editoptions'=> array("defaultValue"=>$ct->last_name,"readonly"=>'readonly',"style"=>"border:0"),
				));

				$lstfirst = $grid->get_dropdown_values("SELECT DISTINCT id_contact_detail as k, first_name_detail as v FROM db_contacts_details WHERE id_fiche = ".$infosup);
				UIGrid::add_cols($cols, 'first_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First Name'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstfirst),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstfirst)
				));

				UIGrid::add_cols($cols, 'num_passport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Passeport' : 'Passport'), array(
					// 'width' => '50px',
				));
				UIGrid::add_cols($cols, 'type_transport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Type' : 'Type'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ":;0:Allée / Retour;1:Allée;2:Retour" : ":;0:Go / Return;1:Go;2:Return") ),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "0:Allée / Retour;1:Allée;2:Retour" : "0:Go / Return;1:Go;2:Return") )
				));

				UIGrid::add_cols($cols, 'date_depart', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Départ' : 'Departure'),array(
					'editable' => true ,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_depart"] > 0', "{date_depart}", ''),
					'editrules' => array("required"=>true)
				));
				UIGrid::add_cols($cols, 'lieu_depart', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lieu<br>départ' : 'Departure<br>location'), array(
					// 'width' => '50px',
				));
				UIGrid::add_cols($cols, 'date_arrive', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Arrivée' : 'Arrive'),array(
					'editable' => true ,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_arrive"] > 0', "{date_arrive}", ''),
					'editrules' => array("required"=>true)
				));
				UIGrid::add_cols($cols, 'lieu_arrive', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lieu<br>arrivée' : 'Arrive<br>location'), array(
					// 'width' => '50px',
				));
				UIGrid::add_cols($cols, 'infos_transport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Infos' : 'Infos'), array(
					'editable' => false ,
					'edittype'=> 'textarea',
					'editoptions'=> array("rows"=>2, "cols"=>20),
				));
				// UIGrid::add_cols($cols, 'is_p', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Payé' : 'Paid'), array(
				// 	'editable' => true,
				// 	'formatter' =>  'checkbox',
				// 	'edittype' => 'checkbox',
				// 	'editoptions' => array('value'=>'1:0'),
				// ));	

				
				$grid->set_events(array(
					"on_update" => array("update_tarif_transp_opts", null, true),
					"on_insert" => array("update_tarif_transp_opts", null, true),
					"on_after_update" => array("update_tot_transp_options", null, true),
					"on_after_insert" => array("update_tot_transp_options", null, true),
				));

				function update_tarif_transp_opts(&$data) {						
					$res = Tarif::findOneTransport(array('id_transport'=>(int)$data['params']['id_transport_detail']));
					$data['params']['tarif_transport_detail'] = $res->tarif_transport;
				}

				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_transports_details");

				break;

			case 'db_contacts_details_options':
				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_GET['id_fiche']));
				// $sql = "SELECT * FROM db_contacts_details WHERE type_detail = 1 AND id_fiche = ".$infosup;
				$sql = "SELECT * FROM db_contacts_details_options WHERE id_fiche = ".$infosup ." AND id_sejour = ".$infosup2;
				$tbname = "db_contacts_details_options";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => ($ct->lnk_contrat_signed > 1 ? false : true) , 'edit' => true, 'delete' => ($ct->lnk_contrat_signed > 1 ? false : true), 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				// $opt["sortname"] = 'date_doc';
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt['width'] = '100%';
				$opt['height'] = 'auto';


				$opt["rowNum"] =  20;
				$opt["height"] = "100%";
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$opt["add_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$opt["edit_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$opt["delete_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$grid->set_options($opt);
				
				$cols = array();

				$cond["column"] = "id_fiche";
				$cond["target"] = "id_fiche";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_sejour";
				$cond["target"] = "id_sejour";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_contact_detail_option";
				$cond["target"] = "id_contact_detail_option";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_contact_detail_option', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '0px', 'resizable'=>false));
				
				$lstct = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(last_name,first_name) as v from db_contacts WHERE id_fiche = ".$infosup);
				
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Id client' : 'Customer id'), array(
					'dbname'=> 'id_fiche',
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$infosup,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'search'=>false,
					'resizable'=>false,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstct),
					'stype' => "select",
					'searchoptions' => array("value" => $lstct),
				));
				
				
				if($arrAccess['isAdmin'] == '1'){
					UIGrid::add_cols( $cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Saisie<br>manuelle' : 'Manual<br>entry'), array(
						// 'frozen'=>true,
						'align' => 'center', 
						'editable' => false, 
						'sortable' => false, 
						'search' => false, 
						'export' => false, 
						'width' => '20px', 
						'on_data_display' => array('display_action_manu_option', '')
					));
				}

				function display_action_manu_option($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						. '<a href="#" data-toggle="tooltip2" data-id ="' . $data['id_fiche'] . '" data-id-detail="' . $data['id_contact_detail_option'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarification manuelle' : 'Manual pricing').'" class="btn btn-xs btn-info bttarifmanuoption" style="background-color:#e6e473d4 !important;border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-money"></i></a>'
						. '</div>';

					return $btn;
				}

				
				$lstsj = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup2);
				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstsj,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstsj),
					'stype' => "select",
					'searchoptions' => array("value" => $lstsj),
				));

				
				$lstlib = $grid->get_dropdown_values("select DISTINCT id_tarif as k, libelle_tarif as v from db_tarifs");
				UIGrid::add_cols($cols, 'id_lib_option', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé' : 'Name option'), array(
					// 'width'=> '0px',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstlib),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstlib),
				));
				

				UIGrid::add_cols($cols, 'qte_detail_option', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Qte' : 'Qte'), array(
					// 'width' => '50px',
				));

				UIGrid::add_cols($cols, 'tarif_detail_option', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif' : 'Price'), array(
					// 'width' => '50px',
					'editoptions'=> array("readonly"=>'readonly'),
				));

				UIGrid::add_cols($cols, 'tot_tarif_option', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Total' : 'Total'), array(
				));


				$grid->set_events(array(
					"on_update" => array("update_tarif_opts", null, true),
					"on_insert" => array("update_tarif_opts", null, true),
					"on_after_update" => array("update_tot_details_options", null, true),
					"on_after_insert" => array("update_tot_details_options", null, true),
				));

				function update_tarif_opts(&$data) {						
					$res = Tarif::findOne(array('id_tarif'=>(int)$data['params']['id_lib_option']));
					$data['params']['tarif_detail_option'] = $res->age_tarif;
					$data['params']['tot_tarif_option'] = $res->age_tarif * $data['params']['qte_detail_option'];
					
				}

				
				function update_tot_details_options(&$data) {
					$sumTarif = 0;
					$tarifNuit = false;
					$tarifSemaine = false;
					$tarifSejour = false;
					$arr= array();
					
					$ct = Fiche::findOne(array('c.id_fiche'=>$data['params']['id_fiche']));
					
					$res = Tarif::findOne(array('id_tarif'=>(int)$data['params']['id_lib_option']));
					// print_r($data);
					// die;
					Fiche::updateDetailsOptions(array('lib_detail_option'=>$res->libelle_tarif), array('id_contact_detail_option'=>(int)$data['id_contact_detail_option'])) ;
					
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

					$alldetails = Fiche::getAllDetails(array('id_fiche'=>$data['params']['id_fiche']));
					foreach($alldetails as $details){
						$sumTarif += $details['tarif_details'];
						$sumTarif += $details['tarif_transport'];
						$sumTarif += $details['tarif_supp_detail'];
					}

					$alldetailsOptions = Fiche::getAllDetailsOptions(array('id_fiche'=>$data['params']['id_fiche'], 'id_sejour'=>$data['params']['id_sejour']));
					foreach($alldetailsOptions as $detailsOptions){
						$sumTarif += $detailsOptions['tot_tarif_option'];
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

					// echo($sumTarif.' -- '.$tot);
					if((int)$ct->is_tot_manu > 0){
						// $totFinal = str_replace(array(' ',','),array(''),$ct->tot_ht);
						$totFinal = $ct->tot_ht;

						// pour tot reel
						$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin
						$totFinalReal += $ct->taxe_sejour;
						*/
					}else{
						$totFinal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						$totFinal += $ct->taxe_sejour;

						// pour tot reel
						$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin
						$totFinalReal += $ct->taxe_sejour;
						*/
					}
		
					$totFinalAcpt = ($totFinal  * (100 - $ct->accompte_25)) / 100;
					
					// $sum = Reglements::sumRglts(array('id_fiche'=>$ct->id_fiche));					
					// if($sum->MT > 0){
					// 	$tot_restant = ($totFinal - $sum->MT) ;
					// 	Reglements::updateRglts(array('mt_restant'=>$tot_restant),array('id_fiche'=>$ct->id_fiche));
					// }

					if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
						$arr['tot_ht'] = $totFinal;
						$arr['tot_real'] = $totFinalReal;
						$arr['mt_ok_ht'] = $totFinalAcpt;

						// pour tot reel
						// $totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
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
					*/
					$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
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
					Fiche::update($arr, array('id_fiche'=>$ct->id_fiche));
				}

				
				$grid->set_options($opt);
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_details_options");

				break;

			case 'db_contacts_details':
				/* ATTENTION il y a un display: none de la ligne search-toolbar de cette grille dans le css 
				#gview_list_details.ui-jqgrid-view div.ui-state-default.ui-jqgrid-hdiv div.ui-jqgrid-hbox table.ui-jqgrid-htable thead tr.ui-search-toolbar { display: none}
				*/
				$respUsr = UsrApp::whatIsProfile($usrActif);

				$ct = Fiche::findOne(array('c.id_fiche'=>(int)$_GET['id_fiche']));
				// $sql = "SELECT * FROM db_contacts_details WHERE type_detail = 1 AND id_fiche = ".$infosup;
				$sql = "SELECT * FROM db_contacts_details WHERE id_fiche = ".$infosup;
				$tbname = "db_contacts_details";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => ($respUsr == '' ? true : false) , 'edit' => true, 'delete' => ($respUsr == '' ? true : false), 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				// $opt["sortname"] = 'date_doc';
				$opt["sortname"] = "is_p DESC, age";
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt['width'] = '100%';
				$opt['height'] = 'auto';


				$opt["rowNum"] =  20;
				$opt["height"] = "100%";
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$opt["add_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$opt["edit_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				$opt["delete_options"]["success_msg"] = "Raffraichissez la page pour mettre a jour les Tarifs";
				// $opt["autowidth"] = true;
				// $opt["shrinkToFit"] = false;
				// $opt["scroll"] = true;
				//$opt["autoresize"] = true;
				// $opt['width'] = '200';
				$grid->set_options($opt);
				
				$cols = array();
				
				$cond["column"] = "id_fiche";
				$cond["target"] = "id_fiche";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_contact_detail', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Id client' : 'Customer id'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$infosup,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'search'=>false,
					// 'formatter' => 'select',
					// 'edittype' => "select",
					// 'editoptions' => array("value" => "" . $lstmd),
					// 'stype' => "select",
					// 'searchoptions' => array("value" => $lstmd),
				));

				
				if($arrAccess['isAdmin'] == '1'){
					UIGrid::add_cols( $cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Saisie<br>manuelle' : 'Manual<br>entry'), array(
						// 'frozen'=>true,
						'align' => 'center', 
						'editable' => false, 
						'sortable' => false, 
						'search' => false, 
						'export' => false, 
						'width' => '20px', 
						'on_data_display' => array('display_action_manu_tarif', '')
					));
				}

				function display_action_manu_tarif($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						. '<a href="#" data-toggle="tooltip2" data-id ="' . $data['id_fiche'] . '" data-id-detail="' . $data['id_contact_detail'] . '" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarification manuelle' : 'Manual pricing').'" class="btn btn-xs btn-info bttarifmanu" style="background-color:#e6e473d4 !important;border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-money"></i></a>'
						. '</div>';

					return $btn;
				}

				UIGrid::add_cols($cols, 'last_name_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Last name'), array(
					'width' => '80px',
					// "edittype" => "textarea",
					// 'editoptions'=> array("defaultValue"=>$infosup2, "rows"=>2, "cols"=>20),
					'editoptions'=> array("defaultValue"=>$infosup2),
				));
				UIGrid::add_cols($cols, 'first_name_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First name'), array(
					'width' => '80px',
					// "edittype" => "textarea",
					// "editoptions" => array("rows"=>2, "cols"=>20),
				));
				UIGrid::add_cols($cols, 'date_naissance_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de naissance' : 'Date of birth'), array(
					'hidden' => true,
					'editable' =>false,
					'width' => '75px',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_naissance_detail"] > 0', "{date_naissance_detail}", '')
				));
			
				UIGrid::add_cols($cols, 'age', 'Age', array(
					'editable' =>true,
					'width' => '35px',
					'formatter' =>'number',
					'formatoptions' => array("thousandsSeparator" => ",",
                                "decimalSeparator" => ".",
                                "decimalPlaces" => 0)

					// 'on_data_display' => array('display_format_age', '')
					)
				);

				// function display_format_age($data)
				// {
				// 	return str_replace('.00', '' ,(string)$data['params']['age']);
				// }

				
				$lstlib = $grid->get_dropdown_values("select DISTINCT id_tarif as k, libelle_tarif as v from db_tarifs");
				UIGrid::add_cols($cols, 'libelle_tarif_details', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libelle' : 'label'),  array(
					// 'width'=> '0px',
					'hidden'=>false,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstlib),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstlib),
				));

				UIGrid::add_cols($cols, 'tarif_details', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif<br>séjour' : 'Rate<br>stay'), array(
					'hidden'=>false,
					'editable' =>true,
					'width' => '55px',
				));


			/* OPTIONS MISES EN ATTENTE
				UIGrid::add_cols($cols, 'num_passport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Passeport' : 'Passport<br>number'), array(
					'width' => '85px',
					'editable' =>true,
				));

				
				$lstopt = $grid->get_dropdown_values("select DISTINCT id_option_chambre as k, lib_option_chambre as v from db_options_chambres ");			
				UIGrid::add_cols($cols, 'opt_lib_1', 'Option<br>1.',array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstopt ),
					'stype' => "select",
					'searchoptions' => array("value" => $lstopt )
				));

				UIGrid::add_cols($cols, 'opt_lib_2', 'Option<br>2.',array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstopt ),
					'stype' => "select",
					'searchoptions' => array("value" => $lstopt )
				));
				
				UIGrid::add_cols($cols, 'tarif_supp_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif<br>opt.' : 'Rate<br>opt.'), array(
					'editable' =>false,
					'width' => '55px',
				));

				$lsttransp = $grid->get_dropdown_values("select DISTINCT id_transport as k, lib_transport as v from db_transports");
				UIGrid::add_cols($cols, 'transport_detail', 'Transport',  array(
					// 'width'=> '0px',
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lsttransp), //;1:Vol+Navette;2:Vol seul;3:Navette seule"),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lsttransp), //"0:Aucun;1:Vol+Navette;2:Vol seul;3:Navette seule"),
				));
				
				UIGrid::add_cols($cols, 'tarif_transport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif<br>Transport' : 'Rate<br>transport'), array(
					'editable' =>false,
					'width' => '55px',
				));

				*/

				// UIGrid::add_cols($cols, 'volnavette', 'Vol +<br>navette', array(
				// 	'editable' => false,
				// 	'formatter' =>  'checkbox',
				// 	'edittype' => 'checkbox',
				// 	'editoptions' => array('value'=>'1:0'),
				// ));	
				// UIGrid::add_cols($cols, 'volseul', 'Vol <br>seul', array(
				// 	'editable' => false,
				// 	'formatter' =>  'checkbox',
				// 	'edittype' => 'checkbox',
				// 	'editoptions' => array('value'=>'1:0'),
				// ));	
				// UIGrid::add_cols($cols, 'navetteseule', 'Navette <br>seule', array(
				// 	'editable' => false,
				// 	'formatter' =>  'checkbox',
				// 	'edittype' => 'checkbox',
				// 	'editoptions' => array('value'=>'1:0'),
				// ));	

				
				// UIGrid::add_cols(
				// 	$cols,
				// 	'action',
				// 	'Traitements',
				// 	array(
				// 		'align' => 'center',
				// 		'editable'=>false,
				// 		'sortable' => false,
				// 		'search' => false,
				// 		'on_data_display' => array('display_transport', '')
				// 	)
				// );

				// function display_transport($data)
				// {
				// 	$btn = '<div class="btn-group"><a href="#" data-id="'.$data['id_contact_detail'] .'" data-vn="'.$data['volnavette'] .'" data-vs="'.$data['volseul'] .'" data-ns="'.$data['navetteseule'] .'" iddata-toggle="tooltip" title="Infos. transport" class="btn btn-xs btn-info bttransport" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-eye"></i></a></div>';

				// 	return $btn;
				// }
				
				$grid->set_events(array(
					"on_update" => array("update_age_details", null, true),
					"on_insert" => array("insert_age_details", null, true),
					"on_after_update" => array("update_tot", null, true),
					"on_after_insert" => array("update_tot", null, true),
				));
				
				function update_age_details(&$data) {
					// echo(print_r($data));
					global $paramIdCt;
					
					// if((int)$data['params']['date_naissance_detail'] > 0){
					// 	$dtn = $data['params']['date_naissance_detail']; 
					// 	$dj = date('Y-m-d');
					// 	$diff = date_diff(date_create($dtn), date_create($dj));
					// 	$data['params']['age'] =  $diff->format('%y');
					// }
					

					$res = Tarif::findOne(array('id_tarif'=>(int)$data['params']['libelle_tarif_details']));
					$data['params']['tarif_details'] = $res->age_tarif;

					$restariftransp = Tarif::findOneTransport(array('id_transport'=>(int)$data['params']['transport_detail']));
					$data['params']['tarif_transport'] = $restariftransp->tarif_transport;
					
					$tarifOption = 0;

					if((int)$data['params']['opt_lib_1'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_1']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					if((int)$data['params']['opt_lib_2'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_2']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					$data['params']['tarif_supp_detail']  = (double)$tarifOption;

					
					$resenf = Tarif::getEnfant();
					$resbb = Tarif::getBb();
					
					$enf = 0;
					$bb = 0;
					$ad = 0;

					$age = $data['params']['age'];
					if($age >= ($resbb->age_bb + 1) && $age <= $resenf->age_enfant){
						$data['params']['type_detail'] = 2;
					}
		
					if($age <= $resbb->age_bb){
						$data['params']['type_detail'] = 3;
					}
		
					if($age >= $resenf->age_enfant){
						$data['params']['type_detail'] = 1;
					}
				}
				
				function insert_age_details(&$data) {
					// echo(print_r($data));
					global $paramIdCt;
					
					$ct = Fiche::findOne(array('c.id_fiche'=>$data['params']['id_fiche']));
					// echo((int)strtotime($ct->date_start). '  ----- ' .(int)strtotime($ct->date_end));
					if((int)strtotime($ct->date_start) <=0 || (int)strtotime($ct->date_end) <=0 ){
						phpgrid_error("Vous devez indiquez les dates d'arrivée et de départ, avant de saisir les personnes participants au sejour !");
        				die;
					}else{
						// if((int)$data['params']['date_naissance_detail'] > 0){
						// 	echo((int)$data['params']['date_naissance_detail']);
						// 	$dtn = $data['params']['date_naissance_detail']; 
						// 	$dj = date('Y-m-d');
						// 	$diff = date_diff(date_create($dtn), date_create($dj));
						// 	$data['params']['age'] =  $diff->format('%y');
						// }
						
						$res = Tarif::findOne(array('id_tarif'=>(int)$data['params']['libelle_tarif_details']));
						$data['params']['tarif_details'] = $res->age_tarif;
	
					}

					$restariftransp = Tarif::findOneTransport(array('id_transport'=>(int)$data['params']['transport_detail']));
					$data['params']['tarif_transport'] = $restariftransp->tarif_transport;
					
					$tarifOption = 0;

					if((int)$data['params']['opt_lib_1'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_1']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					if((int)$data['params']['opt_lib_2'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_2']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					$data['params']['tarif_supp_detail']  = (double)$tarifOption;
					// echo($tarifOption.' --- '.print_r($data));

					
					$resenf = Tarif::getEnfant();
					$resbb = Tarif::getBb();
					
					$enf = 0;
					$bb = 0;
					$ad = 0;

					$age = $data['params']['age'];
					if($age >= ($resbb->age_bb + 1) && $age <= $resenf->age_enfant){
						$data['params']['type_detail'] = 2;
					}
		
					if($age <= $resbb->age_bb){
						$data['params']['type_detail'] = 3;
					}
		
					if($age >= $resenf->age_enfant){
						$data['params']['type_detail'] = 1;
					}

					$isCl = Fiche::findOne(array('id_fiche'=>(int)$data['params']['id_fiche']));
					
					// ajout des informations enfants dans le kidsclub
					// si la configuration est bien faite il ne peut pas y avoir > 1 ligne de resultat. Pour eviter toutes erreurs on limit
					$isGrps = Groupes::genericSql((int)$data['params']['age'].' BETWEEN age_deb AND age_end ', true);
					// error_log('retour groupe'.print_r($isGrps));
					if((int)$isGrps->id_groupe > 0 ){
						Enfants::create(array('last_name'=>$data['params']['last_name_detail'], 'first_name'=>$data['params']['first_name_detail'],
												'age'=>$data['params']['age'], 'date_arrivee'=>$isCl->date_start, 'date_depart'=>$isCl->date_end,
												'tel_pere'=>$isCl->tel1,'id_sejour'=>(int)$isCl->id_organisateur));
					}
					
				}

				function update_tot(&$data) {
					
					/* CONSERVER POUR CAS OU ON UTILISE LA DATE DE NAISSANCE
					// *****************************************************

					if((int)$data['params']['date_naissance_detail'] > 0){
						$dtn = $data['params']['date_naissance_detail']; 
						$dj = date('Y-m-d');
						$diff = date_diff(date_create($dtn), date_create($dj));
						Fiche::updateDetails(array('age' =>  $diff->format('%y')),array('id_contact_detail'=>(int)$data['id_contact_detail']));
						
					}
					*/


					$sumTarif = 0;
					$tarifNuit = false;
					$tarifSemaine = false;
					$tarifSejour = false;
					$arr= array();

					$ct = Fiche::findOne(array('c.id_fiche'=>$data['params']['id_fiche']));
					
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

					$alldetails = Fiche::getAllDetails(array('id_fiche'=>$data['params']['id_fiche']));
					foreach($alldetails as $details){
						$sumTarif += $details['tarif_details'];
						$sumTarif += $details['tarif_transport'];
						$sumTarif += $details['tarif_supp_detail'];
					}
					
        
					$alldetailsopts = Fiche::getAllDetailsOptions(array('id_fiche'=>$data['params']['id_fiche']));
					foreach($alldetailsopts as $detailsopts){
						$sumTarif += $detailsopts['tot_tarif_option'];
					}

					// echo('kkkkkkkk'.$sumTarif.' s: '.$semaine.' j:'.$jours.' dts '.$ct->date_start.' * '.$ct->date_end.' ---- '.print_r($date2->diff($date1)));

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

					// echo($sumTarif.' -- '.$tot);
					if((int)$ct->is_tot_manu > 0){
						// $totFinal = str_replace(array(' ',','),array(''),$ct->tot_ht);
						$totFinal = $ct->tot_ht;

						// pour tot reel
						$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin 
						$totFinalReal += $ct->taxe_sejour;
						*/
					}else{
						$totFinal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						$totFinal += $ct->taxe_sejour;

						// pour tot reel
						$totFinalReal = (($tot + $addTot)  * (100 - $ct->offre_sejour)) / 100;
						/* pas la taxe sur le real qui est le tot_fin 
						$totFinalReal += $ct->taxe_sejour;
						*/
					}
		
					$totFinalAcpt = ($totFinal  * (100 - $ct->accompte_25)) / 100;

					// $sum = Reglements::sumRglts(array('id_fiche'=>$ct->id_fiche));					
					// if($sum->MT > 0){
					// 	$tot_restant = ($totFinal - $sum->MT) ;
					// 	Reglements::updateRglts(array('mt_restant'=>$tot_restant),array('id_fiche'=>$ct->id_fiche));
					// }
		
					if(trim($ct->code_devise) == '' || trim($ct->code_devise) == 'EUR'){
						$arr['tot_ht'] = $totFinal;
						$arr['tot_real'] = $totFinalReal;
						$arr['mt_ok_ht'] = $totFinalAcpt;
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
					*/
					$arr['tot_ht'] = $arr['tot_ht'] + $mtTransp;
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
					
					// if((int)$data['params']['volnavette'] == 0 && (int)$data['params']['volseul'] == 0 && (int)$data['params']['navetteseule'] == 0){
					// 	$data['params']['volnavette'] = '0';
					// 	$data['params']['volseul'] = '0';
					// 	$data['params']['navetteseule'] = '0';
					// }
					// if((int)$data['params']['volnavette'] == 1){
					// 	$data['params']['volnavette'] = '1';
					// 	$data['params']['volseul'] = '0';
					// 	$data['params']['navetteseule'] = '0';
					// }
					// if((int)$data['params']['volseul'] == 1){
					// 	$data['params']['volnavette'] = '0';
					// 	$data['params']['volseul'] = '1';
					// 	$data['params']['navetteseule'] = '0';
					// }
					// if((int)$data['params']['navetteseule'] == 1){
					// 	$data['params']['volnavette'] = '0';
					// 	$data['params']['volseul'] = '0';
					// 	$data['params']['navetteseule'] = '1';
					// }

					Fiche::update($arr, array('id_fiche'=>$ct->id_fiche));
					// phpgrid_msg("Download Zip: <a target='_blank' href='http://google.com'>http://google.com</a>",0);
					// phpgrid_msg("Raffraichissez la page pour mettre a jour les Tarifs");
        			// die;


				}
				
				$grid->set_columns($cols);
				
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_details");

				break;

			case 'adultes':
				// $sql = "SELECT * FROM db_contacts_details WHERE type_detail = 1 AND id_fiche = ".$infosup;
				$sql = "SELECT * FROM db_contacts_details WHERE id_fiche = ".$infosup;
				$tbname = "db_contacts_details";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				// $opt["sortname"] = 'date_doc';
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt['width'] = '100%';
				$opt['height'] = 'auto';


				$opt["rowNum"] =  20;
				$opt["height"] = "100%";
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				
				$grid->set_options($opt);
				
				$cols = array();
				UIGrid::add_cols($cols, 'id_contact_detail', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'last_name_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Last name'));
				UIGrid::add_cols($cols, 'first_name_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First name'));
				UIGrid::add_cols($cols, 'date_naissance_detail', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date<br>naissance' : 'Date of<br>birth'), array(
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_naissance_detail"] > 0', "{date_naissance_detail}", '')
				));
			
				UIGrid::add_cols($cols, 'age', 'Age', array(
					'editable' =>false,
				));

				UIGrid::add_cols($cols, 'num_passport', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Passeport' : 'Passport<br>number'), array(
					'editable' =>true,
				));

				UIGrid::add_cols($cols, 'type_detail', 'Type<br>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? '(1:Adulte;2:Enfant;3:BB)' : '(1:Adult;2:Children;3:BB)'), array(
					'on_data_display' => array('display_types', '')
				));
				
				function display_types($data) {
					foreach($data as $k=>$v){
						if($k=='type_detail'){					
							
							$btn =  "<div style='box-shadow: -5px -5px 10px; background-color:".((int)$v == 1 ? '#dae3f2' : ((int)$v == 2 ? '#e6e6a5' : '#a5e6c3'))."'>".((int)$v == 1 ? 'Adulte' : ((int)$v == 2 ? 'Enfant' : 'BB'))."</div>";	
							return $btn;
						}
					}
				}
				
				$grid->set_events(array(
					"on_update" => array("update_age", null, true),
					"on_insert" => array("update_age", null, true)
				));
				
				function update_age(&$data) {
					// echo(print_r($data));
					global $paramIdCt;
					
					$dtn = $data['params']['date_naissance_detail']; 
					$dj = date('Y-m-d');
					$diff = date_diff(date_create($dtn), date_create($dj));
					$data['params']['age'] =  $diff->format('%y');

									
					$ageAdulte = Tarif::getAdulte('');
					$ageEnfant = Tarif::getEnfant('');
					$ageBb = Tarif::getBb('');

					if((int)$diff->format('%y') <= (int)$ageBb->age_bb){
						$data['params']['type_detail'] = 3;
					}

					if((int)$diff->format('%y') > (int)$ageBb->age_bb && (int)$diff->format('%y') <= (int)$ageEnfant->age_enfant){
						$data['params']['type_detail'] = 2;
					}

					if((int)$diff->format('%y') >= (int)$ageAdulte->age_adulte){
						$data['params']['type_detail'] = 1;
					}

					$data['params']['id_fiche'] = $paramIdCt;
				}

				$grid->set_columns($cols);
				return $grid->render("list_adultes");

				break;

			case 'db_contacts_chambres':
				$sql = "SELECT * FROM db_contacts_chambres WHERE id_fiche = ".$infosup;
				$tbname = "db_contacts_chambres";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				// $opt['width'] = '100%';
				$opt['height'] = 'auto';
				$opt["autowidth"] = true;
				$opt["shrinkToFit"] = false;


				$opt["rowNum"] =  20;
				
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$grid->set_options($opt);

				$cols = array();
				UIGrid::add_cols($cols, 'id_contact_chambre', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'num_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° Chambre' : 'Room<br>number'));
				
				$grid->set_columns($cols);
				return $grid->render("list_ct_ch");

				break;

			case 'db_types_chambres':
				$sql = "SELECT * FROM db_types_chambres ";
				$tbname = "db_types_chambres";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				// $opt['width'] = '100%';
				$opt['height'] = 'auto';
				$opt["autowidth"] = true;
				$opt["shrinkToFit"] = false;


				$opt["rowNum"] =  20;
				
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$grid->set_options($opt);

				$cols = array();
				UIGrid::add_cols($cols, 'id_type_chambre', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'name_type_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé du Type<br>de Chambre' : 'Label<br>room type'), array(
					'width' => '800px',
				));
				
				$grid->set_columns($cols);
				return $grid->render("list_types_ch");

				break;

			case 'db_vues_chambres':
				$sql = "SELECT * FROM db_vues_chambres ";
				$tbname = "db_vues_chambres";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => false));
				
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt["scroll"] = false;
				$opt["width"] = "500";
				$opt["cmTemplate"] = array("width"=>"400");
				$opt['height'] = 'auto';
				$opt["autowidth"] = true;
				$opt["shrinkToFit"] = false;


				$opt["rowNum"] =  20;
				
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$grid->set_options($opt);

				$cols = array();
				UIGrid::add_cols($cols, 'id_loc_chambre', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'name_loc_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé de vue<br>de la Chambre' : 'Label<br>type view'), array(
					// 'width' => '400px',
				));
				
				$grid->set_columns($cols);
				return $grid->render("list_loc_ch");

				break;

			case 'db_options_chambres':
				$sql = "SELECT * FROM db_options_chambres ";
				$tbname = "db_options_chambres";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => false));
				
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt["scroll"] = false;
				// $opt["width"] = "500";
				// $opt["cmTemplate"] = array("width"=>"400");
				$opt['height'] = 'auto';
				// $opt["autowidth"] = true;
				// $opt["shrinkToFit"] = false;


				$opt["rowNum"] =  20;
				
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$grid->set_options($opt);

				$cols = array();
				UIGrid::add_cols($cols, 'id_option_chambre', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'lib_option_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libellé de l\'option' : 'OPtion label'), array());
				UIGrid::add_cols($cols, 'tarif_option_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tarif de l\'option' : 'Tariff option'), array());
				
				$grid->set_columns($cols);
				return $grid->render("list_opt_ch");

				break;

			case 'db_chambres':
				$idsejour = $infosup;

				$sql = "SELECT * FROM db_chambres WHERE id_sejour = ".$infosup;
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				$opt['height'] = 'auto';
				
				$cols = array();

				// $cond["column"] = "tarif_chambre";
				// $cond["target"] = "tarif_chambre";
				// $cond["op"] = ">";
				// $cond["value"] = "0";
				// $cond["cellcss"] = "'background-color':'#ff851b','color':'#000'"; 
				// $cond_conditions[] = $cond;

				$cond["column"] = "id_sejour";
				$cond["target"] = "id_sejour";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#FFF','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_chambre";
				$cond["target"] = "id_chambre";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#FFF','color':'#FFF'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_chambre', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));

				$lstmd = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup);
				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstmd,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstmd),
					'stype' => "select",
					'searchoptions' => array("value" => $lstmd),
				));
				UIGrid::add_cols($cols, 'num_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Chambre' : 'N°<br>Room'),array('editable' => true,'width' => 70));
				UIGrid::add_cols($cols, 'communique_ch', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N°<br>Communiquante' : 'Connecting<br>number'), array('editable' => true,'width' => 115));
				UIGrid::add_cols($cols, 'etage', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etage' : 'Floor'), array('editable' => true,'width' => 150));

				
				$lstt = $grid->get_dropdown_values("select DISTINCT id_type_chambre as k, name_type_chambre as v from db_types_chambres ");
				UIGrid::add_cols($cols, 'type_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Type<br>chambre' : 'Room<br>type'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstt ),
					'stype' => "select",
					'searchoptions' => array("value" => $lstt )
				));
				
				$lstloc = $grid->get_dropdown_values("select DISTINCT id_loc_chambre as k, name_loc_chambre as v from db_vues_chambres ");
				UIGrid::add_cols($cols, 'vue_chambre', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Vue<br>chambre' : 'Room<br>view'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstloc ),
					'stype' => "select",
					'searchoptions' => array("value" => $lstloc )
				));

				
				/*
				// EN COMMENTAIRE POUR CETTE VERSION
				// CONSERVEE CAR PLUS LOGIQUE
				// AVEC LE SET_EVENTS
				// ET LE NOMBRE DE  COUCHAGE =  CAPACITE SERA NON PLUS UN LIBELLE MAIS UN CALCUL
				// EX: 2 LITS DOUBLE ET 1 LIT SIMPLE = 3 COUCHAGE

				UIGrid::add_cols($cols, 'nb_lit_simple', 'Nb lit<br>simple', array(
					'editable' => true,
					// 'formatter' =>  'checkbox',
					// 'edittype' => 'checkbox',
					// 'editoptions' => array('value'=>'true:false'),
				));	
				UIGrid::add_cols($cols, 'nb_lit_double', 'Nb lit<br>double', array(
					'editable' => true,
					// 'formatter' =>  'checkbox',
					// 'edittype' => 'checkbox',
					// 'editoptions' => array('value'=>'true:false'),
				));	

				UIGrid::add_cols($cols, 'capacite', 'Capacité',array(
				));

				*/
				
				
				UIGrid::add_cols($cols, 'nb_lit_double', '<img src="../Dashboard/img/lit-double.png"/>',array(
				));
				UIGrid::add_cols($cols, 'nb_lit_simple', '<img src="../Dashboard/img/lit-simple.png"/>',array(
				));
				UIGrid::add_cols($cols, 'nb_lit_bb', '<img src="../Dashboard/img/lit-bb.png"/>',array(
				));
				UIGrid::add_cols($cols, 'nb_lit_sup', '<img src="../Dashboard/img/lit-sup.png"/>',array(
				));
				
				UIGrid::add_cols($cols, 'capacite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Capacité' : 'Capacity'),array(
				));
				
				UIGrid::add_cols($cols, 'terrasse_balcon', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Terrasse<br>Balcon' : 'Terrace<br>Balcony'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ":;0:Aucun;1:Terrasse;2:Balcon;3:Terrasse / Balcon" : ":;0:None;1:Terrace;2:Balcony;3:Terrace / Balcony") ),
					'stype' => "select",
					'searchoptions' => array("value" => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "0:Aucun;1:Terrasse;2:Balcon;3:Terrasse / Balcon" : "0:None;1:Terrace;2:Balcony;3:Terrace / Balcony") )
				));

			
			/* OPTIONS MISES EN ATTENTE
				UIGrid::add_cols($cols, 'piscine', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Piscine' : 'Pool'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? ":;0:Aucun;1:Privée;2:Partagée" : ":;0:None;1:Private;2:Share") ),
					'stype' => "select",
					'searchoptions' => array("value" => ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "0:Aucun;1:Privée;2:Partagée" : "0:None;1:Private;2:Share") )
				));
				

				$lstopt = $grid->get_dropdown_values("select DISTINCT id_option_chambre as k, lib_option_chambre as v from db_options_chambres ");			
				UIGrid::add_cols($cols, 'opt_lib_1', 'Option<br>1.',array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstopt ),
					'stype' => "select",
					'searchoptions' => array("value" => $lstopt )
				));

				UIGrid::add_cols($cols, 'opt_lib_2', 'Option<br>2.',array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstopt ),
					'stype' => "select",
					'searchoptions' => array("value" => $lstopt )
				));
			*/

				// UIGrid::add_cols($cols, 'opt_lib_3', 'Option<br>3.',array(
				// 	'formatter' => 'select',
				// 	'edittype' => "select",
				// 	'editoptions' => array("value" => ":;".$lstopt ),
				// 	'stype' => "select",
				// 	'searchoptions' => array("value" => $lstopt )
				// ));

				// UIGrid::add_cols($cols, 'opt_lib_4', 'Option<br>4.',array(
				// 	'formatter' => 'select',
				// 	'edittype' => "select",
				// 	'editoptions' => array("value" => ":;".$lstopt ),
				// 	'stype' => "select",
				// 	'searchoptions' => array("value" => $lstopt )
				// ));

				// UIGrid::add_cols($cols, 'opt_lib_5', 'Option<br>5.',array(
				// 	'formatter' => 'select',
				// 	'edittype' => "select",
				// 	'editoptions' => array("value" => ":;".$lstopt ),
				// 	'stype' => "select",
				// 	'searchoptions' => array("value" => $lstopt )
				// ));
				
				// UIGrid::add_cols($cols, 'tarif_chambre', 'Tarif<br>Supp.',array(
				// ));
				

				$grid->set_options($opt);
				$grid->set_events(array(
					"js_on_load_complete" => "gridAll",
					"on_update" => array("update_chambre", null, true),
					"on_insert" => array("insert_chambre", null, true),
				));
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);

				function update_chambre(&$data){
					$tarifOption = 0;
					
					$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));
					if($infgene->is_capacite_auto > 0){
						$data['params']['capacite']  = (int)$data['params']['nb_lit_simple'] + ((int)$data['params']['nb_lit_double'] * 2) + (int)$data['params']['nb_lit_bb'] + ((int)$data['params']['nb_lit_sup'] * 2); 
					}
					
					/* CONSERVE POUR AUTRE VERSION

					if((int)$data['params']['opt_lib_1'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_1']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					if((int)$data['params']['opt_lib_2'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_2']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					if((int)$data['params']['opt_lib_3'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_3']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					if((int)$data['params']['opt_lib_4'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_4']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					if((int)$data['params']['opt_lib_5'] > 0){
						$res = Chambres::findOneOptions(array('id_option_chambre'=>(int)$data['params']['opt_lib_5']));
						$tarifOption += (double)$res->tarif_option_chambre;
					}
					$data['params']['tarif_chambre']  = (double)$tarifOption;
					*/
				}
				
				return $grid->render("list_chambres");

				break;


			case 'db_users':
				$sql = "SELECT u.*, GROUP_CONCAT(t.name_type_alerte SEPARATOR ',') AS types 
							FROM db_users u 
							LEFT JOIN `db_users_type_alerte` a ON a.id_usrApp = u.id_usrApp 
							LEFT JOIN db_type_alertes t ON t.indice_type_alerte = a.indice_alerte";
				
				$sqlsup = '';
				
				$sql .= $sqlsup;
				$sql .= ' GROUP BY u.id_usrApp';

				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));

				$opt['height'] = 'auto';

				$cols = array();

				$cond["column"] = "id_usrApp";
				$cond["target"] = "id_usrApp";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_usrApp', 'Id.', array(
					'dbname' => 'u.id_usrApp',
					'editable' => false, 
					'width' => '0px', 
					'resizable'=>false
				));
				
				
				UIGrid::add_cols($cols, 'title_user', 'Civilité');
				UIGrid::add_cols($cols, 'user_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Name' : 'Last name'));
				if($arrAccess['isAdmin'] == '1'){
					UIGrid::add_cols($cols, 'psw_clear', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Password<br>en clair' : 'Display<br>password'));
				}
				
				UIGrid::add_cols($cols, 'email', 'Email');
				UIGrid::add_cols($cols, 'tel', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Tél' : 'Phone<br>number'));
				UIGrid::add_cols($cols, 'tel2', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Portable' : 'Cellphone'));

				$lstprofils = $grid->get_dropdown_values("select DISTINCT id_profil as k, name_profil as v from db_profils");

				UIGrid::add_cols($cols, 'id_profil', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Profile' : 'Profil'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;" . $lstprofils),
					'stype' => "select",
					'searchoptions' => array("value" => $lstprofils)
				));

				UIGrid::add_cols(
					$cols,
					'action',
					($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitements' : 'Treatments'),
					array(
						'align' => 'center',
						'sortable' => false,
						'search' => false,
						'on_data_display' => array('display_action_usr', '')
					)
				);

				function display_action_usr($data)
				{
					$btn = '<div class="btn-group">
								<a href="#" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Infos. utilisateur' : 'User infos').'" class="btn btn-xs btn-info" onclick="showUsrApp(' . $data['id_usrApp'] . ')" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;margin-bottom: 10px"><i class="fa fa-eye"></i></a>'
					. ($data['email'] != 'admin@hotel.com' ? '<a href="#" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Suppression' : 'Delete').'" class="btn btn-xs btn-danger" onclick="deleteUsrApp(' . $data['id_usrApp'] . ')" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;margin-bottom: 10px"><i class="fa fa-trash"></i></a>' : '')
					. '</div>';

					return $btn;
				}

				$grid->set_options($opt);
				$grid->set_events(array('js_on_load_complete' => "gridAll",
										"on_update" => array("update_usr", null, true),
										"on_insert" => array("insert_usr", null, true),
										"on_delete" => array("delete_usr", null, true),
									));
									
				function delete_usr(&$data){
					if($data['params']['email']  == 'admin@hotel.com'){
						ob_start();
						phpgrid_error(ob_get_clean());
					} 
					
				}

				$grid->set_columns($cols);

				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_UsrApps");

				break;

			case 'db_sejours':
				$sql = "SELECT * FROM db_organisateurs";
				$tbname = 'db_organisateurs';
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				
				$opt['height'] = 'auto';

				$cols = array();
				$cond["column"] = "id_organisateur";
				$cond["target"] = "id_organisateur";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_organisateur', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'logolst', 'Logo', array('default' => '<img src="uploads/organisateurs/{logo_organisateur}" />', 'width' => '120px', 'editable'=>false));
				UIGrid::add_cols($cols, 'logo_organisateur', 'Logo', array(
					'show'=>array("list"=>false,"edit"=>true,"add"=>true),
					'editable'=>true, 
					'edittype'=>'file', 
					'upload_dir'=>'../Dashboard/uploads/organisateurs',					
					)
				);
				
				UIGrid::add_cols($cols, 'periode', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Période' : 'Period'),array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;0:Hiver;1:Eté"),
					'stype' => "select",
					'searchoptions' => array("value" => "0:Hiver;1:Eté")
				));

				UIGrid::add_cols($cols, 'name_organisateur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom du séjour' : 'Name of stay'));
				UIGrid::add_cols($cols, 'lieu_organisateur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lieu du séjour' : 'Place of stay'));
				UIGrid::add_cols($cols, 'date_start_organisateur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date début' : 'Start date'), array(
					'editable' => true ,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_start_organisateur"] > 0', "{date_start_organisateur}", ''),
					'editrules' => array("required"=>true)
				));
				UIGrid::add_cols($cols, 'date_end_organisateur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date fin' : 'End date'), array(
					'editable' => true ,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_end_organisateur"] > 0', "{date_end_organisateur}", ''),
					'editrules' => array("required"=>true)
				));

				UIGrid::add_cols($cols, 'taxe_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Taxe séjour' : 'City tax'));

				// UIGrid::add_cols($cols, 'desc_sejour', 'Informations<br>du séjour', array(
				// 	'editable' => false ,
				// 	'edittype'=> 'textarea',
				// 	'editoptions'=> array("rows"=>2, "cols"=>20),
				// ));

				/*
				UIGrid::add_cols(
					$cols,
					'action',
					'Informations<br>séjour ',
					array(
						'editable' => false ,
						'align' => 'center',
						'sortable' => false,
						'search' => false,
						'on_data_display' => array('display_action_sejour', ''),
						// 'width' => '10px'
					)
				);

				
				function display_action_sejour($data)
				{
					// echo(print_r($data));
					$btn = '<a href="#" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails et information du séjour' : 'Details and informations of the stay').'" class="btn btn-xs btn-primary btinfsejour" data-id="'.$data['id_organisateur'].'" style="border-radius: 100%;border: 2px solid white; margin-right: 4.5px; color:white" ><i class="fa fa-pencil"></i></a>';
					// $btn .= '<a href="#" data-toggle="tooltip2" title="Détails et information du séjour" class="btn btn-xs btn-danger btinfsejourENG" data-id="'.$data['id_organisateur'].'" style="border-radius: 100%;border: 2px solid white; margin-right: 4.5px; color:blue" ><i class="fa fa-pencil"></i> ANG</a>';
				
					return $btn;
				}	
				*/
				
				$opt['add_options'] = array('width' => '620');
				$opt['edit_options'] = array('width' => '620');
				$grid->set_options($opt);

				/*
				$grid->set_events(array(
					"on_update" => array("update_mand", null, true),
					"on_insert" => array("update_mand", null, true)
				));
				
				function update_mand(&$data) {
					$data['params']['logo_organisateur'] = str_replace('../uploads/organisateurs/', '', $data['params']['logo_organisateurs']); 
				}
				*/


				$grid->set_options($opt);
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_sejours");

				break;
	
			case 'db_organisateurs':
				$sql = "SELECT * FROM db_organisateurs";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				$cols = array();
				UIGrid::add_cols($cols, 'id_organisateur', 'Id.', array('editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'logolst', 'Logo', array('default' => '<img src="uploads/organisateurs/{logo_organisateur}" />', 'width' => '120px', 'editable'=>false));
				UIGrid::add_cols($cols, 'logo_organisateur', 'Logo', array(
					'show'=>array("list"=>false,"edit"=>true,"add"=>true),
					'editable'=>true, 
					'edittype'=>'file', 
					'upload_dir'=>'../Dashboard/uploads/organisateurs',					
					)
				);
				UIGrid::add_cols($cols, 'signlst', 'Signature', array('default' => '<img src="uploads/organisateurs/{sign_mandator}" />', 'width' => '120px', 'editable'=>false));
				UIGrid::add_cols($cols, 'sign_mandator', 'Signature', array(
					'show'=>array("list"=>false,"edit"=>true,"add"=>true),
					'editable'=>true, 
					'edittype'=>'file', 
					'upload_dir'=>'../Dashboard/uploads/organisateurs',			
					)
				);
				UIGrid::add_cols($cols, 'name_organisateur', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Raison sociale' : 'Social reason'));
				UIGrid::add_cols($cols, 'first_name_mand', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Last name'));
				UIGrid::add_cols($cols, 'last_name_mand', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prénom' : 'First name'));
				UIGrid::add_cols($cols, 'fonction_mand', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fonction' : 'Job'));
				UIGrid::add_cols($cols, 'siret_mand', 'SIRET');
				UIGrid::add_cols($cols, 'ape_mand', 'APE');
				UIGrid::add_cols($cols, 'num_declaration_mand', 'N° déclaration');
				UIGrid::add_cols($cols, 'adr_mand', 'Adr.');
				UIGrid::add_cols($cols, 'post_code_mand', 'CP');
				UIGrid::add_cols($cols, 'city_mand', 'Ville');
				UIGrid::add_cols($cols, 'tel1_mand', 'Tel 1');
				UIGrid::add_cols($cols, 'tel2_mand', 'Tel 2');
				UIGrid::add_cols($cols, 'fax_mand', 'Fax');
				UIGrid::add_cols($cols, 'email_mand', 'Email');
				UIGrid::add_cols($cols, 'name_banque_mand', 'Banque');
				UIGrid::add_cols($cols, 'code_banque_mand', 'Code BQ');
				UIGrid::add_cols($cols, 'code_guichet_mand', 'Code Guichet');
				UIGrid::add_cols($cols, 'num_compte_mand', 'N° Compte');
				UIGrid::add_cols($cols, 'cle_mand', 'Clé');
				UIGrid::add_cols($cols, 'iban_mand', 'IBAN');
				UIGrid::add_cols($cols, 'bic_mand', 'BIC');
				UIGrid::add_cols($cols, 'footer_text', 'Texte footer doc.', array(
					'edittype' => 'textarea',
					'editoptions' => array("rows" => 5, "cols" => 80)
				));
				UIGrid::add_cols($cols, 'color', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Couleur' : 'Color'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;success:Vert;danger:Rouge;warning:Orange;info:Bleu;default:Gris"),
					'stype' => "select",
					'searchoptions' => array("value" => 'success:Vert;danger:Rouge;warning:Orange;info:Bleu;default:Gris')
				));
				$opt['add_options'] = array('width' => '620');
				$opt['edit_options'] = array('width' => '620');
				$grid->set_options($opt);

				/*
				$grid->set_events(array(
					"on_update" => array("update_mand", null, true),
					"on_insert" => array("update_mand", null, true)
				));
				
				function update_mand(&$data) {
					$data['params']['logo_organisateur'] = str_replace('../uploads/organisateurs/', '', $data['params']['logo_organisateurs']); 
				}
				*/


				$grid->set_columns($cols);
				return $grid->render("list_organisateurs");

				break;

			case 'db_crmactions':
				$sql = "SELECT a.*, u.user_name
						FROM db_crmaction a 
							LEFT JOIN db_users u ON u.id_usrApp = a.id_usrApp
							";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false, 'rowactions' => false));
				$opt["sortname"] = 'date_action';
				$opt["sortorder"] = "DESC";
				$grid->set_options($opt);

				$cols = array();
				UIGrid::add_cols($cols, 'id_crmaction', 'Id.', array('editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'date_action', 'Date action', array(
					'formatter' => 'date',
					"formatoptions" => array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d/m/Y H:i'),
					'condition' => array('$row["date_action"] > 0', "{date_action}", '')
				));
				
				UIGrid::add_cols($cols, 'type_action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Type action' : 'Action type'));
				UIGrid::add_cols($cols, 'user_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur' : 'User'));
				UIGrid::add_cols(
					$cols,
					'details_action',
					'Détails',
					array(
						'on_data_display' => array('display_details', '')
					)
				);

				function display_details($data)
				{
					$btn = '<a href="#" data-toggle="tooltip2" title="' . $data['details_action'] . '" class="btn btn-xs btn-success" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="gi gi-search"></i></a>';
					return $btn;
				}

				$grid->set_events(array('js_on_load_complete' => "gridAll"));
				$grid->set_columns($cols);
				return $grid->render("list_crmaction");
				break;

			case 'db_contacts_fact':
				// $sql = "SELECT cc.*, u.user_name, u.id_equipe, u.teams , p.id_profil, p.name_profil, t.name_equipe, CONCAT(c.last_name,' ',c.first_name) as name,
				$sql = "SELECT c.id_fiche, CONCAT(c.last_name,' ' ,c.first_name) as namect, c.num_dossier_edof, c.date_fac, c.numfac, c.tarif_formation, 
						c.tot_ht, c.paid_edof, c.acompte_fac, u.user_name, u.id_equipe, p.id_profil, p.name_profil, t.name_equipe,
						c.codekey, cd.name_doc
						FROM db_contacts c
						INNER JOIN db_users u ON c.id_usrApp = u.id_usrApp
						LEFT JOIN db_equipes t ON t.id_equipe = u.id_equipe
						LEFT JOIN db_contacts_docs cd ON c.id_fiche = cd.id_fiche AND `name_doc` LIKE 'FACTURE_%'
						INNER JOIN db_profils p ON p.id_profil = u.id_profil";
				
				$mtc1 = 0;
				$mtc2 = 0;

				$dates = explode('|',$infosup);
				if($dates[0] != '' && $dates[0] != 0){
					$dts = $dates[0];
					$dte = $dates[1];
				}
				$pred = '';
				$lstgrp = '';
				$wh = '';

				if($infosup2 == ''){
					$infosup2 = '0';
				}

				$wh = ($infosup != '' ? " (c.date_fac BETWEEN '" . explode('|', $infosup)[0] . "' AND '" . explode('|', $infosup)[1] . "' ) AND " : '');
				
				$sql .= " WHERE ". ($wh != '' ? $wh  : "") . ($infosup2 == '0' ? " ((c.numfac != '' OR c.numfac = '') ) " : ($infosup2 == '1' ? " c.numfac != '' " : " ( c.numfac = '') "));
					
				$idusr = 0;
				$typeusr=999;


				$grid = UIGrid::getGrid('', 'db_contacts', $sql, false, false);
				$grid->set_actions(array('add' => false, 'edit' => true, 'delete' => false, 'view' => false, 'clone' => false, 'autofilter' => true, 'export_pdf' => true, 'export_excel' => true, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => false));
				$cols = array();


				UIGrid::add_cols($cols, 'id_fiche', 'Id', array(
					'dbname'=> 'c.id_fiche',
					'editable' => false, 'width' => '10px'));
				UIGrid::add_cols($cols, 'Action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitements' : 'Treatments'), array(
					'editable' => false, 
					'width' => '10px',
					'on_data_display' => array('display_ct_fac', '')
				));
				UIGrid::add_cols($cols, 'namect', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client' : 'Customer'),array(
					'editable' => false, 
					'dbname' => "CONCAT(c.last_name,' ' ,c.first_name)",
					'width' => 70
				));
				

				function display_ct_fac($data)
				{
					
					$btn = '<a href="fiche.php?id_fiche='.$data['id_fiche'].'" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Acces a la fiche' : 'Open folder').'" class="btn btn-xs btn-info" data-id="'.$data['id_fiche'].'" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-eye"></i></a>';
					
					return $btn;
				}


				UIGrid::add_cols($cols, 'date_fac', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date <br>Facture' : 'Bill <br>date'), array(
					'width' => '30px',
					'editable' => false,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_fac"] > 0', "{date_fac}", ''),
					'editrules' => array("required"=>true)
				));

				UIGrid::add_cols($cols, 'numfac', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° <br>Facture' : 'Bill <br>number'), array(
					'editable' => false,
					'width' => '20px',
				));

				UIGrid::add_cols($cols, 'tot_ht', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mt<br>Facturé' : 'Amount<br>charged'), array(
					'hidden' => false,
					'editable' => true,
					'editrules' => array("readonly"=>true),
					'width' => '20px',
				));

				UIGrid::add_cols($cols, 'acompte_fac', ($usrActif->lang == 'FR' || $usrActif->lang == '' ?'Mt<br>Acompte' : 'Deposit<br>amount'), array(
					'editable' => true, 
					'width' => '30px'
				));

				UIGrid::add_cols($cols, 'name_doc', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom du<br>document' : 'Document<br>name'), array(
                    'dbname' => 'cd.name_doc',
                    'editable' => false,
                    'on_data_display' => array('display_linkdoc', ''),
                    'align' => 'left',
					'width' => '70px'
                ));
				
                function display_linkdoc($data) {                   
                    global $template;
					// die($template['url'].'/uploads/'.$data['codekey'].$data['id_fiche'].'/'.$data['name_doc']);
					if(substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'mpeg' || substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'mpg' || substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'wav' || substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'mp3'){
						return '<audio controls style="width:180px;height:26px"><source src="'.$template['url'].'/uploads/'.$data['codekey'].$data['id_fiche'].'/'.$data['name_doc'].'"  type="audio/mpeg"></audio>';
					}else{
                    	return '<a href="'.$template['url'].'/uploads/'.$data['codekey'].$data['id_fiche'].'/'.$data['name_doc'].'"  data-toggle="lightbox-'.(strpos($data['name_doc'], '.pdf') !== false ? 'iframe' : 'image').'" style="margin-left:5px" target="new"><i class="fa fa-file-pdf-o"></i> '.$data['name_doc'].'</a>';
					}
				};
				
				$opt["multiselect"] = true;
				$opt["sortname"] = 'c.id_fiche';
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = true;
				$opt["rowList"] = array();	
				$opt["rowNum"] =  50;
				$opt['width'] = '100%';
				$opt['height'] = '50%';
				$opt["toppager"] = true;
				$opt["loadComplete"] = "function(ids) { $('[data-toggle=\"lightbox-iframe\"]').magnificPopup({type: 'iframe', image: {titleSrc: 'title'}, gallery:{enabled:true}}); $('[data-toggle=\"lightbox-image\"]').magnificPopup({type: 'image', image: {titleSrc: 'title'}, gallery:{enabled:true}}); }";
				
				$opt["rowList"] = array(20, 50, 100, 200);
				// $opt["subGrid"] = true;
				// $opt["subgridurl"] = "subgrid_detail.php";
				//$opt["toolbar"] = "top";
				
				// $opt["subgridparams"] = "user_name"; // comma sep. fields. will be POSTED from parent grid to subgrid, can be fetching using $_POST in subgrid
				$cond["column"] = "numfac";
				$cond["target"] = "numfac";
				$cond["op"] = "=";
				$cond["value"] = "";
				$cond["cellcss"] = "'background-color':'#fc5432','color':'#000'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "numfac";
				$cond["target"] = "numfac";
				$cond["op"] = "cn";
				$cond["value"] = "F";
				$cond["cellcss"] = "'background-color':'#2098e8','color':'#000'"; 
				$cond_conditions[] = $cond;

				// $cond["column"] = "acompte_fac";
				// $cond["target"] = "tot_ht";
				// $cond["op"] = "<";
				// $cond["value"] = "{tot_ht}";
				// $cond["cellcss"] = "'background-color':'#fc5432','color':'#000'"; 
				// $cond_conditions[] = $cond;

				$cond["column"] = "acompte_fac";
				$cond["target"] = "acompte_fac";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#ebcd54','color':'#000'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "paid_edof";
				$cond["target"] = "paid_edof";
				$cond["op"] = "eq";
				$cond["value"] = "1";
				$cond["cellcss"] = "'background-color':'#7eff21','color':'#000'"; 
				$cond_conditions[] = $cond;

				$grid->set_events(array(
					// 'js_on_load_complete' => "func_gettot_fac()",
					'on_render_excel' => array("export_contacts", null, true),
					'on_render_pdf' => array("export_contacts", null, true),
					'on_update' => array("update_paid_fact", null, true),
					// 'on_after_update' => array("after_update_paid_fact", null, false)
				));

				function update_paid_fact($data){
					// echo('===>'.print_r($data));
					if($data['params']['paid_edof'] == 0 && $data['params']['acompte_fac'] < $data['params']['tot_ht']){
						Fiche::update(array('save_acompte_fac'=>$data['params']['acompte_fac']), array('id_fiche'=>$data['id_fiche']));
					}
				}

				// function after_update_paid_fact($data){
					
				// 	$ct = Fiche::findOne(array('c.id_fiche'=>$data['id_fiche']));

				// 	if($data['params']['paid_edof'] == 1){
				// 		Fiche::update(array('acompte_fac'=>$data['params']['tot_ht']), array('id_fiche'=>$data['id_fiche']));
				// 	}else{
				// 		echo('====>'.$ct->save_acompte_fac);
				// 		if($ct->save_acompte_fac > 0){
				// 			Fiche::update(array('acompte_fac'=>$ct->save_acompte_fac), array('id_fiche'=>$data['id_fiche']));
				// 		}
				// 	}
				// }

				$grid->set_options($opt);

				$grid->set_columns($cols);
				
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_fiches_fact");
				break;


			case 'db_contacts_docs':
				$contactcodekey = Fiche::findOne(array('c.id_fiche' => (int)$infosup));

				$sql = "SELECT d.*, c.codekey , u.user_name
						FROM db_contacts_docs d 
						INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
						LEFT JOIN db_users u ON u.id_usrApp = d.id_usrApp
						WHERE d.id_fiche = " . (int)$infosup;

				
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => false, 'edit' => false, 'delete' => false, 'view' => false, 'clone' => false, 'autofilter' => true, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => false));
				$cols = array();
				
				$cond["column"] = "accept_doc";
				$cond["target"] = "accept_doc";
				$cond["op"] = "=";
				$cond["value"] = "1";
				$cond["cellcss"] = "'background-color':'#ACCE82','color':'white'"; 
				$cond_conditions[] = $cond;


				UIGrid::add_cols($cols, 'id_doc', 'Id.', array('editable' => false, 'width' => '50px'));
				UIGrid::add_cols($cols, 'id_fiche', 'Id. Ct.', array('hidden' => true));
				UIGrid::add_cols($cols, 'codekey', 'codekey', array('hidden' => true));
				UIGrid::add_cols(
					$cols,
					'action',
					($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Traitements' : 'Treatments'),
					array(
						'align' => 'center',
						'sortable' => false,
						'search' => false,
						'export' => false,
						'on_data_display' => array('display_actiondoc', '')
					)
				);

				function display_actiondoc($data)
				{
					global $usrActif;
					global $arrAccess;
					global $template;
					$btn = '<div class="btn-group"></div>';

					

					if( $arrAccess['isAdmin'] == '1' ) {
						$btn = '<div class="btn-group"> ' ;
						$btn .= '<a href="'.$template['url'].'/uploads/'.$data['codekey'].$data['id_fiche'].'/'.$data['name_doc'].'" class="btn btn-xs btn-primary" download data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Télécharger le fichier' : 'Download the file').'" target="new" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-download"></i></a>';
						$btn .= '<a href="#" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Supprimer le fichier' : 'Delete the file').'" class="btn btn-xs btn-danger deldoc" data-id="' . $data['id_doc'] . '" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;" ><i class="fa fa-trash"></i></a>';
						
						$btn .= '<a href="#" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Validez' : 'Validate').'" class="btn btn-xs btn-success acceptdoc" data-id="' . $data['id_doc'] . '" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;" ><i class="fa fa-check"></i></a>';
						
						$btn .= '</div>';
					};
					
					return $btn;
				}

				
				UIGrid::add_cols($cols, 'accept_doc', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Validate'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'true:false'),
					// 'editrules' => array("required"=>true)
				));	

				UIGrid::add_cols($cols, 'user_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etablit par' : 'Edited by'), array(
					'hidden' => false,
					'on_data_display' => array('display_etablit', '')
				));

				function display_etablit($data) {
					
					if((int)$data['id_usrApp'] == 0){					
						
						$btn =  "<div style='box-shadow: -5px -5px 10px; background-color:#dae3f2'>Client</div>";	
					}else{
						$btn =  "<div style='box-shadow: -5px -5px 10px; background-color:#e6e6a5'>".$data['user_name']."</div>";	
					}
					
					return $btn;
				}
				
				UIGrid::add_cols($cols, 'date_doc', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date <br>création' : 'Date <br>create'), array(
					'dbname' => 'DATE(date_doc)',
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_doc"] > 0', "{date_doc}", '')
				));
				
				$lstdoc = $grid->get_dropdown_values("select DISTINCT id_type_doc as k, name_doc as v from db_type_docs ");
				
				// print_r($lstdoc);
				UIGrid::add_cols($cols, 'id_type_doc', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Type de document' : 'Document type'), array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstdoc),
					'stype' => "select",
					'searchoptions' => array("value" => $lstdoc)
				));

				global $template;
				// UIGrid::add_cols($cols, 'name_doc', 'Nom document', array(
				// 	'default' => '<a href="'.$template['url'].'/uploads/'.$contactcodekey->codekey.(int)$infosup.'/{name_doc}" target="new">{name_doc}</a>'
				// ));

				// error_log('lien doc : '.$template['url'].'/uploads/'.$contactcodekey->codekey.(int)$infosup.'/{name_doc}');
				UIGrid::add_cols($cols, 'lnkname_doc', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom du<br>document' : 'Document name'), array(
                    'dbname' => 'name_doc',
                    'editable' => false,
                    'on_data_display' => array('display_linkdoc', ''),
                    'align' => 'left'
                ));

				UIGrid::add_cols($cols, 'status_sellsign', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Statut' : 'Status'));
				UIGrid::add_cols($cols, 'contract_id_sellsign', 'ID Sell&Sign');

                function display_linkdoc($data) {                   
                    global $template;
					if(substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'mpeg' || substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'mpg' || substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'wav' || substr($data['name_doc'],strripos($data['name_doc'],'.') + 1) == 'mp3'){
						return '<audio controls style="width:180px;height:26px"><source src="uploads/'.$data['codekey'].$data['id_fiche'].'/'.$data['name_doc'].'"  type="audio/mpeg"></audio>';
					}else{
                    	return '<a href="uploads/'.$data['codekey'].$data['id_fiche'].'/'.$data['name_doc'].'"  data-toggle="lightbox-'.(strpos($data['name_doc'], '.pdf') !== false ? 'iframe' : 'image').'" style="margin-left:5px" target="new"><i class="fa fa-file-pdf-o"></i> '.$data['name_doc'].'</a>';
					}
				};


				$opt["sortname"] = 'date_doc';
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				$opt["rowNum"] =  '100';
				$opt['width'] = '100%';
				$opt['height'] = 'auto';
				$opt["loadComplete"] = "function(ids) { $('[data-toggle=\"lightbox-iframe\"]').magnificPopup({type: 'iframe', image: {titleSrc: 'title'}, gallery:{enabled:true}}); $('[data-toggle=\"lightbox-image\"]').magnificPopup({type: 'image', image: {titleSrc: 'title'}, gallery:{enabled:true}}); }";
				//$opt["toolbar"] = "top";
				$grid->set_options($opt);

				
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_fiches_docs");
				break;

				
			case 'db_infos_emails':
				$sql = "SELECT * FROM db_infos_emails ";
				$tbname = "db_infos_emails";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => false));
				
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt["scroll"] = false;
				// $opt["width"] = "500";
				// $opt["cmTemplate"] = array("width"=>"400");
				$opt['height'] = 'auto';
				// $opt["autowidth"] = true;
				// $opt["shrinkToFit"] = false;


				$opt["rowNum"] =  20;
				
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$grid->set_options($opt);

				$cols = array();
				
				$cond["column"] = "id_inf_email";
				$cond["target"] = "id_inf_email";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;
				
				$cond["column"] = "is_get";
				$cond["target"] = "is_get";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'yellow','color':'yellow'"; 
				$cond_conditions[] = $cond;
				
				$cond["column"] = "inf_mail_actif";
				$cond["target"] = "inf_mail_actif";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'48bb48','color':'48bb48'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_inf_email', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'inf_mail_name', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom d\'affichage' : 'Display name'), array());
				UIGrid::add_cols($cols, 'inf_host', 'SMTP hote', array());
				UIGrid::add_cols($cols, 'inf_username', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Compte mail<br>adr. mail' : 'Account email<br>email adress'), array());
				UIGrid::add_cols($cols, 'inf_password', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mot de passe' : 'Password'), array(
					"formatter"=>'password',
					'edittype'=>'password'
				));
				UIGrid::add_cols($cols, 'inf_protocol', 'Protocol', array());
				UIGrid::add_cols($cols, 'inf_port', 'Port', array());
				UIGrid::add_cols($cols, 'inf_mail_actif', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Boite<br>d\'envoi' : 'Outbox'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	
				UIGrid::add_cols($cols, 'is_get', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Boite de<br>réception' : 'Inbox'), array(
					'editable' => true,
					'formatter' =>  'checkbox',
					'edittype' => 'checkbox',
					'editoptions' => array('value'=>'1:0'),
				));	

				$grid->set_events(array(
					'js_on_load_complete' => "dbgridMails",
					"on_update" => array("update_inf_mail", null, true),
					"on_insert" => array("update_inf_mail", null, true),
					"on_after_update" => array("update_aft_inf_mail", null, false),
					"on_after_insert" => array("update_aft_inf_mail", null, false),
				));
				
				function update_aft_inf_mail(&$data) {
					
					if((int)$data['params']['inf_mail_actif'] > 0){
						InfosGenes::mailSql("UPDATE db_infos_emails SET inf_mail_actif = 0 WHERE id_inf_email != ".$data['id_inf_email'], false);
					}else{
						$res = InfosGenes::getAllMail(array('inf_mail_actif'=>'1'));
						if($res->num_rows <= 0){
							phpgrid_msg(($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Aucune boite mail n'est active<br>Envoi de mail impossible !" : "No active mailbox<br>cannot send !"),0);
							// die;
						}
					}
				}
				
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_smtp");

				break;
				
			case 'db_infos_banques':
				$sql = "SELECT * FROM db_infos_banques ";
				$tbname = "db_infos_banques";
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => false));
				
				$opt["sortorder"] = "DESC";
				$opt["pgbuttons"] = true;
				$opt["pgtext"] = null;
				$opt["viewrecords"] = false;
				$opt["rowList"] = array();	
				// $opt["rowNum"] =  '100';
				$opt["scroll"] = false;
				// $opt["width"] = "500";
				// $opt["cmTemplate"] = array("width"=>"400");
				$opt['height'] = 'auto';
				// $opt["autowidth"] = true;
				// $opt["shrinkToFit"] = false;


				$opt["rowNum"] =  20;
				
				$opt["sortable"] = true;
				
				$opt["export"] = array(
					"range" => "filtered",
					"orientation" => "landscape"
				);
				$grid->set_options($opt);

				$cols = array();

				$cond["column"] = "id_inf_banque";
				$cond["target"] = "id_inf_banque";
				$cond["op"] = ">";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_inf_banque', 'Id.', array('hidden'=>true,'editable' => false, 'width' => '0px', 'resizable'=>false));
				UIGrid::add_cols($cols, 'inf_nom_rib', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Intitulé RIB' : 'Bank details'), array());
				UIGrid::add_cols($cols, 'inf_code_bq', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code banque' : 'Bank code'), array());
				UIGrid::add_cols($cols, 'inf_guichet', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Code guichet' : 'Branch code'), array());
				UIGrid::add_cols($cols, 'inf_num_compte', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° Compte' : 'Account number'), array());
				UIGrid::add_cols($cols, 'inf_cle', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Clé' : 'Key'), array());
				UIGrid::add_cols($cols, 'inf_iban', 'Iban', array());
				UIGrid::add_cols($cols, 'inf_bic', 'Bic', array());
				
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				
				return $grid->render("list_bq");

				break;


			case 'db_extraactivite':
				$sql = "SELECT * FROM db_extra_activites WHERE id_sejour = ".$infosup;
				if((int)$infosup3 > 0){
					$sql .= " AND id_fiche = ".(int)$infosup3;
					// echo($sql);
				}
				$tbname = 'db_extra_activites';
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				
				$opt['height'] = 'auto';

				$cols = array();
				$cond["column"] = "id_extraactivite";
				$cond["target"] = "id_extraactivite";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_sejour";
				$cond["target"] = "id_sejour";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_usrApp";
				$cond["target"] = "id_usrApp";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				UIGrid::add_cols($cols, 'id_extraactivite', 'Id.', array('editable' => false, 'width' => '0px', 'resizable'=>false));

				$lstusr = $grid->get_dropdown_values("select DISTINCT id_usrApp as k, user_name as v from db_users WHERE id_usrApp = ".$infosup2);
				UIGrid::add_cols($cols, 'id_usrApp', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur' : 'User'),array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstusr,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					// 'editoptions' => array("value" => ":;".$infosup2.":".$infosup2),
					'editoptions' => array("value" => "".$lstusr),
					'stype' => "select",
					// 'searchoptions' => array("value" => $infosup2.":".$infosup2)					
					'searchoptions' => array("value" => $lstusr)					
				));
				
				$lstsj = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup);
				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstsj,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstsj),
					'stype' => "select",
					'searchoptions' => array("value" => $lstsj),
				));

				
				$lstlib = $grid->get_dropdown_values("select DISTINCT id_activite as k, name_activite as v from db_activites");
				UIGrid::add_cols($cols, 'name_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Activité' : 'Activity'),array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstlib),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstlib),
				));

				UIGrid::add_cols($cols, 'lieu_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Lieu activité' : 'Place of activity'));

				UIGrid::add_cols($cols, 'date_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date activité' : 'Start activity'), array(
					'editable' => true ,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_activite"] > 0', "{date_activite}", ''),
					'editrules' => array("required"=>true)
				));

				UIGrid::add_cols($cols, 'details_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails' : 'Details'), array(
					'editable' => true,
					'edittype' => 'textarea',
					'editoptions' => array("rows" => 5, "cols" => 80)
				));
				
				$lstcts = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(first_name,' ',last_name) as v from db_contacts");
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client' : 'Customer'),array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstcts),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstcts),
				));

				UIGrid::add_cols($cols, 'nb_pers', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb personne' : 'Nb Pers.'));
				UIGrid::add_cols($cols, 'prix_activite', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mt activité' : 'Mt activity.'));
				UIGrid::add_cols($cols, 'mt_paye', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Payé' : 'Paid'), array(
					'editable' => true,
				));
				UIGrid::add_cols($cols, 'mt_restant', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Restant' : 'Remaining'), array(
					'editable' => true,	
					'editoptions'=> array("readonly"=>'readonly',"style"=>"border:1"),		
				));

				UIGrid::add_cols($cols, 'action', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Règlements' : 'Payments'), array(
					// 'frozen'=>true,
					'align' => 'center', 
					'sortable' => false, 
					'search' => false, 
					'export' => false, 
					'editable' => false,
					'width' => '200px', 
					'on_data_display' => array('display_action_extra', '')
				));

				function display_action_extra($data)
				{
					global $usrActif;
					$btn = '<div class="btn-group">'
						. '<a href="#" data-id = "'.$data['id_extraactivite'].'" data-idct = "'.$data['id_fiche'].'" data-sej = "'.$data['id_sejour'].'" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Paiements' : 'Payment').'" class="btn btn-xs btn-info btrglt" style="border-radius: 50%;border: 2px solid white; margin-right: 4.5px;"><i class="fa fa-money"></i></a>'
						. '</div>';

					return $btn;
				}

				// UIGrid::add_cols($cols, 'desc_sejour', 'Informations<br>du séjour', array(
				// 	'editable' => false ,
				// 	'edittype'=> 'textarea',
				// 	'editoptions'=> array("rows"=>2, "cols"=>20),
				// ));

				/*
				UIGrid::add_cols(
					$cols,
					'action',
					'Informations<br>séjour ',
					array(
						'editable' => false ,
						'align' => 'center',
						'sortable' => false,
						'search' => false,
						'on_data_display' => array('display_action_sejour', ''),
						// 'width' => '10px'
					)
				);

				
				function display_action_sejour($data)
				{
					// echo(print_r($data));
					$btn = '<a href="#" data-toggle="tooltip2" title="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails et information du séjour' : 'Details and informations of the stay').'" class="btn btn-xs btn-primary btinfsejour" data-id="'.$data['id_organisateur'].'" style="border-radius: 100%;border: 2px solid white; margin-right: 4.5px; color:white" ><i class="fa fa-pencil"></i></a>';
					// $btn .= '<a href="#" data-toggle="tooltip2" title="Détails et information du séjour" class="btn btn-xs btn-danger btinfsejourENG" data-id="'.$data['id_organisateur'].'" style="border-radius: 100%;border: 2px solid white; margin-right: 4.5px; color:blue" ><i class="fa fa-pencil"></i> ANG</a>';
				
					return $btn;
				}	
				*/
				
				$opt['add_options'] = array('width' => '620');
				$opt['edit_options'] = array('width' => '620');
				// $grid->set_options($opt);

				
				$grid->set_events(array(
					"on_update" => array("update_extra", null, true),
					"on_insert" => array("update_extra", null, true)
				));
				
				function update_extra(&$data) {
					$data['params']['mt_restant'] = $data['params']['prix_activite'] - $data['params']['mt_paye']; 
				}
				


				$grid->set_options($opt);
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_extras");

				break;

			case 'db_bar':
				
				$sql = "SELECT b.* FROM db_bar b WHERE b.id_sejour = ".$infosup;
				if((int)$infosup3 > 0){
					$sql .= " AND b.id_fiche = ".(int)$infosup3;
				}
				// echo($sql);
				$tbname = 'db_bar';
				$grid = UIGrid::getGrid('', $tbname, $sql, false, false);
				$grid->set_actions(array('add' => true, 'edit' => true, 'delete' => true, 'view' => false, 'clone' => false, 'export_pdf' => false, 'export_excel' => false, 'export_csv' => false, 'search' => false, 'showhidecolumns' => false,  'rowactions' => true));
				
				
				$opt['height'] = 'auto';				
				$opt['add_options'] = array('width' => '620');
				$opt['edit_options'] = array('width' => '620');
				// $opt["multiselect"] = true  ;			
				$opt["rowList"] = array(20, 50, 100, 200);				
				$opt["rowList"][] = 'All';
				$opt["rowNum"] =  20;

				$cols = array();
				$cond["column"] = "id_bar";
				$cond["target"] = "id_bar";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_sejour";
				$cond["target"] = "id_sejour";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;

				$cond["column"] = "id_usrApp";
				$cond["target"] = "id_usrApp";
				$cond["op"] = ">=";
				$cond["value"] = "0";
				$cond["cellcss"] = "'background-color':'#fff','color':'#fff'"; 
				$cond_conditions[] = $cond;
				
				UIGrid::add_cols($cols, 'id_bar', 'Id.', array('editable'=>false,'width' => '0px', 'resizable'=>false, 'dbname' => 'id_bar'));
				UIGrid::add_cols($cols, 'act', 'action', array('editable'=>false,'hidden'=>true));
				
				$lstusr = $grid->get_dropdown_values("select DISTINCT id_usrApp as k, user_name as v from db_users WHERE id_usrApp = ".$infosup2);
				UIGrid::add_cols($cols, 'id_usrApp', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Utilisateur' : 'User'),array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstusr,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					// 'editoptions' => array("value" => ":;".$infosup2.":".$infosup2),
					'editoptions' => array("value" => "".$lstusr),
					'stype' => "select",
					// 'searchoptions' => array("value" => $infosup2.":".$infosup2)					
					'searchoptions' => array("value" => $lstusr)					
				));
				
				$lstsj = $grid->get_dropdown_values("select DISTINCT id_organisateur as k, name_organisateur as v from db_organisateurs WHERE id_organisateur = ".$infosup);
				
				UIGrid::add_cols($cols, 'id_sejour', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Séjour' : 'Stay'), array(
					'width'=> '0px',
					'editoptions'=> array("defaultValue"=>$lstsj,"readonly"=>'readonly',"style"=>"border:0"),
					'editable'=>true,
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => "" . $lstsj),
					'stype' => "select",
					'searchoptions' => array("value" => $lstsj),
				));
				
				
				UIGrid::add_cols($cols, 'date_bar', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date' : 'Date'), array(
					'editable' => false ,
					'formatter' => 'date',
					"formatoptions" => array("srcformat" => 'Y-m-d', "newformat" => 'd/m/Y'),
					'condition' => array('$row["date_bar"] > 0', "{date_bar}", ''),
					'editrules' => array("required"=>true)
				));
				
				$lstcli = $grid->get_dropdown_values("select DISTINCT id_fiche as k, CONCAT(first_name,' ',last_name) as v from db_contacts WHERE id_organisateur = ".$infosup);
				UIGrid::add_cols($cols, 'id_fiche', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client' : 'Customer'),array(
					'formatter' => 'select',
					'edittype' => "select",
					'editoptions' => array("value" => ":;".$lstcli),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstcli),
				));


				
				$lstlib = $grid->get_dropdown_values("select DISTINCT id_produit as k, name_produit as v from db_produits WHERE is_bar_produit = 1");
				UIGrid::add_cols($cols, 'id_produit', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Article' : 'Article'),array(
					'formatter' => 'select',
					'edittype' => "select",
					"classes" => "clsProd", // Classe personnalisée
					'editoptions' => array("value" => ":;".$lstlib),
					'stype' => "select", //-multiple",
					'searchoptions' => array("value" => $lstlib),
				));

				UIGrid::add_cols($cols, 'prix_produit_bar', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Prix article' : 'Price of article'),array(
					'etitable'=>false,
					'editoptions'=> array("readonly"=>'readonly'),
				));
				UIGrid::add_cols($cols, 'qte_bar', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Qte' : 'Qte'),array(
					'editoptions'=> array("defaultValue"=>'1')
				));

				UIGrid::add_cols($cols, 'mt_du_bar', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mt total' : 'Total amount'),array(
					'etitable'=>false,
					'editoptions'=> array("readonly"=>'readonly'),
				));

				UIGrid::add_cols($cols, 'prix_paye_bar', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Payé' : 'Paid'),array(
					'etitable'=>true,
				));

				UIGrid::add_cols($cols, 'prix_reste_bar', ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mt restant' : 'Remaining amount'),array(
					'etitable'=>false,
					'editoptions'=> array("readonly"=>'readonly'),
				));
				
				// $opt['ondblClickRow'] = array("function(rowid, iRow, iCol, e) { return false; }");
				// $grid->set_options($opt);

				
				$grid->set_events(array(
					"on_after_update" => array("after_update_bar", null, true),
					"on_after_insert" => array("after_update_bar", null, true)
				));
				
				function after_update_bar(&$data) {
					$stock = Stock::findOneProduit(array('id_produit'=>(int)$data['params']['id_produit']));
					$res = Stock::updateProduit(array('val_produit'=>$stock->val_produit - $data['params']['qte_bar']), array('id_produit'=>(int)$data['params']['id_produit']));
					
				}
				


				$grid->set_options($opt);
				$grid->set_columns($cols);
				$grid->set_conditional_css($cond_conditions);
				return $grid->render("list_bar");

				break;
									
		}
	}
}
