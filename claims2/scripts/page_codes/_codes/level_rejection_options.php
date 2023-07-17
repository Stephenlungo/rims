<?php

$this_claim = mysqli_query($$module_connect,"select * from payment_claims where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);

$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));

$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);

if($beneficiary_date == 0){
	$beneficiary_name = ' all beneficiaries ';
	
}else{
	$this_beneficiary = mysqli_query($$module_connect,"select * from claim_beneficiaries where agent_date = '$beneficiary_date' and claim_date = '$claim_date' and type_date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
	
	$this_beneficiary_results = mysqli_fetch_array($this_beneficiary,MYSQLI_ASSOC);
	
	$beneficiary_name = $this_beneficiary_results['_name'];
	
}

$levels = explode(']',$this_claim_type_results['rule_string']);

?>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;font-weight:bold;margin-bottom:10px;color:brown">Reject level <?php print(($level_index+1).' for '.$beneficiary_name.' under "'.$this_claim_type_results['title'].'" claim type');?>.</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Return to level:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#jump_level_menu').toggle('fast');" id="active_jump_level" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Level 1</div>

	<div class="option_menu" id="jump_level_menu" style="display:none;min-width:120px;width:auto;">
	<?php
		for($l=0;$l<count($levels);$l++){
			if($l<$level_index){
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#jump_level_menu').toggle('fast');$('#active_jump_level').html($(this).html());$('#selected_jump_level').val(<?php print($l);?>);">Level <?php print($l+1);?></div>
				<?php
			}
		}
	?>
	</div>
	</div>
		<input type="hidden" id="selected_jump_level" value="0">
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Action on re-approval:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#re_approval_menu').toggle('fast');" id="active_re_approval" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Skip middle levels and continue on level <?php print($level_index+1);?></div>

	<div class="option_menu" id="re_approval_menu" style="display:none;min-width:120px;width:auto;">
			
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#re_approval_menu').toggle('fast');$('#active_re_approval').html($(this).html());$('#selected_re_approval').val(1);">Skip middle levels and continue on level <?php print($level_index+1);?></div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#re_approval_menu').toggle('fast');$('#active_re_approval').html($(this).html());$('#selected_re_approval').val(0);">Go through all middle levels</div>
	</div>
	</div>
		<input type="hidden" id="selected_re_approval" value="1">
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Comment:</div>
	<div style="width:250px;min-height:30px;height:60px;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		<textarea id="rejection_comment" style="color:#aaa;font-family:arial;min-width:100%;max-width:100%;min-height:100%;height:100%;font-size:0.9em;" onfocus="if($(this).val()=='Put reason for rejection'){this.value='';this.style.color='#000';}" onfocusout="if($(this).val()==''){$(this).html('Put reason for rejection');this.style.color='#aaa';}">Put reason for rejection</textarea>
	
	</div>
		
		<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#d05858';" onmouseout="this.style.backgroundColor='brown';"  id="level_continue_rejection_button" onclick="if($('#rejection_comment').val() == '' || $('#rejection_comment').val() == 'Put reason for rejection'){alert('You need to enter reason for rejection');}else{reject_level(<?php print($claim_date.','.$claim_type_date.','.$beneficiary_date.','.$claim_type_index.','.$level_index.','.$request_type.','.$action_type);?>);}" title="Click to continue with rejection">Continue</div>
</div>