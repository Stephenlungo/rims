

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Date <i>(mm/dd/yyyy)</i>:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" id="entry_date" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',$this_entry_results['_date']));?>" onfocusout="if(this.value==''){this.value='<?php print(date('m/d/Y',$this_entry_results['_date']));?>';}" <?php if(!$editing){print(' disabled ');}?>></div><div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;margin-left:5px;color:#006bb3"><?php print(date('jS M, Y',$this_entry_results['_date']));?></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Time:</div>

<div style="width:auto;min-height:30px;height:auto;float:left;">
<?php
	$entry_hour = date('H',$this_entry_results['_date']);

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
	$entry_min = date('i',$this_entry_results['_date']);

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
	$entry_sec = date('s',$this_entry_results['_date']);

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

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Number:</div>
<div style="width:70px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;" value="<?php print($this_entry_results['_value']);?>" onfocusout="if(isNaN(this.value) || this.value==''){this.value='<?php print($this_entry_results['_value']);?>';}" id="entry_value" <?php if(!$editing){print(' disabled ');}?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Agent:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;line-height:30px;margin-right:5px;" title="Phone: <?php print($agent_phone);?>"><?php print($this_agent_results['_name']);?></div>

<div style="width:90px;height:25px;margin-top:2px;background-color:#006bb3;color:#fff;text-align:center;line-height:25px;float:left;cursor:pointer;" onmouseover="this.style.backgroundColor='#339cb3';" onmouseout="this.style.backgroundColor='#006bb3';"  id="all_entries_button" onclick="if($('#reporting_active').val() != undefined){$('#last_entry_id').val(0);$('#editing_active').val(0);$('#days_worked').val(0);$('#total_records').val(0);show_agent_entries(<?php print('0,0,0,0,'.$this_agent_results['id']);?>);}else{alert('Action not available');}">All entries >></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Unit:</div>
<div style="width:270px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#entry_unit_menu').toggle('fast');" id="active_entry_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_results['title']);?></div>

			<div class="option_menu" id="entry_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_unit_menu').toggle('fast');$('#active_entry_unit').html($(this).html());$('#selected_entry_unit').val(<?php print($unit_menu_results['id']);?>);fetch_menu_items('connect','activities','services',<?php print($unit_menu_results['id']);?>,'entry_activity',1,1,'');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_entry_unit" value="<?php print($this_entry_results['unit_id']);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Activity:</div>
<div style="width:270px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#entry_activity_menu').toggle('fast');" id="active_entry_activity" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_activity_results['title']);?></div>

			<div class="option_menu" id="entry_activity_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from activities where services = $this_unit_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_activity_menu').toggle('fast');$('#active_entry_activity').html($(this).html());$('#selected_entry_activity').val(<?php print($unit_menu_results['id']);?>);"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_entry_activity" value="<?php print($this_entry_results['activity_id']);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Region:</div>
<div style="width:270px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#entry_region_menu').toggle('fast');" id="active_entry_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_results['title']);?></div>

			<div class="option_menu" id="entry_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_region_menu').toggle('fast');$('#active_entry_region').html($(this).html());$('#selected_entry_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'entry_province',1,1,'connect-hubs-province_id-{id}-entry_hub-1-1|connect-sites-hub_id-{id}-entry_site-1-1');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_entry_region" value="<?php print($this_entry_results['region_id']);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:270px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#entry_province_menu').toggle('fast');" id="active_entry_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_results['title']);?></div>

			<div class="option_menu" id="entry_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_province_menu').toggle('fast');$('#active_entry_province').html($(this).html());$('#selected_entry_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'entry_hub',1,1,'connect-sites-hub_id-{id}-entry_site-1-1');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_entry_province" value="<?php print($this_entry_results['province_id']);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:270px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#entry_hub_menu').toggle('fast');" id="active_entry_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_results['title']);?></div>

		<div class="option_menu" id="entry_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_hub_menu').toggle('fast');$('#active_entry_hub').html($(this).html());$('#selected_entry_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'entry_site',1,1,'');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_entry_hub" value="<?php print($this_entry_results['hub_id']);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:270px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#entry_site_menu').toggle('fast');" id="active_entry_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_results['title']);?></div>

		<div class="option_menu" id="entry_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_site_menu').toggle('fast');$('#active_entry_site').html($(this).html());$('#selected_entry_site').val(<?php print($site_menu_results['id']);?>);"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_entry_site" value="<?php print($this_entry_results['site_id']);?>">
</div>


<?php
	if($this_entry_results['validation_status'] == 1){?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Validated by:</div>
<div style="width:270px;min-height:20px;height:auto;float:left;line-height:20px;">
	<?php
	$validation_user_date = $this_entry_results['validation_user_date'];
	
	$this_validation_user = mysqli_query($connect,"select * from users where _date = '$validation_user_date'")or die(mysqli_error($connect));
	$this_validation_user_results = mysqli_fetch_array($this_validation_user,MYSQLI_ASSOC);
	
	if(mysqli_num_rows($this_validation_user)){
		
		if($this_validation_user_results['region_id'] == 0){
			$region_title = '<i>Unspecified region</i>';
			
		}else{
			$this_region_id = $this_validation_user_results['region_id'];
			$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
			$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			
			$region_title = $this_region_results['title'];
			
		}
		
		if($this_validation_user_results['province_id'] == 0){
			$province_title = '<i>Unspecified province</i>';
			
		}else{
			$this_province_id = $this_validation_user_results['province_id'];
			$this_province = mysqli_query($connect,"select * from provinces where id = $this_region_id")or die(mysqli_error($connect));
			$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
			
			$province_title = $this_province_results['title'];
			
		}
		
		if($this_validation_user_results['hub_id'] == 0){
			$hub_title = '<i>Unspecified hub</i>';
			
		}else{
			$this_hub_id = $this_validation_user_results['hub_id'];
			$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
			$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
			
			$hub_title = $this_hub_results['title'];
			
		}
		
		if($this_validation_user_results['site_id'] == 0){
			$site_title = '<i>Unspecified site</i>';
			
		}else{
			$this_site_id = $this_validation_user_results['site_id'];
			$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
			$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
			
			$site_title = $this_site_results['title'];
			
		}
		
		
		print($this_validation_user_results['_name'].' <font style="color:#999;font-size:0.9em;">(Phone: '.$this_validation_user_results['phone'].', '.$site_title.' - '.$province_title.' - '.$hub_title.' - '.$region_title.')</font>');
		
		$validadtion_title = '';
	
	}else{
		print('User not found (User might have been deleted)');
		
	}
		
	?>
	</div>
</div>
<?php
	}
	
if($this_entry_results['validation_status'] == 0 and $editing){
?>
<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="validate_entry_button" onclick="validate_entry(<?php print($this_entry_results['id']);?>);">Validate</div>
<?php
}
?>

<?php
if($editing){?>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_entry_button" onclick="<?php if($this_entry_results['validation_status'] == 0){?> update_entry(<?php print($this_entry_results['id']);?>);<?php }else{?> var c = confirm('Updating this entry will undo its validation. Proceed?');if(c){update_entry(<?php print($this_entry_results['id']);?>);}<?php }?>">Update</div>

<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="delete_entry_button" onclick="delete_entry(<?php print($this_entry_results['id']);?>);">Delete</div>

<?php
}
?>
<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="edit_entry_error_message">Information here</div>
</div>

<script>
if($('#reporting_active').val() != undefined){
	$('#all_entries_button').fadeIn('fast');
	
}else{
	$('#all_entries_button').fadeOut('fast');
	
}

$( function() {
	$( "#entry_date" ).datepicker();
} );
</script>