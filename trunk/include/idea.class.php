<?php
/**
 * @package    zoneideas
 * @subpackage idea
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 *
 *
 */
class Idea
{
  public  $idea_id;
  public  $idea_title;
  public  $idea_date;
  public  $idea_rate;
  private $idea_desc;
  public  $user_id;
  public  $comments_count;


  /**
   *
   * @access public
   * @static
   * @param integer $id
   * @return Idea|false
   */
  public static function GetById($id)
  {
    $cmd=sprintf("SELECT * FROM zi_ideas WHERE idea_id=%d",$id);

    try
    {
      $data = Database::Query($cmd);
       
      if (empty($data)) throw new IdeaException("can't get idea");

      $obj = new Idea();

      foreach ($data[0] as $key=>$value)
      {
        $obj->$key = $value;
      }

      $obj->comments_count = Comments::GetCountByIdea($obj);
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
   * @param Idea $obj
   * @return Idea|false
   */
  public static function Add ($obj)
  {

    $cmd = sprintf("INSERT INTO zi_ideas (idea_title,idea_date,user_id,idea_rate,idea_desc) VALUES('%s',%d,%d,%d,'%s')",
    $obj->idea_title,$obj->idea_date,$obj->user_id,$obj->idea_rate,$obj->GetDesc());

    try
    {
      if (!Database::Query($cmd,false)) throw new IdeaException("can't add idea");
      $obj->idea_id=Database::GetLastInsertId();
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
   * @static
   * @param string $title
   * @param string $desc
   * @param User $user
   * @return Idea
   */
  public static function Create($title,$desc,$user)
  {
    $obj = new Idea();

    $obj->idea_title = Database::SafeData(Support::SafeTags($title));
    $obj->user_id    = $user->user_id;
    $obj->SetDesc($desc);
    $obj->idea_date  = time();
    $obj->idea_rate  = 0;
     
    return $obj;

  }


  /**
   *
   * @access public
   * @static
   * @param Idea $idea
   * @param User $user
   * @return bool
   */
  public static function Remove($idea,$user)
  {
    try
    {
      if ($user->user_id==$idea->user_id || $user->IsAdmin())
      {
        $cmd=sprintf("DELETE FROM zi_ideas WHERE idea_id=%d;",$idea->idea_id);

        if (!Database::Query($cmd,false)) throw new IdeaException("can't remove idea - database problem");

        $cmd=sprintf("DELETE FROM zi_comments WHERE idea_id=%d;",$idea->idea_id);

        if (!Database::Query($cmd,false)) throw new IdeaException("can't remove idea comments - database problem");

        $cmd=sprintf("DELETE FROM zi_rates WHERE idea_id=%d;",$idea->idea_id);

        if (!Database::Query($cmd,false)) throw new IdeaException("can't remove idea rates - database problem");
      }
      else
      {
        throw new IdeaException("can't remove idea - user is not a owner of the idea ");
      }
    }
    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }
    return true;
  }


  /**
   *
   * @access public
   * @static
   * @param Idea $idea
   * @parm User $user
   * @return bool
   */
  public static function RatePlus($idea,$user)
  {
    $cmd=sprintf("UPDATE zi_ideas SET idea_rate=%d WHERE idea_id=%d",$idea->idea_rate+=1,$idea->idea_id);

    try
    {
      if (!Database::Query($cmd,false)) throw new IdeaException("can't rate plus idea");
      Rate::Add(Rate::Create($idea,$user));
    }

    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
    return true;
  }


  /**
   *
   * @access public
   * @static
   * @param Idea $idea
   * @parm User $user
   * @return bool
   */
  public static function RateMinus($idea,$user)
  {
    $cmd=sprintf("UPDATE zi_ideas SET idea_rate=%d WHERE idea_id=%d",$idea->idea_rate-=1,$idea->idea_id);
    try
    {
      if (!Database::Query($cmd,false)) throw new IdeaException("can't rate minus idea");
      Rate::Add(Rate::Create($idea,$user));
    }

    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
    return true;
  }


  /**
   *
   * @access public
   * @param bool $decoded
   * @return string
   */
  public function GetDesc($decoded=false)
  {
    if (!$decoded)
    return $this->idea_desc;
    else
    return base64_decode($this->idea_desc);
  }


  /**
   *
   * @access public
   * @param string $desc
   * @return void
   */
  public function SetDesc($desc)
  {
    $this->idea_desc = base64_encode(Support::SafeTags($desc));
  }
}
