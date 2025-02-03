<?php include 'including/config.php'; ?>


<?php
    $outvirement = Grid4PHP::getGrid('inf_virements');
    $outcard = Grid4PHP::getGrid('inf_cards');
?>
<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="css/menu.css">
<style>
	
	@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);
\:root {
  font-size: 16px; }

* {
  font-family: "Open Sans", Helvetica, Arial, sans-serif; }

body {
  height: 100vh;
  background: #F3F4F8; }

.tabs-page {
  position: relative; }
  .tabs-page > .nav-tabs {
    position: relative;
    min-height: 50px;
    margin: 0;
    padding-left: 15px;
    text-align: left;
    cursor: auto;
    border: none;
    z-index: 1; }
    .tabs-page > .nav-tabs li[role="presentation"] {
      display: inline-block;
      height: 50px;
      border: none; }
      .tabs-page > .nav-tabs li[role="presentation"]:not(:last-child) {
        padding-right: 2px; }
      .tabs-page > .nav-tabs li[role="presentation"] a[role="tab"] {
        height: 50px;
        margin: 0;
        padding: 0px 3px 0px 3px;
        /* padding: 0px; */
        /* font-size: 0.875rem; */
        font-weight: 700;
        text-transform: none;
        text-align: center;
        letter-spacing: 0.25px;
        color: black;
        background: #EAE7DA;
        /* background: none; */
        border: none;
		/* border:2px solid black; */
        line-height: 50px;
        transition: color 0.3s ease, box-shadow 0.2s ease; }
        .tabs-page > .nav-tabs li[role="presentation"] a[role="tab"]:hover {
          color: #0075AD; }
      .tabs-page > .nav-tabs li[role="presentation"].active a {
		font-style: oblique;
			font-weight: bold;
			font-size: 25px;
			color: #1f6de6;
        /* color: #0075AD; */
        box-shadow: inset 0 -2px 0 #0075AD;
        background: #FFF; }
        .tabs-page > .nav-tabs li[role="presentation"].active a:hover, .tabs-page > .nav-tabs li[role="presentation"].active a:focus {
			font-style: oblique;
			font-weight: bold;
			font-size: 25px;
			color: #1f6de6;
          background: #FFF;
          border: none; }
  .tabs-page > .tab-content {
    position: relative;
    min-height: 800px;
    margin: 0;
    padding: 0;
    background: white;
    border-top: 1px solid #edeef4;
    border-bottom: 1px solid #edeef4; }

.tabs-secondary {
  position: relative;
  text-align: center; }
  .tabs-secondary > .nav-tabs {
    display: inline-block;
    margin: 0 auto 15px;
    border-bottom: 1px solid #edeef4; }
    .tabs-secondary > .nav-tabs li[role="presentation"]:not(:last-child) {
      margin-right: 20px; }
    .tabs-secondary > .nav-tabs li[role="presentation"] a[role="tab"] {
      padding: 12px 0;
      /* font-size: 0.6875rem; */
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.02rem;
      color: #BDC4D0;
      border: none !important;
      background: none !important; }
      .tabs-secondary > .nav-tabs li[role="presentation"] a[role="tab"]:hover {
        color: #0075AD; }
    .tabs-secondary > .nav-tabs li.active a[role="tab"] {
      color: #0075AD;
      background: none;
      box-shadow: inset 0 -2px 0 0 #0075AD; }


		/*  */
	#example_filter{
		float:right;
	}
	#example_paginate{
		float:right;
	}
	label {
		display: inline-flex;
		margin-bottom: .5rem;
		margin-top: .5rem;

	}

	table{
		width:100%;
	}


</style>


<div id="page-content" class="page-contact">
	
	<div class="content-header">
		<?php include('including/mainMenu.php'); ?>
	</div>
		
  <div id="tabs-page" class="tabs-page">
    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#virement" aria-controls="virement" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Virements" : "Transferts") ?></a></li>
      <li role="presentation"><a href="#card" aria-controls="card" role="tab" data-toggle="tab"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Cartes" : "Cards") ?></a></li>
    </ul><!-- ./ nav tabs -->	
  </div><!-- ./ tabs page -->
  
  
    
  <div class="tabs-page">
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane isact active" id="virement">
        <h2> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Infos virements" : "Transferts informations") ?> </h2>
        <div class="table-responsive">
            <?php echo $outvirement ?>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane isact" id="card">
        <h2> <?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Infos cartes" : "Cards informations") ?> </h2>
        <div class="table-responsive">
            <?php echo $outcard ?>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include 'including/footPage.php'; ?> 

<script src="jscript/jsplug.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>

<script>
	
	$(document).ready(function() {
    $('#virement').change(function(){
				console.log('isact')
				$('.isact').addClass('active');
			})
    })

</script>