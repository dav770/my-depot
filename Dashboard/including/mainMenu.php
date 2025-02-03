
<?php 
$soc = Soc::findOne(array('is_soc'=>'1'));
// echo(print_r($soc));
?>
<div class="row" >
  <?php /*<div class="row">*/?>
  <div class="">
    <div class="col-lg-12">
      <?php if($soc->logo_soc != ''){?>
        <div style="justify-content: center; text-align: center; justify-content: center; text-align: center; justify-content: center; text-align: center;background-color: linear-gradient(to bottom right, blue, pink);background-image: url(uploads/socs/<?php echo $soc->logo_soc?>), linear-gradient(to bottom right, #009fff, #cec4c6);background-repeat: no-repeat;background-size: contain;margin-bottom: -14px;margin-top: 2px;">
      <?php }else{?>
        <div style="justify-content: center; text-align: center; justify-content: center; text-align: center; justify-content: center; text-align: center;background-color: linear-gradient(to bottom right, blue, pink);background-image: url(img/logo-soc.png), linear-gradient(to bottom right, #009fff, #cec4c6);background-repeat: no-repeat;background-size: contain;margin-bottom: -14px;margin-top: 2px;">
      <?php }?>
      <div id="azuro" style="position:absolute; z-index:1;right: 42px;bottom: 0px;">  
        Created by <img src="img/azuro-black.png" style="width:45px"></img>
      </div>
        <ul class="wrapper text-center">
          <!-- <?php if($arrAccess['acces_page_client_calendar_rappel'] == 1){?>
            <li class="icon stat clstat <?php echo strstr($template['active_page'], 'index') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Statistiques" : "Statistics") ?></span>
              <span class="clstat"><a href="index.php"><i class="fa fa-bar-chart clstat"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['acces_page_client_calendar_rappel'] == 1){?>
            <li class="icon calendar clcalendar <?php echo strstr($template['active_page'], '-rappels') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Planing des rappels" : "Schedule of callbacks") ?></span>
              <span class="clcalendar"><a href="calendar-rappels.php"><i class="fa fa-calendar-check-o clcalendar"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['acces_page_client_calendar_rappel'] == 1){?>
            <li class="icon table cltable <?php echo strstr($template['active_page'], 'tables') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Gestion des tables" : "Tables managment") ?></span>
              <span class="cltable"><a href="tables.php"><i class="fa fa-table cltable"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['visu_client'] == 1){?>
            <li class="icon clients clclients <?php echo strstr($template['active_page'], 'contacts') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Clients" : "Customers") ?></span>
              <span class="clclients"><a href="fiches.php"><i class="gi gi-parents clclients"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['visu_planning_ch'] == 1){?>
            <li class="icon calch clcalch <?php echo strstr($template['active_page'], 'planning') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Planing des chambres" : "Schedule of rooms") ?></span>
              <span class="clcalch"><a href="schedule.php"><i class="gi gi-calendar clcalch"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['visu_mail_inbox'] == 1){?>
            <li class="icon inbox clinbox <?php echo strstr($template['active_page'], 'call-') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Boite de réception" : "Inbox") ?></span>
              <span class="clinbox"><a href="call-attach-imap.php"><i class="fa fa-envelope-open-o clinbox"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['visu_mail_outbox'] == 1){?>
            <li class="icon outbox cloutbox <?php echo strstr($template['active_page'], 'outbox') ? ' active' : ''; ?>">
              <span class="tooltip active"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Messages envoyés" : "Outbox") ?></span>
              <span class="cloutbox"><a href="outbox.php"><i class="fa fa-send cloutbox"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['visu_infos_stripe'] == 1){?>
            <li class="icon stripe clstripe <?php echo strstr($template['active_page'], 'reglements') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Suivi des paiments" : "Payments") ?></span>
              <span class="clstripe"><a href="reglements.php"><i class="fa fa-money clstripe"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['visu_commandes'] == 0){?>
            <li class="icon cmds clcmds <?php echo strstr($template['active_page'], 'commandes') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Commndes fournisseurs" : "Orders") ?></span>
              <span class="clcmds"><a href="commandes.php"><i class="fa fa-file clcmds"></i> </a></span>
            </li>
          <?php }?>
          <?php if($arrAccess['visu_settings'] == 1){?>
            <li class="icon set clset <?php echo strstr($template['active_page'], 'setting') ? ' active' : ''; ?>">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Parametrages" : "Settings") ?></span>
              <span class ="clset"><a href="settings.php"><i class="fa fa-gear clset"></i> </a></span>
          </li>
          <?php }?> -->
          <li class="icon main clmain">
              <span class="tooltip"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Menu Principal" : "Main menu") ?></span>
              <span class ="clmain"><a href="index.php"><i class="fa fa-list clmain"></i> </a></span>
          </li>
        </ul>
        
      </div>
      
    </div>
  </div>
</div>


<!-- PASSE DANS FOOTPAGE.PHP AVEC LE COMMENTAIRE : ETAIT DANS MAINMENU.PHP -->

<script>
//  <!-- PASSEE DANS FOOTPAGE.PHP AVEC LECOMMENTAIRE : ETAIT DANS MAINMENU.PHP -->
</script>