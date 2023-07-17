<?php
if($branch_id){
	$button_text = 'Update';
	$default_color = '#000';
	$branch_title = $this_branch_results['title'];
	$branch_phone = $this_branch_results['phone'];
	$branch_email = $this_branch_results['email'];
	$branch_notes = $this_branch_results['details'];
	
	
}else{
	$button_text = 'Create';
	$default_color = '#aaa';
	$branch_title = 'Enter cluster name here';
	$branch_phone = 'Enter phone number here';
	$branch_email = 'Enter email here';
	$branch_notes = 'Enter some notes here';
	
	
}
?>

<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Cluster name:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="branch_name" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($branch_title);?>" onfocus="if(this.value=='Enter cluster name here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_branch_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter cluster name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Phone number:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="branch_phone" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($branch_phone);?>" onfocus="if(this.value=='Enter phone number here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_branch_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter phone number here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Email:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="branch_email" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($branch_email);?>" onfocus="if(this.value=='Enter email here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_branch_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter email here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Notes:</div>
<div style="width:290px;min-height:30px;height:auto'float:left;line-height:30px;color:#aaa;">

<textarea id="branch_notes" style="min-width:100%;max-width:100%;min-height:100px;max-height:100px;font-family:arial;color:<?php print($default_color);?>;font-size:0.9em;" onfocus="if(this.value=='Enter some notes here'){this.value='';this.style.color='#000';}$('#new_branch_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter some notes here';this.style.color='#aaa';}"><?php print($branch_notes);?></textarea>
</div>
</div>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_branch_button" onclick="create_or_update_branch(<?php print($branch_id);?>);"><?php print($button_text);?></div>

<?php
if($branch_id and $active_user_roles[8]){
	if($this_branch_results['status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_or_enabe_branch_button" onclick="disable_or_enable_branch(0,<?php print($branch_id);?>);" title="Click to disable this item">Disable</div>
<?php

	}else{
		?>
		<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="disable_or_enabe_branch_button" onclick="disable_or_enable_branch(1,<?php print($branch_id);?>);" title="Click to activate this item">Enable</div>
		<?php
	}
}
?>
<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_branch_error_message">Information here</div>
</div>