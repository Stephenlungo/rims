<div style="width:400px;height:450px;position:absolute;z-index:2;display:none;" id="new_request_threshold" >
<div class="window_holder" style="width:400px;">
<div class="window_title_bar">Create new approval group

<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="close_window('new_request_threshold');">X</div>
</div>

<div class="window_container" style="width:98.5%;padding:2px;height:450px;">


<div style="width:100%;height:auto;margin:0 auto;">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" id="new_request_threshold_title" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_threshold_error_message').hide('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>
</div>

<?php
if(!$user_results['branch_id']){
	$branch_title = 'Non-clustered';
	
}else{
	$branch_id = $user_results['branch_id'];
	$this_branch = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
	$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
	
	$branch_title = $this_branch_results['title'];
}
?>

<div style="width:100%;float:left;margin-bottom:10px;">
<div style="line-height:30px;width:100px;height:30px;float:left;">Cluster: </div>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#approval_branch_menu').toggle('fast');" id="active_approval_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($branch_title);?></div>

<?php 
if($user_results['branch_id'] == 0){?>
<div class="option_menu" id="approval_branch_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approval_branch_menu').toggle('fast');$('#active_approval_branch').html($(this).html());$('#new_threshold_branch_id').val(0)" >Non-clustered</div>
<?php
$branches = mysqli_query($connect,"select * from branches where company_id = $company_id")or die(mysqli_error($connect));

for($b=0;$b<mysqli_num_rows($branches);$b++){
	$branches_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);
	
	if($branches_results['branch_limit'] == 0){
		$branch_limit = '<i>Unlimited</i>';
		
	}else{
		$branch_limit = 'K'.number_format($branches_results['branch_limit']);
	}

	?>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approval_branch_menu').toggle('fast');$('#active_approval_branch').html($(this).html());$('#new_threshold_branch_id').val(<?php print($branches_results['id']);?>)"><?php print($branches_results['title'].' ('.$branch_limit.')');?></div>
<?php
}
?>
</div>
<?php
}
?>
</div>
<input type="hidden" id="new_threshold_branch_id" value="<?php print($user_results['branch_id']);?>">
</div>

<div style="width:100%;float:left;margin-bottom:10px;">
<div style="line-height:30px;width:100px;height:30px;float:left;">Type: </div>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#approval_type_menu').toggle('fast');" id="active_approval_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Select type</div>


<div class="option_menu" id="approval_type_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approval_type_menu').toggle('fast');$('#active_approval_type').html($(this).html());$('#new_threshold_type').val(0);var total = Number($('#total_thresholds').val());for(var i=0;i<total;i++){$('#lower_values_holder_'+i).slideDown('fast');$('#higher_values_holder_'+i).slideDown('fast');$('#approver_allocation_'+i).slideUp('fast');}" >Threshold</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#approval_type_menu').toggle('fast');$('#active_approval_type').html($(this).html());$('#new_threshold_type').val(1);var total = Number($('#total_thresholds').val());for(var i=0;i<total;i++){$('#lower_values_holder_'+i).slideUp('fast');$('#higher_values_holder_'+i).slideUp('fast');$('#approver_allocation_'+i).slideDown('fast');}" >Pool</div>

</div>

</div>
<input type="hidden" id="new_threshold_type" value="0">
</div>

<div style="width:100%;height:auto;float:left;" id="thresholds_holder_1">
<div style="width:100%;height:auto;float:left;" id="thresholds_holder_0">
<div style="width:100%;height:auto;float:left;" id="thresholds_item_0" title="You cannot remove this approver setting">
<div style="width:100%;height:20px;float:left;font-weight:bold;background-color:#eee;margin-top:5px;" ondblclick = "remove_threshold_approver(0);">Approver 1</div>
<div style="width:300px;float:left;">
<div style="line-height:20px;width:80px;height:20px;float:left;">Limitation: </div>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#new_request_threshold_menu_0').toggle('fast');" id="new_active_request_type_threshold_limit_type_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Unlimited</div>


<div class="option_menu" id="new_request_threshold_menu_0" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_request_threshold_menu_0').toggle('fast');$('#new_active_request_type_threshold_limit_type_0').html($(this).html());$('#new_request_threshold_type_id_0').val(0);$('#new_request_type_threshold_limit_0').hide('fast');" >Unlimited</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_request_threshold_menu_0').toggle('fast');$('#new_active_request_type_threshold_limit_type_0').html($(this).html());$('#new_request_threshold_type_id_0').val(1);$('#new_request_type_threshold_limit_0').show('fast');" >Limited</div>

</div>
</div>
<input type="hidden" id="new_request_threshold_type_id_0" value="0">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;display:none;" id="new_request_type_threshold_limit_0">
<div style="width:100px;height:30px;line-height:30px;float:left;">Maximum limit:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" id="new_request_threshold_limit_0" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter limit here" onfocus="if(this.value=='Enter limit here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_threshold_error_message').hide('fast');" onfocusout="if(this.value==''){this.value='Enter limit here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;" id="standard_confirm_holder">
<div style="line-height:30px;width:80px;height:30px;float:left;">Approvers: </div>

<div style="width:200px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">
<div class="option_item" title="Click to change option" onclick="$('#request_threshold_approver_menu_0').toggle('fast');" id="active_threshold_approver_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><i>Site-level approvers</i></div>
<div class="option_menu" id="request_threshold_approver_menu_0" style="display:none;width:190px"><div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_threshold_approver_menu_0').toggle('fast');$('#active_threshold_approver_0').html($(this).html());$('#request_threshold_approver_0').val('s');$('#threshold_descriptors_0').show('fast');fetch_level_locations_2(0,'sites');" style="font-style:italic"><i>Site-level approvers</i></div>
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_threshold_approver_menu_0').toggle('fast');$('#active_threshold_approver_0').html($(this).html());$('#request_threshold_approver_0').val('h');$('#threshold_descriptors_0').show('fast');fetch_level_locations_2(0,'districts');" style="font-style:italic"><i>Hub-level approvers</i></div>
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_threshold_approver_menu_0').toggle('fast');$('#active_threshold_approver_0').html($(this).html());$('#request_threshold_approver_0').val('p');$('#threshold_descriptors_0').show('fast');fetch_level_locations_2(0,'provinces');" style="font-style:italic"><i>Province-level approvers</i></div>
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_threshold_approver_menu_0').toggle('fast');$('#active_threshold_approver_0').html($(this).html());$('#request_threshold_approver_0').val('r');$('#threshold_descriptors_0').show('fast');fetch_level_locations_2(0,'regions');" ><i>Region-level approvers</i></div>

	<?php

	$creators = mysqli_query($claims_connect,"select * from users where companyID = $company_id order by _name")or die(mysqli_error($claims_connect));

	for($u=0;$u<mysqli_num_rows($creators);$u++){
		$creator_results = mysqli_fetch_array($creators,MYSQLI_ASSOC);
		?>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_threshold_approver_menu_0').toggle('fast');$('#active_threshold_approver_0').html($(this).html());$('#request_threshold_approver_0').val('u-<?php print($creator_results['_date']);?>');$('#threshold_descriptors_0').hide('fast');$('#threshold_location_0').val(0);$('#threshold_unit_0').val(0);" ><?php print($creator_results['_name']);?></div>
		
		<?php
	}
	?>
	</div><input type="hidden" id="request_threshold_approver_0" value="s"></div>

	<div style="width:100%;height:auto;float:left;" id="threshold_descriptors_0"><div style="line-height:30px;width:80px;height:30px;float:left;">Location: </div>
	<div style="width:200px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">
	<div class="option_item" title="Click to change option" onclick="$('#threshold_location_menu_0').toggle('fast');" id="active_threshold_location_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><i>All locations</i></div>
	
	<div class="option_menu" id="threshold_location_menu_0" style="display:none;width:190px">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_location_menu_0').toggle('fast');$('#active_threshold_location_0').html($(this).html());$('#threshold_location_0').val(0);" style="font-style:italic"><i>All locations</i></div>

	<?php
	$locations = mysqli_query($pipat_connect,"select * from sites where company_id = $company_id order by title")or die(mysqli_error($connect));

	for($l=0;$l<mysqli_num_rows($locations);$l++){
		$location_results = mysqli_fetch_array($locations,MYSQLI_ASSOC);
		?>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_location_menu_0').toggle('fast');$('#active_threshold_location_0').html($(this).html());$('#threshold_location_0').val(<?php print($location_results['id']);?>);" ><?php print($location_results['title']);?></div>
		
		<?php
	}

	?>

	</div></div><input type="hidden" id="threshold_location_0" value="0">

	<div style="width:100%;height:auto;float:left;">
	<div style="line-height:30px;width:80px;height:30px;float:left;">Unit: </div>
	
	<div style="width:200px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">
	
	<div class="option_item" title="Click to change option" onclick="$('#threshold_unit_menu_0').toggle('fast');" id="active_threshold_unit_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><i>All units</i></div>
	
	<div class="option_menu" id="threshold_unit_menu_0" style="display:none;width:190px">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_unit_menu_0').toggle('fast');$('#active_threshold_unit_0').html($(this).html());$('#threshold_unit_0').val(0);" style="font-style:italic"><i>All units</i></div>
	
	<?php

	$units = mysqli_query($pipat_connect,"select * from services where company_id = $company_id order by title")or die(mysqli_error($connect));

	for($u=0;$u<mysqli_num_rows($units);$u++){
		$unit_results = mysqli_fetch_array($units,MYSQLI_ASSOC);
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_unit_menu_0').toggle('fast');$('#active_threshold_unit_0').html($(this).html());$('#threshold_unit_0').val(<?php print($unit_results['id']);?>)" ><?php print($unit_results['title']);?></div>
		<?php
		
	}
	?>

	</div></div><input type="hidden" id="threshold_unit_0" value="0"></div></div></div>
	<div style="width:100%;height:30px;float:left;line-height:30px;" id="lower_values_holder_0"><div style="line-height:30px;width:80px;height:30px;float:left;">Low values:</div>	
	<div style="width:80px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">
	
	<div class="option_item" title="Click to change option" onclick="$('#threshold_lower_limits_menu_0').toggle('fast');" id="active_threshold_lower_limits_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:170px;"><i>Skip if other approver exists</i></div>
	
	<div class="option_menu" id="threshold_lower_limits_menu_0" style="display:none;width:170px">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_lower_limits_menu_0').toggle('fast');$('#active_threshold_lower_limits_0').html($(this).html());$('#threshold_lower_limits_0').val(0);" style="font-style:italic"><i>Skip if other approver exists</i></div>
	
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_lower_limits_menu_0').toggle('fast');$('#active_threshold_lower_limits_0').html($(this).html());$('#threshold_lower_limits_0').val(1);" style="font-style:italic"><i>Confirm</i></div>
	</div></div><input type="hidden" id="threshold_lower_limits_0" value="0">
	
	
	</div>
	
	<div style="width:100%;height:30px;float:left;line-height:30px;" id="higher_values_holder_0"><div style="line-height:30px;width:80px;height:30px;float:left;">High values:</div>	
	<div style="width:80px;min-height:30px;height:auto;float:left;" onclick="$('#new_threshold_error_message').hide('fast');">
	
	<div class="option_item" title="Click to change option" onclick="$('#threshold_higher_limits_menu_0').toggle('fast');" id="active_threshold_higher_limits_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><i>Confirm</i></div>
	
	<div class="option_menu" id="threshold_higher_limits_menu_0" style="display:none;width:80px">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_higher_limits_menu_0').toggle('fast');$('#active_threshold_higher_limits_0').html($(this).html());$('#threshold_higher_limits_0').val(0);" style="font-style:italic"><i>Skip all</i></div>
	
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#threshold_higher_limits_menu_0').toggle('fast');$('#active_threshold_higher_limits_0').html($(this).html());$('#threshold_higher_limits_0').val(1);" style="font-style:italic"><i>Confirm</i></div>
	</div></div><input type="hidden" id="threshold_higher_limits_0" value="1">
	
	
	</div>
	
	<div style="width:100%;height:20px;float:left;line-height:20px;display:none;" id="approver_allocation_0"><label for="approver_allocation_check_0"><div style="line-height:20px;width:80px;height:20px;float:left;">Allocation:</div></label>
	
	<div style="width:80px;min-height:20px;height:auto;float:left;">
	<input type="checkbox" id="approver_allocation_check_0" onchange="if(this.checked){$('#approver_allocation_input_0').val(1);}else{$('#approver_allocation_input_0').val(0);}">
	<input type="hidden" id="approver_allocation_input_0" value="0">
	</div>
	</div>
	</div>
	</div>
	</div>
	<input type="hidden" id="total_thresholds" value="1">
<div style="width:100%;height:20px;float:left;background-color:#eef;text-align:center;line-height:20px;cursor:pointer" onmouseover="this.style.backgroundColor='#ddf';" onmouseout="this.style.backgroundColor='#eef';" onclick="add_threshold_approver()">Add</div>
	<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="create_request_threshold();" id="create_request_threshold_button">Create</div>

	<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_threshold_error_message"></div>
	</div>
</div>
</div>
</div>
</div>
