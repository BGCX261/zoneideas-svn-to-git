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
 * @subpackage database
 *
 *
 */
class DataBaseException extends ZoneIdeasException
{}


/**
 *
 * @subpackage idea
 *
 *
 */
class IdeaException extends ZoneIdeasException
{}

/**
 *
 * @subpackage ideas
 *
 *
 */
class IdeasException extends ZoneIdeasException
{}

/**
 *
 * @subpackage viewer
 *
 *
 */
class ViewerException extends ZoneIdeasException
{}

/**
 *
 * @subpackage user
 *
 *
 */
class UserException extends ZoneIdeasException
{}

/**
 *
 * @subpackage session
 *
 *
 */
class SessionException extends ZoneIdeasException
{}

/**
 *
 * @subpackage comment
 *
 *
 */
class CommentException extends ZoneIdeasException
{}

/**
 *
 * @subpackage comments
 *
 *
 */
class CommentsException extends ZoneIdeasException
{}

/**
 *
 * @subpackage mailer
 *
 *
 */
class MailerException extends ZoneIdeasException
{}

/**
 *
 * @subpackage rate
 *
 *
 */
class RateException extends ZoneIdeasException
{}

/**
 *
 * @subpackage file
 *
 *
 */
class FileException extends ZoneIdeasException
{}
