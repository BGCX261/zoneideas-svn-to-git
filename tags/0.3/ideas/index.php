<?php
/**
 * @package    zoneideas
 * @subpackage ideas
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

/**
 *
 *
 */

 
ob_start();

include_once("../core.php");

$action = false;

if (!RESTRICT_ALL || User::Logged())
{
   if(isset($_GET["top"]))
   {
     Viewer::AddData("ideas",Ideas::GetByRate());
     Viewer::UseTemplate("ideas.tpl");
     Viewer::AddData("title", I18n::L("Title Top Ideas"));
     $action = "top";
   }
   
   
   if(isset($_GET["last"]))
   {
     Viewer::AddData("ideas",Ideas::GetByLastTime());
     Viewer::UseTemplate("ideas.tpl");
     Viewer::AddData("title", I18n::L("Title Last Ideas"));
     $action = "last";
   }
   
   if(isset($_GET["active"]))
   {
     Viewer::AddData("ideas",Ideas::GetByActivity());
     Viewer::UseTemplate("ideas.tpl");
     Viewer::AddData("title", I18n::L("Title Most Active Ideas"));
     $action = "active";
   }
   
   
   if(isset($_GET["summary"]))
   {
     Viewer::AddData("ideas_last",Ideas::GetByLastTime(3));
     Viewer::AddData("ideas_top",Ideas::GetByRate(0,3));
     Viewer::AddData("ideas_active",Ideas::GetByActivity(3));
     Viewer::UseTemplate("summary.tpl");
     Viewer::AddData("title", I18n::L("Title Summary"));
     $action = "summary";
   }
   
   
   if(isset($_GET["search"]))
   {
     $q = $_GET["q"];
     Viewer::UseTemplate("ideas.tpl");
     Viewer::AddData("title","Search Ideas");
     Viewer::AddData("q",$q);
     if (!empty($q)) Viewer::AddData("ideas",Ideas::SearchByTitle($q));
     $action = "search";
   }
  
   
   if(isset($_GET["user"]))
   {
     $user_id = (int) $_GET["user"];
     $user    = User::GetById($user_id);
     Viewer::AddData("ideas",Ideas::GetByUser($user));
     Viewer::AddData("user",$user);
     Viewer::UseTemplate("ideas.tpl");
     Viewer::AddData("title", I18n::L("Title %s's ideas", array($user->user_name)));
     $action = "user";
   }
} /* end if RESTRICT_ALL && User::Logged() */
else
{
  Viewer::Restricted();
  $action = "ideas";
}



if(!$action) Viewer::RequestError();

Viewer::AddData("action",$action);
Viewer::Show();
ob_end_flush();
