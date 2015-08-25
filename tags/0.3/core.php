<?php
/**
 * @package    zoneideas
 * @subpackage core
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();


/**
 *
 * @param string $class_name
 * @return void
 */
function __autoload($class_name) 
{
  if (stristr($class_name,"exception"))
  {
    require_once "include/".'exceptions.class.php';
    Debug::Log("Exceptions loaded!"); 
  }
  else
  {
    require_once "include/".strtolower($class_name) . '.class.php';
    Debug::Log("Class ".$class_name. " loaded!"); 
  }
}


include("settings.php");

// Internal settings (do not modify if you are not sure what you are doing).
$SYSTEM_FOLDERS = array("/idea",
                        "/ideas",
                        "/img",
                        "/include",
                        "/login",
                        "/logout",
                        "/profile",
                        "/dashboard",
                        "/register",
                        "/themes",
                        "/lang");

$out = str_replace($SYSTEM_FOLDERS,"#",$_SERVER["REQUEST_URI"]);

define("PREFIX",strstr($out,'#')!=""?'..':'.');

define("THEME_PREFIX",(strstr($out,'#')!=""?'..':'.')."/themes/".SITE_THEME);

define("REQ_URL",$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);



Server::Normalize();
I18n::Load();

User::$current = Session::Start();

















?>