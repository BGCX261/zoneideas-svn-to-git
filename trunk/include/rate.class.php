<?php
/**
 * @package    zoneideas
 * @subpackage rate
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 *
 *
 */
class Rate
{
  public  $rate_id;
  public  $user_id;
  public  $idea_id;


  /**
   *
   * @access public
   * @static
   * @param Idea $idea
   * @param User $user
   * @return Rate|false
   */
  public static function Find($idea,$user)
  {
    $cmd=sprintf("SELECT * FROM zi_rates WHERE idea_id=%d AND user_id=%d", $idea->idea_id, $user->user_id);

    try
    {
      $data = Database::Query($cmd);

      if (empty($data)) throw new RateException("can't get rate");

      $obj = new Rate();

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
   * @param Rate $obj
   * @return Rate|false
   */
  public static function Add ($obj)
  {
    $cmd = sprintf("INSERT INTO zi_rates (user_id,idea_id) VALUES(%d,%d)",
    $obj->user_id,$obj->idea_id);
    try
    {
      if (!Database::Query($cmd,false)) throw new RateException("can't add rate");

      $obj->rate_id=Database::GetLastInsertId();
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
   * @param Idea $idea
   * @param User $user
   * @return Rate
   */
  public static function Create($idea,$user)
  {
    $obj = new Rate();

    $obj->user_id = $user->user_id;
    $obj->idea_id = $idea->idea_id;

    return $obj;
  }
}
