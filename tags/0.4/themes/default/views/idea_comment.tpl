<div class="comment">
    <div style="padding:5px;color:black;font-weight:normal;font-size:80%;" >
         <a name="comment_<?php echo $p?>"></a>
         <span id="comment_text_<?php echo $p?>"><?php echo $comment->GetText(true)?></span>
    </div>

    <div style=";margin-bottom:40px;;text-align:left;font-size:70%;color:#333;vertical-align:top;">
         <div style="float:left;padding:5px;border-bottom:1px solid #eee" >
              <a href="#comment_<?php echo $p?>"  title="Comment #<?php echo $p?>"><img src="<?php echo THEME_PREFIX?>/img/comment_icon.gif" alt="Comment #<?php echo $p?>" style="border:none"></a>&nbsp;
              <a  href="<?php echo PREFIX?>/profile/?<?php echo $comment->user_id ?>" title="<?php echo User::GetById($comment->user_id)->user_name;?>'s profile"><?php echo User::GetById($comment->user_id)->user_name;?></a>
         </div>
        
         <div style="color:#777;padding:5px;padding-left:0px;float:left;border-bottom:1px solid #eee">
         in <?php echo date("H:i \a\\t F d, Y",$comment->comment_date) ?>
              <?php if(User::Logged()):?>
              &nbsp;|&nbsp;
              <a style="text-decoration:none;border-bottom:1px dotted #777" onclick="t=document.getElementById('comment_text');t.value+='&laquo;'+document.getElementById('comment_text_<?php echo $p?>').innerHTML+'&raquo; ';t.focus();t.selectionStart=t.value.length+2" href="javascript:void(0)" title="<?php echo I18n::L("Quote!")?>"><?php echo I18n::L("Quote!")?></a>
              &nbsp;|&nbsp;&nbsp;<a style="text-decoration:none;border-bottom:1px dotted #777" onclick="t=document.getElementById('comment_text');t.value+=' <?php echo User::GetById($comment->user_id)->user_name;?>: ';t.focus();t.selectionStart=t.value.length+2" href="javascript:void(0)" title="<?php echo I18n::L("Reply!")?>"><?php echo I18n::L("Reply!")?></a>
              <?php if (User::$current->IsAdmin() || $comment->user_id==User::$current->user_id ): ?>&nbsp;|&nbsp;<a style="text-decoration:none;border-bottom:1px solid #777" href="?<?php echo Viewer::Value("idea")->idea_id ?>&amp;removecomment=<?php echo $comment->comment_id ?>"><?php echo I18n::L("Remove")?></a><?php endif; ?>
             <?php endif;?>
         </div>
    </div>
</div>
<!-- end of class="comment" -->