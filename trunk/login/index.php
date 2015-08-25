<?php
/**
 * @package    zoneideas
 * @subpackage idea
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

/**
 *
 *
 */
ob_start();

include_once("../core.php");

$action = "login";

if (!empty($_POST["login"]))
{
  if (!empty($_POST["user_name"]) && !empty($_POST["user_password"]))
  {
    $obj=User::CheckUser($_POST["user_name"],$_POST["user_password"]);
    User::$current = Session::StartUser($obj);
  }
  else
  {
    $error_message = I18n::L("Please fill all required fields.");
  }
}



if (User::Logged())
{
  header("Location:".PREFIX."/dashboard/");
  exit();
}



if (!empty($_POST["login"]) && !User::Logged() )
{
  if(empty($error_message)) $error_message = I18n::L("Wrong password.");
  Viewer::AddData("error_message",$error_message);
  Viewer::AddData("user_name",$_POST["user_name"]);
}




Viewer::AddData("title", I18n::L("Title Login"));
Viewer::UseTemplate("login.tpl");
Viewer::AddData("action",$action);
Viewer::Show();
ob_end_flush();