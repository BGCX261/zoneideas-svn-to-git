<?php
/**
 * @package    zoneideas
 * @subpackage settings
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();



// Settings for your database (MySQL  is only supported for now) .
define("MYSQL_HOST",     "localhost" );   // host name
define("MYSQL_DATABASE", "zoneideas" );   // database name
define("MYSQL_USER",     "" );            // database user
define("MYSQL_PASSWORD", "" );            // database password 


// Site name 
define("SITE_NAME", "ZoneIdeas");

// First Part of the title (shown on every page title).
define("BASE_TITLE", "ZoneIdeas");

// Your public site address, used for sending links in notifiations emails etc.
define("SITE_HOST", "zoneideas.mydomain.com");

// Theme
define("SITE_THEME", "default");

// Language
define("LANG", "en");

// Switch to true or false : true means that users have to be logged to view ideas ; false means everybody could view ideas.
define("RESTRICT_ALL", false);

// Webmaster e-mail (used to send errors and notifications). //not used now
define("ADMIN_EMAIL", "report@zoneideas.org");

// Receive error notifications via e-mail. //not used now
define("MAIL_NOTIFICATION", true);

// Specify tags allowed in comments and ideas 
define ("VALID_HTML_TAGS","<a><img><b><i><u><sup><sub>");

// Specify exsiting user for admin rights (not case sensitive)
define("ADMIN_USER","Shtirlic");

// Debug switch. Set it to true for output additional debug information.
define("DEBUG", false);

// ZoneIdeas current version
define("ZI_VERSION", "0.3");
