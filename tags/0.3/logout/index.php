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


User::Logout();



header("Location:".PREFIX."/");
ob_end_flush();
