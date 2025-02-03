<?php

include 'including/config.php';
// echo(print_r($_REQUEST).' --- '.print_r($_GET).' --- '.print_r($_POST));
// die;
$outcmddet = Grid4PHP::getGrid('db_commandes');
// $cmddet = QueryExec::querySQL("SELECT * FROM db_commandes WHERE is_validate = 1 AND num_cmd ='".$_POST['']."' AND id_sejour = ".$_POST[''])

?>

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
    </head>

    <body>
        
        <div class="">
            
            <!-- <table>
<tr><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td></tr>
<tr><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td></tr>
<tr><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td></tr>
<tr><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td></tr>
<tr><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td></tr>
<tr><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td><td>123<td></tr>
        </table> -->
        </div>
        
    <body>
</html>


<script>
    
</script>