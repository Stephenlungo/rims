<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#c5e5eb;"><div style="width:20px;height:20px;float:left;"><input type="checkbox" onchange="if(this.checked){meeting_all_selection(<?php print($meeting_id);?>,1);}else{meeting_all_selection(<?php print($meeting_id);?>,0);}"></div>

<div style="width:120px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:200px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:100px;height:20px;float:left;margin-right:3px;">NRC</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Phone</div><div style="width:100px;height:20px;float:left;margin-right:3px;">New agent</div><div style="width:150px;height:20px;float:left;margin-right:3px;text-align:right;display:none;">Days worked</div></div>

<?php
$regions = fetch_db_table('connect','regions',$company_id,'id',"");
$provinces = fetch_db_table('connect','provinces',$company_id,'id',"");
$hubs = fetch_db_table('connect','hubs',$company_id,'id',"");
$sites = fetch_db_table('connect','sites',$company_id,'id',"");
$users = fetch_db_table('connect','users',$company_id,'id',"");
$units = fetch_db_table('connect','units',$company_id,'id'," status = 1");
$activities = fetch_db_table('connect','activities',$company_id,'id',"");
$this_meeting = fetch_db_table('connect','meetings',$company_id,'id'," id = ".$meeting_id);

$participants = fetch_db_table('connect','meeting_participants',$company_id,'id'," active_status = 1 and meeting_id = ".$meeting_id);

$participant_string = '';

if(!count($participants['id'])){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;font-weight:bold;margin-top:30px;color:red;">No participants have registered for this meeting yet</div>
	
	<script>
		$('#button_holder_0_<?php print($meeting_id);?>').slideUp('fast');
		$('#button_holder_1_<?php print($meeting_id);?>').slideUp('fast');
	</script>
	<?php
}else{
	for($p=0;$p<count($participants['id']);$p++){
		$form_option_array = explode(',',$participants['form_options'][$p]);
		
		$new_agent = 'No';
		if($participants['new_agent'][$p]){
			$new_agent = 'Yes';
		}
		
		if($participant_string == ''){
			$participant_string = $participants['id'][$p];
			
		}else{
			$participant_string .= ','.$participants['id'][$p];
		}
		
		$check_disabled = '';
		$color = '#000';
		$participant_active = 1;
		if($participants['status'][$p] == 2){
			$check_disabled = ' disabled ';
			$participant_active = 0;
			$color = 'green';
		}
		
		$question_1_answer = $form_option_array[9];
		$question_2_answer = $form_option_array[10];
		$question_3_answer = $form_option_array[11];
		$question_4_answer = $form_option_array[12];
		$question_5_answer = $form_option_array[13];
		$question_6_answer = $form_option_array[14];
		$question_7_answer = $form_option_array[15];
		
		if($question_1_answer == 1){
			$question_1_answer = 'Primary';
			
		}else if($question_1_answer == 2){
			$question_1_answer = 'Secondary';
			
		}
		
		if($question_2_answer == 1){
			$question_2_answer = 'None';
			
		}else if($question_2_answer == 2){
			$question_2_answer = '1yr to 3yrs';
			
		}else if($question_2_answer == 3){
			$question_2_answer = '4yrs to 7yrs';
			
		}else if($question_2_answer == 4){
			$question_2_answer = '8yrs and above';
		}
		
		if($question_3_answer == 1){
			$question_3_answer = 'Data entry';
			
		}else if($question_3_answer == 2){
			$question_3_answer = 'Vaccinator';
			
		}else if($question_3_answer == 3){
			$question_3_answer = 'Mobilizer';
			
		}else if($question_3_answer == 4){
			$question_3_answer = 'Supervisor';
			
		}else if($question_3_answer == 5){
			$question_3_answer = 'High-level mobilizer';
			
		}else if($question_3_answer == 6){
			$question_3_answer = 'Team-lead';
			
		}else if($question_3_answer == 7){
			$question_3_answer = 'Fleet Security';
			
		}else if($question_3_answer == 8){
			$question_3_answer = 'Councilor Supervisor';
			
		}else if($question_3_answer == 9){
			$question_3_answer = 'CHW';
			
		}
		
		if($question_4_answer == 1){
			$question_4_answer = 'Yes';
			
		}else if($question_4_answer == 2){
			$question_4_answer = 'No';
			
		}
		
		if($question_5_answer == 1){
			$question_5_answer = 'Yes';
			
		}else if($question_5_answer == 2){
			$question_5_answer = 'No';
			
		}
		
		if($question_6_answer == 1){
			$question_6_answer = 'Yes';
			
		}else if($question_6_answer == 2){
			$question_6_answer = 'No';
			
		}
		
		if($question_7_answer == 1){
			$question_7_answer = 'Yes';
			
		}else if($question_7_answer == 2){
			$question_7_answer = 'No';
			
		}
		?>
		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #fff;color:<?php print($color);?>"><div style="cursor:pointer;width:20px;height:20px;float:left;"><input type="checkbox" onchange="if(this.checked){add_to_selection(<?php print($participants['id'][$p]);?>,'selected_participants_<?php print($meeting_id);?>');$('#participant_selected_<?php print($participants['id'][$p]);?>').val(1);}else{remove_from_selection(<?php print($participants['id'][$p]);?>,'selected_participants_<?php print($meeting_id);?>');$('#participant_selected_<?php print($participants['id'][$p]);?>').val(0);}" id="participant_check_input_<?php print($participants['id'][$p]);?>" <?php print($check_disabled);?>></div><div style="width:auto;float:left;" onclick="$('#participant_responses_<?php print($participants['id'][$p]);?>').slideToggle('fast');"><div style="width:120px;height:20px;float:left;margin-right:3px;"><?php print(date('dS M, Y',$participants['_date'][$p]));?></div>
	<div style="width:200px;height:20px;float:left;margin-right:3px;"><?php print($form_option_array[6]);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print($form_option_array[7]);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print($form_option_array[8]);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print($new_agent);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;text-align:right;display:none;">0</div></div><?php if($participants['status'][$p] == 2 and ($this_meeting['batched'][0] == 0)){?> <div style="user-select: none;width:auto;float:left;margin-left:5px;background-color:#999;padding-left:5px;padding-right:5px;text-align:center;color:#fff;cursor:pointer;" ondblclick="var c = confirm('Are you sure you wish to unlock this entry?');if(c){document.getElementById('participant_check_input_<?php print($participants['id'][$p]);?>').disabled = false;}" onmouseover="this.style.backgroundColor='#aaa'" onmouseout="this.style.backgroundColor='#999'" title="Double click to unlock this entry. Unlocked entries can be selected for other actions">Unlock</div><?php }?></div>

	<div style="width:100%;height:auto;float:left;display:none;margin-bottom:10px;border-bottom:solid 2px #fff;" id="participant_responses_<?php print($participants['id'][$p]);?>">
		<div style="width:90%;height:auto;margin-left:20px;float:left;color:#006bb3;margin-top:2px;">

		What educational qualification do you possess?<br>
		<i>Answer: <?php print($question_1_answer);?><br><br></i>

		How many years do you have in mobilization?<br>
		<i>Answer: <?php print($question_2_answer);?><br><br></i>

		What are you applying for?<br>
		<i>Answer: <?php print($question_3_answer);?><br><br></i>

		<?php if($form_option_array[11] == 1){?>
			Do you have a smart phone?<br>
			
			<?php
		}else if($form_option_array[11] == 2){
			?>
			Do you have a practising license?<br>
			<?php
		}else if($form_option_array[11] == 3 || $form_option_array[11] == 5){
			?>
			Do you have any experience in mobilization<br>
			<?php
		}else if($form_option_array[11] == 4){
			?>
			Do you have any experience in supervision?<br>
			<?php
		}
		?>
		Answer: <?php print($question_4_answer);?><br><br>

		Have you worked with USAID DISCOVER-H before?<br>
		<i>Answer: <?php print($question_5_answer);?><br><br></i>

		Are you willing to wait for 14 days to receive your payments?<br>
		<i>Answer: <?php print($question_6_answer);?><br><br></i>

		Are you willing to meet the targets that you will be given?<br>
		<i>Answer: <?php print($question_7_answer);?><br><br></i>
		</div>
	</div>


	<input type="hidden" value="0" id="participant_selected_<?php print($participants['id'][$p]);?>">
	<input type="hidden" value="<?php print($participant_active);?>" id="participant_active_<?php print($participants['id'][$p]);?>">
		
		<?php
	}
	
	?>
	<script>
		$('#button_holder_0_<?php print($meeting_id);?>').slideDown('fast');
		$('#button_holder_1_<?php print($meeting_id);?>').slideDown('fast');
	</script>
	<?php
}
?>
<input type="hidden" id="selected_participants_<?php print($meeting_id);?>" value="">
<input type="hidden" id="participant_string_<?php print($meeting_id);?>" value="<?php print($participant_string);?>">