<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">

        <title><?php echo $template['title'] ?></title>
	
        <meta name="description" content="<?php echo $template['description'] ?>">
        <meta name="author" content="<?php echo $template['author'] ?>">
        <meta name="robots" content="<?php echo $template['robots'] ?>">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
		
        <link rel="shortcut icon" href="img/logo-soc.png">
        
		<link rel="stylesheet" type="text/css" media="screen" href="jscript/themes/redmond/jquery-ui.custom.css" />		
		<link rel="stylesheet" type="text/css" media="screen" href="jscript/jqgrid/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/head.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <?php if ($template['theme']){ ?>
            <link id="css-theme" rel="stylesheet" href="css/themes/<?php echo $template['theme']; ?>.css">
        <?php } ?>
        
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            function getEmails() {
                document.getElementById('dataDivID')
                    .style.display = "block";
            }
        </script>
        <script src="jscript/jshead.js"></script>
        
		<script type="text/javascript" src="jscript/jqgrid/jsgrid.js"></script>	
		<?php if (strstr(basename($_SERVER['PHP_SELF']), 'contacts')) { ?>
			<script src="//cdn.jsdelivr.net/jstorage/0.1/jstorage.min.js" type="text/javascript"></script>	
			<script src="//cdn.jsdelivr.net/json2/0.1/json2.min.js" type="text/javascript"></script>
			<script src="//cdn.rawgit.com/gridphp/jqGridState/e06788e68cd9f97db9da4bb4ba1c4a82890aed9e/jqGrid.state.js" type="text/javascript"></script>
		<?php } ?>

        <script src="jscript/vendor/bootstrap.min.js"></script>
        <script src="jscript/stocks.js"></script>

        <style>            
            .alerteStock {
                animation-duration: 1.3s;
                animation-name: clignoter;
                animation-iteration-count: infinite;
                transition: none;
            }
            @keyframes clignoter {
                0% { opacity: 1; }
                50% { opacity: 0; }
                100% { opacity: 1; }
            }
        </style>
    </head>
    <html>
    <body>
    
    <?php 
        // $notifs = Notif::find('', 'id_notif desc','',0,20);
        
    ?>
    



<!-- <script src="jscript/vendor/bootstrap.min.js"></script>
<script src="jscript/stocks.js"></script> -->

<div id="page-wrapper-head"<?php if ($template['page_preloader']) { echo ' class="page-loading"'; } ?>>
    <div class="preloader themed-background">
        <h1 class="push-top-bottom text-light text-center"><strong>Azuro Crm</strong></h1>
        <div class="inner">
            <h3 class="text-light visible-lt-ie9 visible-lt-ie10"><strong>Loading.....</strong></h3>
            <div class="preloader-spinner hidden-lt-ie9 hidden-lt-ie10"></div>
        </div>
    </div>

    <?php
        $page_classes = '';

        if ($template['header'] == 'navbar-fixed-top') {
            $page_classes = 'header-fixed-top';
        } else if ($template['header'] == 'navbar-fixed-bottom') {
            $page_classes = 'header-fixed-bottom';
        }

        if ($template['main_style'] == 'style-alt')  {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'style-alt';
        }

        if ($template['footer'] == 'footer-fixed')  {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'footer-fixed';
        }

        if (!$template['menu_scroll'])  {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'disable-menu-autoscroll';
        }

        if ($template['cookies'] === 'enable-cookies') {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'enable-cookies';
        }
    ?>
    <div id="page-container"<?php if ($page_classes) { echo ' class="' . $page_classes . '"'; } ?>>
        <div id="main-container">
            <input type="hidden" id="jsLg" value ="<?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'FR' : 'ENG' )?>">

            <header class="navbar<?php if ($template['header_navbar']) { echo ' ' . $template['header_navbar']; } ?><?php if ($template['header']) { echo ' '. $template['header']; } ?>">
                <?php if ( $template['header_content'] == 'horizontal-menu' ) { // Horizontal Menu Header Content ?>
                <!-- Navbar Header -->
                
                <div class="navbar-header">
                    
                </div>
                
                
                <?php } else { // Default Header Content  ?>
                
                <form action="" method="post" class="navbar-form-custom" onsubmit="return false;">
                    <div class="form-group">
                        <input type="text" id="global-research" name="global-research" class="form-control" placeholder="Search..">
						<div id="searchres">
							<ul class="media-list">
							</ul>
						</div>
                    </div>
                </form>

                
                <ul class="nav navbar-nav-custom pull-right">
                    <?php /*if($alerteStocks->num_rows > 0){ */?>
                        <li class="" id="listocks" style="display:none">
                            <a href="#" class="btn" id="modalStock" data-toggle="">
                                <label class="btn btn-default"><?php echo $usrActif->lang ?><img class="alerteStock" src="img/alarm.png" width="25px"></img></label>
                            </a>
                        </li>
                    <?php/* } */?>

                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <label class="btn btn-default"><?php echo $usrActif->lang ?><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? '<img src="img/france.ico" width="25px"></img>' : '<img src="img/uk.png" width="25px"></img>') ?></label>
                        </a>
                        <ul class="dropdown-menu dropdown-custom dropdown-menu-right" id="btchangelang">
                            <li>
                                <a href="#" data-id="FR">FR <img src="img/france.ico" width="25px"></img></a>
                            </li>                            
                            <li>
                                <a href="#" data-id="ENG">ENG <img src="img/uk.png" width="25px"></img></a>
                            </li>                            
                        </ul>
                    </li>

                    <li>
                        <?php
                            $lstsocs = '';
                            $cursocname = '';
                            $curcol = '';
                            $mands = Setting::getAllorganisateurs();
                            foreach($mands as $mand) {
                                $iscursoc = $mand['id_organisateur'] == max($usrActif->cursoc, 1);
                                if ($iscursoc) {
                                    $cursocname = $mand['name_organisateur'];
                                    $curcol = $mand['color'];
                                }
                                //echo '<li><a href="#" data-id="'.$mand['id_organisateur'].'" '.$issel.'>'.mb_strtoupper($mand['name_organisateur'], 'UTF-8').'</a></li>';
                                $lstsocs .= '<li><a href="#" '.(!$iscursoc ? 'data-id="'.$mand['id_organisateur'].'"' : '').'>'.mb_strtoupper($mand['name_organisateur'], 'UTF-8').'</a></li>';
                            }
                        ?>                            
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <label class="btn btn-<?php echo $curcol; ?>"><?php echo $cursocname; ?> <i class="fa fa-angle-down"></i></label>                            
                        </a>
                        <ul class="dropdown-menu dropdown-custom dropdown-menu-right" id="btchangesoc">
                            <?php
                                echo $lstsocs;
                            ?>                            
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="img/placeholders/avatars/avatar2.jpg" alt="avatar"> <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                            <li>
                                <a id="lnkdlogout" href="sign-in.php?logoff=1"><i class="fa fa-ban fa-fw pull-right"></i> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Deconnexion' : 'Logout') ?></a>
                            </li>                            
                        </ul>
                    </li>
                </ul>
                <?php } ?>
            </header>

                            

            <script src="jscript/one.js"></script>
            <script src="jscript/expire.session.js"></script>

            <script>
                $(document).ready(function(){
                    document.getElementById('lnkdlogout').addEventListener('click', function(event) {
                        // Empêcher le comportement par défaut (navigation vers le href)
                        event.preventDefault();

                        // Votre code à exécuter avant de suivre le lien
                        AppStocks.stopInterval();

                        // Exemple : attendre 2 secondes avant de suivre le lien
                        setTimeout(() => {
                            window.location.href = this.href; // Redirection vers le href après exécution du code
                        }, 800);
                    });
                    
                    $('#modalStock').click(function(){
                        $('#modal-ctrl-stock').modal('show')
                    })

                })

            // Gestion du clic sur le bouton "Ouvrir"
            $(document).on('click', '.btn-open-page', function () {
                const idProduit = $(this).data('id');
                const url = `produit.php?id_produit=${idProduit}`;
                window.location.href = url; // Rediriger vers la page avec l'ID du produit
            });
            </script>