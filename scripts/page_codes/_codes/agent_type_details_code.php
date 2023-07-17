<?php

$agent_type_id = $variables[0];
if($active_user_roles[8]){
	$editing = 1;
	
}else{
	$editing = 0;
	
}

if($agent_type_id){
	$this_agent_type = mysqli_query($connect,"select * from agent_types where id = $agent_type_id")or die(mysqli_error($connect));
	$this_agent_type_results = mysqli_fetch_array($this_agent_type,MYSQLI_ASSOC);	

	$agent_type_title = $this_agent_type_results['title'];
	$agent_type_description = $this_agent_type_results['description'];
	
	$this_branch_id = $this_agent_type_results['branch_id'];
	if(!$this_branch_id){
		$this_branch_title = 'All clusters';

	}else{
		$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
		$this_branch_title = $this_branch_results['title'];
	}
	
	$default_color = '#000';
	
	$button_text = 'Update';

}else{
	$agent_type_title = 'Enter title here';
	$agent_type_description = 'Enter description here';
	
	$this_branch_id = $user_results['branch_id'];
	if(!$this_branch_id){
		$this_branch_title = 'All clusters';
		$this_branch_id = 0;
		
	}else{
		$user_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$this_branch_title = $this_branch_results['title'];
	}
	
	
	$default_color = '#aaa';
	$button_text = 'Create';
}
?>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($agent_type_title);?>"  id="agent_type_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($agent_type_title);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Cluster:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#agent_type_branch_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify this option');<?php }?>" id="active_agent_type_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_branch_title);?></div>

			<div class="option_menu" id="agent_type_branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_type_branch_menu').toggle('fast');$('#active_agent_type_branch').html($(this).html());$('#selected_agent_type_branch').val(0);$('#new_agent_error_message').slideUp('fast');">All clusters</div>
			
			
				<?php
				
					$branch_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($branch_menu);$u++){
						$branch_menu_results = mysqli_fetch_array($branch_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_type_branch_menu').toggle('fast');$('#active_agent_type_branch').html($(this).html());$('#selected_agent_type_branch').val(<?php print($branch_menu_results['id']);?>);$('#new_agent_error_message').slideUp('fast');"><?php print($branch_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_agent_type_branch" value="<?php print($this_branch_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Description*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><textarea style="min-width:100%;max-width:100%;min-heigth:100%;max-height:100%;font-family:arial;font-size:0.9em;border:solid 1px #aaa;color:<?php print($default_color);?>" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter description here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($agent_type_description);?>';this.style.color='<?php print($default_color);?>'}" id="agent_type_description"><?php print($agent_type_description);?></textarea></div>
</div>

	
	<?php if($editing){?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_agent_type_button" onclick="update_or_create_agent_type(<?php print($agent_type_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($agent_type_id){
	if($this_agent_type_results['status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="agent_type_status_change_button" onclick="enable_or_disable_agent_type(<?php print($agent_type_id);?>,0);" title="Click to disable this agent_type">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="agent_type_status_change_button" onclick="enable_or_disable_agent_type(<?php print($agent_type_id);?>,1);" title="Click to enable this agent_type">Enable</div>
<?php
		
	}
}
?>
</div>


<?php
}
?>
	<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>
