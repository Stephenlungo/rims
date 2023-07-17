<?php

$unit_id = $variables[0];
if($active_user_roles[8]){
	$editing = 1;
	
}else{
	$editing = 0;
	
}

if($unit_id){
	$this_unit = mysqli_query($connect,"select * from units where id = $unit_id")or die(mysqli_error($connect));
	$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);	

	$unit_title = $this_unit_results['title'];
	
	$sms_code = $this_unit_results['gsm_code'];
	$ussd_code = $this_unit_results['ussd_code'];
	$ussd_ordering = $this_unit_results['_order'];
	$default_color = '#000';
	
	$button_text = 'Update';
	
	$unit_clusters = $this_unit_results['branch_ids'];
	$unit_agent_types = $this_unit_results['agent_type_ids'];

}else{
	$unit_title = 'Enter unit title here';
	$max_value = 100;
	$default_color = '#aaa';
	
	$sms_code = 'Enter SMS code here';
	$ussd_code = 'Enter USSD code here';
	$ussd_ordering = 100;
	
	$button_text = 'Create';
	
	$unit_clusters = $user_results['branch_id'];
	
	$unit_agent_types ='';
}
?>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($unit_title);?>"  id="unit_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter unit title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($unit_title);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">SMS Code*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($sms_code);?>"  id="unit_sms_code" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter SMS code here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($sms_code);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">USSD Code*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($ussd_code);?>"  id="unit_ussd_code" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter USSD code here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($sms_code);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">USSD Ordering*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:#000" value="<?php print($ussd_ordering);?>"  id="unit_ussd_ordering" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter USSD ordering'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($sms_code);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Clusters:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:15px;border:solid 1px #ccc;">
<?php
$branches = mysqli_query($connect,"select * from branches where company_id = $company_id")or die(mysqli_error($connect));

for($b=0;$b<mysqli_num_rows($branches);$b++){
	$branch_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);
	
	?>
	<input type="checkbox" id="cluster_<?php print($branch_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($branch_results['id']);?>,'selected_unit_clusters');}else{remove_from_selection(<?php print($branch_results['id']);?>,'selected_unit_clusters')}" <?php if($user_results['branch_id'] != 0 and $branch_results['id'] != $user_results['branch_id'] || !$editing){print(' disabled ');} if(check_item_in_list($branch_results['id'],$unit_clusters,0,',')){print(' checked ');}?> > <label for="cluster_<?php print($branch_results['id']);?>"><?php print($branch_results['title']);?></label><br>
	<?php
}
?>
<input type="hidden" id="selected_unit_clusters" value="<?php print($unit_clusters);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Agent types:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:15px;border:solid 1px #ccc;">
<?php
$agent_types = mysqli_query($connect,"select * from agent_types where company_id = $company_id")or die(mysqli_error($connect));

for($a=0;$a<mysqli_num_rows($agent_types);$a++){
	$agent_type_results = mysqli_fetch_array($agent_types,MYSQLI_ASSOC);
	
	?>
	<input type="checkbox" id="agent_type_<?php print($agent_type_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($agent_type_results['id']);?>,'selected_unit_agent_types');}else{remove_from_selection(<?php print($agent_type_results['id']);?>,'selected_unit_agent_types')}" <?php if(check_item_in_list($agent_type_results['id'],$unit_agent_types,0,',')){print(' checked ');}?> > <label for="agent_type_<?php print($agent_type_results['id']);?>"><?php print($agent_type_results['title']);?></label><br>
	<?php
}
?>
<input type="hidden" id="selected_unit_agent_types" value="<?php print($unit_agent_types);?>">
</div>
</div>


	
	<?php if($editing){?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_unit_button" onclick="update_or_create_unit(<?php print($unit_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($unit_id){
	if($this_unit_results['status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="unit_status_change_button" onclick="enable_or_disable_unit(<?php print($unit_id);?>,0);" title="Click to disable this unit">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="unit_status_change_button" onclick="enable_or_disable_unit(<?php print($unit_id);?>,1);" title="Click to enable this unit">Enable</div>
<?php
		
	}
}
?>
</div>


<?php
}
?>
	<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>
