<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Time:</div>

<div style="width:auto;min-height:30px;height:auto;float:left;">
<?php
if($this_message_results['time_datestamp'] == ''){
	$entry_hour = '08';
	
}else{
	$entry_hour = date('H',$this_message_results['time_datestamp']);
	
}

?>
		<div class="option_item" title="Click to change option" onclick="$('#entry_hour_menu').toggle('fast');" id="active_entry_hour" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:30px;"><?php print($entry_hour);?></div>

			<div class="option_menu" id="entry_hour_menu" style="display:none;width:50px;">
				<?php
					for($h=1;$h<25;$h++){
						if($h<10){
							$hour = '0'.$h;
							
						}else{
							$hour = $h;
						}
						
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_hour_menu').toggle('fast');$('#active_entry_hour').html($(this).html());$('#selected_entry_hour').val(<?php print($h);?>);"><?php print($hour);?></div>
						<?php
					}
				?>
				<input type="hidden" id="selected_entry_hour" value="<?php print($entry_hour);?>">
			</div>
	</div>
	<div style="width:auto;min-height:30px;line-height:30px;text-align:center;height:auto;float:left;margin-right:10px;">:</div>
	
	<div style="width:auto;min-height:30px;height:auto;float:left;">
<?php

if($this_message_results['time_datestamp'] == ''){
	$entry_min = '00';
	
}else{
	$entry_min = date('i',$this_message_results['time_datestamp']);
	
}

?>
		<div class="option_item" title="Click to change option" onclick="$('#entry_min_menu').toggle('fast');" id="active_entry_min" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:30px;"><?php print($entry_min);?></div>

			<div class="option_menu" id="entry_min_menu" style="display:none;width:50px;">
				<?php
					for($m=0;$m<60;$m++){
						if($m<10){
							$min = '0'.$m;
							
						}else{
							$min = $m;
						}
						
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_min_menu').toggle('fast');$('#active_entry_min').html($(this).html());$('#selected_entry_min').val(<?php print($m);?>);"><?php print($min);?></div>
						<?php
					}
				?>
				<input type="hidden" id="selected_entry_min" value="<?php print($entry_min);?>">
			</div>
	</div>
	
	
	<div style="width:auto;min-height:30px;line-height:30px;text-align:center;height:auto;float:left;margin-right:10px;">:</div>
	
	<div style="width:auto;min-height:30px;height:auto;float:left;">
<?php
if($this_message_results['time_datestamp'] == ''){
	$entry_sec = '00';
	
}else{
	$entry_sec = date('s',$this_message_results['time_datestamp']);
	
}

?>
		<div class="option_item" title="Click to change option" onclick="$('#entry_sec_menu').toggle('fast');" id="active_entry_sec" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:30px;"><?php print($entry_sec);?></div>

			<div class="option_menu" id="entry_sec_menu" style="display:none;width:50px;">
				<?php
					for($s=0;$s<60;$s++){
						if($s<10){
							$sec = '0'.$s;
							
						}else{
							$sec = $s;
						}
						
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_sec_menu').toggle('fast');$('#active_entry_sec').html($(this).html());$('#selected_entry_sec').val(<?php print($s);?>);"><?php print($sec);?></div>
						<?php
					}
				?>
				<input type="hidden" id="selected_entry_sec" value="<?php print($entry_sec);?>">
			</div>
	</div>
	
	
	
</div>

<div style="width:98%;min-height:30px;height:auto;float:left;line-height:30px;padding:2px;">
<div style="width:100px;float:left;height:auto;">Message:</div>
<div style="width:210px;float:left;min-height:30px;height:auto;"><textarea id="entry_message" style="min-width:100%;max-width:100%;min-height:150px;" onfocus="if(this.value == 'Message comes here'){this.value='';this.style.color='#000';}"  onfocusout="if(this.value == ''){this.value='<?php print($this_message_results['message']);?>';}"><?php print($this_message_results['message']);?></textarea></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="client_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="scheduler_massage_update_button" onclick="create_or_update_prep_scheduler_message(<?php print($scheduler_id.','.$day);?>);" title="Click to update account details">Update</div>

</div>