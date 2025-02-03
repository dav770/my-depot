
<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>


    <div id="modal-ctrl-stock" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Stock en alerte' : 'Stock on alert') ?></h4>
                </div>
                <div class="modal-body text-center">						
                    <h3><i class="fa fa-warning fa-3x text-danger animation-fadeIn"></i></h3>					
                    
                    <div class="" style="" id="ctrlStock">
                        <table id="produitTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th style="width:20%">ID Produit</th> -->
                                    <th style="width:20%">Nom Produit</th>
                                    <th style="width:20%">Description Produit</th>
                                    <th style="width:20%">Valeur Produit</th>
                                    <th style="width:20%">Alerte</th>
                                    <!-- <th style="width:20%">Action</th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <!-- ETAIT DANS MAINMENU.PHP -->
    <?php if (strstr(basename($_SERVER['PHP_SELF']), 'index') == false && strstr(basename($_SERVER['PHP_SELF']), 'charts') == false) { ?>
        <div id="modal-UsrApp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-user"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Utilisateur" : "User") ?> <? echo $template['title'] ?></h2>
                    </div>
                    
                    
                    <div class="modal-body">
                        <form action="index.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="formulaireUsrApp" onsubmit="return false;">
                            <fieldset>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="title_user"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Civilité" : "Title") ?></label>
                                    <div class="col-md-8">
                                        <select data-placeholder="Choisissez la civilité..." class="select-chosen form-control" id="title_user" name="title_user" >
                                            <option value=""><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Choix" : "Choice") ?></option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mme"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Mme" : "Ms") ?></option>         
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user_name"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Nom / Prénom" : "Last / First name") ?></label>
                                    <div class="col-md-8">
                                        <input type="text" id="user_name" name="user_name" class="form-control" value="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" id="emailUsr" name="email" class="form-control" value="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Téléphone" : "Phone number") ?></label>
                                    <div class="col-md-8">
                                        <input type="text" id="tel" name="tel" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="tel2"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Portable" : "Cellphone") ?></label>
                                    <div class="col-md-8">
                                        <input type="text" id="tel2" name="tel2" class="form-control" value="">
                                    </div>
                                </div>
                                
                                <?php if ($arrAccess['isAdmin'] == '1') { ?>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="id_profil"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Profile" : "Profil") ?></label>
                                        <div class="col-md-8">
                                            <select data-placeholder="Choisissez le profile..." class="select-chosen form-control" id="id_profil" name="id_profil" >
                                                <?php
                                                    $profils = Profil::getAll();
                                                    if ($profils) {
                                                        foreach($profils as $profil) {
                                                            echo '<option value="'.$profil['id_profil'].'">'.$profil['name_profil'].'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                <?php } ?>
                            
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="psw"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Mot de passe" : "Password") ?></label>
                                    <div class="col-md-8">
                                    <input type="text" id="psw" name="psw" class="form-control">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <input type="hidden" id="id_usrApp" name="id_usrApp"  value="">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Quitter" : "Close") ?></button>
                                    <button type="submit" class="btn btn-sm btn-primary btvalideUsr"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Valider" : "Confirm") ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

        <div id="modal-display-recall" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-cli="" data-fourn="" data-common="">
            <div class="modal-dialog">
            <div class="modal-content">
                    
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-phone"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Rappel" : "Reminder") ?></h2>
                </div>
                    
                <div class="modal-body bg-primary">
                <div class="recinfcli" id="bginfcall" style="background-color: transparent !important;">
                    <div id="recallinfodt"></div>
                    <div id="recallinfocli1"></div>
                    <div id="recallinfocli2"></div>
                    <div id="recallinfocli3"></div>
                    <div id="recallinfocli4"></div>
                    <div id="recallinfoclimotif"></div>
                </div>
                <div class="text-center"  id="bgbtcall" style="background-color: transparent !important;">
                    <div class="btn-group">
                    <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Planifier" : "Schedule the callback") ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu text-left" id="lstremind">
                        <li><a href="javascript:void(0)" data-id="5"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dans" : "In") ?> 5 minutes</a></li>
                        <li><a href="javascript:void(0)" data-id="10"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dans" : "In") ?> 10 minutes</a></li>
                        <li><a href="javascript:void(0)" data-id="15"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dans" : "In") ?> 15 minutes</a></li>
                        <li><a href="javascript:void(0)" data-id="30"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dans" : "In") ?> 30 minutes</a></li>
                        <li><a href="javascript:void(0)" data-id="60"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dans" : "In") ?> 1 heure</a></li>
                        <li><a href="javascript:void(0)" data-id="120"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Dans" : "In") ?> 2 heures</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                    <a href="javascript:void(0)" data-id="0" id="lstvalidrec" class="btn btn-success"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Cloturer" : "Finish") ?> <span class=""></span></a>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    <?php }?>

    <?php if (strstr(basename($_SERVER['PHP_SELF']), '-rappels') || strstr(basename($_SERVER['PHP_SELF']), 'commandes')) { ?>
        <div id="modal-global-rappel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-calendar"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rappel' : 'Callback') ?></h2>
                    </div>
                    
                    <div class="modal-body">
                        <form onsubmit="return false;" class="form-horizontal" id="formulairerecallglobal" method="post" action="appajax.php">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="switch switch-primary">
                                    <input type="checkbox" id="commun" name="commun" <?php echo $curusr && $curusr->handicap > 0 ? 'checked="true"' : ''; ?>><span></span>
                                    </label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commun' : 'Common') ?>
                                </div>
                                <div class="col-md-4">
                                    <label class="switch switch-primary">
                                    <input type="checkbox" id="cli" name="cli" <?php echo $curusr && $curusr->handicap > 0 ? 'checked="true"' : ''; ?>><span></span>
                                    </label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client' : 'Customer') ?>
                                </div>
                                <div class="col-md-4">
                                    <label class="switch switch-primary">
                                    <input type="checkbox" id="fourn" name="fourn" <?php echo $curusr && $curusr->handicap > 0 ? 'checked="true"' : ''; ?>><span></span>
                                    </label> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Commande' : 'Order') ?>
                                </div>
                            </div>
                            <div id="selcli" class="form-group" style="display:none">
                                <label for="idfiche" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Client' : 'Customer') ?></label>
                                <div class="col-md-9">
                                    <select data-placeholder="Choisissez le client..." class="form-control select-chosen" id="idfiche" name="idfiche" <?php echo $arrAccess['isAdmin'] != '1' ? 'disabled="disabled"' : ''; ?>>
                                        <option value="0"></option>
                                        <?php
                                        $clits = Fiche::getAll();
                                        if ($clits) {
                                            foreach ($clits as $clit) {
                                            echo '<option value="' . $clit['id_fiche'] . '" >' . $clit['last_name'] .' '. $clit['first_name']  .'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="selfourn" class="form-group" style="display:none">
                                <label for="idfournisseur" class="col-md-3 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fournisseur' : 'Provider') ?></label>
                                <div class="col-md-9">
                                    <select data-placeholder="Choisissez le fournisseur..." class="form-control select-chosen" id="idfournisseur" name="idfournisseur" <?php echo $arrAccess['isAdmin'] != '1' ? 'disabled="disabled"' : ''; ?>>
                                        <option value="0"></option>
                                        <?php
                                        $fourns = Fournisseurs::getAll();
                                        if ($fourns) {
                                            foreach ($fourns as $fourn) {
                                            echo '<option value="' . $fourn['id_fournisseur'] . '" >' . $fourn['name_fournisseur']  .'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date_rappel" class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date du rappel' : 'Recall date') ?></label>
                                <div class="col-md-6">
                                    <input type="text" id="date_rappel" name="date_rappel" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="heure_rappel" class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Heure du rappel' : 'Reminder time') ?></label>
                                <div class="col-md-6">
                                    <div class="input-group bootstrap-timepicker">
                                        <input type="text" name="heure_rappel" id="heure_rappel" value="" class="form-control input-timepicker24" required>
                                        <span class="input-group-btn">
                                            <a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="msg_recall" class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Motif du rappel' : 'Reason of recall') ?></label>
                                <div class="col-md-6">
                                    <textarea name="msg_recall" id="msg_recall" class="form-control" rows="4" cols="50" required></textarea>
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-md-12 text-center">
                                    <input type="hidden" name="id_fiche" id="id_fiche" value="" />
                                    <input type="hidden" name="id_fournisseur" id="id_fournisseur" value="" />
                                    <input type="hidden" name="action" id="rappel" value="add-global-rappel" />
                                    <button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></button>
                                    <button class="btn btn-sm btn-primary" id="btrappel" type="submit"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    <?php }?>    

    <div id="modal-note-frais" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-receipt"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Détails des Notes de Frais' : 'Expense Report Details') ?></h2>
                </div>
                
                <div class="modal-body" style="height: 50vh">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="lg" class="col-md-2 control-label">
                                    <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Langage' : 'Language') ?>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" name="lgfrais" id="lgfrais">
                                        <option value="FR" <?php echo $curusr && $curusr->lg == 'FR' ? 'selected="selected"' : ''; ?>>FR</option>
                                        <option value="ENG" <?php echo $curusr && $curusr->lg == 'ENG' ? 'selected="selected"' : ''; ?>>ENG</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_frais" class="control-label">
                                        <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date de la Dépense' : 'Expense Date') ?>
                                    </label>
                                    <input type="text" style="background-color:#c1eaf7" class="form-control input-datepicker" 
                                        data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_frais" id="date_frais" 
                                        value="<?php echo $curusr->date_frais > 0 ? date('d/m/Y', strtotime($curusr->date_frais)) : date('d/m/Y', strtotime(date('Y-m-d'))); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Catégorie' : 'Category') ?>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" name="catfrais" id="catfrais">
                                        <option value="">Sélectionnez une catégorie</option>
                                        <option value="Transport">Transport</option>
                                        <option value="Repas">Repas</option>
                                        <option value="Hébergement">Hébergement</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                                <label class="col-md-2 control-label">
                                    <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Montant' : 'Amount') ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="number" step="0.01" class="form-control" id="mtfrais" name="mtfrais" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Justificatif' : 'Receipt') ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="file" class="form-control" id="justificatif" name="justificatif" />
                                </div>
                                <label class="col-md-2 control-label">
                                    <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Description' : 'Description') ?>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="descfrais" id="descfrais" cols='30' rows='3'></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><hr>
                    <div class="row">
                        <div class="form-group form-actions text-center">
                            <button href="#" class="btn btn-sm btn-default" data-dismiss="modal">
                                <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?>
                            </button>
                            <button class="btn btn-sm btn-primary" id="btokfrais" type="button">
                                <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?>
                            </button>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

    </body>
    
</html>


        <!-- ETAIT DANS MAINMENU.PHP -->
<script>
    //  <!-- ETAIT DANS MAINMENU.PHP -->
    $(document).ready(function(){
        $('#formulaireUsrApp').submit(function() {
            console.log('frmusr');
        HoldOn.open();
        $.post('appajax.php', {
                action:'update-UsrApp', 
                data:$('#formulaireUsrApp').serialize(), 
            }, 
            function(resp) {
            HoldOn.close();
            if (resp.responseAjax == 'SUCCESS') {
            // alert(resp.message);
            
                $('#list_UsrApps').trigger("reloadGrid",[{current:true}]);
                $('#modal-UsrApp').modal('hide');
            }
            else{
                    // alert(resp.message)
                }
            ;
        }, 'json');		
        
        return false;
        });
    })
    // <!-- ETAIT DANS MAINMENU.PHP -->
</script>