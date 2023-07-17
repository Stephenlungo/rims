<?php 
$editing = 1;
if($request_type_id){
	$this_request_type = mysqli_query($$module_connect,"select * from request_types where id = $request_type_id")or die(mysqli_error($$module_connect));
	
	$this_request_type_results = mysqli_fetch_array($this_request_type,MYSQLI_ASSOC);
	
	$this_request_type_date = $this_request_type_results['_date'];
	
	$input_color = '#000';
	$button_text = 'Update';
	
	$request_title = $this_request_type_results['title'];
	
	$billing_type = $this_request_type_results['billing_type'];
	if(!$billing_type){
		$billing_type_title = 'Day based';
		$day_based_billing_holder_display = '';
		$fixed_amount_holder_display = 'display:none';
		
	}else{
		$billing_type_title = 'Fixed amount';
		$day_based_billing_holder_display = 'display:none';
		$fixed_amount_holder_display = '';
	}
	
	$daily_rate = $this_request_type_results['daily_rate'];
	$fixed_amount = $this_request_type_results['fixed_amount'];
	
	$limit_days = $this_request_type_results['limit_days'];
	if(!$limit_days){
		$limit_days_title = "Don't limit";
		$payable_days_container_display = 'display:none';
		
	}else{
		$limit_days_title = "Limit";
		$payable_days_container_display = '';
	}
	
	$max_days = $this_request_type_results['max_days'];
	
	$day_adjustment = $this_request_type_results['day_adjustment'];
	if(!$day_adjustment){
		$day_adjustment_title = "Don't allow";
		
	}else{
		$day_adjustment_title = "Allow";
		
	}
	
	$urgency_id = $this_request_type_results['urgency'];
	
	
	$urgency = mysqli_query($$module_connect,"select * from priorities where id = $urgency_id")or die(mysqli_error($$module_connect));
	$urgency_results = mysqli_fetch_array($urgency,MYSQLI_ASSOC);
	
	$urgency_title = $urgency_results['title'];
	
	$rule_string = $this_request_type_results['rule_string'];
	$delay_monitor_rule_string = $this_request_type_results['delay_monitor_rule_string'];
	
	$color_code = $this_request_type_results['color_code'];
	
	if($color_code == '' || $color_code == '#'){
		$color_title = 'Automatic';
		
	}else if($color_code == '#ccf'){
		$color_title = 'Blue';
		
	}else if($color_code == '#fdd'){
		$color_title = 'Red';
		
	}else if($color_code == '#ddd'){
		$color_title = 'Gray';
		
	}else if($color_code == '#000'){
		$color_title = 'Black';
		
	}
	
	$request_status = $this_request_type_results['status'];
	
	$this_region_id = $this_request_type_results['region_id'];
	if(!$this_region_id){
		$this_region_title = 'All Regions';
		$this_region_id = 0;
		
	}else{		
		$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
		$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
		
		$this_region_title = $this_region_results['title'];
	}
	
	$this_province_id = $this_request_type_results['province_id'];
	if(!$this_province_id){
		$this_province_title = 'All Provinces';
		
	}else{
		$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
		$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
		
		$this_province_title = $this_province_results['title'];		
	}
	
	$this_hub_id = $this_request_type_results['hub_id'];
//	print($this_hub_id);
	
	if(!$this_hub_id){
		$this_hub_title = 'All Hubs';
		
	}else{
		$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
		$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
		
		$this_hub_title = $this_hub_results['title'];
	}
	
	$this_site_id = $this_request_type_results['site_id'];
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
		
		$this_site_title = $this_site_results['title'];
	}
	
	$this_scheduler = mysqlI_query($$module_connect,"select * from request_type_scheduler where request_type_dates = '$this_request_type_date' and company_id = $company_id and _type = 0")or die(mysqli_error($$module_connect));
	
	if(mysqli_num_rows($this_scheduler)){
		$this_scheduler_results = mysqli_fetch_array($this_scheduler,MYSQLI_ASSOC);
		$trigger_id = $this_scheduler_results['trigger_type_id'];
		
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
		
		
		
	}else{
		$trigger_id = 0;		
		$trigger_title = 'None';
		$schedule_holder_display = 'display:none;';

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
	}
	
}else{
	$input_color = '#aaa';
	
	$button_text = 'Create';
	
	$request_title = 'Enter request type title';
	$billing_type = 0;
	$billing_type_title = 'Day based';
	$day_based_billing_holder_display = '';
	$fixed_amount_holder_display = 'display:none';
		
	
	$daily_rate = 0;
	$fixed_amount = 0;
	
	$limit_days = 0;
	$limit_days_title = "Don't limit";
	$payable_days_container_display = 'display:none';
	
	$max_days = 0;
	
	$day_adjustment = 0;
	$day_adjustment_title = "Don't allow";
	
	$urgency_id = 2;
	$urgency_title = 'Medium';
	
	$rule_string = 'Level 1,Creation,0,0,0,0,0,0,0,0,0,Document 1';
	$delay_monitor_rule_string = '0]0]0]0]0]0]';
	
	$color_code = '';
	$color_title = 'Automatic';
	
	$this_unit_id = $user_results['unit_id'];

	if(!$this_unit_id){
		$this_unit_title = 'Select unit';
		$this_unit_id = -1;
		
	}else{
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$this_unit_title = $this_unit_results['title'];
		
	}
	
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
	
	$this_site_id = $user_results['site_id'];
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
		
		$this_site_title = $this_site_results['title'];
	}
	$request_status = 1;
	
	$trigger_id = 0;		
	$trigger_title = 'None';
	$schedule_holder_display = 'display:none;';

	$specific_day_trigger  = 0;
	$specific_day_title = 'Any day';
	
	$specific_month_day  = 1;

	$payment_from_day = 1;
	$payment_from_operator = '+';
	$payment_from_addition = 0;
	
	$payment_to_day = 1;
	$payment_to_operator = '+';
	$payment_to_addition = 0;		
	
	$recurrence = 0;		
	$recurrence_title = 'Once';			

	$schedule_type = 0;
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
	$location_depth = 2;
	$location_depth_title = 'Hub';
	
	$unspecified_locations = 1;
	$unspecified_locations_title = 'Create separate';
	$unspecified_locations_holder_display = '';
	
	$group_specific_holder_display = '';
	$unit_specific_display_holder = 'display:none;';
	$agent_specific_display_holder = 'display:none;';

	$beneficiary_type_title = 'Group specific';
	
	$beneficiary_group_id = '';
	$beneficiary_unit_id = 0;
	$specific_agent_ids = '';
	$email_on_exec = 1;
}

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


<div style="width:100%;height:auto;float:left;">
<div style="width:48%;height:auto;float:left;"><div style="cursor:pointer;width:100%;height:20px;float:left;line-height:20px;background-color:#eef;text-align:center;margin-bottom:5px;" onclick="$('#general_details').slideToggle('fast');" onmouseover="this.style.backgroundColor='#ddf';" onmouseout="this.style.backgroundColor='#eef';">Basic details</div></div>

<div style="width:48%;height:auto;float:right;"><div style="width:100%;height:20px;float:left;line-height:20px;background-color:#fee;text-align:center;cursor:pointer;" onclick="$('#general_details').slideToggle('fast');" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee';">Auto Scheduler</div></div>



<div style="width:100%;height:auto;float:left;display:none" id="general_details">
<div style="width:48%;height:auto;float:left;">
<div style="width:100%;height:auto;float:left;">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:250px;height:30px;float:left;line-height:30px;"><input type="text" id="request_type_title" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="<?php print($request_title);?>" onfocus = "if(this.value=='Enter request type title'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($request_title);?>';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>


<div style="width:100%;height:auto;float:left;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Billing type:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#billing_type_menu').toggle('fast');" id="active_billing_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($billing_type_title);?></div>

		<div class="option_menu" id="billing_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#billing_type_menu').toggle('fast');$('#active_billing_type').html($(this).html());$('#selected_billing_type').val(0);$('#day_based_billing_type_holder').slideDown('fast');$('#request_type_fixed_amount').slideUp('fast');">Day based</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#billing_type_menu').toggle('fast');$('#active_billing_type').html($(this).html());$('#selected_billing_type').val(1);$('#day_based_billing_type_holder').slideUp('fast');$('#request_type_fixed_amount').slideDown('fast');">Fixed amount</div>
		
		</div>
	</div>
	<input type="hidden" id="selected_billing_type" value="<?php print($billing_type);?>">
</div>
		
<div style="width:80%;height:auto;float:left;margin-left:100px;<?php print($day_based_billing_holder_display);?>" id="day_based_billing_type_holder">
	<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
	<div style="width:80px;height:30px;line-height:30px;float:left;">Daily rate(K):</div>
	<div style="width:58px;height:30px;float:left;line-height:30px;"><input type="text" id="daily_rate" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($daily_rate);?>" onfocusout="if(this.value==''){this.value='<?php print($daily_rate);?>';}" <?php if(!$editing){?> disabled <?php }?> onfocus="this.style.borderColor='#aaa';"></div>
	
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
	<div style="width:120px;height:30px;line-height:30px;float:left;">Limit payable days:</div>
		<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#limit_days_menu').toggle('fast');" id="active_limit_days" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($limit_days_title);?></div>

		<div class="option_menu" id="limit_days_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_days_menu').toggle('fast');$('#active_limit_days').html($(this).html());$('#selected_limit_days').val(0);$('#max_payable_days_container').slideUp('fast');">Don't limit</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_days_menu').toggle('fast');$('#active_limit_days').html($(this).html());$('#selected_limit_days').val(1);$('#max_payable_days_container').slideDown('fast');">Limit</div>
		
		</div>
		<input type="hidden" id="selected_limit_days" value="<?php print($limit_days);?>">
	</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:10px;<?php print($payable_days_container_display);?>" id="max_payable_days_container">
	<div style="width:115px;height:30px;line-height:30px;float:left;margin-left:120px;">Max payable days:</div>
	<div style="width:50px;height:30px;float:left;line-height:30px;"><input type="text" id="max_days" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($max_days);?>" onfocusout="if(this.value==''){this.value='0';}" <?php if(!$editing){?> disabled <?php }?> onfocus="this.style.borderColor='#aaa';"></div>
	</div>

	
	<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
	<div style="width:120px;height:30px;line-height:30px;float:left;">Day adjustment:</div>
		<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#day_adjustment_menu').toggle('fast');" id="active_day_adjustment" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($day_adjustment_title);?></div>

		<div class="option_menu" id="day_adjustment_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#day_adjustment_menu').toggle('fast');$('#active_day_adjustment').html($(this).html());$('#selected_day_adjustment').val(0);">Don't allow</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#day_adjustment_menu').toggle('fast');$('#active_day_adjustment').html($(this).html());$('#selected_day_adjustment').val(1);">Allow</div>
		
		</div>
		<input type="hidden" id="selected_day_adjustment" value="<?php print($day_adjustment);?>">
	</div>
	</div>
	
</div>

<div style="width:80%;height:auto;float:left;margin-bottom:10px;margin-left:100px;<?php print($fixed_amount_holder_display);?>" id="request_type_fixed_amount">
<div style="width:70px;height:30px;line-height:30px;float:left;">Amount(K):</div>
<div style="width:80px;height:30px;float:left;line-height:30px;"><input type="text" id="request_type_amount" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($fixed_amount);?>" onfocusout="if(this.value==''){this.value='<?php print($fixed_amount);?>';}" <?php if(!$editing){?> disabled <?php }?> onfocus="this.style.borderColor='#aaa';"></div>
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

<div style="width:100%;height:auto;float:left;margin-top:20px;border-top:solid 1px #eee;padding-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Urgency:</div>
		<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#urgency_menu').toggle('fast');" id="active_urgency" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($urgency_title);?></div>

		<div class="option_menu" id="urgency_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<?php
		$urgency = mysqli_query($$module_connect,"select * from priorities")or die(mysqli_error($$module_connect));
		
		for($u=0;$u<mysqli_num_rows($urgency);$u++){
			$urgency_results = mysqli_fetch_array($urgency,MYSQLI_ASSOC);
			?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#urgency_menu').toggle('fast');$('#active_urgency').html($(this).html());$('#selected_urgency').val(<?php print($urgency_results['id']);?>);"><?php print($urgency_results['title']);?></div>
			<?php
		}
		?>
		<input type="hidden" id="selected_urgency" value="<?php print($urgency_id);?>">
		</div>
	</div>
	</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Color:</div>
	<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#color_menu').toggle('fast');" id="active_color" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($color_title);?></div>

	<div class="option_menu" id="color_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#color_menu').toggle('fast');$('#active_color').html($(this).html());$('#selected_color').val('');">Automatic</div>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#color_menu').toggle('fast');$('#active_color').html($(this).html());$('#selected_color').val('#ccf');">Blue</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#color_menu').toggle('fast');$('#active_color').html($(this).html());$('#selected_color').val('#fdd');">Red</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#color_menu').toggle('fast');$('#active_color').html($(this).html());$('#selected_color').val('#ddd');">Gray</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#color_menu').toggle('fast');$('#active_color').html($(this).html());$('#selected_color').val('#000');">Black</div>
	
	</div>
	<input type="hidden" id="selected_color" value="<?php print($color_code);?>">
</div>
</div>
</div>
</div>


<div style="width:48%;height:auto;float:right;">
<div style="width:100%;height:auto;float:left;" id="auto_scheduler">
<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Trigger:</div>
	<div style="width:170px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#schedule_trigger_menu').toggle('fast');" id="active_schedule_trigger" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:80px;width:auto;"><?php print($trigger_title);?></div>

	<div class="option_menu" id="schedule_trigger_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_trigger_menu').toggle('fast');$('#active_schedule_trigger').html($(this).html());$('#selected_schedule_trigger').val(0);$('#trigger_day').slideUp('fast');$('#trigger_date').slideUp('fast');$('#scheduler_settings').slideUp('fast');">None</div>
		
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
				
				<div style="float:left;width:auto;height:30px;line-height:30px;text-align:center;background-color:#d6b8d6;margin:5px;margin-bottom:0px;padding-left:5px;" id="request_type_beneficiary_<?php print($this_agent_id);?>" title="Phone: <?php print($this_phone_number);?>, NRC: <?php print($this_agent_results['id_number']);?>"><?php print($this_agent_results['_name']);?><div style="margin-left:2px;color:#fff;width:20px;float:right;height:30px;line-height:30px;text-align:center;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';" onclick="remove_from_request_type_agent(<?php print($this_agent_id);?>);" title="Click to remove">X</div></div>
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
</div>
</div>






	
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#f0d7f0;text-align:center;margin-top:10px;margin-bottom:10px;" id="$('#approval_levels').slideToggle('fast');">Approval settings</div>

<?php
$approval_levels = explode(']',$rule_string);
$level_delay_rules = explode('|',$delay_monitor_rule_string);

?>

<div style="width:100%;height:auto;float:left;" id="approval_levels">


<?php

for($l=0;$l<count($approval_levels);$l++){
	if($delay_monitor_rule_string == ''){
		$this_delay_monitor_rules = explode(']','0]0]0]0]0]0]');
		
	}else{
		$this_delay_monitor_rules = explode(']',$level_delay_rules[$l]);
		
	}
	
	
	$level_options = explode(',',$approval_levels[$l]);
	$level_title = $level_options[0];
	$action_title = $level_options[1];
	$action_type = $level_options[2];
	
	if(!$action_type){
		$action_type_title = 'Standard';
		$document_upload_holder = 'display:none';
		
	}else{
		$action_type_title = 'Document upload';
		$document_upload_holder = '';
		
	}
	
	$approver_type = $level_options[3];
	if(!$approver_type){
		$approver_type_title = 'Location specific';
		$location_holder_display = '';
		$group_holder_display = 'display:none';
		$user_holder_display = 'display:none';
		
	}else if($approver_type == 1){
		$approver_type_title = 'Group specific';
		$location_holder_display = 'display:none';
		$group_holder_display = '';
		$user_holder_display = 'display:none';
		
	}else if($approver_type == 2){
		$approver_type_title = 'User specific';
		$location_holder_display = 'display:none';
		$group_holder_display = 'display:none';
		$user_holder_display = '';
	}
	
	$approver_location_level = $level_options[4];
	if(!$approver_location_level){
		$location_level_title = 'Region level approvers';
		$location_table = 'regions';
		
	}else if($approver_location_level ==1){
		$location_level_title = 'Province level approvers';
		$location_table = 'provinces';
		
	}else if($approver_location_level ==2){
		$location_level_title = 'Hub level approvers';
		$location_table = 'hubs';
		
	}else if($approver_location_level ==3){
		$location_level_title = 'Site level approvers';
		$location_table = 'sites';
	}
	
	$location_id = $level_options[5];
	if(!$location_id){
		$this_location_title = 'Select item';
		
	}else{
		
		$this_location = mysqli_query($connect,"select * from $location_table where id = $location_id")or die(mysqli_error($connect));
		$this_location_results = mysqli_fetch_array($this_location,MYSQLI_ASSOC);
		$this_location_title = $this_location_results['title'];
	
	}
	
	$unit_id = $level_options[6];
	
	if(!$unit_id){
		$unit_title = 'All units';
	
	}else{
		$this_unit = mysqli_query($connect,"select * from units where id = $unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		
		$unit_title = $this_unit_results['title'];		
	}
	
	$group_id = $level_options[7];
	if(!$group_id){
		$group_title = 'Select item';
		
	}else{
		$this_group = mysqli_query($$module_connect,"select * from approval_thresholds where id = $group_id")or die(mysqli_error($$module_connct));
		$this_group_results = mysqli_fetch_array($this_group,MYSQLI_ASSOC);
		
		$group_title = $this_group_results['title'];
	}
	
	$this_approver_user_id = $level_options[8];
	if(!$this_approver_user_id){
		$approver_user_name = 'Select user';
		
	}else{
		$approver_user = mysqli_query($connect,"select * from users where id = $this_approver_user_id")or die(mysqli_error($connct));
		$approver_user_results = mysqli_fetch_array($approver_user,MYSQLI_ASSOC);
		
		$approver_user_name = $approver_user_results['_name'];
	}
	
	$notify_creator = $level_options[9];
	if(!$notify_creator){
		$notify_creator_title = "Don't notify";
		
	}else{
		$notify_creator_title = "Notify";
		
	}
	
	$notify_levels = str_replace("}",",",$level_options[10]);
	?>
	
	
	<div style="width:100%;height:25px;line-height:25px;float:left;text-align:left;font-weight:bold;border-top:solid 1px #eee;cursor:pointer;" id="level_header_<?php print($l);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="$('#level_holder_<?php print($l);?>').slideToggle('fast');">Level <?php print($l+1);?></div>
	<div style="width:100%;float:left;height:auto;display:none;" id="level_holder_<?php print($l);?>">
	<div style="width:53%;height:auto;float:left;">

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Level title:</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="level_title_<?php print($l);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="<?php print($level_title);?>" onfocus = "if(this.value=='Enter title here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($level_title);?>';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Action title:</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="action_title_<?php print($l);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="<?php print($action_title);?>" onfocus = "if(this.value=='Enter title here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($action_title);?>';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Action type:</div>
	<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#action_type_menu_<?php print($l);?>').toggle('fast');" id="active_action_type_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($action_type_title);?></div>

	<div class="option_menu" id="action_type_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#action_type_menu_<?php print($l);?>').toggle('fast');$('#active_action_type_<?php print($l);?>').html($(this).html());$('#selected_action_type_<?php print($l);?>').val(0);$('#document_holder_<?php print($l);?>').slideUp('fast');">Standard</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#action_type_menu_<?php print($l);?>').toggle('fast');$('#active_action_type_<?php print($l);?>').html($(this).html());$('#selected_action_type_<?php print($l);?>').val(1);$('#document_holder_<?php print($l);?>').slideDown('fast');">Document upload</div>
	
	</div>
	<input type="hidden" id="selected_action_type_<?php print($l);?>" value="<?php print($action_type);?>">
	</div>
</div>

<div style="width:90%;height:auto;float:left;margin-left:100px;margin-bottom:20px;<?php print($document_upload_holder);?>" id="document_holder_<?php print($l);?>">

<?php
$document_array = explode('|',$level_options[11]);

for($d=0;$d<count($document_array);$d++){
	$this_document_title = $document_array[$d];
	
	if($d == 0){
		$document_remove_display = 'display:none;';
		
	}else{
		$document_remove_display = '';
		
	}
	//print($level_options[11]);
?>

<div style="width:100%;height:30px;line-height:30px;float:left;" id="document_<?php print($l);?>_<?php print($d);?>_holder">
<div style="width:auto;float:left;height:30px;line-height:30px;margin-right:5px;" id="document_title_<?php print($l);?>">Document <?php print($d+1);?></div><div style="width:auto;float:left;height:30px;"><input type="text" id="document_<?php print($l);?>_<?php print($d);?>" value="<?php print($this_document_title);?>" onfocusout="if(this.value==''){this.value='<?php print($this_document_title);?>';}" style="width:175px;height:25px;margin-top:2px;"></div><div style="width:40px;cursor:pointer;margin-top:4px;height:20px;line-height:20px;background-color:#006bb3;color:#fff;float:left;text-align:center;margin-left:5px;" onmouseout="this.style.backgroundColor='#006bb3';" onmouseover="this.style.backgroundColor='#339eb3';" onclick="add_approval_upload('_<?php print($l);?>')" id="add_button_<?php print($l);?>_<?php print($d);?>">Add</div> <div style="<?php print($document_remove_display);?>width:50px;cursor:pointer;margin-top:4px;height:20px;line-height:20px;background-color:brown;color:#fff;float:left;text-align:center;margin-left:5px;" onmouseout="this.style.backgroundColor='brown';" onmouseover="this.style.backgroundColor='#b24242';" onclick="remove_approval_upload('_<?php print($l);?>','_<?php print($d);?>')" id="remove_button_<?php print($l);?>_<?php print($d);?>">Remove</div>
<input type="hidden" id="document_active_<?php print($l);?>_<?php print($d);?>" value="1">
</div>
<?php
}
?>

</div>
<input type="hidden" id="total_documents_<?php print($l);?>" value="<?php print(count($document_array));?>">


<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Approver type:</div>
	<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#approver_type_menu_<?php print($l);?>').toggle('fast');" id="active_approver_type_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($approver_type_title);?></div>

	<div class="option_menu" id="approver_type_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_<?php print($l);?>').toggle('fast');$('#active_approver_type_<?php print($l);?>').html($(this).html());$('#selected_approver_type_<?php print($l);?>').val(0);$('#location_approver_holder_<?php print($l);?>').slideDown('fast');$('#location_approver_holder_<?php print($l);?>').slideDown('fast');$('#user_approver_holder_<?php print($l);?>').slideUp('fast');$('#group_approver_holder_<?php print($l);?>').slideUp('fast');">Location specific</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_<?php print($l);?>').toggle('fast');$('#active_approver_type_<?php print($l);?>').html($(this).html());$('#selected_approver_type_<?php print($l);?>').val(1);$('#location_approver_holder_<?php print($l);?>').slideUp('fast');$('#user_approver_holder_<?php print($l);?>').slideUp('fast');$('#group_approver_holder_<?php print($l);?>').slideDown('fast');">Group specific</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_<?php print($l);?>').toggle('fast');$('#active_approver_type_<?php print($l);?>').html($(this).html());$('#selected_approver_type_<?php print($l);?>').val(2);$('#location_approver_holder_<?php print($l);?>').slideUp('fast');$('#user_approver_holder_<?php print($l);?>').slideDown('fast');$('#group_approver_holder_<?php print($l);?>').slideUp('fast');">User specific</div>
	</div>
	<input type="hidden" id="selected_approver_type_<?php print($l);?>" value="<?php print($approver_type);?>">
	</div>
</div>


<div style="width:80%;height:auto;float:left;margin-left:40px;<?php print($location_holder_display);?>" id="location_approver_holder_<?php print($l);?>">
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location level:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_location_type_menu_<?php print($l);?>').toggle('fast');" id="active_approver_level_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($location_level_title);?></div>

			<div class="option_menu" id="approver_location_type_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($l);?>').toggle('fast');$('#active_approver_level_<?php print($l);?>').html($(this).html());$('#selected_location_level_<?php print($l);?>').val(0);fetch_menu_items('connect','regions','company_id',<?php print($company_id);?>,'approver_area_<?php print($l);?>',1,1,'');$('#error_message').slideUp('fast');">Region level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($l);?>').toggle('fast');$('#active_approver_level_<?php print($l);?>').html($(this).html());$('#selected_location_level_<?php print($l);?>').val(1);fetch_menu_items('connect','provinces','company_id',<?php print($company_id);?>,'approver_area_<?php print($l);?>',1,1,'');$('#error_message').slideUp('fast');">Province level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($l);?>').toggle('fast');$('#active_approver_level_<?php print($l);?>').html($(this).html());$('#selected_location_level_<?php print($l);?>').val(2);fetch_menu_items('connect','hubs','company_id',<?php print($company_id);?>,'approver_area_<?php print($l);?>',1,1,'');$('#error_message').slideUp('fast');">Hub level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_<?php print($l);?>').toggle('fast');$('#active_approver_level_<?php print($l);?>').html($(this).html());$('#selected_location_level_<?php print($l);?>').val(3);fetch_menu_items('connect','sites','company_id',<?php print($company_id);?>,'approver_area_<?php print($l);?>',1,1,'');$('#error_message').slideUp('fast');">Site level approvers</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_location_level_<?php print($l);?>" value="<?php print($approver_location_level);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;" id="location_holder_<?php print($l);?>">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_area_<?php print($l);?>_menu').toggle('fast');" id="active_approver_area_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_location_title);?></div>
<?php
	$locations = mysqli_query($connect,"select * from $location_table where company_id = $company_id")or die(mysqli_error($connect));
	?>
			<div class="option_menu" id="approver_area_<?php print($l);?>_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				for($l2=0;$l2<mysqli_num_rows($locations);$l2++){
					$locations_results = mysqli_fetch_array($locations,MYSQLI_ASSOC);
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_area_<?php print($l);?>_menu').toggle('fast');$('#active_approver_area_<?php print($l);?>').html($(this).html());$('#selected_approver_area_<?php print($l);?>').val(<?php print($locations_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($locations_results['title']);?></div>
					
					
					<?php 
				}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_area_<?php print($l);?>" value="<?php print($location_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Unit:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_unit_menu_<?php print($l);?>').toggle('fast');" id="active_approver_unit_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($unit_title);?></div>

			<div class="option_menu" id="approver_unit_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_<?php print($l);?>').toggle('fast');$('#active_approver_unit_<?php print($l);?>').html($(this).html());$('#selected_approver_unit_<?php print($l);?>').val(0);$('#error_message').slideUp('fast');">All Units</div>
			
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_<?php print($l);?>').toggle('fast');$('#active_approver_unit_<?php print($l);?>').html($(this).html());$('#selected_approver_unit_<?php print($l);?>').val(<?php print($unit_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_unit_<?php print($l);?>" value="<?php print($unit_id);?>">
</div></div></div>

<div style="width:80%;height:auto;float:left;margin-left:40px;<?php print($group_holder_display);?>" id="group_approver_holder_<?php print($l);?>">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:60px;">Group:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_group_menu_<?php print($l);?>').toggle('fast');" id="active_approver_group_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;"><?php print($group_title);?></div>

			<div class="option_menu" id="approver_group_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$group_menu = mysqli_query($$module_connect,"select * from approval_thresholds where company_id = $company_id order by title")or die(mysqli_error($$module_connect));
					for($g=0;$g<mysqli_num_rows($group_menu);$g++){
						$group_menu_results = mysqli_fetch_array($group_menu,MYSQLI_ASSOC);
						?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_group_menu_<?php print($l);?>').toggle('fast');$('#active_approver_group_<?php print($l);?>').html($(this).html());$('#selected_approver_group_<?php print($l);?>').val(<?php print($group_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($group_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_group_<?php print($l);?>" value="<?php print($group_id);?>">
</div></div>

</div>


<div style="width:80%;height:auto;float:left;margin-left:40px;<?php print($user_holder_display);?>" id="user_approver_holder_<?php print($l);?>">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:60px;">User:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_user_menu_<?php print($l);?>').toggle('fast');" id="active_approver_user_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;"><?php print($approver_user_name);?></div>

			<div class="option_menu" id="approver_user_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
			
				$user_menu = mysqli_query($connect,"select * from users where company_id = $company_id and status = 1 order by _name")or die(mysqli_error($connect));

				for($u=0;$u<mysqli_num_rows($user_menu);$u++){
					$user_menu_results = mysqli_fetch_array($user_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_user_menu_<?php print($l);?>').toggle('fast');$('#active_approver_user_<?php print($l);?>').html($(this).html());$('#selected_approver_user_<?php print($l);?>').val(<?php print($user_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($user_menu_results['_name']);?></div>
					<?php
				}
			?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_user_<?php print($l);?>" value="<?php print($this_approver_user_id);?>">
</div></div></div>

<?php
if(!$l){
	$notify_creator_display = 'display:none;';
	
}else{
	$notify_creator_display = '';
	
}
?>

<div style="width:80%;height:auto;float:left;<?php print($notify_creator_display);?>" id="notify_creator_<?php print($l);?>">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Notify creator:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#notify_creator_menu_<?php print($l);?>').toggle('fast');" id="active_notify_creator_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;"><?php print($notify_creator_title);?></div>

			<div class="option_menu" id="notify_creator_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#notify_creator_menu_<?php print($l);?>').toggle('fast');$('#active_notify_creator_<?php print($l);?>').html($(this).html());$('#selected_notify_creator_<?php print($l);?>').val(1);$('#error_message').slideUp('fast');">Notify</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#notify_creator_menu_<?php print($l);?>').toggle('fast');$('#active_notify_creator_<?php print($l);?>').html($(this).html());$('#selected_notify_creator_<?php print($l);?>').val(0);$('#error_message').slideUp('fast');">Don't Notify</div>
				
			</div>
	</div>
	<input type="hidden" id="selected_notify_creator_<?php print($l);?>" value="<?php print($notify_creator);?>">
</div></div></div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Notify levels:</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="request_notify_stages_<?php print($l);?>" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($notify_levels);?>" onfocusout="if(this.value==''){this.value='0';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

</div>


<div style="width:45%;height:auto;float:right;padding-left:5px;">
	<div style="width:100%;height:auto;float:left;margin-top:5px;">
	<?php
	$level_delay_monitor_holder_display = 'display:none;';
	if($this_delay_monitor_rules[0] == 0){
		$monitor_switch_title = 'Off';
		
	}else{
		$monitor_switch_title = 'On';
		$level_delay_monitor_holder_display = '';
	}
	?>
	<div style="width:130px;height:30px;line-height:30px;float:left;">Level delay monitor:</div>
		<div style="width:170px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

		<div class="option_item" title="Click to change option" onclick="$('#delay_monitor_menu_<?php print($l);?>').toggle('fast');" id="active_delay_monitor_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:50px;width:auto;"><?php print($monitor_switch_title);?></div>

		<div class="option_menu" id="delay_monitor_menu_<?php print($l);?>" style="display:none;min-width:50px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#delay_monitor_menu_<?php print($l);?>').toggle('fast');$('#active_delay_monitor_<?php print($l);?>').html($(this).html());$('#selected_delay_monitor_<?php print($l);?>').val(0);$('#level_delay_monitor_holder_<?php print($l);?>').slideUp('fast');">Off</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#delay_monitor_menu_<?php print($l);?>').toggle('fast');$('#active_delay_monitor_<?php print($l);?>').html($(this).html());$('#selected_delay_monitor_<?php print($l);?>').val(1);$('#level_delay_monitor_holder_<?php print($l);?>').slideDown('fast');">On</div>
			
			<input type="hidden" id="selected_delay_monitor_<?php print($l);?>" value="<?php print($this_delay_monitor_rules[0]);?>">
		</div>
	</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;<?php print($level_delay_monitor_holder_display);?>" id="level_delay_monitor_holder_<?php print($l);?>">
	<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Delay length (days):</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="delay_length_<?php print($l);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="<?php print($this_delay_monitor_rules[1]);?>" onfocus = "if(this.value=='Enter length here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(isNaN(this.value)){alert('Value must be a number');this.value='<?php print($this_delay_monitor_rules[1]);?>';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;margin-top:5px;margin-top:10px;font-weight:bold;background-color:#eee;">Actions on delay
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<input type="checkbox" id="flag_claim_<?php print($l);?>" <?php if($this_delay_monitor_rules[2]){print(' checked ');}?> onchange="if(this.checked){$('#flag_claim_input_<?php print($l);?>').val(1);}else{$('#flag_claim_input_<?php print($l);?>').val(0);}"><label for="flag_claim_<?php print($l);?>">Flag claim</label> <input type="checkbox" id="monitor_notify_creator_<?php print($l);?>" <?php if($this_delay_monitor_rules[3]){print(' checked ');}?> onchange="if(this.checked){$('#notify_creator_input_<?php print($l);?>').val(1);}else{$('#notify_creator_input_<?php print($l);?>').val(0);}"><label for="monitor_notify_creator_<?php print($l);?>">Notify creator</label>

<input type="hidden" id="flag_claim_input_<?php print($l);?>" value="<?php print($this_delay_monitor_rules[2]);?>">
<input type="hidden" id="notify_creator_input_<?php print($l);?>" value="<?php print($this_delay_monitor_rules[3]);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:110px;height:30px;line-height:30px;float:left;">Notify levels:</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="monitor_notify_levels_<?php print($l);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="<?php print($this_delay_monitor_rules[4]);?>" onfocus = "if(this.value=='Enter title here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($level_title);?>';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:110px;height:30px;line-height:30px;float:left;">Notify user:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<?php

if($this_delay_monitor_rules[5] == 0){
	$user_title = 'None';
	
}else{
	$this_not_user_id = $this_delay_monitor_rules[5];
	$this_not_user = mysqli_query($connect,"select * from users where id = $this_not_user_id")or die(mysqli_error($connect));
	$this_not_user_results = mysqli_fetch_array($this_not_user,MYSQLI_ASSOC);
	
	$user_title = $this_not_user_results['_name'];
}
?>

<div class="option_item" title="Click to change option" onclick="$('#monitor_user_menu_<?php print($l);?>').toggle('fast');" id="active_monitor_user_<?php print($l);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($user_title);?></div>

		<div class="option_menu" id="monitor_user_menu_<?php print($l);?>" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#monitor_user_menu_<?php print($l);?>').toggle('fast');$('#active_monitor_user_<?php print($l);?>').html($(this).html());$('#selected_supervisor').val(0);$('#error_message').slideUp('fast');">None</div>
		
			<?php
			
				$supervisor_menu = mysqli_query($connect,"select * from users where company_id = $company_id and id != $active_user_id order by _name")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($supervisor_menu);$s++){
					$supervisor_menu_results = mysqli_fetch_array($supervisor_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#monitor_user_menu_<?php print($l);?>').toggle('fast');$('#active_monitor_user_<?php print($l);?>').html($(this).html());$('#selected_monitor_user_<?php print($l);?>').val(<?php print($supervisor_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($supervisor_menu_results['_name']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_monitor_user_<?php print($l);?>" value="<?php print($this_delay_monitor_rules[5]);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:110px;height:30px;float:left;">Notify user group:</div>
<div style="width:220px;min-height:30px;height:auto;float:left;line-height:15px;border:solid 1px #ccc;padding:5px;">
<?php
$user_groups = mysqli_query($connect,"select * from user_groups where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
$this_user_group_id = '';
for($u=0;$u<mysqli_num_rows($user_groups);$u++){
	$user_group_results = mysqli_fetch_array($user_groups,MYSQLI_ASSOC);
	
	?>
	<input type="checkbox" id="user_group_<?php print($l.'_'.$user_group_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($user_group_results['id']);?>,'selected_monitor_user_group_<?php print($l);?>');}else{remove_from_selection(<?php print($user_group_results['id']);?>,'selected_monitor_user_group_<?php print($l);?>')}" <?php if(check_item_in_list($user_group_results['id'],$this_delay_monitor_rules[6],0,',')){print(' checked ');}?> > <label for="user_group_<?php print($l.'_'.$user_group_results['id']);?>"><?php print($user_group_results['title']);?></label><br>
	<?php
}
?>
<input type="hidden" id="selected_monitor_user_group_<?php print($l);?>" value="<?php print($this_delay_monitor_rules[6]);?>">
</div>
</div>
	</div>
</div>
</div>
</div>
	<?php
}
?>


<input type="hidden" id="total_request_type_levels" value="<?php print(count($approval_levels));?>">

<div style="margin-bottom:5px;cursor:pointer;width:100%;float:left;height:20px;line-height:20px;background-color:#bbb;color:#fff;text-align:center;" onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#bbb'" onclick="add_request_type_approver_level();">Add</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>

<div style="width:100%;height:auto;float:left;margin-bottom:30px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_request_type_button" onclick="create_or_update_request_type(<?php print($request_type_id);?>,0);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($request_type_id){?>
<div style="width:80px;height:30px;background-color:#006bb3;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#339eb3';" onmouseout="this.style.backgroundColor='#006bb3';"  id="update_or_create_request_type_button" onclick="create_or_update_request_type(<?php print($request_type_id);?>,1);" title="Click to create a copy with current details">Create copy</div>

<?php
}

if($request_type_id){
	if($request_status){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_request_type_button" onclick="enable_or_disable_request_type(<?php print($request_type_id);?>,0);" title="Click to disable the account">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="enable_request_type_button" onclick="enable_or_disable_request_type(<?php print($request_type_id);?>,1);" title="Click to activate the account">Enable</div>
<?php
		
	}
}
?>
</div>



<div style="width:100%;float:left;height:auto;display:none;" id="default_approval_level">
<div style="width:100%;height:auto;float:left;text-align:center;background-color:#eee;" id="level_header_y">Level _l</div>
<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Levels title:</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="level_title_y" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="Enter title here" onfocus = "if(this.value=='Enter title here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter title here';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Action title:</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="action_title_y" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($input_color);?>" value="Enter title here" onfocus = "if(this.value=='Enter title here'){this.value='';this.style.color='#000'}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter title here';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Action type:</div>
	<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#action_type_menu_y').toggle('fast');" id="active_action_type_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Standard</div>

	<div class="option_menu" id="action_type_menu_y" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#action_type_menu_y').toggle('fast');$('#active_action_type_y').html($(this).html());$('#selected_action_type_y').val(0);$('#document_holder_y').slideUp('fast');">Standard</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#action_type_menu_y').toggle('fast');$('#active_action_type_y').html($(this).html());$('#selected_action_type_y').val(1);$('#document_holder_y').slideDown('fast');">Document upload</div>
	
	</div>
	<input type="hidden" id="selected_action_type_y" value="0">
	</div>
</div>

<div style="width:90%;height:auto;float:left;display:none;margin-left:100px;margin-bottom:20px;" id="document_holder_y">
<div style="width:100%;height:30px;line-height:30px;float:left;" id="document_y_z_holder">
<div style="width:auto;float:left;height:30px;line-height:30px;margin-right:5px;" id="document_title_y">Document 1</div><div style="width:auto;float:left;height:30px;"><input type="text" id="document_y_z" value="Document 1" style="width:175px;height:25px;margin-top:2px;"></div><div style="width:40px;cursor:pointer;margin-top:4px;height:20px;line-height:20px;background-color:#006bb3;color:#fff;float:left;text-align:center;margin-left:5px;" onmouseout="this.style.backgroundColor='#006bb3';" onmouseover="this.style.backgroundColor='#339eb3';" onclick="add_approval_upload('_y')" id="add_button_y_z">Add</div> <div style="display:none;width:50px;cursor:pointer;margin-top:4px;height:20px;line-height:20px;background-color:brown;color:#fff;float:left;text-align:center;margin-left:5px;" onmouseout="this.style.backgroundColor='brown';" onmouseover="this.style.backgroundColor='#b24242';" onclick="remove_approval_upload('_y','_x')" id="remove_button_y_z">Remove</div>
<input type="hidden" id="document_active_y_z" value="1">
</div>


</div>
<input type="hidden" id="total_documents_y" value="1">


<div style="width:100%;height:auto;float:left;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Approver type:</div>
	<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#approver_type_menu_y').toggle('fast');" id="active_approver_type_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Location specific</div>

	<div class="option_menu" id="approver_type_menu_y" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_y').toggle('fast');$('#active_approver_type_y').html($(this).html());$('#selected_approver_type_y').val(0);$('#location_approver_holder_y').slideDown('fast');$('#location_approver_holder_l').slideDown('fast');$('#user_approver_holder_l').slideUp('fast');$('#group_approver_holder_y').slideUp('fast');">Location specific</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_y').toggle('fast');$('#active_approver_type_y').html($(this).html());$('#selected_approver_type_y').val(1);$('#location_approver_holder_y').slideUp('fast');$('#user_approver_holder_y').slideUp('fast');$('#group_approver_holder_y').slideDown('fast');">Group specific</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_type_menu_y').toggle('fast');$('#active_approver_type_y').html($(this).html());$('#selected_approver_type_y').val(2);$('#location_approver_holder_y').slideUp('fast');$('#user_approver_holder_y').slideDown('fast');$('#group_approver_holder_y').slideUp('fast');">User specific</div>
	</div>
	<input type="hidden" id="selected_approver_type_y" value="0">
	</div>
</div>


<div style="width:80%;height:auto;float:left;margin-left:40px;" id="location_approver_holder_y">
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location level:</div>
<div style="width:150px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_location_type_menu_y').toggle('fast');" id="active_approver_level_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Region level approvers</div>

			<div class="option_menu" id="approver_location_type_menu_y" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_y').toggle('fast');$('#active_approver_level_y').html($(this).html());$('#selected_approver_type_y').val(0);fetch_menu_items('connect','regions','company_id',<?php print($company_id);?>,'approver_area_y',1,1,'');$('#error_message').slideUp('fast');">Region level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_y').toggle('fast');$('#active_approver_level_y').html($(this).html());$('#selected_approver_type_y').val(1);fetch_menu_items('connect','provinces','company_id',<?php print($company_id);?>,'approver_area_y',1,1,'');$('#error_message').slideUp('fast');">Province level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_y').toggle('fast');$('#active_approver_level_y').html($(this).html());$('#selected_approver_type_y').val(2);fetch_menu_items('connect','hubs','company_id',<?php print($company_id);?>,'approver_area_y',1,1,'');$('#error_message').slideUp('fast');">Hub level approvers</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_location_type_menu_y').toggle('fast');$('#active_approver_level_y').html($(this).html());$('#selected_approver_type_y').val(3);fetch_menu_items('connect','sites','company_id',<?php print($company_id);?>,'approver_area_y',1,1,'');$('#error_message').slideUp('fast');">Site level approvers</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_approver_type_y" value="0">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;" id="location_holder_y">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Location:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_area_y_menu').toggle('fast');" id="active_approver_area_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select location</div>

			<div class="option_menu" id="approver_area_y_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
		$locations = mysqli_query($connect,"select * from regions where company_id = $company_id")or die(mysqli_error($connect));
		?>
			
				<?php
				for($l2=0;$l2<mysqli_num_rows($locations);$l2++){
					$locations_results = mysqli_fetch_array($locations,MYSQLI_ASSOC);
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_area_y_menu').toggle('fast');$('#active_approver_area_y').html($(this).html());$('#selected_approver_area_y').val(<?php print($locations_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($locations_results['title']);?></div>
					
					
					<?php 
				}
				?>
			
			</div>
	</div>
	<input type="hidden" id="selected_approver_area_y" value="0">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:85px;height:30px;line-height:30px;float:left;margin-left:60px;">Unit:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_unit_menu_y').toggle('fast');" id="active_approver_unit_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($default_unit_title);?></div>

			<div class="option_menu" id="approver_unit_menu_y" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_y').toggle('fast');$('#active_approver_unit_y').html($(this).html());$('#selected_approver_unit_y').val(0);$('#error_message').slideUp('fast');">All Units</div>
			
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_unit_menu_y').toggle('fast');$('#active_approver_unit_y').html($(this).html());$('#selected_approver_unit_y').val(<?php print($unit_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_unit_y" value="<?php print($default_unit_id);?>">
</div></div></div>

<div style="width:80%;height:auto;float:left;margin-left:40px;display:none;" id="group_approver_holder_y">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:60px;">Group:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_group_menu_y').toggle('fast');" id="active_approver_group_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;">Select group</div>

			<div class="option_menu" id="approver_group_menu_y" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$group_menu = mysqli_query($$module_connect,"select * from approval_thresholds where company_id = $company_id order by title")or die(mysqli_error($$module_connect));
					for($g=0;$g<mysqli_num_rows($group_menu);$g++){
						$group_menu_results = mysqli_fetch_array($group_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_group_menu_y').toggle('fast');$('#active_approver_group_y').html($(this).html());$('#selected_approver_group_y').val(<?php print($unit_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($group_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_group_y" value="0">
</div></div>

</div>

<div style="width:80%;height:auto;float:left;margin-left:40px;display:none;" id="user_approver_holder_y">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:60px;">User:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#approver_user_menu_y').toggle('fast');" id="active_approver_user_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;">Select user</div>

			<div class="option_menu" id="approver_user_menu_y" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
			
				$user_menu = mysqli_query($connect,"select * from users where company_id = $company_id and status = 1 and id != $active_user_id order by _name")or die(mysqli_error($connect));

				for($u=0;$u<mysqli_num_rows($user_menu);$u++){
					$user_menu_results = mysqli_fetch_array($user_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approver_user_menu_y').toggle('fast');$('#active_approver_user_y').html($(this).html());$('#selected_approver_user_y').val(<?php print($user_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($user_menu_results['_name']);?></div>
					<?php
				}
			?>
			</div>
	</div>
	<input type="hidden" id="selected_approver_user_y" value="0">
</div></div></div>

<div style="width:80%;height:auto;float:left;" id="notify_creator_y">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Notify creator:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#notify_creator_menu_y').toggle('fast');" id="active_notify_creator_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:160px;width:auto;">Notify</div>

			<div class="option_menu" id="notify_creator_menu_y" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#notify_creator_menu_y').toggle('fast');$('#active_notify_creator_y').html($(this).html());$('#selected_notify_creator_y').val(1);$('#error_message').slideUp('fast');">Notify</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#notify_creator_menu_y').toggle('fast');$('#active_notify_creator_y').html($(this).html());$('#selected_notify_creator_y').val(0);$('#error_message').slideUp('fast');">Don't Notify</div>
				
			</div>
	</div>
	<input type="hidden" id="selected_notify_creator_y" value="0">
</div></div></div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Notify levels:</div>
<div style="width:150px;height:30px;float:left;line-height:30px;"><input type="text" id="request_notify_stages_y" style="border:solid 1px #aaa;width:100%;height:30px;" value="0" onfocusout="if(this.value==''){this.value='0';}" <?php if(!$editing){?> disabled <?php }?>></div>
</div>
</div>
