<?php
/**
 * @package    zoneideas
 * @subpackage settings
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * @final
 */
final class Settings
{

 public static $mysql_host     = MYSQL_HOST;
 public static $mysql_database = MYSQL_DATABASE;
 public static $mysql_user     = MYSQL_USER;
 public static $mysql_password = MYSQL_PASSWORD;


 public static $page_templates_path  = "/views/";
 public static $mail_templates_path  = "/views/mail/";

 public static $admin_user = ADMIN_USER;
}

 

