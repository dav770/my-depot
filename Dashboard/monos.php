<?php include 'including/config.php'; 
$outmono = Grid4PHP::getGrid('db_monos', $usrActif->cursoc);
?>	

<?php include 'including/headPage.php'; ?>
<link rel="stylesheet" href="css/menu.css"> 


<!-- Page content -->
<div id="page-content" class="page-dashboard"> 
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

	<div id="blcact" class="table-responsive"><?php echo $outmono; ?></div>
	
</div>
		


<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>

<script>
	$(document).ready(function(){
        $(document).on('click','.btplan',function(){
                        
        })

    })

</script>