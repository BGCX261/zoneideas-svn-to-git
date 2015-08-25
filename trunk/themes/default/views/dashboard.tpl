<?php include("header.tpl")?>


<h2><?php echo I18n::L("Dashboard")?></h2>






<h3><?php echo I18n::L("My Ideas")?> (<?php echo sizeof(Viewer::Value("ideas"))>1?sizeof(Viewer::Value("ideas")):0; ?>)</h3>

<?php if(Viewer::Value("ideas")===false):?>

   <h4 style="color:#777"><?php echo I18n::L("You have no ideas, maybe it's good time to add a new idea")?>?</h4>

<?php else:?>    


<table cellpadding="0" cellspacing="0"  style="margin-left:auto;margin-right:auto;" >

<?php foreach(Viewer::Value("ideas") as $idea):?>                                                                 
             <tr>

             <td style="text-align:center;width:45px;height:45px;vertical-align:middle;background:#E0ECFF;">
              <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>" style=";text-decoration:none;font-size:180%;color:#333;"><?php echo $idea->idea_rate?></a>
             </td>


             <td style="padding:5pt;text-align:left;">
             <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>"><?php echo $idea->idea_title?></a><br>
             <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>#write_comment" title="Comment" style="padding-right:3px;text-decoration:none;font-size:80%;color:blue">Comment (<?php echo $idea->comments_count?>)</a>
             &nbsp;|&nbsp;<span style="text-align:left;font-size:80%;color:#777;"><?php echo date("d F, Y h:m",$idea->idea_date) ?></span>             
             &nbsp;|&nbsp;<a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id ?>&amp;removeidea" style="font-size:80%;" onClick="return confirm('<?php echo I18n::L("Are you sure want to remove this idea?")?>')"><?php echo I18n::L("Remove")?></a> 
             </td>

             </tr>

             <tr>
              <td colspan="3" style="height:10pt"><br></td>
             </tr>


<?php endforeach;?>

</table>
 
<?php endif;?> 






<!--

<h3 ><?php echo I18n::L("Settings")?></h3>


<h4 style="margin-bottom:5px;padding-left:400px;text-align:left">Mail notifications</h4>
<br>
<div align="left" style="padding-left:400px">
<form action="" method="POST">

     <span>My current email address is</span>  <input type="text" name="user_email" value="<?php echo User::$current->user_email?>" style="padding-left:3px;font-size:140%;width:245px">
     <br><br>
     <input type="checkbox" name="email_comments_myideas" value="1">&nbsp;<span>Send notification about new comments and rates on my ideas</span>
     <br><br>
     <input type="checkbox" name="email_mycomments" value="1">&nbsp;<span>Send copy of my comments</span>
     <br>
     <br>
      <br>
     <input type="hidden" name="save_mail" value="1" />
     <input class="input_buttons" type="submit" value="Save" />

</form>
</div>

<br>


<h4 style="margin-bottom:5px;padding-left:400px;text-align:left">Password</h4>
<br>
<div align="left" style="padding-left:400px">
<form action="" method="POST">

     <span class="form_label">New Password</span><br>  
     <input type="password" name="user_password" value="" style="height:20pt;width:200pt;font-size:140%">
     <br><br>
     <span class="form_label">New Password</span><br>  
     <input type="password" name="user_password2" value="" style="height:20pt;width:200pt;font-size:140%">
     <span style="color:#777;font-size:80%">Please type again.</span>
     <br>
     <br>
      <br>
     <input type="hidden" name="save_mail" value="1" />
     <input class="input_buttons" type="submit" value="Save" />

</form>
</div>

-->



<br>

<br>


<?php include("footer.tpl")?>