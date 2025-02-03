<?php include __DIR__.'/inc/_global/config.php'; ?>
<?php include __DIR__.'/inc/backend/config.php'; ?>
<?php include __DIR__.'/inc/_global/views/head_start.php'; ?>
<?php include __DIR__.'/inc/_global/views/head_end.php'; ?>
<?php include __DIR__.'/inc/_global/views/page_start.php'; ?>

<?php
    require_once __DIR__ . '/including/dbclass.php';

    $contact = false;
    
    if (isset($_GET['key'])) {
        $codekey = substr($_GET['key'], 0, 8);
        $idct =  substr($_GET['key'], 8);
        $contact = Contact::findOne(array('c.id_contact' => $idct, 'c.codekey ' => $codekey));

    }
    
    $dir = IsoPDFBuilder::checkDir($contact->codekey . $contact->id_contact);
	

    $htmldetails ='';
    $nbclic = 0;

    $alldetails = Contact::getAllDetails(array('id_contact'=>$ct->id_contact));
    foreach($alldetails as $details){
        $sumTarif += $details['tarif_details'];
        $sumTarif += $details['tarif_transport'];
        $sumTarif += $details['tarif_supp_detail'];

        $nbclic++;

        $htmldetails .= '
            <tr id="tr'.$nbclic.'">
                <td>
                    <input style="border:none" type="text" name="iddet'.$nbclic.'" id="iddet'.$nbclic.'" value="'.$details['id_contact_detail'].'" readonly/>
                </td>
                <td>
                    <input style="border:none" type="text" name="addnom'.$nbclic.'" id="addnom'.$nbclic.'" value="'.$details['last_name_detail'].'" />
                </td>
                <td>
                    <input style="border:none" type="text" name="addprenom'.$nbclic.'" id="addprenom'.$nbclic.'" value="'.$details['first_name_detail'].'" />
                </td>
                <td>
                    <input style="border:none" type="date" name="adddate'.$nbclic.'" id="adddate'.$nbclic.'" value="'.$details['date_naissance_detail'].'" />
                </td>
                <td>
                    <input type="text" class="form-control" name="addpasseport'.$nbclic.'" id="addpasseport'.$nbclic.'" value="" >
                </td>
            </tr>
        ';
    };
?>  

<style type="text/css" media="screen,print">      
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

<!-- Hero Content -->
<!-- END Hero Content -->

<!-- Page Content -->
<div class="">
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <?php
                        if (file_exists($logo)) {
                            echo '<img src="'.$logo.'" style="width:200px" />';
                        }    
                    ?> 
                    
                </div>
                <!-- Article Content -->
                <div class="cForm" style="display:flex">
                    <form onsubmit="return false;" class="form-horizontal" method="post" action="pubajax.php" id="formulairecontrat">
                        <div style="line-height:20px;border:3px solid #e8cc81; background-color:white;color:black;padding-left:7px">
                            <div style="text-align:center">
                                <h2>DEVIS MH PALACE</h2>
                                <span style="font-size:20px;;vertical-align: middle;">Devis numero : <b><?php echo 'D_'.date('Y').'_'.str_pad($nodevis,5,0,STR_PAD_LEFT) ?></b></span>
                            </div>
                            <p>
                                Veuillez renseigner l'ensemble des informations manquantes et confirmer pour procéder a la mise à jour de votre fiche client
                            </p>
                            <div class="form-group">
                                <label for="last_name" class="col-md-3 control-label">Nom client<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez le nom..." class="form-control" name="last_name" id="last_name" value="<?php echo strtoupper($ct->last_name); ?>" required  readonly='readonly' >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="first_name" class="col-md-3 control-label">Prénom client<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez le nom..." class="form-control" name="first_name" id="first_name" value="<?php echo strtoupper($ct->first_name); ?>" required readonly='readonly' >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tel1" class="col-md-3 control-label">Téléphone principal<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez le nom..." class="form-control" name="tel1" id="tel1" value="<?php echo strtoupper($ct->tel1); ?>" required readonly='readonly' >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tel2" class="col-md-3 control-label">Téléphone secondaire</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez le nom..." class="form-control" name="tel2" id="tel2" value="<?php echo strtoupper($ct->tel2); ?>" >
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="tel2" class="col-md-3 control-label">Num. Passeport</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez le num. passeport." class="form-control" name="numpassport" id="numpassport" value="<?php echo strtoupper($ct->num_passport); ?>" >
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="adr1" class="col-md-3 control-label">Adresse client<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="adr1" id="adr1" value="<?php echo strtoupper($ct->adr1); ?>" required readonly='readonly' >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="post_code" class="col-md-3 control-label">Code postal<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="post_code" id="post_code" value="<?php echo strtoupper($ct->post_code); ?>" required readonly='readonly' >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-md-3 control-label">Ville<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="city" id="city" value="<?php echo strtoupper($ct->city); ?>" required readonly='readonly' >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-3 control-label">Email<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="email" id="email" value="<?php echo strtoupper($ct->email); ?>" required readonly='readonly' >
                                </div>
                            </div>

                            <!-- <a href="#"  style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;width: 98px;" class="form-control btn btn-sm btn-success btaddct" id="btaddct">Ajoutez Infos</a> -->
                            <div class="form-group">
                                <table width="100%" class="center" id="addct">
                                    <tr>
                                        <td width="10%">
                                            ID
                                        </td>
                                        <td>
                                            Nom
                                        </td>
                                        <td>
                                            Prénom
                                        </td>
                                        <td>
                                            Date de naissance
                                        </td>
                                        <td>
                                            N° passeport
                                        </td>
                                        <!-- <td>
                                            Action
                                        </td> -->
                                    </tr>
                                    <?php echo  $htmldetails ?>
                                </table>
                            </div>

                            <div class="form-group form-actions">
                                <input type="hidden" name="action" id="action" value="sign-contrat" />
                                <input type="hidden" name="idct" id="idct" value="<?php echo $ct->id_contact ?>" />
                                <input type="hidden" name="codekey" id="codekey" value="<?php echo $ct->codekey ?>" />
                                <button class="btn btn-sm btn-primary" type="submit" id="btupdatecontrat"><i class="fa fa-user"></i> Valider</button>
                                <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Annuler</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Modal PDF BAR EN -->
                <div id="modal-baren" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="text-right display-none" id="blksigndoc" style="padding:15px 15px 0;">
                                <a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> Signer le document</a>
                            </div>
                            <div class="modal-body" style="height: 80vh">
                                <iframe src="" style="width:100%;height:100%;"></iframe>
                                <input type="hidden" id="view_id_docs" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include __DIR__.'/inc/_global/views/page_end.php'; ?>
<?php include __DIR__.'/inc/_global/views/footer_start.php'; ?>
<?php include __DIR__.'/inc/_global/views/footer_end.php'; ?>
<script src='assets/signature_pad.min.js'></script>
<script src='assets/js/lib/jquery.min.js'></script>
<script src='assets/HoldOn.min.js'></script>

<script src="assets/js/oneui.app.min.js"></script>

    <!-- jQuery (required for Bootstrap Notify plugin) -->
    <script src="assets/js/lib/jquery.min.js"></script>

    <!-- Page JS Plugins -->
    <script src="assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>

<script>
	
	$(document).ready(function() {

    $('#page-header').css('display','none')
    $('#page-footer').css('display','none')

    $(document).on('submit', '#formulairecontrat', function() {

        HoldOn.open();
        jQuery(this).ajaxSubmit({
            dataType : 'json',
            data:{
                idct:$('#idct').val(), 
                codekey:$('#codekey').val(), 
                nbclic: <?php echo $nbclic?>
                },

            success: function(resp) {
            
                HoldOn.close();
                if (resp.responseAjax == 'SUCCESS') {
                    HoldOn.open();
                    
                    $.post('pubajax.php', {action:'sign-doc-public', idd: resp.idd, idct: resp.idct, nameDoc: resp.namedoc, typeDoc: resp.typedoc}, function(resp) {
                            HoldOn.close();
                            if (resp.responseAjax == 'SUCCESS') {
                                One.helpers('jq-notify', {type: 'danger', icon: 'fa fa-check me-1', message: resp.message});
                            } else
                                One.helpers('jq-notify', {type: 'danger', icon: 'fa fa-times me-1', message: resp.message});
                        }, 'json');
                    
                    return false;

                } else {
                    One.helpers('jq-notify', {type: 'danger', icon: 'fa fa-times me-1', message: resp.message});
                }
            },
            error: function() {
                console.log('NO');
                HoldOn.close();
            }
        });

        return false;   
        });
  })
</script>