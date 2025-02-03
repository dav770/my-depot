<?php	
	if (!isset($_GET['key']) || $_GET['key'] != 'X!0258OJBRGN@') {
		echo 'ACCESS DENIED!!';	 
		die;
	}
	
    include '../including/dbclass.php';
    error_log("INFO TASKSCHEDULE START : ".date('d/m/y H:i').PHP_EOL);

    $majStock = QueryExec::querySQL("SELECT pld.*
                                  FROM
                                      db_menus m
                                  INNER JOIN db_plats_details pld ON
                                      pld.id_plat = m.id_plat
                                  INNER JOIN db_produits p ON
                                      p.id_produit = pld.id_produit
                                  WHERE
                                      m.is_do = 0 AND m.date_menu = CURRENT_DATE()");


    foreach($majStock as $stock){
      QueryType::updateSimple('db_produits','val_produit = val_produit - '.$stock['val_plat_detail'],'id_produit = '.$stock['id_produit']);
      QueryType::updateSimple('db_menus','is_do = 1','date_menu = '.date('Y-m-d'));
    }

  ?>


