

<h2><?php echo I18n::L("Search")?></h2>



 <form name="search_form"  method="get" action="">
 <div>
 
 <input type="hidden" name="search">


 <table cellpadding="3" cellspacing="0" style="margin-left:auto;margin-right:auto">

 <tr>
   <td><input type="text" name="q" style="height:20pt;width:350pt;font-size:140%" value="<?php echo Viewer::Value("q")?>" /></td>
 </tr>
 <tr>
   <td style="text-align:center"><input class="input_buttons" type="submit" value="<?php echo I18n::L("Search")?>" /></td>
 </tr>


 </table>

 </div>
 </form>

 <br>