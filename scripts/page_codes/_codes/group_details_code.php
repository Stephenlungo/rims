<?php

if($group_id){
	$this_group = mysqli_query($connect,"select * from sms_groups where id = $group_id")or die(mysqli_error($connect));
	$this_group_results = mysqli_fetch_array($this_group,MYSQLI_ASSOC);
	
	$sms_group_title = $this_group_results['title'];
	$sms_group_details = $this_group_results['description'];
	
	$this_branch_id = $this_group_results['branch_id'];
	if(!$this_branch_id){
		$this_branch_title = '<i>Non-clustered</i>';
		
	}else{		
		$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
		
		$this_branch_title = $this_branch_results['title'];

	}
	
	$schedule_id = $this_group_results['schedule_ids'];
	
	if($schedule_id){
		$this_schedule = mysqli_query($connect,"select * from prep_message_scheduler where id = $schedule_id")or die(mysqli_error($connect));
		$this_schedule_results = mysqli_fetch_array($this_schedule,MYSQLI_ASSOC);
		
		$this_schedule_title = $this_schedule_results['title'];
	}else{
		$this_schedule_title = 'None';
		
	}
	
	$agent_group_ids = $this_group_results['agent_type_ids'];
	$button_text = 'Update';	
	$this_group_status = $this_group_results['status'];
	$font_color = '#000';
	
}else{
	$sms_group_title = 'Enter title here';
	$sms_group_details = 'Enter details here';
	
	$this_branch_id = $user_results['branch_id'];
	if(!$this_branch_id){
		$this_branch_title = 'All clusters';
		
	}else{
		$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
		$this_branch_title = $this_branch_results['title'];
		
	}
	
	$schedule_id = 0;
	$this_schedule_title = 'None';
	
	$agent_group_ids = '';
	
	$button_text = 'Save';
	
	$this_group_status = 0;
	
	$font_color = '#aaa';
}

if($this_group_status == 1){
	$group_status_title = 'Disable';
	
}else{
	$group_status_title = 'Enable';
	
}
?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="single_recipient_holder">
<div style="width:130px;height:30px;line-height:30px;float:left;">Title:</div>
<div style="width:240px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($font_color);?>" value="<?php print($sms_group_title);?>"  id="group_title" onfocusout="if(this.value==''){this.value='Enter title here';this.style.color='#aaa';}" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');"></div>
</div>


<div style="width:auto;height:auto;float:left;" id="cluster_0_holder">
	<div style="width:130px;height:30px;line-height:30px;float:left;">Cluster:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?> $('#branch_menu').toggle('fast'); <?php }else{?>  alert('You are not authorized to change this option'); <?php }?>" id="active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_branch_title);?></div>

	<div class="option_menu" id="branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_group_branch').val(0);">Non-clustered</div>
		<?php
		
			$branch_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($b=0;$b<mysqli_num_rows($branch_menu);$b++){
				$branch_menu_results = mysqli_fetch_array($branch_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_group_branch').val(<?php print($branch_menu_results['id']);?>);"><?php print($branch_menu_results['title']);?></div>
				<?php
			}
		?>
	</div>
	</div>
	<input type="hidden" id="selected_group_branch" value="<?php print($this_branch_id);?>">
</div>

<div style="width:100%;height:auto;float:left;">
	<div style="width:130px;height:30px;line-height:30px;float:left;">Details:</div>
	<div style="width:240px;height:60px;float:left;"><textarea style="font-family:arial;font-size:0.9em;min-width:100%;max-width:100%;border:solid 1px #aaa;min-height:100%;max-height:100%;color:<?php print($font_color);?>" onfocusout="if(this.value==''){this.value='Enter details here';this.style.color='#aaa';}" onfocus="if(this.value=='Enter details here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" id="group_description"><?php print($sms_group_details);?></textarea></div>


</div>

<div style="width:auto;height:auto;float:left;margin-top:5px;" id="sms_schedule_0_holder">
	<div style="width:130px;height:30px;line-height:30px;float:left;">SMS Schedule:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#schedule_menu').toggle('fast');" id="active_schedule" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_schedule_title);?></div>

	<div class="option_menu" id="schedule_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_menu').toggle('fast');$('#active_schedule').html($(this).html());$('#selected_group_schedule').val(0);">None</div>
		<?php
		
			$schedule_menu = mysqli_query($connect,"select * from prep_message_scheduler where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));

			for($s=0;$s<mysqli_num_rows($schedule_menu);$s++){
				$schedule_menu_results = mysqli_fetch_array($schedule_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#schedule_menu').toggle('fast');$('#active_schedule').html($(this).html());$('#selected_group_schedule').val(<?php print($schedule_menu_results['id']);?>);"><?php print($schedule_menu_results['title']);?></div>
				<?php
			}
		?>
	</div>
	</div>
	<input type="hidden" id="selected_group_schedule" value="<?php print($schedule_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;"><div style="width:130px;height:30px;line-height:30px;float:left;">USSD agent groups:</div><div style="width:230px;min-height:30px;height:auto;float:left;line-height:15px;border:solid 1px #ccc;">
<?php
	$agent_types = mysqli_query($connect,"select * from agent_types where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
	for($a=0;$a<mysqli_num_rows($agent_types);$a++){
		$agent_type_results = mysqli_fetch_array($agent_types,MYSQLI_ASSOC);

		?>
		<input type="checkbox" id="agent_type_<?php print($agent_type_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($agent_type_results['id']);?>,'selected_agent_group_ids');}else{remove_from_selection(<?php print($agent_type_results['id']);?>,'selected_agent_group_ids')}" <?php if(check_item_in_list($agent_type_results['id'],$agent_group_ids,0,',')){print(' checked ');}?> > <label for="agent_type_<?php print($agent_type_results['id']);?>"><?php print($agent_type_results['title']);?></label><br>
		<?php
	}
?>
<input type="hidden" id="selected_agent_group_ids" value="<?php print($agent_group_ids);?>">
</div></div>






<div style="width:100%;height:auto;float:left;margin-bottom:2px;color:red;display:none;margin-top:5px;font-weight:bold;" id="error_message"></div>

<div style="width:100%;height:auto;float:left;margin-top:30px;">
		<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="group_update_button" title="Click to save group" onclick="update_sms_group(<?php print($group_id);?>);"><?php print($button_text);?></div>
		
<?php
	if($group_id and $active_user_roles[8]){
		
		if($this_group_status){
			
			$hover_out_color = 'brown';
			$hover_color = 'red';
			
		}else{
			$hover_out_color = '#5c5';
			$hover_color = '#7e7';
			
		}
		?>
	<div style="width:60px;height:30px;background-color:<?php print($hover_out_color);?>;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($hover_out_color);?>';"  id="disable_group_button" onclick="change_group_status(<?php print($group_id.','.$this_group_status);?>);" title="Click to change status of group"><?php print($group_status_title);?></div>
	
	<?php
	}
	?>
	</div>