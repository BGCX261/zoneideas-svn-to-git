<?php
/**
 * @package    zoneideas
 * @subpackage database
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * @final
 * @static
 */
final class Database
{

  private static $db_connection;


  /**
   *
   * @access public
   * @static
   * @return bool
   */
  public static function Init()
  {
    try
    {
      self::$db_connection=@mysql_connect(Settings::$mysql_host,Settings::$mysql_user,Settings::$mysql_password);
      @mysql_select_db(Settings::$mysql_database,self::$db_connection);

      if (mysql_error()) throw new DatabaseException(mysql_error());
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
   * @param string $cmd
   * @param bool $force_result
   * @return mixed|bool
   */
  public static function Query($cmd,$force_result=true)
  {
    if (empty(self::$db_connection)) if(!self::Init()) return false;

    try
    {
      $res = @mysql_query($cmd,self::$db_connection);
       
      if (mysql_error()) throw new DatabaseException(mysql_error());
    }

    catch  (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }

    if ($force_result)
    return self::PrepareData($res);
    else
    return true;
  }


  /**
   *
   * @access private
   * @static
   * @param mixed $res
   * @return mixed|false
   */
  private static function PrepareData($res)
  {
    try
    {
      if (!@mysql_num_rows($res)) throw new DataBaseException("result empty!");

      $i = 0;

      while ($row=@mysql_fetch_assoc($res))
      {
        foreach ($row as $key=>$value)
        {
          $data[$i][$key]=($value);
        }
        $i++;
      }
    }

    catch  (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }
    return $data;
  }


  /**
   *
   * @access public
   * @static
   * @return integer|false
   */
  public static function GetLastInsertId()
  {
    if (empty(self::$db_connection)) if(!self::Init()) return false;

    try
    {
      $id = @mysql_insert_id(self::$db_connection);

      if (mysql_error())  throw new DatabaseException(mysql_error());
    }
    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
    return $id;
  }



  /**
   *
   * @access public
   * @static
   * @param string $data
   * @return string|false
   */
  public static function SafeData ($data)
  {
    if (empty(self::$db_connection)) if(!self::Init()) return false;

    return @mysql_real_escape_string($data,self::$db_connection);
  }
}
