<?php

include 'including/config.php'; ?>


<?php
    if (isset($_GET['refreshCMD']) && $_GET['refreshCMD'] == 'CMD' && !isset($_GET['new'])){
        die(json_encode(array('html' => Grid4PHP::getGrid('commandes_add', $_GET['numcmd']))));
	}

    if (isset($_GET['refreshCMD']) && $_GET['refreshCMD'] == 'CMD' && isset($_GET['new']) && $_GET['new'] == 'NEW'){
       $numcmd = Cmd::getLastNoCmd(array('id_sejour'=>max($usrActif->cursoc, 1)));
        die(json_encode(array('html' => Grid4PHP::getGrid('commandes_add', $_GET['numcmd']))));
	}

    if (isset($_GET['refreshCMD']) && $_GET['refreshCMD'] == 'CANCEL' ){
        die(json_encode(array('html' => Grid4PHP::getGrid('commandes_add', $_GET['numcmd']))));
	}

    /* Dernier num cmd + 1 */
    $numcmd = Cmd::getLastNoCmd(array('id_sejour'=>max($usrActif->cursoc, 1)));
    $verifcmd = Cmd::findOne(array('num_cmd'=>'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT), 'is_validate'=>'0'));
    // echo(print_r($verifcmd));
    
    
    $outcmdsadd = Grid4PHP::getGrid('commandes_add', 'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT));
    $outcmds = Grid4PHP::getGrid('db_commandes_fournisseurs',max($usrActif->cursoc, 1));

    $cpt = 0;
    if (isset($_GET['inpt'])){
        $predicat = '';
        
        if(strtoupper(substr($_GET['inpt'],0,4)) == 'CMD_'){
            $predicat .= " AND c.num_cmd = '".$_GET['inpt']."' GROUP BY c.num_cmd";
        }
        if(strtoupper(substr($_GET['inpt'],0,1) == '_')){
            $predicat .= " AND c.num_cmd = 'CMD".$_GET['inpt']."' GROUP BY c.num_cmd";
        }
        // if(strtotime($_GET['inpt']) > 0){
        //     $predicat .= " AND c.date_cmd = '".$_GET['inpt']."'";
        // } 
        if((int)$_GET['inpt'] > 0){
            $predicat .= " GROUP BY c.num_cmd HAVING SUM(c.val_qte) >= ".$_GET['inpt'];
        } 
        $cmdTable = QueryExec::querySQL("SELECT c.num_cmd, c.date_cmd, f.name_fournisseur, s.name_organisateur, c.id_sejour, c.id_fournisseur, c.is_annule, c.is_validate
                            FROM db_commandes c 
                            INNER JOIN db_fournisseurs f ON c.id_fournisseur = f.id_fournisseur
                            INNER JOIN db_organisateurs s ON c.id_sejour = s.id_organisateur
                            WHERE c.id_sejour = ".$usrActif->cursoc.$predicat);

                            // echo("SELECT c.num_cmd, c.date_cmd, f.name_fournisseur, s.name_organisateur, c.id_sejour, c.id_fournisseur, c.is_annule, c.is_validate
                            // FROM db_commandes c 
                            // INNER JOIN db_fournisseurs f ON c.id_fournisseur = f.id_fournisseur
                            // INNER JOIN db_organisateurs s ON c.id_sejour = s.id_organisateur
                            // WHERE c.id_sejour = ".$usrActif->cursoc.$predicat);
    }else{
        $cmdTable = QueryExec::querySQL("SELECT c.num_cmd, c.date_cmd, f.name_fournisseur, s.name_organisateur, c.id_sejour, c.id_fournisseur, c.is_annule, c.is_validate
                            FROM db_commandes c 
                            INNER JOIN db_fournisseurs f ON c.id_fournisseur = f.id_fournisseur
                            INNER JOIN db_organisateurs s ON c.id_sejour = s.id_organisateur
                            WHERE c.id_sejour = ".$usrActif->cursoc." GROUP BY c.num_cmd");
    }


$mtypes = ModelMail::find("");
?>
<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/menu.css">
    
<div id="page-content" class="page-dashboard"> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

    <h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Commandes fournisseur(s)" : "Providers orders") ?> </h2>
  
    <div id="dataDivID" class="form-container">
        <div class="block-full">
            <div class="row">
                <div class="col-md-6 pull-left" id="zonefind" style="/*! margin: 15px; */">
                    <select id="selfind" name="selfind" class="pull-left form-control " style="width: 155px;margin-right: 15px;">
                        <option value="1"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° commande' :'N° order' )?></option>
                        <option value="2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant >= à' :'Amount >= to' )?></option>
                        <!-- <option value="3"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date' :'Date' )?></option> -->
                    </select>
                    <input class="" type="text" name="inptfind" id="inptfind">
                    <a href="#" class="btn btn-success" id="btfind" style="margin-left:15px"><i class="fa fa-search"></i></a>
                    <a href="#" class="btn btn-primary" id="btrefresh" style="margin-left:15px"><i class="fa fa-refresh"></i></a>
                </div>
                <div class="col-md-6 pull-right" style="margin:15px">
                    <a href="#" class="btn btn-warning" id="btrapp"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nouveau rappel' :'New reminder' )?></a>
                    <a href="#" class="btn btn-primary" id="newcmd"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Passez une commande" : "To order") ?></a>
                    <a href="#" class="btn btn-info" id="viewcmd" style="display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Historique des commandes" : "Orders history") ?></a>
                    <a href="#" class="btn btn-success" id="mailcmd" style="display:none"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Envoyez un mail au fournisseur" : "Sending an email to the provider") ?></a>
                </div>
            </div>
        </div>
        <div id="lstcmd">
          <div class="block">
              <div class="table-responsive">
                 
                <table class="table-striped">
                    <th style="width:10px">
                        
                    </th>
                    <th>
                        <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Num. Commande" : "Order number") ?>
                    </th>
                    <th>
                        <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Fournisseur" : "Provider") ?>
                    </th>
                    <th>
                        <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Date Commande" : "Date") ?>
                    </th>
                    <th>
                        <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Séjour" : "Stay") ?>
                    </th>
                </table>
                <div style="overflow-x: auto;height: 525px;">
                    <table class="table-striped">
                        <?php foreach($cmdTable as $td){
                        echo '<tr id="'.$td['num_cmd'].'" style="'.($cpt % 2 == 0 ? 'background-color:#ede8e8' : '').'">
                                <td>
                                    <a class="btn expand" id="'.$td['num_cmd'].'" style="margin:5px"><i class="fa fa-plus"></i></a>
                                </td>
                                <td style="'.($td['is_annule'] == '1' ? 'background-color:red' : '').'">
                                    '.$td['num_cmd'].'
                                </td>
                                <td>
                                    '.$td['name_fournisseur'].'
                                </td>
                                <td>
                                    '.$td['date_cmd'].'
                                </td>
                                <td>
                                    '.$td['name_organisateur'].'
                                </td>
                                <td>
                                    <a class="btn btn-primary btprintcmd" data-toggle="tooltip2" title="imprimez la commande" data-fourn="'.$td['id_fournisseur'].'" data-cmd="'.$td['num_cmd'].'" style="margin:5px"><i class="fa fa-print"></i></a>
                                </td>
                                <td>
                                    <a class="btn btn-warning btmailcmd" data-toggle="tooltip2" title="Envoyez un mail au fournisseur" data-fourn="'.$td['id_fournisseur'].'" data-cmd="'.$td['num_cmd'].'" style="margin:5px"><i class="fa fa-envelope"></i></a>
                                </td>
                            </tr>
                            <tr >
                                <td class="expand'.$td['num_cmd'].'" colspan="6"></td>
                            </tr>
                           ';
                           $cpt++;
                        }?>
                    </table>
                </div>
              </div>
          </div>
        </div>
        <div id="sendcmd" style="display:none">
        
            <div class="">
                <div class="container">
                    <div class="row" style="">
                       <input type="hidden" name="findcmdfourn" id="findcmdfourn" value="<?php echo $verifcmd->id_fournisseur ?>" />
                       <input type="hidden" name="newnumcmd" id="newnumcmd" value="<?php echo 'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT) ?>" />
                        <div class="col-md-3">
                            <label for="encours" style="" class="control-label" style=""><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dupliquer une Commande" : "Duplicate orders") ?></label>
                            <select data-placeholder="Choisissez la commande " class="form-control select-chosen" id="id_cmd_duplique" name="id_cmd_duplique" style="/*width: 200px;*/">
                                <option value=""></option>
                                <?php
                                $cmds = Cmd::getAllEnCours(array('is_validate'=>'1', 'id_sejour'=>$usrActif->cursoc));
                                if ($cmds) {
                                    foreach ($cmds as $cmd) {
                                        echo '<option data-fourn="'.$cmd['id_fournisseur'].'" data-numcmd="'.$cmd['num_cmd'].'" value="' . $cmd['num_cmd'] . '" >' . $cmd['num_cmd'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="encours" style="" class="control-label" style=""><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Commandes non validées" : "Orders not validated") ?></label>
                            <div id="selcmd">
                                <select data-placeholder="Choisissez la commande " class="form-control select-chosen" id="id_cmd" name="id_cmd" style="/*width: 200px;*/">
                                    <option value=""></option>
                                    <?php
                                    $cmds = Cmd::getAllEnCours(array('is_validate'=>'0', 'is_annule'=>'0', 'id_sejour'=>$usrActif->cursoc));
                                    if ($cmds) {
                                        foreach ($cmds as $cmd) {
                                            echo '<option data-fourn="'.$cmd['id_fournisseur'].'" data-numcmd="'.$cmd['num_cmd'].'" value="' . $cmd['num_cmd'] . '" >' . $cmd['num_cmd'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="fourn" style="" class="control-label" style=""><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "fournisseur" : "Provider") ?></label>
                            <select aria-describedby="id_fournisseur" data-placeholder="Choisissez le fournisseur " class="form-control select-chosen" id="idfourni" name="id_fournisseur" style="/*width: 200px;*/">
                                <option value="0"></option>
                                <?php
                                $frns = Fournisseurs::getAll();
                                if ($frns) {
                                    foreach ($frns as $frn) {
                                        echo '<option data-id="'. $frn['id_fournisseur'] .'" value="' . $frn['id_fournisseur'] . '" >' . $frn['name_fournisseur'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="idfourn" id="idfourn" value="0" />
                        </div>
                        <div class="col-md-3">
                            <label for="numcmd" style="margin-right:5px" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Commande en cours" : "Pending order") ?></label>
                            <input type="text" class="form-control" id="numcmd" name="numcmd" value="<?php echo 'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT) ?>" style="width: 200px;" readonly="">
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-9" style="margin-top: 26px;">
                            <a href="#" class="btn btn-warning" id="dupliquecmd"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Copie commande" : "Copy order") ?></a>
                        </div>
                         <div class="col-md-3" style="margin-top: 26px;">
                            <a href="#" class="btn btn-primary" id="changecmd"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nouvelle commande" : "New order") ?></a>
                        </div>
                        
                    </div>

                    <div class="row" style="margin-top: 25px;">
                        <table id="tbcmd" class="display table table-striped table-bordered" cellspacing="0" style="width:100%;text-align: center;">
                            <thead>
                                <tr>
                                    <th style="width:30%;text-align: center;">
                                    <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Produits" : "Products") ?>
                                    </th>
                                    <th style="width:10%;text-align: center;"> 
                                    <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Unités" : "Units") ?> 
                                    </th>
                                    <th style="width:10%;text-align: center;"> 
                                        Qté 
                                    </th>
                                    <th style="width:15%;text-align: center;"> 
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="prod">
                                    
                                </td> 
                                <td id="unit">
                                    
                                </td>
                                <td id="">
                                    <input type="text" class="form-control" name="qtecmd" id="qtecmd"></input>
                                </td>
                                <td id="">
                                    <label for="addcmd" class="control-label" style="margin-right:5px"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Ajoutez la ligne" : "Add line") ?></label>
                                    <button href="#" id="addcmd" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 pull-left" style="margin-top: 10px;">
                    <a href="#" class="btn btn-warning" id="validecmd"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Validez la commande" : "Confirm order") ?></a>
                </div>
                <div class="col-md-2 pull-right" style="margin-top: 10px">
                    <a href="#" class="btn btn-danger" id="resetcmd"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Annulez la commande" : "Cancel") ?></a>
                </div>
            </div>

            <div class="" style="margin-top: 60px;">
                <div class="table-responsible" id="htmlCmd">
                    <?php echo $outcmdsadd ?>
                </div>
            </div>
        </div>
	</div>

	<div id="modal-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" style="height: 700px;">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Envoi Email" : "Send email") ?></h2>
				</div>
				<div class="modal-body">
					<form onsubmit="return false;" class="" id="formulairemsgdoc" method="post" action="appajax.php">
							
						<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Destinataire(s)" : "Recipient(s)") ?></label>
						<div class="form-group">
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="destemail" />
							</div>
						</div>

                        <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Sujet" : "Subject") ?></label>
						<div class="form-group">	
							<div class="col-md-6">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmail" placeholder="sujet" />
									<div class="input-group-btn" data-toggle="tooltip" title="Charger un message type">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcont" style="width: 50px;height: 34px;"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<?php foreach ($mtypes as $mtype) {?>
												<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" class="lnkmailtype"><?php echo $mtype['name_mailtype']; ?></a></li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
                        
							<label class="col-md-4 control-label">Message</label>
						<div class="form-group">
                            <div class="col-md-12">
                                <textarea id="msgcontent" name="msgcontent" class="ckeditor">
                                    
                                </textarea>
                            </div>
                        </div>

                        <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Pièces jointes" : "Attachments") ?></label>
                        <div class="form-group">
                            <div id="attacheddocs" class="col-md-12 block">
                            </div>
                            <div id="blksenddocint">
                                <div id="lstdocsctt" class="col-md-12"></div>
                            </div>

                            <div id="txtmailpres" class="display-none">							
                            </div>
                            <input type="file" name="fileadd[]" id="fileadd"  style="display:none;" multiple>
                        </div>
						
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="Ajouter un document" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddoc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocin"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
									<button href="#" class="btn btn-sm btn-danger pull-left" title="Retier les pièces jointe" data-toggle="tooltip" id="btdeldoc"><i class="fa fa-minus"></i></button>
								</div>                    
								<input type="hidden" name="id_mailtype" id="id_mailtype" value="0" />
								<input type="hidden" name="attachclr" id="attachclr" value="0" />
								<input type="hidden" name="typeMail" id="typeMail" value="0" />
								<input type="hidden" name="idMailType" id="idMailType" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btsenddoc" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
				
			</div>
		</div>
	</div>

    <div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="text-right display-none" id="blksigndoc" style="padding:15px 15px 0;">
					<a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi du document en Signature électronique' : 'Send document in electonic signature') ?></a>
				</div>
				<div class="modal-body" style="height: 100vh">
					<iframe src="" style="width:100%;height:100%;"></iframe>
					<input type="hidden" id="view_id_docs" />
				</div>
			</div>
		</div>
	</div>

    <div id="modal-cmd" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-file"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Passez une commande' : 'To order') ?></h2>
				</div>
				<div class="modal-body">
                    
				
			</div>
		</div>
	</div>

    <div id="modal-msg-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi mail' : 'Send email') ?></h2>
				</div>
				
				<div class="modal-body">
					<form onsubmit="return false;" class="form-horizontal" id="formulairemsgdoc" method="post" action="appajax.php">
							
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire(s)' : 'Recipient(s)') ?></label>
							<div class="col-md-8">
								<input type="text" class="form-control"  value="" id="destemail" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" class="form-control"  value="" id="subjectmail" placeholder="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?>" />
									<div class="input-group-btn" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Choix du modèle' : 'Choice of model') ?>">
										<a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" id="btmtcont"><i class="gi gi-pen"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
										<?php foreach ($mtypes as $mtype) { ?>
												<li><a href="javascript:void(0)" data-typeMail = "1" data-id="<?php echo $mtype['id_mailtype']; ?>" data-type="<?php echo $mtype['type_mail']; ?>" class="modeltype cl-<?php echo $mtype['type_mail']; ?>"><?php echo $mtype['name_mailtype']; ?></a></li>
											<?php } ?>
										</ul>
											
									</div>
								</div>
							</div>
						</div>
						
						<textarea id="msgcontentmsg" name="msgcontentmsg" class="ckeditor">
							
						</textarea>
						<div id="attacheddocs" class="block">
						</div>
						<div id="blksenddocint">
							<div id="lstdocsctt" class="col-md-12"></div>
						</div>

						<div id="txtmailpres" class="display-none">							
						</div>
						<input type="file" name="fileadd[]" id="fileadd"  style="display:none;" multiple>
						<div class="form-group form-actions">
							<div class="col-md-12 text-center">

								<div class="btn-group pull-left" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajouter pièces jointes' : 'Add attachments') ?>" data-toggle="tooltip">
									<button href="#" class="btn btn-sm btn-success pull-left" data-toggle="dropdown"><i class="fa fa-plus"></i></button>
									<ul class="dropdown-menu text-left" id="adddoclst">
										<li><a href="javascript:void(0)" id="btadddoc"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le poste' : 'From pc') ?></a></li>
										<li><a href="javascript:void(0)" id="btadddocin"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Depuis le serveur' : 'From CRM') ?></a></li>
									</ul>
								</div>                    
								<button href="#" class="btn btn-sm btn-danger pull-right" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Retirer pièces jointes' : 'remove attachments') ?>" data-toggle="tooltip" id="btdeldoc"><i class="fa fa-minus"></i></button>
								<input type="hidden" name="id_mailtype" id="id_mailtype" value="0" />
								<input type="hidden" name="attachclr" id="attachclr" value="0" />
								<input type="hidden" name="typeMail" id="typeMail" value="0" />
								<input type="hidden" name="idMailType" id="idMailType" value="0" />
								<button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
								<button class="btn btn-sm btn-primary" id="btsenddoc" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
							</div>
						</div>
					</form>				
				</div>
			</div>
		</div>
	</div>
	
</div>


<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTPCq11w-n5ZN8o3fIzhuUXCwPTTP6OmE&libraries=places"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>


<script>
	$(document).ready(function() {

        $('#btrefresh').click(function(){
            window.location.href = 'commandes.php';
            return false            
        })

        $('#btfind').click(function(){
            if($('#selfind').val() == '1'){
                console.log('1', '<?php (int)$_GET['inpt'] ?>')
                if($('#inptfind').val().substring(0,1) == '_'){
                    console.log('_')
                    window.location.href = 'commandes.php' + '?inpt=CMD'+$('#inptfind').val();
                }else{
                    if($('#inptfind').val().toUpperCase().substring(0,4) == 'CMD_'){
                        console.log('CMD_')
                        window.location.href = 'commandes.php' + '?inpt='+$('#inptfind').val();
                    }else{
                        if(parseInt($('#inptfind').val()) > 0){
                            console.log('> 0')
                            window.location.href = 'commandes.php' + '?inpt=CMD_'+$('#inptfind').val().padStart(5,0);
                        }
                    }
                }
            }

            if($('#selfind').val() == '2'){
                window.location.href = 'commandes.php' + '?inpt='+$('#inptfind').val();
            }
            return false            
        })

        $("#modal-pdf").on('hidden.bs.modal', function(){
            window.location.reload();
        });

        var nameDocSign = '';
		var typeDocSign = '';

		function getNameDoc(name){
			// console.log('name : ',name)
			nameDocSign = name;
			nameDocSign = nameDocSign.substr(nameDocSign.lastIndexOf('/')+1);
			nameDocSign = nameDocSign.substr(0,nameDocSign.indexOf('pdf')-1);
		}

        
        $('.btmailcmd').click(function(){

            $('#destemail').val('')
            $('#idfourni').val($(this).attr('data-fourn'))

            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'find-mail-fourn',
                idfourn: $('#idfourni').val(),
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {

                    $('#destemail').val(resp.email)

                }else{
                
                }
            }, 'json');
            HoldOn.close();
                    
            $('#id_mailtype').val('0');
            $('#typeMail').val('0');
            $('#attachclr').val('0');
            $('#idMailType').val('0');
            $('#name_mailtype').val('');
            $('#stagiaire').val('');
            $('#subjectmail').val('');

            $('#msgcontent').val('');
            CKEDITOR.instances.msgcontent.setData('')

            $('#aff-stag').hide();
            $('#modal-mail').modal('show');

            // $('#modal-amount-rglt').modal('show')
            return false
        })

        $('#mailcmd').click(function(){

            $('#destemail').val('')

            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'find-mail-fourn',
                idfourn: $('#idfourni').val(),
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {

                    $('#destemail').val(resp.email)

                }else{
                   
                }
            }, 'json');
            HoldOn.close();
					
            $('#id_mailtype').val('0');
            $('#typeMail').val('0');
            $('#attachclr').val('0');
            $('#idMailType').val('0');
            $('#name_mailtype').val('');
            $('#stagiaire').val('');
            $('#subjectmail').val('');

            $('#msgcontent').val('');
            CKEDITOR.instances.msgcontent.setData('')

            $('#aff-stag').hide();
            $('#modal-mail').modal('show');
            
            // $('#modal-amount-rglt').modal('show')
            return false
        })

        $('#btsenddoc').click(function() {
			
			var mailType = $('#typeMail').val();
			
			HoldOn.open();
			//var tdoc = $('#curtypeord').val();
			jQuery('#formulairemsgdoc').ajaxSubmit({
				dataType:'json',
				data:{action:'send-mail-fiche-fourn', email:$('#destemail').val(), subject:$('#subjectmail').val(), msg:CKEDITOR.instances['msgcontent'].getData(), mailtypedest : mailType},
				success : function (resp) {	
					HoldOn.close();
					if (resp.responseAjax == 'SUCCESS') {					
						$.bootstrapGrowl('<h4>Confirmation!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Email envoyé' : 'Email sended')?></p>', {
							type: 'success',
							delay: 5000,
							offset: {
							from: "top",
							amount: 100
								},
								align: "center",
							allow_dismiss: true
						});
						
						$('#modal-mail').modal('hide');
						$('#modal-pdf').modal('hide');

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
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


        $(document).on('click','.btprintcmd', function(){
            let cmd = $(this).attr('data-cmd');
            let fourn = $(this).attr('data-fourn');
            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'print-cmd',
                numcmd: cmd,
                idfourn: fourn,
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    
					if (resp.iddoc > 0)
						$('#pdfiddoc').val(resp.iddoc);
					else
						$('#pdfiddoc').val('');

					if (resp.cansign == '1')
						$('#btsigndocelec').removeClass('display-none');
					else
						$('#btsigndocelec').addClass('display-none');

					getNameDoc(resp.doc);
					typeDocSign = 'du bon de commande';


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();
                }else{
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

            return false;
        })

        $(document).on('click','.expand', function(){
            let cmd = $(this).attr('id');
            $(this).removeClass('expand');
            $(this).addClass('notexpand');
            $(this).children().removeClass('fa-plus');
            $(this).children().addClass('fa-minus');
            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'cmd-detail',
              numcmd: cmd,
            }, function(resp) {
              HoldOn.close();
              if (resp.responseAjax == 'SUCCESS') {
                $('.expand'+cmd).append(resp.html)
            }else{
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

            return false;
        })

        $(document).on('click','.notexpand', function(){
            let cmd = $(this).attr('id');
            
            $(this).removeClass('notexpand');
            $(this).addClass('expand');
            $(this).children().removeClass('fa-minus');
            $(this).children().addClass('fa-plus');
           
            $('.expand'+cmd).children().remove()
            
            return false;
        })
        
        var options = {
                theme:"sk-cube-grid",
                message:'<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Chargement des données en cours ....' : 'Message loading ....') ?>',
                backgroundColor:"#1847B1",
                textColor:"white"
            };
        InitFields();

        var emailfrom = '';
        var emailto = '';
    
        $('#newcmd').click(function(){
            // $('#modal-cmd').modal()
            $(this).css('display', 'none');
            $('#lstcmd').css('display', 'none');
            $('#zonefind').css('display', 'none');
            $('#sendcmd').show();
            $('#viewcmd').show();
            $('#mailcmd').show();
            // $('#listeCmd').DataTable({        
            //     "destroy": true, 
            //     "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            //     "iDisplayLength": -1,
            //     "bFilter": true,
            // });
        })

        $('#viewcmd').click(function(){
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Les saisies en cours seront perdues \\n\\rConfirmer votre choix !" : "Entries will be lost \\n\\rConfirm !") ?>')){
              return false;
            }

            $(this).css('display', 'none');
            
            $('#zonefind').show();
            $('#lstcmd').show();
            $('#sendcmd').hide();
            $('#newcmd').show();
            
            $('#mailcmd').hide();
            // $('#listeCmd').DataTable({    
            //     "destroy": true, 
            //     "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            //     "iDisplayLength": -1,
            //     "bFilter": true,
            // });

            // var table = $('#listeCmd').DataTable();
            
            // table.clear().draw();
        })

        $(document).on('change','#id_cmd_duplique', function(){
            
            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'read-copie',
                numcmd: $('#id_cmd_duplique').val(),
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    // on n'applique pas le change du fournisseur pour activation du addcmd depuis $('#idfourni').trigger("change");
                    // on ne fait que de l'affichage pour permettre la duplication qui fera le reste
                    $('#validecmd').attr('disabled', true);
                    $('#resetcmd').attr('disabled', true);
                    $('#changecmd').attr('disabled', false);
                    $('#dupliquecmd').attr('disabled', false);
                    $('#addcmd').attr('disabled', true);

                    $('#numcmd').val($('#id_cmd_duplique').val());
                    $('#idfourni').val(resp.idf).trigger("chosen:updated");
                    $('#idfourni').attr('disabled', true).trigger("chosen:updated");
                    // $('#idfourni').trigger("change");
                    setTimeout(() => {
                        $.get('commandes.php', {refreshCMD: 'CMD', numcmd:$('#id_cmd_duplique').val()}, function(resp) {
                        $('#htmlCmd').html(resp.html);
                        }, 'json');

                        return false;
                    }, 100);
                }else{
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

        $(document).on('change','#id_cmd', function(){
            console.log('jjjj',$('#id_cmd').val(), $(this).val())

            // reactivation du addcmd depuis $('#idfourni').trigger("change");
            $('#validecmd').attr('disabled', false);
            $('#resetcmd').attr('disabled', false);
            $('#changecmd').attr('disabled', false);

            $('#numcmd').val($('#id_cmd').val());
            $('#idfourni').val($('#id_cmd option:selected').attr('data-fourn')).trigger("chosen:updated");
            $('#idfourni').attr('disabled', true).trigger("chosen:updated");
            $('#idfourni').trigger("change");
            setTimeout(() => {
                $.get('commandes.php', {refreshCMD: 'CMD', numcmd:$('#numcmd').val()}, function(resp) {
                $('#htmlCmd').html(resp.html);
                }, 'json');

                return false;
            }, 100);
        })

        $(document).on('change','#idfourni', function(){
            $('#addcmd').attr('disabled', false)
            $('#idfourn').val($(this).val())

            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'read-prod',
              idfourn: $('#idfourn').val(),
            }, function(resp) {
              HoldOn.close();
              if (resp.responseAjax == 'SUCCESS') {
                $('#prod').html(resp.html);
                $('#unit').html(resp.htmlunit)

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
            }else{
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

            return false;
        })

        
        $(document).on('click','#dupliquecmd', function(){
            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'copie-prod',
              numcmd: $('#id_cmd_duplique').val(),
            }, function(resp) {
              HoldOn.close();
              if (resp.responseAjax == 'SUCCESS') {
                    clearFields();
                    $('#dupliquecmd').attr('disabled', true)
                    $('#changecmd').attr('disabled', true)
                    $('#addcmd').attr('disabled', true)
                    $('#validecmd').attr('disabled', false)
                    $('#resetcmd').attr('disabled', false)

                    $('#newnumcmd').val(resp.numcmd);
                    $('#numcmd').val(resp.numcmd);
                    $('#idfourni').val(resp.idf).trigger("chosen:updated");
                    // $('#idfourni').attr('data-fourn').trigger("chosen:updated");
                    $('#idfourni').trigger("change");
                    $('#idfourni').attr('disabled', true).trigger("chosen:updated");

                    setTimeout(() => {
                    $.get('commandes.php', {refreshCMD: 'CMD', numcmd:$('#numcmd').val()}, function(resp) {
                        $('#htmlCmd').html(resp.html);
                        }, 'json');
                    }, 100);

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
                }else{
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
            return false;
        })
        
        $(document).on('click','#changecmd', function(){
            clearFields();
            
            $('#changecmd').attr('disabled', true)
            $('#addcmd').attr('disabled', true)
            $('#validecmd').attr('disabled', true)
            $('#resetcmd').attr('disabled', true)
            $('#dupliquecmd').attr('disabled', true);
            // $("#id_cmd").val('')
            // $('#id_cmd').trigger("chosen:updated");
            
            // setTimeout(() => {
                //     $('#idfourni').val('0').trigger("chosen:updated");
                // $('#idfourni').attr('disabled', false).trigger("chosen:updated");
                //     $('#idfourni').trigger("change");
                // }, 100);
                
            setTimeout(() => {
                $.get('commandes.php', {refreshCMD: 'CMD', numcmd:'99999999999', newcmd:'NEW'}, function(resp) {
                    $('#htmlCmd').html(resp.html);
                    $('#newnumcmd').val('<?php echo 'CMD_'.str_pad($numcmd,5,"0",STR_PAD_LEFT) ?>');
                    $('#numcmd').val($('#newnumcmd').val());
            }, 'json');

            return false;
            }, 100);
        })

        function mailCmdPdf(doc)
        {
            
            $('.modeltype').hide();
            $('.cl-7').show();
                    
            $('#id_mailtype').val('0');
            $('#typeMail').val('0');
            $('#attachclr').val('0');
            $('#idMailType').val('0');
            $('#name_mailtype').val('');
            $('#stagiaire').val('');
            $('#subjectmail').val('');
            
            $('#destemail').val($('#email').val())

            $('#msgcontentmsg').val('');
            CKEDITOR.instances.msgcontentmsg.setData('')

            $('#aff-stag').hide();
            $('#modal-msg-mail').modal();
           
        }

        $(document).on('click','#validecmd', function(){
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Confirmez la validation de cette commande ?" : "Confirm the validation of this order") ?>')){
                return false;
            }
            
            

            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'valide-cmd',
              idfourn: $('#idfourni').val(),
              numcmd: $('#numcmd').val(),
            }, function(resp) {
              HoldOn.close();
              if (resp.responseAjax == 'SUCCESS') {
                $('#changecmd').attr('disabled', true);
                $('#resetcmd').attr('disabled', true);
                $('#addcmd').attr('disabled', true);
                $('#validecmd').attr('disabled', true);
                $('#dupliquecmd').attr('disabled', true);

                // mailCmdPdf(resp.doc);
                
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
                
                
                setTimeout(() => {
                    clearFields()
                    // window.location.reload();
                }, 1000);

                
                if (resp.iddoc > 0)
                    $('#pdfiddoc').val(resp.iddoc);
                else
                    $('#pdfiddoc').val('');

                if (resp.cansign == '1')
                    $('#btsigndocelec').removeClass('display-none');
                else
                    $('#btsigndocelec').addClass('display-none');

                getNameDoc(resp.doc);
                typeDocSign = 'du bon de commande';


                $('#modal-pdf iframe').attr('src', resp.doc);
                $('#modal-pdf').modal();

                // window.location.reload();
            }else{
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

            return false;
        })

        $(document).on('click','#resetcmd', function(){
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Confirmez l\'annulation de cette commande ?" : "Confirm the annulation of this order ?") ?>')){
                return false;
            }

           
            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'reset-cmd',
              idfourn: $('#idfourni').val(),
              numcmd: $('#numcmd').val(),
            }, function(resp) {
              HoldOn.close();
              if (resp.responseAjax == 'SUCCESS') {
                $('#changecmd').attr('disabled', true)
                $('#validecmd').attr('disabled', true)
                $('#addcmd').attr('disabled', true)
                $('#resetcmd').attr('disabled', true)
                $('#dupliquecmd').attr('disabled', true);

                                
                $('#numcmd').val(resp.numcmd);
                $('#selcmd').html(resp.htmlsel);
                
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
                setTimeout(() => {

                    clearFields();

                    $.get('commandes.php', {refreshCMD: 'CANCEL', numcmd:$('#numcmd').val()}, function(resp) {
                        $('#htmlCmd').html(resp.html);
                        }, 'json');

                    // return false;        
                }, 100);

                // setTimeout(() => {
                //     $.get('commandes.php', {refreshCMD: 'CMD', numcmd:$('#numcmd').val()}, function(resp) {
                //         $('#htmlCmd').html(resp.html);
                //         }, 'json');

                //     return false;
                // }, 100);
            }else{
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

            return false;
        })

        $(document).on('change','#id_produit', function(){
           let unit = $('#id_produit option:selected').attr('data-unit');
            console.log('lll',unit, this);
          //  $('#id_unite option[value="'+unit+'"]').attr('selected', true);
           $('#id_unite').val(unit);
           $('#id_unite').trigger('chosen:updated');
        })


        var arrelem = [];
        var elem = '';
        var elemList = '';
        var numberOfItems = 10;
        var first = 0;
        var actualPage = 1;

        $(document).on('click','#addcmd', function(){
            

            HoldOn.open(options);
            $.post('appajax.php', {
              action: 'add-cmd',
              numcmd: $('#numcmd').val(),
              idprod: $('#id_produit').val(),
              idunit: $('#id_unite').val(),
              qte: $('#qtecmd').val(),
              idfourn: $('#idfourn').val(),
            }, function(resp) {
              HoldOn.close();
              if (resp.responseAjax == 'SUCCESS') {
                $('#idfourni').attr('disabled', true).trigger("chosen:updated");
                $('#resetcmd').attr('disabled', false)
                $('#validecmd').attr('disabled', false)

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
                // $('#list_cmd_add').trigger("reloadGrid",[{current:true}]);
                setTimeout(() => {
                    $.get('commandes.php', {refreshCMD: 'CMD', numcmd:$('#numcmd').val()}, function(resp) {
                    $('#htmlCmd').html(resp.html);
                    }, 'json');

                    return false;
                }, 100);
              }else{
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


        $('#idconnect').click(function(){
            getEmails();
        })

        function clearFields()
        {
            $("#idfourni").val("0")
            $('#idfourni').attr('disabled', false).trigger("chosen:updated");
            $('#idfourni').trigger("chosen:updated");

            $("#id_cmd").val('')
            $('#id_cmd').trigger("chosen:updated");
            // $('#id_cmd').trigger("change");

            $("#id_cmd_duplique").val('')
            $('#id_cmd_duplique').trigger("chosen:updated");
            // $('#id_cmd_duplique').trigger("change");

            // $('#idfourni').trigger("change");
            $('#prod').html('');
            $('#unit').html('');
            $('#qtecmd').html('');
        }

        function InitFields(){
            $('#changecmd').attr('disabled', true)
            $('#addcmd').attr('disabled', true)
            $('#validecmd').attr('disabled', true)
            $('#resetcmd').attr('disabled', true)
            $('#dupliquecmd').attr('disabled', true)

            if(parseInt($('#findcmdfourn').val()) > 0){
                $("#id_cmd").val($("#numcmd").val())
                $('#id_cmd').trigger("chosen:updated");
                $('#id_cmd').trigger("change");
                setTimeout(() => {
                    $('#idfourni').val($('#id_cmd option:selected').attr('data-fourn')).trigger("chosen:updated");
                    $('#idfourni').attr('disabled', true).trigger("chosen:updated");
                    $('#idfourni').trigger("change");
                }, 100);

                setTimeout(() => {
                    $.get('commandes.php', {refreshCMD: 'CMD', numcmd:$('#numcmd').val()}, function(resp) {
                    $('#htmlCmd').html(resp.html);
                    }, 'json');

                    return false;
                }, 100);
            }
            // console.log('init')
            // getEmails();
        }
        
        $(document).on('click','.btforward',function(){
            emailfrom = $(this).attr('data-from');
            emailto = $(this).attr('data-to');

            $('#destemail').val(emailfrom)

            $.post('appajax.php', {
				        action: 'recup-infos-mail',
                uid:  $(this).attr('data-id'),
                outbox:1,
			      }, function(resp) {
                        HoldOn.close();
				        if (resp.responseAjax == 'SUCCESS') {
                            $('#subjectmail').val('RE : '+resp.data.subject_mail)
                            $('#msgcontent').val('\n\n\n\n\n\n'+'- - - - - - - - - - - - - - - -'+'\n\n'+resp.data.msg_mail)
                            CKEDITOR.instances.msgcontent.setData('\n\n\n\n\n\n'+'- - - - - - - - - - - - - - - -'+'\n\n'+resp.data.msg_mail);
				        } else
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

				    $('.tooltip.in').remove();
			      }, 'json');

           
            $('#modal-mail').modal('show')
        })

        $('.lnkmailtype').click(function() {
			$('#id_mailtype').val('0');
			$('#typeMail').val('0');
			$('#attachclr').val('0');
			$('#idMailType').val('0');
			$('#name_mailtype').val('');
			$('#stagiaire').val('');
			$('#subjectmail').val('');

			// $('#destemail').val($('#email').val())

			$('#msgcontent').val('');
			CKEDITOR.instances.msgcontent.setData('')
		
			$('#typeMail').val($(this).attr('data-typeMail'))
			var idmt = $(this).attr('data-id');
			$('#idMailType').val(idmt)


			HoldOn.open(options);
			$.post('appajax.php', {
				action: 'affiche-mailtype-fourn',
                emailfrom: emailfrom,
                emailto: $('#destemail').val(),
				id_mailtype: idmt,
				id_fournisseur : $('#idfourni').val(),
			}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
					
					var msg = resp.msg;
					var subject = resp.subject;
					var dest = resp.dest;

					$('#typeMail').val() != 3 ? "" : $('#destemail').val(dest)

					$('#subjectmail').val(subject);
					
					$('#msgcontent').val(msg);
                    console.log(msg)
					CKEDITOR.instances.msgcontent.setData(msg);
					if(resp.data !== null){
						if (resp.data.attach != '')
							$('#attacheddocs').html('<u>Pièces jointes</u> : ' + JSON.parse(resp.data.attach).join(", "));
						else
							$('#attacheddocs').text('');
					}
					$('#id_mailtype').val(idmt);
					$('#attachclr').val('0');
				} else
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

				$('.tooltip.in').remove();
			}, 'json');
            HoldOn.close();

			$('#btmtcont').dropdown("toggle");
			return false;
		});

        $('#cli').click(function(){
			if($('#cli').is(':checked')){
				$('#selcli').show()
				$('#fourn').attr('checked', false)
				$('#commun').attr('checked', false)
				$('#selfourn').hide()
			}else{
				$('#selcli').hide()
				$('#fourn').attr('checked', false)
				$('#commun').attr('checked', false)
				$('#selfourn').hide()
			}
		})

		$('#fourn').click(function(){
			if($('#fourn').is(':checked')){
				$('#selcli').hide()
				$('#cli').attr('checked', false)
				$('#commun').attr('checked', false)
				$('#selfourn').show()
			}else{
				$('#selcli').hide()
				$('#cli').attr('checked', false)
				$('#commun').attr('checked', false)
				$('#selfourn').hide()
			}
		})

		$('#commun').click(function(){
			if($('#commun').is(':checked')){
				$('#id_fiche').val(0)
				$('#idfourni').val(0)
			}
			$('#selcli').hide()
			$('#cli').attr('checked', false)
			$('#fourn').attr('checked', false)
			$('#selfourn').hide()
		})

		$('#btrapp').click(function(){
			$('#modal-global-rappel').modal()
		})

		$('#cli').change(function(){
			$('#id_fiche').val($('#cli').val())
			$('#idfourni').val(0)
		})

		$('#cli').change(function(){
			$('#id_fiche').val(0)
			$('#idfourni').val($('#fourn').val())
		})

		$('#formulairerecallglobal').submit(function(){
			HoldOn.open();
			jQuery(this).ajaxSubmit({
				dataType:'json',
				success : function (resp) {	
					if (resp.responseAjax == 'SUCCESS') {
						$('#modal-global-rappel').modal('hide');
					}
					else
					if (resp.responseAjax == 'ERROR'){
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
					HoldOn.close();
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
               
					HoldOn.close();
				}
			}); 
			return false; 	
		});


    });


    function checkAll(bx) {
    var cbs = document.getElementsByTagName('input');
    for(var i=0; i < cbs.length; i++) {
        if(cbs[i].type == 'checkbox') {
        cbs[i].checked = bx.checked;
        }
    }


}
</script>