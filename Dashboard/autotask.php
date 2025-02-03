<?php	
	if (!isset($_GET['pkey']) || $_GET['pkey'] != '099df7FxF5g7') {
		echo 'CANNOT ACCESS !!';	 
		die;
	}
	
    include '../including/dbclass.php';
    error_log("INFO AUTOTASK START : ".date('d/m/y H:i').PHP_EOL);

    $majStock = QueryExec::querySQL("SELECT pld.*, pl.name_plat, pl.base_nb_personne, pl.type_personne
                                  FROM
                                      db_menus m
                                  INNER JOIN db_plats_details pld ON
                                      pld.id_plat = m.id_plat
                                  INNER JOIN db_plats pl ON 
                                      pl.id_plat = pld.id_plat
                                  INNER JOIN db_produits p ON
                                      p.id_produit = pld.id_produit
                                  WHERE
                                      m.is_do = 0 AND m.date_menu = CURRENT_DATE()");

    $addWh = " AND ((c.date_start BETWEEN CURRENT_DATE() AND CURRENT_DATE()) OR (c.date_end BETWEEN CURRENT_DATE() AND CURRENT_DATE()))";

    $sqlBB = "SELECT COUNT(d.age) as 'BB', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
            FROM db_contacts_details d 
            INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
            INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
            WHERE d.age <= ".$ageBb->age_bb.$addWh." GROUP BY 'BB' ORDER BY c.date_start ";

    $sqlEnfant = "SELECT COUNT(d.age) as 'Enfant', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
            FROM db_contacts_details d 
            INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
            INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
            WHERE (d.age >= ".($ageBb->age_bb + 1)." AND d.age <= ".$ageEnfant->age_enfant.") ".$addWh." GROUP BY 'Enfant' ORDER BY c.date_start ";

    $sqlAdulte = "SELECT COUNT(d.age) as 'Adulte', c.id_organisateur as id_sejour, o.name_organisateur as sejour 
            FROM db_contacts_details d 
            INNER JOIN db_contacts c ON c.id_fiche = d.id_fiche 
            INNER JOIN db_organisateurs o ON c.id_organisateur = o.id_organisateur 
            WHERE d.age >= ".$ageAdulte->age_adulte.$addWh." GROUP BY 'Adulte' ORDER BY c.date_start ";

            // echo$sqlBB.'<br>'.$sqlEnfant.'<br>'.$sqlAdulte;
            // die;
    $resBB = QueryExec::querySQL($sqlBB, true);
    $resEnfant = QueryExec::querySQL($sqlEnfant, true);
    $resAdulte = QueryExec::querySQL($sqlAdulte, true);

    foreach($majStock as $stock){
        $nbPersonne = $stock['base_nb_personne'];
        $typePersonne = $stock['type_personne'];
        if($typePersonne == 0){
            if($nbPersonne >= ($resBB->BB + $resEnfant->Enfant + $resAdulte->Adulte)){
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.$stock['val_plat_detail'].' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));
            }else{
                $ratio = ($resBB->BB + $resEnfant->Enfant + $resAdulte->Adulte) / $nbPersonne;
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.($stock['val_plat_detail'] * $ratio).' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));

            }
        }

        if($typePersonne == 1){
            if($nbPersonne >= $resAdulte->Adulte){
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.$stock['val_plat_detail'].' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));
            }else{
                $ratio = $resAdulte / $nbPersonne;
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.($stock['val_plat_detail'] * $ratio).' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));

            }
        }

        if($typePersonne == 2){
            if($nbPersonne >= $resEnfant->Enfant){
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.$stock['val_plat_detail'].' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));
            }else{
                $ratio = $resEnfant->Enfant / $nbPersonne;
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.($stock['val_plat_detail'] * $ratio).' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));

            }
        }

        if($typePersonne == 3){
            if($nbPersonne >= $resBB->BB){
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.$stock['val_plat_detail'].' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));
            }else{
                $ratio = $resBB->BB / $nbPersonne;
                QueryType::updateSimple('db_produits','val_produit = val_produit - '.($stock['val_plat_detail'] * $ratio).' WHERE id_produit = '.$stock['id_produit']);
                QueryType::updateSimple('db_menus','is_do = 1 WHERE date_menu = '.date('Y-m-d'));

            }
        }

        
    }

  ?>


