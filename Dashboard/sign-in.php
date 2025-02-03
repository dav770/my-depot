<?php 
    $ispagelogin = true; 
    include 'including/config.php'; 
    $soc = Soc::findOne(array('is_soc'=>'1'));
    if($soc){
        $logosoc = $template['url'].'/uploads/socs/'.$soc->logo_soc;
    }else{
        $logosoc = $template['url'].'/img/azuro-black.png';
    }
?>

<style>
    .form-control 
    {
        margin-bottom:15px !important;
    }
</style>

<!DOCTYPE html>
    <html class="no-js">
    <head>
        <meta charset="utf-8">

        <title><?php echo $template['title'] ?></title>
	
        <meta name="description" content="<?php echo $template['description'] ?>">
        <meta name="author" content="<?php echo $template['author'] ?>">
        <meta name="robots" content="<?php echo $template['robots'] ?>">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
		
        <link rel="shortcut icon" href="<?php echo $logosoc ?>">
        
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
    <html>
        <body>
            <img src="img/placeholders/backgrounds/lock_full_bg.jpg" alt="Login" class="full-bg animation-pulseSlow">
            <div id="login-container" class="animation-fadeIn">
                <!-- Login Title -->	
                <div class="login-title text-center" style="background-color: transparent;text-align: center;height: 25px;">
                    <img src="<?php echo $logosoc ?>" style="width:160px"/> 
                <div class="block push-bit" style="border:none !important; background-color: #2f78a4 !important;"> 
                    <!-- Login Form -->
                    <form action="appajax.php" method="post" id="form-login" style="text-align: center;margin-bottom: 10px;background-color: #2f78a4;" class="form-horizontal form-control" onsubmit="return false">
                        <input type="hidden" name="action" id="action" value="sign-in" />
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <div class="col-md-6">
                                        <input type="text" id="codedemo" name="codedemo" style="font-weight:bold; background-color:black;color: red;text-align: center;" class="form-control input-lg" placeholder="code demo">
                                    
                                        <a href="#" style="color: black;border: 1px solid black;padding: 7px;" class="btn btn-sm btn-warning" id="btcodedemo"> Génération code démo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                    <?php echo Tool::DropDown('id_organisateur',Setting::getAllorganisateurs(),'id_organisateur','name_organisateur','','Choix du séjour',false,false,array(),false,'','#2f78a4',true ) ?>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    <input type="text" id="email" name="email" style="font-weight:bold" class="form-control input-lg" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="password" id="psw" name="psw" style="font-weight:bold" class="form-control input-lg" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-8 text-right">
                                <button type="submit" style="background-color:#2f78a4;color:#cfb63a" class="btn btn-sm " id="btlogin"><i class="fa fa-angle-right"></i> Login to Dashboard</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </body>
    </html>

    <script src="jscript/jsplug.js"></script>

<script>
    $(document).ready(function(){
        
        $('#btcodedemo').click(function(){
			$.post('appajax.php', {action:'code-demo'}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
					$('#codedemo').val(resp.codedemo);
					
				}
				else {
					alert("Impossible de generer le code de domo\n\rVerifier la connexion a la base !");
				}
			}, 'json');
				
			return false;
        })

        $('#email').keyup(function(){
            verifRules();
        })

        $('#psw').keyup(function(){
            verifRules();
        })

        function verifRules(){
            if($('#email').val() == 'admin@azuro.com' && $('#psw').val() == 'demoazuro123'){
                $('#btcodedemo').show();
            }else{
                $('#btcodedemo').hide();
            }
        }
        
        function clearDemo(){
            $.post('appajax.php', {action:'clear-demo'}, function(resp) {
				if (resp.responseAjax == "SUCCESS") {
				}
				else {
					alert("Session de DEMO non réinitialisée !\n\rPrévenir l'adiministarteur / développeur");
				}
			}, 'json');
				
			return false;
        }

        initLogin();

        
        function initLogin(){ 
            verifRules();
            clearDemo();

            $(function(){ 
                $('#form-login').validate({
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'div',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        e.closest('.form-group').removeClass('has-success has-error');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        'login-email': {
                            required: true,
                            email: true
                        },
                        'login-password': {
                            required: true,
                            minlength: 5
                        }
                    },
                    messages: {
                        'login-email': 'Please enter your account\'s email',
                        'login-password': {
                            required: 'Please provide your password',
                            minlength: 'Your password must be at least 5 characters long'
                        }
                    }
                });  
                
                $('#form-login').submit(function() {
                    $('#btlogin').prop( "disabled", true );
                    
                    jQuery(this).ajaxSubmit({
                        dataType:'json',
                        success : function (resp) {	
                            if (resp.responseAjax == 'SUCCESS') {
                                if(resp.new == '1'){
                                    alert('Bienvenue dans votre nouveau CRM\n\rDefinissez vos séjours et vos utilisateurs depuis l\'éeran des paramétrages');
                                }
                                location.href = 'index.php';
                            }
                            else
                            if (resp.responseAjax == 'ERROR')
                                alert(resp.message);
                            $('#btlogin').prop( "disabled", false);	
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log("Error Thrown: " + errorThrown);
                                console.log("Text Status: " + textStatus);
                                console.log("XMLHttpRequest: " + XMLHttpRequest);
                                console.warn(XMLHttpRequest.responseText)
                        
                            $('#btlogin').prop( "disabled", false);	
                        }
                    }); 
                    return false;
                });

            });
        };
    });
</script>
