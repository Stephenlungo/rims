<div style="width:100%;height:auto;float;left;">
<?php
if($scheduler_id){
	?>
<div class="general_menu_holder" style="height:auto;line-height:25px;width:100%;margin-bottom:5px;">
<div class="tab" style="min-height:25px;height:auto;line-height:25px;border-right:none;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_10" onclick="$('#schedule_general_settings').hide();$('#schedule_messages').slideDown('fast');tab_item_change(10);change_window_size('item_details',950,500,1);">Schedule</div>

<div class="tab" style="min-height:25px;height:auto;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_11" onclick="$('#schedule_messages').hide();$('#schedule_general_settings').slideDown('fast');tab_item_change(11);change_window_size('item_details',450,400,1);">General Settings</div>
</div>
<script>
tab_item_change(10);
</script>
<?php


	$button_text = 'Update';
	
	$scheduler_title = $this_scheduler_results['title'];
	$default_color = '#000';
	$schedule_days = $this_scheduler_results['days'];
	
}else{
	$scheduler_title = 'Enter title here';
	$default_color = '#000';
	$schedule_days = 365;

	$button_text = 'Create';
}
?>



<div style="width:100%;height:auto;float:left;<?php if($scheduler_id){print('display:none;');}?>" id="schedule_general_settings">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($scheduler_title);?>"  id="schedule_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($scheduler_title);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Schedule type:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#schedule_type_menu').toggle('fast');" id="active_schedule_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Relative</div>

			<div class="option_menu" id="schedule_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_type_menu').toggle('fast');$('#active_schedule_type').html($(this).html());$('#selected_schedule_type').val(0);$('#error_message').slideUp('fast');$('#schedule_days_holder').slideDown('fast');">Relative</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_type_menu').toggle('fast');$('#active_schedule_type').html($(this).html());$('#selected_schedule_type').val(1);$('#error_message').slideUp('fast');$('#schedule_days_holder').slideUp('fast');">Absolute</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_schedule_type" value="0">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="schedule_days_holder">
<div style="width:140px;height:30px;line-height:30px;float:left;">Days:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($schedule_days);?>"  id="schedule_days" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter days here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($schedule_days);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

</div>

<?php
if($scheduler_id){
	
	?>
	<div style="width:100%;height:auto;float:left;" id="schedule_messages">
	
	<?php
	
	$scheduler_messages = mysqli_query($connect,"select * from prep_message_scheduler_day_entries where scheduler_id = $scheduler_id")or die(mysqli_error($connect));
	
	$schedule_day_entry_array = array();
	$schedule_message_array = array();
	for($m=0;$m<mysqli_num_rows($scheduler_messages);$m++){
		$schedule_message_results = mysqli_fetch_array($scheduler_messages,MYSQLI_ASSOC);
		
		$schedule_day_entry_array[$m] = $schedule_message_results['schedule_day_entry_value'];
		$schedule_message_array[$m] = $schedule_message_results['message'];
		
	}
	
	for($d=1;$d<$this_scheduler_results['days'];$d++){
		?>
		<div style="width:173px;height:80px;border:solid 1px #ddd;margin:2px;padding:2px;float:left;font-size:0.9em;line-height:20px;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor=''" onclick="fetch_schedule_message(<?php print($scheduler_id.','.$d);?>);">
		<div style="width:100%;height:20px;float:left;background-color:#eef;text-align:center;">Day <?php print($d);?></div>
		<div style="width:100%;height:50px;float:left;overflow:auto;margin-top:2px;" id="message_<?php print($d);?>">
		<?php
		for($m=0;$m<count($schedule_day_entry_array);$m++){
			if($schedule_day_entry_array[$m] == $d){
				print($schedule_message_array[$m]);
			}
		}?>		
		</div>
		</div>
		<?php
	}
	?>
	</div>
	
	<?php
}
?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="client_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="cheduler_update_button" onclick="create_or_update_prep_scheduler(<?php print($scheduler_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>
</div>