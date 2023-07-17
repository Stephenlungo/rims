<?php
if(!$form_id){
	$status_change_title = "Don't Change";
	$status_change_id = -1;
	$processing_method_id = 0;
	$dependencies = '';
	
}else{
	$this_form = mysqli_query($connect,"select * from dynamic_forms where id = $form_id")or die(mysqli_error($connect));
	$this_form_results = mysqli_fetch_array($this_form,MYSQLI_ASSOC);
	$processing_method_id = $this_form_results['data_processing_method'];
	
	$dependencies = $this_form_results['dependencies'];
	if($this_form_results['status_change_id'] == -1){
		$status_change_title = "Don't Change";
		
	}else if($this_form_results['status_change_id'] == 2){
		$status_change_title = "Initiated";
		
	}else if($this_form_results['status_change_id'] == 1){
		$status_change_title = "Screened";
		
	}else if($this_form_results['mobilized'] == 0){
		$status_change_title = "Mobilized";
		
	}
	
	$status_change_id = $this_form_results['status_change_id'];
	
	
}

	?>

<div class="general_menu_holder" style="height:auto;line-height:25px;width:100%;margin-top:-3px;margin-bottom:5px;">
<div class="tab" style="height:25px;line-height:25px;border-right:none;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_99" onclick="$('#general_holder').fadeIn('fast');$('#advanced_holder').hide();tab_item_change(99);">General</div><div class="tab" style="height:25px;line-height:25px;border-right:none;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_100" onclick="$('#general_holder').hide();$('#advanced_holder').fadeIn('fast');tab_item_change(100);">Advanced</div>

</div>
<script>
$('#tab_99').click();

</script>

<div style="width:100%;height:auto;float:left;display:none;" id="advanced_holder">
<div style="width:100%;height:auto;float:left;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Data processing method:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;">
<?php
if($processing_method_id == 0){
	$method_title = 'Replace';
	
}else{
	$method_title = 'Accumulate';
}


?>

<input type="hidden" id="data_processing_method" value="<?php print($processing_method_id);?>">
	<div style="width:auto;;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#form_data_processing_method').toggle('fast');" id="active_data_processing_method" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:90px;max-width:100px;width:auto;"><?php print($method_title);?></div>

	<div class="option_menu" id="form_data_processing_method" style="display:none;width:auto;">		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_data_processing_method').toggle('fast');$('#active_data_processing_method').html($(this).html());$('#data_processing_method').val(0);">Replace</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_data_processing_method').toggle('fast');$('#active_data_processing_method').html($(this).html());$('#data_processing_method').val(1);">Accumulate</div>
	</div>
	</div>
</div>
</div>


<div style="width:100%;height:auto;float:left;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Dependencies:</div>
<div style="width:290px;min-height:30px;height:auto;float:left;line-height:30px;">
<?php
$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id and id != $form_id and status = 1 and module_id = $module_id")or die(mysqli_error($connect));

for($d=0;$d<mysqli_num_rows($dynamic_forms);$d++){
	$dynamic_form_reults = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
	
	if(check_item_in_list($form_id,$dependencies,0,',')){
		$item_checked = ' checked ';
		
	}else{
		$item_checked = '';
		
	}
	
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;"><input <?php print($item_checked);?> type="checkbox" id="dynamic_form_check_<?php print($d);?>" onchange="if(this.checked){add_to_selection(<?php print($dynamic_form_reults['id']);?>,'form_dependecies');}else{remove_from_selection(<?php print($dynamic_form_reults['id']);?>,'form_dependecies');}"> <label for="dynamic_form_check_<?php print($d);?>"><?php print($dynamic_form_reults['form_title']);?></label></div>
	
	<?php	
}
?>

</div>
<input type="hidden" id="form_dependecies" value="<?php print($dependencies);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Change Status To:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">


<?php


?>


<div class="option_item" title="Click to change option" onclick="$('#form_status_change_menu').toggle('fast');" id="active_form_status_change" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($status_change_title);?></div>

		<div class="option_menu" id="form_status_change_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_status_change_menu').toggle('fast');$('#active_form_status_change').html($(this).html());$('#selected_form_status_change').val(-1);$('#new_client_error_message').slideUp('fast');">Don't change</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_status_change_menu').toggle('fast');$('#active_form_status_change').html($(this).html());$('#selected_form_status_change').val(2);$('#new_client_error_message').slideUp('fast');">Initiated</div>
			
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_status_change_menu').toggle('fast');$('#active_form_status_change').html($(this).html());$('#selected_form_status_change').val(1);$('#new_client_error_message').slideUp('fast');">Screened</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_status_change_menu').toggle('fast');$('#active_form_status_change').html($(this).html());$('#selected_form_status_change').val(0);$('#new_client_error_message').slideUp('fast');">Mobilized</div>
				
		</div>
	</div>
	<input type="hidden" id="selected_form_status_change" value="<?php print($status_change_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:170px;height:30px;line-height:30px;float:left;">Assign messaging schedule:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;">


<?php

if(!$form_id || !$this_form_results['message_schedule_id']){
	$message_schedule_title = "Don't assign";
	$message_schedule_id = 0;
	
}else{
	$message_schedule_id = $this_form_results['message_schedule_id'];
	$this_messaging_schedule = mysqli_query($connect,"select * from prep_message_scheduler where id = $message_schedule_id")or die(mysqli_error($connect));
	$this_messaging_schedule_results = mysqli_fetch_array($this_messaging_schedule,MYSQLI_ASSOC);
	
	$message_schedule_title = $this_messaging_schedule_results['title'];
}
?>


<div class="option_item" title="Click to change option" onclick="$('#messaging_schedule_menu').toggle('fast');" id="active_messaging_schedule" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($message_schedule_title);?></div>

		<div class="option_menu" id="messaging_schedule_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#messaging_schedule_menu').toggle('fast');$('#active_messaging_schedule').html($(this).html());$('#selected_messaging_schedule_id').val(0);">Don't assign</div>
			
			<?php
			$schedulers = mysqli_query($connect,"select * from prep_message_scheduler where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($s=0;$s<mysqli_num_rows($schedulers);$s++){
				$schedulers_results = mysqli_fetch_array($schedulers,MYSQLI_ASSOC);	
					?>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#messaging_schedule_menu').toggle('fast');$('#active_messaging_schedule').html($(this).html());$('#selected_messaging_schedule_id').val(<?php print($schedulers_results['id']);?>);"><?php print($schedulers_results['title']);?></div>
					<?php
			}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_messaging_schedule_id" value="<?php print($message_schedule_id);?>">
</div>


</div>


<div style="width:100%;height:auto;float:left;display:none;" id="general_holder">


<?php

if($form_id){
	$button_text = 'Update';
	$default_color = '000';
	
	$form_status = $this_form_results['status'];
	
	if($form_status){
		$new_form_status = 0;
		
	}else{
		$new_form_status = 1;
		
	}
	
	if($form_status){
		$status_button_title = 'Disable';
		
	}else{
		$status_button_title = 'Enable';
		
	}
	
	$form_title = $this_form_results['form_title'];
	$form_description = $this_form_results['description'];
	$form_order = $this_form_results['_order'];
	
	if($this_form_results['custom_script'] == ''){
		$custom_script = 'Enter script source if applicable';
		$script_field_color = '#aaa';
		
	}else{
		$custom_script = $this_form_results['custom_script'];
		$script_field_color = '#000';
	}
	
	$branch_id = $this_form_results['branch_id'];
	
	$categories = mysqli_query($connect,"select * from dynamic_form_categories where dynamic_form_id = $form_id order by _order")or die(mysqli_error($connect));
	
	$total_categories = mysqli_num_rows($categories);
	$category_string = '';
	for($c=0;$c<mysqli_num_rows($categories);$c++){
		$category_results = mysqli_fetch_array($categories,MYSQLI_ASSOC);
		$category_id = $category_results['id'];
		
		$category_status = $category_results['status'];
		
		if($category_status == 0){
			$category_disable_status = ' disabled ';
			
		}else{
			$category_disable_status = '';
			
		}
		
		if($category_results['necessity']){
			$category_necessity = 'Required';
			
		}else{
			$category_necessity = 'Optional';
			
		}
		
		$category_string .= '<div style="width:100%;height:auto;float:left;margin-bottom:15px;border-bottom:solid 1px #ddd;" id="form_category_'.$c.'"><input type="hidden" id="category_active_'.$c.'" value="'.$category_status.'"><input type="hidden" id="category_id_'.$c.'" value="'.$category_results['id'].'"><div style="width:100%;height:auto;float:left;margin-top:5px;"><div style="width:100px;height:25px;line-height:25px;float:left;font-weight:bold;" title="Double-click to add/remove" ondblclick="disable_or_enable_form_cateory('.$c.');">Category title:</div><div style="width:200px;height:25px;float:left;line-height:30px;color:#aaa;"><input '.$category_disable_status.' type="text" id="category_title_'.$c.'" style="border:solid 1px #aaa;width:100%;height:25px;color:'.$default_color.';" value="'.$category_results['title'].'"  onfocusout="if(this.value==\'\'){this.value=\''.$category_results['title'].'\';this.style.color=\'#aaa\';}"></div><div style="width:auto;min-height:25px;height:auto;float:left;"><div style="width:55px;height:25px;line-height:25px;float:left;margin-left:10px;">Ordering:</div><div style="width:60px;min-height:25px;height:auto;float:left;"><input '.$category_disable_status.' type="text" id="category_ordering_'.$c.'" style="border:solid 1px #aaa;width:100%;height:25px;" value="'.$category_results['_order'].'" onfocusout="if(this.value==\'\' || isNaN(this.value)){this.value=\''.$category_results['_order'].'\';this.style.color=\'#aaa\';}" ></div></div><div style="width:auto;min-height:25px;height:auto;float:left;"><div style="width:65px;height:25px;line-height:25px;float:left;margin-left:10px;">Necessity:</div><div style="width:60px;min-height:25px;height:auto;float:left;"><input type="hidden" id="category_option_necessity_'.$c.'" value="'.$category_results['necessity'].'"><div style="width:auto;;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#option_necessity_menu_'.$c.'\').toggle(\'fast\');" id="active_option_necessity_'.$c.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:90px;max-width:100px;width:auto;">'.$category_necessity.'</div><div class="option_menu" id="option_necessity_menu_'.$c.'" style="display:none;width:auto;"><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_necessity_menu_'.$c.'\').toggle(\'fast\');$(\'#active_option_necessity_'.$c.'\').html($(this).html());$(\'#category_option_necessity_'.$c.'\').val(1);">Required</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_necessity_menu_'.$c.'\').toggle(\'fast\');$(\'#active_option_necessity_'.$c.'\').html($(this).html());$(\'#category_option_necessity_'.$c.'\').val(0);">Optional</div></div></div></div></div></div><div style="width:100%;height:auto;float:left;;margin-top:5px;"><div style="width:100px;height:25px;line-height:30px;float:left;">Header text:</div><div style="width:600px;height:25px;float:left;line-height:25px;color:#aaa;"><input '.$category_disable_status.' type="text" id="category_header_txt_'.$c.'" style="border:solid 1px #aaa;width:100%;height:25px;color:'.$default_color.';" value="'.$category_results['header_text'].'" onfocusout="if(this.value==\'\'){this.value=\''.$category_results['header_text'].'\';this.style.color=\'#aaa\';}"></div></div><div style="width:100%;height:auto;float:left;;margin-top:5px;"><div style="width:100px;height:25px;line-height:30px;float:left;">Footer text:</div><div style="width:600px;height:25px;float:left;line-height:30px;color:#aaa;"><input '.$category_disable_status.' type="text" id="category_footer_txt_'.$c.'" style="border:solid 1px #aaa;width:100%;height:25px;color:'.$default_color.';" value="'.$category_results['footer_text'].'"  onfocusout="if(this.value==\'\'){this.value=\''.$category_results['footer_text'].'\';this.style.color=\'#aaa\';}"></div></div><div style="width:100%;height:auto;float:left;" id="category_option_holder_'.$c.'">';
		
		$category_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_category_id = $category_id order by _order")or die(mysqli_error($connect));
		
		
		$default_category_option = -1;
		for($o=0;$o<mysqli_num_rows($category_options);$o++){
			$category_option_results = mysqli_fetch_array($category_options,MYSQLI_ASSOC);
			
			if($category_option_results['status'] == 0){
				$category_option_status = $category_option_results['status'];
				
			}else{
				$category_option_status = $category_status;
			}
			
			if($category_option_results['status'] == 0){
				$disable_status = ' disabled ';
				
			}else{
				$disable_status = $category_disable_status;
				
			}
			
			$schedule_display = 'display:none';
			if($category_option_results['option_type'] == 0){
				$option_type_title = 'Bullet';
				
			}else if($category_option_results['option_type'] == 1){
				$option_type_title = 'Checkbox';
				
			}else if($category_option_results['option_type'] == 2){
				$option_type_title = 'Text-input';
				
			}else if($category_option_results['option_type'] == 3){
				$option_type_title = 'Date';
				
			}else if($category_option_results['option_type'] == 4){
				$option_type_title = 'Scheduled Date';
				$schedule_display = '';
			}else if($category_option_results['option_type'] == 5){
				$option_type_title = 'Place Locater';
				$schedule_display = '';
			}
			
			$days_before = $category_option_results['days_before_due_date'];
			$schedule_message = $category_option_results['schedule_message'];
			
			if($o<mysqli_num_rows($category_options)-1){
				$add_option_button_display = 'none';
				
			}else{
				$add_option_button_display = '';
				
			}
			
			if($category_option_results['default_option']){
				$default_category_option = $o;
				$option_checked = ' checked ';
				
			}else{
				$option_checked = ' ';
				
			}
			
			$category_string .= '<div style="width:100%;height:auto;float:left;margin-top:5px;" id="category_option_'.$c.'_'.$o.'"><input type="hidden" id="category_option_active_'.$c.'_'.$o.'" value="'.$category_option_status.'"><input type="hidden" id="category_option_id_'.$c.'_'.$o.'" value="'.$category_option_results['id'].'"><div style="margin-left:90px;width:110px;height:25px;line-height:30px;float:left;" title="Double-click to add/remove" ondblclick="disable_or_enable_option('.$c.','.$o.');">Option '.($o+1).' (ID:'.$category_option_results['id'].'):</div><div style="width:170px;height:25px;float:left;line-height:25px;color:#aaa;"><input '.$disable_status.' type="text" id="category_option_title_'.$c.'_'.$o.'" style="border:solid 1px #aaa;width:100%;height:25px;color:'.$default_color.';" value="'.$category_option_results['category_title'].'" onfocusout="if(this.value==\'\'){this.value=\''.$category_option_results['category_title'].'\';this.style.color=\'#aaa\';}"></div><div style="width:auto;min-height:30px;height:auto;float:left;"><div style="width:55px;height:30px;line-height:30px;float:left;margin-left:10px;">Ordering:</div><div style="width:50px;min-height:30px;height:auto;float:left;"><input '.$disable_status.' type="text" id="category_option_ordering_'.$c.'_'.$o.'" style="border:solid 1px #aaa;width:100%;height:25px;margin-top:2px;" value="'.$category_option_results['_order'].'" onfocusout="if(this.value==\'\' || isNaN(this.value)){this.value=\''.$category_option_results['_order'].'\';this.style.color=\'#aaa\';}" ></div></div><div style="width:80px;height:30px;line-height:30px;float:left;margin-left:10px;">Option type:</div><input type="hidden" id="category_option_type_'.$c.'_'.$o.'" value="'.$category_option_results['option_type'].'"><div style="width:auto;;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#option_type_menu_'.$c.'_'.$o.'\').toggle(\'fast\');" id="active_option_type_'.$c.'_'.$o.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:90px;max-width:100px;width:auto;">'.$option_type_title.'</div><div class="option_menu" id="option_type_menu_'.$c.'_'.$o.'" style="display:none;width:auto;"><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$c.'_'.$o.'\').toggle(\'fast\');$(\'#active_option_type_'.$c.'_'.$o.'\').html($(this).html());$(\'#category_option_type_'.$c.'_'.$o.'\').val(0);$(\'#scheduled_message_'.$c.'_'.$o.'\').slideUp(\'fast\');">Bullet</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$c.'_'.$o.'\').toggle(\'fast\');$(\'#active_option_type_'.$c.'_'.$o.'\').html($(this).html());$(\'#category_option_type_'.$c.'_'.$o.'\').val(1);$(\'#scheduled_message_'.$c.'_'.$o.'\').slideUp(\'fast\');">Check-box</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$c.'_'.$o.'\').toggle(\'fast\');$(\'#active_option_type_'.$c.'_'.$o.'\').html($(this).html());$(\'#category_option_type_'.$c.'_'.$o.'\').val(2);$(\'#scheduled_message_'.$c.'_'.$o.'\').slideUp(\'fast\');">Text-input</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$c.'_'.$o.'\').toggle(\'fast\');$(\'#active_option_type_'.$c.'_'.$o.'\').html($(this).html());$(\'#category_option_type_'.$c.'_'.$o.'\').val(3);$(\'#scheduled_message_'.$c.'_'.$o.'\').slideUp(\'fast\');">Date</div><div style="width:120px;" class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$c.'_'.$o.'\').toggle(\'fast\');$(\'#active_option_type_catind_opind\').html($(this).html());$(\'#category_option_type_'.$c.'_'.$o.'\').val(4);$(\'#scheduled_message_'.$c.'_'.$o.'\').slideDown(\'fast\');">Scheduled Date</div><div style="width:120px;" class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$c.'_'.$o.'\').toggle(\'fast\');$(\'#active_option_type_'.$c.'_'.$o.'\').html($(this).html());$(\'#category_option_type_'.$c.'_'.$o.'\').val(5);$(\'#scheduled_message_'.$c.'_'.$o.'\').slideDown(\'fast\');">Place Locater</div></div></div><div style="width:80px;height:30px;line-height:30px;float:left;margin-left:10px;"><input '.$option_checked.' type="radio" id="option_default_'.$c.'_'.$o.'" name="option_default_menu_'.$c.'" onchange="if(this.checked){$(\'#default_category_option_'.$c.'\').val('.$o.');}"><label for="option_default_'.$c.'_'.$o.'" >Default</label></div><div style="width:30px;height:25px;float:left;text-align:center;line-height:25px;background-color:#dfd;cursor:pointer;margin-left:2px;border:solid 1px #ddd;display:'.$add_option_button_display.'" onmouseover="this.style.backgroundColor=\'#cfc\';" onmouseout="this.style.backgroundColor=\'#dfd\'" title="Click to add option" id="add_option_button_'.$c.'_'.$o.'" onclick="add_form_option('.$c.','.$o.')">+</div><div style="width:80%;height:30px;float:left;margin-left:100px;line-height:30px;'.$schedule_display.'" id="scheduled_message_'.$c.'_'.$o.'"><div style="width:auto;float:left;">Action day (days before due date):</div><div style="width:60px;height:30px;float:left;margin-left:5px"><input type="text" style="width:100%;height:25px;margin-top:3px;" id="days_before_date_due_'.$c.'_'.$o.'" value="'.$days_before.'"></div><div style="margin-left:30px;width:auto;float:left;">Message:</div><div style="width:300px;height:30px;float:left;margin-left:5px"><input type="text" style="width:100%;height:25px;margin-top:3px;" id="schedule_message_'.$c.'_'.$o.'" value="'.$schedule_message.'"></div></div></div>';
			
		}
		
		$category_string .= '</div><input type="hidden" id="total_category_options_'.$c.'" value="'.mysqli_num_rows($category_options).'"><input type="hidden" id="default_category_option_'.$c.'" value="'.$default_category_option.'"></div>';
	}
	
}else{
	$button_text = 'Create';
	$form_title = 'Enter form title here';
	$form_description = 'Enter description here';
	$form_order = 100;
	$default_color = '#aaa';
	$branch_id = $user_results['branch_id'];
	$total_categories = 0;
	$category_string = '';
	$form_status = 1;
	$status_button_title = '';
	$custom_script = 'Enter script source if applicable';
	$script_field_color = '#aaa';
}
?>





<input type="hidden" id="dynamic_form_status" value="<?php print($form_status);?>">






<?php
if($form_id){
	?>
	
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin:5px;margin-left:0px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_edit_dynamic_form_button" onclick="create_or_edit_dynamic_form(<?php print($form_id);?>);"><?php print($button_text);?></div> 
	
	<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin:5px;margin-left:0px;cursor:pointer;" onmouseover="this.style.backgroundColor='#c14545';" onmouseout="this.style.backgroundColor='brown';"  id="create_or_edit_dynamic_form_button_0" onclick="disable_or_enable_dynamic_form(<?php print($form_id.','.$new_form_status);?>);"><?php print($status_button_title);?></div> 
	
	<?php
}
	?>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Form Title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="dynamic_form_title" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($form_title);?>" onfocus="if(this.value=='Enter form title here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_dynamic_form_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter form title here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Cluster:</div>

<?php
if($branch_id == 0){
	$branch_title = '<i>Non-clustered</i>';
	
}else{
	$branch_query = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
	$branch_query_results = mysqli_fetch_array($branch_query,MYSQLI_ASSOC);
	
	$branch_title = $branch_query_results['title'];
}
?>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_dynamic_form_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#branch_menu').toggle('fast');" id="active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;"><?php print($branch_title);?></div>


<div class="option_menu" id="branch_menu" style="display:none;">
<?php if($branch_id == 0){?>
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#dynamic_form_branch_id').val(0);" ><i>Non-clustered</i></div>


<?php
$branches = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));

for($b=0;$b<mysqli_num_rows($branches);$b++){
	$branches_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);

	?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#dynamic_form_branch_id').val(<?php print($branches_results['id']);?>);" ><?php print($branches_results['title']);?></div>
	<?php
}
}
?>
</div>
</div>
<input type="hidden" id="dynamic_form_branch_id" value="<?php print($branch_id);?>">

</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Description:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="dynamic_form_description" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($form_description);?>" onfocus="if(this.value=='Enter description here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_dynamic_form_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter description here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Order:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="dynamic_form_order" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($form_order);?>"  onfocusout="if(this.value==''){this.value='100';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Custom script:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;"><input type="text" id="dynamic_form_custom_script" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($script_field_color);?>;" value="<?php print($custom_script);?>"  onfocusout="if(this.value==''){this.value='<?php print($custom_script);?>';this.style.color='<?php print($script_field_color);?>';}" onfocus="if(this.value=='Enter script source if applicable'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_dynamic_form_error_message').fadeOut('fast');"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;text-align:center;float:left;background-color:#eee;">Categories</div>
<div style="width:100%;height:auto;float:left;" id="form_categories_holder">
<?php print($category_string);?>
</div>

<input type="hidden" id="total_categories" value="<?php print($total_categories);?>">

<div style="width:100%;height:30px;float:left;margin-top:5px;margin-bottom:10px;"><div style="width:100px;height:30px;line-height:30px;text-align:center;float:left;background-color:#ddf;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';" onclick="add_form_category();">Add category</div></div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:left;display:none;" id="new_dynamic_form_error_message">Information here</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_edit_dynamic_form_button" onclick="create_or_edit_dynamic_form(<?php print($form_id);?>);"><?php print($button_text);?></div>

<?php 
if($form_id){
	?>
	<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin:5px;margin-left:0px;cursor:pointer;" onmouseover="this.style.backgroundColor='#c14545';" onmouseout="this.style.backgroundColor='brown';"  id="disable_or_enable_form_button_1" onclick="disable_or_enable_dynamic_form(<?php print($form_id.','.$new_form_status);?>);"><?php print($status_button_title);?></div> 	
	<?php
	
}
?>

<div style="width:100%;height:auto;float:left;display:none;" id="default_field_holder">
<div style="width:100%;height:auto;float:left;margin-bottom:15px;border-bottom:solid 1px #ddd;" id="form_category_catind">
<input type="hidden" id="category_active_catind" value="1">
<input type="hidden" id="category_id_catind" value="0">
<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:100px;height:25px;line-height:25px;float:left;font-weight:bold;" title="Double-click to add/remove" ondblclick="disable_or_enable_form_cateory(catind);">Category title:</div>
<div style="width:200px;height:25px;float:left;line-height:30px;color:#aaa;"><input type="text" id="category_title_catind" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_dynamic_form_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>

	
	<div style="width:auto;min-height:25px;height:auto;float:left;">
	<div style="width:55px;height:25px;line-height:25px;float:left;margin-left:10px;">Ordering:</div>
	<div style="width:60px;min-height:25px;height:auto;float:left;"><input type="text" id="category_ordering_catind" style="border:solid 1px #aaa;width:100%;height:25px;" value="1" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='1';this.style.color='#aaa';}" ></div>
	</div>
	
	<div style="width:auto;min-height:25px;height:auto;float:left;">
	<div style="width:65px;height:25px;line-height:25px;float:left;margin-left:10px;">Necessity:</div>
	<div style="width:60px;min-height:25px;height:auto;float:left;">
			<input type="hidden" id="category_option_necessity_catind" value="0">
	<div style="width:auto;;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#option_necessity_menu_catind').toggle('fast');" id="active_option_necessity_catind" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:90px;max-width:100px;width:auto;">Required</div>

	<div class="option_menu" id="option_necessity_menu_catind_opind" style="display:none;width:auto;">		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_necessity_menu_catind').toggle('fast');$('#active_option_necessity_catind').html($(this).html());$('#category_option_necessity_catind').val(0);">Required</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_necessity_menu_catind').toggle('fast');$('#active_option_necessity_catind').html($(this).html());$('#category_option_necessity_catind').val(1);">Optional</div>
	</div>
	</div>
	</div>
	</div>

</div>

<div style="width:100%;height:auto;float:left;;margin-top:5px;">
<div style="width:100px;height:25px;line-height:30px;float:left;">Header text:</div>
<div style="width:600px;height:25px;float:left;line-height:25px;color:#aaa;"><input type="text" id="category_header_txt_catind" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_dynamic_form_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div></div>

<div style="width:100%;height:auto;float:left;;margin-top:5px;">
<div style="width:100px;height:25px;line-height:30px;float:left;">Footer text:</div>
<div style="width:600px;height:25px;float:left;line-height:30px;color:#aaa;"><input type="text" id="category_footer_txt_catind" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_dynamic_form_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div></div>


<div style="width:100%;height:auto;float:left;" id="category_option_holder_catind">

<div style="width:100%;height:auto;float:left;margin-top:5px;" id="category_option_catind_opind">
<input type="hidden" id="category_option_active_catind_opind" value="1">
<input type="hidden" id="category_option_id_catind_opind" value="0">
<div style="margin-left:100px;width:70px;height:25px;line-height:30px;float:left;" title="Double-click to add/remove" ondblclick="disable_or_enable_option(catind,opind);">Option 1:</div>
<div style="width:200px;height:25px;float:left;line-height:25px;color:#aaa;"><input type="text" id="category_option_title_catind_opind" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_dynamic_form_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>

<div style="width:auto;min-height:30px;height:auto;float:left;">
	
	<div style="width:55px;height:30px;line-height:30px;float:left;margin-left:10px;">Ordering:</div>
	<div style="width:50px;min-height:30px;height:auto;float:left;"><input type="text" id="category_option_ordering_catind_opind" style="border:solid 1px #aaa;width:100%;height:25px;margin-top:2px;" value="1" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='1';this.style.color='#aaa';}" ></div>
	</div>

<div style="width:80px;height:30px;line-height:30px;float:left;margin-left:10px;">Option type:</div>
	<input type="hidden" id="category_option_type_catind_opind" value="0">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#option_type_menu_catind_opind').toggle('fast');" id="active_option_type_catind_opind" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:90px;max-width:100px;width:120px;">Bullet</div>

	<div class="option_menu" id="option_type_menu_catind_opind" style="display:none;width:auto;">		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_catind_opind').toggle('fast');$('#active_option_type_catind_opind').html($(this).html());$('#category_option_type_catind_opind').val(0);$('#option_default_catind_opind').attr('type','radio');$('#scheduled_message_catind_opind').slideUp('fast');">Bullet</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_catind_opind').toggle('fast');$('#active_option_type_catind_opind').html($(this).html());$('#category_option_type_catind_opind').val(1);$('#option_default_catind_opind').attr('type','checkbox');$('#scheduled_message_catind_opind').slideUp('fast');">Check-box</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_catind_opind').toggle('fast');$('#active_option_type_catind_opind').html($(this).html());$('#category_option_type_catind_opind').val(2);$('#scheduled_message_catind_opind').slideUp('fast');">Text-input</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_catind_opind').toggle('fast');$('#active_option_type_catind_opind').html($(this).html());$('#category_option_type_catind_opind').val(3);$('#scheduled_message_catind_opind').slideUp('fast');">Date</div>
		
		<div style="width:120px;" class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_catind_opind').toggle('fast');$('#active_option_type_catind_opind').html($(this).html());$('#category_option_type_catind_opind').val(4);$('#scheduled_message_catind_opind').slideDown('fast');">Scheduled Date</div>
		
		<div style="width:120px;" class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_catind_opind').toggle('fast');$('#active_option_type_catind_opind').html($(this).html());$('#category_option_type_catind_opind').val(5);$('#scheduled_message_catind_opind').slideDown('fast');">Place Locater</div>
	</div>
	</div>
	
	<div style="width:80px;height:30px;line-height:30px;float:left;margin-left:10px;"><input type="radio" id="option_default_catind_opind" name="option_default_menu_catind" onchange="if(this.checked){$('#default_category_option_catind').val(opind);}"><label for="option_default_catind_opind" >Default</label></div>
	
	<div style="width:30px;height:25px;float:left;text-align:center;line-height:25px;background-color:#dfd;cursor:pointer;margin-left:2px;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#cfc';" onmouseout="this.style.backgroundColor='#dfd'" title="Click to add option" id="add_option_button_catind_opind" onclick="add_form_option(catind,opind)">+</div>
	
	<div style="width:80%;height:30px;float:left;margin-left:100px;line-height:30px;display:none;" id="scheduled_message_catind_opind"><div style="width:auto;float:left;">Action day (days before due date):</div><div style="width:60px;height:30px;float:left;margin-left:5px"><input type="text" style="width:100%;height:25px;margin-top:3px;" id="days_before_date_due_catind_opind" value="0"></div><div style="margin-left:30px;width:auto;float:left;">Message:</div><div style="width:300px;height:30px;float:left;margin-left:5px"><input type="text" style="width:100%;height:25px;margin-top:3px;" id="schedule_message_catind_opind"></div></div>
</div>

</div>
<input type="hidden" id="total_category_options_catind" value="1">
<input type="hidden" id="default_category_option_catind" value="0">
</div>
</div>
</div>