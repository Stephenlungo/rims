<div style="width:400px;height:350px;position:absolute;z-index:2;display:none;" id="new_request_type" >
<div class="window_holder" style="width:400px;">
<div class="window_title_bar">Create new request type

<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="close_window('new_request_type');">X</div>
</div>

<div class="window_container" style="width:98.5%;padding:2px;height:350px;">


<div style="width:100%;height:auto;margin:0 auto;" id="newUser">
<form name="signupForm" method="post" action="">
<input type="hidden" name="action" value="signup">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" id="new_request_type_title" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter title here" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_request_error_message').hide('fast');" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}"></div>
</div>

<?php
if(!$user_results['branch_id']){
	$branch_title = 'Non-clustered';
	
}else{
	$branch_id = $user_results['branch_id'];
	$this_branch = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
	$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
	
	$branch_title = $this_branch_results['title'];
}
?>

<div style="width:100%;float:left;margin-bottom:10px;" id="new_branch_type">
<div style="line-height:30px;width:100px;height:30px;float:left;">Cluster: </div>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_type_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#branch_type_menu').toggle('fast');" id="active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($branch_title);?></div>

<?php 
if($user_results['branch_id'] == 0){?>
<div class="option_menu" id="branch_type_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_type_menu').toggle('fast');$('#active_branch').html($(this).html());$('#new_type_branch_id').val(0)" >Non-clustered</div>
<?php
$branches = mysqli_query($connect,"select * from branches where company_id = $company_id")or die(mysqli_error($connect));

for($b=0;$b<mysqli_num_rows($branches);$b++){
	$branches_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);

	?>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_type_menu').toggle('fast');$('#active_branch').html($(this).html());$('#new_type_branch_id').val(<?php print($branches_results['id']);?>)"><?php print($branches_results['title']);?></div>
<?php
}
?>
</div>
<?php
}
?>
</div>
<input type="hidden" id="new_type_branch_id" value="0">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Approval levels:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" id="new_request_type_approval_levels" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter number of approval levels here" onfocus="if(this.value=='Enter number of approval levels here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_request_error_message').hide('fast');" onfocusout="if(this.value==''){this.value='Enter number of approval levels here';this.style.color='#aaa';}"></div>
</div>

<div style="width:300px;float:left;" id="new_request_type_urgency">
<div style="line-height:20px;width:80px;height:20px;float:left;">Urgency: </div>
<div style="width:100px;min-height:30px;height:auto;float:left;" onclick="$('#new_request_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#request_type_urgency_menu').toggle('fast');" id="active_urgency" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Low</div>


<div class="option_menu" id="request_type_urgency_menu" style="display:none;">
<?php
$claim_type_priorities = mysqli_query($connect,"select * from priorities")or die(mysqli_error($connect));

for($p=0;$p<mysqli_num_rows($claim_type_priorities);$p++){
	$claim_type_priorities_results = mysqli_fetch_array($claim_type_priorities,MYSQLI_ASSOC);

	?>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_type_urgency_menu').toggle('fast');$('#active_urgency').html($(this).html());$('#new_request_type_urgency_id').val(<?php print($claim_type_priorities_results['id']);?>)" ><?php print($claim_type_priorities_results['title']);?></div>
<?php
}
?>
</div>
</div>
<input type="hidden" id="new_request_type_urgency_id" value="1">
</div>

<div style="width:300px;float:left;" id="new_request_type_urgency">
<div style="line-height:20px;width:80px;height:20px;float:left;">Color: </div>
<div style="width:200px;min-height:30px;height:auto;float:left;" onclick="$('#new_request_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#request_type_color_menu').toggle('fast');" id="active_color" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Automatic</div>


<div class="option_menu" id="request_type_color_menu" style="display:none;width:100px">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_request_type_color_code').val('')" >Automatic</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_request_type_color_code').val('000')" >Black</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_request_type_color_code').val('faa')" >Red</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_request_type_color_code').val('ddd')" >Gray</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_request_type_color_code').val('eef')">Blue</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#request_type_color_menu').toggle('fast');$('#active_color').html($(this).html());$('#new_request_type_color_code').val('ffc864')">Orange</div>
</div>
</div>
<input type="hidden" id="new_request_type_color_code" value="">
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="create_request_type();" id="create_request_type_button">Create</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_request_error_message"></div>
</div>



</form>
</div>
</div>
</div>
</div>
