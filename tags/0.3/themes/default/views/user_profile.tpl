<?php include("header.tpl")?>

<h2><?php echo Viewer::Value("user")->user_name?>'s profile</h2>

<div style="text-align:left;text-align:center;height:50%;">

<h4>Posted 

<?php if (!Viewer::Value("ideas_count")):?>
no ideas
<?php else:?>
<a href="<?php echo PREFIX?>/ideas/?user=<?php echo Viewer::Value("user")->user_id?>"> <?php echo Viewer::Value("ideas_count")?> <?php echo Viewer::Value("ideas_count")>1?"ideas":"idea"?></a>
<?php endif;?>
    
and 
<?php if (!Viewer::Value("comments_count")):?>
no comments
<?php else:?>
<?php echo Viewer::Value("comments_count")?> <?php echo Viewer::Value("comments_count")>1?"comments":"comment"?>.</h4>
<?php endif;?>


<?php if (User::$current->IsAdmin() && !empty(Viewer::Value("user")->user_email) ): ?><a style="text-decoration:none;border-bottom:1px solid #666" href="?<?php echo Viewer::Value("user")->user_id ?>&amp;removeuser">Remove user</a><?php endif; ?>

</div>



<?php include("footer.tpl") ?>