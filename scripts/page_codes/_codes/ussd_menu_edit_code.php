<?php

if($this_menu_results['_type']){
	$ussd_menu_item_type = 'Custom';
	$script_display = '';
	
}else{
	$ussd_menu_item_type = 'Standard';
	$script_display = 'none';
}

if($this_menu_results['show_id']){
	$menu_show_id = 'Show';
	$id_display = '';
	
}else{
	$menu_show_id = "Don't show";
	$id_display = 'none';
}
	?>


<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_title" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($this_menu_results['title']);?>" onfocusout="if(this.value==''){this.value='<?php print($this_menu_results['title']);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Show ID:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#ussd_menu_show_id_menu').toggle('fast');" id="active_ussd_menu_show_id" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;"><?php print($menu_show_id);?></div>
<div class="option_menu" id="ussd_menu_show_id_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_id_holder').slideDown('fast');$('#ussd_menu_show_id_menu').toggle('fast');$('#active_ussd_menu_show_id').html($(this).html());$('#new_ussd_menu_show_id').val(1);" >Show</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_id_holder').slideUp('fast');$('#ussd_menu_show_id_menu').toggle('fast');$('#active_ussd_menu_show_id').html($(this).html());$('#new_ussd_menu_show_id').val(0);" >Don't show</div>
</div>
</div>
<input type="hidden" id="new_ussd_menu_show_id" value="<?php print($this_menu_results['show_id']);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;display:<?php print($id_display);?>" id="ussd_id_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;">USSD ID:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_id" style="border:solid 1px #aaa;width:40%;height:30px;" value="<?php print($this_menu_results['ussd_id']);?>" onfocusout="if(this.value==''){this.value='<?php print($this_menu_results['ussd_id']);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Type:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#ussd_menu_type_menu').toggle('fast');" id="active_ussd_menu_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;"><?php print($ussd_menu_item_type);?></div>
<div class="option_menu" id="ussd_menu_type_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_script_holder').slideUp('fast');$('#ussd_menu_type_menu').toggle('fast');$('#active_ussd_menu_type').html($(this).html());$('#new_ussd_menu_type').val(0);" >Standard</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_script_holder').slideDown('fast');$('#ussd_menu_type_menu').toggle('fast');$('#active_ussd_menu_type').html($(this).html());$('#new_ussd_menu_type').val(1);" >Custom</div>
</div>
</div>
<input type="hidden" id="new_ussd_menu_type" value="<?php print($this_menu_results['_type']);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;display:<?php print($script_display);?>" id="ussd_script_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;">Script:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_script" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($this_menu_results['script']);?>" onfocusout="if(this.value==''){this.value='<?php print($this_menu_results['script']);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;" >
<div style="width:100px;height:30px;line-height:30px;float:left;">Ordering:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_order" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($this_menu_results['_order']);?>" onfocusout="if(this.value==''){this.value='<?php print($this_menu_results['_order']);?>';}"></div>
</div>


<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_edit_menu_button" onclick="create_or_update_ussd_menu_item(<?php print($this_menu_results['id'].','.$this_menu_results['parent_id'].','.$this_menu_results['level']);?>);">Update</div>

<div style="display:none;width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ce6767';" onmouseout="this.style.backgroundColor='brown';"  id="menu_delete_button" onclick="delete_ussd_menu_item(<?php print($this_menu_results['id'].','.$this_menu_results['level'].','.$this_menu_results['parent_id']);?>);">Delete</div>

<?php
if(!$this_menu_results['_type']){
	?>
<div style="width:90px;height:30px;background-color:#006bb3;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#2c87c5';" onmouseout="this.style.backgroundColor='#006bb3';"  onclick="fetch_ussd_menu(<?php print(($this_menu_results['level']+1).','.$this_menu_results['id']);?>)">Sub-menus</div>

<?php
}
?>



<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="error_message">Information here</div>