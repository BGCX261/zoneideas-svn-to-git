<?php include("header.tpl")?>

<div style=";margin-left:auto;margin-right:auto;width:100%;text-align:center" >



<table width="100%" cellpadding="0" cellspacing="0" style="padding-left:20px;padding-right:20px;">


<tr>
<td colspan="2" style="text-align:center">



<h3 style="padding:0px;text-align:center;" ><?php echo I18n::L("Title Top Ideas")?></h3>

<?php if (Viewer::Value("ideas_top")!==false):?>
<table cellpadding="0" cellspacing="5"  style="text-align:center;margin-left:auto;margin-right:auto;" >
<?php foreach(Viewer::Value("ideas_top") as $idea): ?>                                                                 
             <tr>
             <td style="text-align:center;width:45px;height:45px;vertical-align:middle;background:#E0ECFF;">
              <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>" style=";text-decoration:none;font-size:180%;color:#333;"><?php echo $idea->idea_rate?></a>
             </td>
             <td style="padding:5pt;text-align:left;"><a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>"><?php echo $idea->idea_title?></a><br>
             <span style="text-align:left;font-size:90%;color:#777;"><?php echo date("d F, Y \a\\t H:i",$idea->idea_date) ?>
              by&nbsp;<a href="<?php echo PREFIX?>/profile/?<?php echo $idea->user_id ?>" title="<?php echo User::GetById($idea->user_id)->user_name;?>'s profile"><?php echo User::GetById($idea->user_id)->user_name;?></a> 
             </span></td></tr>       
<?php endforeach;?>
</table>
<?php endif;?>


</td></tr>
      
<tr><td style="vertical-align:top;width:50%">

<h3 style="padding:0px;"><?php echo I18n::L("Title Last Ideas")?></h3>

<?php if (Viewer::Value("ideas_last")!==false):?>
<table cellpadding="0" cellspacing="5"  style="" >
<?php foreach(Viewer::Value("ideas_last") as $idea): ?>                                                                 
             <tr>
             <td style="text-align:center;width:45px;height:45px;vertical-align:middle;background:#E0ECFF;">
              <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>" style=";text-decoration:none;font-size:180%;color:#333;"><?php echo $idea->idea_rate?></a>
             </td>
             <td style="padding:5pt;text-align:left;"><a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>"><?php echo $idea->idea_title?></a><br>
             <span style="text-align:left;font-size:90%;color:#777;"><?php echo date("d F, Y h:m",$idea->idea_date) ?></span></td>
             </tr>
<?php endforeach;?>
</table>
<?php endif;?>

 </td><td style="vertical-align:top">

<h3 style="padding:0px;text-align:right;"><?php echo I18n::L("Title Most Active Ideas")?></h3>

<?php if (Viewer::Value("ideas_active")!==false):?>
<table cellpadding="0" cellspacing="5"   style="margin-left:auto;margin-right:none;">
<?php foreach(Viewer::Value("ideas_active") as $idea): ?>                                                                 
             <tr>
             <td style="padding:5pt;text-align:right;"><a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>"><?php echo $idea->idea_title?></a><br>
             <span style="text-align:right;font-size:90%;color:#777;"><?php echo date("d F, Y h:m",$idea->idea_date) ?></span></td>

             <td style="text-align:center;width:45px;height:45px;vertical-align:middle;background:#E0ECFF;">
              <a href="<?php echo PREFIX?>/idea/?<?php echo $idea->idea_id?>" style=";text-decoration:none;font-size:180%;color:#333;"><?php echo $idea->idea_rate?></a>
             </td>

             </tr>
<?php endforeach;?>
</table>
<?php endif;?>


</td></tr>

</table>


</div>

<br>

<br>

<?php include("footer.tpl")?>