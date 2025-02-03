<?php


class IsoPDFBuilder
{
	public static function checkDir($rep)
	{
		$dirup = __DIR__ . '/../Dashboard/uploads/';
		$dir = $dirup.$rep;
		if (!is_dir($dir)) {
			mkdir($dir);
			copy($dirup . 'index.php', $dir . '/index.php');
		}

		return $dir;
	}


	public static function writeCheckbox($checked, $decal = true)
	{
		return '<span class="cspec" '.($decal ? 'style="margin-left:20px"' : '').'>'.($checked ? '☒' : '☐').'</span>';
	}

	
	public static function BuildMap($map, $template, $dest, $pginfo = '')
	{
		// die('=====>'.__DIR__.'/../libry/isopdfi.php');
		require_once(__DIR__.'/../Dashboard/libry/isopdfi.php');

		$pdf = new ISOPDFI();
		$pdf->SetFont('times', '', 10);
		$pdf->nopageinfo = $pginfo;
		//$pdf->typedoc = $typedoc;
		$pdf->setSourceFile($template);

		$i=0;
		foreach($map as $page => $content) {
			$i++;
			$tpl = $pdf->importPage($i);
			$pdf->addPage();
			$pdf->useTemplate($tpl);
			foreach($content as $elm) {
				if (isset($elm['img'])) 
					$pdf->Image($elm['img'], $elm['imgx'], $elm['imgy'], isset($elm['imgw']) ? $elm['imgw'] : 0, isset($elm['imgh']) ? $elm['imgh'] : 0);
				else	
				if ($elm['value'] != '') {
					foreach($elm['position'] as $pos) {
						$pdf->setXY($pos['X'], $pos['Y']);
						$fam = isset($elm['ffam']) ? $elm['ffam'] : 'times';
						$sty = isset($elm['sty']) ? $elm['sty'] : '';
						$sz = isset($elm['fsize']) ? $elm['fsize'] : 10;
						$pdf->SetFont($fam, $sty, $sz);
						if (isset($elm['txtcol']))
							$pdf->SetTextColor($elm['txtcol'][0], $elm['txtcol'][1], $elm['txtcol'][2]);

						if (isset($elm['color'])) {
							$pdf->setFillColor($elm['color'][0], $elm['color'][1], $elm['color'][2]);
							$pdf->Cell($elm['cell'][0], $elm['cell'][1], $elm['cell'][2], $elm['cell'][3], $elm['cell'][4], $elm['cell'][5], $elm['cell'][6]);
						}
						else
							$pdf->write($elm['h'], $elm['value']);
					}
				}
			}
		}
		$filename = $dest; //$dir.'/BAREN_'.$typedoc.'_'.$ref.'.pdf';
		$pdf->output($filename, 'F');
		return $filename;
	}
		
	
	public static function BuildCommande($fournisseur, $nocmd,  $idsejour, $local=true){ 

		$soc = Soc::findOne(array('is_soc'=>'1'));
		$dirup = __DIR__ . '/../Dashboard/uploads/fournisseurs/';

		$dir = $dirup . $fournisseur->id_fournisseur;
		if (!is_dir($dir)) {
			mkdir($dir);
			copy($dirup . 'index.php', $dir . '/index.php');
		}

		$htmldetails = '';

		$cmds = Cmd::getAllDetails(array('num_cmd'=>$nocmd,'id_sejour'=>$idsejour));
		foreach($cmds as $cmd){
			
			$htmldetails .= '<tr>
							<td style="width:50%"">
								'.$cmd['name_produit'].'
							</td>
							<td style="width:25%"">
								'.$cmd['name_unite'].'
							</td>
							<td style="width:25%"">
								'.$cmd['val_qte'].'
							</td>
						</tr>';
		}

		$htmldoc = '<style type="text/css" media="screen,print">
							
			* {font-family:helvetica;}
			table {border-collapse: collapse; width: 100% ;}
			td { border : none; padding : 5px 5px;}
			.bold{ font-weight: bold}
			.justify {text-align: justify}
			</style>
			<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					// if (file_exists($logo)) {
					// 	$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					// }
					

			$htmldoc .= '
					<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';


			$htmldoc .= 
			'
				<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
					
						<div style="text-align:center">
							<h2> BON DE COMMANDE N° : '.$nocmd.'</h2>
							<span style="font-size:15px"><b> du '.date('d/m/Y').'</b></span>
						</div>
						<p>	
							Fournisseur ,<br><br>
							'.$fournisseur->name_fournisseur.'<br>
							'.$fournisseur->adr_fournisseur.', '.$fournisseur->code_post_fournisseur.' '.$fournisseur->city_fournisseur.'<br>
							<br>
							Tel : '.$fournisseur->tel_fournisseur.'<br>
							Mail : '.$fournisseur->mail_fournisseur.'
							<br><br>
							Détails de la commande :
						</p>';

			$htmldoc .=
						'<table class="center">
						<tr>
							<td style="width:50%">
								<b>PRODUIT</b>
							</td>
							<td style="width:25%">
								<b>UNITE</b>
							</td>
							<td style="width:25%">
								<b>QTE</b>
							</td>
						</tr>	
							'
							.$htmldetails.'
					</table>
					
				</div>
				</page>	';

		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			$nmdoc = 'BON_COMMANDE_'.$idsejour.'_'.$nocmd.'.pdf';
			// $filename = $dir.'/'.$nmdoc;
			$filename = __DIR__."/../Dashboard/uploads/fournisseurs/".$fournisseur->id_fournisseur.'/'.$nmdoc;
			// echo $filename;
			// die;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/fournisseurs/'.$fournisseur->id_fournisseur.'/'.$nmdoc.'?time='.time();

		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}

	}
	
	public static function BuildTables($idsejour, $local=true){ 

		$soc = Soc::findOne(array('is_soc'=>'1'));
		
		$sejour = Setting::getOrganisateur(array('id_organisateur'=>$idsejour));
		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		$logoSoc = __DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc;
		// $dirup = __DIR__ . '/../Dashboard/uploads/fournisseurs/';

		// $dir = $dirup . $fournisseur->id_fournisseur;
		// if (!is_dir($dir)) {
		// 	mkdir($dir);
		// 	copy($dirup . 'index.php', $dir . '/index.php');
		// }

		// $htmldetails = '';

		$tbs = Tables::getAll(array('id_sejour'=>$idsejour),false,'num_table');
		
		foreach($tbs as $tb){

			// echo(print_r($tb).'<br>');

			$arrTb[] = array('key'.$tb['num_table']=>$tb['num_table'], 'numT'=>$tb['num_table'], 'n1'=>$tb['name_table'], 'nb1'=>$tb['nb_table'], 'ch1'=>$tb['num_chambre'],
									'n2'=>$tb['name_table_2'], 'nb2'=>$tb['nb_table_2'], 'ch2'=>$tb['num_chambre_2'],
									'n3'=>$tb['name_table_3'], 'nb3'=>$tb['nb_table_3'], 'ch3'=>$tb['num_chambre_3'],
								);
		}

		// print_r($arrTb);

		$htmldoc = '<style type="text/css" media="screen,print">							
					* {font-family:helvetica;}
					table {border-collapse: collapse; width: 100% ;}
					table #treserve {border-collapse: collapse; width: 100% ;}
					td { border : solid; padding : 5px 5px; text-align: center;vertical-align: text-top; width:25%}
					table #treserve td { border:none;text-align: center;vertical-align: text-top; width:33%;}
					img {text-align:top}
					.bold{ font-weight: bold}
					.justify {text-align: justify}
					
				</style>
			<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					if (file_exists($logo)) {
						$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					}
					if (file_exists($logoSoc)) {
						$htmldoc .= '<img src="'.$logoSoc.'" style="width:150px" />';
					}
					

			$htmldoc .= '
					
				</page_header>';


			$htmldoc .= ' <h2> Plan des tables</h2>
				<table>';

			$idt = 0;
			for($i=1;$i<=7;$i++){
				$tfind = false;
				$htmldoc .= '<tr>';
				for($j=1;$j<=4;$j++){
					$idt++;
					$tfind = false;
					foreach($arrTb as $data){
						
						if($data['numT'] == $idt){
							$htmldoc .= '<td style="background-color:beige;height:110px">
											<span style="color:red">TABLE N° '.$idt.'</span><br>';
							$htmldoc .= '<img src="../img/plaque.png" alt="table_'.$idt.'" data-idtd="'.$idt.'" idtd="'.$idt.'" name="t'.$idt.'" style="max-width: 35%;"/><br>';
							$tfind = true;
						}
					}
					
									
					$htmldoc .= ($tfind ? '' 
								:'<td style=";height:110px">
									TABLE N° '.$idt.'<br>
									<img src="../img/table.png" alt="table_'.$idt.'" data-idtd="'.$idt.'" idtd="'.$idt.'" name="t'.$idt.'" style="max-width: 40%;margin-top:30px"/>
										<br>'
								);
							
									
									foreach($arrTb as $data){
										
										if($data['numT'] == $idt){
											$htmldoc .= '<table id="treserve">
															<tr>
																<th><u>Nom</u></th>
																<th><u>Nb</u></th>
																<th><u>N°</u></th>
															</tr>';
											if($data['n1'] != ''){
												$htmldoc .= '<tr><td>'.$data['n1'].'</td><td>'.$data['nb1'].'</td><td>'.$data['ch1'].'</td></tr>';
											}
											if($data['n2'] != ''){
												$htmldoc .= '<tr><td>'.$data['n2'].'</td><td>'.$data['nb2'].'</td><td>'.$data['ch2'].'</td></tr>';
											}
											if($data['n3'] != ''){
												$htmldoc .= '<tr><td>'.$data['n3'].'</td><td>'.$data['nb3'].'</td><td>'.$data['ch3'].'</td></tr>';
											}
											$htmldoc .= '</table>';
										}
									};
									
							$htmldoc .='
								</td>';
				}
				$htmldoc .= '</tr>';
			}
			$htmldoc .= '
					</table>
				</page>	';

				// echo $htmldoc;

		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			$nmdoc = 'TABLES_'.$idsejour.'.pdf';
			// $filename = $dir.'/'.$nmdoc;
			$filename = __DIR__."/../Dashboard/uploads/docs/".$nmdoc;
			// echo $filename;
			// die;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/docs/'.$nmdoc.'?time='.time();

		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}

	}

	public static function BuildEmpTime($res, $deb, $fin, $local= true)
	{
		$dir = IsoPDFBuilder::checkDir('docs');

		

		$htmldoc = '';

		$ngrp = '';
		$ngrpboucle = '';
		$newgrp = false;

		$nb=0;

		foreach($res as $emp){
			// echo(print_r($emp));
				
			if($newgrp == false){
				$nb = $emp['tot'];
				
				$content = '<h2>EMPLOI DU TEMPS</h2>';
				$content .= '<table style="width:100%;text-align:center" class="center" >';
				$content .= '<tr>
								<th  style="width:15%">Periode</th>
								<th  style="width:20%">Enfants</th>
								<th  style="width:5%">Total</th>
								<th  style="width:12%">Groupe</th>
								<th  style="width:10%">Monos</th>
								<th  style="width:23%">Lieu</th>
								<th  style="width:15%">Activité</th>
							</tr>';

				$ngrp = $emp['name_groupe'];	
				$newgrp = true;	
					
			}

			if($ngrp == $emp['name_groupe']){

				$content .= '<tr>
					<td  style="width:15%">'.$deb.'<br>-<br> '.$fin.'</td>
					<td  style="width:20%">'.$emp['enfants'].'</td>
					<td  style="width:5%">'.$emp['tot'].'</td>
					<td  style="width:12%">'.$emp['name_groupe'].'</td>
					<td  style="width:10%">'.$emp['monos'].'</td>
					<td  style="width:23%">'.$emp['lieu_rdv'].'</td>
					<td  style="width:20%">'.$emp['name_activite'].'</td>
				</tr>';
				
				
			}else{
				
				$content .= '</table>';
		
						
				$htmldoc .= '<style type="text/css" media="screen,print">
							
								* {font-family:times}
								.tcenter{text-align:center}
								.border{border:solid 1px #000}
								b, .bold{ font-weight: bold}
								.red{color:#ff0000}
								.blue{color:#0070C0}
								.thg{background-color: #d7d9d4}
								.f12{font-size:12px}
								.f15{font-size:15px}
								table, th, td {
									border: 1px solid black;
									border-collapse: collapse;
								}
								p{padding-top:10px;padding-bottom:7px;margin-top:5px;margin-bottom:5px;}
								.f9{font-size:9px}
								.title{color:#0070C0;font-size:16px;font-weight:bold;}
								.ml30{margin-left:15px; margin-right:15px;}
								tr.bggr td {background-color:#eee}
		
							
							</style>
							<page backtop="17mm" backbottom="14mm" backleft="5mm" backright="5mm">
								'.$content.'
							</page>';

							$content = '';
							$content = '<h2>EMPLOI DU TEMPS</h2>';
							$content .= '<table style="width:100%;text-align:center" class="center" >';
							$content .= '<tr>
											<th  style="width:15%">Periode</th>
											<th  style="width:20%">Enfants</th>
											<th  style="width:5%">Total</th>
											<th  style="width:12%">Groupe</th>
											<th  style="width:10%">Monos</th>
											<th  style="width:23%">Lieu</th>
											<th  style="width:15%">Activité</th>
										</tr>';

							$content .= '<tr>
								<td  style="width:15%">'.$deb.'<br>-<br> '.$fin.'</td>
								<td  style="width:20%">'.$emp['enfants'].'</td>
								<td  style="width:5%">'.$emp['tot'].'</td>
								<td  style="width:12%">'.$emp['name_groupe'].'</td>
								<td  style="width:10%">'.$emp['monos'].'</td>
								<td  style="width:23%">'.$emp['lieu_rdv'].'</td>
								<td  style="width:15%">'.$emp['name_activite'].'</td>
							</tr>';

							$ngrp = $emp['name_groupe'];	
							$newgrp = true;	
			}
			
		}

		if($newgrp){
			$content .= '</table>';

		
						
			$htmldoc .= '<style type="text/css" media="screen,print">
						
							* {font-family:times}
							.tcenter{text-align:center}
							.border{border:solid 1px #000}
							b, .bold{ font-weight: bold}
							.red{color:#ff0000}
							.blue{color:#0070C0}
							.thg{background-color: #d7d9d4}
							.f12{font-size:12px}
							.f15{font-size:15px}
							table, th, td {
								border: 1px solid black;
								border-collapse: collapse;
							}
							p{padding-top:10px;padding-bottom:7px;margin-top:5px;margin-bottom:5px;}
							.f9{font-size:9px}
							.title{color:#0070C0;font-size:16px;font-weight:bold;}
							.ml30{margin-left:15px; margin-right:15px;}
							tr.bggr td {background-color:#eee}
	
						
						</style>
						<page backtop="17mm" backbottom="14mm" backleft="5mm" backright="5mm">
							'.$content.'
						</page>';
		}
		
		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			$filename = $dir . '/EMP_TIME_'.date('Y-m-d').'.pdf';
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/docs/EMP_TIME_'.date('Y-m-d').'.pdf?time='.time();

		}
		catch(HTML2PDF_exception $e) {
			
			return $e;
			exit;
		}
	}


	public static function BuildPlanTables($idsejour, $local=true){ 

		$soc = Soc::findOne(array('is_soc'=>'1'));
		
		$sejour = Setting::getOrganisateur(array('id_organisateur'=>$idsejour));
		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		$logoSoc = __DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc;
		// $dirup = __DIR__ . '/../Dashboard/uploads/fournisseurs/';

		// $dir = $dirup . $fournisseur->id_fournisseur;
		// if (!is_dir($dir)) {
		// 	mkdir($dir);
		// 	copy($dirup . 'index.php', $dir . '/index.php');
		// }

		// $htmldetails = '';

		$tbs = TablesPlans::getAll(array('tp.id_sejour'=>$idsejour),false,'f.last_name, f.first_name');

		$htmldoc = '<style type="text/css" media="screen,print">							
					* {font-family:helvetica;}
					table {border-collapse: collapse; width: 100% ;}
					td , th{ border : solid; padding : 5px 5px; text-align: center;vertical-align: text-top;}
					img {text-align:top}
					.bold{ font-weight: bold}
					.justify {text-align: justify}
					
				</style>
			<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					if (file_exists($logo)) {
						$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					}
					if (file_exists($logoSoc)) {
						$htmldoc .= '<img src="'.$logoSoc.'" style="width:150px" />';
					}
					

			$htmldoc .= '
					
				</page_header>';


			$htmldoc .= ' <h2> Plan des tables</h2>
				<table>
					<tr>
						<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'</th>
						<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° table' : 'N° table').'</th>
						<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb adulte(s)' : 'Nb Adult(s)').'</th>
						<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb enfant(s)' : 'Nb Children(s)').'</th>
						<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb bébé(s)' : 'Nb baby(s)').'</th>
						<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Note' : 'Note').'</th>
						<th>'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etage' : 'Floor').'</th>
					</tr>';
					
			foreach($tbs as $tb){
				$htmldoc .= '<tr>
									<td>'.$tb['last_name'].' '.$tb['first_name'].'</td>
								<td>'.$tb['num_table'].'</td>
								<td>'.$tb['nb_adulte'].'</td>
								<td>'.$tb['nb_enfant'].'</td>
								<td>'.$tb['nb_bb'].'</td>
								<td>'.$tb['note'].'</td>
								<td>'.$tb['etage'].'</td>
							</tr>';
			}
			
			$htmldoc .= '
					</table>
				</page>	';

				// echo $htmldoc;

		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			$nmdoc = 'TABLES_'.$idsejour.'.pdf';
			// $filename = $dir.'/'.$nmdoc;
			$filename = __DIR__."/../Dashboard/uploads/docs/".$nmdoc;
			// echo $filename;
			// die;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/docs/'.$nmdoc.'?time='.time();

		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}

	}


	public static function BuildRoomList($contact, $type,  $local=true, $rows= array(), $app=''){ 

		// print_r($contact.' --- '.$type);
		// die;

		$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);
		
		$htmlroom = '';
		$htmlct = '';
		$htmldoc = '<style type="text/css" media="screen,print">
							
							* {font-family:helvetica;}
							table {border-collapse: collapse; width: 100% ;}
							td { border : none; padding : 5px 5px;}
							.bold{ font-weight: bold}
							.justify {text-align: justify}
						</style>';

		if($app == ''){
			$rooms = Chambres::getAllDetails(array('id_fiche'=>$contact->id_fiche));
			$soc = Soc::findOne();
			$infdetailsCt = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche));

			$sejour = Setting::getOrganisateur(array('id_organisateur'=>$contact->id_organisateur));
			$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;

			
			$htmldoc = '
			<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
			$htmldoc .= '
					<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';
			
			$htmldoc .= 
				'
				<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
					
					<div style="text-align:center">
						<h2>ROOM LIST</h2>
					</div>
					<p>	
						Informations Client(s)
						<br>
						';
						foreach($infdetailsCt as $detct){
							$htmldoc .= ' . '.strtoupper($detct['last_name_detail']).' '.strtoupper($detct['first_name_detail']).'<br>';
						};
			$htmldoc .= 
						'
					</p>
					<p>	
						Informations Chambre(s)
						<br>
						';
						$htmldoc .= '<table style="width:100%; border:none; text-align:center" >
										<tr>
											<th>N° chambre : </th>
											<th>Etage : </th>
										</tr>
										';
						foreach($rooms as $room){
							$htmldoc .= '
										<tr>
											<td style="width:50%;border-bottom: solid">'.$room['num_chambre'].'</td>
											<td style="width:50%;border-bottom: solid">'.$room['etage'].'</td>
										</tr>
										';
						};
			$htmldoc .= '</table>';
			$htmldoc .= 
						'
					</p>
				</div>
				
			</page>	';
		}else{
			
			if($type == 'P'){
				
				foreach($rows as $row){
					$contact = Fiche::findOne(array('c.id_fiche'=>(int)$row, 'c.lnk_annule'=>'0'));

					$rooms = Chambres::getAllDetails(array('id_fiche'=>$contact->id_fiche));
					$soc = Soc::findOne();
					$infdetailsCt = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche));

					$sejour = Setting::getOrganisateur(array('id_organisateur'=>$contact->id_organisateur));
					$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;


					$htmldoc .= '
					<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
						<page_header style="text-align:center; vertical-align:bottom">';
					$htmldoc .= '
							<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
						</page_header>';
					
					$htmldoc .= 
						'
						<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
							
							<div style="text-align:center">
								<h2>ROOM LIST '.$contact->id_fiche.'</h2>'.$contact->last_name.' '.$contact->first_name.'
							</div>
							<p>	
								Informations Client(s)
								<br>
								';
								foreach($infdetailsCt as $detct){
									$htmldoc .= ' . '.strtoupper($detct['last_name_detail']).' '.strtoupper($detct['first_name_detail']).'<br>';
								};
					$htmldoc .= 
							'
						</p>
						<p>	
							Informations Chambre(s)
							<br>
							';
							$htmldoc .= '<table style="width:100%; border:none; text-align:center">
											<tr>
												<th>N° chambre : </th>
												<th>Etage : </th>
											</tr>
											';
							foreach($rooms as $room){
								$htmldoc .= '
											<tr>
												<td style="width:50%;border-bottom: solid">'.$room['num_chambre'].'</td>
												<td style="width:50%;border-bottom: solid">'.$room['etage'].'</td>
											</tr>
											';
							};
					$htmldoc .= '</table>';
					$htmldoc .= 
								'
							</p>
						</div>
						
					</page>	';
				}
			}else{
				$soc = Soc::findOne();	
				$htmldoc .= '
					<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
						<page_header style="text-align:center; vertical-align:bottom">';
					$htmldoc .= '
							<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
						</page_header>';
				foreach($rows as $row){
					// echo$row.'<br>';
					$contact = Fiche::findOne(array('c.id_fiche'=>(int)$row, 'c.lnk_annule'=>'0'));
						
					$rooms = Chambres::getAllDetails(array('id_fiche'=>$contact->id_fiche));
					
					$infdetailsCt = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche));

					$sejour = Setting::getOrganisateur(array('id_organisateur'=>$contact->id_organisateur));
					$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
					
					$htmldoc .= 
						'
						<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
							
							<div style="text-align:center">
								<h2>ROOM LIST </h2>'.$contact->last_name.' '.$contact->first_name.'
							</div>
							';
					$htmldoc .= '<table style="width:100%; border:none; text-align:left" >
							<tr>
								<th>detail(s) client(s) : </th>
							</tr>
							';
					foreach($infdetailsCt as $detct){
						$htmldoc .= '<tr><td>'.' . '.strtoupper($detct['last_name_detail']).' '.strtoupper($detct['first_name_detail']).'</td></tr>'
									;
					}
					$htmldoc .= '</table>';
					$htmldoc .= '<table style="width:100%; border:none; text-align:center" >
							<tr>
								<th>Chambre : </th>
								<th>Etage : </th>
							</tr>
							';
					foreach($rooms as $room){
						$htmldoc .= '
									<tr>
										<td style="width:50%;border-bottom: solid">'.$room['num_chambre'].'</td>
										<td style="width:50%;border-bottom: solid">'.$room['etage'].'</td>
									</tr>
									';
					};
					$htmldoc .= '</table>';
					$htmldoc .= 
								'
						</div><br>';
				}
				$htmldoc .= '</page>	';
			}
			
		}
		
		// return $htmldoc;			
		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			// $filename = $dir.'/'.$nmdoc;
			if($app == ''){
				$nmdoc = 'ROOM_LIST_'.$sejour->id_organisateur.'_'.$contact->id_fiche.'.pdf';
				$filename = __DIR__."/../Dashboard/uploads/".$contact->codekey.$contact->id_fiche.'/'.$nmdoc;
				$html2pdf->Output($filename, 'F');
				return $local ? $filename : 'uploads/'.$contact->codekey.$contact->id_fiche.'/'.$nmdoc.'?time='.time();
			}else{
				$nmdoc = 'ROOM_LIST_'.$sejour->id_organisateur.'.pdf';
				$filename = __DIR__."/../Dashboard/uploads/docs/".$nmdoc;
				$html2pdf->Output($filename, 'F');
				return $local ? $filename : 'uploads/docs/'.$nmdoc.'?time='.time();
			}
			
			// echo $filename;
			// die;
			// return $filename;
			
			
		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}

	}

	public static function BuildRoomClean($arrChClean=array(), $sej, $dt='', $dt2=''){ 
		// print_r($arrChClean);
		// die;
		$sejour = Setting::getOrganisateur(array('id_organisateur'=>$sej));
		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;

		$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);
		
		$htmlroom = '';
		$htmlct = '';
		$htmldoc = '<style type="text/css" media="screen,print">
							
							* {font-family:helvetica;}
							table {border-collapse: collapse; width: 100% ;}
							td { border : none; padding : 5px 5px;}
							.bold{ font-weight: bold}
							.justify {text-align: justify}
						</style>';

		
		
		$soc = Soc::findOne(array('is_soc'=>'1'));
		// $logo = __DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc;

		$htmldocDetails .= '<table style="width:100%; border:none; text-align:center" >
						<tr>
							<th>N° chambre : </th>
							<th>Nettoyage : </th>
						</tr>
						';

		foreach($arrChClean as $cl){
			
			$htmldocDetails .= '<tr>
							<td style="width:50%">'
								.$cl[0].
							'</td>
							<td style="background-color:'.$cl[1].';width:50%">
							</td>
						</tr>';
		}

		$htmldocDetails .= '</table>';
		
		$htmldoc = '
		<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
			<page_header style="text-align:center; vertical-align:bottom">';
		$htmldoc .= '
				<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
			</page_header>';
		
		
		$htmldoc .= 
			'
			<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
				
				<div style="text-align:center">
					<h2>ROOM LIST '.($lg == 'FR' || $lg == '' ? 'DU ' : 'FROM ').date('d/m/Y',strtotime($dt)) .($lg == 'FR' || $lg == '' ? ' AU ' : ' TO ').date('d/m/Y',strtotime($dt2)) .'</h2>
				</div>
				Informations Chambres
				<br>';
				
		$htmldoc .= $htmldocDetails;
		
		$htmldoc .= '
			</div>
			
		</page>	';
	
		
		// echo $htmldoc;			
		// die;
		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			// $filename = $dir.'/'.$nmdoc;
			$nmdoc = 'ROOM_CLEAN_'.$sejour->id_organisateur.($dt == '' ? '' : '_'.$dt).'.pdf';
			$filename = __DIR__."/../Dashboard/uploads/docs/".$nmdoc;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/docs/'.$nmdoc.'?time='.time();
			
			
			// echo $filename;
			// die;
			// return $filename;
			
			
		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}

	}

	// 
	public static function BuildNoteFrais($contact, $sign='', $htmldetails = '', $lg='FR', $catfrais='', $datefrais='', $mtfrais=0, $local=true, $type='NF',$convertedPath =''){

		// echo($convertedPath);
		// die;
		$soc = Soc::findOne(array('is_soc'=>'1'));
		$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);
		$signNote = $sign != '' ? '<img src="'.__DIR__.'/../'.$sign.'" id="img-sign" style="width:200px; height: 100px;">' : '';
		
		$sejour = Setting::getOrganisateur(array('id_organisateur'=> $contact->id_organisateur));
		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		$logoSoc = __DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc;

		$datefrais = ($datefrais == '' ? date('Y-m-d') : $datefrais);

		$nonotefrais = 'NF_'.date('dm');
		$files = [];
	
		$infiban = explode(' . ',$infbq);
		// $mtTva = ($mtfrais * ((float)$txtva / 100));
		
		$htmldoc = '<style type="text/css" media="screen,print">
					* { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
					table { border-collapse: collapse; width: 100%; }
					th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
					th { background-color: #45608c; color: #FFF; }
					.center { text-align: center; }
					.bold { font-weight: bold; }
					.total-row { background-color: #f4f4f4; font-weight: bold; }
					.footer { font-size: 10px; text-align: center; margin-top: 20px; }
					.box { padding: 15px; border: 2px solid #e8cc81; background-color: white; margin-bottom: 20px; }
					.title { font-size: 16px; font-weight: bold; color: #45608c; }
				</style>

				<page backtop="40mm" backbottom="10mm" backleft="20mm" backright="20mm">
					<page_header>
						<table>
							<tr>
								<td style="width:50%; vertical-align: middle;">
									'.(file_exists($logo) ? '<img src="'.$logo.'" style="width:120px">' : '').'
								</td>
								<td style="width:50%; text-align:right;">
									'.(file_exists($logo_soc) ? '<img src="'.$logoSoc.'" style="width:120px">' : '').'
								</td>
							</tr>
						</table>
						<hr>
					</page_header>';
	
		$htmldoc .= '<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
			<table class="center">
				<tr>
					<td style="width:50%">
						<b>'.$soc->name_soc.'</b><br>
						'.$soc->adr_soc.'<br>
						'.$soc->post_code_soc.', '.$soc->city_soc.'
					</td>
					<td style="width:50%">
						<b>'.$contact->first_name.' '.$contact->last_name.'</b><br>
						'.$contact->adr1.'<br>
						'.$contact->post_code.', '.$contact->city.'<br>
						'.$contact->country.'
					</td>
				</tr>    
			</table>
			<br><br>
			<table class="">
				<tr>
					<td style="width:50%">
						<b>Note de frais N° </b>'.$nonotefrais.'<br>
						Date d\'émission : '.date('d/m/Y',strtotime($datefrais)).'
					</td>
					<td style="width:50%; text-align:left">
						
					</td>
				</tr>
			</table>
			<br>
			<table class="">
				<tr style="text-align:center; background-color:#45608c; color:#FFF">
					<th>Description</th>
					<th>Montant</th>
				</tr>
				<tr>
					<td style="width:60%">'.nl2br($htmldetails).'</td>
					<td style="width:30%; text-align:center">'.((int)$txtva > 0 ? $mtfrais + $mtTva : $mtfrais).' €</td>
				</tr>
			</table>
			<br>
			
		</div>
		</page>';

		// $nmdoc = 'NOTEFRAIS_'.$sejour->id_organisateur.'_'.$contact->id_fiche.'_'.$nonotefrais.'.pdf';
		// $filename = __DIR__."/../Dashboard/uploads/".$contact->codekey.$contact->id_fiche.'/'.$nmdoc;
		// echo($filename);
		// die;
	
		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try {
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			
			$nmdoc = 'NOTEFRAIS_'.$sejour->id_organisateur.'_'.$contact->id_fiche.'_'.$nonotefrais.'.pdf';
			$filename = __DIR__."/../Dashboard/uploads/".$contact->codekey.$contact->id_fiche.'/'.$nmdoc;

			$files[] = $nmdoc;
			$files[] = $convertedPath;
			// print_r($files);
			// die;
			$html2pdf->Output($filename, 'F');
			IsoPDFBuilder::PdfMerging($files,$dir.'/'.$nmdoc, "Dashboard/uploads/".$contact->codekey.$contact->id_fiche."/");

			return $local ? $filename : 'uploads/'.$contact->codekey.$contact->id_fiche.'/'.$nmdoc.'?time='.time();
		} catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}
	}
	

	// 

	public static function BuildFacture($contact, $nofac, $sign='', $htmldetails = '', $nofacture ='', $datefacture='', $lg='FR', $txtva=0, $infbq=' . ', $local=true, $type='F'){ 

		$soc = Soc::findOne(array('is_soc'=>'1'));

		$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);

		$signDevis = '';
		if($sign != ''){
			$signDevis = '<img src="'.__DIR__.'/../'.$sign.'" id="img-sign" style="width:200px; height: 100px;">';
		}
		
		$sejour = Setting::getOrganisateur(array('id_organisateur'=> $contact->id_organisateur));
		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		$logoSoc = __DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc;

		$infiban = explode(' . ',$infbq);

		$mtTva = ($contact->tot_ht * ((float)$txtva / 100));

		$htmldoc = '<style type="text/css" media="screen,print">
							
			* {font-family:helvetica;}
			table {border-collapse: collapse; width: 100% ;}
			td { border : none; padding : 5px 5px;}
			.bold{ font-weight: bold}
			.justify {text-align: justify}
			</style>
			<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					if (file_exists($logo)) {
						$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					}
					

		if (file_exists($logo_soc)) {
			$htmldoc .= '
					<img src="'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';
		}else{
			$htmldoc .= '
				</page_header>';
		}

		$htmldoc = '<style type="text/css" media="screen,print">
					* { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
					table { border-collapse: collapse; width: 100%; }
					th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
					th { background-color: #45608c; color: #FFF; }
					.center { text-align: center; }
					.bold { font-weight: bold; }
					.total-row { background-color: #f4f4f4; font-weight: bold; }
					.footer { font-size: 10px; text-align: center; margin-top: 20px; }
					.box { padding: 15px; border: 2px solid #e8cc81; background-color: white; margin-bottom: 20px; }
					.title { font-size: 16px; font-weight: bold; color: #45608c; }
				</style>

				<page backtop="40mm" backbottom="10mm" backleft="20mm" backright="20mm">
					<page_header>
						<table>
							<tr>
								<td style="width:50%; vertical-align: middle;">
									'.(file_exists($logo) ? '<img src="'.$logo.'" style="width:120px">' : '').'
								</td>
								<td style="width:50%; text-align:right;">
									'.(file_exists($logo_soc) ? '<img src="'.$logoSoc.'" style="width:120px">' : '').'
								</td>
							</tr>
						</table>
						<hr>
					</page_header>

					<div class="box">
						<table>
							<tr>
								<td style="width:50%">
									<span class="title">'.$soc->name_soc.'</span><br>
									'.$soc->adr_soc.'<br>
									'.$soc->post_code_soc.', '.$soc->city_soc.'
								</td>
								<td style="width:50%">
									<span class="title">'.$contact->first_name.' '.$contact->last_name.'</span><br>
									'.$contact->adr1.'<br>
									'.$contact->post_code.', '.$contact->city.'<br>
									'.$contact->country.'
								</td>
							</tr>
						</table>
					</div>

					<div class="box">
						<table>
							<tr>
								<td style="width:50%">
									<b>Facture N° </b>'.$nofacture.'<br>
									Date d\'émission : '.date('d/m/Y', strtotime($datefacture)).'
								</td>
								<td style="width:50%; text-align:right">
									<b>Règlement :</b> 15 jours
								</td>
							</tr>
						</table>
					</div>

					<table>
						<tr>
							<th style="width:60%">'.($lg == 'FR' || $lg == '' ? 'Désignation' : 'Description').'</th>
							<th style="width:10%">'.($lg == 'FR' || $lg == '' ? 'TVA' : 'Taxe').'</th>
							<th style="width:30%; text-align:right">'.($lg == 'FR' || $lg == '' ? 'Montant séjour' : 'Amount stay').'</th>
						</tr>
						<tr>
							<td>'.nl2br($htmldetails).'</td>
							<td>'.$txtva.'%</td>
							<td style="text-align:right">'.number_format($contact->tot_ht, 2, ',', ' ').' €</td>
						</tr>
					</table>

					<br>

					<table>
						<tr class="total-row">
							<td style="width:70%">Total HT</td>
							<td style="width:30%; text-align:right">'.number_format($contact->tot_ht, 2, ',', ' ').' €</td>
						</tr>
						<tr>
							<td>TVA '.$txtva.'%</td>
							<td style="text-align:right">'.((int)$txtva > 0 ? number_format($mtTva, 2, ',', ' ') : '0').' €</td>
						</tr>
						<tr class="total-row">
							<td>Total TTC</td>
							<td style="text-align:right">'.((int)$txtva > 0 ? number_format($contact->tot_ht + $mtTva, 2, ',', ' ') : number_format($contact->tot_ht, 2, ',', ' ')).' €</td>
						</tr>
					</table>

					<br>
					<hr>
					<div class="footer">
						IBAN : '.$infiban[0].' | BIC : '.$infiban[1].'
					</div>

					<page_footer>
						<hr>
						<div class="footer">
							'.$soc->name_soc.' - '.$soc->adr_soc.', '.$soc->post_code_soc.' '.$soc->city_soc.'<br>
							Contact: '.$soc->email_soc.' | '.$soc->tel_soc.'
						</div>
					</page_footer>
				</page>';

		// $htmldoc .= 
		// 		'
		// 		<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
		// 				<table class="center">
		// 					<tr>
		// 						<td style="width:50%">
		// 							<b>'.$soc->name_soc.'</b><br>
		// 							'.$soc->adr_soc.'<br>
		// 							'.$soc->post_code_soc.', '.$soc->city_soc.'
		// 						</td>
		// 						<td style="width:50%">
		// 							<b>'.$contact->first_name.' '.$contact->last_name.'</b><br>
		// 							'.$contact->adr1.'<br>
		// 							'.$contact->post_code.', '.$contact->city.'<br>
		// 							'.$contact->country.'
		// 						</td>
		// 					</tr>	
								
		// 				</table>
		// 				<br><br>
		// 				<table class="">
		// 					<tr>
		// 						<td style="width:50%">
		// 							<b>Facture N° </b>'.$nofacture.'<br>
		// 							Date d\'émission : '.date('d/m/Y',strtotime($datefacture)).'
		// 						</td>
		// 						<td style="width:50%; text-align:left">
		// 							Règlement : 15 jours
		// 						</td>
		// 					</tr>
		// 				</table>
		// 				<br>
		// 				<table class="">
		// 					<tr style="text-align:center; background-color:#45608c; color:#FFF">
		// 						<th>
		// 						'.($lg == 'FR' || $lg == '' ? 'Désignation' : 'Description').'
		// 						</th>
		// 						<th>
		// 						'.($lg == 'FR' || $lg == '' ? 'TVA' : 'Taxe').'
		// 						</th>
		// 						<th>
		// 						'.($lg == 'FR' || $lg == '' ? 'Montant séjour' : 'Amount stay').'
		// 						</th>
		// 					</tr>
		// 					<tr>
		// 						<td style="width:60%">
		// 							'.nl2br($htmldetails).'
		// 						</td>
		// 						<td style="width:10%; text-align:left">
		// 							'.$txtva.'
		// 						</td>
		// 						<td style="width:30%; text-align:center">
		// 							'.$contact->tot_ht.'
		// 						</td>
		// 					</tr>
		// 				</table>
		// 				<br>
		// 				<table class="">
		// 					<tr>
		// 						<td style="width:70%;text-align:left">
		// 							<b>Total HT</b>
		// 						</td>
		// 						<td style="width:30%; text-align:center">
		// 							'.$contact->tot_ht.'
		// 						</td>
		// 					</tr>
		// 					<tr>
		// 						<td style="width:70%;text-align:left">
		// 							<b>TVA '.$txtva.' %</b>
		// 						</td>
		// 						<td style="width:30%; text-align:center">
		// 							'.((int)$txtva > 0 ? $mtTva : '0').'
		// 						</td>
		// 					</tr>
		// 					<tr>
		// 						<td style="width:70%;text-align:left">
		// 							<b>Total TTC </b>
		// 						</td>
		// 						<td style="width:30%; text-align:center">
		// 							'.((int)$txtva > 0 ? $contact->tot_ht + $mtTva : $contact->tot_ht).'
		// 						</td>
		// 					</tr>
		// 				</table>
		// 				<hr>
		// 				<br>
		// 				IBAN : '.$infiban[0].'<br>
		// 				BIC : '.$infiban[1].'
						
		// 		</div>
		// 	</page>	';

		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			// $filename = $dir.'/'.$nmdoc;
			
			$nmdoc = 'FACTURE_'.$sejour->id_organisateur.'_'.$contact->id_fiche.'_'.$nofacture.'.pdf';
			$filename = __DIR__."/../Dashboard/uploads/".$contact->codekey.$contact->id_fiche.'/'.$nmdoc;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/'.$contact->codekey.$contact->id_fiche.'/'.$nmdoc.'?time='.time();

			
		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}
	}


	public static function BuildDevis($contact, $nodevis, $sign='',  $local=true, $type='D'){ 

		$soc = Soc::findOne(array('is_soc'=>'1'));

		$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);

		$signDevis = '';
		if($sign != ''){
			$signDevis = '<img src="'.__DIR__.'/../'.$sign.'" id="img-sign" style="width:200px; height: 100px;">';
		}
		
		$sejour = Setting::getOrganisateur(array('id_organisateur'=> $contact->id_organisateur));
		// $organisateur = Setting::getOrganisateurOrg(array('id_organisateur'=> $contact->id_org));

		$ad = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'1'));
		$enf = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'2'));
		$bb = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'3'));
		
		$nbadulte = $ad->num_rows;
		$nbenf = $enf->num_rows;
		$nbbb = $bb->num_rows;

		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		
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

		foreach($infchs as $ch){
			$prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
			if($prixch->tarif_chambre > 0){
				$addTot += $prixch->tarif_chambre;
			}

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
			
			$htmltransp = '';
			$htmlopt1 = '';
			$htmlopt2 = '';

			$libtarifdetail = Tarif::findOne(array('id_tarif'=>$details['libelle_tarif_details']));
			if($details['transport_detail'] > 0){
				$libtarifdetailTransp = Tarif::findOneTransport(array('id_transport'=>$details['transport_detail']));
				$htmltransp = '<tr>
								<td style="width:70%"">
									1 x '.$libtarifdetailTransp->lib_transport.'
								</td>
								<td style="width:30%">
									<b>'.$details['tarif_transport'].' €</b>
								</td>
							</tr>';
			}
			
			if($details['opt_lib_1'] > 0){
				$libtarifdetailOpt1 = Chambres::findOneOptions(array('id_option_chambre'=>$details['opt_lib_1']));
				$htmlopt1 = '<tr>
								<td style="width:70%"">
									1 x '.$libtarifdetailOpt1->lib_option_chambre.'
								</td>
								<td style="width:30%">
									<b>'.$libtarifdetailOpt1->tarif_option_chambre.' €</b>
								</td>
							</tr>';
			}
			
			if($details['opt_lib_2'] > 0){
				$libtarifdetailOpt2 = Chambres::findOneOptions(array('id_option_chambre'=>$details['opt_lib_2']));
				$htmlopt2 = '<tr>
								<td style="width:70%"">
									1 x '.$libtarifdetailOpt2->lib_option_chambre.'
								</td>
								<td style="width:30%">
									<b>'.$libtarifdetailOpt2->tarif_option_chambre.' €</b>
								</td>
							</tr>';
			}

			$htmldetails .= '
				<tr>
					<td style="width:70%"">
						1 x '.$libtarifdetail->libelle_tarif.'
					</td>
					<td style="width:30%">
						<b>'.$details['tarif_details'].' €</b>
					</td>
				</tr>
			';

			$htmldetails .= $htmltransp;
			$htmldetails .= $htmlopt1;
			$htmldetails .= $htmlopt2;
		};

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

		$totFinal = (($tot + $addTot) * (100 - $contact->offre_sejour)) / 100;

		
		// td { border : 1px solid black; padding : 5px 10px;}
		// '.($contact->civ_contact == 0 ? '' : ($contact->civ_contact == 1 ? 'Mr' : ($contact->civ_contact == 2 ? 'Mme' : 'Mlle'))).' '.strtoupper($contact->first_name).' '.strtoupper($contact->last_name).'<br>
					
		// <page backtop="20mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="img/MH-DEVIS-fond.jpg">

		if($type == 'D'){
			$htmldoc = '<style type="text/css" media="screen,print">
							
			* {font-family:helvetica;}
			table {border-collapse: collapse; width: 100% ;}
			td { border : none; padding : 5px 5px;}
			.bold{ font-weight: bold}
			.justify {text-align: justify}
			</style>
			<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					// if (file_exists($logo)) {
					// 	$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					// }
					

			$htmldoc .= '
					<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';


			$htmldoc .= 
				'
				<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
					
						<div style="text-align:center">
							<h2>'.($type == 'D' ? 'DEVIS ' : 'FACTURE ').'DEMO SOC</h2>
							<span style="font-size:15px"><b>'.($type == 'D' ? 'D ' : 'F ').date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT).'</b></span>
						</div>
						<p>	
							Chère Madame, cher Monsieur,<br><br>
							'.($type == 'D' ? 
							'Suite à votre demande, vous trouverez ci-après le devis de DEMO SOC pour Pessah 2023 en Crète (Hors vols) : ' 
							: 
							'Votre facture pour un séjour du '.date('d/m/Y', strtotime($contact->date_start)).' au '.date('d/m/Y', strtotime($contact->date_end)).', en vous souhaitant bonne réception'
							).'<br>
						</p>
						
						<table class="center">
							<tr>
								<td style="width:70%">
									<b>PANIER</b>
								</td>
								<td style="width:30%">
									<b>PRIX</b>
								</td>
							</tr>	
								'
								.$htmldetails.'
						</table>
						<br>
						<table class="">
							<tr>
								<td style="width:70%">
									<b>TOTAL : </b>
								</td>
								<td style="width:30%; text-align:left">
									<b>'.number_format($tot,2).($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ).''.($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' ).'</b>
								</td>
							</tr>
						</table>
						<br><br>
				</div>
				</page>	';

			$htmldoc .= '<page backtop="40mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					// if (file_exists($logo)) {
					// 	$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					// }

			$htmldoc .= '
					<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';
			
			$htmldoc .= '	
				<div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">

					<div style="text-align:left">
						'
						.($type == 'D' ? $sejour->desc_sejour : '').
						'
					</div>
					
					'.$signDevis.'
				
				</div>
				
			</page>	';
		}else{
			$ht = $tot / (1 + (20 / 100)); // ou $tot * (100/120)
			$tva = $tot - $ht;

			$htmldoc = '<style type="text/css" media="screen,print">
							
			* {font-family:helvetica;}
			table {border-collapse: collapse; width: 100% ;}
			td { border : none; padding : 5px 5px;}
			.bold{ font-weight: bold}
			.justify {text-align: justify}
			table.center td {text-align: center}
			</style>
			<page backtop="20mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					// if (file_exists($logo)) {
					// 	$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					// }

			$htmldoc .= '
				</page_header>';


			$htmldoc .= 
				'
				<div style="padding-left:7px">
					
						<div style="text-align:center">
							<img src="../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:350px"/>
						</div>
						<br><br>
						<div style="text-align:"">
							<span style="font-size:15px"><b>Facture n° F'.date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT).'</b></span><br>'
							.date('d/m/Y').'
						</div>
						<p>	
							<b>Facturé à,</b><br>
							'.$contact->last_name.' '.$contact->first_name.'<br>
							'.$contact->adr1.'<br>
							'.$contact->post_code.' '.$contact->city.'
							<br><br>
						</p>
						
						<table class="">
							<tr>
								<td style="width:80%;border: 1px solid black;border-collapse: collapse;background-color: #0d2d61;color:#FFF;text-align: center">
									<b>Description de l\'élément</b>
								</td>
								<td style="width:20%;border: 1px solid black;border-collapse: collapse;background-color: #0d2d61;color:#FFF;text-align: center">
									<b>Montant</b>
								</td>
							</tr>	
							<tr>
								<td style="width:80%;border: 1px solid black;border-collapse: collapse;">
									Séjour Cacher Pessah 2023
								</td>
								<td style="width:20%;border: 1px solid black;border-collapse: collapse; text-align:center;">
									<b>'.number_format($tot,2).($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ).''.($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' ).'</b>
								</td>
							</tr>	
							<tr>
								<td style="width:80%;border: 1px solid black;border-collapse: collapse;height:10px">
									
								</td>
								<td style="width:20%;border: 1px solid black;border-collapse: collapse;">
									
								</td>
							</tr>	
							<tr>
								<td style="width:80%;border: 1px solid black;border-collapse: collapse;">
									FRAIS DE DOSSIER
								</td>
								<td style="width:20%;border: 1px solid black;border-collapse: collapse; text-align:center;">
									10.00 '.($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ).''.($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' ).'
								</td>
							</tr>	
							<tr>
								<td style="width:80%;border: 1px solid black;border-collapse: collapse;">
									FRAIS DE DOSSIER OFFERT
								</td>
								<td style="width:20%;border: 1px solid black;border-collapse: collapse; text-align:center;">
									-10.00 '.($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ).''.($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' ).'
								</td>
							</tr>	
								
						</table>
						<br>
						<table class="">
							<tr>
								<td style="width:80%; text-align:right;border-right:1px solid black; ">
									sous-total
								</td>
								<td style="width:20%; text-align:center;border: 1px solid black;border-collapse: collapse;">
									<b>'.number_format($ht,2).($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ).''.($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' ).'</b>
								</td>
							</tr>
							<tr>
								<td style="width:80%; text-align:right;border-right:1px solid black;">
									TVA 20%
								</td>
								<td style="width:20%; text-align:center;border: 1px solid black;border-collapse: collapse;">
									<b>'.number_format($tva,2).' €</b>
								</td>
							</tr>
							<tr>
								<td style="width:80%; text-align:right;border-right:1px solid black;">
									Autres coûts
								</td>
								<td style="width:20%; text-align:center;border: 1px solid black;border-collapse: collapse;">
									
								</td>
							</tr>
							<tr>
								<td style="width:80%; text-align:right;border-right:1px solid black;">
									<b>Coût total TTC</b>
								</td>
								<td style="width:20%; text-align:center;border: 1px solid black;border-collapse: collapse;background-color: #0d2d61;color:#FFF;">
									<b>'.number_format($tot,2).($contact->code_devise == 'EUR' ? ' €' : ($contact->code_devise == 'USD' ? ' $' : ' '.$contact->code_devise) ).''.($contact->code_devise == 'EUR' ? '' : 'Montant converti selon la devise' ).'</b>
								</td>
							</tr>
						</table>
				</div>
			</page>	';
		}

		
		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			$nmdoc = ($type == 'D' ? 'DEVIS_' : 'FACTURE_').($signDevis != '' ? 'SIGNED_' : '').$contact->id_fiche.'.pdf';
			// $filename = $dir.'/'.$nmdoc;
			$filename = __DIR__."/../Dashboard/uploads/".$contact->codekey.$contact->id_fiche.'/'.$nmdoc;
			// echo $filename;
			// die;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/'.$contact->codekey.$contact->id_fiche.'/'.$nmdoc.'?time='.time();

		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}
	}

	public static function BuildInscriptContrat($contact, $nodevis, $sign='',  $local=true, $type='', $periode='', $lg = 'FR'){ 
		// echo($sign);
		// die;
		$infgene = InfosGenes::findOne(array('is_inf_gene'=>'1'));

		date_default_timezone_set('Europe/Paris');
		function date_fr($dt)
		{
			$Jour = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi");
			$Mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
			return  $Jour[date("w",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))))]." ".
					date("d",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))))." ".
					$Mois[date("n",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))))]." ".
					date("Y",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))));
		}

		
		function date_eng($dt = '1970-01-01')
		{
			$Jour = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday","Saturday");
			$Mois = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			return  $Jour[date("w",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))))]." ".
					date("d",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))))." ".
					$Mois[date("n",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))))]." ".
					date("Y",mktime(0,0,0,date('m',strtotime($dt)),date('d',strtotime($dt)),date('Y',strtotime($dt))));
		}
		// date("l",mktime(0,0,0,date('m',strtotime($contact->date_start)),date('d',strtotime($contact->date_start)),date('Y',strtotime($contact->date_start))))

		
		if($lg == 'FR' || $lg == ''){
			$dateformat = date_fr(date('Y-m-d'));
		}else{
			$dateformat = date_eng(date('Y-m-d'));
		}
		
		$soc = Soc::findOne(array('is_soc'=>'1'));
		
		$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);

		$signDevis = '';
		if($sign != ''){
			$signDevis = '<img src="'.__DIR__.'/../'.$sign.'" id="img-sign" style="width:200px; height: 100px;">';
			$date_contrat = date('d/m/Y', strtotime($contact->date_contrat_signed));
			// echo(print_r($contact));
		}
		
		$sejour = Setting::getOrganisateur(array('id_organisateur'=> $contact->id_organisateur));
		// $organisateur = Setting::getOrganisateurOrg(array('id_organisateur'=> $contact->id_org));
		
		$ad = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'1'));
		$enf = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'2'));
		$bb = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'3'));
		
		
		$nbadulte = $ad->num_rows;
		$nbenf = $enf->num_rows;
		$nbbb = $bb->num_rows;

		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		
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

		
		$infchsdet = Chambres::getAllDetails(array('cc.id_fiche'=>$contact->id_fiche));
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

		
        
		$alldetailsopts = Fiche::getAllDetailsOptions(array('id_fiche'=>$contact->id_fiche));
		foreach($alldetailsopts as $detailsopts){
			$sumTarif += $detailsopts['tot_tarif_option'];
		}

		foreach($alldetails as $details){
			$sumTarif += $details['tarif_details'];
			$sumTarif += $details['tarif_transport'];
			$sumTarif += $details['tarif_supp_detail'];
			
			$htmltransp = '';
			$htmlopt1 = '';
			$htmlopt2 = '';

			$libtarifdetail = Tarif::findOne(array('id_tarif'=>$details['libelle_tarif_details']));
			if($details['transport_detail'] > 0){
				$libtarifdetailTransp = Tarif::findOneTransport(array('id_transport'=>$details['transport_detail']));
				$htmltransp = '<tr>
								<td style="width:70%"">
									1 x '.$libtarifdetailTransp->lib_transport.'
								</td>
								<td style="width:30%">
									<b>'.$details['tarif_transport'].' €</b>
								</td>
							</tr>';
			}
			
			if($details['opt_lib_1'] > 0){
				$libtarifdetailOpt1 = Chambres::findOneOptions(array('id_option_chambre'=>$details['opt_lib_1']));
				$htmlopt1 = '<tr>
								<td style="width:70%"">
									1 x '.$libtarifdetailOpt1->lib_option_chambre.'
								</td>
								<td style="width:30%">
									<b>'.$libtarifdetailOpt1->tarif_option_chambre.' €</b>
								</td>
							</tr>';
			}
			
			if($details['opt_lib_2'] > 0){
				$libtarifdetailOpt2 = Chambres::findOneOptions(array('id_option_chambre'=>$details['opt_lib_2']));
				$htmlopt2 = '<tr>
								<td style="width:70%"">
									1 x '.$libtarifdetailOpt2->lib_option_chambre.'
								</td>
								<td style="width:30%">
									<b>'.$libtarifdetailOpt2->tarif_option_chambre.' €</b>
								</td>
							</tr>';
			}

			$htmldetails .= '
				<tr>
					<td style="width:70%"">
						1 x '.$libtarifdetail->libelle_tarif.'
					</td>
					<td style="width:30%">
						<b>'.$details['tarif_details'].' €</b>
					</td>
				</tr>
			';

			$htmldetails .= $htmltransp;
			$htmldetails .= $htmlopt1;
			$htmldetails .= $htmlopt2;
		};

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
			// $totInit = (($totFinal + $addTot) - $contact->taxe_sejour);
			$totInit = ($totFinal - $contact->taxe_sejour);
        }else{
            $totFinal = (($tot + $addTot) * (100 - $contact->offre_sejour)) / 100;
            $totFinal += $contact->taxe_sejour;
			$totInit = ($tot + $addTot);
        }
		// $totFinal = (($tot + $addTot) * (100 - $contact->offre_sejour)) / 100;
		$remise = $contact->offre_sejour;

		if($contact->code_devise == 'EUR' || $contact->code_devise == '' ){
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

		// td { border : 1px solid black; padding : 5px 10px;}
		// '.($contact->civ_contact == 0 ? '' : ($contact->civ_contact == 1 ? 'Mr' : ($contact->civ_contact == 2 ? 'Mme' : 'Mlle'))).' '.strtoupper($contact->first_name).' '.strtoupper($contact->last_name).'<br>
					
		// <page backtop="20mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="img/MH-DEVIS-fond.jpg">

		
		if($type == 'I' || $type == 'A'){
			$htmldoc = '<style type="text/css" media="screen,print">
							
			* {font-family:helvetica;}
			table {border-collapse: collapse; width: 100% ;}
			td { border : none; padding : 5px 5px;}
			.bold{ font-weight: bold}
			.justify {text-align: justify}
			</style>
			<page backtop="20mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					// if (file_exists($logo)) {
					// 	$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					// }
					

			$htmldoc .= '
					<img src="'.__DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';

// DU : '.date('d/m/Y', strtotime($contact->date_start)).' AU '.date('d/m/Y', strtotime($contact->date_end)).'
			$htmldoc .= 
				'
				<div style="line-height:20px;background-color:white;color:black;padding-left:7px">
					
						<div style="text-align:center">
							<h2>INSCRIPTION ' .$sejour->name_organisateur.'</h2>
							<p>	
							'.($lg == 'FR' || $lg == '' ? 'DU ' : 'FROM ').' : <strong>'.($lg == 'FR' || $lg == '' ? date_fr($contact->date_start) : date_eng($contact->date_start)).'</strong> '.($lg == 'FR' || $lg == '' ? ' AU ' : ' TO ').' <strong>'.($lg == 'FR' || $lg == '' ? date_fr($contact->date_end) : date_eng($contact->date_end)).'</strong>
							</p>
						</div>
						<br>
						<table>
							<tr>
								<td style="width:33%"><strong>'
									.($contact->civ_contact == '1' ? 'Mr ' : 'Mme ').$contact->last_name.' '.$contact->first_name.'</strong>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td style="width:33%">
									<strong>Tél : </strong>'.$contact->tel1.'
								</td>
								<td style="width:66%">
									<strong>Email : </strong>'.$contact->email.'
								</td>
							</tr>
						</table>
						<table>
							<tr>
								
								<td style="width:33%">
									<strong>'.($lg == 'FR' || $lg == '' ? 'Ville : ' : 'City : ').'</strong>'.$contact->city.'
								</td>
								<td style="width:33%">
									<strong>'.($lg == 'FR' || $lg == '' ? 'Pays : ' : 'Country : ').'</strong>'.$contact->country.'
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td style="width:33%">
								'.($lg == 'FR' || $lg == '' ? 'Nombre adulte :' : 'Nb adult :'). $nbadulte.'
								</td>
								<td style="width:33%">
								'.($lg == 'FR' || $lg == '' ? 'Nombre enfant :' : 'Nb children').$nbenf.'
								</td>
								<td style="width:33%">
								'.($lg == 'FR' || $lg == '' ? 'Nombre bébé :' : 'Nb baby :').$nbbb.'
								</td>
							</tr>
						</table>
						
						<br>
						Clients :<br>
						<table class="">
							<tr>
								<td style="border:1px solid black;width:50%">
								'.($lg == 'FR' || $lg == '' ? 'Nom prénom' : 'Identity').'
								</td>
								
								<td style="border:1px solid black;width:25%">
									Age
								</td>
								<td style="border:1px solid black;width:25%">
								'.($lg == 'FR' || $lg == '' ? 'Sexe' : 'Sex').'
								</td>
							</tr>';
							foreach ($alldetails as $value) {
								$htmldoc .= '<tr>
												<td style="border:1px solid black;width:50%">
													'.$value['last_name_detail'].' '.$value['first_name_detail'].'
												</td>
												
												<td style="border:1px solid black;width:25%">
													'.number_format($value['age']).'
												</td>
												<td style="border:1px solid black;width:25%">
													'.($value['sexe'] > 0 ? ($value['sexe'] == 1 ? 'M' : 'F') : '').'
												</td>
											</tr>
								';
							};
							
			$htmldoc.='
						</table>
						<br>
						Options :<br>
						<table class="">
							<tr>
								<td style="border:1px solid black;width:50%">
									Option
								</td>
								
								<td style="border:1px solid black;width:25%">
									Qte
								</td>
							</tr>';
							foreach ($alldetailsopts as $value) {
								$htmldoc .= '<tr>
												<td style="border:1px solid black;width:50%">
													'.$value['lib_detail_option'].'
												</td>
												
												<td style="border:1px solid black;width:25%">
													'.$value['qte_detail_option'].'
												</td>
											</tr>
								';
							};
			$htmldoc.='
						</table>
						<br>';
			if($infchsdet->num_rows > 0 && $type != 'I' && $type != 'A'){
				$htmldoc.=
						($lg == 'FR' || $lg == '' ? 'Chambres' : 'Rooms').' :<br>
						<table class="">
							<tr>
								<td style="border:1px solid black;width:15%">
									Nb
								</td>
								<td style="border:1px solid black;width:15%">
								'.($lg == 'FR' || $lg == '' ? 'Etage' : 'Floor').'
								</td>
								
								<td style="border:1px solid black;width:10%">
								'.($lg == 'FR' || $lg == '' ? 'Capacité' : 'Capacity').'
								</td>
								<td style="border:1px solid black;width:30%">
									Type
								</td>
								
							</tr>';
						foreach($infchsdet as $ch){
							$cptch++;
							$htmldoc .= '<tr>
											<td style="border:1px solid black;width:15%">
												'.$cptch.'
											</td>
											<td style="border:1px solid black;width:15%">
												'.$ch['etage'].'
											</td>											
											<td style="border:1px solid black;width:10%">
												'.$ch['capacite'].'
											</td>											
											<td style="border:1px solid black;width:30%">
												'.$ch['name_type_chambre'].'
											</td>
											
										</tr>
								';
							};
			$htmldoc.='
						</table>';
			}
			$htmldoc.=
						$signDevis.'
						<br><br>
					</div>
				</page>	';

		// contrat
		}else{
		
			$ht = $tot / (1 + (20 / 100)); // ou $tot * (100/120)
			$tva = $tot - $ht;

			$htmldoc = '<style type="text/css" media="screen,print">
							
			* {font-family:helvetica;}
			table {border-collapse: collapse; width: 100% ;}
			td { border : none; padding : 5px 5px;}
			.bold{ font-weight: bold}
			.justify {text-align: justify}
			table.center td {text-align: center}
			ul{
				list-style-type: none;
			  }
			</style>
			<page backtop="20mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
					// if (file_exists($logo)) {
					// 	$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					// }
					

					$htmldoc .= '
					<img src="'.__DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';

// '.date('d/m/Y', strtotime($contact->date_start)).' AU '.date('d/m/Y', strtotime($contact->date_end)).'
			$htmldoc .= 
				'
				<div style="line-height:20px;background-color:white;color:black;padding-left:7px">
					
						<div style="text-align:center">
							<h2>'.($lg == 'FR' || $lg == '' ? 'CONTRAT ' : 'REGISTRATION FORM ').$sejour->name_organisateur.'</h2>
							<p>	
							'.($lg == 'FR' || $lg == '' ? 'DU ' : 'FROM ').' : <strong>'.($lg == 'FR' || $lg == '' ? date_fr($contact->date_start) : date_eng($contact->date_start)).'</strong> '.($lg == 'FR' || $lg == '' ? ' AU ' : ' TO ').' <strong>'.($lg == 'FR' || $lg == '' ? date_fr($contact->date_end) : date_eng($contact->date_end)).'</strong>
							</p>
						</div>
						<br>
						<table>
							<tr>
								<td style="width:33%"><strong>'
									.($contact->civ_contact == '1' ? 'Mr ' : 'Mme ').$contact->last_name.' '.$contact->first_name.'</strong>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td style="width:33%">
									<strong>Tél : </strong>'.$contact->tel1.'
								</td>
								<td style="width:66%">
									<strong>Email : </strong>'.$contact->email.'
								</td>
							</tr>
						</table>
						<table>
							<tr>
								
								<td style="width:33%">
									<strong>'.($lg == 'FR' || $lg == '' ? 'Ville' : 'City').' : </strong>'.$contact->city.'
								</td>
								<td style="width:33%">
									<strong>'.($lg == 'FR' || $lg == '' ? 'Pays' : 'Country').' : </strong>'.$contact->country.'
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td style="width:33%">
								'.($lg == 'FR' || $lg == '' ? 'Nombre adulte' : 'Nb adult').' : '.$nbadulte.'
								</td>
								<td style="width:33%">
								'.($lg == 'FR' || $lg == '' ? 'Nombre enfant' : 'Nb children').' : '.$nbenf.'
								</td>
								<td style="width:33%">
								'.($lg == 'FR' || $lg == '' ? 'Nombre bébé' : 'Nb baby').' : '.$nbbb.'
								</td>
							</tr>
						</table>
						
						<br>
						Clients :<br>
						<table class="">
							<tr>
								<td style="border:1px solid black;width:50%">
								'.($lg == 'FR' || $lg == '' ? 'Nom prénom' : 'Identity').'
								</td>
								
								<td style="border:1px solid black;width:25%">
									Age
								</td>
								<td style="border:1px solid black;width:25%">
								'.($lg == 'FR' || $lg == '' ? 'Sexe' : 'Sex').'
								</td>
							</tr>';
							foreach ($alldetails as $value) {
								$htmldoc .= '<tr>
												<td style="border:1px solid black;width:50%">
													'.$value['last_name_detail'].' '.$value['first_name_detail'].'
												</td>
												
												<td style="border:1px solid black;width:25%">
													'.number_format($value['age']).'
												</td>
												<td style="border:1px solid black;width:25%">
													'.($value['sexe'] > 0 ? ($value['sexe'] == 1 ? 'M' : 'F') : '').'
												</td>
											</tr>
								';
							};
							
			$htmldoc.='
						</table>
						<br>
						Options :
						<table class="">
							<tr>
								<td style="border:1px solid black;width:50%">
									Option
								</td>
								
								<td style="border:1px solid black;width:25%">
									Qte
								</td>
							</tr>';
							foreach ($alldetailsopts as $value) {
								$htmldoc .= '<tr>
												<td style="border:1px solid black;width:50%">
													'.$value['lib_detail_option'].'
												</td>
												
												<td style="border:1px solid black;width:25%">
													'.$value['qte_detail_option'].'
												</td>
											</tr>
								';
							};
							
							// <td style="border:1px solid black;width:25%">
							// 	Prix
							// </td>
							// foreach ($alldetailsopts as $value) {
							// 	$htmldoc .= '<tr>
							// 					<td style="border:1px solid black;width:50%">
							// 						'.$value['lib_detail_option'].'
							// 					</td>
												
							// 					<td style="border:1px solid black;width:25%">
							// 						'.$value['qte_detail_option'].'
							// 					</td>
							// 					<td style="border:1px solid black;width:25%">
							// 						'.number_format($value['tot_tarif_option'],2).'
							// 					</td>
							// 				</tr>
							// 	';
							// };
			$htmldoc.='
						</table>
						<br>
						'.($lg == 'FR' || $lg == '' ? 'Chambres' : 'Rooms').' :
						<table class="">
							<tr>
								<td style="border:1px solid black;width:15%">
									Nb
								</td>
								<td style="border:1px solid black;width:15%">
								'.($lg == 'FR' || $lg == '' ? 'Etage' : 'Floor').'
								</td>
								
								<td style="border:1px solid black;width:10%">
								'.($lg == 'FR' || $lg == '' ? 'Capacité' : 'Capacity').'
								</td>
								<td style="border:1px solid black;width:30%">
									Type
								</td>
								
							</tr>';
						foreach($infchsdet as $ch){
							$cptch++;
							$htmldoc .= '<tr>
											<td style="border:1px solid black;width:15%">
												'.$cptch.'
											</td>
											<td style="border:1px solid black;width:15%">
												'.$ch['etage'].'
											</td>
											<td style="border:1px solid black;width:10%">
												'.$ch['capacite'].'
											</td>											
											<td style="border:1px solid black;width:30%">
												'.$ch['name_type_chambre'].'
											</td>
											
										</tr>
								';
							};
			$htmldoc.='
						</table>
						<br>';

			// <td style="border:1px solid black;width:30%;display:none">
			// 						'.$ch['name_loc_chambre'].'
			// 					</td>
			// $htmldoc.='
			// 			</table>
			// 			'.$signDevis.'
			// 			<br>
			$htmldoc.='		
					<table style="">
						<tr style="text-align:center">
							<th style="width:25%;border:1px solid black">
							'.($lg == 'FR' || $lg == '' ? 'Montant du séjour' : 'Amount stay').'
							</th>
							<th style="width:25%;border:1px solid black">
							'.($lg == 'FR' || $lg == '' ? 'Taxe de séjour' : 'City tax').'
							</th>
							<th style="width:25%;border:1px solid black;background-color:yellow">
							'.($lg == 'FR' || $lg == '' ? 'Montant total' : 'Total').'
							</th>
						</tr>
						<tr style="text-align:center">
							<td style="width:25%;border:1px solid black">
								'.($infgene->is_decimal > 0 ? number_format($totInit,2) : number_format($totInit)).' '.$devise.'
							</td>
							<td style="width:25%;border:1px solid black">
								'.($infgene->is_decimal > 0 ? number_format($contact->taxe_sejour,2) : number_format($contact->taxe_sejour)).' '.$devise.'
							</td>
							<td style="width:25%;border:1px solid black;background-color:yellow">
								'.($infgene->is_decimal > 0 ? number_format($totFinal,2) : number_format($totFinal)).' '.$devise.'
							</td>
						</tr>
					</table>
					<br>
					';
							
			// $htmldoc.='
			// 			<table>
			// 				<tr>
			// 					<td style="width:10%;">
			// 					</td>
			// 					<td style="width:80%; text-align:center">
			// 						Nous vous remercions d’adresser ce formulaire dûment rempli et signé soit :
			// 					</td>
			// 					<td style="width:10%;">
			// 					</td>
			// 				</tr>
			// 			</table>
			// 			<table>
			// 				<tr>
			// 					<td style="width:18%;">
			// 					</td>
			// 					<td style="width:70%;">
			// 						1. En le signant directement depuis cette page internet<br>
			// 						2. En le telechargeant et en l\'envoyant à l’adresse suivante :
			// 					</td>
			// 					<td style="width:10%;">
			// 					</td>
			// 				</tr>
			// 			</table>
			// 			<table>
			// 				<tr>
			// 					<td style="width:13%;">
			// 					</td>
			// 					<td style="width:70%; text-align:center">
			// 						<span style="color:red">
			// 							CRYSTAL CLUB<br>
			// 							118-130 AVENUE JEAN JAURÈS - 75169 PARIS - FRANCE
			// 						</span>
			// 					</td>
			// 					<td style="width:10%;">
			// 					</td>
			// 				</tr>
			// 			</table>
			// 			<table>
			// 				<tr>
			// 					<td style="width:18%;">
			// 					</td>
			// 					<td style="width:70%;">
			// 						3. Ou bien nous l’envoyer par mail à : crystalclub18@gmail.com
			// 					</td>
			// 					<td style="width:10%;">
			// 					</td>
			// 				</tr>
			// 			</table>';
						// <div class="form-group" id="sign-show" style=";border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
			// $htmldoc .= '
			// 		<div class="form-group" id="sign-show" style="background-color:white;color:black;padding-left:7px">
			// 			<p style="padding:5px;margin-top:20px;margin-bottom:5px;font-weight:600" ><b>'.($lg == 'FR' || $lg == '' ? 'Je confirme avoir lu et approuvé les Conditions Générales de Ventes du Crystal Club : www.crystal-club.fr/cgv' : 'I have read and approved the terms and conditions of the Crystal Club : www.crystal-club.fr/cgv').' </b></p>
						
			// 			<div class="col-md-12" style="border:solid 1px #ccc;min-height:200px">
			// 				<b>'.$contact->city.' Le '.$date_contrat.'</b><br>
			// 				<b>Signature : </b><br><br>
			// 				'.$signDevis.'
			// 			</div>				
			// 		</div>';
			$htmldoc .= '
				</div>
			</page>
			<page backtop="20mm" backbottom="5mm" backleft="20mm" backright="20mm" backimg="">
				<page_header style="text-align:center; vertical-align:bottom">';
						// if (file_exists($logo)) {
						// 	$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
						// }
			$htmldoc .= '
					<img src="'.__DIR__.'/../Dashboard/uploads/socs/'.$soc->logo_soc.'" style="width:150px"/>
				</page_header>';

			$htmldoc .= '
				<div class="form-group" id="sign-show" style="background-color:white;color:black;padding-left:7px">
					<p style="padding:5px;margin-top:20px;margin-bottom:5px;font-weight:600" ><b>'.($lg == 'FR' || $lg == '' ? 'Je confirme avoir lu et approuvé les Conditions Générales de Ventes du Crystal Club : www.crystal-club.fr/cgv' : 'I have read and approved the terms and conditions of the Crystal Club : www.crystal-club.fr/cgv').' </b></p>
					
					<div class="col-md-12" style="border:solid 1px #ccc;min-height:180px">
						<b>'.$contact->city.' - '.$date_contrat.'</b><br>
						<b>Signature : </b><br>
						'.$signDevis.'
					</div>				
				</div>
			';
			
			$htmldoc .=
					($lg == 'FR' || $lg == '' ? '<p style="text-align:center;color:red">Le Crystal Club vous remercie de votre confiance et vous souhaite un agréable séjour</p>' : '<p style="text-align:center;color:red">The Crystal Club thanks you and wishes you a pleasant stay</p>').'
				
				<p style="text-align:center;color:black">CONDITIONS GÉNÉRALES DE VENTES</p>
				<div class="container">
					<div class="row">
						<table style="background-color:gray;color:#FFF">
							<tr>
								<td style="width:50%">
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
								</td>
								<td style="width:49%">
									• De la signature à 45 jours avant le début du séjour, 40% du prix total du
									séjour devra être payé (acompte à déduire).<br>
									• De 30 à 45 jours, 70% du prix total du séjour devra être payé (acompte
									à déduire).<br>
									• De 7 à 30 jours, 90% du prix total du séjour devra être payé (acompte
									à déduire).<br>
									• De 6 jours au jour J, 100% du prix total du séjour devra être payé
									(acompte à déduire).<br>
									Tous les prestataires de services par air, par train ou par route sont des
									sociétés indépendantes qui assument leurs responsabilités respectives.
									Nous vous recommandons donc de souscrire à une assurance.
									En cas d’événements exceptionnels et indépendants de notre volonté,
									nous nous réservons le droit de modifier ou d’annuler notre séjour.
								</td>
							</tr>
						</table>
					</div>
				</div>
				<br>
				<div class="container">
					<div class="row">
						<table style="background-color:gray;color:#FFF">
							<tr>
								<td style="width:50%">
									SIGN<br>
									Registration for our stay implies acceptance of the conditions listed below.
									All registration must be accompanied by a deposit of 40% per person and the registration form duly completed and signed.
									The balance must be paid no later than 7 days before your arrival.
									Registration only takes effect upon receipt of the deposit. 
									A shortened stay does not give right to a refund.
								</td>
								<td style="width:49%">
									CANCEL<br>
									Any cancellation on your part must be notified to us as soon as possible by telephone and confirmed by mail, fax or e-mail.
									The payment of the stay will however have to be completed according to the conditions below:<br>
									■ From the signature to 45 days before the start of the stay, 40% of the total price of the stay must be paid (down payment).<br>
									■ From 30 to 45 days, 70% of the total price of the stay must be paid (deposit to be deducted).<br>
									■ From 6 days to D-day, 100% the total price of the stay must be paid (down payment).
									All other services by air, rail or road are independent companies that assume their own responsibilities.<br>
									We recommend that you apply for insurance.
									In case of exceptional events beyond our control, we reserve the right to modify or cancel our trip.
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<table style="background-color:#781c44;color:#FFF">
							<tr>
								<td style="width:50%">';
	
								if (file_exists($logo)) {
									$htmldoc .= '<img src="'.$logo.'" style="width: 100px" />';
								};    
			$htmldoc .= '		</td>
								<td style="width:49%;text-align:right">
									Tèl : '.$soc->tel_soc .'<br>'
									.$soc->site_soc .' - '.$soc->email_soc.'
								</td>
							</tr>
						</table>
					</div>
				</div>
			</page>	';
		}

		
		// echo('========='.__DIR__);
		// die;

		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr',true,'UTF-8');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			$nmdoc = ($type == 'I' || $type == 'A' ? 'INSCRIPTION_' : 'CONTRAT_').($signDevis != '' ? 'SIGNED_' : '').$contact->id_fiche.'.pdf';
			// $filename = $dir.'/'.$nmdoc;
			$filename = __DIR__."/../Dashboard/uploads/".$contact->codekey.$contact->id_fiche.'/'.$nmdoc;
			// echo $filename;
			// die;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/'.$contact->codekey.$contact->id_fiche.'/'.$nmdoc.'?time='.time();

		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}
	}
	
	public static function BuildContrat ($contact, $local=true){ 
		
		$dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_fiche);
		
		$sejour = Setting::getOrganisateur(array('id_organisateur'=> $contact->id_organisateur));
		// $organisateur = Setting::getOrganisateurOrg(array('id_organisateur'=> $contact->id_org));

		$all = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche));
		$ad = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'1'));
		$enf = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'2'));
		$bb = Fiche::getAllDetails(array('id_fiche'=>$contact->id_fiche, 'type_detail'=>'3'));
		
		$nbadulte = $ad->num_rows;
		$nbenf = $enf->num_rows;
		$nbbb = $bb->num_rows;

		$logo = __DIR__.'/../Dashboard/uploads/organisateurs/'.$sejour->logo_organisateur;
		
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

		foreach($infchs as $ch){
			$prixch = Chambres::findOneCh(array('id_chambre'=>$ch['id_chambre']));
			if($prixch->tarif_chambre > 0){
				$addTot += $prixch->tarif_chambre;
			}

			$descch .= $prixch->type_chambre.' : '.$prixch->vue_chambre.'<br>';
			$supch .= ($prixch->tarif_chambre > 0 ? $prixch->tarif_chambre.' €<br>' : '');
			$totsupch += $prixch->tarif_chambre;
		}

		$nbclic = 0;
		foreach($all as $details){
			$sumTarif += $details['tarif_details'];
			$sumTarif += $details['tarif_transport'];
			$sumTarif += $details['tarif_supp_detail'];
		}
		
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

		$totFinal = (($tot + $addTot) * (100 - $contact->offre_sejour)) / 100;

		$nbclic = 0;

		
		// $htmldoc = '<style type="text/css" media="screen,print">
						
		// * {font-family:helvetica;}
		// table {border-collapse: collapse; width: 100% ;}
		// td { border : 1px solid black; padding : 5px 10px;}
		// .bold{ font-weight: bold}
		// .justify {text-align: justify}
		// </style>
		$htmldoc = '<style type="text/css" media="screen,print">      
						body {background-image: url("/Dashboard/img/MH-DEVIS-fond.jpg");
										background-repeat: no-repeat;
										background-attachment: fixed;
										background-position: center;
										background-size: cover;}        
						.content-header {height: 10rem !important; display:block !important}
						.text-center {margin-top: 15px !important;}
						.cForm {justify-content:center}            
						* {font-family:helvetica;}
						table {border-collapse: collapse; width: 100% ;}
						td { border : none; padding : 5px 5px;}
						.bold{ font-weight: bold}
						.justify {text-align: justify}
					</style>

		<page backtop="60mm" backbottom="5mm" backleft="20mm" backright="20mm">
			<page_header style="text-align: center">';
				if (file_exists($logo)) {
					$htmldoc .= '<img src="'.$logo.'" style="width:200px" />';
				}

		$htmldoc .= '
			</page_header>';

		

		$htmldoc .= 
			'
			<div style="line-height:20px;">
				<p>
					<span style="font-size:20px"><b>CONTRAT</b></span><br><br><br>
					
					Cher(e) client(e),<br>
					Ci-joint votre contrat rempli.<br>
					<br>
					<u>Représentant:<br></u>
					<b>'.($contact->civ_contact == 0 ? '' : ($contact->civ_contact == 1 ? 'Mr' : ($contact->civ_contact == 2 ? 'Mme' : 'Mlle'))).' '.strtoupper($contact->first_name).' '.strtoupper($contact->last_name).'</b><br>
					<b>'.$contact->adr1 .' '.$contact->city.' '.$contact->country.'</b><br>
					<u>Téléphone principal : </u> <b>'.$contact->tel1.'</b><br>
					<u>Téléphone secondaire : </u> <b>'.$contact->tel2.'</b><br>
					<u>Email : </u> <b>'.$contact->email.'</b><br>
				</p>
					Détails :<br>
					<table class="center">
						<tr>
							<td>
								NOM
							</td>
							<td>
								PRENOM
							</td>
							<td>
								DATE DE NAISSANCE
							</td>
							<td>
								N° de PASSEPORT
							</td>
						</tr>';

				foreach($all as $det){
					$htmldoc .= '
							
						<tr>
							<td>
								'.$det['last_name_detail'].'
							</td>
							<td>
								'.$det['first_name_detail'].'
							</td>
							<td>
								'.Date('d/m/Y', strtotime($det['date_naissance_detail'])).'
							</td>
							<td>
								'.$det['num_passport'].'
							</td>
						</tr>';
				};

		$htmldoc .= '</table>
			</div>
		</page>	';

		$htmldoc .= '<style type="text/css" media="screen,print">
						
			* {font-family:helvetica;}
			table {border-collapse: collapse; width: 100% ;}
			td { border : 1px solid black; padding : 5px 10px;}
			.bold{ font-weight: bold}
			.justify {text-align: justify}
			</style>
			<page backtop="60mm" backbottom="5mm" backleft="20mm" backright="20mm">
				<page_header style="text-align: center">';
					if (file_exists($logo)) {
						$htmldoc .= '<img src="'.$logo.'" style="width:150px" />';
					}

		$htmldoc .= '
				</page_header>';

			

		$htmldoc .= 
				'
				<div style="width:500px">
					<div style="line-height:20px;">
						<p stylle="text-align;center">CONDITIONS GENERALES DE VENTE</p>

						<div style=" text-align: justify;text-justify: inter-word;">
							<p>
							Nous vous remercions de prendre connaissance des présentes Conditions Générales de Vente, indispensables pour la
							validation de tout achat de voyages sur l’ensemble de nos séjours.
							Toutes réservations, implique automatiquement l’acceptation de nos conditions générales de ventes.
							DEMO SOC
							SAS DEMO SOC au capital de 1000€
							********** 67000 Strasbourg - Tel : 07.88.21.39.32 - Email : demo@demo.com
							Siret 908 415 748
							</p>
							<b>RESERVATIONS</b>
							<p>
							La validation de votre dossier sera définitive après la réception du mail de confirmation de votre réservation.
							</p>
							<b>PRIX</b>
							<p>
							Les prix sont affichés en Euros, Certains modes de paiements peuvent être soumis à des frais de traitements.
							</p>
							<b>RETRACTATION</b>
							<p>
							Les règles de la vente à distance (code de la consommation) prévoient notamment un délai de rétractation de 7 jours pour
							échanges ou remboursement. Cette faculté de rétractation prévue par le Code de la Consommation lors d’une vente à
							distance n’est pas applicable aux prestations touristiques. Le nouvel article L.121204 du Code de la Consommation précise que
							la plupart des dispositions ne sont pas applicables aux contrats ayant pour objet « la prestation de services d’hébergement, de
							transport, de restauration, de loisirs... » L’acheteur ayant réservé et/ou commandé à distance (par téléphone ou via internet)
							une prestation auprès de l’Organisateur, ne bénéficie donc pas du droit de rétractation.
							</p>
							<b>ANNULATION OU MODIFICATION DE LA PART DE L’ACHETEUR
							</b>
							<p>
							D’une façon générale, toute demande d’annulation doit être adressée par lettre recommandée avec accusé de réception la
							date du cachet de la poste faisant foi à l’adresse de DEMO SOC- ********** 67000 Strasbourg
							Le voyagiste ne pourra être tenu responsable des prestations apportées par l’établissent hébergeur mais restera à disposition
							en qualité d\'intermédiaire.
							Tout voyage interrompu, écourté ou toute prestation non consommée par le client ne fera l’objet d’aucun remboursement. Il
							devra dans ce cas se conformer à son contrat d’assurance si celui-ci a été souscrit lors de l’achat de la prestation.
							</p>
							<b>MODIFICATION OU ANNULATION DU FAIT DE DEMO SOC
							</b>
							<p>
							L\'organisateur se réserve le droit de modifier tout ou partie des programmes établis, et ce, en fonction des conditions
							climatiques, politiques ou des contraintes de sécurité l’impossibilité d\'effectuer tout ou partie d\'un programme par suite de
							conditions météorologiques défavorables, de cas fortuits ou de force majeure, n\'ouvre droit à aucun remboursement.
							L\'organisateur ne peut être tenu pour responsable :
							- du défaut d\'enregistrement du client au lieu de départ du voyage occasionné par un retard de pré acheminement aérien,
							ferroviaire ou terrestre, même si ce retard résulte d\'un cas de force majeure.
							- de l\'impossibilité du participant de prendre le départ prévu en raison de la présentation de documents périmés (passeport,
							carte d\'identité, carnet de vaccination) ou non conformes à ceux exigés par les autorités compétentes du pays de destination.
							</p>
							<b>ANNULATION
							</b>
							<p>
							Si cette annulation est imposée par des circonstances de force majeure ou tenant à la sécurité des voyageurs le client ne
							pourra prétendre à aucune indemnité. Toutefois si DEMO SOC se trouvait contraint d’annuler un séjour (hors cas de force
							majeure) le client serait averti par lettre ou tout autre moyen. L’ensemble des sommes versées lui serait alors entièrement
							remboursé.
							</p>
							<b>DECLARATION DE CONFIDENTIALITE DONNEES PERSONNELLES
							</b>
							<p>
							Lors de votre inscription et pour traiter votre demande de réservation, nous avons besoin de votre nom, prénom(s), adresse,
							numéro de téléphone, adresse email ainsi que votre numéro de carte de crédit/carte bancaire et sa date d’expiration. Votre
							numéro de téléphone nous permet de vous contacter en cas d’ultime nécessite et en cas de problème avec votre réservation.
							Nous devons aussi connaître le nom et civilité de tous les passagers. Lors de votre paiement, nous transmettons certaines de
							vos informations personnelles concernant votre mode de paiement à l’organisme financier qui a émis la carte de débit/crédit
							avec laquelle vous avez effectué votre réservation. Une fois inscrit entant que membre, lors de votre prochaine réservation,
							vos dernières données s’affichent automatiquement dès votre identification : et en cas de modifications de ces données, vous
							êtes invités à les mettre à jour.
							</p>
							<b>TRANSMISSION DE VOS DONNEES
							</b>
							<p>
							Il est possible que nous utilisions parfois les informations recueillies pour vous tenir informé de nouveaux services ou
							nouvelles offres qui pourraient vous intéresser. Si vous préférez ne pas recevoir ces informations par email, veuillez nous
							appeler. Vous pouvez mettre fin à votre inscription à tout moment
							</p>
							<b>DIFFUSION A DES TIERS
							</b>
							<p>
							Vos informations personnelles ne sont pas vendues, échangées ou louées. Nous ne diffusons jamais les informations
							concernant un passager à une tierce personne ou organisation sans l’autorisation de cette personne sauf si la situation le
							demande (en cas d’urgence) ou si nous y sommes contraints par la loi. Il est possible que nous fournissions l’ensemble ou en
							partie des statistiques globales sur nos clients, nos ventes, les tendances d’utilisation et d’une manière générale sur l’activité
							commerciale du site des revendeurs et organismes de conseils dignes de foi. Toutefois, ces statistiques ne contiennent aucune
							information personnelle suffisante à toute identification.
							</p>
							<b>PHOTO ET VIDEO
							</b>
							<p>
							DEMO SOC pourra utiliser, dans le cadre promotionnel (album souvenir, site internet, publications, reportage) des photos de
							participant prises au cours du Séjour.
							</p>
							<b>SECURITE 
							</b>
							<p>
							Tout participant s’engage à respecter les règles de vie du groupe. En cas de faute grave (vol, tapage nocturne, dégradations,
							insultes, bagarres...) tout participant sera exclu sans prétendre à une indemnité. DEMO SOC se réserve le droit de poursuivre
							le participant ayant commis des actes portant atteinte au bon fonctionnement du séjour et réclamer les frais de toutes les
							dégradations
							</p>
							<b>ASSURANCES 
							</b>
							<p>
							Dans le cadre d’une adhésion auprès d’un courtier d’assurance DEMO SOC n’agit qu’en qualité de simple intermédiaire entre
							le client et l’assurance, et ne peut se substituer à la position de ce dernier. DEMO SOC ne pourrait être tenue responsable :
							- D’une souscription prise et payée par un client ne correspondant pas aux critères d’adhésion.
							- Du non remboursement d’une réservation par l’assurance lié ou non aux conditions ci-dessus d’adhésion.
							</p>
							<p>
							Je soussigné (nom, prénom) '.($contact->civ_contact == 0 ? '' : ($contact->civ_contact == 1 ? 'Mr' : ($contact->civ_contact == 2 ? 'Mme' : 'Mlle'))).' '.strtoupper($contact->first_name).' '.strtoupper($contact->last_name).' agissant pour moi-même et/ou pour le compte des autres
							personnes inscrites, certifie avoir pris connaissance du programme et des conditions générales de vente.
							La Signature précédée de la mention « Lu et approuvé »

							<br><br>
							<div style="">
								Lu et approuvé  : [Signature1/] 
							</div>
							</p>
						</div>

					</div>
				</div>';

		$htmldoc .= '
			</page>';



		// echo $htmldoc;
		// die;
		
		require_once(__DIR__.'/../Dashboard/libry/html2pdf/vendor/autoload.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->WriteHTML($htmldoc);
			$html2pdf->addFont('latoregular', '', 'latoregular');
			$nmdoc = 'CONTRAT_'.$contact->id_fiche.'.pdf';
			// $filename = $dir.'/'.$nmdoc;
			$filename = __DIR__."/../Dashboard/uploads/".$contact->codekey.$contact->id_fiche.'/'.$nmdoc;
			// echo $filename;
			// die;
			$html2pdf->Output($filename, 'F');
			return $local ? $filename : 'uploads/'.$contact->codekey.$contact->id_fiche.'/'.$nmdoc.'?time='.time();

		}
		catch(HTML2PDF_exception $e) {
			return $e;
			exit;
		}
	}

	public static function PdfMerging($files, $filename, $dir='' ,$dontremove = array())
    {
        require_once(__DIR__.'/../Dashboard/libry/pdfi.php');

        $pdf = new PDF();
		
        foreach($files as $file) {
            if ($file != '') {
				
				$fileContent = file_get_contents($file,'rb');
				// ...
				// $pagecount = $pdf->setSourceFile($fileContent);
				$pagecount = $pdf->setSourceFile(__DIR__.'/../'.$dir.$file);
				// echo(print_r($file).'<br>'.__DIR__.'/../Dashboard/uploads/docs/EMP_TIME_2022-08-18.pdf');
				// die;
                // $pagecount = $pdf->setSourceFile($file);
				
                for($i=0; $i<$pagecount; $i++){
					$tpl = $pdf->importPage($i + 1);
                    $pdf->AddPage();
                    $pdf->useTemplate($tpl);
                }               
            }
        }
		
        foreach($files as $file) 
            if (!in_array($file, $dontremove))
                unlink($file);
            
        $pdf->output($filename, 'F');
    }
}

?>