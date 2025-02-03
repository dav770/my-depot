<?php include 'including/config.php'; ?>
<?php
	$outalertes = Grid4PHP::getGrid('db_notifs');
?>

<?php include 'including/headPage.php'; ?>



<style>
	tr.focus-rappel
	{
		background: #c8d578;
		color: green;
		border: 1px solid darkgray;
	}
</style>

<!-- Page content -->
<div id="page-content" class="page-alertes">
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>
    <!-- END eCommerce Dashboard Header -->

    <!-- eShop Overview Block --> 
    <div class="block full row" id="blalert">
        <!-- eShop Overview Title -->		
		<div class="col-lg-12">
			<div class="block">
                <!-- Normal Form Title -->
                <div class="block-title">
					<h2><strong>Gestion des</strong> Alertes</h2>
                </div>
				<div class="form-group">
					<div class="table-responsive" id="rglt_grid">
						<?php echo $outalertes; ?>
					</div>
				</div>
            </div>
		</div>		
    </div>

    <!-- END eShop Overview Block -->
</div>
<!-- END Page Content -->



<?php include 'including/footPage.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="jscript/helpers/excanvas.min.js"></script><![endif]-->

<script src="jscript/jsplug.js"></script>
<script src="<?php echo $template['url']; ?>/jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="<?php echo $template['url']; ?>/jscript/helpers/ckeditor/config.js"></script>


<!-- Load and execute javascript code used only in this page -->
<script>
	$(document).ready(function() {

		$(document).on('click','.btdelnotif', function() {
       
			if(!confirm('Suppression de cette alerte ?')){
				return
			}

			HoldOn.open();
			var curnotif = $(this).attr('data-id');
			console.log('del notif : ',$(this).attr('data-id'));
			$.post('crmajax.php', {action:'read-notif', idnotif:curnotif}, function(resp) {
				HoldOn.close();
				if (resp.responseAjax == 'SUCCESS') {
					$('#list_notifs').trigger("reloadGrid",[{page:1}]);
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
			}, 'json');
		
			return false;
	});
		
	});

	function gridformat(ids) {	
		if(ids.rows) 
			jQuery.each(ids.rows,function(i) {
				
				jQuery('#list_notifs tr.jqgrow:eq('+i+')').css({'text-align':'left'});
			});
			
		$('.ui-pg-selbox').val(jQuery('#list_notifs').getGridParam('rowNum'));
		jQuery('#list_notifs').jqGrid('resetSelection');
	}
</script>

