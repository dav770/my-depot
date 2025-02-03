<?php

include 'including/config.php'; ?>


<?php
   $tb = 0;
   
?>
<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/menu.css">

<style>
    #page-content{
        min-height:1500px !important
    }

    .tmpbtn {
        display:none;
    }

    .mydiv {
    position: absolute;
    z-index: 9;
    background-color: #f1f1f1;
    text-align: center;
    border-radius: 10%;
    border: 1px solid #d3d3d3;
    }

    .mydivheader {
    padding: 10px;
    cursor: move;
    z-index: 10;
    background-color: #2196F3;
    color: #fff;
    border-radius: 10%;
    /* background-image: url('img/azuro-black.png'); */
    }

    .myobj {
    padding: 10px;
    cursor: move;
    z-index: 10;
    background-color: #2196F3;
    color: #fff;
    border-radius: 10%;
    /* background-image: url('img/azuro-black.png'); */
    }


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


    
<div id="page-content" class="page-dashboard" > 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>
    <div class="row" style="display:flex">
        <label><span style="margin-left:20px">legende des couleurs de tables</span> </label>
        <div data-color="#574e34" class="clfiltre" style="border:solid 1px black;padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #574e34; color:#FFF"><span style="margin-left:8.5px;"><b>1</b></span></div>
        <div data-color="#2196F3" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #2196F3"><span style="margin-left:8.5px;"><b>2</b></span></div>
        <div data-color="#9c7211" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #9c7211"><span style="margin-left:8.5px;"><b>3</b></span></div>
        <div data-color="#eaf551" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #eaf551"><span style="margin-left:8.5px;"><b>4</b></span></div>
        <div data-color="#b3f556" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #b3f556"><span style="margin-left:8.5px;"><b>5</b></span></div>
        <div data-color="#38823c" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #38823c; color:#FFF"><span style="margin-left:8.5px;"><b>6</b></span></div>
        <div data-color="#57bdb6" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #57bdb6"><span style="margin-left:8.5px;"><b>7</b></span></div>
        <div data-color="#4c4eb5" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #4c4eb5; color:#FFF"><span style="margin-left:8.5px;"><b>8</b></span></div>
        <div data-color="#bd47bf" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #bd47bf"><span style="margin-left:8.5px;"><b>9</b></span></div>
        <div data-color="#e81737" class="clfiltre" style="padding-top: 4px; width: 30px;height: 30px;margin: 7px;border-radius: 50px;background: #e81737"><span style="margin-left:2.5px;"><b>10+</b></span></div>
    </div>
    <h2>Tables </h2>
    <div style="margin-bottom:15px; ">
        <button class="btn btn-info" id="btadd" <?php echo ($arrAccess["add_table"] == 1 ? '' : 'disabled="disabled"') ?>><i class="fa fa-pencil"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout table' : 'Add table') ?></button>
        <select class="btn btn-info" id="btaddobj" <?php echo ($arrAccess["add_obj_table"] == 1 ? '' : 'disabled="disabled"') ?>>
            <option value=""><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Ajout objet' : 'Add object') ?></option>
            <option value="W"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fenêtre' : 'Window') ?></option>
            <option value="C"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Colonne' : 'Column') ?></option>
            <option value="P"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Porte' : 'Dor') ?></option>
            <option value="E"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Entrée' : 'Entry') ?></option>
            <option value="S"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Escaliers' : 'Stairs') ?></option>
            <option value="CT"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Comptoir' : 'Counter') ?></option>
            <option value="CH"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Cheminée' : 'Fireplace') ?></option>
            <option value="EX"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Extèrieure' : 'exterior') ?></option>
            <option value="M"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Mur' : 'Wall') ?></option>
            <option value="R"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Rideau' : 'Curtain') ?></option>
            <option value="F"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Plante' : 'Flower') ?></option>
        </select>
        <button class="btn btn-info" id="btprint" style="margin-left:50px"><i class="fa fa-print"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Imprimer' : 'Print') ?></button>
        

    </div>
   

    <div class="form-container" style="overflow: auto;">
        <div class="row" >
            <div style="/*background-color:blue*/" class="col-md-2" id="contdiv">
                <!-- <div style="width:100px" id="mydiv" class="mydiv">
                    <div id="mydivheader" class="mydivheader">Click here to move</div>
                    <p>Move</p>
                    <p>this</p>
                    <p>DIV</p>
                </div>-->
            </div> 
            <div class="col-md-10" id="contdiv2" style="overflow: auto;background-color: #8a8c84;height: 1300px;">
                
            </div>
        </div>
    </div>

    <div id="modal-modif" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header text-center">
					<h2 class="modal-title"><i class="fa fa-pencil"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifications' : 'Modifications') ?></h2>
				</div>
				
				<div class="modal-body">
					<form action="appajax.php" method="post" class="form-horizontal" id="formulairetable" onsubmit="return false;">
						<fieldset>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <label class="control-label" for="name_table"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom table' : 'Name table') ?></label>
                                    <select id="name_table" name="name_table" class="form-control">
                                        <option value="0"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name') ?></option>
                                        <?php
                                            $clts = Fiche::getAll(array('id_organisateur'=>$usrActif->cursoc));
                                            if ($clts) {
                                                foreach($clts as $clt) {
                                                    echo '<option value="'.$clt['id_fiche'].'">'.$clt['last_name'].' '.$clt['first_name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
							<div class="form-group">
                                <div class="col-md-3">
                                    <label class="control-label" for="num_table"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° table' : 'N° table') ?></label>
									<input type="text" id="num_table" name="num_table" class="form-control" value=""></input>
								</div>
                                <div class="col-md-3">
                                    <label class="control-label" for="etage"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etage' : 'Floor') ?></label>
									<input type="text" id="etage" name="etage" class="form-control" value=""></input>
								</div>
                                <div class="col-md-3">
                                    <label class="control-label" for="capacite"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Capacite' : 'Capacity') ?></label>
									<input type="text" id="capacite" name="capacite" class="form-control" value=""></input>
								</div>
							</div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="date_start" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date arrivée' : 'Date start') ?> </label>
                                    <input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_start" id="date_start" value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="date_end" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Date départ' : 'Date end') ?> </label>
                                    <input type="text" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="date_end" id="date_end" value="">
                                </div>
							</div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="nb_adulte" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Adulte' : 'Adult') ?> </label>
                                    <input type="text" class="form-control" name="nb_adulte" id="nb_adulte" value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="nb_enfant" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Enfant' : 'Child') ?> </label>
                                    <input type="text" class="form-control" name="nb_enfant" id="nb_enfant" value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="nb_bb" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Bébé' : 'Baby') ?> </label>
                                    <input type="text" class="form-control" name="nb_bb" id="nb_bb" value="">
                                </div>
							</div>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <label for="note" class="control-label"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Note' : 'Note') ?> </label>
                                    <input type="text" class="form-control" name="note" id="note" value="">
                                </div>
							</div>
							<div class="form-group form-actions">
								<div class="col-xs-9 text-right">
									<input type="hidden" name="iddiv" id="iddivupt" value="0" />
									<input type="hidden" name="action" id="action" value="update-modal" />
									<a href="#" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Quitter' : 'Close') ?></a>
									<button type="submit" href="#" class="btn btn-sm btn-primary" id="btupdatetable"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Valider' : 'Confirm') ?></button>
								</div>
							</div>
						</fieldset>
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


<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>


<script>
    $(document).ready(function() {
        
        var iddiv = 0;
        var idobj = 0;
        var posL = 0;
        var posT = 0;
        var authAdd = 0;
        var authAddObj = 0;
        var confDelDrag = 0;
        var obj = '';

        $('#btprint').click(function(){
            HoldOn.open();
            $.post('appajax.php', {action: 'print-plan-table',}, function(resp) {
                if (resp.responseAjax == 'SUCCESS') {
                    if (resp.cansign == '1')
						$('#blksigndoc').removeClass('display-none');
					else
						$('#blksigndoc').addClass('display-none');

					if (resp.id_doc > 0)
						$('#view_id_docs').val(resp.iddoc);
					else
						$('#view_id_docs').val('');
					$('#modal-pdf iframe').attr('src', resp.doc);
					$('#modal-pdf').modal();
                }
                else{
                    alert(resp.message);
                }
                
                HoldOn.close();

            }, 'json');
            
            return false;
        })

        displayElmt();
        displayElmtObj();

        function displayElmt(){
            HoldOn.open();
            $.post('appajax.php', {action: 'display-table',}, function(resp) {
                if (resp.responseAjax == 'SUCCESS') {
                    resp.data.forEach(function(d){
                        // console.log(d.posL)
                        // let bkg = '#2196F3';
                        // if(d.etage < 0){
                        //     bkg = 'green';
                        // }
                        // if(d.etage == 0){
                        //     bkg = '#2196F3';
                        // }
                        // if(d.etage == 1){
                        //     bkg = '#2155E0';
                        // }
                        // if(d.etage == 2){
                        //     bkg = '#0085E0';
                        // }

                        let bkg = '#2196F3';

                        if(d.capacite == 1){
                            bkg = '#574e34';
                        }
                        if(d.capacite == 2){
                            bkg = '#2196F3';
                        }
                        if(d.capacite == 3){
                            bkg = '#9c7211';
                        }
                        if(d.capacite == 4){
                            bkg = '#eaf551';
                        }
                        if(d.capacite == 5){
                            bkg = '#b3f556';
                        }
                        if(d.capacite == 6){
                            bkg = '#38823c';
                        }
                        if(d.capacite == 7){
                            bkg = '#57bdb6';
                        }
                        if(d.capacite == 8){
                            bkg = '#4c4eb5';
                        }
                        if(d.capacite == 9){
                            bkg = '#bd47bf';
                        }
                        if(d.capacite == 10){
                            bkg = '#e81737';
                        }

                        let obj = '';
                        // obj = '<div style="width:130px; top:'+d.posT+'px; left:'+d.posL+'px; z-index:1" id="mydiv'+d.num_div+'" class="mydiv"><div style="height:75px; background-color:'+bkg+' !important" id="mydivheader'+d.num_div+'" class="mydivheader"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Déplacer ici' : 'Move here') ?><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="del" id="a'+d.num_div+'" class="btn-xs btn-danger bt-del">X</a><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="dspl" id="d'+d.num_div+'" class="btn-xs btn-info bt-dspl">...</a><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="mod" id="md'+d.num_div+'" class="btn-xs btn-warning bt-mod"><i id="up'+d.num_div+'" class="fa fa-pencil"></i></a><span style="font-weight:bold" id="numtb'+d.num_div+'"> Table : '+d.num_table+'</span>';
                        obj = '<div style="width:130px; top:'+d.posT+'px; left:'+d.posL+'px; z-index:1" id="mydiv'+d.num_div+'" class="mydiv"><div style="height:75px; background-color:'+bkg+' !important" id="mydivheader'+d.num_div+'" class="mydivheader"><i id="mydivspan'+d.num_div+'" class="fa fa-arrows" aria-hidden="true"></i><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="del" id="a'+d.num_div+'" class="btn-xs btn-danger bt-del">X</a><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="dspl" id="d'+d.num_div+'" class="btn-xs btn-info bt-dspl">...</a><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="mod" id="md'+d.num_div+'" class="btn-xs btn-warning bt-mod"><i id="up'+d.num_div+'" class="fa fa-pencil"></i></a><span style="font-weight:bold" id="numtb'+d.num_div+'"> Tb. : '+d.num_table+' -  Pl. : '+d.capacite+'</span>';
                        obj += '<p><input id="nametb'+d.num_div+'" data-id-fiche="'+d.id_fiche+'" type="text" class="form-control nametb" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name') ?>"+'" value="'+d.name_table+'" disabled="disabled"></input></p>';
                        obj += '<div id="inftb'+d.num_div+'" style="display: block;display:none"><p style="display: flex;"><input id="datedeb'+d.num_div+'" type="date" class="form-control datedeb" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Début' : 'Start') ?>"+'" value="'+d.date_start+'" disabled="disabled"></input>';
                        obj += '<input id="dateend'+d.num_div+'" type="date" class="form-control dateend" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fin' : 'End') ?>"+'" value="'+d.date_end+'" disabled="disabled"></input></p>';
                        obj += '<p style="display: flex;"><input id="nbadulte'+d.num_div+'" type="text" class="form-control nbadulte" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb Adulte' : 'Nb Adult') ?>"+'" value="'+d.nb_adulte+'" disabled="disabled"></input>';
                        obj += '<input id="nbenf'+d.num_div+'" type="text" class="form-control nbenf" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb Enfant' : 'Nb Child') ?>"+'" value="'+d.nb_enfant+'" disabled="disabled"></input>';
                        obj += '<input id="nbbb'+d.num_div+'" type="text" class="form-control nbbb" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb Bébé' : 'Nb Baby') ?>"+'" value="'+d.nb_bb+'" disabled="disabled"></input></p>';
                        obj += '<p><input id="note'+d.num_div+'" type="text" class="form-control note" placeholder="Note" value="'+d.note+'"disabled="disabled"></input></p></div></div></div>';
                        $('#contdiv').append(obj)
                        
                        dragElement(document.getElementById("mydiv"+d.num_div));
                    })
                }
                else{
                    alert(resp.message);
                }
                
                HoldOn.close();

            }, 'json');
            
            return false;
        }

        function displayElmtObj(){
            let image = '';

            HoldOn.open();
            $.post('appajax.php', {action: 'display-obj',}, function(resp) {
                if (resp.responseAjax == 'SUCCESS') {
                    // console.log(resp.data)
                    resp.data.forEach(function(d){
                        image = '';
                        if(d.type_obj == "W"){
                            image = 'img/fenetre.png';
                        }    
                        if(d.type_obj == "P"){
                            image = 'img/porte2.png';
                        }    
                        if(d.type_obj == "C"){
                            image = 'img/colonnes.png';
                        }    
                        if(d.type_obj == "E"){
                            image = 'img/double-porte.png';
                        }    
                        if(d.type_obj == "S"){
                            image = 'img/escaliers.png';
                        }    
                        if(d.type_obj == "CT"){
                            image = 'img/comptoir.png';
                        }    
                        if(d.type_obj == "CH"){
                            image = 'img/cheminee.png';
                        }    
                        if(d.type_obj == "EX"){
                            image = 'img/exterieure.png';
                        }    
                        if(d.type_obj == "M"){
                            image = 'img/mur.png';
                        }    
                        if(d.type_obj == "R"){
                            image = 'img/rideau.png';
                        }    
                        if(d.type_obj == "F"){
                            image = 'img/plante.png';
                        }    
                        
                        let divobj = '';
                        divobj = '<div style="background-color:transparent !important; border:none; width:100px; top:'+d.posT+'px; left:'+d.posL+'px; z-index:1" id="mydiv'+d.id_table_obj+'" class="mydiv clsobj"><div style="height:75px; background-color:transparent !important;color:black" id="mydivheader'+d.id_table_obj+'" class="mydivheader clsobj"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '' : '') ?><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="del" id="a'+d.id_table_obj+'" class="btn-xs btn-danger bt-del-obj">X</a>';
                        divobj += '<p><img  class="myimg clsobj" id="myobj'+d.id_table_obj+'" src="'+image+'" alt="window" style="width:50px"/></p></div></div></div>';

                        $('#contdiv').append(divobj)
                        
                        dragElement(document.getElementById("mydiv"+d.id_table_obj));
                    })
                }
                else{
                    alert(resp.message);
                }
                
                HoldOn.close();

            }, 'json');
            
            return false;
        }

        function dragElement(elmnt) {
            console.log('dragelemnt', obj, elmnt, elmnt.id)
            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            if (document.getElementById(elmnt.id + "header")) {
                /* if present, the header is where you move the DIV from:*/
                document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
            } else {
                /* otherwise, move the DIV from anywhere inside the DIV:*/
                
                elmnt.onmousedown = dragMouseDown;
                
            }

            function dragMouseDown(e) {
                let elmt = e.target;
                console.log('dragMouseDown',e.target, e.target.className,'--',elmt.id, $('elmt'),'dragmoussedown')
                if(e.target.className == "mydivheader clsobj" 
                    || e.target.className == "mydiv clsobj" 
                    || e.target.className == "myimg clsobj" 
                    || elmt.id.substring(5) == "myobj"
                    || e.target.className == 'btn-xs btn-danger bt-del-obj'){
                    obj = 'obj';
                }

                
                if(obj == ''){

                    $('#inftb'+elmt.id.substring(1)).hide();
    
                    e = e || window.event;
                    e.preventDefault();
    
                    if(elmt.className == 'btn-xs btn-danger bt-del'){
                        confDelDrag = 1;
                        if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmation !' : 'Confirmation !') ?>")){
                            return false
                        }
                        HoldOn.open();
                        $.post('appajax.php', {action: 'del-table', iddiv:elmt.id.substring(1)}, function(resp) {
                            if (resp.responseAjax == 'SUCCESS') {
                                $('#mydiv'+elmt.id.substring(1)).remove();
                            }
                            else{
                                alert(resp.message);
                            }
                            
                            HoldOn.close();
    
                        }, 'json');
                        
                        return false;
                    }
    
                    if(elmt.className == 'btn-xs btn-info bt-dspl'){
                        return false;
                    }
    
                    if(elmt.className == 'btn-xs btn-warning bt-mod' || elmt.className == 'fa fa-pencil'){
                        let iddivupt = elmt.id.substring(2);
    
                        HoldOn.open();
                        $.post('appajax.php', {action: 'get-inf-table', iddiv:elmt.id.substring(2)}, function(resp) {
                            if (resp.responseAjax == 'SUCCESS') {
                                $('#etage').val(resp.data.etage)
                                $('#capacite').val(resp.data.capacite)
                                $('#name_table').val(resp.data.name_table)
                                $('#num_table').val(resp.data.num_table)
                                $('#date_start').val(resp.date_start)
                                $('#date_end').val(resp.date_end)
                                $('#nb_adulte').val(resp.data.nb_adulte)
                                $('#nb_enfant').val(resp.data.nb_enfant)
                                $('#nb_bb').val(resp.data.nb_bb)
                                $('#note').val(resp.data.note)
                                $('#iddivupt').val(iddivupt)
                                $('#modal-modif').modal();
                            }
                            else{
                                alert(resp.message);
                            }
                            
                            HoldOn.close();
    
                        }, 'json');
                        
                        return false;
                    }
    
                    iddiv = e.target.id.substring(11);
    
                    
                }else{
                    
                    e = e || window.event;
                    e.preventDefault();

                    if(elmt.className == 'btn-xs btn-danger bt-del-obj'){
                        confDelDrag = 1;
                        if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmation !' : 'Confirmation !') ?>")){
                            return false
                        }
                        HoldOn.open();
                        $.post('appajax.php', {action: 'del-obj', iddiv:elmt.id.substring(1)}, function(resp) {
                            if (resp.responseAjax == 'SUCCESS') {
                                $('#mydiv'+elmt.id.substring(1)).remove();
                            }
                            else{
                                alert(resp.message);
                            }
                            
                            HoldOn.close();

                        }, 'json');
                        
                        return false;
                    }

                    
                    if(e.target.className == "mydivheader clsobj"){
                        console.log('d2',obj, e.target.className, elmt.id)
                        // en clic consecutif la elmt.id change ?
                        if(elmt.id.substring(0,10) == 'mydivheader'){
                            idobj = elmt.id.substring(11);
                        }else{
                            idobj = elmt.id.substring(5);
                        }
                    }else{
                        console.log('d3',obj, e.target.className, elmt.id,elmt.id.substring(5))
                        idobj = elmt.id.substring(5);
                    }
                    
                }


                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                console.log('elemntdrag')
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";

                posT = (elmnt.offsetTop - pos2);
                posL = (elmnt.offsetLeft - pos1);
                
                    
            }

            function closeDragElement(e) {
                let identDiv = e
                // console.log(identDiv,'closedrag...')
                // return false;
                
                if(obj == ''){
                    console.log(e,e.srcElement.offsetParent.style.left,'closedrag')
                    if(parseInt(posL) <= 0){
                        posL = e.srcElement.offsetParent.style.left;
                    }
                    if(parseInt(posT) <= 0){
                        posT = e.srcElement.offsetParent.style.top;
                    }

                    // pour eviter le update sur l evenement drag
                    // mais plus necessaire puisque gestion par modal
                    if(e.target.id.substring(0,6) == 'nametb' && iddiv == ''){
                        iddiv = e.target.id.substring(6)
                    }else if((e.target.id.substring(0,7) == 'datedeb' || e.target.id.substring(0,7) == 'dateend') && iddiv == ''){
                        iddiv = e.target.id.substring(7)
                    }else if(e.target.id.substring(0,8) == 'nbadulte' && iddiv == ''){
                        iddiv = e.target.id.substring(8)
                    }else if((e.target.id.substring(0,5) == 'nbenf' || e.target.id.substring(0,5) == 'numtb')&& iddiv == ''){
                        iddiv = e.target.id.substring(5)
                    }else if((e.target.id.substring(0,4) == 'nbbb' || e.target.id.substring(0,4) == 'note') && iddiv == ''){
                        iddiv = e.target.id.substring(4)
                    }else if(e.target.id.substring(0,11) == 'mydivheader' && (iddiv == '' || iddiv == '0')){
                        iddiv = e.target.id.substring(11)
                    }else if(e.target.id.substring(0,9) == 'mydivspan' && iddiv == ''){
                        iddiv = e.target.id.substring(9)
                    }
                    console.log('id closedrag', iddiv)
                    /* stop moving when mouse button is released:*/
                    document.onmouseup = null;
                    document.onmousemove = null;
                    
                    // call ajax save infos div
                    HoldOn.open();
                    $.post('appajax.php', {
                        action: 'update-drag-table',
                        iddiv:iddiv, 
                        posL:posL, 
                        posT:posT,
                    }, function(resp) {
                        if (resp.responseAjax == 'SUCCESS') {
                            authAdd = 0;
                            authAddObj = 0;
                        }
                        else{
                            alert(resp.message);
                        }
                        
                        HoldOn.close();
    
                    }, 'json');
                    return false
                }else{

                    if(e.target.className = "mydivheader clsobj"){
                        console.log(e,e.srcElement.offsetParent.style.left,'closedrag')
                        if(parseInt(posL) <= 0){
                            posL = e.srcElement.offsetParent.style.left;
                        }
                        if(parseInt(posT) <= 0){
                            posT = e.srcElement.offsetParent.style.top;
                        }
                    }else{
                        console.log('ll',e,e.target.parentElement.parentElement.parentElement.style.left,'closedrag')
                        if(parseInt(posL) <= 0){
                            posL = e.target.parentElement.parentElement.parentElement.style.left;
                        }
                        if(parseInt(posT) <= 0){
                            posT = e.target.parentElement.parentElement.parentElement.style.top;
                        }
                    }

                    /* stop moving when mouse button is released:*/
                    document.onmouseup = null;
                    document.onmousemove = null;

                    // call ajax save infos div
                    HoldOn.open();
                    $.post('appajax.php', {
                        action: 'update-drag-obj',
                        idobj:idobj, 
                        posL:posL, 
                        posT:posT,
                    }, function(resp) {
                        if (resp.responseAjax == 'SUCCESS') {
                            authAdd = 0;
                            authAddObj = 0;
                            obj = '';
                        }
                        else{
                            alert(resp.message);
                        }
                        
                        HoldOn.close();

                    }, 'json');
                    return false
                }
            }

        }

        $('#formulairetable').submit(function() {
			
            HoldOn.open();
            jQuery(this).ajaxSubmit({
                dataType: 'json',
                success: function(resp) {
                    if (resp.responseAjax == 'SUCCESS') {
                        
                        $.bootstrapGrowl('<h4>Confirmation!</h4> <p><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Modifications effectuées' : 'Updated')?></p>', {
                            type: 'success',
                            delay: 5000,
                            offset: {
                            from: "top",
                            amount: 100
                                },
                                align: "center",
                            allow_dismiss: true
                        });

                        // let bkg = '#2196F3';
                        // if(resp.etage < 0){
                        //     bkg = 'green';
                        // }
                        // if(resp.etage == 0){
                        //     bkg = '#2196F3';
                        // }
                        // if(resp.etage == 1){
                        //     bkg = '#2155E0';
                        // }
                        // if(resp.etage == 2){
                        //     bkg = '#0085E0';
                        // }

                        let bkg = '#2196F3';

                        if(resp.capacite == 1){
                            bkg = '#574e34';
                        }
                        if(resp.capacite == 2){
                            bkg = '#2196F3';
                        }
                        if(resp.capacite == 3){
                            bkg = '#9c7211';
                        }
                        if(resp.capacite == 4){
                            bkg = '#eaf551';
                        }
                        if(resp.capacite == 5){
                            bkg = '#b3f556';
                        }
                        if(resp.capacite == 6){
                            bkg = '#38823c';
                        }
                        if(resp.capacite == 7){
                            bkg = '#57bdb6';
                        }
                        if(resp.capacite == 8){
                            bkg = '#4c4eb5';
                        }
                        if(resp.capacite == 9){
                            bkg = '#bd47bf';
                        }
                        if(resp.capacite == 10){
                            bkg = '#e81737';
                        }

                        $('#mydivheader'+resp.iddiv).css('background-color',bkg)

                        // console.log($('#numtb'+resp.iddiv).val(),resp)
                        $('#numtb'+resp.iddiv).text(' Tb. : '+resp.numtb+' -  Pl. : '+resp.capacite);
                        $('#capacite'+resp.iddiv).text(resp.capacite);
                        $('#nametb'+resp.iddiv).val(resp.name);
                        $('#datedeb'+resp.iddiv).val(resp.date_start);
                        $('#dateend'+resp.iddiv).val(resp.date_end);
                        $('#nbadulte'+resp.iddiv).val(resp.nb_adulte);
                        $('#nbenf'+resp.iddiv).val(resp.nb_enfant);
                        $('#nbbb'+resp.iddiv).val(resp.nb_bb);
                        $('#note'+resp.iddiv).val(resp.note);

                        $('#modal-modif').modal('hide')

                    } else
                    if (resp.responseAjax == 'ERROR')
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
                    HoldOn.close();
                },
                error: function() {
                    HoldOn.close();
                }
            });

            return false;
        });

        $(document).on('click','.bt-dspl',function(){
            console.log('gg',$(this)[0].id.substring(1))
            let id = $(this)[0].id.substring(1);
            // console.log('565',$('#mydiv'+id).css('z-index'))
            if($(this).attr('data-dspl') == ''){
                $('#mydivheader'+id).css('height','75px')
                $('#mydivheader'+id).css('width','127px')
                $('#inftb'+id).hide();
                $(this).attr('data-dspl','dspl')
                $('#mydiv'+id).css('z-index','1')
            }else{
                $('#mydivheader'+id).css('height','')
                $('#mydivheader'+id).css('width','270px')
                $('#inftb'+id).show();
                $(this).attr('data-dspl','')
                $('#mydiv'+id).css('z-index','2')
            }
            return false;
        })

        $(document).on('click','.bt-del',function(){
            if(confDelDrag == 0){
                if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmation ' : 'Confirmation') ?>")){
                    return false
                }
                let id = $(this).parent().parent()[0].id.substring(5);
                HoldOn.open();
                $.post('appajax.php', {action: 'del-table', iddiv:id}, function(resp) {
                    if (resp.responseAjax == 'SUCCESS') {
                        $('#mydiv'+id).remove();
                    }
                    else{
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
    
                }, 'json');
    
                return false;
            }
            confDelDrag = 0 ;

        })

        $(document).on('click','.bt-del-obj',function(){
            console.log('del obj',$(this))
            if(confDelDrag == 0){
                if(!confirm("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Confirmation ' : 'Confirmation') ?>")){
                    return false
                }
                let id = $(this).parent().parent()[0].id.substring(5);
                HoldOn.open();
                $.post('appajax.php', {action: 'del-obj', iddiv:id}, function(resp) {
                    if (resp.responseAjax == 'SUCCESS') {
                        $('#mydiv'+id).remove();
                    }
                    else{
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
    
                }, 'json');
    
                return false;
            }
            confDelDrag = 0 ;

        })

        // $(document).on('.nametb', 'keyup', function(){
        //     alert($(this).val())
        // })

        /*  ADD RECENT */
        $(document).on('change','.nametb',  function(){
            let idclt = $(this).val();
            let idblk = $(this).attr('id');

            HoldOn.open();
            $.post('appajax.php', {
                action: 'keep-infos',
                idct: idclt,
            }, function(resp) {
                if (resp.responseAjax == 'SUCCESS') {
                    console.log(resp.datedeb, resp.dateend, '#datedeb'+idblk.substr(6));
                    $('#datedeb'+idblk.substr(6)).val(resp.datedeb)
                    $('#dateend'+idblk.substr(6)).val(resp.dateend)
                }
                else{
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

            }, 'json');
        })
        /*  ADD RECENT */
        
        $(document).on("click", "#tmp" ,function(){
            console.log('222',$(this).parent().parent()[0].id.substring(5))
            // console.log('click header after dragelmt', $('#nametb').val())
            // return false;
            let id = $(this).parent().parent()[0].id.substring(5);
            if($('#nametb'+id).val() == ''){
                alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom obligatoire, manquant' : 'Name require, missing') ?>")
                return false;
            }
            if($('#datedeb'+id).val() == '' || $('#dateend'+id).val() == ''){
                alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Dates obligatoires, manquantes' : 'Date require, missing') ?>")
                return false;
            }
            if(parseInt($('#nbadulte'+id).val()) <= 0 && parseInt($('#nbenf'+id).val()) <= 0 && parseInt($('#nbbb'+id).val()) <= 0){
                alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nombre de personne null' : 'Nomber of persons is null') ?>")
                return false;
            }

             // call ajax save infos div
            HoldOn.open();
            $.post('appajax.php', {
                action: 'update-table',
                iddiv:id, 
                posL:'4', 
                posT:'8',
                numtb:$('#numtb'+iddiv).val(),
                nametb:$('#nametb'+iddiv).val(),
                datedeb:$('#datedeb'+iddiv).val(),
                dateend:$('#dateend'+iddiv).val(),
                nbadulte:$('#nbadulte'+iddiv).val(),
                nbenf:$('#nbenf'+iddiv).val(),
                nbbb:$('#nbbb'+iddiv).val(),
                note:$('#note'+iddiv).val(),
                etage:$('#etage'+iddiv).val(),
                capacite:$('#capacite'+iddiv).val(),
            }, function(resp) {
                if (resp.responseAjax == 'SUCCESS') {
                    authAdd = 0;
                }
                else{
                    alert(resp.message);
                }
                
                HoldOn.close();

            }, 'json');

            $('.tmpbtn').removeClass('tmpbtn');
            
            console.log('lll',document.getElementById("mydiv"+iddiv))
            //Make the DIV element draggagle:
            $('#mydivheader'+iddiv).removeClass("mydivheaderTmp");
            $('#mydivheader'+iddiv).addClass("mydivheader");
            
            // $( "a" ).remove( ":contains('Click here to move')" );
            $( ".bt-move" ).replaceWith( "<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Déplacer ici' : 'Move here') ?>" );
            dragElement(document.getElementById("mydiv"+iddiv));
            
            setTimeout(() => {
                window.location.reload()
            }, 100);
        })

        $('#btaddobj').change(function(){
            if(authAddObj != 0 || authAdd != 0){
                alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Objet précédent non encore placé' : 'Previous object not yet placed') ?>")
                return false;
            }
            if($(this).val() == ''){
                return false;
            }

            // console.log('sl',$(this).val())
            let image = '';
            if($(this).val() == "W"){
                image = 'img/fenetre.png';
            }    
            if($(this).val() == "P"){
                image = 'img/porte2.png';
            }    
            if($(this).val() == "C"){
                image = 'img/colonnes.png';
            }    
            if($(this).val() == "E"){
                image = 'img/double-porte.png';
            }    
            if($(this).val() == "S"){
                image = 'img/escaliers.png';
            }    
            if($(this).val() == "CT"){
                image = 'img/comptoir.png';
            }    
            if($(this).val() == "CH"){
                image = 'img/cheminee.png';
            }    
            if($(this).val() == "EX"){
                image = 'img/exterieure.png';
            }
            if($(this).val() == "M"){
                image = 'img/mur.png';                
            }   
            if($(this).val() == "R"){
                image = 'img/rideau.png';
            }    
            if($(this).val() == "F"){
                image = 'img/plante.png';
            }    
           
            HoldOn.open();
            $.post('appajax.php', {action: 'add-obj',type: $(this).val()}, function(resp) {
                if (resp.responseAjax == 'SUCCESS') {
                    if(resp.delelmt > '0'){
                        $('#mydiv'+resp.delelmt).remove();
                    }
                    let divobj = '';
                    divobj = '<div style="background-color:transparent !important; border:none; width:100px; top:8px; left:4px; z-index:1" id="mydiv'+resp.id+'" class="mydiv clsobj"><div style="height:75px; background-color:transparent !important;color:black" id="mydivheader'+resp.id+'" class="mydivheader clsobj"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Déplacer ici' : 'Move here') ?><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="del" id="a'+resp.id+'" class="btn-xs btn-danger bt-del-obj">X</a>';
                    divobj += '<p><img  class="myimg clsobj" id="myobj'+resp.id+'" src="'+image+'" alt="window" style="width:50px"/></p></div></div></div>';
                    
                    // divobj = '<div id="divobj'+resp.id+'" style="left:4px; top:8px;z-index:1" class="myobj"><img  id="myobj'+resp.id+'" src="img/fenetre.png" alt="window" style="width:50px"/></div>';
                    $('#contdiv').append(divobj)
                    authAddObj = 0;
                    // //Make the DIV element draggagle:
                    obj = 'obj';
                    dragElement(document.getElementById("mydiv"+resp.id));
                    authAdd = 0;
                }
                else{
                    alert(resp.message);
                }
                
                HoldOn.close();

            }, 'json');
            <?php /*  */ ?>
            setTimeout(() => {
                window.location.reload()
            }, 100);
           
             
        })

        $('#btadd').click(function(){
            if(authAdd != 0 || authAddObj != 0){
                alert("<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Objet précédent non encore placé' : 'Previous object not yet placed') ?>")
                return false;
            }
            HoldOn.open();
			$.post('appajax.php', {action: 'add-table', }, function(resp) {
				if (resp.responseAjax == 'SUCCESS') {
                    if(resp.delelmt > '0'){
                        $('#mydiv'+resp.delelmt).remove();
                    }

                    // obj += '<p><input value="" id="nametb'+resp.id+'" type="text" class="form-control nametb" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nom' : 'Name') ?>"+'"></input></p>';

                    let obj = '';
                    obj = '<div style="width:270px" id="mydiv'+resp.id+'" class="mydiv"><div id="mydivheader'+resp.id+'" class="mydivheaderTmp"><a href="#" id="tmp" style="margin-bottom:10px" class="btn btn-info bt-move"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Cliquez ici pour déplacer' : 'Click here to move') ?></a><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="del" id="a'+resp.id+'" class="btn-xs btn-danger bt-del">X</a><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="dspl" id="d'+resp.id+'" class="tmpbtn btn-xs btn-info bt-dspl">...</a><a href="#" style="box-shadow:0px 0px !important;margin-left:5px" data-action="mod" id="md'+resp.id+'" class="tmpbtn btn-xs btn-warning bt-mod"><i id="up'+resp.id+'" class="tmpbtn fa fa-pencil"></i></a><p style="display: flex;"><span style="font-weight:bold"><input value="" id="numtb'+resp.id+'" type="text" class="form-control numtb" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'N° table' : 'N° table') ?>"+'"></input></span><span><input value="" id="etage'+resp.id+'" type="text" class="form-control etage" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Etage' : 'Floor') ?>"+'"></input></span><span style="font-weight:bold"><input value="" id="capacite'+resp.id+'" type="text" class="form-control capacite" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Capacité' : 'Capacity') ?>"+'"></input></span></p>';
                    obj += '<p>'+resp.html+'</p>';
                    obj += '<div style="display: block;" id="inftb'+resp.id+'"><p style="display: flex;"><input value="" id="datedeb'+resp.id+'" type="date" class="form-control datedeb" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Début' : 'Start') ?>"+'"></input>';
                    obj += '<input value="" id="dateend'+resp.id+'" type="date" class="form-control dateend" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Fin' : 'End') ?>"+'"></input></p>';
                    obj += '<p style="display: flex;"><input value="" id="nbadulte'+resp.id+'" type="text" class="form-control nbadulte" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb Adulte' : 'Nb Adult') ?>"+'"></input>';
                    obj += '<input value="" id="nbenf'+resp.id+'" type="text" class="form-control nbenf" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb Enfant' : 'Nb Child') ?>"+'"></input>';
                    obj += '<input value="" id="nbbb'+resp.id+'" type="text" class="form-control nbbb" placeholder="'+"<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Nb Bébé' : 'Nb Baby') ?>"+'"></input></p>';
                    obj += '<p><input value="" id="note'+resp.id+'" type="text" class="form-control note" placeholder="Note"></input></p></div></div></div>';
                    $('#contdiv').append(obj)

                    iddiv = resp.id;
                    // alert(iddiv)
                    // //Make the DIV element draggagle:
                    // dragElement(document.getElementById("mydiv"+resp.id));
                    authAdd = 1;
                }
				else{
					alert(resp.message);
                }
				
				HoldOn.close();

			}, 'json');
            
            return false;
        })
    })
</script>