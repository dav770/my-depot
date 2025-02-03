<?php include 'including/config.php'; ?>
<?php $outuser = Grid4PHP::getGrid('db_users', $usrActif); ?>

<?php include 'including/headPage.php'; ?>
<link rel="stylesheet" href="css/menu.css">

<!-- Page content -->
<div id="page-content" class="">
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?> 
    </div>
    <!-- END eCommerce Dashboard Header -->


    <!-- eShop Overview Block -->
    <div class="block full">
        <!-- eShop Overview Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="#" onclick="showUsrApp(0)" class="btn btn-xs btn-info">Nouvel utilisateur CRM</a>
                </div>
            </div>
			<h2>Liste des <strong>utilisateurs CRM</strong></h2>
        </div>
        <!-- END eShop Overview Title -->

        <!-- eShop Overview Content -->
        <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="row push table-responsive">
                        <?php echo $outuser; ?>
                    </div>
                </div>
            </div>
        <!-- END eShop Overview Content -->
    </div>
    <!-- END eShop Overview Block -->

</div>
<!-- END Page Content -->



<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="<?php echo './jscript/helpers/ckeditor/ckeditor.js'?>" ></script>
<script src="<?php echo './jscript/helpers/ckeditor/config.js'?>"></script>


<script>
	
	$(document).ready(function() {
	
    
  });
	
</script>