<?php include("header.tpl")?>


<h2><?php echo I18n::L("Login")?></h2>


 <form name="login_form"  method="post" action="">

<table cellpadding="3" cellspacing="10" align="center">
   <tr>
     <td><span class="form_label"><?php echo I18n::L("Username")?></span><br>
     <input type="text" name="user_name" style="height:20pt;width:200pt;font-size:140%;" value="<?php echo Viewer::Value("user_name")?>" /></td>
   </tr>
   <tr>
     <td><span class="form_label"><?php echo I18n::L("Password")?></span><br>
     <input type="password" name="user_password" style="height:20pt;width:200pt;font-size:140%" /></td>
   </tr>
   <tr>
      <td style="text-align:center;width:200pt"  >
      <?php $err=Viewer::Value("error_message"); if(!empty($err) ): ?>
      <div id="error_message"><?php echo Viewer::Value("error_message");?></div>
      <?php endif;?>
      <span style="font-size:90%"><?php echo I18n::L("Maybe it's time to register?")?></span>
      </td>
   </tr>
   <tr>
      <td style="text-align:center" >
       <span style="font-size:90%"><?php echo I18n::L("Recover lost password.")?></span>
       <br /><br />
       <input type="hidden" name="login" value="1" />
       <input class="input_buttons" type="submit" value="<?php echo I18n::L("Let me in!")?>" />
      </td>
   </tr>
</table>

</form>






<?php include("footer.tpl")?>
