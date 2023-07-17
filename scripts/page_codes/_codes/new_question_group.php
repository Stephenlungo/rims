<div style="width:400px;height:450px;position:absolute;z-index:2;display:none;" id="new_question_group" >
<div class="window_holder" style="width:400px;">
<div class="window_title_bar">Create new session

<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="close_window('new_question_group');">X</div>
</div>

<div class="window_container" style="width:98.5%;padding:2px;height:250px;">
<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">


<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="group_title" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_questionnaire_group_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Order:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="group_order" style="border:solid 1px #aaa;width:100%;height:30px;" value="1" onfocusout="if(this.value==''){this.value='1';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Questionnaire:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_group_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#questionnaire_menu').toggle('fast');" id="active_questionnaire" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:150px;width:auto;">Select option</div>


<div class="option_menu" id="questionnaire_menu" style="display:none;">
<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}

$questionnaires = mysqli_query($prep_connect,"select * from questionnaires where company_id = $company_id $branch_search order by title")or die(mysqli_error($prep_connect));

for($q=0;$q<mysqli_num_rows($questionnaires);$q++){
	$questionnaires_results = mysqli_fetch_array($questionnaires,MYSQLI_ASSOC);

	?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#questionnaire_menu').toggle('fast');$('#active_questionnaire').html($(this).html());$('#questionnaire_id').val(<?php print($questionnaires_results['id']);?>);" ><?php print($questionnaires_results['title']);?></div>
	<?php
}

?>
</div>
</div>
<input type="hidden" id="questionnaire_id" value="0">

</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_questionnaire_group_button" onclick="create_or_edit_questionnaire_group(0);">Create</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_questionnaire_group_error_message">Information here</div>
</div>
</div>
</div>
</div>
