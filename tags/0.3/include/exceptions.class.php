<?php
/**
 * @package    zoneideas
 * @subpackage exceptions
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * 
 */
class ZoneIdeasException extends Exception
{
   public function __construct($text)
   {
      /**
       * @todo pedro alves: make email system
       */
   }
   /**
    * @access public
    * @return string
    */
   public function __toString()
   {
      return "[".get_class($this)."] in ". basename($this->file).",{$this->line} - {$this->message}"."\r\n".$this->GetTraceAsString();
   }
}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class DataBaseException extends ZoneIdeasException
{}


/**
 *
 * @package zoneideas
 * 
 * 
 */
class IdeaException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class IdeasException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class ViewerException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class UserException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class SessionException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class CommentException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class CommentsException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class MailerException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class RateException extends ZoneIdeasException
{}

/**
 *
 * @package zoneideas
 * 
 * 
 */
class FileException extends ZoneIdeasException
{}
