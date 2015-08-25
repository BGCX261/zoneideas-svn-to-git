<?php
/**
 * @desc       Normalize server settings to the recomended default when required for security or stability.      
 * @package    zoneideas
 * @subpackage server
 * @author     Jarred Freeman
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

 /**  
  * Call Server::Normalize();
  * 
  * after session_start()  
  * Call Server::UnregisterGlobals('_SESSION'); 
  *   
  */
class Server 
{

  /**  
   * Unregister global variables if server has register_globals on
   * 
   * UnregisterGlobals('_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
   * //called after session_start() 
   * UnregisterGlobals('_SESSION');  
   * @access public
   * @static
   */  
  public static function UnregisterGlobals()
  {
    if (!ini_get('register_globals'))
    {
      return false;
    }

    foreach (func_get_args() as $name)
    {
      foreach ($GLOBALS[$name] as $key=>$value)
      {
        if (isset($GLOBALS[$key]))  unset($GLOBALS[$key]);
      }
    }     
  }
  
  /**  
   * Undo magic quotes if magic_quotes_gpc enabled
   * 
   * @access private
   * @static
   * @return void
   */  
  private static function UndoMagicQuotes()
  {
    set_magic_quotes_runtime(0);
    
    if (get_magic_quotes_gpc()) 
    {
      $in = array(&$_GET, &$_POST, &$_COOKIE);
      while (list($k,$v) = each($in)) 
      {
        foreach ($v as $key => $val) 
        {
          if (!is_array($val)) 
          {
            $in[$k][$key] = stripslashes($val);
            continue;
          }
          $in[] =& $in[$k][$key];
        }
      }
      unset($in);
    }
  }
  
  
  /**
  * Invokes class functions
  * 
  * @access public
  * @static
  8 @return void
  */
  public static function Normalize()
  {
    self::UnregisterGlobals('_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
    self::UndoMagicQuotes();
  }    

}
