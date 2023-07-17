<div style="width:400px;height:450px;position:absolute;z-index:2;display:none;" id="new_questionnaire" >
<div class="window_holder" style="width:400px;">
<div class="window_title_bar">Create new questionnaire

<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="close_window('new_questionnaire');">X</div>
</div>

<div class="window_container" style="width:98.5%;padding:2px;height:450px;">
<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">


<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="questionnaire_title" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter name here" onfocus="if(this.value=='Enter name here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_questionnaire_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Cluster:</div>

<?php
if($branch_id == 0){
	$branch_title = '<i>Non-clustered</i>';
	
}else{
	$branch_query = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
	$branch_query_results = mysqli_fetch_array($branch_query,MYSQLI_ASSOC);
	
	$branch_title = $branch_query_results['title'];
}
?>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_error_message').hide('fast');">

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
<input type="hidden" id="questionnaire_branch_id" value="<?php print($branch_id);?>">

</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Client identity:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#client_identity_menu').toggle('fast');" id="active_client_identity" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;">Request</div>


<div class="option_menu" id="client_identity_menu" style="display:none;">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_identity_menu').toggle('fast');$('#active_client_identity').html($(this).html());$('#new_client_identity').val(0);" >Request</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_identity_menu').toggle('fast');$('#active_client_identity').html($(this).html());$('#new_client_identity').val(1);" >Ignore</div>

</div>
</div>
<input type="hidden" id="new_client_identity" value="1">

</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Welcome image:</div>

<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_questionnaire_error_message').hide('fast');">

<div class="option_item" title="Click to change option" id="active_uploaded_image" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;" onclick="open_uploader('upload_questionnaire_image()',0)">Select image</div>
</div>
<input type="hidden" id="new_client_identity" value="1">

</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Description:</div>
<div style="width:290px;min-height:30px;height:auto'float:left;line-height:30px;color:#aaa;">

<textarea id="new_questionnaire_description" style="min-width:100%;max-width:100%;min-height:100px;max-height:100px;font-family:arial;color:#aaa;font-size:0.9em;" onfocus="if(this.value=='Enter some details here'){this.value='';this.style.color='#000';}$('#new_questionnaire_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter some details here';this.style.color='#aaa';}">Enter some details here</textarea>
</div>
</div>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_branch_button" onclick="create_or_edit_questionnaire(0);">Create</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_questionnaire_error_message">Information here</div>
</div>
</div>
</div>
</div>
