<?php 
    include 'including/dbclass.php';
    // Désactiver le rapport d'erreurs
    error_reporting(0);
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS");

    $ct = false;
    
    if (isset($_GET['key'])) {
        $codekey = substr($_GET['key'], 0, 8);
        $idct =  substr($_GET['key'], 8);
        $ct = Contact::findOne(array('c.id_fiche' => $idct, 'c.codekey ' => $codekey));

    }
    if (isset($_GET['type'])) {
        $typeTheme = $_GET['type']; 
    }

    $dir = IsoPDFBuilder::checkDir($ct->codekey . $ct->id_fiche);





?>


<style type="text/css" media="screen,print">                    
        * {font-family:helvetica;}
        table {border-collapse: collapse; width: 100% ;}
        td { border : 1px solid black; padding : 5px 10px;}
        .bold{ font-weight: bold}
        .justify {text-align: justify}
        .center {text-align: center}
    </style>


<!DOCTYPE html>
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
    <!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        

        <title>DEMO SOC - FICHES</title>
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
	
        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="img/favicon.png"  type="image/x-icon">
        <link rel="apple-touch-icon" href="img/favicon.png" type="image/x-icon">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <link rel="stylesheet" href="Dashboard/css/bootstrap.min.css">
        <link rel="stylesheet" href="Dashboard/css/plugins.css">
        <link rel="stylesheet" href="Dashboard/css/main.css">
        <link rel="stylesheet" href="Dashboard/css/themes.css">

		<!-- CUSTOM JO -->
		<link rel="stylesheet" href="Dashboard/css/HoldOn.min.css">
		
        <!-- Modernizr (browser feature detection library) & Respond.js (enables responsive CSS code on browsers that don't support it, eg IE8) -->
        <script src="Dashboard/js/vendor/modernizr-respond.min.js"></script>
		
		<script src="Dashboard/js/vendor/jquery-1.12.0.min.js"></script>

        <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        <div id="page-content">
            <!-- Article Content -->
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                    <!-- Article Content -->
                    <div class="col-md-8 col-md-offset-2 col-sm-12">
                        <form onsubmit="return false;" class="form-horizontal" method="post" action="publicajax.php" id="formulairecontrat">
                            <!-- Article Header -->
                            <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
                            <div class="content-header">
                                <div class="header-section text-center">
                                    <p>
                                        Veuillez renseigner l'ensemble des informations suivantes pour procéder a la mise à jour de votre fiche client
                                    </p>
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-3 control-label">Nom client<span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez le nom..." class="form-control" name="last_name" id="last_name" value="<?php echo strtoupper($ct->last_name); ?>" required  readonly='readonly' >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name" class="col-md-3 control-label">Prénom client<span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez le nom..." class="form-control" name="first_name" id="first_name" value="<?php echo strtoupper($ct->first_name); ?>" required readonly='readonly' >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tel1" class="col-md-3 control-label">Téléphone principal<span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez le nom..." class="form-control" name="tel1" id="tel1" value="<?php echo strtoupper($ct->tel1); ?>" required readonly='readonly' >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tel2" class="col-md-3 control-label">Téléphone secondaire</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez le nom..." class="form-control" name="tel2" id="tel2" value="<?php echo strtoupper($ct->tel2); ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tel2" class="col-md-3 control-label">Num. Passeport</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez le num. passeport." class="form-control" name="numpassport" id="numpassport" value="<?php echo strtoupper($ct->numpassport); ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="adr1" class="col-md-3 control-label">Adresse client<span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="adr1" id="adr1" value="<?php echo strtoupper($ct->adr1); ?>" required readonly='readonly' >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_code" class="col-md-3 control-label">Code postal<span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="post_code" id="post_code" value="<?php echo strtoupper($ct->post_code); ?>" required readonly='readonly' >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-md-3 control-label">Ville<span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="city" id="city" value="<?php echo strtoupper($ct->city); ?>" required readonly='readonly' >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-3 control-label">Email<span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Saisissez l'adresse'..." class="form-control" name="email" id="email" value="<?php echo strtoupper($ct->email); ?>" required readonly='readonly' >
                                        </div>
                                    </div>

                                    <a href="#"  style="color:#000; font-weight: bold;margin-top: 30px;border-radius: 30px;width: 98px;" class="form-control btn btn-sm btn-success btaddct" id="btaddct">Ajoutez Infos</a>
                                    <div class="form-group">
                                        <table class="center" id="addct">
                                            <tr>
                                                <td>
                                                    Nom
                                                </td>
                                                <td>
                                                   Prénom
                                                </td>
                                                <td>
                                                    Date de naissance
                                                </td>
                                                <td>
                                                    N° passeport
                                                </td>
                                                <td>
                                                    Action
                                                </td>
                                            </tr>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-actions">
                                    <input type="hidden" name="action" id="action" value="sign-contrat" />
                                    <input type="hidden" name="idct" id="idct" value="<?php echo $ct->id_fiche ?>" />
                                    <input type="hidden" name="codekey" id="codekey" value="<?php echo $ct->codekey ?>" />
                                    <button class="btn btn-sm btn-primary" type="submit" id="btupdatecontrat"><i class="fa fa-user"></i> Valider</button>
                                    <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Annuler</button>
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal PDF BAR EN -->
            <div id="modal-baren" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="text-right display-none" id="blksigndoc" style="padding:15px 15px 0;">
                            <a href="#" id="btsigndoc" class="btn btn-sm btn-success"><i class="gi gi-pen"></i> Signer le document</a>
                        </div>
                        <div class="modal-body" style="height: 80vh">
                            <iframe src="" style="width:100%;height:100%;"></iframe>
                            <input type="hidden" id="view_id_docs" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- END view impot -->
        </div>


        

        <footer class="clearfix">
            <div class="pull-left">
                <span id="y-copy-right"></span> &copy; <?=date('Y')?> <a href="#" target="_blank">DEMO SOC</a>
            </div>
        </footer>
        <!-- END Footer -->

        <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
       

        <script src="Dashboard/js/vendor/bootstrap.min.js"></script>
        <script src="Dashboard/js/plugins.js"></script>
        <script src="Dashboard/js/vendor/jquery.form.min.js"></script>
        <script src="Dashboard/js/HoldOn.min.js"></script>
        <script src="Dashboard/js/signature_pad.min.js"></script>
        <script src="Dashboard/js/one.js"></script>
        
        <!-- <script src="js/one.js"></script> -->
        
        <?php include 'including/template_scripts.php'; ?>

        <script type="text/javascript">
            $(document).ready(function() {

                var nameDocSign = '';
		        var typeDocSign = '';
                
                function getNameDoc(name){
                    // console.log('name : ',name)
                    nameDocSign = name;
                    nameDocSign = nameDocSign.substr(nameDocSign.lastIndexOf('/')+1);
                    nameDocSign = nameDocSign.substr(0,nameDocSign.indexOf('pdf')-1);
                }


                var nbclic = 0;
                var nbtr = 0;

                $('#btaddct').click(function(){
                    
                    nbclic++;
                    var str = '';
                    var str = '<tr id="tr'+nbclic+'" >';
                    str += '<td><input type="text" class="form-control" name="addnom'+nbclic+'" id="addnom'+nbclic+'" value="" required  ></td>';
                    str += '<td><input type="text" class="form-control" name="addprenom'+nbclic+'" id="addprenom'+nbclic+'" value="" required  ></td>';
                    str += '<td><input type="date" style="background-color:#c1eaf7" class="form-control " placeholder="dd/mm/yyyy" name="adddate'+nbclic+'" id="adddate'+nbclic+'" value="" ></td>';
                    str += '<td><input type="text" class="form-control" name="addpasseport'+nbclic+'" id="addpasseport'+nbclic+'" value="" ></td>';
                    str += '<td><button type="button" class="btn btn-sm btn-danger deladd" data-clic="'+nbclic+'" name="suppadd'+nbclic+'" id="deladd'+nbclic+'" value="" >Delete</td>';
                    str += '</tr>';

                    $('#addct').append(str);
                    return false;
                })

                // var obj = $('#formulairecontrat')

                $(document).on('click','.deladd', function(){
                    let valclic = $(this).attr('data-clic');
                    
                    $('#tr'+valclic).remove();
                })
                
                $(document).on('submit', '#formulairecontrat', function() {

                    HoldOn.open();
                    jQuery(this).ajaxSubmit({
                        dataType : 'json',
                        data:{
                            idct:$('#idct').val(), 
                            codekey:$('#codekey').val(), 
                            nbclic: nbclic
                            },

                        success: function(resp) {
					    
                            HoldOn.close();
                            if (resp.responseAjax == 'SUCCESS') {
                                HoldOn.open();
                                // console.log(resp.doc)
                                // if (resp.iddoc > 0)
                                //     $('#view_id_docs').val(resp.iddoc);
                                // else
                                //     $('#view_id_docs').val('');

                                // if (resp.cansign == '1')
                                //     $('#blksigndoc').removeClass('display-none');
                                // else
                                //     $('#blksigndoc').addClass('display-none');

                                // // getNameDoc(resp.doc);
                                // typeDocSign = 'du Devis';


                                // $('#modal-baren iframe').attr('src', resp.doc);
                                // $('#modal-baren').modal();


                                $.post('publicajax.php', {action:'sign-doc-public', idd: resp.idd, idct: resp.idct, nameDoc: resp.namedoc, typeDoc: resp.typedoc}, function(resp) {
                                        HoldOn.close();
                                        if (resp.responseAjax == 'SUCCESS') {
                                            $.bootstrapGrowl('<h4>Confirmation!</h4> <p>' + resp.message + '</p>', {
                                                type: 'success',
                                                delay: 2500,
                                                allow_dismiss: true
                                            });
                                        } else
                                            $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
                                                type: 'danger',
                                                delay: 2500,
                                                allow_dismiss: true
                                            });
                                    }, 'json');
                                
                                return false;

                            } else {
                                $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
                                    type: 'danger',
                                    delay: 2500,
                                    allow_dismiss: true
                                });
                            }
                        },
                        error: function() {
                            console.log('NO');
                            HoldOn.close();
                        }
                    });

			        return false;   
                });
            
            });
        </script>

    </body>
</html>
