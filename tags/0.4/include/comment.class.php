<?php
/**
 * @package    zoneideas
 * @subpackage comment
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 *
 *
 */
class Comment
{
  public  $comment_id;
  public  $comment_date;
  private $comment_text;
  public  $user_id;
  public  $idea_id;


  /**
   *
   * @access public
   * @static
   * @param $id integer
   * @return Comment|false
   */
  public static function GetById($id)
  {
    $cmd = sprintf("SELECT * FROM zi_comments WHERE comment_id=%d",$id);

    try
    {
      $data = Database::Query($cmd);

      if (empty($data)) throw new CommentException("can't get comment");

      $obj = new Comment();

      foreach ($data[0] as $key=>$value)
      {
        $obj->$key = $value;
      }
    }
    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }

    return $obj;
  }


  /**
   *
   * @access public
   * @static
   * @param Comment $obj
   * @return Comment|false
   */
  public static function Add ($obj)
  {
    $cmd = sprintf("INSERT INTO zi_comments (comment_date,user_id,comment_text,idea_id) VALUES(%d,%d,'%s',%d)",
    $obj->comment_date,$obj->user_id,$obj->GetText(),$obj->idea_id);

    try
    {
      if (!Database::Query($cmd,false)) throw new CommentException("can't add comment");

      $obj->comment_id = Database::GetLastInsertId();
    }

    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;

    }
    return $obj;
  }


  /**
   *
   * @access public
   * @param string $text
   * @param Idea $idea
   * @param User $user
   * @static
   * @return Comment
   */
  public static function Create($text,$idea,$user)
  {
    $obj = new Comment();

    $obj->SetText($text);
    $obj->user_id       = $user->user_id;
    $obj->comment_date  = time();
    $obj->idea_id       = $idea->idea_id;

    return $obj;
  }


  /**
   *
   * @access public
   * @param bool $decoded
   * @return string
   */
  public function GetText($decoded = false)
  {
    if (!$decoded)
    return $this->comment_text;
    else
    return base64_decode($this->comment_text);
  }


  /**
   *
   * @access public
   * @param string $text
   * @return void
   */
  public function SetText($text)
  {
    $this->comment_text = base64_encode(Support::SafeTags($text)) ;
  }


  /**
   *
   * @access public
   * @param Comment $comment
   * @param User $user
   * @return bool
   */
  public static function Remove($comment,$user)
  {
    try
    {
      if ($user->user_id==$comment->user_id || $user->IsAdmin())
      {
        $cmd=sprintf("DELETE FROM zi_comments WHERE comment_id=%d;",$comment->comment_id);

        if (!Database::Query($cmd,false)) throw new IdeaException("can't remove comment - database problem");
      }
      else
      {
        throw new IdeaException("can't remove comment - user is not an owner of the comment ");
      }
    }
    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }
    return true;
  }
}
