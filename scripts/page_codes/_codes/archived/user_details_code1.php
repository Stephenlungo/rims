<?php

if($user_id){
	
	if($user_results['id'] == $user_id){
		$editing = 1;
		
	}
	
	$default_color = '#000';
	$button_text = 'Update';
	$user_name = $this_user_results['_name'];
	$user_nrc = $this_user_results['id_number'];
	$user_date = $this_user_results['_date'];
	$user_sex_id = $this_user_results['gender'];
	$user_email = $this_user_results['email'];
	$user_username = $this_user_results['username'];
	$user_password = $this_user_results['password'];
	$job_title = $this_user_results['responsibility'];
	$user_phone_numbers = $this_user_results['phone'];
	
	$user_group_ids = $this_user_results['user_group_ids'];

	$user_gender = mysqli_query($connect,"select * from genders where id = $user_sex_id")or die(mysqli_error($connect));
	$user_gender_results = mysqli_fetch_array($user_gender,MYSQLI_ASSOC);
	$user_gender_title = $user_gender_results['title'];
	
	$this_division_supervisor = $this_user_results['division_supervisor'];
	
	if(!$this_division_supervisor){
		$this_division_supervisor_title = 'No';
		
	}else{
		$this_division_supervisor_title = 'Yes';
		
	}
	
	$roles = explode(',',$this_user_results['roles']);
	
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
	
	$default_roles = $this_user_results['roles'];
	
}else{
	$user_group_ids = $user_results['user_group_ids'];
	
	$default_color = '#aaa';
	$button_text = 'Create';
	$user_name = 'Enter names for this user here';
	$user_nrc = 'Enter NRC here';
	$user_sex_id = 0;
	$user_gender_title = 'Select Gender';
	$user_date = 0;
	$user_phone_numbers = 'Enter phone numbers here';
	
	$user_email = 'Enter email address here';
	$user_username = time();
	$user_password = 'pipat';
	
	$job_title = 'Enter job title here';
	
	$user_phone_numbers = 'Enter phone number here';
	
	$this_supervisor_name = 'Select option';
	$this_supervisor_id = -1;
	
	$this_department_name = 'Select option';
	$this_department_id = -1;
	
	$this_division_name = 'Select option';
	$this_division_id = -1;
	
	$this_cluster_id = $user_results['branch_id'];
	if(!$this_cluster_id){
		$this_cluster_title = 'Select option';
		$this_cluster_id = -1;
		
	}else{
		$this_cluster = mysqli_query($connect,"select * from branches where id = $this_cluster_id")or die(mysqli_error($connect));
		$this_cluster_results = mysqli_fetch_array($this_cluster,MYSQLI_ASSOC);
		$this_cluster_title = $this_cluster_results['title'];
		
	}
	
	$this_unit_id = $user_results['unit_id'];
	if(!$this_unit_id){
		$this_unit_title = 'Select unit';
		$this_unit_id = -1;
		
	}else{
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		
		if($this_unit_results['status'] == 0){
			$this_unit_title = $this_unit_results['title'].'[Disabled]';
			
		}else{
			$this_unit_title = $this_unit_results['title'];
		}
		
	}
	
	$this_region_id = $user_results['region_id'];
	if(!$this_region_id){
		$this_region_title = 'Select region';
		$this_region_id = -1;
		
	}else{		
		$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
		$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
		
		$this_region_title = $this_region_results['title'];
	}
	
	$this_province_id = $user_results['province_id'];
	if(!$this_province_id){
		$this_province_title = 'All Provinces';
		
	}else{
		$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
		$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
		
		$this_province_title = $this_province_results['title'];		
	}
	
	$this_hub_id = $user_results['hub_id'];
	if(!$this_hub_id){
		$this_hub_title = 'All Hubs';
		
	}else{
		$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
		$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
		
		$this_hub_title = $this_hub_results['title'];
	}
	
	$this_site_id = $user_results['site_id'];
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
		
		$this_site_title = $this_site_results['title'];
	}
	
	$this_division_supervisor = 0;
	$this_division_supervisor_title = 'No';
	
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
	
	$default_roles = $pipat_main_access.','.$pipat_main_data_creation.','.$pipat_main_agent_creation.','.$pipat_main_facility_creation.','.$pipat_main_user_creation.','.$pipat_main_report_view.','.$pipat_main_prep_client_creation.','.$pipat_main_prep_admin.','.$pipat_main_super.','.$pipat_claims_access.','.$pipat_claims_type.','.$pipt_claims_notifications.','.$pipat_bills_access.','.$pipat_bills_type.','.$pipat_bills_notification.','.$pipat_training_access.','.$pipat_training_admin.','.$pipat_logistice_access.','.$pipat_logistics_admin.','.$prep_key_generation;
}


?>

<div class="general_holder" id="user_profile">

<div style="width:49%;float:left;height:auto;">
<div style="width:100%;height:20px;float:left;background-color:#eee;text-align:center;font-weight:bold;">Basic Details</div>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Names*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($user_name);?>"  id="user_name" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter names for this user here'){this.value='';this.style.color='#000'}$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($user_name);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Mobile Numbers*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($user_phone_numbers);?>"  id="user_phone" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter phone number here'){this.value='';this.style.color='#000'}$('#phone_number_error').slideUp('fast');this.style.borderColor='#aaa';$('#new_user_error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='<?php print($user_phone_numbers);?>';this.style.color='<?php print($default_color);?>';}else{check_user_phone_number(<?php print($user_id);?>);}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;margin-bottom:10px;" id="phone_number_error"></div>
<input type="hidden" id="phone_number_error_input" value="0">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">NRC Number*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($user_nrc);?>"  id="user_nrc" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter NRC here'){this.value='';this.style.color='#000'}$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($user_nrc);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>




<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Sex*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#sex_menu').toggle('fast');" id="active_sex" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($user_gender_title);?></div>

			<div class="option_menu" id="sex_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			$gender = mysqli_query($connect,"select * from genders order by title")or die(mysqli_error($connect));
			
			for($g=0;$g<mysqli_num_rows($gender);$g++){
				$gender_results = mysqli_fetch_array($gender,MYSQLI_ASSOC);
				?>
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sex_menu').toggle('fast');$('#active_sex').html($(this).html());$('#user_selected_sex').val(<?php print($gender_results['id']);?>);$('#new_user_error_message').slideUp('fast');"><?php print($gender_results['title']);?></div>
				
				<?php
			}
			?>
					
			</div>
	</div>
	<input type="hidden" id="user_selected_sex" value="<?php print($user_sex_id);?>">
</div>
</div>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Email:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($user_email);?>"  id="user_email" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter email address here'){this.value='';this.style.color='#000'}$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($user_email);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">User Name*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="<?php if(!$editing){print('password');}else{print('text');}?>" style="width:100%;border:solid 1px #aaa;height:30px;color:#000" value="<?php print($user_username);?>"  id="user_username" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='<?php print(time());?>';this.style.color='#000'}" onfocus="$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Password*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="<?php if(!$editing){print('password');}else{print('text');}?>" style="width:100%;border:solid 1px #aaa;height:30px;color:#000" value="<?php print($user_password);?>"  id="user_password" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='pipat';}" onfocus="$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';$('#user_password').css('border-color','#aaa');"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Confirm Password*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="<?php if(!$editing){print('password');}else{print('text');}?>" style="width:100%;border:solid 1px #aaa;height:30px;color:#000" value="<?php print($user_password);?>"  id="user_password_2" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='pipat';'}" onfocus="$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';$('#user_password').css('border-color','#aaa');$('#user_password_2').css('border-color','#aaa');"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Job Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($job_title);?>"  id="user_job_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter job title here'){this.value='';this.style.color='#000'}$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($job_title);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Cluster*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#user_cluster_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify cluster settings for users');<?php }?>" id="active_user_cluster" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_cluster_title);?></div>

			<div class="option_menu" id="user_cluster_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(0);fetch_cluster_user_groups(<?php print('0,'.$user_id);?>);$('#new_user_error_message').slideUp('fast');">Non-clustered</div>
			
			
				<?php
				
					$cluster_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($cluster_menu);$u++){
						$cluster_menu_results = mysqli_fetch_array($cluster_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(<?php print($cluster_menu_results['id']);?>);fetch_cluster_user_groups(<?php print($cluster_menu_results['id'].','.$user_id);?>);$('#new_user_error_message').slideUp('fast');"><?php print($cluster_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_cluster" value="<?php print($this_cluster_id);?>">
	
	<script>
		fetch_cluster_user_groups(<?php print($this_cluster_id.','.$user_id);?>)
	
	</script>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:20px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">User groups*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:20px;border:solid 1px #aaa;">

	<div style="width:100%;min-height:30px;height:auto;float:left;max-height:100px;overflow:auto;" id="user_groups_holder">
	
	
	</div>
	<input type="hidden" id="selected_group_ids" value="<?php print($user_group_ids);?>">
</div>
</div>
</div>
<div style="width:48%;float:right;height:auto;">
<div style="width:100%;height:20px;float:left;background-color:#eee;text-align:center;font-weight:bold;">User Access Restrictions</div>
<div style="width:100%;height:auto;float:left;margin-bottom:2px;margin-top:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Unit*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?>$('#user_unit_menu').toggle('fast');<?php }else{?>  alert('You are not allowed to modify unit settings for users'); <?php }?>" id="active_user_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>

			<div class="option_menu" id="user_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_unit_menu').toggle('fast');$('#active_user_unit').html($(this).html());$('#selected_user_unit').val(0);$('#new_user_error_message').slideUp('fast');">All Units</div>
			
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_unit_menu').toggle('fast');$('#active_user_unit').html($(this).html());$('#selected_user_unit').val(<?php print($unit_menu_results['id']);?>);$('#new_user_error_message').slideUp('fast');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_unit" value="<?php print($this_unit_id);?>">
</div>
</div>



<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#user_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for users');<?php }?>" id="active_user_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="user_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_region_menu').toggle('fast');$('#active_user_region').html($(this).html());$('#selected_user_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#new_user_error_message').slideUp('fast');">All Regions</div>
			
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_region_menu').toggle('fast');$('#active_user_region').html($(this).html());$('#selected_user_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#new_user_error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_region" value="<?php print($this_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#user_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for users');<?php }?>" id="active_user_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="user_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_province_menu').toggle('fast');$('#active_user_province').html($(this).html());$('#selected_user_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'user_hub',1,1,'connect-sites-hub_id-{id}-user_site-1-1');$('#new_user_error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_province" value="<?php print($this_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#user_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for users');<?php }?>" id="active_user_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="user_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_hub_menu').toggle('fast');$('#active_user_hub').html($(this).html());$('#selected_user_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'user_site',1,1,'');$('#new_user_error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_user_hub" value="<?php print($this_hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#user_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorised to modify site settings for users');<?php }?>" id="active_user_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="user_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_site_menu').toggle('fast');$('#active_user_site').html($(this).html());$('#selected_user_site').val(<?php print($site_menu_results['id']);?>);$('#new_user_error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_user_site" value="<?php print($this_site_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Supervisor*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#supervisor_menu').toggle('fast');" id="active_supervisor" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_supervisor_name);?></div>

		<div class="option_menu" id="supervisor_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#supervisor_menu').toggle('fast');$('#active_supervisor').html($(this).html());$('#selected_supervisor').val(0);$('#new_user_error_message').slideUp('fast');">Unspecified</div>
		
			<?php
			
				$supervisor_menu = mysqli_query($connect,"select * from users where company_id = $company_id and id != $active_user_id order by _name")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($supervisor_menu);$s++){
					$supervisor_menu_results = mysqli_fetch_array($supervisor_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#supervisor_menu').toggle('fast');$('#active_supervisor').html($(this).html());$('#selected_supervisor').val(<?php print($supervisor_menu_results['id']);?>);$('#new_user_error_message').slideUp('fast');"><?php print($supervisor_menu_results['_name']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_supervisor" value="<?php print($this_supervisor_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Department*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#department_menu').toggle('fast');" id="active_department" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_department_name);?></div>

		<div class="option_menu" id="department_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$department_menu = mysqli_query($connect,"select * from departments where company_id = $company_id order by title")or die(mysqli_error($connect));

				for($d=0;$d<mysqli_num_rows($department_menu);$d++){
					$department_menu_results = mysqli_fetch_array($department_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#department_menu').toggle('fast');$('#active_department').html($(this).html());$('#selected_department').val(<?php print($department_menu_results['id']);?>);$('#new_user_error_message').slideUp('fast');$('#selected_division_supervisor').val(0);$('#active_division_supervisor').html('No');fetch_menu_items('connect','department_divisions','department_id',<?php print($department_menu_results['id']);?>,'division',1,1,'');"><?php print($department_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_department" value="<?php print($this_department_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Division:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#division_menu').toggle('fast');" id="active_division" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_division_name);?></div>

		<div class="option_menu" id="division_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				if($this_department_id > 0){
					$division_menu = mysqli_query($connect,"select * from department_divisions where department_id = $this_department_id order by title")or die(mysqli_error($connect));

					for($d=0;$d<mysqli_num_rows($division_menu);$d++){
						$division_menu_results = mysqli_fetch_array($division_menu,MYSQLI_ASSOC);
						?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#division_menu').toggle('fast');$('#active_division').html($(this).html());$('#selected_division').val(<?php print($division_menu_results['id']);?>);$('#new_user_error_message').slideUp('fast');"><?php print($division_menu_results['title']);?></div>
						<?php
					}
				}
			?>
			
		</div>
	</div>
	<input type="hidden" id="selected_division" value="<?php print($this_division_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;" id="division_supersor">
<div style="width:140px;height:30px;line-height:30px;float:left;">Division supervisor*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#division_supervisor_menu').toggle('fast');" id="active_division_supervisor" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_division_supervisor_title);?></div>

		<div class="option_menu" id="division_supervisor_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#division_supervisor_menu').toggle('fast');$('#active_division_supervisor').html($(this).html());$('#selected_division_supervisor').val(0);$('#new_user_error_message').slideUp('fast');">No</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#division_supervisor_menu').toggle('fast');$('#new_user_error_message').slideUp('fast');if($('#selected_division').val() < 1){alert('This user needs to be in a division to be supervisor. First select a division from the division menu');}else{$('#active_division_supervisor').html($(this).html());$('#selected_division_supervisor').val(1);}">Yes</div>
			
		</div>
	</div>
	<input type="hidden" id="selected_division_supervisor" value="<?php print($this_division_supervisor);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<input type="hidden" id="this_user_default_roles" value="<?php print($default_roles);?>">
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

" <?php if(!$editing){?> disabled<?php }?> <?php print($pipat_main_access_check); if(!$active_user_roles[0]){print(' disabled ');}?>> <label for="pipat_main_access">Allow access to PIPAT-Main system</label><br>

<input type="hidden" id="pipat_main_access_input" value="<?php print($pipat_main_access);?>">

<input type="checkbox" <?php print($pipat_main_data_creation_check); if(!$active_user_roles[1] || !$roles[0]){print(' disabled ');}?> id="pipat_main_data_creation" onchange="if(this.checked){$('#pipat_main_data_creation_input').val(1);}else{$('#pipat_main_data_creation_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_data_creation">Allow PIPAT-Main data creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_data_creation_input" value="<?php print($pipat_main_data_creation);?>">

<input type="checkbox" <?php print($pipat_main_agent_creation_check); if(!$active_user_roles[2] || !$roles[0]){print(' disabled ');}?> id="pipat_main_agent_creation" onchange="if(this.checked){$('#pipat_main_agent_creation_input').val(1);}else{$('#pipat_main_agent_creation_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_agent_creation">Allow PIPAT-Main agent creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_agent_creation_input" value="<?php print($pipat_main_agent_creation);?>">

<input type="checkbox" <?php print($pipat_main_facility_creation_check); if(!$active_user_roles[3] || !$roles[0]){print(' disabled ');}?> id="pipat_main_facility_creation" onchange="if(this.checked){$('#pipat_main_facility_creation_input').val(1);}else{$('#pipat_main_facility_creation_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_facility_creation">Allow PIPAT-Main facility creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_facility_creation_input" value="<?php print($pipat_main_facility_creation);?>">

<input type="checkbox" <?php print($pipat_main_user_creation_check); if(!$active_user_roles[4] || !$roles[0]){print(' disabled ');}?> id="pipat_main_user_creation" onchange="if(this.checked){$('#pipat_main_user_creation_input').val(1);}else{$('#pipat_main_user_creation_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_user_creation">Allow PIPAT-Main user creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_user_creation_input" value="<?php print($pipat_main_user_creation);?>">

<input type="checkbox" <?php print($pipat_main_report_view_check); if(!$active_user_roles[5] || !$roles[0]){print(' disabled ');}?> id="pipat_main_report_view" onchange="if(this.checked){$('#pipat_main_report_view_input').val(1);}else{$('#pipat_main_report_view_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_report_view">Allow PIPAT-Main report viewing</label><br>
<input type="hidden" id="pipat_main_report_view_input" value="<?php print($pipat_main_report_view);?>">

<input type="checkbox" <?php print($pipat_main_prep_client_creation_check); if(!$active_user_roles[6] || !$roles[0]){print(' disabled ');}?> id="pipat_main_prep_client_creation" onchange="if(this.checked){$('#pipat_main_prep_client_creation_input').val(1);}else{$('#pipat_main_prep_client_creation_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_prep_client_creation">Allow PrEP client creation, editing and deleting</label><br>
<input type="hidden" id="pipat_main_prep_client_creation_input" value="<?php print($pipat_main_prep_client_creation);?>">

<input type="checkbox" <?php print($prep_key_generation_check); if(!$active_user_roles[19] || !$roles[0]){print(' disabled ');}?> id="prep_key_generation" onchange="if(this.checked){$('#prep_key_generation_input').val(1);}else{$('#prep_key_generation_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="prep_key_generation">Allow PrEP decryption key generation</label><br>
<input type="hidden" id="prep_key_generation_input" value="<?php print($prep_key_generation);?>">

<input type="checkbox" <?php print($pipat_main_prep_admin_check); if(!$active_user_roles[7] || !$roles[0]){print(' disabled ');}?> id="pipat_main_prep_admin" onchange="if(this.checked){$('#pipat_main_prep_admin_input').val(1);}else{$('#pipat_main_prep_admin_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_prep_admin">Allow PrEP administration</label><br>
<input type="hidden" id="pipat_main_prep_admin_input" value="<?php print($pipat_main_prep_admin);?>">

<input type="checkbox" <?php print($pipat_main_super_check); if(!$active_user_roles[8] || !$roles[0]){print(' disabled ');}?> id="pipat_main_super" onchange="if(this.checked){$('#pipat_main_super_input').val(1);}else{$('#pipat_main_super_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_main_super">Allow PIPAT-Main super administrative roles</label><br>
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
	
	<?php if(!$editing){?> disabled<?php }?>> <label for="pipat_claims_access" >Allow access to PIPAT Claims Tracker</label><br>
<input type="hidden" id="pipat_claims_access_input" value="<?php print($pipat_claims_access);?>">

<input type="checkbox" <?php print($pipat_claims_type_check); if(!$active_user_roles[10] || !$roles[9]){print(' disabled ');}?> id="pipat_claims_type" onchange="if(this.checked){$('#pipat_claims_type_input').val(1);}else{$('#pipat_claims_type_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_claims_type">Allow payment claim type creation, editing and deleting</label><br>
<input type="hidden" id="pipat_claims_type_input" value="<?php print($pipat_claims_type);?>">

<input type="checkbox" <?php print($pipt_claims_notifications_check); if(!$active_user_roles[11] || !$roles[9]){print(' disabled ');}?> id="pipt_claims_notifications" onchange="if(this.checked){$('#pipt_claims_notifications_input').val(1);}else{$('#pipt_claims_notifications_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipt_claims_notifications">Enable PIPAT Claims Tracker notifications</label><br>
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
	<?php if(!$editing){?> disabled<?php }?>> <label for="pipat_bills_access">Allow access to PIPAT Bill Tracker</label><br>
<input type="hidden" id="pipat_bills_access_input" value="<?php print($pipat_bills_access);?>">

<input type="checkbox" <?php print($pipat_bills_type_check); if(!$active_user_roles[13] || !$roles[12]){print(' disabled ');}?> id="pipat_bills_type" onchange="if(this.checked){$('#pipat_bills_type_input').val(1);}else{$('#pipat_bills_type_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_bills_type">Allow bill type creation, editing and deleting</label><br>
<input type="hidden" id="pipat_bills_type_input" value="<?php print($pipat_bills_type);?>">

<input type="checkbox" <?php print($pipat_bills_notification_check); if(!$active_user_roles[14] || !$roles[12]){print(' disabled ');}?> id="pipat_bills_notification" onchange="if(this.checked){$('#pipat_bills_notification_input').val(1);}else{$('#pipat_bills_notification_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_bills_notification">Enable PIPAT Bill Tracker notifications</label><br>
<input type="hidden" id="pipat_bills_notification_input" value="<?php print($pipat_bills_notification);?>">
<br>
<input type="checkbox" <?php print($pipat_training_access_check); if(!$active_user_roles[15]){print(' disabled ');}?> id="pipat_training_access" onchange="
	if(this.checked){
		$('#pipat_training_access_input').val(1);
		<?php if($active_user_roles[16]){?> document.getElementById('pipat_training_admin').disabled = false;document.getElementById('pipat_training_admin').checked = false; <?php }?>
	
	}else{
		$('#pipat_training_access_input').val(0);
		<?php if($active_user_roles[16]){?> document.getElementById('pipat_training_admin').disabled = true;$('#pipat_training_admin_input').val(0); <?php }?>
		
	}" 
		
		<?php if(!$editing){?> disabled<?php }?>> <label for="pipat_training_access">Allow access to PIPAT Training Manager</label><br>
<input type="hidden" id="pipat_training_access_input" value="<?php print($pipat_training_access);?>">

<input type="checkbox" <?php print($pipat_training_admin_check); if(!$active_user_roles[16] || !$roles[15]){print(' disabled ');}?> id="pipat_training_admin" onchange="if(this.checked){	$('#pipat_training_admin_input').val(1);}else{$('#pipat_training_admin_input').val(0);}"<?php if(!$editing){?> disabled<?php }?>> <label for="pipat_training_admin">Allow PIPAT Training Manager course administration</label><br><br>
<input type="hidden" id="pipat_training_admin_input" value="<?php print($pipat_training_admin);?>">

<input type="checkbox" <?php print($pipat_logistice_access_check); if(!$active_user_roles[17]){print(' disabled ');}?> id="pipat_logistice_access" onchange="
	
	if(this.checked){
		$('#pipat_logistice_access_input').val(1);
		<?php if($active_user_roles[18]){?> document.getElementById('pipat_logistics_admin').disabled = false;document.getElementById('pipat_logistics_admin').checked = false; <?php }?>
		
	}else{
		$('#pipat_logistice_access_input').val(0);
		<?php if($active_user_roles[18]){?> document.getElementById('pipat_logistics_admin').disabled = true;$('#pipat_logistics_admin_input').val(0);<?php }?>
		
	}" 
		
		<?php if(!$editing){?> disabled<?php }?>> <label for="pipat_logistice_access">Allow access to PIPAT Logistics Manager</label><br>
<input type="hidden" id="pipat_logistice_access_input" value="<?php print($pipat_logistice_access);?>">

<input type="checkbox" <?php print($pipat_logistics_admin_check); if(!$active_user_roles[18] || !$roles[17]){print(' disabled ');}?> id="pipat_logistics_admin" onchange="if(this.checked){$('#pipat_logistics_admin_input').val(1);}else{$('#pipat_logistics_admin_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="pipat_logistics_admin" >Allow PIPAT Logistics Manager vehicle administration</label><br>
<input type="hidden" id="pipat_logistics_admin_input" value="<?php print($pipat_logistics_admin);?>">

</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="new_user_error_message"></div>

<?php if($editing){?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="user_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_user_button" onclick="update_or_create_user(<?php print($user_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($user_id and $active_user_id != $this_user_results['id']){
	if($this_user_results['status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_user_button" onclick="disable_user(<?php print($user_id);?>);" title="Click to disable the account">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="enable_user_button" onclick="enable_user(<?php print($user_id);?>);" title="Click to activate the account">Enable</div>
	
	<script>
		check_user_phone_number(<?php print($user_id);?>);
	</script>
<?php
		
	}
}
?>
</div>
<?php
}
?>

</div>