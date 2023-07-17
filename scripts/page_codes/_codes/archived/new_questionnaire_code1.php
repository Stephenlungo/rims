<?php
if($questionnaire_id){
	$button_text = 'Update';
	$default_txt_color = '#000';
	
	$this_questionnaire = mysqli_query($connect,"select * from prep_questionnaires where id = $questionnaire_id")or die(mysqli_error($connect));
	$this_questionnaire_results = mysqli_fetch_array($this_questionnaire,MYSQLI_ASSOC);
	
	$questionnaire_title = $this_questionnaire_results['title'];
	$questionnaire_branch_id = $this_questionnaire_results['branch_id'];
	
	$questionnaire_client_identity = $this_questionnaire_results['client_identity'];
	if($questionnaire_client_identity){
		$client_identity_text = 'Request';
		
	}else{
		$client_identity_text = 'Ignore';
		
	}
	
	$questionnaire_description = $this_questionnaire_results['description'];
	
	$sessions = mysqli_query($connect,"select * from prep_questionnaire_sessions where questionnaire_id = $questionnaire_id order by _order")or die(mysqlI_error($connect));
	
	$removed_sessions = '';
	$session_string = '<div style="width:100%;height:auto;float:left;margin-bottom:5px;">';
	for($s=0;$s<mysqli_num_rows($sessions);$s++){
		$session_results = mysqli_fetch_array($sessions,MYSQLI_ASSOC);
		
		$this_session_id = $session_results['id'];
		
		if($session_results['status']){
			$session_disabled_status = ' ';

		}else{
			$session_disabled_status = ' disabled ';
			
			if($removed_sessions === ''){
				$removed_sessions = $s;
				
			}else{
				$removed_sessions .= ','.$s;
			}			
		}
		
		$session_string .= '<div style="cursor:pointer;width:100%;height:30px;line-height:30px;;float:left;background-color:#eef;font-weight:bold;margin-bottom:5px;" onclick="$(\'#session_'.$s.'_holder\').slideToggle(\'fast\');" id="session_title_'.$s.'">Session '.($s+1).'</div><div style="width:100%;height:auto;float;left;" id="session_'.$s.'_holder"><div style="width:100%;height:auto;float:left;margin-bottom:5px;"><div style="width:80px;height:30px;line-height:30px;float:left;" title="Double click to remove/add item" ondblclick="remove_group(\'_'.$s.'\');">Session title:</div><div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="session_item_title_'.$s.'" style="border:solid 1px #aaa;width:100%;height:30px;color:'.$default_txt_color.';" value="'.$session_results['title'].'" onfocus="if(this.value==\'Enter title here\'){this.value=\'\';this.style.color=\'#000\';this.style.borderColor=\'#aaa\';}$(\'#new_questionnaire_group_error_message\').fadeOut(\'fast\');" onfocusout="if(this.value==\'\'){this.value=\''.$session_results['title'].'\';this.style.color=\''.$default_txt_color.'\';}" '.$session_disabled_status.'></div></div><div style="width:100%;height:auto;float:left;margin-bottom:5px;"><div style="width:80px;height:30px;line-height:30px;float:left;">Ordering:</div><div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="group_order_'.$s.'" style="border:solid 1px #aaa;width:100%;height:30px;" value="'.$session_results['_order'].'" onfocusout="if(this.value==\'\'){this.value=\''.$session_results['_order'].'\';}" '.$session_disabled_status.'></div></div><input type="hidden" id="session_id_'.$s.'" value="'.$this_session_id.'">';
		
		$questions = mysqli_query($connect,"select * from prep_questions where session_id = $this_session_id")or die(mysqli_error($connect));
		
		$session_string .= '<div style="width:92%;height:auto;float:right;"><div style="width:100%;height:25px;line-height:25px;background-color:#eee;float:left;margin-top:20px;font-weight:bold;">Questions</div><div style="width:100%;height:auto;float:left;" id="questions_holder_'.$s.'">';
		
		$removed_questions ='';
		for($q=0;$q<mysqli_num_rows($questions);$q++){
			$question_results = mysqli_fetch_array($questions,MYSQLI_ASSOC);
			
			if($question_results['status']){
				$question_disabled_status = ' ';
				
			}else{
				$question_disabled_status = ' disabled ';
				
				if($removed_questions === ''){
					$removed_questions = $q;
					
				}else{
					$removed_questions .= ','.$q;
				}
				
			}
			
			$this_question_id = $question_results['id'];
			
			if($question_results['mandatory'] == 1){
				$mandatory_check = 'checked';
				
			}else{
				$mandatory_check = ' ';
				
			}
			
			$session_string .= '<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;" id="question_'.$s.'_holder"><div style="width:100px;height:30px;line-height:30px;float:left;" title="Double click to remove/add item" ondblclick="remove_question(\'_'.$s.'\',\'_'.$q.'\');">Question '.($q+1).' ('.$question_results['id'].'):</div><div style="width:350px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="question_'.$s.'_'.$q.'" style="border:solid 1px #aaa;width:100%;height:30px;color:'.$default_txt_color.';" value="'.$question_results['title'].'" onfocus="if(this.value==\'Enter question here\'){this.value=\'\';this.style.color=\'#000\';}this.style.borderColor=\'#aaa\';" onfocusout="if(this.value==\'\'){this.value=\''.$question_results['title'].'\';this.style.color=\'#aaa\';}" '.$question_disabled_status.'></div><div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:10px;">Type:</div><div style="width:auto;;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#option_type_menu_'.$s.'_'.$q.'\').toggle(\'fast\');" id="active_option_type_'.$s.'_'.$q.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:78px;max-width:78px;width:auto;">Bullet</div><div class="option_menu" id="option_type_menu_'.$s.'_'.$q.'" style="display:none;min-width:80px;max-width:280px;width:auto;"><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$s.'_'.$q.'\').toggle(\'fast\');$(\'#active_option_type_'.$s.'_'.$q.'\').html($(this).html());$(\'#selected_option_type_'.$s.'_'.$q.'\').val(0);">Bullet</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$s.'_'.$q.'\').toggle(\'fast\');$(\'#active_option_type_'.$s.'_'.$q.'\').html($(this).html());$(\'#selected_option_type_'.$s.'_'.$q.'\').val(1);">Check-box</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$s.'_'.$q.'\').toggle(\'fast\');$(\'#active_option_type_'.$s.'_'.$q.'\').html($(this).html());$(\'#selected_option_type_'.$s.'_'.$q.'\').val(2);">Text</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#option_type_menu_'.$s.'_'.$q.'\').toggle(\'fast\');$(\'#active_option_type_'.$s.'_'.$q.'\').html($(this).html());$(\'#selected_option_type_'.$s.'_'.$q.'\').val(3);">Date</div></div><input type="hidden" id="selected_option_type_'.$s.'_'.$q.'" value="'.$question_results['option_type'].'"><div style="width:55px;height:30px;line-height:30px;float:left;margin-left:10px;">Ordering:</div><div style="width:60px;min-height:30px;height:auto;float:left;"><input type="text" id="question_order_'.$s.'_'.$q.'" style="border:solid 1px #aaa;width:100%;height:25px;margin-top:2px;" value="'.$question_results['_order'].'" onfocusout="if(this.value==\'\' || isNaN(this.value)){this.value=\''.$question_results['_order'].'\';}" ></div><div style="width:auto;margin-left:5px;height:30px;float:left;line-height:30px;border-bottom:solid 1px #eee;"><input type="checkbox" id="field_mandatory_'.$s.'_'.$q.'" '.$mandatory_check.' onchange="if(this.checked){$(\'#question_mandatory_'.$s.'_'.$q.').val(1);}else{$(\'#question_mandatory_'.$s.'_'.$q.'\').val(0);}"><label for="field_mandatory_'.$s.'_'.$q.'">Mandatory</label></div></div><input type="hidden" id="question_mandatory_'.$s.'_'.$q.'" value="'.$question_results['mandatory'].'"><input type="hidden" id="question_id_'.$s.'_'.$q.'" value="'.$question_results['id'].'">';
			
			
			$session_string .= '<div style="width:100%;height:auto;float:left;" id="qustion_options_'.$s.'_'.$q.'">';
			
			$question_options = mysqli_query($connect,"select * from prep_question_options where question_id = $this_question_id")or die(mysqli_error($connect));
			
			$removed_question_options = '';
			for($o=0;$o<mysqli_num_rows($question_options);$o++){				
				$question_option_results = mysqli_fetch_array($question_options,MYSQLI_ASSOC);
				
				if($o == mysqli_num_rows($question_options) -1){
					$option_display = '';
					
				}else{
					$option_display = 'none';
					
				}
				
				if($question_option_results['status']){
					$option_disabled_status = ' ';
					
				}else{
					$option_disabled_status = ' disabled ';
					
					if($removed_question_options === ''){
						$removed_question_options = $o;
						
					}else{
						$removed_question_options .= ','.$o;
						
					}					
				}
				
				$session_string .= '<div style="width:100%;height:auto;float:left;margin-top:5px;" id="question_option_'.$s.'_'.$q.'_'.$o.'"><div style="width:100px;height:30px;line-height:30px;float:left;" ondblclick="remove_option(\'_'.$s.'\',\'_'.$q.'\',\'_'.$o.'\');" title="Double click to remove/add item" id="option_title_'.$s.'_'.$q.'_'.$o.'">Option '.($o+1).' ('.$question_option_results['id'].'):</div><div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="option_'.$s.'_'.$q.'_'.$o.'" style="border:solid 1px #aaa;width:100%;height:25px;color:'.$default_txt_color.';margin-top:2px;" value="'.$question_option_results['title'].'" onfocus="if(this.value==\'Enter option here\'){this.value=\'\';this.style.color=\'#000\';this.style.borderColor=\'#aaa\';}" onfocusout="if(this.value==\'\'){this.value=\''.$question_option_results['title'].'\';this.style.color=\''.$default_txt_color.'\';}" '.$option_disabled_status.'></div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">Ordering:</div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:2px;"><input type="text" style="width:100%;height:25px;margin-top:2px;" value="'.$question_option_results['_order'].'" onfocusout="if(this.value==\'\' || isNaN(this.value)){this.value='.$question_option_results['_order'].';}" id="option_order_'.$s.'_'.$q.'_'.$o.'"></div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">Score:</div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:2px;"><input type="text" style="width:100%;height:25px;margin-top:2px;" value="'.$question_option_results['score'].'" onfocusout="if(this.value==\'\' || isNaN(this.value)){this.value='.$question_option_results['score'].';}" id="option_value_'.$s.'_'.$q.'_'.$o.'" '.$option_disabled_status.'></div><div style="display:'.$option_display.';width:30px;height:25px;float:left;text-align:center;line-height:25px;background-color:#dfd;cursor:pointer;margin-left:2px;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor=\'#cfc\';" onmouseout="this.style.backgroundColor=\'#dfd\'" title="Click to add option" id="add_question_option_button_'.$s.'_'.$q.'_'.$o.'" onclick="add_question_option(\'_'.$s.'\',\'_'.$q.'\')">+</div><input type="hidden" id="option_id_'.$s.'_'.$q.'_'.$o.'" value="'.$question_option_results['id'].'"></div>';
			}
			if($question_results['response_instruction'] != ''){
				$response_instruction = explode(']',$question_results['response_instruction']);
				$dependancy_display = '';
			
			}else{
				$response_instruction = array('-1','-1','-1');
				$dependancy_display = 'display:none;none';
			}
			
			if($response_instruction[0] == -1){
				$dependancy_session_title = 'None';
				
			}else{
				$dependancy_session_title = 'Session '.($response_instruction[0]+1);
				
			}
			
			if($response_instruction[1] == -1){
				$dependancy_question_title = 'None';
				
			}else{
				$dependancy_question_title = 'Question '.($response_instruction[1]+1);
				
			}
			
			if($response_instruction[2] == -1){
				$dependancy_option_title = 'None';
				
			}else{
				$dependancy_option_title = 'Option '.($response_instruction[2]+1);
				
			}
			
			
			$session_string .= '<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#f6f6ff;text-align:center;color:#777;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#f2f2ff\';" onmouseout="this.style.backgroundColor=\'#f6f6ff\'" title="Click to view options" onclick="$(\'#question_advanced_options_'.$s.'_'.$q.'\').slideToggle(\'fast\');fetch_questionnaire_ession(\'_'.$s.'\',\'_'.$q.'\')">Advanced question options</div><div style="width:100%;height:30px;float:left;border:solid 1px #f6f6ff;'.$dependancy_display.'" id="question_advanced_options_'.$s.'_'.$q.'"><div style="width:100%;height:30px;float:left;line-height:30px;border-bottom:solid 1px #eee;"><div style="width:90px;height:30px;line-height:30px;float:left;margin-left:10px;color:#006bb3;">Dependency:</div><div style="width:55px;height:30px;line-height:30px;float:left;margin-left:10px;">Session:</div><div style="width:auto;;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#question_dependency_ession_menu_'.$s.'_'.$q.'\').toggle(\'fast\');" id="active_question_dependency_ession_'.$s.'_'.$q.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:78px;max-width:100px;width:auto;">'.$dependancy_session_title.'</div><div class="option_menu" id="question_dependency_ession_menu_'.$s.'_'.$q.'" style="display:none;min-width:80px;max-width:280px;width:auto;"></div><input type="hidden" id="selected_question_dependency_ession_'.$s.'_'.$q.'" value="'.$response_instruction[0].'"></div><div style="width:60px;height:30px;line-height:30px;float:left;margin-left:10px;">Question:</div><div style="width:auto;;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#option_question_dependency_question_menu_'.$s.'_'.$q.'\').toggle(\'fast\');" id="active_question_dependency_question_'.$s.'_'.$q.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:78px;max-width:100px;width:auto;">'.$dependancy_question_title.'</div><div class="option_menu" id="option_question_dependency_question_menu_'.$s.'_'.$q.'" style="display:none;min-width:80px;max-width:280px;width:auto;"></div><input type="hidden" id="selected_question_dependency_question_'.$s.'_'.$q.'" value="'.$response_instruction[1].'"></div><div style="width:45px;height:30px;line-height:30px;float:left;margin-left:10px;">Option:</div><div style="width:auto;;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#option_question_dependency_option_menu_'.$s.'_'.$q.'\').toggle(\'fast\');" id="active_question_dependency_option_'.$s.'_'.$q.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:78px;max-width:100px;width:auto;">'.$dependancy_option_title.'</div><div class="option_menu" id="option_question_dependency_option_menu_'.$s.'_'.$q.'" style="display:none;min-width:80px;max-width:280px;width:auto;"></div><input type="hidden" id="selected_question_dependency_option_'.$s.'_'.$q.'" value="'.$response_instruction[2].'"></div></div></div></div>';
			
			$session_string .= '<input type="hidden" id="total_question_options_'.$s.'_'.$q.'" value="'.mysqli_num_rows($question_options).'"><input type="hidden" id="removed_question_options_'.$s.'_'.$q.'" value="'.$removed_question_options.'"></div><input type="hidden" id="total_question_options_'.$s.'_'.$q.'" value="'.mysqli_num_rows($question_options).'"><input type="hidden" id="removed_question_options_'.$s.'_'.$q.'" value="">';
			
		}
		
		$session_string .= '</div><input type="hidden" id="total_questions_'.$s.'" value="'.mysqli_num_rows($questions).'"><input type="hidden" id="removed_questions_'.$s.'" value="'.$removed_questions.'"><div style="width:100%;height:30px;float:left;margin-top:5px;"><div style="width:100px;height:30px;line-height:30px;text-align:center;float:left;background-color:#eee;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" onclick="add_question(\'_'.$s.'\');">Add question</div></div></div></div>';
	}
	
	$session_string .= '</div>';
	
	$total_sessions = mysqli_num_rows($sessions);
	
	
	
	if($module_id != 4){
		$wifi_id = 0;
		$wifi_title = 'Select WI-FI';
		
	}else{
		$wifi_id = $this_questionnaire_results['wifi_id'];
		$this_wifi = mysqli_query($connect,"select * from wifis where id = $wifi_id")or die(mysqlI_error($connect));
		$this_wifi_results = mysqli_fetch_array($this_wifi,MYSQLI_ASSOC);
		
		$wifi_title = $this_wifi_results['title'];
	}
	
}else{
	$button_text = 'Create';
	$questionnaire_title = 'Enter title here';
	$default_txt_color = '#aaa';
	
	$questionnaire_branch_id = $branch_id;
	
	$questionnaire_client_identity = 0;
	$client_identity_text = 'Ignore';
	
	$questionnaire_description = 'Enter some details here';
	
	$session_string = '';
	$removed_sessions = '';
	
	$total_sessions = 0;
	
	$wifi_title = 'Select WI-FI';
	$wifi_id = 0;
}
?>



<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">


<div style="width:100%;height:auto;float:left;margin-bottom:30px;border-bottom:solid 1px #eee;" >
<div style="width:80px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="questionnaire_title" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_txt_color);?>;" value="<?php print($questionnaire_title);?>" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_questionnaire_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='<?php print($questionnaire_title);?>';this.style.color='<?php print($default_txt_color);?>';}"></div>

<div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">Cluster:</div>

<?php
if($questionnaire_branch_id == 0){
	$branch_title = '<i>Non-clustered</i>';
	
}else{
	$branch_query = mysqli_query($connect,"select * from branches where id = $questionnaire_branch_id")or die(mysqli_error($connect));
	$branch_query_results = mysqli_fetch_array($branch_query,MYSQLI_ASSOC);
	
	$branch_title = $branch_query_results['title'];
}
?>
<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#branch_menu').toggle('fast');" id="active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;"><?php print($branch_title);?></div>


<div class="option_menu" id="branch_menu" style="display:none;">
<?php if($branch_id == 0){?>
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#questionnaire_branch_id').val(0);" ><i>Non-clustered</i></div>


<?php
$branches = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));

for($b=0;$b<mysqli_num_rows($branches);$b++){
	$branches_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);

	?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#questionnaire_branch_id').val(<?php print($branches_results['id']);?>);" ><?php print($branches_results['title']);?></div>
	<?php
}
}
?>
</div>
</div>
<input type="hidden" id="questionnaire_branch_id" value="<?php print($questionnaire_branch_id);?>">




<div style="width:90px;height:30px;line-height:30px;float:left;margin-left:5px;">Client identity:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_error_message').hide('fast');">
<div class="option_item" title="Click to change option" onclick="$('#client_identity_menu').toggle('fast');" id="active_slient_identity" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;"><?php print($client_identity_text);?></div>


<div class="option_menu" id="client_identity_menu" style="display:none;">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_identity_menu').toggle('fast');$('#active_slient_identity').html($(this).html());$('#new_slient_identity').val(1);" >Request</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_identity_menu').toggle('fast');$('#active_slient_identity').html($(this).html());$('#new_slient_identity').val(0);" >Ignore</div>

</div>
</div>
<input type="hidden" id="new_slient_identity" value="<?php print($questionnaire_client_identity);?>">




<div style="width:50px;height:30px;line-height:30px;float:left;">Image:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_error_message').hide('fast');">

<div class="option_item" title="Click to change option" id="active_uploaded_image" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;" onclick="open_uploader('upload_questionnaire_image()',0)">Select image</div>
</div>
<input type="hidden" id="questionnaire_image" value="">


<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:80px;height:30px;line-height:30px;float:left;">Description:</div>
<div style="width:600px;min-height:30px;height:auto;float:left;line-height:30px;color:#aaa;">

<input type="text" id="new_questionnaire_description" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_txt_color);?>;" onfocus="if(this.value=='Enter some details here'){this.value='';this.style.color='#000';}$('#new_questionnaire_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='<?php print($questionnaire_description);?>';this.style.color='<?php print($default_txt_color);?>';}" value="<?php print($questionnaire_description);?>"></div>


<div style="width:auto;height:auto;float:left;display:none;" id="questionnaire_wifi_holder">
<div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">WI-FI:</div>

<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#wifi_menu').toggle('fast');" id="active_wifi" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;"><?php print($wifi_title);?></div>


<div class="option_menu" id="wifi_menu" style="display:none;">

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}

$wifis = mysqli_query($connect,"select * from wifis where company_id = $company_id $branch_search order by title")or die(mysqli_error($connect));

for($b=0;$b<mysqli_num_rows($wifis);$b++){
	$wifi_results = mysqli_fetch_array($wifis,MYSQLI_ASSOC);

	?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#wifi_menu').toggle('fast');$('#active_wifi').html($(this).html());$('#wifi_id').val(<?php print($wifi_results['id']);?>);" ><?php print($wifi_results['title']);?></div>
	<?php
}
?>
</div>
</div>
<input type="hidden" id="wifi_id" value="<?php print($wifi_id);?>">
</div>
</div>






<div style="width:92.5%;float:right;height:auto;" id="sessions_holder">
<?php print($session_string);?>
</div>
<input type="hidden" id="total_sessions" value="<?php print($total_sessions);?>">
<input type="hidden" id="removed_sessions" value="<?php print($removed_sessions);?>">
<div style="width:92.5%;height:30px;float:right;margin-top:5px;"><div style="width:100px;height:30px;line-height:30px;text-align:center;float:left;background-color:#ddf;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';" onclick="add_session();">Add session</div></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:left;display:none;" id="new_questionnaire_error_message">Information here</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_questionnaire_button" onclick="create_or_edit_questionnaire(<?php print($questionnaire_id);?>);"><?php print($button_text);?></div>

<?php
if($questionnaire_id){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#b65353';" onmouseout="this.style.backgroundColor='brown';"  id="delete_questionnaire_button" onclick="delete_questionnaire(<?php print($questionnaire_id);?>);">Delete</div>
<?php
}
?>

</div>

<div style="width:92.5%;float:right;height:auto;display:none;" id="default_sessions_holder">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="cursor:pointer;width:100%;height:30px;line-height:30px;;float:left;background-color:#eef;font-weight:bold;margin-bottom:5px;" onclick="$('#session_s_holder').slideToggle('fast');" id="session_title_s">Session 1</div>
<div style="width:100%;height:auto;float;left;" id="session_s_holder">
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:80px;height:30px;line-height:30px;float:left;" title="Double click to remove/add item" ondblclick="remove_group('_s');">Session title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="session_item_title_s" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_questionnaire_group_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:80px;height:30px;line-height:30px;float:left;">Ordering:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="group_order_s" style="border:solid 1px #aaa;width:100%;height:30px;" value="1" onfocusout="if(this.value==''){this.value='1';}"></div>
</div>

<input type="hidden" id="session_id_s" value="0">


<div style="width:92%;height:auto;float:right;">
<div style="width:100%;height:25px;line-height:25px;background-color:#eee;float:left;margin-top:20px;font-weight:bold;">Questions</div>
<div style="width:100%;height:auto;float:left;" id="questions_holder_s">
<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;" id="question_s_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;" title="Double click to remove/add item" ondblclick="remove_question('_s','_qq');">Question 1:</div>
<div style="width:350px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="question_s_qq" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter question here" onfocus="if(this.value=='Enter question here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter question here';this.style.color='#aaa';}"></div> 

<div style="width:40px;height:30px;line-height:30px;float:left;margin-left:10px;">Type:</div>
	<div style="width:auto;;min-height:30px;height:auto;float:left;">

	<div class="option_item" title="Click to change option" onclick="$('#option_type_menu_s_qq').toggle('fast');" id="active_option_type_s_qq" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:78px;max-width:100px;width:auto;">Bullet</div>

	<div class="option_menu" id="option_type_menu_s_qq" style="display:none;min-width:80px;max-width:280px;width:auto;">		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_s_qq').toggle('fast');$('#active_option_type_s_qq').html($(this).html());$('#selected_option_type_s_qq').val(0);">Bullet</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_s_qq').toggle('fast');$('#active_option_type_s_qq').html($(this).html());$('#selected_option_type_s_qq').val(1);">Check-box</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_s_qq').toggle('fast');$('#active_option_type_s_qq').html($(this).html());$('#selected_option_type_s_qq').val(2);">Text</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_s_qq').toggle('fast');$('#active_option_type_s_qq').html($(this).html());$('#selected_option_type_s_qq').val(3);">Date</div>
	</div>
	
	<input type="hidden" id="selected_option_type_s_qq" value="0">
	<div style="width:55px;height:30px;line-height:30px;float:left;margin-left:10px;">Ordering:</div>
	<div style="width:60px;min-height:30px;height:auto;float:left;"><input type="text" id="question_order_s_qq" style="border:solid 1px #aaa;width:100%;height:25px;margin-top:2px;" value="1" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='1';this.style.color='#aaa';}" ></div><div style="width:auto;margin-left:5px;height:30px;float:left;line-height:30px;border-bottom:solid 1px #eee;"><input type="checkbox" id="field_mandatory_s_qq" onchange="if(this.checked){$('#question_mandatory_s_qq').val(1);}else{$('#question_mandatory_s_qq').val(0);}"><label for="field_mandatory_s_qq">Mandatory</label></div>
	</div>
	<input type="hidden" id="question_mandatory_s_qq" value="0">
	<input type="hidden" id="question_id_s_qq" value="0">

	<div style="width:100%;height:auto;float:left;" id="qustion_options_s_qq">
	
	<div style="width:100%;height:auto;float:left;margin-top:5px;" id="question_option_s_qq_0">
<div style="width:100px;height:30px;line-height:30px;float:left;" ondblclick="remove_option('_s','_qq','_o');" title="Double click to remove/add item" id="option_title_s_qq_0">Option 1:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="option_s_qq_0" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;margin-top:2px;" value="Enter option here" onfocus="if(this.value=='Enter option here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}" onfocusout="if(this.value==''){this.value='Enter option here';this.style.color='#aaa';}" ></div> <div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">Ordering:</div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:2px;"><input type="text" style="width:100%;height:25px;margin-top:2px;" value="1" onfocusout="if(this.value=='' || isNaN(this.value)){this.value=1;}" id="option_order_s_qq_0"></div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">Score:</div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:2px;"><input type="text" style="width:100%;height:25px;margin-top:2px;" value="1" onfocusout="if(this.value=='' || isNaN(this.value)){this.value=1;}" id="option_value_s_qq_0"></div><div style="display:none;width:30px;height:25px;float:left;text-align:center;line-height:25px;background-color:#dfd;cursor:pointer;margin-left:2px;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#cfc';" onmouseout="this.style.backgroundColor='#dfd'" title="Click to add option" id="add_question_option_button_s_qq_0" onclick="add_question_option('_s','_qq')">+</div>

<input type="hidden" id="option_id_s_qq_0" value="0">
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;" id="question_option_s_qq_1">
<div style="width:100px;height:25px;line-height:25px;float:left;" ondblclick="remove_option('_s','_qq','_o');" title="Double click to remove/add item" id="option_title_s_qq_1">Option 2:</div>
<div style="width:290px;height:25px;float:left;line-height:30px;color:#aaa;"><input type="text" id="option_s_qq_1" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter option here" onfocus="if(this.value=='Enter option here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}" onfocusout="if(this.value==''){this.value='Enter option here';this.style.color='#aaa';}"> </div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">Ordering:</div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:2px;"><input type="text" style="width:100%;height:25px;margin-top:2px;" value="2" onfocusout="if(this.value=='' || isNaN(this.value)){this.value=2;}" id="option_order_s_qq_1"></div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:10px;">Score:</div><div style="width:50px;height:30px;line-height:30px;float:left;margin-left:2px;"><input type="text" style="width:100%;height:25px;margin-top:2px;" value="1" onfocusout="if(this.value==''){this.value=1;}" id="option_value_s_qq_1"></div><div style="width:30px;height:25px;float:left;text-align:center;line-height:25px;background-color:#dfd;cursor:pointer;margin-left:2px;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#cfc';" onmouseout="this.style.backgroundColor='#dfd'" title="Click to add option" id="add_question_option_button_s_qq_1" onclick="add_question_option('_s','_qq')">+</div>
<input type="hidden" id="option_id_s_qq_1" value="0">
</div>
</div>
<input type="hidden" id="total_question_options_s_qq" value="2">
<input type="hidden" id="removed_question_options_s_qq" value="">

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#f6f6ff;text-align:center;color:#777;cursor:pointer;" onmouseover="this.style.backgroundColor='#f2f2ff';" onmouseout="this.style.backgroundColor='#f6f6ff'" title="Click to view options" onclick="$('#question_advanced_options_s_qq').slideToggle('fast');fetch_questionnaire_ession('_s','_qq')">Advanced question options</div>

<div style="width:100%;height:30px;float:left;border:solid 1px #f6f6ff;display:none;" id="question_advanced_options_s_qq">
<div style="width:100%;height:30px;float:left;line-height:30px;border-bottom:solid 1px #eee;">
<div style="width:90px;height:30px;line-height:30px;float:left;margin-left:10px;color:#006bb3;">Dependency:</div>
<div style="width:55px;height:30px;line-height:30px;float:left;margin-left:10px;">Session:</div>
	<div style="width:auto;;min-height:30px;height:auto;float:left;">

	<div class="option_item" title="Click to change option" onclick="$('#question_dependency_ession_menu_s_qq').toggle('fast');" id="active_question_dependency_ession_s_qq" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:78px;max-width:100px;width:auto;">None</div>

	<div class="option_menu" id="question_dependency_ession_menu_s_qq" style="display:none;min-width:80px;max-width:280px;width:auto;">		
		
	</div>
	
	<input type="hidden" id="selected_question_dependency_ession_s_qq" value="-1"></div>
	
	<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:10px;">Question:</div>
	<div style="width:auto;;min-height:30px;height:auto;float:left;">

	<div class="option_item" title="Click to change option" onclick="$('#option_question_dependency_question_menu_s_qq').toggle('fast');" id="active_question_dependency_question_s_qq" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:78px;max-width:100px;width:auto;">None</div>

	<div class="option_menu" id="option_question_dependency_question_menu_s_qq" style="display:none;min-width:80px;max-width:280px;width:auto;">		
		
	</div>
	
	<input type="hidden" id="selected_question_dependency_question_s_qq" value="-1"></div>
	
	<div style="width:45px;height:30px;line-height:30px;float:left;margin-left:10px;">Option:</div>
	<div style="width:auto;;min-height:30px;height:auto;float:left;">

	<div class="option_item" title="Click to change option" onclick="$('#option_question_dependency_option_menu_s_qq').toggle('fast');" id="active_question_dependency_option_s_qq" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:78px;max-width:100px;width:auto;">None</div>

	<div class="option_menu" id="option_question_dependency_option_menu_s_qq" style="display:none;min-width:80px;max-width:280px;width:auto;">		
		
	</div>
	
	<input type="hidden" id="selected_question_dependency_option_s_qq" value="-1"></div>
	</div>
	
</div>
</div>


</div>
<input type="hidden" id="total_questions_s" value="1">
<input type="hidden" id="removed_questions_s" value="">
<div style="width:100%;height:30px;float:left;margin-top:5px;"><div style="width:100px;height:30px;line-height:30px;text-align:center;float:left;background-color:#eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="add_question('_s');">Add question</div></div>

</div>
</div>
</div>
</div>

<script>
	if(Number($('#module_id').val()) == 4){
		$('#questionnaire_wifi_holder').slideDown('fast');
		
	}else{
		$('#questionnaire_wifi_holder').slideUp('fast');
		
	}
</script>