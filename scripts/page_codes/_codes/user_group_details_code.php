<?php

if($user_group_id){
	$default_color = '#000';
	$button_text = 'Update';
	$user_name = $this_user_group_results['title'];
	$user_group_details = $this_user_group_results['details'];
	
	$pipat_main_access = $roles[0];
	if($pipat_main_access){
		$pipat_main_access_check = ' checked ';
		
	}else{
		$pipat_main_access_check = '';
	}
	
	$pipat_main_data_creation = $roles[1];
	if($pipat_main_data_creation){
		$pipat_main_data_creation_check = ' checked ';
		
	}else{
		$pipat_main_data_creation_check = '';		
	}
	
	$pipat_main_agent_creation = $roles[2];
	if($pipat_main_agent_creation){
		$pipat_main_agent_creation_check = ' checked ';
		
	}else{
		$pipat_main_agent_creation_check = '';		
	}
	
	$pipat_main_facility_creation = $roles[3];
	if($pipat_main_facility_creation){
		$pipat_main_facility_creation_check = ' checked ';
		
	}else{
		$pipat_main_facility_creation_check = '';		
	}
	
	$pipat_main_user_creation = $roles[4];
	if($pipat_main_user_creation){
		$pipat_main_user_creation_check = ' checked ';
		
	}else{
		$pipat_main_user_creation_check = '';
	}
	
	$pipat_main_report_view = $roles[5];
	if($pipat_main_report_view){
		$pipat_main_report_view_check = ' checked ';
		
	}else{
		$pipat_main_report_view_check = '';		
	}
	
	$pipat_main_prep_client_creation = $roles[6];
	if($pipat_main_prep_client_creation){
		$pipat_main_prep_client_creation_check = ' checked ';
		
	}else{
		$pipat_main_prep_client_creation_check = '';		
	}
	
	$pipat_main_prep_admin = $roles[7];
	if($pipat_main_prep_admin){
		$pipat_main_prep_admin_check = ' checked ';
		
	}else{
		$pipat_main_prep_admin_check = '';		
	}
	
	$pipat_main_super = $roles[8];
	if($pipat_main_super){
		$pipat_main_super_check = ' checked ';
		
	}else{
		$pipat_main_super_check = '';		
	}
	
	$pipat_claims_access = $roles[9];
	if($pipat_claims_access){
		$pipat_claims_access_check = ' checked ';
		
	}else{
		$pipat_claims_access_check = '';		
	}
	
	$pipat_claims_type = $roles[10];
	if($pipat_claims_type){
		$pipat_claims_type_check = ' checked ';
		
	}else{
		$pipat_claims_type_check = '';		
	}
	
	$pipt_claims_notifications = $roles[11];
	if($pipt_claims_notifications){
		$pipt_claims_notifications_check = ' checked ';
		
	}else{
		$pipt_claims_notifications_check = '';		
	}
	
	$pipat_bills_access = $roles[12];
	if($pipat_bills_access){
		$pipat_bills_access_check = ' checked ';
		
	}else{
		$pipat_bills_access_check = '';		
	}
	
	$pipat_bills_type = $roles[13];
	if($pipat_bills_type){
		$pipat_bills_type_check = ' checked ';
		
	}else{
		$pipat_bills_type_check = '';		
	}
	
	$pipat_bills_notification = $roles[14];
	if($pipat_bills_notification){
		$pipat_bills_notification_check = ' checked ';
		
	}else{
		$pipat_bills_notification_check = '';		
	}
	
	$pipat_training_access = $roles[15];
	if($pipat_training_access){
		$pipat_training_access_check = ' checked ';
		
	}else{
		$pipat_training_access_check = '';		
	}
	
	$pipat_training_admin = $roles[16];
	if($pipat_training_admin){
		$pipat_training_admin_check = ' checked ';
		
	}else{
		$pipat_training_admin_check = '';		
	}
	
	$pipat_logistice_access = $roles[17];
	if($pipat_logistice_access){
		$pipat_logistice_access_check = ' checked ';
		
	}else{
		$pipat_logistice_access_check = '';		
	}
	
	$pipat_logistics_admin = $roles[18];
	if($pipat_logistics_admin){
		$pipat_logistics_admin_check = ' checked ';
		
	}else{
		$pipat_logistics_admin_check = '';		
	}
	
	$prep_key_generation = $roles[19];
	if($prep_key_generation){
		$prep_key_generation_check = ' checked ';
		
	}else{
		$prep_key_generation_check = '';		
	}
	
}else{
	$default_color = '#aaa';
	$button_text = 'Create';
	$user_name = 'Enter group name here';
	$user_group_details =  'Please enter details here';
	
	$this_supervisor_name = 'Unspecified';
	$this_supervisor_date = 0;
	
	
	$this_cluster_id = $user_results['branch_id'];
	if(!$this_cluster_id){
		$this_cluster_title = 'Non-Clustered';
		$this_cluster_id = 0;
		
	}else{
		$this_cluster = mysqli_query($connect,"select * from branches where id = $this_cluster_id")or die(mysqli_error($connect));
		$this_cluster_results = mysqli_fetch_array($this_cluster,MYSQLI_ASSOC);
		$this_cluster_title = $this_cluster_results['title'];
		
	}
	
	if($active_user_roles[0]){
		$pipat_main_access = 1;
		$pipat_main_access_check = ' checked ';
		
	}else{
		$pipat_main_access = 0;
		$pipat_main_access_check = ' ';
	}
		
	if($active_user_roles[1]){			
		$pipat_main_data_creation = 1;
		$pipat_main_data_creation_check = ' checked ';
		
	}else{
		$pipat_main_data_creation = 0;
		$pipat_main_data_creation_check = ' ';
		
	}
	
	if($active_user_roles[2]){		
		$pipat_main_agent_creation = 1;
		$pipat_main_agent_creation_check = ' checked ';
		
	}else{
		$pipat_main_agent_creation = 1;
		$pipat_main_agent_creation_check = ' ';
		
	}
	
	$pipat_main_facility_creation = 0;
	$pipat_main_facility_creation_check = ' ';
	
	$pipat_main_user_creation = 0;
	$pipat_main_user_creation_check = '';		
	
	if($active_user_roles[5]){	
		$pipat_main_report_view = 1;
		$pipat_main_report_view_check = ' checked ';
		
	}else{
		$pipat_main_report_view = 0;
		$pipat_main_report_view_check = ' ';
		
	}
	
	$pipat_main_prep_client_creation = 0;
	$pipat_main_prep_client_creation_check = '';
	
	$pipat_main_prep_admin = 0;
	$pipat_main_prep_admin_check = '';
	
	$pipat_main_super = 0;
	$pipat_main_super_check = ' ';
	
	if($active_user_roles[9]){
		$pipat_claims_access = 1;
		$pipat_claims_access_check = ' checked ';
		
	}else{
		$pipat_claims_access = 0;
		$pipat_claims_access_check = ' ';
		
	}	
	
	$pipat_claims_type = 0;
	$pipat_claims_type_check = ' ';
	
	if($active_user_roles[11]){
		$pipt_claims_notifications = 1;
		$pipt_claims_notifications_check = ' checked ';
		
	}else{
		$pipt_claims_notifications = 0;
		$pipt_claims_notifications_check = ' ';
		
	}
	
	if($active_user_roles[12]){
		$pipat_bills_access = 1;
		$pipat_bills_access_check = ' checked ';
	
	}else{
		$pipat_bills_access = 0;
		$pipat_bills_access_check = ' ';
		
	}
	
	$pipat_bills_type = 0;
	$pipat_bills_type_check = '';	

	if($active_user_roles[14]){	
		$pipat_bills_notification = 1;
		$pipat_bills_notification_check = ' checked ';
		
	}else{
		$pipat_bills_notification = 0;
		$pipat_bills_notification_check = ' ';
		
	}
	
	if($active_user_roles[15]){	
		$pipat_training_access = 1;
		$pipat_training_access_check = ' checked ';
	
	}else{
		$pipat_training_access = 0;
		$pipat_training_access_check = ' ';
		
	}
	
	$pipat_training_admin = 0;
	$pipat_training_admin_check = '';		
	
	if($active_user_roles[17]){	
		$pipat_logistice_access = 1;
		$pipat_logistice_access_check = ' checked ';
	
	}else{
		$pipat_logistice_access = 0;
		$pipat_logistice_access_check = '  ';
		
	}
	
	$pipat_logistics_admin = 0;
	$pipat_logistics_admin_check = '';
	
	$prep_key_generation = 0;
	$prep_key_generation_check = '';
	
	$roles = array($pipat_main_access,$pipat_main_data_creation,$pipat_main_agent_creation,$pipat_main_facility_creation,$pipat_main_user_creation,$pipat_main_report_view,$pipat_main_prep_client_creation,$pipat_main_prep_admin,$pipat_main_super,$pipat_claims_access,$pipat_claims_type,$pipt_claims_notifications,$pipat_bills_access,$pipat_bills_type,$pipat_bills_notification,$pipat_training_access,$pipat_training_admin,$pipat_logistice_access,$pipat_logistics_admin,$prep_key_generation);
	
}
?>

<div class="general_holder" id="user_profile">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($user_name);?>"  id="user_group_name" onfocus="if(this.value=='Enter group name here'){this.value='';this.style.color='#000'}$('#new_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($user_name);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Cluster*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#user_cluster_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify cluster settings for users');<?php }?>" id="active_user_cluster" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_cluster_title);?></div>

			<div class="option_menu" id="user_cluster_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(0);$('#new_error_message').slideUp('fast');">Non-clustered</div>
			
			
				<?php
				
					$cluster_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($cluster_menu);$u++){
						$cluster_menu_results = mysqli_fetch_array($cluster_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(<?php print($cluster_menu_results['id']);?>);$('#new_error_message').slideUp('fast');"><?php print($cluster_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_cluster" value="<?php print($this_cluster_id);?>">
</div>
</div>


<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Supervisor:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#supervisor_menu').toggle('fast');" id="active_supervisor" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_supervisor_name);?></div>

		<div class="option_menu" id="supervisor_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#supervisor_menu').toggle('fast');$('#active_supervisor').html($(this).html());$('#selected_supervisor').val(0);$('#new_error_message').slideUp('fast');">Unspecified</div>
		
			<?php
			
				$supervisor_menu = mysqli_query($connect,"select * from users where company_id = $company_id and id != $active_user_id order by _name")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($supervisor_menu);$s++){
					$supervisor_menu_results = mysqli_fetch_array($supervisor_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#supervisor_menu').toggle('fast');$('#active_supervisor').html($(this).html());$('#selected_supervisor').val(<?php print($supervisor_menu_results['_date']);?>);$('#new_error_message').slideUp('fast');"><?php print($supervisor_menu_results['_name']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_supervisor" value="<?php print($this_supervisor_date);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;color:purple;margin-bottom:10px;">Note: The access roles on the supervisor's account will be updated to the minimum of the roles specified on this group setting.</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Details:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<textarea style="min-width:100%;max-width:100%;height:40px;min-height:40px;font-size:0.9em;font-family:arial;color:<?php print($default_color);?>;" onfocus="if(this.value=='Please enter details here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Please enter details here';this.style.color='#aaa';}" id="group_details"><?php print($user_group_details);?></textarea>
	</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="cursor:pointer;width:100%;float:left;height:20px;background-color:#ddf;margin-top:2px;line-height:20px;text-align:left;" onclick="$('#pipat_main_rules').slideToggle('fast');" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';">PIPAT Main restrictions</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;background-color:#eef" id="pipat_main_rules">
<input type="checkbox" <?php print($pipat_main_access_check);?> id="pipat_main_access" onchange="
	if(this.checked){
		$('#pipat_main_access_input').val(1);
		
		<?php if($active_user_roles[1]){?> document.getElementById('pipat_main_data_creation').disabled = false;document.getElementById('pipat_main_data_creation').checked = false; <?php }?>
		
		<?php if($active_user_roles[2]){?> document.getElementById('pipat_main_agent_creation').disabled = false;document.getElementById('pipat_main_agent_creation').checked = false; <?php }?>
		
		<?php if($active_user_roles[3]){?> document.getElementById('pipat_main_facility_creation').disabled = false;document.getElementById('pipat_main_facility_creation').checked = false; <?php }?>
		
		<?php if($active_user_roles[4]){?> document.getElementById('pipat_main_user_creation').disabled = false;document.getElementById('pipat_main_user_creation').checked = false; <?php }?>
		
		<?php if($active_user_roles[5]){?> document.getElementById('pipat_main_report_view').disabled = false;document.getElementById('pipat_main_report_view').checked = false; <?php }?>
		
		<?php if($active_user_roles[6]){?> document.getElementById('pipat_main_prep_client_creation').disabled = false;document.getElementById('pipat_main_prep_client_creation').checked = false; <?php }?>
		
		<?php if($active_user_roles[7]){?> document.getElementById('pipat_main_prep_admin').disabled = false;document.getElementById('pipat_main_prep_admin').checked = false; <?php }?>
		
		<?php if($active_user_roles[8]){?> 
		document.getElementById('pipat_main_super').disabled = false;document.getElementById('pipat_main_super').checked = false; <?php }?>
		
		<?php if($active_user_roles[19]){?> 
		document.getElementById('prep_key_generation').disabled = false;document.getElementById('prep_key_generation').checked = false; <?php }?>
		
	}else{
		$('#pipat_main_access_input').val(0);
		
		<?php if($active_user_roles[1]){?> document.getElementById('pipat_main_data_creation').disabled = true; <?php }?>
		
		$('#pipat_main_data_creation_input').val(0);
		
		<?php if($active_user_roles[2]){?> document.getElementById('pipat_main_agent_creation').disabled = true; <?php }?>
		$('#pipat_main_agent_creation_input').val(0);
		
		<?php if($active_user_roles[3]){?> document.getElementById('pipat_main_facility_creation').disabled = true; <?php }?>
		$('#pipat_main_facility_creation_input').val(0);
		
		<?php if($active_user_roles[4]){?> document.getElementById('pipat_main_user_creation').disabled = true; <?php }?>
		$('#pipat_main_user_creation_input').val(0);
		
		<?php if($active_user_roles[5]){?> document.getElementById('pipat_main_report_view').disabled = true; <?php }?>
		$('#pipat_main_report_view_input').val(0);
		
		<?php if($active_user_roles[6]){?> document.getElementById('pipat_main_prep_client_creation').disabled = true; <?php }?>
		$('#pipat_main_prep_client_creation_input').val(0);
		
		<?php if($active_user_roles[7]){?> document.getElementById('pipat_main_prep_admin').disabled = true; <?php }?>
		$('#pipat_main_prep_admin_input').val(0);
		
		<?php if($active_user_roles[8]){?> document.getElementById('pipat_main_super').disabled = true; <?php }?>
		$('#pipat_main_super_input').val(0);
		
		<?php if($active_user_roles[19]){?> document.getElementById('prep_key_generation').disabled = true; <?php }?>
		$('#prep_key_generation_input').val(0);

	}

" <?php print($pipat_main_access_check); if(!$active_user_roles[0]){print(' disabled ');}?>> <label for="pipat_main_access">Allow access to PIPAT-Main system</label><br>

<input type="hidden" id="pipat_main_access_input" value="<?php print($pipat_main_access);?>">

<input type="checkbox" <?php print($pipat_main_data_creation_check); if(!$active_user_roles[1] || !$roles[0]){print(' disabled ');}?> id="pipat_main_data_creation" onchange="if(this.checked){$('#pipat_main_data_creation_input').val(1);}else{$('#pipat_main_data_creation_input').val(0);}"> <label for="pipat_main_data_creation">Allow PIPAT-Main data creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_data_creation_input" value="<?php print($pipat_main_data_creation);?>">

<input type="checkbox" <?php print($pipat_main_agent_creation_check); if(!$active_user_roles[2] || !$roles[0]){print(' disabled ');}?> id="pipat_main_agent_creation" onchange="if(this.checked){$('#pipat_main_agent_creation_input').val(1);}else{$('#pipat_main_agent_creation_input').val(0);}"> <label for="pipat_main_agent_creation">Allow PIPAT-Main agent creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_agent_creation_input" value="<?php print($pipat_main_agent_creation);?>">

<input type="checkbox" <?php print($pipat_main_facility_creation_check); if(!$active_user_roles[3] || !$roles[0]){print(' disabled ');}?> id="pipat_main_facility_creation" onchange="if(this.checked){$('#pipat_main_facility_creation_input').val(1);}else{$('#pipat_main_facility_creation_input').val(0);}"> <label for="pipat_main_facility_creation">Allow PIPAT-Main facility creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_facility_creation_input" value="<?php print($pipat_main_facility_creation);?>">

<input type="checkbox" <?php print($pipat_main_user_creation_check); if(!$active_user_roles[4] || !$roles[0]){print(' disabled ');}?> id="pipat_main_user_creation" onchange="if(this.checked){$('#pipat_main_user_creation_input').val(1);}else{$('#pipat_main_user_creation_input').val(0);}"> <label for="pipat_main_user_creation">Allow PIPAT-Main user creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_user_creation_input" value="<?php print($pipat_main_user_creation);?>">

<input type="checkbox" <?php print($pipat_main_report_view_check); if(!$active_user_roles[5] || !$roles[0]){print(' disabled ');}?> id="pipat_main_report_view" onchange="if(this.checked){$('#pipat_main_report_view_input').val(1);}else{$('#pipat_main_report_view_input').val(0);}"> <label for="pipat_main_report_view">Allow PIPAT-Main report viewing</label><br>
<input type="hidden" id="pipat_main_report_view_input" value="<?php print($pipat_main_report_view);?>">

<input type="checkbox" <?php print($pipat_main_prep_client_creation_check); if(!$active_user_roles[6] || !$roles[0]){print(' disabled ');}?> id="pipat_main_prep_client_creation" onchange="if(this.checked){$('#pipat_main_prep_client_creation_input').val(1);}else{$('#pipat_main_prep_client_creation_input').val(0);}"> <label for="pipat_main_prep_client_creation">Allow PrEP client creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_prep_client_creation_input" value="<?php print($pipat_main_prep_client_creation);?>">

<input type="checkbox" <?php print($prep_key_generation_check); if(!$active_user_roles[19] || !$roles[0]){print(' disabled ');}?> id="prep_key_generation" onchange="if(this.checked){$('#prep_key_generation_input').val(1);}else{$('#prep_key_generation_input').val(0);}" > <label for="prep_key_generation">Allow PrEP decryption key generation</label><br>
<input type="hidden" id="prep_key_generation_input" value="<?php print($prep_key_generation);?>">

<input type="checkbox" <?php print($pipat_main_prep_admin_check); if(!$active_user_roles[7] || !$roles[0]){print(' disabled ');}?> id="pipat_main_prep_admin" onchange="if(this.checked){$('#pipat_main_prep_admin_input').val(1);}else{$('#pipat_main_prep_admin_input').val(0);}"> <label for="pipat_main_prep_admin">Allow PrEP administration</label><br>
<input type="hidden" id="pipat_main_prep_admin_input" value="<?php print($pipat_main_prep_admin);?>">

<input type="checkbox" <?php print($pipat_main_super_check); if(!$active_user_roles[8] || !$roles[0]){print(' disabled ');}?> id="pipat_main_super" onchange="if(this.checked){$('#pipat_main_super_input').val(1);}else{$('#pipat_main_super_input').val(0);}" > <label for="pipat_main_super">Allow PIPAT-Main super administrative roles</label><br>
<input type="hidden" id="pipat_main_super_input" value="<?php print($pipat_main_super);?>">
</div>


<div style="cursor:pointer;width:100%;float:left;height:20px;background-color:#ddf;margin-top:2px;line-height:20px;text-align:left;" onclick="$('#pipat_claims_tracker_rules').slideToggle('fast');" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';">PIPAT Claims Tracker restrictions</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;background-color:#eef;" id="pipat_claims_tracker_rules">
<input type="checkbox" <?php print($pipat_claims_access_check); if(!$active_user_roles[9]){print(' disabled ');}?> id="pipat_claims_access" onchange="
if(this.checked){
	$('#pipat_claims_access_input').val(1);
	
	<?php if($active_user_roles[10]){?> document.getElementById('pipat_claims_type').disabled = false;document.getElementById('pipat_claims_type').checked = false; <?php }?>
	
	<?php if($active_user_roles[11]){?> document.getElementById('pipt_claims_notifications').disabled = false;document.getElementById('pipt_claims_notifications').checked = false; <?php }?>
	
	}else{
		$('#pipat_claims_access_input').val(0);
		
		<?php if($active_user_roles[10]){?> document.getElementById('pipat_claims_type').disabled = true;$('#pipat_claims_type_input').val(0); <?php }?>
	
	<?php if($active_user_roles[11]){?> document.getElementById('pipt_claims_notifications').disabled = true;$('#pipt_claims_notifications_input').val(0);<?php }?>
		
	}" 
	
> <label for="pipat_claims_access" >Allow access to PIPAT Claims Tracker</label><br>
<input type="hidden" id="pipat_claims_access_input" value="<?php print($pipat_claims_access);?>">

<input type="checkbox" <?php print($pipat_claims_type_check); if(!$active_user_roles[10] || !$roles[9]){print(' disabled ');}?> id="pipat_claims_type" onchange="if(this.checked){$('#pipat_claims_type_input').val(1);}else{$('#pipat_claims_type_input').val(0);}"> <label for="pipat_claims_type">Allow payment claim type creation, editing and deleting</label><br>
<input type="hidden" id="pipat_claims_type_input" value="<?php print($pipat_claims_type);?>">

<input type="checkbox" <?php print($pipt_claims_notifications_check); if(!$active_user_roles[11] || !$roles[9]){print(' disabled ');}?> id="pipt_claims_notifications" onchange="if(this.checked){$('#pipt_claims_notifications_input').val(1);}else{$('#pipt_claims_notifications_input').val(0);}"> <label for="pipt_claims_notifications">Enable PIPAT Claims Tracker notifications</label><br>
<input type="hidden" id="pipt_claims_notifications_input" value="<?php print($pipt_claims_notifications);?>">
</div>

<div style="cursor:pointer;width:100%;float:left;height:20px;background-color:#ddf;margin-top:2px;line-height:20px;text-align:left;" onclick="$('#pipat_bill_tracker_rules').slideToggle('fast');" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';">Other restrictions</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;background-color:#eef;" id="pipat_bill_tracker_rules">
<input type="checkbox" <?php print($pipat_bills_access_check); if(!$active_user_roles[12]){print(' disabled ');}?> id="pipat_bills_access" onchange="
	if(this.checked){
		$('#pipat_bills_access_input').val(1);
		<?php if($active_user_roles[13]){?> document.getElementById('pipat_bills_type').disabled = false;document.getElementById('pipat_bills_type').checked = false; <?php }?>
		
		<?php if($active_user_roles[14]){?> document.getElementById('pipat_bills_notification').disabled = false;document.getElementById('pipat_bills_notification').checked = false; <?php }?>
	
	}else{
		$('#pipat_bills_access_input').val(0);
		
		<?php if($active_user_roles[13]){?> document.getElementById('pipat_bills_type').disabled = true;$('#pipat_bills_type_input').val(0); <?php }?>
	
	<?php if($active_user_roles[14]){?> document.getElementById('pipat_bills_notification').disabled = true;$('#pipat_bills_notification_input').val(0);<?php }?>
		
	}" 
	> <label for="pipat_bills_access">Allow access to PIPAT Bill Tracker</label><br>
<input type="hidden" id="pipat_bills_access_input" value="<?php print($pipat_bills_access);?>">

<input type="checkbox" <?php print($pipat_bills_type_check); if(!$active_user_roles[13] || !$roles[12]){print(' disabled ');}?> id="pipat_bills_type" onchange="if(this.checked){$('#pipat_bills_type_input').val(1);}else{$('#pipat_bills_type_input').val(0);}" > <label for="pipat_bills_type">Allow bill type creation, editing and deleting</label><br>
<input type="hidden" id="pipat_bills_type_input" value="<?php print($pipat_bills_type);?>">

<input type="checkbox" <?php print($pipat_bills_notification_check); if(!$active_user_roles[14] || !$roles[12]){print(' disabled ');}?> id="pipat_bills_notification" onchange="if(this.checked){$('#pipat_bills_notification_input').val(1);}else{$('#pipat_bills_notification_input').val(0);}"> <label for="pipat_bills_notification">Enable PIPAT Bill Tracker notifications</label><br>
<input type="hidden" id="pipat_bills_notification_input" value="<?php print($pipat_bills_notification);?>">
<br>
<input type="checkbox" <?php print($pipat_training_access_check); if(!$active_user_roles[15]){print(' disabled ');}?> id="pipat_training_access" onchange="
	if(this.checked){
		$('#pipat_training_access_input').val(1);
		<?php if($active_user_roles[16]){?> document.getElementById('pipat_training_admin').disabled = false;document.getElementById('pipat_training_admin').checked = false; <?php }?>
	
	}else{
		$('#pipat_training_access_input').val(0);
		<?php if($active_user_roles[16]){?> document.getElementById('pipat_training_admin').disabled = true;$('#pipat_training_admin_input').val(0); <?php }?>
		
	}" > <label for="pipat_training_access">Allow access to PIPAT Training Manager</label><br>
<input type="hidden" id="pipat_training_access_input" value="<?php print($pipat_training_access);?>">

<input type="checkbox" <?php print($pipat_training_admin_check); if(!$active_user_roles[16] || !$roles[15]){print(' disabled ');}?> id="pipat_training_admin" onchange="if(this.checked){	$('#pipat_training_admin_input').val(1);}else{$('#pipat_training_admin_input').val(0);}"> <label for="pipat_training_admin">Allow PIPAT Training Manager course administration</label><br><br>
<input type="hidden" id="pipat_training_admin_input" value="<?php print($pipat_training_admin);?>">

<input type="checkbox" <?php print($pipat_logistice_access_check); if(!$active_user_roles[17]){print(' disabled ');}?> id="pipat_logistice_access" onchange="
	
	if(this.checked){
		$('#pipat_logistice_access_input').val(1);
		<?php if($active_user_roles[18]){?> document.getElementById('pipat_logistics_admin').disabled = false;document.getElementById('pipat_logistics_admin').checked = false; <?php }?>
		
	}else{
		$('#pipat_logistice_access_input').val(0);
		<?php if($active_user_roles[18]){?> document.getElementById('pipat_logistics_admin').disabled = true;$('#pipat_logistics_admin_input').val(0);<?php }?>
		
	}" 
		
> <label for="pipat_logistice_access">Allow access to PIPAT Logistics Manager</label><br>
<input type="hidden" id="pipat_logistice_access_input" value="<?php print($pipat_logistice_access);?>">

<input type="checkbox" <?php print($pipat_logistics_admin_check); if(!$active_user_roles[18] || !$roles[17]){print(' disabled ');}?> id="pipat_logistics_admin" onchange="if(this.checked){$('#pipat_logistics_admin_input').val(1);}else{$('#pipat_logistics_admin_input').val(0);}"> <label for="pipat_logistics_admin" >Allow PIPAT Logistics Manager vehicle administration</label><br>
<input type="hidden" id="pipat_logistics_admin_input" value="<?php print($pipat_logistics_admin);?>">

</div>
</div>
<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="new_error_message"></div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="user_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_user_group_button" onclick="update_or_create_user_group(<?php print($user_group_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($user_group_id){
	if($this_user_group_results['status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_user_group_button" onclick="disable_user_group(<?php print($this_user_group_results['id']);?>);" title="Click to disable this item">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="enable_user_group_button" onclick="enable_user_group(<?php print($this_user_group_results['id']);?>);" title="Click to disable this item">Enable</div>
<?php
		
	}
}
?>
</div>
</div>