<?php
include 'including/dbclass.php';

// error_log("RETOUR SELLSIGN  POST=> ".print_r($_POST, true));        
$body = file_get_contents('php://input');
// error_log("RETOUR BODY => ".$body.'  '.print_r($_REQUEST, true).'<br>');
$resp = json_decode($body);

$docstf = false;
$tdoc = 3;
// error_log(print_r($resp,true));
// error_log("RETOUR JSON => ".print_r($resp, true).PHP_EOL);
// file_put_contents(__DIR__.'/Dashboard/uploads/tmp.txt', "*********** START RESP ***********\n", FILE_APPEND);
// file_put_contents(__DIR__.'/Dashboard/uploads/tmp.txt', $resp->contractId.' --->'.$resp->signatureStatus."\n===".$resp->pdf."\n===>>>".$resp['pdf']."\n********** END RESP ************\n", FILE_APPEND);
// QueryExec::querySQL("insert into db_tmp_sign (body, request, jsondecode) values ('".str_replace("'",'',$body)."','".str_replace("'",'',print_r($_REQUEST, true))."','".str_replace("'",'',print_r($resp,true))."')");
// QueryExec::querySQL("insert into db_tmp_sign (body, request, jsondecode) values (".$body.",".print_r($_REQUEST, true).",".print_r($resp,true).")");
// QueryExec::querySQL("insert into db_tmp_sign (body, request, jsondecode) values (".$body.",".print_r($_REQUEST, true).",".print_r($resp,true).")");

$doc = Doc::findOne(array('contract_id_sellsign' => $resp->contractId));

if($doc){
    $contact = Fiche::findOne(array('c.id_fiche' => $doc->id_fiche));
}


// if($resp->signatureStatus == 'REFUSED'){       
if($resp->sig_status == 'REFUSED'){       
    $iddoc = Doc::update(array('status_sellsign' => 'REFUSED'),array('id_doc' => $doc->id_doc));
    $nameoriginedoc = $doc->name_doc;
    
    $resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
    if($resInfmail){
        Mailings::sendMail('mail-admin', (object)array(
            'subject' => 'Refus signature document',
            'email' => 'Mendibenech@gmail.com',
            'msg' => 'Le document '.$nameoriginedoc.' $envoyé en signature électronique au client : <br>'.
                        ($contact->civ_contact == 1 ? 'MONSIEUR' : 'MADAME').' '.$contact->last_name.' '.$contact->first_name.'<br>
                        a été <b>refusé</b>.<br>ID client : '.$contact->id_fiche.'<br>Doc : '.$nameoriginedoc.'<br>ID signature : '.$resp->contractId.'<br>Date : '.date('Y-m-d H:i:s')
        ));
    }

    
}
// if($resp->signatureStatus == 'SIGNED'){       
if($resp->sig_status == 'SIGNED'){       
    $iddoc = Doc::update(array('status_sellsign' => 'SEND'),array('id_doc' => $doc->id_doc));

}

    



if ($resp->status == 'ARCHIVED') {
    $doc = Doc::findOne(array('contract_id_sellsign' => $resp->contractId));
    if($doc){
        $contact = Fiche::findOne(array('c.id_fiche' => $doc->id_fiche));
    }

    $nameoriginedoc = $doc->name_doc;
    $nmdoc = str_replace('.pdf', '_SIGNED_ARCHIVED.pdf', $doc->name_doc);
    if(strstr(strtoupper($doc->name_doc), 'DEVIS')){
        $tdoc = '1';
    }
    if(strstr(strtoupper($doc->name_doc), 'CONTRAT')){
        $tdoc = '4';
    }
    $iddoc = Doc::create(array('id_fiche' => $contact->id_fiche,'name_doc'=>$nmdoc,'status_sellsign' => 'SIGNED & ARCHIVED', 'contract_id_sellsign' => $resp->contractId, 'date_doc' => date('Y-m-d H:i:s'),'id_type_doc' => $tdoc));

    $filebin = base64_decode($resp->pdf);

    file_put_contents(__DIR__.'/Dashboard/uploads/'.$contact->codekey.$contact->id_fiche.'/'.$nmdoc, $filebin);

    $resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
    if($resInfmail){
        Mailings::sendMail('mail-admin', (object)array(
            'subject' => 'Retour signé document',
            'email' => 'Mendibenech@gmail.com',
            'msg' => 'Le document '.$nameoriginedoc.' $envoyé en signature électronique au client : <br>'.
                        ($contact->civ_contact == 1 ? 'MONSIEUR' : 'MADAME').' '.$contact->last_name.' '.$contact->first_name.'<br>
                        a été <b>signé</b>.<br>ID client : '.$contact->id_fiche.'<br>Doc : '.$nmdoc.'<br>ID signature : '.$resp->contractId.'<br>Date : '.date('Y-m-d H:i:s')
        ));
    }
    
    if(strstr(strtoupper($nmdoc), 'CONTRAT')){
        Fiche::update(array('lnk_contrat_signed'=>'1'),array('id_fiche'=>$contact->id_fiche));
    }

    if(strstr(strtoupper($nmdoc), 'DEVIS')){
        Fiche::update(array('lnk_devis_signed'=>'1'),array('id_fiche'=>$contact->id_fiche));
    }
    
    

}

?>