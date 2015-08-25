<?php
/**
 * @package    zoneideas
 * @subpackage mailer
 * @author     Petr Kalis <petr.kalis@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * 
 */

class Mailer
{
  public $to;
  public $cc;
  public $bcc;
  public $subject;
  public $content;
  public $type;
  public $fromName;
  public $fromEmail;
 // public $replyemail;
  
  private $header;
  private $characterSet = 'utf8';

  /**
   * class constructor
   */
  public function __construct()
  {   
    $this->to = array();
    $this->cc = array();
    $this->bcc = array();
   
    $this->subject = '';
    $this->header = '';
    $this->content = '';
   
    $this->fromName = '';
    $this->fromEmail = '';
    $this->replyEmail = '';
   
    $this->type = 'text/plain';//for now
  }
  
  public function setCharset($charset)
  {
    $this->charSet = $charset;
  }

  public function prepareMail($to,$subject,$content,$fromname = 'anonymous',$fromemail = '',$cc = array(),$bcc = array())
  {
    $this->to        = $to;
    $this->subject   = $subject;
    $this->content   = $content;
    $this->fromName  = $fromname;
    $this->fromEmail = $fromemail;
    $this->cc        = $cc;
    $this->bcc       = $bcc;
    
    $this->setHeader();   
  }
  
  
  public function isPrepared()
  {
    if ((count($this->to) < 1)||(empty($this->fromEmail)))  return false;

    return true;
  }

  public function setHeader()
  {
    $from    = "From: ".$this->fromName ."<".$this->fromEmail.">\r\n";
    $replay  = "Reply-To: $this->replyEmail\r\n";    
    $params  = "MIME-Version: 1.0\r\n";
    $params .= "Content-type: $this->type; charset=$this->characterSet\r\n";
  
    $this->header = $from.$replay.$params;
  }
  
  private function isSetHeader()
  {
    return (!empty($this->header));
  }
  

  public function send()
  {
    if (!$this->isSetHeader()) $this->setHeader();      

    try
    {
      if (empty($this->to)) throw new MailerException("no recipient of email");
    }
     
    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    } 
   
    try
    {
      if (!@mail($this->to,$this->subject,$this->content,$this->header)) throw new MailerException("mail function error");
    }
    
    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }
     
    return true;
  }

}
