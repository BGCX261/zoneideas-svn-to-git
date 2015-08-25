<?php
/**
 * @package    zoneideas
 * @subpackage register
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

/**
 *
 *
 */

ob_start();

include_once("../core.php");

$action="register";

$error_message = "";


if (User::Logged())
{
  header("Location:".PREFIX."/dashboard/");
  exit();
}


$user_name  = isset($_POST["user_name"])  ? $_POST["user_name"]  :"";
$user_email = isset($_POST["user_email"]) ? $_POST["user_email"] :"";

Viewer::AddData("user_name",$user_name);
Viewer::AddData("user_email",$user_email);



if (!empty($user_name)&&!empty($user_email)&&!empty($_POST["user_password"])&&!empty($_POST["user_password2"]))
{
  if ($_POST["user_password"]!=$_POST["user_password2"])
  {
    $error_message=I18n::L("Passwords mismatch.");
  }
  else
  {
    if (!Support::IsEMail($user_email))
    {
      $error_message=I18n::L("Wrong E-mail address.");
    }
    else
    {
      if (User::FindUser($user_name))
      {
        $error_message=I18n::L("Username &laquo;%s&raquo; is already taken, please find another username.", array($user_name));
      }
      else
      {
        if (User::FindUserByEmail($user_email))
        {
          $error_message=I18n::L("This email &laquo;%s&raquo; is already regesitered, please use another email.", array($user_email));
        }
        else
        {
          $obj=User::Add(User::Create($user_name,$user_email,$_POST["user_password"]));

          if ($obj->user_id)
          {
            Session::StartUser($obj);
            header("Location:".PREFIX."/dashboard/");
            exit;
          }
          else  $error_message=I18n::L("Error while registring user.");  //todo: add some error log
        }
      }
    }
  }
}
else
{
  if (!empty($_POST["register"]))  $error_message=I18n::L("Please fill all required fields.");
}


Viewer::AddData("title", I18n::L("Title Registration"));
Viewer::AddData("error_message",$error_message);




Viewer::UseTemplate("register.tpl");

Viewer::AddData("action", $action);
Viewer::Show();
ob_end_flush();
