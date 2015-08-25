<?php include("header.tpl")?>

<h2><?php echo I18n::L("Registration")?></h2>

 <form action="" method="post" name="register_form">

 <table cellpadding="3" cellspacing="10" align="center">

 <tr>
   <td><span class="form_label"><?php echo I18n::L("Username")?></span><br>
   <input type="text" name="user_name" style="height:20pt;width:200pt;font-size:140%" value="<?php echo Viewer::Value("user_name")?>" /></td>
 </tr>

 <tr>
   <td><span class="form_label"><?php echo I18n::L("E-mail")?></span><br>
   <input type="text" name="user_email" style="height:20pt;width:200pt;font-size:140%" value="<?php echo Viewer::Value("user_email")?>" /></td>
 </tr>
 <tr>
   <td><span class="form_label"><?php echo I18n::L("Password")?></span><br>
   <input type="password" name="user_password" style="height:20pt;width:200pt;font-size:140%" /></td>
 </tr>

 <tr>
   <td><span class="form_label"><?php echo I18n::L("Password")?></span><br>
   <input type="password" name="user_password2" style="height:20pt;width:200pt;font-size:140%" />     <span style="color:#666;font-size:80%"><?php echo I18n::L("Please type again.")?></span>
</td>
 </tr>
 <tr>
   <td style="text-align:center;width:200pt"  >

   <?php $err=Viewer::Value("error_message"); if(!empty($err) ): ?>
   <div id="error_message"><?php echo self::Value("error_message");?></div>
   <?php endif;?>

   </td>
</tr>
<tr>
   <td style="text-align:center">
     <input type="hidden" name="register" value="1" />
     <input class="input_buttons" type="submit" value="<?php echo I18n::L("Register!")?>" />
   </td>
</tr>
</table>

 </form>






<?php include("footer.tpl")?>
