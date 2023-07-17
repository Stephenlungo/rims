<script>
function change_set_column_at_question_level(question_id,new_status){
	var qustion_options = $('#question_options_'+question_id).val();
	
	var question_option_array = qustion_options.split(',');
	
	for(var q=0;q<question_option_array.length;q++){
		if(new_status==1){
			document.getElementById('screening_option_'+question_option_array[q]).disabled = true;
			document.getElementById('screening_option_'+question_option_array[q]).checked = true;
			
			if(!search_item_in_list('screening_rule_string',question_option_array[q],',')){
				add_to_selection(question_option_array[q],'screening_rule_string');
			}
			
			
			
		}else{
			document.getElementById('screening_option_'+question_option_array[q]).disabled = false;
			document.getElementById('screening_option_'+question_option_array[q]).checked = false;
			
			remove_from_selection(question_option_array[q],'screening_rule_string');
			
			
		}	
	}
	
	if(new_status == 1){
		if(!search_item_in_list('screening_question_level_rule_string',question_id,',')){
				add_to_selection(question_id,'screening_question_level_rule_string');
			}
			
			$('#options_all_'+question_id).slideUp('fast');
			document.getElementById('options_all_checkbox_'+question_id).checked = false;
			
	}else{
		remove_from_selection(question_id,'screening_question_level_rule_string');
		$('#options_all_'+question_id).slideDown('fast');
		
	}
}

function select_all_options(question_id,new_status){
	var question_options = $('#question_options_'+question_id).val();
	
	var question_option_array = question_options.split(',');
	
	for(var q=0;q<question_option_array.length;q++){
		if(new_status==1){
			document.getElementById('screening_option_'+question_option_array[q]).checked = true;
			
			if(!search_item_in_list('screening_rule_string',question_option_array[q],',')){
				add_to_selection(question_option_array[q],'screening_rule_string');
			}
			
			
			
		}else{
			document.getElementById('screening_option_'+question_option_array[q]).checked = false;
			
			remove_from_selection(question_option_array[q],'screening_rule_string');
			
			
		}	
	}
}

function change_set_column_at_category_level(form_id,category_id,new_status){
	var column_string = $('#column_string').val();
	var column_value_string = $('#column_value_string').val();
	
	var column_array = column_string.split(',');
	var column_value_array = column_value_string.split(',');
	
	
	var new_column_string = '';
	var new_value_string = '';
	for(var c = 0;c<column_array.length;c++){
		if(column_array[c] != category_id){
			if(new_column_string == ''){
				new_column_string = column_array[c];
				new_value_string = column_value_array[c];
			}else{
				new_column_string = new_column_string+','+column_array[c];
				new_value_string = new_value_string+','+column_value_array[c];
			}
		}
	}
	
	$('#column_string').val(new_column_string);
	$('#column_value_string').val(new_value_string);
	
	var category_options = $('#category_options_'+form_id+'_'+category_id).val();
	
	var category_option_array = category_options.split(',');
	
	if(new_status == 1){
		var formated_category_options = category_options.replace(/,/g,'-');
		add_to_selection(category_id,'column_string');
		add_to_selection(formated_category_options,'column_value_string');
		
		for(var o=0;o<category_option_array.length;o++){
			document.getElementById('dynamic_form_option_'+form_id+'_'+category_option_array[o]).disabled = true;
			document.getElementById('dynamic_form_option_'+form_id+'_'+category_option_array[o]).checked = true;
			
			if(!search_item_in_list('form_rule_string',category_option_array[o],',')){
				//alert('hey');
				add_to_selection(category_option_array[o],'form_rule_string');
			}
		}
		
		$('#category_all_'+category_id).slideUp('fast');
		
		document.getElementById('category_all_checkbox_'+category_id).checked = true;
		
		if(!search_item_in_list('form_category_level_rule_string',category_id,',')){
			add_to_selection(category_id,'form_category_level_rule_string');
		}
		
	}else{
		for(var o=0;o<category_option_array.length;o++){
			document.getElementById('dynamic_form_option_'+form_id+'_'+category_option_array[o]).disabled = false;
			document.getElementById('dynamic_form_option_'+form_id+'_'+category_option_array[o]).checked = false;
			
			if(search_item_in_list('form_rule_string',category_option_array[o],',')){
				remove_from_selection(category_option_array[o],'form_rule_string');
			}
		}
		$('#category_all_'+category_id).slideDown('fast');
		
		document.getElementById('category_all_checkbox_'+category_id).checked = false;
		
		remove_from_selection(category_id,'form_category_level_rule_string');
	}
	
	
}

function select_all_categories(form_id,category_id,new_status){
	var category_options = $('#category_options_'+form_id+'_'+category_id).val();
	
	var category_option_array = category_options.split(',');
	
	for(var c=0;c<category_option_array.length;c++){
		if(new_status==1){
			document.getElementById('dynamic_form_option_'+form_id+'_'+category_option_array[c]).checked = true;
			
			if(!search_item_in_list('column_value_string',category_option_array[c],',')){
				add_to_selection(category_option_array[c],'column_value_string');
				add_to_selection(category_id,'column_string');
			}
			
			if(!search_item_in_list('form_rule_string',category_option_array[c],',')){
				add_to_selection(category_option_array[c],'form_rule_string');
			}
			
		}else{
			if(search_item_in_list('form_rule_string',category_option_array[c],',')){
				remove_from_selection(category_option_array[c],'form_rule_string');
			}
			remove_from_value_selection(category_option_array[c],'column_value_string');
			document.getElementById('dynamic_form_option_'+form_id+'_'+category_option_array[c]).checked = false;
		}	
	}
}

function remove_from_value_selection(option_id,input_id){
	var column_string = $('#column_string').val();
	var column_array = column_string.split(',');
	
	var option_string = $('#'+input_id).val();
	
	var option_array = option_string.split(',');
	
	var new_string = '';
	var new_column_string = '';
	for(var o=0;o<option_array.length;o++){
		if(option_array[o] != option_id){
			if(new_string == ''){
				new_string = option_array[o];
				new_column_string = column_array[o];
			}else{
				new_string = new_string+','+option_array[o];
				new_column_string = new_column_string+','+column_array[o];
			}
		}
	}
	
	$('#'+input_id).val(new_string);
	
	$('#column_string').val(new_column_string);
}

</script>


<div style="width:100%;height:30px;line-height:30px;float:left;color:#006bb3;margin-bottom:10px;">Choose form fields to represent columns on your report from forms below:</div>


	<div style="width:auto;height:auto;float:left;">
		<div style="width:110px;height:30px;line-height:30px;float:left;">Data retrieval type:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
			<div class="option_item" title="Click to change option" onclick="$('#data_retrieval_menu').toggle('fast');" id="active_data_retrieval" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">All data</div>
			<div class="option_menu" id="data_retrieval_menu" style="display:none;width:auto;">
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_retrieval_menu').toggle('fast');$('#active_data_retrieval').html($(this).html());$('#selected_data_retrieval').val(0);">All data</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_retrieval_menu').toggle('fast');$('#active_data_retrieval').html($(this).html());$('#selected_data_retrieval').val(1);">Initial data</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_retrieval_menu').toggle('fast');$('#active_data_retrieval').html($(this).html());$('#selected_data_retrieval').val(2);">Recent data</div>
			</div>
		</div>
		<input type="hidden" id="selected_data_retrieval" value="0">
	</div>

<?php
$screenings = mysqli_query($connect,"select * from prep_questionnaires where module_id = $module_id")or die(mysqli_error($connect));

for($s=0;$s<mysqlI_num_rows($screenings);$s++){
	$screening_results = mysqli_fetch_array($screenings,MYSQLI_ASSOC);
	
	$form_status = '';
	if(!$screening_results['status']){
		$form_status = ' (Screening disabled)';
	}
	
	$this_screening_id = $screening_results['id'];
	?>
	<div style="cursor:pointer;width:99%;height:30px;line-height:30px;float:left;border-bottom:solid 1px #ddd;background-color:#eee;padding-left:5px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="$('#screening_holder_<?php print($screening_results['id']);?>').slideToggle('fast');"><?php print($screening_results['title'].$form_status);?></div>

	<div style="width:100%;height:auto;float:left;display:none;margin-bottom:10px;" id="screening_holder_<?php print($screening_results['id']);?>">
		<?php
		$screening_sessions = mysqli_query($connect,"select * from prep_questionnaire_sessions where questionnaire_id = $this_screening_id order by status desc, _order asc");
		
		for($ss=0;$ss<mysqli_num_rows($screening_sessions);$ss++){
			$screening_session_results = mysqli_fetch_array($screening_sessions,MYSQLI_ASSOC);
			$this_session_id = $screening_session_results['id'];
			
			$form_status = '';
			
			if(!$screening_session_results['status']){
				$form_status = ' (Session disabled)';
			}
			?>
			<div style="cursor:pointer;width:80%;margin-left:30px;height:25px;line-height:30px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#session_holder_<?php print($screening_session_results['id']);?>').slideToggle('fast');"><?php print($screening_session_results['title'].$form_status);?></div>
			
			<div style="width:80%;margin-left:30px;height:auto;line-height:25px;float:left;display:none;" id="session_holder_<?php print($screening_session_results['id']);?>">
			
			<?php
				$questions = mysqli_query($connect,"select * from prep_questions where session_id = $this_session_id order by status desc, _order asc")or die(mysqli_error($connect));
			
				for($q=0;$q<mysqli_num_rows($questions);$q++){
					$question_results = mysqli_fetch_array($questions,MYSQLI_ASSOC);
					
					$this_question_id = $question_results['id'];
					
					$form_status = '';
					
					if(!$question_results['status']){
						$form_status = ' (Question disabled)';
					}
					
					?>
					<div style="cursor:pointer;width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#question_holder_<?php print($question_results['id']);?>').slideToggle('fast');"><?php print($question_results['title'].$form_status);?></div>
					
					<?php
						$all_screening_checked = '';
						$all_screening_disabled = '';
						$all_button_hidden = '';
						if(check_item_in_list($question_results['id'],$screening_question_level_rule_string,0,',')){
							$all_screening_checked ='checked';
							
							$all_screening_disabled = 'disabled';
							$all_button_hidden = 'display:none;';
						}
					?>
					
					<div style="width:70%;margin-left:30px;height:auto;line-height:25px;float:left;display:none;" id="question_holder_<?php print($question_results['id']);?>">
					<div style="width:70%;height:25px;line-height:25px;float:left;background-color:#eef;margin-left:30px;"><input type="checkbox" id="column_at_question_<?php print($question_results['id']);?>" onchange="if(this.checked){change_set_column_at_question_level(<?php print($question_results['id']);?>,1);}else{change_set_column_at_question_level(<?php print($question_results['id']);?>,0);}" <?php print($all_screening_checked);?>><label for="column_at_question_<?php print($question_results['id']);?>">Set column at question level</label></div>
					
					<div style="width:70%;height:25px;line-height:25px;float:left;margin-left:36px;color:#006bb3;<?php print($all_button_hidden);?>" id="options_all_<?php print($question_results['id']);?>"><input type="checkbox" id="options_all_checkbox_<?php print($question_results['id']);?>"  onchange="if(this.checked){select_all_options(<?php print($question_results['id']);?>,1);}else{select_all_options(<?php print($question_results['id']);?>,0);}" ><label for="options_all_checkbox_<?php print($question_results['id']);?>"><i>Select all</i></label></div>
						<?php
							$options = mysqli_query($connect,"select * from prep_question_options where question_id = $this_question_id order by status desc, _order asc")or die(mysqli_error($connect));
							
							$this_option_string = '';
							for($o=0;$o<mysqli_num_rows($options);$o++){
								$option_results = mysqli_fetch_array($options,MYSQLI_ASSOC);
								
								if($this_option_string == ''){
									$this_option_string = $option_results['id'];
									
								}else{
									$this_option_string .= ','.$option_results['id'];
									
								}
								
								$form_status = '';
								
								if(!$option_results['status']){
									$form_status = ' (Option disabled)';
								}
								
							
								
								$option_checked = '';
								if(check_item_in_list($option_results['id'],$screening_rule_string,0,',')){
									$option_checked ='checked';
									
								}
								
								?>
								<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="screening_option_<?php print($option_results['id']);?>" <?php print($option_checked);?> onchange="if(this.checked){add_to_selection('<?php print($option_results['id']);?>','screening_rule_string');}else{remove_from_selection('<?php print($option_results['id']);?>','screening_rule_string');}" <?php print($all_screening_disabled);?>><label for="screening_option_<?php print($option_results['id']);?>"><?php print($option_results['title'].$form_status);?></label></div>
								
								<?php
							}
						
						?>
						<input type="hidden" id="question_options_<?php print($question_results['id']);?>" value="<?php print($this_option_string);?>">
						
						<?php if(!$report_id and $question_results['status']){
							?>
								<script>
									//$('#column_at_question_'+<?php print($question_results['id']);?>).click();
								</script>
							<?php
						}
						?>
					</div>
					
					<?php
				}
			?>
			
			</div>
			<?php
		}

		?>
	</div>
	<?php
}
?>


<div style="width:99%;height:30px;line-height:30px;float:left;border-bottom:solid 1px #ddd;background-color:#eee;padding-left:5px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="$('#dynamic_form_profile_holder').slideToggle('fast');">Profile</div>

<div style="width:100%;height:auto;float:left;display:none;margin-bottom:10px;" id="dynamic_form_profile_holder">

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_1" onchange="if(this.checked){add_to_selection('1','profile_rule_string');}else{remove_from_selection('1','profile_rule_string');}" <?php if(check_item_in_list(1,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_1">Date of entry</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_2" onchange="if(this.checked){add_to_selection('2','profile_rule_string');}else{remove_from_selection('2','profile_rule_string');}" <?php if(check_item_in_list(2,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_2">Time of entry</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_3" onchange="if(this.checked){add_to_selection('3','profile_rule_string');}else{remove_from_selection('3','profile_rule_string');}" <?php if(check_item_in_list(3,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_3">Account status (Shows if the client account on the system is disabled or enabled)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_4" onchange="if(this.checked){add_to_selection('4','profile_rule_string');}else{remove_from_selection('4','profile_rule_string');}" <?php if(check_item_in_list(4,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_4">PrEP ID (Unique identification number of client. Generated by the system on client initiation)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_5" onchange="if(this.checked){add_to_selection('5','profile_rule_string');}else{remove_from_selection('5','profile_rule_string');}" <?php if(check_item_in_list(5,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_5">Initiated/Not initiated (Shows if a client has ever been initiated, irrespective of client categorization)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_6" onchange="if(this.checked){add_to_selection('6','profile_rule_string');}else{remove_from_selection('6','profile_rule_string');}" <?php if(check_item_in_list(6,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_6">Non-successive Categorization (Shows client categorization in relation to the PrEP cascade)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_7" onchange="if(this.checked){add_to_selection('7','profile_rule_string');}else{remove_from_selection('7','profile_rule_string');}" <?php if(check_item_in_list(7,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_7">Name</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_8" onchange="if(this.checked){add_to_selection('8','profile_rule_string');}else{remove_from_selection('8','profile_rule_string');}" <?php if(check_item_in_list(8,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_8">Additional basic details (Phone, NRC)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_20" onchange="if(this.checked){add_to_selection('20','profile_rule_string');}else{remove_from_selection('20','profile_rule_string');}" <?php if(check_item_in_list(20,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_20">Additional basic details (Gender, Age)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_9" onchange="if(this.checked){add_to_selection('9','profile_rule_string');}else{remove_from_selection('9','profile_rule_string');}" <?php if(check_item_in_list(9,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_9">Population category (General, AGYW, DC, FSW etc)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_10" onchange="if(this.checked){add_to_selection('10','profile_rule_string');}else{remove_from_selection('10','profile_rule_string');}" <?php if(check_item_in_list(10,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_10">Agent (CHW responsible)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_11" onchange="if(this.checked){add_to_selection('11','profile_rule_string');}else{remove_from_selection('11','profile_rule_string');}" <?php if(check_item_in_list(11,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_11">User (Service provider who entered the record)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_12" onchange="if(this.checked){add_to_selection('12','profile_rule_string');}else{remove_from_selection('12','profile_rule_string');}" <?php if(check_item_in_list(12,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_12">Implementing Partner</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_13" onchange="if(this.checked){add_to_selection('13','profile_rule_string');}else{remove_from_selection('13','profile_rule_string');}" <?php if(check_item_in_list(13,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_13">Source of Knowledge </label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_14" onchange="if(this.checked){add_to_selection('14','profile_rule_string');}else{remove_from_selection('14','profile_rule_string');}" <?php if(check_item_in_list(14,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_14">Inter-Departmental Referral</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_15" onchange="if(this.checked){add_to_selection('15','profile_rule_string');}else{remove_from_selection('15','profile_rule_string');}" <?php if(check_item_in_list(15,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_15">Location (Region, Province, Hub and Site of client)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_16" onchange="if(this.checked){add_to_selection('16','profile_rule_string');if(document.getElementById('dynamic_form_option_3_221').checked == false){$('#dynamic_form_option_3_221').click();}if(document.getElementById('dynamic_form_option_1_319').checked == false){$('#dynamic_form_option_1_319').click();}}else{remove_from_selection('16','profile_rule_string');}" <?php if(check_item_in_list(16,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_16">Client Status (Active, Missed appointment or Inactive)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_17" onchange="if(this.checked){add_to_selection('17','profile_rule_string');}else{remove_from_selection('17','profile_rule_string');}" <?php if(check_item_in_list(17,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_17">Clinical visit dates (All dates the client visited the facility)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_19" onchange="if(this.checked){add_to_selection('19','profile_rule_string');}else{remove_from_selection('19','profile_rule_string');}" <?php if(check_item_in_list(19,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_19">System - computed last visit date (Show system - computed last visit date and not one entered on forms)</label></div>

<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_18" onchange="if(this.checked){add_to_selection('18','profile_rule_string');}else{remove_from_selection('18','profile_rule_string');}" <?php if(check_item_in_list(18,$profile_rule_string,0,',')){print(' checked ');}?>><label for="dynamic_form_option_18">Duplicate formula (Microsoft Office Excel formula for identifying entry duplicates)</label></div>

</div>


<?php
$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id and module_id = $module_id order by status desc, _order asc")or die(mysqli_error($connect));

for($d=0;$d<mysqli_num_rows($dynamic_forms);$d++){
	$dynamic_form_results = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
	
	$form_status = '';
	if(!$dynamic_form_results['status']){
		$form_status = ' (Form disabled)';
	}
	
	$this_dynamic_form_id = $dynamic_form_results['id'];
	?>
	<div style="cursor:pointer;width:99%;height:30px;line-height:30px;float:left;border-bottom:solid 1px #ddd;background-color:#eee;padding-left:5px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="$('#dynamic_form_holder_<?php print($dynamic_form_results['id']);?>').slideToggle('fast');"><?php print($dynamic_form_results['form_title'].$form_status);?></div>

	<div style="width:100%;height:auto;float:left;display:none;margin-bottom:10px;" id="dynamic_form_holder_<?php print($dynamic_form_results['id']);?>">
		<?php
		$dynamic_form_categories = mysqli_query($connect,"select * from dynamic_form_categories where dynamic_form_id = $this_dynamic_form_id order by status desc, _order asc");
		
		
		for($c=0;$c<mysqli_num_rows($dynamic_form_categories);$c++){
			
			$dynamic_form_category_results = mysqli_fetch_array($dynamic_form_categories,MYSQLI_ASSOC);
			$this_dynamic_form_category_id = $dynamic_form_category_results['id'];
			
			$form_status = '';
			
			if(!$dynamic_form_category_results['status']){
				$form_status = ' (category disabled)';
			}
			
			
			
			?>
			<div style="cursor:pointer;width:80%;margin-left:30px;height:25px;line-height:30px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#dynamic_form_category_holder_<?php print($dynamic_form_category_results['id']);?>').slideToggle('fast');"><?php print($dynamic_form_category_results['title'].$form_status);?></div>
			
			
			
			<div style="width:80%;margin-left:30px;height:auto;line-height:25px;float:left;display:none;" id="dynamic_form_category_holder_<?php print($dynamic_form_category_results['id']);?>">
			
			<?php
				$all_form_checked = '';
				$all_button_hidden = '';
				$all_form_disabled = '';
				if(check_item_in_list($this_dynamic_form_category_id,$form_category_level_rule_string,0,',')){
					$all_form_checked ='checked';
					
					$all_form_disabled = 'disabled';
					$all_button_hidden = 'display:none';
				}
			?>
			
			<div style="width:80%;height:25px;line-height:25px;float:left;background-color:#eef;margin-left:30px;"><input type="checkbox" id="column_at_category_<?php print($this_dynamic_form_category_id);?>" onchange="if(this.checked){change_set_column_at_category_level(<?php print($this_dynamic_form_id.','.$this_dynamic_form_category_id);?>,1);}else{change_set_column_at_category_level(<?php print($this_dynamic_form_id.','.$this_dynamic_form_category_id);?>,0);}" <?php print($all_form_checked);?>><label for="column_at_category_<?php print($this_dynamic_form_category_id);?>">Set column at category level</label></div>
			
			<div style="width:70%;height:25px;line-height:25px;float:left;margin-left:36px;color:#006bb3;<?php print($all_button_hidden);?>" id="category_all_<?php print($this_dynamic_form_category_id);?>"><input type="checkbox" id="category_all_checkbox_<?php print($this_dynamic_form_category_id);?>"  onchange="if(this.checked){select_all_categories(<?php print($this_dynamic_form_id.','.$this_dynamic_form_category_id);?>,1);}else{select_all_categories(<?php print($this_dynamic_form_id.','.$this_dynamic_form_category_id);?>,0);}"><label for="category_all_checkbox_<?php print($this_dynamic_form_category_id);?>"><i>Select all</i></label></div>
			
			<?php
				
				$options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_category_id = $this_dynamic_form_category_id order by status desc, _order asc")or die(mysqli_error($connect));
				
				$this_category_string = '';
				$contains_bullet = 0;
				for($o=0;$o<mysqli_num_rows($options);$o++){
					$option_results = mysqli_fetch_array($options,MYSQLI_ASSOC);
					
					if(!$option_results['option_type']){
						$contains_bullet = 1;
						
					}
					
					$form_status = '';
					
					if(!$option_results['status']){
						$form_status = ' (Option disabled)';
					}
					
					//print($screening_rule_string);
					$option_checked = '';
					if(check_item_in_list($option_results['id'],$form_rule_string,0,',')){
						$option_checked ='checked';
						
					}
					
					if($this_category_string == ''){
						$this_category_string = $option_results['id'];
						
					}else{
						$this_category_string .= ','.$option_results['id'];
						
					}
					
					?>
					<div style="width:90%;margin-left:30px;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;padding-left:5px;"><input type="checkbox" id="dynamic_form_option_<?php print($this_dynamic_form_id.'_'.$option_results['id']);?>" <?php print($option_checked);?> onchange="if(this.checked){add_to_selection('<?php print($option_results['id']);?>','column_value_string');add_to_selection('<?php print($this_dynamic_form_category_id);?>','column_string');add_to_selection('<?php print($option_results['id']);?>','form_rule_string');}else{remove_from_value_selection('<?php print($option_results['id']);?>','column_value_string');remove_from_selection('<?php print($option_results['id']);?>','form_rule_string');}" <?php print($all_form_disabled);?>><label for="dynamic_form_option_<?php print($this_dynamic_form_id.'_'.$option_results['id']);?>"><?php print($option_results['category_title'].$form_status);?></label></div>
					
					<?php
				}
			
			?>
			</div><input type="hidden" id="category_options_<?php print($this_dynamic_form_id.'_'.$this_dynamic_form_category_id);?>" value="<?php print($this_category_string);?>">
			<?php
			
			
			if(!$report_id and $contains_bullet){
			?>
			<script>
				//$('#column_at_category_'+<?php print($this_dynamic_form_category_id);?>).click();
			</script>
			<?php
			}
			
			
		}
			?>

			
			
	</div>	
	<?php
}

$button_text = 'Save';
if($report_id){
	$button_text = 'Update';
}

?>


<div style="margin-top:20px;width:100%;height:auto;float:left;">
<div style="width:120px;height:30px;background-color:green;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#1f981f';" onmouseout="this.style.backgroundColor='green';"  id="process_prep_report_button" onclick="process_prep_report();" title="Click to update account details">Process report</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_profile_button" onclick="save_prep_custom_report(<?php print($report_id);?>)" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($report_id){
	$this_report = mysqli_query($connect,"select * from dynamic_reports where id = $report_id")or die(mysqli_error($connect));
	$this_report_results = mysqli_fetch_array($this_report,MYSQLI_ASSOC);
	
	if($user_results['_date'] == $this_report_results['user_date'] || $active_user_roles[7]){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#c93f3f';" onmouseout="this.style.backgroundColor='brown';"  id="delete_custom_report_button" onclick="delete_prep_report(<?php print($report_id);?>);" title="Click to change account status">Delete</div>
<?php
	}
}
?>
</div>