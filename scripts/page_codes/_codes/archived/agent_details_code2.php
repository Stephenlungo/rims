

<div style="width:100%;border-bottom:solid 1px #eee;margin-top:-3px;margin-bottom:5px;float:left;background-color:#eee">
<div class="general_menu_holder" style="height:25px;line-height:25px;width:363px;">
<div class="tab" style="height:25px;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_10" onclick="$('#agent_profile').fadeIn('fast');$('#agent_targets').hide();$('#agent_entries').hide();tab_item_change(10);change_window_size('agent_details',800,500,1)">Profile</div>

<?php
if($agent_id){
	?>
<div class="tab" style="height:25px;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_11" onclick="$('#agent_profile').hide();$('#agent_targets').hide();$('#agent_entries').fadeIn('fast');tab_item_change(11);change_window_size('agent_details',985,500,1);$('#last_entry_id').val(0);$('#detailed_list_holder').html('');fetch_agent_entries(<?php print($this_agent_results['id']);?>);">Entries</div>

<div class="tab" style="height:25px;line-height:25px;border-right:none;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_12" onclick="$('#agent_profile').hide();$('#agent_entries').hide();$('#agent_targets').fadeIn('fast');tab_item_change(12);change_window_size('agent_details',500,500,1);$('#agent_targets').fadeIn('fast');fetch_agent_targets(<?php print($this_agent_results['id']);?>);">Targets</div>

<?php
}
?>
</div>
</div>
<input type="hidden" id="selected_agent" value="<?php print($this_agent_results['id']);?>">
<?php

	
if($agent_id){
	$default_color = '#000';
	$button_text = 'Update';
	$agent_name = $this_agent_results['_name'];
	$agent_nrc = $this_agent_results['id_number'];
	$agent_date = $this_agent_results['_date'];
	$agent_sex_id = $this_agent_results['gender'];
	$agent_email = $this_agent_results['email'];
	$agent_username = $this_agent_results['username'];
	$agent_password = $this_agent_results['password'];
	$job_title = $this_agent_results['responsibility'];
	
	$agent_gender = mysqli_query($connect,"select * from genders where id = $agent_sex_id")or die(mysqli_error($connect));
	$agent_gender_results = mysqli_fetch_array($agent_gender,MYSQLI_ASSOC);
	$agent_gender_title = $agent_gender_results['title'];
	
	$this_agent_type_id = $this_agent_results['agent_type_id'];
	
	
	$roles = explode(',',$this_agent_results['roles']);
	
	$agent_system_access = $roles[0];
	if($agent_system_access){
		$agent_system_access_check = ' checked ';
		
	}else{
		$agent_system_access_check = '';
	}
	
	$agent_ussd_access = $roles[1];
	if($agent_ussd_access){
		$agent_ussd_access_check = ' checked ';
		
	}else{
		$agent_ussd_access_check = '';		
	}
	
	$agent_sms_reporting = $roles[2];
	if($agent_sms_reporting){
		$agent_sms_reporting_check = ' checked ';
		
	}else{
		$agent_sms_reporting_check = '';		
	}
	
	$agent_training_access = $roles[3];
	if($agent_training_access){
		$agent_training_access_check = ' checked ';
		
	}else{
		$agent_training_access_check = '';		
	}
	
	$this_loc_province_id = $this_agent_results['_province_id'];
	$this_district_id = $this_agent_results['_district_id'];
	$this_constituency_id = $this_agent_results['_constituency_id'];
	
}else{
	$default_color = '#aaa';
	$button_text = 'Create';
	$agent_name = 'Enter agent name here';
	$agent_nrc = 'Enter NRC here';
	$agent_sex_id = 0;
	$agent_gender_title = 'Select Gender';
	$agent_date = 0;
	
	$agent_email = 'Enter email address here';
	$agent_username = time();
	$agent_password = 'pipat';
	
	$job_title = 'Enter job title here';
	$agent_phone_numbers = 'Enter phone number here';
	
	
	$this_branch_id = $user_results['branch_id'];
	if(!$this_branch_id){
		$this_branch_title = 'Non-clustered';
		$this_branch_id = 0;
		
	}else{
		$user_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$this_branch_title = $this_branch_results['title'];
	}
	
	$this_agent_type_id = '';
	$agent_type_title = '<i>Unspecified</i>';
	
	
	$this_unit_id = $user_results['unit_id'];
	if(!$this_unit_id){
		$this_unit_title = 'Select unit';
		$this_unit_id = -1;
		
	}else{
		$user_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$this_unit_title = $this_unit_results['title'];
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
	
	$this_mother_facility_id = $user_results['mother_facility_id'];
	if(!$this_mother_facility_id){
		$this_mother_facility_title = 'All mother facilities';
		
	}else{
		$this_mother_facility = mysqli_query($connect,"select * from mother_facilities where id = $this_mother_facility_id")or die(mysqli_error($connect));
		$this_mother_facility_results = mysqli_fetch_array($this_mother_facility,MYSQLI_ASSOC);		
		$this_mother_facility_title = $this_mother_facility_results['title'];
	}
	
	$this_site_id = $user_results['site_id'];
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);		
		$this_site_title = $this_site_results['title'];
	}
	
	$this_loc_province_id = 0;
	$this_district_id = 0;
	$this_constituency_id = 0;
			
	$agent_ussd_access = 1;
	$agent_ussd_access_check = 'checked';
	
	$agent_sms_reporting = 1;
	$agent_sms_reporting_check = 'checked';
	
	$agent_system_access = 0;
	$agent_system_access_check = '';
	
	$agent_training_access = 1;
	$agent_training_access_check = 'checked';
}

if(!$this_loc_province_id){
	$this_loc_province_title = 'Unspecified';
	
}else{
	$this_loc_province = mysqli_query($connect,"select * from _provinces where id = $this_loc_province_id")or die(mysqli_error($connect));
	$this_loc_province_results = mysqli_fetch_array($this_loc_province,MYSQLI_ASSOC);		
	$this_loc_province_title = $this_loc_province_results['title'];		
}

if(!$this_district_id){
	$this_district_title = 'Unspecified';
	
}else{
	$this_district = mysqli_query($connect,"select * from _districts where id = $this_district_id")or die(mysqli_error($connect));
	$this_district_results = mysqli_fetch_array($this_district,MYSQLI_ASSOC);		
	$this_district_title = $this_district_results['title'];
}

if(!$this_constituency_id){
	$this_constituency_title = 'Unspecified';
	
}else{
	$this_constituency = mysqli_query($connect,"select * from _constituencies where id = $this_constituency_id")or die(mysqli_error($connect));
	$this_constituency_results = mysqli_fetch_array($this_constituency,MYSQLI_ASSOC);		
	$this_constituency_title = $this_constituency_results['title'];
}


?>
<div class="general_holder" id="agent_profile">

<div style="width:48%;height:auto;float:left;">
<div style="width:100%;height:20px;line-height:20px;text-align:center;float:left;background-color:#eef;margin-bottom:5px;">Basic details</div>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Names*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($agent_name);?>"  id="agent_name" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter agent name here'){this.value='';this.style.color='#000'}$('#new_agent_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($agent_name);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Mobile Numbers*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($agent_phone_numbers);?>"  id="agent_phone" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter phone number here'){this.value='';this.style.color='#000'}$('#phone_number_error').slideUp('fast');this.style.borderColor='#aaa';$('#new_agent_error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='<?php print($agent_phone_numbers);?>';this.style.color='<?php print($default_color);?>';}else{check_phone_number(<?php print($agent_date);?>);}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;margin-bottom:10px;" id="phone_number_error"></div>
<input type="hidden" id="phone_number_error_input" value="0">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">NRC Number*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($agent_nrc);?>"  id="agent_nrc" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter NRC here'){this.value='';this.style.color='#000'}$('#new_agent_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($agent_nrc);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>




<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Sex:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#sex_menu').toggle('fast');" id="active_sex" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($agent_gender_title);?></div>

			<div class="option_menu" id="sex_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			$gender = mysqli_query($connect,"select * from genders order by title")or die(mysqli_error($connect));
			
			for($g=0;$g<mysqli_num_rows($gender);$g++){
				$gender_results = mysqli_fetch_array($gender,MYSQLI_ASSOC);
				?>
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sex_menu').toggle('fast');$('#active_sex').html($(this).html());$('#agent_selected_sex').val(<?php print($gender_results['id']);?>);$('#new_agent_error_message').slideUp('fast');"><?php print($gender_results['title']);?></div>
				
				<?php
			}
			?>
					
			</div>
	</div>
	<input type="hidden" id="agent_selected_sex" value="<?php print($agent_sex_id);?>">
</div>
</div>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Email:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($agent_email);?>"  id="agent_email" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter email address here'){this.value='';this.style.color='#000'}$('#new_agent_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($agent_email);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">User Name*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:#000" value="<?php print($agent_username);?>"  id="agent_username" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='<?php print(time());?>';this.style.color='#000'}" onfocus="$('#new_agent_error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Password*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input <?php if(!$editing){?> type="password" <?php }else{?>type="text" <?php }?> style="width:100%;border:solid 1px #aaa;height:30px;color:#000" value="<?php print($agent_password);?>"  id="agent_password" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='pipat';}" onfocus="$('#new_agent_error_message').slideUp('fast');this.style.borderColor='#aaa';$('#agent_password').css('border-color','#aaa');"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Confirm Password*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input <?php if(!$editing){?> type="password" <?php }else{?>type="text" <?php }?>style="width:100%;border:solid 1px #aaa;height:30px;color:#000" value="<?php print($agent_password);?>"  id="agent_password_2" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='pipat';'}" onfocus="$('#new_agent_error_message').slideUp('fast');this.style.borderColor='#aaa';$('#agent_password').css('border-color','#aaa');$('#agent_password_2').css('border-color','#aaa');"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Job Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($job_title);?>"  id="agent_job_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter job title here'){this.value='';this.style.color='#000'}$('#new_agent_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($job_title);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>


</div>

<div style="width:48%;height:auto;float:right;">
<div style="width:100%;height:20px;line-height:20px;text-align:center;float:left;background-color:#ecbefb;margin-bottom:5px;cursor:pointer;" onclick="$('#organisational_location_holder').slideToggle('fast');$('#national_location_holder').slideToggle('fast');" onmouseover="this.style.backgroundColor='#f4dbfd'" onmouseout="this.style.backgroundColor='#ecbefb'">National Location</div>

<div style="width:100%;height:auto;float:left;display:none;" id="national_location_holder">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#agent_loc_province_menu').toggle('fast');" id="active_agent_loc_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_loc_province_title);?></div>

			<div class="option_menu" id="agent_loc_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_loc_province_menu').toggle('fast');$('#active_agent_loc_province').html($(this).html());$('#selected_agent_loc_province').val(0);fetch_menu_items('connect','provinces','_loc_province_id',0,'agent_loc_province',1,1,'connect-hubs-province_id-{id}-agent_hub-1-1|connect-sites-hub_id-{id}-agent_site-1-1');$('#new_agent_error_message').slideUp('fast');">Unspecified</div>
			
				<?php
				
					$loc_province_menu = mysqli_query($connect,"select * from _provinces where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($loc_province_menu);$r++){
						$loc_province_menu_results = mysqli_fetch_array($loc_province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_loc_province_menu').toggle('fast');$('#active_agent_loc_province').html($(this).html());$('#selected_agent_loc_province').val(<?php print($loc_province_menu_results['id']);?>);fetch_menu_items('connect','_districts','province_id',<?php print($loc_province_menu_results['id']);?>,'agent_district',1,1,'connect-_constituencies-district_id-{id}-agent_constituency-1-1');$('#new_agent_error_message').slideUp('fast');"><?php print($loc_province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_agent_loc_province" value="<?php print($this_loc_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">District:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#agent_district_menu').toggle('fast');" id="active_agent_district" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_district_title);?></div>

			<div class="option_menu" id="agent_district_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$district_menu = mysqli_query($connect,"select * from _districts where province_id = $this_loc_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($district_menu);$p++){
						$district_menu_results = mysqli_fetch_array($district_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_district_menu').toggle('fast');$('#active_agent_district').html($(this).html());$('#selected_agent_district').val(<?php print($district_menu_results['id']);?>);fetch_menu_items('connect','_constituencies','district_id',<?php print($district_menu_results['id']);?>,'agent_constituency',1,1,'');$('#new_agent_error_message').slideUp('fast');"><?php print($district_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_agent_district" value="<?php print($this_district_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Constituency:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#agent_constituency_menu').toggle('fast');" id="active_agent_constituency" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_constituency_title);?></div>

		<div class="option_menu" id="agent_constituency_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$constituency_menu = mysqli_query($connect,"select * from _constituencies where district_id = $this_district_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($constituency_menu);$h++){
					$constituency_menu_results = mysqli_fetch_array($constituency_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_constituency_menu').toggle('fast');$('#active_agent_constituency').html($(this).html());$('#selected_agent_constituency').val(<?php print($constituency_menu_results['id']);?>);fetch_menu_items('connect','sites','constituency_id',<?php print($constituency_menu_results['id']);?>,'agent_site',1,1,'');$('#new_agent_error_message').slideUp('fast');"><?php print($constituency_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_agent_constituency" value="<?php print($this_constituency_id);?>">
</div>
</div>
</div>

<div style="width:100%;cursor:pointer;height:20px;line-height:20px;text-align:center;float:left;background-color:#cfc;margin-bottom:5px;" onclick="$('#organisational_location_holder').slideToggle('fast');$('#national_location_holder').slideToggle('fast');" onmouseover="this.style.backgroundColor='#dfd'" onmouseout="this.style.backgroundColor='#cfc'">Organisational Location</div>
<div style="width:100%;height:auto;float:left;" id="organisational_location_holder">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Cluster:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#agent_branch_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify this option');<?php }?>" id="active_agent_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_branch_title);?></div>

			<div class="option_menu" id="agent_branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_branch_menu').toggle('fast');$('#active_agent_branch').html($(this).html());$('#selected_agent_branch').val(0);$('#new_agent_error_message').slideUp('fast');">Non-clustered</div>
			
			
				<?php
				
					$branch_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($branch_menu);$u++){
						$branch_menu_results = mysqli_fetch_array($branch_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_branch_menu').toggle('fast');$('#active_agent_branch').html($(this).html());$('#selected_agent_branch').val(<?php print($branch_menu_results['id']);?>);$('#new_agent_error_message').slideUp('fast');"><?php print($branch_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_agent_branch" value="<?php print($this_branch_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Agent groups:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:15px;border:solid 1px #ccc;">
<?php
$agent_types = mysqli_query($connect,"select * from agent_types where company_id = $company_id")or die(mysqli_error($connect));

for($a=0;$a<mysqli_num_rows($agent_types);$a++){
	$agent_type_results = mysqli_fetch_array($agent_types,MYSQLI_ASSOC);
	
	?>
	<input type="checkbox" id="agent_type_<?php print($agent_type_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($agent_type_results['id']);?>,'selected_agent_type');}else{remove_from_selection(<?php print($agent_type_results['id']);?>,'selected_agent_type')}" <?php if(check_item_in_list($agent_type_results['id'],$this_agent_type_id,0,',')){print(' checked ');}?> > <label for="agent_type_<?php print($agent_type_results['id']);?>"><?php print($agent_type_results['title']);?></label><br>
	<?php
}
?>
<input type="hidden" id="selected_agent_type" value="<?php print($this_agent_type_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Unit:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?>$('#agent_unit_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify unit settings for agents');<?php }?>" id="active_agent_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>

			<div class="option_menu" id="agent_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_unit_menu').toggle('fast');$('#active_agent_unit').html($(this).html());$('#selected_agent_unit').val(0);$('#new_agent_error_message').slideUp('fast');">All units</div>
			
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_unit_menu').toggle('fast');$('#active_agent_unit').html($(this).html());$('#selected_agent_unit').val(<?php print($unit_menu_results['id']);?>);$('#new_agent_error_message').slideUp('fast');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_agent_unit" value="<?php print($this_unit_id);?>">
</div>
</div>



<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Region:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#agent_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for agents');<?php }?>" id="active_agent_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="agent_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_region_menu').toggle('fast');$('#active_agent_region').html($(this).html());$('#selected_agent_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'agent_province',1,1,'connect-hubs-province_id-{id}-agent_hub-1-1|connect-sites-hub_id-{id}-agent_site-1-1');$('#new_agent_error_message').slideUp('fast');">All Regions</div>
			
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_region_menu').toggle('fast');$('#active_agent_region').html($(this).html());$('#selected_agent_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'agent_province',1,1,'connect-hubs-province_id-{id}-agent_hub-1-1|connect-sites-hub_id-{id}-agent_site-1-1');$('#new_agent_error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_agent_region" value="<?php print($this_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#agent_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for agents');<?php }?>" id="active_agent_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="agent_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_province_menu').toggle('fast');$('#active_agent_province').html($(this).html());$('#selected_agent_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'agent_hub',1,1,'connect-sites-hub_id-{id}-agent_site-1-1');$('#new_agent_error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_agent_province" value="<?php print($this_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#agent_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for agents');<?php }?>" id="active_agent_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="agent_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_hub_menu').toggle('fast');$('#active_agent_hub').html($(this).html());$('#selected_agent_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'agent_site',1,1,'');$('#new_agent_error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_agent_hub" value="<?php print($this_hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;display:none;">
	<div style="width:100px;height:30px;line-height:30px;float:left;">Mother facility:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['mother_facility_id']){?>$('#agent_mother_facility_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify this option');<?php }?>" id="active_agent_mother_facility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_mother_facility_title);?></div>
		
			<div class="option_menu" id="agent_mother_facility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
					$mother_facility_menu = mysqli_query($connect,"select * from mother_facilities where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));
					
					for($m=0;$m<mysqli_num_rows($mother_facility_menu);$m++){
						$mother_facility_menu_results = mysqli_fetch_array($mother_facility_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_mother_facility_menu').toggle('fast');$('#active_agent_mother_facility').html($(this).html());$('#selected_agent_mother_facility').val(<?php print($mother_facility_menu_results['id']);?>);fetch_menu_items('connect','sites','mother_facility_id',<?php print($mother_facility_menu_results['id']);?>,'agent_site',1,1,'');$('#new_agent_error_message').slideUp('fast');"><?php print($mother_facility_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
		</div>
		<input type="hidden" id="selected_agent_mother_facility" value="<?php print($this_mother_facility_id);?>">
	</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#agent_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify site settings for agents');<?php }?>" id="active_agent_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="agent_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_site_menu').toggle('fast');$('#active_agent_site').html($(this).html());$('#selected_agent_site').val(<?php print($site_menu_results['id']);?>);$('#new_agent_error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_agent_site" value="<?php print($this_site_id);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;background-color:#fdd;">Access Restrictions</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<input type="checkbox" <?php print($agent_ussd_access_check);?> id="agent_ussd_access_checkbox" onchange="if(this.checked){$('#agent_ussd_access_input').val(1);}else{$('#agent_ussd_access_input').val(0);}" <?php if(!$editing){?> disabled<?php }?> <?php print($agent_ussd_access_check);?>> <label for="agent_ussd_access_checkbox">Allow USSD system access</label><br>

<input type="checkbox" <?php print($agent_sms_reporting_check);?> id="allie_sms_reporting_checkbox" onchange="if(this.checked){$('#agent_sms_reporting_input').val(1);}else{$('#agent_sms_reporting_input').val(0);}" <?php if(!$editing){?> disabled<?php }?> <?php print($agent_sms_reporting_check);?>> <label for="allie_sms_reporting_checkbox">Allow SMS reporting</label><br>

<input type="checkbox" <?php print($agent_system_access_check);?> id="allow_pipat_system_access" onchange="if(this.checked){$('#agent_system_access_input').val(1);}else{$('#agent_system_access_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="allow_pipat_system_access" <?php print($agent_system_access_check);?>>Allow PIPAT system access</label><br>

<input type="checkbox" <?php print($agent_training_access_check);?> id="allow_access_to_training_checkbox" onchange="if(this.checked){$('#agent_training_access_input').val(1);}else{$('#agent_training_access_input').val(0);}" <?php if(!$editing){?> disabled<?php }?>> <label for="allow_access_to_training_checkbox" <?php print($agent_training_access_check);?>>Allow access to PIPAT Trainer</label><br>


	<input type="hidden" id="agent_ussd_access_input" value="<?php print($agent_ussd_access);?>">
	<input type="hidden" id="agent_sms_reporting_input" value="<?php print($agent_sms_reporting);?>">
	<input type="hidden" id="agent_system_access_input" value="<?php print($agent_system_access);?>">
	<input type="hidden" id="agent_training_access_input" value="<?php print($agent_training_access);?>">

</div>
</div>
</div>
<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="new_agent_error_message"></div>

<?php if($editing){?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="agent_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_agent_button" onclick="update_or_create_agent(<?php print($agent_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($agent_id){
	if($area_id){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_agent_button" onclick="disable_agent(<?php print($agent_id);?>);" title="Click to disable the account">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="enable_agent_button" onclick="enable_agent(<?php print($agent_id);?>);" title="Clik to activate the account">Enable</div>
	
	<script>
		check_phone_number(<?php print($agent_date);?>);
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

<?php
if($agent_id){
	?>
<div class="general_holder" id="agent_entries" style="display:none;">
	<div style="width:750px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
	<div style="width:auto;height:auto;float:left;" id="validation_holder">
		<div style="width:70px;height:30px;line-height:30px;float:left;">Validation:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#validation_menu').toggle('fast');" id="active_validation" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All entries</div>

		<div class="option_menu" id="validation_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#validation_menu').toggle('fast');$('#active_validation').html($(this).html());$('#selected_validation').val(-1);">All entries</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#validation_menu').toggle('fast');$('#active_validation').html($(this).html());$('#selected_validation').val(1);">Validated</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#validation_menu').toggle('fast');$('#active_validation').html($(this).html());$('#selected_validation').val(0);">Not validated</div>
			
		</div>
		</div>
		<input type="hidden" id="selected_validation" value="-1">
	</div>
	
	
		<div style="width:120px;height:30px;line-height:30px;float:left;">From (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_from" style="width:100%;height:30px;" value="<?php print(date('m/01/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		<div style="width:105px;height:30px;line-height:30px;float:left;margin-left:10px;">To (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_to" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:right;;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="$('#last_entry_id').val(0);fetch_agent_entries(<?php print($this_agent_results['id']);?>);" title="Click to fetch report with specified options">Fetch</div>
	</div>	
	
	<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="detailed_list_status_bar"><strong>Records found:</strong></div>

</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><div style="width:90px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:55px;height:20px;float:left;margin-right:3px;">Time</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:130px;height:20px;float:left;margin-right:3px;">Site</div><div style="width:120px;height:20px;float:left;margin-right:3px;">Agent</div><div style="width:80px;height:20px;float:left;margin-right:3px;"  onmouseover="this.style.backgroundColor
='#ddf';" onmouseout="this.style.backgroundColor
='#eef';"><div style="width:auto;float:left;" id="results_filter_unit" onclick="$('#filter_unit_holder').toggle('fast');$('#filter_unit_menu').toggle('fast');">Unit</div> <div style="width:15px;height:15px;float:left;display:none;" id="results_filter_unit_icon"><img src="imgs/filter_icon.png" style="width:15px;height:15px;margin-top:2px;margin-left:2px;"></div>

<div style="width:auto;height:auto;float:left;display:none;" id="filter_unit_holder">
	<div class="option_menu" id="filter_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;margin-left:-23px;margin-top:21px;">
	
	</div>
			<input type="hidden" id="selected_results_filter_unit" value="0">
	</div>



</div><div style="width:115px;height:20px;float:left;margin-right:3px;">Activity</div><div style="width:50px;height:20px;float:left;margin-right:3px;">Number</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Validated by</div><div style="width:80px;height:20px;float:left;margin-right:3px;"></div></div>
<input type="hidden" id="last_entry_id" value="0">
<input type="hidden" id="editing_active" value="0">
<input type="hidden" id="days_worked" value="0">
<input id="total_value" type="hidden" value="0">
<input id="total_records" type="hidden" value="0">
<input id="report_live_view" type="hidden" value="1">
<div class="general_holder" id="detailed_list_data_holder">

</div>
<script>
$( function() {
	$( "#date_from" ).datepicker();
	$( "#date_to" ).datepicker();
} );
</script>
</div>

<div class="general_holder" id="agent_targets">


</div>

<?php
}
?>