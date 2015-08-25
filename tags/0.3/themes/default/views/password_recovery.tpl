<?php include("header.tpl")?>

<h2>Password recovery</h2>



<form action="" method="POST">


<table cellpadding="3" cellspacing="10" align="center">

<tr>
<td>
<span class="form_label">E-mail</span><br>
<input type="text" name="user_email" value="<?php echo User::$current->user_email?>" style="height:20pt;width:200pt;font-size:140%">

</td>
</tr>

<tr>
<td style="text-align:center">
   <?php $err=self::Value("error_message"); if(!empty($err) ): ?>
   <div id="error_message"><?php echo self::Value("error_message");?></div>
   <?php endif;?>
  <input type="hidden" name="password_recovery" value="1" />
  <input class="input_buttons" type="submit" value="Recover" />

</td>
</tr>
</table>

</form>





<?php include("footer.tpl")?>
