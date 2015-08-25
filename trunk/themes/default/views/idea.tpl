<?php include("header.tpl")?>

<br>

<div id="idea_content" style="width:97%">

<table cellpadding="0" cellspacing="0" style="width:100%;" >
<tr>
    <td style="background:#e0ecff;width:45px;height:45px;text-align:center;font-size:220%;color:#333;padding:3pt;vertical-align: middle;"><?php echo Viewer::Value("idea")->idea_rate?></td>

    <td style="font-size:100%;font-weight:bold;padding-left:1%;vertical-align:middle;color:#000;">

    <?php echo Viewer::Value("idea")->idea_title?>
    <div style="font-weight:normal;padding-top:6pt;text-align:left;font-size:80%;color:#333;">
      <?php echo I18n::L("Posted on %s by %s", array(date("d F, Y \a\\t H:i",Viewer::Value("idea")->idea_date), Viewer::Value("idea")->user_id, User::GetById(Viewer::Value("idea")->user_id)->user_name, User::GetById(Viewer::Value("idea")->user_id)->user_name))?>
    </div>
    </td>
</tr>
</table>

<div style="color:#333;font-weight:normal">
   <br>
   <?php echo stripslashes(Viewer::Value("idea")->GetDesc(true))?></div>
    


<div style="text-align:left;color:#777;font-weight:normal;vertical-align:top;padding-top:50px;">


<?php if (Viewer::Value("comments")===false):?>

<span style="font-size:100%"><?php echo I18n::L("No comments posted yet.")?></span>

<?php else:
    $comments = Viewer::Value("comments");
    $comments = array_reverse($comments);
    
    foreach($comments as $comment):
    $commented_users[$comment->user_id]=$comment->user_id;
    endforeach;
?>

<div style="font-size:100%"><?php echo I18n::L("Only %d %s posted by %s", array(sizeof(Viewer::Value("comments")), sizeof(Viewer::Value("comments"))>1?I18n::L("comments"):I18n::L("comment"), sizeof($commented_users)>1?I18n::L("users"):I18n::L("user")))?> :
      <?php foreach($commented_users as $commented_user):?> 
      <a href="<?php echo PREFIX?>/profile/?<?php echo $commented_user?>" title="<?php echo User::GetById($commented_user)->user_name;?>'s profile"><?php echo User::GetById($commented_user)->user_name;?></a>
      <?php echo sizeof($commented_users)>1?",":" "?> 
      <?php unset($commented_users[$commented_user])?>
      <?php endforeach;?>
.</div>

<br>

<?php $p=0;foreach($comments as $comment): $p++;?>

<?php include("idea_comment.tpl")?>

<?php endforeach;?>

<br>


<?php endif;?>





<?php if(User::Logged()): ?>


<?php $err=Viewer::Value("error_message"); if(!empty($err) ): ?>
  <div id="error_message" ><?php echo self::Value("error_message");?></div>
<?php endif;?>




<?php echo I18n::L("Please write your comment here")?>:

<div style="width:55%">

<form action="?<?php echo Viewer::Value("idea")->idea_id ?>" method="post">
<div>

<?php include("wysiwyg.tpl")?>

<textarea style="font-size:80%;height:140px;width:100%;margin-top:5px;" name="comment_text" id="comment_text" cols="10" rows="10"></textarea>

<div  style="padding-top:7pt;width:100%;margin-left:auto;margin-right:auto;text-align:center;" >
<?php if (Viewer::Value("rated")==1):?>

  <table cellpadding="0" cellspacing="0" style="width:100%" >
     <tr>
        <td align="center"><input type="submit" class="input_buttons minus"  name="rate_minus"   value="&nbsp;<?php echo I18n::L("Rate Down")?>&nbsp;" title="&nbsp;<?php echo  I18n::L("Rate Down")?>&nbsp;" /></td>
        <td align="center"><input type="submit" class="input_buttons plus"  name="rate_plus"    value="&nbsp;<?php echo  I18n::L("Rate Up")?>&nbsp;" title="&nbsp;<?php echo  I18n::L("Rate Up")?>&nbsp;" /></td>
        <td align="center"><input type="submit" class="input_buttons"  name="comment_only" value="&nbsp;<?php echo  I18n::L("YARRR!")?>&nbsp;" title="&nbsp;<?php echo  I18n::L("Publish my comment")?>&nbsp;" /></td>
     </tr>
  </table>

<?php else:?>

  <?php if (Viewer::Value("rated")==3):?>
  <input type="submit" class="input_buttons plus" name="rate_plus"  value="&nbsp;<?php echo  I18n::L("Rate Up")?>&nbsp;" title="&nbsp;<?php echo  I18n::L("Rate Up")?>&nbsp;" />
  <?php endif;if (Viewer::Value("rated")==2):?>
  <input type="submit" class="input_buttons minus" name="rate_minus" value="&nbsp;<?php echo  I18n::L("Rate Down")?>&nbsp;" title="&nbsp;<?php echo  I18n::L("Rate Down")?>&nbsp;" />
  <?php endif;if (Viewer::Value("rated")==4):?>
  <input type="submit" class="input_buttons" name="comment_only" value="&nbsp;<?php echo  I18n::L("YARRR!")?>&nbsp;" title="&nbsp;<?php echo  I18n::L("Publish my comment")?>&nbsp;" />
  <?php endif;?>

<?php endif;?>


</div>


</div>
</form>

</div>


</div>

</div>


<?php else: ?>
</div>

  <br>
  <br>
  <div id="error_message" style="width:auto">
      <?php echo  I18n::L("Only registered users can comment ideas.")?>
  </div>
<?php endif;?>






<br><br><br>

<?php include("footer.tpl")?>
