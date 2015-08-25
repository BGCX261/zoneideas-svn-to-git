<!-- begin of top menu -->

<div id="menu_div">

    <table cellpadding="0" cellspacing="0"  id="menu_links" border="0" >
    <tr>
    
    <?php if(User::Logged()): ?>
     <td class="<?php echo Support::IsInQuery("new")?"menu_selected_link":"menu_normal_link";?>">    <a <?php if(!Support::IsInQuery("new")):?>     href="<?php echo PREFIX?>/idea/?new"      <?php endif;?> onclick="this.blur();"><?php echo I18n::L("New idea")?></a></td>
    <?php endif;?>
    <td class="<?php echo Support::IsInQuery("summary")?"menu_selected_link":"menu_normal_link";?>"><a <?php if(!Support::IsInQuery("summary")):?> href="<?php echo PREFIX?>/ideas/?summary" <?php endif;?> onclick="this.blur();"><?php echo I18n::L("Summary")?></a></td>
    <td class="<?php echo Support::IsInQuery("top")?"menu_selected_link":"menu_normal_link";?>">    <a <?php if(!Support::IsInQuery("top")):?>     href="<?php echo PREFIX?>/ideas/?top"     <?php endif;?> onclick="this.blur();"><?php echo I18n::L("Top")?></a></td>
    <td class="<?php echo Support::IsInQuery("last")?"menu_selected_link":"menu_normal_link";?>">   <a <?php if(!Support::IsInQuery("last")):?>    href="<?php echo PREFIX?>/ideas/?last"    <?php endif;?> onclick="this.blur();"><?php echo I18n::L("Last")?></a></td>
    <td class="<?php echo Support::IsInQuery("active")?"menu_selected_link":"menu_normal_link";?>"> <a <?php if(!Support::IsInQuery("active")):?>  href="<?php echo PREFIX?>/ideas/?active"  <?php endif;?> onclick="this.blur();"><?php echo I18n::L("Active")?></a></td>
    <td class="<?php echo Support::IsInQuery("search")?"menu_selected_link":"menu_normal_link";?>"> <a <?php if(!Support::IsInQuery("search")):?>  href="<?php echo PREFIX?>/ideas/?search"  <?php endif;?> onclick="this.blur();"><?php echo I18n::L("Search")?></a></td>
    </tr>
    </table>

</div>

<!-- end of top menu -->