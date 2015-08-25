<?php
/**
 * @package    zoneideas
 * @subpackage debug
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 * Some defines for DEBUG
 * 
 * 
 * 
 */
define("DEBUG_FILE_PATH","./debug.log");


define("NOTICE" ,"NOTICE");
define("WARNING","WARNING");
define("ERROR"  ,"ERROR");

/**
 *
 * @package zoneideas
 * @final
 * @static
 */
final class Debug
{
 
  private static $instance;
  private static $last_debug_type   = "screen";
  
  private $log_file          = false;
  private $log_screen        = false;

 
  public static function Init ($debug_type = "")
  {
    self::$instance = new Debug();

    if (empty($debug_type))
    {
       $debug_type = self::$last_debug_type;
    }
       
    if (stristr($debug_type,"file"))
    {
      self::$instance->log_file = true;
    }
    elseif (stristr($debug_type,"screen"))
    {
      self::$instance->log_screen = true;
    }
    
    self::$last_debug_type = $debug_type;
  }
 
 
  public static function Log ($message,$level=NOTICE)
  {
    $data[] = $level;
    $data[] = $message;
    self::WriteLine(self::PrepareLine($data));
  }

 
  private static function PrepareLine ($data)
  {
    $line = date("c");
    $line.= " ";
    
 //   $debug_calls = debug_backtrace();
 //   $file_name = basename($debug_calls[sizeof($debug_calls)-1]["file"]);
 //   $file_line = $debug_calls[sizeof($debug_calls)-1]["line"] ;

 //   $line.= sprintf("%-8s%'04d,%s %s ",$data[0],$file_line,$file_name,$data[1]);
      $line.= sprintf("%-8s %s ",$data[0],$data[1]);


    return $line;
  }


  private static function WriteLine ($data)
  {
    if (!DEBUG) return 0;

    if (empty(self::$instance))
       self::Init();
    
    if (self::$instance->log_file)
       file_put_contents(DEBUG_FILE_PATH,$data."\r\n",FILE_APPEND);

    if (self::$instance->log_screen)
       echo "<pre>".$data."</pre>";
  }


  public static function GetType()
  {
    return empty(self::$instance)?"none":self::$last_debug_type;
  }

}
