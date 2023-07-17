<?php

$activity_id = $variables[0];
if($active_user_roles[8]){
	$editing = 1;
	
}else{
	$editing = 0;
	
}

if($activity_id){
	$this_activity = mysqli_query($connect,"select * from activities where id = $activity_id")or die(mysqli_error($connect));
	$this_activity_results = mysqli_fetch_array($this_activity,MYSQLI_ASSOC);	

	$activity_title = $this_activity_results['title'];
	$max_value = $this_activity_results['max_value'];
	$default_color = '#000';
	
	if($this_activity_results['warning']){
		$this_warnings_title = 'On';
		
	}else{
		$this_warnings_title = 'Off';
	}
	
	$this_warnings_value = $this_activity_results['warning'];
	$sms_code = $this_activity_results['gsm_code'];
	$ussd_code = $this_activity_results['ussd_code'];
	$ussd_ordering = $this_activity_results['_order'];
	
	$button_text = 'Update';
	
	$this_unit_id = $this_activity_results['services'];
	if($this_unit_id){
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		
		if(!$this_unit_results['status']){
			$this_unit_title = $this_unit_results['title'].'[Disabled]';
			
		}else{
			$this_unit_title = $this_unit_results['title'];
			
		}
	
	}
	
	$activity_clusters =$this_activity_results['branch_ids'];
	$activity_agent_types = $this_activity_results['agent_type_ids'];

}else{
	$activity_title = 'Enter activity title here';
	$max_value = 100;
	$default_color = '#aaa';
	
	$this_warnings_title = 'Off';
	$this_warnings_value = 0;
	
	$sms_code = 'Enter SMS code here';
	$ussd_code = 'Enter USSD code here';
	$ussd_ordering = 100;
	
	$button_text = 'Create';
	
	$this_unit_id = $user_results['unit_id'];
	if($this_unit_id){
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		
		$this_unit_title = $this_unit_results['title'];
	
	}else{
		$this_unit_title = 'Select unit';
	}
	
	$activity_clusters = '';
	$activity_agent_types  = '';
}
?>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($activity_title);?>"  id="activity_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter activity title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($activity_title);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Max value*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($max_value);?>"  id="activity_max_value" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter max value here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($max_value);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">SMS Code*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($sms_code);?>"  id="activity_sms_code" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter SMS code here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($sms_code);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">USSD Code*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($ussd_code);?>"  id="activity_ussd_code" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter USSD code here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($ussd_code);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">USSD Ordering*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:#000" value="<?php print($ussd_ordering);?>"  id="activity_ussd_ordering" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter USSD position here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($ussd_ordering);?>';'}"></div>
</div>

<div style="width:auto;height:auto;float:left;" id="activity_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;">Unit:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?>$('#activity_unit_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change this option');<?php }?>" id="active_activity_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($this_unit_title);?></div>

		<div class="option_menu" id="activity_unit_menu" style="display:none;width:auto;">
		<?php
			
			$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
				$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
				
				if($unit_menu_results['status'] == 0){
					$unit_title = $unit_menu_results['title'].'[Disabled]';
					
				}else{
					$unit_title = $unit_menu_results['title'];
					
				}
				
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#activity_unit_menu').toggle('fast');$('#active_activity_unit').html($(this).html());$('#selected_activity_unit').val(<?php print($unit_menu_results['id']);?>);"><?php print($unit_title);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_activity_unit" value="<?php print($this_unit_id);?>">
	</div>
	
	
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Clusters:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:15px;border:solid 1px #ccc;">
<?php
$branches = mysqli_query($connect,"select * from branches where company_id = $company_id")or die(mysqli_error($connect));

for($b=0;$b<mysqli_num_rows($branches);$b++){
	$branch_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);
	
	?>
	<input type="checkbox" id="cluster_<?php print($branch_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($branch_results['id']);?>,'selected_activity_clusters');}else{remove_from_selection(<?php print($branch_results['id']);?>,'selected_activity_clusters')}" <?php if($user_results['branch_id'] != 0 and $branch_results['id'] != $user_results['branch_id'] || !$editing){print(' disabled ');} if(check_item_in_list($branch_results['id'],$activity_clusters,0,',')){print(' checked ');}?> > <label for="cluster_<?php print($branch_results['id']);?>"><?php print($branch_results['title']);?></label><br>
	<?php
}
?>
<input type="hidden" id="selected_activity_clusters" value="<?php print($activity_clusters);?>">
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
	<input type="checkbox" id="agent_type_<?php print($agent_type_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($agent_type_results['id']);?>,'selected_activity_agent_types');}else{remove_from_selection(<?php print($agent_type_results['id']);?>,'selected_activity_agent_types')}" <?php if(check_item_in_list($agent_type_results['id'],$activity_agent_types,0,',')){print(' checked ');}?> > <label for="agent_type_<?php print($agent_type_results['id']);?>"><?php print($agent_type_results['title']);?></label><br>
	<?php
}
?>
<input type="hidden" id="selected_activity_agent_types" value="<?php print($activity_agent_types);?>">
</div>
</div>
	
	<div style="width:auto;height:auto;float:left;" id="warnings_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;">Warnings:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').hide('fast');">
		
		<div class="option_item" title="Click to change option" onclick="$('#activity_warnings_menu').toggle('fast');" id="active_activity_warnings" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($this_warnings_title);?></div>

		<div class="option_menu" id="activity_warnings_menu" style="display:none;width:auto;">		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#activity_warnings_menu').toggle('fast');$('#active_activity_warnings').html($(this).html());$('#selected_activity_warnings').val(0);">Off</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#activity_warnings_menu').toggle('fast');$('#active_activity_warnings').html($(this).html());$('#selected_activity_warnings').val(1);">On</div>
		
		</div>
		</div>
		<input type="hidden" id="selected_activity_warnings" value="<?php print($this_unit_id);?>">
	</div>
	
	
	<?php if($editing){?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_activity_button" onclick="update_or_create_activity(<?php print($activity_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($activity_id){
	if($this_activity_results['status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="activity_status_change_button" onclick="enable_or_disable_activity(<?php print($activity_id);?>,0);" title="Click to disable this activity">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="activity_status_change_button" onclick="enable_or_disable_activity(<?php print($activity_id);?>,1);" title="Click to enable this activity">Enable</div>
<?php
		
	}
}
?>
</div>


<?php
}
?>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>
	
