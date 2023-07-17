<div style="width:99%;padding:3px;height:auto;float:left;">

<?php
$this_survey = mysqli_query($connect,"select * from prep_questionnaires where id = $survey_id")or die(mysqli_error($connect));
$this_survey_results = mysqli_fetch_array($this_survey,MYSQLI_ASSOC);


$responses_array = fetch_db_table('connect','prep_client_answers',1,'id','questionnaire_data_set_id = '.$data_set_id);

if($data_set_id){
	$disabled_status = ' disabled ';
	
}else{
	$disabled_status = ' ';
	
}

?>

<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;font-size:1.3em;color:#788549"><?php print($this_survey_results['title']);?></div>


<div style="width:700px;margin:0 auto;height:auto;">
<div style="width:100%;height:30px;float:left;margin-top:10px;margin-bottom:5px;">
<div style="width:90px;height:30px;background-color:#ddd;text-align:center;line-height:30px;cursor:pointer;float:left;" onmouseover="this.style.backgroundColor='#eee';;" onmouseout="this.style.backgroundColor='#ddd';" onclick="<?php if(!$data_set_id){?>var c = confirm('Are you sure you wish to exit this survey? All responses will not be saved');if(c){fetch_analytical_survey();}<?php }else{?> fetch_analytical_survey_responses() <?php }?>">Exit</div>
</div>

<?php
$sessions = mysqli_query($connect,"select * from prep_questionnaire_sessions where questionnaire_id = $survey_id")or die(mysqli_error($connect));



$response_instruction_string = '';
$question_id_string = '';

for($s=0;$s<mysqli_num_rows($sessions);$s++){
	$session_results = mysqli_fetch_array($sessions,MYSQLI_ASSOC);
	
	$this_session_id = $session_results['id'];
	
	?>
	<div style="width:100%;min-height:30px;height:auto;float:left;font-weight:bold;color:#a99f38;font-size:1.2em;margin-top:30px;"><?php print($session_results['title']);?></div>
	<?php
	
	$questions = mysqli_query($connect,"select * from prep_questions where session_id = $this_session_id and status = 1")or die(mysqli_error($connect));
	
	
	for($q=0;$q<mysqli_num_rows($questions);$q++){
		$question_results = mysqli_fetch_array($questions,MYSQLI_ASSOC);
		
		$this_question_id = $question_results['id'];
		
		if($question_id_string == ''){
			$question_id_string = $this_question_id;
			
		}else{
			$question_id_string .= ','.$this_question_id;
			
		}
		
		if($question_results['option_type'] == 3){
			$question_answer = date('j',time()).'/'.date('m',time()).'/'.date('Y',time());
			
		}else{
			$question_answer = '';
		}
		
		if($response_instruction_string == ''){
			$response_instruction_string = $this_question_id.']'.$question_results['response_instruction'];
			
		}else{
			$response_instruction_string .= ','.$this_question_id.']'.$question_results['response_instruction'];
			
		}
		
		?>
		<div style="width:100%;height:auto;float:left;" id="qustion_holder_<?php print($this_question_id);?>">
		<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;" id="question_title_<?php print($question_results['id']);?>"><?php print(($q+1).'. '.$question_results['title']);?></div>
		<?php
		
		$options = mysqli_query($connect,"select * from prep_question_options where question_id = $this_question_id and status = 1")or die(mysqli_error($connect));
		
		for($o=0;$o<mysqli_num_rows($options);$o++){
			$option_results = mysqli_fetch_array($options,MYSQLI_ASSOC);
			
			
			$this_option_index = array_keys($responses_array['answer'],$option_results['id']);
			$option_checked = ' ';
			//print($data_set_id.' - '.count($this_option_index).' - '.$option_results['id'].',');
			if(isset($this_option_index[0])){
				$option_checked = ' checked ';
				$question_answer = $option_results['id'];
			}
			
			
			if($question_results['option_type'] == 0){
				
				
			?>
				<div style="width:100%;height:30px;line-height:30px;float:left;"><div style="width:20px;height:30px;float:left;line-height:30px;text-align:right;"><input <?php print($option_checked.' '.$disabled_status);?> type="radio" name="question_<?php print($this_question_id);?>"id="option_<?php print($option_results['id']);?>" style="margin-top:8px;"onclick="$('#question_answer_<?php print($this_question_id);?>').val(<?php print($option_results['id']);?>);$('#question_title_<?php print($question_results['id']);?>').css('color','black');check_dependancy_validations();"></div><div style="width:auto;height:30px;line-height:30px;float:left;margin-left:5px;"><label for="option_<?php print($option_results['id']);?>"><?php print($option_results['title']);?></label></div></div>
			<?php
			
			}else if($question_results['option_type'] == 1){
				?>
				<div style="width:100%;height:30px;line-height:30px;float:left;"><div style="width:20px;height:30px;float:left;line-height:30px;text-align:right;"><input <?php print($option_checked.' '.$disabled_status);?> type="checkbox" name="question_<?php print($this_question_id);?>"id="option_<?php print($option_results['id']);?>" style="margin-top:8px;"onchange="if(this.checked){add_to_selection(<?php print($option_results['id']);?>,'question_answer_<?php print($this_question_id);?>');}else{remove_from_selection(<?php print($option_results['id']);?>,'question_answer_<?php print($this_question_id);?>');}$('#question_title_<?php print($question_results['id']);?>').css('color','black');check_dependancy_validations();"></div><div style="width:auto;height:30px;line-height:30px;float:left;margin-left:5px;"><label for="option_<?php print($option_results['id']);?>"><?php print($option_results['title']);?></label></div></div>
			<?php
			
			}else if($question_results['option_type'] == 2){
				$this_option_index = array_keys($responses_array['question_id'],$this_question_id);
				
				if(isset($this_option_index[0])){
					$question_answer = $responses_array['answer'][$this_option_index[0]];
				}
				
			?>
				<div style="width:100%;height:30px;line-height:30px;float:left;"><div style="width:auto;height:30px;float:left;line-height:30px;"><?php print($option_results['title']);?></div><div style="width:200px;float:left;height:20px;margin-left:5px;"><input <?php print($disabled_status);?> type="text"style="width:100%;height:30px;" onfocusout="$('#question_answer_<?php print($this_question_id);?>').val(this.value);if(this.value!=''){$('#question_title_<?php print($question_results['id']);?>').css('color','black');}check_dependancy_validations();" value="<?php print($question_answer);?>"></div></div>
			<?php
			
			}else if($question_results['option_type'] == 3){
				$this_option_index = array_keys($responses_array['question_id'],$this_question_id);
				
				if(isset($this_option_index[0])){
					$question_answer = date('j',$responses_array['answer'][$this_option_index[0]]).'/'.date('m',$responses_array['answer'][$this_option_index[0]]).'/'.date('Y',$responses_array['answer'][$this_option_index[0]]);
				}
				
				$question_answer_array = explode('/',$question_answer);
			?>
				<div style="width:100%;height:30px;line-height:30px;float:left;">
				<div style="width:auto;height:30px;float:left;line-height:30px;margin-left:5px;font-weight:bold;"><?php print($option_results['title']);?>:</div>
				
					<div style="width:320px;float:left;margin-left:5px;">
						<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
						<div style="width:50px;min-height:30px;height:auto;float:left;">

						<div class="option_item" title="Click to change option" onclick="$('#option_day_<?php print($option_results['id']);?>_menu').toggle('fast');" id="active_option_day_<?php print($option_results['id']);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($question_answer_array[0]);?></div>

						<div class="option_menu" id="option_day_<?php print($option_results['id']);?>_menu" style="display:none;">
						<?php
						if(date('j',time()) < 15){
							for($d=1;$d<32;$d++){
								if($d<10){
									$do='0'.$d;
								}else{
									$do = $d;
								}
								?>

								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_day_<?php print($option_results['id']);?>_menu').toggle('fast');$('#active_option_day_<?php print($option_results['id']);?>').html($(this).html());$('#selected_option_day_<?php print($option_results['id']);?>').val(<?php print($d);?>);$('#question_answer_<?php print($this_question_id);?>').val($('#selected_option_day_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_month_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_day_<?php print($option_results['id']);?>').val());check_dependancy_validations()" style="width:40px;"><?php print($do);?></div>
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

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_day_<?php print($option_results['id']);?>_menu').toggle('fast');$('#active_option_day_<?php print($option_results['id']);?>').html($(this).html());$('#selected_option_day_<?php print($option_results['id']);?>').val(<?php print($d);?>);$('#question_answer_<?php print($this_question_id);?>').val($('#selected_option_day_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_month_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_year_<?php print($option_results['id']);?>').val());check_dependancy_validations()" style="width:40px;"><?php print($do);?></div>
							<?php
							}
						}
						?>
						</div>
						<input type="hidden" name="selected_option_day_<?php print($option_results['id']);?>" id="selected_option_day_<?php print($option_results['id']);?>" value="<?php print($question_answer_array[0]);?>">
						</div>



						<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
						<div style="width:50px;min-height:30px;height:auto;float:left;">

						<div class="option_item" title="Click to change option" onclick="$('#option_month_<?php print($option_results['id']);?>_menu').toggle('fast');" id="active_option_month_<?php print($option_results['id']);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($question_answer_array[1]);?></div>


						<div class="option_menu" id="option_month_<?php print($option_results['id']);?>_menu" style="display:none;">
						<?php



							for($m=1;$m<13;$m++){
								
								if($m<10){
									$mo='0'.$m;
								}else{
									$mo = $m;
								}
								?>

								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_month_<?php print($option_results['id']);?>_menu').toggle('fast');$('#active_option_month_<?php print($option_results['id']);?>').html($(this).html());$('#selected_option_month_<?php print($option_results['id']);?>').val(<?php print($m);?>);$('#question_answer_<?php print($this_question_id);?>').val($('#selected_option_day_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_month_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_year_<?php print($option_results['id']);?>').val());check_dependancy_validations()" style="width:40px;"><?php print($mo);?></div>
								<?php
							}

						?>
						</div>
						<input type="hidden" name="selected_option_month_<?php print($option_results['id']);?>" id="selected_option_month_<?php print($option_results['id']);?>" value="<?php print($question_answer_array[1]);?>">
						</div>

						<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
						<div style="width:50px;min-height:30px;height:auto;float:left;">

						<div class="option_item" title="Click to change option" onclick="$('#option_year_<?php print($option_results['id']);?>_menu').toggle('fast');" id="active_option_year_<?php print($option_results['id']);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($question_answer_array[2]);?></div>


						<div class="option_menu" id="option_year_<?php print($option_results['id']);?>_menu" style="display:none;width:65px;">
						<?php
							for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
								?>

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_year_<?php print($option_results['id']);?>_menu').toggle('fast');$('#active_option_year_<?php print($option_results['id']);?>').html($(this).html());$('#selected_option_year_<?php print($option_results['id']);?>').val(<?php print($y);?>);$('#question_answer_<?php print($this_question_id);?>').val($('#selected_option_day_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_month_<?php print($option_results['id']);?>').val()+'/'+$('#selected_option_year_<?php print($option_results['id']);?>').val());check_dependancy_validations()" style="width:50px;"><?php print($y);?></div>
							<?php
							}

						?>
						</div>
						<input type="hidden" name="selected_option_year_<?php print($option_results['id']);?>" id="selected_option_year_<?php print($option_results['id']);?>" value="<?php print($question_answer_array[2]);?>">
						</div>

						</div>
			
				</div>
			<?php
			}else{
				?>
			<div style="width:100%;height:30px;line-height:30px;float:left;"><?php print($option_results['title']);?></div>
			<?php
				
			}
			?>
			
			
			<input type="hidden" id="option_id_<?php print($s.'_'.$q.'_'.$o);?>" value="<?php print($option_results['id']);?>">
			<?php
		}
		
		
		?>
		
		<input type="hidden" id="question_answer_<?php print($this_question_id);?>" value="<?php print($question_answer);?>">
		<input type="hidden" id="question_mandatory_<?php print($this_question_id);?>" value="<?php print($question_results['mandatory']);?>">
		<input type="hidden" id="question_option_type_<?php print($this_question_id);?>" value="<?php print($question_results['option_type']);?>">
		<input type="hidden" id="question_id_<?php print($s.'_'.$q);?>" value="<?php print($this_question_id);?>">
		<input type="hidden" id="question_tree_<?php print($this_question_id);?>" value="">
		</div>
		<?php
	}
	?>
	<input type="hidden" id="session_id_<?php print($s);?>" value="<?php print($this_session_id);?>">
	
	<?php
}
?>
<input type="hidden" id="question_id_string" value="<?php print($question_id_string);?>">

<div style="width:100%;min-height:30px;height:auto;float:left;margin-top:10px;">
<div style="width:100%;height:30px;line-height:30x;float:left;color:red;display:none;font-weight:bold;" id="error_message"></div>
<?php
if(!$data_set_id){
	?>
	<div style="width:90px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="submit_analytical_survey_button" onclick="process_analytical_survey(<?php print($survey_id);?>);">Submit</div>
	
	<?php
}
?>
	
	<div style="width:90px;height:30px;background-color:#ddd;text-align:center;line-height:30px;cursor:pointer;float:left;" onmouseover="this.style.backgroundColor='#eee';;" onmouseout="this.style.backgroundColor='#ddd';" onclick="<?php if(!$data_set_id){?>var c = confirm('Are you sure you wish to exit this survey? All responses will not be saved');if(c){fetch_analytical_survey();}<?php }else{?> fetch_analytical_survey_responses() <?php }?>">Exit</div>
</div>
</div>

</div>


<script>
	function check_dependancy_validations(){
		var response_instruction_string = '<?php print($response_instruction_string);?>';
		var response_instruction_array = response_instruction_string.split(',');
		
		var question_lock = 0;
		for(var r =0;r<response_instruction_array.length;r++){
			var this_rule = response_instruction_array[r];
			var this_rule_array = this_rule.split(']');
			
			var target_question_id = this_rule_array[0];
			
			if(this_rule_array[1] != -1){			
				var source_session_id = $('#session_id_'+this_rule_array[1]).val();
				var source_question_id = $('#question_id_'+this_rule_array[1]+'_'+this_rule_array[2]).val();
				var source_option_id = $('#option_id_'+this_rule_array[1]+'_'+this_rule_array[2]+'_'+this_rule_array[3]).val();
				
				var option_checked = 0;
				
				if($('#question_option_type_'+source_question_id).val() == 0 || $('#question_option_type_'+source_question_id).val() == 1){
					
					if(document.getElementById('option_'+source_option_id).checked == true){
						option_checked = 1;
					}
					
				}else if($('#question_option_type_'+source_question_id).val() == 2 || $('#question_option_type_'+source_question_id).val() == 3){
					if($('#question_answer_'+source_question_id).val() != ''){
						option_checked = 1;
					}
				}
				
				if(option_checked && $('#qustion_holder_'+source_question_id).css('display') != 'none'){
					$('#qustion_holder_'+target_question_id).slideDown('fast');
					
					
				}else{
					$('#qustion_holder_'+target_question_id).slideUp('fast');
				}
			}
		}
	}
check_dependancy_validations();
</script>