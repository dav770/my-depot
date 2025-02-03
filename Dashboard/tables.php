<?php

include 'including/config.php'; ?>


<?php
   $tb = 0;
   
?>
<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/menu.css">

<style>
    @media screen and (max-width:600px) {
        .clinptb{
            width: 100px;
        }
    }

    @media screen and (orientation: landscape) {
        .climg {
            max-width: 20%
        }
    }

    @media screen and (orientation: portrait) {
        .climg {
            max-width: 20%
        }
    }
</style>


    
<div id="page-content" class="page-dashboard"> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

    <h2>Tables </h2><button class="btn btn-info" id="btprint"><i class="fa fa-print"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Imprimer' : 'Print') ?></button>
  
    <div id="dataDivID" class="form-container">
        <div class="block-full">
            <?php for ($i=0; $i < 7; $i++) { 
                    $tb++;
                    echo '<div class="row" style="text-align:center">
                
                    <div class="col-md-3 cltb" style="height:220px; border:1px solid black" id="divtb'.$tb.'" name="divtb'.$tb.'">
                        <img class="climg" src="'.$template['public_url'].'/img/table.png" alt="table_'.$tb.'" data-id="'.$tb.'" id="t'.$tb.'" name="t'.$tb.'" style="max-width: 50%"/>
                        <span id="sp'.$tb.'" style="color:black">TABLE N° '.$tb.'</span>
                        <div id="inptb'.$tb.'" style="display: none;">
                            <div>
                                <input type="text" value="" class="clinptb" id="name-1-'.$tb.'" name="name-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-1-'.$tb.'" name="nb-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-1-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-2-'.$tb.'" name="name-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-2-'.$tb.'" name="nb-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-2-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-3-'.$tb.'" name="name-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-3-'.$tb.'" name="nb-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-3-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <a href="#" id="bloctb'.$tb.'" data-id="'.$tb.'" class="btn btn-success clbloctb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Reserver' : 'Reserve').'</a>
                                <a href="#" id="resettb'.$tb.'" data-id="'.$tb.'" class="btn btn-danger clresettb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel').'</a>
                            </div>
                            <div id="freemod'.$tb.'" style="display:none">
                                <a href="#" id="freetb'.$tb.'" data-id="'.$tb.'" class="btn btn-warning clfreetb " >'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libérer' : 'Reset').'</a>
                                <a href="#" id="modtb'.$tb.'" data-id="'.$tb.'" class="btn btn-primary clmodtb " >'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifier' : 'To modify').'</a>
                            </div>
                        </div>
                    </div>';
                    $tb++;
                    echo '<div class="col-md-3 cltb" style="height:220px; border:1px solid black" id="divtb'.$tb.'" name="divtb'.$tb.'">
                        <img class="climg" src="'.$template['public_url'].'/img/table.png" alt="table_'.$tb.'" data-id="'.$tb.'" id="t'.$tb.'" name="t'.$tb.'" style="max-width: 50%;"/>
                        <span id="sp'.$tb.'" style="color:black">TABLE N° '.$tb.'</span>
                        <div id="inptb'.$tb.'" style="display: none;">
                            <div>
                                <input type="text" value="" class="clinptb" id="name-1-'.$tb.'" name="name-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-1-'.$tb.'" name="nb-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-1-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-2-'.$tb.'" name="name-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-2-'.$tb.'" name="nb-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-2-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-3-'.$tb.'" name="name-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-3-'.$tb.'" name="nb-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-3-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <a href="#" id="bloctb'.$tb.'" data-id="'.$tb.'" class="btn btn-success clbloctb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Reserver' : 'Reserve').'</a>
                                <a href="#" id="resettb'.$tb.'" data-id="'.$tb.'" class="btn btn-danger clresettb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel').'</a>
                            </div>
                            <div id="freemod'.$tb.'" style="display:none">
                                <a href="#" id="freetb'.$tb.'" data-id="'.$tb.'" class="btn btn-warning clfreetb ">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libérer' : 'Reset').'</a>
                                <a href="#" id="modtb'.$tb.'" data-id="'.$tb.'" class="btn btn-primary clmodtb ">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifier' : 'To modify').'</a>
                            </div>
                        </div>
                    </div>';
                    $tb++;
                    echo '<div class="col-md-3 cltb" style="height:220px; border:1px solid black" id="divtb'.$tb.'" name="divtb'.$tb.'">
                        <img class="climg" src="'.$template['public_url'].'/img/table.png" alt="table_'.$tb.'" data-id="'.$tb.'" id="t'.$tb.'" name="t'.$tb.'" style="max-width: 50%;"/>
                        <span id="sp'.$tb.'" style="color:black">TABLE N° '.$tb.'</span>
                        <div id="inptb'.$tb.'" style="display: none;">
                            <div>
                                <input type="text" value="" class="clinptb" id="name-1-'.$tb.'" name="name-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-1-'.$tb.'" name="nb-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-1-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-2-'.$tb.'" name="name-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-2-'.$tb.'" name="nb-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-2-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-3-'.$tb.'" name="name-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-3-'.$tb.'" name="nb-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-3-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <a href="#" id="bloctb'.$tb.'" data-id="'.$tb.'" class="btn btn-success clbloctb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Reserver' : 'Reserve').'</a>
                                <a href="#" id="resettb'.$tb.'" data-id="'.$tb.'" class="btn btn-danger clresettb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel').'</a>
                            </div>
                            <div id="freemod'.$tb.'" style="display:none">
                                <a href="#" id="freetb'.$tb.'" data-id="'.$tb.'" class="btn btn-warning clfreetb ">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libérer' : 'Reset').'</a>
                                <a href="#" id="modtb'.$tb.'" data-id="'.$tb.'" class="btn btn-primary clmodtb ">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifier' : 'To modify').'</a>
                            </div>
                        </div>
                    </div>';
                    $tb++;
                    echo '<div class="col-md-3 cltb" style="height:220px; border:1px solid black" id="divtb'.$tb.'" name="divtb'.$tb.'">
                        <img class="climg" src="'.$template['public_url'].'/img/table.png" alt="table_'.$tb.'" data-id="'.$tb.'" id="t'.$tb.'" name="t'.$tb.'" style="max-width: 50%;"/>
                        <span id="sp'.$tb.'" style="color:black">TABLE N° '.$tb.'</span>
                        <div id="inptb'.$tb.'" style="display: none;">
                            <div>
                                <input type="text" value="" class="clinptb" id="name-1-'.$tb.'" name="name-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-1-'.$tb.'" name="nb-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-1-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-2-'.$tb.'" name="name-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-2-'.$tb.'" name="nb-2-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-2-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <input type="text" value="" class="clinptb" id="name-3-'.$tb.'" name="name-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name').'">
                                <input type="text" value="" class="clinptb" id="nb-3-'.$tb.'" name="nb-3-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people').'">
                                <input type="text" value="" class="clinptb" id="ch-3-'.$tb.'" name="ch-1-'.$tb.'" style="margin-bottom:2px; border: none" placeholder="'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room').'">
                            </div>
                            <div>
                                <a href="#" id="bloctb'.$tb.'" data-id="'.$tb.'" class="btn btn-success clbloctb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Reserver' : 'Reserve').'</a>
                                <a href="#" id="resettb'.$tb.'" data-id="'.$tb.'" class="btn btn-danger clresettb">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Annuler' : 'Cancel').'</a>
                            </div>
                            <div id="freemod'.$tb.'" style="display:none">
                                <a href="#" id="freetb'.$tb.'" data-id="'.$tb.'" class="btn btn-warning clfreetb ">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Libérer' : 'Reset').'</a>
                                <a href="#" id="modtb'.$tb.'" data-id="'.$tb.'" class="btn btn-primary clmodtb ">'.($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifier' : 'To modify').'</a>
                            </div>
                        </div>
                    </div>';
                    
                    echo '
                </div>';
                }
            ?>
        </div>
        
        

        <div id="modal-mail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-envelope-o"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Envoi Email' : 'Send email') ?></h2>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return false;" class="" id="formulairemsgdoc" method="post" action="appajax.php">
                                
                            <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Destinataire(s)' : 'Recipient(s)') ?></label>
                            <div class="form-group">
                                <div class="col-md-8">
                                    <input type="text" class="form-control"  value="" id="destemail" />
                                </div>
                            </div>

                            <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Sujet' : 'Subject') ?></label>
                            <div class="form-group">	
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control"  value="" id="subjectmail" placeholder="sujet" />
                                        <div class="input-group-btn" data-toggle="tooltip" title="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Message type' : 'Load a standard message') ?>">
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

                            <label class="col-md-4 control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Pieces jointes' : 'Attachments') ?></label>
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
                                    <button href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fermer' : 'Close') ?></button>
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
    </div>
</div>


<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>


<script>
	$(document).ready(function() {

        function initFields(){
            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'read-table',
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {

                    if(resp.lgn > 0){
                        let arrTb = JSON.parse(resp.data);
                        console.log(arrTb.length)
                        for (index = 0; index < arrTb.length; index++) {
                            console.log(arrTb[index].numT)
                            $('#name-1-'+arrTb[index].numT).val(arrTb[index].n1)
                            $('#nb-1-'+arrTb[index].numT).val(arrTb[index].nb1)
                            $('#ch-1-'+arrTb[index].numT).val(arrTb[index].ch1)
                            $('#name-2-'+arrTb[index].numT).val(arrTb[index].n2)
                            $('#nb-2-'+arrTb[index].numT).val(arrTb[index].nb2)
                            $('#ch-2-'+arrTb[index].numT).val(arrTb[index].ch2)
                            $('#name-3-'+arrTb[index].numT).val(arrTb[index].n3)    
                            $('#nb-3-'+arrTb[index].numT).val(arrTb[index].nb3)
                            $('#ch-3-'+arrTb[index].numT).val(arrTb[index].ch3)

                            
                            let numtb = arrTb[index].numT
                            $('#divtb'+numtb).css('background-color','beige')
                            $('#sp'+numtb).css('color','red')
                            // $('#bloctb'+numtb).show()
                            // $('#resettb'+numtb).show()
                            // $('#freetb'+numtb).hide()
                            $('#t'+numtb).attr('src','<?php echo $template['public_url']?>'+'/img/plaque.png')
                            $('#inptb'+numtb).css('display','block')
                            $('#bloctb'+numtb).hide()
                            $('#resettb'+numtb).hide()
                            $('#freemod'+numtb).show()
                        }
                    }
                    
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
            
        }
        initFields()

        $('#btprint').click(function(){
            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'print-table',
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
					typeDocSign = 'du plan des tables   ';


					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();
                    $.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
                        type: 'success',
                        delay: 2000,
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

        var options = {
            theme:"sk-cube-grid",
            message: '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Chargement des données en cours ....' : 'Loading data ....') ?>',
            backgroundColor:"#1847B1",
            textColor:"white"
        };

        var nameDocSign = '';
		var typeDocSign = '';

		function getNameDoc(name){
			
			nameDocSign = name;
			nameDocSign = nameDocSign.substr(nameDocSign.lastIndexOf('/')+1);
			nameDocSign = nameDocSign.substr(0,nameDocSign.indexOf('pdf')-1);
		}

        $(document).on('click','.clinptb',function(){
            let idinptb = $(this).attr('id')
            $('#'+idinptb).attr('placeholder', '')
            return false;
        })

        var name1 = '';
        var name2 = '';
        var name3 = '';
        var nb1 = '';
        var nb2 = '';
        var nb3 = '';
        var ch1 = '';
        var ch2 = '';
        var ch3 = '';

        $(document).on('blur','.clinptb',function(){
            let idinptb = $(this).attr('id')
            console.log('name : ',idinptb)
            if($('#'+idinptb).val() == ''){
                if(idinptb.substring(0,2) == 'na'){
                    $('#'+idinptb).attr('placeholder', <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name') ?>)
                }
                if(idinptb.substring(0,2) == 'nb'){
                    $('#'+idinptb).attr('placeholder', '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne' : 'Number of people') ?>')
                }
                if(idinptb.substring(0,2) == 'ch'){
                    $('#'+idinptb).attr('placeholder', '<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° de chambre' : 'N° room') ?>')
                }
            }
            
            return false;
        })

        $(document).on('click','.cltb',function(){
            let idtb = $(this).attr('id')
            let imgtb = $(this).children().attr('id')
            let numtb = $(this).children().attr('data-id')
            $('#bloctb'+numtb).show()
            $('#resettb'+numtb).show()
            $('#freemod'+numtb).hide()
            $('#'+imgtb).attr('src','<?php echo $template['public_url']?>'+'/img/plaque.png')
            $('#inptb'+numtb).css('display','block')
            
            $('#divtb'+numtb).css('background-color','beige')
            $('#sp'+numtb).css('color','red')
            
            return false;
           
        })

        $(document).on('click','.clbloctb',function(){
           
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmer votre choix' : 'Confirm your choice') ?>')){
                return false;
            }
            let idbt = $(this).attr('data-id')

            name1 = $('#name-1-'+idbt).val()
            name2 = $('#name-2-'+idbt).val()
            name3 = $('#name-3-'+idbt).val()

            nb1 = $('#nb-1-'+idbt).val()
            nb2 = $('#nb-2-'+idbt).val()
            nb3 = $('#nb-3-'+idbt).val()

            ch1 = $('#ch-1-'+idbt).val()
            ch2 = $('#ch-2-'+idbt).val()
            ch3 = $('#ch-3-'+idbt).val()

            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'bloc-table',
                idtable: idbt,
                name1: name1,
                name2: name2,
                name3: name3,
                nb1: nb1,
                nb2: nb2,
                nb3: nb3,
                ch1: ch1,
                ch2: ch2,
                ch3: ch3,
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    console.log('ici',idbt)
                    $('#bloctb'+idbt).hide()
                    $('#resettb'+idbt).hide()
                    $('#freemod'+idbt).show()

                    $.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
                        type: 'success',
                        delay: 2000,
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

        $(document).on('click','.clresettb',function(){
           
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmer votre choix' : 'Confirm your choice') ?>')){
                return false;
            }
            let idbt = $(this).attr('data-id')
            console.log('ici',idbt)
            $('#t'+idbt).attr('src','<?php echo $template['public_url']?>'+'/img/table.png')
            $('#inptb'+idbt).css('display','none')
            
            $('#divtb'+idbt).css('background-color','transparent')
            $('#sp'+idbt).css('color','black')
            return false;
        })

        $(document).on('click','.clfreetb',function(){
           
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmer votre choix' : 'Confirm your choice') ?>')){
                return false;
            }
            let idbt = $(this).attr('data-id')
            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'free-table',
                idtable: idbt,                
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    $('#name-1-'+idbt).val('')
                    $('#name-2-'+idbt).val('')
                    $('#name-3-'+idbt).val('')

                    $('#nb-1-'+idbt).val('')
                    $('#nb-2-'+idbt).val('')
                    $('#nb-3-'+idbt).val('')

                    $('#ch-1-'+idbt).val('')
                    $('#ch-2-'+idbt).val('')
                    $('#ch-3-'+idbt).val('')

                    $('#t'+idbt).attr('src','<?php echo $template['public_url']?>'+'/img/table.png')
                    $('#inptb'+idbt).css('display','none')

                    $('#divtb'+idbt).css('background-color','transparent')
                    $('#sp'+idbt).css('color','black')

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

        $(document).on('click','.clmodtb',function(){
           
            if(!confirm('<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmer votre choix' : 'Confirm your choice') ?>')){
                return false;
            }
            let idbt = $(this).attr('data-id')
            name1 = $('#name-1-'+idbt).val()
            name2 = $('#name-2-'+idbt).val()
            name3 = $('#name-3-'+idbt).val()

            nb1 = $('#nb-1-'+idbt).val()
            nb2 = $('#nb-2-'+idbt).val()
            nb3 = $('#nb-3-'+idbt).val()

            ch1 = $('#ch-1-'+idbt).val()
            ch2 = $('#ch-2-'+idbt).val()
            ch3 = $('#ch-3-'+idbt).val()

            HoldOn.open(options);
            $.post('appajax.php', {
                action: 'mod-table',
                idtable: idbt,      
                name1: name1,
                name2: name2,
                name3: name3,
                nb1: nb1,
                nb2: nb2,
                nb3: nb3,
                ch1: ch1,
                ch2: ch2,
                ch3: ch3,          
            }, function(resp) {
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    
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
    })
</script>