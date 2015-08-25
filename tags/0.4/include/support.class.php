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
   * @param string $email
   * @return bool
   */
  public static function IsEmail($email)
  {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    return false;
    else
    return true;
  }


  /**
   *
   * @static
   * @param string $str
   * @return bool
   */
  public static function IsInQuery($str)
  {
    return stristr($_SERVER["REQUEST_URI"],$str) ;
  }


  /**
   *
   * @static
   * @param string $text
   * @param integer $length
   * @param string $tail
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
   * @param string $data
   * @return string
   */
  public static function SafeTags($data)
  {
    return strip_tags($data, VALID_HTML_TAGS);
  }

}
