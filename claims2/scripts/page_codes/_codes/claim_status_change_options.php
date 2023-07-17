<?php

$this_claim = mysqli_query($$module_connect,"select * from payment_claims where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);

?>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;font-weight:bold;margin-bottom:10px;">Change status of claim</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:130px;height:30px;line-height:30px;float:left;">New status:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#claim_new_status_menu').toggle('fast');" id="active_claim_new_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Select option</div>

	<div class="option_menu" id="claim_new_status_menu" style="display:none;min-width:120px;width:auto;">
	
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_new_status_menu').toggle('fast');$('#active_claim_new_status').html($(this).html());$('#claim_new_status').val(3);$('#complete_description').slideUp('fast');$('#rejected_description').slideDown('fast');$('#pending_description').slideUp('fast');$('#disabled_description').slideUp('fast');">Rejected</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_new_status_menu').toggle('fast');$('#active_claim_new_status').html($(this).html());$('#claim_new_status').val(1);$('#complete_description').slideUp('fast');$('#rejected_description').slideUp('fast');$('#pending_description').slideDown('fast');$('#disabled_description').slideUp('fast');">Pending</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_new_status_menu').toggle('fast');$('#active_claim_new_status').html($(this).html());$('#claim_new_status').val(2);$('#complete_description').slideDown('fast');$('#rejected_description').slideUp('fast');$('#pending_description').slideUp('fast');$('#disabled_description').slideUp('fast');">Completed</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_new_status_menu').toggle('fast');$('#active_claim_new_status').html($(this).html());$('#claim_new_status').val(0);$('#complete_description').slideUp('fast');$('#rejected_description').slideUp('fast');$('#pending_description').slideUp('fast');$('#disabled_description').slideDown('fast');">Disabled</div>
		
	</div>
	</div>
		<input type="hidden" id="claim_new_status" value="0">
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;color:#8c9260;font-weight:bold;display:none;margin-bottom:40px;" id="rejected_description">This will change the status of the claim to "rejected". The claim will be moved to the "Rejected" category. Please note that beneficiary statuses will not be altered.</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;color:#8c9260;font-weight:bold;display:none;margin-bottom:40px;" id="pending_description">This will change the status of the claim to "pending". The claim will be moved to the "Pending" category. Please note that beneficiary statuses will not be altered.</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;color:#8c9260;font-weight:bold;display:none;margin-bottom:40px;" id="complete_description">This will change the status of the claim to "completed". The claim will be moved to the "Completed" category. Please note that beneficiary statuses will not be altered.</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;color:brown;font-weight:bold;display:none;margin-bottom:40px;" id="disabled_description">This will change the status of the claim to "disabled". The claim will be moved to the "Disabled" category and all beneficiary statuses will be changed to "disabled".</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Comment:</div>
	<div style="width:250px;min-height:30px;height:60px;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		<textarea id="status_change_comment" style="color:#aaa;font-family:arial;min-width:100%;max-width:100%;min-height:100%;height:100%;font-size:0.9em;" onfocus="if($(this).val()=='Put reason for changing claim status'){this.value='';this.style.color='#000';}" onfocusout="if($(this).val()==''){$(this).val('Put reason for changing claim status');this.style.color='#aaa';}">Put reason for changing claim status</textarea>
	
	</div>
		
		<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#d05858';" onmouseout="this.style.backgroundColor='brown';"  id="claim_status_change_button" onclick="if($('#status_change_comment').val() == '' || $('#status_change_comment').val() == 'Put reason for changing claim status'){alert('You need to provide a comment for your change');}else{process_change_claim_status(<?php print($claim_date);?>);}" title="Click to continue">Continue</div>
</div>