<input type="hidden" id="graph_variables" value="<?php print($graph_variables);?>">
<input type="hidden" id="rule_string" value="<?php print($rule_string);?>">
<input type="hidden" id="graph_size" value="<?php print($graph_size);?>">
<input type="hidden" id="this_graph_id" value="<?php print($graph_id);?>">
<input type="hidden" id="dashboard_id" value="<?php print($dashboard_id);?>">
<input type="hidden" id="dashboard_area_id" value="<?php print($dashboard_area_id);?>">
<input type="hidden" id="show_title" value="<?php print($show_title);?>">
<input type="hidden" id="show_grid" value="<?php print($show_grid);?>">
<input type="hidden" id="show_legend" value="<?php print($show_legend);?>">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Graph Title:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;" value="<?php print($title);?>"  id="saving_graph_title"></div>
</div>

<div style="width:auto;float:left;height:30px;">
	<div style="width:100px;float:left;height:30px;line-height:30px;">Accessibility:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#saving_accessibility_menu').toggle('fast');" id="active_saving_accessibility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:150px;max-width:270px;width:auto;">Accessible to everyone</div>

		<div class="option_menu" id="saving_accessibility_menu" style="display:none;width:auto;width:150px;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#saving_accessibility_menu').toggle('fast');$('#active_saving_accessibility').html($(this).html());$('#selected_saving_accessibility').val(0);">Accessible to everyone</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#saving_accessibility_menu').toggle('fast');$('#active_saving_accessibility').html($(this).html());$('#selected_saving_accessibility').val(<?php print($user_id);?>);">Accessible to me only</div>
		</div>
	</div>
	<input type="hidden" id="selected_saving_accessibility" value="0">
</div>

<?php
if($is_default){
	$is_default_title = 'Yes';
	
}else{
	$is_default_title = 'No';
	
}
?>
<div style="width:auto;float:left;height:30px;">
	<div style="width:100px;float:left;height:30px;line-height:30px;">Make default:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#saving_make_default_menu').toggle('fast');" id="active_saving_make_default" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:80px;max-width:270px;width:auto;"><?php print($is_default_title);?></div>

		<div class="option_menu" id="saving_make_default_menu" style="display:none;width:auto;width:80px;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#saving_make_default_menu').toggle('fast');$('#active_saving_make_default').html($(this).html());$('#selected_saving_make_default').val(1);">Yes</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#saving_make_default_menu').toggle('fast');$('#active_saving_make_default').html($(this).html());$('#selected_saving_make_default').val(0);">No</div>
		</div>
	</div>
	<input type="hidden" id="selected_saving_make_default" value="<?php print($is_default);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-top:15px;">
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  onclick="process_save_graph();" id="graph_saving_button">Save</div>

</div>