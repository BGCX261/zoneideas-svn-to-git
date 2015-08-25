<?php
/**
 * @package    zoneideas
 * @subpackage index
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

/**
 *
 *
 */

ob_start();

include("core.php");








Viewer::AddData("title","Home");
Viewer::UseTemplate("front.tpl");
Viewer::Show();

ob_end_flush();
