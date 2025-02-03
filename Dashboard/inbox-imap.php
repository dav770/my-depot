<?php

include 'including/config.php'; 	

// $outmails = Grid4PHP::getGrid('db_mails'); ?>

<?php include 'including/headPage.php'; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<link rel="stylesheet" href="css/menu.css">

<?php 
$mtypes = ModelMail::find("");

?>


<!-- Bootstrap -->
<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- dataTables -->
<!-- <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet"> -->
<style>
body {
	padding: 20px 10px 20px 10px
}

@media (min-width: 576px) {
  .modal-dialog {
    max-width: 900px !important;
    margin: 30px auto;
  }
}
</style>

<!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->


<div id="page-content" class="page-dashboard"> 
    <!-- eCommerce Dashboard Header --> 
    <div class="content-header">
        <?php include('including/mainMenu.php'); ?>
    </div>

    <h2><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? 'Boite de réception' : 'Inbox') ?> </h2>

    <div class="container">
      <div class="row">
        <div class="col-md-12"> 
          <!-- <h3 align="center">Email Inbox <a href="mailto:hello@bachors.com">hello@bachors.com</a></h3> -->
          <!-- <a class="github-button" href="https://github.com/bachors/Email-Inbox-IMAP" data-icon="octicon-cloud-download" data-size="large" aria-label="Download bachors/Email-Inbox-IMAP on GitHub">Download</a> -->
          <hr>

          <table id="myTable" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Subject</th>
                <th><i class="fa fa-paperclip"></i></th>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody id="inbox">

            </tbody>
          </table>
            
        </div>					
      </div>					
    </div>

    <!-- Modal message -->		
    <div id="addModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content" style="width:800px">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Message</h4>
          </div>
		  <div style=";display: flex;justify-content:center">
			  <div class="modal-body" id="message">
		  </div>
            
          </div>
        </div>
      </div>
    </div>
</div>

<?php include 'including/footPage.php'; ?>

<script src="jscript/jsplug.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTPCq11w-n5ZN8o3fIzhuUXCwPTTP6OmE&libraries=places"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="jscript/helpers/ckeditor/ckeditor.js"></script>
<script src="jscript/helpers/ckeditor/config.js"></script>

<!-- jQuery -->
<!-- <script src="//code.jquery.com/jquery-2.1.1.min.js"></script> -->
<!-- Bootstrap -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script> -->
<!-- dataTables -->
<!-- <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> -->
<!-- loading-overlay -->
<script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
<script>		
$(function() {

	var json;
	
	$.LoadingOverlay("show");

	$.ajax({
		type: "POST",
		url: "libry/imap-client/json.php",
		data: {
			inbox: ""
		},
        dataType: 'json'
	}).done(function(d) {
		if(d.status === "success"){
			var tbody = "";
			let nbpj = 0;

			json = d.data;
			$.each(json, function(i, a) {
				nbpj = a.attachments.length;

				tbody += '<tr><td>' + (i + 1) + '</td>';
				// tbody += '<td><a href="#" data-id="' + i + '" class="view" data-toggle="modal" data-target="#addModal">' + a.subject.substring(0, 20) + '</a></td>';
				tbody += '<td><a href="#" data-id="' + i + '" class="view" data-toggle="modal" >' + a.subject.substring(0, 20) + '</a></td>';
				tbody += '<td>' + nbpj + '</td>';
				tbody += '<td>' + (a.from.name === "" ? "[empty]" : a.from.name) + '</td>';
				tbody += '<td><a href="mailto:' + a.from.address + '?subject=Re:' + a.subject + '">' + a.from.address + '</a></td>';
				tbody += '<td>' + a.date + '</td></tr>';

				nbpj = 0;
			});
			$('#inbox').html(tbody);
			$('#myTable').DataTable();
			$.LoadingOverlay("hide");
		}else{
			alert(d.message);
		}
	});

	$('body').on('click', '.view', function () {
		var id = $(this).data('id'); 
		var message = json[id].message;
		var attachments = json[id].attachments;
		var attachment = '';
		if(attachments.length > 0){
			attachment += "<hr>Attachments:";
			$.each(attachments, function(i, a) {
				var file = json[id].uid + ',' + a.part + ',' + a.file + ',' + a.encoding;
				attachment += '<br><a href="#" class="file" data-file="' + file + '">' + a.file + '</a>';
			});
		}
		$('#message').html(message + attachment); 
    	$("#addModal").modal('show')

	});

	$('body').on('click', '.file', function () {
		$.LoadingOverlay("show");
		var file = $(this).data('file').split(",");
		$.ajax({
			type: "POST",
			url: "libry/imap-client/json.php",
			data: {
				uid: file[0],
				part: file[1],
				file: file[2],
				encoding: file[3]
			},
			dataType: 'json'
		}).done(function(d) {
			if(d.status === "success"){
				$.LoadingOverlay("hide");
				window.open(d.path, '_blank');
			}else{
				alert(d.message);
			}
		});
	});
			
});
</script>