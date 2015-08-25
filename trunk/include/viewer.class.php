<?php
/**
 * @package    zoneideas
 * @subpackage viewer
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 *
 * @final
 */
final class Viewer
{

  private static $data_items=array();
  private static $template;


  /**
   *
   * @static
   * @param string $data_name
   * @param mixed $data
   * @return void
   */
  public static function AddData($data_name,$data)
  {
    self::$data_items[strtolower($data_name)] = $data;
  }


  /**
   *
   * @static
   * @param string $data_name
   * @return mixed|false
   */
  public static function Value($data_name)
  {
    try
    {
      if (!array_key_exists(strtolower($data_name),self::$data_items)) throw new ViewerException("value of data element is empty or not exist");
    }
    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }
    return self::$data_items[strtolower($data_name)];
  }


  /**
   *
   * @static
   * @param string $filename
   * @return void
   */
  public static function UseTemplate($filename)
  {
    self::$template = $filename;
  }


  /**
   *
   * @static
   * @param string $filename
   * @return bool
   */
  public static function CheckTemplate($filename="")
  {
    try
    {
      if (empty($filename))
      {
        $objTemplate   =  new file(THEME_PREFIX.Settings::$page_templates_path.self::$template);
        return $objTemplate->Exists();
      }
      else
      {
        $objTemplate   =  new file(THEME_PREFIX.Settings::$page_templates_path.$filename);
        return $objTemplate->Exists();
      }
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
   * @static
   * @return bool
   */
  public static function Show()
  {
    try
    {
      if (!self::CheckTemplate())  throw new ViewerException("can't parse template") ;

      $path = THEME_PREFIX.Settings::$page_templates_path.self::$template;

      include ($path);

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
   * @static
   * return void
   */
  public static function RequestError()
  {
    Viewer::AddData("title","Bad Request");
    Viewer::UseTemplate("request_error.tpl");
  }


  /**
   *
   * @static
   * return void
   */
  public static function Restricted()
  {
    Viewer::AddData("title","Restricted");
    Viewer::UseTemplate("unregistered.tpl");
  }
}
