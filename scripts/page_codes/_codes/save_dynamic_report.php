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




	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Cluster*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#user_cluster_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify cluster settings for users');<?php }?>" id="active_user_cluster" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_cluster_title);?></div>

			<div class="option_menu" id="user_cluster_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(0);fetch_cluster_user_groups(<?php print('0,'.$user_id);?>);$('#error_message').slideUp('fast');">Non-clustered</div>
			
			
				<?php
				
					$cluster_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($cluster_menu);$u++){
						$cluster_menu_results = mysqli_fetch_array($cluster_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(<?php print($cluster_menu_results['id']);?>);fetch_cluster_user_groups(<?php print($cluster_menu_results['id'].','.$user_id);?>);$('#error_message').slideUp('fast');"><?php print($cluster_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
</div>
<input type="hidden" id="selected_user_cluster" value="<?php print($this_cluster_id);?>">
	
	<script>
		fetch_cluster_user_groups(<?php print($this_cluster_id.','.$user_id);?>)
	
	</script>
</div>


	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:140px;height:30px;line-height:30px;float:left;">Accessibility type:</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#accessibility_type_menu').toggle('fast');" id="active_accessibility_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($accessibility_type_title);?></div>

					<div class="option_menu" id="accessibility_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#accessibility_type_menu').toggle('fast');$('#active_accessibility_type').html($(this).html());$('#selected_accessibility_type').val(0);$('#error_message').slideUp('fast');$('#location_holder').slideDown('fast');$('#user_group_holder').slideUp('fast');$('#unit_holder').slideUp('fast');$('#user_holder').slideUp('fast');">Location specific</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#accessibility_type_menu').toggle('fast');$('#active_accessibility_type').html($(this).html());$('#selected_accessibility_type').val(1);$('#error_message').slideUp('fast');$('#location_holder').slideDown('fast');$('#user_group_holder').slideDown('fast');$('#unit_holder').slideDown('fast');$('#user_holder').slideUp('fast');">User group, unit and location specific</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#accessibility_type_menu').toggle('fast');$('#active_accessibility_type').html($(this).html());$('#selected_accessibility_type').val(2);$('#error_message').slideUp('fast');$('#location_holder').slideDown('fast');$('#user_group_holder').slideUp('fast');$('#unit_holder').slideDown('fast');$('#user_holder').slideUp('fast');">Unit and location specific</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#accessibility_type_menu').toggle('fast');$('#active_accessibility_type').html($(this).html());$('#selected_accessibility_type').val(3);$('#error_message').slideUp('fast');$('#location_holder').slideUp('fast');$('#user_group_holder').slideUp('fast');$('#unit_holder').slideUp('fast');$('#user_holder').slideDown('fast');">User Specific</div>
					</div>
			</div>
			<input type="hidden" id="selected_accessibility_type" value="<?php print($accessibility_type);?>">
		</div>
	</div>
	
	
	<div style="width:100%;height:auto;float:left;margin-bottom:20px;<?php print($user_group_display);?>" id="user_group_holder">
<div style="width:140px;height:30px;line-height:30px;float:left;">User groups*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:20px;border:solid 1px #aaa;">

	<div style="width:100%;min-height:30px;height:auto;float:left;max-height:100px;overflow:auto;" id="user_groups_holder">
	
	
	</div>
	<input type="hidden" id="selected_group_ids" value="<?php print($user_group_ids);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;margin-top:5px;<?php print($unit_display);?>" id="unit_holder">
<div style="width:140px;height:30px;line-height:30px;float:left;">Unit*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?>$('#user_unit_menu').toggle('fast');<?php }else{?>  alert('You are not allowed to modify unit settings for users'); <?php }?>" id="active_user_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>

			<div class="option_menu" id="user_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_unit_menu').toggle('fast');$('#active_user_unit').html($(this).html());reset_dashboard_unit();$('#selected_dashboard_unit').val('');">All units</div>
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					
					$unit_id_string = '';
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						
						if($this_unit_id == '' || check_item_in_list($unit_menu_results['id'],$this_unit_id,0,',')){
							$item_checked = ' checked ';
							
						}else{
							$item_checked = '';
							
						}
						
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';"><input <?php print($item_checked)?> type="checkbox" id="unit_<?php print($unit_menu_results['id']);?>" style="margin-right:2px;" onchange="if(this.checked){add_to_selection(<?php print($unit_menu_results['id']);?>,'selected_dashboard_unit');}else{remove_from_selection(<?php print($unit_menu_results['id']);?>,'selected_dashboard_unit')}if($('#selected_dashboard_unit').val() == ''){$('#active_user_unit').html('Select unit');}else{$('#active_user_unit').html('Multiple selected');}"><label for="unit_<?php print($unit_menu_results['id']);?>"><?php print($unit_menu_results['title']);?></label></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_dashboard_unit" value="<?php print($this_unit_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;<?php print($user_display);?>" id="user_holder">
<div style="width:140px;height:30px;line-height:30px;float:left;">Users:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#user_menu').toggle('fast');" id="active_user" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($user_title);?></div>

		<div class="option_menu" id="user_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_menu').toggle('fast');$('#active_user').html($(this).html());$('#selected_user').val('');$('#error_message').slideUp('fast');">All users</div>
		
			<?php
			
				$user_menu = mysqli_query($connect,"select * from users where company_id = $company_id order by _name")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($user_menu);$s++){
					$user_menu_results = mysqli_fetch_array($user_menu,MYSQLI_ASSOC);
					
					if($this_user_id == '' || check_item_in_list($user_menu_results['id'],$this_user_id,0,',')){
						$item_checked = ' checked ';
						
					}else{
						$item_checked = '';
						
					}
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_menu').toggle('fast');$('#active_user').html($(this).html());$('#selected_user').val(<?php print($user_menu_results['id']);?>);$('#error_message').slideUp('fast');"><input type="checkbox" id="user_<?php print($user_menu_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($user_menu_results['id']);?>,'selected_user');}else{remove_from_selection(<?php print($user_menu_results['id']);?>,'selected_user');}" <?php print($item_checked);?>><label for="user_<?php print($user_menu_results['id']);?>"><?php print($user_menu_results['_name']);?></label></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_user" value="<?php print($this_user_id);?>">
</div>


<div style="width:100%;height:auto;float:left;<?php print($location_display);?>" id="location_holder">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#user_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for users');<?php }?>" id="active_dashboard_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="user_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_region_menu').toggle('fast');$('#active_dashboard_region').html($(this).html());$('#selected_dashboard_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#error_message').slideUp('fast');">All Regions</div>
			
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_region_menu').toggle('fast');$('#active_dashboard_region').html($(this).html());$('#selected_dashboard_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_dashboard_region" value="<?php print($this_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#user_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for users');<?php }?>" id="active_dashboard_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="user_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_province_menu').toggle('fast');$('#active_dashboard_province').html($(this).html());$('#selected_dashboard_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'user_hub',1,1,'connect-sites-hub_id-{id}-user_site-1-1');$('#error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_dashboard_province" value="<?php print($this_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#user_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for users');<?php }?>" id="active_dashboard_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="user_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_hub_menu').toggle('fast');$('#active_dashboard_hub').html($(this).html());$('#selected_dashboard_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'user_site',1,1,'');$('#error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_dashboard_hub" value="<?php print($this_hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#user_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorised to modify site settings for users');<?php }?>" id="active_dashboard_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="user_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_site_menu').toggle('fast');$('#active_dashboard_site').html($(this).html());$('#selected_dashboard_site').val(<?php print($site_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_dashboard_site" value="<?php print($this_site_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;margin-top:10px;">
		<div style="width:140px;height:30px;line-height:30px;float:left;">Set as default:</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#set_default_menu').toggle('fast');" id="active_set_default" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($set_default_title);?></div>

					<div class="option_menu" id="set_default_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#set_default_menu').toggle('fast');$('#active_set_default').html($(this).html());$('#selected_set_default').val(1);$('#error_message').slideUp('fast');">Yes</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#set_default_menu').toggle('fast');$('#active_set_default').html($(this).html());$('#selected_set_default').val(0);$('#error_message').slideUp('fast');">No</div>
						
						
					</div>
			</div>
			<input type="hidden" id="selected_set_default" value="<?php print($set_default);?>">
		</div>
	</div>

	<div style="width:100%;min-height:20px;line-height:20px;float:left;color:#f00;font-weight:bold;display:none;" id="save_report_error_message">Error comes here</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="finish_save_dynamic_report" onclick="process_save_dynamic_form();"><?php print($button_text);?></div>
