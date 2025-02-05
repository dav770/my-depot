<?php

/**
 * @author Florent Viel
 */
class MailAttachmentManager
{
  /**
   * @var string host
   */
  private $host;

  /**
   * @var string login
   */
  private $login;

  /**
   * @var string password
   */
  private $password;

  /**
   * @var string répertoire de sauvegarde
   */
  private $saveDirPath;

  /**
   * @var object boite mail
   */
  private $mbox;

  /**
   * Constructeur
   * @param string $host {host:port\params}BOX voir http://fr.php.net/imap_open
   * @param string $login
   * @param string $password
   * @param string $saveDirPath chemin de sauvegarde des pièces jointes
   */
  public function __construct($host, $login, $password, $saveDirPath = './')
  {
    $this->host = $host;
    $this->login = $login;
    $this->password = $password;
    $this->saveDirPath = $savedirpath = substr($saveDirPath, -1) == "/" ? $saveDirPath : $saveDirPath."/";
  }

  /**
   * Décode le contenu du message
   * @param string $message message
   * @param integer $coding type de contenu
   * @return message décodé
   **/
  private function getDecodeValue($message, $coding)
  {
    switch ($coding) {
      case 0: //text
      case 1: //multipart
        $message = imap_8bit($message);
        break;
      case 2: //message
        $message = imap_binary($message);
        break;
      case 3: //application
      case 5: //image
      case 6: //video
      case 7: //other
        $message = imap_base64($message);
        break;
      case 4: //audio
        $message = imap_qprint($message);
        break;
    }

    return $message;
  }

  /**
   * Ouvrir la boîte mail
   */
  public function openMailBox()
  {
    $mbox = imap_open($this->host, $this->login, $this->password);
    if (!$mbox) {
      throw new Exception("can't connect: ".imap_last_error());
    }

    $this->mbox = $mbox;
  }

  /**
   * Ferme la boite mail en cours
   */
  public function closeMailBox()
  {
    imap_close($this->mbox);
  }

  /**
   * Récupère les parties d'un message
   * @param object $structure structure du message
   * @return object|boolean parties du message|false en cas d'erreur
   */
  public function getParts($structure)
  {
    return isset($structure->parts) ? $structure->parts : false;
  }

  /**
   * Tableau définissant la pièce jointe
   * @param object $part partie du message
   * @return object|boolean définition du message|false en cas d'erreur
   */
  public function getDParameters($part)
  {
    return $part->ifdparameters ? $part->dparameters : false;
  }

  /**
   * Récupère les pièces d'un mail donné
   * @param integer $jk numéro du mail
   * @return array type, filename, pos
   */
  public function getAttachments($jk)
  {
    $structure = imap_fetchstructure($this->mbox, $jk);
    $parts = $this->getParts($structure);
    $fpos = 2;
    $attachments = array();

    if ($parts && count($parts)) {
      for ($i = 1; $i < count($parts); $i++) {
        $part = $parts[$i];

        if ($part->ifdisposition && strtolower($part->disposition) == "attachment") {
          $ext=$part->subtype;
          $params = $this->getDParameters($part);

          if ($params) {
            $filename = $part->dparameters[0]->value;
            $filename = imap_utf8($filename);
            $attachments[] = array('type' => $part->type, 'filename' => $filename, 'pos' => $fpos);
          }
        }
        $fpos++;
      }
    }

    return $attachments;
  }

  /**
   * Retourne la référence de l'hôte sans la boite mail
   * @return string {host:port\params} voir http://fr.php.net/imap_open
   */
  public function getRef()
  {
    preg_match('#^{[^}]*}#', $this->host, $ref);
    return $ref[0];
  }

  /**
   * Retourne la liste des boites mail associées a celle ouverte
   * @param string $pattern motif de recherche
   * @return array liste des boites mail
   */
  public function getList($pattern = '*')
  {
    return imap_list($this->mbox, $this->getRef(), $pattern);
  }

  /**
   * Récupère la contenu de la pièce jointe par rapport a sa position dans un mail donné
   * @param integer $jk numéro du mail
   * @param integer $fpos position de la pièce jointe
   * @param integer $type type de la pièce jointe
   * @return mixed data
   */
  public function getFileData($jk, $fpos, $type)
  {
    $mege = imap_fetchbody($this->mbox, $jk, $fpos);
    $data = $this->getDecodeValue($mege,$type);

    return $data;
  }

  /**
   * Sauvegarde de la pièce jointe dans le dossier défini avec un nom unique
   * @param string $filename nom du fichier
   * @param mixed $data contenu à sauvegarder
   * @return string emplacement du fichier
   **/
  public function saveAttachment($filename, $data)
  {
    $filepath = $this->saveDirPath.$filename;
    $tmp = explode('.', $filename);
    $ext = array_pop($tmp);
    $filename = implode('.', $tmp);
    $i=1;

    while (file_exists($filepath)) {
      $filepath = $this->saveDirPath.$filename.$i.'.'.$ext;
      $i++;
    }

    $fp = fopen($filepath, 'w');
    fputs($fp, $data);
    fclose($fp);

    return $filepath;
  }

  /**
   * Tag un message avec le flag delete
   * @param integer $jk numéro du message
   **/
  public function tagDeleteMessage($jk)
  {
    imap_delete($this->mbox, $jk);
  }

  /**
   * Supprime les messages tagués avec le flag delete
   **/
  public function deleteTaggedMessages()
  {
    imap_expunge($this->mbox);
  }

  /**
   * Retourne la boite mail
   * @return object boite mail
   */
  public function getMbox()
  {
    return $this->mbox;
  }

  /**
   * Retourne le destinataire du message
   * @param integer $id numéro du mail
   * @return string mail
   */
  public function getMessageTo($id)
  {
    $header = imap_fetchheader($this->mbox, $id);
    $header = imap_rfc822_parse_headers($header);
    return $header->to[0]->mailbox.'@'.$header->to[0]->host;
  }

  /**
   * Retourne l'emmetteur du message
   * @param integer $id numéro du mail
   * @return string mail
   */
  public function getMessageFrom($id)
  {
    $header = imap_fetchheader($this->mbox, $id);
    $header = imap_rfc822_parse_headers($header);
    return $header->from[0]->mailbox.'@'.$header->from[0]->host;
  }
}
