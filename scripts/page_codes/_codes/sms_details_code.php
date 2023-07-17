<?php

if($message_id){
	$this_message = mysqli_query($connect,"select * from sms_queue where id = $message_id")or die(mysqli_error($connect));
	$this_message_results = mysqli_fetch_array($this_message,MYSQLI_ASSOC);
	
	$sms_group_id = $this_message_results['group_id'];
	if(!$this_message_results['group_id']){
		$sms_group_title = 'Select group';
		
	}else{
		
		$sms_group = mysqli_query($connect,"select * from sms_groups where id = $sms_group_id")or die(mysqli_error($connect));
		$sms_group_results = mysqli_fetch_array($sms_group,MYSQLI_ASSOC);
		
		$sms_group_title = $sms_group_results['title'];

	}
	
	$send_status = $this_message_results['send_status'];
	
	$text_message = $this_message_results['text_message'];
	$to_number = $this_message_results['_to'];
	$sending_date = $this_message_results['_date'];
	$color = '#000';
	
	$button_text = 'Update';
	$message_user_date = $this_message_results['user_date'];
	
	$message_user = mysqli_query($connect,"select * from users where company_id = $company_id and _date = '$message_user_date'")or die(mysqli_error($connect));

	$message_user_results = mysqli_fetch_array($message_user,MYSQLI_ASSOC);
	
	$message_user_name = $message_user_results['_name'];
	
	$this_sms_module_id = $this_message_results['module_id'];
	
	if($this_sms_module_id == 1){
		$this_sms_module_title = 'PIPAT Main';
		
	}else if($this_sms_module_id == 2){
		$this_sms_module_title = 'Claims Tracker';
		
	}else if($this_sms_module_id == 3){
		$this_sms_module_title = 'PrEP';
		
	}else if($this_sms_module_id == 4){
		$this_sms_module_title = 'Captive Wi-Fi';
		
	}else{
		$this_sms_module_title = 'Unspecified';
		
	}
	
}else{
	$sms_group_id = 0;
	$sms_group_title = 'Select group';
	$sending_date = time();
	$to_number = 260;
	$text_message = 'Enter message here';
	$color = '#aaa';
	$button_text = 'Add to Queue';
	
	$send_status = 0;
	
	$message_user_date = $user_results['_date'];
	
	$message_user_name = $user_results['_name'];
	
	$this_sms_module_id = 1;
	$this_sms_module_title = 'PIPAT Main';
}
?>

<input type="hidden" id="this_holder_index" value="<?php print($holder_index);?>">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">

<div style="width:auto;height:auto;float:left;">
		<div style="width:130px;height:30px;line-height:30px;float:left;">Module:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
		
		<div class="option_item" title="Click to change option" onclick="$('#this_sms_module_menu').toggle('fast');" id="active_this_sms_module" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:auto;"><?php print($this_sms_module_title);?></div>

		<div class="option_menu" id="this_sms_module_menu" style="display:none;width:auto;width:150px;">		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#this_sms_module_menu').toggle('fast');$('#active_this_sms_module').html($(this).html());$('#this_sms_module').val(1);">PIPAT Main</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#this_sms_module_menu').toggle('fast');$('#active_this_sms_module').html($(this).html());$('#this_sms_module').val(2);">Claims Tracker</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#this_sms_module_menu').toggle('fast');$('#active_this_sms_module').html($(this).html());$('#this_sms_module').val(3);">PrEP</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#this_sms_module_menu').toggle('fast');$('#active_this_sms_module').html($(this).html());$('#this_sms_module').val(4);">Captive Wi-Fi</div>
		</div>
		</div>
		<input type="hidden" id="this_sms_module" value="<?php print($this_sms_module_id);?>">
	</div>
	
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Message Type:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#message_type_menu').toggle('fast');" id="active_message_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Single recipient</div>
			<div class="option_menu" id="message_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">

				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#message_type_menu').toggle('fast');$('#active_message_type').html($(this).html());$('#selected_message_type').val(0);$('#single_recipient_holder').slideDown('fast');$('#group_recipient_holder').slideUp('fast');">Single recipient</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#message_type_menu').toggle('fast');$('#active_message_type').html($(this).html());$('#selected_message_type').val(1);$('#single_recipient_holder').slideUp('fast');$('#group_recipient_holder').slideDown('fast');">Group recipients</div>
			</div>

	</div>

	<input type="hidden" id="selected_message_type" value="0">
</div>

</div>

<div style="width:auto;height:auto;float:left;display:none;" id="group_recipient_holder">
			<div style="width:130px;height:30px;line-height:30px;float:left;">Select SMS Group:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			
			<div class="option_item" title="Click to change option" onclick="$('#sms_group_menu').toggle('fast');" id="active_sms_group" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($sms_group_title);?></div>

			<div class="option_menu" id="sms_group_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
				if(!$user_results['branch_id']){
					$branch_search = '';
					
				}else{
					$branch_search = ' and branch_id = '.$user_results['branch_id'];
				}
				
				$sms_group_menu = mysqli_query($connect,"select * from sms_groups where company_id = $company_id $branch_search order by title")or die(mysqli_error($connect));

				for($g=0;$g<mysqli_num_rows($sms_group_menu);$g++){
					$sms_group_menu_results = mysqli_fetch_array($sms_group_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sms_group_menu').toggle('fast');$('#active_sms_group').html($(this).html());$('#selected_sms_group').val(<?php print($sms_group_menu_results['id']);?>);"><?php print($location_menu_results['title']);?></div>
					<?php
				}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_sms_group" value="<?php print($sms_group_id);?>">
		</div>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="single_recipient_holder">
<div style="width:130px;height:30px;line-height:30px;float:left;">Send to number:</div>
<div style="width:240px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:#000" value="<?php print($to_number);?>"  id="sms_to" onfocusout="if(this.value==''){this.value='260'}" onfocus="this.style.borderColor='#aaa';$('#error_message').slideUp('fast');"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Date to send:</div>
<div style="width:240px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#day_menu').toggle('fast');" id="active_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('j',$sending_date));?></div>

<div class="option_menu" id="day_menu" style="display:none;">
<?php
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#day_menu').toggle('fast');$('#active_day').html($(this).html());$('#selected_day').val(<?php print($d);?>);" style="width:40px;"><?php print($do);?></div>
		<?php
	}

?>
</div>
<input type="hidden" name="selected_day" id="selected_day" value="<?php print(date('j',$sending_date));?>">
</div>



<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#month_menu').toggle('fast');" id="active_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('m',$sending_date));?></div>
	<div class="option_menu" id="month_menu" style="display:none;">
	<?php
		for($m=1;$m<13;$m++){
			
			if($m<10){
				$mo='0'.$m;
			}else{
				$mo = $m;
			}
			?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#month_menu').toggle('fast');$('#active_month').html($(this).html());$('#selected_month').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
			<?php
		}

	?>
	</div>
	<input type="hidden" name="selected_month" id="selected_month" value="<?php print(date('m',$sending_date));?>">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#year_menu').toggle('fast');" id="active_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('Y',$sending_date));?></div>
	<div class="option_menu" id="year_menu" style="display:none;width:50px;">
	<?php
		for($y=(date('Y',time()));$y<(date('Y',time()) + 5);$y++){
			?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#year_menu').toggle('fast');$('#active_year').html($(this).html());$('#selected_year').val(<?php print($y);?>);" style="width:50px;"><?php print($y);?></div>
			<?php
		}

	?>
	</div>
	<input type="hidden" name="selected_year" id="selected_year" value="<?php print(date('Y',$sending_date));?>">
</div>

</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Time to send:</div>
<div style="width:240px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="line-height:30px;width:30px;height:30px;float:left;">Hr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#hour_menu').toggle('fast');" id="active_hour" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('H',$sending_date));?></div>

<div class="option_menu" id="hour_menu" style="display:none;">
<?php
	for($h=1;$h<25;$h++){
		if($h<10){
			$ho='0'.$h;
		}else{
			$ho = $h;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#hour_menu').toggle('fast');$('#active_hour').html($(this).html());$('#selected_hour').val(<?php print($h);?>);" style="width:40px;"><?php print($ho);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_hour" id="selected_hour" value="<?php print(date('H',$sending_date));?>">
</div>



<div style="line-height:30px;width:40px;height:30px;float:left;">min:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#minute_menu').toggle('fast');" id="active_minute" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('i',$sending_date));?></div>


<div class="option_menu" id="minute_menu" style="display:none;">
<?php
	for($m=0;$m<60;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#minute_menu').toggle('fast');$('#active_minute').html($(this).html());$('#selected_minute').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
		<?php
	}

?>
</div>
<input type="hidden" name="selected_minute" id="selected_minute" value="<?php print(date('i',$sending_date));?>">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Sec:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_second_menu').toggle('fast');" id="active_from_second" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('s',$sending_date));?></div>


<div class="option_menu" id="from_second_menu" style="display:none;width:50px;">
<?php
	for($s=0;$s<60;$s++){
		if($s<10){
			$so='0'.$s;
		}else{
			$so = $s;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_second_menu').toggle('fast');$('#active_from_second').html($(this).html());$('#selected_from_second').val(<?php print($y);?>);" style="width:50px;"><?php print($so);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_second" id="selected_second" value="<?php print(date('s',$sending_date));?>">
</div>

</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Message:</div>
<div style="width:240px;min-height:140px;height:auto;float:left;line-height:30px;">
<textarea style="min-width:100%;max-width:100%;min-height:140px;;max-height:140px;font-family:arial;font-size:0.9em;border:solid 1px #aaa;color:<?php print($color);?>;" onfocus="if(this.value=='Enter message here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter message here';this.style.color='#aaa';}" id="text_message"><?php print($text_message);?></textarea>
</div>

</div>


<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Message by:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;line-height:30px;">
	<?php print($message_user_name);?>

	<input type="hidden" id="selected_user_date" value="<?php print($message_user_date);?>">
</div>

</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;color:red;display:none;" id="error_message"></div>

	<?php
	if(!$send_status){
		?>
		<div style="width:90px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="add_to_queue_button" title="Click to activate the account" onclick="update_sms_message(<?php print($message_id);?>);"><?php print($button_text);?></div>
		
		<?php
	}
	
	if($message_id and !$send_status and ($message_user_date == $user_date || $active_user_roles[8])){
		?>
	<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="delete_sms_button" onclick="delete_sms_message(<?php print($message_id);?>);" title="Click to disable the account">Delete</div>
	
	<?php
	}
	?>