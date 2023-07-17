<?php
if($report_id){
	$this_report = mysqli_query($connect,"select * from dynamic_reports where id = $report_id")or die(mysqli_error($connect));
		
	$this_report_resuts = mysqli_fetch_array($this_report,MYSQLI_ASSOC);
	
	$this_cluster_id = $this_report_resuts['branch_id'];
	if(!$this_cluster_id){
		$this_cluster_title = 'Non-clustered';
		
	}else{
		$this_cluster = mysqli_query($connect,"select * from branches where id = $this_cluster_id")or die(mysqli_error($connect));
		$this_cluster_results = mysqli_fetch_array($this_cluster,MYSQLI_ASSOC);
		
		$this_cluster_title = $this_cluster_results['title'];
	}
	
	$title = $this_report_resuts['title'];
	$default_color = '#000';
	
	$report_accessibility_id = $this_report_resuts['accessibility'];
	$report_accessibility_type = $this_report_resuts['accessibility_type'];
	
	
	
	
	$button_text = 'Update';
}else{
	$title = 'Enter report title here';
	$default_color = '#aaa';
	$report_accessibility_id = 0;
	$report_accessibility_type = 0;

	$button_text = 'Save';
	
	$this_cluster_id = $user_results['branch_id'];
	if(!$this_cluster_id){
		$this_cluster_title = 'Select option';
		$this_cluster_id = -1;
		
	}else{
		$this_cluster = mysqli_query($connect,"select * from branches where id = $this_cluster_id")or die(mysqli_error($connect));
		$this_cluster_results = mysqli_fetch_array($this_cluster,MYSQLI_ASSOC);
		$this_cluster_title = $this_cluster_results['title'];
		
	}
}

?>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($title);?>"  id="report_title" onfocus="if(this.value=='Enter report title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter report title here';this.style.color='#aaa'}"></div>
</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:140px;height:30px;line-height:30px;float:left;">Cluster*:</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#user_cluster_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify cluster settings for users');<?php }?>" id="active_user_cluster" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_cluster_title);?></div>

					<div class="option_menu" id="user_cluster_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(0);fetch_menu_items('connect','user_groups','status',1,'report_group_accessibility',1,1,'');">Non-clustered</div>
					
					
						<?php
						
							$cluster_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
							for($u=0;$u<mysqli_num_rows($cluster_menu);$u++){
								$cluster_menu_results = mysqli_fetch_array($cluster_menu,MYSQLI_ASSOC);
								?>
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(<?php print($cluster_menu_results['id']);?>);fetch_menu_items('connect','user_groups','branch_id',<?php print($cluster_menu_results['id']);?>,'report_group_accessibility',1,1,'');"><?php print($cluster_menu_results['title']);?></div>
								<?php
							}
						?>
					</div>
			</div>
			<input type="hidden" id="selected_user_cluster" value="<?php print($this_cluster_id);?>">
		</div>
	</div>

	<?php
	if($report_accessibility_type == 0){
		$accessibility_type_title = 'Standard';
		$standard_accessibility_display = '';
		$group_specific_accessibility_display = 'display:none';
		$report_group_accessibility_title = 'Select item';
		
		if($report_accessibility_id == 0){
			$report_standard_accessibility_title = 'Accessible to everyone';
			
		}else{
			$this_report_user = mysqli_query($connect,"select * from users where id = $report_accessibility_id")or die(mysqli_error($connect));
			$this_report_user_results = mysqli_fetch_array($this_report_user,MYSQLI_ASSOC);
			$report_standard_accessibility_title = 'Accessible to '.$this_report_user_results['_name'].' only';
		}

	}else{
		$accessibility_type_title = 'User Group Specific';
		$standard_accessibility_display = 'display:none';
		$report_standard_accessibility_title = 'Accessible to everyone';
		$group_specific_accessibility_display = '';
		
		$this_report_user_group = mysqli_query($connect,"select * from user_groups where id = $report_accessibility_id")or die(mysqli_error($connect));
		$this_report_user_group_results = mysqli_fetch_array($this_report_user_group,MYSQLI_ASSOC);
		
		$report_group_accessibility_title = $this_report_user_group_results['title'];
	}
	?>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:140px;height:30px;line-height:30px;float:left;">Accessibility type:</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#report_accessibility_type_menu').toggle('fast');" id="active_report_accessibility_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($accessibility_type_title);?></div>

					<div class="option_menu" id="report_accessibility_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_accessibility_type_menu').toggle('fast');$('#active_report_accessibility_type').html($(this).html());$('#selected_report_accessibility_type').val(0);$('#error_message').slideUp('fast');$('#standard_accessibility').slideDown('fast');$('#report_group_accessibility').slideUp('fast');">Standard</div>
						
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_accessibility_type_menu').toggle('fast');$('#active_report_accessibility_type').html($(this).html());$('#selected_report_accessibility_type').val(1);$('#error_message').slideUp('fast');$('#standard_accessibility').slideUp('fast');$('#report_group_accessibility').slideDown('fast');">User Group Specific</div>
					</div>
			</div>
			<input type="hidden" id="selected_report_accessibility_type" value="<?php print($report_accessibility_type);?>">
		</div>
	</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;<?php print($standard_accessibility_display);?>" id="standard_accessibility">
<div style="width:140px;height:30px;line-height:30px;float:left;">Accessible to:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#report_standard_accessibility_menu').toggle('fast');" id="active_report_standard_accessibility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($report_standard_accessibility_title);?></div>

		<div class="option_menu" id="report_standard_accessibility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_standard_accessibility_menu').toggle('fast');$('#active_report_standard_accessibility').html($(this).html());$('#selected_report_standard_accessibility').val(<?php print($user_id);?>);$('#error_message').slideUp('fast');">Accessible to me only</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_standard_accessibility_menu').toggle('fast');$('#active_report_standard_accessibility').html($(this).html());$('#selected_report_standard_accessibility').val(0);$('#error_message').slideUp('fast');" style="width:190px;">Accessible to everyone</div>
	
		</div>
	</div>
	<input type="hidden" id="selected_report_standard_accessibility" value="<?php print($report_accessibility_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;<?php print($group_specific_accessibility_display);?>" id="report_group_accessibility">
<div style="width:140px;height:30px;line-height:30px;float:left;">User Group:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#report_group_accessibility_menu').toggle('fast');" id="active_report_group_accessibility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($report_group_accessibility_title);?></div>

			<div class="option_menu" id="report_group_accessibility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<?php
					$this_branch_id = $user_results['branch_id'];
					if(!$this_branch_id){
						$cluster_filter = '';
						
					}else{
						$cluster_filter = ' and branch_id = '.$this_branch_id;
						
					}
					
						$user_group_menu = mysqli_query($connect,"select * from user_groups where company_id = $company_id and status = 1 $cluster_filter order by title")or die(mysqli_error($connect));

						for($g=0;$g<mysqli_num_rows($user_group_menu);$g++){
							$user_group_menu_results = mysqli_fetch_array($user_group_menu,MYSQLI_ASSOC);
							?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_group_accessibility_menu').toggle('fast');$('#active_report_group_accessibility').html($(this).html());$('#selected_report_group_accessibility').val(<?php print($user_group_menu_results['id']);?>);$('#error_message').slideUp('fast');" style="width:190px;"><?php print($user_group_menu_results['title']);?></div>
							<?php
						}
				?>
				
			</div>
	</div>
	<input type="hidden" id="selected_report_group_accessibility" value="<?php print($report_accessibility_id);?>">
</div>
</div>

	<div style="width:100%;min-height:20px;line-height:20px;float:left;color:#f00;font-weight:bold;display:none;" id="save_report_error_message">Error comes here</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="finish_save_dynamic_report" onclick="process_save_prep_report(<?php print($report_id);?>)">Proceed</div>
