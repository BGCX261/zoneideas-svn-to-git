<?php
/**
 * @package    zoneideas
 * @subpackage support
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * @final
 */
final class Support
{

  /**
   * 
   * @static
   * @return boolean     
   */
  public static function IsEmail($email) 
  {
    if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) ) 
    { 
      return true;
    }
    else 
    { 
      return false;
    }
  }


  /**
   * 
   * @static
   * @return boolean     
   */
  public static function IsInQuery($str)
  {
    return stristr($_SERVER["REQUEST_URI"],$str) ;
  }


  /**
   * 
   * @static
   * @return string     
   */
  public static function Snippet($text,$length=64,$tail="...") 
  {
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
   }


  /**
   * 
   * @static
   * @return string     
   */
  public static function SafeTags($data)
  {
    return strip_tags($data, VALID_HTML_TAGS); 
  }

}
