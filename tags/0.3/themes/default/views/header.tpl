<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?php echo Viewer::Value("title")." - ".BASE_TITLE ?></title>
  <link rel="stylesheet" type="text/css"  href="<?php echo THEME_PREFIX?>/style.css">
  <link rel="shortcut icon" href="<?php echo PREFIX?>/favicon.ico" type="image/x-icon">
  <link rel="icon" href="<?php echo PREFIX?>/favicon.ico" type="image/x-icon">
</head>
<body>

<!-- begin of header -->

<div id="up_part">
<div id="top_line">

<a <?php if (Viewer::Value("title")!="Home"): ?> href="<?php echo PREFIX?>/" <?php endif;?> title="Home" id="site_name" ><?php echo SITE_NAME?></a>

         <?php if(!User::Logged()): ?>
          <a <?php if(!Support::IsInQuery("login")):?>      href="<?php echo PREFIX?>/login/"     <?php else:?> style="font-weight:bold"     <?php endif;?>><?php echo I18n::L("Login")?></a> |
          <a <?php if(!Support::IsInQuery("register")):?>   href="<?php echo PREFIX?>/register/"  <?php else:?> style="font-weight:bold"     <?php endif;?>><?php echo I18n::L("Register")?></a> 
         <?php else:?>


          <?php if (User::$current->IsAdmin()): ?>Admin&nbsp;|&nbsp;<?php endif; ?>
          <?php echo User::$current->user_name;?>&nbsp;|&nbsp;
          <a <?php if(!Support::IsInQuery("dashboard")):?>  href="<?php echo PREFIX?>/dashboard/" <?php else:?> style="font-weight:bold"     <?php endif;?>><?php echo I18n::L("Dashboard")?></a>&nbsp;|&nbsp;
          <a href="<?php echo PREFIX?>/logout/"><?php echo I18n::L("Logout")?></a><br>
         <?php endif?>

</div>


<!-- end of header -->
<?php include("menu.tpl")?>