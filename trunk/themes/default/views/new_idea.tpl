<?php include("header.tpl")?>

<br>

<div style="margin-left:auto;margin-right:auto;text-align:center;"  >

<form action="" method="post" >
<div>

<span class="form_label" ><?php echo I18n::L("Title")?></span>
<br>
<input type="text" name="idea_title"  style="font-size:120%;width:60%;text-align:left;" value="<?php echo Viewer::Value("idea_title")?>" />
<br>
<span style="color:#777;font-size:80%"><?php echo I18n::L("Maximum 115 characters.")?></span>
<br>
<br>


<span class="form_label"><?php echo I18n::L("Description")?></span>
<br>

<?php include("wysiwyg.tpl")?>


<textarea cols="0" rows="0" name="idea_description" id="textarea_wysiwyg" style="width:60%;height:200pt;font-size:100%" ></textarea>
<br>
<span style="color:#777;font-size:80%"><?php echo I18n::L("Please, always read your text before posting it. Idea content can not be changed later.")?></span>
<br>


 <?php $err=Viewer::Value("error_message"); if(!empty($err) ): ?>
 <div id="error_message" style="width:40%"><?php echo Viewer::Value("error_message");?></div>
 <?php endif;?>

 <br>

<input type="hidden" name="newidea" value="1" />
<input type="submit" class="input_buttons" value="<?php echo I18n::L("YARRR!")?>" title="&nbsp;Publish my idea&nbsp;" />

</div>
</form>



</div>



<br>

<?php include("footer.tpl")?>
