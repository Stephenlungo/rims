<?php
if($area_id){
	$this_area = mysqli_query($connect,"select * from dynamic_dashboard_areas where id = $area_id")or die(mysqli_error($connect));
	$this_area_results = mysqli_fetch_array($this_area,MYSQLI_ASSOC);
	
	$title = $this_area_results['title'];
	$description = $this_area_results['description'];
	
	$width = $this_area_results['_width'];
	$height = $this_area_results['_height'];
	
	$width_disabled = ' disabled ';
	if($width == 930){
		$width_title = 'Largest';
		
	}else if($width == 700){
		$width_title = 'Large';
		
	}else if($width == 400){
		$width_title = 'Medium';
		
	}else if($width == 200){
		$width_title = 'Small';
		
	}else{
		$width_title = 'Custom';
		$width_disabled = ' ';
		
	}
	
	$height_disabled = ' disabled ';
	if($height == 400){
		$height_title = 'Large';
		
	}else if($height == 300){
		$height_title = 'Medium';
		
	}else if($height == 200){
		$height_title = 'Small';
		
	}else{
		$height_title = 'Custom';
		$height_disabled = ' ';
		
	}
	
	
	$show_title_id = 0;
	$show_title_checked = '';
	if($this_area_results['show_title']){
		$show_title_id = 1;
		$show_title_checked = ' checked ';
		
	}
	
	$show_description_id = 0;
	$show_description_checked = '';
	if($this_area_results['show_description']){
		$show_description_id = 1;
		$show_description_checked = ' checked ';
		
	}
	
	$show_buttons = $this_area_results['show_buttons'];
	
	if($show_buttons){
		$show_buttons_title = 'Show';
		
	}else{
		$show_buttons_title = "Don't show";
		
	}
	
	
	$ordering = $this_area_results['_order'];
	
	$text_color = '#000';
	$button_text = 'Update';
	
}else{
	
	$text_color = '#aaa';
	$button_text = 'Create';
	$show_title_id = 0;
	$show_title_checked = '';
	$show_description_id = 0;
	$show_description_checked = '';
	
	$width = 930;
	$width_title = 'Largest';
	
	$height = 400;
	$height_title = 'Large';
	
	$width_disabled = 'disabled';
	$height_disabled = ' disabled ';
	$title = 'Enter title here';
	$description = 'Enter description here';
	
	$show_buttons_title = 'Show';
	$show_buttons = 1;
	
	
	$ordering = 'Last';
}
?>

<div style="width:100%;height:auto;float:left;">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Space title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($text_color);?>;" value="<?php print($title);?>"  id="area_title" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;"></div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="checkbox" id="show_area_title_input" onchange="if(this.checked){$('#show_area_title').val(1);}else{$('#show_area_title').val(0);}" <?php print($show_title_checked);?>><label for="show_area_title_input">Show title</label></div>

<input type="hidden" id="show_area_title" value="<?php print($show_title_id);?>">
</div>



<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Space description:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<textarea style="width:100%;height:50px;color:<?php print($text_color);?>;font-family:arial;font-size:0.9em;" id="area_description" onfocus="if(this.value=='Enter description here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter description here';this.style.color='#aaa';}"><?php print($description);?></textarea>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;"></div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="checkbox" id="show_description" onchange="if(this.checked){$('#show_area_description').val(1);}else{$('#show_area_description').val(0);}" <?php print($show_description_checked);?>><label for="show_description">Show description</label></div>

<input type="hidden" id="show_area_description" value="<?php print($show_description_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:140px;height:30px;line-height:30px;float:left;">Space width:</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#area_width_menu').toggle('fast');" id="active_area_width" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($width_title);?></div>

					<div class="option_menu" id="area_width_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_width_menu').toggle('fast');$('#active_area_width').html($(this).html());$('#area_width').val(930);document.getElementById('area_width').disabled = true;$('#error_message').slideUp('fast');">Largest</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_width_menu').toggle('fast');$('#active_area_width').html($(this).html());$('#area_width').val(700);document.getElementById('area_width').disabled = true;$('#error_message').slideUp('fast');">Large</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_width_menu').toggle('fast');$('#active_area_width').html($(this).html());$('#area_width').val(400);document.getElementById('area_width').disabled = true;$('#error_message').slideUp('fast');">Medium</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_width_menu').toggle('fast');$('#active_area_width').html($(this).html());$('#area_width').val(200);document.getElementById('area_width').disabled = true;$('#error_message').slideUp('fast');">Small</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_width_menu').toggle('fast');$('#active_area_width').html($(this).html());document.getElementById('area_width').disabled = false;$('#error_message').slideUp('fast');">Custom</div>
						
						
					</div>
			</div>
		</div>
	</div>
	
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Width measure (px):</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;" value="<?php print($width);?>"  id="area_width" onfocusout="if(this.value==''){this.value='<?php print($width);?>';}" <?php print($width_disabled);?>></div>
</div>


	<div style="height:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:140px;height:30px;line-height:30px;float:left;">Space height:</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#area_height_menu').toggle('fast');" id="active_area_height" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;height:auto;"><?php print($height_title);?></div>

					<div class="option_menu" id="area_height_menu" style="display:none;min-width:150px;max-height:280px;height:auto;">
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_height_menu').toggle('fast');$('#active_area_height').html($(this).html());$('#area_height').val(400);document.getElementById('area_height').disabled = true;$('#error_message').slideUp('fast');">Large</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_height_menu').toggle('fast');$('#active_area_height').html($(this).html());$('#area_height').val(300);document.getElementById('area_height').disabled = true;$('#error_message').slideUp('fast');">Medium</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_height_menu').toggle('fast');$('#active_area_height').html($(this).html());$('#area_height').val(200);document.getElementById('area_height').disabled = true;$('#error_message').slideUp('fast');">Small</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_height_menu').toggle('fast');$('#active_area_height').html($(this).html());document.getElementById('area_height').disabled = false;$('#error_message').slideUp('fast');">Custom</div>
					
					</div>
			</div>
		</div>
	</div>
	
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Height measure (px):</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;" value="<?php print($height);?>"  id="area_height" onfocusout="if(this.value==''){this.value='<?php print($height);?>';}" <?php print($height_disabled);?>></div>
</div>

<div style="height:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:140px;height:30px;line-height:30px;float:left;">Show buttons:</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#area_show_buttons_menu').toggle('fast');" id="active_area_show_buttons" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;height:auto;"><?php print($show_buttons_title);?></div>

					<div class="option_menu" id="area_show_buttons_menu" style="display:none;min-width:150px;max-height:280px;height:auto;">
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_show_buttons_menu').toggle('fast');$('#active_area_show_buttons').html($(this).html());$('#selected_show_buttons').val(1);$('#error_message').slideUp('fast');">Show</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#area_show_buttons_menu').toggle('fast');$('#active_area_show_buttons').html($(this).html());$('#selected_show_buttons').val(0);$('#error_message').slideUp('fast');">Don't show</div>
					
					</div>
			</div>
		</div>
	</div><input type="hidden" id="selected_show_buttons" value="<?php print($show_buttons);?>">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Order:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;" value="<?php print($ordering);?>"  id="area_ordering" onfocus="if(this.value=='Last'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Last';this.style.color='#aaa';}"></div>
</div>


<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>
	<div style="cursor:pointer;width:80px;text-align:center;float:left;height:30px;line-height:30px;padding:3px;margin-top:2px;background-color:orange;color:#fff;" onmouseover="this.style.backgroundColor='#fbbc48';" onmouseout="this.style.backgroundColor='orange';" onclick="create_or_update_dashboard_area(<?php print($dashboard_id.','.$area_id);?>);" id="area_save_button"><?php print($button_text);?></div>
</div>