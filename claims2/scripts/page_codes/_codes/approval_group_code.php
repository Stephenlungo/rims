<?php
if($threshold_id){
	$input_color = '#000';
	$button_text = 'Update';
	
	$threshold = mysqli_query($$module_connect,"select * from approval_thresholds where id = $threshold_id")or die(mysqli_error($$module_connect));
	$threshold_results = mysqli_fetch_array($threshold,MYSQLI_ASSOC);
	
	$threshold_title = $threshold_results['title'];
	$rule_string =  $threshold_results['rule_string'];
	
	$this_region_id = $threshold_results['region_id'];
	$this_province_id = $threshold_results['province_id'];
	$this_hub_id = $threshold_results['hub_id'];
	$this_site_id = $threshold_results['site_id'];
	
	$threshold_status = $threshold_results['status'];
	
}else{
	$input_color = '#aaa';
	$button_text = 'Create';
	$threshold_title = 'Enter title here';

	$rule_string = '1,0,0,1,0,0,0,0,0,0,0';
	$this_region_id = $user_results['region_id'];
	$this_province_id = $user_results['province_id'];
	$this_hub_id = $user_results['hub_id'];
	$this_site_id = $user_results['site_id'];
	$threshold_status = 1;
}

	if(!$this_region_id){
		$this_region_title = 'Select region';
		$this_region_id = 0;
		
	}else{		
		$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
		$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
		
		$this_region_title = $this_region_results['title'];
	}
		
	if(!$this_province_id){
		$this_province_title = 'All Provinces';
		
	}else{
		$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
		$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
		
		$this_province_title = $this_province_results['title'];		
	}
	
	if(!$this_hub_id){
		$this_hub_title = 'All Hubs';
		
	}else{
		$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
		$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
		
		$this_hub_title = $this_hub_results['title'];
	}
	
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
		
		$this_site_title = $this_site_results['title'];
	}

$editing = 1;
$default_unit_id = $user_results['unit_id'];

if(!$default_unit_id){
	$default_unit_title = 'Select unit';
	$default_unit_id = 0;
	
}else{
	$default_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
	$default_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
	$default_unit_title = $this_unit_results['title'];
	
}

?>
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:250px;height:30px;float:left;line-height:30px;"><input type="text" id="threshold_title" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="<?php print($threshold_title);?>" onfocus = "if(this.value=='Enter title here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='<?php print($threshold_title);?>';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;margin-top:20px;border-top:solid 1px #eee;padding-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#request_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for users');<?php }?>" id="active_request_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="request_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_region_menu').toggle('fast');$('#active_request_region').html($(this).html());$('#selected_request_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#error_message').slideUp('fast');">All Regions</div>
			
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_region_menu').toggle('fast');$('#active_request_region').html($(this).html());$('#selected_request_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_request_region" value="<?php print($this_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#user_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for users');<?php }?>" id="active_user_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="user_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_province_menu').toggle('fast');$('#active_user_province').html($(this).html());$('#selected_request_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'user_hub',1,1,'connect-sites-hub_id-{id}-user_site-1-1');$('#error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_request_province" value="<?php print($this_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#user_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for users');<?php }?>" id="active_user_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="user_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_hub_menu').toggle('fast');$('#active_user_hub').html($(this).html());$('#selected_request_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'user_site',1,1,'');$('#error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_request_hub" value="<?php print($this_hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#user_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorised to modify site settings for users');<?php }?>" id="active_user_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="user_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_site_menu').toggle('fast');$('#active_user_site').html($(this).html());$('#selected_request_site').val(<?php print($site_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_request_site" value="<?php print($this_site_id);?>">
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddf;text-align:center;margin-top:10px;margin-bottom:10px;" id="$('#approval_levels').slideToggle('fast');">Approvers</div>


<div style="width:100%;height:auto;float:left;" id="approvers">
<?php
$approver_array = explode(']',$rule_string);
for($a=0;$a<count($approver_array);$a++){
	
	$level_options = explode(',',$approver_array[$a]);
	
	$limitation_id = $level_options[0];
	if(!$limitation_id){
		$limitation_title = 'No';
		$amount_holder_display = 'display:none;';
		
	}else{	
		$limitation_title = 'Yes';
		$amount_holder_display = '';
	}

	$limit_amount_value = $level_options[1];
	if(!$limit_amount_value){
		$limit_amount_value_title = 'Enter amount here';

	}else{
		$limit_amount_value_title = $limit_amount_value;

	}
	
	$low_amount_id = $level_options[2];
	if(!$low_amount_id){
		$low_amount_action_title = 'Skip if other approver exists';

	}else{	
		$low_amount_action_title = 'Allow action';
	}
	
	$high_amount_id = $level_options[3];
	if(!$high_amount_id){
		$high_amount_action_title = 'Skip';

	}else{	
		$high_amount_action_title = 'Allow action';
	}
	
	$approver_type_id = $level_options[4];
	
	if(!$approver_type_id){
		$approver_type_title = 'Location specific';
		
		$standard_approver_holder_display = '';
		$user_approver_holder_display = 'display:none;';
		
	}else if($approver_type_id ==1){
		$approver_type_title = 'User specific';
		$standard_approver_holder_display = 'display:none;';
		$user_approver_holder_display = '';
		
	}
	
	$approver_level_id = $level_options[5];
	if(!$approver_level_id){
		$approver_level_title = 'Region level approvers';
		$location_table = 'regions';
		
	}else if($approver_level_id ==1){
		$approver_level_title = 'Province level approvers';
		$location_table = 'provinces';
		
	}else if($approver_level_id ==2){
		$approver_level_title = 'Hub level approvers';
		$location_table = 'hubs';
		
	}else if($approver_level_id ==3){
		$approver_level_title = 'Site level approvers';
		$location_table = 'sites';
		
	}
	
	$location_area_id = $level_options[6];
	if(!$location_area_id){
		$location_area_title = 'Select item';
		
	}else{
		$this_location = mysqli_query($connect,"select * from $location_table where id = $location_area_id")or die(mysqli_error($connect));
		$this_location_results = mysqli_fetch_array($this_location,MYSQLI_ASSOC);
		
		$location_area_title = $this_location_results['title'];
	
	}
	
	$unit_id = $level_options[7];
	if(!$unit_id){
		$unit_title = 'Select item';
		
	}else{
		$unit = mysqli_query($connect,"select * from units where id = $unit_id")or die(mysqli_error($connect));
		$unit_results = mysqli_fetch_array($unit,MYSQLI_ASSOC);
		$unit_title = $unit_results['title'];
		
	}
	
	$group_id = $level_options[8];
	if(!$group_id){
		$group_title = 'Select item';
		
	}else{
		$group = mysqli_query($$module_connect,"select * from approval_thresholds where id = $group_id")or die(mysqli_error($$module_connect));
		$group_results = mysqli_fetch_array($group,MYSQLI_ASSOC);
		
		$group_title = $group_results['title'];
	}
	
	$approval_user_id = $level_options[9];
	if(!$approval_user_id){
		$user_title = 'Select item';
		
	}else{
		$approval_user = mysqli_query($connect,"select * from users where id = $approval_user_id")or die(mysqli_error($connect));
		$approval_user_results = mysqli_fetch_array($approval_user,MYSQLI_ASSOC);
		$user_title = $approval_user_results['_name'];
	}
	
	
	$user_allocation_id = $level_options[10];
	if(!$user_allocation_id){
		$user_allocation_title = "Don't allow";
		
	}else{
		$user_allocation_title = "Allow";
		
	}
		
	?>
<div style="width:100%;height:auto;float:left;margin-bottom:35px;" id="approver_<?php print($a);?>">
<div style="width:100%;height:20px;line-height:20px;float:left;text-align:left;background-color:#eee;font-weight:bold;" id="approver_header_<?php print($a);?>">Approver 1</div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Limit amount:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#limit_amount_menu_<?php print($a);?>').toggle('fast');" id="active_limit_amount_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($limitation_title);?></div>

		<div class="option_menu" id="limit_amount_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_amount_menu_<?php print($a);?>').toggle('fast');$('#active_limit_amount_<?php print($a);?>').html($(this).html());$('#selected_limit_amount_<?php print($a);?>').val(0);$('#limitation_amount_holder_<?php print($a);?>').slideUp('fast');">No</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_amount_menu_<?php print($a);?>').toggle('fast');$('#active_limit_amount_<?php print($a);?>').html($(this).html());$('#selected_limit_amount_<?php print($a);?>').val(1);$('#limitation_amount_holder_<?php print($a);?>').slideDown('fast');">Yes</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_limit_amount_<?php print($a);?>" value="<?php print($limitation_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;<?php print($amount_holder_display);?>" id="limitation_amount_holder_<?php print($a);?>">
<div style="width:100px;height:30px;line-height:30px;float:left;">Limit amount (K):</div>
<div style="width:250px;height:30px;float:left;line-height:30px;"><input type="text" id="limit_amount_value_<?php print($a);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="<?php print($limit_amount_value_title);?>" onfocus = "if(this.value=='Enter amount here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='<?php print($limit_amount_value_title);?>';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Low amounts:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#low_amount_menu_<?php print($a);?>').toggle('fast');" id="active_low_amount_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($low_amount_action_title);?></div>

		<div class="option_menu" id="low_amount_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#low_amount_menu_<?php print($a);?>').toggle('fast');$('#active_low_amount_<?php print($a);?>').html($(this).html());$('#selected_low_amount_<?php print($a);?>').val(0);">Skip if other approver exists</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#low_amount_menu_<?php print($a);?>').toggle('fast');$('#active_low_amount_<?php print($a);?>').html($(this).html());$('#selected_low_amount_<?php print($a);?>').val(1);">Allow action</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_low_amount_<?php print($a);?>" value="<?php print($low_amount_id);?>">
</div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">High amounts:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#high_amount_menu_<?php print($a);?>').toggle('fast');" id="active_high_amount_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($high_amount_action_title);?></div>

		<div class="option_menu" id="high_amount_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#high_amount_menu_<?php print($a);?>').toggle('fast');$('#active_high_amount_<?php print($a);?>').html($(this).html());$('#selected_high_amount_<?php print($a);?>').val(0);">Skip</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#high_amount_menu_<?php print($a);?>').toggle('fast');$('#active_high_amount_<?php print($a);?>').html($(this).html());$('#selected_high_amount_<?php print($a);?>').val(1);">Allow action</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_high_amount_<?php print($a);?>" value="<?php print($high_amount_id);?>">
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Approver type:</div>
	<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#approver_type_menu_<?php print($a);?>').toggle('fast');" id="active_approver_type_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($approver_type_title);?></div>

	<div class="option_menu" id="approver_type_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_<?php print($a);?>').toggle('fast');$('#active_approver_type_<?php print($a);?>').html($(this).html());$('#selected_approver_type_<?php print($a);?>').val(0);$('#location_approver_holder_<?php print($a);?>').slideDown('fast');$('#user_approver_holder_<?php print($a);?>').slideUp('fast');">Location specific</div>
	
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_<?php print($a);?>').toggle('fast');$('#active_approver_type_<?php print($a);?>').html($(this).html());$('#selected_approver_type_<?php print($a);?>').val(1);$('#location_approver_holder_<?php print($a);?>').slideUp('fast');$('#user_approver_holder_<?php print($a);?>').slideDown('fast');">User specific</div>
	</div>
	<input type="hidden" id="selected_approver_type_<?php print($a);?>" value="<?php print($approver_type_id);?>">
	</div>
</div>

<div style="width:80%;height:auto;float:left;margin-left:40px;<?php print($standard_approver_holder_display);?>" id="location_approver_holder_<?php print($a);?>">
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location level:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_location_type_menu_<?php print($a);?>').toggle('fast');" id="active_approver_level_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($approver_level_title);?></div>

			<div class="option_menu" id="approver_location_type_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($a);?>').toggle('fast');$('#active_approver_level_<?php print($a);?>').html($(this).html());$('#selected_approver_type_<?php print($a);?>').val(0);fetch_menu_items('connect','regions','company_id',<?php print($company_id);?>,'approver_area_<?php print($a);?>',1,1,'');$('#error_message').slideUp('fast');">Region level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($a);?>').toggle('fast');$('#active_approver_level_<?php print($a);?>').html($(this).html());$('#selected_approver_type_<?php print($a);?>').val(1);fetch_menu_items('connect','provinces','company_id',<?php print($company_id);?>,'approver_area_<?php print($a);?>',1,1,'');$('#error_message').slideUp('fast');">Province level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($a);?>').toggle('fast');$('#active_approver_level_<?php print($a);?>').html($(this).html());$('#selected_approver_type_<?php print($a);?>').val(2);fetch_menu_items('connect','hubs','company_id',<?php print($company_id);?>,'approver_area_<?php print($a);?>',1,1,'');$('#error_message').slideUp('fast');">Hub level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($a);?>').toggle('fast');$('#active_approver_level_<?php print($a);?>').html($(this).html());$('#selected_approver_type_<?php print($a);?>').val(3);fetch_menu_items('connect','sites','company_id',<?php print($company_id);?>,'approver_area_<?php print($a);?>',1,1,'');$('#error_message').slideUp('fast');">Site level approvers</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_approver_type_<?php print($a);?>" value="<?php print($approver_level_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;" id="location_holder_<?php print($a);?>">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_area_<?php print($a);?>_menu').toggle('fast');" id="active_approver_area_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($location_area_title);?></div>

			<div class="option_menu" id="approver_area_<?php print($a);?>_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
		$locations = mysqli_query($connect,"select * from $location_table where company_id = $company_id order by title")or die(mysqli_error($connect));
		?>
			
				<?php
				for($l2=0;$l2<mysqli_num_rows($locations);$l2++){
					$locations_results = mysqli_fetch_array($locations,MYSQLI_ASSOC);
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_area_<?php print($a);?>_menu').toggle('fast');$('#active_approver_area_<?php print($a);?>').html($(this).html());$('#selected_approver_area_<?php print($a);?>').val(<?php print($locations_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($locations_results['title']);?></div>
					
					
					<?php 
				}
				?>
			
			</div>
	</div>
	<input type="hidden" id="selected_approver_area_<?php print($a);?>" value="<?php print($location_area_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Unit:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_unit_menu_<?php print($a);?>').toggle('fast');" id="active_approver_unit_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($unit_title);?></div>

			<div class="option_menu" id="approver_unit_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_<?php print($a);?>').toggle('fast');$('#active_approver_unit_<?php print($a);?>').html($(this).html());$('#selected_approver_unit_<?php print($a);?>').val(0);$('#error_message').slideUp('fast');">All Units</div>
			
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_<?php print($a);?>').toggle('fast');$('#active_approver_unit_<?php print($a);?>').html($(this).html());$('#selected_approver_unit_<?php print($a);?>').val(<?php print($unit_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_unit_<?php print($a);?>" value="<?php print($unit_id);?>">
</div></div></div>


<div style="width:80%;height:auto;float:left;margin-left:40px;<?php print($user_approver_holder_display);?>" id="user_approver_holder_<?php print($a);?>">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:60px;">User:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_user_menu_<?php print($a);?>').toggle('fast');" id="active_approver_user_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;"><?php print($user_title);?></div>

			<div class="option_menu" id="approver_user_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
			
				$user_menu = mysqli_query($connect,"select * from users where company_id = $company_id and status = 1 order by _name")or die(mysqli_error($connect));

				for($u=0;$u<mysqli_num_rows($user_menu);$u++){
					$user_menu_results = mysqli_fetch_array($user_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_user_menu_<?php print($a);?>').toggle('fast');$('#active_approver_user_<?php print($a);?>').html($(this).html());$('#selected_approver_user_<?php print($a);?>').val(<?php print($user_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($user_menu_results['_name']);?></div>
					<?php
				}
			?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_user_<?php print($a);?>" value="<?php print($approval_user_id);?>">
</div></div></div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">User allocation:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#user_allocation_menu_<?php print($a);?>').toggle('fast');" id="active_user_allocation_<?php print($a);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($user_allocation_title);?></div>

		<div class="option_menu" id="user_allocation_menu_<?php print($a);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_allocation_menu_<?php print($a);?>').toggle('fast');$('#active_user_allocation_<?php print($a);?>').html($(this).html());$('#selected_user_allocation_<?php print($a);?>').val(0);">Don't allow</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_allocation_menu_<?php print($a);?>').toggle('fast');$('#active_user_allocation_<?php print($a);?>').html($(this).html());$('#selected_user_allocation_<?php print($a);?>').val(1);">Allow</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_user_allocation_<?php print($a);?>" value="<?php print($user_allocation_id);?>">
</div>
<input id="approver_active_<?php print($a);?>" value="1" type="hidden">
</div>
<?php
}
?>
</div>
<input type="hidden" id="total_approvers" value="<?php print(count($approver_array));?>">
<div style="margin-bottom:5px;cursor:pointer;width:100%;float:left;height:20px;line-height:20px;background-color:#bbb;color:#fff;text-align:center;" onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#bbb'" onclick="add_group_approver();">Add</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>

<div style="width:100%;height:auto;float:left;margin-bottom:30px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_threshold_button" onclick="create_or_update_threshold(<?php print($threshold_id);?>);" title="Click to save details"><?php print($button_text);?></div>

<?php
if($threshold_id){
	if($threshold_status){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="threshold_status_change_button" onclick="enable_or_disable_threshold(<?php print($threshold_id);?>,0);" title="Click to disable">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="threshold_status_change_button" onclick="var c = confirm('Are you sure you wish to disable this settings?');if(c){enable_or_disable_threshold(<?php print($threshold_id);?>,1);}" title="Click to enable">Enable</div>
<?php
		
	}
}
?>
</div>


<div style="width:100%;height:auto;float:left;display:none;" id="default_approver">
<div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;background-color:#eee;"><div style="width:auto;font-weight:bold;float:left;height:20px;line-height:20px;text-align:center;" id="approver_header_z">Approver 1</div> <div style="width:20px;height:20px;background-color:brown;float:right;text-align:center;line-height:20px;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#c94444';" onmouseout="this.style.backgroundColor='brown';" title="Click to remove this approver" onclick="var c = confirm('Are you sure you wish to remove this approver?');if(c){$('#approver_active_z').val(0);$('#approver_z').slideUp('fast');}">X</div></div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Limit amount:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#limit_amount_menu_z').toggle('fast');" id="active_limit_amount_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Yes</div>

		<div class="option_menu" id="limit_amount_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_amount_menu_z').toggle('fast');$('#active_limit_amount_z').html($(this).html());$('#selected_limit_amount_z').val(0);$('#limitation_amount_holder_z').slideUp('fast');">No</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_amount_menu_z').toggle('fast');$('#active_limit_amount_z').html($(this).html());$('#selected_limit_amount_z').val(1);$('#limitation_amount_holder_z').slideDown('fast');">Yes</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_limit_amount_z" value="1">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;" id="limitation_amount_holder_z">
<div style="width:100px;height:30px;line-height:30px;float:left;">Limit amount (K):</div>
<div style="width:250px;height:30px;float:left;line-height:30px;"><input type="text" id="limit_amount_value_z" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter amount here" onfocus = "if(this.value=='Enter amount here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter amount here';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Low amounts:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#low_amount_menu_z').toggle('fast');" id="active_low_amount_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Skip if other approver exists</div>

		<div class="option_menu" id="low_amount_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#low_amount_menu_z').toggle('fast');$('#active_low_amount_z').html($(this).html());$('#selected_low_amount_z').val(0);">Skip if other approver exists</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#low_amount_menu_z').toggle('fast');$('#active_low_amount_z').html($(this).html());$('#selected_low_amount_z').val(1);">Allow action</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_low_amount_z" value="0">
</div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">High amounts:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#high_amount_menu_z').toggle('fast');" id="active_high_amount_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Allow action</div>

		<div class="option_menu" id="high_amount_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#high_amount_menu_z').toggle('fast');$('#active_high_amount_z').html($(this).html());$('#selected_high_amount_z').val(0);">Skip</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#high_amount_menu_z').toggle('fast');$('#active_high_amount_z').html($(this).html());$('#selected_high_amount_z').val(1);">Allow action</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_high_amount_z" value="1">
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Approver type:</div>
	<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#approver_type_menu_z').toggle('fast');" id="active_approver_type_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Location specific</div>

	<div class="option_menu" id="approver_type_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_z').toggle('fast');$('#active_approver_type_z').html($(this).html());$('#selected_approver_type_z').val(0);$('#location_approver_holder_z').slideDown('fast');$('#user_approver_holder_z').slideUp('fast');$('#group_approver_holder_z').slideUp('fast');">Location specific</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_z').toggle('fast');$('#active_approver_type_z').html($(this).html());$('#selected_approver_type_z').val(1);$('#location_approver_holder_z').slideUp('fast');$('#user_approver_holder_z').slideDown('fast');$('#group_approver_holder_z').slideUp('fast');">User specific</div>
	</div>
	<input type="hidden" id="selected_approver_type_z" value="0">
	</div>
</div>

<div style="width:80%;height:auto;float:left;margin-left:40px;" id="location_approver_holder_z">
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location level:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_location_type_menu_z').toggle('fast');" id="active_approver_level_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Region level approvers</div>

			<div class="option_menu" id="approver_location_type_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_z').toggle('fast');$('#active_approver_level_z').html($(this).html());$('#selected_approver_type_z').val(0);fetch_menu_items('connect','regions','company_id',<?php print($company_id);?>,'approver_area_z',1,1,'');$('#error_message').slideUp('fast');">Region level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_z').toggle('fast');$('#active_approver_level_z').html($(this).html());$('#selected_approver_type_z').val(1);fetch_menu_items('connect','provinces','company_id',<?php print($company_id);?>,'approver_area_z',1,1,'');$('#error_message').slideUp('fast');">Province level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_z').toggle('fast');$('#active_approver_level_z').html($(this).html());$('#selected_approver_type_z').val(2);fetch_menu_items('connect','hubs','company_id',<?php print($company_id);?>,'approver_area_z',1,1,'');$('#error_message').slideUp('fast');">Hub level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_z').toggle('fast');$('#active_approver_level_z').html($(this).html());$('#selected_approver_type_z').val(3);fetch_menu_items('connect','sites','company_id',<?php print($company_id);?>,'approver_area_z',1,1,'');$('#error_message').slideUp('fast');">Site level approvers</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_approver_type_z" value="0">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;" id="location_holder_z">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_area_z_menu').toggle('fast');" id="active_approver_area_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select location</div>

			<div class="option_menu" id="approver_area_z_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
		$locations = mysqli_query($connect,"select * from regions where company_id = $company_id")or die(mysqli_error($connect));
		?>
			
				<?php
				for($l2=0;$l2<mysqli_num_rows($locations);$l2++){
					$locations_results = mysqli_fetch_array($locations,MYSQLI_ASSOC);
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_area_z_menu').toggle('fast');$('#active_approver_area_z').html($(this).html());$('#selected_approver_area_z').val(<?php print($locations_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($locations_results['title']);?></div>
					
					
					<?php 
				}
				?>
			
			</div>
	</div>
	<input type="hidden" id="selected_approver_area_z" value="0">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Unit:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_unit_menu_z').toggle('fast');" id="active_approver_unit_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($default_unit_title);?></div>

			<div class="option_menu" id="approver_unit_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_z').toggle('fast');$('#active_approver_unit_z').html($(this).html());$('#selected_approver_unit_z').val(0);$('#error_message').slideUp('fast');">All Units</div>
			
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_z').toggle('fast');$('#active_approver_unit_z').html($(this).html());$('#selected_approver_unit_z').val(<?php print($unit_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_unit_z" value="<?php print($default_unit_id);?>">
</div></div></div>

<div style="width:80%;height:auto;float:left;margin-left:40px;display:none;" id="user_approver_holder_z">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:60px;">User:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_user_menu_z').toggle('fast');" id="active_approver_user_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;">Select user</div>

			<div class="option_menu" id="approver_user_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
			
				$user_menu = mysqli_query($connect,"select * from users where company_id = $company_id and status = 1 order by _name")or die(mysqli_error($connect));

				for($u=0;$u<mysqli_num_rows($user_menu);$u++){
					$user_menu_results = mysqli_fetch_array($user_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_user_menu_z').toggle('fast');$('#active_approver_user_z').html($(this).html());$('#selected_approver_user_z').val(<?php print($user_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($user_menu_results['_name']);?></div>
					<?php
				}
			?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_user_z" value="0">
</div></div></div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">User allocation:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<div class="option_item" title="Click to change option" onclick="$('#user_allocation_menu_z').toggle('fast');" id="active_user_allocation_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Don't allow</div>

		<div class="option_menu" id="user_allocation_menu_z" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_allocation_menu_z').toggle('fast');$('#active_user_allocation_z').html($(this).html());$('#selected_user_allocation_z').val(0);">Don't allow</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_allocation_menu_z').toggle('fast');$('#active_user_allocation_z').html($(this).html());$('#selected_user_allocation_z').val(1);">Allow</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_user_allocation_z" value="0">
</div>
<input id="approver_active_z" value="1" type="hidden">
</div>