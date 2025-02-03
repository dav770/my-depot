<?php
include __DIR__.'/db.php';
include __DIR__.'/ImageResize.php';
include __DIR__.'/queries.php';
include __DIR__.'/burnDoc.php';

require __DIR__ . '/../libry/vendor/autoload.php';

class FormatRespJsonStandard
{
    public static function wrapJSON($code, $content, $die = true)
    {
        $resJson = [
            "responseAjax" => $code
        ];

        // Fusionner les données de $content avec $resJson
        $resJson = array_merge($resJson, $content);

        echo json_encode($resJson); // Encoder proprement en JSON

        if ($die) {
            die;
        }
    }
}


class RespAjaxStandard
{
	
	public static function successJSON($content, $die = true)
	{
		FormatRespJson::wrapJSON('SUCCESS', $content, $die);
	}
	public static function errorJSON($content, $die = true)
	{
		FormatRespJson::wrapJSON('ERROR', $content, $die);
	}
	
}

class FormatRespJson
{
	public static function wrapJSON($code, $content, $die = true)
	{
		$content = json_encode((object)$content);
		$content = substr($content, 1, strlen($content) - 1);
		$resJson = '{"responseAjax":"' . $code . '",' . $content;

		echo $resJson;

		if ($die) {
			die;
		}
		
	}
}

class RespAjax
{
	
	public static function successJSON($content, $die = true)
	{
		FormatRespJson::wrapJSON('SUCCESS', $content, $die);
	}
	public static function errorJSON($content, $die = true)
	{
		FormatRespJson::wrapJSON('ERROR', $content, $die);
	}
	
}

class Ctrl
{
	public static function ctrlflds($arr, $flds)
	{
		$ret = true;
		foreach ($flds as $fld) {
			if (!isset($arr[$fld]) || (empty($arr[$fld]) && $arr[$fld] !== '0')) {
				$ret = false;
				break;
			}
		}
		return $ret;
	}
}

class Tool
{

	public static function stripTags($bodyTags = '')
	{
		$body = '';

		if($bodyTags != ''){
			$body = str_replace('<br>', '\n',$bodyTags);
			$body = strip_tags($body);
		}

		return $body;
	}

	public static function DropDown($id, $arr, $val, $txt, $selval, $deftxt = '', $multiple = false, $required = false, $atts = array(), $ro = false, $bkg='', $color='',$textalign = false)
	{
		$html = '<select aria-describedby="'.$id.'" id="'.$id.'"  name="'.$id.'" class="form-control select-chosen '.$id.' '.($multiple ? 'select-chosen' : '').'" '.($multiple ? 'multiple' : '').' '.($required ? 'required' : '').' '.($ro ? 'readonly="readonly"' : '').' style="font-weight:bold;'.($bkg && $color != '' ? 'backgroung-color:'.$bkg.';color:'.$color.';' : ($bkg != '' ? 'style="background-color:'.$bkg.';' : 'color:'.$color.';')).($textalign ? 'text-align:center;' : '').'">';
		if ($deftxt != '')
			// 
			if(count($atts) > 0){
				$html .= '<option value="0" data-cout="0" data_coutday="0" >'.$deftxt.'</option>';
			}else{
				$html .= '<option value="">'.$deftxt.'</option>';
			}

		$disp = '';
			
		foreach($arr as $line) {
			$stratt = '';
			if (count($atts) > 0) {
				foreach($atts as $k => $v)
				// echo('==========>'.$line['is_not_actif'].'<br>');
					$stratt .= ' '.$k.'="'.$line[$v].'"';
					
			}
			// if($filtreTh > 0){
			// 	if($k == 'data-theme'){
			// 		$listeTh = explode(',',$line[$v]);		
			// 		$disp = in_array($filtreTh,$listeTh) ? '' : 'style="display:none"';
			// 	}
			// }
			
			$sel = $line[$val] == $selval ? 'selected="selected"' : '';
			
			$html .= '<option value="'.$line[$val].'" '.$sel.' '.$disp.' '.$stratt.'>'.$line[$txt].'</option>';		
			
			
			$sel = '';
		}
		$html .= '</select>';
		
		
		return $html;
	}
	
	public static function DropDownArray($id, $arr, $sfx='')
	{
		$html = '<select aria-describedby="'.$id.'" id="'.$id.'"  name="'.$id.'" class="form-control">';
		foreach($arr as $key => $val) 
			$html .= '<option value="'.$key.'">'.$val.$sfx.'</option>';		
		$html .= '</select>';
		
		return $html;		
	}
	
	public static function dmYtoYmd($dt)
	{
		if (strpos($dt, ' ') !== false)
			$dt = explode(' ', $dt)[0];
		$dts = explode('/', $dt);
		if (count($dts) <> 3)
			return '';
		else 
			return $dts[2].'-'.$dts[1].'-'.$dts[0];
	}
	
	public static function addTimeStr($strtime)
	{
		$times = explode(':', $strtime);
		if (count($times) < 2)
			return '';
		else {
			$hr = (int)$times[0] > 0 ? '+ '.$times[0].' hour ' : '';
			$mn = (int)$times[1] > 0 ? '+ '.$times[1].' minutes ' : '';
			$sc = isset($times[2]) && (int)$times[2] > 0 ? '+ '.$times[2].' seconds ' : '';
			
			$str = $hr.$mn.$sc;
			if ($str == '')
				$str = '+ 0 seconds ';
			return $str;
		}
	}


	public static function removeAccent($text){
		//return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
		
		$table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r'
		);

		// -- Returns the slug
		$text = strtoupper(strtr($text, $table));
		
		
		if (empty($text)) {
		  return '###';
		}
	  
		return $text;		
    }
	
	public static function isImage($file)
	{
		return strpos($file, '.jpg') > 0 || strpos($file, '.gif') > 0 || strpos($file, '.jpeg') > 0 || strpos($file, '.png') > 0 || strpos($file, '.bmp') > 0;
	}
	
		
	public static function displayMt($number, $forcedec = true)
	{
		$whole = floor($number);
		$fraction = $number - $whole;
		if ($fraction == 0 && !$forcedec)
			return number_format($number, 0, ',', ' ');
		else
			return number_format($number, 2, ',', ' ');
	}
	
	public static function fulldatestr($dt)
	{
		$str = date('l d F Y', strtotime($dt));
	
		return str_replace(array(
			'Monday', 
			'Tuesday', 
			'Wednesday', 
			'Thursday', 
			'Friday', 
			'Saturday', 
			'Sunday', 
			'January', 
			'Febuary', 
			'March', 
			'April', 
			'May', 
			'June', 
			'July', 
			'August', 
			'September', 
			'October', 
			'November', 
			'December'), array(
			'Lundi', 
			'Mardi', 
			'Mercredi', 
			'Jeudi', 
			'Vendredi', 
			'Samedi', 
			'Dimanche', 
			'Janvier', 
			'Fevrier', 
			'Mars', 
			'Avril', 
			'Mai', 
			'Juin', 
			'Juillet', 
			'Aout', 
			'Septembre', 
			'Octobre', 
			'Novembre', 
			'Decembre'
		), $str);
	}
	
	
	
	public static function arrayToStr($arr, $html = true) {
		if (count($arr) == 0 || !is_array($arr))
			return '';
		$str = '';
		$sep = $html ? '<br>' : "\n";
		foreach($arr as $k => $v)
			$str .= ($str != '' ? $sep : '') . $k.' : '.$v;
		return $str;
	}

	public static function getInitials($words)
	{
		$res = '';
		$arr = explode(' ', $words);
		foreach($arr as $a)
			$res .= substr($a, 0, 1);
		return $res;
	}
	

	public static function doResize($upload_dir, $name) {
		$image = new \Eventviva\ImageResize($upload_dir . $name);
		$image->crop(200, 200);
		$image->save($upload_dir . $name);
		
		/*$image->resizeToBestFit(60, 60);
		$image->save($upload_dir . 'small/'. $name);*/
	}

	public static function uploadFile($upload_dir, $myFile, $withResize = false) {
		// echo($upload_dir.' --- '.print_r($myFile));

		if ($myFile["error"] !== UPLOAD_ERR_OK) {
			echo "<p>An error occurred.</p>";
			die;
		}

		// ensure a safe filename
		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

		// don't overwrite an existing file
		$i = 0;
		$parts = pathinfo($name);

		if (!in_array(strtolower($parts['extension']), array('txt','jpg', 'gif', 'jpeg', 'png', 'wav', 'mpg','mpeg', 'mp4', 'pdf', 'doc', 'docx', 'xls', 'xlsx'))) {
            echo "<p>An error occurred.</p>";
            die;
        }
				
		while (file_exists($upload_dir . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		}

		// preserve file from temporary directory
		$success = move_uploaded_file($myFile["tmp_name"],
			$upload_dir . $name);
		if (!$success) { 
			echo "Unable to save file.";
			die;
		}
		else {
			if ($withResize)
				Tool::doResize($upload_dir, $name);		
			return $name;
		}
		
	}

	public static function ctrlUploadFile($upload_dir, $myFile, $withResize = false) {
		echo($upload_dir.' --- '.print_r($myFile));
		die;

		if ($myFile["error"] !== UPLOAD_ERR_OK) {
			echo "<p>An error occurred.</p>";
			die;
		}

		// ensure a safe filename
		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

		// don't overwrite an existing file
		$i = 0;
		$parts = pathinfo($name);

		if (!in_array(strtolower($parts['extension']), array('txt','jpg', 'gif', 'jpeg', 'png', 'wav', 'mpg','mpeg', 'mp4', 'pdf', 'doc', 'docx', 'xls', 'xlsx'))) {
           return false;
        }
		
		return true;
	}
	
}


require __DIR__.'/../libry/PHPMailer/PHPMailerAutoload.php';
class Mailings
{
	

	public static function saveMail($arrMail, $typeMail)
	{

		$res = false;
		
		foreach($arrMail as $key=>$valM){
			
			if($typeMail == 0){
				
				$searchMail = Imap::findOne(array('uuid_mail'=>$arrMail['uuid']));
				

				if(!$searchMail){

					if(strpos($arrMail['date'],',') > 0){
						$dt = substr($arrMail['date'],strpos($arrMail['date'],',') + 1);
					
						$dt2 = str_replace(' ','',$dt);
	
						$j = substr(trim($dt),0,2);
						$m = substr(trim($dt),2,3);
						$a = substr(trim($dt),6,4);
						// echo('**'.$dt.'--'.$dt2.' **** '.$m. ' ' .$j.'  '.$a);
						// 	die;
						if(strlen(trim($j)) == 1){
							$j = '0'.$j;
						}
						switch (strtoupper($m))
						{
							case 'JAN':
								$d = $a.'-01-'.$j;
								break;
							case 'FEB':
								$d = $a.'-02-'.$j;
								break;
							case 'MAR':
								$d = $a.'-03-'.$j;
								break;
							case 'APR':
								$d = $a.'-04-'.$j;
								break;
							case 'MAI':
								$d = $a.'-05-'.$j;
								break;
							case 'JUN':
								$d = $a.'-06-'.$j;
								break;
							case 'JUL':
								$d = $a.'-07-'.$j;
								break;
							case 'AUG':
								$d = $a.'-08-'.$j;
								break;
							case 'SEP':
								$d = $a.'-09-'.$j;
								break;
							case 'OCT':
								$d = $a.'-10-'.$j;
								break;
							case 'NOV':
								$d = $a.'-11-'.$j;
								break;
							case 'DEC':
								$d = $a.'-12-'.$j;
								break;
						}
					}else{
						if((int)strpos($arrMail['date'],'-') > 0){
							$d = $arrMail['date'];
						}else{
							if((int)strpos($arrMail['date'],'/') > 0){
								$dt = explode('/',$arrMail['date']);
								$d = $dt[2].'-'.$dt[1].'-'.$dt[0];
							}
						}
					}
					
			
					$sql = "INSERT INTO db_mails (id_fiche, alias_mail, from_mail, to_mail, subject_mail, msg_mail, uuid_mail, is_send_mail, date_mail, date_create) 
					VALUES (".($typeMail == 1 ? $arrMail['id_fiche'] : 0).",'". $arrMail['alias']."','".$arrMail['from']."','". $arrMail['to']."','". $arrMail['subject']."','".$arrMail['msg']."','". $arrMail['uuid']."',". $typeMail.",'". $d."','". date('Y-m-d')."')";


					$res = QueryExec::querySQL($sql, true);
				}else{
					$res = $searchMail;
				}
			}else{

			}
	
		}
		
		return $res;
	}

	private static function DefaultTemplate()
	{
		return '##MESAGE_BODY##';

		/*
		return '<table width="688" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;" >
			<tr>
				<td width="688" valign="top" style="padding:18px;">
				
					<table width="649" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td  valign="top"><a href="" ><img src="https://renovation-solidaire.org/" border="0" style="width:100px" ></a></td>
						</tr>
						<tr>
							<td valign="top" style="padding:25px;">
								##MESAGE_BODY##
							</td>
						</tr>
					</table>
				</td>
			</tr>
			</table>';*/
	}

	private static function createMail()
	{
		global $usrActif;

		$resapi = API::findOne(array('id_sejour'=>$usrActif->cursoc));

		// echo(print_r($resInfmail));
		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';

		if($resapi->is_mail_api > 0){
			$mail->isSMTP();
			$mail->Host = 'smtp.mailtrap.io'; // Hôte Mailtrap
			$mail->SMTPAuth = true;
			$mail->Username = $resapi->mail_user_api; //'your_username'; // Remplacez par votre username Mailtrap
			$mail->Password = $resapi->mail_key_api; //'your_password'; // Remplacez par votre password Mailtrap
			$mail->SMTPSecure = 'tls'; //PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;
		
			// Informations de l'expéditeur et du destinataire
			$mail->setFrom('sender@example.com', 'Expéditeur');
		}else{
			$resInfmail = InfosGenes::findOneMail(array('inf_mail_actif'=>'1'));
			
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $resInfmail->inf_host; //'pro2.mail.ovh.net '; //'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $resInfmail->inf_username; //'reservation@mhpalace.com' ; //'contact@MHPALACE.fr';                 // SMTP username
			$mail->Password = $resInfmail->inf_password; //'Amerique67000!'; //'Contact2626@';                           // SMTP password
			$mail->SMTPSecure = $resInfmail->inf_protocol; //'tls'; //'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = $resInfmail->inf_port; //587; //465;

			$mail->From = $resInfmail->inf_username; //'reservation@mhpalace.com'; //'contact@MHPALACE.fr';
			$mail->FromName = $resInfmail->inf_mail_name; //'CRYSTAL CLUB';
		}

		// echo(print_r($mail));
		return $mail;
	}

	public static function sendMail($type, $vals)
	{
		switch ($type) 
		{
			case 'mail-contact' :
				//echo('ici');
				$mail = Mailings::createMail();
				//print_r($mail);

				$mail->addAddress($vals->email, $vals->first_name.' '.$vals->last_name);     // Add a recipient
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $vals->subject; 
								
				$mail->Body    = $vals->msg;				
				if (isset($vals->doc) && count($vals->doc) > 0) {
					foreach($vals->doc as $d)
						$mail->addAttachment($d);
				}

				// print_r($mail);
				// die;
				if(!$mail->send()) {
					echo 'Message not sent <br>';
					echo 'Mailer Message Error: ' . $mail->ErrorInfo;
					return false;
				} else {
					//echo 'Message has been sent';
					return true;
				}
				
				break;	

			case 'mail-contact-public' :
				
				$mail = Mailings::createMail();

				$mail->addAddress($vals->email, $vals->first_name.' '.$vals->last_name);     // Add a recipient
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $vals->subject; 
				// str_replace('##MESAGE_BODY##', $vals->msg, Mailings::DefaultTemplate());			
				$mail->Body    = $vals->msg;								
				if (isset($vals->doc) && count($vals->doc) > 0) {
					foreach($vals->doc as $d)
						$mail->addAttachment($d);
				}
				if(!$mail->send()) {
					echo 'Message not sent <br>';
					echo 'Mailer Message Error: ' . $mail->ErrorInfo;
					return false;
				} else {
					//echo 'Message has been sent';
					return true;
				}
				
				break;	

			case 'mail-groupe' :
				
				$mail = Mailings::createMail();
				$mail->addAddress($vals->email, '');
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $vals->subject; 
								
				$mail->Body    = $vals->msg;				
				if (isset($vals->doc) && count($vals->doc) > 0) {
					foreach($vals->doc as $d)
						$mail->addAttachment($d);
				}
				if(!$mail->send()) {
					echo 'Message not sent <br>';
					echo 'Mailer Message Error: ' . $mail->ErrorInfo;
					return false;
				} else {
					//echo 'Message has been sent';
					return true;
				}
				
				break;	

			case 'mail-admin' :
				
				$mail = Mailings::createMail();
				$mail->addAddress($vals->email, 'Mail Administration CRM');
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $vals->subject; 
								
				$mail->Body    = $vals->msg;				
				//	die(print_r($mail,true));	

				if(!$mail->send()) {
					echo 'Message not sent <br>';
					echo 'Mailer Message Error: ' . $mail->ErrorInfo;
					return false;
				} else {
					//echo 'Message has been sent';
					return true;
				}
				
				break;	
		}
	}
	
}



?>