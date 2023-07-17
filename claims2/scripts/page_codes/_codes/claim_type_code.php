<?php
if($claim_type_id){
	$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
	$button_text = 'Update';
	$approva_code = '';
	
	$approval_rules = explode(",",$this_claim_type_results['stage_approvers']);
	$creator_rules = explode(":",$approval_rules[0]);
	$creator_location_id = $creator_rules[1];
	$creator_unit_id = $creator_rules[2];
	$creator_hide_descriptors = '';
	
	if($creator_rules[0] == 's'){
		$creator_title = 'Site-level approvers';
		$creator_location = mysqli_query($connect,"select * from sites where id = $creator_location_id")or die(mysqli_error($connect));
		
	}else if($creator_rules[0] == 'h'){
		$creator_title = 'Hub-level approvers';
		$creator_location = mysqli_query($connect,"select * from hubs where id = $creator_location_id")or die(mysqli_error($connect));
	
	}else if($creator_rules[0] == 'p'){
		$creator_title = 'Provincial-level approvers';
		$creator_location = mysqli_query($connect,"select * from provinces where id = $creator_location_id")or die(mysqli_error($connect));
		
	}else if($creator_rules[0] == 'r'){
		$creator_title = 'Regional-level approvers';
		$creator_location = mysqli_query($connect,"select * from regions where id = $creator_location_id")or die(mysqli_error($connect));
	
	}else if($creator_rules[0] == 'u'){
		$creator_user_date = $creator_rules[1];
		$creator = mysqli_query($connect,"select * from users where _date = '$creator_user_date' and companyID = $company_id")or die(mysqli_error($connect));
		$creator_results = mysqli_fetch_array($creator,MYSQLI_ASSOC);
		
		$creator_title = $creator_results['_name'];
		$creator_hide_descriptors = 'none';
	}

	if(!$creator_location_id or $creator_rules[0] == 'u'){
		$creator_location_title = 'All locations';
		
	}else{
		$creator_location_results = mysqli_fetch_array($creator_location,MYSQLI_ASSOC);
		$creator_location_title = $creator_location_results['title'];
	}
	
	if(!$creator_unit_id){
		$creator_unit_title = 'All units';
		
	}else{
		$creator_unit = mysqli_query($pipat_connect,"select * from services where id = $creator_unit_id")or die(mysqli_error($pipat_connect));
		$creator_unit_results = mysqli_fetch_array($creator_unit,MYSQLI_ASSOC);
		$creator_unit_title = $creator_unit_results['title'];
	}
	
	$level_stage_titles = explode(",",$this_claim_type_results['approval_stage_titles']);
	
	if($level_stage_titles[0] == ''){
		$creator_level_stage_titles = '<i>Not set</i>';
		
	}else{
		$creator_level_stage_titles = $level_stage_titles[0];
	}
	
	$approval_code = '<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddd;text-align:center;">Level approvers</div><div style="width:100%;height:auto;float:left;font-weight:bold;">Level 1 (Creation)</div><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$creator_level_stage_titles.'</div></div><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Creators:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$creator_title.'</div></div><div style="width:100%;height:auto;float:left;display:'.$creator_hide_descriptors.'"><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Creator location:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$creator_location_title.'</div></div><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Unit:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$creator_unit_title.'</div></div></div>';
	
	
	for($l=1;$l<$this_claim_type_results['approval_stages'];$l++){
		$level_rules = explode(":",$approval_rules[$l]);		
		$level_location_id = $level_rules[1];
		$level_unit_id = $level_rules[2];
		$level_hide_descriptors = '';
		
		if($level_stage_titles[$l] == ''){
			$this_level_stage_titles = '<i>Not set</i>';
			
		}else{
			$this_level_stage_titles = $level_stage_titles[$l];
		}
		
		if($level_rules[0] == 's'){
			$level_title = 'Site-level approvers';
			$level_location = mysqli_query($connect,"select * from sites where id = $level_location_id")or die(mysqli_error($connect));
			
		}else if($level_rules[0] == 'h'){
			$level_title = 'Hub-level approvers';
			$level_location = mysqli_query($connect,"select * from hubs where id = $level_location_id")or die(mysqli_error($connect));
		
		}else if($level_rules[0] == 'p'){
			$level_title = 'Provincial-level approvers';
			$level_location = mysqli_query($connect,"select * from provinces where id = $level_location_id")or die(mysqli_error($pipat_connect));
			
		}else if($level_rules[0] == 'r'){
			$level_title = 'Regional-level approvers';
			$level_location = mysqli_query($connect,"select * from regions where id = $level_location_id")or die(mysqli_error($pipat_connect));
		
		}else if($level_rules[0] == 'u'){
			$level_user_date = $level_rules[1];
			$level_user = mysqli_query($connect,"select * from users where _date = '$level_user_date' and company_id = $company_id")or die(mysqli_error($connect));
			$level_user_results = mysqli_fetch_array($level_user,MYSQLI_ASSOC);
			
			$level_title = $level_user_results['_name'];
			$level_hide_descriptors = 'none';
		}

		if(!$level_location_id or $level_rules[0] == 'u'){
			$level_location_title = 'All locations';
			
		}else{
			$level_location_results = mysqli_fetch_array($level_location,MYSQLI_ASSOC);
			$level_location_title = $level_location_results['title'];
		}
		
		if(!$level_unit_id){
			$level_unit_title = 'All units';
			
		}else{
			$level_unit = mysqli_query($connect,"select * from units where id = $level_unit_id")or die(mysqli_error($pipat_connect));
			$level_unit_results = mysqli_fetch_array($level_unit,MYSQLI_ASSOC);
			$level_unit_title = $level_unit_results['title'];
		}
		
		
		$approval_code .= '<div style="width:100%;height:auto;float:left;margin-top:10px;font-weight:bold;">Level '.($l+1).'</div><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$this_level_stage_titles.'</div></div><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Approvers:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$level_title.'</div></div><div style="width:100%;height:auto;float:left;display:'.$level_hide_descriptors.'"><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Location:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$level_location_title.'</div></div><div style="width:100%;height:auto;float:left;"><div style="width:100px;height:30px;line-height:30px;float:left;">Unit:</div><div style="width:200px;height:30px;line-height:30px;float:left;">'.$level_unit_title.'</div></div></div>';
		
	}
	
}else{
	$button_text = 'Create';
	$approval_code = '';
}
?>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" name="new_claim_type_title" id="new_claim_type_title" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Approval levels:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" name="new_claim_type_approval_levels" id="new_claim_type_approval_levels" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter number of approval levels here" onfocus="if(this.value=='Enter number of approval levels here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter number of approval levels here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Daily rate:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" name="new_claim_type_daily_rate" id="new_claim_type_daily_rate" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter daily rate here" onfocus="if(this.value=='Enter daily rate here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter daily rate here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:220px;height:30px;line-height:30px;float:left;">Max payable days (Put '0' to unlimit)</div>
<div style="width:50px;height:30px;float:left;"><input type="text" name="new_claim_type_max_payable" id="new_claim_type_max_payable" style="border:solid 1px #aaa;width:100%;height:30px;" value="0" onfocusout="if(this.value==''){this.value='0';}"></div>
</div>

<div style="width:100%;height:30px;line-height:30px;float:left;margin-bottom:5px;">
<input type="checkbox" id="new_claim_type_allow_day_adjust" onchange="if(this.checked){$('#new_claim_type_day_adjustment_input').val(1);}else{$('#new_claim_type_day_adjustment_input').val(0);}"><label for="new_claim_type_allow_day_adjust">Allow day adjustment</label>
<input type="hidden" id="new_claim_type_day_adjustment_input" value="0">
</div>

<div style="width:300px;height:30px;float:left;margin-bottom:5px;" id="new_claim_type_urgency">
<div style="line-height:30px;width:80px;height:30px;float:left;">Urgency: </div>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#claim_type_urgency_menu').toggle('fast');" id="active_urgency" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Normal</div>


<div class="option_menu" id="claim_type_urgency_menu" style="display:none;">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_urgency_menu').toggle('fast');$('#active_urgency').html($(this).html());$('#new_claim_type_urgency_id').val(0)" >Low</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_urgency_menu').toggle('fast');$('#active_urgency').html($(this).html());$('#new_claim_type_urgency_id').val(1)" >Normal</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_urgency_menu').toggle('fast');$('#active_urgency').html($(this).html());$('#new_claim_type_urgency_id').val(2)" >High</div>

</div>
</div>
<input type="hidden" name="new_claim_type_urgency_id" id="new_claim_type_urgency_id" value="1">
</div>

<div style="width:300px;float:left;margin-bottom:5px;" id="new_claim_type_urgency">
<div style="line-height:30px;width:80px;height:30px;float:left;">Color: </div>
<div style="width:200px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#claim_type_color_menu').toggle('fast');" id="active_color" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Automatic</div>


<div class="option_menu" id="claim_type_color_menu" style="display:none;width:100px">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_claim_type_color_code').val('')" >Automatic</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_claim_type_color_code').val('000')" >Black</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_claim_type_color_code').val('faa')" >Red</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_claim_type_color_code').val('ddd')" >Gray</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_claim_type_color_code').val('eef')">Blue</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_claim_type_color_code').val('ffc864')">Orange</div>
</div>
</div>
<input type="hidden" name="new_claim_type_color_code" id="new_claim_type_color_code" value="">
</div>

<div style="width:100%;height:auto;float:left;"><?php print($approval_code);?></div>

<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_claim_type_error_message"></div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="create_claim_type();" id="create_claim_type"><?php print($button_text);?></div>
</div>