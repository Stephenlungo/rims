
<div style="width:100%;height:auto;float:left;" id="targets_holder">
<div style="width:100%;height:auto;float:left;">
<div style="width:auto;height:auto;float:left;" id="unit_0_holder">
	<div style="width:40px;height:30px;line-height:30px;float:left;">Unit:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#unit_target_menu').toggle('fast');" id="active_target_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All units</div>

	<div class="option_menu" id="unit_target_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<?php
		
			$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
				$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_target_menu').toggle('fast');$('#active_target_unit').html($(this).html());$('#selected_target_unit').val(<?php print($unit_menu_results['id']);?>);fetch_menu_items('connect','activities','services',<?php print($unit_menu_results['id']);?>,'target_activity',1,1,'');"><?php print($unit_menu_results['title']);?></div>
				<?php
			}
		?>
	</div>
	</div>
	<input type="hidden" id="selected_target_unit" value="0">
</div>

<div style="width:auto;height:auto;float:left;display:none;" id="target_activity_holder">
	<div style="width:70px;height:30px;line-height:30px;float:left;">Activity:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#target_activity_menu').toggle('fast');" id="active_target_activity" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All activities</div>

	<div class="option_menu" id="target_activity_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
	</div>
	</div>
	<input type="hidden" id="selected_target_activity" value="0">
</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_entry_button" onclick="fetch_targets(<?php print($this_agent_results['id']);?>)">Fetch</div>


		</div>
		<div style="width:100%;height:auto;min-height:25px;float:left;line-height:25px;display:none;background-color:#eef;" id="new_target">
		<div style="width:100%;height:auto;float:left;margin-top:5px;">
			
		<div style="margin-left:2px;width:30px;height:25px;line-height:25px;float:left;margin-top:0px;">Day:</div><div style="width:40px;float:left;margin-top:3px;"><select id="timer_day">
<?php
		for($d=1;$d<32;$d++){
			if($d < 10){
				$dd = '0'.$d;
				
			}else{
				$dd = $d;
			}
			
			if(date('j',time()) == $d){
				$day_active_select = 'selected';
				
			}else{
				$day_active_select = '';
			}
			
			?>
			
			<option value="<?php print($d);?>" <?php print($day_active_select);?>><?php print($dd);?></option>
		<?php
		}
		
		?>
		</select></div>


	<div style="width:45px;height:25px;line-height:25px;float:left;margin-left:10px;">Month: </div>
	<div style="width:50px;height:25px;line-height:25px;float:left;margin-top:3px;"><select id="timer_month">
	
	<?php

for($m=1;$m<13;$m++){
	if($m < 10){
		$dm = '0'.$m;
		
	}else{
		$dm = $m;
	}
	if(date('m',time()) == $dm){
		$active_month_select = 'selected';
		
	}else{
		$active_month_select = '';
		
	}
	
?>
<option value="<?php print($m);?>" <?php print($active_month_select);?>><?php print($dm);?></option>

<?php
}

?>
</select></div>

<div style="width:35px;height:25px;line-height:25px;float:left;margin-left:10px;">Year:</div><div style="width:60px;float:left;margin-top:3px;"><select id="timer_year">

<?php
for($y=2000;$y<(date('Y',time()) +1);$y++){
	if($y < 10){
		$y = '0'.$y;
		
	}
	
if(date('Y',time()) == $y){
	$active_year_select = 'selected';
	
}else{
	$active_year_select = '';
	
}
?>
<option value="<?php print($y);?>" <?php print($active_year_select);?>><?php print($y);?></option>

<?php
}
?>

</select></div>

<div style="width:35px;float:left;margin-left:10px;height:25px;line-height:25px;">Hour: </div><div style="width:40px;float:left;margin-top:3px;"><select id="timer_hour">
<?php
for($h=0;$h<24;$h++){
	if( $h < 10){
		$h = '0'.$h;
		
	}
	if(date('H',time()) == $h){
		$active_hour_select = 'selected';
		
	}else{
		$active_hour_select = '';
		
	}
	
?>
<option value="<?php print($h);?>" <?php print($active_hour_select);?>><?php print($h);?></option>

<?php
}

?>
</select></div>
<div style="width:30px;height:25px;line-height:25px;float:left;margin-left:10px;">Min:</div><div style="width:40px;float:left;margin-top:3px;"><select id="timer_min">

<?php
for($m=0;$m<60;$m++){
	if($m < 10){
		$m = '0'.$m;
		
	}
	
	if(date('i',time()) == $m){
		$active_minute_select = 'selected';
		
	}else{
		$active_minute_select = '';
		
	}
	?>
	
	<option value="<?php print($m);?>" <?php print($active_minute_select);?>><?php print($m);?></option>
	
	<?php
	}
	?>

	</select></div></div>
	
	<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:5px;">
	<div style="width:60px;height:25px;line-height:25px;float:left;">Number: </div>
	<div style="width:60px;float:left;"><input type="text" name="new_target_operation_number" id="new_target_activity_number" style="width:100%;height:25px;color:#aaa" value="Number" onfocus="if(this.value=='Number'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Number';this.style.color='#aaa';}">
	</div>
	
	<div style="margin-top:10px;width:100%;height:auto;float:left;">
	<div style="width:70px;line-height:20px;height:20px;float:left;background-color:#8a8;color:#fff;text-align:center;margin-bottom:3px;cursor:pointer;" onmouseover="this.style.backgroundColor='#9b9'" onmouseout="this.style.backgroundColor='#8a8'" onclick="add_new_target(<?php print($this_agent_results['id']);?>)" id="target_saving_btn">Save</div>
	<div style="width:70px;line-height:20px;height:20px;float:left;background-color:#ddd;margin-left:2px;text-align:center;margin-bottom:3px;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='#ddd'" onclick="$('#new_target').fadeOut('fast');$('#add_new_target_button').fadeIn('fast');">Cancel</div></div></div>
	</div>
		
	<div style="width:100%;float:left;margin-top:10px;" id="user_current_targets">
	<?php
	if($editing){
		?>
	<div style="width:70px;line-height:20px;height:20px;float:right;background-color:#ccc;text-align:center;margin-bottom:3px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#ccc'" onclick="$('#new_target').fadeIn('fast');$(this).fadeOut('fast');" id="add_new_target_button">Add new</div>
	
	<?php
	}
	?>

	<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddf;">
	<div style="width:120px;height:20px;float:left;">Start date</div>
	<div style="width:120px;height:20px;float:left;">Start time</div>
	<div style="width:120px;height:20px;float:left">Number</div>
	</div>
	<div style="width:100%;height:auto;float:left;" id="user_current_targets_data"></div>
	</div>
	</div>