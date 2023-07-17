<?php
$default_color = '#aaa';
$batch_title = 'Enter batch title here';

$editing = 1;

$claim_type_title = '[Multiple]';

$this_pipat_claims_database_ip = getenv('PIPAT_CLAIMS_DATABASE_IP');
$this_pipat_claims_database_name = getenv('PIPAT_CLAIMS_DATABASE_NAME');
$this_pipat_claims_database_username = getenv('PIPAT_CLAIMS_DATABASE_USERNAME');
$this_pipat_claims_database_password = getenv('PIPAT_CLAIMS_DATABASE_PASSWORD');

$claims_connect = mysqli_connect($this_pipat_claims_database_ip,$this_pipat_claims_database_username,$this_pipat_claims_database_password);
mysqli_query($claims_connect,'use '.$this_pipat_claims_database_name)or die(mysqli_error($claim_connect));

$meeting_filter = "(id = ".str_replace(","," or id = ",$selected_meeting_ids).")";
$participant_filter = "(meeting_id = ".str_replace(","," or meeting_id = ",$selected_meeting_ids).")";

$meetings = fetch_db_table('connect','meetings',$company_id,'title',$meeting_filter);
$meeting_participants = fetch_db_table('connect','meeting_participants',$company_id,'id',' status = 2 and '.$participant_filter);

$claim_type_ids = '153,426';
?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Batch title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($batch_title);?>"  id="batch_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter batch title here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($batch_title);?>';this.style.color='<?php print($default_color);?>}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Claim type:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#meeting_claim_menu').slideToggle('fast');" id="active_meeting_claim" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($claim_type_title);?></div>

			<div class="option_menu" id="meeting_claim_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
					$claim_type_array = fetch_db_table('claims_connect','request_types',$company_id,'title',' status = 1');
					for($c=0;$c<count($claim_type_array['id']);$c++){
						
						$rate = 'K'.number_format($claim_type_array['daily_rate'][$c],2).' daily';
						
						if($claim_type_array['billing_type'][$c]){
							$rate = 'Fixed: K'.number_format($claim_type_array['fixed_amount'][$c],2);
						}
						
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_claim_menu').toggle('fast');$('#active_meeting_claim').html($(this).html());$('#selected_meeting_claim').val(<?php print($claim_type_array['id'][$c]);?>);"><?php print($claim_type_array['title'][$c].' ['.$rate.']');?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_meeting_claim" value="<?php print($claim_type_ids);?>">
</div>
</div>

<div style="width:100%;height:20px;line-height:20px;background-color:#eef;text-align:center;float:left;">Batch meetings</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:100%;float:left;font-weight:bold;line-height:20px;">
<div style="width:20px;float:left;"><input type="checkbox"></div>
<div style="width:300px;float:left;">Title</div>
<div style="width:100px;float:left;">Approved</div>

</div>

<div style="width:100%;min-height:100px;max-height:250px;overflow:auto;">
<?php

	$no_participants = '';

	$total_approved = 0;
	for($m=0;$m<count($meetings['id']);$m++){
		
		$participant_index = array_keys($meeting_participants['meeting_id'],$meetings['id'][$m]);
		
		$total_participants = 0;
		if(isset($participant_index[0])){
			$total_participants = count($participant_index);
			
		}
		
		$total_approved += $total_participants;
		
		?>
		<div style="width:100%;float:left;border-bottom:solid 1px #eee;line-height:20px;">
			<div style="width:20px;float:left;"><input type="checkbox" checked onchange="if(this.checked){add_to_selection(<?php print($meetings['id'][$m]);?>,'selected_meetings');document.getElementById('meeting_check_box_<?php print($meetings['id'][$m]);?>').checked = true;calculate_total_approved(<?php print($meetings['id'][$m]);?>,1);}else{remove_from_selection(<?php print($meetings['id'][$m]);?>,'selected_meetings');document.getElementById('meeting_check_box_<?php print($meetings['id'][$m]);?>').checked = false;calculate_total_approved(<?php print($meetings['id'][$m]);?>,0);};" id="batch_config_check_<?php print($meetings['id'][$m]);?>"></div>
			<div style="width:300px;float:left;"><label for="batch_config_check_<?php print($meetings['id'][$m]);?>"><?php print($meetings['title'][$m]);?></label></div>
			<div style="width:100px;float:left;"><?php print($total_participants);?></div>
			<input type="hidden" id="total_participants_<?php print($meetings['id'][$m]);?>" value="<?php print($total_participants);?>">
		</div>
		<?php
		
		if(!$total_participants){
			
			if($no_participants == ''){
				$no_participants = $meetings['id'][$m];
				
			}else{
				$no_participants .= ','.$meetings['id'][$m];
				
			}
			
		}
	}
?>
</div>

<input type="hidden" id="total_approved" value="<?php print($total_approved);?>">
<input type="hidden" id="no_participants_string" value="<?php print($no_participants);?>">

<div style="width:100%;float:left;font-weight:bold;line-height:20px;">
	<div style="width:20px;height:20px;float:left;"></div>
	<div style="width:290px;height:20px;float:left;text-align:right;">Total approved: </div>
	<div style="width:100px;height:20px;float:left;margin-left:10px;" id="total_approved_holder"><?php print($total_approved);?></div>
</div>

</div>

<div style="width:100%;min-height:20px;height:auto;float:left;color:purple;margin-top:5px;"><i>Please note that meetings/teams with no approved participants will be skipped. Only approved participants are considered for batching</i></div>

<div style="width:100%;height:auto;float:left;color:brown;font-weight:bold;display:none;margin-top:5px;" id="batch_error"></div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<div style="width:110px;height:30px;background-color:#0faeaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#20908e'" onmouseout="this.style.backgroundColor='#0faeaa'" id="batch_meetings_button" onclick="process_batch_meetings();" title="Click to update account details">Batch meetings</div>

</div>


<script>
	function calculate_total_approved(meeting_id,direction){
		var total_approved = Number($('#total_approved').val());
		var total_participants = Number($('#total_participants_'+meeting_id).val());
		
		if(direction == 0){
			total_approved = total_approved - total_participants;
			
		}else{
			total_approved = total_approved + total_participants;
		}
		
		$('#total_approved').val(total_approved);
		
		$('#total_approved_holder').html(total_approved);
	}
	
	function remove_no_participants(){
		if($('#no_participants_string').val() != ''){
			var no_participants_string = $('#no_participants_string').val();
			var no_participants_array = no_participants_string.split(',');;
			
			
			for(var n=0;n<no_participants_array.length;n++){
				$('#batch_config_check_'+no_participants_array[n]).click();
				
				document.getElementById('batch_config_check_'+no_participants_array[n]).disabled = true;
			}
		}
	}
	
	remove_no_participants();
</script>