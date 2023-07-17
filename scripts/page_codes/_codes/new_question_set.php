<div style="width:900px;height:500px;position:absolute;z-index:2;" id="new_question_set" >
<div class="window_holder" style="width:900px;">
<div class="window_title_bar">Create new question set

<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="close_window('new_question_set');">X</div>
</div>

<div class="window_container" style="width:99.3%;padding:2px;height:500px;">
<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">


<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;font-weight:bold;">Title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="questionnaire_title" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter name here" onfocus="if(this.value=='Enter name here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_questionnaire_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;" id="new_location_0_holder">
	<div style="width:100px;height:30px;line-height:30px;float:left;font-weight:bold;">Questionnaire:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#option_0_menu').toggle('fast');" id="active_option_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Select questionnaire</div>

		<div class="option_menu" id="option_0_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<?php
			
			$questionnaires = mysqli_query($connect,"select * from questionnaires where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($q=0;$q<mysqli_num_rows($questionnaires);$q++){
				$questionnaire_results = mysqli_fetch_array($questionnaires,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_0_menu').toggle('fast');$('#active_option_0').html($(this).html());$('#selected_option_0').val(<?php print($questionnaire_results['id']);?>);fetch_menu_items('connect','questionnaire_stages','questionnaire_id',<?php print($questionnaire_results['id']);?>,'option_1',1,1,'');"><?php print($questionnaire_results['title']);?></div>
				<?php
			}
		?>
		</div>
	</div>
</div>
		<input type="hidden" id="selected_option_0" value="0">
		
	
	<div style="width:100%;height:auto;float:right;margin-top:5px;display:none;" id="option_1_holder">
		<div style="width:100px;height:30px;line-height:30px;float:left;font-weight:bold;">Stage:</div>
		<div style="width:270px;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#option_1_menu').toggle('fast');" id="active_option_1" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select stage</div>

		<div class="option_menu" id="option_1_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		</div>
		</div>
		<input type="hidden" id="selected_option_1" value="0">
	</div>




<div style="width:100%;height:25px;line-height:25px;background-color:#eee;text-align:center;float:left;margin-top:20px;">Questions</div>
<div style="width:100%;height:auto;float:left;" id="questions_holder">
<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;" id="question_0_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;font-weight:bold;">Question 1:</div>
<div style="width:350px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="question_0" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter question here" onfocus="if(this.value=='Enter question here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}" onfocusout="if(this.value==''){this.value='Enter 
question here';this.style.color='#aaa';}"></div> 

<div style="width:80px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:10px;">Option type:</div>
	<div style="width:auto;;min-height:30px;height:auto;float:left;">

	<div class="option_item" title="Click to change option" onclick="$('#option_type_menu_0').toggle('fast');" id="active_option_type_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:100px;width:auto;">List</div>

	<div class="option_menu" id="option_type_menu_0" style="display:none;min-width:80px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_0').toggle('fast');$('#active_option_type_0').html($(this).html());$('#selected_option_type_0').val(0);">List</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_0').toggle('fast');$('#active_option_type_0').html($(this).html());$('#selected_option_type_0').val(0);">Bullet</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#option_type_menu_0').toggle('fast');$('#active_option_type_0').html($(this).html());$('#selected_option_type_0').val(0);">Check-box</div>
	</div>
	
	<input type="hidden" id="selected_option_type_0" value="0">
	</div>
	
	<div style="width:100%;height:auto;float:left;" id="qustion_options_0">
	
	<div style="width:100%;height:auto;float:left;margin-top:5px;" id="question_option_0_1">
<div style="width:100px;height:25px;line-height:25px;float:left;">Option 1:</div>
<div style="width:290px;height:25px;float:left;line-height:30px;color:#aaa;"><input type="text" id="option_0_1" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter option here" onfocus="if(this.value=='Enter option here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}" onfocusout="if(this.value==''){this.value='Enter option here';this.style.color='#aaa';}" ></div> <div style="display:none;width:30px;height:25px;float:left;text-align:center;line-height:25px;background-color:#dfd;cursor:pointer;margin-left:2px;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#cfc';" onmouseout="this.style.backgroundColor='#dfd'" title="Click to add option" id="add_question_option_button_0_0" onclick="add_question_option('_0')">+</div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;" id="question_option_0_2">
<div style="width:100px;height:25px;line-height:25px;float:left;">Option 2:</div>
<div style="width:290px;height:25px;float:left;line-height:30px;color:#aaa;"><input type="text" id="option_0_2" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter option here" onfocus="if(this.value=='Enter option here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}" onfocusout="if(this.value==''){this.value='Enter option here';this.style.color='#aaa';}"> </div><div style="width:30px;height:25px;float:left;text-align:center;line-height:25px;background-color:#dfd;cursor:pointer;margin-left:2px;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#cfc';" onmouseout="this.style.backgroundColor='#dfd'" title="Click to add option" id="add_question_option_button_0_1" onclick="add_question_option('_0')">+</div>
</div>
</div>
<input type="hidden" id="total_question_options_0" value="2">
</div>
</div>
<input type="hidden" id="total_questions" value="1">
<div style="width:100%;height:30px;float:left;margin-top:5px;"><div style="width:100px;height:30px;line-height:30px;text-align:center;margin:0 auto;background-color:#eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="add_question();">Add question</div></div>


<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_branch_button" onclick="create_or_edit_questionnaire(0);">Create</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_questionnaire_set_error_message">Information here</div>
</div>
</div>
</div>
</div>
