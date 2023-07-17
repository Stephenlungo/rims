<?php
	$this_scheduler = mysqlI_query($$module_connect,"select * from request_type_scheduler where id = $schedule_id")or die(mysqli_error($$module_connect));
	
	if(mysqli_num_rows($this_scheduler)){
		$this_scheduler_results = mysqli_fetch_array($this_scheduler,MYSQLI_ASSOC);
		$trigger_id = $this_scheduler_results['trigger_type_id'];
		$_type = $this_scheduler_results['_type'];
		
		$schedule_holder_display = '';
		$specific_month_day_holder_display = 'display:none;';
		$specific_day_holder_display = '';
		if($trigger_id == 0){
			$trigger_title = 'None';
			$schedule_holder_display = 'display:none;';
			
		}else if($trigger_id == 1){
			$trigger_title = 'Beginning of the month';
			
		}else if($trigger_id == 2){
			$trigger_title = 'End of the month';
			
			
		}else if($trigger_id == 3){
			$trigger_title = 'Specific day of the month';
			$specific_month_day_holder_display = '';
			$specific_day_holder_display = 'display:none';
		}
		
		$specific_day_trigger  = $this_scheduler_results['specific_day_trigger'];
		
		if($specific_day_trigger == '0'){
			$specific_day_title = 'Any day';
			
		}else{
			$specific_day_title = $specific_day_trigger;
			
		}
		
		$specific_month_day  = $this_scheduler_results['trigger_month_day'];
		
		$claim_payment_dates = explode('|',$this_scheduler_results['claim_payment_dates']);
		
		$payment_from_date = explode(']',$claim_payment_dates[0]);
		
		$payment_from_day = $payment_from_date[0];
		$payment_from_operator = $payment_from_date[2];
		$payment_from_addition = $payment_from_date[3];
		
		$payment_to_date = explode(']',$claim_payment_dates[1]);
		
		$payment_to_day = $payment_to_date[0];
		$payment_to_operator = $payment_to_date[2];
		$payment_to_addition = $payment_to_date[3];
		
		
		$recurrence = $this_scheduler_results['recurrence'];		
		if($recurrence == 0){
			$recurrence_title = 'Once';
			
		}else{
			$recurrence_title = 'Continuous';
			
		}
		
		$schedule_type = $this_scheduler_results['schedule_type'];
		$days_worked_holder_display = '';
		if(!$schedule_type){
			$schedule_type_title = 'Place reminder';
			
		}else{
			$schedule_type_title = 'Create claim';
			
		}
		
		$location_depth = $this_scheduler_results['location_depth'];
		
		$unspecified_locations_holder_display = '';
		if($location_depth == 0){
			$location_depth_title = 'Facility';
			
		}else if($location_depth == 1){
			$location_depth_title = 'Mother facility';
			
		}else if($location_depth == 2){
			$location_depth_title = 'Hub';
			
		}else if($location_depth == 3){
			$location_depth_title = 'Province';
			
		}else if($location_depth == 4){
			$location_depth_title = 'Region';
			
		}else if($location_depth == 5){
			$location_depth_title = 'All in one claim';
			$unspecified_locations_holder_display = 'display:none;';
		}
		
		$unspecified_locations = $this_scheduler_results['unspecified_locations'];
		if($unspecified_locations == 0){
			$unspecified_locations_title = 'Skip';
			
		}else if($unspecified_locations == 1){
			$unspecified_locations_title = 'Create separate';
			
		}
		
		$force_days_id = $this_scheduler_results['force_days_worked'];
		$force_days_holder_display = 'display:none';
		if(!$force_days_id){
			$days_worked_type_title = 'Show PIPAT days';
			
		}else{
			$days_worked_type_title = 'Force days worked if PIPAT days are less';
			$force_days_holder_display = '';
			
		}
		
		$days_worked = $this_scheduler_results['days_worked'];
		$justification = $this_scheduler_results['justification_message'];
		
		$justification_field_color = '#000';
		if($justification == ''){
			$justification = 'Enter justification here';
			$justification_field_color = '#aaa';
		}
		
		$schedule_rule = $this_scheduler_results['schedule_rule'];		
		if(!$schedule_rule){
			$schedule_rule_title = 'Skip beneficiary if claim exists';
			
		}else if($schedule_rule == 1){
			$schedule_rule_title = 'Skip if user-defined schedule exists';
			
		}else if($schedule_rule == 2){
			$schedule_rule_title = 'Ignore claims and user-defined schedules';
			
		}
		
		$beneficiary_type = $this_scheduler_results['beneficiary_type'];
		$group_specific_holder_display = 'display:none;';
		$unit_specific_display_holder = 'display:none;';
		$agent_specific_display_holder = 'display:none;';
		
		if(!$beneficiary_type){			
			$beneficiary_type_title = 'Group specific';
			$group_specific_holder_display = '';
			
		}else if($beneficiary_type == 1){
			$beneficiary_type_title = 'Unit specific';
			$unit_specific_display_holder = '';
			
		}else if($beneficiary_type == 2){
			$beneficiary_type_title = 'Group and unit specific';
			$agent_specific_display_holder = '';
			$unit_specific_display_holder = '';
			
		}else if($beneficiary_type == 3){
			$beneficiary_type_title = 'Specific agents';
			$agent_specific_display_holder = '';
			
		}
		
		$beneficiary_group_id = $this_scheduler_results['beneficiary_group_id'];
		$beneficiary_unit_id = $this_scheduler_results['beneficiary_unit_id'];
		$specific_agent_ids = $this_scheduler_results['specific_agent_ids'];
		$email_on_exec = $this_scheduler_results['email_on_exec'];
		
		$this_region_id = $this_scheduler_results['region_id'];
		if(!$this_region_id){
			$this_region_title = 'All Regions';
			$this_region_id = 0;
			
		}else{		
			$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
			$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			
			$this_region_title = $this_region_results['title'];
		}
		
		$this_province_id = $this_scheduler_results['province_id'];
		if(!$this_province_id){
			$this_province_title = 'All Provinces';
			
		}else{
			$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
			$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
			
			$this_province_title = $this_province_results['title'];		
		}
		
		$this_hub_id = $this_scheduler_results['hub_id'];
		if(!$this_hub_id){
			$this_hub_title = 'All Hubs';
			
		}else{
			$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
			$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
			
			$this_hub_title = $this_hub_results['title'];
		}
		
		$this_mother_facility_id = $this_scheduler_results['mother_facility_id'];
		if(!$this_mother_facility_id){
			$this_mother_facility_title = 'All Mother Facilities';
			
		}else{
			$this_mother_facility = mysqli_query($connect,"select * from mother_facilities where id = $this_mother_facility_id")or die(mysqli_error($connect));
			$this_mother_facility_results = mysqli_fetch_array($this_mother_facility,MYSQLI_ASSOC);
			
			$this_mother_facility_title = $this_mother_facility_results['title'];
		}
		
		$this_site_id = $this_scheduler_results['site_id'];
		if(!$this_site_id){
			$this_site_title = 'All Sites';
			
		}else{
			$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
			$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
			
			$this_site_title = $this_site_results['title'];
		}
		
		$claim_type_dates = $this_scheduler_results['request_type_dates'];
		
		$claim_type_date_array = explode(',',$claim_type_dates);
		if(count($claim_type_date_array) > 1){
			$claim_type_title = '<i>Multiple</i>';
			
		}else{
			$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$claim_type_dates' and company_id = $company_id")or die(mysqlI_error($$module_connect));
			$claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
			
			$claim_type_title = $claim_type_results['title'];
		}
		
		$button_text = 'Update';
	}else{
		$_type = 1;
		$trigger_id = 1;		
		$trigger_title = 'Beginning of the month';
		$schedule_holder_display = '';

		$specific_day_trigger  = 0;
		$specific_day_title = 'Any day';
		$specific_day_holder_display = '';
		
		$specific_month_day  = 1;
		$specific_month_day_holder_display = 'display:none;';
		
		$payment_from_day = 1;
		$payment_from_operator = '+';
		$payment_from_addition = 0;
		
		$payment_to_day = 1;
		$payment_to_operator = '+';
		$payment_to_addition = 0;		
		
		$recurrence = 0;		
		$recurrence_title = 'Once';			

		$schedule_type = 0;
		$location_depth = 2;
		$location_depth_title = 'Hub';
		
		$unspecified_locations = 1;
		$unspecified_locations_title = 'Create separate';
		$unspecified_locations_holder_display = '';
		
		$days_worked_holder_display = '';
		$schedule_type_title = 'Place reminder';
		
		$force_days_id = 0;
		$force_days_holder_display = 'display:none';
		$days_worked_type_title = 'Show PIPAT days';
			
		$days_worked = 0;
		$justification = 'Enter justification here';
		$justification_field_color = '#aaa';

		$schedule_rule = 0;		
		$schedule_rule_title = 'Skip beneficiary if claim exists';
		
		$beneficiary_type = 0;
		$group_specific_holder_display = '';
		$unit_specific_display_holder = 'display:none;';
		$agent_specific_display_holder = 'display:none;';

		$beneficiary_type_title = 'Group specific';
		
		$beneficiary_group_id = '';
		$beneficiary_unit_id = 0;
		$specific_agent_ids = '';
		$email_on_exec = 1;
		
		$this_region_id = $user_results['region_id'];
		if(!$this_region_id){
			$this_region_title = 'Select region';
			$this_region_id = -1;
			
		}else{
			$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
			$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			
			$this_region_title = $this_region_results['title'];
		}
		
		$this_province_id = $user_results['province_id'];
		if(!$this_province_id){
			$this_province_title = 'All Provinces';
			
		}else{
			$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
			$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
			
			$this_province_title = $this_province_results['title'];		
		}
		
		$this_hub_id = $user_results['hub_id'];
		if(!$this_hub_id){
			$this_hub_title = 'All Hubs';
			
		}else{
			$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
			$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
			
			$this_hub_title = $this_hub_results['title'];
		}
		
		$this_mother_facility_id = $user_results['mother_facility_id'];
		if(!$this_mother_facility_id){
			$this_mother_facility_title = 'All Mother Facilities';
			
		}else{
			$this_mother_facility = mysqli_query($connect,"select * from mother_facilities where id = $this_mother_facility_id")or die(mysqli_error($connect));
			$this_mother_facility_results = mysqli_fetch_array($this_mother_facility,MYSQLI_ASSOC);
			
			$this_mother_facility_title = $this_mother_facility_results['title'];
		}
		
		$this_site_id = $user_results['site_id'];
		if(!$this_site_id){
			$this_site_title = 'All Sites';
			
		}else{
			$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
			$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
			
			$this_site_title = $this_site_results['title'];
		}
		$claim_type_title = 'Select item';
		$claim_type_dates = '';
		
		$button_text = 'Create';
	}
	?>

<div style="width:750px;height:400px;border:solid 1px purple;position:absolute;margin-left:10px;background-color:#fff;padding:2px;display:none;" id="agent_search_holder">
<div style="width:100%;height:20px;line-height:20px;color:#fff;float:left;background-color:#ab5dab;text-align:center;margin-bottom:5px;">Agent Search <div style="width:20px;height:20px;line-height:20px;text-align:center;float:right;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';" onclick="$('#agent_search_holder').fadeOut('fast');" title="Click to close">X</div></div>
<div style="width:100%;height:30px;line-height:30px;">
	<div style="width:420px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<input type="text" id="agent_search_key" value="Enter agent name, ID or phone number" style="width:350px;float:left;height:30px;color:#aaa;text-align:center;foat:left;" onfocus="if(this.value=='Enter agent name, ID or phone number'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter agent name, ID or phone number';this.style.color='#aaa';}" title="Enter agent name, ID or phone number. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13) {fetch_request_type_agent();}">
	
		<div style="width:60px;height:30px;background-color:#f4eff4;color:#000;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#f0ddf0';" onmouseout="this.style.backgroundColor='#f4eff4';"  id="requeest_type_agent_button" onclick="fetch_request_type_agent();" title="Click to fetch report with specified options">Search</div>
	</div>
</div>
<div style="width:100%;height:20px;float:left;background-color:#f4eff4;margin-top:5px;">
<div style="width:100%;height:20px;line-height:20px;float:left;"><div style="width:20px;height:20px;float:left;margin-right:3px;"></div><div style="width:130px;height:20px;float:left;margin-right:3px;">Cluster</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:120px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:117px;height:20px;float:left;margin-right:3px;">Job Title</div></div></div>

<div style="width:99.5%;height:auto:float:left;height:300px;overflow:auto;" id="search_agent_results_holder"></div>

</div>

<div style="width:48%;height:auto;float:left;">
<div style="width:100%;height:auto;float:left;" id="auto_scheduler">
<div style="line-height:30px;width:100px;height:30px;float:left;">Claim type: </div>
<div style="min-width:100px;width:auto;min-height:30px;height:auto;float:left;" onclick="$('#claim_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="<?php if(!$_type){?> alert('You cannot change this option');<?php }else{?>$('#claim_type_menu').toggle('fast');<?php }?>" id="active_claim_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;width:auto;"><?php print($claim_type_title);?></div>
<div class="option_menu" id="claim_type_menu" style="display:none;">
<?php

if(!$user_results['region_id']){
	$filter_string = ' and status = 1';
	
}else if(!$user_results['province_id']){
	$filter_string = ' and (region_id = '.$user_results['region_id'].' or region_id = 0) and status = 1';
		
}else if(!$user_results['hub_id']){
	$filter_string = ' and (province_id = '.$user_results['province_id'].') or ((region_id = '.$user_results['region_id'].' and province_id = 0) or region_id = 0) and status = 1';
	
}else if(!$user_results['site_id']){
	$filter_string = ' and (hub_id = '.$user_results['hub_id'].') or (province_id = '.$user_results['province_id'].' and hub_id = 0) or (region_id = '.$user_results['region_id'].' and province_id = 0) or (region_id = 0) and status = 1';
	
}else{
	$filter_string = ' and (site_id = '.$user_results['site_id'].') or (hub_id = '.$user_results['hub_id'].' and site_id = 0) or (province_id = '.$user_results['province_id'].' and hub_id = 0) or (region_id = '.$user_results['region_id'].' and province_id = 0) or (region_id = 0) and status = 1';
	
}

$request_types = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id $filter_string order by title")or die(mysqli_error($$module_connect));

for($c=0;$c<mysqli_num_rows($request_types);$c++){
	$request_types_results = mysqli_fetch_array($request_types,MYSQLI_ASSOC);
	
	if(validate_claim_rules($company_id,$user_id,$request_types_results['_date'],0,0)){
		if(!$request_types_results['billing_type']){
			$claim_type_rate = ' (K'.number_format($request_types_results['daily_rate']).' per day)';
			
		}else{
			$claim_type_rate = ' (K'.number_format($request_types_results['fixed_amount']).' fixed)';
			
		}
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" style="min-width:350px;width:100%;"><input type="checkbox" id="claim_check_<?php print($request_types_results['_date']);?>" onclick="if(this.checked){add_to_selection(<?php print($request_types_results['_date']);?>,'selected_claim_type');}else{remove_from_selection(<?php print($request_types_results['_date']);?>,'selected_claim_type');}refresh_request_types();$('#active_claim_type').html('[Multiple]');" <?php if(search_item_in_list($request_types_results['_date'],$claim_type_dates,0)){print(' checked ');}?>><a onclick="$('#claim_type_menu').toggle('fast');$('#active_claim_type').html('<?php print($request_types_results['title']);?>');add_claim_type(<?php print($request_types_results['_date']);?>);" id="claim_type_title_<?php print($request_types_results['_date']);?>"><?php print($request_types_results['title'].$claim_type_rate);?></a></div>
		<input type="hidden" id="claim_rate_<?php print($request_types_results['_date']);?>" value="<?php print($request_types_results['daily_rate']);?>">
		<?php
	}
}
?>
</div>
<input type="hidden" name="selected_claim_type" id="selected_claim_type" value="<?php print($claim_type_dates);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Trigger:</div>
	<div style="width:170px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#schedule_trigger_menu').toggle('fast');" id="active_schedule_trigger" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:80px;width:auto;"><?php print($trigger_title);?></div>

	<div class="option_menu" id="schedule_trigger_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_trigger_menu').toggle('fast');$('#active_schedule_trigger').html($(this).html());$('#selected_schedule_trigger').val(1);$('#trigger_day').slideDown('fast');$('#trigger_date').slideUp('fast');$('#scheduler_settings').slideDown('fast');">Beginning of the month</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_trigger_menu').toggle('fast');$('#active_schedule_trigger').html($(this).html());$('#selected_schedule_trigger').val(2);$('#trigger_day').slideDown('fast');$('#trigger_date').slideUp('fast');$('#scheduler_settings').slideDown('fast');">End of the month</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_trigger_menu').toggle('fast');$('#active_schedule_trigger').html($(this).html());$('#selected_schedule_trigger').val(3);$('#trigger_day').slideUp('fast');$('#trigger_date').slideDown('fast');$('#scheduler_settings').slideDown('fast');">Specific day of the month</div>
	
		<input type="hidden" id="selected_schedule_trigger" value="<?php print($trigger_id);?>">
	</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;<?php print($schedule_holder_display);?>" id="scheduler_settings">
<div style="width:100%;height:auto;float:left;<?php print($specific_day_holder_display);?>" id="trigger_day">
<div style="width:100px;height:30px;line-height:30px;float:left;">Day:</div>
	<div style="width:170px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#trigger_day_menu').toggle('fast');" id="active_trigger_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:80px;width:auto;"><?php print($specific_day_title);?></div>

	<div class="option_menu" id="trigger_day_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val(0);">Any day</div>
	
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val('Sun');">Sunday</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val('Mon');">Monday</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val('Tue');">Tuesday</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val('Wed');">Wednesday</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val('Thu');">Thursday</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val('Fri');">Friday</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_day_menu').toggle('fast');$('#active_trigger_day').html($(this).html());$('#selected_trigger_day').val('Sat');">Saturday</div>
		<input type="hidden" id="selected_trigger_day" value="<?php print($specific_day_trigger);?>">
	</div>
</div>
</div>



<div style="width:100%;height:auto;float:left;<?php print($specific_month_day_holder_display);?>" id="trigger_date">
<div style="width:100px;height:30px;line-height:30px;float:left;">Day:</div>
	<div style="width:60px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#trigger_date_menu').toggle('fast');" id="active_trigger_date" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:60px;width:auto;"><?php print($specific_month_day);?></div>

	<div class="option_menu" id="trigger_date_menu" style="display:none;min-width:60px;width:auto;">
		
		<?php
		for($j=1;$j<32;$j++){
			?>
	
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_date_menu').toggle('fast');$('#active_trigger_date').html($(this).html());$('#selected_trigger_date').val(<?php print($j);?>);"><?php print($j);?></div>
		
		<?php
		}
		?>
			
		
		<input type="hidden" id="selected_trigger_date" value="<?php print($specific_month_day);?>">
	</div>
</div>
</div>



<div style="width:100%;height:auto;float:left;margin-top:5px;">
		<div style="width:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Payment from:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_day_menu').toggle('fast');" id="active_from_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($payment_from_day);?></div>

<div class="option_menu" id="from_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_day_menu').toggle('fast');$('#active_from_day').html($(this).html());$('#selected_from_day').val(<?php print($d);?>);" style="width:40px;"><?php print($do);?></div>
		<?php
	}
	
}else{
	for($d=31;$d>0;$d--){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_day_menu').toggle('fast');$('#active_from_day').html($(this).html());$('#selected_from_day').val(<?php print($d);?>););" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_from_day" id="selected_from_day" value="<?php print($payment_from_day);?>">
</div>
<div style="width:auto;height:auto;float:left;border:solid 1px #ddd;padding-left:5px;">
<div style="line-height:30px;width:45px;height:30px;float:left;">Month:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="alert('This represents month of execution and cannot be changed')" id="active_from_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" title="This represents month of execution and cannot be changed">[Month]</div>


<div class="option_menu" id="from_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_month_menu').toggle('fast');$('#active_from_month').html($(this).html());$('#selected_from_month').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
		<?php
	}

}else{
	for($m=12;$m>0;$m--){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_month_menu').toggle('fast');$('#active_from_month').html($(this).html());$('#selected_from_month').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_from_month" id="selected_from_month" value="m">
</div>

<div style="width:50px;min-height:30px;height:auto;float:left;text-align:center;margin-left:5px;">
<div class="option_item" title="Click to change option" onclick="$('#payment_from_month_operator_menu').toggle('fast');" id="active_payment_from_month_operator" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($payment_from_operator);?></div>

<div class="option_menu" id="payment_from_month_operator_menu" style="display:none;width:30px;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#payment_from_month_operator_menu').toggle('fast');$('#active_payment_from_month_operator').html($(this).html());$('#selected_payment_from_month_operator').val('+');" style="width:30px;">+</div>
	
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#payment_from_month_operator_menu').toggle('fast');$('#active_payment_from_month_operator').html($(this).html());$('#selected_payment_from_month_operator').val('-');" style="width:30px;">-</div>

</div>
<input type="hidden" name="selected_payment_from_month_operator" id="selected_payment_from_month_operator" value="<?php print($payment_from_operator);?>">
</div>

<div style="width:30px;min-height:30px;height:auto;float:left;"><input type="text" id="payment_from_addition" value="<?php print($payment_from_addition);?>" style="width:100%;height:30px;" onfocusout="if(isNaN(this.value)){alert('Value must be a number');this.value='<?php print($payment_from_addition);?>'}"></div>
</div>
</div>





<div style="width:auto;float:left;margin-top:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Payment to:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#to_day_menu').toggle('fast');" id="active_to_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($payment_to_day);?></div>


<div class="option_menu" id="to_day_menu" style="display:none;">
<?php

if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		
	
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_day_menu').toggle('fast');$('#active_to_day').html($(this).html());$('#selected_to_day').val(<?php print($d);?>);" style="width:40px;"><?php print($do);?></div>
		
		<?php
	}
}else{
	for($d=31;$d>0;$d--){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_day_menu').toggle('fast');$('#active_to_day').html($(this).html());$('#selected_to_day').val(<?php print($d);?>);" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_to_day" id="selected_to_day" value="<?php print($payment_to_day);?>">
</div>

<div style="width:auto;height:auto;float:left;border:solid 1px #eee;padding-left:5px;">
<div style="line-height:30px;width:45px;height:30px;float:left;">Month:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="alert('This represents month of execution and cannot be changed')" id="active_to_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" title="This represents month of execution and cannot be changed">[Month]</div>


<div class="option_menu" id="to_month_menu" style="display:none;">
<?php

if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_month_menu').toggle('fast');$('#active_to_month').html($(this).html());$('#selected_to_month').val(<?php print($m);?>););" style="width:40px;"><?php print($mo);?></div>
	
	<?php
	}
	
}else{
	for($m=12;$m>1;$m--){
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_month_menu').toggle('fast');$('#active_to_month').html($(this).html());$('#selected_to_month').val(<?php print($m);?>););" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_to_month" id="selected_to_month" value="m">
</div>

<div style="width:50px;min-height:30px;height:auto;float:left;text-align:center;margin-left:5px;">
<div class="option_item" title="Click to change option" onclick="$('#payment_to_month_operator_menu').toggle('fast');" id="active_payment_to_month_operator" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($payment_to_operator);?></div>

<div class="option_menu" id="payment_to_month_operator_menu" style="display:none;width:30px;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#payment_to_month_operator_menu').toggle('fast');$('#active_payment_to_month_operator').html($(this).html());$('#selected_payment_to_month_operator').val('+');" style="width:30px;">+</div>
	
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#payment_to_month_operator_menu').toggle('fast');$('#active_payment_to_month_operator').html($(this).html());$('#selected_payment_to_month_operator').val('-');" style="width:30px;">-</div>

</div>
<input type="hidden" name="selected_payment_to_month_operator" id="selected_payment_to_month_operator" value="<?php print($payment_to_operator);?>">
</div>

<div style="width:30px;min-height:30px;height:auto;float:left;"><input type="text" id="payment_to_addition" value="<?php print($payment_to_addition);?>" style="width:100%;height:25px;margin-top:2px;" onfocusout="if(isNaN(this.value)){alert('Value must be a number');this.value='<?php print($payment_to_addition);?>'}"></div>
	</div>
	</div>
</div>






<div style="width:100%;height:auto;float:left;" id="trigger_recurrence">
<div style="width:100px;height:30px;line-height:30px;float:left;">Recurrence:</div>
	<div style="width:170px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#trigger_recurrence_menu').toggle('fast');" id="active_trigger_recurrence" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:80px;width:auto;"><?php print($recurrence_title);?></div>

	<div class="option_menu" id="trigger_recurrence_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_recurrence_menu').toggle('fast');$('#active_trigger_recurrence').html($(this).html());$('#selected_trigger_recurrence').val(0);">Once</div>
	
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#trigger_recurrence_menu').toggle('fast');$('#active_trigger_recurrence').html($(this).html());$('#selected_trigger_recurrence').val(1);">Continuous</div>
		
		<input type="hidden" id="selected_trigger_recurrence" value="<?php print($recurrence);?>">
	</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;" >
<div style="width:100px;height:30px;line-height:30px;float:left;">Schedule type:</div>
	<div style="width:170px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#schedule_type_menu').toggle('fast');" id="active_schedule_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:80px;width:auto;"><?php print($schedule_type_title);?></div>

	<div class="option_menu" id="schedule_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_type_menu').toggle('fast');$('#active_schedule_type').html($(this).html());$('#selected_schedule_type').val(0);">Place reminder</div>
	
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_type_menu').toggle('fast');$('#active_schedule_type').html($(this).html());$('#selected_schedule_type').val(1);">Create claim</div>
		
		<input type="hidden" id="selected_schedule_type" value="<?php print($schedule_type);?>">
	</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;<?php print($days_worked_holder_display);?>" id="days_worked_holder">

<div style="width:100%;height:auto;float:left;" >
	<div style="width:100px;height:30px;line-height:30px;float:left;">Location depth:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#location_depth_menu').toggle('fast');" id="active_location_depth" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:auto;width:auto;"><?php print($location_depth_title);?></div>

		<div class="option_menu" id="location_depth_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#location_depth_menu').toggle('fast');$('#active_location_depth').html($(this).html());$('#selected_location_depth').val(5);$('#unspecified_locations_holder').slideUp('fast');">All in one claim</div>
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#location_depth_menu').toggle('fast');$('#active_location_depth').html($(this).html());$('#selected_location_depth').val(4);$('#unspecified_locations_holder').slideDown('fast');">Region</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#location_depth_menu').toggle('fast');$('#active_location_depth').html($(this).html());$('#selected_location_depth').val(3);$('#unspecified_locations_holder').slideDown('fast');">Province</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#location_depth_menu').toggle('fast');$('#active_location_depth').html($(this).html());$('#selected_location_depth').val(2);$('#unspecified_locations_holder').slideDown('fast');">Hub</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#location_depth_menu').toggle('fast');$('#active_location_depth').html($(this).html());$('#selected_location_depth').val(1);$('#unspecified_locations_holder').slideDown('fast');">Mother facility</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#location_depth_menu').toggle('fast');$('#active_location_depth').html($(this).html());$('#selected_location_depth').val(0);$('#unspecified_locations_holder').slideDown('fast');">Facility</div>
			<input type="hidden" id="selected_location_depth" value="<?php print($location_depth);?>">
		</div>
	</div>
</div>

<div style="width:100%;height:auto;float:left;<?php print($unspecified_locations_holder_display);?>" id="unspecified_locations_holder">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Unknown Loc.:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#unspecified_locations_menu').toggle('fast');" id="active_unspecified_locations" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:auto;width:auto;"><?php print($unspecified_locations_title);?></div>

		<div class="option_menu" id="unspecified_locations_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unspecified_locations_menu').toggle('fast');$('#active_unspecified_locations').html($(this).html());$('#selected_unspecified_locations').val(0);">Skip</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unspecified_locations_menu').toggle('fast');$('#active_unspecified_locations').html($(this).html());$('#selected_unspecified_locations').val(1);">Create separate </div>
		
			
			<input type="hidden" id="selected_unspecified_locations" value="<?php print($unspecified_locations);?>">
		</div>
	</div>
</div>

<div style="width:100%;height:auto;float:left;" >
	<div style="width:100px;height:30px;line-height:30px;float:left;">Days worked:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#days_worked_menu').toggle('fast');" id="active_days_worked" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:auto;width:auto;"><?php print($days_worked_type_title);?></div>

		<div class="option_menu" id="days_worked_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#days_worked_menu').toggle('fast');$('#active_days_worked').html($(this).html());$('#selected_days_worked').val(0);$('#force_days_holder').slideUp('fast');">Show PIPAT days</div>
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#days_worked_menu').toggle('fast');$('#active_days_worked').html($(this).html());$('#selected_days_worked').val(1);$('#force_days_holder').slideDown('fast');">Force days worked if PIPAT days are less</div>
			
			<input type="hidden" id="selected_days_worked" value="<?php print($force_days_id);?>">
		</div>
	</div>
</div>

<div style="width:100%;height:auto;float:left;<?php print($force_days_holder_display);?>" id="force_days_holder">
	<div style="width:100%;height:auto;float:left;" >
	<div style="width:100px;height:30px;line-height:30px;float:left;">Force days:</div>
		<div style="width:170px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<input type="text" id="force_days" value="<?php print($days_worked);?>" style="height:25px" onfocusout="if(isNaN(this.value)){alert('Value must be a number');this.value='<?php print($days_worked);?>'}">
		</div>
	</div>


	<div style="width:100%;height:auto;float:left;" >
	<div style="width:100px;height:30px;line-height:30px;float:left;">Justification:</div>
		<div style="width:200px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		<input type="text" id="force_days_justification" value="<?php print($justification);?>" style="height:25px;color:<?php print($justification_field_color);?>;width:100%" onfocus="if(this.value=='Enter justification here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='<?php print($justification);?>';this.style.color='#aaa';}">
		</div>
	</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;" id="schedule_rule">
<div style="width:100px;height:30px;line-height:30px;float:left;">Schedule rule:</div>
	<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#schedule_rule_menu').toggle('fast');" id="active_schedule_rule" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:50px;width:auto;"><?php print($schedule_rule_title);?></div>

	<div class="option_menu" id="schedule_rule_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_rule_menu').toggle('fast');$('#active_schedule_rule').html($(this).html());$('#selected_schedule_rule').val(0);">Skip beneficiary if claim exists</div>
	
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_rule_menu').toggle('fast');$('#active_schedule_rule').html($(this).html());$('#selected_schedule_rule').val(1);">Skip if user-defined schedule exists</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_rule_menu').toggle('fast');$('#active_schedule_rule').html($(this).html());$('#selected_schedule_rule').val(2);">Ignore claims and user-defined schedules</div>
		
		<input type="hidden" id="selected_schedule_rule" value="<?php print($schedule_rule);?>">
	</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Beneficiaries:</div>
	<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#beneficiary_selection_menu').toggle('fast');" id="active_beneficiary_selection" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:50px;width:auto;"><?php print($beneficiary_type_title);?></div>

	<div class="option_menu" id="beneficiary_selection_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#beneficiary_selection_menu').toggle('fast');$('#active_beneficiary_selection').html($(this).html());$('#selected_beneficiary_selection').val(0);$('#agent_group_holder').slideDown('fast');$('#unit_holder').slideUp('fast');$('#custom_agent_holder').slideUp('fast');">Group specific</div>
	
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#beneficiary_selection_menu').toggle('fast');$('#active_beneficiary_selection').html($(this).html());$('#selected_beneficiary_selection').val(1);$('#agent_group_holder').slideUp('fast');$('#unit_holder').slideDown('fast');$('#custom_agent_holder').slideUp('fast');">Unit specific</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#beneficiary_selection_menu').toggle('fast');$('#active_beneficiary_selection').html($(this).html());$('#selected_beneficiary_selection').val(2);$('#agent_group_holder').slideDown('fast');$('#unit_holder').slideDown('fast');$('#custom_agent_holder').slideUp('fast');">Group and unit specific</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#beneficiary_selection_menu').toggle('fast');$('#active_beneficiary_selection').html($(this).html());$('#selected_beneficiary_selection').val(3);$('#agent_group_holder').slideUp('fast');$('#unit_holder').slideUp('fast');$('#custom_agent_holder').slideDown('fast');">Specific agents</div>
		
		<input type="hidden" id="selected_beneficiary_selection" value="<?php print($beneficiary_type);?>">
	</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;<?php print($group_specific_holder_display);?>" id="agent_group_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;">Agent groups:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:15px;border:solid 1px #ccc;">
<?php
$agent_types = mysqli_query($connect,"select * from agent_types where company_id = $company_id order by title")or die(mysqli_error($connect));

for($a=0;$a<mysqli_num_rows($agent_types);$a++){
	$agent_type_results = mysqli_fetch_array($agent_types,MYSQLI_ASSOC);
	
	?>
	<input type="checkbox" id="agent_type_<?php print($agent_type_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($agent_type_results['id']);?>,'selected_agent_type');}else{remove_from_selection(<?php print($agent_type_results['id']);?>,'selected_agent_type')}" <?php if(check_item_in_list($agent_type_results['id'],$beneficiary_group_id,0,',')){print(' checked ');}?> > <label for="agent_type_<?php print($agent_type_results['id']);?>"><?php print($agent_type_results['title']);?></label><br>
	<?php
}
?>
<input type="hidden" id="selected_agent_type" value="<?php print($beneficiary_group_id);?>">
</div>
</div>


<div style="width:auto;height:auto;float:left;<?php print($unit_specific_display_holder);?>" id="unit_holder">
	<?php
	$this_unit_id = $beneficiary_unit_id;
	if(!$this_unit_id){
		$this_unit_title = 'Select unit';
		$this_unit_id = -1;
		
	}else{
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$this_unit_title = $this_unit_results['title'];
		
	}
	
	
	?>
			<div style="width:100px;height:30px;line-height:30px;float:left;">Unit:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?> $('#unit_menu').toggle('fast'); <?php }else{?>  alert('You are not authorized to change unit for this view'); <?php }?>" id="active_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>

			<div class="option_menu" id="unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(-1);">All units</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(0);">All units</div>
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));

					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						
						if($unit_menu_results['status'] == 0){
							$unit_status = ' [disabled]';
							
						}else{
							$unit_status = '';
							
						}
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(<?php print($unit_menu_results['id']);?>);"><?php print($unit_menu_results['title'].$unit_status);?></div>
						<?php
					}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_unit" value="<?php print($this_unit_id);?>">
		</div>
		
		
<div style="width:100%;height:auto;float:left;<?php print($agent_specific_display_holder);?>" id="custom_agent_holder">

<div style="width:98%;height:auto;float:left;border:solid 1px #dfd;padding:2px;">
<div style="width:50px;height:20px;color:#fff;line-height:20px;text-align:center;float:right;background-color:#c780c7;cursor:pointer;" onmouseover="this.style.backgroundColor='#dfabdf';" onmouseout="this.style.backgroundColor='#c780c7';" onclick="$('#agent_search_holder').fadeIn('fast');">Add</div>

<div style="width:100%;min-height:70px;float:left;" id="request_type_beneficiaries_holder">
<?php
	if($specific_agent_ids != ''){
		$specific_agent_id_array = explode(',',$specific_agent_ids);
		
		for($a=0;$a<count($specific_agent_id_array);$a++){
			$this_agent_id = $specific_agent_id_array[$a];
			
			$this_agent = mysqli_query($connect,"select * from agents where id = $this_agent_id")or die(mysqli_error($connect));
			if(mysqli_num_rows($this_agent)){
				$this_agent_results= mysqli_fetch_array($this_agent,MYSQLI_ASSOC);
				
				$this_agent_date = $this_agent_results['_date'];
				$phone_numbers = mysqli_query($connect,"select * from phone_numbers where agent_date = '$this_agent_date' and company_id = $company_id")or die(mysqli_error($connect));
				
				$this_phone_number = '';
				for($p=0;$p<mysqli_num_rows($phone_numbers);$p++){
					$phone_number_results = mysqli_fetch_array($phone_numbers,MYSQLI_ASSOC);
					
					if($this_phone_number==''){
						$this_phone_number = $phone_number_results['phone_number'];;
						
					}else{
						$this_phone_number .= ', '.$phone_number_results['phone_number'];						
					}
				}				
				?>
				
				<div style="float:left;width:auto;height:30px;line-height:30px;text-align:center;background-color:#d6b8d6;margin:5px;margin-bottom:0px;padding-left:5px;" id="type_beneficiary_<?php print($this_agent_id);?>" title="Phone: <?php print($this_phone_number);?>, NRC: <?php print($this_agent_results['id_number']);?>"><?php print($this_agent_results['_name']);?><div style="margin-left:2px;color:#fff;width:20px;float:right;height:30px;line-height:30px;text-align:center;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';" onclick="remove_from_type_agent(<?php print($this_agent_id);?>);" title="Click to remove">X</div></div>
				<?php				
			}			
		}		
	}
?>


</div>
<input type="hidden" id="selected_request_type_agents" value="<?php print($specific_agent_ids);?>">

</div></div>
		
		

<div style="width:100%;height:auto;float:left;">
	<div style="width:100%;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
	<input type="checkbox" id="schedule_notification_checkbox" onchange="if(this.checked){$('#selected_schedule_notification').val(1);}else{$('#selected_schedule_notification').val(0);}" <?php if($email_on_exec){print(' checked ');}?>> <label for="schedule_notification_checkbox">Send email notification to creators on execution of instruction</label>
		
	<input type="hidden" id="selected_schedule_notification" value="<?php print($email_on_exec);?>">
	</div>
</div>
</div>
</div>

<?php
if($active_user_roles[10] || ($schedule_id and $this_scheduler_results['_type'] == 1 and $this_scheduler_results['user_date'] == $user_results['_date']) || !$schedule_id){
	?>

<div style="width:100%;height:auto;float:left;margin-bottom:30px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_type_button" onclick="create_or_update_schedule_type(<?php print($schedule_id);?>);" title="Click to update details"><?php print($button_text);?></div>

<?php
if($schedule_id){
	?>
	<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="delete_schedule_button" onclick="delete_schedule_type(<?php print($schedule_id);?>);" title="Click to delete item">Delete</div>
<?php
		
	}
?>
</div>
<?php
}
?>
</div>

<div style="width:48%;height:auto;float:right;"><div style="width:100%;height:auto;float:left;margin-bottom:2px;margin-top:20px;border-top:solid 1px #eee;padding-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id'] and $_type){?>$('#region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for users');<?php }?>" id="active_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-mother_facilities-hub_id-{id}-user_mother_facility-1-1|connect-sites-mother_facility_id-{id}-site-1-1');$('#error_message').slideUp('fast');">All Regions</div>
			
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-mother_facilities-hub_id-{id}-mother_facility-1-1|connect-sites-mother_facility_id-{id}-site-1-1');$('#error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_region" value="<?php print($this_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']  and $_type){?>$('#province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for users');<?php }?>" id="active_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#province_menu').toggle('fast');$('#active_province').html($(this).html());$('#selected_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'hub',1,1,'connect-mother_facilities-hub_id-{id}-mother_facility-1-1|connect-mother_facilities-hub_id-{id}-mother_facility-1-1||connect-sites-mother_facility_id-{id}-site-1-1');$('#error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_province" value="<?php print($this_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']  and $_type){?>$('#hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for users');<?php }?>" id="active_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#hub_menu').toggle('fast');$('#active_hub').html($(this).html());$('#selected_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','mother_facilities','hub_id',<?php print($hub_menu_results['id']);?>,'mother_facility',1,1,'connect-sites-mother_facility_id-{id}-site-1-1');$('#error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_hub" value="<?php print($this_hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Mother facility:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['mother_facility_id']  and $_type){?>$('#mother_facility_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify this option');<?php }?>" id="active_mother_facility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_mother_facility_title);?></div>

		<div class="option_menu" id="mother_facility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$mother_facility_menu = mysqli_query($connect,"select * from mother_facilities where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($m=0;$m<mysqli_num_rows($mother_facility_menu);$m++){
					$mother_facility_menu_results = mysqli_fetch_array($mother_facility_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#mother_facility_menu').toggle('fast');$('#active_mother_facility').html($(this).html());$('#selected_mother_facility').val(<?php print($mother_facility_menu_results['id']);?>);fetch_menu_items('connect','sites','mother_facility_id',<?php print($mother_facility_menu_results['id']);?>,'site',1,1,'');$('#error_message').slideUp('fast');"><?php print($mother_facility_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_mother_facility" value="<?php print($this_mother_facility_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']  and $_type){?>$('#site_menu').toggle('fast'); <?php }else{?> alert('You are not authorised to modify site settings for users');<?php }?>" id="active_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_menu').toggle('fast');$('#active_site').html($(this).html());$('#selected_site').val(<?php print($site_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_site" value="<?php print($this_site_id);?>">
</div><div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div></div>

