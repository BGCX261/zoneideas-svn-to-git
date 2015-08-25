<?php
/**
 * @package    zoneideas
 * @subpackage notify
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 *
 *
 */
class Notify
{

  /**
   *
   * @access private
   * @param string $name
   * @return File
   */
  private function ReadNotifyTemplate($name)
  {
    $objTemplate = new file(THEME_PREFIX.Settings::$mail_templates_path.$name.'.tpl');

    return $objTemplate->Read();
  }


   
  /**
   *
   * @access private
   * @param mixed $notify_data
   * @param string $template_content
   * @return string
   */
  private function ParseNotifyTemplate($notify_data,$template_content)
  {
    foreach ($notify_data as $search => $replace)
    {
      $template_content = str_replace('%'.$search.'%', $replace, $template_content);
    }
    return $template_content;
  }

  /**
   *
   * @access public
   * @param string $email_to
   * @param string $email_subject
   * @param string $email_body
   * @param string $email_from_name
   * @param string $email_from
   * @return void
   */
  private function SendEmail ($email_to,$email_subject,$email_body,$email_from_name,$email_from)
  {
    $mailer = new Mailer();
    $mailer->prepareMail( $email_to,
    $email_subject,
    $email_body,
    $email_from_name,
    $email_from       );
     
    $mailer->send();
  }

  /**
   *
   * @access public
   * @static
   * @param User $owner
   * @param User $user
   * @param Idea $idea
   * @param Comment $comment
   * @return void
   */
  public static function NotifyOfIdeaComment($owner,$user,$idea,$comment)
  {
    $comment_lastnumber = $idea->comments_count;

    $notify_title = "{$user->user_name}"." commented your idea#{$idea->idea_id}";

    $notify_content = self::ReadNotifyTemplate("idea_new_comment");

    $notify_data = array (
      'IDEA_TITLE'       => $idea->idea_title,
      'IDEA_ID'          => $idea->idea_id,
      'COMMENT_NUMBER'   => $comment_lastnumber,
      'COMMENT_DATE'     => date("F d, Y \\a\\t H:i",$comment->comment_date),
      'BASE_TITLE'       => BASE_TITLE,
      'SITE_HOST'        => SITE_HOST,
      'USER_NAME'        => $user->user_name,
      'USER_COMMENT'     => $comment->GetText(true)
    );

    $notify_content= self::ParseNotifyTemplate($notify_data,$notify_content);

    //mail notify
    if (!empty($owner->user_email)) self::SendEmail ($owner->user_email,$notify_title,$notify_content,BASE_TITLE."","robot@".SITE_HOST);

    //todo:sms notify
    //todo:jaiku//twitter notify

  }

  /**
   *
   * @access public
   * @static
   * @param User $owner
   * @param User $user
   * @param Idea $idea
   * @param Comment $comment
   * @param bool $rate_plus
   * @return void
   */
  public static function NotifyOfIdeaRate($owner,$user,$idea,$comment,$rate_plus)
  {
    $comment_lastnumber = $idea->comments_count;

    $rate = $rate_plus?"up":"down";

    $notify_title = "{$user->user_name}"." rated {$rate} your idea#{$idea->idea_id}";

    $notify_content = self::ReadNotifyTemplate("idea_new_rate");

    $notify_data = array (
      'IDEA_TITLE'       => $idea->idea_title,
      'IDEA_ID'          => $idea->idea_id,
      'COMMENT_NUMBER'   => $comment_lastnumber,
      'COMMENT_DATE'     => date("F d, Y \\a\\t H:i",$comment->comment_date),
      'BASE_TITLE'       => BASE_TITLE,
      'SITE_HOST'        => SITE_HOST,
      'RATE'             => $rate,
      'USER_NAME'        => $user->user_name,
      'USER_COMMENT'     => $comment->GetText(true)
    );

    $notify_content= self::ParseNotifyTemplate($notify_data,$notify_content);

    //mail notify
    if (!empty($owner->user_email)) self::SendEmail ($owner->user_email,$notify_title,$notify_content,BASE_TITLE."","robot@".SITE_HOST);
  }

  /**
   *
   * @access public
   * @static
   * @param User $user
   * @return void
   */
  public static function NotifyOfLostPassword ($user)
  {
    $notify_title = BASE_TITLE." password recovery";

    $notify_content = self::ReadNotifyTemplate("password_recovery");

    $notify_data = array (
      'USER_PASSWORD'    => $user->user_password,
      'BASE_TITLE'       => BASE_TITLE,
      'SITE_HOST'        => SITE_HOST,
      'USER_NAME'        => $user->user_name
    );

    $notify_content= self::ParseNotifyTemplate($notify_data,$notify_content);

    //mail notify
    self::SendEmail ($user->user_email,$notify_title,$notify_content,BASE_TITLE."","robot@".SITE_HOST);
  }
}
