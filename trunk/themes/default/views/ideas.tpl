<?php include("header.tpl")?>


<?php if (Viewer::Value("action")=="user"):?>

<h2 align="center"><?php echo I18n::L("%s's ideas", array(Viewer::Value("user")->user_name))?></h2>

<?php elseif (Viewer::Value("action")=="search"):?>

<?php include("search.tpl")?>

<?php else:?>

<br>

<?php endif;?>




<div id="ideas"  style="margin:0px;padding:0pt;text-align:left;margin-left:auto;margin-right:auto;width:97%">


<?php if (Viewer::Value("ideas")!==false){?>

<table cellpadding="0" cellspacing="0"  border="0"  style=""  >

<?php foreach(Viewer::Value("ideas") as $idea): ?>


<tr>
    
<td style="background:#e0ecff;width:45px;height:45px;text-align:center;font-size:220%;color:#333;padding:3pt;vertical-align: middle;" title="<?php echo $idea->idea_title?>"><?php echo $idea->idea_rate?></td>

<td style="text-align:left;padding-left:10pt;vertical-align:middle;">
 <div class="idea_title" title="<?php echo $idea->idea_title?>" ><a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>"><?php echo $idea->idea_title?></a><a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>" style="text-decoration:none;color:#999">&nbsp;&mdash;&nbsp;<?php echo Support::Snippet(strip_tags(($idea->GetDesc(true))),120,"...")?></a>
 </div>
 <div style="font-size:80%;padding-top:6pt;color:#333;">
       <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>&amp;rate_minus" title="Rate down" style="font-weight:bold;padding-right:3px;text-decoration:none;font-size:100%;color:red"><img src="<?php echo THEME_PREFIX?>/img/down.png" class="rate_icon" alt="Down" />Down</a>&nbsp;|&nbsp;
       <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>&amp;rate_plus"  title="Rate up"   style="font-weight:bold;padding-right:3px;text-decoration:none;font-size:100%;color:green;"><img src="<?php echo THEME_PREFIX?>/img/up.png" class="rate_icon" alt="Up" />Up</a>&nbsp;|&nbsp;
       <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>#write_comment"  title="Comment" style="padding-right:3px;text-decoration:none;font-size:100%;color:blue">Comment (<?php echo $idea->comments_count?>)</a>

|&nbsp;&nbsp;<?php echo date("d F, Y \a\\t H:i",$idea->idea_date) ?>
  by&nbsp;<a href="<?php echo PREFIX?>/profile/?<?php echo $idea->user_id ?>" title="<?php echo User::GetById($idea->user_id)->user_name;?>'s profile"><?php echo User::GetById($idea->user_id)->user_name;?></a>. 
<?php if (User::$current->IsAdmin()): ?>&nbsp;|&nbsp;<a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id ?>&amp;removeidea" style="font-size:80%;" onClick="return confirm('<?php echo I18n::L("Are you sure want to remove this idea?")?>')"><?php echo I18n::L("Remove")?></a><?php endif;?> 
</div>

</td>


</tr>

<tr>

 <td colspan="2" style="height:20pt"><br></td>

</tr>

<?php endforeach;?>

</table>


</div>

<?php }else{?>

</div>



<?php if (Viewer::Value("user")!==false){?>


<h4 style="text-align:center"><?php echo I18n::L("No ideas posted.")?></h4>

<?php }else{?>


<h4 style="text-align:center"><?php echo I18n::L("No Ideas found.")?></h4>

<?php }?>




<?php }?>







<?php include("footer.tpl")?>
