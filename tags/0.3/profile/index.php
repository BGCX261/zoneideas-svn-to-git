<?php
/**
 * @package    zoneideas
 * @subpackage profile
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

/**
 *
 *
 */
ob_start();

include_once("../core.php");

$action = false;


if (isset($_GET["recover"]))
{

  if (!User::Logged()) 
  { 
    //recover password
    if (!empty($_POST["user_email"]))
    {

     if (!$user = User::FindUserByEmail($_POST["user_email"]))
      {
        $error_message = I18n::L("Email not registered");
      }
      else
      {
        $user->user_password = User::GeneratePassword(8);
        
        if(!User::Update($user))
        {
          $error_message = I18n::L("Cannot update user.");
        }
        else
        {
           Notify::NotifyOfLostPassword($user);
           $error_message = I18n::L("New password was sent to your e-mail.");
        }
      }                                 
     }
 
  
     if ((!empty($_POST["password_recovery"])) && (empty($_POST["user_email"])))
     {
       $error_message = I18n::L("Please fill email.");
     }
     
     if (!empty($error_message))
     {
       Viewer::AddData("error_message",$error_message);
     }
     
     Viewer::AddData("title", I18n::L("Password recovery"));
     Viewer::UseTemplate("password_recovery.tpl");
     $action = "password_recovery";
  }
}

elseif ((!RESTRICT_ALL || User::Logged()) && !isset($_GET["recover"])  )
{

  $id = (int)$_SERVER["QUERY_STRING"];

  $user = User::GetById($id);

  if(!empty($id) && $user )
  { 

    //remove user
    if (isset($_GET["removeuser"]))
    {
      if (User::$current->IsAdmin() && !empty($user->user_email) )
      {
        $user->user_password = User::GeneratePassword(8);
        $user->user_email="";
        $user->user_name=$user->user_name."_removed";
    
        if(!User::Update($user))
        {
          $error_message = I18n::L("Cannot update user.");
          $user = User::GetById($id);
        }
        else
        {
          header("Location:".PREFIX."/profile?".$user->user_id);
          exit();
        }
      }
      else
      {
        header("Location:".PREFIX."/profile?".$user->user_id);
        exit();
      }
    }
    Viewer::AddData("user", $user);
    Viewer::AddData("title", I18n::L("Title %s's profile", array($user->user_name)));
    Viewer::AddData("ideas_count",Ideas::GetByUser($user)?sizeof(Ideas::GetByUser($user)):0 );     
    Viewer::AddData("comments_count",Comments::GetByUser($user)?sizeof( Comments::GetByUser($user)):0 );     
    Viewer::UseTemplate("user_profile.tpl");
    $action = "profile";
  
  }
} 
else
{
   Viewer::Restricted();
   $action = "profile";
}


if (!$action) Viewer::RequestError(); 


Viewer::AddData("action",$action);
Viewer::Show();

ob_end_flush();
