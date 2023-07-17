<?php
$this_pipat_claims_database_ip = getenv('PIPAT_CLAIMS_DATABASE_IP');
$this_pipat_claims_database_name = getenv('PIPAT_CLAIMS_DATABASE_NAME');
$this_pipat_claims_database_username = getenv('PIPAT_CLAIMS_DATABASE_USERNAME');
$this_pipat_claims_database_password = getenv('PIPAT_CLAIMS_DATABASE_PASSWORD');

$claims_connect = mysqli_connect($this_pipat_claims_database_ip,$this_pipat_claims_database_username,$this_pipat_claims_database_password);
mysqli_query($claims_connect,'use '.$this_pipat_claims_database_name)or die(mysqli_error($claim_connect));

$editing = 1;
$default_color = '#000';
$claim_type_title = 'multiple';
$this_batch = fetch_db_table('connect','meeting_batches',$company_id,'id',' id = '.$batch_id);

$batch_title = $this_batch['title'][0];
$claim_type_ids = $this_batch['claim_type_ids'][0];

$meeting_ids = $this_batch['meeting_ids'][0];
$meeting_filter = '(id = '.str_replace(","," or id = ",$this_batch['meeting_ids'][0]).')';
$participant_filter = '(meeting_id = '.str_replace(","," or meeting_id = ",$this_batch['meeting_ids'][0]).')';

$meetings = fetch_db_table('connect','meetings',$company_id,'id',$meeting_filter);
$batch_participants = fetch_db_table('connect','meeting_batch_participants',$company_id,'id',' batch_id = '.$batch_id);

$claim_type_array = fetch_db_table('claims_connect','request_types',$company_id,'title','');
?>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Batch title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($batch_title);?>"  id="batch_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter batch title here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($batch_title);?>';this.style.color='<?php print($default_color);?>}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Claim type:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="alert('This option has been disabled. Default claim types for meetings/teams will be used')" id="active_meeting_claim" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($claim_type_title);?></div>

			<div class="option_menu" id="meeting_claim_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
					
					for($c=0;$c<count($claim_type_array['id']);$c++){
						if($claim_type_array['status'][$c] == 1){
						?>
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_claim_menu').toggle('fast');$('#active_meeting_claim').html($(this).html());$('#selected_meeting_claim').val(<?php print($claim_type_array['id'][$c]);?>);"><?php print($claim_type_array['title'][$c]);?></div>
						<?php
						}
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_meeting_claim" value="<?php print($claim_type_ids);?>">
</div>
</div>

<div style="width:100%;height:390px;overflow:auto;float:left;">
<?php

for($m=0;$m<count($meetings['id']);$m++){
	?>
	<div style="width:100%;cursor:pointer;margin-top:5px;height:20px;line-height:20px;float:left;background-color:#000;color:#fff;text-align:center;" onclick="$('#meeting_holder_<?php print($meetings['id'][$m]);?>').slideToggle('fast');"><?php print($meetings['title'][$m]);?></div>
	<div style="width:100%;height:auto;float:left;<?php if($m != 0){?>display:none;<?php }?>;margin-bottom:10px;" id="meeting_holder_<?php print($meetings['id'][$m]);?>">
	
<?php
	
	$participant_index = array_keys($batch_participants['meeting_id'],$meetings['id'][$m]);
	
	if(isset($participant_index[0])){
		$this_claim_type_array = explode(',',$this_batch['claim_type_ids'][0]);
		
		for($c=0;$c<count($this_claim_type_array);$c++){
			$claim_type_index = array_keys($claim_type_array['id'],$this_claim_type_array[$c]);
			
			if(isset($claim_type_index[0])){
				
				$claim_type_rate = $claim_type_array['daily_rate'][$claim_type_index[0]];
				$rate_title = 'K'.number_format($claim_type_array['daily_rate'][$claim_type_index[0]],2).' per day';
				
				$fixed_rate = 0;
				if($claim_type_array['billing_type'][$claim_type_index[0]]){
					$claim_type_rate = $claim_type_array['fixed_amount'][$claim_type_index[0]];
					
					$rate_title = 'Fixed: K'.number_format($claim_type_array['fixed_amount'][$claim_type_index[0]],2);
					
					$fixed_rate = 1;
				}
				
				?>
				<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#006bb3;color:#fff;text-align:left;"><?php print($claim_type_array['title'][$claim_type_index[0]].' ('.$rate_title.')');?></div>
				
				<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><div style="width:20px;height:20px;float:left;display:none;"><input type="checkbox" onchange="if(this.checked){select_in_view(1);}else{select_in_view(0);}" id="meeting_check_box_parent"></div><div style="width:210px;height:20px;float:left;margin-right:3px;">Names</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Phone</div><div style="width:80px;height:20px;float:left;margin-right:3px;">NRC</div><div style="width:90px;height:20px;float:left;margin-right:3px;">From</div><div style="width:90px;height:20px;float:left;margin-right:3px;">To</div><div style="width:90px;height:20px;float:left;margin-right:3px;text-align:right;">Payable</div><div style="width:90px;height:20px;float:left;margin-right:3px;text-align:right;">Amount(K)</div></div>
		
				<?php
				
				for($p=0;$p<count($participant_index);$p++){
					
					if($batch_participants['claim_type_id'][$participant_index[$p]] == $this_claim_type_array[$c]){
						
						if($batch_participants['responsibility_id'][$participant_index[$p]] == 1){
							$responsibility_title = 'DEC';
							
						}else if($batch_participants['responsibility_id'][$participant_index[$p]] == 2){
							$responsibility_title = 'Vaccinator';
							
						}else if($batch_participants['responsibility_id'][$participant_index[$p]] == 3){
							$responsibility_title = 'Mobilizer';
							
						}else if($batch_participants['responsibility_id'][$participant_index[$p]] == 4){
							$responsibility_title = 'Supervisor';
							
						}else if($batch_participants['responsibility_id'][$participant_index[$p]] == 5){
							$responsibility_title = 'HL mobilizer';
							
						}else if($batch_participants['responsibility_id'][$participant_index[$p]] == 6){
							$responsibility_title = 'Team-lead';
							
						}
						
						$this_participant_id = $batch_participants['id'][$participant_index[$p]];
						
					?>
					<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;"><div style="width:20px;height:20px;float:left;display:none;"><input type="checkbox" onchange="if(this.checked){select_in_view(1);}else{select_in_view(0);}" id="meeting_check_box_parent"></div><div style="width:210px;height:20px;float:left;margin-right:3px;"><?php print($batch_participants['_name'][$participant_index[$p]].' ('.$responsibility_title.')');?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($batch_participants['phone'][$participant_index[$p]]);?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($batch_participants['nrc'][$participant_index[$p]]);?></div><div style="width:90px;height:20px;float:left;margin-right:3px;"><?php print(date('dS M, Y',$batch_participants['period_from'][$participant_index[$p]]));?></div><div style="width:90px;height:20px;float:left;margin-right:3px;"><?php print(date('dS M, Y',$batch_participants['period_to'][$participant_index[$p]]));?></div><div style="width:90px;height:20px;float:left;margin-right:3px;text-align:right;"><input id="payable_<?php print($this_participant_id);?>" type="text" style="width:100%;height:20px;text-align:right;" value="<?php print($batch_participants['days_payable'][$participant_index[$p]]);?>" onfocus="this.value=''" onfocusout="if(isNaN(this.value) || this.value==''){this.value='<?php print($batch_participants['days_payable'][$participant_index[$p]]);?>'}else{<?php if(!$fixed_rate){?> $('#amount_<?php print($batch_participants['id'][$participant_index[$p]]);?>').html(Number(this.value) * <?php print($claim_type_rate);?>) <?php }?>;if(!search_item_in_list('participant_editing_string',<?php print($this_participant_id);?>,',')){add_to_selection(<?php print($this_participant_id);?>,'participant_editing_string');}}"></div><div style="width:90px;height:20px;float:left;margin-right:3px;text-align:right;" id="amount_<?php print($batch_participants['id'][$participant_index[$p]]);?>"><?php print(number_format($batch_participants['amount'][$participant_index[$p]],2));?></div></div>
					<?php
					}
				}
			}
		}
	}
	?>
	</div>
	<?php
}
?>

<input type="hidden" id="participant_editing_string" value="">
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:90px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_batch_button" onclick="update_batch(<?php print($batch_id);?>)" title="Click to update batch">Update batch</div>

</div>