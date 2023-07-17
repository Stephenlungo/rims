<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_title" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Show ID:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#ussd_menu_show_id_menu').toggle('fast');" id="active_ussd_menu_show_id" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;">Show</div>
<div class="option_menu" id="ussd_menu_show_id_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_id_holder').slideDown('fast');$('#ussd_menu_show_id_menu').toggle('fast');$('#active_ussd_menu_show_id').html($(this).html());$('#new_ussd_menu_show_id').val(1);" >Show</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_id_holder').slideUp('fast');$('#ussd_menu_show_id_menu').toggle('fast');$('#active_ussd_menu_show_id').html($(this).html());$('#new_ussd_menu_show_id').val(0);" >Don't show</div>
</div>
</div>
<input type="hidden" id="new_ussd_menu_show_id" value="1">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;" id="ussd_id_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;">USSD ID:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_id" style="border:solid 1px #aaa;width:40%;height:30px;" value="<?php print($next_id);?>" onfocusout="if(this.value==''){this.value='<?php print($next_id);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Type:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#ussd_menu_type_menu').toggle('fast');" id="active_ussd_menu_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;">Standard</div>
<div class="option_menu" id="ussd_menu_type_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_script_holder').slideUp('fast');$('#ussd_menu_type_menu').toggle('fast');$('#active_ussd_menu_type').html($(this).html());$('#new_ussd_menu_type').val(0);" >Standard</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ussd_script_holder').slideDown('fast');$('#ussd_menu_type_menu').toggle('fast');$('#active_ussd_menu_type').html($(this).html());$('#new_ussd_menu_type').val(1);" >Custom</div>
</div>
</div>
<input type="hidden" id="new_ussd_menu_type" value="0">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;display:none" id="ussd_script_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;">Script:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_script" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter script source here" onfocus="if(this.value=='Enter script source here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter script source here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;" >
<div style="width:100px;height:30px;line-height:30px;float:left;">Ordering:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="ussd_menu_order" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($next_order);?>" onfocusout="if(this.value==''){this.value='<?php print($next_order);?>';}"></div>
</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_edit_menu_button" onclick="create_or_update_ussd_menu_item(<?php print('0,'.$parent_id.','.$level);?>);">Create</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="error_message">Information here</div>