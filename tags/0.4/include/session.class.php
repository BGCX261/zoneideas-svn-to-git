<?php
/**
 * @package    zoneideas
 * @subpackage session
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 *
 * @final
 */
final class Session
{

  /**
   * @access public
   * @static
   * @return User
   */
  public static function Start()
  {
    session_start();
    Server::UnregisterGlobals('_SESSION');

    if (empty($_SESSION["user_id"]))
    return User::GetById(0);
    else
    return User::GetById($_SESSION["user_id"]);
  }


  /**
   * @access public
   * @static
   * @param User $obj
   * @return User
   */
  public static function StartUser($obj)
  {
    $ssid = session_id();
    if(empty($ssid))  session_start();

    Server::UnregisterGlobals('_SESSION');
    $_SESSION["user_id"] = $obj->user_id;

    return $obj;
  }
}
