<?php
/**
 * @package    zoneideas
 * @subpackage dashboard
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

/**
 *
 *
 */
ob_start();

include_once("../core.php");

$action = false;


if (User::Logged())
{
  Viewer::AddData("ideas",Ideas::GetByUser(User::$current));
  Viewer::AddData("user" ,User::$current);
  Viewer::AddData("title", I18n::L("Title Dashboard"));
  Viewer::UseTemplate("dashboard.tpl");
  $action = "dashboard";
}
else
{
  Viewer::Restricted();
  $action = "restricted";
}


if (!$action) Viewer::RequestError();

Viewer::AddData("action",$action);
Viewer::Show();
ob_end_flush();
