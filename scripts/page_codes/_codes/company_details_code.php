<?php
$this_company_id = $variables[0];
$this_company = mysqli_query($connect,"select * from companies where id = $this_company_id")or die(mysqli_error($connect));
$this_company_results = mysqli_fetch_array($this_company,MYSQLI_ASSOC);
if($variables[0]){
	$button_text = 'Update';
	$default_color = '#000';
	$this_company_title = $this_company_results['_name'];
	$this_company_phone = $this_company_results['tel'];
	$this_company_email = $this_company_results['email'];
	$this_company_notes = $this_company_results['details'];
	
	
}else{
	$button_text = 'Create';
	$default_color = '#aaa';
	$this_company_title = 'Enter company name here';
	$this_company_phone = 'Enter phone number here';
	$this_company_email = 'Enter email here';
	$this_company_notes = 'Enter some notes here';
	
	
}
?>

<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Company name:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="company_name" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($this_company_title);?>" onfocus="if(this.value=='Enter company name here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_company_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter cluster name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Phone Number:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="company_phone" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($this_company_phone);?>" onfocus="if(this.value=='Enter phone number here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_company_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter phone number here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Email Address:</div>
<div style="width:290px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="company_email" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($default_color);?>;" value="<?php print($this_company_email);?>" onfocus="if(this.value=='Enter email here'){this.value='';this.style.color='#000';this.style.borderColor='#aaa';}$('#new_company_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter email here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Notes:</div>
<div style="width:290px;min-height:30px;height:auto'float:left;line-height:30px;color:#aaa;">

<textarea id="company_notes" style="min-width:100%;max-width:100%;min-height:100px;max-height:100px;font-family:arial;color:<?php print($default_color);?>;font-size:0.9em;" onfocus="if(this.value=='Enter some notes here'){this.value='';this.style.color='#000';}$('#new_company_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter some notes here';this.style.color='#aaa';}"><?php print($this_company_notes);?></textarea>
</div>
</div>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_company_button" onclick="create_or_update_company(<?php print($this_company_id);?>);"><?php print($button_text);?></div>

<?php
if($this_company_id and $active_user_roles[0]){
	if($this_company_results['status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_or_enabe_company_button" onclick="disable_or_enable_company(0,<?php print($this_company_id);?>);" title="Click to disable this item">Disable</div>
<?php

	}else{
		?>
		<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="disable_or_enabe_company_button" onclick="disable_or_enable_company(1,<?php print($this_company_id);?>);" title="Click to activate this item">Enable</div>
		<?php
	}
}
?>
<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_company_error_message">Information here</div>
</div>