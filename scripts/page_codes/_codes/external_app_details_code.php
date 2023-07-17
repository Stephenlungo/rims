<?php
	$app_id = $variables[0];
	
	if($app_id){
		$this_app = mysqli_query($connect,"select * from external_apps where id = $app_id")or die(mysqli_error($connect));
		
		$this_app_results = mysqli_fetch_array($this_app,MYSQLI_ASSOC);
		
		$app_title = $this_app_results['title'];
		$app_organisation = $this_app_results['organisation'];
		$app_organisational_key = simple_decode($this_app_results['organisation_key']);
		$app_password = rand(1000000,9999999);
		$module_string = $this_app_results['module_string'];
		$access_roles = $this_app_results['access_roles'];
		$user_id = $this_app_results['user_id'];
		$app_branch_id = $this_app_results['branch_id'];
		
		
		$app_linkage_id = $this_app_results['linkage_id'];
		
		$application_id = $app_id;
		$change_password_id = 0;
		$app_password_holder = 'none;';
		$color = '#000';
		$button_text = 'Update';
		
	}else{
		$app_title = 'Enter app name here';
		$app_organisation = 'Enter app organisation here';
		$app_organisational_key = 'rims_'.time().'_'.rand(1000000,9999999);
		$app_password = rand(1000000,9999999);
		$module_string = '';
		$access_roles = 2;
		$user_id = $user_id;
		$app_branch_id = $user_results['branch_id'];
		
		$application_id = '<i>Will be assigned automatically</i>';
		$change_password_id = 1;
		$app_password_holder = '';
		
		$app_linkage_id = 0;
		
		$color = '#aaa';
		$button_text = 'Create';
	}
	
	$app_linkage_title = 'Test environment';
	if($app_linkage_id){
		$app_linkage_title = 'Live environment';
	}
	
	if($access_roles == 0){
		$access_title = 'Fetch only';
		
	}else if($access_roles == 1){
		$access_title = 'Post only';
		
	}else if($access_roles == 2){
		$access_title = 'Fetch and Post';
		
	}
	
	$this_cluster_id = $app_branch_id;
	$this_cluster_title = 'All clusters';
	if($this_cluster_id){
		$this_cluster = mysqli_query($connect,"select * from branches where id = $this_cluster_id")or die(mysqli_error($connect));
		
		$this_cluster_results = mysqli_fetch_array($this_cluster,MYSQLI_ASSOC);
		$this_cluster_title = $this_cluster_results['title'];
	}
?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
	<div class="general_menu_holder" style="height:25px;line-height:25px;width:100%;">
		<div class="tab" style="height:25px;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_100" onclick="$('#access_log_details').slideUp('fast');$('#basic_details').slideDown('fast');tab_item_change(100);">Basic details</div>

		<div class="tab" style="height:25px;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_101" onclick="$('#basic_details').slideUp('fast');$('#access_log_details').slideDown('fast');tab_item_change(101);">Access log</div>
	</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;" id="basic_details">
	<div style="width:auto;float:left;height:30px;margin-bottom:2px;line-height:30px;">
		<div style="width:130px;height:30px;float:left;">App name:*</div>
		<div style="width:250px;min-height:30px;height:auto;float:left;"><input type="text" style="width:100%;height:30px;color:<?php print($color);?>;" value="<?php print($app_title);?>"  id="app_name" onfocus="if(this.value=='Enter app name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='<?php print($app_title);?>';this.style.color='<?php print($color);?>';}"></div>
	</div>

	<div style="width:auto;float:left;height:30px;line-height:30px;margin-bottom:2px;">
		<div style="width:130px;height:30px;float:left;">Organisation:*</div>
		<div style="width:250px;min-height:30px;height:auto;float:left;"><input type="text" style="width:100%;height:30px;color:<?php print($color);?>;" value="<?php print($app_organisation);?>"  id="app_organisation" onfocus="if(this.value=='Enter app organisation here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='<?php print($app_organisation);?>';this.style.color='<?php print($color);?>';}"></div>
	</div>

	<div style="width:auto;float:left;height:30px;line-height:30px;margin-bottom:2px;">
		<div style="width:130px;height:30px;float:left;">Organisational key:*</div>
		<div style="width:250px;min-height:30px;height:auto;float:left;"><input type="text" style="width:100%;height:30px;" value="<?php print($app_organisational_key);?>"  id="organisational_key" onfocus="if(this.value=='Enter organisational key here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='<?php print($app_organisation);?>';}"></div>
	</div>

	<div style="width:auto;float:left;height:30px;line-height:30px;margin-bottom:2px;">
		<div style="width:130px;height:30px;float:left;">App ID:*</div>
		<div style="width:250px;min-height:30px;height:auto;float:left;"><?php print($application_id);?></div>
	</div>
	
	<div style="width:100%;height:30px;line-height:30px;float:left;margin-bottom:5px;">
	<div style="width:140px;height:30px;line-height:30px;float:left;"></div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:120px;height:30px;line-height:30px;float:left;"><i>Change password:</i></div>
	<div style="border:solid 1px #eee;cursor:pointer;width:30px;height:30px;line-height:30px;float:left;text-align:center;<?php if($change_password_id){?>background-color:orange;<?php }?>" onmouseover="this.style.borderColor='orange';" onmouseout="this.style.borderColor='#eee';" onclick="$('#change_password_id').val(1);$('#app_password_holder').slideDown('fast');this.style.backgroundColor='orange';$('#dont_change_password_button').css('backgroundColor','#fff')" id="change_password_button">Yes</div>
	<div style="border:solid 1px #eee;margin-left:5px;cursor:pointer;width:30px;height:30px;line-height:30px;float:left;text-align:center;<?php if(!$change_password_id){?>background-color:orange;<?php }?>;<?php if(!$app_id){?>display:none;<?php }?>"  onmouseover="this.style.borderColor='orange';" onmouseout="this.style.borderColor='#eee';"  onclick="$('#change_password_id').val(0);$('#app_password_holder').slideUp('fast');this.style.backgroundColor='orange';$('#change_password_button').css('backgroundColor','#fff')" id="dont_change_password_button">No</div>
	</div>
	</div>
<input type="hidden" id="change_password_id" value="<?php print($change_password_id);?>">

	
	<div style="width:auto;float:left;height:30px;line-height:30px;margin-bottom:2px;display:<?php print($app_password_holder);?>" id="app_password_holder">
		<div style="width:130px;height:30px;float:left;">New app password:*</div>
		<div style="width:250px;min-height:30px;height:auto;float:left;"><input type="text" style="width:100%;height:30px;" value="<?php print($app_password);?>"  id="app_password" onfocus="if(this.value=='Enter app password here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='<?php print($app_password);?>';this.style.color='<?php print($color);?>';}"></div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:130px;height:30px;line-height:30px;float:left;">Cluster:*</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">

				<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#app_cluster_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify cluster settings for apps');<?php }?>" id="active_app_cluster" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_cluster_title);?></div>
				
				<div class="option_menu" id="app_cluster_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_cluster_menu').toggle('fast');$('#active_app_cluster').html($(this).html());$('#selected_app_cluster').val(0);fetch_cluster_app_groups(<?php print('0,'.$app_id);?>);$('#new_app_error_message').slideUp('fast');">All clusters</div>

					<?php
						$cluster_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));

						for($u=0;$u<mysqli_num_rows($cluster_menu);$u++){
							$cluster_menu_results = mysqli_fetch_array($cluster_menu,MYSQLI_ASSOC);
							
							?>
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_cluster_menu').toggle('fast');$('#active_app_cluster').html($(this).html());$('#selected_app_cluster').val(<?php print($cluster_menu_results['id']);?>);$('#new_app_error_message').slideUp('fast');"><?php print($cluster_menu_results['title']);?></div>
							<?php
						}
					?>
				</div>
			</div>
			<input type="hidden" id="selected_app_cluster" value="<?php print($app_branch_id);?>">
		</div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:130px;height:30px;float:left;">Allowed modules:*</div>
		<div style="width:230px;min-height:30px;min-height:60px;height:auto;float:left;border:solid 1px #ddd">
		<input type="checkbox" id="app_module_rims_main" onchange="if(this.checked){add_to_selection(0,'allowed_module');}else{remove_from_selection(0,'allowed_module');}" <?php if(check_item_in_list(0,$module_string,0,',')){print('checked');}?>><label for="app_module_rims_main">RIMS Main</label><br>
		<input type="checkbox" id="app_module_rims_claims" onchange="if(this.checked){add_to_selection(1,'allowed_module');}else{remove_from_selection(1,'allowed_module');}" <?php if(check_item_in_list(1,$module_string,0,',')){print('checked');}?>><label for="app_module_rims_claims">Claims</label><br>
		<input type="checkbox" id="app_module_rims_admin" onchange="if(this.checked){add_to_selection(2,'allowed_module');}else{remove_from_selection(2,'allowed_module');}" <?php if(check_item_in_list(2,$module_string,0,',')){print('checked');}?>><label for="app_module_rims_admin">Administration</label><br>
		<input type="checkbox" id="app_module_rims_hr" onchange="if(this.checked){add_to_selection(3,'allowed_module');}else{remove_from_selection(3,'allowed_module');}" <?php if(check_item_in_list(3,$module_string,0,',')){print('checked');}?>><label for="app_module_rims_hr">Human resource</label><br>
		<input type="checkbox" id="app_module_rims_prep" onchange="if(this.checked){add_to_selection(4,'allowed_module');}else{remove_from_selection(4,'allowed_module');}" <?php if(check_item_in_list(4,$module_string,0,',')){print('checked');}?>><label for="app_module_rims_prep">PrEP</label><br>
		<input type="checkbox" id="app_module_rims_training" onchange="if(this.checked){add_to_selection(5,'allowed_module');}else{remove_from_selection(5,'allowed_module');}" <?php if(check_item_in_list(5,$module_string,0,',')){print('checked');}?>><label for="app_module_rims_training">Training</label><br>
		<input type="checkbox" id="app_module_rims_transport" onchange="if(this.checked){add_to_selection(6,'allowed_module');}else{remove_from_selection(6,'allowed_module');}" <?php if(check_item_in_list(6,$module_string,0,',')){print('checked');}?>><label for="app_module_rims_transport">Transport</label>
		</div>
		
		<input type="hidden" id="allowed_module" value="<?php print($module_string);?>">
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:130px;height:30px;line-height:30px;float:left;">Allowed action:*</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">

				<div class="option_item" title="Click to change option" onclick="$('#app_action_menu').toggle('fast');" id="active_app_action" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($access_title);?></div>
				
				<div class="option_menu" id="app_action_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_action_menu').toggle('fast');$('#active_app_action').html($(this).html());$('#selected_app_action').val(0);$('#new_app_error_message').slideUp('fast');">Fetch only</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_action_menu').toggle('fast');$('#active_app_action').html($(this).html());$('#selected_app_action').val(1);$('#new_app_error_message').slideUp('fast');">Post only</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_action_menu').toggle('fast');$('#active_app_action').html($(this).html());$('#selected_app_action').val(2);$('#new_app_error_message').slideUp('fast');">Fetch and Post</div>

					
				</div>
				<input type="hidden" id="selected_app_action" value="<?php print($access_roles);?>">
			</div>
		</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
		<div style="width:130px;height:30px;line-height:30px;float:left;">App linkage:*</div>
		<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
			<div style="width:auto;min-height:30px;height:auto;float:left;">

				<div class="option_item" title="Click to change option" onclick="$('#app_linkage_menu').toggle('fast');" id="active_app_linkage" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($app_linkage_title);?></div>
				
				<div class="option_menu" id="app_linkage_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_linkage_menu').toggle('fast');$('#active_app_linkage').html($(this).html());$('#selected_app_linkage').val(1);$('#new_app_error_message').slideUp('fast');">Live environment</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_linkage_menu').toggle('fast');$('#active_app_linkage').html($(this).html());$('#selected_app_linkage').val(0);$('#new_app_error_message').slideUp('fast');">Test environment</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#app_linkage_menu').toggle('fast');$('#active_app_linkage').html($(this).html());$('#selected_app_linkage').val(2);$('#new_app_error_message').slideUp('fast');">Local installation</div>

				</div>
			</div>
			<input type="hidden" id="selected_app_linkage" value="<?php print($app_linkage_id);?>">
		</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;color:red;font-weight:bold;" id="error_message"></div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="app_update_holder">
		<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_app_button" onclick="update_or_create_application(<?php print($app_id);?>);" title="Click to update account details"><?php print($button_text);?></div>
		
		<?php
		if($app_id){
			$new_status = 0;
			$bg_color = 'brown';
			$hover_color = '#bf4242';
			$button_text = 'Disable';
			
			if(!$this_app_results['status']){
				$new_status = 1;
				$bg_color = '#75b675';
				$hover_color = '#8acc8a';
				$button_text = 'Enable';
			}
			?>		
			<div style="width:60px;height:30px;background-color:<?php print($bg_color);?>;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($bg_color);?>';"  id="disable_app_button" onclick="change_app_status(<?php print($new_status.','.$app_id);?>);" title="Click to update account details"><?php print($button_text);?></div>
		<?php
		}
		?>
	</div>
</div>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;" id="access_log_details"></div>

<script>
	$('#tab_100').click();
</script>