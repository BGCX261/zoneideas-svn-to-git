<?php
/**
 * @package    zoneideas
 * @subpackage I18n
 * @author     Mathieu Lory <lory@zoneideas.org>
 */


if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * @final
 */
final class I18n
{
  private static $language;
  
  /**
   * get the language string $key
   * return string
   */
  public function L($key, $array=NULL)
  {
    if (empty($key))
    {
      Debug::Log("Key undefined");
      return '';
    }
    if (isset(self::$language[$key]) && !is_array($array))
    {
      return self::$language[$key];
    }
    else if (isset(self::$language[$key]) && is_array($array))
    {
      return vsprintf(self::$language[$key], $array);
    }
    else
    {
      Debug::Log("Key '".$key."' need to be translated into ".LANG);
      return "[[$key]]";
    }
  }
  

  public static function Load()
  {
    $file = PREFIX . "/lang/".LANG.".php";

    if (is_readable($file))  require($file);
    else require(PREFIX . "/lang/en.php"); /* default system language */

    self::$language = $lang;
    
    Debug::Log("Language '".LANG."', file : '".$file)."'";
  }
}
